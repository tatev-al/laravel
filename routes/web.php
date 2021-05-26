<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DetailController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/feed', [FeedController::class, 'index'])->name('feed');

Route::prefix('profile')->group(function()
{
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
    Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/detail', [DetailController::class, 'update'])->name('profile.detail.update');
    Route::put('/upload', [AvatarController::class, 'upload'])->name('profile.upload');
});

Route::prefix('posts')->group(function()
{
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/update/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

Route::prefix('gallery')->group(function()
{
    Route::get('/', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/show/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/update/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/{image}', [GalleryController::class, 'delete'])->name('gallery.delete');
    Route::delete('/destroy/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
});

Route::prefix('admin')->group(function() {

});
