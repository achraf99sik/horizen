<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\WatchHistoryController;

Route::apiResource('me', AuthController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('nationalities', NationalityController::class);
Route::apiResource('playlist', PlaylistController::class);
Route::apiResource('tags', TagController::class);
Route::apiResource('watch-history', WatchHistoryController::class);
Route::apiResource('like', LikeController::class);

Route::get('videos/{video}/related', [VideoController::class, 'fetchVideos']);

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('signup', [AuthController::class, 'store'])->name('singup');

Route::middleware('jwt')->group(function () {
    Route::get('profile', [AuthController::class, 'show']);
});
Route::post('/user-info', [UserInfoController::class, 'storeOrUpdate']);
