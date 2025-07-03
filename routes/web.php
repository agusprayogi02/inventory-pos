<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StokGudangController;
use App\Http\Controllers\StokKitchenController;
use App\Http\Controllers\StokProdukController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
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
    Route::get('produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::get('produk/select2', [ProdukController::class, 'select2'])->name('produk.select2');
    Route::resource('produk', ProdukController::class)
        ->names('produk');
});

Route::middleware(['auth'])->prefix("transaksi")->group(function () {
    Route::get('stok-gudang/data', [StokGudangController::class, 'data'])->name('stok-gudang.data');
    Route::get('stok-gudang/data-detail/{bahan_id}', [StokGudangController::class, 'dataDetail'])->name('stok-gudang.dataDetail');
    Route::get('stok-gudang/select2', [StokGudangController::class, 'select2'])->name('stok-gudang.select2');
    Route::resource('stok-gudang', StokGudangController::class)
        ->names('stok-gudang');

    // stok kitchen
    Route::get('stok-kitchen/data', [StokKitchenController::class, 'data'])->name('stok-kitchen.data');
    Route::get('stok-kitchen/select2', [StokKitchenController::class, 'select2'])->name('stok-kitchen.select2');
    Route::resource('stok-kitchen', StokKitchenController::class)
        ->names('stok-kitchen');

    // stok produk
    Route::get('stok-produk/data', [StokProdukController::class, 'data'])->name('stok-produk.data');
    Route::get('stok-produk/select2', [StokProdukController::class, 'select2'])->name('stok-produk.select2');
    Route::resource('stok-produk', StokProdukController::class)
        ->names('stok-produk');
});

Route::middleware(['auth'])->prefix("produksi")->group(function () {
    Route::get('hasil-produksi/data', [ProduksiController::class, 'data'])->name('produksi.data');
    Route::get('hasil-produksi/select2', [ProduksiController::class, 'select2'])->name('produksi.select2');
    Route::post('hasil-produksi/{id}/stok', [ProduksiController::class, 'storeStokProduk'])->name('produksi.stok.store');
    Route::get('hasil-produksi/{id}/stok/data', [ProduksiController::class, 'dataStokProduk'])->name('produksi.stok.data');
    Route::resource('hasil-produksi', ProduksiController::class)
        ->names('produksi');
});
