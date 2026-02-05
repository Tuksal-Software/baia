@extends('layouts.admin')

@section('title', __('Edit Discount Code'))

@section('breadcrumb')
    <a href="{{ route('admin.discount-codes.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Discount Codes') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $discountCode->code }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit Discount Code') }}</h1>
            <p class="text-sm text-slate-500 mt-1">
                <span class="font-mono bg-slate-100 px-2 py-0.5 rounded">{{ $discountCode->code }}</span>
            </p>
        </div>
        <form action="{{ route('admin.discount-codes.destroy', $discountCode) }}"
              method="POST"
              onsubmit="return confirm('{{ __('Are you sure you want to delete this discount code?') }}')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                {{ __('Delete') }}
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.discount-codes.update', $discountCode) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="max-w-2xl">
            <x-admin.card :title="__('Code Information')">
                <div class="space-y-4">
                    <x-admin.form-input
                        name="code"
                        :label="__('Code')"
                        :value="$discountCode->code"
                        class="uppercase"
                        required
                    />

                    <x-admin.form-select
                        name="type"
                        :label="__('Discount Type')"
                        :value="$discountCode->type"
                        :options="[
                            'percentage' => __('Percentage (%)'),
                            'fixed' => __('Fixed (TL)'),
                        ]"
                        required
                    />

                    <x-admin.form-input
                        name="value"
                        type="number"
                        :label="__('Value')"
                        :value="$discountCode->value"
                        step="0.01"
                        min="0"
                        required
                        :hint="__('0-100 for percentage, TL amount for fixed')"
                    />

                    <x-admin.form-input
                        name="min_order_amount"
                        type="number"
                        :label="__('Minimum Order Amount (TL)')"
                        :value="$discountCode->min_order_amount"
                        step="0.01"
                        min="0"
                        :hint="__('Invalid for orders below this amount')"
                    />

                    <x-admin.form-input
                        name="usage_limit"
                        type="number"
                        :label="__('Usage Limit')"
                        :value="$discountCode->usage_limit"
                        min="1"
                        :hint="__('Used: :count', ['count' => $discountCode->used_count])"
                    />
                </div>
            </x-admin.card>

            <x-admin.card :title="__('Validity Period')" class="mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-admin.form-input
                        name="starts_at"
                        type="date"
                        :label="__('Start Date')"
                        :value="$discountCode->starts_at?->format('Y-m-d')"
                    />

                    <x-admin.form-input
                        name="expires_at"
                        type="date"
                        :label="__('End Date')"
                        :value="$discountCode->expires_at?->format('Y-m-d')"
                    />
                </div>
            </x-admin.card>

            <x-admin.card :title="__('Status')" class="mt-6">
                <x-admin.form-toggle
                    name="is_active"
                    :label="__('Active')"
                    :description="__('Code can be used by customers')"
                    :checked="$discountCode->is_active"
                />
            </x-admin.card>

            <x-admin.card :title="__('Information')" class="mt-6">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">{{ __('Usage') }}</span>
                        <span class="text-slate-900 font-medium">
                            {{ $discountCode->used_count }} / {{ $discountCode->usage_limit ?? __('Unlimited') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">{{ __('Created') }}</span>
                        <span class="text-slate-900">{{ $discountCode->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">{{ __('Last Updated') }}</span>
                        <span class="text-slate-900">{{ $discountCode->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    {{ __('Save Changes') }}
                </x-admin.button>
                <x-admin.button href="{{ route('admin.discount-codes.index') }}" variant="ghost">
                    {{ __('Cancel') }}
                </x-admin.button>
            </div>
        </div>
    </form>
@endsection
