<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LinkChapter;
use App\Models\LinkTruyen;
use Illuminate\Http\Request;

class TruyenFullController extends Controller
{
    public function getLinkChapters(Request $request)
    {
        // link story
        $data = $request->validate(['url' => 'required']);
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

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function storeNewLinks(Request $request)
    {
        $data = $request->validate(['url' => 'required']);
        $source = file_get_contents($data['url']);
        $xml = simplexml_load_string($source);
        $title = $xml->head->title;

        LinkTruyen::updateOrCreate(
            [
                'name' => $title,
                'link' => $data['url'],
                'status' => LinkTruyen::STATUS_PROCESS,
            ]
        );

        return response()->json([
            'status' => 'success',
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
}
