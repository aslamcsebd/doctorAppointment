@extends('layouts.app')
    @section('title') Room-seat @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
    <div class="row justify-content-center">
        <?php
			// All booking time store
			$times = App\Models\BookingTime::where('status', 1)->pluck('time')->toArray();

           	if (isset($room_type) && $room_type == 'cabin') {
				$check_in_date = date('d-m-Y', strtotime($check_in));
				$check_in_time = date('h:i a', strtotime($check_in));
			
				$check_out_date = date('d-m-Y', strtotime($check_out));
				$check_out_time = date('h:i a', strtotime($check_out));
			}
			elseif(isset($room_type) && $room_type == 'ward'){
				$check_in_date = date('d-m-Y', strtotime($check_in));
				$check_out_date = date('d-m-Y', strtotime($check_out));
			}
        ?>
        <div class="col-md-12">
            <div class="card-body p-1">   
				<fieldset class="form-group pt-2 mb-1">
					<legend class="mb-0">Select room type</legend>
					<div class="row justify-content-center">
						<div class="form-group col-auto">
							<label for="start">Bed type*</label>
							<div class="border border-secondary rounded pb-1 mt-2">
								<div class="radio-toolbar form-check form-check-inline">
									<div class="radio m-1 pl-1">
										<input type="radio" id="cabin" name="room_type" value="cabin" @if (isset($room_type)) {{ $room_type == 'cabin' ? 'checked' : '' }} @endif required>
										<label for="cabin">Cabin/room</label>
									</div>
									<div class="radio m-1">
										<input type="radio" id="ward" name="room_type" value="ward" @if (isset($room_type)) {{ $room_type == 'ward' ? 'checked' : '' }} @endif required>
										<label for="ward">Ward(bed)</label>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group col-auto {{ (isset($room_type) && $room_type == 'ward') ? 'hide' : '' }}" id="cabinStatus">
							<form action="{{ route('admin.booking_search') }}" method="post" data_id="cabinAction" enctype="multipart/form-data" class="needs-validation">
								@csrf
								<input type="hidden" name="patientId" value="{{ $patientId ?? '' }}">
								<div class="row justify-content-center">
									<input type="hidden" name="room_type" value="cabin">

									<div class="form-group col-auto">
										<label for="check_in">Check in*</label>
										<input type="text" class="form-control datepicker mt-2 text-center" name="check_in" id="check_in" value="{{ $check_in_date = $check_in_date ?? '' }}" placeholder="Day-Month-Year" required onfocus="clearInput(this)" />
										<select class="form-control mt-2" name="check_in_time" required>
											<option value="" class="text-center">Select time</option>
											@foreach($times as $time)
												<option class="text-center" value="{{$time}}" @if (isset($check_in_time)) {{ $check_in_time == $time ? 'selected' : '' }} @endif>{{$time}}</option>
											@endforeach
										</select>
									</div>
	
									<div class="form-group col-auto">
										<label for="check_out">Check out*</label>
										<input type="text" class="form-control datepicker mt-2 text-center" name="check_out" id="check_out" value="{{ $check_out_date = $check_out_date ?? '' }}" placeholder="Day-Month-Year" required onfocus="clearInput2(this)" />
	
										<select class="form-control mt-2 text-center" name="check_out_time" required>
											<option value="">Select time</option>
											@foreach($times as $time)
												<option class="text-center" value="{{$time}}" @if (isset($check_out_time)) {{ $check_out_time == $time ? 'selected' : '' }} @endif>{{$time}}</option>
											@endforeach
										</select>
									</div>
	
									<div class="form-group col-auto pt-2">
										<button type="submit" class="btn btn-success mt-4"
											{{ isset($disabled) ? 'disabled' : '' }}>
											<i class="fas fa-search nav-icon"></i> &nbsp; Search now
										</button>
									</div>									
								</div>								
							</form>
						</div>

						<div class="form-group col-auto {{ isset($room_type) ? '' : 'hide' }} {{ (isset($room_type) && $room_type == 'cabin') ? 'hide' : '' }}" id="wardStatus">
							<form action="{{ route('admin.booking_search') }}" method="post" data_id="wardAction" enctype="multipart/form-data" class="needs-validation">
								@csrf
								<input type="hidden" name="patientId" value="{{ $patientId ?? '' }}">
								<div class="row justify-content-center">
									<input type="hidden" name="room_type" value="ward">
									<div class="form-group col-auto">
										<label for="check_in">Check in*</label>
										<input type="text" class="form-control datepicker mt-2 text-center" name="check_in" id="check_in2" value="{{ $check_in_date = $check_in_date ?? '' }}" placeholder="Day-Month-Year" required onfocus="clearInput(this)" />
									</div>
	
									<div class="form-group col-auto">
										<label for="check_out">Check out*</label>
										<input type="text" class="form-control datepicker mt-2 text-center" name="check_out"
											id="check_out2" value="{{ $check_out_date = $check_out_date ?? '' }}"
											placeholder="Day-Month-Year" required onfocus="clearInput2(this)" />	
									</div>
	
									<div class="form-group col-auto pt-2">
										<button type="submit" class="btn btn-success mt-4"
											{{ isset($disabled) ? 'disabled' : '' }}>
											<i class="fas fa-search nav-icon"></i> &nbsp; Search now
										</button>
									</div>									
								</div>								
							</form>
						</div>
					</div>
				</fieldset>                          
            </div>            
        </div>

        <!-- Result -->
        <div class="col-md-12">
            @if(isset($room_type) && $room_type == 'cabin')
                <h6 class="card-header bg-success text-center py-1 mx-1">Cabin/room list</h6>
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
                                @php $roomCount = $floor->rooms->where('room_type', 'cabin')->whereIn('room_no', $unBook)->count()  @endphp
                                @if($roomCount == 0) @continue @endif
                                <tr>
                                    <td rowspan="{{($roomCount > 1) ? $roomCount+1 : ''}}">{{$floor->floor}}</td>
                                    @if($roomCount == 1)
                                        @foreach($floor->rooms->where('room_type', 'cabin')->whereIn('room_no', $unBook)->sortBy('room') as $room)
											<td>{{$room->name}}</td>
											<td>
                                                <a href="{{ url('admin/cabin_book', [$check_in, $check_out, $room->id, $patientId]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$room->room_no}}</a>                                               
                                            </td>
                                            <td>{{$room->rent}}</td>
                                        @endforeach
                                    @endif
                                </tr>
                                @if($roomCount > 1)
                                    @foreach($floor->rooms->where('room_type', 'cabin')->whereIn('room_no', $unBook)->sortBy('room') as $room)
                                        <tr>
											<td>{{$room->name}}</td>
                                            <td>
                                                <a href="{{ url('admin/cabin_book', [$check_in, $check_out, $room->id, $patientId]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$room->room_no}}</a>                                               
                                            </td>                                            
                                            <td>{{$room->rent}}</td>
                                        </tr>     
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(isset($room_type) && $room_type == 'ward')
                <h6 class="card-header bg-secondary text-center py-1 mx-1">Ward list</h6>
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
                                @php $wardCount = $room->wards->whereIn('id', $unBook)->count() @endphp

                                @if($wardCount == 0) 
									@continue 
								@endif

                                <tr>
                                    <td rowspan="{{($wardCount > 1) ? $wardCount+1 : ''}}">{{$room->room_no}}</td>
                                    <td rowspan="{{($wardCount > 1) ? $wardCount+1 : ''}}">{{$room->name}}</td>
                                    @if($wardCount == 1)
                                        @foreach($room->wards->whereIn('id', $unBook)->sortBy('id') as $ward)
                                            <td>
                                                <a href="{{ url('admin/ward_book', [$check_in, $check_out, $ward->id, $patientId]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$ward->ward_no}}</a>                                                                                              
                                            </td>
                                            <td>{{$room->rent}}</td>
                                        @endforeach
                                    @endif
                                </tr>
                                
                                @if($wardCount > 1)
                                    @foreach($room->wards->whereIn('id', $unBook)->sortBy('id') as $ward)
                                        <tr>
                                            <td>
                                                <a href="{{ url('admin/ward_book', [$check_in, $check_out, $ward->id, $patientId]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$ward->ward_no}}</a>                                                                                              
                                            </td>
                                            <td>{{$room->rent}}</td>
                                        </tr>
                                    @endforeach
                                @endif
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
    <script type="text/javascript">
        function clearInput(target){
            if (target.value== '{{$check_in_date}}'){
                target.value= "";
            }
        }

        function clearInput2(target){
            if (target.value== '{{$check_out_date}}'){
                target.value= "";
            }
        }
    </script>
	
	<script>
		// Bed search dependency
		$("#cabin").click(function () {
			var chkFormationDept = document.getElementById("cabin").checked;
			if (chkFormationDept) {
				$('#cabinStatus [data_id="cabinAction"]').parent().removeClass('active').css('display', 'block');
				$('#wardStatus [data_id="wardAction"]').parent().removeClass('active').css('display', 'none');
			}
		})
		$("#ward").click(function () {
			var chkFormationDept = document.getElementById("ward").checked;
			if (chkFormationDept) {
				$('#cabinStatus [data_id="cabinAction"]').parent().removeClass('active').css('display', 'none');
				$('#wardStatus [data_id="wardAction"]').parent().removeClass('active').css('display', 'block');
			}
		})
	</script>
@endsection
