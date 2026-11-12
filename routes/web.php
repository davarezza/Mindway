<?php

use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'home'])->name('home');

Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen');
Route::get('/asesmen/hasil', [AsesmenController::class, 'hasil'])->name('asesmen.hasil');
Route::get('/peta-kondisi', [PetaController::class, 'index'])->name('peta');
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
