<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChapterController extends Controller
{
    public function getListChapters($id)
    {
        $query = Chapter::where('story_id', $id);
        $query = $query->orderBy('id', 'desc');
        return ChapterResource::collection($query->paginate());
    }

    public function getListChaptersNoPaginate($id)
    {
        $query = Chapter::where('story_id', $id);
        $query = $query->orderBy('id', 'desc');
        return ChapterResource::collection($query->get());
    }

    public function getNewChapters(Request $request)
    {
        $storyIds = [];
        $ids = [];
        Chapter::orderBy('id', 'desc')->chunk(100, function ($records) use (&$storyIds, &$ids) {
            foreach ($records as $record) {

                if (!in_array($record->story_id, $ids)) {
                    array_unshift($ids, $record->story_id);
                    array_unshift($storyIds, $record->id);
                }

                if (count($ids) > 30) {
                    break;
                }
            }
        });
        $chapters = Chapter::find($storyIds);
        $chapters->load('story');
        return ChapterResource::collection($chapters->reverse());
    }

    public function getChapter($id)
    {
        $chapter = Chapter::find($id);
        return ChapterResource::make($chapter);
    }
}
