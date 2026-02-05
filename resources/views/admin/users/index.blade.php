@extends('layouts.admin')

@section('title', __('Users'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Users') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Users') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('Manage all users') }}</p>
        </div>
        <x-admin.button href="{{ route('admin.users.create') }}" icon="fa-plus">
            {{ __('New User') }}
        </x-admin.button>
    </div>

    <!-- Filters -->
    <x-admin.card class="mb-6" :padding="false">
        <form action="{{ route('admin.users.index') }}" method="GET" class="p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <x-admin.form-input
                        name="search"
                        :placeholder="__('Search by name or email...')"
                        :value="request('search')"
                        icon="fa-search"
                    />
                </div>
                <div class="w-full sm:w-48">
                    <x-admin.form-select
                        name="role"
                        :value="request('role')"
                        :options="['' => __('All Roles'), 'admin' => __('Admin'), 'user' => __('User')]"
                        :placeholder="__('Select Role')"
                    />
                </div>
                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="secondary" icon="fa-filter">
                        {{ __('Filter') }}
                    </x-admin.button>
                    @if(request()->hasAny(['search', 'role']))
                        <x-admin.button href="{{ route('admin.users.index') }}" variant="ghost">
                            {{ __('Clear') }}
                        </x-admin.button>
                    @endif
                </div>
            </div>
        </form>
    </x-admin.card>

    <!-- Users Table -->
    <x-admin.data-table :headers="[
        __('User'),
        __('Email'),
        __('Role'),
        __('Registration Date'),
        ['label' => __('Actions'), 'class' => 'text-right', 'width' => '120px']
    ]">
        @forelse($users as $user)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                            @if($user->id === auth()->id())
                                <span class="text-xs text-primary-600">{{ __('(You)') }}</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-600">{{ $user->email }}</span>
                </td>
                <td class="px-4 py-3">
                    @if($user->is_admin)
                        <x-admin.badge variant="primary" size="sm" dot>{{ __('Admin') }}</x-admin.badge>
                    @else
                        <x-admin.badge variant="default" size="sm">{{ __('User') }}</x-admin.badge>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-500">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                           title="{{ __('View') }}">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="{{ __('Edit') }}">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="{{ $user->is_admin ? __('Remove admin permission') : __('Grant admin permission') }}">
                                    <i class="fas {{ $user->is_admin ? 'fa-user-minus' : 'fa-user-shield' }} text-sm"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                        title="{{ __('Delete') }}">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-users"
                        :title="__('No users found')"
                        :description="__('No users matching your search criteria')"
                    />
                </td>
            </tr>
        @endforelse

        <x-slot:footer>
            {{ $users->links() }}
        </x-slot:footer>
    </x-admin.data-table>
@endsection
