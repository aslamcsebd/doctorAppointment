@extends('layouts.app')
    @section('title') Room-seat @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
    <div class="row justify-content-center">
		@if($room_type == 'cabin')
			<div class="col-md-12">
				<a href="{{ Url('print', [$room_type, $check_in, $check_out]) }}" class="btn btn-primary p-1 mb-2">Download now</a>
				<h6 class="card-header bg-secondary text-center py-1 mx-1">Cabin list</h6>
				<div class="card-body p-1">
					<table class="table table-bordered">
						<thead class="bg-info">
							<th>Id</th>
							<th>Check in</th>
							<th>Check out</th>
							<th>Room no</th>
						</thead>
						<tbody>
							@foreach($booked as $book)		
								<tr>	
									<td width="30">{{ $loop->iteration }}</td>
									<td>{{ date('d-M-Y', strtotime($book->check_in)) }}</td>
									<td>{{ date('d-M-Y', strtotime($book->check_out)) }}</td>
									<td>{{$book->room_no}}</td>
								</tr>								
							@endforeach
						</tbody>
					</table>
				</div>                     
			</div>
		@else
			<div class="col-md-12">
				<a href="{{ Url('print', [$room_type, $check_in, $check_out]) }}" class="btn btn-primary p-1 mb-2">Download now</a>
				<h6 class="card-header bg-secondary text-center py-1 mx-1">Ward list</h6>
				<div class="card-body p-1">
					<table class="table table-bordered">
						<thead class="bg-info">
							<th>Id</th>
							<th>Check in</th>
							<th>Check out</th>
							<th>Room no</th>
							<th>Ward no</th>
						</thead>
						<tbody>
							@foreach($booked as $book)		
								<tr>	
									<td width="30">{{ $loop->iteration }}</td>
									<td>{{ date('d-M-Y', strtotime($book->check_in)) }}</td>
									<td>{{ date('d-M-Y', strtotime($book->check_out)) }}</td>
									<td>{{ $book->wardNo->roomNo->room_no }}</td>
									<td>{{ $book->wardNo->ward_no }}</td>									
								</tr>								
							@endforeach
						</tbody>
					</table>
				</div>                     
			</div>
		@endif     
       
   </div>
</div>
@endsection

@section('js')    
@endsection
