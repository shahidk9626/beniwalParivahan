<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@beniwalparivahan.com'],
            [
                'name' => 'Super Admin',
                'password' => 'Admin@12345', // live karne se pehle badalna
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}