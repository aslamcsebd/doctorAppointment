<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\FavouriteDoctor;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    // Show all doctor
    public function doctor_search(){
        $data['doctors'] = Doctor::where('status', 1)->with('user')->get();
        return view('patient.doctors', $data);
    }

    // View doctor full info
    public function singleDoctor($id){
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
}
