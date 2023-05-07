<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Support\Google2FAAuthenticator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Publisher;
use App\Models\Login_history;
use App\Mail\VerifyPublisherMail;
use App\Helpers\UserSystemInfoHelper;
use Illuminate\Support\Facades\Mail;
use App\Models\Countrie;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use App\Models\Site_category;
use App\Models\Verify_publisher;
use App\Models\Site_setting;
use Stevebauman\Location\Facades\Location;

class PublisherController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        Auth::guard('admin')->logout();
    }
    public function showLoginForm()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = Location::get($ip);

        $getbrowser = UserSystemInfoHelper::get_browsers();
        $site_data = Site_setting::first();
        $getos = UserSystemInfoHelper::get_os();

        if (auth()->guard('publisher')->check()) {
            return redirect()->route('publisher.dashboard');
        }
        return view('Auth/publisher/login', compact('data', 'getbrowser', 'getos', 'site_data'));
    }
    public function Showdashboard()
    {

        return view('publisher/dashboard');
    }

    public function login(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // User::where('email',$request->email)->update(['password'=>md5('1234567890')]);
        // return $request->all();
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];

        // if (Hash::check('1234567890', bcrypt($request->password))) {
        //     return 'match!!';
        // } else {
        //     return 'not match!!';
        // }
        $pub_check = Publisher::where('email', $request->email)->where('password', bcrypt($request->password))->first();
        if (isset($pub_check)) {
            $password = $pub_check->password_show;
        } else {
            $password = $request->password;
        }
        $pub_check = Publisher::where('email', $request->email)->first();
        if (empty($pub_check)) {
            $response = [
                'status' => false,
                'message' => 'There is not any account exist with this Email',
                // 'data' =>route('publisher.varify_publisher')
            ];
            return response()->json($response);
        } else if ($pub_check->verified == 0) {
            $response = [
                'status' => false,
                'message' => 'Your email is not verified please verified your mail.',
                // 'data' =>route('publisher.varify_publisher')
            ];
            return response()->json($response);
        }

        // Attempt to log the user in
        if (Auth::guard('publisher')->attempt(['email' => $request->email, 'password' => $request->password])) {

            $publisher = Auth::guard('publisher')->user();


            if ($publisher->status === 'banned') {
                Auth::guard('publisher')->logout();
                $response = [
                    'status' => false,
                    'message' => 'You can not access your account because your account is banned.',
                    'data' => []
                ];
                return response()->json($response);
            }


            $ip = $_SERVER['REMOTE_ADDR'];
            $ipdata = Location::get($ip);
            
            Login_history::create(
                [
                    'publisher_id' => $publisher->id,
                    'device' => $request->device,
                    'browser' => $request->browser,
                    'ip_address' => $ip,
                    'city' => $ipdata->cityName,
                    'country' => $ipdata->countryName,
                    'result' => 1,
                    'session_id' => session()->getId(),
                    'is_active' => '1'
                ]
            );
            $response = [
                'status' => true,
                'message' => 'You are login successfully',
                'data' => []
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Email And password not match',
                'data' => []
            ];
            return response()->json($response);
        }

        return response()->json($response);
    }
    public function varify_publisher($email)
    {
        $user = Publisher::Where('email', $email)->first();;
        $verifyUser = Verify_publisher::create([
            'publisher_id' => $user->id,
            'token' => sha1(time())
        ]);
        try {
            $smtp_server = Site_setting::find(1);
            $config = array(
                'driver'     => 'smtp',
                'host'       => $smtp_server->smtp_host,
                'port'       => $smtp_server->smtp_port,
                'username'   => $smtp_server->smtp_user,
                'password'   => $smtp_server->smtp_password,
                'encryption' => $smtp_server->smtp_enc,
                'from'       => array('address' => $smtp_server->from_email, 'name' => $smtp_server->from_name),
                'sendmail'   => '/usr/sbin/sendmail -bs',
                'pretend'    => false,
            );
            Config::set('mail', $config);


            Mail::to($user->email)->send(new VerifyPublisherMail($user));
            $response['status'] = true;
            $response['message'] = 'Congratulations!! you have successfully registered';
        } catch (\Exception $e) {
            $response['status'] = true;
            $response['message'] = 'Congratulations!! you have successfully registered but email is not send';
        }


        return response()->json($response);
    }
    public function showRegisterForm()
    {
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $site_category_list = Site_category::select('site_category_name')->get()->all();
        $site = Site_setting::first();
        return view('Auth/publisher/register', compact('country_list', 'site_category_list', 'site'));
    }

    public function account_information(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        if ($request->account_type == 'Individual') {
            $this->validate($request, [
                'account_type' => 'required',
                'publisher_type' => 'required',
            ]);
        } else if ($request->account_type == 'Company') {
            $this->validate($request, [
                'account_type' => 'required',
                'publisher_type' => 'required',
                'company_name' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'account_type' => 'required',
            ]);
        }
        $response = [
            'status' => true,
            'message' => "Your Account information Is correct",
            'data' => []
        ];

        return response()->json($response);
    }

    public function validate_website_information(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $this->validate($request, [
            'website_url' => 'required',
            'monthly_traffic' => 'required',
            'category' => 'required',
            'additional_information' => 'required',
            'hereby' => 'required'

        ]);

        $response = [
            'status' => true,
            'message' => "Your Wbsite information Is correct",
            'data' => []
        ];

        return response()->json($response);
    }
    public function validate_addistional_information(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:publishers,email',
            'password' => 'required|min:8',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'region' => 'required',
            'zip' => 'required',
            'skype' => 'required',
            'phone' => 'required|min:10|max:12',
            'phone_code' => 'required'
        ]);

        $response = [
            'status' => true,
            'message' => "Your Additional information Is correct",
            'data' => []
        ];

        return response()->json($response);
    }
    public function register(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'region' => 'required',
            'zip' => 'required',
            'skype' => 'required',
            'phone' => 'required',
            'phone_code' => 'required',
            'account_type' => 'required',
            'publisher_type' => 'required',
            'website_url' => 'required',
            'monthly_traffic' => 'required',
            'category' => 'required',
            'additional_information' => 'required',
            'hereby' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:publishers,email'

        ]);

        $response = [
            'status' => false,
            'message' => "Sorry, Something went wrong, please try again.",
            'data' => []
        ];
        $user = Publisher::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
        $site = Site_setting::first();
        if (isset($request->affliate) && !empty($request->affliate)) {
            $affliate_manager = $request->affliate;
        } else {
            $affliate_manager = $site->default_affliate_manager;
        }
        $user_data = [
            'name' => $request->name,
            'affliate_manager_id' => $affliate_manager,
            'payment_terms' => $site->default_payment_terms,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'account_type' => $request->account_type,
            'city' => $request->city,
            'total_earnings' => '0',
            'balance' => '0',
            'skype' => $request->skype,
            'phone_code' => $request->phone_code,
            'country' => $request->country,
            'regions' => $request->region,
            'postal_code' => $request->zip,
            'website_url' => $request->website_url,
            'monthly_traffic' => $request->monthly_traffic,
            'category' => $request->category,
            'phone' => $request->phone,
            'additional_information' => $request->additional_information,
            'hereby' => $request->hereby,
            'expert_mode' => $request->publisher_type,
            'status' => 'Inactive',
        ];
        if ($Publisher = Publisher::where('id', $user->id)->update($user_data)) {
            $verifyUser = Verify_publisher::create([
                'publisher_id' => $user->id,
                'token' => sha1(time())
            ]);
            try {
                $smtp_server = Site_setting::find(1);
                $config = array(
                    'driver'     => 'smtp',
                    'host'       => $smtp_server->smtp_host,
                    'port'       => $smtp_server->smtp_port,
                    'username'   => $smtp_server->smtp_user,
                    'password'   => $smtp_server->smtp_password,
                    'encryption' => $smtp_server->smtp_enc,
                    'from'       => array('address' => $smtp_server->from_email, 'name' => $smtp_server->from_name),
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);

                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id,
                    'subject' => $smtp_server->site_name . ' - Publisher register.'
                ];

                // Mail::to($user->email)->send(new VerifyPublisherMail($user));


                try {
                    Mail::send('emails.verifyPublisher', ['publisher' => $data,'setting'=>$smtp_server], function ($message) use ($data) {
                        $smtp_server = Site_setting::first();
                        $message->from($smtp_server->from_email, $smtp_server->from_name);
    
                        $message->to($data['email'], $data['name'])->subject($data['subject']);
                    });
                    // $publisher->save();
                    $response['status'] = true;
                    $response['message'] = 'Congratulations!! you have successfully registered';
                    // return redirect()->back()->with('success', 'mail sent successfully');
                } catch (\Exception $e) {
                    // return redirect()->back()->with('error', 'Mail could not send please cheack smtp');
                    $response['status'] = true;
                    $response['message'] = 'Congratulations!! you have successfully registered but email is not send';
                }

            } catch (\Exception $e) {
                $response['status'] = true;
                $response['message'] = 'Congratulations!! you have successfully registered but email is not send';
            }
            // $response['status'] = true;
            // $response['message'] = 'Congratulations!! you have successfully registered';
        }
        return response()->json($response);
    }

    public function logout(Request $request)
    {

        // $authenticator = app(Google2FAAuthenticator::class)->boot($request);
        $login = Login_history::where('session_id', session()->getId())->update(['is_active' => 0]);
        Auth::guard('publisher')->logout();




        return redirect('/publisher')->with('status', 'User has been logged out!');
    }
    public function verifyUser($token)
    {
        $verifyUser = Verify_publisher::where('token', $token)->first();

        $site = Site_setting::first();
        $status = 'Inactive';

        $message = "Your e-mail is verified.Wait For Admin To Verify";
        if ($site->auto_signup == 1) {
            $status = 'Active';
            $message = "Your e-mail is verified.You can Login In";
        }
        if (isset($verifyUser)) {

            $user_id = $verifyUser->publisher_id;
            $user = Publisher::where('id', $user_id)->first();
            if ($user->verified == 1) {
                $status = "Your e-mail is already verified.";
            } else {
                if ($verifyUser->token == $token) {
                    Publisher::where('id', $user_id)->update(['verified' => 1, 'status' => $status]);

                    $status = $message;
                }
            }
        } else {
            return redirect('/publisher/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/publisher/login')->with('status', $status);
    }
    public function forgot_password()
    {
        return view('Auth/publisher/reset_password');
    }
    public function reset_password_link(Request $request, $token)
    {
        try {
            $password = decrypt($token);
        } catch (DecryptException $e) {
            return abort(404);
        }
        // $token .= '55';
        $expiry_time = explode('##', $password);
        if ($expiry_time[1] < time()) {
            return redirect()->route('publisher.login')->with('error',  'Sorry, your link has been expired. please try again');
        }
        return view('Auth/publisher/reset', compact('token'));
    }
    public function forgot_password_email(Request $request)
    {
        $publisher = Publisher::where('email', $request->email)->first();
        if (!empty($publisher)) {
            $token = md5(microtime()) . '##' . strtotime('+ 5 minutes', time());
            $publisher->password = $token;
            $smtp_server = Site_setting::first();
            $password_reset_link = route('publisher.rest-password-link', encrypt($token));
            $data = [
                'name' => $publisher->name,
                'email' => $publisher->email,
                'password_reset_link' => $password_reset_link,
                'subject' => $smtp_server->site_name . ' - Instructions for password reset.'
            ];

            $config = array(
                'driver'     => 'smtp',
                'host'       => $smtp_server->smtp_host,
                'port'       => $smtp_server->smtp_port,
                'username'   => $smtp_server->smtp_user,
                'password'   => $smtp_server->smtp_password,
                'encryption' => $smtp_server->smtp_enc,
                'from'       => array('address' => $smtp_server->from_email, 'name' => $smtp_server->from_name),
                'sendmail'   => '/usr/sbin/sendmail -bs',
                'pretend'    => false,
            );
            Config::set('mail', $config);
            try {
                Mail::send('emails.passwordreset', ['data' => $data,'setting'=>$smtp_server], function ($message) use ($data) {
                    $smtp_server = Site_setting::first();
                    $message->from($smtp_server->from_email, $smtp_server->from_name);

                    $message->to($data['email'], $data['name'])->subject($data['subject']);
                });
                $publisher->save();
                return redirect()->back()->with('success', 'mail sent successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Mail could not send please cheack smtp');
            }
        } else {
            return redirect()->back()->with('error', 'Email is wrong  please check your email');
        }
    }

    public function reset_password(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8',

        ]);
        try {
            $password = decrypt($request->token);
        } catch (DecryptException $e) {
            return abort(404);
        }
        $publisher = Publisher::where('password', $password)->first();
        // $token .= '55';
        $publisher->password = bcrypt($request->password);
        $expiry_time = explode('##', $password);
        if ($expiry_time[1] < time()) {
            return redirect()->route('publisher.login')->with('error',  'Sorry, your link has been expired. please try again');
        }
        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()->with('error',  'Sorry,Your password is not match ');
        }
        if ($publisher->save()) {
            return redirect()->route('publisher.login')->with('success',  'Your password updated successfully');
        }
    }
}
