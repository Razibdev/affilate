@extends('affiliate.layout.affiliate-dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 ">
                    <div class="card radius-10">
                        <div class="card-header">

                            <h4>View Offer Details </h4>

                        </div>
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if (Session::has('danger'))
                                            <div class="alert alert-danger">
                                                {{ Session::get('danger') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-8">
                                        <label class="form-label">Offer ID</label>
                                        <input class="form-control" type="text" name="offer_id" id="offer_id">

                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-dark " id="search_box"
                                            style="margin-top: 30px">Search</button>


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
    <script type="text/javascript" src="{{ config('app.url') }}/public/public/vendors/datatables/jquery.mark.min.js">
    </script>
    <script type="text/javascript">
        $(function() {
            @if (Session::has('success'))
                Swal.fire({
                    title: '{{ Session::get('success') }}',


                    confirmButtonText: 'Ok'
                })
            @endif

            $('#search_box').click(function(e) {
                e.preventDefault();
                var id = $('#offer_id').val();
                $.ajax({
                    url: '{{ route('manager.offer') }}',
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        $('.loader').fadeOut();
                        // console.log(result);
                        if (!result.status) {


                        } else {

$('.page-content').empty();
$('.page-content').html(result.data);


                        }
                    },

                });
            });
        });
    </script>
@endsection
