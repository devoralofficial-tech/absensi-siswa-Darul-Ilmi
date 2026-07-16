<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/setup-db', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
    return 'Database berhasil di-migrate dan di-seed di Vercel!';
});
require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Scan QR
    Route::get('/scan', [AttendanceController::class, 'scan'])->name('scan');
    Route::get('/scan/lookup/{token}', [AttendanceController::class, 'lookup'])->name('scan.lookup');
    Route::get('/attendance/confirm/{token}', [AttendanceController::class, 'confirm'])->name('attendance.confirm');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    // QR Siswa
    Route::get('/qr-siswa', [QrController::class, 'index'])->name('qr.index');
    Route::get('/qr-siswa/download-all', [QrController::class, 'downloadAll'])->name('qr.downloadAll');
    Route::get('/qr-siswa/{id}/download', [QrController::class, 'download'])->name('qr.download');
    Route::get('/qr-siswa/print', [QrController::class, 'printView'])->name('qr.print');

    // Riwayat
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('history.index');

    // Laporan
    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    Route::get('/laporan/export', [ReportController::class, 'export'])->name('report.export');
});
