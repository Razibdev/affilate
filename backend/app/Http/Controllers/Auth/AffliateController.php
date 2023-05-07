<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site_setting;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Support\Google2FAAuthenticator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Affliate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
class AffliateController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:affliate')->except('logout');
    }

    public function showLoginForm()
    {
        if (auth()->guard('affliate')->check()) {
            return redirect()->route('beforelogin');
        }

        return view('Auth.affiliate.affliate-login');
    }


    public function login(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

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
        if (Auth::guard('affliate')->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            $response = [
                'status' => true,
                'message' => 'Login successfully',
                'data' => []
            ];
        }

        // if unsuccessful
        return response()->json($response);
    }
    public function showRegisterForm()
    {
        return view('auth.affliate-register');
    }
    public function forgot_password()
    {
        return view('Auth/affiliate/reset_password');
    }
    public function reset_password_link(Request $request,$token)
    {
        try {
            $password = decrypt($token);
        } catch (DecryptException $e) {
            return abort(404);
        }
        // $token .= '55';
         $expiry_time = explode('##', $password);
        if ($expiry_time[1] < time()) {
            return redirect()->route('manager.login')->with('error',  'Sorry, your link has been expired. please try again');
        }
        return view('Auth/affiliate/reset',compact('token'));
    }
    public function forgot_password_email(Request $request)
    {
         $affliate = Affliate::where('email', $request->email)->first();
        if (!empty($affliate)) {
            $token = md5(microtime()) . '##' . strtotime('+ 5 minutes', time());
            $affliate->password = $token;
            $smtp_server = Site_setting::first();
            $password_reset_link = route('manager.rest-password-link', encrypt($token));
            $data = [
                'name' => $affliate->name,
                'email' => $affliate->email,
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
                $affliate->save();
                return redirect()->back()->with('success', 'mail sent successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Mail could not send please cheack smtp');
            }
            
        }else{
            return redirect()->back()->with('error', 'Email is wrong  please check your email');
        }
    }

    public function reset_password(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8',

        ]);
        try {
            $password = decrypt($request->token);
        } catch (DecryptException $e) {
            return abort(404);
        }
        $affliate = Affliate::where('password', $password)->first();
        // $token .= '55';
        $affliate->password= bcrypt($request->password);
        $expiry_time = explode('##', $password);
        if ($expiry_time[1] < time()) {
            return redirect()->route('manager.login')->with('error',  'Sorry, your link has been expired. please try again');
        }
        if($request->password!==$request->password_confirmation){
            return redirect()->back()->with('error',  'Sorry,Your password is not match ');
        }
        if($affliate->save()){
            return redirect()->route('manager.login')->with('success',  'Your password updated successfully');
        }

    }
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:affliates|email',
            'password' => 'required|min:8',

        ]);
        $user = Affliate::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);
        $verifyUser = VerifyAffliate::create([
            'affliate_id' => $user->id,
            'token' => sha1(time())
        ]);
        $smtp_server = SiteSetting::find(1);
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

        \Mail::to($user->email)->send(new VerifyMail($user));
        return $user;
    }
    public function verifyUser($token)
    {
        $verifyUser = VerifyAffliate::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->affliate;
            if (!$user->verified) {
                $verifyUser->affliate->verified = 1;
                $verifyUser->affliate->save();
                $status = "Your e-mail is verified. Wait For Admin To Verify.";
            } else {
                $status = "Your e-mail is already verified.  Wait For Admin To Verify.";
            }
        } else {
            return redirect('/manager/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/manager/login')->with('status', $status);
    }

    public function logout()
    {
        Auth::guard('affliate')->logout();
        return redirect('/manager/login')->with('status', 'User has been logged out!');
    }
}
