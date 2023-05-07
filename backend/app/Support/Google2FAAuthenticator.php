<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\Support\Authenticator;
use Illuminate\Support\Facades\Auth;
class Google2FAAuthenticator extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    { 


        if(Auth::guard('publisher')->user()->loginSecurity == null)
            return true;
  return 
            !Auth::guard('publisher')->user()->loginSecurity->google2fa_enable ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }
        protected function noUserIsAuthenticated()
    {
        return is_null(Auth::guard('publisher')->user());
    }


    protected function getGoogle2FASecretKey()
    {
        $secret =Auth::guard('publisher')->user()->loginSecurity->{$this->config('otp_secret_column')};
 
        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }

}