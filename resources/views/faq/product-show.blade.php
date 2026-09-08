@extends('layouts.product')

@section('head')

    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    >

    @php
        $productFaqTitle = trim((string) ($productFaq?->question_name ?? ''));

        if ($productFaqTitle === '') {
            $productFaqTitle = $product->name . 'について';
        }

        $productPageUrl = trim((string) ($productFaq?->product_link ?? ''));
        $defaultProductPageUrl = route(
            'products.show',
            ['productPath' => $product->slug]
        );

        $productPageScheme = strtolower((string) parse_url(
            $productPageUrl,
            PHP_URL_SCHEME
        ));

        $isSafeProductPageUrl =
            $productPageUrl === ''
            || str_starts_with($productPageUrl, '/')
            || str_starts_with($productPageUrl, '#')
            || in_array($productPageScheme, ['http', 'https'], true);

        if (!$isSafeProductPageUrl) {
            $productPageUrl = '';
        }

        if ($productPageUrl === '') {
            $productPageUrl = $defaultProductPageUrl;
        }

        $productPageText = trim((string) ($productFaq?->product_link_text ?? ''));

        if ($productPageText === '') {
            $productPageText = $product->name . '商品ページ';
        }
    @endphp

    <title>{{ $productFaqTitle }}FAQ一覧｜ホットモバイリー</title>

    <meta
        name="robots"
        content="index,follow"
    >

    <link
        rel="canonical"
        href="{{ route(
            'faq.product.show',
            ['product' => $product->slug]
        ) }}"
    >

    @include('partials.legacy-head-products')

    <style>

        .faq-product-detail-page {
            width: 100%;

            box-sizing: border-box;

            color: #281600;
        }


        .faq-product-detail-heading {
            width: 100%;

            margin: 0 0 18px;

            padding: 3px 10px;

            box-sizing: border-box;

            background: #f5820b;

            color: #fff;

            font-size: 22px;

            font-weight: 700;

            line-height: 1.5;
        }


        .faq-product-detail-product-link {
            display: block;

            margin: 0 0 34px 15px;

            color: #1a0dab !important;

            font-size: 16px;

            line-height: 1.6;

            text-decoration: none !important;
        }


        .faq-product-detail-product-link:hover {
            text-decoration: underline !important;
        }


        .faq-product-detail-list {
            margin: 0;

            padding: 0 20px;
        }


        .faq-product-detail-item {
            margin: 0 0 25px;
        }


        .faq-product-detail-row {
            display: flex;

            align-items: flex-start;

            width: 100%;

            font-size: 16px;

            line-height: 1.95;
        }


        .faq-product-detail-label {
            flex: 0 0 42px;

            font-size: 17px;

            font-weight: 400;
        }


        .faq-product-detail-label-question {
            color: #f00000;
        }


        .faq-product-detail-label-answer {
            color: #0000ff;
        }


        .faq-product-detail-text {
            flex: 1 1 auto;

            min-width: 0;

            color: #281600;

            overflow-wrap: anywhere;
        }


        .faq-product-detail-answer-text p {
            margin: 0 0 8px;
        }


        .faq-product-detail-answer-text p:last-child {
            margin-bottom: 0;
        }


        .faq-product-detail-answer-text img {
            max-width: 100%;

            height: auto;
        }


        .faq-product-detail-answer-text a {
            color: #1a0dab;

            text-decoration: underline;
        }


        .faq-product-detail-empty {
            padding: 0 20px;

            color: #777;

            font-size: 16px;
        }


        @media (max-width: 768px) {

            .faq-product-detail-heading {
                font-size: 19px;
            }


            .faq-product-detail-product-link {
                margin-bottom: 25px;
            }


            .faq-product-detail-list {
                padding: 0 5px;
            }


            .faq-product-detail-row {
                font-size: 15px;
            }


            .faq-product-detail-label {
                flex-basis: 36px;

                font-size: 16px;
            }

        }

    </style>

@endsection


@section('content')

    <div class="faq-product-detail-page">

        <div class="faq-product-detail-heading">
            {{ $productFaqTitle }}FAQ一覧
        </div>


        <a
            href="{{ $productPageUrl }}"
            class="faq-product-detail-product-link"
        >
            {{ $productPageText }}
        </a>


        @if ($faqs->count())

            <div class="faq-product-detail-list">

                @foreach ($faqs as $faq)

                    <div
                        id="faq-{{ $loop->iteration }}"
                        class="faq-product-detail-item"
                    >

                        <div class="faq-product-detail-row">

                            <span
                                class="faq-product-detail-label faq-product-detail-label-question"
                            >
                                Q{{ $loop->iteration }}.
                            </span>

                            <div class="faq-product-detail-text">
                                {!! nl2br(e($faq->question)) !!}
                            </div>

                        </div>


                        <div class="faq-product-detail-row">

                            <span
                                class="faq-product-detail-label faq-product-detail-label-answer"
                            >
                                A{{ $loop->iteration }}.
                            </span>

                            <div class="faq-product-detail-text faq-product-detail-answer-text">
                                {!! $faq->answer !!}
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="faq-product-detail-empty">
                この商品のFAQはありません。
            </div>

        @endif

    </div>

@endsection
