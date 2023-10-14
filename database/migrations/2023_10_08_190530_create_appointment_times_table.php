<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_times', function (Blueprint $table) {
            $table->id();
            $table->string('time', 50);            
            $table->tinyInteger('status')->default('1')->comment('0=Inactive, 1=Active');
            $table->timestamps();
        });

        // mktime(hour, minute, second, month, day, year, is_dst);
        
        $hour = 10; //10:00 am
        $iTimestamp = mktime($hour, 0, 0, 1, 1, date('Y'));
        for ($i = 0; $i < 25; $i++) {
            $time =  date('h:i a', $iTimestamp);
            DB::table('appointment_times')->insert([
                'time' => $time
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
        Schema::dropIfExists('appointment_times');
    }
}
