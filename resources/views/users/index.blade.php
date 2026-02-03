@extends('layouts.app')

@section('page-title', 'Kullanıcılar')
@section('page-subtitle', 'Tüm kullanıcıları yönetin')

@section('content')
<div class="space-y-6 fade-in" x-data="{ selectedUsers: [], selectAll: false, deleteModal: false }">

    {{-- Top Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 rounded-xl bg-white px-3 py-2.5 shadow-sm ring-1 ring-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Kullanıcı ara..." class="bg-transparent border-none text-sm text-gray-700 placeholder-gray-400 outline-none w-48">
            </div>

            {{-- Filters --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 rounded-xl bg-white px-3 py-2.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filtreler
                </button>
                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition
                    class="absolute left-0 mt-2 w-64 rounded-xl bg-white p-4 shadow-lg ring-1 ring-black/5 z-10"
                >
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Rol</label>
                            <select class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10">
                                <option>Tümü</option>
                                <option>Admin</option>
                                <option>Editör</option>
                                <option>Kullanıcı</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Durum</label>
                            <select class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10">
                                <option>Tümü</option>
                                <option>Aktif</option>
                                <option>Pasif</option>
                            </select>
                        </div>
                        <button class="w-full rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                            Uygula
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <a href="/users/create" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary-600/30 hover:bg-primary-700 hover:shadow-xl transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Yeni Kullanıcı
        </a>
    </div>

    {{-- Table --}}
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" x-model="selectAll" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kullanıcı</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Rol</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Durum</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Son Giriş</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    {{-- Row 1 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-700 font-semibold text-sm flex-shrink-0">
                                    AY
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Ahmet Yılmaz</p>
                                    <p class="text-xs text-gray-500">ahmet@baia.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700">Admin</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-sm">
                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                <span class="text-gray-700">Aktif</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">2 saat önce</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-700 font-semibold text-sm flex-shrink-0">
                                    MD
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Mehmet Demir</p>
                                    <p class="text-xs text-gray-500">mehmet@baia.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">Editör</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-sm">
                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                <span class="text-gray-700">Aktif</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">5 saat önce</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 3 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-700 font-semibold text-sm flex-shrink-0">
                                    EK
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Elif Kaya</p>
                                    <p class="text-xs text-gray-500">elif@baia.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">Kullanıcı</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-sm">
                                <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                <span class="text-gray-500">Pasif</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">3 gün önce</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 4 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-rose-100 text-rose-700 font-semibold text-sm flex-shrink-0">
                                    ZA
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Zeynep Arslan</p>
                                    <p class="text-xs text-gray-500">zeynep@baia.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700">Admin</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-sm">
                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                <span class="text-gray-700">Aktif</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">30 dk önce</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 5 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-100 text-cyan-700 font-semibold text-sm flex-shrink-0">
                                    Cİ
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Can İlhan</p>
                                    <p class="text-xs text-gray-500">can@baia.com</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">Editör</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-sm">
                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                <span class="text-gray-700">Aktif</span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">1 saat önce</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between border-t border-gray-100 px-6 py-4">
            <p class="text-sm text-gray-500">
                Toplam <span class="font-semibold text-gray-700">247</span> kullanıcıdan <span class="font-semibold text-gray-700">1-5</span> arası gösteriliyor
            </p>
            <div class="flex items-center gap-1">
                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 transition-colors disabled:opacity-40" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-600 text-sm font-medium text-white">1</button>
                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">2</button>
                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">3</button>
                <span class="flex h-9 w-9 items-center justify-center text-sm text-gray-400">...</span>
                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">50</button>
                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
