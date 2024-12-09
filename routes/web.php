<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SumberDanaController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PekerjaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\TransaksiController;

// Show login form
Route::get('login', [PageController::class, 'showLoginForm'])->name('login');

// Handle login
Route::post('login', [PageController::class, 'login'])->name('logged');

// Handle logout
Route::post('logout', [PageController::class, 'logout'])->name('logout');


// Group routes that require authentication and specific roles
Route::middleware(['auth:admin', 'role:Admin Bank,Super Admin,Admin Payroll'])->group(function () {
    // Home route
    Route::get('/', [PageController::class, 'home'])->name('home');
    // Admin Routes
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin', [AdminController::class, 'addAdmin'])->name('addAdmin');
    Route::get('/admin/{id}/edit', [AdminController::class, 'editAdmin'])->name('editAdmin');
    Route::put('/admin/{id}', [AdminController::class, 'updateAdmin'])->name('updateAdmin');
    Route::delete('/admin/{id}', [AdminController::class, 'deleteAdmin'])->name('deleteAdmin');

    // Sumber Dana routes
    Route::get('/paymentaccount', [SumberDanaController::class, 'index'])->name('paymentaccount');
    Route::post('/paymentaccount', [SumberDanaController::class, 'addSumberDana'])->name('addSumberDana');
    Route::get('/paymentaccount/{id}/edit', [SumberDanaController::class, 'editSumberDana'])->name('editSumberDana');
    Route::put('/paymentaccount/{id}', [SumberDanaController::class, 'updateSumberDana'])->name('updateSumberDana');
    Route::delete('/paymentaccount/{id}', [SumberDanaController::class, 'deleteSumberDana'])->name('deleteSumberDana');

    // Divisi Routes
    Route::get('/divisi', [DivisiController::class, 'index'])->name('divisi.index');
    Route::post('/divisi', [DivisiController::class, 'addDivisi'])->name('addDivisi');
    Route::get('/divisi/{id}/edit', [DivisiController::class, 'editDivisi'])->name('editDivisi');
    Route::put('/divisi/{id}', [DivisiController::class, 'updateDivisi'])->name('updateDivisi');
    Route::delete('/divisi/{id}', [DivisiController::class, 'deleteDivisi'])->name('deleteDivisi');

    // Pekerja Routes
    Route::get('/workerdata', [PekerjaController::class, 'index'])->name('workerdata');
    Route::post('/workerdata', [PekerjaController::class, 'addPekerja'])->name('addPekerja');
    Route::get('/workerdata/{id}/edit', [PekerjaController::class, 'editPekerja'])->name('editPekerja');
    Route::put('/workerdata/{id}', [PekerjaController::class, 'updatePekerja'])->name('updatePekerja');
    Route::delete('/workerdata/{id}', [PekerjaController::class, 'deletePekerja'])->name('deletePekerja');

    // Transaction Routes
    Route::get('/transaction', [JadwalController::class, 'index'])->name('transaction');
    Route::post('/process-payments/{id}', [JadwalController::class, 'processPayments'])->name('process.payments');
    Route::post('/transaction/test-payment', [JadwalController::class, 'testPayment'])->name('transaction.testPayment');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/transaction/process', [JadwalController::class, 'processPaymentsForCompany'])->name('transaction.process');
    Route::delete('/jadwal/{id}/cancel', [JadwalController::class, 'cancel'])->name('jadwal.cancel');
    Route::post('/update-status-process-payments/{id}', [JadwalController::class, 'updateStatusAndProcessPayments'])->name('update.status.process.payments');

    // Logbook Routes
    Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook');
    Route::get('logbook/export', [LogbookController::class, 'exportPdf'])->name('logbook.export');

    // Transaksi Routes
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
});

// Group routes that require authentication but not specific roles
Route::middleware(['auth:admin', 'role:Admin Bank,Super Admin'])->group(function () {
    // Perusahaan Routes
    Route::get('/crudperusahaan', [PerusahaanController::class, 'index'])->name('crudperusahaan');
    Route::post('/addPerusahaan', [PerusahaanController::class, 'addPerusahaan'])->name('addPerusahaan');
    Route::get('/editPerusahaan/{id}', [PerusahaanController::class, 'editPerusahaan'])->name('editPerusahaan');
    Route::put('/editPerusahaan/{id}', [PerusahaanController::class, 'updatePerusahaan'])->name('updatePerusahaan');
    Route::delete('/deletePerusahaan/{id}', [PerusahaanController::class, 'deletePerusahaan'])->name('deletePerusahaan');
});
