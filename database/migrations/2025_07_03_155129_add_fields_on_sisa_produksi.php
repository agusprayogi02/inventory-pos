<?php

use App\Enums\StatusSisaProduksi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sisa_produksi', function (Blueprint $table) {
            $table->enum('status', [
                StatusSisaProduksi::BAIK->value,
                StatusSisaProduksi::RUSAK->value,
                StatusSisaProduksi::KEDALUARSA->value,
                StatusSisaProduksi::KECIL->value,
                StatusSisaProduksi::BESAR->value,
            ])->after('jumlah');
            $table->string('keterangan')->nullable()->after('status');
            $table->date('tanggal')->nullable()->after('produk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sisa_produksi', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('keterangan');
            $table->dropColumn('tanggal');
        });
    }
};
