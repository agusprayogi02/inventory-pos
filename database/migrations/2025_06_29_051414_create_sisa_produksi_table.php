<?php

use App\Models\Produk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sisa_produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produk::class)->constrained()->cascadeOnDelete();
            $table->integer('jumlah');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sisa_produksi');
    }
};
