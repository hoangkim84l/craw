<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Story;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getListCategories(Request $request)
    {
        $categories = Catalog::query();
        return response()->json([
            'status' => 'success',
            'data' => $categories->paginate()
        ]);
    }

    public function getListStoriesByCategory($id)
    {
        $id = (string)'"' . $id . '"';
        $stories = Story::where('category_id', 'like', "%$id%");
        return response()->json([
            'status' => 'success',
            'data' => $stories->paginate()
        ]);
    }

    public function getCategory($id)
    {
        $catalog = Catalog::where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $catalog,
        ]);
    }
}
