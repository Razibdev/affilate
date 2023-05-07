<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ config('app.url') }}/public/public/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ config('app.url') }}/public/public/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ config('app.url') }}/public/public/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ config('app.url') }}/public/public/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="{{ config('app.url') }}/public/public/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage"
        content="{{ config('app.url') }}/public/public/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ config('app.url') }}/public/public/assets/js/config.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ config('app.url') }}/public/public/vendors/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ config('app.url') }}/public/public/vendors/overlayscrollbars/OverlayScrollbars.min.css"
        rel="stylesheet">
    {{-- <link href="{{ config('app.url') }}/public/public/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl"> --}}
    <link href="{{ config('app.url') }}/public/public/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    {{-- <link href="{{ config('app.url') }}/public/public/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl"> --}}
    <link href="{{ config('app.url') }}/public/public/assets/css/user.min.css" rel="stylesheet"
        id="user-style-default">

</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark"
            data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
            <div class="container"><a class="navbar-brand" href="../index.html"><span
                        class="text-white dark__text-white">Falcon</span></a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
                    <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
                        <li class=""><a class="nav-link " href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                id="homes">Home</a>
                            
                        </li>
                        <li class=""><a class="nav-link " href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                id="apps">Payout Model</a>
                            
                        </li>
                        <li class=""><a class="nav-link " href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                id="about_us">About Us</a>

                        </li>
                        <li class=""><a class="nav-link " href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                id="moduless">Why Choose Us?</a>

                        </li>
                        
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        @if (empty(Auth::guard('publisher')->user()->name))
                            @if (Route::has('publisher.login'))
                                <li class="nav-item "><a class="nav-link " id="navbarDropdownLogin"
                                        href="{{ route('publisher.login') }}" role="button">Login</a>
                                </li>
                            @endif
                            @if (Route::has('publisher.register'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('publisher.register') }}"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">Register</a></li>
                            @endif
                        @else
                            <li class=""><a class="nav-link "
                                    id="navbarDropdownLogin" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">My account</a>

                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <section class="py-0 overflow-hidden light" id="banner">

            <div class="bg-holder overlay"
                style="background-image:url({{ config('app.url') }}/public/public/assets/img/generic/bg-1.jpg);background-position: center bottom;">
            </div>
            <!--/.bg-holder-->

            <div class="container">
                <div class="row flex-center pt-8 pt-lg-10 pb-lg-9 pb-xl-0">
                    <div class="col-md-11 col-lg-8 col-xl-4 pb-7 pb-xl-9 text-center text-xl-start"><a
                            class="btn btn-outline-danger mb-4 fs--1 border-2 rounded-pill" href="#!"><span
                                class="me-2" role="img" aria-label="Gift">🎁</span>Become a Publisher</a>
                        <h3 class="text-white fw-light">A CPA Network that <br />contains <span class="typed-text fw-bold"
                                data-typed-text='["Premium CPC","Premium CPL","Premium CPA"]'></span></h3>
                        <p class="lead text-white opacity-75">We focus on cloud and AI for faster speed of the network perfermance</p><a
                            class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2"
                            href="#!">Start building with the falcon<span class="fas fa-play ms-2"
                                data-fa-transform="shrink-6 down-1"></span></a>
                    </div>
                    <div class="col-xl-7 offset-xl-1 align-self-end mt-4 mt-xl-0"><a
                            class="img-landing-banner rounded" href="../index.html"><img class="img-fluid"
                                src="{{ config('app.url') }}/public/public/assets/img/generic/dashboard-alt.jpg"
                                alt="" /></a></div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        @yield('content')




        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="bg-dark pt-8 pb-4 light">

            <div class="container">
                <div class="position-absolute btn-back-to-top bg-dark"><a class="text-600" href="#banner"
                        data-bs-offset-top="0" data-scroll-to="#banner"><span class="fas fa-chevron-up"
                            data-fa-transform="rotate-45"></span></a></div>
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="text-uppercase text-white opacity-85 mb-3">Our Mission</h5>
                        <p class="text-600">Hasprofit is Premium CPA Network that contains premiums offers based on CPL, CPC and CPA. Traffic Firenly smart links system and the echo system that protect our Advertisers from the Fraud. There is no limit for conversions and offers for long and lifetime.</p>
                        <div class="icon-group mt-4"><a class="icon-item bg-white text-facebook" href="#!"><span
                                    class="fab fa-facebook-f"></span></a><a class="icon-item bg-white text-twitter"
                                href="#!"><span class="fab fa-twitter"></span></a><a
                                class="icon-item bg-white text-google-plus" href="#!"><span
                                    class="fab fa-google-plus-g"></span></a><a
                                class="icon-item bg-white text-linkedin" href="#!"><span
                                    class="fab fa-linkedin-in"></span></a><a class="icon-item bg-white"
                                href="#!"><span class="fab fa-medium-m"></span></a></div>
                    </div>
                    <div class="col ps-lg-6 ps-xl-8">
                        <div class="row mt-5 mt-lg-0">
                            <div class="col-6 col-md-3">
                                <h5 class="text-uppercase text-white opacity-85 mb-3">Quick Link</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-1"><a class="link-600" href="{{ route('privacy') }}">Privacy Policy</a></li>
                                    <li class="mb-1"><a class="link-600" href="{{ route('refund') }}">Refund Policy</a></li>
                                    <li class="mb-1"><a class="link-600" href="{{ route('terms') }}">Terms of Service</a></li>
                                    <li class="mb-1"><a class="link-600" href="{{ route('dmca') }}">DMCA</a></li>
                            
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <h5 class="text-uppercase text-white opacity-85 mb-3">Product</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-1"><a class="link-600" href="{{ route('publisher.register') }}">Rgister</a></li>
                                    <li class="mb-1"><a class="link-600" href="{{ route('publisher.login') }}">Sign In</a></li>
                                    <li class="mb-1"><a class="link-600" href="{{ route('contact') }}">Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="col mt-5 mt-md-0">
                                <h5 class="text-uppercase text-white opacity-85 mb-3">From the Blog</h5>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->




        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-0 bg-dark light">

            <div>
                <hr class="my-0 text-600 opacity-25" />
                <div class="container py-3">
                    <div class="row justify-content-between fs--1">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600 opacity-85">Thank you for creating with Falcon <span
                                    class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2021 &copy; <a
                                    class="text-white opacity-85" href="https://themewagon.com">Themewagon</a></p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600 opacity-85">v3.4.0</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->



    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->





    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ config('app.url') }}/public/public/vendors/popper/popper.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/is/is.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/typed.js/typed.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/fontawesome/all.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ config('app.url') }}/public/public/vendors/list.js/list.min.js"></script>
    <script src="{{ config('app.url') }}/public/public/assets/js/theme.js"></script>
    @yield('js')
</body>

</html>
