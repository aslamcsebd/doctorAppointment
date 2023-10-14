@extends('layouts.app')
   @section('title') Patient last report @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3 view">
   <div class="row justify-content-center">

      <div class="col-md-12">
         <div class="card">
            <h6 class="card-header bg-success text-center py-2">Single patient</h6>
            <div class="card-body">
               <table class="table table-bordered">                  
                  <tr>
                     <td colspan="2">
                        <div class="text-center">
                           <img src="{{asset('')}}/{{$appointment->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="100">
                           <br>
                           <span>{{$appointment->user2->name}}</span>                
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Email</label>
                     </td>
                     <td>{{$appointment->user2->email}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Phone</label>
                     </td>
                     <td>{{$appointment->user2->phone}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Gender</label>
                     </td>
                     <td>{{$appointment->patient->gender}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Blood group</label>
                     </td>
                     <td>{{$appointment->patient->blood}}</td>
                  </tr>
                  <tr>
                     <td width="20%">
                        <label class="capitalize">Date of birth</label>
                     </td>
                     <td>{{date('d-M-Y', strtotime($appointment->patient->dob))}}</td>
                  </tr>
               </table>             
            </div>
         </div>
      </div>

      <div class="col-md-12">        
         <div class="card">
            <h6 class="card-header bg-success text-center py-1 mx-1">Patient last report</h6>
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Appointment id</th>
                     <th>Appointment date</th>
                     <th>Report name</th>
                     <th>Report date</th>
                     <th>File</th>
                  </thead>
                  <tbody>
                        <tr>
                           <td width="30">1</td>
                           <td>{!!$report->appointment_id!!}</td>
                           <td>{{ date('d-M-Y (h:i a)', strtotime($appointment->date . $appointment->time)) }}</td>
                           <td>
                              <span>{!!$report->title!!}</span>
                           </td>                        
                           <td>{{ date('d-M-Y (h:i a)', strtotime($report->date)) }}</td>
                           <td>
                              <a href="{{asset('')}}/{{$report->file}}" class="btn btn-large pull-right" target="_blank" download="">
                                 <i class="fas fa-download pr-2"></i>Download
                              </a>
                            </td>
                        </tr>
                  </tbody>
               </table>

               <a href="{{ route('all.appointment') }}" class="btn btn-primary col-auto mt-2">
                  <i class="fas fa-arrow-circle-left nav-icon"></i> &nbsp;
                  Back previous page
               </a>
            </div>                   
         </div>
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
