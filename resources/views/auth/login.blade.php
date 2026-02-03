<!DOCTYPE html>
<html lang="tr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - Baia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-primary-900 to-slate-900 font-sans antialiased">

    <div class="flex min-h-full items-center justify-center px-4 py-12">
        <div class="w-full max-w-md fade-in" x-data="{ showPassword: false, loading: false }">

            {{-- Logo & Title --}}
            <div class="text-center mb-8">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-600 text-white font-bold text-2xl shadow-2xl shadow-primary-600/40 mb-4">
                    B
                </div>
                <h1 class="text-2xl font-bold text-white">Baia Panel</h1>
                <p class="mt-2 text-sm text-slate-400">Hesabınıza giriş yapın</p>
            </div>

            {{-- Login Card --}}
            <div class="rounded-2xl bg-white/95 backdrop-blur-xl shadow-2xl shadow-black/20 p-8">
                <form @submit.prevent="loading = true; setTimeout(() => { loading = false; window.location.href = '/dashboard' }, 1500)" class="space-y-5">

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-posta Adresi</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input
                                id="email"
                                type="email"
                                value="halil@baia.com"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                                placeholder="ornek@email.com"
                            >
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-gray-700">Şifre</label>
                            <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-700 transition-colors">Şifremi Unuttum</a>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                value="password"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-11 text-sm text-gray-900 placeholder-gray-400 outline-none transition-all duration-200 focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10"
                                placeholder="••••••••"
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

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition-colors">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Beni Hatırla</label>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        :disabled="loading"
                        class="relative w-full rounded-xl bg-primary-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/30 transition-all duration-200 hover:bg-primary-700 hover:shadow-xl hover:shadow-primary-600/40 focus:outline-none focus:ring-4 focus:ring-primary-500/30 disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <span :class="{ 'opacity-0': loading }">Giriş Yap</span>
                        <div x-show="loading" class="absolute inset-0 flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <p class="mt-6 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} Baia. Tüm hakları saklıdır.
            </p>
        </div>
    </div>

</body>
</html>
