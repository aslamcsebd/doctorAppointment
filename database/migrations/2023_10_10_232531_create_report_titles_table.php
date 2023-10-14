<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);            
            $table->tinyInteger('status')->default('1')->comment('0=Inactive, 1=Active');
            $table->timestamps();
        });

        $loop = 1;
        for ($i = 0; $i < 3; $i++) {
            DB::table('report_titles')->insert([
                'name' => 'Report name'." ".$loop
            ]);
            $loop++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_titles');
    }
}
