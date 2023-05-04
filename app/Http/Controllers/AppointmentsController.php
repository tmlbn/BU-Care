<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Appointment;
use App\Models\UserStudent;
use App\Models\UserPersonnel;
use App\Models\UserClinic;
use App\Models\MedicalRecord;
use App\Models\FamilyHistory;
use App\Models\ImmunizationHistory;
use App\Models\PastIllness;
use App\Models\PersonalSocialHistory;
use App\Models\PresentIllness;
use Carbon\Carbon;
use Session;
use DateTime;
use Hash;
use DB;

class AppointmentsController extends Controller
{
    public function setAppointment(){
        $dateToday = date('Y-m-d');

        $entries = Appointment::where('appointmentDate', '>=', $dateToday)->get(); //CHANGED = TO >=
        if(!$entries){
            // if the entries is empty, don't pass any data 
            return response()->json([]);
        }
        if(Auth::user()){
            $user = Auth::user();
            $user_type = 'student_id';
        }
        elseif(Auth::guard('employee')->user()){
            $user = Auth::guard('employee')->user();
            $user_type = 'personnel_id';
        }
        else{
            return redirect()->route('home')->with('fail','Please login to continue.'); // If somehow authentication fails e.g. session ended or interrupted.
        }

        if(!$user->hasMedRecord){
            return redirect()->route('home')->with('fail','Please submit your medical record form before setting an appointment.'); // If user haven't submitted their medical record.
        }
        $userID = $user->id;
        // Get current user's appointment entries
        $myAppointments = Appointment::where('status', '=', 'Active')
                                    ->where(function($query) use ($userID, $user_type){
                                        $query->where($user_type, '=', $userID);
                                    })
                                    ->where('appointmentDate', '>=', $dateToday)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('appointments')->with([
            'entries' => $entries,
            'myAppointments' => $myAppointments
        ]);
    }

    public function checkAvailability(Request $request){
        // Extract date
        $requestDate = $request->input('date');
        // Convert to DateTime
        $date = DateTime::createFromFormat('Y-F-d', $requestDate);
        $formattedDate = $date->format('Y-m-d');
        // Retrieve the appointment entries for the date
        $appointments = Appointment::whereDate('appointmentDate', $formattedDate)
                                    ->orderByDesc('created_at')
                                    ->get();

        return response()->json($appointments);
    }
/*
    public function getEntries(Request $request){
        // Retrieve the date range from the AJAX request
        $date = $request->input('date');
        
        // Query the database to retrieve the appointment entries for the future
        $entries = Appointment::where('appointmentDate', '>=', $date)->get(); //CHANGED = TO >=
        if(!$entries){
            // if the entries is empty, don't pass any data 
            return response()->json([]);
        }
        
        // Count the appointment entries for each day
        $counts = [];
        foreach ($entries as $entry) {
            $entryDate = $entry->appointmentDate;
            if (isset($counts[$entryDate])) {
                $counts[$entryDate]++;
            } else {
                $counts[$entryDate] = 1;
            }
        }
        
        // Return the data as a JSON response
        return response()->json([
            'entries' => $entries,
            //'counts' => $counts,
        ]);
    }
*/

