<?php

namespace App\Console\Commands;

use App\Jobs\CaptureContentByUrlJob;
use Illuminate\Console\Command;

class CaptureContentChapterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cfn-crawler:capture_content_chapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Craw content';

    /**
     * Execute the console command.
     *
     * @return int|void
     */
    public function handle()
    {
        CaptureContentByUrlJob::dispatch();
    }
}
