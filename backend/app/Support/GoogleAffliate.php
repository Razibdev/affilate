<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\Support\Authenticator;
use Auth;
class GoogleAffliate extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    { 


        if(Auth::guard('affliate')->user()->affliateSecurity == null)
            return true;
  return 
            !Auth::guard('affliate')->user()->affliateSecurity->google2fa_enable ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }
        protected function noUserIsAuthenticated()
    { 
        return is_null(Auth::guard('affliate')->user());
    }


    protected function getGoogle2FASecretKey()
    {
        $secret =Auth::guard('affliate')->user()->affliateSecurity->{$this->config('otp_secret_column')};
 
        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }

}