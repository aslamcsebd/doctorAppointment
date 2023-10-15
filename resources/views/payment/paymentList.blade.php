@extends('layouts.app')
    @section('title') Payment list @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{ Url('/total-payment', [$check_in, $check_out]) }}" class="btn btn-primary px-1 mb-2">
                <i class="fas fa-download px-2"></i>Download
            </a>
            <h6 class="card-header bg-secondary text-center py-1 mx-1">All payment list</h6>
            <div class="card-body p-1">
                <table class="table table-bordered">
                    <thead class="bg-info">
                        <th>Id</th>
                        <th>Payment id</th>
                        <th>Room type</th>
                        <th>Room no</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        @foreach($payments as $payment)
                            <tr>	
                                <td width="30">{{ $loop->iteration }}</td>
                                <td>{{ $payment->tran_id }}</td>
                                <td>{{ $payment->room_type }}</td>
                                @if($payment->room_type == 'cabin')
                                    <td>{{ $payment->cabin->room_no }}</td>
                                    <td>{{ date('d-M-Y', strtotime($payment->cabin->check_in)) }}</td>
                                    <td>{{ date('d-M-Y', strtotime($payment->cabin->check_out)) }}</td>
                                @else
                                    <td>{{ $payment->ward->wardNo->roomNo->room_no }}
                                        ({{ $payment->ward->wardNo->ward_no }})
                                    </td>
                                    <td>{{ date('d-M-Y', strtotime($payment->ward->check_in)) }}</td>
                                    <td>{{ date('d-M-Y', strtotime($payment->ward->check_out)) }}</td>
                                @endif
                                <td>{{ $sum = $payment->advance + $payment->due }}</td>
                                <?php $total = $total + $sum; ?>
                            </tr>								
                        @endforeach
                        <tr class="bg-info">
                            <td colspan='6'>
                                <b class="float-right pr-4">Sum : </b>
                            </td>
                            <td>
                                <b><?=$total;?></b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
   </div>
</div>
@endsection

@section('js')    
@endsection
