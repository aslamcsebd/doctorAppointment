@extends('layouts.app')
   @section('title') Booking list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
    <div class="row justify-content-center">

        <!-- Result -->
        <div class="col-md-12">
            @if(isset($cabines))
                <h6 class="card-header bg-success text-center py-1 mx-1">Cabin/room list</h6>
                <div class="card-body p-1">
                    <table class="table table-bordered">
                        <thead class="bg-info">
                            <th class="hide">Sl</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Floor no</th>
                            <th>Room no</th>
                            <th>Rent per night</th>
                            <th>Card type</th>
                        </thead>
                        <tbody>
                            @foreach($cabines as $cabin)                         
                                <tr>
                                    <td>{{$cabin->check_in}}</td>
                                    <td>{{$cabin->check_out}}</td>
                                    <td>{{$cabin->floorId->floorNo->floor}}</td>
                                    <td class="{{ $cabin->check_out >= date('Y-m-d') ? 'bg-warning' : '' }}">{{$cabin->room_no}} </td>
                                    <td>{{$cabin->rent}}</td>
                                    <td>{{$cabin->card_type}}</td>
                                </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if(isset($wards))   
                <h6 class="card-header bg-secondary text-center py-1 mx-1 mt-4">Ward list</h6>
                <div class="card-body p-1">
                    <table class="table table-bordered">
                        <thead class="bg-info">
                            <th class="hide">Sl</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Floor no</th>
                            <th>Room no</th>
                            <th>Ward no</th>
                            <th>Rent per night</th>
                            <th>Card type</th>
                        </thead>
                        <tbody>
                            @foreach($wards as $ward)
                                <tr>
                                    <td>{{$ward->check_in}}</td>
                                    <td>{{$ward->check_out}}</td>
                                    <td>{{$ward->wardNo->roomNo->floorNo->floor}}</td> 
                                    <td>{{$ward->wardNo->roomNo->room_no}}</td>
                                    <td class="{{ $ward->check_out >= date('Y-m-d') ? 'bg-warning' : '' }}">{{$ward->wardNo->ward_no}}</td>
                                    <td>{{$ward->rent}}</td>
                                    <td>{{$ward->card_type}}</td>
                                </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
   </div>
</div>

@endsection

@section('js')
@endsection
