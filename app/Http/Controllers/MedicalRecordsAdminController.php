<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\MedicalRecord_Admin;
use App\Models\UserStudent;
use DB;
use Hash;

class MedicalRecordsAdminController extends Controller
{

    public function medFormSubmit(Request $request){

        /* VALIDATE USER INPUT */
        $validator = Validator::make($request->all(), [
        /* VITAL SIGNS */
        'VS_bp_systolic' => 'required|integer',
        'VS_bp_diastolic' => 'required|integer',
        'VS_pulseRate' => 'required|integer',
        'VS_respirationRate' => 'required|integer',
        'VS_temp' => 'required|float',
        'VS_height' => 'required|integer',
        'VS_weight' => 'required|integer',
        'VS_bmi' => 'required|float',
        'VS_xrayFindings' => 'required|string',
        'VS_cbcResults' => 'required|string',
        'VS_hepaBscreening' => 'required|string',
        'VS_bloodType' => 'required|string',

        /* PHYSICAL EXAMINATION */
        'PE_GenAppearance' => 'required|in:0,1',
        'PE_GenAppearance_Comment' => 'required_if:PE_GenAppearance,0|string',
        'PE_HEENT' => 'required|in:0,1',
        'PE_HEENT_Comment' => 'required_if:PE_HEENT,0|string',
        'PE_Chest&Lungs' => 'required|in:0,1',
        'PE_Chest&LungsComment' => 'required_if:PE_Chest&Lungs,0|string',
        'PE_Cardio' => 'required|in:0,1',
        'PE_CardioComment' => 'required_if:PE_Cardio,0|string',
        'PE_Abdomen' => 'required|in:0,1',
        'PE_AbdomenComment' => 'required_if:PE_Abdomen,0|string',
        'PE_Genito' => 'required|in:0,1',
        'PE_GenitoComment' => 'required_if:PE_Genito,0|string',
        'PE_Musculoskeletal' => 'required|in:0,1',
        'PE_MusculoskeletalComment' => 'required_if:PE_Musculoskeletal,0|string',
        'PE_NervousSystem' => 'required|in:0,1',
        'PE_NervousSystemComment' => 'required_if:PE_NervousSystem,0|string',
        'PE_otherSignificantFindings' => 'nullable|string',

        /* FITNESS CERTTIFICATION */
        'fitness' => 'required|in:0,1,2',
        'fit_reason' => 'required_if:fitness,0,2|string',

        /* IMPRESSION */
        'MRP_impression' => 'required|string',

        /* SIGNATORIES */
        'MR_DateofExam' => 'required|date_format:Y-m-d',

        ],[ #-- CATCH SPECIFIC ERRRORS --#
        'required' => 'The :attribute field is required.',
        'PE_GenAppearance_Comment.required_if' => 'Please provide details',
        'PE_HEENT_Comment.required_if' => 'Please provide details',
        'PE_Chest&LungsComment.required_if' => 'Please provide details',
        'PE_CardioComment.required_if' => 'Please provide details', 
        'PE_AbdomenComment.required_if' => 'Please provide details',
        'PE_GenitoComment.required_if' => 'Please provide details',
        'PE_MusculoskeletalComment.required_if' => 'Please provide details',
        'PE_NervousSystemComment.required_if' => 'Please provide details', 
        ]);

         // Return error message if validation fails
         if ($validator->fails()) {
            #dd($validator);
            return back()->withErrors($validator)->withInput();
         }

        /* IF VALIDATION IS GOOD, GET USER AND SANITIZE USER-INPUT THEN SAVE TO DATABASE */
        $user = Auth::user();
        
        $medRecordAdmin = new MedicalRecord_Admin();
            $medRecordAdmin->diastolic = filter_var($request->input('VS_bp_systolic'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->systolic = filter_var($request->input('VS_bp_diastolic'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->pulseRate = filter_var($request->input( 'VS_pulseRate'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->respirationRate = filter_var($request->input('VS_respirationRate'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->temp = filter_var($request->input('VS_temp'),FILTER_SANITIZE_NUMBER_FLOAT);
            $medRecordAdmin->height = filter_var($request->input(),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->weight = filter_var($request->input(),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->BMI = filter_var($request->input(),FILTER_SANITIZE_NUMBER_NUMBER_FLOAT);
            $medRecordAdmin->xrayfindings = filter_var($request->input(),FILTER_SANITIZE_STRING);
            $medRecordAdmin->cbcresults = filter_var($request->input(),FILTER_SANITIZE_STRING);
            $medRecordAdmin->hepaB = filter_var($request->input(),FILTER_SANITIZE_STRING);
            $medRecordAdmin->bloodType = filter_var($request->input(),FILTER_SANITIZE_STRING);
           
    }

}
