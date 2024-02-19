<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::view('admin/dashboard', 'admin.index')->name('dashboard.admin');
    Route::view('admin/writer/new', 'admin.writer.create')->name('new.writer.admin');
    Route::post('admin/writer/store', [AdminController::class, 'storeWriter'])->name('store.writer.admin');
    Route::get('admin/writer/list', [AdminController::class, 'showWriterList'])->name('list.writer.admin');
    Route::get('admin/writer/posts/{user}', [AdminController::class, 'showWriterPosts'])->name('posts.writer.admin');
    Route::view('admin/category/new', 'admin.category.create')->name('new.category.admin');
    Route::post('admin/category/store', [AdminController::class, 'storeNewCategory'])->name('store.category.admin');
    Route::get('admin/category/list', [AdminController::class, 'showCategoryList'])->name('list.category.admin');
    Route::get('admin/category/edit/{category}', [AdminController::class, 'editCategory'])->name('edit.category.admin');
    Route::put('admin/category/update/{category}', [AdminController::class, 'updateCategory'])->name('update.category.admin');
});