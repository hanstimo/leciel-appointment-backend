<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat akun admin awal dari environment variable.
 * Kredensial TIDAK disimpan di dalam kode karena repositori ini publik.
 * Set ADMIN_EMAIL dan ADMIN_PASSWORD pada environment sebelum deploy.
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
        if ($email = env('ADMIN_EMAIL')) {
            DB::table('users')->where('email', $email)->delete();
        }
    }
};
