<?php

namespace App\Http\Controllers\Admin;

use App\Support\Google2FAAuthenticator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Publisher;
use App\Models\Login_history;
use App\Models\Countrie;
use App\Models\Site_category;
use App\Models\Affliate;
use App\Models\Publisher_payment_method;
use App\Models\Verify_publisher;
use App\Models\Site_setting;
use Illuminate\Support\Facades\Validator;
class PublisherController extends Controller
{
    public function ManagePublisher()
    {
        return view('admin.publisher.all_publisher');
    }
    public function ShowPublisher(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Publisher::select('*')->where('status', '<>', 'banned');
        // $pages_query->addSelect(DB::raw("SUBSTRING('description', 0, 1000) as dsd"));
        //search
        if (!empty($search)) {
            $pages_query->where('name', 'like', '%' . $search . '%');
            $pages_query->orWhere('email', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $pages_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $pages_query->orderBy('name', $sort_direction);
        } elseif ($sort_by == 2) {
            $pages_query->orderBy('email', $sort_direction);
        } elseif ($sort_by == 3) {
            $pages_query->orderBy('status', $sort_direction);
        }

        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->get();
        $pages->each->append('action');
        $pages->each->append('managername');
        // $pages->each->append('sponsor');

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_pages,
            'recordsFiltered' => $total_pages,
            'data' => $pages,
        );
        // print_r($data);
        // print_r(mb_detect_order());
        // die;
        return response()->json($data);

        // return response()->json($data);
    }
    public function ViewPublisher($id)
    {
        $data = Publisher::where('id', $id)->first();
        $data->append('managername');
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $site_category_list = Site_category::select('site_category_name')->get()->all();
        $Affliate = Affliate::select('id', 'name')->get()->all();
        $payment = Publisher_payment_method::where('publisher_id', $id)->get();
        return view('admin.publisher.edit-publisher', compact('data', 'payment', 'country_list', 'site_category_list', 'Affliate'));
    }
    public function shiow_publisher_details($id)
    {
        $data = Publisher::where('id', $id)->first();
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $site_category_list = Site_category::select('site_category_name')->get()->all();
        $Affliate = Affliate::select('id', 'name')->get()->all();
        $payment = Publisher_payment_method::where('publisher_id', $id)->get();
        return view('admin.publisher.view-publisher', compact('data', 'payment','country_list', 'site_category_list', 'Affliate'));
    }
    public function add_new_publisher()
    {

        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $site_category_list = Site_category::select('site_category_name')->get()->all();
        $Affliate = Affliate::select('id', 'name')->get()->all();
        return view('admin.publisher.new-publisher', compact('country_list', 'site_category_list', 'Affliate'));
    }

    
    public function DeletePublisher(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $publisher_data = Publisher::where('id', $request->id)->first();
        if (!empty($publisher_data)) {
            @unlink('uploads/' . $publisher_data->publisher_image);
        }
        if (Publisher::where('id', $publisher_data->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Publisher deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertPublisher(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];



        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'countries' => 'required',
            'city' => 'required',
            'region' => 'required',
            'status' => 'required',
            'payment_terms' => 'required',
            'affliate_manager' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:publishers,email'

        ]);
        $site = Site_setting::first();

        if ($request->password != $request->confirm_password) {
            $request->session()->flash('success', 'Password Not Match');
            return redirect()->back()->with('success', 'Password Not Match');
        }
        $photo = '';
        if ($request->photo != '') {
            $validator = Validator::make($request->all(), [
                'photo' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                // die('aaaaaa');
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            $photo = mt_rand(1, 1000) . '' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads', $photo);
        }
        $publisher_last = Publisher::orderBy('id', 'desc')->first();

        $data = array(
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'country' => $request->countries,
            'address' => $request->address,
            'city' => $request->city,
            'regions' => $request->regions,
            'status' => $request->status,
            'payment_terms' => $request->payment_terms,
            'affliate_manager_id' => $request->affliate_manager,
            'publisher_image' => $photo,
            'verified' => '1',
            'expert_mode' => '1',
        );

        if (Publisher::create($data)) {
            $response = [
                'status' => true,
                'message' => 'New publisher created successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function BanPublisher(Request $request)
    {
        // $id = $id;
        // $publisher = DB::table('publishers')->where('id', $id)->first();
        // DB::table('publishers')->where('id', $id)->update(['status' => 'banned']);
        // $data = array('message' => 'Your Account has been Banned by Admin', 'subject' => 'Account Banned', 'email' => $publisher->email, 'name' => $publisher->name);

        // $smtp_server = SiteSetting::find(1);
        // $config = array(
        //     'driver'     => 'smtp',
        //     'host'       => $smtp_server->smtp_host,
        //     'port'       => $smtp_server->smtp_port,
        //     'username'   => $smtp_server->smtp_user,
        //     'password'   => $smtp_server->smtp_password,
        //     'encryption' => $smtp_server->smtp_enc,
        //     'from'       => array('address' => $smtp_server->from_email, 'name' => $smtp_server->from_name),
        //     'sendmail'   => '/usr/sbin/sendmail -bs',
        //     'pretend'    => false,
        // );
        // Config::set('mail', $config);

        // Mail::send('emails.sendmailadmin', ['data' => $data], function ($message) use ($data) {
        //     $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_OTHER_NAME'));
        //     $message->to($data['email'], $data['name'])->subject($data['subject']);
        // });
        // return redirect()->back()->with('success', 'User Banned Successfully');
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Publisher::where('id', $request->id)->update(['status' => 'banned'])) {
            $response = [
                'status' => true,
                'message' => 'Publisher Ban successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }




    public function UpdatePublisher(Request $request)
    {

        $imageName = '';
        if ($request->photo1 != '') {
            $validator = Validator::make($request->all(), [
                'photo1' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                // die('aaaaaa');
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }
            @unlink('uploads/' . $request->hidden_img);
            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('photo1')->getClientOriginalExtension();
            $request->file('photo1')->move('uploads', $imageName);
        } else {
            $imageName = $request->hidden_img;
        }

    

        $data = array(
            'name' => $request->name,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'address' => $request->address,
            'regions' => $request->region,
            'city' => $request->city,
            'postal_code' => $request->zip,
            'skype' => $request->skype,
            'website_url' => $request->website_url,
            'monthly_traffic' => $request->monthly_traffic,
            'payment_terms' => $request->payment_terms,
            'category' => $request->category,
            'additional_information' => $request->additional_information,
            'status' => $request->status,
            'email' => $request->email,
            'country' => $request->countries,
            'affliate_manager_id' => $request->affliate_manager,
            'publisher_image' => $imageName
        );

        Publisher::where('id', $request->id)->update($data);
        return redirect()->back()->with('success', 'Publisher Updated Successfully');
    }

    public function login(Request $request, $email)
    {

        If(!empty(Auth::guard('admin')->user()->name)){
        $user = Publisher::where('email', $email)->first();

        Auth::guard('publisher')->login($user);
        // Attempt to log the user in
        // $authenticator = app(Google2FAAuthenticator::class)->boot($request);

        // $authenticator->login();
        return redirect('publisher/dashboard');
        }
        // return redirect()->back()->with('success', 'Error Occured');
    }
    public function PublisherApprovalRequest()
    {
        return view('admin.publisher.PublisherApprovalRequest');
    }

    public function ShowPublisherApproval(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Publisher::select('*')->where('status', 'Inactive');
        // $pages_query->addSelect(DB::raw("SUBSTRING('description', 0, 1000) as dsd"));
        //search
        if (!empty($search)) {
            $pages_query->where('name', 'like', '%' . $search . '%');
            $pages_query->orWhere('email', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $pages_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $pages_query->orderBy('name', $sort_direction);
        } elseif ($sort_by == 2) {
            $pages_query->orderBy('email', $sort_direction);
        } elseif ($sort_by == 3) {
            $pages_query->orderBy('status', $sort_direction);
        }

        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->get();
        $pages->each->append('action2');
        $pages->each->append('verfied');
        // $pages->each->append('sponsor');

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_pages,
            'recordsFiltered' => $total_pages,
            'data' => $pages,
        );
        // print_r($data);
        // print_r(mb_detect_order());
        // die;
        return response()->json($data);

        // return response()->json($data);
    }
    public function PublisherApproveRequest(Request $request, $id)
    {
        $id = $id;
        $publisher = Publisher::where('id', $id)->first();
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array('message' => 'Your Account has been Approved by Admin', 'subject' => 'Account Approved', 'email' => $publisher->email, 'publisher_id' => $publisher->id, 'name' => $publisher->name);

        // $smtp_server = SiteSetting::find(1);
        // $config = array(
        //     'driver'     => 'smtp',
        //     'host'       => $smtp_server->smtp_host,
        //     'port'       => $smtp_server->smtp_port,
        //     'username'   => $smtp_server->smtp_user,
        //     'password'   => $smtp_server->smtp_password,
        //     'encryption' => $smtp_server->smtp_enc,
        //     'from'       => array('address' => $smtp_server->from_email, 'name' => $smtp_server->from_name),
        //     'sendmail'   => '/usr/sbin/sendmail -bs',
        //     'pretend'    => false,
        // );
        // Config::set('mail', $config);

        // Mail::send('emails.sendmailadmin', ['data' => $data], function ($message) use ($data) {
        //     $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_OTHER_NAME'));
        //     $message->to($data['email'], $data['name'])->subject($data['subject']);
        // });
        if(Publisher::where('id', $id)->update(['status' => 'Active'])){
            $response = [
                'status' => true,
                'message' => 'Status Updated successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    
}
