<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Makanan Ringan',
            'Makanan Instan',
            'Minuman',
            'Susu & Produk Olahan Susu',
            'Sembako',
            'Bumbu Dapur & Rempah',
            'Makanan Segar',
            'Perlengkapan Rumah Tangga',
            'Produk Kebersihan Pribadi',
            'Perawatan Bayi',
            'Alat Tulis & Kantor',
            'Obat-obatan & Kesehatan',
            'Kosmetik & Perawatan Tubuh',
            'Kue & Roti',
            'Cemilan Tradisional',
            'Alat Masak',
            'Perlengkapan Laundry'
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name)
            ]);
        }

        $this->command->info('Kategori warung berhasil dibuat!');
    }
}
