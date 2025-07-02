<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StokGudangController;
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
    Route::get('bahan/select2', [BahanController::class, 'select2'])->name('bahan.select2');
    Route::resource('bahan', BahanController::class)
        ->names('bahan');
    Route::get('satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
    Route::get('satuan/select2', [SatuanController::class, 'select2'])->name('satuan.select2');
    Route::resource('satuan', SatuanController::class)
        ->names('satuan');
    Route::get('resep/data', [ResepController::class, 'data'])->name('resep.data');
    Route::get('resep/select2', [ResepController::class, 'select2'])->name('resep.select2');
    Route::resource('resep', ResepController::class)
        ->names('resep');
    Route::get('resep/{resep_id}/bahan', [ResepController::class, 'showBahan'])->name('resep.bahan');
    Route::post('resep/{resep_id}/bahan', [ResepController::class, 'storeBahan'])->name('resep.bahan.store');
    Route::put('resep/{resep_id}/bahan/{id}', [ResepController::class, 'updateBahan'])->name('resep.bahan.update');
    Route::delete('resep/{resep_id}/bahan/{id}', [ResepController::class, 'destroyBahan'])->name('resep.bahan.destroy');
});

Route::middleware(['auth'])->prefix("transaksi")->group(function () {
    Route::get('stok-gudang/data', [StokGudangController::class, 'data'])->name('stok-gudang.data');
    Route::get('stok-gudang/data-detail/{bahan_id}', [StokGudangController::class, 'dataDetail'])->name('stok-gudang.dataDetail');
    Route::get('stok-gudang/select2', [StokGudangController::class, 'select2'])->name('stok-gudang.select2');
    Route::resource('stok-gudang', StokGudangController::class)
        ->names('stok-gudang');
});
