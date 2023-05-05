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

    #------------MedicalRecordFormController------------#
    Route::post('/medical-record-check-auth', [MedicalRecordFormController::class, 'checkAuthentication'])->name('medicalForm.checkAuth');

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
Route::get('/admin/manual-register',[AdminAuthController::class, 'register'])->name('admin.register');
    Route::post('admin/manual-register', [AdminAuthController::class, 'manualRegister'])->name('manualRegister.store');

Route::group(['middleware' => ['web', 'admin']], function(){
    Route::get('/admin/home',function () {
        return view('admin.home');
    })->name('admin.home');
   
    
    // POST for Importing CSV File (users_students table) //
    Route::post('/admin/import-new-students', [ImportController::class, 'importNew'])->name('import.store.new');
    // For old
    Route::post('/admin/import-old-students', [ImportController::class, 'importOld'])->name('import.store.old');
    // POST for Importing CSV File (users_personnel table) //
    Route::post('/admin/import-personnel', [ImportController::class, 'importPersonnel'])->name('import.store.personnel');

    Route::get('/admin/walk-in/student-health-record',[MedicalRecordFormController::class, 'showWalkInHealthRecord'])->name('admin.walkInHealthRecord.show');
    Route::get('/admin/walk-in/personnel-health-record',[MedicalRecordFormController::class, 'showWalkInHealthRecordPersonnel'])->name('admin.walkInHealthRecordPersonnel.show');

    /* STUDENT FORMS */
    Route::get('/admin/medical-record',[MedicalRecordFormController::class, 'showPatientMedFormList'])->name('admin.patientMedFormList.show');
    Route::get('/admin/medical-record/{patientID}',[MedicalRecordFormController::class, 'showPatientForm'])->name('admin.studentMedForm.show');
    Route::get('/admin/medical-record/{patientID}/edit',[MedicalRecordFormController::class, 'editMedRecord'])->name('admin.medRecord.edit');
    Route::patch('/admin/medical-record/{patientID}',[MedicalRecordFormController::class, 'updateMedRecord'])->name('admin.medRecord.update');
    Route::delete('/admin/medical-record/{patientID}',[MedicalRecordFormController::class, 'destroyMedRecord'])->name('admin.medRecord.destroy');

    /* PERSONNEL FORMS */
    Route::get('/admin/personnel-medical-record',[MedicalRecordFormController::class, 'showPersonnelMedFormList'])->name('admin.personnelMedFormList.show');
    Route::get('/admin/personnel-medical-record/{patientID}',[MedicalRecordFormController::class, 'showPersonnelForm'])->name('admin.personnelMedForm.show');
    Route::get('/admin/personnel-medical-record/{patientID}/edit',[MedicalRecordFormController::class, 'editPersonnelMedRecord'])->name('admin.personnelMedRecord.edit');
    Route::patch('/admin/personnel-medical-record/{patientID}',[MedicalRecordFormController::class, 'updatePersonnelMedRecord'])->name('admin.personnelMedRecord.update');
    Route::delete('/admin/personnel-medical-record/{patientID}',[MedicalRecordFormController::class, 'destroyPersonnelMedRecord'])->name('admin.personnelMedRecord.destroy');

    Route::post('admin/submit-medical-form', [MedicalRecordsAdminController::class, 'medFormSubmitAdmin'])->name('medicalFormAdmin.store');
    Route::post('admin/personnel-submit-medical-form', [MedicalRecordsAdminController::class, 'medicalRecordsPersonnelAdmin'])->name('medicalFormAdminPersonnel.store');

    Route::get('/admin/medical-patient-records', [MedicalPatientRecordsController::class, 'showMedicalPatientRecordList'])->name('admin.medPatientRecordList.show');
    Route::post('admin/medical-patient-record', [MedicalPatientRecordsController::class, 'storeMedicalPatientRecord'])->name('admin.medicalPatientRecord.store');
    Route::get('/admin/medical-patient-record/{patientID}', [MedicalPatientRecordsController::class, 'showMedicalPatientRecord'])->name('admin.medicalPatientRecord.show');
    Route::get('/admin/medical-patient-record/{patientID}/edit', [MedicalPatientRecordsController::class, 'editMedicalPatientRecord'])->name('admin.medicalPatientRecord.edit');
    Route::patch('admin/medical-patient-record/{patientID}', [MedicalPatientRecordsController::class, 'updateMedicalPatientRecord'])->name('admin.medicalPatientRecord.update');
    Route::delete('/admin/medical-patient-record/{patientID}', [MedicalPatientRecordsController::class, 'destroyMedicalPatientRecord'])->name('admin.medicalPatientRecord.destroy');
	
	Route::get('/admin/reports', [AdminReportsController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/appointments', [AppointmentsController::class, 'showAdminAppointments'])->name('admin.appointments.show');
    Route::post('admin/check-password', [AdminAuthController::class, 'checkPassword'])->name('admin.checkPassword');
	Route::post('admin/appointments-store', [AppointmentsController::class, 'adminAppointmentsStore'])->name('admin.appointments.store');
    Route::get('/admin/appointment/medical-record/{patientType}/{patientID}/{ticketID}', [AppointmentsController::class, 'adminShowMedRecordFromAppointment'])->name('admin.med-record-from-appointment.show');
    Route::get('/admin/getUserOfAppointment', [AppointmentsController::class, 'getUserOfAppointment'])->name('admin.UserOfAppointment.get');
    Route::post('/admin/release-medical-certificate/{userTicketID}', [MedicalRecordsAdminController::class, 'releaseMedCertFromAppointment'])->name('admin.releaseMedCertFromAppointment');
    Route::post('/admin/release-medical-certificate/{patientID}', [MedicalRecordsAdminController::class, 'releaseMedCert'])->name('admin.releaseMedCert');
});
