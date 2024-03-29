<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Models\UserStudent;
use App\Models\UserPersonnel;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordPersonnel;
use App\Models\FamilyHistory;
use App\Models\ImmunizationHistory;
use App\Models\PastIllness;
use App\Models\PersonalSocialHistory;
use App\Models\PresentIllness;
use App\Models\MedicalPatientRecord;
use App\Models\MPR_Illness;
use Session;
use Hash;
use DB;
use DateTime;

class MedicalPatientRecordsController extends Controller
{
    public function showMedicalPatientRecordList(){
        $medicalPatientRecordsStudents = MedicalPatientRecord::whereNotNull('student_id')->get();
        $medicalPatientRecordsPersonnel = MedicalPatientRecord::whereNotNull('personnel_id')->get();
        return view('admin.medicalPatientRecordList')
        ->with([
            'medicalPatientRecordsStudents' => $medicalPatientRecordsStudents,
            'medicalPatientRecordsPersonnel' => $medicalPatientRecordsPersonnel
        ]);
    }
/*
    public function getMedicalPatientRecordsList(Request $request)
    {
        $searchQuery = $request->input('search');
        $filterByCampus = $request->input('campusSelect');
        $filterByCourse = $request->input('courseSelect');

        if ($filterByCampus == 'ALL'){
            $studentsList = UserStudent::select('id', 'applicant_id_number', 'student_id_number', 'last_name', 'first_name', 'middle_name')
                                        ->whereHas('medicalRecord', function($query) {
                                            $query->select('campus', 'course');
                                        })
                                        ->paginate(15);
            $personnelList = UserPersonnel::select('id', 'personnel_id_number', 'last_name', 'first_name', 'middle_name')
                                        ->whereHas('medicalRecordPersonnel', function($query) {
                                            $query->select('campus', 'designation', 'unitDepartment');
                                        })
                                        ->paginate(15);

        }
        else{
            $studentsList = UserStudent::with(['medicalRecord' => function ($query) use ($filterByCampus) {
                        $query->select('campus', 'course')->where('campus', $filterByCampus);
                    }])
                    ->select('id', 'applicant_id_number', 'student_id_number', 'last_name', 'first_name', 'middle_name')
                    ->whereHas('medicalRecord', function ($query) use ($filterByCampus) {
                        $query->where('campus', $filterByCampus);
                    })
                    ->paginate(15);

        
            $personnelList = UserPersonnel::with(['medicalRecordPersonnel' => function ($query) use ($filterByCampus) {
                        $query->select('campus', 'designation', 'unitDepartment')->where('campus', $filterByCampus);
                    }])
                    ->select('id', 'personnel_id_number', 'last_name', 'first_name', 'middle_name')
                    ->whereHas('medicalRecordPersonnel', function ($query) use ($filterByCampus) {
                        $query->where('campus', $filterByCampus);
                    })
                    ->paginate(15);  
        }
            foreach($studentsList as $student){
                $student->medical_form_url = route('admin.studentMedForm.show', [
                    'patientID' => $student->student_id_number ?: $student->applicant_id_number
                ]);

                $patientID = $student->id;
                $medical_record = MedicalRecord::where('student_id', $patientID)->first();
                
                $student->campus = $medical_record->campus;
                $student->course = $medical_record->course;
            }
            
            foreach($personnelList as $personnel){
                $personnel->medical_form_url = route('admin.personnelMedForm.show', [
                    'patientID' => $personnel->personnel_id_number
                ]);
            }
        
        return response()->json([
            'students' => $studentsList,
            'personnel' => $personnelList,
            'filterByCampus' => $filterByCampus
        ]);
    
    }
    */
    public function showMedicalPatientRecordsList(Request $request){
        $filterByCampus = $request->input('campusSelect');
        $searchQuery = $request->input('search');

        if (!isset($filterByCampus)) {
            $filterByCampus = 'College of Science';
        }

        $students = UserStudent::with(['medicalRecord' => function ($query) use ($filterByCampus) {
            $query->where('campus', $filterByCampus);
        }])
            ->select('id', 'applicant_id_number', 'student_id_number', 'last_name', 'first_name', 'middle_name', 'MR_id')
            ->whereHas('medicalRecord', function ($query) use ($filterByCampus) {
                if ($filterByCampus != 'ALL') {
                    $query->where('campus', $filterByCampus);
                }
            })
            ->when($searchQuery, function ($query, $searchQuery) {
                $query->where(function ($query) use ($searchQuery) {
                    $query->where('applicant_id_number', 'like', '%' . $searchQuery . '%')
                        ->orWhere('student_id_number', 'like', '%' . $searchQuery . '%')
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name)"), 'like', '%' . $searchQuery . '%');
                });
            })
            ->paginate(15);
            $students->appends(request()->query()); // Append query string parameters to pagination links

