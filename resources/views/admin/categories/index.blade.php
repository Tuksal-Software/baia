@extends('layouts.admin')
@section('title', 'Kategoriler')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Kategoriler ({{ $categories->count() }})</h2>
    <a href="{{ route('admin.categories.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-plus mr-2"></i>Yeni Kategori</a>
</div>
<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Kategori</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Ust Kategori</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Urunler</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th><th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th></tr></thead>
        <tbody class="divide-y">
            @foreach($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><div class="flex items-center gap-3">@if($category->image)<img src="{{ asset('storage/' . $category->image) }}" class="w-10 h-10 rounded object-cover">@else<div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center"><i class="fas fa-folder text-gray-400"></i></div>@endif<div><p class="font-medium">{{ $category->name }}</p><p class="text-xs text-gray-500">{{ $category->slug }}</p></div></div></td>
                    <td class="px-4 py-3 text-gray-600">{{ $category->parent?->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $category->products_count }}</td>
                    <td class="px-4 py-3 text-center"><form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="px-2 py-1 rounded text-xs {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $category->is_active ? 'Aktif' : 'Pasif' }}</button></form></td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a><form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button></form></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
