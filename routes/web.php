<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

// Home - Landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/contact/captcha', [ContactController::class, 'captcha'])->name('contact.captcha');

// Legal & Privacy pages
Route::view('/legal-notice', 'legal.notice')->name('legal');
Route::view('/privacy', 'legal.privacy')->name('privacy');

// Projects dynamic pages
Route::get('/project/{slug}', [HomeController::class, 'project'])->name('project');

// ── Admin / CMS routes
require __DIR__ . '/admin.php';

// ── CMS Bootstrap route (replaces _cms_setup.php)
// Runs database migrations and seeds the default admin account.
// DELETE THIS ROUTE AFTER FIRST SUCCESSFUL RUN.
use App\Http\Controllers\Admin\LoginController;
Route::get('/admin/setup', [LoginController::class, 'setup'])->name('admin.setup');

// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
