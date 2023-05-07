 @extends('publisher.layout.dashboard')
 @section('content')
     <?php

     ?>
     <style>
     </style>
     <div class="page-content-wrapper">
         <div class="page-content">

             <div class="card radius-10 mb-3">

                 <div class="card-body">
                     <form action="{{ url('publisher/show-daily-report') }}" method="get">
                         <div class="row">
                             <div class="col-lg-3">

                                 <div class="form-group">
                                     <label>From Date</label>
                                     <input type="date" name="from_date" value="{{ substr($from_date, 0, 10) }}"
                                         class="form-control">
                                 </div>
                             </div>
                             <div class="col-lg-3">
                                 <div class="form-group">
                                     <label>To Date</label>
                                     <input class="form-control" value="{{ substr($to_date, 0, 10) }}" name="to_date"
                                         type="date">
                                 </div>
                             </div>

                             <div class="col-lg-2">
                                 <button class="btn btn-primary" type="submit" style="margin-top: 28px">Filter</button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>

             <!--end row-->
             <div class="row">
                 <div class="col-12 col-lg-12">
                     <div class="card radius-10">
                         <div class="card-header">
                             Report By Offers
                         </div>
                         <div class="card-body ">
                             <div class="table-responsive">
                                 <table class="table table-bordered table-sm table-striped w-100" id="example2">
                                     <thead>



                                         <th>Date</th>
                                         <th>Offer</th>
                                         <th>Countries</th>
                                         <th>Browsers</th>
                                         <th>IP Address</th>
                                         <th>Device</th>

                                         <th>Smartlink(ID)</th>
                                         <th>Source</th>
                                         <th>SID</th>
                                         <th>SID2</th>
                                         <th>SID3</th>
                                         <th>SID4</th>
                                         <th>SID5</th>



                                         <th>Clicks</th>
                                         <th>Leads</th>
                                         <th>Earnings</th>
                                         <th>CR</th>
                                         <th>CVR</th>
                                         <th>ECPM</th>

                                     </thead>
                                     <tbody>
                                         <?php
                                         $click = 0;
                                         $leads = 0;
                                         $earnings = 0;
                                         ?>

                                         @foreach ($qry as $q)
                                             <?php $click += $q->clicks;
                                             $leads += $q->leads;
                                             $earnings += $q->earnings; ?>
                                             <tr>

                                                 <td>{{ $q->created_at }}</td>
                                                 <td>{{ $q->offer_name }}({{ $q->offer_id }})</td>
                                                 <td>{{ $q->countries }}</td>
                                                 <td>
                                                     @if ($q->browser == 'OPERA MINI')
                                                         <i class="fab fa-opera text-danger" title="Opera"></i>
                                                     @elseif($q->browser == 'Chrome')
                                                         <i class="fadeIn animated fab fa-chrome " title="Chrome"></i>
                                                     @elseif($q->browser == 'Firefox')
                                                         <i class="fadeIn animated fab fa-firefox" title="Firefox"></i>
                                                     @elseif($q->browser == 'Internet Explorer')
                                                         <i class="fab fa-internet-explorer" title="Internet Explorer"></i>
                                                     @elseif($q->browser == 'Safari')
                                                         <i class="fadeIn animated fab fa-safari" title="Safari"></i>
                                                     @elseif($q->browser == 'EDGE')
                                                         <i class="fadeIn animated fab fa-edge" title="Edge"></i>
                                                     @endif
                                                 </td>
                                                 <td>{{ $q->ip_address }}</td>
                                                 @if($q->key_==null)
                                                 <td>

                                                     @if ($q->ua_target == 'Windows')
                                                         <i class="fab fa-windows" title="Windows"></i>
                                                     @elseif($q->ua_target == 'Mac')
                                                         <i class="fadeIn animated fas fa-laptop" title="Mac"></i>
                                                     @elseif($q->ua_target == 'Iphone')
                                                         <i class="fadeIn animated fas fa-mobile" title="Iphone"></i>
                                                     @elseif($q->ua_target == 'Ipad')
                                                         <i class="fas fa-mobile-alt" title="Ipad"></i>
                                                     @elseif($q->ua_target == 'Android')
                                                         <i class="fadeIn animated fab fa-android" title="Android"></i>
                                                     @endif
                                                 </td>
                                                 <td style="background:#F2F2F2;"></td>
                                                 <td>
                                                    @if($q->source==null)
                                                     Direct Visitor
                                                    @else
                                                        {{ $q->source }}
                                                    @endif
                                                 </td>

                                                 <td>{{ $q->sid }}</td>
                                                 <td>{{ $q->sid2 }}</td>
                                                 <td>{{ $q->sid3 }}</td>
                                                 <td>{{ $q->sid4 }}</td>
                                                 <td>{{ $q->sid5 }}</td>
                                                @else
                                                 <td>

                                                     @if ($q->ua_target == 'Windows')
                                                         <i class="fab fa-windows" title="Windows"></i>
                                                     @elseif($q->ua_target == 'Mac')
                                                         <i class="fadeIn animated fas fa-laptop" title="Mac"></i>
                                                     @elseif($q->ua_target == 'Iphone')
                                                         <i class="fadeIn animated fas fa-mobile" title="Iphone"></i>
                                                     @elseif($q->ua_target == 'Ipad')
                                                         <i class="fa-mobile-alt" title="Ipad"></i>
                                                     @elseif($q->ua_target == 'Android')
                                                         <i class="fadeIn animated fab fa-android" title="Android"></i>
                                                     @endif
                                                 </td>

                                                 <td>{{(!empty($q->smartlink))?$q->smartlink:'--'}}
                                               </td>

                                                 <td style="background:#F2F2F2;"></td>
                                                 <td style="background:#F2F2F2;"></td>
                                                 <td style="background:#F2F2F2;"></td>
                                                 <td style="background:#F2F2F2;"></td>
                                                 <td style="background:#F2F2F2;"></td>
                                                 <td style="background:#F2F2F2;"></td>

                                                 @endif


                                                 <td><b>{{ $q->clicks }}</b></td>
                                                 <td><b>{{ $q->leads }}</b></td>
                                                 <td><b>€ {{ round($q->earnings, 2) }}</b></td>

                                                 <td> <b>{{ $q->leads == 0 ? 0 : $q->clicks / $q->leads }}%</b></td>
                                                 <td> <b>{{ $q->leads == 0 ? 0 : round(($q->leads / $q->clicks)*100, 2) }}%</b></td>
                                                 <td> <b>{{ $q->leads == 0 ? 0 : round(($q->earnings / $q->leads) * 1000, 2) }}</b>
                                                 </td>
                                             </tr>
                                         @endforeach
                                     </tbody>
                                     <tfoot>
                                         <tr>
                                             <td></td>

                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>

                                             <td> </td>
                                             <td> </td>
                                             <td> </td>
                                             <td> </td>
                                             <td></td>
                                             <td><b> Total = </b></td>

                                             <td><b>{{ $click }}</b></td>
                                             <td><b>{{ $leads }}</b></td>
                                             <td><b>€ {{ round($earnings, 2) }}</b></td>
                                             <td><b>{{$click * 100}}%</b></td>
                                             <td> <b>{{ $leads == 0 ? 0 : round(($leads / $click)*100,2) }}%</b></td>
                                             <td> <b>€ {{ $leads == 0 ? 0 : round(($earnings / $leads) * 1000, 2) }}</b> </td>

                                         </tr>
                                     </tfoot>
                                 </table>

                             </div>
                             {!! $qry->links() !!}
                         </div>
                     </div>
                 </div>
             </div>
             <!--		<div class="row">-->
             <!--			<div class="col-12 col-lg-12">-->
             <!--				<div class="card radius-10">-->
             <!--						<div class="card-header">-->
             <!--	 				Report By Date-->
             <!--	 			</div>-->
             <!--					<div class="card-body ">-->
             <!--						<div class="table-responsive">-->
             <!--					<table class="table" id="example">-->
             <!--						<thead>-->


             <!--							<th>Date</th>-->
             <!--								<th>Offer</th>-->
             <!--									<th>Countries</th>-->
             <!--									<th>Browsers</th>-->
             <!--									<th>Ip Address</th>-->

             <!--							<th>Clicks</th>-->
             <!--							<th>Leads</th>-->
             <!--							<th>Earnings</th>-->


             <!--						</thead>-->
             <!--						<tbody>-->
             <!--							@foreach ($qry1 as $q)
    -->
             <!--							<tr>-->

             <!--								<td>{{ $q->created_at }}</td>-->
             <!--								<td>{{ $q->offer_id }}</td>-->
             <!--								<td>{{ $q->countries }}</td>-->
             <!--									<td>{{ $q->browser }}</td>-->
             <!--										<td>{{ $q->ip_address }}</td>-->
             <!--								<td>{{ $q->clicks }}</td>-->
             <!--								<td>{{ $q->leads }}</td>-->
             <!--								<td>${{ round($q->earnings, 2) }}</td>-->
             <!--							</tr>-->
             <!--
    @endforeach-->
             <!--						</tbody>-->
             <!--					</table>-->
             <!--				</div>-->
             <!--			</div>-->
             <!--		</div>-->
             <!--	</div>-->
             <!--</div>-->

         </div>
     </div>
     </div>
 @endsection('content')
