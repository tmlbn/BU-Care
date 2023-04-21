<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\UserStudent;
use Session;
use Hash;
use DB;

class BUCareAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BUCareLogin Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return view('auth.login');
    }
    
    public function personnelLogin(){
        return view('personnel.login');
    }

    public function BUCareLogin(Request $request){
        $this->validateLogin($request);

        $loginType = null;

            // Determine the login type
        if($request->studentID != null){
            $loginType = 'studentID';
        } 
        elseif($request->applicantID != null){
            $loginType = 'applicantID';
        } 
        elseif($request->personnelID != null){
            $loginType = 'personnelID';
        }

        switch ($loginType) {
                // Login with Applicant ID
            case 'studentID':
                $credentials = $this->credentials($request);

                if(Auth::guard('web')->attempt($credentials, $request->has('remember'))){
                    return redirect()->route('home');
                }

                if($userNotFound = UserStudent::where('student_id_number', $request->studentID)->first()){
                    return back()->with('fail', 'Wrong password.');
                }

                return back()->with('fail', 'Student ID Number ' . $request->studentID . ' is not registered.');
                break;

                // Login with Applicant ID
            case 'applicantID':
                $applicantID = $request->applicantID;
                $user = UserStudent::where('applicant_id_number', $applicantID)->first();
                if($user){
                    if(($user->birth_month == $request->applicantBirthMonth) && ($user->birth_date == $request->applicantBirthDate) && ($user->birth_year == $request->applicantBirthYear)) {
                        Auth::login($user);
                        return redirect()->route('home');
                    }
                    else{
                        return back()->with('fail', 'No data found.');
                    }
                } 
                else{
                    return back()->with('fail', 'Applicant ID Number "' . $applicantID . '" is not registered.');
                }
                break;

                // Login with Personnel ID
            case 'personnelID':
                $credentials = [
                    'personnel_id_number' => $request->personnelID,
                    'password' => $request->password,
                ];

                if (Auth::guard('employee')->attempt($credentials, $request->has('remember'))) {
                    return redirect()->route('home');
                }

                if($userNotFound = UserStudent::where('personnel_id_number', $request->staffID)->first()){
                    return back()->with('fail', 'Wrong password.');
                }

                return back()->with('fail', 'Personnel ID Number ' . $request->staffID . ' is not registered.');
                break;

            default:
                return back()->with('fail', 'Please enter your ID number.');
                break;
        }
    }

    protected function validateLogin(Request $request){
            // Determine the login type
        if($request->studentID != null){
            $loginType = 'studentID';
        } 
        elseif($request->applicantID != null){
            $loginType = 'applicantID';
        } 
        elseif($request->personnelID != null){
            $loginType = 'personnelID';
        }

        switch ($loginType) {
                // Login with Applicant ID
            case 'studentID':
                $request->validate([
                    'studentID' => 'required',
                    'password' => 'required',
                ]);
                break;

                // Login with Applicant ID
            case 'applicantID':
                $request->validate([
                    'applicantID' => 'required',
                    'applicantBirthMonth' => 'required',
                    'applicantBirthDate' => 'required',
                    'applicantBirthYear' => 'required',
                ]);
                
                break;

                // Login with Personnel ID
            case 'personnelID':
                $request->validate([
                    'personnelID' => 'required',
                    'password' => 'required',
                ]);
                break;
    
            default:
                return back()->with('fail', 'An error occured. Please try again later.');
                break;
        }
    }

    protected function credentials(Request $request){
        if($request->personnelID){
            $credentials = $request->only('personnelID', 'password');
            // DB column 'student_id_number' = input name 'studentID'
            $credentials['personnel_id_number'] = $credentials['personnelID'];
            // Remove 'studentID' key from $credentials
            unset($credentials['personnelID']);

            return $credentials;
        }
        $credentials = $request->only('studentID', 'password');
        // DB column 'student_id_number' = input name 'studentID'
        $credentials['student_id_number'] = $credentials['studentID'];
        // Remove 'studentID' key from $credentials
        unset($credentials['studentID']);

        return $credentials;
    }    
    
    public function logout(Request $request){
        if(Auth::guard('employee')->check()){
            Auth::guard('employee')->logout();
        }
        elseif(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }
        else{
            Auth::logout();
        }

        Session::flush();
        return redirect()->route('home');
    }

    public function personnelValidatePassword(Request $request){
        $password = $request->input('password');
        $user = Auth::guard('employee')->user();
        //dd(Hash::check($password, $user->password));

        // Check if the entered password matches with the authenticated user's password
        if (Hash::check($password, $user->password)) {
           $response = ['success' => true];
           return response()->json([
            'success' => true
            ]);

          } else {
            $response = ['success' => false,
            'message' => 'Invalid password',
            ];
            die();

           return response()->json([
            'success' => false,
            'message' => 'Invalid password',
           ]);
           die();
          }
    }
}