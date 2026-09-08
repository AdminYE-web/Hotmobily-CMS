@extends('layouts.product')

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>よくある質問（FAQ）｜ホットモバイリー</title>

    <meta name="robots" content="index,follow">

    <link rel="canonical" href="{{ url('/faq') }}">

    {{-- ใช้ CSS / Header / Navigation เดียวกับ Product --}}
    @include('partials.legacy-head-products')

    <style>
        /* ============================================================
           FAQ Page
        ============================================================ */

        .faq-page {
            width: 100%;
            box-sizing: border-box;
            color: #000;
        }

        /*
        |--------------------------------------------------------------------------
        | FAQ Header
        |--------------------------------------------------------------------------
        */

        .faq-heading {
            display: flex;
            align-items: center;

            width: 100%;
            min-height: 35px;

            margin: 0 0 25px;
            padding: 5px 12px;

            box-sizing: border-box;

            background: #f5820b;
            color: #fff;

            font-size: 20px;
            font-weight: 700;
            line-height: 1.3;
        }

        /*
        |--------------------------------------------------------------------------
        | FAQ Category Grid
        |--------------------------------------------------------------------------
        */

        .faq-category-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 25px 20px;

            width: 100%;
        }

        .faq-category-item {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            min-height: 70px;

            padding: 15px 20px;

            box-sizing: border-box;

            background: #fff;

            border: 2px solid #f5820b;

            color: #000 !important;

            font-size: 18px;
            font-weight: 700;

            text-align: center;
            text-decoration: none !important;

            box-shadow:
                0 8px 12px rgba(0, 0, 0, .08);

            transition:
                background-color .2s ease,
                color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .faq-category-item:hover {
            background: #f5820b;

            color: #fff !important;

            transform: translateY(-2px);

            box-shadow:
                0 10px 16px rgba(0, 0, 0, .13);

            text-decoration: none !important;
        }

        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        @media (max-width: 768px) {

            .faq-heading {
                margin-bottom: 15px;

                font-size: 18px;
            }

            .faq-category-grid {
                grid-template-columns: 1fr;

                gap: 15px;
            }

            .faq-category-item {
                min-height: 65px;

                padding: 12px 15px;

                font-size: 16px;
            }
        }
    </style>
@endsection


@section('content')

    <div class="faq-page">

        {{-- หัวข้อสีส้ม --}}
        <div class="faq-heading">
            オリジナルグッズ製作に関する良くある質問（FAQ）
        </div>

        {{-- FAQ Categories --}}
        <div class="faq-category-grid">

            <a
                href="{{ url('/faq/product') }}"
                class="faq-category-item"
            >
                製品につきまして
            </a>

            <a
                href="{{ url('/faq/order') }}"
                class="faq-category-item"
            >
                ご注文につきまして
            </a>

            <a
                href="{{ url('/faq/delivery') }}"
                class="faq-category-item"
            >
                納期・配送につきまして
            </a>

            <a
                href="{{ url('/faq/payment') }}"
                class="faq-category-item"
            >
                お支払いにつきまして
            </a>

        </div>

    </div>

@endsection