<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\UserStudent;
use App\Models\UserPersonnel;
use App\Models\MedicalRecord;
use App\Models\FamilyHistory;
use App\Models\ImmunizationHistory;
use App\Models\PastIllness;
use App\Models\PersonalSocialHistory;
use App\Models\PresentIllness;
use App\Models\MedicalPatientRecord;
use Session;
use Hash;
use DB;
use DateTime;

class MedicalPatientRecordsController extends Controller
{
    public function showMedicalPatientRecordList(){
        $medicalPatientRecords = MedicalPatientRecord::all();
        return view('admin.medicalPatientRecordList')->with(compact('medicalPatientRecords'));
    }

    public function showMedicalPatientRecord($patientID){
        try {
            // Try to find a patient with the specified ID as applicantID
            $patient = UserStudent::with('medicalRecord')
                ->where('applicant_id_number', $patientID)
                ->where('hasMedRecord', 1)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            try {
                // If it fails or a student ID number is used, try to find a patient with the specified ID as studentID
                $patient = UserStudent::with('medicalRecord')
                ->where('student_id_number', $patientID)
                ->where('hasMedRecord', 1)
                ->firstOrFail();
            } catch (ModelNotFoundException $e) {
                try {
                    // If it still fails, try to find a patient with the specified ID as peronnelID
                    $patient = UserPersonnel::with('medicalRecord')
                    ->where('personnel_id_number', $patientID)
                    ->where('hasMedRecord', 1)
                    ->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    // Neither applicant ID nor student ID found
                    $message = 'Patient '.$patientID.' not found.';
                    return redirect()->route('admin.medPatientRecordList.show')->with('fail', $message);
                }
            }
            // Display the patient form with the found user data
            $patientID = $patient->id;
            if($patient->user_type == 'PATIENT/STUDENT'){
                $medicalPatientRecords = MedicalPatientRecord::where('student_id', $patientID)->get();
            }elseif($patient->user_type == 'PATIENT/PERSONNEL'){
                $medicalPatientRecords = MedicalPatientRecord::where('personnel_id', $patientID)->get();
            }
            
            return view('admin.medicalPatientRecord')
                    ->with('patient', $patient)
                    ->with('medicalPatientRecords', $medicalPatientRecords);
        }
    }

    public function storeMedicalPatientRecord (Request $request){
            $request->validate([
                'patientID' => 'required|int',
                'date' => 'required|date_format:d-F-Y',
                'temperature' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'bloodPressure' => 'required|regex:/^\d+\/\d+$/',
                'weight' => 'required|string',
                'height' => 'required|string',
                'historyAndPhysicalExamination' => 'required|string',
                'physicianDirections' => 'required|string',
            ]);

            try {
                $new_mpr = new MedicalPatientRecord();
                    $new_mpr->student_id = filter_var($request->studentID,  FILTER_SANITIZE_NUMBER_INT);
                    $new_mpr->date = DateTime::createFromFormat('d-F-Y', $request->date)->format('Y-m-d');
                    $new_mpr->temperature = filter_var($request->temperature, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $new_mpr->blood_pressure = filter_var($request->bloodPressure, FILTER_SANITIZE_STRING);
                    $new_mpr->weight = filter_var($request->weight, FILTER_SANITIZE_STRING);
                    $new_mpr->height = html_entity_decode(filter_var($request->height, FILTER_SANITIZE_STRING));
                    $new_mpr->historyPhysical_examinations = filter_var($request->historyAndPhysicalExamination, FILTER_SANITIZE_STRING);
                    $new_mpr->physician_directions = filter_var($request->physicianDirections, FILTER_SANITIZE_STRING);
                $res = $new_mpr->save();
                
                
                if($res){
                    return back()->with('success','Medical Patient Record form submitted.');
                } else {
                    // Log error and display user-friendly message
                    Log::error('Failed to submit.');
                    return back()->with('fail','Failed to submit. Please try again later.');
                }
                
            } catch (\Throwable $th) {
                // Log error and display user-friendly message
                Log::error('Failed to submit: ' . $th->getMessage());
                return back()->with('fail','Failed to submit. Please try again later');
            }
    }
}
