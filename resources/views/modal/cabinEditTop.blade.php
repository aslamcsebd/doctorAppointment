
<a href="javascript:;" class="btn btn-sm btn-outline-primary px-3 cabinEdit" data-toggle="modal" 
    data-target="#cabinEdit"
    data-id="{{ $room->id }}"
    data-name="{{ $room->name }}"
    data-room_no="{{ $room->room_no }}"
    data-rent="{{ $room->rent }}"
>View</a>
<a href="{{ url('itemDelete', ['rooms', $room->id, 'tabName'])}}" class="btn btn-sm btn-danger py-1" onclick="return confirm('Are you want to delete this?')">Delete</a>
