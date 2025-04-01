<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'div@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123123123'),
                'is_admin' => true
            ]
        );
    }
}