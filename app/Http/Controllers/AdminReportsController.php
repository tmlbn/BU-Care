<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use DB;
use DateTime;

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
}
