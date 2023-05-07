@extends('admin.layout.admin-dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>Edit Publisher</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/update-publishers') }}" method="post" id="updates_publisher"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                <input type="hidden" name="hidden_img" value="{{ $data->publisher_image }}">
                                <input type="hidden" name="hidden_nid" value="{{ $data->nid }}">
                                <input type="hidden" name="hidden_tax" value="{{ $data->tax_file }}">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label><b> Name</b></label>
                                        <input type="text" value="{{ $data->name }}" name="name" class="form-control">
                                    </div>
                                    <div class="col-lg-6   ">
                                        <label><b>Phone</b></label>
                                        <div class="form-group">
                                            <select class="form-control" name="phone_code"
                                                style="width: 30%;float: left;">
                                                @foreach ($country_list as $cuntry)
                                                    <option value="{{ $cuntry->phonecode }}"
                                                        {{ $cuntry->phonecode == $data->phone_code ? 'selected' : null }}>
                                                        {{ $cuntry->phonecode }}-{{ $cuntry->country_name }}</option>
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
                                        <input type="text" value="{{ $data->regions }}" name="regions"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label><b>City</b></label>
                                        <input type="text" value="{{ $data->city }}" name="city" class="form-control">
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

                                            @foreach ($Affliate as $Affliate)
                                                <option value="{{ $Affliate->id }}"
                                                    {{ $data->affliate_manager_id == $Affliate->id ? 'selected' : '' }}>
                                                    {{ $Affliate->name }}</option>
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
                                            @foreach ($country_list as $cuntry)
                                                <option value="{{ $cuntry->country_name }}"
                                                    {{ $data->country == $cuntry->country_name ? 'selected' : '' }}>
                                                    {{ $cuntry->country_name }}</option>
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
                                            <label><b>Payment terms</b></label>
                                            <select class="form-control"  value="{{ $data->payment_terms }}" name="payment_terms">
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
                                            
                                                @foreach ($site_category_list as $site)
                                                    <option value="{{ $site->site_category_name }}"
                                                        {{ $site->site_category_name == $data->category ? 'selected' : null }}>
                                                        {{ $site->site_category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-10  form-group">
                                        <label> Photo</label>
                                        <input type="file" name="photo1" class="form-control">
                                    </div>
                                    <div class="col-lg-2  form-group">

                                        <a id="publisher_image_anchor" target="_blank"><img width="70px" height="100px"
                                                id="publisher_image"
                                                src="{{ asset('uploads') }}/{{ $data->publisher_image }}"></a>
                                    </div>
                                        <div class="row my-4" id="showdata">
                                                        
                                                         @foreach ($payment as $p)
                                                             <div class="col-12 col-lg-6 mb-3">
                                                                 <div class="card shadow-none border mb-3 mb-md-0">
                                                                     <div class="card-body">
                                                                         <div class="media align-items-center">
                                                                             <div class="col-lg-5 text-center">
                                                                                 @if ($p->payment_type == 'Paypal')
                                                                                     <img src="{{ url('assets/img/paypal.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Skrill')
                                                                                     <img src="{{ url('assets/img/skrill.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Bitcoin')
                                                                                     <img src="{{ url('assets/img/bitcoin.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Payoneer')
                                                                                     <img src="{{ url('assets/img/payoneer.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Web Money')
                                                                                     <img src="{{ url('assets/img/webmoney.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Bank Wire')
                                                                                     <img src="{{ url('assets/img/bankwire.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @endif
                                                                             </div>
                                                                             <div class="media-body ml-2">

                                                                                 <h6 class="mb-0 ">
                                                                                     ....{{ substr($p->payment_details, strlen($p->payment_details) - 4) }}
                                                                                 </h6>
                                                                                 <p class="text-warning">
                                                                                     {{ $p->created_at }}</p>
                                                                                 <p class="text-primary">
                                                                                     {{ $p->is_primary == 1 ? 'Primary' : '' }}
                                                                                 </p>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                
                                                                 </div>
                                                             </div>
                                                         @endforeach

                                                    

                                                     </div>
                                    <div class="col-lg-12 mt-2">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
<script>
$(function() {
     
        @if (Session::has('success'))
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif
});
</script>
@endsection
