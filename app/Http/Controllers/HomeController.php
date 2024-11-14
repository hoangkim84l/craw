<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Story;

class HomeController extends Controller
{
    public function index()
    {
        $storiesView = Story::orderBy('view', 'desc')->limit(10)->get();
        $storiesNew = Story::orderBy('created', 'desc')->limit(3)->get();
        $categoriesAsTags = Catalog::orderBy('created', 'desc')->get();
        $trendingStories = Story::inRandomOrder()->get();
        return view('layouts.home.home', compact('storiesView', 'storiesNew', 'categoriesAsTags', 'trendingStories'));
    }
}
