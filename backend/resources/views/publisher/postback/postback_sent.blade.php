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
                <div class="col-lg-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3>Postback Sent
                        </div>
                        <div class="card-body ">

                            <div class="table-responsive">
                                <table id="postback_log_recieve"
                                    class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Payout</th>

                                            <th>Offer ID</th>
                                            <th>Callback URL</th>

                                            <th>Status</th>

                                        </tr>
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
    <script>
        $(document).ready(function() {
            $(function() {
                var postback_log_recieve = $('#postback_log_recieve').DataTable({
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
                    

                    ajax: "{{ route('publisher.show-postback-log-sent') }}",
                    columns: [{
                            "data": "id"
                        },
                        {
                            "data": "date"
                        },
                        {
                            "data": "payout"
                        },
                        {
                            "data": "offer_id"
                        },
                        {
                            "data": "url"
                        },
                        {
                            "data": "status"
                        },




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
