@extends('publisher.layout.dashboard')
@section('content')
    <div class="row g-3 mb-3">

        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                    style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-1.png);">
                </div>
                <!--/.bg-holder-->



                <div class="card-body position-relative" style="padding: 0">
                    <div style="padding: 5px; background: #ded1d1;">
                        <h5 style="text-align: center;">Clicks</h5>
                    </div>
                    <h6 style="padding: 5px">Current Month</h6>
                    <div class="display-4 fs-4 fw-normal font-sans-serif text-warning"
                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}' style="padding-left: 5px;">{{ $data['click_count_c_month'] }}</div>
                    <hr>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Today</h6>
                        <h6>{{$data['click_count']}}</h6>
                    </div>
                     <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Yesterday</h6>
                        <h6>{{ $data['click_count_yesterday']}}</h6>
                    </div>
                     <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Last Month</h6>
                        <h6>{{ $data['click_count_l_month']}}</h6>
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

{{--                <div class="card-body position-relative">--}}
{{--                    <h5>Today leads</h5>--}}
{{--                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"--}}
{{--                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ ($data['lead_count']) }}</div>--}}

{{--                </div>--}}


                <div class="card-body position-relative" style="padding: 0">
                    <div style="padding: 5px; background: #ded1d1;">
                        <h5 style="text-align: center;">Leads</h5>
                    </div>
                    <h6 style="padding: 5px">Current Month</h6>
                    <div class="display-4 fs-4 fw-normal font-sans-serif text-warning"
                         data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}' style="padding-left: 5px;">{{ $data['lead_count_c_month'] }}</div>
                    <hr>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Today</h6>
                        <h6>{{$data['lead_count']}}</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Yesterday</h6>
                        <h6>{{ $data['lead_count_yesterday']}}</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Last Month</h6>
                        <h6>{{ $data['lead_count_l_month']}}</h6>
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

{{--                <div class="card-body position-relative">--}}
{{--                    <h6>Today Earnings</h6>--}}
{{--                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"--}}
{{--                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ number_format($data['today_earning'],2) }} €</div>--}}

{{--                </div>--}}

                <div class="card-body position-relative" style="padding: 0">
                    <div style="padding: 5px; background: #ded1d1;">
                        <h5 style="text-align: center;">Earnings</h5>
                    </div>
                    <h6 style="padding: 5px">Current Month</h6>
                    <div class="display-4 fs-4 fw-normal font-sans-serif text-warning"
                         data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}' style="padding-left: 5px;">{{ number_format($data['today_earning_c_month'], 2) }} €</div>
                    <hr>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Today</h6>
                        <h6>{{number_format($data['today_earning'],2) }} €</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Yesterday</h6>
                        <h6>{{ number_format($data['today_earning_yesterday'],2)}} €</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Last Month</h6>
                        <h6>{{ number_format($data['today_earning_l_month'],2)}} €</h6>
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

{{--                <div class="card-body position-relative">--}}
{{--                    <h5>Unique Clicks</h5>--}}
{{--                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"--}}
{{--                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ !empty($data['unique_click']) ? $data['unique_click'] : '0' }}--}}
{{--                    </div>--}}
{{--                </div>--}}


                <div class="card-body position-relative" style="padding: 0">
                    <div style="padding: 5px; background: #ded1d1;">
                        <h5 style="text-align: center;">Unique Click</h5>
                    </div>
                    <h6 style="padding: 5px">Current Month</h6>
                    <div class="display-4 fs-4 fw-normal font-sans-serif text-warning"
                         data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}' style="padding-left: 5px;">{{  $data['unique_click_c_month'] }}</div>
                    <hr>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Today</h6>
                        <h6>{{  $data['unique_click']}}</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Yesterday</h6>
                        <h6>{{ $data['unique_click_yesterday']}}</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Last Month</h6>
                        <h6>{{   $data['unique_click_l_month']}}</h6>
                    </div>

                </div>



            </div>
        </div>

         <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url({{ config('app.url') }}/public/public/assets/img/icons/spot-illustrations/corner-3.png);">
                </div>
                <!--/.bg-holder-->

