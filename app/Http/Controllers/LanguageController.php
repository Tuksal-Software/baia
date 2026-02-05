<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Switch the application locale.
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $availableLocales = array_keys(config('app.available_locales', []));

        if (!in_array($locale, $availableLocales)) {
            return back()->with('error', __('Geçersiz dil seçimi.'));
        }

        // Store locale in session
        session(['locale' => $locale]);

        // Set locale for current request
        App::setLocale($locale);

        return back();
    }
}
