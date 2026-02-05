@extends('layouts.admin')

@section('title', 'Menuler')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Menuler</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Menuler</h1>
        <p class="text-sm text-slate-500 mt-1">Site menuleri ve ogelerini yonetin</p>
    </div>

    <!-- Menu Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menus as $menu)
            <x-admin.card :padding="false">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $menu->name }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Konum: {{ $menu->location }}</p>
                        </div>
                        <a href="{{ route('admin.menus.edit', $menu) }}"
                           class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                            <i class="fas fa-edit text-xs"></i>
                            Duzenle
                        </a>
                    </div>

                    <div class="border-t border-slate-200 pt-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-slate-600">Menu Ogeleri</span>
                            <x-admin.badge variant="default" size="sm">
                                {{ $menu->items->count() }}
                            </x-admin.badge>
                        </div>

                        @if($menu->items->count() > 0)
                            <ul class="space-y-2">
                                @foreach($menu->items->take(5) as $item)
                                    <li class="flex items-center gap-2 text-sm">
                                        <span class="w-1.5 h-1.5 bg-slate-300 rounded-full"></span>
                                        <span class="text-slate-700">{{ $item->title }}</span>
                                        @if($item->children->count() > 0)
                                            <span class="text-xs text-slate-400">(+{{ $item->children->count() }} alt)</span>
                                        @endif
                                    </li>
                                @endforeach
                                @if($menu->items->count() > 5)
                                    <li class="text-xs text-slate-400 pl-3.5">+{{ $menu->items->count() - 5 }} daha...</li>
                                @endif
                            </ul>
                        @else
                            <p class="text-sm text-slate-400">Henuz menu ogesi yok</p>
                        @endif
                    </div>
                </div>
            </x-admin.card>
        @endforeach
    </div>
@endsection
