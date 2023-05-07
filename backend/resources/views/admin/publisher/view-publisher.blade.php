@extends('admin.layout.admin-dashboard')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="card radius-10">
                        <div class="card-header">
                            <h4>View Publisher Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ UserSystemInfoHelper::publishar_image($data->publisher_image ) }}" class="rounded-circle" width="200">
                                </div>
                            </div>
                        
                                
                                <div class="row">
                                    <table class="table table-bordered table-striped text-center ">
                                        <thead>
                                            <tr>
                                                <th colspan="4">User Information</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $data->name }}</td>
                                                <th>Email</th>
                                                <td>{{ $data->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ (!empty($data->phone))?$data->phone:'---' }}</td>
                                                <th>status</th>
                                                <td>{{ (!empty($data->status))?$data->status:'---' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ (!empty($data->address))?$data->address:'---' }}</td>
                                                <th>City</th>
                                                <td>{{ $data->city }}</td>
                                            </tr>
                                            <tr>
                                                <th>Country</th>
                                                <td>{{ (!empty($data->country))?$data->country:'---' }}</td>
                                                <th>Zipcode</th>
                                                <td>{{ (!empty($data->postal_code))?$data->postal_code:'---' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Regions</th>
                                                <td>{{ (!empty($data->regions))?$data->regions:'--' }}</td>
                                                <th>Skype</th>
                                                <td>{{ (!empty($data->skype))?$data->skype:'---' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Account Type</th>
                                                <td>{{ (!empty($data->account_type))?$data->account_type:'---' }}</td>
                                                <th>Company Name</th>
                                                <td>{{ (!empty($data->company_name))?$data->company_name:'---' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Manager Name</th>
                                                <td>{{ (!empty($data->managername))?$data->managername:'---' }}</td>
                                                <th></th>
                                                <td></td>
                                            </tr>

                                            <tr><th colspan="4">Website Details</th>
                                            <tr>
                                                <th>Website Url</th>
                                                <td>{{ (!empty($data->website_url))?$data->website_url:'---' }}</td>
                                                <th>Category</th>
                                                <td>{{ (!empty($data->category))?$data->category:'---' }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <th>Monthly Traffic</th>
                                                <td>{{ (!empty($data->monthly_traffic))?$data->monthly_traffic:'---' }}</td>
                                                <th colspan="2"></th>
                                                
                                            </tr>
                                            <tr>
                                                <th colspan="4">
                                                    Additional Information
                                                </th>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    {{ (!empty($data->additional_information))?$data->additional_information:'---' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="4">
                                                    Hereby
                                                </th>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    {{ (!empty($data->hereby))?$data->hereby:'---' }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    
                                    

                                </div>
                                
                                                     <div class="row my-4" id="showdata">
                                                        
                                                         @foreach ($payment as $p)
                                                             <div class="col-12 col-lg-6 mb-3">
                                                                 <div class="card shadow-none border mb-3 mb-md-0">
                                                                     <div class="card-body">
                                                                         <div class="media align-items-center">
                                                                             <div class="col-lg-5 text-center">
                                                                                 @if ($p->payment_type == 'Paypal')
                                                                                     <img src="{{ url('assets/img/paypal.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Skrill')
                                                                                     <img src="{{ url('assets/img/skrill.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Bitcoin')
                                                                                     <img src="{{ url('assets/img/bitcoin.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Payoneer')
                                                                                     <img src="{{ url('assets/img/payoneer.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Web Money')
                                                                                     <img src="{{ url('assets/img/webmoney.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @elseif($p->payment_type == 'Bank Wire')
                                                                                     <img src="{{ url('assets/img/bankwire.png') }}"
                                                                                         height="150" width='100%' alt="">
                                                                                 @endif
                                                                             </div>
                                                                             <div class="media-body ml-2">

                                                                                 <h6 class="mb-0 ">
                                                                                     ....{{ substr($p->payment_details, strlen($p->payment_details) - 4) }}
                                                                                 </h6>
                                                                                 <p class="text-warning">
                                                                                     {{ $p->created_at }}</p>
                                                                                 <p class="text-primary">
                                                                                     {{ $p->is_primary == 1 ? 'Primary' : '' }}
                                                                                 </p>
                                                                             </div>
                                                                         </div>
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
    </div>
@endsection('content')
@section('js')


@endsection
