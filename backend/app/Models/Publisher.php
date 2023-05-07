<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
    use Illuminate\Notifications\Notifiable;
use App\Models\Chat;
use App\Models\Offer_process;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Foundation\Auth\User as Authenticatable;

class Publisher extends Authenticatable
{
    use HasFactory;
     protected $guard = 'publisher';
     protected $fillable = [
       'name','role','email','company_name','affliate_manager_id','password','status','verified','address','account_type','city','skype','phone_code','country','regions','postal_code','website_url','monthly_traffic','category','balance','ip_address','publisher_image','phone','additional_information','badge','google2fa_secret','nid','tax_file','tax_note','total_earnings','payment_terms','hereby','actual_country','expert_mode','master_key','password_show'
    ];
      public function loginSecurity()
{
    return $this->hasOne('App\LoginSecurity');
}
    public function getActionAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="'.route("admin.view-publishers", $this->id).'" class="text-primary publisher_view" data-toggle="tooltip" title="View Publisher"><i class="far fa-eye"></i></a> &nbsp; ';
        $action_links .= '<a href="#" class="text-danger publisher_delete" data-toggle="tooltip" data-id="'.$this->id.'" title="Delete Publisher"><i class="fas fa-trash-alt"></i></a> &nbsp; ';
        $action_links .= '<a href="' .route("admin.edit-view-publisher",$this->id) . '" class="text-info publisher_edit" data-toggle="tooltip" title="Edit Publisher"><i class="far fa-edit"></i></a> &nbsp; ';
    
