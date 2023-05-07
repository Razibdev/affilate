<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use Illuminate\Support\Carbon;
class Offer_process extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    
    protected $fillable = [
        'offer_id', 'offer_name', 'publisher_id', 'payout_type', 'payout', 'advertiser_id', 'country', 'browser', 'ip_address', 'ua_target', 'ref_credits', 'source', 'code','sid', 'sid2', 'sid3', 'sid4', 'sid5', 'status', 'unique_', 'key_', 'admin_earned', 'affliate_manager_earnings', 'publisher_earned'
    ];
    protected $table = 'offer_process';

    public function publisher()
    {
        return $this->hasOne('App\Models\Publisher', 'id', 'publisher_id');
    }
    public function advertiser()
    {
        return $this->hasOne('App\Models\Advertiser', 'id', 'advertiser_id');
    }
    public function getPhotourlAttribute()
    {
        $image = '';
        $offer=Offer::Where('id',$this->offer_id)->first();
        if (!empty($offer->preview_url)) {
            $image = asset('uploads') . '/' . $offer->preview_url;
        } else {
            $image = "https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png";
        }
        return $image;
    }
    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M , Y');
    }
    public function getCheckboxAttribute()
    {
        return '<input type="checkbox" name="check[]"  value="'.$this->id.'"> ';
    }
}
