<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function index(Request $request)
    {
        $storiesNew = Story::query()->paginate();
        if ($request->ajax()) {
            // Trả về dữ liệu dạng JSON khi là yêu cầu AJAX
            return response()->json([
                'html' => view('partials.story_item', compact('storiesNew'))->render(),
                'next_page_url' => $storiesNew->nextPageUrl(),
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }
        return view('layouts.stories.list', compact('storiesNew'));
    }

    public function show(string $slug)
    {
        $story = Story::where('slug', $slug)->firstOrFail();
        $storyTags = Catalog::whereIn('id', $story->category_id)->get();
        $chapters = Chapter::where('story_id', $story->id)->orderBy('id', 'desc')->get();
        session()->push('recently_viewed', $story->id);
        return view('layouts.stories.detail', compact('story', 'storyTags', 'chapters'));
    }

    public function showChapter(string $slug)
    {
        $story = Story::where('slug', $slug)->firstOrFail();
        $storyTags = Catalog::whereIn('id', $story->category_id)->get();
        $chapters = Chapter::where('story_id', $story->id)->orderBy('id', 'desc')->get();
        return view('layouts.stories.chapters', compact('story', 'storyTags', 'chapters'));
    }

    public function search(Request $request)
    {
        $tag = $request->input('q');
        $stories = Story::where('name', 'like', "%$tag%")->get();
        return view('layouts.stories.search', compact('stories', 'tag'));
    }
}
