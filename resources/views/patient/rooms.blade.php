@extends('layouts.app')
   @section('title') Room-seat @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
   <div class="row justify-content-center">
      <div class="col-md-12">       
         <div class="card border border-danger">
            <h6 class="card-header bg-success text-center py-1 mx-1 mt-1">Cabin/room list</h6>
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
					  	<th>Floor</th>
					  	<th>Room name</th>
                        <th>Room no</th>
                        <th>Rent</th>
                  </thead>
                  <tbody>
                     @foreach($floors as $floor)
                        @php $roomCount = $floor->rooms->where('room_type', 'cabin')->count()  @endphp

                        <tr>
                           <td rowspan="{{($roomCount > 1) ? $roomCount+1 : ''}}">{{$floor->floor}}</td>
                           @if($roomCount == 1)
                              @foreach($floor->rooms->where('room_type', 'cabin')->sortBy('room') as $room)
                                    <td>{{$room->name}}</td>
                                    <td>{{$room->room_no}}</td>
                                    <td>{{$room->rent}}</td>
                              @endforeach
                           @endif
                        </tr>
                           @if($roomCount > 1)
                              @foreach($floor->rooms->where('room_type', 'cabin')->sortBy('room') as $room)
                                    <tr>
										<td>{{$room->name}}</td>
                                       <td>{{$room->room_no}}</td>
                                       <td>{{$room->rent}}</td>
                                    </tr>     
                              @endforeach
                           @endif
                     @endforeach
                  </tbody>
               </table>
            </div>                   
            
            <h6 class="card-header bg-secondary text-center py-1 mx-1 mt-3">Ward list</h6>
            <div class="card-body p-1">
               <table class="table table-bordered">
                  <thead class="bg-info">
                        <th>Room no</th>
                        <th>Room name</th>
                        <th>Ward no</th>
                        <th>Rent</th>
                  </thead>
                  <tbody>
                     @foreach($roomWards as $room)
                        @php $wardCount = $room->wards->count()  @endphp

                        <tr>
                           <td rowspan="{{($wardCount > 1) ? $wardCount+1 : ''}}">{{$room->room_no}}</td>
                           <td rowspan="{{($wardCount > 1) ? $wardCount+1 : ''}}">{{$room->name}}</td>
                        </tr>
                           @if($wardCount > 1)
                              @foreach($room->wards->sortBy('ward_no') as $ward)
                                    <tr>
                                       <td>{{$ward->ward_no}}</td>
                                       <td>{{$room->rent}}</td>
                                    </tr>     
                              @endforeach
                           @endif
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
