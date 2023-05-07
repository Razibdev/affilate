<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Postback_sent extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id', 'publisher_id', 'status', 'url', 'payout'
    ];
    protected $table = 'postback_sent';
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
}
