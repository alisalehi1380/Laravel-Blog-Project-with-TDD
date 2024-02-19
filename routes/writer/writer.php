<?php

use App\Http\Controllers\Writer\WriterController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::view('writer/dashboard', 'writer.index')->name('dashboard.writer');
    Route::get('writer/post/new', [WriterController::class, 'newPost'])->name('new.post.writer');
    Route::post('writer/post/store', [WriterController::class, 'storePost'])->name('store.post.writer');
    Route::get('writer/post/list', [WriterController::class, 'showPostsList'])->name('list.post.writer');
    Route::get('writer/post/edit/{post}', [WriterController::class, 'editWriterPost'])->name('edit.post.writer');
    Route::put('writer/post/update/{post}', [WriterController::class, 'updateWriterPost'])->name('update.post.writer');
    Route::delete('writer/post/delete/{post}', [WriterController::class, 'deletePost'])->name('delete.post.writer');
    Route::get('writer/post/comments/{post}', [WriterController::class, 'showPostComments'])->name('comment.post.writer');
    Route::get('writer/post/{comment}', [WriterController::class, 'changeStateComment'])->name('state.comments.writer');
});