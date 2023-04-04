<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\UserStudent;
use App\Models\MedicalRecord;
use App\Models\FamilyHistory;
use App\Models\ImmunizationHistory;
use App\Models\PastIllness;
use App\Models\PersonalSocialHistory;
use App\Models\PresentIllness;
use Session;
use Hash;
use DB;

class MedicalPatientRecordsController extends Controller
{
    public function showMedicalPatientRecord($patientID){
        try {
            // Try to find a patient with the specified applicant ID
            $patient = UserStudent::with('medicalRecord')->where('applicant_id_number', $patientID)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            try {
                // If it fails or a student ID number is used, try to find a patient with the specified student ID
                $patient = UserStudent::with('medicalRecord')->where('student_id_number', $patientID)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                // Neither applicant ID nor student ID found
                $message = 'Patient '.$patientID.' not found.';
                return redirect()->route('admin.patientMedFormList.show')->with('fail', $message);
            }
        }
    
        // Display the patient form with the found user data
        return view('admin.records')->with('patient', $patient);
    }
}
