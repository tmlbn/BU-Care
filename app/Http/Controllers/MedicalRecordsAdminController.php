<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\MedicalRecordsPersonnel_Admin;
use App\Models\MedicalRecord_Admin;
use App\Models\UserStudent;
use DB;
use Hash;

class MedicalRecordsAdminController extends Controller
{

    public function medFormSubmitAdmin(Request $request){
        dd($request->all());
    try{
        /* VALIDATE USER INPUT */
        $validator = Validator::make($request->all(), [
        /* VITAL SIGNS */
        'VS_bp_systolic' => 'required|integer',
        'VS_bp_diastolic' => 'required|integer',
        'VS_pulseRate' => 'required|integer',
        'VS_respirationRate' => 'required|integer',
        'VS_temp' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'VS_height' => 'required|integer',
        'VS_weight' => 'required|integer',
        'VS_bmi' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'VS_xrayFindings' => 'required|string',
        'VS_cbcResults' => 'required|string',
        'VS_hepaBscreening' => 'required|string',
        'VS_bloodType' => 'required|string',

        /* PHYSICAL EXAMINATION */
        'PE_GenAppearance' => 'required|string',
        'PE_HEENT' => 'required|string',
        'PE_ChestLungs' => 'required|string',
        'PE_Cardio' => 'required|string',
        'PE_Abdomen' => 'required|string',
        'PE_Genito' => 'required|string',
        'PE_Musculoskeletal' => 'required|string',
        'PE_NervousSystem' => 'required|string',
        'PE_otherSignificantFindings' => 'nullable|string',

        /* FITNESS CERTTIFICATION */
        'fitness' => 'required',

        /* IMPRESSION */
        'MRP_impression' => 'required|string',

        /* SIGNATORIES */
        'MRA_LicenseNumber' => 'required',
        'MRA_PTRNumber' => 'required',
        'MRA_DateofExam' => 'required|date_format:Y-m-d',

        ],[ #-- CATCH SPECIFIC ERRRORS --#
        'required' => 'The :attribute field is required.'
        ]);

        /* FITNESS CERTTIFICATION REASON */
        if ($request->input('fitness') == 'notFit' || $request->input('fitness') == 'pending') {
            $request->validate([
                'fit_reason' => 'required|string',
            ]);
        }
        

         // Return error message if validation fails
         if ($validator->fails()) {
            #dd($validator);
            return back()->withErrors($validator)->withInput();
         }

        /* IF VALIDATION IS GOOD, GET USER AND SANITIZE USER-INPUT THEN SAVE TO DATABASE */
        
        $medRecordAdmin = new MedicalRecord_Admin();
            $medRecordAdmin->MR_id = filter_var($request->input('studentID'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->student_id = filter_var($request->input('medRecID'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->bp_systolic = filter_var($request->input('VS_bp_systolic'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->bp_diastolic = filter_var($request->input('VS_bp_diastolic'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->pulseRate = filter_var($request->input( 'VS_pulseRate'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->respirationRate = filter_var($request->input('VS_respirationRate'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->temp = filter_var($request->input('VS_temp'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $medRecordAdmin->height = filter_var($request->input('VS_height'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->weight = filter_var($request->input('VS_weight'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->bmi = filter_var($request->input('VS_bmi'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $medRecordAdmin->xrayFindings = filter_var($request->input('VS_xrayFindings'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->cbcResults = filter_var($request->input('VS_cbcResults'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->hepaBscreening = filter_var($request->input('VS_hepaBscreening'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->bloodType = filter_var($request->input('VS_bloodType'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_genAppearance = filter_var($request->input('PE_GenAppearance'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_HEENT = filter_var($request->input('PE_HEENT'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_chestLungs = filter_var($request->input('PE_ChestLungs'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_cardio = filter_var($request->input('PE_Cardio'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_abdomen = filter_var($request->input('PE_Abdomen'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_genito = filter_var($request->input('PE_Genito'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_musculoskeletal = filter_var($request->input('PE_Musculoskeletal'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_nervousSystem = filter_var($request->input('PE_NervousSystem'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PE_otherSignificantFindings = filter_var($request->input('PE_otherSignificantFindings'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->fitness = filter_var($request->input('fitness'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->notfitPendingReason = filter_var($request->input('fit_reason'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->MRA_impression = filter_var($request->input('MRP_impression'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->MRA_licenseNumber = filter_var($request->input('MRA_LicenseNumber'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->MRA_PTRnumber = filter_var($request->input('MRA_PTRNumber'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->MRA_dateOfExam = filter_var($request->input('MRA_DateofExam'),FILTER_SANITIZE_STRING);
        $res = $medRecordAdmin->save();

            //IF FALSE
        if(!$res){
            // Log error and display user-friendly message
            Log::error('Failed to register user.');
            return back()->with('fail','Failed to register. Please try again later.');
        }else{
            $patient = UserStudent::where('studentID', $studentID)->first();
            $patient->hasValidatedRecord = intval('1');
            $patient->MRA_id =  $medRecordAdmin->MRA_id;
            $patient->save();
            return redirect('/')->with('success', 'Medical record saved successfully');
        }
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

    #NEW FUNCTION STARTS HERE
    public function medicalRecordsPersonnelAdmin(Request $request){
        $validator = Validator::make($request->all(), [
            'VS_bp_systolic' => 'required|integer',
            'VS_bp_diastolic' => 'required|integer',
            'VS_pulseRate' => 'required|integer',
            'VS_respirationRate' => 'required|integer',
            'VS_temp' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'VS_o2saturaion' => 'required|integer',
            'VS_height' => 'required|integer',
            'VS_weight' => 'required|integer',
            'VS_bmi' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'VS_bloodType' => 'required|integer',
        ]);

        $user = Auth::guard('employee')->user();
        try{
            $medRecordPersonnelAdmin = new MedicalRecordsPersonnel_Admin();

            $medRecordPersonnelAdmin->bp_systolic = filter_var($request->input('VS_bp_systolic'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnelAdmin->bp_diastolic = filter_var($request->input('VS_bp_diastolic'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnelAdmin->pulseRate = filter_var($request->input( 'VS_pulseRate'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnelAdmin->respirationRate = filter_var($request->input('VS_respirationRate'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnelAdmin->temp = filter_var($request->input('VS_temp'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $medRecordPersonnelAdmin->o2saturation = filter_var($request->input('VS_o2saturation'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnelAdmin->height = filter_var($request->input('VS_height'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnelAdmin->weight = filter_var($request->input('VS_weight'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordPersonnelAdmin->bmi = filter_var($request->input('VS_bmi'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
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
}
