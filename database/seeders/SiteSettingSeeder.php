<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            ['group' => 'general', 'key' => 'site_name', 'value' => 'BAIA', 'type' => 'text', 'label' => 'Site Adı', 'order' => 1],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'Modern Mobilya & Dekorasyon', 'type' => 'textarea', 'label' => 'Site Açıklaması', 'order' => 2],
            ['group' => 'general', 'key' => 'site_logo', 'value' => null, 'type' => 'image', 'label' => 'Site Logosu', 'order' => 3],
            ['group' => 'general', 'key' => 'site_logo_light', 'value' => null, 'type' => 'image', 'label' => 'Site Logosu (Açık)', 'order' => 4],
            ['group' => 'general', 'key' => 'site_favicon', 'value' => null, 'type' => 'image', 'label' => 'Favicon', 'order' => 5],
            ['group' => 'general', 'key' => 'currency_symbol', 'value' => '₺', 'type' => 'text', 'label' => 'Para Birimi Sembolü', 'order' => 6],
            ['group' => 'general', 'key' => 'currency_code', 'value' => 'TRY', 'type' => 'text', 'label' => 'Para Birimi Kodu', 'order' => 7],

            // Header Settings
            ['group' => 'header', 'key' => 'header_announcement', 'value' => 'Ücretsiz Kargo - 2000₺ üzeri siparişlerde', 'type' => 'text', 'label' => 'Duyuru Bandı', 'order' => 1],
            ['group' => 'header', 'key' => 'header_announcement_link', 'value' => '/kampanyalar', 'type' => 'text', 'label' => 'Duyuru Linki', 'order' => 2],
            ['group' => 'header', 'key' => 'header_announcement_active', 'value' => '1', 'type' => 'boolean', 'label' => 'Duyuru Bandı Aktif', 'order' => 3],
            ['group' => 'header', 'key' => 'header_phone', 'value' => '0850 123 45 67', 'type' => 'text', 'label' => 'Telefon', 'order' => 4],
            ['group' => 'header', 'key' => 'header_style', 'value' => 'dark', 'type' => 'select', 'label' => 'Header Stili', 'description' => 'dark,light', 'order' => 5],

            // Footer Settings
            ['group' => 'footer', 'key' => 'footer_about', 'value' => 'BAIA, modern ve minimalist mobilya tasarımlarıyla yaşam alanlarınıza şıklık katıyor. Kalite ve estetiği bir arada sunuyoruz.', 'type' => 'textarea', 'label' => 'Hakkımızda Metni', 'order' => 1],
            ['group' => 'footer', 'key' => 'footer_copyright', 'value' => '© 2026 BAIA. Tüm hakları saklıdır.', 'type' => 'text', 'label' => 'Copyright Metni', 'order' => 2],
            ['group' => 'footer', 'key' => 'footer_payment_icons', 'value' => '1', 'type' => 'boolean', 'label' => 'Ödeme İkonlarını Göster', 'order' => 3],

            // Contact Settings
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'info@baia.com', 'type' => 'text', 'label' => 'E-posta', 'order' => 1],
            ['group' => 'contact', 'key' => 'contact_phone', 'value' => '0850 123 45 67', 'type' => 'text', 'label' => 'Telefon', 'order' => 2],
            ['group' => 'contact', 'key' => 'contact_address', 'value' => 'İstanbul, Türkiye', 'type' => 'textarea', 'label' => 'Adres', 'order' => 3],
            ['group' => 'contact', 'key' => 'contact_working_hours', 'value' => 'Pazartesi - Cumartesi: 09:00 - 18:00', 'type' => 'text', 'label' => 'Çalışma Saatleri', 'order' => 4],

            // Social Media Settings
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://facebook.com/baia', 'type' => 'text', 'label' => 'Facebook', 'order' => 1],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => 'https://instagram.com/baia', 'type' => 'text', 'label' => 'Instagram', 'order' => 2],
            ['group' => 'social', 'key' => 'social_twitter', 'value' => '', 'type' => 'text', 'label' => 'Twitter/X', 'order' => 3],
            ['group' => 'social', 'key' => 'social_pinterest', 'value' => 'https://pinterest.com/baia', 'type' => 'text', 'label' => 'Pinterest', 'order' => 4],
            ['group' => 'social', 'key' => 'social_youtube', 'value' => '', 'type' => 'text', 'label' => 'YouTube', 'order' => 5],

            // SEO Settings
            ['group' => 'seo', 'key' => 'meta_title', 'value' => 'BAIA - Modern Mobilya & Dekorasyon', 'type' => 'text', 'label' => 'Meta Başlık', 'order' => 1],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'BAIA ile evinize modern ve şık mobilyalar. Kaliteli üretim, uygun fiyatlar ve ücretsiz kargo avantajıyla alışveriş yapın.', 'type' => 'textarea', 'label' => 'Meta Açıklama', 'order' => 2],
            ['group' => 'seo', 'key' => 'meta_keywords', 'value' => 'mobilya, dekorasyon, ev mobilyası, modern mobilya, koltuk, masa, sandalye', 'type' => 'textarea', 'label' => 'Meta Anahtar Kelimeler', 'order' => 3],
            ['group' => 'seo', 'key' => 'google_analytics', 'value' => '', 'type' => 'textarea', 'label' => 'Google Analytics Kodu', 'order' => 4],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
