@extends('layouts.app')
   @section('title') Payment system @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">        
         <div class="card">
            <h6 class="card-header bg-success text-center py-1 mx-1">Payment list</h6>
            <div class="card-header p-1">
               <ul class="nav nav-pills" id="tabMenu">
                  <li class="nav-item">
                     <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#unPaid">Unpaid ({{$payments->where('status', 0)->count()}})</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#paid">Paid</a>
                  </li>
               </ul>
            </div>
            <div class="card-body p-1">            
               <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="unPaid">
                     <table class="table table-bordered">
                        <thead class="bg-info">
                           <th>Sl</th>
                           <th>Room type</th>
                           <th>Payment Id</th>
                           <th>Patient</th>
                           <th>Total cost</th>
                           <th>Advance</th>
                           <th class="bg-warning">Other</th>
                           <th>Status</th>
                           <th>Action</th>
                        </thead>
                        <tbody>
                           @foreach($payments->where('status', 0) as $payment)      
                              <tr>
                                 <td>{{$loop->iteration}}</td>
                                 <td class="capitalize">{!!$payment->room_type!!}</td>
                                 <td>{!!$payment->tran_id!!}</td>
                                 <td>
                                    <img src="{{asset('')}}/{{$payment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                    <br>
                                    <span>{!!$payment->getPatient->name!!}</span>
                                 </td>                                 
                                 <td>{!!$payment->bed_fee!!}</td>
                                 <td>{!!$payment->advance!!}</td>
                                 <td>{!!$payment->bed_fee - $payment->advance!!}</td>
                                  <td>
                                    <span class="bg-primary userType px-2">Unpaid</span>
                                 </td>
                                 <td idth="auto">
                                    <a href="{{ url('paymentView', [$payment->id])}}" class="btn btn-sm btn-warning py-1">Add payment</a>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>

                  <div class="tab-pane fade show" id="paid">
                     <table class="table table-bordered">
                        <thead class="bg-info">
                           <th>Sl</th>
                           <th>Room type</th>
                           <th>Payment Id</th>
                           <th>Patient</th>
                           <th>Total cost</th>
                           <th>Advance</th>
                           <th>Other</th>
                           <th>Status</th>
                           <th>Action</th>
                        </thead>
                        <tbody>
                           @foreach($payments->where('status', 1) as $payment)                           
                              <tr>
                                 <td>{{$loop->iteration}}</td>
                                 <td class="capitalize">{!!$payment->room_type!!}</td>
                                 <td>{!!$payment->tran_id!!}</td>
                                 <td>
                                    <img src="{{asset('')}}/{{$payment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                    <br>
                                    <span>{!!$payment->getPatient->name!!}</span>
                                 </td> 
                                 <td>{!!$payment->bed_fee!!}</td>
                                 <td>{!!$payment->advance!!}</td>
                                 <td>{!!$payment->bed_fee - $payment->advance!!}</td>
                                 <td>
                                    <span class="bg-success userType px-2">Paid</span>
                                 </td>
                                 <td>
                                    <a href="{{ url('invoice-view', [$payment->id])}}" class="btn btn-sm btn-secondary py-1">Invoice view</a>
                                 </td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
