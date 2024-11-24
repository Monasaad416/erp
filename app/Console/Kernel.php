<?php

namespace App\Console;

use App\Jobs\AddAssetDepreciation;
use App\Jobs\AddNewFinancialYear;
use App\Jobs\AddSalaries;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:add-salary')->monthlyOn(25, '00:00');
        $schedule->job(new AddSalaries)->everyMinute();
        $schedule->job(new AddNewFinancialYear)->yearlyOn(1, 1,'00:00');
        $schedule->job(new AddAssetDepreciation)->yearlyOn(11, 17, '00:00');

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
