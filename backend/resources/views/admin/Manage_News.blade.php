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
                            <h4>Manage News/Announcements</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12 text-right mb-4 mt-2">
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#addModal">Add News/Annoucement</button>
                            </div>
                            <div class="col-lg-12">
                                <table id="news_datatable" class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <td>Serial</td>
                                            <td>Headline</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>


                                <!-- ADD MODAL -->

                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document"
                                        style="max-width: 500px">
                                        <div class="modal-content position-relative">
                                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                <button
                                                    class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                    <h5 class="modal-title">Add News/Annoucement</h5>
                                                </div>
                                                <div class="p-4 pb-0">
                                                    <form id="add_new_form">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-lg-12 form-group">
                                                                <label>Headline</label>
                                                                <input type="text" name="title" class="form-control">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label>Details</label>
                                                                <textarea type="text" name="description" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" id="btnsave">Add</button>
                                                <button class="btn btn-secondary" type="button"
                                                    data-bs-dismiss="modal">Close</button>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End ADD MODAL -->



                                <!-- Edit MODAL -->
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document"
                                        style="max-width: 500px">
                                        <div class="modal-content position-relative">
                                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                <button
                                                    class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                    <h5 class="modal-title">Edit News/Annoucement</h5>
                                                </div>
                                                <div class="p-4 pb-0">
                                                    <form id="edit_model">
                                                        @csrf
                                                        <label>News/Annoucement Name</label>
                                                        <input type="hidden" name="edit_id" id="id">
                                                        <div class="row">
                                                            <div class="col-lg-12 form-group">
                                                                <label>Headline</label>
                                                                <input type="text" name="edit_title" class="form-control">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label>Details</label>
                                                                <textarea type="text" name="edit_description" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="modal-footer"><button class="btn btn-primary" id="btnUpdate" type="button">Edit</button>
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
                    var news_datatable = $('#news_datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        scrollX: true,
                        ajax: "{{ route('admin.show-news') }}",
                        columns: [{
                                "data": "id"
                            },
                            {
                                "data": "title"
                            },
                            {
                                "data": "action",
                                "name": 'action',
                                "orderable": false,
                                "searchable": false
                            }
                        ],
                    });
                    $('#news_datatable').on('click', '.editData', function(e) {
                        e.preventDefault()
                        $('#editModal').modal('show');
                        let id = $(this).attr('data-id');
                        let title = $(this).attr('data-title');
                        let description = $(this).attr('data-description');
                        $('#editModal textarea[name=edit_description]').val(description);
                        $('#editModal input[name=edit_id]').val(id);
                        $('#editModal input[name=edit_title]').val(title);
                    })



                    $('#news_datatable').on('click', '.deleteData', function() {
                        let id = $(this).attr('data-id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You want to remove this Annoncement ",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, remove it!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "{{ route('admin.delete-news') }}",
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
                    $('#btnUpdate').unbind().click(function(e) {
                        e.preventDefault();
                        let data = $('#edit_model').serialize();
                        $.ajax({
                            url: "{{ route('admin.update-news') }}",
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

                    $('#btnsave').unbind().click(function() {
                        let data = $('#add_new_form').serialize();
                        $.ajax({
                            url: "{{ route('admin.insert-news') }}",
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
