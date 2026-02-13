<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/install', [AuthController::class, 'install']);
Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');
Route::post('/webhook', [WebhookController::class, 'handle']);

Route::get('/{any?}', fn () => view('app'))->where('any', '.*');

