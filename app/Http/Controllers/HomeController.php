<?php

namespace App\Http\Controllers;
use DB;

use App\Models\Room;
use App\Models\User;
use App\Models\Ward;
use App\Models\Floor;
use App\Models\Doctor;
use App\Models\Report;
use App\Models\Patient;

use App\Models\Payment;
use App\Models\Appointment;
use App\Models\PatientForm;
use App\Models\WardBooking;
use App\Models\CabinBooking;
use Illuminate\Http\Request;
use App\Models\FavouriteDoctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller {
       
	public function index(){
        $data['doctors'] = Doctor::all();
		return view('welcome', $data);
	}

	public function appointment_create(Request $request) {	
		$validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:patient_forms',
            'phone'=>'required',
            'age'=>'required',
            'doctor_id'=>'required',
            'appointment_date'=>'required',
            'diseases_info'=>'required',
            'address'=>'required'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
    
        PatientForm::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => date('Y-m-d', strtotime($request->appointment_date)),
            'diseases_info' => $request->diseases_info,
            'address' => $request->address,
        ]);     
        return back()->with('success', 'Patient appointment form fillup successfully');
	}

    public function index2(){
		if(Auth::check() == false){			
			return Redirect::route('login');		
		}

        // Admin
        $data['doctors'] = Doctor::all();
        $data['patients'] = Patient::all();

        $data['floors'] = Floor::all();
        $data['cabins'] = Room::where('room_type', 'cabin')->get();
        $data['wards'] = Ward::all();

        $data['payments'] = Payment::where('status', 0)->get();
 
        if(Auth::user()->role=='3' && Auth::user()->password == null){
            return redirect('/set-password')->with('success', 'Patient\'s registration complete'); 
        }

        // Doctor
        $data['Appointment'] = Appointment::where('doctor_id', Auth::id())->where('status', '0')->get();
        $data['patientReport'] = Report::where('doctor_id', Auth::id())->get()->groupBy('patient_id');   

        // Patient
        $data['favouriteDoctor'] = FavouriteDoctor::where('patient_id', Auth::id())->get();
        $data['appointmentReq'] = Appointment::where('patient_id', Auth::id())->where('status', '0')->get();

        $data['cabinBooking'] = CabinBooking::where('patient_id', Auth::id())->get();
        $data['wardBooking'] = WardBooking::where('patient_id', Auth::id())->get();

        $data['report'] = Report::where('patient_id', Auth::id())->get();
        
        return view('home', $data);
    }

    // Status change
    public function changeStatus(Request $request){
        $model = $request->model;
        $field = $request->field;
        $id = $request->id;
        $tab = $request->tab;

        $itemId = DB::table($model)->find($id);
        ($itemId->$field == true) ? $action=$itemId->$field = false : $action=$itemId->$field = true;     
        DB::table($model)->where('id', $id)->update([$field => $action]);
        return response()->json(['message' => 'Status updated successfully.']);
    }

    // Delete
    public function itemDelete($model, $id, $tab){
        $itemId = DB::table($model)->find($id);
        if (Schema::hasColumn($model, $column='photo')){
            ($itemId->$column!=null) ? (file_exists($itemId->$column) ? unlink($itemId->$column) : '') : '';
        }
        DB::table($model)->where('id', $id)->delete();
        return back()->with('success', $model.' delete successfully')->withInput(['tab' => $tab]);
    }

}
