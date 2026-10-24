<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\KoleksiController;
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

    Route::get('/dashboard/koleksi', [KoleksiController::class, 'index'])->name('koleksi.index');
    Route::patch('/dashboard/koleksi/{koleksi}/toggle', [KoleksiController::class, 'toggleTersedia'])->name('koleksi.toggle');
    Route::get('/dashboard/koleksi/{koleksi}/edit', [KoleksiController::class, 'edit'])->name('koleksi.edit');
    Route::post('/dashboard/koleksi/{koleksi}/blocked-dates', [KoleksiController::class, 'addBlockedDate'])->name('koleksi.blocked-dates.store');
    Route::delete('/dashboard/koleksi/{koleksi}/blocked-dates/{date}', [KoleksiController::class, 'removeBlockedDate'])->name('koleksi.blocked-dates.destroy');

    // melepas satu rentang sekaligus, dan membersihkan tanggal yang sudah lewat
    Route::delete('/dashboard/koleksi/{koleksi}/blocked-dates-range', [KoleksiController::class, 'removeRange'])->name('koleksi.blocked-dates.range');
    Route::delete('/dashboard/koleksi/{koleksi}/blocked-dates-history', [KoleksiController::class, 'clearHistory'])->name('koleksi.blocked-dates.history');
});

require __DIR__.'/auth.php';
