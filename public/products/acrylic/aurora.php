<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
error_reporting(E_ALL ^ E_NOTICE);
//Read Modules
require_once('../../control/Control_Rubber.php');
include_once('../../common/Const.php');
include_once('../../common/SetUpLang.php');
include("../../connect_db/Control_Connect.php");

include_once('../const_js.php');
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


// echo "<pre>";
// print_r ($_SESSION);
// echo "</pre>";

$data1 = mysqli_query($conn, "SELECT COUNT(id) AS totalreview FROM reviews_hm") or die(mysqli_error());
$info1 = mysqli_fetch_assoc($data1);

$data2 = mysqli_query($conn, "SELECT AVG(service) AS avg_service, AVG(product) AS avg_product FROM reviews_hm") or die(mysqli_error());
$info2 = mysqli_fetch_assoc($data2);

$japanNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Tokyo'));
$planDisableStart = new DateTimeImmutable('2026-08-13 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisableEnd = new DateTimeImmutable('2026-08-17 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisabled = ($japanNow >= $planDisableStart && $japanNow < $planDisableEnd) ? 'disabled' : '';

// 1. Define or retrieve your dynamic product variables here
// *************************************************************
// REPLACE these placeholder values with your actual PHP variables
// that hold the product data from your database or CMS.
// *************************************************************
$product_name = "【ホットモバイリー】オリジナルオーロラアクリルキーホルダー（オーロラアクキー）";
$product_description = "オリジナルオーロラアクリルキーホルダー（オーロラアクキー）をオーダーメイドで製作。最短6営業日で出荷可能。小ロット1個から製作できます。最安188円。特別感あふれる加工で記念品に最適";
$product_image_url = "https://hotmobily.jp/products/images/aurora-41.webp";
$product_sku = "HM-AAK-2025";
$product_price = 188;
$product_currency = "JPY";
$product_availability = "InStock";
$product_url = "https://hotmobily.jp/products/acrylic/aurora.php";

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
  <meta name="robots" content="index,follow">
  <meta name="keywords" content="<?= lang('アクリル,キーホルダー,オリジナル,名入れ,製作,作成,アクキー,剥がれない,1個から') ?>">
  <meta name="description" content="<?= lang('オリジナルのアクリルキーホルダーが1個から注文可。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現') ?>">
  <title><?= lang('光の角度で色が変わる！オーロラアクリルキーホルダー（オーロラアクキー）') ?></title>
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <?php include('../../head_products.html'); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <link href="/products/css/product_group.css?v=1.11" rel="stylesheet" type="text/css" />
  <link href="css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.10" rel="stylesheet" type="text/css">
  <link href="/products/css/calendar.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="ptw/photoswipe.css">
  <link rel="stylesheet" href="ptw/default-skin.css">
  <link href="/products/acrylic/css/hand-scroll.css?v=1.00" rel="stylesheet" type="text/css">
  <link href="/css/modal.css" rel="stylesheet" type="text/css" />
  <script>
    function gtag_report_conversion(url) {
      var callback = function() {
        if (typeof(url) != 'undefined') {
          window.location = url;
        }
      };
      gtag('event', 'conversion', {
        'send_to': 'AW-1036353231/IGnMCK-CuAEQz_2V7gM',
        'event_callback': callback
      });
      return false;
    }
  </script>
  <style type="text/css">
    .row {
      justify-content: flex-start
    }

    .new-text {
      font-size: 16px !important;
      letter-spacing: 0.05em !important;
      line-height: 150% !important;
    }

    .mt-10-part {
      min-width: 23%;
      max-width: 23%
    }

    .mt-10-part div {
      text-align: center
    }

    .row .mt-10-part {
      min-width: 33%;
      max-width: 33%;
      text-align: center
    }

    .camera-left {
      width: 90%;
      text-align: left !important
    }

    .exc_pro1 {
      position: relative;
      overflow: hidden;
      padding-bottom: 110px;
      max-height: 230px
    }

    .exc_pro {
      max-height: 325px
    }

    .read-more1 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      text-align: center;
      margin: 0;
      padding: 10px 0 2px;
      background: #fff;
      z-index: 1
    }

    .tag-menu {
      font-weight: 700
    }

    .tag-name {
      font-weight: 400
    }

    .download_templete .modal-content.data {
      width: 30%
    }

    .data .btn-a.btn-yellow,
    .btn-a.btn-orange {
      width: 80%
    }

    .data .table_rubber td:nth-child(odd) {
      background: #fff
    }

    .prodate {
      padding: 0 5px;
      text-align: center;
      font-weight: 700;
      background: linear-gradient(to bottom, #d66f21 10%, #ea8335 35%, #f58e41 100%);
      border-radius: 5px;
      color: #fff;
      font-size: 16px;
      font-family: 'Noto Sans JP', sans-serif;
      width: 87%;
      margin: auto
    }

    .exc_pro1 .swiper-slide {
      margin-bottom: 12px
    }

    swiper-container {
      width: 100%;
      height: auto;
      /* Reset the height */
      overflow: hidden;
    }

    swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: auto;
    }

    swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    swiper-container {
      margin-left: auto;
      margin-right: auto;
    }

    :root {
      --swiper-theme-color: #f58904 !important;
      --swiper-pagination-bullet-width: 20px !important;
      --swiper-pagination-bullet-height: 20px !important;
      --pdp-v2-accent: #ff477e;
      --pdp-v2-slide-speed: 0.6s;
    }

    .pdp-v2-gallery-wrapper {
      width: 100%;
      max-width: 500px;
      background: #fff;
      position: relative;
    }

    .pdp-v2-main-viewport {
      width: 100%;
      overflow: hidden;
      /* Hides images outside the frame */
      position: relative;
      background-color: #fcfcfc;
    }

    .pdp-v2-main-link {
      min-width: 100%;
      display: block;
      cursor: pointer;
      position: relative;
      /* Important for positioning the icon */
    }

    .pdp-v2-image-strip {
      display: flex;
      width: 100%;
      /* Sliding animation */
      transition: transform var(--pdp-v2-slide-speed) cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pdp-v2-slide-img {
      min-width: 100%;
      height: auto;
      /* Image defines the height naturally */
      display: block;
    }

    /* --- ZOOM ICON STYLES --- */
    .pdp-v2-zoom-icon {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 64px;
      height: 64px;
      background-color: rgba(0, 0, 0, 0.4);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
      z-index: 2;
    }

    .pdp-v2-zoom-icon svg {
      width: 32px;
      height: 32px;
      color: white;
    }

    .pdp-v2-main-link:hover .pdp-v2-zoom-icon {
      opacity: 1;
    }

    .pdp-v2-thumb-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      /* 2 per row */
      gap: 8px;
      /* padding: 10px 0; */
      /* Vertical padding only, moved up to touch top */
      background: #fff;
    }

    .pdp-v2-thumb-item {
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
      object-fit: cover;
      border: 2px solid #f0f0f0;
      transition: all 0.3s ease;
      opacity: 0.6;
    }

    .pdp-v2-thumb-item.pdp-v2-active-state {
      border-color: var(--pdp-v2-accent);
      opacity: 1;
      transform: scale(0.98);
    }

    .pdp-v2-main-link {
      min-width: 100%;
      display: block;
      cursor: pointer;
      /* Added pointer cursor */
    }

    .pdp-v2-main-link::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
      opacity: 0;
      /* Hidden by default */
      transition: opacity 0.3s ease;
      pointer-events: none;
      /* Allows clicks to pass through to the container */
      z-index: 1;
      /* Sit above image, below zoom icon */
    }

    .pdp-v2-main-link:hover::after {
      opacity: 1;
    }

    .pdp-v2-slide-img {
      width: 100%;
      height: auto;
      display: block;
    }

    /* --- MODAL POPUP STYLES --- */
    .pdp-v2-modal-overlay {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.9);
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity var(--pdp-v2-fade-speed) ease-in-out;
    }

    /* Class added by JS to show modal */
    .pdp-v2-modal-overlay.active {
      display: flex;
      opacity: 1;
    }

    .pdp-v2-modal-container {
      position: relative;
      max-width: 90%;
      max-height: 90vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .pdp-v2-modal-content {
      display: block;
      width: 100%;
      height: auto;
      max-height: 90vh;
      object-fit: contain;
      box-shadow: 0 5px 30px rgba(0, 0, 0, 0.5);
      /* This property handles the slow fade effect */
      transition: opacity var(--pdp-v2-fade-speed) ease-in-out;
      opacity: 1;
    }

    .pdp-v2-modal-overlay.active .pdp-v2-modal-content {
      transform: scale(1);
    }

    .pdp-v2-modal-close {
      position: absolute;
      bottom: -40px;
      right: 0;
      /* Position relative to the container */
      color: #f1f1f1;
      font-size: 40px;
      font-weight: bold;
      cursor: pointer;
      line-height: 1;
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
      transition: all 0.3s ease;
      filter: drop-shadow(0px 0px 8px rgba(0, 0, 0, 1));
    }

    .pdp-v2-modal-next svg {
      width: 100%;
      height: 100%;
      stroke-width: 1.5;
    }

    .pdp-v2-modal-overlay:hover .pdp-v2-modal-next {
      opacity: 0.8;
    }

    .pdp-v2-modal-next:hover {
      opacity: 1;
      transform: translateY(-50%) scale(1.1);
    }

    #pc-gall-show {
      display: block;
    }

    #mb-gall-show {
      display: none;
    }

    @media(max-width: 768px) {
      .download_templete .modal-content.data {
        width: 90%
      }

      .pdp-v2-thumb-grid {
        grid-template-columns: repeat(2, 1fr);
        /* 2 per row */
      }

      .custom-split-details {
        padding: 0;
      }

      #pc-gall-show {
        display: none;
      }

      #mb-gall-show {
        display: block;
      }
    }

    @media (max-width: 576px) {
      .exc_pro1 {
        padding-bottom: 0
      }

      input[name="qty"] {
        width: calc(100% - 200px)
      }

      #label-qty {
        justify-content: space-between
      }

      .prodate {
        width: 90%;
        margin: 0;
        font-size: 13px;
        font-weight: 500
      }

      .exc_pro1 .swiper-slide {
        margin-bottom: 0
      }

      .flex-container.btn-container div.flex-item {
        width: 100% !important;
      }

      .pdp-v2-modal-next {
        right: 5px;
        width: 35px;
        height: 35px;
      }

      .pdp-v2-modal-close {
        bottom: -45px;
      }

      .pdp-v2-thumb-grid {
        grid-template-columns: repeat(2, 1fr);
        /* 2 per row */
      }

      /* .pdp-v2-gallery-wrapper { padding: 0 10px; }
        .pdp-v2-modal-close { top: 10px; right: 20px; }
        .pdp-v2-modal-next { right: 10px; width: 40px; }  */

      .button-order {
        margin-top: 20px;
      }

      .custom-split-details {
        padding: 0;
      }

      swiper-slide img {
        max-width: 100%;
      }

      #pc-gall-show {
        display: none;
      }

      #mb-gall-show {
        display: block;
      }
    }

    a.tag-name {
      padding: 2px 5px;
      background: #f7b516;
      display: inline-block;
      margin: 5px;
      border: 1px solid #f58904;
      color: #fff;
      margin-left: 0;
      text-decoration: none;
      border-radius: 5px
    }

    a.tag-name.active,
    a.tag-name:hover {
      background: #fff;
      color: #f58904
    }

    .selected-tag {
      display: block;
      animation: fade-in 1s
    }

    .unselect-tag {
      display: none;
      animation: fade-out 1s
    }

    .pc-show {
      display: block;
    }

    .mobile-show {
      display: none;
    }

    #A,
    #C,
    #D {
      position: relative;
    }

    #C .PC-C-Contents,
    .Mb-A-Contents,
    #B {
      filter: blur(10px);
      opacity: 0;
      transition: filter 0.5s ease-out, opacity 0.5s ease-out;
    }


    @keyframes fade-in {
      from {
        opacity: 0
      }

      to {
        opacity: 1
      }
    }

    @keyframes fade-out {
      from {
        opacity: 1
      }

      to {
        opacity: 0
      }
    }

    .sign {
      font-size: 35px
    }

    #date_create4 {
      font-size: 22px;
      font-weight: bold;
      color: red;
      letter-spacing: -1px;
      overflow: hidden;
    }

    .flex-container.btn-container div.flex-item {
      width: 30%;
    }

    #step3 .flex-container.btn-container div.flex-item .ord-btn {
      width: 100%;
    }

    .flex-container.btn-container {
      align-items: flex-start;
    }

    .btn-success {
      background: #00a300;
    }


    .repeat input[type="text"] {
      padding: 5px 10px;
      margin-left: -32px;
      width: -webkit-fill-available;
    }

    @media screen and (max-width: 768px) {
      .mobile-show {
        display: block;
      }

      .pc-show {
        display: none;
      }

      #A {
        margin-top: 0px;
        display: block;
        opacity: 1;
      }

      #D .Mb-D-Contents,
      .Mb-A-Contents,
      #B {
        filter: blur(10px);
        opacity: 0;
        transition: filter 0.5s ease-out, opacity 0.5s ease-out;
      }
    }

    #content_wrapper>h2.feature1,
    #content_wrapper>h2.feature2,
    #content_wrapper>h2.feature3,
    #content_wrapper>h2.feature4 {
      border: unset;
      padding-left: 61px;
      font-family: IwaUDGoDspPro-Th, sans-serif !important;
      text-align: left;
      color: #281600 !important;
      display: block;
      font-size: 21px !important;
    }

    #content_wrapper>h2.feature1 {
      background: transparent url(/products/images/wappen/feature-wappen-01.webp) no-repeat !important;
      background-size: 50px 50px !important;
      background-position: 0px center !important;
    }

    #content_wrapper>h2.feature2 {
      background: transparent url(/products/images/wappen/feature-wappen-02.webp) no-repeat !important;
      background-size: 50px 50px !important;
      background-position: 0px center !important;
    }

    #content_wrapper>h2.feature3 {
      background: transparent url(/products/images/wappen/feature-wappen-03.webp) no-repeat !important;
      background-size: 50px 50px !important;
      background-position: 0px center !important;
    }

    <?= ($_SESSION['lang'] == "kr" ? 'body{font-family: "돋움체",DotumChe,serif!important;}#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}.prodate,.q-detail,.tab-label{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body{font-family: "Prompt", sans-serif!important;}#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}.prodate,.q-detail,.tab-label{font-family: "Prompt", sans-serif!important;}' : '') ?>
  </style>
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

        // if (window.innerWidth < 768) {
        //   // ===== MOBILE =====

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

        // } else {
        //   // ===== DESKTOP =====

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
        // }

      });
    })();
  </script>
