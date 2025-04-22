<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::apiResource('user', AuthController::class);

Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt')->group(function () {
    Route::get('profile', [AuthController::class, 'show']);
});
