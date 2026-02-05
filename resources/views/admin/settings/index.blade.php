@extends('layouts.admin')
@section('title', 'Site Ayarları')
@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold">Site Ayarları</h2>
</div>

<!-- Group Tabs -->
<div class="flex gap-2 mb-6 flex-wrap">
    @foreach($groups as $key => $label)
        <a href="{{ route('admin.settings.index', ['group' => $key]) }}"
           class="px-4 py-2 rounded-lg {{ $activeGroup === $key ? 'bg-purple-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg p-6">
    @csrf
    <input type="hidden" name="group" value="{{ $activeGroup }}">

    <div class="space-y-6">
        @foreach($settings as $setting)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting->label }}</label>
                @if($setting->description && $setting->type !== 'select')
                    <p class="text-xs text-gray-500 mb-2">{{ $setting->description }}</p>
                @endif

                @switch($setting->type)
                    @case('textarea')
                        <textarea name="settings[{{ $setting->key }}]" rows="3"
                                  class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old("settings.{$setting->key}", $setting->value) }}</textarea>
                        @break

                    @case('boolean')
                        <label class="flex items-center gap-2">
                            <input type="hidden" name="settings[{{ $setting->key }}]" value="0">
                            <input type="checkbox" name="settings[{{ $setting->key }}]" value="1"
                                   {{ old("settings.{$setting->key}", $setting->value) ? 'checked' : '' }}
                                   class="rounded text-purple-600">
                            <span class="text-sm text-gray-600">Aktif</span>
                        </label>
                        @break

                    @case('image')
                        <div class="flex items-start gap-4">
                            @if($setting->value)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $setting->value) }}" class="w-24 h-24 object-cover rounded border">
                                    <label class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer hover:bg-red-600">
                                        <input type="checkbox" name="remove_images[{{ $setting->key }}]" value="1" class="hidden">
                                        <i class="fas fa-times text-xs"></i>
                                    </label>
                                </div>
                            @endif
                            <input type="file" name="settings[{{ $setting->key }}]" accept="image/*"
                                   class="flex-1 border rounded-lg px-4 py-2">
                        </div>
                        @break

                    @case('select')
                        <select name="settings[{{ $setting->key }}]" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                            @foreach(explode(',', $setting->description ?? '') as $option)
                                <option value="{{ trim($option) }}" {{ old("settings.{$setting->key}", $setting->value) === trim($option) ? 'selected' : '' }}>
                                    {{ ucfirst(trim($option)) }}
                                </option>
                            @endforeach
                        </select>
                        @break

                    @case('color')
                        <div class="flex items-center gap-2">
                            <input type="color" name="settings[{{ $setting->key }}]"
                                   value="{{ old("settings.{$setting->key}", $setting->value ?: '#000000') }}"
                                   class="w-12 h-10 rounded border cursor-pointer">
                            <input type="text" value="{{ old("settings.{$setting->key}", $setting->value) }}"
                                   class="flex-1 border rounded-lg px-4 py-2" readonly>
                        </div>
                        @break

                    @default
                        <input type="text" name="settings[{{ $setting->key }}]"
                               value="{{ old("settings.{$setting->key}", $setting->value) }}"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                @endswitch
            </div>
        @endforeach
    </div>

    <div class="mt-6 pt-6 border-t">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
            <i class="fas fa-save mr-2"></i>Kaydet
        </button>
    </div>
</form>
@endsection
