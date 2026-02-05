<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'icon' => 'truck',
                'title' => 'Ücretsiz Kargo',
                'description' => '2000₺ üzeri siparişlerde',
                'link' => '/kargo-teslimat',
                'position' => 'home',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'shield-check',
                'title' => '2 Yıl Garanti',
                'description' => 'Tüm ürünlerde geçerli',
                'link' => '/garanti',
                'position' => 'home',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'icon' => 'refresh-cw',
                'title' => '14 Gün İade',
                'description' => 'Koşulsuz iade garantisi',
                'link' => '/iade-degisim',
                'position' => 'home',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'icon' => 'credit-card',
                'title' => 'Güvenli Ödeme',
                'description' => '256-bit SSL koruma',
                'link' => null,
                'position' => 'home',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'icon' => 'headphones',
                'title' => 'Müşteri Desteği',
                'description' => '7/24 destek hattı',
                'link' => '/iletisim',
                'position' => 'footer',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'package',
                'title' => 'Kolay Montaj',
                'description' => 'Detaylı montaj kılavuzu',
                'link' => null,
                'position' => 'footer',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            Feature::updateOrCreate(
                ['title' => $feature['title'], 'position' => $feature['position']],
                $feature
            );
        }
    }
}
