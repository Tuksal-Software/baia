@extends('layouts.admin')
@section('title', 'Yorum Detay')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.reviews.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">Yorum Detay</h2></div>
    <div class="bg-white rounded-lg p-6">
        <div class="flex justify-between items-start mb-4">
            <div><div class="flex text-yellow-400 mb-2">@for($i = 1; $i <= 5; $i++)<i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>@endfor</div><p class="font-semibold">{{ $review->customer_name }}</p><p class="text-sm text-gray-500">{{ $review->customer_email }}</p></div>
            <span class="px-3 py-1 rounded-full text-sm {{ $review->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $review->is_approved ? 'Onaylandi' : 'Bekliyor' }}</span>
        </div>
        <div class="border-t pt-4 mb-4">
            <p class="text-sm text-gray-500 mb-1">Urun:</p>
            <a href="{{ route('products.show', $review->product) }}" target="_blank" class="text-blue-600 hover:underline">{{ $review->product->name }}</a>
        </div>
        @if($review->comment)<div class="border-t pt-4 mb-4"><p class="text-sm text-gray-500 mb-1">Yorum:</p><p class="text-gray-700">{{ $review->comment }}</p></div>@endif
        <div class="border-t pt-4"><p class="text-sm text-gray-500">Tarih: {{ $review->created_at->format('d.m.Y H:i') }}</p></div>
        <div class="border-t pt-4 mt-4 flex gap-3">
            @unless($review->is_approved)<form action="{{ route('admin.reviews.approve', $review) }}" method="POST">@csrf<button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-check mr-2"></i>Onayla</button></form>@endunless
            @if($review->is_approved)<form action="{{ route('admin.reviews.reject', $review) }}" method="POST">@csrf<button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700"><i class="fas fa-times mr-2"></i>Reddet</button></form>@endif
            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Silmek istediginize emin misiniz?')">@csrf @method('DELETE')<button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700"><i class="fas fa-trash mr-2"></i>Sil</button></form>
        </div>
    </div>
</div>
@endsection
