<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Support\Google2FAAuthenticator;
use App\Models\Payment_method;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Publisher;
use App\Models\Site_category;
use App\Models\Affliate;
use App\Models\Postback;
use App\Models\Smartlink;
use App\Models\News_and_announcement;
use App\Models\Offer_process;
use App\Models\Countrie;
use App\Models\Message;
use App\Models\Site_setting;
use App\Models\Chat;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use App\Models\Mail_room;
use App\Models\Ranking;
use Illuminate\Support\Facades\Storage;
use App\Models\Affliate_withdraw;
use App\Models\Affliate_transaction;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Facades\Config;

class AffliateController extends Controller
{

    public function chat(){
        $id = Auth::guard('affliate')->id();
         $publisher_count = Publisher::where('affliate_manager_id', Auth::guard('affliate')->id())->count();
         $my_publisher = Publisher::where('affliate_manager_id', Auth::guard('affliate')->id())->get()->append('photourl')->append('unread');
        $my = Publisher::where('affliate_manager_id', Auth::guard('affliate')->id())->first()->append('photourl');
        $message=Chat::where('sender', $my->email)->where('receiver', 'affliate')->get()->append('photourl');
        if(empty($my_publisher)){
            return abort(404);
        }
        return view('affiliate.chat',compact('my_publisher', 'message','my'));
    }
    public function Payment()
    {
        $id = Auth::guard('affliate')->id();
        $date = date('Y-m-01 00:00:00');
        $affliate_withdraw= Affliate_withdraw::where('affliate_id', $id)->get();
         $affliate_tr= Affliate_transaction::where('affliate_id', $id)->sum('amount');
        return view('affiliate.payment',compact('affliate_withdraw', 'affliate_tr', 'date','id'));
    }
    public function chat_with_user(Request  $request ,$pubid){
        $id = Auth::guard('affliate')->id();
         $publisher_count = Publisher::where('affliate_manager_id', Auth::guard('affliate')->id())->count();
         if(empty($publisher_count)){
            return redirect()->route('manager.dashboard')->with('success', 'The chat page will Apprear when your publisher will send you message');
         }
         $my_publisher = Publisher::where('affliate_manager_id', Auth::guard('affliate')->id())->get()->append('photourl')->append('unread');
        $my = Publisher::where('id', $pubid)->first()->append('photourl');
        $message=Chat::where('sender', $my->email)->where('receiver', 'affliate')->orwhere('sender', 'affliate')->where('receiver', $my->email)->get()->append('photourl');
        Chat::where('sender', $my->email)->update(['is_read'=>1]);
        return view('affiliate.chat',compact('my_publisher', 'message','my'));
    }

