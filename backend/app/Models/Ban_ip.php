<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban_ip extends Model
{
    use HasFactory;
    protected $fillable = [
         'ip_address'
    ];
    protected $table = 'ban_ip';
    public function getActionAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="#" class="text-info editData"  data-title="' . $this->ip_address . '"  data-id="' . $this->id . '" title="Edit Site category"><i class="fas fa-edit editData" " data-name="' . $this->domain_name . '" data-id="' . $this->id . '"></i></a> &nbsp; ';


        $action_links .= '<a href="#"  class="text-danger  deleteData" data-title="' . $this->ip_address . '"   data-id="' . $this->id . '" title="Delete Site category"><i class="fas fa-trash-alt"></i></a>  &nbsp;';

        return $action_links;
    }
}
