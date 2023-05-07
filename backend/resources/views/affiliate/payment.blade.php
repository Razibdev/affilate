@extends('affiliate.layout.affiliate-dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">

                    <div class="card"
                        style="box-shadow: 0 4px 8px 0 rgb(146 140 175);transition: 0.3s;border: 1px solid #ffefef;">
                        <div class="card-body">
                            <center>
                                <br><br>
                                <div class="col-md-4">
                                    <div style="border: 1px solid #000;border-radius:12px;" class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">

                                                    
                                                    <p class="text-truncate font-size-14 mb-2">Your Unpaid Salary Amount</p>
                                                    <h4 class="mb-0">${{ $affliate_tr ? round($affliate_tr, 2) : 0 }}</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-exchange-dollar-fill font-size-40"></i>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>



                                <br>
                                <p class="card-title-desc">From our Hr Department you can see all your salary histroy from
                                    here</p>

                                <center>

                                    <div class="table-responsive ">
                                        <table class="table table-bordered table-striped w-100" id="example">
                                            <thead>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Method</th>
                                                <th>Payment Detail</th>
                                                <th>Status</th>
                                                <th>Payment Cycle</th>
                                                <!--        <th>Action</th> -->



                                            </thead>
                                            
                                            <tbody>
                                                @foreach ($affliate_withdraw as $q)
                                                    <tr>
                                                        <td>{{ $q->created_at }}</td>
                                                        <td>{{ round($q->amount, 2) }}</td>
                                                        <td>{{ $q->method }}</td>
                                                        <td>{{ $q->payment_details }}</td>
                                                        <td>{{ $q->status }}</td>
                                                        <td>{{ $q->payterm }}</td>
                                                        <!--      <td><a type="button" href="{{ url('publisher/generate-payment-pdf') }}/?&id={{ $q->id }}" target="_blank"><img src="{{ asset('assets/img/pdf.jpg') }}" width="40"></a></td> -->
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>



                                    </div>
                                </center>
                            </center>
                        </div>
                    </div>
                @endsection
                @section('js')
                @endsection
