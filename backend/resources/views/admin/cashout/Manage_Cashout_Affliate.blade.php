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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-md-12 col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>Affiliate Manager Withdrawals</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-right  mt-2">
                                    <button class="btn float-end btn-primary m-2" data-bs-toggle="modal"
                                        data-bs-target="#addModal">Create
                                        Withdrawal Request</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    <table id="advtizer_datatable"
                                        class="table table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>Serial</td>
                                                <td>Date</td>
                                                <td>Manager</td>
                                                <td>Method</td>
                                                <td>Amount</td>
                                                <td>Status</td>
                                                <td>Pay Term</td>
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
                                    <a href="{{ url('admin/InstantWithdraw') }}" class="btn btn-primary">Instant
                                        Widthraw</a>
                                </div>
                                <!-- ADD MODAL -->
                                <form action="{{ url('admin/insert-cashout-affliate') }}" id="add_cashout_request"
                                    method="post">
                                    @csrf
                                    <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">New Withdraw Request</h5>
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
                                                            <label>Select Affiliate Manager</label>
                                                            <select type="text" name="affliate_id" class="form-control"
                                                                id="publisher_id" required="">
                                                                <option value="">Select Manager</option>

                                                                @foreach ($Affliate as $q)
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
                                                            <input type="number" name="amount" id="amount"
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
                                <form action="{{ url('admin/update-cashout-affliate') }}" id="edit_affliate_withdrwal"
                                    method="post">
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
                                                    <input type="hidden" name="affliate_id">
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Affiliate Manager</p>
                                                        </div>
                                                        <div class="col-md-8 col-lg-8">
                                                            <p id="affliate"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Method</p>
                                                        </div>
                                                        <div class="col-md-8 col-lg-8">
                                                            <p id="methoddiv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Details</p>
                                                        </div>
                                                        <div class="col-md-8 col-lg-8">
                                                            <p id="detail"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Note</p>
                                                        </div>
                                                        <div class="col-md-8 col-lg-8">
                                                            <p id="notediv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Payment Term</p>
                                                        </div>
                                                        <div class="col-md-8 col-lg-8">
                                                            <p id="paymentdiv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Period</p>
                                                        </div>
                                                        <div class="col-md-8 col-lg-8">
                                                            <p id="perioddiv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-3 col-lg-3 ">
                                                            <p>Amount</p>
                                                        </div>
                                                        <div class="col-md-4 col-lg-4"><input name="amount1"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Status</p>
                                                        </div>
                                                        <div class="col-md-4 col-lg-4">
                                                            <select id="status" class="form-control mb-3"
                                                                name="status">
                                                                <option value="Pending">Pending</option>
                                                                <option value="Locked">Locked</option>
                                                                <option value="Completed">Completed</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <p>Date Of Cashout Request</p>
                                                        </div>
                                                        <div class="col-md-8 col-lg-8">
                                                            <p id="datediv"></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" id="btnupdate"
                                                        class="btn btn-primary">Edit</button>
                                                    <button class="btn btn-secondary" type="button"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                    var advtizer_datatable = $('#advtizer_datatable').DataTable({

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

                            url: "{{ route('admin.show-cashout-affliate') }}",

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
                                "data": "affliate.name"
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
                        $('#advtizer_datatable').on('click', '.deleteData', function(e) {
                            e.preventDefault();

                            let id = $(this).attr('data');
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You want to Delete this Withdrawal Request ",
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
                                        url: "{{ route('admin.delete-cashout-affliate') }}",
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
                        $('#advtizer_datatable').on('click', '.editData', function(e) {
                            e.preventDefault();
                            let id = $(this).attr('data');

                            $.ajax({
                                method: 'get',
                                data: {
                                    id: id
                                },
                                url: "{{ route('admin.edit-cashout-affliate') }}",
                                async: false,
                                dataType: 'json',
                                success: function(res) {
                                    $('#editModal').modal('show');

                                    $('select[name=status]').val(res.status);

                                    $('#affliate').html(res.affliate.name);
                                    $('#methoddiv').html(res.method);
                                    $('#notediv').html(res.note);

                                    $('#detail').html(res.payment_details);
                                    $('#paymentdiv').html(res.payterm);
                                    $('#perioddiv').html(res.from_date + ' to ' + res.to_date);
                                    $('input[name=amount1]').val(parseFloat(res.amount).toFixed(
                                        2));
                                    $('input[name=old_amount]').val(parseFloat(res.amount)
                                        .toFixed(2));

                                    $('input[name=affliate_id]').val(res.affliate_id);

                                    $('#datediv').html(res.created_at);


                                    $('#withdraw_id').html(res.id);
                                    $('#id').val(res.id);

                                },



                            })
                        })
                        $('#savebtn').unbind().click(function(e) {
                            e.preventDefault();
                            let data = $('#add_cashout_request').serialize();
                            $.ajax({
                                url: "{{ route('admin.insert-cashout-affliate') }}",
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
                                            form.find('[name="' + k + '"]').after(
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
                            let data = $('#edit_affliate_withdrwal').serialize();
                            $.ajax({
                                url: "{{ route('admin.update-cashout-affliate') }}",
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
                                            form.find('[name="' + k + '"]').after(
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
                    });



                });
            </script>
        @endsection
