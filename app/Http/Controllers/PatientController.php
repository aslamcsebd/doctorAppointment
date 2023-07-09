<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\FavouriteDoctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
 
    // Show all doctor
    public function favourite_list(){
        $data['doctors'] = FavouriteDoctor::where('patient_id', Auth::id())->with('user')->get();
        return view('patient.favouriteDoctors', $data);
    }

    // Add favourite doctor
    public function appointment_add(Request $request){
        Appointment::Create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->user_id,
            'date' => date('Y-m-d', strtotime($request->date))
        ]);
        return back()->with('success', 'Appointment add successfully');
    }

    // Show all doctor
    public function appointment_list(){
        $data['appointments'] = Appointment::where('patient_id', Auth::id())->with('user')->get();
        return view('patient.appointments', $data);
    }
}