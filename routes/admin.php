<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Admin / CMS Routes
|--------------------------------------------------------------------------
|
| Authenticated admin area for managing the landing page content.
| Protected by the `session.admin` middleware alias defined in the Kernel.
|
*/

// ── Login (public)
Route::get('/admin/login', [LoginController::class, 'show'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'authenticate']);
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// ── CMS Dashboard — requires admin session
Route::middleware('session.admin')->group(function () {
    // Dashboard home
    Route::get('/admin', [DashboardController::class, 'show'])->name('admin.dashboard');

    // ── Projects CRUD ──
    Route::get('/admin/projects',                                     [ProjectController::class, 'index'])->name('admin.projects');
    Route::get('/admin/projects/create',                              [ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/admin/projects',                                    [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/admin/projects/{project}/edit',                      [ProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::post('/admin/projects/{project}',                          [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::post('/admin/projects/{project}/delete',                   [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
});
