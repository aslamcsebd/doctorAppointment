@extends('layouts.app')
@section('title')
    Payment view
@endsection
@section('content')
    @include('includes.alertMessage')
    <style>
        .table.dataTable tbody td:first-child {
            text-align: right !important;
            padding-right: 20px; 
        }
        .table.dataTable tbody td:last-child {
            text-align: left !important;
            padding-left: 20px; 
        }
    </style>
    <div class="content-wrapper p-3">
        <h4 class="text-center">            
            <span>{{ $hospital->name ?? '' }}</span>
        </h4>        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h5 class="text-center">Invoice</h5>
                            </td>
                        </tr>
                        <tr class="bg-info ">
                            <td>Booking type</td>
                            <td class="capitalize">{{ $payment->room_type ?? '' }}</td>
                        </tr>

                        @if($payment->room_type == 'cabin')
                            <tr>
                                <td>Floor no</td>
                                <td>{{ $payment->cabin->floorId->floorNo->floor }}</td>
                            </tr>
                            <tr>
                                <td>Room number</td>
                                <td>{{ $payment->cabin->room_no }}</td>
                            </tr>
                            <tr>
                                <td>Check in</td>
                                <td>{{ date('d-M-Y (h:i a)', strtotime($payment->cabin->check_in)) }}</td>
                            </tr>
                            <tr>
                                <td>Check out</td>
                                <td>{{ date('d-M-Y (h:i a)', strtotime($payment->cabin->check_out)) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>Floor no</td>
                                <td>{{ $payment->ward->wardNo->roomNo->floorNo->floor }}</td>
                            </tr>
                            <tr>
                                <td>Room number</td>
                                <td>{{ $payment->ward->wardNo->roomNo->room_no }}</td>
                            </tr>
                            <tr>
                                <td>Ward no</td>
                                <td>{{ $payment->ward->wardNo->ward_no }}</td>
                            </tr>
                            <tr>
                                <td>Check in</td>
                                <td>{{ date('d-M-Y', strtotime($payment->ward->check_in)) }}</td>
                            </tr>
                            <tr>
                                <td>Check out</td>
                                <td>{{ date('d-M-Y', strtotime($payment->ward->check_out)) }}</td>
                            </tr>
                        @endif   

                        <tr>
                            <td>Total cost</td>
                            <td>{{ $payment->bed_fee ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Advance</td>
                            <td>{{ $payment->advance ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Other cost</td>
                            <td>{{ $payment->due ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{route('payment')}}" class="btn btn-primary col-3 mt-2">
                    <i class="fas fa-arrow-circle-left nav-icon"></i> &nbsp; Back
                </a>
                <a href="{{ Url('/admin/payment/print', [$payment->id]) }}" class="btn btn-success offset-md-5 col-3 mt-2 pull-right">
                    <i class="fas fa-download pr-3"></i>Download
                </a>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
