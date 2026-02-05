@extends('layouts.admin')

@section('title', 'Yeni Indirim Kodu')

@section('breadcrumb')
    <a href="{{ route('admin.discount-codes.index') }}" class="text-slate-500 hover:text-slate-700">Indirim Kodlari</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Kod</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Indirim Kodu</h1>
        <p class="text-sm text-slate-500 mt-1">Yeni bir indirim kodu olusturun</p>
    </div>

    <form action="{{ route('admin.discount-codes.store') }}" method="POST">
        @csrf

        <div class="max-w-2xl">
            <x-admin.card title="Kod Bilgileri">
                <div class="space-y-4">
                    <div>
                        <label for="code" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Kod
                        </label>
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <input type="text"
                                       name="code"
                                       id="code"
                                       value="{{ old('code') }}"
                                       placeholder="Bos birakilirsa otomatik olusturulur"
                                       class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 uppercase
                                              focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-primary-500 focus:ring-primary-200
                                              @error('code') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            </div>
                            <x-admin.button type="button" variant="secondary" onclick="generateCode()">
                                Olustur
                            </x-admin.button>
                        </div>
                        @error('code')
                            <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-admin.form-select
                        name="type"
                        label="Indirim Tipi"
                        :value="old('type', 'percentage')"
                        :options="[
                            'percentage' => 'Yuzde (%)',
                            'fixed' => 'Sabit (TL)',
                        ]"
                        required
                    />

                    <x-admin.form-input
                        name="value"
                        type="number"
                        label="Deger"
                        :value="old('value')"
                        step="0.01"
                        min="0"
                        required
                        hint="Yuzde icin 0-100 arasi, sabit icin TL cinsinden"
                    />

                    <x-admin.form-input
                        name="min_order_amount"
                        type="number"
                        label="Minimum Siparis Tutari (TL)"
                        :value="old('min_order_amount')"
                        step="0.01"
                        min="0"
                        hint="Bu tutarin altindaki siparislerde gecersiz"
                    />

                    <x-admin.form-input
                        name="usage_limit"
                        type="number"
                        label="Kullanim Limiti"
                        :value="old('usage_limit')"
                        min="1"
                        placeholder="Bos = sinirsiz"
                        hint="Bos birakilirsa sinirsiz kullanim"
                    />
                </div>
            </x-admin.card>

            <x-admin.card title="Gecerlilik Suresi" class="mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-admin.form-input
                        name="starts_at"
                        type="date"
                        label="Baslangic Tarihi"
                        :value="old('starts_at')"
                        hint="Bos = hemen gecerli"
                    />

                    <x-admin.form-input
                        name="expires_at"
                        type="date"
                        label="Bitis Tarihi"
                        :value="old('expires_at')"
                        hint="Bos = suresiz gecerli"
                    />
                </div>
            </x-admin.card>

            <x-admin.card title="Durum" class="mt-6">
                <x-admin.form-toggle
                    name="is_active"
                    label="Aktif"
                    description="Kod aktif olarak baslasin"
                    :checked="old('is_active', true)"
                />
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    Kaydet
                </x-admin.button>
                <x-admin.button href="{{ route('admin.discount-codes.index') }}" variant="ghost">
                    Iptal
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
