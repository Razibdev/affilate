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

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>Publisher Approval Requests</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-right mb-4  mt-2">
                                    <a href="{{ route('admin.add-new-publisher') }}" class="btn btn-primary float-end">Add New Publisher</a>

                                </div>
                                <div class="col-lg-12 table-responsive ">

                                    <table id="publisher_approval_datatable" class="table table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>Serial</td>
                                                <td>Name</td>
                                                <td>Email</td>
                                                <td>Status</td>
                                                <td>Email Verification</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody class="text-dark">

                                        </tbody>
                                        <tfoot>
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
@section('js')
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
            // showdata();
            var publisher_approval_datatable = $('#publisher_approval_datatable').DataTable({

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

                    url: "{{ route('admin.show-publisher-approval') }}",

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
                        "data": "name"
                    },

                    {
                        "data": "email"
                    },

                    {
                        "data": "status"
                    },
                    {
                        "data": "verfied"
                    },

                    {
                        "data": "action2"
                    }

                ],

                drawCallback: function(settings) {

                    $(document).find('[data-toggle="tooltip"]').tooltip();

                },

                initComplete: function(settings, json) {

                    // $(document).find('[data-toggle="tooltip"]').tooltip();

                }

            })
            // dt_search(datatable);
            $('#publisher_approval_datatable').unbind().on('click', '.approveData', function() {
                // alert('aaaaa');
                let id = $(this).attr('data');
                let url = $(this).attr('data-href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Approve this Publisher ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: url,
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
        
            //EDIT DATA
            $('#showdata').on('click', '.ban', function() {
                let id = $(this).attr('data');
                var txt;
                var r = confirm("Do you want to BAN this account!");
                if (r == true) {
                    window.location.href = '<?php echo url('admin/ban-publishers'); ?>/' + id + '';
                }
            })


        });
    </script>
@endsection
