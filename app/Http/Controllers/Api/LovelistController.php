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

    public function getLovelist($id)
    {
        $lovelist = Lovelists::where('user_id', $id)->paginate();
        return response()->json(['status' => 'success', 'data' => $lovelist]);
    }

    public function removeLovelist(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'story_id' => 'required',
        ]);

        $loveList = Lovelists::where('user_id', $data['user_id'])->where('story_id', $data['story_id'])->first();
        if ($loveList) {
            $loveList->delete();
            return response()->json(['status' => 'remove successfull']);
        }
        return response()->json(['status' => 'Something wrong can not delete']);
    }
}
