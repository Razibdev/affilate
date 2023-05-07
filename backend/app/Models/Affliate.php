<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Affliate extends Authenticatable
{
    
    use HasFactory;
    protected $guard = 'affiliate';
    protected $fillable = [
        'name',  'email',  'password', 'status', 'verified', 'address', 'skype', 'balance', 'photo', 'total_earnings', 'payment_method', 'power_mode', 'payment_description'
    ];
    public function getActionAttribute()
    {
        $action_links = "";
        // $action_links .= '<a href="' . route("admin.view-publishers", $this->id) . '" class="text-primary affiliate_view" data-toggle="tooltip" title="view publisher"><i class="far fa-eye"></i></a> &nbsp; ';
        $action_links .= '<a href="#" class="text-danger affiliate_delete" data-toggle="tooltip" data-id="' . $this->id . '" title="delete affiliate"><i class="fas fa-trash-alt"></i></a> &nbsp; ';
        $action_links .= '<a href="#" class="text-primary editData" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-toggle="tooltip" data-id="' . $this->id . '"  title="Edit affiliate"><i class="far fa-edit"></i></a> &nbsp; ';

        $action_links .= '<a href="#" class="text-danger changepassword" data-toggle="tooltip" data-bs-target="#passwordModal" data-toggle="tooltip" data-id="' . $this->id . '"  title="Change pasword"><i class="fas fa-unlock"></i></a> &nbsp; ';
        $action_links .= '<a href="' . route("admin.access-affliate", $this->email) . '" class="text-success " target="_blank" data-toggle="tooltip" data-id="' . $this->id . '"  title="Login affliate"><i class="fas fa-lock-open"></i></a> &nbsp; ';
        // $action_links .= '<a target="_blank" href="'.route('view_publisher', $this->slug).'" class="text-success" data-toggle="tooltip" title="view affiliate"><i class="fe-eye"></i></a>  &nbsp;';


        return $action_links;
    }


    public function  getTotalpublisherAttribute(){
        return Publisher::where('affliate_manager_id',$this->id)->count();
    }

    public function  getPowerAttribute(){
        if($this->id==1){
            $mode='Expert';
        }else{
            $mode = 'General';
        }
        return $mode;
    }
    public function getPhotourlAttribute()
    {
        $image = '';
        if (!empty($this->photo)) {
            $image = asset('uploads') . '/' . $this->photo;
        } else {
            $image = "https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png";
        }
        return $image;
    }
}
