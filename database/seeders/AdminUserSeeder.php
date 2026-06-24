<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email    = env('ADMIN_EMAIL', 'admin@qrhub.com');
        $password = env('ADMIN_PASSWORD', 'ChangeMe123!');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name'     => 'QRHub Admin',
                'password' => Hash::make($password),
            ]
        );

        $this->command->info("Admin user seeded: {$email}");
    }
}

