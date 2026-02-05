@extends('layouts.admin')

@section('title', 'Yeni Kullanici')

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700">Kullanicilar</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">Yeni Kullanici</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">Yeni Kullanici</h1>
        <p class="text-sm text-slate-500 mt-1">Sisteme yeni kullanici ekleyin</p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Kullanici Bilgileri">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            label="Ad Soyad"
                            placeholder="Kullanici adi"
                            required
                        />

                        <x-admin.form-input
                            name="email"
                            type="email"
                            label="E-posta"
                            placeholder="ornek@email.com"
                            required
                        />

                        <x-admin.form-input
                            name="password"
                            type="password"
                            label="Sifre"
                            placeholder="En az 8 karakter"
                            required
                        />

                        <x-admin.form-input
                            name="password_confirmation"
                            type="password"
                            label="Sifre Tekrar"
                            placeholder="Sifreyi tekrar girin"
                            required
                        />
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card title="Yetki">
                    <x-admin.form-toggle
                        name="is_admin"
                        label="Admin Yetkisi"
                        description="Bu kullanici admin paneline erisebilir"
                    />
                </x-admin.card>

                <x-admin.card>
                    <div class="space-y-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            Kullanici Olustur
                        </x-admin.button>
                        <x-admin.button href="{{ route('admin.users.index') }}" variant="ghost" class="w-full">
                            Iptal
                        </x-admin.button>
                    </div>
                </x-admin.card>
            </div>
        </div>
    </form>
@endsection
