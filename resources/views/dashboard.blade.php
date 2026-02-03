@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Genel bakış ve istatistikler')

@section('content')
<div class="space-y-6 fade-in">

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        {{-- Total Users --}}
        <div class="group rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 hover:shadow-md hover:ring-primary-100 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Toplam Kullanıcı</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">2,847</p>
                    <div class="mt-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-sm font-medium text-green-600">+12.5%</span>
                        <span class="text-xs text-gray-400">bu ay</span>
                    </div>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-50 text-primary-600 group-hover:bg-primary-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Active Users --}}
        <div class="group rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 hover:shadow-md hover:ring-green-100 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Aktif Kullanıcı</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">1,234</p>
                    <div class="mt-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-sm font-medium text-green-600">+8.2%</span>
                        <span class="text-xs text-gray-400">bu ay</span>
                    </div>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-600 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="group rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 hover:shadow-md hover:ring-purple-100 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Gelir</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">₺48.2K</p>
                    <div class="mt-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-sm font-medium text-green-600">+23.1%</span>
                        <span class="text-xs text-gray-400">bu ay</span>
                    </div>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-purple-600 group-hover:bg-purple-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Tasks --}}
        <div class="group rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 hover:shadow-md hover:ring-amber-100 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Bekleyen İşlem</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">18</p>
                    <div class="mt-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-sm font-medium text-red-600">-4.3%</span>
                        <span class="text-xs text-gray-400">bu ay</span>
                    </div>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 group-hover:bg-amber-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        {{-- Main Chart --}}
        <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Kullanıcı Artışı</h3>
                    <p class="text-sm text-gray-500">Son 7 gün</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="rounded-lg bg-primary-50 px-3 py-1.5 text-xs font-medium text-primary-700 transition-colors hover:bg-primary-100">7G</button>
                    <button class="rounded-lg px-3 py-1.5 text-xs font-medium text-gray-500 transition-colors hover:bg-gray-100">30G</button>
                    <button class="rounded-lg px-3 py-1.5 text-xs font-medium text-gray-500 transition-colors hover:bg-gray-100">90G</button>
                </div>
            </div>
            {{-- Chart Placeholder --}}
            <div class="relative h-64">
                <svg class="w-full h-full" viewBox="0 0 700 250" fill="none">
                    {{-- Grid Lines --}}
                    <line x1="0" y1="50" x2="700" y2="50" stroke="#f1f5f9" stroke-width="1"/>
                    <line x1="0" y1="100" x2="700" y2="100" stroke="#f1f5f9" stroke-width="1"/>
                    <line x1="0" y1="150" x2="700" y2="150" stroke="#f1f5f9" stroke-width="1"/>
                    <line x1="0" y1="200" x2="700" y2="200" stroke="#f1f5f9" stroke-width="1"/>

                    {{-- Area --}}
                    <defs>
                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.2"/>
                            <stop offset="100%" stop-color="#3b82f6" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,180 C50,170 100,140 150,120 C200,100 250,130 300,110 C350,90 400,60 450,80 C500,100 550,50 600,40 C650,30 680,35 700,30 L700,250 L0,250 Z" fill="url(#chartGradient)"/>

                    {{-- Line --}}
                    <path d="M0,180 C50,170 100,140 150,120 C200,100 250,130 300,110 C350,90 400,60 450,80 C500,100 550,50 600,40 C650,30 680,35 700,30" stroke="#3b82f6" stroke-width="3" fill="none" stroke-linecap="round"/>

                    {{-- Points --}}
                    <circle cx="0" cy="180" r="4" fill="#3b82f6"/>
                    <circle cx="150" cy="120" r="4" fill="#3b82f6"/>
                    <circle cx="300" cy="110" r="4" fill="#3b82f6"/>
                    <circle cx="450" cy="80" r="4" fill="#3b82f6"/>
                    <circle cx="600" cy="40" r="5" fill="#3b82f6" stroke="white" stroke-width="2"/>
                    <circle cx="700" cy="30" r="4" fill="#3b82f6"/>
                </svg>

                {{-- Labels --}}
                <div class="absolute bottom-0 left-0 right-0 flex justify-between px-2 text-xs text-gray-400">
                    <span>Pzt</span><span>Sal</span><span>Çar</span><span>Per</span><span>Cum</span><span>Cmt</span><span>Paz</span>
                </div>
            </div>
        </div>

        {{-- Donut Chart / Stats --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <h3 class="text-base font-semibold text-gray-900 mb-1">Kullanıcı Dağılımı</h3>
            <p class="text-sm text-gray-500 mb-6">Rol bazında dağılım</p>

            {{-- Donut Chart Placeholder --}}
            <div class="flex justify-center mb-6">
                <svg width="180" height="180" viewBox="0 0 180 180">
                    <circle cx="90" cy="90" r="70" fill="none" stroke="#eff6ff" stroke-width="20"/>
                    <circle cx="90" cy="90" r="70" fill="none" stroke="#3b82f6" stroke-width="20"
                            stroke-dasharray="264 176" stroke-dashoffset="0" stroke-linecap="round"
                            transform="rotate(-90 90 90)"/>
                    <circle cx="90" cy="90" r="70" fill="none" stroke="#10b981" stroke-width="20"
                            stroke-dasharray="110 330" stroke-dashoffset="-264" stroke-linecap="round"
                            transform="rotate(-90 90 90)"/>
                    <circle cx="90" cy="90" r="70" fill="none" stroke="#f59e0b" stroke-width="20"
                            stroke-dasharray="66 374" stroke-dashoffset="-374" stroke-linecap="round"
                            transform="rotate(-90 90 90)"/>
                    <text x="90" y="85" text-anchor="middle" class="text-2xl font-bold" fill="#1e293b" font-size="24" font-weight="700">2,847</text>
                    <text x="90" y="105" text-anchor="middle" fill="#94a3b8" font-size="12">Toplam</text>
                </svg>
            </div>

            {{-- Legend --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-primary-500"></div>
                        <span class="text-sm text-gray-600">Admin</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">1,710 (60%)</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        <span class="text-sm text-gray-600">Editör</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">712 (25%)</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="h-3 w-3 rounded-full bg-amber-500"></div>
                        <span class="text-sm text-gray-600">Kullanıcı</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">425 (15%)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        {{-- Recent Activity --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-semibold text-gray-900">Son Aktiviteler</h3>
                <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">Tümünü Gör</a>
            </div>

            <div class="space-y-4">
                {{-- Activity Item --}}
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-600 flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900"><span class="font-medium">Ahmet Yılmaz</span> yeni kullanıcı olarak eklendi</p>
                        <p class="text-xs text-gray-400 mt-0.5">2 dakika önce</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-100 text-primary-600 flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900"><span class="font-medium">Sistem ayarları</span> güncellendi</p>
                        <p class="text-xs text-gray-400 mt-0.5">15 dakika önce</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-100 text-amber-600 flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900"><span class="font-medium">Mehmet Demir</span> 3 kez başarısız giriş denemesi yaptı</p>
                        <p class="text-xs text-gray-400 mt-0.5">1 saat önce</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-red-100 text-red-600 flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900"><span class="font-medium">Eski rapor</span> silindi</p>
                        <p class="text-xs text-gray-400 mt-0.5">3 saat önce</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-purple-100 text-purple-600 flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900"><span class="font-medium">Yedekleme</span> başarıyla tamamlandı</p>
                        <p class="text-xs text-gray-400 mt-0.5">5 saat önce</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions + Server Status --}}
        <div class="space-y-4 lg:space-y-6">
            {{-- Quick Actions --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Hızlı İşlemler</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="/users/create" class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 p-4 text-center hover:border-primary-300 hover:bg-primary-50 transition-all duration-200">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-100 text-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-gray-700">Kullanıcı Ekle</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 p-4 text-center hover:border-green-300 hover:bg-green-50 transition-all duration-200">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-gray-700">Rapor Oluştur</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 p-4 text-center hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-gray-700">Dışa Aktar</span>
                    </a>
                    <a href="#" class="flex flex-col items-center gap-2 rounded-xl border border-gray-200 p-4 text-center hover:border-amber-300 hover:bg-amber-50 transition-all duration-200">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-gray-700">Ayarlar</span>
                    </a>
                </div>
            </div>

            {{-- Server Status --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Sunucu Durumu</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm text-gray-600">CPU Kullanımı</span>
                            <span class="text-sm font-semibold text-gray-900">45%</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-100">
                            <div class="h-2 rounded-full bg-primary-500 transition-all duration-500" style="width: 45%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm text-gray-600">Bellek</span>
                            <span class="text-sm font-semibold text-gray-900">72%</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-100">
                            <div class="h-2 rounded-full bg-amber-500 transition-all duration-500" style="width: 72%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm text-gray-600">Disk</span>
                            <span class="text-sm font-semibold text-gray-900">28%</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-100">
                            <div class="h-2 rounded-full bg-green-500 transition-all duration-500" style="width: 28%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
