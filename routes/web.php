<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

// Define home route
Route::redirect('/', '/admin/posts')->name('home');


// Define dashboard route - uncommented to avoid route not found errors
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/prueba/{post}', function(Post $post){
    return Storage::download($post->image_path);
})->name('prueba');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';