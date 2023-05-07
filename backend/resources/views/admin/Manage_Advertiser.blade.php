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
                            <h4>Manage Advertisers</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-12 text-right  mt-2 mb-4">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                        data-bs-target="#addModal">Create New Advertiser</button>
                                </div>

                                <div class="col-lg-12  table-responsive">
                                    <table id="advtizer_datatable" class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td>AID</td>
                                                <td>Advertise Name</td>
                                                <td>Company Name</td>
                                                <td>Email</td>
                                                <td>Status</td>
                                                <td>Total Offer</td>

                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody >

                                        </tbody>
                                    </table>


                                    <!-- ADD MODAL -->
                                    <form id="add_form_data" action="{{ url('admin/insert-advertiser') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div id="addModal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content position-relative">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add Advertiser Request</h5>
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                            <button
                                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-lg-12 form-group">
                                                                <label> Advertiser ID</label>
                                                                <?php $qry = DB::table('advertisers')
                                                                    ->orderBy('id', 'desc')
                                                                    ->first(); ?>
                                                                <input type="text" class="form-control"
                                                                    value="{{ @$qry->id + 1 }}" disabled>
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Advertiser Name</label>
                                                                <input type="text" name="advertiser_name"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Company Name</label>
                                                                <input type="text" name="company_name"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Email</label>
                                                                <input type="text" name="email" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-12  form-group">
                                                                <label> Password</label>
                                                                <input type="text" name="password" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Here by</label>
                                                                <input type="text" name="hereby" placeholder="from Google"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label>Hash/ Clickid ID</label>
                                                                <input type="text" name="param1" placeholder="s2"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Publisher ID / Sub ID</label>
                                                                <input type="text" placeholder="s1" name="param2"
                                                                    class="form-control" required="">
                                                            </div>

                                                            <div class="col-lg-12  form-group">
                                                                <label> Photo</label>
                                                                <input type="file" name="photo" class="form-control">
                                                            </div>


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
                                    <form action="{{ url('admin/update-advertiser') }}" method="post"
                                        enctype="multipart/form-data">
                                        <div id="editModal" class="modal fade" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content position-relative">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Edit Advertiser</h5>
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">

                                                        @csrf

                                                        <div class="row">
                                                            <div class="col-lg-12 text-center form-group">
                                                            
<a id="publisher_image_anchor" class="" target="_blank"><img width="100" height="100"
                                                                        id="publisher_image"></a>
                                                                
                                                            </div>
                                                            <input type="hidden" name="id" id="id">
                                                            <input type="hidden" id="hidden_img" name="hidden_img">
                                                            <div class="col-lg-12 form-group">
                                                                <label> Advertiser Name</label>
                                                                <input type="text" name="advertiser_name1"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Company Name</label>
                                                                <input type="text" name="company_name1"
                                                                    class="form-control" required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Email</label>
                                                                <input type="text" name="email1" class="form-control"
                                                                    required="">
                                                            </div>

                                                            <div class="col-lg-12 form-group">
                                                                <label> Hereby</label>
                                                                <input type="text" name="hereby1" class="form-control"
                                                                    required="">
                                                            </div>

                                                            <div class="col-lg-12  form-group">
                                                                <label> Photo</label>
                                                                <input type="file" name="photo1" class="form-control">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Hash / Clickid</label>
                                                                <input type="text" name="param11" class="form-control"
                                                                    required="">
                                                            </div>
                                                            <div class="col-lg-12 form-group">
                                                                <label> Publisher ID / Sub ID</label>
                                                                <input type="text" name="param21" class="form-control"
                                                                    required="">
                                                            </div>

                                                            
                                                            <div class="col-lg-12  form-group">
                                                                <label> Status</label>
                                                                <select name="status1" class="form-control">
                                                                    <option value="Inactive">Inactive</option>
                                                                    <option value="Active">Active</option>
                                                                    <option value="Ban">Ban</option>
                                                                </select>
                                                            </div>
                                                        </div>


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
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif

             var advtizer_datatable = $('#advtizer_datatable').DataTable({

        "mark" : true,

        "order": [

            [0, "desc"]

        ],

        "columnDefs": [

            {

                "targets" : [0],

                "render": function ( data, type, row, meta ) {

                    return '#' +data;

                }

            },

            { 

                "responsivePriority" : 1, 

                "targets" : 0 

            },

            { 

                "responsivePriority" : 2, 

                "targets" : -1,

                "orderable" : false

            }

	    ],

        "processing": true,

        "serverSide": true,

        "ajax": {

            url: "{{route('admin.show-advertiser')}}",

            error: function(xhr) {

                session_error(xhr);

                // console.log(xhr.status);

            }

        },

        "columns": [

            { "data": "id" },

            { "data": "advertiser_name" },
            { "data": "company_name" },

            { "data": "email" },

            { "data": "status" },
            { "data": "totaloffers" },

            { "data": "action" }

        ],

        drawCallback : function(settings) { 

            $(document).find('[data-toggle="tooltip"]').tooltip();

        },

        initComplete: function(settings, json) {

            // $(document).find('[data-toggle="tooltip"]').tooltip();

        }

    })
                    
$(document).ready(function(){
$('#advtizer_datatable').on('click','.editData',function(e){
e.preventDefault();
let id=$(this).attr('data-id');

$.ajax({
	method:'get',
	data:{id:id},
	url:"{{ route('admin.edit-advertiser')}}",
	async:false,
	dataType:'json',
	success:function(res){
		 $('#editModal').modal('show');
 
 				$('input[name=id]').val(res.id);
				$('input[name=advertiser_name1]').val(res.advertiser_name);
				$('input[name=company_name1]').val(res.company_name);
				$('input[name=email1]').val(res.email);
	   		 
				$('input[name=hereby1]').val(res.hereby);
                $('input[name=param11]').val(res.param1);
                        $('input[name=param21]').val(res.param2);
			   $('select[name=status1]').val(res.status);
			 $('input[name=hidden_img]').val(res.advertiser_image);
 $('#publisher_image').attr('src','<?php echo asset('uploads/')?>/'+res.advertiser_image+'')
  $('#publisher_image_anchor').attr('href','<?php echo asset('uploads/')?>/'+res.advertiser_image+'')

		},



})
})
    $('#advtizer_datatable').on('click', '.advertiser_delete', function() {
                        let id = $(this).attr('data-id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You want to remove this Advertizer ",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, remove it!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "{{ route('admin.delete-advertiser') }}",
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



                    });
                </script>
            @endsection
