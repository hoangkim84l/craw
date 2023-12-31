<?php

namespace App\Console\Commands\TruyenFull;

use App\Jobs\TruyenFull\TFCaptureContentJob;
use Illuminate\Console\Command;

class TfCaptureContentChapterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cfn-crawler:tf_capture_content_chapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TF Craw content - come v2';

    /**
     * Execute the console command.
     *
     * @return int|void
     */
    public function handle()
    {
        TFCaptureContentJob::dispatch();
    }
}
