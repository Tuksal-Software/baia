@extends('layouts.admin')
@section('title', 'Menu Duzenle')
@section('content')
<div class="max-w-4xl">
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.menus.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
        <h2 class="text-xl font-semibold">{{ $menu->name }} Duzenle</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Menu Items List -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.menus.update-items', $menu) }}" method="POST" id="menu-form">
                @csrf @method('PUT')

                <div class="bg-white rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">Menu Ogeleri</h3>
                        <button type="button" onclick="addMenuItem()" class="text-sm text-purple-600 hover:text-purple-800">
                            <i class="fas fa-plus mr-1"></i>Yeni Oge
                        </button>
                    </div>

                    <div id="menu-items-container" class="space-y-3">
                        @foreach($menu->items as $index => $item)
                            <div class="menu-item border rounded-lg p-4" data-id="{{ $item->id }}">
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Baslik</label>
                                        <input type="text" name="items[{{ $index }}][title]" value="{{ $item->title }}" required class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Link</label>
                                        <input type="text" name="items[{{ $index }}][link]" value="{{ $item->link }}" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Hedef</label>
                                        <select name="items[{{ $index }}][target]" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                                            <option value="_self" {{ $item->target === '_self' ? 'selected' : '' }}>Ayni Pencere</option>
                                            <option value="_blank" {{ $item->target === '_blank' ? 'selected' : '' }}>Yeni Pencere</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Sira</label>
                                        <input type="number" name="items[{{ $index }}][order]" value="{{ $item->order }}" min="0" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Durum</label>
                                        <label class="flex items-center gap-2 mt-2">
                                            <input type="checkbox" name="items[{{ $index }}][is_active]" value="1" {{ $item->is_active ? 'checked' : '' }} class="rounded text-purple-600">
                                            <span class="text-sm">Aktif</span>
                                        </label>
                                    </div>
                                </div>
                                <button type="button" onclick="removeMenuItem(this)" class="mt-3 text-xs text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash mr-1"></i>Sil
                                </button>

                                <!-- Child Items -->
                                @if($item->children->count() > 0)
                                    <div class="mt-4 pl-4 border-l-2 border-gray-200 space-y-3">
                                        @foreach($item->children as $childIndex => $child)
                                            <div class="menu-item bg-gray-50 rounded p-3" data-id="{{ $child->id }}">
                                                <input type="hidden" name="items[{{ $index }}][children][{{ $childIndex }}][id]" value="{{ $child->id }}">
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <input type="text" name="items[{{ $index }}][children][{{ $childIndex }}][title]" value="{{ $child->title }}" required placeholder="Baslik" class="w-full border rounded px-3 py-2 text-sm">
                                                    </div>
                                                    <div>
                                                        <input type="text" name="items[{{ $index }}][children][{{ $childIndex }}][link]" value="{{ $child->link }}" placeholder="Link" class="w-full border rounded px-3 py-2 text-sm">
                                                    </div>
                                                </div>
                                                <div class="flex gap-3 mt-2">
                                                    <select name="items[{{ $index }}][children][{{ $childIndex }}][target]" class="border rounded px-2 py-1 text-sm">
                                                        <option value="_self" {{ $child->target === '_self' ? 'selected' : '' }}>Ayni</option>
                                                        <option value="_blank" {{ $child->target === '_blank' ? 'selected' : '' }}>Yeni</option>
                                                    </select>
                                                    <input type="number" name="items[{{ $index }}][children][{{ $childIndex }}][order]" value="{{ $child->order }}" min="0" class="w-16 border rounded px-2 py-1 text-sm">
                                                    <label class="flex items-center gap-1">
                                                        <input type="checkbox" name="items[{{ $index }}][children][{{ $childIndex }}][is_active]" value="1" {{ $child->is_active ? 'checked' : '' }} class="rounded text-purple-600">
                                                        <span class="text-xs">Aktif</span>
                                                    </label>
                                                    <button type="button" onclick="removeMenuItem(this)" class="text-xs text-red-600"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                            <i class="fas fa-save mr-2"></i>Kaydet
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quick Add -->
        <div>
            <div class="bg-white rounded-lg p-6 sticky top-6">
                <h3 class="font-semibold mb-4">Hizli Ekle</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Baslik</label>
                        <input type="text" id="quick-title" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link</label>
                        <input type="text" id="quick-link" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                    </div>
                    <button type="button" onclick="quickAddMenuItem()" class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                        <i class="fas fa-plus mr-2"></i>Ekle
                    </button>
                </div>

                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-medium text-sm mb-2">Hazir Linkler</h4>
                    <div class="space-y-2 text-sm">
                        <button type="button" onclick="setQuickLink('Ana Sayfa', '/')" class="block text-purple-600 hover:underline">Ana Sayfa</button>
                        <button type="button" onclick="setQuickLink('Tum Urunler', '/urunler')" class="block text-purple-600 hover:underline">Tum Urunler</button>
                        <button type="button" onclick="setQuickLink('Kategoriler', '/kategoriler')" class="block text-purple-600 hover:underline">Kategoriler</button>
                        <button type="button" onclick="setQuickLink('Hakkimizda', '/hakkimizda')" class="block text-purple-600 hover:underline">Hakkimizda</button>
                        <button type="button" onclick="setQuickLink('Iletisim', '/iletisim')" class="block text-purple-600 hover:underline">Iletisim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let itemIndex = {{ $menu->items->count() }};

