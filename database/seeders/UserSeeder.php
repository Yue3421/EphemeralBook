<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama dengan cara yang aman
        User::query()->delete();
        
        // Buat user baru
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ephemeral.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'staff@ephemeral.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '081234567891',
            'address' => 'Bandung',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'customer@ephemeral.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567892',
            'address' => 'Surabaya',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'Staff 2',
            'email' => 'staff2@ephemeral.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '081234567893',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'Customer 2',
            'email' => 'customer2@ephemeral.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567894',
            'address' => 'Yogyakarta',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin: admin@ephemeral.com / password');
        $this->command->info('Staff: staff@ephemeral.com / password');
        $this->command->info('Customer: customer@ephemeral.com / password');
    }
}
