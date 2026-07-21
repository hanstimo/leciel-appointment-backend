<?php

namespace Database\Seeders;

use App\Models\Koleksi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Crown' => [
                'deskripsi' => 'Koleksi mahkota eksklusif Le Ciel Design untuk momen spesial.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-crown-1-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-crown-2-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-crown-3-800x800.jpg',
                ],
            ],
            'Headband' => [
                'deskripsi' => 'Koleksi headband elegan dari Le Ciel Design.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-headband-1-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-headband-2-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2020/12/Le-Ciel-Collection-headband-3-800x800.jpg',
                ],
            ],
            'Necklace' => [
                'deskripsi' => 'Koleksi kalung signature dengan detail mewah dari Le Ciel Design.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-6-1-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-2-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-3-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-7-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-5-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-4-1-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-1-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Necklace-8-800x800.jpg',
                ],
            ],
            'Earring' => [
                'deskripsi' => 'Koleksi anting eksklusif dari Le Ciel Design.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2021/01/Le-Ciel-Collection-anting-1-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2021/01/Le-Ciel-Collection-anting-2-800x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2021/01/Le-Ciel-Collection-anting-3-800x800.jpg',
                ],
            ],
            'Brooch' => [
                'deskripsi' => 'Koleksi bros dengan desain elegan dari Le Ciel Design.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-1-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-4-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-2-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-3-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-5-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-6-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-8-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Brooch-7-600x800.jpg',
                ],
            ],
            'Oriental' => [
                'deskripsi' => 'Koleksi aksesori bergaya oriental dari Le Ciel Design.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-10-632x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-11-632x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-60-632x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-56-632x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Hairpiece-44-632x800.jpg',
                ],
            ],
            'Hand Piece' => [
                'deskripsi' => 'Koleksi hand piece mewah dari Le Ciel Design.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-15-632x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-13-632x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-16-632x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Handpiece-2-632x800.jpg',
                ],
            ],
            'Clutch' => [
                'deskripsi' => 'Koleksi clutch mewah untuk berbagai acara dari Le Ciel Design.',
                'foto' => [
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-2-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-3-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-7-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-6-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-8-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-4-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-5-600x800.jpg',
                    'https://lecieldesign.com/wp-content/uploads/2025/09/Clutch-1-600x800.jpg',
                ],
            ],
        ];

        foreach ($data as $kategori => $info) {
            foreach ($info['foto'] as $i => $foto) {
                Koleksi::create([
                    'nama_koleksi' => $kategori . ' ' . ($i + 1),
                    'kategori' => $kategori,
                    'deskripsi' => $info['deskripsi'],
                    'foto' => $foto,
                ]);
            }
        }
    }
}