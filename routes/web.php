<?php
namespace App\Http\Controllers;

use Auth;
use Artisan;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();


Route::middleware(['auth'])->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
 
    // Doctor registration
        Route::get('doctor/registration', 'DoctorController@registration')->name('doctor.registration');
        Route::post('/doctor-create', 'DoctorController@doctor_create')->name('doctor.create');
       
        Route::get('doctor/list', 'DoctorController@doctor_list')->name('doctor.list');
        Route::get('doctorView/{id}','DoctorController@doctorView')->name('doctorView');

    // Room management
        Route::get('room', 'RoomController@room')->name('room');

        // Add room
        Route::post('/add-room', 'RoomController@addRoom')->name('addRoom');

        // Add floor        
        Route::post('/add-floor', 'RoomController@addFloor')->name('addFloor');

        // All status change
        Route::get('/status/update', 'HomeController@changeStatus')->name('status');

        // Delete item
        Route::get('itemDelete/{model}/{id}/{tab}','HomeController@itemDelete')->name('itemDelete');  
});
 
Route::get('login/{provider}', 'App\Http\Controllers\Auth\LoginController@redirectToProvider');
Route::get('{provider}/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback');

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');   
    
    return "Cleared!";
 });
 