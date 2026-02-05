<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    use HandlesFileUploads;

    public function index(Request $request): View
    {
        $groups = [
            'general' => __('General Settings'),
            'header' => __('Header Settings'),
            'footer' => __('Footer Settings'),
            'contact' => __('Contact Information'),
            'social' => __('Social Media'),
            'seo' => __('SEO Settings'),
        ];

        $activeGroup = $request->get('group', 'general');
        $settings = SiteSetting::byGroup($activeGroup)->ordered()->get();

        return view('admin.settings.index', compact('groups', 'activeGroup', 'settings'));
    }

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
                $this->deleteFile($setting->value);
                $value = $this->uploadFile($request->file("settings.{$key}"), 'settings');
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
                    $this->deleteFile($setting->value);
                    $setting->update(['value' => null]);
                }
            }
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.settings.index', ['group' => $group])
            ->with('success', __('Settings updated successfully.'));
    }
}
