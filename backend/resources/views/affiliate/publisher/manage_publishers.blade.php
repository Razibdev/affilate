@extends('affiliate.layout.affiliate-dashboard')
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
                <div class="col-12 ">
                    <div class="card radius-10">
                        <div class="card-header">

                            <h4>Manage Publisher </h4>

                        </div>
                        <div class="card-body">


                            <div class="row">



                                <div class="col-lg-12 table-responsive">
                                    <table id="publisher_table"
                                        class="table table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Email</th>

                                                <th>Date Joined</th>
                                                <th>Total Click</th>
                                                <th>Total Leads</th>
                                                <th>Total Unique click</th>
                                                <th>Total vpn click</th>
                                                <th>Total Earning</th>



                                                <th>Status</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="showdata">

                                        </tbody>
                                    </table>


                                    <!-- ADD MODAL -->
                                    <form action="{{ url('admin/insert-publishers') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg " role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add Publisher </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">

                                                            <div class="col-lg-6 form-group">
                                                                <label> Publisher Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-6 form-group">
                                                                <label> Email</label>
                                                                <input type="email" name="email" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-6 form-group">
                                                                <label> Password</label>
                                                                <input type="text" name="password" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-6 form-group">
                                                                <label>Confirm password</label>
                                                                <input type="text" name="confirm_password"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-6 form-group">
                                                                <label> Address</label>
                                                                <input type="text" name="address" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6 form-group">
                                                                <label class="form-label">Countries</label>

                                                                <select class="form-control" name="countries"
                                                                    style="width: 100%">
                                                                    <option></option>

                                                                    @foreach ($country_list as $q)
                                                                        <option value="{{ $q->country_name }}">
                                                                            {{ $q->country_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6  form-group">
                                                                <label> City</label>
                                                                <input type="text" name="city" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6  form-group">
                                                                <label> Region</label>
                                                                <input type="text" name="region" class="form-control">
                                                            </div>

                                                            <div class="col-lg-6  form-group">
                                                                <label> Account Status</label>
                                                                <select type="text" name="status" id="status"
                                                                    class="form-control" required="">

                                                                    <option value="Inactive">Inactive</option>
                                                                    <option value="Active">Active</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6  form-group">
                                                                <label> Affliate Manager</label>
                                                                <select type="text" name="affliate_manager"
                                                                    class="form-control" required="">
                                                                    <option value="">Select Affliate Manager</option>

                                                                    @foreach ($affliate as $q)
                                                                        <option value="{{ $q->id }}">
                                                                            {{ $q->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-6  form-group">
                                                                <label> Photo</label>
                                                                <input type="file" name="photo"
                                                                    class="form-control">
                                                            </div>



                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End ADD MODAL -->



                                    <!-- Edit MODAL -->
                                    <form action="{{ url('admin/update-publishers') }}" method="post"
                                        enctype="multipart/form-data">
                                        <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Edit Publisher</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        @csrf
                                                        <input type="hidden" id="id" name="id">
                                                        <input type="hidden" id="hidden_img" name="hidden_img">
                                                        <div class="row">

                                                            <div class="col-lg-6 form-group">
                                                                <label> Publisher Name</label>
                                                                <input type="text" name="name1" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-6 form-group">
                                                                <label> Email</label>
                                                                <input type="email" name="email1" class="form-control"
                                                                    required="">
                                                            </div>

                                                            <div class="col-lg-6 form-group">
                                                                <label> Address</label>
                                                                <input type="text" name="address1"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-lg-6 form-group">
                                                                <label class="form-label">Countries</label>

                                                                <select class="form-control" name="countries1"
                                                                    style="width: 100%">
                                                                    <option></option>

                                                                    @foreach ($country_list as $q)
                                                                        <option value="{{ $q->country_name }}">
                                                                            {{ $q->country_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6  form-group">
                                                                <label> City</label>
                                                                <input type="text" name="city1"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-lg-6  form-group">
                                                                <label> Region</label>
                                                                <input type="text" name="region1"
                                                                    class="form-control">
                                                            </div>

                                                            <div class="col-lg-6  form-group">
                                                                <label> Account Status</label>
                                                                <select type="text" name="status1" id="status1"
                                                                    class="form-control" required="">

                                                                    <option value="Inactive">Inactive</option>
                                                                    <option value="Active">Active</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6  form-group">
                                                                <label> Affliate Manager</label>
                                                                <select type="text" name="affliate_manager1"
                                                                    class="form-control" required="">
                                                                    <option value="">Select Affliate Manager</option>

                                                                    @foreach ($affliate as $q)
                                                                        <option value="{{ $q->id }}">
                                                                            {{ $q->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-6  form-group">
                                                                <label> Photo</label>
                                                                <input type="file" name="photo1"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-lg-6  form-group">
                                                                <label> Previous Image</label>

                                                                <a id="publisher_image_anchor" target="_blank"><img
                                                                        width="70px" height="100px"
                                                                        id="publisher_image"></a>
                                                            </div>


                                                        </div>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
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
            </div>
        </div>
    </div>
@endsection


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

            var publisher_table = $('#publisher_table').DataTable({

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

                    url: "{{ route('manager.show-publisher') }}",

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
                        "data": "photo"
                    },

                    {
                        "data": "name"
                    },

                    {
                        "data": "email"
                    },
                    {
                        "data": "joindate"
                    },
                    {
                        "data": "totalclick"
                    },
                    {
                        "data": "totalleads"
                    },
                    {
                        "data": "totaluniqueclick"
                    },
                    {
                        "data": "vpn_clicks"
                    },
                    {
                        "data": "totalearning"
                    },


                    {
                        "data": "status"
                    },


                    {
                        "data": "action3"
                    }

                ],

                drawCallback: function(settings) {

                    $(document).find('[data-toggle="tooltip"]').tooltip();

                },

                initComplete: function(settings, json) {

                    // $(document).find('[data-toggle="tooltip"]').tooltip();

                }

            })
            $('#publisher_table').on('click', '.publisher_ban', function() {
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
                            url: "{{ route('manager.ban-publishers') }}",
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
        })
    </script>
@endsection
