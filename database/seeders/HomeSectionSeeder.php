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
                'title' => 'Kategoriler',
                'subtitle' => 'İlham veren koleksiyonlarımızı keşfedin',
                'settings' => ['limit' => 6, 'show_all_link' => true],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'type' => 'products',
                'title' => 'Yeni Ürünler',
                'subtitle' => 'En yeni tasarımlarımız',
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
                'title' => 'Çok Satanlar',
                'subtitle' => 'En popüler ürünlerimiz',
                'settings' => ['type' => 'bestseller', 'limit' => 12],
                'order' => 6,
                'is_active' => true,
            ],
            [
                'type' => 'products',
                'title' => 'İndirimli Ürünler',
                'subtitle' => 'Kaçırılmayacak fırsatlar',
                'settings' => ['type' => 'sale', 'limit' => 12],
                'order' => 7,
                'is_active' => true,
            ],
            [
                'type' => 'newsletter',
                'title' => 'Bültenimize Katılın',
                'subtitle' => 'Yeni ürünler ve kampanyalardan haberdar olun',
                'settings' => ['background_color' => '#f5f5dc'],
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::updateOrCreate(
                ['type' => $section['type'], 'order' => $section['order']],
                $section
            );
        }
    }
}