    public function appointmentStore(Request $request) {
        //dd($request);
        if(Auth::guard('employee')->user() || Auth::user()->student_id_number){
            $request->validate([
                'appointmentDate' => 'required',
                'appointmentTime' => 'required',
           //   'services' => 'required_if:othersInput,null',
                'servicesAvail' => 'required',
                'othersInput' => 'required_if:servicesAvail,others',
                'appointmentDescription' => 'required',
                'passwordInput' => 'required'
            ],[
                'appointmentDate.required' => 'Appointment Date is required',
                'appointmentTime.required' => 'Appointment Time is required',
           //   'services.required_if' => 'Services is required',
                'servicesAvail.required' => 'Services is required',
                'othersInput.required_if' => 'Please input details.',
                'appointmentDescription.required' => 'appointmentDescription is required',
                'passwordInput.required' => 'Please input your password.'
            ]);
            // Confirm if password is a match
            $password = $request->input('passwordInput');
            $user = Auth::guard('employee')->user() ?: Auth::user();
            if (!Hash::check($password, $user->password)) {
                return back()->with('fail','Invalid password.');
            }
        }
        else{
            $request->validate([
                'appointmentDate' => 'required',
                'appointmentTime' => 'required',
            //  'services' => 'required_if:othersInput,null',
                'servicesAvail' => 'required',
                'othersInput' => 'required_if:servicesAvail,others',
            //  'othersInput' => 'required_if:services,null',
                'appointmentDescription' => 'required',
                'applicantIDinput' => 'required',
                'applicantBirthYear' => 'required',
                'applicantBirthMonth' => 'required',
                'applicantBirthDate' => 'required',
            ],[
                'appointmentDate.required' => 'Appointment Date is required',
                'appointmentTime.required' => 'Appointment Time is required',
            //  'services.required_if' => 'Services is required',
                'servicesAvail.required' => 'required',
                'othersInput.required_if' => 'required_if:servicesAvail,null',
            //  'othersInput.required_if' => 'Please input details.',
                'appointmentDescription.required' => 'appointmentDescription is required',
                'applicantIDinput.required' => 'Please input your Applicant ID Number.',
                'applicantBirthYear.required' => 'Please input your birth year.',
                'applicantBirthMonth.required' => 'Please input your birth month.',
                'applicantBirthDate.required' => 'Please input your birth date.',
            ]);
            // Confirm if birthday details are match
            $applicantID = $request->input('applicantIDinput');
            $birthYear = $request->input('applicantBirthYear');
            $birthMonth = $request->input('applicantBirthMonth');
            $birthDate = $request->input('applicantBirthDate');
            $user = Auth::user();

            if(!($user->applicant_id_number == $applicantID && 
            $user->birth_year == $birthYear && 
            $user->birth_month == $birthMonth && 
            $user->birth_date == $birthDate)){
                return back()->with('fail','Invalid authentication.');
            }
        }

        // Format Date
            $dateString = $request->appointmentDate;
            $date = DateTime::createFromFormat('Y-F-d', $dateString);
            $formattedDate = $date->format('Y-m-d');
            // Format Time
            $timeString = $request->appointmentTime;
            $formattedTime = DateTime::createFromFormat('g:i A', $timeString)->format('H:i:s');

            // Merge as Datetime
            $formattedDateTime = $formattedDate . ' ' . $formattedTime;

        // Count number of entries with Datetime
            $appointmentEntries = Appointment::whereDate('appointmentDateTime', $formattedDateTime)->count();
            if($appointmentEntries == 2){
                return back()->with('fail','No available slots for '. $request->appointmentDate .' @ '. $request->appointmentTime);
            }
            // Get latest entry with the user-input Datetime
            $appointmentLatestEntry = Appointment::where('appointmentDateTime', $formattedDateTime)
                                ->latest()
                                ->first();

        /* If things are good, start saving the new entry */
        $appointment = new appointment();

            if(Auth::guard('employee')->check()){
                $appointment->personnel_id = filter_var($request->patientID, FILTER_SANITIZE_STRING);
            }
            elseif(Auth::check()){
                $appointment->student_id = filter_var($request->patientID, FILTER_SANITIZE_STRING);
            }
            else{
                return back()->with('fail', 'Please login to continue.'); // If somehow authentication fails e.g. session ended or interrupted.
            }

            $appointment->patient_type = filter_var($request->patientType, FILTER_SANITIZE_STRING);
            $appointment->appointmentDate = $formattedDate;
            $appointment->appointmentTime = $formattedTime;
            $appointment->appointmentDateTime = $formattedDateTime;
            $appointment->appointmentDescription = filter_var($request->appointmentDescription, FILTER_SANITIZE_STRING);
                
            $request->servicesAvail == 'others'
                                ? $appointment->others = filter_var($request->input('othersInput'), FILTER_SANITIZE_STRING)
                                : $appointment->services = filter_var($request->input('servicesAvail'), FILTER_SANITIZE_STRING);

            // Determine if booked_slots should be 1 or 2
            if($appointmentLatestEntry == NULL){
                // If there are no entries
                $appointment->booked_slots = 1;
                $temp = 1;
            }elseif($appointmentLatestEntry->booked_slots == 1){
                $appointment->booked_slots = 2;
                $appointmentLatestEntry->booked_slots = 2;
                $temp = 2;
                $resLatest = $appointmentLatestEntry->save();
                if(!$resLatest){
                    return back()->with('fail','Failed to save appointment reservation. Please try again later');
                }
            }
            else{
                return back()->with('fail','No available slots for '. $request->appointmentDate .' @ '. $request->appointmentTime);
            }
            
            $tDate = $date->format('Ymd');
            $time = DateTime::createFromFormat('g:i A', $timeString)->format('Gi');
            $tTime = sprintf("%04d", $time);
            
            $tPID = filter_var($request->patientID, FILTER_SANITIZE_STRING);
 
        $res = $appointment->save();

        if(!$res){
            return redirect()->route('setAppointment.show')->with('fail', 'Failed to reserve appointment. Please try again later.'); 
        }
        $tAPID = $appointment->id;
        // E-Ticket
        $e_ticket = $tDate . '-' . $tTime . '-'. $tAPID . $tPID . $temp;
        $appointment->ticket_id = $e_ticket;
        $res = $appointment->save();

        if(!$res){
            return redirect()->route('setAppointment.show')->with('fail', 'Failed to reserve appointment. Please try again later.'); 
        }
        
        return redirect()->route('setAppointment.show')->with('success', 'Your Appointment Ticket# is: ' . $e_ticket);
    }
    public function getAppointmentToUpdate(Request $request){
        $ticketID = $request->input('ticketID');
        
        // Confirm password is a match
        if(Auth::guard('employee')->check()){
            $user = Auth::guard('employee')->user();
            $type = 'personnel_id';
        }
        elseif(Auth::check()){
            $user = Auth::user();
            $type = 'student_id';
        }
        else{
            return redirect()->route('setAppointment.show')->with('fail', 'An error occured. Please try again later.');
        }
        
        $appointment = Appointment::where('ticket_id', $ticketID)
                    ->where($type, $user->id)
                    ->first();

        if (!$appointment) {
            return response()->json(['fail' => 'Appointment not found. Please enter the correct Ticket Number.']);
        }

        $appointmentsForTheDay = Appointment::where('appointmentDate', $appointment->appointmentDate)
                                ->get();
        
        return response()->json([
            'appointment' => $appointment,
            'appointmentsForTheDay' => $appointmentsForTheDay
        ]);
    }

