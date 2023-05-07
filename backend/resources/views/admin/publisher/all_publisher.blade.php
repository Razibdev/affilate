@extends('admin.layout.admin-dashboard')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ config('app.url') }}/public/public/vendors/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="{{ config('app.url') }}/public/public/vendors/datatables/datatables.mark.css" rel="stylesheet" type="text/css" />
<link href="{{ config('app.url') }}/public/public/vendors/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="{{ config('app.url') }}/public/public/vendors/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
<link href="{{ config('app.url') }}/public/public/vendors/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card radius-10">
                    <div class="card-header">
                        <h4>Manage Publishers</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 text-right mb-4  mt-2">
                                <a href="{{route('admin.add-new-publisher')}}" class="btn btn-primary float-end">Create New Publisher</a>

                            </div>
                            <div class="col-lg-12 table-responsive ">
                                <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <td>PID</td>
                                            <td>Name</td>
                                            <td>Email</td>
                                            <td>Status</td>
                                            <td>Manager Name</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody id="showdata">
                                    </tbody>
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
<script type="text/javascript" src="{{ config('app.url') }}/public/public/vendors/datatables/jquery.mark.min.js"></script>
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
        @if(Session::has('success'))
        Swal.fire({
            title: '{{ Session::get('
            success ') }}',
            confirmButtonText: 'Ok'
        })
        @endif
        // showdata();
        var datatable = $('#datatable').DataTable({
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

                url: "{{route('admin.show-publishers')}}",

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
                    "data": "managername"
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
        // dt_search(datatable);
        $('#showdata').on('click', '.publisher_delete', function() {
            // alert('aaaaa');
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to Delete this Publisher ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.delete-publishers') }}",
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
        $('#datatable').on('click', '.publisher_ban', function() {
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to Ban this Publisher ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.ban-publishers') }}",
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
        $('#datatable').on('click', '.change_status', function() {
            let id = $(this).attr('data-id');
            let status = $(this).attr('data-status');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to " + status + " this Publisher ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.delete-site-categories') }}",
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