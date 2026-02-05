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
    public static function getPositions(): array
    {
        return [
            'home' => __('Home'),
            'footer' => __('Footer'),
        ];
    }

    public static function getIcons(): array
    {
        return [
            'truck' => __('Truck'),
            'shield-check' => __('Shield'),
            'refresh-cw' => __('Refresh'),
            'credit-card' => __('Credit Card'),
            'headphones' => __('Headphones'),
            'package' => __('Package'),
            'check-circle' => __('Check'),
            'clock' => __('Clock'),
            'gift' => __('Gift'),
            'star' => __('Star'),
            'heart' => __('Heart'),
            'award' => __('Award'),
        ];
    }

    public function index(Request $request): View
    {
        $query = Feature::ordered();

        if ($request->filled('position')) {
            $query->position($request->position);
        }

        $features = $query->get();
        $positions = self::getPositions();

        return view('admin.features.index', compact('features', 'positions'));
    }

    public function create(): View
    {
        $positions = self::getPositions();
        $icons = self::getIcons();

        return view('admin.features.create', compact('positions', 'icons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|array',
            'title.tr' => 'required|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.tr' => 'nullable|string|max:500',
            'description.en' => 'nullable|string|max:500',
            'description.de' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::getPositions())),
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
        ]);

        Feature::create([
            'icon' => $validated['icon'],
            'title' => array_filter($validated['title']),
            'description' => isset($validated['description']) ? array_filter($validated['description']) : null,
            'link' => $validated['link'] ?? null,
            'position' => $validated['position'],
            'order' => $request->input('order', Feature::max('order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.features.index')
            ->with('success', __('Feature created successfully.'));
    }

    public function edit(Feature $feature): View
    {
        $positions = self::getPositions();
        $icons = self::getIcons();

        return view('admin.features.edit', compact('feature', 'positions', 'icons'));
    }

    public function update(Request $request, Feature $feature): RedirectResponse
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|array',
            'title.tr' => 'required|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.tr' => 'nullable|string|max:500',
            'description.en' => 'nullable|string|max:500',
            'description.de' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::getPositions())),
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
        ]);

        $feature->update([
            'icon' => $validated['icon'],
            'title' => array_filter($validated['title']),
            'description' => isset($validated['description']) ? array_filter($validated['description']) : null,
            'link' => $validated['link'] ?? null,
            'position' => $validated['position'],
            'order' => $validated['order'] ?? $feature->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.features.index')
            ->with('success', __('Feature updated successfully.'));
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        $feature->delete();

        return redirect()->route('admin.features.index')
            ->with('success', __('Feature deleted successfully.'));
    }

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

    public function toggleStatus(Feature $feature): RedirectResponse
    {
        $feature->update(['is_active' => !$feature->is_active]);
        $status = $feature->is_active ? __('activated') : __('deactivated');

        return redirect()->back()->with('success', __('Feature :status.', ['status' => $status]));
    }
}
