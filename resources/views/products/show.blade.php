@extends('layouts.product')


@section('head')

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>{{ $product->name }}</title>

<meta
    name="robots"
    content="index,follow"
>

<link
    rel="canonical"
    href="{{ url('/products/' . $product->slug) }}"
>


{{--
    The storefront shell (header, navigation, sidebar and footer) is the
    legacy product shell. Load its base assets before the CMS block styles so
    the dynamic page has the same dimensions and responsive behaviour as the
    migrated product pages.
--}}
@include('partials.legacy-head-products')


@if(
    $product->slug
    ===
    'rubberstrap'
)

    <link
        rel="preload"
        type="text/css"
        href="/css/homepage_hotstrap.css"
        as="style"
        onload="this.onload=null;this.rel='stylesheet'"
    >

    <link
        rel="stylesheet"
        href="/products/css/product_group.css?v=1.14"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="/products/acrylic/css/renew_products.css?v=1.163"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="/products/css/scroll.css"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="/css/rubber.css?v=1.06"
        type="text/css"
    >

@endif


<style>

/* ============================================================
   Product CMS
============================================================ */
.store-gallery{
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
        0
        0
        var(--product-column-width)
        !important;

    width:
        var(--product-column-width)
        !important;

    max-width:
        var(--product-column-width)
        !important;

    min-width: 0;

    padding-left: 8px;
    padding-right: 8px;
}


.product-layout-column-inner {
    box-sizing: border-box;

    width: 100%;
    min-width: 0;
}


.product-layout-column-inner > * {
    max-width: 100%;
}


/* ============================================================
   Block
============================================================ */

.store-product-block {
    width: 100%;
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
        0
        0
        6px;

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
        repeat(
            2,
            minmax(0, 1fr)
        );

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
        rgba(
            0,
            0,
            0,
            .88
        );
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
        18px
        0
        15px;

    color: #f59420;

    font-size: 19px;
    line-height: 1.5;
}


/* ============================================================
   Heading / Text
============================================================ */

.store-heading {
    margin:
        15px
        0
        10px;

    color: #eb8018;

    font-size: 19px;
}


.store-rich-text {
    font-size: 16px;
    line-height: 1.7;

    white-space: normal;
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
        0
        0
        10px;

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
        rotate(
            45deg
        );

    transition:
        transform
        .3s;
}


.store-accordion-input:checked
~
.store-accordion-summary
.store-accordion-arrow {
    transform:
        rotate(
            -135deg
        );
}


.store-accordion-content {
    max-height: 0;

    overflow: hidden;

    padding:
        0
        10px
        0;

    transition:
        max-height
        .5s
        cubic-bezier(
            0,
            1,
            0,
            1
        ),
        padding
        .3s;
}


.store-accordion-input:checked
~
.store-accordion-content {
    max-height: 2000px;

    padding:
        20px
        10px
        10px;
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

    border-collapse: collapse;

    table-layout: fixed;
}


.store-custom-table td {
    padding: 10px;

    border: 1px solid #ccc;

    vertical-align: middle;

    white-space: pre-line;
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
    flex-wrap: wrap;

    gap: 8px;

    margin:
        12px
        0
        8px;
}


.store-shipping-badge {
    display: inline-block;

    padding: 6px 12px;

    border-radius: 5px;

    font-weight: 700;
}


.store-theme-blue {
    background: #b9e5fa;

    color: #0875d1;
}


.store-theme-pink {
    background: #ff93ff;

    color: #9e009f;
}


.store-theme-cyan {
    background: #66fffe;

    color: #004140;
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

    margin-bottom: 15px;

    border-collapse: collapse;
}


.store-shipping-table td,
.store-shipping-table th {
    padding: 10px;

    border: 1px solid #ccc;

    text-align: center;
}


.store-shipping-table th {
    background: #d1e3f0;
}


.store-shipping-footer {
    margin-top: 10px;

    font-size: 12px;
    line-height: 1.6;

    white-space: pre-line;
}


.store-shipping-group-badges {
    display: flex;
    flex-wrap: wrap;

    gap: 8px;

    margin-bottom: 10px;
}


/* ============================================================
   Template Button
============================================================ */

.store-template-button {
    display: block;

    width: 80%;

    margin:
        15px
        auto;

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
        20px
        0;

    border: 0;
    border-top: 1px solid #ddd;
}


/* ============================================================
   Mobile
============================================================ */

