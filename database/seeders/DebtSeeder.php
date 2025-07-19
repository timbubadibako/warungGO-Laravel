<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Debt;
use Illuminate\Database\Seeder;

class DebtSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua produk dan user
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Tidak ada produk atau user. Jalankan ProductSeeder dan UserSeeder terlebih dahulu.');
            return;
        }

        // Data pelanggan hutang (dummy)
        $customers = [
            'Budi Santoso',
            'Siti Rahayu',
            'Ahmad Wijaya',
            'Dewi Lestari',
            'Andi Pratama',
            'Maya Sari',
            'Bambang Sutrisno',
            'Rina Wati',
            'Yusuf Hidayat',
            'Linda Permata'
        ];

        // Buat 10 transaksi hutang dummy
        for ($i = 1; $i <= 10; $i++) {
            $subTotal = 0;
            $customerName = $customers[$i-1];

            $order = Order::create([
                'invoice_number' => 'DEBT-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => $users->random()->id,
                'order_type' => 'in_store',
                'sub_total' => 0,
                'tax' => 0,
                'delivery_fee' => 0,
                'total_amount' => 0,
                'payment_method' => 'debt',
                'status' => 'debt',
                'customer_address' => null,
                'customer_notes' => 'Hutang atas nama ' . $customerName,
                'created_at' => now()->subDays(rand(1, 45)),
            ]);

            // 2-5 item unik per order
            $itemCount = rand(2, 5);
            $usedProductIds = [];
            for ($j = 0; $j < $itemCount; $j++) {
                $availableProducts = $products->whereNotIn('id', $usedProductIds);
                if ($availableProducts->isEmpty()) break;
                $product = $availableProducts->random();
                $usedProductIds[] = $product->id;

                $quantity = rand(1, 3);
                $price = property_exists($product, 'selling_price') ? $product->selling_price : $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $subTotal += $quantity * $price;
            }

            // Update order total
            $order->update([
                'sub_total' => $subTotal,
                'total_amount' => $subTotal,
            ]);

            // Buat record hutang
            Debt::create([
                'order_id' => $order->id,
                'customer_name' => $customerName,
                'amount' => $subTotal,
                'status' => 'unpaid',
                'created_at' => $order->created_at,
            ]);
        }

        $this->command->info('10 data hutang dummy berhasil dibuat!');
    }
}
