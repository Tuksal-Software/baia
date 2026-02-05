@extends('layouts.app')
@section('title', 'Giris Yap')
@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white border border-gray-100 p-8">
            <h1 class="text-2xl font-serif font-bold text-center mb-2">Giris Yap</h1>
            <p class="text-gray-500 text-center text-sm mb-8">Hesabiniza giris yapin</p>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border border-gray-200 focus:border-black focus:ring-0 outline-none transition-colors @error('email') border-red-500 @enderror"
                           placeholder="ornek@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sifre</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-200 focus:border-black focus:ring-0 outline-none transition-colors"
                           placeholder="Sifreniz">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-black focus:ring-black">
                        <span class="text-sm text-gray-600">Beni hatirla</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-3 bg-black text-white uppercase text-sm tracking-wider hover:bg-gray-800 transition-colors">
                        Giris Yap
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Hesabiniz yok mu?
                    <a href="{{ route('register') }}" class="text-black font-medium hover:underline">Kayit Ol</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
