<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    // Payment list
    public function payment(){
        $data['payments'] = Payment::all();
        return view('admin.payment', $data);
    }

    // Patient payment view
    public function paymentView($id){
        $data['payment'] = Payment::find($id);        
        return view('admin.view', $data);
    }

    // Create doctor account
    public function payment_add(Request $request){

        $validator = Validator::make($request->all(),[            
            'payment_id'=>'required',
            'sub_total'=>'required'
        ]);
    
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator);
        }

        Payment::where('id', $request->payment_id)->update([
            'sub_total' => $request->sub_total,
            'status' => 1,
        ]);
        return redirect()->route('payment')->with('success','Payment add successfully');
    }
}
