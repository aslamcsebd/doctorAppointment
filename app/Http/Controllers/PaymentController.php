<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Ward;
use App\Models\Floor;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\WardBooking;
use App\Models\CabinBooking;
use App\Models\HospitalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    // Payment list
    public function payment(){
        $data['payments'] = Payment::orderBy('id', 'DESC')->get();
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

    // Invoice view
    public function invoice_view($id){
        $data['hospital'] = HospitalInfo::first();
        $data['payment'] = Payment::find($id);
        
        if($data['payment']->room_type == 'cabin'){
            $cabin = CabinBooking::where('tran_id', $data['payment']->tran_id)->get();
        }
        else{
            $ward = WardBooking::where('tran_id', $data['payment']->tran_id)->get();
        }
        // return view('payment.pdf', $data);
        return view('payment.invoice', $data);
    }

    // Booking list
    public function booking(){     
        $data['floors'] = Floor::all();       
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        $allColumns = array_keys(json_decode(Patient::first(), true));
        $data['needed_columns'] = array_diff($allColumns, ['id', 'user_id', 'patient_id', 'photo', 'status', 'created_at', 'updated_at']);

        return view('patient.booking', $data);
    }
    
    // Booking search
    public function booking_search(Request $request){
        // dd($request->all());

		$data['room_type'] = $request->room_type;
		if($data['room_type'] == 'cabin'){
			$validator = Validator::make($request->all(),[            
				'room_type'=>'required',
				'check_in'=>'required|date',
				'check_in_time'=>'required',
				'check_out'=>'required|date|after_or_equal:check_in',
				'check_out_time'=>'required'
			]);

			if($request->check_in == $request->check_out && $request->check_in_time >= $request->check_out_time){
				$messages = 'In same day checkout time must be big than checkin time';
				return Redirect::back()->withErrors($messages);
			}

			$check_in = date('Y-m-d H:s:i', strtotime($request->check_in . $request->check_in_time));
			$check_out = date('Y-m-d H:s:i', strtotime($request->check_out . $request->check_out_time));
		}
		else{
			$validator = Validator::make($request->all(),[            
				'room_type'=>'required',
				'check_in'=>'required|date',
				'check_out'=>'required|date|after_or_equal:check_in',
			]);

			$check_in = date('Y-m-d', strtotime($request->check_in));
			$check_out = date('Y-m-d', strtotime($request->check_out));
		}
        
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
       
        $data['check_in'] = $check_in;
        $data['check_out'] = $check_out;

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
        } 
		else{
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
    public function cabin_book($check_in, $check_out, $id) {
        $data['check_in'] =   Carbon::createFromFormat('Y-m-d H:s:i', $check_in);        
        $data['check_out'] = Carbon::createFromFormat('Y-m-d H:s:i', $check_out);
        $data['totalHour'] = $data['check_in']->diffInHours($data['check_out']);
       
        $data['room'] = Room::find($id);
        return view('patient.cabinBookingView', $data);
    }

    // Ward booking info
    public function ward_book($check_in, $check_out, $id){
        $data['check_in'] =   Carbon::createFromFormat('Y-m-d', $check_in);        
        $data['check_out'] = Carbon::createFromFormat('Y-m-d', $check_out);
        $data['totalDay'] = $data['check_in']->diffInDays($data['check_out']);
        
        $data['ward'] = Ward::find($id);
        return view('patient.wardBookingView', $data);
    }

    // Payment search
    public function payment_search(Request $request){
        $validator = Validator::make($request->all(),[            
            'check_in'=>'required|date',
            'check_out'=>'required|date|after_or_equal:check_in',
        ]);
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        $data['check_in'] = $check_in = date('Y-m-d', strtotime($request->check_in));
        $data['check_out'] = $check_out = date('Y-m-d', strtotime($request->check_out));

        $cabin = Payment::join('cabin_bookings', 'cabin_bookings.tran_id', '=', 'payments.tran_id')
            ->whereDate('check_in', '>=', $check_in)
            ->whereDate('check_in', '<=', $check_out)
            ->where('payments.status', '=', 1)
            ->pluck('cabin_bookings.tran_id')->toArray();
        
        $ward = Payment::join('ward_bookings', 'ward_bookings.tran_id', '=', 'payments.tran_id')
            ->whereDate('check_in', '>=', $check_in)
            ->whereDate('check_in', '<=', $check_out)
            ->where('payments.status', '=', 1)
            ->pluck('ward_bookings.tran_id')->toArray();

        $paid = collect($cabin)->concat($ward)->toArray();
        $data['payments'] = Payment::whereIn('tran_id', $paid)->get();
        return view('payment.paymentList', $data);
    }
}