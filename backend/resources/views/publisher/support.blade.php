@extends('publisher.layout.dashboard')
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Create New Message</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('publisher/send-message') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="hidden" name="affliate_id" value="{{ @$msg_data->affliate_id }}">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" name="subject" class="form-control"
                                                value="{{ @$msg_data->subject }}">
                                        </div>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea id="summernote" type="text" rows=10 name="message" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Screenshot (Optional)</label>
                                            <input type="file" name="screenshot" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 m-4 text-center">
                                        <button type="submit" class="btn btn-primary ">Send</button>

                                        @if ($reply != '')
                                            <a class="btn btn-success" href="{{ url('publisher/support') }}">Go Back</a>
                                        @endif
                                    </div>

                                </div>
                            </form>
                        </div>


                    </div>
                </div>

                @if ($reply == '')
                    <div class="col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3>View Messages</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="publisher_message"
                                    class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <th>Message ID</th>
                                        <th>Sender</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Action</th>

                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
            </div>




        </div>
    </div>
    @endif
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
    <script>
        $(document).ready(function() {
            $(function() {
       @if (Session::has('success'))
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif
                var publisher_message = $('#publisher_message').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
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

                            "responsivePriority": 1,

                            "targets": -1,

                            "orderable": false

                        }

                    ],
                    

                    ajax: "{{ route('publisher.show-message') }}",
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
                        "data": "actionpublisher",
                        "name": 'actionpublisher',
                        "orderable": false,
                        "searchable": false
                    }
                    ],
                });
                $('#post_back_save').submit(function(e) {
                    e.preventDefault();

                    let data = $(this).serialize();
                    $.ajax({
                        url: "{{ route('publisher.add-postback') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: data,
                        success: function(result) {
                            $('.text-danger').remove();
                            $('.loader').fadeOut();
                            // console.log(result);
                            if (!result.status) {
                                Swal.fire('Failed', result.message, 'error');

                            } else {
                                Swal.fire('Success', result.message, 'success');



                            }
                        },
                        error: function(xhr) {
                            var form = $('#post_back_save');
                            $('.loader').fadeOut();
                            $('.text-danger').remove();
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
        });
    </script>

@endsection