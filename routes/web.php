<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Guest\PostController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Writer\WriterController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

Route::view('/login', 'auth.login')->name('show.login')->middleware('guest');
Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthenticateController::class, 'register'])->name('register.normall.user');
Route::any('/logout', [AuthenticateController::class, 'logout'])->name('logout')->middleware('auth');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'can:admin']], function () {
    Route::view('/dashboard', 'admin.index')->name('dashboard.admin');
    Route::view('/writer/new', 'admin.writer.create')->name('new.writer.admin');
    Route::post('/writer/store', [AdminController::class, 'storeWriter'])->name('store.writer.admin');
    Route::get('/writer/list', [AdminController::class, 'showWriterList'])->name('list.writer.admin');
    Route::get('/writer/posts/{user}', [AdminController::class, 'showWriterPosts'])->name('posts.writer.admin');
    Route::view('/category/new', 'admin.category.create')->name('new.category.admin');
    Route::post('/category/store', [AdminController::class, 'storeNewCategory'])->name('store.category.admin');
    Route::get('/category/list', [AdminController::class, 'showCategoryList'])->name('list.category.admin');
    Route::get('/category/edit/{category}', [AdminController::class, 'editCategory'])->name('edit.category.admin');
    Route::put('/category/update/{category}', [AdminController::class, 'updateCategory'])->name('update.category.admin');
});
Route::group(['prefix' => 'writer', 'middleware' => ['auth']], function () {
    Route::view('/dashboard', 'writer.index')->name('dashboard.writer');
    Route::get('/post/new', [WriterController::class, 'newPost'])->name('new.post.writer');
    Route::post('/post/store', [WriterController::class, 'storePost'])->name('store.post.writer');
    Route::get('/post/list', [WriterController::class, 'showPostsList'])->name('list.post.writer');
    Route::get('/post/edit/{post}', [WriterController::class, 'editWriterPost'])->name('edit.post.writer');
    Route::put('/post/update/{post}', [WriterController::class, 'updateWriterPost'])->name('update.post.writer');
    Route::delete('/post/delete/{post}', [WriterController::class, 'deletePost'])->name('delete.post.writer');
    Route::get('/post/comments/{post}', [WriterController::class, 'showPostComments'])->name('comment.post.writer');
    Route::get('/post/{comment}', [WriterController::class, 'changeStateComment'])->name('state.comments.writer');
});
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::post('/comment/add/{post}', [UserController::class, 'addComment'])->name('add.comment.user');
});
Route::group([], function () {
    Route::get('/', [PostController::class, 'index'])->name('index.guest');
    Route::get('/{post}/{slug}', [PostController::class, 'showSinglePost'])->name('single.post.guest');
    Route::get('/writer/posts/{user}', [WriterController::class, 'getWriterPosts'])->name('get.post.writer');
    Route::get('/post/categories/{category}', [PostController::class, 'getPostByCategories'])->name('get.categories.post');
    Route::get('/post/tags/{tag}', [PostController::class, 'getPostByTags'])->name('get.tags.post');
});

//TODO add middleware can:admin,writer
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});