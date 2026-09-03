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

$japanNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Tokyo'));
$planDisableStart = new DateTimeImmutable('2026-08-13 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisableEnd = new DateTimeImmutable('2026-08-17 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisabled = ($japanNow >= $planDisableStart && $japanNow < $planDisableEnd) ? 'disabled' : '';

// include('/products/acrylic/part-base-rainbow.php');


// echo "<pre>";
// print_r($attachment);
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
    <meta name="keywords" content="レインボーアクリルスタンド（レインボーアクスタ）,オリジナル">
    <meta name="description"
        content="レインボーアクリルスタンド（レインボーアクスタ）のオリジナル製作。選べる2タイプご用意。印刷を保護フィルムでカバーするからはがれない！小ロット・格安価格。データ作成補助無料。最短6営業日出荷。業界最安級の1個330円〜（税込）|イラストも写真もアクスタに">
    <meta name="robots" content="index,follow" />
    <title>レインボーアクリルスタンド（レインボーアクスタ）製作｜印刷が剥げない独自仕様</title>
    <link rel="canonical" href="https://hotmobily.jp/products/acrylic/figure/rainbow/">
    <link rel="preload" type="text/css" href="https://hotstrap.jp/css/homepage.css?v=1.15" as="style"
        onload="this.rel='stylesheet'">
    <link href="/products/css/box.css" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/css/modal.css?v=1.01" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/products/css/calendar.css?v=2" rel="preload" type="text/css" as="style"
        onload="this.rel='stylesheet'" />
    <?php include("../../head_products.html"); ?>
    <link rel="stylesheet" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link href="/products/css/product_group.css?v=1.14" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163" as="style"
        onload="this.onload=null;this.rel='stylesheet'" /> -->
        <link href="https://hotmobily.jp/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://hotmobily.jp/products/css/scroll.css">
    <!-- <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" /> -->
    <link href="/products/acrylic/css/acrylic.css?v=1.10" rel="stylesheet" type="text/css">
    <style type="text/css">
        <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?>
        <?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
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
            /* width: 80%; */
            /* background-color: #f79647 */
            text-decoration: none !important;
        }

        a.est-btn.btn-a, a.ord-btn.btn-a {
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

            .accordion-input:checked~.accordion-content {
                max-height: fit-content;
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
                <h1 class="h1-new">レインボーアクリルスタンド（レインボーアクスタ）（2026年版）</h1>
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
                                <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand01.webp"
                                    alt="ラバーストラップ制作事例（ケモ耳女の子キャラ）" fetchpriority="high" loading="eager"
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
                                <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand02.webp"
                                    alt="ラバーストラップ制作事例（文字デザイン）" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand03.webp"
                                    alt="ラバーストラップ制作事例（キャラクター）" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand04.webp"
                                    alt="ラバーストラップ制作事例（女の子キャラ）" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/figure-rainbow/rainbow_stand05_ver02.webp"
                                    alt="ラバーストラップ制作事例（ロゴ）" loading="lazy" class="pdp-v2-slide-img" width="600"
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
                                <img src="/products/acrylic/img/figure-rainbow/rainbow_stand06_ver02.webp?v=1"
                                    alt="ラバーストラップ制作事例（キャラクターと文字）" loading="lazy" class="pdp-v2-slide-img" width="600"
                                    height="600">
                            </div>
                        </div>
                    </div>

                    <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                        <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand01.webp"
                            alt="ラバーストラップ制作事例（ケモ耳女の子キャラ）" class="pdp-v2-thumb-item pdp-v2-active-state" data-index="0">
                        <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand02.webp"
                            alt="ラバーストラップ制作事例（文字デザイン）" class="pdp-v2-thumb-item" data-index="1" loading="lazy">
                        <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand03.webp"
                            alt="ラバーストラップ制作事例（キャラクター）" class="pdp-v2-thumb-item" data-index="2" loading="lazy">
                        <img src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand04.webp"
                            alt="ラバーストラップ制作事例（女の子キャラ）" class="pdp-v2-thumb-item" data-index="3" loading="lazy">
                        <img src="/products/acrylic/img/figure-rainbow/rainbow_stand05_ver02.webp" alt="ラバーストラップ制作事例（ロゴ）"
                            class="pdp-v2-thumb-item" data-index="4" loading="lazy">
                        <img src="/products/acrylic/img/figure-rainbow/rainbow_stand06_ver02.webp?v=1"
                            alt="ラバーストラップ制作事例（キャラクターと文字）" class="pdp-v2-thumb-item" data-index="5" loading="lazy">
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
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個480円（税込）</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">100個合計金額：</span>48,000円（税込）</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span class=""
                                id="date_create2x1"></span></p>
                    </div>

                    <div class="">
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です。</small><br>
                        <small class="note">※上記よりも早くお届けする6営業日後出荷コースもございます。<a href="javascript:void(0)" class=""
                                onclick="GotoDiv(2)">納期詳細はこちら</a></small>
                    </div>

                    <h2 class="promo-title" style="color: #cc3f44; !important;">
                        特別感あふれる虹色のエフェクト付きアクスタ！</h2>

                    <div class="info-card">
                        <h3 class="lpc">光を反射して虹色に光るアクスタ！</h3>
                        <a onclick="GotoDiv(6)" href="javascript:void(0)"><img
                                src="/products/acrylic/img/figure-rainbow/rainbow_pr_ver02.webp?v=1" alt="業界最短7日出荷"
                                width="660" height="auto" loading="lazy"></a>
                        <p class="new-text">レインボーアクリルスタンド（レインボーアクスタ）は光を反射して虹色に輝くエフェクト付き。特別なアクスタの製作にぴったり。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(6)"
                                style="color: black;">レインボー加工の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">最安単価330円（税込）！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(3)"><img
                                src="/products/acrylic/img/figure-rainbow/rainbow_price.webp?c=1" alt="業界最安値価格" width="660"
                                height="auto" loading="lazy"></a>
                        <p class="new-text">
                            最安単価がたったの330円（税込）！大ロットほど単価が安くなりお得です。
                        </p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(3)"
                                style="color: black;">料金の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc">印刷がはがれない！</h3>
                        <a href="javascript:void(0)" onclick="GotoDiv(7)"><img
                                src="/products/acrylic/img/figure-rainbow/rainbow_print.webp?k=1" alt="汚れ防止加工" width="660"
                                height="auto" loading="lazy"></a>
                        <p class="new-text">印刷したデザインを保護フィルムでカバーするので、こすれたり引っかいたりしても印刷がはがれません。</p>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text"
                                style="color: black;" onclick="GotoDiv(7)">保護フィルムの詳細</a>
                        </div>
                    </div>

                </div>
            </div>

            <!--Accordion Type-->
            <div id="acc-type">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="type-toggle" class="accordion-input" checked>
                        <label for="type-toggle" class="accordion-header" id="type-g">
                            <span class="fw-bold">ノーマルタイプとクリスタルタイプをご用意</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <div class="poster-grid">
                                        <div class="poster-item">
                                            <div class="text-center" style="text-align:center;"><p class="new-text">ノーマルタイプ</p></div>
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this, 1)"
                                                    src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand02.webp"
                                                    alt="Poster 1" />
                                                <div class="camera-left"
                                                    style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                    📷<?= lang('クリックすると拡大します') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="poster-item">
                                            <div class="text-center" style="text-align:center;"><p class="new-text">クリスタルタイプ</p></div>
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this, 1)"
                                                    src="/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand01.webp"
                                                    alt="Poster 2" />
                                                <div class="camera-left"
                                                    style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                    📷<?= lang('クリックすると拡大します') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div>
                                    <p class="new-text">見る角度によって色彩が移ろう、幻想的なレインボーアクリルスタンド（レインボーアクスタ）。お好みの雰囲気やデザインに合わせて、ノーマルタイプとクリスタルタイプの2種類の輝きからお選びいただけます。</p>
                                    <br>
                                    <p class="new-text">幻想的な輝きのノーマルタイプは、光の当たり方でなめらかに虹色を帯びる、本当に虹が手の中にあるような上品な輝きが特徴です。主張しすぎない柔らかな光沢は、キャラクターイラストやロゴを際立たせます。デザインの魅力を邪魔することなく、背景からふんわりと幻想的な雰囲気をプラスし、可愛らしさを一層引き立てます。</p>
                                    <br>
                                    <p class="new-text">鮮やかなきらめきのクリスタルタイプは、まるで宝石を散りばめたような、幾何学的なホログラムが特徴です。光を複雑に乱反射させることで、ノーマルタイプよりも強く、キラキラとした華々しいインパクトを放ちます。写真やポップなデザインと組み合わせれば、奥行きのあるリッチな仕上がりに。手にした瞬間に心が躍るような、ゴージャスな存在感が魅力です。</p>
                                    <br>
                                    <p class="new-text">なお、白押さえ（印刷デザインがアクリルスタンド（レインボーアクスタ）の反対側の面に透けるのを防ぐ白色の印刷）を入れた部分にはレインボー加工の効果が出ません。ご注意ください。</p>
                                    <br>
                                    <div>
                                        <iframe width="100%" height="388" src="https://www.youtube.com/embed/vk0kNTN0QCo?si=3V9mtHy-JkUM9_YO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Type-->

            <!--Accordion Price-->
            <br>
            <div id="acc-price">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="price-toggle" class="accordion-input" checked>
                        <label for="price-toggle" class="accordion-header" id="price-g">
                            <span class="fw-bold">制作料金（税込）</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">納期と印刷面を選択してください。サイズ別の製作単価表が表示されます。ここは価格表のみです。見積・注文は<a href="javascript:void(0);" onclick="GotoDiv(1)" class="new-text">こちら</a>です。</p>

                                <h3><?= lang('納期') ?></h3>
                                    <div class="part-container">
                                        <div class="part-content" style="display: flex">
                                            <label class="part-name">
                                                <input type="radio" name="prc_delivery" value="10" checked="" onclick="writePriceTable('del');" />10<?=
                                                lang('営業日') ?> <span class="checkmark"></span>
                                            </label>
                                            <label class="part-name">
                                                <input type="radio" name="prc_delivery" value="6" onclick="writePriceTable('del');" />6<?= lang('営業日') ?>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <h3><?= lang('印刷面') ?></h3>
                                    <div class="part-container">
                                        <div class="part-content" style="display: flex">
                                            <label class="part-name"
                                                ><input
                                                    type="radio"
                                                    name="prc_screen"
                                                    value="1"
                                                    checked=""
                                                    onclick="writePriceTable();" /><?= lang('片面印刷') ?>
                                                <span class="checkmark"></span
                                            ></label>
                                            <label class="part-name"
                                                ><input type="radio" name="prc_screen" value="2" onclick="writePriceTable();" /><?= lang('両面印刷') ?>
                                                <span class="checkmark"></span
                                            ></label>
                                        </div>
                                    </div>
                                    <br />
                                    <h3><?= lang('数量・サイズ別価格表') ?></h3>
                                    <div class="fixed-thead">
                                        <!-- <div class="scroll-center">
                                            <div class="arrow"></div>
                                        </div> -->
                                        <table
                                            id="table-price"
                                            class="tbl-price tb-w12 blink"
                                            border-solid="1"
                                            bordercolor="#cccccc"
                                            border="1"
                                            cellpadding="5"
                                            cellspacing="0"
                                            style="border-collapse: collapse; width: 99%"
                                        >
                                            <thead>
                                                <tr>
                                                    <td></td>
                                                    <td>50×50mm<?= lang('以内') ?></td>
                                                    <td>75×75mm<?= lang('以内') ?></td>
                                                    <td>100×100mm<?= lang('以内') ?></td>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
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
                            <span class="fw-bold">納期</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">6営業日後出荷コース、10営業日後出荷コースがございます。注文後のデザイン確定・制作開始の日時から数えて6営業日後出荷・10営業日後出荷です。</p>
                                <br>
                                <!-- <div class="flex-container">
                                    <div class="flex-item item">
                                        <div class="btn-container item_btn" style="display: flex; justify-content: space-between">
                                            <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
                                                <span><?= lang('テンプレート') ?></span>
                                            </a>
                                            <a class="btn-a btn-yellow" href="/products/data-acrylic-figure.php">
                                                <span><?= lang('入稿データ作成') ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex-item item">
                                        <div class="btn-container item_btn" style="display: flex; justify-content: space-between">
                                            <a class="btn-a btn-yellow" href="/howtoorder/acrylic" target="_blank">
                                                <span><?= lang('ご注文の流れ') ?></span>
                                            </a>
                                            <a class="btn-a btn-yellow" href="/contact/?item=アクリルスタンド（レインボーアクスタ）">
                                                <span><?= lang('無料サンプル') ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-container">
                                    <div class="flex-item item">
                                        <div class="btn-container item_btn">
                                            <a class="btn-a ord-btn" href="javascript:void(0)" onclick="GotoDiv(1)"> <?= lang('ご注文') ?> </a>
                                        </div>
                                    </div>
                                    <div class="flex-item item">
                                        <div class="btn-container item_btn">
                                            <a class="btn-a est-btn" href="javascript:void(0)" onclick="GotoDiv(1)"> <?= lang('見積書作成') ?> </a>
                                        </div>
                                    </div>
                                </div> -->

                                <table class="cld_tb">
                                    <tr class="cld_head">
                                        <td colspan="2">今、この製品を製作開始した場合の出荷日を表示中</td>
                                    </tr>
                                    <tr class="cld_r1">
                                        <td><?= lang('製作開始日時') ?></td>
                                        <td>６営業日出荷予定</td>
                                    </tr>
                                    <tr class="cld_r2">
                                        <td rowspan="4"><span id="date_create"></span></td>
                                        <td><span id="date_create4"></span></td>
                                    </tr>
                                    <tr class="cld_r1">
                                        <td>10営業日出荷予定</td>
                                    </tr>
                                    <tr class="cld_r2">
                                        <td><span id="date_create2"></span></td>
                                    </tr>
                                </table>

                                <br>
                                <a class="new-text" href="/howtoorder/acrylic" target="_blank">アクリル製品のご注文の流れ</a>
                                <br><br>
                                <a class="new-text" href="/contact/?item=レインボーアクリルスタンド（レインボーアクスタ）" >無料サンプルの送付をリクエスト</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Shipping-->

            <!--Accordion Data-->
            <br>
            <div id="acc-data_creation">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="data_creation-toggle" class="accordion-input" checked>
                        <label for="data_creation-toggle" class="accordion-header" id="data_creation-g">
                            <span class="fw-bold">データ作成補助が無料！</span>
                            <span class="arrow-dove"></span>
                        </label>
                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <a href="https://hotmobily.jp/products/acrylic/cutline_white"><img src="/products/acrylic/img/figure-rainbow/cutpath_rainbow.webp" alt="" loading="lazy"></a>
                                </div>
                                <br>
                                <div>
                                    <p class="new-text">アクリルスタンド（レインボーアクスタ）の製作にあたって、カットパスや白押さえなど、専用の入稿データの作成にお悩みの方もいるでしょう。当店では無料のデータ作成補助サービスをご用意。お客様の代わりに入稿データを無料で作成いたします。イラストや写真の画像（JPG、PNG）、PDFなどをお送りください。</p>
                                    <br>
                                    <a href="https://hotmobily.jp/products/acrylic/cutline_white" class="new-text">データ作成補助の詳細</a>
                                    <br><br>
                                    <p class="new-text">また、カットパス・白押さえにもこだわりがありじぶんで入稿データを作成したい方向けに、テンプレートもご用意しております。</p>
                                    <br><br>
                                    <a href="/products/acrylic/template/template-rainbow-acrylic-stand.zip" class="new-text" download>テンプレートをダウンロード</a>
                                    <!-- <div>
                                        <a href="https://hotmobily.jp/products/data-acrylic-figure.php">
                                            <img src="/products/acrylic/img/figure-rainbow/banner_guide_acrylic_rainbow.webp" alt="" loading="lazy"></a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Data-->

            <!-- Order Form -->
            <br>
            <div id="order-form">
                <?php include('../campaign_banner.php') ?>

                <h2 id="est-order">ご注文・見積書作成</h2>
                <div>
                    <?php include('../../delivery_note.php'); ?>
                    <div style="overflow: unset!important;">
                        <div class="fixed-contrainer">
                        <h3 class="red">【<?= lang('レインボーアクリルスタンド（レインボーアクスタ）') ?>】</h3>
                        <span class="total-price"><span class="prd_total">0</span>円<?= lang('（税込）') ?></span>
                        </div>
                        <div style="clear: both;"></div>
                        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
                        <div class="step-box">
                            <table class="table_rubber" style="padding: 0">
                            <tr>
                                <td><?= lang('納期') ?></td>
                                <td><span id="sample-prd-prdt"></span></td>
                            </tr>
                            <tr>
                                <td><?= lang('サイズ') ?></td>
                                <td><span id="sample-prd-size"></span></td>
                            </tr>
                            <tr>
                                <td><?= lang('加工タイプ') ?></td>
                                <td><span id="sample-prd-type"></span></td>
                            </tr>
                            <tr>
                                <td><?= lang('印刷面') ?></td>
                                <td><span id="sample-prd-screen"></span></td>
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
                            <img data-src="/products/acrylic/img/base01.webp" id="sample-part-pic" class="picpro lazy" width="250" height="160"><br />
                            <span id="sample-part-name"></span>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <img data-src="/products/acrylic/img/coming-soon.webp" id="sample-paper-pic" class="picpro lazy" width="500" height="500"><br />
                            <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
                        </div>
                        </div>
                        <div class="step-container">
                        <div class="step-box step-list">
                            <ul>
                            <li id="dot-step1" class="active">
                                <div class="step-number">1</div><span class="step-details"><?= lang('納期・サイズ・印刷面') ?></span>
                            </li>
                            <li id="dot-step2">
                                <div class="step-number">2</div><span class="step-details"><?= lang('台座・台紙等') ?></span>
                            </li>
                            <li id="dot-step3">
                                <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
                            </li>
                            </ul>
                        </div>
                        </div>
                        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
                        <div style="display: table-column;">
                            <input type="text" name="ItemType" id="strap" value="レインボーアクリルスタンド" />
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
                        //Setup Type data
                        switch ($acy_cat) 
                        {
                            case 'ノーマルタイプ':
                                $cat1 = "checked";
                            break;

                            case 'クリスタルタイプ':
                                $cat2 = "checked";
                            break;
                            
                            default:
                                $cat1 = "checked";
                            break;
                        }
                        //Setup screen data
                        switch ($acy_screen) {
                            case '片面印刷':
                            $screen1 = "checked";
                            break;
                            case '両面印刷':
                            $screen2 = "checked";
                            break;
                            default:
                            $screen1 = "checked";
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
                                    <input type="text" name="design_no" value="<?= $design_no ?>">
                                </label>
                                </div>
                            </div>
                            </div>
                            
                            <h3><?= lang('納期') ?></h3>
                            <?php include('../alert-btn.php') ?>
                            <div class="part-container">
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="acy_delivery" value="10営業日" <?= $delivery_10 ?>>10<?= lang('営業日') ?><span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name" <?=$delivery_disabled?>><input type="radio" name="acy_delivery" value="6営業日" <?= $delivery_6 ?> <?= $planDisabled ?>>6<?= lang('営業日') ?> <span class="checkmark"></span></label>
                            </div>
                            <h3 style="font-size: 13px;"><i style="color:red" class="fa fa-exclamation-circle" aria-hidden="true"></i>毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。
                            </h3>
                            </div>
                            <h3><?= lang('サイズ') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_size" value="50" onclick="getPartData();" <?= $size50 ?>>50x50mm. <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_size" value="75" onclick="getPartData()" <?= $size75 ?>>75x75mm. <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_size" value="100" onclick="getPartData()" <?= $size100 ?>>100x100mm. <span class="checkmark"></span></label>
                                </div>
                            </div>
                            <h3><?= lang('加工タイプ') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_cat" value="ノーマルタイプ" <?= $cat1 ?>><?= lang('ノーマルタイプ') ?> <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_cat" value="クリスタルタイプ" <?= $cat2 ?>><?= lang('クリスタルタイプ') ?> <span class="checkmark"></span></label>
                                </div>
                            </div>
                            <h3><?= lang('印刷面') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_screen" value="片面印刷" <?= $screen1 ?>><?= lang('片面印刷') ?> <span class="checkmark"></span></label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name"><input type="radio" name="acy_screen" value="両面印刷" <?= $screen2 ?>><?= lang('両面印刷') ?> <span class="checkmark"></span></label>
                                </div>
                            </div>
                            <h3><?= lang('数量') ?></h3>
                            <div class="part-container">
                            <div class="part-content">
                                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right; width: auto;" onblur="check_val('next')" value="<?= $qty ?>"></label>
                                <div class="error" id="qty-error"></div>
                            </div>
                            <h3 style="font-size: 13px;">※デザイン1種につき1注文となります。デザインが複数ある場合は、デザインごとにご注文ください。</h3>
                            </div>
                        </div>
                        <div class="estimate-content" id="step2">
                            <h3><?= lang('台座') ?></h3>
                            <div class="flex-container">
                            <div class="preview-container">
                                <div class="preview-sub flex-container">
                                <?php

                                $target_file = __DIR__ . "/part-base-rainbow.php";
                                if (file_exists($target_file)) {
                                    include($target_file);
                                }


                                $i = 0;
                                for ($i = 0; $i < count($attachment); $i++) {
                                    echo '
                                                        <div class="flex-item acy_base">
                                                        <label class="part-name">
                                                        <input class="vv_'.$attachment[$i]["part_id"].'" type="radio" id="' . $attachment[$i]["part_id"] . '" name="acy_part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData()" ' . ($acy_part == $attachment[$i]["part_name"] ? 'checked' : '') . '>
                                                        <div class="base_group picpro">
                                                        <span id="p_'.$attachment[$i]["part_id"].'">' . $attachment[$i]["part_name"] . '</span>
                                                        <img class="lazy" data-src="' . $attachment[$i]["part_pic"] . '?v=1.01">
                                                        </div>
                                                        <br>+<span class="part_price" id="_'.$attachment[$i]["part_id"].'">' . ($attachment[$i]["part_price"] * 1.1) . '</span>円
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
                                    <input type="checkbox" class="checkbox" name="acy_paper_select" value="あり" onclick="check_val('next')" <?= ($acy_paper_select == "あり" ? "checked" : "") ?>>
                                    <div class="knobs">
                                    <span></span>
                                    </div>
                                    <div class="layer"></div>
                                </div>
                                <?= lang('台紙印刷') ?>
                                </label>
                                <div class="error" id="paper-error"></div>
                            </div>
                            </div>
                            <div class="flex-container paper-container">
                            <div class="preview-container">
                                <div class="preview-sub flex-container" id="paper-preview">
                                <?php if ($acy_paper_select == "あり") {

                                    $papar_path = __DIR__ . "/../acy_paper_preview_rainbow.php";
                                    // echo $papar_path;
                                    if (file_exists($papar_path)) {
                                        include($papar_path);
                                    }

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
                            </div>
                        </div>
                        <div class="estimate-content flex-item" id="step3">
                            <div class="flex-container">
                            <div class="flex-item">
                                <h3><?= lang('製品仕様') ?></h3>
                                <table class="table_rubber">
                                <tbody>
                                    <tr>
                                    <td class="TableLeft"><?= lang('納期') ?></td>
                                    <td class="" id="prd_production" style="text-align: left;"></td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft"><?= lang('サイズ') ?></td>
                                        <td class="" id="prd_size" style="text-align: left;"></td>
                                    </tr>
                                    <tr>
                                        <td class="TableLeft"><?= lang('加工タイプ') ?></td>
                                        <td class="" id="prd_type" style="text-align: left;"></td>
                                    </tr>
                                    <tr>
                                    <td class="TableLeft"><?= lang('印刷面') ?></td>
                                    <td class="" id="prd_print" style="text-align: left;"></td>
                                    </tr>
                                    <tr>
                                    <td class="TableLeft"><?= lang('数量') ?></td>
                                    <td class="" id="prd_amount" style="text-align: left;"></td>
                                    </tr>
                                    <tr>
                                    <td class="TableLeft"><?= lang('台座') ?></td>
                                    <td class="" id="prd_part" style="text-align: left;"></td>
                                    </tr>
                                    <tr>
                                    <td class="TableLeft"><?= lang('台紙') ?></td>
                                    <td class="" id="prd_paper" style="text-align: left;"></td>
                                    </tr>
                                    <tr>
                                    <td class="TableLeft"><?= lang('試作品') ?></td>
                                    <td class="" id="prd_sample" style="text-align: left;"><?= lang('なし') ?></td>
                                    </tr>
                                    <tr>
                                    <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                                    <td class="" id="prd_trace" style="text-align: left;"><?= lang('なし') ?></td>
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
                                    <td class="TableLeft"><?= lang('台座代金') ?></td>
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
                                        <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step1');$('#cus_detail').hide();">製作条件修正</a>
                                        <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step2');$('#cus_detail').hide();">オプション修正</a>
                                        <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle();">
                                        <div class="flex-item">
                                            <input type="button" class="btn ord-btn btn-success" value="カートに入れる" onclick="comSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', form);">
                                            <!-- <input type="button" class="btn ord-btn" value="すぐに購入" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form);"> -->
                                        </div>
                                        </div>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="acrylic-btn" class="btn-container">
                            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="validation('back')"><?= lang('戻る') ?></a>
                            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="validation('next')"><?= lang('台座・オプション入力へ') ?></a>
                        </div>
                        </form>
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
                                <td class="TableLeft"><?= lang('郵便番号') ?> </td>
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
            </div>
            <!-- End Order Form -->


            <!--Accordion Rainbow  01 -->
            <br>
            <div id="acc-rainbow01">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="rainbow01-toggle" class="accordion-input" checked>
                        <label for="rainbow01-toggle" class="accordion-header">
                            <span class="fw-bold">イラストや写真がより際立つレインボー加工！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/figure-rainbow/rainbow_pr02.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    「いつものアクスタでは物足りない」「もっとデザインを際立たせたい」「特別感を出したい」といったクリエイター様・企業様の想いに応えるのが、このレインボーアクリルスタンド（レインボーアクスタ）です。
                                </p>
                                <br>
                                <p class="new-text">光を反射して虹色の光彩を帯びるそのきらめきは、こだわりのオリジナルデザインの価値をさらに高めます。虹色のエフェクトとのかけ合わせによって、デザインの世界観の再現度を引き上げることが可能です。背景が虹色に輝くことで、キャラクターの可愛らしさをポップに強調したり、アーティスティックなデザインに奥行きと高級感を与えたり、デザインの魅力を最大限に引き出します。また、たとえばキャラクターの瞳の部分やステンドグラスのデザインの部分などピンポイントに虹色のエフェクトが入るようにして、デザインのクオリティを高めることもできます。</p>
                                <br>
                                <p class="new-text">また、「普通のグッズ」の枠組みを超え、手にしたファンが大切にしたくなる「宝物」になるようなアイテムを作ることができるのがレインボーアクリルスタンド（レインボーアクスタ）です。記念品や限定品として製作すれば、グッズ自体だけではなく、「特別感」「プレミアム感」をユーザーに提供することができます。周年記念の節目を祝う記念品やイベント会場での数量限定グッズなどに最適です。手に取った人に特別な感動を与えることができます。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Rainbow  01 -->
            

            <!--Accordion Rainbow 02 -->
            <br>
            <div id="acc-rainbow02">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="rainbow02-toggle" class="accordion-input" checked>
                        <label for="rainbow02-toggle" class="accordion-header">
                            <span class="fw-bold">特別なメモリアルとしても活躍！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/figure-rainbow/rainbow_memory.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    何気ない日常の一枚も、人生に一度きりの特別な瞬間も、写真にはそのときの空気や想いがぎゅっと詰まっています。大切な家族の笑顔、親友と肩を並べて笑ったあの日、旅立ちの日の卒業式、心を込めてお祝いした誕生日、そしてかけがえのない存在であるペットの愛らしい姿。そんな二度と戻らない瞬間を、ただデータやアルバムの中に眠らせておくのではなく、いつでも目に見える形で残せたら素敵だと思いませんか？
                                </p>
                                <br>
                                <p class="new-text">レインボーアクリルスタンド（レインボーアクスタ）は、思い出の写真を美しく立体化し、光とともに輝く特別なメモリアルアイテムへと変身させます。</p>
                                <br>
                                <p class="new-text">透明感あふれるアクリル素材に、角度によって表情を変えるレインボーのきらめき。光を受けるたびにやさしく七色に反射し、写真の中の笑顔や風景をより一層ドラマチックに彩ります。</p>
                                <br>
                                <p class="new-text">・お子さまの誕生日の一枚を、毎年成長を感じられるインテリアに。</p>
                                <p class="new-text">・卒業式の晴れ姿を、未来へのエールを込めた記念品として。</p>
                                <p class="new-text">・結婚式や家族写真を、いつでも見守ってくれる宝物に。</p>
                                <p class="new-text">・大切なペットの写真を、あたたかな存在感のあるメモリアルとして。</p>
                                <br>
                                <p class="new-text">写真をアクリルスタンド（レインボーアクスタ）にすることで、思い出は「見るもの」から「飾るもの」へと変わります。デスクやリビング、玄関やベッドサイドなど、日常の空間にそっと置くだけで、その瞬間が何度でもよみがえります。さらに、レインボー仕様ならではの華やかさは、贈り物としても格別です。ご家族へのサプライズギフト、友人への誕生日プレゼント、卒業・入学祝い、ペットを愛する方へのメモリアルギフトとしても、心からの想いが伝わる特別な一品になります。</p>
                                <br>
                                <p class="new-text">時間が経つほどに価値を増していく思い出。その大切な瞬間を、色あせない透明感と虹色の輝きで包み込み、いつまでもそばに置いておける形に。レインボーアクリルスタンド（レインボーアクスタ）は、あなたの「忘れたくない」を、美しく残すための新しいメモリアルのかたちです。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Rainbow 02 -->

            <!--Accordion One -->
            <br>
            <div id="acc-one">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="one-toggle" class="accordion-input" checked>
                        <label for="one-toggle" class="accordion-header">
                            <span class="fw-bold">1個だけの注文も可能</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/figure-rainbow/rainbow_one.webp" alt=""
                                        width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    当店のレインボーアクリルスタンド（レインボーアクスタ）は、たった1個から製作可能です。「自分のイラストを特別なアクリルスタンド（レインボーアクスタ）にしたい」「友人への贈り物として唯一無二のアクスタを作りたい」などのパーソナルな希望も叶えることができます。たとえ一つだけの製作であっても、クオリティに一切の妥協はありません。光を反射してきらめく虹色のきらめきが、お客様だけのデザインをアートへと昇華させ、自分の宝物として、あるいは大切な人への想いを込めたオンリーワンのギフトとして、たった一つの注文から最高級の満足感と感動をお届けする体制を整えております。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion One -->

            <!--Accordion Print -->
            <br>
            <div id="acc-print">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="print-toggle" class="accordion-input" checked>
                        <label for="print-toggle" class="accordion-header">
                            <span class="fw-bold">他社と違う！印刷を守る保護フィルム</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/acrylic/img/figure-rainbow/acrylic-protection-compare-rainbow.webp" alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    他社とは一線を画す当店のレインボーアクリルスタンド（レインボーアクスタ）の強みのひとつとして、お客様の大切なデザインを保護する保護フィルムがあります。
                                </p>
                                <br>
                                <p class="new-text">一般的なレインボーアクリルスタンド（レインボーアクスタ）は保護フィルムがなく、固いものがこすれたり爪で引っかいたりすると、印刷されたデザインがはがれる恐れがあります。しかし、当店のアクリルスタンド（レインボーアクスタ）は印刷デザインを保護フィルムで覆っています。このため、印刷がむき出しにならず保護フィルムによって保護され、印刷がはがれる恐れがありません。</p>
                                <br>
                                <p class="new-text">せっかく製作したレインボーアクリルスタンド（レインボーアクスタ）なら、長くキレイに保ちたい方も多いかと思います。当店のレインボーアクリルスタンド（レインボーアクスタ）なら、お客様のご希望を叶えることが可能です。</p>
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
            <!--End Accordion Print -->

            <!--Accordion CNC -->
            <br>
            <div id="acc-cnc">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="cnc-toggle" class="accordion-input" checked>
                        <label for="cnc-toggle" class="accordion-header">
                            <span class="fw-bold">CNC加工</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img onclick="openSimpleModal(this, 1)"
                                        src="/products/acrylic/img/figure-rainbow/edit-55.webp"
                                        alt="Poster 1" />
                                    <div class="camera-left"
                                        style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                        📷<?= lang('クリックすると拡大します') ?>
                                    </div>
                                </div>
                                <br>
                                <p class="new-text">
                                    アクリルスタンド（レインボーアクスタ）を含め、アクリルグッズのカットはレーザーが使用されることが多いです。しかし、レーザーを使ったカットは、カット面に不自然な突起ができてしまいます。ごく小さな突起なので目立ちませんが、カット面に手で触ってみると引っかかりがあるのがわかるでしょう。当店のアクリルグッズは、アクリルのカットにCNC加工機を使用しております。レーザーとは異なり、突起のない整ったカット面になるため、手で触れても引っかかりがなく、なめらかな手触りなのが特長です。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion CNC -->

            <!--Accordion Factory -->
            <br>
            <div id="acc-factory">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="factory-toggle" class="accordion-input" checked>
                        <label for="factory-toggle" class="accordion-header">
                            <span class="fw-bold">当店のレインボーアクリルスタンド（レインボーアクスタ）はすべて自社生産！</span>
                            <span class="arrow-dove"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <a href="https://hotmobily.jp/products/acrylic/ownfactory"><img src="/products/acrylic/img/figure-rainbow/rainbow_factory.webp" alt="" width="100%" loading="lazy"></a>
                                </div>
                                <br>
                                <p class="new-text">
                                    レインボーアクリルスタンド（レインボーアクスタ）を含め、当店のアクリル製品はすべて自社生産です。デザインの印刷、アクリル板のカット、包装まですべて自社工場で完結しています。自社生産のためマージンなどが発生せず、お客様のお求めの製品を低コストで製作することができます。製品のクオリティにも責任をもってこだわっております。お客様のデザインを活かした高品質のレインボーアクリルスタンド（レインボーアクスタ）をお届けいたします。
                                </p>
                                <br>
                                <div style="text-align: left;">
                                    <a href="https://hotmobily.jp/products/acrylic/ownfactory" class="new-text"
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
                                            <td style="text-align: left;"><?= lang('レインボーアクリルスタンド（レインボーアクスタ）') ?></td>
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
                                                <?= lang('50X50mm / 75X75mm / 100X100mm (台座を除く本体部分)') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('色数') ?></td>
                                            <td style="text-align: left;">
                                                フルカラーUVインクジェット印刷+白押さえが基本となります。<br>片面印刷：UV印刷+白押さえ<br>両面印刷：UV印刷+白押さえ+UV印刷
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('台座') ?></td>
                                            <td style="text-align: left;">
                                               規定形状：4種類（楕円、円、正方形、長方形）<br>オリジナル形状：お客様ご指定の形状で製作。台座に印刷することも可能です
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('台紙') ?></td>
                                            <td style="text-align: left;">
                                               既製品：50種類のデータから選択可<br>オリジナル印刷：お客様の入稿データを使用し、印刷します<br>支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('試作品') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('20以上のご注文から可能です') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('最小ロット') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('1個') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>包装</td>
                                            <td style="text-align: left;">個別OPP包装</td>
                                        </tr>
                                        <tr>
                                            <td>特徴</td>
                                            <td style="text-align: left;">印刷面をフィルム保護。CNCカット</td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('納期') ?></td>
                                            <td style="text-align: left;">6営業日/10営業日</td>
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
            <div id="acrylic-lists">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="acrylic-lists-toggle" class="accordion-input" checked>
                        <label for="acrylic-lists-toggle" class="accordion-header">
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
                    <h3><?= lang('アクリルスタンド（レインボーアクスタ）') ?>【Illustrator／Photoshop】</h3>
                    <table class="table_rubber">
                        <tbody>
                            <tr>
                                <td>50×50mm</td>
                                <td>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_50mm_20250320.ai"
                                    >
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/ai-icon.webp" width="20" height="20" /> <?=
                                            lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_50mm_20250320.psd"
                                    >
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
                                        href="https://hotmobily.jp/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_75mm_20250320.ai"
                                    >
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/ai-icon.webp" width="20" height="20" /> <?=
                                            lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_75mm_20250320.psd"
                                    >
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
                                        href="https://hotmobily.jp/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_100mm_20250320.ai"
                                    >
                                        <div>
                                            <img src="https://hotmobily.jp/products/acrylic/img/ai-icon.webp" width="20" height="20" /> <?=
                                            lang('テンプレートダウンロード') ?>
                                        </div>
                                    </a>
                                    <a
                                        class="btn-a btn-yellow"
                                        href="https://hotmobily.jp/products/acrylic-rainbow/template/template-rainbow_acrylic_stand_100mm_20250320.psd"
                                    >
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
    <script type="text/javascript" src="/products/acrylic/js/calculate-figure-rainbow-ver2.js?v=<?php echo date('is'); ?>" defer></script>
    <script type="text/javascript" src="/js/common.js?v=1.02"></script>
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=<?php echo date('is'); ?>" defer></script>
    <script type="text/javascript" src="/products/js/date.js" defer></script>
    <script>
        $(document).ready(function () {

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
                "/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand01.webp",
                "/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand02.webp",
                "/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand03.webp",
                "/products/acrylic/img/figure-rainbow/rainbow_acrylic_stand04.webp",
                "/products/acrylic/img/figure-rainbow/rainbow_stand05_ver02.webp",
                "/products/acrylic/img/figure-rainbow/rainbow_stand06_ver02.webp?v=1"
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
            document.addEventListener('click', function (e) {
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

            $.ajax({
                type: "POST",
                url: "/products/check_holiday.php",
                data: {
                    "product": "アクリルキーホルダー"
                },
                success: function(data) {
                    prd_date1(data.sort());
                },
                dataType: "json"
            });

            $.ajax({
                type: "POST",
                url: "/products/check_holiday.php",
                data: {
                    "product": "アクリルキーホルダー exp"
                },
                success: function(data) {
                    prd_date2(data.sort());
                },
                dataType: "json"
            });

            // Check Holiday
            $.post("/products/check_holiday.php", {
                "product": "ラバーキーホルダー"
            }, function (data) {
                if (typeof productionDate === 'function') productionDate(data.sort());
            }, "json");


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
            $(document).on('click', "input[name='acy_paper_select']", function () {
                if ($(this).is(':checked')) {
                    $('#paper-preview').load('https://hotmobily.jp/products/acy_paper_preview_rainbow.php');
                }
            });

            // Read More Expanders (Delegated)
            $(document).on('click', '.exc_pro1 .btn, .exc_pro .btn', function (e) {
                e.preventDefault();
                const $el = $(this);
                const $up = $el.closest('.exc_pro1, .exc_pro'); // Find parent container
                const $containers = $up.find("div.swiper-container");

                let totalHeight = 0;
                $containers.each(function () {
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
            $('.preview-sub img').click(function () {
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

            $("#open-virus").click(function () {
                $("#slide-virus").slideToggle("slow");
            });
            $('.jump').click(function (e) {
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
        $(document).ready(function () {
            $(".tbl_s").on("click scroll", function () {
                // $(this).find(".scroll-center").hide();
            });
        });
    </script>
</body>

</html>