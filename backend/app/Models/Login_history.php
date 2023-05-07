<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login_history extends Model
{
    use HasFactory;
             protected $fillable = [
       'publisher_id','device','browser','country','city','ip_address','result','session_id','is_active'
    ];
     protected $table = 'login_history';
}

