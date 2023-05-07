<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\Support\Authenticator;
use Auth;
class GoogleAdmin extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    { 


        if(Auth::guard('admin')->user()->adminSecurity == null)
            return true;
  return 
            !Auth::guard('admin')->user()->adminSecurity->google2fa_enable ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }
        protected function noUserIsAuthenticated()
    { 
        return is_null(Auth::guard('admin')->user());
    }


    protected function getGoogle2FASecretKey()
    {
        $secret =Auth::guard('admin')->user()->adminSecurity->{$this->config('otp_secret_column')};
 
        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }

}