    public function updateAppointment(Request $request, $ticketID){
        if(Auth::guard('employee')->check()){
            $user = Auth::guard('employee')->user();
            $type = 'personnel_id';
        }
        elseif(Auth::check()){
            $user = Auth::user();
            $type = 'student_id';
        }
        else{
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }
        if($request->input('password')){
            $password = $request->input('password');
            if (!Hash::check($password, $user->password)) {
                $response = 'Invalid Password';
                return response()->json(['error' => $response]);
            }
        }
        else{
            $request->validate([
                'appointmentDate' => 'required',
                'appointmentTime' => 'required',
            //  'services' => 'required_if:othersInput,null',
                'servicesAvail' => 'required',
                'othersInput' => 'required_if:servicesAvail,others',
            //  'othersInput' => 'required_if:services,null',
                'appointmentDescription' => 'required',
                'applicantIDinput' => 'required',
                'applicantBirthYear' => 'required',
                'applicantBirthMonth' => 'required',
                'applicantBirthDate' => 'required',
            ],[
                'appointmentDate.required' => 'Appointment Date is required',
                'appointmentTime.required' => 'Appointment Time is required',
            //  'services.required_if' => 'Services is required',
                'servicesAvail' => 'required',
                'othersInput' => 'required_if:servicesAvail,others',
            //  'othersInput.required_if' => 'Please input details.',
                'appointmentDescription.required' => 'appointmentDescription is required',
                'applicantIDinput.required' => 'Please input your Applicant ID Number.',
                'applicantBirthYear.required' => 'Please input your birth year.',
                'applicantBirthMonth.required' => 'Please input your birth month.',
                'applicantBirthDate.required' => 'Please input your birth date.',
            ]);
            // Confirm if birthday details are match
            $applicantID = $request->input('applicantIDinput');
            $birthYear = $request->input('applicantBirthYear');
            $birthMonth = $request->input('applicantBirthMonth');
            $birthDate = $request->input('applicantBirthDate');
            $user = Auth::user();
            if(!($user->applicant_id_number == $applicantID && 
            $user->birth_year == $birthYear && 
            $user->birth_month == $birthMonth && 
            $user->birth_date == $birthDate)){
                return back()->with('fail','Invalid authentication.');
            }
        }
        
        $appointment = Appointment::where('ticket_id', $ticketID)
                    ->where($type, $user->id)
                    ->first();

        // Format Date
        $dateString = $request->appointmentDate;
        $date = DateTime::createFromFormat('Y-F-d', $dateString);
        $formattedDate = $date->format('Y-m-d');
        // Format Time
        $timeString = $request->appointmentTime;
        $formattedTime = DateTime::createFromFormat('g:i A', $timeString)->format('H:i:s');

        // Merge as Datetime
        $formattedDateTime = $formattedDate . ' ' . $formattedTime;

        $appointment->appointmentDate = $formattedDate;
        $appointment->appointmentTime = $formattedTime;
        $appointment->appointmentDatetime = $formattedDateTime;
        $request->servicesAvail == 'others'
                ? $appointment->others = filter_var($request->input('othersInput'), FILTER_SANITIZE_STRING) 
                : $appointment->services = filter_var($request->input('servicesAvail'), FILTER_SANITIZE_STRING);
        $appointment->appointmentDescription = filter_var($request->input('appointmentDescription'), FILTER_SANITIZE_STRING);

        $res = $appointment->save();
        if(!$res){
            return response()->json(['error' => 'An error occurred. Please try again later.'], 500);
        }

        return response()->json([
            'success' => 'Appointment with Ticket#'.$ticketID.' updated successfully.',
            'ticketID' => $ticketID
        ], 200);
    }

