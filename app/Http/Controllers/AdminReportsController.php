<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\UserPersonnel;
use App\Models\UserStudent;
use App\Models\MedicalRecordPersonnel;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordsPersonnel_Admin;
use App\Models\MedicalRecord_Admin;
use App\Models\MedicalPatientRecord;
use DB;
use Carbon\Carbon;
use DateTime;
use DateInterval;

class AdminReportsController extends Controller
{
    public function reports()
   {
        /* FETCH THE TOP MOST AVAILED SERVICES */
        // Students
        $studentAppointments = Appointment::select('services', DB::raw('count(*) as total'))
                ->whereNotNull('student_id')
                ->groupBy('services')
                ->orderBy('total', 'DESC')
                ->get();

        $studentDataPoints = $studentAppointments->map(function ($appointment) {
            return [
            'label' => $appointment->services,
            'y' => $appointment->total,
            ];
        });

        // Students
        $personnelAppointments = Appointment::select('services', DB::raw('count(*) as total'))
                ->whereNotNull('personnel_id')
                ->groupBy('services')
                ->orderBy('total', 'DESC')
                ->get();

        $personnelDataPoints = $personnelAppointments->map(function ($appointment) {
            return [
            'label' => $appointment->services,
            'y' => $appointment->total,
            ];
        });

        /* FETCH THE APPOINTMENTS BY STATUS */
        $data = Appointment::select(
            DB::raw('DATE_FORMAT(appointmentTime, "%Y-%m") as month'),
            'status',
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('month', 'status')
        ->get()
        ->toArray();


    /* FETCH THE TOP PATIENTS WITH APPOINTMENT RESERVATION */
        $topPatients = Appointment::select(DB::raw("CONCAT(users_students.last_name, ', ', users_students.first_name, ' ', users_students.middle_name) AS full_name"), DB::raw('count(*) as total'))
            ->join('users_students', 'users_students.id', '=', 'appointments.student_id')
            ->groupBy('full_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();


        $topPatientsLabels = $topPatients->pluck('full_name')->toArray();
        $topPatientsData = $topPatients->pluck('total')->toArray();

    /* FETCH APPOINTMENTS AND GROUP IT BY MONTH */
        // Get all appointments for a given year
        $year = date('Y');
        $appointmentsByYear = Appointment::whereYear('appointmentDateTime', $year)->get();

        // Group appointments by month
        $appointmentsByMonth = $appointmentsByYear->groupBy(function ($appointment) {
            return DateTime::createFromFormat('Y-m-d H:i:s', $appointment->appointmentDateTime)->format('M');
        });

        // Initialize arrays for chart data
        $months = [];
        $count = [];

        // Loop through all 12 months and get the count for each month
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('M', mktime(0, 0, 0, $i, 1));
            $count[] = isset($appointmentsByMonth[$monthName]) ? count($appointmentsByMonth[$monthName]) : 0;
            $months[] = $monthName;
        }
        return view('admin.reports', 
            compact('studentAppointments', 'studentDataPoints', 
                    'personnelAppointments', 'personnelDataPoints', 
                    'data',
                    'topPatients', 'topPatientsLabels', 'topPatientsData', 
                    'months', 'count'
        ));
    }

    public function showAppointmentsHistory(Request $request)
    {
        /** IN CASE EXPIRATION CODE SKIPPED, EXPIRE APPOINTMENTS THAT SHOULD BE EXPIRED NOW */
        $expiredAppointments = Appointment::where('appointmentDateTime', '<=', Carbon::now()->subHours(2))
            ->where('status', '!=', 'CANCELLED or NO-SHOW') // exclude previously expired appointments
            ->where('status', '!=', 'COMPLETED')
            ->get();

        // Update status of expired appointments
        foreach ($expiredAppointments as $appointment) {
            $appointment->status = 'CANCELLED or NO-SHOW';
            $appointment->save();
        }

        $filterBy = $request->input('timely', 'today');
        $search = $request->input('search');
        $now = Carbon::now();
        $startDate = $now->startOfDay();
        $endDate = $now->endOfDay();
        $status = $request->status;
        $month = $request->input('month');

        switch ($filterBy) {
            case 'past':
                $startDate = $now->copy()->startOfDay()->subDay();
                $endDate = $now->copy()->endOfDay()->subDay();
                break;
            case 'today':
                $todayStart = $now->copy()->startOfDay();
                $todayEnd = $now->copy()->endOfDay();
                $startDate = $todayStart;
                $endDate = $todayEnd;
                break;
            case 'thisWeek':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'thisMonth':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            default:
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                break;
        }
        $appointments = null;
        $query = Appointment::query();

        if($filterBy === 'past'){
            $appointments = Appointment::where('appointmentDate', '<', $endDate)
                ->orderByDesc('appointmentDateTime')
                ->paginate(15);
        } 
        elseif ($month) {
            $startDate = $now->copy()->startOfMonth()->month($month);
            $endDate = $now->copy()->endOfMonth()->month($month);
            $appointments = $query->whereBetween('appointmentDateTime', [$startDate, $endDate])
            ->orderByDesc('appointmentDateTime')
            ->paginate(15);
        }
        else{
            $appointments = $query->whereBetween('appointmentDateTime', [$startDate, $endDate])
            ->orderByDesc('appointmentDateTime')
            ->paginate(15);
        }
        
        if ($status === 'RELEASED') {
            $query->where('released', 1);
            $appointments = $query->orderByDesc('appointmentDateTime')->paginate(15);
        } elseif ($status === 'COMPLETED'){
            $query->where('status', 'COMPLETED')
                  ->where('released', 0);
            $appointments = $query->orderByDesc('appointmentDateTime')->paginate(15);
        } elseif ($status === 'CANCELLED or NO-SHOW'){
            $query->where('status', 'CANCELLED or NO-SHOW');
            $appointments = $query->orderByDesc('appointmentDateTime')->paginate(15);
        } elseif ($status === 'SCHEDULED'){
            $query->where('status', 'SCHEDULED');
            $appointments = $query->orderByDesc('appointmentDateTime')->paginate(15);
        } 

        if (!empty($search)) {
            $query->where('ticket_id', 'like', '%' . $search . '%')
                ->orderByDesc('appointmentDateTime');
        }
        
        $appointments->appends(request()->query());
        
        return view('admin.appointmentsHistory', [
            'entries' => $appointments,
            'filterBy' => $filterBy,
            'search' => $search,
            'status' => $status,
            'byMonth' => $month
        ]);
        
    }

    public function showMedicalPatientRecordList(Request $request){

        $filterBy = $request->input('timely', 'thisWeek');
        $search = $request->input('search');
        $now = Carbon::now();
        $startDate = $now->startOfDay();
        $endDate = $now->endOfDay();
        $status = $request->status;
        $query = Appointment::query();
        $month = $request->input('month');

        switch ($filterBy) {
            case 'today':
                $todayStart = $now->copy()->startOfDay();
                $todayEnd = $now->copy()->endOfDay();
                $startDate = $todayStart;
                $endDate = $todayEnd;
                break;
            case 'thisWeek':
                $startDate = $now->startOfWeek();
                $endDate = $now->endOfWeek();
                break;
            case 'thisMonth':
                $startDate = $now->startOfMonth();
                $endDate = $now->endOfMonth();
                break;
            default:
                $startDate = $now->startOfDay();
                $endDate = $now->endOfDay();
                break;
        }

        if(!empty($search)){
            $MPRStudentsList = MedicalPatientRecord::join('users_students', 'users_students.id', '=', 'medicalpatientrecords.student_id')
                    ->where(function ($query) use ($search) {
                        $query->where('users_students.last_name', 'like', "%{$search}%")
                            ->orWhere('users_students.first_name', 'like', "%{$search}%")
                            ->orWhere('users_students.middle_name', 'like', "%{$search}%")
                            ->orWhere(DB::raw("CONCAT(users_students.last_name, ' ', users_students.first_name, ' ', users_students.middle_name)"), 'like', "%{$search}%")
                            ->orWhere('users_students.student_id_number', 'like', "%{$search}%")
                            ->orWhere('users_students.applicant_id_number', 'like', "%{$search}%");
                    })
                    ->orderByDesc('date_of_exam')
                    ->paginate(15);

            $MPRStudentsList->appends(request()->query());

            $MPRPersonnelList = MedicalPatientRecord::join('users_personnel', 'users_personnel.id', '=', 'medicalpatientrecords.student_id')
                    ->where(function ($query) use ($search) {
                        $query->where('users_personnel.last_name', 'like', "%{$search}%")
                            ->orWhere('users_personnel.first_name', 'like', "%{$search}%")
                            ->orWhere('users_personnel.middle_name', 'like', "%{$search}%")
                            ->orWhere(DB::raw("CONCAT(users_personnel.last_name, ' ', users_personnel.first_name, ' ', users_personnel.middle_name)"), 'like', "%{$search}%")
                            ->orWhere('users_personnel.personnel_id_number', 'like', "%{$search}%");
                    })
                    ->orderByDesc('date_of_exam')
                    ->paginate(15);

            $MPRPersonnelList->appends(request()->query());
        
            return view('admin.medicalPatientRecordList', [
                'medicalPatientRecordsStudents' => $MPRStudentsList,
                'medicalPatientRecordsPersonnel' => $MPRPersonnelList,
                'filterBy' => $filterBy,
                'search' => $search,
                'status' => $status,
            ]);
        }
        elseif ($month) {
            $startDate = $now->copy()->startOfMonth()->month($month);
            $endDate = $now->copy()->endOfMonth()->month($month);
            $medicalPatientRecordsStudents = MedicalPatientRecord::whereNotNull('student_id')
                ->whereBetween('date_of_exam', [$startDate, $endDate])
                ->orderByDesc('date_of_exam')
                ->paginate(15);
            $medicalPatientRecordsPersonnel = MedicalPatientRecord::whereNotNull('personnel_id')
                ->whereBetween('date_of_exam', [$startDate, $endDate])
                ->orderByDesc('date_of_exam')
                ->paginate(15);
            
            $medicalPatientRecordsStudents->appends(request()->query());
            $medicalPatientRecordsPersonnel->appends(request()->query());

            return view('admin.medicalPatientRecordList')
            ->with([
                'medicalPatientRecordsStudents' => $medicalPatientRecordsStudents,
                'medicalPatientRecordsPersonnel' => $medicalPatientRecordsPersonnel,
                'filterBy' => $filterBy,
                'search' => $search,
                'byMonth' => $month
            ]);
        }
        else{
            $today = Carbon::now()->startOfDay();

            if ($filterBy === 'thisMonth') {
                $startOfWeek = Carbon::now()->startOfMonth()->startOfDay();
                $endOfWeek = Carbon::now()->endOfMonth()->endOfDay();
                $medicalPatientRecordsStudents = MedicalPatientRecord::whereNotNull('student_id')
                    ->whereBetween('date_of_exam', [$startOfWeek, $endOfWeek])
                    ->orderByDesc('date_of_exam')
                    ->paginate(15);
                $medicalPatientRecordsPersonnel = MedicalPatientRecord::whereNotNull('personnel_id')
                    ->whereBetween('date_of_exam', [$startOfWeek, $endOfWeek])
                    ->orderByDesc('date_of_exam')
                    ->paginate(15);
            }
            elseif ($filterBy === 'today'){
                $medicalPatientRecordsStudents = MedicalPatientRecord::whereNotNull('student_id')
                    ->whereDate('date_of_exam', $today)
                    ->orderByDesc('date_of_exam')
                    ->paginate(15);
                $medicalPatientRecordsPersonnel = MedicalPatientRecord::whereNotNull('personnel_id')
                    ->whereDate('date_of_exam', $today)
                    ->orderByDesc('date_of_exam')
                    ->paginate(15);
            }
            else{
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();

                $medicalPatientRecordsStudents = MedicalPatientRecord::whereNotNull('student_id')
                    ->whereBetween('date_of_exam', [$startOfWeek, $endOfWeek])
                    ->paginate(15);
                $medicalPatientRecordsPersonnel = MedicalPatientRecord::whereNotNull('personnel_id')
                    ->whereBetween('date_of_exam', [$startOfWeek, $endOfWeek])
                    ->paginate(15);
            }

            $medicalPatientRecordsStudents->appends(request()->query());
            $medicalPatientRecordsPersonnel->appends(request()->query());

            return view('admin.medicalPatientRecordList')
            ->with([
                'medicalPatientRecordsStudents' => $medicalPatientRecordsStudents,
                'medicalPatientRecordsPersonnel' => $medicalPatientRecordsPersonnel,
                'filterBy' => $filterBy,
                'search' => $search,
                'byMonth' => $month
            ]);
        }
    }
}
