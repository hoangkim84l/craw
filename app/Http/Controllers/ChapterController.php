<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Story;

class ChapterController extends Controller
{
    public function index(string $slug)
    {
        $story = Story::where('slug', $slug)->firstOrFail();
        $chapters = Chapter::where('story_id', $story->id)->orderBy('created_at', 'desc')->get();
        return view('layouts.chapters.list', compact('chapters'));
    }

    public function show(string $truyen, string $chuong)
    {
        $story = Story::where('slug', $truyen)->firstOrFail();
        $chapter = Chapter::where('story_id', $story->id)->where('slug', $chuong)->first();
        $chapters = Chapter::where('story_id', $story->id)->orderBy('created_at', 'desc')->get();
        $nextChapter = Chapter::where('story_id', $story->id)
            ->where('created_at', '>', $chapter->created_at)
            ->orderBy('created_at', 'asc')
            ->first();

        $previousChapter = Chapter::where('story_id', $story->id)
            ->where('created_at', '<', $chapter->created_at)
            ->orderBy('created_at', 'desc')
            ->first();
        return view('layouts.chapters.detail', compact('story', 'chapter', 'nextChapter', 'previousChapter', 'chapters'));
    }
}
