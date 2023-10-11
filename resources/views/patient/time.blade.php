
@php
    $times = App\Models\AppointmentTime::where('status', 1)->pluck('time')->toArray()
@endphp

@if($route=='appointment.list')
    <select class="form-control col-3 ml-2" name="time" id="time" disabled>
        <option value="">Select time</option>
        @foreach($times as $time)
            <option value="{{$time}}" {{$appointmentDate->time == $time ? 'selected' : ''}}>{{$time}}</option>
        @endforeach
    </select>
@elseif($route=='appointment.request')
    <select class="form-control col-3 ml-2" name="time" id="time" {{$appointmentDate->status == 1 ? 'disabled' : ''}}>
        <option value="">Select time</option>
        @foreach($times as $time)
            <option value="{{$time}}" {{$appointmentDate->time == $time ? 'selected' : ''}}>{{$time}}</option>
        @endforeach
    </select>
@else
    <select class="form-control col-3 ml-2" name="time" id="time" required>
        <option value="">Select time</option>
        @foreach($times as $time)
            <option value="{{$time}}">{{$time}}</option>
        @endforeach
    </select>
@endif
