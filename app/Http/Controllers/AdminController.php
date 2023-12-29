<?php

namespace App\Http\Controllers;

use Redirect;

use Carbon\Carbon;
use App\Models\Room;

use App\Models\User;
use App\Models\Ward;
use App\Models\Floor;
use App\Mail\SendMail;
use App\Models\Doctor;
use App\Models\Report;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\PatientForm;
use App\Models\ReportTitle;
use App\Models\WardBooking;

use App\Models\CabinBooking;
use App\Models\HospitalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

    // Doctor registration
    public function registration(){
        return view('admin.registration');
    }

    // Create doctor account
    public function doctor_create(Request $request){
        $validator = Validator::make($request->all(),[
            'doctor_id'=>'required|unique:doctors',
            'name'=>'required',
            'email'=>'required|unique:users',
            'phone'=>'required',
            'password'=>'required|min:6',
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
            'role' => 3,
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'created_at' => Carbon::now()
        ]);

        Doctor::create([
            'user_id' => $user_id,
            // 'doctor_id' => str_pad($user_id, 6, '0', STR_PAD_LEFT),
            'doctor_id' => $request->doctor_id,
            'gender' => $request->gender,
            'blood' => $request->blood,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'fee' => $request->fee,
            'photo' => $photoLink,
            'qualification' => $request->qualification,
            'service' => $request->service,
        ]);        

		// For email
        $this->send_email($request->email, $request->password);

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
    
	// Guest appointment
	public function guest_appointment(){	
        $data['appointmentRequest'] = PatientForm::orderBy('appointment_date')->get();	
		return view('admin.guestAppointment', $data);
	}

	public function accept($id){
		$guest = PatientForm::find($id);

        // All user
		$user_id = User::create([
            'role' => 4,
            'name' => $guest->name,
            'email' => $guest->email,
            'phone' => $guest->phone,
            'password' => Hash::make($guest->phone),
            'created_at' => Carbon::now()
        ]);

        // All patient
        $id2 = $user_id->id;
        Patient::create([
            'user_id' => $id2,
            'patient_id' => str_pad($id2, 6, '0', STR_PAD_LEFT),
			'address' => $guest->address,
			'source' => $guest->source
        ]);

        // Appointment booking
        $id2 = $user_id->id;
        Appointment::Create([       
            'appointment_id' => uniqid(),
            'patient_id' => $id2,
            'doctor_id' => $guest->doctor_id,
            'date' => date('Y-m-d', strtotime($guest->appointment_date)),
            'time' => date('h:i a', strtotime($guest->appointment_date)),
        ]);

        // For email
        $this->send_email($guest->email, $guest->phone);

		PatientForm::find($id)->update([
			'status' => 'accept'
		]);
		return back()->with('success', 'Appointment request accept successfully');
	}

    // Appointment request
    public function all_appointment(){	
        $data['appointments'] = Appointment::orderBy('date')->get();	
        return view('admin.appointments', $data);
    }

    // appointment accept
    public function appointment_accept(Request $request){
        $validator = Validator::make($request->all(),[
            'date'=>'required'
        ]);

        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
      
        // Appointment confirm
        Appointment::where('id', $request->id)->update([  
            'date' => date('Y-m-d', strtotime($request->date)),
            'time' => date('h:i a', strtotime($request->date)),
			'status' => 'accept'
        ]);

        $id = Appointment::find($request->id)->patient_id;
        $phone = User::find($id)->phone;
        $sms = 'Your appointment request accept successfully. ' . date('d-M-Y h:i a', strtotime($request->date));

        // Notification
        // $notification = HospitalInfo::first()->notification;
        // if($notification == 'email'){
        //     echo $notification;
        // }elseif($notification == 'sms'){
        //     echo $notification;
        // }else{
        //     echo $notification;
        // }

        // For sms
        $this->send_sms($phone, $sms);

		return back()->with('success', 'Appointment request accept successfully');
	}

    // Single report 
    public function patient_view($id){
        $data['appointment'] = Appointment::find($id);
        $data['reports'] = ReportTitle::where('status', 1)->get();
        return view('admin.reportAdd', $data);
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

        $appointment = Appointment::where('id', $request->id)->update([            
            'status' => 'report'
        ]);
        $appointment = Appointment::find($request->id);        
        Report::create([
            'appointment_id' => $appointment->appointment_id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'title' => $request->title,
            'file' => $fileLink
        ]);
        return back()->with('success', 'Report file add successfully');       
    }

    // Last report 
    public function last_report($id){
        $data['appointment'] = Appointment::where('appointment_id', $id)->first();
        $data['report'] = Report::where('appointment_id', $id)->first();
        return view('admin.lastReport', $data);
    }

    // Create new patient
    public function create_patient(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|min:6',
            'phone'=>'required|unique:users'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
    
        $user_id = User::create([
            'role' => 4,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        $id = $user_id->id;

        Patient::create([
            'user_id' => $id,
            'patient_id' => str_pad($id, 6, '0', STR_PAD_LEFT)
        ]);
		
        // For email
        $this->send_email($request->email, $request->password);

        return back()->with('success', 'Patient registration successfully');
    }   

    // Patient info
    public function patient_list(){
        $data['patients'] = Patient::with('user')->get();
        return view('admin.patients', $data);
    }

    // Patient full info
    public function patientView($id){
        $data['patient'] = Patient::find($id);
        $data['reports'] = Report::where('patient_id', $data['patient']->user_id)->get();
        return view('admin.patientView', $data);
    }

    // Room-seat [Room controller]

    // Booking for patient list
    public function new_booking(){
        $data['new_booking'] = true;
        $data['patients'] = Patient::with('user')->get();
        return view('admin.patients', $data);
    }

    // New booking process
    public function booking($patientId) {
        $data['patientId'] = $patientId;
        $data['floors'] = Floor::all();       
        $data['roomWards'] = Room::where('room_type', 'ward')->orderBy('room_no', 'Asc')->get();

        $allColumns = array_keys(json_decode(Patient::first(), true));
        $data['needed_columns'] = array_diff($allColumns, ['id', 'user_id', 'patient_id', 'status', 'created_at', 'updated_at']);

        return view('admin.booking', $data);
    }

    // Booking search
    public function booking_search(Request $request){
		$data['patientId'] = $request->patientId;
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
 
        return view('admin.booking', $data);
    }

    // Cabin booking info
    public function cabin_book($check_in, $check_out, $id, $patientId) {
        $data['check_in'] =   Carbon::createFromFormat('Y-m-d H:s:i', $check_in);        
        $data['check_out'] = Carbon::createFromFormat('Y-m-d H:s:i', $check_out);
        $data['totalHour'] = $data['check_in']->diffInHours($data['check_out']);
        
        $data['patientId'] = $patientId;
        $data['room'] = Room::find($id);

        return view('admin.cabinBookingView', $data);
    }

    // Ward booking info
    public function ward_book($check_in, $check_out, $id, $patientId){ 
        $data['check_in'] =   Carbon::createFromFormat('Y-m-d', $check_in);        
        $data['check_out'] = Carbon::createFromFormat('Y-m-d', $check_out);
        $data['totalDay'] = $data['check_in']->diffInDays($data['check_out']);

        $data['patientId'] = $patientId;
        $data['ward'] = Ward::find($id);

        return view('admin.wardBookingView', $data);
	}

    // Final booking
    public function bookingNow(Request $request){
        $patientId = $request->patientId;
        $post_data['tran_id'] = uniqid();
 
        $bookingType = $request->bookingType;
        if($bookingType == 'cabin'){
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
        
            $bookingId = CabinBooking::create([
                'patient_id' => $patientId,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'room_no' => $request->room_no,
                'rent' => $request->rent,
                'tran_id' => $post_data['tran_id'],
                'card_type' => 'Cash'
            ]);
            $url = 'cabin-booking';

        }elseif($bookingType == 'ward'){

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
            
            $bookingId = WardBooking::create([
                'patient_id' => $patientId,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'ward_id' => $request->id,
                'rent' => $request->rent,
                'tran_id' => $post_data['tran_id'],
                'card_type' => 'Cash'
            ]);
            $url = 'ward-booking';
        }       

        Payment::create([
            'room_type' => $bookingType,
            'tran_id' => $post_data['tran_id'],
            'patient_id' => $patientId,
            'bed_fee' => $request->totalRent,
            'advance' => $request->advance
        ]);      
        return redirect($url)->with('success', 'Booking & transaction is successfully completed');
    }

    // Booking list	[Room controller]

    // Payment system [Payment controller]

    // Create new sub admin
    public function create_subAdmin(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|min:6',
            'phone'=>'required|unique:users'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }
    
        $user_id = User::create([
            'role' => 2,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        // For email
        $this->send_email($request->email, $request->password);

        return back()->with('success', 'Sub admin registration successfully');
    }

    // Sub admin info
    public function sub_admin(){
        $data['subAdmins'] = User::where('role', 2)->get();
        return view('admin.subAdmins', $data);
    }

	// All settings
    public function hospitalInfo(){
        $data['hospitalInfo'] = HospitalInfo::first();
        return view('admin.settings', $data);
    }

    // Add hospital info 
    public function updateHospitalInfo(Request $request){
        if($request->id==null){
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
        }
        else{
            $path="images/admin/";
            if ($request->hasFile('photo')){
                $validator = Validator::make($request->all(),[
                    'name'=>'required',
                    'address'=>'required',
                    'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
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

    // Email / sms notification 
    public function saveNotification(Request $request){
        if($request->id==null){  
            HospitalInfo::create([
                'notification' => $request->notification
            ]);
            return back()->with('success', 'Notification save successfully');

        }else{
            HospitalInfo::where('id', $request->id)->update([
                'notification' => $request->notification
            ]);
            return back()->with('success', 'Notification update successfully');
        }
    }

    // Email send
    public  function send_email($email, $password){
        $mailData = [
            'email' 	=>	$email,
			'password' 	=>	$password,
			'website'	=>	route('login')
        ];
        Mail::to($email)->send(new SendMail($mailData));
    }    

    // SMS gateway
    public  function send_sms($num, $sms){
        $url = env('SMS_url');
        $data = [
            "api_key" => env('SMS_api_key'), 
            "type" => env('SMS_type'),
            "contacts" => $num,
            "senderid" => env('SMS_senderid'),
            "msg" => $sms
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
