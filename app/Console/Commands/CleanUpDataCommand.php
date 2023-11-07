<?php

namespace App\Console\Commands;

use App\Models\LinkChapter;
use App\Models\LinkTruyen;
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
                if (!Str::startsWith($record->link, 'http')) {
                    $record->delete();
                }

                if (
                    Str::startsWith($record->link, 'https://dtruyen.com')
                    && $record->type != LinkTruyen::TYPE_DT
                ) {
                    $record->update(['type' => LinkTruyen::TYPE_DT]);
                }

                if (
                    Str::startsWith($record->link, 'https://truyenfull.com')
                    && $record->type != LinkTruyen::TYPE_TF
                ) {
                    $record->update(['type' => LinkTruyen::TYPE_TF]);
                }
            }
        });
    }
}
