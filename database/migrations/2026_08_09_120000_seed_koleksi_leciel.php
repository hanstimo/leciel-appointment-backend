<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $data = [
        'Crown' => ['Koleksi mahkota eksklusif Le Ciel Design untuk momen istimewa.', [
            'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-crown-1-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-crown-2-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-crown-3-800x800.jpg',
        ]],
        'Headband' => ['Koleksi headband elegan dengan detail rancangan tangan.', [
            'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-headband-1-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-headband-2-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-headband-3-800x800.jpg',
        ]],
        'Necklace' => ['Koleksi kalung signature dengan detail mewah.', [
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-6-1-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-2-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-3-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-7-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-5-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-4-1-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-1-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-8-800x800.jpg',
        ]],
        'Earring' => ['Koleksi anting eksklusif untuk melengkapi penampilan.', [
            'https://lecieldesign.com/wp-content/uploads/2021/01/Le-Ciel-Collection-anting-1-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2021/01/Le-Ciel-Collection-anting-2-800x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2021/01/Le-Ciel-Collection-anting-3-800x800.jpg',
        ]],
        'Brooch' => ['Koleksi bros dengan desain elegan dan detail halus.', [
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-1-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-4-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-2-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-3-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-5-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-6-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-8-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-7-600x800.jpg',
        ]],
        'Oriental' => ['Koleksi hairpiece bergaya oriental yang anggun.', [
            'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-10-632x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-11-632x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-60-632x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-56-632x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-44-632x800.jpg',
        ]],
        'Hand Piece' => ['Koleksi hand piece mewah untuk acara formal.', [
            'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-15-632x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-13-632x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-16-632x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-2-632x800.jpg',
        ]],
        'Clutch' => ['Koleksi clutch mewah untuk berbagai acara.', [
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-2-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-3-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-7-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-6-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-8-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-4-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-5-600x800.jpg',
            'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-1-600x800.jpg',
        ]],
    ];

    public function up(): void
    {
        if (DB::table('koleksis')->count() > 0) {
            return;
        }

        $now = now();
        $rows = [];

        foreach ($this->data as $kategori => [$deskripsi, $fotos]) {
            foreach ($fotos as $i => $foto) {
                $rows[] = [
                    'nama_koleksi' => $kategori . ' ' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
                    'kategori' => $kategori,
                    'deskripsi' => $deskripsi,
                    'foto' => $foto,
                    'tersedia' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('koleksis')->insert($rows);
    }

    public function down(): void
    {
        DB::table('koleksis')->truncate();
    }
};
