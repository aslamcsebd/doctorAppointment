<?php

namespace App\Http\Controllers;

use Redirect;

use App\Models\HospitalInfo;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // All settings
    public function hospitalInfo(){
        $data['hospitalInfo'] = HospitalInfo::first();
        return view('admin.settings', $data);
    }

    // Add hospital info 
    public function addHospitalInfo(Request $request){

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

            $path="images/";
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

            $path="images/";
            if ($request->hasFile('photo')){
                
                $validator = Validator::make($request->all(),[
                    'name'=>'required',
                    'address'=>'required',
                    'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
                $photoLink =$request->photoName;
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