            foreach($students as $student){
                $student->medical_form_url = route('admin.studentMedForm.show', [
                    'patientID' => $student->student_id_number ?: $student->applicant_id_number
                ]);

                $patientID = $student->id;
                $medical_record = MedicalRecord::where('student_id', $patientID)->first();
                
                $student->campus = $medical_record->campus;
                $student->course = $medical_record->course;
            }

            $personnel = UserPersonnel::with(['medicalRecordPersonnel' => function ($query) use ($filterByCampus) {
                $query->select('campus', 'designation', 'unitDepartment');
                if ($filterByCampus !== 'ALL') {
                    $query->where('campus', $filterByCampus);
                }                
            }])
            ->select('id', 'personnel_id_number', 'last_name', 'first_name', 'middle_name', 'MRP_id')
            ->whereHas('medicalRecordPersonnel')
            ->where(function ($query) use ($filterByCampus) {
                if ($filterByCampus != 'ALL') {
                    $query->whereHas('medicalRecordPersonnel', function ($query) use ($filterByCampus) {
                        $query->where('campus', $filterByCampus);
                    });
                }
            })
            
            ->when($searchQuery, function ($query, $searchQuery) {
                $query->where(function ($query) use ($searchQuery) {
                    $query->where('personnel_id_number', 'like', '%' . $searchQuery . '%')
                        ->orWhere(DB::raw("CONCAT(first_name, ' ', middle_name, ' ', last_name)"), 'like', '%' . $searchQuery . '%');
                });
            })
            ->paginate(15);
            $personnel->appends(request()->query());

            foreach($personnel as $person){
                $person->medical_form_url = route('admin.personnelMedForm.show', [
                    'patientID' => $person->personnel_id_number
                ]);
                
                $patientID = $person->id;
                $medical_record = MedicalRecordPersonnel::where('personnel_id', $patientID)->first();

                if ($medical_record) {
                    $person->campus = $medical_record->campus;
                    $person->designation = $medical_record->designation;
                    $person->unitDepartment = $medical_record->unitDepartment;
                }
            }

