<?php

namespace App\Http\Controllers;

use App\Models\WardBooking;
use App\Models\CabinBooking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFMakerController extends Controller {    
    public function print($room_type, $check_in, $check_out) {            
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

        $data['type'] = $room_type;
        $currentPage = 'admin.pdf';
        $pdf = Pdf::loadView($currentPage, $data);
        $set_paper = 'portrait';

        // $pdf->set_paper("A4", "portrait");
        $pdf->set_paper("A4", $set_paper);
        return $pdf->download('result.pdf');
    }
}
