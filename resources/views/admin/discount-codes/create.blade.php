@extends('layouts.admin')
@section('title', 'Yeni Indirim Kodu')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6"><a href="{{ route('admin.discount-codes.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a><h2 class="text-xl font-semibold">Yeni Indirim Kodu</h2></div>
    <form action="{{ route('admin.discount-codes.store') }}" method="POST" class="bg-white rounded-lg p-6">
        @csrf
        <div class="space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Kod</label><div class="flex gap-2"><input type="text" name="code" value="{{ old('code') }}" placeholder="Bos birakilirsa otomatik olusturulur" class="flex-1 border rounded-lg px-4 py-2 uppercase"><button type="button" onclick="generateCode()" class="bg-gray-200 px-4 rounded-lg hover:bg-gray-300">Olustur</button></div></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Indirim Tipi *</label><select name="type" required class="w-full border rounded-lg px-4 py-2"><option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Yuzde (%)</option><option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Sabit (TL)</option></select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Deger *</label><input type="number" name="value" value="{{ old('value') }}" step="0.01" min="0" required class="w-full border rounded-lg px-4 py-2"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Minimum Siparis Tutari (TL)</label><input type="number" name="min_order_amount" value="{{ old('min_order_amount') }}" step="0.01" min="0" class="w-full border rounded-lg px-4 py-2"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Kullanim Limiti</label><input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1" placeholder="Bos = sinirsiz" class="w-full border rounded-lg px-4 py-2"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Baslangic Tarihi</label><input type="date" name="starts_at" value="{{ old('starts_at') }}" class="w-full border rounded-lg px-4 py-2"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Bitis Tarihi</label><input type="date" name="expires_at" value="{{ old('expires_at') }}" class="w-full border rounded-lg px-4 py-2"></div>
            </div>
            <div><label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded text-purple-600">Aktif</label></div>
        </div>
        <div class="mt-6 flex gap-3"><button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Kaydet</button><a href="{{ route('admin.discount-codes.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a></div>
    </form>
</div>
@push('scripts')
<script>
async function generateCode() {
    const response = await fetch('{{ route("admin.discount-codes.generate") }}');
    const data = await response.json();
    document.querySelector('input[name="code"]').value = data.code;
}
</script>
@endpush
@endsection