    public function search_offer_dashboard(Request $request){
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $all_offer=Offer::where('offer_name','LIKE','%'. $request->text.'%')->get();
        $response = [
            'status' => true,
            'message' => 'Message send successfully',
            'data' => view('affiliate.layout.offer_search', compact('all_offer'))->render()
        ];
        return response()->json($response);
    }
    public function send_message_to_publisher(Request $request){
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $imagenid='';
        if ($request->file != '') {
        if(empty($request->message)){
        $message='';
        }else{
            $message= $request->message;
        }

        $validator = Validator::make($request->all(), [
            'file' => ['required','mimes:jpg']
        ]);
        if ($validator->fails()){
            $response = [
                'status' => false,
                'message' => 'Upload .jpg File Only',
                'data' => []
            ];
            return response()->json($response);
        }

            $imagenid = mt_rand(1, 1000) . '' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move('file', $imagenid);
        }else{
            $message= $request->message;
        }
        $data=[
            'message'=> $message,
            'sender'=> 'affliate',
            'receiver'=>$request->publisher,
            'screenshot' => $imagenid,
            'affliate_id'=> Auth::guard('affliate')->id(),
        ];
    
    
    
        if (Chat::create($data)) {
            $publisher = Publisher::where('email', $request->publisher)->first()->append('photourl');
            $message = Chat::where('sender', $publisher->email)->where('receiver', 'affliate')->orwhere('sender', 'affliate')->where('receiver', $publisher->email)->get()->append('photourl');
            $response = [
                'status' => true,
                'message' => 'Message send successfully',
                'data' => view('affiliate.chat_message',compact('message', 'publisher'))->render()
            ];
        }
        return response()->json($response);

    }
    public function search_publisher_chat(Request $request){
        $id = Auth::guard('affliate')->id();
         $my_publisher=Publisher::where('name','like','%'.$request->publisher.'%')->where('affliate_manager_id',$id)->get();
         if(!empty($my_publisher)){
            $response = [
                'status' => true,
                'message' => 'Message send successfully',
                'data' => view('affiliate.chart_search', compact('my_publisher'))->render()
            ];
         }else{
            $response = [
                'status' => true,
                'message' => 'Message send successfully',
                'data' => '<div class="alert alert-danger">There is no publisher</div>'
            ];
         }
        return response()->json($response);
    }
    public function index()
    {
        $id = Auth::guard('affliate')->id();
        if(empty($id)){
            return redirect('/manager/login');
        }
        $site = Site_setting::first();
        $my_publisher = Publisher::where('status', 'Active')->where('affliate_manager_id', $id)->count();
        $pending_publisher = Publisher::where('status', 'Inactive')->where('affliate_manager_id', $id)->count();
        $rejected_publisher = Publisher::wherein('status', ['banned', 'Rejected'])->where('affliate_manager_id', $id)->count();
        $pub = Publisher::where('affliate_manager_id', Auth::guard('affliate')->id())->get();

         $top_countrie= Countrie::selectRaw('countries.nicename, countries.phonecode,(SELECT COUNT(*) FROM offer_process Where  offer_process.country=countries.country_name AND source="smartlink") as leads,(SELECT COUNT(*) FROM offer_process Where offer_process.country=countries.nicename  AND source!="smartlink") as click ')->orderBy('leads', 'desc')->orderBy('click', 'desc')->limit(10)->get();
        //->append('totalclick')->append('totalleads');
        


        $top_10_offers =Offer::selectRaw('offers.offer_name,offers.payout,offer_process.offer_id,offers.icon_url,count(offer_process.id) as leads')->join('offer_process', 'offer_process.offer_id', 'offers.id')->join('publishers', 'publishers.id', 'offer_process.publisher_id')->where('publishers.affliate_manager_id',$id)->where('offer_process.status', 'Approved')->groupBy('offers.id')->orderBy('offers.payout','desc')->limit(10)->get()->append('leadscount');
        // $top_10_offers = DB::select("SELECT  o.offer_name,o.payout,op.offer_id,o.icon_url,count(op.id) as leads FROM `offers` as o join offer_process as op on op.offer_id=o.id  join publishers as p  on p.id=op.publisher_id where p.affliate_manager_id='$id' and op.status='Approved'  group by op.offer_id order by (select count(id) from offer_process where offer_id=op.offer_id and status='Approved') desc limit 10");
         $recent_conversion = Offer_process::select('offer_process.*')->join('offers','offers.id', 'offer_process.offer_id')->join('publishers', 'offer_process.publisher_id', 'publishers.id')->where('offer_process.status', 'Approved')->where('publishers.affliate_manager_id', $id)->orderBy('offer_process.created_at', 'desc')->paginate(10); //->append('photourl');
        $recent_conversion->append('photourl');
         $my_10_members= Publisher::selectRaw('ranking.publisher_id,sum(ranking.earnings) as earnings,sum(ranking.lead) as leads,publishers.name as name,publishers.total_earnings as publisher_earnings')->join('ranking','ranking.publisher_id','publishers.id')->where('publishers.affliate_manager_id',$id)->groupBy('ranking.publisher_id')->orderBy('earnings','desc')->get()->append('photourl');
          $top_10_members= Publisher::selectRaw('ranking.publisher_id,sum(ranking.earnings) as earnings,sum(ranking.lead) as leads,publishers.name as name,publishers.total_earnings as publisher_earnings')->join('ranking','ranking.publisher_id','publishers.id')->groupBy('ranking.publisher_id')->orderBy('earnings','desc')->get()->append('photourl');
    
        return view('affiliate.dashboard',compact('site', 'recent_conversion','my_publisher', 'pending_publisher','rejected_publisher', 'pub', 'top_10_offers', 'my_10_members', 'top_10_members', 'top_countrie'));
    }
    public function SendMail(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $message = $request->message;
        $subject = $request->subject;
        $email = $request->email;
        $attchment='';
        if ($request->attechment != '') {

            $validator = Validator::make($request->all(), [
                'attechment' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                $response = [
                    'status' => false,
                    'message' => 'Upload .jpg File Only',
                    'data' => []
                ];
                return response()->json($response);
            }

            $imagenid = mt_rand(1, 1000) . '' . time() . '.' . $request->file('attechment')->getClientOriginalExtension();
            $request->file('attechment')->move('attechment', $imagenid);
            $attchment = base_path('../attechment/' . $imagenid);
            $data = array('message' => $message, 'subject' => $subject, 'email' => $email, 'attchment' => $attchment, 'affliate_id' => Auth::guard('affliate')->id());
        }else{
   
        $data = array('message' => $message, 'subject' => $subject, 'email' => $email, 'attchment'=> '', 'affliate_id' => Auth::guard('affliate')->id());
        }
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

        Mail::send('emails.mailroom', ['data' => $data,'setting'=>$smtp_server], function ($message) use ($data) {
            $smtp_server = Site_setting::find(1);
            
            $message->from($smtp_server->from_email, $smtp_server->from_name);
            $message->to($data['email'], 'Publisher')->subject($data['subject']);
            if(isset($data['attchment']) && !empty($data['attchment'])){
            $message->attach($data['attchment']);
            }
        });
        if(Mail_room::create($data)){
            $response = [
                'status' => true,
                'message' => 'Mail send successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function ManagePublisher()
    {
        $affliate = Affliate::get();
        $country_list = Countrie::select('country_name', 'phonecode')->get();
    
        return view('affiliate.publisher.manage_publishers',compact('affliate', 'country_list'));
    }

    public function Support($reply = '')
    {
        $id = Auth::guard('affliate')->id();
        $publishers=Publisher::where('affliate_manager_id', $id)->get();
            if ($reply != '') {
        $qry = Message::where('id',$reply)->first();
            return view('affiliate.Support', compact('publishers', 'qry'))->with('reply', $reply);
    } else{
        return view('affiliate.Support',compact('publishers'))->with('reply', $reply);
    }
    }
    public function ViewPublisherMessages()
    {
        return view('affiliate.view_support_message');
    }
    public function MailRoom()
    {
        return view('affiliate.mail_room');
    }
    public function ViewMail()
    {
        return view('affiliate.view_send_mail');
    }
    public function ViewMessage($id)
    {
        Message::where('id', $id)->update(['is_read' => 1]);
        $msgdata=Message::where('id', $id)->first();
        return view('affiliate.view_message',compact('msgdata'), ['id' => $id]);
    }
    public function GenerateLink()
    {
        return view('affiliate.generate_link');
    }
    public function SendMessage(Request $request)
    {
        $imagenid = '';
        $id = Auth::guard('affliate')->id();
        $publishers = Publisher::where('affliate_manager_id', $id)->get();
        if ($request->screenshot != '') {
            $validator = Validator::make($request->all(), [
                'screenshot' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                // die('aaaaaa');
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            $imagenid = mt_rand(1, 1000) . '' . time() . '.' . $request->file('screenshot')->getClientOriginalExtension();
            $request->file('screenshot')->move('screenshot', $imagenid);
        }
        foreach ($publishers as $p) {
            # code...


            $data = array(
                'sender' => Auth::guard('affliate')->user()->email,
                'receiver' => $p->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'screenshot' => $imagenid,
                'affliate_id' => Auth::guard('affliate')->id(),
                'is_read' => 0
            );
            Message::create($data);
            $pub = Publisher::where('email', $p->email)->first();
            // $data = array('message' => $request->message, 'subject' => $request->subject, 'email' => $p, 'name' => $pub->name);

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

            // Mail::send('emails.AdminMessages', ['data' => $data], function ($message) use ($data) {
            //     $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_OTHER_NAME'));
            //     $message->to($data['email'], $data['name'])->subject($data['subject']);
            // });
        }
        return redirect()->route('manager.view-publisher-messages')->with('success', 'Message Send Successfully');
    }
    public function ShowPublisher(Request $request)
    {

        $id = Auth::guard('affliate')->id();
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Publisher::select('*')->where('affliate_manager_id',  $id);
        if(isset($request->status_type) && !empty($request->status_type)){
            if($request->status_type=='pending'){
                $pages_query->where('status', 'Inactive');
            }else if($request->status_type == 'rejected'){
                $pages_query->Where('status', 'Banned');
            }
        } else {
            $pages_query->Where('status', '<>', 'banned');
        }
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
        $pages->each->append('photo');
        if (isset($request->status_type) && !empty($request->status_type)) {
            if ($request->status_type == 'pending') {
                $pages->each->append('action4');
            } else if ($request->status_type == 'rejected') {
                $pages->each->append('action5');
            }
        }else{
            $pages->each->append('action3');
        }
        $pages = $pages->append('totalclick');
        $pages = $pages->append('totaluniqueclick');
        $pages = $pages->append('totalleads');
        $pages = $pages->append('totalearning');
        $pages = $pages->append('joindate');
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

    }
    public function get_post_mail(Request $request){
        return Mail_room::where('id',$request->id)->first();
    }
    public function show_mail(Request $request)
    {

        $id = Auth::guard('affliate')->id();
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Mail_room::select('*')->where('affliate_id',  $id);
    
        if (!empty($search)) {
            $pages_query->where('name', 'like', '%' . $search . '%');
            $pages_query->orWhere('email', 'like', '%' . $search . '%');
        }
        //sorting
        // if ($sort_by == 0) {
        //     $pages_query->orderBy('id', $sort_direction);
        // } elseif ($sort_by == 1) {
        //     $pages_query->orderBy('name', $sort_direction);
        // } elseif ($sort_by == 2) {
        //     $pages_query->orderBy('email', $sort_direction);
        // } elseif ($sort_by == 3) {
        //     $pages_query->orderBy('status', $sort_direction);
        // }
    
        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->orderby('id','desc')->get();
        $pages->append('date');
        $pages->append('action');
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_pages,
            'recordsFiltered' => $total_pages,
            'data' => $pages,
        );

        return response()->json($data);

    }
    public function show_message(Request $request)
    {

        $id = Auth::guard('affliate')->id();
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Message::select('*')->where('receiver',  'affliate')->orwhere('receiver', 'admin')->where('affliate_id',$id);
    
        // $pages_query->addSelect(DB::raw("SUBSTRING('description', 0, 1000) as dsd"));
        //search
        if (!empty($search)) {
            $pages_query->where('sender', 'like', '%' . $search . '%');
            $pages_query->orWhere('receiver', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $pages_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $pages_query->orderBy('sender', $sort_direction);
        } elseif ($sort_by == 2) {
            $pages_query->orderBy('receiver', $sort_direction);
        } elseif ($sort_by == 3) {
            $pages_query->orderBy('status', $sort_direction);
        }

        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->get();
        $pages->each->append('actionaffliate');
        $pages->each->append('date');

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

    }
    public function ApprovePublisher(Request $request, $id)
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
        if (Publisher::where('id', $id)->update(['status' => 'Active'])) {
            $response = [
                'status' => true,
                'message' => 'Status Updated successfully',
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
            'category' => $request->category,
            'payment_terms' => $request->payment_terms,
                     'status' => $request->status,
            'email' => $request->email,
            'country' => $request->countries,
            'affliate_manager_id' => $request->affliate_manager,
            'publisher_image' => $imageName
        );

        Publisher::where('id', $request->id)->update($data);
        return redirect()->back()->with('success', 'Publisher Updated Successfully');
    }
    public function UpdatePostback(Request $request)
    {
        $check = Postback::where('publisher_id', $request->id)->first();
        if ($check != '') {
            Postback::where('publisher_id', $request->id)->update(['link' => $request->postback]);
        } else {
            Postback::insert(['link' => $request->postback, 'publisher_id' => $request->id]);
        }
        return redirect()->back()->with('success', 'Postback Set Successfully');
    }
    public function GetDetail($id)
    {
        $check = Publisher::where('id', $id)->first();
        $data = Publisher::where('id', $id)->first();
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $site_category_list = Site_category::select('site_category_name')->get()->all();
        $Affliate = Affliate::select('id', 'name')->get()->all();
        if ($check->affliate_manager_id == Auth::guard('affliate')->id()) {
            return view('affiliate.publisher.get_details',compact('data', 'country_list', 'site_category_list', 'Affliate'))->with('id', $id);
        } else {
            return 'You are not allowed to see this user';
        }
    }
    public function  SetPostback($id)
    {
        return view('affiliate.publisher.set_postback')->with('id', $id);
    }
    public function ShowPendingPublisher()
    {
        $affliate = Affliate::get();
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        return view('affiliate.publisher.pending_publishers',compact('affliate','country_list'));
    }
    public function ShowRejectedPublisher()
    {
        $affliate = Affliate::get();
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        return view('affiliate.publisher.rejected_publisher',compact('affliate','country_list'));
    }
    public function BanPublisher(Request $request)
    {
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
    public function ShowSmartlinkRequest(Request $request)
    {

        // $id = Auth::guard('affliate')->id();
        // $qry = DB::select("select s.id as sid,s.url,s.created_at,s.enabled,s.earnings,c.category_name,s.name as sname,p.name as publisher_name,(select count(id) from offer_process as o where s.key_=o.key_) as total_clicks,(select count(id) from offer_process as o where s.key_=o.key_ and status='Approved') as total_leads,(select count(id) from smartlinks as sm  where sm.publisher_id=s.publisher_id) as total_smartlinks from smartlinks as s join publishers as p on s.publisher_id = p.id join category as c on c.id = s.category_id where p.affliate_manager_id='$id' and enabled=0 order by s.id desc");
        // return $qry;
        $id = Auth::guard('affliate')->id();
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Smartlink::select('smartlinks.*')->join('publishers','publishers.id','smartlinks.publisher_id')->where('publishers.affliate_manager_id',$id)->with('publisher')->with('category');
        if (isset($request->status_type) && !empty($request->status_type)) {
            if ($request->status_type == 'pending') {
                $pages_query->where('enabled', 0);
            } else if ($request->status_type == 'rejected') {
                $pages_query->where('enabled', 2);
            }
            else if ($request->status_type == 'approve') {
                $pages_query->where('enabled', 1);
            }
        } 
    
    
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
        $pages->each->append('status');
        $pages->each->append('action');
        $pages->each->append('date');
        // if (isset($request->status_type) && !empty($request->status_type)) {
        //     if ($request->status_type == 'pending') {
        //         $pages->each->append('action4');
        //     } else if ($request->status_type == 'rejected') {
        //         $pages->each->append('action5');
        //     }
        // } else {
        //     $pages->each->append('action3');
        // }
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

    }
    public function PendingSmartlink()
    {

        return view('affiliate.smartlink.pending_smartlink');
    }
    public function ApproveSmartlink()
    {

        return view('affiliate.smartlink.approve_smartlink');
    }
    public function RejectedSmartlink()
    {

        return view('affiliate.smartlink.rejected_smartlink');
    }
    public function SmartlinkApproveRequest(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
    
        if(Smartlink::where('id', $request->id)->update(['enabled' => '1'])) {
            $response = [
                'status' => true,
                'message' => 'Smartlink Approve Successfully',
                'data' => []
            ];
        }
            $ap = Smartlink::where('id', $request->id)->first();
        
    
        $publisher = Publisher::where('id', $ap->publisher_id)->first();

        // $data = array('message' => '', 'subject' => 'Your Smartlink  has been Approved', 'email' => $publisher->email, 'smartlink_name' => $ap->name, 'id' => $ap->id, 'status' => 'Approved', 'name' => $publisher->name, 'url' => $ap->url);

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

        // Mail::send('emails.approvesmartlinkrequest', ['data' => $data], function ($message) use ($data) {
        //     $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_OTHER_NAME'));
        //     $message->to($data['email'], $data['name'])->subject($data['subject']);
        // });
        return response()->json($response);
    }


    public function SmartlinkRejectRequest(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];

        if (Smartlink::where('id', $request->id)->update(['enabled' => '2'])) {
            $response = [
                'status' => true,
                'message' => 'Smartlink Approve Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function Settings()
    {
        $data = Affliate::where('id', Auth::guard('affliate')->id())->first();
        $payment = Payment_method::get()->all();
        return view('affiliate.settings', ['data' => $data, 'payment'=> $payment]);
    }

    public function ChangePassword(Request $request)
    {
        if ($request->password != $request->confirm_password) {
            $request->session()->flash('success', 'Password Not Match');
            return redirect()->back()->with('success', 'Password Not Match');
        }
        $data = array(
            'password' => bcrypt($request->password),
        );
        Affliate::where('id', $request->id)->update($data);
        return redirect()->back()->with('success', 'Password Updated  Successfully');
    }
    public function UpdateSettings(Request $request)
    {
        // dd($request);
        $imageName = '';
        if ($request->photo != '') {
            $validator = Validator::make($request->all(), [
                'photo' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }
            @unlink('uploads/' . $request->hidden_img);
            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads', $imageName);
        } else {
            $imageName = $request->hidden_img;
        }
        $data = array(
            'name' => $request->name,

            'email' => $request->email,
            'skype' => $request->skype,
            'address' => $request->address,
            'photo' => $imageName,
            'payment_description' => $request->payment_description,
            'payment_method' => $request->payment_method

        );
        Affliate::where('id', $request->id)->update($data);
        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }
}
