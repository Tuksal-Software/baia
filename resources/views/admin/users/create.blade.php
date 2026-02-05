@extends('layouts.admin')

@section('title', __('New User'))

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Users') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New User') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New User') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Add a new user to the system') }}</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('User Information')">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            :label="__('Full Name')"
                            :placeholder="__('Username')"
                            required
                        />

                        <x-admin.form-input
                            name="email"
                            type="email"
                            :label="__('Email')"
                            :placeholder="__('example@email.com')"
                            required
                        />

                        <x-admin.form-input
                            name="password"
                            type="password"
                            :label="__('Password')"
                            :placeholder="__('At least 8 characters')"
                            required
                        />

                        <x-admin.form-input
                            name="password_confirmation"
                            type="password"
                            :label="__('Confirm Password')"
                            :placeholder="__('Enter password again')"
                            required
                        />
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card :title="__('Permission')">
                    <x-admin.form-toggle
                        name="is_admin"
                        :label="__('Admin Permission')"
                        :description="__('This user can access the admin panel')"
                    />
                </x-admin.card>

                <x-admin.card>
                    <div class="space-y-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            {{ __('Create User') }}
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
