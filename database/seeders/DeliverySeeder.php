<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        // Ambil produk dan user
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Tidak ada produk atau user. Jalankan ProductSeeder dan UserSeeder terlebih dahulu.');
            return;
        }

        // Alamat dan catatan delivery dummy
        $addresses = [
            'Jl. Mangga No. 10, RT 01 RW 01, Kelurahan Sumber Jaya',
            'Jl. Salak No. 2, RT 02 RW 01, Kelurahan Sumber Jaya',
            'Jl. Pisang No. 5, RT 03 RW 02, Kelurahan Sumber Jaya',
            'Jl. Durian No. 18, RT 04 RW 02, Kelurahan Sumber Jaya',
            'Jl. Rambutan No. 7, RT 05 RW 03, Kelurahan Sumber Jaya',
            'Jl. Melon No. 22, RT 06 RW 03, Kelurahan Sumber Jaya',
        ];

        $customerNotes = [
            'Tolong antar sebelum jam 12 siang.',
            'Rumah pagar biru, depan masjid.',
            'Mohon telepon sebelum sampai.',
            'Titip ke warung sebelah jika saya tidak di rumah.',
            'Rumah di pojok gang, ada tanaman rambat.',
            null,
        ];

        $deliveryStatuses = ['pending', 'preparing', 'out_for_delivery', 'delivered'];

        // Buat 10 pesanan delivery dummy
        for ($i = 1; $i <= 10; $i++) {
            $subTotal = 0;
            $deliveryFee = rand(5, 12) * 1000; // 5k - 12k ongkir

            // Buat order
            $order = Order::create([
                'invoice_number' => 'DLV-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => $users->random()->id,
                'order_type' => 'delivery',
                'sub_total' => 0, // akan diupdate
                'tax' => 0,
                'delivery_fee' => $deliveryFee,
                'total_amount' => 0, // akan diupdate
                'payment_method' => collect(['cash', 'qris'])->random(),
                'status' => 'paid',
                'delivery_status' => collect($deliveryStatuses)->random(),
                'customer_address' => $addresses[array_rand($addresses)],
                'customer_notes' => $customerNotes[array_rand($customerNotes)],
                'created_at' => now()->subHours(rand(1, 48)), // 1-48 jam yang lalu
            ]);

            // Ambil kategori warung (sesuai ProductSeeder kategori)
            $categories = [
                'Makanan Ringan', 'Minuman', 'Makanan Instan', 'Sembako', 'Bumbu Dapur & Rempah',
                'Perlengkapan Rumah Tangga', 'Produk Kebersihan Pribadi', 'Kue & Roti', 'Cemilan Tradisional'
            ];

            // Tambahkan 2-5 item per order (acak kategori warung)
            $itemCount = rand(2, 5);
            $usedProductIds = [];
            for ($j = 0; $j < $itemCount; $j++) {
                // Cari produk random dari kategori warung
                $categoryProducts = $products->whereIn('category_id',
                    \App\Models\Category::whereIn('name', $categories)->pluck('id')->toArray()
                );
                $product = $categoryProducts->whereNotIn('id', $usedProductIds)->random();
                $usedProductIds[] = $product->id;

                $quantity = rand(1, 3);
                $price = $product->selling_price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $subTotal += $quantity * $price;
            }

            // Update total order
            $order->update([
                'sub_total' => $subTotal,
                'total_amount' => $subTotal + $deliveryFee,
            ]);
        }

        $this->command->info('10 pesanan delivery dummy khas warung berhasil dibuat!');
    }
}
