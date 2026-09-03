<?php
header('Cache-Control: public, max-age=300');
header('Content-Type: text/html; charset=UTF-8');
if (extension_loaded('zlib') && !ob_get_level()) {
    ob_start('ob_gzhandler');
}
ini_set("session.bug_compat_warn", 0);
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require_once('../../control/Control_Rubber.php');
include_once('../../common/Const.php');
include_once('../../common/SetUpLang.php');
include_once('../const_js.php');
include("../../connect_db/Control_Connect.php");


$msMode = "";
if (isset($_GET['mode'])) {
    $msMode = $_GET['mode'];
}
$btn_flg = false;

if ($msMode == "MODE_MOD") {
    $mrFormData = $_SESSION;
    foreach ($mrFormData as $k => $v) {
        $k = $v;
        $_POST["$k"] = $_SESSION["$v"];
    }
    $_SESSION['btn_flg'] = false;
} else if ($msMode == "CANCEL") {
    $btn_flg = $_POST['btn_flg'];
    $_POST[] = array();
    session_unset();
    session_destroy();
    $link = gsCnv2Form($_SERVER['SERVER_PHP_SELF']);
} elseif ($msMode === "MODE_RESET") {
    session_unset();
    session_destroy();
} else {
    $mrFormData = $_POST;
    $link = gsCnv2Form($_SERVER['SERVER_PHP_SELF']);
    foreach ($mrFormData as $k => $v) {
        $k = $v;
        $_SESSION[$k] = $v;
    }
    if ($msMode != "MODE_CART") {
        unset($_SESSION['index']);
        ClearSessionPrice();
    }
}

$mrErrMsgList = array();
$msErrFocusCtl = "";
Main();

// Session vars
$acy_print   = $_SESSION['acy_print']   ?? '';
$qty         = $_SESSION['qty']         ?? '';
$acy_part    = $_SESSION['acy_part']    ?? '';
$acy_sample  = $_SESSION['acy_sample']  ?? '' ? 'checked' : '';
$acy_trace   = $_SESSION['acy_trace']   ?? '' ? 'checked' : '';
$design_no   = $_SESSION['design_no']   ?? '';
$RepeatStyle_2 = (isset($_SESSION['acy_repeat']) && $_SESSION['acy_repeat'] == 'はい') ? '' : 'display:none;';

