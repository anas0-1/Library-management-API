<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('members', MemberController::class);
    Route::apiResource('loans', LoanController::class);
    Route::apiResource('reservations', ReservationController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('genres', GenreController::class);
});
