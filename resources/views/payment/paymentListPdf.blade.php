<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{ asset('css/bootstrap3.3.7.min.css') }}">
        <title>Payment</title>
        <style>
            .table thead th, .table tbody tr td {text-align: center !important; vertical-align: middle !important;}
        </style>
    </head>
    <body class="container-fluid">
        <div class="row justify-content-center">
			<div class="col-md-12">
                <h3 class="card-header bg-secondary text-center py-1 mx-1">All payment list</h3>
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
                                    <b class="pull-right pr-4">Sum : </b>
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
     </body>
 </html>
 