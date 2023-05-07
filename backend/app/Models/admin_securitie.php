<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin_securitie extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id', 'google2fa_enable', 'google2fa_secret'
    ];
}
