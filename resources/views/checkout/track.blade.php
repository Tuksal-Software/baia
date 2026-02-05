@extends('layouts.app')
@section('title', 'Siparis Takip')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Siparis Takip</h1>
        <form method="GET" class="bg-white rounded-lg p-6 mb-6">
            <label class="block text-sm text-gray-600 mb-2">Siparis Numarasi</label>
            <div class="flex gap-2"><input type="text" name="order_number" value="{{ request('order_number') }}" placeholder="ORD-XXXXXXXX-XXXX" class="flex-1 border rounded-lg px-4 py-2"><button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Sorgula</button></div>
        </form>
        @if($error)<div class="bg-red-100 text-red-700 p-4 rounded-lg">{{ $error }}</div>@endif
        @if($order)
            <div class="bg-white rounded-lg p-6">
                <div class="flex justify-between items-start mb-4"><div><h2 class="font-bold text-lg">{{ $order->order_number }}</h2><p class="text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</p></div><span class="px-3 py-1 rounded-full text-sm {{ $order->status_badge_class }}">{{ $order->status_label }}</span></div>
                <div class="border-t pt-4">
                    <h3 class="font-semibold mb-2">Urunler</h3>
                    @foreach($order->items as $item)<div class="flex justify-between text-sm py-1"><span>{{ $item->display_name }} x{{ $item->quantity }}</span><span>{{ number_format($item->total, 2) }} TL</span></div>@endforeach
                    <div class="border-t mt-2 pt-2 flex justify-between font-bold"><span>Toplam</span><span>{{ number_format($order->total, 2) }} TL</span></div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
