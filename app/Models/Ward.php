<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Room no
    public function roomNo(){
        return $this->belongsTo(Room::class, 'room_id', 'id')->withDefault();
    }
}
