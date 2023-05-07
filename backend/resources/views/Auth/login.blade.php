@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" id="publishar_login" action="{{ route('publisher.login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="device" type="hidden" class="form-control @error('device') is-invalid @enderror" name="device" value="{{ old('device') }}" required autocomplete="device" autofocus>
                                <input id="browser" type="hidden" class="form-control @error('browser') is-invalid @enderror" name="browser" value="{{ old('browser') }}" required autocomplete="browser" autofocus>
                                <input id="country" type="hidden" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required autocomplete="country" autofocus>
                                <input id="city" type="hidden" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript">
        // window.addEventListener('load', function() {
            $(document).ready(function() {
                    @if (Session::has('success'))
            Swal.fire({
                title: '{{ Session::get('success') }}',


                confirmButtonText: 'Ok'
            })
        @endif
                   const getUA = () => {
    let device = "Unknown";
    const ua = {
        "Generic Linux": /Linux/i,
        "Android": /Android/i,
        "BlackBerry": /BlackBerry/i,
        "Bluebird": /EF500/i,
        "Chrome OS": /CrOS/i,
        "Datalogic": /DL-AXIS/i,
        "Honeywell": /CT50/i,
        "iPad": /iPad/i,
        "iPhone": /iPhone/i,
        "iPod": /iPod/i,
        "macOS": /Macintosh/i,
        "Windows": /IEMobile|Windows/i,
        "Zebra": /TC70|TC55/i,
    }
    Object.keys(ua).map(v => navigator.userAgent.match(ua[v]) && (device = v));
    return device;
}

console.log(getUA());

// Opera 8.0+
var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

// Firefox 1.0+
var isFirefox = typeof InstallTrigger !== 'undefined';

// Safari 3.0+ "[object HTMLElementConstructor]"
var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

// Internet Explorer 6-11
var isIE = /*@cc_on!@*/false || !!document.documentMode;

// Edge 20+
var isEdge = !isIE && !!window.StyleMedia;

// Chrome 1 - 79
var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);

// Edge (based on chromium) detection
var isEdgeChromium = isChrome && (navigator.userAgent.indexOf("Edg") != -1);

// Blink engine detection
var isBlink = (isChrome || isOpera) && !!window.CSS;


device='';
if(isOpera){
    device='Opera';
}
else if(isFirefox){
    device='Firefox';
}
else if(isSafari){
    device='Safari';
}
else if(isIE){
    device='Internet Explorer';
}
else if(isChrome){
    device='Chrome';

}
else if(isEdge){
    device='Edge';
}
else if(isEdgeChromium){
    device='Edge chromium';
}
else if(isBlink){
    device='Blink';
}


$('input[name=device]').val(device);
$('input[name=browser]').val(getUA());
 $.ajax('https://api.ipbase.com/v1/json/')
  .then(
      function success(response) {

   $('input[name=country]').val(response.country_name);
   $('input[name=city]').val(response.city);
        })
    

    
                $('#publishar_login').submit(function(e) {
                    
                    $('.loader').fadeIn();
                    e.preventDefault();
                    var form = $(this);
                    form.prev('.alert').remove();
                    form.find('.text-danger').remove();
                    $.ajax({
                        url: "{{ route('publisher.login.submit') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: form.serialize(),
                        success: function(result) {
                            $('.loader').fadeOut();
                            // console.log(result);
                            if (!result.status) {
                                 Swal.fire('Failed',result.message,'error');
                                
                            } else {
                                 Swal.fire('Success', result.message,'success');
                                
                                form[0].reset();

                            }
                        },
                        error: function(xhr) {
                            $('.loader').fadeOut();
                            if (xhr.status == 422) {
                                $.each(xhr.responseJSON.errors, function(k, v) {
                                    form.find('[name="' + k + '"]').after(
                                        '<div class="text-danger">' + v[0] +
                                        '</div>');
                                });
                            } else if (xhr.status == 419) {
                                window.location.href = "";
                            }
                            // console.log(xhr);
                        }
                    });
                });
            });
    </script>
@endsection;
