<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\HomeSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeSectionController extends Controller
{
    /**
     * Display section list
     */
    public function index(): View
    {
        $sections = HomeSection::ordered()->get();
        $types = HomeSection::TYPES;

        return view('admin.home-sections.index', compact('sections', 'types'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $types = HomeSection::TYPES;
        $categories = Category::active()->root()->ordered()->get();
        $banners = Banner::active()->ordered()->get();

        return view('admin.home-sections.create', compact('types', 'categories', 'banners'));
    }

    /**
     * Store new section
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(HomeSection::TYPES)),
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'settings' => 'nullable|array',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $request->input('order', HomeSection::max('order') + 1);
        $validated['settings'] = $request->input('settings', []);

        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Bölüm başarıyla oluşturuldu.');
    }

    /**
     * Show edit form
     */
    public function edit(HomeSection $homeSection): View
    {
        $types = HomeSection::TYPES;
        $categories = Category::active()->root()->ordered()->get();
        $banners = Banner::active()->ordered()->get();

        return view('admin.home-sections.edit', compact('homeSection', 'types', 'categories', 'banners'));
    }

    /**
     * Update section
     */
    public function update(Request $request, HomeSection $homeSection): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(HomeSection::TYPES)),
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'settings' => 'nullable|array',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['settings'] = $request->input('settings', []);

        $homeSection->update($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Bölüm başarıyla güncellendi.');
    }

    /**
     * Delete section
     */
    public function destroy(HomeSection $homeSection): RedirectResponse
    {
        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Bölüm başarıyla silindi.');
    }

    /**
     * Update section order (AJAX)
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:home_sections,id',
            'sections.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->sections as $item) {
            HomeSection::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle section status
     */
    public function toggleStatus(HomeSection $homeSection): RedirectResponse
    {
        $homeSection->is_active = !$homeSection->is_active;
        $homeSection->save();

        $status = $homeSection->is_active ? 'aktif' : 'pasif';

        return redirect()->back()
            ->with('success', "Bölüm {$status} yapıldı.");
    }
}
