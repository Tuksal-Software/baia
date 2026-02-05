@extends('layouts.admin')

@section('title', 'Yeni Ozellik')

@section('breadcrumb')
    <a href="{{ route('admin.features.index') }}" class="text-slate-500 hover:text-slate-700">Ozellikler</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Ozellik</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Ozellik</h1>
        <p class="text-sm text-slate-500 mt-1">Yeni bir ozellik olusturun</p>
    </div>

    <form action="{{ route('admin.features.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Temel Bilgiler">
                    <div class="space-y-4">
                        <x-admin.form-select
                            name="icon"
                            label="Ikon"
                            :options="$icons"
                            required
                            hint="Lucide ikonlari kullanilmaktadir"
                        />

                        <x-admin.form-input
                            name="title"
                            label="Baslik"
                            placeholder="Ozellik basligi"
                            required
                        />

                        <x-admin.form-textarea
                            name="description"
                            label="Aciklama"
                            :rows="3"
                        />

                        <x-admin.form-input
                            name="link"
                            label="Link"
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
                            :checked="old('is_active', true)"
                        />

                        <x-admin.form-select
                            name="position"
                            label="Pozisyon"
                            :options="$positions"
                            :value="old('position', 'home')"
                            required
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
            <x-admin.button href="{{ route('admin.features.index') }}" variant="ghost">
                Iptal
            </x-admin.button>
        </div>
    </form>
@endsection
