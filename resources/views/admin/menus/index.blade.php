@extends('layouts.admin')

@section('title', __('Menus'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Menus') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('Menus') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Manage site menus and items') }}</p>
    </div>

    <!-- Menu Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menus as $menu)
            <x-admin.card :padding="false">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $menu->name }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5">{{ __('Location') }}: {{ $menu->location }}</p>
                        </div>
                        <a href="{{ route('admin.menus.edit', $menu) }}"
                           class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                            <i class="fas fa-edit text-xs"></i>
                            {{ __('Edit') }}
                        </a>
                    </div>

                    <div class="border-t border-slate-200 pt-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-slate-600">{{ __('Menu Items') }}</span>
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
                                            <span class="text-xs text-slate-400">(+{{ $item->children->count() }} {{ __('sub') }})</span>
                                        @endif
                                    </li>
                                @endforeach
                                @if($menu->items->count() > 5)
                                    <li class="text-xs text-slate-400 pl-3.5">+{{ $menu->items->count() - 5 }} {{ __('more') }}...</li>
                                @endif
                            </ul>
                        @else
                            <p class="text-sm text-slate-400">{{ __('No menu items yet') }}</p>
                        @endif
                    </div>
                </div>
            </x-admin.card>
        @endforeach
    </div>
@endsection
