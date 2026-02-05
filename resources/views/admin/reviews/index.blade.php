@extends('layouts.admin')
@section('title', 'Yorumlar')
@section('content')
<div class="flex justify-between items-center mb-6"><h2 class="text-xl font-semibold">Yorumlar</h2></div>

<div class="flex gap-2 mb-6">
    <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-purple-600 text-white' : 'bg-white text-gray-700' }}">Tumu</a>
    <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700' }}">Bekleyen ({{ $pendingCount }})</a>
    <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'approved' ? 'bg-green-500 text-white' : 'bg-white text-gray-700' }}">Onaylanan ({{ $approvedCount }})</a>
</div>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50"><tr><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Urun</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Musteri</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Puan</th><th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Yorum</th><th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th><th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th></tr></thead>
        <tbody class="divide-y">
            @forelse($reviews as $review)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><a href="{{ route('products.show', $review->product) }}" target="_blank" class="text-blue-600 hover:underline">{{ Str::limit($review->product->name, 30) }}</a></td>
                    <td class="px-4 py-3"><p class="font-medium">{{ $review->customer_name }}</p><p class="text-xs text-gray-500">{{ $review->customer_email }}</p></td>
                    <td class="px-4 py-3 text-center"><div class="flex justify-center text-yellow-400">@for($i = 1; $i <= 5; $i++)<i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-sm"></i>@endfor</div></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($review->comment, 50) }}</td>
                    <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded text-xs {{ $review->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $review->is_approved ? 'Onaylandi' : 'Bekliyor' }}</span></td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        @unless($review->is_approved)<form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">@csrf<button type="submit" class="text-green-600 hover:text-green-800 mr-2"><i class="fas fa-check"></i></button></form>@endunless
                        @if($review->is_approved)<form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline">@csrf<button type="submit" class="text-yellow-600 hover:text-yellow-800 mr-2"><i class="fas fa-times"></i></button></form>@endif
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Yorum bulunamadi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $reviews->links() }}</div>
@endsection
