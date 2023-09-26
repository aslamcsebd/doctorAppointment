<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_forms', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('doctor_id');
            $table->string('name', 50)->nullable();
            $table->string('email', 50)->unique();            
            $table->string('phone', 30)->nullable();
            $table->string('age', 5)->nullable();   
            $table->date('appointment_date')->nullable();
            $table->text('diseases_info')->nullable();
            $table->text('address')->nullable();	
            $table->string('status', 10)->default('pending')->comment('pending, accept, reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_forms');
    }
}
