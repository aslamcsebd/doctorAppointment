<?php

namespace App\Http\Controllers;

use Redirect;

use App\Models\Room;
use App\Models\User;
use App\Models\Ward;

use App\Models\Floor;
use App\Models\Doctor;
use App\Models\Payment;
use App\Models\WardBooking;
use App\Models\CabinBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    // Room info
    public function room(){
        $data['floors'] = Floor::all();       
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        return view('admin.rooms', $data);
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

    // Cabin booking
    public function cabin_booking(){ 
        $data['cabines'] = CabinBooking::all();
        return view('admin.cabinBooking', $data);
    }

    // Booking-view
    public function booking_view($id, $type, $route, $tab){
        if($type=='cabin'){
            $data['booking'] = CabinBooking::find($id);
        }else{
            $data['booking'] = WardBooking::find($id);
        }

        $data['type'] = $type;
        $data['route'] = $route;
        $data['tab'] = $tab;
        $data['advance'] = Payment::where('tran_id', $data['booking']->tran_id)->get()->first()->advance;
        return view('admin.bookingView', $data);
    }

    // Booking complete
    public function bookingComplete(Request $request){ 
        $validator = Validator::make($request->all(),[            
            'check_in'=>'required|date',
            'check_out'=>'required|date|after_or_equal:check_in'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        if($request->type=='cabin'){
            CabinBooking::where('id', $request->id)->update([
                'check_out' => date('Y-m-d', strtotime($request->check_out))
            ]);

        }else{

            WardBooking::where('id', $request->id)->update([
                'check_out' => date('Y-m-d', strtotime($request->check_out)),
            ]);
        }

        Payment::where('tran_id', $request->tran_id)->update([
            'due' => $request->due,
            'status' => 1
        ]);
        
        return redirect()->route($request->route)->with('success','All information update successfully');
    }

    // Ward booking
    public function ward_booking(){ 
        $data['wards'] = WardBooking::all();
        return view('admin.wardBooking', $data);
    }
}
