@extends('layouts.admin')

@section('title', $user->name)

@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700">Kullanicilar</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $user->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center">
                <span class="text-2xl font-semibold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ $user->name }}</h1>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <x-admin.button href="{{ route('admin.users.edit', $user) }}" icon="fa-edit">
                Duzenle
            </x-admin.button>
            @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      onsubmit="return confirm('Bu kullaniciyi silmek istediginizden emin misiniz?')">
                    @csrf
                    @method('DELETE')
                    <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                        Sil
                    </x-admin.button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card title="Kullanici Bilgileri">
                <dl class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">Ad Soyad</dt>
                        <dd class="text-sm text-slate-900 mt-1 sm:mt-0">{{ $user->name }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">E-posta</dt>
                        <dd class="text-sm text-slate-900 mt-1 sm:mt-0">{{ $user->email }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">Rol</dt>
                        <dd class="mt-1 sm:mt-0">
                            @if($user->is_admin)
                                <x-admin.badge variant="primary" dot>Admin</x-admin.badge>
                            @else
                                <x-admin.badge variant="default">Kullanici</x-admin.badge>
                            @endif
                        </dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3 border-b border-slate-100">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">Kayit Tarihi</dt>
                        <dd class="text-sm text-slate-900 mt-1 sm:mt-0">{{ $user->created_at->format('d.m.Y H:i') }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center py-3">
                        <dt class="text-sm font-medium text-slate-500 sm:w-1/3">E-posta Dogrulama</dt>
                        <dd class="mt-1 sm:mt-0">
                            @if($user->email_verified_at)
                                <x-admin.badge variant="success" dot>Dogrulandi</x-admin.badge>
                                <span class="text-xs text-slate-500 ml-2">{{ $user->email_verified_at->format('d.m.Y') }}</span>
                            @else
                                <x-admin.badge variant="warning">Dogrulanmadi</x-admin.badge>
                            @endif
                        </dd>
                    </div>
                </dl>
            </x-admin.card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <x-admin.card title="Hizli Islemler">
                <div class="space-y-3">
                    <x-admin.button href="{{ route('admin.users.edit', $user) }}" variant="secondary" class="w-full" icon="fa-edit">
                        Kullaniciyi Duzenle
                    </x-admin.button>

                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <x-admin.button type="submit" variant="secondary" class="w-full" icon="{{ $user->is_admin ? 'fa-user-minus' : 'fa-user-shield' }}">
                                {{ $user->is_admin ? 'Admin Yetkisini Kaldir' : 'Admin Yetkisi Ver' }}
                            </x-admin.button>
                        </form>
                    @endif
                </div>
            </x-admin.card>

            <x-admin.card title="Aktivite">
                <div class="text-sm text-slate-500 text-center py-4">
                    Kullanici aktivite gecmisi burada gorunecek
                </div>
            </x-admin.card>
        </div>
    </div>
@endsection
