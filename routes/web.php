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
        Route::get('doctor/registration/', 'AdminController@registration')->name('doctor.registration');
        Route::post('doctor-create/', 'AdminController@doctor_create')->name('doctor.create');       
        Route::get('doctor/list/', 'AdminController@doctor_list')->name('doctor.list');
        Route::get('doctorView/{id}/','AdminController@doctorView')->name('doctorView');

    // Room management
        Route::get('room', 'RoomController@room')->name('room');
        Route::post('add-room/', 'RoomController@addRoom')->name('addRoom');
        Route::post('add-floor/', 'RoomController@addFloor')->name('addFloor');

    // Payment system
        Route::get('payment', 'PaymentController@payment')->name('payment');
        Route::get('paymentView/{id}','PaymentController@paymentView')->name('paymentView');
        Route::post('payment-add/', 'PaymentController@payment_add')->name('payment.add');

// Doctor
    Route::get('appointment-request','DoctorController@appointment_request')->name('appointment.request');
    Route::get('single-patient/{id}/{route}','DoctorController@singlePatient')->name('singlePatient');   
    Route::post('appointment-accept', 'DoctorController@appointment_accept')->name('appointment.accept');   

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

    // Booking
    Route::get('booking/','PaymentController@booking')->name('booking');
    Route::post('booking-search', 'PaymentController@booking_search')->name('booking_search');   

// Settings
    // Admin
    Route::get('hospitalInfo', 'AdminController@hospitalInfo')->name('hospitalInfo');
    Route::post('updateHospitalInfo', 'AdminController@updateHospitalInfo')->name('updateHospitalInfo');
    
    // Doctor
    Route::get('doctorInfo', 'DoctorController@doctorInfo')->name('doctorInfo');
    Route::post('updateDoctorInfo', 'DoctorController@updateDoctorInfo')->name('updateDoctorInfo');

    // Patient
    Route::get('patientInfo', 'PatientController@patientInfo')->name('patientInfo');
    Route::post('updatePatientInfo', 'PatientController@updatePatientInfo')->name('updatePatientInfo');

    Route::get('set-password', 'PatientController@setPassword')->name('setPassword');
    Route::post('set-password-now', 'PatientController@setPasswordNow')->name('setPasswordNow');        
    
// Default option
        // All status change
        Route::get('/status/update', 'HomeController@changeStatus')->name('status');

        // Delete item
        Route::get('itemDelete/{model}/{id}/{tab}','HomeController@itemDelete')->name('itemDelete');  
});
 
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');   
    
    return "Cleared!";
 });
 