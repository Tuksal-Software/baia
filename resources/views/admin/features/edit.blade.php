@extends('layouts.admin')

@section('title', 'Ozellik Duzenle')

@section('breadcrumb')
    <a href="{{ route('admin.features.index') }}" class="text-slate-500 hover:text-slate-700">Ozellikler</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $feature->title }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Ozellik Duzenle</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $feature->title }}</p>
        </div>
        <form action="{{ route('admin.features.destroy', $feature) }}"
              method="POST"
              onsubmit="return confirm('Bu ozelligi silmek istediginizden emin misiniz?')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                Sil
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.features.update', $feature) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="icon"
                            label="Ikon"
                            :options="$icons"
                            :value="$feature->icon"
                            required
                        />

                        <x-admin.form-input
                            name="title"
                            label="Baslik"
                            :value="$feature->title"
                            required
                        />

                        <x-admin.form-textarea
                            name="description"
                            label="Aciklama"
                            :value="$feature->description"
                            :rows="3"
                        />

                        <x-admin.form-input
                            name="link"
                            label="Link"
                            :value="$feature->link"
                            placeholder="/sayfa/..."
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
                            description="Ozellik sitede gorunur"
                            :checked="$feature->is_active"
                        />

                        <x-admin.form-select
                            name="position"
                            label="Pozisyon"
                            :options="$positions"
                            :value="$feature->position"
                            required
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="Sira"
                            :value="$feature->order"
                            min="0"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card title="Bilgi">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Olusturulma</span>
                            <span class="text-slate-900">{{ $feature->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Son Guncelleme</span>
                            <span class="text-slate-900">{{ $feature->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                Degisiklikleri Kaydet
            </x-admin.button>
            <x-admin.button href="{{ route('admin.features.index') }}" variant="ghost">
                Iptal
            </x-admin.button>
        </div>
    </form>
@endsection