        return view('admin.medicalPatientRecords', [
            'students' => $students,
            'personnel' => $personnel,
        ]);
    }

    public function filterDate(Request $request){
        $dateToFilter = $request->input('date');
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
        }
        // Display the patient form with the found user data
        $patientID = $patient->id;
            
        if($patient->user_type == 'PATIENT-STUDENT'){
            $medicalPatientRecords = MedicalPatientRecord::where('student_id', $patientID)
            ->orderBy('date_of_exam')
            ->get();
        }elseif($patient->user_type == 'PATIENT-PERSONNEL'){
            $medicalPatientRecords = MedicalPatientRecord::where('personnel_id', $patientID)
            ->orderBy('date_of_exam')
            ->get();
        }
        
        return view('admin.medicalPatientRecord')
                ->with('patient', $patient)
                ->with('medicalPatientRecords', $medicalPatientRecords);
    }

    public function storeMedicalPatientRecord (Request $request){
            $request->validate([
                'patientID' => 'required|int',
                'patientType' => 'required',
                'date' => 'required|date_format:d-F-Y',
                'temperature' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'bloodPressure' => 'required|regex:/^\d+\/\d+$/',
                'weight' => 'required|string',
                'height' => 'required|string',
                'historyAndPhysicalExamination' => 'required|string',
                'physicianDirections' => 'required|string',
            ]);

                // Extracting of Dates                 
                $new_mpr_date = DateTime::createFromFormat('d-F-Y', $request->date);
                $year = $new_mpr_date->format('Y');
                $month = $new_mpr_date->format('F');
                

                $new_mpr_illness = new MPR_Illness();
                    $new_mpr_illness->hypertension = $request->filled('hypertension') ?: '0';
                    $new_mpr_illness->asthma = $request->filled('asthma') ?: '0';
                    $new_mpr_illness->mumps = $request->filled('mumps') ?: '0';
                    $new_mpr_illness->diabetes = $request->filled('diabetes') ?: '0';
                    $new_mpr_illness->rheumatic_fever = $request->filled('rheumaticFever') ?: '0';
                    $new_mpr_illness->cardiac_disease = $request->filled('cardiacDisease') ?: '0';
                    $new_mpr_illness->kidney_disease = $request->filled('kidneyDisease') ?: '0';
                    $new_mpr_illness->seizure_disorder = $request->filled('seizureDisorder') ?: '0';
                    $new_mpr_illness->chicken_pox = $request->filled('chickenPox') ?: '0';
                    $new_mpr_illness->measles = $request->filled('measles') ?: '0';
                    $new_mpr_illness->hepatitis = $request->filled('hepatitis') ?: '0';
                    $new_mpr_illness->tuberculosis = $request->filled('tuberculosis') ?: '0';
                    $new_mpr_illness->diphteria = $request->filled('diphteria') ?: '0';
                    $new_mpr_illness->allergy = $request->filled('allergy') ?: '0';
                    $new_mpr_illness->allergyDetails = $request->filled('allergyDetails') ?: 'N/A';
                    $new_mpr_illness->others = $request->filled('others') ?: '0';
                    $new_mpr_illness->othersDetails = $request->filled('othersDetails') ?: 'N/A';
                $res = $new_mpr_illness->save();

                $new_mpr = new MedicalPatientRecord();
                try{
                    if($request->patientType == 'PATIENT-PERSONNEL'){
                        $patient = UserPersonnel::where('id', $request->patientID)->first();
                        $new_mpr->personnel->id = $patient->id;
                    }
                    elseif($request->patientType == 'PATIENT-STUDENT'){
                        $patient = UserStudent::where('id', $request->patientID)->first();
                        $new_mpr->student_id = $patient->id;
                    }
                } 
                catch (ModelNotFoundException $e) {
                    $message = 'Patient not found.';
                    return redirect()->route('admin.patientMedFormList.show')->with('fail', $message);
                }
                    $new_mpr->MPR_illnessID = $new_mpr_illness->MPR_illnessID ;
                    $new_mpr->date_of_exam = DateTime::createFromFormat('d-F-Y', $request->date)->format('Y-m-d');
                    // SAVE MONTH AND YEAR OF EXAM HER
                    $new_mpr->temperature = filter_var($request->temperature, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $new_mpr->bloodPressure = filter_var($request->bloodPressure, FILTER_SANITIZE_STRING);
                    $new_mpr->weight = filter_var($request->weight, FILTER_SANITIZE_STRING);
                    $new_mpr->height = html_entity_decode(filter_var($request->height, FILTER_SANITIZE_STRING));
                    $new_mpr->historyAndPhysicalExamination = filter_var($request->historyAndPhysicalExamination, FILTER_SANITIZE_STRING);
                    $new_mpr->physicianDirections = filter_var($request->physicianDirections, FILTER_SANITIZE_STRING);
                $res = $new_mpr->save();

                $new_mpr_illness->MPR_id = $new_mpr->MPR_id;
                $new_mpr_illness->save();

                return redirect()->back()->with('success', 'Medical Patient Record successfully saved.');

    }
}
