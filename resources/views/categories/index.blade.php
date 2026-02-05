@extends('layouts.app')
@section('title', 'Kategoriler')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Kategoriler</h1>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden group">
                @if($category->image)
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="w-full h-40 bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center"><i class="fas fa-couch text-4xl text-white/50"></i></div>
                @endif
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-purple-600">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $category->products_count }} Urun</p>
                    @if($category->children->count() > 0)
                        <div class="mt-2 text-xs text-gray-400">{{ $category->children->pluck('name')->implode(', ') }}</div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
