<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koleksi_unavailable_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koleksi_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->timestamps();
            $table->unique(['koleksi_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksi_unavailable_dates');
    }
};