    public function appointmentDelete(Request $request){
        $user = Auth::guard('employee')->user() ?: Auth::user();
        if($request->passwordInputDelete){
            $request->validate([
                'ticketInputDelete' => 'required',
                'passwordInputDelete' => 'required',
            ],[
                'ticketInputDelete.required' => 'Please input the ticket number.',
                'passwordInputDelete.required' => 'Please input your password.'
            ]);
            // Confirm password is a match
            $password = $request->input('passwordInputDelete');
            if (!Hash::check($password, $user->password)) {
                return back()->with('fail','Invalid password.');
            }
        }
        else{
            $request->validate([
                'ticketInputDelete' => 'required',
                'applicantIDinputDelete' => 'required',
                'applicantBirthYearDelete' => 'required',
                'applicantBirthMonthDelete' => 'required',
                'applicantBirthDateDelete' => 'required',
            ],[
                'ticketInputDelete.required' => 'Please input the ticket number.',
                'applicantIDinputDelete.required' => 'Please input your Applicant ID number.',
                'applicantBirthYearDelete.required' => 'Please input your Birth Year.',
                'applicantBirthMonthDelete.required' => 'Please input your Birth Month.',
                'applicantBirthDateDelete.required' => 'Please input your Birth Date.',
            ]);
            $applicantID = $request->input('applicantIDinputDelete');
            $birthYear = $request->input('applicantBirthYearDelete');
            $birthMonth = $request->input('applicantBirthMonthDelete');
            $birthDate = $request->input('applicantBirthDateDelete');

            if(!($user->applicant_id_number == $applicantID && 
            $user->birth_year == $birthYear && 
            $user->birth_month == $birthMonth && 
            $user->birth_date == $birthDate)){
                return back()->with('fail','Invalid authentication.');
            }
        }

        // Delete appointment entry
        $ticketID = $request->input('ticketInputDelete');
        $appointment = Appointment::where('ticket_id', $ticketID)->first();
        if (!$appointment) {
            return back()->with('fail','Appointment not found. Please enter the correct Ticket Number.');
        }

        /**
         * DECREMENT WHEN DELETING AN APPOINTMENT ENTRY
         */
        $appointmentDateTimeToDelete = $appointment->appointmentDateTime;
        $appointmentToDecrementSlot = Appointment::where('appointmentDateTime', $appointmentDateTimeToDelete)->first();

        if($appointment->id ===  $appointmentToDecrementSlot->id){
            $appointmentToDecrementSlot = Appointment::where('appointmentDateTime', $appointmentDateTimeToDelete)->skip(1)->take(1)->first();
        }
        if($appointmentToDecrementSlot){
            $appointmentToDecrementSlot->booked_slots = 1;
            $appointmentToDecrementSlot->save();
        }

        $appointment->delete();
        return back()->with('success','Appointment deleted successfully.');
    }


