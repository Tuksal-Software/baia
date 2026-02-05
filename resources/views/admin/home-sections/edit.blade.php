@extends('layouts.admin')
@section('title', 'Bolum Duzenle')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.home-sections.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-semibold">Bolum Duzenle</h2>
    </div>

    <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" class="bg-white rounded-lg p-6">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bolum Tipi *</label>
                <select name="type" id="section-type" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                    @foreach($types as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $homeSection->type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Baslik</label>
                <input type="text" name="title" value="{{ old('title', $homeSection->title) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alt Baslik</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $homeSection->subtitle) }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <!-- Dynamic settings based on type -->
            <div id="settings-products" class="settings-group hidden space-y-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-700">Urun Ayarlari</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urun Tipi</label>
                    <select name="settings[type]" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="new" {{ ($homeSection->settings['type'] ?? '') === 'new' ? 'selected' : '' }}>Yeni Urunler</option>
                        <option value="bestseller" {{ ($homeSection->settings['type'] ?? '') === 'bestseller' ? 'selected' : '' }}>Cok Satanlar</option>
                        <option value="sale" {{ ($homeSection->settings['type'] ?? '') === 'sale' ? 'selected' : '' }}>Indirimli Urunler</option>
                        <option value="featured" {{ ($homeSection->settings['type'] ?? '') === 'featured' ? 'selected' : '' }}>One Cikan Urunler</option>
                        <option value="category" {{ ($homeSection->settings['type'] ?? '') === 'category' ? 'selected' : '' }}>Kategoriye Gore</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Limit</label>
                    <input type="number" name="settings[limit]" value="{{ $homeSection->settings['limit'] ?? 12 }}" min="1" max="24" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori (opsiyonel)</label>
                    <select name="settings[category_id]" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="">- Sec -</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ($homeSection->settings['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="settings-categories" class="settings-group hidden space-y-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-700">Kategori Ayarlari</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Limit</label>
                    <input type="number" name="settings[limit]" value="{{ $homeSection->settings['limit'] ?? 6 }}" min="1" max="12" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="settings[show_all_link]" value="1" {{ ($homeSection->settings['show_all_link'] ?? false) ? 'checked' : '' }} class="rounded text-purple-600">
                        "Tumu" linkini goster
                    </label>
                </div>
            </div>

            <div id="settings-banner" class="settings-group hidden space-y-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-700">Banner Ayarlari</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Banner Pozisyonu</label>
                    <select name="settings[position]" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="home_top" {{ ($homeSection->settings['position'] ?? '') === 'home_top' ? 'selected' : '' }}>Ana Sayfa Ust</option>
                        <option value="home_middle" {{ ($homeSection->settings['position'] ?? '') === 'home_middle' ? 'selected' : '' }}>Ana Sayfa Orta</option>
                        <option value="home_bottom" {{ ($homeSection->settings['position'] ?? '') === 'home_bottom' ? 'selected' : '' }}>Ana Sayfa Alt</option>
                    </select>
                </div>
            </div>

            <div id="settings-features" class="settings-group hidden space-y-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-700">Ozellik Ayarlari</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pozisyon</label>
                    <select name="settings[position]" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                        <option value="home" {{ ($homeSection->settings['position'] ?? '') === 'home' ? 'selected' : '' }}>Ana Sayfa</option>
                        <option value="footer" {{ ($homeSection->settings['position'] ?? '') === 'footer' ? 'selected' : '' }}>Footer</option>
                    </select>
                </div>
            </div>

            <div id="settings-newsletter" class="settings-group hidden space-y-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-700">Bulten Ayarlari</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Arkaplan Rengi</label>
                    <input type="text" name="settings[background_color]" value="{{ $homeSection->settings['background_color'] ?? '#f5f5dc' }}" placeholder="#f5f5dc" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sira</label>
                <input type="number" name="order" value="{{ old('order', $homeSection->order) }}" min="0" class="w-32 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }} class="rounded text-purple-600">
                    Aktif
                </label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">Guncelle</button>
            <a href="{{ route('admin.home-sections.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Iptal</a>
        </div>
    </form>
</div>

<script>
document.getElementById('section-type').addEventListener('change', function() {
    document.querySelectorAll('.settings-group').forEach(el => el.classList.add('hidden'));
    const selected = document.getElementById('settings-' + this.value);
    if (selected) selected.classList.remove('hidden');
});
document.getElementById('section-type').dispatchEvent(new Event('change'));
</script>
@endsection
