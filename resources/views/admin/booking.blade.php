@extends('layouts.app')
    @section('title') Room-seat @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
    <div class="row justify-content-center">

        <?php 
            if(isset($room_type)) {
                $check_in_date = date('Y-m-d', strtotime($check_in));
                $check_in_time = date('h:i a', strtotime($check_in));

                $check_out_date = date('Y-m-d', strtotime($check_out));
                $check_out_time = date('h:i a', strtotime($check_out));
            }
        ?>

        <div class="col-md-12">
            <div class="card-body p-1">
                <form action="{{ route('admin.booking_search') }}" method="post" enctype="multipart/form-data" class="needs-validation">
                    @csrf
                    <input type="hidden" name="patientId" value="{{ $patientId ?? '' }}">

                    <fieldset class="form-group pt-2 mb-1">
                        <legend class="mb-0">Select room type</legend>
                        <div class="row justify-content-center">

                            <div class="form-group col-auto">
                                <label for="start">Bed type*</label>
                                <div class="border border-secondary rounded p-1 mt-2">
                                    <div class="radio-toolbar form-check form-check-inline">
                                        <div class="radio m-1">
                                            <input type="radio" id="cabin" name="room_type" value="cabin" @if(isset($room_type)) {{ $room_type == 'cabin' ? 'checked' : '' }} @endif required>
                                            <label for="cabin">Cabin/room</label>
                                        </div>
                                        <div class="radio m-1">
                                            <input type="radio" id="ward" name="room_type" value="ward" @if(isset($room_type)) {{ $room_type == 'ward' ? 'checked' : '' }} @endif required>
                                            <label for="ward">Ward(bed)</label> 
                                        </div>
                                    </div>
                                </div> 
                            </div>
            
                            <div class="form-group col-auto">
                                <label for="check_in">Check in*</label>
                                <input type="text" class="form-control datepicker mt-2 text-center" name="check_in" id="check_in" value="{{$check_in_date = $check_in_date ?? ''}}" placeholder="Day-Month-Year" required onfocus= "clearInput(this)"/>                            
                            
                                <select class="form-control mt-2" name="check_in_time">
                                    <option value="" class="text-center">Select time</option>
                                    <?php $hour = 0; ?>
                                    @while($hour++ < 24)
                                        <?php $time = date('h:i a',mktime($hour,0,0,1,1,date('Y'))); ?>
                                        <option class="text-center" value="{{$time}}" @if(isset($check_in_time)) {{$check_in_time == $time ? 'selected' : ''}} @endif>{{$time}}</option>
                                    @endwhile
                                </select>
                            </div>

                            <div class="form-group col-auto">
                                <label for="check_out">Check out*</label>
                                <input type="text" class="form-control datepicker mt-2 text-center" name="check_out" id="check_out" value="{{$check_out_date = $check_out_date ?? ''}}" placeholder="Day-Month-Year" required onfocus= "clearInput2(this)"/>                            
                           
                                <select class="form-control mt-2 text-center" name="check_out_time">
                                    <option value="">Select time</option>
                                    <?php $hour = 0; ?>
                                    @while($hour++ < 24)
                                        <?php $time = date('h:i a',mktime($hour,0,0,1,1,date('Y'))); ?>
                                        <option class="text-center" value="{{$time}}" @if(isset($check_out_time)) {{$check_out_time == $time ? 'selected' : ''}} @endif>{{$time}}</option>
                                    @endwhile
                                </select>
                            </div>

                            <div class="form-group col-auto pt-2">
                                <button type="submit" class="btn btn-success mt-4" {{ isset($disabled) ? 'disabled' : '' }}>
                                    <i class="fas fa-search nav-icon"></i> &nbsp; Search now
                                </button>
                            </div>   
                        </div>
                    </fieldset>
                </form>                                      
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
                            <th>Ward no</th>
                            <th>Rent</th>
                        </thead>
                        <tbody>
                            @foreach($roomWards as $room)
                                @php $wardCount = $room->wards->whereIn('id', $unBook)->count() @endphp

                                @if($wardCount == 0) @continue @endif

                                <tr>
                                    <td rowspan="{{($wardCount > 1) ? $wardCount+1 : ''}}">{{$room->room_no}}</td>
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
@endsection
