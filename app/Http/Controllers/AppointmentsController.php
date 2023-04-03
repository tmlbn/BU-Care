<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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

class AppointmentsController extends Controller
{
    public function setAppointment(){
        return view('appointments');
    }
}
