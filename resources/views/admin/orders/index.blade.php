@extends('layouts.admin')
@section('title', 'Siparisler')
@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <h2 class="text-xl font-semibold">Siparisler</h2>
    <a href="{{ route('admin.orders.export', request()->all()) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-download mr-2"></i>CSV Indir</a>
</div>

<!-- Status Tabs -->
<div class="flex flex-wrap gap-2 mb-6">
    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-purple-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">Tumu ({{ $statusCounts->sum() }})</a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">Bekleyen ({{ $statusCounts['pending'] ?? 0 }})</a>
    <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'confirmed' ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">Onaylanan ({{ $statusCounts['confirmed'] ?? 0 }})</a>
    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'processing' ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">Hazirlanan ({{ $statusCounts['processing'] ?? 0 }})</a>
    <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'shipped' ? 'bg-purple-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">Kargoda ({{ $statusCounts['shipped'] ?? 0 }})</a>
    <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'delivered' ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">Teslim ({{ $statusCounts['delivered'] ?? 0 }})</a>
</div>

<!-- Filters -->
<form method="GET" class="bg-white rounded-lg p-4 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Siparis no, musteri adi..." class="border rounded-lg px-3 py-2">
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded-lg px-3 py-2">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded-lg px-3 py-2">
        <button type="submit" class="bg-gray-800 text-white rounded-lg hover:bg-gray-900">Filtrele</button>
    </div>
</form>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Siparis</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Musteri</th><th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Tutar</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tarih</th><th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th></tr></thead>
        <tbody class="divide-y">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><p class="font-medium">{{ $order->order_number }}</p><p class="text-xs text-gray-500">{{ $order->items->count() }} urun</p></td>
                    <td class="px-4 py-3"><p class="font-medium">{{ $order->customer_name }}</p><p class="text-xs text-gray-500">{{ $order->customer_phone }}</p></td>
                    <td class="px-4 py-3 text-right font-semibold">{{ number_format($order->total, 2) }} TL</td>
                    <td class="px-4 py-3 text-center"><form action="{{ route('admin.orders.update-status', $order) }}" method="POST">@csrf @method('PATCH')<select name="status" onchange="this.form.submit()" class="text-xs border rounded px-2 py-1 {{ $order->status_badge_class }}"><option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Bekleyen</option><option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Onaylanan</option><option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Hazirlanan</option><option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Kargoda</option><option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Teslim</option><option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Iptal</option></select></form></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-eye"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Siparis bulunamadi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
