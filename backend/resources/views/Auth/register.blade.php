@extends('layouts.app')

@section('content')
    <style type="text/css">


    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-9 col-lg-8 text-center p-0 mt-3 mb-2">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <h2><strong>Publisher Register</strong></h2>
                    <p>Fill all form field to go to next step</p>
                    <div class="row">
                        <div class="col-md-12 mx-0">
                            <form id="msform" method="POST" action="{{ route('publisher.register.submit') }}">
                                @csrf
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active" id="account">
                                        <div class="user_icon"><span class="fas fa-user me-2"><br></span></div>
                                        <strong>Account Information</strong>
                                    </li>
                                    <li id="personal">
                                        <div class="user_icon"><span class="fas fa-info-circle"><br></span></div>
                                        <strong>Additional Information</strong>
                                        
                                    </li>
                                    <li id="payment">
                                        <div class="user_icon"><span class="fab fa-google"><br></span></div>
                                        <strong>Website Information</strong>
                                    </li>
                                    <li id="confirm">
                                        <div class="user_icon"><span class="far fa-save"><br></span></div>
                                        <strong>Confirmation</strong>
                                    </li>
                                </ul>
                                <!-- fieldsets -->
                                <fieldset>
                                    <div class="form-card">
                                        {{-- <h2 class="fs-title">Account Information</h2> --}}
                                        <div class="col-lg-12 m-auto">
                                            <div class="form-group">
                                                <label><b>Select Account Type</b></label>
                                                <select class="form-control @error('account_type') is-invalid @enderror"
                                                    name="account_type" id="account_type">
                                                    <option value="">Select Account Type </option>
                                                    <option value="Individual">Individual</option>
                                                    <option value="Company">Company</option>
                                                </select>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 m-auto" id="account_type_hidden" style="visibility:hidden">
                                            <div class="form-group">

                                                <select class="form-control " name="publisher_type" id="publisher_type">

                                                    <option value="1">CPA & SMARTLINK NETWORK</option>
                                                    <option value="0">SMARTLINK NETWORK</option>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group" id="company_name" style="visibility:hidden">
                                                <label><b>Company Name</b></label>
                                                <input type="text"  placeholder="Enter Your Company Name"
                                                    class="form-control @error('company_name') is-invalid @enderror"
                                                    name="company_name">

                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" data-field="account_information" value="Next Step" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        {{-- <h2 class="fs-title">Personal Information</h2> --}}
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Full Name</b></label>
                                                <input type="text"  placeholder="Enter Your Full Name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name">

                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Email</b></label>
                                                <input type="text"  placeholder="Enter Your Email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email">

                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Password</b></label>
                                                <input type="text"  placeholder="Enter Password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Address</b></label>
                                                <input type="text"  placeholder="Enter Your Address"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address">

                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Country</b></label>
                                                <select class="form-control" name="country">



                                                    @foreach ($country_list as $q)
                                                        <option value="{{ $q->country_name }}">{{ $q->country_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>City</b></label>
                                                <input type="text"  placeholder="Enter Your City"
                                                    class="form-control @error('city') is-invalid @enderror" name="city">

                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Region</b></label>
                                                <input type="text"  placeholder="Enter Region"
                                                    class="form-control @error('region') is-invalid @enderror"
                                                    name="region">

                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Zip/Postal Code</b></label>
                                                <input type="text"  placeholder="Enter Zip/Postal Code"
                                                    class="form-control @error('zip') is-invalid @enderror" name="zip">

                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Skype</b></label>
                                                <input type="text"  placeholder="Enter Skype Name "
                                                    class="form-control @error('skype') is-invalid @enderror" name="skype">

                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  pb-5">
                                            <label><b>Phone</b></label>
                                            <div class="form-group">

                                                <select class="form-control" name="phone_code"
                                                    style="width: 20%;float: left;">

                                                    @foreach ($country_list as $q)
                                                        <option value="{{ $q->phonecode }}">+{{ $q->phonecode }}
                                                            ({{ $q->country_name }})
                                                        </option>
                                                    @endforeach



                                                </select>
                                                <input type="text"  placeholder="Enter Phone Number "
                                                    style="width: 80%;float: left"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone">

                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                    <input type="button" name="next" class="next action-button" data-field="addistional_information" value="Next Step" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        {{-- <h2 class="fs-title">Payment Information</h2> --}}
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Website Url</b></label>
                                                <input type="text"  placeholder="Enter Website Url "
                                                    class="form-control @error('website_url') is-invalid @enderror"
                                                    name="website_url">

                                            </div>
                                        </div>

                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Monthly Traffic</b></label>

                                                <select class="form-control @error('monthly_traffic') is-invalid @enderror"
                                                    name="monthly_traffic">
                                                    <option value="">Select Traffic</option>
                                                    <option value="Less than 1k"> Less than 1k</option>
                                                    <option value="1K to 5K">1K to 5K</option>
                                                    <option value="5K to 10K">5K to 10K</option>
                                                    <option value="10K to 50K">10K to 50K</option>
                                                    <option value="50K  to 100K">50K to 100K</option>
                                                    <option value="100K to 1M">100K to 1M</option>
                                                    <option value="More than 1 M">More than 1 M</option>



                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">
                                            <div class="form-group">
                                                <label><b>Site Category</b></label>
                                                <select name="category"
                                                    class="form-control @error('category') is-invalid @enderror">
                                                    <option value="">Select Category</option>
                                                    @foreach($site_category_list as $q)
                                                    <option value="{{ $q->site_category_name }}">
                                                        {{ $q->site_category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">

                                            <div class="form-group">
                                                <label><b>Describe how do you do promotions of CPA or CPL Offers</b></label>
                                                <textarea rows="6" name="additional_information" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-auto  ">

                                            <div class="form-group">
                                                <label><b>How did you hear about Us ?</b></label>
                                                <textarea rows="3" name="hereby" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                    <input type="button" name="make_payment" class="next action-button" data-field="website_information" value="Confirm" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        {{-- <h2 class="fs-title text-center">Success !</h2> --}}
                                        <div class="  ">
                                            <input type="checkbox" name="terms" checked="" value="1" readonly="true"><b
                                                style="font-size: 18px">

                                                By submitting this form, You agree to Our <a href="/privacy/">Privacy
                                                    Policy</a> and <a href="/terms/">Our Terms and Conditions</a></b>
                                            <br>

                                            <input type="checkbox" name="updates" checked="" value="1" readonly="true"><b
                                                style="font-size: 18px">
                                                Yes! Send me updates and Notificatios</b>
                                        </div>
                                    
                                    </div>
                                        <input type="button" name="previous" class="previous action-button-previous"
                                        value="Previous" />
                                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        // window.addEventListener('load', function() {
            $(document).ready(function() {
                var current_fs, next_fs, previous_fs; //fieldsets
                var opacity;

                $(".next").click(function() {
                    // alert('aaaaa');
                    var field= $(this).attr("data-field");
                validate_fileld(field).then(() =>  {
                    if(resp_status==true){
                            current_fs = $(this).parent();
                            next_fs = $(this).parent().next();

                            //Add Class Active
                            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                            //show the next fieldset
                            next_fs.show();
                            //hide the current fieldset with style
                            current_fs.animate({
                                opacity: 0
                            }, {
                                step: function(now) {
                                    // for making fielset appear animation
                                    opacity = 1 - now;

                                    current_fs.css({
                                        'display': 'none',
                                        'position': 'relative'
                                    });
                                    next_fs.css({
                                        'opacity': opacity
                                    });
                                },
                                duration: 600
                            });
                    }
                }).catch((error) => {
                    console.log(error)
                });
                // console.log(validate_status);
                //     if(validate_status==false){
                        
                //         return false;
                //     }else{
                //         alert("ndjhh");
                //     }
                
                
                });

                $(".previous").click(function() {

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //Remove class active
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();

                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now) {
                            // for making fielset appear animation
                            opacity = 1 - now;

                            current_fs.css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            previous_fs.css({
                                'opacity': opacity
                            });
                        },
                        duration: 600
                    });
                });
                var resp_status = false;
                async  function validate_fileld(field){
                    if(field=='account_information'){
                        var account_type=$("select[name=account_type]").val();
                        var publisher_type=$("select[name=publisher_type]").val();
                        var company_name=$("input[name=company_name]").val();
                    
                        var csrf=$("meta[name=csrf-token]").attr("content");
                        
                      await $.ajax({
                        url: "{{ route('publisher.validate_account_information') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        timeout: 3000,
                         headers: {
                                "X-CSRFToken":  csrf
                            },
                        data: {
                            "_token":csrf,
                            "account_type":account_type,
                            "publisher_type":publisher_type,
                            "company_name":company_name
                        },
                        success: function(result) {
                            $('.text-danger').remove();
                            $('.loader').fadeOut();
                            
                            if (!result.status) {
                             resp_status= false;
                            } else {
                                 Swal.fire('Account Information', result.message,'success');
                            resp_status =true;
                        
                            }
                        },
                        error: function(xhr) {
                            
                            $('.loader').fadeOut();
                            if (xhr.status == 422) {
                                var form=$('#msform');
                                $('.text-danger').remove();
                                $.each(xhr.responseJSON.errors, function(k, v) {
                                    form.find('[name="' + k + '"]').after(
                                        '<div class="text-danger text-end">' + v[0] +
                                        '</div>');
                                });
                                resp_status =false
                            } else if (xhr.status == 419) {
                            
                            }
                            // console.log(xhr);
                        }
                         
                    });
                    }else if(field=='addistional_information'){
                        var name=$("input[name=name]").val();
                        var email=$("input[name=email]").val();
                        var password=$("input[name=password]").val();
                        var address=$("input[name=address]").val();
                        var country=$("select[name=country]").val();
                        var phone_code=$("select[name=phone_code]").val();
                        var city=$("input[name=city]").val();
                        var region=$("input[name=region]").val();
                        var zip=$("input[name=zip]").val();
                        var skype=$("input[name=skype]").val();
                        var phone=$("input[name=phone]").val();
                    
                        var csrf=$("meta[name=csrf-token]").attr("content");
                        
                      await $.ajax({
                        url: "{{ route('publisher.validate_addistional_information') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        timeout: 3000,
                         headers: {
                                "X-CSRFToken":  csrf
                            },
                        data: {
                            "_token":csrf,
                            "name":name,
                            "email":email,
                            "address":address,
                            "country":country,
                            "password":password,
                            "phone_code":phone_code,
                            "city":city,
                            "region":region,
                            "zip":zip,
                            "skype":skype,
                            "phone":phone
                        },
                        success: function(result) {
                            $('.text-danger').remove();
                            $('.loader').fadeOut();
                            
                            if (!result.status) {
                             resp_status= false;
                            } else {
                                 Swal.fire('Account Information', result.message,'success');
                            resp_status =true;
                        
                            }
                        },
                        error: function(xhr) {
                            
                            $('.loader').fadeOut();
                            if (xhr.status == 422) {
                                var form=$('#msform');
                                $('.text-danger').remove();
                                $.each(xhr.responseJSON.errors, function(k, v) {
                                    form.find('[name="' + k + '"]').after(
                                        '<div class="text-danger text-end">' + v[0] +
                                        '</div>');
                                });
                                resp_status =false
                            } else if (xhr.status == 419) {
                            
                            }
                            // console.log(xhr);
                        }
                        });
                    }else if(field=='website_information'){
                        var website_url=$("input[name=website_url]").val();
                        var monthly_traffic=$("select[name=monthly_traffic]").val();
                        var category=$("select[name=category]").val();
                        var additional_information=$("textarea[name=additional_information]").val();
                        var hereby=$("textarea[name=hereby]").val();
                    
                        var csrf=$("meta[name=csrf-token]").attr("content");
                        
                      await $.ajax({
                        url: "{{ route('publisher.validate_website_information') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        timeout: 3000,
                         headers: {
                                "X-CSRFToken":  csrf
                            },
                        data: {
                            "_token":csrf,
                            "website_url":website_url,
                            "monthly_traffic":monthly_traffic,
                            "category":category,
                            "additional_information":additional_information,
                            "hereby":hereby
                        },
                        success: function(result) {
                            $('.text-danger').remove();
                            $('.loader').fadeOut();
                            
                            if (!result.status) {
                             resp_status= false;
                            } else {
                                 Swal.fire('Website Information', result.message,'success');
                            resp_status =true;
                        
                            }
                        },
                        error: function(xhr) {
                            
                            $('.loader').fadeOut();
                            if (xhr.status == 422) {
                                var form=$('#msform');
                                $('.text-danger').remove();
                                $.each(xhr.responseJSON.errors, function(k, v) {
                                    form.find('[name="' + k + '"]').after(
                                        '<div class="text-danger text-end">' + v[0] +
                                        '</div>');
                                });
                                resp_status =false
                            } else if (xhr.status == 419) {
                            
                            }
                            // console.log(xhr);
                        }
                        });
                    }else{
                        resp_status =false;
                    }
                    
                }


                $('#msform')[0].reset();
                $('#msform').submit(function(e) {
                    
                    $('.loader').fadeIn();
                    e.preventDefault();
                    var form = $(this);
                    form.prev('.alert').remove();
                    form.find('.text-danger').remove();
                    $.ajax({
                        url: "{{ route('publisher.register.submit') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: form.serialize(),
                        success: function(result) {
                            $('.loader').fadeOut();
                            // console.log(result);
                            if (!result.status) {
                                 Swal.fire('Failed',result.message,'error');
                                
                            } else {
                                 Swal.fire('Success', result.message,'success');
                                
                                form[0].reset();

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
                });

            });
            $('#account_type').change(function() {
                if ($('#account_type').val() == 'Company') {
                    $('#account_type_hidden').removeAttr('style', 'visibility:hidden');
                    $('#company_name').removeAttr('style', 'visibility:hidden');
                } else if ($('#account_type').val() == 'Individual') {
                    $('#account_type_hidden').removeAttr('style', 'visibility:hidden');
                    $('#company_name').attr('style', 'visibility:hidden');
                } else {
                    $('#company_name').attr('style', 'visibility:hidden');
                    $('#account_type_hidden').attr('style', 'visibility:hidden');
                }
            })
        // });
    </script>
@endsection
