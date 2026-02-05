@extends('layouts.admin')

@section('title', 'Kullanici Duzenle')

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700">Kullanicilar</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $user->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Kullanici Duzenle</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $user->email }}</p>
        </div>
        @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}"
                  method="POST"
                  onsubmit="return confirm('Bu kullaniciyi silmek istediginizden emin misiniz?')">
                @csrf
                @method('DELETE')
                <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                    Kullaniciyi Sil
                </x-admin.button>
            </form>
        @endif
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card title="Kullanici Bilgileri">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            label="Ad Soyad"
                            :value="$user->name"
                            required
                        />

                        <x-admin.form-input
                            name="email"
                            type="email"
                            label="E-posta"
                            :value="$user->email"
                            required
                        />

                        <div class="pt-4 border-t border-slate-200">
                            <p class="text-sm font-medium text-slate-700 mb-3">Sifre Degistir</p>
                            <p class="text-xs text-slate-500 mb-4">Sifreyi degistirmek istemiyorsaniz bos birakin</p>

                            <div class="space-y-4">
                                <x-admin.form-input
                                    name="password"
                                    type="password"
                                    label="Yeni Sifre"
                                    placeholder="En az 8 karakter"
                                />

                                <x-admin.form-input
                                    name="password_confirmation"
                                    type="password"
                                    label="Yeni Sifre Tekrar"
                                    placeholder="Sifreyi tekrar girin"
                                />
                            </div>
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card title="Yetki">
                    @if($user->id === auth()->id())
                        <x-admin.alert type="warning" class="mb-4">
                            Kendi admin durumunuzu degistiremezsiniz
                        </x-admin.alert>
                        <x-admin.form-toggle
                            name="is_admin"
                            label="Admin Yetkisi"
                            :checked="$user->is_admin"
                            disabled
                        />
                        <input type="hidden" name="is_admin" value="{{ $user->is_admin ? '1' : '' }}">
                    @else
                        <x-admin.form-toggle
                            name="is_admin"
                            label="Admin Yetkisi"
                            description="Bu kullanici admin paneline erisebilir"
                            :checked="$user->is_admin"
                        />
                    @endif
                </x-admin.card>

                <x-admin.card title="Bilgi">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kayit Tarihi</span>
                            <span class="text-slate-900">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Son Guncelleme</span>
                            <span class="text-slate-900">{{ $user->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="space-y-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            Degisiklikleri Kaydet
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
