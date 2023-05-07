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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>View Offers Report</h4>
                        </div>
                        <div class="card-body">

                            <form method="post" action="{{url('/admin/view-offer-report')}}">{{csrf_field()}}
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-lg-3">
                                        <label class="form-label" for="from_date">From</label>
                                        <input type="date" name="from_date" id="from_date"  class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label" for="to_date">To</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
{{--                                        <label class="form-label" for="to_date"></label>--}}
                                        <button type="submit" class="btn btn-success" style="margin-top: 30px;">Filter</button>
                                    </div>

                                </div>

{{--                                --}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;" >--}}
{{--                                        <label for="today"> <button type="submit" class="btn btn-success">Today</button></label>--}}
{{--                                        <input type="radio" name="filter" value="today" id="today" style="opacity: 0;">--}}
{{--                                    </div>--}}

{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;">--}}
{{--                                        <label for="yesterday">  <button type="submit" class="btn btn-success">Yesterday</button></label>--}}
{{--                                        <input type="radio" name="filter" value="yesterday" id="yesterday" style="opacity: 0;">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;">--}}
{{--                                        <button type="button" class="btn btn-success">This Week</button>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;">--}}
{{--                                        <button type="button" class="btn btn-success">Last 7 Days</button>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;">--}}
{{--                                        <button type="button" class="btn btn-success">Last Week</button>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;">--}}
{{--                                        <button type="button" class="btn btn-success">Month to Date</button>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;">--}}
{{--                                        <button type="button" class="btn btn-success">Last Month</button>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2" style="margin-bottom: 10px;">--}}
{{--                                        <button type="button" class="btn btn-success">Year to Date</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            --}}
{{--                            --}}


                            </form>
                            @php
                            $total_clck = 0;
                            $total_lead = 0;
                            $total_earning = 0;
                            $total_cvr = 0;
                            $total_u_click = 0;
                            $total_ecpm = 0;

                            @endphp

                            <div class="row">
                                <h6>Summary</h6>

                                <table class="table table-bordered table-striped dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="thead thead-light" >
                                    <tr>
                                        <th>Click</th>
                                        <th>Leads</th>
                                        <th>Earning</th>
                                        <th>Unique Click</th>
                                        <th>CR</th>
                                        <th>CVR</th>
                                        <th>ECPM</th>

                                    </tr>
                                    </thead>
                                    <tbody class="text-dark" >
                                    @foreach($offer as $off)
                                        @php
                                            $total_clck += $off->click_count->count();
                                            $total_lead += $off->lead_count->count();
                                            $total_earning += $off->click_count->sum('payout');
                                            $total_u_click += $off->unique_click->count();

                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td>{{$total_clck}}</td>
                                        <td>{{$total_lead}}</td>
                                        <td>{{number_format($total_earning, 2)}}</td>
                                        <td>{{$total_u_click}}</td>
                                        <td>{{$total_clck== 0? 0 : $total_clck*100}}%</td>
                                        <td>{{$total_lead ==0 ? 0 : number_format(($total_lead/$total_clck)*100)}}%</td>
                                        <td>@if($total_earning > 0) {{number_format($total_earning / $total_clck? $total_clck : 1, 2)}} @else 0 @endif</td>


                                    </tr>
                                    </tbody>
                                </table>

                            </div>


                            <div class="row">
                                <h6>Detailed Report </h6>

                                <table class="table table-bordered table-striped dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="thead thead-light">
                                    <tr>
                                        <th>Offer Name</th>
                                        <th>Click</th>
                                        <th>Leads</th>
                                        <th>Earning</th>
                                        <th>CR</th>
                                        <th>CVR</th>
                                        <th>Unique Click</th>
                                        <th>ECPM</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                    @foreach($offer as $off)
                                        <tr>
                                            <td>{{$off->offer_name}}</td>
                                            <td>{{$off->click_count->count()}}</td>
                                            <td>{{$off->lead_count->count()}}</td>
                                            <td>{{number_format($off->click_count->sum('payout'), 2)}}</td>
                                            <td>{{$off->click_count->count()*100}}%</td>
                                            <td>{{$off->lead_count->count()== 0? 0 : number_format(($off->lead_count->count()/ $off->click_count->count())*100, 2) }} %</td>
                                            <td>{{$off->unique_click->count()}}</td>
                                            <td>@if($off->click_count->sum('payout')) € {{round($off->click_count->sum('payout')/($off->click_count->count()?$off->click_count->count():1),2)}} @else 0 @endif</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        <?php $site = DB::table('site_settings')->first(); ?>
        $(function() {

            $(function() {
                $('.selectpicker').selectpicker();
            });


            $('#description').summernote({
                height: 150
            });
            $('#requirements').summernote({
                height: 150
            });
            $('.js-example-basic-multiple').select2();

            @if (Session::has('success'))
            Swal.fire({
                title: '{{ Session::get('success') }}',


                confirmButtonText: 'Ok'
            })
            @endif

            $('#payout').change(function() {
                if ($('#payout').val() == 'fixed') {
                    $('#payout_amount').removeAttr('disabled', 'true');
                    $('#payout_amount').val('');
                } else {


                    $('#payout_amount').attr('disabled', 'true');


                }
            })
            $('select[name=offer_type]').change(function(e) {
                if ($('select[name=offer_type]').val() == 'special') {
                    $('.divhide').removeClass('d-none');


                } else {

                    $('.divhide').addClass('d-none');

                }
            })
            var offer_table = $('#offer_table').DataTable({

                "mark": true,

                "order": [

                    [0, "desc"]

                ],

                "columnDefs": [

                    {

                        "targets": [0],

                        "render": function(data, type, row, meta) {

                            return '#' + data;

                        }

                    },

                    {

                        "responsivePriority": 1,

                        "targets": 0

                    },

                    {

                        "responsivePriority": 2,

                        "targets": -1,

                        "orderable": false

                    }

                ],

                "processing": true,

                "serverSide": true,

                "ajax": {

                    url: "{{ route('admin.show-offers') }}",
                    "data": function(d) {
                        d.offer_name = $('#offer_name').val();
                        d.offer_id = $('#offer_id').val();
                        d.countries = $('#countries').val();
                        d.ua_target = $('#ua_target').val();
                        d.traffic = $('#traffic').val();
                        d.status = $('#status').val();
                        d.offer_type = $('#offer_type').val();
                    },
                    error: function(xhr) {

                        session_error(xhr);

                        // console.log(xhr.status);

                    }

                },

                "columns": [

                    {
                        "data": "id"
                    },

                    {
                        "data": "offer_name"
                    },
                    {
                        "data": "category.category_name"
                    },
                    {
                        "data": "countries"
                    },

                    {
                        "data": "payout_type"
                    },
                    {
                        "data": "payout"
                    },
                    {
                        "data": "browsers"
                    },
                    {
                        "data": "ua_target"
                    },

                    {
                        "data": "status"
                    },
                    {
                        "data": "offer_type"
                    },
                    {
                        "data": "clicks"
                    },
                    {
                        "data": "conversion"
                    },

                    {
                        "data": "smartlinkstatus"
                    },


                    {
                        "data": "action"
                    }

                ],

                drawCallback: function(settings) {

                    $(document).find('[data-toggle="tooltip"]').tooltip();

                },

                initComplete: function(settings, json) {

                    // $(document).find('[data-toggle="tooltip"]').tooltip();

                }

            })
            $('#offer_table').on('click', '.deleteData', function() {
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this Offer ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('admin.delete-offer') }}",
                            type: 'GET',
                            dataType: 'JSON',
                            data: {
                                id: id
                            },
                            success: function(result) {
                                $('.loader').fadeOut();
                                // console.log(result);
                                if (!result.status) {
                                    Swal.fire('Failed', result.message, 'error');

                                } else {
                                    Swal.fire('Success', result.message, 'success');

                                    location.reload();

                                }
                            },
                            error: function(xhr) {
                                $('.loader').fadeOut();
                                if (xhr.status == 422) {
                                    $.each(xhr.responseJSON.errors, function(k, v) {
                                        form.find('[name="' + k + '"]').after(
                                            '<div class="text-danger">' + v[
                                                0] +
                                            '</div>');
                                    });
                                } else if (xhr.status == 419) {
                                    window.location.href = "";
                                }
                                // console.log(xhr);
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