    public function showAdminAppointments()
    {
            $dateToday = date('Y-m-d');
        
            $entries = Appointment::where('appointmentDate', '>=', $dateToday)->get(); //CHANGED = TO >=
            if(!$entries){
                // if the entries is empty, don't pass any data 
                return response()->json([]);
            }
            // Count the appointment entries for each day
            $counts = [];
            foreach ($entries as $entry) {
                $entryDate = $entry->appointmentDate;
                if (isset($counts[$entryDate])) {
                    $counts[$entryDate]++;
                } else {
                    $counts[$entryDate] = 1;
                }
            }
        
            return view('admin.ClinicSideAppointments')->with([
                'entries' => $entries
            ]);
    }

    public function adminAppointmentsStore(Request $request) {
        
        $request->validate([
        
            'patientID' => 'required',
            'patientType' => 'required',
            'appointmentDate' => 'required',
            'appointmentTime' => 'required',
        //  'services' => 'required_if:othersInput,null',
            'servicesAvail' => 'required',
            'othersInput' => 'required_if:servicesAvail,null',
        //  'othersInput' => 'required_if:services,null',
            'appointmentDescription' => 'required',
        ]);

    $adminAppointment = new Appointment();
     
        // Knowing the patient type and what their ID number
        if($request->patientType == 'OldStudent'){
            try{
                $patient = UserStudent::where('student_id_number', $request->input('patientID'))->firstOrFail();
                    $adminAppointment->student_id = $patient->id;
                    $adminAppointment->patient_type = $patient->user_type;
            }
            catch(ModelNotFoundException $e){
                return redirect()->back()->with('fail', 'Student ID Number '.$request->input('patientID').' not found.');
            }
        }
        elseif($request->patientType == 'NewStudent') {
            try{
                $patient = UserStudent::where('applicant_id_number', $request->input('patientID'))->firstOrFail();
                    $adminAppointment->student_id = $patient->id;
                    $adminAppointment->patient_type = $patient->user_type;
            }
            catch(ModelNotFoundException $e){
                return redirect()->back()->with('fail', 'Applicant ID Number '.$request->input('patientID').' not found.');
            }     
        }
        elseif($request->patientType == 'Personnel') {
            try{
                $patient = UserPersonnel::where('personnel_id_number', $request->input('patientID'))->firstOrFail();
                    $adminAppointment->personnel_id = $patient->id;
                    $adminAppointment->patient_type = $patient->user_type;
            }
            catch(ModelNotFoundException $e){
                return redirect()->back()->with('fail', 'Personnel ID Number '.$request->input('patientID').' not found.');
            }
        }
        else{
            return redirect()->back()->with('fail', 'Personnel ID Number '.$request->input('patientID').' not found.');
        }

       // Format Date
       $dateString = $request->appointmentDate;
       $date = DateTime::createFromFormat('Y-F-d', $dateString);
       $formattedDate = $date->format('Y-m-d');
       // Format Time
       $timeString = $request->appointmentTime;
       $formattedTime = DateTime::createFromFormat('g:i A', $timeString)->format('H:i:s');

       // Merge as Datetime
       $formattedDateTime = $formattedDate . ' ' . $formattedTime;

   // Count number of entries with Datetime
       $appointmentEntries = Appointment::whereDate('appointmentDateTime', $formattedDateTime)->count();
       if($appointmentEntries == 2){
           return back()->with('fail','No available slots for '. $request->appointmentDate .' @ '. $request->appointmentTime);
       }
       // Get latest entry with the user-input Datetime
       $appointmentLatestEntry = Appointment::where('appointmentDateTime', $formattedDateTime)
                           ->latest()
                           ->first();

       $adminAppointment->patient_type = filter_var($request->patientType, FILTER_SANITIZE_STRING);
       $adminAppointment->appointmentDate = $formattedDate;
       $adminAppointment->appointmentTime = $formattedTime;
       $adminAppointment->appointmentDateTime = $formattedDateTime;
       $adminAppointment->appointmentDescription = filter_var($request->appointmentDescription, FILTER_SANITIZE_STRING);
           
       $request->servicesAvail == 'others'
                           ? $adminAppointment->others = filter_var($request->input('othersInput'), FILTER_SANITIZE_STRING)
                           : $adminAppointment->services = filter_var($request->input('servicesAvail'), FILTER_SANITIZE_STRING);

       // Determine if booked_slots should be 1 or 2
       if($appointmentLatestEntry == NULL){
           // If there are no entries
           $adminAppointment->booked_slots = 1;
           $temp = 1;
       }elseif($appointmentLatestEntry->booked_slots == 1){
           $adminAppointment->booked_slots = 2;
           $appointmentLatestEntry->booked_slots = 2;
           $temp = 2;
           $resLatest = $appointmentLatestEntry->save();
           if(!$resLatest){
               return back()->with('fail','Failed to save appointment reservation. Please try again later');
           }
       }
       else{
           return back()->with('fail','No available slots for '. $request->appointmentDate .' @ '. $request->appointmentTime);
       }
       
       $tDate = $date->format('Ymd');
       $time = DateTime::createFromFormat('g:i A', $timeString)->format('Gi');
       $tTime = sprintf("%04d", $time);
       
       $tPID = $patient->id;

        $res = $adminAppointment->save();

        if(!$res){
            return redirect()->route('admin.appointments.show')->with('fail', 'Failed to reserve appointment. Please try again later.'); 
        }
        $tAPID = $adminAppointment->id;
        // E-Ticket
        $e_ticket = $tDate . '-' . $tTime . '-'. $tAPID . $tPID . $temp;
        $adminAppointment->ticket_id = $e_ticket;
        $res = $adminAppointment->save();

        if(!$res){
            return redirect()->route('admin.appointments.show')->with('fail', 'Failed to reserve appointment. Please try again later.'); 
        }
        
        return redirect()->route('admin.appointments.show')->with('success', 'Your Appointment Ticket# is: ' . $e_ticket);
    }

