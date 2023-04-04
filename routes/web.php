<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\BUCareAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicalRecordFormController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\MedicalPatientRecordsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
/**
 *  OPEN ROUTES FOR USERS THAT ARE NOT LOGGED IN
 */

Route::get('/records/{patientID}', [MedicalPatientRecordsController::class, 'showMedicalPatientRecord'])->name('medicalPatientRecord.show');
Route::get('/', function () {
        return view('home');
})->name('home');

/**
 *  GUEST PROTECTED ROUTES
 */
Route::group(['middleware' => ['guest']], function() {
    Route::get('/login', [BUCareAuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('BUCare', [BUCareAuthController::class, 'BUCareLogin'])->name('BUCare.login')->middleware('guest');
    Route::get('/admin/login', [AdminAuthController::class, 'showAdminLogin'])->name('admin.login.show')->middleware('guest');
    Route::post('admin-login', [AdminAuthController::class, 'adminLogin'])->name('admin.login')->middleware('guest');
});

/**
 *  PROTECTED ROUTES FOR PATIENTS
 */
Route::group(['middleware' => ['web', 'auth']], function() {
   
    #---------------BUCareAuthController---------------#
    Route::post('logout', [BUCareAuthController::class, 'logout'])->name('logout');

    #------------MedicalRecordFormController------------#
    Route::get('/medical-record-form-registration',[MedicalRecordFormController::class, 'medicalRecordFormReg'])->name('medicalForm.show');
    Route::post('submit-medical-form', [MedicalRecordFormController::class, 'medFormSubmit'])->name('medicalForm.store');

    #--------------AppointmentsController---------------#
    Route::get('/set-appointment', [AppointmentsController::class, 'setAppointment'])->name('setAppointment.show');
});

/**
 *  PROTECTED ROUTES FOR ADMINS
 */
Route::group(['middleware' => ['web', 'admin']], function() {
    Route::get('/admin/home',function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/admin/manual-register',[AdminAuthController::class, 'register'])->name('admin.register');
    Route::post('admin-manual-register', [AdminAuthController::class, 'manualRegister'])->name('manualRegister.store');
    Route::get('/admin/medical-record',[MedicalRecordFormController::class, 'showPatientMedFormList'])->name('admin.patientMedFormList.show');
    Route::get('/admin/medical-record/{patientID}',[MedicalRecordFormController::class, 'showPatientForm'])->name('admin.patientMedForm.show');
});

