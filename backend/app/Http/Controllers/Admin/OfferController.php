<?php




use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Support\Google2FAAuthenticator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin;
use App\Models\Login_history;
use App\Models\Publisher;
use App\Models\Countrie;
use App\Models\Site_category;
use App\Models\Domain;
use App\Models\Smartlink_domain;
use App\Models\Smartlink;
use App\Models\admin_securitie;
use App\Models\Site_setting;
use App\Models\Advertiser;

class OfferController extends Controller
{
    public function AddOffer()
    {
        $advertizer= Advertiser::get()->all();
        $domain= Domain::get()->all();
        return view('admin.offer.add_offer',compact('advertizer', 'domain'));
    }
    


}
