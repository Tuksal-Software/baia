<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $koltuklar = DB::table('categories')->where('slug', 'koltuklar')->first()->id;
        $kanepeler = DB::table('categories')->where('slug', 'kanepeler')->first()->id;
        $yataklar = DB::table('categories')->where('slug', 'yataklar')->first()->id;
        $yemekMasalari = DB::table('categories')->where('slug', 'yemek-masalari')->first()->id;

        $products = [
            // Koltuklar
            [
                'category_id' => $koltuklar,
                'name' => 'Nordic Berjer Koltuk',
                'slug' => 'nordic-berjer-koltuk',
                'short_description' => 'Modern tasarımlı rahat berjer koltuk',
                'description' => 'İskandinav tarzı tasarımıyla evinize şıklık katan Nordic Berjer Koltuk, yüksek kaliteli kumaş döşemesi ve masif ahşap ayaklarıyla dayanıklılık sunar. Ergonomik yapısı sayesinde uzun süreli oturmalarda bile konfor sağlar.',
                'price' => 4599.00,
                'sale_price' => 3899.00,
                'sku' => 'NRD-BRJ-001',
                'stock' => 15,
                'is_active' => true,
                'is_featured' => true,
                'is_new' => true,
                'rating' => 4.5,
                'reviews_count' => 23,
                'specifications' => [
                    ['key' => 'Genişlik', 'value' => '75', 'unit' => 'cm', 'order' => 1],
                    ['key' => 'Derinlik', 'value' => '80', 'unit' => 'cm', 'order' => 2],
                    ['key' => 'Yükseklik', 'value' => '95', 'unit' => 'cm', 'order' => 3],
                    ['key' => 'Oturma Yüksekliği', 'value' => '45', 'unit' => 'cm', 'order' => 4],
                    ['key' => 'Malzeme', 'value' => 'Kadife Kumaş', 'unit' => null, 'order' => 5],
                    ['key' => 'Ayak Malzemesi', 'value' => 'Masif Meşe', 'unit' => null, 'order' => 6],
                ],
                'features' => [
                    'Yüksek yoğunluklu sünger dolgu',
                    'Leke tutmayan kumaş',
                    'Kolay montaj',
                    '2 yıl garanti',
                ],
                'variants' => [
                    ['name' => 'Gri Kadife', 'sku' => 'NRD-BRJ-001-GRY', 'price_difference' => 0, 'stock' => 5],
                    ['name' => 'Lacivert Kadife', 'sku' => 'NRD-BRJ-001-NVY', 'price_difference' => 0, 'stock' => 5],
                    ['name' => 'Yeşil Kadife', 'sku' => 'NRD-BRJ-001-GRN', 'price_difference' => 200, 'stock' => 5],
                ],
            ],
            [
                'category_id' => $koltuklar,
                'name' => 'Loft Tekli Koltuk',
                'slug' => 'loft-tekli-koltuk',
                'short_description' => 'Endüstriyel tasarımlı tekli koltuk',
                'description' => 'Endüstriyel ve modern tasarımın buluştuğu Loft Tekli Koltuk, metal ayakları ve premium deri döşemesiyle dikkat çeker. Kompakt yapısı sayesinde küçük alanlara da uyum sağlar.',
                'price' => 3299.00,
                'sale_price' => null,
                'sku' => 'LFT-TKL-001',
                'stock' => 20,
                'is_active' => true,
                'is_featured' => false,
                'is_new' => false,
                'rating' => 4.2,
                'reviews_count' => 15,
                'specifications' => [
                    ['key' => 'Genişlik', 'value' => '70', 'unit' => 'cm', 'order' => 1],
                    ['key' => 'Derinlik', 'value' => '75', 'unit' => 'cm', 'order' => 2],
                    ['key' => 'Yükseklik', 'value' => '85', 'unit' => 'cm', 'order' => 3],
                    ['key' => 'Malzeme', 'value' => 'Suni Deri', 'unit' => null, 'order' => 4],
                ],
                'features' => [
                    'Metal ayak yapısı',
                    'Kolay temizlenebilir yüzey',
                    '1 yıl garanti',
                ],
                'variants' => [
                    ['name' => 'Siyah Deri', 'sku' => 'LFT-TKL-001-BLK', 'price_difference' => 0, 'stock' => 10],
                    ['name' => 'Kahverengi Deri', 'sku' => 'LFT-TKL-001-BRN', 'price_difference' => 0, 'stock' => 10],
                ],
            ],
            // Kanepeler
            [
                'category_id' => $kanepeler,
                'name' => 'Milano L Köşe Koltuk Takımı',
                'slug' => 'milano-l-kose-koltuk-takimi',
                'short_description' => 'Geniş ve konforlu L köşe koltuk takımı',
                'description' => 'Geniş oturma alanı sunan Milano L Köşe Koltuk Takımı, tüm aileyi ağırlayacak kapasitede tasarlanmıştır. Yüksek kaliteli kumaşı ve dayanıklı iskelet yapısıyla uzun yıllar kullanım sunar.',
                'price' => 18999.00,
                'sale_price' => 15999.00,
                'sku' => 'MLN-KSE-001',
                'stock' => 8,
                'is_active' => true,
                'is_featured' => true,
                'is_new' => true,
                'rating' => 4.8,
                'reviews_count' => 45,
                'specifications' => [
                    ['key' => 'Toplam Genişlik', 'value' => '320', 'unit' => 'cm', 'order' => 1],
                    ['key' => 'Köşe Derinliği', 'value' => '220', 'unit' => 'cm', 'order' => 2],
                    ['key' => 'Yükseklik', 'value' => '90', 'unit' => 'cm', 'order' => 3],
                    ['key' => 'Kişi Kapasitesi', 'value' => '6-7', 'unit' => 'kişi', 'order' => 4],
                ],
                'features' => [
                    'Yıkanabilir kılıf',
                    'Ayarlanabilir başlıklar',
                    'USB şarj girişi',
                    '5 yıl iskelet garantisi',
                    'Ücretsiz montaj hizmeti',
                ],
                'variants' => [
                    ['name' => 'Krem Kumaş', 'sku' => 'MLN-KSE-001-CRM', 'price_difference' => 0, 'stock' => 3],
                    ['name' => 'Antrasit Kumaş', 'sku' => 'MLN-KSE-001-ANT', 'price_difference' => 0, 'stock' => 3],
                    ['name' => 'Mavi Kumaş', 'sku' => 'MLN-KSE-001-BLU', 'price_difference' => 500, 'stock' => 2],
                ],
            ],
            // Yataklar
            [
                'category_id' => $yataklar,
                'name' => 'Comfort Plus Baza Yatak Seti',
                'slug' => 'comfort-plus-baza-yatak-seti',
                'short_description' => 'Ortopedik yatak ve baza seti',
                'description' => 'Sağlıklı uyku için tasarlanan Comfort Plus Baza Yatak Seti, ortopedik yatak teknolojisi ve sağlam baza yapısıyla mükemmel bir uyku deneyimi sunar. Pocket yay sistemi sayesinde partner hareketlerinden etkilenmezsiniz.',
                'price' => 12499.00,
                'sale_price' => null,
                'sku' => 'CMF-BZY-001',
                'stock' => 12,
                'is_active' => true,
                'is_featured' => true,
                'is_new' => false,
                'rating' => 4.7,
                'reviews_count' => 67,
                'specifications' => [
                    ['key' => 'Yatak Genişliği', 'value' => '160', 'unit' => 'cm', 'order' => 1],
                    ['key' => 'Yatak Uzunluğu', 'value' => '200', 'unit' => 'cm', 'order' => 2],
                    ['key' => 'Yatak Yüksekliği', 'value' => '30', 'unit' => 'cm', 'order' => 3],
                    ['key' => 'Baza Yüksekliği', 'value' => '35', 'unit' => 'cm', 'order' => 4],
                    ['key' => 'Sertlik', 'value' => 'Orta-Sert', 'unit' => null, 'order' => 5],
                ],
                'features' => [
                    'Pocket yay sistemi',
                    'Visco memory foam katman',
                    'Antibakteriyel kumaş',
                    'Çift taraflı kullanım',
                    '10 yıl garanti',
                ],
                'variants' => [
                    ['name' => '160x200 cm', 'sku' => 'CMF-BZY-001-160', 'price_difference' => 0, 'stock' => 4],
                    ['name' => '180x200 cm', 'sku' => 'CMF-BZY-001-180', 'price_difference' => 1500, 'stock' => 4],
                    ['name' => '200x200 cm', 'sku' => 'CMF-BZY-001-200', 'price_difference' => 3000, 'stock' => 4],
                ],
            ],
            // Yemek Masaları
            [
                'category_id' => $yemekMasalari,
                'name' => 'Doğal Meşe Yemek Masası',
                'slug' => 'dogal-mese-yemek-masasi',
                'short_description' => 'Doğal meşe ağacından el yapımı masa',
                'description' => 'Doğal meşe ağacından üretilen bu yemek masası, her parçası benzersiz damarlarıyla evinize doğallık katar. El işçiliğiyle üretilen masa, 8 kişilik aileler için ideal boyuttadır.',
                'price' => 8999.00,
                'sale_price' => 7499.00,
                'sku' => 'MSE-YMK-001',
                'stock' => 6,
                'is_active' => true,
                'is_featured' => false,
                'is_new' => true,
                'rating' => 4.9,
                'reviews_count' => 31,
                'specifications' => [
                    ['key' => 'Uzunluk', 'value' => '200', 'unit' => 'cm', 'order' => 1],
                    ['key' => 'Genişlik', 'value' => '100', 'unit' => 'cm', 'order' => 2],
                    ['key' => 'Yükseklik', 'value' => '75', 'unit' => 'cm', 'order' => 3],
                    ['key' => 'Tabla Kalınlığı', 'value' => '4', 'unit' => 'cm', 'order' => 4],
                    ['key' => 'Malzeme', 'value' => 'Masif Meşe', 'unit' => null, 'order' => 5],
                    ['key' => 'Kapasite', 'value' => '8', 'unit' => 'kişi', 'order' => 6],
                ],
                'features' => [
                    'El yapımı üretim',
                    'Doğal ahşap dokusu',
                    'Su bazlı vernik',
                    'Açılır ek tabla seçeneği',
                    '3 yıl garanti',
                ],
                'variants' => [
                    ['name' => 'Doğal Meşe', 'sku' => 'MSE-YMK-001-NAT', 'price_difference' => 0, 'stock' => 3],
                    ['name' => 'Koyu Ceviz', 'sku' => 'MSE-YMK-001-WLN', 'price_difference' => 500, 'stock' => 3],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $specifications = $productData['specifications'] ?? [];
            $features = $productData['features'] ?? [];
            $variants = $productData['variants'] ?? [];
            unset($productData['specifications'], $productData['features'], $productData['variants']);

            $productData['created_at'] = now();
            $productData['updated_at'] = now();

            $productId = DB::table('products')->insertGetId($productData);

            // Insert specifications
            foreach ($specifications as $spec) {
                $spec['product_id'] = $productId;
                $spec['created_at'] = now();
                $spec['updated_at'] = now();
                DB::table('product_specifications')->insert($spec);
            }

            // Insert features
            foreach ($features as $index => $feature) {
                DB::table('product_features')->insert([
                    'product_id' => $productId,
                    'feature' => $feature,
                    'order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert variants
            foreach ($variants as $variant) {
                $variant['product_id'] = $productId;
                $variant['created_at'] = now();
                $variant['updated_at'] = now();
                DB::table('product_variants')->insert($variant);
            }
        }
    }
}
