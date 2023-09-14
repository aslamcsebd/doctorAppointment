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
        Route::get('doctor-list/', 'AdminController@doctor_list')->name('doctor.list');
        Route::get('doctorView/{id}/','AdminController@doctorView')->name('doctorView');

    // Patient info
        Route::get('/patient-list', 'AdminController@patient_list')->name('patient.list');
        Route::get('patientView/{id}/','AdminController@patientView')->name('patientView');

        Route::post('/create-patient','AdminController@create_patient')->name('create.patient');
        
    // Room management
        Route::get('room', 'RoomController@room')->name('room');
        Route::post('add-room/', 'RoomController@addRoom')->name('addRoom');
        Route::post('add-floor/', 'RoomController@addFloor')->name('addFloor');

    // New booking from admin
        Route::get('/new-booking', 'AdminController@new_booking')->name('admin.booking');  
        Route::get('/admin/booking/{patientId}', 'AdminController@booking')->name('admin.booking.patientId'); 
        Route::post('/admin/booking-search', 'AdminController@booking_search')->name('admin.booking_search');

        // Cabin
        Route::get('admin/cabin_book/{check_in}/{check_out}/{id}/{patientId}', 'AdminController@cabin_book')->name('cabin_book');
    
        // Ward
        Route::get('admin/ward_book/{check_in}/{check_out}/{id}/{patientId}', 'AdminController@ward_book')->name('ward_book');
        
        // Final booking
        Route::post('admin/booking-now', 'AdminController@bookingNow')->name('admin.bookingNow');

    // Booking process
        Route::get('cabin-booking', 'RoomController@cabin_booking')->name('cabin.booking');
        Route::get('booking-view/{id}/{type}/{route}/{tab}', 'RoomController@booking_view');
        Route::post('/booking-complete', 'RoomController@bookingComplete')->name('bookingComplete');

        Route::get('ward-booking', 'RoomController@ward_booking')->name('ward.booking');

    // Payment system
        Route::get('payment', 'PaymentController@payment')->name('payment');
        Route::get('paymentView/{id}','PaymentController@paymentView')->name('paymentView');
        Route::post('payment-add/', 'PaymentController@payment_add')->name('payment.add');

// Doctor
    Route::get('appointment-request', 'DoctorController@appointment_request')->name('appointment.request');
    Route::get('appointment-request/{tab}', 'DoctorController@appointment_request2')->name('appointment.request.tab');
    Route::get('single-patient/{id}/{route}/{tab}', 'DoctorController@singlePatient')->name('singlePatient');   
    Route::post('appointment-accept', 'DoctorController@appointment_accept')->name('appointment.accept');

    Route::get('/patient_list','DoctorController@patient_list2')->name('patientList');
    Route::get('patient-view/{id}', 'DoctorController@patient_view')->name('patient_view');    
    Route::post('report-add', 'DoctorController@report_add')->name('report.add');
    Route::get('patient-report/{id}', 'DoctorController@patient_report')->name('patient-report');    
    Route::get('patient-last-report/{id}/{route}/{tab}', 'DoctorController@patient_last_report')->name('patient-last-report');    

// Patient
    // Doctor search
    Route::get('doctor-search', 'PatientController@doctor_search')->name('doctor.search');
    Route::get('single-doctor/{id}/{route}','PatientController@singleDoctor')->name('singleDoctor');      
    Route::get('doctor-appointment/{id}/{route}','PatientController@doctor_appointment');      
    Route::get('addFavourite/{id}','PatientController@addFavourite')->name('addFavourite');
    Route::get('favourite-list','PatientController@favourite_list')->name('favourite.list');
    
    Route::get('search-date', 'PatientController@search_date')->name('search.date');   
    Route::post('appointment-add', 'PatientController@appointment_add')->name('appointment.add');   
    Route::get('appointment-list','PatientController@appointment_list')->name('appointment.list');

    Route::get('report-list','PatientController@report_list')->name('report.list');
    Route::get('report-view/{id}','PatientController@report_view')->name('report-view');

    // Booking
    Route::get('booking/', 'PaymentController@booking')->name('booking');
    Route::post('booking-search', 'PaymentController@booking_search')->name('booking_search');
    
    // Cabin
    Route::get('cabin_book/{check_in}/{check_out}/{id}', 'PaymentController@cabin_book')->name('cabin_book');
    
    // Ward
    Route::get('ward_book/{check_in}/{check_out}/{id}', 'PaymentController@ward_book')->name('ward_book');

    // Booking [cabin, Ward]
    Route::post('booking-now', 'SslCommerzPaymentController@index')->name('bookingNow');
    Route::get('booking-list', 'PatientController@booked')->name('booked');  

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
    
// Google Socialite
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// SSLCOMMERZ Start
    Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
    Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

    // Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
    Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

    Route::post('/success', [SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

    Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

// Cache:clear
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');   
    
    return "Cleared!";
 });
 