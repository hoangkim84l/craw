<?php

namespace App\Jobs;

use App\Models\Chapter;
use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use App\Models\Story;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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
                    $title = $xml->head->title;
                    $chapter = $xml->xpath("//div[@id='chapter-c']");
                    $content = '';
                    foreach ($chapter as $value) {
                        $content .= $value->__toString() . '<br/>';
                    }

                    // FIND STORY
                    $story = Story::where('name', 'like',  '%' . $data->source . '%')->first();
                    if (!$story) {
                        $data->update(['status' => LinkTruyen::STATUS_NOT_FOUND]);
                        continue;
                    }

                    // INSERT CONTENT CHAPTER
                    Chapter::updateOrCreate(
                        ['name' => ltrim($title, " ")],
                        [
                            'name' => ltrim($title, " "),
                            'slug' => Str::slug($title),
                            'site_title' => 'Đọc truyện' . $data->source . ' - ' . ltrim($title, " ") . 'Tiếng Việt tại website cafesuanovel.com',
                            'meta_desc' => 'Đọc truyện' . $data->source . ' - ' . ltrim($title, " ") . 'Tiếng Việt tại website cafesuanovel.com',
                            'meta_key' => 'Đọc truyện' . $data->source . ' - ' . ltrim($title, " ") . 'Tiếng Việt tại website cafesuanovel.com',
                            'story_id' => $story->id,
                            'image_link' => '',
                            'audio_link' => '',
                            'show_img' => 0,
                            'content' => $content,
                            'status' => 1 ,
                            'view' => 0,
                            'author' => 'System',
                            'ordering' => 1,
                            'created' => date("Y-m-d H:i:s"),
                        ]
                    );

                    // UPDATE STATUS AFTER CRAW
                    $data->update(['status' => LinkTruyen::STATUS_DONE]);
                }
            });
    }
}
