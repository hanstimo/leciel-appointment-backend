<php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat akun admin dari environment variable.
 * Migrasi sebelumnya sempat berjalan saat ADMIN_EMAIL belum diisi,
 * sehingga tercatat selesai tanpa membuat akun apa pun.
 * Kredensial TIDAK disimpan di dalam kode karena repositori ini publik.
 */
return new class extends Migration
{
    public function up(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            return;
        }

        if (DB::table('users')->where('email', $email)->exists()) {
            return;
        }

        DB::table('users')->insert([
            'name' => env('ADMIN_NAME', 'Admin Le Ciel'),
            'email' => $email,
            'password' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // sengaja dikosongkan agar akun admin tidak ikut terhapus saat rollback
    }
};
