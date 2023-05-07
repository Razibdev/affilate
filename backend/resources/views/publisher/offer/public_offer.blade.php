 @extends('publisher.layout.dashboard')
 @section('content')
     <link href="https://xbladecdn.b-cdn.net/cnew/site/css/bootstrap-slider.css" rel="stylesheet">
     <style type="text/css">
         [slider] {
             position: relative;
             height: 14px;
             border-radius: 10px;
             text-align: left;
             margin: 45px 0 10px 0;
         }

         .bootstrap-select {
             width: 100% !important;
         }

         [slider]>div {
             position: absolute;
             left: 13px;
             right: 15px;
             height: 14px;
         }

         [slider]>div>[inverse-left] {
             position: absolute;
             left: 0;
             height: 14px;
             border-radius: 10px;
             background-color: #CCC;
             margin: 0 7px;
         }

         [slider]>div>[inverse-right] {
             position: absolute;
             right: 0;
             height: 14px;
             border-radius: 10px;
             background-color: #CCC;
             margin: 0 7px;
         }

         [slider]>div>[range] {
             position: absolute;
             left: 0;
             height: 14px;
             border-radius: 14px;
             background-color: #1ABC9C;
         }

         [slider]>div>[thumb] {
             position: absolute;
             top: -7px;
             z-index: 2;
             height: 28px;
             width: 28px;
             text-align: left;
             margin-left: -11px;
             cursor: pointer;
             box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
             background-color: #FFF;
             border-radius: 50%;
             outline: none;
         }

         [slider]>input[type=range] {
             position: absolute;
             pointer-events: none;
             -webkit-appearance: none;
             z-index: 3;
             height: 14px;
             top: -2px;
             width: 100%;
             -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
             filter: alpha(opacity=0);
             -moz-opacity: 0;
             -khtml-opacity: 0;
             opacity: 0;
         }

         div[slider]>input[type=range]::-ms-track {
             -webkit-appearance: none;
             background: transparent;
             color: transparent;
         }

         div[slider]>input[type=range]::-moz-range-track {
             -moz-appearance: none;
             background: transparent;
             color: transparent;
         }

         div[slider]>input[type=range]:focus::-webkit-slider-runnable-track {
             background: transparent;
             border: transparent;
         }

         div[slider]>input[type=range]:focus {
             outline: none;
         }

         div[slider]>input[type=range]::-ms-thumb {
             pointer-events: all;
             width: 28px;
             height: 28px;
             border-radius: 0px;
             border: 0 none;
             background: red;
         }

         div[slider]>input[type=range]::-moz-range-thumb {
             pointer-events: all;
             width: 28px;
             height: 28px;
             border-radius: 0px;
             border: 0 none;
             background: red;
         }

         div[slider]>input[type=range]::-webkit-slider-thumb {
             pointer-events: all;
             width: 28px;
             height: 28px;
             border-radius: 0px;
             border: 0 none;
             background: red;
             -webkit-appearance: none;
         }

         div[slider]>input[type=range]::-ms-fill-lower {
             background: transparent;
             border: 0 none;
         }

         div[slider]>input[type=range]::-ms-fill-upper {
             background: transparent;
             border: 0 none;
         }

         div[slider]>input[type=range]::-ms-tooltip {
             display: none;
         }

         [slider]>div>[sign] {
             opacity: 1;
             position: absolute;
             margin-left: -11px;
             top: -39px;
             z-index: 3;
             background-color: #1ABC9C;
             color: #fff;
             width: 28px;
             height: 28px;
             border-radius: 28px;
             -webkit-border-radius: 28px;
             align-items: center;
             -webkit-justify-content: center;
             justify-content: center;
             text-align: center;
         }

         [slider]>div>[sign]:after {
             position: absolute;
             content: '';
             left: 0;
             border-radius: 16px;
             top: 19px;
             border-left: 14px solid transparent;
             border-right: 14px solid transparent;
             border-top-width: 16px;
             border-top-style: solid;
             border-top-color: #1ABC9C;
         }

         [slider]>div>[sign]>span {
             font-size: 12px;
             font-weight: 700;
             line-height: 28px;
         }

         [slider]:hover>div>[sign] {
             opacity: 1;
         }
     </style>

     <!--page-content-wrapper-->
     <div class="page-content-wrapper">
         <div class="page-content">
             <div class="row">
                 <div class="col-lg-12 ">
                     <div class="card radius-10">
                         <div class="card-header">
                             <h5 class="mb-0">Filter Public Offers</h5>
                         </div>
                         <div class="card-body">
                             <form action="{{ url('publisher/offer/search') }}" method="get">
                                 @csrf
                                 <div class="row">
                                     <div class="col-lg-12 mb-3">
                                         <label>Payout</label>
                                         <div slider id="slider-distance "
                                             style="margin: 0px!important;margin-bottom: 20px!important;">
                                             <div>
                                                 <div inverse-left style="width:70%;"></div>
                                                 <div inverse-right style="width:70%;"></div>
                                                 <div range style="left:30%;right:40%;"></div>
                                                 <span thumb style="left:30%;"></span>
                                                 <span thumb style="left:60%;"></span>
                                                 <div sign style="left:30%;">
                                                     $<span id="value">30</span>
                                                 </div>
                                                 <div sign style="left:60%;">
                                                     $<span id="value">60</span>
                                                 </div>
                                             </div>
                                             <input type="range" tabindex="0" value="30" max="100" min="0"
                                                 name="from_payout" step="1" oninput="
                      this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
                      var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
                      var children = this.parentNode.childNodes[1].childNodes;
                      children[1].style.width=value+'%';
                      children[5].style.left=value+'%';
                      children[7].style.left=value+'%';children[11].style.left=value+'%';
                      children[11].childNodes[1].innerHTML=this.value;" />

                                             <input type="range" tabindex="0" value="60" max="100" min="0" name="to_payout"
                                                 step="1" oninput="
                      this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
                      var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
                      var children = this.parentNode.childNodes[1].childNodes;
                      children[3].style.width=(100-value)+'%';
                      children[5].style.right=(100-value)+'%';
                      children[9].style.left=value+'%';children[13].style.left=value+'%';
                      children[13].childNodes[1].innerHTML=this.value;" />
                                         </div>
                                     </div>
                                     <div class="col-lg-4">
                                         <label class="form-label">Countries</label>

                                         <select class="js-example-basic-multiple" name="countries[]" multiple="multiple"
                                             style="width: 100%;">
                                             <option></option>
                                             @foreach ($country as $q)
                                                 <option value="{{ $q->country_name }}">{{ $q->country_name }}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                     <div class="col-lg-3">
                                         <label class="form-label">Name</label>
                                         <input type="" name="name" class="form-control" placeholder="Enter Name Keyword"
                                             id="name">
                                              <input type="hidden" name="page_type" class="form-control" placeholder="Enter Name Keyword"
                                             value="public_offer">
                                             <input type="hidden" name="offer_type" class="form-control" placeholder="Enter Name Keyword"
                                             value="public">
                                     </div>
                                     <div class="col-lg-2">
                                         <label class="form-label">Offer ID</label>
                                         <input type="" name="id" class="form-control" placeholder="Enter Offer ID"
                                             id="id">
                                     </div>

                                     <div class="col-lg-3">
                                         <label class="form-label">Targeting</label>

                                         <select class="selectpicker" name="ua_target[]" id="ua_target" multiple
                                             data-actions-box="true">

                                             <option value="Windows">Windows</option>
                                             <option value="Android">Android</option>
                                             <option value="Iphone">Iphone</option>
                                             <option value="Ipad">Ipad</option>
                                             <option value="Mac">Mac</option>

                                         </select>
                                     </div>


                                     <div class="col-lg-4">
                                         <label class="form-label">Category</label>
                                         <select name="category[]" class="selectpicker" multiple data-actions-box="true"
                                             style="width: 100%">
                                             @foreach ($category as $q)
                                                 <option value="{{ $q->id }}">{{ $q->category_name }}</option>
                                             @endforeach
                                         </select>
                                     </div>


                                     <div class="col-lg-3">
                                         <label class="form-label">Order</label>
                                         <select type="text" name="ascending" id="ascending" class="form-control">

                                             <option value="desc">Descending</option>
                                             <option value="asc">Ascending</option>
                                         </select>
                                     </div>
                                     <div class="col-lg-2 " style="margin-top: 28px">

                                         <button type="submit" class="btn btn-primary">Search</button>

                                     </div>


                                 </div>

                                 <input type="hidden" name="offer_type" value="public">
                             </form>
                         </div>

                     </div>

                     <div class="card radius-10">
                         <div class="card-header">
                             <h5 class="mb-0">View Public Offers</h5>
                         </div>
                         <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table table-bordered  table-sm table-striped w-100">
                                     <thead>
                                         <tr>

                                             <td>id</td>
                                             <td>Preview Image</td>
                                             <td>Name</td>
                                             <td>Category & Verticals</td>
                                             <td>Payout</td>
                                             <td>Allowed Devices</td>
                                             <td style="max-width:100px">Allowed Countries</td>
                                             <td>Allowed Browsers</td>
                                             <td>Action</td>
                                         </tr>
                                     </thead>
                                     <tbody id="showdata">
                                         @foreach ($offers as $offer)
                                             <tr>
                                                 <td>{{ $offer->id }}</td>
                                                 <td><a href="{{ asset('uploads/') }}/{{ $offer->preview_url }}"
                                                         target="_blank"><img
                                                             src="{{ asset('uploads/') }}/{{ $offer->preview_url }}"
                                                             width="100 " height="100" style="object-fit: contain;"></a>
                                                 </td>
                                                 <td>{{ $offer->offer_name }}</td>
                                                 <td>{{ $offer->category_name }}<br>{{ $offer->verticals }}</td>
                                                 <td>
                                                     @if ($offer->payout_type == 'revshare')
                                                         RevShare
                                                     @else
                                                         ${{ round(($offer->payout * $offer->payout_percentage) / 100, 2) }}
                                                     @endif
                                                 </td>
                                                 <td>
                                                     @php  $device=explode('|',$offer->ua_target); @endphp
                                                     @foreach ($device as $d)
                                                         @if ($d == 'Windows')
                                                             <i class="lni lni-windows" title="Windows"></i>
                                                         @elseif($d == 'Mac')
                                                             <i class="fadeIn animated bx bx-laptop" title="Mac"></i>
                                                         @elseif($d == 'Iphone')
                                                             <i class="fadeIn animated bx bx-mobile-alt" title="Iphone"></i>
                                                         @elseif($d == 'Ipad')
                                                             <i class="lni lni-tab" title="Ipad"></i>
                                                         @elseif($d == 'Android')
                                                             <i class="fadeIn animated bx bx-mobile" title="Android"></i>
                                                         @endif
                                                     @endforeach
                                                 </td>
                                                 <td style="max-width:100px;white-space: normal;">
                                                     <p>{{ $offer->countries }}</p>
                                                 </td>
                                                 <td>
                                                     @php  $browser=explode('|',$offer->browsers); @endphp
                                                     @foreach ($browser as $d)
                                                         @if ($d == 'OPERA MINI')
                                                             <i class="lni lni-opera" title="Opera"></i>
                                                         @elseif($d == 'Chrome')
                                                             <i class="fadeIn animated lni lni-chrome" title="Chrome"></i>
                                                         @elseif($d == 'Firefox')
                                                             <i class="fadeIn animated lni lni-firefox" title="Firefox"></i>
                                                         @elseif($d == 'Internet Explorer')
                                                             <i class="lni lni-dribbble" title="Internet Explorer"></i>
                                                         @elseif($d == 'Safari')
                                                             <i class="fadeIn animated lni lni-shortcode"
                                                                 title="Safari"></i>
                                                         @elseif($d == 'EDGE')
                                                             <i class="fadeIn animated lni lni-edge" title="Edge"></i>
                                                         @endif
                                                     @endforeach
                                                 </td>
                                                 <td><a class="btn btn-primary"
                                                         href="{{ url('publisher/offers-details') }}/{{ $offer->id }}"
                                                         target="_blank">Get Details</a></td>
                                             </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                                 <div class="d-flex justify-content-center">
                                     {!! $offers->links() !!}
                                 </div>
                             </div>

                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection('content')
 @section('js')
     <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
          crossorigin="anonymous"></script>
     <script src="https://xbladecdn.b-cdn.net/cnew/site/js/bootstrap-slider.js"></script>


     <script type="text/javascript">
         $(function() {

         });
     </script>
 @endsection
