<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Room;
use App\Models\Ward;
use App\Models\Floor;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\WardBooking;
use App\Models\CabinBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            'due'=>'required'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        Payment::where('id', $request->payment_id)->update([
            'due' => $request->due,
            'status' => 1,
        ]);
        return redirect()->route('payment')->with('success','Payment add successfully');
    }

    // Booking list
    public function booking() {         
        $data['floors'] = Floor::all();       
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        $allColumns = array_keys(json_decode(Patient::first(), true));
        $data['needed_columns'] = array_diff($allColumns, ['id', 'user_id', 'patient_id', 'status', 'created_at', 'updated_at']);

        return view('patient.booking', $data);
    }
    
    // Booking search
    public function booking_search(Request $request){
        $validator = Validator::make($request->all(),[            
            'room_type'=>'required',
            'check_in'=>'required|date',
            'check_out'=>'required|date|after:check_in'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
        
        $data['room_type'] = $request->room_type;

        $data['check_in'] = $request->check_in;
        $data['check_out'] = $request->check_out;

        $check_in = date('Y-m-d', strtotime($data['check_in']));
        $check_out = date('Y-m-d', strtotime($data['check_out']));

        if($data['room_type'] == 'cabin'){
            $rooms = Room::where('room_type', 'cabin')->orderBy('room_no', 'Asc')->pluck('room_no');
              
            $booked = CabinBooking::where([
                ['cabin_bookings.check_in', '<=', $check_in],
                ['cabin_bookings.check_out', '>=', $check_in]
            ])
            ->orwhere([
                ['cabin_bookings.check_in', '>=', $check_out],
                ['cabin_bookings.check_out', '<=', $check_out]
            ])->pluck('room_no');
            
            $data['unBook'] = $rooms->diff($booked);

        } else {
            $wards = Ward::pluck('id');
            $booked = WardBooking::where([
                ['ward_bookings.check_in', '<=', $check_in],
                ['ward_bookings.check_out', '>=', $check_out]
            ])
            ->orwhere([
                ['ward_bookings.check_in', '>=', $check_in],
                ['ward_bookings.check_out', '<=', $check_out]
            ])->pluck('ward_id');
            $data['unBook'] = $wards->diff($booked);
        }
   
        $data['floors'] = Floor::all();
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        return view('patient.booking', $data);
    }

    // Cabin booking info
    public function cabin_book($check_in, $check_out, $id){
        $data['check_in'] = $check_in;       
        $data['check_out'] = $check_out;

        $in = new DateTime($check_in);
        $out = new DateTime($check_out);
        
        $data['totalNight'] = $out->diff($in)->format('%d');
       
        $data['room'] = Room::find($id);

        return view('patient.cabinBookingView', $data);
    }

    // Ward booking info
    public function ward_book($check_in, $check_out, $id){
        $data['check_in'] = $check_in;       
        $data['check_out'] = $check_out;

        $in = new DateTime($check_in);
        $out = new DateTime($check_out);
        
        $data['totalNight'] = $out->diff($in)->format('%d');
       
        $data['ward'] = Ward::find($id);
        // dd($data['ward']->roomNo->room_no);

        return view('patient.wardBookingView', $data);
    }

    // Booking now [Cabin]
    public function bookingNow(Request $request){
        $validator = Validator::make($request->all(),[            
            'id'=>'required',
            'room_no'=>'required',
            'check_in'=>'required|date',
            'check_out'=>'required|date',
            'rent'=>'required',
            'totalRent'=>'required',
            'advance'=>'required'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
        
        CabinBooking::create([
            'patient_id' => Auth::id(),
            'check_in' => date('Y-m-d', strtotime($request->check_in)),
            'check_out' => date('Y-m-d', strtotime($request->check_out)),
            'room_no' => $request->room_no,
            'rent' => $request->rent,
        ]);

        return Redirect('booking-list')->with('success', 'Booking complete successfully');
    }

    // Booking now [Ward]
    public function bookingNow2(Request $request){
        $validator = Validator::make($request->all(),[            
            'id'=>'required',
            'check_in'=>'required|date',
            'check_out'=>'required|date',
            'rent'=>'required',
            'totalRent'=>'required',
            'advance'=>'required'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
        
        WardBooking::create([
            'patient_id' => Auth::id(),
            'check_in' => date('Y-m-d', strtotime($request->check_in)),
            'check_out' => date('Y-m-d', strtotime($request->check_out)),
            'ward_id' => $request->id,
            'rent' => $request->rent,
        ]);

        return Redirect('booking-list')->with('success', 'Booking complete successfully');
    }
}
