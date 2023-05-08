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

use App\Models\UserPersonnel;
use App\Models\UserStudent;
use App\Models\MedicalRecordPersonnel;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordsPersonnel_Admin;
use App\Models\MedicalRecord_Admin;

use App\Models\Appointment;


class MedicalRecordsAdminController extends Controller
{

    public function medFormSubmitAdmin(Request $request){
        $user = Auth::guard('admin')->user();
        if(!$user){
            return redirect()->route('home')->with('fail', 'Please login to continue.');
        }
    try{
        /* VALIDATE USER INPUT */
        $validator = Validator::make($request->all(), [
            'VS_bp_systolic' => 'required|integer',
            'VS_bp_diastolic' => 'required|integer',
            'VS_pulseRate' => 'required|integer',
            'VS_respirationRate' => 'required|integer',
            'VS_temp' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'VS_height' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'VS_weight' => 'required|integer',
            'VS_bmi' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
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
            'MRA_recommendations' => 'required|string',

            /* SIGNATORIES */
            'MRA_licenseNumber' => 'required',
            'MRA_PTRNumber' => 'required',
            'MRA_dateOfExamination' => 'required|date_format:Y F d',

            ], [
                'VS_temp.regex' => 'The temperature must have at most 2 decimal places',
                'VS_height.regex' => 'The height must have at most 2 decimal places',
                'VS_bmi.regex' => 'The BMI must have at most 2 decimal places',
            ]);

        /* FITNESS CERTTIFICATION REASON */
        if ($request->input('fitness') == 'notFit' || $request->input('fitness') == 'pending') {
            $request->validate([
                'fit_reason' => 'required|string',
            ]);
        }

         // Return error message if validation fails
         if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        /* IF VALIDATION IS GOOD, GET USER AND SANITIZE USER-INPUT THEN SAVE TO DATABASE */
        
        $medRecordAdmin = new MedicalRecord_Admin();
            $medRecordAdmin->MR_id = filter_var($request->input('medRecID'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->student_id = filter_var($request->input('studentID'),FILTER_SANITIZE_NUMBER_INT);
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
            $medRecordAdmin->bloodtype = filter_var($request->input('VS_bloodType'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->generalAppearance = filter_var($request->input('PE_GenAppearance'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->generalAppearanceDetails = $request->filled('PE_GenAppearanceDetails') ? filter_var($request->input('PE_GenAppearanceDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->HEENT = filter_var($request->input('PE_HEENT'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->HEENTDetails = $request->filled('PE_HEENTDetails') ? filter_var($request->input('PE_HEENTDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->chestLungs = filter_var($request->input('PE_ChestLungs'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->chestLungsDetails = $request->filled('PE_ChestLungsDetails') ? filter_var($request->input('PE_ChestLungsDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->cardio = filter_var($request->input('PE_Cardio'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->cardioDetails = $request->filled('PE_CardioDetails') ? filter_var($request->input('PE_CardioDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->abdomen = filter_var($request->input('PE_Abdomen'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->abdomenDetails = $request->filled('PE_AbdomenDetails') ? filter_var($request->input('PE_AbdomenDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->genito = filter_var($request->input('PE_Genito'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->genitoDetails = $request->filled('PE_GenitoDetails') ? filter_var($request->input('PE_GenitoDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->musculoskeletal = filter_var($request->input('PE_Musculoskeletal'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->musculoskeletalDetails = $request->filled('PE_MusculoskeletalDetails') ? filter_var($request->input('PE_MusculoskeletalDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->nervousSystem = filter_var($request->input('PE_NervousSystem'),FILTER_SANITIZE_NUMBER_INT);
            $medRecordAdmin->nervousSystemDetails = $request->filled('PE_NervousSystemDetails') ? filter_var($request->input('PE_NervousSystemDetails'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->otherSignificantFindings = $request->filled('PE_otherSignificantFindings') ? filter_var($request->input('PE_otherSignificantFindings'),FILTER_SANITIZE_STRING) : 'N/A';
            $medRecordAdmin->fitness = filter_var($request->input('fitness'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->notfitPendingReason = filter_var($request->input('fit_reason'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->impression = filter_var($request->input('MRA_recommendations'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->physician = $user->first_name.' '.$user->middle_name.' '.$user->last_name;
            $medRecordAdmin->licenseNumber = filter_var($request->input('MRA_licenseNumber'),FILTER_SANITIZE_STRING);
            $medRecordAdmin->PTRnumber = filter_var($request->input('MRA_PTRNumber'),FILTER_SANITIZE_STRING);
            
                $date = DateTime::createFromFormat('Y M d', $request->input('MRA_dateOfExamination'));
                $formatted_date = $date->format('Y-m-d');

            $medRecordAdmin->dateOfExam = $formatted_date;
        $res = $medRecordAdmin->save();

            //IF FALSE
        if(!$res){
            // Log error and display user-friendly message
            Log::error('Failed to register user.');
            return back()->with('fail','Failed to register. Please try again later.');
        }
            $patient = UserStudent::where('id', $request->input('studentID'))->first();
            $patient->hasValidatedRecord = intval('1');
            $patient->MRA_id =  $medRecordAdmin->MRA_id;
            $patient->save();
            if($request->input('fromAppointment') == 1){
                try{
                    $ticketID = $request->input('ticketID');
                    $userAppointment = Appointment::where('ticket_id', $ticketID)->first();
                    $userAppointment->status = 'SUCCESS';
                    $userAppointment->save();
                    return redirect('/')
                            ->with('MedicalRecordSuccess', 'Medical record saved successfully')
                            ->with('userTicketID', $ticketID);
                }
                catch (\Throwable $e) {
                // handle $e
                    return redirect('/')->with('fail', 'An error occured. Please Try again later.');
                }
            }
            elseif($request->input('fromAppointment') == 0){
                return redirect('/')
                        ->with('MedicalRecordSuccess', 'Medical record saved successfully')
                        ->with('patientID', $patient->id);
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
        try{
            $validator = Validator::make($request->all(), [
                'VS_bp_systolic' => 'required|integer',
                'VS_bp_diastolic' => 'required|integer',
                'VS_pulseRate' => 'required|integer',
                'VS_respirationRate' => 'required|integer',
                'VS_temp' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                ],
                'VS_o2saturation' => 'required|integer',
                'VS_height' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                ],
                'VS_weight' => 'required|integer',
                'VS_bmi' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                ],
                'VS_xrayFindings' => 'required|string',
                'VS_cbcResults' => 'required|string',
                'VS_hepaBscreening' => 'required|string',
                'VS_bloodType' => 'required|string',
                'MRA_recommendations' => 'required|string',
                'mrp_id' => 'required|string',
                'personnel_id' => 'required|string',
            ], [
                'VS_temp.regex' => 'The temperature must have at most 2 decimal places',
                'VS_height.regex' => 'The height must have at most 2 decimal places',
                'VS_bmi.regex' => 'The BMI must have at most 2 decimal places',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            // Get the admin/doctor type user
            $user = Auth::guard('admin')->user();
            // Create new instance of MedicalRecordsPersonnel_Admin and save
            $medRecordPersonnelAdmin = new MedicalRecordsPersonnel_Admin();
                $medRecordPersonnelAdmin->MRP_id = filter_var($request->input('mrp_id'),FILTER_SANITIZE_STRING);
                $medRecordPersonnelAdmin->personnel_id = filter_var($request->input('personnel_id'),FILTER_SANITIZE_STRING);
                $medRecordPersonnelAdmin->bp_systolic = filter_var($request->input('VS_bp_systolic'),FILTER_SANITIZE_NUMBER_INT);
                $medRecordPersonnelAdmin->bp_diastolic = filter_var($request->input('VS_bp_diastolic'),FILTER_SANITIZE_NUMBER_INT);
                $medRecordPersonnelAdmin->pulseRate = filter_var($request->input( 'VS_pulseRate'),FILTER_SANITIZE_NUMBER_INT);
                $medRecordPersonnelAdmin->respirationRate = filter_var($request->input('VS_respirationRate'),FILTER_SANITIZE_NUMBER_INT);
                $medRecordPersonnelAdmin->temp = filter_var($request->input('VS_temp'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $medRecordPersonnelAdmin->o2saturation = filter_var($request->input('VS_o2saturation'),FILTER_SANITIZE_NUMBER_INT);
                $medRecordPersonnelAdmin->height = filter_var($request->input('VS_height'),FILTER_SANITIZE_NUMBER_INT);
                $medRecordPersonnelAdmin->weight = filter_var($request->input('VS_weight'),FILTER_SANITIZE_NUMBER_INT);
                $medRecordPersonnelAdmin->bmi = filter_var($request->input('VS_bmi'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $medRecordPersonnelAdmin->chestXrayFinding = filter_var($request->input('VS_xrayFindings'),FILTER_SANITIZE_STRING);
                $medRecordPersonnelAdmin->CBCResults = filter_var($request->input('VS_cbcResults'),FILTER_SANITIZE_STRING);
                $medRecordPersonnelAdmin->hepatitisBscreeningResults = filter_var($request->input('VS_hepaBscreening'),FILTER_SANITIZE_STRING);
                $medRecordPersonnelAdmin->bloodtype = filter_var($request->input('VS_bloodType'),FILTER_SANITIZE_STRING);
                $medRecordPersonnelAdmin->recommendations = filter_var($request->input('MRA_recommendations'),FILTER_SANITIZE_STRING);
                $medRecordPersonnelAdmin->physician = $user->last_name.' '.$user->first_name.' '.$user->middle_name.'-'.$user->id;
            $res = $medRecordPersonnelAdmin->save();
            // Return an error if saving fails
            if(!$res){
                return redirect()->back()->with('fail', 'An error occured. Please try again later.');
            }
            // Get the personnel who owns this medical record
            $userPersonnel = UserPersonnel::where('id', $request->input('personnel_id'))->first();
            // Save foreign keys
            $userPersonnel->MRPA_id = $medRecordPersonnelAdmin->MRPA_id;
            $userPersonnel->hasValidatedRecord = intval('1');
            $res = $userPersonnel->save();
            // Return an error if saving fails
            if(!$res){
                return redirect()->back()->with('fail', 'An error occured. Please try again later.');
            }
            // Get the frst part of the personnel's medical record and save foreign keys
            $personnelMRP = MedicalRecordPersonnel::where('personnel_id', $request->input('personnel_id'))->first();

            $personnelMRP->MRPA_id = $medRecordPersonnelAdmin->MRPA_id;
            $res = $personnelMRP->save();
            // Return an error if saving fails
            if(!$res){
                return redirect()->back()->with('fail', 'An error occured. Please try again later.');
            }
            if($request->input('fromAppointment') == 1){
                try{
                    $ticketID = $request->input('ticketID');
                    $userAppointment = Appointment::where('ticket_id', $ticketID)->first();
                    $userAppointment->status = 'SUCCESS';
                    $userAppointment->save();
                    return redirect('/')
                            ->with('MedicalRecordSuccess', 'Medical record saved successfully')
                            ->with('userTicketID', $ticketID);
                }
                catch (\Throwable $e) {
                // handle $e
                    return redirect('/')->with('fail', 'An error occured. Please Try again later.');
                }
            }
            elseif($request->input('fromAppointment') == 0){
                return redirect('/')
                        ->with('MedicalRecordSuccess', 'Medical record saved successfully')
                        ->with('patientID', $userPersonnel->id);
            }
        }
        catch (Exception $ex) {
            // Handle error here
            return redirect()->back()->withErrors([
                "An error occurred: " . $ex->getMessage(),
                'If this error persists, please contact the admin from Bicol University Health Services.'
            ])->withInput();
            Log::error('Error from '.$user->id.': '. $ex->getMessage());
        }
    }

    public function releaseMedCertFromAppointment($userTicketID){
        dd($userTicketID);
        $userAppointment = Appointment::where('ticket_id', $userTicketID)->first();
        $userAppointment->released = intval('1');
        $userAppointment->save();

        $userMRA = MedicalRecord_Admin::where('student_id', $userAppointment->student_id)->first();
        $userMRA->released = intval('1');
        $userMRA->save();

        return redirect('/')->with('success', 'Appointment done and Medical Certificate Released.');
    }

    public function releaseMedCert($patientID){
        $user = UserStudent::where('id', $patientID)->first();
        $user->released = intval('1');
        $user->save();
        $userMRA = MedicalRecord_Admin::where('student_id', $patientID->id)->first();
        $userMRA->released = intval('1');
        $userMRA->save();
    }
}