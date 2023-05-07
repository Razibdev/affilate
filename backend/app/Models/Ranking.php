<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;
    protected $fillable = [
        'publisher_id',  'clicks',  'lead', 'earnings'
    ];
    protected $table = 'ranking';
}
