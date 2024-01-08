<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function getListStories(Request $request)
    {
        [
            'search' => $search,
            'order' => $order,
            'orderBy' => $orderBy,
        ] = $this->getFilters();
        $query = Story::query();
        $availableProperties = app(Story::class)->getFillable();
        if ($search) {
            $query->where(
                function ($q) use ($availableProperties, $search) {
                    foreach ($availableProperties as $availableProperty) {
                        $q->orWhere($availableProperty, 'like', "%$search%");
                    }
                }
            );
        }

        $fillable = app(Story::class)->getFillable();
        if (in_array($orderBy, $fillable)) {
            $query = $query->orderBy($orderBy, $order);
        } else {
            $query = $query->orderBy('id', 'desc');
        }

        return StoryResource::collection($query->paginate());
    }

    public function getStory($id)
    {
        $story = Story::find($id);
        return StoryResource::make($story);
    }

    public function getStoryViews(Request $request)
    {
        $stories = Story::orderBy('view', 'desc')->limit(10)->get();
        return StoryResource::collection($stories);
    }

    public function getStoryNew(Request $request)
    {
        $stories = Story::orderBy('created', 'desc')->limit(6)->get();
        return StoryResource::collection($stories);
    }

    public function addStoryViewRecently($id)
    {
        $storiesViewed = session()->get('storiesViewed', []);
        if (!in_array($id, $storiesViewed)) {
            array_unshift($storiesViewed, $id);
        }
        $storiesViewed = array_slice($storiesViewed, 0, 6);
        session()->put('stories_viewed', $storiesViewed);
        return response()->json(['state' => 'success']);
    }

    public function getStoryViewRecently(Request $request)
    {
        $storiesViewed = session()->get('stories_viewed', []);
        $stories = Story::whereIn('id', $storiesViewed)->get();
        return StoryResource::collection($stories);
    }

    private function getFilters(): array
    {
        if (request()->isMethod('get')) {
            return [
                'search' => request()->query('search'),
                'order' => request()->query('order'),
                'orderBy' => request()->query('orderBy'),
            ];
        }

        return [
            'search' => 'all' !== request()->search ? request()->search : null,
            'order' => request()->order,
            'orderBy' => 'all' !== request()->orderBy ? request()->orderBy : null,
        ];
    }
}
