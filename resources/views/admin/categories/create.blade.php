@extends('layouts.admin')

@section('title', 'Yeni Kategori')

@section('breadcrumb')
    <a href="{{ route('admin.categories.index') }}" class="text-slate-500 hover:text-slate-700">Kategoriler</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Kategori</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Kategori</h1>
        <p class="text-sm text-slate-500 mt-1">Yeni bir kategori olusturun</p>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="max-w-2xl">
            <x-admin.card title="Kategori Bilgileri">
                <div class="space-y-4">
                    <x-admin.form-input
                        name="name"
                        label="Kategori Adi"
                        placeholder="Kategori adini girin"
                        required
                    />

                    <x-admin.form-input
                        name="slug"
                        label="Slug"
                        placeholder="Otomatik olusturulur"
                        hint="Bos birakirsaniz kategori adindan otomatik olusturulur"
                    />

                    <x-admin.form-select
                        name="parent_id"
                        label="Ust Kategori"
                        :options="$parentCategories->pluck('name', 'id')->toArray()"
                        placeholder="- Ana Kategori -"
                        hint="Bos birakirsaniz ana kategori olarak olusturulur"
                    />

                    <x-admin.form-textarea
                        name="description"
                        label="Aciklama"
                        :rows="3"
                        placeholder="Kategori hakkinda aciklama"
                    />

                    <x-admin.form-image
                        name="image"
                        label="Kategori Gorseli"
                    />

                    <x-admin.form-input
                        name="order"
                        type="number"
                        label="Siralama"
                        :value="0"
                        min="0"
                        hint="Kucuk degerler once gosterilir"
                    />

                    <x-admin.form-toggle
                        name="is_active"
                        label="Aktif"
                        description="Kategori sitede gorunur"
                        :checked="true"
                    />
                </div>
            </x-admin.card>

            <div class="mt-6 flex items-center gap-3">
                <x-admin.button type="submit" icon="fa-check">
                    Kategori Olustur
                </x-admin.button>
                <x-admin.button href="{{ route('admin.categories.index') }}" variant="ghost">
                    Iptal
                </x-admin.button>
            </div>
        </div>
    </form>
@endsection
