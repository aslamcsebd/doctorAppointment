<?php

namespace App\Http\Controllers;
use Redirect;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Report;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\WardBooking;
use App\Models\CabinBooking;
use Illuminate\Http\Request;

use App\Models\FavouriteDoctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    // Show all doctor
    public function doctor_search(){
        $data['doctors'] = Doctor::where('status', 1)->with('user')->get();
        return view('patient.doctors', $data);
    }

    // View doctor full info
    public function singleDoctor($id, $route){
        if($route=='appointment.list'){
            $data['appointmentDate'] = Appointment::where('patient_id', Auth::id())->where('doctor_id', $id)->first();
        }    
        $data['route'] = $route;
        $data['doctor'] = Doctor::where('user_id', $id)->first();

        $allColumns = array_keys(json_decode(Patient::first(), true));
        $data['needed_columns'] = array_diff($allColumns, ['id', 'user_id', 'patient_id', 'status', 'created_at', 'updated_at']);

        return view('patient.view', $data);
    }

    // Add favourite doctor
    public function addFavourite($id){
        FavouriteDoctor::Create([
            'patient_id' => Auth::id(),
            'doctor_id' => $id
        ]);
        return back()->with('success', 'Favourite doctor add successfully');
    }
 
    // Show favourite list
    public function favourite_list(){
        $data['doctors'] = FavouriteDoctor::where('patient_id', Auth::id())->with('user')->get();
        return view('patient.favouriteDoctors', $data);
    }

    // Search appointment date
    public function search_date(Request $request)
    {
        $allTime = array('8:30 AM', '8:45 AM', '9:00 AM', '9:15 AM', '9:30 AM', '9:45 AM', '10:00 AM', '10:15 AM', '10:30 AM', '10:45 AM', '11:00 AM', '11:15 AM', '11:30 AM', '11:45 AM', '12:00 PM', '12:15 PM', '12:30 PM', '12:45 PM', '01:00 PM', '01:15 PM', '01:30 PM', '01:45 PM', '02:00 PM');
        $booked = Appointment::where('patient_id', Auth::id())->where('doctor_id', $request->doctorId)->where('date', date('Y-m-d', strtotime($request->date)))->pluck('time')->toArray();
        
        $unBook = array_diff($allTime, $booked);
        return response()->json($unBook);
    }

    // Add appointment
    public function appointment_add(Request $request){   
        Appointment::Create([            
            'appointment_id' => uniqid(),
            'patient_id' => Auth::id(),
            'doctor_id' => $request->user_id,
            'date' => date('Y-m-d', strtotime($request->date)),
            'time' => $request->time
        ]);
        return back()->with('success', 'Appointment add successfully');
    }

    // Show appointment list
    public function appointment_list(){
        $data['appointments'] = Appointment::where('patient_id', Auth::id())->with('user')->get();
        return view('patient.appointments', $data);
    }

    // Show appointment list
    public function report_list(){
        $data['reports'] = Report::where('patient_id', Auth::id())->with('user')->orderBy('id', 'DESC')->get()->groupBy('doctor_id');
        return view('patient.reports', $data);
    }

    // Report view
    public function report_view($id){ 
        $data['user'] = User::find($id);
        $data['reports'] = Report::where('patient_id', Auth::id())->where('doctor_id', $id)->orderBy('id', 'DESC')->get();
        return view('patient.reportView', $data);
    }        

    // Patient profile
    public function patientInfo(){
        $data['patientInfo'] = Patient::where('user_id', Auth::id())->with('user')->first();
        return view('patient.settings', $data);
    }   

    // Update patient info 
    public function updatePatientInfo(Request $request){
        
        $path="images/patient/";
        if ($request->hasFile('photo')){                
            $validator = Validator::make($request->all(),[
                'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg'
            ]);

            if($validator->fails()){
                $messages = $validator->messages();
                return Redirect::back()->withErrors($validator);
            }

            if($files=$request->file('photo')){
                $photo = $request->photo;
                $fullName=time().".".$photo->getClientOriginalExtension();
                $files->move(public_path($path), $fullName);
                $photoLink = $path . $fullName;
            }
        }else{
            $photoLink =$request->oldPhoto;
        }

        User::where('id', $request->user_id)->where('phone', null)->update([
            'phone' => $request->phone
        ]);

        Patient::where('id', $request->id)->update([
            'gender' => $request->gender,
            'blood' => $request->blood,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'photo' => $photoLink,
            'source' => $request->source,
            'address' => $request->address
        ]);
        return back()->with('success','Patient info update successfully');
    }

    // Password set page
    public function setPassword(){
        $data['patientInfo'] = User::find(Auth::id());
        return view('patient.setPassword', $data);
    }   

    // Add hospital info 
    public function setPasswordNow(Request $request){
        $validator = Validator::make($request->all(),[
            'id'=>'required',
            'password'=>['required', 'string', 'min:3', 'confirmed'],
            'password_confirmation'=>'required|same:password'
        ]);

        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        User::where('id', $request->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect('/home')->with('success','Password set successfully');
    }

    // Report view
    public function booked(){ 
        $data['cabines'] = CabinBooking::where('patient_id', Auth::id())->orderBy('id', 'desc')->get();
        $data['wards'] = WardBooking::where('patient_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('patient.bookingList', $data);
    }
}