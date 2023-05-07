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
                            <h4>Manage Affliate Manager</h4>
                        </div>
                        <div class="card-body">



                            <div class="row">


                                <div class="col-lg-12 text-right  mt-2 mb-4">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#addModal">Create New Affliate Manager</button>
                                </div>
                                <div class="col-lg-12 table-responsive ">
                                    <table id="affiliate_datatable"
                                        class="table table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>Id</td>
                                                <td> Name</td>

                                                <td>Email</td>
                                                <td>Phone</td>
                                                <td>Address</td>
                                                <td>Total Publisher</td>
                                                <td>Status</td>
                                                {{-- <td>Control Access</td> --}}
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>


                                    <!-- ADD MODAL -->
                                    <form action="{{ url('admin/insert-affliatemanager') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div id="addModal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content position-relative">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add Affliate Manager </h5>
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                            <button
                                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">

                                                            <div class="col-lg-12 form-group">
                                                                <label> Affliate Manager Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Email</label>
                                                                <input type="email" name="email" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Password</label>
                                                                <input type="text" name="password" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label>Confirm password</label>
                                                                <input type="text" name="confirm_password"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-12  form-group">
                                                                <label> Phone</label>
                                                                <input type="text" name="skype" class="form-control">
                                                            </div>
                                                            <div class="col-lg-12  form-group">
                                                                <label> Photo</label>
                                                                <input type="file" name="photo" class="form-control">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Address</label>
                                                                <input type="text" name="address" class="form-control">
                                                            </div>
                                                            <div class="col-lg-12  form-group">
                                                                <label> Account Status</label>
                                                                <select type="text" name="status" id="status"
                                                                    class="form-control" required="">

                                                                    <option value="Inactive">Inactive</option>
                                                                    <option value="Active">Active</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-12  form-group">
                                                                <label>Payment Method</label>
                                                                <select type="text" name="payment_method"
                                                                    id="payment_method" class="form-control"
                                                                    required="">
                                                                    @foreach ($payment as $pay)
                                                                        <option value="{{ $pay->name }}">
                                                                            {{ $pay->name }}</option>
                                                                    @endforeach


                                                                </select>
                                                            </div>

                                                            {{-- <div class="col-lg-12  form-group">
                                                                <label> Control Access</label>
                                                                <select type="text" name="power_mode" id="power_mode"
                                                                    class="form-control" required="">

                                                                    <option value="0">General</option>
                                                                    <option value="1">Expert</option>
                                                                </select>
                                                            </div> --}}



                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button class="btn btn-secondary" type="button"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End ADD MODAL -->



                                    <!-- Edit MODAL -->
                                    <form action="{{ url('admin/update-affliatemanager') }}" method="post"
                                        enctype="multipart/form-data">
                                        <div id="editModal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content position-relative">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Edit Affliate Manager</h5>
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                                                        </div>
                                                    </div>
                                                    <div class="modal-body">

                                                        @csrf
                                                        <input type="hidden" id="id" name="id">
                                                        <input type="hidden" id="hidden_img" name="hidden_img">
                                                        <div class="row">
                                                            <div class="col-lg-12  form-group text-center">

                                                                <a id="publisher_image_anchor" target="_blank"><img
                                                                        width="100px" height="100px"
                                                                        id="publisher_image"></a>
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Affliate Manager Name</label>
                                                                <input type="text" name="name1" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Email</label>
                                                                <input type="email" name="email1" class="form-control"
                                                                    required="">
                                                            </div>


                                                            <div class="col-lg-12  form-group">
                                                                <label> Phone</label>
                                                                <input type="text" name="skype1"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-lg-12  form-group">
                                                                <label> Photo</label>
                                                                <input type="file" name="photo1"
                                                                    class="form-control">
                                                            </div>

                                                            <div class="col-lg-12 form-group">
                                                                <label> Address</label>
                                                                <input type="text" name="address1"
                                                                    class="form-control">
                                                            </div>

                                                            <div class="col-lg-12  form-group">
                                                                <label> Account Status</label>
                                                                <select type="text" name="status1" id="status1"
                                                                    class="form-control" required="">

                                                                    <option value="Inactive">Inactive</option>
                                                                    <option value="Active">Active</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-12  form-group">
                                                                <label>Payment Method</label>
                                                                <select type="text" name="payment_method"
                                                                    id="payment_method" class="form-control"
                                                                    required="">
                                                                    @foreach ($payment as $pay)
                                                                        <option value="{{ $pay->name }}">
                                                                            {{ $pay->name }}</option>
                                                                    @endforeach


                                                                </select>
                                                            </div>

                                                            {{-- <div class="col-lg-12  form-group">
                                                                <label> Control Access</label>
                                                                <select type="text" name="power_mode" id="power_mode"
                                                                    class="form-control" required="">

                                                                    <option value="0">General</option>
                                                                    <option value="1">Expert</option>
                                                                </select>
                                                            </div> --}}





                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Update</button>
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







                <!-- Delete MODAL -->


                <!-- End Delete MODAL -->

                <!-- Edit MODAL -->
                <form action="{{ url('admin/change-affliatemanager') }}" method="post" enctype="multipart/form-data">
                    <div id="passwordModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content position-relative">
                                <div class="modal-header">
                                    <h5 class="modal-title"> Change Affliate Manager Password</h5>
                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                                    </div>
                                </div>
                                <div class="modal-body">

                                    @csrf
                                    <input type="hidden" id="passwordid" name="password_id">

                                    <div class="row">

                                        <div class="col-lg-12 form-group">
                                            <label>New Password</label>
                                            <input type="text" name="password" class="form-control" required="">
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label> Confirm Password</label>
                                            <input type="text" name="confirm_password" class="form-control"
                                                required="">
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Change</button>
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
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
                            Swal.fire('Success', '{{ Session::get('success') }}', 'success');
                        @endif
                        @if (Session::has('error'))
                            Swal.fire('Error', '{{ Session::get('error') }}', 'error');
                        @endif

                        var affiliate_datatable = $('#affiliate_datatable').DataTable({

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

                                url: "{{ route('admin.show-affliatemanager') }}",

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
                                    "data": "skype"
                                },
                                {
                                    "data": "address"
                                },
                                {
                                    "data": "totalpublisher"
                                },
                                {
                                    "data": "status"
                                }
                                ,
                               
                                // {
                                //     "data": "power"
                                // },

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
                            $('#affiliate_datatable').on('click', '.changepassword', function(e) {
                                e.preventDefault();
                                let id = $(this).attr('data-id');
                                $('#passwordModal').modal('show');
                                $('input[name=password_id]').val(id);
                            });

                            $('#affiliate_datatable').on('click', '.editData', function(e) {
                                e.preventDefault();
                                let id = $(this).attr('data-id');

                                $.ajax({
                                    method: 'get',
                                    data: {
                                        id: id
                                    },
                                    url: "{{ route('admin.edit-affliatemanager') }}",
                                    async: false,
                                    dataType: 'json',
                                    success: function(res) {
                                        $('#editModal').modal('show');

                                        $('input[name=id]').val(res.id);
                                        $('input[name=name1]').val(res.name);
                                        $('input[name=skype1]').val(res.skype);
                                        $('input[name=email1]').val(res.email);
                                        $('input[name=power_mode]').val(res.power_mode);

                                        $('input[name=address1]').val(res.address);
                                        $('select[name=status1]').val(res.status);
                                        $('select[name=payment_method]').val(res.payment_method);
                                        $('input[name=hidden_img]').val(res.photo);
                                        $('#publisher_image').attr('src', '<?php echo asset('uploads/'); ?>/' +
                                            res.photo + '')
                                        $('#publisher_image_anchor').attr('href',
                                            '<?php echo asset('uploads/'); ?>/' + res.photo + '')

                                    },



                                })
                            })
                            $('#affiliate_datatable').on('click', '.affiliate_delete', function() {
                                let id = $(this).attr('data-id');
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You want to remove this Affiliate Manager ",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, remove it!'
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajax({
                                            url: "{{ route('admin.delete-affliatemanager') }}",
                                            type: 'GET',
                                            dataType: 'JSON',
                                            data: {
                                                id: id
                                            },
                                            success: function(result) {
                                                $('.loader').fadeOut();
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
                                                $('.loader').fadeOut();
                                                if (xhr.status == 422) {
                                                    $.each(xhr.responseJSON.errors,
                                                        function(k, v) {
                                                            form.find('[name="' + k +
                                                                '"]').after(
                                                                '<div class="text-danger">' +
                                                                v[
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



                    });
                </script>
            @endsection