    public function getUserOfAppointment(Request $request){
        $patientType = $request->input('patientType');
        $patientID = $request->input('patientID');

        if($patientType == 'PATIENT-STUDENT') {
            $user = UserStudent::where('id', $patientID)->first();
            if($user->hasMedRecord){
                return response()->json(['user' => $user]);
            }
            else{
                // handle error case when $patientType is neither 'PATIENT-STUDENT' nor 'PATIENT-PERSONNEL'
                return redirect()->route('admin.appointments.show')->with('fail', 'Invalid patient type. Please contact a BU-Care admin.');
            }
        }
        elseif($patientType == 'PATIENT-PERSONNEL'){
            $user = UserPersonnel::where('id', $patientID)->first();
            if($user->hasMedRecord){
                return response()->json(['user' => $user]);
            }
            else{
                // handle error case when $patientType is neither 'PATIENT-STUDENT' nor 'PATIENT-PERSONNEL'
                return redirect()->route('admin.appointments.show')->with('fail', 'Invalid patient type. Please contact a BU-Care admin.');
            }
        }
    }

    public function adminShowMedRecordFromAppointment($patientType, $patientID){
        dd($patientType, $patientID);
        if($patientType == 'PATIENT-STUDENT') {
            $user = UserStudent::where('id', $patientID)->first();
            if($user->hasMedRecord){
                return view('ClinicSideMedicalRecordForm')
                ->with('patient', $user)
                ->with('fromAppointment', 1);
            }
        }
        elseif($patientType == 'PATIENT-PERSONNEL'){
            $user = UserPersonnel::where('id', $patientID)->first();
            if($user->hasMedRecord){
                return view('ClinicSideMedicalRecordFormPersonnel')
                ->with('patient', $user)
                ->with('fromAppointment', 1);
            }
        }
        else{
            // handle error case when $patientType is neither 'PATIENT-STUDENT' nor 'PATIENT-PERSONNEL'
            return redirect()->route('admin.appointments.show')->with('fail', 'Invalid patient type. Please contact a BU-Care admin.');
        }
    }
}   