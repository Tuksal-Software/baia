@extends('layouts.admin')
@section('title', 'Bulten Aboneleri')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Bulten Aboneleri</h2>
    <a href="{{ route('admin.newsletter.export', request()->all()) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
        <i class="fas fa-download mr-2"></i>CSV Indir
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg p-4">
        <p class="text-sm text-gray-500">Toplam</p>
        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-lg p-4">
        <p class="text-sm text-gray-500">Aktif</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
    </div>
    <div class="bg-white rounded-lg p-4">
        <p class="text-sm text-gray-500">Iptal</p>
        <p class="text-2xl font-bold text-red-600">{{ $stats['inactive'] }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg p-4 mb-6">
    <form action="{{ route('admin.newsletter.index') }}" method="GET" class="flex gap-4 items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Ara</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="E-posta ara..." class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
            <select name="status" class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                <option value="">Tumu</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Iptal</option>
            </select>
        </div>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Filtrele</button>
        <a href="{{ route('admin.newsletter.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Temizle</a>
    </form>
</div>

<div class="bg-white rounded-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">
                    <input type="checkbox" id="select-all" class="rounded text-purple-600">
                </th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">E-posta</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Durum</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Abone Tarihi</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Iptal Tarihi</th>
                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Islemler</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($subscribers as $subscriber)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <input type="checkbox" name="selected[]" value="{{ $subscriber->id }}" class="subscriber-checkbox rounded text-purple-600">
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $subscriber->email }}</td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.newsletter.toggle-status', $subscriber) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-2 py-1 rounded text-xs {{ $subscriber->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $subscriber->is_active ? 'Aktif' : 'Iptal' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $subscriber->subscribed_at?->format('d.m.Y H:i') ?? '-' }}</td>
                    <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $subscriber->unsubscribed_at?->format('d.m.Y H:i') ?? '-' }}</td>
                    <td class="px-4 py-3 text-right">
                        <form action="{{ route('admin.newsletter.destroy', $subscriber) }}" method="POST" class="inline" onsubmit="return confirm('Silmek istediginize emin misiniz?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Henuz abone yok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($subscribers->hasPages())
    <div class="mt-6">
        {{ $subscribers->links() }}
    </div>
@endif

<!-- Bulk Actions -->
<form action="{{ route('admin.newsletter.bulk-delete') }}" method="POST" id="bulk-form" class="hidden">
    @csrf
    <input type="hidden" name="ids" id="bulk-ids">
</form>

<div id="bulk-actions" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white rounded-lg shadow-lg px-6 py-3 hidden">
    <span id="selected-count" class="mr-4 text-gray-600">0 secili</span>
    <button type="button" onclick="bulkDelete()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        <i class="fas fa-trash mr-2"></i>Sil
    </button>
</div>

<script>
document.getElementById('select-all').addEventListener('change', function() {
    document.querySelectorAll('.subscriber-checkbox').forEach(cb => cb.checked = this.checked);
    updateBulkActions();
});

document.querySelectorAll('.subscriber-checkbox').forEach(cb => {
    cb.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checked = document.querySelectorAll('.subscriber-checkbox:checked');
    const bulkActions = document.getElementById('bulk-actions');
    const count = document.getElementById('selected-count');

    if (checked.length > 0) {
        bulkActions.classList.remove('hidden');
        count.textContent = checked.length + ' secili';
    } else {
        bulkActions.classList.add('hidden');
    }
}

function bulkDelete() {
    if (!confirm('Secili aboneleri silmek istediginize emin misiniz?')) return;

    const ids = Array.from(document.querySelectorAll('.subscriber-checkbox:checked')).map(cb => cb.value);
    document.getElementById('bulk-ids').value = JSON.stringify(ids);
    document.getElementById('bulk-form').submit();
}
</script>
@endsection
