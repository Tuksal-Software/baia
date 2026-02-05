@extends('layouts.admin')

@section('title', __('Edit Banner'))

@section('breadcrumb')
    <a href="{{ route('admin.banners.index') }}" class="text-slate-500 hover:text-slate-700">{{ __('Banners') }}</a>
    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
    <span class="text-slate-700 font-medium">{{ $banner->name }}</span>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">{{ __('Edit Banner') }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $banner->name }}</p>
        </div>
        <form action="{{ route('admin.banners.destroy', $banner) }}"
              method="POST"
              onsubmit="return confirm('{{ __('Are you sure you want to delete this banner?') }}')">
            @csrf
            @method('DELETE')
            <x-admin.button type="submit" variant="outline-danger" icon="fa-trash">
                {{ __('Delete') }}
            </x-admin.button>
        </form>
    </div>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card :title="__('Basic Information')">
                    <div class="space-y-4">
                        <x-admin.form-input
                            name="name"
                            label="{{ __('Banner Name') }}"
                            :value="$banner->name"
                            required
                        />

                        <x-admin.form-select
                            name="position"
                            label="{{ __('Position') }}"
                            :options="$positions"
                            :value="$banner->position"
                            required
                        />

                        <x-admin.form-translatable-input
                            name="title"
                            label="{{ __('Title') }}"
                            :value="$banner->getTranslations('title')"
                            placeholder="{{ __('Banner title (optional)') }}"
                        />

                        <x-admin.form-translatable-input
                            name="subtitle"
                            label="{{ __('Subtitle') }}"
                            :value="$banner->getTranslations('subtitle')"
                            placeholder="{{ __('Banner subtitle (optional)') }}"
                        />

                        <x-admin.form-input
                            name="link"
                            label="{{ __('Link') }}"
                            :value="$banner->link"
                            placeholder="/category/..."
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Images')">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('Image (Desktop)') }}</label>
                            <div class="flex items-start gap-4">
                                <img src="{{ $banner->image_url }}"
                                     class="w-40 h-24 object-cover rounded-lg border border-slate-200"
                                     alt="Current image">
                                <div class="flex-1">
                                    <x-admin.form-image name="image" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('Image (Mobile)') }}</label>
                            <div class="flex items-start gap-4">
                                @if($banner->image_mobile)
                                    <div class="relative">
                                        <img src="{{ $banner->mobile_image_url }}"
                                             class="w-24 h-32 object-cover rounded-lg border border-slate-200"
                                             alt="Mobile image">
                                        <label class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-rose-600 transition-colors">
                                            <input type="checkbox" name="remove_image_mobile" value="1" class="hidden">
                                            <i class="fas fa-times text-xs"></i>
                                        </label>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <x-admin.form-image name="image_mobile" />
                                </div>
                            </div>
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <x-admin.card :title="__('Publish Settings')">
                    <div class="space-y-4">
                        <x-admin.form-toggle
                            name="is_active"
                            label="{{ __('Active') }}"
                            description="{{ __('Banner is visible on the site') }}"
                            :checked="$banner->is_active"
                        />

                        <x-admin.form-input
                            name="order"
                            type="number"
                            label="{{ __('Order') }}"
                            :value="$banner->order"
                            min="0"
                        />

                        <x-admin.form-input
                            name="starts_at"
                            type="datetime-local"
                            label="{{ __('Start Date') }}"
                            :value="$banner->starts_at?->format('Y-m-d\TH:i')"
                        />

                        <x-admin.form-input
                            name="ends_at"
                            type="datetime-local"
                            label="{{ __('End Date') }}"
                            :value="$banner->ends_at?->format('Y-m-d\TH:i')"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card :title="__('Information')">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Created') }}</span>
                            <span class="text-slate-900">{{ $banner->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">{{ __('Last Updated') }}</span>
                            <span class="text-slate-900">{{ $banner->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <x-admin.button type="submit" icon="fa-check">
                {{ __('Save Changes') }}
            </x-admin.button>
            <x-admin.button href="{{ route('admin.banners.index') }}" variant="ghost">
                {{ __('Cancel') }}
            </x-admin.button>
        </div>
    </form>
@endsection