$print_single = ($acy_print == '片面印刷' || $acy_print == '') ? 'checked' : '';
$print_double = ($acy_print == '両面印刷') ? 'checked' : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="アクリル詰め放題">
    <meta name="description" content="A5サイズのアクリル板にデザインを詰め放題！アクリルキーホルダーやアクリルフィギュアスタンドを複数まとめて製作可能。推し活や同人のグッズ、ペット写真のオリジナルグッズにも最適。印刷がはがれない保護フィルム付き＆完全自社生産で高品質にお届け。1枚から製作可">
    <meta name="robots" content="index,follow">
    <title>【1個から】アクリル詰め放題（A5）アクキーもアクスタも自由に配置！</title>
    <link rel="canonical" href="https://hotmobily.jp/products/acrylic/tsumehodai">
     <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
    <link href="/products/css/box.css" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/css/modal.css?v=1.01" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/products/css/calendar.css?v=<?php echo date('is') ?>" rel="preload" type="text/css" as="style"
        onload="this.rel='stylesheet'" />
    <?php include("../../head_products.html"); ?>
    <link rel="stylesheet" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link href="/products/css/product_group.css?v=1.14" rel="stylesheet" type="text/css" />
    <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/products/css/lightbox.css" />
    <!-- <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163" as="style"
        onload="this.onload=null;this.rel='stylesheet'" /> -->
    <link href="https://hotmobily.jp/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://hotmobily.jp/products/css/scroll.css">
    <!-- <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" /> -->
    <link href="/products/acrylic/css/acrylic.css?v=1.10" rel="stylesheet" type="text/css">
    <style type="text/css">
        <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
    </style>
    <noscript>
        <link rel="stylesheet" type="text/css" href="/products/campaign/css/all.css">
        <!-- <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" /> -->
        <link href="https://hotmobily.jp/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
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
            color: #000 !important;
            background: unset !important;
            margin-bottom: 5px !important;
            text-align: start !important;
            font-size: 22px !important
        }

        .exc_pro {
            max-height: 450px;
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
            /* position: relative; */
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
            max-height: 3000px;
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
            /* width: 80%; */
            /* background-color: #f79647 */
            text-decoration: none !important;
        }

        a.est-btn.btn-a,
        a.ord-btn.btn-a {
            color: #fff;
            text-decoration: none !important;
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

        .mt-10-part {
            min-width: 23%;
            max-width: 23%;
        }

        .row .mt-10-part {
            min-width: 33%;
            max-width: 33%;
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

        a:link {
            color: #1a0dab;
            text-decoration: none !important;
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

        #date_create4 {
            font-size: 22px;
            font-weight: bold;
            color: red;
            letter-spacing: -1px;
            overflow: hidden;
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

        .poster-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: auto
        }

        .poster-item {
            background: #fff;
            border-radius: unset;
            overflow: hidden;
            transition: transform .3s
        }

        .poster-item img {
            width: 100%;
            height: auto;
            display: block
        }

        .poster-caption {
            padding: 10px;
            font-size: 14px;
            color: #555
        }

        #step2 .flex-item.acy_base {
            max-width: 50%
        }

        #step2 .preview-sub .flex-item.acy_base img {
            margin-bottom: 0
        }

        #step2 .flex-item.acy_base .part-name input:checked~.base_group {
            outline: 2px solid #1e90ff;
            outline-offset: -2px
        }

        #step3 .flex-container.btn-container div.flex-item .ord-btn {
            width: 100%;
        }

        .btn-success {
            background: #00a300;
        }

        .flex-container.btn-container div.flex-item {
            width: 30%;
        }

        .base_group span {
            display: block;
            padding: 5px 0;
            font-size: 12px
        }

        .base_group {
            display: inline-block
        }

        .base_group.picpro {
            max-width: 100%
        }

        .read-more1 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 10px 0 0px;
            z-index: 10;
        }

        .feature1 {
            background: url(/products/rubbercoaster/images/coaster_number_1.webp) 0 center/50px 85px no-repeat !important
        }

        .feature2 {
            background: url(/products/rubbercoaster/images/coaster_number_2.webp) 0 center/50px 85px no-repeat !important
        }

        .feature3 {
            background: url(/products/rubbercoaster/images/coaster_number_3.webp) 0 center/50px 85px no-repeat !important
        }

        .feature4 {
            background: url(images/coaster_number_4.webp) 0 center/50px 85px no-repeat !important
        }

        .feature1,
        .feature2,
        .feature3,
        .feature4 {
            color: #000 !important;
            line-height: 1.5;
            margin-top: 15px !important;
            min-height: 85px;
            padding-left: 66px !important;
            padding-top: 4px !important;
            font-size: 18px !important;
            display: flex;
            align-items: center
        }

        h2.feature1 {
            background: url(/products/images/wappen/feature-wappen-01.webp) 0 center/50px 50px no-repeat !important
        }

        h2.feature2 {
            background: url(/products/images/wappen/feature-wappen-02.webp) 0 center/50px 50px no-repeat !important
        }

        h2.feature3 {
            background: url(/products/images/wappen/feature-wappen-03.webp) 0 center/50px 50px no-repeat !important
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

        .pop {
            display: flex;
            flex-direction: row;
            gap: 10px;
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

            .poster-grid {
                grid-template-columns: repeat(2, 1fr)
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

            .pop {
                display: flex;
                flex-direction: column;
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

        @media screen and (max-width: 768px) {
            .input-qty {
                width: 25%;
            }

            .btn-a.btn-yellow,
            .btn-a.btn-orange {
                width: 69%;
            }
        }
    </style>
    <style>
        .tsume-step {
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .tsume-step-img {
            flex: 0 0 300px;
            max-width: 300px;
            width: 100%;
        }

        .tsume-step-text {
            flex: 1;
            min-width: 0;
        }

        /* mobile */
        @media (max-width: 768px) {
            .tsume-step {
                flex-direction: column;
            }

            .tsume-step-img {
                flex: none;
                max-width: 100%;
            }

            .tsume-step-text {
                width: 100%;
            }
        }

        .visually-hidden {
            position: absolute;
            left: -9999px;
        }
    </style>

</head>

<body id="top">
    <?php include('../../header.html'); ?>
    <?php include('../../gnavi.php'); ?>
    <div id="wrapper">
        <?php include('../../sidenavi.php'); ?>
        <div id="content_wrapper">
            <?php include('../banner-campaign.php'); ?>
            <?php
            $path_info = __DIR__ . "/acrylic_info.php";
            if (file_exists($path_info)) include($path_info);
            ?>

            <!-- H1 & Social -->
            <div>
                <h1 class="h1-new">アクリル詰め放題（2026年版）</h1>
                <div class="social-sns">
                    <p>シェアする</p>
                    <a href="//x.com/GoodsYe" target="_blank"><img src="/products/images/rubberstrap/v2/x-icon.webp" alt="X" width="20" height="20"></a>
                    <a href="//www.facebook.com/Hotmobily_jp-%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC-171871399585893" target="_blank"><img src="/products/images/rubberstrap/v2/Facebook-icon.webp" alt="Facebook" width="20" height="20"></a>
                    <a href="https://www.instagram.com/hot.mobily/?hl=ja" target="_blank"><img src="/products/images/rubberstrap/v2/IG_icon.webp" alt="Instagram" width="20" height="20"></a>
                    <p>更新日：2026年8月3日</p>
                </div>
            </div>

            <!-- Hero Container -->
            <div class="container">
                <!-- Gallery -->
                <div class="product-gallery">
                    <div class="pdp-v2-main-viewport">
                        <div class="pdp-v2-image-strip" id="pdp-v2-js-strip">
                            <div class="pdp-v2-main-link" data-index="0">
                                <img src="/products/acrylic/img/tsume/TsumeTsume-14.webp" alt="女の子キャラのアクリル詰め放題の製作事例 fetchpriority=" high" loading="eager" class="pdp-v2-slide-img" width="600" height="600">
                            </div>
                            <div class="pdp-v2-main-link" data-index="1">
                                <img src="/products/acrylic/img/tsume/TsumeTsume-15.webp" alt="猫の写真のアクリル詰め放題の製作事例" loading="lazy" class="pdp-v2-slide-img" width="600" height="600">
                            </div>
                            <div class="pdp-v2-main-link" data-index="2">
                                <img src="/products/acrylic/img/tsume/TsumeTsume-13 (1).webp" alt="猫の写真のアクリル詰め放題の全体像" loading="lazy" class="pdp-v2-slide-img" width="600" height="600">
                            </div>
                            <div class="pdp-v2-main-link" data-index="3">
                                <img src="/products/acrylic/img/tsume/TsumeTsume-08.webp" alt="猫の写真のアクリル詰め放題のズーム図" loading="lazy" class="pdp-v2-slide-img" width="600" height="600">
                            </div>
                            <div class="pdp-v2-main-link" data-index="4">
                                <img src="/products/acrylic/img/tsume/TsumeTsume-24.webp" alt="猫の写真のアクリル詰め放題を組み立てた様子" loading="lazy" class="pdp-v2-slide-img" width="600" height="600">
                            </div>
                            <div class="pdp-v2-main-link" data-index="5">
                                <img src="/products/acrylic/img/tsume/TsumeTsume-28.webp" alt="女の子キャラのアクリル詰め放題のパーツ" loading="lazy" class="pdp-v2-slide-img" width="600" height="600">
                            </div>
                        </div>
                    </div>
                    <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                        <img src="/products/acrylic/img/tsume/TsumeTsume-14.webp" alt="女の子キャラのアクリル詰め放題の製作事例" class="pdp-v2-thumb-item pdp-v2-active-state" data-index="0">
                        <img src="/products/acrylic/img/tsume/TsumeTsume-15.webp" alt="猫の写真のアクリル詰め放題の製作事例" class="pdp-v2-thumb-item" data-index="1" loading="lazy">
                        <img src="/products/acrylic/img/tsume/TsumeTsume-13 (1).webp" alt="猫の写真のアクリル詰め放題の全体像" class="pdp-v2-thumb-item" data-index="2" loading="lazy">
                        <img src="/products/acrylic/img/tsume/TsumeTsume-08.webp" alt="猫の写真のアクリル詰め放題のズーム図" class="pdp-v2-thumb-item" data-index="3" loading="lazy">
                        <img src="/products/acrylic/img/tsume/TsumeTsume-24.webp" alt="猫の写真のアクリル詰め放題を組み立てた様子" class="pdp-v2-thumb-item" data-index="4" loading="lazy">
                        <img src="/products/acrylic/img/tsume/TsumeTsume-28.webp" alt="女の子キャラのアクリル詰め放題のパーツ" class="pdp-v2-thumb-item" data-index="5" loading="lazy">
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

                <!-- Product Details -->
                <div class="product-details">
                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個3,850円（税込）</p>
                    </div>
                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">10個合計：</span>38,500円（税込）</p>
                    </div>
                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span id="date_create2x1"></span></p>
                    </div>
                    <div>
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です。</small><br>
                        <small class="note"><a href="javascript:void(0)" onclick="GotoDiv(2)">納期の詳細をチェック</a></small>
                    </div>

                    <h2 class="promo-title" style="color: #cc3f44; !important;">
                        A5サイズにデザインを詰め放題！アクキーもアクスタも<br>
                        <span style="color: #cc3f44;">製作費用がお得になるかも！</span>
                    </h2>

                    <div class="info-card">
                        <h3 class="lpc">製作費用がお得になることも！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(3)">
                            <img src="/products/acrylic/img/tsume/tsume_price.webp" alt="製作費用がお得になるかも" width="660" height="auto" loading="lazy">
                        </a>
                        <p class="new-text">「いろいろなデザインでアクキーやアクスタを作りたい！」というとき、アクリル詰め放題で制作費用がお得になることも！</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(3)">制作料金の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">ファングッズにも個人利用にも◎</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(4)">
                            <img src="/products/acrylic/img/tsume/A5_tsume_banner-01.webp" alt="ファングッズにも個人利用にも" width="660" height="auto" loading="lazy">
                        </a>
                        <p class="new-text">A5サイズにデザイン詰め放題！ファングッズ製作にも小ロット製作にもぴったりマッチ！</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(4)">アクリル詰め放題の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">印刷が剥がれない保護フィルム付き！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(5)">
                            <img src="/products/acrylic/img/tsume/protection-Tsume-Tsume2.webp" alt="保護フィルム付き" width="660" height="auto" loading="lazy">
                        </a>
                        <p class="new-text">当店のアクリル詰め放題は、印刷の剥がれを防ぐ保護フィルム付き。大切なオリジナルデザインを長くキレイに残します。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(5)">保護フィルムの詳細</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Hero Container -->

            <!-- Accordion: デザインを詰め放題 id="tsume" -->
            <br>
            <div id="tsume">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="tsume-toggle" class="accordion-input" checked>
                        <label for="tsume-toggle" class="accordion-header">
                            <span class="fw-bold">デザインを詰め放題！アクキーもアクスタも</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <img src="/products/acrylic/img/tsume/A5_tsume_banner-02.webp" alt="アクリル詰め放題" width="100%" loading="lazy">
                                <br><br>
                                <p class="new-text">・アニメファンやアイドルファンに、たくさんのデザインのアクリルグッズをまとめて届ける良い方法はないかな？</p>
                                <p class="new-text">・いろいろなデザインでアクキーやアクスタを作りたいけど、1デザインごとに注文するのは大変！</p>
                                <br>
                                <p class="new-text">法人・個人を問わず、上記のようなことでお悩みの方におすすめなのがアクリル詰め放題です。</p>
                                <br>
                                <p class="new-text">アクリル詰め放題は、A5サイズのアクリル板に好きなだけデザインを詰め込むことができます。「アクリルキーホルダーだけ」「アクリルフィギュアスタンドだけ」と限定されることもありません。</p>
                                <br>
                                <!-- <div>
                                    <img src="/products/acrylic/img/tsume/tsumehodai.webp" alt=""
                                        width="100%" loading="lazy">
                                </div> -->
                                <br>
                                <p class="new-text">たとえば、1枚のアクリル板に複数のキャラクターたちを詰め込めば、アニメファン向けにいろいろなキャラクターのアクキー・アクスタのセットを届けることができます。</p>
                                <br>
                                <p class="new-text">また、1回の注文で複数のデザインのアクリルグッズを製作できるため、注文にかかる手間を減らすことができるのも大きなポイントです。</p>
                                <br>
                                <p class="new-text">※複数デザインを入れる際には、カットライン（アクリルグッズの輪郭線）同士の間に2mm以上のスペースが必要です。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: tsume -->

            <!-- Accordion: 製作料金 id="price" -->
            <br>
            <div id="price">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="price-toggle" class="accordion-input" checked>
                        <label for="price-toggle" class="accordion-header">
                            <span class="fw-bold">製作料金（税込）</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">制作料金の単価（100枚以下の製作の場合）は以下になります。</p>
                                <br>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>単価</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>片面印刷</td>
                                                <td>3,850円</td>
                                            </tr>
                                            <tr>
                                                <td>両面印刷</td>
                                                <td>4,950円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <p class="new-text">100個を超える個数のご注文については、個別に<a href="https://hotmobily.jp/contact/">お問い合わせ</a>ください。</p>
                                <br>
                                <h3 class="h3-new fw-bold">アクリル詰め放題がお得なワケ！</h3>
                                <div>
                                    <img src="/products/acrylic/img/tsume/Tsume_otoku.webp" alt=""
                                        width="771" height="390" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">「いろいろなデザインでアクリルキーホルダーやアクリルフィギュアスタンドを作りたい！」というとき、<span class="hlt">アクリル詰め放題がとってもお得になることがあります。</span></p>
                                <br>
                                <p class="new-text">たとえば以下の条件だと、アクリルキーホルダーとアクリルフィギュアスタンドをそれぞれ別個に注文するよりも、アクリル詰め放題を注文する方が<span class="hlt">13,100円もお得です！</span></p>
                                <br>
                                <p class="new-text">・10種類のデザインのアクキーをそれぞれ10個ずつ（計100個）</p>
                                <p class="new-text">・5種類のデザインのアクスタをそれぞれ10個ずつ（計50個）</p>
                                <p class="new-text">※どちらも50mm×50mm以内サイズの片面印刷とします。</p>
                                <br>
                                <p class="new-text">ホットモバイリーの場合、デザイン1種類につき、アクリルキーホルダー10個製作の場合の単価は328円（税込）、アクリルフィギュアスタンド100個製作の場合の単価は376円（税込）です。それぞれ別個に注文すると、制作料金は以下のようになります。</p>
                                <br>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th>製品</th>
                                                <th>単価（税込）</th>
                                                <th>個数</th>
                                                <th>計（税込）</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>アクリルキーホルダー</td>
                                                <td>328円</td>
                                                <td>100個</td>
                                                <td>32,800円</td>
                                            </tr>
                                            <tr>
                                                <td>アクリルフィギュアスタンド</td>
                                                <td>376円</td>
                                                <td>50個</td>
                                                <td>18,800円</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">アクリルキーホルダーとアクリルフィギュアスタンドの合計</td>
                                                <td style="color:#cc3f44;font-weight:bold;">51,600円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <p class="new-text">アクリル詰め放題で、A5サイズのアクリル板内に収まるパーツ数は、パーツの大きさによりますが平均20個前後です。10種類のアクリルキーホルダー（10パーツ）と5種類のアクリルフィギュアスタンド（1デザインに付き本体と台座で2パーツ必要なので計10パーツ）がちょうどA5サイズ1枚に収まります。それを10枚製作すれば必要な個数を確保することができます。</p>
                                <br>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th>製品</th>
                                                <th>単価（税込）</th>
                                                <th>個数</th>
                                                <th>計（税込）</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>アクリル詰め放題</td>
                                                <td>3,850円</td>
                                                <td>10個</td>
                                                <td style="color:#cc3f44;font-weight:bold;">38,500円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <p class="new-text">このような計算になるため、この場合<span class="hlt">アクリル詰め放題が<span style="color: red;">13,100円もお得</span></span>になります。</p>
                                <br>
                                <p class="new-text">たくさんのデザインでいろいろなアクリルグッズを製作したい場合は、<span class="hlt">アクリル詰め放題がベストな選択肢</span>になるケースもあります。</p>
                                <br>
                                <p class="new-text">ただし、各種アクリルグッズは1デザインあたりの製作数量が大きくなるほど単価が下がるようになっています。1デザインあたりの製作数量が多いのであれば、別個に注文する方が安くなるケースもあります。大ロットの場合の各種アクリルグッズの単価は、各商品ページをご確認ください。</p>
                                <br>
                                <p class="new-text"><a href="https://hotmobily.jp/all-acrylic-products.php">各種アクリルグッズをチェック！</a></p>
                                <br>
                                <p class="new-text">なお、アクリル詰め放題の製作には、AI形式の入稿データ（デザインデータ）が必要です。ご自身でデータを作成するのは難しい方向けに、データ作成補助サービス（税込2,200円）をご用意しております。お送り頂いたイラストや写真を元に、入稿データ作成を代行いたします。</p>
                                <br>
                                <p class="new-text">※データ作成補助サービスをご希望の方は、注文フォーム上で「データ作成補助」をご選択ください。また、入稿データのベースとなるデザイン（イラストや写真などのデータ）のアップロードを注文フォーム上でお願いいたします。注文時のデザインのアップロードが難しい場合は、メール等で後ほどお送り頂くことも可能です。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: price -->

            <!-- Accordion: 入稿データテンプレート id="template" -->
            <br>
            <div id="template">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="template-toggle" class="accordion-input" checked>
                        <label for="template-toggle" class="accordion-header">
                            <span class="fw-bold">入稿データテンプレート</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">入稿データをご自身で作成する方向けに、AI形式の入稿データテンプレートをご用意しております。アドビイラストレーターで編集可能です。</p>
                                <br>
                                <div style="display:flex;flex-direction:row;justify-content:center;width:100%;">
                                    <a class="btn-a btn-yellow" href="/products/acrylic/download/アクリル詰め放題.zip" target="_blank" download>
                                        <span>入稿データ用テンプレート</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: template -->

            <!-- Accordion: 納期 id="shipping" -->
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
                                <p class="new-text">注文数別の出荷予定日は以下です。</p>
                                <br>

                                <!-- Shipping 10 Days -->
                                <div>
                                    <div style="display: flex">
                                        <div class="delivery">
                                            <span class="btn-a std-btn"><?= lang('1～10個の注文'); ?></span>
                                        </div>
                                        <div class="delivery">
                                            <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                <?= lang('10営業日後出荷'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="cld_tb" style="display:table;">
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
                                <!-- End Shipping 10 Days -->

                                <!-- Shipping 11 Days -->
                                <br>
                                <div>
                                    <div style="display: flex">
                                        <div class="delivery">
                                            <span class="btn-a std-btn"><?= lang('11～30個の注文'); ?></span>
                                        </div>
                                        <div class="delivery">
                                            <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                <?= lang('11営業日後出荷'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="cld_tb" style="display:table;">
                                        <tr class="cld_head">
                                            <td colspan="2"><?= lang('今、この製品を製作開始した場合の出荷日を表示中') ?></td>
                                        </tr>
                                        <tr class="cld_r1">
                                            <td><?= lang('原稿確定日') ?></td>
                                            <td><?= lang('出荷予定') ?></td>
                                        </tr>
                                        <tr class="cld_r2">
                                            <td><span id="date_create_11day_1"></span></td>
                                            <td><span id="date_create_11day_2"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- End Shipping 11 Days -->

                                <!-- Shipping 12 Days -->
                                <br>
                                <div>
                                    <div style="display: flex">
                                        <div class="delivery">
                                            <span class="btn-a std-btn"><?= lang('31～100個の注文'); ?></span>
                                        </div>
                                        <div class="delivery">
                                            <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                <?= lang('12営業日後出荷'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="cld_tb" style="display:table;">
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
                                <!-- End Shipping 12 Days -->

                                <br>
                                <p class="new-text">原稿確定日は、デザインや仕様の確認が完了し、制作開始となった日を指します。ご注文後、製品のデザインや仕様等についてのご連絡を当店営業からお客様へメールでお送りいたしますので、ご確認をお願いいたします。</p>
                                <br>
                                <a href="/howtoorder/acrylic.html" class="new-text">注文の流れはこちら</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: shipping -->

            <!--Accordion Attachment-->
            <br>
            <div id="acc-attachment">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="attachment-toggle" class="accordion-input" checked>
                        <label for="attachment-toggle" class="accordion-header" id="attachment-g">
                            <span class="fw-bold">アタッチメント</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">アクリルキーホルダー用のアタッチメントを、ご希望の数お付けいたします。以下の6種類をご用意しております。</p>
                                <br>
                                <div class="exc_pro">
                                    <div class="swiper-container">
                                        <div class="row">
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part14.webp"
                                                    data-lightbox="img-part-set-14"
                                                    data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。"
                                                    aria-label="ボールチェーンシルバーの画像を拡大表示">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part14.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy"
                                                        alt="ボールチェーンシルバー" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part14.webp"
                                                    data-lightbox="img-part-set-14-1"
                                                    data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。"
                                                    aria-label="ボールチェーンシルバーの画像を拡大表示"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part9.webp"
                                                    data-lightbox="img-part-set-9"
                                                    data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。"
                                                    aria-label="ボールチェーン黄色の画像を拡大表示">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part9.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+11円</div>
                                                <a
                                                    href="/products/images/HM_part9.webp"
                                                    data-lightbox="img-part-set-9-1"
                                                    data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。"
                                                    aria-label="ボールチェーン黄色の画像を拡大表示"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part10.webp"
                                                    data-lightbox="img-part-set-10"
                                                    data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。"
                                                    aria-label="ボールチェーン赤色の画像を拡大表示">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part10.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+11円</div>
                                                <a
                                                    href="/products/images/HM_part10.webp"
                                                    data-lightbox="img-part-set-10-1"
                                                    data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。"
                                                    aria-label="ボールチェーン赤色の画像を拡大表示"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part11.webp"
                                                    data-lightbox="img-part-set-11"
                                                    data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。"
                                                    aria-label="ボールチェーン青色の画像を拡大表示">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part11.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+11円</div>
                                                <a
                                                    href="/products/images/HM_part11.webp"
                                                    data-lightbox="img-part-set-11-1"
                                                    data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。"
                                                    aria-label="ボールチェーン青色の画像を拡大表示"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part12.webp"
                                                    data-lightbox="img-part-set-12"
                                                    data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。"
                                                    aria-label="ボールチェーンピンク色の画像を拡大表示">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part12.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+11円</div>
                                                <a
                                                    href="/products/images/HM_part12.webp"
                                                    data-lightbox="img-part-set-12-1"
                                                    data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>

                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part13.webp"
                                                    data-lightbox="img-part-set-13"
                                                    data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。"
                                                    aria-label="ボールチェーン緑色の画像を拡大表示">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part13.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+11円</div>
                                                <a
                                                    href="/products/images/HM_part13.webp"
                                                    data-lightbox="img-part-set-13-1"
                                                    data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。"
                                                    aria-label="ボールチェーン緑色の画像を拡大表示"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="read-more1">
                                        <a href="#" class="btn"
                                            ><img class="btn_z" src="/products/images/but3-03.webp" width="266" height="40" loading="lazy"
                                        /></a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Attachment-->

            <!-- Order Form id="order-form" -->
            <br>
            <div id="order-form">
                <?php include('../campaign_banner.php'); ?>

                <h2 id="est-order">ご注文・見積書作成</h2>
                <?php include('../../delivery_note.php'); ?>
                <div style="overflow:unset!important;">
                    <div class="fixed-contrainer">
                        <h3 class="red">【詰め放題アクリル】</h3>
                        <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
                    </div>
                    <div style="clear:both;"></div>

                    <!-- Summary Box -->
                    <div class="step-container line1" style="padding:5px;border:1px solid lightgray;margin-bottom:5px;">
                        <div class="step-box">
                            <table class="table_rubber" style="padding:0;">
                                <tr>
                                    <td>サイズ</td>
                                    <td>148mm×210mm　アタッチメント：なし　</td>
                                </tr>
                                <tr>
                                    <td>印刷面</td>
                                    <td><span id="sample-prd-print"></span></td>
                                </tr>
                                <tr>
                                    <td>本体数量</td>
                                    <td><span id="sample-prd-qty"></span></td>
                                </tr>
                                <tr>
                                    <td>アタッチメント数量</td>
                                    <td><span id="sample-prd-part"></span></td>
                                </tr>
                                <tr>
                                    <td>試作品</td>
                                    <td><span id="sample-prd-samp"></span></td>
                                </tr>
                                <tr>
                                    <td>データ作成補助</td>
                                    <td><span id="sample-prd-trace"></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img class="lazy" data-src="/products/images/HM_part1-2.webp" id="sample-part-pic" class="picpro" width="320" height="320"><br />
                            <span id="sample-part-name"><?= lang('アタッチメント:なし') ?></span>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img class="lazy" data-src="img/coming-soon.webp" style="display: none;" id="sample-paper-pic" class="picpro" width="500" height="500"><br />
                            <!-- <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span> -->
                        </div>
                    </div>

                    <!-- Step Indicator -->
                    <div class="step-container">
                        <div class="step-box step-list">
                            <ul>
                                <li id="dot-step1" class="active">
                                    <div class="step-number">1</div><span class="step-details">納期・サイズ・印刷面</span>
                                </li>
                                <li id="dot-step2">
                                    <div class="step-number">2</div><span class="step-details">アタッチメント・台紙等</span>
                                </li>
                                <li id="dot-step3">
                                    <div class="step-number">3</div><span class="step-details">製品仕様・制作料金</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
                        <div style="display:table-column;">
                            <label for="strap" class="visually-hidden">Item Type</label>
                            <input type="text" name="ItemType" id="strap" value="アクリル詰め放題" />
                            <input type="hidden" id="ms_mode" value="<?php echo (isset($_GET['mode']) ? $_GET['mode'] : '') ?>">
                        </div>

                        <!-- Step 1 -->
                        <div class="estimate-content" id="step1">
                            <h3>以前のご注文と同じデザインでの製作ですか？</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_repeat" value="いいえ" onclick="check_val();" <?= (!isset($_SESSION['acy_repeat']) || $_SESSION['acy_repeat'] == 'いいえ') ? 'checked' : '' ?>>いいえ <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_repeat" value="はい" onclick="check_val();" <?= (isset($_SESSION['acy_repeat']) && $_SESSION['acy_repeat'] == 'はい') ? 'checked' : '' ?>>はい <span class="checkmark"></span></label>
                                </div>
                            </div>
                            <div class="repeat" style="<?= $RepeatStyle_2 ?>">
                                <h3>前回ご注文の管理番号等がもしおわかりでしたら、ご入力ください。</h3>
                                <div class="part-container">
                                    <div class="part-content">
                                        <label class="part-name">
                                            <input type="text" name="design_no" value="<?= $design_no ?>" style="width:100%;height:100%;">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h3><?= lang('印刷面') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_print" value="片面印刷" onclick="check_val(); cal_c();" <?= $print_single ?>><?= lang('片面印刷') ?> <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_print" value="両面印刷" onclick="check_val(); cal_c();" <?= $print_double ?>><?= lang('両面印刷') ?> <span class="checkmark"></span></label>
                                </div>
                            </div>

                            <h3><?= lang('数量') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input class="input-qty" type="number" name="qty" style="text-align:right;" onblur="check_val(); cal_c();" oninput="updateTotalAtt()" value="<?= $qty ?>" min="1" max="100"></label>
                                    <div class="error" id="qty-error"></div>
                                </div>
                                <h3 style="font-size:13px;">※デザイン1種につき1注文となります。デザインが複数ある場合は、デザインごとにご注文ください。</h3>
                            </div>
                        </div>
                        <!-- End Step 1 -->

                        <!-- Step 2 -->
                        <div class="estimate-content" id="step2">
                            <h3><?= lang('アタッチメント') ?></h3>
                            <div class="flex-container">
                                <div class="preview-container">
                                    <div class="preview-sub flex-container">
                                        <?php
                                        if (file_exists(__DIR__ . '/part-tsume.php')) {
                                            include('part-tsume.php');
                                            if (isset($attachment) && is_array($attachment)) {
                                                foreach ($attachment as $att) {
                                                    echo '<div class="flex-item">
                                                        <label class="part-name">
                                                        <input type="radio" name="acy_part" value="' . $att["part_name"] . '" onclick="getPartData(\'' . $att["part_name"] . '\')" ' . ($acy_part == $att["part_name"] ? 'checked' : '') . '>
                                                        <img class="lazy" data-src="' . $att["part_pic"] . '" width="95" height="95">
                                                        <br><span class="std_price">+' . ($att["part_price"] * 1.1) . '円</span>
                                                        </label>
                                                        </div>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="error" id="part-error" style="text-align:center;"></div>
                                </div>
                                <h3><?= lang('詰め放題1枚あたりのアタッチメント数（10個まで）') ?></h3>
                                <div class="part-content">
                                    <input type="number" name="qoa" style="text-align:right;width: 33%;" onblur="check_val('next')" oninput="updateTotalAtt()" value="10" min="1" max="10">
                                    <span class="unit" id="total-attachment-count">アタッチメントの合計数量 : 0）</span>
                                    <div class="error" id="qoa-error"></div>
                                </div>
                            </div>

                            <h3 style="display:inline;"><?= lang('試作品・データ作成補助') ?></h3><a href="javascript:void(0)" onclick="$('#modal-5').prop('checked',true)">詳細</a>
                            <input class="modal-state" id="modal-5" type="checkbox">
                            <div class="modal">
                                <label class="modal__bg" for="modal-5"></label>
                                <div class="modal__inner modal1" style="height: fit-content;">
                                    <label class="modal__close" for="modal-5"></label>
                                    <div>
                                        <p class="new-text">データ作成補助は、ご自身でAI形式のデザインデータを用意するのは難しい方向けのサービスです。AI形式のデザインデータをお持ちでない方はデータ作成補助サービスをご利用ください。</p>

                                    </div>
                                </div>
                            </div>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type="hidden" value="なし" name="acy_sample">
                                            <input type="checkbox" class="checkbox" name="acy_sample" value="あり" onclick="cal_c()" <?= $acy_sample ?>>
                                            <div class="knobs"><span></span></div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('試作品 (20個以上から)') ?>
                                    </label>
                                    <div class="error" id="sample-error"></div>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type="hidden" value="なし" name="acy_trace">
                                            <input type="checkbox" class="checkbox" name="acy_trace" value="あり" onclick="cal_c()" <?= $acy_trace ?>>
                                            <div class="knobs"><span></span></div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('データ作成補助') ?>
                                    </label>
                                    <div id="myModal" class="modal">
                                        <div class="modal-content">
                                            <span class="close-modal">&times;</span>
                                            <p><?= lang('アクリル製品を製作する際に必要な、カットパスと白押さえのデータを作成するサービスです。<br/>アドビイラストレータもしくはフォトショップ以外のソフトでデザインを作成した場合には、必ずありを選択してください。') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Step 2 -->

                        <!-- Step 3 -->
                        <div class="estimate-content flex-item" id="step3">
                            <div class="flex-container">
                                <div class="flex-item">
                                    <h3><?= lang('製品仕様') ?></h3>
                                    <table class="table_rubber">
                                        <tbody>
                                            <tr>
                                                <td class="TableLeft"><?= lang('サイズ') ?></td>
                                                <td style="text-align:left;">148mm×210mm</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('印刷面') ?></td>
                                                <td id="prd_color" style="text-align:left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('数量') ?></td>
                                                <td id="prd_amount" style="text-align:left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td id="prd_part" style="text-align:left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント数量') ?></td>
                                                <td id="prd_qoa" style="text-align:left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td id="prd_sample" style="text-align:left;">なし</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                <td id="prd_trace" style="text-align:left;">なし</td>
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
                                                <td><input id="prd_price" type="text" name="prd_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td><input id="prd_part_price" type="text" name="prd_part_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                <td><input id="prd_trace_price" type="text" name="prd_trace_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('小計(税込)') ?></td>
                                                <td><input id="prd_sub_total" type="text" name="prd_sub_total" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('お値引き') ?></td>
                                                <td><input id="discount" type="text" name="discount" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('合計(税込)') ?></td>
                                                <td><input id="prd_total" type="text" name="prd_total" readonly>円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <table class="table_rubber total_price_tbl">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="background:none;border:none;">
                                            <div class="flex-container btn-container">
                                                <input type="button" class="btn clr-btn flex-item" value="CLEAR" onclick="setzero();">
                                                <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                                                <a href="javascript:void(0)" style="width: 16%;" class="btn btn-back" onclick="validation('step2');$('#cus_detail').hide();"><?= lang('アタッチメント修正') ?></a>
                                                <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle();">
                                                <div class="flex-item">
                                                    <input type="button" class="btn ord-btn btn-success" value="カートに入れる" onclick="if(chk_part()){comSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', form);}">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Step 3 -->

                        <div id="acrylic-btn" class="btn-container">
                            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="validation('back')"><?= lang('戻る') ?></a>
                            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="validation('next')"><?= lang('アタッチメント・オプション入力へ') ?></a>
                        </div>
                    </form>

                    <!-- Customer Detail for PDF -->
                    <div id="cus_detail" style="display:none;" align="center">
                        <table class="table_rubber" style="display:table;">
                            <tbody>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（姓）') ?></td>
                                    <td style="text-align:left;"><input name="Name_S" id="sname" type="text" maxlength="100" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（名）') ?></td>
                                    <td style="text-align:left;"><input name="Name_F" id="fname" type="text" maxlength="100" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('法人名') ?></td>
                                    <td style="text-align:left;"><input name="Corp_Name" id="Corp_Name" type="text" value="" size="45" maxlength="100"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('郵便番号') ?></td>
                                    <td style="text-align:left;"><input type="text" id="zip" name="zip" maxlength="8" size="15" value="">&nbsp;<input type="button" id="src_btn" onclick="address_fn();" value="住所に変換"><br><span id="error" style="color:red"></span></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('都道府県') ?></td>
                                    <td style="text-align:left;"><input type="text" id="address1" name="prefc" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('以降の住所') ?></td>
                                    <td style="text-align:left;"><input id="address2" name="address" type="text" class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('番地、建物名、部屋番号') ?></td>
                                    <td style="text-align:left;"><input id="address_street" name="address_street" type="text" class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('TELハイフンなし') ?></td>
                                    <td style="text-align:left;"><input name="tel" id="tel" type="text" maxlength="11" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お客様メモ欄') ?></td>
                                    <td style="text-align:left;"><input name="comment" id="comment" type="text" size="45" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="padding:10px;background:unset;border:unset;">
                                        <input id="button_pdf" type="button" style="cursor:pointer;height:30px;width:250px;color:red" onclick="validate('gcd');" value="御社情報確定（PDF出力）">
                                        <div class="remark">&nbsp;※<?= lang('社名や会社名の入力は任意です') ?></div>
                                        <span id="validate_error" style="color:red"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Order Form -->

            <!-- Accordion: 保護フィルム id="protection" -->
            <br>
            <div id="protection">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="protection-toggle" class="accordion-input" checked>
                        <label for="protection-toggle" class="accordion-header">
                            <span class="fw-bold">【他社と違う！】印刷が剥がれない保護フィルム付き</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <img src="/products/acrylic/img/tsume/protection-Tsume-Tsume1.webp" alt="保護フィルム付き" width="100%" loading="lazy">
                                <br><br>
                                <p class="new-text">当店のアクリル詰め放題の強みのひとつとして、お客様の大切なデザインを保護する保護フィルムがあります。</p>
                                <br>
                                <p class="new-text">他社のアクリル詰め放題は保護フィルムがなく、固いものがこすれると、印刷されたデザインが剥がれる恐れがあります。しかし、当店のアクリル詰め放題のアクリル板は保護フィルムでカバーされており、印刷がむき出しになることがなく、印刷が剥がれません。</p>
                                <br>
                                <p class="new-text">オリジナルのデザインをせっかく印刷したアクリルグッズなら、長くキレイに保ちたいですよね。当店のアクリルグッズなら、お客様のご希望を叶えることが可能です。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: protection -->

            <!-- Accordion: アクキー・アクスタの組み立て方 id="assemble" -->
            <br>
            <div id="assemble">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="assemble-toggle" class="accordion-input" checked>
                        <label for="assemble-toggle" class="accordion-header">
                            <span class="fw-bold">アクキー・アクスタの組み立て方</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">アクリル詰め放題の板からパーツを取り出し、アクキー・アクスタを完成させる手順は以下になります。誰でも簡単にアクキー・アクスタを完成させることができます。</p>
                                <br>
                                <h3 class="h3-new fw-bold">1.裏面のフィルムを剥がす。</h3>
                                <div class="tsume-step">
                                    <div class="tsume-step-img">
                                        <img src="/products/acrylic/img/tsume/TsumeTsume-10.webp" alt="裏面フィルムを剥がす" width="100%" loading="lazy">
                                    </div>
                                    <div class="tsume-step-text">
                                        <p class="new-text">裏側に、パーツが板本体から外れないようにするためのフィルムが貼ってあります。まずはフィルムを剥がしましょう。</p>
                                    </div>
                                </div>
                                <br>
                                <h3 class="h3-new fw-bold">2.板からパーツを取り外す。</h3>
                                <div class="tsume-step">
                                    <div class="tsume-step-img">
                                        <img src="/products/acrylic/img/tsume/TsumeTsume-11.webp" alt="板からパーツを取り外す" width="100%" loading="lazy">
                                    </div>
                                    <div class="tsume-step-text">
                                        <p class="new-text">裏側のフィルムを剥がせば、あとは簡単にパーツを取り外すことができます。取り外した後、パーツを失くさないように注意してください。特に小さなパーツは要注意です。</p>
                                    </div>
                                </div>
                                <br>
                                <h3 class="h3-new fw-bold">3.アタッチメントや台座を取り付ける。</h3>
                                <div class="tsume-step">
                                    <div class="tsume-step-img">
                                        <img src="/products/acrylic/img/tsume/TsumeTsume-17.webp" alt="アタッチメントや台座を取り付ける" width="100%" loading="lazy">
                                    </div>
                                    <div class="tsume-step-text">
                                        <p class="new-text">アクキーは、付属のアタッチメントを取り付ければ完成です。アクスタは、本体を台座に差し込めば完成です。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: assemble -->

            <!-- Accordion: 活用方法 id="customization" -->
            <br>
            <div id="customization">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="customization-toggle" class="accordion-input" checked>
                        <label for="customization-toggle" class="accordion-header">
                            <span class="fw-bold">活用方法は無限大！ファングッズにも小ロットにも◎</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <img src="/products/acrylic/img/tsume/tsume_scene.webp" alt="活用方法は無限大" width="100%" loading="lazy">
                                <br><br>
                                <p class="new-text">1枚のアクリル板に、あなたのアイデアとこだわりをギュッと詰め込める「アクリル詰め放題」。このアイテムの最大の魅力は、圧倒的な自由度と、手元に届いたときのワクワク感です。決められたサイズの枠内であれば、パーツの配置はあなた次第。思い描くアイテムをパズルのように自由に組み合わせることが可能です。</p>
                                <br>
                                <p class="new-text">工夫次第で無限に広がる、おすすめの活用方法をご紹介します。</p>
                                <br>
                                <h3 class="h3-new fw-bold">ファンの心を掴む！大満足の公式グッズ・ノベルティとして</h3>
                                <p class="new-text">キャラクターグッズやアーティストのオフィシャルグッズとして、アクリル詰め放題はファンにとっておきのワクワクを提供します。たとえば、1枚のプレートの中に「キャラクターの全身スタンド」「表情違いのバストアップ」「作品のロゴ」「モチーフアイテム」をすべて詰め込むことが可能です。ファンにとっては、1つの商品で複数のグッズが手に入るお得感があり、さらにプラモデルのように自分でパーツを外して組み立てる体験そのものも楽しむことができます。</p>
                                <br>
                                <h3 class="h3-new fw-bold">同人活動・個人クリエイターの強い味方！</h3>
                                <p class="new-text">「いろいろなデザインでアクスタやアクキーを作りたいけれど、それぞれ発注すると予算オーバーになるし、在庫を抱えるのも不安…」といったクリエイターの皆様のお悩みを解決するのが、この詰め放題システムです。1枚のプレートで複数のデザインを網羅できるため、別々に製作するよりもコストパフォーマンスに優れるケースも。複数のデザインのアクリルグッズを小ロットずつ製作したい場合にぴったりです。</p>
                                <br>
                                <h3 class="h3-new fw-bold">大切なペットや家族の思い出を形に</h3>
                                <p class="new-text">イラストだけでなく、写真を使った製作も大歓迎です。可愛いペットのあくびをしている顔やおもちゃで遊んでいる姿、すやすや眠る様子などを切り抜いて、1枚のプレートに詰め込んでみませんか？ 自宅に飾るスタンドやお出かけ用のバッグに付けるキーホルダーとして、いつでも一緒に過ごすことができます。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: customization -->

            <!-- Accordion: 1枚から注文可能 id="one" -->
            <br>
            <div id="one">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="one-toggle" class="accordion-input" checked>
                        <label for="one-toggle" class="accordion-header">
                            <span class="fw-bold">1枚から注文可能！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <img src="/products/acrylic/img/tsume/tsume_one.webp" alt="1枚から製作可能" width="100%" loading="lazy">
                                <br><br>
                                <p class="new-text">当店のアクリル詰め放題は1枚からご注文が可能です。個人のお客様でもお気軽にオリジナルグッズ制作をお楽しみいただけます。</p>
                                <br>
                                <p class="new-text">・愛犬や愛猫のメモリーを、自分専用や家族専用のアクリルグッズに！</p>
                                <p class="new-text">・クラスメイトや部活メンバーたちで、今まで撮った写真のアクリルグッズをシェア！</p>
                                <p class="new-text">・同人イベントに向けたグッズを1枚だけ作ってみて仕上がりを確認！</p>
                                <br>
                                <p class="new-text">上記のようなニーズにもマッチした製作サービスです。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: one -->

            <!-- Accordion: 完全自社生産 id="factory" (closed by default) -->
            <br>
            <div id="factory">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="factory-toggle" class="accordion-input" checked>
                        <label for="factory-toggle" class="accordion-header">
                            <span class="fw-bold">当店アクリル詰め放題は完全自社生産です！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <img src="/products/acrylic/img/tsume/in-house-production_banner-02_1.webp" alt="完全自社生産" width="100%" loading="lazy">
                                <br><br>
                                <p class="new-text">アクリル詰め放題を含め、当店のアクリル製品はすべて自社生産です。デザインの印刷、アクリル板のカット、包装まですべて自社で完結しています。自社生産のためマージンなどが発生せず、お客様のお求めの製品を低コストで製作することができます。製品のクオリティにも責任をもってこだわっております。お客様のデザインを活かした高品質のアクリル詰め放題をお届けいたします。</p>
                                <br>
                                <p class="new-text"><a href="https://hotmobily.jp/products/acrylic/ownfactory">自社生産の詳細</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: factory -->

            <!-- Accordion: 製品仕様 id="information" (closed by default) -->
            <br>
            <div id="information">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="information-toggle" class="accordion-input" checked>
                        <label for="information-toggle" class="accordion-header">
                            <span class="fw-bold">製品仕様</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <table class="table_rubber">
                                    <tr>
                                        <td class="TableLeft">名称</td>
                                        <td style="text-align:left;">アクリル詰め放題</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">素材</td>
                                        <td style="text-align:left;">3mm厚アクリル</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">サイズ</td>
                                        <td style="text-align:left;">A5サイズ(148mm × 210mm)</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">色数</td>
                                        <td style="text-align:left;">フルカラーUVインクジェット印刷+白押さえが基本となります。</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">アタッチメント</td>
                                        <td style="text-align:left;">各色ボールチェーン</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">試作品</td>
                                        <td style="text-align:left;">20以上のご注文から可能です。</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">最小ロット</td>
                                        <td style="text-align:left;">1個</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">包装</td>
                                        <td style="text-align:left;">個別OPP包装</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">納期</td>
                                        <td style="text-align:left;">1～10個：10営業日後出荷<br>11～30個：11営業日後出荷<br>31～100個：12営業日後出荷</td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft">特徴</td>
                                        <td style="text-align:left;">印刷面を保護フィルムで保護/レーザーカット</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: information -->

            <!--Accordion Acrylic Lists-->
            <br>
            <div id="acrylic-grid">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="acrylic-grid-toggle" class="accordion-input" checked>
                        <label for="acrylic-grid-toggle" class="accordion-header">
                            <span class="fw-bold fw-style">アクリルグッズ一覧</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <?php include('acrylic-items-lists.php') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Acrylic Lists-->

            <!-- Accordion: 御社にお伺いします id="meeting" -->
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
                            <div class="plan-section">
                                <a href="https://hotmobily.jp/meeting_date/" target="_blank">
                                    <img src="https://hotmobily.jp/img/btn_meetingdate_1.webp" alt="商談日程を予約する" width="100%" loading="lazy">
                                </a>
                                <br><br>
                                <p class="new-text">対面やZoom等でのご相談をご希望の法人様向けに、当店営業の呼出フォームをご用意しております。「仕様や納期についてまずは話を聞きたい」「希望のデザインができるのか確かめたい」といったご希望のある法人様は、ぜひご活用ください。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion: meeting -->

        </div><!-- end content_wrapper -->
    </div><!-- end wrapper -->

    <?php include('../../footer.html'); ?>

    <!-- Modal for image zoom -->
    <div id="pdp-v2-modal" class="pdp-v2-modal-overlay">
        <div class="pdp-v2-modal-container" style="position:relative;max-width:90%;max-height:90vh;display:flex;align-items:center;justify-content:center;">
            <img id="pdp-v2-modal-img" class="pdp-v2-modal-content" src="" alt="">
            <span id="pdp-v2-modal-next-btn" class="pdp-v2-modal-next" style="position:absolute;top:50%;right:10px;transform:translateY(-50%);width:45px;height:45px;display:flex;align-items:center;justify-content:center;color:#fff;cursor:pointer;z-index:10001;filter:drop-shadow(0px 0px 8px rgba(0,0,0,1));">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:100%;height:100%;">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </span>
            <span class="pdp-v2-modal-close">&times;</span>
        </div>
    </div>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script src="https://hotmobily.jp/products/js/lightbox.js"></script>
    <script type="text/javascript" src="/js/common.js?v=1.02" defer></script>
    <script type="text/javascript" src="/products/acrylic/js/calculate-tsume-tsume.js?v=<?php echo date('is'); ?>" defer></script>
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=<?php echo date('is'); ?>" defer></script>
    <script type="text/javascript" src="/products/js/date.js" defer></script>
    <script type="text/javascript">
        $(document).ready(function() {

            // Gallery
            const elements = {
                modal: document.getElementById('pdp-v2-modal'),
                modalImg: document.getElementById('pdp-v2-modal-img'),
                pdpStrip: document.getElementById('pdp-v2-js-strip'),
                pdpGrid: document.getElementById('pdp-v2-js-grid-pc'),
                nextBtn: document.getElementById('pdp-v2-modal-next-btn'),
                closeBtns: document.querySelectorAll('.pdp-v2-modal-close'),
            };
            const imageList = [
                "/products/acrylic/img/tsume/TsumeTsume-14.webp",
                "/products/acrylic/img/tsume/TsumeTsume-15.webp",
                "/products/acrylic/img/tsume/TsumeTsume-13 (1).webp",
                "/products/acrylic/img/tsume/TsumeTsume-08.webp",
                "/products/acrylic/img/tsume/TsumeTsume-24.webp",
                "/products/acrylic/img/tsume/TsumeTsume-28.webp",
            ];

            let pdpCurrentIdx = 0;
            let pdpTimer;

            function updateGalleryView(index) {
                pdpCurrentIdx = index;
                if (elements.pdpStrip) elements.pdpStrip.style.transform = `translateX(-${index * 100}%)`;
                const thumbs = document.getElementsByClassName('pdp-v2-thumb-item');
                for (let i = 0; i < thumbs.length; i++) {
                    thumbs[i].classList.toggle('pdp-v2-active-state', i === index);
                }
            }

            function openModal(index) {
                pdpCurrentIdx = index;
                if (elements.modal) {
                    elements.modal.classList.add('active');
                    elements.modalImg.src = imageList[index];
                    clearInterval(pdpTimer);
                }
            }

            function closeModal() {
                if (elements.modal) elements.modal.classList.remove('active');
                startAutoTimer();
            }

            function nextImage() {
                pdpCurrentIdx = (pdpCurrentIdx + 1) % imageList.length;
                elements.modalImg.style.opacity = '0';
                setTimeout(() => {
                    elements.modalImg.src = imageList[pdpCurrentIdx];
                    elements.modalImg.onload = () => {
                        elements.modalImg.style.opacity = '1';
                    };
                }, 200);
                updateGalleryView(pdpCurrentIdx);
            }

            function startAutoTimer() {
                pdpTimer = setInterval(() => {
                    pdpCurrentIdx = (pdpCurrentIdx + 1) % imageList.length;
                    updateGalleryView(pdpCurrentIdx);
                }, 4000);
            }

            // Init gallery
            elements.pdpStrip.querySelectorAll('.pdp-v2-main-link').forEach(link => {
                link.onclick = () => openModal(parseInt(link.getAttribute('data-index'), 10));
            });
            elements.pdpGrid.querySelectorAll('.pdp-v2-thumb-item').forEach(thumb => {
                thumb.onclick = () => {
                    updateGalleryView(parseInt(thumb.getAttribute('data-index'), 10));
                    clearInterval(pdpTimer);
                    startAutoTimer();
                };
            });
            if (elements.closeBtns) elements.closeBtns.forEach(btn => btn.onclick = closeModal);
            if (elements.modal) elements.modal.onclick = (e) => {
                if (e.target === elements.modal) closeModal();
            };
            if (elements.nextBtn) elements.nextBtn.onclick = (e) => {
                e.stopPropagation();
                nextImage();
            };
            startAutoTimer();

            // Shipping date display
            let params = '<?php echo (isset($_GET['sec']) ? $_GET['sec'] : "") ?>';
            if (params !== "") GotoDiv(params, true);

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

            fetchHolidayData("10days", productionDate);
            fetchHolidayData("11days", productionDate11Days);
            fetchHolidayData("12days", productionDate12Days);

        }); // end ready

        function updateTotalAtt() {
            var qty = parseInt($('input[name="qty"]').val()) || 0;
            var qoa = parseInt($('input[name="qoa"]').val()) || 0;
            var total = qty * qoa;
            $('#total-attachment-count').text('アタッチメントの合計数量 : ' + total + '）');
        }

        function GotoDiv(no, external_page = false) {
            let em = '';
            if (!no) return;
            if (!external_page) {
                const map = {
                    1: '#order-form',
                    2: '#acc-shipping',
                    3: '#price',
                    4: '#tsume',
                    5: '#protection',
                    6: '#customization',
                    7: '#one',
                };
                em = map[no];
                if (no == 2) document.getElementById('shipping-toggle') && (document.getElementById('shipping-toggle').checked = true);
                if (no == 3) document.getElementById('price-toggle') && (document.getElementById('price-toggle').checked = true);
                if (no == 4) document.getElementById('tsume-toggle') && (document.getElementById('tsume-toggle').checked = true);
            } else {
                em = '#' + no;
            }
            if (em && $(em).length) {
                $("html, body").animate({
                    scrollTop: $(em).offset().top - 100
                }, 1000);
            }
        }
    </script>
</body>

</html>