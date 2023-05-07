@extends('affiliate.layout.affiliate-dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 ">
                    <div class="card radius-10">
                        <div class="card-header">

                            <h4>Mail Room </h4>

                        </div>
                        <div class="card-body">
                            <form id="mail_send_to_user" action="{{ url('manager/send-mail') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth::guard('affliate')->id() }}">
                                <div class="row mt-4">

                                    <div class="col-lg-12">
                                        <label class="form-label">Email Address</label>
                                        <input class="form-control" type="email" name="email" required="">

                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">Subject</label>

                                        <input class="form-control" type="" name="subject" required="">
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Email Body</label>

                                        <textarea id="summernote" rows=9 class="form-control" type="" name="message" required=""></textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Attechment (Optional)</label>
                                            <input type="file" name="attechment" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-success " style="margin-top: 33px">Send</button>


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
        $(function() {
            $('#summernote').summernote({
                height: 200
            });
            $('#mail_send_to_user').submit(function(e) {
                e.preventDefault();

            
                var form =$('#mail_send_to_user')[0];
                var data = new FormData(form);
                $.ajax({
                    url: "{{ route('manager.send-mail') }}",
                    type: 'POST',
                    dataType: 'JSON',
                        cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    success: function(result) {
                        $('.text-danger').remove();
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
                        var form = $('#Create_new_smartlink');
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
