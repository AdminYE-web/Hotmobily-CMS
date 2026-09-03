@extends('layouts.product')

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="ラバーストラップ,オリジナル,作成,製作,同人">
    <meta name="description"
        content="オリジナルラバーストラップが小ロット1個から短納期で製作できます。業界最速の7営業日出荷。当店だけの汚れ防止加工で汚れが簡単に落とせます。全数自社生産で激安価格を実現。同人/イベントグッズ、販促ノベルティでご利用頂いてます。">
    <meta name="robots" content="index,follow" />
    <title>オリジナルラバーストラップが小ロット1個から、短納期で製作できます。業界最速の7営業日出荷でも格安価格を実現。同人/イベントグッズ、販促ノベルティで人気</title>
    <link rel="canonical" href="https://hotmobily.jp/products/rubberstrap/">
    <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
    <link href="/products/css/box.css" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/css/modal.css?v=1.01" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/products/css/calendar.css?v=2" rel="preload" type="text/css" as="style"
        onload="this.rel='stylesheet'" />
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link href="/products/css/product_group.css?v=1.14" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163" as="style"
        onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="stylesheet" type="text/css" href="../css/scroll.css">
    <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
    <style type="text/css">
        {{ session('lang') == 'kr' ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '' }}
        {{ session('lang') == 'th' ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '' }}
    </style>
    <noscript>
        <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
        <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
        <link href="/products/acrylic/css/acrylic.css?v=1.05" rel="stylesheet" type="text/css">
    </noscript>
    <script type="text/javascript" src="/js/lazyload.min.js" defer></script>
    <style>
        .lpc,
        .new-text {
            letter-spacing: .05em !important
        }

        .prod-sched-wrapper,
        .prod-sched-wrapper * {
            box-sizing: border-box
        }

        table,
        table.prod-sched-table {
            border-collapse: collapse;
            width: 100%
        }

        .pdp-v2-thumb-grid,
        .thumbnails {
            grid-template-columns: repeat(2, 1fr)
        }

        /* body {
            font-family: IwaUDGoDspPro-Th, sans-serif !important
        } */

        :root {
            --pdp-v2-accent: #ff477e;
            --pdp-v2-slide-speed: 0.6s
        }

        .new-text {
            font-size: 16px !important;
            line-height: 150% !important
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            display: flex;
            gap: 15px;
            background: #fff
        }

        .h1-new {
            color: #000 !important;
            background: unset !important;
            margin-bottom: 5px !important;
            text-align: left !important;
            font-size: 22px !important
        }

        #est-order,
        .box-purple,
        .btnz,
        .group-container .btn-select,
        .link-text,
        .modal-content,
        .row .mt-10-part-4,
        td {
            text-align: center
        }

        #est-order {
            font-size: 25px;
            color: #000
        }

        .new-topic {
            color: #eb8018;
            font-size: 19px
        }

        .text-orange {
            color: #000
        }

        .group-container {
            display: flex;
            justify-content: space-between;
            flex-flow: row wrap;
            margin: 10px 0
        }

        .action-buttons,
        .social-sns,
        table.cld_tb {
            margin-top: 10px
        }

        .group-container .btn-select {
            width: calc(24% - 10px);
            border: 1px solid #9e9e9e;
            margin-bottom: 10px;
            padding: 10px 5px;
            cursor: pointer;
            border-radius: 3px;
            transition-duration: .3s;
            position: relative
        }

        .btn-select input[type=radio] {
            opacity: 0;
            width: 0
        }

        .group-container .btn-select.active,
        .group-container .btn-select:hover {
            border: 1px solid #fff;
            background: #f7b516;
            color: #fff
        }

        .group-container .btn-select.active .top-noted,
        .group-container .btn-select:hover .top-noted {
            background: #fff;
            border: 2px solid #1e6077;
            color: #1e6077
        }

        .group-container .btn-select:has(input[type=radio]:checked) {
            border: 1px solid #fff;
            background: #f7b516;
            color: #fff
        }

        table.tbl_price_deli.loading:not(.for_fans) tbody td:not(:first-child) {
            background: linear-gradient(to right, #eee 20%, #ddd 50%, #eee 80%);
            background-size: 500px 100px;
            animation-name: moving-gradient;
            animation-duration: 1s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
            animation-fill-mode: forwards
        }

        .product-gallery {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px
        }

        .main-image img {
            width: 100%;
            border-radius: 8px;
            cursor: zoom-in
        }

        .thumbnails {
            display: grid;
            gap: 10px
        }

        .thumbnails img {
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            opacity: .6;
            transition: opacity .3s
        }

        .thumbnails img.active,
        .thumbnails img:hover {
            opacity: 1;
            border: 1px solid #eb8018
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .btnz {
            padding: 15px;
            border: none;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            border-radius: 4px
        }

        .btn-orange {
            background-color: #cc3f44;
            font-size: 16px
        }

        .btn-dark-orange {
            background-color: #e67e22;
            font-size: 16px
        }

        .link-text {
            color: #333;
            text-decoration: underline;
            font-size: .9rem
        }

        .product-details {
            flex: 1
        }

        .price-box {
            background: #efefef;
            padding: 5px;
            margin-bottom: 2px
        }

        .price-box p {
            font-size: 20px
        }

        .promo-title {
            color: #f59420;
            font-size: 1.2rem;
            margin-bottom: 15px;
            letter-spacing: .05em
        }

        .info-card,
        .info-card h3,
        table {
            margin-bottom: 10px
        }

        .info-card h3 {
            font-size: 1rem;
            padding-left: 10px
        }

        .info-card img {
            width: 100%;
            border-radius: 4px
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000
        }

        .modal-overlay:target,
        .social-sns {
            display: flex
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            position: relative;
            max-width: 90%;
            max-height: 90%
        }

        .close-btn {
            position: absolute;
            top: -40px;
            right: 0;
            color: #fff;
            font-size: 30px;
            text-decoration: none
        }

        .fw-bold {
            font-family: IwaUDGoDspPro-Bd, sans-serif !important;
            font-weight: 700
        }

        .social-sns {
            flex-direction: row;
            justify-content: end;
            gap: 5px;
            margin-bottom: 20px
        }

        .accordion-container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #fff;
            border-bottom: 1px solid #e5e5e5
        }

        .accordion-input {
            display: none
        }

        .accordion-header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 15px;
            background-color: #fff;
            cursor: pointer;
            font-weight: 700;
            font-size: 1.2rem;
            position: relative;
            transition: background .3s
        }

        .arrow-dove,
        .icon {
            position: absolute
        }

        .icon {
            right: 20px;
            width: 20px;
            height: 20px
        }

        .icon::after,
        .icon::before {
            content: '';
            position: absolute;
            background-color: #000;
            transition: transform .3s
        }

        .icon::before {
            width: 100%;
            height: 2px;
            top: 50%;
            left: 0;
            transform: translateY(-50%)
        }

        .icon::after {
            width: 2px;
            height: 100%;
            left: 50%;
            top: 0;
            transform: translateX(-50%)
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height .5s cubic-bezier(0, 1, 0, 1), padding .3s;
            padding: 0 10px
        }

        .tab-menu,
        .table-wrapper {
            overflow-x: auto
        }

        .accordion-input:checked~.accordion-content {
            max-height: 2000px;
            padding: 20px 10px 10px
        }

        .accordion-input:checked~.accordion-header .icon::after {
            transform: translateX(-50%) rotate(90deg);
            max-height: 0;
            opacity: 0
        }

        .arrow-dove {
            flex-shrink: 0;
            width: 10px;
            height: 10px;
            border-right: 2px solid #333;
            border-bottom: 2px solid #333;
            transform: rotate(45deg);
            transition: transform .3s;
            right: 20px
        }

        .accordion-input:checked~.accordion-header .arrow-dove {
            transform: rotate(-135deg)
        }

        .plan-section,
        .prod-sched-section {
            margin-bottom: 20px
        }

        .plan-section h3 {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: #333
        }

        #date_create_sample1,
        #date_create_sample2,
        #date_create_speed_1,
        #date_create_speed_2 {
            font-size: 22px;
            font-weight: 700;
            color: red;
            letter-spacing: -1px;
            overflow: hidden
        }

        .box-purple {
            color: #a428a5;
            background: #ff93ff;
            border-radius: 6px;
            font-size: 18px;
            padding: 8px 10px;
            margin-right: 10px;
            min-width: 215px;
            height: unset
        }

        .d-inline {
            display: inline-block;
            margin-top: 13px
        }

        .bg-purple th:first-child {
            background: #ff93ff;
            color: #9e009f
        }

        .btn-a.btn-orange,
        .btn-a.btn-yellow {
            width: 80%;
            background-color: #f79647
        }

        th {
            background-color: #d1e3f0;
            padding: 10px
        }

        /* td {
            padding: 12px 10px
        } */

        .note {
            color: #000;
            line-height: 1.5;
            font-size: 11.5px !important
        }

        .prod-sched-wrapper {
            color: #000;
            max-width: 800px;
            margin: 0 auto;
            background: #fff
        }

        .prod-sched-title {
            margin: 0 0 10px;
            padding-left: 10px;
            color: #000
        }

        .prod-sched-subtitle {
            color: #666;
            font-weight: 400
        }

        .prod-sched-scroll-box {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch
        }

        table.prod-sched-table {
            font-size: .95rem;
            min-width: 500px;
            margin: 0
        }

        .prod-sched-table td,
        .prod-sched-table th {
            border: 1px solid #ccc;
            padding: 10px 12px;
            text-align: center;
            vertical-align: middle
        }

        .prod-sched-table thead th {
            background-color: #f4f4f4;
            font-weight: 700;
            color: #444
        }

        .prod-sched-label {
            background-color: #fdfdfd;
            text-align: left !important;
            font-weight: 500;
            width: 35%;
            min-width: 180px
        }

        .prod-sched-table tbody tr:hover {
            background-color: #f9f9f9
        }

        .prod-sched-info-box h3 {
            font-size: 1rem;
            margin: 0 0 10px;
            color: #222;
            font-weight: 700
        }

        .prod-sched-list {
            list-style-type: disc;
            padding-left: 20px;
            margin: 0
        }

        .prod-sched-list li {
            margin-bottom: 5px
        }

        .prod-sched-list strong {
            color: #d32f2f
        }

        .prod-sched-info-box small {
            color: #777;
            font-size: .85em
        }

        .rune{
            background-color: #f4f4f4 !important;
            font-weight: 700 !important;
            color: #444 !important;
        }

        .tab-container {
            width: 100%;
            max-width: 1200px;
            margin: auto
        }

        .tab-menu {
            display: flex;
            border-bottom: 1px solid #ddd
        }

        .tab-link {
            flex: 1;
            padding: 15px 20px;
            border: none;
            background: #faf7f5;
            cursor: pointer;
            font-weight: 700;
            color: #e67e22;
            white-space: nowrap;
            border-right: 1px solid #ddd
        }

        .tab-link.active {
            background: #fff;
            border-top: 4px solid #e67e22;
            border-left: 1px solid;
            border-right: 1px solid;
            color: #e67e22;
            border-bottom: 1px solid #fff;
            margin-bottom: -1px
        }

        .tab-content {
            display: none;
            padding: 10px 0 0 !important;
            border: none !important;
            border-top: none;
            background: #fff !important;
            font-family: IwaUDGoDspPro-Th, sans-serif !important
        }

        .tab-content.active {
            display: block;
            max-height: 2000px
        }

        .grid-layout {
            display: flex;
            flex-wrap: wrap;
            gap: 20px
        }

        .itemz {
            flex: 1 1 calc(33.333% - 20px);
            min-width: 250px
        }

        .itemz img {
            width: 100%;
            height: auto;
            border-radius: 4px
        }

        .row .mt-10-part-4 {
            min-width: 25%;
            max-width: 25%
        }

        .product-d_feature_title {
            font-size: 16px;
            display: block;
            width: 100%;
            border-bottom: 1px solid #d2d2d2;
            padding: 0 0 15px !important;
            margin: 20px 0 30px !important;
            color: #f58904
        }

        .pdp-v2-gallery-wrapper {
            width: 100%;
            max-width: 500px;
            background: #fff;
            position: relative
        }

        .pdp-v2-main-viewport {
            width: 100%;
            overflow: hidden;
            position: relative;
            background-color: #fcfcfc
        }

        #A,
        #C,
        #D,
        .pdp-v2-main-link {
            position: relative
        }

        .pdp-v2-image-strip {
            display: flex;
            width: 100%;
            transition: transform var(--pdp-v2-slide-speed) cubic-bezier(.4, 0, .2, 1)
        }

        .pdp-v2-main-link::after,
        .pdp-v2-zoom-icon {
            position: absolute;
            background-color: rgba(0, 0, 0, .4);
            transition: opacity .3s;
            pointer-events: none
        }

        .pdp-v2-zoom-icon {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            z-index: 2
        }

        .pdp-v2-zoom-icon svg {
            width: 32px;
            height: 32px;
            color: #fff
        }

        .pdp-v2-main-link:hover .pdp-v2-zoom-icon,
        .pdp-v2-main-link:hover::after {
            opacity: 1
        }

        .pdp-v2-thumb-grid {
            display: grid;
            gap: 8px;
            padding: 10px 0;
            background: #fff
        }

        .pdp-v2-thumb-item {
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            object-fit: cover;
            border: 2px solid #f0f0f0;
            transition: .3s;
            opacity: .6
        }

        .pdp-v2-modal-content,
        .pdp-v2-modal-overlay {
            transition: opacity var(--pdp-v2-fade-speed) ease-in-out;
            width: 100%
        }

        .pdp-v2-thumb-item.pdp-v2-active-state {
            border-color: #e67e22;
            opacity: 1;
            transform: scale(.98)
        }

        .pdp-v2-main-link {
            min-width: 100%;
            display: block;
            cursor: pointer
        }

        .pdp-v2-main-link::after {
            content: '';
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 1
        }

        .pdp-v2-slide-img {
            min-width: 100%;
            width: 100%;
            height: auto;
            display: block
        }

        .pdp-v2-modal-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            height: 100%;
            background-color: rgba(0, 0, 0, .9);
            align-items: center;
            justify-content: center;
            opacity: 0
        }

        .pdp-v2-modal-overlay.active {
            display: flex;
            opacity: 1
        }

        .pdp-v2-modal-container {
            position: relative;
            max-width: 90%;
            max-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .pdp-v2-modal-content {
            display: block;
            height: auto;
            max-height: 90vh;
            object-fit: contain;
            box-shadow: 0 5px 30px rgba(0, 0, 0, .5);
            opacity: 1
        }

        .pdp-v2-modal-overlay.active .pdp-v2-modal-content {
            transform: scale(1)
        }

        .pdp-v2-modal-close {
            position: absolute;
            bottom: -40px;
            right: 0;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: 700;
            cursor: pointer;
            line-height: 1
        }

        .pdp-v2-modal-next {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            z-index: 10001;
            opacity: 0;
            transition: .3s;
            filter: drop-shadow(0px 0px 8px rgba(0, 0, 0, 1))
        }

        .pdp-v2-modal-next svg {
            width: 100%;
            height: 100%;
            stroke-width: 1.5
        }

        .pdp-v2-modal-overlay:hover .pdp-v2-modal-next {
            opacity: .8
        }

        .pdp-v2-modal-next:hover {
            opacity: 1;
            transform: translateY(-50%) scale(1.1)
        }

        .thumbnail-track {
            display: flex;
            transition: transform .5s ease-in-out;
            gap: 10px
        }

        .thumbnail-track img {
            width: 80px;
            height: auto;
            cursor: pointer;
            flex-shrink: 0
        }

        a {
            text-decoration: underline !important
        }

        .fw-style {
            font-size: 18px
        }

        #B,
        #C .PC-C-Contents,
        #D .Mb-D-Contents,
        .Mb-A-Contents,
        .Mb-B-Contents {
            filter: blur(5px);
            opacity: 0;
            transform: translateY(30px);
            transition: filter 1.2s cubic-bezier(.16, 1, .3, 1), opacity 1.2s cubic-bezier(.16, 1, .3, 1), transform 1.2s cubic-bezier(.16, 1, .3, 1);
            will-change: filter, opacity, transform
        }

        .qty-inp {
            width: 25%
        }

        @media (max-width:768px) {

            .container,
            .tab-menu {
                flex-direction: column
            }

            .product-details,
            .product-gallery,
            .qty-inp,
            .tbl_price_tg p {
                width: 100%
            }

            .accordion-header,
            .prod-sched-title {
                font-size: 1rem
            }

            td,
            th {
                padding: 8px 5px;
                font-size: .8rem
            }

            .tbl_price_tg {
                display: grid
            }

            .tbl_price_tg div {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                flex-direction: row;
                align-items: center;
                align-content: center
            }

            .prod-sched-wrapper {
                padding: 10px
            }

            table.prod-sched-table {
                font-size: .85rem
            }

            .prod-sched-table td,
            .prod-sched-table th {
                padding: 8px
            }

            .tab-link {
                border-right: none;
                border-bottom: 1px solid #ddd;
                text-align: left
            }

            .itemz {
                flex: 1 1 100%
            }

            .pdp-v2-modal-next {
                right: 5px;
                width: 35px;
                height: 35px
            }

            .pdp-v2-modal-close {
                bottom: -45px
            }

            .pdp-v2-thumb-grid,
            .thumbnails {
                grid-template-columns: repeat(3, 1fr)
            }
        }

        .but3 {
            padding: 8px 0;
            border: 1px solid #b5b5b5;
            box-shadow: 0 2px 6px #b5b5b5;
            border-radius: 5px;
            background-image: linear-gradient(#f7f7f7, #dbdbdb);
            transition: .3s ease-in-out
        }

        #A {
            margin-top: 0;
            display: block;
            opacity: 1
        }
         .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
}
    </style>

    <!-- lightbox2-master -->
    <link rel="stylesheet" href="css/lightbox.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="css/lightbox.css">
    </noscript>
    <!-- /lightbox2-master -->