@media
(
    max-width: 768px
) {

    .product-layout-row {
        flex-wrap: wrap !important;
    }


    .product-layout-column {
        flex:
            0
            0
            100%
            !important;

        max-width:
            100%
            !important;
    }


    .store-product-inner {
        width:
            100%
            !important;
    }


    .store-gallery-thumbnails {
        grid-template-columns:
            repeat(
                2,
                minmax(
                    0,
                    1fr
                )
            );
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

}

</style>

@endsection


@section('content')

<div
    class="product-cms-page"
    data-product-slug="{{ $product->slug }}"
>

    <div class="product-layout-container">

        @foreach(
            $layout['rows'] ?? []
            as $row
        )

            <div class="product-layout-row">

                @foreach(
                    $row['columns'] ?? []
                    as $column
                )

                    @php

                        $columnWidth =
                            (int)
                            (
                                $column['width']
                                ??
                                12
                            );


                        $columnWidth =
                            max(
                                1,
                                min(
                                    12,
                                    $columnWidth
                                )
                            );


                        $columnPercent =
                            (
                                $columnWidth
                                /
                                12
                            )
                            *
                            100;

                    @endphp


                    <div
                        class="product-layout-column"
                        style="
                            --product-column-width:
                            {{ $columnPercent }}%;
                        "
                    >

                        <div class="product-layout-column-inner">

                            @foreach(
                                $column['blocks'] ?? []
                                as $block
                            )

                                @include(
                                    'products.partials.block',
                                    [
                                        'block' =>
                                            $block,

                                        'contents' =>
                                            $contents,

                                        'product' =>
                                            $product,

                                        'publishedAt' =>
                                            $publishedAt,
                                    ]
                                )

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

        @endforeach

    </div>


    {{--
    |--------------------------------------------------------------------------
    | Order Form
    |--------------------------------------------------------------------------
    |
    | ยังไม่ทำรอบนี้
    |
    | ภายหลังค่อย:
    |
    | @include('products.partials.order-form')
    |
    --}}

</div>

@endsection


@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

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
                function (gallery) {

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

                        thumbs.forEach(function (item) {
                            item.classList.remove('is-active');
                        });

                        thumbs[index].classList.add('is-active');

                    }


                    function startAutoSlide() {

                        if (thumbs.length <= 1) return;

                        autoTimer = setInterval(function () {

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
                        function (thumb, index) {

                            thumb.addEventListener(
                                'click',
                                function () {

                                    activateThumb(index);
                                    restartAutoSlide();

                                }
                            );

                        }
                    );


                    main
                        ?.addEventListener(
                            'click',
                            function () {

                                if (
                                    !modal
                                    ||
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


                    function closeModal()
                    {
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
                            function (event) {

                                if (
                                    event.target
                                    ===
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
                function (event) {

                    if (
                        event.key
                        !==
                        'Escape'
                    ) {

                        return;

                    }


                    document
                        .querySelectorAll(
                            '.store-gallery-modal.is-open'
                        )
                        .forEach(
                            function (modal) {

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
            shippingTargets.length
            ||
            shippingStartTargets.length
        ) {

            loadShippingCalendar();

        }


        async function loadShippingCalendar()
        {
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
                        }&calendar_type=normal`,
                        {
                            headers: {
                                'Accept':
                                    'application/json',
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
                    function (holiday) {

                        const type =
                            String(
                                holiday.holiday_type
                                ??
                                holiday.type
                                ??
                                ''
                            );


                        const date =
                            String(
                                holiday.holiday_date
                                ??
                                holiday.date
                                ??
                                ''
                            )
                            .slice(
                                0,
                                10
                            );


                        if (
                            date
                            &&
                            [
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
                        function (element) {

                            const days =
                                Number(
                                    element.dataset
                                        .shippingDateDays
                                    ??
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


                const nowText =
                    new Intl
                        .DateTimeFormat(
                            'ja-JP',
                            {
                                timeZone:
                                    'Asia/Tokyo',

                                month:
                                    '2-digit',

                                day:
                                    '2-digit',

                                weekday:
                                    'short',

                                hour:
                                    '2-digit',

                                minute:
                                    '2-digit',

                                hour12:
                                    false,
                            }
                        )
                        .format(
                            new Date()
                        );


                shippingStartTargets
                    .forEach(
                        function (element) {

                            element.textContent =
                                nowText;

                        }
                    );

            } catch (error) {

                console.error(
                    'Shipping calendar error:',
                    error
                );


                shippingTargets
                    .forEach(
                        function (element) {

                            element.textContent =
                                '-';

                        }
                    );

            }
        }


        function extractHolidays(
            result
        )
        {
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
        )
        {
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
                        )
                        ||
                        0
                    )
                );


            while (
                count
                <
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


        function getTokyoDateKey()
        {
            const parts =
                new Intl
                    .DateTimeFormat(
                        'en-CA',
                        {
                            timeZone:
                                'Asia/Tokyo',

                            year:
                                'numeric',

                            month:
                                '2-digit',

                            day:
                                '2-digit',
                        }
                    )
                    .formatToParts(
                        new Date()
                    );


            const values =
                {};


            parts.forEach(
                function (part) {

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
        )
        {
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
                date.getUTCDate()
                +
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
                    date.getUTCMonth()
                    +
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
        )
        {
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


            return new Intl
                .DateTimeFormat(
                    'ja-JP',
                    {
                        timeZone:
                            'Asia/Tokyo',

                        month:
                            '2-digit',

                        day:
                            '2-digit',

                        weekday:
                            'short',
                    }
                )
                .format(
                    date
                );
        }

    }
);

</script>

@endpush