</head>

<body id="top">
  <!-- :: header start :: -->
  <?php include('../../header.html'); ?>
  <!-- :: header end :: -->

  <!-- globalNavi -->
  <?php include('../../gnavi.php'); ?>
  <!-- globalNavi End -->

  <!-- :: wrapper start :: -->
  <div id="wrapper">

    <!-- sidemenu-->
    <?php include('../../sidenavi.php'); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
      <?php include('../../global_news.html'); ?>
      <?php include("acrylic_info.php"); ?>
      <?php include('../banner-campaign.php') ?>

      <div id="" class="">
        <h1 class=""><?= lang('光の角度で色が変わる！オーロラアクリルキーホルダー（オーロラアクキー）') ?></h1>
        <div class="social-time ">
          <span class="social-content">
            <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0A光の角度で色が変わる！オーロラアクリルキーホルダー（オーロラアクキー）剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/aurora.php" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a><a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0A光の角度で色が変わる！オーロラアクリルキーホルダー（オーロラアクキー）剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/aurora.php" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
            <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2faurora.php" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2faurora.php&amp;text=光の角度で色が変わる！オーロラアクリルキーホルダー（オーロラアクキー）剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現" target="_blank"><i class="fab fa-twitter-square"></i></a>
          </span>
          <span class="time-content">更新日 2026年8月3日</span>
        </div>
      </div>

      <div id="">
        <img src="/products/images/banner_aurora.webp" alt="オリジナルアクリルキーホルダー(アクキー)の製作。1個から注文可。保護フィルムで、印刷が剥がれません(2024年版)" width="771" height="390" />
      </div>

      <div>&nbsp;</div>

      <div class="" id="">
        <div class="flex-container">

            <div class="flex-item item new-text">
                <div class="pdp-v2-gallery-wrapper">
                <div class="pdp-v2-main-viewport">
                    <div class="pdp-v2-image-strip" id="pdp-v2-js-strip">
                    </div>
                </div>

                <div class="pdp-v2-thumb-grid only-mobile" id="pdp-v2-js-grid-mb">
                </div>

                </div>
            </div>
            
          <!-- <div class="flex-item item">
            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
                <swiper-slide><img src="/products/images/aurora_v2_01.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img src="/products/images/aurora_v2_02.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img src="/products/images/new_arurora_rainbow_-01.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img src="/products/images/new_arurora_rainbow_-02.webp?dd=<?php echo date('is') ?>"></swiper-slide>
            </swiper-container>
          </div> -->
          <div class="flex-item item new-text" style="display:grid;align-content: center;line-height: 2;">
            <h2 style="margin-top: 0px;"><?= lang('お客様のオリジナルデザインで、オーロラアクキーをご制作！') ?></h2><br>
            <p class="new-text">
                光の角度で色が変化するオーロラアクリルを、あなたのデザインでご製作！ブルーやオレンジに色が変化するブルーベース加工、ピンクやグリーンに変化するピンクベース加工の2種類があります。<br><br>
                大ロットなら1個188円（税込）からの激安価格！さらに1個だけのご注文も可能です！<br><br>
                オリジナルのキャラクターやロゴ、思い出の写真などが、光によって表情を変える印象的なアクキーに。同人グッズや社名入りノベルティなど幅広くご利用頂けます。<br><br>
            </p>
          </div>

            <div class="flex only-pc">
                <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                </div>
            </div>

          <div class="flex-item item">
            <!-- <div class="preview-container">
                    <div class="preview-top my-gallery">
                    <div id="box-show-id-1">
                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                        <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                            <img class="zoom-img" id="zoom_01" src="/products/images/aurora-20.webp" data-zoom-image="/products/images/aurora_1365 × 840-01.webp" width="376" height="231" itemprop="thumbnail">
                        </a>
                        </figure>
                    </div>
                    <div id="box-show-id-2">
                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                        <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                            <img class="zoom-img" id="zoom_02" src="/products/images/aurora-12.webp" data-zoom-image="/products/images/aurora_1365 × 840-02.webp" width="376" height="231" itemprop="thumbnail">
                        </a>
                        </figure>
                    </div>
                    <div id="box-show-id-3">
                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                        <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                            <img class="zoom-img" id="zoom_03" src="/products/images/aurora-32.webp" data-zoom-image="/products/images/aurora_1365 × 840-03.webp" width="376" height="231" itemprop="thumbnail">
                        </a>
                        </figure>
                    </div>
                    <div id="box-show-id-4">
                        <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                        <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                            <img class="zoom-img" id="zoom_04" src="/products/images/aurora-30.webp" data-zoom-image="/products/images/aurora_1365 × 840-04.webp" width="376" height="231" itemprop="thumbnail">
                        </a>
                        </figure>
                    </div>
                    </div>
                    <div class="preview-sub flex-container">
                    <div class="flex-item"><img src="/products/images/aurora-20.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();">
                    </div>
                    <div class="flex-item"><img src="/products/images/aurora-12.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();">
                    </div>
                    <div class="flex-item"><img src="/products/images/aurora-32.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();">
                    </div>
                    <div class="flex-item"><img src="/products/images/aurora-30.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();">
                    </div>
                    </div>
                </div> -->
            <!-- <div style="font-size: 12px;" class="camera-preview">📷<?= lang('大きな画像にマウスを合わせると拡大されます') ?></div> -->
            <!-- <div class="ptw-container"></div> -->
          </div>

          <!-- <div class="flex-item item">
                <h2 style="margin-top: 0px;"><?= lang('お客様のオリジナルデザインで、オーロラアクキーをご制作！') ?></h2>
                <p class="new-text">
                    光の当たる角度によって、青やピンク、イエローなど色が変化するオーロラアクリルを、あなたのデザインでご制作いたします。<br><br>
                    大ロットなら1個○○円（税込）からの激安価格で製作可能！さらに、1個だけのご注文も可能です！<br><br>
                    オリジナルのキャラクターやロゴ、思い出の写真などが、光によって表情を変える印象的なアクキーに！<br><br>
                    同人グッズや企業名入れノベルティなど、幅広い用途でご利用頂けます。<br><br>
                </p>
            </div> -->
        </div>
      </div>

      <h2><?= lang('オーロラアクリルキーホルダー（オーロラアクキー）の特徴') ?></h2>
      <p class="new-text">オーロラアクリルキーホルダー（オーロラアクキー）には、一般的なアクリルキーホルダーとは異なる次のような特徴があります。</p>
      <h2 class="feature1 new-text">まるでアート！幻想的なオーロラ加工！</h2>
      <p style="padding-top: 10px!important;" class="new-text">見る角度によって、ブルー・オレンジ・イエローなど、まるでオーロラのように色が移ろう——。当店のオーロラアクリルキーホルダー（オーロラアクキー）は、光の反射を考慮して施された特別なオーロラ加工が魅力です。光を受けるたびに表情を変えるその輝きは、まるでアート作品のよう。手に取る角度や撮影する環境によって印象が変わるため、飽きることなくずっと眺めていたくなる美しさを演出します。</p>
      <h2 class="feature2 new-text">写真映え・SNS映え抜群！思わずシェアしたくなる輝き</h2>
      <p style="padding-top: 10px!important;" class="new-text">オーロラのような輝きが、写真や動画に魔法のような彩りを添えます。撮るたびに異なる表情を見せてくれるから、SNSにアップした瞬間に「かわいい！」「どこで作ったの？」と話題になること間違いなし。ファンアイテムやイベント記念品、アイドルやキャラクターグッズにもぴったりな映えるキーホルダーです。</p>
      <h2 class="feature3 new-text">限定品・記念品に最適な、特別感のある仕上がり</h2>
      <p style="padding-top: 10px!important;" class="new-text">オーロラアクリルキーホルダー（オーロラアクキー）は、その輝き自体が“特別感”を演出します。条件によって色が変化するため、まるで動いているかのような動きを感じさせ、他のアクリルグッズにはない高級感と存在感を放ちます。記念イベントや周年グッズ、数量限定のアイテムとしても人気が高く、贈る人にも手にする人にも印象に残る仕上がりです。デザインの美しさを引き立てながら、“限定品らしさ”をしっかり伝えられる、それが当店のオーロラアクリルキーホルダー（オーロラアクキー）です。</p>
      <hr>
      <div style="clear: both;"></div>

      <h2><?= lang('ブルーベース加工・ピンクベース加工の2種類をご用意！') ?></h2>
      <div class="new-text">
        <p>オーロラアクリルキーホルダー（オーロラアクキー）は、ブルーベース加工とピンクベース加工の2種類があります。どちらも光の角度や背景によって色が変化する仕様ですが、色の変化のパターンが異なります。</p>
        <br>
        <p>下の写真の、女性キャラのデザインのものがブルーベース加工、ユニコーンのデザインのものがピンクベース加工です。</p>
        <br>

        <div class="flex-item item" style="max-width: 100%;">
            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
                <swiper-slide><img src="/products/images/blue_pink_aurora.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img src="/products/images/orange_green_aurora.webp?dd=<?php echo date('is') ?>"></swiper-slide>
            </swiper-container>
        </div>

        <br>
        <p>どちらをお選び頂いても価格は変わりません。注文フォームでご注文の際に、お好みの方をお選びください。</p>

      </div>


      <h2><?= lang('オリジナルアクリルキーホルダー製作事例') ?></h2>
      <div class="ex-row">
        <div class="swiper-button-prev"></div>
        <div class="swiper-container swiper2">
          <div class="swiper-wrapper swiper-bt">

            <div class="swiper-slide">
              <div class="prodate">水色の髪の女性キャラ</div>
              <a href="/products/images/aurora-43.webp" data-lightbox="acrylic_swiper15" style="text-decoration:none;" data-title="">
                <img src="/products/images/aurora-43.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/aurora-44.webp" data-lightbox="acrylic_swiper15" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">オレンジの髪の女性キャラ</div>
              <a href="/products/images/aurora-41.webp" data-lightbox="acrylic_swiper16" style="text-decoration:none;" data-title="">
                <img src="/products/images/aurora-41.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/aurora-42.webp" data-lightbox="acrylic_swiper16" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">ピンクの髪の女性キャラ</div>
              <a href="/products/images/aurora-45.webp" data-lightbox="acrylic_swiper1" style="text-decoration:none;" data-title="">
                <img src="/products/images/aurora-45.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/aurora-46.webp" data-lightbox="acrylic_swiper1" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">2匹の猫</div>
              <a href="/products/images/aurora_cat01.webp" data-lightbox="acrylic_swiper17" style="text-decoration:none;" data-title="">
                <img src="/products/images/aurora_cat01.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/aurora_cat02.webp" data-lightbox="acrylic_swiper17" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">クリスマスデザイン</div>
              <a href="/products/images/aurora_christmas01.webp" data-lightbox="acrylic_swiper18" style="text-decoration:none;" data-title="">
                <img src="/products/images/aurora_christmas01.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/aurora_christmas02.webp" data-lightbox="acrylic_swiper18" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">悪魔の女の子</div>
              <a href="/products/images/aurora_demongirl01.webp" data-lightbox="acrylic_swiper19" style="text-decoration:none;" data-title="">
                <img src="/products/images/aurora_demongirl01.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/aurora_demongirl02.webp" data-lightbox="acrylic_swiper19" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">ユニコーン</div>
              <a href="/products/images/arurora_07_01.webp" data-lightbox="acrylic_swiper21" style="text-decoration:none;" data-title="">
                <img src="/products/images/arurora_07_01.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/arurora_07_02.webp" data-lightbox="acrylic_swiper21" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">女性の写真</div>
              <a href="/products/images/arurora_08_01.webp" data-lightbox="acrylic_swiper22" style="text-decoration:none;" data-title="">
                <img src="/products/images/arurora_08_01.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/arurora_08_02.webp" data-lightbox="acrylic_swiper22" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">ミニキャラたち</div>
              <a href="/products/images/arurora_09_01.webp" data-lightbox="acrylic_swiper23" style="text-decoration:none;" data-title="">
                <img src="/products/images/arurora_09_01.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/arurora_09_02.webp" data-lightbox="acrylic_swiper23" data-title=""></a>
            </div>

          </div>
        </div>
        <div class="swiper-button-next"></div>
        <!-- <div style="text-align: center; margin: 15px auto 0;">
          <a href="/gallery/acrylic_key"><img class="btn_z" src="/products/images/but3-02.webp" width="266" height="40"></a>
        </div> -->
      </div>
      <div style="clear: both;"></div>

      <h2><?= lang('光を反射して虹色に！') ?></h2>
      <div>
        <div class="videoWrapper">
          <!-- <img src="/products/images/banner_default.jpg" data-src="LQNZDWC28Zw" class="iframe" width="770" height="434"> -->
          <iframe width="560" height="315" src="https://www.youtube.com/embed/Ll7sTjjjBiE?si=-sZR8UUjJe1JhZjF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          <!-- <div class="playbtn"> -->
          <!-- <div class="tri"></div> -->
          <!-- </div> -->
        </div>
        <div>
          <br>
          <p class="new-text">オーロラアクリルキーホルダー（オーロラアクキー）は、光の角度によってブルーやピンク、イエローなど、まるでオーロラのように色が変わるオーロラアクリルキーホルダー（オーロラアクキー）です。</p><br>
          <p class="new-text">オリジナルのキャラクターやロゴ、イラストや写真などに、さらにインパクトをプラスしたアクリルキーホルダーを制作可能！一般的なアクリルキーホルダーとはひと味違った仕上がりが、見る人の視線を奪います。記念品や販促グッズ、イベントグッズなど、特別なアイテムにも最適です！</p>
        </div>
      </div>


      <div style="clear: both;"></div>
      <?php include("four_reason-v2.php") ?>

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

      <!-- <div class="flex-container" id="btn-group">
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
              <span><?= lang('テンプレート') ?></span>
            </a>
            <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
              <span><?= lang('入稿データ作成') ?></span>
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/howtoorder/acrylic" target="_blank">
              <span><?= lang('ご注文の流れ') ?></span>
            </a>
            <a class="btn-a btn-yellow" href="/contact/?item=アクリルキーホルダー">
              <span><?= lang('無料サンプル') ?></span>
            </a>
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
      <a class="new-text" href="/contact/?item=オーロラアクリルキーホルダー" >無料サンプルの送付をリクエスト</a>

      <div id="download_templete" class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3><?= lang('アクリルキーホルダー') ?>【Illustrator／Photoshop】</h3>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>50×50mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_50mm_20250320.ai">
                    <div><img class="lazy" data-src="img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_50mm_20250320.psd">
                    <div><img class="lazy" data-src="img/psd-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>75×75mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_75mm_20250320.ai">
                    <div><img class="lazy" data-src="img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_75mm_20250320.psd">
                    <div><img class="lazy" data-src="img/psd-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>100×100mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_100mm_20250320.ai">
                    <div><img class="lazy" data-src="img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_100mm_20250320.psd">
                    <div><img class="lazy" data-src="img/psd-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
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
                  <a class="btn-a btn-yellow" href="/products/data-acrylic.php" target="_blank">
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
        
      <h2>入稿データ作成について</h2>
      <br>
      <p class="new-text">アクリル製品の製作に必要不可欠なカットパス・白押さえの作成（データ作成補助）を無料で承っております。お気軽にご利用ください。</p>
      <br>
      <a href="/products/acrylic/cutline_white" target="_blank">
        <img src="img/Banner_Acrylc_Pink.webp" width="770" height="194" />
      </a>
      <br>
      <br>
      <p class="new-text">なお、「カットパス・白押さえも自分で細かく設定したい」という方向けに、入稿データ作成のテンプレート及びアクリル製品の入稿データ作成ガイドもご用意しております。</p>
      <br>

      <a class="new-text" href="/products/acrylic/template/template-aurora-acrylic.zip" download>入稿データテンプレートをダウンロード</a>
      <br>
      <br>
      <a class="new-text" href="/products/data-acrylic.php">入稿データ作成ガイド</a>

      <h2>印刷を守る保護フィルム付き！</h2>
      <br>
      <img class="lazy" data-src="img/acrylic-protection-cnc-02.webp" width="770" height="388" loading="lazy">
      <br><br>
      <p class="new-text">当店アクリルグッズは、印刷を守る保護フィルム付き。コインで削っても印刷が剥がれません。さらに、カット面のエッジには滑らかな触り心地のCNC加工を採用しています。</p>
      <br>

       <?php $page = 'product';  include('../../campaign_2021.php'); ?>



      <div id="attachments" style="clear: both;"></div>
      <div class="videoWrapper">
        <img src="img/ak-yt.webp" data-src="pnKcyfuh4Rw" class="iframe" width="770" height="434">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <hr />
      <h2><?= lang('アタッチメント') ?></h2>
      <p class="new-text"><?= lang('写真をクリックすると拡大写真と詳細説明を確認頂けます。') ?></p>
      <div class="exc_pro">
        <div class="swiper-container">
          <div class="row">
            <div class="mt-10-part">
              <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-5" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。">
                <img class="picpro lazy" data-src="/products/images/HM_part5.webp" width="229" height="229">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-5-1" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-6" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。">
                <img class="picpro lazy" data-src="/products/images/HM_part6.webp" width="229" height="229">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-6-1" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-7" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。">
                <img class="picpro lazy" data-src="/products/images/HM_part7.webp" width="229" height="229">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-7-1" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part14.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14-1" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-4" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。">
                <img class="picpro lazy" data-src="/products/images/HM_part4.webp" width="229" height="229">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-4-1" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-15" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm">
                <img class="picpro lazy" data-src="/products/images/HM_part15.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-15-1" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-18" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm">
                <img class="picpro lazy" data-src="/products/images/HM_part18.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-18-1" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-16" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm">
                <img class="picpro lazy" data-src="/products/images/HM_part16.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-16-1" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-19" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm">
                <img class="picpro lazy" data-src="/products/images/HM_part19.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-19-1" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-17" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm">
                <img class="picpro lazy" data-src="/products/images/HM_part17.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-17-1" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-20" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm">
                <img class="picpro lazy" data-src="/products/images/HM_part20.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-20-1" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-8" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。">
                <img class="picpro lazy" data-src="/products/images/HM_part8.webp" width="229" height="229">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-8-1" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro lazy" data-src="/products/images/HM_part1.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro lazy" data-src="/products/images/HM_part2.webp" width="229" height="229">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2-1" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro lazy" data-src="/products/images/HM_part3.webp" width="229" height="229">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3-1" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part9.webp" width="229" height="229">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9-1" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part10.webp" width="229" height="229">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10-1" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part11.webp" width="229" height="229">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11-1" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part12.webp" width="229" height="229">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12-1" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part13.webp" width="229" height="229">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13-1" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
                <a href="/products/images/Red_opener.webp" data-lightbox="img-part-set-91" data-title="<strong>【ボトルオープナー（赤色）】</strong>赤色のボトルオープナーです。">
                    <img class="picpro lazy" data-src="/products/images/Red_opener.webp" width="229" height="229">
                </a><br>
                <div>+55円</div>
                <a href="/products/images/Red_opener.webp" data-lightbox="img-part-set-91-1" data-title="<strong>【ボトルオープナー（赤色）】</strong>赤色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
                <a href="/products/images/Blue_opener.webp" data-lightbox="img-part-set-92" data-title="<strong>【ボトルオープナー（青色）】</strong>青色のボトルオープナーです。">
                    <img class="picpro lazy" data-src="/products/images/Blue_opener.webp" width="229" height="229">
                </a><br>
                <div>+55円</div>
                <a href="/products/images/Blue_opener.webp" data-lightbox="img-part-set-92-1" data-title="<strong>【ボトルオープナー（青色）】</strong>青色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
                <a href="/products/images/Purple_opener.webp" data-lightbox="img-part-set-93" data-title="<strong>【ボトルオープナー（紫色）】</strong>紫色のボトルオープナーです。">
                    <img class="picpro lazy" data-src="/products/images/Purple_opener.webp" width="229" height="229">
                </a><br>
                <div>+55円</div>
                <a href="/products/images/Purple_opener.webp" data-lightbox="img-part-set-93-1" data-title="<strong>【ボトルオープナー（紫色）】</strong>紫色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
                <a href="/products/images/Black_opener.webp" data-lightbox="img-part-set-94" data-title="<strong>【ボトルオープナー（黒色）】</strong>黒色のボトルオープナーです。">
                    <img class="picpro lazy" data-src="/products/images/Black_opener.webp" width="229" height="229">
                </a><br>
                <div>+55円</div>
                <a href="/products/images/Black_opener.webp" data-lightbox="img-part-set-94-1" data-title="<strong>【ボトルオープナー（黒色）】</strong>黒色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

          </div>
        </div>
        <div class="read-more1"><a href="#" class="btn"><img class="btn_z" src="/products/images/but3-03.webp" width="266" height="40"></a></div>
      </div>
      <hr />
      <h2 style="margin-top: 5px;"><?= lang('入稿データ作成方法') ?></h2>
      <a href="https://hotmobily.jp/products/data-acrylic.php" target="_blank"><img class="lazy" data-src="img/acrylic-data-guide.webp" width="770" height="388"></a>
      <?php include("../campaign_news.php"); ?>
      <hr />
      <h2><?= lang('代表的な本数での価格表') ?></h2>
      <p class="new-text"><?= lang('納期と印刷面を選択してください。サイズ別の製作単価表が表示されます。ここは価格表のみです。<a href="#est-content">見積・注文</a>はこちらです。') ?></p><br />
      <h3><?= lang('納期') ?></h3>
      <div class="part-container">
        <div class="part-content" style="display: flex;">
          <label class="part-name">
            <input type="radio" name="prc_delivery" value="10" checked="" onclick="writePriceTable('del');">10<?= lang('営業日') ?> <span class="checkmark"></span>
          </label>
          <label class="part-name">
            <input type="radio" name="prc_delivery" value="6" onclick="writePriceTable('del');">6<?= lang('営業日') ?>
            <span class="checkmark"></span>
          </label>
        </div>
      </div>

      <div style="display:none;">
        <h3><?= lang('印刷面') ?></h3>
        <div class="part-container">
          <div class="part-content" style="display: flex;">
            <label class="part-name"><input type="radio" name="prc_screen" value="1" checked="" onclick="writePriceTable();"><?= lang('片面印刷') ?> <span class="checkmark"></span></label>
            <label class="part-name"><input type="radio" name="prc_screen" value="2" onclick="writePriceTable();"><?= lang('両面印刷') ?> <span class="checkmark"></span></label>
          </div>
        </div>
      </div>

      <br />
      <h3><?= lang('数量・サイズ別価格表') ?></h3>
      <div class="fixed-thead">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table id="table-price" class="tbl-price tb-w12 blink" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;width: 99%;">
          <thead>
            <tr>
              <td></td>
              <td>50×50mm<?= lang('以内') ?></td>
              <td>75×75mm<?= lang('以内') ?></td>
              <td>100×100mm<?= lang('以内') ?></td>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※お買い上げ金額合計が11,000円（税込）未満の場合、別途送料880円（税込）がかかります。<br>
      </div>

      <br>
        <!-- <div>
            <a href="https://hotmobily.jp/campaign/christmas2025"><img src="/img/banner_christmas_v2.webp" alt="" width="771" height="auto"></a>
        </div> -->


      <h2 id="est-content"><?= lang('ご注文・見積書作成') ?></h2>
      <?php include('../campaign_banner.php') ?>
      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('オーロラアクリルキーホルダー（オーロラアクキー）') ?>】</h3>
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
                <td><span id="sample-prd-process"></span></td>
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
                <div class="step-number">1</div><span class="step-details"><?= lang('納期・サイズ・印刷面') ?></span>
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
            <input type="text" name="ItemType" id="strap" value="オーロラアクリルキーホルダー" />
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

            <h3>納期</h3>
            <div class="acy_delivery">
            <?php include('../../delivery_note.php'); ?>
              <?php include('../alert-btn.php') ?>
              <div class="part-container">
                <div class="part-content">
                  <label class="part-name"><input type="radio" name="acy_delivery" value="10営業日" onclick="check_val('next')" <?= $delivery_10 ?>>10<?= lang('営業日') ?><span class="checkmark"></span></label>
                </div>
                <div class="part-content ">
                  <label class="part-name" <?= $delivery_disabled ?>><input type="radio" name="acy_delivery" value="6営業日" onclick="check_val('next')" <?= $delivery_6 ?> <?= $planDisabled ?>>6<?= lang('営業日') ?> <span class="checkmark"></span></label>
                </div>
              </div>
              <h3 style="font-size: 13px;"><i style="color:red" class="fa fa-exclamation-circle" aria-hidden="true"></i>毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。
              </h3>
            </div>

            <h3><?= lang('サイズ') ?></h3>
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
            </div>

            <div style="clear: both;"></div><br>

            <h3><?= lang('加工タイプ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="shape_processing" value="ブルーベース加工" onclick="check_val('next')"> ブルーベース加工 <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="shape_processing" value="ピンクベース加工" onclick="check_val('next')" >ピンクベース加工 <span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_shape_processing"></span>
            </div>

            <div style="clear: both;"></div><br>

            <h3><?= lang('印刷面') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_screen" value="片面印刷" onclick="check_val('next')" <?= $screen1 ?>><?= lang('片面印刷') ?> <span class="checkmark"></span></label>
              </div>
              <!-- <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_screen" value="両面印刷" onclick="check_val('next')" <?= $screen2 ?>><?= lang('両面印刷') ?> <span class="checkmark"></span></label>
              </div> -->
            </div>
            <h3><?= lang('数量') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" onblur="check_val('next')" value="<?= $qty ?>"></label>
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
                    //include('part-event.php');
                    // if (date('Y-m-d') >= date('2025-11-01') && date('Y-m-d') <= date('2025-11-16')) {
                    //     include('part-event.php');
                    // } else {
                    include('part.php');
                    // }

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
                    <input type="checkbox" class="checkbox" name="acy_paper_select" value="あり" onclick="check_val('next')" <?= ($acy_paper_select != "なし" ? ($acy_paper_select != "" ? "checked" : "") : "") ?>>
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
                      <td class="" id="prd_processing" style="text-align: left;"></td>
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
                        <!-- <input type="button" class="btn ord-btn" value="すぐに購入" onclick="if(chk_part()){comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form);}"> -->
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
        <div id="cus_detail" style="display:none;" align="center">
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');" value="御社情報確定（PDF出力）">
                  <div class="remark">&nbsp;※<?= lang('社名や会社名の入力は任意です') ?></div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <h2 style="margin-top: 5px;"><?= lang('製品仕様・付属品等') ?></h2>

      <table class="table_rubber" style="padding: 0 ;">
        <tr>
          <td class="TableLeft"><?= lang('名称') ?></td>
          <td class=""><?= lang('オーロラアクリルキーホルダー（オーロラアクキー）') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('素材') ?></td>
          <td class=""><?= lang('アクリル板3mm厚') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('サイズ') ?></td>
          <td class="">50X50mm / 75X75mm / 100X100mm </td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('色数') ?></td>
          <td class=""><?= lang('フルカラーUVインクジェット印刷+白押さえが基本となります。<br/>片面印刷：UV印刷+白押さえ') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('アタッチメント') ?></td>
          <td class=""><?= lang('ボールチェーン、キーリング等') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('最小ロット') ?></td>
          <td class="">1<?= lang('個') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('包装') ?></td>
          <td class=""><?= lang('個別OPP包装') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('台紙') ?></td>
          <td class="">
            <?= lang('既製品：50種類のデータから選択可<br/>オリジナル印刷：お客様の入稿データを使用し、印刷します<br/>支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。') ?>
          </td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('特徴') ?></td>
          <td class=""><?= lang('印刷面をフィルム保護。オーロラ加工。CNCカット。') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('納期') ?></td>
          <td class="">6<?= lang('営業日') ?>/10<?= lang('営業日') ?></td>
        </tr>
      </table>
      <!-- <hr /> -->
      <!-- <h2 style="margin-top: 5px;"><?= lang('よくある質問') ?></h2>
      <div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('一度の注文で複数種類のデザインを注文できますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('はい、できます。') ?></span><a href="javascript:void(0)" onclick="$('#panel1').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel1" class="a-detail new-text">
            <?= lang('たとえば、2つのデザインを注文する場合は、まず片方のデザインの注文をカートに入れて頂き、その後「買い物を続ける」ボタンをクリックしてください。クリック後、アクリル製品一覧画面が表示されます。一覧画面で、2つめとして購入したいアクリル製品の欄を選んで頂き、注文画面から2つめのデザインのご注文をカートに入れてください。その後、カートに2つの注文が入っていることをご確認後「購入へ」ボタンをクリックし、ご購入のステップにお進みください。オモテ面のデザインは同じでウラ面のデザインだけが異なる場合も、別々のデザインとして2件のご注文をカートにお入れください。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('データ作成補助はどんな時に必要ですか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('アドビイラストレータもしくは、フォトショップ以外で作成されたデータでご注文の場合、原則必須となります。') ?></span><a href="javascript:void(0)" onclick="$('#panel2').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel2" class="a-detail new-text">
            <?= lang('アクリルキーホルダーを作成する際、デザインのデータ以外に、カットパスと白押さえのデータが必要となります。カットバスとは、どのようにアクリルキーホルダーをカットするかのデータです。白押さえとは、アクリルキーホルダーを印刷する際、白色部分は印刷されませんので、透明となります。一旦白色以外の部分を印刷した後、指定された部分のみ白色印刷を行います。カットパスと白押さえの詳細は、<a href="https://hotmobily.jp/products/data-acrylic.php">入稿データ作成</a>のページをご覧ください。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('注文したのですが、キャンセルしたいです。できますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('製作（量産）開始のご連絡前であれば可能です。') ?></span><a href="javascript:void(0)" onclick="$('#panel3').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel3" class="a-detail new-text">
            <?= lang('製品の製作を開始する際には、その旨をメールでご連絡させて頂きます。このメールが送信される前であれば、キャンセルは可能です。キャンセル費用はかかりません。既に製作料金のお振込みが完了している場合、ご返金させて頂きますが、ご返金に伴う振り込み手数料はお客様負担となります。また、製作料金よりも振り込み手数料の方が高い場合、ご返金はできません。製作開始後のキャンセルは一切できませんのでご了承ください。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('配送先を複数拠点に出来ますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('複数拠点に発送は可能です。') ?></span><a href="javascript:void(0)" onclick="$('#panel4').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel4" class="a-detail new-text"><?= lang('ただし、発送数量、発送住所をお伺いして別途配送手配代金を追加で頂戴する必要がございます。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('注文フォームから注文した内容を変更できますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('注文内容の変更は可能ですが、案件の進行状況によっては対応は異なります。') ?></span><a href="javascript:void(0)" onclick="$('#panel5').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel5" class="a-detail new-text">
            <?= lang('弊社にてデザインを調整前（製作開始前）は、正しい注文内容にて再注文をお願いします。<br/>弊社にてデザインを調整後（製作開始後）は、デザインを変更できませんが、パーツは変更可能でございます。パーツ変更に伴い、追加料金が発生する場合、差額を再度ご入金頂く必要がございます。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('同じデザインですが、複数種のアタッチメントに変更したいです。手配は可能ですか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('手配可能です。') ?></span><a href="javascript:void(0)" onclick="$('#panel6').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel6" class="a-detail new-text"><?= lang('現在のご注文フォームからこのような注文はお受けできませんので、ご希望がございますお客様は直接営業担当までご相談ください。') ?>
          </div>
        </div>
        <div class="quest">Q</div>
        <div class="q-detail"><?= lang('納期について、6営業と10営業がありますが、営業日とは何ですか？また、配送時間はどれくらいですか？') ?></div>
        <div class="ans">A</div>
        <div class="q-detail"><span class="orange"><?= lang('営業日とは土日祝をカウントしない日数です。') ?></span><a href="javascript:void(0)" onclick="$('#panel7').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
        <div id="panel7" class="a-detail new-text"><?= lang('また、製品の配送には2日程度かかります。※離島を除く。') ?>
        </div>
      </div> -->

      <?php
      $favor = 'acrylic';
      if (isset($favor) && $favor == 'acrylic') {
        include '../product-faq-v2.php';
      }
      ?>

      <hr />
      <?php include('../acrylic-blog.php'); ?>

      <?php
      if (isset($favor) && $favor == 'acrylic') {
        include '../product-review-v2.php';
      }
      ?>
      
      <h2><?= lang('アクリルグッズ一覧') ?></h2>
      <br>
      <?php include('acrylic-items-lists.php') ?>


      <h2><?= lang('営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <a href="//hotmobily.jp/meeting_date/"><img class="lazy" data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82"></a>
      <div style="clear: both">&nbsp;</div>
      <img src="img/x-banner.webp">
      <div style="clear: both">&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">ネルゲル様のアクリルキーホルダー30個今日届きました😆✨素敵に作ってくれて感謝です💞仕上がり綺麗で予備も2つ入れてくれてました✨またぜひ次も何か作りたいです🩷<br>初めてのアクリルキーホルダーだから嬉しい💞<a href="https://twitter.com/hashtag/%E3%82%A2%E3%82%AF%E3%83%AA%E3%83%AB%E3%82%AD%E3%83%BC%E3%83%9B%E3%83%AB%E3%83%80%E3%83%BC?src=hash&amp;ref_src=twsrc%5Etfw">#アクリルキーホルダー</a><a href="https://twitter.com/hashtag/%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC?src=hash&amp;ref_src=twsrc%5Etfw">#ホットモバイリー</a> <a href="https://t.co/WBzy0ZOgGf">https://t.co/WBzy0ZOgGf</a> <a href="https://t.co/GZpmt5E37U">pic.twitter.com/GZpmt5E37U</a></p>&mdash; エトワール (@etowarlukarzas) <a href="https://twitter.com/etowarlukarzas/status/1738063253954232607?ref_src=twsrc%5Etfw">December 22, 2023</a>
          </blockquote>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="flex-item item">
          <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">PundaRock 🆕GOODS✨<br><br>ロゴアクリルキーホルダー！<br><br>1/8(月・祝)熊猫夜会<br>＠下北沢BREATH<br><br>より発売開始です！！<br><br>1個 1,000円<br><br>是非ともよろしくお願いします！<br><br>めちゃくちゃ可愛い!<br>そして仕上げが丁寧✨<a href="https://twitter.com/GoodsYe?ref_src=twsrc%5Etfw">@GoodsYe</a> 様ありがとうございます😆 <a href="https://t.co/4eFwlJDeUp">pic.twitter.com/4eFwlJDeUp</a></p>&mdash; 熊猫屋☆HiRΦ 🐼2024/1/8(月祝)下北沢BREATH,1/21(日)Giorno (@panda8hiro) <a href="https://twitter.com/panda8hiro/status/1743126711661903912?ref_src=twsrc%5Etfw">January 5, 2024</a>
          </blockquote>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="flex-item item">
          <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">参加者特典のプレゼントはホットモバイリー様(<a href="https://twitter.com/GoodsYe?ref_src=twsrc%5Etfw">@GoodsYe</a>)で製作させてもらいました。<br><br>最初から裏面に保護フィルム付きだし面取りしてくれて画像だけ投げたらパスも引いて貰えます。<br>仕上がりや対応もとても良かったのでまた次回も利用させて貰いたいです！！<a href="https://t.co/bLybMDI1gO">https://t.co/bLybMDI1gO</a> <a href="https://t.co/qjoCeoZSAI">pic.twitter.com/qjoCeoZSAI</a></p>&mdash; 朝倉工務店 (@askr_iktrik) <a href="https://twitter.com/askr_iktrik/status/1739937918456668377?ref_src=twsrc%5Etfw">December 27, 2023</a>
          </blockquote>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
      </div>
    </div>
    <!-- :: content_wrapper end :: -->


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
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../../footer.php'); ?>
  <!--フッター ここまで-->
  <script src="../js/lightbox.js"></script>
  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/products/js/hand-scroll.js?v=1.01"></script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="ptw/photoswipe.min.js?v=1.08"></script>
  <script src="ptw/photoswipe-ui-default.min.js"></script>
  <!-- <script type="text/javascript" src="/products/js/auto-slider.js"></script> -->
  <script type="text/javascript" src="/products/acrylic/js/calculate_aurora-v2.js?v=<?php echo date('is') ?>"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
  <script type="text/javascript" language="javascript">
    $(document).ready(function() {
      $("#open-virus").click(function() {
        $("#slide-virus").slideToggle("slow");
      });

      //sso
      const imageList = [{
          src: "/products/images/aurora_v2_01.webp",
          targetId: "processing"
        },
        {
          src: "/products/images/aurora_v2_02.webp",
          targetId: "special"
        },
        {
          src: "/products/images/new_arurora_rainbow_-01.webp",
          targetId: "plans"
        },
        {
          src: "/products/images/new_arurora_rainbow_-02.webp",
          targetId: "production"
        },
        // { src: "/products/images/rubberstrap/rubberstrap_durability01.webp", targetId: "durability01" },
        // { src: "/products/images/rubberstrap/rubberstrap_durability02.webp", targetId: "durability02" }
      ];

      let pdpCurrentIdx = 0;
      const pdpStrip = document.getElementById('pdp-v2-js-strip');

      let pdpGrid = document.getElementById('pdp-v2-js-grid-pc');

      $('#pdp-v2-js-grid-mb').addClass('is-hidden');
      $('#pdp-v2-js-grid-pc').removeClass('is-hidden');


      if ($(window).width() < 768) {
        pdpGrid = document.getElementById('pdp-v2-js-grid-mb');

        $('#pdp-v2-js-grid-mb').removeClass('is-hidden');
        $('#pdp-v2-js-grid-pc').addClass('is-hidden');
      }

      let pdpTimer;

      // Modal Elements
      const modal = document.getElementById('pdp-v2-modal');
      const modalImg = document.getElementById('pdp-v2-modal-img');
      const closeBtn = document.getElementsByClassName('pdp-v2-modal-close')[0];
      const nextBtn = document.getElementById('pdp-v2-modal-next-btn');

      const zoomSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>';

      function initGallery() {
        imageList.forEach((item, i) => {
          const mainContainer = document.createElement('div');
          mainContainer.className = 'pdp-v2-main-link';
          const iconDiv = document.createElement('div');
          iconDiv.className = 'pdp-v2-zoom-icon';
          iconDiv.innerHTML = zoomSVG;
          const mainImg = document.createElement('img');
          mainImg.src = item.src;
          mainImg.className = 'pdp-v2-slide-img';
          mainContainer.onclick = () => {
            openModal(i);
          };
          mainContainer.appendChild(iconDiv);
          mainContainer.appendChild(mainImg);
          pdpStrip.appendChild(mainContainer);

          const thumbImg = document.createElement('img');
          thumbImg.src = item.src;
          thumbImg.className = 'pdp-v2-thumb-item';
          if (i === 0) thumbImg.classList.add('pdp-v2-active-state');
          thumbImg.onclick = () => {
            updateGalleryView(i);
            restartAutoTimer();
          };
          pdpGrid.appendChild(thumbImg);
        });
      }

      function updateGalleryView(index) {
        pdpCurrentIdx = index;
        pdpStrip.style.transform = `translateX(-${index * 100}%)`;
        const thumbs = document.querySelectorAll('.pdp-v2-thumb-item');
        thumbs.forEach((el, i) => {
          el.classList.toggle('pdp-v2-active-state', i === index);
        });
      }

      // --- SMOOTH MODAL LOGIC ---
      function openModal(index) {
        pdpCurrentIdx = index;
        modal.classList.add('active');
        modalImg.src = imageList[index].src;
        modalImg.style.opacity = '1';
        clearInterval(pdpTimer);
      }

      function updateModalImage(index) {
        // 1. Hide the image slowly
        modalImg.style.opacity = '0';

        // 2. Wait for the fade-out to finish (800ms)
        setTimeout(() => {
          // 3. Swap the source
          modalImg.src = imageList[index].src;

          // 4. Wait for browser to load new image before showing it
          modalImg.onload = () => {
            modalImg.style.opacity = '1';
          };
        }, 200);
      }

      function closeModal() {
        modal.classList.remove('active');
        restartAutoTimer();
      }

      function nextImage() {
        pdpCurrentIdx = (pdpCurrentIdx + 1) % imageList.length;
        updateModalImage(pdpCurrentIdx);
        updateGalleryView(pdpCurrentIdx);
      }

      closeBtn.onclick = closeModal;
      modal.onclick = (e) => {
        if (e.target === modal) closeModal();
      };
      nextBtn.onclick = (e) => {
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

      initGallery();
      startAutoTimer();

      var $el, $ps, $up, totalHeight;
      $(".exc_pro1 .btn").click(function() {
        totalHeight = 0
        $el = $(this);
        $p = $el.parent();
        $up = $p.parent();
        $ps = $up.find("div.swiper-container:not('.read-more')");
        $ps.each(function() {
          totalHeight += $(this).outerHeight();
        });
        $up
          .css({
            "height": $up.height(),
            "max-height": 9999,
            "padding-bottom": 70
          })
          .animate({
            "height": totalHeight
          });

        $p.fadeOut();

        return false;
      });
      $(".exc_pro .btn").click(function() {
        totalHeight = 0
        $el = $(this);
        $p = $el.parent();
        $up = $p.parent();
        $ps = $up.find("div.swiper-container:not('.read-more1')");
        $ps.each(function() {
          totalHeight += $(this).outerHeight();
        });
        $up
          .css({
            "height": $up.height(),
            "max-height": 9999,
            "padding-bottom": 70
          })
          .animate({
            "height": totalHeight
          });

        $p.fadeOut();

        return false;
      });
      $('#info_div').load('/info/index.php');

      var tmp = "<?= $_GET['mode'] ?>";
      if (tmp != "") {
        validation('step3');
        check_val('next');
      }
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
    });

    lightbox.option({
      'maxWidth': 800,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    });
    if (window.innerWidth < 768) {
      var swiper = new Swiper('.swiper-container', {
        slidesPerView: 2,
        spaceBetween: 10,
        slidesPerGroup: 1,
        loop: false,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });
      var x = document.getElementsByClassName('swiper-wrapper');
      window.onload = function() {
        // Wait a short time after the page loads before scrolling
        setTimeout(function() {
          // Scroll the page down by a small amount (e.g., 100 pixels)
          window.scrollBy(0, 5);
        }, 3000); // Adjust the timeout and scroll amount as needed
      };
    } else {
      window.onload = function() {
        // Wait a short time after the page loads before scrolling
        setTimeout(function() {
          // Scroll the page down by a small amount (e.g., 100 pixels)
          window.scrollBy(0, 5);
        }, 100); // Adjust the timeout and scroll amount as needed
      };
    }
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
    $("input[name='acy_paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/acy_paper_preview.php');
      }
    });

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
  </script>
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
                        "name": "オーロラアクリルキーホルダー（オーロラアクキー）",
                        "item": "https://hotmobily.jp/products/acrylic/aurora.php"
                    }
                ]
            }
        ]
    </script>
    <!-- /.google script -->

</body>

</html>