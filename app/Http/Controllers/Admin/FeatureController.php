<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeatureController extends Controller
{
    /**
     * Feature positions
     */
    public const POSITIONS = [
        'home' => 'Ana Sayfa',
        'footer' => 'Footer',
    ];

    /**
     * Available icons
     */
    public const ICONS = [
        'truck' => 'Kargo',
        'shield-check' => 'Kalkan',
        'refresh-cw' => 'Yenileme',
        'credit-card' => 'Kredi Kartı',
        'headphones' => 'Kulaklık',
        'package' => 'Paket',
        'check-circle' => 'Onay',
        'clock' => 'Saat',
        'gift' => 'Hediye',
        'star' => 'Yıldız',
        'heart' => 'Kalp',
        'award' => 'Ödül',
    ];

    /**
     * Display feature list
     */
    public function index(Request $request): View
    {
        $query = Feature::ordered();

        if ($request->filled('position')) {
            $query->position($request->position);
        }

        $features = $query->get();
        $positions = self::POSITIONS;

        return view('admin.features.index', compact('features', 'positions'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $positions = self::POSITIONS;
        $icons = self::ICONS;

        return view('admin.features.create', compact('positions', 'icons'));
    }

    /**
     * Store new feature
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::POSITIONS)),
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $request->input('order', Feature::max('order') + 1);

        Feature::create($validated);

        return redirect()->route('admin.features.index')
            ->with('success', 'Özellik başarıyla oluşturuldu.');
    }

    /**
     * Show edit form
     */
    public function edit(Feature $feature): View
    {
        $positions = self::POSITIONS;
        $icons = self::ICONS;

        return view('admin.features.edit', compact('feature', 'positions', 'icons'));
    }

    /**
     * Update feature
     */
    public function update(Request $request, Feature $feature): RedirectResponse
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::POSITIONS)),
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $feature->update($validated);

        return redirect()->route('admin.features.index')
            ->with('success', 'Özellik başarıyla güncellendi.');
    }

    /**
     * Delete feature
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();

        return redirect()->route('admin.features.index')
            ->with('success', 'Özellik başarıyla silindi.');
    }

    /**
     * Update feature order (AJAX)
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'features' => 'required|array',
            'features.*.id' => 'required|exists:features,id',
            'features.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->features as $item) {
            Feature::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle feature status
     */
    public function toggleStatus(Feature $feature): RedirectResponse
    {
        $feature->is_active = !$feature->is_active;
        $feature->save();

        $status = $feature->is_active ? 'aktif' : 'pasif';

        return redirect()->back()
            ->with('success', "Özellik {$status} yapıldı.");
    }
}
