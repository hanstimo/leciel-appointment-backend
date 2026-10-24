<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan keterangan alasan pada setiap tanggal yang diblokir.
     *
     * Nilai yang dipakai: dipinjam, diperbaiki, disewa, dijual.
     * Kolom dibuat nullable supaya baris yang sudah ada sebelum migrasi ini
     * tetap sah, dan ditampilkan sebagai tanda hubung pada panel admin.
     */
    public function up(): void
    {
        Schema::table('koleksi_unavailable_dates', function (Blueprint $table) {
            $table->string('alasan', 20)->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('koleksi_unavailable_dates', function (Blueprint $table) {
            $table->dropColumn('alasan');
        });
    }
};
