@extends('layouts.app')
   @section('title') Appointment list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">        
         <div class="card">
            <h6 class="card-header bg-success text-center py-1 mx-1">Appointment list</h6>
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Appointment id</th>
                     <th>Doctor name</th>
                     <th>Appointment date</th>
                     <th>Status</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @foreach($appointments as $appointment)
                        <tr>
                           <td width="30">{{$loop->iteration}}</td>
                           <td>{{$appointment->appointment_id}}</tdwidth=>
                           <td>
                              <img src="{{asset('')}}/{{$appointment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                              <br>
                              <span>{!!$appointment->user->name!!}</span>
                           </td>
                           <td>
                              {!!$appointment->date!!}
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
                                    <a href="{{ url('doctor-appointment', [$appointment->doctor_id, Route::currentRouteName()])}}" class="btn btn-sm btn-info py-1">View</a>
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
