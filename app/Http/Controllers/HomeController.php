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
        $storiesNew = Story::orderBy('created_at', 'desc')->limit(3)->get();
        $categoriesAsTags = Catalog::orderBy('created_at', 'desc')->get();
        $trendingStories = Story::inRandomOrder()->get();
        $populars = Story::orderBy('view', 'desc')->limit(14)->get();
        $highlight = Story::orderBy('rate_total', 'desc')->limit(3)->get();
        $phoBien = Chapter::orderBy('created_at', 'desc')->limit(10)->get();
        return view('layouts.home.home', compact('populars', 'highlight', 'phoBien', 'storiesNew', 'categoriesAsTags', 'trendingStories'));
    }
}
