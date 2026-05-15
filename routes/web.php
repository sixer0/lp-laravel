<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

// Home - Landing page (Bootstrap layout)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact form submission
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Legal & Privacy pages
Route::view('/legal-notice', 'legal.notice')->name('legal');
Route::view('/privacy', 'legal.privacy')->name('privacy');

// Projects dynamic pages
Route::get('/project/{slug}', [HomeController::class, 'project'])->name('project');

// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

