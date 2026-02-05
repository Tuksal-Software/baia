<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BannerController extends Controller
{
    /**
     * Banner positions
     */
    public const POSITIONS = [
        'home_top' => 'Ana Sayfa Üst',
        'home_middle' => 'Ana Sayfa Orta',
        'home_bottom' => 'Ana Sayfa Alt',
        'sidebar' => 'Sidebar',
        'category' => 'Kategori Sayfası',
        'product' => 'Ürün Sayfası',
    ];

    /**
     * Display banner list
     */
    public function index(Request $request): View
    {
        $query = Banner::ordered();

        if ($request->filled('position')) {
            $query->position($request->position);
        }

        $banners = $query->get();
        $positions = self::POSITIONS;

        return view('admin.banners.index', compact('banners', 'positions'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $positions = self::POSITIONS;

        return view('admin.banners.create', compact('positions'));
    }

    /**
     * Store new banner
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::POSITIONS)),
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        // Handle image upload
        $validated['image'] = $request->file('image')->store('banners', 'public');

        if ($request->hasFile('image_mobile')) {
            $validated['image_mobile'] = $request->file('image_mobile')->store('banners', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $request->input('order', Banner::max('order') + 1);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner başarıyla oluşturuldu.');
    }

    /**
     * Show edit form
     */
    public function edit(Banner $banner): View
    {
        $positions = self::POSITIONS;

        return view('admin.banners.edit', compact('banner', 'positions'));
    }

    /**
     * Update banner
     */
    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::POSITIONS)),
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        if ($request->hasFile('image_mobile')) {
            if ($banner->image_mobile) {
                Storage::disk('public')->delete($banner->image_mobile);
            }
            $validated['image_mobile'] = $request->file('image_mobile')->store('banners', 'public');
        }

        // Handle image removal
        if ($request->boolean('remove_image_mobile') && $banner->image_mobile) {
            Storage::disk('public')->delete($banner->image_mobile);
            $validated['image_mobile'] = null;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner başarıyla güncellendi.');
    }

    /**
     * Delete banner
     */
    public function destroy(Banner $banner): RedirectResponse
    {
        Storage::disk('public')->delete($banner->image);

        if ($banner->image_mobile) {
            Storage::disk('public')->delete($banner->image_mobile);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner başarıyla silindi.');
    }

    /**
     * Update banner order (AJAX)
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'banners' => 'required|array',
            'banners.*.id' => 'required|exists:banners,id',
            'banners.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->banners as $item) {
            Banner::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle banner status
     */
    public function toggleStatus(Banner $banner): RedirectResponse
    {
        $banner->is_active = !$banner->is_active;
        $banner->save();

        $status = $banner->is_active ? 'aktif' : 'pasif';

        return redirect()->back()
            ->with('success', "Banner {$status} yapıldı.");
    }
}
