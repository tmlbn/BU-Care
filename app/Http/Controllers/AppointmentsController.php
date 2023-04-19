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
use App\Models\appointment;
use Session;
use Hash;
use DB;

class AppointmentsController extends Controller
{
    public function setAppointment(){
      return view('appointments');

    }

    public function appointmentStore(Request $request) {
        $request->validate([
            'appointmentDate' => 'required',
            'appointmentTime' => 'required',
            'services' => 'required_if:OthersInput,null',
            'OthersInput' => 'required_if:services,null',
            'appointmentDescription' => 'required',
        ],[
            'appointmentDate.required' => 'Appointment Date is required',
            'appointmentTime.required' => 'Appointment Time is required',
            'services.required_if' => 'services is required',
            'OthersInput.required_if' => 'Other is required ',
            'appointmentDescription.required' => 'appointmentDescription is required',
        ]);
    
        $appointment = new appointment();
    
        $appointment->appointmentDate = filter_var($request->appointmentDate, FILTER_SANITIZE_STRING);
        $appointment->appointmentTime = filter_var($request->appointmentTime, FILTER_SANITIZE_STRING);
        $appointment->appointmentDescription = filter_var($request->appointmentDescription, FILTER_SANITIZE_STRING);
                
        if ($request->services == 'Others') {
            $appointment->Others = filter_var($request->input('OthersInput'), FILTER_SANITIZE_STRING);
        } else {
            $appointment->services = filter_var($request->services, FILTER_SANITIZE_STRING);
        }
                        
        $appointment->save();
    
        return redirect()->route('setAppointment.show')->with('success', 'Appointment Saved'); 
    }
    
}