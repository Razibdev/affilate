<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'image'
    ];
    protected $table = 'payment_method';
    public function getActionAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="#" class="text-info editData"  data-name="' . $this->name . '" data-id="' . $this->id . '" title="Edit Site payment"><i class="fas fa-edit editData" " data-name="' . $this->name . '" data-id="' . $this->id . '"></i></a> &nbsp; ';


        $action_links .= '<a href="#"  class="text-danger  deleteData" data-name="' . $this->name . '" data-id="' . $this->id . '" title="Delete Site payment"><i class="fas fa-trash-alt"></i></a>  &nbsp;';

        return $action_links;
    }
    public function getPhotoAttribute()
    {
        $image = '';
        if (!empty($this->image)) {
            $image = '<img src="'.asset('uploads') . '/' . $this->image.'" height="50" width="50">';
        } 
        return $image;
    }
}
