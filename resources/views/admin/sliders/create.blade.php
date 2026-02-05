@extends('layouts.admin')

@section('title', 'Yeni Slider')

@section('breadcrumb')
    <a href="{{ route('admin.sliders.index') }}" class="text-slate-500 hover:text-slate-700">Sliderlar</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Slider</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Slider</h1>
        <p class="text-sm text-slate-500 mt-1">Yeni bir slider olusturun</p>
    </div>

    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="title"
                            label="Baslik"
                            placeholder="Slider basligi"
                        />

                        <x-admin.form-input
                            name="subtitle"
                            label="Alt Baslik"
                            placeholder="Slider alt basligi"
                        />

                        <x-admin.form-textarea
                            name="description"
                            label="Aciklama"
                            :rows="3"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Gorseller">
                    <div class="space-y-4">
                        <x-admin.form-image
                            name="image"
                            label="Gorsel (Desktop)"
                            required
                            hint="Onerilen boyut: 1920x800px"
                        />

                        <x-admin.form-image
                            name="image_mobile"
                            label="Gorsel (Mobil)"
                            hint="Onerilen boyut: 768x600px"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Buton Ayarlari">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-admin.form-input
                                name="button_text"
                                label="Buton Metni"
                                placeholder="Orn: Kesfet"
                            />

                            <x-admin.form-input
                                name="button_link"
                                label="Buton Linki"
                                placeholder="/kategori/..."
                            />
                        </div>

                        <x-admin.form-select
                            name="button_style"
                            label="Buton Stili"
                            :options="[
                                'primary' => 'Primary',
                                'secondary' => 'Secondary',
                                'outline' => 'Outline',
                            ]"
                            :value="old('button_style', 'primary')"
                        />
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card title="Yayin Ayarlari">
                    <div class="space-y-4">
                        <x-admin.form-toggle
                            name="is_active"
                            label="Aktif"
                            description="Slider sitede gorunur"
                            :checked="old('is_active', true)"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="Sira"
                            :value="old('order', 0)"
                            min="0"
                        />

                        <x-admin.form-input
                            name="starts_at"
                            type="datetime-local"
                            label="Baslangic Tarihi"
                        />

                        <x-admin.form-input
                            name="ends_at"
                            type="datetime-local"
                            label="Bitis Tarihi"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Gorunum Ayarlari">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="text_position"
                            label="Metin Pozisyonu"
                            :options="[
                                'left' => 'Sol',
                                'center' => 'Orta',
                                'right' => 'Sag',
                            ]"
                            :value="old('text_position', 'center')"
                        />

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Metin Rengi</label>
                            <input type="color"
                                   name="text_color"
                                   value="{{ old('text_color', '#ffffff') }}"
                                   class="w-full h-10 rounded-lg border border-slate-300 cursor-pointer">
                        </div>

                        <x-admin.form-input
                            name="overlay_color"
                            label="Overlay Rengi"
                            placeholder="rgba(0,0,0,0.3)"
                        />
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                Kaydet
            </x-admin.button>
            <x-admin.button href="{{ route('admin.sliders.index') }}" variant="ghost">
                Iptal
            </x-admin.button>
        </div>
    </form>
@endsection
