<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

class MedicalRecordFormController extends Controller
{
    /* ACCESS MEDICAL FORM */
    public function medicalRecordFormReg(){
        if(Auth::check()){
            /* VALIDATION STATEMENT/METHOD TO SEE IF USER ALREADY HAS SUBMITTED MEDICAL FORM */
                if(Auth::user()->hasMedRecord == 0){
                    return view('medicalRecordForm');
                }
            return redirect()->back()->with('alreadySubmitted', 'You have already submitted your Medical Form!');
        }
        else{
            return redirect('login');
        }
    }

    public function showPatientMedFormList(){
        $searchQuery = request()->search;
        $filterByCampus = request()->campus;
        $filterByCourse = request()->course;
    
        $patientsList = UserStudent::has('medicalRecord')
            ->when($searchQuery, function($query, $searchQuery) {
                return $query->where('first_name', 'LIKE', '%'.$searchQuery.'%')
                             ->orWhere('middle_name', 'LIKE', '%'.$searchQuery.'%')
                             ->orWhere('last_name', 'LIKE', '%'.$searchQuery.'%')
                             ->orWhere('applicant_id_number', 'LIKE', '%'.$searchQuery.'%')
                             ->orWhere('student_id_number', 'LIKE', '%'.$searchQuery.'%');
            })
            ->join('medicalrecords', 'users_students.MR_id', '=', 'medicalrecords.MR_id')
            ->when($filterByCampus, function($query, $filterByCampus) {
                return $query->where('medicalrecords.campus', '=', $filterByCampus);
            })
            ->when($filterByCourse, function($query, $filterByCourse) {
                return $query->where('medicalrecords.course', '=', $filterByCourse);
            })
            ->select('users_students.*')
            ->get();
    
        return view('admin.medicalRecordList', [
            'patients' => $patientsList,
            'searchQuery' => $searchQuery,
            'filterByCampus' => $filterByCampus,
            'filterByCourse' => $filterByCourse
        ]);
    }

    public function showPatientForm($patientID){
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
        return view('admin.medicalRecordFormClinicSide')->with('patient', $patient);
    }

