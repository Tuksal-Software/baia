@extends('layouts.admin')

@section('title', 'Slider Duzenle')

@section('breadcrumb')
    <a href="{{ route('admin.sliders.index') }}" class="text-slate-500 hover:text-slate-700">Sliderlar</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $slider->title ?: 'Slider Duzenle' }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Slider Duzenle</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $slider->title ?: '(Basliksiz)' }}</p>
        </div>
        <form action="{{ route('admin.sliders.destroy', $slider) }}"
              method="POST"
              onsubmit="return confirm('Bu slideri silmek istediginizden emin misiniz?')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                Sil
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="title"
                            label="Baslik"
                            :value="$slider->title"
                            placeholder="Slider basligi"
                        />

                        <x-admin.form-input
                            name="subtitle"
                            label="Alt Baslik"
                            :value="$slider->subtitle"
                            placeholder="Slider alt basligi"
                        />

                        <x-admin.form-textarea
                            name="description"
                            label="Aciklama"
                            :value="$slider->description"
                            :rows="3"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Gorseller">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gorsel (Desktop)</label>
                            <div class="flex items-start gap-4">
                                <img src="{{ $slider->image_url }}"
                                     class="w-40 h-24 object-cover rounded-lg border border-slate-200"
                                     alt="Current image">
                                <div class="flex-1">
                                    <x-admin.form-image name="image" hint="Onerilen boyut: 1920x800px" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gorsel (Mobil)</label>
                            <div class="flex items-start gap-4">
                                @if($slider->image_mobile)
                                    <div class="relative">
                                        <img src="{{ $slider->mobile_image_url }}"
                                             class="w-24 h-32 object-cover rounded-lg border border-slate-200"
                                             alt="Mobile image">
                                        <label class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-rose-600 transition-colors">
                                            <input type="checkbox" name="remove_image_mobile" value="1" class="hidden">
                                            <i class="fas fa-times text-xs"></i>
                                        </label>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <x-admin.form-image name="image_mobile" hint="Onerilen boyut: 768x600px" />
                                </div>
                            </div>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card title="Buton Ayarlari">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-admin.form-input
                                name="button_text"
                                label="Buton Metni"
                                :value="$slider->button_text"
                                placeholder="Orn: Kesfet"
                            />

                            <x-admin.form-input
                                name="button_link"
                                label="Buton Linki"
                                :value="$slider->button_link"
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
                            :value="$slider->button_style"
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
                            :checked="$slider->is_active"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="Sira"
                            :value="$slider->order"
                            min="0"
                        />

                        <x-admin.form-input
                            name="starts_at"
                            type="datetime-local"
                            label="Baslangic Tarihi"
                            :value="$slider->starts_at?->format('Y-m-d\TH:i')"
                        />

                        <x-admin.form-input
                            name="ends_at"
                            type="datetime-local"
                            label="Bitis Tarihi"
                            :value="$slider->ends_at?->format('Y-m-d\TH:i')"
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
                            :value="$slider->text_position"
                        />

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Metin Rengi</label>
                            <input type="color"
                                   name="text_color"
                                   value="{{ old('text_color', $slider->text_color) }}"
                                   class="w-full h-10 rounded-lg border border-slate-300 cursor-pointer">
                        </div>

                        <x-admin.form-input
                            name="overlay_color"
                            label="Overlay Rengi"
                            :value="$slider->overlay_color"
                            placeholder="rgba(0,0,0,0.3)"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Bilgi">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Olusturulma</span>
                            <span class="text-slate-900">{{ $slider->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Son Guncelleme</span>
                            <span class="text-slate-900">{{ $slider->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                Degisiklikleri Kaydet
            </x-admin.button>
            <x-admin.button href="{{ route('admin.sliders.index') }}" variant="ghost">
                Iptal
            </x-admin.button>
        </div>
    </form>
@endsection
