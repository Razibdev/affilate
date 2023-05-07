<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Support\Google2FAAuthenticator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin;
use App\Models\Login_history;
use App\Models\Offers_publisher;
use App\Models\Approval_request;
use App\Models\Publisher;
use App\Models\Affliate;
use App\Models\Advertiser;
use App\Models\Payment_method;
use App\Models\Offer_process;
use App\Models\Offer;
use Illuminate\Support\Carbon;
use App\Models\Site_setting;
use App\Models\Countrie;
use App\Models\Site_category;
use App\Models\Domain;
use App\Models\Smartlink_domain;
use App\Models\Smartlink;
use App\Models\admin_securitie;
use App\Models\Category;
use App\Models\News_and_announcement;
use App\Models\Notification;
use App\Models\Ban_ip;
use App\Models\Message;
use App\Models\Postback_recieve;
use App\Models\Postback;
use App\Models\Ranking;
use App\Models\Affliate_transaction;
use App\Models\Publisher_transaction;
use App\Models\Cashout_request;
use App\Models\Postback_sent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;


class AdminController extends Controller
{

    public function __construct()
    {

        // if (empty(Auth()->guard('admin')->user()->name)) {
        //     return abort(404);
        // }
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
        if(Admin::where('id', Auth::guard('admin')->id())->update($data)){
            $response = [
                'status' => true,
                'message' => 'Password Updated successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }



    public function ViewOffer()
    {
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        return view('admin.offer.view_offers', compact('country_list'));
    }

    public function ViewOfferReport(Request $request){
        $offer = Offer::with('lead_count', 'click_count', 'unique_click')->get();
        if($request->isMethod('post')){
            if($request->from_date != null && $request->to_date){
                $offer = Offer::whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->with('lead_count', 'click_count', 'unique_click')->get();
            }else{
                $offer = Offer::with('lead_count', 'click_count', 'unique_click')->get();
            }
        }
        return view('admin.offer.view_offer_report', compact('offer'));

    }
   public function ViewOfferSingle(){
//        $offer = Offer::with('lead_count', 'click_count', 'unique_click')->get();
//        if($request->isMethod('post')){
//            if($request->from_date != null && $request->to_date){
//                $offer = Offer::whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->with('lead_count', 'click_count', 'unique_click')->get();
//            }else{
//                $offer = Offer::with('lead_count', 'click_count', 'unique_click')->get();
//            }
//        }

//       return 'ok';


        $offer = Offer_process::get()->groupBy('offer_id');
//        dump($offer);
        return view('admin.offer.view_offer_report_single', compact('offer'));

    }


    public function ApprovalRequest()
    {

        $qry = Approval_request::orderby('id', 'desc')->paginate(10);
        $qry->append('publisher1')->append('offer')->append('action');
        return view('admin.offer.approval_request', compact('qry'));
    }
    public function ShowApprovalRequest(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Approval_request::select('*');




        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('publisher1');
        $category->each->append('date');
        $category->each->append('offer');
        $category->each->append('action');


        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_site_category,
            'recordsFiltered' => $total_site_category,
            'data' => $category,
        );
        return response()->json($data);
    }
    public function AddOffer()
    {
        $advertizer = Advertiser::get()->all();
        $publisher = Publisher::where('status', 'Active')->get();
        $domain = Smartlink_domain::get()->all();
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $category = Category::get()->all();
        return view('admin.offer.add_offer', compact('advertizer', 'domain', 'country_list', 'category', 'publisher'));
    }
    public function edit_offer(Request $request, $id)
    {
        $advertizer = Advertiser::get()->all();
        $publisher = Publisher::where('status', 'Active')->get();
        $country_list = Countrie::select('country_name', 'phonecode')->get()->all();
        $category = Category::get()->all();
        $offer = Offer::where('id', $id)->first();
        return view('admin.offer.edit_offer', compact('offer', 'advertizer', 'country_list', 'category', 'publisher'));
    }
    public function showOffer(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Offer::select('*');
        if (isset($request->offer_name) && !empty($request->offer_name)) {
            $pages_query->where('offer_name', 'like', '%' . $request->offer_name . '%');
        }
        if (isset($request->countries) && !empty($request->countries)) {
            $pages_query->where('countries', 'like', '%' . $request->countries . '%');
        }
        if (isset($request->ua_target) && !empty($request->ua_target)) {
            $pages_query->where('ua_target', 'like', '%' . $request->ua_target . '%');
        }
        if (isset($request->traffic) && !empty($request->traffic)) {
            if($request->traffic=='smartlink'){

                $pages_query->where('smartlink', '=', '1');
            }
        }
        if (isset($request->offer_id) && !empty($request->offer_id)) {
            $pages_query->where('id', $request->offer_id);
        }
        if (isset($request->status) && !empty($request->status)) {
            $pages_query->where('status', $request->status);
        }
        if (isset($request->offer_type) && !empty($request->offer_type)) {
            $pages_query->where('offer_type', $request->offer_type);
        }

        $pages_query->with('category');

        // $pages_query->addSelect(DB::raw("SUBSTRING('description', 0, 1000) as dsd"));
        //search
        if (!empty($search)) {
            $pages_query->where('offer_name', 'like', '%' . $search . '%');
            $pages_query->orWhere('advertiser_id', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $pages_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $pages_query->orderBy('offer_name', $sort_direction);
        } elseif ($sort_by == 2) {
            $pages_query->orderBy('advertiser_id', $sort_direction);
        } elseif ($sort_by == 3) {
            $pages_query->orderBy('status', $sort_direction);
        }

        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->get();
        $pages->each->append('action');
        $pages->each->append('smartlinkstatus');
        $pages->each->append('date');

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
    public function UpdateOffer(Request $request)
    {
        $imageName = '';
        $icon_url = '';

        if ($request->preview_link != '') {
            $validator = Validator::make($request->all(), [
                'preview_link' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            @unlink('uploads/' . $request->hidden_preview_image);
            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('preview_link')->getClientOriginalExtension();
            $request->file('preview_link')->move('uploads', $imageName);
        } else {
            $imageName = $request->hidden_preview_image;
        }

        if ($request->icon_url != '') {
            $validator = Validator::make($request->all(), [
                'icon_url' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }
            @unlink('uploads/' . $request->hidden_icon_image);
            $icon_url = mt_rand(1, 1000) . '' . time() . '.' . $request->file('icon_url')->getClientOriginalExtension();
            $request->file('icon_url')->move('uploads', $icon_url);
        } else {
            $icon_url = $request->hidden_icon_image;
        }

        // print_r($request->all());die;

        $data = array(
            'offer_name' => $request->offer_name,
            'advertiser_id' => $request->advertiser_id,
            'offer_type' => $request->offer_type,
            'verticals' => $request->verticals,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'link' => $request->link,
            'secondary_link' => $request->secondary_link,
            'browsers' => implode('|', $request->browser),
            'lead_qty' => $request->lead_qty,
            'payout' => $request->payout_amount,
            'countries' => implode('|', $request->countries),
            'ua_target' => implode('|', $request->ua_target),
            'status' => $request->status,
            'clicks' => $request->clicks,
            'conversion' => $request->conversion,
            'featured_offer' => $request->featured == null ? 0 : 1,
            'incentive_allowed' => $request->incentive == null ? 0 : 1,
            'smartlink' => $request->smartlink == null ? 0 : 1,
            'magiclink' => $request->magiclink == null ? 0 : 1,
            'lockers' => $request->lockers == null ? 0 : 1,
            'native' => $request->native == null ? 0 : 1,
            'payout_type' => $request->payout
        );

        if($request->icon_url!=''){
            $data['icon_url'] = $icon_url;
        }
        if ($request->preview_link != '') {
            $data['preview_url'] = $imageName;
        }
        if (isset($request->payout_percentage) && !empty($request->payout_percentage)) {
            $data['payout_percentage'] = $request->payout_percentage;
        }


        Offer::where('id', $request->id)->update($data);


        return redirect()->back()->with('success', 'Offer Updated Successfully');
    }

    public function DeleteOffer(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $offer = Offer::where('id', $request->id)->first();
        if (!empty($offer)) {
            @unlink('uploads/' . $offer->hidden_preview_image);
            @unlink('uploads/' . $offer->hidden_icon_image);
        }
        if (Offer::where('id', $offer->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Offer deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertOffer(Request $request)
    {
        $imageName = '';
        $icon_url = '';

        if ($request->preview_link != '') {

            $validator = Validator::make($request->all(), [
                'preview_link' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('preview_link')->getClientOriginalExtension();
            $request->file('preview_link')->move('uploads', $imageName);
        }

        if ($request->icon_url != '') {
            $validator = Validator::make($request->all(), [
                'icon_url' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }
            $icon_url = mt_rand(1, 1000) . '' . time() . '.' . $request->file('icon_url')->getClientOriginalExtension();
            $request->file('icon_url')->move('uploads', $icon_url);
        }


        $site = Site_setting::first();
        if ($request->payout_percentage == '') {
            $percentage = $site->payout_percentage;
        } else {
            $percentage = $request->payout_percentage;
        }


        $data = array(
            'offer_name' => $request->offer_name,
            'advertiser_id' => $request->advertiser_id,
            'offer_type' => $request->offer_type,
            'verticals' => $request->verticals,
            // 'tracking_domain_id' => $request->tracking_domain_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'link' => $request->link,
            'secondary_link' => $request->secondary_link,
            'preview_url' => $imageName,
            'preview_link' => $request->preview_url,
            'payout_percentage' => $percentage,
            'icon_url' => $icon_url,
            'lead_qty' => $request->lead_qty,
            'payout' => $request->payout_amount,
            'countries' => implode('|', $request->countries),
            'ua_target' => implode('|', $request->ua_target),
            'browsers' => implode('|', $request->browser),
            'status' => $request->status,
            'conversion' => $request->conversion,
            'featured_offer' => $request->featured_offer == null ? 0 : 1,
            'incentive_allowed' => $request->incentive == null ? 0 : 1,
            'smartlink' => $request->smartlink == null ? 0 : 1,
            'magiclink' => $request->magiclink == null ? 0 : 1,
            'lockers' => $request->lockers == null ? 0 : 1,
            'native' => $request->native == null ? 0 : 1,
            'payout_type' => $request->payout,
            'leads' => 0,
            'clicks' => 0,
            'maximum_lead'=> $request->maximum_lead,
            'redirection_link'=>  $request->redirection_link
        );
        $offer = Offer::create($data);
        $id = $offer->id;
        if ($request->offer_type == 'special') {
            foreach ($request->publishers as $p) {
                Offers_publisher::create(['publisher_id' => $p, 'offer_id' => $id]);
            }
        }
        return redirect()->back()->with('success', 'Offer Created Successfully');
    }
    public function Showdashboard(Request $request)
    {

        if (empty(Auth::guard('admin')->user()->name)) {
            return redirect('/admin/login');
        }
        if (isset($request->from_date) && !empty($request->from_date) && isset($request->to_date) && !empty($request->to_date)) {
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
            $to_date = Carbon::parse($request->to_date)->format('Y-m-d H:i:s');
        } else {
            $from_date = date('Y-m-d 00:00:00');
            $to_date = date('Y-m-d 23:59:59');
        }
        $total_pub = Publisher::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_advirter = Advertiser::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_aff = Affliate::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_offers = Offer::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_leads = Offer_process::where('status', 'Approved')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_clicks = Offer_process::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_unique_clicks = Offer_process::where('unique_', 1)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_publisher_earnings = Publisher_transaction::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
        $total_vpn_clicks = Publisher::sum('vpn_clicks');
        $total_affliate_earning = Affliate_transaction::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
        $total_admin_earnings = Offer_process::where('status', 'Approved')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('admin_earned');
        $total_paid_amount = Cashout_request::where('status', 'Completed')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->sum('amount');
        $total_smartlinks = Smartlink::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_messages = Message::where('sender', '!=', 'admin')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_pending_withdraw = Cashout_request::where('status', 'Pending')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_pending_offer_process = Offer_process::where('status', 'Pending')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_approved_offer_process = Offer_process::where('status', 'Approved')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_smartlink_domains = Smartlink_domain::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_waiting_offer_process = Offer_process::whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->where('status', 'Awaited')->count();
        // $total_locked_payments = DB::table('cashout_request')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->where('status', 'Locked')->count();
        $total_pending_smartlink = Smartlink::where('enabled', '0')->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
        $total_pending_offer_request = Approval_request::where('approval_status', 'Requested')->whereBetween('created_at', [$from_date, $to_date])->count();
        // $top_10_offers = DB::select("SELECT  o.offer_name,o.payout,op.offer_id,o.icon_url,count(op.id) as leads FROM `offers` as o join offer_process as op on op.offer_id=o.id where op.status='Approved' group by op.offer_id order by (select count(id) from offer_process where offer_id=op.offer_id and status='Approved') desc limit 10");
        $month = date('Y-m-01 00:00:00');
        $site = Site_setting::first();
        // $top_10_members = DB::select("SELECT (DENSE_RANK() OVER(ORDER BY sum(r.earnings) DESC )) as rank  ,r.publisher_id,sum(r.earnings) as earnings,p.publisher_image,sum(r.lead) as leads,p.name,sum(r.clicks) as clicks,(select sum(earnings) from ranking where publisher_id=p.id) as total_earnings,(select sum(lead) from ranking where publisher_id=p.id) as total_leads,p.total_earnings as publisher_earnings FROM ranking as r,publishers as p where r.created_at>='$month' and p.id=r.publisher_id  group by r.publisher_id order by rank ");
        $waiting_offer_amount = Offer_process::where('status', 'Awaited')->sum('payout');
        $total_affliate = Affliate::count();


        $top_10_offers = Offer::selectRaw('offers.offer_name,offers.payout,offer_process.offer_id,offers.icon_url,count(offer_process.id) as leads')->join('offer_process', 'offer_process.offer_id', 'offers.id')->join('publishers', 'publishers.id', 'offer_process.publisher_id')->where('offer_process.status', 'Approved')->groupBy('offers.id')->orderBy('offers.payout', 'desc')->limit(5)->get()->append('leadscount');

        $top_10_members = Publisher::selectRaw('ranking.publisher_id,sum(ranking.earnings) as earnings,sum(ranking.lead) as leads,publishers.name as name,publishers.total_earnings as publisher_earnings')->join('ranking', 'ranking.publisher_id', 'publishers.id')->groupBy('ranking.publisher_id')->orderBy('earnings', 'desc')->get()->append('photourl');
        $top_10_affliate = Affliate::orderby('total_earnings', 'desc')->get()->append('photourl');
        $top_10_advertiser = Advertiser::selectRaw('*,(SELECT COUNT(id) FROM offer_process  as op WHERE op.status="Approved" and op.advertiser_id=advertisers.id) as total_leads ')->orderby('total_leads', 'desc')->get()->append('photourl');
        $top_countrie = Countrie::selectRaw('countries.nicename, countries.phonecode,(SELECT COUNT(*) FROM offer_process Where  offer_process.country=countries.country_name AND source="smartlink") as leads,(SELECT COUNT(*) FROM offer_process Where offer_process.country=countries.nicename  AND source!="smartlink") as click ')->orderBy('leads', 'desc')->orderBy('click', 'desc')->limit(10)->get();
        //->append('totalclick')->append('totalleads');


        $top_browsers = Offer_process::selectRaw('browser,count(*) as `count`')->where('status', 'Approved')->groupBy('browser')->limit(5)->get();
        $top_devices = Offer_process::selectRaw('ua_target,count(*) as `count`')->where('status', 'Approved')->groupBy('ua_target')->limit(5)->get();


        if (empty(Auth()->guard('admin')->user()->name)) {
            return abort(404);
        }
        return view('admin/dashboard')->with(['from_date' => $from_date, 'site' => $site, 'top_10_affliate' => $top_10_affliate, 'top_10_members' => $top_10_members, 'top_10_advertiser' => $top_10_advertiser, 'top_10_offers' => $top_10_offers, 'top_countrie' => $top_countrie, 'total_paid_amount' => $total_paid_amount, 'total_pending_withdraw' => $total_pending_withdraw, 'to_date' => $to_date, 'total_pub' => $total_pub, 'total_aff' => $total_aff, 'total_advirter' => $total_advirter, 'total_offers' => $total_offers, 'total_leads' => $total_leads, 'total_clicks' => $total_clicks, 'total_unique_clicks' => $total_unique_clicks, 'total_publisher_earnings' => $total_publisher_earnings, 'total_vpn_clicks' => $total_vpn_clicks, 'total_admin_earnings' => $total_admin_earnings, 'total_smartlinks' => $total_smartlinks, 'total_messages' => $total_messages, 'total_pending_offer_process' => $total_pending_offer_process, 'total_approved_offer_process' => $total_approved_offer_process, 'total_smartlink_domains' => $total_smartlink_domains, 'total_waiting_offer_process' => $total_waiting_offer_process, 'total_pending_smartlink' => $total_pending_smartlink, 'total_pending_offer_request' => $total_pending_offer_request, 'waiting_offer_amount' => $waiting_offer_amount, 'total_affliate' => $total_affliate, 'month' => $month, 'total_affliate_earning' => $total_affliate_earning,'top_browsers'=>$top_browsers,'top_devices'=>$top_devices]);
    }
    public function showsettings()
    {
        $data = Site_setting::first();
        $smartlinks = Smartlink_domain::get();
        $affliates = Affliate::get();
        return view('admin/settings', compact('data', 'smartlinks', 'affliates'));
    }


    public function ManageCategory()
    {
        return view('admin.category.Manage_Categories');
    }
    public function Managepayment()
    {
        return view('admin.Manage_payment');
    }
    public function ShowCategory(Request $request)
    {
        // $data = Site_category::get()->all();
        // return response()->json($data);
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Category::select('*');
        //search
        if (!empty($search)) {
            $category_query->where('category_name', 'like', '%' . $search . '%');
        }
        // //sorting
        // if ($sort_by == 0) {
        //     $category_query->orderBy('id', $sort_direction);
        // } elseif ($sort_by == 1) {
        //     $category_query->orderBy('category_name', $sort_direction);
        // } elseif ($sort_by == 2) {
        //     $category_query->orderBy('created_at', $sort_direction);
        // }

        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
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

    public function DeleteCategory(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Category::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Category deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function get_edit_data(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data= Payment_method::where('id', $request->id)->first()->append('photo');
        if(!empty($data)) {
            $response = [
                'status' => true,
                'data' => $data
            ];
        }
        return response()->json($response);
    }

    public function InsertCategory(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'Categories_name' => 'required'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'category_name' => $request->Categories_name,
        );
        $exist = Category::where('category_name', $request->Categories_name)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' =>  $exist
            ];
            return response()->json($response);
        }
        if (Category::create($data)) {
            $response = [
                'status' => true,
                'message' => 'Site Category add successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function ShowPayment(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Payment_method::select('*');


        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
        $category->each->append('photo');
        // $category->each->append('sponsor');

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_site_category,
            'recordsFiltered' => $total_site_category,
            'data' => $category,
        );
        return response()->json($data);
    }
    public function update_payment(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'edit_title' => 'required',
            'edit_id' => 'required'
        ]);
        $imageName = '';
        $payment= Payment_method::where('id',$request->edit_id)->first();
        if ($request->image != '') {

            $validator = Validator::make($request->all(), [
                'image' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                // die('aaaaaa');
                $response = [
                    'status' => false,
                    'message' => 'Upload .jpg File Only',
                    'data' => []
                ];
                return response()->json($response);
            }

            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move('uploads', $imageName);
            @unlink('uploads/' . $payment->image);
        }
        if(empty($imageName)){
        $data = array(
            'name' => $request->edit_title,
        );
    }else{
            $data = array(
                'name' => $request->edit_title,
                'image' => $imageName,
            );
    }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Payment_method::where('id', $request->edit_id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Payment method Updated Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function Insertpayment_method(Request $request)
    {


        $this->validate($request, [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $imageName='';
        if ($request->image != '') {
            $validator = Validator::make($request->all(), [
                'image' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                $response = [
                    'status' => false,
                    'message' => 'Upload .jpg File Only',
                    'data' => []
                ];
                return response()->json($response);
                // return redirect()->back()->with('error', 'Upload .jpg File Only');
            }
        $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move('uploads', $imageName);
        }else{
            $response = [
                'status' => false,
                'message' => 'Image could not be empty',
                'data' => []
            ];
            return response()->json($response);
        }
        $data = array(
            'name' => $request->name,
            'image' => $imageName,
        );
        $exist = Payment_method::where('name', $request->name)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' =>  $exist
            ];
            return response()->json($response);
        }
        if (Payment_method::create($data)) {
            $response = [
                'status' => true,
                'message' => 'Payment Method  add successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function deletepayment(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $payment = Payment_method::where('id', $request->id)->first();
        @unlink('uploads/' . $payment->image);
        if (Payment_method::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Payment method deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function UpdateCategory(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'Categories_name' => 'required',
            'id' => 'required'
        ]);
        $data = array(
            'category_name' => $request->Categories_name,
        );
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Category::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Category Updated Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }




    public function ManageSiteCategory()
    {
        return view('admin.category.Manage_Site_Categories');
    }
    public function ShowSiteCategory(Request $request)
    {
        // $data = Site_category::get()->all();
        // return response()->json($data);
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Site_category::select('*');
        //search
        if (!empty($search)) {
            $category_query->where('site_category_name', 'like', '%' . $search . '%');
        }
        // //sorting
        // if ($sort_by == 0) {
        //     $category_query->orderBy('id', $sort_direction);
        // } elseif ($sort_by == 1) {
        //     $category_query->orderBy('site_category_name', $sort_direction);
        // } elseif ($sort_by == 2) {
        //     $category_query->orderBy('created_at', $sort_direction);
        // }

        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
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
    public function EditSiteCategory(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'Categories_name' => 'required/unique:site_category,site_category_name',
            'id' => 'required'
        ]);
        $data = array(
            'site_category_name' => $request->Categories_name,
        );
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Site_category::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Site Category Updated Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function DeleteSiteCategory(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Site_category::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Category deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertSiteCategory(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'Categories_name' => 'required'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'site_category_name' => $request->Categories_name,
        );
        $exist = Site_category::where('site_category_name', $request->Categories_name)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' =>  $exist
            ];
            return response()->json($response);
        }
        if (Site_category::create($data)) {
            $response = [
                'status' => true,
                'message' => 'Site Category add successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function UpdateSiteCategory(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'Categories_name' => 'required',
            'id' => 'required'
        ]);
        $data = array(
            'site_category_name' => $request->Categories_name,
        );
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Site_category::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Site Category Updated Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }

    public function ManageDomain()
    {
        return view('admin.domain.Manage_Domain');
    }
    public function ShowDomain(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Domain::select('*');
        //search
        if (!empty($search)) {
            $category_query->where('domain_name', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $category_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $category_query->orderBy('domain_name', $sort_direction);
        } elseif ($sort_by == 2) {
            $category_query->orderBy('created_at', $sort_direction);
        }

        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->get();
        $category->each->append('action');
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

    public function DeleteDomain(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Domain::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Traking Domain deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertDomain(Request $request)
    {

        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'domain_name' => 'required'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'domain_name' => $request->domain_name,
        );
        $exist = Domain::where('domain_name', $request->domain_name)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' =>  $exist
            ];
            return response()->json($response);
        }
        if (Domain::create($data)) {
            $response = [
                'status' => true,
                'message' => 'Traking Domain  add successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function UpdateDomain(Request $request)
    {

        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'domain_name1' => 'required',
            'id' => 'required'
        ]);
        $exist = Domain::where('domain_name', $request->domain_name1)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' =>  $exist
            ];
            return response()->json($response);
        }
        $data = array(
            'domain_name' => $request->domain_name1,
        );
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Domain::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Traking Domain Updated Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }










    public function ShowSmartlinkRequest(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Smartlink::select('*')->where('enabled', 2)->with('publisher')->with('category');
        //search
        if (!empty($search)) {
            $category_query->where('url', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $category_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $category_query->orderBy('name', $sort_direction);
        } elseif ($sort_by == 2) {
            $category_query->orderBy('created_at', $sort_direction);
        }

        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->get();
        $category->each->append('action');
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


    public function ManageSmartlinkDomain()
    {
        return view('admin.domain.Manage_Smartlink_Domain');
    }
    public function ManageSmartlinkRequest()
    {
        return view('admin.smartlink.Manage_Smartlink_Request');
    }

    public function ShowSmartlinkDomain(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Smartlink_domain::select('*');
        //search
        if (!empty($search)) {
            $category_query->where('url', 'like', '%' . $search . '%');
        }
        //sorting


        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderBy('id', 'desc')->get();
        $category->each->append('action');
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

    public function DeleteSmartlinkDomain(Request $request)
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
                'message' => 'Traking Domain deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertSmartlinkDomain(Request $request)
    {

        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'domain_name' => 'required'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'url' => $request->domain_name,
        );
        $exist = Smartlink_domain::where('url', $request->domain_name)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' =>  $exist
            ];
            return response()->json($response);
        }
        if (Smartlink_domain::create($data)) {
            $response = [
                'status' => true,
                'message' => 'Traking Domain  add successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function UpdateSmartlinkDomain(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'domain_name1' => 'required',
            'id' => 'required'
        ]);
        $exist = Smartlink_domain::where('url', $request->domain_name)->first();
        if (!empty($exist)) {
            $response = [
                'status' => false,
                'message' => 'Data is already exist',
                'data' =>  $exist
            ];
            return response()->json($response);
        }
        $data = array(
            'url' => $request->domain_name1,
        );
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Smartlink_domain::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Traking Domain Updated Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
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

        $id = $request->id;
        Smartlink::where('id', $id)->update(['enabled' => '1']);
        $ap = Smartlink::where('id', $id)->first();

        $publisher = Publisher::where('id', $ap->publisher_id)->first();

        // $data = array('message' => '', 'subject' => 'Your Smartlink  has been Approved', 'email' => $publisher->email, 'smartlink_name' => $ap->name, 'id' => $ap->id, 'status' => 'Approved', 'name' => $publisher->name, 'url' => $ap->url);

        $response = [
            'status' => true,
            'message' => 'Your Smartlink  has been Approved',
            'data' => []
        ];

        return response()->json($response);
        // $smtp_server = Site_setting::find(1);
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

        $id = $request->id;

        Smartlink::where('id', $id)->update(['enabled' => '2']);

        $response = [
            'status' => true,
            'message' => 'Your Smartlink  has been Rejected',
            'data' => []
        ];
        return response()->json($response);
    }

    public function ManageNews()
    {
        return view('admin.Manage_News');
    }
    public function ShowNews(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = News_and_announcement::select('*');
        //search
        // if (!empty($search)) {
        //     $category_query->where('title', 'like', '%' . $search . '%');
        // }
        //sorting
        // if ($sort_by == 0) {
        //     $category_query->orderBy('id', $sort_direction);
        // } elseif ($sort_by == 1) {
        //     $category_query->orderBy('title', $sort_direction);
        // }

        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
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

    public function DeleteNews(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }


        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (News_and_announcement::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Announcement Deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertNews(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'title' => $request->title,
            'description' => $request->description,
        );
        $news = News_and_announcement::create($data);
        $id = $news->id;
        $pub = Publisher::get();
        foreach ($pub as $p) {
            $data = array(
                'news_id' => $id,
                'publisher_id' => $p->id,
                'is_read' => 0
            );
            Notification::create($data);
            $response = [
                'status' => true,
                'message' => 'Your Annoncement  has been created',
                'data' => []
            ];
        }

        return response()->json($response);
    }
    public function UpdateNews(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'edit_title' => 'required',
            'edit_description' => 'required'
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'title' => $request->edit_title,
            'description' => $request->edit_description,
        );

        if (News_and_announcement::where('id', $request->edit_id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Announcement Updated successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }




    public function ManageBanIp()
    {
        return view('admin.Manage_Ban_Ip');
    }
    public function ShowBanIp(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Ban_ip::select('*');
        //search
        if (!empty($search)) {
            $category_query->where('ip_address', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $category_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $category_query->orderBy('ip_address', $sort_direction);
        }

        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
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


    public function DeleteBanIp(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Ban_ip::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'IP Deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertBanIp(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'ip_address' => 'required',
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'ip_address' => $request->ip_address
        );

        if (Ban_ip::create($data)) {
            $response = [
                'status' => true,
                'message' => 'IP Banned Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function UpdateBanIp(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $this->validate($request, [
            'edit_ip_address' => 'required',
        ]);
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $data = array(
            'ip_address' => $request->edit_ip_address,
        );

        if (Ban_ip::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'IP Updated successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }



    public function Messages($reply = '')
    {
        $publisher = Publisher::get();
        return view('admin.Messages', compact('publisher'))->with('reply', $reply);
    }
    public function show_Messages(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Message::select('*');
        //search



        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
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
        $message = Message::where('id', $id)->first();
        return view('admin.view_message', compact('message'), ['id' => $id]);
    }


    public function SendMessage(Request $request)
    {
        $imagenid = '';
        if ($request->screenshot != '') {

            $validator = Validator::make($request->all(), [
                'screenshot' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            $imagenid = mt_rand(1, 1000) . '' . time() . '.' . $request->file('screenshot')->getClientOriginalExtension();
            $request->file('screenshot')->move('screenshot', $imagenid);
        }
        $publisher = Publisher::get();
        foreach ($publisher as $p) {
            # code...


            $data = array(
                'sender' => 'admin',
                'receiver' => $p->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'screenshot' => $imagenid,
                'is_read' => 0
            );
            Message::create($data);
            $pub = Publisher::where('email', $p->email)->first();
            $data = array('message' => $request->message, 'subject' => $request->subject, 'email' => $p->email, 'name' => $pub->name);

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

                Mail::send('emails.AdminMessages', ['data' => $data,'setting'=>$smtp_server], function ($message) use ($data) {
                    $smtp_server = Site_setting::find(1);
                    $message->from($smtp_server->from_email, $smtp_server->from_name);
                    $message->to($data['email'], $data['name'])->subject($data['subject']);
                });
            } catch (\Exception $e) {
            }
        }
        return redirect()->back()->with('success', 'Message Send Successfully');
    }
    public function Updatedetails(Request $request){

        // echo Hash::make('12345654321'); die;
        // print_r($request->all());
        // die;
        $imageName = '';
        if ($request->photo != '') {

            $validator = Validator::make($request->all(), [
                'photo' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                // die('aaaaaa');
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            @unlink('site_images/' . $request->hidden_photo);
            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('site_images', $imageName);
        } else {
            $imageName = $request->hidden_photo;
        }
        $data=array(
            'name'=>$request->name,
            'email'=>$request->email,
            'photo'=> $imageName,
        );
         Admin::where('id',$request->id)->update($data);
        return redirect()->back()->with('success', 'Admin Details Updated Successfully');
    }
    public function  UpdateSettings(Request $request)
    {

        $imageName = '';
        if ($request->logo != '') {
            $validator = Validator::make($request->all(), [
                'logo' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }

            @unlink('site_images/' . $request->hidden_logo);
            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move('site_images', $imageName);
        } else {
            $imageName = $request->hidden_logo;
        }

        $icon = '';
        if ($request->icon != '') {
            $validator = Validator::make($request->all(), [
                'icon' => ['required','mimes:jpg']
            ]);
            if ($validator->fails()){
                return redirect()->back()->with('error', 'Upload .jpg File Only');
            }
            @unlink('site_images/' . $request->hidden_icon);
            $icon = mt_rand(1, 1000) . '' . time() . '.' . $request->file('icon')->getClientOriginalExtension();
            $request->file('icon')->move('site_images', $icon);
        } else {
            $icon = $request->hidden_icon;
        }


        if ($request->vpn_check == 'yes') {
            $vpn_api = $request->vpn_api;
            $vpn_limit = $request->vpn_click_limit;
        } else {
           $vpn_api = $request->vpn_api;
            $vpn_limit = $request->vpn_click_limit;
        }

        $data = array(
            'auto_signup' => $request->auto_signup,
            'minimum_withdraw_amount' => $request->minimum_withdraw_amount,
            'payout_percentage' => $request->payout_percentage,
            'default_affliate_manager' => $request->affliate_manager,
            'affliate_manager_salary_percentage' => $request->affliate_percentage,
            'default_payment_terms' => $request->default_payment_terms,
            'logo' => $imageName,
            'icon' => $icon,
            'vpn_check' => $request->vpn_check,
            'vpn_click_limit' => $vpn_limit,
            'vpn_api' => $vpn_api,

            'smtp_host' => $request->smtp_host,
            'smtp_port' => $request->smtp_port,
            'smtp_user' => $request->smtp_user,
            'smtp_password' => $request->smtp_password,
            'smtp_enc' => $request->smtp_enc,
            'postback_password' => $request->postback_password,
            'from_email' => $request->from_email,
            'from_name' => $request->from_name,
            'site_description' => $request->site_description,
            'site_name' => $request->site_name,
        );
        Site_setting::where('id', 1)->update($data);
        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }
    public function ShowOfferProcess(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Offer_process::select('offer_process.*')->with('publisher')->with('advertiser')->join('publishers', 'publishers.id', 'offer_process.publisher_id');
        $category_query = $category_query->join('advertisers', 'advertisers.id', 'offer_process.advertiser_id');
        if (isset($request->publisher_name) && !empty($request->publisher_name)) {
            $category_query = $category_query->where('publishers.name', 'LIKE', '%' . $request->publisher_name . '%');
        }
        if (isset($request->publisher_email) && !empty($request->publisher_email)) {
            $category_query = $category_query->where('publishers.email', $request->publisher_email);
        }
        if (isset($request->advertiser_name) && !empty($request->advertiser_name)) {
            $category_query = $category_query->where('advertisers.advertiser_name', $request->advertiser_name);
        }
        if (isset($request->offer_name) && !empty($request->offer_name)) {
            $category_query = $category_query->where('offer_process.offer_name', 'LIKE', '%' . $request->offer_name . '%');
        }
        if (isset($request->offer_id) && !empty($request->offer_id)) {
            $category_query = $category_query->where('offer_process.offer_id', $request->offer_id);
        }
        if (isset($request->ip_address) && !empty($request->ip_address)) {
            $category_query = $category_query->where('offer_process.ip_address', $request->ip_address);
        }
        if (isset($request->country_list) && !empty($request->country_list)) {
            $country_list = explode(',', $request->country_list);
            $category_query = $category_query->whereIn('offer_process.country', $country_list);
        }
        if (isset($request->ua_target) && !empty($request->ua_target)) {
            $ua_target = explode(',', $request->ua_target);
            $category_query = $category_query->whereIn('offer_process.ua_target', $ua_target);
        }
        if (isset($request->browser) && !empty($request->browser)) {
            $browser = explode(',', $request->browser);
            $category_query = $category_query->whereIn('offer_process.browser', $browser);
        }



        if (isset($request->status_type) && !empty($request->status_type)) {
            if ($request->status_type == 'Pending') {
                $category_query = $category_query->where('offer_process.status', 'Pending');
            } else if ($request->status_type == 'Awaited') {
                $category_query = $category_query->where('offer_process.status', 'Awaited');
            } else if ($request->status_type == 'Approved') {
                $category_query = $category_query->where('offer_process.status', 'Approved');
            } else if ($request->status_type == 'Rejected') {
                $category_query = $category_query->where('offer_process.status', 'Rejected');
            }
        }
        if (isset($request->offer_type) && !empty($request->offer_type)) {
            if ($request->offer_type == 'smartlink') {
                $category_query = $category_query->where('offer_process.key_', '!=', null);
            } else {
                $category_query = $category_query->where('offer_process.key_', null);
            }
        }


        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('offer_process.id', 'desc')->get();

        $category->each->append('date');
        $category->each->append('checkbox');
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
    public function PendingOfferProcess()
    {
        $country = Countrie::get();
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Pending')->where('key_', null)->orderBy('id', 'desc')->paginate(10);

        return view('admin.offer_process.pending_offer_process', compact('offers', 'country'));
    }
    public function WaitOfferProcess()
    {
        $country = Countrie::get();
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Awaited')->where('key_', null)->orderBy('id', 'desc')->paginate(10);

        return view('admin.offer_process.wait_offer_process', compact('offers', 'country'));
    }
    public function ApproveOfferProcess()
    {

        $country = Countrie::get();
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Approved')->where('key_', null)->orderBy('id', 'desc')->paginate(10);

        return view('admin.offer_process.approve_offer_process', compact('offers', 'country'));
    }
    public function RejectOfferProcess()
    {
        $country = Countrie::get();
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Rejected')->where('key_', null)->orderBy('id', 'desc')->paginate(10);

        return view('admin.offer_process.rejected_offer_process', compact('offers', 'country'));
    }



    public function SmartlinkPendingProcess()
    {
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Pending')->where('key_', '!=', null)->orderBy('id', 'desc')->paginate(10);
        $country = Countrie::get();
        return view('admin.smartlink.smartlink_pending_process', compact('offers', 'country'));
    }


    public function SmartlinkApproveProcess()
    {
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Approved')->where('key_', '!=', null)->orderBy('id', 'desc')->paginate(10);
        $country = Countrie::get();

        return view('admin.smartlink.smartlink_approve_process', compact('offers', 'country'));
    }
    public function SmartlinkWaitedProcess()
    {
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Awaited')->where('key_', '!=', null)->orderBy('id', 'desc')->paginate(10);
        $country = Countrie::get();

        return view('admin.smartlink.smartlink_waited_process', compact('offers', 'country'));
    }

    public function SmartlinkRejectedProcess()
    {
        $offers = Offer_process::with('publisher')->with('advertiser')->where('status', 'Rejected')->where('key_', '!=', null)->orderBy('id', 'desc')->paginate(10);
        $country = Countrie::get();
        return view('admin.smartlink.smartlink_rejected_process', compact('offers', 'country'));
    }
    public function ManagePostback()
    {
        return view('admin.postback.Manage_Postback');
    }

    public function ManagePostbackLog()
    {
        $postbacks = Postback_sent::orderBy('id', 'desc')->paginate(10);
        return view('admin.postback.Postback_log', compact('postbacks'));
    }
    public function showPostbackLog(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Postback_sent::select('*');
        //search




        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->get();
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
    public function ManagePostbackLogRecieve()
    {
        $postbacks = Postback_recieve::orderBy('id', 'desc')->paginate(10);
        return view('admin.postback.Postback_log_Receive', compact('postbacks'));
    }
    public function showPostbackLogRecieve(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Postback_recieve::select('*');
        //search




        $total_site_category = $category_query->count();
        $category = $category_query->orderby('id','desc')->limit($length)->offset($start)->get();
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
    public function ApproveRequest(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }


        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $id = $request->id;
        $site = Site_setting::first();
        Approval_request::where('id', $id)->update(['approval_status' => 'Approved']);
        $ap = Approval_request::where('id', $id)->first();
        $offer = Offer::where('id', $ap->offer_id)->first();
        $publisher = Publisher::where('id', $ap->publisher_id)->first();

        $data = array(
            'message' => '', 'subject' => 'Your Offer Request No ' . $id . ' has been Approved', 'email' => $publisher->email, 'payout' => $offer->payout * $offer->payout_percentage * 100,
            'offer_name' => $offer->offer_name, 'offer_id' => $offer->id, 'status' => 'Approved', 'name' => $publisher->name
        );

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

        Mail::send('emails.approveofferrequest', ['data' => $data,'setting'=>$smtp_server], function ($message) use ($data) {

            $smtp_server = Site_setting::find(1);
            $message->from($smtp_server->from_email, $smtp_server->from_name);
            $message->to($data['email'], $data['name'])->subject($data['subject']);
        });

        $response = [
            'status' => true,
            'message' => 'Offer approved  Successfully',
            'data' => []
        ];

        return response()->json($response);
    }
    public function RejectRequest(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }


        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $id = $request->id;

        if (Approval_request::where('id', $id)->update(['approval_status' => 'Rejected'])) {
            $response = [
                'status' => true,
                'message' => 'Offer Rejected Successfully',
                'data' => []
            ];
        }

        return response()->json($response);
    }
    public function ApprovePendingOfferProcess(Request $request)
    {
        $site = Site_setting::first();

        foreach ($request->check as $c) {
            $qry = Offer_process::with('publisher')->with('advertiser')->where('id', $c)->first();
            if ($qry->status == 'Approved') {
                return 1;
            } else {
                Offer_process::where('id', $c)->update(['status' => 'Approved']);
                $offer = Offer::where('id', $qry->offer_id)->first();
                $publisher = Publisher::where('id', $qry->publisher_id)->first();
                $publisher_earnings = $qry->payout * $offer->payout_percentage / 100;
                Publisher::where('id', $qry->publisher_id)->increment('balance', $publisher_earnings);
                Publisher::where('id', $qry->publisher_id)->increment('total_earnings', $publisher_earnings);
                Offer::where('id', $qry->offer_id)->increment('leads', 1);
                if ($qry->key_ != null) {
                    Smartlink::where('key_', $qry->key_)->increment('earnings', $publisher_earnings);
                }
                $data = array(
                    'offer_process_id' => $qry->id,
                    'amount' => $publisher_earnings,
                    'publisher_id' => $qry->publisher_id
                );
                Publisher_transaction::create($data);
                $pub = Publisher::where('id', $qry->publisher_id)->first();
                if ($pub->affliate_manager_id != '') {
                    $affliate_earning = ($qry->payout * $site->affliate_manager_salary_percentage / 100);
                    $data1 = array(
                        'offer_process_id' => $qry->id,
                        'amount' => $affliate_earning,
                        'affliate_id' => $pub->affliate_manager_id
                    );
                    Affliate_transaction::create($data1);
                    Affliate::where('id', $pub->affliate_manager_id)->increment('balance', $affliate_earning);
                    Affliate::where('id', $pub->affliate_manager_id)->increment('total_earnings', $affliate_earning);
                }
                $data = array(
                    'publisher_id' => $qry->publisher_id,
                    'earnings' => $publisher_earnings,
                    'lead' => 1,
                );
                Ranking::create($data);
                $data = array('message' => '', 'subject' => 'Your Offer Process No ' . $c . ' has been Approved', 'email' => $publisher->email, 'hash' => $qry->code, 'payout' => $publisher_earnings, 'offer_name' => $qry->offer_name, 'ip_address' => $qry->ip_address, 'offer_id' => $qry->offer_id, 'status' => 'Approved', 'country' => $qry->country, 'device' => $qry->ua_target, 'name' => $publisher->name);
                $postback = Postback::where('publisher_id', $qry->publisher_id)->first();
                if ($postback != null) {
                    $offer_id = $qry->offer_id;
                    $offer_name = $qry->offer_name;
                    $status = '1';
                    $payout = $publisher_earnings;
                    $code = $qry->code;
                    $sid = $qry->sid;
                    $sid2 = $qry->sid2;
                    $sid3 = $qry->sid3;
                    $sid4 = $qry->sid4;
                    $sid5 = $qry->sid5;
                    $ip = $qry->ip_address;
                    $browser = $qry->browser;
                    $ua_target = $qry->ua_target;
                    $url = '';
                    $url = $postback->link;
                    $url = str_replace("{offer_id}", $offer_id, $url);
                    $url = str_replace("{status}", $status, $url);
                    $url = str_replace("{code}", $code, $url);
                    $url = str_replace("{payout}", $payout, $url);
                    $url = str_replace("{sid}", $sid, $url);
                    $url = str_replace("{sid2}", $sid2, $url);
                    $url =  str_replace("{sid3}", $sid3, $url);
                    $url =  str_replace("{sid4}", $sid4, $url);
                    $url =  str_replace("{sid5}", $sid5, $url);
                    $url =   str_replace("{ip_address}", $ip, $url);
                    $url =   str_replace("{offer_name}", $offer_name, $url);
                    $url =   str_replace("{ua_target}", $ua_target, $url);
                    $url =     str_replace("{browser}", $browser, $url);
                    $timeout = 5;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $data_post = array(
                        'publisher_id' => $qry->publisher_id,
                        'status' => 'Approved',
                        'payout' => $publisher_earnings,
                        'offer_id' => $qry->offer_id,
                        'url' => $url,
                    );
                    Postback_sent::create($data_post);
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
                Mail::send('emails.approveofferprocess', ['data' => $data,'setting'=>$smtp_server], function ($message) use ($data) {
                    $smtp_server = Site_setting::find(1);
                    $message->from($smtp_server->from_email, $smtp_server->from_name);
                    $message->to($data['email'], $data['name'])->subject($data['subject']);
                });
            }
        }
        return 1;
    }
    public function ApproveRejectOfferProcess(Request $request)
    {
        $site = Site_setting::first();
        foreach ($request->check as $c) {
            $qry = Offer_process::where('id', $c)->first();
            Offer_process::where('id', $c)->update(['status' => 'Rejected']);
            if ($qry->status == 'Rejected') {
                return 1;
            } else {
                $offer = Offer::where('id', $qry->offer_id)->first();
                $publisher = Publisher::where('id', $qry->publisher_id)->first();
                $publisher_earnings = $qry->payout * $offer->payout_percentage / 100;
                Publisher::where('id', $qry->publisher_id)->decrement('balance', $publisher_earnings);
                Publisher::where('id', $qry->publisher_id)->decrement('total_earnings', $publisher_earnings);
                Offer::where('id', $qry->offer_id)->decrement('leads', 1);
                //THIS IS FOR POSTBACK
                $postback = Postback::where('publisher_id', $qry->publisher_id)->first();
                if ($postback != null) {
                    $offer_id = $qry->offer_id;
                    $offer_name = $qry->offer_name;
                    $status = '2';
                    $payout = $publisher_earnings;
                    $code = $qry->code;
                    $sid = $qry->sid;
                    $sid2 = $qry->sid2;
                    $sid3 = $qry->sid3;
                    $sid4 = $qry->sid4;
                    $sid5 = $qry->sid5;
                    $ip = $qry->ip_address;
                    $browser = $qry->browser;
                    $ua_target = $qry->ua_target;
                    $url = '';
                    $url = $postback->link;
                    $url = str_replace("{offer_id}", $offer_id, $url);
                    $url = str_replace("{status}", $status, $url);
                    $url = str_replace("{code}", $code, $url);
                    $url = str_replace("{payout}", $payout, $url);
                    $url = str_replace("{sid}", $sid, $url);
                    $url = str_replace("{sid2}", $sid2, $url);
                    $url =  str_replace("{sid3}", $sid3, $url);
                    $url =  str_replace("{sid4}", $sid4, $url);
                    $url =  str_replace("{sid5}", $sid5, $url);
                    $url =   str_replace("{ip_address}", $ip, $url);
                    $url =   str_replace("{offer_name}", $offer_name, $url);
                    $url =   str_replace("{ua_target}", $ua_target, $url);
                    $url =     str_replace("{browser}", $browser, $url);
                    $timeout = 5;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $data_post = array(
                        'publisher_id' => $qry->publisher_id,
                        'status' => 'Rejected',
                        'payout' => $publisher_earnings,
                        'offer_id' => $qry->offer_id,
                        'url' => $url,
                    );
                    Postback_sent::create($data_post);
                }
                //END POSTBACK LOGIN
                //START SMARLINK LOGIC
                if ($qry->key_ != null) {
                    Smartlink::where('key_', $qry->key_)->decrement('earnings', $publisher_earnings);
                }
                //END SMARTLINK LOGIN
                //GOING TO PUBLISHER TRANSACTION TABLE
                $data = array(
                    'offer_process_id' => $qry->id,
                    'amount' => -1 * $publisher_earnings,
                    'publisher_id' => $qry->publisher_id
                );
                Publisher_transaction::create($data);
                $pub = Publisher::where('id', $qry->publisher_id)->first();
                //END PUB TABLE
                //GOING TO AFFLIATE TRANSACTION TABLE
                if ($pub->affliate_manager_id != '') {
                    $affliate_earning = ($qry->payout * $site->affliate_manager_salary_percentage / 100);
                    $data1 = array(
                        'offer_process_id' => $qry->id,
                        'amount' => -1 * $affliate_earning,
                        'affliate_id' => $pub->affliate_manager_id
                    );
                    Affliate_transaction::create($data1);
                    Affliate::where('id', $pub->affliate_manager_id)->decrement('balance', $affliate_earning);
                    Affliate::where('id', $pub->affliate_manager_id)->decrement('total_earnings', $affliate_earning);
                }
                //END GOUNG
                //GOING TO RANKING TABLE
                $data = array(
                    'publisher_id' => $qry->publisher_id,
                    'earnings' => -1 * $publisher_earnings,
                    'lead' => -1
                );
                Ranking::create($data);
            }
            //NOT GOING
        }
        return 1;
    }
    public function ApproveRejectOfferProcess1(Request $request)
    {
        Offer_process::whereIn('id', $request->check)->update(['status' => 'Rejected']);
        return 1;
    }
    public function deleteOfferProcess1(Request $request)
    {
        Offer_process::whereIn('id', $request->check)->where('status', '!=','Approved')->delete();
        return 1;
    }
    public function ApproveWaitOfferProcess(Request $request)
    {
        Offer_process::whereIn('id', $request->check)->update(['status' => 'Awaited']);
        return 1;
    }
    public function leadSearch(Request $request)
    {
        $country = Countrie::get();
        $query = Offer_process::select('*');

        if (isset($request->name)) {
            $query->where('offer_name', 'like', '%' . $request->offer_name . '%');
        }
        if (isset($request->offer_id)) {
            $query->where('offer_id', $request->offer_id);
        }
        if (isset($request->ip_address)) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        $browsers = $request->browser;
        if (isset($browsers)) {
            $query->where(function ($q) use ($browsers) {
                foreach ($browsers as $browser) {
                    $q->orWhere('browser', 'like', '%' . $browser . '%');
                }
            });
        }

        $query->where('status', $request->status);
        if ($request->smart_link != null) {
            $query->where('key_', '!=', null);
        } else {
            $query->where('key_', null);
        }


        $offers = $query->paginate('10');

        if ($request->status == 'Pending' && $request->smart_link == null) {
            return view('admin.offer_process.pending_offer_process', compact('offers', 'country'));
        }
        if ($request->status == 'Awaited' && $request->smart_link == null) {
            return view('admin.offer_process.wait_offer_process', compact('offers', 'country'));
        }
        if ($request->status == 'Approved' && $request->smart_link == null) {
            return view('admin.offer_process.approve_offer_process', compact('offers', 'country'));
        }
        if ($request->status == 'Rejected' && $request->smart_link == null) {
            return view('admin.offer_process.rejected_offer_process', compact('offers', 'country'));
        }


        if ($request->status == 'Pending' && $request->smart_link != null) {
            return view('admin.smartlink.smartlink_pending_process', compact('offers', 'country'));
        }
        if ($request->status == 'Awaited' && $request->smart_link != null) {
            return view('admin.smartlink.smartlink_waited_process', compact('offers', 'country'));
        }
        if ($request->status == 'Approved' && $request->smart_link != null) {
            return view('admin.smartlink.smartlink_approve_process', compact('offers', 'country'));
        }
        if ($request->status == 'Rejected' && $request->smart_link != null) {
            return view('admin.smartlink.smartlink_rejected_process', compact('offers', 'country'));
        }
    }
    public function offerDetails(Request $req)
    {
        $site = Site_setting::first();
        $qry = Offer::where('id', $req->id)->where('status', 'Active')->with('category')->first();
        return view('admin.offer.offer_detail', compact('site', 'qry'));
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
        if (isset($request->route) && $request->route == 'publisher') {
            $html = view('publisher.layout.offer_search', compact('all_offer'))->render();
        } else {
            $html = view('admin.layout.offer_search', compact('all_offer'))->render();
        }
        $response = [
            'status' => true,
            'message' => 'Message send successfully',
            'data' => $html
        ];
        return response()->json($response);
    }
}
