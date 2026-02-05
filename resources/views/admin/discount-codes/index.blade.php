@extends('layouts.admin')

@section('title', 'Indirim Kodlari')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Indirim Kodlari</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Indirim Kodlari</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $discountCodes->total() }} indirim kodu</p>
        </div>
        <x-admin.button href="{{ route('admin.discount-codes.create') }}" icon="fa-plus">
            Yeni Kod
        </x-admin.button>
    </div>

    <!-- Discount Codes Table -->
    <x-admin.data-table :headers="[
        ['label' => 'Kod', 'width' => '15%'],
        'Indirim',
        ['label' => 'Min. Tutar', 'class' => 'text-right'],
        ['label' => 'Kullanim', 'class' => 'text-center'],
        'Gecerlilik',
        ['label' => 'Durum', 'class' => 'text-center'],
        ['label' => 'Islemler', 'class' => 'text-right', 'width' => '120px'],
    ]">
        @forelse($discountCodes as $code)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <span class="font-mono text-sm font-semibold text-slate-900 bg-slate-100 px-2 py-1 rounded">
                        {{ $code->code }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm font-medium text-slate-900">{{ $code->formatted_value }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <span class="text-sm text-slate-600">
                        {{ $code->min_order_amount > 0 ? number_format($code->min_order_amount, 2) . ' TL' : '-' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <x-admin.badge variant="default" size="sm">
                        {{ $code->used_count }} / {{ $code->usage_limit ?? '∞' }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3">
                    @if($code->starts_at || $code->expires_at)
                        <div class="text-sm text-slate-600">
                            <span>{{ $code->starts_at?->format('d.m.Y') ?? '-' }}</span>
                            <span class="text-slate-400 mx-1">-</span>
                            <span>{{ $code->expires_at?->format('d.m.Y') ?? '-' }}</span>
                        </div>
                    @else
                        <span class="text-sm text-slate-400">Sinirsiz</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.discount-codes.toggle-status', $code) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <x-admin.badge :variant="$code->is_active ? 'success' : 'danger'" size="sm" dot>
                                {{ $code->is_active ? 'Aktif' : 'Pasif' }}
                            </x-admin.badge>
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.discount-codes.show', $code) }}"
                           class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                           title="Detay">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                        <a href="{{ route('admin.discount-codes.edit', $code) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="Duzenle">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        <form action="{{ route('admin.discount-codes.destroy', $code) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Bu indirim kodunu silmek istediginizden emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="Sil">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-tags"
                        title="Indirim kodu bulunamadi"
                        description="Henuz indirim kodu eklenmemis"
                        action="Yeni Kod Ekle"
                        :actionUrl="route('admin.discount-codes.create')"
                    />
                </td>
            </tr>
        @endforelse

        <x-slot:footer>
            {{ $discountCodes->links() }}
        </x-slot:footer>
    </x-admin.data-table>
@endsection
