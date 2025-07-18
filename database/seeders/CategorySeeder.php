<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan Ringan', 'description' => 'Aneka makanan ringan dan snack'],
            ['name' => 'Minuman', 'description' => 'Berbagai jenis minuman segar'],
            ['name' => 'Bumbu Dapur', 'description' => 'Bumbu dan bahan masakan'],
            ['name' => 'Peralatan Rumah Tangga', 'description' => 'Perlengkapan rumah tangga sehari-hari'],
            ['name' => 'Sembako', 'description' => 'Kebutuhan pokok dan sembilan bahan pokok'],
            ['name' => 'Alat Tulis', 'description' => 'Perlengkapan sekolah dan kantor'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Kategori berhasil dibuat!');
    }
}
