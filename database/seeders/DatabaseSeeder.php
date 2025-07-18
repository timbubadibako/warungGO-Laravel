<?php
// database/seeders/DatabaseSeeder.php
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Roles jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $kasirRole = Role::firstOrCreate(['name' => 'Kasir']);

        // Buat User Admin jika belum ada
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@warunggo.com'],
            [
                'name' => 'Admin Warung',
                'password' => bcrypt('password') // ganti dengan password aman
            ]
        );

        // Berikan role 'Admin' ke user tersebut jika belum punya
        if (!$adminUser->hasRole('Admin')) {
            $adminUser->assignRole($adminRole);
        }
    }
}
