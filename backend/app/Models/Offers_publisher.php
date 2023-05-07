<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers_publisher extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id', 'publisher_id'
    ];
    protected $table = 'approval_request';
}
