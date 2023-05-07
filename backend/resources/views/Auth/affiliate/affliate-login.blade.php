@extends('layouts.app')

@section('content')
 
    @php $data=UserSystemInfoHelper::site_settings();
    @endphp
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
                                           <form method="POST" id="affliate_login"  class="form" action="{{ route('manager.login') }}">
                                             @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="card-email">Email address</label>


                                        
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email"
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
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">

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
                                                <div class="col-auto">    @if (Route::has('manager.forgot_password'))
                                    <a class="btn btn-link" href="{{ route('manager.forgot_password') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif</div>
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

    

@endsection
@section('js')
    <script type="text/javascript">
        // window.addEventListener('load', function() {
        
        @if (Session::has('success'))
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif
    
        $(document).ready(function() {
    

            $('#affliate_login').submit(function(e) {

                $('.loader').fadeIn();
                e.preventDefault();
                var form = $(this);
                form.prev('.alert').remove();
                form.find('.text-danger').remove();
                $.ajax({
                    url: "{{ route('manager.login.submit') }}",
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
                            location.replace('{{ route('beforelogin') }}');

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
