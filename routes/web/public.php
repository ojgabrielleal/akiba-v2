<?php

use Illuminate\Support\Facades\Route;

// Public controllers
use App\Http\Controllers\Public\HomeController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::prefix("site")->middleware(['inertia', 'auth'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('', 'render')->name('home');
    });
});
        