 @extends('publisher.layout.dashboard')
 @section('content')
     <div class="card card-chat overflow-hidden">
         <div class="card-body d-flex p-0 h-100">
             <div class="chat-sidebar">
                 <div class="contacts-list scrollbar-overlay">
                     <div class="nav nav-tabs border-0 flex-column" role="tablist" aria-orientation="vertical">
                         @foreach ($affiliate_publisher as $affliate)
                             <div class="hover-actions-trigger chat-contact nav-item active"
                                 role="tab" id="{{ $affliate->id . $affliate->id }}" data-bs-toggle="tab"
                                 data-bs-target="#{{ $affliate->id }}" aria-controls="{{ $affliate->id }}"
                                 aria-selected="true">
                                 <div class="d-md-none d-lg-block">
                                     <div class="dropdown dropdown-active-trigger dropdown-chat">
                                         <button
                                             class="hover-actions btn btn-link btn-sm text-400 dropdown-caret-none dropdown-toggle end-0 fs-0 mt-4 me-1 z-index-1 pb-2 mb-n2"
                                             type="button" data-boundary="viewport" data-bs-toggle="dropdown"
                                             aria-haspopup="true" aria-expanded="false"><span class="fas fa-cog"
                                                 data-fa-transform="shrink-3 down-4"></span></button>
                                         <div class="dropdown-menu dropdown-menu-end border py-2 rounded-2"><a
                                                 class="dropdown-item" href="#!">Mute</a>
                                             <div class="dropdown-divider"></div><a class="dropdown-item"
                                                 href="#!">Archive</a><a class="dropdown-item text-danger"
                                                 href="#!">Delete</a>
                                             <div class="dropdown-divider"></div><a class="dropdown-item"
                                                 href="#!">Mark as Unread</a><a class="dropdown-item"
                                                 href="#!">Something's Wrong</a><a class="dropdown-item"
                                                 href="#!">Ignore Messsages</a><a class="dropdown-item"
                                                 href="#!">Block Messages</a>
                                         </div>
                                     </div>
                                 </div>
                                  <a href="{{route('publisher.chat',$affliate->id)}}" style="text-decoration: none;">
                                 <div class="d-flex p-3">
                                     <div class="avatar avatar-xl status-online">
                                         <img class="rounded-circle" src="{{ $affliate->photourl }}" alt="" />

                                     </div>
                                     <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                         <div class="d-flex justify-content-between">
                                             <h6 class="mb-0 chat-contact-title">{{ $affliate->name }}</h6><span
                                                 class="message-time fs--2">Tue</span>
                                         </div>
                                         <div class="min-w-0">
                                             <div class="chat-contact-content pe-3">{{ $affliate->name }}
                                                    @if(!empty($total_unread))
                                                {{$total_unread}} Messages are recieved
                                                    @endif
                                             </div>
                                             <div class="position-absolute bottom-0 end-0 hover-hide">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                      </a>
                             </div>
                    
                         @endforeach




                     </div>
                 </div>
                 <form class="contacts-search-wrapper">
                     <div class="form-group mb-0 position-relative d-md-none d-lg-block w-100 h-100">
                         <input class="form-control form-control-sm chat-contacts-search border-0 h-100" type="text"
                             placeholder="Search contacts ..." /><span class="fas fa-search contacts-search-icon"></span>
                     </div>
                     <button class="btn btn-sm btn-transparent d-none d-md-inline-block d-lg-none"><span
                             class="fas fa-search fs--1"></span></button>
                 </form>
             </div>
             <div class="tab-content card-chat-content">
                 @foreach ($affiliate_publisher as $affliate)
                     <div class="tab-pane card-chat-pane active" id="{{ $affliate->id }}"
                         role="tabpanel" aria-labelledby="{{ $affliate->id . $affliate->id }}">
                         <div class="chat-content-header">
                             <div class="row flex-between-center">
                                 <div class="col-6 col-sm-8 d-flex align-items-center"><a
                                         class="pe-3 text-700 d-md-none contacts-list-show" href="#!">
                                         <div class="fas fa-chevron-left"></div>
                                     </a>
                                     <div class="min-w-0">
                                         <h5 class="mb-0 text-truncate fs-0">{{ $affliate->name }}</h5>
                                         <div class="fs--2 text-400">Active On Chat
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-auto">
                                     <button class="btn btn-sm btn-falcon-primary me-2" type="button" data-index="0"
                                         data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><span
                                             class="fas fa-eye"></span></button>
                                     <button class="btn btn-sm btn-falcon-primary me-2" type="button" data-index="0"
                                         data-bs-toggle="tooltip" data-bs-placement="top" title="Start a Video Call"><span
                                             class="fas fa-video"></span></button>
                                     <button class="btn btn-sm btn-falcon-primary btn-info" type="button" data-index="0"
                                         data-bs-toggle="tooltip" data-bs-placement="top"
                                         title="Conversation Information"><span class="fas fa-info"></span></button>
                                 </div>
                             </div>
                         </div>
                         <div class="chat-content-body" style="display: inherit;">
                             <div class="conversation-info" data-index="0">
                                 <div class="h-100 overflow-auto scrollbar">
                                     <div class="d-flex position-relative align-items-center p-3 border-bottom">
                                         <div class="avatar avatar-xl status-online">
                                             <img class="rounded-circle"
                                                 src="{{ $affliate->photourl }}"
                                                 alt="" />

                                         </div>
                                         <div class="flex-1 ms-2 d-flex flex-between-center">
                                             <h6 class="mb-0"><a class="text-decoration-none stretched-link text-700"
                                                     href="">{{ $affliate->name }}</a></h6>
                                             <div class="dropdown z-index-1">
                                                 <button
                                                     class="btn btn-link btn-sm text-400 dropdown-toggle dropdown-caret-none me-n3"
                                                     type="button" id="profile-dropdown-0" data-bs-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false"><span
                                                         class="fas fa-cog"></span></button>
                                                
                                             </div>
                                         </div>
                                     </div>
                                    
                                    
                                 </div>
                             </div>
                             <div class="chat-content-scroll-area scrollbar">
                                 <div class="d-flex position-relative p-3 border-bottom mb-3 align-items-center">
                                     <div class="avatar avatar-2xl status-online me-3">
                                         <img class="rounded-circle" src="{{ $affliate->photourl }}" alt="" />

                                     </div>
                                     <div class="flex-1">
                                         <h6 class="mb-0"><a class="text-decoration-none stretched-link text-700"
                                                 href="javascript:void(0)">{{ $affliate->name }}</a></h6>
                                         <p class="mb-0">You Affliate Manager {{ $affliate->name }}. Say hi to start the
                                             conversation
                                         </p>
                                     </div>
                                 </div>
                                @php $data=date('Y');@endphp
                                 @foreach ($message as $messag)
                                 
                                 @if($data!=date_format(date_create($messag->created_at), 'd'))
                                 @php $data=date_format(date_create($messag->created_at), 'd');@endphp
                                  <div class="text-center fs--2 text-500"><span>{{ date_format(date_create($messag->created_at), 'M d Y h:i a') }}</span></div>
                                  @endif
                                     @if ($messag->sender == 'affliate')
                                         <div class="d-flex p-3">
                                             <div class="avatar avatar-l me-2">
                                                 <img class="rounded-circle" src="{{ $affliate->photourl }}"
                                                     alt="" />

                                             </div>
                                             <div class="flex-1">
                                                 <div class="w-xxl-75">
                                                     <div class="hover-actions-trigger d-flex align-items-center">
                                                         <div class="chat-message bg-200 p-2 rounded-2">
                                                            <p> {!! $messag->message !!}</p> 
                                                            @if(!empty($messag->photourl))
                                                            <a href="{{$messag->photourl}}" ><img src="{{$messag->photourl}}" width="100" height="100"></a>
                                                        @endif</div>
                                                         <ul
                                                             class="hover-actions position-relative list-inline mb-0 text-400 ms-2">
                                                             <li class="list-inline-item"><a class="chat-option"
                                                                     href="#!" data-bs-toggle="tooltip"
                                                                     data-bs-placement="top" title="Edit"><span
                                                                         class="fas fa-edit"></span></a></li>
                                                             <li class="list-inline-item"><a class="chat-option"
                                                                     href="#!" data-bs-toggle="tooltip"
                                                                     data-bs-placement="top" title="Remove"><span
                                                                         class="fas fa-trash-alt"></span></a></li>
                                                         </ul>
                                                     </div>
                                                     <div class="text-400 fs--2">
                                                         <span>{{ date_format(date_create($messag->created_at), ' H:i') }}</span>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     @else
                                         <div class="d-flex p-3">
                                             <div class="flex-1 d-flex justify-content-end">
                                                 <div class="w-100 w-xxl-75">
                                                     <div class="hover-actions-trigger d-flex flex-end-center">
                                                         <ul
                                                             class="hover-actions position-relative list-inline mb-0 text-400 me-2">
                                                            
                                                             <li class="list-inline-item"><a class="chat-option"
                                                                     href="#!" data-bs-toggle="tooltip"
                                                                     data-bs-placement="top" title="Edit"><span
                                                                         class="fas fa-edit"></span></a></li>
                                                             <li class="list-inline-item"><a class="chat-option"
                                                                     href="#!" data-bs-toggle="tooltip"
                                                                     data-bs-placement="top" title="Remove"><span
                                                                         class="fas fa-trash-alt"></span></a></li>
                                                         </ul>
                                                         <div
                                                             class="bg-primary text-white p-2 rounded-2 chat-message light">
                                                             <p class="mb-0">{!! $messag->message !!}</p>
                                                             @if(!empty($messag->photourl))
                                                            <a href="{{$messag->photourl}}" ><img src="{{$messag->photourl}}" width="100" height="100"></a>
                                                            @endif

                                                         </div>
                                                     </div>
                                                     <div class="text-400 fs--2 text-end">
                                                        {{ date_format(date_create($messag->created_at), ' h:i a') }}<span
                                                             class="fas fa-check ms-2 text-success"></span>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     @endif
                                 @endforeach


                             </div>
                         </div>
                     </div>
                        
                 @endforeach
                    <form class="chat-editor-area" id="send_message_to_affliate" enctype="multipart/form-data">
                        @csrf
                     <div class="emojiarea-editor outline-none scrollbar" contenteditable="true"></div>
                     <input class="d-none" name="file" type="file" id="chat-file-upload" />
                     <input class="d-none" name="affliate" type="hidden" value="affliate" id="chat-file-upload" />
                     <input class="d-none" name="message" type="hidden" value="" id="chat-message" />
                     <label class="chat-file-upload cursor-pointer" for="chat-file-upload"><span
                             class="fas fa-paperclip"></span></label>
                     <div class="btn btn-link emoji-icon" data-emoji-button="data-emoji-button"><span
                             class="far fa-laugh-beam"></span></div>
                     <button class="btn btn-sm btn-send" type="submit">Send</button>
                 </form>
            
             </div>
         </div>
     </div>
 @endsection('content')