@endsection

@section('content')
            
            
            <div id="">
                <h1 class="h1-new">オリジナルラバーストラップ（2026年版）</h1>
                <div class="social-sns">
                    <p>シェアする</p>
                    <a href="//x.com/GoodsYe" target="_blank"><img src="/products/images/rubberstrap/v2/x-icon.webp"
                            alt="X" width="20" height="20"></a>
                    <a href="//www.facebook.com/Hotmobily_jp-%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC-171871399585893"
                        target="_blank"><img src="/products/images/rubberstrap/v2/Facebook-icon.webp" alt="Facebook"
                            width="20" height="20"></a>
                    <a href="https://www.instagram.com/hot.mobily/?hl=ja" target="_blank"><img
                            src="/products/images/rubberstrap/v2/IG_icon.webp" alt="Instagram" width="20"
                            height="20"></a>
                    <p>更新日：2026年8月3日</p>
                </div>
            </div>
            <div class="container">
                <div class="product-gallery" id="">

                    <div class="pdp-v2-main-viewport">
                        <div class="pdp-v2-image-strip" id="pdp-v2-js-strip">
                            <!-- Image 1 -->
                            <div class="pdp-v2-main-link" data-index="0">
                                <div class="pdp-v2-zoom-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        <line x1="11" y1="8" x2="11" y2="14"></line>
                                        <line x1="8" y1="11" x2="14" y2="11"></line>
                                    </svg></div>
                                <img src="/products/images/rubberstrap/v2/rubber_strap_product01.webp"
                                    alt="VTuberグッズ制作事例：ケモ耳キャラクターのラバーストラップ" fetchpriority="high" loading="eager"
                                    class="pdp-v2-slide-img" width="600" height="600">
                            </div>
                            <!-- Image 2 -->
                            <div class="pdp-v2-main-link" data-index="1">
                                <div class="pdp-v2-zoom-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        <line x1="11" y1="8" x2="11" y2="14"></line>
                                        <line x1="8" y1="11" x2="14" y2="11"></line>
                                    </svg></div>
                                <img src="/products/images/rubberstrap/v2/rubber_strap_product02.webp"
                                    alt="配信者・YouTuberのオリジナルロゴ・文字デザインを用いたラバーストラップ制作事例" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                            <!-- Image 3 -->
                            <div class="pdp-v2-main-link" data-index="2">
                                <div class="pdp-v2-zoom-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        <line x1="11" y1="8" x2="11" y2="14"></line>
                                        <line x1="8" y1="11" x2="14" y2="11"></line>
                                    </svg></div>
                                <img src="/products/images/rubberstrap/v2/rubber_strap_product03.webp"
                                    alt="パンキッシュで個性的なオリジナルキャラクターのラバーストラップ" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                            <!-- Image 4 -->
                            <div class="pdp-v2-main-link" data-index="3">
                                <div class="pdp-v2-zoom-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        <line x1="11" y1="8" x2="11" y2="14"></line>
                                        <line x1="8" y1="11" x2="14" y2="11"></line>
                                    </svg></div>
                                <img src="/products/images/rubberstrap/v2/rubber_strap_product04.webp"
                                    alt="同人イベント頒布・BOOTH販売向けキャラクターラバーストラップの制作事例" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                            <!-- Image 5 -->
                            <div class="pdp-v2-main-link" data-index="4">
                                <div class="pdp-v2-zoom-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        <line x1="11" y1="8" x2="11" y2="14"></line>
                                        <line x1="8" y1="11" x2="14" y2="11"></line>
                                    </svg></div>
                                <img src="/products/images/rubberstrap/v2/rubber_strap_product05.webp"
                                    alt="飲食店・バー向けノベルティ用オーダーメイドラバーストラップ制作事例（ロゴデザイン）" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                            <!-- Image 6 -->
                            <div class="pdp-v2-main-link" data-index="5">
                                <div class="pdp-v2-zoom-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        <line x1="11" y1="8" x2="11" y2="14"></line>
                                        <line x1="8" y1="11" x2="14" y2="11"></line>
                                    </svg></div>
                                <img src="/products/images/rubberstrap/v2/rubber_strap_product06.webp?v=1"
                                    alt="キャラクターとテキスト（文字）を一体化させたオリジナルデザインのラバーストラップ制作事例" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                        </div>
                    </div>

                    <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                        <img src="/products/images/rubberstrap/v2/rubber_strap_product01.webp"
                            alt="VTuberグッズ制作事例：ケモ耳キャラクターのラバーストラップ" class="pdp-v2-thumb-item pdp-v2-active-state" data-index="0">
                        <img src="/products/images/rubberstrap/v2/rubber_strap_product02.webp"
                            alt="配信者・YouTuberのオリジナルロゴ・文字デザインを用いたラバーストラップ制作事例" class="pdp-v2-thumb-item" data-index="1" loading="lazy">
                        <img src="/products/images/rubberstrap/v2/rubber_strap_product03.webp"
                            alt="パンキッシュで個性的なオリジナルキャラクターのラバーストラップ" class="pdp-v2-thumb-item" data-index="2" loading="lazy">
                        <img src="/products/images/rubberstrap/v2/rubber_strap_product04.webp"
                            alt="同人イベント頒布・BOOTH販売向けキャラクターラバーストラップの制作事例" class="pdp-v2-thumb-item" data-index="3" loading="lazy">
                        <img src="/products/images/rubberstrap/v2/rubber_strap_product05.webp" alt="飲食店・バー向けノベルティ用オーダーメイドラバーストラップ制作事例（ロゴデザイン）"
                            class="pdp-v2-thumb-item" data-index="4" loading="lazy">
                        <img src="/products/images/rubberstrap/v2/rubber_strap_product06.webp?v=1"
                            alt="キャラクターとテキスト（文字）を一体化させたオリジナルデザインのラバーストラップ制作事例" class="pdp-v2-thumb-item" data-index="5" loading="lazy">
                    </div>

                    <div class="action-buttons">
                        <button class="btnz btn-orange" type="button" onclick="GotoDiv(1)" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background-color: #FF9900; border-color: #FF9900; margin-top: 10px; margin-bottom: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                            </svg>
                            この商品を見積・注文する
                        </button>

                        <a href="/gallery/rubberstrap" class="new-text" style="color:black !important; margin-top: 15px; display: inline-block;">制作事例を見る</a>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="link-text new-text" onclick="GotoDiv(5)"
                            style="color: black;">商品レビューを見る</a>
                    </div>
                </div>

                <div class="product-details" id="">
                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個480円～</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">100個合計金額：</span>48,000円</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span class=""
                                id="date_create2x1"></span></p>
                    </div>

                    <div class="">
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です。</small><br>
                        <small class="note">※出荷目安は注文個数やプランによって異なります。詳しくは<a href="javascript:void(0)" class=""
                                onclick="GotoDiv(2)">こちら</a>をご確認ください。</small>
                    </div>


                    <h2 class="promo-title" style="color: #cc3f44; !important;">
                        業界最速・最安級！自社生産だからできる高品質ラバスト製作</h2>


                    <div class="info-card">
                        <h3 class="lpc">1個からラバストを作りたいなら印刷タイプ！</h3>
                        <a href="/products/printedrubberstrap_keyholder/"><img
                                src="/products/printedrubberstrap_keyholder/images/new/printed_rubber_banner01.webp" alt=""
                                width="660" height="auto" loading="lazy"></a>
                        <p class="new-text">1個からのラバスト製作なら印刷ラバーストラップ！フルカラーでデザインを印刷可能です！</p>
                        <div style="text-align:right;">
                            <a href="/products/printedrubberstrap_keyholder/" class="new-text" style="color: black;">印刷ラバーストラップはこちら</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">業界最短！７日のスピード出荷</h3>
                        <a onclick="GotoDiv(2)" href="javascript:void(0)"><img
                                src="/products/images/rubberstrap/v2/rubber_strap_shipping.webp?v=1" alt="業界最短7日出荷"
                                width="660" height="auto" loading="lazy"></a>
                        <p class="new-text">お急ぎでも安心。自社生産により、ご注文から最短7営業日での出荷を実現！</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(2)"
                                style="color: black;">納期一覧はこちら</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">直販ならではの業界最安値</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(3)"><img
                                src="/products/images/rubberstrap/v2/rubber_strap_price.webp?c=1" alt="業界最安値価格" width="660"
                                height="auto" loading="lazy"></a>
                        <p class="new-text">
                            100個48,000円（@480円）の業界最安値！中間代理店のマージンを削減した直販ならではの激安価格。10個9,900円の小ロットプランもご用意。初心者でも気軽に作成可能です。
                        </p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(3)"
                                style="color: black;">価格表はこちら</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">汚れ防止オプションあり</h3>
                        <a href="https://hotmobily.jp/faq/details/rubberstrap/q4"><img
                                src="/products/images/rubber_strap_protect_v2.webp?k=1" alt="汚れ防止加工" width="660"
                                height="auto" loading="lazy"></a>
                        <p class="new-text">ラバーストラップについた汚れを水洗いだけで落とせる！当店だけの汚れ防止加工でラバストをきれいに保てます！単価99円（税込）！</p>
                        <div style="text-align:right;">
                            <a href="https://hotmobily.jp/faq/details/rubberstrap/q4" class="new-text"
                                style="color: black;">汚れ防止加工の詳細はこちら</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">ラバーストラップ完全ガイド</h3>
                        <a href="/lp/rubber-guide.php"><img src="/products/images/rubberstrap/rubber_guide_top.webp?z=1"
                                alt="ラバーストラップガイド" width="660" height="auto" loading="lazy"></a>
                        <p class="new-text">「ラバーストラップ製作の基本を知りたい！」「より良いラバストを作りたい！」という方向けの完全ガイドをご用意しております。ぜひご確認ください。</p>
                        <div style="text-align:right;">
                            <a href="/lp/rubber-guide.php" class="new-text" style="color: black;">ラバスト完全ガイドはこちら</a>
                        </div>
                    </div>

                </div>
            </div>

            <!--Accordion Price-->
            <div id="acc-price">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="price-toggle" class="accordion-input" checked>
                        <label for="price-toggle" class="accordion-header" id="price-g">
                            <span class="fw-bold">価格・制作料金について</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">スタンダードプラン</p>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">数量</th>
                                                <th class="fw-bold">100</th>
                                                <th class="fw-bold">200</th>
                                                <th class="fw-bold">300</th>
                                                <th class="fw-bold">500</th>
                                                <th class="fw-bold">1000</th>
                                                <th class="fw-bold">3000</th>
                                                <th class="fw-bold">5000</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold"><strong>3mm厚</strong></td>
                                                <td>¥48,000<br><span>@¥480</span></td>
                                                <td>¥78,600<br><span>@¥393</span></td>
                                                <td>¥91,800<br><span>@¥306</span></td>
                                                <td>¥126,500<br><span>@¥253</span></td>
                                                <td>¥201,000<br><span>@¥201</span></td>
                                                <td>¥438,000<br><span>@¥146</span></td>
                                                <td>¥630,000<br><span>@¥126</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold"><strong>5mm厚</strong></td>
                                                <td>¥57,600<br><span>@¥576</span></td>
                                                <td>¥94,200<br><span>@¥471</span></td>
                                                <td>¥110,100<br><span>@¥367</span></td>
                                                <td>¥151,500<br><span>@¥303</span></td>
                                                <td>¥240,000<br><span>@¥240</span></td>
                                                <td>¥522,000<br><span>@¥174</span></td>
                                                <td>¥755,000<br><span>@¥151</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <small class="note">※スタンダードには表面印刷代、トレース代は含まれておりません。</small><br>
                                <small class="note">※試作込みの製作日数には、試作品配送日数として1日加算しております。</small>
                            </div>

                            <div class="plan-section">
                                <p class="new-text">プレミアムプラン</p>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">数量</th>
                                                <th class="fw-bold">100</th>
                                                <th class="fw-bold">200</th>
                                                <th class="fw-bold">300</th>
                                                <th class="fw-bold">500</th>
                                                <th class="fw-bold">1000</th>
                                                <th class="fw-bold">3000</th>
                                                <th class="fw-bold">5000</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold"><strong>3mm厚</strong></td>
                                                <td>¥66,000<br><span>@¥660</span></td>
                                                <td>¥88,000<br><span>@¥440</span></td>
                                                <td>¥120,300<br><span>@¥401</span></td>
                                                <td>¥184,000<br><span>@¥368</span></td>
                                                <td>¥282,000<br><span>@¥282</span></td>
                                                <td>¥606,000<br><span>@¥202</span></td>
                                                <td>¥770,000<br><span>@¥154</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold"><strong>5mm厚</strong></td>
                                                <td>¥72,600<br><span>@¥726</span></td>
                                                <td>¥96,800<br><span>@¥484</span></td>
                                                <td>¥132,300<br><span>@¥441</span></td>
                                                <td>¥202,000<br><span>@¥404</span></td>
                                                <td>¥310,000<br><span>@¥310</span></td>
                                                <td>¥660,000<br><span>@¥222</span></td>
                                                <td>¥845,000<br><span>@¥169</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <small class="note">※プレミアムでは、試作品、裏面印刷、トレース代金は無料です。</small><br>
                                <small class="note">※試作込みの製作日数には、試作品配送日数として1日加算しております。</small>
                            </div>

                            <div class="plan-section">
                                <p class="new-text">スタンダード（スピード発送）</p>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">数量</th>
                                                <th class="fw-bold">100</th>
                                                <th class="fw-bold">200</th>
                                                <th class="fw-bold">300</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold"><strong>3mm厚</strong></td>
                                                <td>¥54,300<br><span>@¥543</span></td>
                                                <td>¥88,400<br><span>@¥442</span></td>
                                                <td>¥101,700<br><span>@¥339</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold"><strong>5mm厚</strong></td>
                                                <td>¥65,100<br><span>@¥651</span></td>
                                                <td>¥106,000<br><span>@¥530</span></td>
                                                <td>¥122,100<br><span>@¥407</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <small class="note">※スピード発送の場合、最大ロットは300個となります。</small><br>
                                <small class="note">※裏面印刷代金、トレース代金は含まれておりません。</small>
                                <small class="note">※汚れ防止加工は、スピード発送の対象外です。</small>
                            </div>

                            <div class="plan-section">
                                <p class="new-text">各種オプション料金（税込）</p>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <tbody>
                                            <tr>
                                                <td class="rune fw-bold">汚れ防止加工</td>
                                                <td>@99円</td>
                                            </tr>
                                            <tr>
                                                <td class="rune fw-bold">裏面印刷</td>
                                                <td>@33円</td>
                                            </tr>
                                            <tr>
                                                <td class="rune fw-bold">特殊素材</td>
                                                <td>@33円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="plan-section">
                                <p class="new-text">■1個から製作可能な印刷タイプ</p>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">数量</th>
                                                <th class="fw-bold">1</th>
                                                <th class="fw-bold">10</th>
                                                <th class="fw-bold">30</th>
                                                <th class="fw-bold">50</th>
                                                <th class="fw-bold">100</th>
                                                <th class="fw-bold">300</th>
                                                <th class="fw-bold">500</th>
                                                <th class="fw-bold">1000</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold"><strong>価格</strong></td>
                                                <td>¥316<br><span>@¥316</span></td>
                                                <td>¥3,000<br><span>@300</span></td>
                                                <td>¥8,550<br><span>@¥285</span></td>
                                                <td>¥13,650<br><span>@¥273</span></td>
                                                <td>¥25,000<br><span>@¥250</span></td>
                                                <td>¥62,400<br><span>@¥208</span></td>
                                                <td>¥92,000<br><span>@¥184</span></td>
                                                <td>¥1,740,000<br><span>@¥174</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <a href="/products/printedrubberstrap_keyholder/">印刷ラバーストラップの注文フォームはこちら</a>
                            </div>

                            <div>
                                <label class="new-topic">スタンダードプラン・プレミアムプランとは？</label><br><br>

                                <p class="new-text">当店では、お客様の目的・ニーズに合わせて選べる「スタンダード」「プレミアム」の2つのプランをご用意しています！</p><br>
                                <p class="new-text">・スタンダードプラン</p>
                                <p class="new-text">満足度90％以上を維持しつつ、コストを抑えたお得なプランです。</p>
                                <p class="new-text">ノベルティや配布用などコスパを意識しつつ、良品を製作したい方はスタンダードがおすすめ。</p><br>

                                <p class="new-text">・プレミアムプラン</p>
                                <p class="new-text">海外と日本でダブル検品を行う最高品質プラン！日本の厳しい基準でわずかな色の干渉も排除し、非常に品質の高い製品をお届けします。</p>
                                <br>

                                <a href="https://hotmobily.jp/lp/rubber-guide-production.php?sec=plan" class="new-text"
                                    style="color: black;">スタンダード、プレミアムプランについて詳しくはこちら</a><br>
                                <a href="https://hotmobily.jp/products/product-difference.php?data=3" class="new-text"
                                    style="color: black;">全てのプランの詳細について詳しくはこちら</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Price-->

            <!--Accordion Shipping-->
            <br>
            <div id="acc-shipping">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="shipping-toggle" class="accordion-input" checked>
                        <label for="shipping-toggle" class="accordion-header">
                            <span class="fw-bold">出荷目安・納期について</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">オリジナルラバーストラップ製作の出荷日目安日です。出荷目安日は、現時点でご注文確定（デザイン確定、お支払い完了）の場合です。</p>

                                <div>
                                    

                                    <div class="tbl_s cl2" style="position: relative;">
                                        <div class="scroll-center">
                                            <div class="arrow"></div>
                                        </div>
                                        <table class="tbl_price_deli loading">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="2">スタンダード</th>
                                                    <th colspan="2">プレミアム</th>
                                                </tr>
                                                <tr>
                                                    <th rowspan="2">数量</th>
                                                    <th colspan="2">当店からの出荷日目安</th>
                                                    <th colspan="2">当店からの出荷日目安</th>
                                                </tr>
                                                <tr>
                                                    <th>量産のみ</th>
                                                    <th>試作込み最短</th>
                                                    <th>量産のみ</th>
                                                    <th>試作込み最短</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($units as $key => $value)
                                                    <tr>
                                                        <td>{{ $value }}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="font_s" style="text-align: right;">
                                        ※スタンダードには裏面印刷代金、トレース代金は含まれておりません。<br>
                                        ※プレミアムでは、試作品、裏面印刷、トレース代金は無料です。<br>
                                        ※試作込みの製作日数には、試作品配送日数として1日加算しております。<br><br>
                                    </div>

                                    <table class="tbl_price_deli bg-purple">
                                        <thead>
                                            <tr>
                                                <th colspan="3">スタンダード（スピード発送）</th>
                                            </tr>
                                            <tr>
                                                <td rowspan="2">数量</th>
                                                <td colspan="2">当店からの出荷日目安</th>
                                            </tr>
                                            <tr>
                                                <td>量産のみ</th>
                                                <td>試作込み最短</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>100</td>
                                                <td class="speed_deli_date"></td>
                                                <td class="speed_deli_date2"></td>
                                            </tr>
                                            <tr>
                                                <td>200</td>
                                                <td class="speed_deli_date"></td>
                                                <td class="speed_deli_date2"></td>
                                            </tr>
                                            <tr>
                                                <td>300</td>
                                                <td class="speed_deli_date"></td>
                                                <td class="speed_deli_date2"></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="font_s" style="text-align: right;">
                                        ※スピード発送の場合、最大ロットは300個となります。<br>
                                        ※裏面印刷代金、トレース代金は含まれておりません。<br>
                                        ※汚れ防止加工は、スピード発送の対象外です。<br><br>
                                    </div>
                                </div>

                                <div>
                                    <p class="new-text">
                                        本生産（通常納期10営業日後、スピード発送納期7営業日後）の場合の出荷予定日、試作品（6営業日後出荷）の場合の出荷予定日は以下です。
                                        ※本日原稿確定（最終デザイン確定・生産開始）の場合の出荷予定日です。
                                    </p>
                                    <br />
                                    <div>
                                        <!-- <h2>本生産納期</h2> -->
                                        <div style="display: flex">
                                            <div class="delivery">
                                                <span class="btn-a std-btn">通常納期</span>
                                            </div>
                                            <div class="delivery">
                                                <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                    10営業日後出荷
                                                </div>
                                            </div>
                                        </div>
                                        <table class="cld_tb">
                                            <tr class="cld_head">
                                                <td colspan="2">今、この製品を製作開始した場合の出荷日を表示中</td>
                                            </tr>
                                            <tr class="cld_r1">
                                                <td>原稿確定日</td>
                                                <td>出荷予定</td>
                                            </tr>
                                            <tr class="cld_r2">
                                                <td><span id="date_create"></span></td>
                                                <td><span id="date_create2"></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style="clear: both"></div>

                                    <div>
                                        <div style="margin-top: 13px"></div>
                                        <div style="display: flex">
                                            <div class="delivery"><span class="btn-a"
                                                    style="color: #a428a5;background: #ff93ff;">スピード納期</span></div>
                                            <!-- <span class="box-purple d-inline">スピード納期</span> -->
                                            <h2 class="red tb_02" style="padding: 2px 5px!important;margin-top: 0px;">
                                                7営業日後出荷</h2>
                                        </div>
                                        <table class="cld_tb">
                                            <tr class="cld_head">
                                                <td colspan="2">今、この製品を製作開始した場合の出荷日を表示中</td>
                                            </tr>
                                            <tr class="cld_r1">
                                                <td>原稿確定日</td>
                                                <td>出荷予定</td>
                                            </tr>
                                            <tr class="cld_r2">
                                                <td><span id="date_create_speed_1"></span></td>
                                                <td><span id="date_create_speed_2"></span></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div style="clear: both"></div>

                                    <div>
                                        <!-- <h2>試作納期</h2> -->
                                        <div style="margin-top: 13px"></div>
                                        <div style="display: flex">
                                            <div class="delivery"><span class="btn-a"
                                                    style="background: #66fffe; color: #000">試作納期</span></div>
                                            <div class="delivery">
                                                <div class="tb_06" style="color: #004140; padding: 2px 5px">6営業日後出荷
                                                </div>
                                            </div>
                                        </div>
                                        <table class="cld_tb" style="display: table">
                                            <tbody>
                                                <tr class="cld_head">
                                                    <td colspan="2">今、この製品をご注文頂いた場合の出荷予定日を表示中</td>
                                                </tr>
                                                <tr class="cld_r1">
                                                    <td>原稿確定日</td>
                                                    <td>出荷予定</td>
                                                </tr>
                                                <tr class="cld_r2">
                                                    <td><span id="date_create_sample1"></span></td>
                                                    <td><span id="date_create_sample2"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <span class="font_s" style="float: right; text-align: right">
                                            <span
                                                class="sun new-text">※</span>お急ぎの場合、営業担当にご相談下さい。出来る限りお客様のご希望に沿うよう対応させていただきます。<br />
                                            <span class="sun new-text">※</span>営業日には、土日祝日を含みません。<br />
                                        </span>
                                    </div>

                                    <div style="clear: both"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Shipping-->

            <!--Accordion Production-->
            <br>
            <div id="acc-production-period">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="production-toggle" class="accordion-input" checked>
                        <label for="production-toggle" class="accordion-header">
                            <span class="fw-bold">製作日数</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div class="prod-sched-wrapper">
                                    <div class="prod-sched-section">
                                        <p class="new-text">各種条件での製作日数の目安は以下になります。</p><br>
                                        <h2 class="prod-sched-title">◆スタンダード製作期間（単位：営業日。配送日数は含まず）</h2>
                                        <div class="prod-sched-scroll-box">
                                            <table class="prod-sched-table">
                                                <thead>
                                                    <tr>
                                                        <th class="prod-sched-empty-header"></th>
                                                        <th>300個以下</th>
                                                        <th>1,000個以下</th>
                                                        <th>3,000個程度まで</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="prod-sched-label">試作品製作日数</td>
                                                        <td>6</td>
                                                        <td>6</td>
                                                        <td>6</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-sched-label">量産品製作日数<br>(試作あり)</td>
                                                        <td>16</td>
                                                        <td>21</td>
                                                        <td>29〜</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-sched-label">量産のみの製作日数<br>(試作なし)</td>
                                                        <td>10</td>
                                                        <td>14</td>
                                                        <td>22〜</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="prod-sched-section">
                                        <h2 class="prod-sched-title">◆スタンダード (スピード発送) 製作期間 (単位：営業日。配送日数は含まず)</h2>
                                        <div class="prod-sched-scroll-box">
                                            <table class="prod-sched-table">
                                                <thead>
                                                    <tr>
                                                        <th class="prod-sched-empty-header"></th>
                                                        <th>300個以下</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="prod-sched-label">試作品製作日数</td>
                                                        <td>6</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-sched-label">量産品製作日数 (試作あり)</td>
                                                        <td>13</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-sched-label">量産のみの製作日数 (試作なし)</td>
                                                        <td>7</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="prod-sched-section">
                                        <h2 class="prod-sched-title">◆プレミアム製作期間 (単位：営業日。配送日数は含まず)</h2>
                                        <div class="prod-sched-scroll-box">
                                            <table class="prod-sched-table">
                                                <thead>
                                                    <tr>
                                                        <th class="prod-sched-empty-header"></th>
                                                        <th>300個以下</th>
                                                        <th>1,000個以下</th>
                                                        <th>3,000個程度まで</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="prod-sched-label">試作品製作日数</td>
                                                        <td>6</td>
                                                        <td>6</td>
                                                        <td>6</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-sched-label">量産品製作日数<br>(試作あり)</td>
                                                        <td>23</td>
                                                        <td>28</td>
                                                        <td>36〜</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-sched-label">量産のみの製作日数<br>(試作なし)</td>
                                                        <td>16</td>
                                                        <td>21</td>
                                                        <td>29〜</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="prod-sched-info-box">
                                        <h3>◆下記の制作条件の場合、上記に加えてプラス日数がかかります。</h3>
                                        <p class="new-text">・汚れ防止加工をオプションで付ける場合、+3～5営業日。</p>
                                        <p class="new-text">・シルク印刷ありでのご注文の場合、+1営業日。</p>
                                        <p class="new-text">・色味指定を印刷紙で行う場合、+3営業日。</p>
                                    </div>

                                    <br>
                                    <div class="prod-sched-info-box">
                                        <h3>◆製作後の配送日数</h3>
                                        <p class="new-text">
                                            北海道、九州、沖縄は2日。その他地域は1日。（離島等に関しては、別途お問い合わせください。）配送日数は、営業日でなく土日祝も含めた日数となります。
                                        </p>
                                    </div>

                                    <br>
                                    <div class="prod-sched-info-box">
                                        <h3>◆お客様の元へ製品が到着するまでの日数の計算例</h3>
                                        <p class="new-text">
                                            北海道、九州、沖縄は2日。その他地域は1日。（離島等に関しては、別途お問い合わせください。）配送日数は、営業日でなく土日祝も含めた日数となります。
                                        </p>
                                        <p class="new-text">スタンダード仕様にて、300個、試作品なしでご注文の場合、</p>
                                        <p class="new-text">・製作期間：10営業日</p>
                                        <p class="new-text">・配送期間：1-2日（配送地域により異なります）となります。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Production-->

            <!--Accordion Template-->
            <br>
            <div id="acc-data">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="template-toggle" class="accordion-input" checked>
                        <label for="template-toggle" class="accordion-header">
                            <span class="fw-bold">入稿データについて</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <p class="new-text">
                                        「デザインデータ作成のためのツール（adobe
                                        illustrator）を持っていない」「データの作り方がわからない」という方向けに、データ作成代行サービス（税込8,800円）をご提供しております。
                                        「データ作成ツールを持っていて使い方もわかるので自分でデータを作成したい」という方向けに、テンプレートをご用意しております。
                                    </p>
                                    <br>
                                    <div
                                        style="display: flex; flex-direction: row; justify-content: center; width: 100%">
                                        <a class="btn-a btn-yellow"
                                            href="/products/rubberstrap/download/download.php?fname=template-Rubberstrap_final_20260119.zip"
                                            target="_blank" download><span>テンプレートダウンロード</span></a>
                                    </div>
                                    <br>
                                    <div style="text-align:right;">
                                        <a target="_blank" href="/lp/rubber-guide-data.php" class="new-text"
                                            style="color: black;">詳細はこちら</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Template-->

            <!--Accordion Additional-->
            <br>
            <div id="acc-production">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="additional-toggle" class="accordion-input" checked>
                        <label for="additional-toggle" class="accordion-header">
                            <span class="fw-bold">自社生産だからこその高品質・低価格</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <p class="new-text">当店では、こだわりの自社生産によって、高品質・低価格を実現しています。</p><br>
                                    <label class="new-topic">機械と職人の手で高いクオリティを実現</label>
                                    <div>
                                        <img src="/products/images/rubberstrap/v2/rubber_strap_production.webp"
                                            alt="機械と職人による製造" loading="lazy">
                                    </div>
                                    <p class="new-text">
                                        最高のラバーストラップの製作のためには、最新技術と人の手の両方が不可欠です。当店は工程ごとに最適な手法（機械か、人か）を使い分け、理想のクオリティを実現しています。
                                    </p>
                                    <div style="text-align: end;">
                                        <a href="/lp/rubber-guide-production.php" class="new-text"
                                            style="color: black;">生産工程の詳細はこちら</a>
                                    </div>
                                    <br>
                                    <label class="new-topic">金具以上にちぎれにくい耐久性</label>
                                    <div>
                                        <img src="/products/images/rubberstrap/v2/rubber_strap_strength.webp"
                                            alt="耐久性テスト" loading="lazy">
                                    </div>
                                    <p class="new-text">ラバーストラップ製作においてよく懸念されるのが「金具との接続穴（通し穴）の強度」です。
                                        「使っているうちにゴムが千切れて、ストラップを落としてしまった……」 といった事故を防ぐため、ホットモバイリーでは徹底した強度テストを行っています。</p>
                                    <div style="text-align: end;">
                                        <a href="/lp/rubber-guide-production.php?sec=durability02" class="new-text"
                                            style="color: black;">耐久性の詳細はこちら</a>
                                    </div>
                                    <br>
                                    <label class="new-topic">強化段ボール＋3重梱包で安全にお届け</label>
                                    <div>
                                        <img src="/products/images/rubberstrap/v2/rubber_strap_packing.webp" alt="梱包方法"
                                            loading="lazy">
                                    </div>
                                    <p class="new-text">
                                        ラバーストラップはゴムの塊であるため、まとまるとかなりの重量になります。一般的な段ボールや簡易的な梱包では、配送中の振動や自重に耐えられず、ダメージを受けてしまうことも。当店では最高品質を保つため、梱包方法にもこだわっています。
                                    </p>
                                    <div style="text-align: end;">
                                        <a href="/lp/rubber-guide-production.php?sec=packing" class="new-text"
                                            style="color: black;">梱包の詳細はこちら</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Additional-->

            <!-- Order Form -->
            <br>
            <div id="order-form">
                

                <h2 id="est-order">ご注文・見積書作成</h2>
                <div style="overflow: unset!important;">
                    <div class="fixed-contrainer">
                        <h3 class="red">【ラバーストラップ】</h3>
                        <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="step-container line1"
                        style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
                        <div class="step-box">
                            <table class="table_rubber" style="padding: 0">
                                <tr>
                                    <td>ご注文タイプ</td>
                                    <td><span id="sample-prd-pcs">-</span></td>
                                </tr>
                                <tr>
                                    <td>サイズ</td>
                                    <td><span id="sample-prd-size">-</span></td>
                                </tr>
                                <tr>
                                    <td>裏面印刷</td>
                                    <td><span id="sample-prd-screen">-</span></td>
                                </tr>
                                <tr>
                                    <td>汚れ防止加工</td>
                                    <td><span id="sample-prd-coating">-</span></td>
                                </tr>
                                <tr>
                                    <td>数量</td>
                                    <td><span id="sample-prd-qty">-</span></td>
                                </tr>
                                <tr>
                                    <td>試作品</td>
                                    <td><span id="sample-prd-samp">-</span></td>
                                </tr>
                                <tr>
                                    <td>データトレース</td>
                                    <td><span id="sample-prd-trace">-</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img data-src="/products/images/HM_part1-2.webp" width="135" height="135"
                                id="sample-part-pic" class="picpro lazy" loading="lazy"><br />
                            <span id="sample-part-name">通常松葉（カニカン）</span>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img data-src="/products/acrylic/img/coming-soon.webp" width="135" height="135"
                                id="sample-paper-pic" class="picpro lazy" loading="lazy"><br />台紙:<span
                                id="sample-paper-name">なし</span>
                        </div>
                    </div>
                    <div class="step-container">
                        <div class="step-box step-list">
                            <ul>
                                <li id="dot-step1" class="active">
                                    <div class="step-number">1</div><span
                                        class="step-details">ご注文タイプ・裏面印刷</span>
                                </li>
                                <li id="dot-step2">
                                    <div class="step-number">2</div><span
                                        class="step-details">アタッチメント・台紙等</span>
                                </li>
                                <li id="dot-step3">
                                    <div class="step-number">3</div><span
                                        class="step-details">製品仕様・製作料金</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
                        <div style="display: table-column;"><input type="text" name="ItemType" id="strap"
                                value="ラバーストラップ" /></div>
                        
                        <div class="estimate-content" id="step1">
                            <h3>以前のご注文と同じデザインでの製作ですか？</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="いいえ"
                                            onclick="$('.repeat').hide();" {{ $RepeatSelected_1 ?? 'checked' }}>いいえ <span
                                            class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="はい"
                                            onclick="$('.repeat').show();" {{ $RepeatSelected_2 ?? '' }}>はい<span
                                            class="checkmark"></span></label>
                                </div>
                            </div>

                            <div class="repeat"
                                style="{{ $RepeatStyle_2 ?? (($RepeatSelected_2 ?? '') === 'checked' ? '' : 'display:none;') }}">
                                <h3>前回ご注文の管理番号等がもしおわかりでしたら、ご入力ください。</h3>
                                <div class="part-container">
                                    <div class="part-content">
                                        <label class="part-name">
                                            <input type="text" name="design_no" value="{{ $design_no ?? '' }}">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h3>ご注文タイプ</h3><a class="btn-details inline" href="javascript:void(0)"
                                for="modal-3" style="cursor: pointer;"
                                onclick="$('#modal-3').prop('checked',true)">詳細</a>
                            <input class="modal-state" id="modal-3" type="checkbox">
                            <div class="modal">
                                <label class="modal__bg" for="modal-3"></label>
                                <div class="modal__inner modal1">
                                    <label class="modal__close" for="modal-3"></label>
                                    <div class="flex-container b-bottom p-bottom">
                                        <div class="icon-img"><img class="lazy"
                                                data-src="/products/images/icon-standard-pc.webp" width="122"
                                                height="122" loading="lazy"></div>
                                        <div class="icon-text">
                                            <h4>配布用ノベルティ製品として十分な品質とコストパフォーマンスを両立</h4>
                                            <p>
                                                通常のラバーストラップのご注文はスタンダートプランをご利用下さい。来店されたお客様への景品や粗品、イベントでの販売などに最適です。玩具や、趣味としての販売にお使い頂くのに十分な品質を確保しております。また、業界最速での納期をご提供しながら、コストパフォーマンスの高さを実現。特に法人のお客様の大ロット・短納期へのご要望、台紙や同梱する書類などへの対応も含めて専任の担当者がご希望にお応えできる体制を構築しております。<br /><a
                                                    href="https://hotmobily.jp/products/quality.html#quality-check1">スタンダートの品質基準</a>
                                            </p>
                                            <div>&nbsp;</div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="flex-container b-bottom p-bottom">
                                        <div class="icon-img"><img class="lazy"
                                                data-src="/products/images/icon-rush-pc.jpg" width="122" height="122"
                                                loading="lazy"></div>
                                        <div class="icon-text">
                                            <h4>7営業日出荷。業界最速のスピードで製作</h4>
                                            <p>
                                                原稿確定日より、7営業日後に出荷いたします。例）月曜日に原稿確定の場合、翌週火曜日に出荷<br/>スタンダードと同じ品質とコストパフォーマンスで、納期を縮めることができます。「とにかく早く作りたい！」とお考えのお客様に最適。このプランは、200個までのご注文で選択いただけます。<br /><a
                                                    href="https://hotmobily.jp/products/quality.html#quality-check1">スタンダード（スピード発送）の品質基準はスタンダートの品質基準をご覧ください</a>
                                            </p>
                                            <div>&nbsp;</div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="flex-container b-bottom p-bottom">
                                        <div class="icon-img"><img class="lazy"
                                                data-src="/products/images/icon-premium-pc.webp" width="122"
                                                height="122" loading="lazy"></div>
                                        <div class="icon-text">
                                            <h4>品質重視。販売用製品として十分な品質を保証</h4>
                                            <p>
                                                物販サイトや店頭での販売や限られた大切なお客様への配布などに最適です。スタンダートプランとの一番の違いは品質の高さです。通常の玩具やノベルティ製品に要求される品質をはるかに超えた卓越した逸品としての品質を確保しております。海外での検査に加え、日本国内の専門検査会社での検査を行い品質を保証致します。<br/>また、ハイスペックな製品をお求めのお客様に対応する為、製作可能な色数や裏面印刷へのこだわりなど、専任の担当者が細部までヒアリングを行い、対応させて頂きます。<br /><a
                                                    href="https://hotmobily.jp/products/quality.html#quality-check2">プレミアムの品質基準</a>
                                            </p>
                                            <div>&nbsp;</div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="flex-container p-bottom">
                                        <div class="icon-img"><img class="lazy"
                                                data-src="/products/images/icon-hotmobilyfan-pc.webp" width="122"
                                                height="122" loading="lazy"></div>
                                        <div class="icon-text">
                                            <h4>ラバスト製作の入門プラン。業界最安値であなたの創作意欲に応えます</h4>
                                            <p>
                                                10個9,900円（税込)。ラバスト製作の初心者向け入門プランです。ラバストと他の製品の大きな違いは、事前に金型を作る必要があるので、ラバスト独特のデザインに変更しないといけない点です。こういった所を、できる限り小予算で体験して頂いたり、これから本格的にラバストを含めたグッズ製作をやってみようという方を念頭に置いたプランです。<br /><span
                                                    class="font_s">・このサービスは、個人のお客様専用のサービスです。<br/>・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br/>・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br/>・ご納期の指定はできません。<br/>・見積書、請求書、領収書の発行はできません。WEBサイトからのご注文のみとなります。<br/>ホットモバイリーファンの品質基準は<a
                                                        href="https://hotmobily.jp/products/quality.html#quality-check1">スタンダートの品質基準をご覧ください</a></span>
                                            </p>
                                            <div>&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <p class="new-text" style="color:red">中国工場の春節休みに伴い、現在通常納期以外の納期に対応しておりません。ご理解のほどお願い申し上げます。詳細は<a href="/campaign/202602" target="_blank">こちら</a></p> -->
                            
                            


                            <div class="part-container">
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS"
                                            id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();"
                                            {{ $lsSelected_1pcs ?? '' }}>スタンダード <span
                                            class="checkmark"></span></label></div>
                                <div class="part-content" {{ $delivery_disabled ?? '' }}><label class="part-name"><input
                                            type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）"
                                            onclick="click_typeorder_enabled();clearValue();" {{ $lsSelected_4pcs ?? '' }} {{ $planDisabled ?? '' }}>スタンダード（スピード7営業日発送） <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS"
                                            id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();"
                                            {{ $lsSelected_2pcs ?? '' }} {{ $planDisabled ?? '' }}>プレミアム <span
                                            class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS"
                                            id="pcs3" value="ホットモバイリーファン"
                                            onclick="type_special_disabled('t1');clearValue();" {{ $lsSelected_3pcs ?? '' }} {{ $planDisabled ?? '' }}>ホットモバイリーファン (10個 9,900円税込)<span
                                            class="checkmark"></span></label>
                                </div>
                                <span style="color: red" id="error_pcs"></span>
                                <div class="pcs_option">
                                    <p class="pcs_group"><span class="pcs_01" id="pcs_status"></span>
                                        <span id="pcs_txt"></span>
                                    </p>
                                    <p class="pcs_info">
                                        ・このサービスは、個人のお客様専用のサービスです。<br/>・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br/>・ホットモバイリーファンは、スタンダートの品質基準と同じ製品です。<br/>・製作料金は、送料込みの金額です。<br/>・製品の色数は12色以内でお願い致します。<br/>・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br/>・製品の裏面へのシルク印刷につきましては、申し訳ございませんが対応しておりません。<br/>・ご注文製品は、本WEBサイトの生産実績に掲載させて頂く場合がございます。<br/>・製品は製作開始から約3週間～1ヵ月程度でのご納品となります。<br/>・申し訳ございませんが、ご納期の指定はできません。<br/>・見積書、請求書、領収書の発行はできません。<br/>
                                    </p>
                                </div>
                            </div>
                            <h3>ベース厚さ</h3><a class="btn-details inline" href="javascript:void(0)"
                                for="modal-4" style="cursor: pointer;"
                                onclick="$('#modal-4').prop('checked',true)">詳細</a>
                            <input class="modal-state" id="modal-4" type="checkbox">
                            <div class="modal">
                                <label class="modal__bg" for="modal-4"></label>
                                <div class="modal__inner modal1" style="height: fit-content;"><label
                                        class="modal__close"
                                        for="modal-4"></label>最下層の厚みは、通常3mmでございます。ハイインパクトの最下層は5mmとなりまして、製品単価はスタンダード+20％増、プレミアム+10％増、となります。
                                </div>
                            </div>
                            <div class="part-container">
                                <div class="part-content"><label class="part-name"><input type="radio" id="normal_size"
                                            name="ItemSize" value="通常（80*80/3mm厚）" {{ $tickness0_checked ?? '' }}
                                            onclick="clearValue();" />通常（3mm厚） <span
                                            class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" id="big_size"
                                            name="ItemSize" value="ハイインパクト（80*80/5mm厚）" {{ $tickness1_checked ?? '' }}
                                            onclick="clearValue();" />ハイインパクト（5mm厚） <span
                                            class="checkmark"></span></label></div>
                            </div>

                            <h3>特殊素材（蓄光／蛍光／ラメ／金色銀色）</h3>
                            <div class="part-container">
                                <div class="part-content"><label class="part-name"><input type="radio"
                                            name="ItemMaterial" value="特殊素材なし" {{ $material0_checked ?? '' }}
                                            onclick="clearValue();" />特殊素材なし <span
                                            class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio"
                                            name="ItemMaterial" value="特殊素材あり" {{ $material1_checked ?? '' }}
                                            onclick="clearValue();" />特殊素材あり <span
                                            class="checkmark"></span></label></div>
                            </div>

                            <h3>裏面印刷</h3>
                            <div class="part-container">
                                <div class="part-content"><label class="part-name"><input type="radio" name="silk_print"
                                            id="nashiprint" value="印刷なし" {{ $printing1_checked ?? '' }}
                                            onclick="clearValue();" />印刷なし <span
                                            class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="silk_print"
                                            id="ariprint" value="単色（シルク）印刷" {{ $printing2_checked ?? '' }}
                                            onclick="clearValue();" />単色（シルク）印刷 <span
                                            class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="silk_print"
                                            id="fcprint" value="フルカラー印刷" {{ $printing3_checked ?? '' }}
                                            onclick="clearValue();" />フルカラー印刷
                                        <span class="checkmark"></span></label></div>
                                <span style="color: red" id="error_print"></span>
                                <font color="red">※プレミアムは裏面印刷が無料</font>
                            </div>
                            <h3>汚れ防止加工</h3><a class="btn-details inline" href="javascript:void(0)"
                                for="modal-2" style="cursor: pointer;"
                                onclick="$('#modal-2').prop('checked',true)">詳細</a>
                            <input class="modal-state" id="modal-2" type="checkbox">
                            <div class="modal">
                                <label class="modal__bg" for="modal-2"></label>
                                <div class="modal__inner modal1" style="height: fit-content;">
                                    <label class="modal__close" for="modal-2"></label>
                                    <img src="/products/images/banner-coating.webp" width="660" height="327"
                                        loading="lazy"><br>
                                    <p>ラバー製品に汚れ防止加工が出来ます。汚れが付着した場合、水洗いして頂くで簡単に汚れが落ちます。</p>
                                    <p class="red">スタンダード（スピード7営業日発送）では、汚れ防止加工はお選びいただけません。</p>
                                </div>
                            </div>
                            <div class="part-container">
                                <div class="part-content"><label class="part-name"><input type="radio" name="coating"
                                            id="coating0" value="汚れ防止加工なし" {{ $coating0_checked ?? '' }}
                                            onclick="clearValue();" />汚れ防止加工なし
                                        <span class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="coating"
                                            id="coating1" value="汚れ防止加工あり" {{ $coating1_checked ?? '' }}
                                            onclick="clearValue();" />汚れ防止加工あり (納期+3～5営業日） <span
                                            class="checkmark"></span></label>
                                </div>
                                <span style="color: red" id="error_coating"></span>
                            </div>

                            <h3>カラーバリエーション</h3><a class="btn-details inline" href="javascript:void(0)" for="modal-5"
                                style="cursor: pointer;" onclick="$('#modal-5').prop('checked',true)">詳細</a>
                            <input class="modal-state" id="modal-5" type="checkbox">
                            <div class="modal">
                                <label class="modal__bg" for="modal-5"></label>
                                <div class="modal__inner modal1" style="height: fit-content;">
                                    <label class="modal__close" for="modal-5"></label>
                                    <p>
                                        （詳細）<br />
                                        2種以上のカラーバリエーションを組み合わせて1つの注文にする事ができます。<br />
                                        <span class="red">複数種のデザインを1度にご注文できるわけではございません。</span>
                                    <div class="d-flex">
                                        <div class="flex-item">
                                            <img src="/products/images/HM_design1.webp" width="300" height="300"
                                                loading="lazy">
                                        </div>
                                        <div class="flex-item">
                                            <img src="/products/images/HM_design2.webp" width="300" height="300"
                                                loading="lazy">
                                        </div>
                                    </div>
                                    カラーバリエーション2種類目から＜3,300円(税込)/デザイン＞<br />
                                    ※カラーバリエーション毎の個数は、入稿データ内またはご連絡事項に記載してください。<br />
                                    ※4種類まで可能。各バリエーションの最小ロットは50個です。<br />
                                    </p>
                                </div>
                            </div>
                            <div class="group-container">
                                <label class="btn-select">
                                    <input type="radio" name="ItemDesignVariation" value="1種類" {{ $lsSelected_1design ?? '' }} onclick="clearValue();">1種類
                                </label>
                                <label class="btn-select">
                                    <input type="radio" name="ItemDesignVariation" value="2種類" {{ $lsSelected_2design ?? '' }} onclick="clearValue();">2種類
                                </label>
                                <label class="btn-select">
                                    <input type="radio" name="ItemDesignVariation" value="3種類" {{ $lsSelected_3design ?? '' }} onclick="clearValue();">3種類
                                </label>
                                <label class="btn-select">
                                    <input type="radio" name="ItemDesignVariation" value="4種類" {{ $lsSelected_4design ?? '' }} onclick="clearValue();">4種類
                                </label>
                            </div>
                            <p>1種類カラーバリエーションが増えると、＋3300円（税込）</p>
                            <div>&nbsp;</div>
                            <h3>ご注文本数</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name" id="label-qty">ご注文・御見積数量&nbsp;&nbsp;<input
                                            type="number" name="numberOf" id="no_of_order" class="right qty-inp"
                                            onchange="this.value=format_number(this.value);"
                                            value="{{ $numberOf ?? '' }}" style="text-align: right;"><br /></label>
                                    <div id="err_numberOf_mess">
                                    </div>
                                </div>
                            </div>
                            <span style="color: red" id="error_message"></span>
                        </div>
                        <div class="estimate-content" id="step2">
                            <h3>アタッチメント</h3>
                            <div class="flex-container">
                                <div class="preview-container">
                                    <div class="preview-sub flex-container">
                                        @foreach ($attachments as $idx => $att)
    <div class="flex-item">
        <label class="part-name">
            <input type="radio" name="part" value="{{ $att['part_name'] }}" onclick="getPartData('{{ $att['part_name'] }}')" {{ $idx === 0 ? 'checked' : '' }}>
            <img data-src="{{ $att['part_pic'] }}" width="95" height="95" class="picpro lazy" loading="lazy">
            <br><span class="part_price_std">+{{ $att['part_price'] * 1.1 }}円</span><span class="part_price_prm">+0円</span>
        </label>
    </div>
@endforeach
                                    </div>
                                </div>
                            </div>
                            <h3>台紙</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='paper_select'>
                                            <input type="checkbox" class="checkbox" name="paper_select" value="あり"
                                                onclick="check_val('next')" {{ ($paper_select ?? '') === 'あり' ? 'checked' : '' }}>
                                            <div class="knobs"><span></span></div>
                                            <div class="layer"></div>
                                        </div>
                                        台紙印刷
                                    </label>
                                    <div class="error" id="paper-error"></div>
                                </div>
                            </div>
                            <div class="flex-container paper-container">
                                <div class="preview-container">
                                    <div class="preview-sub flex-container" id="paper-preview">
                                        @include('products.partials.paper-preview')
                                    </div>
                                </div>
                            </div>
                            <h3>試作品・データトレース</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='SendPrototype'>
                                            <input type="checkbox" class="checkbox" name="SendPrototype" value="あり"
                                                onclick="setToInput();" {{ $sendActual_checked ?? '' }}>
                                            <div class="knobs"><span></span></div>
                                            <div class="layer"></div>
                                        </div>
                                        試作品
                                    </label>
                                </div>
                                <font color="red">※プレミアムは試作品代金が無料</font>
                                <font color="red">※ご注文納期とは別に、6営業日+配送2日がかかります。</font>
                            </div>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='DeFormat'>
                                            <input type="checkbox" class="checkbox" name="DeFormat" value="あり"
                                                onclick="setToInput();" {{ $others_checked ?? '' }}>
                                            <div class="knobs"><span></span></div>
                                            <div class="layer"></div>
                                        </div>
                                        データトレース
                                    </label>
                                </div>
                                <font color="red">※プレミアムはトレース代金が無料</font>
                            </div>
                        </div>
                        <div class="estimate-content flex-item" id="step3">
                            <div class="flex-container">
                                <div class="flex-item">
                                    <h3>製品仕様</h3>
                                    <table class="table_rubber">
                                        <tbody>
                                            <tr>
                                                <td class="TableLeft">ご注文タイプ</td>
                                                <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">サイズ</td>
                                                <td class="" id="prd_ItemSize" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">裏面印刷</td>
                                                <td class="" id="prd_silk_print" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">汚れ防止加工</td>
                                                <td class="" id="prd_coating" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">ご注文本数</td>
                                                <td class="" id="prd_qty" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">アタッチメント</td>
                                                <td class="" id="prd_part" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">台紙</td>
                                                <td class="" id="prd_paper" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">試作品</td>
                                                <td class="" id="prd_SendPrototype" style="text-align: left;">なし</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">データトレース</td>
                                                <td class="" id="prd_DeFormat" style="text-align: left;">なし</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">カラーバリエーション</td>
                                                <td class="" id="prd_ItemDesign" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">特殊素材</td>
                                                <td class="" id="prd_ItemMaterial" style="text-align: left;"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex-item">
                                    <h3>製作料金</h3>
                                    <table class="table_rubber total_price_tbl">
                                        <tbody>
                                            <tr>
                                                <td class="TableLeft">商品代金</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="StrapPrice" readonly="readonly" id="textfield7"
                                                        class="right" value="{{ $StrapPrice ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">裏面印刷代金</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="SilkPrint" readonly="readonly" id="textfield13"
                                                        class="right" value="{{ $SilkPrint ?? '' }}" />円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">汚れ防止加工</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="coatingPrice" readonly="readonly" id="textfield13_2"
                                                        class="right" value="{{ $coatingPrice ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">アタッチメント</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="PartPrice" readonly="readonly" id="textfield7_1"
                                                        class="right" value="{{ $PartPrice ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">台紙</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="PaperPrice" readonly="readonly" id="textfield7_2"
                                                        class="right" value="{{ $PaperPrice ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">試作品</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="ProShipping" readonly="readonly" id="textfield3"
                                                        class="right" value="{{ $ProShipping ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">データトレース</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="TraceCharge" readonly="readonly" id="textfield4"
                                                        class="right" value="{{ $TraceCharge ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">カラーバリエーション</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="DesignsCharge" readonly="readonly" id="DesignsCharge"
                                                        class="right" value="{{ $DesignsCharge ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">特殊素材</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="MaterialCharge" readonly="readonly" id="MaterialCharge"
                                                        class="right" value="{{ $MaterialCharge ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">小計(税込)</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="BeforeTax" readonly="readonly" id="textfield9"
                                                        class="right" value="{{ $BeforeTax ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">お値引き</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="discount" readonly="readonly" id="textfield_dis"
                                                        class="right" value="{{ $discount ?? '' }}">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft">合計(税込)</td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="grandTotal" readonly="readonly" id="textfield11"
                                                        class="right" value="{{ $grandTotal ?? '' }}">円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <table class="table_rubber total_price_tbl">
                                <tbody>
                                    <tr id="">
                                        <td colspan="2" style="background: unset;border: unset;">
                                            <div class="flex-container btn-container">
                                                <input type="button" class="btn clr-btn flex-item" value="CLEAR" id=""
                                                    onclick="clearValue();$('#cus_detail').hide();valid_chk_btn('step1');" />
                                                <a href="javascript:void(0)" class="btn btn-back"
                                                    onclick="valid_chk_btn('step1');$('#cus_detail').hide();">製作条件修正</a>
                                                <a href="javascript:void(0)" class="btn btn-back"
                                                    onclick="valid_chk_btn('step2');$('#cus_detail').hide();">ｱﾀｯﾁﾒﾝﾄ修正</a>
                                                <input type="button" class="btn est-btn flex-item"
                                                    value="見積書" id="button_pdf2"
                                                    onclick="$('#cus_detail').toggle()" />
                                                <input type="button" class="btn ord-btn flex-item"
                                                    value="ご注文情報入力へ" for="modal-ord"
                                                    onclick="$('#modal-ord').prop('checked',true)" />
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input class="modal-state" id="modal-ord" type="checkbox">
                            <div class="modal">
                                <label class="modal__bg" for="modal-ord"></label>
                                <div class="modal__inner modal1" style="height: fit-content;">
                                    <label class="modal__close" for="modal-ord"></label>
                                    <p>【ご確認ください】</p>
                                    <p class="red">毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。</p>
                                    <p>それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。</p>
                                    <diV style="display: grid;justify-items: center;">
                                        <picture>
                                            <source media="(max-width:650px)"
                                                srcset="/img/delivery_10days_notice_mb.jpg" style="width: 100%;">
                                            <img src="/img/delivery_10days_notice.jpg" alt="Flowers" style="width:100%;"
                                                loading="lazy">
                                        </picture>
                                        <input type="button" class="btn btn-back flex-item" value="OK"
                                            for="modal-ord"
                                            onclick="comSubmit('', '_top', form); " />
                                    </diV>

                                </div>
                            </div>
                        </div>
                        <div id="acrylic-btn" class="btn-container">
                            <a href="javascript:void(0)" id="back" class="btn btn-back"
                                onclick="valid_chk_btn('back')">戻る</a>
                            <a href="javascript:void(0)" id="next" class="btn btn-next"
                                onclick="valid_chk_btn('next')">アタッチメント・オプション入力へ</a>
                        </div>
                    </form>
                    <div id="cus_detail" style="display: none;" align="center">
                        <table class="table_rubber" style="display: table;">
                            <tbody>
                                <tr>
                                    <td class="TableLeft">お名前（姓）</td>
                                    <td class=""><input name="Name_S" id="sname" type="text" maxlength="100" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">お名前（名）</td>
                                    <td class=""><input name="Name_F" id="fname" type="text" maxlength="100" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">法人名</td>
                                    <td class=""><input name="Corp_Name" id="Corp_Name" type="text" value="" size="45"
                                            maxlength="100"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">郵便番号</td>
                                    <td class=""><input type="text" id="zip" name="zip" maxlength="8" size="15"
                                            value="">&nbsp;<input type="button" id="src_btn" onclick="address_fn();"
                                            value="住所に変換"><br><span id="error" style="color:red"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">都道府県</td>
                                    <td class=""><input type="text" id="address1" name="prefc" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">以降の住所</td>
                                    <td class=""><input id="address2" name="address" type="text" class="contact_text1"
                                            value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">番地、建物名、部屋番号</td>
                                    <td class=""><input id="address_street" name="address_street" type="text"
                                            class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">TELハイフンなし</td>
                                    <td class=""><input name="tel" id="tel" type="text" maxlength="11" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft">お客様メモ欄</td>
                                    <td class=""><input name="comment" id="comment" type="text" size="45" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"
                                        style="padding: 10px;background: unset;border: unset;">
                                        <input id="button_pdf" type="button"
                                            style="cursor:pointer;height: 30px;width: 250px;color: red"
                                            onclick="Javascript:validate('gcd');$('.loading').show();"
                                            value="御社情報確定（PDF出力）" />
                                        <div class="remark">&nbsp;※社名や会社名の入力は任意です</div><span
                                            id="validate_error" style="color:red"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Order Form -->

            <!--Accordion Gallery-->
            <br>
            <div id="acc-detail">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="gallery-toggle" class="accordion-input" checked>
                        <label for="gallery-toggle" class="accordion-header">
                            <span class="fw-bold">アタッチメント・加工・オプション</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">当店ラバーストラップのアタッチメント・加工・オプションのご紹介です。</p><br>
                                <div class="tab-container">
                                    <div class="tab-menu">
                                        <button class="tab-link active"
                                            onclick="openTab(event, 'tab1')">アタッチメント</button>
                                        <button class="tab-link" onclick="openTab(event, 'tab2')">加工方法</button>
                                        <button class="tab-link" onclick="openTab(event, 'tab3')">オプション</button>
                                    </div>

                                    <div id="tab1" class="tab-content active">
                                        <div class="grid-layout">
                                            <div class="itemz">
                                                <div class="row">
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part1.webp"
                                                            data-lightbox="img-part-set-1"
                                                            data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part1.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+0円</div>
                                                        <a href="/products/images/HM_part1.webp"
                                                            data-lightbox="img-part-set-1-1"
                                                            data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part2.webp"
                                                            data-lightbox="img-part-set-2"
                                                            data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part2.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+0円</div>
                                                        <a href="/products/images/HM_part2.webp"
                                                            data-lightbox="img-part-set-2-1"
                                                            data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part14.webp"
                                                            data-lightbox="img-part-set-14"
                                                            data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part14.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+0円</div>
                                                        <a href="/products/images/HM_part14.webp"
                                                            data-lightbox="img-part-set-14-1"
                                                            data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part3.webp"
                                                            data-lightbox="img-part-set-3"
                                                            data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part3.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+11円</div>
                                                        <a href="/products/images/HM_part3.webp"
                                                            data-lightbox="img-part-set-3-1"
                                                            data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part9.webp"
                                                            data-lightbox="img-part-set-9"
                                                            data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part9.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+11円</div>
                                                        <a href="/products/images/HM_part9.webp"
                                                            data-lightbox="img-part-set-9-1"
                                                            data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part10.webp"
                                                            data-lightbox="img-part-set-10"
                                                            data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part10.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+11円</div>
                                                        <a href="/products/images/HM_part10.webp"
                                                            data-lightbox="img-part-set-10-1"
                                                            data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part11.webp"
                                                            data-lightbox="img-part-set-11"
                                                            data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part11.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+11円</div>
                                                        <a href="/products/images/HM_part11.webp"
                                                            data-lightbox="img-part-set-11-1"
                                                            data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part12.webp"
                                                            data-lightbox="img-part-set-12"
                                                            data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part12.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+11円</div>
                                                        <a href="/products/images/HM_part12.webp"
                                                            data-lightbox="img-part-set-12-1"
                                                            data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="mt-10-part-4">
                                                        <a href="/products/images/HM_part13.webp"
                                                            data-lightbox="img-part-set-13"
                                                            data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。"><img
                                                                class="picpro lazy"
                                                                data-src="/products/images/HM_part13.webp" width="160"
                                                                height="160" loading="lazy" /></a><br />
                                                        <div>+11円</div>
                                                        <a href="/products/images/HM_part13.webp"
                                                            data-lightbox="img-part-set-13-1"
                                                            data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。"
                                                            style="font-size: 10px; color: black !important;">📷クリックすると拡大します</a>
                                                    </div>
                                                    <div class="part_link">
                                                        <a href="/products/rubberkeyholder/#part_keyholder"><img
                                                                data-src="/products/images/accessories.webp"
                                                                class="lazy" width="570" height="192"
                                                                loading="lazy" /></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="itemz">
                                            <img src="path_to_image2.jpg" alt="Double side" />
                                            <h3>両面印刷の仕様</h3>
                                            <p>両面印刷は透けにくい印刷方法を採用しています...</p>
                                        </div>
                                        <div class="itemz">
                                            <img src="path_to_image3.jpg" alt="Connected" />
                                            <h3>連結仕様もOK！</h3>
                                            <p>別商品の「アクリルチャーム」を繋げて楽しい！</p>
                                        </div> -->
                                        </div>
                                    </div>

                                    <div id="tab2" class="tab-content">
                                        <div class="grid-layout">
                                            <div class="itemz">
                                                <img src="/products/images/rubberstrap/v2/rubber_guide02.webp" alt=""
                                                    loading="lazy">
                                                <p class="new-text">
                                                    あなたのデザインを最高のラバーキーホルダーに！キャラクターに最適な「ぷっくり凹凸タイプ」や、ドット絵・ロゴ向きの「フラットタイプ」が選べます。
                                                </p><br>
                                                <div>
                                                    <a href="/lp/rubber-guide-structure.php" class="new-text"
                                                        style="color: black;">詳細はこちら</a>
                                                </div>
                                            </div>
                                            <div class="itemz">
                                                <img src="/products/images/rubberstrap/v2/rubber_guide07.webp" alt=""
                                                    loading="lazy">
                                                <p class="new-text">
                                                    曲面加工や貼り合わせ半立体、貫通穴（中抜き）加工などの特殊加工もご用意！デザインをより活かす特別なラバーストラップを製作できます。
                                                </p><br>
                                                <div>
                                                    <a href="/lp/rubber-guide-structure.php?sec=special_processing"
                                                        class="new-text" style="color: black;">詳細はこちら</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="tab3" class="tab-content">
                                        <div class="grid-layout">
                                            <div class="itemz">
                                                <img src="/products/images/rubberstrap/v2/rubber_strap_protect.webp"
                                                    alt="" loading="lazy">
                                                <p class="new-text">業界唯一の汚れ防止加工オプションをご用意！あなたの大切なラバーストラップをキレイに保ちます。</p>
                                                <br>
                                                <div>
                                                    <a href="https://hotmobily.jp/faq/details/rubberstrap/q4"
                                                        class="new-text" style="color: black;">詳細はこちら</a>
                                                </div>
                                            </div>
                                            <div class="itemz">
                                                <img src="/products/images/rubberstrap/v2/rubberstrap_special.webp"
                                                    alt="" loading="lazy">
                                                <p class="new-text">金銀、蓄光、ラメ、蛍光、半透明素材の5種の特殊素材をご用意！</p><br>
                                                <div>
                                                    <a href="/lp/rubber-guide-special.php" class="new-text"
                                                        style="color: black;">詳細はこちら</a>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="grid-layout">
                                            <div class="itemz">
                                                <img src="/products/images/rubberstrap/v2/rubber_guide11.webp" alt=""
                                                    loading="lazy">
                                                <p class="new-text">入稿データをご自身で作成するのが難しい方は、データ作成代行サービスをぜひご利用ください。</p><br>
                                                <div>
                                                    <a href="/lp/rubber-guide-data.php" class="new-text"
                                                        style="color: black;">詳細はこちら</a>
                                                </div>
                                            </div>
                                            <div class="itemz">
                                                <img src="/products/images/rubberstrap/v2/daishi_rubberstrap.webp"
                                                    alt="" loading="lazy">
                                                <p class="new-text">
                                                    台紙封入サービスをご用意しております。当店のテンプレートデザイン、またはお客様のオリジナルデザインの台紙を封入します。</p><br>
                                                <div>
                                                    <a href="https://hotmobily.jp/products/daishi.html" class="new-text"
                                                        style="color: black;">詳細はこちら</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Gallery-->

            <!--Accordion How To Order -->
            <br>
            <div id="acc-flow">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="howtoorder-toggle" class="accordion-input" checked>
                        <label for="howtoorder-toggle" class="accordion-header">
                            <span class="fw-bold">注文の流れ</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/images/rubberstrap/v2/rubberstrap_flow.webp" alt="" width="100%"
                                        loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    当ページの注文フォームよりご注文ください。注文後、注文完了メールがお客様のメールアドレス宛てに送付されます。その後、当店からお客様へ、デザインの確認等のご連絡をメールでさせて頂きます。
                                </p>
                                <div style="text-align: right;">
                                    <a href="/lp/rubber-guide-flow.php" class="new-text"
                                        style="color: black;">詳細はこちら</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion How To Order -->

            <!--Accordion Security -->
            <br>
            <div id="acc-safety">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="security-toggle" class="accordion-input" checked>
                        <label for="security-toggle" class="accordion-header">
                            <span class="fw-bold">食品衛生法のおもちゃ規格に準拠した安全性</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/images/rubberstrap/v2/rubberstrap_durability01.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    主流の安価なラバー製品特有の「ツンとする刺激臭」。これは素材に含まれる特定の化学物質が原因です。当店では、環境ホルモンの影響が少なく、食品衛生法のおもちゃ規格にも準拠した安心・安全の「ATBC-PVC（非フタル酸系塩ビ）」を使用しています。
                                </p>
                                <div style="text-align: right;">
                                    <a href="/lp/rubber-guide-production.php?sec=durability01" class="new-text"
                                        style="color: black;">詳細はこちら</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Security -->

            <!--Accordion Stage -->
            <br>
            <div id="acc-scene">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="stage-toggle" class="accordion-input" checked>
                        <label for="stage-toggle" class="accordion-header">
                            <span class="fw-bold">どんなシーンで使われているの？</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/images/rubberstrap/v2/rubberstrap_scene.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    「ラバーストラップの製作に興味があるけど、実際どんな場面で使われているのかな？」と疑問に思っている方もいるかもしれません。ラバーストラップは、キャラクターグッズやファングッズなどさまざまな用途で使用されています。
                                </p>
                                <div style="text-align: right;">
                                    <a href="/lp/rubber-guide-scene.php" class="new-text"
                                        style="color: black;">詳細はこちら</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Stage -->

            <!--Accordion Capsule Toy -->
            <br>
            <div id="acc-scene">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="toy-toggle" class="accordion-input" checked>
                        <label for="toy-toggle" class="accordion-header">
                            <span class="fw-bold">カプセルトイ封入オプション</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/lp/images/cupsule_toy_rubber.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    製品をマシンへすぐに投入できるカプセルトイ封入オプションをご用意しております。お客様に、製品だけでなく、ケースを開けるワクワク感を届けることができるおすすめオプションです。
                                </p>
                                <br>
                                <div style="text-align: right;">
                                    <a href="/lp/rubber-guide-capsuletoy.php" class="new-text"
                                        style="color: black;">カプセルトイ封入オプションの詳細はこちら</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Capsule Toy -->


            <!--Accordion FAQ -->
            <br>
            <div id="acc-faq">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="faq-toggle" class="accordion-input" checked>
                        <label for="faq-toggle" class="accordion-header">
                            <span class="fw-bold">FAQ</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                @if (!empty($faqs))
    <style>
        .faq-last-item {
            position: relative;
            overflow: hidden;
        }
        .faq-last-item::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.6) 50%, rgba(255, 255, 255, 1) 100%);
            pointer-events: none;
            transition: opacity 0.9s ease-in-out;
        }
    </style>
    <div class="mt new-text">
        @foreach ($faqs as $idx => $faq)
            <div class="{{ $loop->last ? 'faq-last-item' : '' }}" style="margin-bottom: 15px;">
                <div class="faq-question d-flex2">
                    <p><font color="red">Q{{ $idx + 1 }}.</font> {!! $faq['question'] !!}</p>
                </div>
                <div class="faq-answer d-flex2">
                    <p><font color="blue">A{{ $idx + 1 }}.</font> {!! $faq['answer'] !!}</p>
                </div>
            </div>
        @endforeach
        <div style="text-align:right; margin-top: 15px;">
            <a style="color:black;" href="https://hotmobily.jp/faq/product-info.php?code=rubber">ラバーストラップFAQページへ</a>
        </div>
    </div>
