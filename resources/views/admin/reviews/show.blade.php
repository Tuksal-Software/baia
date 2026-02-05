@extends('layouts.admin')

@section('title', __('Review Detail'))

@section('breadcrumb')
    <a href="{{ route('admin.reviews.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Reviews') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ __('Review') }} #{{ $review->id }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ __('Review Detail') }}</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $review->created_at->format('d.m.Y H:i') }}</p>
            </div>
            <x-admin.badge :variant="$review->is_approved ? 'success' : 'warning'" size="lg" dot>
                {{ $review->is_approved ? __('Approved') : __('Pending') }}
            </x-admin.badge>
        </div>
        <div class="flex items-center gap-2">
            @unless($review->is_approved)
                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                    @csrf
                    <x-admin.button type="submit" variant="secondary" icon="fa-check">
                        {{ __('Approve') }}
                    </x-admin.button>
                </form>
            @endunless

            @if($review->is_approved)
                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                    @csrf
                    <x-admin.button type="submit" variant="ghost" icon="fa-times">
                        {{ __('Reject') }}
                    </x-admin.button>
                </form>
            @endif

            <form action="{{ route('admin.reviews.destroy', $review) }}"
                  method="POST"
                  onsubmit="return confirm('{{ __('Are you sure you want to delete this review?') }}')">
                @csrf
                @method('DELETE')
                <x-admin.button type="submit" variant="danger" icon="fa-trash">
                    {{ __('Delete') }}
                </x-admin.button>
            </form>
        </div>
    </div>

    <div class="max-w-3xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Review Content -->
            <div class="md:col-span-2">
                <x-admin.card :title="__('Review Content')">
                    <!-- Rating -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-lg"></i>
                            @endfor
                        </div>
                        <span class="text-lg font-semibold text-slate-900">{{ $review->rating }}/5</span>
                    </div>

                    <!-- Comment -->
                    @if($review->comment)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <p class="text-slate-700 leading-relaxed">{{ $review->comment }}</p>
                        </div>
                    @else
                        <p class="text-sm text-slate-500 italic">{{ __('No review text entered') }}</p>
                    @endif
                </x-admin.card>
            </div>

            <!-- Customer Info -->
            <x-admin.card :title="__('Customer Information')">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Full Name') }}</dt>
                        <dd class="text-sm font-medium text-slate-900 mt-1">{{ $review->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Email') }}</dt>
                        <dd class="text-sm text-slate-900 mt-1">{{ $review->customer_email }}</dd>
                    </div>
                </dl>
            </x-admin.card>

            <!-- Product Info -->
            <x-admin.card :title="__('Product Information')">
                <div class="flex items-start gap-4">
                    @if($review->product->primaryImage)
                        <img src="{{ $review->product->primaryImage->image_url }}"
                             alt="{{ $review->product->name }}"
                             class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                    @else
                        <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                            <i class="fas fa-image text-slate-400"></i>
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('admin.products.show', $review->product) }}"
                           class="text-sm font-medium text-slate-900 hover:text-primary-600">
                            {{ $review->product->name }}
                        </a>
                        <p class="text-xs text-slate-500 mt-1">SKU: {{ $review->product->sku ?? '-' }}</p>
                        <a href="{{ route('products.show', $review->product) }}"
                           target="_blank"
                           class="inline-flex items-center gap-1 text-xs text-primary-600 hover:text-primary-700 mt-2">
                            <i class="fas fa-external-link-alt"></i>
                            {{ __('View on Site') }}
                        </a>
                    </div>
                </div>
            </x-admin.card>

            <!-- Metadata -->
            <div class="md:col-span-2">
                <x-admin.card :title="__('Additional Information')">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Review ID') }}</dt>
                            <dd class="text-sm font-medium text-slate-900 mt-1">#{{ $review->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Created') }}</dt>
                            <dd class="text-sm text-slate-900 mt-1">{{ $review->created_at->format('d.m.Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Last Updated') }}</dt>
                            <dd class="text-sm text-slate-900 mt-1">{{ $review->updated_at->format('d.m.Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500 uppercase tracking-wide">{{ __('Status') }}</dt>
                            <dd class="mt-1">
                                <x-admin.badge :variant="$review->is_approved ? 'success' : 'warning'" size="sm">
                                    {{ $review->is_approved ? __('Approved') : __('Pending') }}
                                </x-admin.badge>
                            </dd>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>
    </div>
@endsection
