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
$product_name = "【ホットモバイリー】オリジナルアクリルパネル（アクリルボード）";
$product_description = "オリジナルアクリルパネル（アクリルボード）をオーダーメイドで製作。最短6営業日で出荷可能。小ロット1個から製作できます。最安単価740円。インテリアとしても映える存在感抜群のキャラクターグッズやフォトプレートに";
$product_image_url = "https://hotmobily.jp/products/acrylic/img/board/acrylic_board_02.webp";
$product_sku = "HM-AB-2025";
$product_price = 740;
$product_currency = "JPY";
$product_availability = "InStock";
$product_url = "https://hotmobily.jp/products/acrylic/board";

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
  <meta name="keywords" content="<?= lang('オリジナルアクリルパネル（アクリルボード）,アニメキャラ,Vtuber,アイドル,推し活,グッズ,オリジナルグッズ製作,フォトボード,フォトパネル,写真,イラスト') ?>">
  <meta name="description" content="<?= lang('オリジナルアクリルパネル（アクリルボード）をご製作！アニメキャラやVtuber、アイドルなどの推し活に！オリジナルのイラストや写真を印刷できます。ボードは横向きと縦向きの両方をご用意。インテリアとしても映えるオリジナルグッズに！大ロット注文承っております。') ?>">
  <meta name="robots" content="index,follow">
  <title><?= lang('オリジナルアクリルパネル（アクリルボード）製作！アニメやVtuberの推し活グッズに！') ?></title>
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <?php include('../../head_products.html'); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <link href="/products/css/product_group.css?v=1.11" rel="stylesheet" type="text/css" />
  <link href="css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.10" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="ptw/photoswipe.css">
  <link rel="stylesheet" href="ptw/default-skin.css">
  <link href="/products/acrylic/css/hand-scroll.css?v=1.00" rel="stylesheet" type="text/css">
  <link href="/products/css/calendar.css" rel="stylesheet" type="text/css" />
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
    .part-name.disabled-option {
      color: #aaaaaa !important;
      cursor: not-allowed !important;
      pointer-events: none;
    }
    .part-name.disabled-option .checkmark {
      background-color: #e0e0e0 !important;
      border-color: #cccccc !important;
    }
    .part-content.disabled-option {
      background-color: #f5f5f5 !important;
      border-color: #e0e0e0 !important;
      cursor: not-allowed !important;
    }
    .new-text {
      font-size: 16px !important;
      letter-spacing: 0.05em !important;
      line-height: 150% !important;
    }

    .step-container.line1 {
      padding: 5px;
      border: 1px solid lightgray;
      margin-bottom: 5px;
      width: calc(100% - 15px)
    }

    .sold-out2 {
      position: absolute;
      left: 25%;
      top: 40%;
      transform: rotate(350deg);
      -ms-transform: rotate(350deg);
      -moz-transform: rotate(350deg);
      -webkit-transform: rotate(350deg);
      -o-transform: rotate(350deg)
    }

    .sold-out {
      position: absolute;
      left: 25%;
      top: 38%;
      transform: rotate(350deg);
      -ms-transform: rotate(350deg);
      -moz-transform: rotate(350deg);
      -webkit-transform: rotate(350deg);
      -o-transform: rotate(350deg)
    }

    .ZoomContainer {
      display: none
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

    .exc_pro {
      padding-bottom: 40px;
      max-height: 50px;
      margin-bottom: 10px
    }

    .exc_pro1 {
      position: relative;
      overflow: hidden
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
      z-index: 1;
      display: none
    }

    .sold-out {
      position: absolute;
      left: 25%;
      top: 20%;
      transform: rotate(350deg);
      -ms-transform: rotate(350deg);
      -moz-transform: rotate(350deg);
      -webkit-transform: rotate(350deg);
      -o-transform: rotate(350deg)
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


    .img-container {
      position: relative;
      display: inline-block;
    }

    #productImg {
      display: block;
      max-width: 100%;
      height: auto;
      user-select: none;
    }

    #lens {
      position: absolute;
      border: 2px solid rgba(255, 255, 255, 0.95);
      width: 180px;
      /* change lens size here */
      height: 140px;
      pointer-events: none;
      /* so mouse events reach the image */
      display: none;
      /* hidden until hover */
      background-repeat: no-repeat;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
      z-index: 50;
    }

    @media(max-width: 768px) {
      .download_templete .modal-content.data {
        width: 90%
      }
    }

    @media (max-width: 576px) {
      .exc_pro {
        max-height: 85px
      }

      .read-more {
        display: block
      }

      input[name="qty"] {
        width: calc(100% - 200px)
      }

      #label-qty {
        justify-content: space-between
      }
    }

    #delivery-main {
      text-decoration: none;
      position: relative
    }

    #delivery-main:after {
      content: ' ';
      font-size: inherit;
      display: block;
      position: absolute;
      right: 0;
      left: 0;
      top: 30%;
      bottom: 40%;
      border-top: 1px solid red;
      border-bottom: 1px solid red
    }

    .delivery-sub {
      pointer-events: none
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

    .text-center {
      text-align: center;
    }

    .btn-a.btn-orange,
    .btn-a.btn-yellow {
      width: 80% !important;
      background-color: #f79647
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

    .pdp-v2-modal-close,
    .pdp-v3-modal-close {
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

    .row-slider {
      display: flex;
      flex-direction: row;
      gap: 15px;
    }

    #pc-gall-show {
      display: block;
    }

    #mb-gall-show {
      display: none;
    }

    @media (max-width:768px) {
      .d-flex2 {
        justify-content: center
      }

      .flex-item {
        flex-basis: 100%;
        max-width: 100%
      }

      .thought {
        margin-bottom: 0
      }

      .poster-grid {
        grid-template-columns: repeat(2, 1fr)
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
  </style>
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
      <h1>オリジナルアクリルパネル（アクリルボード）製作！鮮やかな印刷で推し活グッズにぴったり！</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルのアクリルスマホスタンド（アクスタ）が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/stand" title="Share by Email" target="_blank">シェアする</a><a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルのアクリルスマホスタンド（アクスタ）が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/stand" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2fstand" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2fstand&amp;text=オリジナルのアクリルスマホスタンド（アクスタ）が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <div class="flex-container">
      </div>

      <div>
        <img src="/products/acrylic/img/board/banner_acrylicboard.webp" alt="" width="771" height="390" />
      </div>

      <div>
        <br>
        <p class="new-text">高精度のフルカラー印刷のオリジナルアクリルパネル（アクリルボード）製作！最安単価740円（税込）、最短6営業日後出荷！大ロット注文がお得です。小ロット1個からの製作ももちろん可能となっております。推し活グッズやフォトプレートに！<a href="#est-content">ご注文・お見積りはこちら</a></p>
      </div>

      <h2>インテリアとしても映える！推し活グッズやフォトプレートに</h2>
      <div>
        <div>
          <img src="/products/acrylic/img/board/acrylic_board_01.webp" alt="" width="771" height="390" />
        </div>
        <br>
        <div>
          <p class="new-text">高い透明感と美しい光沢が魅力のアクリルパネル（アクリルボード）に、お客様のイラストや写真を高精度・高発色でフルカラー印刷いたします。細かな線や色のグラデーションまで鮮明に再現できるため、たとえば法人様でしたら、ファン向けのアニメキャラクター・アイドル・Vtuberなどの推し活グッズに最適です。個人のお客様でしたら、ご自身のオリジナルキャラクターなどでのグッズ製作にぴったりです。記念日やイベントの思い出を残すフォトプレート・フォトスタンドとしても人気が高く、結婚式・卒業・誕生日などの記念品やプレゼントにもおすすめ。自立させて飾れるため、デスクや棚、受付カウンターなど卓上インテリアとしても映えるアクリルパネル（アクリルボード）です。展示用・販売用・ノベルティまで幅広い用途に対応できます。</p>
        </div>

        <br>
        <div class="poster-grid">
          <div class="poster-item">
            <div>
              <p class="new-text"></p>
            </div>
            <img onclick="openSimpleModal(this)" src="/products/acrylic/img/board/acrylic_board_02.webp" alt="Poster 1" style="cursor: pointer;">
            <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
            </div>
          </div>
          <div class="poster-item">
            <div>
              <p class="new-text"></p>
            </div>
            <img onclick="openSimpleModal(this)" src="/products/acrylic/img/board/acrylic_board_03.webp" alt="Poster 2" style="cursor: pointer;">
            <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
            </div>
          </div>
        </div>
        <br>
        <p class="new-text">小ロット1個から製作可能なので、自分で描いたイラストやペット・家族の写真も手軽にアクリルパネル（アクリルボード）に。額縁や写真立てとは違った存在感でデスクや棚に飾ることができます。同人グッズ制作にも最適で、即売会・イベント頒布用の同人グッズや、少部数だけ作りたい試作品・記念アイテムとしても人気。アニメ・ゲーム・創作キャラクターのビジュアルも、透明感のあるアクリルに美しく映えます。</p>
      </div>

      <h2>アクリルパネルのサイズ</h2>
      <div>
        <div>
          <img onclick="openSimpleModal(this)" src="/products/acrylic/img/acrylic-board-3size.webp" alt="" width="771" height="390" style="cursor: pointer;" />
          <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
          </div>
        </div>
        <br>
        <p class="new-text">当店のアクリルパネルは、以下の3サイズをご用意しております。</p>
        <br>

        <p class="new-text">・A5サイズ（210mm×148mm）</p>
        <p class="new-text">・A4サイズ（210mm × 297mm）</p>
        <p class="new-text">・A3サイズ（297mm × 420mm）</p>
        <br>
        <p class="new-text">パネルを支える部品の仕様は、パネルのサイズによって異なります。A5サイズのパネルの場合は金属製のピン、A4サイズ・A3サイズのパネルの場合はアクリル製の部品になります。</p>
        <br>

        <div class="poster-grid">
          <div class="poster-item">
            <div style="text-align: center;">
              <p class="new-text">A5サイズの場合</p>
            </div>
            <img onclick="openSimpleModal(this)" src="/products/acrylic/img/acrylic-board-v1.webp" alt="Poster 1" style="cursor: pointer;">
            <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
            </div>
          </div>
          <div class="poster-item">
            <div style="text-align: center;">
              <p class="new-text">A4・A3サイズの場合</p>
            </div>
            <img onclick="openSimpleModal(this)" src="/products/acrylic/img/acrylic-board-v2.webp" alt="Poster 2" style="cursor: pointer;">
            <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
            </div>
          </div>
        </div>

      </div>

      <h2>誰でも簡単に設置可能！アクリルパネル（アクリルボード）の飾り方・使い方</h2>
      <div>
        <p class="new-text">当店のアクリルパネル（アクリルボード）の飾り方・使い方はとても簡単。付属のピンをアクリルプレートの穴に取り付けて頂ければ、すぐにご使用になれます。くわしい手順は下記の動画をご確認ください。</p><br>
        <div class="videoWrapper">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/SiI3HioRR8g?si=UgZiY3pYOF36kSRd" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>

      <h2>制作料金と納期</h2>
      <div class="new-text">
        <p class="new-text">注文数量別の税込単価は以下となります。</p>



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

        <div class="fixed-thead">
            <p class="new-text">数量・サイズ別価格表</p>
            <div class="scroll-center">
            <div class="arrow"></div>
            </div>
            <table id="table-price" class="tbl-price tb-w12 blink" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;width: 99%;">
            <thead>
                <tr>
                    <td></td>
                    <td>A5サイズ</td>
                    <td>A4サイズ</td>
                    <td>A3サイズ</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
            </table>
        </div>

        <!-- <table width="100%" class="tb-w12 txt-center" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
          <thead>
            <tr class="text-center" style="background-color: #f0f0f0;">
              <th scope="col">数量</th>
              <th scope="col">10営業日後出荷</th>
              <th scope="col">6営業日後出荷</th>
            </tr>
          </thead>
          <tbody>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">1</td>
              <td data-label="A2サイズ">1,437</td>
              <td data-label="B2サイズ">1,595</td>
            </tr>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">10</td>
              <td data-label="A2サイズ">1,309</td>
              <td data-label="B2サイズ">1,454</td>
            </tr>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">30</td>
              <td data-label="A2サイズ">1,259</td>
              <td data-label="B2サイズ">1,397</td>
            </tr>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">50</td>
              <td data-label="A2サイズ">1,155</td>
              <td data-label="B2サイズ">1,283</td>
            </tr>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">100</td>
              <td data-label="A2サイズ">1,041</td>
              <td data-label="B2サイズ">1,157</td>
            </tr>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">300</td>
              <td data-label="A2サイズ">862</td>
              <td data-label="B2サイズ">957</td>
            </tr>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">500</td>
              <td data-label="A2サイズ">803</td>
              <td data-label="B2サイズ">893</td>
            </tr>
            <tr class="text-center">
              <td data-label="数量" style="background-color: #f0f0f0;">1000</td>
              <td data-label="A2サイズ">740</td>
              <td data-label="B2サイズ">821</td>
            </tr>
          </tbody>
        </table> -->
        <div style="text-align:center;">
          <small>※お買い上げ金額合計が11,000円（税込）未満の場合、別途送料880円（税込）がかかります。</small>
        </div>
        <br>
        <p class="new-text">最小ロットは1枚です。また、当Webページの注文フォームから注文可能な最大数量は1,000個となっております。1,000個を超える個数のご注文をご希望の方は、個別に<a href="/contact">お問い合わせ</a>ください。</p>
        <br>
        <p class="new-text">無料サンプルは<a href="/contact">こちら</a>からお求めください。</p>
      </div>

      <br>
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


      <h2>入稿データについて</h2>
      <div>
        <div>
          <p class="new-text">当店のアクリルパネル（アクリルボード）製作サービスでは、データ作成補助を無料で承っております。JPEG、PNG、PDFなどのイラスト・写真をご送付頂ければ、それらを元にアクリルパネル（アクリルボード）製作用の入稿データ（AI形式）を当店でご用意いたします。入稿データ作成に不安のある方も安心してご利用頂けます。</p>
        </div>
        <br>
        <div>
          <img src="/products/acrylic/img/board/banner_cutpath-board.webp" alt="Poster 2">
        </div>
        <br>
        <p class="new-text">なお、Adobeイラストレーターをお持ちの方であれば、当店のテンプレートデータ（AI形式）をベースに、ご自身で入稿データを作成して頂くことも可能です。テンプレートデータは下記にご用意しております。</p>
      </div>


      <!-- <h2><?= lang('入稿データ') ?></h2> -->
      <div>
        <!-- <p class="new-text">入稿データ作成についてのご案内及びテンプレートをご用意しております。下記からダウンロードが可能です。</p> -->
        <!-- <br> -->

        <div style="display:flex; flex-direction:row; justify-content:center; width:100%;">
          <a class="btn-a btn-yellow" href="/products/acrylic/template/Acrylic-board-template.zip" target="_blank" download><span><?= lang('入稿データ用テンプレート') ?></span></a>
        </div>

        <!-- <br> -->
        <!-- <p class="new-text">入稿データはAIデータでの作成をお願いしております。上記の入稿データ作成のご案内・テンプレートもAIデータとなっております。Adobe Illustratorをお持ちでないお客様は、JPG、PNG、PDF等でのご入稿が可能です。</p> -->
      </div>

      <h2>エッジにCNC加工を採用！なめらかなカット面</h2>
      <div>
        <div>
          <div class="img-container">
            <img id="productImg" src="/products/acrylic/img/board/acrylic_board_05.webp" alt="エッジ加工はCNC加工を採用！" width="771" height="auto" />
            <div id="lens" aria-hidden="true"></div>
          </div>
          <!-- <img src="/products/acrylic/img/board/acrylic_board_05.webp" alt="Poster 2" width="771" height="auto"> -->
          <small>マウスを合わせて拡大</small>
        </div>
        <br>
        <div>
          <p class="new-text">アクリルパネル（アクリルボード）を含め、当店の全てのアクリル製品が、エッジにCNC加工を採用しております。アクリル板のカットによく用いられるレーザーカットは、カット面に指で触るとわかる程度の不自然な小さな突起ができてしまいます。当店採用のCNCカットなら、指で触れてもなめらかなカット面を実現。細部までクオリティにこだわったアクリルパネル（アクリルボード）をお届けいたします。</p>
        </div>
      </div>

      <h2>1個から製作可能！さまざまな用途にご注文頂けます！</h2>
      <div>
        <div>
          <img src="/products/images/banner_acrylic-board_order 1.webp" alt="" width="771" height="390" />
        </div>
        <br>
        <p class="new-text">当店のアクリルパネル（アクリルボード）は1個から製作可能です。ご友人への贈り物やご家族用、自分用、同人グッズ、お試しなど、さまざまな用途にご注文頂けます。お気軽にご注文ください。「1個だけ」「10個だけ」など小ロットの注文も歓迎です。</p>
      </div>

      <h2>安心・安全・安価の自社生産！</h2>
      <div>
        <div>
          <p class="new-text">お客様の大切な製品を責任を持って生産するために、当店はアクリル製品を全て自社の工場で生産しています。印刷からカット、検品、梱包まで全て社内で完結しています。さらに、自社生産のため外注費が発生せず、高品質の製品を安くご提供することができます。</p>
        </div>
        <br>
        <div>
          <div class="videoWrapper">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/_6Y5_wYhK50?si=UjV2q704fq2SkqcT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
        </div>
      </div>

      <div id="download_temp_data" class="download_templete">
        <div class="modal-content data">
          <span class="close">&times;</span>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="/products/data-acrylic-stand.php" target="_blank">
                    <div>Illustrator／Photoshopはこちら</div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="/products/clip_studio_data_making.php" target="_blank">
                    <div>CLIP STUDIO PAINTはこちら</div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- <hr style="margin-bottom: 10px;margin-top: 0;" /> -->
      <?php $page = 'product';
      //include('../../campaign_2021.php'); 
      ?>
      <?php //include('campaign_slide.php'); 
      ?>
      <!-- <img src="img/banner-acrylic.webp" width="100%" height="388" style="max-width: 770px;">
      <hr /> -->
      <!-- <div class="videoWrapper">
        <img src="img/ak-yt.webp" data-src="ho78jzoURdM" class="iframe" width="100%" height="434">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div> -->
      <?php //include("four_reason-v2.php") 
      ?>
      <!-- <h2>製作事例紹介</h2>
      <div class="tag-menu" style="display: none;">
        タグで絞込み：
        <a href='/gallery/acrylic_key-test?tag=個人' class='tag-name' target="_blank">個人</a>
        <a href='/gallery/acrylic_key-test?tag=会社' class='tag-name' target="_blank">会社</a>
        <a href='/gallery/acrylic_key-test?tag=赤色' class='tag-name' target="_blank">赤色</a>
        <a href='/gallery/acrylic_key-test?tag=青色' class='tag-name' target="_blank">青色</a>
        <a href='/gallery/acrylic_key-test?tag=黄色' class='tag-name' target="_blank">黄色</a>
        <a href='/gallery/acrylic_key-test?tag=紫色' class='tag-name' target="_blank">紫色</a>
        <a href='/gallery/acrylic_key-test?tag=緑色' class='tag-name' target="_blank">緑色</a>
        <a href='/gallery/acrylic_key-test?tag=黒色' class='tag-name' target="_blank">黒色</a>
        <a href='/gallery/acrylic_key-test?tag=1人' class='tag-name' target="_blank">1人</a>
        <a href='/gallery/acrylic_key-test?tag=複数人' class='tag-name' target="_blank">複数人</a>
        <a href='/gallery/acrylic_key-test?tag=片面' class='tag-name' target="_blank">片面</a>
        <a href='/gallery/acrylic_key-test?tag=両面' class='tag-name' target="_blank">両面</a>
      </div> -->
      <!-- <div class="exc_pro1 ex-row">
        <div class="swiper-button-prev"></div>
        <div class="swiper-container swiper2">
          <div class="swiper-wrapper swiper-bt">
            <div class="swiper-slide">
              <a href="/products/acrylic/img/acrylic-stand-1.webp" data-lightbox="acrylic-a1" style="text-decoration:none;" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　青山様">
                <img src="/products/acrylic/img/acrylic-stand-1.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します </div>
              </a>
              <a href="/products/acrylic/img/acrylic-stand-1b.webp" data-lightbox="acrylic-a1" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　青山様"></a>
              <a href="/products/acrylic/img/acrylic-stand-1c.webp" data-lightbox="acrylic-a1" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　青山様"></a>
            </div>
            <div class="swiper-slide">
              <a href="/products/acrylic/img/acrylic-stand-2.webp" data-lightbox="acrylic-a2" style="text-decoration:none;" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　望月様">
                <img src="/products/acrylic/img/acrylic-stand-2.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します </div>
              </a>
              <a href="/products/acrylic/img/acrylic-stand-2b.webp" data-lightbox="acrylic-a2" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　望月様"></a>
              <a href="/products/acrylic/img/acrylic-stand-2c.webp" data-lightbox="acrylic-a2" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　望月様"></a>
            </div>
            <div class="swiper-slide">
              <a href="/products/acrylic/img/acrylic-stand-3.webp" data-lightbox="acrylic-a3" style="text-decoration:none;" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　石川様">
                <img src="/products/acrylic/img/acrylic-stand-3.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します </div>
              </a>
              <a href="/products/acrylic/img/acrylic-stand-3b.webp" data-lightbox="acrylic-a3" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　石川様"></a>
              <a href="/products/acrylic/img/acrylic-stand-3c.webp" data-lightbox="acrylic-a3" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　石川様"></a>
            </div>
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div style="text-align: center; margin: 15px auto 0; display: none;">
          <a href="/gallery/acrylic_key"><img class="btn_z" src="/products/images/but3-02.webp" width="266" height="167"></a>
        </div>
        <div class="read-more1"><a href="#" class="btn"><img class="btn_z" src="/products/images/but3-02.webp" width="266" height="167"></a></div>
      </div> -->
      <!-- <hr /> -->
      <!-- <h2 style="margin-top: 5px;">入稿データ作成方法</h2>
      <a href="https://hotmobily.jp/products/data-acrylic-stand.php" target="_blank"><img src="img/banner_design_data.webp" width="100%" height="388" style="max-width:770px;"></a> -->
      <?php include("../campaign_news.php"); ?>
      <hr />
      <!-- <h2>代表的な本数での価格表</h2>
      <p class="new-text">納期と印刷面を選択してください。サイズ別の製作単価表が表示されます。ここは価格表のみです。<a href="#est-content">見積・注文</a>はこちらです。</p><br />
      <h3>納期</h3>
      <div class="part-container">
        <div class="part-content" style="display: flex;">
          <label class="part-name"><input type="radio" name="prc_delivery" value="10" checked="" onclick="writePriceTable('del');">10営業日 <span class="checkmark"></span></label>
          <label class="part-name"><input type="radio" name="prc_delivery" value="6" onclick="writePriceTable('del');">6営業日 <span class="checkmark"></span></label>
        </div>
      </div><br />
      <h3>数量・サイズ別価格表</h3>
      <div class="fixed-thead">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table id="table-price" class="tbl-price tb-w12 blink" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;width: 99%;">
          <thead>
            <tr>
              <td></td>
              <td>150x90mm</td>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※お買い上げ金額合計が11,000円（税込）未満の場合、別途送料880円（税込）がかかります。<br>
      </div> -->
      <h2 id="est-content">ご注文・見積書作成</h2>

      <?php include('../campaign_banner.php') ?>

      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【アクリルパネル（アクリルボード）】</h3>
          <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td>納期</td>
                <td><span id="sample-prd-prdt"></span></td>
              </tr>
              <tr>
                <td>サイズ</td>
                <td><span id="sample-prd-size"></span></td>
              </tr>
              <tr>
                <td>数量</td>
                <td><span id="sample-prd-qty"></span></td>
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
            <img src="img/coming-soon.webp" id="sample-paper-pic" class="picpro" width="500" height="500"><br />
            台紙:<span id="sample-paper-name">なし</span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details">納期・サイズ</span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div><span class="step-details">台紙等</span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details">製品仕様・製作料金</span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="アクリルパネル" />
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
            case 'A4サイズ':
              $sizeA4 = "checked";
              $sizeA5 = "";
              $sizeA3 = "";
              break;
            case 'A3サイズ':
              $sizeA3 = "checked";
              $sizeA5 = "";
              $sizeA4 = "";
              break;
            default:
              $sizeA5 = "checked";
              $sizeA4 = "";
              $sizeA3 = "";
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
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_delivery" onclick="readfunction('10');" value="10営業日"<?= $delivery_10 ?>>10営業日<span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name" <?= $delivery_disabled ?>><input type="radio" name="acy_delivery" onclick="readfunction('6');" value="6営業日"<?= $delivery_6 ?> <?= $planDisabled ?>>6営業日 <span class="checkmark"></span></label>
              </div>
              <h3 style="font-size: 13px;"><i style="color:red" class="fa fa-exclamation-circle" aria-hidden="true"></i>毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。
              </h3>
            </div>
            <h3>サイズ</h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input class="aa5" type="radio" name="acy_size" value="A5サイズ" <?= $sizeA5 ?>>A5サイズ <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name aa4s"><input class="aa4" type="radio" name="acy_size" value="A4サイズ" <?= $sizeA4 ?>>A4サイズ <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name aa5s"><input class="aa3" type="radio" name="acy_size" value="A3サイズ" <?= $sizeA3 ?>>A3サイズ <span class="checkmark"></span></label>
              </div>
            </div>
            <h3>数量</h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty">ご注文・御見積数量&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" onblur="check_val('next')" value="<?= $qty ?>"></label>
                <div class="error" id="qty-error"></div>
              </div>
              <h3 style="font-size: 13px;">※デザイン1種につき1注文となります。デザインが複数ある場合は、デザインごとにご注文ください。</h3>
            </div>
          </div>
          <div class="estimate-content" id="step2">
            <!-- <h3>台紙</h3>
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
                  台紙印刷
                </label>
                <div class="error" id="paper-error"></div>
              </div>
            </div> -->
            <div class="flex-container paper-container">
              <div class="preview-container">
                <div class="preview-sub flex-container" id="paper-preview">
                  <?php if ($acy_paper_select == "あり") {
                    include("../acy_paper_preview.php");
                  } ?>
                </div>
              </div>
            </div>
            <h3 style="display: inline;">試作品・データ作成補助</h3><a href="javascript:void(0)" id="opn-modal">詳細</a>
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
                  試作品 (20個以上から)
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
                  データ作成補助
                </label>
                <div id="myModal" class="modal">
                  <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <p>
                      アクリル製品を製作する際に必要な、カットパスと白押さえのデータを作成するサービスです。<br />アドビイラストレータもしくはフォトショップ以外のソフトでデザインを作成した場合には、必ずありを選択してください。
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="estimate-content flex-item" id="step3">
            <div class="flex-container">
              <div class="flex-item">
                <h3>製品仕様</h3>
                <table class="table_rubber">
                  <tbody>
                    <tr>
                      <td class="TableLeft">納期</td>
                      <td class="" id="prd_production" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">サイズ</td>
                      <td class="" id="prd_size" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">数量</td>
                      <td class="" id="prd_amount" style="text-align: left;"></td>
                    </tr>
                    <!-- <tr>
                      <td class="TableLeft">台紙</td>
                      <td class="" id="prd_paper" style="text-align: left;"></td>
                    </tr> -->
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class="" id="prd_sample" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データ作成補助</td>
                      <td class="" id="prd_trace" style="text-align: left;">なし</td>
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
                      <td class=""><input id="prd_price" type="text" name="prd_price" readonly>円</td>
                    </tr>
                    <!-- <tr>
                      <td class="TableLeft">台紙</td>
                      <td class=""><input id="prd_paper_price" type="text" name="prd_paper_price" readonly>円</td>
                    </tr> -->
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データ作成補助</td>
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
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="validation('back')">戻る</a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="validation('next')">オプション入力へ</a>
          </div>
        </form>
        <div id="cus_detail" style="display:none;" align="center">
          <table class="table_rubber" style="display: table;">
            <tbody>
              <tr>
                <td class="TableLeft">お名前（姓）</td>
                <td class=""><input name="Name_S" id="sname" type="text" maxlength="100" value=""></td>
              </tr>
              <tr>
                <td class="TableLeft">お名前（名）</td>
                <td class=""><input name="Name_F" id="fname" type="text" maxlength="100" value=""></td>
              </tr>
              <tr>
                <td class="TableLeft">法人名</td>
                <td class=""><input name="Corp_Name" id="Corp_Name" type="text" value="" size="45" maxlength="100"></td>
              </tr>
              <tr>
                <td class="TableLeft">郵便番号 </td>
                <td class=""><input type="text" id="zip" name="zip" maxlength="8" size="15" value="">&nbsp;<input type="button" id="src_btn" onclick="address_fn();" value="住所に変換"><br><span id="error" style="color:red"></span></td>
              </tr>
              <tr>
                <td class="TableLeft">都道府県</td>
                <td class=""><input type="text" id="address1" name="prefc" value=""></td>
              </tr>
              <tr>
                <td class="TableLeft">以降の住所</td>
                <td class=""><input id="address2" name="address" type="text" class="contact_text1" value=""></td>
              </tr>
              <tr>
                <td class="TableLeft">番地、建物名、部屋番号</td>
                <td class=""><input id="address_street" name="address_street" type="text" class="contact_text1" value=""></td>
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
                <td colspan="2" align="center" style="padding: 10px;background: unset;border: unset;">
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');" value="御社情報確定（PDF出力）">
                  <div class="remark">&nbsp;※社名や会社名の入力は任意です</div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <h2><?= lang('製品仕様・付属品等') ?></h2>
      <div class="new-text">
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td>名称</td>
              <td>アクリルパネル（アクリルボード）</td>
            </tr>
            <tr>
              <td>素材</td>
              <td>アクリル板</td>
            </tr>
            <tr>
              <td>サイズ</td>
              <td>・A5サイズ（210mm×148mm）<br>・A4サイズ（210mm × 297mm）<br>・A3サイズ（297mm × 420mm）</td>
            </tr>
            <tr>
              <td>付属品</td>
              <td>固定用ピン</td>
            </tr>
            <tr>
              <td>印刷方法</td>
              <td>フルカラーUVインクジェット印刷+白押さえが基本となります。</td>
            </tr>
            <tr>
              <td>最小ロット</td>
              <td>1個</td>
            </tr>
            <tr>
              <td>包装</td>
              <td>個別OPP包装</td>
            </tr>
            <tr>
              <td>納期</td>
              <td>10営業日後出荷・6営業日後出荷</td>
            </tr>
          </tbody>
        </table>
      </div>
      <br>

        <h2><?= lang('アクリルグッズ一覧') ?></h2>
      <br>
      <?php include('acrylic-items-lists.php') ?>



      <!-- <hr /> -->
      <!-- <h2 style="margin-top: 5px;">よくある質問</h2>
      <div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">Aというデザインを2枚、Bというデザインを2枚注文する際、合計4枚として注文できますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">はい、できます。</span><a href="javascript:void(0)" onclick="$('#panel1').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel1" class="a-detail new-text">
            アクリルスマホスタンドの注文画面はカート形式となっております。この場合、まずAデザインのご注文をカートに入れていただき、その後「買い物を続ける」ボタンをクリックしてください。アクリル製品一覧画面に移行しますので、再度アクリルスマホスタンドのページに行き、注文画面からBデザインのご注文をカートに入れてください。カートに2つの注文が入っていることをご確認後「購入へ」ボタンをクリックし、ご購入のステップにお進みください。例えば、表面のデザインは同じで、裏面のデザインだけが異なる場合も、別々の注文として2件のご注文をカートに入れていただく必要がございます。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">データ作成補助はどんな時に必要ですか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">アドビイラストレータもしくは、フォトショップ以外で作成されたデータでご注文の場合、原則必須となります。</span><a href="javascript:void(0)" onclick="$('#panel2').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel2" class="a-detail new-text">
            アクリルキーホルダーを作成する際、デザインのデータ以外に、カットパスと白押さえのデータが必要となります。カットバスとは、どのようにアクリルキーホルダーをカットするかのデータです。白押さえとは、アクリルキーホルダーを印刷する際、白色部分は印刷されませんので、透明となります。一旦白色以外の部分を印刷した後、指定された部分のみ白色印刷を行います。カットパスと白押さえの詳細は、<a href="https://hotmobily.jp/products/data-acrylic-umbrella.php">入稿データ作成</a>のページをご覧ください。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">注文したのですが、キャンセルしたいです。できますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">製作（量産）開始のご連絡前であれば可能です。</span><a href="javascript:void(0)" onclick="$('#panel3').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel3" class="a-detail new-text">
            製品の製作を開始する際には、その旨をメールでご連絡させて頂きます。このメールが送信される前であれば、キャンセルは可能です。キャンセル費用はかかりません。既に製作料金のお振込みが完了している場合、ご返金させて頂きますが、ご返金に伴う振り込み手数料はお客様負担となります。また、製作料金よりも振り込み手数料の方が高い場合、ご返金はできません。製作開始後のキャンセルは一切できませんのでご了承ください。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">配送先を複数拠点に出来ますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">複数拠点に発送は可能です。</span><a href="javascript:void(0)" onclick="$('#panel4').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel4" class="a-detail new-text">ただし、発送数量、発送住所をお伺いして別途配送手配代金を追加で頂戴する必要がございます。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">注文フォームから注文した内容を変更できますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">注文内容の変更は可能ですが、案件の進行状況によっては対応は異なります。</span><a href="javascript:void(0)" onclick="$('#panel5').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel5" class="a-detail new-text">
            弊社にてデザインを調整前（製作開始前）は、正しい注文内容にて再注文をお願いします。<br />弊社にてデザインを調整後（製作開始後）は、デザインを変更できませんが、パーツは変更可能でございます。パーツ変更に伴い、追加料金が発生する場合、差額を再度ご入金頂く必要がございます。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">同じデザインですが、複数種のアタッチメントに変更したいです。手配は可能ですか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">手配可能です。</span><a href="javascript:void(0)" onclick="$('#panel6').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel6" class="a-detail new-text">現在のご注文フォームからこのような注文はお受けできませんので、ご希望がございますお客様は直接営業担当までご相談ください。
          </div>
        </div>
        <div class="quest">Q</div>
        <div class="q-detail">納期について、6営業と10営業がありますが、営業日とは何ですか？また、配送時間はどれくらいですか？</div>
        <div class="ans">A</div>
        <div class="q-detail"><span class="orange">営業日とは土日祝をカウントしない日数です。</span><a href="javascript:void(0)" onclick="$('#panel7').slideToggle('fast');">...詳細表示</a></div>
        <div id="panel7" class="a-detail new-text">また、製品の配送には2日程度かかります。※離島を除く。
        </div>
      </div> -->
      <!-- <hr /> -->
      <?php //include('../acrylic-blog.php'); 
      ?>
      <!-- <h2>その他アクリル製品</h2>
      <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/"><img src="img/go_to_top.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/figure"><img src="img/go_to_figure.webp" width="380" height="165"></a>
        </div>
      </div>
      <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/umbrella"><img src="img/go_to_um.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/badge"><img src="img/go_to_badge.webp" width="380" height="165"></a>
        </div>
      </div>
      <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/coaster"><img src="img/go_to_coaster.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/hairbunch"><img src="img/go_to_hair.webp" width="380" height="165"></a>
        </div>
      </div>
      <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/griptok"><img src="img/go_to_griptok.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">

        </div>
      </div> -->
      <!-- <hr /> -->
      <!-- <h2>営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。</h2>
      <a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82"></a>
      <div style="clear: both">&nbsp;</div> -->
    </div>
    <!-- :: content_wrapper end :: -->

    <div id="pdp-v3-modal" class="pdp-v2-modal-overlay">
      <div class="pdp-v2-modal-container">
        <span class="pdp-v3-modal-close">&times;</span>
        <img class="pdp-v2-modal-content" id="pdp-v3-modal-img" alt="Zoomed view">

        <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn">
        </div>
      </div>
    </div>

  </div>
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../../footer.html'); ?>
  <!--フッター ここまで-->
  <script src="../js/lightbox.js"></script>
  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/products/js/hand-scroll.js?v=1.01"></script>
  <script type="text/javascript" src="/products/acrylic/js/calculate-board-new.js?ep=<?php echo date('is') ?>"></script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="ptw/photoswipe.min.js?v=1.08"></script>
  <script src="ptw/photoswipe-ui-default.min.js"></script>
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script>
    $(function() {

      const modal2 = document.getElementById('pdp-v3-modal');
      const modalImg2 = document.getElementById('pdp-v3-modal-img');
      const closeBtn2 = document.getElementsByClassName('pdp-v3-modal-close')[0];

      function closeModal2() {
        modal2.classList.remove('active');
        // restartAutoTimer();
      }

      closeBtn2.onclick = closeModal2;
      modal2.onclick = (e) => {
        if (e.target === modal2) closeModal2();
      };


      $('#info_div').load('/info/index.php');
      $('.slider_review').bxSlider({
        mode: 'vertical',
        auto: true,
        pause: 4000,
        speed: 1000,
        maxSlides: 3, //一度に表示させる数
        minSlides: 3, //最低限表示させる数
        moveSlides: 1, //スライドで動かす数
        pager: false,
        controls: false,
        autoControls: false,
        preventDefaultSwipeY: false,
        touchEnabled: false,
      });
    });

    lightbox.option({
      'maxWidth': 800,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    });
    $(function() {
      var tmp = "<?= $_GET['mode'] ?>";
      if (tmp != "") {
        validation('step3');
      }
      var currentDelivery = $('input[name="acy_delivery"]:checked').val();
      if (currentDelivery === '6営業日') {
        readfunction('6');
      }
    })

    if (window.innerWidth < 768) {
      var swiper = new Swiper('.swiper-container', {
        slidesPerView: 2,
        spaceBetween: 10,
        slidesPerGroup: 1,
        loop: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });
      var x = document.getElementsByClassName('swiper-wrapper');
    }

    $(function() {
      var $el, $ps, $up, totalHeight;
      $(".exc_pro .btn").click(function() {
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
            "padding-bottom": 0
          })
          .animate({
            "height": totalHeight
          });

        $p.fadeOut();

        return false;
      });
    });
    $("input[name='acy_paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/acy_paper_preview.php');
      }
    });
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

    function readfunction(days)
    {
        $('.aa3,.aa4').attr('disabled',false);
        $('.aa4s, .aa5s').removeClass('disabled-option').closest('.part-content').removeClass('disabled-option');
        if (days == '6') {
            $('.aa3,.aa4').attr('disabled',true).prop('checked', false);
            $('.aa4s, .aa5s').addClass('disabled-option').closest('.part-content').addClass('disabled-option');
        }
    }
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

    function openSimpleModal(element) {
      const modal = document.getElementById('pdp-v3-modal');
      const modalImg = document.getElementById('pdp-v3-modal-img');
      let imgSrc = "";

      // 1. Logic to find the image source
      if (element.tagName === 'IMG') {
        // If they clicked the image directly
        imgSrc = element.src;
      } else {
        // If they clicked the 'camera-left' div, find the image in the same block
        const parent = element.closest('.flex-item');
        const img = parent.querySelector('swiper-container img');
        imgSrc = img ? img.src : "";
      }

      // 2. Open the modal if we found a source
      if (imgSrc) {
        modal.classList.add('active');
        modalImg.src = imgSrc;
        modalImg.style.opacity = '1';

        // Stop any auto-scrolling sliders if necessary
        if (typeof pdpTimer !== 'undefined') clearInterval(pdpTimer);
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
            "name": "アクリルパネル（アクリルボード）",
            "item": "https://hotmobily.jp/products/acrylic/board"
          }
        ]
      }
    ]
  </script>
  <!-- /.google script -->
</body>

</html>