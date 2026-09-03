<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
error_reporting(E_ALL ^ E_NOTICE);
//Read Modules
require_once('../control/Control_Rubber.php');
include_once('../common/Const.php');
include_once('../common/SetUpLang.php');
include("../connect_db/Control_Connect.php");
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
  <meta name="keywords" content="<?= lang('マイクロファイバー,リサイクル素材,印刷,オリジナル,製作') ?>">
  <meta name="description" content="<?= lang('スウェード生地から成る、オリジナルマイクロファイバークロスです。厚みがあり、柔らかい触り心地。フルカラー両面印刷も可能です。最小ロットは100枚。ノベルティとしてもご活用いただけます。') ?>">
  <meta name="robots" content="index,follow">
  <title><?= lang('オリジナルマイクロファイバークロス  スウェード生地｜HOTMOBILYオリジナルグッズ') ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <?php include("../head_products.html"); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
  <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">

  <style type="text/css">
    .mt-10-part {
      min-width: 23%;
      max-width: 23%;
    }

    .mt-10-part div {
      text-align: center;
    }

    .preview-sub .hover {
      max-width: 19.87%;
    }

    .preview-top img,
    .preview-sub .hover img {
      width: 100%;
      height: 100%;
    }

    .videoWrapper {
      margin-top: 0px;
    }

    .gall_pro {
      flex-flow: row wrap;
      justify-content: space-between;
      padding: 0;
      margin-bottom: 10px;
      display: flex;
    }

    .sold-out {
      position: absolute;
      left: 25%;
      top: 23%;
      transform: rotate(350deg);
      -ms-transform: rotate(350deg);
      -moz-transform: rotate(350deg);
      -webkit-transform: rotate(350deg);
      -o-transform: rotate(350deg);
    }

    .modal {
      display: block;
    }

    .prodate {
      padding: 0px 5px;
      text-align: center;
      font-weight: bold;
      background: linear-gradient(to bottom, #d66f21 10%, #ea8335 35%, #f58e41 100%);
      border-radius: 5px;
      color: white;
      font-size: 16px;
      font-family: 'Noto Sans JP', sans-serif;
      width: 87%;
      margin: auto;
    }

    .ZoomContainer {
      display: none;
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

    .tag-menu {
      font-weight: bold;
    }

    .tag-name {
      font-weight: normal;
    }

    #est-content h2 {
      font-size: 25px;
      text-align: center;
      color: black;
    }

    .exc_pro .gallbox {
      margin-bottom: 12px;
    }

    .gallbox {
      width: 33%;
      text-align: center;
    }

    .picpro {
      border: 1px solid lightgray;
      box-shadow: 1px 1px 5px lightgrey;
      margin: 5px;
    }

    .camera-left {
      width: 90%;
      text-align: left !important;
    }

    @media (max-width: 576px) {
      .mt-10-part {
        min-width: 32%;
        max-width: 32%;
      }

      .preview-sub .hover {
        max-width: 19.67%;
      }

      .sold-out {
        width: 60%;
      }

      input[name="numberOf"] {
        width: calc(100% - 200px);
      }

      .prodate {
        width: 90%;
        margin: 0;
        font-size: 13px;
        font-weight: 500;
      }

      #label-qty {
        justify-content: space-between;
      }

      .gallbox {
        width: 50%;
        text-align: left;
      }

      .gall_pro .gallbox {
        display: none;
      }

      .gallbox:nth-child(1),
      .gallbox:nth-child(2),
      .gallbox:nth-child(3),
      .gallbox:nth-child(4),
      .gallbox:nth-child(5),
      .gallbox:nth-child(6),
      .gallbox:nth-child(7),
      .gallbox:nth-child(8) {
        display: block;
      }

      .flex-item.item.w-20 {
        width: 50%;
      }

      .w-50 {
        width: 100% !important;
      }

      .flex-container.flex-border.pl-1 {
        padding-top: 10px;
        width: 100% !important;
      }
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
    }

    .feature1,
    .feature2,
    .feature3,
    .feature4 {
      color: #0AA6E7 !important;
      line-height: 1.5;
      margin-top: 30px !important;
      margin-bottom: 20px !important;
      min-height: 56px;
      padding-left: 66px !important;
      padding-top: 4px !important;
      font-size: 18px !important;
      display: flex;
      align-items: center;
      border-bottom: unset !important;
    }

    .feature1 {
      background: transparent url(img/pointer01.webp) no-repeat !important;
      background-size: 56px 56px !important;
      background-position: 0px center !important;
    }

    .feature2 {
      background: transparent url(img/pointer02.webp) no-repeat !important;
      background-size: 56px 56px !important;
      background-position: 0px center !important;
    }

    .feature3 {
      background: transparent url(img/pointer03.webp) no-repeat !important;
      background-size: 56px 56px !important;
      background-position: 0px center !important;
    }

    .feature4 {
      background: transparent url(img/pointer04.webp) no-repeat !important;
      background-size: 56px 56px !important;
      background-position: 0px center !important;
    }

    .num_feature1 {
      background: transparent url(img/number01.webp) no-repeat !important;
      background-size: 30px 50px !important;
      background-position: 0px center !important;
    }

    .num_feature2 {
      background: transparent url(img/number02.webp) no-repeat !important;
      background-size: 30px 50px !important;
      background-position: 0px center !important;
    }

    .num_feature3 {
      background: transparent url(img/number03.webp) no-repeat !important;
      background-size: 30px 50px !important;
      background-position: 0px center !important;
    }

    .num_feature4 {
      background: transparent url(img/number04.webp) no-repeat !important;
      background-size: 30px 50px !important;
      background-position: 0px center !important;
    }

    .num_feature5 {
      background: transparent url(img/number05.webp) no-repeat !important;
      background-size: 30px 50px !important;
      background-position: 0px center !important;
    }

    .num_feature1,
    .num_feature2,
    .num_feature3,
    .num_feature4,
    .num_feature5 {
      color: black !important;
      line-height: 2;
      margin-top: 30px !important;
      margin-bottom: 20px !important;
      min-height: 50px;
      padding-left: 66px !important;
      padding-top: 4px !important;
      font-size: 17px !important;
      align-items: center;
      font-size: 20px;
      margin-top: 20px;
    }

    .flex-item.item img {
      width: 100%;
    }

    table.table-border {
      width: 100%;
      border-collapse: collapse;
    }

    table.table-border td {
      border: 1px solid black;
    }

    .w-20 {
      width: 20%;
    }

    .text-center {
      text-align: center;
    }

    .flex-border .flex-item.item {
      /* Adjust the width as needed */
      border: 0.25px solid black;
      padding: 10px;
      box-sizing: border-box;
      padding: 2px;
      width: 30%;
      font-size: 12px;
      display: grid;
      align-content: space-between;
    }

    .flex-item.item.w-20.text-center {
      width: 20%;
    }

    .pl-1 {
      padding: 10px;
      width: calc(50% - 20px) !important;
    }

    .flex-container {
      justify-content: flex-start;
    }

    .download_templete .modal-content.data {
      width: 30%
    }

    @media(max-width: 768px) {
      .download_templete .modal-content.data {
        width: 90%
      }
    }

    .w-100 {
      width: 100% !important;
    }

    .w-50 {
      width: 50%;
    }

    .justify-between {
      justify-content: space-between;
    }

    .sm-bold {
      font-family: IwaUDGoDspPro-Eb, sans-serif !important;
      margin-top: 10px;
    }

    .prd-selection .part-name {
      padding-left: 5px;
    }

    .prd-selection label:before {
      content: "";
      height: 31px;
      position: absolute;
      right: 7px;
      top: 3px;
      width: 22px;
      background: #fff;
      border-top-right-radius: 3px;
      border-bottom-right-radius: 3px;
      pointer-events: none;
      display: block;
    }

    .prd-selection label:after {
      content: " ";
      position: absolute;
      left: calc(30% + 25px);
      top: 46%;
      margin-top: -3px;
      z-index: 2;
      pointer-events: none;
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 6.9px 4px 0 4px;
      border-color: #aaa transparent transparent transparent;
      pointer-events: none;
    }

    .prd-selection label select {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      padding: 0 30px 0 10px;
      border: 1px solid #e0e0e0;
      border-radius: 3px;
      line-height: 28px;
      height: 28px;
      background: #fff;
      width: 30%;
    }

    .prd-selection select::-ms-expand {
      display: none;
    }

    @media (max-width: 576px) {
      .container-cloud .justify-content-between {
        flex-direction: column;
        text-align: center;
      }

      .container-cloud .d-flex.justify-content-between p {
        margin: 0px !important;
      }

      .mt-12 {
        min-width: 100%;
      }

      .table_rubber td:nth-child(odd) {
        width: 25%;
      }
    }

    .d-flex {
      display: flex;
    }

    .d-flex.justify-content-between a.btn {
      background: #5b9bd5;
      width: 49%;
      height: 35px;
      text-decoration: none;
      color: white;
      font-size: 20px;
      text-align: center;
      line-height: 2;
      border-radius: 5px;
    }

    .d-flex.justify-content-between a.btn:hover {
      opacity: 0.8;
    }

    .d_TEXT1 {
      line-height: 1.5;
    }

    .ballroon {
      left: 100%;
      position: absolute;
      top: -16px;
    }

    a .ballroon .inner {
      white-space: nowrap;
      position: relative;
      white-space: nowrap;
      background-color: #ff9900;
      color: #ffffff;
      border: 1px solid #8d5500;
      font-size: 10px;
      border-radius: 32px;
      line-height: 1.33;
      padding: 1px 8px;

    }

    a .ballroon .inner:after {
      content: '';
      position: absolute;
      transform: rotate(65deg);
      z-index: 1;
      width: 6px;
      height: 6px;
      border-right: 1px solid #653d00f5;
      display: inline-block;
      border-bottom: 1px solid #653d00f5;
      background-color: #ff9900;
      border-top: none;
      border-left: none;
      bottom: -3px;
      left: 6%;
      z-index: 0;
    }

    .table_rubber_final td:nth-child(odd) {
      width: 35%;
      height: 50px;
    }

    .table_rubber_final td:last-child {
      width: 65%;
    }

    .flex-item .btn {
      flex: unset;
    }

    .flex-item.w-30 {
      flex: 0 0 30%;
      margin-bottom: 0;
    }

    .flex-item.w-70 {
      flex: 0 0 70%;
      max-width: 68%;
      margin: auto;
    }

    .unlink {
      color: #000 !important;
      text-decoration: none !important;
    }

    .repeat input[type="text"] {
        padding: 5px 10px;
        margin-left: -32px;
        width: -webkit-fill-available;
    }

    <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
  </style>
  <script>
    $(document).ready(function() {
      $("#open1").click(function() {
        $("#slide1").slideToggle("slow");
      });
    });
  </script>
  <!-- lightbox2-master -->
  <link rel="stylesheet" href="css/lightbox.css">
  <!-- /lightbox2-master -->

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
    .red {
      color: red;
      font-weight: bold;
      font-size: 14px;
    }
  </style>
