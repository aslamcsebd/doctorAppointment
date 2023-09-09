@extends('layouts.app')
@section('title') Appointment list @endsection
@section('content')
@include('includes.alertMessage')
@php $route = 'appointment.request'; 
   $appointments = App\Models\Appointment::where('doctor_id', Auth::id())->with('user2')->orderBy('id', 'DESC')->get();
@endphp
<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">      
         <h6 class="card-header bg-success text-center py-1 mx-1">Appointment list</h6>
         <div class="card-header p-1">
            <ul class="nav nav-pills" id="tabMenu">
               <li class="nav-item">
                  <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#pending">Pending ({{$appointments->where('status', 0)->count()}})</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#accept">Accept ({{$appointments->where('status', 1)->count()}})</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#report">Report complete</a>
               </li>
            </ul>
         </div>
        
         <div class="card-body p-1">            
            <div class="tab-content" id="pills-tabContent">
               <div class="tab-pane fade show active" id="pending">
                  <div class="card">
                     <div class="card-body p-1">
                        <table class="table table-bordered">
                           <thead class="bg-info">
                              <th>Sl</th>
                              <th>Patient</th>
                              <th>Appointment id</th>
                              <th>Mobile</th>
                              <th>Appointment date</th>
                              <th>Status</th>
                              <th>Action</th>
                           </thead>
                           <tbody>
                              @foreach($appointments->where('status', 0) as $appointment)
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>
                                       <img src="{{asset('')}}/{{$appointment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$appointment->user2->name!!}</span>
                                    </td>                        
                                    <td>{!!$appointment->appointment_id!!}</td>
                                    <td>{!!$appointment->user2->phone!!}</td>
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
                                             <a href="{{ url('single-patient', [$appointment->id, $route, 'pending'])}}" class="btn btn-sm btn-info py-1">View</a>
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

               <div class="tab-pane fade show" id="accept">                 
                  <div class="card">
                     <div class="card-body p-1">
                        <table class="table table-bordered">
                           <thead class="bg-info">
                              <th>Sl</th>
                              <th>Patient</th>
                              <th>Appointment id</th>
                              <th>Mobile</th>
                              <th>Appointment date</th>
                              <th>Status</th>
                              <th>Action</th>
                           </thead>
                           <tbody>
                              @foreach($appointments->where('status', 1) as $appointment)
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>
                                       <img src="{{asset('')}}/{{$appointment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$appointment->user2->name!!}</span>
                                    </td>                        
                                    <td>{!!$appointment->appointment_id!!}</td>
                                    <td>{!!$appointment->user2->phone!!}</td>
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
                                             <a href="{{ url('single-patient', [$appointment->id, $route, 'accept'])}}" class="btn btn-sm btn-info py-1">View</a>
                                             @if($appointment->status == 1)
                                                <a href="{{ url('patient-view', [$appointment->id]) }}" class="btn btn-sm btn-success py-1 ml-1">Add report</a>
                                             @endif
                                       </div>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>                   
                  </div>
               </div>

               <div class="tab-pane fade show" id="report">                 
                  <div class="card">
                     <div class="card-body p-1">
                        <table class="table table-bordered">
                           <thead class="bg-info">
                              <th>Sl</th>
                              <th>Patient</th>
                              <th>Appointment id</th>
                              <th>Mobile</th>
                              <th>Appointment date</th>
                              <th>Status</th>
                              <th>Action</th>
                           </thead>
                           <tbody>
                              @foreach($appointments->where('status', 2) as $appointment)
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>
                                       <img src="{{asset('')}}/{{$appointment->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$appointment->user2->name!!}</span>
                                    </td>                        
                                    <td>{!!$appointment->appointment_id!!}</td>
                                    <td>{!!$appointment->user2->phone!!}</td>
                                    <td>
                                       {!!$appointment->date!!} ({{date('l', strtotime($appointment->date))}})
                                    </td>
                                    <td>
                                       <span class="bg-secondary userType px-2">Report added</span>
                                    </td>
                                    <td width="auto">
                                       <div class="btn-group">
                                             <a href="{{ url('patient-last-report', [$appointment->id, $route, 'report'])}}" class="btn btn-sm btn-info py-1">View</a>
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
      </div>
   </div>
</div>

@endsection

@section('js')
@endsection
