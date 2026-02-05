@extends('layouts.app')
@section('title', 'Ana Sayfa')
@section('content')

@foreach($sections as $section)
    @switch($section->type)
        @case('slider')
            @if(isset($sliders))
                <x-hero-slider :sliders="$sliders" />
            @endif
            @break

        @case('features')
            @if(isset($features))
                <x-features-bar :features="$features" :position="$section->getSetting('position', 'home')" />
            @endif
            @break

        @case('categories')
            @if(isset($data[$section->id]['categories']))
                <x-category-cards
                    :categories="$data[$section->id]['categories']"
                    :title="$section->title"
                    :subtitle="$section->subtitle"
                    :showAllLink="$data[$section->id]['showAllLink'] ?? true" />
            @endif
            @break

        @case('products')
            @if(isset($data[$section->id]['products']) && $data[$section->id]['products']->count() > 0)
                <x-product-carousel
                    :products="$data[$section->id]['products']"
                    :title="$section->title"
                    :subtitle="$section->subtitle"
                    :viewAllLink="$data[$section->id]['viewAllLink'] ?? null" />
            @endif
            @break

        @case('banner')
            @if(isset($data[$section->id]['banner']))
                <x-banner :banner="$data[$section->id]['banner']" />
            @endif
            @break

        @case('newsletter')
            <x-newsletter-section
                :title="$section->title ?? 'Bultenimize Katilın'"
                :subtitle="$section->subtitle ?? 'Yeni urunler ve kampanyalardan haberdar olun'"
                :backgroundColor="$section->getSetting('background_color', '#f5f5dc')" />
            @break
    @endswitch
@endforeach

@endsection
