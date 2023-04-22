<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Appointment;
use App\Models\UserStudent;
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
        return view('appointments');

    }

    public function checkAvailability(Request $request){
        // Extract date
        $requestDate = $request->input('date');
        // Convert to DateTime
        $date = DateTime::createFromFormat('Y-F-d', $requestDate);
        $formattedDate = $date->format('Y-m-d');
        // Retrieve the appointment entries for the date
        $appointments = Appointment::whereDate('appointmentDate', $formattedDate)->get();

        return response()->json($appointments);
    }

    public function getEntries(Request $request){
        // Retrieve the date range from the AJAX request
        $start = $request->input('start');
        $end = $request->input('end');
        
        // Query the database to retrieve the appointment entries for the future
        $entries = Appointment::where('appointmentDate', '>=', $start)->where('appointmentDate', '<=', $end)->get();
        
        // Count the appointment entries for each day
        $counts = [];
        foreach ($entries as $entry) {
            $date = $entry->date;
            if (isset($counts[$date])) {
                $counts[$date]++;
            } else {
                $counts[$date] = 1;
            }
        }
        
        // Return the data as a JSON response
        return response()->json([
            'entries' => $entries,
            'counts' => $counts,
        ]);
    }


    public function appointmentStore(Request $request) {
        $request->validate([
            'appointmentDate' => 'required',
            'appointmentTime' => 'required',
            'services' => 'required_if:othersInput,null',
            'othersInput' => 'required_if:services,null',
            'appointmentDescription' => 'required',
        ],[
            'appointmentDate.required' => 'Appointment Date is required',
            'appointmentTime.required' => 'Appointment Time is required',
            'services.required_if' => 'Services is required',
            'othersInput.required_if' => 'Please input details.',
            'appointmentDescription.required' => 'appointmentDescription is required',
        ]);
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

            $appointment->patientID = filter_var($request->patientID, FILTER_SANITIZE_STRING);
            $appointment->patient_type = filter_var($request->patientType, FILTER_SANITIZE_STRING);
            $appointment->appointmentDate = $formattedDate;
            $appointment->appointmentTime = $formattedTime;
            $appointment->appointmentDateTime = $formattedDateTime;
            $appointment->appointmentDescription = filter_var($request->appointmentDescription, FILTER_SANITIZE_STRING);
                
            $request->services == 'others'
                                ? $appointment->others = filter_var($request->input('othersInput'), FILTER_SANITIZE_STRING)
                                : $appointment->services = filter_var($request->input('services'), FILTER_SANITIZE_STRING);

            // Determine if booked_slots should be 1 or 2
            if($appointmentLatestEntry == NULL){
                // If there are no entries
                $appointment->booked_slots = 1;
            }elseif($appointmentLatestEntry->booked_slots == 1){
                $appointment->booked_slots = 2;
                $appointmentLatestEntry->booked_slots = 2;
                $resLatest = $appointmentLatestEntry->save();
                if(!$resLatest){
                    return back()->with('fail','Failed to save appointment reservation. Please try again later');
                }
            }
            else{
                return back()->with('fail','No available slots for '. $request->appointmentDate .' @ '. $request->appointmentTime);
            }

        $res = $appointment->save();

        if(!$res){
            return redirect()->route('setAppointment.show')->with('fail', 'Failed to reserve appointment. Please try again later.'); 
        }
        /**
         * NEED TO ADD E-TICKETS!!!
         */
        return redirect()->route('setAppointment.show')->with('success', 'Appointment saved'); 
        /**
         * DECREMENT WHEN DELETING AN APPOINTMENT ENTRY
         * 
         * $appointment = Appointment::find($id);
         * $appointment->booked_slots--;
         * $appointment->save();
         */
    
        
    }
    
}