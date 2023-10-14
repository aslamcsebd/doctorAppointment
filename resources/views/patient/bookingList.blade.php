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
                            <th>Room no</th>
                            <th>Rent per day</th>
                            <th>Advance</th>
                            <th>Card type</th>
                            <th>Action</th>
                        </thead>
                        <tbody> 
                            @foreach($cabines as $cabin)                         
                                <tr>
                                    <td>
                                        {{ date('Y-m-d', strtotime($cabin->check_in))}} <br>
                                        <b>({{ date('h:s a', strtotime($cabin->check_in))}})</b>
                                    </td>
                                    <td>
                                        {{ date('Y-m-d', strtotime($cabin->check_out))}} <br>
                                        <b>({{ date('h:s a', strtotime($cabin->check_out))}})</b>
                                    </td>
                                    <td class="{{ $cabin->check_out >= date('Y-m-d') ? 'bg-warning' : '' }}">{{$cabin->room_no}} </td>
                                    <td>{{$cabin->rent}}</td>
                                    <td>{{$cabin->payment->advance}}</td>
                                    <td>{{$cabin->card_type}}</td>
                                    <td>
                                        <a href="{{ Url('/patient/payment/print', [ $cabin->tran_id ]) }}" class="btn btn-sm btn-outline-primary p-1">
                                            <i class="fas fa-download pr-1"></i> Invoice
                                        </a>
                                    </td>
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
                            <th>Room no</th>
                            <th>Ward no</th>
                            <th>Rent per day</th>
                            <th>Advance</th>
                            <th>Card type</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($wards as $ward)
                                <tr>
                                    <td>{{ date('Y-m-d', strtotime($ward->check_in))}}</td>
                                    <td>{{ date('Y-m-d', strtotime($ward->check_out))}}</td>
                                    <td>{{$ward->wardNo->roomNo->room_no}}</td>
                                    <td class="{{ $ward->check_out >= date('Y-m-d') ? 'bg-warning' : '' }}">{{$ward->wardNo->ward_no}}</td>
                                    <td>{{$ward->rent}}</td>
                                    <td>{{$ward->payment->advance}}</td>
                                    <td>{{$ward->card_type}}</td>
                                    <td>
                                        <a href="{{ Url('/patient/payment/print', [ $ward->tran_id ]) }}" class="btn btn-sm btn-outline-primary p-1">
                                            <i class="fas fa-download pr-1"></i> Invoice
                                        </a>
                                    </td>
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
