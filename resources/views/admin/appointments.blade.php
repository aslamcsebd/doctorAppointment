@extends('layouts.app')
@section('title') Appointment list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">      
         <h6 class="card-header bg-success text-center py-1 mx-1">Appointment list</h6>
         <div class="card-header p-1">
            <ul class="nav nav-pills" id="tabMenu">
               <li class="nav-item">
                  <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#pending">Pending ({{ $appointments->where('status', 'pending')->count() }})</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#accept">Accept ({{ $appointments->where('status', 'accept')->count() }})</a>
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
                              <th>Appointment id</th>
                              <th>Doctor</th>
                              <th>Patient</th>
                              <th>Appointment date</th>
                              <th>Patient number</th>
                              <th>Status</th>
                              <th>Action</th>
                           </thead>
                           <tbody>
                              @foreach($appointments->where('status', 'pending') as $appointment)
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>{!!$appointment->appointment_id!!}</td>
                                    <td>
                                       <img src="{{ asset($appointment->doctor->photo ?? 'images/default.jpg') }}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$appointment->user->name!!}</span>
                                    </td>      
                                    <td>
                                       <img src="{{ asset($appointment->patient->photo ?? 'images/default.jpg') }}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!! $name = $appointment->user2->name !!}</span>
                                    </td>
                                    <td>
                                       {{ $date = date('d-M-Y  h:i a', strtotime($appointment->date . $appointment->time)) }}
                                    </td>
                                    <td>{!!$appointment->user2->phone!!}</td>
                                    <td>
                                       <span class="bg-primary userType px-2">Pending</span>
                                    </td>
                                    <td width="auto">
                                       <a class="btn btn-sm btn-outline-primary appointmentPending"
                                           data-toggle="modal" data-target="#appointmentPending"
                                           data-id="{{ $appointment->id }}"
                                           data-appointment_id="{{ $appointment->appointment_id }}"
                                           data-name="{{ $name }}"
                                           data-date="{{ date('Y-m-d\TH:i', strtotime($date)) }}"                                           
                                           data-out_time="{{ date('H:i', strtotime("30 minutes", strtotime($date))) }}"                                      
                                       >View</a>
                                       <a href="{{ url('itemDelete', ['appointments', $appointment->id, 'tabName'])}}" class="btn btn-sm btn-danger py-1" onclick="return confirm('Are you want to delete this?')">Delete</a>
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
                              <th>Appointment id</th>
                              <th>Doctor</th>
                              <th>Patient</th>
                              <th>Appointment date</th>
                              <th>Patient number</th>
                              <th>Status</th>
                              <th>Action</th>
                           </thead>
                           <tbody>
                              @foreach($appointments->where('status', 'accept') as $appointment)
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>{!!$appointment->appointment_id!!}</td>
                                    <td>
                                       <img src="{{ asset($appointment->doctor->photo ?? 'images/default.jpg') }}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$appointment->user->name!!}</span>
                                    </td>
                                    <td>
                                       <img src="{{ asset($appointment->patient->photo ?? 'images/default.jpg') }}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!! $appointment->user2->name !!}</span>
                                    </td>
                                    <td>
                                       {{ date('d-M-Y  h:i a', strtotime($appointment->date . $appointment->time)) }}
                                    </td>
                                    <td>{!!$appointment->user2->phone!!}</td>
                                    <td>
                                       <span class="bg-success userType px-2">Accept</span>
                                    </td>
                                    <td width="auto">
                                       <a href="{{ url('admin/patient-view', [$appointment->id]) }}" class="btn btn-sm btn-success py-1 ml-1">Add report</a>
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
                              <th>Appointment id</th>
                              <th>Doctor</th>
                              <th>Patient</th>
                              <th>Mobile</th>
                              <th>Appointment date</th>
                              <th>Status</th>
                              <th>Action</th>
                           </thead>
                           <tbody>
                              @foreach($appointments->where('status', 'report') as $appointment)
                                 <tr>
                                    <td idth="30">{{$loop->iteration}}</td>
                                    <td>{!!$appointment->appointment_id!!}</td>
                                    <td>
                                       <img src="{{ asset($appointment->doctor->photo ?? 'images/default.jpg') }}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$appointment->user->name!!}</span>
                                    </td>
                                    <td>
                                       <img src="{{asset('')}}/{{$appointment->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$appointment->user2->name!!}</span>
                                    </td>                        
                                    <td>{!!$appointment->user2->phone!!}</td>
                                    <td>
                                       {{date('d-M-Y (h:i a)', strtotime($appointment->date))}}
                                    </td>
                                    <td>
                                       <span class="bg-secondary userType px-2">Report added</span>
                                    </td>
                                    <td width="auto">
                                       <div class="btn-group">
                                             <a href="{{ url('admin/last-report', [$appointment->appointment_id])}}" class="btn btn-sm btn-info px-4 py-1">View</a>
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

@include('modal.appointmentPendingBottom')

@endsection
@section('js')
   <script type="text/javascript">
      $('.appointmentPending').click(function() {
         var id = $(this).data('id');
         var appointment_id = $(this).data('appointment_id');
         var name = $(this).data('name');
         var date = $(this).data('date');
         var outTime = $(this).data('out_time');

         $('#id').val(id); 
         $('#appointment_id').val(appointment_id); 
         $('#name').val(name); 
         $('#date').val(date);
         $('#outTime').val(outTime);
      });
   </script>
@endsection
