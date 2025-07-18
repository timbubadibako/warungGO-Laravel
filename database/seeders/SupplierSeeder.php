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
                'email' => 'info@sumberrejeki.com',
                'phone' => '0271-123456',
                'address' => 'Jl. Raya Solo-Yogya KM 12, Klaten',
                'contact_person' => 'Bapak Slamet',
            ],
            [
                'name' => 'UD. Maju Jaya',
                'email' => 'majujaya@gmail.com',
                'phone' => '0271-789012',
                'address' => 'Jl. Pemuda No. 45, Solo',
                'contact_person' => 'Ibu Siti',
            ],
            [
                'name' => 'PT. Berkah Mandiri',
                'email' => 'berkah@mandiri.co.id',
                'phone' => '0274-345678',
                'address' => 'Jl. Malioboro No. 100, Yogyakarta',
                'contact_person' => 'Bapak Wahyu',
            ],
            [
                'name' => 'Toko Grosir Sejahtera',
                'email' => 'sejahtera.grosir@yahoo.com',
                'phone' => '0271-567890',
                'address' => 'Jl. Ahmad Yani No. 23, Surakarta',
                'contact_person' => 'Bapak Agus',
            ],
            [
                'name' => 'CV. Barokah Abadi',
                'email' => 'barokah.abadi@outlook.com',
                'phone' => '0274-234567',
                'address' => 'Jl. Veteran No. 67, Yogyakarta',
                'contact_person' => 'Ibu Dewi',
            ],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }

        $this->command->info('Supplier dummy berhasil dibuat!');
    }
}
