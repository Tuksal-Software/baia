<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function __construct(
        protected TranslationService $translationService
    ) {}

    /**
     * Translate text to multiple languages.
     */
    public function translate(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'from' => 'required|string|in:tr,en,de',
            'to' => 'required|array',
            'to.*' => 'string|in:tr,en,de',
        ]);

        $text = $request->input('text');
        $from = $request->input('from', 'tr');
        $toLanguages = $request->input('to', ['en', 'de']);

        $translations = $this->translationService->translateToMultiple($text, $from, $toLanguages);

        return response()->json([
            'success' => true,
            'translations' => $translations,
        ]);
    }

    /**
     * Translate a single field.
     */
    public function translateField(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'from' => 'required|string|in:tr,en,de',
            'to' => 'required|string|in:tr,en,de',
        ]);

        $translated = $this->translationService->translate(
            $request->input('text'),
            $request->input('from', 'tr'),
            $request->input('to')
        );

        if ($translated === null) {
            return response()->json([
                'success' => false,
                'message' => __('Çeviri yapılamadı. Lütfen daha sonra tekrar deneyin.'),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'translation' => $translated,
        ]);
    }

    /**
     * Check translation service status.
     */
    public function status(): JsonResponse
    {
        $isAvailable = $this->translationService->isAvailable();

        return response()->json([
            'available' => $isAvailable,
            'languages' => $this->translationService->getSupportedLanguages(),
        ]);
    }
}
