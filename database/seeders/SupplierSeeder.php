<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'CV. Sumber Rejeki',
                'phone_number' => '0271-123456',
                'address' => 'Jl. Raya Solo-Yogya KM 12, Klaten',
            ],
            [
                'name' => 'UD. Maju Jaya',
                'phone_number' => '0271-789012',
                'address' => 'Jl. Pemuda No. 45, Solo',
            ],
            [
                'name' => 'PT. Berkah Mandiri',
                'phone_number' => '0274-345678',
                'address' => 'Jl. Malioboro No. 100, Yogyakarta',
            ],
            [
                'name' => 'Toko Grosir Sejahtera',
                'phone_number' => '0271-567890',
                'address' => 'Jl. Ahmad Yani No. 23, Surakarta',
            ],
            [
                'name' => 'CV. Barokah Abadi',
                'phone_number' => '0274-234567',
                'address' => 'Jl. Veteran No. 67, Yogyakarta',
            ],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }

        $this->command->info('Supplier dummy berhasil dibuat!');
    }
}
