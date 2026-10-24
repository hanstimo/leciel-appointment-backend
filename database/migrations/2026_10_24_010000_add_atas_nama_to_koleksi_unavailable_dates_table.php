<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan nama pihak yang meminjam atau menyewa koleksi, supaya admin
     * dapat menelusuri keberadaan barang selama masa blokir.
     *
     * Hanya terisi untuk alasan dipinjam dan disewa; untuk diperbaiki dan
     * dijual kolom ini dibiarkan kosong.
     */
    public function up(): void
    {
        Schema::table('koleksi_unavailable_dates', function (Blueprint $table) {
            $table->string('atas_nama', 100)->nullable()->after('alasan');
        });
    }

    public function down(): void
    {
        Schema::table('koleksi_unavailable_dates', function (Blueprint $table) {
            $table->dropColumn('atas_nama');
        });
    }
};
