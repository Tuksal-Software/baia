@extends('layouts.app')
@section('title', 'Siparis Alindi')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto text-center">
        <div class="bg-white rounded-lg p-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fas fa-check text-4xl text-green-500"></i></div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Siparisini Aldik!</h1>
            <p class="text-gray-600 mb-6">Siparis numaraniz: <strong>{{ $order->order_number }}</strong></p>
            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <h3 class="font-semibold mb-3">Siparis Detayi</h3>
                @foreach($order->items as $item)<div class="flex justify-between text-sm py-1"><span>{{ $item->display_name }} x{{ $item->quantity }}</span><span>{{ number_format($item->total, 2) }} TL</span></div>@endforeach
                <div class="border-t mt-2 pt-2 flex justify-between font-bold"><span>Toplam</span><span>{{ number_format($order->total, 2) }} TL</span></div>
            </div>
            <a href="{{ $whatsappUrl }}" target="_blank" class="inline-block bg-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-600 mb-4"><i class="fab fa-whatsapp mr-2"></i>WhatsApp'tan Iletisime Gec</a>
            <p class="text-sm text-gray-500">Siparisini onaylamak icin WhatsApp uzerinden bizimle iletisime gecin.</p>
            <a href="{{ route('home') }}" class="inline-block mt-6 text-purple-600 hover:underline">Ana Sayfaya Don</a>
        </div>
    </div>
</div>
@endsection
