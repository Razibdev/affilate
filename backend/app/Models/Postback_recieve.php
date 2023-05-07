<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Postback_recieve extends Model
{
    use HasFactory;
    protected $fillable = [
        'url', 'status', 'offer_process_id', 'offer_id', 'publisher_id'
    ];
    protected $table = 'postback_recieve';
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
}
