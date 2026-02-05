@extends('layouts.admin')
@section('title', 'Indirim Kodlari')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Indirim Kodlari</h2>
    <a href="{{ route('admin.discount-codes.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-plus mr-2"></i>Yeni Kod</a>
</div>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Kod</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Indirim</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Min. Tutar</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Kullanim</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Gecerlilik</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th><th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th></tr></thead>
        <tbody class="divide-y">
            @forelse($discountCodes as $code)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono font-semibold">{{ $code->code }}</td>
                    <td class="px-4 py-3">{{ $code->formatted_value }}</td>
                    <td class="px-4 py-3">{{ $code->min_order_amount > 0 ? number_format($code->min_order_amount, 2) . ' TL' : '-' }}</td>
                    <td class="px-4 py-3 text-center">{{ $code->used_count }} / {{ $code->usage_limit ?? '∞' }}</td>
                    <td class="px-4 py-3 text-sm">@if($code->starts_at || $code->expires_at){{ $code->starts_at?->format('d.m.Y') ?? '-' }} - {{ $code->expires_at?->format('d.m.Y') ?? '-' }}@else<span class="text-gray-400">Sinirsiz</span>@endif</td>
                    <td class="px-4 py-3 text-center"><form action="{{ route('admin.discount-codes.toggle-status', $code) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="px-2 py-1 rounded text-xs {{ $code->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $code->is_active ? 'Aktif' : 'Pasif' }}</button></form></td>
                    <td class="px-4 py-3 text-right whitespace-nowrap"><a href="{{ route('admin.discount-codes.edit', $code) }}" class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-edit"></i></a><form action="{{ route('admin.discount-codes.destroy', $code) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button></form></td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Indirim kodu bulunamadi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $discountCodes->links() }}</div>
@endsection
