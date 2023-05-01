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
use App\Models\UserPersonnel;
use App\Models\MedicalRecord;
use DateTime;
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
        # REGISTER STAFF
        if($request->staffID){ 
            $request->validate([
                'staffID' => 'required|unique:users_clinic,staff_id_number',
                'staff_email' => 'required|unique:users_clinic,email',
                'staff_password' => 'required|min:8',
                'staff_lastName' => 'required|string',
                'staff_firstName' => 'required|string',
                'staff_middleName' => 'nullable',
                'staff_dateOfBirth' => 'required'
            ],[
                'staffID.unique' => 'This Staff ID Number is already registered!',
                'staff_email.unique' => 'This Email Address is already registered!',
                'staff_password.min' => 'Password should be greater than 8 characters long.',
                'required' => 'This field is required.'
            ]);
                // sanitize email address
                $email = filter_var($request->staff_email, FILTER_SANITIZE_EMAIL);
                // validate email address
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // invalid email address
                    return back()->with('fail','Invalid Email Address.');
                }
                $dateString = $request->staff_dateOfBirth;
                $date = DateTime::createFromFormat('Y-m-d', $dateString);
                if ($date !== false) {
                    $sanitizedDate = $date->format('Y-m-d');
                } else {
                    return back()->with('fail','Invalid date format.');
                }
                // Sanitize inputs to prevent SQL injection and cross-site scripting (XSS) attacks then save user to database
                try {
                    $user = new UserClinic();
                        $user->staff_id_number = filter_var($request->staffID, FILTER_SANITIZE_STRING);
                        $user->email = $email;
                        $user->password = bcrypt(filter_var($request->staff_password, FILTER_SANITIZE_STRING));
                        $user->last_name = filter_var($request->staff_lastName, FILTER_SANITIZE_STRING);
                        $user->first_name = filter_var($request->staff_firstName, FILTER_SANITIZE_STRING);
                        $user->middle_name = filter_var($request->staff_middleName, FILTER_SANITIZE_STRING);
                        $user->date_of_birth = $sanitizedDate;
                    $res = $user->save();
                    
                    if($res){
                        return back()->with('success','Successfully Registered.');
                    } else {
                        // Log error and display message
                        Log::error('Failed to register user.');
                        return back()->with('fail','Failed to register. Please try again later.');
                    }
                    
                } catch (\Exception $e) {
                    // Log error and display message
                    Log::error('Failed to register user: ' . $e->getMessage());
                    return back()->with('fail','Failed to register. Please try again later');
                }
        }
        elseif($request->applicantID){
            # REGISTER STUDENT
        $request->validate([
            'applicantID' => 'required|unique:users_students,applicant_id_number',
            'studentID' => 'nullable|unique:users_students,student_id_number',
            'student_email' => 'nullable|unique:users_students,email',
            'student_password' => 'nullable|min:8',
            'student_lastName' => 'required|string',
            'student_firstName' => 'required|string',
            'student_middleName' => 'nullable',
            'applicantBirthMonth' => 'required',
            'applicantBirthDate' => 'required',
            'applicantBirthYear' => 'required',

        ],[
            'applicantID.unique' => 'This Applicant ID Number is already registered!',
            'studentID.unique' => 'This Student ID Number is already registered!',
            'student_email.unique' => 'This Email Address is already registered!',
            'student_password.min' => 'Password should be greater than 8 characters long.',
            'required' => 'This field is required.'
        ]);
            // sanitize email address
            $email = filter_var($request->student_email, FILTER_SANITIZE_EMAIL);
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
                    $user->password = bcrypt(filter_var($request->student_password, FILTER_SANITIZE_STRING));
                    $user->last_name = filter_var($request->student_lastName, FILTER_SANITIZE_STRING);
                    $user->first_name = filter_var($request->student_firstName, FILTER_SANITIZE_STRING);
                    $user->middle_name = filter_var($request->student_middleName, FILTER_SANITIZE_STRING);
                    $user->birth_month = filter_var($request->applicantBirthMonth, FILTER_SANITIZE_STRING);
                    $user->birth_date = filter_var($request->applicantBirthDate, FILTER_SANITIZE_NUMBER_INT);
                    $user->birth_year = filter_var($request->applicantBirthYear, FILTER_SANITIZE_NUMBER_INT);
                $res = $user->save();
            
                if($res){
                    return back()->with('success','Successfully Registered.');
                } else {
                    // Log error and display message
                    Log::error('Failed to register user.');
                    return back()->with('fail','Failed to register. Please try again later.');
                }
                
            } catch (\Exception $e) {
                // Log error and display message
                Log::error('Failed to register user: ' . $e->getMessage());
                return back()->with('fail','Failed to register. Please try again later.');
            }
        }
        elseif($request->personnelID){
            # REGISTER PERSONNEL
        $request->validate([
            'personnelID' => 'required|unique:users_personnel,personnel_id_number',
            'personnel_email' => 'nullable|unique:users_personnel,email',
            'personnel_password' => 'nullable|min:8',
            'personnel_lastName' => 'required|string',
            'personnel_firstName' => 'required|string',
            'personnel_middleName' => 'nullable',
            'personnel_dateOfBirth' => 'required',

        ],[
            'applicantID.unique' => 'This Personnel ID Number is already registered!',
            'personnel_email.unique' => 'This Email Address is already registered!',
            'personnel_password.min' => 'Password should be greater than 8 characters long.',
            'required' => 'This field is required.'
        ]);
            // sanitize email address
            $email = filter_var($request->personnel_email, FILTER_SANITIZE_EMAIL);
            // validate email address
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // invalid email address
                return back()->with('fail','Invalid Email Address.');
            }
            $dateString = $request->personnel_dateOfBirth;
            $date = DateTime::createFromFormat('Y-m-d', $dateString);
            if ($date !== false) {
                $sanitizedDate = $date->format('Y-m-d');
            } else {
                return back()->with('fail','Invalid date format.');
            }
            // Sanitize inputs to prevent SQL injection and cross-site scripting (XSS) attacks then save user to database
            try {
                $user = new UserPersonnel();
                    $user->personnel_id_number = filter_var($request->personnelID, FILTER_SANITIZE_STRING);
                    $user->email = $email;
                    $user->password = bcrypt(filter_var($request->personnel_password, FILTER_SANITIZE_STRING));
                    $user->last_name = filter_var($request->personnel_lastName, FILTER_SANITIZE_STRING);
                    $user->first_name = filter_var($request->personnel_firstName, FILTER_SANITIZE_STRING);
                    $user->middle_name = filter_var($request->personnel_middleName, FILTER_SANITIZE_STRING);
                    $user->date_of_birth = $sanitizedDate;
                $res = $user->save();
            
                if($res){
                    return back()->with('success','Successfully Registered.');
                } else {
                    // Log error and display message
                    Log::error('Failed to register user.');
                    return back()->with('fail','Failed to register. Please try again later.');
                }
                
            } catch (\Exception $e) {
                // Log error and display message
                Log::error('Failed to register user: ' . $e->getMessage());
                return back()->with('fail','Failed to register. Please try again later.');
            }
        }
    }
    
    public function checkPassword(Request $request){
        $password = $request->input('password');
        $user = Auth::guard('admin')->user();
            
            if (!Hash::check($password, $user->password)) {
                $response = 'Invalid Password';
                 return response()->json(['error' => $response]);
            }

            $response = 'Password match';
             return response()->json(['success' => $response]);
    }
}
