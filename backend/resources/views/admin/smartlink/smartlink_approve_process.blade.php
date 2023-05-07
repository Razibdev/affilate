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
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>Smartlink Leads</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Offer Name</label>
                                        <input class="form-control" placeholder="Offer Name" name="offer_name"
                                            value="{{ isset($_GET['offer_name']) ? $_GET['offer_name'] : '' }}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Offer Id</label>
                                        <input class="form-control" placeholder="Offer Id" name="offer_id"
                                            value="{{ isset($_GET['offer_id']) ? $_GET['offer_id'] : '' }}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Ip Address</label>
                                        <input class="form-control" placeholder="Ip Address" name="ip_address"
                                            value="{{ isset($_GET['ip_address']) ? $_GET['ip_address'] : '' }}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Publisher Name</label>
                                        <input class="form-control" placeholder="Publisher Name" name="publisher_name"
                                            value="{{ isset($_GET['publisher_name']) ? $_GET['publisher_name'] : '' }}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Publisher Email</label>
                                        <input class="form-control" placeholder="Publisher Email" name="publisher_email"
                                            value="{{ isset($_GET['publisher_email']) ? $_GET['publisher_email'] : '' }}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Hash</label>
                                        <input class="form-control" placeholder="Hash" name="hash"
                                            value="{{ isset($_GET['hash']) ? $_GET['hash'] : '' }}">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Advertiser Name</label>
                                        <input class="form-control" placeholder="Advertiser Name" name="advertiser_name"
                                            value="{{ isset($_GET['advertiser_name']) ? $_GET['advertiser_name'] : '' }}">
                                    </div>
                                    @php
                                        $offer_name = isset($_GET['offer_name']) ? $_GET['offer_name'] : '';
                                        $offer_id = isset($_GET['offer_id']) ? $_GET['offer_id'] : '';
                                        $ip_address = isset($_GET['ip_address']) ? $_GET['ip_address'] : '';
                                        $publisher_name = isset($_GET['publisher_name']) ? $_GET['publisher_name'] : '';
                                        $publisher_email = isset($_GET['publisher_email']) ? $_GET['publisher_email'] : '';
                                        $hash = isset($_GET['hash']) ? $_GET['hash'] : '';
                                        $advertiser_name = isset($_GET['advertiser_name']) ? $_GET['advertiser_name'] : '';
                                        $country_list = isset($_GET['countries']) ? $_GET['countries'] : '';
                                        if (!empty($country_list)) {
                                            $country_list = implode(',', $country_list);
                                        }
                                        $ua_target = isset($_GET['ua_target']) ? $_GET['ua_target'] : '';
                                        if (!empty($ua_target)) {
                                            $ua_target = implode(',', $ua_target);
                                        }
                                        $browser = isset($_GET['browser']) ? $_GET['browser'] : '';
                                        if (!empty($browser)) {
                                            $browser = implode(',', $browser);
                                        }
                                        
                                    @endphp
                                    <div class="col-lg-3">
                                        <label class="form-label">Countries</label>
                                        <select class="js-example-basic-multiple" name="countries[]" multiple="multiple"
                                            style="width: 100%">
                                            <option></option>
                                            @foreach ($country as $q)
                                                <option value="{{ $q->country_name }}">{{ $q->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-label">Targeting</label>
                                        <select class="selectpicker w-100" name="ua_target[]" id="ua_target" multiple
                                            data-actions-box="true">
                                            <option value="Windows">Windows</option>
                                            <option value="Android">Android</option>
                                            <option value="Iphone">Iphone</option>
                                            <option value="Ipad">Ipad</option>
                                            <option value="Mac">Mac</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-label">Browsers</label>
                                        <select class="selectpicker w-100" name="browser[]" multiple data-actions-box="true"
                                            required="">
                                            <?php if (isset($data[0])) {
                                                $ua = explode('|', $data[0]->browsers);
                                            }
                                            ?>
                                            <option value="Firefox">Firefox</option>
                                            <option value="Chrome">Chrome</option>
                                            <option value="Safari">Safari</option>
                                            <option value="EDGE">EDGE</option>
                                            <option value="Internet Explorer">Internet Explorer</option>
                                            <option value="OPERA MINI">OPERA MINI</option>
                                            <option value="Others">Others</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-8">
                                        <button class="btn btn-primary" type="submit"
                                            style="margin-top: 31px;">Filter</button>
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="Approved">
                                <input type="hidden" name="smart_link" value="yes">
                            </form>

                            <div class="row">
                                <div class="col-md-12">
                                <a class="btn btn-sm m-2 btn-danger rejectSelected" id="rejectSelected"
                                        type="button">Reject Selected</a>
                                <a class="btn btn-sm m-2 btn-danger rejectAll" id="rejectAll" type="button">Reject All</a>
                                </div>
                            </div>
                            <div class="row">
                                <form id="form">
                                    @csrf
                                    <div class="col-lg-12 mt-3  table-responsive">
                                        <table id="offer_process_table"
                                            class="table table-bordered table-striped dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Offer Name</td>
                                                    <td>Ip Address</td>
                                                    <td>Date</td>
                                                    <td>Publisher ID</td>
                                                    <td>Publisher Name</td>
                                                    <td>Publisher Email</td>
                                                    <td>Payout</td>
                                                    <td>Advertiser Name</td>
                                                    <td>Hash Key</td>
                                                    <td>Country</td>
                                                    <td>Browser</td>
                                                    <td>UA Target</td>
                                                    <td>Unique</td>
                                                    <td>Status</td>
                                                </tr>
                                            </thead>

                                            <tbody id="showdata" class="text-dark">
                                                {{-- @foreach ($offers as $q)
                                                    <tr>
                                                        <td><input type="checkbox" name="check[]"
                                                                value="{{ $q->id }}"></td>
                                                        <td>{{ $q->advertiser_offer_id }}</td>
                                                        <td>{{ $q->offer_name }}</td>
                                                        <td>{{ $q->ip_address }}</td>
                                                        <td>{{ $q->created_at }}</td>                                                    
                                                        <td>{{ $q->publisher->name }}</td>
                                                        <td>{{ $q->publisher->email }}</td>
                                                        <td>{{ round($q->payout, 2) }}</td>
                                                        <td>{{ $q->advertiser->advertiser_name }}</td>
                                                        <td>{{ $q->code }}</td>
                                                        <td>{{ $q->country }}</td>
                                                        <td>{{ $q->browser }}</td>
                                                        <td>{{ $q->ua_target }}</td>
                                                        <td>{{ $q->unique_ }}</td>
                                                        <td>{{ $q->status }}</td>
                                                    </tr>
                                                @endforeach --}}
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                        {{-- {{ $offers->appends(Request::all())->links() }} --}}
                                    </div>
                                </form>
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
    <script type="text/javascript">
        $(function() {
            var offer_process_table = $('#offer_process_table').DataTable({
                processing: true,
                serverSide: true,
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
                scrollX: true,
                "ajax": {

                    url: "{{ route('admin.show-offer-process') }}",
                    "data": function(d) {
                        d.status_type = 'Approved';
                        d.offer_type = 'smartlink';
                        d.offer_name = '{{ $offer_name }}';
                        d.offer_id = '{{ $offer_id }}';
                        d.ip_address = '{{ $ip_address }}';
                        d.publisher_name = '{{ $publisher_name }}';
                        d.publisher_email = '{{ $publisher_email }}';
                        d.advertiser_name = '{{ $advertiser_name }}';
                        d.country_list = '{{ $country_list }}';
                        d.ua_target = '{{ $ua_target }}';
                        d.browser = '{{ $browser }}';
                    },
                    error: function(xhr) {

                        session_error(xhr);

                        // console.log(xhr.status);

                    }

                },

                columns: [{
                        "data": "id"
                    },
                    {
                        "data": "checkbox"
                    },

                    {
                        "data": "offer_name"
                    },
                    {
                        "data": "ip_address"
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "publisher.id"
                    },
                    {
                        "data": "publisher.name"
                    },
                    {
                        "data": "publisher.email"
                    },
                    {
                        "data": "payout"
                    },
                    {
                        "data": "advertiser.advertiser_name"
                    },
                    {
                        "data": "code"
                    },
                    {
                        "data": "country"
                    },
                    {
                        "data": "browser"
                    },
                    {
                        "data": "ua_target"
                    },
                    {
                        "data": "unique_"
                    },
                    {
                        "data": "status"
                    },

                ],
            });

            $('#rejectSelected').click(function() {

                var data = $('#form').serialize();
                console.log(data);
                var searchIDs = $('#offer_process_table input:checked').map(function() {

                    return $(this).val();

                });

                $.ajax({
                    method: 'get',
                    data: {
                        check: searchIDs.get()
                    },
                    url: '<?php echo url('admin/approve-reject-offer-process1'); ?>',
                    async: false,
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire('Success', 'Offer Process Rejected successfully',
                            'success');
                        location.reload();
                    },
                    error: function() {
                        Swal.fire('Failed', 'Error', 'error');
                    }

                })
                })

                $('#rejectAll').click(function() {

                    var data = $('#form').serialize();
                    $("#offer_process_table input:checkbox").attr('checked', 'true');
                    var searchIDs = $('#offer_process_table input:checked').map(function() {

                        return $(this).val();

                    });

                    $.ajax({
                        method: 'get',
                        data: {
                            check: searchIDs.get()
                        },
                        url: '<?php echo url('admin/approve-reject-offer-process1'); ?>',
                        async: false,
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Success', 'Offer Process Rejected successfully',
                                'success');
                            location.reload();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');
                        }

                    })
                    })
        });
    </script>
@endsection
