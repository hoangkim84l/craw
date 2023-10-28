<?php

namespace App\Console;

use App\Console\Commands\DTruyen\DTCaptureContentChapterCommand;
use App\Console\Commands\DTruyen\DTCaptureLinksChapterCommand;
use App\Console\Commands\TruyenFull\TFCaptureContentChapterCommand;
use App\Console\Commands\TruyenFull\TFCaptureLinksChapterCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // config server /usr/bin/php /home/u59xx/domains/cfn.com/public_html/cfn-crawler/artisan schedule:run
        // TruyenFull site
        $schedule->command(TFCaptureLinksChapterCommand::class)->daily();
        $schedule->command(TFCaptureContentChapterCommand::class)->daily();

        // DTruyen site
        $schedule->command(DTCaptureLinksChapterCommand::class)->daily();
        $schedule->command(DTCaptureContentChapterCommand::class)->daily();
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
