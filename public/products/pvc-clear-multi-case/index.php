<?php
header('Cache-Control: public, max-age=300'); // 5 minutes
header('Content-Type: text/html; charset=UTF-8');
if (extension_loaded('zlib') && !ob_get_level()) {
    ob_start('ob_gzhandler');
}
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//Read Modules
require_once('../../control/Control_Rubber.php');
include_once('../../common/Const.php');
include_once('../../common/SetUpLang.php');
include_once('../const_js.php');
include("../../connect_db/Control_Connect.php");


// GETリクエストを取得
// $msMode = $_GET['mode'];
$msMode = "";
if (isset($_GET['mode'])) {
    $msMode = $_GET['mode'];
}
$btn_flg = false;

// パラメータを取得
if ($msMode == "MODE_MOD") {
    $mrFormData = $_SESSION;
    foreach ($mrFormData as $k => $v) {
        $$k = $v;
        $_POST["$k"] = $_SESSION["$v"];
    }
    $_SESSION['btn_flg'] = false;
} else if ($msMode == "CANCEL") {
    $btn_flg = $_POST['btn_flg'];
    $_POST[] = array();

    session_unset();
    session_destroy();
    $link = gsCnv2Form($_SERVER['SERVER_PHP_SELF']);
} else if ($msMode === "MODE_RESET") {
    session_unset();
    session_destroy();
} else {
    $mrFormData = $_POST;
    foreach ($mrFormData as $k => $v) {
        $$k = $v;
        $_SESSION[$k] = $v;
    }

    ClearSessionPrice();
}
// エラー出力用
$mrErrMsgList = array();
$msErrFocusCtl = "";

//メイン関数の呼出
Main();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="PVCクリアマルチケース">
    <meta name="description" content="オリジナルのPVCクリアマルチケースを製作！フルカラー印刷対応で推し活グッズや企業ノベルティに大人気。クリア・ラメ・オーロラの3種から選べます。最小50個の小ロットから、最短12営業日の短納期でお届け。大ロットなら1個420円とお得に作成可能です。">
    <meta name="robots" content="index,follow" />
    <title>PVCクリアマルチケース｜オリジナル製作｜小ロット50個・短納期</title>
    <link rel="canonical" href="https://hotmobily.jp/products/pvc-clear-multi-case/">
    <link rel="preload" type="text/css" href="https://hotstrap.jp/css/homepage.css?v=1.15" as="style" onload="this.rel='stylesheet'">
    <link href="/products/css/box.css" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/css/modal.css?v=1.01" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/products/css/calendar.css?v=2" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <?php include("../../head_products.html"); ?>
    <link rel="stylesheet" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link href="/products/css/product_group.css?v=1.14" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="stylesheet" type="text/css" href="../css/scroll.css">
    <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
    <style type="text/css">
        <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
    </style>
    <noscript>
        <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
        <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
        <link href="/products/acrylic/css/acrylic.css?v=1.05" rel="stylesheet" type="text/css">
    </noscript>
    <script language="JavaScript" type="text/javascript">
    </script>
    <script type="text/javascript" src="/js/lazyload.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#open1").click(function() {
                $("#slide1").slideToggle("slow");
            });
        });
    </script>
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

        .h1-new {
            color: #000 !important
        }

        body {
            font-family: IwaUDGoDspPro-Th, sans-serif !important
        }

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
            max-height: 2500px;
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

               .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
}

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
            /* text-align: left !important; */
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
            /* margin-bottom: -1px */
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

        .h3-new {
            font-size: 17px !important;
            letter-spacing: 0.05em !important;
            padding: 13px 10px !important;
            background-image: repeating-linear-gradient(90deg, rgba(255, 165, 0, 1) 0, rgba(255, 165, 0, 1) 2px, rgba(0, 0, 0, 0) 2px, rgba(0, 0, 0, 0) 4px);
            background-size: 4px 4px;
            background-repeat: repeat-x;
            background-position: center bottom;
            margin-top: 20px;
            margin-bottom: 20px;
            width: 100%;
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
            text-decoration: none !important
        }

        .fw-style {
            font-size: 18px
        }

        #B,
        #C .PC-C-Contents,
        #D .Mb-D-Contents,
        .Mb-A-Contents,
        .Mb-B-Contents {
            filter: blur(10px);
            opacity: 0;
            transition: filter 1.5s ease-out, opacity 1.5s ease-out
        }

        .qty-inp {
            width: 25%;
        }

        @media (max-width:768px) {

            .container,
            .tab-menu {
                flex-direction: column
            }

            .product-details,
            .product-gallery,
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

            .qty-inp {
                width: 100%;
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

        .shape-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: flex-start;
        }

        .shape-options-two {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: start;
        }

        /* ซ่อน radio ดั้งเดิม */
        .shape-options input[type="radio"],
        .shape-options-two input[type="radio"] {
            display: none;
        }

        /* การ์ด */
        .shape-card {
            width: 115px;
            background: #e6f2f5;
            border: #f0f0f0 2px solid;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            padding: 10px;
        }

        .shape-card img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .shape-card span {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        /* เมื่อเลือก */
        .shape-options input[type="radio"]:checked+.shape-card,
        .shape-options-two input[type="radio"]:checked+.shape-card {
            border-color: #ffffff;
            background: #f7b516;
            color: white;
        }

        @media screen and (min-width: 298px) and (max-width: 331px) {

            .shape-options,
            .shape-options-two {
                justify-content: flex-start;
                gap: 10px;
            }

            .shape-card {
                width: 150px;
            }
        }

        @media screen and (min-width: 332px) and (max-width: 405px) {

            .shape-options,
            .shape-options-two {
                justify-content: flex-start;
                gap: 10px;
            }

            .shape-card {
                width: 100%;
                max-width: 150px;
            }
        }

        #cus_detail .table_rubber td:nth-child(2) input[type=text] {
            display: block;
        }

        #cus_detail .table_rubber td:nth-child(2) input[type=button] {
            display: inline;
        }

        #cus_detail .table_rubber td:nth-child(2) {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            align-items: stretch;
        }

        label.accordion-header span {
            max-width: 85%;
        }
    </style>

    <!-- lightbox2-master -->
    <link rel="stylesheet" href="css/lightbox.css">
    <!-- /lightbox2-master -->
</head>

