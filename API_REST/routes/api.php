<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('academies', AcademyController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('academies', AcademyController::class);
});