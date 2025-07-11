<?php

use App\Models\Produk;
use App\Models\Resep;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produksi', function (Blueprint $table) {
            $table->foreignIdFor(Produk::class)->after('id')->constrained()->cascadeOnDelete();
            $table->dropConstrainedForeignIdFor(Resep::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produksi', function (Blueprint $table) {
            $table->foreignIdFor(Resep::class)->after('id')->constrained()->cascadeOnDelete();
            $table->dropConstrainedForeignIdFor(Produk::class);
        });
    }
};
