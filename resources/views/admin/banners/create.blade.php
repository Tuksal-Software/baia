@extends('layouts.admin')
@section('title', 'Yeni Banner')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.banners.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-semibold">Yeni Banner</h2>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg p-6">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Banner Adi *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pozisyon *</label>
                <select name="position" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                    @foreach($positions as $key => $label)
                        <option value="{{ $key }}" {{ old('position') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Baslik</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alt Baslik</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gorsel (Desktop) *</label>
                <input type="file" name="image" accept="image/*" required class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gorsel (Mobil)</label>
                <input type="file" name="image_mobile" accept="image/*" class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link</label>
                <input type="text" name="link" value="{{ old('link') }}" placeholder="/kategori/..." class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
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
            <a href="{{ route('admin.banners.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a>
        </div>
    </form>
</div>
@endsection
