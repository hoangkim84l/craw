<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use Goutte\Client;
use Illuminate\Http\Request;

class TruyenFullController extends Controller
{
    public function storeNewLinks(Request $request)
    {
        $title = '';
        $data = $request->validate(['urls' => 'required']);
        foreach ($data['urls'] as $url) {
            $client = new Client();
            $crawler = $client->request('GET', $url);
            $title = $crawler->filter('h3.title')->each(function ($node) {
                return $node->text();
            })[0];

            $title = strtolower($title);
            $title = ucfirst($title);
    
            LinkTruyen::updateOrCreate(
                ['link' => $url],
                [
                    'name' => ltrim($title, " "),
                    'link' => $url,
                    'status' => LinkTruyen::STATUS_PROCESS,
                    'type' => LinkTruyen::TYPE_TF,
                ]
            );
        }
        return response()->json([
            'status' => 'success',
            'title' => ltrim($title, " "),
        ]);
    }

    public function getLinkChapters(Request $request)
    {
        // link story
        $data = $request->validate(['urls' => 'required']);
        foreach ($data['urls'] as $url) {
            $client = new Client();
            $crawler = $client->request('GET', $url);
            $title = $crawler->filter('h3.title')->each(function ($node) {
                return $node->text();
            })[0];
    
            $title = strtolower($title);
            $title = ucfirst($title);

            $crawler->filterXPath("//ul[@class='list-chapter']//a")->each(function ($node) use($title) {
                /** @var Crawler $node */
                LinkChapter::updateOrCreate(
                    ['link' => $node->attr('href')],
                    [
                        'name' => $node->text(),
                        'link' => $node->attr('href'),
                        'status' => LinkChapter::STATUS_PENDING,
                        'source' => ltrim($title, " "),
                        'type' => LinkTruyen::TYPE_TF,
                    ]
                );
            });
        }

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
        
        $title = strtolower($title);
        $title = ucfirst($title);


        $content = $crawler->filterXPath("//div[@id='chapter-c']")->each(function ($node) {
            /** @var Crawler $node */
            return $node->text();
        });

        $content = $content[0];
        return response()->json([
            'status' => 'success',
            'title' => ltrim($title, " "),
            'content' => str_replace('truyenfull.com', 'cafesuanovel.com', $content),
        ]);
    }
}
