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
    $_SESSION['acy_size'] = '70*70mm';
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
    <meta name="keywords" content="シャカシャカアクリルキーホルダー">
    <meta name="description"
        content="中のパーツが入れ替え自由なシャカシャカアクリルキーホルダーを作りませんか？1個から注文可能で、キャラクターや小物などパーツをいくつ入れても追加料金は一切かかりません。完全自社生産で高品質＆低コストを実現。あなただけのオリジナルグッズを手軽に製作できます。">
    <meta name="robots" content="index,follow" />
    <title>パーツ追加無料！シャカシャカアクリルキーホルダーを1個から作成</title>
    <link rel="canonical" href="https://hotmobily.jp/products/acrylic/syaka-syaka-acrylic-keyholder">
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

        @media (max-width: 576px) {
            .delivery .btn-a {
                font-size: 4vw !important;
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
                <h1 class="h1-new">シャカシャカアクリルキーホルダー（2026年版）</h1>
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
                                <img src="/products/acrylic/img/syaka/syakasyaka_acrylic01.webp"
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
                                <img src="/products/acrylic/img/syaka/syakasyaka_acrylic02.webp"
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
                                <img src="/products/acrylic/img/syaka/syakasyaka_acrylic03.webp"
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
                                <img src="/products/acrylic/img/syaka/syakasyaka_acrylic04.webp"
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
                                <img src="/products/acrylic/img/syaka/syakasyaka_acrylic05.webp"
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
                                <img src="/products/acrylic/img/syaka/syakasyaka_acrylic06.webp?v=1"
                                    alt="可愛い動物たちのシャカシャカアクリルキーホルダー" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                        </div>
                    </div>

                    <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                        <img src="/products/acrylic/img/syaka/syakasyaka_acrylic01.webp" alt="シャカシャカアクリルキーホルダーの製作事例" width="189" height="189"
                            class="pdp-v2-thumb-item" data-index="0" loading="lazy">
                        <img src="/products/acrylic/img/syaka/syakasyaka_acrylic02.webp" width="189" height="189"
                            alt="開いたシャカシャカアクリルキーホルダー" class="pdp-v2-thumb-item" data-index="1" loading="lazy">
                        <img src="/products/acrylic/img/syaka/syakasyaka_acrylic03.webp" width="189" height="189"
                            alt="グレーのシャカシャカアクリルキーホルダー" class="pdp-v2-thumb-item" data-index="2" loading="lazy">
                        <img src="/products/acrylic/img/syaka/syakasyaka_acrylic04.webp" width="189" height="189"
                            alt="シャカシャカアクリルキーホルダーのパーツ" class="pdp-v2-thumb-item" data-index="3" loading="lazy">

                        <img src="/products/acrylic/img/syaka/syakasyaka_acrylic05.webp" width="189" height="189"
                            alt="ピンクのシャカシャカアクリルキーホルダー" class="pdp-v2-thumb-item pdp-v2-active-state" data-index="4">
                        <img src="/products/acrylic/img/syaka/syakasyaka_acrylic06.webp?v=1" width="189" height="189"
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
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個1,021円（税込）</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">100個合計金額：</span>102,100円（税込）</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span class=""
                                id="date_create2x1"></span></p>
                    </div>

                    <div class="">
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です。</small><br>
                        <!-- <small class="note">※上記よりも早くお届けする6営業日後出荷コースもございます。<a href="javascript:void(0)" class=""
                                onclick="GotoDiv(2)">納期詳細はこちら</a></small> -->
                    </div>

                    <h2 class="promo-title" style="color: #cc3f44; !important;">
                        振って楽しい♪ 詰め替えて楽しいシャカシャカアクキー</h2>

                    <div class="info-card">
                        <h3 class="lpc">最安単価656円（税込）！</h3>
                        <a onclick="GotoDiv(3)" href="javascript:void(0)"><img
                                src="/products/acrylic/img/syaka/syaka_price_v2.webp?v=1" alt="業界最短7日出荷"
                                width="660" height="100%" loading="lazy"></a>
                        <p class="new-text">大ロット製作ほどお得！1,000個製作の場合で1個あたりの製作料金が656円（税込）になります。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(3)">制作料金の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">クルッと開く！入れ替えできる！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(9)"><img
                                src="/products/acrylic/img/syaka/Syaka_open.webp?c=1" alt="業界最安値価格" width="660"
                                height="100%" loading="lazy"></a>
                        <p class="new-text">
                            アクリルキーホルダーのフレーム内のパーツを自由に入れ替え可能です。カスタマイズが楽しいアクリルキーホルダー！
                        </p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(9)">詰め替えの詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">制作料金内でパーツの個数が自由！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(8)"><img
                                src="/products/acrylic/img/syaka/70mm_banner-01.webp?k=1" alt="汚れ防止加工" width="660"
                                height="100%" loading="lazy"></a>
                        <p class="new-text">規定サイズの範囲内であれば、デザインもパーツの個数も自由です。パーツの個数によって料金が変わることがありません。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text"
                                onclick="GotoDiv(8)">デザインとパーツの詳細</a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Accordion Video -->
            <br>
            <div id="acc-video">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="video-toggle" class="accordion-input" checked>
                        <label for="video-toggle" class="accordion-header" id="video-g">
                            <span class="fw-bold">振って楽しい！詰め替えて楽しい！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <iframe width="100%" height="388" src="https://www.youtube.com/embed/A0J3bhxzYhM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                                <br>
                                <div>
                                    <p class="new-text">シャカシャカアクリルキーホルダーの最大の魅力は、思わず何度も振ってみたくなる楽しさにあります。手元でシャカシャカと振ると、リズミカルな音とともに、小さなパーツたちがフレームの中を元気いっぱいに動き回ります。まるで小さな世界を持ち歩いているかのような遊び心満載のデザインは、お子様や若い世代の方にとくに喜ばれるアイテムです。</p>
                                    <br>
                                    <p class="new-text">また、当店シャカシャカアクリルキーホルダーのもうひとつの大きな魅力は「中身を自由に入れ替えられる」ことです。本体をクルッと開閉できるようになっており、中のパーツの配置を変えたり、お好みのパーツを足したりと、アレンジは無限大！作る楽しさと持ち歩く嬉しさの両方を味わえるアイテムです。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Video-->

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
                            <div class="plan-section">
                                <p class="new-text">注文数量ごとの単価（税込）は以下になります。</p>
                                <br>

                                <div class="prod-sched-scroll-box">
                                    <p class="new-text">数量別価格表（税込）</p>
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th class="prod-sched-empty-header">数量</th>
                                                <th class="prod-sched-empty-header">単価</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>1,554</td>
                                            </tr>
                                            <tr>
                                                <td>10</td>
                                                <td>1,460</td>
                                            </tr>
                                            <tr>
                                                <td>20</td>
                                                <td>1,417</td>
                                            </tr>
                                            <tr>
                                                <td>30</td>
                                                <td>1,339</td>
                                            </tr>
                                            <tr>
                                                <td>50</td>
                                                <td>1,269</td>
                                            </tr>
                                            <tr>
                                                <td>100</td>
                                                <td>1,021</td>
                                            </tr>
                                            <tr>
                                                <td>200</td>
                                                <td>861</td>
                                            </tr>
                                            <tr>
                                                <td>300</td>
                                                <td>783</td>
                                            </tr>
                                            <tr>
                                                <td>500</td>
                                                <td>724</td>
                                            </tr>
                                            <tr>
                                                <td>1000</td>
                                                <td>656</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>

                                <p class="new-text">1,000個を超える個数のご注文については、個別に<a href="/contact" class="new-text">お問い合わせ</a>ください。</p>
                                <br>
                                <p class="new-text">製作には、AI形式の入稿データ（デザインデータ）が必要です。ご自身でデータを作成するのは難しい方向けに、データ作成補助サービス（税込2,000円）をご用意しております。お送り頂いたイラストや写真を元に、入稿データ作成を代行いたします。</p>
                                <br>
                                <p class="new-text">※データ作成補助サービスをご希望の方は、注文フォーム上で「データ作成補助」をご選択ください。また、入稿データのベースとなるデザイン（イラストや写真などのデータ）のアップロードを注文フォーム上でお願いいたします。注文時のデザインのアップロードが難しい場合は、メール等で後ほどお送り頂くことも可能です。</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Price-->

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
                                            href="/products/acrylic/template/シャカシャカアクリルキーホルダーテンプレート20260603.zip"
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
                                <!-- <br>
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
                                </div> -->
                                <!-- End Shipping 16 Days -->

                                <br>
                                <p class="new-text">原稿確定日は、デザインや仕様の確認が完了し、制作開始となった日を指します。ご注文後、製品のデザインや仕様等についてのご連絡を当店営業からお客様へメールでお送りいたしますので、ご確認をお願いいたします。</p>
                                <br>
                                <a href="/howtoorder/acrylic.html" class="new-text">注文の流れはこちら</a>

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
                                        <div class="row">
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

            <!--Accordion Design-->
            <br>
            <div id="acc-design">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="design-toggle" class="accordion-input" checked>
                        <label for="design-toggle" class="accordion-header" id="design-g">
                            <span class="fw-bold">デザインもパーツの個数も自由！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/syaka/70mm_banner-02.webp" alt="" loading="lazy" width="100%" height="100%">
                                </div>
                                <br>
                                <div>
                                    <p class="new-text">当店のシャカシャカアクリルキーホルダーは、「70mm×70mmのサイズ内なら、本体のケースも中のパーツもすべて自由にデザインできる」という圧倒的な自由度も大きなポイントです。本体の形状を丸や星の形にしたり、中のパーツを自作のイラストやロゴにしたりと、アイデア次第で表現は無限大です！ブランドのノベルティや、クリエイター様のオリジナルグッズとして、他にはないインパクトと特別感のあるアイテムを制作できます。</p>
                                    <br>

                                    <p class="new-text">※パーツを入れるスペースは65mm×65mm以内です。</p>
                                    <p class="new-text">※アタッチメントの取り付け穴とハトメは一直線上に配置する必要があります。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Design-->

            <!--Accordion Data Creation-->
            <div id="acc-data_creation">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="data_creation-toggle" class="accordion-input" checked>
                        <label for="data_creation-toggle" class="accordion-header" id="data_creation-g">
                            <span class="fw-bold">選べるハトメカラー！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <p class="new-text">ハトメ部分のカラーを、「金色」「銀色」の2色からご選択頂けます。</p>
                                    <br>
                                    <div class="poster-grid">
                                        <div class="poster-item">
                                            <div class="text-center" style="text-align:center;">
                                                <p class="new-text">金色ハトメ</p>
                                            </div>
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this, 1)"
                                                    src="/products/acrylic/img/syaka/syaka_gold.webp"
                                                    alt="Poster 1" />
                                                <div class="camera-left"
                                                    style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                    📷<?= lang('クリックして拡大') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="poster-item">
                                            <div class="text-center" style="text-align:center;">
                                                <p class="new-text">銀色ハトメ</p>
                                            </div>
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this, 1)"
                                                    src="/products/acrylic/img/syaka/syaka_silver.webp"
                                                    alt="Poster 2" />
                                                <div class="camera-left"
                                                    style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                    📷<?= lang('クリックして拡大') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <p class="new-text">シャカシャカアクリルキーホルダーは、「フレーム表側」「パーツ収納枠」「フレーム裏側」の3枚のアクリルプレートの組み合わせです。この3枚がバラバラにならないように固定する部品がハトメです。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Data Creation -->


            <!-- Order Form -->
            <br>
            <div id="order-form">
                <?php include('../campaign_banner.php') ?>
                <?php include('../../delivery_note.php'); ?>

                <h2 id="est-order">ご注文・見積書作成</h2>

                <div style="overflow: unset!important;">
                    <div class="fixed-contrainer">
                        <h3 class="red">【<?= lang('シャカシャカアクリルキーホルダー') ?>】</h3>
                        <span class="total-price"><span class="prd_total">0</span>円<?= lang('（税込）') ?></span>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
                        <div class="step-box">
                            <table class="table_rubber" style="padding: 0">
                                <tr>
                                    <td><?= lang('サイズ') ?></td>
                                    <td><span id="sample-prd-size"></span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('ハトメ') ?></td>
                                    <td><span id="sample-prd-color"></span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('数量') ?></td>
                                    <td><span id="sample-prd-qty"></span></td>
                                </tr>
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
                            <img class="lazy" data-src="img/coming-soon.webp" style="display: none;" id="sample-paper-pic" class="picpro" width="500" height="500"><br />
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
                            <input type="text" name="ItemType" id="strap" value="シャカシャカアクリルキーホルダー" />
                            <input type="hidden" id="ms_mode" value="<?php echo (isset($_GET['mode']) ? $_GET['mode'] : "") ?>">
                        </div>
                        <?php
                        //Setup delivery data
                        switch ($acy_delivery) {
                            case '10営業日':
                                $delivery_10 = "checked";
                                break;
                            case '6営業日':
                                $delivery_6 = "checked";
                                break;
                            default:
                                $delivery_10 = "checked";
                                break;
                        }
                        //Setup size data
                        switch ($acy_size) {
                            case '50':
                                $size50 = "checked";
                                break;
                            case '75':
                                $size75 = "checked";
                                break;
                            case '100':
                                $size100 = "checked";
                                break;
                            default:
                                $size50 = "checked";
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


                            <!-- <div class="part-container">
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="acy_simulator" value="いいえ" onclick="check_simulator_interaction()" <?= ($acy_simulator == "いいえ" || $acy_simulator == "") ? "checked" : "" ?>><?= lang('いいえ') ?> <span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="acy_simulator" value="はい" onclick="check_simulator_interaction()" <?= ($acy_simulator == "はい") ? "checked" : "" ?>><?= lang('はい') ?> <span class="checkmark"></span></label>
                            </div>
                        </div> -->

                            <!-- <h3>納期</h3>
                            <div class="acy_delivery">
                            <?php include('../alert-btn.php') ?>
                            <div class="part-container">
                                <div class="part-content">
                                <label class="part-name"><input type="radio" name="acy_delivery" value="10営業日" onclick="check_val('next')" <?= $delivery_10 ?>>10<?= lang('営業日') ?><span class="checkmark"></span></label>
                                </div>
                                <div class="part-content ">
                                <label class="part-name" <?= $delivery_disabled ?>><input type="radio" name="acy_delivery" value="6営業日" onclick="check_val('next')" <?= $delivery_6 ?>>6<?= lang('営業日') ?> <span class="checkmark"></span></label>
                                </div>
                            </div>
                        </div> -->

                            <!-- <h3><?= lang('サイズ') ?></h3>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="acy_size" value="50" onclick="check_val('next')" <?= $size50 ?>>50x50mm. <span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="acy_size" value="75" onclick="check_val('next')" <?= $size75 ?>>75x75mm. <span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="acy_size" value="100" onclick="check_val('next')" <?= $size100 ?>>100x100mm. <span class="checkmark"></span></label>
                            </div>
                        </div> -->

                            <h3><?= lang('ハトメ') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_color" value="金色ハトメ" onclick="" <?= $acy_color1 ?>><?= lang('金色ハトメ') ?> <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_color" value="銀色ハトメ" onclick="" <?= $acy_color2 ?>><?= lang('銀色ハトメ') ?> <span class="checkmark"></span></label>
                                </div>
                            </div>

                            <h3><?= lang('数量') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input class="input-qty" type="number" name="qty" style="text-align: right;" onblur="check_val()" value="<?= $qty ?>"></label>
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
                                        include('part-syaka.php');
                                        $i = 0;
                                        for ($i = 0; $i < count($attachment); $i++) {
                                            echo '
                                                    <div class="flex-item">
                                                    <label class="part-name">
                                                    <input type="radio" name="acy_part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($acy_part == $attachment[$i]["part_name"] ? 'checked' : '') . '>
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
                                            <tr>
                                                <td class="TableLeft"><?= lang('ハトメ') ?></td>
                                                <td class="" id="prd_color" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('数量') ?></td>
                                                <td class="" id="prd_amount" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td class="" id="prd_part" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('台紙') ?></td>
                                                <td class="" id="prd_paper" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td class="" id="prd_sample" style="text-align: left;">なし')?></td>
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




                <!-- <div style="padding: 20px; text-align:center; background-color: yellow; margin-top: 10px;">
                    Order Form Here
                </div> -->
            </div>
            <!-- End Order Form -->

            <!--Accordion Strength -->
            <br>
            <div id="acc-strength">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="strength-toggle" class="accordion-input" checked>
                        <label for="strength-toggle" class="accordion-header">
                            <span class="fw-bold">【他社と違う！】決まった料金内で自由にカスタマイズ！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/syaka/our_syakasyaka.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">オリジナルシャカシャカアクリルキーホルダー製作の依頼先を検討していて、下記のようにお悩みではないでしょうか。</p>
                                <br>

                                <p class="new-text">・フレームと中のパーツが別売りで、発注が面倒。</p>
                                <p class="new-text">・フレームが密閉される仕様のため、後から中身の入れ替えができない。</p>
                                <p class="new-text">・中に入れたいパーツがたくさんあるのに、個数を増やすと追加料金がかかってしまう。</p>
                                <p class="new-text">・当社のシャカシャカアクリルキーホルダー製作サービスなら、そんなお悩みをすべて解消します。お客様の「こんなのを作りたい！」というこだわりを、妥協することなく形にできる当店の強みをご紹介します。</p>

                                <div>
                                    <h2 style="color: #333;" class="h3-new fw-bold">フレームも中身も「すべてセット」でラクラク注文！</h2>
                                    <p class="new-text">
                                        他社ではフレームとアクリルパーツを別々に注文しなければならないケースもありますが、当社はフレームとアクリルパーツをまとめてひとつのセットとしてご注文いただけます。
                                    </p>
                                </div>

                                <div>
                                    <h2 style="color: #333;" class="h3-new fw-bold">フレームを開閉できる！パーツの入れ替えが自由自在</h2>
                                    <p class="new-text">
                                        当店のシャカアクリルキーホルダーは、フレームが開閉可能な設計になっています。他社のシャカシャカアクリルキーホルダーのなかには、フレームが完全に密閉されていて中のアクリルパーツを変更できないケースもありますが、当社の製品なら、好きなときにフレームを開いてパーツの入れ替えや配置の変更が可能です。「今日はこのキャラとこのキャラを入れよう！」といった、ユーザー側の遊び心をくすぐるギミックです。
                                    </p>
                                </div>

                                <div>
                                    <h2 style="color: #333;" class="h3-new fw-bold">中のパーツはいくつ作っても追加料金ゼロ！</h2>
                                    <p class="new-text">
                                        「キャラクターをたくさん入れたい」「星やハートの小物をいっぱい詰め込みたい」といったご要望も大歓迎です。当社では、フレームの中に入れるパーツの個数によって料金が変動することはありません。他社では、「パーツが〇個以上の場合はプラス〇〇円」といった追加料金制になっていることもありますが、当店であれば予算内で思う存分こだわりのデザインを実現できます。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Strength -->

            <!-- Section Replacement -->
            <br>
            <div id="replacement">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="replacement-toggle" class="accordion-input" checked>
                        <label for="replacement-toggle" class="accordion-header">
                            <span class="fw-bold">パーツの入れ替え方法</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">当店のシャカシャカアクリルキーホルダーは、アタッチメントを外すと、フレームを開閉できる仕様になっています。</p>

                                <h3 class="h3-new fw-bold">1.アタッチメントを取り外してフレームを開き、パーツを入れ替える</h3>
                                <div class="d-flex pop">
                                    <div class="flex-item w-30">
                                        <img src="/products/acrylic/img/syaka/how_to_syaka01.webp" class="w-100">
                                    </div>
                                    <div class="flex-item w-70">
                                        <p class="new-text">アタッチメントを取り外し、シャカシャカアクリルキーホルダーのフレームの表側を横にスライドさせることで、フレームを開くことができます。フレームを開いたら、自由にパーツの出し入れが可能です。</p>
                                    </div>
                                </div>
                                <div>&nbsp;</div>


                                <h3 class="h3-new fw-bold">2.フレームを閉じ、アタッチメントを取り付ける。</h3>
                                <div class="d-flex pop">
                                    <div class="flex-item w-30">
                                        <img src="/products/acrylic/img/syaka/how_to_syaka02.webp" class="w-100">
                                    </div>
                                    <div class="flex-item w-70">
                                        <p class="new-text">フレームの表側をスライドさせてフレームを閉じ、アタッチメントを取り付ければ、パーツの入れ替え完了です。</p>
                                    </div>
                                </div>
                                <div>&nbsp;</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Replacement -->

            <!--Accordion Customization -->
            <br>
            <div id="acc-custom">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="custom-toggle" class="accordion-input" checked>
                        <label for="custom-toggle" class="accordion-header">
                            <span class="fw-bold">楽しいカスタマイズ</span>

                            <span class="arrow-dove"></span>
                        </label>
                        <div>
                            <img src="/products/acrylic/img/syaka/syaka_fun02_v2.webp" alt=""
                                width="100%" loading="lazy">
                        </div>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <!-- <div>
                                    <img src="/products/acrylic/img/syaka/blank.webp" alt=""
                                        width="100%" loading="lazy">
                                </div> -->
                                <br>
                                <p class="new-text">
                                    当社のシャカシャカアクリルキーホルダーが持つ最大の魅力のひとつが、カスタマイズの楽しさです。フレームをいつでも自由に開閉できる設計のため、その日の気分や持ち物に合わせて、中に入れるパーツを自由に組み替えることができます。
                                </p>
                                <br>
                                <p class="new-text">たとえば、お気に入りのキャラクターパーツと一緒に、春は桜、冬は雪の結晶といった季節のパーツを入れ替えて四季の移ろいを楽しんだり、一緒に出かける場所に合わせて中身のアイテムを変えてみたりと、小さなフレームの中に自分だけの特別な世界を何度でも作り直すことができるのです。パーツが動くたびに「シャカシャカ」と鳴る心地よい音色とともに、自分好みに配置したレイアウトが揺れ動く様子は、何度見ても飽きることがありません。まるで小さなドールハウスやジオラマを模様替えするようなワクワク感を、手のひらサイズで手軽に味わうことができます。</p>
                                <br>
                                <p class="new-text">さらに、このカスタマイズの楽しさを最大限に引き出すのが、「中のパーツをいくつ作っても追加料金がかからない」という当社のもうひとつの強みです。パーツの数で料金が変動しないため、メインとなるデザインだけでなく、星やハート、キラキラとしたエフェクトなど、世界観を彩る細かなサブパーツを予算の心配なくたっぷりと制作してセットにすることができます。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Customization -->

            <!--Accordion One -->
            <br>
            <div id="acc-one">
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
                                    <img src="/products/acrylic/img/syaka/syaka_one_v2.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    当店のシャカシャカアクリルキーホルダーは、なんと1個からの小ロット製作が可能です。「業者に頼むと何十個も作らなきゃいけないのでは」という心配はいりません。あなたのアイデアや大切な思い出を、世界に一つだけの特別な「動く」キーホルダーとして形にできます。
                                </p>

                                <h3 class="h3-new fw-bold">写真や思い出のイラストで！友人・恋人とのおそろいグッズに</h3>
                                <p class="new-text">スマートフォンのカメラロールに眠っているとっておきの写真や、みんなで描いたイラストを使って、仲良しグループや恋人とのおそろいグッズを製作することも可能です。たとえば、愛犬や愛猫の写真、旅行の思い出のワンシーン、あるいは仲間内だけで通じるちょっと笑えるイラストなどを小さなアクリルパーツにして、可愛いフレームに閉じ込めることができます。フレームは自由に開閉できるため、「今日はこの写真パーツを入れよう！」と、その日の気分で中身を入れ替えることも可能です。</p>

                                <h3 class="h3-new fw-bold">自分のイラストを触れる「形」にする感動を</h3>
                                <p class="new-text">趣味でイラストを描いている方にとって、自分の作品が画面から飛び出し、カチャカチャと音を立てる立体的なグッズになる瞬間は格別な喜びがあります。当店のシャカシャカアクキーなら、あなたの描いたキャラクターが小さなパーツとなって、透明なケースの中で生き生きと動き回ります。しかも、中に入れるパーツの個数によって追加料金はかかりません。メインのキャラクターだけでなく、あなたの絵柄に合わせた星やハート、魔法陣、キラキラのエフェクトなど、世界観を彩る小物パーツを予算を気にせずたっぷりと描き下ろして詰め込むことができます。自分へのご褒美として、これまでにない達成感とワクワク感を味わえるはずです。</p>

                                <h3 class="h3-new fw-bold">同人活動やクリエイターの新作頒布グッズとして</h3>
                                <p class="new-text">同人誌即売会やクリエイターズマーケットなどでの頒布用グッズとしても、シャカシャカアクキーが大活躍します。1個から製作できるため、「まずは自分用のサンプルとして1つ作って、色味や動きを確認したい」「在庫リスクを抱えずに、少人数のコアなファンに向けて限定グッズを作りたい」といった同人活動ならではの細やかなニーズにも完璧にお応えします。手に取ってくれたファンの方が、後から自分でパーツを組み替えて遊べるという「体験」もできるため、SNSでの写真映えや満足度も非常に高くなります。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion One -->

            <!--Accordion Protection -->
            <br>
            <div id="acc-protection">
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
                                    <a href="/products/acrylic/filmcoating"><img src="/products/acrylic/img/syaka/syaka_protectv3.webp" alt="" width="100%" loading="lazy"></a>
                                </div>
                                <br>
                                <p class="new-text">
                                    当店のアクリル製品の強みのひとつが、印刷がはがれるのを防ぐ保護フィルムです。印刷面を保護フィルムがカバーしているため、固いものがこすれたりしても印刷がはがれることがありません。シャカシャカアクリルキーホルダーも例外ではなく、フレーム自体はもちろん、中のパーツ1個1個に保護フィルムが付いています。
                                </p>
                                <br>
                                <div style="text-align: left;">
                                    <a href="/products/acrylic/filmcoating" class="new-text"
                                        style="color: blue;">保護フィルムの詳細</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Protection -->

            <!--Accordion Factory -->
            <br>
            <div id="acc-factory">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="factory-toggle" class="accordion-input" checked>
                        <label for="factory-toggle" class="accordion-header">
                            <span class="fw-bold">当店シャカシャカアクキーは完全自社生産です！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img onclick="openSimpleModal(this, 1)"
                                        src="/products/acrylic/img/syaka/in-house-production_banner-01_1.webp"
                                        alt="Poster 1" />
                                    <div class="camera-left"
                                        style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                        📷<?= lang('クリックすると拡大します') ?>
                                    </div>
                                </div>
                                <br>
                                <p class="new-text">
                                    シャカシャカアクリルキーホルダーを含め、当店のアクリル製品はすべて自社生産です。デザインの印刷、アクリル板のカット、包装まですべて自社工場で完結しています。自社生産のためマージンなどが発生せず、お客様のお求めの製品を低コストで製作することができます。製品のクオリティにも責任をもってこだわっております。お客様のデザインを活かした高品質のシャカシャカアクリルキーホルダーをお届けいたします。
                                </p>
                                <br>
                                <div style="text-align: left;">
                                    <a href="/products/acrylic/ownfactory" class="new-text"
                                        style="color: blue;">自社生産の詳細</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Factory -->

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
                                            <td style="text-align: left;"><?= lang('シャカシャカアクリルキーホルダー') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('素材') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('フレーム : 3mm厚アクリル') ?>
                                                <br>
                                                パーツ : 2mm厚アクリル
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('サイズ') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('70mm×70mm以内') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('色数') ?></td>
                                            <td style="text-align: left;">
                                                フルカラーUVインクジェット印刷+白押さえが基本となります。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('アタッチメント') ?></td>
                                            <td style="text-align: left;">
                                                各色ボールチェーン
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('台紙') ?></td>
                                            <td style="text-align: left;">
                                                既製品：50種類のデータから選択可<br>
                                                オリジナル印刷：お客様の入稿データを使用し、印刷します<br>
                                                支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('試作品') ?></td>
                                            <td style="text-align: left;">
                                                20以上のご注文から可能です。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('最小ロット') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('1個') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('包装') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('個別OPP包装') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('納期') ?></td>
                                            <td style="text-align: left;">
                                                1～10個 : 10営業日後出荷<br>
                                                11～30個 : 11営業日後出荷<br>
                                                31～100個 : 12営業日<br>
                                                101～300個 : 15営業日<br>
                                                301～1,000個 : 16営業日
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('特徴') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('印刷面を保護フィルムで保護/レーザーカット') ?>
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
            <br>
            <!--End Accordion Acrylic Lists-->


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
    <script type="text/javascript" src="/products/acrylic/js/calculate-syaka-acrylic.js?v=<?php echo date('is'); ?>" defer></script>
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
                "/products/acrylic/img/syaka/syakasyaka_acrylic01.webp",
                "/products/acrylic/img/syaka/syakasyaka_acrylic02.webp",
                "/products/acrylic/img/syaka/syakasyaka_acrylic03.webp",
                "/products/acrylic/img/syaka/syakasyaka_acrylic04.webp",
                "/products/acrylic/img/syaka/syakasyaka_acrylic05.webp",
                "/products/acrylic/img/syaka/syakasyaka_acrylic06.webp?v=1"
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

            fetchHolidayData("10days", productionDate);
            fetchHolidayData("11days", productionDate11Days);
            fetchHolidayData("12days", productionDate12Days);
            fetchHolidayData("15days", productionDate15Days);
            fetchHolidayData("16days", productionDate16Days);





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
            $(document).on('click', "input[name='acy_paper_select']", function() {
                if ($(this).is(':checked')) {
                    $('#paper-preview').load('/products/acy_paper_preview.php');
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
                    8: '#acc-design',
                    9: '#replacement',
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
    </script>
    <script type="text/javascript" src="/js/common.js?v=1.02" defer></script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js" async></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".tbl_s").on("click scroll", function() {
                // $(this).find(".scroll-center").hide();
            });
        });
    </script>
</body>

</html>