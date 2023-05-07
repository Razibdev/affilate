@if(!empty($all_offer))
<div class="scrollbar list py-3" style="max-height: 24rem;">
                                            <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                                                Results Offers</h6>
                                                @foreach ($all_offer as $offer)
                                                    
                                                
                                                <a class="dropdown-item px-card py-2" href="{{route('manager.offers',$offer->id)}}">
                                                <div class="d-flex align-items-center">
                                                    <div class="file-thumbnail me-2"><img
                                                            class="border h-100 w-100 fit-cover rounded-3"
                                                            src="{{ asset('uploads') }}/{{ $offer->preview_url }}" alt="" />
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mb-0 title">{{ $offer->offer_name }}</h6>
                                                        <p class="fs--2 mb-0 d-flex"><span
                                                                class="fw-semi-bold">{{ $offer->status }}</span><span
                                                                class="fw-medium text-600 ms-2">{{ $offer->created_at }}</span></p>
                                                    </div>
                                                </div>
                                            </a>
                                            @endforeach
                                    

                                            <hr class="bg-200 dark__bg-900" />
                                        

                                        </div>
                                        @else
                                        <div class="text-center mt-n3">
                                            <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                                        </div>
                                        @endif