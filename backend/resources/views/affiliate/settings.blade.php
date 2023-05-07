@extends('affiliate.layout.affiliate-dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 ">
                    <div class="card radius-10">
                        <div class="card-header">

                            <h4>Settings </h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ url('manager/change-password') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::guard('affliate')->id() }}">
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
                                        <button class="btn btn-dark " style="margin-top: 33px">Change</button>


                                    </div>
                                </div>
                            </form>
                            <form action="{{ url('manager/update-settings') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::guard('affliate')->id() }}">
                                <div class="row mt-5">
                                    <div class="col-lg-6">
                                        <h3>Edit Personal Information</h3>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Name</label>
                                        <input class="form-control" type="" value="{{ $data->name }}" name="name">

                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Email</label>

                                        <input class="form-control" type="" value="{{ $data->email }}" name="email">
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Skype</label>

                                        <input class="form-control" type="" value="{{ $data->skype }}" name="skype">
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Address</label>

                                        <input class="form-control" type="" value="{{ $data->address }}" name="address">
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Payment Method</label>

                                        <select class="form-control" type="" value="{{ $data->payment_method }}"
                                            name="payment_method">
                                            @foreach ($payment as $pay)
                                                <option value="{{$pay->name}}" {{ ($data->payment_method==$pay->name)?'selected':''}}>{{$pay->name}}</option>
                                            @endforeach
                                            

                                        </select>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Payment Details</label>

                                        <textarea class="form-control" type="" value="" name="payment_description">{{ $data->payment_description }}</textarea>

                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <label class="form-label">Photo</label>

                                        <input class="form-control" type="file" name="photo">
                                    </div>
                                    <div class="col-lg-6 mt-2">
                                        <input type="hidden" name="hidden_img" value="{{ $data->photo }}"></input>
                                        <a href="{{ asset('uploads') }}/{{ $data->photo }}" target="_blank"><img
                                                src="{{ asset('uploads') }}/{{ $data->photo }}" width="100"
                                                height="100"></a>
                                    </div>
                                    <div class="col-lg-6">
                                        <button class="btn btn-success btn-block" style="margin-top: 33px">Save
                                            Changes</button>


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
    <script type="text/javascript">
 @if (Session::has('success'))
            Swal.fire('Success','{{ Session::get('success') }}','success');
        @endif
        @if (Session::has('error'))
            Swal.fire('Error','{{ Session::get('error') }}','error');
                
            @endif
    </script>
@endsection
