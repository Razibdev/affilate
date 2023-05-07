@extends('publisher.layout.dashboard')
@section('content')
    <div class="row g-3 mb-3">
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="card radius-10">
                            <div class="card-header">
                                <h5 class="mb-0">Smartlink</h5>
                            </div>
                            <div class="card-body">
                                <form id="Create_new_smartlink" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    {!! implode('', $errors->all('<div>:message</div>')) !!}

                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-lg-3">

                                            <input type="text" placeholder="Enter Name" name="name" class="form-control">
                                        </div>
                                        <div class="col-lg-3">

                                            <input type="text" placeholder="Enter Traffic Source" name="traffic_source"
                                                class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <select class="form-control" id="domain" name="domain">
                                            
                                                <option value="">Select Domain</option>
                                                @foreach ($domains as $q)
                                                    <option value="{{ $q->url }}"
                                                        {{ $site_settings->default_smartlink_domain == $q->url ? 'selected' : '' }}>
                                                        {{ $q->url }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <select class="form-control" id="category" name="category">
                                            
                                                <option value="">Select Category</option>
                                                @foreach ($sites as $q)
                                                    <option value="{{ $q->id }}">{{ $q->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class=" mb-5">




                                            </div>

                                            <div class="mt-3" style="display: none">
                                                <h4><b>Smart Link</b></h4>
                                                <?php $random = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                                                
                                                ?>

                                                <div class="alert alert-success" role="alert"
                                                    style="height: auto;width:100%;">
                                                    <span id="offer_name"><span
                                                            id="url">{{ @$domains[0]->url }}</span>/links?&pubid={{ Auth::guard('publisher')->id() }}&key={{ $random }}<span
                                                            id="sid"></span><span id="sid2"></span><span
                                                            id="sid3"></span><span id="sid4"></span><span
                                                            id="sid5"></span></span>
                                                </div>
                                                <input type="hidden" name="url" class="form-control" value="{{ @$domains[0]->url }}/links?&pubid={{ Auth::guard('publisher')->id() }}&key={{ $random }}">
                                                <input type="hidden" name="key" value="{{ $random }}"
                                                    class="form-control">
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3" id="save">Save
                                                Smartlink</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
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
            
function sid1() {
  var x = document.getElementById("myInput").value;
  document.getElementById("sid").innerHTML = "&sid=" + x;
}
function sid2() {
  var x2 = document.getElementById("myInput2").value;
  document.getElementById("sid2").innerHTML = "&sid2=" + x2;
}
  function sid3() {
  var x3 = document.getElementById("myInput3").value;
  document.getElementById("sid3").innerHTML = "&sid3=" + x3;
}
  function sid4() {
  var x4 = document.getElementById("myInput4").value;
  document.getElementById("sid4").innerHTML = "&sid4=" + x4;
}
  function sid5() {
  var x5 = document.getElementById("myInput5").value;
  document.getElementById("sid5").innerHTML = "&sid5=" + x5 ;


}
            $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
            $('#Create_new_smartlink').submit(function(e) {
                e.preventDefault();
                
                let data = $(this).serialize();
                $.ajax({
                    url: "{{ route('publisher.insert-smartlink') }}",
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


                        location.replace('{{ route('publisher.show-smartlink') }}');
                        }
                    },
                    error: function(xhr) {
                        var form=$('#Create_new_smartlink');
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
