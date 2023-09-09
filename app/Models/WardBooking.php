<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Room id
    public function wardNo(){
        return $this->belongsTo(Ward::class, 'ward_id', 'id')->withDefault();
    }

    // User info
    public function user(){
        return $this->belongsTo(User::class, 'patient_id', 'id')->withDefault();
    }

    // Patient info
    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id', 'user_id')->withDefault();
    }
}
