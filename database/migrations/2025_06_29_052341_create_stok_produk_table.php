<?php

use App\Models\Produk;
use App\Models\Produksi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produksi::class);
            $table->foreignIdFor(Produk::class);
            $table->integer('jumlah');
            $table->string('keterangan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_produk');
    }
};
