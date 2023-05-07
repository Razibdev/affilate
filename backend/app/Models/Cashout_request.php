<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Cashout_request extends Model
{
    use HasFactory;
    protected $fillable = [
        'affliate_id', 'from_date', 'to_date', 'amount', 'method', 'note', 'payterm', 'payment_details', 'status'
    ];
    protected $table = 'cashout_request';
    public function  getPayperiodAttribute()
    {
    return $period='<p>'.$this->from_date.'<br>'.$this->to_date;
    }
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
    public function getStatustextAttribute(){
        $text='';
        if($this->status=='Pending'){
            $text='Pending';
        }else if($this->status == 'Approved'){
            $text = 'Approved';
        }else if($this->status == 'Rejected'){
            $text = 'Rejected';
        }
        return $text;
    }
    public function getActionAttribute()
    {
        $action_links = "";
        // $action_links .= '<a href="' . route("admin.view-publishers", $this->id) . '" class="text-primary affiliate_view" data-toggle="tooltip" title="view publisher"><i class="far fa-eye"></i></a> &nbsp; ';
    
            $action_links .= '<a href="#" class="btn btn-sm m-1 btn-primary editData" data-toggle="tooltip" data="' . $this->id . '" title="Edit "><i class="fas fa-edit"></i></a>';
            $action_links .= '<a href="#" class="btn btn-sm m-1 btn-danger deleteData" data-toggle="tooltip" data="' . $this->id . '" title="Delete "><i class="fas fa-trash-alt"></i></a>';
    
        return $action_links;
    }
    public function publisher()
    {
        return $this->hasOne('App\Models\Publisher', 'id', 'affliate_id');
    }
}
