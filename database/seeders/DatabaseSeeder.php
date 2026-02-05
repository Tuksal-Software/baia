<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin kullanıcı oluştur
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@baia.com',
            'is_admin' => true,
        ]);

        // Kategorileri, ürünleri ve indirim kodlarını ekle
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            DiscountCodeSeeder::class,
            SiteSettingSeeder::class,
            MenuSeeder::class,
            HomeSectionSeeder::class,
            FeatureSeeder::class,
        ]);
    }
}
