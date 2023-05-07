<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher_transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_process_id',  'publisher_id',  'amount', 'code'
    ];
}
