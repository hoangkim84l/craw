<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use Goutte\Client;
use Illuminate\Http\Request;

class TruyenFullController extends Controller
{
    public function getLinkChapters(Request $request)
    {
        // link story
        $data = $request->validate(['url' => 'required']);
        $client = new Client();
        $crawler = $client->request('GET', $data['url']);
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

        return response()->json([
            'status' => 'success',
            'title' => ltrim($title, " "),
        ]);
    }

    public function storeNewLinks(Request $request)
    {
        $data = $request->validate(['url' => 'required']);
        $client = new Client();
        $crawler = $client->request('GET', $data['url']);
        $title = $crawler->filter('title')->each(function ($node) {
            return $node->text();
        })[0];

        LinkTruyen::updateOrCreate(
            [
                'name' => ltrim($title, " "),
                'link' => $data['url'],
                'status' => LinkTruyen::STATUS_PROCESS,
            ]
        );

        return response()->json([
            'status' => 'success',
            'title' => ltrim($title, " "),
        ]);
    }

    public function updateStatusStoryToDone(Request $request)
    {
        $data = $request->validate([
            'url' => 'required',
            'name' => 'required'
        ]);

        $story = LinkTruyen::where('link', $data['url'])->where('name', $data['name'])->firstOrFail();
        $story->update(['status' => LinkTruyen::STATUS_DONE]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function getContentChapter(Request $request)
    {
        // link story
        $data = $request->validate(['url' => 'required']);
        $client = new Client();
        $crawler = $client->request('GET', $data['url']);
        $title = $crawler->filter('title')->each(function ($node) {
            return $node->text();
        })[0];

        $content = $crawler->filterXPath("//div[@id='chapter-c']")->each(function ($node) {
            /** @var Crawler $node */
            return $node->text();
        });

        return response()->json([
            'status' => 'success',
            'title' => ltrim($title, " "),
            'content' => str_replace('truyenfull.com', 'cafesuanovel.com', $content),
        ]);
    }
}
