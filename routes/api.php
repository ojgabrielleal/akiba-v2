<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CastController;

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::prefix('stream')->group(function () {
    Route::controller(CastController::class)->group(function () {
        Route::get('', 'redirectStream');
        Route::get('metadata', 'showMetadata');
    });
});