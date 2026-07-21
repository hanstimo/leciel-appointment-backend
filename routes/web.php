<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'index'])->name('dashboard');
    Route::patch('/dashboard/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::post('/dashboard/appointments/manual', [AppointmentController::class, 'storeManual'])->name('appointments.storeManual');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/koleksi', [App\Http\Controllers\Admin\KoleksiController::class, 'index'])->name('koleksi.index');
Route::patch('/dashboard/koleksi/{koleksi}/toggle', [App\Http\Controllers\Admin\KoleksiController::class, 'toggleTersedia'])->name('koleksi.toggle');
Route::get('/dashboard/koleksi/{koleksi}/edit', [App\Http\Controllers\Admin\KoleksiController::class, 'edit'])->name('koleksi.edit');
Route::post('/dashboard/koleksi/{koleksi}/blocked-dates', [App\Http\Controllers\Admin\KoleksiController::class, 'addBlockedDate'])->name('koleksi.blocked-dates.store');
Route::delete('/dashboard/koleksi/{koleksi}/blocked-dates/{date}', [App\Http\Controllers\Admin\KoleksiController::class, 'removeBlockedDate'])->name('koleksi.blocked-dates.destroy');
});

require __DIR__.'/auth.php';