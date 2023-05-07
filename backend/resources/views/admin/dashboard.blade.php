@extends('admin.layout.admin-dashboard')

@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ config('app.url') }}/public/public/vendors/datatables/dataTables.bootstrap4.css" rel="stylesheet"

        type="text/css" />

    <link href="{{ config('app.url') }}/public/public/vendors/datatables/datatables.mark.css" rel="stylesheet"

        type="text/css" />

    <link href="{{ config('app.url') }}/public/public/vendors/datatables/buttons.bootstrap4.css" rel="stylesheet"

        type="text/css" />

    <link href="{{ config('app.url') }}/public/public/vendors/datatables/responsive.bootstrap4.css" rel="stylesheet"

        type="text/css" />

    <link href="{{ config('app.url') }}/public/public/vendors/datatables/select.bootstrap4.css" rel="stylesheet"

        type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />







    <!--page-content-wrapper-->

    <div class="page-content-wrapper">

        <div class="page-content">

            <form action="" method="get">

                <div class="row mb-3">



                    <div class="col-lg-3">

                        <label> From Date</label>

                        <input type="date" name="from_date" value="{{ $from_date }}" class="form-control">

                    </div>

                    <div class="col-lg-3">

                        <label> To Date</label>

                        <input type="date" name="to_date" value="{{ $to_date }}" class="form-control">

                    </div>

                    <div class="col-lg-3">

                        <button type="submit" class="btn btn-primary " style="margin-top: 29px">Search</button>

                    </div>

                </div>



            </form>

            <div class="row g-3 mb-3">

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-1.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Publishers </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $total_pub }}</div>

                             

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-1.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Advetrisers </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $total_advirter }}

                            </div>

                             

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-2.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Affliate Managers</h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $total_aff }}</div>

                            

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-3.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Offers </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $total_offers }}

                            </div>

                        </div>

                    </div>

                </div>



                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-5.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Smart Links </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ $total_smartlinks }}</div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-3.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Clicks </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $total_clicks }}

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-2.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Leads </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $total_leads }}

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-1.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Unique Clicks 

                            </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ $total_unique_clicks }}</div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-2.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>VPN Clicks </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ $total_vpn_clicks }}

                            </div>

                        </div>

                    </div>

                </div>



                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-3.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Publisher Earnings </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ round($total_publisher_earnings, 2) }}</div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-1.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Admin Earnings 

                            </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ round($total_admin_earnings, 2) }}</div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-5.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Affliate Balance </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ round($total_affliate_earning, 2) }}

                            </div>

                        </div>

                    </div>

                </div>

                





                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-2.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Pending Smartlink </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ $total_pending_smartlink }}

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-3.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Pending Offer Request </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ $total_pending_offer_request }}</div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-5.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Messages </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ $total_messages }}</div>

                        </div>

                    </div>

                </div>

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-2.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Pending Withdraw </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ round($total_pending_withdraw, 3) }}

                            </div>

                        </div>

                    </div>

                </div>

               

                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-5.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Tracking Domains </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ $total_smartlink_domains }}</div>

                        </div>

                    </div>

                </div>





                <div class="col-sm-6 col-md-4">

                    <div class="card overflow-hidden" style="min-width: 12rem">

                        <div class="bg-holder bg-card"

                            style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-2.png);">

                        </div>

                        <!--/.bg-holder-->



                        <div class="card-body position-relative">

                            <h6>Paid Money 

                            </h6>

                            <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"

                                data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>

                                {{ round($total_paid_amount, 2) }}

                            </div>

                        </div>

                    </div>

                </div>



            </div>

            <div class="page-content-wrapper">

                <div class="page-content">



                    <div class="row">

                        <div class="col-md-4 col-xl-4 col-md-6 col-xs-12 my-2">

                            <div class="card radius-10">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div>

                                            <h5 class="font-weight-bold mb-0">Global Top Members</h5>

                                        </div>



                                    </div>

                                    <div class="product-list mt-3">

                                        <?php $count = 0; ?>

                                        @foreach ($top_10_members as $t)

                                            <?php $count++; ?>

                                            @if ($count < 10)

                                                <div class="media  d-flex">

                                                    <div class="mt-2">

                                                        <img src="{{ $t->photourl }}" width="40" height="40"

                                                            class="rounded-circle" alt="" />

                                                    </div>

                                                    <div class="media-body pl-2 m-2 w-100">

                                                        <h6 class="mb-1 font-weight-bold">{{ $t->name }} <span

                                                                class="text-primary float-right font-13 float-end">Rank :

                                                                {{ $count }}</span></h6>

                                                        <p class="mb-0 font-13 text-secondary ">Earnings :

                                                            ${{ round($t->earnings, 3) }}

                                                        </p>

                                                    </div>

                                                </div>

                                                <hr />

                                            @endif

                                        @endforeach





                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4 col-xl-4 col-md-6 col-xs-12 my-2">

                            <div class="card radius-10">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div>

                                            <h5 class="font-weight-bold mb-0">Global Top Affliates</h5>

                                        </div>



                                    </div>

                                    <div class="product-list mt-3">

                                        <?php $count = 0; ?>

                                        @foreach ($top_10_affliate as $t)

                                            <?php $count++; ?>

                                            @if ($count < 10)

                                                <div class="media  d-flex">

                                                    <div class="mt-2">

                                                        <img src="{{ $t->photourl }}" width="40" height="40"

                                                            class="rounded-circle" alt="" />

                                                    </div>

                                                    <div class="media-body pl-2 m-2 w-100">

                                                        <h6 class="mb-1 font-weight-bold">{{ $t->name }} <span

                                                                class="text-primary float-right font-13 float-end">Rank :

                                                                {{ $count }}</span></h6>

                                                        <p class="mb-0 font-13 text-secondary ">Earnings :

                                                            ${{ round($t->total_earnings, 3) }}

                                                        </p>

                                                    </div>

                                                </div>

                                                <hr />

                                            @endif

                                        @endforeach





                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-4 col-xl-4 col-md-6 col-xs-12 my-2">

                            <div class="card radius-10">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div>

                                            <h5 class="font-weight-bold mb-0">Global Top Advertisers</h5>

                                        </div>



                                    </div>

                                    <div class="product-list mt-3">

                                        <?php $count = 0; ?>

                                        @foreach ($top_10_advertiser as $t)

                                            <?php $count++; ?>

                                            @if ($count < 10)

                                                <div class="media  d-flex">

                                                    <div class="mt-2">

                                                        <img src="{{ $t->photourl }}" width="40" height="40"

                                                            class="rounded-circle" alt="" />

                                                    </div>

                                                    <div class="media-body pl-2 m-2 w-100">

                                                        <h6 class="mb-1 font-weight-bold">{{ $t->advertiser_name }}

                                                            <span class="text-primary float-right font-13 float-end">Rank :

                                                                {{ $count }}</span>

                                                        </h6>

                                                        <p class="mb-0 font-13 text-secondary ">Total Leads :

                                                            {{ $t->total_leads }}

                                                        </p>

                                                    </div>

                                                </div>

                                                <hr />

                                            @endif

                                        @endforeach





                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- top offer start -->
                        <div class="col-md-4 col-xl-4 col-md-6 col-xs-12 my-2">

                            <div class="card radius-10">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div>

                                            <h5 class="font-weight-bold mb-0">Top Offers</h5>

                                        </div>



                                    </div>

                                    <div class="product-list mt-3">

                                        <?php $count = 0; ?>

                                        @foreach ($top_10_offers as $t)

                                            <?php $count++; ?>

                                            <div class="media align-items-center-2 d-flex ">

                                                <div class="m-2">

                                                    <img src="{{ asset('uploads') }}/{{ $t->icon_url }}"

                                                        width="40" alt="" class="rounded-circle" />

                                                </div>

                                                <div class="media-body pl-3 m-2 w-100">

                                                    <h6 class="mb-0 font-weight-bold">{{ $t->offer_name }}

                                                        ({{ $count }})

                                                    </h6>

                                                    <p class="mb-0 text-secondary">Leads : {{ $t->leads }}</p>



                                                </div>

                                                <p class="mb-0 text-purple float-end">

                                                    ${{ round(($t->payout * $site->affliate_manager_salary_percentage) / 100, 3) }}

                                                </p>



                                            </div>

                                            <hr />

                                        @endforeach



                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Top offers end -->


                        <!-- Top Browsers Start -->

                        <div class="col-md-4 col-xl-4 col-md-6 col-xs-12 my-2">

                            <div class="card radius-10">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">

                                        <div>

                                            <h5 class="font-weight-bold mb-0">Top Browsers</h5>

                                        </div>



                                    </div>

                                    <div class="product-list mt-3">

                                        <?php $count = 0; ?>

                                        @foreach ($top_browsers as $browser)
                                            
                                            <div class="media align-items-center-2 d-flex ">
                                                <div class="media-body pl-3 m-2 w-100">
                                                    <h6 class="mb-0 font-weight-bold">{{ $browser->browser}} ({{ $browser->count }})</h6>
                                                    
                                                </div>
                                                
                                            </div>
                                            <hr />

                                        @endforeach



                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Top Browsers End -->


                        <!-- Top Devices Start -->

                        <div class="col-md-4 col-xl-4 col-md-6 col-xs-12 my-2">

                            <div class="card radius-10">

                                <div class="card-body">

                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h5 class="font-weight-bold mb-0">Top Devices</h5>
                                        </div>

                                    </div>

                                    <div class="product-list mt-3">

                                        <?php $count = 0; ?>

                                        @foreach ($top_devices as $device)
                                            
                                            <div class="media align-items-center-2 d-flex ">
                                                <div class="media-body pl-3 m-2 w-100">
                                                    <h6 class="mb-0 font-weight-bold">{{ $device->ua_target}} ({{ $device->count }})</h6>
                                                    
                                                </div>
                                                
                                            </div>
                                            <hr />

                                        @endforeach



                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Top Devices End -->

                    </div>

                </div>

            </div>



            <div class="row">

                <div class="card radius-10 mt-4">

                    <div class="card-header border-bottom-0">

                        <div class="d-flex align-items-center">

                            <div>

                                <h5 class="font-weight-bold mb-0">Top Country</h5>

                            </div>



                        </div>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped mb-0">

                                <thead>

                                    <tr>

                                        <th>Rank</th>

                                        <th>Country Name</th>

                                        <th>Total Click</th>

                                        <th>Total Leads</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($top_countrie as $key => $r)

                                        <tr class="text-center">

                                            <td>{{ $key + 1 }}</td>



                                            <td> {{ $r->nicename }}</td>

                                            <td>{{ $r->click }}</td>

                                            <td>{{ $r->leads }}</td>

                                        </tr>

                                    @endforeach



                                </tbody>

                            </table>

                            <div class="d-flex justify-content-center">



                            </div>

                        </div>

                    </div>

                </div>



            </div>





        </div>

    </div>





    <div class="overlay toggle-btn-mobile"></div>

    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>





@endsection

@section('js')

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="

        crossorigin="anonymous"></script>

    <script type="text/javascript" src="{{ config('app.url') }}/public/public/vendors/datatables/jquery.mark.min.js">

    </script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/jquery.dataTables.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/dataTables.buttons.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/buttons.bootstrap4.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/dataTables.keyTable.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/dataTables.select.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/buttons.html5.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/buttons.print.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/dataTables.responsive.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/responsive.bootstrap4.min.js"></script>

    <script src="{{ config('app.url') }}/public/public/vendors/datatables/datatables.mark.js"></script>



    <script type="text/javascript">

        $(function() {





            @if (Session::has('success'))

                Swal.fire({

                    title: '{{ Session::get('success') }}',





                    confirmButtonText: 'Ok'

                })

            @endif











        });

    </script>

@endsection

