@extends('layouts.app')
@section('title', 'Sepetim')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Sepetim</h1>
    @if($cart->items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg overflow-hidden">
                    @foreach($cart->items as $item)
                        <div class="flex gap-4 p-4 border-b">
                            @if($item->product->primaryImage)
                                <img src="{{ $item->product->primaryImage->image_url }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center"><i class="fas fa-image text-gray-400"></i></div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800"><a href="{{ route('products.show', $item->product) }}" class="hover:text-purple-600">{{ $item->display_name }}</a></h3>
                                <p class="text-purple-600 font-semibold">{{ number_format($item->price, 2) }} TL</p>
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2 mt-2">
                                    @csrf @method('PATCH')
                                    <div class="flex items-center border rounded">
                                        <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="px-2 py-1 hover:bg-gray-100">-</button>
                                        <span class="px-3">{{ $item->quantity }}</span>
                                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="px-2 py-1 hover:bg-gray-100">+</button>
                                    </div>
                                </form>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800">{{ number_format($item->total, 2) }} TL</p>
                                <form action="{{ route('cart.remove', $item) }}" method="POST" class="mt-2">@csrf @method('DELETE')<button type="submit" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button></form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">@csrf @method('DELETE')<button type="submit" class="text-red-500 hover:underline text-sm">Sepeti Temizle</button></form>
            </div>
            <div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Siparis Ozeti</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-600">Ara Toplam</span><span>{{ number_format($cart->subtotal, 2) }} TL</span></div>
                        @if(session('discount_code'))<div class="flex justify-between text-green-600"><span>Indirim</span><span>-</span></div>@endif
                    </div>
                    <form action="{{ route('cart.apply-discount') }}" method="POST" class="mt-4 flex gap-2">@csrf<input type="text" name="code" placeholder="Indirim Kodu" class="flex-1 border rounded px-3 py-2 text-sm"><button type="submit" class="bg-gray-200 px-4 py-2 rounded text-sm hover:bg-gray-300">Uygula</button></form>
                    <div class="border-t mt-4 pt-4"><div class="flex justify-between font-bold text-lg"><span>Toplam</span><span>{{ number_format($cart->subtotal, 2) }} TL</span></div></div>
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-purple-600 text-white text-center py-3 rounded-lg mt-4 hover:bg-purple-700"><i class="fab fa-whatsapp mr-2"></i>Siparisi Tamamla</a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg"><i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i><p class="text-gray-600 mb-4">Sepetiniz bos</p><a href="{{ route('products.index') }}" class="inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Alisverise Basla</a></div>
    @endif
</div>
@endsection