@section('js')
<script type="text/javascript">
        $(function() {
        $('.emojiarea-editor').keyup(function(){
var msg=    $('.emojiarea-editor').text();
$('#chat-message').val(msg);
        });
    $('#chat-file-upload').change(function(e) {
                e.preventDefault();
                
                var form =$('#send_message_to_affliate')[0];
                var data = new FormData(form);
                $.ajax({
                    url: "{{ route('publisher.send_message_to_affliate') }}",
                            type: 'post',
                            dataType: 'JSON',
                            data: data,
                            cache:false,
                            contentType: false,
                            processData: false,
                    success: function(result) {
                        $('.loader').fadeOut();
                        // console.log(result);
                        if (!result.status) {
                            Swal.fire('Failed', result.message, 'error');

                        } else {

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

            });
            $('#send_message_to_affliate').submit(function(e) {
            e.preventDefault();
            let data =new FormData(this);
                        $.ajax({
                            url: "{{ route('publisher.send_message_to_affliate') }}",
                            type: 'post',
                            dataType: 'JSON',
                            data: data,
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(result) {
                                $('.loader').fadeOut();
                                // console.log(result);
                                if (!result.status) {
                                    Swal.fire('Failed', result.message, 'error');

                                } else {
                                

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
                
            });
        })
    </script>    
@endsection