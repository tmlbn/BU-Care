<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use DateTime;
use Session;
use Hash;
use DB;

# Students
use App\Models\UserStudent;
use App\Models\MedicalRecord;
use App\Models\FamilyHistory;
use App\Models\ImmunizationHistory;
use App\Models\PastIllness;
use App\Models\PersonalSocialHistory;
use App\Models\PresentIllness;
# Personnel
use App\Models\UserPersonnel;
use App\Models\MedicalRecordPersonnel;
use App\Models\MRP_FamilyHistory;
use App\Models\MRP_ImmunizationHistory;
use App\Models\MRP_PersonalMedicalCondition;
use App\Models\MRP_PersonalSocialHistory;

class MedicalRecordFormController extends Controller
{
    /* ACCESS MEDICAL FORM */
    public function medicalRecordFormReg(){
        if(Auth::check()){
            /* VALIDATION STATEMENT/METHOD TO SEE IF USER ALREADY HAS SUBMITTED MEDICAL FORM */
                if(Auth::user()->hasMedRecord == 0){
                    $user = Auth::user();
                    $birthYear = $user->birth_year;
                    $birthMonth = $user->birth_month;
                    $birthDate = $user->birth_date;

                    $dateString = $birthYear . '-' . $birthMonth . '-' . $birthDate;
                    $date = date_create($dateString);
                    
                    $formattedBirthDate = $date->format('Y F d');
                    return view('medicalRecordForm')->with([
                        'user' => $user,
                        'birthDate' => $formattedBirthDate
                    ]);
                }
            return redirect()->back()->with('warning', 'You have already submitted your Medical Form!');
        }
        else{
            return redirect('login');
        }
    }

    public function showPatientMedFormList()
    {
        $studentsList = UserStudent::whereHas('medicalRecord', function ($query){
            $query->where('campus', 'College of Science');
        })->paginate(15);

        $personnelList = UserPersonnel::whereHas('medicalRecordPersonnel', function ($query){
            $query->where('campus', 'College of Science');
        })->paginate(15);

        return view('admin.medicalRecordList', [
            'students' => $studentsList,
            'personnel' => $personnelList,
        ]);
    }

    public function showPersonnelMedFormList(){
        $personnelList = UserPersonnel::whereHas('medicalRecordPersonnel', function ($query){
            $query->where('campus', 'College of Science');
        })->paginate(15);

        return view('admin.medicalRecordListPersonnel', [
            'personnel' => $personnelList,
        ]);
    }

    public function searchStudentMedForm(Request $request)
    {
        $filterByCampus = $request->input('campusSelect');
        $searchQuery = $request->input('search');
    
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

        return view('admin.medicalRecordList', 
               compact(
                    'students',
                    'filterByCampus'
               ));
    }

    public function searchPersonnelMedForm(Request $request)
    {
        $filterByCampus = $request->input('campusSelect');
        $searchQuery = $request->input('search');

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
        return view('admin.medicalRecordListPersonnel', 
               compact(
                    'personnel',
                    'filterByCampus'
               ));
    }
    
/*
    public function getMedicalRecordsList(Request $request)
    {
        $searchQuery = $request->input('search');
        $filterByCampus = $request->input('campusSelect');


        if ($filterByCampus == 'ALL'){
            $students = UserStudent::select('id', 'applicant_id_number', 'student_id_number', 'last_name', 'first_name', 'middle_name')
                                        ->whereHas('medicalRecord', function($query) {
                                            $query->select('campus', 'course');
                                        })
                                        ->paginate(15);
            $personnel = UserPersonnel::select('id', 'personnel_id_number', 'last_name', 'first_name', 'middle_name')
                                        ->whereHas('medicalRecordPersonnel', function($query) {
                                            $query->select('campus', 'designation', 'unitDepartment');
                                        })
                                        ->paginate(15);

        }
        else{
            $students = UserStudent::with(['medicalRecord' => function ($query) use ($filterByCampus) {
                        $query->select('campus', 'course')->where('campus', $filterByCampus);
                    }])
                    ->select('id', 'applicant_id_number', 'student_id_number', 'last_name', 'first_name', 'middle_name')
                    ->whereHas('medicalRecord', function ($query) use ($filterByCampus) {
                        $query->where('campus', $filterByCampus);
                    })
                    ->paginate(15);

        
            $personnel = UserPersonnel::with(['medicalRecordPersonnel' => function ($query) use ($filterByCampus) {
                        $query->select('campus', 'designation', 'unitDepartment')->where('campus', $filterByCampus);
                    }])
                    ->select('id', 'personnel_id_number', 'last_name', 'first_name', 'middle_name')
                    ->whereHas('medicalRecordPersonnel', function ($query) use ($filterByCampus) {
                        $query->where('campus', $filterByCampus);
                    })
                    ->paginate(15);  
        }
            foreach($students as $student){
                $student->medical_form_url = route('admin.studentMedForm.show', [
                    'patientID' => $student->student_id_number ?: $student->applicant_id_number
                ]);

                $patientID = $student->id;
                $medical_record = MedicalRecord::where('student_id', $patientID)->first();
                
                $student->campus = $medical_record->campus;
                $student->course = $medical_record->course;
            }
            
            foreach($personnel as $prof){
                $prof->medical_form_url = route('admin.personnelMedForm.show', [
                    'patientID' => $prof->personnel_id_number
                ]);

                $patientID = $prof->id;
                $medical_record = MedicalRecordPersonnel::where('personnel_id', $patientID)->first();
                
                $prof->campus = $medical_record->campus;
                $prof->designation = $medical_record->designation;
                $prof->unitDepartment = $medical_record->unitDepartment;
            }
            
        return view('admin.medicalRecordList', 
            compact(
                    'students',
                    'personnel',
                    ));
    }
*/
    public function showPatientForm($patientID){
        try {
            // Try to find a patient with the specified applicant ID
            $student = UserStudent::with('medicalRecord')
                                    ->where('applicant_id_number', $patientID)
                                    ->where('hasMedRecord', 1)
                                    ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            try {
                // If it fails or a student ID number is used, try to find a patient with the specified student ID
                $student = UserStudent::with('medicalRecord')
                                        ->where('student_id_number', $patientID)
                                        ->where('hasMedRecord', 1)
                                        ->firstOrFail();
            } catch (ModelNotFoundException $e) {
                // Neither applicant ID nor student ID found
                $message = 'Patient '.$patientID.' not found.';
                return redirect()->route('admin.patientMedFormList.show')->with('fail', $message);
            }
        }
    
        // Display the patient form with the found user data
        return view('admin.ClinicSideMedicalRecordForm')->with('patient', $student);
    }

    public function checkAuthentication(Request $request){
        if($request->input('password')){
            $password = $request->input('password');
            $user = Auth::user() ?: Auth::guard('employee')->user();
            
            if (!Hash::check($password, $user->password)) {
                $response = 'Invalid Password';
                return response()->json(['error' => $response]);
            }

            $response = 'Password match';
            return response()->json(['success' => $response]);
        }
        else{
            $applicantID = $request->input('applicantID');
            $birthYear = $request->input('birthYear');
            $birthMonth = $request->input('birthMonth');
            $birthDate = $request->input('birthDate');
            $user = Auth::user();

            if($user->applicant_id_number == $applicantID && 
            $user->birth_year == $birthYear && 
            $user->birth_month == $birthMonth && 
            $user->birth_date == $birthDate){
                $response = 'Authentican passed';
                return response()->json(['success' => $response]);
            }
            else{
                $response = 'Invalid Authentication';
                return response()->json(['error' => $response]);
            }
        }
    }

