@extends('layouts.app')
   @section('title') Room-seat @endsection
@section('content')
@include('includes.alertMessage')

<div class="content-wrapper p-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-body p-1">
                <form action="{{ route('booking_search') }}" method="post" enctype="multipart/form-data" class="needs-validation" >
                    @csrf
                    <fieldset class="form-group pt-2 mb-1">
                        <legend class="mb-0">Select room type</legend>
                        <div class="row justify-content-center">

                            <div class="form-group col-md-3">
                                <label for="start">Bed type*</label>
                                <div class="border border-secondary rounded p-1 mt-2">
                                    <div class="radio-toolbar form-check form-check-inline">
                                        <div class="radio">
                                            <input type="radio" id="cabin" name="room_type" value="cabin" @if(isset($room_type)) {{ $room_type == 'cabin' ? 'checked' : '' }} @endif>
                                            <label for="cabin">Cabin/room</label>
                                        </div>
                                        <div class="radio ml-3 mt-1">
                                            <input type="radio" id="ward" name="room_type" value="ward" @if(isset($room_type)) {{ $room_type == 'ward' ? 'checked' : '' }} @endif>
                                            <label for="ward">Ward(bed)</label> 
                                        </div>
                                    </div>
                                </div> 
                            </div>
            
                            <div class="form-group col-md-2">
                                <label for="check_in">Check in*</label>
                                <input type="text" class="form-control datepicker mt-2" name="check_in" id="check_in" value="{{$check_in ?? ''}}" placeholder="Day-Month-Year" required/>                            
                            </div>

                            <div class="form-group col-md-2">
                                <label for="check_out">Check out*</label>
                                <input type="text" class="form-control datepicker mt-2" name="check_out" id="check_out" value="{{$check_out ?? ''}}" placeholder="Day-Month-Year" required/>                            
                            </div>

                            <div class="form-group col-md-2 pt-2">
                                <button type="submit" class="btn btn-success mt-4">
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
                                                <a href="{{ url('cabin_book', [$check_in, $check_out, $room->id]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$room->room_no}}</a>                                               
                                            </td>
                                            <td>{{$room->rent}}</td>
                                        @endforeach
                                    @endif
                                </tr>
                                @if($roomCount > 1)
                                    @foreach($floor->rooms->where('room_type', 'cabin')->whereIn('room_no', $unBook)->sortBy('room') as $room)
                                        <tr>
                                            <td>
                                                <a href="{{ url('cabin_book', [$check_in, $check_out, $room->id]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$room->room_no}}</a>                                               
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
                                        @foreach($room->wards->whereIn('id', $unBook)->sortBy('ward_no') as $ward)
                                            <td>
                                                <a href="{{ url('ward_book', [$check_in, $check_out, $ward->id]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$ward->ward_no}}</a>                                                                                              
                                            </td>
                                            <td>{{$room->rent}}</td>
                                        @endforeach
                                    @endif
                                </tr>
                                
                                @if($wardCount > 1)
                                    @foreach($room->wards->whereIn('id', $unBook)->sortBy('ward_no') as $ward)
                                        <tr>
                                            <td>
                                                <a href="{{ url('ward_book', [$check_in, $check_out, $ward->id]) }}" class="btn btn-sm btn-primary px-4" title="Click now for booking">{{$ward->ward_no}}</a>                                                                                              
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
@endsection
