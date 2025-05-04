<?php

declare(strict_types=1);

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('welcome');
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
