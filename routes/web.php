<?php

use App\Http\Controllers\AsesmenController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'home'])->name('home');

Route::get('/asesmen', [AsesmenController::class, 'index'])->name('asesmen');
Route::get('/asesmen/hasil', [AsesmenController::class, 'hasil'])->name('asesmen.hasil');
