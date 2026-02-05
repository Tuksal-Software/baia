@extends('layouts.admin')
@section('title', 'Kategori Duzenle')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">Kategori Duzenle: {{ $category->name }}</h2></div>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg p-6">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Kategori Adi *</label><input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Ust Kategori</label><select name="parent_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"><option value="">- Ana Kategori -</option>@foreach($parentCategories as $parent)<option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Aciklama</label><textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('description', $category->description) }}</textarea></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Gorsel</label>@if($category->image)<div class="mb-2"><img src="{{ asset('storage/' . $category->image) }}" class="h-20 rounded"></div>@endif<input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-4 py-2"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Sira</label><input type="number" name="order" value="{{ old('order', $category->order) }}" min="0" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="rounded text-purple-600">Aktif</label></div>
        </div>
        <div class="mt-6 flex gap-3"><button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Guncelle</button><a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a></div>
    </form>
</div>
@endsection
