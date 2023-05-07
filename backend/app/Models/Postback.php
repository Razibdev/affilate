<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Postback extends Model
{
    use HasFactory;
    protected $fillable = [
        'publisher_id', 'link', 'created'
    ];
    protected $table = 'postback';
    public function getJoindateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
}
