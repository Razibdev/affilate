@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-center min-vh-100 py-6 text-center">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="mb-0">Forgot your password?</h5><small>Enter your email and we'll send you a
                            reset link.</small>
                        <form class="mt-4" method="POST" action="{{ route('publishar.password.email') }}">
                            <input class="form-control" type="email" placeholder="Email address" />
                            <div class="mb-3"></div>
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Send reset
                                link</button>
                        </form><a class="fs--1 text-600" href="#!">I can't recover my account using this page<span
                                class="d-inline-block ms-1">&rarr;</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {});
    </script>
@endsection
