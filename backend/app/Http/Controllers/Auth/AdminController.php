<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Support\Google2FAAuthenticator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin;
use App\Models\Login_history;
use App\Models\Countrie;
use App\Models\Site_category;
use App\Models\admin_securitie;
use App\Models\Site_setting;

class AdminController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        Auth::guard('publisher')->logout();
    
    }
    public function showLoginForm()
    {
    
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('Auth/admin/login');
    }
    public function login(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }
        if (!empty(Auth::guard('admin')->user()->name)) {
            return redirect('/admin');
        }
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // User::where('email',$request->email)->update(['password'=>md5('1234567890')]);
        // return $request->all();
        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
    
        // return $pub_check = Admin::where('email', $request->email)->where('password', bcrypt($request->password))->first();
        // if (isset($pub_check)) {
        //     $password = $pub_check->password_show;
        // } else {
        //     $password = $request->password;
        // }
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $response = [
                'status' => true,
                'message' => 'You are login successfully',
                'data' => []
            ];
        }

        // if unsuccessful
        return response()->json($response);

    }
    public function logout(Request $request)
    {

        Auth::guard('admin')->logout();

        return redirect('/home')->with('status', 'User has been logged out!');
    }
}
