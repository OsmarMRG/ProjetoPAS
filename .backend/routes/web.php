<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;

Route::get('/', function () {
    return view('site.index');
})->name('site.index');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/area/camaras', [AreaController::class, 'camaras'])->name('area.camaras');
    Route::post('/area/camaras', [AreaController::class, 'guardarCamaras'])->name('area.camaras.guardar');
});
