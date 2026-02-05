@extends('layouts.admin')

@section('title', __('Order Detail'))

@section('breadcrumb')
    <a href="{{ route('admin.orders.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Orders') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $order->order_number }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ $order->order_number }}</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $order->created_at->format('d.m.Y H:i') }}</p>
            </div>
            @php
                $statusVariant = match($order->status) {
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'processing' => 'primary',
                    'shipped' => 'primary',
                    'delivered' => 'success',
                    'cancelled' => 'danger',
                    default => 'default'
                };
            @endphp
            <x-admin.badge :variant="$statusVariant" size="lg">
                {{ $order->status_label }}
            </x-admin.badge>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ $whatsappUrl }}" target="_blank">
                <x-admin.button variant="secondary" icon="fa-brands fa-whatsapp">
                    WhatsApp
                </x-admin.button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <x-admin.card :title="__('Products')" :subtitle="__(':count products', ['count' => $order->items->count()])">
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center p-4 bg-slate-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ $item->display_name }}</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ number_format($item->price, 2) }} TL x {{ $item->quantity }}
                                </p>
                            </div>
                            <p class="text-sm font-semibold text-slate-900">{{ number_format($item->total, 2) }} TL</p>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="border-t border-slate-200 mt-4 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">{{ __('Subtotal') }}</span>
                        <span class="text-slate-900">{{ number_format($order->subtotal, 2) }} TL</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-emerald-600">{{ __('Discount') }} ({{ $order->discount_code }})</span>
                            <span class="text-emerald-600">-{{ number_format($order->discount, 2) }} TL</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base font-semibold pt-2 border-t border-slate-100">
                        <span class="text-slate-900">{{ __('Total') }}</span>
                        <span class="text-slate-900">{{ number_format($order->total, 2) }} TL</span>
                    </div>
                </div>
            </x-admin.card>

            <!-- Notes -->
            <x-admin.card :title="__('Notes')">
                @if($order->notes)
                    <div class="bg-slate-50 rounded-lg p-4 text-sm text-slate-700 whitespace-pre-line mb-4">
                        {{ $order->notes }}
                    </div>
                @endif

                <form action="{{ route('admin.orders.add-note', $order) }}" method="POST">
                    @csrf
                    <x-admin.form-textarea
                        name="notes"
                        :placeholder="__('Add note...')"
                        rows="2"
                    />
                    <div class="mt-3">
                        <x-admin.button type="submit" icon="fa-plus">
                            {{ __('Add Note') }}
                        </x-admin.button>
                    </div>
                </form>
            </x-admin.card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <x-admin.card :title="__('Customer Information')">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Full Name') }}</dt>
                        <dd class="text-sm font-medium text-slate-900 mt-1">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Email') }}</dt>
                        <dd class="text-sm text-slate-900 mt-1">{{ $order->customer_email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Phone') }}</dt>
                        <dd class="text-sm mt-1">
                            <a href="tel:{{ $order->customer_phone }}" class="text-primary-600 hover:text-primary-700">
                                {{ $order->customer_phone }}
                            </a>
                        </dd>
                    </div>
                    @if($order->customer_address)
                        <div>
                            <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Address') }}</dt>
                            <dd class="text-sm text-slate-900 mt-1">{{ $order->customer_address }}</dd>
                        </div>
                    @endif
                </dl>
            </x-admin.card>

            <!-- Update Status -->
            <x-admin.card :title="__('Update Status')">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <x-admin.form-select
                        name="status"
                        :value="$order->status"
                        :options="[
                            'pending' => __('Pending'),
                            'confirmed' => __('Confirmed'),
                            'processing' => __('Preparing'),
                            'shipped' => __('Shipped'),
                            'delivered' => __('Delivered'),
                            'cancelled' => __('Cancelled'),
                        ]"
                    />
                    <div class="mt-3">
                        <x-admin.button type="submit" class="w-full" icon="fa-check">
                            {{ __('Update') }}
                        </x-admin.button>
                    </div>
                </form>
            </x-admin.card>

            <!-- Timeline -->
            <x-admin.card :title="__('Timeline')">
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ __('Order Created') }}</p>
                            <p class="text-xs text-slate-500">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    @if($order->confirmed_at)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ __('Confirmed') }}</p>
                                <p class="text-xs text-slate-500">{{ $order->confirmed_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($order->shipped_at)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-violet-100 text-violet-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-truck text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ __('Shipped') }}</p>
                                <p class="text-xs text-slate-500">{{ $order->shipped_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($order->delivered_at)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-box-check text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ __('Delivered') }}</p>
                                <p class="text-xs text-slate-500">{{ $order->delivered_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($order->cancelled_at)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-times text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ __('Cancelled') }}</p>
                                <p class="text-xs text-slate-500">{{ $order->cancelled_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </x-admin.card>
        </div>
    </div>
@endsection
