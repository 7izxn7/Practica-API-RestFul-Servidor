<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\CourseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Endpoint público: consultar los cursos de una academia
Route::get('/academy/{academy}/courses', [AcademyController::class, 'courses']);

// Endpoints protegidos
Route::middleware('auth:sanctum')->group(function () {

    // CRUD de academias
    Route::apiResource('academies', AcademyController::class);

    // Consultar estudiantes de un curso
    Route::get('/course/{course}/students', [CourseController::class, 'students']);

    // Matricular estudiante
    Route::post('/courses/{course}/enroll/{student}', [CourseController::class, 'enroll']);

    // Desmatricular estudiante
    Route::delete('/courses/{course}/unenroll/{student}', [CourseController::class, 'unenroll']);

});