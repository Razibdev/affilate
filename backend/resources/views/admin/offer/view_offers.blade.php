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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>View Offers</h4>
                        </div>
                        <div class="card-body">

                            <form method="get">
                
                                <div class="row">

                                    <div class="col-lg-12 text-right">
                                        <a href="{{ url('admin/add-offer') }}" class="btn btn-outline-primary mt-2">Add New
                                            Offer</a>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-label">Countries</label>

                                        <select class="js-example-basic-multiple" id="countries" name="countries"
                                            style="width: 100%">
                                            <option></option>
                                            @php $country=(isset($_GET['countries']))?$_GET['countries']:''; @endphp
                                            @foreach ($country_list as $q)
                                                <option value="{{ $q->country_name }}"
                                                    {{ $q->country_name == $country ? 'selected' : '' }}>
                                                    {{ $q->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">Name</label>
                                        <input type="" id="offer_name" name="name" class="form-control"
                                            value="{{ (isset($_GET['name']))?$_GET['name']:'' }}" placeholder="Offer Name" id="name">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">Offer ID</label>
                                        <input type="" id="offer_id" name="id" value="{{ (isset($_GET['id']))?$_GET['id']:'' }}"
                                            class="form-control" placeholder="Offer ID" id="id">
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-label">Targeting</label>

                                        <select class="form-control" name="ua_target" id="ua_target"
                                            data-actions-box="true">
                                                <option value="">Select Target Browsers</option>
                                            @php $ua_target=(isset($_GET[' ']))?$_GET['ua_target']:''; @endphp
                                            <option value="Windows" {{ $ua_target == 'Windows' ? 'selected' : '' }}>Windows
                                            </option>
                                            <option value="Android" {{ $ua_target == 'Android' ? 'selected' : '' }}>Android
                                            </option>
                                            <option value="Iphone" {{ $ua_target == 'Iphone' ? 'selected' : '' }}>Iphone
                                            </option>
                                            <option value="Ipad" {{ $ua_target == 'Ipad' ? 'selected' : '' }}>Ipad</option>
                                            <option value="Mac" {{ $ua_target == 'Mac' ? 'selected' : '' }}>Mac</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">Status</label>
                                        <select type="text" name="status" id="status" class="form-control">
                                            @php $status=(isset($_GET['status']))?$_GET['status']:''; @endphp
                                            <option value="">Select Status</option>
                                            <option value="Inactive" {{ $status == 'Inactive' ? 'selected' : '' }}>Inactive
                                            </option>
                                            <option value="Active" {{ $status == 'Active' ? 'selected' : '' }}>Active</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Traffic</label>
                                        <select type="text" name="traffic" id="traffic" class="form-control"
                                            data-actions-box="true">
                                                <option value="">Select Traffic</option>
                                            @php $traffic=(isset($_GET['traffic']))?$_GET['traffic']:''; @endphp
                                            
                                            <option value="smartlink" {{ $traffic == 'smartlink' ? 'selected' : '' }}>
                                                Smartlink</option>
                                            
                                           
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Offer Type</label>
                                        <select type="text" name="offer_type" id="offer_type" class="form-control">
                                            <option value="">Select Type</option>
                                            @php $offer_type=(isset($_GET['offer_type']))?$_GET['offer_type']:''; @endphp
                                            <option value="Public" {{ $offer_type == 'Public' ? 'selected' : '' }}>Public
                                            </option>
                                            <option value="Private" {{ $offer_type == 'Private' ? 'selected' : '' }}>Private
                                            </option>

                                        </select>
                                    </div>

                                    <div class="col-lg-3 " style="margin-top: 33px">

                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>

                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table id="offer_table" class="table table-bordered table-striped dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="thead thead-light">
                                            <tr>
                                                <th>OID</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Country</th>
                                                <th>Payout Type</th>
                                                <th>Payout</th>

                                                <th>Browsers</th>
                                                 <th>Devices</th>

                                                <th>Status</th>
                                                <th>Offer Type</th>
                                                <th>Clicks</th>
                                                <th>Conversion</th>
                                                <th>Smartlink</th>
                                                
                                                
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-dark">

                                        </tbody>
                                    </table>



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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        <?php $site = DB::table('site_settings')->first(); ?>
        $(function() {

            $(function() {
                $('.selectpicker').selectpicker();
            });


            $('#description').summernote({
                height: 150
            });
            $('#requirements').summernote({
                height: 150
            });
            $('.js-example-basic-multiple').select2();

            @if (Session::has('success'))
                Swal.fire({
                    title: '{{ Session::get('success') }}',


                    confirmButtonText: 'Ok'
                })
            @endif

            $('#payout').change(function() {
                if ($('#payout').val() == 'fixed') {
                    $('#payout_amount').removeAttr('disabled', 'true');
                    $('#payout_amount').val('');
                } else {


                    $('#payout_amount').attr('disabled', 'true');


                }
            })
            $('select[name=offer_type]').change(function(e) {
                if ($('select[name=offer_type]').val() == 'special') {
                    $('.divhide').removeClass('d-none');


                } else {

                    $('.divhide').addClass('d-none');

                }
            })
            var offer_table = $('#offer_table').DataTable({

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

                    url: "{{ route('admin.show-offers') }}",
                    "data": function(d) {
                        d.offer_name = $('#offer_name').val();
                        d.offer_id = $('#offer_id').val();
                        d.countries = $('#countries').val();
                        d.ua_target = $('#ua_target').val();
                        d.traffic = $('#traffic').val();
                        d.status = $('#status').val();
                        d.offer_type = $('#offer_type').val();
                    },
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
                        "data": "offer_name"
                    },
                    {
                        "data": "category.category_name"
                    },
                    {
                        "data": "countries"
                    },

                    {
                        "data": "payout_type"
                    },
                    {
                        "data": "payout"
                    },
                    {
                        "data": "browsers"
                    },
                    {
                        "data": "ua_target"
                    },

                    {
                        "data": "status"
                    },
                    {
                        "data": "offer_type"
                    },
                    {
                        "data": "clicks"
                    },
                    {
                        "data": "conversion"
                    },
                    
                    {
                        "data": "smartlinkstatus"
                    },
                

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
$('#offer_table').on('click', '.deleteData', function() {
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this Offer ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('admin.delete-offer') }}",
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
    </script>
@endsection
