<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DTruyenController;
use App\Http\Controllers\Api\LovelistController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\TruyenFullController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// PUBLIC ROUTES ----------------------------------------------------

Route::middleware('throttle:api')
    ->group(function () {
        //ACCOUNT APIs
        Route::prefix('ac')->group(function () {
            Route::post('/register', [AccountController::class, 'register']);
            Route::post('/login', [AccountController::class, 'login']);
        });

        // CRAWL TRUYENFULL
        Route::prefix('tf')->group(function () {
            Route::post('/craw-new-story', [TruyenFullController::class, 'storeNewLinks']);
            Route::post('/craw-link-chapters', [TruyenFullController::class, 'getLinkChapters']);
            Route::post('/craw-content-chapter', [TruyenFullController::class, 'getContentChapter']);
        });
        //CRAWL DTRUYEN
        Route::prefix('dt')->group(function () {
            Route::post('/craw-new-story', [DTruyenController::class, 'storeNewLinks']);
            Route::post('/craw-link-chapters', [DTruyenController::class, 'getLinkChapters']);
            Route::post('/craw-content-chapter', [DTruyenController::class, 'getContentChapter']);
        });
        //STORY APIs
        Route::prefix('st')->group(function () {
            Route::get('/get-list-stories', [StoryController::class, 'getListStories']);
            Route::get('/get-story/{id}', [StoryController::class, 'getStory']);
            Route::get('/get-story-views', [StoryController::class, 'getStoryViews']);
            Route::get('/get-story-new', [StoryController::class, 'getStoryNew']);
            Route::get('/add-story-view-recently/{id}', [StoryController::class, 'addStoryViewRecently']);
            Route::get('/get-story-view-recently', [StoryController::class, 'getStoryViewRecently']);
        });
        //CHAPTER APIs
        Route::prefix('ct')->group(function () {
            Route::get('/get-list-chapters/{id}', [ChapterController::class, 'getListChapters']);
            Route::get('/get-chapter/{id}', [ChapterController::class, 'getChapter']);
            Route::get('/get-list-chapters-no-paginate/{id}', [ChapterController::class, 'getListChaptersNoPaginate']);
            Route::get('/get-list-new-chapters', [ChapterController::class, 'getNewChapters']);
        });

        //CATALOG APIs
        Route::prefix('ctl')->group(function () {
            Route::get('/get-list-catalog', [CategoryController::class, 'getListCategories']);
            Route::get('/get-catalog/{id}', [CategoryController::class, 'getCategory']);
            Route::get('/get-stories-by-category-id/{id}', [CategoryController::class, 'getListStoriesByCategory']);
        });

        //CONTACT APIs
        Route::prefix('contact')->group(function () {
            Route::post('/add-contact', [ContactController::class, 'addContact']);
        });

        //CONTACT APIs
        Route::prefix('ll')->group(function () {
            Route::post('/add-lovelist', [LovelistController::class, 'addLovelist']);
        });
    });

// PRIVATE ROUTES ----------------------------------------------------
// Route::middleware(['auth:user_account, auth:sanctum'])
//     ->group(function () {
//         Route::post('/craw-new-story', [TruyenFullController::class, 'storeNewLinks']);
//         Route::post('/craw-link-chapter', [TruyenFullController::class, 'getLinkChapters']);
//         Route::post('/update-status-story-to-done', [TruyenFullController::class, 'updateStatusStoryToDone']);
//     });
