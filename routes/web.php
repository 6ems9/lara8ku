<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Cviebrock\EloquentSluggable\Services\SlugService;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified']);

Route::get('check_slug', function () {
    $slug = SlugService::createSlug(App\Models\Post::class, 'slug', request('title'));
    return response()->json(['slug' => $slug]);
});

Route::resource('post', PostController::class)->middleware(['auth', 'verified']);
Route::get('/blog', [PostController::class, 'blog']);

Route::resource('category', CategoryController::class)->middleware(['auth', 'verified']);
Route::post('destroymulti', [CategoryController::class, 'destroymulti']);

Route::resource('tag', TagController::class)->middleware(['auth', 'verified']);

Route::resource('sample', SampleController::class)->middleware(['auth', 'verified']);
Route::post('allposts', [SampleController::class, 'allPosts'])->name('allposts');
