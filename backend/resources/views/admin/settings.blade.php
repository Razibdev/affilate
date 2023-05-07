@extends('admin.layout.admin-dashboard')

@section('content')
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 ">
                    <div class="card radius-10">
                        <div class="card-header">

                            <h4>Settings </h4>

                        </div>
                        <div class="card-body">
                            <form id="form2" action="{{ route('admin.change-password') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::guard('admin')->id() }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Change Password</h3>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">New Password</label>
                                        <input class="form-control" type="" name="password">

                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">Confirm Password</label>

                                        <input class="form-control" type="" name="confirm_password">
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-dark " style="margin-top: 28px">Change</button>
                                    </div>
                                </div>
                            </form>

                            <form action="{{ url('admin/change-details') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::guard('admin')->id() }}">
                                <input type="hidden" name="hidden_photo" value="{{ Auth::guard('admin')->user()->photo }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Update Your Details</h3>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Admin Name</label>
                                        <input class="form-control" type="input" name="name" value="{{ Auth::guard('admin')->user()->name }}">

                                    </div>
                                    <div class="col-lg-12 ">
                                        <label class="form-label">Admin Email</label>

                                        <input class="form-control" type="email" name="email" value="{{ Auth::guard('admin')->user()->email }}">
                                    </div>
                                    <div class="col-lg-9 ">
                                        <label class="form-label">Admin Image</label>

                                        <input class="form-control" type="file" name="photo" >
                                    </div>
                                    <div class="col-lg-3 mt-3">
                                        <img src="{{ asset('site_images') }}/{{ Auth::guard('admin')->user()->photo}}" height="100" width="100">
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-dark " style="margin-top: 28px">Update</button>


                                    </div>
                                </div>
                            </form>

                            <form action="{{ url('admin/update-settings') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::guard('admin')->id() }}">
                                <div class="row mt-5">
                                    <div class="col-lg-6">
                                        <h3>Network Information</h3>
                                    </div>

                                    <input type="hidden" name="hidden_logo" value="{{ $data->logo }}">
                                    <input type="hidden" name="hidden_icon" value="{{ $data->icon }}">
                                    <div class="col-lg-12">
                                        <label class="form-label">Auto Approve Account</label>

                                        <input class="form-" type="checkbox" value="1" name="auto_signup"
                                            {{ isset($data) ? ($data->auto_signup == 1 ? 'checked' : null) : null }}>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Minimum Withdraw Amount</label>

                                        <input class="form-control" type="number"
                                            value="{{ $data->minimum_withdraw_amount }}" name="minimum_withdraw_amount">
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Publisher Payout Percentage</label>

                                        <input class="form-control" type="number" value="{{ $data->payout_percentage }}"
                                            name="payout_percentage">
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Affliate Manager Payout Percentage</label>

                                        <input class="form-control" type="number"
                                            value="{{ $data->affliate_manager_salary_percentage }}"
                                            name="affliate_percentage">
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Default Affliate Manager</label>
                                        <select type="text" name="affliate_manager" class="form-control" required="">
                                            <option value="">Select Affliate Manager</option>

                                            @foreach ($affliates as $q)
                                                <option value="{{ $q->id }}"
                                                    {{ isset($data) ? ($data->default_affliate_manager == $q->id ? 'selected' : null) : null }}>
                                                    {{ $q->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!--  Updates 30_06 -->

                                    <div class="col-lg-12">
                                        <label class="form-label"> When Publishers will get Paid?</label>

                                        <select type="text" name="default_payment_terms" class="form-control"
                                            required="">
                                            <option @if ($data->default_payment_terms == 'net45') selected @endif value="net45">Every
                                                45 Days</option>
                                            <option @if ($data->default_payment_terms == 'net30') selected @endif value="net30">
                                                Monthly</option>
                                            <option @if ($data->default_payment_terms == 'net15') selected @endif value="net15">Every
                                                15 days</option>
                                            <option @if ($data->default_payment_terms == 'net7') selected @endif value="net7">
                                                Weekly</option>
                                        </select>

                                    </div>


                                    <!-- End -->

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">Logo (2000px X 699px)</label>

                                        <input class="form-control" type="file" name="logo">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <a href="{{ asset('site_images') }}/{{ $data->logo }}" target="_blank"><img
                                                src="{{ asset('site_images') }}/{{ $data->logo }}" height="100"
                                                width="400px"></a>
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">Icon (85px X 85px)</label>

                                        <input class="form-control" type="file" name="icon">
                                    </div>



                                    <div class="col-lg-6 mt-2">
                                        <a href="{{ asset('site_images') }}/{{ $data->icon }}" target="_blank"><img
                                                src="{{ asset('site_images') }}/{{ $data->icon }}" width="100"
                                                height="100"></a>
                                    </div>
                                                       <div class="col-lg-6 mt-2">
                                        <label class="form-label">Network Name</label>
                                        <input class="form-control" type="text" value="{{ $data->site_name }}"
                                            name="site_name">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">Netowrk Description</label>
                                        <textarea class="form-control"
                                            name="site_description">{{ $data->site_description }}</textarea>
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">Block VPN?</label>
                                        <select name="vpn_check" class="form-control" required>
                                            <option>--select--</option>
                                            <option {{ $data->vpn_check == 'yes' ? 'selected' : '' }} value="yes">Yes
                                            </option>
                                            <option {{ $data->vpn_check == 'no' ? 'selected' : '' }} value="no">No
                                            </option>
                                        </select>
                                        <span style="color:maroon;">If yes. Then Visitor Can not go it offer link. if no then he can visit offer link using vpn but account will not ban.</span>
                                    </div>
                            
                                    <div class="col-lg-6 mt-2" >
                                        
                                        <label class="form-label">VPN API</label> 
                                        <span><a href="https://proxycheck.io/" target="_blank">Click Here</a> to get an API Key.</span>

                                        <input class="form-control" type="text" value="{{ $data->vpn_api }}"
                                            name="vpn_api" required>
                                        
                                    </div>
                                    <div class="col-lg-6 mt-2" >
                                
                                        <label class="form-label">VPN Click Limit Per Publisher</label>

                                        <input class="form-control" type="text" value="{{ $data->vpn_click_limit }}"
                                            name="vpn_click_limit" required>
                                    
                                    </div>
                                   



                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">SMTP Host</label>
                                        <input class="form-control" type="text" value="{{ $data->smtp_host }}"
                                            name="smtp_host">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">SMTP Port</label>
                                        <input class="form-control" type="text" value="{{ $data->smtp_port }}"
                                            name="smtp_port">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">SMTP User</label>
                                        <input class="form-control" type="text" value="{{ $data->smtp_user }}"
                                            name="smtp_user">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">SMTP Password</label>
                                        <input class="form-control" type="text" value="{{ $data->smtp_password }}"
                                            name="smtp_password">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">SMTP Encryption</label>
                                        <select name="smtp_enc" class="form-control">
                                            <option value="tls" {{ $data->smtp_enc == 'tls' ? 'selected' : '' }}>tls
                                            </option>
                                            <option value="ssl" {{ $data->smtp_enc == 'ssl' ? 'selected' : '' }}>ssl
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">Support Email Address / Form Email Address</label>
                                        <input class="form-control" type="text" value="{{ $data->from_email }}"
                                            name="from_email">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">From Name (Example: OfferFM Support)</label>
                                        <input class="form-control" type="text" value="{{ $data->from_name }}"
                                            name="from_name">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">Postback Password</label>
                                        <input class="form-control" type="text" value="{{ $data->postback_password }}"
                                            name="postback_password">
                                    </div>
                        


                                    

                                    <div class="col-lg-6">
                                        <button class="btn btn-success btn-block" style="margin-top: 33px">Update Setting</button>


                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {
            @if(Session::has('success'))
                Swal.fire({
                    text: '{{ Session::get('success')}}',
                    type: 'success',
                    confirmButtonText: 'Ok'
                })
            @endif

            @if(Session::has('error'))
                Swal.fire({
                    text: '{{Session::get('error')}}',
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
            @endif



            $('#form2').submit(function(e) {
                 e.preventDefault();

                 let data = $(this).serialize();
                 $.ajax({
                     url: "{{ route('admin.change-password') }}",
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
                         var form = $('#form2');
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
    </script>
@endsection
