@extends('layouts.front_layout')

@section('content')
    @php $site_settings=UserSystemInfoHelper::site_settings();@endphp

       <section id="features" class="services-area pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="section-title text-center pb-40">
                        <div class="line m-auto"></div>
                        <h3 class="title">CPC, CPL and CPA Offers, <span> Comes with everything you need to get started!</span></h3>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 col-sm-8">
                    <div class="single-services text-center mt-30 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="services-icon">
                            <img class="shape" src="{{$site_settings->cdn_url}}home/images/services-shape.svg" alt="shape">
                            <img class="shape-1" src="{{$site_settings->cdn_url}}home/images/services-shape-1.svg" alt="shape">
                            <i class="lni lni-mouse"></i>
                        </div>
                        <div class="services-content mt-30">
                            <h4 class="services-title"><a href="#">CPC</a></h4>
                            <p class="text">Buy & sell clicks in a transparent CPC auction. Any vertical. All geos.</p>
                            
                        </div>
                    </div> <!-- single services -->
                </div>
                <div class="col-lg-4 col-md-7 col-sm-8">
                    <div class="single-services text-center mt-30 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                        <div class="services-icon">
                            <img class="shape" src="{{$site_settings->cdn_url}}home/images/services-shape.svg" alt="shape">
                            <img class="shape-1" src="{{$site_settings->cdn_url}}home/images/services-shape-2.svg" alt="shape">
                            <i class="lni lni-infinite"></i>
                        </div>
                        <div class="services-content mt-30">
                            <h4 class="services-title"><a href="#">CPL</a></h4>
                            <p class="text">CPL Offers Contains SOI or DOI based leads with high payout rate than others.</p>
                            
                        </div>
                    </div> <!-- single services -->
                </div>
                <div class="col-lg-4 col-md-7 col-sm-8">
                    <div class="single-services text-center mt-30 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">
                        <div class="services-icon">
                            <img class="shape" src="{{$site_settings->cdn_url}}home/images/services-shape.svg" alt="shape">
                            <img class="shape-1" src="{{$site_settings->cdn_url}}home/images/services-shape-3.svg" alt="shape">
                           <i class="lni-bolt-alt"></i>
                        </div>
                        <div class="services-content mt-30">
                            <h4 class="services-title"><a href="#">CPA</a></h4>
                            <p class="text">Our CPA Offeers based on Downloads, On Click follow, Registration and more.</p>
                           
                        </div>
                    </div> <!-- single services -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== SERVICES PART ENDS ======-->
    
    <!--====== ABOUT PART START ======-->
    
    
    
    <!--====== ABOUT PART ENDS ======-->
    
    <!--====== ABOUT PART START ======-->
    
    <section id="about" class="about-area pt-70">
        <div class="about-shape-2">
            <img src="{{$site_settings->cdn_url}}home/images/about-shape-2.svg" alt="shape">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-lg-last">
                    <div class="about-content mt-50 wow fadeInLeftBig" data-wow-duration="1s" data-wow-delay="0.5s">
                        <div class="section-title">
                            <div class="line"></div>
                            <h3 class="title">{{ config('app.name') }}  <span> with Essential Offers and Flexyable Payment</span></h3>
                        </div> <!-- section title -->
                        <p class="text">The Network {{ config('app.name') }} conains premium offers with felxyable Payments processing. Our system is automated payment processed system. Offers are in Hight Converting Rates with low authentic. {{ config('app.name') }} conatins Public, Private and Special Offers</p>
                        <a href="{{ config('app.url')}}/publisher" class="main-btn">Sign Up Here</a>
                    </div> <!-- about content -->
                </div>
                <div class="col-lg-6 order-lg-first">
                    <div class="about-image text-center mt-50 wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="0.5s">
                        <img src="{{$site_settings->cdn_url}}home/images/about2.svg" alt="about">
                    </div> <!-- about image -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>


    <!--====== ABOUT PART START ======-->
    
    <section class="about-area pt-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-content mt-50 wow fadeInLeftBig" data-wow-duration="1s" data-wow-delay="0.5s">
                        <div class="section-title">
                            <div class="line"></div>
                            <h3 class="title"><span>Crafted with</span> Smart links and Advance Report Based</h3>
                        </div> <!-- section title -->
                        <p class="text">{{ config('app.name') }} has a Great Feature with Smartlinks with Advance Reports. You can easily create an SmartLink for your Team Members. Also Advance reports for in it's statics.</p>
                        <a href="{{ config('app.url')}}/publisher" class="main-btn">Explore Now</a>
                    </div> <!-- about content -->
                </div>
                <div class="col-lg-6">
                    <div class="about-image text-center mt-50 wow fadeInRightBig" data-wow-duration="1s" data-wow-delay="0.5s">
                        <img src="{{$site_settings->cdn_url}}home/images/about3.svg" alt="about">
                    </div> <!-- about image -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
        <div class="about-shape-1">
            <img src="{{$site_settings->cdn_url}}home/images/about-shape-1.svg" alt="shape">
        </div>
    </section>
    
    <!--====== ABOUT PART ENDS ======-->

    
    <!--====== ABOUT PART ENDS ======-->
    
    <!--====== VIDEO COUNTER PART START ======-->
    
    <section id="facts" class="video-counter pt-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="video-content mt-50 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                        <img class="dots" src="{{$site_settings->cdn_url}}home/images/dots.svg" alt="dots">
                        <div class="video-wrapper">
                            <div class="video-image">
                                <img src="{{$site_settings->cdn_url}}home/images/video.png" alt="video">
                            </div>
                            <!--<div class="video-icon">-->
                            <!--    <a href="#" class="video-popup"><i class="lni-play"></i></a>-->
                            <!--</div>-->
                        </div> <!-- video wrapper -->
                    </div> <!-- video content -->
                </div>
                <div class="col-lg-6">
                    <div class="counter-wrapper mt-50 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.8s">
                        <div class="counter-content">
                            <div class="section-title">
                                <div class="line"></div>
                                <h3 class="title">Cool facts <span> this about {{ config('app.name') }}</span></h3>
                            </div> <!-- section title -->
                            <p class="text">This is the reports from the updates of {{ config('app.name') }} Database. </p>
                        </div> <!-- counter content -->
                        <div class="row no-gutters">
                            <div class="col-4">
                                <div class="single-counter counter-color-1 d-flex align-items-center justify-content-center">
                                    <div class="counter-items text-center">
                                        <span class="count"><span class="counter">7</span>K+</span>
                                        <p class="text">Network Offers</p>
                                    </div>
                                </div> <!-- single counter -->
                            </div>
                            <div class="col-4">
                                <div class="single-counter counter-color-2 d-flex align-items-center justify-content-center">
                                    <div class="counter-items text-center">
                                        <span class="count"><span class="counter">4</span>K+</span>
                                        <p class="text">Smartlinks Offers</p>
                                    </div>
                                </div> <!-- single counter -->
                            </div>
                            <div class="col-4">
                                <div class="single-counter counter-color-3 d-flex align-items-center justify-content-center">
                                    <div class="counter-items text-center">
                                        <span class="count"><span class="counter">42</span>K+</span>
                                        <p class="text">Publishers</p>
                                    </div>
                                </div> <!-- single counter -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- counter wrapper -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    

@endsection
