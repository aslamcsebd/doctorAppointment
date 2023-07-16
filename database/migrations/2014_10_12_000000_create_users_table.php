<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('role')->comment('1 =Admin, 2=Doctor, 3=Patient');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');    
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });



        $roles = array('admin', 'doctor', 'patient');
        $loop = 1;
        foreach($roles as $role){
            DB::table('users')->insert([
                'role' => $loop,
                'name' => $role,
                'email' => $role.'@gmail.com',
                'email_verified_at' => now(),
                'phone' => '0123456789',
                'password' => Hash::make('123'),
                'remember_token' => '123',
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
        Schema::dropIfExists('users');
    }
}
