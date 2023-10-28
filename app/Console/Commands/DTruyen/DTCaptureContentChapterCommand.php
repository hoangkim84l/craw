<?php

namespace App\Console\Commands\DTruyen;

use App\Jobs\Dtruyen\DTCaptureContentByUrlJob;
use Illuminate\Console\Command;

class DTCaptureContentChapterCommand extends Command
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
        DTCaptureContentByUrlJob::dispatch();
    }
}
