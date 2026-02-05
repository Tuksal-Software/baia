<?php

namespace App\Providers;

use App\Models\Feature;
use App\Models\Menu;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share global data with all views using View::share (runs once)
        try {
            View::share('siteSettings', Schema::hasTable('site_settings') ? SiteSetting::getAllCached() : []);
            View::share('headerMenu', Schema::hasTable('menus') ? Menu::getByLocation('header') : null);
            View::share('footerMenu', Schema::hasTable('menus') ? Menu::getByLocation('footer') : null);
            View::share('footerSecondaryMenu', Schema::hasTable('menus') ? Menu::getByLocation('footer_secondary') : null);
            View::share('footerFeatures', Schema::hasTable('features') ? Feature::active()->position('footer')->ordered()->get() : collect());
        } catch (\Exception $e) {
            // Fallback to empty values if database is not available
            View::share('siteSettings', []);
            View::share('headerMenu', null);
            View::share('footerMenu', null);
            View::share('footerSecondaryMenu', null);
            View::share('footerFeatures', collect());
        }
    }
}
