 @extends('publisher.layout.dashboard')
 @section('content')
     <div class="page-content-wrapper">
         <div class="page-content">
             <?php
             if ($publisher->address == '' || $publisher->city == '' || $publisher->skype == '' || $publisher->regions == '' || $publisher->postal_code == '' || $publisher->website_url == '' || $publisher->monthly_traffic == '' || $publisher->publisher_image == '' || $publisher->phone == '' || $publisher->payment_terms == '') {
                 echo "<div class='alert alert-danger'>Please Complete your Profile.</div>";
             } ?>
             @if ($errors->any())
                 <script>
                     alert('{!! implode('', $errors->all(':message')) !!}')
                 </script>
             @endif
             <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                 <div class="breadcrumb-title pr-3">User Profile</div>
                 <div class="pl-3">
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb mb-0 p-0">
                             <li class="breadcrumb-item"><a href="javaScript:;"><i class='bx bx-home-alt'></i></a>
                             </li>
                             <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                         </ol>
                     </nav>
                 </div>
                 <div class="ml-auto">

                 </div>
             </div>
             <!--end breadcrumb-->
             <div class="user-profile-page">
                 <div class="card">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-12 col-lg-5 border-right">

                                 <div class="d-md-flex align-items-center">
                                     <div class="mb-md-0 mr-md-4  mx-3">
                                         <form id="image_form" action="{{ url('publisher/upload-image') }}" method="post"
                                             enctype="multipart/form-data">
                                             @csrf
                                             <p><input type="file" name="file" id="file" style="display: none;"></p>
                                             <p><label for="file" style="cursor: pointer;">
                                                     @if (Auth::guard('publisher')->user()->publisher_image != null)
                                                         <img src="{{ asset('uploads') }}/{{ Auth::guard('publisher')->user()->publisher_image }}"
                                                             class="rounded-circle shadow" width="130" height="130" alt="">
                                                     @else
                                                         <img src="{{ $site_settings->cdn_url }}site/dashboard_assets/images/avatars/avatar-1.png"
                                                             class="rounded-circle shadow" width="130" height="130" alt="">
                                                     @endif
                                                 </label></p>
                                         </form>
                                     </div>
                                     <div class="ml-md-4 flex-grow-1">
                                         <div class="d-flex align-items-center mb-1">
                                             <h4 class="mb-0">{{ $publisher->name }}</h4>
                                         </div>
                                         <p class="mb-0 text-muted">{{ $publisher->email }}</p>
                                         <p class="text-primary"><i class='bx bx-buildings'></i><?php
                                         if ($publisher->total_earnings < 10) {
                                             echo 'Beginner';
                                         } elseif ($publisher->total_earnings >= 10 && $publisher->total_earnings < 35) {
                                             echo 'Expert';
                                         } elseif ($publisher->total_earnings >= 35 && $publisher->total_earnings < 100) {
                                             echo 'Genious';
                                         } elseif ($publisher->total_earnings >= 100 && $publisher->total_earnings < 1000) {
                                             echo 'Boss';
                                         } elseif ($publisher->total_earnings >= 1000 && $publisher->total_earnings < 15000) {
                                             echo 'Rock';
                                         } elseif ($publisher->total_earnings >= 15000) {
                                             echo 'Superman';
                                         }
                                         ?>
                                         </p>

                                     </div>
                                 </div>
                             </div>

                             <!--     <div class="col-12 col-lg-4 border-right">
                                        <table class="table table-sm table-borderless mt-md-0 mt-3">
                                          <tbody>
                                            <tr>
                                              <th>Availability:</th>
                                              <td> <span class="badge badge-success">available</span>
                                              </td>
                                            </tr>
                                            <tr>
                                              <th>Account Type:</th>
                                              <td>{{ $publisher->account_type }}</td>
                                            </tr>
                                            <tr>
                                              <th>Address:</th>
                                              <td>{{ $publisher->address }}</td>
                                            </tr>
                                            <tr>
                                              <th>Country:</th>
                                              <td>{{ $publisher->country }}</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                       </div> -->

                             {{-- <div class="col-lg-2 text-center m-auto">
                                 <div class="card radius-10 bg-voilet  text-center">
                                     <div class="card-body px-0">
                                         <div class="text-center">
                                             <div class="font-60 ">
                                             </div>
                                             <h4 class="mb-0 ">${{ round($publisher->balance, 2) }}</h4>
                                             <p class="mb-0 ">Current Balance</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-2 text-center m-auto">
                                 <div class="card radius-10 bg-voilet  text-center">
                                     <div class="card-body px-0">
                                         <div class="text-center">
                                             <div class="font-60 ">
                                             </div>
                                             <h4 class="mb-0 ">${{ round($publisher->total_earnings, 2) }}</h4>
                                             <p class="mb-0 ">Total Earnings</p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-lg-2 text-center m-auto">
                                 <div class="card radius-10 bg-voilet  text-center">
                                     <div class="card-body px-0">
                                         <div class="text-center">
                                             <div class="font-60 ">
                                             </div>
                                             <?php $rank=DB::select("SELECT (DENSE_RANK() OVER(ORDER BY sum(r.total_earnings) DESC )) as rank  ,r.id from publishers as r  group by r.id order by rank ");
                                            foreach($rank as $r){
                                            if($r->id==Auth::guard('publisher')->id()){?>
                                             <h4 class="mb-0 ">{{ $r->rank }}</h4>
                                             <?php }}?>
                                             <p class="mb-0 ">Ranking Number</p>
                                         </div>
                                     </div>
                                 </div>
                             </div> --}}

                         </div>
                         <!--end row-->
                     </div>
                 </div>
                 <div class="card">
                     <div class="card-body">
                         <ul class="nav nav-tabs">

                             <li class="nav-item"> <a class="nav-link active" data-toggle="tab"
                                     href="#Edt-Profile"><span class="p-tab-name">Edit Profile</span><i
                                         class='bx bx-message-edit font-24 d-sm-none'></i></a>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <div class="card">
                     <div class="card-body">
                         <div class="tab-content">

                             <div>
                                 <div class="card shadow-none border mb-0">
                                     <div class="card-body">
                                         <div class="form-body">

                                             <div class="row my-3">

                                                 <div class="col-12 col-lg-12 border-right">
                                                     <form id="form2" action="{{ url('publisher/change-password') }}"
                                                         method="post">
                                                         @csrf
                                                         <div class="row">
                                                             <div class="col-lg-6">
                                                                 <div class="form-group  ">
                                                                     <label><b> Password</b></label>
                                                                     <input type="password" name="password"
                                                                         class="form-control">
                                                                 </div>
                                                             </div>
                                                             <div class="col-lg-6">
                                                                 <div class="form-group  ">
                                                                     <label><b>Confirm Password</b></label>
                                                                     <input type="password" name="confirm_password"
                                                                         class="form-control">
                                                                 </div>
                                                             </div>
                                                         </div>
                                                         <div class="form-group  ">
                                                             <button type="submit" class="btn btn-primary my-3">Change
                                                                 Password</button>
                                                         </div>
                                                     </form>

                                                 </div>
                                             </div>
                                             <div class="row">

                                                 <div class="col-12 col-lg-12">
                                                     <form id="form3" action="{{ url('publisher/update-settings') }}"
                                                         method="post" enctype="multipart/form-data">

                                                         @csrf
                                                         <div class="form-row row">

                                                             <div class="form-group col-lg-6">
                                                                 <label><b> Name</b></label>
                                                                 <input type="text" value="{{ $publisher->name }}"
                                                                     name="name" class="form-control">
                                                             </div>

                                                             <div class="col-lg-6   ">
                                                                 <label><b>Phone</b></label>
                                                                 <div class="form-group">

                                                                     <select class="form-control" name="phone_code"
                                                                         style="width: 30%;float: left;">




                                                                         @foreach ($country_list as $q)
                                                                             <option value="{{ $q->phonecode }}"
                                                                                 {{ $q->phonecode == $publisher->phone_code ? 'selected' : null }}>
                                                                                 {{ $q->phonecode }}-{{ $q->country_name }}
                                                                             </option>
                                                                         @endforeach



                                                                     </select>
                                                                     <input type="number" placeholder="Enter Phone Number "
                                                                         style="width: 70%;float: left"
                                                                         class="form-control"
                                                                         value="{{ $publisher->phone }}" name="phone">

                                                                 </div>
                                                             </div>


                                                             <div class="form-group col-lg-6">
                                                                 <label><b>Address</b></label>
                                                                 <input type="text" value="{{ $publisher->address }}"
                                                                     name="address" class="form-control">
                                                             </div>
                                                             <div class="form-group col-lg-6">
                                                                 <label><b>Region</b></label>
                                                                 <input type="text" value="{{ $publisher->regions }}"
                                                                     name="region" class="form-control">
                                                             </div>

                                                             <div class="form-group col-lg-6">
                                                                 <label><b>City</b></label>
                                                                 <input type="text" value="{{ $publisher->city }}"
                                                                     name="city" class="form-control">
                                                             </div>
                                                             <div class="col-lg-6  col-lg-6">
                                                                 <div class="form-group">
                                                                     <label><b>Zip/Postal Code</b></label>
                                                                     <input type="text" placeholder="Enter Zip/Postal Code"
                                                                         class="form-control "
                                                                         value="{{ $publisher->postal_code }}"
                                                                         name="zip">

                                                                 </div>
                                                             </div>
                                                             <div class="col-lg-6">
                                                                 <div class="form-group">
                                                                     <label><b>Skype</b></label>
                                                                     <input type="text" placeholder="Enter Skype Name "
                                                                         class="form-control @error('skype') is-invalid @enderror"
                                                                         value="{{ $publisher->skype }}" name="skype">

                                                                 </div>
                                                             </div>
                                                             <div class="col-lg-6  ">
                                                                 <div class="form-group">
                                                                     <label><b>Website Url</b></label>
                                                                     <input type="text" placeholder="Enter Website Url "
                                                                         class="form-control "
                                                                         value="{{ $publisher->website_url }}"
                                                                         name="website_url">

                                                                 </div>
                                                             </div>


                                                             <div class="col-lg-6  ">
                                                                 <div class="form-group">
                                                                     <label><b>Monthly Traffic</b></label>

                                                                     <select
                                                                         class="form-control @error('monthly_traffic') is-invalid @enderror"
                                                                         value="{{ $publisher->monthly_traffic }}"
                                                                         name="monthly_traffic">
                                                                         <option value="">Select Traffic</option>
                                                                         <option value="Less than 1k"
                                                                             {{ 'Less than 1k' == $publisher->monthly_traffic ? 'selected' : null }}>
                                                                             Less than 1k</option>
                                                                         <option value="1K to 5K"
                                                                             {{ '1K to 5K' == $publisher->monthly_traffic ? 'selected' : null }}>
                                                                             1K to 5K</option>
                                                                         <option value="5K to 10K"
                                                                             {{ '5K to 10K' == $publisher->monthly_traffic ? 'selected' : null }}>
                                                                             5K to 10K</option>
                                                                         <option value="10K to 50K"
                                                                             {{ '10K to 50K' == $publisher->monthly_traffic ? 'selected' : null }}>
                                                                             10K to 50K</option>
                                                                         <option value="50K  to 100K"
                                                                             {{ '50K  to 100K ' == $publisher->monthly_traffic ? 'selected' : null }}>
                                                                             50K to 100K</option>
                                                                         <option value="100K to 1M"
                                                                             {{ '100K to 1M' == $publisher->monthly_traffic ? 'selected' : null }}>
                                                                             100K to 1M</option>
                                                                         <option value="More than 1 M"
                                                                             {{ 'More than 1 M' == $publisher->monthly_traffic ? 'selected' : null }}>
                                                                             More than 1 M</option>



                                                                     </select>
                                                                 </div>
                                                             </div>

                                                             <div class="col-lg-6  ">
                                                                 <div class="form-group">
                                                                     <label><b>Site Category</b></label>
                                                                     <select name="category"
                                                                         class="form-control @error('category') is-invalid @enderror"
                                                                         value="{{ $publisher->category }}">
                                                                         <option value="">Select Category</option>
                                                                         {{-- <option value="Adult"
                                                                             {{ 'Adult' == $publisher->category ? 'selected' : null }}>
                                                                             Adult</option>
                                                                         <option value="Not Adult"
                                                                             {{ 'Not Adult' == $publisher->category ? 'selected' : null }}>
                                                                             Not Adult</option> --}}

                                                                         @foreach ($site_category_list as $q)
                                                                             <option value="{{ $q->site_category_name }}"
                                                                                 {{ $q->site_category_name == $publisher->category ? 'selected' : null }}>
                                                                                 {{ $q->site_category_name }}</option>
                                                                         @endforeach
                                                                     </select>
                                                                 </div>
                                                             </div>
                                                           
                                                        
                                                             <div class="col-lg-12">
                                                                 <div class="form-group">
                                                                     <label><b>Payment Term</b></label>
                                                                     <input type="text" name="" disabled=""
                                                                         value="{{ $publisher->payment_terms }}"
                                                                         class="form-control">
                                                                 </div>
                                                             </div>
                                                             <div class="col-lg-12 my-4 ">
                                                                 <div class="form-group text-center">
                                                                     <button type="submit" class="btn btn-primary">Save
                                                                         Changes</button>
                                                                 </div>
                                                             </div>

                                                         </div>
                                                     </form>

                                                     <div class="row my-4" id="showdata">
                                                        
                                                         @foreach ($payment as $p)
                                                             <div class="col-12 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
                                                                 <div class="card shadow-none border mb-3 mb-md-0">
                                                                     <div class="card-body">
                                                                         <div class="media align-items-center">
                                                                             <div class="col-lg-5 text-center">
                                                                                {!! $p->paymentmethod->photo !!}
                                                                             </div>
                                                                             <div class="media-body ml-2">

                                                                                 <h6 class="mb-0 ">
                                                                                    {{$p->payment_details}}
                                                                                    
                                                                                 </h6>
                                                                                 <p class="text-warning">
                                                                                     {{ $p->created_at }}</p>
                                                                                 <p class="text-primary" style="position: absolute;">
                                                                                     {{ $p->is_primary == 1 ? 'Primary' : '' }}
                                                                                 </p>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                     <div class="card-footer bg-transparent ">
                                                                         <!-- <a href="javaScript:;" class="text-primary   ml-auto" data="{{ $p->id }}">View</a> -->
                                                                         <a href="javaScript:;"
                                                                             class="text-danger  removepayment"
                                                                             style="float:right"
                                                                             data="{{ $p->id }}">REMOVE</a>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         @endforeach

                                                         <div class="col-12 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3 text-center">

                                                             <div class="icon-box qp0pm4-0 pByfF border addPayment btn btn-primary"
                                                                 style="width: 96%" tabindex="375" data-bs-toggle="modal"
                                                                 data-bs-target="#addModal">
                                                                 <div class="icon-box-inner">
                                                                     <div class="icon-base"> <i
                                                                             class="fadeIn animated bx bx-plus"></i>
                                                                     </div>
                                                                     <div class="icon-box-name">Add Payment</div>

                                                                 </div>
                                                             </div>
                                                         </div>

                                                     </div>

                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>




     <!-- ADD MODAL -->

     <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content position-relative">
                 <div class="modal-header">
                     <h5 class="modal-title">Add Site</h5>

                     <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                         data-bs-dismiss="modal" aria-label="Close"></button>

                 </div>
                 <div class="modal-body">
                     <form id="add_form" method="post" action="{{ url('publisher/add-payment') }}">
                         @csrf
                         <label> Select Payment Method</label>

                         <select class="form-control" name="payment_type">
                             <option value="">Select</option>
                             @foreach ($paymentmethod as $pay)
                                 <option value="{{$pay->name}}">{{$pay->name}}</option>
                             @endforeach
                             
                         </select>
                         <label> Payment Details</label>
                         <textarea type="text" name="payment_details" class="form-control"></textarea>
                         <label class="mt-2">Make Primary Account</label>
                         <input type="checkbox" name="primary" value="1">
                     </form>
                 </div>
                 <div class="modal-footer">
                     <button type="submit" class="btn btn-primary" id="btnSave">Save</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>
 @endsection
 @section('js')
     <script>
         $(function() {
             $('#form2').submit(function(e) {
                 e.preventDefault();

                 let data = $(this).serialize();
                 $.ajax({
                     url: "{{ route('publisher.change-password') }}",
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
                         var form = $('#form3');
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
                 $('#btnSave').unbind().click(function() {
                let data = $('#add_form').serialize();
                $.ajax({
                    url: "{{ route('publisher.add-payment') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: data,
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
             $('#file').change(function() {

                 var formdata = new FormData();

                 formdata.append('file', this.files[0]);

                 var url = "{{ url('publisher/upload-image') }}";
                 $('#image_form').submit();

                 //         $.ajax({
                 //        type:'ajax',

                 //     type:'post',
                 //     data:formdata,

                 //           contentType:false,
                 //               cache:false,

                 //         processData:false,
                 //     url:url,

                 //     async:false,

                 //         success:function(res){
                 //    console.log(res);
                 //        // window.location.reload();
                 //         }

                 // });
             });
                         $('#showdata').on('click', '.removepayment', function() {
                let id = $(this).attr('data');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this Payment method ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('publisher.remove-payment') }}",
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
