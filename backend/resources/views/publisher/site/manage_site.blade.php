 @extends('publisher.layout.dashboard')
 @section('content')
     <div class="page-content-wrapper">
         <div class="page-content">
             <div class="row">
                 <div class="col-lg-12 ">
                     <div class="card radius-10">
                         <div class="card-header">
                             <h4>View Parking Domain</h4>
                         </div>
                         <div class="card-body">
                             <div class="col-lg-12 text-right mb-4 mt-2">
                                 <a class="btn btn-primary" href="{{ url('publisher/add-site') }}">Add Parking Domain</a>
                             </div>
                             <div class="col-lg-12">
                                 <table id="datatable" class="table table-striped table-bordered w-100">
                                     <thead>
                                         <tr>
                                             <td>ID</td>

                                             <td>Url</td>

                                             <td>Action</td>
                                         </tr>
                                     </thead>
                                     <tbody id="showdata">
                                         @foreach ($domains as $item)
                                             <tr>
                                                 <td>{{ $item->id }}</td>
                                                 <td>{{ $item->url }}</td>
                                                 <td>{!! $item->action !!}</td>
                                             <tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                                 <div class="d-flex justify-content-center">
                                     {!! $domains->links() !!}
                                 </div>

                                



                        

                                 <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                     <div class="modal-dialog modal-dialog-centered" role="document"
                                         style="max-width: 500px">
                                         <div class="modal-content position-relative">
                                             <div class="modal-header">
                                                 <h5 class="modal-title">Edit Site</h5>
                                                 <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                     <button
                                                         class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                         data-bs-dismiss="modal" aria-label="Close"></button>
                                                 </div>
                                             </div>
                                             <div class="modal-body">
                                                 <form id="edit_form">
                                                     @csrf

                                                     <input type="hidden" name="id" id="id">

                                                     {{-- <div class="form-group">
                                                         <label>Name</label>
                                                         <input type="" placeholder="Enter Name" name="name"
                                                             class="form-control" required="">
                                                     </div> --}}

                                                     <div class="form-group">
                                                         <label>Url</label>
                                                         <input type="url" placeholder="Enter Url" name="url"
                                                             class="form-control" required="">
                                                     </div>

                                                     {{-- <div class="form-group">
                                                         <label>Description</label>
                                                         <textarea type="" placeholder="Enter Description" name="description" class="form-control" required=""></textarea>
                                                     </div> --}}
                                                 </form>
                                             </div>
                                             <div class="modal-footer">
                                                 <button type="button" class="btn btn-primary"
                                                     id="btnUpdate">Update</button>
                                                 <button type="button" class="btn btn-secondary"
                                                     data-dismiss="modal">Close</button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- End Edit MODAL -->

                            
                                 <!-- End Delete MODAL -->
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         @endsection('content')
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

                     $('#datatable').on('click', '.editData', function(e) {
                         e.preventDefault()
                         $('#editModal').modal('show');
                         let id = $(this).attr('data-id');
                         let name = $(this).attr('data-url');
                         $('#editModal input[name=url]').val(name);
                         $('#editModal input[name=id]').val(id);
                     })



                     $('#datatable').on('click', '.deleteData', function() {
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
                                     url: "{{ route('publisher.delete-site') }}",
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
                             url: "{{ route('publisher.update-site') }}",
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
