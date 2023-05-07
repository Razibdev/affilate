<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Helpers\UserSystemInfoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Support\Google2FAAuthenticator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Publisher;
use App\Models\Postback;
use App\Models\Postback_sent;
use App\Models\Site_category;
use App\Models\Affliate;
use App\Models\Domain;
use App\Models\Smartlink_domain;
use App\Models\Offer;
use App\Models\Smartlink;
use App\Models\Category;
use App\Models\Site_setting;
use App\Models\Countrie;
use App\Models\Payment_method;
use App\Models\Login_history;
use App\Models\Publisher_transaction;
use App\Models\Publisher_payment_method;
use App\Models\Message;
use App\Models\Chat;
use App\Models\Cashout_request;
use App\Models\Offer_process;
use Illuminate\Support\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{
    public function Showdashboard()
    {

        $id = Auth::guard('publisher')->id();
        $term_days = UserSystemInfoHelper::get_payment_rerm_total_days(Auth::guard('publisher')->user()->payment_terms);
        $balance = Auth::guard('publisher')->user()->balance;

        if (isset($term_days) && !empty($term_days) && !empty($balance)) {
            $balance = Auth::guard('publisher')->user()->balance;
            $term_date = Carbon::now()->subDays($term_days)->format('Y-m-d');
            $join_date = Carbon::parse(Auth::guard('publisher')->user()->created_at)->format('Y-m-d');
            if ($join_date <= $term_date) {
                $last_with = Cashout_request::where('affliate_id', $id)->orderby('id', 'desc')->first();
                if (!empty($last_with)) {
                    $publisher = Publisher_payment_method::where('publisher_id', $id)
                        ->where('is_primary', '1')
                        ->first();
                    $last_with_date = Carbon::parse($last_with->created_at)->format('Y-m-d');
                    if ($last_with_date <= $term_date) {
                        Publisher::where('id', $id)->decrement('balance', $balance);

                        $cashdata = array(
                            'affliate_id' => $id,
                            'from_date' => $term_date,
                            'payterm' => Auth::guard('publisher')->user()->payment_terms,
                            'to_date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $balance,
                            'note' => 'autometic withdrwal',
                            'status' => 'Pending',
                            'payment_details' => $publisher->payment_details,
                            'method' => $publisher->payment_type,
                        );
                        Cashout_request::create($cashdata);
                        $trs = array(
                            'amount' => -1 * $balance,
                            'offer_process_id' => '0',
                            'publisher_id' => $id
                        );
                        Publisher_transaction::create($trs);

                    }
                } else {
                    $publisher = Publisher_payment_method::where('publisher_id', $id)
                        ->where('is_primary', '1')
                        ->first();
                    // $last_with_date =   Carbon::parse($last_with->created_at)->format('Y-m-d');
                    $last_with_date = date('Y-m-d');
                    if ($last_with_date <= $term_date) {
                        Publisher::where('id', $id)->decrement('balance', $balance);

                        $cashdata = array(
                            'affliate_id' => $id,
                            'from_date' => $term_date,
                            'payterm' => Auth::guard('publisher')->user()->payment_terms,
                            'to_date' => Carbon::now()->format('Y-m-d'),
                            'amount' => $balance,
                            'note' => 'autometic withdrwal',
                            'status' => 'Pending',
                            'payment_details' => $publisher->payment_details,
                            'method' => $publisher->payment_type,
                        );
                        Cashout_request::create($cashdata);
                        $trs = array(
                            'amount' => -1 * $balance,
                            'offer_process_id' => '0',
                            'publisher_id' => $id
                        );
                        Publisher_transaction::create($trs);


                    }
                }
            }
        }

        $recent_conversion = Offer_process::select('offer_process.*')->join('offers', 'offers.id', 'offer_process.offer_id')->join('publishers', 'offer_process.publisher_id', 'publishers.id')->where('offer_process.status', 'Approved')->where('offer_process.publisher_id', $id)->orderBy('offer_process.created_at', 'desc')->paginate(10); //->append('photourl');
        $recent_conversion->append('photourl');


        $data['click_count'] = $click_count = Offer_process::where('publisher_id', $id)
            ->whereDate('created_at', Carbon::today())
            ->count();

          $data['click_count_yesterday'] = $click_count_yesterday = Offer_process::where('publisher_id', $id)
            ->whereDate('created_at', Carbon::now()->subDay())
            ->count();
        $data['click_count_c_month'] = $click_count_c_month = Offer_process::where('publisher_id', $id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $data['click_count_l_month'] = $click_count_l_month = Offer_process::where('publisher_id', $id)
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->count();



        $data['lead_count'] = $lead_count = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $data['lead_count_yesterday'] = $lead_count_yesterday = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
            ->whereDate('created_at', Carbon::now()->subDay())
            ->count();
        $data['lead_count_c_month'] = $lead_count_c_month = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $data['lead_count_l_month'] = $lead_count_l_month = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
            ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->count();


        if($lead_count){
            $data['cvr_count'] = ($lead_count/$click_count)*100;
        }else{
            $data['cvr_count'] = 0;
        }

        if($lead_count_yesterday){
            $data['cvr_count_yesterday'] = ($lead_count_yesterday/$click_count_yesterday)*100;
        }else{
            $data['cvr_count_yesterday'] = 0;
        }

        if($lead_count_c_month){
            $data['cvr_count_c_month'] = ($lead_count_c_month/$click_count_c_month)*100;
        }else{
            $data['cvr_count_c_month'] = 0;
        }

        if($lead_count_l_month){
            $data['cvr_count_l_month'] = ($lead_count_l_month/$click_count_l_month)*100;
        }else{
            $data['cvr_count_l_month'] =0;
        }


        $data['unique_click'] = $unique_click = Offer_process::where('publisher_id', $id)->where('unique_', 1)
                                                ->whereDate('created_at', Carbon::today())
                                                ->count();

        $data['unique_click_yesterday'] = $unique_click_yesterday = Offer_process::where('publisher_id', $id)->where('unique_', 1)
                                                ->whereDate('created_at', Carbon::now()->subDay())
                                                ->count();

        $data['unique_click_c_month'] = $unique_click_c_month = Offer_process::where('publisher_id', $id)->where('unique_', 1)
                                                ->whereMonth('created_at', Carbon::now()->month)
                                                ->count();

        $data['unique_click_l_month'] = $unique_click_l_month = Offer_process::where('publisher_id', $id)->where('unique_', 1)
                                                ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                                                ->count();




        if ($click_count != null && $lead_count != null) {
            $data['ctr'] = $click_count / $lead_count;
        } else {
            $data['ctr'] = 0;
        }


        $data['payout_count'] = $payout_count = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
            ->whereDate('created_at', Carbon::today())
            ->sum('payout');
        if ($payout_count != null && $lead_count != null) {
            $data['epc'] = $payout_count / $lead_count;
        } else {
            $data['epc'] = 0;
        }

        $data['publisher_table'] = $publisher_table = Publisher::where('id', $id)->first();




        $data['today_earning'] = $today_earning = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
            ->whereDate('updated_at', Carbon::today())
            ->sum('publisher_earned');

         $data['today_earning_yesterday'] = $today_earning_yesterday = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
             ->whereDate('created_at', Carbon::now()->subDay())
            ->sum('publisher_earned');

         $data['today_earning_c_month'] = $today_earning_c_month = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
             ->whereMonth('created_at', Carbon::now()->month)
            ->sum('publisher_earned');

         $data['today_earning_l_month'] = $today_earning_l_month = Offer_process::where('publisher_id', $id)
            ->where('status', 'Approved')
             ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->sum('publisher_earned');



        if ($today_earning != null) {
            $site = Site_setting::first();

            $data['td_epc'] = ($today_earning / 100) * $site->payout_percentage;
        } else {
            $data['td_epc'] = 0;
        }

          if ($today_earning_yesterday != null) {
            $site = Site_setting::first();

            $data['td_epc_yesterday'] = ($today_earning_yesterday / 100) * $site->payout_percentage;
        } else {
            $data['td_epc_yesterday'] = 0;
        }

          if ($today_earning_c_month != null) {
            $site = Site_setting::first();

            $data['td_epc_c_month'] = ($today_earning_c_month / 100) * $site->payout_percentage;
        } else {
            $data['td_epc_c_month'] = 0;
        }

          if ($today_earning_l_month != null) {
            $site = Site_setting::first();

            $data['td_epc_l_month'] = ($today_earning_l_month / 100) * $site->payout_percentage;
        } else {
            $data['td_epc_l_month'] = 0;
        }






        $month_date = date('Y-m-01');

        // \DB::enableQueryLog();

        // $diff_qry = Offer_process::selectRaw("(select count(id) from offer_process as ol  where ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='$id' and ol.created_at>='$month_date') as leads ,(select count(id) from offer_process as ol  where  date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='$id'  and ol.created_at>='$month_date') as clicks,(select sum(publisher_earned) from offer_process as ol  where  ol.publisher_id='$id' and ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at)  and ol.created_at>='$month_date') as earnings ,DATE_FORMAT(offer_process.created_at,'%d-%m-%Y %H:%i:%s') as createdat")->where('offer_process.publisher_id',$id)->where('offer_process.created_at','>=',$month_date)->groupby('offer_process.created_at')->orderby('offer_process.created_at','asc')->get();


        // (select count(id) from offer_process as ol  where ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='$id' and ol.created_at>='$month_date') as leads ,(select count(id) from offer_process as ol  where  date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='$id'  and ol.created_at>='$month_date') as clicks,(select sum(publisher_earned) from offer_process as ol  where  ol.publisher_id='$id' and ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at)  and ol.created_at>='$month_date') as earnings ,

        // $diff_qry = Offer_process::join("offer_process as ol","ol.created_at",'=',"offer_process.created_at")
        // ->join("offer_process as oc","oc.created_at",'=',"offer_process.created_at")
        // ->join("offer_process as oe","oe.created_at",'=',"offer_process.created_at")
        // ->selectRaw("DATE_FORMAT(offer_process.created_at,'%d-%m-%Y %H:%i:%s') as createdat,count(ol.id) as leads,count(oc.id) as clicks,sum(oe.publisher_earned) as earnings")
        // ->where('offer_process.publisher_id',$id)
        // ->where('offer_process.created_at','>=',$month_date)
        // ->where('oc.publisher_id','=',$id)
        // ->where('oc.created_at','>=',$month_date)
        // ->where('oe.publisher_id','=',$id)
        // ->where('oe.created_at','>=',$month_date)
        // ->where('oe.status','=','Approved')
        // ->where('ol.status','=','Approved')
        // ->where('ol.publisher_id','=',$id)
        // ->groupby('offer_process.created_at')
        // ->orderby('offer_process.created_at','asc')
        // ->get();


        // (select count(id) from offer_process as ol  where ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='$id' and ol.created_at>='$month_date') as leads ,(select count(id) from offer_process as ol  where  date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='$id'  and ol.created_at>='$month_date') as clicks,(select sum(publisher_earned) from offer_process as ol  where  ol.publisher_id='$id' and ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at)  and ol.created_at>='$month_date') as earnings ,


        // $diff_qry = Offer_process::selectRaw("DATE_FORMAT(offer_process.created_at,'%d-%m-%Y') as createdat")->where('offer_process.publisher_id',$id)->where('created_at','>=',$month_date)->orderBy('created_at','asc')->get()->groupBy('createdat');

//     $dataarray=array();
//     if($diff_qry){
//         foreach($diff_qry as $q){
//             $leads=Offer_process::select("id")->where('status','=','Approved')->where('publisher_id','=',$id)->where('created_at','>=',$month_date)->count();
//             echo '<pre>';
//             // print_r($q[0]->created_at);
//             print_r($leads);
//             echo '</pre>';
//         }
//     }

        $diff_qry = array();
        $diff_qrys = DB::table('offer_process')
            ->select(DB::raw('DATE(created_at) as createdat'))
            ->get()->groupBy('createdat');
        foreach ($diff_qrys as $data_key => $q) {

            $leads = Offer_process::select("id")->where('status', '=', 'Approved')->where('publisher_id', '=', $id)->where('created_at', '>=', $month_date)->whereDate('created_at', '=', $data_key)->count();
            $clicks = Offer_process::select("id")->where('publisher_id', '=', $id)->where('created_at', '>=', $month_date)->whereDate('created_at', '=', $data_key)->count();
            $earnings = Offer_process::where('status', '=', 'Approved')->where('publisher_id', '=', $id)->where('created_at', '>=', $month_date)->whereDate('created_at', '=', $data_key)->sum('publisher_earned');


            $diff_qry[] = array('createdat' => $data_key, 'leads' => $leads, 'clicks' => $clicks, 'earnings' => number_format((float)$earnings, 2, '.', ''));
        }


        $diff_qry = json_encode($diff_qry);

        // echo $diff_qry; die;
        return view('publisher/dashboard', compact('data', 'publisher_table', 'recent_conversion', 'diff_qry'));
    }


    public function chat()
    {
        $id = Auth::guard('publisher')->id();
        $affiliate_publisher = Affliate::where('id', Auth::guard('publisher')->user()->affliate_manager_id)->get()->append('photourl');
        $total_unread = Chat::where('receiver', Auth::guard('publisher')->user()->email)->where('sender', 'affliate')->where('is_read', null)->count();
        $message = Chat::where('sender', Auth::guard('publisher')->user()->email)->where('receiver', 'affliate')->get();
        return view('publisher.chat', compact('affiliate_publisher', 'message'));
    }

    public function chat_with_user(Request $request, $pubid)
    {
        $id = Auth::guard('publisher')->id();
        Chat::where('sender', 'affliate')->where('sender', Auth::guard('publisher')->user()->email)->update(['is_read' => 1]);
        $total_unread = Chat::where('receiver', Auth::guard('publisher')->user()->email)->where('sender', 'affliate')->where('is_read', null)->count();
        $affiliate_publisher = Affliate::where('id', Auth::guard('publisher')->user()->affliate_manager_id)->get()->append('photourl');
        $message = Chat::where('sender', Auth::guard('publisher')->user()->email)->where('receiver', 'affliate')->orwhere('sender', 'affliate')->where('receiver', Auth::guard('publisher')->user()->email)->get()->append('photourl');
        return view('publisher.chat', compact('affiliate_publisher', 'message'));
    }

    public function send_message_to_affliate(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $imagenid = '';
        if ($request->file != '') {
            if (empty($request->message)) {
                $message = '';
            } else {
                $message = $request->message;
            }


            $validator = Validator::make($request->all(), [
                'file' => ['required', 'mimes:jpg']
            ]);
            if ($validator->fails()) {
                // die('aaaaaa');
                $response = [
                    'status' => false,
                    'message' => 'Upload .jpg File Only',
                    'data' => []
                ];
                return response()->json($response);
                // return redirect()->back()->with('error', 'Upload .jpg File Only');
            }


            $imagenid = mt_rand(1, 1000) . '' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move('file', $imagenid);
        } else {
            $message = $request->message;
        }
        $data = [
            'message' => $message,
            'sender' => Auth::guard('publisher')->user()->email,
            'receiver' => $request->affliate,
            'screenshot' => $imagenid,
            'affliate_id' => Auth::guard('publisher')->user()->affliate_manager_id,
        ];
        if (Chat::create($data)) {
            $response = [
                'status' => true,
                'message' => 'Message send successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function Smartlink()
    {
        $sites = Category::get()->all();
        $domains = Smartlink_domain::get()->all();
        $site_settings = Site_setting::first();
        return view('publisher.smartlink', compact('sites', 'domains', 'site_settings'));
    }

    public function ManageSite()
    {
        $domains = Smartlink_domain::where('publisher_id', null)->Orwhere('publisher_id', Auth::guard('publisher')->id())->paginate(10);
        return view('publisher.site.manage_site', ['domains' => $domains]);
    }

    public function AddSite()
    {
        return view('publisher.site.add_site');
    }

    public function DeleteSite(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Smartlink_domain::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Smartlink deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);

    }

    public function InsertSite(Request $request)
    {

        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'url' => 'required'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'url' => $request->url,
            'publisher_id' => Auth::guard('publisher')->id(),
        );
        $exist = Smartlink_domain::where('url', $request->domain_name)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' => $exist
            ];
            return response()->json($response);
        }
        if (Smartlink_domain::create($data)) {
            $response = [
                'status' => true,
                'message' => 'Smartlink  add successfully',
                'data' => []
            ];
        }
        return response()->json($response);

    }

    public function UpdateSite(Request $request)
    {

        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'url' => 'required'
        ]);
        $exist = Smartlink_domain::where('url', $request->url)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' => $exist
            ];
            return response()->json($response);
        }
        $data = array(
            'url' => $request->url,
        );
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Smartlink_domain::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Smartlink Updated Updated Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function Support($reply = '')
    {
        $msg_data = Message::where('id', $reply)->first();

        return view('publisher.support', compact('msg_data'))->with('reply', $reply);
    }

    public function show_Messages(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Message::select('*')->where('receiver', Auth::guard('publisher')->user()->email);
        //search
        if (!empty($search)) {
            $category_query->where('sender', 'like', '%' . $search . '%');
        }
        //sorting

        $category_query->orderBy('id', 'desc');

        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->get();
        $category->each->append('actionpublisher');
        $category->each->append('date');
        // $category->each->append('excerpt');
        // $category->each->append('sponsor');

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_site_category,
            'recordsFiltered' => $total_site_category,
            'data' => $category,
        );
        return response()->json($data);
    }

    public function ViewMessage($id)
    {
        Message::where('id', $id)->update(['is_read' => 1]);
        $msg_data = Message::where('id', $id)->first();
        return view('publisher.view_message', compact('msg_data'), ['id' => $id]);
    }

    public function SendMessage(Request $request)
    {

        $imagenid = '';
        if ($request->screenshot != '') {

            $validator = Validator::make($request->all(), [
                'screenshot' => ['required', 'mimes:jpg']
            ]);
            if ($validator->fails()) {
                // die('aaaaaa');
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            $imagenid = mt_rand(1, 1000) . '' . time() . '.' . $request->file('screenshot')->getClientOriginalExtension();
            $request->file('screenshot')->move('screenshot', $imagenid);
        }
        $receiver = 'admin';
        if ($request->affliate_id != '') {
            $receiver = 'affliate';
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'subject' => 'required'
        ]);
        if ($validator->fails()) {
            // die('aaaaaa');
            return redirect()->back()->with('error', 'Please check Required Fields');
        }


        $data = array(
            'sender' => Auth::guard('publisher')->user()->email,
            'receiver' => $receiver,
            'subject' => $request->subject,
            'message' => $request->message,
            'screenshot' => $imagenid,
            'affliate_id' => Auth::guard('publisher')->user()->affliate_manager_id,
            'is_read' => 0
        );
        Message::create($data);
        return redirect()->back()->with('success', 'Message Send Successfully');
    }

    public function FilterSmartlink(Request $request)
    {
        $id = Auth::guard('publisher')->id();
        $from_date = $request->from_date . ' 00:00:00';
        $to_date = $request->to_date . ' 23:59:59';

        if ($request->from_date == '' && $request->to_date == '' && $request->category == '') {
            $qry = DB::select("select *, `s`.`id` as `smart_id` from `smartlinks` as `s` left join `category` as `c` on `c`.`id` = `s`.`category_id` where `s`.`publisher_id` = '$id' and  s.name like '%$request->name%'");
        } else if ($request->from_date == '' && $request->to_date == '') {
            $qry = DB::select("select *, `s`.`id` as `smart_id` from `smartlinks` as `s` left join `category` as `c` on `c`.`id` = `s`.`category_id` where `s`.`publisher_id` = '$id' and  s.name like '%$request->name%' and s.category_id=$request->category");
        } else if ($request->category == '') {
            $qry = DB::select("select *, `s`.`id` as `smart_id` from `smartlinks` as `s` left join `category` as `c` on `c`.`id` = `s`.`category_id` where `s`.`publisher_id` = '$id' and s.created_at>='$from_date' and s.created_at<='$to_date' and s.name like '%$request->name%'");
        } else {
            $qry = DB::select("select *, `s`.`id` as `smart_id` from `smartlinks` as `s` left join `category` as `c` on `c`.`id` = `s`.`category_id` where `s`.`publisher_id` = '$id' and s.created_at>='$from_date' and s.created_at<='$to_date' and s.name like '%$request->name%' and s.category_id=$request->category ");
        }

        return view('publisher.show_smartlink', ['qry' => $qry]);
    }

    public function ViewSmartlink()
    {
        $sites = Category::get()->all();
        $domains = Smartlink_domain::get()->all();
        $site_settings = Site_setting::first();
        $Smart_links = Smartlink::select('smartlinks.*')->where('publisher_id', Auth::guard('publisher')->id())->join('category', 'smartlinks.category_id', '=', 'category.id')->where('smartlinks.is_delete', 0)->get();

        return view('publisher.show_smartlink', compact('Smart_links', 'domains', 'sites'));
    }

    public function InsertSmartlink(Request $request)
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
            'url' => 'required',
            'category' => 'required',
            'domain' => 'required',
            'name' => 'required',
            'traffic_source' => 'required',
        ]);

        $data = array(
            'publisher_id' => Auth::guard('publisher')->id(),
            'url' => $request->url,
            'category_id' => $request->category,
            'key_' => $request->key,
            'enabled' => 1,
            'name' => $request->name,
            'traffic_source' => $request->traffic_source,
            'is_delete' => '0',
        );

        if (Smartlink::create($data)) {
            $response = [
                'status' => true,
                'message' => 'New Smartlink created successfully',
                'data' => []
            ];
        }
        return response()->json($response);
        // return redirect('publisher/show-smartlink')->with('success', 'Smartlink added successfully ');
    }

    public function DeleteSmartlink(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $row = Smartlink::where('id', $request->id)->first();
        $row->is_delete = '1';
        if ($row->save()) {
            $response = [
                'status' => true,
                'message' => 'Smartlink deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }


    public function AccountInformation()
    {
        $site_settings = Site_setting::find(1);
        $payment = Publisher_payment_method::where('publisher_id', Auth::guard('publisher')->id())->get();
        $publisher = Publisher::where('id', Auth::guard('publisher')->id())->first();
        $paymentmethod = Payment_method::get()->all();
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $site_category_list = Site_category::get()->all();
        return view('publisher.account_settings', compact('site_settings', 'paymentmethod', 'country_list', 'site_category_list', 'publisher', 'payment'));
    }

    public function ChangePassword(Request $request)
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
            'password' => 'required',
            'confirm_password' => 'required'
        ]);
        if ($request->password != $request->confirm_password) {
            $response = [
                'status' => false,
                'message' => 'Password Not match',
                'data' => []
            ];
        }
        $data = array(
            'password' => bcrypt($request->password),
        );
        if (Publisher::where('id', Auth::guard('publisher')->id())->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Password Updated successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }


    public function UpdateSettings(Request $request)
    {


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
            'category' => $request->category
        );

        Publisher::where('id', Auth::guard('publisher')->id())->update($data);
        return redirect()->back()->with('success', 'Settings Updated  Successfully');
    }

    public function UploadImage(Request $request)
    {

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $this->validate($request, [
            'file' => 'required|image|max:1024'
        ]);


        $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('file')->getClientOriginalExtension();
        $request->file('file')->move('uploads', $imageName);
        @unlink('uploads/' . Auth::guard('publisher')->user()->publisher_image);

        if (Publisher::where('id', Auth::guard('publisher')->id())->update(['publisher_image' => $imageName])) {
            $response = [
                'status' => true,
                'message' => 'Publisher Image Updated successfully',
                'data' => []
            ];
        }
        return redirect()->back()->with('Success', "Publisher Image Updated successfully.");;
    }

    public function RemoveAccount(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Publisher_payment_method::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Publisher Payment method is deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function AddPayment(Request $request)
    {
        $primary = 0;
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $this->validate($request, [
            'payment_type' => 'required',
            'payment_details' => 'required'
        ]);
        if ($request->primary == 1) {
            Publisher_payment_method::where('publisher_id', Auth::guard('publisher')->id())->update(['is_primary' => 0]);
            $primary = 1;
        }
        $data = array(
            'payment_type' => $request->payment_type,
            'payment_details' => $request->payment_details,
            'publisher_id' => Auth::guard('publisher')->id(),
            'is_primary' => $primary

        );
        if (Publisher_payment_method::insert($data)) {
            $response = [
                'status' => true,
                'message' => 'Publisher Paymenth add  successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function LoginHistory()
    {

        $qry = Login_history::where('publisher_id', Auth::guard('publisher')->id())->orderBy('id', 'desc')->paginate(10);
        return view('publisher.login_information', ['qry' => $qry]);
    }

    public function Postback()
    {
        $qry = Postback::where('publisher_id', Auth::guard('publisher')->id())->first();
        $site_setting = Site_setting::find(1);
        return view('publisher.postback.postback', compact('qry', 'site_setting'));
    }

    public function SendPostback()
    {
        $qry = Postback_sent::where('publisher_id', Auth::guard('publisher')->id())->orderBy('id', 'desc')->paginate(10);
        return view('publisher.postback.postback_sent', compact('qry'));
    }

    public function show_post_back(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Postback_sent::select('*')->where('publisher_id', Auth::guard('publisher')->id());


        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category = $category->append('date');
        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_site_category,
            'recordsFiltered' => $total_site_category,
            'data' => $category,
        );
        return response()->json($data);
    }


    // report By date

    public function ReportByDate(Request $request)
    {
        $id = Auth::guard('publisher')->id();


        if (!empty($_GET['from_date'])) {
            $from_date = $_GET['from_date'] . ' 00:00:00';
        } else {
            $from_date = date('Y-m-1 00:00:00');
        }
        if (!empty($_GET['to_date'])) {
            $to_date = $_GET['to_date'] . ' 23:59:59';
        } else {
            $to_date = date('Y-m-d 23:59:59');
        }

        $qry = Offer_process::selectRaw("DATE(offer_process.created_at) as group_date,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and DATE(optclick.created_at)=group_date) as clicks,(select count(id) from offer_process opleads where opleads.publisher_id='$id' and opleads.status='Approved' and DATE(opleads.created_at)=group_date) as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.publisher_id='$id'  AND opearning.status='Approved' and DATE(opearning.created_at)=group_date)  as earnings")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupBy('group_date')->get();

        //    $qry= Offer_process::selectRaw("offer_process.offer_id,offer_process.created_at,offer_process.source,offer_process.key_,offer_process.ua_target,offer_process.sid,offer_process.sid2,offer_process.sid3,offer_process.sid4,offer_process.sid5,offer_process.country as countries,offer_process.ip_address as ip_address,offer_process.offer_id ,offer_process.browser,offer_process.offer_name,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and optclick.created_at>='$from_date' and optclick.created_at<='$to_date') as total_clicks,(select count(id) from offer_process oclick where oclick.id=offer_process.id and oclick.created_at>='$from_date' and oclick.created_at<='$to_date') as clicks,(select count(id) from offer_process opleads where opleads.id=offer_process.id and opleads.status='Approved' and opleads.created_at>='$from_date' and opleads.created_at<='$to_date') as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.id=offer_process.id and opearning.status='Approved' and opearning.created_at>='$from_date' and opearning.created_at<='$to_date')  as earnings,(select smartlinks.name From smartlinks  WHERE smartlinks.key_=offer_process.key_ ) as smartlink ")->where('offer_process.publisher_id',$id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->orderby('offer_process.id','desc')->get();


        //    echo '<pre>';
        //    print_r($qry);
        //    echo '</pre.';
        //    die;


        return view('publisher.report-by-date', ['qry' => $qry, 'from_date' => date('Y-m-d 00:00:00'), 'to_date' => date('Y-m-d 23:59:59')]);
    }

    // Report By Date

    // report By Device

    public function ReportByDevice(Request $request)
    {
        $id = Auth::guard('publisher')->id();


        if (!empty($_GET['from_date'])) {
            $from_date = $_GET['from_date'] . ' 00:00:00';
        } else {
            $from_date = date('Y-m-1 00:00:00');
        }
        if (!empty($_GET['to_date'])) {
            $to_date = $_GET['to_date'] . ' 23:59:59';
        } else {
            $to_date = date('Y-m-d 23:59:59');
        }


        $qry = Offer_process::selectRaw("offer_process.ua_target as sdevice,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and optclick.ua_target=sdevice) as clicks,(select count(id) from offer_process opleads where opleads.publisher_id='$id' and opleads.status='Approved' and opleads.ua_target=sdevice) as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.publisher_id='$id'  AND opearning.status='Approved' and opearning.ua_target=sdevice)  as earnings")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupBy('sdevice')->get();

        return view('publisher.report-by-device', ['qry' => $qry, 'from_date' => date('Y-m-d 00:00:00'), 'to_date' => date('Y-m-d 23:59:59')]);
    }

    // report By Device

    // report By Browser

    public function ReportByBrowser(Request $request)
    {
        $id = Auth::guard('publisher')->id();


        if (!empty($_GET['from_date'])) {
            $from_date = $_GET['from_date'] . ' 00:00:00';
        } else {
            $from_date = date('Y-m-1 00:00:00');
        }
        if (!empty($_GET['to_date'])) {
            $to_date = $_GET['to_date'] . ' 23:59:59';
        } else {
            $to_date = date('Y-m-d 23:59:59');
        }


        $qry = Offer_process::selectRaw("offer_process.browser as tbrowser,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and optclick.browser=tbrowser) as clicks,(select count(id) from offer_process opleads where opleads.publisher_id='$id' and opleads.status='Approved' and opleads.browser=tbrowser) as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.publisher_id='$id'  AND opearning.status='Approved' and opearning.browser=`browser`)  as earnings")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupBy('tbrowser')->get();

        // echo '<pre>';print_r($qry); echo '</pre>';die;


        return view('publisher.report-by-browser', ['qry' => $qry, 'from_date' => date('Y-m-d 00:00:00'), 'to_date' => date('Y-m-d 23:59:59')]);
    }

    // report By Browser

    // report By Country

    public function ReportByCountry(Request $request)
    {
        $id = Auth::guard('publisher')->id();


        if (!empty($_GET['from_date'])) {
            $from_date = $_GET['from_date'] . ' 00:00:00';
        } else {
            $from_date = date('Y-m-1 00:00:00');
        }
        if (!empty($_GET['to_date'])) {
            $to_date = $_GET['to_date'] . ' 23:59:59';
        } else {
            $to_date = date('Y-m-d 23:59:59');
        }


        $qry = Offer_process::selectRaw("offer_process.country as tcountry,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and optclick.country=tcountry) as clicks,(select count(id) from offer_process opleads where opleads.publisher_id='$id' and opleads.status='Approved' and opleads.country=tcountry) as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.publisher_id='$id'  AND opearning.status='Approved' and opearning.country=tcountry)  as earnings")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupBy('tcountry')->get();
        return view('publisher.report-by-country', ['qry' => $qry, 'from_date' => date('Y-m-d 00:00:00'), 'to_date' => date('Y-m-d 23:59:59')]);
    }

    // report By Country

    //report By SID

    public function ReportBySid(Request $request)
    {
        $id = Auth::guard('publisher')->id();


        if (!empty($_GET['from_date'])) {
            $from_date = $_GET['from_date'] . ' 00:00:00';
        } else {
            $from_date = date('Y-m-1 00:00:00');
        }
        if (!empty($_GET['to_date'])) {
            $to_date = $_GET['to_date'] . ' 23:59:59';
        } else {
            $to_date = date('Y-m-d 23:59:59');
        }


        $qry = Offer_process::selectRaw("offer_process.sid as ssid,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and optclick.sid=ssid) as clicks,(select count(id) from offer_process opleads where opleads.publisher_id='$id' and opleads.status='Approved' and opleads.sid=ssid) as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.publisher_id='$id'  AND opearning.status='Approved' and opearning.sid=ssid)  as earnings")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupBy('ssid')->get();
        return view('publisher.report-by-sid', ['qry' => $qry, 'from_date' => date('Y-m-d 00:00:00'), 'to_date' => date('Y-m-d 23:59:59')]);
    }

    //Report By SID


    public function DailyReport()
    {

        $id = Auth::guard('publisher')->id();
        $from_date = date('Y-m-d 00:00:00');
        $to_date = date('Y-m-d 23:59:59');
        $qry1 = Offer_process::selectRaw("offer_process.created_at,group_concat(distinct(offer_process.country)) as countries,group_concat(distinct(offer_process.ip_address)) as ip_address,group_concat(distinct(offer_process.offer_id)) as offer_id,group_concat(distinct(offer_process.browser)) as browser,(select count(id) from offer_process opleads where  opleads.publisher_id='$id' and opleads.created_at=offer_process.created_at and opleads.status='Approved' and opleads.created_at>='$from_date' and opleads.created_at<='$to_date') as leads,(select count(id) from offer_process opclick where opclick.publisher_id='" . $id . "' and opclick.created_at=offer_process.created_at  and opclick.created_at>='" . $from_date . "' and opclick.created_at<='" . $to_date . "') as clicks ,(select sum(publisher_earned) from offer_process opearning where opearning.publisher_id='$id' and opearning.created_at=offer_process.created_at and opearning.status='Approved' and opearning.created_at>='$from_date' and opearning.created_at<='$to_date') as earnings  ")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupBy('offer_process.created_at')->get();

        $qry = Offer_process::selectRaw("offer_process.offer_id,offer_process.created_at,offer_process.source,offer_process.key_,offer_process.ua_target,offer_process.sid,offer_process.sid2,offer_process.sid3,offer_process.sid4,offer_process.sid5,offer_process.country as countries,offer_process.ip_address as ip_address,offer_process.offer_id ,offer_process.browser,offer_process.offer_name,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and optclick.created_at>='$from_date' and optclick.created_at<='$to_date') as total_clicks,(select count(id) from offer_process oclick where oclick.id=offer_process.id and oclick.created_at>='$from_date' and oclick.created_at<='$to_date') as clicks,(select count(id) from offer_process opleads where opleads.id=offer_process.id and opleads.status='Approved' and opleads.created_at>='$from_date' and opleads.created_at<='$to_date') as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.id=offer_process.id and opearning.status='Approved' and opearning.created_at>='$from_date' and opearning.created_at<='$to_date')  as earnings,(select smartlinks.name From smartlinks  WHERE smartlinks.key_=offer_process.key_ ) as smartlink ")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->orderby('offer_process.id', 'desc')->paginate(10);


        return view('publisher.daily_report', ['qry1' => $qry1, 'qry' => $qry, 'from_date' => $from_date, 'to_date' => $to_date]);
    }

    public function ShowDailyReport(Request $request)
    {

        $id = Auth::guard('publisher')->id();
        if ($request->from_date) {
            $from_date = $request->from_date;
        } else {
            $from_date = date('Y-m-d 00:00:00');
        }

        if ($request->to_date) {
            $to_date = $request->to_date;
        } else {
            $to_date = date('Y-m-d 23:59:59');
        }


        $qry1 = Offer_process::selectRaw("offer_process.created_at,group_concat(distinct(offer_process.country)) as countries,group_concat(distinct(offer_process.ip_address)) as ip_address,group_concat(distinct(offer_process.offer_id)) as offer_id,group_concat(distinct(offer_process.browser)) as browser,(select count(id) from offer_process opleads where  opleads.publisher_id='$id' and opleads.created_at=offer_process.created_at and opleads.status='Approved' and opleads.created_at>='$from_date' and opleads.created_at<='$to_date') as leads,(select count(id) from offer_process opclick where opclick.publisher_id='" . $id . "' and opclick.created_at=offer_process.created_at  and opclick.created_at>='" . $from_date . "' and opclick.created_at<='" . $to_date . "') as clicks ,(select sum(publisher_earned) from offer_process opearning where opearning.publisher_id='$id' and opearning.created_at=offer_process.created_at and opearning.status='Approved' and opearning.created_at>='$from_date' and opearning.created_at<='$to_date') as earnings  ")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupBy('offer_process.created_at')->get();

        $qry = Offer_process::selectRaw("offer_process.offer_id,offer_process.created_at,offer_process.source,offer_process.key_,offer_process.ua_target,offer_process.sid,offer_process.sid2,offer_process.sid3,offer_process.sid4,offer_process.sid5,offer_process.country as countries,offer_process.ip_address as ip_address,offer_process.offer_id ,offer_process.browser,offer_process.offer_name,(select count(id) from offer_process  optclick where optclick.publisher_id='$id' and optclick.created_at>='$from_date' and optclick.created_at<='$to_date') as total_clicks,(select count(id) from offer_process oclick where oclick.id=offer_process.id and oclick.created_at>='$from_date' and oclick.created_at<='$to_date') as clicks,(select count(id) from offer_process opleads where opleads.id=offer_process.id and opleads.status='Approved' and opleads.created_at>='$from_date' and opleads.created_at<='$to_date') as leads,(select sum(opearning.publisher_earned) from offer_process as opearning where opearning.id=offer_process.id and opearning.status='Approved' and opearning.created_at>='$from_date' and opearning.created_at<='$to_date')  as earnings,(select smartlinks.name From smartlinks  WHERE smartlinks.key_=offer_process.key_ ) as smartlink ")->where('offer_process.publisher_id', $id)->whereBetween('offer_process.created_at', [$from_date, $to_date])->orderby('offer_process.id', 'desc')->paginate(10);

        return view('publisher.daily_report', ['qry1' => $qry1, 'qry' => $qry, 'from_date' => $from_date, 'to_date' => $to_date]);
        // return view('publisher.daily_report', ['from_date' => $request->from_date, 'to_date' => $request->to_date]);
    }

    public function Reports_get(Request $request)
    {
        $id = Auth::guard('publisher')->id();
        $smartlink_type = Smartlink::where('publisher_id', Auth::guard('publisher')->id())->get();
        $diff_qry = Offer_process::selectRaw('(select count(id) from offer_process as ol  where ol.status="Approved" and date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id="' . $id . '"   ) as leads ,(select count(id) from offer_process as ol  where  date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id="' . $id . '"   ) as clicks,(select sum(publisher_earned) from offer_process as ol  where  ol.publisher_id="' . $id . '" and ol.status="Approved" and date(ol.created_at)=date(offer_process.created_at)    ) as earnings ,offer_process.created_at ')->where('offer_process.publisher_id', $id)->groupby('offer_process.created_at')->orderby('offer_process.created_at', 'desc')->get();
        $diff_qry = json_encode($diff_qry);
        $qry = Offer_process::selectRaw('*,(select payout_percentage from offers where id=offer_process.offer_id) as payout_percentage,(SELECT count(id) from offer_process where (ua_target ="windows" or  ua_target="Mac") and status="Approved" and publisher_id="' . $id . '"  ) as desktop,(SELECT count(id) from offer_process where (ua_target="Android" or  ua_target ="Iphone") and status="Approved" and publisher_id="' . $id . '"  ) as mobile,(SELECT count(id) from offer_process where (ua_target="Ipad") and status="0Approved" and publisher_id="' . $id . '"  ) as tablet,(SELECT count(id) from offer_process where status="Approved" and publisher_id="' . $id . '"  ) as total_rows')->where('offer_process.publisher_id', $id)->where('offer_process.status', 'Approved')->orderby('offer_process.created_at', 'desc')->get();
        $country = Offer_process::selectRaw('count(id) as visitors,country')->where('publisher_id', $id)->where('status', 'Approved')->groupby('country')->get();
        $location = json_encode($country);
        $source = Offer_process::selectRaw('source,count(id) as visitors')->where('publisher_id', $id)->where('status', 'Approved')->groupby('source')->get();
        return view('publisher.Report')->with(['source' => $source, 'location' => $location, 'country' => $country, 'qry' => $qry, 'diff_qry' => $diff_qry, 'smartlink_type' => $smartlink_type, 'from_date' => date('Y-m-d 00:00:00', strtotime('-7 days')), 'to_date' => date('Y-m-d 23:59:59'), 'type' => 'offer', 'key' => '11']);
    }

    public function Reports(Request $request)
    {

        $id = Auth::guard('publisher')->id();
        $smartlink_type = Smartlink::where('publisher_id', Auth::guard('publisher')->id())->get();
        $month_date = date('Y-m-01 00:00:00');
        $diff_qry = '';
        $from_date = $request->from_date . ' 00:00:00';
        $to_date = $request->to_date . ' 23:59:59';
        $key = $request->key;
        $type = $request->type;
        $site = Site_setting::first();
        if ($type == 'smartlink') {


            $diff_qry = Offer_process::selectRaw('(select count(id) from offer_process as ol  where ol.status="Approved" and date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id="' . $id . '"  and (date(created_at)>="' . $from_date . '" and date(created_at)<="' . $to_date . '") and  key_="' . $key . '") as leads ,(select count(id) from offer_process as ol  where  date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id="' . $id . '"  and (date(created_at)>="' . $from_date . '" and date(created_at)<="' . $to_date . '") and  key_="' . $key . '") as clicks,(select sum(publisher_earned) from offer_process as ol  where  ol.publisher_id="' . $id . '" and ol.status="Approved" and date(ol.created_at)=date(offer_process.created_at)   and (date(created_at)>="' . $from_date . '" and date(created_at)<="' . $to_date . '") and  key_="' . $key . '") as earnings ,offer_process.created_at ')->where('offer_process.publisher_id', $id)->where('key_', $key)->whereBetween('offer_process.created_at', [$from_date, $to_date])->groupby('offer_process.created_at')->orderby('offer_process.created_at', 'desc')->get();
            $diff_qry = json_encode($diff_qry);

            $qry = Offer_process::selectRaw('*,(select payout_percentage from offers where id=offer_process.offer_id) as payout_percentage,(SELECT count(id) from offer_process where (ua_target ="windows" or  ua_target="Mac") and status="Approved" and publisher_id="' . $id . '" and  (date(created_at)>="' . $from_date . '" and date(created_at)<="' . $to_date . '")  and key_="' . $key . '" ) as desktop,(SELECT count(id) from offer_process where (ua_target="Android" or  ua_target ="Iphone") and status="Approved" and publisher_id="' . $id . '" and  (date(created_at)>="' . $from_date . '" and date(created_at)<="' . $to_date . '")    and key_="' . $key . '" ) as mobile,(SELECT count(id) from offer_process where (ua_target="Ipad") and status="0Approved" and publisher_id="' . $id . '" and  (date(created_at)>="' . $from_date . '" and date(created_at)<="' . $to_date . '")   and key_="' . $key . '"  ) as tablet,(SELECT count(id) from offer_process where status="Approved" and publisher_id="' . $id . '" and  (date(created_at)>="' . $from_date . '" and date(created_at)<="' . $to_date . '")   and key_="' . $key . '"  ) as total_rows')->where('offer_process.publisher_id', $id)->where('key_', $key)->whereBetween('offer_process.created_at', [$from_date, $to_date])->where('offer_process.status', 'Approved')->orderby('offer_process.created_at', 'desc')->get();

            $country = Offer_process::selectRaw('count(id) as visitors,country')->where('publisher_id', $id)->where('status', 'Approved')->whereBetween('created_at', [$from_date, $to_date])->where('key_', $key)->groupby('country')->get();

            $location = json_encode($country);

            $source = Offer_process::selectRaw('source,count(id) as visitors')->where('publisher_id', $id)->where('status', 'Approved')->whereBetween('created_at', [$from_date, $to_date])->where('key_', $key)->groupby('source')->get();

        } else {

            $diff_qry = Offer_process::selectRaw("(select count(id) from offer_process as ol  where ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='" . $id . "'  and (created_at>='" . $from_date . "' and created_at<='" . $to_date . "') and ol.key_ is NULL) as leads ,(select count(id) from offer_process as ol  where  date(ol.created_at)=date(offer_process.created_at) and ol.publisher_id='" . $id . "'  and (created_at>='" . $from_date . "' and created_at<='" . $to_date . "') and ol.key_ is NULL) as clicks,(select sum(publisher_earned) from offer_process as ol  where  ol.publisher_id='" . $id . "' and ol.status='Approved' and date(ol.created_at)=date(offer_process.created_at)   and (created_at>='" . $from_date . "' and created_at<='" . $to_date . "') and ol.key_ is NULL) as earnings ,offer_process.created_at")->where('offer_process.publisher_id', $id)->where('key_', NULL)->whereBetween('offer_process.created_at', [$from_date, $to_date])->where('offer_process.status', 'Approved')->groupby('offer_process.created_at')->orderby('offer_process.created_at', 'desc')->get();
            $diff_qry = json_encode($diff_qry);
            $qry = Offer_process::selectRaw('*,(select payout_percentage from offers where id=offer_process.offer_id) as payout_percentage,(SELECT count(id) from offer_process where (ua_target ="windows" or  ua_target="Mac") and status="Approved" and publisher_id="' . $id . '" and  (created_at>="' . $from_date . '" and created_at<="' . $to_date . '")  and key_ is NULL) as desktop,(SELECT count(id) from offer_process where (ua_target="Android" or  ua_target ="Iphone") and status="Approved" and publisher_id="' . $id . '" and  (created_at>="' . $from_date . '" and created_at<="' . $to_date . '")    and key_ is NULL) as mobile,(SELECT count(id) from offer_process where (ua_target="Ipad") and status="0Approved" and publisher_id="' . $id . '" and  (created_at>="' . $from_date . '" and created_at<="' . $to_date . '")   and key_ is NULL ) as tablet,(SELECT count(id) from offer_process where status="Approved" and publisher_id="' . $id . '" and  (created_at>="' . $from_date . '" and created_at<="' . $to_date . '")   and key_ is NULL ) as total_rows')->where('offer_process.publisher_id', $id)->where('key_', NULL)->whereBetween('offer_process.created_at', [$from_date, $to_date])->where('offer_process.status', 'Approved')->orderby('offer_process.created_at', 'desc')->get();
            $country = Offer_process::selectRaw('count(id) as visitors,country')->where('publisher_id', $id)->where('status', 'Approved')->whereBetween('created_at', [$from_date, $to_date])->where('key_', NULL)->groupby('country')->get();
            $location = json_encode($country);
            $source = Offer_process::selectRaw('source,count(id) as visitors')->where('publisher_id', $id)->where('status', 'Approved')->whereBetween('created_at', [$from_date, $to_date])->where('key_', NULL)->groupby('source')->get();
        }

        return view('publisher.Report')->with(['location' => $location, 'source' => $source, 'diff_qry' => $diff_qry, 'qry' => $qry, 'country' => $country, 'smartlink_type' => $smartlink_type, 'from_date' => $request->from_date . ' 00:00:00', 'to_date' => $request->to_date . ' 23:59:59', 'type' => $request->type, 'key' => $request->key]);
    }

    public function AddPostback(Request $request)
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
            'postback' => 'required'
        ]);
        $check = Postback::where('publisher_id', Auth::guard('publisher')->id())->first();
        if ($check != '') {
            if (Postback::where('publisher_id', Auth::guard('publisher')->id())->update(['link' => $request->postback])) {
                $response = [
                    'status' => true,
                    'message' => 'Postback Updated Updated successfully',
                    'data' => []
                ];
            }


        } else {
            if (Postback::insert(['link' => $request->postback, 'publisher_id' => Auth::guard('publisher')->id()])) {
                $response = [
                    'status' => true,
                    'message' => 'Publisher Image Updated successfully',
                    'data' => []
                ];
            }

        }
        return response()->json($response);
    }

    public function OfferApi()
    {
        return view('publisher.api_offer');
    }

    public function PaymentHistory()
    {
        $id = Auth::guard('publisher')->id();

        $date = date('Y-m-01 00:00:00');
        $qry = Publisher_transaction::where('publisher_id', '=', $id)->sum('amount');
        $phistoy = Cashout_request::where('affliate_id', $id)->get()->append('statustext');
        return view('publisher.payment_history', compact('qry', 'phistoy'));
    }

    public function search_offer_dashboard(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $all_offer = Offer::where('offer_name', 'LIKE', '%' . $request->text . '%')->get();
        $response = [
            'status' => true,
            'message' => 'Message send successfully',
            'data' => view('publisher.layout.offer_search', compact('all_offer'))->render()
        ];
        return response()->json($response);
    }
}
