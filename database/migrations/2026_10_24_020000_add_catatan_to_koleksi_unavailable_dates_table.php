<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catatan bebas untuk setiap blokir, misalnya nomor nota, nama acara,
     * atau keterangan kerusakan. Bersifat opsional dan berlaku untuk semua
     * alasan, tidak seperti atas_nama yang hanya untuk dipinjam dan disewa.
     */
    public function up(): void
    {
        Schema::table('koleksi_unavailable_dates', function (Blueprint $table) {
            $table->string('catatan', 255)->nullable()->after('atas_nama');
        });
    }

    public function down(): void
    {
        Schema::table('koleksi_unavailable_dates', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};
