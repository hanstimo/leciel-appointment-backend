<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KoleksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Publik: koleksi & booking bisa diakses tanpa login
Route::get('/koleksi', [KoleksiController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store'])->middleware('throttle:10,1');

// Auth pelanggan
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Butuh login (pakai token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/appointments', [AppointmentController::class, 'index']);
});
