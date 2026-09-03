<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
error_reporting(E_ALL ^ E_NOTICE);
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

$data1 = mysqli_query($conn, "SELECT COUNT(id) AS totalreview FROM reviews_hm") or die(mysqli_error());
$info1 = mysqli_fetch_assoc($data1);

$data2 = mysqli_query($conn, "SELECT AVG(service) AS avg_service, AVG(product) AS avg_product FROM reviews_hm") or die(mysqli_error());
$info2 = mysqli_fetch_assoc($data2);

// 1. Define or retrieve your dynamic product variables here
// *************************************************************
// REPLACE these placeholder values with your actual PHP variables
// that hold the product data from your database or CMS.
// *************************************************************
$product_name = "【ホットモバイリー】オリジナルラバーキーホルダー";
$product_description = "オリジナル形状のラバーキーホルダーをオーダーメイドで製作。最短7営業日で出荷可能なプランや、少数（10個）向けプランあり。";
$product_image_url = "https://hotmobily.jp/gallery/img-keyholder/2023-rubberkeyholder-gallery/7.webp";
$product_sku = "HM-RK-2024";
$product_price = 480;
$product_currency = "JPY";
$product_availability = "InStock";
$product_url = "https://hotmobily.jp/products/rubberkeyholder/";

// 2. Build the Product Schema array in PHP
$schema_array = [
    '@context' => 'https://schema.org/',
    '@type' => 'Product',
    // Product Details
    'name' => $product_name,
    'description' => $product_description,
    'sku' => $product_sku,
    'url' => $product_url,
    'image' => $product_image_url,
    'brand' => [
        '@type' => 'Brand',
        'name' => 'HotMobily', // Your brand name
    ],

    // Offer Details (Required for price/availability snippets)
    'offers' => [
        '@type' => 'Offer',
        'url' => $product_url,
        // availability must use the full schema.org URL
        'availability' => 'https://schema.org/' . $product_availability,
        'priceCurrency' => $product_currency,
        'price' => $product_price,
        "priceValidUntil" => "2026-12-31",
    ],

    "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => number_format($info2['avg_product'], 1),
        "reviewCount" => $info1['totalreview']
    ],

    'review' => [
        '@type' => 'Review',
        "name" => "当店ラバーストラップのレビュー",
        "author" => [
            "@type" => "Person",
            "name" => "Anonymous"
        ],
        'positiveNotes' => [
            '@type' => 'ItemList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => '対応が丁寧で不安なく作れて感謝しています。 年末のせいか制作にやや時間がかかったのが少し気になりましたが、それ以外は完璧でした。 またよろしくお願いします。',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => '発色が一番好みだったのと、裏面保護があるのがいいと思いました。 もう少し小さくしても印刷が衰えないならアクキーもそのうち作りたいです。',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => 'いつもお世話になっております。 制作前のやり取り、納期、仕上り、梱包状態、そして細部にわたる製品のクオリティ全てに満足しております。',
                ],
            ],
        ],
    ]

];

