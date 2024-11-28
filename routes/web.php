<?php

use App\Http\Controllers\divisiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\perusaanController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PageController::class, 'home']);
Route::get('/paymentaccount', [PageController::class, 'pa']);
Route::get('/workerdata', [PageController::class, 'worker']);
Route::get('/transaction', [PageController::class, 'transaction']);
Route::get('/logbook', [PageController::class, 'logbook']);
Route::get('/admin', [PageController::class, 'admin']);

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





