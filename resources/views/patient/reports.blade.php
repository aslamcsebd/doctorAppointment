@extends('layouts.app')
   @section('title') Report list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">        
         <div class="card">
            <h6 class="card-header bg-success text-center py-1 mx-1">Report list</h6>
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                     <th>Sl</th>
                     <th>Name</th>
                     <th>Gender</th>
                     <th>Age</th>
                     <th>Fee</th>
                     <th>Action</th>
                  </thead>
                  <tbody>
                     @php $si=1; @endphp
                     @foreach($reports as $report2)
                        @foreach($report2->take(1) as $report)
                           <tr>
                              <td width="30">{{$si}}</td> @php $si++; @endphp
                              <td>
                                 <img src="{{asset('')}}/{{$report->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                 <br>
                                 <span>{!!$report->user->name!!}</span>
                              </td>                        
                              <td>{!!$report->user2->gender!!}</td>
                              <td>
                                 {{\Carbon\Carbon::parse($report->user2->dob)->diff(\Carbon\Carbon::now())->format('%y years')}}
                              </td>                          
                              <td>{!!$report->user2->fee!!}</td>                          

                              <td width="auto">
                                 <div class="btn-group">
                                       <a href="{{ url('report-view', [$report->doctor_id]) }}" class="btn btn-sm btn-info py-1">View</a>
                                 </div>
                              </td>
                           </tr>
                        @endforeach
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
