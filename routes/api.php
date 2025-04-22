<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::apiResource('user', AuthController::class);

Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt')->group(function () {
    Route::get('profile', [AuthController::class, 'show']);
});
