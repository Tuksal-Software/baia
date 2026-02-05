@extends('layouts.admin')

@section('title', 'Yeni Banner')

@section('breadcrumb')
    <a href="{{ route('admin.banners.index') }}" class="text-slate-500 hover:text-slate-700">Bannerlar</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Banner</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Banner</h1>
        <p class="text-sm text-slate-500 mt-1">Yeni bir banner olusturun</p>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            label="Banner Adi"
                            placeholder="Banner adi"
                            required
                        />

                        <x-admin.form-select
                            name="position"
                            label="Pozisyon"
                            :options="$positions"
                            required
                        />

                        <x-admin.form-input
                            name="title"
                            label="Baslik"
                            placeholder="Banner basligi (opsiyonel)"
                        />

                        <x-admin.form-input
                            name="subtitle"
                            label="Alt Baslik"
                            placeholder="Banner alt basligi (opsiyonel)"
                        />

                        <x-admin.form-input
                            name="link"
                            label="Link"
                            placeholder="/kategori/..."
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Gorseller">
                    <div class="space-y-4">
                        <x-admin.form-image
                            name="image"
                            label="Gorsel (Desktop)"
                            required
                        />

                        <x-admin.form-image
                            name="image_mobile"
                            label="Gorsel (Mobil)"
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
                            description="Banner sitede gorunur"
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
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                Kaydet
            </x-admin.button>
            <x-admin.button href="{{ route('admin.banners.index') }}" variant="ghost">
                Iptal
            </x-admin.button>
        </div>
    </form>
@endsection
