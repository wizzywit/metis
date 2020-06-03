<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::prefix('admin')->group(function() {
    //reset admin password logic
    Route::get('/password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::get('/pasword/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.update');
    Route::post('/password/reset','Admin\ResetPasswordController@reset')->name('admin.password.request');

    Route::post('/password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    //Admin login logic
    Route::get('/login','Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\LoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'Admin\LoginController@logout')->name('admin.logout');


    //change password
    Route::post('/setting/password/change','Admin\AdminController@changePassword')->name('admin.password.change');
    Route::get('/setting/password','Admin\AdminController@showPasswordForm')->name('admin.password.form');
    Route::get('/setting/password/confirm','Admin\AdminController@confirmPassword')->name('admin.password.confirm');

    //Admin Protected doctors routes
    Route::get('/doctors', 'Admin\AdminController@showDoctors')->name('admin.doctors');

    Route::get('/doctor/create', 'Admin\AdminController@createDoctor')->name('admin.doctor.store');
    Route::post('/doctor/{id}/edit', 'Admin\AdminController@editDoctor')->name('admin.doctor.edit');
    Route::get('/doctor/{id}/edit', 'Admin\AdminController@showEditDoctorForm')->name('admin.doctor.editForm');
    Route::post('/doctor/create', 'Admin\AdminController@storeDoctor')->name('admin.doctor.save');
    Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/doctor/{id}/verify','Admin\AdminController@verifyDoctor');
    Route::get('/doctor/{id}/refute','Admin\AdminController@refuteDoctor');
    Route::get('/doctor/{id}/delete','Admin\AdminController@deleteDoctor')->name('admin.delete.doctor');
    Route::get('/doctor/{id}/view','Admin\AdminController@viewDoctor');

    //Admin Protected Patients route
    Route::get('/patients', 'Admin\AdminController@showPatients')->name('admin.patients');
    Route::get('/patient/create', 'Admin\AdminController@createPatient')->name('admin.patient.store');
    Route::post('/patient/{id}/edit', 'Admin\AdminController@editPatient')->name('admin.patient.edit');
    Route::get('/patient/{id}/edit', 'Admin\AdminController@showEditPatientForm')->name('admin.patient.editForm');
    Route::post('/patient/create', 'Admin\AdminController@storePatient')->name('admin.patient.save');
    Route::get('/patient/{id}/delete','Admin\AdminController@deletePatient')->name('admin.delete.patient');
    Route::get('/patient/{id}/view','Admin\AdminController@viewPatient');

    //todo #Admin Protected Appointment routes
    Route::get('/appointments', 'Admin\AdminController@showAppointments')->name('admin.appointments');
    Route::get('/appointment/create', 'Admin\AdminController@createAppointment')->name('admin.appointment.store');
    Route::post('/appointment/{id}/edit', 'Admin\AdminController@editAppointment')->name('admin.appointment.edit');
    Route::get('/appointment/{id}/edit', 'Admin\AdminController@showEditAppointmentForm')->name('admin.appointment.editForm');
    Route::post('/appointment/create', 'Admin\AdminController@storeAppointment')->name('admin.appointment.save');
    Route::get('/appointment/{id}/delete','Admin\AdminController@deleteAppointment')->name('admin.delete.appointment');
    Route::get('/appointments/events','Admin\AdminController@showAppointmentsCalender')->name('admin.appointment.calender');
    Route::get('/appointment/{id}/view','Admin\AdminController@viewAppointment')->name('admin.appointment.view');
    Route::get('/appointment/{id}/schedule/{flag}','Admin\AdminController@scheduleAppointment');
   }) ;


Route::prefix('doctor')->group(function() {
     //reset admin password logic
     Route::get('/password/reset/{token}','Doctor\ResetPasswordController@showResetForm')->name('doctor.password.reset');
     Route::get('/pasword/reset','Doctor\ForgotPasswordController@showLinkRequestForm')->name('doctor.password.update');
     Route::post('/password/reset','Doctor\ResetPasswordController@reset')->name('doctor.password.request');

     Route::post('/password/email','Doctor\ForgotPasswordController@sendResetLinkEmail')->name('doctor.password.email');
     //Doctor login logic
     Route::get('/login','Doctor\LoginController@showLoginForm')->name('doctor.login');
     Route::post('/login', 'Doctor\LoginController@login')->name('doctor.login.submit');
     Route::post('logout/', 'Doctor\LoginController@logout')->name('doctor.logout');
     Route::get('registered',function() {
         return view('doctor.registered');
     });


     //change password
     Route::post('/setting/password/change','DoctorController@changePassword')->name('doctor.password.change');
     Route::get('/setting/password','DoctorController@showPasswordForm')->name('doctor.password.form');
     Route::get('/setting/password/confirm','DoctorController@confirmPassword')->name('doctor.password.confirm');
     Route::get('/register','Doctor\RegisterController@showRegistrationForm')->name('doctor.register');
     Route::post('/register','Doctor\RegisterController@register')->name('doctor.register.now');

     Route::get('/', 'DoctorController@index')->name('doctor.dashboard');

     //scheduling appointment routes
     Route::get('/schedule/{id}','DoctorController@showScheduleForm')->name('doctor.schedule.request');
     Route::post('/schedule/{id}','DoctorController@schedule')->name('doctor.schedule');

     //change password
    Route::post('/setting/password/change','DoctorController@changePassword')->name('doctor.password.change');
    Route::get('/setting/password','DoctorController@showPasswordForm')->name('doctor.password.form');
    Route::get('/setting/password/confirm','DoctorController@confirmPassword')->name('doctor.password.confirm');

    //view profile
    Route::get('/setting/profile','DoctorController@showProfile')->name('doctor.view');

    //edit profile
    Route::get('/setting/profile/edit','DoctorController@showEdit')->name('doctor.edit');
    Route::post('/setting/profile/edit','DoctorController@editProfile')->name('doctor.edit.profile');

    //videoconferencing route
    Route::post('/video/home','DoctorController@videoHome')->name('doctor.video.conference');
    Route::get('/video/start','DoctorController@showRooms')->name('doctor.video.rooms');

});



// Route::get('/home', 'HomeController@index')->name('home');
Route::middleware('auth')->prefix('patient')->group(function() {
    Route::get('/','PatientController@index');
    Route::get('/booking','PatientController@booking')->name('booking');
    Route::get('/doctor/get','PatientController@getDoctor')->name('doctor.get');
    Route::post('/booking/book','PatientController@bookNow')->name('book.now');
    Route::post('/booking/book/{id}','PatientController@bookNowInstance')->name('book.now.instance');
    Route::post('/booking/payment','PatientController@stripePost')->name('stripe.post');
    Route::get('/appointments','PatientController@appointments')->name('appointments');


    //change password
    Route::post('/setting/password/change','PatientController@changePassword')->name('patient.password.change');
    Route::get('/setting/password','PatientController@showPasswordForm')->name('patient.password.form');
    Route::get('/setting/password/confirm','PatientController@confirmPassword')->name('patient.password.confirm');

    //view profile
    Route::get('/setting/profile','PatientController@showProfile')->name('patient.view');

    //edit profile
    Route::get('/setting/profile/edit','PatientController@showEdit')->name('patient.edit');
    Route::post('/setting/profile/edit','PatientController@editProfile')->name('patient.edit.profile');

     //videoconferencing route
     Route::post('/video/home','PatientController@videoHome')->name('patient.video.conference');
     Route::get('/video/start','PatientController@showRooms')->name('patient.video.rooms');

});

Route::post('/pusher/auth','PusherController@authenticate');
