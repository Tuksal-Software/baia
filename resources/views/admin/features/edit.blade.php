@extends('layouts.admin')
@section('title', 'Ozellik Duzenle')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.features.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-semibold">Ozellik Duzenle</h2>
    </div>

    <form action="{{ route('admin.features.update', $feature) }}" method="POST" class="bg-white rounded-lg p-6">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ikon *</label>
                <select name="icon" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                    @foreach($icons as $key => $label)
                        <option value="{{ $key }}" {{ old('icon', $feature->icon) === $key ? 'selected' : '' }}>{{ $label }} ({{ $key }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Baslik *</label>
                <input type="text" name="title" value="{{ old('title', $feature->title) }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Aciklama</label>
                <textarea name="description" rows="2" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('description', $feature->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link</label>
                <input type="text" name="link" value="{{ old('link', $feature->link) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pozisyon *</label>
                <select name="position" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                    @foreach($positions as $key => $label)
                        <option value="{{ $key }}" {{ old('position', $feature->position) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sira</label>
                <input type="number" name="order" value="{{ old('order', $feature->order) }}" min="0" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $feature->is_active) ? 'checked' : '' }} class="rounded text-purple-600">
                    Aktif
                </label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Guncelle</button>
            <a href="{{ route('admin.features.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a>
        </div>
    </form>
</div>
@endsection
