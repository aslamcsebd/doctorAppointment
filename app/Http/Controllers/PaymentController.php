<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Room;
use App\Models\Floor;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    // Payment list
    public function payment(){
        $data['payments'] = Payment::all();
        return view('payment.payment', $data);
    }

    // Patient payment view
    public function paymentView($id){
        $data['payment'] = Payment::find($id);        
        return view('payment.view', $data);
    }

    // Create doctor account
    public function payment_add(Request $request){

        $validator = Validator::make($request->all(),[            
            'payment_id'=>'required',
            'sub_total'=>'required'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        Payment::where('id', $request->payment_id)->update([
            'sub_total' => $request->sub_total,
            'status' => 1,
        ]);
        return redirect()->route('payment')->with('success','Payment add successfully');
    }

    // Booking list
    public function booking(){         
        $data['floors'] = Floor::all();       
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        return view('patient.booking', $data);
    }
    
    // Booking search
    public function booking_search(Request $request){

        $validator = Validator::make($request->all(),[            
            'room_type'=>'required',
            'check_in'=>'required|date|after:now',
            'check_out'=>'required|date|after:check_in'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        $check_in = date('Y-m-d', strtotime($request->check_in));
        $check_out = date('Y-m-d', strtotime($request->check_out));

        // $in = new DateTime($request->check_in);
        // $out = new DateTime($request->check_out);
        // $d = $out->diff($in);

        // dd($request->check_in);
        $data['room_type'] = $request->room_type;  
        /*
        $booking = DB::table('rooms')
            ->leftjoin('bookings','bookings.bed_no','=','rooms.room_no')->select('bed_no')
            ->where([
                ['bookings.check_in', '<', $check_in],
                ['bookings.check_out', '<', $check_out]
            ])
            ->orwhere([
                ['bookings.check_in', '>', $check_in],
                ['bookings.check_out', '>', $check_out]
            ])
            ->get();        
        */

        $data['floors'] = Floor::all(); 
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        return view('patient.booking', $data);
    }
}
