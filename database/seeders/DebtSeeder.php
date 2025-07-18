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
        // Ambil produk yang sudah ada
        $products = Product::all();
        
        // Ambil user untuk kasir
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Tidak ada produk atau user. Jalankan ProductSeeder dan UserSeeder terlebih dahulu.');
            return;
        }

        // Data pelanggan dummy
        $customers = [
            'Budi Santoso',
            'Siti Rahayu',
            'Ahmad Wijaya',
            'Dewi Lestari',
            'Andi Pratama',
            'Maya Sari',
            'Bambang Sutrisno',
            'Rina Wati',
        ];

        // Buat 8 transaksi hutang dummy
        for ($i = 1; $i <= 8; $i++) {
            $subTotal = 0;
            $customerName = $customers[array_rand($customers)];
            
            // Buat order dengan status debt
            $order = Order::create([
                'invoice_number' => 'DEBT-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => $users->random()->id,
                'order_type' => 'in_store',
                'sub_total' => 0, // akan diupdate setelah menambah items
                'tax' => 0,
                'delivery_fee' => 0,
                'total_amount' => 0, // akan diupdate
                'payment_method' => 'debt',
                'status' => 'debt',
                'customer_address' => null,
                'customer_notes' => 'Hutang untuk ' . $customerName,
                'created_at' => now()->subDays(rand(1, 45)), // 1-45 hari yang lalu
            ]);

            // Tambahkan 1-4 item per order
            $itemCount = rand(1, 4);
            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price;
                
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
                'total_amount' => $subTotal,
            ]);

            // Buat record debt
            Debt::create([
                'order_id' => $order->id,
                'customer_name' => $customerName,
                'amount' => $subTotal,
                'status' => 'unpaid',
                'created_at' => $order->created_at,
            ]);
        }

        $this->command->info('8 data hutang dummy berhasil dibuat!');
    }
}