@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion FAQ -->

            <!--Accordion Guide -->
            <br>
            <div id="acc-encyclopedia">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="guide-toggle" class="accordion-input" checked>
                        <label for="guide-toggle" class="accordion-header">
                            <span class="fw-bold">ラバスト大全</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <a href="/products/images/daizen_z.webp" data-lightbox="daizen"
                                        style="text-decoration:none;">
                                        <img class="lazy" data-src="/products/images/daizen-2.webp" width="100%"
                                            height="643" loading="lazy">
                                    </a><br />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Guide -->

            <!--Accordion Video -->
            <br>
            <div id="acc-video">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="video-toggle" class="accordion-input" checked>
                        <label for="video-toggle" class="accordion-header">
                            <span class="fw-bold">ラバーストラップ自社工場のご紹介</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div class="videoWrapper">
                                    <img src="/products/img/rubber-production-yt.webp" data-src="5KK0a4b1C9Q"
                                        class="iframe" width="771" height="434">
                                    <div class="playbtn">
                                        <div class="tri"></div>
                                    </div>
                                </div>
                                <br>
                                <div style="text-align: right;">
                                    <a href="/lp/rubber-guide-inhouse.php" class="new-text"
                                        style="color:black !important;">自社生産の詳細はこちら</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Video -->

            <!--Accordion Spec-->
            <br>
            <div id="acc-specifications">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="spec-toggle" class="accordion-input" checked>
                        <label for="spec-toggle" class="accordion-header">
                            <span class="fw-bold">製品仕様</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <table class="table_rubber" cellpadding="5" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>名称</td>
                                            <td style="text-align: left;">オリジナルラバーストラップ</td>
                                        </tr>
                                        <tr>
                                            <td>素材</td>
                                            <td style="text-align: left;">
                                                ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)。熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細はこちら。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>大きさ</td>
                                            <td style="text-align: left;">
                                                縦80mmX横80mm以内。（このサイズを超える製品は、別途費用がかかります）
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>厚さ</td>
                                            <td style="text-align: left;">3mmもしくは5mm。注文時に指定。指定肉厚可。</td>
                                        </tr>
                                        <tr>
                                            <td>色数</td>
                                            <td style="text-align: left;">
                                                スタンダードの場合12色まで、プレミアムの場合18色までご使用頂けます。<br>印刷物ではないため、グラデーションは表現できません。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>色指定</td>
                                            <td style="text-align: left;">
                                                以下2通りのいづれか。①PANTONE(パントーン)もしくは、DIC(ディック)番号によるご指定。②弊社もしくは、お客様が印刷された、色見本（カラーペーパー）によるご指定。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>裏面印刷</td>
                                            <td style="text-align: left;">
                                                単色（シルク）印刷、カラー印刷ともに可能です。プレミアムの場合は無料、スタンダードの場合は単色が＋@33円（税込）、カラーが＋@55円（税込）となります。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>最小製作個数（最小ロット）</td>
                                            <td style="text-align: left;">
                                                100個より製作します。（ホットモバイリーファンは、10個9,900円です。）
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>試作品（実物校正サンプル）</td>
                                            <td style="text-align: left;">
                                                スタンダードの場合、+8,800円（税込）、プレミアムの場合無料。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>台紙</td>
                                            <td style="text-align: left;">オプションとして台紙の封入が可能です。 <a
                                                    href="/products/daishi.html"
                                                    style="color:black;">台紙封入の詳細。</a>
                                                支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Spec-->

            <!-- Section Review -->
            <br>
            <div id="reviews">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="reviews-toggle" class="accordion-input" checked>
                        <label for="reviews-toggle" class="accordion-header">
                            <span class="fw-bold">当店ラバーストラップのレビュー</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                @if (!empty($reviews))
    <link href="/reviews/css/reviews.css" rel="stylesheet" type="text/css" />
    <style>
        .rev-last-item {
            position: relative;
            overflow: hidden;
        }
        .rev-last-item::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 30%, rgba(255, 255, 255, 1) 100%);
            pointer-events: none;
            transition: opacity 0.5s ease-in-out;
        }
        .rev-last-item .rev-question { opacity: 0.6; }
        .rev-last-item .rev-answer { opacity: 0.3; }
    </style>
    <div>
        @foreach ($reviews as $rev)
            <div class="reviews_area {{ $loop->last ? 'rev-last-item' : '' }}">
                <div class="user_icon rev-question"><img src="/reviews/img/user_icon.png" alt="User"></div>
                <div class="reviews_box rev-answer">
                    @if (!empty($rev['comment']))
                        <p class="comment">{{ $rev['comment'] }}</p>
                    @endif
                    <hr>
                    <p class="star">お客様対応:<span class="score">
                        @for ($s = 1; $s <= 5; $s++)
                            {{ $s <= $rev['service'] ? '★' : '☆' }}
                        @endfor
                    </span>
                    &nbsp;&nbsp;製品の満足度:<span class="score">
                        @for ($p = 1; $p <= 5; $p++)
                            {{ $p <= $rev['product'] ? '★' : '☆' }}
                        @endfor
                    </span>
                    &nbsp;&nbsp;営業担当： <span class="sale">{{ $rev['sale_name'] }}</span><br/>
                    製品： <span class="product_type">{{ $rev['product_type'] }}</span></p>
                </div>
            </div>
        @endforeach
    </div>
