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
                            <h4>Manage Tracking Domain</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12 text-right mb-4 mt-2">
                                <button class="btn btn-primary  add_model" type="button" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add Domain</button>
                            </div>

                            <div class="col-lg-12 table-responsive">
                                <table id="trakeing_link_datatable"
                                    class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sno</th>
                                            <th>Tracking Domain</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showdata">

                                    </tbody>
                                </table>


                                <!-- ADD MODAL -->

                                <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content position-relative">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Tracking Domain</h5>
                                                <button
                                                    class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="add_form">
                                                    @csrf
                                                    <label>Domain Name</label>

                                                    <input type="text" name="domain_name" class="form-control">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                                                <button class="btn btn-secondary" type="button"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End ADD MODAL -->



                                <!-- Edit MODAL -->

                                <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Tracking Domain</h5>
                                                <button
                                                    class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="edit_form">
                                                    @csrf
                                                    <label>Domain Name</label>
                                                    <input type="hidden" name="id" id="id">
                                                    <input type="text" name="domain_name1" class="form-control">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
                                                <button class="btn btn-secondary" type="button"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
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
                    var trakeing_link_datatable = $('#trakeing_link_datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        scrollX: true,
                        ajax: "{{ route('admin.show-domain') }}",
                        columns: [{
                                "data": "id"
                            },
                            {
                                "data": "domain_name"
                            },
                            {
                                "data": "action",
                                "name": 'action',
                                "orderable": false,
                                "searchable": false
                            }
                        ],
                    });
                    $('#trakeing_link_datatable').on('click', '.editData', function(e) {
                        e.preventDefault()
                        $('#editModal').modal('show');
                        let id = $(this).attr('data-id');
                        let name = $(this).attr('data-name');
                        $('#editModal input[name=domain_name1]').val(name);
                        $('#editModal input[name=id]').val(id);
                    })



                    $('#trakeing_link_datatable').on('click', '.deleteData', function() {
                        let id = $(this).attr('data-id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You want to remove this Categery ",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, remove it!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "{{ route('admin.delete-domain') }}",
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
                    $('#btnUpdate').unbind().click(function() {
                        let data = $('#edit_form').serialize();
                        $.ajax({
                            url: "{{ route('admin.update-domain') }}",
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

                    //ADD DATA

                    $('#btnSave').unbind().click(function() {
                        let data = $('#add_form').serialize();
                        $.ajax({
                            url: "{{ route('admin.insert-domain') }}",
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
            </script>
        @endsection
