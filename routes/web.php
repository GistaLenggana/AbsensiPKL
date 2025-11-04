<?php
// routes/web.php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Redirect root to absensi
// Ketika user akses http://localhost:8000 akan redirect ke /absensi
Route::redirect('/', '/absensi');

// Public Routes - Absensi
// Halaman form absensi (GET)
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');

// Proses submit form absensi (POST)
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

// Halaman sukses setelah absensi (GET)
Route::get('/absensi/success', [AbsensiController::class, 'success'])->name('absensi.success');

// Dashboard Admin
// Halaman dashboard untuk lihat data absensi (GET)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');