@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Review -->

            <!-- Section Blog -->
            <br>
            <div id="blog">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="blog-toggle" class="accordion-input" checked>
                        <label for="blog-toggle" class="accordion-header">
                            <span class="fw-bold">関連記事</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                @if (!empty($blogs))
    @foreach ($blogs as $blog)
        <div class="d-flex">
            <div class="flex-item w-30">
                <a class="unlink" href="/blog-content/{{ $blog['url'] }}" style="color:black;"><img src="/{{ $blog['img_cover'] }}" class="w-100" alt="{{ $blog['title'] }}"></a>
            </div>
            <div class="flex-item w-70">
                <a class="unlink" href="/blog-content/{{ $blog['url'] }}" style="color:black;">{{ $blog['title'] }}</a>
            </div>
        </div>
        <div>&nbsp;</div>
    @endforeach
@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Blog -->

            <br>
            <div id="lastd">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="lastd-toggle" class="accordion-input" checked>
                        <label for="lastd-toggle" class="accordion-header">
                            <span class="fw-bold fw-style">営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div align="center">
                                    <a href="//hotmobily.jp/meeting_date/"><img
                                            data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム"
                                            width="100%" height="82" class="lazy" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>


            <div id="pdp-v2-modal" class="pdp-v2-modal-overlay">
                <div class="pdp-v2-modal-container">
                    <span class="pdp-v2-modal-close">&times;</span>
                    <img class="pdp-v2-modal-content" id="pdp-v2-modal-img" alt="Zoomed view">

                    <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>

