@extends('layouts.app')
@section('title', 'Iletisim')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Iletisim</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-lg p-6">
            <h2 class="font-semibold text-lg mb-4">Bize Ulasin</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-3"><div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center"><i class="fas fa-phone text-purple-600"></i></div><div><p class="text-sm text-gray-500">Telefon</p><a href="tel:+905551234567" class="font-medium hover:text-purple-600">0555 123 45 67</a></div></div>
                <div class="flex items-center gap-3"><div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center"><i class="fab fa-whatsapp text-green-600"></i></div><div><p class="text-sm text-gray-500">WhatsApp</p><a href="https://wa.me/905551234567" class="font-medium hover:text-green-600">0555 123 45 67</a></div></div>
                <div class="flex items-center gap-3"><div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-envelope text-blue-600"></i></div><div><p class="text-sm text-gray-500">E-posta</p><a href="mailto:info@baia.com" class="font-medium hover:text-blue-600">info@baia.com</a></div></div>
                <div class="flex items-center gap-3"><div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-map-marker-alt text-red-600"></i></div><div><p class="text-sm text-gray-500">Adres</p><p class="font-medium">Istanbul, Turkiye</p></div></div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-6">
            <h2 class="font-semibold text-lg mb-4">Calisma Saatleri</h2>
            <div class="space-y-2 text-sm"><div class="flex justify-between"><span class="text-gray-600">Pazartesi - Cuma</span><span>09:00 - 18:00</span></div><div class="flex justify-between"><span class="text-gray-600">Cumartesi</span><span>10:00 - 16:00</span></div><div class="flex justify-between"><span class="text-gray-600">Pazar</span><span>Kapali</span></div></div>
            <div class="mt-6 p-4 bg-green-50 rounded-lg"><p class="text-sm text-green-800"><i class="fab fa-whatsapp mr-2"></i>WhatsApp uzerinden 7/24 mesaj gonderebilirsiniz.</p></div>
        </div>
    </div>
</div>
@endsection
