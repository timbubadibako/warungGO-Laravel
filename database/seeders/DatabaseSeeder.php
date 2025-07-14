<?php
// database/seeders/DatabaseSeeder.php
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $kasirRole = Role::create(['name' => 'Kasir']);

        // Buat User Admin
        $adminUser = User::create([
            'name' => 'Admin Warung',
            'email' => 'admin@warunggo.com',
            'password' => bcrypt('password') // ganti dengan password aman
        ]);

        // Berikan role 'Admin' ke user tersebut
        $adminUser->assignRole($adminRole);
    }
}