// 3. Convert the PHP array to a JSON string.
// Use JSON_UNESCAPED_UNICODE to ensure Japanese characters are handled correctly.
$json_ld_output = json_encode($schema_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="<?= lang('キーホルダー,オリジナル,激安,製作') ?>">
  <meta name="description" content="<?= lang('業界最安・最速のオリジナルラバーキーホルダーの製作。100個から製作。短納期、最短7営業日で出荷。同人からイベント、ノベルティまで。') ?>">
  <meta name="robots" content="index,follow" />
  <title><?= lang('ラバーキーホルダーをオリジナルの形状で製作。業界最速7営業日出荷。同人/イベントグッズ、販促ノベルティ向け。') ?></title>
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css?v=1.03" rel="stylesheet" type="text/css" />
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css" />
  <?php include("../../head_products.html"); ?>
  <link rel="preload" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <link rel="preload" href="/products/css/product_group.css?v=1.08" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <link href="/products/acrylic/css/renew_products.css?v=1.164" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="../css/scroll.css">
  <link rel="preload" href="/products/acrylic/css/acrylic.css?v=1.04" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <script>
    $(document).ready(function() {
      $("#open1").click(function() {
        $("#slide1").slideToggle("slow");
      });
    });

    $(document).ready(function() {
      $(".tbl_s").on("click scroll", function() {
        $(this).find(".scroll-center").hide();
      });
    });
  </script>
  <!-- lightbox2-master -->
  <link rel="stylesheet" href="css/lightbox.css">
  <!-- /lightbox2-master -->
  <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
  <style type="text/css">
    <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
  </style>
  <style type="text/css">

    @-webkit-keyframes moving-gradient {
      0% {
        background-position: -250px 0;
      }

      100% {
        background-position: 250px 0;
      }
    }

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }

    table.tbl_price_deli.loading:not(.for_fans) tbody td:not(:first-child) {
      background: linear-gradient(to right, #eee 20%, #ddd 50%, #eee 80%);
      background-size: 500px 100px;
      animation-name: moving-gradient;
      animation-duration: 1s;
      animation-iteration-count: infinite;
      animation-timing-function: linear;
      animation-fill-mode: forwards;
    }

    div.gall_pro {
      justify-content: flex-start;
    }

    .preview-top img,
    .preview-sub .hover img {
      height: auto;
    }

    .product-detail {
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      justify-content: space-between;
      align-items: stretch;
      align-content: center
    }

    .product-txt {
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      flex-wrap: wrap;
      align-content: flex-end;
      align-items: flex-start;
      width: calc(45% - 5px);
      padding-left: 5px
    }

    .product-txt-sub {
      width: 100%
    }

    .product-txt-sub a {
      text-decoration: none;
      font-family: IwaUDGoDspPro-Eb, sans-serif !important
    }

    .product-txt-sub h4 {
      font-size: 16px;
      background: #fff;
      font-family: IwaUDGoDspPro-Eb, sans-serif !important
    }

    .product-txt-sub p {
      font-size: 11px;
      line-height: 1.2;
      color: #666
    }

    .product-img {
      width: calc(55% - 5px);
      position: relative
    }

    .product-img img {
      width: 100%
    }

    .product-line-group {
      position: absolute;
      display: grid;
      grid-template-rows: repeat(3, 1fr);
      top: 0;
      width: 100%;
      height: 100%;
      align-items: center
    }

    .product-line {
      height: 2px;
      background: #666;
      position: relative
    }

    div#line01 {
      width: 8%
    }

    div#line02 {
      width: 65%
    }

    div#line03 {
      width: 55%
    }

    div#line04 {
      width: 89%
    }

    div#line05 {
      width: 85%
    }

    .product-line:before {
      content: '';
      position: absolute;
      right: 0;
      border-radius: 10px;
      width: 20px;
      height: 20px;
      background-color: #ff80006e;
      animation: pulse 2s infinite;
      transform: translateY(-8.5px) translateX(6.5px)
    }

    .product-line:after {
      content: '';
      position: absolute;
      border-radius: 10px;
      width: 7px;
      height: 7px;
      background-color: #ff8000;
      transform: translateY(-2px)
    }

    #line01:before,
    #line01:after,
    #line02:after,
    #line02:before,
    #line03:after,
    #line03:before {
      right: 0
    }

    #line04:after,
    #line05:after {
      left: 0
    }

    #line04:before,
    #line05:before {
      transform: translateY(-8.5px) translateX(-6.5px);
      left: 0
    }


    .group-container {
      display: flex;
      justify-content: space-between;
      flex-flow: row wrap;
      margin: 10px 0;
    }

    .group-container .btn-select {
      width: calc(24% - 10px);
      border: 1px solid #9e9e9e;
      text-align: center;
      margin-bottom: 10px;
      padding: 10px 5px;
      cursor: pointer;
      border-radius: 3px;
      transition-duration: 0.3s;
      position: relative;
    }

    .btn-select input[type="radio"] {
      opacity: 0;
      width: 0;
    }

    .group-container .btn-select:hover,
    .group-container .btn-select.active {
      border: 1px solid #ffffff;
      background: #f7b516;
      color: white;
    }
    

    .group-container .btn-select:hover .top-noted,
    .group-container .btn-select.active .top-noted {
      background: white;
      border: 2px solid #1e6077;
      color: #1e6077;
    }

    @keyframes pulse {
      0% {
        opacity: 1
      }

      50% {
        opacity: 0
      }

      100% {
        opacity: 1
      }
    }

    .product-txt-mb {
      align-content: center
    }

    .pc-show{
      display: block;
    }

    .mobile-show{
        display: none;
    }

    #A, #C, #D {
        position: relative;
    }

    #C .PC-C-Contents, .Mb-A-Contents, #B{
        filter: blur(10px);
        opacity: 0;
        transition: filter 0.5s ease-out, opacity 0.5s ease-out;
    }

    .hb{
        min-height: 723px;
    }

    @media(max-width: 768px) {
      .tbl_price_tg {
        display: grid;
      }

      .tbl_price_tg p {
        width: 100%;
      }

      .tbl_price_tg div {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        flex-direction: row;
        align-items: center;
        align-content: center;
      }

      .switch_chk {
        margin: 10px;
      }

      .item-sp{
        margin-bottom: -55px !important;
      }
    }

    @media screen and (max-width: 768px) {
        .mobile-show{
          display: block;
        }

        .pc-show{
          display: none;
        }
       
        #A{
            margin-top: 0px; 
            display: block;
            opacity: 1;
        }

        #D .Mb-D-Contents, .Mb-A-Contents, #B {
            filter: blur(10px);
            opacity: 0;
            transition: filter 0.5s ease-out, opacity 0.5s ease-out;
        }

        .hb{
            min-height: 645.76px;
        }
      }

    @media(max-width: 576px) {
      label.part-name img {
        width: calc(100% - 5px) !important;
      }

      #step2 .flex-container {
        overflow-x: hidden;
      }

      div.howto+div {
        font-size: 5vw !important;
      }

      .hb{
            min-height: 594.20px;
        }
    }

    table.cld_tb {
      margin-top: 10px;
    }

    .modal__inner {
      width: 770px;
    }

    @media(max-width: 546px) {
      .product-detail {
        flex-wrap: wrap
      }

      .product-detail-mb {
        align-items: center;
        flex-direction: column-reverse
      }

      .product-img-mb {
        width: 100%
      }

      .product-img-mb img {
        width: 60%
      }

      .product-img-right {
        display: flex;
        justify-content: flex-end
      }

      .product-txt-mb {
        width: 80%
      }
    }

    @media(max-width: 425px) {
      .product-txt-sub {
        width: 95%
      }

      .product-txt-sub h4 {
        font-size: 14px
      }

      .product-txt-sub p {
        font-size: 11px
      }

      .modal__inner {
        width: 95%;
        padding: 1em;
      }

      .hb{
            min-height: 450px;
        }
    }

    .preview-top img,
    .preview-sub .hover img {
      height: auto;
    }

    .gal-btn {
      text-align: center;
      margin-top: 8px;
    }

    .gal-btn a {
      font-size: 16px;
      background: linear-gradient(to bottom, #f7f7f7 0, #dbdbdb 100%);
      border: 1px solid #bab7b6;
      border-radius: 5px;
      box-shadow: 0 3.5px 0 0 #b5b5b5;
      color: #333;
      display: inline-block;
      padding: 10px 30px;
      text-decoration: none;
      text-align: center;
      transition: all .3s ease;
    }

    .gal-btn a:hover {
      box-shadow: none;
      transform: translateY(3px);
    }

    #date_create_sample1,
    #date_create_sample2,
    #date_create_speed_1,
    #date_create_speed_2 {
      font-size: 22px;
      font-weight: bold;
      color: red;
      letter-spacing: -1px;
      overflow: hidden;
    }

    .mt-10 {
      max-width: 100%;
    }

    .group-container .btn-select:has(input[type=radio]:checked) {
      border: 1px solid #ffffff;
      background: #f7b516;
      color: white;
    }

    .box-purple {
      color: #a428a5;
      background: #ff93ff;
      border-radius: 6px;
      font-size: 18px;
      padding: 8px 10px;
      margin-right: 10px;
      min-width: 215px;
      text-align: center;
      height: unset;
    }

    .d-inline {
      display: inline-block;
      margin-top: 13px;
    }

    .bg-purple th:nth-child(1) {
      background: #ff93ff;
      color: #9e009f;
    }

    .ballroon {
      top: -16px;
      display: inline-block;
      margin-left: 6px;
      padding: 3px 5px;
      text-decoration: none !important;
      background: #f44336;
      border-radius: 5px;
      border: 1px solid lightgray;
      transition-duration: 0.2s;
      margin-top: 12px;
      color: white !important;
      right: 0px;
      position: absolute;
    }

    a.ballroon .inner {
      white-space: nowrap;
      position: relative;
      white-space: nowrap;
      font-size: 14px;
      border-radius: 32px;
      line-height: 1.33;
      padding: 1px 8px;
    }

    a.ballroon .inner:after {
      content: '';
      position: absolute;
      transform: rotate(223deg);
      z-index: 1;
      width: 6px;
      height: 6px;
      border-right: 1px solid lightgray;
      display: inline-block;
      border-bottom: 1px solid lightgray;
      background-color: #f44336;
      border-top: none;
      border-left: none;
      top: -4.4px;
      left: 0;
      z-index: 0;
    }

    .repeat input[type="text"] {
        padding: 5px 10px;
        margin-left: -32px;
        width: -webkit-fill-available;
    }

    .resource-button-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 16px;
      margin: 14px 0 22px;
      max-width: 780px;
    }

    .resource-button {
      display: flex;
      align-items: center;
      min-height: 84px;
      padding: 14px 26px;
      border: 1px solid #e5e5e5;
      border-radius: 7px;
      background: #fff;
      color: #233c4a;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .22);
      transition: box-shadow .2s ease, transform .2s ease;
    }

    .resource-button:hover,
    .resource-button:focus {
      color: #233c4a;
      text-decoration: none;
      box-shadow: 0 3px 10px rgba(0, 0, 0, .28);
      transform: translateY(-1px);
    }

    .resource-button svg {
      flex: 0 0 54px;
      width: 54px;
      height: 54px;
      margin-right: 22px;
      stroke: currentColor;
      stroke-width: 1.9;
    }

    .resource-button span {
      color: #0d0d0d;
      font-family: IwaUDGoDspPro-Eb, "Noto Sans JP", "Yu Gothic", sans-serif;
      font-size: 22px;
      font-weight: 800;
      line-height: 1.25;
      letter-spacing: 0;
    }

    @media (max-width: 768px) {
      .resource-button-grid {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .resource-button {
        min-height: 74px;
        padding: 12px 18px;
      }

      .resource-button svg {
        flex-basis: 44px;
        width: 44px;
        height: 44px;
        margin-right: 16px;
      }

      .resource-button span {
        font-size: 18px;
      }
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
  <link rel="stylesheet" type="text/css" href="/products/css/foodproducts_banner.css?v=0.03">
  <noscript>
    <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
    <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css">
    <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  </noscript>

  <script>
    (function() {
      function css(el, styles) {
        if (!el) return;
        Object.assign(el.style, styles);

        requestAnimationFrame(() => {
          el.style.filter = "blur(0)";
        });
      }

      function cssAll(selector, styles) {
        document.querySelectorAll(selector).forEach(el => css(el, styles));
      }

      document.addEventListener("DOMContentLoaded", function() {

        if (window.innerWidth < 768) {
          // ===== MOBILE =====

        //   css(document.getElementById("B"), {
        //     filter: "blur(10px)",
        //     opacity: "0",
        //     transition: "filter 0.8s ease-out, opacity 0.8s ease-out"
        //   });

        //   setTimeout(() => {
        //     css(document.getElementById("B"), {
        //       filter: "blur(0px)",
        //       opacity: "1"
        //     });
        //   }, 400);

        //   setTimeout(() => {
        //     cssAll(".Mb-D-Contents", {
        //       filter: "blur(10px)",
        //       opacity: "0",
        //       transform: "translateY(50px)",
        //       transition: "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
        //     });

        //     setTimeout(() => {
        //       cssAll(".Mb-D-Contents", {
        //         filter: "blur(0px)",
        //         opacity: "1",
        //         transform: "translateY(0)"
        //       });
        //     }, 200);

        //   }, 600);

        //   cssAll(".Mb-A-Contents", {
        //     filter: "blur(0px)",
        //     opacity: "1",
        //     transform: "translateY(0)"
        //   });

        } else {
          // ===== DESKTOP =====

        //   css(document.getElementById("B"), {
        //     filter: "blur(10px)",
        //     opacity: "0",
        //     transition: "filter 0.8s ease-out, opacity 0.8s ease-out"
        //   });

        //   setTimeout(() => {
        //     css(document.getElementById("B"), {
        //       filter: "blur(0px)",
        //       opacity: "1"
        //     });
        //   }, 200);

        //   setTimeout(() => {
        //     cssAll(".PC-C-Contents", {
        //       filter: "blur(10px)",
        //       opacity: "0",
        //       transform: "translateY(400px)",
        //       transition: "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
        //     });

        //     setTimeout(() => {
        //       cssAll(".PC-C-Contents", {
        //         filter: "blur(0px)",
        //         opacity: "1",
        //         transform: "translateY(0)"
        //       });
        //     }, 200);

        //   }, 600);

        //   setTimeout(() => {
        //     cssAll(".Mb-A-Contents", {
        //       filter: "blur(10px)",
        //       opacity: "0",
        //       transform: "translateY(-100px)",
        //       transition: "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
        //     });

        //     setTimeout(() => {
        //       cssAll(".Mb-A-Contents", {
        //         filter: "blur(0px)",
        //         opacity: "1",
        //         transform: "translateY(0)"
        //       });
        //     }, 200);
        //   }, 400);
        }

      });
    })();
  </script>
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
    <div id="content_wrapper">
      <?php include("../rubber_info.php"); ?>
      <?php include('../banner-campaign.php') ?>
        
        <div class="hb">
            <div id="">
                <h1 class=""><?= lang('ラバーキーホルダーをオリジナルの形状で製作します。業界最安値 (2026年版)') ?></h1>
                <div class="social-time ">
                    <span class="social-content">
                    <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルキーホルダーの製作。同人からイベント、ノベルティまで、100本から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/rubberkeyholder/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a>
                    <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルキーホルダーの製作。同人からイベント、ノベルティまで、100本から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/rubberkeyholder/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
                    <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubberkeyholder%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubberkeyholder%2f&amp;text=オリジナルキーホルダーの製作。同人からイベント、ノベルティまで、100本から激安価格で製作できます" target="_blank"><i class="fab fa-twitter-square"></i></a>
                    </span>
                    <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
                </div>
            </div>

            <div id="">
                <img src="/products/images/rubber_banner_key.webp?v=1.05">
            </div>

            <div class="pc-show" id="">
                <div>&nbsp;</div>
                <div class="flex-container">
                    <div class="flex-item item">
                        <div class="videoWrapper" style="text-align:center;">
                            <img src="img/rk-yt.webp" data-src="LEfE8rBnJqc" class="iframe" width="100%" height="211" style="max-width:378px;">
                            <div class="playbtn">
                            <div class="tri"></div>
                        </div>
                    </div>
                    <div class="tag-menu new-text">
                        <span class="tag-name non-active">7営業日OK</span>
                        <span class="tag-name non-active">安心安全材料</span>
                        <span class="tag-name non-active">自社生産</span>
                        <span class="tag-name non-active">10個OK</span>
                        <span class="tag-name non-active">防汚加工OK</span>
                        <span class="tag-name non-active">大ロットOK</span>
                    </div>
                    </div>
                    <div class="flex-item item">
                        <h2 style="margin-top: 0px;"><?= lang('業界最安・最速のオリジナルキーホルダー製作') ?></h2>
                        <p class="new-text">
                            <?= lang('ラバーキーホルダーをオリジナルのデザインで製作できます。') ?><br /><br />
                            <?= lang('業界最短の7営業日で製作。最もよくご注文頂く<font style="font-weight:bold;">100個の製作料金は48,000円（税込）と激安価格。</font>さらに<font style="font-weight:bold;">汚れ防止加工を99円（税込単価）</font>でご提供。') ?><br /><br />
                            <?= lang('高品質の特注品を激安で作成できるのが当店の強み。展示会グッズ、同人グッズ、名入れノベルティ等としてご利用頂けます。ラバーキーホルダー製作は当店へ。') ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mobile-show" id="">
                <div class="flex-container">
                    <div class="flex-item item">
                        <div class="tag-menu new-text">
                            <span class="tag-name non-active">7営業日OK</span>
                            <span class="tag-name non-active">安心安全材料</span>
                            <span class="tag-name non-active">自社生産</span>
                            <span class="tag-name non-active">10個OK</span>
                            <span class="tag-name non-active">防汚加工OK</span>
                            <span class="tag-name non-active">大ロットOK</span>
                        </div>
                    </div>
                    <div class="flex-item item">
                        <h2 style="margin-top: 0px;"><?= lang('業界最安・最速のオリジナルキーホルダー製作') ?></h2>
                        <p class="new-text">
                            <?= lang('ラバーキーホルダーをオリジナルのデザインで製作できます。') ?><br /><br />
                            <?= lang('業界最短の7営業日で製作。最もよくご注文頂く100個の製作料金は48,000円（税込）と激安価格。さらに汚れ防止加工を99円（税込単価）でご提供。') ?><br /><br />
                            <?= lang('高品質の特注品を激安で作成できるのが当店の強み。展示会グッズ、同人グッズ、名入れノベルティ等としてご利用頂けます。ラバーキーホルダー製作は当店へ。') ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        

      <input class="modal-state" id="modal-delivery" type="checkbox" />
      <div class="modal">
        <label class="modal__bg" for="modal-delivery"></label>
        <div class="modal__inner modal-delivery" style="height: 275px">
          <label class="modal__close" for="modal-delivery"></label>
          <p class="pcs_info">
            ・このサービスは、個人のお客様専用のサービスです。<br>・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br>・ホットモバイリーファンは、スタンダートの品質基準と同じ製品です。<br>・製作料金は、送料込みの金額です。<br>・製品の色数は12色以内でお願い致します。<br>・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br>・製品の裏面へのシルク印刷につきましては、申し訳ございませんが対応しておりません。<br>・ご注文製品は、本WEBサイトの生産実績に掲載させて頂く場合がございます。<br>・製品は製作開始から約3週間～1ヵ月程度でのご納品となります。<br>・申し訳ございませんが、ご納期の指定はできません。<br>・見積書、請求書、領収書の発行はできません。
          </p>
        </div>
      </div>
      <hr />

      <h2>ラバーキーホルダー完全ガイドをご用意！</h2>
        <div>
            <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
        </div>
        <div>
            <p class="new-text">初めてラバーキーホルダーを製作する方や、よりハイクオリティのラバーキーホルダーを製作したい方なら、オリジナルラバーキーホルダー製作について詳しく知りたいですよね。
            </p><br>
            <p class="new-text">そんな方のために、ラバーキーホルダーの加工タイプや特殊素材、汚れ防止加工、入稿データ作成などについての完全ガイドをご用意。
            </p><br>
            <p class="new-text">最高のラバーキーホルダー製作にぜひともお役立てください。</p>
            <br>
            <div style="text-align: right;">
                <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
            </div>
        </div>
        <hr>
      <h2><?= lang('ラバーキーホルダー') ?><?= lang('製作事例紹介') ?></h2>

        <div class="mobile-show vdo-last">
            <div class="flex-container">
                <div class="flex-item item">
                    <div class="videoWrapper" style="text-align:center;">
                        <img src="img/rk-yt.webp" data-src="LEfE8rBnJqc" class="iframe" width="100%" height="211" style="max-width:378px;">
                        <div class="playbtn">
                            <div class="tri"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="after-vdo">
            <p class="d_TEXT1 new-text"><?= lang('当店にご注文頂きました、オリジナルラバーキーホルダーの製作事例の中より、掲載許可を頂きましたお客様の作品をご紹介させて頂きます。') ?></p>
        </div>

      <div class="tag-menu">
        <?= lang('タグで絞込み') ?>：
        <a href='/gallery/rubberkeyholder?tag=個人' class='tag-name' target="_blank"><?= lang('個人') ?></a>
        <a href='/gallery/rubberkeyholder?tag=会社' class='tag-name' target="_blank"><?= lang('会社') ?></a>
        <a href='/gallery/rubberkeyholder?tag=赤色' class='tag-name' target="_blank"><?= lang('赤色') ?></a>
        <a href='/gallery/rubberkeyholder?tag=青色' class='tag-name' target="_blank"><?= lang('青色') ?></a>
        <a href='/gallery/rubberkeyholder?tag=黄色' class='tag-name' target="_blank"><?= lang('黄色') ?></a>
        <a href='/gallery/rubberkeyholder?tag=紫色' class='tag-name' target="_blank"><?= lang('紫色') ?></a>
        <a href='/gallery/rubberkeyholder?tag=緑色' class='tag-name' target="_blank"><?= lang('緑色') ?></a>
        <a href='/gallery/rubberkeyholder?tag=黒色' class='tag-name' target="_blank"><?= lang('黒色') ?></a>
        <a href='/gallery/rubberkeyholder?tag=黒色' class='tag-name' target="_blank"><?= lang('白色') ?></a>
        <a href='/gallery/rubberkeyholder?tag=1人' class='tag-name' target="_blank"><?= lang('1人') ?></a>
        <a href='/gallery/rubberkeyholder?tag=複数人' class='tag-name' target="_blank"><?= lang('複数人') ?></a>
      </div>
      <!-- New image gallery -->
      <div class="ex-row">
        <div class="gall_pro">
          <!-- new gallery 2023 -->
          <div class="gallbox">
            <div class="prodate">キャラクターキーホルダー</div>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/7.webp" data-lightbox="rubberkeyholder-20231018-1" data-title="株式会社えんじゅ 様 2023年8月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/2023-rubberkeyholder-gallery/7.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/8.webp" data-lightbox="rubberkeyholder-20231018-1" data-title="株式会社えんじゅ 様 2023年8月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/9.webp" data-lightbox="rubberkeyholder-20231018-1" data-title="株式会社えんじゅ 様 2023年8月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">ドット絵のキャラクター</div>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/13.webp" data-lightbox="rubberkeyholder-20231018-2" data-title="	T 様 2023年8月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/2023-rubberkeyholder-gallery/13.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/14.webp" data-lightbox="rubberkeyholder-20231018-2" data-title="	T 様 2023年8月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/15.webp" data-lightbox="rubberkeyholder-20231018-2" data-title="	T 様 2023年8月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">女の子のイラスト</div>
            <a href="/gallery/img-keyholder/rubberkeyholder-301220-3.webp" data-lightbox="rubberkeyholder-301220-3" data-title="A 様 2022年3月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/rubberkeyholder-301220-3.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/rubberkeyholder-301220-4.webp" data-lightbox="rubberkeyholder-301220-3" data-title="A 様 2022年3月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">ノベルティ風キーホルダー</div>
            <a href="/gallery/img-keyholder/key-110121-27a.webp" data-lightbox="key-110121-27a" data-title="A 様 2022年3月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/key-110121-27a.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/key-110121-27b.webp" data-lightbox="key-110121-27a" data-title="A 様 2022年3月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/key-110121-27c.webp" data-lightbox="key-110121-27a" data-title="A 様 2022年3月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">アニメ風イラスト</div>
            <a href="/gallery/img-keyholder/gal9_5-1-n(1).webp" data-lightbox="gal9_5-1-n" data-title="A 様 2022年3月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/gal9_5-1-n(1).webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/gal9_5-2(1).webp" data-lightbox="gal9_5-1-n" data-title="A 様 2022年3月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">車のデザイン</div>
            <a href="/gallery/img-keyholder/1-n(1).webp" data-lightbox="1-n" data-title="K 様 2022年1月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/1-n(1).webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/1-1(1).webp" data-lightbox="1-n" data-title="K 様 2022年1月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">釣りをイメージしたデザイン</div>
            <a href="/gallery/img-keyholder/rub270622-6a.webp" data-lightbox="rub270622-6a" data-title="M 様 2022年1月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/rub270622-6a.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/rub270622-6b.webp" data-lightbox="rub270622-6a" data-title="M 様 2022年1月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/rub270622-6c.webp" data-lightbox="rub270622-6a" data-title="M 様 2022年1月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">鳥のキャラクター</div>
            <a href="/gallery/img-keyholder/20130411_04-n(1).webp" data-lightbox="20130411_04-n" data-title="B 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/20130411_04-n(1).webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/20130411_04-z(1).webp" data-lightbox="20130411_04-n" data-title="B 様 2021年12月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">パズル風のデザイン</div>
            <a href="/gallery/img-keyholder/k-018-n(1).webp" data-lightbox="k-018-n" data-title="B 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/k-018-n(1).webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/k-018-1(1).webp" data-lightbox="k-018-n" data-title="B 様 2021年12月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">バイクに乗る子ども</div>
            <a href="/gallery/img-keyholder/key240621-10a.webp" data-lightbox="key240621-10a" data-title="Y 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/key240621-10a.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/key240621-10b.webp" data-lightbox="key240621-10a" data-title="Y 様 2021年12月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/key240621-10c.webp" data-lightbox="key240621-10a" data-title="Y 様 2021年12月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">レストランのノベルティ風</div>
            <a href="/gallery/img-keyholder/rubberkeyholder-301220-1.webp" data-lightbox="rubberkeyholder-301220-1" data-title="H 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/rubberkeyholder-301220-1.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/rubberkeyholder-301220-2.webp" data-lightbox="rubberkeyholder-301220-1" data-title="H 様 2021年12月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">カラーバリエーション</div>
            <a href="/gallery/img-keyholder/keyholder-p5-5.webp" data-lightbox="keyholder-p5-5" data-title="L 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/keyholder-p5-5.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/keyholder-p5-6.webp" data-lightbox="keyholder-p5-5" data-title="L 様 2021年12月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">周年記念キーホルダー</div>
            <a href="/gallery/img-keyholder/rubberkey_20221229_set3-A.webp" data-lightbox="rubberkey_20221229_set3-A" data-title="L 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/rubberkey_20221229_set3-A.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/rubberkey_20221229_set3-B.webp" data-lightbox="rubberkey_20221229_set3-A" data-title="L 様 2021年12月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/rubberkey_20221229_set3-C.webp" data-lightbox="rubberkey_20221229_set3-A" data-title="L 様 2021年12月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">細かい点のデザイン</div>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/1.webp" data-lightbox="rubberkey_20221229_set7-D" data-title="L 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/2023-rubberkeyholder-gallery/1.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/2.webp" data-lightbox="rubberkey_20221229_set7-D" data-title="H 様 2021年12月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/2023-rubberkeyholder-gallery/3.webp" data-lightbox="rubberkey_20221229_set7-D" data-title="H 様 2021年12月" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">人気のモノクロ配色</div>
            <a href="/gallery/img-keyholder/rubberkey_20221229_set6-D.webp" data-lightbox="rubberkey_20221229_set6-D" data-title="L 様 2021年12月" style="text-decoration:none;">
              <img src="/gallery/img-keyholder/rubberkey_20221229_set6-D.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-keyholder/rubberkey_20221229_set6-E.webp" data-lightbox="rubberkey_20221229_set6-D" data-title="L 様 2021年12月" style="text-decoration:none;"></a>
            <a href="/gallery/img-keyholder/rubberkey_20221229_set6-F.webp" data-lightbox="rubberkey_20221229_set6-D" data-title="L 様 2021年12月" style="text-decoration:none;"></a>
          </div>
          <!-- end gallery 2023 -->
        </div>
        <div style="text-align: center; margin: 15px auto 0;">
          <button class="but3"><a href="/gallery/rubberkeyholder" style="text-decoration: none; color: black; font-size: 16px; padding: 10px 40px;">もっと製作事例を見る <i class="fas fa-arrow-circle-right"></i></a></button>
        </div>
      </div>
      <div style="clear:both;"></div>
      <hr />
      <h2><?= lang('ラバーキーホルダーとは、どんな製品？') ?></h2>
      <div class="product-detail">
        <div class="product-txt">
          <div class="product-txt-sub">
            <h4><a href="#part_keyholder">豊富なアタッチメント</a></h4>
            <p class="">金色ナスカンやハート型も選択可。ゴム松葉やカラーボールチェーンは、<a href="/products/rubberstrap/">ラバーストラップ</a>に掲載。</p>
          </div>
          <div class="product-txt-sub">
            <h4>金型に注型し製品を作成</h4>
            <p>ゴムの液体を金型に注型し製作。印刷物ではありません。スリット線で色をわけます。</p>
          </div>
          <div class="product-txt-sub">
            <h4>ベース層</h4>
            <p>製品の土台となる層です。ほとんどの場合黒色。指定色での製作も可能。</p>
          </div>
        </div>
        <div class="product-img">
          <picture>
            <source media="(max-width:546px)" srcset="images/rubberkey_prodet/285-L.webp?v=0.01">
            <img class="lazy" data-src="images/rubberkey_prodet/210-L.webp?v=0.01" width="210" height="419">
          </picture>
          <div class="product-line-group">
            <div class="product-line" id="line01"></div>
            <div class="product-line" id="line02"></div>
            <div class="product-line" id="line03"></div>
          </div>
        </div>
        <div class="product-img">
          <picture>
            <source media="(max-width:546px)" srcset="images/rubberkey_prodet/285-R.webp?v=0.01">
            <img class="lazy" data-src="images/rubberkey_prodet/210-R.webp?v=0.01" width="210" height="419">
          </picture>
          <div class="product-line-group" style="grid-template-rows: repeat(5, 1fr); justify-items: end;">
            <div></div>
            <div></div>
            <div class="product-line" id="line04"></div>
            <div class="product-line" id="line05"></div>
          </div>
        </div>
        <div class="product-txt" style="align-content: flex-start;">
          <div class="product-txt-sub"></div>
          <div class="product-txt-sub"></div>
          <div class="product-txt-sub">
            <h4>裏面白色印刷</h4>
            <p>シルク印刷より綺麗で剥がれにくいUV印刷を採用。白色以外も印刷可能です。</p>
          </div>
          <div class="product-txt-sub">
            <h4>裏面ベース層</h4>
            <p>裏面はベース層の1色です。</p>
          </div>
          <div class="product-txt-sub"></div>
        </div>
      </div>
      <div class="product-detail product-detail-mb">
        <div class="product-img product-img-mb"><img class="lazy" data-src="/products/rubberstrap/images/rubberstrap_prodet/base_3mm.webp" width="272" height="106"></div>
        <div class="product-txt product-txt-mb">
          <div class="product-txt-sub">
            <h4>ベース厚</h4>
            <p>3mmの通常品と、より重厚感のある5mmが選択可。</p>
          </div>
        </div>
        <div class="product-img product-img-mb product-img-right"><img class="lazy" data-src="/products/rubberstrap/images/rubberstrap_prodet/base_5mm.webp" width="272" height="106"></div>
      </div>
      <hr />

      
      <h2><?= lang('ラバーキーホルダーの製作工程のご紹介') ?></h2>
      <div class="videoWrapper">
        <img src="/products/img/rubber-production-yt.webp" data-src="5KK0a4b1C9Q" class="iframe" width="773" height="435">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <hr>
      <!-- <div>
        <h2><?= lang('製品仕様・付属品等') ?></h2>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td><?= lang('名称') ?></td>
              <td><?= lang('ラバーキーホルダー') ?></td>
            </tr>
            <tr>
              <td><?= lang('素材') ?></td>
              <td><?= lang('ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)。熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細は') ?><a href="/products/foodproducts.php?data=rubberkey" target="_blank">こちら</a>。</td>
            </tr>
            <tr>
              <td><?= lang('大きさ') ?></td>
              <td><?= lang('縦70mmX横70mm以内。（このサイズを超える製品は、別途費用がかかります）') ?></td>
            </tr>
            <tr>
              <td><?= lang('厚さ') ?></td>
              <td><?= lang('3mmもしくは5mm。注文時に指定。指定肉厚可。') ?></td>
            </tr>
            <tr>
              <td><?= lang('色数') ?></td>
              <td><?= lang('スタンダードの場合12色まで、プレミアムの場合18色までご使用頂けます。') ?><br><?= lang('印刷物ではないため、グラデーションは表現できません。') ?></td>
            </tr>
            <tr>
              <td><?= lang('色指定') ?></td>
              <td><?= lang('以下2通りのいづれか。①PANTONE(パントーン)もしくは、DIC(ディック)番号によるご指定。②弊社もしくは、お客様が印刷された、色見本（カラーペーパー）によるご指定。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('裏面印刷') ?></td>
              <td>
                <?= lang('単色（シルク）印刷、カラー印刷ともに可能です。プレミアムの場合は無料、スタンダードの場合は単色が＋@33円（税込）、カラーが＋@55円（税込）となります。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('最小製作個数（最小ロット）') ?></td>
              <td><?= lang('100個より製作します。（ホットモバイリーファンは、10個9,900円です。）') ?></td>
            </tr>
            <tr>
              <td><?= lang('台紙') ?></td>
              <td><?= lang('オプションとして台紙の封入が可能です。') ?> <a href="/products/daishi.html"><?= lang('台紙封入の詳細。') ?></a>
                <?= lang('支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。') ?></td>
            </tr>
          </tbody>
        </table>
      </div> -->
      <!-- <div class="flex-container" style="padding-top: 8px;">
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="download/download.php?fname=template-Key Holder_20260119.zip">
              <span><?= lang('テンプレート') ?></span>
            </a>
            <a class="btn-a btn-yellow" href="/products/data" target="_blank">
              <span><?= lang('入稿データ作成') ?></span>
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/howtoorder/" target="_blank">
              <span><?= lang('ご注文の流れ') ?></span>
            </a>
            <a class="btn-a btn-yellow" href="/contact/?item=ラバーキーホルダ">
              <span><?= lang('無料サンプル') ?></span>
            </a>
          </div>
        </div>
      </div> -->
      <!-- <div class="row how" style="margin-top: -8px;">
        <a class="mt-10 btn-a btn-yellow" href="/lp/rubber-guide-structure.php" target="_blank">
          <div class="howto">
            <img class="lazy" data-src="/products/images/icon-kako-rb.webp" width="34" height="34">
          </div>
          <div><?= lang('立体加工詳細') ?></div>
        </a>
        <a class="mt-10 btn-a btn-yellow" href="/products/quality.html" target="_blank">
          <div class="howto">
            <img class="lazy" data-src="/products/images/icon-qlt-rb.webp" width="34" height="34">
          </div>
          <div><?= lang('品質基準詳細') ?></div>
        </a>
        <a href="javascript:void(0)" class="mt-10 btn-a btn-yellow" for="modal-1" style="cursor: pointer;" onclick="$('#modal-1').prop('checked',true)">
          <div class="howto">
            <img class="lazy" data-src="/products/images/icon-des-rb.webp" width="34" height="34">
          </div>
          <div><?= lang('お客様へのお約束') ?></div>
        </a>
        <input class="modal-state" id="modal-1" type="checkbox">
        <div class="modal">
          <label class="modal__bg" for="modal-1"></label>
          <div class="modal__inner modal1">
            <label class="modal__close" for="modal-1"></label>
            <h2><?= lang('ホットモバイリーから皆様へのお約束') ?></h2>
            <p class="d_TEXT1">
              <?= lang('ホットモバイリーは、日々皆様と接しデザインを作成、製品の製作をする中で、<br>お客様対応と製品品質で日本一でありたいと思い事業活動を行っております。<br>そのために以下の点を事業活動の指針としています。') ?>
            </p>
            <h2><?= lang('数あるノベルティー製作会社の中で、最もきめの細かなサービスを提供する。') ?></h2>
            <p class="d_TEXT1">
              <?= lang('製品の品質に責任を持つ。<br>これら2つの事業活動の指針を実現する為、具体的には以下の点を常に意識してサービスを提供しています。') ?>
            </p>
            <h2><?= lang('皆様のデザインを出来る限り忠実に製品化する。') ?></h2>
            <p class="d_TEXT1">
              <?= lang('皆様のデザインは電子データです。特にキャラクター製品は多くのディテールを含んでおり、<br>データ入稿、一発製品化とはいきません。 多くの場合修正を必要としますが、最低限に留めるよう、注意しております。') ?>
            </p>
            <h2><?= lang('皆様が納得いくまで、何回でもデザインの修正を行います。') ?></h2>
            <p class="d_TEXT1">
              <?= lang('ホットモバイリーは理解しています、オリジナルグッズの製作が決して安くないことを。<br>ですから皆様に納得して頂けるまで、何度でも デザインの修正を無料で行います。<br>デザイン修正を行った結果、オリジナルグッズの製作を希望されない場合、料金はかかりません。') ?>
            </p>
            <h2><?= lang('品質基準を明確にし、品質基準を満たさない製品が納品されてしまった場合、無条件で製品の再作製を行います。') ?></h2>
            <p class="d_TEXT1">
              <?= lang('ホットモバイリーは製品の品質基準を明確にし、全てのお客様に公表しています。<br>この品質基準は、業界で最も厳しい基準だと考えております。<br>このような管理をしても、海外生産ということもあり、品質基準を満たさない製品が皆様に納品されしまうことがあります。<br>その際は理由の如何を問わず、全数再作成し、再度納品させて頂いております。<br>皆様に満足頂くこと、これはホットモバイリーの使命です。') ?>
            </p>
            <h2><?= lang('ホットモバイリーで製作頂いた全てのお客様に、アンケートでご不満な点を質問し、その回答を誰でも閲覧できるように公開します。') ?></h2>
            <p class="d_TEXT1">
              <?= lang('インターネットだけで、高額な買い物をするには不安が残る。ホットモバイリーは、本当に大丈夫なのか？我々が大丈夫だと言うより、<br>皆様に答えて頂いた方がより的確に判断して頂けます。全てのホットモバイリーご利用者様にアンケートを実施。<br>特に記述式で満足した点でなく、不満な点を記載してもらうようお願いしています。<br>アンケート結果は全て公開。弊社で回答の改ざんができないよう、第三者のシステムを利用しています。<br>ご意見をもとに改善させて頂いた例は多く、例えば<br><br>WEBサイトだけで販売されているので、売っている人の顔が見えない。スタッフの自己紹介をWEBでやったら良いのではないか。<br>→WEBサイトにスタッフ紹介を追加しました。') ?><br><br>
              <span style="color: red;"><?= lang('皆様の貴重なご意見やお叱りがホットモバイリーを強くしてくれます。') ?></span>
            </p>
          </div>
        </div>
      </div> -->

      <!-- <div class="flex-container">
        <div class="flex-item item">
          <div class="btn-container item_btn">
            <a class="btn-a ord-btn" href="#est-content">
              <?= lang('ご注文') ?>
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn">
            <a class="btn-a est-btn" href="#est-content">
              <?= lang('見積書作成') ?>
            </a>
          </div>
        </div>
      </div> -->
      <!-- :: campaign banner end :: -->
      <br>
      <div class="flex-container">
        <div class="flex-item item">
          <div class="btn-container item_btn">
            <a class="btn-a ord-btn" href="#est-content" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background-color: #FF9900; border-color: #FF9900;">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
              </svg>
              ご注文
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn">
            <a class="btn-a est-btn" href="#est-content">
              見積書作成
            </a>
          </div>
        </div>
      </div>

      <div>
        <!-- <a href="/products/new-template/template-Key Holder_20260119.zip" class="new-text" download>入稿データテンプレートをダウンロード</a>
        <br><br>
        <a href="/products/data.html" class="new-text">入稿データ作成のご案内</a>
        <br><br>
        <a href="/howtoorder/" class="new-text">ご注文の流れ</a>
        <br><br>
        <a href="/contact/?item=ラバーキーホルダ" class="new-text">無料サンプルの送付をリクエスト</a> -->

        <div class="resource-button-grid">
          <a href="/products/new-template/template-Key Holder_20260119.zip" class="resource-button" download style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <path d="M12 18v-7"></path>
              <path d="M8.5 14.5 12 18l3.5-3.5"></path>
            </svg>
            <span>入稿データテンプレートをダウンロード</span>
          </a>

          <a href="/products/data.html" class="resource-button" style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M5 2.5h13.5v19H6.5A2.5 2.5 0 0 1 4 19V4a1.5 1.5 0 0 1 1-1.5z"></path>
              <path d="M4 19a2.5 2.5 0 0 1 2.5-2.5h12"></path>
              <rect x="8" y="6.5" width="7" height="8" rx=".5"></rect>
              <circle cx="11.5" cy="9.2" r=".9" fill="currentColor" stroke="none"></circle>
              <path d="M11.5 11.5v2.2"></path>
            </svg>
            <span>入稿データ作成のご案内</span>
          </a>

          <a href="/howtoorder/" class="resource-button" style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M10.5 6h5.5a2 2 0 0 1 2 2v3.5"></path>
              <polyline points="15 8.5 18 11.5 21 8.5"></polyline>
              <path d="M13.5 18H8a2 2 0 0 1-2-2v-3.5"></path>
              <polyline points="3 15.5 6 12.5 9 15.5"></polyline>
              <circle cx="6" cy="6" r="3.8" fill="currentColor" stroke="none"></circle>
              <text x="6" y="7.6" font-size="4.5" font-family="sans-serif" font-weight="bold" text-anchor="middle" fill="#fff" stroke="none">1</text>
              <circle cx="18" cy="18" r="3.8" fill="currentColor" stroke="none"></circle>
              <text x="18" y="19.6" font-size="4.5" font-family="sans-serif" font-weight="bold" text-anchor="middle" fill="#fff" stroke="none">2</text>
            </svg>
            <span>ご注文の流れ</span>
          </a>

          <a href="/contact/?item=ラバーキーホルダ" class="resource-button" style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <polyline points="20 12 20 22 4 22 4 12"></polyline>
              <rect x="2" y="7" width="20" height="5"></rect>
              <line x1="12" y1="22" x2="12" y2="7"></line>
              <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
              <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
            </svg>
            <span>無料サンプルの送付をリクエスト</span>
          </a>
        </div>

      </div>

      <div>
        <h2>本生産納期</h2>
        <div style="display: flex;">
          <div class="delivery"><span class="btn-a std-btn"><?= lang('通常納期'); ?></span></div>
          <div class="delivery">
            <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('10営業日後出荷'); ?></div>
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
      <div style="clear:both;"></div>

      <div>
        <span class="box-purple d-inline">スピード発送納期</span>
        <h2 class="red d-inline delivery">7営業日後出荷</h2>
        <table class="cld_tb">
          <tr class="cld_head">
            <td colspan="2"><?= lang('今、この製品を製作開始した場合の出荷日を表示中') ?></td>
          </tr>
          <tr class="cld_r1">
            <td><?= lang('原稿確定日') ?></td>
            <td><?= lang('出荷予定') ?></td>
          </tr>
          <tr class="cld_r2">
            <td><span id="date_create_speed_1"></span></td>
            <td><span id="date_create_speed_2"></span></td>
          </tr>
        </table>
      </div>
      <div style="clear:both;"></div>

      <div>
        <h2>試作納期</h2>
        <div style="display: flex;">
          <div class="delivery"><span class="btn-a" style="background: #66fffe; color: #000;">試作納期</span>
          </div>
          <div class="delivery">
            <div class="tb_06" style="color: #004140;padding: 2px 5px;">6営業日後出荷</div>
          </div>
        </div>
        <table class="cld_tb" style="display: table;">
          <tbody>
            <tr class="cld_head">
              <td colspan="2"><?= lang('今、この製品をご注文頂いた場合の出荷予定日を表示中'); ?></td>
            </tr>
            <tr class="cld_r1">
              <td><?= lang('原稿確定日') ?></td>
              <td><?= lang('出荷予定') ?></td>
            </tr>
            <tr class="cld_r2">
              <td><span id="date_create_sample1"></span></td>
              <td><span id="date_create_sample2"></span></td>
            </tr>
          </tbody>
        </table>
        <span class="font_s" style="float:right; text-align: right;">
          <span class="sun">※</span><?= lang('お急ぎの場合、営業担当にご相談下さい。出来る限りお客様のご希望に沿うよう対応させていただきます。'); ?><br>
          <span class="sun">※</span><?= lang('営業日には、土日祝日を含みません。'); ?><br>
        </span>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <h2 id="part_keyholder"><?= lang('リングパーツの種類') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('チェーン付きのキーリングが基本となります。キーリングには、シルバーとブラックの2種類があります。シルバーリングには、大、中、小の3種類の大きさがあります。チェーンを使わない、黒色プラスチック留め具にてリングを固定することもできます。写真をクリックすると拡大写真と詳細説明を確認頂けます。') ?>
      </p>
      <br>
      <div class="row">
        <div class="mt-10-part">
          <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-1" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm">
            <img class="picpro lazy" data-src="/products/images/HM_part15.webp" width="160" height="160">
          </a><br>
          <div>+0円</div>
          <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-1-1" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-2" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm">
            <img class="picpro lazy" data-src="/products/images/HM_part18.webp" width="160" height="160">
          </a><br>
          <div>+0円</div>
          <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-2-1" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-3" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm">
            <img class="picpro lazy" data-src="/products/images/HM_part16.webp" width="160" height="160">
          </a><br>
          <div>+0円</div>
          <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-3-1" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-4" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm">
            <img class="picpro lazy" data-src="/products/images/HM_part19.webp" width="160" height="160">
          </a><br>
          <div>+0円</div>
          <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-4-1" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-5" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm">
            <img class="picpro lazy" data-src="/products/images/HM_part17.webp" width="160" height="160">
          </a><br>
          <div>+0円</div>
          <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-5-1" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-6" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm">
            <img class="picpro lazy" data-src="/products/images/HM_part20.webp" width="160" height="160">
          </a><br>
          <div>+0円</div>
          <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-6-1" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part21.webp" data-lightbox="img-part-set-7" data-title="<strong>【リング黒色。黒色リングです】</strong>ビス留め仕様になりますので、チェーン以外でお探しの場合はこちらをお勧めしております。 リング 外径：30mm　内径：26mm <br> <font color='red'>※ハイインパクト（5mm厚）に使えません</font>">
            <img class="picpro lazy" data-src="/products/images/HM_part21.webp" width="160" height="160">
          </a><br>
          <div>+0円</div>
          <a href="/products/images/HM_part21.webp" data-lightbox="img-part-set-7-1" data-title="<strong>【リング黒色。黒色リングです】</strong>ビス留め仕様になりますので、チェーン以外でお探しの場合はこちらをお勧めしております。 リング 外径：30mm　内径：26mm <br> <font color='red'>※ハイインパクト（5mm厚）に使えません</font>" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-9" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。">
            <img class="picpro lazy" data-src="/products/images/HM_part5.webp" width="160" height="160">
          </a><br />
          <div>+11円</div>
          <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-9-1" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-8" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。">
            <img class="picpro lazy" data-src="/products/images/HM_part4.webp" width="160" height="160">
          </a><br />
          <div>+22円</div>
          <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-8-1" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-10" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。">
            <img class="picpro lazy" data-src="/products/images/HM_part6.webp" width="160" height="160">
          </a><br />
          <div>+22円</div>
          <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-10-1" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-11" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。">
            <img class="picpro lazy" data-src="/products/images/HM_part7.webp" width="160" height="160">
          </a><br />
          <div>+22円</div>
          <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-11-1" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-12" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。">
            <img class="picpro lazy" data-src="/products/images/HM_part8.webp" width="160" height="160">
          </a><br />
          <div>+22円</div>
          <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-12-1" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
        </div>
      </div>
      <div style="clear: both;" class="">&nbsp;</div>
      <hr />
      <h2><?= lang('製作料金・納期一覧') ?></h2>
      <div class="tbl_price_tg" style="position:relative;">
        <p class="new-text">
          <?= lang('製作料金（送料込み、税込み総額）と当店からの出荷日目安が表示されます。ご納期は、現時点でご注文確定（デザイン確定、お支払い完了）の場合です。翌日以降ご注文の出荷日目安は、下記よりご注文予定日を選択してください。'); ?>
        </p>
        <div>
          <!-- <label class="switch_chk">
            <input type="checkbox" id="tg_unit" onchange="$('.ut_price').toggle();" /><label for="tg_unit"></label>
            <?= lang('単価を表示'); ?>
          </label> -->
          <label class="switch_chk">
            <input type="checkbox" id="tg_prdt" onchange="$('.ut_date').toggle();" /><label for="tg_prdt"></label>
            <?= lang('営業日数を表示'); ?>
          </label>
        </div>
      </div>
      <div style="clear: both;"></div>
      <?php
      $unit = [100, 200, 300, 500, 1000, 3000, 5000];
      ?>
      <div class="tbl_s cl2" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tbl_price_deli loading">
          <thead>
            <tr>
              <th></th>
              <th colspan="4">スタンダード</th>
              <th colspan="4">プレミアム</th>
            </tr>
            <tr>
              <th rowspan="2">数量</th>
              <th colspan="2">製作料金（税込総額）</th>
              <th colspan="2">当店からの出荷日目安</th>
              <th colspan="2">製作料金（税込総額）</th>
              <th colspan="2">当店からの出荷日目安</th>
            </tr>
            <tr>
              <th>3mm厚</th>
              <th>5mm厚</th>
              <th>量産のみ</th>
              <th>試作込み最短</th>
              <th>3mm厚</th>
              <th>5mm厚</th>
              <th>量産のみ</th>
              <th>試作込み最短</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($unit as $key => $value) {
            ?>
              <tr>
                <td><?= $value ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スタンダードには裏面印刷代金、トレース代金は含まれておりません。') ?><br>
        ※<?= lang('プレミアムでは、試作品、裏面印刷、トレース代金は無料です。') ?><br>
        ※<?= lang('試作込みの製作日数には、試作品配送日数として1日加算しております。') ?><br><br>
      </div>

      <table class="tbl_price_deli bg-purple">
        <thead>
          <tr>
            <th colspan="5">スタンダード（スピード発送）</th>
          </tr>
          <tr>
            <td rowspan="2">数量</th>
            <td colspan="2">製作料金（税込総額）</th>
            <td colspan="2">当店からの出荷日目安</th>
          </tr>
          <tr>
            <td>3mm厚</th>
            <td>5mm厚</th>
            <td>量産のみ</th>
            <td>試作込み最短</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>100</td>
            <td>
              <div class="ut_price">543円</div>
              <div class="tt_price">54,300円</div>
            </td>
            <td>
              <div class="ut_price">651円</div>
              <div class="tt_price">65,100円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>200</td>
            <td>
              <div class="ut_price">442円</div>
              <div class="tt_price">88,400円</div>
            </td>
            <td>
              <div class="ut_price">530円</div>
              <div class="tt_price">106,000円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>300</td>
            <td>
              <div class="ut_price">339円</div>
              <div class="tt_price">101,700円</div>
            </td>
            <td>
              <div class="ut_price">407円</div>
              <div class="tt_price">122,100円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
        </tbody>
      </table>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは300個となります。') ?><br>
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br>
        ※<?= lang('汚れ防止加工は、スピード発送の対象外です。') ?><br><br>
      </div>

      <table class="tbl_price_deli for_fans">
        <thead>
          <tr>
            <th></th>
            <th colspan="4">ホットモバイリーファン</th>
          </tr>
          <tr>
            <th rowspan="2">数量</th>
            <th colspan="2">製作料金（税込総額）</th>
            <th colspan="2">当店からの出荷日目安</th>
          </tr>
          <tr>
            <th>3mm厚</th>
            <th>5mm厚</th>
            <th>量産のみ</th>
            <th>試作込み最短</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>10</td>
            <td>
              <div class="ut_price">990円</div>
              <div class="tt_price">9,900円</div>
            </td>
            <td>なし</td>
            <td>-</td>
            <td>なし</td>
          </tr>
        </tbody>
      </table>
      <div class="font_s for_fans" style="text-align: right;">※<?= lang('トレース代金は含まれております。') ?><br></div>
      <h2><?= lang('スタンダードとプレミアムの違い') ?></h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/product-difference.php?data=3" target="_blank"><img class="lazy" data-src="/img/top3-banner.webp" width="745" height="450"></a></div>
      <h2><?= lang('納期（製作期間）') ?></h2>
      <div style="clear: both;"></div>
      <?php include('../../delivery_note.php'); ?>
      <!-- <div id="info_div"></div>    -->
      <p class="d_TEXT1 new-text"><?= lang('納期=製作日数+配送日数で計算致します。') ?></p><br />
      <p class="d_TEXT1 new-text">【<?= lang('製作期間') ?>】</p>
      ◆<?= lang('スタンダード製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr align="center">
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">300<?= lang('個以下') ?></td>
          <td align="center">1,000<?= lang('個以下') ?></td>
          <td align="center">3,000<?= lang('個程度まで') ?></td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">6</td>
          <td align="center">6</td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数(試作あり)') ?></td>
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">10</td>
          <td align="center">14</td>
          <td align="center">22～</td>
        </tr>
      </table><br />

      ◆<?= lang('スタンダード（スピード発送）製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">300個以下</td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数（試作あり）') ?></td>
          <td align="center">13</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">7</td>
        </tr>
      </table><br />

      ◆<?= lang('プレミアム製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">300<?= lang('個以下') ?></td>
          <td align="center">1,000<?= lang('個以下') ?></td>
          <td align="center">3,000<?= lang('個程度まで') ?></td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">6</td>
          <td align="center">6</td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数(試作あり)') ?></td>
          <td align="center">23</td>
          <td align="center">28</td>
          <td align="center">36～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
      </table><br />
      ◆<?= lang('ホットモバイリーファンは納期のご指定は頂けません。') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">10<?= lang('個') ?></td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">対応なし</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数(試作あり)') ?></td>
          <td align="center">対応なし</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">約3週間～1ヵ月程度</td>
        </tr>
      </table><br />
      <p class="d_TEXT1 new-text"><?= lang('◆汚れ防止加工') ?><br /><?= lang('スタンダード/プレミアム製品製作期間+3～5営業日') ?></p><br />

      <div class="font_s new-text" style="">
        <?= lang('弊社稼働日につきまして、詳しくは<a href="/guide/delivery">こちら</a>をご覧ください。') ?><br /><?= lang('製品生産国中国の長期休暇につきましては、別途定める休日が指定されます。') ?><br /><?= lang('シルク印刷ありでのご注文の場合、+1営業日。') ?><br /><?= lang('色味指定を印刷紙で行う場合、+3営業日。') ?><br /><?= lang('（お客様から印刷紙手配が遅れる場合、この限りではございません）') ?>
      </div>
      <div style="clear: both;">&nbsp;</div>
      <p class="d_TEXT1 new-text">
        【<?= lang('配送日数') ?>】<br /><?= lang('北海道、九州、沖縄は2日。その他地域は1日。（離島等に関しては、別途お問い合わせください。）') ?><br /><?= lang('配送日数は、営業日でなく土日祝も含めた日数となります。') ?>
      </p><br />
      <p class="d_TEXT1 new-text">
        【<?= lang('納期計算例') ?>】<br /><?= lang('スタンダード仕様にて、300個、試作品なしでご注文の場合、') ?><br /><?= lang('・製作期間：10営業日') ?><br /><?= lang('・配送期間：1-2日（配送地域により異なります）') ?><br /><?= lang('となります。') ?>
      </p>
      <div style="clear: both;">&nbsp;</div>
      <div style="margin-top: 10px;"><a href="/campaign/quality_rubberstrap.php"><img data-src="/products/images/banner-quality-2025.webp" class="lazy" width="100%" height="" style="max-width:770px;"></a></div>
      <?php include("../campaign_news.php"); ?>
      <h2>厚労省の定める規格基準に合格した安全性の高い材料を使用</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/foodproducts.php?data=rubberkey" target="_blank"><img class="lazy" data-src="/img/safety-banner.webp" width="745" height="70"></a></div>
      <div style="clear:both;">&nbsp;</div>
      <div id="est-content">

      <?php include('../campaign_banner.php') ?>

        <div style="clear:both;"></div>
        <h2><?= lang('ご注文・見積書作成') ?></h2>
      </div>
      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('ラバーキーホルダー') ?>】</h3>
          <span class="total-price"><span class="prd_total">0</span><?= lang('円（税込）') ?></span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray; margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td><?= lang('ご注文タイプ') ?></td>
                <td><span id="sample-prd-pcs">-</span></td>
              </tr>
              <tr>
                <td><?= lang('サイズ') ?></td>
                <td><span id="sample-prd-size">-</span></td>
              </tr>
              <tr>
                <td><?= lang('裏面印刷') ?></td>
                <td><span id="sample-prd-screen">-</span></td>
              </tr>
              <tr>
                <td><?= lang('汚れ防止加工') ?></td>
                <td><span id="sample-prd-coating">-</span></td>
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
                <td><?= lang('データトレース') ?></td>
                <td><span id="sample-prd-trace">-</span></td>
              </tr>
            </table>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img class="lazy" data-src="/products/images/HM_part15.webp" width="135" height="135" id="sample-part-pic" class="picpro"><br />
            <span id="sample-part-name"><?= lang('通常松葉（カニカン）') ?></span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img class="lazy" data-src="/products/acrylic/img/coming-soon.webp" width="135" height="135" id="sample-paper-pic" class="picpro"><br />
            <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div>
                <span class="step-details"><?= lang('ご注文タイプ・裏面印刷') ?></span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div>
                <span class="step-details"><?= lang('アタッチメント・台紙等') ?></span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div>
                <span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="ラバーキーホルダー" />
          </div>
          <?php
          switch ($ItemPCS) {
            case "スタンダード":
              $lsSelected_1pcs = 'checked';
              break;
            case "プレミアム":
              $lsSelected_2pcs = 'checked';
              break;
            case "ホットモバイリーファン":
              $lsSelected_3pcs = 'checked';
              break;
            case "スタンダード（スピード7営業日発送）":
              $lsSelected_4pcs = 'checked';
              break;
            case "トリプルベネフィットキャンペーン":
              $lsSelected_0pcs = 'checked';
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
            case "印刷なし":
              $printing1_checked = 'checked';
              break;
            case "単色（シルク）印刷":
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
            
            <h3><?= lang('ご注文タイプ') ?></h3><a class="btn-details inline" href="javascript:void(0)" for="modal-3" style="cursor: pointer;" onclick="$('#modal-3').prop('checked',true)">詳細</a>
            <input class="modal-state" id="modal-3" type="checkbox">
            <div class="modal">
              <label class="modal__bg" for="modal-3"></label>
              <div class="modal__inner modal1">
                <label class="modal__close" for="modal-3"></label>
                <div class="flex-container b-bottom p-bottom">
                  <div class="icon-img">
                    <img class="lazy" data-src="/products/images/icon-standard-pc.webp" width="122" height="122">
                  </div>
                  <div class="icon-text">
                    <h4><?= lang('配布用ノベルティ製品として十分な品質とコストパフォーマンスを両立'); ?></h4>
                    <p>
                      <?= lang('通常のラバーストラップのご注文はスタンダートプランをご利用下さい。来店されたお客様への景品や粗品、イベントでの販売などに最適です。玩具や、趣味としての販売にお使い頂くのに十分な品質を確保しております。また、業界最速での納期をご提供しながら、コストパフォーマンスの高さを実現。特に法人のお客様の大ロット・短納期へのご要望、台紙や同梱する書類などへの対応も含めて専任の担当者がご希望にお応えできる体制を構築しております。'); ?><br /><a href="https://hotmobily.jp/products/quality.html#quality-check1"><?= lang('スタンダートの品質基準'); ?></a>
                    </p>
                    <div>&nbsp;</div>
                  </div>
                </div>
                <div>&nbsp;</div>
                <div class="flex-container b-bottom p-bottom">
                  <div class="icon-img"><img class="lazy" data-src="/products/images/icon-rush-pc.jpg" width="122" height="122"></div>
                  <div class="icon-text">
                    <h4><?= lang('7営業日出荷。業界最速のスピードで製作'); ?></h4>
                    <p>
                      <?= lang('原稿確定日より、7営業日後に出荷いたします。例）月曜日に原稿確定の場合、翌週火曜日に出荷<br/>スタンダードと同じ品質とコストパフォーマンスで、納期を縮めることができます。「とにかく早く作りたい！」とお考えのお客様に最適。このプランは、200個までのご注文で選択いただけます。'); ?><br /><a href="https://hotmobily.jp/products/quality.html#quality-check1"><?= lang('スタンダード（スピード発送）の品質基準はスタンダートの品質基準をご覧ください'); ?></a>
                    </p>
                    <div>&nbsp;</div>
                  </div>
                </div>
                <div>&nbsp;</div>
                <div class="flex-container b-bottom p-bottom">
                  <div class="icon-img"><img class="lazy" data-src="/products/images/icon-premium-pc.webp" width="122" height="122"></div>
                  <div class="icon-text">
                    <h4><?= lang('品質重視。販売用製品として十分な品質を保証'); ?></h4>
                    <p>
                      <?= lang('物販サイトや店頭での販売や限られた大切なお客様への配布などに最適です。スタンダートプランとの一番の違いは品質の高さです。通常の玩具やノベルティ製品に要求される品質をはるかに超えた卓越した逸品としての品質を確保しております。海外での検査に加え、日本国内の専門検査会社での検査を行い品質を保証致します。<br/>また、ハイスペックな製品をお求めのお客様に対応する為、製作可能な色数や裏面印刷へのこだわりなど、専任の担当者が細部までヒアリングを行い、対応させて頂きます。'); ?><br /><a href="https://hotmobily.jp/products/quality.html#quality-check2"><?= lang('プレミアムの品質基準'); ?></a>
                    </p>
                    <div>&nbsp;</div>
                  </div>
                </div>
                <div>&nbsp;</div>
                <div class="flex-container p-bottom">
                  <div class="icon-img"><img class="lazy" data-src="/products/images/icon-hotmobilyfan-pc.webp" width="122" height="122"></div>
                  <div class="icon-text">
                    <h4><?= lang('ラバスト製作の入門プラン。業界最安値であなたの創作意欲に応えます'); ?></h4>
                    <p>
                      <?= lang('10個9,900円（税込)。ラバスト製作の初心者向け入門プランです。ラバストと他の製品の大きな違いは、事前に金型を作る必要があるので、ラバスト独特のデザインに変更しないといけない点です。こういった所を、できる限り小予算で体験して頂いたり、これから本格的にラバストを含めたグッズ製作をやってみようという方を念頭に置いたプランです。'); ?><br /><span class="font_s"><?= lang('・このサービスは、個人のお客様専用のサービスです。<br/>・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br/>・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br/>・ご納期の指定はできません。<br/>・見積書、請求書、領収書の発行はできません。WEBサイトからのご注文のみとなります。<br/>ホットモバイリーファンの品質基準は'); ?><a href="https://hotmobily.jp/products/quality.html#quality-check1"><?= lang('スタンダートの品質基準をご覧ください'); ?></a></span>
                    </p>
                    <div>&nbsp;</div>
                  </div>
                </div>
              </div>
            </div>
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_1pcs ?>><?= lang('スタンダード') ?> <span class="checkmark"></span></label></div>
              <div class="part-content" <?=$delivery_disabled?>><label class="part-name"><input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_4pcs ?> <?= $planDisabled ?>><?= lang('スタンダード（スピード7営業日発送）') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?> <?= $planDisabled ?>><?= lang('プレミアム') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs3" value="ホットモバイリーファン" onclick="type_special_disabled('t1');clearValue();" <?= $lsSelected_3pcs ?> <?= $planDisabled ?>><?= lang('ホットモバイリーファン (10個 9,900円税込)') ?><span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_pcs"></span>
              <div class="pcs_option">
                <p class="pcs_group"><span class="pcs_01" id="pcs_status"></span>
                  <span id="pcs_txt"></span>
                </p>
                <p class="pcs_info">
                  <?= lang('・このサービスは、個人のお客様専用のサービスです。<br/>・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br/>・ホットモバイリーファンは、スタンダートの品質基準と同じ製品です。<br/>・製作料金は、送料込みの金額です。<br/>・製品の色数は12色以内でお願い致します。<br/>・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br/>・製品の裏面へのシルク印刷につきましては、申し訳ございませんが対応しておりません。<br/>・ご注文製品は、本WEBサイトの生産実績に掲載させて頂く場合がございます。<br/>・製品は製作開始から約3週間～1ヵ月程度でのご納品となります。<br/>・申し訳ございませんが、ご納期の指定はできません。<br/>・見積書、請求書、領収書の発行はできません。<br/>') ?>
                </p>
              </div>
            </div>
            <h3><?= lang('ベース厚さ') ?></h3><a class="btn-details inline" href="javascript:void(0)" for="modal-4" style="cursor: pointer;" onclick="$('#modal-4').prop('checked',true)">詳細</a>
            <input class="modal-state" id="modal-4" type="checkbox">
            <div class="modal">
              <label class="modal__bg" for="modal-4"></label>
              <div class="modal__inner modal1" style="height: fit-content;"><label class="modal__close" for="modal-4"></label>最下層の厚みは、通常3mmでございます。ハイインパクトの最下層は5mmとなりまして、製品単価はスタンダード+20％増、プレミアム+10％増、となります。
              </div>
            </div>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" id="normal_size" name="ItemSize" value="通常（80*80/3mm厚）" <?php echo $tickness0_checked ?> onclick="clearValue();" /><?= lang('通常（3mm厚）') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" id="big_size" name="ItemSize" value="ハイインパクト（80*80/5mm厚）" <?php echo $tickness1_checked ?> onclick="clearValue();" /><?= lang('ハイインパクト（5mm厚）') ?> <span class="checkmark"></span></label></div>
            </div>

            <h3><?= lang('特殊素材（蓄光／蛍光／ラメ／金色銀色）') ?></h3>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材なし" <?php echo $material0_checked ?> onclick="clearValue();" /><?= lang('特殊素材なし') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材あり" <?php echo $material1_checked ?> onclick="clearValue();" /><?= lang('特殊素材あり') ?> <span class="checkmark"></span></label></div>
            </div>

            <h3><?= lang('裏面印刷') ?></h3>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="nashiprint" value="印刷なし" <?php echo $printing1_checked ?> onclick="clearValue();" /><?= lang('印刷なし') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="ariprint" value="単色（シルク）印刷" <?php echo $printing2_checked ?> onclick="clearValue();" /><?= lang('単色（シルク）印刷') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="fcprint" value="フルカラー印刷" <?php echo $printing3_checked ?> onclick="clearValue();" /><?= lang('フルカラー印刷') ?>
                  <span class="checkmark"></span></label></div>
              <span style="color: red" id="error_print"></span>
              <font color="red">※<?= lang('プレミアムは裏面印刷が無料') ?></font>
            </div>
            <h3><?= lang('汚れ防止加工') ?></h3><a class="btn-details inline" href="javascript:void(0)" for="modal-2" style="cursor: pointer;" onclick="$('#modal-2').prop('checked',true)">詳細</a>
            <input class="modal-state" id="modal-2" type="checkbox">
            <div class="modal">
              <label class="modal__bg" for="modal-2"></label>
              <div class="modal__inner modal1" style="height: fit-content;">
                <label class="modal__close" for="modal-2"></label>
                <img src="/products/images/banner-coating.webp" width="660" height="327"><br>
                <p>ラバー製品に汚れ防止加工が出来ます。汚れが付着した場合、水洗いして頂くで簡単に汚れが落ちます。</p>
                <p class="red">スタンダード（スピード7営業日発送）では、汚れ防止加工はお選びいただけません。</p>
              </div>
            </div>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="coating" id="coating0" value="汚れ防止加工なし" <?php echo $coating0_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工なし') ?>
                  <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="coating" id="coating1" value="汚れ防止加工あり" <?php echo $coating1_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工あり (納期+3～5営業日）') ?> <span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_coating"></span>
            </div>

            <h3>カラーバリエーション</h3><a class="btn-details inline" href="javascript:void(0)" for="modal-5" style="cursor: pointer;" onclick="$('#modal-5').prop('checked',true)">詳細</a>
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
                    <img src="/products/images/HM_design1.webp" width="300" height="300">
                  </div>
                  <div class="flex-item">
                    <img src="/products/images/HM_design2.webp" width="300" height="300">
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
                <input type="radio" name="ItemDesignVariation" value="1種類" <?php echo $lsSelected_1design ?> onclick="clearValue();">1種類
              </label>
              <label class="btn-select">
                <input type="radio" name="ItemDesignVariation" value="2種類" <?php echo $lsSelected_2design ?> onclick="clearValue();">2種類
              </label>
              <label class="btn-select">
                <input type="radio" name="ItemDesignVariation" value="3種類" <?php echo $lsSelected_3design ?> onclick="clearValue();">3種類
              </label>
              <label class="btn-select">
                <input type="radio" name="ItemDesignVariation" value="4種類" <?php echo $lsSelected_4design ?> onclick="clearValue();">4種類
              </label>
            </div>
            <p>1種類カラーバリエーションが増えると、＋3300円（税込）</p>
            <div>&nbsp;</div>
            <h3><?= lang('ご注文本数') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="numberOf" id="no_of_order" class="right" onchange="this.value=format_number(this.value);" value="<?php echo $numberOf ?>" style="text-align: right;"><br /></label>
                <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?></div>
              </div>
            </div>
            <span style="color: red" id="error_message"></span>
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
														<input type="radio" name="part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($part == $attachment[$i]["part_name"] ? 'checked' : ($i == 0 ? 'checked' : '')) . '>
														<img class="picpro lazy" data-src="' . $attachment[$i]["part_pic"] . '" width="95" height="95">
														<br><span class="part_price_std">+' . ($attachment[$i]["part_price"] * 1.1) . '円</span><span class="part_price_prm">+0円</span>
														</label>
														</div>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <h3><?= lang('台紙') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='paper_select'>
                    <input type="checkbox" class="checkbox" name="paper_select" value="あり" onclick="check_val('next')" <?= ($paper_select == "あり" ? 'checked' : '') ?>>
                    <div class="knobs"><span></span></div>
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
                  <?php if ($paper_select == "あり") {
                    include("../paper_preview.php");
                  } ?></div>
              </div>
            </div>
            <h3><?= lang('試作品・データトレース') ?></h3>
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
              <font color="red"><?= lang('※プレミアムは試作品代金が無料') ?></font>
              <font color="red"><?= lang('※ご注文納期とは別に、6営業日+配送2日がかかります。') ?></font>
            </div>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='DeFormat'>
                    <input type="checkbox" class="checkbox" name="DeFormat" value="あり" onclick="setToInput();" <?= $others_checked ?>>
                    <div class="knobs"><span></span></div>
                    <div class="layer"></div>
                  </div>
                  <?= lang('データトレース') ?>
                </label>
              </div>
              <font color="red"><?= lang('※プレミアムはトレース代金が無料') ?></font>
            </div>
          </div>
          <div class="estimate-content flex-item" id="step3">
            <div class="flex-container">
              <div class="flex-item">
                <h3><?= lang('製品仕様') ?></h3>
                <table class="table_rubber">
                  <tbody>
                    <tr>
                      <td class="TableLeft"><?= lang('ご注文タイプ') ?></td>
                      <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('サイズ') ?></td>
                      <td class="" id="prd_ItemSize" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('裏面印刷') ?></td>
                      <td class="" id="prd_silk_print" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class="" id="prd_coating" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('ご注文本数') ?></td>
                      <td class="" id="prd_qty" style="text-align: left;"></td>
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
                      <td class="" id="prd_SendPrototype" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class="" id="prd_DeFormat" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('カラーバリエーション') ?></td>
                      <td class="" id="prd_ItemDesign" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('特殊素材') ?></td>
                      <td class="" id="prd_ItemMaterial" style="text-align: left;"></td>
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
                      <td class="TableLeft"><?= lang('裏面印刷代金') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="SilkPrint" readonly="readonly" id="textfield13" class="right" value="<?php echo $SilkPrint ?>" />円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="coatingPrice" readonly="readonly" id="textfield13_2" class="right" value="<?= $coatingPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('台紙') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PaperPrice" readonly="readonly" id="textfield7_2" class="right" value="<?= $PaperPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="ProShipping" readonly="readonly" id="textfield3" class="right" value="<?= $ProShipping ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="TraceCharge" readonly="readonly" id="textfield4" class="right" value="<?= $TraceCharge ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('カラーバリエーション') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="DesignsCharge" readonly="readonly" id="DesignsCharge" class="right" value="<?= $DesignsCharge ?>">円</td>
                    </tr>
                    <tr>
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
                      <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle()" />
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
                    <img src="/img/delivery_10days_notice.jpg" alt="Flowers" style="width:100%;">
                  </picture>
                  <input type="button" class="btn btn-back flex-item" value="<?= lang('OK') ?>" for="modal-ord" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form); " />
                </diV>

              </div>
            </div>
          </div>
          <div id="acrylic-btn" class="btn-container">
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn('back')"><?= lang('戻る') ?></a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')"><?= lang('アタッチメント・オプション入力へ') ?></a>
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
                <td class=""><input type="text" id="zip" name="zip" maxlength="8" size="15" value="">&nbsp;<input type="button" id="src_btn" onclick="address_fn();" value="住所に変換"><br><span id="error" style="color:red"></span></td>
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
      <hr />
      <?php $fd_type = "rubberkey";
      include '../rubber_product_detail_test.php'; ?>
      <h2><?= lang('営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <div align="center">
        <a href="//hotmobily.jp/meeting_date/"><img data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" class="lazy" /></a>
      </div>
      <p class="d_TEXT1"></p><br />
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->
  <!--フッター ここから-->
  <?php include("../../footer.php"); ?>
  <!--フッター ここまで-->
  <!-- /lightbox2-master -->
  <script src="js/lightbox.js"></script>
  <script>
    lightbox.option({
      'maxWidth': 600,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <!-- /lightbox2-master -->

  <!-- google script -->
  <!-- リマーケティング タグの Google コード -->
  <!--
         リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
         http://google.com/ads/remarketingsetup
      -->
  <!-- Swiper JS -->
  <script type="text/javascript" src="/js/_setToInput_2026.js?v=<?php echo date('is') ?>"></script>
  <!-- <script type="text/javascript" src="<?= $cal_rubber_js ?>"></script> -->
  <script language="JavaScript" src="/js/validation_new.js?v=1.11" type="text/javascript"></script>
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>
  <script type="text/javascript" language="javascript">

    // function updateMargin() {
    //     if (window.innerWidth <= 768) {
    //         let vdoLast = document.querySelector('.vdo-last');
    //         let vdoText = document.querySelector('.after-vdo');

    //         if (vdoLast && vdoText) {
    //         let height = vdoLast.offsetHeight;
    //             console.log(height);
    //             if (height >= 183) {
    //                 vdoText.style.marginTop = `${height - 150}px`;
    //             } else {
    //                 if (height <= 155) {
    //                     if (height <= 148) {
    //                         vdoText.style.marginTop = `${height - 70}px`;
    //                     } else {
    //                         vdoText.style.marginTop = `${height - 100}px`;
    //                     }
    //                 } else {
    //                     vdoText.style.marginTop = `${height - 120}px`;
    //                 }
    //             }
    //         }
    //     } else {
    //         document.querySelector('.after-vdo').style.marginTop = "";
    //     }
    // }

    // เรียกใช้เมื่อโหลดหน้าเว็บ
    // window.addEventListener('load', updateMargin);

    // เรียกใช้เมื่อมีการเปลี่ยนขนาดหน้าจอ
    // window.addEventListener('resize', updateMargin);

    $('.preview-sub img').click(function() {
      var e = $(this).attr('data-embed');
      var r = $(this).attr('data-src');
      if ($('.preview-top').find('img').length) {
        $('.preview-top img').attr('src', r);
        $('.preview-top img').attr('data-src', e);
      } else {
        $('.preview-top iframe').attr('src', 'https://www.youtube.com/embed/' + e);
      }
    });
    $(function() {
      $('#info_div').load('/info/index.php');
      $('.tbl_price_deli.loading').load("../getdate_disp2023", function(data) {
        $('.tbl_price_deli.loading').replaceWith(data);
        $('.tbl_price_deli').removeClass("loading");
      });


    });
    /* <![CDATA[ */
    var google_conversion_id = 1036353231;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
    var tmp = "<?= $_GET['mode'] ?>";
    $(function() {
      var t = $("#i_txt1"),
        s = $("#i_txt2");
      screen.width <= 768 && (t.attr("src", "images/keyh_txt_n1.svg"), s.attr("src", "images/text_sample_n1.svg"))
    }, getPartData($('input[name="part"]:checked').val()), (tmp != "" ? valid_chk_btn('step3') : ""));
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "ラバーキーホルダー"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });
    $("input[name='paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    });

    $.ajax({
      type: "POST",
      url: "../get_sample_date.php",
      data: {
        'days': '7',
        'format_cal': '12',
      },
      success: function(data) {
        // console.log(data);
        $('.speed_deli_date').html(formatDate(data[1]) + "<br/><div class='ut_date'>7日</diV>");
        $('.speed_deli_date2').html(formatDate(data[2]) + "<br/><div class='ut_date'>13日</diV>");
        productionDate3(data.sort());
      },
      dataType: "json"
    });

    $.ajax({
      type: "POST",
      url: "../get_sample_date.php",
      success: function(data) {
        // console.log(data);
        productionDate2(data.sort());
      },
      dataType: "json"
    });
  </script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".tbl_s").on("click scroll", function() {
        $(this).find(".scroll-center").hide();
      });
    });
  </script>
  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
  <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
    </div>
  </noscript>
  
    <script type="application/ld+json">
        [
            <?php echo $json_ld_output; ?>, {
                "@context": "https://schema.org",
                "@type": "BreadcrumbList",
                "itemListElement": [{
                        "@type": "ListItem",
                        "position": 1,
                        "name": "ホーム",
                        "item": "https://hotmobily.jp/"
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": "Products",
                        "item": "https://hotmobily.jp/products"
                    },
                    {
                        "@type": "ListItem",
                        "position": 3,
                        "name": "ラバーキーホルダー",
                        "item": "https://hotmobily.jp/products/rubberkeyholder/"
                    }
                ]
            }
        ]
    </script>
    <!-- /.google script -->
</body>

</html>
