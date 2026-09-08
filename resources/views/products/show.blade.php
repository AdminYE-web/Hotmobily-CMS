@extends('layouts.product')


@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>{{ $product->name }}</title>

    <meta name="robots" content="index,follow">

    <link rel="canonical" href="{{ url('/products/' . $product->slug) }}">


    {{--
    The storefront shell (header, navigation, sidebar and footer) is the
    legacy product shell. Load its base assets before the CMS block styles so
    the dynamic page has the same dimensions and responsive behaviour as the
    migrated product pages.
--}}
    @include('partials.legacy-head-products')


    @if ($product->slug === 'rubberstrap')
        <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
            onload="this.onload=null;this.rel='stylesheet'">

        <link rel="stylesheet" href="/products/css/product_group.css?v=1.14" type="text/css">

        <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163" type="text/css">

        <link rel="stylesheet" href="/products/css/box.css" type="text/css">

        <link rel="stylesheet" href="/css/modal.css?v=1.01" type="text/css">

        <link rel="stylesheet" href="/products/css/calendar.css?v=2" type="text/css">

        <link rel="stylesheet" href="/products/css/scroll.css" type="text/css">

        <link rel="stylesheet" href="/css/rubber.css?v=1.06" type="text/css">
    @endif


    <style>
        /* ============================================================
           Product CMS
        ============================================================ */
        .store-gallery {
            margin-bottom: 15px;
        }

        .product-cms-page {
            width: 100%;

            color: #281600;

            font-size: 13.6px;
            letter-spacing: .05em;
        }


        .product-layout-container {
            width: 100%;
            max-width: 1200px;

            margin: 0 auto;
        }


        .product-layout-container-after-order {
            margin-top: 25px;
        }


        .product-layout-row {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: flex-start;

            width: calc(100% + 16px);

            /* margin: 0 -8px 15px; */
        }


        .product-layout-row:last-child {
            margin-bottom: 0;
        }


        .product-layout-column {
            box-sizing: border-box !important;

            flex:
                0 0 var(--product-column-width) !important;

            width:
                var(--product-column-width) !important;

            max-width:
                var(--product-column-width) !important;

            min-width: 0;

            padding-left: 8px;
            padding-right: 8px;
        }


        .product-layout-column-inner {
            box-sizing: border-box;

            width: 100%;
            min-width: 0;
        }


        .product-layout-column-inner>* {
            max-width: 100%;
        }


        /* ============================================================
           Block
        ============================================================ */

        html {
            scroll-behavior: smooth;
        }


        .store-product-block {
            width: 100%;
            scroll-margin-top: 80px;
        }


        /* .store-product-block + .store-product-block {
            margin-top: 15px;
        } */


        .store-product-position {
            display: flex;

            width: 100%;
        }


        .store-product-inner {
            max-width: 100%;
        }


        /* ============================================================
           Product Header
        ============================================================ */

        .store-product-header {
            margin-bottom: 15px;
        }


        .store-product-title {
            margin:
                0 0 6px;

            color: #000;

            font-size: 22px;
            line-height: 1.4;

            text-align: left;
        }


        .store-product-meta {
            display: flex;
            align-items: center;
            flex-direction: row;
            justify-content: flex-end;

            gap: 5px;

            margin-top: 10px;
            margin-bottom: 20px;

            font-size: 13px;
        }


        .store-product-meta p {
            margin: 0;
        }


        .store-product-meta a,
        .store-product-meta img {
            display: block;
        }


        .store-product-meta img {
            width: 20px;
            height: 20px;
        }


        /* ============================================================
           Product Gallery
        ============================================================ */

        .store-gallery {
            width: 100%;
        }


        .store-gallery-main {
            position: relative;

            width: 100%;

            overflow: hidden;

            background: #fafafa;

            border-radius: 8px;

            cursor: zoom-in;
        }


        .store-gallery-main img {
            display: block;

            width: 100%;
            height: auto;

            object-fit: contain;
        }


        .store-gallery-thumbnails {
            display: grid;

            grid-template-columns:
                repeat(2,
                    minmax(0, 1fr));

            gap: 8px;

            margin-top: 10px;
        }


        .store-gallery-thumb {
            width: 100%;

            padding: 0;

            overflow: hidden;

            background: #fff;

            border: 2px solid #eee;
            border-radius: 6px;

            cursor: pointer;

            opacity: .65;

            transition: .2s;
        }


        .store-gallery-thumb img {
            display: block;

            width: 100%;

            aspect-ratio: 1 / 1;

            object-fit: cover;
        }


        .store-gallery-thumb.is-active {
            border-color: #e67e22;

            opacity: 1;
        }


        /* ============================================================
           Gallery Modal
        ============================================================ */

        .store-gallery-modal {
            position: fixed;

            inset: 0;

            z-index: 99999;

            display: none;
            justify-content: center;
            align-items: center;

            padding: 30px;

            background:
                rgba(0,
                    0,
                    0,
                    .88);
        }


        .store-gallery-modal.is-open {
            display: flex;
        }


        .store-gallery-modal img {
            display: block;

            max-width: 90vw;
            max-height: 90vh;

            object-fit: contain;
        }


        .store-gallery-modal-close {
            position: absolute;

            top: 15px;
            right: 20px;

            color: #fff;

            font-size: 40px;
            line-height: 1;

            cursor: pointer;
        }


        /* ============================================================
           Product Details
        ============================================================ */

        .store-product-details {
            width: 100%;
        }


        .store-price-box {
            margin-bottom: 3px;

            padding: 5px;

            background: #efefef;
        }


        .store-price-box p {
            margin: 0;

            font-size: 20px;
        }


        .store-price-label {
            font-weight: 700;
        }


        .store-product-note {
            margin-top: 8px;

            font-size: 12px;
            line-height: 1.6;
        }


        .store-highlight-title {
            margin:
                18px 0 15px;

            color: #f59420;

            font-size: 19px;
            line-height: 1.5;
        }


        /* ============================================================
           Heading / Text
        ============================================================ */

        .store-heading {
            margin:
                15px 0 10px;

            color: #eb8018;

            font-size: 19px;
        }


        .store-rich-text {
            font-size: 16px;
            line-height: 1.7;

            white-space: normal;
        }


        .store-rich-text-small {
            font-size: 12px;
            line-height: 1.4;
        }


        /* ============================================================
           Image
        ============================================================ */

        .store-image {
            width: 100%;
        }


        .store-image img {
            display: block;

            max-width: 100%;
            height: auto;
        }


        /* ============================================================
           Button
        ============================================================ */

        .store-button {
            box-sizing: border-box;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            width: 100%;
            min-height: 55px;

            padding: 0 24px;

            background: #ff9900;

            color: #fff !important;

            border-radius: 4px;

            font-size: 16px;
            font-weight: 700;

            text-decoration: none !important;
        }


        .store-button-icon {
            flex: 0 0 auto;

            width: 24px;
            height: 24px;

            fill: currentColor;
        }


        /* ============================================================
           Text Link
        ============================================================ */

        .store-text-link {
            color: #111 !important;

            text-decoration: underline !important;
        }


        /* ============================================================
           Info Card
        ============================================================ */

        .store-info-card {
            margin-bottom: 15px;
        }


        .store-info-card-title {
            margin:
                0 0 10px;

            padding-left: 10px;

            font-size: 16px;
        }


        .store-info-card-image {
            display: block;

            margin-bottom: 10px;
        }


        .store-info-card-image img {
            display: block;

            width: 100%;
            height: auto;

            border-radius: 4px;
        }


        .store-info-card-description {
            margin-bottom: 8px;

            font-size: 16px;
            line-height: 1.6;
        }


        .store-info-card-link {
            text-align: right;
        }


        .store-info-card-link a {
            color: #000 !important;

            text-decoration: underline !important;
        }


        /* ============================================================
           Accordion
        ============================================================ */

        .store-accordion {
            width: 100%;

            margin-bottom: 15px;

            background: #fff;

            border-bottom: 1px solid #e5e5e5;
        }


        .store-accordion-input {
            display: none;
        }


        .store-accordion-summary {
            position: relative;

            display: flex;
            justify-content: flex-start;
            align-items: center;

            padding: 15px;

            cursor: pointer;

            font-size: 19px;
            font-weight: 700;
        }


        .store-accordion-arrow {
            position: absolute;
            right: 20px;

            flex-shrink: 0;

            width: 10px;
            height: 10px;

            border-right: 2px solid #333;
            border-bottom: 2px solid #333;

            transform:
                rotate(45deg);

            transition:
                transform .3s;
        }


        .store-accordion-input:checked~.store-accordion-summary .store-accordion-arrow {
            transform:
                rotate(-135deg);
        }


        .store-accordion-content {
            max-height: 0;

            overflow: hidden;

            padding:
                0 10px 0;

            transition:
                max-height .5s cubic-bezier(0,
                    1,
                    0,
                    1),
                padding .3s;
        }


        .store-accordion-input:checked~.store-accordion-content {
            max-height: 2000px;

            padding:
                20px 10px 10px;
        }


        /* ============================================================
           Custom Table
        ============================================================ */

        .store-table-scroll {
            width: 100%;

            overflow-x: auto;

            -webkit-overflow-scrolling: touch;
        }


        .store-custom-table {
            width: 100%;
            min-width: 500px;

            border-collapse: collapse;

            table-layout: auto;

            margin: 0;

            font-size: .95rem;
            line-height: normal;
        }


        .store-custom-table-title {
            margin: 0 0 10px;

            font-size: 16px;
            font-weight: 500;
        }


        .store-custom-table td {
            min-width: 0;

            padding: 10px 12px;

            border: 1px solid #ccc;

            text-align: center;
            vertical-align: middle;

            white-space: normal;
            overflow-wrap: normal;
            word-break: normal;
        }


        .store-custom-table tbody tr:hover {
            background-color: #f9f9f9;
        }


        /* ============================================================
           Shipping Schedule
        ============================================================ */

        .store-shipping-schedule {
            width: 100%;
        }


        .store-shipping-title {
            margin-bottom: 10px;
        }


        .store-shipping-intro {
            margin-bottom: 12px;

            line-height: 1.6;
        }


        .store-shipping-heading {
            display: flex;
            align-items: center;
            width: 100%;
            margin: 0;
        }


        .store-shipping-delivery {
            display: inline-block;
            width: auto;
            min-width: 0;
            padding: 0 5px 5px 0;
            text-align: left;
            font-size: 22px;
        }


        .store-shipping-delivery:first-child {
            flex: 0 0 220px;
            box-sizing: border-box;
        }


        .store-shipping-delivery:last-child {
            flex: 1 1 auto;
            text-align: left;
        }


        .store-shipping-badge {
            display: inline-block;
            padding: 5px;
            border-radius: 7px;
            font-weight: 700;
            text-align: center;
        }


        .store-shipping-delivery .store-shipping-badge {
            display: grid;
            width: 100%;
            box-sizing: border-box;
            padding: 8px 10px;
            font-size: 18px;
            line-height: 1.25;
        }


        .store-shipping-days {
            display: block;
            padding: 2px 5px;
            font-size: 22px;
            line-height: 1.3;
            text-align: left;
        }


        .store-theme-blue {
            background: #a9e2f6;
            color: #000;
        }


        .store-theme-pink {
            background: #ff93ff;
            color: #a428a5;
        }


        .store-theme-cyan {
            background: #66fffe;
            color: #000;
        }


        .store-theme-orange {
            background: #ffd3a3;

            color: #a85000;
        }


        .store-theme-gray {
            background: #e5e5e5;

            color: #444;
        }


        .store-shipping-table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 0;
            border-collapse: collapse;
            border: 1px solid #333;
            font-weight: 700;
        }


        .store-shipping-table td,
        .store-shipping-table th {
            padding: 2px 5px;

            border: 1px solid #333;

            text-align: center;
        }


        .store-shipping-table th {
            background: #d1e3f0;
        }


        .store-shipping-message-row td {
            background: #fff;
        }


        .store-shipping-label-row th,
        .store-shipping-date-row td {
            width: 50%;
            border-top: 1px solid #333;
            border-right: 0;
            border-bottom: 1px solid #333;
            border-left: 0;
        }


        .store-shipping-label-row th:first-child,
        .store-shipping-date-row td:first-child {
            border-right: 1px dotted #333;
        }


        .store-shipping-label-row th:first-child,
        .store-shipping-date-row td:first-child {
            background: #b5deff;
            color: #000;
        }


        .store-shipping-label-row th:nth-child(2),
        .store-shipping-date-row td:nth-child(2) {
            background: #ffcccc;
            color: #000;
        }


        .store-shipping-date-row td {
            padding-top: 4px;
            padding-bottom: 4px;
            font-size: 22px;
            letter-spacing: -1px;
        }


        .store-shipping-item-pink .store-shipping-days {
            color: #e60012;
        }


        .store-shipping-item-blue .store-shipping-days {
            color: #006ab1;
        }


        .store-shipping-item-cyan .store-shipping-days {
            color: #004140;
        }


        .store-shipping-item-orange .store-shipping-days {
            color: #a85000;
        }


        .store-shipping-item + .store-shipping-item {
            margin-top: 13px;
        }


        .store-shipping-footer {
            margin-top: 10px;
            font-size: 12px;
            line-height: 1.6;
            text-align: right;
            white-space: pre-line;
        }


        .store-shipping-group-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }


        @media (max-width: 576px) {
            .store-shipping-delivery {
                width: 50%;
                padding: 0;
                box-sizing: border-box;
            }


            .store-shipping-delivery:first-child,
            .store-shipping-delivery:last-child {
                flex: 0 0 50%;
            }


            .store-shipping-delivery .store-shipping-badge {
                padding: 4px 10px 1px;
                font-size: 5vw;
            }


            .store-shipping-days {
                font-size: 5vw;
            }


            .store-shipping-table td,
            .store-shipping-table th {
                padding: 2px 5px;
            }


            .store-shipping-date-row td {
                padding-top: 4px;
                padding-bottom: 4px;
                font-size: 5vw;
            }
        }


        /* ============================================================
           Template Button
        ============================================================ */

        .store-template-button {
            display: block;

            width: 80%;

            margin:
                15px auto;

            padding: 10px 20px;

            background: #f79647;

            color: #000 !important;

            border-radius: 6px;

            font-weight: 700;

            text-align: center;

            text-decoration: underline !important;
        }


        /* ============================================================
           Divider / Spacer
        ============================================================ */

        .store-divider {
            margin:
                20px 0;

            border: 0;
            border-top: 1px solid #ddd;
        }


        /* ============================================================
           Mobile
        ============================================================ */

        @media (max-width: 768px) {

            /* Keep the legacy product shell and CMS rows inside the mobile viewport. */
            body#top {
                overflow-x: hidden;
            }


            #wrapper,
            #content_wrapper,
            .product-layout-container {
                width: 100%;
                max-width: 100%;
                box-sizing: border-box;
            }


            .product-layout-row {
                flex-wrap: wrap !important;
                width: 100%;
                margin-left: 0;
                margin-right: 0;
            }


            .product-layout-column {
                flex:
                    0 0 100% !important;

                width:
                    100% !important;

                max-width:
                    100% !important;
            }


            .store-product-inner {
                width:
                    100% !important;
            }


            .store-gallery-thumbnails {
                grid-template-columns:
                    repeat(2,
                        minmax(0,
                            1fr));
            }


            .store-product-title {
                font-size: 19px;
            }


            .product-cms-page {
                font-size: 3.47vw;
                line-height: 1.53;
            }


            .store-template-button {
                width: 100%;
            }

            @media (max-width: 768px) {
                .store-template-button {
                    width: 85%;
                }
            }

        }

        /* ============================================================
           OptionCardGrid / Plan Section
        ============================================================ */
        .store-option-card-grid {
            margin-bottom: 30px;
        }

        .product-d_feature_title {
            font-size: 16px;
            display: block;
            width: 100%;
            border-bottom: 1px solid #d2d2d2;
            padding: 0 0 15px !important;
            margin: 20px 0 20px !important;
            color: #f58904;
            font-weight: 700;
        }

        .tab-container {
            width: 100%;
            max-width: 1200px;
            margin: auto;
        }

        .tab-menu {
            display: flex;
            border-bottom: 1px solid #ddd;
        }

        .tab-link {
            flex: 1;
            padding: 14px 20px;
            border: none;
            background: #faf7f5;
            cursor: pointer;
            font-weight: 700;
            color: #e67e22;
            white-space: nowrap;
            border-right: 1px solid #ddd;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
            transition: all .2s;
            text-align: center;
        }

        .tab-link:first-child {
            border-left: 1px solid #ddd;
        }

        .tab-link.active {
            background: #fff;
            border-top: 4px solid #e67e22;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            color: #e67e22;
            border-bottom: 1px solid #fff;
            margin-bottom: -1px;
        }

        .tab-content {
            display: none;
            padding: 20px 0 0 !important;
            background: #fff !important;
        }

        .tab-content.active {
            display: block;
        }

        .grid-layout {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .itemz {
            flex: 1 1 calc(50% - 20px);
            min-width: 250px;
        }

        .itemz img {
            width: 100%;
            height: auto;
            border-radius: 4px;
            display: block;
        }

        .option-parts-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .mt-10-part-4 {
            flex: 0 0 25%;
            max-width: 25%;
            padding: 10px;
            text-align: center;
            box-sizing: border-box;
        }

        .mt-10-part-4 img.picpro {
            max-width: 160px;
            width: 100%;
            height: auto;
            border: 1px solid #eee;
            border-radius: 4px;
            background: #fafafa;
            transition: transform .2s;
        }

        .mt-10-part-4 img.picpro:hover {
            transform: scale(1.04);
        }

        .part-price {
            font-weight: 700;
            color: #333;
            margin: 6px 0 2px;
            font-size: 14px;
        }

        .part-zoom {
            font-size: 10px;
            color: #666 !important;
            display: inline-block;
            text-decoration: none;
        }

        .part_link {
            width: 100%;
            margin-top: 20px;
            padding: 0 10px;
            text-align: center;
        }

        .part_link img {
            max-width: 570px;
            width: 100%;
            height: auto;
            border-radius: 6px;
        }

        .option-more-link {
            font-size: 13px;
            font-weight: 700;
            color: #000;
            text-decoration: underline;
        }

        .option-more-link:hover {
            color: #e67e22;
        }

        @media (max-width: 768px) {
            .store-custom-table {
                font-size: .85rem;
            }

            .store-custom-table td {
                padding: 8px;
            }

            .mt-10-part-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .tab-link {
                padding: 10px 8px;
                font-size: 12px;
            }

            .itemz {
                flex: 1 1 100%;
            }
        }
    </style>
@endsection


@section('content')
    <div class="product-cms-page" data-product-slug="{{ $product->slug }}">

        @php
            $layoutRows = is_array($layout['rows'] ?? null) ? $layout['rows'] : [];

            $beforeOrderRows = array_values(array_filter(
                $layoutRows,
                fn($row) => ($row['region'] ?? 'before_order') !== 'after_order'
            ));

            $afterOrderRows = array_values(array_filter(
                $layoutRows,
                fn($row) => ($row['region'] ?? 'before_order') === 'after_order'
            ));
        @endphp

        <div class="product-layout-container">
            @include('products.partials.layout-rows', ['rows' => $beforeOrderRows])

        </div>

        @if ($product->slug === 'rubberstrap')
            @include('products.partials.order-form')
        @endif

        @if (count($afterOrderRows))
            <div class="product-layout-container product-layout-container-after-order">
                @include('products.partials.layout-rows', ['rows' => $afterOrderRows])
            </div>
        @endif

    </div>
@endsection


@push('scripts')
    @if ($product->slug === 'rubberstrap')
        <script type="text/javascript" src="/js/_setToInput_2026.js?v=1.01"></script>
        <script type="text/javascript" src="/js/validation_new.js?v=1.11"></script>
        <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.17"></script>
        <script type="text/javascript" src="/products/js/date.js"></script>
        <script type="text/javascript" src="/js/pdf_rubber-campaign.js"></script>
        <script type="text/javascript" src="/js/common.js?v=1.02"></script>

        <script>
            /* The dynamic URL does not end in /rubberstrap/, so keep the
             * legacy attachment lookup on its Laravel endpoint. */
            window.getPartData = function(value) {
                if (!window.jQuery) return;

                window.jQuery.get(
                    @json(route('products.rubberstrap.part')),
                    { c: 'passed' },
                    function(data) {
                        var parts = typeof data === 'string' ? JSON.parse(data) : data;

                        window.parts_obj = (parts || []).find(function(part) {
                            return part.part_name === value;
                        });

                        if (window.parts_obj && typeof window.setToInput === 'function') {
                            window.setToInput();
                        }
                    }
                );
            };
        </script>
    @endif

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                /*
                |--------------------------------------------------------------------------
                | Product Gallery
                |--------------------------------------------------------------------------
                */

                document
                    .querySelectorAll(
                        '[data-store-gallery]'
                    )
                    .forEach(
                        function(gallery) {

                            const main =
                                gallery.querySelector(
                                    '[data-gallery-main]'
                                );


                            const modal =
                                gallery.querySelector(
                                    '[data-gallery-modal]'
                                );


                            const modalImage =
                                gallery.querySelector(
                                    '[data-gallery-modal-image]'
                                );


                            const close =
                                gallery.querySelector(
                                    '[data-gallery-modal-close]'
                                );


                            const thumbs =
                                Array.from(
                                    gallery.querySelectorAll(
                                        '[data-gallery-thumb]'
                                    )
                                );


                            let currentIndex = 0;
                            let autoTimer = null;


                            function activateThumb(index) {

                                if (!thumbs.length || !main) return;

                                currentIndex = index;

                                const src = thumbs[index].dataset.gallerySrc;

                                if (src) main.src = src;

                                thumbs.forEach(function(item) {
                                    item.classList.remove('is-active');
                                });

                                thumbs[index].classList.add('is-active');

                            }


                            function startAutoSlide() {

                                if (thumbs.length <= 1) return;

                                autoTimer = setInterval(function() {

                                    activateThumb(
                                        (currentIndex + 1) % thumbs.length
                                    );

                                }, 4000);

                            }


                            function stopAutoSlide() {

                                clearInterval(autoTimer);
                                autoTimer = null;

                            }


                            function restartAutoSlide() {

                                stopAutoSlide();
                                startAutoSlide();

                            }


                            thumbs.forEach(
                                function(thumb, index) {

                                    thumb.addEventListener(
                                        'click',
                                        function() {

                                            activateThumb(index);
                                            restartAutoSlide();

                                        }
                                    );

                                }
                            );


                            main
                                ?.addEventListener(
                                    'click',
                                    function() {

                                        if (
                                            !modal ||
                                            !modalImage
                                        ) {

                                            return;

                                        }


                                        modalImage.src =
                                            main.src;


                                        modal
                                            .classList
                                            .add(
                                                'is-open'
                                            );


                                        document
                                            .body
                                            .style
                                            .overflow =
                                            'hidden';


                                        stopAutoSlide();

                                    }
                                );


                            function closeModal() {
                                modal
                                    ?.classList
                                    .remove(
                                        'is-open'
                                    );


                                document
                                    .body
                                    .style
                                    .overflow =
                                    '';


                                restartAutoSlide();
                            }


                            close
                                ?.addEventListener(
                                    'click',
                                    closeModal
                                );


                            modal
                                ?.addEventListener(
                                    'click',
                                    function(event) {

                                        if (
                                            event.target ===
                                            modal
                                        ) {

                                            closeModal();

                                        }

                                    }
                                );


                            // Start auto-slideshow
                            startAutoSlide();

                        }
                    );


                document
                    .addEventListener(
                        'keydown',
                        function(event) {

                            if (
                                event.key !==
                                'Escape'
                            ) {

                                return;

                            }


                            document
                                .querySelectorAll(
                                    '.store-gallery-modal.is-open'
                                )
                                .forEach(
                                    function(modal) {

                                        modal
                                            .classList
                                            .remove(
                                                'is-open'
                                            );

                                    }
                                );


                            document
                                .body
                                .style
                                .overflow =
                                '';

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | Shipping Calendar
                |--------------------------------------------------------------------------
                */

                const shippingTargets =
                    document.querySelectorAll(
                        '[data-shipping-date-days]'
                    );


                const shippingStartTargets =
                    document.querySelectorAll(
                        '[data-shipping-start-time]'
                    );


                if (
                    shippingTargets.length ||
                    shippingStartTargets.length
                ) {

                    loadShippingCalendar();

                }


                async function loadShippingCalendar() {
                    try {

                        const today =
                            getTokyoDateKey();


                        const to =
                            addDays(
                                today,
                                550
                            );


                        const response =
                            await fetch(
                                `/api/v1/holidays?from=${
                            encodeURIComponent(
                                today
                            )
                        }&to=${
                            encodeURIComponent(
                                to
                            )
                        }&calendar_type=normal`, {
                                    headers: {
                                        'Accept': 'application/json',
                                    },
                                }
                            );


                        const result =
                            await response.json();


                        if (
                            !response.ok
                        ) {

                            throw result;

                        }


                        const holidays =
                            extractHolidays(
                                result
                            );


                        const holidayMap =
                            new Set();


                        holidays.forEach(
                            function(holiday) {

                                const type =
                                    String(
                                        holiday.holiday_type ??
                                        holiday.type ??
                                        ''
                                    );


                                const date =
                                    String(
                                        holiday.holiday_date ??
                                        holiday.date ??
                                        ''
                                    )
                                    .slice(
                                        0,
                                        10
                                    );


                                if (
                                    date && [
                                        'type1',
                                        'type2',
                                        'type3',
                                    ]
                                    .includes(
                                        type
                                    )
                                ) {

                                    holidayMap.add(
                                        date
                                    );

                                }

                            }
                        );


                        shippingTargets
                            .forEach(
                                function(element) {

                                    const days =
                                        Number(
                                            element.dataset
                                            .shippingDateDays ??
                                            0
                                        );


                                    const date =
                                        calculateShippingDate(

                                            today,

                                            days,

                                            holidayMap

                                        );


                                    element.textContent =
                                        formatJapaneseDate(
                                            date
                                        );

                                }
                            );


                        const startDateText =
                            formatJapaneseDateTime();


                        shippingStartTargets
                            .forEach(
                                function(element) {

                                    element.textContent =
                                        startDateText;

                                }
                            );

                    } catch (error) {

                        console.error(
                            'Shipping calendar error:',
                            error
                        );


                        shippingTargets
                            .forEach(
                                function(element) {

                                    element.textContent =
                                        '-';

                                }
                            );

                    }
                }


                function extractHolidays(
                    result
                ) {
                    if (
                        Array.isArray(
                            result
                        )
                    ) {

                        return result;

                    }


                    if (
                        Array.isArray(
                            result?.data
                        )
                    ) {

                        return result.data;

                    }


                    if (
                        Array.isArray(
                            result
                            ?.data
                            ?.holidays
                        )
                    ) {

                        return result
                            .data
                            .holidays;

                    }


                    if (
                        Array.isArray(
                            result
                            ?.holidays
                        )
                    ) {

                        return result.holidays;

                    }


                    return [];
                }


                function calculateShippingDate(
                    startDate,
                    days,
                    holidayMap
                ) {
                    let date =
                        startDate;


                    let count =
                        0;


                    days =
                        Math.max(
                            0,
                            Math.floor(
                                Number(
                                    days
                                ) ||
                                0
                            )
                        );


                    while (
                        count <
                        days
                    ) {

                        date =
                            addDays(
                                date,
                                1
                            );


                        if (
                            holidayMap.has(
                                date
                            )
                        ) {

                            continue;

                        }


                        count++;

                    }


                    return date;
                }


                function getTokyoDateKey() {
                    const parts =
                        new Intl
                        .DateTimeFormat(
                            'en-CA', {
                                timeZone: 'Asia/Tokyo',

                                year: 'numeric',

                                month: '2-digit',

                                day: '2-digit',
                            }
                        )
                        .formatToParts(
                            new Date()
                        );


                    const values = {};


                    parts.forEach(
                        function(part) {

                            values[
                                    part.type
                                ] =
                                part.value;

                        }
                    );


                    return (

                        values.year

                        +

                        '-'

                        +

                        values.month

                        +

                        '-'

                        +

                        values.day

                    );
                }


                function addDays(
                    dateKey,
                    amount
                ) {
                    const [
                        year,
                        month,
                        day
                    ] =
                    dateKey
                        .split('-')
                        .map(
                            Number
                        );


                    const date =
                        new Date(
                            Date.UTC(
                                year,
                                month - 1,
                                day
                            )
                        );


                    date.setUTCDate(
                        date.getUTCDate() +
                        Number(
                            amount
                        )
                    );


                    return (

                        date.getUTCFullYear()

                        +

                        '-'

                        +

                        String(
                            date.getUTCMonth() +
                            1
                        )
                        .padStart(
                            2,
                            '0'
                        )

                        +

                        '-'

                        +

                        String(
                            date.getUTCDate()
                        )
                        .padStart(
                            2,
                            '0'
                        )

                    );
                }


                function formatJapaneseDate(
                    dateKey
                ) {
                    const [
                        year,
                        month,
                        day
                    ] =
                    dateKey
                        .split('-')
                        .map(
                            Number
                        );


                    const date =
                        new Date(
                            Date.UTC(
                                year,
                                month - 1,
                                day,
                                12
                            )
                        );


                    const parts =
                        new Intl
                        .DateTimeFormat(
                            'ja-JP', {
                                timeZone: 'Asia/Tokyo',

                                month: '2-digit',

                                day: '2-digit',

                                weekday: 'short',
                            }
                        )
                        .formatToParts(
                            date
                        );


                    const values = {};


                    parts.forEach(
                        function(part) {

                            values[
                                part.type
                            ] = part.value;

                        }
                    );


                    return `${values.month}月${values.day}日(${values.weekday})`;
                }


                function formatJapaneseDateTime() {
                    const parts =
                        new Intl
                        .DateTimeFormat(
                            'ja-JP', {
                                timeZone: 'Asia/Tokyo',
                                month: '2-digit',
                                day: '2-digit',
                                weekday: 'short',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                            }
                        )
                        .formatToParts(
                            new Date()
                        );


                    const values = {};


                    parts.forEach(
                        function(part) {

                            values[
                                part.type
                            ] = part.value;

                        }
                    );


                    return `${values.month}月${values.day}日(${values.weekday}) ${values.hour}:${values.minute}`;
                }


                /*
                |--------------------------------------------------------------------------
                | Smooth Scroll to Block & Accordion Auto-Open
                |--------------------------------------------------------------------------
                */

                function navigateToBlock(targetId) {
                    if (!targetId) return;

                    const cleanId =
                        targetId.replace(/^#/, '').trim();

                    const targetEl =
                        document.getElementById(cleanId);

                    if (!targetEl) return;

                    // If target or ancestor is an accordion, ensure it is open
                    const accordion =
                        targetEl.closest('.store-accordion') ||
                        targetEl.querySelector('.store-accordion');

                    if (accordion) {
                        const input =
                            accordion.querySelector('.store-accordion-input');
                        if (input) {
                            input.checked = true;
                        }
                    }

                    const headerOffset = 80;
                    const elementPosition =
                        targetEl.getBoundingClientRect().top;
                    const offsetPosition =
                        elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: Math.max(0, offsetPosition),
                        behavior: 'smooth'
                    });
                }

                document.addEventListener('click', function(event) {
                    const link =
                        event.target.closest('a[href*="#"]');

                    if (!link) return;

                    const href =
                        link.getAttribute('href');

                    if (!href) return;

                    const hashIndex =
                        href.indexOf('#');

                    if (hashIndex === -1) return;

                    const path =
                        href.substring(0, hashIndex);
                    const hash =
                        href.substring(hashIndex + 1);

                    if (!hash) return;

                    // Check if current page
                    if (
                        path === '' ||
                        path === window.location.pathname ||
                        href.startsWith(window.location.origin + window.location.pathname + '#')
                    ) {
                        const targetEl =
                            document.getElementById(hash);

                        if (targetEl) {
                            event.preventDefault();
                            navigateToBlock(hash);
                            try {
                                history.pushState(null, '', '#' + hash);
                            } catch (e) {}
                        }
                    }
                });

                if (window.location.hash) {
                    setTimeout(function() {
                        navigateToBlock(window.location.hash);
                    }, 350);
                }

                /*
                |--------------------------------------------------------------------------
                | OptionCardGrid Tabs
                |--------------------------------------------------------------------------
                */
                document.addEventListener('click', function(e) {
                    const tabBtn =
                        e.target.closest('.tab-link[data-tab-target]');
                    if (!tabBtn) return;

                    const container =
                        tabBtn.closest('.store-option-card-grid');
                    if (!container) return;

                    const targetTabId =
                        tabBtn.getAttribute('data-tab-target');
                    if (!targetTabId) return;

                    container.querySelectorAll('.tab-link').forEach(function(b) {
                        b.classList.remove('active');
                    });
                    container.querySelectorAll('.tab-content').forEach(function(p) {
                        p.classList.remove('active');
                        p.style.display = 'none';
                    });

                    tabBtn.classList.add('active');
                    const targetPane =
                        container.querySelector('#' + targetTabId);
                    if (targetPane) {
                        targetPane.classList.add('active');
                        targetPane.style.display = 'block';
                    }
                });

            }
        );
    </script>
@endpush
