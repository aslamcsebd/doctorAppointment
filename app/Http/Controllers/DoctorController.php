<?php

namespace App\Http\Controllers;

use Redirect;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;

use App\Models\Report;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller {

    // Patient profile
    public function doctorInfo(){
        $data['doctorInfo'] = Doctor::where('user_id', Auth::id())->with('user')->first();
        return view('doctor.settings', $data);
    }   

    // Add hospital info 
    public function updateDoctorInfo(Request $request){
        $path="images/doctor/";
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

        Doctor::where('id', $request->id)->update([
            'gender' => $request->gender,
            'blood' => $request->blood,
            'fee' => $request->fee,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'photo' => $photoLink,
            'qualification' => $request->qualification,
            'service' => $request->service
        ]);
        return back()->with('success','Doctor info update successfully');
    }   

    // Show appointment list
    public function appointment_request(){
        $data['appointments'] = Appointment::where('doctor_id', Auth::id())->with('user2')->orderBy('id', 'DESC')->get();
        return view('doctor.appointments', $data);
    }

    public function appointment_request2($tab){
        $tab = $tab;
        $appointments = Appointment::where('doctor_id', Auth::id())->with('user2')->orderBy('id', 'DESC')->get();
        return view('doctor.appointments', ['tab' => 'accept']);
        // ->with(['tab' => $tab]);
    }

    // View patient full info
    public function singlePatient($id, $route, $tab){
        if($route=='appointment.request'){
            $data['appointmentDate'] = Appointment::find($id);
            $patient_id = $data['appointmentDate']->patient_id;
        }

        $allTime = array('8:30 AM', '8:45 AM', '9:00 AM', '9:15 AM', '9:30 AM', '9:45 AM', '10:00 AM', '10:15 AM', '10:30 AM', '10:45 AM', '11:00 AM', '11:15 AM', '11:30 AM', '11:45 AM', '12:00 PM', '12:15 PM', '12:30 PM', '12:45 PM', '01:00 PM', '01:15 PM', '01:30 PM', '01:45 PM', '02:00 PM');
        $booked = Appointment::where('doctor_id', Auth::id())->where('date', $data['appointmentDate']->date)->where('status', 1)->pluck('time')->toArray();
        $data['unBook'] = array_diff($allTime, $booked);

        $data['route'] = $route;
        $data['tab'] = $tab;
        $data['patient'] = Patient::where('user_id', $patient_id)->first();
        return view('doctor.view', $data);
    }

    // Accept appointment
    public function appointment_accept(Request $request){
        Appointment::where('id', $request->id)->update([
            'date' => date('Y-m-d', strtotime($request->date)),
            'time' => $request->time,
            'status' => 1
        ]);
        return back()->with('success', 'Appointment accept successfully');
    }

    // Patient report
    public function patient_list2(){
        $data['patients'] = Appointment::where('doctor_id', Auth::id())->orderBy('id', 'DESC')->get()->groupBy('patient_id');   
        return view('doctor.patients', $data);
    }

    // Single report 
    public function patient_view($id){
        Appointment::where('id', $id)->update([
            'status' => 2
        ]);
        $id = Appointment::find($id)->patient_id;

        $data['user'] = User::find($id);
        $data['patient'] = Patient::where('user_id', $id)->first();

        $data['report2'] = Report::where('patient_id', $id)->where('doctor_id', Auth::id())->orderBy('id', 'DESC')->get();

        return view('doctor.reportAdd', $data);
    }

    // Add report 
    public function report_add(Request $request){
        $path="images/report/";
        $validator = Validator::make($request->all(),[
            'id'=>'required',
            'title'=>'required',
            'file'=>'required',
        ]);

        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        if($files=$request->file('file')){
            $file = $request->file;
            $fullName=time().".".$file->getClientOriginalExtension();
            $files->move(public_path($path), $fullName);
            $fileLink = $path . $fullName;
        }

        Report::create([
            'patient_id' => $request->id,
            'doctor_id' => Auth::id(),
            'title' => $request->title,
            'file' => $fileLink,
            'date' => Carbon::now()
        ]);
        return back()->with('success', 'Report file add successfully');       
    }

    // Single report
    public function patient_report($id){
        $data['user'] = User::find($id);
        $data['reports'] = Report::where('patient_id', $id)->where('doctor_id', Auth::id())->orderBy('id', 'DESC')->get();
        return view('doctor.reportView', $data);
    }

    // Last report
    public function patient_last_report($id, $route, $tab){    
        
        $data['appointmentDate'] = Appointment::find($id);
        $patient_id = $data['appointmentDate']->patient_id;

        $data['route'] = $route;
        $data['tab'] = $tab;
        $data['patient'] = Patient::where('user_id', $patient_id)->first();


        $data['report'] = Report::where('patient_id', $patient_id)->where('doctor_id', Auth::id())->get()->last();
        return view('doctor.lastReport', $data);
    }
}
