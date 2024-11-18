<?php

namespace App\Http\Middleware;

use App\Models\Catalog;
use App\Models\Story;
use App\Models\Support;
use App\Models\User;
use Closure;

class SetGlobalData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $userData = User::find(auth()->id());
        $stories = Story::orderBy('view', 'desc')->limit(5)->get();
        $tags = Catalog::orderBy('created_at', 'desc')->get();
        $siteSetting = Support::find(1);

        $storyIds = session()->get('recently_viewed', []);
        $lastFiveViewedIds = array_slice($storyIds, -5);
        $viewedStories = Story::whereIn('id', $lastFiveViewedIds)->get();

        $storiesSameTag =Story::inRandomOrder()->limit(3)->get();


        view()->share([
            'userData' => $userData,
            'siteSetting' => $siteSetting,
            'quickViewStories' => $stories,
            'tags' => $tags,
            'viewedStories' => $viewedStories,
            'storiesSameTag' => $storiesSameTag
        ]);

        return $next($request);
    }
}
