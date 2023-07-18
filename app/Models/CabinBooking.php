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
}
