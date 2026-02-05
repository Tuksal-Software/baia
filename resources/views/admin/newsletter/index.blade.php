@extends('layouts.admin')

@section('title', __('Newsletter Subscribers'))

@section('breadcrumb')
    <span class="text-slate-700 font-medium">{{ __('Newsletter Subscribers') }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Newsletter Subscribers') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ __('Manage email subscriptions') }}</p>
        </div>
        <x-admin.button href="{{ route('admin.newsletter.export', request()->all()) }}" variant="success" icon="fa-download">
            {{ __('Download CSV') }}
        </x-admin.button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <x-admin.stats-card
            :title="__('Total Subscribers')"
            :value="$stats['total']"
            icon="fa-users"
            color="primary"
        />
        <x-admin.stats-card
            :title="__('Active Subscribers')"
            :value="$stats['active']"
            icon="fa-user-check"
            color="success"
        />
        <x-admin.stats-card
            :title="__('Unsubscribed')"
            :value="$stats['inactive']"
            icon="fa-user-times"
            color="danger"
        />
    </div>

    <!-- Filters -->
    <x-admin.card class="mb-6" :padding="false">
        <form action="{{ route('admin.newsletter.index') }}" method="GET" class="p-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <x-admin.form-input
                        name="search"
                        :placeholder="__('Search by email address...')"
                        :value="request('search')"
                        icon="fa-search"
                    />
                </div>
                <div class="w-full sm:w-48">
                    <x-admin.form-select
                        name="status"
                        :value="request('status')"
                        :options="['' => __('All Statuses'), 'active' => __('Active'), 'inactive' => __('Cancelled')]"
                        :placeholder="__('Select Status')"
                    />
                </div>
                <div class="flex gap-2">
                    <x-admin.button type="submit" variant="secondary" icon="fa-filter">
                        {{ __('Filter') }}
                    </x-admin.button>
                    @if(request()->hasAny(['search', 'status']))
                        <x-admin.button href="{{ route('admin.newsletter.index') }}" variant="ghost">
                            {{ __('Clear') }}
                        </x-admin.button>
                    @endif
                </div>
            </div>
        </form>
    </x-admin.card>

    <!-- Subscribers Table -->
    <x-admin.data-table
        :selectable="true"
        :headers="[
            __('Email'),
            ['label' => __('Status'), 'class' => 'text-center', 'width' => '120px'],
            ['label' => __('Subscribe Date'), 'class' => 'text-center', 'width' => '160px'],
            ['label' => __('Unsubscribe Date'), 'class' => 'text-center', 'width' => '160px'],
            ['label' => __('Actions'), 'class' => 'text-right', 'width' => '100px']
        ]"
        x-data="{
            selectedIds: [],
            selectAll: false,
            toggleAll(checked) {
                this.selectAll = checked;
                this.selectedIds = checked
                    ? Array.from(document.querySelectorAll('.subscriber-checkbox')).map(cb => cb.value)
                    : [];
            },
            toggleOne(id, checked) {
                if (checked && !this.selectedIds.includes(id)) {
                    this.selectedIds.push(id);
                } else if (!checked) {
                    this.selectedIds = this.selectedIds.filter(i => i !== id);
                }
            }
        }"
        @select-all.window="toggleAll($event.detail)"
    >
        @forelse($subscribers as $subscriber)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3">
                    <input type="checkbox"
                           class="subscriber-checkbox w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500"
                           value="{{ $subscriber->id }}"
                           @change="toggleOne('{{ $subscriber->id }}', $event.target.checked)"
                           :checked="selectedIds.includes('{{ $subscriber->id }}')">
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-slate-400"></i>
                        </div>
                        <span class="text-sm font-medium text-slate-900">{{ $subscriber->email }}</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-center">
                    <form action="{{ route('admin.newsletter.toggle-status', $subscriber) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex">
                            @if($subscriber->is_active)
                                <x-admin.badge variant="success" size="sm" dot>{{ __('Active') }}</x-admin.badge>
                            @else
                                <x-admin.badge variant="danger" size="sm" dot>{{ __('Cancelled') }}</x-admin.badge>
                            @endif
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm text-slate-500">
                        {{ $subscriber->subscribed_at?->format('d.m.Y H:i') ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-sm text-slate-500">
                        {{ $subscriber->unsubscribed_at?->format('d.m.Y H:i') ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <form action="{{ route('admin.newsletter.destroy', $subscriber) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('{{ __('Are you sure you want to delete this subscriber?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                title="{{ __('Delete') }}">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-12">
                    <x-admin.empty-state
                        icon="fa-envelope"
                        :title="__('No subscribers found')"
                        :description="__('No newsletter subscribers yet or no results matching your search.')"
                    />
                </td>
            </tr>
        @endforelse

        <x-slot:footer>
            <div class="flex items-center justify-between">
                <div x-show="selectedIds.length > 0" x-cloak class="flex items-center gap-3">
                    <span class="text-sm text-slate-600">
                        <span x-text="selectedIds.length"></span> {{ __('subscribers selected') }}
                    </span>
                    <form action="{{ route('admin.newsletter.bulk-delete') }}" method="POST" class="inline"
                          onsubmit="return confirm('{{ __('Are you sure you want to delete selected subscribers?') }}')">
                        @csrf
                        <input type="hidden" name="ids" :value="JSON.stringify(selectedIds)">
                        <x-admin.button type="submit" variant="danger" size="sm" icon="fa-trash">
                            {{ __('Delete Selected') }}
                        </x-admin.button>
                    </form>
                </div>
                <div x-show="selectedIds.length === 0" class="text-sm text-slate-500">
                    {{ __(':count subscribers', ['count' => $subscribers->total()]) }}
                </div>
                <div>
                    {{ $subscribers->links() }}
                </div>
            </div>
        </x-slot:footer>
    </x-admin.data-table>
@endsection
