@extends('layouts.product')

@section('head')
    <meta charset="UTF-8">
    @include('partials.legacy-head-products')
    <meta name="keywords" content="最新ニュース,オリジナルノベルティ,オリジナルグッズ制作,法人,個人">
    <meta name="description" content="オリジナルノベルティ制作のホットモバイリー公式ニュース一覧ページです。新商品追加や新サービスなど最新情報をお届けいたします。ご注文は法人様、個人様問わず承っております。">
    <meta name="robots" content="index,follow">
    <link href="{{ asset('css/faq_2nd.css') }}" rel="stylesheet" type="text/css" media="all">
    <title>News一覧</title>
    <style>
        #content_wrapper > h1 {
            margin: 0 0 20px;
        }

        .news-list {
            max-width: 800px;
            margin: auto;
        }

        .news-list > a {
            color: #000;
            text-decoration: none;
        }

        .news-item {
            display: flex;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px dotted #ccc;
            transition: border-color 0.7s ease, color 0.7s ease;
        }

        .news-list > a:hover .news-item {
            border-bottom: 1px solid #f25140;
            color: #f25140;
            cursor: pointer;
        }

        .news-date {
            font-weight: bold;
            white-space: nowrap;
        }

        .news-title {
            letter-spacing: 0.05em;
        }

        .news-pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .news-pagination a {
            width: 40px;
            height: 40px;
            border: 2px solid #000;
            border-radius: 50%;
            color: #000;
            line-height: 36px;
            text-align: center;
            text-decoration: none;
        }

        .news-pagination a.active {
            background-color: #000;
            color: #fff;
        }

        .news-home-link {
            margin-top: 15px;
            text-align: right;
        }

        @media (max-width: 600px) {
            .news-item {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
@endsection

@section('content')
    <h1>News一覧</h1>

    <div class="news-list">
        @foreach ($newsPage as $newsItem)
            <a href="{{ route('news.legacy.show', ['id' => $newsItem->id]) }}">
                <div class="news-item">
                    <div class="news-date">{{ $newsItem->published_at?->format('Y.m.d') }}</div>
                    <div class="news-title">{{ $newsItem->title }}</div>
                </div>
            </a>
        @endforeach

        @if ($newsPage->lastPage() > 1)
            <nav class="news-pagination" aria-label="News pages">
                @for ($page = 1; $page <= $newsPage->lastPage(); $page++)
                    <a
                        href="{{ $newsPage->url($page) }}"
                        class="{{ $newsPage->currentPage() === $page ? 'active' : '' }}"
                        @if ($newsPage->currentPage() === $page) aria-current="page" @endif
                    >{{ $page }}</a>
                @endfor

                @if ($newsPage->hasMorePages())
                    <a href="{{ $newsPage->nextPageUrl() }}" aria-label="Next page">&rarr;</a>
                @endif
            </nav>
        @endif
    </div>

    <div class="news-home-link">
        <a href="/">トップページへ</a>
    </div>
@endsection
