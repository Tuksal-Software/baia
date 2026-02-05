@extends('layouts.admin')

@section('title', 'Kategori Duzenle')

@section('breadcrumb')
    <a href="{{ route('admin.categories.index') }}" class="text-slate-500 hover:text-slate-700">Kategoriler</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $category->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Kategori Duzenle</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $category->name }}</p>
        </div>
        <form action="{{ route('admin.categories.destroy', $category) }}"
              method="POST"
              onsubmit="return confirm('Bu kategoriyi silmek istediginizden emin misiniz?')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                Sil
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="max-w-2xl">
            <x-admin.card title="Kategori Bilgileri">
                <div class="space-y-4">
                    <x-admin.form-translatable-input
                        name="name"
                        label="Kategori Adi"
                        :value="$category->getTranslations('name')"
                        required
                    />

                    <x-admin.form-input
                        name="slug"
                        label="Slug"
                        :value="$category->slug"
                    />

                    <x-admin.form-select
                        name="parent_id"
                        label="Ust Kategori"
                        :value="$category->parent_id"
                        :options="$parentCategories->pluck('name', 'id')->toArray()"
                        placeholder="- Ana Kategori -"
                    />

                    <x-admin.form-translatable-textarea
                        name="description"
                        label="Aciklama"
                        :value="$category->getTranslations('description')"
                        :rows="3"
                    />

                    <x-admin.form-image
                        name="image"
                        label="Kategori Gorseli"
                        :value="$category->image"
                    />

                    <x-admin.form-input
                        name="order"
                        type="number"
                        label="Siralama"
                        :value="$category->order"
                        min="0"
                    />

                    <x-admin.form-toggle
                        name="is_active"
                        label="Aktif"
                        description="Kategori sitede gorunur"
                        :checked="$category->is_active"
                    />
                </div>
            </x-admin.card>

            <x-admin.card title="Bilgi" class="mt-6">
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Urun Sayisi</span>
                        <span class="text-slate-900 font-medium">{{ $category->products_count ?? $category->products()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Olusturulma</span>
                        <span class="text-slate-900">{{ $category->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Son Guncelleme</span>
                        <span class="text-slate-900">{{ $category->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    Degisiklikleri Kaydet
                </x-admin.button>
                <x-admin.button href="{{ route('admin.categories.index') }}" variant="ghost">
                    Iptal
                </x-admin.button>
            </div>
        </div>
    </form>
@endsection
