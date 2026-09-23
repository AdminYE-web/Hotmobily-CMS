@extends('layouts.product')

@php
    $publicHeading = trim((string) ($galleryPage->heading ?? '')) ?: $galleryPage->name;
@endphp

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow">
    <meta name="description" content="{{ strip_tags((string) ($galleryPage->description ?: $publicHeading)) }}">
    <title>{{ $publicHeading }}</title>
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="/gallery/css/gallery.css">
    <style>
        .dynamic-gallery { max-width: 1040px; margin: 0 auto; padding: 20px 15px 50px; box-sizing: border-box; }
        .dynamic-gallery * { box-sizing: border-box; }
        .dynamic-gallery h1 { margin: 0 0 10px; font-size: 28px; }
        .dynamic-gallery-description { margin: 0 0 25px; color: #555; white-space: pre-line; }
        .dynamic-gallery-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 22px; }
        .dynamic-gallery-card { border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, .06); }
        .dynamic-gallery-images { display: grid; grid-template-columns: repeat(3, 1fr); background: #f5f5f5; }
        .dynamic-gallery-images a:first-child { grid-column: 1 / -1; }
        .dynamic-gallery-images img { display: block; width: 100%; height: 110px; object-fit: contain; background: #fff; }
        .dynamic-gallery-images a:first-child img { height: 260px; }
        .dynamic-gallery-copy { padding: 14px; }
        .dynamic-gallery-tags { margin-bottom: 6px; color: #777; font-size: 12px; }
        .dynamic-gallery-customer { margin: 0; font-size: 16px; font-weight: 700; }
        .dynamic-gallery-meta { margin-top: 7px; color: #555; font-size: 13px; white-space: pre-line; }
        .dynamic-gallery-empty { padding: 45px; border: 1px dashed #bbb; text-align: center; color: #777; }
        .dynamic-gallery-pagination { margin-top: 28px; }
        @media (max-width: 820px) { .dynamic-gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 560px) { .dynamic-gallery-grid { grid-template-columns: 1fr; } .dynamic-gallery-images a:first-child img { height: 230px; } }
    </style>
@endsection

@section('content')
    <section class="dynamic-gallery">
        <h1>{{ $publicHeading }}</h1>
        @if ($galleryPage->description)
            <div class="dynamic-gallery-description">{!! $galleryPage->description !!}</div>
        @endif

        @if ($galleries->isEmpty())
            <div class="dynamic-gallery-empty">No gallery items have been published yet.</div>
        @else
            <div class="dynamic-gallery-grid">
                @foreach ($galleries as $gallery)
                    @php($images = $gallery->imageNames())
                    <article class="dynamic-gallery-card">
                        @if ($images !== [])
                            <div class="dynamic-gallery-images">
                                @foreach ($images as $image)
                                    @php($imageUrl = $gallery->imageUrl($image, $galleryPage->media_directory, (string) $galleryPage->legacy_extension))
                                    <a href="{{ $imageUrl }}" target="_blank" rel="noopener">
                                        <img src="{{ $imageUrl }}" alt="{{ $galleryPage->name }} {{ $gallery->id }}" loading="lazy" decoding="async">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        <div class="dynamic-gallery-copy">
                            @if ($gallery->arr_txt1)<div class="dynamic-gallery-tags">{{ $gallery->arr_txt1 }}</div>@endif
                            @if ($gallery->safeWebsiteUrl())
                                <p class="dynamic-gallery-customer"><a href="{{ $gallery->safeWebsiteUrl() }}" target="_blank" rel="noopener nofollow">{{ $gallery->arr_txt2 ?: $gallery->safeWebsiteUrl() }}</a></p>
                            @elseif ($gallery->arr_txt2)
                                <p class="dynamic-gallery-customer">{{ $gallery->arr_txt2 }}</p>
                            @endif
                            @if ($gallery->arr_txt3 || $gallery->arr_txt4)
                                <div class="dynamic-gallery-meta">{{ collect([$gallery->arr_txt3, $gallery->arr_txt4])->filter()->implode("\n") }}</div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
            @if ($galleries->hasPages())
                <div class="dynamic-gallery-pagination">{{ $galleries->links() }}</div>
            @endif
        @endif
    </section>
@endsection
