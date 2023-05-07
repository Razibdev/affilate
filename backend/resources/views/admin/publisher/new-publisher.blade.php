@extends('admin.layout.admin-dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>Add New Publisher</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.insert-publishers') }}" method="POST" id="add_new_publisher" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-6 form-group">
                                        <label> Publisher Name</label>
                                        <input type="text" name="name" class="form-control" required="">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Email</label>
                                        <input type="email" name="email" class="form-control" required="">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Password</label>
                                        <input type="password" name="password" class="form-control" required="">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label>Confirm password</label>
                                        <input type="password" name="confirm_password" class="form-control" required="">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label> Address</label>
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                    <div class="col-lg-6 form-group">
                                        <label class="form-label">Countries</label>

                                        <select class="form-control" name="countries" style="width: 100%">
                                            <option></option>

                                            @foreach ($country_list as $site)
                                                <option value="{{ $site->country_name }}">{{ $site->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6  form-group">
                                        <label> City</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                    <div class="col-lg-6  form-group">
                                        <label> Region</label>
                                        <input type="text" name="region" class="form-control">
                                    </div>
                                    <div class="col-lg-6  form-group">
                                        <label> Payment term</label>
                                         <select class="form-control"   name="payment_terms">
                                                    <option  value="net45">Every
                                                45 Days</option>
                                            <option value="net30">
                                                Monthly</option>
                                            <option value="net15">Every
                                                15 days</option>
                                            <option value="netweekly">
                                                Weekly</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6  form-group">
                                        <label> Account Status</label>
                                        <select type="text" name="status" id="status" class="form-control" required="">

                                            <option value="Inactive">Inactive</option>
                                            <option value="Active">Active</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6  form-group">
                                        <label> Affliate Manager</label>
                                        <select type="text" name="affliate_manager" class="form-control" required="">
                                            <option value="">Select Affliate Manager</option>
                                            @foreach ($Affliate as $affiliate)
                                                <option value="{{ $affiliate->id }}">{{ $affiliate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6  form-group">
                                        <label> Photo</label>
                                        <input type="file" name="photo" class="form-control">
                                    </div>



                                </div>

                                <div class="col-lg-12  text-center m-4">
                                    <button type="submit" class="btn  btn-primary">Create</button>
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
            $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
            $('#add_new_publisher').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let data =  new FormData(this);
                $.ajax({
                    url: "{{ route('admin.insert-publishers') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: data,
                     cache:false,
            contentType: false,
            processData: false,
                    success: function(result) {
                        $('.text-danger').remove();
                        $('.loader').fadeOut();
                        // console.log(result);
                        if (!result.status) {
                            Swal.fire('Failed', result.message, 'error');

                        } else {
                            Swal.fire('Success', result.message, 'success');


                        location.replace('{{ route('admin.manage-publishers') }}');
                        }
                    },
                    error: function(xhr) {
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
        })
    </script>
@endsection
