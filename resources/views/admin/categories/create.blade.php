@extends('layouts.admin')
@section('title', 'Yeni Kategori')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">Yeni Kategori</h2></div>
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg p-6">
        @csrf
        <div class="space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Kategori Adi *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug') }}" placeholder="Bos birakilirsa otomatik olusturulur" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Ust Kategori</label><select name="parent_id" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"><option value="">- Ana Kategori -</option>@foreach($parentCategories as $parent)<option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Aciklama</label><textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('description') }}</textarea></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Gorsel</label><input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-4 py-2"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Sira</label><input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-purple-600">Aktif</label></div>
        </div>
        <div class="mt-6 flex gap-3"><button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Kaydet</button><a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a></div>
    </form>
</div>
@endsection
