<?php

use App\Enums\StokStatus;
use App\Models\Bahan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok_kitchen', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Bahan::class)->constrained()->cascadeOnDelete();
            $table->integer('jumlah')->comment('Jumlah stok yang di inputkan didasar dari stok gudang');
            $table->timestamp('tanggal');
            $table->enum('status', [StokStatus::MINUS->value, StokStatus::PLUS->value]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_kitchen');
    }
};
