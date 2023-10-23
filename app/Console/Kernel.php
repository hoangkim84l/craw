<?php

namespace App\Console;

use App\Console\Commands\CaptureContentChapterCommand;
use App\Console\Commands\CaptureLinksChapterCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(CaptureLinksChapterCommand::class)->daily();
        /**
         * chay command vào 5 giờ chiều mỗi 2 ngày
         *  crontab -e && cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
         * */
        $schedule->command(CaptureContentChapterCommand::class)->cron('0 17 */2 * *');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
