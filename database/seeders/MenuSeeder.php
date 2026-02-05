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
            ['name' => ['tr' => 'Ana Menü', 'en' => 'Main Menu', 'de' => 'Hauptmenü']]
        );

        // Clear existing items for this menu
        MenuItem::where('menu_id', $headerMenu->id)->delete();

        $headerItems = [
            [
                'title' => ['tr' => 'Yeni Ürünler', 'en' => 'New Products', 'de' => 'Neue Produkte'],
                'link' => '/yeni-urunler',
                'order' => 1
            ],
            [
                'title' => ['tr' => 'Oturma Odası', 'en' => 'Living Room', 'de' => 'Wohnzimmer'],
                'link' => '/kategori/oturma-odasi',
                'order' => 2
            ],
            [
                'title' => ['tr' => 'Yatak Odası', 'en' => 'Bedroom', 'de' => 'Schlafzimmer'],
                'link' => '/kategori/yatak-odasi',
                'order' => 3
            ],
            [
                'title' => ['tr' => 'Yemek Odası', 'en' => 'Dining Room', 'de' => 'Esszimmer'],
                'link' => '/kategori/yemek-odasi',
                'order' => 4
            ],
            [
                'title' => ['tr' => 'Çalışma Odası', 'en' => 'Home Office', 'de' => 'Arbeitszimmer'],
                'link' => '/kategori/calisma-odasi',
                'order' => 5
            ],
            [
                'title' => ['tr' => 'Dekorasyon', 'en' => 'Decoration', 'de' => 'Dekoration'],
                'link' => '/kategori/dekorasyon',
                'order' => 6
            ],
            [
                'title' => ['tr' => 'İndirimler', 'en' => 'Discounts', 'de' => 'Rabatte'],
                'link' => '/indirimler',
                'order' => 7
            ],
        ];

        foreach ($headerItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $headerMenu->id, 'is_active' => true]));
        }

        // Footer Menu 1 - Kurumsal
        $footerMenu = Menu::updateOrCreate(
            ['location' => 'footer'],
            ['name' => ['tr' => 'Footer Menü', 'en' => 'Footer Menu', 'de' => 'Footer-Menü']]
        );

        // Clear existing items for this menu
        MenuItem::where('menu_id', $footerMenu->id)->delete();

        $footerItems = [
            [
                'title' => ['tr' => 'Hakkımızda', 'en' => 'About Us', 'de' => 'Über uns'],
                'link' => '/hakkimizda',
                'order' => 1
            ],
            [
                'title' => ['tr' => 'İletişim', 'en' => 'Contact', 'de' => 'Kontakt'],
                'link' => '/iletisim',
                'order' => 2
            ],
            [
                'title' => ['tr' => 'Kariyer', 'en' => 'Careers', 'de' => 'Karriere'],
                'link' => '/kariyer',
                'order' => 3
            ],
            [
                'title' => ['tr' => 'Blog', 'en' => 'Blog', 'de' => 'Blog'],
                'link' => '/blog',
                'order' => 4
            ],
            [
                'title' => ['tr' => 'Mağazalarımız', 'en' => 'Our Stores', 'de' => 'Unsere Geschäfte'],
                'link' => '/magazalarimiz',
                'order' => 5
            ],
        ];

        foreach ($footerItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $footerMenu->id, 'is_active' => true]));
        }

        // Footer Menu 2 - Yardım
        $footerSecondary = Menu::updateOrCreate(
            ['location' => 'footer_secondary'],
            ['name' => ['tr' => 'Yardım Menü', 'en' => 'Help Menu', 'de' => 'Hilfe-Menü']]
        );

        // Clear existing items for this menu
        MenuItem::where('menu_id', $footerSecondary->id)->delete();

        $footerSecondaryItems = [
            [
                'title' => ['tr' => 'Sipariş Takibi', 'en' => 'Order Tracking', 'de' => 'Bestellverfolgung'],
                'link' => '/siparis-takibi',
                'order' => 1
            ],
            [
                'title' => ['tr' => 'Kargo & Teslimat', 'en' => 'Shipping & Delivery', 'de' => 'Versand & Lieferung'],
                'link' => '/kargo-teslimat',
                'order' => 2
            ],
            [
                'title' => ['tr' => 'İade & Değişim', 'en' => 'Returns & Exchanges', 'de' => 'Rückgabe & Umtausch'],
                'link' => '/iade-degisim',
                'order' => 3
            ],
            [
                'title' => ['tr' => 'Sıkça Sorulan Sorular', 'en' => 'FAQ', 'de' => 'Häufige Fragen'],
                'link' => '/sss',
                'order' => 4
            ],
            [
                'title' => ['tr' => 'Gizlilik Politikası', 'en' => 'Privacy Policy', 'de' => 'Datenschutzrichtlinie'],
                'link' => '/gizlilik-politikasi',
                'order' => 5
            ],
        ];

        foreach ($footerSecondaryItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $footerSecondary->id, 'is_active' => true]));
        }
    }
}
