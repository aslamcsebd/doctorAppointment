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
                ['check_in', '>=', $check_in],
                ['check_in', '<=', $check_out]
            ])->get();
        }
        else{
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

    // Total Payment
    public function total_payment($check_in, $check_out){
        $data['hospital'] = HospitalInfo::first();

        $cabin = Payment::join('cabin_bookings', 'cabin_bookings.tran_id', '=', 'payments.tran_id')
            ->whereDate('check_in', '>=', $check_in)
            ->whereDate('check_in', '<=', $check_out)
            ->where('payments.status', '=', 1)
            ->pluck('cabin_bookings.tran_id')->toArray();
        
        $ward = Payment::join('ward_bookings', 'ward_bookings.tran_id', '=', 'payments.tran_id')
            ->whereDate('check_in', '>=', $check_in)
            ->whereDate('check_in', '<=', $check_out)
            ->where('payments.status', '=', 1)
            ->pluck('ward_bookings.tran_id')->toArray();

        $paid = collect($cabin)->concat($ward)->toArray();
        $data['payments'] = Payment::whereIn('tran_id', $paid)->get();

        $currentPage = 'payment.paymentListPdf';
        $pdf = Pdf::loadView($currentPage, $data);
        $set_paper = 'portrait';

        $pdf->set_paper("A4", $set_paper);
        return $pdf->download('result.pdf');
    }

}
