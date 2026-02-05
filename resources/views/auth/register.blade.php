@extends('layouts.app')
@section('title', 'Kayit Ol')
@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white border border-gray-100 p-8">
            <h1 class="text-2xl font-serif font-bold text-center mb-2">Kayit Ol</h1>
            <p class="text-gray-500 text-center text-sm mb-8">Hesabinizi olusturun ve alisverise baslayin</p>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-200 focus:border-black focus:ring-0 outline-none transition-colors @error('name') border-red-500 @enderror"
                           placeholder="Adiniz Soyadiniz">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

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
                           class="w-full px-4 py-3 border border-gray-200 focus:border-black focus:ring-0 outline-none transition-colors @error('password') border-red-500 @enderror"
                           placeholder="En az 8 karakter">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sifre Tekrar</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 border border-gray-200 focus:border-black focus:ring-0 outline-none transition-colors"
                           placeholder="Sifrenizi tekrar giriniz">
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-3 bg-black text-white uppercase text-sm tracking-wider hover:bg-gray-800 transition-colors">
                        Kayit Ol
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Zaten hesabiniz var mi?
                    <a href="{{ route('login') }}" class="text-black font-medium hover:underline">Giris Yap</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
