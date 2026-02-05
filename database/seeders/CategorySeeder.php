<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => ['tr' => 'Oturma Odası', 'en' => 'Living Room', 'de' => 'Wohnzimmer'],
                'slug' => 'oturma-odasi',
                'description' => ['tr' => 'Oturma odası mobilyaları', 'en' => 'Living room furniture', 'de' => 'Wohnzimmermöbel'],
                'order' => 1,
                'is_active' => true,
                'children' => [
                    ['name' => ['tr' => 'Koltuklar', 'en' => 'Armchairs', 'de' => 'Sessel'], 'slug' => 'koltuklar', 'order' => 1],
                    ['name' => ['tr' => 'Kanepeler', 'en' => 'Sofas', 'de' => 'Sofas'], 'slug' => 'kanepeler', 'order' => 2],
                    ['name' => ['tr' => 'TV Üniteleri', 'en' => 'TV Units', 'de' => 'TV-Möbel'], 'slug' => 'tv-uniteleri', 'order' => 3],
                    ['name' => ['tr' => 'Sehpalar', 'en' => 'Coffee Tables', 'de' => 'Couchtische'], 'slug' => 'sehpalar', 'order' => 4],
                ],
            ],
            [
                'name' => ['tr' => 'Yatak Odası', 'en' => 'Bedroom', 'de' => 'Schlafzimmer'],
                'slug' => 'yatak-odasi',
                'description' => ['tr' => 'Yatak odası mobilyaları', 'en' => 'Bedroom furniture', 'de' => 'Schlafzimmermöbel'],
                'order' => 2,
                'is_active' => true,
                'children' => [
                    ['name' => ['tr' => 'Yataklar', 'en' => 'Beds', 'de' => 'Betten'], 'slug' => 'yataklar', 'order' => 1],
                    ['name' => ['tr' => 'Gardıroplar', 'en' => 'Wardrobes', 'de' => 'Kleiderschränke'], 'slug' => 'gardroplar', 'order' => 2],
                    ['name' => ['tr' => 'Komodinler', 'en' => 'Nightstands', 'de' => 'Nachttische'], 'slug' => 'komodinler', 'order' => 3],
                    ['name' => ['tr' => 'Şifonyerler', 'en' => 'Dressers', 'de' => 'Kommoden'], 'slug' => 'sifonyerler', 'order' => 4],
                ],
            ],
            [
                'name' => ['tr' => 'Yemek Odası', 'en' => 'Dining Room', 'de' => 'Esszimmer'],
                'slug' => 'yemek-odasi',
                'description' => ['tr' => 'Yemek odası mobilyaları', 'en' => 'Dining room furniture', 'de' => 'Esszimmermöbel'],
                'order' => 3,
                'is_active' => true,
                'children' => [
                    ['name' => ['tr' => 'Yemek Masaları', 'en' => 'Dining Tables', 'de' => 'Esstische'], 'slug' => 'yemek-masalari', 'order' => 1],
                    ['name' => ['tr' => 'Sandalyeler', 'en' => 'Chairs', 'de' => 'Stühle'], 'slug' => 'sandalyeler', 'order' => 2],
                    ['name' => ['tr' => 'Konsollar', 'en' => 'Consoles', 'de' => 'Konsolen'], 'slug' => 'konsollar', 'order' => 3],
                    ['name' => ['tr' => 'Büfeler', 'en' => 'Buffets', 'de' => 'Buffets'], 'slug' => 'bufeler', 'order' => 4],
                ],
            ],
            [
                'name' => ['tr' => 'Çalışma Odası', 'en' => 'Home Office', 'de' => 'Arbeitszimmer'],
                'slug' => 'calisma-odasi',
                'description' => ['tr' => 'Çalışma odası mobilyaları', 'en' => 'Home office furniture', 'de' => 'Büromöbel'],
                'order' => 4,
                'is_active' => true,
                'children' => [
                    ['name' => ['tr' => 'Çalışma Masaları', 'en' => 'Desks', 'de' => 'Schreibtische'], 'slug' => 'calisma-masalari', 'order' => 1],
                    ['name' => ['tr' => 'Ofis Koltukları', 'en' => 'Office Chairs', 'de' => 'Bürostühle'], 'slug' => 'ofis-koltuklari', 'order' => 2],
                    ['name' => ['tr' => 'Kitaplıklar', 'en' => 'Bookcases', 'de' => 'Bücherregale'], 'slug' => 'kitapliklar', 'order' => 3],
                ],
            ],
            [
                'name' => ['tr' => 'Mutfak', 'en' => 'Kitchen', 'de' => 'Küche'],
                'slug' => 'mutfak',
                'description' => ['tr' => 'Mutfak mobilyaları', 'en' => 'Kitchen furniture', 'de' => 'Küchenmöbel'],
                'order' => 5,
                'is_active' => true,
                'children' => [
                    ['name' => ['tr' => 'Mutfak Masaları', 'en' => 'Kitchen Tables', 'de' => 'Küchentische'], 'slug' => 'mutfak-masalari', 'order' => 1],
                    ['name' => ['tr' => 'Bar Tabureleri', 'en' => 'Bar Stools', 'de' => 'Barhocker'], 'slug' => 'bar-tabureleri', 'order' => 2],
                ],
            ],
            [
                'name' => ['tr' => 'Bahçe & Balkon', 'en' => 'Garden & Balcony', 'de' => 'Garten & Balkon'],
                'slug' => 'bahce-balkon',
                'description' => ['tr' => 'Dış mekan mobilyaları', 'en' => 'Outdoor furniture', 'de' => 'Gartenmöbel'],
                'order' => 6,
                'is_active' => true,
                'children' => [
                    ['name' => ['tr' => 'Bahçe Takımları', 'en' => 'Garden Sets', 'de' => 'Gartenmöbel-Sets'], 'slug' => 'bahce-takimlari', 'order' => 1],
                    ['name' => ['tr' => 'Şezlonglar', 'en' => 'Loungers', 'de' => 'Liegen'], 'slug' => 'sezlonglar', 'order' => 2],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $parent = Category::create($categoryData);

            foreach ($children as $child) {
                $child['parent_id'] = $parent->id;
                $child['is_active'] = true;
                Category::create($child);
            }
        }
    }
}
