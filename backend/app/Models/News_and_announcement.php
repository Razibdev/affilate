<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_and_announcement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description'
    ];
    protected $table = 'news_and_announcement';
    public function getActionAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="#" class="text-info editData"  data-title="' . $this->title . '"  data-description="'.$this->description.'" data-id="' . $this->id . '" title="Edit Site category"><i class="fas fa-edit editData" " data-name="' . $this->domain_name . '" data-id="' . $this->id . '"></i></a> &nbsp; ';


        $action_links .= '<a href="#"  class="text-danger  deleteData" data-title="' . $this->title . '"   data-description="' . $this->description . '" data-id="' . $this->id . '" title="Delete Site category"><i class="fas fa-trash-alt"></i></a>  &nbsp;';

        return $action_links;
    }
}
