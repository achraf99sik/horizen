<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DashboardController;

Route::get('/home', function () {
    return view('welcome');
});
Route::middleware('jwt')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'Authenticated']);
    });
});
Route::get("watch/{slug}", [VideoController::class, "videoDetails"]);
Route::get("upload", [VideoController::class, "index"]);
Route::post("upload", [VideoController::class, "store"])
    ->name("videos.store");
Route::prefix("uploads")->group(function(){
    Route::get("playlist/{folder}/{file}", [VideoController::class,"show"])
        ->name("video.playlist");
    Route::get("video/{folder}/{file}", [VideoController::class, "getFile"])
        ->name("video.file");
    Route::get("key/{folder}/{key}", [VideoController::class, "getKey"])
        ->name("video.key");
});
Route::view('/signup', 'auth.signup');
Route::view('/login', 'auth.login');
Route::view('/Categories', 'admin.create-category');
Route::get('/Categories/{Category}', [CategoryController::class, "show"]);
Route::delete('/Categories/{Category}', [CategoryController::class, "destroy"])->name("category.delete");
Route::get("/",[HomeController::class,"index"]);
Route::post('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
