<!DOCTYPE html>

@if (!empty(Auth::guard('publisher')->user()->name))
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @php
    $data = UserSystemInfoHelper::site_settings();
        $user_notification = UserSystemInfoHelper::News_and_announcement();
        $all_offer = UserSystemInfoHelper::all_offer();
    @endphp

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{  $data->site_name }} Publisher Panel</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="manifest" href="{{ config('app.url') }}/public/public/assets/img/favicons/manifest.json">
        <meta name="msapplication-TileImage" content="{{ asset('site_images') }}/{{ $data->icon }}">
        <meta name="theme-color" content="#ffffff">

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->


        <link href="{{ config('app.url') }}/public/public/assets/css/theme.min.css" rel="stylesheet">
        <link href="{{ config('app.url') }}/public/public/assets/css/user.min.css" rel="stylesheet">
        <link href="{{ config('app.url') }}/public/public/assets/css/main.css" rel="stylesheet">
        {{-- <link href="{{ config('app.url') }}/public/public/assets/css/theme-rtl.min.css" rel="stylesheet"> --}}
        <link href="{{ config('app.url') }}/public/public/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
        <link href="{{ config('app.url') }}/public/public/vendors/dropzone/dropzone.min.css" rel="stylesheet">
        <link href="{{ config('app.url') }}/public/public/vendors/prism/prism-okaidia.css" rel="stylesheet">
        <link href="{{ config('app.url') }}/public/public/vendors/overlayscrollbars/OverlayScrollbars.min.css"
            rel="stylesheet">
        <link href="{{ config('app.url') }}/public/public/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet">

    </head>


    <body>

        <!-- ===============================================-->
        <!--    Main Content-->
        <!-- ===============================================-->
        <main class="main" id="top">
            <div class="container" data-layout="container">
                <script>
                    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                    if (isFluid) {
                        var container = document.querySelector('[data-layout]');
                        container.classList.remove('container');
                        container.classList.add('container-fluid');
                    }
                </script>
                <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
                    <script>
                        var navbarStyle = localStorage.getItem("navbarStyle");
                        if (navbarStyle && navbarStyle !== 'transparent') {
                            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                        }
                    </script>
                    <div class="d-flex align-items-center">
                        <div class="toggle-icon-wrapper">

                            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span
                                    class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                        </div><a class="navbar-brand" href="{{ route('publisher.dashboard') }}">
                            <div class="d-flex align-items-center py-3"><img class="me-2"
                                    src="{{ asset('site_images') }}/{{ $data->logo }}" alt=""
                                    width="150" />
                            </div>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                        <div class="navbar-vertical-content scrollbar">
                            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                                @if (Auth::guard('publisher')->user()->status == 'Active')
                                    <li class="nav-item">
                                        <!-- parent pages--><a class="nav-link "
                                            href="{{ route('publisher.dashboard') }}" role="button">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-chart-line"></span></span><span
                                                    class="nav-link-text ps-1">Dashboard</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <!-- parent pages--><a class="nav-link "
                                            href="{{ route('publisher.show-smartlink') }}" role="button">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-link"></span></span><span
                                                    class="nav-link-text ps-1">Smart Link</span>
                                            </div>
                                        </a>
                                    </li>

                                    @if (Auth::guard('publisher')->user()->expert_mode == '1')
                                    <li class="nav-item">
                                        <!-- parent pages-->
                                        <a class="nav-link dropdown-indicator" href="#cpa_offers" role="button"
                                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="cpa_offers">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="far fa-list-alt"></span></span><span
                                                    class="nav-link-text ps-1">CPA Offers</span>
                                            </div>
                                        </a>
                                        <ul class="nav collapse " id="cpa_offers">
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.all-offers') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">All Offers</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.my-offers') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">My Offers</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>
                                           
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.new-offers') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">New Offers</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.top-offers') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Top Offers</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>

                                        </ul>
                                    </li>
                                    @endif
                                    
                                    <li class="nav-item">
                                        <!-- parent pages-->
                                        <a class="nav-link dropdown-indicator" href="#reports" role="button"
                                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="reports">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-chart-pie"></span></span><span
                                                    class="nav-link-text ps-1">Reports</span>
                                            </div>
                                        </a>
                                        <ul class="nav collapse " id="reports">
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.reports') }}" aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Conversion Report</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.daily-report') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Click Report</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>



                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.report-by-date') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Report By Date</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>

                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.report-by-device') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Report By Device</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>


                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.report-by-browser') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Report By Browser</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>


                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.report-by-country') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Report By Country</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.report-by-sid') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Report By SID</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>


                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <!-- parent pages--><a class="nav-link dropdown-indicator" href="#My_account"
                                            role="button" data-bs-toggle="collapse" aria-expanded="true"
                                            aria-controls="My_account">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-user-graduate"></span></span><span
                                                    class="nav-link-text ps-1">My Account</span>
                                            </div>
                                        </a>
                                        <ul class="nav collapse" id="My_account">
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.account-information') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Account Information</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.login-history') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Login History</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <!-- parent pages--><a class="nav-link "
                                            href="{{ route('publisher.payment-history') }}" role="button">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-money-bill"></span></span><span
                                                    class="nav-link-text ps-1">Payment History</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <!-- parent pages--><a class="nav-link "
                                            href="{{ route('publisher.support') }}" role="button">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-sms"></span></span><span
                                                    class="nav-link-text ps-1">Support</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <!-- parent pages--><a class="nav-link "
                                        href="{{ route('publisher.chat', Auth::guard('publisher')->user()->affliate_manager_id) }}"
                                        role="button">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fab fa-facebook-messenger"></span></span><span
                                                class="nav-link-text ps-1">Chat</span>
                                        </div>
                                    </a>
                                </li>
                                @if (Auth::guard('publisher')->user()->status == 'Active')
                                    <li class="nav-item">
                                        <!-- parent pages--><a class="nav-link dropdown-indicator" href="#postback"
                                            role="button" data-bs-toggle="collapse" aria-expanded="true"
                                            aria-controls="postback">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-expand-alt"></span></span><span
                                                    class="nav-link-text ps-1">Postback</span>
                                            </div>
                                        </a>
                                        <ul class="nav collapse " id="postback">
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.postback') }}" aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Global Postback</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>
                                            <li class="nav-item"><a class="nav-link"
                                                    href="{{ route('publisher.send-postback') }}"
                                                    aria-expanded="false">
                                                    <div class="d-flex align-items-center"><span
                                                            class="nav-link-text ps-1">Postback sent</span>
                                                    </div>
                                                </a>
                                                <!-- more inner pages-->
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <!-- parent pages--><a class="nav-link "
                                            href="{{ route('publisher.api') }}" role="button"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-code"></span></span><span
                                                    class="nav-link-text ps-1">API</span>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            </ul>

                        </div>
                    </div>
                </nav>
                <div class="content">
                    <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                        <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                            aria-controls="navbarVerticalCollapse" aria-expanded="false"
                            aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                    class="toggle-line"></span></span></button>
                        <a class="navbar-brand me-1 me-sm-3" href="{{ route('publisher.dashboard') }}">
                            <div class="d-flex align-items-center"><img class="me-2"
                                    src="{{ asset('site_images') }}/{{ $data->logo }}" alt=""
                                    width="150" />
                            </div>
                        </a>
                        <ul class="navbar-nav align-items-center d-none d-lg-block">
                            <li class="nav-item">
                                <div class="search-box" data-list='{"valueNames":["title"]}'>
                                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                        <input class="form-control search-input fuzzy-search" id="offer_search_box"
                                            type="search" placeholder="Search..." aria-label="Search" />
                                        <span class="fas fa-search search-box-icon"></span>

                                    </form>
                                    <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
                                        data-bs-dismiss="search">
                                        <div class="btn-close-falcon" aria-label="Close"></div>
                                    </div>
                                    <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100"
                                        id="all_offers_results">
                                        @if (Auth::guard('publisher')->user()->status=== 'Active')
                                        <div class="scrollbar list py-3" style="max-height: 24rem;">
                                            <h6
                                                class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                                                Results Offers</h6>
                                            @foreach ($all_offer as $offer)
                                                <a class="dropdown-item px-card py-2"
                                                    href="{{ route('publisher.offers-details', $offer->id) }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="file-thumbnail me-2"><img
                                                                class="border h-100 w-100 fit-cover rounded-3"
                                                                src="{{ asset('uploads') }}/{{ $offer->preview_url }}"
                                                                alt="" />
                                                        </div>
                                                        <div class="flex-1">
                                                            <h6 class="mb-0 title">{{ $offer->offer_name }}</h6>
                                                            <p class="fs--2 mb-0 d-flex"><span
                                                                    class="fw-semi-bold">{{ $offer->status }}</span><span
                                                                    class="fw-medium text-600 ms-2">{{ $offer->created_at }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach


                                            <hr class="bg-200 dark__bg-900" />


                                        </div>
                                        @endif
                                        <div class="text-center mt-n3">
                                            <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                            <li class="nav-item">
                                <div class="theme-control-toggle fa-icon-wait px-2">
                                    <input class="form-check-input ms-0 theme-control-toggle-input"
                                        id="themeControlToggle" type="checkbox" data-theme-control="theme"
                                        value="dark" />
                                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                                        for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                                        for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait"
                                    id="navbarDropdownNotification" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                        class="fas fa-bell" data-fa-transform="shrink-6"
                                        style="font-size: 33px;"></span></a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification"
                                    aria-labelledby="navbarDropdownNotification">
                                    <div class="card card-notification shadow-none">
                                        <div class="card-header">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-auto">
                                                    <h6 class="card-header-title mb-0">Notifications</h6>
                                                </div>
                                                <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal"
                                                        href="#">Mark all as read</a></div>
                                            </div>
                                        </div>
                                        <div class="scrollbar-overlay" style="max-height:19rem">
                                            <div class="list-group list-group-flush fw-normal fs--1">
                                                <div class="list-group-title border-bottom">NEW</div>

                                                @php $messages=UserSystemInfoHelper::get_all_messages('admin');@endphp
                                                @foreach ($user_notification as $notification)
                                                    <div class="list-group-item">
                                                        

                                                            <div class="alert alert-success text-center">
                                                                <div class="alert alert-primary">
                                                                    {{ $notification->title }}</div>
                                                                {{ $notification->description }}
                                                            </div>

                                                        

                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>
                                        <div class="card-footer text-center border-top"><a class="card-link d-block"
                                                href="{{ route('publisher.support') }}">View all</a>
                                        </div>
                                    </div>
                                </div>

                            </li>
                            <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="avatar avatar-xl">
                                        <img class="rounded-circle"
                                            src="{{ UserSystemInfoHelper::publishar_image(Auth::guard('publisher')->user()->publisher_image) }}"
                                            alt="" />

                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0"
                                    aria-labelledby="navbarDropdownUser">
                                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                        <a class="dropdown-item fw-bold text-warning" href="#!"><span
                                                class="fas fa-crown me-1"></span><span>{{ Auth::guard('publisher')->user()->name }}</span></a>

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                            href="{{ route('publisher.account-information') }}">Profile &amp;
                                            Account</a>

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                            href="{{ route('publisher.account-information') }}">Settings</a>

                                        <a class="dropdown-item" href="{{ route('publisher.logout') }}"
                                            onclick="event.preventDefault();
                                                         document.getElementById('publisher-logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="publisher-logout-form" action="{{ route('publisher.logout') }}"
                                            method="POST" class="d-none">
                                            @csrf
                                        </form>

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <div class="content">
                        <div class="row g-3 mb-3">

                            @if (Auth::guard('publisher')->user()->status=== 'Active')
                                 @yield('content')
                            @else
                                @if (Request::url() === route('publisher.chat', Auth::guard('publisher')->user()->affliate_manager_id))
                                    @yield('content')
                            
                                        
                                    @else
                                        <div class="card-body bg-light">
                                          <div class="row justify-content-center">
                                            <div class="col-lg-10 col-xxl-12">
                                              <div class="card shadow-none mb-3"><img class="card-img-top" src="{{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/6.png" alt="" />
                                                <div class="card-body">
                                                  <h3 class="fw-semi-bold">Hey Dude, Welcome to KingsOfAffiliate Network!</h3>
                                                  <p>Currently Your account is <span style="color:maroon;font-widht:bold;">Waiting for Approval</span></p>
                                                  <p>If you want to <span style="color:green;font-width:bold;">Active</span>  your account then Your are Requested to Talk with Your Manager.</p>
                                                  <p>Your Personal Account Manager <span style="color:green;font-width:bold;">Email:</span>  support@kingsofaffiliate.com</p>
                                                  <div class="text-center">
                                                    <button class="btn btn-success btn-lg my-3" type="button"><a href="{{ route('publisher.chat', Auth::guard('publisher')->user()->affliate_manager_id) }}" style="text-decoration:none;color:white;">Talk Now</a></button><div class="text-center">
                                                    <button class="btn btn-success btn-lg my-3" type="button"><a href="#" style="text-decoration:none;color:white;">Skype</a></button><small class="d-block">For any issues faced, Please contact with your <a href="{{ route('publisher.chat', Auth::guard('publisher')->user()->affliate_manager_id) }}">Manager</a>.</small>
                                                  </div>
                                                </div>
                                              </div>
                                             
                                            </div>
                                          </div>
                                         </div>
                                    @endif
                            
                            @endif
                        </div>
                        <footer class="footer">
                        <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600">Copyright @ <a href="https://kingsofaffiliate.com">KingsOfAffiliate Team</a><span
                                        class="d-none d-sm-inline-block"> | </span><br class="d-sm-none" /> All Right Reserved.
                                </p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600">v3.4.0</p>
                            </div>
                        </div>
                    </footer>
                    </div>

                    
                </div>

            </div>
        </main>
        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->



        {{-- <a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
      <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
        <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
          <div class="settings-popover"><span class="ripple"><span class="fa-spin position-absolute all-0 d-flex flex-center"><span class="icon-spin position-absolute all-0 d-flex flex-center">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z" fill="#2A7BE4"></path>
                  </svg></span></span></span></div>
        </div><small class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">customize</small>
      </div>
    </a> --}}

        <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
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
        <script src="{{ config('app.url') }}/public/public/vendors/echarts/echarts.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/lodash/lodash.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/validator/validator.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/prism/prism.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/fontawesome/all.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/lodash/lodash.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/fontawesome/all.min.js"></script>
        {{-- <script src="{{ config('app.url') }}/public/public/vendors/list.js/list.min.js"></script> --}}
        <script src="{{ config('app.url') }}/public/public/vendors/fontawesome/all.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/sweetalert2/sweetalert2.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/assets/js/theme.js"></script>
        <script src="{{ config('app.url') }}/public/plugins/select2/js/select2.min.js"></script>
        @yield('js')
        <script>
            $(function() {
                $('#offer_search_box').keyup(function() {
                    var text = $(this).val();
                    var csrf = $("meta[name=csrf-token]").attr("content");
                    $.ajax({
                        url: "{{ route('admin.search_offer_dashboard') }}",
                        type: 'post',
                        dataType: 'JSON',
                        headers: {
                            "X-CSRFToken": csrf
                        },
                        data: {
                            "_token": csrf,
                            'text': text,
                            'route': 'publisher'
                        },
                        success: function(result) {
                            $('.loader').fadeOut();
                            // console.log(result);
                            if (!result.status) {
                                Swal.fire('Failed', result.message, 'error');

                            } else {

                                $('#all_offers_results').empty();
                                // $('.emojiarea-editor').empty();
                                // $('#chat-message').val('');
                                // $('#chat-file-upload').val('');
                                $('#all_offers_results').append(result.data);


                            }
                        },

                    });
                });
            });
        </script>
        
        
        <script src="//code.tidio.co/c5lgggj2cufhto4wgnxqzbf75dl4taef.js" async></script>
    </body>

    </html>
@endif
