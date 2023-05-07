@extends('publisher.layout.dashboard')
 @section('content')

     <style>
     </style>
     <div class="page-content-wrapper">
         <div class="page-content">

             <div class="card radius-10 mb-3">

                 <div class="card-body">
                     <form action="{{ url('publisher/report-by-date') }}" method="get">
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
                                    <button class="btn btn-primary" type="submit" style="margin-top: 28px">Search</button>
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
                             Report By Date
                         </div>
                         <div class="card-body ">
                             <div class="table-responsive">
                             <table class="table table-bordered table-sm table-striped w-100" id="example2">
                             <thead>


                                    <th>Date</th>
                                    <th>Total Clicks</th>
                                    <th>Total leads</th>
                                    <th>Total Earnings</th>
                                    <th>EPC</th>
                                    <th>CR</th>
                                    <th>CVR</th>


                                    </thead>
                                    <tbody>

                                    @if($qry)
                                    @foreach ($qry as $q)
                                        <?php
                                         ?>
                                        <tr>
                                            <td>{{ $q->group_date }}</td>
                                            <td>{{$q->clicks}}</td>
                                            <td>{{$q->leads}}</td>
                                            <td>€ {{round($q->earnings,2)}}</td>
                                            <td>€ {{round($q->earnings/($q->clicks?$q->clicks:1),2)}}</td>
                                            <td>{{ round(($q->clicks/($q->leads?$q->leads:1))*100,2) }}%</td>
                                            <td>{{ round($q->leads == 0 ? 0 : ($q->leads / $q->clicks)*100, 2) }}%</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                    </table>

                             </div>
                         </div>
                     </div>
                 </div>
             </div>


         </div>
     </div>
     </div>
 @endsection('content')
