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
}
