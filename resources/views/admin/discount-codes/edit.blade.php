@extends('layouts.admin')

@section('title', 'Indirim Kodu Duzenle')

@section('breadcrumb')
    <a href="{{ route('admin.discount-codes.index') }}" class="text-slate-500 hover:text-slate-700">Indirim Kodlari</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $discountCode->code }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Indirim Kodu Duzenle</h1>
            <p class="text-sm text-slate-500 mt-1">
                <span class="font-mono bg-slate-100 px-2 py-0.5 rounded">{{ $discountCode->code }}</span>
            </p>
        </div>
        <form action="{{ route('admin.discount-codes.destroy', $discountCode) }}"
              method="POST"
              onsubmit="return confirm('Bu indirim kodunu silmek istediginizden emin misiniz?')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                Sil
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.discount-codes.update', $discountCode) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="max-w-2xl">
            <x-admin.card title="Kod Bilgileri">
                <div class="space-y-4">
                    <x-admin.form-input
                        name="code"
                        label="Kod"
                        :value="$discountCode->code"
                        class="uppercase"
                        required
                    />

                    <x-admin.form-select
                        name="type"
                        label="Indirim Tipi"
                        :value="$discountCode->type"
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
                        :value="$discountCode->value"
                        step="0.01"
                        min="0"
                        required
                        hint="Yuzde icin 0-100 arasi, sabit icin TL cinsinden"
                    />

                    <x-admin.form-input
                        name="min_order_amount"
                        type="number"
                        label="Minimum Siparis Tutari (TL)"
                        :value="$discountCode->min_order_amount"
                        step="0.01"
                        min="0"
                        hint="Bu tutarin altindaki siparislerde gecersiz"
                    />

                    <x-admin.form-input
                        name="usage_limit"
                        type="number"
                        label="Kullanim Limiti"
                        :value="$discountCode->usage_limit"
                        min="1"
                        hint="Kullanildi: {{ $discountCode->used_count }}"
                    />
                </div>
            </x-admin.card>

            <x-admin.card title="Gecerlilik Suresi" class="mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-admin.form-input
                        name="starts_at"
                        type="date"
                        label="Baslangic Tarihi"
                        :value="$discountCode->starts_at?->format('Y-m-d')"
                    />

                    <x-admin.form-input
                        name="expires_at"
                        type="date"
                        label="Bitis Tarihi"
                        :value="$discountCode->expires_at?->format('Y-m-d')"
                    />
                </div>
            </x-admin.card>

            <x-admin.card title="Durum" class="mt-6">
                <x-admin.form-toggle
                    name="is_active"
                    label="Aktif"
                    description="Kod musteriler tarafindan kullanilabilir"
                    :checked="$discountCode->is_active"
                />
            </x-admin.card>

            <x-admin.card title="Bilgi" class="mt-6">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kullanim</span>
                        <span class="text-slate-900 font-medium">
                            {{ $discountCode->used_count }} / {{ $discountCode->usage_limit ?? 'Sinirsiz' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Olusturulma</span>
                        <span class="text-slate-900">{{ $discountCode->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Son Guncelleme</span>
                        <span class="text-slate-900">{{ $discountCode->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    Degisiklikleri Kaydet
                </x-admin.button>
                <x-admin.button href="{{ route('admin.discount-codes.index') }}" variant="ghost">
                    Iptal
                </x-admin.button>
            </div>
        </div>
    </form>
@endsection
