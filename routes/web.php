<?php

use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Writer\WriterController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

include "auth/auth.php";
include "admin/admin.php";
include "writer/writer.php";

Route::middleware('auth')->group(function () {
    Route::post('user/comment/add/{post}', [UserController::class, 'addComment'])->name('add.comment.user');
});

Route::get('/', [PostController::class, 'index'])->name('index.guest');
Route::get('/{post}/{slug}', [PostController::class, 'showSinglePost'])->name('single.post.guest');
Route::get('/writer/posts/{user}', [WriterController::class, 'getWriterPosts'])->name('get.post.writer');
Route::get('/post/categories/{category}', [PostController::class, 'getPostByCategories'])->name('get.categories.post');
Route::get('/post/tags/{tag}', [PostController::class, 'getPostByTags'])->name('get.tags.post');

//TODO add middleware can:admin,writer
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});