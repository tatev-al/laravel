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
Route::get('/profile/{profile}', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile/detail', [DetailController::class, 'update'])->name('profile.detail.update');
Route::put('/profile/upload', [AvatarController::class, 'upload'])->name('profile.upload');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/update/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/gallery', [GalleryController::class, 'create'])->name('gallery.create');
Route::post('/gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
Route::get('/gallery/show/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
Route::put('/gallery/update/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
Route::delete('/gallery/{image}', [GalleryController::class, 'delete'])->name('gallery.delete');
Route::delete('/gallery/destroy/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
