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
    <?php
    if ($reply != '') {
        $qry = DB::table('messages')
            ->where('id', $reply)
            ->first();
    } ?>
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Send New Message</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/send-message') }}" method="post" enctype="multipart/form-data">
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
                                            <label>Details</label>
                                            <textarea type="text" name="message" id="summernote" class="form-control" required=""></textarea>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Screenshot (Optional)</label>
                                            <input type="file" name="screenshot" class="form-control">
                                        </div>
                                    </div>

                                   

                                    <div class="col-lg-12">
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
                @if ($reply == '')
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Incoming Messages</h3>
                            </div>
                            <div class="card-body table-responsive ">
                                <table id="messge_table" class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <th>Message ID</th>
                                        <th>Sender</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Action</th>

                                    </thead>
                        
                                </table>

                            </div>
                        </div>
                    </div>
            </div>
            @endif
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
            $('#summernote').summernote({
                height: 150
            });

        @if (Session::has('success'))
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif

            var messge_table = $('#messge_table').DataTable({
                processing: true,
                serverSide: true,
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
                scrollX: true,
                ajax: "{{ route('admin.show-message') }}",
                columns: [{
                        "data": "id"
                    },
                    {
                        "data": "sender"
                    },
                    {
                        "data": "subject"
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "action",
                        "name": 'action',
                        "orderable": false,
                        "searchable": false
                    }
                ],
            });



        });
    </script>
@endsection
