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
                'title' => ['tr' => 'Ücretsiz Kargo', 'en' => 'Free Shipping', 'de' => 'Kostenloser Versand'],
                'description' => ['tr' => '2000₺ üzeri siparişlerde', 'en' => 'On orders over 2000₺', 'de' => 'Bei Bestellungen über 2000₺'],
                'link' => '/kargo-teslimat',
                'position' => 'home',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'shield-check',
                'title' => ['tr' => '2 Yıl Garanti', 'en' => '2 Year Warranty', 'de' => '2 Jahre Garantie'],
                'description' => ['tr' => 'Tüm ürünlerde geçerli', 'en' => 'Valid on all products', 'de' => 'Gültig für alle Produkte'],
                'link' => '/garanti',
                'position' => 'home',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'icon' => 'refresh-cw',
                'title' => ['tr' => '14 Gün İade', 'en' => '14 Day Returns', 'de' => '14 Tage Rückgabe'],
                'description' => ['tr' => 'Koşulsuz iade garantisi', 'en' => 'Unconditional return guarantee', 'de' => 'Bedingungslose Rückgabegarantie'],
                'link' => '/iade-degisim',
                'position' => 'home',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'icon' => 'credit-card',
                'title' => ['tr' => 'Güvenli Ödeme', 'en' => 'Secure Payment', 'de' => 'Sichere Zahlung'],
                'description' => ['tr' => '256-bit SSL koruma', 'en' => '256-bit SSL protection', 'de' => '256-Bit SSL-Schutz'],
                'link' => null,
                'position' => 'home',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'icon' => 'headphones',
                'title' => ['tr' => 'Müşteri Desteği', 'en' => 'Customer Support', 'de' => 'Kundendienst'],
                'description' => ['tr' => '7/24 destek hattı', 'en' => '24/7 support line', 'de' => '24/7 Support-Hotline'],
                'link' => '/iletisim',
                'position' => 'footer',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'icon' => 'package',
                'title' => ['tr' => 'Kolay Montaj', 'en' => 'Easy Assembly', 'de' => 'Einfache Montage'],
                'description' => ['tr' => 'Detaylı montaj kılavuzu', 'en' => 'Detailed assembly guide', 'de' => 'Detaillierte Montageanleitung'],
                'link' => null,
                'position' => 'footer',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
