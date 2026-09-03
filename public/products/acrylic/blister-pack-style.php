<?php

// // 1. เปิดโชว์ Error ของ PHP ทุกอย่าง (ป้องกันหน้าขาวแล้วมองไม่เห็นปัญหา)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// // 2. กำหนด Path ที่เราจะทดสอบ
// $target_file = __DIR__ . "/part-base-rainbow.php";

// // 3. เช็คว่า PHP มองเห็นไฟล์นี้จริงๆ ไหมบนฮาร์ดดิสก์
// if (file_exists($target_file)) {
//     echo "<b>[Debug]</b> เจอไฟล์: " . $target_file . " แล้ว! กำลังพยายาม include...<br>";

//     // ลอง include ดู ถ้าพังหลังจากบรรทัดนี้ แปลว่าเป็นปัญหาที่โค้ดข้างในไฟล์ acy_paper_preview_rainbow.php
//     include($target_file); 

//     echo "<br><b>[Debug]</b> Include สำเร็จและทำงานจบแล้ว!";
// } else {
//     echo "<b>[Error]</b> ระบบหาไฟล์นี้ไม่เจอจริงๆ Path ที่ PHP พยายามหาคือ: <br>" . $target_file;
// }

// exit;

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

// include('/products/acrylic/part-base-rainbow.php');

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
// die;

// GETリクエストを取得
// $msMode = $_GET['mode'];
$msMode = "";
if (isset($_GET['mode'])) {
    $msMode = $_GET['mode'];
}
$btn_flg = false;

// パラメータを取得
if ($msMode == "MODE_MOD") {
    //get SessData
    $mrFormData = $_SESSION;
    foreach ($mrFormData as $k => $v) {
        $$k = $v;
        $_POST["$k"] = $_SESSION["$v"];
    }
    $_SESSION['btn_flg'] = false;
} else if ($msMode == "CANCEL") {
    $btn_flg = $_POST['btn_flg'];
    $_POST[] = array();
    //delete SessData
    session_unset();
    session_destroy();
    $link = gsCnv2Form($_SERVER['SERVER_PHP_SELF']);
} else if ($msMode === "MODE_RESET") {
    session_unset();
    session_destroy();
} else {
    $mrFormData = $_POST;
    $link = gsCnv2Form($_SERVER['SERVER_PHP_SELF']);
    //nameのPOSTデータを取得
    foreach ($mrFormData as $k => $v) {
        $$k = $v;
        $_SESSION[$k] = $v;
    }

    if ($msMode != "MODE_CART") {
        unset($_SESSION['index']);
        ClearSessionPrice();
    }
}

// エラー出力用
$mrErrMsgList = array();
$msErrFocusCtl = "";

//メイン関数の呼出
Main();


?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="ブリスターパック風アクリルキーホルダー">
    <meta name="description"
        content="ブリスターパック風アクリルキーホルダーをオリジナルデザインで製作！推し活、同人グッズ、キャラグッズに最適。1個から製作可能、印刷を守る保護フィルム付き。キャラクターやVTuber、アイドル、アーティストなどをパッキング！個性あふれるアクリルグッズ">
    <meta name="robots" content="index,follow" />
    <title>ブリスターパック風アクリルキーホルダー製作！推し活やキャラグッズに</title>
    <link rel="canonical" href="https://hotmobily.jp/products/acrylic/blister-pack-style">
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
            max-height: 325px;
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

        .img-container {
            position: relative;
            display: inline-block;
        }

        #productImg,
        .img-fayde {
            max-width: 100%
        }

        #lens {
            position: absolute;
            border: 2px solid rgba(255, 255, 255, .95);
            width: 180px;
            height: 140px;
            pointer-events: none;
            background-repeat: no-repeat;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .25);
            z-index: 50
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
            background: #fff;

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

            #step2 .preview-container {
                margin-top: 10px;
            }

            #step2 .dsd {
                gap: 5px;
                overflow: auto;
                scroll-behavior: unset !important;
                max-height: fit-content !important;
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

        @media (max-width: 576px) {
            .delivery .btn-a {
                font-size: 4vw !important;
            }

            #lens,
            .mobile-show {
                display: none
            }
        }

        .blister-photo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            margin-top: 20px;
        }

        .blister-photo-box {
            background-color: #d9e8f6;
            min-height: 300px;
            border: 1px solid #c7d6e3;
            position: relative;
            padding: 6px;
            font-size: 14px;
            color: #000;
        }

        .blister-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* มือถือให้เรียงลงมา */
        @media (max-width: 768px) {
            .blister-photo-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .blister-photo-box {
                min-height: 220px;
            }
        }

        .blister-photo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            margin-top: 20px;
        }

        .blister-photo-title {
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
            color: #000;
        }

        .blister-photo-box {
            background-color: #d9e8f6;
            min-height: 300px;
            border: 1px solid #c7d6e3;
            position: relative;
            padding: 6px;
            font-size: 14px;
            color: #000;
        }

        .blister-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* มือถือ */
        @media (max-width: 768px) {
            .blister-photo-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .blister-photo-box {
                min-height: 220px;
            }
        }

        #blister-static-price {
            border-collapse: collapse !important;
            width: 99%;
            text-align: center;
        }

        #blister-static-price td,
        #blister-static-price th {
            border: 1px solid #cccccc !important;
            padding: 8px 10px;
            text-align: center;
        }

        #blister-static-price thead td {
            background-color: #eeeeee;
        }

        #blister-static-price tbody td:first-child {
            background-color: #eeeeee;
        }

        .blister-size-photo-row {
            display: flex;
            justify-content: space-between;
            gap: 50px;
            margin-top: 20px;
        }

        .blister-size-photo {
            min-width: 0 !important;
            max-width: none !important;
            width: 33.333%;
            text-align: left;
        }

        .blister-photo-title {
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
            color: #000;
        }

        .blister-photo-box {
            background-color: #d9e8f6;
            min-height: 190px;
            border: 1px solid #c7d6e3;
            position: relative;
            padding: 6px;
            font-size: 14px;
            color: #000;
        }

        .blister-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* มือถือให้เรียงลงมา */
        @media (max-width: 768px) {
            .blister-size-photo-row {
                flex-direction: column;
                gap: 20px;
            }

            .blister-size-photo {
                width: 100%;
            }

            .blister-photo-box {
                min-height: 220px;
            }
        }
    </style>

    <!-- lightbox2-master -->
    <link rel="stylesheet" href="https://hotmobily.jp/products/css/lightbox.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://hotmobily.jp/products/css/lightbox.css">
    </noscript>
    <!-- /lightbox2-master -->
</head>

