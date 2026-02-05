@extends('layouts.admin')
@section('title', 'Yeni Slider')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.sliders.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-semibold">Yeni Slider</h2>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg p-6">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Baslik</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alt Baslik</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Aciklama</label>
                <textarea name="description" rows="2" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gorsel (Desktop) *</label>
                <input type="file" name="image" accept="image/*" required class="w-full border rounded-lg px-4 py-2">
                <p class="text-xs text-gray-500 mt-1">Onerilen boyut: 1920x800px</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gorsel (Mobil)</label>
                <input type="file" name="image_mobile" accept="image/*" class="w-full border rounded-lg px-4 py-2">
                <p class="text-xs text-gray-500 mt-1">Onerilen boyut: 768x600px</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buton Metni</label>
                    <input type="text" name="button_text" value="{{ old('button_text') }}" placeholder="Orn: Kesfet" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buton Linki</label>
                    <input type="text" name="button_link" value="{{ old('button_link') }}" placeholder="/kategori/..." class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buton Stili</label>
                    <select name="button_style" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="primary" {{ old('button_style') === 'primary' ? 'selected' : '' }}>Primary</option>
                        <option value="secondary" {{ old('button_style') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                        <option value="outline" {{ old('button_style') === 'outline' ? 'selected' : '' }}>Outline</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metin Pozisyonu</label>
                    <select name="text_position" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="left" {{ old('text_position') === 'left' ? 'selected' : '' }}>Sol</option>
                        <option value="center" {{ old('text_position', 'center') === 'center' ? 'selected' : '' }}>Orta</option>
                        <option value="right" {{ old('text_position') === 'right' ? 'selected' : '' }}>Sag</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metin Rengi</label>
                    <input type="color" name="text_color" value="{{ old('text_color', '#ffffff') }}" class="w-full h-10 border rounded-lg cursor-pointer">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Overlay Rengi</label>
                <input type="text" name="overlay_color" value="{{ old('overlay_color') }}" placeholder="rgba(0,0,0,0.3)" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Baslangic Tarihi</label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bitis Tarihi</label>
                    <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sira</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-purple-600">
                    Aktif
                </label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Kaydet</button>
            <a href="{{ route('admin.sliders.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a>
        </div>
    </form>
</div>
@endsection
