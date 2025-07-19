<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Mapping: kategori => daftar produk
        $productsData = [
            'Makanan Ringan' => [
                [
                    'name' => 'Chitato Sapi Panggang 68g',
                    'purchase_price' => 8500,
                    'selling_price' => 10000,
                    'stock' => 20,
                    'description' => 'Keripik kentang rasa sapi panggang, renyah dan gurih.',
                ],
                [
                    'name' => 'Taro Net Seaweed 60g',
                    'purchase_price' => 8000,
                    'selling_price' => 9500,
                    'stock' => 16,
                    'description' => 'Snack rasa rumput laut favorit anak-anak.',
                ],
                [
                    'name' => 'Qtela Tempe Original 55g',
                    'purchase_price' => 7000,
                    'selling_price' => 8500,
                    'stock' => 25,
                    'description' => 'Keripik tempe original, camilan tradisional kekinian.',
                ],
            ],
            'Makanan Instan' => [
                [
                    'name' => 'Indomie Goreng 85g',
                    'purchase_price' => 3000,
                    'selling_price' => 3500,
                    'stock' => 50,
                    'description' => 'Mi instan goreng rasa original, praktis dan lezat.',
                ],
                [
                    'name' => 'Sarimi Isi 2 Ayam Kecap',
                    'purchase_price' => 3500,
                    'selling_price' => 4000,
                    'stock' => 40,
                    'description' => 'Mi instan isi 2 rasa ayam kecap, lebih hemat.',
                ],
                [
                    'name' => 'Pop Mie Rasa Ayam Bawang',
                    'purchase_price' => 5500,
                    'selling_price' => 6500,
                    'stock' => 18,
                    'description' => 'Mi instan cup rasa ayam bawang, cocok untuk perjalanan.',
                ],
            ],
            'Minuman' => [
                [
                    'name' => 'Aqua Botol 600ml',
                    'purchase_price' => 3500,
                    'selling_price' => 5000,
                    'stock' => 60,
                    'description' => 'Air mineral kemasan botol 600ml.',
                ],
                [
                    'name' => 'Teh Pucuk Harum 350ml',
                    'purchase_price' => 3500,
                    'selling_price' => 5000,
                    'stock' => 30,
                    'description' => 'Minuman teh manis siap minum, botol 350ml.',
                ],
                [
                    'name' => 'Coca-Cola Kaleng 330ml',
                    'purchase_price' => 6000,
                    'selling_price' => 7500,
                    'stock' => 24,
                    'description' => 'Minuman bersoda kaleng, segar diminum dingin.',
                ],
            ],
            'Susu & Produk Olahan Susu' => [
                [
                    'name' => 'Ultra Milk Coklat 250ml',
                    'purchase_price' => 6000,
                    'selling_price' => 7500,
                    'stock' => 18,
                    'description' => 'Susu UHT rasa coklat kemasan kotak.',
                ],
                [
                    'name' => 'Indomilk Kids Vanila 115ml',
                    'purchase_price' => 3500,
                    'selling_price' => 4500,
                    'stock' => 20,
                    'description' => 'Susu cair untuk anak rasa vanila.',
                ],
                [
                    'name' => 'Yakult 5Pcs',
                    'purchase_price' => 11000,
                    'selling_price' => 12500,
                    'stock' => 10,
                    'description' => 'Minuman probiotik isi 5 botol kecil.',
                ],
            ],
            'Sembako' => [
                [
                    'name' => 'Beras Ramos 5Kg',
                    'purchase_price' => 65000,
                    'selling_price' => 70000,
                    'stock' => 6,
                    'description' => 'Beras pulen kemasan 5 kilogram.',
                ],
                [
                    'name' => 'Minyak Goreng Bimoli 1L',
                    'purchase_price' => 18000,
                    'selling_price' => 20000,
                    'stock' => 20,
                    'description' => 'Minyak goreng sawit kemasan 1 liter.',
                ],
                [
                    'name' => 'Gula Pasir Gulaku 1Kg',
                    'purchase_price' => 13500,
                    'selling_price' => 15000,
                    'stock' => 15,
                    'description' => 'Gula pasir kemasan 1 kilogram.',
                ],
            ],
            'Bumbu Dapur & Rempah' => [
                [
                    'name' => 'Royco Ayam 230g',
                    'purchase_price' => 9000,
                    'selling_price' => 11000,
                    'stock' => 10,
                    'description' => 'Penyedap rasa ayam kemasan 230 gram.',
                ],
                [
                    'name' => 'Kecap ABC Manis 135ml',
                    'purchase_price' => 6000,
                    'selling_price' => 8000,
                    'stock' => 12,
                    'description' => 'Kecap manis botol kecil.',
                ],
                [
                    'name' => 'Sasa Tepung Bumbu 210g',
                    'purchase_price' => 6000,
                    'selling_price' => 7500,
                    'stock' => 8,
                    'description' => 'Tepung bumbu serba guna kemasan 210 gram.',
                ],
            ],
            'Makanan Segar' => [
                [
                    'name' => 'Telur Ayam 1kg (±15 butir)',
                    'purchase_price' => 27000,
                    'selling_price' => 30000,
                    'stock' => 5,
                    'description' => 'Telur ayam negeri segar per kilogram.',
                ],
                [
                    'name' => 'Tomat 500g',
                    'purchase_price' => 6000,
                    'selling_price' => 7500,
                    'stock' => 7,
                    'description' => 'Tomat segar kemasan 500 gram.',
                ],
                [
                    'name' => 'Cabe Rawit 250g',
                    'purchase_price' => 9000,
                    'selling_price' => 11000,
                    'stock' => 4,
                    'description' => 'Cabe rawit segar kemasan 250 gram.',
                ],
            ],
            'Perlengkapan Rumah Tangga' => [
                [
                    'name' => 'Sapu Ijuk',
                    'purchase_price' => 14000,
                    'selling_price' => 17000,
                    'stock' => 8,
                    'description' => 'Sapu ijuk untuk rumah tangga.',
                ],
                [
                    'name' => 'Ember Plastik 15L',
                    'purchase_price' => 12000,
                    'selling_price' => 15000,
                    'stock' => 6,
                    'description' => 'Ember plastik besar kapasitas 15 liter.',
                ],
                [
                    'name' => 'Lap Pel Microfiber',
                    'purchase_price' => 9000,
                    'selling_price' => 12000,
                    'stock' => 10,
                    'description' => 'Lap pel lantai dari microfiber.',
                ],
            ],
            'Produk Kebersihan Pribadi' => [
                [
                    'name' => 'Lifebuoy Sabun Cair 450ml',
                    'purchase_price' => 18000,
                    'selling_price' => 21000,
                    'stock' => 10,
                    'description' => 'Sabun cair untuk mandi, kemasan refill.',
                ],
                [
                    'name' => 'Pepsodent Pasta Gigi 190g',
                    'purchase_price' => 13500,
                    'selling_price' => 15500,
                    'stock' => 15,
                    'description' => 'Pasta gigi keluarga kemasan besar.',
                ],
                [
                    'name' => 'Shampo Clear 170ml',
                    'purchase_price' => 18000,
                    'selling_price' => 21000,
                    'stock' => 12,
                    'description' => 'Shampo anti ketombe kemasan 170ml.',
                ],
            ],
            'Perawatan Bayi' => [
                [
                    'name' => 'Sweety Silver Pants M34',
                    'purchase_price' => 56000,
                    'selling_price' => 60000,
                    'stock' => 5,
                    'description' => 'Popok bayi tipe celana size M isi 34.',
                ],
                [
                    'name' => 'Cussons Baby Powder 100g',
                    'purchase_price' => 9000,
                    'selling_price' => 11000,
                    'stock' => 7,
                    'description' => 'Bedak bayi lembut kemasan 100 gram.',
                ],
                [
                    'name' => 'Johnson\'s Baby Shampoo 100ml',
                    'purchase_price' => 12000,
                    'selling_price' => 14500,
                    'stock' => 8,
                    'description' => 'Shampo bayi lembut kemasan 100ml.',
                ],
            ],
            'Alat Tulis & Kantor' => [
                [
                    'name' => 'Buku Tulis Sidu 38 Lembar',
                    'purchase_price' => 3500,
                    'selling_price' => 4000,
                    'stock' => 30,
                    'description' => 'Buku tulis Sidu isi 38 lembar.',
                ],
                [
                    'name' => 'Bolpoin Standard AE-7',
                    'purchase_price' => 2500,
                    'selling_price' => 3000,
                    'stock' => 50,
                    'description' => 'Pulpen biru Standard AE-7.',
                ],
                [
                    'name' => 'Pensil 2B Faber Castell',
                    'purchase_price' => 2500,
                    'selling_price' => 3500,
                    'stock' => 40,
                    'description' => 'Pensil 2B untuk ujian atau menggambar.',
                ],
            ],
            'Obat-obatan & Kesehatan' => [
                [
                    'name' => 'Paracetamol 500mg Strip',
                    'purchase_price' => 4000,
                    'selling_price' => 6000,
                    'stock' => 20,
                    'description' => 'Obat penurun panas isi 10 tablet.',
                ],
                [
                    'name' => 'Antangin JRG Sachet',
                    'purchase_price' => 2500,
                    'selling_price' => 3500,
                    'stock' => 25,
                    'description' => 'Obat herbal masuk angin dalam bentuk sachet.',
                ],
                [
                    'name' => 'Hansaplast 10pcs',
                    'purchase_price' => 9000,
                    'selling_price' => 12000,
                    'stock' => 7,
                    'description' => 'Plester luka isi 10 lembar.',
                ],
            ],
            'Kosmetik & Perawatan Tubuh' => [
                [
                    'name' => 'Wardah Lightening Face Powder',
                    'purchase_price' => 32000,
                    'selling_price' => 38000,
                    'stock' => 4,
                    'description' => 'Bedak wajah ringan dari Wardah.',
                ],
                [
                    'name' => 'Viva Face Tonic 100ml',
                    'purchase_price' => 7000,
                    'selling_price' => 9500,
                    'stock' => 6,
                    'description' => 'Toner wajah klasik dari Viva.',
                ],
                [
                    'name' => 'Pond\'s Men Energy Charge 50g',
                    'purchase_price' => 21000,
                    'selling_price' => 25000,
                    'stock' => 5,
                    'description' => 'Facial foam pria untuk kulit segar.',
                ],
            ],
            'Kue & Roti' => [
                [
                    'name' => 'Sari Roti Tawar 200g',
                    'purchase_price' => 9500,
                    'selling_price' => 12000,
                    'stock' => 12,
                    'description' => 'Roti tawar kemasan 200 gram.',
                ],
                [
                    'name' => 'Roma Biskuit Kelapa 300g',
                    'purchase_price' => 12000,
                    'selling_price' => 15000,
                    'stock' => 10,
                    'description' => 'Biskuit kelapa klasik dari Roma.',
                ],
                [
                    'name' => 'Amanda Brownies Kukus Mini',
                    'purchase_price' => 15000,
                    'selling_price' => 18000,
                    'stock' => 8,
                    'description' => 'Brownies kukus mini, cemilan khas Bandung.',
                ],
            ],
            'Cemilan Tradisional' => [
                [
                    'name' => 'Opak Singkong 150g',
                    'purchase_price' => 6000,
                    'selling_price' => 8000,
                    'stock' => 13,
                    'description' => 'Cemilan opak singkong tradisional renyah.',
                ],
                [
                    'name' => 'Krupuk Udang 200g',
                    'purchase_price' => 10000,
                    'selling_price' => 13000,
                    'stock' => 10,
                    'description' => 'Krupuk udang asli kemasan 200 gram.',
                ],
                [
                    'name' => 'Rempeyek Kacang 100g',
                    'purchase_price' => 9000,
                    'selling_price' => 12000,
                    'stock' => 8,
                    'description' => 'Rempeyek kacang gurih dan renyah.',
                ],
            ],
            'Alat Masak' => [
                [
                    'name' => 'Sendok Stainless 12pcs',
                    'purchase_price' => 18000,
                    'selling_price' => 21000,
                    'stock' => 6,
                    'description' => 'Sendok makan stainless isi 12 buah.',
                ],
                [
                    'name' => 'Wajan Penggorengan 24cm',
                    'purchase_price' => 37000,
                    'selling_price' => 42000,
                    'stock' => 4,
                    'description' => 'Wajan penggorengan diameter 24cm.',
                ],
                [
                    'name' => 'Sutil Kayu',
                    'purchase_price' => 5000,
                    'selling_price' => 7000,
                    'stock' => 10,
                    'description' => 'Sutil kayu untuk memasak.',
                ],
            ],
            'Perlengkapan Laundry' => [
                [
                    'name' => 'Rinso Deterjen Cair 800ml',
                    'purchase_price' => 14000,
                    'selling_price' => 17000,
                    'stock' => 11,
                    'description' => 'Deterjen cair kemasan 800ml.',
                ],
                [
                    'name' => 'So Klin Pewangi 800ml',
                    'purchase_price' => 12000,
                    'selling_price' => 15000,
                    'stock' => 12,
                    'description' => 'Pewangi pakaian kemasan 800ml.',
                ],
                [
                    'name' => 'Sunlight Jeruk Nipis 210ml',
                    'purchase_price' => 9000,
                    'selling_price' => 12000,
                    'stock' => 13,
                    'description' => 'Sabun cuci piring Sunlight isi 210ml.',
                ],
            ],
        ];

        $barcodeBase = 1000000000000; // 13 digit dummy barcode

        foreach ($productsData as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->first();
            if (!$category) continue;

            foreach ($items as $i => $item) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'barcode' => (string)($barcodeBase + rand(10000, 99999) + $i),
                    'description' => $item['description'],
                    'image' => null, // Atur sesuai kebutuhan atau ganti dengan nama file gambar dummy
                    'purchase_price' => $item['purchase_price'],
                    'selling_price' => $item['selling_price'],
                    'stock' => $item['stock'],
                ]);
            }
        }

        $this->command->info('Produk warung berhasil dibuat!');
    }
}
