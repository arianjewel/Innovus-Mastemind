<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@innovus.com.bd'],
            [
                'name' => 'Site Administrator',
                'password' => Hash::make('Innovus@2026'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
