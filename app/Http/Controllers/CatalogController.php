<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Story;

class CatalogController extends Controller
{
    public function show(string $slug)
    {
        $catalog = Catalog::where('slug', $slug)->first();
        $stories = Story::where('category_id', 'LIKE ', "%'$catalog->id'%")->get();
        return view('layouts.stories.catalog', compact('stories', 'catalog'));
    }
}
