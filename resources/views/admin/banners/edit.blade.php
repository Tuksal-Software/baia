@extends('layouts.admin')

@section('title', 'Banner Duzenle')

@section('breadcrumb')
    <a href="{{ route('admin.banners.index') }}" class="text-slate-500 hover:text-slate-700">Bannerlar</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $banner->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Banner Duzenle</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $banner->name }}</p>
        </div>
        <form action="{{ route('admin.banners.destroy', $banner) }}"
              method="POST"
              onsubmit="return confirm('Bu banneri silmek istediginizden emin misiniz?')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                Sil
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            label="Banner Adi"
                            :value="$banner->name"
                            required
                        />

                        <x-admin.form-select
                            name="position"
                            label="Pozisyon"
                            :options="$positions"
                            :value="$banner->position"
                            required
                        />

                        <x-admin.form-input
                            name="title"
                            label="Baslik"
                            :value="$banner->title"
                            placeholder="Banner basligi (opsiyonel)"
                        />

                        <x-admin.form-input
                            name="subtitle"
                            label="Alt Baslik"
                            :value="$banner->subtitle"
                            placeholder="Banner alt basligi (opsiyonel)"
                        />

                        <x-admin.form-input
                            name="link"
                            label="Link"
                            :value="$banner->link"
                            placeholder="/kategori/..."
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Gorseller">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gorsel (Desktop)</label>
                            <div class="flex items-start gap-4">
                                <img src="{{ $banner->image_url }}"
                                     class="w-40 h-24 object-cover rounded-lg border border-slate-200"
                                     alt="Current image">
                                <div class="flex-1">
                                    <x-admin.form-image name="image" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gorsel (Mobil)</label>
                            <div class="flex items-start gap-4">
                                @if($banner->image_mobile)
                                    <div class="relative">
                                        <img src="{{ $banner->mobile_image_url }}"
                                             class="w-24 h-32 object-cover rounded-lg border border-slate-200"
                                             alt="Mobile image">
                                        <label class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-rose-600 transition-colors">
                                            <input type="checkbox" name="remove_image_mobile" value="1" class="hidden">
                                            <i class="fas fa-times text-xs"></i>
                                        </label>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <x-admin.form-image name="image_mobile" />
                                </div>
                            </div>
                        </div>
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
                            description="Banner sitede gorunur"
                            :checked="$banner->is_active"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="Sira"
                            :value="$banner->order"
                            min="0"
                        />

                        <x-admin.form-input
                            name="starts_at"
                            type="datetime-local"
                            label="Baslangic Tarihi"
                            :value="$banner->starts_at?->format('Y-m-d\TH:i')"
                        />

                        <x-admin.form-input
                            name="ends_at"
                            type="datetime-local"
                            label="Bitis Tarihi"
                            :value="$banner->ends_at?->format('Y-m-d\TH:i')"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Bilgi">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Olusturulma</span>
                            <span class="text-slate-900">{{ $banner->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Son Guncelleme</span>
                            <span class="text-slate-900">{{ $banner->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                Degisiklikleri Kaydet
            </x-admin.button>
            <x-admin.button href="{{ route('admin.banners.index') }}" variant="ghost">
                Iptal
            </x-admin.button>
        </div>
    </form>
@endsection
