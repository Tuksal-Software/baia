@extends('layouts.admin')

@section('title', 'Yeni Bolum')

@section('breadcrumb')
    <a href="{{ route('admin.home-sections.index') }}" class="text-slate-500 hover:text-slate-700">Ana Sayfa Bolumleri</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Bolum</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Ana Sayfa Bolumu</h1>
        <p class="text-sm text-slate-500 mt-1">Yeni bir ana sayfa bolumu olusturun</p>
    </div>

    <form action="{{ route('admin.home-sections.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="type"
                            label="Bolum Tipi"
                            :options="$types"
                            required
                            id="section-type"
                        />

                        <x-admin.form-input
                            name="title"
                            label="Baslik"
                            placeholder="Bolum basligi"
                        />

                        <x-admin.form-input
                            name="subtitle"
                            label="Alt Baslik"
                            placeholder="Bolum alt basligi"
                        />
                    </div>
                </x-admin.card>

                <!-- Dynamic Settings -->
                <div id="settings-products" class="settings-group hidden">
                    <x-admin.card title="Urun Ayarlari">
                        <div class="space-y-4">
                            <x-admin.form-select
                                name="settings[type]"
                                label="Urun Tipi"
                                :options="[
                                    'new' => 'Yeni Urunler',
                                    'bestseller' => 'Cok Satanlar',
                                    'sale' => 'Indirimli Urunler',
                                    'featured' => 'One Cikan Urunler',
                                    'category' => 'Kategoriye Gore',
                                ]"
                            />

                            <x-admin.form-input
                                name="settings[limit]"
                                type="number"
                                label="Limit"
                                :value="old('settings.limit', 12)"
                                min="1"
                                max="24"
                            />

                            <x-admin.form-select
                                name="settings[category_id]"
                                label="Kategori (opsiyonel)"
                                :options="$categories->pluck('name', 'id')->toArray()"
                                placeholder="- Sec -"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-categories" class="settings-group hidden">
                    <x-admin.card title="Kategori Ayarlari">
                        <div class="space-y-4">
                            <x-admin.form-input
                                name="settings[limit]"
                                type="number"
                                label="Limit"
                                :value="old('settings.limit', 6)"
                                min="1"
                                max="12"
                            />

                            <x-admin.form-checkbox
                                name="settings[show_all_link]"
                                label="Tumu linkini goster"
                                :checked="old('settings.show_all_link', true)"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-banner" class="settings-group hidden">
                    <x-admin.card title="Banner Ayarlari">
                        <div class="space-y-4">
                            <x-admin.form-select
                                name="settings[position]"
                                label="Banner Pozisyonu"
                                :options="[
                                    'home_top' => 'Ana Sayfa Ust',
                                    'home_middle' => 'Ana Sayfa Orta',
                                    'home_bottom' => 'Ana Sayfa Alt',
                                ]"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-features" class="settings-group hidden">
                    <x-admin.card title="Ozellik Ayarlari">
                        <div class="space-y-4">
                            <x-admin.form-select
                                name="settings[position]"
                                label="Pozisyon"
                                :options="[
                                    'home' => 'Ana Sayfa',
                                    'footer' => 'Footer',
                                ]"
                            />
                        </div>
                    </x-admin.card>
                </div>

                <div id="settings-newsletter" class="settings-group hidden">
                    <x-admin.card title="Bulten Ayarlari">
                        <div class="space-y-4">
                            <x-admin.form-input
                                name="settings[background_color]"
                                label="Arkaplan Rengi"
                                :value="old('settings.background_color', '#f5f5dc')"
                                placeholder="#f5f5dc"
                            />
                        </div>
                    </x-admin.card>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card title="Yayin Ayarlari">
                    <div class="space-y-4">
                        <x-admin.form-toggle
                            name="is_active"
                            label="Aktif"
                            description="Bolum ana sayfada gorunur"
                            :checked="old('is_active', true)"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="Sira"
                            :value="old('order', 0)"
                            min="0"
                        />
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                Kaydet
            </x-admin.button>
            <x-admin.button href="{{ route('admin.home-sections.index') }}" variant="ghost">
                Iptal
            </x-admin.button>
        </div>
    </form>

    <script>
    document.getElementById('section-type').addEventListener('change', function() {
        document.querySelectorAll('.settings-group').forEach(el => el.classList.add('hidden'));
        const selected = document.getElementById('settings-' + this.value);
        if (selected) selected.classList.remove('hidden');
    });
    document.getElementById('section-type').dispatchEvent(new Event('change'));
    </script>
@endsection
