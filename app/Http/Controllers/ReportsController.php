<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request): View
    {
        $appointments = MedicalPatientRecord::select('services', DB::raw('count(*) as total'))
            ->groupBy('services')
            ->orderBy('total', 'DESC')
            ->get();

            dd($appointments);

        $dataPoints = $appointments->map(function ($appointment) {
            return [
                'label' => $appointment->services,
                'y' => $appointment->total,
            ];
        });

        return view('admin.reports', compact('appointments', 'dataPoints'));
    }
}