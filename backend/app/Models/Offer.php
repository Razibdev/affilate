<?php

namespace App\Models;

use App\Models\Offer_process;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_name', 'advertiser_id', 'advertiser_officer_id', 'tracking_domain_id', 'offer_type', 'category_id', 'description', 'requirements', 'link', 'preview_url', 'preview_link', 'publishers', 'icon_url', 'lead_qty', 'verticals', 'payout', 'payout_type', 'countries', 'ua_target', 'clicks', 'conversion', 'featured_offer', 'incentive_allowed', 'smartlink', 'magiclink', 'native', 'lockers', 'deleted_at', 'is_deleted', 'status', 'browsers', 'leads', 'payout_percentage'
    ];

    public function lead_count(){
        return $this->hasMany(Offer_process::class, 'offer_id', 'id')->where('status', 'Approved')->select('offer_id', 'id', 'status');
    }
    public function click_count(){
        return $this->hasMany(Offer_process::class, 'offer_id', 'id')->select('offer_id', 'id', 'payout');
    }

    public function unique_click(){
        return $this->hasMany(Offer_process::class, 'offer_id', 'id')->where('unique_', 1)->select('offer_id', 'id', 'unique_');
    }

    public function getActionAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="' . route('admin.edit_offer', $this->id) . '" class="text-info editData"  data-id="' . $this->id . '" title="Edit Offer"><i class="fas fa-edit editData" " data-id="' . $this->id . '"></i></a> &nbsp; ';


        $action_links .= '<a href="#"  class="text-danger  deleteData" data-id="' . $this->id . '" title="Delete Offer"><i class="fas fa-trash-alt"></i></a>  &nbsp;';

        return $action_links;
    }
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
    public function getOferrevshereAttribute(){
        if(empty($this->payout)){
            return 'Revshere';
        }else{
            // return $this->payout;
            return '$' . round(($this->payout * $this->payout_percentage) / 100, 2);
        }
    }
    public function getPublishercountAttribute()
    {

        if ($this->offer_type == 'special') {
            return Offer_process::where('offer_id', $this->id)->where('publisher_id', Auth::guard('publisher')->id())->count();
        } else {
            return 0;
        }
    }
    public function getCategoryverticsAttribute()
    {

        $category= Category::where('id',$this->category_id)->first();
     return '<p>'. $category->category_name.' / '.$this->verticals;
    }

    public function getLeadscountAttribute()
    {
        return Offer_process::where('offer_id', $this->id)->count();
    }





    public function getSmartlinkstatusAttribute()
    {
        $smart = 'no';
        if ($this->smartlink == 1) {
            $smart = 'Yes';
        } else {
            $smart = 'No';
        }
        return $smart;
    }
    public function publisher()
    {
        return $this->hasOne('App\Models\Publisher', 'id', 'publisher_id');
    }
    public function getOfferimageAttribute()
    {
        $offer_image = asset('uploads/') . '/' . $this->preview_url;
        return '<a href="' . $offer_image . '" target="_blank"><img src="' . $offer_image . '" width="100" height="100" style="object-fit: contain;"></a>';
    }
    public function getOfferactionAttribute()
    {
        return '<a class="btn btn-primary" href="' . route('publisher.offers-details', $this->id) . '" target="_blank">Get details</a>';
    }
    public function getPayoutamountAttribute()
    {
        if ($this->payout_type == 'revshare') {
            return 'RevShare';
        } else {
            return '$' . round(($this->payout * $this->payout_percentage) / 100, 2);
        }
    }
    public function getBroweserAttribute()
    {
        $browser = explode('|', $this->browsers);
        $browser_result='';
        foreach ($browser as $d) {
            if ($d == 'OPERA MINI') {
                $browser_result .= '<i class="fab fa-opera m-1" title="Opera"></i>';
            } elseif ($d == 'Chrome') {
                $browser_result .= '<i class="fab fa-chrome m-1" title="Chrome"></i>';
            } elseif ($d == 'Firefox') {
                $browser_result .= '<i class="fab fa-firefox m-1" title="Firefox"></i>';
            } elseif ($d == 'Internet Explorer') {
                $browser_result .= '<i class="fab fa-internet-explorer m-1" title="Internet Explorer"></i>';
            } elseif ($d == 'Safari') {
                $browser_result .= '<i class="fab fa-safari m-1" title="Safari"></i>';
            } elseif ($d == 'EDGE') {
                $browser_result .= '<i class="fab fa-edge m-1" title="Edge"></i>';
            }
        }
        return $browser_result;
    }
    public function getDeviceAttribute()
    {
        $device = explode('|', $this->ua_target);
        $device_result ='';
        foreach ($device as $d) {
            if ($d == 'Windows') {
                $device_result .= '<i class="fab fa-windows m-1" title="Windows"></i>';
            } else if ($d == 'Mac') {
                $device_result .= '<i class="fas fa-laptop m-1" title="Mac"></i>';
            } else if ($d == 'Iphone') {
                $device_result .= '<i class="fas fa-mobile m-1" title="Iphone"></i>';
            } else if ($d == 'Ipad') {
                $device_result .= '<i class="fas fa-tablet m-1" title="Ipad"></i>';
            } else if ($d == 'Android') {
                $device_result .= '<i class="fas fa-mobile-alt m-1" title="Android"></i>';
            }
        }
        return $device_result;
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M Y');
    }
}
