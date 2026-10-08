@extends('layouts.product')

@php
    $guideHeading = trim((string) ($guideMain?->heading ?? '')) ?: 'ご利用ガイド';
    $guideDescription = $guideMain?->description;
    $guideMetaDescription = trim(strip_tags((string) ($guideDescription ?? '')))
        ?: 'オリジナル製品製作に関するご利用案内｜HOTMOBILYオリジナルグッズ';
@endphp

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="{{ $guideMetaDescription }}">
    <meta name="robots" content="index,follow">
    <title>{{ $guideHeading }} HOTMOBILYオリジナルグッズ</title>

    @include('partials.legacy-head-products')

    <link href="/css/company_2nd.css" rel="stylesheet" type="text/css" media="all">
    <link href="/products/css/product_group.css?v=1.05" rel="stylesheet" type="text/css">

    <style>
        .guide-main-page .new-text {
            font-size: 16px !important;
            letter-spacing: .05em !important;
            line-height: 150% !important;
        }

        .guide-main-page #guide .col-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .guide-main-page #guide .box {
            display: block;
            width: 32%;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: linear-gradient(to bottom left, #e6e6e6 10%, #ebefee 35%, #fefefe 100%);
            color: #000;
            text-align: center;
            text-decoration: none !important;
        }

        .guide-main-page #guide .box:hover {
            opacity: .7;
        }

        .guide-main-page #guide .inbox {
            margin: 5px;
            padding: 10px 5px;
            color: #000;
            font-weight: bold;
            line-height: 20px;
        }

        .guide-main-page #guide .inbox img {
            display: block;
            width: 63%;
            max-width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .guide-main-page #guide .inbox-title {
            margin: 10px 0;
            font-size: 16px;
        }

        .guide-main-page #guide .inbox-description {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
        }

        .guide-main-page #guide .inbox-description p {
            padding: 0;
            margin: 0;
        }

        .guide-main-page #guide .other {
            margin-top: 10px;
            padding: 10px;
            background-color: #d6edf7;
            text-align: center;
        }

        @media (max-width: 768px) {
            .guide-main-page #guide .inbox-title {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .guide-main-page #content_wrapper > p {
                padding: 5px 0;
            }

            .guide-main-page #guide .box {
                width: 49%;
            }

            .guide-main-page #guide .inbox {
                padding: 10px 0;
                font-size: 12px;
            }

            .guide-main-page #guide .inbox-title {
                padding: 0;
                font-size: 14px;
            }

            .guide-main-page #guide .inbox-description {
                font-size: 12px;
            }
        }

        @media (max-width: 320px) {
            .guide-main-page #guide .box {
                width: 90%;
                margin-right: auto;
                margin-left: auto;
                margin-bottom: 10px;
            }

            .guide-main-page #guide .inbox {
                padding: 10px 5px;
                font-size: 14px;
            }

            .guide-main-page #guide .inbox-title {
                font-size: 16px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="guide-main-page">
        <h1>{{ $guideHeading }}</h1>

        @if (filled($guideDescription))
            <div class="new-text guide-main-description">
                {!! $guideDescription !!}
            </div>
        @endif

        <div id="guide">
            <div class="col-container">
                @foreach ($guideItems as $item)
                    @php
                        $guidePage = $item->guidePage;
                        $titleColor = preg_match('/^#[0-9A-Fa-f]{6}$/', (string) ($item->title_color ?? ''))
                            ? $item->title_color
                            : '#000000';
                        $imagePath = trim((string) ($item->image_path ?? ''));
                        $imageUrl = $imagePath === ''
                            ? null
                            : (str_starts_with($imagePath, 'http://')
                                || str_starts_with($imagePath, 'https://')
                                || str_starts_with($imagePath, '/')
                                ? $imagePath
                                : \Illuminate\Support\Facades\Storage::disk('public')->url($imagePath));
                    @endphp

                    @if ($guidePage)
                        <a href="{{ route('guides.show', ['guidePath' => $guidePage->slug]) }}" class="box">
                            <div class="inbox">
                                @if ($imageUrl)
                                    <img
                                        src="{{ $imageUrl }}"
                                        alt="{{ $item->image_alt ?: $item->title }}"
                                        loading="lazy"
                                    >
                                @endif

                                @if (filled($item->title))
                                    <div class="inbox-title" style="color: {{ $titleColor }};">{{ $item->title }}</div>
                                @endif

                                @if (filled($item->description))
                                    <div class="inbox-description">{!! $item->description !!}</div>
                                @endif
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>

            <div style="clear: both;">&nbsp;</div>

            <div class="other">
                <a href="/sitepolicy/">ご利用規約</a>
                <span>　　</span>
                <a href="/tokusho.html">特定商取引について</a>
                <span>　　</span>
                <a href="/privacy/">プライバシーポリシー</a>
                <span>　　</span>
                <a href="/campaign/">過去のキャンペーン一覧</a>
            </div>
        </div>
    </div>
@endsection
