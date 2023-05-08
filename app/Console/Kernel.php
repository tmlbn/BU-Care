<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            // Get all appointments that are scheduled to start 1 hour ago
            $expiredAppointments = Appointment::where('appointmentTime', '<=', Carbon::now()->subHour())
                ->where('status', '!=', 'EXPIRED') // exclude previously expired appointments
                ->where('status', '!=', 'SUCCESS')
                ->get();
    
            // Update status of expired appointments
            foreach ($expiredAppointments as $appointment) {
                $appointment->status = 'Expired';
                $appointment->save();
            }
        })->everyOneHour();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
