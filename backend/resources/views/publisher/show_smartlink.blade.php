 @extends('publisher.layout.dashboard')
 @section('content')
     <style type="text/css">
         .lni-trash {
             font-size: 24px;
             padding: 10px;
             background: #FDC869;
             border: 1px solid;
             color: white;
             border-radius: 999px;
         }

         .reporticon {
             font-size: 24px !important;
             padding: 4px 10px !important;
             background: #65C1FA;
             border: 1px solid;
             color: white;
             border-radius: 999px;
         }

         .overlay {
             position: absolute;
             right: 0px;
             top: 0px;
         }
     </style>
     <div class="page-content-wrapper">
         <div class="page-content">
             <div class="row">
                 <div class="col-lg-12 ">
                     <div class="card radius-10">
                         <div class="card-header">
                             <h5 class="mb-0">View Smartlinks</h5>
                             <div class=" float-end " style="margin-top: 29px">
                                 <a href="{{ url('publisher/smartlink') }}" title="Add Smartlink" class="btn btn-primary">+
                                     Create New Smartlink </a>

                             </div>
                         </div>
                         <div class="card-body">
                             <form id="form1" method="post" action="{{ url('publisher/filter-smartlink') }}">

                                 <div class="row">

                                     <div class="col-lg-4">
                                         <div class="form-group">
                                             <label>Search by Name</label>
                                             <input type="" placeholder="Enter Smartlink Name" name="name"
                                                 class="form-control">
                                         </div>
                                     </div>

                                     <div class="col-lg-4">


                                         <div class="form-group">

                                             <label>Category</label>
                                             <select class="form-control" id="category" name="category">

                                                 <option value="">Select Category</option>
                                                 @foreach ($sites as $q)
                                                     <option value="{{ $q->id }}">{{ $q->category_name }}
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-lg-4">
                                         <label>From Date</label>
                                         <div class="form-group">
                                             <input type="date" name="from_date" class="form-control">
                                         </div>
                                     </div>
                                     <div class="col-lg-4">
                                         <label>To Date</label>
                                         <div class="form-group">
                                             <input type="date" name="to_date" class="form-control">
                                         </div>
                                     </div>
                                     <div class="col-lg-4">
                                         <button class="btn btn-success" type="btn" style="margin-top: 29px">Search</button>

                                     </div>
                                     <div class="col-lg-2">
                                         <textarea type="text" value="1" id="myInput" style="opacity:0">12</textarea>
                                     </div>

                                 </div>
                             </form>

                             <hr>


                             <div class="row" id="showdata">

                                 @foreach ($Smart_links as $q)
                                     <?php 
                                     $earn_qry = DB::select("SELECT (select count(id) from offer_process where  key_='$q->key_' and status='Approved') as leads, (select count(id) from offer_process where  key_='$q->key_' ) as clicks FROM `offer_process`  WHERE key_='$q->key_' group by key_"); 


                                     $crarecord=  DB::select("SELECT SUM(payout) as total from offer_process where publisher_id='$q->publisher_id' AND key_='$q->key_'");

                                    $cra=$crarecord[0];

                                     $crbrecord=  DB::select("SELECT SUM(payout) as total from offer_process where publisher_id='$q->publisher_id' AND key_='$q->key_' AND status = 'Approved'");
                                    
                                    $crb=$crbrecord[0];

                                    $cr=($cra->total/100)*$crb->total;
                                     
                                     
                                     
                                     ?>
                                     <div class="col-lg-4 my-4">

                                         <div class="card radius-10">
                                             <div class="card-body" style="position: relative;">
                                                 <div class="d-lg-flex align-items-center" style="position: relative;">
                                                     <div>
                                                         <h5 class="font-weight-bold mb-">{{ $q->name }}</h5>
                                                         <span> ID({{ $q->key_ }})</span>
                                                         <p style="font-weight:bold;" class="mb-0">
                                                             {{ $q->category_name }}</p>
                                                         <p style="font-weight:bold;">{{ $q->traffic_source }}</p>

                                                     </div>
                                                     <div class="overlay">
                                                         <a href="javascript:;" data="{{ $q->url }}"
                                                             onclick="copyFunction('{{ $q->url }}')"><svg
                                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                 stroke-width="2" stroke-linecap="round"
                                                                 stroke-linejoin="round"
                                                                 class="feather feather-copy text-primary">
                                                                 <rect x="9" y="9" width="13" height="13" rx="2" ry="2">
                                                                 </rect>
                                                                 <path
                                                                     d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1">
                                                                 </path>
                                                             </svg></a>
                                                     </div>
                                                 </div>
                                                 <h3 class="text-right">${{ round($q->earnings, 2) }}</h3>

                                                 <h5 class="text-right">ECPM :
                                                     ${{ ($q->earnings != 0 && $q->earnings != null && $q->leads != null) ? round(($q[0]->leads / $q->earnings) * 1000, 2) : 0.0 }}
                                                 </h5>


                                                 <h5 class="text-right">CR:
                                                     {{ $cr }}%
                                                 </h5>

                                                 <hr>
                                                 <p class=" mb-0">{{ $q->created_at }} <span
                                                         style="float:right"><b>Status : <?php if ($q->enabled == 0) {
                                                             echo "<span class='text-info'>Pending</span>";
                                                         } elseif ($q->enabled == 1) {
                                                             echo "<span class='text-success'>Approved</span>";
                                                         } else {
                                                             echo "<span class='text-danger'>Rejected</span>";
                                                         }
                                                         ?></b></span></p>
                                                         <br>
                                                 <ul class="list-group list-group-flush mb-0 ">

                                                     <li class="list-group-item d-flex justify-content-center align-items-center bg-transparent ml-3">
                                                         <form action="{{ url('publisher/reports') }}" method="post">
                                                            @csrf
                                                             <input type="hidden" name="from_date"
                                                                 value="{{ date('Y-m-d 00:00:00', strtotime('-7 days')) }}">
                                                             <input type="hidden" name="to_date"
                                                                 value="{{ date('Y-m-d 23:59:59') }}">
                                                             <input type="hidden" name="key" value="{{ $q->key_ }}">
                                                             <input type="hidden" name="type" value="smartlink">
                                                             <button type="submit" class="btn m-3 bg-success round"><i
                                                                     class="fas fa-file-medical text-white b "
                                                                     title="Reports"></i></button>
                                                         </form>
                                                         <a href="javascript:;" data="{{ $q->id }}"
                                                             class="deleteBtn btn m-3 bg-danger"><i class="far fa-trash-alt text-white"
                                                                 title="delete"></i></a>
                                                     </li>
                                                 </ul>
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     @endsection
     @section('js')
         <script>
             function copyFunction(e) {

                 document.getElementById("myInput").value = e;
                 var copyText = document.getElementById("myInput");
                 copyText.select();
                 copyText.setSelectionRange(0, 99999)
                 document.execCommand("copy");
                 Swal.fire({
                    title: 'Copyed',
                    text: "Your smartlink is copy successfully",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ok'
                })
             }


             $(function() {
                 $('#showdata').on('click', '.deleteBtn', function() {
                     var id = $(this).attr('data');
                   Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this Smartlink",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                         $.ajax({
                             method: 'get',
                             url: "{{ route('publisher.delete-smartlink') }}",
                             datatype:'json',
                             data: {
                                 id: id
                             },
                             
                             success: function(res) {

                                   if (result.status ==false) {
                                    Swal.fire('Failed', result.message, 'error');

                                } else {
                                    Swal.fire('Success', result.message, 'success');


                                    location.reload();
                                }
                             },
                             error: function() {
                            
                             }

                         })
                     }
                    });
                 })
             })

             function myFunction() {
                 var copyText = document.getElementById("myInput");
                 copyText.select();
                 copyText.setSelectionRange(0, 99999);
                 document.execCommand("copy");

                 var tooltip = document.getElementById("myTooltip");
                 tooltip.innerHTML = "Copied: " + copyText.value;
             }

             function outFunc() {
                 var tooltip = document.getElementById("myTooltip");
                 tooltip.innerHTML = "Copy to clipboard";
             }
         </script>
     @endsection
