<!DOCTYPE html>

@if (!empty(Auth::guard('admin')->user()->name))
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @php
    $data = UserSystemInfoHelper::site_settings();
        $all_offer = UserSystemInfoHelper::all_offer();
    @endphp

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $data->site_name }} Admin Panel</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('site_images') }}/{{ $data->icon }}">
        <link rel="manifest" href="{{ config('app.url') }}/public/public/assets/img/favicons/manifest.json">
        <meta name="msapplication-TileImage" content="{{ asset('site_images') }}/{{ $data->icon }}">
        <meta name="theme-color" content="#ffffff">

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>

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

                        </div>
                        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                            <div class="d-flex align-items-center py-3"><img class="me-2"
                                    src="{{ asset('site_images') }}/{{ $data->logo }}" alt=""
                                    width="150" /><span class="font-sans-serif"></span>
                            </div>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                        <div class="navbar-vertical-content scrollbar">
                            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('admin.dashboard') }}" role="button"
                                        aria-controls="dashboard">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-chalkboard-teacher"></span></span><span
                                                class="nav-link-text ps-1">Dashboard</span>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#manage-account" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="manage-account">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-user-graduate"></span></span><span
                                                class="nav-link-text ps-1">Manage Accounts</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="manage-account">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-publishers') }}" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Publisher</span>
                                                </div>
                                            </a>

                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-affliatemanager') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Affiliate Managers</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-advertiser') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Advertisers</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>


                                    </ul>
                                </li>



                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#offers" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="offers">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-book"></span></span><span
                                                class="nav-link-text ps-1">Offers</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="offers">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.add-offer') }}" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Add Offers</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.view-offer') }}" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">View Offers</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>



                                 <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#offers-report" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="offers-report">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-book"></span></span><span
                                                class="nav-link-text ps-1">Offers Report</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="offers-report">
{{--                                        <li class="nav-item"><a class="nav-link"--}}
{{--                                                href="{{ route('admin.add-offer') }}" aria-expanded="false">--}}
{{--                                                <div class="d-flex align-items-center"><span--}}
{{--                                                        class="nav-link-text ps-1">Add Offers</span>--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.view-offer-report') }}" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">View Offers Report</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>




                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#Leads_process" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="Leads_process">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-mouse-pointer"></span></span><span
                                                class="nav-link-text ps-1">Clicks and Leads</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="Leads_process">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.clicks') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Clicks</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.leads') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Leads</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.reject-leads') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Rejected Leads</span>
                                                </div>
                                            </a>
                                        </li>
                                         <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.smartlink-clicks') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Smartlink Clicks </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.smartlink-leads') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Smartlink Leads </span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.rejected-smartlink-leads') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Rejected Smartlink Leads </span>
                                                </div>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('admin.manage-news') }}" role="button"
                                        aria-controls="News/Announcements">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="far fa-sticky-note"></span></span><span
                                                class="nav-link-text ps-1">News/Announcements</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('admin.messages') }}" role="button"
                                        aria-controls="Message">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fab fa-facebook-messenger"></span></span><span
                                                class="nav-link-text ps-1">Message</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#category" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="category">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fab fa-ethereum"></span></span><span
                                                class="nav-link-text ps-1">Categories</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="category">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-site-categories') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Website Category</span>
                                                </div>
                                            </a>

                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-categories') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Offer Category</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#Domain" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="Domain">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-link"></span></span><span
                                                class="nav-link-text ps-1">Domain</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="Domain">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-smartlink-domain') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Tracking Domain</span>
                                                </div>
                                            </a>

                                        </li>


                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#chashout" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="chashout">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="far fa-money-bill-alt"></span></span><span
                                                class="nav-link-text ps-1">Cashout Requests</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="chashout">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-cashout') }}" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Publisher Cashout</span>
                                                </div>
                                            </a>

                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-cashout-affliate') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Affliate Cashout</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#approval-request" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true"
                                        aria-controls="approval-request">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="far fa-clock"></span></span><span
                                                class="nav-link-text ps-1">Approval Request</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="approval-request">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.approval-request') }}" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Offer Approval Request</span>
                                                </div>
                                            </a>

                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.publisher-approval-request') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Publisher Approval Request</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-smartlink-request') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Smartlink Request</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link dropdown-indicator" href="#Postback" role="button"
                                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="Postback">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-expand-alt"></span></span><span
                                                class="nav-link-text ps-1">Postback</span>
                                        </div>
                                    </a>
                                    <ul class="nav collapse" id="Postback">
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-postback-log') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Postback Logs Sent</span>
                                                </div>
                                            </a>

                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('admin.manage-postback-log-receive') }}"
                                                aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text ps-1">Postback Logs Received</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>


                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('admin.manage-payment') }}" role="button"
                                        aria-controls="dashboard">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-plus"></span></span><span
                                                class="nav-link-text ps-1">Payment methods</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('admin.settings') }}" role="button"
                                        aria-controls="dashboard">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-cog"></span></span><span
                                                class="nav-link-text ps-1">Settings</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('admin.manage-ban-ip') }}" role="button"
                                        aria-controls="dashboard">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-ban"></span></span><span
                                                class="nav-link-text ps-1">Ban IP</span>
                                        </div>
                                    </a>
                                </li>

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
                        <a class="navbar-brand me-1 me-sm-3" href="{{ route('admin.dashboard') }}">
                            <div class="d-flex align-items-center py-3"><img class="me-2"
                                    src="{{ asset('site_images') }}/{{ $data->logo }}" alt=""
                                    width="150" /><span class="font-sans-serif"></span>
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
                                        <div class="scrollbar list py-3" style="max-height: 24rem;">
                                            <h6
                                                class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                                                Results Offers</h6>
                                            @foreach ($all_offer as $offer)
                                                <a class="dropdown-item px-card py-2"
                                                    href="{{ route('admin.offers', $offer->id) }}">
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
                                                @if(!empty($$messages))
                                                @foreach ($messages as $message)
                                                    <div class="list-group-item">
                                                        <a class="notification notification-flush notification-unread"
                                                            href="{{ route('admin.view-message', $message->id) }}">
                                                            <div class="notification-avatar">
                                                                <div class="avatar avatar-2xl me-3">
                                                                    <img class="rounded-circle"
                                                                        src="{{ $message->image }}" alt="" />

                                                                </div>
                                                            </div>
                                                            <div class="notification-body">
                                                                <p class="mb-1">
                                                                    <strong>{{ $message->sender }}</strong> Messages
                                                                    you : "{{ $message->subject }}"</p>
                                                                <span class="notification-time"><span class="me-2"
                                                                        role="img"
                                                                        aria-label="Emoji">💬</span>{{ date_format(date_create($message->created_at), ' h:i a') }}</span>

                                                            </div>
                                                        </a>

                                                    </div>
                                                @endforeach
                                                @else
                                                <div class="list-group-item">
                                                    <div class="alert alert-success">There is not any unread Notification</div>
                                                </div>
                                                @endif



                                            </div>
                                        </div>
                                        <div class="card-footer text-center border-top"><a class="card-link d-block"
                                                href="{{ route('admin.messages') }}">View all</a></div>
                                    </div>
                                </div>

                            </li>

                            <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="avatar avatar-xl">
                                        <img class="rounded-circle"
                                            src="{{ asset('site_images') }}/{{ Auth::guard('admin')->user()->photo}}"
                                            alt="" />

                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0"
                                    aria-labelledby="navbarDropdownUser">
                                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                        <a class="dropdown-item fw-bold text-warning" href="#!"><span
                                                class="fas fa-crown me-1"></span><span>{{ Auth::guard('admin')->user()->name }}</span></a>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="{{ route('admin.settings') }}">Profile &amp;
                                            Account</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.manage-news') }}">Announcements</a>
                                        <a class="dropdown-item" href="{{ route('admin.messages') }}">Messages</a>

                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('admin.settings') }}">Settings</a>

                                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                            onclick="event.preventDefault();
                                                         document.getElementById('admin-logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="admin-logout-form" action="{{ route('admin.logout') }}"
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
                            @yield('content')
                        </div>
                    </div>

                    <footer class="footer">
                        <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                            <div class="col-12 col-sm-auto text-center">
                               <p class="mb-0 text-600">Copyright @ <a href="https://kingsofaffiliate.com">KingsOfAffiliate</a><span class="d-none d-sm-inline-block">| </span><br class="d-sm-none"> All Right Reserved.
                                </p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600">v3.4.0</p>
                            </div>
                        </div>
                    </footer>
                </div>

            </div>
        </main>
        <!-- ===============================================-->
        <!--    End of Main Content-->
        <!-- ===============================================-->





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
        <script src="{{ config('app.url') }}/public/public/vendors/lodash/lodash.min.js"></script>=
        <script src="{{ config('app.url') }}/public/public/vendors/list.js/list.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/vendors/sweetalert2/sweetalert2.min.js"></script>
        <script src="{{ config('app.url') }}/public/public/assets/js/theme.js"></script>
        <script src="{{ config('app.url') }}/public/plugins/select2/js/select2.min.js"></script>
        {{-- <script src="{{ config('app.url') }}/cdn/plugins/select2/js/select2.min.js"></script> --}}
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
                            'text': text
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

            function dt_search(dt_table_object) {
                var container = dt_table_object.table().container();
                var dt_search = $(container).find('div.dataTables_filter input');
                dt_search.unbind();
                var conatiner_id = $(container).attr('id')
                var search_id = conatiner_id.replace('wrapper', 'search');
                dt_search.after('<button class="btn btn-sm btn-primary" id="' + search_id +
                    '"><i class="fe-search"></i></button>');
                $("#" + search_id).click(function() {
                    var keyword = dt_search.val();
                    dt_table_object.search(keyword).draw();
                });
                dt_search.keyup(function(e) {
                    if (e.keyCode == 13) {
                        dt_table_object.search(this.value).draw();
                    }
                });
            }
        </script>
    </body>

    </html>
@endif
