    <div class="nav nav-tabs border-0 flex-column" role="tablist" aria-orientation="vertical">
                        @foreach ($my_publisher as $publisher)
                            <div class="hover-actions-trigger chat-contact nav-item "
                                role="tab" id="{{ $publisher->id . $publisher->id }}" data-bs-toggle="tab"
                                data-bs-target="#{{ $publisher->id }}" aria-controls="{{ $publisher->id }}"
                                aria-selected="true">
                                <div class="d-md-none d-lg-block">
                                    <div class="dropdown dropdown-active-trigger dropdown-chat">
                                        <button
                                            class="hover-actions btn btn-link btn-sm text-400 dropdown-caret-none dropdown-toggle end-0 fs-0 mt-4 me-1 z-index-1 pb-2 mb-n2"
                                            type="button" data-boundary="viewport" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"><span class="fas fa-cog"
                                                data-fa-transform="shrink-3 down-4"></span></button>


                                    </div>
                                </div>
                                <a href="{{ route('manager.chat', $publisher->id) }}" style="text-decoration: none;">
                                    <div class="d-flex p-3">
                                        <div class="avatar avatar-xl status-online">
                                            <img class="rounded-circle" src="{{ $publisher->photourl }}" alt="" />

                                        </div>
                                        <div class="flex-1 chat-contact-body ms-2 d-md-none d-lg-block">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0 chat-contact-title">{{ $publisher->name }}</h6><span
                                                    class="message-time fs--2">Tue</span>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="chat-contact-content pe-3">{{ $publisher->name }}
                                                    @if (!empty($publisher->unread))
                                                        {{ $publisher->unread }} Messages are recieved
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