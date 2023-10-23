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

class CaptureLinkChapterJob implements ShouldQueue, ShouldBeUnique
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
            'capture_link_chapter_job'
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        LinkTruyen::where('status', LinkTruyen::STATUS_PROCESS)
            ->chunkById(1000, function ($records) {
                foreach ($records as $data) {
                    $source = file_get_contents($data['url']);
                    $xml = simplexml_load_string($source);
                    $links = $xml->xpath("//ul[@class='list-chapter']//a");
                    $title = $xml->head->title;

                    foreach ($links as $link) {
                        $attribute = $link->attributes()->href;
                        $name = $link->__toString();

                        LinkChapter::updateOrCreate(
                            [
                                'name' => $name,
                                'link' => $attribute,
                                'status' => LinkChapter::STATUS_PENDING,
                                'source' => ltrim($title, " "),
                            ]
                        );
                    }
                }
            });
    }
}
