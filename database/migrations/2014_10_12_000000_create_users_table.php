<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->tinyInteger('role')->comment('1=Admin, 2=Sub_admin, 3=Doctor, 4=Patient');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();    
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // $roles = array('admin', 'sub_admin', 'doctor', 'patient');
        $roles = array('admin');
        $loop = 1;
        foreach($roles as $role){
            DB::table('users')->insert([
                'role' => $loop,
                'name' => $role,
                'email' => $role.'@gmail.com',
                'email_verified_at' => now(),
                'phone' => '0123456789',
                'password' => Hash::make('admin'),
                'remember_token' => '',
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
