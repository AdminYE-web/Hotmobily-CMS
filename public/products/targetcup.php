<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
// Error display
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
  <meta name="keywords" content="ターゲットカップ,オリジナル,パター練習">
  <meta name="description" content="チームや会社のロゴを入れたオリジナルゴルフターゲットカップが製作できます。カラビナに刻印可。パター練習用に最適です。">
  <meta name="robots" content="index,follow">
  <title>オリジナルゴルフターゲットカップが製作できます。パター練習用に最適です。</title>
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
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- :: js start :: -->
  <script language="JavaScript" src="../js/calculater_tc_2026.js?v=<?php echo date('is') ?>" type="text/javascript"></script>
  <script type="text/javascript" src="js/pdf_tc_2023.js?v=1.09"></script>
  <!-- :: js end :: -->

  <?php include('../head_products.html'); ?>

  <script>
    $(document).ready(function() {
      $("#clear_txt").click(function() {
        document.getElementById("target").checked = !0, $("input[name=carabiner_type]:first").prop("checked", !0),
          clearColor(), click_typeorder_enabled("standard"), document.getElementById("Quality1").checked = !0, $(
            "#no_of_order").val(""), $("#pricefield7").val(""), $("#pricefield8").val(""), $("#pricefield9").val(
            ""), $("#pricefield10").val(""), $("#pricefield11").val(""), $("#pricefield12").val(""), $(
            "#pricefield13").val(""), $("#pricefield7_n1").val(""), $("#pricefield7_n2").val(""), $(
            "input[name=carabiner]:first").prop("checked", !0), $(".cb_detail").slideUp(), clear_valCal();
      });
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

  <link rel="stylesheet" href="../css/design_estimate_2nd.css" type="text/css" />
  <link href="css/order_2nd.css" rel="stylesheet" type="text/css" media="all" />

  <script language="JavaScript" src="js/common.js" type="text/javascript"></script>
  <script language="JavaScript" src="/js//validation_new.js" type="text/javascript"></script>
  <style type="text/css">
    .TableLeft {
      text-align: left !important;
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

    a.img-hover img {
      transition: all 0.3s ease-in-out;
    }

    a.img-hover:hover img {
      opacity: 0.8;
      box-shadow: 1px 1px 6px grey;
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
      width: 55%
    }

    div#line02 {
      width: 75%
    }

    div#line03 {
      width: 48%
    }

    div#line04 {
      width: 86%
    }

    div#line05 {
      width: 82%
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

    .new-text {
      font-size: 16px !important;
      letter-spacing: 0.05em !important;
      line-height: 150% !important;
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

      #step2 .flex-item label.part-name {
        height: 60px !important;
      }

      #step2 .flex-container {
        height: auto;
      }

      #step2 .preview-sub .flex-item img {
        transform: translateY(30%) !important;
      }
    }

    table.cld_tb {
      margin-top: 10px;
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

    #step2 .flex-item label.part-name {
      display: block;
      width: 85%;
      border: 1px solid lightgray;
      box-shadow: 1px 1px 5px #d3d3d3;
      padding: 5px !important;
      height: 100px;
      margin-bottom: 10px;
      position: relative;
    }

    #step2 .flex-item label.part-name div {
      width: 100%;
      height: 100%;
      color: red;
      display: grid;
      align-items: center;
      justify-content: center;
      font-size: 25px;
    }

    #step2 .flex-item .part-name input:checked~div {
      outline: 2px solid #1e90ff;
      outline-offset: -2px;
    }

    #step2 .carabiner-printng label.part-name {
      padding: 10px !important;
      padding-left: 45px !important;
    }

    .TableLeft {
      color: #000;
    }

    #step2 .paper-container .preview-sub .flex-item label.part-name {
      height: 230px;
    }

    #step2 .preview-sub .flex-item {
      max-width: 25%;
      text-align: center;
    }

    #step2 .preview-sub .flex-item img {
      width: fit-content;
      height: auto;
      max-height: -webkit-fill-available;
      transform: translateY(10%);
      outline: unset;
    }


    span.full-content {
      display: block;
      width: calc(100% - 10px);
      height: calc(100% - 10px);
      position: absolute;
      top: 5px;
    }

    #step2 .flex-item .part-name input:checked~img {
      outline: unset;
    }

    #step2 .flex-item .part-name input:checked~.full-content {
      outline: 2px solid #1e90ff;
      outline-offset: -2px;
    }

    .repeat input[type="text"] {
      padding: 5px 10px;
      margin-left: -32px;
      width: -webkit-fill-available;
    }
  </style>
  <link rel="stylesheet" type="text/css" href="/products/css/foodproducts_banner.css?v=0.03">
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
    <?php include('../sidenavi.php'); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
      <?php include("rubber_info.php"); ?>
      <?php include('banner-campaign.php') ?>
      <h1>オリジナルゴルフターゲットカップが製作できます(2026年版)</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=オリジナルゴルフターゲットカップが製作できます&amp;body=チームや会社のロゴを入れたオリジナルゴルフターゲットカップが製作できます。カラビナに刻印可。パター練習用に最適です。:https://hotmobily.jp/products/targetcup" title="Share by Email" target="_blank">シェアする</a><a href="mailto:?subject=オリジナルゴルフターゲットカップが製作できます&amp;body=チームや会社のロゴを入れたオリジナルゴルフターゲットカップが製作できます。カラビナに刻印可。パター練習用に最適です。:https://hotmobily.jp/products/targetcup" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2ftargetcup" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2ftargetcup&amp;text=チームや会社のロゴを入れたオリジナルゴルフターゲットカップが製作できます。カラビナに刻印可。パター練習用に最適です。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <img src="/products/images/rubber_feature_banner.webp?v=1.02">
      <div style="clear:both;"></div>
      <h2>オリジナルゴルフターゲットカップ</h2>
      <p class="d_TEXT1 new-text">パター練習に最適な、オリジナルゴルフターゲットカップが製作できます。チームや会社のロゴマークを名入れできます。製作前にデータの入稿方法、製作料金、納期、など詳細を確認できます。</p>
      <hr>

      <h2>ラバー製品完全ガイドをご用意！</h2>
      <div>
        <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
      </div>
      <div>
        <p class="new-text">当店のゴルフターゲットカップはラバー製品です。「ラバー製品って素材は安全なの？」「どんな特徴があるの？」などの疑問をお持ちの方もいるかと思います。</p><br>
        <p class="new-text">そんな方へ向けて、ラバー製品の素材の安全性や特徴、ラバー製品でできることなどについての完全ガイドをご用意しました。</p><br>
        <p class="new-text">ベストな仕上がりのゴルフターゲットカップを製作するのに、ぜひともお役立てください。</p>
        <br>
        <div style="text-align: right;">
          <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
        </div>
      </div>

      <hr>
      <h2>仕様</h2>
      </br>
      <table class="table_rubber" cellpadding="5" cellspacing="0" style="width: -webkit-fill-available;">
        <tbody>
          <tr>
            <td><?= lang('名称') ?></td>
            <td><?= lang('ゴルフターゲットカップ') ?></td>
          </tr>
          <tr>
            <td><?= lang('材料') ?></td>
            <td>ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)<br />熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細は<a href="quality.html#qa_point">こちら</a>。</td>
          </tr>
          <tr>
            <td><?= lang('製品サイズ') ?></td>
            <td><?= lang('直径110mm程度の円形もしくは類似形状。（このサイズを大きく超える製品は、別途費用がかかります）') ?></td>
          </tr>
          <tr>
            <td><?= lang('厚さ') ?></td>
            <td><?= lang('円形部約3mm。縁部分最大8mm程度。肉厚指定のある場合、事前にご相談下さい。') ?></td>
          </tr>
          <tr>
            <td><?= lang('色数') ?></td>
            <td><?= lang('スタンダードの場合12色まで、プレミアムの場合18色までご使用頂けます。') ?><br><?= lang('印刷物ではないため、グラデーションは表現できません。') ?></td>
          </tr>
          <tr>
            <td><?= lang('裏面印刷') ?></td>
            <td><?= lang('単色（シルク）印刷、カラー印刷ともに可能です。プレミアムの場合は無料、スタンダードの場合は単色が＋@33円（税込）、カラーが＋@55円（税込）となります。') ?>
            </td>
          </tr>
          <tr>
            <td><?= lang('最小製作個数（最小ロット）') ?></td>
            <td>
              <?= lang('100個より製作します。') ?>
            </td>
          </tr>
          <tr>
            <td><?= lang('台紙') ?></td>
            <td>
              既製品：50種類のデータから選択可 <br>
              オリジナル印刷：お客様の入稿データを使用し、印刷します <br>
              支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。
            </td>
          </tr>
        </tbody>
      </table>
      <div>&nbsp;</div>
      <div style="display: flex;width: 100%">
        <div style="width: 50%">
          <a href="img/targetcup1_B.webp" data-lightbox="target-set1" data-title="" style="text-decoration:none;">
            <img src="img/targetcup1_B.webp" width="100%" height="403" />
          </a>
        </div>
        <div style="width: 50%">
          <a href="img/targetcup2_B.webp" data-lightbox="target-set1" data-title="" style="text-decoration:none;">
            <img src="img/targetcup2_B.webp" width="100%" height="403" />
          </a>
        </div>
      </div>
      <div style="display: flex;width: 100%">
        <div style="width: 50%">
          <a href="img/targetcup3_B.webp" data-lightbox="target-set1" data-title="" style="text-decoration:none;">
            <img src="img/targetcup3_B.webp" width="100%" height="403" />
          </a>
        </div>
        <div style="width: 50%">
          <a href="img/targetcup4_B.webp" data-lightbox="target-set1" data-title="" style="text-decoration:none;">
            <img src="img/targetcup4_B.webp" width="100%" height="403" />
          </a>
        </div>
      </div>
      <div style="display: flex;width: 100%">
        <div style="width: 50%">
          <a href="img/targetcup5_B.webp" data-lightbox="target-set1" data-title="" style="text-decoration:none;">
            <img src="img/targetcup5_B.webp" width="100%" height="403" />
          </a>
        </div>
        <div style="width: 50%">
          <a href="img/targetcup6_B.webp" data-lightbox="target-set1" data-title="" style="text-decoration:none;">
            <img src="img/targetcup6_B.webp" width="100%" height="403" />
          </a>
        </div>
      </div>
      <a href="img/targetcup1_B.webp" data-lightbox="target-set2" style="text-decoration:none; font-size:10px;">📷クリックすると拡大します</a>
      <a href="img/targetcup2_B.webp" data-lightbox="target-set2"></a>
      <a href="img/targetcup3_B.webp" data-lightbox="target-set2"></a>
      <a href="img/targetcup4_B.webp" data-lightbox="target-set2"></a>
      <a href="img/targetcup5_B.webp" data-lightbox="target-set2"></a>
      <a href="img/targetcup6_B.webp" data-lightbox="target-set2"></a>
      <br>
      <div style="clear:both;">&nbsp;</div>
      <div class="flex-container" style="padding-top: 8px;">
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="download/download.php?fname=template-pvc targetcup.zip">
              <span><?= lang('テンプレート') ?></span></a>
            <a class="btn-a btn-yellow" href="/products/data" target="_blank"><span><?= lang('入稿データ作成') ?></span></a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/howtoorder/" target="_blank"><span><?= lang('ご注文の流れ') ?></span></a>
            <a class="btn-a btn-yellow" href="/contact/?item=ラバーストラップ"><span><?= lang('無料サンプル') ?></span></a>
          </div>
        </div>
      </div>
      <div class="row how" style="margin-top: -8px;">
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
      </div>
      <div class="flex-container">
        <div class="flex-item item">
          <div class="btn-container item_btn"><a class="btn-a ord-btn" href="#est-content"><?= lang('ご注文') ?></a></div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn"><a class="btn-a est-btn" href="#est-content"><?= lang('見積書作成') ?></a>
          </div>
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
      <hr />
      <h2>厚労省の定める規格基準に合格した安全性の高い材料を使用</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/foodproducts.php?data=targetcup" target="_blank"><img class="lazy" data-src="/img/safety-banner.webp" width="745" height="70"></a></div>
      <div style="clear:both;">&nbsp;</div>
      <h2>製作料金一覧</h2><br />
      <p class="new-text">オリジナルゴルフターゲットカップの製作料金 = 円形の本体 + カラビナ（任意）</p>
      <img src="img/targetpluscara.webp" width="756" height="160" style="max-width: 100%;">
      <hr>
      <h2>ターゲットカップ本体部分</h2><br />
      <span class="new-text">スタンダード *カラビナ別途。ラバー部分本体のみ</span>
      <div class="tbl_s">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="width: -webkit-fill-available;border-collapse:collapse;">
          <tbody>
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
              <td>892 円</td>
              <td>728 円</td>
              <td>563 円</td>
              <td>495 円</td>
              <td>276 円</td>
              <td>173 円</td>
              <td>154 円</td>
            </tr>
            <tr align="center">
              <td>税込総額</td>
              <td>(89,200 円)</td>
              <td>(145,800 円)</td>
              <td>(168,900 円)</td>
              <td>(247,500 円)</td>
              <td>(276,000 円)</td>
              <td>(519,000 円)</td>
              <td>(770,000 円)</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br />
      </div>
      <span class="new-text">スタンダード（スピード発送）*カラビナ別途。ラバー部分本体のみ</span>
      <div class="tbl_s">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tbody>
            <tr align="center">
              <td></td>
              <td>100個～</td>
              <td>200個～</td>
            </tr>
            <tr align="center">
              <td>製品単価</td>
              <td>1,013 円</td>
              <td>849 円</td>
            </tr>
            <tr align="center">
              <td>税込総額</td>
              <td>(101,300 円)</td>
              <td>(169,800 円)</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは200個となります。') ?><br />
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br />
        ※<?= lang('汚れ防止加工はできません。') ?><br />
      </div>
      <p class="new-text">プレミアム *カラビナ別途。ラバー部分本体のみ</p>
      <div class="tbl_s">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tbody>
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
              <td>1,072 円</td>
              <td>875 円</td>
              <td>677 円</td>
              <td>594 円</td>
              <td>332 円</td>
              <td>210 円</td>
              <td>184 円</td>
            </tr>
            <tr align="center">
              <td>税込総額</td>
              <td>(107,200 円)</td>
              <td>(175,000 円)</td>
              <td>(203,100 円)</td>
              <td>(297,000 円)</td>
              <td>(332,000 円)</td>
              <td>(630,000 円)</td>
              <td>(920,000 円)</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('プレミアムでは、試作品、裏面印刷、トレース代金は無料です。') ?><br />
      </div>
      <hr>
      <h2>カラビナ部分</h2>
      <p class="d_TEXT1 new-text">カラビナは廉価版カラビナ、高級版Mサイズ、高級版Lサイズよりご選択頂けます。また、カラビナを装着しない仕様でもご注文可能でございます。</p>
      <h3 class="new-text">廉価版カラビナ</h3><br />
      <a href="img/cb_type0_ss.webp" data-lightbox="imgcb-set1" style="text-decoration:none;">
        <img src="img/cb_type0_ss.webp" width="254" height="212">
      </a>
      <br />
      <a href="img/cb_type0_ss.webp" data-lightbox="imgcb-set4" style="text-decoration:none; font-size:10px;">📷クリックすると拡大します</a>
      <br><br />
      <span class="red new-text">廉価版カラビナ仕様</span><br />
      <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tbody>
          <tr>
            <td width="30%">サイズ(横幅)</td>
            <td width="70%">60mm</td>
          </tr>
          <tr>
            <td>本体材質</td>
            <td>アルミ製</td>
          </tr>
          <tr>
            <td>本体色</td>
            <td>シルバー</td>
          </tr>
          <tr>
            <td>重量</td>
            <td>7g</td>
          </tr>
        </tbody>
      </table><br />
      <span class="red new-text">カラビナ単体 (廉価版)</span>
      <div class="tbl_s">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tbody>
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
              <td>61 円</td>
              <td>57 円</td>
              <td>52 円</td>
              <td>45 円</td>
              <td>38 円</td>
              <td>30 円</td>
              <td>29 円</td>
            </tr>
            <tr align="center">
              <td>税込総額</td>
              <td>(6,100 円)</td>
              <td>(11,400 円)</td>
              <td>(15,600 円)</td>
              <td>(22,500 円)</td>
              <td>(38,000 円)</td>
              <td>(90,000 円)</td>
              <td>(145,000 円)</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="font_s" style="text-align: right;">
        ※カラビナ単体 (廉価版)の料金表です。<br />
        ※上記価格は税込み価格です。<br />
        ※名入れはできません。
      </p>
      <br />
      <h3 class="new-text">高級版Mサイズ</h3><br />
      <div style="display: flex;">
        <div style="padding:1px;width: 33%">
          Mサイズ 光沢<br>
          <a href="/products/carabiner/images/cb_gs_red_sb.webp" data-lightbox="imgcb-set1" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_gs_red_ss.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Mサイズ 光沢<br>
          <a href="/products/carabiner/images/cb_gs_black_sb.webp" data-lightbox="imgcb-set1" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_gs_black_ss.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Mサイズ 光沢<br>
          <a href="/products/carabiner/images/cb_gs_slv_sb.webp" data-lightbox="imgcb-set1" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_gs_slv_ss.webp" width="100%" height="129">
          </a>
        </div>
      </div>
      <div style="display: flex;">
        <div style="padding:1px;width: 33%">
          Mサイズ マット(艶消し)<br>
          <a href="/products/carabiner/images/cb_mat_red_sb.webp" data-lightbox="imgcb-set1" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_mat_red_ss.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Mサイズ マット(艶消し)<br>
          <a href="/products/carabiner/images/cb_mat_black_sb.webp" data-lightbox="imgcb-set1" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_mat_black_ss.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Mサイズ マット(艶消し)<br>
          <a href="/products/carabiner/images/cb_mat_slv_sb.webp" data-lightbox="imgcb-set1" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_mat_slv_ss.webp" width="100%" height="129">
          </a>
        </div>
      </div>
      <br />
      <a href="/products/carabiner/images/cb_gs_red_sb.webp" data-lightbox="imgcb-set3" style="text-decoration:none; font-size:10px;">📷クリックすると拡大します</a>
      <a href="/products/carabiner/images/cb_gs_black_sb.webp" data-lightbox="imgcb-set3"></a>
      <a href="/products/carabiner/images/cb_gs_slv_sb.webp" data-lightbox="imgcb-set3"></a>
      <a href="/products/carabiner/images/cb_mat_red_sb.webp" data-lightbox="imgcb-set3"></a>
      <a href="/products/carabiner/images/cb_mat_black_sb.webp" data-lightbox="imgcb-set3"></a>
      <a href="/products/carabiner/images/cb_mat_slv_sb.webp" data-lightbox="imgcb-set3"></a>
      <br /><br />
      <span class="red new-text">高級版Mサイズ仕様</span><br />
      <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tbody>
          <tr>
            <td width="30%">サイズ(横幅)</td>
            <td width="70%">Mサイズ(60mm)</td>
          </tr>
          <tr>
            <td>本体材質</td>
            <td>アルミ製</td>
          </tr>
          <tr>
            <td>本体色</td>
            <td>ルビーレッド、ブラック、シルバーの3色</td>
          </tr>
          <tr>
            <td>重量</td>
            <td>10g</td>
          </tr>
        </tbody>
      </table><br />
      <span class="red new-text">カラビナ単体 (高級版Mサイズ)</span>
      <div class="tbl_s">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tbody>
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
              <td>163 円</td>
              <td>150 円</td>
              <td>136 円</td>
              <td>123 円</td>
              <td>99 円</td>
              <td>77 円</td>
              <td>73 円</td>
            </tr>
            <tr align="center">
              <td>税込総額</td>
              <td>(16,300 円)</td>
              <td>(30,000 円)</td>
              <td>(40,800 円)</td>
              <td>(61,500 円)</td>
              <td>(99,000 円)</td>
              <td>(231,000 円)</td>
              <td>(365,000 円)</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="font_s" style="text-align: right;">
        ※カラビナ単体 (高級版Mサイズ)の料金表です。<br />
        ※上記価格は税込み価格です。<br />
        ※レーザー刻印で名入れができます。<br /><br />
        レーザー刻印（白色のみ）<br />
        &nbsp;&nbsp;片面印刷代金 22円<br />
        &nbsp;&nbsp;両面印刷代金 33円
      </p><br />
      <br />
      <h3 class="new-text">高級版Lサイズ</h3><br />
      <div style="display: flex;">
        <div style="padding:1px;width: 33%">
          Lサイズ 光沢<br>
          <a href="/products/carabiner/images/cb_gs_red_lb.webp" data-lightbox="imgcb-set2" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_gs_red_ls.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Lサイズ 光沢<br>
          <a href="/products/carabiner/images/cb_gs_black_lb.webp" data-lightbox="imgcb-set2" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_gs_black_ls.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Lサイズ 光沢<br>
          <a href="/products/carabiner/images/cb_gs_slv_lb.webp" data-lightbox="imgcb-set2" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_gs_slv_ls.webp" width="100%" height="129">
          </a>
        </div>
      </div>
      <div style="display: flex;">
        <div style="padding:1px;width: 33%">
          Lサイズ マット(艶消し)<br>
          <a href="/products/carabiner/images/cb_mat_red_lb.webp" data-lightbox="imgcb-set2" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_mat_red_ls.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Lサイズ マット(艶消し)<br>
          <a href="/products/carabiner/images/cb_mat_black_lb.webp" data-lightbox="imgcb-set2" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_mat_black_ls.webp" width="100%" height="129">
          </a>
        </div>
        <div style="padding:1px;width: 33%">
          Lサイズ マット(艶消し)<br>
          <a href="/products/carabiner/images/cb_mat_slv_lb.webp" data-lightbox="imgcb-set2" style="text-decoration:none;">
            <img src="/products/carabiner/images/cb_mat_slv_ls.webp" width="100%" height="129">
          </a>
        </div>
      </div>
      <br />
      <a href="/products/carabiner/images/cb_gs_red_lb.webp" data-lightbox="imgcb-set5" style="text-decoration:none; font-size:10px;">📷クリックすると拡大します</a>
      <a href="/products/carabiner/images/cb_gs_black_lb.webp" data-lightbox="imgcb-set5"></a>
      <a href="/products/carabiner/images/cb_gs_slv_lb.webp" data-lightbox="imgcb-set5"></a>
      <a href="/products/carabiner/images/cb_mat_red_lb.webp" data-lightbox="imgcb-set5"></a>
      <a href="/products/carabiner/images/cb_mat_black_lb.webp" data-lightbox="imgcb-set5"></a>
      <a href="/products/carabiner/images/cb_mat_slv_lb.webp" data-lightbox="imgcb-set5"></a>
      <br /><br />
      <span class="red new-text">高級版Lサイズ仕様</span><br />
      <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tbody>
          <tr>
            <td width="30%">サイズ(横幅)</td>
            <td width="70%">Lサイズ(70mm)</td>
          </tr>
          <tr>
            <td>本体材質</td>
            <td>アルミ製</td>
          </tr>
          <tr>
            <td>本体色</td>
            <td>ルビーレッド、ブラック、シルバーの3色</td>
          </tr>
          <tr>
            <td>重量</td>
            <td>14g</td>
          </tr>
        </tbody>
      </table><br />
      <span class="red new-text">カラビナ単体 (高級版Lサイズ)</span>
      <div class="tbl_s">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tbody>
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
              <td>235 円</td>
              <td>215 円</td>
              <td>194 円</td>
              <td>177 円</td>
              <td>140 円</td>
              <td>108 円</td>
              <td>103 円</td>
            </tr>
            <tr align="center">
              <td>税込総額</td>
              <td>(23,500 円)</td>
              <td>(43,000 円)</td>
              <td>(58,200 円)</td>
              <td>(88,500 円)</td>
              <td>(140,000 円)</td>
              <td>(324,000 円)</td>
              <td>(515,000 円)</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="font_s" style="text-align: right;">
        ※カラビナ単体 (高級版Lサイズ)の料金表です。<br />
        ※上記価格は税込み価格です。<br />
        ※レーザー刻印で名入れができます。<br /><br />
        レーザー刻印（白色のみ）<br />
        &nbsp;&nbsp;片面印刷代金 22円<br />
        &nbsp;&nbsp;両面印刷代金 33円
      </p>
      <hr>
      <h2>スタンダードとプレミアムの違い</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/product-difference.php?data=2" target="_blank"><img src="/img/top4-banner.webp" width="745" height="350"></a></div>
      <h2>製作納期</h2>
      <?php include('../notice.html'); ?>
      <p class="d_TEXT1 new-text">
        納期：<br>
        <span class="red new-text">下記日数は全て営業日。</span><br>
        納期=製作日数+配送日数で定義されるものとします。<br>
        営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。中国春節、国慶節期間につきましては、別途定める休日が指定されます。<br>シルク印刷ありでのご注文の場合、+1営業日<br>色味指定を印刷紙で行う場合、+3営業日<br>※お客様から印刷紙手配が遅れる場合、この限りではございません。
      </p>
      <p class="new-text">◆<?= lang('スタンダード製作期間（単位：営業日。配送日数は含まず）') ?></p>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="width: -webkit-fill-available;border-collapse:collapse;">
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
          <td align="center">8</td>
          <td align="center">13</td>
          <td align="center">21～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">10</td>
          <td align="center">14</td>
          <td align="center">22～</td>
        </tr>
      </table><br />

      <p class="new-text">◆<?= lang('スタンダード（スピード発送）製作期間（単位：営業日。配送日数は含まず）') ?></p>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="width: -webkit-fill-available;border-collapse: collapse;">
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
          <td align="center">7</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">7</td>
        </tr>
      </table><br />

      <p class="new-text">◆<?= lang('プレミアム製作期間（単位：営業日。配送日数は含まず）') ?></p>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="width: -webkit-fill-available;border-collapse:collapse;">
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
          <td align="center">15</td>
          <td align="center">20</td>
          <td align="center">28～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">19</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
      </table><br />
      <p class="d_TEXT1 new-text">◆配送日数：1-2営業日</p>
      <p class="d_TEXT1 new-text">
        ◇例）<br>
        スタンダード<br>
        300個<br>
        試作品なしの場合
      </p>
      <p class="d_TEXT1 new-text">
        ・製作期間：10営業日<br>
        ・配送期間：1-2営業日<br>
        合計：11-12営業日となります。
      </p>
      <hr>
      <div id="pro1" style="margin-top: 10px;">
        <img src="img/promotion-2.webp" alt="全数国内検品のラバーストラップ" width="185" height="123">
        <img src="img/promotion-7.webp" alt="ラバーストラップは10営業日で製作" width="185" height="123">
      </div>
      <div id="pro2" style="margin-top: 10px;">
        <img src="img/promotion-12.webp" alt="ラバーストラップを12色まで均一料金で製作" width="185" height="123">
        <img src="img/promotion-18.webp" alt="ラバーストラップを15色まで均一料金で製作" width="185" height="123">
      </div>
      <div style="clear:both;">&nbsp;</div>
      <div id="est-content">

        <?php include('campaign_banner.php') ?>

        <h2><?= lang('ご注文・見積書作成') ?></h2>
      </div>
      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('ゴルフターゲットカップ') ?>】</h3>
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
            <div id="sample-part-pic"></div>
            <span id="sample-part-name"></span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img data-src="/products/acrylic/img/coming-soon.webp" width="135" height="135" id="sample-paper-pic" class="picpro lazy"><br />台紙:<span id="sample-paper-name">なし</span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ・裏面印刷') ?></span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div><span class="step-details"><?= lang('カラビナ・台紙等') ?></span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="ゴルフターゲットカップ" />
            <input type="hidden" id="ms_mode" value="<?php echo (isset($_GET['mode']) ? $_GET['mode'] : "") ?>">
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
            case "トリプルベネフィットキャンペーン":
              $lsSelected_0pcs = 'checked';
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

          switch ($carabiner_print) {
            case "刻印なし":
              $carabiner_print0_checked = 'checked';
              break;
            case "刻印あり（表）":
              $carabiner_print1_checked = 'checked';
              break;
            case "刻印あり（表+裏）":
              $carabiner_print2_checked = 'checked';
              break;
            default:
              $carabiner_print0_checked = 'checked';
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
                  <div class="icon-img"><img class="lazy" data-src="/products/images/icon-standard-pc.webp" width="122" height="122"></div>
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
              </div>
            </div>
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_1pcs ?>><?= lang('スタンダード') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_4pcs ?>><?= lang('スタンダード（スピード7営業日発送）') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?>><?= lang('プレミアム') ?> <span class="checkmark"></span></label></div>
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
            <h3><?= lang('カラビナ') ?></h3>
            <div class="flex-container">
              <div class="preview-container">
                <div class="preview-sub flex-container">
                  <?php include('part-carabiner.php');
                  $i = 0;
                  for ($i = 0; $i < count($attachment); $i++) {
                    echo '
											<div class="flex-item">
												<label class="part-name">
													<input type="radio" name="part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($part == $attachment[$i]["part_name"] ? 'checked' : ($i == 0 ? 'checked' : '')) . '>
													';
                    if ($attachment[$i]["part_pic"] == "") {
                      echo '<div>なし</div><span class="full-content"></span>';
                    } else {
                      echo '<img data-src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="lazy" style="' . ($attachment[$i]["part_name"] == "廉価版カラビナ" ? 'transform: translateY(0%)!important;' : '') . '"><span class="full-content"></span>';
                    }
                    echo '<br></label><span>' . $attachment[$i]["part_name"] . '</span>
											</div>';
                  } ?>
                </div>
              </div>
            </div>

            <h3 class="carabiner-printng" style="<?= ($part != "" ? ($part != "廉価版カラビナ" ? '' : 'display:none;') : 'display:none;') ?>"><?= lang('カラビナレーザー刻印') ?></h3>
            <div class="carabiner-printng" class="part-container" style="<?= ($part != "" ? ($part != "廉価版カラビナ" ? '' : 'display:none;') : 'display:none;') ?>">
              <div class="part-content"><label class="part-name"><input type="radio" name="carabiner_print" value="刻印なし" <?php echo $carabiner_print0_checked ?> onclick="clearValue();" /><?= lang('刻印なし') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="carabiner_print" value="刻印あり（表）" <?php echo $carabiner_print1_checked ?> onclick="clearValue();" /><?= lang('刻印あり（表）') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="carabiner_print" value="刻印あり（表+裏）" <?php echo $carabiner_print2_checked ?> onclick="clearValue();" /><?= lang('刻印あり（表+裏）') ?> <span class="checkmark"></span></label></div>
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
                    include("paper_preview.php");
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
                      <td class="TableLeft"><?= lang('カラビナ') ?></td>
                      <td class="" id="prd_part" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('カラビナレーザー刻印') ?></td>
                      <td class="" id="prd_part_printing" style="text-align: left;">刻印なし</td>
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
                <table class="table_rubber total_price_tbl" style="width: -webkit-fill-available;">
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
                      <td class="TableLeft"><?= lang('カラビナ') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('カラビナ刻印代金') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrintingPrice" readonly="readonly" id="textfield7_3" class="right" value="<?= $PartPrintingPrice ?>">円</td>
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
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn('back')">戻る</a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')">カラビナ・オプション入力へ</a>
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="Javascript:validate('gcd');$('.loading').show();" value="<?= lang('御社情報確定（PDF出力）') ?>" />
                  <div class="remark">&nbsp;<?= lang('※社名や会社名の入力は任意です') ?></div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr />
      <?php $fd_type = "rubberstrap";
      include 'rubber_product_detail_test.php'; ?>
      <h2><?= lang('営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <div align="center">
        <a href="//hotmobily.jp/meeting_date/"><img data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" class="lazy" /></a>
      </div>
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../footer.html'); ?>
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
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript">
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "ラバーストラップ"
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
    $("input[name='paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    });


    $(function() {
      var s = $("#i_txt2");
      screen.width <= 768 && (s.attr("src", "images/text_sample_n1.svg"))
    });
    var tmp = "<?= $_GET['mode'] ?>";
    $(function() {
      var t = $("#i_txt1"),
        s = $("#i_txt2");
      screen.width <= 768 && (t.attr("src", "images/img_txt2_n1.svg"), s.attr("src", "images/text_sample_n1.svg"))
    }, getPartData($('input[name="part"]:checked').val()), (tmp != "" ? valid_chk_btn('step3') : ""));

    function next_area(tmp) {
      if (screen.width <= 768) {
        switch (tmp) {
          case 'itemType':
            $('#100').show();
            $('#200').show();
            $('#300').show();
            $('#400').show();
            $('.area2').show();
            break;
          case 'cal':
            $('#menu2').show();
            $('#menu3').show();
            break;
        }
      }
    }

    function show_input(type) {
      switch (type) {
        case 'show':
          $('#number_other').show();
          break;
        case 'hide':
          $('#number_other').hide();
          break;
      }
    }
  </script>
</body>

</html>