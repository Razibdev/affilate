<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @php $data=UserSystemInfoHelper::site_settings();
     @endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{  $data->site_name }}</title>


    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link href="{{ config('app.url') }}/public/public/assets/css/theme.css" rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/assets/css/user.css" rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/assets/css/main.css" rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/assets/css/theme-rtl.min.css" rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/vendors/dropzone/dropzone.min.css" rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/vendors/prism/prism-okaidia.css" rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/vendors/overlayscrollbars/OverlayScrollbars.min.css"
        rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet">


</head>

<body>
    <div id="app">
        

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/assets/js/jquery.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/assets/js/app.js"></script>
    <script src="{{ config('app.url') }}/public/public/assets/js/config.js"></script>
    <script src="{{ config('app.url') }}/public/public/assets/js/flatpickr.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/popper/popper.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/is/is.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/dropzone/dropzone.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/lottie/lottie.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/validator/validator.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/prism/prism.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/fontawesome/all.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/lodash/lodash.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/list.js/list.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/fontawesome/all.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/assets/js/theme.js"></script>
    @yield('js')
    <script type="text/javascript"></script>
</body>

</html>
