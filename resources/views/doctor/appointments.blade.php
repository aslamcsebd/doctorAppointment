@extends('layouts.app')
   @section('title') Appointment list @endsection
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
                     <th>Name</th>
                     <th>Mobile</th>
                     <th>Email</th>
                     <th>Appointment</th>
                     <th>Status</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach($appointments as $appointment)
                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>
                              <img src="{{asset('')}}/{{$appointment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                              <br>
                              <span class="singerName">{!!$appointment->user2->name!!}</span>
                           </td>                        
                           <td>{!!$appointment->user2->phone!!}</td>
                           <td>{!!$appointment->user2->email!!}</td>
                           <td>
                              {!!$appointment->date!!} ({{date('l', strtotime($appointment->date))}})
                           </td>
                            @php
                                $appointment->status == 0 ? $bg='bg-primary' : $bg='bg-success';
                                $appointment->status == 0 ? $title='Pending' : $title='Accept';
                            @endphp
                            <td>
                              <span class="{{$bg}} userType px-2">{{$title}}</span>
                           </td>
                           <td width="auto">
                              <div class="btn-group">
                                    <a href="{{ url('single-patient', [$appointment->patient_id, Route::currentRouteName()])}}" class="btn btn-sm btn-info py-1">View</a>
                                    <a href="{{ url('itemDelete', ['appointments', $appointment->id, 'tabName'])}}" class="btn btn-sm btn-danger ml-1 py-1 px-3" onclick="return confirm('Are you want to delete this?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                              </div>
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
