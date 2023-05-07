        <div class="d-flex position-relative p-3 border-bottom mb-3 align-items-center">
                                    <div class="avatar avatar-2xl status-online me-3">
                                        <img class="rounded-circle" src="{{ $publisher->photourl }}" alt="" />

                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mb-0"><a class="text-decoration-none stretched-link text-700"
                                                href="{{ route('manager.get-detail', $publisher->id) }}">{{ $publisher->name }}</a>
                                        </h6>
                                        <p class="mb-0">Your Publisher {{ $publisher->name }}. Say hi to start the
                                            conversation
                                        </p>
                                    </div>
                                </div>
                                @php $data=date('Y');@endphp
                                @foreach ($message as $messag)
                                    @if ($data != date_format(date_create($messag->created_at), 'd'))
                                        @php $data=date_format(date_create($messag->created_at), 'd');@endphp
                                        <div class="text-center fs--2 text-500">
                                            <span>{{ date_format(date_create($messag->created_at), 'M d Y h:i a') }}</span>
                                        </div>
                                    @endif
                                    @if ($messag->receiver == 'affliate')
                                        <div class="d-flex p-3">
                                            <div class="avatar avatar-l me-2">
                                                <img class="rounded-circle" src="{{ $publisher->photourl }}"
                                                    alt="" />

                                            </div>
                                            <div class="flex-1">
                                                <div class="w-xxl-75">
                                                    <div class="hover-actions-trigger d-flex align-items-center">
                                                        <div class="chat-message bg-200 p-2 rounded-2">
                                                            <p> {!! $messag->message !!}</p>
                                                            @if (!empty($messag->photourl))
                                                                <a href="{{ $messag->photourl }}"><img
                                                                        src="{{ $messag->photourl }}" width="100"
                                                                        height="100"></a>
                                                            @endif
                                                        </div>
                                                        <ul
                                                            class="hover-actions position-relative list-inline mb-0 text-400 ms-2">


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


                                                        </ul>
                                                        <div
                                                            class="bg-primary text-white p-2 rounded-2 chat-message light">
                                                            <p class="mb-0">{!! $messag->message !!}</p>
                                                            @if (!empty($messag->photourl))
                                                                <a href="{{ $messag->photourl }}"><img
                                                                        src="{{ $messag->photourl }}" width="100"
                                                                        height="100"></a>
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