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

    public function BUCareLogin(Request $request){
        $this->validateLogin($request);

        if ($request->applicantID != null) {
            // Logging in with applicant ID number
            $applicantID = $request->applicantID;
            $user = UserStudent::where('applicant_id_number', $applicantID)->first();
            if ($user) {
                if (($user->birth_month == $request->applicantBirthMonth) && ($user->birth_date == $request->applicantBirthDate) && ($user->birth_year == $request->applicantBirthYear)) {
                    Auth::login($user);
                    return redirect()->route('home');
                } else {
                    return back()->with('fail', 'No data found.');
                }
            } else {
                return back()->with('fail', 'Applicant ID Number "' . $applicantID . '" is not registered.');
            }
        }

        // Logging in with student ID number
        $credentials = $this->credentials($request);

        if (Auth::guard('web')->attempt($credentials, $request->has('remember'))) {
            return redirect()->route('home');
        }

        if ($userNotFound = UserStudent::where('student_id_number', $request->studentID)->first()) {
            return back()->with('fail', 'Wrong password.');
        }

        return back()->with('fail', 'Student ID Number ' . $request->studentID . ' is not registered.');
    }

    protected function validateLogin(Request $request){
        // Login with Applicant ID Number
        if ($request->applicantID != NULL) {
            $request->validate([
                'applicantID' => 'required',
                'applicantBirthMonth' => 'required',
                'applicantBirthDate' => 'required',
                'applicantBirthYear' => 'required',
            ]);
		}else{
            $request->validate([
                'studentID' => 'required',
                'password' => 'required',
            ]);
        }
    }

    protected function credentials(Request $request){
        $credentials = $request->only('studentID', 'password');
        // DB column 'student_id_number' = input name 'studentID'
        $credentials['student_id_number'] = $credentials['studentID'];
        // Remove 'studentID' key from $credentials
        unset($credentials['studentID']);

        return $credentials;
    }    
    
    public function logout(Request $request){
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}

