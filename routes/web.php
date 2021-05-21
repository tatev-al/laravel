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

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/{profileId}', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile/detail', [DetailController::class, 'update'])->name('profile.detail.update');
Route::put('/profile/upload', [AvatarController::class, 'upload'])->name('profile.upload');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'transfer'])->name('posts.transfer');
Route::post('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{postId}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('/posts/update/{postId}', [PostController::class, 'update'])->name('posts.update');
Route::get('/posts/{postId}', [PostController::class, 'delete'])->name('posts.delete');
Route::get('/posts/show/{postId}', [PostController::class, 'show'])->name('posts.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::post('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
Route::put('/gallery/edit/{galleryId}', [GalleryController::class, 'edit'])->name('gallery.edit');
Route::get('/gallery/show/{galleryId}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/gallery/{galleryId}', [GalleryController::class, 'transfer'])->name('gallery.transfer');
Route::delete('/gallery/{imageId}', [GalleryController::class, 'delete'])->name('gallery.delete');
Route::delete('/gallery/destroy/{galleryId}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
