@extends('layouts.admin')

@section('title', $user->name)

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Users') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $user->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center">
                <span class="text-2xl font-semibold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ $user->name }}</h1>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <x-admin.button href="{{ route('admin.users.edit', $user) }}" icon="fa-edit">
                {{ __('Edit') }}
            </x-admin.button>
            @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                    @csrf
                    @method('DELETE')
                    <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                        {{ __('Delete') }}
                    </x-admin.button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card :title="__('User Information')">
                <dl class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">{{ __('Full Name') }}</dt>
                        <dd class="text-sm text-slate-900 mt-1 sm:mt-0">{{ $user->name }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">{{ __('Email') }}</dt>
                        <dd class="text-sm text-slate-900 mt-1 sm:mt-0">{{ $user->email }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">{{ __('Role') }}</dt>
                        <dd class="mt-1 sm:mt-0">
                            @if($user->is_admin)
                                <x-admin.badge variant="primary" dot>{{ __('Admin') }}</x-admin.badge>
                            @else
                                <x-admin.badge variant="default">{{ __('User') }}</x-admin.badge>
                            @endif
                        </dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">{{ __('Registration Date') }}</dt>
                        <dd class="text-sm text-slate-900 mt-1 sm:mt-0">{{ $user->created_at->format('d.m.Y H:i') }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">{{ __('Email Verification') }}</dt>
                        <dd class="mt-1 sm:mt-0">
                            @if($user->email_verified_at)
                                <x-admin.badge variant="success" dot>{{ __('Verified') }}</x-admin.badge>
                                <span class="text-xs text-slate-500 ml-2">{{ $user->email_verified_at->format('d.m.Y') }}</span>
                            @else
                                <x-admin.badge variant="warning">{{ __('Not Verified') }}</x-admin.badge>
                            @endif
                        </dd>
                    </div>
                </dl>
            </x-admin.card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <x-admin.card :title="__('Quick Actions')">
                <div class="space-y-3">
                    <x-admin.button href="{{ route('admin.users.edit', $user) }}" variant="secondary" class="w-full" icon="fa-edit">
                        {{ __('Edit User') }}
                    </x-admin.button>

                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <x-admin.button type="submit" variant="secondary" class="w-full" icon="{{ $user->is_admin ? 'fa-user-minus' : 'fa-user-shield' }}">
                                {{ $user->is_admin ? __('Remove Admin Permission') : __('Grant Admin Permission') }}
                            </x-admin.button>
                        </form>
                    @endif
                </div>
            </x-admin.card>

            <x-admin.card :title="__('Activity')">
                <div class="text-sm text-slate-500 text-center py-4">
                    {{ __('User activity history will appear here') }}
                </div>
            </x-admin.card>
        </div>
    </div>
@endsection
