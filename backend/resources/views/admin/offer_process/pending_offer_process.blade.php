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
                            <h4>All Clicks</h4>
                        </div>
                        <div class="card-body" id="card_body">
                            <form action="" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Offer Name</label>
                                        <input class="form-control" placeholder="Offer Name" name="offer_name" value="{{(isset($_GET['offer_name']))?$_GET['offer_name']:''}}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Offer ID</label>
                                        <input class="form-control" placeholder="Offer ID" name="offer_id"  value="{{(isset($_GET['offer_id']))?$_GET['offer_id']:''}}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>IP Address</label>
                                        <input class="form-control" placeholder="IP Address" name="ip_address"  value="{{(isset($_GET['ip_address']))?$_GET['ip_address']:''}}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Publisher Name</label>
                                        <input class="form-control" placeholder="Publisher Name" name="publisher_name"  value="{{(isset($_GET['publisher_name']))?$_GET['publisher_name']:''}}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Publisher Email</label>
                                        <input class="form-control" placeholder="Publisher Email" name="publisher_email"  value="{{(isset($_GET['publisher_email']))?$_GET['publisher_email']:''}}">
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Hash</label>
                                        <input class="form-control" placeholder="Hash" name="hash"  value="{{(isset($_GET['hash']))?$_GET['hash']:''}}">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Advertiser Name</label>
                                        <input class="form-control" placeholder="Advertiser Name" name="advertiser_name"  value="{{(isset($_GET['advertiser_name']))?$_GET['advertiser_name']:''}}">
                                    </div>
                                    @php
                                     $offer_name=(isset($_GET['offer_name']))?$_GET['offer_name']:'';
                                     $offer_id=(isset($_GET['offer_id']))?$_GET['offer_id']:'';
                                     $ip_address=(isset($_GET['ip_address']))?$_GET['ip_address']:'';
                                     $publisher_name=(isset($_GET['publisher_name']))?$_GET['publisher_name']:'';
                                     $publisher_email=(isset($_GET['publisher_email']))?$_GET['publisher_email']:'';
                                     $hash=(isset($_GET['hash']))?$_GET['hash']:'';
                                     $advertiser_name=(isset($_GET['advertiser_name']))?$_GET['advertiser_name']:'';
                                     $country_list=(isset($_GET['countries']))?$_GET['countries']:'';
                                     if(!empty($country_list)){
                                     $country_list=implode(",",$country_list);
                                     }
                                     $ua_target=(isset($_GET['ua_target']))?$_GET['ua_target']:'';
                                     if(!empty($ua_target)){
                                      $ua_target=implode(",",$ua_target);
                                     }
                                     $browser=(isset($_GET['browser']))?$_GET['browser']:'';
                                       if(!empty($browser)){
                                      $browser=implode(",",$browser);
                                       }
                                    
                                      @endphp
                                    <div class="col-lg-3">
                                        <label class="form-label">Countries</label>
                                        <select class="js-example-basic-multiple" multiple="multiple" style="width: 100%" name="countries[]"">
                                            <option></option>
                                            @foreach ($country as $q)
                                                <option value="{{ $q->country_name }}">{{ $q->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-label">Targeting</label>
                                        <select class="js-example-basic-multiple" multiple="multiple" style="width: 100%" name="ua_target[]" id="ua_target" >
                                            <option value="Windows">Windows</option>
                                            <option value="Android">Android</option>
                                            <option value="Iphone">Iphone</option>
                                            <option value="Ipad">Ipad</option>
                                            <option value="Mac">Mac</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-label">Browsers</label>
                                        <select  class="js-example-basic-multiple" multiple="multiple" style="width: 100%" name="browser[]">
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
                                            style="margin-top: 31px;">Search Data</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        {{-- <a class="btn btn-sm m-2 btn-primary  waitingSelected" id="waitingSelected"
                                            type="button">Mark Waiting Selected</a>
                                        <a class="btn btn-sm m-2 btn-primary waitAll" id="waitAll" type="button">Wait
                                            All</a> --}}





                                        <!-- <a class="btn btn-sm m-2  btn-warning rejectSelected" id="rejectSelected"
                                            type="button">Reject Selected</a>




                                        <a class="btn btn-sm m-2 btn-warning  rejectAll" id="rejectAll"
                                            type="button">Reject
                                            All</a>



                                        





                                        <a class="btn btn-sm m-2 btn-success  approveAll" id="approveAll"
                                            type="button">Approve All</a> -->
                                        
                                        <a class="btn btn-sm m-2 btn-success  approveSelected" id="approveSelected"
                                            type="button">Approved Selected</a>
                                        <a class="btn btn-sm m-2 btn-danger  deleteSelected" id="deleteSelected"
                                            type="button">Delete Selected</a>





                                        <a class="btn btn-sm m-2 btn-danger  deleteAll" id="deleteAll"
                                            type="button">Delete All</a>
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="Pending">
                            </form>







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
                                                    <td>IP Address</td>
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

                                            </tbody>

                                        </table>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete MODAL -->

                    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Pending Offer Process</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Do You want to delete this Pending Offer Process.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btnDelete">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Delete MODAL -->
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
        $(document).ready(function() {
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
                        d.status_type = 'Pending';
                        d.offer_type = 'offer_process';
                         d.offer_name = '{{$offer_name}}';
                        d.offer_id = '{{$offer_id}}';
                        d.ip_address = '{{$ip_address}}';
                        d.publisher_name = '{{$publisher_name}}';
                        d.publisher_email = '{{$publisher_email}}';
                        d.advertiser_name = '{{$advertiser_name}}';
                        d.country_list = '{{$country_list}}';
                        d.ua_target = '{{$ua_target}}';
                        d.browser = '{{$browser}}';
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
            $(function() {


                $('#card_body').on('click', '#approveSelected', function() {

                    var data = $('#form').serialize();
                    console.log(data);
                    var searchIDs = $('#offer_process_table input:checked').map(function() {

                        return $(this).val();

                    });
                    console.log(searchIDs);
                    $.ajax({
                        method: 'get',
                        data: {
                            check: searchIDs.get()
                        },
                        url: '<?php echo url('admin/approve-pending-offer-process'); ?>',
                        async: false,
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Success', 'Offer Process Approved successfully',
                                'success');
                            location.reload();
                            // searchData();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');

                        }

                    })
                })
                $('#rejectSelected').click(function() {

                    var data = $('#form').serialize();

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
                            // searchData();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');
                        }

                    })
                })
                $('#deleteSelected').click(function() {

                    var data = $('#form').serialize();

                    var searchIDs = $('#offer_process_table input:checked').map(function() {

                        return $(this).val();

                    });

                    $.ajax({
                        method: 'get',
                        data: {
                            check: searchIDs.get()
                        },
                        url: '<?php echo url('admin/delete-offer-process'); ?>',
                        async: false,
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Success', 'Offer Process delete successfully',
                                'success');
                            location.reload();
                            // searchData();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');
                        }

                    })
                })
                $('#waitingSelected').click(function() {
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
                        url: '<?php echo url('admin/approve-wait-offer-process'); ?>',
                        async: false,
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Success', 'Offer Process Waited successfully',
                                'success');
                            location.reload();
                            // searchData();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');
                        }

                    })
                })
                $('#waitAll').click(function() {

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
                        url: '<?php echo url('admin/approve-wait-offer-process'); ?>',
                        async: false,
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Success', 'Offer Process Rejected successfully',
                                'success');
                            location.reload();
                            // searchData();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');
                        }

                    })
                })
                $('#approveAll').click(function() {

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
                        url: '<?php echo url('admin/approve-pending-offer-process'); ?>',
                        async: false,
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Success', 'Offer Process Approved successfully',
                                'success');
                            location.reload();
                            // searchData();
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
                            // searchData();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');
                        }

                    })
                })
                $('#deleteAll').click(function() {

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
                        url: '<?php echo url('admin/delete-offer-process'); ?>',
                        async: false,
                        dataType: 'json',
                        success: function(res) {
                            Swal.fire('Success', 'Offer Process Deleted successfully',
                                'success');
                            location.reload();
                            // searchData();
                        },
                        error: function() {
                            Swal.fire('Failed', 'Error', 'error');
                        }

                    })
                })



            })
        });
    </script>
@endsection
