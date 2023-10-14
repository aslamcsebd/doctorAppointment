<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_times', function (Blueprint $table) {
            $table->id();
            $table->string('time', 50);            
            $table->tinyInteger('status')->default('1')->comment('0=Inactive, 1=Active');
            $table->timestamps();
        });

        // mktime(hour, minute, second, month, day, year, is_dst);
        $iTimestamp = mktime(0, 0, 0, 1, 1, date('Y'));
        for ($i = 0; $i < 48; $i++) {
            DB::table('booking_times')->insert([
                'time' => date('h:i a', $iTimestamp)
            ]);
            $iTimestamp += 1800;
        }        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_times');
    }
}
