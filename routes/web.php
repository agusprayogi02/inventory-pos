<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\SatuanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->prefix("master")->group(function () {
    Route::get('bahan/data', [BahanController::class, 'data'])->name('bahan.data');
    Route::resource('bahan', BahanController::class)
        ->names('bahan');
    Route::get('satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
    Route::get('satuan/select2', [SatuanController::class, 'select2'])->name('satuan.select2');
    Route::resource('satuan', SatuanController::class)
        ->names('satuan');
});
