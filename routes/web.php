<?php

declare(strict_types=1);

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix("uploads")->group(function(){
    Route::get("playlist/{folder}", [VideoController::class,"getVideo"])
        ->name("video.playlist");
    Route::get("video/{folder}/{file}", [VideoController::class, "getFile"])
        ->name("video.file");
    Route::get("key/{folder}/{key}", [VideoController::class, "getKey"])
        ->name("video.key");
});
