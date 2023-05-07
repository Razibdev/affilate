@extends('admin.layout.admin-dashboard')
@section('content')

    <style type="text/css">
        h4 {
            font-size: 18px !important;
        }

        #offer_name {
            font-size: 20px;
        }

        #offer_name1 {
            font-size: 16px;
            color: #384A50;
        }
    </style>
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h5 class="mb-0">OFFER ID : <span class="text-danger">{{ $qry->id }}</span></h5>
                        </div>
                        <div class="card-body">
                            <h6>Offer Details of <b style="color:#800000">{{ $qry->offer_name }}</b></h6>
                            


                                <h4><b>Preview Image</b></h4>

                                <div class="alert alert-primary" role="alert" style="height: auto;width: fit-content;">
                                    <img src="{{ asset('uploads') }}/{{ $qry->preview_url }}"
                                        style="height:256px;width:256px;object-fit: fill">
                                </div>
                                <a href="{{ url('uploads') }}/{{ $qry->preview_url }}" class="btn btn-success"
                                    target='blank'>Preview Image</a>
                                @if ($qry->preview_link != '')
                                    <a href=" {{ $qry->preview_link }}" class="btn btn-success" target='_blank'>Preview
                                        Link</a>
                                @endif
                                <div class="mt-3">
                                    <h4><b>Offer Name</b></h4>
                                    <div class="alert alert-primary " role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name">{{ $qry->offer_name }}</span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h4><b>Offer Details</b></h4>
                                    <div class="alert border" role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name1">{!! $qry->description !!}</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h4><b>Follow</b></h4>
                                    <div class="alert border" role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name1">{!! $qry->verticals !!}</span>
                                    </div>
                                </div>

								<div class="mt-3">
                                    <h4><b>Offer Category</b></h4>
                                    <div class="alert alert-success" role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name1">{{ $qry->category->category_name }}</span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h4><b>Offer Requirements</b></h4>
                                    <div class="alert border" role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name1">{!! $qry->requirements !!}</span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h4><b>Offer Payout</b></h4>
                                    <div class="alert alert-primary" role="alert" style="height: auto;width:100%;">

                                        @if ($qry->payout_type == 'revshare')
                                            <span id="offer_name">RevShare</span>
                                        @else
                                            <span id="offer_name">
                                                ${{ round(($qry->payout), 2) }}</span>
                                        @endif

                                    </div>

                                </div>
                                <div class="mt-3">
                                    <h4><b>Supported Only</b></h4>
                                    <div class="alert alert-success" role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name1">
                                            @php  $device=explode('|',$qry->ua_target); @endphp
                                            @foreach ($device as $d)
                                                @if ($d == 'Windows')
                                                    <i class="fab fa-microsoft" title="Windows"></i>
                                                @elseif($d == 'Mac')
                                                    <i class="fadeIn animated fas fa-laptop" title="Mac"></i>
                                                @elseif($d == 'Iphone')
                                                    <i class="fadeIn animated fas fa-mobile-alt" title="Iphone"></i>
                                                @elseif($d == 'Ipad')
                                                    <i class="fas fa-mobile" title="Ipad"></i>
                                                @elseif($d == 'Android')
                                                    <i class="fadeIn animated fab fa-android" title="Android"></i>
                                                @endif
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h4><b>Supported Browser</b></h4>
                                    <div class="alert alert-success" role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name1">
                                            @php  $device=explode('|',$qry->browsers); @endphp
                                            @foreach ($device as $d)
                                                @if ($d == 'Firefox')
                                                    <i class="fab fa-firefox-browser" title="Firefox"></i>
                                                @elseif($d == 'Chrome')
                                                    <i class="fadeIn animated fab fa-chrome" title="Chrome"></i>
                                                @elseif($d == 'Safari')
                                                    <i class="fadeIn animated fab fa-safari" title="Safari"></i>
                                                @elseif($d == 'EDGE')
                                                    <i class="fab fa-edge" title="EDGE"></i>
                                                @elseif($d == 'Internet Explorer')
                                                    <i class="fadeIn animated fab fa-internet-explorer"
                                                        title="Internet Explorer"></i>
                                                @elseif($d == 'OPERA MINI')
                                                    <i class="fadeIn animated fab fa-opera" title="OPERA MINI"></i>
                                                @endif
                                            @endforeach
                                        </span>
                                    </div>
                                </div>


                               
                                <div class="mt-3">
                                    <h4><b>Offer Country</b></h4>
                                    <div class="alert alert-success" role="alert" style="height: auto;width:100%;">
                                        <span id="offer_name1">{{ $qry->countries }}</span>
                                    </div>
                                </div>
                           



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    
@endsection
