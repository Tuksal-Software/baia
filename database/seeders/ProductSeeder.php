<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $koltuklar = Category::where('slug', 'koltuklar')->first()->id;
        $kanepeler = Category::where('slug', 'kanepeler')->first()->id;
        $yataklar = Category::where('slug', 'yataklar')->first()->id;
        $yemekMasalari = Category::where('slug', 'yemek-masalari')->first()->id;

        $products = [
            // Koltuklar
            [
                'category_id' => $koltuklar,
                'name' => ['tr' => 'Nordic Berjer Koltuk', 'en' => 'Nordic Armchair', 'de' => 'Nordic Sessel'],
                'slug' => 'nordic-berjer-koltuk',
                'short_description' => ['tr' => 'Modern tasarımlı rahat berjer koltuk', 'en' => 'Modern design comfortable armchair', 'de' => 'Modern gestalteter bequemer Sessel'],
                'description' => ['tr' => 'İskandinav tarzı tasarımıyla evinize şıklık katan Nordic Berjer Koltuk, yüksek kaliteli kumaş döşemesi ve masif ahşap ayaklarıyla dayanıklılık sunar.', 'en' => 'The Nordic Armchair adds elegance to your home with its Scandinavian-style design, offering durability with high-quality fabric upholstery and solid wood legs.', 'de' => 'Der Nordic Sessel verleiht Ihrem Zuhause mit seinem skandinavischen Design Eleganz und bietet Langlebigkeit mit hochwertiger Stoffpolsterung und massiven Holzbeinen.'],
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
                    ['key' => 'Malzeme', 'value' => 'Kadife Kumaş', 'unit' => null, 'order' => 4],
                ],
                'features' => ['Yüksek yoğunluklu sünger dolgu', 'Leke tutmayan kumaş', 'Kolay montaj', '2 yıl garanti'],
                'variants' => [
                    ['name' => 'Gri Kadife', 'sku' => 'NRD-BRJ-001-GRY', 'price_difference' => 0, 'stock' => 5],
                    ['name' => 'Lacivert Kadife', 'sku' => 'NRD-BRJ-001-NVY', 'price_difference' => 0, 'stock' => 5],
                ],
            ],
            [
                'category_id' => $koltuklar,
                'name' => ['tr' => 'Loft Tekli Koltuk', 'en' => 'Loft Single Armchair', 'de' => 'Loft Einzelsessel'],
                'slug' => 'loft-tekli-koltuk',
                'short_description' => ['tr' => 'Endüstriyel tasarımlı tekli koltuk', 'en' => 'Industrial design single armchair', 'de' => 'Einzelsessel im Industriedesign'],
                'description' => ['tr' => 'Endüstriyel ve modern tasarımın buluştuğu Loft Tekli Koltuk, metal ayakları ve premium deri döşemesiyle dikkat çeker.', 'en' => 'The Loft Single Armchair, where industrial and modern design meet, stands out with its metal legs and premium leather upholstery.', 'de' => 'Der Loft Einzelsessel, bei dem sich industrielles und modernes Design treffen, besticht durch seine Metallbeine und die hochwertige Lederpolsterung.'],
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
                ],
                'features' => ['Metal ayak yapısı', 'Kolay temizlenebilir yüzey', '1 yıl garanti'],
                'variants' => [
                    ['name' => 'Siyah Deri', 'sku' => 'LFT-TKL-001-BLK', 'price_difference' => 0, 'stock' => 10],
                    ['name' => 'Kahverengi Deri', 'sku' => 'LFT-TKL-001-BRN', 'price_difference' => 0, 'stock' => 10],
                ],
            ],
            // Kanepeler
            [
                'category_id' => $kanepeler,
                'name' => ['tr' => 'Milano L Köşe Koltuk Takımı', 'en' => 'Milano L-Shaped Sofa Set', 'de' => 'Milano L-Ecksofa-Set'],
                'slug' => 'milano-l-kose-koltuk-takimi',
                'short_description' => ['tr' => 'Geniş ve konforlu L köşe koltuk takımı', 'en' => 'Spacious and comfortable L-shaped sofa set', 'de' => 'Geräumiges und komfortables L-Ecksofa-Set'],
                'description' => ['tr' => 'Geniş oturma alanı sunan Milano L Köşe Koltuk Takımı, tüm aileyi ağırlayacak kapasitede tasarlanmıştır.', 'en' => 'The Milano L-Shaped Sofa Set, offering a spacious seating area, is designed with capacity to accommodate the whole family.', 'de' => 'Das Milano L-Ecksofa-Set bietet einen großzügigen Sitzbereich und ist so konzipiert, dass die ganze Familie Platz findet.'],
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
                ],
                'features' => ['Yıkanabilir kılıf', 'Ayarlanabilir başlıklar', 'USB şarj girişi', '5 yıl iskelet garantisi'],
                'variants' => [
                    ['name' => 'Krem Kumaş', 'sku' => 'MLN-KSE-001-CRM', 'price_difference' => 0, 'stock' => 3],
                    ['name' => 'Antrasit Kumaş', 'sku' => 'MLN-KSE-001-ANT', 'price_difference' => 0, 'stock' => 3],
                ],
            ],
            // Yataklar
            [
                'category_id' => $yataklar,
                'name' => ['tr' => 'Comfort Plus Baza Yatak Seti', 'en' => 'Comfort Plus Bed Base Set', 'de' => 'Comfort Plus Bettgestell-Set'],
                'slug' => 'comfort-plus-baza-yatak-seti',
                'short_description' => ['tr' => 'Ortopedik yatak ve baza seti', 'en' => 'Orthopedic mattress and bed base set', 'de' => 'Orthopädisches Matratzen- und Bettgestell-Set'],
                'description' => ['tr' => 'Sağlıklı uyku için tasarlanan Comfort Plus Baza Yatak Seti, ortopedik yatak teknolojisi ve sağlam baza yapısıyla mükemmel bir uyku deneyimi sunar.', 'en' => 'Designed for healthy sleep, the Comfort Plus Bed Base Set offers a perfect sleep experience with orthopedic mattress technology and sturdy base structure.', 'de' => 'Das für gesunden Schlaf konzipierte Comfort Plus Bettgestell-Set bietet mit orthopädischer Matratzen-Technologie und stabiler Basisstruktur ein perfektes Schlaferlebnis.'],
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
                    ['key' => 'Sertlik', 'value' => 'Orta-Sert', 'unit' => null, 'order' => 3],
                ],
                'features' => ['Pocket yay sistemi', 'Visco memory foam katman', 'Antibakteriyel kumaş', '10 yıl garanti'],
                'variants' => [
                    ['name' => '160x200 cm', 'sku' => 'CMF-BZY-001-160', 'price_difference' => 0, 'stock' => 4],
                    ['name' => '180x200 cm', 'sku' => 'CMF-BZY-001-180', 'price_difference' => 1500, 'stock' => 4],
                ],
            ],
            // Yemek Masaları
            [
                'category_id' => $yemekMasalari,
                'name' => ['tr' => 'Doğal Meşe Yemek Masası', 'en' => 'Natural Oak Dining Table', 'de' => 'Natürlicher Eiche Esstisch'],
                'slug' => 'dogal-mese-yemek-masasi',
                'short_description' => ['tr' => 'Doğal meşe ağacından el yapımı masa', 'en' => 'Handmade table from natural oak wood', 'de' => 'Handgefertigter Tisch aus natürlichem Eichenholz'],
                'description' => ['tr' => 'Doğal meşe ağacından üretilen bu yemek masası, her parçası benzersiz damarlarıyla evinize doğallık katar.', 'en' => 'This dining table made from natural oak wood adds naturalness to your home with each piece having unique grain patterns.', 'de' => 'Dieser aus natürlichem Eichenholz gefertigte Esstisch verleiht Ihrem Zuhause mit der einzigartigen Maserung jedes Stücks Natürlichkeit.'],
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
                    ['key' => 'Malzeme', 'value' => 'Masif Meşe', 'unit' => null, 'order' => 4],
                ],
                'features' => ['El yapımı üretim', 'Doğal ahşap dokusu', 'Su bazlı vernik', '3 yıl garanti'],
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

            $product = Product::create($productData);

            // Insert specifications
            foreach ($specifications as $spec) {
                DB::table('product_specifications')->insert([
                    'product_id' => $product->id,
                    'key' => $spec['key'],
                    'value' => $spec['value'],
                    'unit' => $spec['unit'],
                    'order' => $spec['order'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert features
            foreach ($features as $index => $feature) {
                DB::table('product_features')->insert([
                    'product_id' => $product->id,
                    'feature' => $feature,
                    'order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert variants
            foreach ($variants as $variant) {
                DB::table('product_variants')->insert([
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'sku' => $variant['sku'],
                    'price_difference' => $variant['price_difference'],
                    'stock' => $variant['stock'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
