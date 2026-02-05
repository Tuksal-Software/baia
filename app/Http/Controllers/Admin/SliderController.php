<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SliderController extends Controller
{
    /**
     * Display slider list
     */
    public function index(): View
    {
        $sliders = Slider::ordered()->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('admin.sliders.create');
    }

    /**
     * Store new slider
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'button_style' => 'required|in:primary,secondary,outline',
            'text_position' => 'required|in:left,center,right',
            'text_color' => 'nullable|string|max:20',
            'overlay_color' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        // Handle image upload
        $validated['image'] = $request->file('image')->store('sliders', 'public');

        if ($request->hasFile('image_mobile')) {
            $validated['image_mobile'] = $request->file('image_mobile')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $request->input('order', Slider::max('order') + 1);

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider başarıyla oluşturuldu.');
    }

    /**
     * Show edit form
     */
    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update slider
     */
    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'button_style' => 'required|in:primary,secondary,outline',
            'text_position' => 'required|in:left,center,right',
            'text_color' => 'nullable|string|max:20',
            'overlay_color' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slider->image);
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        if ($request->hasFile('image_mobile')) {
            if ($slider->image_mobile) {
                Storage::disk('public')->delete($slider->image_mobile);
            }
            $validated['image_mobile'] = $request->file('image_mobile')->store('sliders', 'public');
        }

        // Handle image removal
        if ($request->boolean('remove_image_mobile') && $slider->image_mobile) {
            Storage::disk('public')->delete($slider->image_mobile);
            $validated['image_mobile'] = null;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider başarıyla güncellendi.');
    }

    /**
     * Delete slider
     */
    public function destroy(Slider $slider): RedirectResponse
    {
        Storage::disk('public')->delete($slider->image);

        if ($slider->image_mobile) {
            Storage::disk('public')->delete($slider->image_mobile);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider başarıyla silindi.');
    }

    /**
     * Update slider order (AJAX)
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'sliders' => 'required|array',
            'sliders.*.id' => 'required|exists:sliders,id',
            'sliders.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->sliders as $item) {
            Slider::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle slider status
     */
    public function toggleStatus(Slider $slider): RedirectResponse
    {
        $slider->is_active = !$slider->is_active;
        $slider->save();

        $status = $slider->is_active ? 'aktif' : 'pasif';

        return redirect()->back()
            ->with('success', "Slider {$status} yapıldı.");
    }
}
