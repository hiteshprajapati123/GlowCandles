<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@GlowCandles.in',
            'email_verified_at' => now(),
            'password' => bcrypt('Reset@123'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone' => '1234567890',
            'is_active' => true,
            'is_verified' => true,
            'is_banned' => false,
            'last_login_at' => now(),
            'last_login_ip' => '127.0.0.1',
            'timezone' => 'Asia/Kolkata',
            'locale' => 'en',
            'currency' => 'INR'
        ]);

        $this->call([
            AboutPageSeeder::class,
            ShippingPolicyPageSeeder::class,
            PrivacyPolicyPageSeeder::class,
            ContactPageSeeder::class,
        ]);
    }
}
