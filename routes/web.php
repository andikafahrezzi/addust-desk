<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin-test', function () {
    return 'Admin Area';
})
->middleware(['auth', 'role:ADMIN']);

Route::get('/agent-test', function () {
    return 'Agent Area';
})
->middleware(['auth', 'role:AGENT']);
Route::middleware(['auth'])
    ->get('/dashboard', [DashboardController::class, 'redirect'])
    ->name('dashboard');
    
    Route::middleware(['auth', 'role:USER'])
    ->group(function () {

        Route::view(
            '/user/dashboard',
            'user.dashboard'
        )->name('user.dashboard');

    });
Route::middleware(['auth', 'role:AGENT'])
    ->group(function () {

        Route::view(
            '/agent/dashboard',
            'agent.dashboard'
        )->name('agent.dashboard');

    });
Route::middleware(['auth', 'role:ADMIN'])
    ->group(function () {

        Route::view(
            '/admin/dashboard',
            'admin.dashboard'
        )->name('admin.dashboard');

    });
require __DIR__.'/auth.php';
