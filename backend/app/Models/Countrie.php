<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use DB;
class Countrie extends Model
{
    use HasFactory;
     protected $fillable = [
        'country_name', 'nicename', 'iso3', 'numcode', 'phonecode', 'iso'
    ];
    public function getTotalclickAttribute()
    {
        $total =0;
    $total= Offer::where('countries' ,'like', '%'.$this->nicename .'%')->sum('clicks');
    // dd($total);
    if(!empty($total)){
        return $total;
    }else{
        return 0;
    }
    }
    public function getTotalleadsAttribute()
    {
        return Offer::where('countries', 'like', '%' . $this->nicename . '%')->sum('leads');
    }
}
