<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    use HandlesFileUploads;

    public function index(): View
    {
        $sliders = Slider::ordered()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create(): View
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|array',
            'title.tr' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'subtitle' => 'nullable|array',
            'subtitle.tr' => 'nullable|string|max:255',
            'subtitle.en' => 'nullable|string|max:255',
            'subtitle.de' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.tr' => 'nullable|string|max:1000',
            'description.en' => 'nullable|string|max:1000',
            'description.de' => 'nullable|string|max:1000',
            'button_text' => 'nullable|array',
            'button_text.tr' => 'nullable|string|max:100',
            'button_text.en' => 'nullable|string|max:100',
            'button_text.de' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'button_link' => 'nullable|string|max:255',
            'button_style' => 'required|in:primary,secondary,outline',
            'text_position' => 'required|in:left,center,right',
            'text_color' => 'nullable|string|max:20',
            'overlay_color' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $sliderData = [
            'title' => isset($validated['title']) ? array_filter($validated['title']) : null,
            'subtitle' => isset($validated['subtitle']) ? array_filter($validated['subtitle']) : null,
            'description' => isset($validated['description']) ? array_filter($validated['description']) : null,
            'button_text' => isset($validated['button_text']) ? array_filter($validated['button_text']) : null,
            'button_link' => $validated['button_link'] ?? null,
            'button_style' => $validated['button_style'],
            'text_position' => $validated['text_position'],
            'text_color' => $validated['text_color'] ?? '#ffffff',
            'overlay_color' => $validated['overlay_color'] ?? null,
            'order' => $request->input('order', Slider::max('order') + 1),
            'is_active' => $request->boolean('is_active', true),
            'starts_at' => $validated['starts_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
        ];

        $sliderData['image'] = $this->uploadFile($request->file('image'), 'sliders');

        if ($request->hasFile('image_mobile')) {
            $sliderData['image_mobile'] = $this->uploadFile($request->file('image_mobile'), 'sliders');
        }

        Slider::create($sliderData);

        return redirect()->route('admin.sliders.index')
            ->with('success', __('Slider created successfully.'));
    }

    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|array',
            'title.tr' => 'nullable|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'title.de' => 'nullable|string|max:255',
            'subtitle' => 'nullable|array',
            'subtitle.tr' => 'nullable|string|max:255',
            'subtitle.en' => 'nullable|string|max:255',
            'subtitle.de' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'description.tr' => 'nullable|string|max:1000',
            'description.en' => 'nullable|string|max:1000',
            'description.de' => 'nullable|string|max:1000',
            'button_text' => 'nullable|array',
            'button_text.tr' => 'nullable|string|max:100',
            'button_text.en' => 'nullable|string|max:100',
            'button_text.de' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'button_link' => 'nullable|string|max:255',
            'button_style' => 'required|in:primary,secondary,outline',
            'text_position' => 'required|in:left,center,right',
            'text_color' => 'nullable|string|max:20',
            'overlay_color' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'nullable',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $sliderData = [
            'title' => isset($validated['title']) ? array_filter($validated['title']) : null,
            'subtitle' => isset($validated['subtitle']) ? array_filter($validated['subtitle']) : null,
            'description' => isset($validated['description']) ? array_filter($validated['description']) : null,
            'button_text' => isset($validated['button_text']) ? array_filter($validated['button_text']) : null,
            'button_link' => $validated['button_link'] ?? null,
            'button_style' => $validated['button_style'],
            'text_position' => $validated['text_position'],
            'text_color' => $validated['text_color'] ?? '#ffffff',
            'overlay_color' => $validated['overlay_color'] ?? null,
            'order' => $validated['order'] ?? $slider->order,
            'is_active' => $request->boolean('is_active'),
            'starts_at' => $validated['starts_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $this->deleteFile($slider->image);
            $sliderData['image'] = $this->uploadFile($request->file('image'), 'sliders');
        }

        if ($request->hasFile('image_mobile')) {
            $this->deleteFile($slider->image_mobile);
            $sliderData['image_mobile'] = $this->uploadFile($request->file('image_mobile'), 'sliders');
        }

        if ($request->boolean('remove_image_mobile') && $slider->image_mobile) {
            $this->deleteFile($slider->image_mobile);
            $sliderData['image_mobile'] = null;
        }

        $slider->update($sliderData);

        return redirect()->route('admin.sliders.index')
            ->with('success', __('Slider updated successfully.'));
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        $this->deleteFile($slider->image);
        $this->deleteFile($slider->image_mobile);
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', __('Slider deleted successfully.'));
    }

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

    public function toggleStatus(Slider $slider): RedirectResponse
    {
        $slider->update(['is_active' => !$slider->is_active]);
        $status = $slider->is_active ? __('activated') : __('deactivated');

        return redirect()->back()->with('success', __('Slider :status.', ['status' => $status]));
    }
}
