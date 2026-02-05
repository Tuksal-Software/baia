<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $labelMap = [
        'Site Adı' => 'Site Name',
        'Site Açıklaması' => 'Site Description',
        'Site Logosu' => 'Site Logo',
        'Site Logosu (Açık)' => 'Site Logo (Light)',
        'Duyuru Bandı' => 'Announcement Bar',
        'Duyuru Linki' => 'Announcement Link',
        'Duyuru Bandı Aktif' => 'Announcement Bar Active',
        'Telefon' => 'Phone',
        'Header Stili' => 'Header Style',
        'Hakkımızda Metni' => 'About Text',
        'Copyright Metni' => 'Copyright Text',
        'Ödeme İkonlarını Göster' => 'Show Payment Icons',
        'E-posta' => 'Email',
        'Adres' => 'Address',
        'Çalışma Saatleri' => 'Working Hours',
        'Meta Başlık' => 'Meta Title',
        'Meta Açıklama' => 'Meta Description',
        'Meta Anahtar Kelimeler' => 'Meta Keywords',
        'Google Analytics Kodu' => 'Google Analytics Code',
    ];

    public function up(): void
    {
        foreach ($this->labelMap as $oldLabel => $newLabel) {
            DB::table('site_settings')
                ->where('label', $oldLabel)
                ->update(['label' => $newLabel]);
        }
    }

    public function down(): void
    {
        foreach ($this->labelMap as $oldLabel => $newLabel) {
            DB::table('site_settings')
                ->where('label', $newLabel)
                ->update(['label' => $oldLabel]);
        }
    }
};
