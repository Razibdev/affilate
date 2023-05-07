<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Smartlink extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'traffic_source', 'publisher_id', 'category_id', 'earnings', 'ecpm', 'conversion_rate', 'traffic_quality', 'url', 'enabled', 'key_', 'is_delete'
    ];
    public function getActionAttribute()
    {
        $action_links = "";
        if ($this->enabled == 1) {
            $action_links .= '<a  class="btn btn-sm btn-danger rejectData" href="javascript:void(0)" class="text-danger " data="' . $this->id . '" data-toggle="tooltip" title="Reject Smartlink">Reject</a> &nbsp; ';
        } else if ($this->enabled == 2) {
            $action_links .= '<a  class="btn btn-sm btn-success approveData" href="javascript:void(0)"  class="text-danger " data="' . $this->id . '" data-toggle="tooltip" title="Approve Smartlink">Approve</a> &nbsp; ';
        } else if ($this->enabled == 0) {
            $action_links .= '<a  class="btn btn-sm btn-success approveData" href="javascript:void(0)" class="text-danger approveData" data="' . $this->id . '" data-toggle="tooltip" title="Approve Smartlink">Approve</a> &nbsp; ';
        }


        return $action_links;
    }
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
    public function getStatusAttribute()
    {
        $status='';
        if($this->enabled==1){
            $status='Approved';
        }else if($this->enabled == 2){
            $status = 'rejected';
        } else if ($this->enabled == 0) {
            $status = 'pending';
        }
        return $status;
    }
    public function category()
    {
        return $this->hasOne('App\Models\Site_category','id', 'category_id');
    }
    public function publisher()
    {
        return $this->hasOne('App\Models\Publisher', 'id', 'publisher_id');
    }
}
