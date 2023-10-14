<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{{ asset('css/bootstrap3.3.7.min.css') }}">
        <title>Cabin list</title>
        <style>
            .table thead th, .table tbody tr td {text-align: center !important; vertical-align: middle !important;}
        </style>
    </head>
    <body class="container-fluid">
        <div class="row justify-content-center">    
			<div class="col-md-12">
				<h3 class="card-header bg-secondary text-center py-1 mx-1">{{$type}} list</h3>
				<div class="card-body p-1">
					<table class="table table-bordered">
						<thead class="bg-info">
							<th>Id</th>
							<th>Check in</th>
							<th>Check out</th>

							@if($type=='cabin')
								<th>Ward no</th>
							@else
								<th>Room no</th>
								<th>Ward no</th>
							@endif							
						</thead>
						<tbody>
							@foreach($booked as $book)
								<tr>	
									<td width="30">{{ $loop->iteration }}</td>
									<td>{{ date('d-M-Y', strtotime($book->check_in)) }}</td>
									<td>{{ date('d-M-Y', strtotime($book->check_out)) }}</td>
									@if($type=='cabin')
										<td>{{ $book->room_no }}</td>
									@else
										<td>{{ $book->wardNo->roomNo->room_no }}</td>
										<td>{{ $book->wardNo->ward_no }}</td>
									@endif
								</tr>								
							@endforeach
						</tbody>
					</table>
				</div>                     
			</div>
	   </div>
    </body>
</html>
