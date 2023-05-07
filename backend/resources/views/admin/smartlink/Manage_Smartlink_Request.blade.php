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
                            <h4>Smartlink Approval Requests</h4>
                        </div>
                        <div class="card-body">
                            <form id="form1">
                                <div class="row">


                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table id="smart_linkdatatable"
                                        class="table table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>P.Name</th>
                                                <th>URL</th>
                                                <th>Category</th>
                                                <th>Date</th>
                                                <th>Total Clicks</th>
                                                <th>Total Smartlinks</th>
                                                <th>Earnings</th>
                                                <th>Total Conversion</th>
                                                <th>Status</th>
                                                <th>Action</th>




                                            </tr>
                                        </thead>
                                        <tbody id="showdata" class="text-dark">

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
            var smart_linkdatatable = $('#smart_linkdatatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.show-smartlink-request') }}",
                columns: [{
                        "data": "id"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "publisher.name"
                    },
                    {
                        "data": "url"
                    },
                    {
                        "data": "category.site_category_name"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "ecpm"
                    },
                    {
                        "data": "ecpm"
                    },
                    {
                        "data": "earnings"
                    },
                    {
                        "data": "conversion_rate"
                    },
                    {
                        "data": "enabled"
                    },
                       {
                            "data": "action",
                            "name": 'action',
                            "orderable": false,
                            "searchable": false
                        } 
                ],
            });
        



            $('#smart_linkdatatable').on('click', '.approveData', function() {
                let id = $(this).attr('data');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Approve this Smartlink request ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('admin.smartlink-approve-request') }}",
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
            $('#smart_linkdatatable').on('click', '.rejectData', function() {
                let id = $(this).attr('data');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to reject this Smartlink ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('admin.smartlink-reject-request') }}",
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
