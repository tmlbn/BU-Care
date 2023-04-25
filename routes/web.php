<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\BUCareAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicalRecordFormController;
use App\Http\Controllers\MedicalRecordsAdminController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\MedicalPatientRecordsController;
use App\Http\Controllers\AdminReportsController;

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

Route::get('/', function () {
    if(Auth::guard('admin')->check()){
        return view('admin.home');
    }
        return view('home');
})->name('home');

/**
 *  GUEST PROTECTED ROUTES
 */
Route::group(['middleware' => ['guest']], function() {
    Route::get('/login', [BUCareAuthController::class, 'login'])->name('login')->middleware('guest');
    Route::get('/personnel-login', [BUCareAuthController::class, 'personnelLogin'])->name('personnel.login')->middleware('guest');
    Route::post('BUCare', [BUCareAuthController::class, 'BUCareLogin'])->name('BUCare.login')->middleware('guest');
    Route::get('/admin/login', [AdminAuthController::class, 'showAdminLogin'])->name('admin.login.show')->middleware('guest');
    Route::post('admin-login', [AdminAuthController::class, 'adminLogin'])->name('admin.login')->middleware('guest');
});

/**
 *  PROTECTED ROUTES FOR STUDENTS
 */
Route::group(['middleware' => ['web', 'auth']], function() {
   
    #------------MedicalRecordFormController------------#
    Route::get('/medical-record-form',[MedicalRecordFormController::class, 'medicalRecordFormReg'])->name('medicalForm.show');
    Route::post('submit-medical-form', [MedicalRecordFormController::class, 'medFormSubmit'])->name('medicalForm.store');
    Route::post('/medical-record-check-auth', [MedicalRecordFormController::class, 'checkAuthentication'])->name('medicalForm.checkAuth');

});

/**
 *  PROTECTED ROUTES FOR PERSONNEL
 */
Route::group(['middleware' => ['web', 'employee']], function() {

    Route::post('personnel/validate-password', [BUCareAuthController::class, 'personnelValidatePassword'])->name('personnelPassword.validate');
    Route::get('/personnel/medical-record-form',[MedicalRecordFormController::class, 'personnelMedicalRecordFormReg'])->name('personnel.medicalForm.show');
    Route::post('/personnel/submit-medical-form', [MedicalRecordFormController::class, 'personnelMedFormSubmit'])->name('personnel.medicalForm.store');
});
/**
 *  PROTECTED ROUTES FOR ANY(Personnel, Students, and Admin/Clinic)
 */
Route::group(['middleware' => ['web', 'auth.any']], function() {
    #---------------BUCareAuthController---------------#
    Route::post('logout', [BUCareAuthController::class, 'logout'])->name('logout');
    Route::get('/check-password', [BUCareAuthController::class, 'checkPassword'])->name('password.check');
    #--------------AppointmentsController---------------#
    Route::get('/set-appointment', [AppointmentsController::class, 'setAppointment'])->name('setAppointment.show');
    Route::get('/check-availability', [AppointmentsController::class, 'checkAvailability'])->name('availability.check');
    Route::post('appointmentStore', [AppointmentsController::class, 'appointmentStore'])->name('appointmentDetails.store');
    
    Route::get('/get-entries', [AppointmentsController::class, 'getEntries'])->name('entries.fetch');
    Route::delete('/appointment-delete', [AppointmentsController::class, 'appointmentDelete'])->name('appointment.destroy');
    Route::get('/get-appointment/update', [AppointmentsController::class, 'getAppointmentToUpdate'])->name('get.appointment.update');
    Route::patch('/update-appointment/{ticketID}/edit', [AppointmentsController::class, 'updateAppointment'])->name('appointment.update');
});

/**
 *  PROTECTED ROUTES FOR ADMINS
 */
Route::group(['middleware' => ['web', 'admin']], function(){
    Route::get('/admin/home',function () {
        return view('admin.home');
    })->name('admin.home');
   
    Route::get('/admin/manual-register',[AdminAuthController::class, 'register'])->name('admin.register');
    Route::post('admin/manual-register', [AdminAuthController::class, 'manualRegister'])->name('manualRegister.store');
    // POST for Importing CSV File (users_students table) //
    Route::post('/admin/import-new-students', [ImportController::class, 'import'])->name('import.store');
    // POST for Importing CSV File (users_personnel table) //
    Route::post('/admin/import-new-personnel', [ImportController::class, 'import'])->name('import.store');

    Route::get('/admin/medical-record',[MedicalRecordFormController::class, 'showPatientMedFormList'])->name('admin.patientMedFormList.show');
    Route::get('/admin/medical-record/{patientID}',[MedicalRecordFormController::class, 'showPatientForm'])->name('admin.patientMedForm.show');
    Route::get('/admin/medical-record/{patientID}/edit',[MedicalRecordFormController::class, 'editMedRecord'])->name('admin.medRecord.edit');
    Route::patch('/admin/medical-record/{patientID}',[MedicalRecordFormController::class, 'updateMedRecord'])->name('admin.medRecord.update');
    Route::delete('/admin/medical-record/{patientID}',[MedicalRecordFormController::class, 'destroyMedRecord'])->name('admin.medRecord.destroy');

    Route::post('admin/submit-medical-form', [MedicalRecordsAdminController::class, 'medFormSubmitAdmin'])->name('medicalFormAdmin.store');

    Route::get('/admin/medical-patient-records', [MedicalPatientRecordsController::class, 'showMedicalPatientRecordList'])->name('admin.medPatientRecordList.show');
    Route::post('admin/medical-patient-record', [MedicalPatientRecordsController::class, 'storeMedicalPatientRecord'])->name('admin.medicalPatientRecord.store');
    Route::get('/admin/medical-patient-record/{patientID}', [MedicalPatientRecordsController::class, 'showMedicalPatientRecord'])->name('admin.medicalPatientRecord.show');
    Route::get('/admin/medical-patient-record/{patientID}/edit', [MedicalPatientRecordsController::class, 'editMedicalPatientRecord'])->name('admin.medicalPatientRecord.edit');
    Route::patch('admin/medical-patient-record/{patientID}', [MedicalPatientRecordsController::class, 'updateMedicalPatientRecord'])->name('admin.medicalPatientRecord.update');
    Route::delete('/admin/medical-patient-record/{patientID}', [MedicalPatientRecordsController::class, 'destroyMedicalPatientRecord'])->name('admin.medicalPatientRecord.destroy');
	
	Route::get('/admin/reports', [AdminReportsController::class, 'reports'])->name('admin.reports');
});
