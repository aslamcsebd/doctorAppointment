<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    // Doctor info
    public function user(){
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

    // Patient info
    public function user2(){
        return $this->belongsTo(User::class, 'patient_id', 'id')->withDefault();
    }
    
    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id')->withDefault();
    }

    // Doctor info
	public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id')->withDefault();
    }
}
