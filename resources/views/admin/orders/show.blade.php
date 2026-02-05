@extends('layouts.admin')
@section('title', 'Siparis Detay')
@section('content')
<div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">{{ $order->order_number }}</h2><span class="px-3 py-1 rounded-full text-sm {{ $order->status_badge_class }}">{{ $order->status_label }}</span></div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Urunler</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <div><p class="font-medium">{{ $item->display_name }}</p><p class="text-sm text-gray-500">{{ number_format($item->price, 2) }} TL x {{ $item->quantity }}</p></div>
                        <p class="font-semibold">{{ number_format($item->total, 2) }} TL</p>
                    </div>
                @endforeach
            </div>
            <div class="border-t mt-4 pt-4 space-y-2">
                <div class="flex justify-between"><span class="text-gray-600">Ara Toplam</span><span>{{ number_format($order->subtotal, 2) }} TL</span></div>
                @if($order->discount > 0)<div class="flex justify-between text-green-600"><span>Indirim ({{ $order->discount_code }})</span><span>-{{ number_format($order->discount, 2) }} TL</span></div>@endif
                <div class="flex justify-between font-bold text-lg"><span>Toplam</span><span>{{ number_format($order->total, 2) }} TL</span></div>
            </div>
        </div>

        <!-- Notes -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Notlar</h3>
            @if($order->notes)<div class="bg-gray-50 rounded p-3 text-sm whitespace-pre-line mb-4">{{ $order->notes }}</div>@endif
            <form action="{{ route('admin.orders.add-note', $order) }}" method="POST">
                @csrf
                <textarea name="notes" rows="2" placeholder="Not ekle..." class="w-full border rounded-lg px-4 py-2 mb-2"></textarea>
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">Not Ekle</button>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Musteri Bilgileri</h3>
            <div class="space-y-3 text-sm">
                <div><span class="text-gray-500">Ad Soyad:</span><p class="font-medium">{{ $order->customer_name }}</p></div>
                <div><span class="text-gray-500">E-posta:</span><p>{{ $order->customer_email }}</p></div>
                <div><span class="text-gray-500">Telefon:</span><p><a href="tel:{{ $order->customer_phone }}" class="text-blue-600">{{ $order->customer_phone }}</a></p></div>
                @if($order->customer_address)<div><span class="text-gray-500">Adres:</span><p>{{ $order->customer_address }}</p></div>@endif
            </div>
            <a href="{{ $whatsappUrl }}" target="_blank" class="mt-4 w-full inline-flex items-center justify-center gap-2 bg-green-500 text-white py-2 rounded-lg hover:bg-green-600"><i class="fab fa-whatsapp"></i>WhatsApp</a>
        </div>

        <!-- Status -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Durum Guncelle</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" class="w-full border rounded-lg px-4 py-2 mb-3">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Bekleyen</option>
                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Onaylanan</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Hazirlanan</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Kargoda</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Teslim Edildi</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Iptal</option>
                </select>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">Guncelle</button>
            </form>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="font-semibold mb-4">Zaman Cizelgesi</h3>
            <div class="space-y-3 text-sm">
                <div class="flex gap-3"><i class="fas fa-circle text-xs text-green-500 mt-1"></i><div><p class="font-medium">Siparis Olusturuldu</p><p class="text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</p></div></div>
                @if($order->confirmed_at)<div class="flex gap-3"><i class="fas fa-circle text-xs text-blue-500 mt-1"></i><div><p class="font-medium">Onaylandi</p><p class="text-gray-500">{{ $order->confirmed_at->format('d.m.Y H:i') }}</p></div></div>@endif
            </div>
        </div>
    </div>
</div>
@endsection
