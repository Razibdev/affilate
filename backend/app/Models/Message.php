<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Publisher;
use App\Models\Affliate;
use Illuminate\Support\Carbon;
class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender', 'receiver', 'subject', 'message', 'created_at', 'is_read', 'screenshot', 'affliate_id'
    ];
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
    public function getActionAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="' . route("admin.view-message", $this->id) . '" class="text-info editData"   title="Edit Site category"><i class="far fa-eye editData"></i></a> &nbsp; ';


        $action_links .= '<a href="' . route("admin.messages", $this->id) . '"  class="text-danger  deleteData" data-title="' . $this->id . '"  data-id="' . $this->id . '" title="Delete Site category"><i class="fas fa-reply"></i></a>  &nbsp;';

        return $action_links;
    }
    public function getActionpublisherAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="' . route("publisher.view-message", $this->id) . '" class="text-info editData"   title="Edit Site category"><i class="far fa-eye editData"></i></a> &nbsp; ';


        $action_links .= '<a href="' . route("publisher.support", $this->id) . '"  class="text-danger  deleteData" data-title="' . $this->id . '"  data-id="' . $this->id . '" title="Delete Site category"><i class="fas fa-reply"></i></a>  &nbsp;';

        return $action_links;
    }
    public function getActionaffliateAttribute()
    {
        $action_links = "";
        $action_links .= '<a href="' . route("manager.view-message", $this->id) . '" class="text-info editData"   title="Edit Site category"><i class="far fa-eye editData"></i></a> &nbsp; ';


        $action_links .= '<a href="' . route("manager.support", $this->id) . '"  class="text-danger  deleteData" data-title="' . $this->id . '"  data-id="' . $this->id . '" title="Delete Site category"><i class="fas fa-reply"></i></a>  &nbsp;';

        return $action_links;
    }

    public function getImageAttribute(){
        if($this->sender=='admin'){
            $imageurl = "https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png";
        }else if($this->sender == 'affliate'){
            $image= Affliate::where('id',$this->affliate_id)->first();
            if (!empty($image->photo)) {
                $imageurl = asset('uploads') . '/' . $this->photo;
            } else {
                $imageurl = "https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png";
            }
            return $imageurl ;
        }else{
            $publisher= Publisher::where('email',$this->sender)->first();
            $image = '';
            if (!empty($publisher->publisher_image)) {
                $image = asset('uploads') . '/' . $publisher->publisher_image;
            } else {
                $image = "https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png";
            }
            return $image;
        }
    }
}
