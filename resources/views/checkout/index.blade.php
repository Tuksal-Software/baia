@extends('layouts.app')
@section('title', __('Checkout'))
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Complete Order') }}</h1>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <form action="{{ route('checkout.process') }}" method="POST" class="bg-white rounded-lg p-6">
                @csrf
                <h2 class="font-semibold text-gray-800 mb-4">{{ __('Contact Information') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div><label class="block text-sm text-gray-600 mb-1">{{ __('Full Name') }} *</label><input type="text" name="name" required value="{{ old('name') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 @error('name') border-red-500 @enderror">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                    <div><label class="block text-sm text-gray-600 mb-1">{{ __('Email') }} *</label><input type="email" name="email" required value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 @error('email') border-red-500 @enderror">@error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                    <div class="md:col-span-2"><label class="block text-sm text-gray-600 mb-1">{{ __('Phone (WhatsApp)') }} *</label><input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="05XX XXX XX XX" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 @error('phone') border-red-500 @enderror">@error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                    <div class="md:col-span-2"><label class="block text-sm text-gray-600 mb-1">{{ __('Address') }}</label><textarea name="address" rows="3" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('address') }}</textarea></div>
                    <div class="md:col-span-2"><label class="block text-sm text-gray-600 mb-1">{{ __('Order Notes') }}</label><textarea name="notes" rows="2" placeholder="{{ __('Notes you want to add...') }}" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('notes') }}</textarea></div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-800"><i class="fab fa-whatsapp text-green-600 mr-2"></i>{{ __('Orders are confirmed via WhatsApp. Payment is made at the door or by bank transfer.') }}</p>
                </div>
                <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition"><i class="fab fa-whatsapp mr-2"></i>{{ __('Order via WhatsApp') }}</button>
            </form>
        </div>
        <div>
            <div class="bg-white rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('My Cart') }}</h3>
                <div class="space-y-3 mb-4">
                    @foreach($cart->items as $item)
                        <div class="flex justify-between text-sm"><span class="text-gray-600">{{ $item->display_name }} x{{ $item->quantity }}</span><span>{{ number_format($item->total, 2) }} {{ __('TL') }}</span></div>
                    @endforeach
                </div>
                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-sm"><span class="text-gray-600">{{ __('Subtotal') }}</span><span>{{ number_format($cart->subtotal, 2) }} {{ __('TL') }}</span></div>
                    @if($discount > 0)<div class="flex justify-between text-sm text-green-600"><span>{{ __('Discount') }} ({{ $discountCode->code }})</span><span>-{{ number_format($discount, 2) }} {{ __('TL') }}</span></div>@endif
                    <div class="flex justify-between font-bold text-lg border-t pt-2"><span>{{ __('Total') }}</span><span>{{ number_format($total, 2) }} {{ __('TL') }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
