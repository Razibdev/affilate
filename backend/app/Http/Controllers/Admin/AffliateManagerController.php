<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Google2FAAuthenticator;
use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\Affliate;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment_method;

class AffliateManagerController extends Controller
{
    public function ManageAffliateManager()
    {
        $payment= Payment_method::get()->all();
        return view('admin.Manage_AffliateManager',compact('payment'));
    }
    public function login(Request $request, $email)
    {

        if (!empty(Auth::guard('admin')->user()->name)) {
            $user = Affliate::where('email', $email)->first();

            Auth::guard('affliate')->login($user);
            // Attempt to log the user in
            $authenticator = app(Google2FAAuthenticator::class)->boot($request);

            $authenticator->login();
            return redirect('manager');
        }
        // return redirect()->back()->with('success', 'Error Occured');
    }
    public function ShowAffliateManager(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $pages_query = Affliate::select('*');
        // $pages_query->addSelect(DB::raw("SUBSTRING('description', 0, 1000) as dsd"));
        //search
        if (!empty($search)) {
            $pages_query->where('name', 'like', '%' . $search . '%');
            $pages_query->orWhere('email', 'like', '%' . $search . '%');
        }
        //sorting
        if ($sort_by == 0) {
            $pages_query->orderBy('id', $sort_direction);
        } elseif ($sort_by == 1) {
            $pages_query->orderBy('name', $sort_direction);
        } elseif ($sort_by == 2) {
            $pages_query->orderBy('email', $sort_direction);
        } elseif ($sort_by == 3) {
            $pages_query->orderBy('status', $sort_direction);
        }

        $total_pages = $pages_query->count();
        $pages = $pages_query->limit($length)->offset($start)->get();
        $pages->each->append('action')->append('power');
        $pages->each->append('totalpublisher');
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


    public function EditAffliateManager(Request $request)
    {
        $data = Affliate::where('id', $request->id)->first();
        return response()->json($data);
    }
    public function DeleteAffliateManager(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $affliate = Affliate::where('id', $request->id)->first();
        if (!empty($affliate)) {
            @unlink('uploads/' . $affliate->photo);
        }
        if (Affliate::where('id', $affliate->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Affiliate deleted successfully',
                'data' => []
            ];
        }
        return response()->json($response);
    }
    public function InsertAffliateManager(Request $request)
    {
        if ($request->password != $request->confirm_password) {
            $request->session()->flash('success', 'Password Not Match');
            return redirect()->back()->with('success', 'Password Not Match');
        }
        $photo = '';
        if ($request->photo != '') {

            $photo = mt_rand(1, 1000) . '' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads', $photo);
        }
        $data = array(
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'skype' => $request->skype,
            'status' => $request->status,
            'balance' => '0',
            'total_earnings' => '0',
            'address' => $request->address,
            'photo' => $photo,
            'payment_method' => $request->payment_method,
            'created_at' => now(),
            'updated_at' => now(),
        );
        Affliate::insert($data);
        return redirect()->back()->with('success', 'Affliate Manager Created Successfully');
    }
    public function UpdateAffliateManager(Request $request)
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
            'name' => $request->name1,

            'email' => $request->email1,
            'skype' => $request->skype1,
            'status' => $request->status1,
            'address' => $request->address1,
            'photo' => $imageName,
            'payment_method' => $request->payment_method,

        );
        Affliate::where('id', $request->id)->update($data);
        return redirect()->back()->with('success', 'AffliateManager Updated Successfully');
    }

    public function ChangePassword(Request $request)
    {
        if ($request->password != $request->confirm_password) {
            $request->session()->flash('success', 'Password Not Match');
            return redirect()->back()->with('success', 'Password Not Match');
        }
        $data = array(
            'password' => bcrypt($request->password),
        );
        Affliate::where('id', $request->password_id)->update($data);
        return redirect()->back()->with('success', 'Password Updated  Successfully');
    }
}
