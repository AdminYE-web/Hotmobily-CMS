@extends('layouts.product')

@section('head')
    <meta charset="UTF-8">
    @include('partials.legacy-head-products')
    <meta name="keywords" content="{{ $newsItem->meta_keyword ?: '最新ニュース,オリジナルノベルティ,オリジナルグッズ制作,法人,個人,' }}">
    <meta name="description" content="{{ $newsItem->meta_description ?: 'オリジナルノベルティ制作のホットモバイリー公式ニュース一覧ページです。新商品追加や新サービスなど最新情報をお届けいたします。ご注文は法人様、個人様問わず承っております。' }}">
    <meta name="robots" content="index,follow">
    <link href="{{ asset('css/faq_2nd.css') }}" rel="stylesheet" type="text/css" media="all">
    <title>{{ $newsItem->meta_title ?: 'News一覧' }}</title>
    <style>
        #content_wrapper .news-detail-date {
            text-align: right;
        }

        #content_wrapper .new-text {
            margin-top: 15px;
            font-size: 16px !important;
            letter-spacing: 0.05em !important;
            line-height: 170% !important;
            font-family: IwaUDGoDspPro-Th, sans-serif !important;
        }

        li {
            font-size: 16px !important;
            letter-spacing: 0.05em !important;
            line-height: 150% !important;
            font-family: IwaUDGoDspPro-Th, sans-serif !important;
        }

        #content_wrapper .new-text h1 {
            display: none !important;
        }

        #content_wrapper .new-text figure.image {
            width: 100% !important;
            text-align: center !important;
        }

        #content_wrapper .new-text img {
            max-width: 100%;
            height: auto;
        }

        #content_wrapper .rich-text-media-embed {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
            margin: 1em 0;
        }

        #content_wrapper .rich-text-media-embed iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        #content_wrapper .new-text table {
            max-width: 100%;
            border-collapse: collapse;
        }

        #content_wrapper .new-text th,
        #content_wrapper .new-text td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        #content_wrapper .news-detail-links {
            margin-top: 15px;
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <h1>{{ $newsItem->title }}</h1>

    @if ($newsItem->published_at)
        <div class="news-detail-date">更新日 {{ $newsItem->published_at->format('Y年n月j日') }}</div>
    @endif

    <div class="new-text" id="insp">{!! $contentHtml !!}</div>

    <div class="news-detail-links">
        <a href="{{ route('news.legacy.index') }}">ニュース一覧へ</a>
    </div>

    <div class="news-detail-links">
        <a href="/">トップページへ</a>
    </div>
@endsection
