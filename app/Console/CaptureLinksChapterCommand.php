<?php

namespace App\Console\Commands;

use App\Jobs\CaptureLinkChapterJob;
use Illuminate\Console\Command;

class CaptureLinksChapterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cfn-crawler:capture_link_chapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Craw link chapter';

    /**
     * Execute the console command.
     *
     * @return int|void
     */
    public function handle()
    {
        CaptureLinkChapterJob::dispatch();
    }
}
