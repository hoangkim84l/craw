<?php

namespace App\Jobs;

use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CaptureContentByUrlJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array<int, string>
     */
    public function tags(): array
    {
        return [
            'capture_content_by_url_job'
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        LinkChapter::where('status', LinkChapter::STATUS_PENDING)
            ->chunkById(1000, function ($records) {
                foreach ($records as $data) {
                    $source = file_get_contents($data->url);
                    $xml = simplexml_load_string($source);
                    $chapter = $xml->xpath("//div[@id='chapter-c']");
                    $content = '';
                    foreach ($chapter as $value) {
                        $content .= $value->__toString() . '<br/>';
                    }

                    // FIND STORY
                    $story = '';
                    if (!$story) {
                        $data->update(['status' => LinkTruyen::STATUS_NOT_FOUND]);
                        continue;
                    }

                    // INSEARCH CONTENT CHAPTER

                    // UPDATE STATUS AFTER CRAW
                    $data->update(['status' => LinkTruyen::STATUS_DONE]);
                }
            });
    }
}
