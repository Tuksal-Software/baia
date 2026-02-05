@extends('layouts.admin')
@section('title', 'Menuler')
@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold">Menuler</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($menus as $menu)
        <div class="bg-white rounded-lg p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-semibold text-lg">{{ $menu->name }}</h3>
                    <p class="text-sm text-gray-500">Konum: {{ $menu->location }}</p>
                </div>
                <a href="{{ route('admin.menus.edit', $menu) }}" class="text-purple-600 hover:text-purple-800">
                    <i class="fas fa-edit"></i> Duzenle
                </a>
            </div>

            <div class="border-t pt-4">
                <p class="text-sm text-gray-600 mb-2">Menu Ogeleri ({{ $menu->items->count() }})</p>
                @if($menu->items->count() > 0)
                    <ul class="space-y-1 text-sm">
                        @foreach($menu->items->take(5) as $item)
                            <li class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-gray-300 rounded-full"></span>
                                <span>{{ $item->title }}</span>
                                @if($item->children->count() > 0)
                                    <span class="text-xs text-gray-400">(+{{ $item->children->count() }} alt)</span>
                                @endif
                            </li>
                        @endforeach
                        @if($menu->items->count() > 5)
                            <li class="text-gray-400 text-xs">+{{ $menu->items->count() - 5 }} daha...</li>
                        @endif
                    </ul>
                @else
                    <p class="text-gray-400 text-sm">Henuz menu ogesi yok</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
