@extends('affiliate.layout.affiliate-dashboard')
@section('content')
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-2.png);">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative">
                    <h6>My Publishers</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $my_publisher }}</div>
                   
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
                    <h6>Total Pending Publishers</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $pending_publisher }}</div>
                    
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
                    <h6>My Rejected Publishers</h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ $rejected_publisher }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="row">
                <div class="col-md-4 col-xl-4 col-md-6 col-xs-12">
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
                                            <img src="{{ asset('uploads') }}/{{ $t->icon_url }}" height="55" width="55"
                                                alt="" class="rounded-circle" />
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
                <div class="col-md-4 col-xl-4 col-md-6 col-xs-12">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="font-weight-bold mb-0">My Top Members</h5>
                                </div>

                            </div>
                            <div class="product-list mt-3">
                                <?php $count = 0; ?>
                                @foreach ($my_10_members as $t)
                                    <?php $count++; ?>
                                    @if ($count < 10)
                                        <div class="media  d-flex">
                                            <div class="mt-2">
                                                <img src="{{ $t->photourl }}" width="55" height="55"
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
                <div class="col-md-4 col-xl-4 col-md-6 col-xs-12">
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
                                                <img src="{{ $t->photourl }}" width="55" height="55"
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

            </div>
            <div class="card radius-10 mt-4">
                <div class="card-header border-bottom-0">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="font-weight-bold mb-0">Recent Leads</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Photo</th>
                                    <th>#(ID)/Offer Name</th>
                                    <th>Payout</th>
                                    <th>Country</th>
                                    <th>Device</th>
                                    <th>Browser</th>
                                    <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_conversion as $r)
                                    <tr>
                                        <td>{{ $r->created_at }}</td>
                                        <td>
                                            <div class="product-img bg-transparent border">
                                                <img src="{{ $r->photourl }}" width="35" alt="">
                                            </div>
                                        </td>
                                        <td>#({{ $r->id }}) - {{ $r->offer_name }}</td>
                                        <td>${{ round($r->publisher_earned, 2) }}</td>
                                        <td>{{ $r->country }}</td>
                                        <td>
                                            @if ($r->ua_target == 'Windows')
                                                <i class="fab fa-windows" title="Windows"></i>
                                            @elseif($r->ua_target == 'Mac')
                                                <i class="fas fa-laptop-code" title="Mac"></i>
                                            @elseif($r->ua_target == 'Iphone')
                                                <i class="fas fa-mobile-alt" title="Iphone"></i>
                                            @elseif($r->ua_target == 'Ipad')
                                                <i class="lni lni-tab" title="Ipad"></i>
                                            @elseif($r->ua_target == 'Android')
                                                <i class="fadeIn animated bx bx-mobile" title="Android"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($r == 'OPERA MINI')
                                                <i class="fadeIn animated fab fa-opera" title="Opera"></i>
                                            @elseif($r->browser == 'Chrome')
                                                <i class="fadeIn animated fab fa-chrome" title="Chrome"></i>
                                            @elseif($r->browser == 'Firefox')
                                                <i class="fadeIn animated fab fa-firefox" title="Firefox"></i>
                                            @elseif($r->browser == 'Internet Explorer')
                                                <i class="lni lni-dribbble" title="Internet Explorer"></i>
                                            @elseif($r->browser == 'Safari')
                                                <i class="fadeIn animated fab fa-safari" title="Safari"></i>
                                            @elseif($r->browser == 'EDGE')
                                                <i class="fadeIn animated fab fa-edge" title="Edge"></i>
                                            @endif
                                        </td>
                                        <td>{{ $r->ip_address }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {!! $recent_conversion->render() !!}
                        </div>
                    </div>
                </div>
            </div>
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
                                @foreach ($top_countrie as $key=> $r)
                                    <tr class="text-center">
                                        <td>{{ $key+1 }}</td>
                                        
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
        <!--end page-wrapper-->
        <!--start overlay-->
        <div class="overlay toggle-btn-mobile"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <!--footer -->

    </div>
@endsection
@section('js')
<script type="text/javascript">
        @if (Session::has('success'))
            Swal.fire({
                title: '{{ Session::get('success') }}',


                confirmButtonText: 'Ok'
            })
        @endif
    </script>
@endsection
