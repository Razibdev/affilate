<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Mail_room extends Model
{
    use HasFactory;
    protected $fillable = [
        'affliate_id', 'email', 'subject', 'message'
    ];
    protected $table = 'mail_room';
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
    public function getActionAttribute()
    {
        return '<a href="javascript:void(0)" class="btn btn-sm btn-primary show_mail" type="button" data-bs-toggle="modal" data="'.$this->id.'" >view</a>';
    }
}
