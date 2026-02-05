@extends('layouts.app')
@section('title', 'Indirimli Urunler')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-fire text-red-500 mr-2"></i>Indirimli Urunler</h1>
    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">@foreach($products as $product)<x-product-card :product="$product" />@endforeach</div>
        <div class="mt-8">{{ $products->links() }}</div>
    @else
        <div class="text-center py-12"><i class="fas fa-tags text-4xl text-gray-400 mb-4"></i><p class="text-gray-600">Indirimli urun bulunmuyor.</p></div>
    @endif
</div>
@endsection
