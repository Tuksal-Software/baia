@extends('layouts.admin')
@section('title', 'Sliderlar')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Sliderlar ({{ $sliders->count() }})</h2>
    <a href="{{ route('admin.sliders.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
        <i class="fas fa-plus mr-2"></i>Yeni Slider
    </a>
</div>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Gorsel</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Baslik</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Pozisyon</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Sira</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($sliders as $slider)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <img src="{{ $slider->image_url }}" class="w-32 h-20 object-cover rounded">
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-medium">{{ $slider->title ?: '(Baslıksız)' }}</p>
                        @if($slider->subtitle)
                            <p class="text-sm text-gray-500">{{ $slider->subtitle }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600">{{ ucfirst($slider->text_position) }}</td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $slider->order }}</td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.sliders.toggle-status', $slider) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-2 py-1 rounded text-xs {{ $slider->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $slider->is_active ? 'Aktif' : 'Pasif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Henuz slider eklenmemis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
