
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{ asset('css/bootstrap3.3.7.min.css') }}">
        <title>Payment</title>
        <style>
            h4{ margin: 0; font-weight: bold; }
			.img-thumbnail{
				width: 70px;
				height: 70px;
				border-radius: 50%;
				padding: 0rem;
				border: 1px solid #dee2e6;
			}
			.table>tbody>tr>td{ padding: 5px 8px; }
			.top tr td table tbody{ min-height:160px !important; }
        </style>
    </head>
    <body class="container-fluid" tyle="width: 8.27in; margin: auto;">
        <div class="row justify-content-center">
			<div class="col-md-12">
                <h4 class="text-center" tyle="margin: 20px 0;">
                    <img src="{{ asset($hospital->photo ?? 'images/default.jpg') }}" class="img-thumbnail" alt="No Image found" width="60">
					<p></p>
					<h4 class="text-center">{{ $hospital->name ?? '' }}</h4>
					<p></p>
                </h4>

                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width: 45%; padding:0%;">
                                        <div>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="bg-danger">
                                                        <td colspan="2">
                                                            <h4 class="text-center">Billing to</h4>
                                                        </td>
                                                    </tr>          
                                                    <tr>
                                                        <td>Patient ID</td>
                                                        <td>{{ $payment->patientInfo->patient_id ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>{{ $payment->getPatient->name ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobile</td>
                                                        <td>{{ $payment->getPatient->phone ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{ $payment->getPatient->email ?? '' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td style="width: 10%; padding:0%;"></td>
                                    <td style="width: 50%; padding:0%;">
										<table class="table table-bordered">
											<tbody>
												<tr class="bg-danger">
													<td>
														<h4 class="text-center">Hospital information</h4>
													</td>
												</tr>
												<tr>
													<td>{!! $hospital->address ?? '' !!}</td>
												</tr>
											</tbody>
										</table> 
                                        <div>
                                        </div>
                                    </td>                  
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-danger">
                                    <td colspan="2">
                                        <h4 class="text-center">Invoice</h4>
                                    </td>
                                </tr>
								<tr>
                                    <td>Invoice No</td>
                                    <td>{{ $payment->tran_id ?? '' }}</td>
                                </tr>
								<tr>
                                    <td>Booking type</td>
                                    <td style="text-transform: capitalize">{{ $payment->room_type ?? '' }}</td>
                                </tr>
        
                                @if($payment->room_type == 'cabin')
                                    <tr>
                                        <td>
                                            Floor number ({{ $payment->cabin->floorId->floorNo->floor }}),
                                            Room number
                                        </td>
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
                                        <td>
                                            Floor number ({{ $payment->ward->wardNo->roomNo->floorNo->floor }}),
                                            Room number ({{ $payment->ward->wardNo->roomNo->room_no }}),
                                            Ward number
                                        </td>
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
                    </div>
                </div>

				<br> <br>
				<p>
					- - - - - - - - - - - - - - - -
					<p style="padding-left: 30px;">
						<b>
							Signature
						</b>
					</p>
				</p>
			</div>
	   </div>
    </body>
</html>