function addMenuItem() {
    const container = document.getElementById('menu-items-container');
    const html = `
        <div class="menu-item border rounded-lg p-4" data-id="">
            <input type="hidden" name="items[${itemIndex}][id]" value="">
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Baslik</label>
                    <input type="text" name="items[${itemIndex}][title]" required class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Link</label>
                    <input type="text" name="items[${itemIndex}][link]" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Hedef</label>
                    <select name="items[${itemIndex}][target]" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                        <option value="_self">Ayni Pencere</option>
                        <option value="_blank">Yeni Pencere</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Sira</label>
                    <input type="number" name="items[${itemIndex}][order]" value="${itemIndex}" min="0" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Durum</label>
                    <label class="flex items-center gap-2 mt-2">
                        <input type="checkbox" name="items[${itemIndex}][is_active]" value="1" checked class="rounded text-purple-600">
                        <span class="text-sm">Aktif</span>
                    </label>
                </div>
            </div>
            <button type="button" onclick="removeMenuItem(this)" class="mt-3 text-xs text-red-600 hover:text-red-800">
                <i class="fas fa-trash mr-1"></i>Sil
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    itemIndex++;
}

function removeMenuItem(btn) {
    btn.closest('.menu-item').remove();
}

function setQuickLink(title, link) {
    document.getElementById('quick-title').value = title;
    document.getElementById('quick-link').value = link;
}

function quickAddMenuItem() {
    const title = document.getElementById('quick-title').value;
    const link = document.getElementById('quick-link').value;
    if (!title) return alert('Baslik gerekli');

    const container = document.getElementById('menu-items-container');
    const html = `
        <div class="menu-item border rounded-lg p-4" data-id="">
            <input type="hidden" name="items[${itemIndex}][id]" value="">
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Baslik</label>
                    <input type="text" name="items[${itemIndex}][title]" value="${title}" required class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Link</label>
                    <input type="text" name="items[${itemIndex}][link]" value="${link}" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Hedef</label>
                    <select name="items[${itemIndex}][target]" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                        <option value="_self">Ayni Pencere</option>
                        <option value="_blank">Yeni Pencere</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Sira</label>
                    <input type="number" name="items[${itemIndex}][order]" value="${itemIndex}" min="0" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Durum</label>
                    <label class="flex items-center gap-2 mt-2">
                        <input type="checkbox" name="items[${itemIndex}][is_active]" value="1" checked class="rounded text-purple-600">
                        <span class="text-sm">Aktif</span>
                    </label>
                </div>
            </div>
            <button type="button" onclick="removeMenuItem(this)" class="mt-3 text-xs text-red-600 hover:text-red-800">
                <i class="fas fa-trash mr-1"></i>Sil
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    itemIndex++;

    document.getElementById('quick-title').value = '';
    document.getElementById('quick-link').value = '';
}
</script>
@endsection
