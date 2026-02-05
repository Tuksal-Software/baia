<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get available locales from config
        $availableLocales = array_keys(config('app.available_locales', ['tr', 'en', 'de']));

        // Priority: 1. Session, 2. Browser preference, 3. Default
        $locale = session('locale');

        if (!$locale || !in_array($locale, $availableLocales)) {
            // Try to detect from browser
            $browserLocale = $request->getPreferredLanguage($availableLocales);
            $locale = $browserLocale ?: config('app.locale', 'tr');
        }

        // Validate locale
        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale', 'tr');
        }

        // Set the application locale
        App::setLocale($locale);

        // Share locale with all views
        view()->share('currentLocale', $locale);
        view()->share('availableLocales', config('app.available_locales'));

        return $next($request);
    }
}
