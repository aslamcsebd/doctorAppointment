<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->comment('user id');
            $table->integer('doctor_id')->comment('user id');
            $table->integer('doctor_fee')->nullable();
            $table->integer('bed_fee')->nullable();
            $table->integer('total')->nullable();
            $table->integer('advance')->nullable();
            $table->integer('sub_total')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0=Incomplete, 1=Done');
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
        Schema::dropIfExists('payments');
    }
}
