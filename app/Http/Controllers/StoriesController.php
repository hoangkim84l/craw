<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Http\Request;

class StoriesController extends Controller
{
    public function index()
    {
        $storiesNew = Story::orderBy('created_at', 'desc')->paginate();
        return view('layouts.stories.list', compact('storiesNew'));
    }

    public function show(string $slug)
    {
        $story = Story::where('slug', $slug)->firstOrFail();
        $storyTags = Catalog::whereIn('id', $story->category_id)->get();
        $chapters = Chapter::where('story_id', $story->id)->orderBy('created_at', 'desc')->get();
        session()->push('recently_viewed', $story->id);
        return view('layouts.stories.detail', compact('story', 'storyTags', 'chapters'));
    }

    public function search(Request $request)
    {
        $tag = $request->input('q');
        $stories = Story::where('name', 'like', "%$tag%")->get();
        return view('layouts.stories.search', compact('stories', 'tag'));
    }
}