{{--                <div class="card-body position-relative">--}}
{{--                    <h5>Today ECPM</h5>--}}
{{--                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"--}}
{{--                        data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>{{ number_format($data['td_epc'],2) }} €--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="card-body position-relative" style="padding: 0">
                    <div style="padding: 5px; background: #ded1d1;">
                        <h5 style="text-align: center;">ECPM</h5>
                    </div>
                    <h6 style="padding: 5px">Current Month</h6>
                    <div class="display-4 fs-4 fw-normal font-sans-serif text-warning"
                         data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}' style="padding-left: 5px;">{{ number_format($data['td_epc_c_month'],2) }} €</div>
                    <hr>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Today</h6>
                        <h6>{{ number_format($data['td_epc'],2) }} €</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Yesterday</h6>
                        <h6>{{ number_format($data['td_epc_yesterday'],2) }} €</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Last Month</h6>
                        <h6>{{ number_format($data['td_epc_l_month'],2) }} €</h6>
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

{{--                <div class="card-body position-relative">--}}
{{--                    <h5>VPN Click</h5>--}}
{{--                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"--}}
{{--                         data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}'>--}}
{{--                        {{ !empty($publisher_table['vpn_clicks']) ? $publisher_table['vpn_clicks'] : '0' }}</div>--}}

{{--                </div>--}}


                <div class="card-body position-relative" style="padding: 0">
                    <div style="padding: 5px; background: #ded1d1;">
                        <h5 style="text-align: center;">CVR</h5>
                    </div>
                    <h6 style="padding: 5px">Current Month</h6>
                    <div class="display-4 fs-4 fw-normal font-sans-serif text-warning"
                         data-countup='{"endValue":58.386,"decimalPlaces":2,"suffix":"k"}' style="padding-left: 5px;">{{ number_format($data['cvr_count_c_month'],2) }} %</div>
                    <hr>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Today</h6>
                        <h6>{{ number_format($data['cvr_count'],2) }} %</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Yesterday</h6>
                        <h6>{{ number_format($data['cvr_count_yesterday'],2) }} %</h6>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 5px; font-size: 18px;">
                        <h6>Last Month</h6>
                        <h6>{{ number_format($data['cvr_count_l_month'],2) }} %</h6>
                    </div>

                </div>


            </div>
        </div>


    </div>
    <div class="card radius-10">
        <div class="card-header border-bottom-0">
            <div class="d-lg-flex align-items-center">
                <div>
                    <h5 class="font-weight-bold mb-2 mb-lg-0">Clicks | Conversions | Earnings</h5>
                </div>
                <div class="ml-lg-auto mb-2 mb-lg-0">
                    <div class="btn-group-round">

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="differencechart"></div>

        </div>
    </div>
    <div class="card radius-10 mt-4">
        <div class="card-header border-bottom-0">
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="font-weight-bold mb-0">Recent Conversions</h5>
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
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript" >



$(function () {
url='{{config('app.url')}}'+'/assets/ringtone/welcome.ogg';
  playSound(url);
    function playSound(url) {
  const audio = new Audio(url);
  audio.play();
}

    // setInterval(GetLiveClicks,3000);
let clicks=[];
let leads=[];
let date=[];
let earnings=[];
var qry=JSON.parse('<?php echo $diff_qry ?>');



for(var i=0;i<qry.length;i++){
  if(qry[i].clicks==null){
      clicks.push(0);
  }else{
        clicks.push(qry[i].clicks);
  }

   if(qry[i].leads==null){
        leads.push(0);
   }
   else{
        leads.push(qry[i].leads);
   }
        date.push(qry[i].createdat);
        if(qry[i].earnings==null){
        earnings.push(0);
        }
        else{
        earnings.push(parseFloat(qry[i].earnings).toFixed(2));
}
}

    "use strict";
        var optionsLine = {
        chart: {
            height: 300,
            type: 'line',
            zoom: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                top: 8,
                left: 2,
                blur: 3,
                opacity: 0.1,
            }
        },
           animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ["#ff007b", '#265ED7','#00ff66'],
        series: [{
            name: "Clicks",
            data:clicks,

        }, {
            name: "Conversions",
            data: leads
        }
        , {
            name: "Earnings",
            data: earnings
        }],
        title: {
            text: 'This Month',
            align: 'left',
            offsetY: 25,
            offsetX: 20
        },
        subtitle: {
            text: 'Statistics',
            offsetY: 55,
            offsetX: 20
        },
        markers: {
            size: 4,
            strokeWidth: 0,
            hover: {
                size: 7
            }
        },
        grid: {
            show: true,
            padding: {
                bottom: 0
            }
        },

        labels:date,
        xaxis: {
            tooltip: {
                enabled: false
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            offsetY: -20
        }
    }
    var chartLine = new ApexCharts(document.querySelector('#differencechart'), optionsLine);
    chartLine.render();

    // GetLiveClicks();
    var lead=0;
     function GetLiveClicks(){
    $.ajax({
        method:'get',
        url:"{{url('publisher/clicks-graph')}}",
        'dataType':'json',
        success:function(res){
        if(res[0].today_leads>lead){
            url='{{config('app.url')}}'+'/assets/ringtone/lead.ogg';
            playSound(url);

         }
        lead=res[0].today_leads;

        var earnings=(res[0]!=undefined && res[0].total_earnings!=null?(parseFloat(res[0].total_earnings)).toFixed(2):'0.00');

        $('.uniqueClicks').html(res[0]!=undefined?res[0].unique_clicks:0);
        $('.today_leads').html(res[0]!=undefined?res[0].today_leads:0);
        $('.today_earnings').html('$'+earnings);
        $('.today_ecpm').html(res[0].today_leads!=undefined  && res[0].today_leads!=0?'$'+parseFloat(((res[0].total_earnings/res[0].today_leads)*1000)).toFixed(3):'$0.00')
    }

})
}


});
</script>
@endsection
