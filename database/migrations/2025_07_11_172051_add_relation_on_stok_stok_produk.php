<?php

use App\Models\Produk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stok_produk', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Produk::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_produk', function (Blueprint $table) {
            $table->foreignIdFor(Produk::class)->after('id')->constrained()->cascadeOnDelete();
        });
    }
};
