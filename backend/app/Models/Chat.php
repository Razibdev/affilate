<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender', 'receiver',  'message', 'created_at', 'is_read', 'screenshot', 'affliate_id'
    ];
    public function getPhotourlAttribute()
    {
        $image = '';
        if (!empty($this->screenshot)) {
            $image = asset('file') . '/' . $this->screenshot;
        } else {
            $image = "";
        }
        return $image;
    }
}
