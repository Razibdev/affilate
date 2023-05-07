<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smartlink_domain extends Model
{
    use HasFactory;
    protected $table = 'smartlink_domain';
    protected $fillable = [
        'url', 'publisher_id'
    ];

    public function getActionAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="#" class="text-info editData"  data-url="' . $this->url . '" data-id="' . $this->id . '" title="Edit Site category"><i class="fas fa-edit editData" " data-name="' . $this->site_category_name . '" data-id="' . $this->id . '"></i></a> &nbsp; ';


        $action_links .= '<a href="#"  class="text-danger  deleteData" data-url="' . $this->url . '" data-id="' . $this->id . '" title="Delete Site category"><i class="fas fa-trash-alt"></i></a>  &nbsp;';

        return $action_links;
    }
}
