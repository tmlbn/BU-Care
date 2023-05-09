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
use DB;
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

    public function showAppointmentsHistory(){
        // Get the current date
        $currentDate = new DateTime();

        // Get the day of the week (0 = Sunday, 6 = Saturday)
        $dayOfWeek = $currentDate->format('w');

        // Calculate the number of days to subtract from the current date to get the first day of the week
        $numDaysToSubtract = $dayOfWeek;

        // Subtract the number of days from the current date to get the first day of the week
        $firstDayOfWeek = $currentDate->sub(new DateInterval('P'.$numDaysToSubtract.'D'));

        // Format the first day of the week in the desired format
        $firstDayOfWeekFormatted = $firstDayOfWeek->format('Y-m-d');

        $today = date('Y-m-d');
        $entries = Appointment::where('appointmentDate', $today)->orderBy('appointmentDateTime', 'asc')->paginate(15);
        $entries->appends(request()->query());

        return view('admin.appointmentsHistory', compact('entries'));
    }
}
