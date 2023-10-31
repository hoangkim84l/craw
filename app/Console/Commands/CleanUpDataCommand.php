<?php

namespace App\Console\Commands;

use App\Jobs\TruyenFull\TFCaptureContentJob;
use App\Models\LinkChapter;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CleanUpDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cfn-crawler:cleam_up_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup data';

    /**
     * Execute the console command.
     *
     * @return int|void
     */
    public function handle()
    {
        LinkChapter::chunkById(1000, function ($records) {
            foreach ($records as $record) {
                if (!Str::startsWith($record->url, 'http')) {
                    $record->delete();
                }
            }
        });
    }
}
