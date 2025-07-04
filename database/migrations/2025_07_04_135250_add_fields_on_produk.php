<?php

use App\Models\Satuan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->foreignIdFor(Satuan::class, 'satuan_produk_id')
                ->nullable()->after('satuan_id')
                ->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['satuan_produk_id']);
            $table->dropColumn('satuan_produk_id');
        });
    }
};
