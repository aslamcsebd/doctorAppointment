@extends('layouts.app')
@section('title') Ward list @endsection
@section('content')
@include('includes.alertMessage')
@php $route = 'ward.booking'; @endphp

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">      
         <h6 class="card-header bg-success text-center py-1 mx-1">Ward booking</h6>
         <div class="card-header p-1">
            <ul class="nav nav-pills" id="tabMenu">
               <li class="nav-item">
                  <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#active">Active ({{$wards->count()}})</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#inactive">Inactive</a>
               </li>
            </ul>
         </div>
        
         <div class="card-body p-1">            
            <div class="tab-content" id="pills-tabContent">
               <div class="tab-pane fade show active" id="active">
                  <div class="card">
                     <div class="card-body p-1">
                        <table class="table table-bordered">
                           <thead class="bg-info">
                              <th>Sl</th>
                              <th>Patient</th>
                              <th>Check in</th>
                              <th>Check out</th>
                              <th>Room no</th>
                              <th>Ward no</th>
                              <th>Rent per night</th>
                              <th>View</th>
                           </thead>
                           <tbody>
                              @foreach($wards->where('check_out', '>=', date('Y-m-d')) as $ward)                         
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>
                                       <img src="{{asset('')}}/{{$ward->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$ward->user->name!!}</span>
                                    </td>
                                    <td>{{$ward->check_in}}</td>
                                    <td>{{$ward->check_out}}</td>
                                    <td>{{$ward->wardNo->roomNo->room_no}} </td>
                                    <td>{{$ward->wardNo->ward_no}} </td>
                                    <td>{{$ward->rent}}</td>
                                    <td width="auto">
                                       <div class="btn-group"> 
                                             <a href="{{ url('booking-view', [$ward->id, 'ward', $route, 'active'])}}" class="btn btn-sm btn-info py-1">View</a>
                                        </div>
                                    </td>
                                 </tr>  
                              @endforeach
                           </tbody>
                        </table>
                     </div>                   
                  </div>
               </div>

               <div class="tab-pane fade show" id="inactive">                 
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
                              <th>Rent per night</th>
                              <th>View</th>
                           </thead>
                           <tbody>
                              @foreach($wards->where('check_out', '<', date('Y-m-d')) as $ward)                         
                                 <tr>
                                    <td width="30">{{$loop->iteration}}</td>
                                    <td>
                                       <img src="{{asset('')}}/{{$ward->patient->photo ?? 'images/default.jpg'}}" class="img-thumbnail" alt="No Image found" width="60">
                                       <br>
                                       <span>{!!$ward->user->name!!}</span>
                                    </td>
                                    <td>{{$ward->check_in}}</td>
                                    <td>{{$ward->check_out}}</td>
                                    <td>{{$ward->wardNo->roomNo->room_no}} </td>
                                    <td>{{$ward->wardNo->ward_no}} </td>
                                    <td>{{$ward->rent}}</td>
                                    <td width="auto">
                                       <div class="btn-group"> 
                                             <a href="{{ url('booking-view', [$ward->id, 'ward', $route, 'inactive'])}}" class="btn btn-sm btn-info py-1">View</a>
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
