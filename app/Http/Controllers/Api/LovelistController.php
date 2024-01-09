<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lovelists;
use Illuminate\Http\Request;

class LovelistController extends Controller
{
    public function addLovelist(Request $request)
    {
        $data = $request->validate([
            'user_email' => 'required',
            'user_id' => 'required',
            'story_id' => 'required',
            'status' => 'required',
        ]);

        Lovelists::create($data);
        return response()->json(['status' => 'success']);
    }
}
