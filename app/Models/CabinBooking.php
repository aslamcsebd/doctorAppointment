<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabinBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Floor id
    public function floorId(){
        return $this->belongsTo(Room::class, 'room_no', 'room_no')->withDefault();
    }

    // User info
    public function user(){
        return $this->belongsTo(User::class, 'patient_id', 'id')->withDefault();
    }

    // Patient info
    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id')->withDefault();
    }

    // Payment info
    public function payment(){
        return $this->belongsTo(Payment::class, 'tran_id', 'tran_id')->withDefault();
    }
}
