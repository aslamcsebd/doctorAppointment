@extends('layouts.app')
@section('title')
    Room-seat
@endsection
@section('content')
    @include('includes.alertMessage')
    <div class="content-wrapper p-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border border-danger">
                    <div class="card-header px-1 pt-1 pb-0 border-bottom-0">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active btn-sm py-1 m-1" data-toggle="pill" href="#allRoom">All room</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-sm py-1 m-1" data-toggle="pill" href="#editRoom">Edit room</a>
                            </li>
                            @include('modal.floorRoomTop')
                        </ul>
                    </div>
        
                    <div class="modal-body p-1">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="allRoom">
                                <h6 class="card-header bg-success text-center py-1 mx-1 mb-0">Cabin/room list</h6>
                                <div class="card-body p-1">
                                    <table class="table table-bordered">
                                        <thead class="bg-info">
                                            <th>Floor</th>
                                            <th>Room name</th>
                                            <th>Room no</th>
                                            <th>Rent</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($floors as $floor)
                                                @php $roomCount = $floor->rooms->where('room_type', 'cabin')->count()  @endphp
            
                                                <tr>
                                                    <td rowspan="{{ $roomCount > 1 ? $roomCount + 1 : '' }}">{{ $floor->floor }}</td>
                                                    @if ($roomCount == 1)
                                                        @foreach ($floor->rooms->where('room_type', 'cabin')->sortBy('room') as $room)
                                                            <td>{{ $room->name }}</td>
                                                            <td>{{ $room->room_no }}</td>
                                                            <td>{{ $room->rent }}</td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                                @if ($roomCount > 1)
                                                    @foreach ($floor->rooms->where('room_type', 'cabin')->sortBy('room') as $room)
                                                        <tr>
                                                            <td>{{ $room->name }}</td>
                                                            <td>{{ $room->room_no }}</td>
                                                            <td>{{ $room->rent }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
            
                                <h6 class="card-header bg-secondary text-center py-1 mx-1 mt-2">Ward list</h6>
                                <div class="card-body p-1">
                                    <table class="table table-bordered">
                                        <thead class="bg-info">
                                            <th>Room no</th>
                                            <th>Room name</th>
                                            <th>Ward no</th>
                                            <th>Rent</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($roomWards as $room)
                                                @php $wardCount = $room->wards->count()  @endphp
            
                                                <tr>
                                                    <td rowspan="{{ $wardCount > 1 ? $wardCount + 1 : '' }}">{{ $room->room_no }}</td>
                                                    <td rowspan="{{ $wardCount > 1 ? $wardCount + 1 : '' }}">{{ $room->name }}</td>
                                                </tr>
                                                @if ($wardCount > 1)
                                                    @foreach ($room->wards->sortBy('ward_no') as $ward)
                                                        <tr>
                                                            <td>{{ $ward->ward_no }}</td>
                                                            <td>{{ $room->rent }}</td>                                                
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        
                            <div class="tab-pane fade show" id="editRoom">
                                <h6 class="card-header bg-secondary text-center py-1 mx-1 mb-0">All room list</h6>
                                <div class="card-body p-1">
                                    <table class="table table-bordered">
                                        <thead class="bg-info">
                                            <th>Floor</th>
                                            <th>Room type</th>
                                            <th>Room name</th>
                                            <th>Room no</th>
                                            <th>Rent</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($floors as $floor)
                                                @php $roomCount = $floor->rooms->count()  @endphp            
                                                <tr>
                                                    <td rowspan="{{ $roomCount > 1 ? $roomCount + 1 : '' }}">{{ $floor->floor }}</td>
                                                    @if ($roomCount == 1)
                                                        @foreach ($floor->rooms->sortBy('room') as $room)
                                                            <td>{{ $room->room_type }}</td>
                                                            <td>{{ $room->name }}</td>
                                                            <td>{{ $room->room_no }}</td>
                                                            <td>{{ $room->rent }}</td>
                                                            
                                                            <td width="auto">
                                                                @include('modal.cabinEditTop')
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                                @if ($roomCount > 1)
                                                    @foreach ($floor->rooms->sortBy('room') as $room)
                                                        <tr>
                                                            <td>{{ $room->room_type }}</td>
                                                            <td>{{ $room->name }}</td>
                                                            <td>{{ $room->room_no }}</td>
                                                            <td>{{ $room->rent }}</td>
                                                            <td width="auto">
                                                                @include('modal.cabinEditTop')
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.floorRoomButtom')
    @include('modal.cabinEditButtom')
@endsection

@section('js')
    <script>
        $('.cabinEdit').click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var room_no = $(this).data('room_no');
            var rent = $(this).data('rent');

            $('#id').val(id);
            $('#name2').val(name);
            $('#room_no2').val(room_no);
            $('#rent2').val(rent);
        });
    </script>
@endsection
