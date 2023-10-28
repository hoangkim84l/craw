<?php

namespace App\Console\Commands\TruyenFull;

use App\Jobs\TruyenFull\TFCaptureContentByUrlJob;
use Illuminate\Console\Command;

class TFCaptureContentChapterCommand extends Command
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
        TFCaptureContentByUrlJob::dispatch();
    }
}
