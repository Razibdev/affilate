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
                   
                        
        <div class="col-lg-12">
  <div class="card"  >

                                <div class="card-header">
                                    <h3>View Message</h3>
                                </div>
                                    <div class="card-body">
                                        <b>From {{$message->sender}}</b>
                                        <p><b>Subject</b> : {{$message->subject}}</p>
                                        <p><b>Message </b>: {!!$message->message!!}</p>
                                     @if($message->screenshot!='')
                                     <a href="{{url('screenshot')}}/{{$message->screenshot}}" target="_blank"><img src="{{asset('screenshot')}}/{{$message->screenshot}}" class="image-responsive" width="100" height="100"> </a>
                                     @endif
                                    <p> <a href="{{url('admin/messages')}}/{{$message->id}}" class="btn btn-danger">Reply</a>
                                        <button class="btn btn-success" onclick=" window.history.back();">Go Back</button>
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
            $('#summernote').summernote({
                height: 150
            });

            @if (Session::has('success'))
                Swal.fire({
                    title: '{{ Session::get('success') }}',


                    confirmButtonText: 'Ok'
                })
            @endif

            var messge_table = $('#messge_table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
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
                        "data": "created_at"
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
