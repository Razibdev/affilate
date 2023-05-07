@extends('publisher.layout.dashboard')
@section('content')
 <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="row">
                        <div class="col-lg-12 ">

                            <div class="card"  >
                                <div class="card-header">
<h3>Login Information</h3>
                                </div>
                                    <div class="card-body">
                                         
                                            <div class="table-responsive " >
                                        <table  class="table table-bordered table-striped" id="example">
                                            <thead>
                                                <th>Login Time</th>
                                                  <th>Browser</th>
                                                <th>Device</th>
                                               
                                                  <th>Country</th>
                                                <th>City</th>
                                                 <th>IP Address</th>
                                                   
                                                    <th>Active</th>

                                               

                                            </thead>
                                            <tbody>
                                                @foreach($qry as $q)
                                                <tr>
                                                    <td>{{$q->created_at}}</td>
                                                     <td>{{$q->device}}</td>
                                                      <td>{{$q->browser}}</td>
                                                       <td>{{$q->country}}</td>
                                                        <td>{{$q->city}}</td>
                                                         <td>{{$q->ip_address}}</td>
                                                         
                                                          <td>{{$q->is_active}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
         <div class="d-flex justify-content-center">
            {!! $qry->links() !!}
        </div>
                                        </div>
           
                                    
                                  </div>
                              </div>
          @endsection
          @section('js')
          @endsection