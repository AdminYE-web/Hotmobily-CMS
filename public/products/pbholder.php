<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
//Read Modules
require_once('../control/Control_Rubber.php');
include_once('../common/Const.php');

include_once('../common/SetUpLang.php');

include_once('const_js.php');

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
  <meta name="keywords" content="ペットボトルホルダー,オリジナル,ゴム,ラバー,カラビナ,ホルダー,アウトドア">
  <meta name="description" content="オリジナルペットボトルホルダーの商品紹介。オリジナルデザインで製作(制作)できます。個数も嬉しい50個から製作可。">
  <meta name="robots" content="index,follow">
  <title>半立体ペットボトルホルダーをオリジナルで製作。小ロット・短納期OK</title>
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css?v=1.02" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <?php include("../head_products.html"); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
  <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">
  <link rel="stylesheet" type="text/css" href="css/scroll.css">
  <link href="/css/rubber.css?v=1.02" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
  <style type="text/css">
    <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
  </style>

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
  <style type="text/css">
    .mt-10-part {
      min-width: 23%;
      max-width: 23%
    }

    .mt-10-part div {
      text-align: center
    }

    .preview-sub .hover {
      max-width: 19.87%
    }

    .preview-top img,
    .preview-sub .hover img {
      width: 100%;
      height: 100%
    }

    .videoWrapper {
      margin-top: 0
    }

    .gall_pro {
      flex-flow: row wrap;
      justify-content: flex-start;
      padding: 0;
      margin-bottom: 10px;
      display: flex
    }

    .prodate {
      padding: 0 5px;
      text-align: center;
      font-weight: 700;
      background: linear-gradient(to bottom, #d66f21 10%, #ea8335 35%, #f58e41 100%);
      border-radius: 5px;
      color: #fff;
      font-size: 16px;
      width: 87%;
      margin: auto
    }

    .ZoomContainer {
      display: none
    }

    .tag-menu .tag-name {
      padding: 2px 12px;
      background: #f7b516;
      display: inline-block;
      margin: 5px 3px;
      border: 1px solid #f58904;
      color: #fff;
      margin-left: 0;
      text-decoration: none !important;
      border-radius: 15px;
    }

    .tag-menu .tag-name.active,
    .tag-menu .tag-name:not(.non-active):hover {
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

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
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


    /*new css*/
    a.btn.toggle-btn {
      display: block;
      background: lightblue;
      border-bottom: 1px white solid;
      color: red;
      font-size: 16px;
    }


    #date_create_sample1,
    #date_create_sample2 {
      font-size: 22px;
      font-weight: bold;
      color: red;
      letter-spacing: -1px;
      overflow: hidden;
    }

    .mt-10 {
      max-width: 100%;
    }

    .modal__inner {
      width: 770px;
    }

    @media(max-width: 576px) {
      div.howto+div {
        font-size: 5vw !important;
      }

      .modal__inner {
        width: 95%;
        padding: 1em;
      }
    }


    table.cld_tb {
      margin-top: 10px;
    }

    @-webkit-keyframes moving-gradient {
      0% {
        background-position: -250px 0;
      }

      100% {
        background-position: 250px 0;
      }
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
    }

    table.cld_tb {
      margin-top: 10px;
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
  </style>
  <script>
    $(document).ready(function() {
      $("#open1").click(function() {
        $("#slide1").slideToggle("slow");
      });
    });
  </script>
  <script src="/js/slider.js"></script>
  <!-- lightbox2-master -->
  <link rel="stylesheet" href="css/lightbox.css">
  <!-- /lightbox2-master -->
  <style type="text/css">
    .splide__track {
      padding: 5px 0;
    }

    .splide__slide {
      list-style: none;
      text-align: center;
    }

    .splide__slide a img {
      transition: all 0.2s ease-in-out;
      transition-duration: 0.2s;
      width: 90%;
      border-radius: 8px;
      border: 3px solid #dbdbda;
    }

    .splide__slide a:hover img {
      border: 3px solid #ff8000;
    }

    .splide__arrow--next {
      right: 0;
    }

    .splide__arrow--prev {
      left: 0;
    }

    #date_create_sample1,
    #date_create_sample2 {
      font-size: 22px;
      font-weight: bold;
      color: red;
      letter-spacing: -1px;
      overflow: hidden;
    }

    @media(max-width: 576px) {
      div.howto+div {
        font-size: 5vw !important;
      }
    }

    table.cld_tb {
      margin-top: 10px;
    }

    .repeat input[type="text"] {
        padding: 5px 10px;
        margin-left: -32px;
        width: -webkit-fill-available;
    }
  </style>
</head>

<body id="top">

  <!-- :: header start :: -->
  <?php include("../header.html");  ?>
  <!-- :: header end :: -->
  <!-- globalNavi -->
  <?php include("../gnavi.php"); ?>
  <!-- globalNavi End -->

  <!-- :: wrapper start :: -->
  <div id="wrapper">
    <!-- sidemenu-->
    <?php include("../sidenavi.php"); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
      <?php include("rubber_info.php"); ?>
      <?php include('banner-campaign.php') ?>
      <table width="260" border="0" cellspacing="0" cellpadding="0" align="right">
        <tr>
          <td valign="top-right">
          </td>
        </tr>
      </table>
      <h1>ペットボトルホルダー(2025年版)</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ペットボトルホルダー&amp;body=オリジナルペットボトルホルダーの商品紹介。オリジナルデザインで製作(制作)できます。個数も嬉しい50個から製作可。:https://hotmobily.jp/products/pbholder.html" title="Share by Email" target="_blank">シェアする</a><a href="mailto:?subject=ペットボトルホルダー&amp;body=オリジナルペットボトルホルダーの商品紹介。オリジナルデザインで製作(制作)できます。個数も嬉しい50個から製作可。:https://hotmobily.jp/products/pbholder.html" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fpbholder.html" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fpbholder.html&amp;text=オリジナルペットボトルホルダーの商品紹介。オリジナルデザインで製作(制作)できます。個数も嬉しい50個から製作可。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <img src="/products/images/rubber_feature_banner.webp?v=1.02">
      <div>&nbsp;</div>

        <h2>ラバー製品完全ガイドをご用意！</h2>
        <div>
            <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
        </div>
        <div>
            <p class="new-text">当店のペットボトルホルダーはラバー製品になります。「ラバー製品って素材は何なの？」「どんなものが作れるの？」などの疑問をお持ちの方もいるかと思います。</p><br>
            <p class="new-text">そんな方へ向けて、ラバー製品の素材やデザインの注意点、入稿データ作成などについての完全ガイドをご用意しました。</p><br>
            <p class="new-text">ベストな仕上がりのペットボトルホルダーを製作するのに、ぜひともお役立てください。</p>
            <br>
            <div style="text-align: right;">
                <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
            </div>
        </div>

      <div>&nbsp;</div>
      <h2>ペットボトルホルダーとは</h2>
      <p class="d_TEXT1 new-text">ペットボトルを引っ掛けて持ち運びの出来る便利アイテムです。カバンやベルトに簡単に取り付ける事ができます。製品は小さいですがとても頑丈に出来ていますので、様々なシーンでご活用頂けます。
      </p>
      <table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr align="center">
          <td valign="top" align="center"><a href="//hotstrap.jp/bottle.html" target="_blank"><img src="img/banner_PB_HM.webp" width="710" height="80"></a></td>
        </tr>
        <tr>
          <td valign="middle" bgcolor="#FFFFFF" align="center" class="process">
            首からぶら下げてペットボトルを持ち運びできるタイプのペットボトルホルダーをご希望のお客様はこちらからご確認下さい。</td>
        </tr>
      </table>
      <hr>
      <h2>オリジナルペットボトルホルダーの製作事例</h2>
      <div class="splide">
        <div class="splide__track">
          <ul class="splide__list">
            <li class="splide__slide">
              <a data-lightbox="pbhold-set" style="text-decoration:none;" href="slideimg/pbhold01.webp"><img src="slideimg/pbhold01_s.webp" width="231" height="173" alt=""></a>
            </li>
            <li class="splide__slide">
              <a data-lightbox="pbhold-set" style="text-decoration:none;" href="slideimg/pbhold02.webp"><img src="slideimg/pbhold02_s.webp" width="231" height="173" alt=""></a>
            </li>
            <li class="splide__slide">
              <a data-lightbox="pbhold-set" style="text-decoration:none;" href="slideimg/pbhold03.webp"><img src="slideimg/pbhold03_s.webp" width="231" height="173" alt=""></a>
            </li>
            <li class="splide__slide">
              <a data-lightbox="pbhold-set" style="text-decoration:none;" href="slideimg/pbhold04.webp"><img src="slideimg/pbhold04_s.webp" width="231" height="173" alt=""></a>
            </li>
            <li class="splide__slide">
              <a data-lightbox="pbhold-set" style="text-decoration:none;" href="slideimg/pbhold05.webp"><img src="slideimg/pbhold05_s.webp" width="231" height="173" alt=""></a>
            </li>
            <li class="splide__slide">
              <a data-lightbox="pbhold-set" style="text-decoration:none;" href="slideimg/pbhold06.webp"><img src="slideimg/pbhold06_s.webp" width="231" height="173" alt=""></a>
            </li>
          </ul>
        </div>
      </div>
      <hr>
      <h2>HOTMOBILYのオリジナルペットボトルホルダーの特長
      </h2>
      <ul class="new-text">
        <li>当店のオリジナルペットボトルホルダーはオリジナルのロゴデザイン・カラーで作製出来ます。
        </li>
        <li>注文本数は小ロット対応の100個～作製出来ます。
        </li>
        <li>製品の裏面には小さいオリジナルロゴやTEL番号、URLなどを印刷することができます。
        </li>
        <li>野外サークル活動やキャンプなどをご企画されているお客様にはお勧めのノベルティです。
        </li>
        <li>材質は 感触の柔らかいラバー素材（ATBC-PVC）になります。
        </li>
      </ul>
      <table width="412" border="0" cellpadding="0" cellspacing="7">
        <tr align="center">
          <td width="200"><img src="img/pb_photo01.webp" width="300" height="200" /></td>
          <td width="200"><img src="img/pb_photo02.webp" width="300" height="200" /></td>
        </tr>
      </table>
      <p class="d_TEXT1">ちょっと専門的になりますが、当店ではPVCの中でも安全性の高い
        ATBC-PVC（非フタル酸エステル系）のPVCを原料に使用しております。ATBC-PVCは通常のPVCと比較して、熱や経年劣化による変形や変色が少なく、PVC特有の
        ゴムの臭いも少ないのが特徴です。また、内分泌攪乱化学物質（いわゆる環境ホルモン）の影響も通常のPVCよりも少なくなっています。
      </p>
      <hr>
      <h2>ペットボトルホルダーの使用方法</h2>
      <p class="d_TEXT1 new-text">
        ウォーキング、登山、サイクリングだけではなくキャンプやバーベキューでも大活躍のペットボトルホルダー。当店のオリジナルペットボトルホルダーはカラビナが付いているのでリュックサックやベルトに簡単に取り付ける事ができます。最近ではベビーカーにつけている方もよく見かけます。ホルダーからペットボトルを片手で取り外せるのも小さいお子様が居るお客様には嬉しいですね。
      </p>
      <hr>
      <h2>オリジナルペットボトルホルダーの標準仕様</h2>
      <p class="d_TEXT1 new-text">
        当店のオリジナルペットボトルホルダーは全長約120mmになります。アルミ製のカラビナとホルダーが標準装備となります。※注文本数が3,000個以上の場合、紐やカラビナに色を付けることもご提案できます。
      </p>
      <table width="710" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td colspan="3" align="center"><img src="img/pb_specification01.jpg" width="660" height="301" style="max-width:100%;" /></td>
        </tr>
        <tr>
          <td><img src="img/pb_specification02.webp" width="220" height="181" /></td>
          <td><img src="img/pb_specification03.webp" width="220" height="181" /></td>
          <td><img src="img/pb_specification04.webp" width="220" height="181" /></td>
        </tr>
        <tr>
          <td><img src="img/pb_specification05.webp" width="220" height="181" /></td>
          <td><img src="img/pb_specification06.webp" width="220" height="181" /></td>
          <td><img src="img/pb_specification07.webp" width="220" height="181" /></td>
        </tr>
      </table>

      <hr>
      <h2>ペットボトルホルダーを注文しようと思ったら
      </h2>
      <p class="d_TEXT1 new-text">まず、ペットボトルホルダーの製作の価格を確認しましょう。製作料金10色までは同一価格でございます。10色以上をご検討の場合、事前にご相談ください。</p>
      <p class="d_TEXT1" align="center"><img src="img/colorscheme_pb.webp" width="393" height="267" /></p>
      <hr>
      <h2>オリジナルペットボトルホルダーの注文方法 </h2>
      <p class="d_TEXT1 new-text">
        ロゴ部分のデザインのご入稿をお願い致します。デザインはイラストレータデータにてご入稿をお願いしております。ペットボトルホルダーの製品サイズは横幅27mm縦幅35mmと厳密に決まっておりますのでご入稿後、弊社にて調整させて頂きます。テンプレートは<a href="img/HM_PBHolder_Template.pdf" target="_blank">こちら</a>からダウンロードできます。</p>
      <table width="710" border="0" cellpadding="0" cellspacing="4">
        <tr align="center">
          <td width="200" class="d_TEXT1"><img src="img/pb_specification08.webp" width="221" height="153" /></td>
          <td width="200" class="d_TEXT1"><img src="img/pb_specification09.webp" width="221" height="153" /></td>
          <td width="200" class="d_TEXT1"><img src="img/pb_specification10.webp" width="221" height="153" /></td>
        </tr>
        <tr valign="top">
          <td class="d_products_cap">製品のサイズは27mm縦幅35mm。
            微調整は弊社にてご提案致しますので、デザインはお気軽にご入稿下さい。</td>
          <td class="d_products_cap">この部分のデザインを入稿して下さい。
          </td>
          <td class="d_products_cap">はみ出しても製作出来ます。
          </td>
        </tr>
      </table>
      <p class="d_TEXT1 new-text">デザインはアドビイラストレータファイルでお送り頂くと、最も速く確認作業が完了します。PSDやJPEG、pdfなどイラストレータファイル以外の場合、製品の大きさの情報も記載してください。
      </p>

      <hr>
      <h2>オリジナルペットボトルホルダーの製作料金</h2>
      <?= lang('スタンダード') ?>
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td><?= lang('製品単価') ?></td>
            <td>985 円</td>
            <td>550 円</td>
            <td>410 円</td>
            <td>304 円</td>
            <td>234 円</td>
            <td>195 円</td>
          </tr>
          <tr align="center">
            <td><?= lang('税込総額') ?></td>
            <td>(98,500 円)</td>
            <td>(165,000 円)</td>
            <td>(205,000 円)</td>
            <td>(304,000 円)</td>
            <td>(702,000 円)</td>
            <td>(975,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('トレース代金は含まれておりません。') ?><br />
      </div>
      <div>&nbsp;</div>
      スタンダード（スピード発送）
      <div class="tbl_s" style="position: relative;">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1,106 円</td>
            <td>1,106 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(110,600 円)</td>
            <td>(221,200 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは200個となります。') ?><br />
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('汚れ防止加工はできません。') ?><br />
      </div>
      <div>&nbsp;</div>
      <?= lang('プレミアム') ?>
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td><?= lang('製品単価') ?></td>
            <td>1,271 円</td>
            <td>720 円</td>
            <td>558 円</td>
            <td>432 円</td>
            <td>349 円</td>
            <td>309 円</td>
          </tr>
          <tr align="center">
            <td><?= lang('税込総額') ?></td>
            <td>(127,100 円)</td>
            <td>(216,000 円)</td>
            <td>(279,000 円)</td>
            <td>(432,000 円)</td>
            <td>(1,047,000 円)</td>
            <td>(1,545,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('プレミアムでは、試作品、トレース代金は無料です。') ?><br />
      </div>
      <hr>
      <table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr align="center">
          <td valign="top" align="center"><a href="//hotstrap.jp/bottle.html" target="_blank"><img src="img/banner_PB_HM.webp" width="710" height="80" style="max-width: 100%;"></a></td>
        </tr>
        <tr>

          <td valign="middle" bgcolor="#FFFFFF" align="center" class="process">
            首からぶら下げてペットボトルを持ち運びできるタイプのペットボトルホルダーをご希望のお客様はこちらからご確認下さい。</td>
        </tr>
      </table>
      <hr>
      <h2><?= lang('スタンダードとプレミアムの違い') ?></h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/product-difference.php?data=2" target="_blank"><img src="/img/top4-banner.webp" width="" height=""></a></div>

      <h2>オリジナルペットボトルホルダーの納期</h2>
      <table width="710" border="0" cellspacing="2" cellpadding="0">
        <tr valign="top" class="process">
          <td>
            <p class="new-text">金額、デザインを確認する際、納期もお問い合わせください。注文確定からお客様への到着までの祝日を除く日数の目安です。離島等配送時間のかかる地域は除きます。納期が迫っている場合は早めにお電話(050-6865-5591)でご相談ください。</p>
            <p></p>
            <p class="new-text">価格、デザイン、納期全てＯＫであればご注文頂きます。ご注文は本WEBサイト<a href="//hotmobily.jp/order/" class="new-text">注文ページ</a>もしくはメールにてお願いします。ご注文完了後、お支払い頂いた時点から製作を開始致します。<br />
            </p>
          </td>
          <td nowrap="nowrap" align="center">
            <table border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
              <tr>
                <td colspan="2" align="center">納期の目安</td>
              </tr>
              <tr>
                <td align="center">100～499 個</td>
                <td align="center" bgcolor="#EFEFEF" nowrap="nowrap">15日営業日</td>
              </tr>
              <tr>
                <td align="center" nowrap="nowrap">500～1,000 個</td>
                <td align="center" bgcolor="#EFEFEF">18日営業日</td>
              </tr>
              <tr>
                <td nowrap="nowrap">3,000個～</td>
                <td align="center" bgcolor="#EFEFEF">25日営業日</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <div>
        <h2>本生産納期</h2>
        <div style="display: flex;">
          <div class="delivery"><span class="btn-a std-btn"><?= lang('通常納期'); ?></span></div>
          <div class="delivery">
            <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('15営業日後出荷'); ?></div>
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
      <div style="clear:both;">&nbsp;</div>

      <div id="est-content">

        <?php include('campaign_banner.php') ?>

        <div style="clear:both;"></div>
        <h2><?= lang('ご注文・見積書作成') ?></h2>
      </div>
      <?php include('../notice.html'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('ペットボトルホルダー') ?>】</h3>
          <span class="total-price"><span class="prd_total">0</span>円（<?= lang('税込') ?>）</span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td><?= lang('ご注文タイプ') ?></td>
                <td><span id="sample-prd-pcs">-</span></td>
              </tr>
              <tr>
                <td><?= lang('サイズ') ?></td>
                <td><span>横27mmX縦35mm以内</span></td>
              </tr>
              <tr>
                <td><?= lang('印刷面') ?></td>
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
            <img src="/products/images/HM_part1-2.webp" width="320" height="320" id="sample-part-pic" class="picpro" style="display: none;"><br />
            <span id="sample-part-name">通常松葉（カニカン）</span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="/products/acrylic/img/coming-soon.webp" width="500" height="500" id="sample-paper-pic" class="picpro" style="display: none;"><br />
            台紙:<span id="sample-paper-name">なし</span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ') ?></span>
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
            <input type="text" name="ItemType" id="strap" value="ペットボトルホルダー" />
          </div>
          <?php
          switch ($ItemPCS) {
            case "スタンダード":
              $lsSelected_1pcs = 'checked';
              break;
            case "プレミアム":
              $lsSelected_2pcs = 'checked';
              break;
            case "スタンダード（スピード7営業日発送）":
              $lsSelected_4pcs = 'checked';
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
            
            <h3><?= lang('ご注文タイプ') ?></h3>
            <?php include('alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_1pcs ?>>スタンダード <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_4pcs ?>><?= lang('スタンダード（スピード7営業日発送）') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?>>プレミアム <span class="checkmark"></span></label>
              </div>
            </div>

            <h3><?= lang('特殊素材（蓄光／蛍光／ラメ／金色銀色）') ?></h3>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材なし" <?php echo $material0_checked ?> onclick="clearValue();" /><?= lang('特殊素材なし') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材あり" <?php echo $material1_checked ?> onclick="clearValue();" /><?= lang('特殊素材あり') ?> <span class="checkmark"></span></label></div>
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
              <div class="part-content">
                <label class="part-name"><input type="radio" name="coating" id="coating0" value="汚れ防止加工なし" <?php echo $coating0_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工なし') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="coating" id="coating1" value="汚れ防止加工あり" <?php echo $coating1_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工あり (納期+3～5営業日）') ?> <span class="checkmark"></span></label>
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
            <h3><?= lang('台紙') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='paper_select'>
                    <input type="checkbox" class="checkbox" name="paper_select" value="あり" onclick="check_val('next')" <?= ($paper_select == "あり" ? 'checked' : '') ?>>
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
                  <?php if ($paper_select == "あり") {
                    include("paper_preview.php");
                  } ?>
                </div>
              </div>
            </div>
            <h3><?= lang('試作品・データトレース') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='SendPrototype'>
                    <input type="checkbox" class="checkbox" name="SendPrototype" value="あり" onclick="setToInput();" <?= $sendActual_checked ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>
                  <?= lang('試作品') ?>
                </label>
              </div>
              <font color="red"><?= lang('※プレミアムは試作品代金が無料') ?></font>
            </div>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='DeFormat'>
                    <input type="checkbox" class="checkbox" name="DeFormat" value="あり" onclick="setToInput();" <?= $others_checked ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
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
                      <td class="" style="text-align: left;">横27mmX縦35mm以内</td>
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
                      <td class="TableLeft"><?= lang('デザインバリエーション') ?></td>
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
                    <tr style="display: none;">
                      <td class="TableLeft"><?= lang('シルク印刷代金') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="SilkPrint" readonly="readonly" id="textfield13" class="right" value="<?php echo $SilkPrint ?>" />円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="coatingPrice" readonly="readonly" id="textfield13_2" class="right" value="<?= $coatingPrice ?>">円</td>
                    </tr>
                    <tr style="display: none;">
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
                      <td class="TableLeft"><?= lang('デザインバリエーション') ?></td>
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
                      <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="clearValue();$('#cus_detail').hide();valid_chk_btn2('step1');" />
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn2('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn2('step2');$('#cus_detail').hide();"><?= lang('ｱﾀｯﾁﾒﾝﾄ修正') ?></a>
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
                    <img src="/img/delivery_10days_notice.jpg" alt="Flowers" style="width:100%;">
                  </picture>
                  <input type="button" class="btn btn-back flex-item" value="<?= lang('OK') ?>" for="modal-ord" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form); " />
                </diV>

              </div>
            </div>
          </div>
          <div id="acrylic-btn" class="btn-container">
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn2('back')"><?= lang('戻る') ?></a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn2('next')"><?= lang('オプション入力へ') ?></a>
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');$('.loading').show();" value="<?= lang('御社情報確定（PDF出力）') ?>" />
                  <div class="remark">&nbsp;<?= lang('※社名や会社名の入力は任意です') ?></div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <?php $fd_type = "pbholder";
      $favor = "pbholder";
      include 'rubber_product_detail_test.php'; ?>
      <?php include("part-daishi.php"); ?>
      <hr>
      <h2>ペットボトルホルダーのサンプルについて</h2>
      <a href="/contact/?item=ラバーペットボトルホルダー"><img src="img/banner_cont6.webp" width="100%" height="82"></a>
      <hr />
      <a href="/production/"><img src="/production/img/banner-2_20210407.webp" width="770" height="194" style="max-width: 100%;margin: 10px 0;"></a>
      <h2>営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。</h2>
      <center><a href="//hotmobily.jp/meeting_date/"><img src="../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a></center>
      <br />
      <img src="images/text_sample.webp" width="100%" height="620" id="i_txt2">
      <hr>
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->


  <!--フッター ここから-->
  <?php include("../footer.php"); ?>
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
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>

  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/js/_setToInput_2026.js?v=<?php echo date('is') ?>"></script>
  <script language="JavaScript" src="/js/validation_new.js?v=1.11" type="text/javascript"></script>
  <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="/products/acrylic/ptw/photoswipe.min.js?v=1.08"></script>
  <script src="/products/acrylic/ptw/photoswipe-ui-default.min.js"></script>
  <script type="text/javascript">
    var splide = new Splide('.splide', {
      type: 'loop',
      perPage: 3,
      pagination: false,
      arrows: true,
      breakpoints: {
        425: {
          perPage: 2,
        }
      },
    });
    splide.mount();
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "15days"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });
    $.ajax({
      type: "POST",
      url: "get_sample_date.php",
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
      url: "get_sample_date.php",
      success: function(data) {
        // console.log(data);
        productionDate2(data.sort());
      },
      dataType: "json"
    });
    var tmp = "<?= $_GET['mode'] ?>";
    $(function() {
      var t = $("#i_txt1"),
        s = $("#i_txt2");
      screen.width <= 768 && (t.attr("src", "rubberstrap/images/img_txt2_n1.svg"), s.attr("src",
        "rubberstrap/images/text_sample_n1.svg"))
    }, (tmp != "" ? valid_chk_btn2('step3') : ""), setToInput(), $('#sample-paper-pic').attr('data-src',
      '/products/acrylic/img/' + $('input[name="paper"]:checked').val() + '.jpg'));
    $("input[name='paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    })
  </script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
</body>

</html>