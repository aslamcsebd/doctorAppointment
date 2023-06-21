<?php

namespace App\Http\Controllers;

use Redirect;

use App\Models\Room;
use App\Models\User;
use App\Models\Floor;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    // Room info
    public function room(){
        $data['floors'] = Floor::all();       
        $data['singlrRooms'] = User::all();

        return view('room.index', $data);
    }

    // Create room
    public function addRoom(Request $request){
               
        $validator = Validator::make($request->all(),[
            'floor'=>'required',
            'room'=>'required'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }  

        $rooms = $request->input('room');
        foreach ($rooms as $room){
            Room::create([
                'floor_id' => $request->floor,
                'room' => $room
            ]);
        }
        $tab = "floorRoom";
        return back()->with('success', 'Floor\'s rooms added')->withInput(['tab' => $tab]);
    }

    // Create floor
    public function addFloor(Request $request){               
        $validator = Validator::make($request->all(),[
            'floor'=>'required|unique:floors'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }  

        Floor::create([
            'floor' => $request->floor
        ]);

        return back()->with('success', $request->floor.' floor add successfully');
    }
}
