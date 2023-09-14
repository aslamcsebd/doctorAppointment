@extends('layouts.app')
@section('title') Cabin list @endsection
@section('content')
@include('includes.alertMessage')
@php $route = 'cabin.booking'; @endphp

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">      
         <h6 class="card-header bg-success text-center py-1 mx-1">Cabin booking</h6>
         <div class="card-header p-1">
            <ul class="nav nav-pills" id="tabMenu">
               <li class="nav-item">
                  <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#running">Running ({{$cabines->count()}})</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#past">Past</a>
               </li>
            </ul>
         </div>
        
         <div class="card-body p-1">            
            <div class="tab-content" id="pills-tabContent">
               <div class="tab-pane fade show active" id="running">
                  <div class="card">
                     <div class="card-body p-1">
                        <table class="table table-bordered">
                           <thead class="bg-info">
                              <th>Sl</th>
                              <th>Patient</th>
                              <th>Check in</th>
                              <th>Check out</th>
                              <th>Floor no</th>
                              <th>Room no</th>
                              <th>Rent per day</th>
                              <th>View</th>
                           </thead>
                           <tbody>
                              @foreach($cabines->where('check_out', '>=', date('Y-m-d')) as $cabin)                         
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>
                                       <img src="{{asset('')}}/{{$cabin->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$cabin->user->name!!}</span>
                                    </td>
                                    <td>{{ date('Y-m-d (h:s a)', strtotime($cabin->check_in)) }}</td>
                                    <td>{{ date('Y-m-d (h:s a)', strtotime($cabin->check_out)) }}</td>
                                    <td>{{$cabin->floorId->floorNo->floor}}</td>
                                    <td>{{$cabin->room_no}} </td>
                                    <td>{{$cabin->rent}}</td>
                                    <td width="auto">
                                       <div class="btn-group"> 
                                             <a href="{{ url('booking-view', [$cabin->id, 'cabin', $route, 'active'])}}" class="btn btn-sm btn-info py-1">View</a>
                                        </div>
                                    </td>
                                 </tr>  
                              @endforeach
                           </tbody>
                        </table>
                     </div>                   
                  </div>
               </div>

               <div class="tab-pane fade show" id="past">                 
                  <div class="card">
                     <div class="card-body p-1">
                        <table class="table table-bordered">
                           <thead class="bg-info">
                              <th>Sl</th>
                              <th>Patient</th>
                              <th>Check in</th>
                              <th>Check out</th>
                              <th>Floor no</th>
                              <th>Room no</th>
                              <th>Rent per day</th>
                              <th>View</th>
                           </thead>
                           <tbody>
                              @foreach($cabines->where('check_out', '<', date('Y-m-d')) as $cabin)                         
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>
                                       <img src="{{asset('')}}/{{$cabin->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$cabin->user->name!!}</span>
                                    </td>
                                    <td>{{ date('Y-m-d (h:s a)', strtotime($cabin->check_in)) }}</td>
                                    <td>{{ date('Y-m-d (h:s a)', strtotime($cabin->check_out)) }}</td>
                                    <td>{{$cabin->floorId->floorNo->floor}}</td>
                                    <td>{{$cabin->room_no}} </td>
                                    <td>{{$cabin->rent}}</td>
                                    <td width="auto">
                                       <div class="btn-group"> 
                                             <a href="{{ url('booking-view', [$cabin->id, 'cabin', $route, 'inactive'])}}" class="btn btn-sm btn-info py-1">View</a>
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
