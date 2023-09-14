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
            $table->string('tran_id')->nullable();
            $table->integer('patient_id')->comment('user id');
            $table->integer('bed_fee')->nullable();
            $table->integer('advance')->nullable();
            $table->integer('due')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0=Incomplete, 1=Done');
            $table->timestamps();
        });
        /*
        CREATE TABLE `orders` (
            `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `amount` double DEFAULT NULL,
            `address` text COLLATE utf8_unicode_ci,
            `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `transaction_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `currency` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
        );
        */
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
