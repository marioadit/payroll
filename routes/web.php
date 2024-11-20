<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\perusaanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [PageController::class, 'home']);
Route::get('/paymentaccount', [PageController::class, 'pa']);
Route::get('/workerdata', [PageController::class, 'worker']);
Route::get('/transaction', [PageController::class, 'transaction']);
Route::get('/logbook', [PageController::class, 'logbook']);
Route::get('/admin', [PageController::class, 'admin']);
Route::get('/divisi', [PageController::class, 'divisi']);

//perusahaan
Route::get('/crudperusahaan', [perusaanController::class, 'index'])->name('crudperusahaan');
Route::post('/addPerusahaan', [perusaanController::class, 'addPerusahaan'])->name('addPerusahaan');
Route::get('/editPerusahaan/{id}', [perusaanController::class, 'editPerusahaan'])->name('editPerusahaan');
Route::put('/editPerusahaan/{id}', [perusaanController::class, 'updatePerusahaan'])->name('updatePerusahaan');
Route::delete('/deletePerusahaan/{id}', [perusaanController::class, 'deletePerusahaan'])->name('deletePerusahaan');




