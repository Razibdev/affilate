<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Site_setting;
use App\Models\Offer;
use App\Models\Offer_process;
use App\Models\Approval_request;
class OfferController extends Controller
{
    public function PendingOfferProcess()
    {
        return view('affiliate.offer_process.pending_offer_process');
    }
    public function WaitOfferProcess()
    {
        return view('affiliate.offer_process.wait_offer_process');
    }
    public function RejectOfferProcess()
    {
        return view('affiliate.offer_process.rejected_offer_process');
    }
    public function ApproveOfferProcess()
    {
        return view('affiliate.offer_process.approve_offer_process');
    }
    public function viewOfferDetail()
    {
        return view('affiliate.offer.view_offer_details');
    }

    public function ApprovalRequest()
    {
        return view('affiliate.approval_request');
    }
    public function ApproveApprovalRequest()
    {
        return view('affiliate.approve_approval_request');
    }
    public function rejectApprovalRequest()
    {
        return view('affiliate.reject_approval_request');
    }
    public function ShowApprovalRequest(Request $request)
    {

        $id = Auth::guard('affliate')->id();
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Approval_request::select('approval_request.*')->join('publishers','publishers.id', 'approval_request.publisher_id')->where('publishers.affliate_manager_id',$id);
        if ($request->status_type == 'approved') {
            $pages_query->where('approval_request.approval_status',  'Approved');
        }else if($request->status_type == 'rejected'){
            $pages_query->where('approval_request.approval_status',  'Rejected');
        }else {
        $pages_query->where('approval_request.approval_status','Pending')->orwhere('approval_request.approval_status',  'Requested');
        }
        // if (isset($request->status_type) && !empty($request->status_type)) {
        //     if ($request->status_type == 'pending') {
        //         $pages_query->where('status', 'Inactive');
        //     } else if ($request->status_type == 'rejected') {
        //         $pages_query->where('status', 'Rejected')->orWhere('status', 'Banned');
        //     } 
        // } 
        // $pages_query->addSelect(DB::raw("SUBSTRING('description', 0, 1000) as dsd"));
        //search
        if (!empty($search)) {
            $pages_query->where('approval_request.id', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $pages_query->orderBy('approval_request.id', $sort_direction);
        }

        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->get();
        $pages->each->append('date');
        $pages->each->append('publisher');
        $pages->each->append('offer');
        $pages->each->append('action');
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

        if(Approval_request::where('id', $id)->update(['approval_status' => 'Rejected'])){
            $response = [
                'status' => true,
                'message' => 'Approval Request Rejected successdully',
                'data' => []
            ];
        }

        return response()->json($response);
    }

    public function offerDetail(Request $req)
    {
        
        if (!$req->ajax()) {
            return abort(404);
        }
        

         $site = Site_setting::first();
       $qry = Offer::where('id', $req->id)->where('status', 'Active')->with('category')->first();
        if (is_null($qry)) {
            $html= '<div class="alert alert-danger">There is no such Offer Exists!</div>';
        }else{
            $html= view('affiliate.offer.offer', get_defined_vars())->render();
        }
        
        $response = [
            'status' => true,
            'message' => 'Approval Request approve successdully',
            'data' => $html
        ];
        return response()->json($response);
    }

    public function offerDetails(Request $req)
    {
         $site = Site_setting::first();
       $qry = Offer::where('id', $req->id)->where('status', 'Active')->with('category')->first();
    
            $html= view('affiliate.offer.offer', get_defined_vars())->render();
        return view('affiliate.offer.offer_detail', get_defined_vars());
        
        
    }
}
