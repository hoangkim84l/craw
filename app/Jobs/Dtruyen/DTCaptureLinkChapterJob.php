<?php

namespace App\Jobs\Dtruyen;

use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DTCaptureLinkChapterJob implements ShouldQueue, ShouldBeUnique
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
            ->where('type', LinkTruyen::TYPE_DT)
            ->chunkById(1000, function ($records) {
                foreach ($records as $data) {
                    // link story
                    $client = new Client();
                    $crawler = $client->request('GET', $data->link);
                    $title = $crawler->filter('h1.title')->each(function ($node) {
                        return $node->text();
                    })[0];

                    $title = strtolower($title);
                    $title = ucfirst($title);

                    $crawler->filterXPath("//div[@id='chapters']//a")->each(function ($node) use($title) {
                        /** @var Crawler $node */
                        LinkChapter::updateOrCreate(
                            ['link' => $node->attr('href')],
                            [
                                'name' => $node->text(),
                                'link' => $node->attr('href'),
                                'status' => LinkChapter::STATUS_PENDING,
                                'source' => ltrim($title, " "),
                                'type' => LinkTruyen::TYPE_DT,
                            ]
                        );
                    });
                }
            });
    }
}
