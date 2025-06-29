<?php

use App\Models\Resep;
use App\Models\Satuan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Resep::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Satuan::class)->constrained()->cascadeOnDelete();
            $table->string('nama', 150);
            $table->integer('isi');
            $table->integer('jumlah');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
