@extends('layouts.admin')

@section('title', __('Edit User'))

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Users') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $user->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit User') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $user->email }}</p>
        </div>
        @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}"
                  method="POST"
                  onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                @csrf
                @method('DELETE')
                <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                    {{ __('Delete User') }}
                </x-admin.button>
            </form>
        @endif
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('User Information')">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            :label="__('Full Name')"
                            :value="$user->name"
                            required
                        />

                        <x-admin.form-input
                            name="email"
                            type="email"
                            :label="__('Email')"
                            :value="$user->email"
                            required
                        />

                        <div class="pt-4 border-t border-slate-200">
                            <p class="text-sm font-medium text-slate-700 mb-3">{{ __('Change Password') }}</p>
                            <p class="text-xs text-slate-500 mb-4">{{ __('Leave blank if you do not want to change the password') }}</p>

                            <div class="space-y-4">
                                <x-admin.form-input
                                    name="password"
                                    type="password"
                                    :label="__('New Password')"
                                    :placeholder="__('At least 8 characters')"
                                />

                                <x-admin.form-input
                                    name="password_confirmation"
                                    type="password"
                                    :label="__('Confirm New Password')"
                                    :placeholder="__('Enter password again')"
                                />
                            </div>
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card :title="__('Permission')">
                    @if($user->id === auth()->id())
                        <x-admin.alert type="warning" class="mb-4">
                            {{ __('You cannot change your own admin status') }}
                        </x-admin.alert>
                        <x-admin.form-toggle
                            name="is_admin"
                            :label="__('Admin Permission')"
                            :checked="$user->is_admin"
                            disabled
                        />
                        <input type="hidden" name="is_admin" value="{{ $user->is_admin ? '1' : '' }}">
                    @else
                        <x-admin.form-toggle
                            name="is_admin"
                            :label="__('Admin Permission')"
                            :description="__('This user can access the admin panel')"
                            :checked="$user->is_admin"
                        />
                    @endif
                </x-admin.card>

                <x-admin.card :title="__('Information')">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Registration Date') }}</span>
                            <span class="text-slate-900">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Last Updated') }}</span>
                            <span class="text-slate-900">{{ $user->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="space-y-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            {{ __('Save Changes') }}
                        </x-admin.button>
                        <x-admin.button href="{{ route('admin.users.index') }}" variant="ghost" class="w-full">
                            {{ __('Cancel') }}
                        </x-admin.button>
                    </div>
                </x-admin.card>
            </div>
        </div>
    </form>
@endsection
