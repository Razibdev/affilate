<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Publisher;
use App\Models\Advertiser;
use App\Models\Offer_process;
use App\Models\Offer;
use Stevebauman\Location\Facades\Location;
use App\Models\Site_setting;
use App\Helpers\UserSystemInfoHelper;
use App\Models\Offers_publisher;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\Approval_request;
use App\Models\Affliate;
use App\Models\Smartlink;
use App\Models\Postback_recieve;
use App\Models\Affliate_transaction;
use App\Models\Publisher_transaction;
use App\Models\Ranking;
use App\Models\Cashout_request;
use App\Models\Postback_sent;
use App\Models\Postback;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return vid
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function Click(Request $request)
    {


        $campid = $request->query('camp');
        $pubid = $request->query('pubid');


        $subid = $request->query('sid');
        $subid2 = $request->query('sid2');
        $subid3 = $request->query('sid3');
        $subid4 = $request->query('sid4');
        $subid5 = $request->query('sid5');
        $ip = $_SERVER['REMOTE_ADDR'];
        $timeout = 5;


        $setting_vpn = Site_setting::where('id', '1')->first();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        //smaller than =0,means not using vpn and if greater than 0 means using vpn it will not go to advertiser url,plz close your vpn then try again
        //if you're using custom flags (like flags=m), change the URL below

        if ($setting_vpn->vpn_check == 'yes') {
            //Commented 30_06
            curl_setopt($ch, CURLOPT_URL, "http://proxycheck.io/v2/" . $ip . "?key=" . $setting_vpn->vpn_api . "0&risk=1&vpn=1");
        } else {
            //New Added  30_06
            curl_setopt($ch, CURLOPT_URL, url('/api/bypass/ip'));
        }

        $response = curl_exec($ch);

        curl_close($ch);

        $data = Location::get($ip);

        $country = $data->countryName;

        $getbrowser = UserSystemInfoHelper::get_ip();
        $getbrowser = UserSystemInfoHelper::get_browsers();

        $getos = UserSystemInfoHelper::get_os();

        //CHECKING VPN
        $v = json_decode($response, true);
        // echo '<pre>'; print_r($v); echo '</pre>';die;
        if(!empty($v)){

            $v['proxy'] = $v[$ip]['proxy'];
        } else {
            $v['proxy'] = 'no';
        }

        if ($v['proxy'] == 'yes') {

            if ($setting_vpn->vpn_check == 'yes') {
                echo "<h1>You are using vpn , close it and try again</h1>";
                $inc = Publisher::where('id', $pubid)->increment('vpn_clicks', 1);
                $pu = Publisher::where('id', $pubid)->first();
                if ($pu->vpn_clicks >= $setting_vpn->vpn_click_limit) {
                    echo "This Publisher is Banned from Our Network";
    
                    Publisher::where('id', $pubid)->update(['status' => 'banned']);
    
                    $data = array('name' => $pu->name, 'publisher_id' => $pu->id, 'message' => 'Your Account has been Banned Due to Exceeded Vpn Clicks', 'subject' => 'Account Ban', 'email' => $pu->email);
    
                    $smtp_server = Site_setting::find(1);
                    $config = array(
                        'driver'     => 'smtp',
                        'host'       => $smtp_server->smtp_host,
                        'port'       => $smtp_server->smtp_port,
                        'username'   => $smtp_server->smtp_user,
                        'password'   => $smtp_server->smtp_password,
                        'encryption' => $smtp_server->smtp_enc,
                        'from'       => array('address' => $smtp_server->from_email, 'name' => $smtp_server->from_name),
                        'sendmail'   => '/usr/sbin/sendmail -bs',
                        'pretend'    => false,
                    );
                    Config::set('mail', $config);
    
                    Mail::send('emails.sendmailadmin', ['data' => $data,'setting'=>$smtp_server], function ($message) use ($data) {
                        $smtp_server = Site_setting::find(1);
                        $message->from($smtp_server->from_email, $smtp_server->from_name);
                        $message->to($data['email'], 'Publisher')->subject($data['subject']);
                    });
                    Auth::guard('publisher')->logout();
                }
            } else {
                $country = strtoupper($country);
    
                // $qry = DB::select("select *,id as id from offers where id='$campid'  and (countries like '%$country%' or countries='ALL') and browsers like '%$getbrowser%' and ua_target like '%$getos%'  limit 1 ");
                $qry = Offer::select('*')->Where('id', $campid)->where('countries', 'LIKE', '%' . $country . '%')->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
                if (empty($qry)) {
    
                    $qry = Offer::select('*')->Where('id', $campid)->where('countries', 'LIKE', '%ALL%')->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
                }
    
    
    
    
    
    
                $var = '0';
                if (!empty($qry)) {
                    if ($qry->offer_type == 'public') {
                        $var = '1';
                    } elseif ($qry->offer_type == 'private') {
    
                        $qry1 = Approval_request::where('offer_id', $campid)->where('publisher_id', $pubid)->first();
                        if ($qry1 == '') {
                        } else {
                            if ($qry1->approval_status == 'Approved') {
                                $var = '1';
                            }
                        }
                    } else {
    
                        $qry2 = Offers_publisher::where('offer_id', $campid)->where('publisher_id', $pubid)->first();
    
                        if ($qry2 != '') {
                            $var = '1';
                        }
                    }
                }
    
                        $codes = 0;
             $code = md5(rand(1, 999999));
            do {
                 $codes = Offer_process::Where('code', $code)->first();
                 if(!empty($codes)){
                $code = md5(rand(1, 999999));
                 }
            } while (!empty($codes));
                if ($var == '1') {
                    $unique = '1';
                    $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                    if ($checkUnique != '') {
                        $unique = 0;
                    }
    
                    $amount = 0;
                    $admin_amount = 0;
                    $publisher_earnings = 0;
                    $site = Site_setting::first();
                    $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                    if ($qry->payout_type == 'revshare') {
    
                        $amount = 0;
                    } else {
    
                        $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);
    
                        $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                    }
                    $offerProcessData = array(
                        'offer_id' => $qry->id,
                        'offer_name' => $qry->offer_name,
                        'ua_target' => $getos,
                        'browser' => $getbrowser,
                        'country' => $country,
                        'ip_address' => $ip,
                        'code' => $code,
                        'unique_' => $unique,
                        'publisher_id' => $pubid,
                        'payout_type' => $qry->payout_type,
                        'payout' => $qry->payout,
                        'publisher_earned' => $publisher_earnings,
                        'source' => 'Direct Visitor',
                        // 'source' => "abc",
                        'sid' => $request->query('sid'),
                        'sid2' => $request->query('sid2'),
                        'sid3' => $request->query('sid3'),
                        'sid4' => $request->query('sid4'),
                        'sid5' => $request->query('sid5'),
                        'status' => 'Pending',
                        'admin_earned' => $admin_amount,
                        'advertiser_id' => $qry->advertiser_id
    
                    );
    
                    Offer::where('id', $qry->id)->increment('clicks', 1);
    
                    Offer_process::create($offerProcessData);
                    $network = Advertiser::where('id', $qry->advertiser_id)->first();
    
                    $q = '';
                    if ($network->param2 == null || $network->param2 == '') {
                        $q = "&$network->param1=$code&";
                    } else {
    
                        $q = "&$network->param1=$code&$network->param2=$pubid&";
                    }
    
                    return Redirect::to($qry->link . $q);
                } else {
                    //FOR SMARTLINK
                    $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%' . $country . '%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.smartlink', 1)->where('offers.status', 'Active')->first();
                    if (empty($qry)) {
                        $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%ALL%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.smartlink', 1)->where('offers.status', 'Active')->first();
                    }
    
    
                    if (isset($qry) && !empty($qry)) {
                        //OFFER NOT VALID FOR YOU
                        $unique = '1';
                        $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                        if ($checkUnique != '') {
                            $unique = 0;
                        }
    
                        $amount = 0;
                        $admin_amount = 0;
                        $publisher_earnings = 0;
                        $site = Site_setting::first();
                        $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                        if ($qry->payout_type == 'revshare') {
    
                            $amount = 0;
                        } else {
    
                            $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);
    
                            $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                        }
                        $offerProcessData = array(
                            'offer_id' => $qry->id,
                            'offer_name' => $qry->offer_name,
                            'ua_target' => $getos,
                            'browser' => $getbrowser,
                            'country' => $country,
                            'ip_address' => $ip,
                            'code' => $code,
                            'unique_' => $unique,
                            'publisher_id' => $pubid,
                            'payout_type' => $qry->payout_type,
                            'payout' => $qry->payout,
                            'publisher_earned' => $publisher_earnings,
                            'source' => "fgvgh",
                            'admin_earned' => $admin_amount,
                            'sid' => $request->query('sid'),
                            'sid2' => $request->query('sid2'),
                            'sid3' => $request->query('sid3'),
                            'sid4' => $request->query('sid4'),
                            'sid5' => $request->query('sid5'),
                            'status' => 'Pending',
                            'advertiser_id' => $qry->advertiser_id
    
                        );
    
                        Offer::where('id', $qry->id)->increment('clicks', 1);
    
                        Offer_process::create($offerProcessData);
                        $network = Advertiser::where('id', $qry->advertiser_id)->first();
                        $q = '';
                        if ($network->param2 == null || $network->param2 == '') {
                            $q = "&$network->param1=$code&";
                        } else {
    
                            $q = "&$network->param1=$code&$network->param2=$pubid&";
                        }
    
                        return Redirect::to($qry->link . $q);
                    } else {
    
    
                        //FOR RANDOM
                        $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%' . $country . '%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.status', 'Active')->first();
                        if (empty($qry)) {
                            $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%ALL%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.status', 'Active')->first();
                        }
                        if (isset($qry) &&  !empty($qry)) {
                            //OFFER NOT VALID FOR YOU
                            $unique = '1';
                            $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                            if ($checkUnique != '') {
                                $unique = 0;
                            }
    
                            $amount = 0;
                            $publisher_earnings = 0;
                            $admin_amount = 0;
                            $site = Site_setting::first();
                            $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                            if ($qry->payout_type == 'revshare') {
    
                                $amount = 0;
                            } else {
    
                                $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);
    
                                $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                            }
                            $offerProcessData = array(
                                'offer_id' => $qry->id,
                                'offer_name' => $qry->offer_name,
                                'ua_target' => $getos,
                                'browser' => $getbrowser,
                                'country' => $country,
                                'ip_address' => $ip,
                                'code' => $code,
                                'unique_' => $unique,
                                'publisher_id' => $pubid,
                                'payout_type' => $qry->payout_type,
                                'payout' => $qry->payout,
                                'publisher_earned' => $publisher_earnings,
                                'admin_earned' => $admin_amount,
                                'source' => "vbhfg",
                                'sid' => $request->query('sid'),
                                'sid2' => $request->query('sid2'),
                                'sid3' => $request->query('sid3'),
                                'sid4' => $request->query('sid4'),
                                'sid5' => $request->query('sid5'),
                                'status' => 'Pending',
                                'advertiser_id' => $qry->advertiser_id
    
                            );
    
    
                            Offer_process::create($offerProcessData);
                            Offer::where('id', $qry->id)->increment('clicks', 1);
    
                            $network = Advertiser::where('id', $qry->advertiser_id)->first();
                            $q = '';
                            if ($network->param2 == null || $network->param2 == '') {
                                $q = "&$network->param1=$code&";
                            } else {
    
                                $q = "&$network->param1=$code&$network->param2=$pubid&";
                            }
    
    
                            return Redirect::to($qry->link . $q);
                        } else {
                            $qry = Offer::select('*')->where('id', $campid)->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
                            
                            if(!empty($qry->secondary_link)){
                                
                                $network = Advertiser::where('id', $qry->advertiser_id)->first();
                                $q = '';
                                if ($network->param2 == null || $network->param2 == '') {
                                    $q = "&$network->param1=$code&";
                                } else {
        
                                    $q = "&$network->param1=$code&$network->param2=$pubid&";
                                }
                                
                                return Redirect::to($qry->secondary_link . $q);
                            }else{
                                echo "No Qualified Offer";
                            }
                        }
                    }
                }
            }
        
        } else {
            
            $country = strtoupper($country);

            // $qry = DB::select("select *,id as id from offers where id='$campid'  and (countries like '%$country%' or countries='ALL') and browsers like '%$getbrowser%' and ua_target like '%$getos%'  limit 1 ");
            $qry = Offer::select('*')->where('id', $campid)->where('countries', 'LIKE', '%' . $country . '%')->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
            
            if (empty($qry)) {

                $qry = Offer::select('*')->where('id', $campid)->where('countries', 'LIKE', '%ALL%')->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
            }


            $var = '0';
            if (!empty($qry)) {
                if ($qry->offer_type == 'public') {
                    $var = '1';
                } elseif ($qry->offer_type == 'private') {

                    $qry1 = Approval_request::where('offer_id', $campid)->where('publisher_id', $pubid)->first();
                    if ($qry1 == '') {
                    } else {
                        if ($qry1->approval_status == 'Approved') {
                            $var = '1';
                        }
                    }
                } else {

                    $qry2 = Offers_publisher::where('offer_id', $campid)->where('publisher_id', $pubid)->first();

                    if ($qry2 != '') {
                        $var = '1';
                    }
                }
            }

                    $codes = 0;
         $code = md5(rand(1, 999999));
        do {
             $codes = Offer_process::Where('code', $code)->first();
             if(!empty($codes)){
            $code = md5(rand(1, 999999));
             }
        } while (!empty($codes));
            if ($var == '1') {
                $unique = '1';
                $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                if ($checkUnique != '') {
                    $unique = 0;
                }

                $amount = 0;
                $admin_amount = 0;
                $publisher_earnings = 0;
                $site = Site_setting::first();
                $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                if ($qry->payout_type == 'revshare') {

                    $amount = 0;
                } else {

                    $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                    $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                }
                $offerProcessData = array(
                    'offer_id' => $qry->id,
                    'offer_name' => $qry->offer_name,
                    'ua_target' => $getos,
                    'browser' => $getbrowser,
                    'country' => $country,
                    'ip_address' => $ip,
                    'code' => $code,
                    'unique_' => $unique,
                    'publisher_id' => $pubid,
                    'payout_type' => $qry->payout_type,
                    'payout' => $qry->payout,
                    'publisher_earned' => $publisher_earnings,
                    'source' => 'Direct Visitor',
                    // 'source' => "abc",
                    'sid' => $request->query('sid'),
                    'sid2' => $request->query('sid2'),
                    'sid3' => $request->query('sid3'),
                    'sid4' => $request->query('sid4'),
                    'sid5' => $request->query('sid5'),
                    'status' => 'Pending',
                    'admin_earned' => $admin_amount,
                    'advertiser_id' => $qry->advertiser_id

                );

                Offer::where('id', $qry->id)->increment('clicks', 1);

                Offer_process::create($offerProcessData);
                $network = Advertiser::where('id', $qry->advertiser_id)->first();

                $q = '';
                if ($network->param2 == null || $network->param2 == '') {
                    $q = "&$network->param1=$code&";
                } else {

                    $q = "&$network->param1=$code&$network->param2=$pubid&";
                }

                return Redirect::to($qry->link . $q);
            } else {
                //FOR SMARTLINK
                $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%' . $country . '%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.smartlink', 1)->where('offers.status', 'Active')->first();
                if (empty($qry)) {
                    $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%ALL%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.smartlink', 1)->where('offers.status', 'Active')->first();
                }


                if (isset($qry) && !empty($qry)) {
                    //OFFER NOT VALID FOR YOU
                    $unique = '1';
                    $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                    if ($checkUnique != '') {
                        $unique = 0;
                    }

                    $amount = 0;
                    $admin_amount = 0;
                    $publisher_earnings = 0;
                    $site = Site_setting::first();
                    $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                    if ($qry->payout_type == 'revshare') {

                        $amount = 0;
                    } else {

                        $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                        $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                    }
                    $offerProcessData = array(
                        'offer_id' => $qry->id,
                        'offer_name' => $qry->offer_name,
                        'ua_target' => $getos,
                        'browser' => $getbrowser,
                        'country' => $country,
                        'ip_address' => $ip,
                        'code' => $code,
                        'unique_' => $unique,
                        'publisher_id' => $pubid,
                        'payout_type' => $qry->payout_type,
                        'payout' => $qry->payout,
                        'publisher_earned' => $publisher_earnings,
                        'source' => "fgvgh",
                        'admin_earned' => $admin_amount,
                        'sid' => $request->query('sid'),
                        'sid2' => $request->query('sid2'),
                        'sid3' => $request->query('sid3'),
                        'sid4' => $request->query('sid4'),
                        'sid5' => $request->query('sid5'),
                        'status' => 'Pending',
                        'advertiser_id' => $qry->advertiser_id

                    );

                    Offer::where('id', $qry->id)->increment('clicks', 1);

                    Offer_process::create($offerProcessData);
                    $network = Advertiser::where('id', $qry->advertiser_id)->first();
                    $q = '';
                    if ($network->param2 == null || $network->param2 == '') {
                        $q = "&$network->param1=$code&";
                    } else {

                        $q = "&$network->param1=$code&$network->param2=$pubid&";
                    }

                    return Redirect::to($qry->link . $q);
                } else {


                    //FOR RANDOM
                    $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%' . $country . '%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.status', 'Active')->first();
                    if (empty($qry)) {
                        $qry = Offer::select('offers.*')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', $pubid)->where('approval_request.approval_status', 'Approved')->where('offers.browsers', 'like', '%' . $getbrowser . '%')->where('offers.countries', 'like', '%ALL%')->where('offers.ua_target', 'like', '%' . $getos . '%')->where('offers.status', 'Active')->first();
                    }
                    if (isset($qry) &&  !empty($qry)) {
                        //OFFER NOT VALID FOR YOU
                        $unique = '1';
                        $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                        if ($checkUnique != '') {
                            $unique = 0;
                        }

                        $amount = 0;
                        $publisher_earnings = 0;
                        $admin_amount = 0;
                        $site = Site_setting::first();
                        $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                        if ($qry->payout_type == 'revshare') {

                            $amount = 0;
                        } else {

                            $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                            $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                        }
                        $offerProcessData = array(
                            'offer_id' => $qry->id,
                            'offer_name' => $qry->offer_name,
                            'ua_target' => $getos,
                            'browser' => $getbrowser,
                            'country' => $country,
                            'ip_address' => $ip,
                            'code' => $code,
                            'unique_' => $unique,
                            'publisher_id' => $pubid,
                            'payout_type' => $qry->payout_type,
                            'payout' => $qry->payout,
                            'publisher_earned' => $publisher_earnings,
                            'admin_earned' => $admin_amount,
                            'source' => "vbhfg",
                            'sid' => $request->query('sid'),
                            'sid2' => $request->query('sid2'),
                            'sid3' => $request->query('sid3'),
                            'sid4' => $request->query('sid4'),
                            'sid5' => $request->query('sid5'),
                            'status' => 'Pending',
                            'advertiser_id' => $qry->advertiser_id

                        );


                        Offer_process::create($offerProcessData);
                        Offer::where('id', $qry->id)->increment('clicks', 1);

                        $network = Advertiser::where('id', $qry->advertiser_id)->first();
                        $q = '';
                        if ($network->param2 == null || $network->param2 == '') {
                            $q = "&$network->param1=$code&";
                        } else {

                            $q = "&$network->param1=$code&$network->param2=$pubid&";
                        }


                        return Redirect::to($qry->link . $q);
                    } else {
                        $qry = Offer::select('*')->where('id', $campid)->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
                            
                        if(!empty($qry->secondary_link)){
                            
                            $network = Advertiser::where('id', $qry->advertiser_id)->first();
                            $q = '';
                            if ($network->param2 == null || $network->param2 == '') {
                                $q = "&$network->param1=$code&";
                            } else {
    
                                $q = "&$network->param1=$code&$network->param2=$pubid&";
                            }
                            
                            return Redirect::to($qry->secondary_link . $q);
                        }else{
                            echo "No Qualified Offer";
                        }
                        
                    }
                }
            }
        }


        return null;
    }

    public function Smartlink(Request $request)
    {

        $campid = $request->query('camp');
        $pubid = $request->query('pubid');


        $codeemail = rand(1, 999);

        $subid = $request->query('sid');
        $subid2 = $request->query('sid2');
        $subid3 = $request->query('sid3');
        $subid4 = $request->query('sid4');
        $subid5 = $request->query('sid5');
        $ip = $_SERVER['REMOTE_ADDR'];

        $setting_vpn = Site_setting::where('id', '1')->first();
        $timeout = 5;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        //smaller than =0,means not using vpn and if greater than 0 means using vpn it will not go to advertiser url,plz close your vpn then try again
        //if you're using custom flags (like flags=m), change the URL below
        if ($setting_vpn->vpn_check == 'yes') {
            //Commented 30_06
            curl_setopt($ch, CURLOPT_URL, "http://proxycheck.io/v2/" . $ip . "?key=" . $setting_vpn->vpn_api . "0&risk=1&vpn=1");
        } else {
            //New Added  30_06
            curl_setopt($ch, CURLOPT_URL, url('/api/bypass/ip'));
        }

        $response = curl_exec($ch);

        curl_close($ch);

        $data = Location::get($ip);

        $country = $data->countryName;

        $getbrowser = UserSystemInfoHelper::get_browsers();

        $getos = UserSystemInfoHelper::get_os();

        //CHECKING VPN
        $v = json_decode($response, true);
        if(!empty($v)){

            $v['proxy'] = $v[$ip]['proxy'];
        } else {
            $v['proxy'] = 'no';
        }



        $data = Location::get($ip);
        $country = $data->countryName == null ? 'Null' : $data->countryName;

        $getbrowser = UserSystemInfoHelper::get_browsers();

        $getos = UserSystemInfoHelper::get_os();
        if ($v['proxy'] == 'yes') {
            if ($setting_vpn->vpn_check == 'yes') {
            echo "<h1>You are using vpn , close it and try again</h1>";
            $inc = Publisher::where('id', $pubid)->increment('vpn_clicks', 1);
            $pu = Publisher::where('id', $pubid)->first();
            if ($pu->vpn_clicks >= $setting_vpn->vpn_click_limit) {
                echo "Your Account is Ban";
                Publisher::where('id', $pubid)->update(['status' => 'banned']);
                $data = array('name' => $pu->name, 'publisher_id' => $pu->id, 'message' => 'Your Account has been Banned Due to Exceeded Vpn Clicks', 'subject' => 'Account Ban', 'email' => $pu->email);

                $smtp_server = Site_setting::find(1);
                $config = array(
                    'driver'     => 'smtp',
                    'host'       => $smtp_server->smtp_host,
                    'port'       => $smtp_server->smtp_port,
                    'username'   => $smtp_server->smtp_user,
                    'password'   => $smtp_server->smtp_password,
                    'encryption' => $smtp_server->smtp_enc,
                    'from'       => array('address' => $smtp_server->from_email, 'name' => $smtp_server->from_name),
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);

                Mail::send('emails.sendmailadmin', ['data' => $data,'setting'=>$smtp_server], function ($message) use ($data) {
                    $smtp_server = Site_setting::find(1);
                    $message->from($smtp_server->from_email, $smtp_server->from_name);
                    $message->to($data['email'], 'Publisher')->subject($data['subject']);
                });
                Auth::guard('publisher')->logout();
            }
        } else {
            $key = $request->query('key');
            $sm = Smartlink::where('key_', $key)->first();
            if ($sm->enabled == 0) {
                return 'Smartlink is Pending';
            }
            if ($sm->enabled == 2) {
                return 'Smartlink is Rejected';
            }

            $category = Smartlink::where('key_', $key)->first();
            $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%' . $country . '%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
            if (empty($qry)) {
                $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%ALL%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
            }
            //         $qry = DB::select("select * from offers as o  where  o.category_id='$category->category_id'
            // and (o.countries like '%$country%' or o.countries='ALL') and o.browsers like '%$getbrowser%'  and o.smartlink=1  and o.ua_target like '%$getos%'  order by rand()  limit 1");

                    $codes = 0;
         $code = md5(rand(1, 999999));
        do {
             $codes = Offer_process::Where('code', $code)->first();
             if(!empty($codes)){
            $code = md5(rand(1, 999999));
             }
        } while (!empty($codes));

            $var = '0';
            if (!empty($qry)) {

                if ($qry->offer_type == 'public') {
                    $var = '1';
                } elseif ($qry->offer_type == 'private') {

                    $qry1 = Approval_request::where('offer_id', $qry->id)->where('publisher_id', $sm->publisher_id)->first();
                    if ($qry1 == '') {
                    } else {
                        if ($qry1->approval_status == 'Approved') {
                            $var = '1';
                        }
                    }
                } else {

                    $qry2 = Offers_publisher::where('offer_id', $qry->id)->where('publisher_id', $sm->publisher_id)->first();

                    if ($qry2 != '') {
                        $var = '1';
                    }
                }


                if ($var == '1') {
                    $unique = '1';
                    $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                    if ($checkUnique != '') {
                        $unique = 0;
                    }
                    $amount = 0;
                    $admin_amount = 0;
                    $publisher_earnings = 0;
                    $site = Site_setting::first();
                    $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                    if ($qry->payout_type == 'revshare') {

                        $amount = 0;
                    } else {

                        $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                        $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                    }
                    $offerProcessData = array(
                        'offer_id' => $qry->id,
                        'offer_name' => $qry->offer_name,
                        'ua_target' => $getos,
                        'browser' => $getbrowser,
                        'country' => $country,
                        'ip_address' => $ip,
                        'code' => $code,
                        'unique_' => $unique,
                        'publisher_id' => $pubid,
                        'payout_type' => $qry->payout_type,
                        'payout' => $qry->payout,
                        'publisher_earned' => $publisher_earnings,
                        'admin_earned' => $admin_amount,
                        'source' => 'smartlink',
                        'key_' => $key,
                        'status' => 'Pending',
                        'advertiser_id' => $qry->advertiser_id

                    );

                    Offer::where('id', $qry->id)->increment('clicks', 1);

                    Offer_process::create($offerProcessData);
                    $network = Advertiser::where('id', $qry->advertiser_id)->first();
                    $q = '';
                    if ($network->param2 == null || $network->param2 == '') {
                        $q = "?&$network->param1=$code&";
                    } else {

                        $q = "?&$network->param1=$code&$network->param2=$pubid&";
                    }


                    return Redirect::to($qry->link . $q);
                } else {

                    //NOW SELECTING PUBLIC OFFERS
                    $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%' . $country . '%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
                    if (empty($qry)) {
                        $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%ALL%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
                    }
                    // $qry = DB::select("select * from offers where   category_id='$category->category_id'
                    // and (countries like '%$country%' or countries='ALL') and browsers like '%$getbrowser%'   and o.smartlink=1  and offer_type='public'  and ua_target like '%$getos%' order by rand()  limit 1");
                    if (!empty($qry)) {
                        $unique = '1';
                        $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                        if ($checkUnique != '') {
                            $unique = 0;
                        }
                        $amount = 0;
                        $admin_amount = 0;
                        $publisher_earnings = 0;
                        $site = Site_setting::first();
                        $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                        if ($qry->payout_type == 'revshare') {

                            $amount = 0;
                        } else {

                            $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                            $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                        }
                        $offerProcessData = array(
                            'offer_id' => $qry->id,
                            'offer_name' => $qry->offer_name,
                            'ua_target' => $getos,
                            'browser' => $getbrowser,
                            'country' => $country,
                            'ip_address' => $ip,
                            'code' => $code,
                            'unique_' => $unique,
                            'publisher_id' => $pubid,
                            'payout_type' => $qry->payout_type,
                            'payout' => $qry->payout,
                            'publisher_earned' => $publisher_earnings,
                            'admin_earned' => $admin_amount,
                            'source' => 'smartlink',
                            'key_' => $key,
                            'status' => 'Pending',
                            'advertiser_id' => $qry->advertiser_id

                        );

                        Offer::where('id', $qry->id)->increment('clicks', 1);

                        Offer_process::create($offerProcessData);
                        $network = Advertiser::where('id', $qry->advertiser_id)->first();
                        $q = '';
                        if ($network->param2 == null || $network->param2 == '') {
                            $q = "?&$network->param1=$code&";
                        } else {

                            $q = "?&$network->param1=$code&$network->param2=$pubid&";
                        }


                        return Redirect::to($qry->link . $q);
                    }
                }
            } else {


                $qry = Offer::where('countries', 'like', '%' . $country . '%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->first();
                if (empty($qry)) {
                    $qry = Offer::where('countries', 'like', '%ALL%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->first();
                }
                //NOW SELECTING PUBLIC OFFERS
                // $qry = DB::select("select * from offers where   (countries like '%$country%' or countries='ALL') and browsers like '%$getbrowser%' and offer_type='public'  and ua_target like '%$getos%' order by rand()  limit 1");
                if (!empty($qry)) {
                    $unique = '1';
                    $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                    if ($checkUnique != '') {
                        $unique = 0;
                    }
                    $amount = 0;
                    $admin_amount = 0;
                    $publisher_earnings = 0;
                    $site = Site_setting::first();
                    $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                    if ($qry->payout_type == 'revshare') {

                        $amount = 0;
                    } else {

                        $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                        $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                    }
                    $offerProcessData = array(
                        'offer_id' => $qry->id,
                        'offer_name' => $qry->offer_name,
                        'ua_target' => $getos,
                        'browser' => $getbrowser,
                        'country' => $country,
                        'ip_address' => $ip,
                        'code' => $code,
                        'unique_' => $unique,
                        'publisher_id' => $pubid,
                        'payout_type' => $qry->payout_type,
                        'payout' => $qry->payout,
                        'publisher_earned' => $publisher_earnings,
                        'admin_earned' => $admin_amount,
                        'payout' => $qry->payout,
                        'source' => 'smartlink',
                        'key_' => $key,
                        'status' => 'Pending',
                        'advertiser_id' => $qry->advertiser_id

                    );

                    Offer::where('id', $qry->id)->increment('clicks', 1);

                    Offer_process::create($offerProcessData);
                    $network = Advertiser::where('id', $qry->advertiser_id)->first();
                    $q = '';
                    if ($network->param2 == null || $network->param2 == '') {
                        $q = "?&$network->param1=$code&";
                    } else {

                        $q = "?&$network->param1=$code&$network->param2=$pubid&";
                    }


                    return Redirect::to($qry->link . $q);
                } else {
                    $qry = Offer::select('*')->where('id', $campid)->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
                            
                    if(!empty($qry->secondary_link)){
                        
                        $network = Advertiser::where('id', $qry->advertiser_id)->first();
                        $q = '';
                        if ($network->param2 == null || $network->param2 == '') {
                            $q = "&$network->param1=$code&";
                        } else {
                            $q = "&$network->param1=$code&$network->param2=$pubid&";
                        }
                        
                        return Redirect::to($qry->secondary_link . $q);
                    }else{
                        echo "No Qualified Offer";
                    }
                        
                }
            }
        }
        } else {
            $key = $request->query('key');
            $sm = Smartlink::where('key_', $key)->first();
            if ($sm->enabled == 0) {
                return 'Smartlink is Pending';
            }
            if ($sm->enabled == 2) {
                return 'Smartlink is Rejected';
            }

            $category = Smartlink::where('key_', $key)->first();
            $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%' . $country . '%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
            if (empty($qry)) {
                $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%ALL%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
            }
            //         $qry = DB::select("select * from offers as o  where  o.category_id='$category->category_id'
            // and (o.countries like '%$country%' or o.countries='ALL') and o.browsers like '%$getbrowser%'  and o.smartlink=1  and o.ua_target like '%$getos%'  order by rand()  limit 1");

                    $codes = 0;
         $code = md5(rand(1, 999999));
        do {
             $codes = Offer_process::Where('code', $code)->first();
             if(!empty($codes)){
            $code = md5(rand(1, 999999));
             }
        } while (!empty($codes));

            $var = '0';
            if (!empty($qry)) {

                if ($qry->offer_type == 'public') {
                    $var = '1';
                } elseif ($qry->offer_type == 'private') {

                    $qry1 = Approval_request::where('offer_id', $qry->id)->where('publisher_id', $sm->publisher_id)->first();
                    if ($qry1 == '') {
                    } else {
                        if ($qry1->approval_status == 'Approved') {
                            $var = '1';
                        }
                    }
                } else {

                    $qry2 = Offers_publisher::where('offer_id', $qry->id)->where('publisher_id', $sm->publisher_id)->first();

                    if ($qry2 != '') {
                        $var = '1';
                    }
                }


                if ($var == '1') {
                    $unique = '1';
                    $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                    if ($checkUnique != '') {
                        $unique = 0;
                    }
                    $amount = 0;
                    $admin_amount = 0;
                    $publisher_earnings = 0;
                    $site = Site_setting::first();
                    $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                    if ($qry->payout_type == 'revshare') {

                        $amount = 0;
                    } else {

                        $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                        $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                    }
                    $offerProcessData = array(
                        'offer_id' => $qry->id,
                        'offer_name' => $qry->offer_name,
                        'ua_target' => $getos,
                        'browser' => $getbrowser,
                        'country' => $country,
                        'ip_address' => $ip,
                        'code' => $code,
                        'unique_' => $unique,
                        'publisher_id' => $pubid,
                        'payout_type' => $qry->payout_type,
                        'payout' => $qry->payout,
                        'publisher_earned' => $publisher_earnings,
                        'admin_earned' => $admin_amount,
                        'source' => 'smartlink',
                        'key_' => $key,
                        'status' => 'Pending',
                        'advertiser_id' => $qry->advertiser_id

                    );

                    Offer::where('id', $qry->id)->increment('clicks', 1);

                    Offer_process::create($offerProcessData);
                    $network = Advertiser::where('id', $qry->advertiser_id)->first();
                    $q = '';
                    if ($network->param2 == null || $network->param2 == '') {
                        $q = "?&$network->param1=$code&";
                    } else {

                        $q = "?&$network->param1=$code&$network->param2=$pubid&";
                    }


                    return Redirect::to($qry->link . $q);
                } else {

                    //NOW SELECTING PUBLIC OFFERS
                    $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%' . $country . '%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
                    if (empty($qry)) {
                        $qry = Offer::where('category_id', $category->category_id)->where('countries', 'like', '%ALL%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->where('smartlink', 1)->first();
                    }
                    // $qry = DB::select("select * from offers where   category_id='$category->category_id'
                    // and (countries like '%$country%' or countries='ALL') and browsers like '%$getbrowser%'   and o.smartlink=1  and offer_type='public'  and ua_target like '%$getos%' order by rand()  limit 1");
                    if (!empty($qry)) {
                        $unique = '1';
                        $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                        if ($checkUnique != '') {
                            $unique = 0;
                        }
                        $amount = 0;
                        $admin_amount = 0;
                        $publisher_earnings = 0;
                        $site = Site_setting::first();
                        $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                        if ($qry->payout_type == 'revshare') {

                            $amount = 0;
                        } else {

                            $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                            $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                        }
                        $offerProcessData = array(
                            'offer_id' => $qry->id,
                            'offer_name' => $qry->offer_name,
                            'ua_target' => $getos,
                            'browser' => $getbrowser,
                            'country' => $country,
                            'ip_address' => $ip,
                            'code' => $code,
                            'unique_' => $unique,
                            'publisher_id' => $pubid,
                            'payout_type' => $qry->payout_type,
                            'payout' => $qry->payout,
                            'publisher_earned' => $publisher_earnings,
                            'admin_earned' => $admin_amount,
                            'source' => 'smartlink',
                            'key_' => $key,
                            'status' => 'Pending',
                            'advertiser_id' => $qry->advertiser_id

                        );

                        Offer::where('id', $qry->id)->increment('clicks', 1);

                        Offer_process::create($offerProcessData);
                        $network = Advertiser::where('id', $qry->advertiser_id)->first();
                        $q = '';
                        if ($network->param2 == null || $network->param2 == '') {
                            $q = "?&$network->param1=$code&";
                        } else {

                            $q = "?&$network->param1=$code&$network->param2=$pubid&";
                        }


                        return Redirect::to($qry->link . $q);
                    }
                }
            } else {


                $qry = Offer::where('countries', 'like', '%' . $country . '%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->first();
                if (empty($qry)) {
                    $qry = Offer::where('countries', 'like', '%ALL%')->where('browsers', 'like', '%' . $getbrowser . '%')->where('offer_type', 'public')->where('ua_target', 'like', '%' . $getos . '%')->first();
                }
                //NOW SELECTING PUBLIC OFFERS
                // $qry = DB::select("select * from offers where   (countries like '%$country%' or countries='ALL') and browsers like '%$getbrowser%' and offer_type='public'  and ua_target like '%$getos%' order by rand()  limit 1");
                if (!empty($qry)) {
                    $unique = '1';
                    $checkUnique = Offer_process::where('offer_id', $qry->id)->where('ip_address', $ip)->where('publisher_id', $pubid)->first();
                    if ($checkUnique != '') {
                        $unique = 0;
                    }
                    $amount = 0;
                    $admin_amount = 0;
                    $publisher_earnings = 0;
                    $site = Site_setting::first();
                    $total_perc = $qry->payout_percentage + $site->affliate_manager_salary_percentage;
                    if ($qry->payout_type == 'revshare') {

                        $amount = 0;
                    } else {

                        $admin_amount = $qry->payout - ($qry->payout * $total_perc / 100);

                        $publisher_earnings = $qry->payout * $qry->payout_percentage / 100;
                    }
                    $offerProcessData = array(
                        'offer_id' => $qry->id,
                        'offer_name' => $qry->offer_name,
                        'ua_target' => $getos,
                        'browser' => $getbrowser,
                        'country' => $country,
                        'ip_address' => $ip,
                        'code' => $code,
                        'unique_' => $unique,
                        'publisher_id' => $pubid,
                        'payout_type' => $qry->payout_type,
                        'payout' => $qry->payout,
                        'publisher_earned' => $publisher_earnings,
                        'admin_earned' => $admin_amount,
                        'payout' => $qry->payout,
                        'source' => 'smartlink',
                        'key_' => $key,
                        'status' => 'Pending',
                        'advertiser_id' => $qry->advertiser_id

                    );

                    Offer::where('id', $qry->id)->increment('clicks', 1);

                    Offer_process::create($offerProcessData);
                    $network = Advertiser::where('id', $qry->advertiser_id)->first();
                    $q = '';
                    if ($network->param2 == null || $network->param2 == '') {
                        $q = "?&$network->param1=$code&";
                    } else {

                        $q = "?&$network->param1=$code&$network->param2=$pubid&";
                    }


                    return Redirect::to($qry->link . $q);
                } else {
                    $qry = Offer::select('*')->where('id', $campid)->where('browsers', 'LIKE', '%' . $getbrowser . '%')->where('ua_target', 'LIKE', '%' . $getos . '%')->first();
                            
                    if(!empty($qry->secondary_link)){
                        
                        $network = Advertiser::where('id', $qry->advertiser_id)->first();
                        $q = '';
                        if ($network->param2 == null || $network->param2 == '') {
                            $q = "&$network->param1=$code&";
                        } else {

                            $q = "&$network->param1=$code&$network->param2=$pubid&";
                        }
                        
                        return Redirect::to($qry->secondary_link . $q);
                    }else{
                        echo "No Qualified Offer";
                    }
                        
                }
            }
        }
    }

    public function Api(Request $request)
    {
        if ($request->pubid != null) {
            $browser = $request->browser;
            $device = $request->device;
            $category_id = $request->category_id;
            $site = DB::table('site_settings')->first();
            $perc = $site->payout_percentage;

            $country = $request->country_name;
            // $device = $request->device;
            $category_id = $request->category_id;
            $site = Site_setting::first();
            $perc = $site->payout_percentage;

            // $country = $request->country_name;
            if ($category_id != null) {
                $data = Offer::select('offers.*')->join('category', 'category.id', 'offers.category_id')->where('offers.offer_type', 'public')->where('offers.smartlink', 0)->where('offers.magiclink', 0)->where('offers.native', 0)->where('offers.lockers', 0)->where('offers.featured_offer', 0)->where('offers.incentive_allowed', 0);
                if(isset($browser) && !empty($browser)){
                     $data= $data->where('offers.browsers', 'like', '%' . $browser . '%');
                }
                if(isset($device) && !empty($device)){
                    $data = $data->where('offers.ua_target', 'like', '%' . $device . '%');
                }
                if(isset($country) && !empty($country)){
                    $data = $data->where('offers.countries', 'like', '%' . $country . '%');
                }
                if(isset($category_id) && !empty($category_id)){
                    $data = $data->where('offers.category_id', 'like', $category_id);
                }
                        $data = $data->get();

                $private_offer = Offer::select('offers.*')->with('category')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', Auth::guard('publisher')->id())->where('offers.offer_type', 'private')->where('offers.smartlink', 0)->where('offers.magiclink', 0)->where('offers.native', 0)->where('offers.lockers', 0)->where('offers.featured_offer', 0)->where('offers.incentive_allowed', 0);
                if (isset($browser) && !empty($browser)) {
                    $private_offer = $private_offer->where('offers.browsers', 'like', '%' . $browser . '%');
                }
                if (isset($device) && !empty($device)) {
                    $private_offer = $private_offer->where('offers.ua_target', 'like', '%' . $device . '%');
                }
                if (isset($country) && !empty($country)) {
                    $private_offer = $private_offer->where('offers.countries', 'like', '%' . $country . '%');
                }
                if (isset($category_id) && !empty($category_id)) {
                    $private_offer = $private_offer->where('offers.category_id', 'like', $category_id);
                }
                $private_offer = $private_offer->get();
                // $data = DB::select("select o.id,o.offer_name,o.link,o.description,c.category_name,o.ua_target,o.browsers,o.countries,o.payout_type,o.payout as payout,o.lead_qty from offers as o join category as c on c.id=o.category_id where o.offer_type='public' and o.browsers like '%$browser%' and o.ua_target like '%$device%' and o.countries like '%$country%' and o.category_id='$category_id' ");
            } else {

                $data = Offer::with('category')->where('offer_type', 'public')->where('smartlink', 0)->where('magiclink', 0)->where('native', 0)->where('lockers', 0)->where('featured_offer', 0)->where('incentive_allowed', 0);
                if (isset($browser) && !empty($browser)) {
                    $data = $data->where('offers.browsers', 'like', '%' . $browser . '%');
                }
                if (isset($device) && !empty($device)) {
                    $data = $data->where('offers.ua_target', 'like', '%' . $device . '%');
                }
                if (isset($country) && !empty($country)) {
                    $data = $data->where('offers.countries', 'like', '%' . $country . '%');
                }
            
                $data = $data->get();
                $private_offer = Offer::select('offers.*')->with('category')->join('approval_request', 'approval_request.offer_id', 'offers.id')->where('approval_request.publisher_id', Auth::guard('publisher')->id())->where('offers.offer_type', 'private')->where('offers.smartlink', 0)->where('offers.magiclink', 0)->where('offers.native', 0)->where('offers.lockers', 0)->where('offers.featured_offer', 0)->where('offers.incentive_allowed', 0);
                if (isset($browser) && !empty($browser)) {
                    $private_offer = $private_offer->where('offers.browsers', 'like', '%' . $browser . '%');
                }
                if (isset($device) && !empty($device)) {
                    $private_offer = $private_offer->where('offers.ua_target', 'like', '%' . $device . '%');
                }
                if (isset($country) && !empty($country)) {
                    $private_offer = $private_offer->where('offers.countries', 'like', '%' . $country . '%');
                }

                $private_offer = $private_offer->get();
                // $data = DB::select("select o.id,o.offer_name,o.link,o.description,c.category_name,o.ua_target,o.browsers,o.countries,o.payout_type,o.payout as payout,o.lead_qty from offers as o left join category as c on c.id=o.category_id where o.offer_type='public' and o.countries like '%$country%' and o.browsers like '%$browser%' and o.ua_target like '%$device%'");
            }
            $array = array();
            foreach ($data as $d) {
                $array[] = array(
                    'id' => $d->id,
                    'offer_name' => $d->offer_name,

                    'link' => $site->default_tracking_domain . '/click?camp=' . $d->id . '&pubid=' . $request->pubid,
                    'description' => $d->description,
                    'category_name' => $d->category->category_name,
                    'ua_target' => $d->ua_target,
                    'browsers' => $d->browsers,
                    'countries' => $d->countries,
                    'payout_type' => $d->payout_type,
                    'payout' => $d->payout * $perc / 100,
                    'lead_qty' => $d->lead_qty,

                );
            }
            foreach ($private_offer as $p) {
                $array[] = array(
                    'id' => $p->id,
                    'offer_name' => $p->offer_name,

                    'link' => $site->default_tracking_domain . '/click?camp=' . $p->id . '&pubid=' . $request->pubid,
                    'description' => $p->description,
                    'category_name' => $p->category->category_name,
                    'ua_target' => $p->ua_target,
                    'browsers' => $p->browsers,
                    'countries' => $p->countries,
                    'payout_type' => $p->payout_type,
                    'payout' => $p->payout * $perc / 100,
                    'lead_qty' => $p->lead_qty,

                );
            }
            return response()->json($array);
        } else {
            return 'Enter Publisher Id';
        }
    }

    public function Postback(Request $request)
    {
        $site = Site_setting::first();

        $postback_pass= $site->postback_password;
        if($postback_pass!==$request->password){
            return 'You are deined.';
        }
        $hash = $request->hash;

        $qry = Offer_process::where('code', $hash)->first();
        if ($qry == '') {
            return 'Invalid Values';
        }

        $postback_url = array(
            'url' => url()->full(),
            'status' => $request->status,
            'offer_process_id' => $qry->id,
            'offer_id' => $qry->offer_id,
            'publisher_id' => $qry->publisher_id
        );
        $offer = Offer::where('id', $qry->offer_id)->first();

        $publisher = Publisher::where('id', $qry->publisher_id)->first();

        if ($request->payout != null) {


            $payout = $request->payout;
        } else {
            $payout = $qry->payout;
        }

        
        $site = Site_setting::first();
        $publisher_earnings = $payout * $offer->payout_percentage / 100;
        $total_perc = $offer->payout_percentage + $site->affliate_manager_salary_percentage;
        $amount = 0;
        $admin_amount = 0;
        $affliate_earning = 0;
        $affliate_earning = ($payout * $site->affliate_manager_salary_percentage / 100);
        $admin_amount = $payout - ($publisher_earnings + $affliate_earning);

        if ($request->status == 1  || $request->status == 'Approved') {

            if ($qry->status == 'Approved' || $qry->status == 'Rejected') {
                return 'It is already ' . $qry->status . '   ,You can not await it';
            } else {
                Offer_process::where('code', $hash)->update(['status' => 'Approved', 'payout' => $payout, 'old_payout' => $qry->payout, 'admin_earned' => $admin_amount, 'publisher_earned' => $publisher_earnings, 'affliate_manager_earnings' => $affliate_earning]);
                Postback_recieve::insert($postback_url);
                $offer = Offer::where('id', $qry->offer_id)->first();
                $publisher = Publisher::where('id', $qry->publisher_id)->first();

                Publisher::where('id', $qry->publisher_id)->increment('balance', $publisher_earnings);
                Publisher::where('id', $qry->publisher_id)->increment('total_earnings', $publisher_earnings);
                Offer::where('id', $qry->offer_id)->increment('leads', 1);
                if ($qry->key_ != null) {
                    Smartlink::where('key_', $qry->key_)->increment('earnings', $publisher_earnings);
                }
                $data = array(
                    'offer_process_id' => $qry->id,
                    'amount' => $publisher_earnings,
                    'publisher_id' => $qry->publisher_id
                );
                Publisher_transaction::create($data);
                $pub = Publisher::where('id', $qry->publisher_id)->first();
                if ($pub->affliate_manager_id != '') {

                    $data1 = array(
                        'offer_process_id' => $qry->id,
                        'amount' => $affliate_earning,
                        'affliate_id' => $pub->affliate_manager_id
                    );
                    Affliate_transaction::create($data1);
                    Affliate::where('id', $pub->affliate_manager_id)->increment('balance', $affliate_earning);
                    Affliate::where('id', $pub->affliate_manager_id)->increment('total_earnings', $affliate_earning);
                }
                $data = array(
                    'publisher_id' => $qry->publisher_id,
                    'earnings' => $publisher_earnings,
                    'lead' => 1,
                );
                Ranking::create($data);


                
        // start script here

        $postback=Postback::where('publisher_id',$qry->publisher_id)->first();

        if($postback!=null){
         $offer_id=$qry->offer_id;
          $offer_name=$qry->offer_name;
         $status='1';
         $payout=$publisher_earnings;
         $code=$qry->code;
         $sid=$qry->sid;
         $sid2=$qry->sid2;
         $sid3=$qry->sid3;
        $sid4=$qry->sid4;
        $sid5=$qry->sid5;
        $ip=$qry->ip_address;
        $browser=$qry->browser;
        $ua_target=$qry->ua_target;
        $url='';
        
        $url=$postback->link;
        $url=str_replace("{offer_id}", $offer_id, $url);
        $url=str_replace("{status}", $status, $url);
        $url= str_replace("{code}", $code, $url);
        $url= str_replace("{payout}", $payout, $url);
        $url= str_replace("{sid}", $sid, $url);
        $url= str_replace("{sid2}", $sid2, $url);
        $url=  str_replace("{sid3}", $sid3, $url);
        $url=  str_replace("{sid4}", $sid4, $url);
        $url=  str_replace("{sid5}", $sid5, $url);
        $url=   str_replace("{ip_address}", $ip, $url);
        $url=   str_replace("{offer_name}", $offer_name, $url);
        $url=   str_replace("{ua_target}", $ua_target, $url);
        $url=     str_replace("{browser}", $browser, $url);
        
        $timeout=5;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        $response=curl_exec($ch);
        curl_close($ch);
        
        
        Postback_sent::insert(
            ['publisher_id'=>$qry->publisher_id,
            'status'=>'Approved',
            'payout'=>$publisher_earnings,
            'offer_id'=>$qry->offer_id,
            'url'=>$url,
                ]
        );
    }
        // end script here


            }
        } elseif ($request->status == 2 || $request->status =='Rejected') {
            Offer_process::where('code', $hash)->update(['status' => 'Rejected', 'payout' => $qry->old_payout, 'old_payout' => $payout, 'admin_earned' => $admin_amount, 'publisher_earned' => $publisher_earnings, 'affliate_manager_earnings' => $affliate_earning]);
            Postback_recieve::insert($postback_url);

            if ($qry->status == 'Approved') {
                Publisher::where('id', $qry->publisher_id)->decrement('balance', $publisher_earnings);
                Publisher::where('id', $qry->publisher_id)->decrement('total_earnings', $publisher_earnings);
                Offer::where('id', $qry->offer_id)->decrement('leads', 1);
                if ($qry->key_ != null) {
                    Smartlink::where('key_', $qry->key_)->decrement('earnings', $publisher_earnings);
                }

                $pub = Publisher::where('id', $qry->publisher_id)->first();

                if ($pub->affliate_manager_id != '') {

                    $affliate_earning = ($qry->payout * $site->affliate_manager_salary_percentage / 100);
                    $data1 = array(
                        'offer_process_id' => $qry->id,
                        'amount' => -1 * $affliate_earning,

                        'affliate_id' => $pub->affliate_manager_id
                    );
                    Affliate_transaction::create($data1);

                    Affliate::where('id', $pub->affliate_manager_id)->decrement('balance', $affliate_earning);
                    Affliate::where('id', $pub->affliate_manager_id)->decrement('total_earnings', $affliate_earning);
                }


                $data = array(
                    'offer_process_id' => $qry->id,
                    'amount' => -1 * $publisher_earnings,
                    'publisher_id' => $qry->publisher_id
                );
                Publisher_transaction::create($data);


                $data = array(
                    'publisher_id' => $qry->publisher_id,
                    'earnings' => -1 * $publisher_earnings,
                    'lead' => -1,
                );
                Ranking::create($data);



                // start script here

        $postback=Postback::where('publisher_id',$qry->publisher_id)->first();

        if($postback!=null){
         $offer_id=$qry->offer_id;
          $offer_name=$qry->offer_name;
         $status='2';
         $payout=$publisher_earnings;
         $code=$qry->code;
         $sid=$qry->sid;
         $sid2=$qry->sid2;
         $sid3=$qry->sid3;
        $sid4=$qry->sid4;
        $sid5=$qry->sid5;
        $ip=$qry->ip_address;
        $browser=$qry->browser;
        $ua_target=$qry->ua_target;
        $url='';
        
        $url=$postback->link;
        $url=str_replace("{offer_id}", $offer_id, $url);
        $url=str_replace("{status}", $status, $url);
        $url=str_replace("{code}", $code, $url);
        $url=str_replace("{payout}", $payout, $url);
        $url=str_replace("{sid}", $sid, $url);
        $url=str_replace("{sid2}", $sid2, $url);
        $url=str_replace("{sid3}", $sid3, $url);
        $url=str_replace("{sid4}", $sid4, $url);
        $url=str_replace("{sid5}", $sid5, $url);
        $url=str_replace("{ip_address}", $ip, $url);
        $url=str_replace("{offer_name}", $offer_name, $url);
        $url=str_replace("{ua_target}", $ua_target, $url);
        $url=str_replace("{browser}", $browser, $url);
        
        $timeout=5;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        $response=curl_exec($ch);
        curl_close($ch);
        
        
        Postback_sent::insert(
            ['publisher_id'=>$qry->publisher_id,
            'status'=>'Rejected',
            'payout'=>$publisher_earnings,
            'offer_id'=>$qry->offer_id,
            'url'=>$url,
                ]
        );
    }
        // end script here

            }
        }
        return 'Postback Recieve Successfully';
    }
}
