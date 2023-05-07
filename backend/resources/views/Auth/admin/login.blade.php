@extends('layouts.app')
   @php $data=UserSystemInfoHelper::site_settings();
    @endphp
@section('content')
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                        src="{{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/bg-shape.png"
                        alt="" width="250"><img class="bg-auth-circle-shape-2"
                        src="{{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/shape-1.png"
                        alt="" width="150">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-card-gradient">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <div class="bg-holder bg-auth-card-shape"
                                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/half-circle.png);">
                                        </div>
                                        <!--/.bg-holder-->

                                        <div class="z-index-1 position-relative"><a
                                                class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                                href="{{ route('home') }}">{{ $data->site_name }}</a>
                                            <p class="opacity-75 text-white">{{ $data->site_description }}</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-5 flex-grow-1">
                                        <div class="row flex-between-center">
                                            <div class="col-auto">
                                                <h3>Account Login</h3>
                                            </div>
                                        </div>
                                           <form method="POST" id="admin_login" action="{{ route('admin.login') }}">
                                @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="card-email">Email address</label>


                                        
                                                <input id="device" type="hidden"
                                        class="form-control @error('device') is-invalid @enderror" name="device"
                                        value="{{ old('device') }}" required autocomplete="device" autofocus>
                                    <input id="browser" type="hidden"
                                        class="form-control @error('browser') is-invalid @enderror" name="browser"
                                        value="{{ old('browser') }}" required autocomplete="browser" autofocus>
                                    <input id="country" type="hidden"
                                        class="form-control @error('country') is-invalid @enderror" name="country"
                                        value="{{ old('country') }}" required autocomplete="country" autofocus>
                                    <input id="city" type="hidden" class="form-control @error('city') is-invalid @enderror"
                                        name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Email address" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                


                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <label class="form-label" for="card-password">Password</label>
                                                </div>
                                               <input id="password" type="password" placeholder="Password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="row flex-between-center">
                                                <div class="col-auto">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" id="card-checkbox"
                                                            checked="checked" />
                                                        <label class="form-check-label mb-0" for="card-checkbox">Remember
                                                            me</label>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                                    name="submit">Log in</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="row flex-center min-vh-100 py-6">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card">
                        <div class="card-body p-4 p-sm-5">
                            <div class="row flex-between-center mb-2">
                                <div class="col-auto">
                                    <h5>Log in</h5>
                                </div>

                            </div>
                            <form method="POST" id="admin_login" action="{{ route('admin.login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                    <input id="device" type="hidden"
                                        class="form-control @error('device') is-invalid @enderror" name="device"
                                        value="{{ old('device') }}" required autocomplete="device" autofocus>
                                    <input id="browser" type="hidden"
                                        class="form-control @error('browser') is-invalid @enderror" name="browser"
                                        value="{{ old('browser') }}" required autocomplete="browser" autofocus>
                                    <input id="country" type="hidden"
                                        class="form-control @error('country') is-invalid @enderror" name="country"
                                        value="{{ old('country') }}" required autocomplete="country" autofocus>
                                    <input id="city" type="hidden" class="form-control @error('city') is-invalid @enderror"
                                        name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Email address" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                    <input id="password" type="password" placeholder="Password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row flex-between-center">
                                
                                
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Log
                                        in</button>
                                </div>
                            </form>
                        
                            <div class="row g-2 mt-2">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> --}}
@endsection
@section('js')
    <script type="text/javascript">
        // window.addEventListener('load', function() {
        $(document).ready(function() {
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
            var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(
                ' OPR/') >= 0;

            // Firefox 1.0+
            var isFirefox = typeof InstallTrigger !== 'undefined';

            // Safari 3.0+ "[object HTMLElementConstructor]"
            var isSafari = /constructor/i.test(window.HTMLElement) || (function(p) {
                return p.toString() === "[object SafariRemoteNotification]";
            })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

            // Internet Explorer 6-11
            var isIE = /*@cc_on!@*/ false || !!document.documentMode;

            // Edge 20+
            var isEdge = !isIE && !!window.StyleMedia;

            // Chrome 1 - 79
            var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);

            // Edge (based on chromium) detection
            var isEdgeChromium = isChrome && (navigator.userAgent.indexOf("Edg") != -1);

            // Blink engine detection
            var isBlink = (isChrome || isOpera) && !!window.CSS;


            device = '';
            if (isOpera) {
                device = 'Opera';
            } else if (isFirefox) {
                device = 'Firefox';
            } else if (isSafari) {
                device = 'Safari';
            } else if (isIE) {
                device = 'Internet Explorer';
            } else if (isChrome) {
                device = 'Chrome';

            } else if (isEdge) {
                device = 'Edge';
            } else if (isEdgeChromium) {
                device = 'Edge chromium';
            } else if (isBlink) {
                device = 'Blink';
            }


            $('input[name=device]').val(device);
            $('input[name=browser]').val(getUA());
            //  $.ajax('https://api.ipbase.com/v1/json/')
            //   .then(
            //       function success(response) {

            //    $('input[name=country]').val(response.country_name);
            //    $('input[name=city]').val(response.city);
            //         })



            $('#admin_login').submit(function(e) {

                $('.loader').fadeIn();
                e.preventDefault();
                var form = $(this);
                form.prev('.alert').remove();
                form.find('.text-danger').remove();
                $.ajax({
                    url: "{{ route('admin.login.submit') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: form.serialize(),
                    success: function(result) {
                        $('.loader').fadeOut();
                        // console.log(result);
                        if (!result.status) {
                            Swal.fire('Failed', result.message, 'error');

                        } else {
                            Swal.fire('Success', result.message, 'success');

                            form[0].reset();
                            location.replace('{{ route('admin.dashboard') }}');

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
@endsection
