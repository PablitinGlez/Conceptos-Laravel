<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Admin dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Resource routes for categories and posts
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
});
