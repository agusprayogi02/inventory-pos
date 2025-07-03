<?php

use App\Models\StokGudang;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stok_kitchen', function (Blueprint $table) {
            $table->foreignIdFor(StokGudang::class)->after('bahan_id')
                ->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_kitchen', function (Blueprint $table) {
            $table->dropForeign(['stok_gudang_id']);
            $table->dropColumn('stok_gudang_id');
        });
    }
};
