@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg p-4"><div class="flex items-center gap-3"><div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center"><i class="fas fa-box text-purple-600"></i></div><div><p class="text-2xl font-bold">{{ $stats['total_products'] }}</p><p class="text-sm text-gray-500">Toplam Urun</p></div></div></div>
    <div class="bg-white rounded-lg p-4"><div class="flex items-center gap-3"><div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-shopping-bag text-blue-600"></i></div><div><p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p><p class="text-sm text-gray-500">Toplam Siparis</p></div></div></div>
    <div class="bg-white rounded-lg p-4"><div class="flex items-center gap-3"><div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center"><i class="fas fa-clock text-yellow-600"></i></div><div><p class="text-2xl font-bold">{{ $stats['pending_orders'] }}</p><p class="text-sm text-gray-500">Bekleyen Siparis</p></div></div></div>
    <div class="bg-white rounded-lg p-4"><div class="flex items-center gap-3"><div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center"><i class="fas fa-star text-green-600"></i></div><div><p class="text-2xl font-bold">{{ $stats['pending_reviews'] }}</p><p class="text-sm text-gray-500">Bekleyen Yorum</p></div></div></div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg p-6">
        <div class="flex justify-between items-center mb-4"><h2 class="font-semibold">Son Siparisler</h2><a href="{{ route('admin.orders.index') }}" class="text-purple-600 text-sm hover:underline">Tumu</a></div>
        <div class="space-y-3">
            @forelse($recentOrders->take(5) as $order)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <div><p class="font-medium">{{ $order->order_number }}</p><p class="text-sm text-gray-500">{{ $order->customer_name }}</p></div>
                    <div class="text-right"><p class="font-semibold">{{ number_format($order->total, 2) }} TL</p><span class="text-xs px-2 py-1 rounded {{ $order->status_badge_class }}">{{ $order->status_label }}</span></div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Henuz siparis yok</p>
            @endforelse
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="bg-white rounded-lg p-6">
        <div class="flex justify-between items-center mb-4"><h2 class="font-semibold">Dusuk Stoklu Urunler</h2><a href="{{ route('admin.products.index', ['status' => 'low_stock']) }}" class="text-purple-600 text-sm hover:underline">Tumu</a></div>
        <div class="space-y-3">
            @forelse($lowStockProducts as $product)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <div><p class="font-medium">{{ $product->name }}</p><p class="text-sm text-gray-500">SKU: {{ $product->sku ?? '-' }}</p></div>
                    <span class="px-3 py-1 rounded text-sm {{ $product->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $product->stock }} adet</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Dusuk stoklu urun yok</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-6 bg-white rounded-lg p-6">
    <h2 class="font-semibold mb-4">Hizli Islemler</h2>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-plus"></i> Yeni Urun</a>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700"><i class="fas fa-folder-plus"></i> Yeni Kategori</a>
        <a href="{{ route('admin.discount-codes.create') }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-tags"></i> Yeni Indirim Kodu</a>
        <a href="{{ route('admin.orders.export') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-download"></i> Siparisleri Indir</a>
    </div>
</div>
@endsection
