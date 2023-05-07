@extends('affiliate.layout.affiliate-dashboard')
@section('content')
 <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row">
                   
                        
        <div class="col-lg-12">
  <div class="card"  >

                                <div class="card-header">
                                    <h3>View Message</h3>
                                </div>
                                    <div class="card-body">
                                        <b>From {{$msgdata->sender}}</b>
                                        <p><b>Subject</b> : {{$msgdata->subject}}</p>
                                        <p><b>Message </b>: {!!$msgdata->message!!}</p>
                                     @if($msgdata->screenshot!='')
                                     <a href="{{url('screenshot')}}/{{$msgdata->screenshot}}" target="_blank"><img src="{{asset('screenshot')}}/{{$msgdata->screenshot}}" class="image-responsive" width="100" height="100"> </a>
                                     @endif
                                    <p> <a href="{{url('manager/support')}}/{{$msgdata->id}}" class="btn btn-danger">Reply</a>
                                        <button class="btn btn-success" onclick=" window.history.back();">Go Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

@endsection
@section('js')
    
@endsection
