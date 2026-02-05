<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discountCodes = [
            [
                'code' => 'HOSGELDIN10',
                'type' => 'percentage',
                'value' => 10.00,
                'min_order_amount' => 500.00,
                'usage_limit' => null, // Sınırsız kullanım
                'used_count' => 0,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'is_active' => true,
            ],
            [
                'code' => 'YAZ2026',
                'type' => 'percentage',
                'value' => 15.00,
                'min_order_amount' => 2000.00,
                'usage_limit' => 100,
                'used_count' => 0,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(3),
                'is_active' => true,
            ],
            [
                'code' => 'KARGO100',
                'type' => 'fixed',
                'value' => 100.00,
                'min_order_amount' => 1000.00,
                'usage_limit' => 50,
                'used_count' => 0,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'VIP500',
                'type' => 'fixed',
                'value' => 500.00,
                'min_order_amount' => 5000.00,
                'usage_limit' => 20,
                'used_count' => 0,
                'starts_at' => now(),
                'expires_at' => now()->addMonths(2),
                'is_active' => true,
            ],
            [
                'code' => 'SUPERSALE25',
                'type' => 'percentage',
                'value' => 25.00,
                'min_order_amount' => 10000.00,
                'usage_limit' => 10,
                'used_count' => 0,
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
                'is_active' => true,
            ],
        ];

        foreach ($discountCodes as $code) {
            $code['created_at'] = now();
            $code['updated_at'] = now();
            DB::table('discount_codes')->insert($code);
        }
    }
}
