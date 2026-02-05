@extends('layouts.admin')

@section('title', __('Orders'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Orders') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Orders') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __(':count orders listed', ['count' => $orders->total()]) }}</p>
        </div>
        <x-admin.button href="{{ route('admin.orders.export', request()->all()) }}" variant="secondary" icon="fa-download">
            {{ __('Download CSV') }}
        </x-admin.button>
    </div>

    <!-- Status Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.orders.index') }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('All') }} ({{ $statusCounts->sum() }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Pending') }} ({{ $statusCounts['pending'] ?? 0 }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'confirmed' ? 'bg-sky-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Confirmed') }} ({{ $statusCounts['confirmed'] ?? 0 }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'processing' ? 'bg-indigo-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Preparing') }} ({{ $statusCounts['processing'] ?? 0 }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'shipped' ? 'bg-violet-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Shipped') }} ({{ $statusCounts['shipped'] ?? 0 }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'delivered' ? 'bg-emerald-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Delivered') }} ({{ $statusCounts['delivered'] ?? 0 }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'cancelled' ? 'bg-rose-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Cancelled') }} ({{ $statusCounts['cancelled'] ?? 0 }})
        </a>
    </div>

    <!-- Filters -->
    <x-admin.card class="mb-6" :padding="false">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="p-4">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <x-admin.form-input
                    name="search"
                    :placeholder="__('Order number, customer name...')"
                    :value="request('search')"
                    icon="fa-search"
                />

                <x-admin.form-input
                    type="date"
                    name="date_from"
                    :value="request('date_from')"
                    :placeholder="__('Start Date')"
                />

                <x-admin.form-input
                    type="date"
                    name="date_to"
                    :value="request('date_to')"
                    :placeholder="__('End Date')"
                />

                <div class="flex gap-2 lg:col-span-2">
                    <x-admin.button type="submit" variant="secondary" icon="fa-filter" class="flex-1 sm:flex-none">
                        {{ __('Filter') }}
                    </x-admin.button>
                    @if(request()->hasAny(['search', 'date_from', 'date_to']))
                        <x-admin.button href="{{ route('admin.orders.index', request('status') ? ['status' => request('status')] : []) }}" variant="ghost">
                            {{ __('Clear') }}
                        </x-admin.button>
                    @endif
                </div>
            </div>
        </form>
    </x-admin.card>

    <!-- Orders Table -->
    <x-admin.data-table :headers="[
        ['label' => __('Order'), 'width' => '20%'],
        ['label' => __('Customer'), 'width' => '25%'],
        ['label' => __('Amount'), 'class' => 'text-right'],
        ['label' => __('Status'), 'class' => 'text-center'],
        ['label' => __('Date')],
        ['label' => __('Actions'), 'class' => 'text-right', 'width' => '100px'],
    ]">
        @forelse($orders as $order)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-slate-900 hover:text-primary-600">
                        {{ $order->order_number }}
                    </a>
                    <p class="text-xs text-slate-500 mt-0.5">{{ __(':count products', ['count' => $order->items->count()]) }}</p>
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-slate-900">{{ $order->customer_name }}</p>
                    <p class="text-xs text-slate-500">{{ $order->customer_phone }}</p>
                </td>
                <td class="px-4 py-3 text-right">
                    <span class="text-sm font-semibold text-slate-900">{{ number_format($order->total, 2) }} TL</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                                onchange="this.form.submit()"
                                class="text-xs font-medium border-0 rounded-full px-3 py-1 cursor-pointer focus:ring-2 focus:ring-primary-500
                                    {{ match($order->status) {
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'confirmed' => 'bg-sky-100 text-sky-700',
                                        'processing' => 'bg-indigo-100 text-indigo-700',
                                        'shipped' => 'bg-violet-100 text-violet-700',
                                        'delivered' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-rose-100 text-rose-700',
                                        default => 'bg-slate-100 text-slate-700'
                                    } }}">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>{{ __('Confirmed') }}</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{ __('Preparing') }}</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                        </select>
                    </form>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-slate-600">{{ $order->created_at->format('d.m.Y') }}</span>
                    <p class="text-xs text-slate-400">{{ $order->created_at->format('H:i') }}</p>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                           title="{{ __('Details') }}">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-shopping-bag"
                        :title="__('No orders found')"
                        :description="__('No orders matching your search or no orders yet')"
                    />
                </td>
            </tr>
        @endforelse

        <x-slot:footer>
            {{ $orders->links() }}
        </x-slot:footer>
    </x-admin.data-table>
@endsection
