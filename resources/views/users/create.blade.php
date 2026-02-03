@extends('layouts.app')

@section('page-title', 'Yeni Kullanıcı')
@section('page-subtitle', 'Sisteme yeni bir kullanıcı ekleyin')

@section('content')
<div class="max-w-3xl fade-in" x-data="{ showPassword: false }">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm mb-6">
        <a href="/users" class="text-gray-500 hover:text-primary-600 transition-colors">Kullanıcılar</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-900 font-medium">Yeni Kullanıcı</span>
    </nav>

    <form @submit.prevent="alert('Bu sadece tasarım aşamasıdır. Backend henüz bağlanmadı.')" class="space-y-6">

        {{-- Personal Info Card --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <h3 class="text-base font-semibold text-gray-900 mb-1">Kişisel Bilgiler</h3>
            <p class="text-sm text-gray-500 mb-6">Kullanıcının temel bilgilerini girin.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- First Name --}}
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1.5">Ad <span class="text-red-500">*</span></label>
                    <input
                        id="first_name"
                        type="text"
                        placeholder="Ahmet"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                    >
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1.5">Soyad <span class="text-red-500">*</span></label>
                    <input
                        id="last_name"
                        type="text"
                        placeholder="Yılmaz"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                    >
                </div>

                {{-- Email --}}
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-posta Adresi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input
                            id="email"
                            type="email"
                            placeholder="ornek@baia.com"
                            class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                        >
                    </div>
                </div>

                {{-- Phone --}}
                <div class="sm:col-span-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Telefon</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input
                            id="phone"
                            type="tel"
                            placeholder="+90 5XX XXX XX XX"
                            class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                        >
                    </div>
                </div>
            </div>
        </div>

        {{-- Account Info Card --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <h3 class="text-base font-semibold text-gray-900 mb-1">Hesap Bilgileri</h3>
            <p class="text-sm text-gray-500 mb-6">Kullanıcı rolü ve şifre ayarları.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Role --}}
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">Rol <span class="text-red-500">*</span></label>
                    <select
                        id="role"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 appearance-none"
                    >
                        <option value="">Rol seçiniz</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editör</option>
                        <option value="user">Kullanıcı</option>
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Durum <span class="text-red-500">*</span></label>
                    <select
                        id="status"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 appearance-none"
                    >
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                    </select>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Şifre <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Min. 8 karakter"
                            class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-11 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Password Confirm --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Şifre Tekrar <span class="text-red-500">*</span></label>
                    <input
                        id="password_confirmation"
                        :type="showPassword ? 'text' : 'password'"
                        placeholder="Şifreyi tekrar girin"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                    >
                </div>
            </div>
        </div>

        {{-- Notification Preferences --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <h3 class="text-base font-semibold text-gray-900 mb-1">Bildirim Tercihleri</h3>
            <p class="text-sm text-gray-500 mb-6">Kullanıcıya gönderilecek bildirimleri seçin.</p>

            <div class="space-y-4">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" checked class="mt-0.5 h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Hoş geldiniz e-postası</p>
                        <p class="text-xs text-gray-500">Kullanıcıya hesap bilgilerini içeren bir hoş geldiniz e-postası gönder</p>
                    </div>
                </label>
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" class="mt-0.5 h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Sistem bildirimleri</p>
                        <p class="text-xs text-gray-500">Önemli sistem güncellemeleri hakkında bildirim gönder</p>
                    </div>
                </label>
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" checked class="mt-0.5 h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Güvenlik uyarıları</p>
                        <p class="text-xs text-gray-500">Şüpheli giriş denemeleri ve güvenlik olayları hakkında uyar</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pb-6">
            <a href="/users" class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                İptal
            </a>
            <button
                type="submit"
                class="rounded-xl bg-primary-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-700 hover:shadow-xl transition-all duration-200"
            >
                Kullanıcı Oluştur
            </button>
        </div>
    </form>
</div>
@endsection
