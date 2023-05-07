@extends('publisher.layout.dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">

                    <div class="card"
                        style="box-shadow: 0 4px 8px 0 rgb(146 140 175);transition: 0.3s;border: 1px solid #ffefef;">
                        <div class="card-body">

                                <br><br>
                                <div class="col-md-4 offset-md-4">
                                    <div style="border: 1px solid #000;border-radius:12px;" class="card m-4 text-center">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">


                                                    <p class="text-truncate font-size-14 mb-2 text-center">Your Balance Remaining</p>
                                                    <h4 class="mb-0">${{ round($qry ? $qry : 0, 2) }}</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-money-euro-circle-fill font-size-40"></i>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                        aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ round($qry ? $qry : 0, 2) }}%"></div>
                                </div>

                                <br>
                                <p class="card-title-desc text-center">From our Payments Department you can see all your payment histroy
                                </p>



                                <div class="table-responsive ">
                                    <table class="table table-bordered table-striped w-100" id="example">
                                        <thead>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Payment Detail</th>

                                            <th>Payment Cycle</th>
                                            <th style="width:130px;">Status</th>
                                            <th>Invoice</th>



                                        </thead>

                                        <tbody>
                                            @foreach ($phistoy as $q)
                                                <tr>
                                                    <td>{{ $q->created_at }}</td>
                                                    <td>{{ round($q->amount, 2) }}</td>
                                                    <td>{{ $q->method }}</td>
                                                    <td>{{ $q->payment_details }}</td>

                                                    <td>{{ $q->payterm }}</td>
                                                    <td>


                                                        {{ $q->status }}</td>
                                                    <td> @if(!empty($q->doc))
                                                            <a href="{{ asset('https://kingsofaffiliate.com/aff/backend/public/uploads/'.$q->doc) }}" class="btn btn-sm btn-primary" download><i class="fa-solid fa-file-invoice"></i></a>
                                                        @endif</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>



                                </div>

                        </div>
                    </div>
                @endsection
                @section('js')
                @endsection
