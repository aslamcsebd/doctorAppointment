@extends('layouts.app')
   @section('title') Payment system @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">
        
         <div class="card">
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Patient</th>
                     <th>Bed rent</th>
                     <th>Advance</th>
                     <th class="bg-warning">Due</th>
                     <th>Status</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach($payments->sortBy('status') as $payment)

                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>
                              <img src="{{asset('')}}/{{$payment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                              <br>
                              <span>{!!$payment->getPatient->name!!}</span>
                           </td> 
                           <td>{!!$payment->bed_fee!!}</td>
                           <td>{!!$payment->advance!!}</td>
                           <td>{!!$payment->bed_fee - $payment->advance!!}</td>
                            @php
                                $payment->status == 0 ? $bg='bg-primary' : $bg='bg-success';
                                $payment->status == 0 ? $title='Unpaid' : $title='Paid';
                            @endphp
                            <td>
                              <span class="{{$bg}} userType px-2">{{$title}}</span>
                           </td>
                           <td width="auto">
                                @if($payment->status == 0)
                                    <div class="btn-group">
                                        <a href="{{ url('paymentView', [$payment->id])}}" class="btn btn-sm btn-warning py-1 btn-block">Add payment</a>
                                    </div>
                                @endif
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

@endsection

@section('js')
@endsection
