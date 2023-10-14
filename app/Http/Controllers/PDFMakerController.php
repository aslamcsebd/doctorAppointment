<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\WardBooking;
use App\Models\CabinBooking;
use App\Models\HospitalInfo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFMakerController extends Controller{
    // Booking print
    public function booked_print($room_type, $check_in, $check_out){
        $data['hospitalName'] = HospitalInfo::first();
      
        if($room_type == 'cabin'){
            $data['booked'] = CabinBooking::where([
                ['cabin_bookings.check_in', '<=', $check_in],
                ['cabin_bookings.check_out', '>=', $check_in]
            ])
            ->orwhere([
                ['cabin_bookings.check_in', '>=', $check_out],
                ['cabin_bookings.check_out', '<=', $check_out]
            ])->get();
        }else{
            $data['booked'] = WardBooking::where([
                ['check_in', '>=', $check_in],
                ['check_in', '<=', $check_out]
            ])->get();
        }

        $data['room_type'] = $room_type;
        $currentPage = 'admin.pdf';
        $pdf = Pdf::loadView($currentPage, $data);
        $set_paper = 'portrait';

        // $pdf->set_paper("A4", "portrait");
        $pdf->set_paper("A4", $set_paper);
        return $pdf->download('result.pdf');
    }

    // Admin Payment print
    public function admin_payment($id){
        $data['hospital'] = HospitalInfo::first();
        $data['payment'] = Payment::find($id);
        
        $currentPage = 'payment.pdf';
        $pdf = Pdf::loadView($currentPage, $data);
        $set_paper = 'portrait';

        $pdf->set_paper("A4", $set_paper);
        return $pdf->download('result.pdf');
    }

    // Patient Payment print
    public function patient_payment($tran_id){
        $data['hospital'] = HospitalInfo::first();
        $data['payment'] = Payment::where('tran_id', $tran_id)->first();
        
        $currentPage = 'patient.pdf';
        $pdf = Pdf::loadView($currentPage, $data);
        $set_paper = 'portrait';

        $pdf->set_paper("A4", $set_paper);
        return $pdf->download('result.pdf');
    }
}
