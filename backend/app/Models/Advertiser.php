<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    use HasFactory;
    protected $fillable = [
        'advertiser_name',  'company_name',  'password', 'param1', 'verified', 'email', 'param2', 'hereby', 'advertiser_image', 'status', 'remember_token'
    ];

    public function getActionAttribute()
    {
        $action_links = "";
        // $action_links .= '<a href="' . route("admin.view-publishers", $this->id) . '" class="text-primary advertiser_view" data-toggle="tooltip" title="view publisher"><i class="far fa-eye"></i></a> &nbsp; ';
        $action_links .= '<a href="#" class="text-danger advertiser_delete" data-toggle="tooltip" data-id="' . $this->id . '" title="delete advertiser"><i class="fas fa-trash-alt"></i></a> &nbsp; ';
        $action_links .= '<a href="#" class="text-primary editData" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-toggle="tooltip" data-id="' . $this->id . '"  title="Edit advertiser"><i class="far fa-edit"></i></a> &nbsp; ';

        $action_links .= '<a href="#" class="text-danger advertiser_ban" data-toggle="tooltip" data-id="' . $this->id . '"  title="Ban advertiser"><i class="fas fa-ban"></i></a> &nbsp; ';
        // $action_links .= '<a target="_blank" href="'.route('view_publisher', $this->slug).'" class="text-success" data-toggle="tooltip" title="view advertiser"><i class="fe-eye"></i></a>  &nbsp;';


        return $action_links;
    }
    public function getPhotourlAttribute()
    {
        $image = '';
        if (!empty($this->advertiser_image)) {
            $image = asset('uploads') . '/' . $this->advertiser_image;
        } else {
            $image = "https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png";
        }
        return $image;
    }

    public function getTotaloffersAttribute()
    {
        return Offer::where('advertiser_id', $this->id)->count();
    }

}
