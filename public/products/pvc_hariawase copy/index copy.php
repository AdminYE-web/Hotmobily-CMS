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
    <meta name="keywords" content="オリジナル,印刷ラバーストラップ,印刷ラバーキーホルダー,製作,1個,最安,最短,短納期,イラスト,写真,ロゴ">
    <meta name="description" content="ぷっくりとした厚みとツヤが可愛いオリジナル立体シール（キャンディシール）を制作！面倒な入稿データの作成代行が無料。最安1個278円〜、500個から作成可能。キャラクターグッズ、推し活グッズ、企業の販促・ノベルティに最適。お気軽にご相談から。">
    <meta name="robots" content="index,follow" />
    <title>3D立体チャーム</title>
    <link rel="canonical" href="https://hotmobily.jp/products/3d-rubber/">
    <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
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

        .h3-new {
            width: 100% !important;
            font-size: 17px !important;
            letter-spacing: 0.05em !important;
            padding: 13px 10px !important;
            background-image: repeating-linear-gradient(90deg, rgba(255, 165, 0, 1) 0, rgba(255, 165, 0, 1) 2px, rgba(0, 0, 0, 0) 2px, rgba(0, 0, 0, 0) 4px);
            background-size: 4px 4px;
            background-repeat: repeat-x;
            background-position: center bottom;
            margin-top: 20px;
            margin-bottom: 20px;
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

        .side_link {
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
            filter: blur(10px);
            opacity: 0;
            transition: filter 1.5s ease-out, opacity 1.5s ease-out
        }

        .qty-inp {
            width: 25%;
        }

        #date_create_11day_1,
        #date_create_11day_2,
        #date_create_12day_1,
        #date_create_12day_2,
        #date_create_15day_1,
        #date_create_15day_2,
        #date_create_16day_1,
        #date_create_16day_2 {
            font-size: 22px;
            font-weight: bold;
            color: red;
            letter-spacing: -1px;
            overflow: hidden;
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

        /* กล่องครอบที่จำกัดความสูงเริ่มต้นไว้ */
        .exc_pro {
            max-height: 325px;
            position: relative;
            overflow: hidden;
            padding-bottom: 70px;
        }

        /* จัด Flex ให้แถวแสดง 3 คอลัมน์เหมือนหน้า acrylic */
        .exc_pro .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin: 0 -5px;
        }

        .exc_pro .mt-10-part {
            min-width: 33.333%;
            max-width: 33.333%;
            width: 33.333%;
            padding: 0 5px;
            box-sizing: border-box;
            text-align: center;
            margin-bottom: 15px;
        }

        .exc_pro .mt-10-part div {
            text-align: center;
        }

        /* สไตล์รูปภาพพาร์ท */
        .picpro {
            border: 1px solid #d3d3d3;
            box-shadow: 1px 1px 5px #d3d3d3;
            margin: 5px auto;
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* ปุ่ม 'ดูเพิ่มเติม' ที่ลอยอยู่ด้านล่าง */
        .read-more1 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 10px 0 2px;
            z-index: 10;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.85) 35%, #ffffff 100%);
        }

        .read-more1 .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 266px;
            height: 40px;
            background: linear-gradient(to bottom, #ffffff 0%, #f7f7f7 50%, #e6e6e6 100%);
            border: 1px solid #ccc;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            color: #333;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            box-sizing: border-box;
        }

        .read-more1 .btn:hover {
            background: linear-gradient(to bottom, #f9f9f9 0%, #ececec 50%, #dadada 100%);
            color: #000;
        }

        .read-more1 .btn img.btn_z {
            display: block;
            width: 266px;
            height: 40px;
            border-radius: 6px;
        }

        /* Responsive สำหรับมือถือ */
        @media (max-width: 576px) {
            .exc_pro .mt-10-part {
                min-width: 33.333%;
                max-width: 33.333%;
                width: 33.333%;
            }
        }
    </style>

    <!-- lightbox2-master -->
    <link rel="stylesheet" href="../css/lightbox.css">
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
                <h1 class="h1-new">3D立体チャーム（2026年版）</h1>
                <div class="social-sns">
                    <p>シェアする</p>
                    <a href="//x.com/GoodsYe" target="_blank"><img src="/products/images/rubberstrap/v2/x-icon.webp" alt="" width="20px"></a>
                    <a href="//www.facebook.com/Hotmobily_jp-%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC-171871399585893" target="_blank"><img src="/products/images/rubberstrap/v2/Facebook-icon.webp" alt="" width="20px"></a>
                    <a href="https://www.instagram.com/hot.mobily/?hl=ja" target="_blank"><img src="/products/images/rubberstrap/v2/IG_icon.webp" alt="" width="20px"></a>
                    <p>更新日：2026年8月31日</p>
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
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個797円</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">1000個合計金額: </span>797,000円/p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span class="" id="date_create2x1"></span></p>
                    </div>

                    <div class="">
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です</small><br><a href="javascript:void(0)" class="" onclick="GotoDiv(2)">納期詳細はこちら</a>
                    </div>

                    <h2 class="promo-title" style="color: #cc3f44; !important;">明瞭価格で立体キーホルダー・立体フィギュアをご製作！</h2>

                    <div class="info-card">
                        <h3 class="lpc">最安単価556円（税込）！明瞭価格！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(5)"><img src="/products/candysticker/images/candy-stickers-banner-01.webp" alt="ぷくぷく立体シールの価格" loading="lazy"></a>
                        <p class="new-text">最安単価が556円（税込）！大ロットほど単価が安くなりお得です。明瞭価格も嬉しいポイント。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(5)" style="color: black;">立体ラバーの詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">選べるアタッチメント！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(6)"><img src="/products/candysticker/images/3D-stickers_banner-2.webp" alt="オリジナルデザインでぷくぷく立体シール製作" loading="lazy"></a>
                        <p class="new-text">キーリングやボールチェーンなど、各種アタッチメントを付けられます！</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(6)" style="color: black;">アタッチメントの詳細</a>
                        </div>
                    </div>

                    <!-- <div class="info-card">
                        <h3 class="lpc">入稿データ作成補助がゼロ円！</h3>
                        <img src="/products/candysticker/images/blank.png" alt="" loading="lazy">
                        <p class="new-text">シール製作の際に大変なのがデザインデータの作成です。当店ではお客様から頂いたロゴやキャラクターを元に入稿データの作成を無料で代行いたします！</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(7)" style="color: black;">デザインデータ作成補助の詳細</a>
                        </div>
                    </div> -->

                </div>
            </div>


            <!--Accordion Candy -->
            <br>
            <div id="acc-candy">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="candy-toggle" class="accordion-input" checked>
                        <label for="candy-toggle" class="accordion-header">
                            <span class="fw-bold">立体キーホルダーや立体フィギュアを明瞭価格でご製作！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/candysticker/images/candy-stickers-banner-03.webp" alt="オリジナルデザインでキャンディシール製作" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">キャラクターやマスコットのオリジナルグッズ製作でぜひ検討したいのが、キャラの魅力的な姿を立体的に表現する立体キーホルダーや立体フィギュアです。当店では、キャラクターやマスコット、動物、乗り物、商品モチーフなどを立体的に表現した立体ラバーキーホルダーや立体ラバーフィギュアの製作を承っています。キャラクターの顔立ちや髪型、服装、ポーズ、商品の特徴的なフォルムなどを、厚みや凹凸で立体的に表現できます。アクリルキーホルダーなど平面的なグッズよりも存在感があり、企業ノベルティや販売用グッズ、イベントグッズ、周年記念品、店舗のオリジナル商品など、幅広い用途で活用できます。
                                </p>
                                <br>
                                <p class="new-text">オリジナルグッズの製作を検討する際、「最終的にいくらかかるのか分かりにくい」という点を不安に感じる企業担当者様の方も少なくないでしょう。当店では、そうした不安をできるだけ解消できるよう、数量に応じた価格を明瞭にご案内しています。たとえば、1000個製作の場合で単価797円といったように、製作数量ごとの価格を確認したうえでご検討いただけるのです。大量生産を前提とした販促品や販売グッズはもちろん、予算と数量のバランスを考えながら企画を進めたい法人様にも利用しやすい製作サービスです。あらかじめコストの目安を把握しやすいため、社内での予算申請や商品企画、販売価格の設定なども進めやすいでしょう。
                                </p>
                                <br>
                                <p class="new-text">さらに、立体ラバーならではの造形に加えて、製品表面へのデザインの印刷にも対応可能です。ラバーそのものの色分けだけでは表現しにくい細かなロゴ、文字、模様、キャラクターの表情やディテールなどを印刷で加えることで、デザインの表現幅をさらに広げられます。「形は立体的に作りたいけれど、細部までブランドイメージを再現したい」「キャラクターの特徴をより忠実に表現したい」といったご要望にも適しています。</p>
                                <br>
                                <p class="new-text">手に取ったときの立体感やボリューム感は、写真やイラストだけでは得られない大きな魅力です。手に取った人の印象にも残りやすく、コレクションしたくなるオリジナルグッズに仕上げることができます。販促用の立体キーホルダーから、キャラクターを再現した立体フィギュア、オリジナル商品の物販まで、立体造形と印刷を組み合わせた自由度の高いラバー製品を、分かりやすい価格で製作したい法人様は、ぜひ当店の製作サービスをご活用ください。サイズは高さ30〜50mmが目安です。より大きい製品の製作については、一度お問い合わせ下さい。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Candy -->

            <!--Accordion Price-->
            <div id="acc-price">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="price-toggle" class="accordion-input" checked>
                        <label for="price-toggle" class="accordion-header" id="price-g">
                            <span class="fw-bold">製作料金</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">数量別の単価（税込）は以下になります。</p>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">数量</th>
                                                <th class="fw-bold">単価（税込）</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>100個</td>
                                                <td>1,872円</td>
                                            </tr>
                                            <tr>
                                                <td>300個</td>
                                                <td>1,315円</td>
                                            </tr>
                                            <tr>
                                                <td>500個</td>
                                                <td>1,090円</td>
                                            </tr>
                                            <tr>
                                                <td>1000個</td>
                                                <td>797円</td>
                                            </tr>
                                            <tr>
                                                <td>2000個</td>
                                                <td>655円</td>
                                            </tr>
                                            <tr>
                                                <td>5000個</td>
                                                <td>556円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <small class="note">
                                    上記と合わせて、版型代金が（税込195,000円）が発生します。 <br>
                                    また、立体ラバーは試作品の製作後に量産開始となりますが、再試作の場合には再試作料金（税込8,800円）が発生します。 <br><br>
                                    立体ラバーの製作には3Dの入稿データが必要です。ご用意が難しい方向けに、3Dデータ作成補助サービス（税込25,000円）をご用意しております。
                                </small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--End Accordion Price-->


            <!--Accordion Datacreation -->
            <!-- <br>
            <div id="acc-datacreation">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="datacreation-toggle" class="accordion-input" checked>
                        <label for="datacreation-toggle" class="accordion-header">
                            <span class="fw-bold">データ作成補助が無料！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/candysticker/images/blank.png" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">キャンディシールの製作にあたって大変なのが、入稿データの作成です。当店のキャンディシールは、横幅100mm・縦幅160mmの範囲内に複数のシールのデザインを配置する方式です。その範囲内に複数のシールをどのように配置するのか、自分で考えて入稿データを作成するのは大変ですよね。当店では、無料のデータ作成補助サービスをご用意。お客様の代わりに入稿データを無料で作成いたします。シールにしたい画像（JPG、PNG）、PDFなどをお送りください。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--End Accordion Datacreation -->



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
                                <p class="new-text">出荷日の目安は以下です。なお、量産前の試作も含めた納期です。1回のみの試作を前提とした出荷日ですので、1回目の試作後にデザインの変更等で再度試作する場合は納期が延期となります。</p>
                                <br>

                                <!-- Shipping 28 Days -->
                                <br>
                                <div>
                                    <div style="display: flex">
                                        <div class="delivery">
                                            <span class="btn-a std-btn"><?= lang('通常納期'); ?></span>
                                        </div>
                                        <div class="delivery">
                                            <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                <?= lang('24営業日後出荷'); ?>
                                            </div>
                                        </div>
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
                                            <td><span id="date_create_12day_1"></span></td>
                                            <td><span id="date_create_12day_2"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- End Shipping 28 Days -->

                                <br>
                                <p class="new-text">原稿確定日は、デザインや仕様の確認が完了し、制作開始となった日を指します。ご注文後、製品のデザインや仕様等についてのご連絡を当店営業からお客様へメールでお送りいたしますので、ご確認をお願いいたします。</p>
                                <br>
                                <a href="https://hotmobily.jp/contact/index.php" class="new-text">無料サンプルの送付をリクエスト</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2><?= lang('アタッチメント') ?></h2>
            <p class="new-text"><?= lang('写真をクリックすると拡大写真と詳細説明を確認頂けます。') ?></p>
            <div class="exc_pro">
                <div class="swiper-container">
                    <div class="row">
                        <div class="mt-10-part">
                            <a href="/products/acrylic/img/HM_part-um1.jpg" data-lightbox="img-part-set-55" data-title="アンブレラマーカー">
                                <img class="picpro lazy" src="/products/acrylic/img/HM_part-um1.jpg" data-src="/products/acrylic/img/HM_part-um1.jpg" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/acrylic/img/HM_part-um1.jpg" data-lightbox="img-part-set-55-1" data-title="アンブレラマーカー" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>

                        <div class="mt-10-part">
                            <a href="/products/acrylic/img/HM_part-um2.jpg" data-lightbox="img-part-set-66" data-title="アンブレラマーカー+ボールチェーン">
                                <img class="picpro lazy" src="/products/acrylic/img/HM_part-um2.jpg" data-src="/products/acrylic/img/HM_part-um2.jpg" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/acrylic/img/HM_part-um2.jpg" data-lightbox="img-part-set-66-1" data-title="アンブレラマーカー+ボールチェーン" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-5" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。">
                                <img class="picpro lazy" src="/products/images/HM_part5.webp" data-src="/products/images/HM_part5.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+11円</div>
                            <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-5-1" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-6" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。">
                                <img class="picpro lazy" src="/products/images/HM_part6.webp" data-src="/products/images/HM_part6.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+22円</div>
                            <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-6-1" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-7" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。">
                                <img class="picpro lazy" src="/products/images/HM_part7.webp" data-src="/products/images/HM_part7.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+22円</div>
                            <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-7-1" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。">
                                <img class="picpro lazy" src="/products/images/HM_part14.webp" data-src="/products/images/HM_part14.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14-1" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-4" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。">
                                <img class="picpro lazy" src="/products/images/HM_part4.webp" data-src="/products/images/HM_part4.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+22円</div>
                            <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-4-1" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-15" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm">
                                <img class="picpro lazy" src="/products/images/HM_part15.webp" data-src="/products/images/HM_part15.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-15-1" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-18" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm">
                                <img class="picpro lazy" src="/products/images/HM_part18.webp" data-src="/products/images/HM_part18.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-18-1" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-16" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm">
                                <img class="picpro lazy" src="/products/images/HM_part16.webp" data-src="/products/images/HM_part16.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-16-1" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-19" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm">
                                <img class="picpro lazy" src="/products/images/HM_part19.webp" data-src="/products/images/HM_part19.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-19-1" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-17" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm">
                                <img class="picpro lazy" src="/products/images/HM_part17.webp" data-src="/products/images/HM_part17.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-17-1" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-20" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm">
                                <img class="picpro lazy" src="/products/images/HM_part20.webp" data-src="/products/images/HM_part20.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-20-1" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-8" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。">
                                <img class="picpro lazy" src="/products/images/HM_part8.webp" data-src="/products/images/HM_part8.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+22円</div>
                            <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-8-1" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                                <img class="picpro lazy" src="/products/images/HM_part1.webp" data-src="/products/images/HM_part1.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                                <img class="picpro lazy" src="/products/images/HM_part2.webp" data-src="/products/images/HM_part2.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+0円</div>
                            <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2-1" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                                <img class="picpro lazy" src="/products/images/HM_part3.webp" data-src="/products/images/HM_part3.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+11円</div>
                            <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3-1" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。">
                                <img class="picpro lazy" src="/products/images/HM_part9.webp" data-src="/products/images/HM_part9.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+11円</div>
                            <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9-1" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。">
                                <img class="picpro lazy" src="/products/images/HM_part10.webp" data-src="/products/images/HM_part10.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+11円</div>
                            <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10-1" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。">
                                <img class="picpro lazy" src="/products/images/HM_part11.webp" data-src="/products/images/HM_part11.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+11円</div>
                            <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11-1" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>
                        <div class="mt-10-part">
                            <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。">
                                <img class="picpro lazy" src="/products/images/HM_part12.webp" data-src="/products/images/HM_part12.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+11円</div>
                            <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12-1" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>

                        <div class="mt-10-part">
                            <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。">
                                <img class="picpro lazy" src="/products/images/HM_part13.webp" data-src="/products/images/HM_part13.webp" width="229" height="229" loading="lazy">
                            </a><br>
                            <div>+11円</div>
                            <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13-1" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
                        </div>


                    </div>
                </div>
                <div class="read-more1">
                    <a href="#" class="btn">
                        <img class="btn_z" src="/products/images/but3-03.webp" width="266" height="40" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';" alt="もっと見る">
                        <span class="btn_text_fallback" style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%;">もっと見る <svg style="width: 14px; height: 14px; margin-left: 6px; fill: currentColor;" viewBox="0 0 512 512">
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm113-273c9.4 9.4 9.4 24.6 0 33.9l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l39-39-138.1 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l138.1 0-39-39c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80z" />
                            </svg></span>
                    </a>
                </div>
            </div>
            <hr />
            <!-- Accordion Template-->
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
                                        製作には、STLデータ、CADデータなどの3Dのデザインデータが必要です。ご用意して頂いた入稿データは、ご注文の際に注文フォームでアップロードして頂くか、ご注文後にメールでご送付ください。
                                    </p>
                                    <br>
                                    <p class="new-text">
                                        3Dデータのご用意が難しい方は、製作したいキャラクターやマスコットの六面図または三面図の画像データ（写真やイラストなど）のご用意をお願いいたします。ご用意して頂いた画像データを元に、当店で入稿用の3Dデータを作成いたします（税込25,000円）。
                                    </p>
                                    <br>
                                    <p class="new-text">
                                        六面図とは、対象のキャラクターなどを六方向（正面・背面・上面・右側面・左側面・下面）から映したそれぞれの図です。,000円）。
                                    </p>
                                    <br>
                                    <div>
                                        <img src="/products/candysticker/images/candy-stickers-banner-03.webp" alt="オリジナルデザインでキャンディシール製作" width="100%" loading="lazy">
                                    </div>
                                    <br>
                                    <p class="new-text">
                                        三面図とは、対象のキャラクターなどを三方向（正面・背面・側面）から映したそれぞれの図です。
                                    </p>
                                    <br>
                                    <div>
                                        <img src="/products/candysticker/images/candy-stickers-banner-03.webp" alt="オリジナルデザインでキャンディシール製作" width="100%" loading="lazy">
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Template -->

            <br>
            <div id="acc-dev">

                <!-- Order Form -->
                <br>
                <div id="order-form">
                    <?php include('../campaign_banner.php') ?>

                    <h2 id="est-order">ご注文・見積書作成</h2>
                    <div style="overflow: unset!important;">
                        <div class="fixed-contrainer">
                            <h3 class="red">【<?= lang('3D立体チャーム') ?>】</h3>
                            <span class="total-price"><span class="prd_total">0</span>円（<?= lang('税込') ?>）</span>
                        </div>
                        <div style="clear: both;"></div>
                        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
                            <div class="step-box">
                                <table class="table_rubber" style="padding: 0">
                                    <tr>
                                        <td><?= lang('数量') ?></td>
                                        <td><span id="sample-prd-pcs">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang('アタッチメント') ?></td>
                                        <td><span id="sample-prd-attachment">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang('台紙') ?></td>
                                        <td><span id="sample-prd-candydaishe">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang('3Dデータ作成補助') ?></td>
                                        <td><span id="sample-prd-3d-data-creation">-</span></td>
                                    </tr>
                                    <!-- <tr>
                                        <td><?= lang('データ作成補助') ?></td>
                                        <td><span id="sample-prd-trace">-</span></td>
                                    </tr> -->
                                </table>
                            </div>
                            <div class="step-box line2" style="text-align: center;">
                                <img class="picpro lazy" data-src="/products/images/HM_part1-2.webp" id="sample-part-pic" width="320" height="320"><br />
                                <span id="sample-part-name"><?= lang('アタッチメント:なし') ?></span>
                            </div>
                            <div class="step-box line2" style="text-align: center;">
                                <img class="picpro lazy" data-src="/products/acrylic/img/coming-soon.webp" style="display: none;" id="sample-paper-pic" width="500" height="500"><br />
                                <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
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
                            <div style="display: table-column;"><input type="text" name="ItemType" id="strap" value="キャンディシール" /></div>
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

                            switch ($CandySticker_Daishe) {
                                case "なし":
                                    $candyDaishe_checked = '';
                                    break;
                                case "あり":
                                    $candyDaishe_checked = 'checked';
                                    break;
                            }

                            switch ($DeFormat) {
                                case "なし":
                                    $others_checked = 'checked';
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
                                                <input type="text" name="design_no" value="<?= $design_no ?>">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <?php include('../../delivery_note.php'); ?>
                                <?php include('../alert-btn.php') ?>

                                <h3><?= lang('数量') ?></h3>
                                <div class="part-container">
                                    <div class="part-content">
                                        <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="numberOf" id="no_of_order" class="right qty-inp" min="100" max="5000" onchange="this.value=format_number(this.value);" value="<?php echo $numberOf ?>" style="text-align: right;"><br /></label>
                                        <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?></div>
                                    </div>
                                </div>
                                <small>※デザイン1種につき1注文となります。デザインが複数ある場合は、デザインごとにご注文ください。</small>
                                <span style="color: red" id="error_message"></span>
                            </div>
                            <div class="estimate-content" id="step2">
                                <h3><?= lang('アタッチメント') ?></h3>
                                <div class="flex-container">
                                    <div class="preview-container">
                                        <div class="preview-sub flex-container">
                                            <?php
                                            include('part-3d-rubber.php');
                                            $i = 0;
                                            for ($i = 0; $i < count($attachment); $i++) {
                                                echo '
										<div class="flex-item">
										<label class="part-name">
										<input type="radio" name="acy_part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($acy_part == $attachment[$i]["part_name"] ? 'checked' : ($i == 0 && empty($acy_part) ? 'checked' : '')) . '>
										<img class="lazy" data-src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="picpro">
										<br><span class="std_price">+' . ($attachment[$i]["part_price"] * 1.1) . '円</span>
										</label>
										</div>';
                                            }
                                            ?>
                                        </div>
                                        <div class="error" id="part-error" style="text-align: center;"></div>
                                    </div>
                                </div>
                                <h3><?= lang('台紙') ?></h3>
                                <div class="part-container">
                                    <div class="part-content">
                                        <label class="part-name">
                                            <div class="switch_off_button b2 switch_off">
                                                <input type='hidden' value='なし' name='acy_paper_select'>
                                                <input type="checkbox" class="checkbox" name="acy_paper_select" value="あり" <?= ($acy_paper_select != "なし" ? ($acy_paper_select != "" ? "checked" : "") : "") ?>>
                                                <div class="knobs">
                                                    <span></span>
                                                </div>
                                                <div class="layer"></div>
                                            </div>
                                            <?= lang('台紙印刷') ?>
                                        </label>
                                        <div class="error" id="paper-error"></div>
                                        <div id="acy_paper_msg"></div>
                                    </div>
                                </div>
                                <div class="flex-container paper-container" style="<?= ($acy_paper_select == 'あり' ? '' : 'display:none;') ?>">
                                    <div class="preview-container">
                                        <div class="preview-sub flex-container" id="paper-preview">
                                            <?php if ($acy_paper_select == "あり") {
                                                include("../acy_paper_preview.php");
                                            } ?>
                                        </div>
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
                                                    <td class="TableLeft"><?= lang('数量') ?></td>
                                                    <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                                                </tr>
                                                <tr>
                                                    <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                    <td class="" id="prd_part" style="text-align: left;"></td>
                                                </tr>
                                                <tr>
                                                    <td class="TableLeft"><?= lang('台紙') ?></td>
                                                    <td class="" id="prd_CandyDaishe" style="text-align: left;"></td>
                                                </tr>
                                                <!-- <tr>
                                                    <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                    <td class="" id="prd_DeFormat" style="text-align: left;"></td>
                                                </tr> -->
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
                                                <tr style="display:none;">
                                                    <td class="TableLeft"><?= lang('版型代金') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="MoldPrice" readonly="readonly" id="textfield2" class="right" value="<?= $MoldPrice ?>">円</td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td class="TableLeft"><?= lang('本体色') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="SilkPrint" readonly="readonly" id="textfield13" class="right" value="<?php echo $SilkPrint ?>" />円</td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="coatingPrice" readonly="readonly" id="textfield13_2" class="right" value="<?= $coatingPrice ?>">円</td>
                                                </tr>
                                                <tr>
                                                    <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
                                                </tr>
                                                <tr>
                                                    <td class="TableLeft"><?= lang('台紙') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="CandyDaishePrice" readonly="readonly" id="textfield_candy" class="right" value="<?= $CandyDaishePrice ?>">円</td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td class="TableLeft"><?= lang('試作品') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="ProShipping" readonly="readonly" id="textfield3" class="right" value="<?= $ProShipping ?>">円</td>
                                                </tr>
                                                <!-- <tr>
                                                    <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="TraceCharge" readonly="readonly" id="textfield4" class="right" value="<?= $TraceCharge ?>">円</td>
                                                </tr> -->
                                                <tr style="display:none;">
                                                    <td class="TableLeft"><?= lang('特殊素材') ?></td>
                                                    <td class=""><input style="text-align: right;" type="text" size="16" name="MaterialCharge" readonly="readonly" id="MaterialCharge" class="right" value="<?= $MaterialCharge ?>">円</td>
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
                                <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')">オプション入力へ</a>
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

                <!--Accordion Candy 01 -->
                <br>
                <div id="acc-candy01">
                    <div class="accordion-container">
                        <div class="accordion-item">
                            <input type="checkbox" id="candy01-toggle" class="accordion-input" checked>
                            <label for="candy01-toggle" class="accordion-header">
                                <span class="fw-bold">今人気の推し活グッズ製作にぴったり！</span>
                                <span class="arrow-dove"></span>
                            </label>

                            <div class="accordion-content">
                                <div class="plan-section">
                                    <div>
                                        <img src="/products/candysticker/images/candy-stickers-banner-04.webp" alt="ぷくぷく立体シールでデコレーション" width="100%" loading="lazy">
                                    </div>
                                    <br>
                                    <p class="new-text">アイドルやアーティスト、アニメ・漫画・ゲームのキャラクター、VTuber、スポーツ選手など、「推し」を応援して楽しむ推し活は、幅広い世代に定着したカルチャーとなっています。それに伴い、推しを身近に感じられるキーホルダーやフィギュアなどのオリジナルグッズも、ファンにとって重要なアイテムのひとつになっています。当店の立体ラバー製品は、キャラクターや人物、マスコットなどを立体的な造形で表現できるため、こうした推し活グッズの製作にもおすすめです。平面的な印刷グッズとは異なり、厚みや凹凸のあるフォルムによって、顔立ちや髪型、衣装、ポーズなどの特徴を立体的に表現でき、手に取ったときの存在感や特別感をファンに提供することができます。</p>
                                    <br>
                                    <h3 class="h3-new fw-bold">持ち歩いて楽しめる立体キーホルダー</h3>
                                    <p class="new-text">立体ラバーキーホルダーは、バッグやポーチ、鍵などに取り付けて日常的に持ち歩けるため、推し活グッズとの相性が良いアイテムです。キャラクター全身をデフォルメして立体化したり、顔や象徴的なモチーフだけを立体的に表現したりと、企画に合わせてさまざまなデザインが考えられます。ライブやイベント、コンサート、ポップアップショップなどで販売する公式グッズをはじめ、作品の周年記念商品、店舗限定グッズ、購入特典などにも活用できます。ラバー素材ならではのソフトめの質感と、ころんとした立体的なフォルムも魅力です。バッグに付けた状態でも存在感があり、写真撮影の際には推し活アイテムとして画面に取り入れやすいため、SNSとの親和性も期待できます。複数のキャラクターやメンバーをシリーズ展開すれば、「推しだけを選ぶ」「全種類集める」といったコレクション需要にもつなげられます。</p>
                                    <br>
                                    <h3 class="h3-new fw-bold">飾って楽しめる立体フィギュアにも</h3>
                                    <p class="new-text">立体ラバー製品は、キーホルダーだけでなく、デスクや棚などに飾って楽しめる立体フィギュアとして製作することもできます。アクリルスタンドとは異なる厚みや丸みがあり、正面だけでなく斜めや横方向から見ても立体感を楽しめることが特長です。推しのキャラクターやマスコットを小型の立体物として再現することで、コレクション性の高いグッズに仕上げられます。たとえば、アニメやゲーム作品のキャラクターグッズ、企業・自治体の公式マスコット、スポーツチームのキャラクター、配信者やVTuberのオリジナルグッズなど、幅広いコンテンツに活用できます。誕生日、デビュー記念、周年、イベント開催などに合わせた限定デザインを展開することで、記念性のある商品企画にも適しています。</p>
                                    <br>
                                    <h3 class="h3-new fw-bold">立体造形と印刷でデザインの幅が広がる</h3>
                                    <p class="new-text">立体ラバー製品は、形状や色分けによる造形だけでなく、表面にデザインを印刷することも可能です。そのため、細かな目や口の表情、衣装の模様、ロゴ、文字など、立体造形だけでは再現しにくいディテールを加えることができます。キャラクターの個性や作品の世界観をより細かく表現できるため、オリジナリティを重視した推し活グッズ製作にも適しています。</p>
                                    <br>
                                    <p class="new-text">「身に付ける」「持ち歩く」「飾る」「集める」といったさまざまな楽しみ方ができるのが、立体キーホルダーや立体フィギュアの魅力です。ファンが思わず手に取りたくなる販売グッズを企画したい企業様や、既存のアクリル・缶バッジとはひと味違う推し活グッズを展開したい法人様は、ぜひ立体ラバー製品をご検討ください。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Candy 01 -->

            <!--Accordion Candy 02 -->
            <br>
            <div id="acc-candy02">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="candy02-toggle" class="accordion-input" checked>
                        <label for="candy02-toggle" class="accordion-header">
                            <span class="fw-bold">周年グッズや特典にも最適！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/candysticker/images/candy-stickers-banner-05.webp" alt="ぷくぷく立体シールで推し活" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">企業やブランド、店舗、施設、サービスなどの節目を記念する周年グッズや、購入・来場・キャンペーン参加などに合わせて配布する特典グッズには、「記念として残したくなること」「受け取ったときに特別感があること」が求められます。当店の立体ラバー製品は、キャラクターやロゴ、商品モチーフなどを厚みのある立体形状で表現できるため、一般的な平面グッズとはひと味違うオリジナルアイテムを製作できます。立体キーホルダーや立体フィギュアとして展開することで、企業の周年記念品からブランドキャンペーンのノベルティまで、さまざまな法人向け企画に活用できます。</p>

                                <h3 class="h3-new fw-bold">周年ならではの「特別仕様」を形にできる</h3>
                                <p class="new-text">創業10周年、20周年、50周年といった企業の節目や、ブランド・店舗・サービスの周年イベントでは、通常商品とは異なる限定感のあるグッズが効果的です。たとえば、企業やブランドのマスコットを立体キーホルダーにしたり、周年数を取り入れた特別デザインの立体フィギュアを製作したりすることで、その年ならではの記念品に仕上げられます。周年ロゴや記念メッセージ、創業年などをデザインに盛り込めば、単なるノベルティではなく、節目を象徴するアイテムとして長く手元に残してもらいやすくなります。社員向けの周年記念品、取引先への贈答品、周年イベントの来場記念、キャンペーン限定商品など、配布対象や目的に合わせた企画も可能です。立体的な造形による存在感があるため、「何か特別感のあるものを作りたい」という法人様にもおすすめです。</p>
                                <br>
                                <h3 class="h3-new fw-bold">購入特典や来場特典で商品・イベントの魅力を高める</h3>
                                <p class="new-text">立体ラバーキーホルダーや立体フィギュアは、購入特典、予約特典、来場特典、成約特典、キャンペーン景品などにも活用できます。商品パッケージやブランドキャラクター、イベント限定の衣装やモチーフなどを立体化すれば、本商品と関連性の高いオリジナル特典を製作できます。特典グッズは、非売品や数量限定とすることで希少性を演出しやすい点も魅力です。「対象商品を購入すると限定キーホルダーをプレゼント」「イベント来場者限定でオリジナルフィギュアを配布」といった企画にすることで、購買や来場を後押しする販促施策にもつなげられます。複数種類を用意してランダム配布する、キャンペーン期間ごとにデザインを変更するなど、コレクション性を持たせた展開も可能です。</p>
                                <br>
                                <h3 class="h3-new fw-bold">立体造形と印刷を組み合わせて細部まで表現</h3>
                                <p class="new-text">当店の立体ラバー製品は、形そのものを立体的に造形するだけでなく、表面にデザインを印刷することも可能です。細かなロゴや文字、キャラクターの表情、衣装の模様などを印刷で加えることで、立体造形だけでは表現しにくいディテールまで盛り込むことができます。企業ロゴを取り入れた周年記念キーホルダー、公式キャラクターを再現した来場特典フィギュア、商品そのものをミニチュア化した購入特典など、アイデア次第で幅広いオリジナルグッズを企画できます。手に取った瞬間に存在感を感じることができ、飾る・持ち歩く・集めるといった楽しみ方もできるため、受け取った後も印象に残りやすいのが特長です。周年グッズや特典グッズに、記念性とオリジナリティを兼ね備えたアイテムを取り入れたい法人様は、立体ラバーキーホルダーや立体フィギュアをぜひご検討ください。</p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Candy 02 -->

            <!--Accordion Candy 03 -->
            <!-- <br>
            <div id="acc-candy03">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="candy03-toggle" class="accordion-input" checked>
                        <label for="candy03-toggle" class="accordion-header">
                            <span class="fw-bold">自社のロゴや社名、キャラクターでノベルティにも！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/candysticker/images/candy-stickers-banner-06.webp" alt="ぷくぷく立体シールでノベルティ" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">光を反射してきらめくツヤと透明感、まるで本物のキャンディのようなコロンとした可愛いフォルムが目を惹く「キャンディシール」。最大の魅力は、ひと目見た瞬間に「かわいい！」と思わせる圧倒的な存在感にあります。滑らかでぷっくりとした質感に仕上がり、透明な表面が光を反射してきらめくため、手にした時の特別感は格別です。通常の平面ステッカーにはない立体的な厚みがあることで、平面ステッカーよりも圧倒的に高い注目度を誇ります。この魅力あふれる立体シールをオリジナルデザインで製作できるのが、ホットモバイリーのキャンディシール製作サービスです。</p>
                                <br>
                                <p class="new-text">販促グッズのみならず、企業のノベルティやプロモーションアイテムにも最適です。自社のロゴや社名、愛らしい公式キャラクターなどをキャンディシールにすることで、従来の印刷物では表現しきれなかった魅力と存在感をプラスできます。イベントや展示会での配布物として活用すれば、他社との差別化を図りつつ受け取った方の印象に深く残すことができ、思わず写真を撮ってSNSに投稿したくなるような話題性も抜群です。また、スマホケースやPC、手帳などに思わず貼りたくなる高いデザイン性があるため、ユーザーの身近な持ち物に長期間留まり、ブランドの認知拡大やファン作りに大きく貢献します。オリジナル製作だからこそ実現できる世界に一つだけのデザインと、思わず触れたくなる特別な手触りを兼ね備えたキャンディシールで、貴社のブランド価値を高める魅惑のプロモーションを展開してみませんか。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--End Accordion Candy 03 -->


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
                                            <td style="text-align: left;"><?= lang('立体ラバー') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('素材') ?></td>
                                            <td style="text-align: left;"><?= lang('PVC') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('サイズ') ?></td>
                                            <td style="text-align: left;"><?= lang('高さ30mm～50mm以内。50mmを超える高さの製品の製作については一度お問い合わせ下さい。') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('印刷方法') ?></td>
                                            <td style="text-align: left;">ATBC-PVC（非フタル酸エステル系）のPVC</td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('最小ロット') ?></td>
                                            <td style="text-align: left;"><?= lang('100個') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('包装') ?></td>
                                            <td style="text-align: left;"><?= lang('OPP個別包装') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('試作品') ?></td>
                                            <td style="text-align: left;">試作品 : 9営業日後 <br> 試作後の量産品 : 15営業日後</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Spec-->

            <br>
            <div id="lastd">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="lastd-toggle" class="accordion-input" checked>
                        <label for="lastd-toggle" class="accordion-header">
                            <span class="fw-bold fw-style">御社にお伺いします！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div align="center">
                                    <a href="//hotmobily.jp/meeting_date/"><img
                                            data-src="https://hotmobily.jp/img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム"
                                            width="100%" height="82" class="lazy" /></a>
                                </div>
                                <br>
                                <p class="new-text">対面やZoom等でのご相談をご希望の法人様向けに、当店営業の呼出フォームをご用意しております。「仕様や納期についてまずは話を聞きたい」「希望のデザインができるのか確かめたい」といったご希望のある法人様は、ぜひご活用ください。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



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
    <script type="text/javascript" src="/js/calculater_3d-rubber.js?de=<?php echo date('is') ?>"></script>
    <script language="JavaScript" src="/js/validation_new.js?v=1.11" type="text/javascript"></script>
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.17"></script>
    <script type="text/javascript" src="/products/js/date.js"></script>
    <script type="text/javascript" src="/products/js/pdf_3d-rubber.js?ver=<?php echo date('is') ?>"></script>
    <script>
        $(document).ready(function() {
            let params = '<?php echo (isset($_GET['sec']) ? $_GET['sec'] : "") ?>';
            if (params != "") {
                GotoDiv(params, true);
            }

            $("input[name='acy_paper_select'][type='checkbox']").on('change', function() {
                if ($(this).is(':checked')) {
                    $('.paper-container').show();
                    $('#paper-preview').load('/products/acy_paper_preview.php');
                } else {
                    $('.paper-container').hide();
                    $('#paper-preview').empty();
                    $('input[name="acy_paper"]').prop('checked', false);
                }
                setToInput();
            });

            $(document).on('change', 'input[name="acy_paper"]', function() {
                setToInput();
            });

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
                    src: "/products/candysticker/images/candysticker-01.webp",
                    targetId: "processing",
                    alt: "貝殻のぷくぷく立体シール"
                },
                {
                    src: "/products/candysticker/images/candysticker-02.webp",
                    targetId: "special",
                    alt: "キャラクターのぷくぷく立体シール"
                },
                {
                    src: "/products/candysticker/images/candysticker-03.webp",
                    targetId: "plans",
                    alt: "ぷくぷく立体シールの拡大図"
                },
                {
                    src: "/products/candysticker/images/candysticker-04.webp",
                    targetId: "production",
                    alt: "海の生き物のぷくぷく立体シール"
                },
                {
                    src: "/products/candysticker/images/candysticker-05.webp",
                    targetId: "production",
                    alt: "果物のぷくぷく立体シール"
                },
                {
                    src: "/products/candysticker/images/candysticker-06.webp",
                    targetId: "production",
                    alt: "ロゴのぷくぷく立体シール"
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
                        "height": $up.height(),
                        "max-height": 9999,
                        "padding-bottom": 70
                    })
                    .animate({
                        "height": totalHeight + 30
                    });
                $el.closest('.read-more1, .read-more').fadeOut();
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

            fetchHolidayData("24days", productionDate);
            fetchHolidayData("24days", productionDate28Days);

        }); // End Ready

        // --- GLOBAL FUNCTIONS (Keep outside ready to be accessible) ---

        function fetchHolidayData(productDays, successCallback) {
            $.ajax({
                type: "POST",
                url: "/products/check_holiday.php",
                data: {
                    "product": productDays
                },
                dataType: "json",
                success: function(data) {
                    successCallback(data.sort());
                },
                error: function(xhr, status, error) {
                    console.error(`Failed to fetch ${productDays} holidays.`);
                }
            });
        }


        function setProductionDate(date, startId, endId) {
            var str = date,
                l = str.length - 1,
                date_l = new Date(str[l]),
                f = new Date();

            var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];

            $('.cld_tb').show();

            $('#' + startId).text(
                add_digi(parseInt(f.getMonth() + 1)) + "月" +
                add_digi(f.getDate()) + "日(" +
                dayOfWeekStrJP[f.getDay()] + ") " +
                add_digi(f.getHours()) + ":" +
                add_digi(f.getMinutes())
            );

            $('#' + endId).text(
                add_digi(parseInt(date_l.getMonth() + 1)) + "月" +
                add_digi(date_l.getDate()) + "日(" +
                dayOfWeekStrJP[date_l.getDay()] + ")"
            );
        }

        function productionDate(date) {
            setProductionDate(date, 'date_create', 'date_create2');

            // ด้านบนขวา 出荷目安
            $('#date_create2x1').text($('#date_create_12day_2').text());
        }

        function productionDate11Days(date) {
            setProductionDate(date, 'date_create_11day_1', 'date_create_11day_2');
        }

        function productionDate28Days(date) {
            setProductionDate(date, 'date_create_12day_1', 'date_create_12day_2');
        }

        function productionDate15Days(date) {
            setProductionDate(date, 'date_create_15day_1', 'date_create_15day_2');
        }

        function productionDate16Days(date) {
            setProductionDate(date, 'date_create_16day_1', 'date_create_16day_2');
        }

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
                    3: '#acc-print',
                    4: '#acc-options',
                    5: '#acc-price',
                    6: '#acc-candy',
                    7: '#acc-datacreation'
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
    <script src="../js/lightbox.js" defer></script>
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