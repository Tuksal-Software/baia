<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_settings')
            ->whereIn('key', ['currency_symbol', 'currency_code'])
            ->delete();
    }

    public function down(): void
    {
        DB::table('site_settings')->insert([
            ['group' => 'general', 'key' => 'currency_symbol', 'value' => '₺', 'type' => 'text', 'label' => 'Para Birimi Sembolü', 'order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'general', 'key' => 'currency_code', 'value' => 'TRY', 'type' => 'text', 'label' => 'Para Birimi Kodu', 'order' => 7, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
};
