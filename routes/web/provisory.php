<?php

use Illuminate\Support\Facades\Route;

// Provisory controllers
use App\Http\Controllers\Provisory\HomeController;

/*
|--------------------------------------------------------------------------
| Provisory routes
|--------------------------------------------------------------------------
*/
Route::prefix("")->middleware(['inertia'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('', 'render')->name('home');
        Route::post('song-request','createSongRequest');
    });
});
