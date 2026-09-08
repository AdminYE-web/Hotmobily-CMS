@extends('layouts.product')

@section('head')

    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    >

    <title>製品ごとのFAQ一覧｜ホットモバイリー</title>

    <meta
        name="robots"
        content="index,follow"
    >

    <link
        rel="canonical"
        href="{{ url('/faq/product') }}"
    >

    @include('partials.legacy-head-products')


    <style>

        /*
        |--------------------------------------------------------------------------
        | Product FAQ
        |--------------------------------------------------------------------------
        */

        .faq-product-page {
            width: 100%;

            box-sizing: border-box;

            color: #000;
        }


        /*
        |--------------------------------------------------------------------------
        | Heading
        |--------------------------------------------------------------------------
        */

        .faq-product-heading {
            width: 100%;

            margin:
                0 0 20px;

            padding:
                6px 12px;

            box-sizing:
                border-box;

            background:
                #f5820b;

            color:
                #fff;

            font-size:
                20px;

            font-weight:
                700;

            line-height:
                1.4;
        }


        /*
        |--------------------------------------------------------------------------
        | Product List
        |--------------------------------------------------------------------------
        */

        #wrapper #content_wrapper ul.faq-product-list {
            margin: 0;

            padding:
                0 0 0 20px;

            list-style: none;
        }


        .faq-product-item {
            margin-bottom:
                20px;
        }


        .faq-product-link {
            display:
                inline-block;

            color:
                #0000ff !important;

            font-size:
                16px;

            line-height:
                1.6;

            text-decoration:
                none !important;
        }


        .faq-product-link:hover {
            text-decoration:
                underline !important;
        }


        .faq-product-question {
            display:
                inline-block;

            margin-right:
                5px;

            color:
                #0000ff;
        }


        /*
        |--------------------------------------------------------------------------
        | Empty
        |--------------------------------------------------------------------------
        */

        .faq-empty {
            padding:
                20px;

            color:
                #777;

            font-size:
                14px;
        }


        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {

            .faq-product-heading {
                font-size:
                    18px;
            }


            #wrapper #content_wrapper ul.faq-product-list {
                padding-left:
                    5px;
            }


            .faq-product-item {
                margin-bottom:
                    16px;
            }


            .faq-product-link {
                font-size:
                    15px;
            }

        }

    </style>

@endsection


@section('content')

    <div class="faq-product-page">

        {{-- Heading --}}
        <div class="faq-product-heading">
            製品ごとのFAQ一覧
        </div>


        {{-- Product List --}}
        @if ($products->count())

            <ul class="faq-product-list">

                @foreach ($products as $product)

                    <li class="faq-product-item">

                        <a
                            href="{{ route(
                                'faq.product.show',
                                $product->slug
                            ) }}"
                            class="faq-product-link"
                        >

                            <span class="faq-product-question">
                                Q.
                            </span>

                            {{ $product->question_name ?: ($product->name . 'について') }}

                        </a>

                    </li>

                @endforeach

            </ul>

        @else

            <div class="faq-empty">
                製品がありません。
            </div>

        @endif

    </div>

@endsection
