<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    use HandlesFileUploads;

    public const POSITIONS = [
        'home_top' => 'Ana Sayfa Üst',
        'home_middle' => 'Ana Sayfa Orta',
        'home_bottom' => 'Ana Sayfa Alt',
        'sidebar' => 'Sidebar',
        'category' => 'Kategori Sayfası',
        'product' => 'Ürün Sayfası',
    ];

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

    public function create(): View
    {
        $positions = self::POSITIONS;
        return view('admin.banners.create', compact('positions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::POSITIONS)),
            'title' => 'nullable|array',
            'title.tr' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'subtitle' => 'nullable|array',
            'subtitle.tr' => 'nullable|string|max:255',
            'subtitle.en' => 'nullable|string|max:255',
            'subtitle.de' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $bannerData = [
            'name' => $validated['name'],
            'position' => $validated['position'],
            'title' => isset($validated['title']) ? array_filter($validated['title']) : null,
            'subtitle' => isset($validated['subtitle']) ? array_filter($validated['subtitle']) : null,
            'link' => $validated['link'] ?? null,
            'order' => $request->input('order', Banner::max('order') + 1),
            'is_active' => $request->boolean('is_active', true),
            'starts_at' => $validated['starts_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
        ];

        $bannerData['image'] = $this->uploadFile($request->file('image'), 'banners');

        if ($request->hasFile('image_mobile')) {
            $bannerData['image_mobile'] = $this->uploadFile($request->file('image_mobile'), 'banners');
        }

        Banner::create($bannerData);

        return redirect()->route('admin.banners.index')
            ->with('success', __('Banner created successfully.'));
    }

    public function edit(Banner $banner): View
    {
        $positions = self::POSITIONS;
        return view('admin.banners.edit', compact('banner', 'positions'));
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|in:' . implode(',', array_keys(self::POSITIONS)),
            'title' => 'nullable|array',
            'title.tr' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'subtitle' => 'nullable|array',
            'subtitle.tr' => 'nullable|string|max:255',
            'subtitle.en' => 'nullable|string|max:255',
            'subtitle.de' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $bannerData = [
            'name' => $validated['name'],
            'position' => $validated['position'],
            'title' => isset($validated['title']) ? array_filter($validated['title']) : null,
            'subtitle' => isset($validated['subtitle']) ? array_filter($validated['subtitle']) : null,
            'link' => $validated['link'] ?? null,
            'order' => $validated['order'] ?? $banner->order,
            'is_active' => $request->boolean('is_active'),
            'starts_at' => $validated['starts_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $this->deleteFile($banner->image);
            $bannerData['image'] = $this->uploadFile($request->file('image'), 'banners');
        }

        if ($request->hasFile('image_mobile')) {
            $this->deleteFile($banner->image_mobile);
            $bannerData['image_mobile'] = $this->uploadFile($request->file('image_mobile'), 'banners');
        }

        if ($request->boolean('remove_image_mobile') && $banner->image_mobile) {
            $this->deleteFile($banner->image_mobile);
            $bannerData['image_mobile'] = null;
        }

        $banner->update($bannerData);

        return redirect()->route('admin.banners.index')
            ->with('success', __('Banner updated successfully.'));
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->deleteFile($banner->image);
        $this->deleteFile($banner->image_mobile);
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', __('Banner deleted successfully.'));
    }

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

    public function toggleStatus(Banner $banner): RedirectResponse
    {
        $banner->update(['is_active' => !$banner->is_active]);
        $status = $banner->is_active ? __('activated') : __('deactivated');

        return redirect()->back()->with('success', __('Banner :status.', ['status' => $status]));
    }
}
