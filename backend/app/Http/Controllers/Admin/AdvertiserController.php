<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\Affliate;

class AdvertiserController extends Controller
{
    public function ManageAdvertiser()
    {
        return view('admin.Manage_Advertiser');
    }
    public function ShowAdvertiser(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Advertiser::select('*');
        // $pages_query->addSelect(DB::raw("SUBSTRING('description', 0, 1000) as dsd"));
        //search
        if (!empty($search)) {
            $pages_query->where('advertiser_name', 'like', '%' . $search . '%');
            $pages_query->orWhere('email', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $pages_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $pages_query->orderBy('advertiser_name', $sort_direction);
        } elseif ($sort_by == 2) {
            $pages_query->orderBy('email', $sort_direction);
        } elseif ($sort_by == 3) {
            $pages_query->orderBy('status', $sort_direction);
        }

        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->get();
        $pages->each->append('action');
        $pages->each->append('totaloffers');
        // $pages->each->append('sponsor');

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_pages,
            'recordsFiltered' => $total_pages,
            'data' => $pages,
        );
        // print_r($data);
        // print_r(mb_detect_order());
        // die;
        return response()->json($data);
    }



    public function EditAdvertiser(Request $request)
    {
        $data = Advertiser::where('id', $request->id)->first();
        return response()->json($data);
    }
    public function DeleteAdvertiser(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $advtizer= Advertiser::where('id', $request->id)->first();
        if(!empty($advtizer)){
        @unlink('uploads/' . $advtizer->advertiser_image);
        }
        if (Advertiser::where('id', $advtizer->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Advertizer deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
        
    }
    public function InsertAdvertiser(Request $request)
    {

        $photo = '';
        if ($request->photo != '') {

            $photo = mt_rand(1, 1000) . '' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads', $photo);
        }

        $data = array(
            'advertiser_name' => $request->advertiser_name,
            'password' => bcrypt($request->password),
            'company_name' => $request->company_name,
            'email' => $request->email,
            'hereby' => $request->hereby,
            'advertiser_image' => $photo,
            'param1' => $request->param1,
            'param2' => $request->param2,
            'status' => 'Active',
        );
        Advertiser::create($data);
        return redirect()->back()->with('success', 'Advertiser Created Successfully');
    }
    public function UpdateAdvertiser(Request $request)
    {
        $imageName = '';
        if ($request->photo1 != '') {
            @unlink('uploads/' . $request->hidden_img);
            $imageName = mt_rand(1, 1000) . '' . time() . '.' . $request->file('photo1')->getClientOriginalExtension();
            $request->file('photo1')->move('uploads', $imageName);
        } else {
            $imageName = $request->hidden_img;
        }

        $data = array(
            'advertiser_name' => $request->advertiser_name1,

            'company_name' => $request->company_name1,
            'email' => $request->email1,
            'hereby' => $request->hereby1,
            'advertiser_image' => $imageName,
            'status' => $request->status1,
            'param1' => $request->param11,
            'param2' => $request->param21,

        );
        Advertiser::where('id', $request->id)->update($data);
        return redirect()->back()->with('success', 'Advertiser Updated Successfully');
    }

}
