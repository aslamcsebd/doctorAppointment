<?php

namespace App\Http\Controllers;

use Redirect;

use App\Models\Room;
use App\Models\User;
use App\Models\Ward;

use App\Models\Floor;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    // Room info
    public function room(){
        $data['floors'] = Floor::all();       
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        return view('room.index', $data);
    }

    // Create room
    public function addRoom(Request $request){
               
        $validator = Validator::make($request->all(),[
            'room_type'=>'required',     
            'name'=>'required',
            'floor_id'=>'required',
            'room_no'=>'required',
            'rent'=>'required',
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        $room_id = Room::insertGetId([
            'room_type' => $request->room_type,
            'name' => $request->name,
            'floor_id' => $request->floor_id,
            'room_no' => $request->room_no,
            'rent' => $request->rent             
        ]);
        
        if($request->room_type=='ward'){
            for($i=1; $i<=$request->bedCount; $i++){
                Ward::Create([
                    'room_id' => $room_id,
                    'ward_no' => 'W-'.$i           
                ]);
            }
        }
       
        $tab = "addRoomTab";
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
