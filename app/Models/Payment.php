<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getPatient(){
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }
    
    public function patientInfo(){
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id');
    }

    public function getDoctor(){
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
}
