<?php

use App\Http\Controllers\GenerateController;
use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InvitationController::class, 'index'])->name('invitation');

Route::post('/rsvp', [InvitationController::class, 'storeRsvp'])
    ->middleware('throttle:10,1')
    ->name('rsvp.store');

Route::get('/generate', [GenerateController::class, 'form'])->name('generate.form');
Route::post('/generate/auth', [GenerateController::class, 'authenticate'])
    ->middleware('throttle:20,1')
    ->name('generate.auth');
Route::post('/generate', [GenerateController::class, 'generate'])
    ->middleware('generate.auth', 'throttle:20,1')
    ->name('generate.create');
Route::post('/generate/logout', [GenerateController::class, 'logout'])->name('generate.logout');
