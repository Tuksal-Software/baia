<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'type' => 'slider',
                'title' => null,
                'subtitle' => null,
                'settings' => [],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'type' => 'features',
                'title' => null,
                'subtitle' => null,
                'settings' => ['position' => 'home'],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'type' => 'categories',
                'title' => ['tr' => 'Kategoriler', 'en' => 'Categories', 'de' => 'Kategorien'],
                'subtitle' => ['tr' => 'İlham veren koleksiyonlarımızı keşfedin', 'en' => 'Discover our inspiring collections', 'de' => 'Entdecken Sie unsere inspirierenden Kollektionen'],
                'settings' => ['limit' => 6, 'show_all_link' => true],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'type' => 'products',
                'title' => ['tr' => 'Yeni Ürünler', 'en' => 'New Products', 'de' => 'Neue Produkte'],
                'subtitle' => ['tr' => 'En yeni tasarımlarımız', 'en' => 'Our newest designs', 'de' => 'Unsere neuesten Designs'],
                'settings' => ['type' => 'new', 'limit' => 12],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'type' => 'banner',
                'title' => null,
                'subtitle' => null,
                'settings' => ['position' => 'home_middle'],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'type' => 'products',
                'title' => ['tr' => 'Çok Satanlar', 'en' => 'Best Sellers', 'de' => 'Bestseller'],
                'subtitle' => ['tr' => 'En popüler ürünlerimiz', 'en' => 'Our most popular products', 'de' => 'Unsere beliebtesten Produkte'],
                'settings' => ['type' => 'bestseller', 'limit' => 12],
                'order' => 6,
                'is_active' => true,
            ],
            [
                'type' => 'products',
                'title' => ['tr' => 'İndirimli Ürünler', 'en' => 'Sale Products', 'de' => 'Sale Produkte'],
                'subtitle' => ['tr' => 'Kaçırılmayacak fırsatlar', 'en' => 'Unmissable deals', 'de' => 'Unschlagbare Angebote'],
                'settings' => ['type' => 'sale', 'limit' => 12],
                'order' => 7,
                'is_active' => true,
            ],
            [
                'type' => 'newsletter',
                'title' => ['tr' => 'Bültenimize Katılın', 'en' => 'Join Our Newsletter', 'de' => 'Abonnieren Sie unseren Newsletter'],
                'subtitle' => ['tr' => 'Yeni ürünler ve kampanyalardan haberdar olun', 'en' => 'Stay updated on new products and campaigns', 'de' => 'Bleiben Sie über neue Produkte und Aktionen informiert'],
                'settings' => ['background_color' => '#f5f5dc'],
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::create($section);
        }
    }
}
