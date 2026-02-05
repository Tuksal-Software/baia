<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Header Menu
        $headerMenu = Menu::updateOrCreate(
            ['location' => 'header'],
            ['name' => 'Ana Menü']
        );

        $headerItems = [
            ['title' => 'Yeni Ürünler', 'link' => '/yeni-urunler', 'order' => 1],
            ['title' => 'Oturma Odası', 'link' => '/kategori/oturma-odasi', 'order' => 2],
            ['title' => 'Yatak Odası', 'link' => '/kategori/yatak-odasi', 'order' => 3],
            ['title' => 'Yemek Odası', 'link' => '/kategori/yemek-odasi', 'order' => 4],
            ['title' => 'Çalışma Odası', 'link' => '/kategori/calisma-odasi', 'order' => 5],
            ['title' => 'Dekorasyon', 'link' => '/kategori/dekorasyon', 'order' => 6],
            ['title' => 'İndirimler', 'link' => '/indirimler', 'order' => 7],
        ];

        foreach ($headerItems as $item) {
            MenuItem::updateOrCreate(
                ['menu_id' => $headerMenu->id, 'title' => $item['title']],
                array_merge($item, ['menu_id' => $headerMenu->id])
            );
        }

        // Footer Menu 1 - Kurumsal
        $footerMenu = Menu::updateOrCreate(
            ['location' => 'footer'],
            ['name' => 'Footer Menü']
        );

        $footerItems = [
            ['title' => 'Hakkımızda', 'link' => '/hakkimizda', 'order' => 1],
            ['title' => 'İletişim', 'link' => '/iletisim', 'order' => 2],
            ['title' => 'Kariyer', 'link' => '/kariyer', 'order' => 3],
            ['title' => 'Blog', 'link' => '/blog', 'order' => 4],
            ['title' => 'Mağazalarımız', 'link' => '/magazalarimiz', 'order' => 5],
        ];

        foreach ($footerItems as $item) {
            MenuItem::updateOrCreate(
                ['menu_id' => $footerMenu->id, 'title' => $item['title']],
                array_merge($item, ['menu_id' => $footerMenu->id])
            );
        }

        // Footer Menu 2 - Yardım
        $footerSecondary = Menu::updateOrCreate(
            ['location' => 'footer_secondary'],
            ['name' => 'Yardım Menü']
        );

        $footerSecondaryItems = [
            ['title' => 'Sipariş Takibi', 'link' => '/siparis-takibi', 'order' => 1],
            ['title' => 'Kargo & Teslimat', 'link' => '/kargo-teslimat', 'order' => 2],
            ['title' => 'İade & Değişim', 'link' => '/iade-degisim', 'order' => 3],
            ['title' => 'Sıkça Sorulan Sorular', 'link' => '/sss', 'order' => 4],
            ['title' => 'Gizlilik Politikası', 'link' => '/gizlilik-politikasi', 'order' => 5],
        ];

        foreach ($footerSecondaryItems as $item) {
            MenuItem::updateOrCreate(
                ['menu_id' => $footerSecondary->id, 'title' => $item['title']],
                array_merge($item, ['menu_id' => $footerSecondary->id])
            );
        }
    }
}