@endsection

@push('scripts')
    <!-- /lightbox2-master -->
    <script src="/products/js/lightbox.js" defer></script>
    <script src="/js/swiper.min.js" defer></script>
    <script>
        if (typeof lightbox !== 'undefined') {
            lightbox.option({
                'maxWidth': 800,
                'maxHeight': 800,
                'alwaysShowNavOnTouchDevices': true
            });
        }
    </script>
    <!-- /lightbox2-master -->
    <!-- Form Calculater & Validation JS -->
    <script type="text/javascript" src="/js/_setToInput_2026.js?v=1.01"></script>
    <script type="text/javascript" src="/js/validation_new.js?v=1.11"></script>
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.17"></script>
    <script type="text/javascript" src="/products/js/date.js"></script>
    <script type="text/javascript" src="/js/pdf_rubber-campaign.js"></script>
    <script>
        $(document).ready(function() {
            let params = '{{ request('sec', '') }}';
            if (params != "") {
                GotoDiv(params, true);
            }

            // --- 1. CACHE DOM ELEMENTS (Performance Boost) ---
            const elements = {
                modal: document.getElementById('pdp-v2-modal'),
                modalImg: document.getElementById('pdp-v2-modal-img'),
                pdpStrip: document.getElementById('pdp-v2-js-strip'),
                pdpGrid: document.getElementById('pdp-v2-js-grid-pc'),
                nextBtn: document.getElementById('pdp-v2-modal-next-btn'),
                closeBtns: document.querySelectorAll('.pdp-v2-modal-close'),
                body: document.body
            };

            // Image list for modal functionality
            const imageList = [
                "/products/images/rubberstrap/v2/rubber_strap_product01.webp",
                "/products/images/rubberstrap/v2/rubber_strap_product02.webp",
                "/products/images/rubberstrap/v2/rubber_strap_product03.webp",
                "/products/images/rubberstrap/v2/rubber_strap_product04.webp",
                "/products/images/rubberstrap/v2/rubber_strap_product05.webp",
                "/products/images/rubberstrap/v2/rubber_strap_product06.webp?v=1"
            ];

            let pdpCurrentIdx = 0;
            let pdpTimer;
            const isMobile = window.innerWidth < 768;

            function initGallery() {
                // Attach click events to existing main images (for modal open)
                const mainLinks = elements.pdpStrip.querySelectorAll('.pdp-v2-main-link');
                mainLinks.forEach((link) => {
                    const idx = parseInt(link.getAttribute('data-index'), 10);
                    link.onclick = () => openModal(idx);
                });

                // Attach click events to existing thumbnails
                const thumbs = elements.pdpGrid.querySelectorAll('.pdp-v2-thumb-item');
                thumbs.forEach((thumb) => {
                    const idx = parseInt(thumb.getAttribute('data-index'), 10);
                    thumb.onclick = () => {
                        updateGalleryView(idx);
                        restartAutoTimer();
                    };
                });
            }

            function updateGalleryView(index) {
                pdpCurrentIdx = index;
                if (elements.pdpStrip) elements.pdpStrip.style.transform = `translateX(-${index * 100}%)`;

                // Efficient class toggling
                const thumbs = document.getElementsByClassName('pdp-v2-thumb-item');
                for (let i = 0; i < thumbs.length; i++) {
                    if (i === index) thumbs[i].classList.add('pdp-v2-active-state');
                    else thumbs[i].classList.remove('pdp-v2-active-state');
                }
            }

            function openModal(index) {
                pdpCurrentIdx = index;
                if (elements.modal) {
                    elements.modal.classList.add('active');
                    elements.modalImg.src = imageList[index];
                    elements.modalImg.style.opacity = '1';
                    clearInterval(pdpTimer);
                }
            }

            function closeModal() {
                if (elements.modal) elements.modal.classList.remove('active');
                restartAutoTimer();
            }

            function nextImage() {
                pdpCurrentIdx = (pdpCurrentIdx + 1) % imageList.length;
                // Fade effect logic
                elements.modalImg.style.opacity = '0';
                setTimeout(() => {
                    elements.modalImg.src = imageList[pdpCurrentIdx];
                    elements.modalImg.onload = () => {
                        elements.modalImg.style.opacity = '1';
                    };
                }, 200);
                updateGalleryView(pdpCurrentIdx);
            }

            // Modal Event Listeners
            if (elements.closeBtns) elements.closeBtns.forEach(btn => btn.onclick = closeModal);
            if (elements.modal) elements.modal.onclick = (e) => {
                if (e.target === elements.modal) closeModal();
            };
            if (elements.nextBtn) elements.nextBtn.onclick = (e) => {
                e.stopPropagation();
                nextImage();
            };

            function startAutoTimer() {
                pdpTimer = setInterval(() => {
                    pdpCurrentIdx = (pdpCurrentIdx + 1) % imageList.length;
                    updateGalleryView(pdpCurrentIdx);
                }, 4000);
            }

            function restartAutoTimer() {
                clearInterval(pdpTimer);
                startAutoTimer();
            }

            // --- 4. OPTIMIZED ENTRANCE ANIMATIONS ---
            // Replaces the nested setTimeout "Callback Hell"
            function runEntranceAnimations() {
                // Define animation targets based on screen size
                const targets = isMobile ? ['#B', '.Mb-D-Contents', '.Mb-A-Contents', '.Mb-B-Contents'] : ['#B', '.PC-C-Contents', '.Mb-A-Contents', '.Mb-B-Contents'];

                // Smooth cubic-bezier for premium feel
                const smoothEasing = 'cubic-bezier(0.16, 1, 0.3, 1)';

                // Initial State (Apply via JS to ensure CSS matches)
                targets.forEach(sel => {
                    $(sel).css({
                        "filter": "blur(5px)",
                        "opacity": "0",
                        "transform": "translateY(30px)",
                        "transition": `filter 1.2s ${smoothEasing}, opacity 1.2s ${smoothEasing}, transform 1.2s ${smoothEasing}`,
                        "will-change": "filter, opacity, transform"
                    });
                });

                // Use requestAnimationFrame for smoother start
                requestAnimationFrame(() => {
                    // Loop with staggered delays (250ms for gentle cascade)
                    targets.forEach((selector, index) => {
                        setTimeout(() => {
                            $(selector).css({
                                "filter": "blur(0)",
                                "opacity": "1",
                                "transform": "translateY(0)"
                            });
                            // Clean up will-change after animation completes
                            setTimeout(() => {
                                $(selector).css("will-change", "auto");
                            }, 1200);
                        }, index * 250 + 100); // 250ms stagger, 100ms initial delay
                    });
                });
            }

            // --- 5. EVENT DELEGATION FOR ACCORDIONS ---
            // Replaces adding listeners to every single header
            document.addEventListener('click', function(e) {
                // Check if clicked element is an accordion header or inside one
                const header = e.target.closest('.accordion-header');
                if (!header) return;

                // Close all others
                document.querySelectorAll('.accordion-header').forEach(h => {
                    content.style.maxHeight = null;
                    if (h !== header) {
                        h.classList.remove('active');
                        h.nextElementSibling.style.maxHeight = null;
                        h.nextElementSibling.style.paddingTop = "0";
                        h.nextElementSibling.style.paddingBottom = "0";
                    }
                });

                // Toggle Clicked
                const content = header.nextElementSibling;
                header.classList.toggle('active');

                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    content.style.paddingTop = "0";
                    content.style.paddingBottom = "0";
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                    content.style.paddingTop = "15px";
                    content.style.paddingBottom = "15px";
                }
            });

            // --- 6. AJAX & EXTERNAL CONTENT ---
            // Grouped for cleaner execution

            // Load Info
            $('#info_div').load('/info/index.php');

            // Load Price Table
            const $priceTbl = $('.tbl_price_deli.loading');
            if ($priceTbl.length) {
                $priceTbl.load("../getdate_disp2023-rubber", function(data) {
                    $(this).replaceWith(data);
                    $('.tbl_price_deli').removeClass("loading");
                });
            }

            // Check Holiday
            $.post("/products/check_holiday.php", {
                "product": "ラバーストラップ"
            }, function(data) {
                if (typeof productionDate === 'function') productionDate(data.sort());
            }, "json");

            // Get Sample Date
            $.post("../get_sample_date.php", {
                'days': '7',
                'format_cal': '12'
            }, function(data) {
                $('.speed_deli_date').html(formatDate(data[1]) + "<br/><div class='ut_date'>7日</diV>");
                $('.speed_deli_date2').html(formatDate(data[2]) + "<br/><div class='ut_date'>13日</diV>");
                if (typeof productionDate3 === 'function') productionDate3(data.sort());
            }, "json");

            // Get Sample Date 2
            $.post("../get_sample_date.php", function(data) {
                if (typeof productionDate2 === 'function') productionDate2(data.sort());
            }, "json");

            // --- 7. MISC UI HANDLERS ---

            // Paper Preview
            $(document).on('click', "input[name='paper_select']", function() {
                if ($(this).is(':checked')) {
                    $('#paper-preview').load('/products/paper_preview.php');
                }
            });

            // Read More Expanders (Delegated)
            $(document).on('click', '.exc_pro1 .btn, .exc_pro .btn', function(e) {
                e.preventDefault();
                const $el = $(this);
                const $up = $el.closest('.exc_pro1, .exc_pro'); // Find parent container
                const $containers = $up.find("div.swiper-container");

                let totalHeight = 0;
                $containers.each(function() {
                    totalHeight += $(this).outerHeight();
                });

                $up.css({
                        "max-height": 9999,
                        "padding-bottom": 70
                    })
                    .animate({
                        "height": totalHeight
                    });
                $el.parent().fadeOut();
            });

            // Video Preview Switcher
            $('.preview-sub img').click(function() {
                var e = $(this).attr('data-embed');
                var r = $(this).attr('data-src');
                if ($('.preview-top').find('img').length) {
                    $('.preview-top img').attr('src', r).attr('data-src', e);
                } else {
                    $('.preview-top iframe').attr('src', 'https://www.youtube.com/embed/' + e);
                }
            });

            // Swiper Logic
            if (isMobile) {
                if (typeof Swiper !== 'undefined') {
                    new Swiper('.swiper-container', {
                        slidesPerView: 2,
                        spaceBetween: 10,
                        slidesPerGroup: 1,
                        loop: false,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        },
                    });
                }
                // Delayed Scroll (optimized)
                setTimeout(() => window.scrollBy(0, 5), 3000);
            } else {
                setTimeout(() => window.scrollBy(0, 5), 100);
            }

            $("#open-virus").click(function() {
                $("#slide-virus").slideToggle("slow");
            });
            $('.jump').click(function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#text-coating').offset().top - 100
                }, 800);
            });

            // INITIALIZE
            initGallery();
            startAutoTimer();
            // runEntranceAnimations();

            // Dynamic Text Updates
            var tmp = "{{ request('mode', '') }}"; // Safety check for PHP
            if (isMobile) {
                $("#i_txt1").attr("src", "images/img_txt2_n1.svg");
                $("#i_txt2").attr("src", "images/text_sample_n1.svg");
            }
            // Assumes getPartData is defined globally
            if (typeof getPartData === 'function') getPartData($('input[name="part"]:checked').val());
            if (tmp != "" && typeof valid_chk_btn === 'function') valid_chk_btn('step3');

        }); // End Ready

        // --- GLOBAL FUNCTIONS (Keep outside ready to be accessible) ---

        function openTab(evt, tabName) {
            $(".tab-content").hide();
            $(".tab-link").removeClass("active");

            const tab = document.getElementById(tabName);
            if (tab) {
                tab.style.display = "block";
                tab.style.maxHeight = "2000px";
            }
            if (evt && evt.currentTarget) evt.currentTarget.classList.add("active");
        }

        function GotoDiv(no, external_page = false) {
            let em = '';
            if (!no) return;

            if (!external_page) {
                const map = {
                    1: '#order-form',
                    2: '#acc-shipping',
                    3: '#acc-price',
                    4: '#acc-detail',
                    5: '#reviews'
                };
                em = map[no];
                if (no == 2) openShippingAccordion();
                if (no == 3) openPriceAccordion();
            } else {
                em = '#' + no;
            }

            if (em && $(em).length) {
                $("html, body").animate({
                    scrollTop: $(em).offset().top - 100
                }, 1000);
            }
        }

        function openSimpleModal(element) {
            const modal = document.getElementById('pdp-v2-modal');
            const modalImg = document.getElementById('pdp-v2-modal-img');
            let imgSrc = "";

            if (element.tagName === 'IMG') imgSrc = element.src;
            else {
                const img = element.closest('.flex-item')?.querySelector('swiper-container img');
                if (img) imgSrc = img.src;
            }

            if (imgSrc && modal) {
                modal.classList.add('active');
                modalImg.src = imgSrc;
                modalImg.style.opacity = '1';
            }
        }

        function openPriceAccordion() {
            $('#price-toggle').prop('checked', true);
            document.getElementById('acc-price')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function openShippingAccordion() {
            $('#shipping-toggle').prop('checked', true);
            document.getElementById('acc-shipping')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    </script>
    <script type="text/javascript" src="/js/common.js?v=1.02" defer></script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js" async></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tbl_s").on("click scroll", function() {
                $(this).find(".scroll-center").hide();
            });
        });
    </script>
    <noscript>
        <div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt=""
                src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
        </div>
    </noscript>
    <script type="application/ld+json">
        {!! $jsonLdOutput !!}
    </script>
    <!-- /.google script -->
@endpush