        $action_links .= '<a href="#" class="text-danger publisher_ban" data-toggle="tooltip" data-id="'.$this->id.'"  title="Ban Publisher"><i class="fas fa-ban"></i></a> &nbsp; ';
        $action_links .= '<a href="' . route("admin.access-publisher", $this->email) . '" class="text-success " target="_blank" data-toggle="tooltip" data-id="'.$this->id. '"  title="Login Publisher"><i class="fas fa-lock-open"></i></a> &nbsp; ';
        // $action_links .= '<a target="_blank" href="'.route('view_publisher', $this->slug).'" class="text-success" data-toggle="tooltip" title="view publisher"><i class="fe-eye"></i></a>  &nbsp;';
        
        
        return $action_links;
    }
    public function getAction2Attribute()
    {
        $action_links = "";
        if($this->status == 'Approved'){
            $action_links .= '<a  class="btn btn-sm btn-danger rejectData" href="javascript:void(0)" class="text-danger " data="'.$this->id. '" data-toggle="tooltip" title="Approve Rejected Publisher"> Reject Publisher</a> &nbsp; ';
        } else if ($this->status == 'Inactive') {
            $action_links .= '<a  class="btn btn-sm btn-danger approveData" href="javascript:void(0)" data-href="' . route("admin.publisher-approve-request", $this->id) . '"  class="text-danger " data="' . $this->id . '" data-toggle="tooltip" title="Approve Publisher">Approve</a> &nbsp; ';
        } else if ($this->status == 'Rejected') {
            $action_links .= '<a  class="btn btn-sm btn-danger approveData" href="javascript:void(0)" class="text-danger approveData" data="' . $this->id . '" data-toggle="tooltip" title="Approve Publisher">Approve</a> &nbsp; ';
        }
        
        
        return $action_links;
    }
    public function getAction3Attribute()
    {
        $action_links = "";
        $action_links .= '<a href="' . route("manager.get-detail", $this->id) . '" class="text-primary publisher_view" data-toggle="tooltip" title="View Publisher"><i class="far fa-edit"></i></a> &nbsp; ';

        $action_links .= '<a href="' . route("manager.set-postback", $this->id) . '" class="text-info set_postback" data-toggle="tooltip" title="Set Postback"><i class="fa fa-expand-alt"></i></a> &nbsp; ';

        $action_links .= '<a href="#" class="text-danger publisher_ban" data-toggle="tooltip" data-id="' . $this->id . '"  title="Ban Publisher"><i class="fas fa-ban"></i></a> &nbsp; ';
        // $action_links .= '<a target="_blank" href="'.route('view_publisher', $this->slug).'" class="text-success" data-toggle="tooltip" title="view publisher"><i class="fe-eye"></i></a>  &nbsp;';


        return $action_links;
    }
    public function getAction4Attribute()
    {
        $action_links = "";
        $action_links .= '<a href="' . route("manager.get-detail", $this->id) . '" class="text-primary publisher_view" data-toggle="tooltip" title="view publisher"><i class="far fa-edit"></i></a> &nbsp; ';

        $action_links .= '<a  class="btn btn-sm btn-success approveData" href="javascript:void(0)" data-href="' . route("manager.approve-publishers", $this->id) . '"  class="text-danger " data="' . $this->id . '" data-toggle="tooltip" title="Approve publisher"><i class="fas fa-user-check"></i></a> &nbsp; ';

        $action_links .= '<a  class="btn btn-sm btn-danger rejectData" href="javascript:void(0)" class="text-danger " data="' . $this->id . '" data-toggle="tooltip" title="Reject publisher"> <i class="fas fa-times"></i></a> &nbsp; ';
        // $action_links .= '<a target="_blank" href="'.route('view_publisher', $this->slug).'" class="text-success" data-toggle="tooltip" title="view publisher"><i class="fe-eye"></i></a>  &nbsp;';


        return $action_links;
    }
    public function getAction5Attribute()
    {
        $action_links = "";
        

        $action_links .= '<a  class="btn btn-sm btn-success approveData" href="javascript:void(0)" data-href="' . route("manager.approve-publishers", $this->id) . '"  class="text-danger " data="' . $this->id . '" data-toggle="tooltip" title="Approve publisher"><i class="fas fa-user-check"></i></a> &nbsp; ';

        
        // $action_links .= '<a target="_blank" href="'.route('view_publisher', $this->slug).'" class="text-success" data-toggle="tooltip" title="view publisher"><i class="fe-eye"></i></a>  &nbsp;';


        return $action_links;
    }
    public function getPhotoAttribute(){
        $image='';
        if(!empty($this->publisher_image)){
            $image='<img height="110" width="100" src="'.asset('uploads').'/'. $this->publisher_image.' "> ';
        }else{
            $image = '<img height="110" width="100" src="https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png"> ';
        }
        return $image;
    }
    public function getVerfiedAttribute(){
        $image='';
        if(!empty($this->verified)){
            $image='Yes';
        }else{
            $image = 'No';
        }
        return $image;
    }
    public function getUnreadAttribute(){
        $total=0;
    $total= Chat::where('sender', $this->email)->where('is_read',null)->count();
        return $total;
    }
    public function getTotalclickAttribute(){
        
    return Offer_process::where('publisher_id', $this->id)->count();
        
    }
    public function getTotaluniqueclickAttribute(){
        
    return Offer_process::where('publisher_id', $this->id)->where('unique_',0)->count();
        
    }
    public function getTotalleadsAttribute(){
        
    return Offer_process::where('publisher_id', $this->id)->where('status', 'Approved')->count();
        
    }
    public function getTotalearningAttribute(){
    
    return Offer_process::where('publisher_id', $this->id)->where('status', 'Approved')->sum('publisher_earned');
        
    }
    public function getJoindateAttribute(){
    
    return Carbon::parse($this->created_at)->format('d M Y');
        
    }

    public function getManagernameAttribute()
    {
        // return $this->affliate()->name;
        return $affliate=Affliate::where('id', $this->affliate_manager_id)->first()->name;
        
    }


    public function affliate()
    {
        return $this->hasOne('App\Models\Affliate', 'id', 'affliate_manager_id');
    }

    public function getPhotourlAttribute(){
        $image='';
        if(!empty($this->publisher_image)){
            $image=asset('uploads').'/'. $this->publisher_image;
        }else{
            $image = "https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png";
        }
        return $image;
    }
}
