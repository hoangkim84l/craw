<?php

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
        Route::post('/craw-new-story', [TruyenFullController::class, 'storeNewLinks']);
        Route::post('/craw-link-chapters', [TruyenFullController::class, 'getLinkChapters']);
        Route::post('/craw-content-chapter', [TruyenFullController::class, 'getContentChapter']);

});

// PRIVATE ROUTES ----------------------------------------------------
// Route::middleware(['auth:user_account, auth:sanctum'])
//     ->group(function () {
//         Route::post('/craw-new-story', [TruyenFullController::class, 'storeNewLinks']);
//         Route::post('/craw-link-chapter', [TruyenFullController::class, 'getLinkChapters']);
//         Route::post('/update-status-story-to-done', [TruyenFullController::class, 'updateStatusStoryToDone']);
//     });
