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
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Create New Message</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('manager/send-message') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" name="subject" class="form-control"
                                                value="{{ @$qry->subject }}" required="">
                                        </div>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea type="text" id="summernote" name="message" class="form-control" required=""></textarea>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Screenshot (Optional)</label>
                                            <input type="file" name="screenshot" class="form-control">
                                        </div>
                                    </div>



                                    <div class="col-lg-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                        <?php  if($reply!=''){
                            ?>
                                        <a class="btn btn-success" href="{{ url('admin/messages') }}">Go Back</a>
                                        <?php  }?>
                                    </div>

                                </div>
                            </form>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    @endsection

@section('js')
    <script type="text/javascript">
            $(function() {
     $('#summernote').summernote({height:200});
            });
         @if (Session::has('success'))
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif
    </script>
@endsection
