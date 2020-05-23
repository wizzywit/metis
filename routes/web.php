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
    return view('welcome');
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
   }) ;

Route::get('/home', 'HomeController@index')->name('home');
