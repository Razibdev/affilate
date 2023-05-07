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
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>Edit Publisher</h4>
                        </div>
                        <div class="card-body">



                            <!-- Edit MODAL -->
                            <form action="{{ url('manager/update-publishers') }}" method="post"
                                enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                <input type="hidden" name="hidden_img" value="{{ $data->publisher_image }}">
                                <input type="hidden" name="hidden_nid" value="{{ $data->nid }}">
                                <input type="hidden" name="hidden_tax" value="{{ $data->tax_file }}">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label><b> Name</b></label>
                                        <input type="text" value="{{ $data->name }}" name="name"
                                            class="form-control">
                                    </div>

                                    <div class="col-lg-6   ">
                                        <label><b>Phone</b></label>
                                        <div class="form-group">

                                            <select class="form-control" name="phone_code" style="width: 30%;float: left;">


                                                @foreach ($country_list as $q)
                                                    <option value="{{ $q->phonecode }}"
                                                        {{ $q->phonecode == $data->phone_code ? 'selected' : null }}>
                                                        {{ $q->phonecode }}-{{ $q->country_name }}</option>
                                                @endforeach



                                            </select>
                                            <input type="number" placeholder="Enter Phone Number "
                                                style="width: 70%;float: left" class="form-control"
                                                value="{{ $data->phone }}" name="phone">

                                        </div>
                                    </div>


                                    <div class="form-group col-lg-6">
                                        <label><b>Address</b></label>
                                        <input type="text" value="{{ $data->address }}" name="address"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label><b>Region</b></label>
                                        <input type="text" value="{{ $data->regions }}" name="region"
                                            class="form-control">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label><b>City</b></label>
                                        <input type="text" value="{{ $data->city }}" name="city"
                                            class="form-control">
                                    </div>
                                    <div class="col-lg-6  col-lg-6">
                                        <div class="form-group">
                                            <label><b>Zip/Postal Code</b></label>
                                            <input type="text" placeholder="Enter Zip/Postal Code" class="form-control "
                                                value="{{ $data->postal_code }}" name="zip">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label><b>Skype</b></label>
                                            <input type="text" placeholder="Enter Skype Name "
                                                class="form-control @error('skype') is-invalid @enderror"
                                                value="{{ $data->skype }}" name="skype">

                                        </div>
                                    </div>

                                    <div class="col-lg-6  form-group">
                                        <label> Account Status</label>
                                        <select type="text" name="status" id="status" class="form-control">

                                            <option value="Inactive" {{ $data->status == 'Inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="Active" {{ $data->status == 'Active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6  form-group">
                                        <label> Affliate Manager</label>
                                        <select type="text" name="affliate_manager" class="form-control">
                                            <option value="">Select Affliate Manager</option>
                                    
    @foreach($Affliate as $q)
                                            <option value="{{ $q->id }}"
                                                {{ $data->affliate_manager_id == $q->id ? 'selected' : '' }}>
                                                {{ $q->name }}</option>
@endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label> Email</label>
                                        <input type="email" name="email" value="{{ $data->email }}"
                                            class="form-control" required="">
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <label class="form-label">Countries</label>

                                        <select class="form-control" name="countries" style="width: 100%">
                                            <option></option>

                                            @foreach ($country_list as $q)
                                                <option value="{{ $q->country_name }}"
                                                    {{ $data->country == $q->country_name ? 'selected' : '' }}>
                                                    {{ $q->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6  ">
                                        <div class="form-group">
                                            <label><b>Website Url</b></label>
                                            <input type="text" placeholder="Enter Website Url " class="form-control "
                                                value="{{ $data->website_url }}" name="website_url">

                                        </div>
                                    </div>
                                    <div class="col-lg-6  ">
                                        <div class="form-group">
                                            <label><b>Payment term</b></label>
                                            <select  class="form-control " name="payment_terms">
                                                        <option @if ($data->payment_terms == 'net45') selected @endif value="net45">Every
                                                45 Days</option>
                                            <option @if ($data->payment_terms == 'net30') selected @endif value="net30">
                                                Monthly</option>
                                            <option @if ($data->payment_terms == 'net15') selected @endif value="net15">Every
                                                15 days</option>
                                            <option @if ($data->payment_terms == 'netweekly') selected @endif value="netweekly">
                                                Weekly</option>
                                        </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-6  ">
                                        <div class="form-group">
                                            <label><b>Monthly Traffic</b></label>

                                            <select class="form-control @error('monthly_traffic') is-invalid @enderror"
                                                value="{{ $data->monthly_traffic }}" name="monthly_traffic">
                                                <option value="">Select Traffic</option>
                                                <option value="Less than 1k"
                                                    {{ 'Less than 1k' == $data->monthly_traffic ? 'selected' : null }}>
                                                    Less
                                                    than 1k</option>
                                                <option value="1K to 5K"
                                                    {{ '1K to 5K' == $data->monthly_traffic ? 'selected' : null }}>1K to
                                                    5K
                                                </option>
                                                <option value="5K to 10K"
                                                    {{ '5K to 10K' == $data->monthly_traffic ? 'selected' : null }}>5K to
                                                    10K
                                                </option>
                                                <option value="10K to 50K"
                                                    {{ '10K to 50K' == $data->monthly_traffic ? 'selected' : null }}>10K
                                                    to 50K
                                                </option>
                                                <option value="50K  to 100K"
                                                    {{ '50K  to 100K ' == $data->monthly_traffic ? 'selected' : null }}>
                                                    50K to
                                                    100K</option>
                                                <option value="100K to 1M"
                                                    {{ '100K to 1M' == $data->monthly_traffic ? 'selected' : null }}>100K
                                                    to 1M
                                                </option>
                                                <option value="More than 1 M"
                                                    {{ 'More than 1 M' == $data->monthly_traffic ? 'selected' : null }}>
                                                    More
                                                    than 1 M</option>



                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6  ">
                                        <div class="form-group">
                                            <label><b>Site Category</b></label>
                                            <select name="category"
                                                class="form-control @error('category') is-invalid @enderror"
                                                value="{{ $data->category }}">
                                                <option value="">Select Category</option>
                                                                                            @foreach ($site_category_list as $q)
                                                    <option value="{{ $q->site_category_name }}"
                                                        {{ $q->site_category_name == $data->category ? 'selected' : null }}>
                                                        {{ $q->site_category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                   

                                    <div class="col-lg-10  form-group">
                                        <label> Photo</label>
                                        <input type="file" name="photo1" class="form-control">
                                    </div>
                                    <div class="col-lg-2  form-group">

                                        <a id="publisher_image_anchor" target="_blank"><img width="70px"
                                                height="100px" id="publisher_image"
                                                src="{{ UserSystemInfoHelper::publishar_image($data->publisher_image) }} "></a>
                                    </div>


                                </div>

                                <div class="col-lg-12 mt-2">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                        </div>



                        </form>
                        <!-- End Edit MODAL -->

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
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
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
                        "data": "created_at"
                    },


                    {
                        "data": "status"
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
        })
    </script>
@endsection
