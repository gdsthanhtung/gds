<?php

namespace App\Console;

use App\Jobs\SendReminderDKTTEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        'App\Console\Commands\PhongTroCommand',
        'App\Console\Commands\CongDanCommand'
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $filePath = base_path('storage/logs/phong-tro_create.log');
        // $schedule->command('phong-tro:create')
        //         ->everyFiveSeconds()
        //         ->appendOutputTo($filePath)
        //         ->runInBackground()
        //         ->withoutOverlapping(10); //The minutes must pass before the "without overlapping" lock expires. By default, the lock will expire after 24 hours

        // $filePath = base_path('storage/logs/cong-dan_check-dktt.log');
        // $schedule->command('cong-dan:check-dktt')->everyFiveSeconds()
        //         ->appendOutputTo($filePath)
        //         ->runInBackground()
        //         ->withoutOverlapping(10);

        // $filePath = base_path('storage/logs/cong-dan_check-dktt.log');
        // $schedule->call('\App\Http\Controllers\Admin\CongDanController@sendmail')
        //         ->everyFiveSeconds()
        //         ->name('cong-dan:check-dktt')
        //         ->appendOutputTo($filePath)
        //         ->withoutOverlapping(10);

        $schedule->job(new SendReminderDKTTEmail(['test' => 123]))->everyTenSeconds();
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
