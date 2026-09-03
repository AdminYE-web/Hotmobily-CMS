<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
error_reporting(E_ALL ^ E_NOTICE);
//Read Modules
require_once('../control/Control_Rubber.php');
include_once('../common/Const.php');
include_once('../common/SetUpLang.php');
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
  <meta name="keywords" content="<?= lang('メガネクロス,オリジナル,メガネクリーナー, ノベルティ') ?>">
  <meta name="description" content="<?= lang('マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。') ?>">
  <meta name="robots" content="index,follow">
  <title><?= lang('オリジナルメガネクロス、クリーナー製作｜HOTMOBILYオリジナルグッズ') ?></title>
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

    .tag-menu {
      font-weight: bold;
    }
   .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
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
    }

    .d-flex {
      display: flex;
    }

    .ms-2 {
      margin-left: 5%;
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

    @media screen and (max-width: 768px) {
      .modifing_table .d_TEXT1 {
        width: 100%;
      }

      /* Hide the second column on mobile */
      .modifing_table .process td:nth-child(2) {
        display: none;
      }
    }

    .modifing_table a {
      position: relative;
    }

    div.plus {
      position: absolute;
      right: 5px;
      bottom: 5px;
      color: #555;
      font-size: 16px;
      border-radius: 100%;
      width: 15px;
      height: 15px;
      background: linear-gradient(to bottom, #f3f5f6 0, #dedfe0 100%);
      padding: 9px;
      bottom: -120px;
      right: 20px;
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
      <h1><?= lang('オリジナルメガネクロス(2025年版)') ?></h1>
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
      <div style="clear:both;"></div>
      <p class="d_TEXT1 new-text">
        <?= lang('メガネレンズクリーナーに最適な、超極細化学繊維マイクロファイバークロスを使用し、柔らかくシルクを思わせる高級感があります。 形状は、正方形、長方形。また裁断だけでなく、縁の縫製タイプもございます。美しいフルカラーの昇華転写印刷。 ロゴ/名入れなどのシルクスクリーン印刷。立体感で高級感のあるエンボス加工（浮き出し）、等ご要望に添った加工でオリジナルなメガネ クリーナーを作成致します。小ロットから製作できますので、ノベルティやオリジナルグッズ製作としてもご利用頂けます。') ?><br />
      </p>
      <div style="margin: auto;">
        <table border="0" cellpadding="0" cellspacing="0" class="modifing_table">
          <tbody>
            <tr class="process" valign="top">
              <td valign="top" class="d_TEXT1" align="center">
                <a href="img/cloth_new_01.webp?v=1.01" data-lightbox="cloth1-set" data-title="オリジナルメガネクロス" style="text-decoration:none;">
                  <img src="img/cloth_new_01.webp?v=1.01" width="380" height="285" />
                  <div class="plus"><i class="fas fa-search-plus"></i></div>
                </a>
              </td>
              <td>
                <a href="img/cloth_new_02.webp?v=1.01" data-lightbox="cloth1-set" data-title="オリジナルメガネクロス" style="text-decoration:none;">
                  <img src="img/cloth_new_02.webp?v=1.01" width="380" height="285" />
                  <div class="plus"><i class="fas fa-search-plus"></i></div>
                </a>
              </td>
            </tr>
            <tr class="process" valign="top">
              <td valign="top" class="d_TEXT1" align="center">
                <a href="img/cloth_new_03.webp?v=1.01" data-lightbox="cloth1-set" data-title="オリジナルメガネクロス" style="text-decoration:none;">
                  <img src="img/cloth_new_03.webp?v=1.01" width="380" height="285" />
                  <div class="plus"><i class="fas fa-search-plus"></i></div>
                </a>
              </td>
              <td>
                <a href="img/cloth_new_04.webp?v=1.01" data-lightbox="cloth1-set" data-title="オリジナルメガネクロス" style="text-decoration:none;">
                  <img src="img/cloth_new_04.webp?v=1.01" width="380" height="285" />
                  <div class="plus"><i class="fas fa-search-plus"></i></div>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <h2><?= lang('オリジナルメガネクロスの製作事例') ?></h2><br />
      <div class="ex-row">
        <div class="gall_pro">
          <div class="gallbox">
            <a href="slideimg/micr01.jpg" data-lightbox="img-set-05" style="text-decoration:none;" class="">
              <img src="slideimg/micr01_s.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/micr03.jpg" data-lightbox="img-set-11" style="text-decoration:none;" class="">
              <img src="slideimg/micr03_s.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/micr04.jpg" data-lightbox="img-set-18" style="text-decoration:none;" class="">
              <img src="slideimg/micr04_s.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/micr06.jpg" data-lightbox="img-set-21" style="text-decoration:none;" class="">
              <img src="slideimg/micr06_s.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/micr09.jpg" data-lightbox="img-set-22" style="text-decoration:none;" class="">
              <img src="slideimg/micr09_s.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/cloth_norm_btm2.jpg" data-lightbox="img-set-23" style="text-decoration:none;" class="">
              <img src="slideimg/cloth_norm_btm2_s.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/cloth_norm_btm3.jpg" data-lightbox="img-set-26" style="text-decoration:none;" class="">
              <img src="slideimg/cloth_norm_btm3_s.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/mic1_650x450.jpg" data-lightbox="img-set-27" style="text-decoration:none;" class="">
              <img src="slideimg/mic1_200x150.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/mic2_650x450.jpg" data-lightbox="img-set-28" style="text-decoration:none;" class="">
              <img src="slideimg/mic2_200x150.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/mic3_650x450.jpg" data-lightbox="img-set-29" style="text-decoration:none;" class="">
              <img src="slideimg/mic3_200x150.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/mic4_650x450.jpg" data-lightbox="img-set-30" style="text-decoration:none;" class="">
              <img src="slideimg/mic4_200x150.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/mic5_650x450.jpg" data-lightbox="img-set-31" style="text-decoration:none;" class="">
              <img src="slideimg/mic5_200x150.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
          <div class="gallbox">
            <a href="slideimg/mic6_650x450.jpg" data-lightbox="img-set-32" style="text-decoration:none;" class="">
              <img src="slideimg/mic6_200x150.webp" class="picpro" width="200" height="150"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
          </div>
        </div>
      </div>
      <hr>
      <h2><?= lang('オリジナルメガネクロス by HOTMOBILYオリジナルグッズの特徴') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('① 髪の毛の1/100の細さで、柔らかく拭き取り効果はバツグンです。<br />② 特に指紋や皮脂の汚れも難なく落とし、毛羽立ちにくい為繊維が残る事がありません。<br />③ メガネだけでなく、スマートフォン、タブレットPC、デジタルカメラ、手鏡などのクリーナーとしてもご利用頂けます。<br />④ 勿論、洗濯が可能です。') ?><br />
      </p>
      <hr>
      <h2><?= lang('ご入稿データからの完成イメージ') ?></h2>
      <div style="margin: auto;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr class="process" valign="top">
              <td valign="top" class="d_TEXT1" align="center">
                <a href="img/cloth_norm_btm2.webp" data-lightbox="cloth2-set" data-title="ご入稿データからの完成イメージ" style="text-decoration:none;">
                  <img src="img/cloth_norm_btm2.webp" width="380" height="285" />
                </a>
              </td>
              <td>
                <a href="img/cloth_norm_btm3.webp" data-lightbox="cloth2-set" data-title="ご入稿データからの完成イメージ" style="text-decoration:none;">
                  <img src="img/cloth_norm_btm3.webp" width="380" height="285" />
                </a>
              </td>
            </tr>
            <tr>
              <td style="font-size:10px;">
                <a href="img/cloth_norm_btm2.webp" data-lightbox="cloth2-set_text" data-title="ご入稿データからの完成イメージ" style="text-decoration:none;">📷<?= lang('クリックすると拡大します') ?></a>
                <a href="img/cloth_norm_btm3.webp" data-lightbox="cloth2-set_text" data-title="ご入稿データからの完成イメージ" style="text-decoration:none;"></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <hr>
      <h2><?= lang('メガネクロスの仕様') ?></h2>
      <table width="99%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse: collapse;">
        <tr>
          <td>名称</td>
          <td>メガネクロス</td>
        </tr>
        <tr>
          <td>材料</td>
          <td>
            マイクロファイバークロス（ポリエステル70％+ナイロン30％）※RoHS対応の素材を使用しております<br />
            プレミアムクロス：240g/sqmの重量<br />
            スタンダード：220g/sqmの重量<br />
            ※上記以外にもクロス生地はございます。ご注文枚数が1,000枚以上の場合、ご予算に応じて最適な生地をご提案させて頂きます。
          </td>
        </tr>
        <tr>
          <td>サイズ</td>
          <td>150mm×150mm、150mm×180mm の２サイズ。 その他ご指定のサイズがあればお問合せ下さい。<br />※上記、正方形、長方形以外の形状もお請け致します。</td>
        </tr>
        <tr>
          <td>印刷/加工</td>
          <td>
            ・ 昇華転写印刷（片面、両面）<br />
            ・ シルクスクリーン印刷（型代別料金）<br />
            ・ エンボス加工（型代別料金）
          </td>
        </tr>
        <tr>
          <td>生地色</td>
          <td>
            昇華転写印刷は、白色の生地となります。<br />
            シルクスクリーン印刷／エンボス加工の場合、生地色をお選びいただけます。<br />
            スタンダード、プレミアムそれぞれ10色ずつご用意していますので、お好みの色をお選びください。<br />
            <div style="clear:both;">&nbsp;</div>
            <div class="d-flex">
              <div class="flex-item" onclick="$('#standard_color').slideToggle();$('#premium_color').slideUp();">
                <img src="img/button_preview_standard_color.webp" style="width:100%">
              </div>
              <div class="flex-item" onclick="$('#premium_color').slideToggle();$('#standard_color').slideUp();">
                <img src="img/button_preview_premium_color.webp" style="width:95%" class="ms-2">
              </div>
            </div>

            <div id="standard_color" style="display:none;">
              <div style="clear:both;">&nbsp;</div>
              <p class="red">スタンダード</p><img src="img/standard_cloth_color_n.webp?v=1.03" style="width:100%">
            </div>
            <div id="premium_color" style="display:none;">
              <div style="clear:both;">&nbsp;</div>
              <p class="red">プレミアム</p><img src="img/premium_cloth_colr.webp" style="width:100%">
            </div>
          </td>
        </tr>
        <tr>
          <td>最小ロット</td>
          <td>100枚</td>
        </tr>
        <tr>
          <td>包装方式</td>
          <td>一括包装（個別OPP包装は+@11円(税込)です）</td>
        </tr>
        <tr>
          <td>台紙</td>
          <td>既製品：50種類のデータから選択可 <br> オリジナル印刷：お客様の入稿データを使用し、印刷します <br> 支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。</td>
        </tr>
      </table>
      <h2>テンプレート</h2>
      <div class="flex-container justify-between">
        <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
          <span>150mm×150mm</span>
        </a>
        <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
          <span>180mm×150mm</span>
        </a>
      </div>

      <div class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_150X150mm.pdf">
                    <div><img class="lazy" data-src="/products/acrylic/img/pdf-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_150X150mm.ai">
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
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_180X150mm.pdf">
                    <div><img class="lazy" data-src="/products/acrylic/img/pdf-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=Template_microfiber_180X150mm.ai">
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
      <h2><?= lang('メガネクロス製作料金（税込）') ?></h2>
      <div class="exceed-table">
        <p class="new-text"><?= lang('・ 昇華転写印刷 片面印刷（裏面は白になります）') ?></p><br />
        <div class="tbl_s">
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
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('スタンダード') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">231</td>
              <td class="" align="center">176</td>
              <td class="" align="center">143</td>
              <td class="" align="center">110</td>
              <td class="red" align="center">88</td>
              <td class="red" align="center">77</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">242</td>
              <td class="" align="center">187</td>
              <td class="" align="center">154</td>
              <td class="" align="center">121</td>
              <td class="red" align="center">99</td>
              <td class="red" align="center">88</td>
            </tr>
            <tr>
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('プレミアム') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">242</td>
              <td class="" align="center">187</td>
              <td class="" align="center">154</td>
              <td class="" align="center">121</td>
              <td class="red" align="center">99</td>
              <td class="red" align="center">88</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">253</td>
              <td class="" align="center">198</td>
              <td class="" align="center">165</td>
              <td class="" align="center">132</td>
              <td class="red" align="center">110</td>
              <td class="red" align="center">99</td>
            </tr>
          </table>
        </div>
        <p class="new-text"><?= lang('※上記価格は税込み価格です。') ?></p><br /><br />
        <p class="new-text"><?= lang('・ 両面印刷') ?></p>
        <div class="tbl_s">
          <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
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
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('スタンダード') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">253</td>
              <td class="" align="center">198</td>
              <td class="" align="center">165</td>
              <td class="" align="center">132</td>
              <td class="red" align="center">110</td>
              <td class="red" align="center">99</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">264</td>
              <td class="" align="center">209</td>
              <td class="" align="center">176</td>
              <td class="" align="center">143</td>
              <td class="red" align="center">121</td>
              <td class="red" align="center">110</td>
            </tr>
            <tr>
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('プレミアム') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">264</td>
              <td class="" align="center">209</td>
              <td class="" align="center">176</td>
              <td class="" align="center">143</td>
              <td class="red" align="center">121</td>
              <td class="red" align="center">110</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">275</td>
              <td class="" align="center">220</td>
              <td class="" align="center">187</td>
              <td class="" align="center">154</td>
              <td class="red" align="center">132</td>
              <td class="red" align="center">121</td>
            </tr>
          </table>
        </div>
        <p class="new-text"><?= lang('※上記価格は税込み価格です。') ?></p><br /><br />
        <p class="new-text"><?= lang('・ シルクスクリーン印刷1色印刷') ?></p>
        <div class="tbl_s">
          <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
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
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('スタンダード') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">-</td>
              <td class="" align="center">110</td>
              <td class="" align="center">99</td>
              <td class="" align="center">77</td>
              <td class="red" align="center">55</td>
              <td class="red" align="center">44</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">-</td>
              <td class="" align="center">121</td>
              <td class="" align="center">110</td>
              <td class="" align="center">99</td>
              <td class="red" align="center">66</td>
              <td class="red" align="center">55</td>
            </tr>
            <tr>
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('プレミアム') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">-</td>
              <td class="" align="center">121</td>
              <td class="" align="center">110</td>
              <td class="" align="center">99</td>
              <td class="red" align="center">66</td>
              <td class="red" align="center">55</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">-</td>
              <td class="" align="center">132</td>
              <td class="" align="center">121</td>
              <td class="" align="center">110</td>
              <td class="red" align="center">77</td>
              <td class="red" align="center">66</td>
            </tr>
          </table>
        </div>
        <p class="new-text"><?= lang('※上記単価に加え、版型代金3,960円/デザイン・色がかかります。<br />※シルク印刷のロゴサイズが30mmX60mm以上の場合は単価が11円UPします。<br />※シルクスクリーン印刷は300枚からの製作手配となります。') ?></p><br /><br />

        <p class="new-text"><?= lang('・ エンボス加工（30mmX50mm程度）') ?></p>
        <div class="tbl_s">
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
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('スタンダード') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">176</td>
              <td class="" align="center">121</td>
              <td class="" align="center">110</td>
              <td class="" align="center">88</td>
              <td class="red" align="center">66</td>
              <td class="red" align="center">55</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">187</td>
              <td class="" align="center">132</td>
              <td class="" align="center">121</td>
              <td class="" align="center">99</td>
              <td class="red" align="center">77</td>
              <td class="red" align="center">66</td>
            </tr>
            <tr>
              <td rowspan="2" class="red" align="center" bgcolor="#EFEFEF"><?= lang('プレミアム') ?></td>
              <td class="" align="center" bgcolor="#EFEFEF">150x150mm</td>
              <td class="" align="center">187</td>
              <td class="" align="center">132</td>
              <td class="" align="center">121</td>
              <td class="" align="center">99</td>
              <td class="red" align="center">77</td>
              <td class="red" align="center">66</td>
            </tr>
            <tr>
              <td class="" align="center" bgcolor="#EFEFEF">150x180mm</td>
              <td class="" align="center">198</td>
              <td class="" align="center">143</td>
              <td class="" align="center">132</td>
              <td class="" align="center">110</td>
              <td class="red" align="center">88</td>
              <td class="red" align="center">77</td>
            </tr>
          </table>
        </div>
        <p class="new-text">※<?= lang('上記単価に加え、版型代金8,800円/デザインがかかります。') ?></p><br /><br />
        <p class="new-text"><?= lang('・ 製品の個別OPP包装 11円/枚<br />・ 長方形以外の形状、淵縫製等このページに記載の無い加工方法につきましては<a href="../contact/index.php">お問い合わせ</a>下さい。') ?></p>
      </div>
      <!-- Estimate 03/21/2018 -->
      <hr>

      <div style="clear:both;">&nbsp;</div>

      <div id="container-color" style="display:none">
        <div style="clear:both;">&nbsp;</div>
        <p>シルクスクリーン印刷／エンボス加工の場合、生地色をお選びいただけます。スタンダード、プレミアムそれぞれ10色ずつご用意していますので、お好みの色をお選びください。</p>
        <div style="clear:both;">&nbsp;</div>
        <p class="red">スタンダード</p>
        <img src="img/standard_cloth_color.webp">
        <div style="clear:both;">&nbsp;</div>
        <p class="red">プレミアム</p>
        <img src="img/premium_cloth_colr.webp">
      </div>

      <div id="pro1" style="margin-top: 10px;">
        <img src="img/saitan9day.webp" alt="" width="185" height="123">
        <img src="img/cloth_btop2.webp" alt="" width="185" height="123">
      </div>
      <div id="pro2" style="margin-top: 10px;">
        <img src="img/cloth_btop3_new.webp" alt="" width="185" height="123">
        <img src="img/cloth_btop4.webp" alt="" width="185" height="123">
      </div>
      <div style="clear:both;"></div>
      <div id="info_div" style="margin-top: 10px;"></div>
      <h2 id="est-content"><?= lang('ご注文・見積書作成') ?></h2>

      <?php include('campaign_banner.php') ?>

      <span style="font-size: 12px;" class="new-text">※<?= lang('一つのデザインにつき一注文となります。複数のデザインがある場合、それぞれのデザインで別々にご注文ください。') ?></span>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('オリジナルメガネクロス') ?>】</h3>
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
            <input type="text" name="ItemType" id="strap" value="オリジナルメガネクロス" />
          </div>
          <?php
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
          switch ($cth_option) {
            case 'スタンダード':
              $cth_option0 = "checked";
              break;
            case 'プレミアム':
              $cth_option1 = "checked";
              break;
            default:
              $cth_option0 = "checked";
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
          ?>
          <div class="estimate-content" id="step1">
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
                  <input type="radio" name="cth_type" value="エンボス加工" onclick="check_val('next')" <?= $cth_type3 ?>><?= lang('エンボス加工') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>
            <h3><?= lang('生地タイプ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="cth_option" value="スタンダード" onclick="check_val('next')" <?= $cth_option0 ?>><?= lang('スタンダード') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="cth_option" value="プレミアム" onclick="check_val('next')" <?= $cth_option1 ?>><?= lang('プレミアム') ?> <span class="checkmark"></span></label>
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
      <h2><?= lang('納期（製作期間）') ?></h2>
      <div style="clear: both;"></div>
      <p class="d_TEXT1 new-text"><?= lang('納期=製作日数+配送日数で計算致します。') ?></p><br />
      <p class="d_TEXT1 new-text">【<?= lang('製作期間') ?>】</p>
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
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center" colspan="6">8</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数') ?></td>
          <td align="center">9</td>
          <td align="center">11</td>
          <td align="center">13</td>
          <td align="center">16</td>
          <td align="center">20</td>
          <td align="center">23</td>
        </tr>
      </table><br />

      <?php include('part-daishi-lang.php'); ?>
      <hr>
      <h2><?= lang('オリジナルメガネクロスの無料サンプルについて') ?></h2>
      <a href="/contact/?item=マイクロファイバーメガネクロス"><img src="img/banner_cont4.webp" width="100%" height="82"></a>
      <style>
        .d-flex {
          display: flex;
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
      </style>
      <!-- <h2 class="text-info">この商品に関する記事</h2>

      <div class="d-flex">
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
      <div>&nbsp;</div> -->
      <h2><?= lang('営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('ホットモバイリーでは担当の営業マンが直接製品やサービスのご提案・ご説明をさせて頂けます。WEBサイトだけではなかなかイメージが掴めない。価格も含めて相談したい。このようなご要望がございましたら是非お声掛け下さい。営業担当が実際にサンプル品をもって御社にお伺いし詳しく説明させて頂きます。ご希望のお客様はお手数ですが、バナーをクリックして頂き必要事項をご入力ください。お伺いできるエリアは東京都内もしくは近郊に限ります。事情によりお伺いできない場合もございますので、ご了承ください。') ?>
        <center>
          <a href="//hotmobily.jp/meeting_date/"><img src="../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a>
        </center>
      </p>
      <br />
      <img src="images/text_sample.svg" width="100%" height="620" id="i_txt2">
      <hr>
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
  <script language="JavaScript" src="../js/calculater_cth_2021.js?v=1.08" type="text/javascript"></script>
  <script type="text/javascript" src="js/pdf_cth_2021.js?v=1.16"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script src="js/cloth_calendar.js?v=1.11"></script>
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
  </script>
</body>

</html>