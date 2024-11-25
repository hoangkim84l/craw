<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Chapter;
use App\Models\Story;

class HomeController extends Controller
{
    public function index()
    {
        $storiesNew = Story::orderBy('id', 'desc')->limit(3)->get();
        $categoriesAsTags = Catalog::orderBy('id', 'desc')->get();
        $trendingStories = Story::inRandomOrder()->get();
        $populars = Story::orderBy('view', 'desc')->limit(14)->get();
        $highlight = Story::orderBy('rate_total', 'desc')->limit(3)->get();
        $phoBien = Chapter::orderBy('id', 'desc')->limit(10)->get();
        $phoBien->load('story');
        return view('layouts.home.home', compact('populars', 'highlight', 'phoBien', 'storiesNew', 'categoriesAsTags', 'trendingStories'));
    }
}
