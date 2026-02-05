@extends('layouts.admin')

@section('title', 'Kullanicilar')

@section('breadcrumb')
    <span class="text-slate-700 font-medium">Kullanicilar</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Kullanicilar</h1>
            <p class="text-sm text-slate-500 mt-1">Tum kullanicilari yonetin</p>
        </div>
        <x-admin.button href="{{ route('admin.users.create') }}" icon="fa-plus">
            Yeni Kullanici
        </x-admin.button>
    </div>

    <!-- Filters -->
    <x-admin.card class="mb-6" :padding="false">
        <form action="{{ route('admin.users.index') }}" method="GET" class="p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <x-admin.form-input
                        name="search"
                        placeholder="Isim veya e-posta ile ara..."
                        :value="request('search')"
                        icon="fa-search"
                    />
                </div>
                <div class="w-full sm:w-48">
                    <x-admin.form-select
                        name="role"
                        :value="request('role')"
                        :options="['' => 'Tum Roller', 'admin' => 'Admin', 'user' => 'Kullanici']"
                        placeholder="Rol Sec"
                    />
                </div>
                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="secondary" icon="fa-filter">
                        Filtrele
                    </x-admin.button>
                    @if(request()->hasAny(['search', 'role']))
                        <x-admin.button href="{{ route('admin.users.index') }}" variant="ghost">
                            Temizle
                        </x-admin.button>
                    @endif
                </div>
            </div>
        </form>
    </x-admin.card>

    <!-- Users Table -->
    <x-admin.data-table :headers="[
        'Kullanici',
        'E-posta',
        'Rol',
        'Kayit Tarihi',
        ['label' => 'Islemler', 'class' => 'text-right', 'width' => '120px']
    ]">
        @forelse($users as $user)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                            @if($user->id === auth()->id())
                                <span class="text-xs text-primary-600">(Siz)</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-600">{{ $user->email }}</span>
                </td>
                <td class="px-4 py-3">
                    @if($user->is_admin)
                        <x-admin.badge variant="primary" size="sm" dot>Admin</x-admin.badge>
                    @else
                        <x-admin.badge variant="default" size="sm">Kullanici</x-admin.badge>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-500">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                           title="Goruntule">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="Duzenle">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="{{ $user->is_admin ? 'Admin yetkisini kaldir' : 'Admin yetkisi ver' }}">
                                    <i class="fas {{ $user->is_admin ? 'fa-user-minus' : 'fa-user-shield' }} text-sm"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Bu kullaniciyi silmek istediginizden emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                        title="Sil">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-users"
                        title="Kullanici bulunamadi"
                        description="Arama kriterlerinize uygun kullanici yok"
                    />
                </td>
            </tr>
        @endforelse

        <x-slot:footer>
            {{ $users->links() }}
        </x-slot:footer>
    </x-admin.data-table>
@endsection