        #####---MEDICAL RECORD FORM SUBMISSION---#####
    public function medFormSubmit(Request $request){
                /* PHONE NUMBER */
        $rules = [
            'MR_parentGuardianContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
            'MR_studentContactNumber' => ['required', 'regex:/^(\\+63|0)\\d{10}$/'],
        ];
        $validator = Validator::make($request->only(['MR_parentGuardianContactNumber', 'MR_studentContactNumber']), $rules);
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
            'schoolYearEnd' => 'required_with:schoolYearStart|integer|gt:schoolYearStart',
            'MR_lastName' => 'required|string',
            'MR_firstName' => 'required|string',
            'MR_middleName' => 'nullable',
            'MR_age' => 'required|integer',
            'MR_sex' => 'required|string',
            'MR_placeOfBirth' => 'required|string',
            'MR_civilStatus' => 'required|string',
            'MR_nationality' => 'required|string',
            'MR_religion' => 'required|string',
            'MR_address' => 'required|string',
            'MR_fatherName' => 'required|string',
            'MR_fatherOccupation' => 'nullable',
            'MR_fatherOffice' => 'nullable',
            'MR_motherName' => 'required|string',
            'MR_motherOccupation' => 'nullable',
            'MR_motherOffice' => 'nullable',
            'MR_guardian' => 'nullable|string',
            'MR_guardianAddress' => 'nullable|required_with:MR_guardian|string',

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
            'PSH_drinking_amountOfBeer' => 'nullable|required_if:PSH_drinking,1|string',
            'PSH_drinking_freqOfBeer' => 'nullable|required_with:PSH_drinking_amountOfBeer|string',
            'PSH_drinking_amountofShots' => 'nullable|required_if:PSH_drinking,1|string',
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

            /* SIGNATURES */
            'MR_studentSignature' => 'required|image|mimes:jpeg,jpg,png|max:5120', 
            'MR_parentGuardianSignature' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'MR_certify' => 'required|in:1'

        ],[ #--- CATCH SPECIFIC ERRORS ---#
            'required' => 'The :attribute field is required.',
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
            'MR_certify.required' => 'Please certify that the foregoing answers are true and complete, and to the best of my knowledge by checking the checkbox.'
        ]); /* END OF VALIDATION */

        // Return error message if validation fails
        if ($validator->fails()) {
            #dd($validator);
            return back()->withErrors($validator)->withInput();
        }
            /* IF VALIDATION IS GOOD, GET USER AND SANITIZE USER-INPUT THEN SAVE TO DATABASE */
            ###----- FAMILY HISTORY TABLE -----###
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
                dd($res);
            }

            ###----- FAMILY HISTORY TABLE -----###
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
                    dd($res);
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
                    dd($res);
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
                    dd($res);
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
                    dd($res);
                }     
            
        ###----- MEDICAL RECORD TABLE -----###
            $medRecord = new MedicalRecord();
                $medRecord->student_id = $user->id;
                $medRecord->campus = filter_var($request->input('campusSelect'), FILTER_SANITIZE_STRING);
                $medRecord->course = filter_var($request->input('courseSelect'), FILTER_SANITIZE_STRING);
                $medRecord->SYstart = filter_var($request->input('schoolYearStart'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->SYend = filter_var($request->input('schoolYearEnd'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->lastName = filter_var($request->input('MR_lastName'), FILTER_SANITIZE_STRING);
                $medRecord->firstName = filter_var($request->input('MR_firstName'), FILTER_SANITIZE_STRING);
                $medRecord->middleName = filter_var($request->input('MR_middleName'), FILTER_SANITIZE_STRING);
                $medRecord->age = filter_var($request->input('MR_age'), FILTER_SANITIZE_NUMBER_INT);
                $medRecord->sex = filter_var($request->input('MR_sex'), FILTER_SANITIZE_STRING);
                $medRecord->placeOfBirth = filter_var($request->input('MR_placeOfBirth'), FILTER_SANITIZE_STRING);
                $medRecord->civilStatus = filter_var($request->input('MR_civilStatus'), FILTER_SANITIZE_STRING);
                $medRecord->homeAddress = filter_var($request->input('MR_address'), FILTER_SANITIZE_STRING);
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

                # SIGNATURES
                    // Get the validated, uploaded file
                $studentSignature = $request->file('MR_studentSignature');
                $parentGuardianSignature = $request->file('MR_parentGuardianSignature');
                    // Sanitize the file name to remove any special characters
                $studentSignatureName = filter_var($studentSignature->getClientOriginalName(), FILTER_SANITIZE_STRING);
                $parentGuardianSignatureName = filter_var($parentGuardianSignature->getClientOriginalName(), FILTER_SANITIZE_STRING);
                    // Store the file on the server
                $medRecord->studentSignature = $studentSignature->storeAs('uploads', $studentSignatureName, 'public');
                $medRecord->parentGuardianSignature = $parentGuardianSignature->storeAs('uploads', $parentGuardianSignatureName, 'public');

                /**
                 * SAVE EVERY INPUT WITH && SO THAT IF ONE ->save() RETURNS FALSE, $res WILL BE FALSE
                 */
            $res = $medRecord->save();

            //IF FALSE
        if(!$res){
            // Log error and display user-friendly message
            Log::error('Failed to register user.');
            return back()->with('fail','Failed to register. Please try again later.');
        }else{
            $user = Auth::user();
            $user->hasMedRecord = intval('1');
            $user->MR_id =  $medRecord->MR_id;
            $user->save();
            return redirect('/')->with('success', 'Medical record saved successfully');
        }
    } // END OF medFormSubmit FUNCTION

    #--- FUNCTIONS FOR PERSONNEL MED RECORD---#
    public function personnelMedicalRecordFormReg(){
        if(Auth::guard('employee')->user()->hasMedRecord == 0){
            return view('personnel.medicalRecordFormPersonnel');
        }
        else{
            return redirect()->back()->with('alreadySubmitted', 'You have already submitted your Medical Form!');
        }
    }

    public function personnelMedFormSubmit(){
     // code for validating user input and saving   
    }
}