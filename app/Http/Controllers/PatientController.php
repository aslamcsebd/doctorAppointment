<?php

namespace App\Http\Controllers;
use Redirect;

use App\Models\Doctor;
use App\Models\Report;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\FavouriteDoctor;
use Illuminate\Support\Facades\Auth;
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

    // Add appointment
    public function appointment_add(Request $request){
        Appointment::Create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->user_id,
            'date' => date('Y-m-d', strtotime($request->date))
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
        $data['reports'] = Report::where('patient_id', Auth::id())->with('user')->orderBy('id', 'DESC')->get();
        return view('patient.reports', $data);
    }

    // Report view
    public function report_view($id){ 
        $data['report'] = Report::find($id);
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
}