        #####---MEDICAL RECORD FORM SUBMISSION---#####
    public function medFormSubmit(Request $request){
        //dd($request);
                /* PHONE NUMBER */
        $rules = [
            'MR_parentGuardianContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
            'MR_studentContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
            'MR_emergencyContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
        ];
        $validator = Validator::make($request->only(['MR_parentGuardianContactNumber', 'MR_studentContactNumber', 'MR_emergencyContactNumber']), $rules);
            // Return error message if validation fails
        if ($validator->fails()) {
            #dd($validator);
            return back()->withErrors($validator)->withInput();
        }
                /* VALIDATE USER INPUT */
        $validator = Validator::make($request->all(), [
            /* BASIC INFORMATION */
            'campusSelect' => 'required',
            'courseSelect' => 'required',
            'schoolYearStart' => 'required_with:schoolYearEnd|integer|min:2015',
            'schoolYearEnd' => [
                'required_with:schoolYearStart',
                'integer',
                'gt:schoolYearStart',
                function ($attribute, $value, $fail) use ($request) {
                    $start = $request->input('schoolYearStart');
                    if ($value != $start + 1) {
                        $fail('The end school year must be exactly one greater than school year start.');
                    }
                },
            ],
            'MR_lastName' => 'required|string',
            'MR_firstName' => 'required|string',
            'MR_middleName' => 'nullable',
            'MR_age' => 'required|integer',
            'MR_sex' => 'required|string',
            'MR_dateOfBirth' => 'required',
            'MR_civilStatus' => 'required|string',
            'MR_nationality' => 'required|string',
            'MR_addressRegion' => 'required|string',
            'MR_addressProvince' => 'required|string',
            'MR_addressCityMunicipality' => 'required|string',
            'MR_addressBrgySubdVillage' => 'required|string',
            'MR_addressHouseNoStreet' => 'nullable|string',
            'MR_fatherName' => 'required|string',
            'MR_fatherOccupation' => 'nullable',
            'MR_fatherOffice' => 'nullable',
            'MR_motherName' => 'required|string',
            'MR_motherOccupation' => 'nullable',
            'MR_motherOffice' => 'nullable',
            'MR_guardian' => 'nullable|string',
            'MR_guardianAddress' => 'nullable|required_with:MR_guardian|string',
            'MR_emergencyContactName' => 'required|string',
            'MR_emergencyContactOccupation' => 'required|string',
            'MR_emergencyContactRelationship' => 'required|string',
            'MR_emergencyContactAddress' => 'required|string',

            /* FAMILY HISTORY[FH_] */
            'FH_cancer' => 'required|in:0,1', 
            'FH_heartDisease' => 'required|in:0,1', 
            'FH_hypertension' => 'required|in:0,1', 
            'FH_thyroidDisease' => 'required|in:0,1', 
            'FH_tuberculosis' => 'required|in:0,1', 
            'FH_diabetesMelittus' => 'required|in:0,1', 
            'FH_mentalDisorder' => 'required|in:0,1', 
            'FH_asthma' => 'required|in:0,1', 
            'FH_convulsions' => 'required|in:0,1', 
            'FH_bleedingDyscrasia' => 'required|in:0,1', 
            'FH_eyeDisorder' => 'required|in:0,1', 
            'FH_skinProblems' => 'required|in:0,1', 
            'FH_kidneyProblems' => 'required|in:0,1', 
            'FH_gastroDisease' => 'required|in:0,1', 
            'FH_others' => 'required|in:0,1', 
            'FH_othersDetails' => 'required_if:FH_others,1|string', 

            /* PERSONAL SOCIAL HISTORY[PSH_] */
            'PSH_smoking' => 'required|in:0,1', 
            'PSH_smoking_amount' => 'required_if:PSH_smoking,1|int', 
            'PSH_smoking_freq' => 'required_if:PSH_smoking,1|int', 
            'PSH_drinking' => 'required|in:0,1',
            'PSH_drinking_amountOfBeer' => 'nullable|string',
            'PSH_drinking_freqOfBeer' => 'nullable|required_with:PSH_drinking_amountOfBeer|string',
            'PSH_drinking_amountofShots' => 'nullable|string',
            'PSH_drinking_freqOfShots' => 'nullable|required_with:PSH_drinking_amountofShots|string',

            /* PAST ILLNESS[pi_] */
            'pi_primaryComplex' => 'required|in:0,1', 
            'pi_chickenPox' => 'required|in:0,1', 
            'pi_kidneyDisease' => 'required|in:0,1', 
            'pi_typhoidFever' => 'required|in:0,1', 
            'pi_earProblems' => 'required|in:0,1', 
            'pi_heartDisease' => 'required|in:0,1', 
            'pi_leukemia' => 'required|in:0,1', 
            'pi_asthma' => 'required|in:0,1', 
            'pi_diabetes' => 'required|in:0,1', 
            'pi_eyeDisorder' => 'required|in:0,1', 
            'pi_pneumonia' => 'required|in:0,1', 
            'pi_dengue' => 'required|in:0,1', 
            'pi_measles' => 'required|in:0,1', 
            'pi_hepatitis' => 'required|in:0,1', 
            'pi_rheumaticFever' => 'required|in:0,1', 
            'pi_mentalDisorder' => 'required|in:0,1', 
            'pi_skinProblems' => 'required|in:0,1', 
            'pi_poliomyetis' => 'required|in:0,1', 
            'pi_thyroidDisorder' => 'required|in:0,1', 
            'pi_anemia' => 'required|in:0,1', 
            'pi_mumps' => 'required|in:0,1', 

            /* PRESENT ILLNESS[PI_] */
            'PI_chestPain' => 'required|in:0,1', 
            'PI_insomnia' => 'required|in:0,1', 
            'PI_jointPains' => 'required|in:0,1', 
            'PI_dizziness' => 'required|in:0,1', 
            'PI_headaches' => 'required|in:0,1', 
            'PI_indigestion' => 'required|in:0,1', 
            'PI_swollenFeet' => 'required|in:0,1', 
            'PI_weightLoss' => 'required|in:0,1', 
            'PI_nauseaOrVomiting' => 'required|in:0,1', 
            'PI_soreThroat' => 'required|in:0,1', 
            'PI_frequentUrination' => 'required|in:0,1', 
            'PI_difficultyOfBreathing' => 'required|in:0,1', 
            'PI_others' => 'required|in:0,1', 
            'PI_othersDetails' => 'required_if:PI_others,1|string', 

            /* HOSPITALIZATION, REGULAR MEDS, AND ALLREGIES */
            'hospitalization' => 'required|in:0,1', 
            'hospitalizationDetails' => 'required_if:hospitalization,1|string', 
            'regMeds' => 'required|in:0,1', 
            'regMedsDetails' => 'required_if:regMeds,1|string', 
            'allergy' => 'required|in:0,1', 
            'allergyDetails' => 'required_if:allergy,1|string', 

            /* IMMUNIZATION HISTORY[IH_] */
            'IH_bcg' => 'required|in:0,1', 
            'IH_polio' => 'required|in:0,1', 
            'IH_mumps' => 'required|in:0,1', 
            'IH_typhoid' => 'required|in:0,1', 
            'IH_hepatitisA' => 'required|in:0,1', 
            'IH_chickenPox' => 'required|in:0,1', 
            'IH_dpt' => 'required|in:0,1', 
            'IH_measles' => 'required|in:0,1', 
            'IH_germanMeasles' => 'required|in:0,1', 
            'IH_hepatitisB' => 'required|in:0,1', 
            'IH_others' => 'required|in:0,1', 
            'IH_othersDetails' => 'required_if:FH_others,1|string',
            
            'MR_chestXray' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'MR_cbcresults' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'MR_hepaBscreening' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'MR_bloodtype' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'certify' => 'required|in:1',

            /* NAME OF UPLOADS */
            'MR_additionalResult1' => 'nullable|string',
            'MR_additionalResult2' => 'nullable|string',
            'MR_additionalResult3' => 'nullable|string',
            'MR_additionalResult4' => 'nullable|string',
            'MR_additionalResult5' => 'nullable|string',
            'MR_additionalResult6' => 'nullable|string',
            'MR_additionalResult7' => 'nullable|string',
            'MR_additionalResult8' => 'nullable|string',

            /* UPLOADS */
            'MR_additionalUpload1' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload2' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'MR_additionalUpload3' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload4' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'MR_additionalUpload5' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload6' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'MR_additionalUpload7' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload8' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',

        ],[ #--- CATCH SPECIFIC ERRORS ---#
            'campusSelect.required' => 'Please select a campus.',
            'courseSelect.required' => 'Please select a course.',
            'schoolYearStart.required_with' => 'Please provide a start year.',
            'schoolYearStart.integer' => 'The start year must be a number.',
            'schoolYearStart.min' => 'The start year must be at least 2015.',
            'schoolYearEnd.required_with' => 'Please provide an end year.',
            'schoolYearEnd.integer' => 'The end year must be a number.',
            'schoolYearEnd.gt' => 'The end year must be greater than the start year.',
            'PSH_smoking_amount.required_if' => 'Please provide the amount of cigarettes.',
            'PSH_smoking_freq.required_if' => 'Please provide the frequency of cigarette consumption.',
            'PSH_drinking_amountOfBeer.required_without_all' => 'Please indicate the amount of beer you drink.',
            'PSH_drinking_freqOfBeer.required_without_all' => 'Please indicate the frequency of beer you drink.',
            'PSH_drinking_amountofShots.required_without_all' => 'Please indicate the amount of shots you drink.',
            'PSH_drinking_freqOfShots.required_without_all' => 'Please indicate the frequency of shots you drink.',
            'PI_othersDetails.required_if' => 'Please provide the details of your other Present Illness/es',
            'hospitalizationDetails.required_if' => 'Please provide the details of your hospitalization for serious illness, operation, fracture or injury.',
            'regMedsDetails.required_if' => 'Please provide the name/s of your regular drug/s.',
            'allergyDetails.required_if' => 'Please specify your allergy details.',
            'FH_othersDetails.required_if' => 'Please provide the details of your other disease/s in Family History.',
            'IH_othersDetails.required_if' => 'Please provide the details of other immunization you have taken.',
            'certify.required' => 'Please certify that the foregoing answers are true and complete, and to the best of my knowledge by checking the checkbox.'
        ]); /* END OF VALIDATION */

        // Return error message if validation fails
        if ($validator->fails()) {
            #dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
            /* IF VALIDATION IS GOOD, GET USER AND SANITIZE USER-INPUT THEN SAVE TO DATABASE */
            ###----- FAMILY HISTORY TABLE -----###
        try {
            $familyHistory = new FamilyHistory();
                $familyHistory->cancer = filter_var($request->FH_cancer, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->heartDisease = filter_var($request->FH_heartDisease, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->hypertension = filter_var($request->FH_hypertension, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->thyroidDisease = filter_var($request->FH_thyroidDisease, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->tuberculosis = filter_var($request->FH_tuberculosis, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->diabetesMelittus = filter_var($request->FH_diabetesMelittus, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->mentalDisorder = filter_var($request->FH_mentalDisorder, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->asthma = filter_var($request->FH_asthma, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->convulsions = filter_var($request->FH_convulsions, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->bleedingDyscrasia = filter_var($request->FH_bleedingDyscrasia, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->eyeDisorder = filter_var($request->FH_eyeDisorder, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->skinProblems = filter_var($request->FH_skinProblems, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->kidneyProblems = filter_var($request->FH_kidneyProblems, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->gastrointestinalDisease = filter_var($request->FH_gastroDisease, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->others = filter_var($request->FH_others, FILTER_SANITIZE_NUMBER_INT);
                $familyHistory->othersDetails = $request->filled('FH_othersDetails') ? filter_var($request->input('FH_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $res = $familyHistory->save();
            if(!$res){
                return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
            }

            ###----- PERSONAL SOCIAL HISTORY TABLE -----###
            $psHistory = new PersonalSocialHistory();
                $psHistory->smoking = filter_var($request->input('PSH_smoking'), FILTER_SANITIZE_NUMBER_INT);
                $psHistory->sticksPerDay = $request->filled('PSH_smoking_amount') ? filter_var($request->input('PSH_smoking_amount'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
                $psHistory->years = $request->filled('PSH_smoking_freq') ? filter_var($request->input('PSH_smoking_freq'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
                $psHistory->drinking = filter_var($request->input('PSH_drinking'), FILTER_SANITIZE_NUMBER_INT);
                $psHistory->numberOfBeers = $request->filled('PSH_drinking_amountOfBeer') ? filter_var($request->input('PSH_drinking_amountOfBeer'), FILTER_SANITIZE_STRING) : 'N/A';
                $psHistory->beerFrequency = $request->filled('PSH_drinking_freqOfBeer') ? filter_var($request->input('PSH_drinking_freqOfBeer'), FILTER_SANITIZE_STRING) : 'N/A';
                $psHistory->numberOfShots = $request->filled('PSH_drinking_amountofShots') ? filter_var($request->input('PSH_drinking_amountofShots'), FILTER_SANITIZE_STRING) : 'N/A';
                $psHistory->shotsFrequency = $request->filled('PSH_drinking_freqOfShots') ? filter_var($request->input('PSH_drinking_freqOfShots'), FILTER_SANITIZE_STRING) : 'N/A';
            $res = $psHistory->save();
                if(!$res){
                    return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                }
        
            ###----- PAST ILLNESS TABLE -----###
            $pastIllness = new PastIllness();
                $pastIllness->primaryComplex = filter_var($request->input('pi_primaryComplex'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->chickenPox = filter_var($request->input('pi_chickenPox'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->kidneyDisease = filter_var($request->input('pi_kidneyDisease'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->typhoidFever = filter_var($request->input('pi_typhoidFever'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->earProblems = filter_var($request->input('pi_earProblems'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->heartDisease = filter_var($request->input('pi_heartDisease'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->leukemia = filter_var($request->input('pi_leukemia'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->asthma = filter_var($request->input('pi_asthma'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->diabetes = filter_var($request->input('pi_diabetes'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->eyeDisorder = filter_var($request->input('pi_eyeDisorder'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->pneumonia = filter_var($request->input('pi_pneumonia'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->dengue = filter_var($request->input('pi_dengue'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->measles = filter_var($request->input('pi_measles'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->hepatitis = filter_var($request->input('pi_hepatitis'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->rheumaticFever = filter_var($request->input('pi_rheumaticFever'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->mentalDisorder = filter_var($request->input('pi_mentalDisorder'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->skinProblems = filter_var($request->input('pi_skinProblems'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->poliomyetis = filter_var($request->input('pi_poliomyetis'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->thyroidDisorder = filter_var($request->input('pi_thyroidDisorder'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->anemia = filter_var($request->input('pi_anemia'), FILTER_SANITIZE_NUMBER_INT);
                $pastIllness->mumps = filter_var($request->input('pi_mumps'), FILTER_SANITIZE_NUMBER_INT);
            $res = $pastIllness->save();
                if(!$res){
                    return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                }
        
            ###----- PRESENT ILLNESS TABLE -----###
            $presentIllness = new PresentIllness();
                $presentIllness->chestPain = filter_var($request->input('PI_chestPain'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->insomnia = filter_var($request->input('PI_insomnia'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->jointPains = filter_var($request->input('PI_jointPains'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->dizziness = filter_var($request->input('PI_dizziness'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->headaches = filter_var($request->input('PI_headaches'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->indigestion = filter_var($request->input('PI_indigestion'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->swollenFeet = filter_var($request->input('PI_swollenFeet'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->weightLoss = filter_var($request->input('PI_weightLoss'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->nauseaOrVomiting = filter_var($request->input('PI_nauseaOrVomiting'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->soreThroat = filter_var($request->input('PI_soreThroat'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->frequentUrination = filter_var($request->input('PI_frequentUrination'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->difficultyOfBreathing = filter_var($request->input('PI_difficultyOfBreathing'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->others = filter_var($request->input('PI_others'), FILTER_SANITIZE_NUMBER_INT);
                $presentIllness->othersDetails = $request->filled('PI_othersDetails') ? filter_var($request->input('PI_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $res = $presentIllness->save();
                if(!$res){
                    return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                }

        ###----- IMMUNIZATION HISTORY TABLE -----###
            $immunizationHistory = new ImmunizationHistory;
                $immunizationHistory->BCG = filter_var($request->input('IH_bcg'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->polio = filter_var($request->input('IH_polio'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->mumps = filter_var($request->input('IH_mumps'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->typhoid = filter_var($request->input('IH_typhoid'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->hepatitisA = filter_var($request->input('IH_hepatitisA'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->chickenPox = filter_var($request->input('IH_chickenPox'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->DPT = filter_var($request->input('IH_dpt'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->measles = filter_var($request->input('IH_measles'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->germanMeasles = filter_var($request->input('IH_germanMeasles'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->hepatitisB = filter_var($request->input('IH_hepatitisB'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->others = filter_var($request->input('IH_others'), FILTER_SANITIZE_NUMBER_INT);
                $immunizationHistory->othersDetails = $request->filled('IH_othersDetails') ? filter_var($request->input('IH_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $res = $immunizationHistory->save();
                if(!$res){
                    return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                }
                
                $user = Auth::user();
        ###----- MEDICAL RECORD TABLE -----###
            $medRecord = new MedicalRecord();
                $medRecord->student_id = $user->id;
                $medRecord->campus = filter_var($request->input('campusSelect'), FILTER_SANITIZE_STRING);
                $medRecord->course = filter_var($request->input('courseSelect'), FILTER_SANITIZE_STRING);
                $medRecord->SYstart = filter_var($request->input('schoolYearStart'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->SYend = filter_var($request->input('schoolYearEnd'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->last_name = filter_var($request->input('MR_lastName'), FILTER_SANITIZE_STRING);
                $medRecord->first_name = filter_var($request->input('MR_firstName'), FILTER_SANITIZE_STRING);
                $medRecord->middle_name = filter_var($request->input('MR_middleName'), FILTER_SANITIZE_STRING);
                $medRecord->age = filter_var($request->input('MR_age'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->sex = filter_var($request->input('MR_sex'), FILTER_SANITIZE_STRING);

                $dateString = $request->input('MR_dateOfBirth');
                $date = DateTime::createFromFormat('Y F d', $dateString);
                $formattedDate = $date->format('Y-m-d');

                $medRecord->dateOfBirth = $formattedDate;
                $medRecord->civilStatus = filter_var($request->input('MR_civilStatus'), FILTER_SANITIZE_STRING);

                $medRecord->region = filter_var($request->input('MR_addressRegion'), FILTER_SANITIZE_STRING);
                $medRecord->province = filter_var($request->input('MR_addressProvince'), FILTER_SANITIZE_STRING);
                $medRecord->cityMunicipality = filter_var($request->input('MR_addressCityMunicipality'), FILTER_SANITIZE_STRING);
                $medRecord->barangaySubdVillage = filter_var($request->input('MR_addressBrgySubdVillage'), FILTER_SANITIZE_STRING);
                $medRecord->houseNumberStName = filter_var($request->input('MR_addressHouseNoStreet'), FILTER_SANITIZE_STRING);

                $medRecord->nationality = filter_var($request->input('MR_nationality'), FILTER_SANITIZE_STRING);
                $medRecord->religion = filter_var($request->input('MR_religion'), FILTER_SANITIZE_STRING);
                $medRecord->fatherName = filter_var($request->input('MR_fatherName'), FILTER_SANITIZE_STRING);
                $medRecord->fatherOccupation = filter_var($request->input('MR_fatherOccupation'), FILTER_SANITIZE_STRING);
                $medRecord->fatherOfficeAddress = filter_var($request->input('MR_fatherOffice'), FILTER_SANITIZE_STRING);
                $medRecord->motherName = filter_var($request->input('MR_motherName'), FILTER_SANITIZE_STRING);
                $medRecord->motherOccupation = filter_var($request->input('MR_motherOccupation'), FILTER_SANITIZE_STRING);
                $medRecord->motherOfficeAddress = filter_var($request->input('MR_motherOffice'), FILTER_SANITIZE_STRING);
                $medRecord->guardianName = $request->filled('MR_guardian') ? filter_var($request->input('MR_guardian'), FILTER_SANITIZE_STRING) : 'N/A';     
                $medRecord->guardianAddress = $request->filled('MR_guardianAddress') ? filter_var($request->input('MR_guardianAddress'), FILTER_SANITIZE_STRING) : 'N/A';    
                $medRecord->parentGuardianContactNumber = filter_var(ltrim($request->input('MR_parentGuardianContactNumber'), '0'), FILTER_VALIDATE_INT);
                $medRecord->studentContactNumber = filter_var(ltrim($request->input('MR_studentContactNumber'), '0'), FILTER_VALIDATE_INT);
                
                if($request->input('MR_emergencyContactPerson') == 'FATHER'){
                    $medRecord->emergencyContactName = filter_var($request->input('MR_fatherName'), FILTER_SANITIZE_STRING);
                    $medRecord->emergencyContactOccupation = filter_var($request->input('MR_fatherOccupation'), FILTER_SANITIZE_STRING);
                        $emergencyContactRelationship = 'FATHER'; 
                    $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                }
                elseif($request->input('MR_emergencyContactPerson') == 'MOTHER'){
                    $medRecord->emergencyContactName = filter_var($request->input('MR_motherName'), FILTER_SANITIZE_STRING);
                    $medRecord->emergencyContactOccupation = filter_var($request->input('MR_motherOccupation'), FILTER_SANITIZE_STRING);
                        $emergencyContactRelationship = 'MOTHER'; 
                    $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                }
                elseif($request->input('MR_emergencyContactPerson') == 'GUARDIAN'){
                    $medRecord->emergencyContactName = filter_var($request->input('MR_guardian'), FILTER_SANITIZE_STRING);
                    $medRecord->emergencyContactOccupation = filter_var($request->input('MR_guardianOccupation'), FILTER_SANITIZE_STRING);
                        $emergencyContactRelationship = 'GUARDIAN'; 
                    $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                }
                else{
                    $medRecord->emergencyContactName = filter_var($request->input('MR_emergencyContactName'), FILTER_SANITIZE_STRING);
                    $medRecord->emergencyContactOccupation = filter_var($request->input('MR_emergencyContactOccupation'), FILTER_SANITIZE_STRING);
                    $medRecord->emergencyContactRelationship = filter_var($request->input('MR_emergencyContactRelationship'), FILTER_SANITIZE_STRING);
                }
                $medRecord->emergencyContactAddress = filter_var($request->input('MR_emergencyContactAddress'), FILTER_SANITIZE_STRING);
                $medRecord->emergencyContactNumber = filter_var(ltrim($request->input('MR_emergencyContactNumber'), '0'), FILTER_VALIDATE_INT);

                $medRecord->hospitalization = filter_var($request->input('hospitalization'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->hospDetails = $request->filled('hospitalizationDetails') ? filter_var($request->input('hospitalizationDetails'), FILTER_SANITIZE_STRING) : 'N/A';   
                $medRecord->takingMedsRegularly = filter_var($request->input('regMeds'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->medsDetails = $request->filled('regMedsDetails') ? filter_var($request->input('regMedsDetails'), FILTER_SANITIZE_STRING) : 'N/A';  
                $medRecord->allergic = filter_var($request->input('allergy'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->allergyDetails = $request->filled('allergyDetails') ? filter_var($request->input('allergyDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                # SAVE THE FOREIGN KEYS
                $medRecord->familyHistoryID = $familyHistory->familyHistoryID;
                $medRecord->immunizationHistoryID = $immunizationHistory->immunizationHistoryID;
                $medRecord->pastIllnessID = $pastIllness->pastIllnessID;
                $medRecord->personalSocialHistoryID = $psHistory->personalSocialHistoryID;
                $medRecord->presentIllnessID = $presentIllness->presentIllnessID;

                # UPLOADS
                    // Get the validated, uploaded file
                    $chestXray = $request->file('MR_chestXray');
                    $cbcresults = $request->file('MR_cbcresults');
                    $hepaBscreening = $request->file('MR_hepaBscreening');
                    $bloodtype = $request->file('MR_bloodtype');
                      // Filename prefix
                    $secondID = $user->student_id_number ?: $user->applicant_id_number;
                    $uploadPrefix = $user->id.''.$secondID.''.$request->lastName;

                    $chestXrayName = $uploadPrefix.'CHESTXRAY.'.$chestXray->getClientOriginalExtension();
                    $cbcresultsName = $uploadPrefix.'CBCRESULTS.'.$cbcresults->getClientOriginalExtension();
                    $hepaBscreeningName = $uploadPrefix.'HEPATITISBSCREENING.'.$hepaBscreening->getClientOriginalExtension();
                    $bloodtypeName = $uploadPrefix.'BLOODTYPE.'.$bloodtype->getClientOriginalExtension();

                        // Store the file on the server
                    $medRecord->chestXray = $chestXray->storeAs('uploads', $chestXrayName, 'public');
                    $medRecord->CBCResults = $cbcresults->storeAs('uploads', $cbcresultsName, 'public');
                    $medRecord->hepaBscreening = $hepaBscreening->storeAs('uploads', $hepaBscreeningName, 'public');
                    $medRecord->bloodType = $bloodtype->storeAs('uploads', $bloodtypeName, 'public');
                        // Other uploads
                    if($otherUpload1 = $request->file('MR_additionalUpload1')){
                        $otherUpload1name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult1'), FILTER_SANITIZE_STRING).'.'.$otherUpload1->getClientOriginalExtension();
                        $medRecord->resultName1 = filter_var($request->input('MR_additionalResult1'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage1 = $otherUpload1->storeAs('uploads', $otherUpload1name, 'public');
                    }
                    if($otherUpload2 = $request->file('MR_additionalUpload2')){
                        $otherUpload2name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult2'), FILTER_SANITIZE_STRING).'.'.$otherUpload2->getClientOriginalExtension();
                        $medRecord->resultName2 = filter_var($request->input('MR_additionalResult2'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage2 = $otherUpload2->storeAs('uploads', $otherUpload2name, 'public');
                    }
                    if($otherUpload3 = $request->file('MR_additionalUpload3')){
                        $otherUpload3name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult3'), FILTER_SANITIZE_STRING).'.'.$otherUpload3->getClientOriginalExtension();
                        $medRecord->resultName3 = filter_var($request->input('MR_additionalResult3'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage3 = $otherUpload3->storeAs('uploads', $otherUpload3name, 'public');
                    }
                    if($otherUpload4 = $request->file('MR_additionalUpload4')){
                        $otherUpload4name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult4'), FILTER_SANITIZE_STRING).'.'.$otherUpload4->getClientOriginalExtension();
                        $medRecord->resultName4 = filter_var($request->input('MR_additionalResult4'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage4 = $otherUpload4->storeAs('uploads', $otherUpload4name, 'public');
                    }
                    if($otherUpload5 = $request->file('MR_additionalUpload5')){
                        $otherUpload5name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult5'), FILTER_SANITIZE_STRING).'.'.$otherUpload5->getClientOriginalExtension();
                        $medRecord->resultName5 = filter_var($request->input('MR_additionalResult5'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage5 = $otherUpload5->storeAs('uploads', $otherUpload5name, 'public');
                    }
                    if($otherUpload6 = $request->file('MR_additionalUpload6')){
                        $otherUpload6name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult6'), FILTER_SANITIZE_STRING).'.'.$otherUpload6->getClientOriginalExtension();
                        $medRecord->resultName6 = filter_var($request->input('MR_additionalResult6'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage6 = $otherUpload6->storeAs('uploads', $otherUpload6name, 'public');
                    }
                    if($otherUpload7 = $request->file('MR_additionalUpload7')){
                        $otherUpload7name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult7'), FILTER_SANITIZE_STRING).'.'.$otherUpload7->getClientOriginalExtension();
                        $medRecord->resultName7 = filter_var($request->input('MR_additionalResult7'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage7 = $otherUpload7->storeAs('uploads', $otherUpload7name, 'public');
                    }
                    if($otherUpload8 = $request->file('MR_additionalUpload8')){
                        $otherUpload8name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult8'), FILTER_SANITIZE_STRING).'.'.$otherUpload8->getClientOriginalExtension();
                        $medRecord->resultName8 = filter_var($request->input('MR_additionalResult8'), FILTER_SANITIZE_STRING);
                        $medRecord->resultImage8 = $otherUpload8->storeAs('uploads', $otherUpload8name, 'public');
                    }
    
                    $medRecord->signed = intval('1');
                /**
                 * SAVE EVERY INPUT WITH && SO THAT IF ONE ->save() RETURNS FALSE, $res WILL BE FALSE
                 */
            $res = $medRecord->save();

            //IF FALSE
            if(!$res){
                // Log error and display user-friendly message
                Log::error('Failed to register user.');
                return redirect()->back()->with('fail','Failed to register. Please try again later.');
            }

            $familyHistory->MR_id =  $medRecord->MR_id;
            $psHistory->MR_id =  $medRecord->MR_id;
            $pastIllness->MR_id =  $medRecord->MR_id;
            $presentIllness->MR_id =  $medRecord->MR_id;
            $immunizationHistory->MR_id =  $medRecord->MR_id;

            $familyHistory->save();
            $psHistory->save();
            $pastIllness->save();
            $presentIllness->save();
            $immunizationHistory->save();

            $user->hasMedRecord = intval('1');
            $user->MR_id =  $medRecord->MR_id;
            $user->save();

            return redirect('/')->with('MedicalRecordSuccess', 'Medical record saved successfully');
        } 
        catch (QueryException $ex) {
            // Handle the SQL error here
            return redirect()->back()->withErrors([
                "An error occurred: " . $ex->getMessage(),
                'If this error persists, please contact the admin from Bicol University Health Services.'
            ])->withInput();
            Log::error('Error from '.$user->id.': '. $ex->getMessage());
        }
        
    } // END OF medFormSubmit FUNCTION

    #--- FUNCTIONS FOR PERSONNEL MED RECORD---#
    public function personnelMedicalRecordFormReg(){
        if(Auth::guard('employee')->user()->hasMedRecord == 0){
            $user = Auth::guard('employee')->user();

            $dateString = $user->date_of_birth;
            $date = date_create($dateString);
            
            $formattedBirthDate = $date->format('Y F d');

            return view('personnel.medicalRecordFormPersonnel')
            ->with([
                'user' => $user,
                'birthDate' => $formattedBirthDate
            ]);
        }
        else{
            return redirect()->back()->with('warning', 'You have already submitted your Medical Form!');
        }
    }

    public function personnelMedFormSubmit(Request $request){

        $rules = [
            'MRP_personnelContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
            'MRP_emergencyContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
        ];
        $validator = Validator::make($request->only(['MRP_personnelContactNumber', 'MRP_emergencyContactNumber']), $rules);
            // Return error message if validation fails
        if ($validator->fails()) {
            #dd($validator);
            return back()->withErrors($validator)->withInput();
        }

        $validator = Validator::make($request->all(), [
            /* BASIC INFORMATION */
            'designation' => 'required',
            'unitDepartment' => 'required',
            'campusSelect' => 'required',
            'MRP_lastName' => 'required|string',
            'MRP_firstName' => 'required|string',
            'MRP_middleName' => 'required|string',
            'MRP_age' => 'required|integer',
            'MRP_sex' => 'required|string',
            'MRP_gender' => 'required|string',
            'MRP_pwd' => 'required|string',
            'MRP_dateOfBirth' => 'required|string',
            'MRP_civilStatus' => 'required|string',
            'MRP_nationality' => 'required|string',
            'MRP_religion' => 'required|string',
            'MRP_addressRegion' => 'required|string',
            'MRP_addressProvince' => 'required|string',
            'MRP_addressCityMunicipality' => 'required|string',
            'MRP_addressBrgySubdVillage' => 'required|string',
            'MRP_addressHouseNoStreet' => 'nullable|string',
            'MRP_emergencyContactName' => 'required|string',
            'MRP_emergencyContactOccupation' => 'required|string',
            'MRP_emergencyContactRelationship' => 'required|string',
            'MRP_emergencyContactAddress' => 'required|string',
            'certify' => 'required|in:1',

            /* FAMILY and SOCIAL HISTORY  PERSONNEL*/
            'FHP_cancer' => 'required|in:0,1', 
            'FHP_heartDisease' => 'required|in:0,1', 
            'FHP_hypertension' => 'required|in:0,1', 
            'FHP_thyroidDisease' => 'required|in:0,1', 
            'FHP_tuberculosis' => 'required|in:0,1', 
            'FHP_hivAids' => 'required|in:0,1', 
            'FHP_diabetesMelittus' => 'required|in:0,1', 
            'FHP_mentalDisorder' => 'required|in:0,1', 
            'FHP_asthma' => 'required|in:0,1', 
            'FHP_convulsions' => 'required|in:0,1', 
            'FHP_bleedingDyscrasia' => 'required|in:0,1', 
            'FHP_arthritis' => 'required|in:0,1', 
            'FHP_eyeDisorder' => 'required|in:0,1', 
            'FHP_skinProblems' => 'required|in:0,1', 
            'FHP_kidneyProblems' => 'required|in:0,1', 
            'FHP_gastroDisease' => 'required|in:0,1', 
            'FHP_hepatitis' => 'required|in:0,1', 
            'FHP_others' => 'required_if:FHP_others,1|string', 
            'FHP_othersDetails' => 'required_if:FHP_others,1|string', 

            /* PERSONAL SOCIAL HISTORY[PPSH_] */
            'PPSH_smoking' => 'required|in:0,1', 
            'PPSH_smoking_amount' => 'required_if:PPSH_smoking,1|int',
            'PPSH_smoking_freq' => 'required_if:PPSH_smoking,1|int',
            'PPSH_eCig' => 'required|in:0,1', 
            'PPSH_vape' => 'required|in:0,1', 
            'PPSH_drinking' => 'required|in:0,1',

            /* PERSONAL MEDICAL CONDITION */
            'PMC_hypertension' => 'required|in:0,1', 
            'PMC_asthma' => 'required|in:0,1', 
            'PMC_diabetes' => 'required|in:0,1', 
            'PMC_arthritis' => 'required|in:0,1', 
            'PMC_chickenPox' => 'required|in:0,1', 
            'PMC_dengue' => 'required|in:0,1', 
            'PMC_tuberculosis' => 'required|in:0,1', 
            'PMC_pneumonia' => 'required|in:0,1', 
            'PMC_covid19' => 'required|in:0,1', 
            'PMC_hivAids' => 'required|in:0,1', 

            'PMC_hepatitis' => 'required|in:0,1', 
            'PMC_hepatitisDetails' => 'required_if:PMC_hepatitis,1|string',
            'PMC_thyroidDisorder' => 'required|in:0,1', 
            'PMC_thyroidDisorderDetails' => 'required_if:PMC_thyroidDisorder,1|string', 
            'PMC_eyeDisorder' => 'required|in:0,1', 
            'PMC_eyeDisorderDetails' => 'required_if:PMC_eyeDisorder,1|string',
            'PMC_mentalDisorder' => 'required|in:0,1', 
            'PMC_mentalDisorderDetails' => 'required_if:PMC_mentalDisorder,1|string',
            'PMC_gastroDisease' => 'required|in:0,1', 
            'PMC_gastroDiseaseDetails' => 'required_if:PMC_gastroDisease,1|string',
            'PMC_kidneyDisease' => 'required|in:0,1',
            'PMC_kidneyDiseaseDetails' => 'required_if:PMC_kidneyDisease,1|string',
            'PMC_heartDisease' => 'required|in:0,1',
            'PMC_heartDiseaseDetails' => 'required_if:PMC_heartDisease,1|string',
            'PMC_skinDisease' => 'required|in:0,1',
            'PMC_skinDiseaseDetails' => 'required_if:PMC_skinDisease,1|string',
            'PMC_earDisease' => 'required|in:0,1',
            'PMC_earDiseaseDetails' => 'required_if:PMC_earDisease,1|string',
            'PMC_cancer' => 'required|in:0,1',
            'PMC_cancerDetails' => 'required_if:PMC_cancer,1|string',
            'PMC_others' => 'required|in:0,1',
            'PMC_othersDetails' => 'required_if:PMC_others,1|string',

            /* Hospitalization */
            'hospitalization' => 'required|in:0,1', 
            'hospitalizationDetails' => 'required_if:hospitalization,1|string',
            'regMeds' => 'required|in:0,1', 
            'regMedsDetails' => 'required_if:regMeds,1|string', 
            'allergy' => 'required|in:0,1', 
            'allergyDetails' => 'required_if:allergy,1|string',  
 
            /* IMMUNIZATION HISTORY[IH_] */
            'IH_bcg' => 'required|in:0,1', 
            'IH_polio' => 'required|in:0,1', 
            'IH_chickenPox' => 'required|in:0,1', 
            'IH_dpt' => 'required|in:0,1', 
            'IH_covidVacc' => 'required|in:0,1', 
            'IH_covidVaccName' => 'required_if:IH_covidVacc,1|string', 
            'IH_covidBoosterName' => 'required_if:IH_covidVacc,1|string', 
            'IH_typhoid' => 'required|in:0,1', 
            'IH_mumps' => 'required|in:0,1',
            'IH_hepatitisA' => 'required|in:0,1',
            'IH_measles' => 'required|in:0,1',
            'IH_germanMeasles' => 'required|in:0,1',
            'IH_hepatitisB' => 'required|in:0,1', 
            'IH_pneumococcal' => 'required|in:0,1',
            'IH_influenza' => 'required|in:0,1',
            'IH_hpv' => 'required|in:0,1', 
            'IH_others' => 'required|in:0,1', 
            'IH_othersDetails' => 'required_if:IH_others,1|string',  


            /* NAME OF UPLOADS */
            'MR_additionalResult1' => 'nullable|string',
            'MR_additionalResult2' => 'nullable|string',
            'MR_additionalResult3' => 'nullable|string',
            'MR_additionalResult4' => 'nullable|string',
            'MR_additionalResult5' => 'nullable|string',
            'MR_additionalResult6' => 'nullable|string',
            'MR_additionalResult7' => 'nullable|string',
            'MR_additionalResult8' => 'nullable|string',

            /* UPLOADS */
            'MR_additionalUpload1' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload2' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'MR_additionalUpload3' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload4' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'MR_additionalUpload5' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload6' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'MR_additionalUpload7' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_additionalUpload8' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',

        ],[ #--- CATCH SPECIFIC ERRORS ---#
            'required' => 'The :attribute field is required.',
            'designation.required' => 'Please select a designation.',
            'unitDepartment.required' => 'Please select a Unit Department.',
            'campusSelect.required' => 'Please select your campus.',
            'PPSH_smoking_amount.required_if' => 'Please provide the amount of cigarettes.',
            'PPSH_smoking_freq.required_if' => 'Please provide the frequency of cigarette consumption.',
            'hospitalizationDetails.required_if' => 'Please provide the details of your hospitalization for serious illness, operation, fracture or injury.',
            'regMedsDetails.required_if' => 'Please provide the name/s of your regular drug/s.',
            'allergyDetails.required_if' => 'Please specify your allergy details.',
            'FHP_othersDetails.required_if' => 'Please provide the details of your other disease/s in Family History.',
            'IH_othersDetails.required_if' => 'Please provide the details of other immunization you have taken.',
            'certify.required' => 'Please certify that the foregoing answers are true and complete, and to the best of my knowledge by checking the checkbox.'
        ]); /* END OF VALIDATION */

        if ($validator->fails()) {
            #dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        /* GET USER */
        $user = Auth::guard('employee')->user();
        //dd($user->id);
    try{
        # Family History
        $familyHistory = new MRP_FamilyHistory();
            $familyHistory->cancer = filter_var($request->FHP_cancer, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->heartDisease = filter_var($request->FHP_heartDisease, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->hypertension = filter_var($request->FHP_hypertension, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->thyroidDisease = filter_var($request->FHP_thyroidDisease, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->tuberculosis = filter_var($request->FHP_tuberculosis, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->hivAids = filter_var($request->FHP_hivAids, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->diabetesMelittus = filter_var($request->FHP_diabetesMelittus, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->mentalDisorder = filter_var($request->FHP_mentalDisorder, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->asthma = filter_var($request->FHP_asthma, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->convulsions = filter_var($request->FHP_convulsions, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->bleedingDyscrasia = filter_var($request->FHP_bleedingDyscrasia, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->arthritis = filter_var($request->FHP_arthritis, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->eyeDisorder = filter_var($request->FHP_eyeDisorder, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->skinProblems = filter_var($request->FHP_skinProblems, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->kidneyProblems = filter_var($request->FHP_kidneyProblems, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->hepatitis = filter_var($request->FHP_hepatitis, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->gastrointestinalDisease = filter_var($request->FHP_gastroDisease, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->others = filter_var($request->FHP_others, FILTER_SANITIZE_NUMBER_INT);
            $familyHistory->othersDetails = $request->filled('FHP_othersDetails') ? filter_var($request->input('FHP_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
        $res = $familyHistory->save();
        if(!$res){
            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
        }

        ###----- PERSONAL SOCIAL HISTORY TABLE -----###
        $psHistory = new MRP_PersonalSocialHistory();
            $psHistory->smoking = filter_var($request->input('PPSH_smoking'), FILTER_SANITIZE_NUMBER_INT);
            $psHistory->sticksPerDay = $request->filled('PPSH_smoking_amount') ? filter_var($request->input('PPSH_smoking_amount'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
            $psHistory->years = $request->filled('PPSH_smoking_freq') ? filter_var($request->input('PPSH_smoking_freq'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
            $psHistory->eCig = filter_var($request->input('PPSH_eCig'), FILTER_SANITIZE_NUMBER_INT);
            $psHistory->vape =filter_var($request->input('PPSH_vape'), FILTER_SANITIZE_NUMBER_INT);
            $psHistory->drinking = filter_var($request->input('PPSH_drinking'), FILTER_SANITIZE_NUMBER_INT);
            $psHistory->drinkingDetails = $request->filled('PPSH_drinkingDetails') ? filter_var($request->input('PPSH_drinkingDetails'), FILTER_SANITIZE_STRING) : 'N/A';
        $res = $psHistory->save();
        if(!$res){
            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
        }

        ###----- PERSONAL MEDICAL CONDITION HISTORY TABLE -----###
        $personalMedicalCondition = new MRP_PersonalMedicalCondition();
            $personalMedicalCondition->hypertension = filter_var($request->PMC_hypertension, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->asthma = filter_var($request->PMC_asthma, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->diabetes = filter_var($request->PMC_diabetes, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->arthritis = filter_var($request->PMC_arthritis, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->chickenPox = filter_var($request->PMC_chickenPox, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->dengue = filter_var($request->PMC_dengue, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->tuberculosis = filter_var($request->PMC_tuberculosis, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->pneumonia = filter_var($request->PMC_pneumonia, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->covid19 = filter_var($request->PMC_covid19, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->hivAids = filter_var($request->PMC_hivAids, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->hepatitis = filter_var($request->PMC_hepatitis, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->hepatitisDetails = $request->filled('PMC_hepatitisDetails') ? filter_var($request->input('PMC_hepatitisDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->thyroidDisorder = filter_var($request->PMC_thyroidDisorder, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->thyroidDisorderDetails = $request->filled('PMC_thyroidDisorderDetails') ? filter_var($request->input('PMC_thyroidDisorderDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->eyeDisorder = filter_var($request->PMC_eyeDisorder, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->eyeDisorderDetails = $request->filled('PMC_eyeDisorderDetails') ? filter_var($request->input('PMC_eyeDisorderDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->mentalDisorder = filter_var($request->PMC_mentalDisorder, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->mentalDisorderDetails = $request->filled('PMC_mentalDisorderDetails') ? filter_var($request->input('PMC_mentalDisorderDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->gastroDisease = filter_var($request->PMC_gastroDisease, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->gastroDiseaseDetails = $request->filled('PMC_gastroDiseaseDetails') ? filter_var($request->input('PMC_gastroDiseaseDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->kidneyDisease = filter_var($request->PMC_kidneyDisease, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->kidneyDiseaseDetails = $request->filled('PMC_kidneyDiseaseDetails') ? filter_var($request->input('PMC_kidneyDiseaseDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->heartDisease = filter_var($request->PMC_heartDisease, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->heartDiseaseDetails = $request->filled('PMC_heartDiseaseDetails') ? filter_var($request->input('PMC_heartDiseaseDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->skinDisease = filter_var($request->PMC_skinDisease, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->skinDiseaseDetails = $request->filled('PMC_skinDiseaseDetails') ? filter_var($request->input('PMC_skinDiseaseDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->earDisease = filter_var($request->PMC_earDisease, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->earDiseaseDetails = $request->filled('PMC_earDiseaseDetails') ? filter_var($request->input('PMC_earDiseaseDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->cancer = filter_var($request->PMC_cancer, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->cancerDetails = $request->filled('PMC_cancerDetails') ? filter_var($request->input('PMC_cancerDetails'), FILTER_SANITIZE_STRING) : 'N/A';
            $personalMedicalCondition->others = filter_var($request->PMC_others, FILTER_SANITIZE_NUMBER_INT);
            $personalMedicalCondition->othersDetails = $request->filled('PMC_othersDetails') ? filter_var($request->input('PMC_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
        $res = $personalMedicalCondition->save();
        if(!$res){
            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
        }

        ###----- IMMUNIZATION HISTORY TABLE -----###
        $immunizationHistory = new MRP_ImmunizationHistory();
            $immunizationHistory->bcg = filter_var($request->IH_bcg, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->polio = filter_var($request->IH_polio, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->chickenPox = filter_var($request->IH_chickenPox, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->dpt = filter_var($request->IH_dpt, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->covidVacc = filter_var($request->IH_covidVacc, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->covidVaccName = $request->filled('IH_covidVaccName') ? filter_var($request->input('IH_covidVaccName'), FILTER_SANITIZE_STRING) : 'N/A';
            $immunizationHistory->covidBoosterName = $request->filled('IH_covidBoosterName') ? filter_var($request->input('IH_covidBoosterName'), FILTER_SANITIZE_STRING) : 'N/A';
            $immunizationHistory->typhoid = filter_var($request->IH_typhoid, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->mumps = filter_var($request->IH_mumps, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->hepatitisA = filter_var($request->IH_hepatitisA, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->measles = filter_var($request->IH_measles, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->germanMeasles = filter_var($request->IH_germanMeasles, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->hepatitisB = filter_var($request->IH_hepatitisB, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->pneumococcal = filter_var($request->IH_pneumococcal, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->influenza = filter_var($request->IH_influenza, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->hpv = filter_var($request->IH_hpv, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->others = filter_var($request->IH_others, FILTER_SANITIZE_NUMBER_INT);
            $immunizationHistory->othersDetails = $request->filled('IH_othersDetails') ? filter_var($request->input('othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
        $res = $immunizationHistory->save();
        if(!$res){
            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
        }

        /* SAVE INPUT TO MEDICAL RECORDS PERSONNEL TABLE */
        $medRecordPersonnel = new MedicalRecordPersonnel();
            $medRecordPersonnel->personnel_id = $user->id;
            $medRecordPersonnel->designation = filter_var($request->input('designation'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->unitDepartment = filter_var($request->input('unitDepartment'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->campus = filter_var($request->input('campusSelect'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->last_name = filter_var($request->input('MRP_lastName'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->first_name = filter_var($request->input('MRP_firstName'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->middle_name = filter_var($request->input('MRP_middleName'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->age = filter_var($request->input('MRP_age'), FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnel->sex = filter_var($request->input('MRP_sex'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->gender = filter_var($request->input('MRP_gender'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->pwd = filter_var($request->input('MRP_pwd'), FILTER_SANITIZE_NUMBER_INT);

                $dateString = $request->input('MRP_dateOfBirth');
                $date = DateTime::createFromFormat('Y F d', $dateString);
                $formattedDate = $date->format('Y-m-d');
            $medRecordPersonnel->dateOfBirth = $formattedDate;

            $medRecordPersonnel->civilStatus = filter_var($request->input('MRP_civilStatus'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->nationality = filter_var($request->input('MRP_nationality'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->religion = filter_var($request->input('MRP_religion'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->region = filter_var($request->input('MRP_addressRegion'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->province = filter_var($request->input('MRP_addressProvince'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->cityMunicipality = filter_var($request->input('MRP_addressCityMunicipality'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->barangaySubdVillage = filter_var($request->input('MRP_addressBrgySubdVillage'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->houseNumberStName = filter_var($request->input('MRP_addressHouseNoStreet'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->contactNumber = filter_var(ltrim($request->input('MRP_personnelContactNumber'), '0'), FILTER_VALIDATE_INT);
            $medRecordPersonnel->emergencyContactName = filter_var($request->input('MRP_emergencyContactName'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->emergencyContactNumber = filter_var(ltrim($request->input('MRP_emergencyContactNumber'), '0'), FILTER_VALIDATE_INT);
            $medRecordPersonnel->emergencyContactOccupation = filter_var($request->input('MRP_emergencyContactOccupation'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->emergencyContactRelationship = filter_var($request->input('MRP_emergencyContactRelationship'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->emergencyContactAddress = filter_var($request->input('MRP_emergencyContactAddress'), FILTER_SANITIZE_STRING);
            $medRecordPersonnel->hospitalization = filter_var($request->input('hospitalization'), FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnel->hospDetails = $request->filled('hospitalizationDetails') ? filter_var($request->input('hospitalizationDetails'), FILTER_SANITIZE_STRING) : 'N/A';  
            $medRecordPersonnel->takingMedsRegularly = filter_var($request->input('regMeds'), FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnel->medsDetails = $request->filled('regMedsDetails') ? filter_var($request->input('regMedsDetails'), FILTER_SANITIZE_STRING) : 'N/A';  
            $medRecordPersonnel->allergic =  filter_var($request->input('allergy'), FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnel->allergyDetails = $request->filled('allergyDetails') ? filter_var($request->input('allergyDetails'), FILTER_SANITIZE_STRING) : 'N/A';  

            # UPLOADS
                    // Get the validated, uploaded file
                    $chestXray = $request->file('MRP_chestXray');
                    $chestXrayExtension = $chestXray->getClientOriginalExtension();
                    $cbcresults = $request->file('MRP_cbcresults');
                    $cbcresultsExtension = $cbcresults->getClientOriginalExtension();
                    $hepaBscreening = $request->file('MRP_hepaBscreening');
                    $hepaBscreeningExtension = $hepaBscreening->getClientOriginalExtension();
                    $bloodtype = $request->file('MRP_bloodtype');
                    $bloodtypeExtension = $bloodtype->getClientOriginalExtension();

                    $fileNamePreFix = $user->id.''.$user->personnel_id_number.''.$request->lastName;
                    
                    // RENAME
                    $chestXrayName = $fileNamePreFix.'-CHESTXRAY.'.$chestXrayExtension;
                    $cbcresultsName = $fileNamePreFix.'-CBC RESULTS.'.$cbcresultsExtension;
                    $hepaBscreeningName = $fileNamePreFix.'-HEPATITIS B SCREENING.'.$hepaBscreeningExtension;
                    $bloodtypeName = $fileNamePreFix.'-BLOODTYPE.'.$bloodtypeExtension;
                    // Store the file on the server
                    $medRecordPersonnel->chestXray = $chestXray->storeAs('uploads', $chestXrayName, 'public');
                    $medRecordPersonnel->CBCResults = $cbcresults->storeAs('uploads', $cbcresultsName, 'public');
                    $medRecordPersonnel->hepaBscreening = $hepaBscreening->storeAs('uploads', $hepaBscreeningName, 'public');
                    $medRecordPersonnel->bloodType = $bloodtype->storeAs('uploads', $bloodtypeName, 'public');

                        // Other uploads
                    if($otherUpload1 = $request->file('MRP_additionalUpload1')){
                        $extension1 = $otherUpload1->getClientOriginalExtension();
                        $otherUpload1name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult1'), FILTER_SANITIZE_STRING).'.'.$extension1;
                        $medRecordPersonnel->resultName1 = filter_var($request->input('MRP_additionalResult1'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage1 = $otherUpload1->storeAs('uploads', $otherUpload1name, 'public');
                    }
                    if($otherUpload2 = $request->file('MRP_additionalUpload2')){
                        $extension2 = $otherUpload2->getClientOriginalExtension();
                        $otherUpload2name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult2'), FILTER_SANITIZE_STRING).'.'.$extension2;
                        $medRecordPersonnel->resultName2 = filter_var($request->input('MRP_additionalResult2'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage2 = $otherUpload2->storeAs('uploads', $otherUpload2name, 'public');
                    }
                    if($otherUpload3 = $request->file('MRP_additionalUpload3')){
                        $extension3 = $otherUpload3->getClientOriginalExtension();
                        $otherUpload3name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult3'), FILTER_SANITIZE_STRING).'.'.$extension3;
                        $medRecordPersonnel->resultName3 = filter_var($request->input('MRP_additionalResult3'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage3 = $otherUpload3->storeAs('uploads', $otherUpload3name, 'public');
                    }
                    if($otherUpload4 = $request->file('MRP_additionalUpload4')){
                        $extension4 = $otherUpload4->getClientOriginalExtension();
                        $otherUpload4name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult4'), FILTER_SANITIZE_STRING).'.'.$extension4;
                        $medRecordPersonnel->resultName4 = filter_var($request->input('MRP_additionalResult4'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage4 = $otherUpload4->storeAs('uploads', $otherUpload4name, 'public');
                    }
                    if($otherUpload5 = $request->file('MRP_additionalUpload5')){
                        $extension5 = $otherUpload5->getClientOriginalExtension();
                        $otherUpload5name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult5'), FILTER_SANITIZE_STRING).'.'.$extension5;
                        $medRecordPersonnel->resultName5 = filter_var($request->input('MRP_additionalResult5'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage5 = $otherUpload5->storeAs('uploads', $otherUpload5name, 'public');
                    }
                    if($otherUpload6 = $request->file('MRP_additionalUpload6')){
                        $extension6 = $otherUpload6->getClientOriginalExtension();
                        $otherUpload6name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult6'), FILTER_SANITIZE_STRING).'.'.$extension6;
                        $medRecordPersonnel->resultName6 = filter_var($request->input('MRP_additionalResult6'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage6 = $otherUpload6->storeAs('uploads', $otherUpload6name, 'public');
                    }
                    if($otherUpload7 = $request->file('MRP_additionalUpload7')){
                        $extension7 = $otherUpload7->getClientOriginalExtension();
                        $otherUpload7name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult7'), FILTER_SANITIZE_STRING).'.'.$extension7;
                        $medRecordPersonnel->resultName7 = filter_var($request->input('MRP_additionalResult7'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage7 = $otherUpload7->storeAs('uploads', $otherUpload7name, 'public');
                    }
                    if($otherUpload8 = $request->file('MRP_additionalUpload8')){
                        $extension8 = $otherUpload8->getClientOriginalExtension();
                        $otherUpload8name = $fileNamePreFix.''.filter_var($request->input('MRP_additionalResult8'), FILTER_SANITIZE_STRING).'.'.$extension8;
                        $medRecordPersonnel->resultName8 = filter_var($request->input('MRP_additionalResult8'), FILTER_SANITIZE_STRING);
                        $medRecordPersonnel->resultImage8 = $otherUpload8->storeAs('uploads', $otherUpload8name, 'public');
                    }

                    $medRecordPersonnel->signed = intval('1');

            # Foreign Keys
            $medRecordPersonnel->MRP_familyHistoryID = $familyHistory->MRP_familyHistoryID;
            $medRecordPersonnel->MRP_personalSocialHistoryID = $psHistory->MRP_personalSocialHistoryID;
            $medRecordPersonnel->MRP_PMC_ID = $personalMedicalCondition->MRP_PMC_ID;
            $medRecordPersonnel->MRP_immunizationHistoryID = $immunizationHistory->MRP_immunizationHistoryID;

            /**
            * SAVE EVERY INPUT WITH && SO THAT IF ONE ->save() RETURNS FALSE, $res WILL BE FALSE
            */
            $res = $medRecordPersonnel->save();
            // IF FALSE
            if(!$res){
                // Log error and display message
                Log::error('Failed to register user.');
                return redirect()->back()->with('fail','Failed to register. Please try again later.');
            }

            $familyHistory->MRP_id =  $medRecordPersonnel->MRP_id;
                $familyHistory->save();
            $psHistory->MRP_id =  $medRecordPersonnel->MRP_id;
                $psHistory->save();
            $personalMedicalCondition->MRP_id =  $medRecordPersonnel->MRP_id;
                $personalMedicalCondition->save();
            $immunizationHistory->MRP_id =  $medRecordPersonnel->MRP_id;
                $immunizationHistory->save();
            
            $user->hasMedRecord = intval('1');
            $user->MRP_id =  $medRecordPersonnel->MRP_id;
            $user->save();

            return redirect('/')->with('MedicalRecordSuccess', 'Medical record saved successfully');
        } 
        catch (QueryException $ex) {
            // Handle the SQL error here
            return redirect()->back()->withErrors([
                "An error occurred: " . $ex->getMessage(),
                'If this error persists, please contact the admin from Bicol University Health Services.'
            ])->withInput();
            Log::error('Error from '.$user->id.': '. $ex->getMessage());
        }
    }

    public function showPersonnelForm($patientID){
        try {
            // Try to find a patient with the specified personnel ID
            $patient = UserPersonnel::with('medicalRecordPersonnel')
                                    ->where('personnel_id_number', $patientID)
                                    ->where('hasMedRecord', 1)
                                    ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $message = 'Patient '.$patientID.' not found.';
            return redirect()->route('admin.patientMedFormList.show')->with('fail', $message);
        }
    
        // Display the patient form with the found user data
        return view('admin.ClinicSideMedicalRecordFormPersonnel')->with('patient', $patient);
    }
    
    public function showWalkInHealthRecord(){
        return view('admin.walkInMedicalRecordForm');
    }

    public function showWalkInHealthRecordPersonnel(){
        return view('admin.walkInMedicalRecordFormPersonnel');
    }

    public function WalkInHealthRecordSubmit(Request $request) {
              /* PHONE NUMBER */
              $rules = [
                'MR_parentGuardianContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
                'MR_studentContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
                'MR_emergencyContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
            ];
            $validator = Validator::make($request->only(['MR_parentGuardianContactNumber', 'MR_studentContactNumber', 'MR_emergencyContactNumber']), $rules);
                // Return error message if validation fails
            if ($validator->fails()) {
                #dd($validator);
                return back()->withErrors($validator)->withInput();
            }
                    /* VALIDATE USER INPUT */
            $validator = Validator::make($request->all(), [
                /* BASIC INFORMATION */
                'applicant_id' => 'required',
                'student_id' => 'required',
                'campusSelect' => 'required',
                'courseSelect' => 'required',
                'schoolYearStart' => 'required_with:schoolYearEnd|integer|min:2015',
                'schoolYearEnd' => [
                    'required_with:schoolYearStart',
                    'integer',
                    'gt:schoolYearStart',
                    function ($attribute, $value, $fail) use ($request) {
                        $start = $request->input('schoolYearStart');
                        if ($value != $start + 1) {
                            $fail('The end school year must be exactly one greater than school year start.');
                        }
                    },
                ],
                'MR_lastName' => 'required|string',
                'MR_firstName' => 'required|string',
                'MR_middleName' => 'nullable',
                'MR_age' => 'required|integer',
                'MR_sex' => 'required|string',
                'MR_dateOfBirth' => 'required',
                'MR_civilStatus' => 'required|string',
                'MR_nationality' => 'required|string',
                'MR_religion' => 'required|string',
                'MR_addressRegion' => 'required|string',
                'MR_addressProvince' => 'required|string',
                'MR_addressCityMunicipality' => 'required|string',
                'MR_addressBrgySubdVillage' => 'required|string',
                'MR_addressHouseNoStreet' => 'required|string',
                'MR_fatherName' => 'required|string',
                'MR_fatherOccupation' => 'nullable',
                'MR_fatherOffice' => 'nullable',
                'MR_motherName' => 'required|string',
                'MR_motherOccupation' => 'nullable',
                'MR_motherOffice' => 'nullable',
                'MR_guardian' => 'nullable|string',
                'MR_guardianAddress' => 'nullable|required_with:MR_guardian|string',
                'MR_emergencyContactName' => 'required|string',
                'MR_emergencyContactOccupation' => 'required|string',
                'MR_emergencyContactRelationship' => 'required|string',
                'MR_emergencyContactAddress' => 'required|string',
    
                /* FAMILY HISTORY[FH_] */
                'FH_cancer' => 'required|in:0,1', 
                'FH_heartDisease' => 'required|in:0,1', 
                'FH_hypertension' => 'required|in:0,1', 
                'FH_thyroidDisease' => 'required|in:0,1', 
                'FH_tuberculosis' => 'required|in:0,1', 
                'FH_diabetesMelittus' => 'required|in:0,1', 
                'FH_mentalDisorder' => 'required|in:0,1', 
                'FH_asthma' => 'required|in:0,1', 
                'FH_convulsions' => 'required|in:0,1', 
                'FH_bleedingDyscrasia' => 'required|in:0,1', 
                'FH_eyeDisorder' => 'required|in:0,1', 
                'FH_skinProblems' => 'required|in:0,1', 
                'FH_kidneyProblems' => 'required|in:0,1', 
                'FH_gastroDisease' => 'required|in:0,1', 
                'FH_others' => 'required|in:0,1', 
                'FH_othersDetails' => 'required_if:FH_others,1|string', 
    
                /* PERSONAL SOCIAL HISTORY[PSH_] */
                'PSH_smoking' => 'required|in:0,1', 
                'PSH_smoking_amount' => 'required_if:PSH_smoking,1|int', 
                'PSH_smoking_freq' => 'required_if:PSH_smoking,1|int', 
                'PSH_drinking' => 'required|in:0,1',
                'PSH_drinking_amountOfBeer' => 'nullable|string',
                'PSH_drinking_freqOfBeer' => 'nullable|required_with:PSH_drinking_amountOfBeer|string',
                'PSH_drinking_amountofShots' => 'nullable|string',
                'PSH_drinking_freqOfShots' => 'nullable|required_with:PSH_drinking_amountofShots|string',
    
                /* PAST ILLNESS[pi_] */
                'pi_primaryComplex' => 'required|in:0,1', 
                'pi_chickenPox' => 'required|in:0,1', 
                'pi_kidneyDisease' => 'required|in:0,1', 
                'pi_typhoidFever' => 'required|in:0,1', 
                'pi_earProblems' => 'required|in:0,1', 
                'pi_heartDisease' => 'required|in:0,1', 
                'pi_leukemia' => 'required|in:0,1', 
                'pi_asthma' => 'required|in:0,1', 
                'pi_diabetes' => 'required|in:0,1', 
                'pi_eyeDisorder' => 'required|in:0,1', 
                'pi_pneumonia' => 'required|in:0,1', 
                'pi_dengue' => 'required|in:0,1', 
                'pi_measles' => 'required|in:0,1', 
                'pi_hepatitis' => 'required|in:0,1', 
                'pi_rheumaticFever' => 'required|in:0,1', 
                'pi_mentalDisorder' => 'required|in:0,1', 
                'pi_skinProblems' => 'required|in:0,1', 
                'pi_poliomyetis' => 'required|in:0,1', 
                'pi_thyroidDisorder' => 'required|in:0,1', 
                'pi_anemia' => 'required|in:0,1', 
                'pi_mumps' => 'required|in:0,1', 
    
                /* PRESENT ILLNESS[PI_] */
                'PI_chestPain' => 'required|in:0,1', 
                'PI_insomnia' => 'required|in:0,1', 
                'PI_jointPains' => 'required|in:0,1', 
                'PI_dizziness' => 'required|in:0,1', 
                'PI_headaches' => 'required|in:0,1', 
                'PI_indigestion' => 'required|in:0,1', 
                'PI_swollenFeet' => 'required|in:0,1', 
                'PI_weightLoss' => 'required|in:0,1', 
                'PI_nauseaOrVomiting' => 'required|in:0,1', 
                'PI_soreThroat' => 'required|in:0,1', 
                'PI_frequentUrination' => 'required|in:0,1', 
                'PI_difficultyOfBreathing' => 'required|in:0,1', 
                'PI_others' => 'required|in:0,1', 
                'PI_othersDetails' => 'required_if:PI_others,1|string', 
    
                /* HOSPITALIZATION, REGULAR MEDS, AND ALLREGIES */
                'hospitalization' => 'required|in:0,1', 
                'hospitalizationDetails' => 'required_if:hospitalization,1|string', 
                'regMeds' => 'required|in:0,1', 
                'regMedsDetails' => 'required_if:regMeds,1|string', 
                'allergy' => 'required|in:0,1', 
                'allergyDetails' => 'required_if:allergy,1|string', 
    
                /* IMMUNIZATION HISTORY[IH_] */
                'IH_bcg' => 'required|in:0,1', 
                'IH_polio' => 'required|in:0,1', 
                'IH_mumps' => 'required|in:0,1', 
                'IH_typhoid' => 'required|in:0,1', 
                'IH_hepatitisA' => 'required|in:0,1', 
                'IH_chickenPox' => 'required|in:0,1', 
                'IH_dpt' => 'required|in:0,1', 
                'IH_measles' => 'required|in:0,1', 
                'IH_germanMeasles' => 'required|in:0,1', 
                'IH_hepatitisB' => 'required|in:0,1', 
                'IH_others' => 'required|in:0,1', 
                'IH_othersDetails' => 'required_if:FH_others,1|string',
                
                'MR_chestXray' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                'MR_cbcresults' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                'MR_hepaBscreening' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                'MR_bloodtype' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                'certify' => 'required|in:1',
    
                /* NAME OF UPLOADS */
                'MR_additionalResult1' => 'nullable|string',
                'MR_additionalResult2' => 'nullable|string',
                'MR_additionalResult3' => 'nullable|string',
                'MR_additionalResult4' => 'nullable|string',
                'MR_additionalResult5' => 'nullable|string',
                'MR_additionalResult6' => 'nullable|string',
                'MR_additionalResult7' => 'nullable|string',
                'MR_additionalResult8' => 'nullable|string',
    
                /* UPLOADS */
                'MR_additionalUpload1' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                'MR_additionalUpload2' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                'MR_additionalUpload3' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                'MR_additionalUpload4' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                'MR_additionalUpload5' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                'MR_additionalUpload6' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                'MR_additionalUpload7' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                'MR_additionalUpload8' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
    
            ],[ #--- CATCH SPECIFIC ERRORS ---#
                'campusSelect.required' => 'Please select a campus.',
                'courseSelect.required' => 'Please select a course.',
                'schoolYearStart.required_with' => 'Please provide a start year.',
                'schoolYearStart.integer' => 'The start year must be a number.',
                'schoolYearStart.min' => 'The start year must be at least 2015.',
                'schoolYearEnd.required_with' => 'Please provide an end year.',
                'schoolYearEnd.integer' => 'The end year must be a number.',
                'schoolYearEnd.gt' => 'The end year must be greater than the start year.',
                'PSH_smoking_amount.required_if' => 'Please provide the amount of cigarettes.',
                'PSH_smoking_freq.required_if' => 'Please provide the frequency of cigarette consumption.',
                'PSH_drinking_amountOfBeer.required_without_all' => 'Please indicate the amount of beer you drink.',
                'PSH_drinking_freqOfBeer.required_without_all' => 'Please indicate the frequency of beer you drink.',
                'PSH_drinking_amountofShots.required_without_all' => 'Please indicate the amount of shots you drink.',
                'PSH_drinking_freqOfShots.required_without_all' => 'Please indicate the frequency of shots you drink.',
                'PI_othersDetails.required_if' => 'Please provide the details of your other Present Illness/es',
                'hospitalizationDetails.required_if' => 'Please provide the details of your hospitalization for serious illness, operation, fracture or injury.',
                'regMedsDetails.required_if' => 'Please provide the name/s of your regular drug/s.',
                'allergyDetails.required_if' => 'Please specify your allergy details.',
                'FH_othersDetails.required_if' => 'Please provide the details of your other disease/s in Family History.',
                'IH_othersDetails.required_if' => 'Please provide the details of other immunization you have taken.',
                'certify.required' => 'Please certify that the foregoing answers are true and complete, and to the best of my knowledge by checking the checkbox.'
            ]); /* END OF VALIDATION */
    
            // Return error message if validation fails
            if ($validator->fails()) {
                #dd($validator);
                return redirect()->back()->withErrors($validator)->withInput();
            }
                /* IF VALIDATION IS GOOD, GET USER AND SANITIZE USER-INPUT THEN SAVE TO DATABASE */
                ###----- FAMILY HISTORY TABLE -----###
            try {
                $familyHistory = new FamilyHistory();
                    $familyHistory->cancer = filter_var($request->FH_cancer, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->heartDisease = filter_var($request->FH_heartDisease, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->hypertension = filter_var($request->FH_hypertension, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->thyroidDisease = filter_var($request->FH_thyroidDisease, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->tuberculosis = filter_var($request->FH_tuberculosis, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->diabetesMelittus = filter_var($request->FH_diabetesMelittus, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->mentalDisorder = filter_var($request->FH_mentalDisorder, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->asthma = filter_var($request->FH_asthma, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->convulsions = filter_var($request->FH_convulsions, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->bleedingDyscrasia = filter_var($request->FH_bleedingDyscrasia, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->eyeDisorder = filter_var($request->FH_eyeDisorder, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->skinProblems = filter_var($request->FH_skinProblems, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->kidneyProblems = filter_var($request->FH_kidneyProblems, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->gastrointestinalDisease = filter_var($request->FH_gastroDisease, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->others = filter_var($request->FH_others, FILTER_SANITIZE_NUMBER_INT);
                    $familyHistory->othersDetails = $request->filled('FH_othersDetails') ? filter_var($request->input('FH_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                $res = $familyHistory->save();
                if(!$res){
                    return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                }
    
                ###----- PERSONAL SOCIAL HISTORY TABLE -----###
                $psHistory = new PersonalSocialHistory();
                    $psHistory->smoking = filter_var($request->input('PSH_smoking'), FILTER_SANITIZE_NUMBER_INT);
                    $psHistory->sticksPerDay = $request->filled('PSH_smoking_amount') ? filter_var($request->input('PSH_smoking_amount'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
                    $psHistory->years = $request->filled('PSH_smoking_freq') ? filter_var($request->input('PSH_smoking_freq'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
                    $psHistory->drinking = filter_var($request->input('PSH_drinking'), FILTER_SANITIZE_NUMBER_INT);
                    $psHistory->numberOfBeers = $request->filled('PSH_drinking_amountOfBeer') ? filter_var($request->input('PSH_drinking_amountOfBeer'), FILTER_SANITIZE_STRING) : 'N/A';
                    $psHistory->beerFrequency = $request->filled('PSH_drinking_freqOfBeer') ? filter_var($request->input('PSH_drinking_freqOfBeer'), FILTER_SANITIZE_STRING) : 'N/A';
                    $psHistory->numberOfShots = $request->filled('PSH_drinking_amountofShots') ? filter_var($request->input('PSH_drinking_amountofShots'), FILTER_SANITIZE_STRING) : 'N/A';
                    $psHistory->shotsFrequency = $request->filled('PSH_drinking_freqOfShots') ? filter_var($request->input('PSH_drinking_freqOfShots'), FILTER_SANITIZE_STRING) : 'N/A';
                $res = $psHistory->save();
                    if(!$res){
                        return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                    }
            
                ###----- PAST ILLNESS TABLE -----###
                $pastIllness = new PastIllness();
                    $pastIllness->primaryComplex = filter_var($request->input('pi_primaryComplex'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->chickenPox = filter_var($request->input('pi_chickenPox'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->kidneyDisease = filter_var($request->input('pi_kidneyDisease'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->typhoidFever = filter_var($request->input('pi_typhoidFever'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->earProblems = filter_var($request->input('pi_earProblems'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->heartDisease = filter_var($request->input('pi_heartDisease'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->leukemia = filter_var($request->input('pi_leukemia'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->asthma = filter_var($request->input('pi_asthma'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->diabetes = filter_var($request->input('pi_diabetes'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->eyeDisorder = filter_var($request->input('pi_eyeDisorder'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->pneumonia = filter_var($request->input('pi_pneumonia'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->dengue = filter_var($request->input('pi_dengue'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->measles = filter_var($request->input('pi_measles'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->hepatitis = filter_var($request->input('pi_hepatitis'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->rheumaticFever = filter_var($request->input('pi_rheumaticFever'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->mentalDisorder = filter_var($request->input('pi_mentalDisorder'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->skinProblems = filter_var($request->input('pi_skinProblems'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->poliomyetis = filter_var($request->input('pi_poliomyetis'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->thyroidDisorder = filter_var($request->input('pi_thyroidDisorder'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->anemia = filter_var($request->input('pi_anemia'), FILTER_SANITIZE_NUMBER_INT);
                    $pastIllness->mumps = filter_var($request->input('pi_mumps'), FILTER_SANITIZE_NUMBER_INT);
                $res = $pastIllness->save();
                    if(!$res){
                        return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                    }
            
                ###----- PRESENT ILLNESS TABLE -----###
                $presentIllness = new PresentIllness();
                    $presentIllness->chestPain = filter_var($request->input('PI_chestPain'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->insomnia = filter_var($request->input('PI_insomnia'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->jointPains = filter_var($request->input('PI_jointPains'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->dizziness = filter_var($request->input('PI_dizziness'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->headaches = filter_var($request->input('PI_headaches'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->indigestion = filter_var($request->input('PI_indigestion'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->swollenFeet = filter_var($request->input('PI_swollenFeet'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->weightLoss = filter_var($request->input('PI_weightLoss'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->nauseaOrVomiting = filter_var($request->input('PI_nauseaOrVomiting'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->soreThroat = filter_var($request->input('PI_soreThroat'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->frequentUrination = filter_var($request->input('PI_frequentUrination'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->difficultyOfBreathing = filter_var($request->input('PI_difficultyOfBreathing'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->others = filter_var($request->input('PI_others'), FILTER_SANITIZE_NUMBER_INT);
                    $presentIllness->othersDetails = $request->filled('PI_othersDetails') ? filter_var($request->input('PI_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                $res = $presentIllness->save();
                    if(!$res){
                        return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                    }
    
            ###----- IMMUNIZATION HISTORY TABLE -----###
                $immunizationHistory = new ImmunizationHistory;
                    $immunizationHistory->BCG = filter_var($request->input('IH_bcg'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->polio = filter_var($request->input('IH_polio'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->mumps = filter_var($request->input('IH_mumps'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->typhoid = filter_var($request->input('IH_typhoid'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->hepatitisA = filter_var($request->input('IH_hepatitisA'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->chickenPox = filter_var($request->input('IH_chickenPox'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->DPT = filter_var($request->input('IH_dpt'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->measles = filter_var($request->input('IH_measles'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->germanMeasles = filter_var($request->input('IH_germanMeasles'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->hepatitisB = filter_var($request->input('IH_hepatitisB'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->others = filter_var($request->input('IH_others'), FILTER_SANITIZE_NUMBER_INT);
                    $immunizationHistory->othersDetails = $request->filled('IH_othersDetails') ? filter_var($request->input('IH_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                $res = $immunizationHistory->save();
                    if(!$res){
                        return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                    }
                    
                    $user = Auth::user();
            ###----- MEDICAL RECORD TABLE -----###
                $medRecord = new MedicalRecord();
                    $medRecord->student_id = $user->id;
                    $medRecord->campus = filter_var($request->input('campusSelect'), FILTER_SANITIZE_STRING);
                    $medRecord->course = filter_var($request->input('courseSelect'), FILTER_SANITIZE_STRING);
                    $medRecord->SYstart = filter_var($request->input('schoolYearStart'), FILTER_SANITIZE_NUMBER_INT);
                    $medRecord->SYend = filter_var($request->input('schoolYearEnd'), FILTER_SANITIZE_NUMBER_INT);
                    $medRecord->last_name = filter_var($request->input('MR_lastName'), FILTER_SANITIZE_STRING);
                    $medRecord->first_name = filter_var($request->input('MR_firstName'), FILTER_SANITIZE_STRING);
                    $medRecord->middle_name = filter_var($request->input('MR_middleName'), FILTER_SANITIZE_STRING);
                    $medRecord->age = filter_var($request->input('MR_age'), FILTER_SANITIZE_NUMBER_INT);
                    $medRecord->sex = filter_var($request->input('MR_sex'), FILTER_SANITIZE_STRING);
    
                    $dateString = $request->input('MR_dateOfBirth');
                    $date = DateTime::createFromFormat('Y F d', $dateString);
                    $formattedDate = $date->format('Y-m-d');
    
                    $medRecord->dateOfBirth = $formattedDate;
                    $medRecord->civilStatus = filter_var($request->input('MR_civilStatus'), FILTER_SANITIZE_STRING);
                    $medRecord->region = filter_var($request->input('MR_addressRegion'), FILTER_SANITIZE_STRING);
                    $medRecord->province = filter_var($request->input('MR_addressProvince'), FILTER_SANITIZE_STRING);
                    $medRecord->cityMunicipality = filter_var($request->input('MR_addressCityMunicipality'), FILTER_SANITIZE_STRING);
                    $medRecord->barangaySubdVillage = filter_var($request->input('MR_addressBrgySubdVillage'), FILTER_SANITIZE_STRING);
                    $medRecord->houseNumberStName = filter_var($request->input('MR_address'), FILTER_SANITIZE_STRING);
                    $medRecord->nationality = filter_var($request->input('MR_addressHouseNoStreet'), FILTER_SANITIZE_STRING);
                    $medRecord->religion = filter_var($request->input('MR_religion'), FILTER_SANITIZE_STRING);
                    $medRecord->fatherName = filter_var($request->input('MR_fatherName'), FILTER_SANITIZE_STRING);
                    $medRecord->fatherOccupation = filter_var($request->input('MR_fatherOccupation'), FILTER_SANITIZE_STRING);
                    $medRecord->fatherOfficeAddress = filter_var($request->input('MR_fatherOffice'), FILTER_SANITIZE_STRING);
                    $medRecord->motherName = filter_var($request->input('MR_motherName'), FILTER_SANITIZE_STRING);
                    $medRecord->motherOccupation = filter_var($request->input('MR_motherOccupation'), FILTER_SANITIZE_STRING);
                    $medRecord->motherOfficeAddress = filter_var($request->input('MR_motherOffice'), FILTER_SANITIZE_STRING);
                    $medRecord->guardianName = $request->filled('MR_guardian') ? filter_var($request->input('MR_guardian'), FILTER_SANITIZE_STRING) : 'N/A';     
                    $medRecord->guardianAddress = $request->filled('MR_guardianAddress') ? filter_var($request->input('MR_guardianAddress'), FILTER_SANITIZE_STRING) : 'N/A';    
                    $medRecord->parentGuardianContactNumber = filter_var(ltrim($request->input('MR_parentGuardianContactNumber'), '0'), FILTER_VALIDATE_INT);
                    $medRecord->studentContactNumber = filter_var(ltrim($request->input('MR_studentContactNumber'), '0'), FILTER_VALIDATE_INT);
                    
                    if($request->input('MR_emergencyContactPerson') == 'FATHER'){
                        $medRecord->emergencyContactName = filter_var($request->input('MR_fatherName'), FILTER_SANITIZE_STRING);
                        $medRecord->emergencyContactOccupation = filter_var($request->input('MR_fatherOccupation'), FILTER_SANITIZE_STRING);
                            $emergencyContactRelationship = 'FATHER'; 
                        $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                    }
                    elseif($request->input('MR_emergencyContactPerson') == 'MOTHER'){
                        $medRecord->emergencyContactName = filter_var($request->input('MR_motherName'), FILTER_SANITIZE_STRING);
                        $medRecord->emergencyContactOccupation = filter_var($request->input('MR_motherOccupation'), FILTER_SANITIZE_STRING);
                            $emergencyContactRelationship = 'MOTHER'; 
                        $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                    }
                    elseif($request->input('MR_emergencyContactPerson') == 'GUARDIAN'){
                        $medRecord->emergencyContactName = filter_var($request->input('MR_guardian'), FILTER_SANITIZE_STRING);
                        $medRecord->emergencyContactOccupation = filter_var($request->input('MR_guardianOccupation'), FILTER_SANITIZE_STRING);
                            $emergencyContactRelationship = 'GUARDIAN'; 
                        $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                    }
                    else{
                        $medRecord->emergencyContactName = filter_var($request->input('MR_emergencyContactName'), FILTER_SANITIZE_STRING);
                        $medRecord->emergencyContactOccupation = filter_var($request->input('MR_emergencyContactOccupation'), FILTER_SANITIZE_STRING);
                        $medRecord->emergencyContactRelationship = filter_var($request->input('MR_emergencyContactRelationship'), FILTER_SANITIZE_STRING);
                    }
                    $medRecord->emergencyContactAddress = filter_var($request->input('MR_emergencyContactAddress'), FILTER_SANITIZE_STRING);
                    $medRecord->emergencyContactNumber = filter_var(ltrim($request->input('MR_emergencyContactNumber'), '0'), FILTER_VALIDATE_INT);
    
                    $medRecord->hospitalization = filter_var($request->input('hospitalization'), FILTER_SANITIZE_NUMBER_INT);
                    $medRecord->hospDetails = $request->filled('hospitalizationDetails') ? filter_var($request->input('hospitalizationDetails'), FILTER_SANITIZE_STRING) : 'N/A';   
                    $medRecord->takingMedsRegularly = filter_var($request->input('regMeds'), FILTER_SANITIZE_NUMBER_INT);
                    $medRecord->medsDetails = $request->filled('regMedsDetails') ? filter_var($request->input('regMedsDetails'), FILTER_SANITIZE_STRING) : 'N/A';  
                    $medRecord->allergic = filter_var($request->input('allergy'), FILTER_SANITIZE_NUMBER_INT);
                    $medRecord->allergyDetails = $request->filled('allergyDetails') ? filter_var($request->input('allergyDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                    # SAVE THE FOREIGN KEYS
                    $medRecord->familyHistoryID = $familyHistory->familyHistoryID;
                    $medRecord->immunizationHistoryID = $immunizationHistory->immunizationHistoryID;
                    $medRecord->pastIllnessID = $pastIllness->pastIllnessID;
                    $medRecord->personalSocialHistoryID = $psHistory->personalSocialHistoryID;
                    $medRecord->presentIllnessID = $presentIllness->presentIllnessID;
    
                    # UPLOADS
                        // Get the validated, uploaded file
                        $chestXray = $request->file('MR_chestXray');
                        $cbcresults = $request->file('MR_cbcresults');
                        $hepaBscreening = $request->file('MR_hepaBscreening');
                        $bloodtype = $request->file('MR_bloodtype');
                          // Filename prefix
                        $secondID = $user->student_id_number ?: $user->applicant_id_number;
                        $uploadPrefix = $user->id.''.$secondID.''.$request->lastName;
    
                        $chestXrayName = $uploadPrefix.'CHESTXRAY.'.$chestXray->getClientOriginalExtension();
                        $cbcresultsName = $uploadPrefix.'CBCRESULTS.'.$cbcresults->getClientOriginalExtension();
                        $hepaBscreeningName = $uploadPrefix.'HEPATITISBSCREENING.'.$hepaBscreening->getClientOriginalExtension();
                        $bloodtypeName = $uploadPrefix.'BLOODTYPE.'.$bloodtype->getClientOriginalExtension();
    
                            // Store the file on the server
                        $medRecord->chestXray = $chestXray->storeAs('uploads', $chestXrayName, 'public');
                        $medRecord->CBCResults = $cbcresults->storeAs('uploads', $cbcresultsName, 'public');
                        $medRecord->hepaBscreening = $hepaBscreening->storeAs('uploads', $hepaBscreeningName, 'public');
                        $medRecord->bloodType = $bloodtype->storeAs('uploads', $bloodtypeName, 'public');
                            // Other uploads
                        if($otherUpload1 = $request->file('MR_additionalUpload1')){
                            $otherUpload1name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult1'), FILTER_SANITIZE_STRING).'.'.$otherUpload1->getClientOriginalExtension();
                            $medRecord->resultName1 = filter_var($request->input('MR_additionalResult1'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage1 = $otherUpload1->storeAs('uploads', $otherUpload1name, 'public');
                        }
                        if($otherUpload2 = $request->file('MR_additionalUpload2')){
                            $otherUpload2name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult2'), FILTER_SANITIZE_STRING).'.'.$otherUpload2->getClientOriginalExtension();
                            $medRecord->resultName2 = filter_var($request->input('MR_additionalResult2'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage2 = $otherUpload2->storeAs('uploads', $otherUpload2name, 'public');
                        }
                        if($otherUpload3 = $request->file('MR_additionalUpload3')){
                            $otherUpload3name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult3'), FILTER_SANITIZE_STRING).'.'.$otherUpload3->getClientOriginalExtension();
                            $medRecord->resultName3 = filter_var($request->input('MR_additionalResult3'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage3 = $otherUpload3->storeAs('uploads', $otherUpload3name, 'public');
                        }
                        if($otherUpload4 = $request->file('MR_additionalUpload4')){
                            $otherUpload4name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult4'), FILTER_SANITIZE_STRING).'.'.$otherUpload4->getClientOriginalExtension();
                            $medRecord->resultName4 = filter_var($request->input('MR_additionalResult4'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage4 = $otherUpload4->storeAs('uploads', $otherUpload4name, 'public');
                        }
                        if($otherUpload5 = $request->file('MR_additionalUpload5')){
                            $otherUpload5name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult5'), FILTER_SANITIZE_STRING).'.'.$otherUpload5->getClientOriginalExtension();
                            $medRecord->resultName5 = filter_var($request->input('MR_additionalResult5'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage5 = $otherUpload5->storeAs('uploads', $otherUpload5name, 'public');
                        }
                        if($otherUpload6 = $request->file('MR_additionalUpload6')){
                            $otherUpload6name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult6'), FILTER_SANITIZE_STRING).'.'.$otherUpload6->getClientOriginalExtension();
                            $medRecord->resultName6 = filter_var($request->input('MR_additionalResult6'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage6 = $otherUpload6->storeAs('uploads', $otherUpload6name, 'public');
                        }
                        if($otherUpload7 = $request->file('MR_additionalUpload7')){
                            $otherUpload7name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult7'), FILTER_SANITIZE_STRING).'.'.$otherUpload7->getClientOriginalExtension();
                            $medRecord->resultName7 = filter_var($request->input('MR_additionalResult7'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage7 = $otherUpload7->storeAs('uploads', $otherUpload7name, 'public');
                        }
                        if($otherUpload8 = $request->file('MR_additionalUpload8')){
                            $otherUpload8name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult8'), FILTER_SANITIZE_STRING).'.'.$otherUpload8->getClientOriginalExtension();
                            $medRecord->resultName8 = filter_var($request->input('MR_additionalResult8'), FILTER_SANITIZE_STRING);
                            $medRecord->resultImage8 = $otherUpload8->storeAs('uploads', $otherUpload8name, 'public');
                        }
        
                        $medRecord->signed = intval('1');
                    /**
                     * SAVE EVERY INPUT WITH && SO THAT IF ONE ->save() RETURNS FALSE, $res WILL BE FALSE
                     */
                $res = $medRecord->save();
    
                //IF FALSE
                if(!$res){
                    // Log error and display user-friendly message
                    Log::error('Failed to register user.');
                    return redirect()->back()->with('fail','Failed to register. Please try again later.');
                }
    
                $familyHistory->MR_id =  $medRecord->MR_id;
                $psHistory->MR_id =  $medRecord->MR_id;
                $pastIllness->MR_id =  $medRecord->MR_id;
                $presentIllness->MR_id =  $medRecord->MR_id;
                $immunizationHistory->MR_id =  $medRecord->MR_id;
    
                $familyHistory->save();
                $psHistory->save();
                $pastIllness->save();
                $presentIllness->save();
                $immunizationHistory->save();
    
                $user->hasMedRecord = intval('1');
                $user->MR_id =  $medRecord->MR_id;
                $user->save();
    
                return redirect('/')->with('MedicalRecordSuccess', 'Medical record saved successfully');
            } 
            catch (QueryException $ex) {
                // Handle the SQL error here
                return redirect()->back()->withErrors([
                    "An error occurred: " . $ex->getMessage(),
                    'If this error persists, please contact the admin from Bicol University Health Services.'
                ])->withInput();
                Log::error('Error from '.$user->id.': '. $ex->getMessage());
            }
            
        } // END OF medFormSubmit FUNCTION
        
    // END OF medFormSubmit FUNCTION

    // function for WalkInHealthRecordPersonnel
    public function showWalkInHealthRecordPersonnelSubmit(Request $request){
           //dd($request);
                /* PHONE NUMBER */
                $rules = [
                    'MR_parentGuardianContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
                    'MR_studentContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
                    'MR_emergencyContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
                ];
                $validator = Validator::make($request->only(['MR_parentGuardianContactNumber', 'MR_studentContactNumber', 'MR_emergencyContactNumber']), $rules);
                    // Return error message if validation fails
                if ($validator->fails()) {
                    #dd($validator);
                    return back()->withErrors($validator)->withInput();
                }
                        /* VALIDATE USER INPUT */
                $validator = Validator::make($request->all(), [
                    /* BASIC INFORMATION */
                    'campusSelect' => 'required',
                    'courseSelect' => 'required',
                    'schoolYearStart' => 'required_with:schoolYearEnd|integer|min:2015',
                    'schoolYearEnd' => [
                        'required_with:schoolYearStart',
                        'integer',
                        'gt:schoolYearStart',
                        function ($attribute, $value, $fail) use ($request) {
                            $start = $request->input('schoolYearStart');
                            if ($value != $start + 1) {
                                $fail('The end school year must be exactly one greater than school year start.');
                            }
                        },
                    ],
                    'MR_lastName' => 'required|string',
                    'MR_firstName' => 'required|string',
                    'MR_middleName' => 'nullable',
                    'MR_age' => 'required|integer',
                    'MR_sex' => 'required|string',
                    'MR_dateOfBirth' => 'required',
                    'MR_civilStatus' => 'required|string',
                    'MR_nationality' => 'required|string',
                    'MR_religion' => 'required|string',
                    'MR_addressRegion' => 'required|string',
                    'MR_addressProvince' => 'required|string',
                    'MR_addressCityMunicipality' => 'required|string',
                    'MR_addressBrgySubdVillage' => 'required|string',
                    'MR_addressHouseNoStreet' => 'required|string',
                    'MR_fatherName' => 'required|string',
                    'MR_fatherOccupation' => 'nullable',
                    'MR_fatherOffice' => 'nullable',
                    'MR_motherName' => 'required|string',
                    'MR_motherOccupation' => 'nullable',
                    'MR_motherOffice' => 'nullable',
                    'MR_guardian' => 'nullable|string',
                    'MR_guardianAddress' => 'nullable|required_with:MR_guardian|string',
                    'MR_emergencyContactName' => 'required|string',
                    'MR_emergencyContactOccupation' => 'required|string',
                    'MR_emergencyContactRelationship' => 'required|string',
                    'MR_emergencyContactAddress' => 'required|string',
        
                    /* FAMILY HISTORY[FH_] */
                    'FH_cancer' => 'required|in:0,1', 
                    'FH_heartDisease' => 'required|in:0,1', 
                    'FH_hypertension' => 'required|in:0,1', 
                    'FH_thyroidDisease' => 'required|in:0,1', 
                    'FH_tuberculosis' => 'required|in:0,1', 
                    'FH_diabetesMelittus' => 'required|in:0,1', 
                    'FH_mentalDisorder' => 'required|in:0,1', 
                    'FH_asthma' => 'required|in:0,1', 
                    'FH_convulsions' => 'required|in:0,1', 
                    'FH_bleedingDyscrasia' => 'required|in:0,1', 
                    'FH_eyeDisorder' => 'required|in:0,1', 
                    'FH_skinProblems' => 'required|in:0,1', 
                    'FH_kidneyProblems' => 'required|in:0,1', 
                    'FH_gastroDisease' => 'required|in:0,1', 
                    'FH_others' => 'required|in:0,1', 
                    'FH_othersDetails' => 'required_if:FH_others,1|string', 
        
                    /* PERSONAL SOCIAL HISTORY[PSH_] */
                    'PSH_smoking' => 'required|in:0,1', 
                    'PSH_smoking_amount' => 'required_if:PSH_smoking,1|int', 
                    'PSH_smoking_freq' => 'required_if:PSH_smoking,1|int', 
                    'PSH_drinking' => 'required|in:0,1',
                    'PSH_drinking_amountOfBeer' => 'nullable|string',
                    'PSH_drinking_freqOfBeer' => 'nullable|required_with:PSH_drinking_amountOfBeer|string',
                    'PSH_drinking_amountofShots' => 'nullable|string',
                    'PSH_drinking_freqOfShots' => 'nullable|required_with:PSH_drinking_amountofShots|string',
        
                    /* PAST ILLNESS[pi_] */
                    'pi_primaryComplex' => 'required|in:0,1', 
                    'pi_chickenPox' => 'required|in:0,1', 
                    'pi_kidneyDisease' => 'required|in:0,1', 
                    'pi_typhoidFever' => 'required|in:0,1', 
                    'pi_earProblems' => 'required|in:0,1', 
                    'pi_heartDisease' => 'required|in:0,1', 
                    'pi_leukemia' => 'required|in:0,1', 
                    'pi_asthma' => 'required|in:0,1', 
                    'pi_diabetes' => 'required|in:0,1', 
                    'pi_eyeDisorder' => 'required|in:0,1', 
                    'pi_pneumonia' => 'required|in:0,1', 
                    'pi_dengue' => 'required|in:0,1', 
                    'pi_measles' => 'required|in:0,1', 
                    'pi_hepatitis' => 'required|in:0,1', 
                    'pi_rheumaticFever' => 'required|in:0,1', 
                    'pi_mentalDisorder' => 'required|in:0,1', 
                    'pi_skinProblems' => 'required|in:0,1', 
                    'pi_poliomyetis' => 'required|in:0,1', 
                    'pi_thyroidDisorder' => 'required|in:0,1', 
                    'pi_anemia' => 'required|in:0,1', 
                    'pi_mumps' => 'required|in:0,1', 
        
                    /* PRESENT ILLNESS[PI_] */
                    'PI_chestPain' => 'required|in:0,1', 
                    'PI_insomnia' => 'required|in:0,1', 
                    'PI_jointPains' => 'required|in:0,1', 
                    'PI_dizziness' => 'required|in:0,1', 
                    'PI_headaches' => 'required|in:0,1', 
                    'PI_indigestion' => 'required|in:0,1', 
                    'PI_swollenFeet' => 'required|in:0,1', 
                    'PI_weightLoss' => 'required|in:0,1', 
                    'PI_nauseaOrVomiting' => 'required|in:0,1', 
                    'PI_soreThroat' => 'required|in:0,1', 
                    'PI_frequentUrination' => 'required|in:0,1', 
                    'PI_difficultyOfBreathing' => 'required|in:0,1', 
                    'PI_others' => 'required|in:0,1', 
                    'PI_othersDetails' => 'required_if:PI_others,1|string', 
        
                    /* HOSPITALIZATION, REGULAR MEDS, AND ALLREGIES */
                    'hospitalization' => 'required|in:0,1', 
                    'hospitalizationDetails' => 'required_if:hospitalization,1|string', 
                    'regMeds' => 'required|in:0,1', 
                    'regMedsDetails' => 'required_if:regMeds,1|string', 
                    'allergy' => 'required|in:0,1', 
                    'allergyDetails' => 'required_if:allergy,1|string', 
        
                    /* IMMUNIZATION HISTORY[IH_] */
                    'IH_bcg' => 'required|in:0,1', 
                    'IH_polio' => 'required|in:0,1', 
                    'IH_mumps' => 'required|in:0,1', 
                    'IH_typhoid' => 'required|in:0,1', 
                    'IH_hepatitisA' => 'required|in:0,1', 
                    'IH_chickenPox' => 'required|in:0,1', 
                    'IH_dpt' => 'required|in:0,1', 
                    'IH_measles' => 'required|in:0,1', 
                    'IH_germanMeasles' => 'required|in:0,1', 
                    'IH_hepatitisB' => 'required|in:0,1', 
                    'IH_others' => 'required|in:0,1', 
                    'IH_othersDetails' => 'required_if:FH_others,1|string',
                    
                    'MR_chestXray' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                    'MR_cbcresults' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                    'MR_hepaBscreening' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                    'MR_bloodtype' => 'required|image|mimes:jpeg,jpg,png|max:5120',
                    'certify' => 'required|in:1',
        
                    /* NAME OF UPLOADS */
                    'MR_additionalResult1' => 'nullable|string',
                    'MR_additionalResult2' => 'nullable|string',
                    'MR_additionalResult3' => 'nullable|string',
                    'MR_additionalResult4' => 'nullable|string',
                    'MR_additionalResult5' => 'nullable|string',
                    'MR_additionalResult6' => 'nullable|string',
                    'MR_additionalResult7' => 'nullable|string',
                    'MR_additionalResult8' => 'nullable|string',
        
                    /* UPLOADS */
                    'MR_additionalUpload1' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                    'MR_additionalUpload2' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                    'MR_additionalUpload3' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                    'MR_additionalUpload4' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                    'MR_additionalUpload5' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                    'MR_additionalUpload6' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                    'MR_additionalUpload7' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', 
                    'MR_additionalUpload8' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        
                ],[ #--- CATCH SPECIFIC ERRORS ---#
                    'campusSelect.required' => 'Please select a campus.',
                    'courseSelect.required' => 'Please select a course.',
                    'schoolYearStart.required_with' => 'Please provide a start year.',
                    'schoolYearStart.integer' => 'The start year must be a number.',
                    'schoolYearStart.min' => 'The start year must be at least 2015.',
                    'schoolYearEnd.required_with' => 'Please provide an end year.',
                    'schoolYearEnd.integer' => 'The end year must be a number.',
                    'schoolYearEnd.gt' => 'The end year must be greater than the start year.',
                    'PSH_smoking_amount.required_if' => 'Please provide the amount of cigarettes.',
                    'PSH_smoking_freq.required_if' => 'Please provide the frequency of cigarette consumption.',
                    'PSH_drinking_amountOfBeer.required_without_all' => 'Please indicate the amount of beer you drink.',
                    'PSH_drinking_freqOfBeer.required_without_all' => 'Please indicate the frequency of beer you drink.',
                    'PSH_drinking_amountofShots.required_without_all' => 'Please indicate the amount of shots you drink.',
                    'PSH_drinking_freqOfShots.required_without_all' => 'Please indicate the frequency of shots you drink.',
                    'PI_othersDetails.required_if' => 'Please provide the details of your other Present Illness/es',
                    'hospitalizationDetails.required_if' => 'Please provide the details of your hospitalization for serious illness, operation, fracture or injury.',
                    'regMedsDetails.required_if' => 'Please provide the name/s of your regular drug/s.',
                    'allergyDetails.required_if' => 'Please specify your allergy details.',
                    'FH_othersDetails.required_if' => 'Please provide the details of your other disease/s in Family History.',
                    'IH_othersDetails.required_if' => 'Please provide the details of other immunization you have taken.',
                    'certify.required' => 'Please certify that the foregoing answers are true and complete, and to the best of my knowledge by checking the checkbox.'
                ]); /* END OF VALIDATION */
        
                // Return error message if validation fails
                if ($validator->fails()) {
                    #dd($validator);
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                    /* IF VALIDATION IS GOOD, GET USER AND SANITIZE USER-INPUT THEN SAVE TO DATABASE */
                    ###----- FAMILY HISTORY TABLE -----###
                try {
                    $familyHistory = new FamilyHistory();
                        $familyHistory->cancer = filter_var($request->FH_cancer, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->heartDisease = filter_var($request->FH_heartDisease, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->hypertension = filter_var($request->FH_hypertension, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->thyroidDisease = filter_var($request->FH_thyroidDisease, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->tuberculosis = filter_var($request->FH_tuberculosis, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->diabetesMelittus = filter_var($request->FH_diabetesMelittus, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->mentalDisorder = filter_var($request->FH_mentalDisorder, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->asthma = filter_var($request->FH_asthma, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->convulsions = filter_var($request->FH_convulsions, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->bleedingDyscrasia = filter_var($request->FH_bleedingDyscrasia, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->eyeDisorder = filter_var($request->FH_eyeDisorder, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->skinProblems = filter_var($request->FH_skinProblems, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->kidneyProblems = filter_var($request->FH_kidneyProblems, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->gastrointestinalDisease = filter_var($request->FH_gastroDisease, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->others = filter_var($request->FH_others, FILTER_SANITIZE_NUMBER_INT);
                        $familyHistory->othersDetails = $request->filled('FH_othersDetails') ? filter_var($request->input('FH_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                    $res = $familyHistory->save();
                    if(!$res){
                        return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                    }
        
                    ###----- PERSONAL SOCIAL HISTORY TABLE -----###
                    $psHistory = new PersonalSocialHistory();
                        $psHistory->smoking = filter_var($request->input('PSH_smoking'), FILTER_SANITIZE_NUMBER_INT);
                        $psHistory->sticksPerDay = $request->filled('PSH_smoking_amount') ? filter_var($request->input('PSH_smoking_amount'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
                        $psHistory->years = $request->filled('PSH_smoking_freq') ? filter_var($request->input('PSH_smoking_freq'), FILTER_SANITIZE_NUMBER_INT) : intval('0');
                        $psHistory->drinking = filter_var($request->input('PSH_drinking'), FILTER_SANITIZE_NUMBER_INT);
                        $psHistory->numberOfBeers = $request->filled('PSH_drinking_amountOfBeer') ? filter_var($request->input('PSH_drinking_amountOfBeer'), FILTER_SANITIZE_STRING) : 'N/A';
                        $psHistory->beerFrequency = $request->filled('PSH_drinking_freqOfBeer') ? filter_var($request->input('PSH_drinking_freqOfBeer'), FILTER_SANITIZE_STRING) : 'N/A';
                        $psHistory->numberOfShots = $request->filled('PSH_drinking_amountofShots') ? filter_var($request->input('PSH_drinking_amountofShots'), FILTER_SANITIZE_STRING) : 'N/A';
                        $psHistory->shotsFrequency = $request->filled('PSH_drinking_freqOfShots') ? filter_var($request->input('PSH_drinking_freqOfShots'), FILTER_SANITIZE_STRING) : 'N/A';
                    $res = $psHistory->save();
                        if(!$res){
                            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                        }
                
                    ###----- PAST ILLNESS TABLE -----###
                    $pastIllness = new PastIllness();
                        $pastIllness->primaryComplex = filter_var($request->input('pi_primaryComplex'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->chickenPox = filter_var($request->input('pi_chickenPox'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->kidneyDisease = filter_var($request->input('pi_kidneyDisease'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->typhoidFever = filter_var($request->input('pi_typhoidFever'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->earProblems = filter_var($request->input('pi_earProblems'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->heartDisease = filter_var($request->input('pi_heartDisease'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->leukemia = filter_var($request->input('pi_leukemia'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->asthma = filter_var($request->input('pi_asthma'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->diabetes = filter_var($request->input('pi_diabetes'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->eyeDisorder = filter_var($request->input('pi_eyeDisorder'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->pneumonia = filter_var($request->input('pi_pneumonia'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->dengue = filter_var($request->input('pi_dengue'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->measles = filter_var($request->input('pi_measles'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->hepatitis = filter_var($request->input('pi_hepatitis'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->rheumaticFever = filter_var($request->input('pi_rheumaticFever'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->mentalDisorder = filter_var($request->input('pi_mentalDisorder'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->skinProblems = filter_var($request->input('pi_skinProblems'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->poliomyetis = filter_var($request->input('pi_poliomyetis'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->thyroidDisorder = filter_var($request->input('pi_thyroidDisorder'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->anemia = filter_var($request->input('pi_anemia'), FILTER_SANITIZE_NUMBER_INT);
                        $pastIllness->mumps = filter_var($request->input('pi_mumps'), FILTER_SANITIZE_NUMBER_INT);
                    $res = $pastIllness->save();
                        if(!$res){
                            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                        }
                
                    ###----- PRESENT ILLNESS TABLE -----###
                    $presentIllness = new PresentIllness();
                        $presentIllness->chestPain = filter_var($request->input('PI_chestPain'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->insomnia = filter_var($request->input('PI_insomnia'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->jointPains = filter_var($request->input('PI_jointPains'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->dizziness = filter_var($request->input('PI_dizziness'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->headaches = filter_var($request->input('PI_headaches'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->indigestion = filter_var($request->input('PI_indigestion'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->swollenFeet = filter_var($request->input('PI_swollenFeet'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->weightLoss = filter_var($request->input('PI_weightLoss'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->nauseaOrVomiting = filter_var($request->input('PI_nauseaOrVomiting'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->soreThroat = filter_var($request->input('PI_soreThroat'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->frequentUrination = filter_var($request->input('PI_frequentUrination'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->difficultyOfBreathing = filter_var($request->input('PI_difficultyOfBreathing'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->others = filter_var($request->input('PI_others'), FILTER_SANITIZE_NUMBER_INT);
                        $presentIllness->othersDetails = $request->filled('PI_othersDetails') ? filter_var($request->input('PI_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                    $res = $presentIllness->save();
                        if(!$res){
                            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                        }
        
                ###----- IMMUNIZATION HISTORY TABLE -----###
                    $immunizationHistory = new ImmunizationHistory;
                        $immunizationHistory->BCG = filter_var($request->input('IH_bcg'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->polio = filter_var($request->input('IH_polio'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->mumps = filter_var($request->input('IH_mumps'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->typhoid = filter_var($request->input('IH_typhoid'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->hepatitisA = filter_var($request->input('IH_hepatitisA'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->chickenPox = filter_var($request->input('IH_chickenPox'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->DPT = filter_var($request->input('IH_dpt'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->measles = filter_var($request->input('IH_measles'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->germanMeasles = filter_var($request->input('IH_germanMeasles'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->hepatitisB = filter_var($request->input('IH_hepatitisB'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->others = filter_var($request->input('IH_others'), FILTER_SANITIZE_NUMBER_INT);
                        $immunizationHistory->othersDetails = $request->filled('IH_othersDetails') ? filter_var($request->input('IH_othersDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                    $res = $immunizationHistory->save();
                        if(!$res){
                            return redirect()->back()->with('fail','An error occured while saving your data. Please try again later.');
                        }
                        
                        $user = Auth::user();
                ###----- MEDICAL RECORD TABLE -----###
                    $medRecord = new MedicalRecord();
                        $medRecord->student_id = $user->id;
                        $medRecord->campus = filter_var($request->input('campusSelect'), FILTER_SANITIZE_STRING);
                        $medRecord->course = filter_var($request->input('courseSelect'), FILTER_SANITIZE_STRING);
                        $medRecord->SYstart = filter_var($request->input('schoolYearStart'), FILTER_SANITIZE_NUMBER_INT);
                        $medRecord->SYend = filter_var($request->input('schoolYearEnd'), FILTER_SANITIZE_NUMBER_INT);
                        $medRecord->last_name = filter_var($request->input('MR_lastName'), FILTER_SANITIZE_STRING);
                        $medRecord->first_name = filter_var($request->input('MR_firstName'), FILTER_SANITIZE_STRING);
                        $medRecord->middle_name = filter_var($request->input('MR_middleName'), FILTER_SANITIZE_STRING);
                        $medRecord->age = filter_var($request->input('MR_age'), FILTER_SANITIZE_NUMBER_INT);
                        $medRecord->sex = filter_var($request->input('MR_sex'), FILTER_SANITIZE_STRING);
        
                        $dateString = $request->input('MR_dateOfBirth');
                        $date = DateTime::createFromFormat('Y F d', $dateString);
                        $formattedDate = $date->format('Y-m-d');
        
                        $medRecord->dateOfBirth = $formattedDate;
                        $medRecord->civilStatus = filter_var($request->input('MR_civilStatus'), FILTER_SANITIZE_STRING);
                        $medRecord->region = filter_var($request->input('MR_addressRegion'), FILTER_SANITIZE_STRING);
                        $medRecord->province = filter_var($request->input('MR_addressProvince'), FILTER_SANITIZE_STRING);
                        $medRecord->cityMunicipality = filter_var($request->input('MR_addressCityMunicipality'), FILTER_SANITIZE_STRING);
                        $medRecord->barangaySubdVillage = filter_var($request->input('MR_addressBrgySubdVillage'), FILTER_SANITIZE_STRING);
                        $medRecord->houseNumberStName = filter_var($request->input('MR_address'), FILTER_SANITIZE_STRING);
                        $medRecord->nationality = filter_var($request->input('MR_nationality'), FILTER_SANITIZE_STRING);
                        $medRecord->religion = filter_var($request->input('MR_religion'), FILTER_SANITIZE_STRING);
                        $medRecord->fatherName = filter_var($request->input('MR_fatherName'), FILTER_SANITIZE_STRING);
                        $medRecord->fatherOccupation = filter_var($request->input('MR_fatherOccupation'), FILTER_SANITIZE_STRING);
                        $medRecord->fatherOfficeAddress = filter_var($request->input('MR_fatherOffice'), FILTER_SANITIZE_STRING);
                        $medRecord->motherName = filter_var($request->input('MR_motherName'), FILTER_SANITIZE_STRING);
                        $medRecord->motherOccupation = filter_var($request->input('MR_motherOccupation'), FILTER_SANITIZE_STRING);
                        $medRecord->motherOfficeAddress = filter_var($request->input('MR_motherOffice'), FILTER_SANITIZE_STRING);
                        $medRecord->guardianName = $request->filled('MR_guardian') ? filter_var($request->input('MR_guardian'), FILTER_SANITIZE_STRING) : 'N/A';     
                        $medRecord->guardianAddress = $request->filled('MR_guardianAddress') ? filter_var($request->input('MR_guardianAddress'), FILTER_SANITIZE_STRING) : 'N/A';    
                        $medRecord->parentGuardianContactNumber = filter_var(ltrim($request->input('MR_parentGuardianContactNumber'), '0'), FILTER_VALIDATE_INT);
                        $medRecord->studentContactNumber = filter_var(ltrim($request->input('MR_studentContactNumber'), '0'), FILTER_VALIDATE_INT);
                        
                        if($request->input('MR_emergencyContactPerson') == 'FATHER'){
                            $medRecord->emergencyContactName = filter_var($request->input('MR_fatherName'), FILTER_SANITIZE_STRING);
                            $medRecord->emergencyContactOccupation = filter_var($request->input('MR_fatherOccupation'), FILTER_SANITIZE_STRING);
                                $emergencyContactRelationship = 'FATHER'; 
                            $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                        }
                        elseif($request->input('MR_emergencyContactPerson') == 'MOTHER'){
                            $medRecord->emergencyContactName = filter_var($request->input('MR_motherName'), FILTER_SANITIZE_STRING);
                            $medRecord->emergencyContactOccupation = filter_var($request->input('MR_motherOccupation'), FILTER_SANITIZE_STRING);
                                $emergencyContactRelationship = 'MOTHER'; 
                            $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                        }
                        elseif($request->input('MR_emergencyContactPerson') == 'GUARDIAN'){
                            $medRecord->emergencyContactName = filter_var($request->input('MR_guardian'), FILTER_SANITIZE_STRING);
                            $medRecord->emergencyContactOccupation = filter_var($request->input('MR_guardianOccupation'), FILTER_SANITIZE_STRING);
                                $emergencyContactRelationship = 'GUARDIAN'; 
                            $medRecord->emergencyContactRelationship = $emergencyContactRelationship;
                        }
                        else{
                            $medRecord->emergencyContactName = filter_var($request->input('MR_emergencyContactName'), FILTER_SANITIZE_STRING);
                            $medRecord->emergencyContactOccupation = filter_var($request->input('MR_emergencyContactOccupation'), FILTER_SANITIZE_STRING);
                            $medRecord->emergencyContactRelationship = filter_var($request->input('MR_emergencyContactRelationship'), FILTER_SANITIZE_STRING);
                        }
                        $medRecord->emergencyContactAddress = filter_var($request->input('MR_emergencyContactAddress'), FILTER_SANITIZE_STRING);
                        $medRecord->emergencyContactNumber = filter_var(ltrim($request->input('MR_emergencyContactNumber'), '0'), FILTER_VALIDATE_INT);
        
                        $medRecord->hospitalization = filter_var($request->input('hospitalization'), FILTER_SANITIZE_NUMBER_INT);
                        $medRecord->hospDetails = $request->filled('hospitalizationDetails') ? filter_var($request->input('hospitalizationDetails'), FILTER_SANITIZE_STRING) : 'N/A';   
                        $medRecord->takingMedsRegularly = filter_var($request->input('regMeds'), FILTER_SANITIZE_NUMBER_INT);
                        $medRecord->medsDetails = $request->filled('regMedsDetails') ? filter_var($request->input('regMedsDetails'), FILTER_SANITIZE_STRING) : 'N/A';  
                        $medRecord->allergic = filter_var($request->input('allergy'), FILTER_SANITIZE_NUMBER_INT);
                        $medRecord->allergyDetails = $request->filled('allergyDetails') ? filter_var($request->input('allergyDetails'), FILTER_SANITIZE_STRING) : 'N/A';
                        # SAVE THE FOREIGN KEYS
                        $medRecord->familyHistoryID = $familyHistory->familyHistoryID;
                        $medRecord->immunizationHistoryID = $immunizationHistory->immunizationHistoryID;
                        $medRecord->pastIllnessID = $pastIllness->pastIllnessID;
                        $medRecord->personalSocialHistoryID = $psHistory->personalSocialHistoryID;
                        $medRecord->presentIllnessID = $presentIllness->presentIllnessID;
        
                        # UPLOADS
                            // Get the validated, uploaded file
                            $chestXray = $request->file('MR_chestXray');
                            $cbcresults = $request->file('MR_cbcresults');
                            $hepaBscreening = $request->file('MR_hepaBscreening');
                            $bloodtype = $request->file('MR_bloodtype');
                              // Filename prefix
                            $secondID = $user->student_id_number ?: $user->applicant_id_number;
                            $uploadPrefix = $user->id.''.$secondID.''.$request->lastName;
        
                            $chestXrayName = $uploadPrefix.'CHESTXRAY.'.$chestXray->getClientOriginalExtension();
                            $cbcresultsName = $uploadPrefix.'CBCRESULTS.'.$cbcresults->getClientOriginalExtension();
                            $hepaBscreeningName = $uploadPrefix.'HEPATITISBSCREENING.'.$hepaBscreening->getClientOriginalExtension();
                            $bloodtypeName = $uploadPrefix.'BLOODTYPE.'.$bloodtype->getClientOriginalExtension();
        
                                // Store the file on the server
                            $medRecord->chestXray = $chestXray->storeAs('uploads', $chestXrayName, 'public');
                            $medRecord->CBCResults = $cbcresults->storeAs('uploads', $cbcresultsName, 'public');
                            $medRecord->hepaBscreening = $hepaBscreening->storeAs('uploads', $hepaBscreeningName, 'public');
                            $medRecord->bloodType = $bloodtype->storeAs('uploads', $bloodtypeName, 'public');
                                // Other uploads
                            if($otherUpload1 = $request->file('MR_additionalUpload1')){
                                $otherUpload1name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult1'), FILTER_SANITIZE_STRING).'.'.$otherUpload1->getClientOriginalExtension();
                                $medRecord->resultName1 = filter_var($request->input('MR_additionalResult1'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage1 = $otherUpload1->storeAs('uploads', $otherUpload1name, 'public');
                            }
                            if($otherUpload2 = $request->file('MR_additionalUpload2')){
                                $otherUpload2name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult2'), FILTER_SANITIZE_STRING).'.'.$otherUpload2->getClientOriginalExtension();
                                $medRecord->resultName2 = filter_var($request->input('MR_additionalResult2'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage2 = $otherUpload2->storeAs('uploads', $otherUpload2name, 'public');
                            }
                            if($otherUpload3 = $request->file('MR_additionalUpload3')){
                                $otherUpload3name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult3'), FILTER_SANITIZE_STRING).'.'.$otherUpload3->getClientOriginalExtension();
                                $medRecord->resultName3 = filter_var($request->input('MR_additionalResult3'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage3 = $otherUpload3->storeAs('uploads', $otherUpload3name, 'public');
                            }
                            if($otherUpload4 = $request->file('MR_additionalUpload4')){
                                $otherUpload4name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult4'), FILTER_SANITIZE_STRING).'.'.$otherUpload4->getClientOriginalExtension();
                                $medRecord->resultName4 = filter_var($request->input('MR_additionalResult4'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage4 = $otherUpload4->storeAs('uploads', $otherUpload4name, 'public');
                            }
                            if($otherUpload5 = $request->file('MR_additionalUpload5')){
                                $otherUpload5name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult5'), FILTER_SANITIZE_STRING).'.'.$otherUpload5->getClientOriginalExtension();
                                $medRecord->resultName5 = filter_var($request->input('MR_additionalResult5'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage5 = $otherUpload5->storeAs('uploads', $otherUpload5name, 'public');
                            }
                            if($otherUpload6 = $request->file('MR_additionalUpload6')){
                                $otherUpload6name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult6'), FILTER_SANITIZE_STRING).'.'.$otherUpload6->getClientOriginalExtension();
                                $medRecord->resultName6 = filter_var($request->input('MR_additionalResult6'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage6 = $otherUpload6->storeAs('uploads', $otherUpload6name, 'public');
                            }
                            if($otherUpload7 = $request->file('MR_additionalUpload7')){
                                $otherUpload7name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult7'), FILTER_SANITIZE_STRING).'.'.$otherUpload7->getClientOriginalExtension();
                                $medRecord->resultName7 = filter_var($request->input('MR_additionalResult7'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage7 = $otherUpload7->storeAs('uploads', $otherUpload7name, 'public');
                            }
                            if($otherUpload8 = $request->file('MR_additionalUpload8')){
                                $otherUpload8name = $uploadPrefix.''.filter_var($request->input('MR_additionalResult8'), FILTER_SANITIZE_STRING).'.'.$otherUpload8->getClientOriginalExtension();
                                $medRecord->resultName8 = filter_var($request->input('MR_additionalResult8'), FILTER_SANITIZE_STRING);
                                $medRecord->resultImage8 = $otherUpload8->storeAs('uploads', $otherUpload8name, 'public');
                            }
            
                            $medRecord->signed = intval('1');
                        /**
                         * SAVE EVERY INPUT WITH && SO THAT IF ONE ->save() RETURNS FALSE, $res WILL BE FALSE
                         */
                    $res = $medRecord->save();
        
                    //IF FALSE
                    if(!$res){
                        // Log error and display user-friendly message
                        Log::error('Failed to register user.');
                        return redirect()->back()->with('fail','Failed to register. Please try again later.');
                    }
        
                    $familyHistory->MR_id =  $medRecord->MR_id;
                    $psHistory->MR_id =  $medRecord->MR_id;
                    $pastIllness->MR_id =  $medRecord->MR_id;
                    $presentIllness->MR_id =  $medRecord->MR_id;
                    $immunizationHistory->MR_id =  $medRecord->MR_id;
        
                    $familyHistory->save();
                    $psHistory->save();
                    $pastIllness->save();
                    $presentIllness->save();
                    $immunizationHistory->save();
        
                    $user->hasMedRecord = intval('1');
                    $user->MR_id =  $medRecord->MR_id;
                    $user->save();
        
                    return redirect('/')->with('MedicalRecordSuccess', 'Medical record saved successfully');
                } 
                catch (QueryException $ex) {
                    // Handle the SQL error here
                    return redirect()->back()->withErrors([
                        "An error occurred: " . $ex->getMessage(),
                        'If this error persists, please contact the admin from Bicol University Health Services.'
                    ])->withInput();
                    Log::error('Error from '.$user->id.': '. $ex->getMessage());
                }
                
            } // END OF medFormSubmit FUNCTION
        
}
