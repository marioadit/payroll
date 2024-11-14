<?php
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [PageController::class, 'home']);
Route::get('/paymentaccount', [PageController::class, 'pa']);
Route::get('/workerdata', [PageController::class, 'worker']);
Route::get('/transaction', [PageController::class, 'transaction']);
Route::get('/logbook', [PageController::class, 'logbook']);
Route::get('/admin', [PageController::class, 'admin']);


