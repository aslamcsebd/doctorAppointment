<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'doctor_id', 'id')->withDefault();
    }

    public function user2(){
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id')->withDefault();
    }
}
