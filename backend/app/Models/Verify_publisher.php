<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify_publisher extends Model
{
    use HasFactory;
     protected $fillable = [
       'publisher_id','token'
    ];
    protected $guarded = ['publisher'];

    public function publisher()
    {
        return $this->belongsTo('App\Models\Publisher', 'publisher_id');
    }

}
