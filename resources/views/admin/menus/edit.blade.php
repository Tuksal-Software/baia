@extends('layouts.admin')

@section('title', 'Menu Duzenle')

@section('breadcrumb')
    <a href="{{ route('admin.menus.index') }}" class="text-slate-500 hover:text-slate-700">Menuler</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $menu->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">{{ $menu->name }} Duzenle</h1>
        <p class="text-sm text-slate-500 mt-1">Konum: {{ $menu->location }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Menu Items List -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.menus.update-items', $menu) }}" method="POST" id="menu-form">
                @csrf
                @method('PUT')

                <x-admin.card title="Menu Ogeleri">
                    <x-slot:actions>
                        <button type="button" onclick="addMenuItem()" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700">
                            <i class="fas fa-plus text-xs"></i>
                            Yeni Oge
                        </button>
                    </x-slot:actions>

                    <div id="menu-items-container" class="space-y-4">
                        @foreach($menu->items as $index => $item)
                            <div class="menu-item border border-slate-200 rounded-lg p-4 bg-white" data-id="{{ $item->id }}">
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <x-admin.form-input
                                        name="items[{{ $index }}][title]"
                                        label="Baslik"
                                        :value="$item->title"
                                        required
                                    />
                                    <x-admin.form-input
                                        name="items[{{ $index }}][link]"
                                        label="Link"
                                        :value="$item->link"
                                    />
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <x-admin.form-select
                                        name="items[{{ $index }}][target]"
                                        label="Hedef"
                                        :options="['_self' => 'Ayni Pencere', '_blank' => 'Yeni Pencere']"
                                        :value="$item->target"
                                    />
                                    <x-admin.form-input
                                        name="items[{{ $index }}][order]"
                                        type="number"
                                        label="Sira"
                                        :value="$item->order"
                                        min="0"
                                    />
                                    <x-admin.form-checkbox
                                        name="items[{{ $index }}][is_active]"
                                        label="Aktif"
                                        :checked="$item->is_active"
                                        class="pt-6"
                                    />
                                </div>
                                <button type="button" onclick="removeMenuItem(this)" class="mt-4 inline-flex items-center gap-1.5 text-sm text-rose-600 hover:text-rose-700">
                                    <i class="fas fa-trash text-xs"></i>
                                    Sil
                                </button>

                                <!-- Child Items -->
                                @if($item->children->count() > 0)
                                    <div class="mt-4 pl-4 border-l-2 border-slate-200 space-y-3">
                                        @foreach($item->children as $childIndex => $child)
                                            <div class="menu-item bg-slate-50 rounded-lg p-4" data-id="{{ $child->id }}">
                                                <input type="hidden" name="items[{{ $index }}][children][{{ $childIndex }}][id]" value="{{ $child->id }}">
                                                <div class="grid grid-cols-2 gap-3">
                                                    <input type="text"
                                                           name="items[{{ $index }}][children][{{ $childIndex }}][title]"
                                                           value="{{ $child->title }}"
                                                           required
                                                           placeholder="Baslik"
                                                           class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                                                    <input type="text"
                                                           name="items[{{ $index }}][children][{{ $childIndex }}][link]"
                                                           value="{{ $child->link }}"
                                                           placeholder="Link"
                                                           class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                                                </div>
                                                <div class="flex items-center gap-4 mt-3">
                                                    <select name="items[{{ $index }}][children][{{ $childIndex }}][target]"
                                                            class="rounded-lg border border-slate-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                                                        <option value="_self" {{ $child->target === '_self' ? 'selected' : '' }}>Ayni</option>
                                                        <option value="_blank" {{ $child->target === '_blank' ? 'selected' : '' }}>Yeni</option>
                                                    </select>
                                                    <input type="number"
                                                           name="items[{{ $index }}][children][{{ $childIndex }}][order]"
                                                           value="{{ $child->order }}"
                                                           min="0"
                                                           class="w-20 rounded-lg border border-slate-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                                                    <label class="flex items-center gap-2">
                                                        <input type="checkbox"
                                                               name="items[{{ $index }}][children][{{ $childIndex }}][is_active]"
                                                               value="1"
                                                               {{ $child->is_active ? 'checked' : '' }}
                                                               class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                                        <span class="text-sm text-slate-700">Aktif</span>
                                                    </label>
                                                    <button type="button" onclick="removeMenuItem(this)" class="text-rose-600 hover:text-rose-700">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200">
                        <x-admin.button type="submit" icon="fa-save">
                            Kaydet
                        </x-admin.button>
                    </div>
                </x-admin.card>
            </form>
        </div>

        <!-- Quick Add Sidebar -->
        <div>
            <x-admin.card title="Hizli Ekle" class="sticky top-6">
                <div class="space-y-4">
                    <x-admin.form-input
                        name="quick_title"
                        label="Baslik"
                        id="quick-title"
                    />

                    <x-admin.form-input
                        name="quick_link"
                        label="Link"
                        id="quick-link"
                    />

                    <x-admin.button type="button" onclick="quickAddMenuItem()" variant="secondary" icon="fa-plus" class="w-full">
                        Ekle
                    </x-admin.button>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-200">
                    <h4 class="text-sm font-medium text-slate-700 mb-3">Hazir Linkler</h4>
                    <div class="space-y-2">
                        <button type="button" onclick="setQuickLink('Ana Sayfa', '/')" class="block text-sm text-primary-600 hover:text-primary-700 hover:underline">Ana Sayfa</button>
                        <button type="button" onclick="setQuickLink('Tum Urunler', '/urunler')" class="block text-sm text-primary-600 hover:text-primary-700 hover:underline">Tum Urunler</button>
                        <button type="button" onclick="setQuickLink('Kategoriler', '/kategoriler')" class="block text-sm text-primary-600 hover:text-primary-700 hover:underline">Kategoriler</button>
                        <button type="button" onclick="setQuickLink('Hakkimizda', '/hakkimizda')" class="block text-sm text-primary-600 hover:text-primary-700 hover:underline">Hakkimizda</button>
                        <button type="button" onclick="setQuickLink('Iletisim', '/iletisim')" class="block text-sm text-primary-600 hover:text-primary-700 hover:underline">Iletisim</button>
                    </div>
                </div>
            </x-admin.card>
        </div>
    </div>

    <script>
    let itemIndex = {{ $menu->items->count() }};

    function addMenuItem() {
        const container = document.getElementById('menu-items-container');
        const html = `
            <div class="menu-item border border-slate-200 rounded-lg p-4 bg-white" data-id="">
                <input type="hidden" name="items[${itemIndex}][id]" value="">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Baslik</label>
                        <input type="text" name="items[${itemIndex}][title]" required class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Link</label>
                        <input type="text" name="items[${itemIndex}][link]" class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Hedef</label>
                        <select name="items[${itemIndex}][target]" class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                            <option value="_self">Ayni Pencere</option>
                            <option value="_blank">Yeni Pencere</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Sira</label>
                        <input type="number" name="items[${itemIndex}][order]" value="${itemIndex}" min="0" class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                    </div>
                    <div class="pt-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="items[${itemIndex}][is_active]" value="1" checked class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm font-medium text-slate-700">Aktif</span>
                        </label>
                    </div>
                </div>
                <button type="button" onclick="removeMenuItem(this)" class="mt-4 inline-flex items-center gap-1.5 text-sm text-rose-600 hover:text-rose-700">
                    <i class="fas fa-trash text-xs"></i>
                    Sil
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
            <div class="menu-item border border-slate-200 rounded-lg p-4 bg-white" data-id="">
                <input type="hidden" name="items[${itemIndex}][id]" value="">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Baslik</label>
                        <input type="text" name="items[${itemIndex}][title]" value="${title}" required class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Link</label>
                        <input type="text" name="items[${itemIndex}][link]" value="${link}" class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Hedef</label>
                        <select name="items[${itemIndex}][target]" class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                            <option value="_self">Ayni Pencere</option>
                            <option value="_blank">Yeni Pencere</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Sira</label>
                        <input type="number" name="items[${itemIndex}][order]" value="${itemIndex}" min="0" class="block w-full rounded-lg border border-slate-300 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-500">
                    </div>
                    <div class="pt-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="items[${itemIndex}][is_active]" value="1" checked class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm font-medium text-slate-700">Aktif</span>
                        </label>
                    </div>
                </div>
                <button type="button" onclick="removeMenuItem(this)" class="mt-4 inline-flex items-center gap-1.5 text-sm text-rose-600 hover:text-rose-700">
                    <i class="fas fa-trash text-xs"></i>
                    Sil
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
