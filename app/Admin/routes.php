<?php

use App\Admin\Controllers\CatalogController;
use App\Admin\Controllers\ChapterController;
use App\Admin\Controllers\ContactController;
use App\Admin\Controllers\LinkChapterController;
use App\Admin\Controllers\LinkChapterHistoryController;
use App\Admin\Controllers\StoryController;
use App\Admin\Controllers\SupportController;
use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->resource('cafe/stories', StoryController::class);
    $router->resource('cafe/catalogs', CatalogController::class);
    $router->resource('cafe/chapters', ChapterController::class);
    $router->resource('cafe/contacts', ContactController::class);
    $router->resource('cafe/link-chapters', LinkChapterController::class);
    $router->resource('cafe/link-chapter-histories', LinkChapterHistoryController::class);
    $router->resource('cafe/supports', SupportController::class);

});
