<?php

namespace App\Http\Controllers;

use Redirect;

use Carbon\Carbon;
use App\Models\User;

use App\Models\Doctor;
use App\Models\HospitalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

    // Doctor registration
    public function registration(){
        return view('admin.registration');
    }

    // Create doctor account
    public function doctor_create(Request $request){               
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users',
            'phone'=>'required',
            'password'=>'required|min:6',
            /*    
            'gender'=>'required',
            'blood'=>'required',
            'dob'=>'required',
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'qualification'=>'required',
            'service'=>'required' */
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
    
        $path="images/doctor/";
        $default="default.jpg";
        if ($request->hasFile('photo')){
            if($files=$request->file('photo')){
                $photo = $request->photo;
                $fullName=time().".".$photo->getClientOriginalExtension();
                $files->move(public_path($path), $fullName);
                $photoLink = $path. $fullName;
            }
        }else{
            $photoLink = 'images/'. $default;
        }

        $user_id = User::insertGetId([
            'role' => 2,
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'created_at' => Carbon::now()
        ]);

        Doctor::create([
            'user_id' => $user_id,
            'doctor_id' => str_pad($user_id, 6, '0', STR_PAD_LEFT),
            'gender' => $request->gender,
            'blood' => $request->blood,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'fee' => $request->fee,
            'photo' => $photoLink,
            'qualification' => $request->qualification,
            'service' => $request->service,
        ]);

        return back()->with('success','Doctor registration successfully');
    }

    // Show all doctor
    public function doctor_list(){
        $data['doctors'] = Doctor::with('user')->get();
        return view('admin.doctors', $data);
    }

    // View doctor full info
    public function doctorView($id){
        $data['doctor'] = Doctor::find($id);        
        return view('admin.doctorView', $data);
    }    

    // All settings
    public function hospitalInfo(){
        $data['hospitalInfo'] = HospitalInfo::first();
        return view('admin.settings', $data);
    }

    // Add hospital info 
    public function updateHospitalInfo(Request $request){
        if($request->id==null){
            $validator = Validator::make($request->all(),[
                'name'=>'required',
                'address'=>'required',
                'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg'
            ]);

            if($validator->fails()){
                $messages = $validator->messages();
                return Redirect::back()->withErrors($validator);
            }

            $path="images/admin/";
            $default="default.jpg";
            if ($request->hasFile('photo')){
                if($files=$request->file('photo')){
                    $photo = $request->photo;
                    $fullName=time().".".$photo->getClientOriginalExtension();
                    $files->move(public_path($path), $fullName);
                    $photoLink = $path . $fullName;
                }
            }else{
                $photoLink = $path . $default;
            }

            HospitalInfo::create([
                'name' => $request->name,
                'address' => $request->address,
                'photo' => $photoLink
            ]);
            return back()->with('success','Hospital info save successfully');
            
        }else{

            $path="images/admin/";
            if ($request->hasFile('photo')){                
                $validator = Validator::make($request->all(),[
                    'name'=>'required',
                    'address'=>'required',
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

            HospitalInfo::where('id', $request->id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'photo' => $photoLink
            ]);
            return back()->with('success','Hospital info update successfully');
        }
    }   
}
