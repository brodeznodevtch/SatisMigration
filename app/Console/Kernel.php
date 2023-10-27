<?php

namespace App\Console;

use File;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

        $cronLog = storage_path('logs/cron.log');
        if (! File::exists($cronLog)) {
            File::put($cronLog, '');
        }

        $env = config('app.env');
        $email = env('MAIL_USERNAME');

        if ($env === 'live') {
            //Scheduling backup, specify the time when the backup will get cleaned & time when it will run.
            $schedule->command('backup:run')->dailyAt('23:30');

            //Subscription expiry email for superadmin
            $schedule->command('pos:sendSubscriptionExpiryAlert')->daily();
        }

        if ($env === 'demo' && ! empty($email)) {
            //IMPORTANT NOTE: This command will delete all business details and create dummy business, run only in demo server.
            $schedule->command('pos:dummyBusiness')
                ->cron('0 */2 * * *')
                    //->everyThirtyMinutes()
                ->emailOutputTo($email);
        }

        $schedule->command('command:update_quotes')->daily()->withoutOverlapping()->appendOutputTo($cronLog);
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