<body id="top">
    <!-- :: header start :: -->
    <?php include("../../header.html");  ?>
    <!-- :: header end :: -->
    <!-- globalNavi -->
    <?php include("../../gnavi.php"); ?>
    <!-- globalNavi End -->
    <!-- :: wrapper start :: -->
    <div id="wrapper">
        <!-- sidemenu-->
        <?php include("../../sidenavi.php"); ?>
        <!-- sidemenu End -->
        <!-- :: content_wrapper start :: -->
        <div id="content_wrapper" class="scrollingPanel">
            <?php include("../rubber_info.php"); ?>
            <?php include('../banner-campaign.php') ?>
            <div id="">
                <h1 class="h1-new">PVCクリアマルチケース（2026年版）</h1>
                <div class="social-sns">
                    <p>シェアする</p>
                    <a href="//x.com/GoodsYe" target="_blank"><img src="/products/images/rubberstrap/v2/x-icon.webp" alt="" width="20px"></a>
                    <a href="//www.facebook.com/Hotmobily_jp-%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC-171871399585893" target="_blank"><img src="/products/images/rubberstrap/v2/Facebook-icon.webp" alt="" width="20px"></a>
                    <a href="https://www.instagram.com/hot.mobily/?hl=ja" target="_blank"><img src="/products/images/rubberstrap/v2/IG_icon.webp" alt="" width="20px"></a>
                    <p>更新日：2026年8月3日</p>
                </div>
            </div>
            <div class="container">
                <div class="product-gallery" id="">

                    <div class="pdp-v2-main-viewport">
                        <div class="pdp-v2-image-strip" id="pdp-v2-js-strip">
                        </div>
                    </div>

                    <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                    </div>

                    <div class="action-buttons">
                        <button class="btnz btn-orange" type="button" onclick="GotoDiv(1)" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background-color: #FF9900; border-color: #FF9900; margin-top: 10px; margin-bottom: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                            </svg>
                            この商品を見積・注文する
                        </button>
                    </div>
                </div>

                <div class="product-details" id="">
                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個686円（税込）</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">100個合計：</span>68,600円（税込）</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span class="" id="date_create2x1"></span></p>
                    </div>

                    <div class="">
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です。</small><br>
                        <small class="note"><a href="javascript:void(0)" onclick="GotoDiv(2)">納期の詳細をチェック</a></small><br>
                    </div>

                    <h2 class="promo-title" style="color: #cc3f44; !important;">実用性◎でサイズ感が可愛いPVCクリアマルチケース！</h2>

                    <div class="info-card">
                        <h3 class="lpc">最安単価420円（税込）！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(5)"><img src="images/new/pvc-case-price01.webp" alt="none" loading="lazy"></a>
                        <p class="new-text">大ロット製作ほどお得！1,000個製作の場合で1個あたりの製作料金が420円（税込）になります。</p>
                        <br>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(5)">制作料金の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">オリジナルデザインをフルカラー印刷！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(3)"><img src="images/new/PVCclearcase-2.jpg" alt="" loading="lazy"></a>
                        <p class="new-text">オリジナルのデザインをフルカラーで印刷可能。部分印刷も全面印刷もできます。</p>
                        <br>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(3)">印刷の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">ラメ加工・オーロラ加工をご用意！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(6)"><img src="images/new/pvc-case-type.webp" alt="" loading="lazy"></a>
                        <p class="new-text">本体にラメ加工・オーロラ加工が入ったタイプのPVCクリアマルチケースもご用意しております。</p>
                        <br>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" onclick="GotoDiv(6)" class="new-text" class="new-text">ラメ加工・オーロラ加工の詳細</a>
                        </div>
                    </div>

                </div>
            </div>

            <!--Accordion Store-->
            <div id="acc-store">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="store-toggle" class="accordion-input" checked>
                        <label for="store-toggle" class="accordion-header">
                            <span class="fw-bold">収納できて便利&楽しい！実用性と可愛いサイズ感が魅力</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div style="display: grid;gap: 8px;padding: 10px 0;background: #fff;grid-template-columns: repeat(2, 1fr);">
                                <div style="width: 100%;">
                                    <a href="images/new/050526_artboard 2.webp" data-lightbox="img-color-set-1" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                        <p class="fw-bold" style="text-align: center;"></p>
                                        <img src="images/new/050526_artboard 2.webp" alt="" loading="lazy" style="width: 100%;">
                                        <p>📷クリックすると拡大します</p>
                                    </a>
                                </div>
                                <div style="width: 100%;">
                                    <a href="images/new/050526_artboard 7.webp" data-lightbox="img-color-set-2" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                        <p class="fw-bold" style="text-align: center;"></p>
                                        <img src="images/new/050526_artboard 7.webp" alt="" loading="lazy" style="width: 100%;">
                                        <p>📷クリックすると拡大します</p>
                                    </a>
                                </div>
                            </div>
                            <br>
                            <p class="new-text">手のひらサイズでコロンとしたフォルムが愛らしい「PVCクリアマルチケース」。今、オリジナルグッズやノベルティとして大注目のアイテムです。毎日持ち歩く小物をすっきり収納できるだけでなく、お客様のこだわりデザインをプリントすれば、魅せる収納としても大活躍する特別なアイテムに仕上がります。</p>
                            <br>
                            <p class="new-text">リップクリームや目薬、ハンドクリームといったコスメ類をはじめ、ワイヤレスイヤホン、常備薬、さらには推しの小さなアクリルグッズなど、日常のちょっとした小物や推し活グッズを入れるのにぴったりなサイズ感が最大の魅力。散らかりがちな小物を整理しながら、サッと取り出せる実用性の高さは、一度使うと手放せなくなります。</p>
                            <br>
                            <p class="new-text">さらに当店のPVCクリアマルチケースは、バッグやリュック、ベルトループにチャーム感覚でぶら下げることが可能です。「バッグの中から探す」のではなく「バッグの外に飾る」という新しい楽しみ方ができ、可愛らしいサイズ感も相まって、ファッションのアクセントとしても大活躍します。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Store-->

            <!--Accordion Price-->
            <br>
            <div id="acc-price">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="price-toggle" class="accordion-input" checked>
                        <label for="price-toggle" class="accordion-header" id="price-g">
                            <span class="fw-bold">製作料金（税込）</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <p class="new-text">注文数量ごとの単価（税込）は以下になります。</p><br />
                            <div class="plan-section">
                                <p class="new-text">クリアタイプ・半透明タイプ・ラメタイプの数量別価格表（税込）</p>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table" style="width: 99%;">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">数量</th>
                                                <th class="fw-bold">価格</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>50</td>
                                                <td>756</td>
                                            </tr>
                                            <tr>
                                                <td>100</td>
                                                <td>686</td>
                                            </tr>
                                            <tr>
                                                <td>300</td>
                                                <td>498</td>
                                            </tr>
                                            <tr>
                                                <td>500</td>
                                                <td>477</td>
                                            </tr>
                                            <tr>
                                                <td>1000</td>
                                                <td>420</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <br>
                            <div class="prod-sched-scroll-box">
                                <p class="new-text">オーロラタイプの数量別価格表（税込）</p>
                                <table class="prod-sched-table" style="width: 99%;">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">数量</th>
                                            <th class="fw-bold">価格</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>50</td>
                                            <td>877</td>
                                        </tr>
                                        <tr>
                                            <td>100</td>
                                            <td>845</td>
                                        </tr>
                                        <tr>
                                            <td>300</td>
                                            <td>617</td>
                                        </tr>
                                        <tr>
                                            <td>500</td>
                                            <td>542</td>
                                        </tr>
                                        <tr>
                                            <td>1000</td>
                                            <td>523</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <a href="javascript:void(0)" onclick="GotoDiv(6)" class="new-text">各種タイプ（クリアタイプ・半透明タイプ・ラメタイプ・オーロラタイプ）の詳細</a>
                            <br><br>

                            <div class="prod-sched-scroll-box">
                                <p class="new-text">スナップボタン代金（税込）</p>
                                <table class="prod-sched-table" style="width: 99%;">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">スナップボタンタイプ</th>
                                            <th class="fw-bold">単価</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>プラスチック製</td>
                                            <td>無料</td>
                                        </tr>
                                        <tr>
                                            <td>金属製</td>
                                            <td>22</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <a href="javascript:void(0)" onclick="GotoDiv(7)" class="new-text">各種スナップボタンの詳細</a>
                            <br><br>
                            <p class="new-text">1,000個を超える個数のご注文については、個別に<a href="/contact" class="new-text">お問い合わせ</a>ください。</p>
                            <br>
                            <p class="new-text">製作には、AI形式の入稿データ（デザインデータ）が必要です。ご自身でデータを作成するのは難しい方向けに、データ作成補助サービス（税込2,200円）をご用意しております。お送り頂いたイラストや写真を元に、入稿データ作成を代行いたします。</p>
                            <br>
                            <p class="new-text">※データ作成補助サービスをご希望の方は、注文フォーム上で「データ作成補助」をご選択ください。また、入稿データのベースとなるデザイン（イラストや写真などのデータ）のアップロードを注文フォーム上でお願いいたします。注文時のデザインのアップロードが難しい場合は、メール等で後ほどお送り頂くことも可能です。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Price-->

            <!--Accordion Template-->
            <br>
            <div id="acc-data">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="template-toggle" class="accordion-input" checked>
                        <label for="template-toggle" class="accordion-header">
                            <span class="fw-bold">入稿データテンプレート</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <p class="new-text">
                                        入稿データをご自身で作成する方向けに、AI形式の入稿データテンプレートをご用意しております。アドビイラストレーターで編集可能です。
                                    </p>
                                    <br>
                                    <div style="display: flex; flex-direction: row; justify-content: center; width: 100%">
                                        <a class="btn-a btn-yellow" href="/products/pvc-clear-multi-case/template/clearmulticase_template_ol.zip" target="_blank" download><span><?= lang('テンプレートダウンロード') ?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Template-->

            <!--Accordion Shipping-->
            <br>
            <div id="acc-shipping">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="shipping-toggle" class="accordion-input" checked>
                        <label for="shipping-toggle" class="accordion-header">
                            <span class="fw-bold">納期</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <div style="display: flex">
                                        <p class="new-text">出荷予定日は、原稿確定日の12営業日後です。</p>
                                    </div>
                                    <table class="cld_tb">
                                        <tr class="cld_head">
                                            <td colspan="2"><?= lang('今、この製品を製作開始した場合の出荷日を表示中') ?></td>
                                        </tr>
                                        <tr class="cld_r1">
                                            <td><?= lang('原稿確定日') ?></td>
                                            <td><?= lang('出荷予定') ?></td>
                                        </tr>
                                        <tr class="cld_r2">
                                            <td><span id="date_create"></span></td>
                                            <td><span id="date_create2"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <br>
                                <p class="new-text">原稿確定日は、デザインや仕様の確認が完了し、制作開始となった日を指します。ご注文後、製品のデザインや仕様等についてのご連絡を当店営業からお客様へメールでお送りいたしますので、ご確認をお願いいたします。</p>
                                <br>
                                <a href="javascript:void(0)" onclick="GotoDiv(1)" class="new-text">注文フォームはこちら</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Shipping-->

            <!--Accordion Printing -->
            <br>
            <div id="acc-printing">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="printing-toggle" class="accordion-input" checked>
                        <label for="printing-toggle" class="accordion-header">
                            <span class="fw-bold">オリジナルデザインをフルカラー印刷！部分印刷も全面印刷も</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="images/new/PVCclearcase-1.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">当店のオリジナルPVCクリアマルチケースは、フルカラー印刷に完全対応しています。デザインのこだわりや用途に合わせて、部分印刷も全面印刷も可能です。下記のように幅広くご活用いただけます。</p>
                                <br>
                                <p class="new-text">・ケース本体にロゴや社名をすっきりと配置した、企業ノベルティやブランド記念品</p>
                                <p class="new-text">・ミニキャラクターやちびイラストをランダムに散りばめた、ポップで可愛い販売用グッズ</p>
                                <p class="new-text">・背景まで描き込まれた一枚絵のイラストや、アイドルの写真などを大胆に配置した推し活・アーティストグッズ</p>
                                <br>
                                <p class="new-text">部分印刷であれば、ケースの透明感を活かしたシースルーデザインに。全面印刷であれば、イラストや写真自体の持ち味を最大限にアピールするデザインに。表現力の幅が広い製品です。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Printing -->

            <!--Accordion Type-->
            <br>
            <div id="acc-type">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="type-toggle" class="accordion-input" checked>
                        <label for="type-toggle" class="accordion-header">
                            <span class="fw-bold">クリアタイプ・半透明タイプ・ラメタイプ・オーロラタイプをご用意！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <p class="new-text">当店のPVCクリアマルチケースは、ケース本体の加工が異なる4タイプがあります。透明なクリアタイプ、半透明タイプ、ラメを散りばめたラメタイプ、オーロラのような色合いのオーロラタイプの3タイプです。</p><br />

                            <div style="display: grid;gap: 12px;padding: 10px 0;background: #fff;grid-template-columns: repeat(2, 1fr);">
                                <a href="images/new/clear-pvc-case.webp" data-lightbox="img-color-set-1a" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                    <p class="fw-bold" style="text-align: center;">クリアタイプ</p>
                                    <img src="images/new/clear-pvc-case.webp" alt="クリアタイプ" loading="lazy" style="width: 100%;">
                                    <small>📷クリックすると拡大します</small>
                                </a>

                                <a href="images/new/translucent-pvc-case.webp" data-lightbox="img-color-set-1d" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                    <p class="fw-bold" style="text-align: center;">半透明タイプ</p>
                                    <img src="images/new/translucent-pvc-case.webp" alt="半透明タイプ" loading="lazy" style="width: 100%;">
                                    <small>📷クリックすると拡大します</small>
                                </a>
                            </div>

                            <div style="display: grid;gap: 12px;padding: 10px 0;background: #fff;grid-template-columns: repeat(2, 1fr);">
                                <a href="images/new/glitter-pvc-case.webp" data-lightbox="img-color-set-1b" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                    <p class="fw-bold" style="text-align: center;">ラメタイプ</p>
                                    <img src="images/new/glitter-pvc-case.webp" alt="ラメタイプ" loading="lazy" style="width: 100%;">
                                    <small>📷クリックすると拡大します</small>
                                </a>

                                <a href="images/new/aurora-pvc-case.webp" data-lightbox="img-color-set-1c" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                    <p class="fw-bold" style="text-align: center;">オーロラタイプ</p>
                                    <img src="images/new/aurora-pvc-case.webp" alt="オーロラタイプ" loading="lazy" style="width: 100%;">
                                    <small>📷クリックすると拡大します</small>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Type-->

            <!--Accordion Hatome-->
            <br>
            <div id="acc-hatome">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="hatome-toggle" class="accordion-input" checked>
                        <label for="hatome-toggle" class="accordion-header">
                            <span class="fw-bold">スナップボタンは2種類</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <p class="new-text">ケースの口を開け閉めするスナップボタンは、プラスチック製と金属製の2種類です。プラスチック製スナップボタンは無料、金属製スナップボタンは22円（単価／税込）です。</p>
                            <br>
                            <div style="display: grid;gap: 8px;padding: 10px 0;background: #fff;grid-template-columns: repeat(2, 1fr);">
                                <div style="width: 100%;">
                                    <a href="images/new/pvcclearcase_11.webp" data-lightbox="img-color-set-12" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                        <p class="fw-bold" style="text-align: center;">プラスチック製</p>
                                        <img src="images/new/pvcclearcase_11.webp" alt="" loading="lazy" style="width: 100%;">
                                        <p>📷クリックすると拡大します</p>
                                    </a>
                                </div>
                                <div style="width: 100%;">
                                    <a href="images/new/pvcclearcase_14.webp" data-lightbox="img-color-set-13" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                        <p class="fw-bold" style="text-align: center;">金属製</p>
                                        <img src="images/new/pvcclearcase_14.webp" alt="" loading="lazy" style="width: 100%;">
                                        <p>📷クリックすると拡大します</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Hatome-->

            <!--Accordion Attachment-->
            <br>
            <div id="acc-attachment">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="attachment-toggle" class="accordion-input" checked>
                        <label for="attachment-toggle" class="accordion-header">
                            <span class="fw-bold">アタッチメント</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <p class="new-text">下記3種類のアタッチメントをご用意しております。いずれも無料です。</p><br />

                            <div style="display: grid;gap: 12px;padding: 10px 0;background: #fff;grid-template-columns: repeat(3, 1fr);">
                                <a href="images/new/silver-snaphook-pvc.webp" data-lightbox="img-color-set-a1" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                    <p class="fw-bold" style="text-align: center;">銀色ナスカン</p>
                                    <img src="images/new/silver-snaphook-pvc.webp" alt="銀色ナスカン" loading="lazy" style="width: 100%;">
                                    <p>📷クリックすると拡大します</p>
                                </a>
                                <a href="images/new/silver-carabiner-pvc.webp" data-lightbox="img-color-set-a2" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                    <p class="fw-bold" style="text-align: center;">銀色カラビナ</p>
                                    <img src="images/new/silver-carabiner-pvc.webp" alt="銀色カラビナ" loading="lazy" style="width: 100%;">
                                    <p>📷クリックすると拡大します</p>
                                </a>
                                <a href="images/new/Silver-ballchain-pvc.webp" data-lightbox="img-color-set-a3" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                    <p class="fw-bold" style="text-align: center;">銀色ボールチェーン</p>
                                    <img src="images/new/Silver-ballchain-pvc.webp" alt="銀色ボールチェーン" loading="lazy" style="width: 100%;">
                                    <p>📷クリックすると拡大します</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Attachment-->


            <!-- Order Form -->
            <br>
            <div id="order-form">
                <?php include('../campaign_banner.php') ?>

                <h2 id="est-order">ご注文・見積書作成</h2>
                <div style="overflow: unset!important;">
                    <div class="fixed-contrainer">
                        <h3 class="red">【<?= lang('PVCクリアマルチケース') ?>】</h3>
                        <span class="total-price"><span class="prd_total">0</span>円（<?= lang('税込') ?>）</span>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
                        <div class="step-box">
                            <table class="table_rubber" style="padding: 0">
                                <tr>
                                    <td><?= lang('サイズ') ?></td>
                                    <td><span id="sample-prd-size">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('タイプ') ?></td>
                                    <td><span id="sample-prd-type">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('スナップボタン') ?></td>
                                    <td><span id="sample-prd-hatome">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('数量') ?></td>
                                    <td><span id="sample-prd-qty">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('試作品') ?></td>
                                    <td><span id="sample-prd-samp">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('データ作成補助') ?></td>
                                    <td><span id="sample-prd-trace">-</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img width="135" height="135" id="sample-part-pic" class="picpro" loading="lazy"><br />
                            <span id="sample-part-name"></span>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <!-- <img data-src="/products/acrylic/img/coming-soon.webp" width="135" height="135" id="sample-paper-pic" class="picpro lazy" loading="lazy"><br />台紙:<span id="sample-paper-name">なし</span> -->
                        </div>
                    </div>
                    <div class="step-container">
                        <div class="step-box step-list">
                            <ul>
                                <li id="dot-step1" class="active">
                                    <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ・裏面印刷') ?></span>
                                </li>
                                <li id="dot-step2">
                                    <div class="step-number">2</div><span class="step-details"><?= lang('アタッチメント・台紙等') ?></span>
                                </li>
                                <li id="dot-step3">
                                    <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
                        <div style="display: table-column;"><input type="text" name="ItemType" id="strap" value="PVCクリアマルチケース" /></div>
                        <?php
                        switch ($ItemPCS) {
                            case "スタンダード":
                                $lsSelected_1pcs = 'checked';
                                break;
                            case "スタンダード（スピード7営業日発送）":
                                $lsSelected_4pcs = 'checked';
                                break;
                        }
                        switch ($ItemSize) {
                            case "通常（80*80/3mm厚）":
                                $tickness0_checked = 'checked';
                                break;
                            case "ハイインパクト（80*80/5mm厚）":
                                $tickness1_checked = 'checked';
                                break;
                            default:
                                $tickness0_checked = 'checked';
                                break;
                        }
                        switch ($SendPrototype) {
                            case "なし":
                                $noNeed_checked = 'checked';
                                break;
                            case "あり":
                                $sendActual_checked = 'checked';
                                break;
                        }
                        switch ($DeFormat) {
                            case "なし":
                                $illus_checked = 'checked';
                                break;
                            case "あり":
                                $others_checked = 'checked';
                                break;
                        }
                        switch ($silk_print) {
                            case "裏面印刷なし":
                                $printing1_checked = 'checked';
                                break;
                            case "裏面印刷あり":
                                $printing2_checked = 'checked';
                                break;
                            case "フルカラー印刷":
                                $printing3_checked = 'checked';
                                break;
                        }
                        switch ($coating) {
                            case "汚れ防止加工なし":
                                $coating0_checked = 'checked';
                                break;
                            case "汚れ防止加工あり":
                                $coating1_checked = 'checked';
                                break;
                        }

                        switch ($ItemMaterial) {
                            case "特殊素材なし":
                                $material0_checked = 'checked';
                                break;
                            case "特殊素材あり":
                                $material1_checked = 'checked';
                                break;
                            default:
                                $material0_checked = 'checked';
                                break;
                        }

                        switch ($ItemDesignVariation) {
                            case "1種類":
                                $lsSelected_1design = 'checked';
                                break;
                            case "2種類":
                                $lsSelected_2design = 'checked';
                                break;
                            case "3種類":
                                $lsSelected_3design = 'checked';
                                break;
                            case "4種類":
                                $lsSelected_4design = 'checked';
                                break;
                            case "5種類":
                                $lsSelected_5design = 'checked';
                                break;
                            default:
                                $lsSelected_1design = 'checked';
                                break;
                        }

                        switch ($ItemDesignRepeat) {
                            case "いいえ":
                                $RepeatSelected_1 = 'checked';
                                $RepeatStyle_1 = 'display:block;';
                                $RepeatStyle_2 = 'display:none;';
                                break;
                            case "はい":
                                $RepeatSelected_2 = 'checked';
                                $RepeatStyle_2 = 'display:block;';
                                $RepeatStyle_1 = 'display:none;';
                                break;
                            default:
                                $RepeatSelected_1 = 'checked';
                                $RepeatStyle_1 = 'display:block;';
                                $RepeatStyle_2 = 'display:none;';
                                break;
                        }
                        ?>
                        <div class="estimate-content" id="step1">
                            <h3>以前のご注文と同じデザインでの製作ですか？</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="いいえ" onclick="$('.repeat').hide();" <?= $RepeatSelected_1 ?>>いいえ <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="はい" onclick="$('.repeat').show();" <?= $RepeatSelected_2 ?>>はい<span class="checkmark"></span></label>
                                </div>
                            </div>

                            <div class="repeat" style="<?= $RepeatStyle_2 ?>">
                                <h3>前回ご注文の管理番号等がもしおわかりでしたら、ご入力ください。</h3>
                                <div class="part-container">
                                    <div class="part-content">
                                        <label class="part-name">
                                            <input style="width:100%; height:100%; padding:3px;" type="text" name="design_no" value="<?= $design_no ?>">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <?php include('../../delivery_note.php'); ?>
                            <?php include('../alert-btn.php') ?>

                            <h3><?= lang('タイプ') ?></h3>
                            <div class="part-container">
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemCat" value="クリアタイプ" <?= ($ItemCat == 'クリアタイプ' ? 'checked' : '') ?> onclick="clearValue();" />クリアタイプ <span class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemCat" value="半透明タイプ" <?= ($ItemCat == '半透明タイプ' ? 'checked' : '') ?> onclick="clearValue();" />半透明タイプ <span class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemCat" value="ラメタイプ" <?= ($ItemCat == 'ラメタイプ' ? 'checked' : '') ?> onclick="clearValue();" />ラメタイプ <span class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemCat" value="オーロラタイプ" <?= ($ItemCat == 'オーロラタイプ' ? 'checked' : '') ?> onclick="clearValue();" />オーロラタイプ <span class="checkmark"></span></label></div>
                                <span style="color: red" id="error_cat"></span>
                            </div>

                            <h3><?= lang('スナップボタン') ?></h3>
                            <div class="part-container">
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="プラスチック製スナップボタン" <?= ($ItemMaterial == 'プラスチック製スナップボタン' ? 'checked' : '') ?> onclick="clearValue();" /><?= lang('プラスチック製スナップボタン') ?> <span class="checkmark"></span></label></div>
                                <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="金属製スナップボタン" <?= ($ItemMaterial == '金属製スナップボタン' ? 'checked' : '') ?> onclick="clearValue();" /><?= lang('金属製スナップボタン') ?> <span class="checkmark"></span></label></div>
                                <span style="color: red" id="error_mat"></span>
                            </div>

                            <h3><?= lang('ご注文本数') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="numberOf" id="no_of_order" class="right qty-inp" onchange="this.value=format_number(this.value);" value="<?php echo $numberOf ?>" style="text-align: right;"><br /></label>
                                    <div id="err_numberOf_mess"></div>
                                </div>
                            </div>
                            <span style="color: red" id="error_message"></span>
                        </div>
                        <div class="estimate-content" id="step2">
                            <h3><?= lang('アタッチメント') ?></h3>
                            <div id="error_part" style="color:red"></div>
                            <div class="flex-container">
                                <div class="preview-container">
                                    <div class="preview-sub flex-container">
                                        <?php include('part.php');
                                        $i = 0;
                                        for ($i = 0; $i < count($attachment); $i++) {
                                            echo '
                                                    <div class="flex-item">
                                                        <label class="part-name">
                                                            <input type="radio" name="part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($part == $attachment[$i]["part_name"] ? 'checked' : '') . '>
                                                            <img data-src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="picpro lazy" loading="lazy">
                                                            <br><span class="part_price_std">+' . ($attachment[$i]["part_price"] * 1.1) . '円</span><span class="part_price_prm"></span>
                                                        </label>
                                                    </div>';
                                        } ?>
                                    </div>
                                </div>
                            </div>

                            <h3><?= lang('試作品') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='SendPrototype'>
                                            <input type="checkbox" class="checkbox" name="SendPrototype" value="あり" onclick="setToInput();" <?= $sendActual_checked ?>>
                                            <div class="knobs"><span></span></div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('試作品') ?>
                                    </label>
                                </div>
                            </div>

                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='DeFormat'>
                                            <input type="checkbox" class="checkbox" name="DeFormat" value="あり" onclick="setToInput();"
                                                <?= $others_checked ?>>
                                            <div class="knobs"><span></span></div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('データ作成補助【2,200円(税込)】') ?>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="estimate-content flex-item" id="step3">
                            <div class="flex-container">
                                <div class="flex-item">
                                    <h3><?= lang('製品仕様') ?></h3>
                                    <table class="table_rubber">
                                        <tbody>
                                            <tr>
                                                <td class="TableLeft"><?= lang('サイズ') ?></td>
                                                <td class="" id="prd_ItemSize" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('タイプ') ?></td>
                                                <td class="" id="prd_ItemCat" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('スナップボタン') ?></td>
                                                <td class="" id="prd_ItemMat" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('数量') ?></td>
                                                <td class="" id="prd_qty" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td class="" id="prd_part" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td class="" id="prd_SendPrototype" style="text-align: left;">なし</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                <td class="" id="prd_DeFormat" style="text-align: left;">なし</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex-item">
                                    <h3><?= lang('製作料金') ?></h3>
                                    <table class="table_rubber total_price_tbl">
                                        <tbody>
                                            <tr>
                                                <td class="TableLeft"><?= lang('商品代金') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="StrapPrice" readonly="readonly" id="textfield7" class="right" value="<?= $StrapPrice ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('スナップボタン') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="HatomePrice" readonly="readonly" id="textfield12" class="right" value="<?= $HatomePrice ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="ProShipping" readonly="readonly" id="textfield3" class="right" value="<?= $ProShipping ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="TraceCharge" readonly="readonly" id="textfield4" class="right" value="<?= $TraceCharge ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('小計(税込)') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="BeforeTax" readonly="readonly" id="textfield9" class="right" value="<?= $BeforeTax ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('お値引き') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="discount" readonly="readonly" id="textfield_dis" class="right" value="<?= $discount ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('合計(税込)') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16" name="grandTotal" readonly="readonly" id="textfield11" class="right" value="<?= $grandTotal ?>">円</td>
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
                                                <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="clearValue();$('#cus_detail').hide();valid_chk_btn('step1');" />
                                                <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                                                <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step2');$('#cus_detail').hide();"><?= lang('ｱﾀｯﾁﾒﾝﾄ修正') ?></a>
                                                <input type="button" class="btn est-btn flex-item" value="<?= lang('見積書') ?>" id="button_pdf2" onclick="$('#cus_detail').toggle()" />
                                                <input type="button" class="btn ord-btn flex-item" value="<?= lang('ご注文情報入力へ') ?>" for="modal-ord" onclick="$('#modal-ord').prop('checked',true)" />
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
                                            <source media="(max-width:650px)" srcset="/img/delivery_10days_notice_mb.jpg" style="width: 100%;">
                                            <img src="/img/delivery_10days_notice.jpg" alt="Flowers" style="width:100%;" loading="lazy">
                                        </picture>
                                        <input type="button" class="btn btn-back flex-item" value="<?= lang('OK') ?>" for="modal-ord" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form); " />
                                    </diV>

                                </div>
                            </div>
                        </div>
                        <div id="acrylic-btn" class="btn-container">
                            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn('back')">戻る</a>
                            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')">アタッチメント・オプション入力へ</a>
                        </div>
                    </form>
                    <div id="cus_detail" style="display: none;" align="center">
                        <table class="table_rubber" style="display: table;">
                            <tbody>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（姓）') ?></td>
                                    <td class=""><input name="Name_S" id="sname" type="text" maxlength="100" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（名）') ?></td>
                                    <td class=""><input name="Name_F" id="fname" type="text" maxlength="100" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('法人名') ?></td>
                                    <td class=""><input name="Corp_Name" id="Corp_Name" type="text" value="" size="45" maxlength="100"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('郵便番号') ?></td>
                                    <td class=""><input type="text" id="zip" name="zip" maxlength="8" size="15" value="">&nbsp;<input type="button" id="src_btn" onclick="address_fn();" value="<?= lang('住所に変換') ?>"><br><span id="error" style="color:red"></span></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('都道府県') ?></td>
                                    <td class=""><input type="text" id="address1" name="prefc" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('以降の住所') ?></td>
                                    <td class=""><input id="address2" name="address" type="text" class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('番地、建物名、部屋番号') ?></td>
                                    <td class=""><input id="address_street" name="address_street" type="text" class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('TELハイフンなし') ?></td>
                                    <td class=""><input name="tel" id="tel" type="text" maxlength="11" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お客様メモ欄') ?></td>
                                    <td class=""><input name="comment" id="comment" type="text" size="45" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="padding: 10px;background: unset;border: unset;">
                                        <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="Javascript:validate('gcd');$('.loading').show();" value="<?= lang('御社情報確定（PDF出力）') ?>" />
                                        <div class="remark">&nbsp;<?= lang('※社名や会社名の入力は任意です') ?></div><span id="validate_error" style="color:red"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Order Form -->

            <!--Accordion Short -->
            <br>
            <div id="acc-short">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="short-toggle" class="accordion-input" checked>
                        <label for="short-toggle" class="accordion-header">
                            <span class="fw-bold">圧倒的な短納期でお届け！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="images/new/pvc-case-speed.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">他社では製作に一か月かかることもあるPVCクリアマルチケースが、当店であればデザイン確定の12営業日後に出荷可能です。「再来週のイベントに間に合わせないといけない」「できるだけ早く手元にほしい」などのご要望に、できる限りお応えいたします。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Short -->

            <!--Accordion Practicality -->
            <br>
            <div id="acc-practicality">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="practicality-toggle" class="accordion-input" checked>
                        <label for="practicality-toggle" class="accordion-header">
                            <span class="fw-bold">水や汚れに強くコンパクト！実用性抜群！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="images/new/pvc-case-water.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">屋外で持ち歩くことが想定されるグッズだからこそ、デザインだけでなく「日常での使いやすさ」や「タフさ」も絶対に譲れないポイントですよね。このPVCクリアマルチケースに採用されているPVC素材は、優れた耐水性と防汚性を兼ね備えています。</p>
                                <br>
                                <p class="new-text">洗面所など水回りへの持ち込みはもちろんのこと、雨の日の外出時や海・プール、夏の野外フェスといったアクティブなアウトドアシーンでも安心して持ち歩くことが可能です。水しぶきが飛んできたりプールへ落としてしまったりしても、ケースのデザインがはがれたり本体が傷んだりすることはありません。砂や泥などで汚れても、サッとふくだけで落とすことができます。可愛らしいサイズ感やプリントしたイラストや写真で魅力をアピールできるだけでなく、「水に濡れても安心」「汚れてもサッときれいにできる」という高い実用性と安心感があるからこそ、受け取った方に「本当に使えるアイテム」として長く愛用され続ける特別なオリジナルグッズになります。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Practicality -->

            <!--Accordion Clear -->
            <br>
            <div id="acc-clear">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="clear-toggle" class="accordion-input" checked>
                        <label for="clear-toggle" class="accordion-header">
                            <span class="fw-bold">部分印刷なら中身が見えて便利！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div style="display: grid;gap: 12px;padding: 10px 0;background: #fff;grid-template-columns: repeat(2, 1fr);">
                                    <a href="images/new/pvc-clear-multi-case03.webp" data-lightbox="img-flow-set-b1" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                        <img src="images/new/pvc-clear-multi-case03.webp" alt="" width="100%" loading="lazy">
                                        <p>📷クリックすると拡大します</p>
                                    </a>
                                    <a href="images/new/050526_artboard 8.webp" data-lightbox="img-flow-set-c1" style="width: 100%;display: block;color: black;text-decoration: none!important;">
                                        <img src="images/new/050526_artboard 8.webp" alt="" width="100%" loading="lazy">
                                        <p>📷クリックすると拡大します</p>
                                    </a>
                                </div>
                                <br>
                                <p class="new-text">ロゴをワンポイントに印刷したり小さなキャラクターたちを散りばめたりするデザインであれば、ケースの中に何が入っているのかが一目でわかります。ケースを開けることなく、外からサッと視線を落とすだけで瞬時に中身を確認できるので、「あのリップクリームは持ったっけ？」などのようなお出かけ前の確認にかかる時間を減らすことができます。</p>
                                <br>
                                <p class="new-text">お気に入りのキャラクターグッズなどをケースに入れて持ち運ぶのであれば、ケースに入った自分の推しの姿をいつでも確認できる最高の推し活グッズにもなります。</p>
                                <br>
                                <p class="new-text">さらに、ケースの中身が見えることを前提とした遊び心のあるデザインで製作することも可能です。窓枠のようなデザインを印刷して中身を主役にしたり、キャラクターが中身を覗き込んでいるような配置にしたりと、アイデア次第で楽しみ方は無限に広がります。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Clear -->

            <!--Accordion Use -->
            <br>
            <div id="acc-use">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="use-toggle" class="accordion-input" checked>
                        <label for="use-toggle" class="accordion-header">
                            <span class="fw-bold">推し活グッズや企業ノベルティなど活用方法いろいろ！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="images/new/pcc-case-various.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">PVCクリアマルチケースは、昨今話題の推し活グッズやブランディングに重要な企業ノベルティとして、高いポテンシャルを秘めた製品です。</p>
                                <br>
                                <h3 class="h3-new fs-bold">推し活グッズに最適！</h3>
                                <p class="new-text">PVCクリアマルチケースは、推し活グッズとしても人気・定番のグッズです。クリア素材のためケースの中身がいつでも見えるうえに、リュックや鞄に取り付けることができ、雨などを気にせず屋外に持ち出すことができるので、推しグッズを持ち歩きたいファンたちに大人気。推しキャラのアクリルキーホルダーはもちろん、推しキャラのデザインが入ったコスメやワイヤレスイヤホンなど、推し活関連のグッズを目に見えるかたちで持ち歩くのに最適なグッズです。</p>
                                <br>
                                <p class="new-text">推し活を想定して、ケースの中身を際立たせる額縁などのデザインをケースに印刷するのも選択肢のひとつです。もちろん、推し活向けに人気のキャラクターやアイドルそのものをプリントするのもあり。推し活グッズとして幅広く活用できる製品です。</p>
                                <br>
                                <h3 class="h3-new fs-bold">企業ノベルティとして活躍！</h3>
                                <br>
                                <p class="new-text">PVCクリアマルチケースは、企業ノベルティとしても活用できる製品です。たとえば、女性向けブランドの立ち上げの際にブランドロゴを入れたPVCクリアマルチケースを配布すれば、「見せるコスメ収納」として使用してもらうことで、ブランディング効果を期待できるでしょう。他にも、ワイヤレスイヤホンなどスマホ関連のグッズの収納を想定して家電量販店で配布したり、常備薬やヘアピンの収納を想定してドラッグストアで配布したりすることもできます。</p>
                                <br>
                                <p class="new-text">収納機能があり、リュックや鞄に付けて持ち歩くことが想定されるPVCクリアマルチケースは、ユーザーに利便性を提供しながら自社ブランディングをすることができるとっておきのグッズです。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Use -->

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
                                            <td><?= lang('名称') ?></td>
                                            <td style="text-align: left;"><?= lang('PVCクリアマルチケース') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('素材') ?></td>
                                            <td style="text-align: left;"><?= lang('PVC') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('サイズ') ?></td>
                                            <td style="text-align: left;"><?= lang('60mm×110mm') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('印刷方法') ?></td>
                                            <td style="text-align: left;"><?= lang('UVフルカラー印刷') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('アタッチメント') ?></td>
                                            <td style="text-align: left;"><?= lang('銀色ナスカン／銀色カラビナ／銀色ボールチェーン') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('スナップボタン') ?></td>
                                            <td style="text-align: left;"><?= lang('プラスチック製／金属製') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('試作品') ?></td>
                                            <td style="text-align: left;"><?= lang('無料／9営業日後出荷') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('最小ロット') ?></td>
                                            <td style="text-align: left;"><?= lang('50個') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('包装') ?></td>
                                            <td style="text-align: left;">OPP袋個包装</td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('納期') ?></td>
                                            <td style="text-align: left;">12営業日後</td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('特徴') ?></td>
                                            <td style="text-align: left;">クリアタイプ／半透明タイプ／ラメタイプ／オーロラタイプ</td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('注意点') ?></td>
                                            <td style="text-align: left;">白引きなしのデザインの印刷濃度は、製作前にお渡しする図面と実物とで見え方が大きく異なる場合がございます。量産前の試作品製作をおすすめしております。／クリアタイプ・半透明タイプ・ラメタイプは生地のカット面を丸く加工しておりますが、オーロラタイプは生地の特性上加工なしとなっております。</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Spec-->

            <!-- Section Meeting -->
            <br>
            <div id="meeting">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="meeting-toggle" class="accordion-input" checked>
                        <label for="meeting-toggle" class="accordion-header">
                            <span class="fw-bold">御社にお伺いします！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <a href="//hotmobily.jp/meeting_date/"><img data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" class="lazy" /></a>
                            <br><br>
                            <p class="new-text">対面やZoom等でのご相談をご希望の法人様向けに、当店営業の呼出フォームをご用意しております。「仕様や納期についてまずは話を聞きたい」「希望のデザインができるのか確かめたい」といったご希望のある法人様は、ぜひご活用ください。</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Meeting -->


            <div id="pdp-v2-modal" class="pdp-v2-modal-overlay">
                <div class="pdp-v2-modal-container">
                    <span class="pdp-v2-modal-close">&times;</span>
                    <img class="pdp-v2-modal-content" id="pdp-v2-modal-img" alt="Zoomed view">

                    <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>


        </div>
        <!-- :: content_wrapper end :: -->
    </div>
    <!-- :: wrapper end :: -->
    <!--フッター ここから-->
    <?php include("../../footer.php"); ?>
    <!--フッター ここまで-->
    <!-- /lightbox2-master -->
    <script src="../js/lightbox.js"></script>
    <script src="/js/swiper.min.js"></script>
    <script>
        lightbox.option({
            'maxWidth': 800,
            'maxHeight': 800,
            'alwaysShowNavOnTouchDevices': true
        });
    </script>
    <!-- /lightbox2-master -->
    <!-- google script -->
    <!-- リマーケティング タグの Google コード -->
    <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->
    <!-- Swiper JS -->
    <script type="text/javascript" src="/js/_setToInput_2026_pvc_clear_case.js?v=<?php echo date('is') ?>"></script>
    <script language="JavaScript" src="/js/validation_new.js?v=1.11" type="text/javascript"></script>
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.17"></script>
    <script type="text/javascript" src="/products/js/date.js"></script>
    <script type="text/javascript" src="<?= $pdf_rubber_js_ver2 ?>"></script>
    <script>
        $(document).ready(function() {
            let params = '<?php echo (isset($_GET['sec']) ? $_GET['sec'] : "") ?>';
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

            const imageList = [{
                    src: "images/new/pvc-clear-multi-case01.webp",
                    targetId: "processing",
                    alt: "ラバーストラップ制作事例（ケモ耳女の子キャラ）"
                },
                {
                    src: "images/new/pvc-clear-multi-case02.webp",
                    targetId: "special",
                    alt: "ラバーストラップ制作事例（文字デザイン）"
                },
                {
                    src: "images/new/pvc-clear-multi-case03.webp",
                    targetId: "plans",
                    alt: "ラバーストラップ制作事例（キャラクター）"
                },
                {
                    src: "images/new/pvc-clear-multi-case04.webp",
                    targetId: "production",
                    alt: "ラバーストラップ制作事例（女の子キャラ）"
                },
                {
                    src: "images/new/pvc-clear-multi-case05.webp",
                    targetId: "production",
                    alt: "ラバーストラップ制作事例（ロゴ）"
                },
                {
                    src: "images/new/pvc-clear-multi-case06.webp?v=1",
                    targetId: "production",
                    alt: "ラバーストラップ制作事例（キャラクターと文字）"
                }
            ];

            let pdpCurrentIdx = 0;
            let pdpTimer;
            const isMobile = window.innerWidth < 768;

            function initGallery() {
                // Create fragments to minimize Reflows
                const stripFragment = document.createDocumentFragment();
                const gridFragment = document.createDocumentFragment();
                const zoomSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>';

                imageList.forEach((item, i) => {
                    // Build Main Strip
                    const mainContainer = document.createElement('div');
                    mainContainer.className = 'pdp-v2-main-link';

                    // Use template literal for speed
                    mainContainer.innerHTML = `
                <div class="pdp-v2-zoom-icon">${zoomSVG}</div>
                <img src="${item.src}" alt="${item.alt}" loading="" class="pdp-v2-slide-img">
            `;
                    // Add event directly
                    mainContainer.onclick = () => openModal(i);
                    stripFragment.appendChild(mainContainer);

                    // Build Thumbnails
                    const thumbImg = document.createElement('img');
                    thumbImg.src = item.src;
                    thumbImg.alt = item.alt;
                    thumbImg.loading = '';
                    thumbImg.className = 'pdp-v2-thumb-item' + (i === 0 ? ' pdp-v2-active-state' : '');

                    thumbImg.onclick = () => {
                        updateGalleryView(i);
                        restartAutoTimer();
                    };
                    gridFragment.appendChild(thumbImg);
                });

                if (elements.pdpStrip) elements.pdpStrip.appendChild(stripFragment);
                if (elements.pdpGrid) elements.pdpGrid.appendChild(gridFragment);

                if (elements.pdpGrid) elements.pdpGrid.classList.remove('is-hidden');
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
                    elements.modalImg.src = imageList[index].src;
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
                    elements.modalImg.src = imageList[pdpCurrentIdx].src;
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

                // Initial State (Apply via JS to ensure CSS matches)
                targets.forEach(sel => {
                    $(sel).css({
                        "filter": "blur(10px)",
                        "opacity": "0",
                        "transform": "translateY(50px)",
                        "transition": "all 0.8s ease-out"
                    });
                });

                // Loop with staggered delays
                targets.forEach((selector, index) => {
                    setTimeout(() => {
                        $(selector).css({
                            "filter": "blur(0px)",
                            "opacity": "1",
                            "transform": "translateY(0)"
                        });
                    }, index * 200 + 100); // 200ms stagger
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
                $priceTbl.load("../getdate_disp2023-printed", function(data) {
                    $(this).replaceWith(data);
                    $('.tbl_price_deli').removeClass("loading");
                });
            }

            // Check Holiday
            $.post("/products/check_holiday.php", {
                "product": "12days"
            }, function(data) {
                if (typeof productionDate === 'function') productionDate(data.sort());
            }, "json");

            // Get Sample Date
            // $.post("../get_sample_date.php", {
            //     'days': '7',
            //     'format_cal': '12'
            // }, function(data) {
            //     $('.speed_deli_date').html(formatDate(data[1]) + "<br/><div class='ut_date'>7日</diV>");
            //     $('.speed_deli_date2').html(formatDate(data[2]) + "<br/><div class='ut_date'>13日</diV>");
            //     if (typeof productionDate3 === 'function') productionDate3(data.sort());
            // }, "json");

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
            //runEntranceAnimations();

            // Dynamic Text Updates
            var tmp = "<?= $_GET['mode'] ?? '' ?>"; // Safety check for PHP
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
                    3: '#acc-printing',
                    4: '#acc-options',
                    5: '#acc-price',
                    6: '#acc-type',
                    7: '#acc-hatome',
                };
                em = map[no];
                if (no == 2) openShippingAccordion();
                if (no == 3) openPrintingAccordion();
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

        function openPrintingAccordion() {
            $('#print-toggle').prop('checked', true);
            document.getElementById('acc-print')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    </script>
    </script>
    <script type="text/javascript" src="/js/common.js?v=1.02"></script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tbl_s").on("click scroll", function() {
                $(this).find(".scroll-center").hide();
            });
        });
    </script>
    <noscript>
        <div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
        </div>
    </noscript>
</body>

</html>