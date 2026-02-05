@extends('layouts.admin')

@section('title', __('Reviews'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Reviews') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Reviews') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __(':count reviews listed', ['count' => $reviews->total()]) }}</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.reviews.index') }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('All') }}
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'pending' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Pending') }} ({{ $pendingCount }})
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
           class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') == 'approved' ? 'bg-emerald-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            {{ __('Approved') }} ({{ $approvedCount }})
        </a>
    </div>

    <!-- Reviews Table -->
    <x-admin.data-table :headers="[
        ['label' => __('Product'), 'width' => '20%'],
        ['label' => __('Customer'), 'width' => '20%'],
        ['label' => __('Rating'), 'class' => 'text-center', 'width' => '100px'],
        ['label' => __('Review'), 'width' => '30%'],
        ['label' => __('Status'), 'class' => 'text-center', 'width' => '100px'],
        ['label' => __('Actions'), 'class' => 'text-right', 'width' => '140px'],
    ]">
        @forelse($reviews as $review)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3">
                    <a href="{{ route('products.show', $review->product) }}"
                       target="_blank"
                       class="text-sm text-primary-600 hover:text-primary-700 hover:underline line-clamp-1">
                        {{ Str::limit($review->product->name, 30) }}
                    </a>
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm font-medium text-slate-900">{{ $review->customer_name }}</p>
                    <p class="text-xs text-slate-500">{{ $review->customer_email }}</p>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex items-center justify-center gap-0.5 text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-sm"></i>
                        @endfor
                    </div>
                </td>
                <td class="px-4 py-3">
                    <p class="text-sm text-slate-600 line-clamp-2">{{ Str::limit($review->comment, 80) }}</p>
                </td>
                <td class="px-4 py-3 text-center">
                    <x-admin.badge :variant="$review->is_approved ? 'success' : 'warning'" size="sm" dot>
                        {{ $review->is_approved ? __('Approved') : __('Pending') }}
                    </x-admin.badge>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1">
                        @unless($review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                        title="{{ __('Approve') }}">
                                    <i class="fas fa-check text-sm"></i>
                                </button>
                            </form>
                        @endunless

                        @if($review->is_approved)
                            <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="{{ __('Reject') }}">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.reviews.destroy', $review) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('{{ __('Are you sure you want to delete this review?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="{{ __('Delete') }}">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-star"
                        :title="__('No reviews found')"
                        :description="__('No reviews yet or no reviews matching your search')"
                    />
                </td>
            </tr>
        @endforelse

        <x-slot:footer>
            {{ $reviews->links() }}
        </x-slot:footer>
    </x-admin.data-table>
@endsection
