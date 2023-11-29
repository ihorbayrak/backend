<?php

namespace App\Console;

use App\Console\Commands\DeleteDeactivatedUsersCommand;
use App\Console\Commands\ReindexPost;
use App\Console\Commands\ReindexProfile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ReindexPost::class,
        ReindexProfile::class,
        DeleteDeactivatedUsersCommand::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('delete:deactivated-users')->daily();
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
