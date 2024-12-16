<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\sumberdanaController;
use App\Http\Controllers\divisiController;
use App\Http\Controllers\pekerjaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\perusaanController;
use App\Http\Controllers\logbookController;
use App\Http\Controllers\JadwalController;
use App\Http\COntrollers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PageController::class, 'home']);
// Route::get('/transaction', [PageController::class, 'transaction']);
// Route::get('/logbook', [PageController::class, 'logbook']);

//perusahaan
Route::get('/crudperusahaan', [perusaanController::class, 'index'])->name('crudperusahaan');
Route::post('/addPerusahaan', [perusaanController::class, 'addPerusahaan'])->name('addPerusahaan');
Route::get('/editPerusahaan/{id}', [perusaanController::class, 'editPerusahaan'])->name('editPerusahaan');
Route::put('/editPerusahaan/{id}', [perusaanController::class, 'updatePerusahaan'])->name('updatePerusahaan');
Route::delete('/deletePerusahaan/{id}', [perusaanController::class, 'deletePerusahaan'])->name('deletePerusahaan');

// Divisi
Route::get('/divisi', [divisiController::class, 'index'])->name('divisi.index');
Route::post('/divisi', [divisiController::class, 'addDivisi'])->name('addDivisi');
Route::get('/divisi/{id}/edit', [divisiController::class, 'editDivisi'])->name('editDivisi');
Route::put('/divisi/{id}', [divisiController::class, 'updateDivisi'])->name('updateDivisi');
Route::delete('/divisi/{id}', [divisiController::class, 'deleteDivisi'])->name('deleteDivisi');

// Rute untuk pekerja
Route::get('/workerdata', [pekerjaController::class, 'index'])->name('workerdata');
Route::post('/workerdata', [pekerjaController::class, 'addPekerja'])->name('addPekerja');
Route::get('/workerdata/{id}/edit', [pekerjaController::class, 'editPekerja'])->name('editPekerja');
Route::put('/workerdata/{id}', [pekerjaController::class, 'updatePekerja'])->name('updatePekerja');
Route::delete('/workerdata/{id}', [pekerjaController::class, 'deletePekerja'])->name('deletePekerja');


// Sumber Dana routes
Route::get('/paymentaccount', [sumberdanaController::class, 'index'])->name('paymentaccount');
Route::post('/paymentaccount', [sumberdanaController::class, 'addSumberDana'])->name('addSumberDana');
Route::get('/paymentaccount/{id}/edit', [sumberdanaController::class, 'editSumberDana'])->name('editSumberDana');
Route::put('/paymentaccount/{id}', [sumberdanaController::class, 'updateSumberDana'])->name('updateSumberDana');
Route::delete('/paymentaccount/{id}', [sumberdanaController::class, 'deleteSumberDana'])->name('deleteSumberDana');

// Admin Routes
Route::get('/admin', [adminController::class, 'index'])->name('admin.index');
Route::post('/admin', [adminController::class, 'addAdmin'])->name('addAdmin');
Route::get('/admin/{id}/edit', [adminController::class, 'editAdmin'])->name('editAdmin');
Route::put('/admin/{id}', [adminController::class, 'updateAdmin'])->name('updateAdmin');
Route::delete('/admin/{id}', [adminController::class, 'deleteAdmin'])->name('deleteAdmin');

Route::get('/transaction', [JadwalController::class, 'index'])->name('transaction');
Route::post('/process-payments/{id}', [JadwalController::class, 'processPayments'])->name('process.payments');
Route::post('/transaction/test-payment', [JadwalController::class, 'testPayment'])->name('transaction.testPayment');
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
Route::post('/transaction/process', [JadwalController::class, 'processPaymentsForCompany'])->name('transaction.process');
Route::delete('/jadwal/{id}/cancel', [JadwalController::class, 'cancel'])->name('jadwal.cancel');
Route::post('/update-status-process-payments/{id}', [JadwalController::class, 'updateStatusAndProcessPayments'])->name('update.status.process.payments');

// Logbook Routes
Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook');
Route::get('logbook/export', [logbookController::class, 'exportPdf'])->name('logbook.export');

Route::get('/', [TransaksiController::class, 'home']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// routes/web.php
Route::get('/login', function () {
    return view('auth.login'); // Return the Vue.js login page view
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
