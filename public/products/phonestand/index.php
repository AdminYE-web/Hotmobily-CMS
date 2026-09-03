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

// GETリクエストを取得
// $msMode = $_GET['mode'];
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
  <meta name="keywords" content="<?= lang('携帯,スマホ,スマートフォンスタンド,オリジナル,作成,製作,同人') ?>">
  <meta name="description" content="<?= lang('携帯・スマートフォンスタンドの製作。ラバー素材を使用し、オリジナル形状で製作できます。100個から。') ?>">
  <meta name="robots" content="noindex,nofollow" />
  <title><?= lang('携帯・スマートフォンスタンドの製作。ラバー素材を使用し、オリジナル形状で製作できます。') ?></title>
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css?v=1.01" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <?php include("../../head_products.html"); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.09" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
  <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">
  <link rel="stylesheet" type="text/css" href="../css/scroll.css">
  <link href="/css/rubber.css?v=1.02" rel="stylesheet" type="text/css" />
  <style type="text/css">
    <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>

    /*new css*/
    a.btn.toggle-btn {
      display: block;
      background: lightblue;
      border-bottom: 1px white solid;
      color: red;
      font-size: 16px;
    }

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
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
    .TableLeft {
      text-align: left !important;
    }
  </style>

  <!-- lightbox2-master -->
  <link rel="stylesheet" href="css/lightbox.css">
  <!-- /lightbox2-master -->
  <link rel="stylesheet" type="text/css" href="/products/css/foodproducts_banner.css?v=0.03">
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
      <?php include("../rubber_info.php"); ?>
      <?php include('../banner-campaign.php') ?>
      <h1>オリジナル携帯・スマートフォンスタンドの製作。(2026年版)</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=オリジナル携帯・スマートフォンスタンドの製作。&amp;body=携帯・スマートフォンスタンドの製作。ラバー素材を使用し、オリジナル形状で製作できます。100個から。:https://hotmobily.jp/products/phonestand/" title="Share by Email" target="_blank">シェアする</a><a href="mailto:?subject=オリジナル携帯・スマートフォンスタンドの製作。&amp;body=携帯・スマートフォンスタンドの製作。ラバー素材を使用し、オリジナル形状で製作できます。100個から。:https://hotmobily.jp/products/phonestand/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fphonestand%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fphonestand%2f&amp;text=携帯・スマートフォンスタンドの製作。ラバー素材を使用し、オリジナル形状で製作できます。100個から。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <img src="/products/images/rubber_feature_banner.webp?v=1.02">
      <div>&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <div class="videoWrapper" style="text-align:center;">
            <img src="/products/img/rubber-phonestand-yt-1.webp" data-src="pZK_x27By2w" class="iframe" width="100%" height="213" style="max-width: 378px">
            <div class="playbtn">
              <div class="tri"></div>
            </div>
          </div>
        </div>
        <div class="flex-item item">
          <h2 style="margin-top: 0px;"><?= lang('ラバースマートフォンスタンド製作') ?></h2>
          <p class="new-text">
            <?= lang('ラバースマートフォンスタンドをオリジナルのデザインで製作できます。') ?><br /><br />
            <?= lang('業界最短の7営業日で製作。手軽に携帯電話を置いていただけるオリジナルスタンドです。') ?><br /><br />
            <?= lang('未使用時は平らにすることが出来ますので、保管に場所をとりません。また、組み立ても非常に簡単でどなた様にもお気軽にご利用頂けます。') ?><br /><br />
            <?= lang('机に置いて使用する事が多くなりますので、ノベルティとしての広告効果を望めるアイテムです。') ?>
          </p>
        </div>
      </div>
      <hr />

        <h2>ラバー製品完全ガイドをご用意！</h2>
        <div>
            <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
        </div>
        <div>
            <p class="new-text">初めてラバー製品を製作するとき、「ラバー製品ってどこまでできるのかな？」「どんな制約があるのかな？」など、オリジナルラバー製品の製作について詳しく知りたいですよね</p><br>
            <p class="new-text">そんな方のために、ラバー製品の加工タイプやデザインのポイントなどについての完全ガイドをご用意。
            </p><br>
            <p class="new-text">あなたのベストなラバースマートフォン製作にお役立てください。</p>
            <br>
            <div style="text-align: right;">
                <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
            </div>
        </div>

      <hr>
      <h2>ラバースマートフォンスタンドとは</h2>
      <p class="new-text">
        手軽に組み立てられて、携帯電話やテレビやエアコンのリモコンを収納できるスタンドです。置き場所を選ばない小サイズから、大型の携帯電話やリモコンなどもしっかり収納できる大サイズの2サイズをご用意しておりますので用途に応じてご提案しております。
      </p>
      <hr />
      <h2>スマートフォンの組み立て方法</h2>
      <p class="d_TEXT1 new-text">
        当店のスマートフォンスタンドは、平板構造を組み立てて使用します。組み立ては下記のようにとても簡単です。スタンドをノベルティーとしてお客様へ郵送される場合、
        定型封筒に入れて郵送できますので立体物であるにも関わらず配送コストを抑えることができます。<br />
      <div align="center"><img src="img/smart_example_02.webp" width="583" height="186"></div>
      </p>
      <hr />
      <h2>製作事例紹介</h2>
      <div class="ex-row">
        <div class="gall_pro" style="justify-content: flex-start;">
          <div class="gallbox">
            <a href="/products/phonestand/img/product_gallery/01/1.webp" data-lightbox="img-set-01" data-title="" style="text-decoration: none;">
              <img src="/products/phonestand/img/product_gallery/01/1.webp" class="picpro" width="229" height="141"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/products/phonestand/img/product_gallery/01/2.webp" data-lightbox="img-set-01" data-title="" style="text-decoration: none;"></a>
            <a href="/products/phonestand/img/product_gallery/01/3.webp" data-lightbox="img-set-01" data-title="" style="text-decoration: none;"></a>
          </div>
          <div class="gallbox">
            <a href="/products/phonestand/img/product_gallery/02/1.webp" data-lightbox="img-set-02" data-title="" style="text-decoration: none;">
              <img src="/products/phonestand/img/product_gallery/02/1.webp" class="picpro" width="229" height="141"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/products/phonestand/img/product_gallery/02/2.webp" data-lightbox="img-set-02" data-title="" style="text-decoration: none;"></a>
            <a href="/products/phonestand/img/product_gallery/02/3.webp" data-lightbox="img-set-02" data-title="" style="text-decoration: none;"></a>
          </div>
          <div class="gallbox">
            <a href="/products/phonestand/img/product_gallery/03/1.webp" data-lightbox="img-set-03" data-title="" style="text-decoration: none;">
              <img src="/products/phonestand/img/product_gallery/03/1.webp" class="picpro" width="229" height="141"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/products/phonestand/img/product_gallery/03/2.webp" data-lightbox="img-set-03" data-title="" style="text-decoration: none;"></a>
            <a href="/products/phonestand/img/product_gallery/03/3.webp" data-lightbox="img-set-03" data-title="" style="text-decoration: none;"></a>
          </div>
          <div class="gallbox">
            <a href="/products/phonestand/img/product_gallery/04/1.webp" data-lightbox="img-set-04" data-title="" style="text-decoration: none;">
              <img src="/products/phonestand/img/product_gallery/04/1.webp" class="picpro" width="229" height="141"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/products/phonestand/img/product_gallery/04/2.webp" data-lightbox="img-set-04" data-title="" style="text-decoration: none;"></a>
            <a href="/products/phonestand/img/product_gallery/04/3.webp" data-lightbox="img-set-04" data-title="" style="text-decoration: none;"></a>
          </div>
          <div class="gallbox">
            <a href="/products/phonestand/img/product_gallery/05/1.webp" data-lightbox="img-set-05" data-title="" style="text-decoration: none;">
              <img src="/products/phonestand/img/product_gallery/05/1.webp" class="picpro" width="229" height="141"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/products/phonestand/img/product_gallery/05/2.webp" data-lightbox="img-set-05" data-title="" style="text-decoration: none;"></a>
            <a href="/products/phonestand/img/product_gallery/05/3.webp" data-lightbox="img-set-05" data-title="" style="text-decoration: none;"></a>
          </div>
        </div>
      </div>
      <hr />
      <h2>ラバースマートフォンスタンドのサイズ</h2>
      <table width="100%" border="0" cellpadding="0" cellspacing="5">
        <tr>
          <td colspan="2">
            <h2 class="red">小サイズの仕様</h2>
          </td>
        </tr>
        <tr>
          <td align="center">
            <a href="img/phonestand_f01.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f01.webp" width="300" height="364">
            </a>
          </td>
          <td align="center">
            <a href="img/phonestand_f02.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f02.webp" width="300" height="364">
            </a>
          </td>
        </tr>
        <tr>
          <td align="center">
            <a href="img/phonestand_f03.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f03.webp" width="300" height="364">
            </a>
          </td>
          <td align="center">
            <a href="img/phonestand_f04.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f04.webp" width="300" height="364">
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="5">
        <tbody>
          <tr>
            <td width="40%">
              <a href="img/phonestand_sample_M.webp" data-lightbox="set-sampleM" style="text-decoration:none;">
                <img src="img/phonestand_sample_M.webp" width="100%" height="235">
              </a>
            </td>
            <td width="60%">
              <p class="new-text" style="line-height: 2;">
                ご利用の携帯電話等の本体横幅が68mm以下で適合。<br />小さいサイズのスマートフォンやガラケーをご利用の場合、こちらのサイズを推奨しております。小さいサイズですので、置き場に困らず様々用途で使用できます。主な適合機種は以下、一覧表にてご確認頂けます。
              </p>
            </td>
          </tr>
        </tbody>
      </table>
      <a href="img/phonestand_f01.webp" data-lightbox="set-phonestand-1" style="text-decoration:none; font-size:10px;">📷クリックすると拡大します</a>
      <a href="img/phonestand_f02.webp" data-lightbox="set-phonestand-1"></a>
      <a href="img/phonestand_f03.webp" data-lightbox="set-phonestand-1"></a>
      <a href="img/phonestand_f04.webp" data-lightbox="set-phonestand-1"></a>
      <a href="img/phonestand_sample_M.webp" data-lightbox="set-phonestand-1"></a><br><br>

      <a class="btn toggle-btn" href="javascript:void(0);" onclick="$('#small_phone').slideToggle()">小サイズ適合機種例一覧</a>
      <div id="small_phone" style="display:none">
        <table cellpadding="2" cellspacing="1" bgcolor="lightblue" style="width: 100%;">
          <tr bgcolor="lightblue">
            <td width="106">
              <div align="center" class="red"></div>
            </td>
            <td width="88">
              <div align="center">高さ(mm)</div>
            </td>
            <td width="84">
              <div align="center">幅(mm)</div>
            </td>
            <td width="88">
              <div align="center">厚さ(mm)</div>
            </td>
            <td width="82">
              <div align="center">画面サイズ(inch)</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 13 mini</div>
            </td>
            <td>
              <div align="center">131.5</div>
            </td>
            <td>
              <div align="center">64.1</div>
            </td>
            <td>
              <div align="center">7.65</div>
            </td>
            <td>
              <div align="center">5.4</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 12 mini</div>
            </td>
            <td>
              <div align="center">131.5</div>
            </td>
            <td>
              <div align="center">64.2</div>
            </td>
            <td>
              <div align="center">7.4</div>
            </td>
            <td>
              <div align="center">5.4</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone SE</div>
            </td>
            <td>
              <div align="center">138.4</div>
            </td>
            <td>
              <div align="center">67.3</div>
            </td>
            <td>
              <div align="center">7.3</div>
            </td>
            <td>
              <div align="center">4.7</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Xperia 5 IV</div>
            </td>
            <td>
              <div align="center">156</div>
            </td>
            <td>
              <div align="center">67</div>
            </td>
            <td>
              <div align="center">9.7</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Xperia 10 IV</div>
            </td>
            <td>
              <div align="center">153</div>
            </td>
            <td>
              <div align="center">67</div>
            </td>
            <td>
              <div align="center">8.3</div>
            </td>
            <td>
              <div align="center">6</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Xperia 5 Ⅲ</div>
            </td>
            <td>
              <div align="center">157</div>
            </td>
            <td>
              <div align="center">68</div>
            </td>
            <td>
              <div align="center">8.2</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Xperia 10 III</div>
            </td>
            <td>
              <div align="center">154</div>
            </td>
            <td>
              <div align="center">68</div>
            </td>
            <td>
              <div align="center">8.3</div>
            </td>
            <td>
              <div align="center">6</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Xperia 5 II</div>
            </td>
            <td>
              <div align="center">158</div>
            </td>
            <td>
              <div align="center">68</div>
            </td>
            <td>
              <div align="center">8</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Rakuten Hand 5G</div>
            </td>
            <td>
              <div align="center">138</div>
            </td>
            <td>
              <div align="center">63</div>
            </td>
            <td>
              <div align="center">9.5</div>
            </td>
            <td>
              <div align="center">5.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Rakuten Hand</div>
            </td>
            <td>
              <div align="center">138</div>
            </td>
            <td>
              <div align="center">63</div>
            </td>
            <td>
              <div align="center">9.5</div>
            </td>
            <td>
              <div align="center">5.1</div>
            </td>
          </tr>
        </table>
      </div>
      <div>&nbsp;</div>
      <h2 class="red">小サイズ製作料金</h2>
      <?= lang('スタンダード') ?>
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>935 円</td>
            <td>745 円</td>
            <td>555 円</td>
            <td>457 円</td>
            <td>326 円</td>
            <td>246 円</td>
            <td>217 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(93,500円)</td>
            <td>(149,000円)</td>
            <td>(166,500円)</td>
            <td>(228,500円)</td>
            <td>(326,000円)</td>
            <td>(738,000円)</td>
            <td>(1,085,000円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スタンダードの料金表です。') ?><br />
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br />
      </div>
      <div>&nbsp;</div>
      スタンダード（スピード発送）
      <div class="tbl_s" style="position: relative;">
        <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1,056 円</td>
            <td>866 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(105,600 円)</td>
            <td>(173,200 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは200個となります。') ?><br />
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br />
        ※<?= lang('汚れ防止加工はできません。') ?><br />
      </div>
      <div>&nbsp;</div>
      <?= lang('プレミアム') ?>
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1,215 円</td>
            <td>969 円</td>
            <td>722 円</td>
            <td>548 円</td>
            <td>391 円</td>
            <td>295 円</td>
            <td>261 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(121,500 円)</td>
            <td>(193,800 円)</td>
            <td>(216,600 円)</td>
            <td>(274,000 円)</td>
            <td>(391,000 円)</td>
            <td>(885,000 円)</td>
            <td>(1,305,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('プレミアムの料金表です。') ?><br />
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('プレミアムでは、試作品、裏面印刷、トレース代金は無料です。') ?><br />
      </div>
      <hr color="black" size="1px;">
      <table width="100%" border="0" cellpadding="0" cellspacing="5">
        <tr>
          <td colspan="2">
            <h2 class="red">大サイズの仕様</h2>
          </td>
        </tr>
        <tr>
          <td align="center">
            <a href="img/phonestand_f05.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f05.webp" width="300" height="364">
            </a>
          </td>
          <td align="center">
            <a href="img/phonestand_f06.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f06.webp" width="300" height="364">
            </a>
          </td>
        </tr>
        <tr>
          <td align="center">
            <a href="img/phonestand_f07.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f07.webp" width="300" height="364">
            </a>
          </td>
          <td align="center">
            <a href="img/phonestand_f08.webp" data-lightbox="set-phonestand" style="text-decoration:none;">
              <img src="img/phonestand_f08.webp" width="300" height="364">
            </a>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="5">
        <tbody>
          <tr>
            <td width="40%">
              <a href="img/phonestand_sample_L.webp" data-lightbox="set-sampleM" style="text-decoration:none;">
                <img src="img/phonestand_sample_L.webp" width="100%" height="235">
              </a>
            </td>
            <td width="60%">
              <p class="new-text" style="line-height: 2;">
                ご利用の携帯電話等の本体横幅が68mm以上、88mm以下で適合。<br />大きいサイズのスマートフォンをご利用の場合、こちらのサイズを推奨しております。製品自体が大きいサイズですので、テレビのリモコンなどでもご利用頂けます。主な適合機種は以下、一覧表にてご確認頂けます。
              </p>
            </td>
          </tr>
        </tbody>
      </table>

      <a href="img/phonestand_f05.webp" data-lightbox="set-phonestand-2" style="text-decoration:none; font-size:10px;">📷クリックすると拡大します</a>
      <a href="img/phonestand_f06.webp" data-lightbox="set-phonestand-2"></a>
      <a href="img/phonestand_f07.webp" data-lightbox="set-phonestand-2"></a>
      <a href="img/phonestand_f08.webp" data-lightbox="set-phonestand-2"></a>
      <a href="img/phonestand_sample_L.webp" data-lightbox="set-phonestand-2"></a><br><br>

      <a class="btn toggle-btn" href="javascript:void(0);" onclick="$('#big_phone').slideToggle()">大サイズ適合機種例一覧</a>
      <div id="big_phone" style="display:none">
        <table cellpadding="2" cellspacing="1" bgcolor="lightblue" style="width: 100%;">
          <tr bgcolor="lightblue">
            <td width="106">
              <div align="center" class="red"></div>
            </td>
            <td width="88">
              <div align="center">高さ(mm)</div>
            </td>
            <td width="84">
              <div align="center">幅(mm)</div>
            </td>
            <td width="88">
              <div align="center">厚さ(mm)</div>
            </td>
            <td width="82">
              <div align="center">画面サイズ(inch)</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 14 Pro</div>
            </td>
            <td>
              <div align="center">147.5</div>
            </td>
            <td>
              <div align="center">71.5</div>
            </td>
            <td>
              <div align="center">7.85</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 14</div>
            </td>
            <td>
              <div align="center">146.7</div>
            </td>
            <td>
              <div align="center">71.5</div>
            </td>
            <td>
              <div align="center">7.8</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 13</div>
            </td>
            <td>
              <div align="center">146.7</div>
            </td>
            <td>
              <div align="center">71.5</div>
            </td>
            <td>
              <div align="center">7.65</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 13 Pro</div>
            </td>
            <td>
              <div align="center">146.7</div>
            </td>
            <td>
              <div align="center">71.5</div>
            </td>
            <td>
              <div align="center">7.65</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 12</div>
            </td>
            <td>
              <div align="center">146.7</div>
            </td>
            <td>
              <div align="center">71.5</div>
            </td>
            <td>
              <div align="center">7.4</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 12 Pro</div>
            </td>
            <td>
              <div align="center">146.7</div>
            </td>
            <td>
              <div align="center">71.5</div>
            </td>
            <td>
              <div align="center">7.4</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 11</div>
            </td>
            <td>
              <div align="center">150.9</div>
            </td>
            <td>
              <div align="center">75.7</div>
            </td>
            <td>
              <div align="center">8.3</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 14 Pro Max</div>
            </td>
            <td>
              <div align="center">160.7</div>
            </td>
            <td>
              <div align="center">77.6</div>
            </td>
            <td>
              <div align="center">7.85</div>
            </td>
            <td>
              <div align="center">6.7</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 14 Plus</div>
            </td>
            <td>
              <div align="center">160.8</div>
            </td>
            <td>
              <div align="center">78.1</div>
            </td>
            <td>
              <div align="center">7.8</div>
            </td>
            <td>
              <div align="center">6.7</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 13 Pro Max</div>
            </td>
            <td>
              <div align="center">160.8</div>
            </td>
            <td>
              <div align="center">78.1</div>
            </td>
            <td>
              <div align="center">7.65</div>
            </td>
            <td>
              <div align="center">6.7</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">iPhone 12 Pro Max</div>
            </td>
            <td>
              <div align="center">160.8</div>
            </td>
            <td>
              <div align="center">78.1</div>
            </td>
            <td>
              <div align="center">7.4</div>
            </td>
            <td>
              <div align="center">6.7</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy A23 5G</div>
            </td>
            <td>
              <div align="center">150</div>
            </td>
            <td>
              <div align="center">71</div>
            </td>
            <td>
              <div align="center">9</div>
            </td>
            <td>
              <div align="center">5.8</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy S22</div>
            </td>
            <td>
              <div align="center">146</div>
            </td>
            <td>
              <div align="center">71</div>
            </td>
            <td>
              <div align="center">7.6</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy S21 5G</div>
            </td>
            <td>
              <div align="center">152</div>
            </td>
            <td>
              <div align="center">71</div>
            </td>
            <td>
              <div align="center">7.9</div>
            </td>
            <td>
              <div align="center">6.2</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy A21</div>
            </td>
            <td>
              <div align="center">150</div>
            </td>
            <td>
              <div align="center">71</div>
            </td>
            <td>
              <div align="center">8.4</div>
            </td>
            <td>
              <div align="center">5.8</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy Z Flip4</div>
            </td>
            <td>
              <div align="center">165</div>
            </td>
            <td>
              <div align="center">72</div>
            </td>
            <td>
              <div align="center">6.9</div>
            </td>
            <td>
              <div align="center">6.7</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy A51 5G</div>
            </td>
            <td>
              <div align="center">159</div>
            </td>
            <td>
              <div align="center">74</div>
            </td>
            <td>
              <div align="center">8.8</div>
            </td>
            <td>
              <div align="center">6.5</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy A53 5G</div>
            </td>
            <td>
              <div align="center">160</div>
            </td>
            <td>
              <div align="center">75</div>
            </td>
            <td>
              <div align="center">8.1</div>
            </td>
            <td>
              <div align="center">6.5</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy A52 5G</div>
            </td>
            <td>
              <div align="center">160</div>
            </td>
            <td>
              <div align="center">75</div>
            </td>
            <td>
              <div align="center">8.4</div>
            </td>
            <td>
              <div align="center">6.5</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy S21 Ultra 5G</div>
            </td>
            <td>
              <div align="center">165</div>
            </td>
            <td>
              <div align="center">76</div>
            </td>
            <td>
              <div align="center">8.9</div>
            </td>
            <td>
              <div align="center">6.8</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy A32 5G</div>
            </td>
            <td>
              <div align="center">164</div>
            </td>
            <td>
              <div align="center">76</div>
            </td>
            <td>
              <div align="center">9.1</div>
            </td>
            <td>
              <div align="center">6.5</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy M23 5G</div>
            </td>
            <td>
              <div align="center">165.5</div>
            </td>
            <td>
              <div align="center">77</div>
            </td>
            <td>
              <div align="center">8.4</div>
            </td>
            <td>
              <div align="center">6.6</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy Note20 Ultra 5G</div>
            </td>
            <td>
              <div align="center">165</div>
            </td>
            <td>
              <div align="center">77</div>
            </td>
            <td>
              <div align="center">8.1</div>
            </td>
            <td>
              <div align="center">6.9</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">Galaxy S22 Ultra</div>
            </td>
            <td>
              <div align="center">163</div>
            </td>
            <td>
              <div align="center">78</div>
            </td>
            <td>
              <div align="center">8.9</div>
            </td>
            <td>
              <div align="center">6.8</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">AQUOS sense7</div>
            </td>
            <td>
              <div align="center">152</div>
            </td>
            <td>
              <div align="center">70</div>
            </td>
            <td>
              <div align="center">8</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
          <tr bgcolor="white">
            <td>
              <div style="padding-left: 10px;">AQUOS sense6s</div>
            </td>
            <td>
              <div align="center">152</div>
            </td>
            <td>
              <div align="center">70</div>
            </td>
            <td>
              <div align="center">9.2</div>
            </td>
            <td>
              <div align="center">6.1</div>
            </td>
          </tr>
        </table>
      </div>
      <h2><?= lang('ラバースマートフォンスタンドの製作工程のご紹介') ?></h2>
      <div class="videoWrapper">
        <img src="/products/img/rubber-production-yt.webp" data-src="5KK0a4b1C9Q" class="iframe" width="773" height="435">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <hr />
      <!-- <div>
        <h2><?= lang('ラバースマートフォンスタンド／携帯スタンドの仕様') ?></h2>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td><?= lang('製品のデザイン') ?></td>
              <td><?= lang('御社の会社ロゴや新製品ロゴを使って、完全にオリジナル製品で製作します。名入れのみではありません。') ?></td>
            </tr>
            <tr>
              <td><?= lang('製品サイズ') ?></td>
              <td><?= lang('小サイズ（182.5mmX95mm）、大サイズ（236mmX120mm）の2サイズを用意しております。') ?></td>
            </tr>
            <tr>
              <td><?= lang('材質') ?></td>
              <td>
                <?= lang('ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)
            熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細は<a href="/products/foodproducts.php?data=phonestand" target="_blank">こちら</a>。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('デザインテンプレート') ?></td>
              <td><?= lang('小サイズ：182.5mmX95mm <a href="/products/download.php?file=download_smartphone_S.zip" target="_blank">ダウンロード</a><br/>
            大サイズ：236mmX120mm <a href="/products/download.php?file=download_iphone6.zip" target="_blank">ダウンロード</a>') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('携帯スタンド以外の用途') ?></td>
              <td><?= lang('画面表示機能を備えた小型医療器具スタンド テレビやエアコンのリモコン置き') ?></td>
            </tr>
            <tr>
              <td><?= lang('色指定') ?></td>
              <td><?= lang('以下2通りのいづれか。①PANTONE(パントーン)もしくは、DIC(ディック)番号によるご指定。②弊社もしくは、お客様が印刷された、色見本（カラーペーパー）によるご指定。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('裏面印刷') ?></td>
              <td>単色（シルク）印刷、カラー印刷ともに可能です。プレミアムの場合は無料、スタンダードの場合は単色が＋@33円（税込）、カラーが＋@55円（税込）となります。</td>
            </tr>
            <tr>
              <td><?= lang('最小製作個数（最小ロット）') ?>
              </td>
              <td><?= lang('100個より製作します。') ?></td>
            </tr>
            <tr>
              <td><?= lang('台紙') ?></td>
              <td><?= lang('オプションとして台紙の封入が可能です。') ?>
                <a href="/products/daishi.html"><?= lang('台紙封入の詳細。') ?></a> <?= lang('支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。') ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div> -->

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
      
      
            <div class="resource-button-grid">
        <a href="/products/new-template/rubber-smartphone.zip" class="resource-button" style="color: #233c4a">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <path d="M12 18v-7"></path>
            <path d="M8.5 14.5 12 18l3.5-3.5"></path>
          </svg>
          <span>入稿データテンプレートをダウンロード</span>
        </a>

        <a href="/products/data" class="resource-button" style="color: #233c4a">
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

        <a href="/contact/?item=ラバースマートフォンスタンド" class="resource-button" style="color: #233c4a">
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
      <!-- <div class="row how" style="margin-top: -8px;">
        <a class="mt-10 btn-a btn-yellow" href="/lp/rubber-guide-structure.php" target="_blank">
          <div class="howto"><img src="/products/images/icon-kako-rb.webp" width="34" height="34"></div>
          <div><?= lang('立体加工詳細') ?></div>
        </a>
        <a class="mt-10 btn-a btn-yellow" href="/products/quality.html" target="_blank">
          <div class="howto"><img src="/products/images/icon-qlt-rb.webp" width="34" height="34"></div>
          <div><?= lang('品質基準詳細') ?></div>
        </a>
        <a href="javascript:void(0)" class="mt-10 btn-a btn-yellow" for="modal-1" style="cursor: pointer;" onclick="$('#modal-1').prop('checked',true)">
          <div class="howto"><img src="/products/images/icon-des-rb.webp" width="34" height="34"></div>
          <div><?= lang('お客様へのお約束') ?></div>
        </a>
        <input class="modal-state" id="modal-1" type="checkbox" />
        <div class="modal">
          <label class="modal__bg" for="modal-1"></label>
          <div class="modal__inner modal1">
            <label class="modal__close" for="modal-1"></label>
            <h2>ホットモバイリーから皆様へのお約束</h2>
            <p class="d_TEXT1">ホットモバイリーは、日々皆様と接しデザインを作成、製品の製作をする中で、<br>
              お客様対応と製品品質で日本一でありたいと思い事業活動を行っております。<br>
              そのために以下の点を事業活動の指針としています。</p>

            <h2>数あるノベルティー製作会社の中で、最もきめの細かなサービスを提供する。</h2>
            <p class="d_TEXT1">製品の品質に責任を持つ。<br>
              これら2つの事業活動の指針を実現する為、具体的には以下の点を常に意識してサービスを提供しています。</p>

            <h2>皆様のデザインを出来る限り忠実に製品化する。</h2>
            <p class="d_TEXT1">皆様のデザインは電子データです。特にキャラクター製品は多くのディテールを含んでおり、<br>
              データ入稿、一発製品化とはいきません。 多くの場合修正を必要としますが、その修正は最低限に留める。</p>

            <h2>皆様が納得いくまで、何回でもデザインの修正を行います。</h2>
            <p class="d_TEXT1">ホットモバイリーは理解しています、オリジナルグッズの製作が決して安くないことを。<br>
              ですから皆様に納得して頂けるまで、何度でも デザインの修正を無料で行います。<br>
              デザイン修正を行った結果、オリジナルグッズの製作を希望されない場合、料金はかかりません。</p>

            <h2>品質基準を明確にし、品質基準を満たさない製品が納品されてしまった場合、無条件で製品の再作製を行います。</h2>
            <p class="d_TEXT1">ホットモバイリーは製品の品質基準を明確にし、全てのお客様に公表しています。<br>
              この品質基準は、業界で最も厳しい基準だと考えております。<br>
              このような管理をしても、海外生産ということもあり、品質基準を満たさない製品が皆様に納品されしまうことがあります。<br>
              その際は理由の如何を問わず、全数再作成し、再度納品させて頂いております。<br>
              皆様に満足頂くこと、これはホットモバイリーの使命です。</p>

            <h2>ホットモバイリーで製作頂いた全てのお客様に、アンケートでご不満な点を質問し、その回答を誰でも閲覧できるように公開します。</h2>
            <p class="d_TEXT1">インターネットだけで、高額な買い物をするには不安が残る。ホットモバイリーは、本当に大丈夫なのか？我々が大丈夫だと言うより、<br>
              皆様に答えて頂いた方がより的確に判断して頂けます。全てのホットモバイリーご利用者様にアンケートを実施。<br>
              特に記述式で満足した点でなく、不満な点を記載してもらうようお願いしています。<br>
              アンケート結果は全て公開。弊社で回答の改ざんができないよう、第三者のシステムを利用しています。<br>
              ご意見をもとに改善させて頂いた例は多く、例えば<br><br>

              WEBサイトだけで販売されているので、売っている人の顔が見えない。スタッフの自己紹介をWEBでやったら良いのではないか。<br>
              →WEBサイトにスタッフ紹介を追加しました。<br><br>

              <span style="color: red;">皆様の貴重なご意見やお叱りがホットモバイリーを強くしてくれます。</span>
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
      <h2 class="red">大サイズ製作料金</h2>
      <?= lang('スタンダード') ?>
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1,172 円</td>
            <td>928 円</td>
            <td>684 円</td>
            <td>578 円</td>
            <td>438 円</td>
            <td>316 円</td>
            <td>289 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(117,200円)</td>
            <td>(185,600円)</td>
            <td>(205,200円)</td>
            <td>(289,000円)</td>
            <td>(438,000円)</td>
            <td>(948,000円)</td>
            <td>(1,445,000円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スタンダードの料金表です。') ?><br />
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?>
      </div>
      <div>&nbsp;</div>
      スタンダード（スピード発送）
      <div class="tbl_s" style="position: relative;">
        <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1,293 円</td>
            <td>1,093 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(129,300 円)</td>
            <td>(218,600 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは200個となります。') ?><br />
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br />
        ※<?= lang('汚れ防止加工はできません。') ?>
      </div>
      <div>&nbsp;</div>
      <?= lang('プレミアム') ?>
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1,458 円</td>
            <td>1,170 円</td>
            <td>854 円</td>
            <td>694 円</td>
            <td>526 円</td>
            <td>380 円</td>
            <td>347 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(145,800 円)</td>
            <td>(234,000 円)</td>
            <td>(256,200 円)</td>
            <td>(347,000 円)</td>
            <td>(526,000 円)</td>
            <td>(1,140,000 円)</td>
            <td>(1,735,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('プレミアムの料金表です。') ?><br />
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('プレミアムでは、試作品、裏面印刷、トレース代金は無料です。') ?>
      </div>
      <hr>
      <h2>スタンダードとプレミアムの違い</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/product-difference.php?data=2" target="_blank"><img src="/img/top4-banner.webp" width="745" height="350"></a></div>
      <h2>製作納期</h2>
      <div style="clear: both;"></div>
      <!-- <div id="info_div"></div> -->
      <?php include('../../delivery_note.html'); ?><br>
      <p class="d_TEXT1 new-text">
        納期：<br />
        <span class="red">下記日数は全て営業日。</span><br />
        納期=製作日数+配送日数で定義されるものとします。<br />
        営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。中国春節、国慶節期間につきましては、別途定める休日が指定されます。<br />シルク印刷ありでのご注文の場合、+1営業日<br />色味指定を印刷紙で行う場合、+3営業日<br />※お客様から印刷紙手配が遅れる場合、この限りではございません。
      </p>
      ◆スタンダード製作期間（単位：営業日。配送日数は含まず）
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr align="center">
          <td>&nbsp;</td>
          <td align="center">300個以下</td>
          <td align="center">1,000個以下</td>
          <td align="center">3,000個程度まで</td>
        </tr>
        <tr>
          <td>試作品製作日数</td>
          <td align="center">6</td>
          <td align="center">6</td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td>量産品製作日数(試作あり)</td>
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
        <tr>
          <td>量産のみの製作日数（試作なし）</td>
          <td align="center">10</td>
          <td align="center">14</td>
          <td align="center">22～</td>
        </tr>
      </table>
      <br />
      ◆<?= lang('スタンダード（スピード発送）製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">200個以下</td>
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

      ◆プレミアム製作期間（単位：営業日。配送日数は含まず）
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr>
          <td>&nbsp;</td>
          <td align="center">300個以下</td>
          <td align="center">1,000個以下</td>
          <td align="center">3,000個程度まで</td>
        </tr>
        <tr>
          <td>試作品製作日数</td>
          <td align="center">6</td>
          <td align="center">6</td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td>量産品製作日数(試作あり)</td>
          <td align="center">23</td>
          <td align="center">28</td>
          <td align="center">36～</td>
        </tr>
        <tr>
          <td>量産のみの製作日数（試作なし）</td>
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
      </table>
      <p class="d_TEXT1 new-text">◆配送日数：1-2営業日</p>
      <p class="d_TEXT1 new-text">
        ◇例）<br />
        スタンダード<br />
        300個<br />
        試作品なしの場合
      </p>
      <p class="d_TEXT1 new-text">
        ・製作期間：10営業日<br />
        ・配送期間：1-2営業日<br />
        合計：11-12営業日となります。
      </p>
      <div style="clear: both;"></div>
      <div style="margin-top: 10px;">
        <a href="/campaign/quality_rubberstrap.php"><img data-src="/products/images/banner-quality-2025.webp" class="lazy" width="100%" height="" style="max-width: 770px;"></a>
      </div>
      <?php include("../campaign_news.php"); ?>
      <h2>厚労省の定める規格基準に合格した安全性の高い材料を使用</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/foodproducts.php?data=phonestand" target="_blank"><img class="lazy" data-src="/img/safety-banner.webp" width="745" height="70"></a></div>
      <div style="clear:both;">&nbsp;</div>
      <div id="est-content">

      <?php include('../campaign_banner.php') ?>

        <div style="clear:both;"></div>
        <h2><?= lang('ご注文・見積書作成') ?></h2>
      </div>
      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('ラバースマートフォンスタンド') ?>】</h3>
          <span class="total-price"><span class="prd_total">0</span><?= lang('円（税込）') ?></span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td><?= lang('サイズ') ?></td>
                <td><span id="sample-prd-size">-</span></td>
              </tr>
              <tr>
                <td><?= lang('ご注文タイプ') ?></td>
                <td><span id="sample-prd-pcs">-</span></td>
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
            <img src="/products/images/HM_part1-2.webp" width="320" height="320" id="sample-part-pic" class="picpro"><br />
            <span id="sample-part-name"><?= lang('通常松葉（カニカン）') ?></span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="/products/acrylic/img/coming-soon.webp" width="500" height="500" id="sample-paper-pic" class="picpro"><br />
            <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('スタンドのサイズ・ご注文タイプ・裏面印刷') ?></span>
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
            <input type="text" name="ItemType" id="strap" value="ラバースマートフォンスタンド" />
          </div>
          <?php
          switch ($ItemSize) {
            case "小サイズ":
              $lsSelected_ItemSize_1 = 'checked';
              break;
            case "大サイズ":
              $lsSelected_ItemSize_2 = 'checked';
              break;
            default:
              $lsSelected_ItemSize_1 = 'checked';
              break;
          }
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
            
            <h3><?= lang('スタンドのサイズ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemSize" id="SizeS" value="小サイズ" onclick="clearValue();" <?= $lsSelected_ItemSize_1 ?>><?= lang('小サイズ') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemSize" id="SizeL" value="大サイズ" onclick="clearValue();" <?= $lsSelected_ItemSize_2 ?>><?= lang('大サイズ') ?> <span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_pcs"></span>
            </div>
            <h3><?= lang('ご注文タイプ') ?></h3>
            <?php include('../alert-btn.php') ?>

            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_1pcs ?>><?= lang('スタンダード') ?> <span class="checkmark"></span></label></div>
              <div class="part-content" <?=$delivery_disabled?>><label class="part-name"><input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_4pcs ?>><?= lang('スタンダード（スピード7営業日発送）') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?>><?= lang('プレミアム') ?> <span class="checkmark"></span></label></div>
              <span style="color: red" id="error_pcs"></span>
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
              <font color="red">※<?= lang('プレミアムはシルク印刷代金が無料') ?></font>
            </div>
            <h3><?= lang('汚れ防止加工') ?></h3><a class="btn-details inline" href="javascript:void(0)" for="modal-2" style="cursor: pointer;" onclick="$('#modal-2').prop('checked',true)">詳細</a>
            <input class="modal-state" id="modal-2" type="checkbox">
            <div class="modal">
              <label class="modal__bg" for="modal-2"></label>
              <div class="modal__inner modal1" style="height: fit-content;">
                <label class="modal__close" for="modal-2"></label>
                <img src="/products/images/banner-coating.webp" width="100%" height="327"><br>
                <p>ラバー製品に汚れ防止加工が出来ます。汚れが付着した場合、水洗いして頂くで簡単に汚れが落ちます。</p>
                <p class="red">スタンダード（スピード7営業日発送）では、汚れ防止加工はお選びいただけません。</p>
              </div>
            </div>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="coating" id="coating0" value="汚れ防止加工なし" <?php echo $coating0_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工なし') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="coating" id="coating1" value="汚れ防止加工あり" <?php echo $coating1_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工あり') ?> <span class="checkmark"></span></label>
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
            <input type='hidden' value='なし' name='part'>
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
                    include("../paper_preview.php");
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
                  <?= lang('試作品サンプル') ?>
                </label>
              </div>
              <font color="red">※<?= lang('プレミアムは試作品代金が無料') ?></font>
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
              <font color="red">※<?= lang('プレミアムはトレース代金が無料') ?></font>
            </div>
          </div>
          <div class="estimate-content flex-item" id="step3">
            <div class="flex-container">
              <div class="flex-item">
                <h3><?= lang('製品仕様') ?></h3>
                <table class="table_rubber">
                  <tbody>
                    <tr>
                      <td class="TableLeft"><?= lang('サイズ') ?></td>
                      <td class="" id="prd_ItemSize" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('ご注文タイプ') ?></td>
                      <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
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
                    <tr style="display: none;">
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class="" id="prd_part" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('台紙') ?></td>
                      <td class="" id="prd_paper" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class="" id="prd_SendPrototype" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class="" id="prd_DeFormat" style="text-align: left;"><?= lang('なし') ?></td>
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
                      <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="clearValue();$('#cus_detail').hide();valid_chk_btn2('step1');" />
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn2('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn2('step2');$('#cus_detail').hide();"><?= lang('オプション修正') ?></a>
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');$('.loading').show();" value="御社情報確定（PDF出力）" />
                  <div class="remark">&nbsp;※<?= lang('社名や会社名の入力は任意です') ?></div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <?php $fd_type = "rubberstand";
      $favor = "phonestand";
      include '../rubber_product_detail_test.php'; ?>
      <h2>営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。</h2>
      <center><a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a></center>
      <br />
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../../footer.html'); ?>
  <!--フッター ここまで-->
  <!-- /lightbox2-master -->
  <script src="js/lightbox.js"></script>
  <script>
    lightbox.option({
      'maxWidth': 750,
      'maxHeight': 750,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <!-- /lightbox2-master -->
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <!-- google script -->
  <!-- リマーケティング タグの Google コード -->
  <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->
  <!-- Swiper JS -->
  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/js/_setToInput_2023-test.js?dw=<?php echo date('is') ?>"></script>
  <script language="JavaScript" src="/js/validation_new.js?v=1.10" type="text/javascript"></script>
  <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="/products/acrylic/ptw/photoswipe.min.js?v=1.08"></script>
  <script src="/products/acrylic/ptw/photoswipe-ui-default.min.js"></script>

  <script type="text/javascript">
    $(function() {
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

    /* <![CDATA[ */
    var google_conversion_id = 1036353231;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "ラバースマートフォンスタンド"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
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

    var tmp = "<?= $_GET['mode'] ?>";
    $(function() {
      var t = $("#i_txt1"),
        s = $("#i_txt2");
      screen.width <= 768 && (t.attr("src", "images/img_txt2_n1.svg"), s.attr("src", "images/text_sample_n1.svg"))
    }, (tmp != "" ? valid_chk_btn2('step3') : ""), setToInput());

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
            "padding-bottom": 70
          })
          .animate({
            "height": totalHeight
          });

        $p.fadeOut();

        return false;
      });
    });
    $("input[name='paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    })

    $('.download_temp').on("click", function() {
      $('.download_templete').css("display", "block");
    });

    $('.close').on("click", function() {
      $('.download_templete').css("display", "none");
    });
  </script>
  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
  </script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
    </div>
  </noscript>
</body>

</html>