<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * MyMemory API endpoint
     */
    protected string $apiUrl = 'https://api.mymemory.translated.net/get';

    /**
     * Supported language pairs
     */
    protected array $supportedLanguages = ['tr', 'en', 'de'];

    /**
     * Translate text from source to target language.
     *
     * @param string $text Text to translate
     * @param string $from Source language code (tr, en, de)
     * @param string $to Target language code (tr, en, de)
     * @return string|null Translated text or null on failure
     */
    public function translate(string $text, string $from, string $to): ?string
    {
        // Don't translate if same language
        if ($from === $to) {
            return $text;
        }

        // Validate languages
        if (!in_array($from, $this->supportedLanguages) || !in_array($to, $this->supportedLanguages)) {
            Log::warning("Translation: Unsupported language pair {$from} -> {$to}");
            return null;
        }

        // Check cache first
        $cacheKey = "translation_{$from}_{$to}_" . md5($text);
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::timeout(10)->get($this->apiUrl, [
                'q' => $text,
                'langpair' => "{$from}|{$to}",
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['responseStatus']) && $data['responseStatus'] == 200) {
                    $translatedText = $data['responseData']['translatedText'] ?? null;

                    if ($translatedText) {
                        // Cache for 24 hours
                        Cache::put($cacheKey, $translatedText, now()->addHours(24));
                        return $translatedText;
                    }
                }

                Log::warning("Translation API returned non-200 status", [
                    'status' => $data['responseStatus'] ?? 'unknown',
                    'text' => substr($text, 0, 100),
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Translation API error: {$e->getMessage()}", [
                'from' => $from,
                'to' => $to,
                'text' => substr($text, 0, 100),
            ]);
        }

        return null;
    }

    /**
     * Translate text to multiple languages at once.
     *
     * @param string $text Text to translate
     * @param string $from Source language code
     * @param array $toLanguages Array of target language codes
     * @return array Associative array of language code => translated text
     */
    public function translateToMultiple(string $text, string $from, array $toLanguages): array
    {
        $translations = [$from => $text]; // Include original

        foreach ($toLanguages as $lang) {
            if ($lang === $from) {
                continue;
            }

            $translated = $this->translate($text, $from, $lang);
            $translations[$lang] = $translated ?? $text; // Fallback to original if failed
        }

        return $translations;
    }

    /**
     * Auto-translate all translatable fields from Turkish.
     *
     * @param array $fields Array of field names
     * @param array $data Request data containing Turkish values
     * @return array Translations array for spatie/laravel-translatable format
     */
    public function autoTranslateFields(array $fields, array $data): array
    {
        $translations = [];

        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                continue;
            }

            $turkishValue = $data[$field];

            // Get translations for all languages
            $translated = $this->translateToMultiple($turkishValue, 'tr', ['en', 'de']);

            $translations[$field] = $translated;
        }

        return $translations;
    }

    /**
     * Check if translation service is available.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl, [
                'q' => 'test',
                'langpair' => 'en|tr',
            ]);

            return $response->successful() && ($response->json()['responseStatus'] ?? 0) == 200;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get supported languages.
     *
     * @return array
     */
    public function getSupportedLanguages(): array
    {
        return config('app.available_locales', [
            'tr' => ['name' => 'Türkçe', 'native' => 'Türkçe', 'flag' => '🇹🇷'],
            'en' => ['name' => 'English', 'native' => 'English', 'flag' => '🇬🇧'],
            'de' => ['name' => 'German', 'native' => 'Deutsch', 'flag' => '🇩🇪'],
        ]);
    }
}