<body id="top">
    <!-- :: header start :: -->
    <?php include("../../header.html"); ?>
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
            <?php include('../banner-campaign.php') ?>

            <?php
            $path_info = __DIR__ . "/acrylic_info.php";
            if (file_exists($path_info)) {
                include($path_info);
            }
            ?>
            <div id="">
                <h1 class="h1-new">ブリスターパック風アクリルキーホルダー（2026年版）</h1>
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
                                <img src="/products/acrylic/img/blister/blisteracrylic-01.webp"
                                    alt="シャカシャカアクリルキーホルダーの製作事例" fetchpriority="high" loading="eager"
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
                                <img src="/products/acrylic/img/blister/blisteracrylic-02.webp"
                                    alt="開いたシャカシャカアクリルキーホルダー" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/blister/blisteracrylic-03.webp"
                                    alt="グレーのシャカシャカアクリルキーホルダー" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/blister/blisteracrylic-04.webp"
                                    alt="シャカシャカアクリルキーホルダーのパーツ" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/blister/blisteracrylic-05.webp"
                                    alt="ピンクのシャカシャカアクリルキーホルダー" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/blister/blisteracrylic-06.webp"
                                    alt="可愛い動物たちのシャカシャカアクリルキーホルダー" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                        </div>
                    </div>

                    <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                        <img src="/products/acrylic/img/blister/blisteracrylic-01.webp" alt="シャカシャカアクリルキーホルダーの製作事例" width="189" height="189"
                            class="pdp-v2-thumb-item" data-index="0" loading="lazy">
                        <img src="/products/acrylic/img/blister/blisteracrylic-02.webp" width="189" height="189"
                            alt="開いたシャカシャカアクリルキーホルダー" class="pdp-v2-thumb-item" data-index="1" loading="lazy">
                        <img src="/products/acrylic/img/blister/blisteracrylic-03.webp" width="189" height="189"
                            alt="グレーのシャカシャカアクリルキーホルダー" class="pdp-v2-thumb-item" data-index="2" loading="lazy">
                        <img src="/products/acrylic/img/blister/blisteracrylic-04.webp" width="189" height="189"
                            alt="シャカシャカアクリルキーホルダーのパーツ" class="pdp-v2-thumb-item" data-index="3" loading="lazy">
                        <img src="/products/acrylic/img/blister/blisteracrylic-05.webp" width="189" height="189"
                            alt="ピンクのシャカシャカアクリルキーホルダー" class="pdp-v2-thumb-item pdp-v2-active-state" data-index="4">
                        <img src="/products/acrylic/img/blister/blisteracrylic-06.webp" width="189" height="189"
                            alt="可愛い動物たちのシャカシャカアクリルキーホルダー" class="pdp-v2-thumb-item" data-index="5" loading="lazy">
                    </div>

                    <div class="action-buttons">
                        <button class="btnz btn-orange" type="button" onclick="GotoDiv(1)" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background-color: #FF9900; border-color: #FF9900; margin-top: 10px; margin-bottom: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                            </svg>
                            この商品を見積・注文する
                        </button>
                        <!-- <a href="/gallery/rubberstrap" class="btnz but3 new-text" style="color:black !important; text-decoration: none !important;">制作事例を見る</a> -->
                        <!-- <a href="/gallery/rubberstrap" class="new-text" style="color:black !important;">制作事例を見る</a> -->
                    </div>
                    <!-- <div>
                        <a href="javascript:void(0)" class="link-text new-text" onclick="GotoDiv(5)"
                            style="color: black;">商品レビューを見る</a>
                    </div> -->
                </div>

                <div class="product-details" id="">
                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個535円</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">100個合計金額：</span>53,500円</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span class=""
                                id="date_create2x1"></span></p>
                    </div>

                    <div class="">
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です。</small><br>
                        <small class="note">※出荷目安は注文個数により異なります。<a href="javascript:void(0)" class=""
                                onclick="GotoDiv(2)">納期詳細はこちら</a></small>
                    </div>

                    <h2 class="promo-title" style="color: #cc3f44; !important;">発想が光る！ブリスターパック風アクリルキーホルダー</h2>

                    <div class="info-card">
                        <h3 class="lpc">最安単価円416（税込）！</h3>
                        <a onclick="GotoDiv(3)" href="javascript:void(0)"><img
                                src="/products/acrylic/img/blister/blisteracrylic-banner01.webp" alt="業界最短7日出荷"
                                width="660" height="100%" loading="lazy"></a>
                        <p class="new-text">最安単価がたったの416円（税込）！大ロットほど単価が安くなりお得です。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(3)">料金の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">発想が光るブリスターパック風！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(10)"><img
                                src="/products/acrylic/img/blister/blisteracrylic-banner02.webp" alt="業界最安値価格" width="660"
                                height="100%" loading="lazy"></a>
                        <p class="new-text">
                            「ブリスターパック風」というユニークな形と、あなたのアイディアをかけ合わせたアクキーをご製作！
                        </p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(10)">ブリスターパック風の特徴詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">はがれない印刷！とっておきの保護フィルム！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(8)"><img
                                src="/products/acrylic/img/blister/blisteracrylic-banner03.webp" alt="汚れ防止加工" width="660"
                                height="100%" loading="lazy"></a>
                        <p class="new-text">当店のブリスターパック風アクリルキーホルダーは、保護フィルムで印刷を保護する仕様。爪が当たったり落としたりしても印刷がはがれません。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text"
                                onclick="GotoDiv(8)">保護フィルムの詳細</a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Accordion Connectable -->
            <br>
            <div id="blister">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="connectable-toggle" class="accordion-input" checked>
                        <label for="connectable-toggle" class="accordion-header" id="video-g">
                            <span class="fw-bold">アイディアと発想力が光るブリスターパック風アクキー！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/blister/blisteracrylic-banner04.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <div>
                                    <p class="new-text">ブリスターパック風アクリルキーホルダーは、アイディアと発想力が光るアクリルグッズです。従来の一般的なアクリルキーホルダーと大きく異なる点は、「ブリスターパック風」であること。キャラクターやVtuber、アイドル、アーティストなどがまるで「パッキング」されたかのようなデザインのアクリルグッズを製作することができます。</p>
                                    <br>
                                    <p class="new-text">ブリスターパック風アクリルキーホルダーは、フロントパーツ、内部パーツ、ベースパーツ、アタッチメントで構成されています。</p>
                                </div>
                                <br>
                                <div>
                                    <img src="/products/acrylic/img/blister/blisteracrylic-parts.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    ①フロントパーツ <br>
                                    ②内部パーツ <br>
                                    ③ベースパーツ <br>
                                    ④アタッチメント

                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Connectable-->

            <!--Accordion Price-->


            <div id="acc-price">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="price-toggle" class="accordion-input" checked>
                        <label for="price-toggle" class="accordion-header" id="price-g">
                            <span class="fw-bold">製作料金（税込）とサイズ</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">サイズ・数量別の単価（税込）は以下になります。</p>
                                <br>
                                <p class="new-text">数量・サイズ別価格表</p>
                                <br>
                                <div class="fixed-thead">
                                    <table
                                        id="blister-static-price"
                                        class="tbl-price tb-w12 blink"
                                        border="1"
                                        cellpadding="5"
                                        cellspacing="0"
                                        style="border-collapse: collapse; width: 99%; text-align: center;">

                                        <thead>
                                            <tr>
                                                <td></td>
                                                <td>Sサイズ</td>
                                                <td>Mサイズ</td>
                                                <td>Lサイズ</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>50</td>
                                                <td>592</td>
                                                <td>759</td>
                                                <td>981</td>
                                            </tr>
                                            <tr>
                                                <td>100</td>
                                                <td>535</td>
                                                <td>697</td>
                                                <td>907</td>
                                            </tr>
                                            <tr>
                                                <td>200</td>
                                                <td>501</td>
                                                <td>642</td>
                                                <td>841</td>
                                            </tr>
                                            <tr>
                                                <td>300</td>
                                                <td>471</td>
                                                <td>594</td>
                                                <td>782</td>
                                            </tr>
                                            <tr>
                                                <td>500</td>
                                                <td>441</td>
                                                <td>558</td>
                                                <td>741</td>
                                            </tr>
                                            <tr>
                                                <td>1000</td>
                                                <td>416</td>
                                                <td>529</td>
                                                <td>705</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <p class="new-text">1000個を超える個数のご注文は <a href="https://hotmobily.jp/contact/">個別にお問い合わせ</a> ください。</p>
                                <br>
                                <p class="new-text">サイズは以下をご確認ください。</p>

                                <table
                                    class="tbl-priced tb-w12 blink"
                                    border="1"
                                    cellpadding="5"
                                    cellspacing="0"
                                    style="border-collapse: collapse; width: 99%; text-align: center; margin-top: 10px; border: 1px solid #999;">

                                    <tbody>
                                        <tr>
                                            <td style="width: 30%; border: 1px solid #999;">Sサイズ</td>
                                            <td style="width: 70%; border: 1px solid #999;text-align: start;">フロントパーツ：50×50mm、ベースパーツ：55×75mm</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%; border: 1px solid #999;">Mサイズ</td>
                                            <td style="width: 70%; border: 1px solid #999;text-align: start;">フロントパーツ：50×75mm、ベースパーツ：75×80mm</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%; border: 1px solid #999;">Lサイズ</td>
                                            <td style="width: 70%; border: 1px solid #999;text-align: start;">フロントパーツ：85×75mm、ベースパーツ：105×80mm</td>
                                        </tr>
                                    </tbody>
                                </table>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id="data_creation">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="data-creation-toggle" class="accordion-input" checked>
                        <label for="data-creation-toggle" class="accordion-header" id="data-creation-g">
                            <span class="fw-bold">データ作成補助が無料！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <a href="https://hotmobily.jp/products/acrylic/cutline_white"> <img src="/products/acrylic/img/blister/blisteracrylic-banner07.webp" alt="" width="100%" loading="lazy">
                                    </a>
                                </div>
                                <br>
                                <p class="new-text">ブリスターパック風アクリルキーホルダーの製作にあたって、カットパスや白押さえなど、専用の入稿データの作成にお悩みの方もいるでしょう。当店では無料のデータ作成補助サービスをご用意。お客様の代わりに入稿データを無料で作成いたします。イラストや写真の画像（JPG、PNG）、PDFなどをお送りください。</p>
                                <br>
                                <a class="new-text" href="https://hotmobily.jp/products/acrylic/cutline_white ">データ作成補助の詳細</a>
                                <br>
                                <br>
                                <p class="new-text">また、カットパス・白押さえにもこだわりがありじぶんで入稿データを作成したい方向けに、データ作成ガイドもご用意しております。</p>
                                <br>
                                <a class="new-text" href="https://hotmobily.jp/lp/acrylic-guide.php?sec=data">データ作成ガイド</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Accordion Template-->
            <br>
            <div id="acc-template">
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
                                    <div
                                        style="display: flex; flex-direction: row; justify-content: center; width: 100%">
                                        <a class="btn-a btn-yellow"
                                            href="/products/acrylic/template/blisterpack-acrylic-template20266030.zip"
                                            target="_blank" download><span><?= lang('テンプレートダウンロード') ?></span></a>
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
                                <p class="new-text">注文数別の出荷予定日は以下です。</p>
                                <br>

                                <!-- Shipping 10 Days -->
                                <!-- <div>
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
                                </div> -->
                                <!-- End Shipping 10 Days -->

                                <!-- Shipping 11 Days -->
                                <!-- <br>
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
                                    <table class="cld_tb">
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
                                </div> -->
                                <!-- End Shipping 11 Days -->

                                <!-- Shipping 12 Days -->
                                <br>
                                <div>
                                    <div style="display: flex">
                                        <div class="delivery">
                                            <span class="btn-a std-btn"><?= lang('50～100個の注文'); ?></span>
                                        </div>
                                        <div class="delivery">
                                            <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                <?= lang('12営業日後出荷'); ?>
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
                                <!-- End Shipping 12 Days -->

                                <!-- Shipping 15 Days -->
                                <br>
                                <div>
                                    <div style="display: flex">
                                        <div class="delivery">
                                            <span class="btn-a std-btn"><?= lang('101～300個の注文'); ?></span>
                                        </div>
                                        <div class="delivery">
                                            <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                <?= lang('15営業日後出荷'); ?>
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
                                            <td><span id="date_create_15day_1"></span></td>
                                            <td><span id="date_create_15day_2"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- End Shipping 15 Days -->

                                <!-- Shipping 16 Days -->
                                <br>
                                <div>
                                    <div style="display: flex">
                                        <div class="delivery">
                                            <span class="btn-a std-btn"><?= lang('301～1000個の注文'); ?></span>
                                        </div>
                                        <div class="delivery">
                                            <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                <?= lang('16営業日後出荷'); ?>
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
                                            <td><span id="date_create_16day_1"></span></td>
                                            <td><span id="date_create_16day_2"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- End Shipping 16 Days -->

                                <br>
                                <p class="new-text">原稿確定日は、デザインや仕様の確認が完了し、制作開始となった日を指します。ご注文後、製品のデザインや仕様等についてのご連絡を当店営業からお客様へメールでお送りいたしますので、ご確認をお願いいたします。</p>
                                <br>
                                <a href="https://hotmobily.jp/contact/index.php" class="new-text">無料サンプルの送付をリクエスト</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Shipping-->

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
                                <div class="exc_pro">
                                    <div class="swiper-container">
                                        <div class="row" style="justify-content: flex-start;">
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part5.webp"
                                                    data-lightbox="img-part-set-5"
                                                    data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part5.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+11円</div>
                                                <a
                                                    href="/products/images/HM_part5.webp"
                                                    data-lightbox="img-part-set-5-1"
                                                    data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part6.webp"
                                                    data-lightbox="img-part-set-6"
                                                    data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part6.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+22円</div>
                                                <a
                                                    href="/products/images/HM_part6.webp"
                                                    data-lightbox="img-part-set-6-1"
                                                    data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part7.webp"
                                                    data-lightbox="img-part-set-7"
                                                    data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part7.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+22円</div>
                                                <a
                                                    href="/products/images/HM_part7.webp"
                                                    data-lightbox="img-part-set-7-1"
                                                    data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part14.webp"
                                                    data-lightbox="img-part-set-14"
                                                    data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part14.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part14.webp"
                                                    data-lightbox="img-part-set-14-1"
                                                    data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part4.webp"
                                                    data-lightbox="img-part-set-4"
                                                    data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part4.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+22円</div>
                                                <a
                                                    href="/products/images/HM_part4.webp"
                                                    data-lightbox="img-part-set-4-1"
                                                    data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part15.webp"
                                                    data-lightbox="img-part-set-15"
                                                    data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part15.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part15.webp"
                                                    data-lightbox="img-part-set-15-1"
                                                    data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part18.webp"
                                                    data-lightbox="img-part-set-18"
                                                    data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part18.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part18.webp"
                                                    data-lightbox="img-part-set-18-1"
                                                    data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part16.webp"
                                                    data-lightbox="img-part-set-16"
                                                    data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part16.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part16.webp"
                                                    data-lightbox="img-part-set-16-1"
                                                    data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part19.webp"
                                                    data-lightbox="img-part-set-19"
                                                    data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part19.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part19.webp"
                                                    data-lightbox="img-part-set-19-1"
                                                    data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part17.webp"
                                                    data-lightbox="img-part-set-17"
                                                    data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part17.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part17.webp"
                                                    data-lightbox="img-part-set-17-1"
                                                    data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part20.webp"
                                                    data-lightbox="img-part-set-20"
                                                    data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part20.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part20.webp"
                                                    data-lightbox="img-part-set-20-1"
                                                    data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part8.webp"
                                                    data-lightbox="img-part-set-8"
                                                    data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part8.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+22円</div>
                                                <a
                                                    href="/products/images/HM_part8.webp"
                                                    data-lightbox="img-part-set-8-1"
                                                    data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part1.webp"
                                                    data-lightbox="img-part-set-1"
                                                    data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part1.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part1.webp"
                                                    data-lightbox="img-part-set-1-1"
                                                    data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part2.webp"
                                                    data-lightbox="img-part-set-2"
                                                    data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part2.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/images/HM_part2.webp"
                                                    data-lightbox="img-part-set-2-1"
                                                    data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part3.webp"
                                                    data-lightbox="img-part-set-3"
                                                    data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/HM_part3.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+11円</div>
                                                <a
                                                    href="/products/images/HM_part3.webp"
                                                    data-lightbox="img-part-set-3-1"
                                                    data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part9.webp"
                                                    data-lightbox="img-part-set-9"
                                                    data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。">
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
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part10.webp"
                                                    data-lightbox="img-part-set-10"
                                                    data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。">
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
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part11.webp"
                                                    data-lightbox="img-part-set-11"
                                                    data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。">
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
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/HM_part12.webp"
                                                    data-lightbox="img-part-set-12"
                                                    data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。">
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
                                                    data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。">
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
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>

                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/acrylic/img/HM_part-um1.jpg"
                                                    data-lightbox="img-part-set-55"
                                                    data-title="アンブレラマーカー">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/acrylic/img/HM_part-um1.jpg"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/acrylic/img/HM_part-um1.jpg"
                                                    data-lightbox="img-part-set-55-1"
                                                    data-title="アンブレラマーカー"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>

                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/acrylic/img/HM_part-um2.jpg"
                                                    data-lightbox="img-part-set-66"
                                                    data-title="アンブレラマーカー+ボールチェーン">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/acrylic/img/HM_part-um2.jpg"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+0円</div>
                                                <a
                                                    href="/products/acrylic/img/HM_part-um2.jpg"
                                                    data-lightbox="img-part-set-66-1"
                                                    data-title="アンブレラマーカー+ボールチェーン"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>

                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/Red_opener.webp"
                                                    data-lightbox="img-part-set-91"
                                                    data-title="<strong>【ボトルオープナー（赤色）】</strong>赤色のボトルオープナーです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/Red_opener.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+55円</div>
                                                <a
                                                    href="/products/images/Red_opener.webp"
                                                    data-lightbox="img-part-set-91-1"
                                                    data-title="<strong>【ボトルオープナー（赤色）】</strong>赤色のボトルオープナーです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>

                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/Blue_opener.webp"
                                                    data-lightbox="img-part-set-92"
                                                    data-title="<strong>【ボトルオープナー（青色）】</strong>青色のボトルオープナーです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/Blue_opener.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+55円</div>
                                                <a
                                                    href="/products/images/Blue_opener.webp"
                                                    data-lightbox="img-part-set-92-1"
                                                    data-title="<strong>【ボトルオープナー（青色）】</strong>青色のボトルオープナーです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>

                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/Purple_opener.webp"
                                                    data-lightbox="img-part-set-93"
                                                    data-title="<strong>【ボトルオープナー（紫色）】</strong>紫色のボトルオープナーです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/Purple_opener.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+55円</div>
                                                <a
                                                    href="/products/images/Purple_opener.webp"
                                                    data-lightbox="img-part-set-93-1"
                                                    data-title="<strong>【ボトルオープナー（紫色）】</strong>紫色のボトルオープナーです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>

                                            <div class="mt-10-part">
                                                <a
                                                    href="/products/images/Black_opener.webp"
                                                    data-lightbox="img-part-set-94"
                                                    data-title="<strong>【ボトルオープナー（黒色）】</strong>黒色のボトルオープナーです。">
                                                    <img
                                                        class="picpro lazy"
                                                        data-src="/products/images/Black_opener.webp"
                                                        width="229"
                                                        height="229"
                                                        loading="lazy" /> </a><br />
                                                <div>+55円</div>
                                                <a
                                                    href="/products/images/Black_opener.webp"
                                                    data-lightbox="img-part-set-94-1"
                                                    data-title="<strong>【ボトルオープナー（黒色）】</strong>黒色のボトルオープナーです。"
                                                    style="font-size: 10px">📷<?= lang('クリックすると拡大します') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="read-more1">
                                        <a href="#" class="btn"><img class="btn_z" src="/products/images/but3-03.webp" width="266" height="40" loading="lazy" /></a>
                                    </div>
                                </div>

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
                <?php include('../../delivery_note.php'); ?>

                <h2 id="est-order">ご注文・見積書作成</h2>

                <div style="overflow: unset!important;">
                    <div class="fixed-contrainer">
                        <h3 class="red">【<?= lang('ブリスターパック風アクリルキーホルダー') ?>】</h3>
                        <span class="total-price"><span class="prd_total">0</span>円<?= lang('（税込）') ?></span>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
                        <div class="step-box">
                            <table class="table_rubber" style="padding: 0">
                                <!-- <tr>
                                    <td><?= lang('納期') ?></td>
                                    <td><span id="sample-prd-delivery"></span></td>
                                </tr> -->
                                <tr>
                                    <td><?= lang('サイズ') ?></td>
                                    <td><span id="sample-prd-size"></span></td>
                                </tr>
                                <!-- <tr>
                                    <td><?= lang('フロントパーツ印刷') ?></td>
                                    <td><span id="sample-prd-print"></span></td>
                                </tr> -->
                                <tr>
                                    <td><?= lang('数量') ?></td>
                                    <td><span id="sample-prd-qty"></span></td>
                                </tr>
                                <!-- <tr>
                                    <td><?= lang('接続パーツ') ?></td>
                                    <td><span id="sample-prd-part-con"></span></td>
                                </tr> -->
                                <tr>
                                    <td><?= lang('試作品') ?></td>
                                    <td><span id="sample-prd-samp"></span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('データ作成補助') ?></td>
                                    <td><span id="sample-prd-trace"></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img class="lazy" data-src="/products/images/HM_part1-2.webp" id="sample-part-pic" class="picpro" width="320" height="320"><br />
                            <span id="sample-part-name"><?= lang('アタッチメント:なし') ?></span>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img class="lazy picpro" data-src="img/coming-soon.webp" style="display: none;" id="sample-paper-pic" width="500" height="500"><br />
                            <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
                        </div>
                    </div>
                    <div class="step-container">
                        <div class="step-box step-list">
                            <ul>
                                <li id="dot-step1" class="active">
                                    <div class="step-number">1</div><span class="step-details"><?= lang('納期・印刷面') ?></span>
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
                        <div style="display: table-column;">
                            <input type="text" name="ItemType" id="strap" value="ブリスターパック風アクリルキーホルダー" />
                            <input type="hidden" id="ms_mode" value="<?php echo (isset($_GET['mode']) ? $_GET['mode'] : "") ?>">
                        </div>
                        <?php
                        //Setup size data
                        switch ($acy_size) {
                            case 'S':
                                $sizeS = "checked";
                                break;
                            case 'M':
                                $sizeM = "checked";
                                break;
                            case 'L':
                                $sizeL = "checked";
                                break;
                            default:
                                $sizeS = "checked";
                                break;
                        }
                        //Setup screen data
                        switch ($acy_color) {
                            case '金色ハトメ':
                                $acy_color1 = "checked";
                                break;
                            case '銀色ハトメ':
                                $acy_color2 = "checked";
                                break;
                            default:
                                $acy_color1 = "checked";
                                break;
                        }
                        //Setup sample data
                        switch ($acy_sample) {
                            case 'あり':
                                $sample = "checked";
                                break;
                        }
                        //Setup trace data
                        switch ($acy_trace) {
                            case 'あり':
                                $trace = "checked";
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
                                            <input type="text" name="design_no" value="<?= $design_no ?>" style="width:100%; height:100%;">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="acy_delivery" value="50～100個：12営業日　101～300個：15営業日　301～1000個：16営業日">

                            <h3><?= lang('サイズ') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_size" value="Sサイズ" <?= $sizeS ?>><?= lang('Sサイズ') ?> <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_size" value="Mサイズ" <?= $sizeM ?>><?= lang('Mサイズ') ?> <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_size" value="Lサイズ" <?= $sizeL ?>><?= lang('Lサイズ') ?> <span class="checkmark"></span></label>
                                </div>
                            </div>

                            <!-- <h3><?= lang('フロントパーツ印刷') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_screen" value="フロントパーツ印刷なし" <?php echo (isset($acy_screen) ? ($acy_screen == "フロントパーツ印刷なし" ? "checked" : "") : "checked") ?>><?= lang('フロントパーツ印刷なし') ?> <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_screen" value="フロントパーツ印刷あり" <?php echo (isset($acy_screen) ? ($acy_screen == "フロントパーツ印刷あり" ? "checked" : "") : "") ?>><?= lang('フロントパーツ印刷あり') ?> <span class="checkmark"></span></label>
                                </div>
                            </div> -->

                            <h3><?= lang('数量') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input class="input-qty" type="number" name="qty" min="5" max="200" step="1" style="text-align: right;" onblur="check_val()" value="<?= $qty ?>"></label>
                                    <div class="error" id="qty-error"></div>
                                </div>
                                <h3 style="font-size: 13px;">※デザイン1種につき1注文となります。デザインが複数ある場合は、デザインごとにご注文ください。</h3>
                            </div>
                        </div>
                        <div class="estimate-content" id="step2">
                            <h3><?= lang('アタッチメント') ?></h3>
                            <div class="flex-container">
                                <div class="preview-container">
                                    <div class="preview-sub flex-container">
                                        <?php
                                        include('part.php');
                                        $i = 0;
                                        for ($i = 0; $i < count($attachment); $i++) {
                                            echo '
                                    <div class="flex-item">
                                    <label class="part-name">
                                    <input type="radio" name="acy_part"  value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($acy_part == $attachment[$i]["part_name"] ? 'checked' : '') . '>
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
                                            <input type="checkbox" class="checkbox" name="acy_paper_select" value="あり" onclick="cal_c()" <?= ($acy_paper_select != "なし" ? ($acy_paper_select != "" ? "checked" : "") : "") ?>>
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
                            <div class="flex-container paper-container">
                                <div class="preview-container">
                                    <div class="preview-sub flex-container" id="paper-preview">
                                        <?php if ($acy_paper_select == "あり") {
                                            include("../acy_paper_preview.php");
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- <h3><?= lang('接続パーツ') ?></h3>
                            <div class="flex-container">
                                <div class="preview-container">
                                    <div class="preview-sub flex-container dsd">
                                        <?php
                                        include('part-connectable.php');
                                        $i = 0;
                                        for ($i = 0; $i < count($attachment_connectable); $i++) {
                                            echo '
                                    <div class="flex-item">
                                    <small>' . $attachment_connectable[$i]["part_name"] . '</small><br>
                                    <label class="part-name">
                                    <input type="radio" name="acy_part_connectable" value="' . $attachment_connectable[$i]["part_name"] . '" onclick="getPartDataC(\'' . $attachment_connectable[$i]["part_name"] . '\')" ' . ($acy_part == $attachment_connectable[$i]["part_name"] ? 'checked' : '') . '>
                                    <img class="lazy" data-src="' . $attachment_connectable[$i]["part_pic"] . '" width="95" height="95" class="picpro">
                                    <br><span class="std_price">+' . ($attachment_connectable[$i]["part_price"] * 1.1) . '円</span>
                                    </label>
                                    </div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="error" id="part-error" style="text-align: center;"></div>
                                </div>
                            </div> -->

                            <h3 style="display: inline;"><?= lang('試作品・データ作成補助') ?></h3><a href="javascript:void(0)" id="opn-modal">詳細</a>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='acy_sample'>
                                            <input type="checkbox" class="checkbox" name="acy_sample" value="あり" onclick="cal_c()" <?= $sample ?>>
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('試作品 (20個以上から)') ?>
                                    </label>
                                    <div class="error" id="sample-error"></div>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='acy_trace'>
                                            <input type="checkbox" class="checkbox" name="acy_trace" value="あり" onclick="cal_c()" <?= $trace ?>>
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('データ作成補助') ?>
                                    </label>
                                    <div id="myModal" class="modal">
                                        <div class="modal-content">
                                            <span class="close-modal">&times;</span>
                                            <p>
                                                <?= lang('アクリル製品を製作する際に必要な、カットパスと白押さえのデータを作成するサービスです。<br/>アドビイラストレータもしくはフォトショップ以外のソフトでデザインを作成した場合には、必ずありを選択してください。') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <p class="red">※完成図シミュレーターを利用される場合、データ作成補助オプションは必要ありません。</p> -->
                            </div>
                        </div>
                        <div class="estimate-content flex-item" id="step3">
                            <div class="flex-container">
                                <div class="flex-item">
                                    <h3><?= lang('製品仕様') ?></h3>
                                    <table class="table_rubber">
                                        <tbody>
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('納期') ?></td>
                                                <td class="" id="prd_production" style="text-align: left;"></td>
                                            </tr> -->
                                            <tr>
                                                <td class="TableLeft"><?= lang('サイズ') ?></td>
                                                <td class="" id="prd_size" style="text-align: left;"></td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('フロントパーツ印刷') ?></td>
                                                <td class="" id="prd_print" style="text-align: left;"></td>
                                            </tr> -->
                                            <tr>
                                                <td class="TableLeft"><?= lang('数量') ?></td>
                                                <td class="" id="prd_qty" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('台紙') ?></td>
                                                <td id="prd_paper" style="text-align: left;"></td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td class="" id="prd_part" style="text-align: left;"></td>
                                            </tr> -->
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('接続パーツ') ?></td>
                                                <td class="" id="prd_part_pj" style="text-align: left;"></td>
                                            </tr> -->
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td class="" id="prd_sample" style="text-align: left;">なし</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                <td class="" id="prd_trace" style="text-align: left;">なし</td>
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
                                                <td class=""><input id="prd_price" type="text" name="prd_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td class=""><input id="prd_part_price" type="text" name="prd_part_price" readonly>円</td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('フロントパーツ印刷') ?></td>
                                                <td class=""><input id="prd_front_print_price" type="text" name="prd_front_print_price" readonly>円</td>
                                            </tr> -->
                                            <tr>
                                                <td class="TableLeft"><?= lang('台紙') ?></td>
                                                <td class=""><input id="prd_paper_price" type="text" name="prd_paper_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                                <td class=""><input id="prd_trace_price" type="text" name="prd_trace_price" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('小計(税込)') ?></td>
                                                <td class=""><input id="prd_sub_total" type="text" name="prd_sub_total" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('お値引き') ?></td>
                                                <td class=""><input id="discount" type="text" name="discount" readonly>円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('合計(税込)') ?></td>
                                                <td class=""><input id="prd_total" type="text" name="prd_total" readonly>円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <table class="table_rubber total_price_tbl">
                                <tbody>
                                    <tr id="">
                                        <td colspan="2" style="background: none;border: none;">
                                            <div class="flex-container btn-container">
                                                <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="setzero();">
                                                <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                                                <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step2');$('#cus_detail').hide();"><?= lang('ｱﾀｯﾁﾒﾝﾄ修正') ?></a>
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
                        <div id="acrylic-btn" class="btn-container">
                            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="validation('back')"><?= lang('戻る') ?></a>
                            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="validation('next')"><?= lang('アタッチメント・オプション入力へ') ?></a>
                        </div>
                    </form>

                    <input class="modal-state" id="modal-7" type="checkbox">
                    <div class="modal">
                        <label class="modal__bg" for="modal-7"></label>
                        <div class="modal__inner modal1" style="height: fit-content;">
                            <label class="modal__close" for="modal-7"></label>
                            <div>
                                <p class="new-text">【シミュレーター使用の注意点】</p>
                                <br>
                                <p class="new-text" style="font-size: 13px !important;">※着日指定、注文後の配送先変更は対応いたしかねます。着日指定をご希望の場合、注文後の配送先変更の可能性がある場合は、シミュレーターを使用しない方法での注文をお願いいたします。</p>
                                <p class="new-text" style="font-size: 13px !important;">※シミュレーターを使わない注文でご提供させて頂いている製作図面確認は省略となります。</p>
                                <p class="new-text" style="font-size: 13px !important;">※カード支払いのみとなります。</p>
                                <p class="new-text" style="font-size: 13px !important;">※シミュレーター使用の注文では台紙なしとなります。</p>
                                <p class="new-text" style="font-size: 13px !important;">※シュミレーター未使用、納期、試作などオプションが異なる別の商品と一緒にカートに入れる事はできません。</p>
                                <p class="new-text" style="font-size: 13px !important;">※背景削除ができる背景の色は白色のみです。</p>
                                <p class="new-text" style="font-size: 13px !important;">※著作権や肖像権を侵害するおそれがあるご注文はお断りしております。</p>
                                <p class="new-text" style="font-size: 13px !important;">※著名な作品を模したデザインは1個のみ、自分用、無料配布などであっても正式な許可が無い限りお断りしております。</p>
                                <br>
                                <p class="new-text">【重要】ご注文確定後のキャンセル・変更について</p>
                                <br>
                                <p class="new-text" style="font-size: 13px !important;">アクリルシミュレーターの特性上、ご注文が確定した直後に工場での製作が開始されます。 そのため、ご注文確定後のキャンセル・デザインや数量の変更、およびご返金はお受けすることができません。デザインや数量等に間違いがないか、十分にご確認の上ご注文をお願いいたします。</p>
                            </div>
                            <div style="display: flex; flex-direction: row; justify-content: center; margin-top: 15px;">
                                <button type="button" onclick="comSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', document.getElementById('form'));" style="padding: 10px; width: 30%; cursor:pointer;">OK</button>
                            </div>
                        </div>
                    </div>

                    <div id="cus_detail" style="display:none;" align="center">
                        <table class="table_rubber" style="display: table;">
                            <tbody>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（姓）') ?></td>
                                    <td class="" style="text-align:left;"><input name="Name_S" id="sname" type="text" maxlength="100" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（名）') ?></td>
                                    <td class="" style="text-align:left;"><input name="Name_F" id="fname" type="text" maxlength="100" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('法人名') ?></td>
                                    <td class="" style="text-align:left;"><input name="Corp_Name" id="Corp_Name" type="text" value="" size="45" maxlength="100"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('郵便番号') ?></td>
                                    <td class="" style="text-align:left;"><input type="text" id="zip" name="zip" maxlength="8" size="15" value="">&nbsp;<input type="button" id="src_btn" onclick="address_fn();" value="住所に変換"><br><span id="error" style="color:red"></span></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('都道府県') ?></td>
                                    <td class="" style="text-align:left;"><input type="text" id="address1" name="prefc" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('以降の住所') ?></td>
                                    <td class="" style="text-align:left;"><input id="address2" name="address" type="text" class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('番地、建物名、部屋番号') ?></td>
                                    <td class="" style="text-align:left;"><input id="address_street" name="address_street" type="text" class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('TELハイフンなし') ?></td>
                                    <td class="" style="text-align:left;"><input name="tel" id="tel" type="text" maxlength="11" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お客様メモ欄') ?></td>
                                    <td class="" style="text-align:left;"><input name="comment" id="comment" type="text" size="45" value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" style="padding: 10px;background: unset;border: unset;">
                                        <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');" value="御社情報確定（PDF出力）">
                                        <div class="remark">&nbsp;※<?= lang('社名や会社名の入力は任意です') ?></div><span id="validate_error" style="color:red"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Order Form -->

            <!--Accordion Customization -->
            <br>
            <div id="protect">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="custom-toggle" class="accordion-input" checked>
                        <label for="custom-toggle" class="accordion-header">
                            <span class="fw-bold">はがれない印刷！保護フィルムで印刷を保護！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/blister/blisteracrylic-banner05 (1).webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">他社とは一線を画す当店のブリスター風アクリルキーホルダーの強みのひとつとして、お客様の大切なデザインを保護する保護フィルムがあります。</p>
                                <br>
                                <p class="new-text">一般的なブリスター風アクリルキーホルダーは保護フィルムがなく、固いものがこすれたり爪で引っかいたりすると、印刷されたデザインがはがれる恐れがあります。しかし、当店のジオラマアクリルスタンド（ジオラマアクスタ）は印刷デザインを保護フィルムで覆っています。このため、印刷がむき出しにならず保護フィルムによって保護され、印刷がはがれる恐れがありません。</p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Customization -->

            <!--Accordion Expression -->
            <br>
            <div id="oshikatsu">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="expression-toggle" class="accordion-input" checked>
                        <label for="expression-toggle" class="accordion-header">
                            <span class="fw-bold">アイディアが光る推し活グッズに！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/blister/blisteracrylic-07.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">ブリスターパック風アクリルキーホルダーは、アイディアを活かしたユニークな推し活グッズとしておすすめできるアクリルグッズです。</p>
                                <br>
                                <p class="new-text">アニメや漫画のキャラクターたちを詰め込んだり、ひとりのキャラクターをそのキャラクターの持ち物やロゴと組み合わせてパックしたりすることで、ユニークで特別感のあるアクリルグッズ製作が可能になります。アイドルやアーティスト、スポーツ選手などの写真を使った製作ももちろん可能。ベースパーツ（背景にあたる部分）にライブステージやスポーツの競技場などをデザインすれば、パッケージの中にライブ会場や競技場を閉じ込めたようなブリスターパック風アクリルキーホルダーを製作することができます。</p>
                                <br>
                                <p class="new-text">他にも、ブリスターパック風アクリルキーホルダーの特色を利用した次のような可能性があります。</p>
                                <br>
                                <h3 class="h3-new fw-bold">デフォルメ化したアニメ・漫画のキャラクターたちをパッキング！</h3>
                                <p class="new-text">作品の中ではカッコよく活躍するキャラクターたちを、可愛くデフォルメ化してブリスターパック風アクリルキーホルダーとしてパッキング！ユニークなデザインと普段とのギャップが、ファンの心をつかみます。ベースパーツ（背景にあたる部分）にもデザインを印刷できるので、アニメや漫画のイメージカラーやロゴを印刷して、完成度の高いアクリルグッズに！推し活グッズとして大人気間違いなし！</p>
                                <br>
                                <h3 class="h3-new fw-bold">あの名シーンを閉じ込めて！</h3>
                                <p class="new-text">ベースパーツに風景を印刷して、名シーンの登場人物たちを詰め込めば、アニメや漫画の人気の名シーンの再現も実現可能。誰もが知る名シーンがパッキングされたデザインは、推し活に励むファンたちの心を躍らせます。バトルアニメであればバトルシーン、日常アニメであれば登場キャラたちの友情が深まったシーンなど、可能性は無限大！</p>
                                <br>
                                <h3 class="h3-new fw-bold">アイドルやVTuberたちをパッキング！</h3>
                                <p class="new-text">人気のアイドルの写真やVTuberのイラストで製作すれば、ユニークで可愛い推し活グッズに仕上がります。アイドルグループのメンバーたちをミニパーツにして詰め込んだり、普段とは違った衣装を着たVTuberをパッキングしてみたり。ベースパーツにもアイドルやVTuberのカラーを活かしたデザインを印刷すれば、完成度の高い推し活グッズを製作できます。</p>
                                <br>
                                <h3 class="h3-new fw-bold">みんなの思い出のライブやコンサートをパッキング！</h3>
                                <p class="new-text">アーティストやミュージシャンなどの写真のパーツを詰め込んで、ベースパーツにライブ会場やコンサート会場、日付を印刷すれば、みんなの思い出のライブやコンサートをパッキングしたブリスターパック風アクリルキーホルダーの出来上がり！単なる推し活グッズではなく、みんなの思い出をカタチにしたアクリルグッズに仕上がります。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Expression -->

            <!--Accordion Oshikatsu -->
            <br>
            <div id="dojin">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="oshikatsu-toggle" class="accordion-input" checked>
                        <label for="oshikatsu-toggle" class="accordion-header">
                            <span class="fw-bold">個性が光るユニークな同人グッズ製作に！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/blister/blisteracrylic-banner06.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">「一般的な同人グッズとは少し違った同人グッズを作りたい」などのことをお考えなら、ブリスターパック風アクリルキーホルダーを強くおすすめできます。従来の一般的なアクリルキーホルダーとは違った趣向のブリスターパック風アクリルキーホルダーは、個性と新しさ、ユニークな発想が光る同人グッズ製作を可能にします。</p>
                                <br>
                                <h3 class="h3-new fw-bold">「キャラクターたちをパッキング」という新しい発想</h3>
                                <p class="new-text">ブリスターパック風アクリルキーホルダーは、「キャラクターたちをパッキングしたアクリルキーホルダー」という新しい発想を可能にするアクリルグッズです。こだわりのキャラクターを単体で、あるいはそのキャラクターの小物やロゴと一緒に、あるいは他のキャラクターと一緒にパッキング。その新しい発想がクリエイターとファンの心をつかみます。</p>
                                <br>
                                <h3 class="h3-new fw-bold">こだわりのワンシーンを演出！</h3>
                                <p class="new-text">ハラハラドキドキのバトルシーンや、日常のひとコマ、キャラクターたちの関係が深まった瞬間など、クリエイターならこだわりのワンシーンがあるはず。そのワンシーンをパッキングできるのがブリスターパック風アクリルキーホルダーです。ワンシーンの背景をベースパーツに印刷し、そのシーンの登場キャラクターたちを詰め込めば、まるであのワンシーンがパッキングされたかのような仕上がりに。ブリスターパック風アクリルキーホルダーは、クリエイターの表現の可能性を広げるアクリルグッズです。</p>
                                <br>
                                <h3 class="h3-new fw-bold">「背景」と「複数のパーツ」を活用したさまざまな演出</h3>
                                <p class="new-text">ベースパーツにデザインを印刷できる点や、複数のパーツをパッキングできる点を活かして、さまざまな表現が可能です。たとえば、特定のキャラクターを連想させるカラーリングのベースパーツ、そのキャラクターの持ち物やロゴのパーツによって、「敢えてキャラクター本人を出さないキャラクターグッズ」を製作できます。この他にも、ブリスターパック風アクリルキーホルダーの特色を活かしたさまざまな表現の可能性が無数に存在します。クリエイターの手腕と発想力を大いに振るうことができます。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Oshikatsu -->

            <!--Accordion One -->
            <br>
            <!-- <div id="acc-one">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="one-toggle" class="accordion-input" checked>
                        <label for="one-toggle" class="accordion-header">
                            <span class="fw-bold">たった1個から注文可能！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/connectable/Connectable-Acrylic-Keychains2.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">2連アクリルキーホルダー（連結キーホルダー）は1個から製作可能です。個人のお客様や「初めてオリジナルグッズを製作するので不安」という方でも、安心してご依頼いただけます。</p>
                                <br>

                                <h3 class="h3-new fw-bold">「自分用」や「家族や友人へのギフト」として</h3>
                                <p class="new-text">「自分で描いたイラストを連結キーホルダーにして手元に置いておきたい」「過去の記念写真で作った連結キーホルダーを家族や友人に配りたい」などの場合にも、ホットモバイリーにご注文・ご相談ください。1個から注文を承っておりますので、「自分用に1個だけ連結キーホルダーを製作したい」「家族や友人への配布用に10個だけ作りたい」などのケースにもぴったりです。</p>
                                <br>

                                <h3 class="h3-new fw-bold">「とりあえず1個作ってみたい」というお試しとして</h3>
                                <p class="new-text">初めてのオリジナルグッズ製作の依頼で不安な場合などに、とりあえず1個だけ注文してみることが可能です。いったん1個だけ作ってみて、その仕上がりを見てから同じデザインで100個や200個などの量産を注文することもできます。</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--End Accordion One -->

            <!--Accordion Protection -->
            <!-- <br> -->
            <!-- <div id="acc-protection">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="protection-toggle" class="accordion-input" checked>
                        <label for="protection-toggle" class="accordion-header">
                            <span class="fw-bold">印刷がはがれない保護フィルム付き！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/connectable/protection_connectible key chain_nomore.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">当店のアクリル製品の強みのひとつが、印刷がはがれるのを防ぐ保護フィルムです。印刷面を保護フィルムがカバーしているため、固いものがこすれたりしても印刷がはがれることがありません。2連アクリルキーホルダー（連結キーホルダー）も例外ではなく、アクリルパーツのひとつひとつに保護フィルムが付いています。</p>
                                <br>
                                <a href="/products/acrylic/filmcoating" class="new-text">保護フィルムの詳細</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--End Accordion Protection -->

            <!--Accordion Print -->
            <!-- <br>
            <div id="acc-print">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="print-toggle" class="accordion-input" checked>
                        <label for="print-toggle" class="accordion-header">
                            <span class="fw-bold">なめらかなカット面を実現！CNCカット！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div class="img-container">
                                    <img src="/products/acrylic/img/connectable/050526-24.webp" alt=""
                                        width="100%" loading="lazy" id="productImg">
                                    <div id="lens" aria-hidden="true"></div>
                                </div>
                                <br>
                                <small>マウスを合わせて拡大</small>
                                <br><br>
                                <p class="new-text">アクリルグッズ製作時のカットにはレーザーが使用されることが多いです。しかし、レーザーを使ってアクリル板をカットすると、カット面に不自然な突起ができます。ごく小さな突起なので目で見るだけではわかりにくいですが、手でカット面に触ると、引っかかりがあるのがわかります。2連アクリルキーホルダーを含め、当店のアクリルグッズは、アクリル板のカットにCNC加工機を使用しております。レーザーとは異なり、不自然な突起のない整ったカット面になります。手で触れても引っかかりのない、なめらかな手触りのカット面に仕上がるのが特長です。</p>
                                <br>
                                <a class="new-text" href="/products/acrylic/roundededge">CNCカットの詳細</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--End Accordion Print -->

            <!--Accordion Factory -->
            <!-- <br>
            <div id="acc-factory">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="factory-toggle" class="accordion-input" checked>
                        <label for="factory-toggle" class="accordion-header">
                            <span class="fw-bold">当店2連アクリルキーホルダー（連結キーホルダー）は完全自社生産です！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/connectable/Connectable-Acrylic-Keychains4.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">2連アクリルキーホルダー（連結キーホルダー）連結キーホルダーを含め、当店のアクリル製品はすべて自社生産です。デザインの印刷、アクリル板のカット、包装まですべて自社工場で完結しています。自社生産のためマージンなどが発生せず、お客様のお求めの製品を低コストで製作することができます。製品のクオリティにも責任をもってこだわっております。お客様のデザインを活かした高品質の連結キーホルダーをお届けいたします。</p>
                                <br>
                                <a class="new-text" href="/products/acrylic/ownfactory">自社生産の詳細</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!--End Accordion Factory -->

            <!--Accordion Spec-->
            <br>
            <div id="information">
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
                                            <td style="text-align: left;"><?= lang('ブリスターパック風アクリルキーホルダー') ?></td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('素材') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('アクリル板3mm厚') ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('サイズ') ?></td>
                                            <td style="text-align: left;">
                                                Sサイズ（フロントパーツ：50*50mm、ベースパーツ：55*75mm）<br>
                                                Mサイズ（フロントパーツ：50*75mm、ベースパーツ：75*80mm）<br>
                                                Lサイズ（フロントパーツ：85*75mm、ベースパーツ：105*80mm）
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('色数') ?></td>
                                            <td style="text-align: left;">
                                                フルカラーUVインクジェット印刷+白押さえが基本となります。<br>
                                                印刷：UV印刷+白押さえ
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('アタッチメント') ?></td>
                                            <td style="text-align: left;">
                                                ボールチェーン、キーリング等
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('台紙') ?></td>
                                            <td style="text-align: left;">
                                                既製品：50種類のデータから選択可<br>
                                                オリジナル印刷：お客様の入稿データを使用し、印刷します<br>
                                                支給された台紙封入、JANシール貼り等の軽作業は、＠22円（税込）でお受けします
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('試作品') ?></td>
                                            <td style="text-align: left;">
                                                注文数20個以上の場合で利用可
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('最小ロット') ?></td>
                                            <td style="text-align: left;">50個</td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('包装') ?></td>
                                            <td style="text-align: left;">個別OPP包装</td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('特徴') ?></td>
                                            <td style="text-align: left;">印刷面をフィルム保護</td>
                                        </tr>

                                        <tr>
                                            <td><?= lang('納期') ?></td>
                                            <td style="text-align: left;">
                                                50～100個：12営業日<br>
                                                101～300個：15営業日<br>
                                                301～1000個：16営業日
                                            </td>
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
            <br>


            <div id="pdp-v2-modal" class="pdp-v2-modal-overlay">
                <div class="pdp-v2-modal-container">
                    <span class="pdp-v2-modal-close">&times;</span>
                    <img class="pdp-v2-modal-content" id="pdp-v2-modal-img" alt="Zoomed view">

                    <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn">
                        <div class="summon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>


            <div id="download_templete" class="download_templete">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h3><?= lang('アクリルフィギュアスタンド') ?>【Illustrator／Photoshop】</h3>
                    <table class="table_rubber">
                        <tbody>
                            <tr>
                                <td>50×50mm</td>
                                <td>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-aurora/template/template-aurora_acrylic_stand_50mm_20250320.ai" download>
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/ai-icon.webp" width="20" height="20" /> <?=
                                                                                                                                        lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-aurora/template/template-aurora_acrylic_stand_50mm_20250320.psd" download>
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/psd-icon.webp" width="20" height="20" /> <?=
                                                                                                                                            lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>75×75mm</td>
                                <td>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-aurora/template/template-aurora_acrylic_stand_75mm_20250320.ai" download>
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/ai-icon.webp" width="20" height="20" /> <?=
                                                                                                                                        lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-aurora/template/template-aurora_acrylic_stand_75mm_20250320.psd">
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/psd-icon.webp" width="20" height="20" /> <?=
                                                                                                                                            lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>100×100mm</td>
                                <td>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-aurora/template/template-aurora_acrylic_stand_100mm_20250320.ai">
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/ai-icon.webp" width="20" height="20" /> <?=
                                                                                                                                        lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-aurora/template/template-aurora_acrylic_stand_100mm_20250320.psd">
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/psd-icon.webp" width="20" height="20" /> <?=
                                                                                                                                            lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="download_temp_data" class="download_templete">
                <div class="modal-content data">
                    <span class="close">&times;</span>
                    <table class="table_rubber">
                        <tbody>
                            <tr>
                                <td>
                                    <a class="btn-a btn-yellow" href="/products/data-acrylic-figure.php" target="_blank">
                                        <div>Illustrator／Photoshopは<?= lang('こちら') ?></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="btn-a btn-yellow" href="/products/clip_studio_data_making.php" target="_blank">
                                        <div>CLIP STUDIO PAINT<?= lang('はこちら') ?></div>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

    <!-- /lightbox2-master -->
    <!-- google script -->
    <!-- リマーケティング タグの Google コード -->
    <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->
    <!-- Swiper JS -->
    <script src="https://hotmobily.jp/products/js/lightbox.js"></script>
    <script type="text/javascript" src="/products/acrylic/js/calculate-blister-pack-style.js?v=<?php echo date('is'); ?>" defer></script>
    <script type="text/javascript" src="/js/common.js?v=1.02"></script>
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=<?php echo date('is'); ?>" defer></script>
    <script type="text/javascript" src="/products/js/date.js" defer></script>
    <script>
        $(document).ready(function() {

            $(".download_temp").each(function(index) {
                $(this).on("click", function() {
                    $(".download_templete").each(function(index2) {
                        if (index2 == index) {
                            $(this, index2).show();
                        }
                    });
                });
            });

            $(".close").click(function(index) {
                $(this).parents().find(".download_templete").hide();
            });

            $(window).click(function(e) {
                if (e.target.className == "download_templete") {
                    $(".download_templete").hide();
                }
            });

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

            // Image list for modal functionality
            const imageList = [
                "/products/acrylic/img/blister/blisteracrylic-01.webp",
                "/products/acrylic/img/blister/blisteracrylic-02.webp",
                "/products/acrylic/img/blister/blisteracrylic-03.webp",
                "/products/acrylic/img/blister/blisteracrylic-04.webp",
                "/products/acrylic/img/blister/blisteracrylic-05.webp",
                "/products/acrylic/img/blister/blisteracrylic-06.webp"
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
            // $('#info_div').load('/info/index.php');

            // Load Price Table
            // const $priceTbl = $('.tbl_price_deli.loading');
            // if ($priceTbl.length) {
            //     $priceTbl.load("../getdate_disp2023-rubber", function (data) {
            //         $(this).replaceWith(data);
            //         $('.tbl_price_deli').removeClass("loading");
            //     });
            // }

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
                $('#date_create2x1').text($('#date_create2').text());
            }

            function productionDate11Days(date) {
                setProductionDate(date, 'date_create_11day_1', 'date_create_11day_2');
            }

            function productionDate12Days(date) {
                setProductionDate(date, 'date_create_12day_1', 'date_create_12day_2');
            }

            function productionDate15Days(date) {
                setProductionDate(date, 'date_create_15day_1', 'date_create_15day_2');
            }

            function productionDate16Days(date) {
                setProductionDate(date, 'date_create_16day_1', 'date_create_16day_2');
            }


            // Get Sample Date
            // $.post("https://hotmobily.jp/products/get_sample_date.php", {
            //     'days': '7',
            //     'format_cal': '12'
            // }, function (data) {
            //     $('.speed_deli_date').html(formatDate(data[1]) + "<br/><div class='ut_date'>7日</diV>");
            //     $('.speed_deli_date2').html(formatDate(data[2]) + "<br/><div class='ut_date'>13日</diV>");
            //     if (typeof productionDate3 === 'function') productionDate3(data.sort());
            // }, "json");

            // Get Sample Date 2
            // $.post("https://hotmobily.jp/products/get_sample_date.php", function (data) {
            //     if (typeof productionDate2 === 'function') productionDate2(data.sort());
            // }, "json");

            // --- 7. MISC UI HANDLERS ---

            // Paper Preview
            $(document).on('change', "input[name='acy_paper_select'][type='checkbox']", function() {
                if ($(this).is(':checked')) {
                    $('.paper-container').show();
                    $('#paper-preview').load('/products/acy_paper_preview.php');
                } else {
                    $('.paper-container').hide();
                    $('#paper-preview').empty();
                    $('input[name="acy_paper"]').prop('checked', false);
                }

                cal_c();
            });

            $(document).on('change', 'input[name="acy_paper"]', function() {
                cal_c();
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
            var tmp = "<?= $_GET['mode'] ?? '' ?>"; // Safety check for PHP
            if (isMobile) {
                $("#i_txt1").attr("src", "images/img_txt2_n1.svg");
                $("#i_txt2").attr("src", "images/text_sample_n1.svg");
            }
            // Assumes getPartData is defined globally
            if (typeof getPartData === 'function') getPartData($('input[name="acy_part"]:checked').val());
            if (tmp != "" && typeof valid_chk_btn === 'function') valid_chk_btn('step3');

            if (typeof getPartDataC === 'function') getPartDataC($('input[name="acy_part_connectable"]:checked').val());
            if (tmp != "" && typeof valid_chk_btn === 'function') valid_chk_btn('step3');

        }); // End Ready

        // --- GLOBAL FUNCTIONS (Keep outside ready to be accessible) ---

        function prd_date1(date) {
            var str = date,
                l = str.length - 1,
                date_f = new Date(str[0]),
                date_l = new Date(str[l]),
                f = new Date();
            var date = new Date();
            var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];
            currentHours = date.getHours();
            currentHours = ("0" + currentHours).slice(-2);
            $('.cld_tb').show();
            $('#date_create').text(add_digi(parseInt(f.getMonth() + 1)) + "月" + add_digi(f.getDate()) + "日(" + dayOfWeekStrJP[f
                .getDay()] + ") " + add_digi(f.getHours()) + ":" + add_digi(f.getMinutes()));
            $('#date_create2').text(add_digi(parseInt(date_l.getMonth() + 1)) + "月" + add_digi(date_l.getDate()) + "日(" +
                dayOfWeekStrJP[date_l.getDay()] + ")");
        }

        function prd_date2(date) {
            var str = date,
                l = str.length - 1,
                date_f = new Date(str[0]),
                date_l = new Date(str[l]),
                f = new Date();
            var date = new Date();
            var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];
            currentHours = date.getHours();
            currentHours = ("0" + currentHours).slice(-2);
            $('.cld_tb').show();
            $('#date_create4').text(add_digi(parseInt(date_l.getMonth() + 1)) + "月" + add_digi(date_l.getDate()) + "日(" +
                dayOfWeekStrJP[date_l.getDay()] + ")");
        }

        function add_digi(num) {
            if (num < 10) {
                return "0" + num;
            } else {
                return num;
            }
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
                    3: '#acc-price',
                    4: '#acc-detail',
                    5: '#reviews',
                    6: '#acc-type',
                    7: '#acc-print',
                    8: '#protect',
                    9: '#replacement',
                    10: '#blister'
                };
                em = map[no];
                if (no == 2) openShippingAccordion();
                if (no == 3) openPriceAccordion();
                if (no == 6) openTypeAccordion();
                if (no == 7) openPrintAccordion();
            } else {
                em = '#' + no;
            }

            if (em && $(em).length) {
                $("html, body").animate({
                    scrollTop: $(em).offset().top - 100
                }, 1000);
            }
        }

        function openSimpleModal(element, act) {
            const modal = document.getElementById('pdp-v2-modal');
            const modalImg = document.getElementById('pdp-v2-modal-img');
            let imgSrc = "";

            if (element.tagName === 'IMG') imgSrc = element.src;
            else {
                const img = element.closest('.flex-item')?.querySelector('swiper-container img');
                if (img) imgSrc = img.src;
            }

            if (imgSrc && modal) {

                $('.summon').css('display', 'block');
                if (act) {
                    $('.summon').css('display', 'none');
                }

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

        function openFrontPrintAccordion() {
            $('#front-print-toggle').prop('checked', true);
            document.getElementById('acc-front-print')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function openDataCreationAccordion() {
            $('#data-creation-toggle').prop('checked', true);
            document.getElementById('acc-data-creation')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function openTypeAccordion() {
            $('#type-toggle').prop('checked', true);
            document.getElementById('acc-type')?.scrollIntoView({
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

        function openPrintAccordion() {
            $('#print-toggle').prop('checked', true);
            document.getElementById('acc-print')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

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
                    console.error("Failed to fetch " + productDays + " holidays.");
                }
            });
        }

        fetchHolidayData("10days", productionDate);
        fetchHolidayData("11days", productionDate11Days);
        fetchHolidayData("12days", productionDate12Days);
        fetchHolidayData("15days", productionDate15Days);
        fetchHolidayData("16days", productionDate16Days);
    </script>
    <script>
        (function() {
            const img = document.getElementById('productImg');
            const lens = document.getElementById('lens');
            const zoom = 2; // change zoom factor (2.2 = 220%)

            // Ensure DOM and image loaded
            function ready(cb) {
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', cb);
                } else cb();
            }

            ready(() => {
                if (!img) return console.error('productImg not found');

                // Wait until image is loaded so getBoundingClientRect works and natural sizes are available
                if (!img.complete) {
                    img.addEventListener('load', init);
                } else {
                    init();
                }
            });

            function init() {
                const lensStyle = getComputedStyle(lens);
                const lensW = parseFloat(lensStyle.width);
                const lensH = parseFloat(lensStyle.height);

                img.addEventListener('mouseenter', () => {
                    lens.style.display = 'block';
                    lens.style.backgroundImage = `url('${img.src}')`;
                    const rect = img.getBoundingClientRect();
                    lens.style.backgroundSize = `${rect.width * zoom}px ${rect.height * zoom}px`;
                });

                // Hide on leave
                img.addEventListener('mouseleave', () => {
                    lens.style.display = 'none';
                });

                window.addEventListener('resize', () => {
                    if (lens.style.display === 'block') {
                        const rect = img.getBoundingClientRect();
                        lens.style.backgroundSize = `${rect.width * zoom}px ${rect.height * zoom}px`;
                    }
                });

                img.addEventListener('mousemove', function(e) {
                    const rect = img.getBoundingClientRect();

                    let x = e.clientX - rect.left;
                    let y = e.clientY - rect.top;

                    if (x < 0) x = 0;
                    if (y < 0) y = 0;
                    if (x > rect.width) x = rect.width;
                    if (y > rect.height) y = rect.height;

                    let left = x - lensW / 2;
                    let top = y - lensH / 2;

                    if (left < 0) left = 0;
                    if (top < 0) top = 0;
                    if (left + lensW > rect.width) left = rect.width - lensW;
                    if (top + lensH > rect.height) top = rect.height - lensH;

                    lens.style.left = `${left}px`;
                    lens.style.top = `${top}px`;

                    const bgX = -(x * zoom - lensW / 2);
                    const bgY = -(y * zoom - lensH / 2);
                    lens.style.backgroundPosition = `${bgX}px ${bgY}px`;
                });
            }
        })();
    </script>
    <script type="text/javascript" src="/js/common.js?v=1.02" defer></script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js" async></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tbl_s").on("click scroll", function() {
                // $(this).find(".scroll-center").hide();
            });
        });

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
                    console.error("Failed to fetch " + productDays + " holidays.");
                }
            });
        }

        function setProductionDate(date, startId, endId) {
            var str = date;
            var l = str.length - 1;
            var date_l = new Date(str[l]);
            var f = new Date();

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

        function productionDate10Days(date) {
            var str = date;
            var l = str.length - 1;
            var date_l = new Date(str[l]);
            var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];

            if (isNaN(date_l.getTime())) {
                console.error('[10days] invalid date:', date);
                return;
            }

            var endText =
                add_digi(parseInt(date_l.getMonth() + 1)) + "月" +
                add_digi(date_l.getDate()) + "日(" +
                dayOfWeekStrJP[date_l.getDay()] + ")";

            $('#date_create2').text(endText);
            $('#date_create2x1').text(endText);
        }

        function productionDate11Days(date) {
            setProductionDate(date, 'date_create_11day_1', 'date_create_11day_2');
        }

        function productionDate12Days(date) {
            setProductionDate(date, 'date_create_12day_1', 'date_create_12day_2');
        }

        function productionDate15Days(date) {
            setProductionDate(date, 'date_create_15day_1', 'date_create_15day_2');
        }

        function productionDate16Days(date) {
            setProductionDate(date, 'date_create_16day_1', 'date_create_16day_2');
        }

        $(function() {
            fetchHolidayData("12days", productionDate10Days);
            fetchHolidayData("11days", productionDate11Days);
            fetchHolidayData("12days", productionDate12Days);
            fetchHolidayData("15days", productionDate15Days);
            fetchHolidayData("16days", productionDate16Days);
        });
    </script>


</body>

</html>