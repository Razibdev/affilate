@extends('layouts.app')
    @php $data=UserSystemInfoHelper::site_settings();
    @endphp
@section('content')
 <main class="main" id="top">
      <div class="container-fluid">
        <div class="row min-vh-100 flex-center g-0">
          <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape" src="{{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img class="bg-auth-circle-shape-2" src="{{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
            <div class="card overflow-hidden z-index-1">
              <div class="card-body p-0">
                <div class="row g-0 h-100">
                  <div class="col-md-5 text-center bg-card-gradient">
                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                      <div class="bg-holder bg-auth-card-shape" style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/half-circle.png);">
                      </div>
                      <!--/.bg-holder-->

                       <div class="z-index-1 position-relative"><a
                                                class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                                href="{{ route('home') }}">{{ $data->site_name }}</a>
                                            <p class="opacity-75 text-white">{{ $data->site_description }}</p>
                         
                      </div>
                    </div>
                    <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                      
                    </div>
                  </div>
                  <div class="col-md-7 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                      <h3>Reset password</h3>
                      <form method="POST" action="{{ route('manager.reset-password') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                          <label class="form-label" for="card-reset-password">Email Address</label>
 <input id="email" type="email" class="form-control " name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="card-reset-password">New Password</label>
     <input id="password" type="password" class="form-control " name="password" required autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="card-reset-confirm-password">Confirm Password</label>
    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('manager.reset-password') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control " name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control " name="password" required autocomplete="new-password">

                        
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
@section('js')
    <script type="text/javascript">
        @if (Session::has('success'))
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif
    </script>
@endsection