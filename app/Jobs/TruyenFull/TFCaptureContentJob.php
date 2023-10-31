<?php

namespace App\Jobs\TruyenFull;

use App\Models\Chapter;
use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use App\Models\Story;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TFCaptureContentJob implements ShouldQueue, ShouldBeUnique
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
            'truyenfull_capture_content_job'
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
            ->where('type', LinkTruyen::TYPE_TF)
            ->chunkById(1000, function ($records) {
                foreach ($records as $data) {
                    $client = new Client();
                    $crawler = $client->request('GET', $data->link);
                    $title = $crawler->filter('title')->each(function ($node) {
                        return $node->text();
                    })[0];

                    $content = $crawler->filterXPath("//div[@id='chapter-c']")->each(function ($node) {
                        /** @var Crawler $node */
                        return $node->text();
                    });

                    if ($content) {
                        // FIND STORY
                        $story = Story::where('name', 'like',  '%' . $data->source . '%')->first();
                        if (!$story) {
                            $data->update(['status' => LinkTruyen::STATUS_NOT_FOUND]);
                            Log::info('Do not have story id');
                            continue;
                        }

                        Log::info('After have story id');
                        $title = strtolower($title);
                        $title = ucfirst($title);
                        $title = ltrim($title, " ");

                        $content = $content[0];

                        // INSERT CONTENT CHAPTER
                        Chapter::updateOrCreate(
                            ['name' => $title],
                            [
                                'slug' => Str::slug($title),
                                'site_title' => 'Đọc truyện online, truyện mới cập nhật, Đọc truyện' . $data->source . ' - ' . $title . 'Tiếng Việt tại website cafesuanovel.com',
                                'meta_desc' => 'Đọc truyện online, truyện mới cập nhật, Đọc truyện' . $data->source . ' - ' . $title . 'Tiếng Việt tại website cafesuanovel.com',
                                'meta_key' => 'Đọc truyện online, truyện mới cập nhật, Đọc truyện' . $data->source . ' - ' . $title . 'Tiếng Việt tại website cafesuanovel.com',
                                'story_id' => $story->id,
                                'image_link' => '',
                                'audio_link' => '',
                                'show_img' => 0,
                                'content' => str_replace('truyenfull.com', 'cafesuanovel.com', $content),
                                'status' => 1,
                                'view' => 0,
                                'author' => 'System',
                                'ordering' => 1,
                                'created' => date("Y-m-d H:i:s"),
                            ]
                        );
                    }

                    // UPDATE STATUS AFTER CRAW
                    $data->update(['status' => LinkTruyen::STATUS_DONE]);
                }
            });
    }
}
