<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientForm extends Model
{
    use HasFactory;
    protected $guarded = [];

	// Doctor info
	public function user(){
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

	// Doctor info
	public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id')->withDefault();
    }
}
