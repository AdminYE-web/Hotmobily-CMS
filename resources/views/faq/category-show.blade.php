@extends('layouts.product')

@section('head')

    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    >

    <title>{{ $pageTitle }}｜ホットモバイリー</title>

    <meta
        name="robots"
        content="index,follow"
    >

    <link
        rel="canonical"
        href="{{ route('faq.category.show', ['category' => $category]) }}"
    >

    @include('partials.legacy-head-products')

    <style>

        .faq-category-detail-page {
            width: 100%;

            box-sizing: border-box;

            color: #281600;
        }


        .faq-category-detail-heading {
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


        .faq-category-detail-list {
            margin: 0;

            padding: 0 20px;
        }


        .faq-category-detail-item {
            margin: 0 0 25px;
        }


        .faq-category-detail-row {
            display: flex;

            align-items: flex-start;

            width: 100%;

            font-size: 16px;

            line-height: 1.95;
        }


        .faq-category-detail-label {
            flex: 0 0 42px;

            font-size: 17px;

            font-weight: 400;
        }


        .faq-category-detail-label-question {
            color: #f00000;
        }


        .faq-category-detail-label-answer {
            color: #0000ff;
        }


        .faq-category-detail-text {
            flex: 1 1 auto;

            min-width: 0;

            color: #281600;

            overflow-wrap: anywhere;
        }


        .faq-category-detail-answer-text p {
            margin: 0 0 8px;
        }


        .faq-category-detail-answer-text p:last-child {
            margin-bottom: 0;
        }


        .faq-category-detail-answer-text img {
            max-width: 100%;

            height: auto;
        }


        .faq-category-detail-answer-text a {
            color: #1a0dab;

            text-decoration: underline;
        }


        .faq-category-detail-empty {
            padding: 0 20px;

            color: #777;

            font-size: 16px;
        }


        @media (max-width: 768px) {

            .faq-category-detail-heading {
                font-size: 19px;
            }


            .faq-category-detail-list {
                padding: 0 5px;
            }


            .faq-category-detail-row {
                font-size: 15px;
            }


            .faq-category-detail-label {
                flex-basis: 36px;

                font-size: 16px;
            }

        }

    </style>

@endsection


@section('content')

    <div class="faq-category-detail-page">

        <div class="faq-category-detail-heading">
            {{ $pageTitle }}
        </div>


        @if ($faqs->count())

            <div class="faq-category-detail-list">

                @foreach ($faqs as $faq)

                    <div
                        id="faq-{{ $loop->iteration }}"
                        class="faq-category-detail-item"
                    >

                        <div class="faq-category-detail-row">

                            <span
                                class="faq-category-detail-label faq-category-detail-label-question"
                            >
                                Q{{ $loop->iteration }}.
                            </span>

                            <div class="faq-category-detail-text">
                                {!! nl2br(e($faq->question)) !!}
                            </div>

                        </div>


                        <div class="faq-category-detail-row">

                            <span
                                class="faq-category-detail-label faq-category-detail-label-answer"
                            >
                                A{{ $loop->iteration }}.
                            </span>

                            <div class="faq-category-detail-text faq-category-detail-answer-text">
                                {!! $faq->answer !!}
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="faq-category-detail-empty">
                このカテゴリーのFAQはありません。
            </div>

        @endif

    </div>

@endsection
