<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Oturma Odası',
                'slug' => 'oturma-odasi',
                'description' => 'Oturma odası mobilyaları',
                'order' => 1,
                'children' => [
                    ['name' => 'Koltuklar', 'slug' => 'koltuklar', 'order' => 1],
                    ['name' => 'Kanepeler', 'slug' => 'kanepeler', 'order' => 2],
                    ['name' => 'TV Üniteleri', 'slug' => 'tv-uniteleri', 'order' => 3],
                    ['name' => 'Sehpalar', 'slug' => 'sehpalar', 'order' => 4],
                ],
            ],
            [
                'name' => 'Yatak Odası',
                'slug' => 'yatak-odasi',
                'description' => 'Yatak odası mobilyaları',
                'order' => 2,
                'children' => [
                    ['name' => 'Yataklar', 'slug' => 'yataklar', 'order' => 1],
                    ['name' => 'Gardıroplar', 'slug' => 'gardroplar', 'order' => 2],
                    ['name' => 'Komodinler', 'slug' => 'komodinler', 'order' => 3],
                    ['name' => 'Şifonyerler', 'slug' => 'sifonyerler', 'order' => 4],
                ],
            ],
            [
                'name' => 'Yemek Odası',
                'slug' => 'yemek-odasi',
                'description' => 'Yemek odası mobilyaları',
                'order' => 3,
                'children' => [
                    ['name' => 'Yemek Masaları', 'slug' => 'yemek-masalari', 'order' => 1],
                    ['name' => 'Sandalyeler', 'slug' => 'sandalyeler', 'order' => 2],
                    ['name' => 'Konsollar', 'slug' => 'konsollar', 'order' => 3],
                    ['name' => 'Büfeler', 'slug' => 'bufeler', 'order' => 4],
                ],
            ],
            [
                'name' => 'Çalışma Odası',
                'slug' => 'calisma-odasi',
                'description' => 'Çalışma odası mobilyaları',
                'order' => 4,
                'children' => [
                    ['name' => 'Çalışma Masaları', 'slug' => 'calisma-masalari', 'order' => 1],
                    ['name' => 'Ofis Koltukları', 'slug' => 'ofis-koltuklari', 'order' => 2],
                    ['name' => 'Kitaplıklar', 'slug' => 'kitapliklar', 'order' => 3],
                ],
            ],
            [
                'name' => 'Mutfak',
                'slug' => 'mutfak',
                'description' => 'Mutfak mobilyaları',
                'order' => 5,
                'children' => [
                    ['name' => 'Mutfak Masaları', 'slug' => 'mutfak-masalari', 'order' => 1],
                    ['name' => 'Bar Tabureleri', 'slug' => 'bar-tabureleri', 'order' => 2],
                ],
            ],
            [
                'name' => 'Bahçe & Balkon',
                'slug' => 'bahce-balkon',
                'description' => 'Dış mekan mobilyaları',
                'order' => 6,
                'children' => [
                    ['name' => 'Bahçe Takımları', 'slug' => 'bahce-takimlari', 'order' => 1],
                    ['name' => 'Şezlonglar', 'slug' => 'sezlonglar', 'order' => 2],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $children = $category['children'] ?? [];
            unset($category['children']);

            $category['created_at'] = now();
            $category['updated_at'] = now();

            $parentId = DB::table('categories')->insertGetId($category);

            foreach ($children as $child) {
                $child['parent_id'] = $parentId;
                $child['created_at'] = now();
                $child['updated_at'] = now();
                DB::table('categories')->insert($child);
            }
        }
    }
}
