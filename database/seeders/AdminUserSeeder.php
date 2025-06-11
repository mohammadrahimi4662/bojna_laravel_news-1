<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = $this->command->ask('Enter username');
        $email = $this->command->ask('Enter email');
        $password = $this->command->secret('Enter password'); // مخفی نمایش داده میشه

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($password),
            ]
        );

        $this->command->info('Admin user created/updated successfully.');
    }
}
