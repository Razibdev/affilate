@extends('publisher.layout.dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">


                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header">
                            <h3>View Message</h3>
                        </div>
                        <div class="card-body">
                            <b>From Support Team</b>
                            <p><b>Subject</b> : {{ $msg_data->subject }}</p>
                            <p><b>Message </b>: {!! $msg_data->message !!}</p>
                            @if ($msg_data->screenshot != '')
                                <a href="{{ url('screenshot') }}/{{ $msg_data->screenshot }}" target="_blank"><img
                                        src="{{ asset('screenshot') }}/{{ $msg_data->screenshot }}" class="image-responsive"
                                        width="100" height="100"> </a>
                            @endif
                            <p> <a href="{{ url('publisher/support') }}/{{ $msg_data->id }}" class="btn btn-danger">Reply</a>
                                <button class="btn btn-success" onclick=" window.history.back();">Go Back</button>
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
        
    </script>
@endsection
