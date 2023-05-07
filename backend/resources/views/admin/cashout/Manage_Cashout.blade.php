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
                            <h4>Publisher Withdrawals</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-right  mt-2">
                                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addModal">Create Withdraw Request</button>
                                </div>
                            </div>
                            <form id='form1' method="GET">
                                <div class="row">
                                    <div class="col-lg-3 ">
                                        <select type="text" name="affliatesearch" class="form-control" required="">
                                            <option value="">Select Publisher</option>
                                            @foreach ($publishers as $q)
                                                <option value="{{ $q->id }}">{{ $q->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select id="status" class="form-control mb-3" name="statussearch">
                                            <option value="">Select Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Locked">Locked</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input class="btn btn-dark" type="submit" id="search" value="Filter">
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-12  table-responsive">
                                    <table id="cashout_table"
                                        class="table table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>Serial</td>
                                                <td>Date</td>
                                                <td>Publisher</td>
                                                <td>Method</td>
                                                <td>Amount</td>
                                                <td>Status</td>
                                                <td>Pay Terms</td>
                                                <td>Pay Period</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody id="showdata">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12">
                                    <h4>Automate Withdrawl Request</h4>
                                    <a href="{{ url('admin/cron-payout-net-45') }}" class="btn btn-primary">Net 45</a>
                                    <a href="{{ url('admin/cron-payout-net-30') }}" class="btn btn-primary">Net 30</a>
                                    <a href="{{ url('admin/cron-payout-net-15') }}" class="btn btn-primary">Net 15</a>
                                    <a href="{{ url('admin/cron-payout-net-7') }}" class="btn btn-primary">Net 7</a>
                                </div>
                                <!-- ADD MODAL -->
                                <form action="{{ url('admin/insert-cashout') }}" id="add_cashout_request" method="post">
                                    @csrf
                                    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Withdraw Request</h5>
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                        <button
                                                            class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="row">
                                                        <div class="col-lg-3 ">
                                                            <label>Balance</label>
                                                            <input type="text" class="form-control" name="balance"
                                                                readonly="true">
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>Select Publisher</label>
                                                            <select type="text" name="affliate_id" class="form-control"
                                                                id="publisher_id" required="">
                                                                <option value="">Select Publisher</option>

                                                                @foreach ($publishers as $q)
                                                                    <option value="{{ $q->id }}"
                                                                        data="{{ $q->balance }}">{{ $q->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>Select Payment Terms</label>
                                                            <select type="text" name="payment_terms"
                                                                class="form-control">
                                                                <!-- <option value="netweekly">netweekly</option> -->
                                                                <option value="net30">net30</option>
                                                                <option value="net45">net45</option>
                                                                <option value="net15">net15</option>
                                                                <option value="net7">net7</option>

                                                                <option value="On Requested">On Requested</option>

                                                            </select>

                                                        </div>



                                                        <div class="col-lg-4 form-group">
                                                            <label> From Date</label>
                                                            <input type="date" name="from_date" class="form-control"
                                                                required="">
                                                        </div>
                                                        <div class="col-lg-4 form-group">
                                                            <label> To Date</label>
                                                            <input type="date" name="to_date" class="form-control"
                                                                required="">
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label> Amount</label>
                                                            <input type="text" name="amount" id="amount"
                                                                class="form-control" required="">
                                                        </div>

                                                        <div class="col-lg-12 form-group">
                                                            <label>Note</label>
                                                            <textarea name="note" class="form-control"></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary"
                                                        id="savebtn">Request</button>
                                                    <button class="btn btn-secondary" type="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End ADD MODAL -->



                                <!-- Edit MODAL -->
                                <form id="update_cashout" method="post" enctype="multipart/form-data">
                                    <div id="editModal" class="modal fade" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> Withdraw Request Number <span
                                                            id="withdraw_id"></span></h5>

                                                </div>
                                                <div class="modal-body">

                                                    @csrf

                                                    <input type="hidden" name="id" id="id">
                                                    <input type="hidden" name="old_amount">
                                                    <input type="hidden" name="publisher_id">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Publisher</p>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p id="affliate"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Method</p>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p id="methoddiv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Details</p>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p id="detail"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Note</p>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p id="notediv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Payment Term</p>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p id="paymentdiv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Period</p>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p id="perioddiv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-3 ">
                                                            <p>Amount</p>
                                                        </div>
                                                        <div class="col-lg-4"><input name="amount1" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Status</p>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <select id="status" class="form-control mb-3"
                                                                name="status">

                                                                <option value="Pending">Pending</option>
                                                                <option value="Locked">Locked</option>
                                                                <option value="Completed">Completed</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                                <option value="Rejected">Rejected</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Upload File (pdf)</p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" id="upload_pdf" name="upload_pdf" accept="application/pdf">
                                                        </div>
                                                    </div>
                                                    
                                            
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <p>Date Of Withdraw Request</p>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <p id="datediv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary"
                                                        id="btnupdate">Edit</button>
                                                    <button class="btn btn-secondary" type="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Edit MODAL -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $affliatesearch = isset($_GET['affliatesearch']) && !empty($_GET['affliatesearch']) ? $_GET['affliatesearch'] : '0';
                $statussearch = isset($_GET['statussearch']) && !empty($_GET['statussearch']) ? $_GET['statussearch'] : '0';
            @endphp
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
                    @if (Session::has('success'))
                        Swal.fire({
                            title: '{{ Session::get('success') }}',
                            confirmButtonText: 'Ok'
                        })
                    @endif
                    let balance = 0;
                    $('#publisher_id').change(function() {

                        balance = $('option:selected', this).attr('data');
                        $('input[name=balance]').val(parseFloat(balance).toFixed(2));
                    })
                    var cashout_table = $('#cashout_table').DataTable({

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

                            url: "{{ route('admin.show-cashout') }}",
                            "data": function(d) {
                                d.affliatesearch = '{{ $affliatesearch }}';
                                d.statussearch = '{{ $statussearch }}';
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
                                "data": "date"
                            },
                            {
                                "data": "publisher.name"
                            },

                            {
                                "data": "method"
                            },

                            {
                                "data": "amount"
                            },
                            {
                                "data": "status"
                            },
                            {
                                "data": "payterm"
                            },
                            {
                                "data": "payperiod"
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

                    $(document).ready(function() {
                        $('#cashout_table').on('click', '.deleteData', function() {

                            let id = $(this).attr('data');
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You want to Delete this Withdraw Request ",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        method: 'get',
                                        data: {
                                            id: id
                                        },
                                        url: "{{ route('admin.delete-cashout') }}",
                                        async: false,
                                        dataType: 'json',
                                        success: function(result) {

                                            // console.log(result);
                                            if (!result.status) {
                                                Swal.fire('Failed', result.message,
                                                    'error');
                                            } else {
                                                Swal.fire('Success', result.message,
                                                    'success');
                                                location.reload();
                                            }
                                        },
                                        error: function(xhr) {

                                            if (xhr.status == 422) {
                                                $.each(xhr.responseJSON.errors,
                                                    function(k, v) {
                                                        form.find('[name="' + k +
                                                            '"]').after(
                                                            '<div class="text-danger">' +
                                                            v[0] +
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
                        })
                        $('#savebtn').unbind().click(function(e) {
                            e.preventDefault();
                            let data = $('#add_cashout_request').serialize();
                            $.ajax({
                                url: "{{ route('admin.insert-cashout') }}",
                                type: 'POST',
                                dataType: 'JSON',
                                data: data,
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
                                            $('#add_cashout_request').find('[name="' + k + '"]').after(
                                                '<div class="text-danger">' + v[0] +
                                                '</div>');
                                        });
                                    } else if (xhr.status == 419) {
                                        window.location.href = "";
                                    }
                                    // console.log(xhr);
                                }
                            });
                        })
                        $('#btnupdate').unbind().click(function(e) {
                            e.preventDefault();
                            
                            let files = $('#upload_pdf')[0].files;
                            var form = $("#update_cashout");
                            let data  = new FormData(form[0]);
                            if(files.length > 0){
                                data.append('upload_pdf',files[0]);
                            }
                            // let data = $('#update_cashout').serialize();
                            
                            console.log(data);
                            $.ajax({
                                url: "{{ route('admin.update-cashout') }}",
                                type: 'POST',
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                data: data,
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
                                            $('#update_cashout').find('[name="' + k + '"]').after(
                                                '<div class="text-danger">' + v[0] +
                                                '</div>');
                                        });
                                    } else if (xhr.status == 419) {
                                        window.location.href = "";
                                    }
                                    // console.log(xhr);
                                }
                            });
                        })
                        $('#cashout_table').on('click', '.editData', function() {

                            let id = $(this).attr('data');

                            $.ajax({
                                method: 'get',
                                data: {
                                    id: id
                                },
                                url: "{{ route('admin.edit-cashout') }}",
                                async: false,
                                dataType: 'json',
                                success: function(res) {
                                    $('#editModal').modal('show');

                                    $('select[name=status]').val(res.status);

                                    $('#affliate').html(res.publisher.name);
                                    $('#methoddiv').html(res.method);
                                    $('#notediv').html(res.note);

                                    $('#detail').html(res.payment_details);
                                    $('#paymentdiv').html(res.payterm);
                                    $('#perioddiv').html(res.from_date + ' to ' + res.to_date);
                                    $('input[name=amount1]').val(parseFloat(res.amount).toFixed(
                                        2));
                                    $('input[name=old_amount]').val(parseFloat(res.amount)
                                        .toFixed(2));

                                    $('input[name=publisher_id]').val(res.affliate_id);

                                    $('#datediv').html(res.created_at);


                                    $('#withdraw_id').html(res.id);
                                    $('#id').val(res.id);

                                },



                            })
                        })


                    });



                });
            </script>
        @endsection
