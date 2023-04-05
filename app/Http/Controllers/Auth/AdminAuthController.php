<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\UserClinic;
use App\Models\UserStudent;
use App\Models\MedicalRecord;
use Session;
use Hash;
use DB;

class AdminAuthController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except('logout','register','manualRegister');
      }

    public function showAdminLogin(){
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request){
        $this->validateLogin($request);

        $credentials = $this->credentials($request);

        if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {
            return redirect()->route('admin.home');
        }

        if ($userNotFound = UserClinic::where('staff_id_number', $request->staffID)->first()) {
            return back()->with('fail', 'Wrong password.');
        }

        return back()->with('fail', 'Staff ID Number ' . $request->staffID . ' is not registered.');
    }

    protected function validateLogin(Request $request){
            $request->validate([
                'staffID' => 'required',
                'password' => 'required',
            ]);
    }

    protected function credentials(Request $request){
        $credentials = $request->only('staffID', 'password');
        // DB column 'staff_id_number' = input name 'staffID'
        $credentials['staff_id_number'] = $credentials['staffID'];
        // Remove 'staffID' key from $credentials
        unset($credentials['staffID']);

        return $credentials;
    }    
    
    public function logout(Request $request){
        Session::flush();
        Auth::guard('admin')->logout();
        
        return redirect()->route('admin.login.show');
    }

    public function register(){
        return view('admin.auth.register');
    }

    public function manualRegister(Request $request){
        if($request->staffID){ # REGISTER STAFF
            $request->validate([
                'staffID' => 'required|unique:users_clinic,staff_id_number',
                'email' => 'required|unique:users_clinic,email',
                'password' => 'required|min:5',
                'lastName' => 'required|string',
                'firstName' => 'required|string',
                'middleName' => 'nullable',
            ],[
                'staffID.unique' => 'This Staff ID Number is already registered!',
                'email.unique' => 'This Email Address is already registered!',
                'password.min' => 'Password should be greater than 5 characters long.',
                'required' => 'This field is required.'
            ]);
                // sanitize email address
                $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
                // validate email address
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // invalid email address
                    return back()->with('fail','Invalid Email Address.');
                }
                // Sanitize inputs to prevent SQL injection and cross-site scripting (XSS) attacks then save user to database
                try {
                    $user = new UserClinic();
                        $user->staff_id_number = filter_var($request->staffID, FILTER_SANITIZE_STRING);
                        $user->email = $email;
                        $user->password = bcrypt(filter_var($request->password, FILTER_SANITIZE_STRING));
                        $user->last_name = filter_var($request->lastName, FILTER_SANITIZE_STRING);
                        $user->first_name = filter_var($request->firstName, FILTER_SANITIZE_STRING);
                        $user->middle_name = filter_var($request->middleName, FILTER_SANITIZE_STRING);
                    $res = $user->save();
                    
                    if($res){
                        return back()->with('success','Successfully Registered.');
                    } else {
                        // Log error and display user-friendly message
                        Log::error('Failed to register user.');
                        return back()->with('fail','Failed to register. Please try again later.');
                    }
                    
                } catch (\Exception $e) {
                    // Log error and display user-friendly message
                    Log::error('Failed to register user: ' . $e->getMessage());
                    return back()->with('fail','Failed to register. Please try again later');
                }
        }elseif($request->applicantID){
            # REGISTER STUDENT
        $request->validate([
            'applicantID' => 'required|unique:users_students,applicant_id_number',
            'studentID' => 'nullable|unique:users_students,student_id_number',
            'email' => 'nullable|unique:users_students,email',
            'password' => 'nullable|min:8',
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'middleName' => 'nullable',
            'applicantBirthMonth' => 'required',
            'applicantBirthDate' => 'required',
            'applicantBirthYear' => 'required',

        ],[
            'applicantID.unique' => 'This Applicant ID Number is already registered!',
            'studentID.unique' => 'This Student ID Number is already registered!',
            'email.unique' => 'This Email Address is already registered!',
            'password.min' => 'Password should be greater than 8 characters long.',
            'required' => 'This field is required.'
        ]);
            // sanitize email address
            $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
            // validate email address
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // invalid email address
                return back()->with('fail','Invalid Email Address.');
            }
            // Sanitize inputs to prevent SQL injection and cross-site scripting (XSS) attacks then save user to database
            try {
                $user = new UserStudent();
                    $user->applicant_id_number = filter_var($request->applicantID, FILTER_SANITIZE_STRING);
                    $user->student_id_number = filter_var($request->studentID, FILTER_SANITIZE_STRING);
                    $user->email = $email;
                    $user->password = bcrypt(filter_var($request->password, FILTER_SANITIZE_STRING));
                    $user->last_name = filter_var($request->lastName, FILTER_SANITIZE_STRING);
                    $user->first_name = filter_var($request->firstName, FILTER_SANITIZE_STRING);
                    $user->middle_name = filter_var($request->middleName, FILTER_SANITIZE_STRING);
                    $user->birth_month = filter_var($request->applicantBirthMonth, FILTER_SANITIZE_STRING);
                    $user->birth_date = filter_var($request->applicantBirthDate, FILTER_SANITIZE_NUMBER_INT);
                    $user->birth_year = filter_var($request->applicantBirthYear, FILTER_SANITIZE_NUMBER_INT);
                $res = $user->save();
            
                if($res){
                    return back()->with('success','Successfully Registered.');
                } else {
                    // Log error and display user-friendly message
                    Log::error('Failed to register user.');
                    return back()->with('fail','Failed to register. Please try again later.');
                }
                
            } catch (\Exception $e) {
                // Log error and display user-friendly message
                Log::error('Failed to register user: ' . $e->getMessage());
                return back()->with('fail','Failed to register. Please try again later.');
            }
        }
    }
}
