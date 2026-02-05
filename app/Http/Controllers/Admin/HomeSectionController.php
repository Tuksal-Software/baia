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
    public function index(): View
    {
        $sections = HomeSection::ordered()->get();
        $types = HomeSection::TYPES;

        return view('admin.home-sections.index', compact('sections', 'types'));
    }

    public function create(): View
    {
        $types = HomeSection::TYPES;
        $categories = Category::active()->root()->ordered()->get();
        $banners = Banner::active()->ordered()->get();

        return view('admin.home-sections.create', compact('types', 'categories', 'banners'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(HomeSection::TYPES)),
            'title' => 'nullable|array',
            'title.tr' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'subtitle' => 'nullable|array',
            'subtitle.tr' => 'nullable|string|max:255',
            'subtitle.en' => 'nullable|string|max:255',
            'subtitle.de' => 'nullable|string|max:255',
            'settings' => 'nullable|array',
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
        ]);

        HomeSection::create([
            'type' => $validated['type'],
            'title' => isset($validated['title']) ? array_filter($validated['title']) : null,
            'subtitle' => isset($validated['subtitle']) ? array_filter($validated['subtitle']) : null,
            'settings' => $request->input('settings', []),
            'order' => $request->input('order', HomeSection::max('order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.home-sections.index')
            ->with('success', __('Section created successfully.'));
    }

    public function edit(HomeSection $homeSection): View
    {
        $types = HomeSection::TYPES;
        $categories = Category::active()->root()->ordered()->get();
        $banners = Banner::active()->ordered()->get();

        return view('admin.home-sections.edit', compact('homeSection', 'types', 'categories', 'banners'));
    }

    public function update(Request $request, HomeSection $homeSection): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys(HomeSection::TYPES)),
            'title' => 'nullable|array',
            'title.tr' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'subtitle' => 'nullable|array',
            'subtitle.tr' => 'nullable|string|max:255',
            'subtitle.en' => 'nullable|string|max:255',
            'subtitle.de' => 'nullable|string|max:255',
            'settings' => 'nullable|array',
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
        ]);

        $homeSection->update([
            'type' => $validated['type'],
            'title' => isset($validated['title']) ? array_filter($validated['title']) : null,
            'subtitle' => isset($validated['subtitle']) ? array_filter($validated['subtitle']) : null,
            'settings' => $request->input('settings', []),
            'order' => $validated['order'] ?? $homeSection->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.home-sections.index')
            ->with('success', __('Section updated successfully.'));
    }

    public function destroy(HomeSection $homeSection): RedirectResponse
    {
        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', __('Section deleted successfully.'));
    }

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

    public function toggleStatus(HomeSection $homeSection): RedirectResponse
    {
        $homeSection->update(['is_active' => !$homeSection->is_active]);
        $status = $homeSection->is_active ? __('activated') : __('deactivated');

        return redirect()->back()->with('success', __('Section :status.', ['status' => $status]));
    }
}