</head>

<body id="top">
  <!-- :: header start :: -->
  <?php include('../header.html'); ?>
  <!-- :: header end :: -->

  <!-- globalNavi -->
  <?php include('../gnavi.php'); ?>
  <!-- globalNavi End -->

  <!-- :: wrapper start :: -->
  <div id="wrapper">

    <!-- sidemenu-->

    <?php $prd_cloth="1";include('../sidenavi.php'); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
      <?php //include('../global_news.html'); 
      ?>
      <h1><?= lang('オリジナルマイクロファイバークロス　柔らかいスウェード生地') ?></h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=オリジナルメガネクロス&amp;body=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。:https://hotmobily.jp/products/cloth.php" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a><a href="mailto:?subject=オリジナルメガネクロス&amp;body=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。:https://hotmobily.jp/products/cloth.php" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fcloth.php" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fcloth.php&amp;text=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
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
      <div style="clear:both;">&nbsp;</div>

      <div class="flex-container">
        <div class="flex-item item">
          <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
            <swiper-slide><img src="img/mki_pic_18.webp"></swiper-slide>
            <swiper-slide><img src="img/mki_pic_43.webp"></swiper-slide>
            <swiper-slide><img src="img/mki_pic_31.webp"></swiper-slide>
            <swiper-slide><img src="img/mki_pic_24.webp"></swiper-slide>
          </swiper-container>
        </div>
        <div class="flex-item item" style="display:grid;align-content: center;line-height: 2;padding:5px;">
          <p>スウェード生地のマイクロファイバークロス。手触りは柔らかく、厚みもあります。バージン材とリサイクル材の2種類からお選びいたけます。
            両面ともフルカラー両面印刷が可能。グラデーションや多色のデザインも印刷することができます。織物製品のため、立ち落としではなく、メロー加工があります。
            ハンドタオルのサイズ感は、持ち歩きにもぴったり。メガネケースの中に常備しておくこともできます。最小ロットは100枚。展示会やイベント等のノベルティとしてもご利用いただけます。
            メガネだけではなく、スマートフォン、カメラ、手鏡などのケアにぴったりです。</p>
        </div>
      </div>
      <div style="clear:both;"></div>

      <h2>オリジナルマイクロファイバークロス（スウェード生地）の特徴</h2>
      <h2 class="feature1">小さく畳んでもしわになりにくい、厚みのあるスウェード生地</h2>
      <div class="flex-container">
        <div class="flex-item item">
          <a href="img/mki_pic_38.webp" data-lightbox="pic_set_1_1" data-title="" style="text-decoration:none;">
            <img src="img/mki_pic_38.webp">
          </a>
        </div>
        <div class="flex-item item">
          <a href="img/mki_pic_33.webp" data-lightbox="pic_set_1_1" data-title="" style="text-decoration:none;">
            <img src="img/mki_pic_33.webp">
          </a>
        </div>
      </div>
      <p>柔らかくて厚みのあるスウェード生地なので、小さく畳んでもしわになりにくく、高級感も楽しめます。また、裏に印刷した場合にも、生地に厚みがあるため表に透けることがありません。</p>

      <h2 class="feature2">側面の縫製は、丈夫なメロー加工</h2>
      <div class="flex-container">
        <div class="flex-item item">
          <a href="img/mki_pic_37.webp" data-lightbox="pic_set_2_1" data-title="" style="text-decoration:none;">
            <img src="img/mki_pic_37.webp">
          </a>
        </div>
        <div class="flex-item item">
          <a href="img/mki_pic_29.webp" data-lightbox="pic_set_2_1" data-title="" style="text-decoration:none;">
            <img src="img/mki_pic_29.webp">
          </a>
        </div>
      </div>
      <p>側面の縫製は上部なメロー加工を採用しているため、屋外などのハードな環境でも安心してご利用いただけます。</p>

      <h2 class="feature3">綺麗なカラー印刷やシルク印刷が可能！バージン材ならエンボス加工も</h2>
      <div class="flex-container">
        <div class="flex-item item">
          <a href="img/mki_pic_41.webp" data-lightbox="pic_set_3_1" data-title="" style="text-decoration:none;">
            <img src="img/mki_pic_41.webp">
          </a>
        </div>
        <div class="flex-item item">
          <a href="img/mki_pic_28.webp" data-lightbox="pic_set_3_1" data-title="" style="text-decoration:none;">
            <img src="img/mki_pic_28.webp">
          </a>
        </div>
      </div>
      <p>裏表ともカラー印刷が可能なうえ、シルク印刷（一色のみ）もできます。バージン材はデザインに立体感が出るエンボス加工も施すことができます。文字の印刷も可能ですので、例えば裏面に会社情報を記載するなど、ノベルティとしてもご活用いただけます。</p>

      <h2 class="feature4">洗濯・乾燥機も安心してご利用いただけます</h2>
      <img src="img/washing.webp">
      <p>汚れた時は、洗濯機で洗っていただけます。また、乾燥機のご利用も可能。洗濯機や乾燥機を使用しても性能が落ちることはございません。</p>

      <div style="clear:both;">&nbsp;</div>
      <img src="img/mki_review.webp">

      <h2>製品仕様</h2>
      <table class="table-border">
        <tr>
          <td>名称</td>
          <td>マイクロファイバークロス　スウェード生地</td>
        </tr>
        <tr>
          <td>素材</td>
          <td>
            MKI（バージン材）<br />
            MKI50（リサイクル材）
          </td>
        </tr>
        <tr>
          <td>重さ</td>
          <td>200g</td>
        </tr>
        <tr>
          <td>サイズ</td>
          <td>
            <img src="img/mki_size_sample02.webp"><br />
            <img src="img/mki_size_sample01.webp"><br />
            <p>その他ご指定のサイズがあればお問合せ下さい。正方形、長方形以外の形状もお請け致します。</p>
          </td>
        </tr>
        <tr>
          <td>印刷加工</td>
          <td>
            ・昇華転写印刷（片面、両面）<br />
            ・シルクスクリーン印刷（型代別料金）<br />
            ・エンボス加工（型代別料金）★バージン材のみ<br />
            ・縫製：メロー加工
          </td>
        </tr>
        <tr>
          <td>最小ロット</td>
          <td>100枚（シルク印刷、エンボス加工は300枚から）</td>
        </tr>
        <tr>
          <td>包装</td>
          <td>
            ・一括包装<br />
            ・個別OPP包装（11円（税込）／枚の追加料金が発生いたします）
          </td>
        </tr>
        <tr>
          <td>台紙</td>
          <td>
            既製品：50種類のデータから選択可<br />
            オリジナル印刷：お客様の入稿データを使用し、印刷します <br />
            支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。
          </td>
        </tr>
      </table>

      <h2>生地のカラーバリエーション</h2>

      <div class="flex-container">
        <div class="flex-container w-50">
          <img src="img/mki_mat_color_banner.webp?v=1.01" style="width: 100%;">
        </div>
        <div class="flex-container flex-border pl-1 w-50">
          <p>バージン材の転写印刷は、白の生地となります。シルク印刷とエンボス加工の生地は、黒・ダークグレー・ライトグレー・ライトブルー・白の計5色からお選びいただけます。リサイクル材は白のみとなっています。</p>
          <div class="flex-item item text-center">
            01LUNOR BROWN<br />
            <a href="img/mat_black.webp" data-lightbox="pic_set_3_1" data-title="" style="text-decoration:none;">
              <img src="img/mat_black.webp">
            </a>
          </div>
          <div class="flex-item item text-center">
            02LUNOR DARK GRAY<br />
            <a href="img/mat_dark_gray.webp" data-lightbox="pic_set_3_1" data-title="" style="text-decoration:none;">
              <img src="img/mat_dark_gray.webp">
            </a>
          </div>
          <div class="flex-item item text-center">
            03LIGHT GRAY<br />
            <a href="img/mat_gray.webp" data-lightbox="pic_set_3_1" data-title="" style="text-decoration:none;">
              <img src="img/mat_gray.webp">
            </a>
          </div>
          <div class="flex-item item text-center">
            04LIGHT BLUE<br />
            <a href="img/mat_light_blue.webp" data-lightbox="pic_set_3_1" data-title="" style="text-decoration:none;">
              <img src="img/mat_light_blue.webp">
            </a>
          </div>
          <div class="flex-item item text-center">
            05WHITE<br />
            <a href="img/mat_white.webp" data-lightbox="pic_set_3_1" data-title="" style="text-decoration:none;">
              <img src="img/mat_white.webp">
            </a>
          </div>
        </div>
      </div>

      <h2>メロー加工の糸カラーバリエーション</h2>
      <img src="img/mki_color_banner.webp?v=1.01">
      <div style="clear:both;">&nbsp;</div>
      <p>側面の縫製に仕様する糸の色は、18色からお選びいただけます。</p>
      <div class="flex-container flex-border">
        <div class="flex-item item w-20 text-center">
          01白色<br />
          <a href="img/color_white.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_white.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          04ピンク(2)<br />
          <a href="img/color_pink.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_pink.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          06赤色<br />
          <a href="img/color_red.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_red.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          09黄色(2)<br />
          <a href="img/color_yellow.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_yellow.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          11黄緑(2)<br />
          <a href="img/color_yellow_green.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_yellow_green.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          13深緑<br />
          <a href="img/color_dark_green.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_dark_green.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          14水色<br />
          <a href="img/color_light_blue.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_light_blue.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          16青色(1)<br />
          <a href="img/color_blue.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_blue.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          18紺色<br />
          <a href="img/color_dark_blue.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_dark_blue.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          20青紫<br />
          <a href="img/color_blue_purple.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_blue_purple.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          21紫色<br />
          <a href="img/color_purple.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_purple.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          22ライラック<br />
          <a href="img/color_lilac.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_lilac.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          24茶色<br />
          <a href="img/color_brown.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_brown.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          26オレンジ<br />
          <a href="img/color_orange.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_orange.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          27灰色(1)<br />
          <a href="img/color_light_gray.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_light_gray.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          28灰色(2)<br />
          <a href="img/color_gray.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_gray.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          29黒色<br />
          <a href="img/color_black.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_black.webp">
          </a>
        </div>
        <div class="flex-item item w-20 text-center">
          30灰色(3)<br />
          <a href="img/color_dark_gray.webp" data-lightbox="pic_set_4_1" data-title="" style="text-decoration:none;">
            <img src="img/color_dark_gray.webp">
          </a>
        </div>
      </div>

      <h2>テンプレート</h2>
      <p>バージン材</p>
      <div class="flex-container justify-between">
        <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
          <span>150mm×150mm</span>
        </a>
        <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
          <span>150mm×180mm</span>
        </a>
      </div>

      <div style="clear: both;">&nbsp;</div>
      <p>リサイクル材</p>
      <div class="flex-container justify-between">
        <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
          <span>150mm×150mm</span>
        </a>
        <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
          <span>150mm×180mm</span>
        </a>
      </div>

      <div class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3><?= lang('オリジナルマイクロファイバークロス（スウェード生地）') ?>【Illustrator】</h3>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=①Template_microfiber_150X150mm_MKI.pdf">
                    <div><img class="lazy" data-src="/products/acrylic/img/pdf-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_150X150mm_MKI.ai">
                    <div><img class="lazy" data-src="/products/acrylic/img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3><?= lang('オリジナルマイクロファイバークロス（スウェード生地）') ?>【Illustrator】</h3>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=②Template_microfiber_180X150mm_MKI.pdf">
                    <div><img class="lazy" data-src="/products/acrylic/img/pdf-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_180X150mm_MKI.ai">
                    <div><img class="lazy" data-src="/products/acrylic/img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3><?= lang('オリジナルマイクロファイバークロス（スウェード生地）') ?>【Illustrator】</h3>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=③Template_microfiber_150X150mm_MKI-50.pdf">
                    <div><img class="lazy" data-src="/products/acrylic/img/pdf-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_150X150mm_MKI-50.ai">
                    <div><img class="lazy" data-src="/products/acrylic/img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3><?= lang('オリジナルマイクロファイバークロス（スウェード生地）') ?>【Illustrator】</h3>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=④Template_microfiber_180X150mm_MKI-50.pdf">
                    <div><img class="lazy" data-src="/products/acrylic/img/pdf-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_180X150mm_MKI-50.ai">
                    <div><img class="lazy" data-src="/products/acrylic/img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <?php include("campaign_news.php"); ?>
      <hr>

      <h2>製作料金</h2>
      <p>バージン材</p>
      <div class="exceed-table">
        <table width="99%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
          <tr>
            <td colspan="2" class="" align="center"></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">100<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">300<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">500<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">1,000<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">3,000<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">5,000<?= lang('枚') ?></td>
          </tr>
          <tr>
            <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF">片面</td>
            <td class="" align="center" bgcolor="#EFEFEF">150x150</td>
            <td class="" align="center">292</td>
            <td class="" align="center">246</td>
            <td class="" align="center">208</td>
            <td class="" align="center">165</td>
            <td class="red" align="center">136</td>
            <td class="red" align="center">131</td>
          </tr>
          <tr>
            <td class="" align="center" bgcolor="#EFEFEF">150X180</td>
            <td class="" align="center">318</td>
            <td class="" align="center">272</td>
            <td class="" align="center">231</td>
            <td class="" align="center">184</td>
            <td class="red" align="center">155</td>
            <td class="red" align="center">147</td>
          </tr>
          <tr>
            <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF">両面</td>
            <td class="" align="center" bgcolor="#EFEFEF">150X150</td>
            <td class="" align="center">321</td>
            <td class="" align="center">277</td>
            <td class="" align="center">239</td>
            <td class="" align="center">194</td>
            <td class="red" align="center">162</td>
            <td class="red" align="center">156</td>
          </tr>
          <tr>
            <td class="" align="center" bgcolor="#EFEFEF">150X180</td>
            <td class="" align="center">347</td>
            <td class="" align="center">299</td>
            <td class="" align="center">262</td>
            <td class="" align="center">210</td>
            <td class="red" align="center">180</td>
            <td class="red" align="center">168</td>
          </tr>
          <tr>
            <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF">エンボス</td>
            <td class="" align="center" bgcolor="#EFEFEF">150X150</td>
            <td class="" align="center"></td>
            <td class="" align="center">216</td>
            <td class="" align="center">185</td>
            <td class="" align="center">147</td>
            <td class="red" align="center">121</td>
            <td class="red" align="center">112</td>
          </tr>
          <tr>
            <td class="" align="center" bgcolor="#EFEFEF">150X180</td>
            <td class="" align="center"></td>
            <td class="" align="center">233</td>
            <td class="" align="center">201</td>
            <td class="" align="center">158</td>
            <td class="red" align="center">135</td>
            <td class="red" align="center">125</td>
          </tr>
          <tr>
            <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF">シルク</td>
            <td class="" align="center" bgcolor="#EFEFEF">150X150</td>
            <td class="" align="center"></td>
            <td class="" align="center">188</td>
            <td class="" align="center">160</td>
            <td class="" align="center">127</td>
            <td class="red" align="center">107</td>
            <td class="red" align="center">99</td>
          </tr>
          <tr>
            <td class="" align="center" bgcolor="#EFEFEF">150X180</td>
            <td class="" align="center"></td>
            <td class="" align="center">208</td>
            <td class="" align="center">178</td>
            <td class="" align="center">142</td>
            <td class="red" align="center">119</td>
            <td class="red" align="center">110</td>
          </tr>
        </table>
      </div>
      ※エンボス加工の場合、版型料金7,700円（税込）が追加となります。<br />
      ※シルク印刷の場合、版型料金4,950円（税込）が追加となります。<br /><br />

      <p>リサイクル材</p>
      <div class="exceed-table">
        <table width="99%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
          <tr>
            <td colspan="2" class="" align="center"></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">100<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">300<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">500<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">1,000<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">3,000<?= lang('枚') ?></td>
            <td class="" align="center" bgcolor="#EFEFEF" width="10%">5,000<?= lang('枚') ?></td>
          </tr>
          <tr>
            <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF">片面</td>
            <td class="" align="center" bgcolor="#EFEFEF">150x150</td>
            <td class="" align="center">306</td>
            <td class="" align="center">255</td>
            <td class="" align="center">218</td>
            <td class="" align="center">173</td>
            <td class="red" align="center">144</td>
            <td class="red" align="center">136</td>
          </tr>
          <tr>
            <td class="" align="center" bgcolor="#EFEFEF">150X180</td>
            <td class="" align="center">332</td>
            <td class="" align="center">285</td>
            <td class="" align="center">242</td>
            <td class="" align="center">194</td>
            <td class="red" align="center">162</td>
            <td class="red" align="center">154</td>
          </tr>
          <tr>
            <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF">両面</td>
            <td class="" align="center" bgcolor="#EFEFEF">150X150</td>
            <td class="" align="center">330</td>
            <td class="" align="center">286</td>
            <td class="" align="center">246</td>
            <td class="" align="center">199</td>
            <td class="red" align="center">166</td>
            <td class="red" align="center">162</td>
          </tr>
          <tr>
            <td class="" align="center" bgcolor="#EFEFEF">150X180</td>
            <td class="" align="center">358</td>
            <td class="" align="center">310</td>
            <td class="" align="center">274</td>
            <td class="" align="center">220</td>
            <td class="red" align="center">186</td>
            <td class="red" align="center">176</td>
          </tr>
          <tr>
            <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF">シルク</td>
            <td class="" align="center" bgcolor="#EFEFEF">150X150</td>
            <td class="" align="center"></td>
            <td class="" align="center">199</td>
            <td class="" align="center">169</td>
            <td class="" align="center">134</td>
            <td class="red" align="center">112</td>
            <td class="red" align="center">105</td>
          </tr>
          <tr>
            <td class="" align="center" bgcolor="#EFEFEF">150X180</td>
            <td class="" align="center"></td>
            <td class="" align="center">219</td>
            <td class="" align="center">188</td>
            <td class="" align="center">150</td>
            <td class="red" align="center">125</td>
            <td class="red" align="center">117</td>
          </tr>
        </table>
      </div>
      ※シルク印刷の場合、版型料金4,950円（税込）が追加となります。<br /><br />
      <!-- Estimate 03/21/2018 -->
      <hr>

      <h2><?= lang('納期（製作期間）') ?></h2>
      <div style="clear: both;"></div>
      <p class="d_TEXT1"><?= lang('納期=製作日数+配送日数で計算致します。') ?></p><br />
      <p class="d_TEXT1">【<?= lang('製作期間') ?>】</p>
      ◆製作期間（単位：営業日。配送日数は含まず）
      <table width="99%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr align="center">
          <td>&nbsp;</td>
          <td align="center">100個</td>
          <td align="center">300個</td>
          <td align="center">500個</td>
          <td align="center">1000個</td>
          <td align="center">3000個</td>
          <td align="center">5000個</td>
        </tr>
        <tr>
          <td>試作品製作日数</td>
          <td align="center" colspan="6">8</td>
        </tr>
        <tr>
          <td>量産品製作日数</td>
          <td align="center">9</td>
          <td align="center">11</td>
          <td align="center">13</td>
          <td align="center">16</td>
          <td align="center">20</td>
          <td align="center">23</td>
        </tr>
      </table><br />

      <h2>ご注文の流れ</h2>
      <h3 class="num_feature1">下記の「<span class="sm-bold">ご注文・御見積書作成</span>」<span class="sm-bold">フォーム</span>に必要事項をご入力ください。印刷の<span class="sm-bold">デザインデータ</span>は、アドビイラストレータでの作成を推奨いたします。なお、写真やイラストでも可能です。その場合、印刷品質上、400dpi以上の解像度を推奨いたします。</h3>
      <div style="clear:both;">&nbsp;</div>

      <h3 class="num_feature2">弊社にてデザイン校正を行った後、最終的にお客様に<span class="sm-bold">デザインを確</span>定していただきます。概算お見積りと製作価格が異なる場合は、最終お見積りをお送りいたします。</h3>
      <div style="clear:both;">&nbsp;</div>

      <h3 class="num_feature3">製作料金を<span class="sm-bold">お支払い</span>ください。</h3>

      <div class="text-center">
        <p class="sm-bold">支払い方法</p>
      </div>
      <div class="flex-container">
        <div class="flex-item item text-center">
          <p>①クレジットカード決済</p>
          <img src="img/creditcard.webp" class="w-50">
        </div>
        <div class="flex-item item text-center">
          <p>②銀行振込</p>
          <img src="img/bookbank.webp">
        </div>
      </div>
      <div class="text-center">
        <p>デザイン校正とお支払いが完了した時点で、製作開始となります。</p>
      </div>

      <div style="clear:both;">&nbsp;</div>

      <h3 class="num_feature4">試作品をご注文の場合は、<span class="sm-bold">試作品</span>をご送付しますので<span class="sm-bold">ご確認</span>ください。<span class="sm-bold">ご注文個数に応じた量産 へと進み</span>確定納期をご連絡いたします。（試作品のご注文がない場合、量産のみとなります。）</h3>
      <div style="clear:both;">&nbsp;</div>

      <h3 class="num_feature5">宅急便にて配送し、<span class="sm-bold">ご納品</span>となります。 発送完了時に【ご注文製品出荷完了のご連絡】をお送りいたします。</h3>
      <img src="img/delivery_man.webp" class="w-50">
      <div style="clear:both;">&nbsp;</div>

      <div style="clear:both;"></div>
      <div id="info_div" style="margin-top: 10px;"></div>
      <h2 id="est-content"><?= lang('ご注文・見積書作成') ?></h2>

      <?php include('campaign_banner.php') ?>

      <span style="font-size: 12px;">※<?= lang('一つのデザインにつき一注文となります。複数のデザインがある場合、それぞれのデザインで別々にご注文ください。') ?></span>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('オリジナルマイクロファイバークロス（スウェード生地）') ?>】</h3>
          <span class="total-price"><span class="prd_total">0</span>円<?= lang('（税込）') ?></span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td><?= lang('ご注文タイプ') ?></td>
                <td><span id="sample-prd-prdt"></span></td>
              </tr>
              <tr>
                <td><?= lang('サイズ') ?></td>
                <td><span id="sample-prd-size"></span></td>
              </tr>
              <tr>
                <td><?= lang('生地色') ?></td>
                <td><span id="sample-prd-color"></span></td>
              </tr>
              <tr>
                <td><?= lang('メロー加工の糸色') ?></td>
                <td><span id="sample-prd-sewing-color"></span></td>
              </tr>
              <tr>
                <td><?= lang('数量') ?></td>
                <td><span id="sample-prd-qty"></span></td>
              </tr>
              <tr>
                <td><?= lang('実物校正サンプル') ?></td>
                <td><span id="sample-prd-samp"></span></td>
              </tr>
              <tr>
                <td><?= lang('OPP個別包装') ?></td>
                <td><span id="sample-prd-opp"></span></td>
              </tr>
            </table>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="img/cth1.webp" id="type-part-pic" style="max-width: 265px!important;" width="250" height="118"><br />
          </div>
          <div class="step-box line2" style="text-align: center;">
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ・サイズ・印刷面') ?></span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div><span class="step-details"><?= lang('実物校正サンプル・OPP個別包装') ?></span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="オリジナルマイクロファイバークロス（スウェード生地）" />
          </div>
          <?php
          switch ($item_type) {
            case 'バージン材':
              $ItemType0 = "checked";
              break;
            case 'リサイクル材':
              $ItemType1 = "checked";
              break;
            default:
              $ItemType0 = "checked";
              break;
          }
          switch ($cth_type) {
            case '昇華転写片面印刷':
              $cth_type0 = "checked";
              break;
            case '昇華転写両面印刷':
              $cth_type1 = "checked";
              break;
            case '1色印刷（シルクスクリーン）':
              $cth_type2 = "checked";
              break;
            case 'エンボス加工':
              $cth_type3 = "checked";
              break;
            default:
              $cth_type0 = "checked";
              break;
          }
          switch ($cth_size) {
            case '150':
              $cth_size0 = "checked";
              break;
            case '180':
              $cth_size1 = "checked";
              break;
            default:
              $cth_size0 = "checked";
              break;
          }
          //Setup sample data
          switch ($cth_sample) {
            case 'あり':
              $sample = "checked";
              break;
          }
          //Setup trace data
          switch ($cth_opp) {
            case 'あり':
              $opp = "checked";
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
            
            <h3><?= lang('素材タイプ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="item_type" value="バージン材" onclick="check_val('next')" <?= $ItemType0 ?>>バージン材<span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="item_type" value="リサイクル材" onclick="check_val('next')" <?= $ItemType1 ?>>リサイクル材<span class="checkmark"></span></label>
              </div>
            </div>
            <h3><?= lang('注文製品タイプ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_type" value="昇華転写片面印刷" onclick="check_val('next')" <?= $cth_type0 ?>><?= lang('昇華転写片面印刷') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_type" value="昇華転写両面印刷" onclick="check_val('next')" <?= $cth_type1 ?>><?= lang('昇華転写両面印刷') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_type" value="1色印刷（シルクスクリーン）" onclick="check_val('next')" <?= $cth_type2 ?>><?= lang('1色印刷（シルクスクリーン）') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_type" id="cth_type3" value="エンボス加工" onclick="check_val('next')" <?= $cth_type3 ?>><?= lang('エンボス加工') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>

            <h3><?= lang('生地色') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_color" value="01LUNOR BROWN" onclick="check_val('next')" <?= ($cth_color == "01LUNOR BROWN" ? 'checked' : ($cth_color == "" ? 'checked' : '')) ?>>
                  <?= lang('01LUNOR BROWN') ?> <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_color" value="02LUNOR DARK GRAY" onclick="check_val('next')" <?= ($cth_color == "02LUNOR DARK GRAY" ? 'checked' : '') ?>>
                  <?= lang('02LUNOR DARK GRAY') ?> <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_color" value="03LIGHT GRAY" onclick="check_val('next')" <?= ($cth_color == "03LIGHT GRAY" ? 'checked' : '') ?>>
                  <?= lang('03LIGHT GRAY') ?> <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_color" value="04LIGHT BLUE" onclick="check_val('next')" <?= ($cth_color == "04LIGHT BLUE" ? 'checked' : '') ?>>
                  <?= lang('04LIGHT BLUE') ?> <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="cth_color" value="05WHITE" onclick="check_val('next')" <?= ($cth_color == "05WHITE" ? 'checked' : '') ?>>
                  <?= lang('05WHITE') ?> <span class="checkmark"></span>
                </label>
              </div>
            </div>

            <h3><?= lang('メロー加工の糸色') ?></h3>
            <div class="part-container">
              <div class="part-content prd-selection">
                <label class="part-name ">
                  <select name="cth_sewing_color" onchange="check_val('next')">
                    <option value="01白色" <?= ($cth_sewing_color == "01白色" ? 'selected' : '') ?>>01白色</option>
                    <option value="04ピンク(2)" <?= ($cth_sewing_color == "04ピンク(2)" ? 'selected' : '') ?>>04ピンク(2)</option>
                    <option value="06赤色" <?= ($cth_sewing_color == "06赤色" ? 'selected' : '') ?>>06赤色</option>
                    <option value="09黄色(2)" <?= ($cth_sewing_color == "09黄色(2)" ? 'selected' : '') ?>>09黄色(2)</option>
                    <option value="11黄緑(2)" <?= ($cth_sewing_color == "11黄緑(2)" ? 'selected' : '') ?>>11黄緑(2)</option>
                    <option value="13深緑" <?= ($cth_sewing_color == "13深緑" ? 'selected' : '') ?>>13深緑</option>
                    <option value="14水色" <?= ($cth_sewing_color == "14水色" ? 'selected' : '') ?>>14水色</option>
                    <option value="16青色(1)" <?= ($cth_sewing_color == "16青色(1)" ? 'selected' : '') ?>>16青色(1)</option>
                    <option value="18紺色" <?= ($cth_sewing_color == "18紺色" ? 'selected' : '') ?>>18紺色</option>
                    <option value="20青紫" <?= ($cth_sewing_color == "20青紫" ? 'selected' : '') ?>>20青紫</option>
                    <option value="21紫色" <?= ($cth_sewing_color == "21紫色" ? 'selected' : '') ?>>21紫色</option>
                    <option value="22ライラック" <?= ($cth_sewing_color == "22ライラック" ? 'selected' : '') ?>>22ライラック</option>
                    <option value="24茶色" <?= ($cth_sewing_color == "24茶色" ? 'selected' : '') ?>>24茶色</option>
                    <option value="26オレンジ" <?= ($cth_sewing_color == "26オレンジ" ? 'selected' : '') ?>>26オレンジ</option>
                    <option value="27灰色(1)" <?= ($cth_sewing_color == "27灰色(1)" ? 'selected' : '') ?>>27灰色(1)</option>
                    <option value="28灰色(2)" <?= ($cth_sewing_color == "28灰色(2)" ? 'selected' : '') ?>>28灰色(2)</option>
                    <option value="29黒色" <?= ($cth_sewing_color == "29黒色" ? 'selected' : '') ?>>29黒色</option>
                    <option value="30灰色(3)" <?= ($cth_sewing_color == "30灰色(3)" ? 'selected' : '') ?>>30灰色(3)</option>
                  </select>
                </label>
              </div>
            </div>

            <h3><?= lang('製品サイズ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="cth_size" value="150" onclick="check_val('next');" <?= $cth_size0 ?>>150x150mm. <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="cth_size" value="180" onclick="check_val('next');" <?= $cth_size1 ?>>150x180mm. <span class="checkmark"></span></label>
              </div>
            </div>
            <h3><?= lang('数量') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" id="qty" onblur="check_val('next')" value="<?= $qty ?>"></label>
                <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?></div>
              </div>
            </div>
          </div>
          <div class="estimate-content" id="step2">
            <h3><?= lang('実物校正サンプル・OPP個別包装') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='cth_sample'>
                    <input type="checkbox" class="checkbox" name="cth_sample" value="あり" onclick="check_val('next');" <?= $sample ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>実物校正サンプル
                </label>
                <div class="error" id="sample-error"></div>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='cth_opp'>
                    <input type="checkbox" class="checkbox" name="cth_opp" value="あり" onclick="check_val('next');" <?= $opp ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>OPP個別包装
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
                      <td class="TableLeft"><?= lang('納期') ?></td>
                      <td class="" id="prd_production" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('サイズ') ?></td>
                      <td class="" id="prd_size" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('生地色') ?></td>
                      <td class="" id="prd_color" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('メロー加工の糸色') ?></td>
                      <td class="" id="prd_sewing_color" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('数量') ?></td>
                      <td class="" id="prd_amount" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('実物校正サンプル') ?></td>
                      <td class="" id="prd_sample" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('OPP個別包装') ?></td>
                      <td class="" id="prd_opp" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="flex-item">
                <h3><?= lang('製作料金') ?></h3>
                <table class="table_rubber total_price_tbl">
                  <tbody>
                    <tr>
                      <td class="TableLeft"><?= lang('版型代金') ?></td>
                      <td class=""><input id="prd_basic_price" type="text" name="prd_basic_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('製品代金') ?></td>
                      <td class=""><input id="prd_price" type="text" name="prd_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('実物校正サンプル代金') ?></td>
                      <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('OPP個別包装代金') ?></td>
                      <td class=""><input id="prd_opp_price" type="text" name="prd_opp_price" readonly>円</td>
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
                      <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="setzero();valid_chk_btn('step1');">
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step2');$('#cus_detail').hide();"><?= lang('オプション修正') ?></a>
                      <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle();">
                      <input type="button" class="btn ord-btn flex-item" value="ご注文情報入力へ" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form);">
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="acrylic-btn" class="btn-container">
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn('back')"><?= lang('戻る') ?></a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')"><?= lang('オプション入力へ') ?></a>
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
                <td class="TableLeft"><?= lang('郵便番号') ?> </td>
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
      <hr>

      <h2><?= lang('台紙の印刷、封入について') ?></h2>
      <p class="d_TEXT1"><?= lang('一般的な名刺サイズの台紙を製作し、オリジナルマイクロファイバークロスに同封することが可能です。') ?></p>
      <table width="380" border="0" cellpadding="0" cellspacing="8">
        <tr>
          <td align="center"><img src="img/card_03.webp" alt="台紙両面カラー" width="123" height="162" /></td>
          <td align="center"><img src="img/card_01.webp" alt="台紙片面カラー" width="98" height="160" /></td>
        </tr>
        <tr>
          <td align="center"><?= lang('両面カラー') ?></td>
          <td align="center"><?= lang('片面カラー<br />（片面は印刷なし）') ?></td>
        </tr>
      </table>
      <p class="d_TEXT1"><span class="taizen_b_txt"><?= lang('台紙') ?></span></p>
      <p class="d_TEXT1"><?= lang('用紙 : 両面コート紙220Kg<br/>印刷種別 : UV印刷<br/>サイズ : 140mmX100mm以内で製作してください') ?></p>
      <p class="d_TEXT1"><?= lang('台紙のみの製作料金を確認する場合、<a href="javascript:void(0)" id="open1">ここをクリック</a>してください。') ?></p>
      <div id="slide1" class="slideBox">
        <p class="d_TEXT1"><span class="taizen_b_txt"><?= lang('料金（台紙製作のみの料金です）') ?></span></p>
        <table width="710" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="tbl-1" style="margin-top:15px;border-collapse: collapse;">
          <tr align="center">
            <td rowspan="2"><?= lang('印刷部数') ?></td>
            <td colspan="2"><?= lang('カラー/カラー') ?></td>
            <td colspan="2"><?= lang('カラー/印刷なし') ?></td>
          </tr>
          <tr>
            <td align="center"><?= lang('1枚あたり単価(円)') ?></td>
            <td align="center"><?= lang('税込総額(円)') ?></td>
            <td align="center"><?= lang('1枚あたり単価(円)') ?></td>
            <td align="center"><?= lang('税込総額(円)') ?></td>
          </tr>
          <tr>
            <td align="center">100</td>
            <td align="center">46</td>
            <td align="center">4,600</td>
            <td align="center">44</td>
            <td align="center">4,400</td>
          </tr>
          <tr>
            <td align="center">200</td>
            <td align="center">29</td>
            <td align="center">5,800</td>
            <td align="center">28</td>
            <td align="center">5,600</td>
          </tr>
          <tr>
            <td align="center">300</td>
            <td align="center">24</td>
            <td align="center">7,200</td>
            <td align="center">23</td>
            <td align="center">6,900</td>
          </tr>
          <tr>
            <td align="center">400</td>
            <td align="center">20</td>
            <td align="center">8,000</td>
            <td align="center">19</td>
            <td align="center">7,600</td>
          </tr>
          <tr>
            <td align="center">500</td>
            <td align="center">17</td>
            <td align="center">8,500</td>
            <td align="center">16</td>
            <td align="center">8,000</td>
          </tr>
          <tr>
            <td align="center">600</td>
            <td align="center">17</td>
            <td align="center">10,200</td>
            <td align="center">16</td>
            <td align="center">9,600</td>
          </tr>
          <tr>
            <td align="center">700</td>
            <td align="center">15</td>
            <td align="center">10,500</td>
            <td align="center">14</td>
            <td align="center">9,800</td>
          </tr>
          <tr>
            <td align="center">800</td>
            <td align="center">15</td>
            <td align="center">12,000</td>
            <td align="center">14</td>
            <td align="center">11,200</td>
          </tr>
          <tr>
            <td align="center">900</td>
            <td align="center">14</td>
            <td align="center">12,600</td>
            <td align="center">13</td>
            <td align="center">11,700</td>
          </tr>
          <tr>
            <td align="center">1,000</td>
            <td align="center">14</td>
            <td align="center">14,000</td>
            <td align="center">13</td>
            <td align="center">13,000</td>
          </tr>
          <tr>
            <td align="center">1,500</td>
            <td align="center">14</td>
            <td align="center">21,000</td>
            <td align="center">13</td>
            <td align="center">19,500</td>
          </tr>
          <tr>
            <td align="center">2,000</td>
            <td align="center">14</td>
            <td align="center">28,000</td>
            <td align="center">13</td>
            <td align="center">26,000</td>
          </tr>
          <tr>
            <td align="center">2,500</td>
            <td align="center">14</td>
            <td align="center">35,000</td>
            <td align="center">13</td>
            <td align="center">32,500</td>
          </tr>
          <tr>
            <td align="center">3,000</td>
            <td align="center">14</td>
            <td align="center">42,000</td>
            <td align="center">13</td>
            <td align="center">39,000</td>
          </tr>
        </table>
        <p class="d_TEXT1"> <?= lang('上記料金は、OPP袋への個別包装、台紙封入料金込みの価格です。') ?></p>
      </div>
      <hr>

      <?php 
            $favor = "microfibercross";
            if (isset($favor) && ($favor)) {
                include 'product-faq-v2.php';
            }
        ?>

      <h2>この商品に関する記事</h2>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/promotional-giveaway-1"><img src="/blog-content/upload/202308241733194642.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/promotional-giveaway-1">人気の法人ノベルティは何？注意点と効果を最大化させるための工夫</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <!--<div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/originalgoods-aiservices"><img src="/blog-content/upload/202309071211157923.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/originalgoods-aiservices">AIを使ってオリジナルグッズが作れるって本当？AI画像生成おすすめサービス5選</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/howtomake-originalgoods"><img src="/blog-content/upload/202309281647114842.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/howtomake-originalgoods">オリジナルグッズの作り方・流れ・手順【HOTMOBILY】</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/howtomake-cheaper"><img src="/blog-content/upload/202310051309082634.jpg" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/howtomake-cheaper">知ってる人だけトクをする！オリジナルグッズを安く作る方法5選</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <hr> -->

    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../footer.php'); ?>
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
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.1"></script>
  <script language="JavaScript" src="../js/calculater_cth_mki.js?v=1.18" type="text/javascript"></script>
  <script type="text/javascript" src="js/pdf_cth_mki.js?v=1.21"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
  <script src="js/cloth_calendar.js?v="<?php echo date('is') ?>></script>
  <script type="text/javascript">
    $.ajax({
      type: "POST",
      url: "/products/check_holiday2.php",
      data: {
        "product": "オリジナルメガネクロス"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });
    $(function() {
      var s = $("#i_txt2");
      screen.width <= 768 && (s.attr("src", "images/text_sample_n1.svg"))
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
    check_val();
  </script>
</body>

</html>