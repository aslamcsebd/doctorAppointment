
@php
    $times = array(
        '8:30 AM',
        '8:45 AM',
        '9:00 AM',
        '9:15 AM',
        '9:30 AM',
        '9:45 AM',
        '10:00 AM',
        '10:15 AM',
        '10:30 AM',
        '10:45 AM',
        '11:00 AM',
        '11:15 AM',
        '11:30 AM',
        '11:45 AM',
        '12:00 PM',
        '12:15 PM',
        '12:30 PM',
        '12:45 PM',
        '01:00 PM',
        '01:15 PM',
        '01:30 PM',
        '01:45 PM',
        '02:00 PM'    
    );
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
    <select class="form-control col-3 ml-2" name="time" id="time">
        <option value="">Select time</option>
        @foreach($times as $time)
            <option value="{{$time}}">{{$time}}</option>
        @endforeach
    </select>
@endif
