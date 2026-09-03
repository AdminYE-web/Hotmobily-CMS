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
} else if ($msMode == "") {
  //start order with fresh session
  // session_unset();
  // session_destroy();
} elseif ($msMode === "MODE_RESET") {
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
  <meta name="keywords" content="携帯クリーナー,ラバー,オリジナル,作成,製作">
  <meta name="description" content="オリジナル携帯クリーナーが製作できます。表面はラバーストラップと同一素材。裏面はマイクロファイバーの本格派。同人からイベント、ノベルティまで。">
  <meta name="robots" content="index,follow" />
  <title>オリジナル携帯クリーナーが製作できます。表面はラバーストラップと同一素材。裏面はマイクロファイバーの本格派。</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <?php include("../../head_products.html"); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
  <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">
  <link rel="stylesheet" type="text/css" href="../css/scroll.css">
  <link href="/css/rubber.css?v=1.02" rel="stylesheet" type="text/css" />
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

    .tag-menu {
      font-weight: 700
    }

    .tag-name {
      font-weight: 400
    }

    #est-content h2 {
      font-size: 25px;
      text-align: center;
      color: #000
    }

    .gallbox {
      width: 33%;
      text-align: center
    }

    .picpro {
      border: 1px solid lightgray;
      box-shadow: 1px 1px 5px #d3d3d3;
      margin: 5px
    }

    .camera-left {
      width: 90%;
      text-align: left !important
    }

    @media (max-width: 576px) {
      label.part-name img {
        width: calc(100% - 5px) !important;
      }

      #step2 .flex-container {
        overflow-x: hidden;
      }

      .mt-10-part {
        min-width: 32%;
        max-width: 32%
      }

      .preview-sub .hover {
        max-width: 19.67%
      }

      input[name="numberOf"] {
        width: calc(100% - 200px)
      }

      .prodate {
        width: 90%;
        margin: 0;
        font-size: 13px;
        font-weight: 500
      }

      div.gall_pro {
        justify-content: flex-start;
      }

      #label-qty {
        justify-content: space-between
      }

      .gallbox {
        width: 50%;
        text-align: left
      }

      .gall_pro .gallbox {
        display: none
      }

      .gallbox:nth-child(1),
      .gallbox:nth-child(2),
      .gallbox:nth-child(3),
      .gallbox:nth-child(4),
      .gallbox:nth-child(5),
      .gallbox:nth-child(6),
      .gallbox:nth-child(7),
      .gallbox:nth-child(8) {
        display: block
      }

      .flex-container.b-bottom.p-bottom {
        display: block;
      }

      div.icon-text {
        width: 100%;
      }

      div.icon-img {
        width: 20%;
      }
    }

    .icon-img {
      width: calc(20% - 10px);
      padding-right: 10px;
      display: block;
      float: left
    }

    .icon-img img {
      width: 100%;
      max-width: 140px;
    }

    .icon-text {
      width: 80%;
      text-align: justify;
      display: block
    }

    .icon-text h4 {
      font-size: 20px;
      margin-bottom: 10px;
      display: block
    }

    .b-bottom {
      border-bottom: 1px solid lightgray
    }

    .p-bottom {
      margin-bottom: 15px;
      padding-bottom: 10px
    }

    .icon-text p {
      display: block;
      clear: both;
      line-height: 2;
    }

    span.tag-name.non-active {
      background: #2196f3;
      border: unset;
      border-radius: 2px;
      padding: 2px 16px;
      margin-bottom: 0;
      font-size: 11px;
    }

    a.btn-details {
      display: inline-block;
      margin-left: 10px;
      padding: 3px 15px;
      text-decoration: none !important;
      cursor: pointer;
      color: #595a5a;
      border-radius: 5px;
      border: 1px solid lightgray;
      transition-duration: .2s
    }

    a.btn-details:hover {
      color: #09f;
      background: #fff;
      border: 1px solid #09f;
      transition-duration: .2s
    }

    h3 {
      display: inline-block
    }

    .under-line {
      font-family: IwaUDGoDspPro-Eb, sans-serif !important;
      text-decoration: underline;
    }

    .but3 {
      padding: 8px 0;
      border: 1px solid #b5b5b5;
      box-shadow: 0px 2px 6px #b5b5b5;
      border-radius: 5px;
      background-image: linear-gradient(#f7f7f7, #dbdbdb);
      transition: all 0.3s ease-in-out;
    }

    .but3:hover {
      opacity: 0.8;
      box-shadow: 0px 2px 6px #666666;
    }

    .se-color {
      margin-bottom: 10px;
      width: 100%
    }

    .se-color .preview-container {
      background: none;
      display: block;
      width: 100%
    }

    .se-color .preview-sub {
      justify-content: flex-start
    }

    .se-color .preview-sub .flex-item img {
      width: auto;
      margin-bottom: 5px;
      max-width: 100%;
      outline: .5px solid #f8f8f8;
      outline-offset: -1px
    }

    .se-color .part-name input:checked~img {
      outline: 2px solid #1e90ff;
      outline-offset: -2px
    }

    .se-color .preview-sub .flex-item {
      max-width: 20%;
      text-align: center
    }

    .se-color .flex-item .part-name {
      display: block;
      width: 100%
    }

    .se-color .flex-item {
      max-width: 100%;
      width: 100%
    }

    .se-color label.part-name {
      padding: 0 !important
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

    .group-container .btn-select:has(input[type=radio]:checked) {
      border: 1px solid #ffffff;
      background: #f7b516;
      color: white;
    }

    .btn-select input[type="radio"] {
      opacity: 0;
      width: 0;
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
    <?= ($_SESSION['lang'] == "kr" ? 'body{font-family: "돋움체",DotumChe,serif!important;}#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}.prodate{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body{font-family: "Prompt", sans-serif!important;}#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}.prodate{font-family: "Prompt", sans-serif!important;}' : '') ?>
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

  <!-- lightbox2-master -->
  <link rel="stylesheet" href="css/lightbox.css">
  <!-- /lightbox2-master -->
  <link rel="stylesheet" type="text/css" href="/products/css/foodproducts_banner.css?v=0.03">
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
      <h1>オリジナル携帯クリーナーが製作できます。表面はラバーストラップと同一素材。裏面はマイクロファイバーの本格派。 (2025年版)</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナル携帯クリーナーが製作できます。表面はラバーストラップと同一素材。裏面はマイクロファイバーの本格派。同人からイベント、ノベルティまで。%0A%0A詳細はこちら:https://hotmobily.jp/products/rubbercleaner/" title="Share by Email" target="_blank">シェアする</a>
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナル携帯クリーナーが製作できます。表面はラバーストラップと同一素材。裏面はマイクロファイバーの本格派。同人からイベント、ノベルティまで。%0A%0A詳細はこちら:https://hotmobily.jp/products/rubbercleaner/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubbercleaner%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubbercleaner%2f&amp;text=オリジナル携帯クリーナーが製作できます。表面はラバーストラップと同一素材。裏面はマイクロファイバーの本格派。同人からイベント、ノベルティまで。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2025年1月29日</span>
      </div>
      <div class="flex-container">
        <div class="flex-item item">
          <div class="preview-container">
            <div class="preview-top my-gallery">
              <div id="box-show-id-1">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_01" src="img/rubber-1.webp" width="376" height="231" data-zoom-image="img/rubber-1.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-2">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_02" src="img/rubber-2.webp" width="376" height="231" data-zoom-image="img/rubber-2.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-3">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_03" src="img/rubber-3.webp" width="376" height="231" data-zoom-image="img/rubber-3.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-4">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_04" src="img/rubber-4.webp" width="376" height="231" data-zoom-image="img/rubber-4.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
            </div>
            <div class="preview-sub flex-container">
              <div class="flex-item"><img src="img/rubber-1.webp" width="90" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();">
              </div>
              <div class="flex-item"><img src="img/rubber-2.webp" width="90" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();">
              </div>
              <div class="flex-item"><img src="img/rubber-3.webp" width="90" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();">
              </div>
              <div class="flex-item"><img src="img/rubber-4.webp" width="90" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();">
              </div>
            </div>
          </div>
          <div style="font-size: 12px;" class="camera-preview">📷大きな画像にマウスを合わせると拡大されます</div>
          <div class="ptw-container"></div>
        </div>
        <div class="flex-item item" style="line-height: 2;">
          <p>ラバー表面のオリジナル携帯クリーナーが製作できます。</p>
          <p>裏面はマイクロファイバー極細繊維なので、画面の汚れをきれいに拭きとることが可能。</p>
          <p>裏面の色は10色からお選びいただけます。</p><br />

          <p>何度でも洗って使えるので、清潔な状態を保てます。</p>
          <p>イベントグッズやノベルティとしても最適です。</p>
        </div>
      </div>
      <div style="clear:both;">&nbsp;</div>
      <div id="pro1">
        <img src="images/mini-banner_1.webp" width="185" height="123">
        <img src="images/mini-banner_2.webp" width="185" height="123">
      </div>
      <div id="pro2">
        <img src="images/mini-banner_3.webp" width="185" height="123">
        <img src="images/mini-banner_4.webp" width="185" height="123">
      </div>
      <div style="clear:both;"></div>
      <h2>オリジナルの携帯クリーナーが製作できます</h2>
      <p class="d_TEXT1">
        表面がラバーストラップ（ラバスト）と全く同じ素材・構造のスマホクリーナーが作れます。ラバスト特有の表面の凹凸構造がありますので、ラバストファンにはたまらない商品です。クリーナーの形状や色は自由自在。ラバーストラップと同一設計となります。（厚さが異なります）
      </p><br />
      <p class="d_TEXT1">
        裏面は、メガネ拭きやPCモニターのクリーニングにも使用されているマイクロファイバー極細繊維素材を使用し、油で汚れたスマホや携帯の画面が簡単に綺麗になります。スマホの画面がぜんぜん綺麗にならない、なんちゃって携帯クリーナーが多い中で、本格派の製品です。また、裏面が汚れたら水洗いする事で綺麗になりますので、何度でも使えます。実用度の高いノベルティとして人気の製品です。
      </p><br />
      <p class="d_TEXT1">
        大きさもラバーストラップと同じ70X70mm程度ですので、バック等に取り付けて持ち運びも便利です。製作可能個数もラバーストラップと同じ、100個から製作できますので、会社やチームの記念品として最適です。
      </p>
      <hr>
      <h2>スマホクリーナー（ラバストタイプ）とは、どんな製品？</h2>
      <div class="block-g">
        <div class="block-title" style="background: #febc28;">SMART PHONE SCREEN CLEANER RUBBER SURFACE TYPE - FRONT
        </div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/rubbercleaner-01z.webp" data-lightbox="imgst-set" style="text-decoration:none;">
              <img src="images/rubbercleaner-01.webp" width="453" height="268">
            </a>
          </div>
          <div class="bp2">
            <a href="images/rubbercleaner-02z.webp" data-lightbox="imgst-set" style="text-decoration:none;">
              <img src="images/rubbercleaner-02.webp" width="239" height="268">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/rubbercleaner-01z.webp" data-lightbox="imgst-set01" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します</a>
          <a href="images/rubbercleaner-02z.webp" data-lightbox="imgst-set01"></a>
        </div>
        <div class="b-text">表面はラバーストラップと同じ素材・構造です。通常のラバーストラップの厚さを薄くして使用します。</div>
      </div>
      <div class="block-g">
        <div class="block-title" style="background: rgb(146,208,80);">SMART PHONE SCREEN CLEANER RUBBER SURFACE TYPE -
          BACK</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/rubbercleaner-03z.webp" data-lightbox="imgst-set2" style="text-decoration:none;">
              <img src="images/rubbercleaner-03.webp" width="453" height="268">
            </a>
          </div>
          <div class="bp2">
            <a href="images/rubbercleaner-04z.webp" data-lightbox="imgst-set2" style="text-decoration:none;">
              <img src="images/rubbercleaner-04.webp" width="239" height="268">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/rubbercleaner-03z.webp" data-lightbox="imgst-set02" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します</a>
          <a href="images/rubbercleaner-04z.webp" data-lightbox="imgst-set02"></a>
        </div>
        <div class="b-text">裏面はメガネ拭きにも使用されるマイクロファイバー極細繊維クロスを使用した本格派。10色から選べます。</div>
      </div>
      <div class="block-g">
        <div class="block-title" style="background: rgb(248,203,173);;">SMART PHONE SCREEN CLEANER RUBBER SURFACE TYPE -
          INSIDE</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/A-big.webp" data-lightbox="imgst-set3" style="text-decoration:none;">
              <img src="images/A-small.webp" width="455" height="270">
            </a>
          </div>
          <div class="bp2">
            <a href="images/B-big.webp" data-lightbox="imgst-set3" style="text-decoration:none;">
              <img src="images/B-small.webp" width="240" height="270">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/A-big.jpg" data-lightbox="imgst-set03" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します</a>
          <a href="images/B-big.jpg" data-lightbox="imgst-set03"></a>
        </div>
        <div class="b-text">スマホクリーナーの内部を紹介。表面のラバー（ゴム）素材、裏面はマイクロファイバー極細繊維。中間にはぷくぷく感を演出する〇〇。</div>
      </div>
      <hr>
      <h2>オリジナルの携帯クリーナー製作工程をご紹介</h2>
      <div class="videoWrapper">
        <img src="/products/img/rubber-production-yt.webp" data-src="5KK0a4b1C9Q" class="iframe" width="771" height="434">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <hr />
      <!-- <div>
        <h2>製品仕様・付属品等</h2>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td>名称</td>
              <td>スマホクリーナー（ラバストタイプ）</td>
            </tr>
            <tr>
              <td>材料</td>
              <td>ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)。熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細は<a href="/products/foodproducts.php?data=rubbercleaner" target="_blank">こちら</a>。</td>
            </tr>
            <tr>
              <td>大きさ</td>
              <td>縦70mmX横70mm以内。（このサイズを超える製品は、別途費用がかかります）</td>
            </tr>
            <tr>
              <td>厚さ</td>
              <td>通常約5mm。肉厚指定のある場合、事前にご相談下さい。</td>
            </tr>
            <tr>
              <td>表面のラバー部分の色数</td>
              <td>スタンダードの場合12色まで、プレミアムの場合18色までご使用頂けます。<br>
                印刷物ではないため、グラデーションは表現できません。</td>
            </tr>
            <tr>
              <td>色指定</td>
              <td>以下2通りのいづれか。①PANTONE(パントーン)もしくは、DIC(ディック)番号によるご指定。②弊社もしくは、お客様が印刷された、色見本（カラーペーパー）によるご指定。</td>
            </tr>
            <tr>
              <td>裏面素材</td>
              <td>マイクロファイバー極細繊維。10色から選択可能。</td>
            </tr>
            <tr>
              <td>最小製作個数<br>
                （最小ロット）</td>
              <td>100個より製作します。</td>
            </tr>
            <tr>
              <td>台紙</td>
              <td>オプションとして台紙の封入が可能です。
                <a href="/products/daishi.html">台紙封入の詳細。</a> 支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。
              </td>
            </tr>
          </tbody>
        </table>
      </div> -->
      <div style="clear: both;">&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="download/download.php?fname=template_rubber_mobile_cleaner.zip">
              <span>テンプレート</span>
            </a>
            <a class="btn-a btn-yellow" href="/products/data" target="_blank">
              <span>入稿データ作成</span>
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/howtoorder/" target="_blank">
              <span>ご注文の流れ</span>
            </a>
            <a class="btn-a btn-yellow" href="/contact/?item=ラバーイヤホンホルダー">
              <span>無料サンプル</span>
            </a>
          </div>
        </div>
      </div>
      <div class="row how">
        <a class="mt-10 btn-a btn-yellow" href="/products/kako.html" target="_blank">
          <div class="howto"><img src="/products/images/icon-kako-rb.webp" width="34" height="34"></div>
          <div>立体加工詳細</div>
        </a>
        <a class="mt-10 btn-a btn-yellow" href="/products/quality.html" target="_blank">
          <div class="howto"><img src="/products/images/icon-qlt-rb.webp" width="34" height="34"></div>
          <div>品質基準詳細</div>
        </a>
        <a href="javascript:void(0)" class="mt-10 btn-a btn-yellow" for="modal-1" style="cursor: pointer;" onclick="$('#modal-1').prop('checked',true)">
          <div class="howto"><img src="/products/images/icon-des-rb.webp" width="34" height="34"></div>
          <div>お客様へのお約束</div>
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
          <div class="btn-container item_btn">
            <a class="btn-a ord-btn" href="#est-content">
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
      <?php $page = 'product';
      include('../../campaign_2021.php'); ?>
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

      <h2>アタッチメント</h2>
      <p>
        写真をクリックすると拡大写真と詳細説明を確認頂けます。
      </p>
      <br>
      <div class="">
        <div class="swiper-container">
          <div class="row">
            <div class="mt-10-part">
              <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro" src="/products/images/HM_part1.webp" width="160" height="160">
              </a><br />
              <div>+0円</div>
              <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro" src="/products/images/HM_part2.webp" width="160" height="160">
              </a><br />
              <div>+0円</div>
              <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2-1" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。">
                <img class="picpro" src="/products/images/HM_part14.webp" width="160" height="160">
              </a><br />
              <div>+0円</div>
              <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14-1" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro" src="/products/images/HM_part3.webp" width="160" height="160">
              </a><br />
              <div>+11円</div>
              <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3-1" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。">
                <img class="picpro" src="/products/images/HM_part9.webp" width="160" height="160">
              </a><br />
              <div>+11円</div>
              <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9-1" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。">
                <img class="picpro" src="/products/images/HM_part10.webp" width="160" height="160">
              </a><br />
              <div>+11円</div>
              <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10-1" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。">
                <img class="picpro" src="/products/images/HM_part11.webp" width="160" height="160">
              </a><br />
              <div>+11円</div>
              <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11-1" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。">
                <img class="picpro" src="/products/images/HM_part12.webp" width="160" height="160">
              </a><br />
              <div>+11円</div>
              <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12-1" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。">
                <img class="picpro" src="/products/images/HM_part13.webp" width="160" height="160">
              </a><br />
              <div>+11円</div>
              <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13-1" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-1" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm">
                <img class="picpro" src="/products/images/HM_part15.webp" width="160" height="160">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-1-1" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-2" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm">
                <img class="picpro" src="/products/images/HM_part18.webp" width="160" height="160">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-2-1" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-3" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm">
                <img class="picpro" src="/products/images/HM_part16.webp" width="160" height="160">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-3-1" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-4" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm">
                <img class="picpro" src="/products/images/HM_part19.webp" width="160" height="160">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-4-1" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-5" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm">
                <img class="picpro" src="/products/images/HM_part17.webp" width="160" height="160">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-5-1" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-6" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm">
                <img class="picpro" src="/products/images/HM_part20.webp" width="160" height="160">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-6-1" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part21.webp" data-lightbox="img-part-set-7" data-title="<strong>【リング黒色。黒色リングです】</strong>ビス留め仕様になりますので、チェーン以外でお探しの場合はこちらをお勧めしております。 リング 外径：30mm　内径：26mm">
                <img class="picpro" src="/products/images/HM_part21.webp" width="160" height="160">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part21.webp" data-lightbox="img-part-set-7-1" data-title="<strong>【リング黒色。黒色リングです】</strong>ビス留め仕様になりますので、チェーン以外でお探しの場合はこちらをお勧めしております。 リング 外径：30mm　内径：26mm" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-9" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。">
                <img class="picpro" src="/products/images/HM_part5.webp" width="160" height="160">
              </a><br />
              <div>+11円</div>
              <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-9-1" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-8" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。">
                <img class="picpro" src="/products/images/HM_part4.webp" width="160" height="160">
              </a><br />
              <div>+22円</div>
              <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-8-1" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-10" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。">
                <img class="picpro" src="/products/images/HM_part6.webp" width="160" height="160">
              </a><br />
              <div>+22円</div>
              <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-10-1" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-11" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。">
                <img class="picpro" src="/products/images/HM_part7.webp" width="160" height="160">
              </a><br />
              <div>+22円</div>
              <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-11-1" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-12" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。">
                <img class="picpro" src="/products/images/HM_part8.webp" width="160" height="160">
              </a><br />
              <div>+22円</div>
              <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-12-1" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。" style="font-size: 10px;">📷クリックすると拡大します</a>
            </div>
          </div>
        </div>
      </div>
      <hr />
      <h2>製作料金一覧</h2>
      スタンダード
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>2,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>616 円</td>
            <td>451 円</td>
            <td>385 円</td>
            <td>319 円</td>
            <td>264 円</td>
            <td>220 円</td>
            <td>191 円</td>
            <td>171 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(61,600 円)</td>
            <td>(90,200 円)</td>
            <td>(115,500 円)</td>
            <td>(159,500 円)</td>
            <td>(264,000 円)</td>
            <td>(440,000 円)</td>
            <td>(573,000 円)</td>
            <td>(855,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('トレース代金は含まれておりません。') ?><br />
      </div>
      <div>&nbsp;</div>
      プレミアム
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>2,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>902 円</td>
            <td>649 円</td>
            <td>555 円</td>
            <td>467 円</td>
            <td>391 円</td>
            <td>299 円</td>
            <td>248 円</td>
            <td>209 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(90,200 円)</td>
            <td>(129,800 円)</td>
            <td>(166,500 円)</td>
            <td>(233,500 円)</td>
            <td>(391,000 円)</td>
            <td>(598,000 円)</td>
            <td>(744,000 円)</td>
            <td>(1,045,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('プレミアムでは、試作品、トレース代金、アタッチメントは無料です。') ?><br />
      </div>
      <hr>
      <h2><?= lang('スタンダードとプレミアムの違い') ?></h2>
      <center>
        <a class="img-hover" href="/products/product-difference.php?data=2" target="_blank">
          <img src="/img/top2-banner.webp" width="100%" height="350" style="max-width: 745px;">
        </a>
      </center>
      <h2><?= lang('製作納期') ?></h2>
      <p class="d_TEXT1"><?= lang('納期') ?>：<br /><span class="red"><?= lang('下記日数は全て営業日。') ?></span><br /><?= lang('納期=製作日数+配送日数で定義されるものとします。<br />営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。中国春節、国慶節期間につきましては、別途定める休日が指定されます。<br />シルク印刷ありでのご注文の場合、+1営業日<br />色味指定を印刷紙で行う場合、+3営業日<br />※お客様から印刷紙手配が遅れる場合、この限りではございません。') ?>
      </p>
      ◆<?= lang('スタンダード製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="70%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr align="center">
          <td>&nbsp;</td>
          <td align="center">300<?= lang('個以下') ?></td>
          <td align="center">1,000<?= lang('個以下') ?></td>
          <td align="center">3,000<?= lang('個程度まで') ?></td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">7</td>
          <td align="center">7</td>
          <td align="center">7</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数(試作あり)') ?></td>
          <td align="center">9</td>
          <td align="center">14</td>
          <td align="center">22～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">10</td>
          <td align="center">14</td>
          <td align="center">22～</td>
        </tr>
      </table>
      <br />
      ◆<?= lang('プレミアム製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="70%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr>
          <td>&nbsp;</td>
          <td align="center">300<?= lang('個以下') ?></td>
          <td align="center">1,000<?= lang('個以下') ?></td>
          <td align="center">3,000<?= lang('個程度まで') ?></td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">7</td>
          <td align="center">7</td>
          <td align="center">7</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数(試作あり)') ?></td>
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">19</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
      </table>
      <p class="d_TEXT1">◆<?= lang('配送日数') ?>：<?= lang('1-2営業日') ?></p>
      <p class="d_TEXT1">
        ◇<?= lang('例') ?>）<br />
        <?= lang('スタンダード') ?><br />
        300<?= lang('個') ?><br />
        <?= lang('試作品なしの場合') ?>
      </p>
      <p class="d_TEXT1">
        ・<?= lang('製作期間') ?>：10<?= lang('営業日') ?><br />
        ・<?= lang('配送期間') ?>：1-2<?= lang('営業日') ?><br />
        <?= lang('合計') ?>：11-12<?= lang('営業日となります。') ?>
      </p>
      <div style="margin-top: 10px;">
        <a href="/campaign/quality_rubberstrap.php"><img class="lazy" data-src="/products/images/banner-quality-2025.webp" width="100%" height="" style="max-width:770px;"></a>
      </div>
      <div style="clear:both;">&nbsp;</div>
      <h2>厚労省の定める規格基準に合格した安全性の高い材料を使用</h2>
      <center>
        <a class="img-hover" href="/products/foodproducts.php?data=rubbercleaner" target="_blank">
          <img src="/img/safety-banner.webp" width="100%" height="70" style="max-width:745px;">
        </a>
      </center>
      <div style="clear:both;">&nbsp;</div>


      <h2 id="est-content">ご注文・見積書作成</h2>

      <?php include('../campaign_banner.php') ?>

      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【スマホラバークリーナー】</h3>
          <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td>ご注文タイプ</td>
                <td><span id="sample-prd-pcs">-</span></td>
              </tr>
              <tr>
                <td>サイズ</td>
                <td><span>70X70mm以内。</span></td>
              </tr>
              <tr>
                <td>裏面生地の色</td>
                <td><span id="sample-prd-cloth">-</span></td>
              </tr>
              <tr style="display: none;">
                <td>印刷面</td>
                <td><span id="sample-prd-screen">-</span></td>
              </tr>
              <tr>
                <td><?= lang('汚れ防止加工') ?></td>
                <td><span id="sample-prd-coating">-</span></td>
              </tr>
              <tr>
                <td>数量</td>
                <td><span id="sample-prd-qty">-</span></td>
              </tr>
              <tr>
                <td>試作品</td>
                <td><span id="sample-prd-samp">-</span></td>
              </tr>
              <tr>
                <td>データトレース</td>
                <td><span id="sample-prd-trace">-</span></td>
              </tr>
            </table>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="/products/images/HM_part1-2.webp" width="135" height="135" id="sample-part-pic" class="picpro"><br />
            <span id="sample-part-name">通常松葉（カニカン）</span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="/products/acrylic/img/coming-soon.webp" width="500" height="500" id="sample-paper-pic" class="picpro"><br />
            台紙:<span id="sample-paper-name">なし</span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details">ご注文タイプ・裏面生地の色</span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div><span class="step-details">アタッチメント・台紙等</span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details">製品仕様・製作料金</span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="スマホラバークリーナー" />
          </div>
          <?php
          switch ($ItemPCS) {
            case "スタンダード":
              $lsSelected_1pcs = 'checked';
              break;
            case "プレミアム":
              $lsSelected_2pcs = 'checked';
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

          switch ($back_side_color) {
            case "裏面生地白色":
              $white_checked = 'checked';
              break;
            case "裏面生地黒色":
              $black_checked = 'checked';
              break;
            default:
              $white_checked = 'checked';
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
            
            <h3>ご注文タイプ</h3>
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();check_val('next')" <?= $lsSelected_1pcs ?>>スタンダード
                  <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();check_val('next')" <?= $lsSelected_2pcs ?>>プレミアム
                  <span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_pcs"></span>
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
            <h3>裏面生地の色</h3>
            <div style="display: table-column;height: 0px;">
              <input type="radio" name="silk_print" id="nashiprint" value="シルク印刷なし" checked="" />
            </div>
            <div class="flex-container se-color">
              <div class="preview-container">
                <div class="preview-sub flex-container">
                  <?php
                  include('color.php');
                  $j = 0;
                  for ($j = 0; $j < count($color_back); $j++) {
                    echo '
                  <div class="flex-item">
                  <label class="part-name">
                  <input type="radio" name="back_side_color" value="' . $color_back[$j]["color_name"] . '" ' . ($back_side_color == $color_back[$j]["color_name"] ? 'checked' : ($j == 0 ? 'checked' : '')) . ' onclick="check_val(\'next\')">
                  <img src="' . $color_back[$j]["color_pic"] . '" width="100" height="100" class="picpro">
                  </label>
                  </div>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <div>&nbsp;</div>
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
            <h3>ご注文本数</h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty">ご注文・御見積数量&nbsp;&nbsp;<input type="number" name="numberOf" id="no_of_order" class="right" onchange="this.value=format_number(this.value);" onblur="check_val('next')" value="<?php echo $numberOf ?>" style="padding-right: 1px;text-align: right;"><br /></label>
                <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?></div>
              </div>
            </div>
            <span style="color: red" id="error_message"></span>
          </div>
          <div class="estimate-content" id="step2">
            <h3>アタッチメント</h3>
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
                  <img src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="picpro">
                  <br><span class="part_price_std">+' . ($attachment[$i]["part_price"] * 1.1) . '円</span><span class="part_price_prm">+0円</span>
                  </label>
                  </div>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <h3>台紙</h3>
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
                  台紙印刷
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
            <h3>試作品・データトレース</h3>
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
                  試作品
                </label>
              </div>
              <font color="red">※プレミアムは実物校正代金が無料</font>
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
                  データトレース
                </label>
              </div>
              <font color="red">※プレミアムは試作品代金が無料</font>
            </div>
          </div>
          <div class="estimate-content flex-item" id="step3">
            <div class="flex-container">
              <div class="flex-item">
                <h3>製品仕様</h3>
                <table class="table_rubber">
                  <tbody>
                    <tr>
                      <td class="TableLeft">ご注文タイプ</td>
                      <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">サイズ</td>
                      <td class="" style="text-align: left;">70X70mm以内。</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">裏面生地の色</td>
                      <td class="" id="prd_cloth" style="text-align: left;"></td>
                    </tr>
                    <tr style="display: none;">
                      <td class="TableLeft">裏面シルク印刷</td>
                      <td class="" id="prd_silk_print" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class="" id="prd_coating" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">ご注文本数</td>
                      <td class="" id="prd_qty" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">アタッチメント</td>
                      <td class="" id="prd_part" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">台紙</td>
                      <td class="" id="prd_paper" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class="" id="prd_SendPrototype" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データトレース</td>
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
                <h3>製作料金</h3>
                <table class="table_rubber total_price_tbl">
                  <tbody>
                    <tr>
                      <td class="TableLeft">商品代金</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="StrapPrice" readonly="readonly" id="textfield7" class="right" value="<?= $StrapPrice ?>">円</td>
                    </tr>
                    <tr style="display: none;">
                      <td class="TableLeft">シルク印刷代金</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="SilkPrint" readonly="readonly" id="textfield13" class="right" value="<?php echo $SilkPrint ?>" />円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="coatingPrice" readonly="readonly" id="textfield13_2" class="right" value="<?= $coatingPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">アタッチメント</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">台紙</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PaperPrice" readonly="readonly" id="textfield7_2" class="right" value="<?= $PaperPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="ProShipping" readonly="readonly" id="textfield3" class="right" value="<?= $ProShipping ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データトレース</td>
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
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step1');$('#cus_detail').hide();">製作条件修正</a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step2');$('#cus_detail').hide();">ｱﾀｯﾁﾒﾝﾄ修正</a>
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
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn('back')">戻る</a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')">アタッチメント・オプション入力へ</a>
          </div>
        </form>
        <div id="cus_detail" style="display: none;" align="center">
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');$('.loading').show(); " value="御社情報確定（PDF出力）" />
                  <div class="remark">&nbsp;※社名や会社名の入力は任意です</div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <?php $fd_type = "rubbercleaner";
      $favor = 'cleaner';
      include '../rubber_product_detail_test.php'; ?>
      <h2>営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。</h2><br />
      <p class="d_TEXT1">当社では担当の営業マンが直接製品やサービスのご提案・ご説明をさせて頂けます。WEBサイトだけではなかなかイメージが掴めない。価格も含めて相談したい。このような
        ご要望がございましたら是非お声掛け下さい。営業担当が実際にサンプル品をもって御社にお伺いし詳しく説明させて頂きます。
        ご希望のお客様はお手数ですが、バナーをクリックして頂き必要事項をご入力ください。お伺いできるエリアは東京都内もしくは近郊に限ります。事情によりお伺いできない場合もございますので、ご了承ください。</p>
      <br />
      <div align="center">
        <a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a>
      </div><br />
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include("../../footer.html"); ?>
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
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <!-- google script -->
  <!-- リマーケティング タグの Google コード -->
  <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->

  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/js/_setToInput_2023-test.js?d=<?php echo date('is') ?>"></script>
  <script language="JavaScript" src="/js/validation_new.js?v=1.13" type="text/javascript"></script>
  <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>
  <!--<script type="text/javascript" src="/products/js/auto-slider.js"></script>-->
  <script src="/js/swiper.min.js"></script>
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
        "product": "ラバー携帯クリーナー"
      },
      success: function(data) {
        productionDate(data.sort());
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
    }, getPartData($('input[name="part"]:checked').val()), (tmp != "" ? valid_chk_btn('step3') : ""));

    if (window.innerWidth < 768) {
      var swiper = new Swiper('.swiper-container', {
        slidesPerView: 2,
        spaceBetween: 15,
        slidesPerGroup: 1,
        loop: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });
      var x = document.getElementsByClassName('swiper-wrapper');
    }


    $("input[name='paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    })
  </script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
  </script>
  <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
    </div>
  </noscript>
  <!-- /.google script -->

</body>

</html>