@extends('layouts.admin')
@section('title', 'Slider Duzenle')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.sliders.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-semibold">Slider Duzenle</h2>
    </div>

    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg p-6">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Baslik</label>
                <input type="text" name="title" value="{{ old('title', $slider->title) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alt Baslik</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Aciklama</label>
                <textarea name="description" rows="2" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('description', $slider->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gorsel (Desktop)</label>
                <div class="flex items-start gap-4">
                    <img src="{{ $slider->image_url }}" class="w-40 h-24 object-cover rounded border">
                    <input type="file" name="image" accept="image/*" class="flex-1 border rounded-lg px-4 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gorsel (Mobil)</label>
                <div class="flex items-start gap-4">
                    @if($slider->image_mobile)
                        <div class="relative">
                            <img src="{{ $slider->mobile_image_url }}" class="w-24 h-32 object-cover rounded border">
                            <label class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer hover:bg-red-600">
                                <input type="checkbox" name="remove_image_mobile" value="1" class="hidden">
                                <i class="fas fa-times text-xs"></i>
                            </label>
                        </div>
                    @endif
                    <input type="file" name="image_mobile" accept="image/*" class="flex-1 border rounded-lg px-4 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buton Metni</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slider->button_text) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buton Linki</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $slider->button_link) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buton Stili</label>
                    <select name="button_style" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="primary" {{ old('button_style', $slider->button_style) === 'primary' ? 'selected' : '' }}>Primary</option>
                        <option value="secondary" {{ old('button_style', $slider->button_style) === 'secondary' ? 'selected' : '' }}>Secondary</option>
                        <option value="outline" {{ old('button_style', $slider->button_style) === 'outline' ? 'selected' : '' }}>Outline</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metin Pozisyonu</label>
                    <select name="text_position" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="left" {{ old('text_position', $slider->text_position) === 'left' ? 'selected' : '' }}>Sol</option>
                        <option value="center" {{ old('text_position', $slider->text_position) === 'center' ? 'selected' : '' }}>Orta</option>
                        <option value="right" {{ old('text_position', $slider->text_position) === 'right' ? 'selected' : '' }}>Sag</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metin Rengi</label>
                    <input type="color" name="text_color" value="{{ old('text_color', $slider->text_color) }}" class="w-full h-10 border rounded-lg cursor-pointer">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Overlay Rengi</label>
                <input type="text" name="overlay_color" value="{{ old('overlay_color', $slider->overlay_color) }}" placeholder="rgba(0,0,0,0.3)" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Baslangic Tarihi</label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $slider->starts_at?->format('Y-m-d\TH:i')) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bitis Tarihi</label>
                    <input type="datetime-local" name="ends_at" value="{{ old('ends_at', $slider->ends_at?->format('Y-m-d\TH:i')) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sira</label>
                <input type="number" name="order" value="{{ old('order', $slider->order) }}" min="0" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }} class="rounded text-purple-600">
                    Aktif
                </label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Guncelle</button>
            <a href="{{ route('admin.sliders.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a>
        </div>
    </form>
</div>
@endsection
