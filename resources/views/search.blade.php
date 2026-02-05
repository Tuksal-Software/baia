@extends('layouts.app')
@section('title', 'Arama: ' . $query)
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Arama Sonuclari</h1>
    <p class="text-gray-600 mb-6">"{{ $query }}" icin {{ $products->total() }} sonuc bulundu</p>
    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">@foreach($products as $product)<x-product-card :product="$product" />@endforeach</div>
        <div class="mt-8">{{ $products->links() }}</div>
    @else
        <div class="text-center py-12 bg-white rounded-lg"><i class="fas fa-search text-4xl text-gray-400 mb-4"></i><p class="text-gray-600">Aradiginiz kriterlere uygun urun bulunamadi.</p></div>
    @endif
</div>
@endsection
