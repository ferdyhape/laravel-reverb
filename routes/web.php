<?php

use App\Events\MessageSent;
use App\Http\Controllers\BroadcastController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('app.dashboard');
    })->name('home');

    Route::get('/broadcast-notifications', [BroadcastController::class, 'index'])->name('broadcast-notifications');
    Route::post('/broadcast-notifications', [BroadcastController::class, 'send'])->name('broadcast-notifications.send');
    Route::post('/notifications/{id}/read', [BroadcastController::class, 'markAsRead'])->name('notifications.markAsRead');
});
