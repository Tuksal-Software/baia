@extends('layouts.admin')

@section('title', __('Discount Code Detail'))

@section('breadcrumb')
    <a href="{{ route('admin.discount-codes.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Discount Codes') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $discountCode->code }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                <span class="font-mono bg-slate-100 px-3 py-1 rounded-lg">{{ $discountCode->code }}</span>
            </h1>
            <p class="text-sm text-slate-500 mt-2">{{ __('Discount code details') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-admin.button href="{{ route('admin.discount-codes.edit', $discountCode) }}" icon="fa-edit">
                {{ __('Edit') }}
            </x-admin.button>
            <form action="{{ route('admin.discount-codes.toggle-status', $discountCode) }}" method="POST">
                @csrf
                @method('PATCH')
                <x-admin.button type="submit" variant="secondary" icon="{{ $discountCode->is_active ? 'fa-pause' : 'fa-play' }}">
                    {{ $discountCode->is_active ? __('Deactivate') : __('Activate') }}
                </x-admin.button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Code Details -->
            <x-admin.card :title="__('Code Details')">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <span class="text-sm text-slate-500">{{ __('Discount Code') }}</span>
                        <p class="mt-1 font-mono text-lg font-bold text-slate-900 bg-slate-50 px-3 py-2 rounded-lg inline-block">
                            {{ $discountCode->code }}
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-slate-500">{{ __('Status') }}</span>
                        <p class="mt-1">
                            <x-admin.badge :variant="$discountCode->is_active ? 'success' : 'danger'" size="md" dot>
                                {{ $discountCode->is_active ? __('Active') : __('Inactive') }}
                            </x-admin.badge>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-slate-500">{{ __('Discount') }}</span>
                        <p class="mt-1 text-lg font-semibold text-slate-900">{{ $discountCode->formatted_value }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-slate-500">{{ __('Minimum Order Amount') }}</span>
                        <p class="mt-1 text-lg font-medium text-slate-900">
                            {{ $discountCode->min_order_amount > 0 ? number_format($discountCode->min_order_amount, 2) . ' TL' : '-' }}
                        </p>
                    </div>
                </div>
            </x-admin.card>

            <!-- Usage Stats -->
            <x-admin.card :title="__('Usage Statistics')">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <div class="text-3xl font-bold text-slate-900">{{ $discountCode->used_count }}</div>
                        <div class="text-sm text-slate-500 mt-1">{{ __('Used') }}</div>
                    </div>
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <div class="text-3xl font-bold text-slate-900">{{ $discountCode->usage_limit ?? '∞' }}</div>
                        <div class="text-sm text-slate-500 mt-1">{{ __('Limit') }}</div>
                    </div>
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        @php
                            $remaining = $discountCode->usage_limit ? ($discountCode->usage_limit - $discountCode->used_count) : null;
                        @endphp
                        <div class="text-3xl font-bold {{ $remaining !== null && $remaining <= 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                            {{ $remaining ?? '∞' }}
                        </div>
                        <div class="text-sm text-slate-500 mt-1">{{ __('Remaining') }}</div>
                    </div>
                </div>

                @if($discountCode->usage_limit)
                    <div class="mt-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-500">{{ __('Usage Rate') }}</span>
                            <span class="text-slate-700 font-medium">
                                {{ round(($discountCode->used_count / $discountCode->usage_limit) * 100) }}%
                            </span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full transition-all"
                                 style="width: {{ min(100, ($discountCode->used_count / $discountCode->usage_limit) * 100) }}%"></div>
                        </div>
                    </div>
                @endif
            </x-admin.card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Validity Period -->
            <x-admin.card :title="__('Validity Period')">
                <dl class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <dt class="text-slate-500">{{ __('Start') }}</dt>
                        <dd class="font-medium text-slate-900">
                            {{ $discountCode->starts_at?->format('d.m.Y') ?? __('Valid immediately') }}
                        </dd>
                    </div>
                    <div class="flex justify-between text-sm">
                        <dt class="text-slate-500">{{ __('End') }}</dt>
                        <dd class="font-medium text-slate-900">
                            {{ $discountCode->expires_at?->format('d.m.Y') ?? __('Indefinite') }}
                        </dd>
                    </div>
                    <div class="pt-3 border-t border-slate-100">
                        @php
                            $now = now();
                            $isValid = $discountCode->is_active
                                && (!$discountCode->starts_at || $discountCode->starts_at <= $now)
                                && (!$discountCode->expires_at || $discountCode->expires_at >= $now)
                                && (!$discountCode->usage_limit || $discountCode->used_count < $discountCode->usage_limit);
                        @endphp
                        <div class="flex items-center gap-3">
                            @if($isValid)
                                <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text-sm font-medium text-slate-900">{{ __('Valid') }}</span>
                            @else
                                <span class="w-8 h-8 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="text-sm font-medium text-slate-900">{{ __('Invalid') }}</span>
                            @endif
                        </div>
                    </div>
                </dl>
            </x-admin.card>

            <!-- Dates -->
            <x-admin.card :title="__('Dates')">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">{{ __('Created') }}</dt>
                        <dd class="text-slate-900">{{ $discountCode->created_at->format('d.m.Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">{{ __('Last Updated') }}</dt>
                        <dd class="text-slate-900">{{ $discountCode->updated_at->format('d.m.Y H:i') }}</dd>
                    </div>
                </dl>
            </x-admin.card>

            <!-- Actions -->
            <x-admin.card :title="__('Quick Actions')">
                <div class="space-y-2">
                    <x-admin.button href="{{ route('admin.discount-codes.edit', $discountCode) }}" variant="secondary" class="w-full justify-start" icon="fa-edit">
                        {{ __('Edit') }}
                    </x-admin.button>
                    <form action="{{ route('admin.discount-codes.toggle-status', $discountCode) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-admin.button type="submit" variant="secondary" class="w-full justify-start" icon="{{ $discountCode->is_active ? 'fa-pause' : 'fa-play' }}">
                            {{ $discountCode->is_active ? __('Deactivate') : __('Activate') }}
                        </x-admin.button>
                    </form>
                    <form action="{{ route('admin.discount-codes.destroy', $discountCode) }}"
                          method="POST"
                          onsubmit="return confirm('{{ __('Are you sure you want to delete this discount code?') }}')">
                        @csrf
                        @method('DELETE')
                        <x-admin.button type="submit" variant="outline-danger" class="w-full justify-start" icon="fa-trash">
                            {{ __('Delete') }}
                        </x-admin.button>
                    </form>
                </div>
            </x-admin.card>
        </div>
    </div>
@endsection
