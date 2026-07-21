<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koleksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_koleksi');
            $table->string('kategori')->nullable(); // contoh: crown, necklace, earring, brooch, clutch
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // path/nama file foto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koleksis');
    }
};