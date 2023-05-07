<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Affliate_withdraw extends Model
{
    use HasFactory;
    protected $table = 'affliate_withdraw';
    protected $fillable = [
        'affliate_id',  'from_date',  'to_date', 'amount', 'method', 'note', 'payterm', 'payment_details', 'status'
    ];
    public function getDateAttribute()
    {

        return Carbon::parse($this->created_at)->format('d M Y');
    }
    public function  getPayperiodAttribute()
    {
        return $period = '<p>' . $this->from_date . '<br>' . $this->to_date;
    }
    public function getActionAttribute()
    {
        $action_links = "";
        // $action_links .= '<a href="' . route("admin.view-publishers", $this->id) . '" class="text-primary affiliate_view" data-toggle="tooltip" title="view publisher"><i class="far fa-eye"></i></a> &nbsp; ';

        $action_links .= '<a href="#" class="btn btn-sm m-1 btn-primary editData" data-toggle="tooltip" data="' . $this->id . '" title="Edit"><i class="fas fa-edit"></i></a>';
        $action_links .= '<a href="#" class="btn btn-sm m-1 btn-danger deleteData" data-toggle="tooltip" data="' . $this->id . '" title="Delete"><i class="fas fa-trash-alt"></i></a>';


        return $action_links;
    }
    public function affliate()
    {
        return $this->hasOne('App\Models\Affliate', 'id', 'affliate_id');
    }
}
