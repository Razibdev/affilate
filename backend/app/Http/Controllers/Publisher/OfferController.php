<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Publisher;
use App\Models\Domain;
use App\Models\Offer;
use App\Models\Site_setting;
use App\Models\Smartlink_domain;
use App\Models\Countrie;
use App\Models\Approval_request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function show_all_offers_type(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query =  Offer::select('offers.*')->where('is_deleted', null);
        if (isset($request->offer_page_name) && !empty($request->offer_page_name)) {
            if ($request->offer_page_name === 'all') {
                $category_query = $category_query->where('smartlink', 0)->where('magiclink', 0)->where('native', 0)->where('lockers', 0)->where('featured_offer', 0)->where('incentive_allowed', 0);
            } else if ($request->offer_page_name === 'new') {
                $category_query = $category_query->where('smartlink', 0)->where('magiclink', 0)->where('native', 0)->where('lockers', 0)->where('featured_offer', 0)->where('incentive_allowed', 0);
            } else if ($request->offer_page_name === 'top') {
                $category_query = $category_query->where('smartlink', 0)->where('magiclink', 0)->where('native', 0)->where('lockers', 0)->where('featured_offer', 0)->where('incentive_allowed', 0);
            } else if ($request->offer_page_name === 'my') {
                $category_query = $category_query->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', Auth::guard('publisher')->id())->where('approval_request.approval_status', 'Approved')->where('offers.offer_type', 'private');
            }
        }

        if (isset($request->offer_name) && !empty($request->offer_name)) {
            $category_query = $category_query->where('offers.offer_name', 'LIKE', '%' . $request->offer_name . '%');
        }
        if (isset($request->offer_id) && !empty($request->offer_id)) {
            $category_query = $category_query->where('offers.id', $request->offer_id);
        }
        if (isset($request->o_type) && !empty($request->o_type)) {
            $category_query = $category_query->where('offers.offer_type', $request->o_type);
        }
        if (isset($request->from_payout) && !empty($request->from_payout) && isset($request->to_payout) && !empty($request->to_payout)) {
            $category_query = $category_query->where('offers.payout', '>=', $request->from_payout)->where('offers.payout', '<=', $request->to_payout);
        }
        $category_query = $category_query->where(function ($query) use ($request) {
        if (isset($request->countries) && !empty($request->countries)) {
            $country_list = explode(',', $request->countries);
            foreach ($country_list as $key => $country) {
                
                    $query->orWhere('offers.countries', 'LIKE', '%'.$country.'%');
               
            }
        }
        });
        $category_query = $category_query->where(function ($query) use ($request) {
        if (isset($request->ua_target) && !empty($request->ua_target)) {
                $ua_target_list = explode(',', $request->ua_target);
            foreach ($ua_target_list as $key => $taget) {
                
                    $query->orWhere('offers.ua_target', 'LIKE', '%'. $taget.'%');
               
            }
        }
        });
        
        if (isset($request->category) && !empty($request->category)) {
            $category = explode(',', $request->category);
            $category_query = $category_query->whereIn('offers.category_id', $category);
        }





        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start);

        if ($request->offer_page_name === 'new') {
            $category = $category_query->orderby('offers.id', 'desc');
        } else if ($request->offer_page_name === 'top') {
            $category = $category_query->orderby('offers.leads', 'desc');
        }
        // DB::enableQueryLog();
        $category = $category_query->get();
        // dd(DB::getQueryLog());
        $category->each->append('offerimage');
        $category->each->append('offeraction');
        $category->each->append('payoutamount');
        $category->each->append('categoryvertics');
        $category->each->append('oferrevshere');
        $category->each->append('broweser');
        $category->each->append('device');
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
    public function PublicOffers()
    {

        if (Auth::guard('publisher')->user()->expert_mode === 1) {
            $offers = Offer::where('offer_type', 'public')->paginate(10);
            $site = Site_setting::first();
            $country = Countrie::get();
            $category = Category::get();
            return view('publisher.offer.public_offer', compact('offers', 'site', 'country', 'category'));
        } else {
            return redirect('/publisher');
        }
    }
    public function PrivateOffers()
    {
        if (Auth::guard('publisher')->user()->expert_mode == 1) {
            $offers = Offer::where('offer_type', 'private')->paginate(10);
            $site = Site_setting::first();
            $country = Countrie::get();
            $category = Category::get();
            return view('publisher.offer.private_offers', compact('offers', 'site', 'country', 'category'));
        } else {
            return redirect('/publisher');
        }
    }

    public function PrivateOffers2()
    {
        if (Auth::guard('publisher')->user()->expert_mode == 1) {
            return view('publisher.private_offers2');
        } else {
            return redirect('/publisher');
        }
    }

    public function SpecialOffers()
    {
        if (Auth::guard('publisher')->user()->expert_mode == 1) {
            $offers = Offer::where('offer_type', 'special')->paginate(10);
            $site = Site_setting::first();
            $country = Countrie::get();
            $category = Category::get();
            return view('publisher.offer.special_offers', compact('offers', 'site', 'country', 'category'));
        } else {
            return redirect('/publisher');
        }
    }

    public function NewOffers()
    {
        if (Auth::guard('publisher')->user()->expert_mode == 1) {
            $offers = Offer::where('is_deleted', null)->where('smartlink', 0)->where('magiclink', 0)->where('native', 0)->where('lockers', 0)->where('featured_offer', 0)->where('incentive_allowed', 0)->orderby('id', 'desc')->paginate(10);
            $site = Site_setting::first();
            $country = Countrie::get();
            $category = Category::get();
            return view('publisher.offer.new_offer', compact('offers', 'site', 'country', 'category'));
        } else {
            return redirect('/publisher');
        }
    }

    public function TopOffers()
    {

        if (Auth::guard('publisher')->user()->expert_mode == 1) {
            $offers = Offer::orderBy('clicks', 'desc')->paginate(10);
            $site = Site_setting::first();
            $country = Countrie::get();
            $category = Category::get();
            return view('publisher.offer.top_offers', compact('offers', 'site', 'country', 'category'));
        } else {
            return redirect('/publisher');
        }
    }
    public function chat()
    {
        return view('publisher.chat');
    }
    public function AllOffers()
    {

        if (Auth::guard('publisher')->user()->expert_mode == 1) {
            $offers = Offer::where('is_deleted', null)->where('smartlink', 0)->where('magiclink', 0)->where('native', 0)->where('lockers', 0)->where('featured_offer', 0)->where('incentive_allowed', 0)->paginate(10);

            // echo '<pre>';print_r($offers);echo '</pre>';
            // die;
            $site = Site_setting::first();
            $country = Countrie::get();
            $category = Category::get();
            return view('publisher.offer.all_offers', compact('offers', 'site', 'country', 'category'));
        } else {
            return redirect('/publisher');
        }
    }
    public function myOffers()
    {

        if (Auth::guard('publisher')->user()->expert_mode == 1) {
            // $offers = Offer::select('offers.*')->join('offers_publisher', 'offers_publisher.offer_id', 'offers.id')->where('offers_publisher.publisher_id', Auth::guard('publisher')->user()->id)->paginate(10);
            $offers = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', Auth::guard('publisher')->user()->id)->paginate(10);
            $site = Site_setting::first();
            $country = Countrie::get();
            $category = Category::get();

            // echo '<pre>';
            // print_r($offers); 
            // echo '</pre>';
            // die;
            return view('publisher.offer.my_offers', compact('offers', 'site', 'country', 'category'));
        } else {
            return redirect('/publisher');
        }
    }
    public function OfferDetails(Request $request, $id)
    {

        $site = Site_setting::first();
        $country = Countrie::get();
        $category = Category::get();
        $domain = Smartlink_domain::get();
        $qry = Offer::where('id', $id)->where('status', 'Active')->with('category')->first();
        $approval_request = Approval_request::where('publisher_id', Auth::guard('publisher')->id())->where('offer_id', $id)->first();
        if (is_null($qry)) {
            return redirect()->back()->with('danger', 'There is no such Offer Exists!');
        }
        return view('publisher.offer.offer_detail', ['data' => $id, 'qry' => $qry, 'domain' => $domain, 'approval_request' => $approval_request]);
    }

    // public function SearchOffer(Request $request)
    // {
    //     return $request;
    //     $countries = '1=1';
    //     $count = 0;
    //     if (isset($request->countries)) {
    //         foreach ($request->countries as $c) {
    //             if ($count == 0) {
    //                 $countries = ' countries like \'%' . $c . '%\' ';
    //             } else {
    //                 $countries .= ' or countries like \'%' . $c . '%\' ';
    //             }
    //             $count++;
    //         }
    //     }
    //     $ua = '1=1';
    //     $count = 0;
    //     if (isset($request->ua_target)) {
    //         foreach ($request->ua_target as $c) {
    //             if ($count == 0) {
    //                 $ua = ' ua_target like \'%' . $c . '%\' ';
    //             } else {
    //                 $ua .= ' or ua_target like \'%' . $c . '%\' ';
    //             }
    //             $count++;
    //         }
    //     }

    //     if (isset($request->category)) {
    //         $category = implode(',', $request->category);
    //         $qry = Offer::select('offers.*')->join('category', 'category.id', 'offers.category_id')->where('offers.offer_name', 'like', '%' . $request->name . '%')->where('offers.id', 'like', '%' . $request->id . '%')->whereBetween('offers.payout', [$request->from_payout, $request->to_payout])->where('offers.magiclink', '!=', '1')->where('offers.smartlink', '!=', '1')->where('offers.native', '!=', '1')->where('offers.lockers', '!=', '1')->where('offers.lockers', 'Active')->where('offers.offer_type', 'public')->whereIn('offers.category_id', $category);
    //         if (isset($request->countries)) {
    //             foreach ($request->countries as $c) {
    //                 $qry->orwhere('offers.countries', 'like', '%' . $c . '%');
    //             }
    //         }
    //         if (isset($request->ua_target)) {
    //             foreach ($request->ua_target as $c) {
    //                 $qry->orwhere('offers.ua_target', 'like', '%' . $c . '%');
    //             }
    //         }
    //         $qry->orderBy('offers.id', $request->ascending);
    //         // $qry = DB::select("SELECT o.offer_name,o.offer_type,o.payout_percentage,c.category_name,o.countries,o.payout_type,o.payout,o.ua_target,o.status,o.clicks,o.conversion,o.browsers,o.incentive_allowed,o.smartlink,o.magiclink,o.native,o.lockers,o.preview_url,o.verticals,o.id as offerid,(select GROUP_CONCAT(pub.name) from offers_publisher as of join publishers as pub on pub.id=of.publisher_id where of.offer_id=o.id) as publisher_name  FROM `offers`  as o  left join category as c on c.id=o.category_id where (o.offer_name like '%$request->name%') and (o.id like '%$request->id%')    and (o.payout>=$request->from_payout and o.payout<=$request->to_payout)  and o.magiclink!=1 and o.smartlink!=1 and o.native!=1 and o.lockers!=1   and o.status='Active' and o.offer_type='public' and o.category_id in ($category) and ($countries) and  ($ua)   order by o.id $request->ascending");
    //     } else {
    //         $qry = Offer::select('offers.*')->join('category', 'category.id', 'offers.category_id')->where('offers.offer_name', 'like', '%' . $request->name . '%')->where('offers.id', 'like', '%' . $request->id . '%')->whereBetween('offers.payout', [$request->from_payout, $request->to_payout])->where('offers.magiclink', '!=', '1')->where('offers.smartlink', '!=', '1')->where('offers.native', '!=', '1')->where('offers.lockers', '!=', '1')->where('offers.lockers', 'Active')->where('offers.offer_type', 'public');
    //         if (isset($request->countries)) {
    //             foreach ($request->countries as $c) {
    //                 $qry->orwhere('offers.countries', 'like', '%' . $c . '%');
    //             }
    //         }
    //         if (isset($request->ua_target)) {
    //             foreach ($request->ua_target as $c) {
    //                 $qry->orwhere('offers.ua_target', 'like', '%' . $c . '%');
    //             }
    //         }
    //         $qry->orderBy('offers.id', $request->ascending);
    //         // $qry = DB::select("SELECT o.offer_name,o.offer_type,o.payout_percentage,c.category_name,o.countries,o.payout_type,o.payout,o.ua_target,o.status,o.clicks,o.conversion,o.browsers,o.incentive_allowed,o.smartlink,o.magiclink,o.native,o.lockers,o.preview_url,o.verticals,o.id as offerid,(select GROUP_CONCAT(pub.name) from offers_publisher as of join publishers as pub on pub.id=of.publisher_id where of.offer_id=o.id) as publisher_name  FROM `offers`  as o  left join category as c on c.id=o.category_id where (o.offer_name like '%$request->name%') and (o.id like '%$request->id%')    and (o.payout>=$request->from_payout and o.payout<=$request->to_payout)  and o.magiclink!=1 and o.smartlink!=1 and o.native!=1 and o.lockers!=1 and o.offer_type='public'  and o.status='Active'  and ($countries) and  ($ua)   order by o.id $request->ascending");
    //     }
    //     return response()->json($qry);
    // }
    // public function offerSearch(Request $request)
    // {

    //     // $category = implode(',', $request->category);

    //     $offers = Offer::select('*');
    //     if (isset($request->name) && !empty($request->name)) {
    //         $offers = $offers->where('offer_name', 'like', '%' . $request->name . '%');
    //     }
    //     if (isset($request->id) && !empty($request->id)) {
    //         $offers = $offers->where('id', 'like', '%' . $request->id . '%');
    //     }
    //     $offers = $offers->whereBetween('payout', [$request->from_payout, $request->to_payout]);
    //     $offers = $offers->where('magiclink', '!=', '1')->where('smartlink', '!=', '1');
    //     $offers = $offers->where('native', '!=', '1')->where('lockers', '!=', '1');
    //     $offers = $offers->where('status', 'Active');
    //     if (isset($request->offer_type) && !empty($request->offer_type)) {
    //         $offers = $offers->where('offer_type', $request->offer_type);
    //     }
    //     if (isset($request->category)) {
    //         $offers = $offers->whereIn('offers.category_id', $request->category);
    //     }
    //     if (isset($request->countries) && !empty($request->countries)) {
    //         foreach ($request->countries as $c) {
    //             $offers =    $offers->orwhere('countries', 'like', '%' . $c . '%');
    //         }
    //     }
    //     if (isset($request->ua_target) && !empty($request->ua_target)) {
    //         foreach ($request->ua_target as $c) {
    //             $offers =    $offers->orwhere('ua_target', 'like', '%' . $c . '%');
    //         }
    //     }

    //     $offers = $offers->orderBy('id', $request->ascending)->paginate(10);
    //     $site = Site_setting::first();
    //     $country = Countrie::get();
    //     $category = Category::get();

    //     return view('publisher.offer.' . $request->page_type, compact('offers', 'site', 'country', 'category'));
    // }

    public function requestApproval(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];

        $this->validate($request,  [
            'description' => 'required',
            'terms' => 'required',
        ]);
        $approval_data = [
            'offer_id' => $request->id,
            'publisher_id' => Auth::guard('publisher')->id(),
            'approval_status' => 'Requested',
            'description' => $request->description,
            'terms' => $request->terms
        ];

        if (Approval_request::create($approval_data)) {
            $response = [
                'status' => true,
                'message' => 'Requested  successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
}
