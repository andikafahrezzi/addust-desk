<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\Agent\TicketController as AgentTicketController;
use App\Http\Controllers\Admin\Master\DepartmentController;

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

Route::middleware([
    'auth',
    'role:AGENT'
])
->prefix('agent')
->name('agent.')
->group(function () {

    Route::get(
        '/tickets',
        [AgentTicketController::class, 'index']
    )->name('tickets.index');
        Route::patch(
        '/tickets/{ticket}/claim',
        [AgentTicketController::class, 'claim']
    )->name('tickets.claim');
    Route::get(
        '/tickets/{ticket}',
        [AgentTicketController::class, 'show']
    )->name('tickets.show');
    Route::post(
    '/tickets/{ticket}/messages',
    [AgentTicketController::class, 'storeMessage']
)->name('tickets.messages.store');
Route::patch(
    '/tickets/messages/{message}',
    [AgentTicketController::class, 'updateMessage']
)->name('tickets.messages.update');

Route::delete(
    '/tickets/messages/{message}',
    [AgentTicketController::class, 'deleteMessage']
)->name('tickets.messages.delete');
Route::get(
    '/attachments/{attachment}/download',
    [AgentTicketController::class, 'downloadAttachment']
)->name('attachments.download');
Route::patch(
    '/tickets/{ticket}/resolve',
    [AgentTicketController::class, 'resolve']
)->name('tickets.resolve');
Route::patch(
    '/tickets/{ticket}/escalate',
    [AgentTicketController::class, 'escalate']
)->name('tickets.escalate');
Route::patch(
    '/tickets/{ticket}/reassign',
    [AgentTicketController::class, 'reassign']
)->name('tickets.reassign');

});
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
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view(
            '/dashboard',
            'admin.dashboard'
        )->name('dashboard');

        Route::resource(
            'departments',
            DepartmentController::class
        )->except(['show']);

    });

    Route::middleware([
    'auth',
    'role:USER'
])->prefix('user')
->name('user.')
->group(function () {

    
    Route::get(
        '/tickets/create',
        [TicketController::class, 'create']
        )->name('tickets.create');
        
        Route::post(
            '/tickets',
            [TicketController::class, 'store']
            )->name('tickets.store');
            
            Route::get(
                '/tickets',
                [TicketController::class, 'index']
            )->name('tickets.index');
            Route::get(
                '/tickets/{ticket}',
                [TicketController::class, 'show']
            )->name('tickets.show');
            Route::post(
                '/tickets/{ticket}/messages',
                [TicketController::class, 'storeMessage']
            )->name('tickets.messages.store');
            Route::patch(
                '/tickets/messages/{message}',
                [TicketController::class, 'updateMessage']
            )->name('tickets.messages.update');
            Route::delete(
                '/tickets/messages/{message}',
                [TicketController::class, 'deleteMessage']
            )->name('tickets.messages.delete');
            Route::get(
                '/attachments/{attachment}/download',
                [TicketController::class, 'downloadAttachment']
            )->name('attachments.download');
            Route::patch(
                '/tickets/{ticket}/reopen',
                [TicketController::class, 'reopen']
            )->name('tickets.reopen');
            Route::patch(
                '/tickets/{ticket}/close',
                [TicketController::class, 'close']
            )->name('tickets.close');
        });
        
require __DIR__.'/auth.php';
