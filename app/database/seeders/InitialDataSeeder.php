<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'balance_aed' => 50.00,
        ]);

        \App\Models\Task::create([
            'title' => 'Follow @instagram',
            'description' => 'Go to the Instagram profile and follow the account.',
            'reward_aed' => 10.00,
            'instagram_url' => 'https://www.instagram.com/instagram/',
            'type' => 'follow',
        ]);

        \App\Models\AccessCode::create([
            'code' => 'ABC-123',
            'status' => 'active',
            'user_id' => $user->id,
            'expires_at' => now()->addDays(7),
        ]);
    }
}
