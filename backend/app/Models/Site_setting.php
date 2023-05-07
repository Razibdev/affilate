<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site_setting extends Model
{
    use HasFactory;
     protected $fillable = [
       'site_name','site_description','logo','icon','auto_signup','minimum_withdraw_amount','payout_percentage','referral_percentage','disable_signup','default_tracking_domain','default_smartlink_domain','default_affliate_manager','default_payment_terms','cdn_url','affliate_manager_salary_percentage','vpn_api','master_key','vpn_check','vpn_click_limit','smtp_host','smtp_port','smtp_user','smtp_password','smtp_enc','from_email','from_name','from_security','zerobounce_api','zerobounce_check',
    ];
}
