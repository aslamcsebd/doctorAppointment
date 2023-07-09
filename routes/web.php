<?php
namespace App\Http\Controllers;

use Auth;
use Artisan;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function(){

// Admin
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

    // Payment system
        Route::get('payment', 'PaymentController@payment')->name('payment');
        Route::get('paymentView/{id}','PaymentController@paymentView')->name('paymentView');
        Route::post('/payment-add', 'PaymentController@payment_add')->name('payment.add');

// Patient
    // Doctor search
    Route::get('doctor-search', 'PatientController@doctor_search')->name('doctor.search');
    Route::get('single-doctor/{id}/{route}','PatientController@singleDoctor')->name('singleDoctor');        
    Route::get('addFavourite/{id}','PatientController@addFavourite')->name('addFavourite');
    Route::get('favourite-list','PatientController@favourite_list')->name('favourite.list');

    Route::post('appointment-add', 'PatientController@appointment_add')->name('appointment.add');   
    Route::get('appointment-list','PatientController@appointment_list')->name('appointment.list');

    Route::get('report-list','PatientController@report_list')->name('report.list');
    Route::get('report-view/{id}','PatientController@report_view')->name('report-view'); 
    
// Default option
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
 