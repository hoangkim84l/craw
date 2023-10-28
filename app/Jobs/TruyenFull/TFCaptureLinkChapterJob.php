<?php

namespace App\Jobs\TruyenFull;

use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TFCaptureLinkChapterJob implements ShouldQueue, ShouldBeUnique
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
            ->where('type', LinkTruyen::TYPE_TF)
            ->chunkById(1000, function ($records) {
                foreach ($records as $data) {
                    // link story
                    $client = new Client();
                    $crawler = $client->request('GET', $data->link);
                    $title = $crawler->filter('title')->each(function ($node) {
                        return $node->text();
                    })[0];

                    $crawler->filterXPath("//ul[@class='list-chapter']//a")->each(function ($node) use($title) {
                        /** @var Crawler $node */
                        LinkChapter::updateOrCreate(
                            [
                                'name' => $node->text(),
                                'link' => $node->attr('href'),
                                'status' => LinkChapter::STATUS_PENDING,
                                'source' => ltrim($title, " "),
                            ]
                        );
                    });
                }
            });
    }
}
