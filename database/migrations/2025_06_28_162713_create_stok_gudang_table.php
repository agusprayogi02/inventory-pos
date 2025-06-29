<?php

use App\Enums\StokStatus;
use App\Models\Bahan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stok_gudang', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Bahan::class);
            $table->foreignIdFor(User::class);
            $table->integer('jumlah');
            $table->timestamp('tanggal');
            $table->enum('status', [StokStatus::MINUS->value, StokStatus::PLUS->value]);
            $table->string('keterangan');
            $table->date('exp_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_gudang');
    }
};
