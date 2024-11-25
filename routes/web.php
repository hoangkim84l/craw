<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/truyen.html', [StoriesController::class, 'index'])->name('truyen');
Route::get('/truyen/{truyen}', [StoriesController::class, 'show'])->name('show-truyen');
Route::get('/truyen/{truyen}/ds-chuong.html', [StoriesController::class, 'showChapter'])->name('show-chuong');
Route::get('/tim-truyen', [StoriesController::class, 'search'])->name('tim-truyen');

Route::get('/truyen/{truyen}/danh-sach-chuong.html', [ChapterController::class, 'index'])->name('danh-sach-chuong');
Route::get('/truyen/{truyen}/{chuong}', [ChapterController::class, 'show'])->name('chapter-detail');

Route::get('/danh-muc.html', [HomeController::class, 'index']);
Route::get('/danh-muc/{slug}', [CatalogController::class, 'show'])->name('show-danh-muc');
Route::get('/lien-he.html', [HomeController::class, 'index']);

Route::get('/dang-ki.html', [HomeController::class, 'index']);
Route::get('/dang-nhap.html', [HomeController::class, 'index']);

Route::get('/me/{me}/trang-cua-toi.html', [HomeController::class, 'index']);
Route::get('/me/{me}/truyen-cua-toi.html', [HomeController::class, 'index']);
