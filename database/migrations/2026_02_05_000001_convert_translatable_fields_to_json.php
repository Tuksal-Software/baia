<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Convert existing text values to JSON format for translatable fields.
     */
    public function up(): void
    {
        // Convert products translatable fields
        $this->convertToJson('products', ['name', 'short_description', 'description']);

        // Convert categories translatable fields
        $this->convertToJson('categories', ['name', 'description']);

        // Convert sliders translatable fields
        $this->convertToJson('sliders', ['title', 'subtitle', 'description', 'button_text']);

        // Convert banners translatable fields
        $this->convertToJson('banners', ['title', 'subtitle']);

        // Convert home_sections translatable fields
        $this->convertToJson('home_sections', ['title', 'subtitle']);

        // Convert features translatable fields
        $this->convertToJson('features', ['title', 'description']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert JSON back to plain text (extract Turkish value)
        $this->convertFromJson('products', ['name', 'short_description', 'description']);
        $this->convertFromJson('categories', ['name', 'description']);
        $this->convertFromJson('sliders', ['title', 'subtitle', 'description', 'button_text']);
        $this->convertFromJson('banners', ['title', 'subtitle']);
        $this->convertFromJson('home_sections', ['title', 'subtitle']);
        $this->convertFromJson('features', ['title', 'description']);
    }

    /**
     * Convert plain text fields to JSON format with Turkish as default.
     */
    private function convertToJson(string $table, array $columns): void
    {
        $records = DB::table($table)->get();

        foreach ($records as $record) {
            $updates = [];

            foreach ($columns as $column) {
                $value = $record->$column ?? null;

                // Skip if already JSON
                if ($value && $this->isJson($value)) {
                    continue;
                }

                // Convert to JSON with Turkish as default
                if ($value !== null) {
                    $updates[$column] = json_encode(['tr' => $value], JSON_UNESCAPED_UNICODE);
                }
            }

            if (!empty($updates)) {
                DB::table($table)->where('id', $record->id)->update($updates);
            }
        }
    }

    /**
     * Convert JSON fields back to plain text (extract Turkish value).
     */
    private function convertFromJson(string $table, array $columns): void
    {
        $records = DB::table($table)->get();

        foreach ($records as $record) {
            $updates = [];

            foreach ($columns as $column) {
                $value = $record->$column ?? null;

                // Only process if it's JSON
                if ($value && $this->isJson($value)) {
                    $decoded = json_decode($value, true);
                    $updates[$column] = $decoded['tr'] ?? $decoded[array_key_first($decoded)] ?? null;
                }
            }

            if (!empty($updates)) {
                DB::table($table)->where('id', $record->id)->update($updates);
            }
        }
    }

    /**
     * Check if a string is valid JSON.
     */
    private function isJson(?string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
};
