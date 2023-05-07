 @extends('publisher.layout.dashboard')
 @section('content')
     <div class="page-content-wrapper">
         <div class="page-content">
             <div class="row">


                 <div class="col-lg-12 ">

                     <div class="card">
                         <div class="card-header">
                             <h3> Do this before ading your domain </h3>
                         </div>
                         <div class="card-body">
                             <h6>
                                 Please copy Nameserver and update it to your domain. Here is a guide how to update domain
                                 name server <a
                                     href="https://www.namecheap.com/support/knowledgebase/article.aspx/767/10/how-to-change-dns-for-a-domain/"
                                     target="_blank">"Read Here"</a>
                             </h6>
                             <div class="col-lg-5 m-auto">
                                 <ul style="list-style:none;">
                                     <li>
                                         <code>ns1.hasprofit.com</code>
                                     </li>
                                     <li>
                                         <code>ns2.hasprofit.com</code>
                                     </li>
                                 </ul>
                             </div>
                             Note: It usually takes more than 30 miniutes to point the domain properly
                         </div>
                     </div>
                 </div>




                 <div class="col-lg-12 ">

                     <div class="card">
                         <div class="card-header">
                             <h3>Add Parking Domain </h3>
                         </div>
                         <div class="card-body">
                             <form id="add_parkinfg_domain" method="post">
                                 @csrf
                                 @if ($errors->any())
                                     <div class="alert alert-danger">
                                         <ul>
                                             @foreach ($errors->all() as $error)
                                                 <li>{{ $error }}</li>
                                             @endforeach
                                         </ul>

                                     </div>
                                 @endif

                                 <div class="col-lg-5 m-auto">
                                     <div class="form-group">
                                         <label>Enter Domain Name </label><br />
                                         <code>https://example.com</code>

                                         <input type="url" placeholder="Enter Url" name="url" class="form-control"
                                             required="">

                                     </div>
                                 </div>
                                 <div class="col-lg-5 m-auto">

                                     <div class="col-lg-12 text-center">
                                         <button class="btn btn-primary" id="btn_save">Save</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
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
                
                    $('#btn_save').unbind().click(function() {
                        let data = $('#add_parkinfg_domain').serialize();
                        $.ajax({
                            url: "{{ route('publisher.insert-site') }}",
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