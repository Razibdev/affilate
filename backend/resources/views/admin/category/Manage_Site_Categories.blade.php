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
                            <h4>Manage Website Categories</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12 text-right mb-4 mt-2">
                                <button type="button" class="btn btn-primary m-3 float-end" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add New Category</button>
                            </div>
                            <div class="col-lg-12 table-responsive ">
                                <table id="site_category_table"
                                    class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="thead ">
                                        <tr class="text-center">
                                            <th>Serial</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>
                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                                    aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add New Category</h5>

                                            </div>
                                            <div class="modal-body">
                                                <form id="add_form">
                                                    @csrf
                                                    <label>Category Name</label>

                                                    <input type="text" name="Categories_name" class="form-control">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="btnSave">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Category</h5>

                                            </div>
                                            <div class="modal-body">
                                                <form id="edit_form">
                                                    @csrf
                                                    <label>Category Name</label>
                                                    <input type="hidden" name="id" id="id">
                                                    <input type="text" name="Categories_name" class="form-control">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" id="btnUpdate">Edit</button>

                                            </div>
                                        </div>
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
            var site_category_table = $('#site_category_table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                scrollX: true,
                ajax: "{{ route('admin.show-site-categories') }}",
                columns: [{
                        "data": "id"
                    },
                    {
                        "data": "site_category_name"
                    },
                    {
                        "data": "action",
                        "name": 'action',
                        "orderable": false,
                        "searchable": false
                    }
                ],
            });
            $('#site_category_table').on('click', '.editData', function(e) {
                e.preventDefault()
                $('#editModal').modal('show');
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');
                $('#editModal input[name=Categories_name]').val(name);
                $('#editModal input[name=id]').val(id);
            })


            $('#site_category_table').on('click', '.deleteData', function() {
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this Category ",
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
            $('#btnUpdate').unbind().click(function() {
                let data = $('#edit_form').serialize();
                $.ajax({
                    url: "{{ route('admin.update-site-categories') }}",
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
                    url: "{{ route('admin.insert-site-categories') }}",
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
