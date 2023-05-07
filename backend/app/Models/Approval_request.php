<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use App\Models\Offer_process;
use Illuminate\Support\Facades\Auth;
use App\Models\Publisher;
use Illuminate\Support\Carbon;
class Approval_request extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id', 'publisher_id', 'approval_status', 'description', 'terms'
    ];
    protected $table = 'approval_request';
    public function getActionAttribute()
    {
        $action_links = "";
        // $action_links .= '<a href="' . route("admin.view-publishers", $this->id) . '" class="text-primary affiliate_view" data-toggle="tooltip" title="view publisher"><i class="far fa-eye"></i></a> &nbsp; ';
        if($this->approval_status == 'Approved'){
            $action_links .= '<a href="#" class="btn btn-sm btn-danger rejectData" data-toggle="tooltip" data-id="' . $this->id . '" title="Reject offer ">Reject</a> &nbsp; ';
        }else if($this->approval_status == 'Requested'){
            $action_links .= '<a href="#" class="btn btn-sm btn-danger rejectData" data-toggle="tooltip" data-id="' . $this->id . '" title="Reject offer ">Reject</a> &nbsp; ';
            $action_links .= '<a href="#" class="btn btn-sm btn-success approveData" data-toggle="tooltip" data-id="' . $this->id . '" title="Approve offer ">Approve</a> &nbsp; ';
        } else if ($this->approval_status == 'Rejected') {
            $action_links .= '<a href="#" class="btn btn-sm btn-success approveData" data-toggle="tooltip" data-id="' . $this->id . '" title="Approve offer ">Approve</a> &nbsp; ';
        }
        
        return $action_links;
    }
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
    public function  getTclickAttribute()
    {
    return Offer_process::where('publisher_id',$this->publisher_id)->where('offer_id',$this->offer_id)->count();
    }
    public function  getTleadsAttribute()
    {
    return Offer_process::where('publisher_id',$this->publisher_id)->where('offer_id',$this->offer_id)->where('status', 'Approved')->count();
    }
    public function  getPublisherAttribute()
    {
        $id = Auth::guard('affliate')->id();
    return Publisher::where('id',$this->publisher_id)->where('affliate_manager_id', $id)->first();
    }
    public function  getPublisher1Attribute()
    {
    
    return Publisher::where('id',$this->publisher_id)->first();
    }
    public function  getOfferAttribute()
    {
        $id = Auth::guard('affliate')->id();
    return Offer::where('id',$this->offer_id)->first();
    }
}
