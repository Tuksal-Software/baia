@extends('layouts.admin')

@section('title', __('New Discount Code'))

@section('breadcrumb')
    <a href="{{ route('admin.discount-codes.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Discount Codes') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('New Code') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ __('New Discount Code') }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ __('Create a new discount code') }}</p>
    </div>

    <form action="{{ route('admin.discount-codes.store') }}" method="POST">
        @csrf

        <div class="max-w-2xl">
            <x-admin.card :title="__('Code Information')">
                <div class="space-y-4">
                    <div>
                        <label for="code" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('Code') }}
                        </label>
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <input type="text"
                                       name="code"
                                       id="code"
                                       value="{{ old('code') }}"
                                       placeholder="{{ __('Auto-generated if left empty') }}"
                                       class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 uppercase
                                              focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-primary-500 focus:ring-primary-200
                                              @error('code') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            </div>
                            <x-admin.button type="button" variant="secondary" onclick="generateCode()">
                                {{ __('Generate') }}
                            </x-admin.button>
                        </div>
                        @error('code')
                            <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-admin.form-select
                        name="type"
                        :label="__('Discount Type')"
                        :value="old('type', 'percentage')"
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
                        :value="old('value')"
                        step="0.01"
                        min="0"
                        required
                        :hint="__('0-100 for percentage, TL amount for fixed')"
                    />

                    <x-admin.form-input
                        name="min_order_amount"
                        type="number"
                        :label="__('Minimum Order Amount (TL)')"
                        :value="old('min_order_amount')"
                        step="0.01"
                        min="0"
                        :hint="__('Invalid for orders below this amount')"
                    />

                    <x-admin.form-input
                        name="usage_limit"
                        type="number"
                        :label="__('Usage Limit')"
                        :value="old('usage_limit')"
                        min="1"
                        :placeholder="__('Empty = unlimited')"
                        :hint="__('Unlimited usage if left empty')"
                    />
                </div>
            </x-admin.card>

            <x-admin.card :title="__('Validity Period')" class="mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-admin.form-input
                        name="starts_at"
                        type="date"
                        :label="__('Start Date')"
                        :value="old('starts_at')"
                        :hint="__('Empty = valid immediately')"
                    />

                    <x-admin.form-input
                        name="expires_at"
                        type="date"
                        :label="__('End Date')"
                        :value="old('expires_at')"
                        :hint="__('Empty = valid indefinitely')"
                    />
                </div>
            </x-admin.card>

            <x-admin.card :title="__('Status')" class="mt-6">
                <x-admin.form-toggle
                    name="is_active"
                    :label="__('Active')"
                    :description="__('Code starts as active')"
                    :checked="old('is_active', true)"
                />
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    {{ __('Save') }}
                </x-admin.button>
                <x-admin.button href="{{ route('admin.discount-codes.index') }}" variant="ghost">
                    {{ __('Cancel') }}
                </x-admin.button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
async function generateCode() {
    const response = await fetch('{{ route("admin.discount-codes.generate") }}');
    const data = await response.json();
    document.querySelector('input[name="code"]').value = data.code;
}
</script>
@endpush
