<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('Tidak ada kategori. Jalankan CategorySeeder terlebih dahulu.');
            return;
        }

        $products = [
            // Makanan Ringan
            ['name' => 'Keripik Kentang', 'price' => 8000, 'stock' => 50, 'category' => 'Makanan Ringan'],
            ['name' => 'Biskuit Marie', 'price' => 5000, 'stock' => 30, 'category' => 'Makanan Ringan'],
            ['name' => 'Kacang Garuda', 'price' => 12000, 'stock' => 25, 'category' => 'Makanan Ringan'],
            ['name' => 'Wafer Coklat', 'price' => 3000, 'stock' => 40, 'category' => 'Makanan Ringan'],

            // Minuman
            ['name' => 'Air Mineral 600ml', 'price' => 3000, 'stock' => 100, 'category' => 'Minuman'],
            ['name' => 'Teh Kotak', 'price' => 4500, 'stock' => 50, 'category' => 'Minuman'],
            ['name' => 'Kopi Kapal Api', 'price' => 2500, 'stock' => 60, 'category' => 'Minuman'],
            ['name' => 'Susu UHT 250ml', 'price' => 6000, 'stock' => 35, 'category' => 'Minuman'],

            // Bumbu Dapur
            ['name' => 'Garam Beryodium 500g', 'price' => 3500, 'stock' => 20, 'category' => 'Bumbu Dapur'],
            ['name' => 'Gula Pasir 1kg', 'price' => 16000, 'stock' => 15, 'category' => 'Bumbu Dapur'],
            ['name' => 'Minyak Goreng 1L', 'price' => 18000, 'stock' => 12, 'category' => 'Bumbu Dapur'],
            ['name' => 'Kecap Manis ABC', 'price' => 8500, 'stock' => 18, 'category' => 'Bumbu Dapur'],

            // Peralatan Rumah Tangga
            ['name' => 'Sabun Cuci Piring', 'price' => 7500, 'stock' => 25, 'category' => 'Peralatan Rumah Tangga'],
            ['name' => 'Sabun Mandi Lifebuoy', 'price' => 4000, 'stock' => 30, 'category' => 'Peralatan Rumah Tangga'],
            ['name' => 'Deterjen Bubuk', 'price' => 12000, 'stock' => 20, 'category' => 'Peralatan Rumah Tangga'],
            ['name' => 'Tisu Wajah', 'price' => 15000, 'stock' => 15, 'category' => 'Peralatan Rumah Tangga'],
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();

            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'category_id' => $category->id,
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'min_stock' => 5,
                    'description' => 'Produk berkualitas untuk kebutuhan sehari-hari',
                ]);
            }
        }

        $this->command->info('Produk dummy berhasil dibuat!');
    }
}
