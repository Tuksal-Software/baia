<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display settings grouped by category
     */
    public function index(Request $request): View
    {
        $groups = [
            'general' => 'Genel Ayarlar',
            'header' => 'Header Ayarları',
            'footer' => 'Footer Ayarları',
            'contact' => 'İletişim Bilgileri',
            'social' => 'Sosyal Medya',
            'seo' => 'SEO Ayarları',
        ];

        $activeGroup = $request->get('group', 'general');
        $settings = SiteSetting::byGroup($activeGroup)->ordered()->get();

        return view('admin.settings.index', compact('groups', 'activeGroup', 'settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request): RedirectResponse
    {
        $settings = $request->input('settings', []);
        $group = $request->input('group', 'general');

        foreach ($settings as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();

            if (!$setting) {
                continue;
            }

            // Handle file upload for image type
            if ($setting->type === 'image' && $request->hasFile("settings.{$key}")) {
                // Delete old image
                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                $value = $request->file("settings.{$key}")->store('settings', 'public');
            }

            // Handle boolean type
            if ($setting->type === 'boolean') {
                $value = $value ? '1' : '0';
            }

            $setting->update(['value' => $value]);
        }

        // Handle image removals
        $removeImages = $request->input('remove_images', []);
        foreach ($removeImages as $key => $shouldRemove) {
            if ($shouldRemove) {
                $setting = SiteSetting::where('key', $key)->first();
                if ($setting && $setting->value) {
                    Storage::disk('public')->delete($setting->value);
                    $setting->update(['value' => null]);
                }
            }
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.settings.index', ['group' => $group])
            ->with('success', 'Ayarlar başarıyla güncellendi.');
    }
}
