@extends('layouts.admin')
@section('title', 'Indirim Kodu Detay')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.discount-codes.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">{{ $discountCode->code }}</h2></div>
    <div class="bg-white rounded-lg p-6">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500">Kod</span><p class="font-mono font-bold text-lg">{{ $discountCode->code }}</p></div>
            <div><span class="text-gray-500">Durum</span><p><span class="px-2 py-1 rounded text-xs {{ $discountCode->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $discountCode->is_active ? 'Aktif' : 'Pasif' }}</span></p></div>
            <div><span class="text-gray-500">Indirim</span><p class="font-semibold">{{ $discountCode->formatted_value }}</p></div>
            <div><span class="text-gray-500">Min. Siparis</span><p>{{ $discountCode->min_order_amount > 0 ? number_format($discountCode->min_order_amount, 2) . ' TL' : '-' }}</p></div>
            <div><span class="text-gray-500">Kullanim</span><p>{{ $discountCode->used_count }} / {{ $discountCode->usage_limit ?? 'Sinirsiz' }}</p></div>
            <div><span class="text-gray-500">Gecerlilik</span><p>{{ $discountCode->starts_at?->format('d.m.Y') ?? '-' }} - {{ $discountCode->expires_at?->format('d.m.Y') ?? '-' }}</p></div>
        </div>
        <div class="border-t pt-4 mt-4 flex gap-3">
            <a href="{{ route('admin.discount-codes.edit', $discountCode) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-edit mr-2"></i>Duzenle</a>
            <form action="{{ route('admin.discount-codes.toggle-status', $discountCode) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">{{ $discountCode->is_active ? 'Pasif Yap' : 'Aktif Yap' }}</button></form>
        </div>
    </div>
</div>
@endsection
