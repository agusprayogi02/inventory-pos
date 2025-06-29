<?php

use App\Models\Bahan;
use App\Models\Resep;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resep_bahan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Resep::class);
            $table->foreignIdFor(Bahan::class);
            $table->integer('jumlah');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_bahan');
    }
};
