<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
error_reporting(E_ALL ^ E_NOTICE);
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
  <meta name="keywords" content="<?= lang('バッジ,刺繍,刺繍バッジ,製作,デザイン,制作,名入れ,オリジナル,缶バッジ') ?>">
  <meta name="description" content="<?= lang('バッジをオリジナル刺繍デザインで製作できます。名入れ可能な完全オーダーメイド。細かいデザインでも安価に制作可能です。最短15営業日出荷の短納期。50枚からご注文いただけます。') ?>">
  <meta name="robots" content="index,follow">
  <title><?= lang('オリジナル刺繍バッジの製作　50枚から') ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
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
  <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
  <link href="css/flight_tag.css?v=1.06" rel="stylesheet" type="text/css" />
  <link href="https://hotstrap.jp/css/products.css?v=1.15" rel="stylesheet" type="text/css" />

  <style type="text/css">
    .part-content.preview-container {
      background: unset;
    }

    .choose_c img {
      width: 98%;
    }

    .d-none {
      display: none;
    }

    .show_c img {
      width: fit-content;
      height: auto;
    }

    #step2 label.part-name.p-normal {
      padding: 10px !important;
      padding-left: 45px !important;
    }

    .no-designs {
      display: none;
    }

    .picpro {
      height: auto;
    }

    #wrapper .pswp img {
      height: auto !important;
    }

    .pswp--animated-in .pswp__zoom-wrap {
      transform: translate3d(0px, 140px, 0px) scale(1) !important;
    }

    #step2 label.part-name.p-normal {
      padding: 10px !important;
      padding-left: 45px !important;
    }

    .table-container {
      overflow-x: auto;
      max-height: 400px;
      /* Set a max height for the container if needed */
    }

    .tbl_price_deli thead {
      position: sticky;
      top: 55px;
      background-color: #ffdada;
    }

    #content_wrapper>h2.feature1,
    #content_wrapper>h2.feature2,
    #content_wrapper>h2.feature3,
    #content_wrapper>h2.feature4 {
      text-align: left;
    }

    @media screen and (max-width: 768px) {
      .flex-item.w-30 div.plus {
        bottom: 33% !important;
        right: 0;
      }

      .tbl_price_deli thead {
        top: 0;
        position: unset;
        display: block;
      }

      .tbl_s.cl2 {
        overflow-x: unset;
      }

      .tbl_price_deli tbody {
        max-height: 250px;
        overflow-y: auto;
        display: block;
        width: 100%;
      }

      .tbl_price_deli tbody tr {
        width: 100%;
        display: table;
      }

      .tbl_price_deli tbody td {
        width: calc(100% / 7);
      }

      .tbl_price_deli th {
        width: calc(100% /7);
      }
    }

    .tbl_price_deli tr td:nth-child(n+2):hover {
      background: #d9ffe3;
      cursor: pointer;
    }

    table.tbl_price_deli tr td:nth-child(1) {
      background: #ffdada !important;
    }

    table.tbl_price_deli tr:nth-child(2)>th:nth-child(n) {
      background: #b8e9ff;
      color: #2196f3;
    }

    .tb-w12-new tbody td:not(:first-child) {
      background: #f0f0f0;
    }

    .tb-w12-new tr:nth-child(3) td:nth-child(n+2) {
      background: white !important;
    }

    .tb-w12-new {
      background: #f0f0f0;
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
      <?php include('../global_news.html'); ?>
      <?php include('banner-campaign.php') ?>
      <h1><?= lang('オリジナル刺繍バッジの製作　50枚から') ?></h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=オリジナルメガネクロス&amp;body=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。:https://hotmobily.jp/products/cloth.php" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a><a href="mailto:?subject=オリジナルメガネクロス&amp;body=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。:https://hotmobily.jp/products/cloth.php" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fcloth.php" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fcloth.php&amp;text=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
      </div>

      <div class="flex-container">
        <div class="flex-item item">
          <div class="preview-container">
            <div class="preview-top my-gallery">
              <div id="box-show-id-1">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_01" src="images/flight_tag/ft_badge_01_S.webp" data-zoom-image="images/flight_tag/ft_badge_01_L.webp" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-2">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_02" src="images/flight_tag/ft_badge_02_S.webp" data-zoom-image="images/flight_tag/ft_badge_02_L.webp" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-3">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_03" src="images/flight_tag/ft_badge_03_S.webp" data-zoom-image="images/flight_tag/ft_badge_03_L.webp" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-4">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                    <img class="zoom-img" id="zoom_04" src="images/flight_tag/ft_badge_04_S.webp" data-zoom-image="images/flight_tag/ft_badge_04_L.webp" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
            </div>
            <div class="preview-sub flex-container">
              <div class="flex-item"><img src="images/flight_tag/ft_badge_01_S.webp" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();">
              </div>
              <div class="flex-item"><img src="images/flight_tag/ft_badge_02_S.webp" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();">
              </div>
              <div class="flex-item"><img src="images/flight_tag/ft_badge_03_S.webp" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();">
              </div>
              <div class="flex-item"><img src="images/flight_tag/ft_badge_04_S.webp" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();">
              </div>
            </div>
          </div>
          <div style="font-size: 12px;" class="camera-preview">📷<?= lang('大きな画像にマウスを合わせると拡大されます') ?></div>
          <div class="ptw-container"></div>
        </div>

        <div class="flex-item item">
          <table class="table_rubber" style="padding: 0 ;">
            <tr>
              <td class="TableLeft"><?= lang('名称') ?></td>
              <td class=""><?= lang('刺繍バッジ') ?></td>
            </tr>
            <tr>
              <td class="TableLeft"><?= lang('サイズ') ?></td>
              <td class="">縦の長さと横の長さの合計が30㎝以内</td>
            </tr>
            <tr>
              <td class="TableLeft">印刷加工</td>
              <td class="">刺繍・ジャガード織</td>
            </tr>
            <tr>
              <td class="TableLeft">フチ加工</td>
              <td class="">オーバーロック仕上げ・ヒートカット仕上げ</td>
            </tr>
            <tr>
              <td class="TableLeft">裏面留め具</td>
              <td class="">ロック式の安全ピン・バタフライクラッチ</td>
            </tr>
            <tr>
              <td class="TableLeft">最小ロット</td>
              <td class="">50枚</td>
            </tr>
            <tr>
              <td class="TableLeft">試作品</td>
              <td class="">5,500円（税込）<br />但し、300個以上ご注文の場合は無料になります。</td>
            </tr>
            <tr>
              <td class="TableLeft">本生産納期</td>
              <td class="">15営業日</td>
            </tr>
            <tr>
              <td class="TableLeft">単価</td>
              <td class="">94円（税込）～</td>
            </tr>
          </table>
        </div>
      </div>
      <div>&nbsp;</div>

      <p>
        バッジをオリジナルデザインで製作できます。社名やロゴ、オリジナルイラストを入れて、ノベルティやイベントグッズとしてもご活用いただけます。最短15営業日出荷の短納期、50枚からご注文いただけます。
      </p>
      <div>&nbsp;</div>
      <p>
        刺繍とジャガード織から選べる、名入れ可能な完全オーダーメイドです。ブローチ代わりにジャケットなどの衣類につけたり、バッグや帽子につけてデコレーションしたり、様々な用途でお使いいただけます。
      </p>
      <div>&nbsp;</div>

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
        <h2>試作納期</h2>
        <div style="display: flex;">
          <div class="delivery"><span class="btn-a" style="background: #66fffe; color: #000;">試作納期</span>
          </div>
          <div class="delivery">
            <div class="tb_06" style="color: #004140;padding: 2px 5px;">7営業日後出荷</div>
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
      <div class="flex-container">
        <div class="flex-item item btn-contain">
          <div class="btn-container item_btn">
            <a class="btn-a ord-btn" href="#est-content" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background-color: #FF9900; border-color: #FF9900;">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
              </svg>
              ご注文・お見積書作成
            </a>
          </div>
        </div>
      </div>

      <h2><?= lang('刺繍バッジの特徴') ?></h2>
      <h2 class="feature1">立体感のある刺繍と、細かいデザインも可能なジャガード織</h2>
      <p>
        オリジナルデザインを刺繍およびジャガード織で再現いたします。刺繍タイプは、ベースの生地に刺繍を施すため、立体感が生まれます。ジャガード織は、お守り等でよくみられる技法で、比較的細かいデザインも可能です。どちらをお選びいただいても製作料金は変わりませんので、お好みに応じてお選びください。
      </p>
      <div class="d-flex">
        <div class="flex-item">
          <a href="images/flight_tag/W_-05.webp?v=1.01" data-lightbox="sample_1_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/flight_tag/W_-05.webp?v=1.01">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <h3>▲刺繍事例（線の太さは、最低1mmは必要です）</h3>
        </div>
        <div class="flex-item">
          <a href="images/flight_tag/ft_badge_09.webp?v=1.02" data-lightbox="sample_1_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/flight_tag/ft_badge_09.webp?v=1.02">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <h3>▲ジャガード織事例</h3>
        </div>
      </div>
      <h2 class="feature2">本体色も刺繍糸色も、種類豊富！</h2>
      <p>
        刺繍の場合、光沢のあるツイル生地と、暖かみのあるフェルト生地をお選びいただけます。生地色は、表と裏それぞれ22色からお選びください。その他の色も、ご希望の色に合わせてお選びいただけます。刺繍糸色は、お客様のデザインをもとに工場にて選定した色を使用いたします。（基本8色までとなっております）
      </p>
      <div>&nbsp;</div>
      <h3 style="font-family: IwaUDGoDspPro-Eb, sans-serif !important;font-size: 20px;">ツイル生地</h3>
      <img class="lazy" data-src="images/flight_tag/F_-34.webp">
      <div>&nbsp;</div>
      <h3 style="font-family: IwaUDGoDspPro-Eb, sans-serif !important;font-size: 20px;">フェルト生地</h3>
      <img class="lazy" data-src="images/flight_tag/F_-39.webp">


      <h2 class="feature3">フチ加工や裏面留め具も選択肢豊富</h2>
      <p>
        フチ加工は、オーバーロック仕上げとヒートカット仕上げからお選びいただけます。オーバーロック仕上げで使用する糸は、ご希望の色に最も近い色を使用いたします。裏側の留め具は、ロック式の安全ピンまたはバタフライクラッチいづれかをお選びください。
      </p>
      <div>&nbsp;</div>
      <div class="d-flex">
        <div class="flex-item">
          <a href="/products/images/wappen_overlock.webp?v=1.01" data-lightbox="sample_2_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/products/images/wappen_overlock.webp?v=1.01">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <h3>▲オーバーロック仕上げ</h3>
        </div>
        <div class="flex-item">
          <a href="images/flight_tag/W_-06.webp?v=1.01" data-lightbox="sample_2_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/flight_tag/W_-06.webp?v=1.01">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <h3>▲ヒートカット仕上げ</h3>
        </div>
      </div>


      <h2 class=""><?= lang('製品仕様') ?></h2>
      <div class="">
        <table class="table-border">
          <tr>
            <td>名称</td>
            <td>刺繍バッジ</td>
          </tr>
          <tr>
            <td>素材</td>
            <td>
              ツイル生地・フェルト生地
            </td>
          </tr>
          <tr>
            <td>サイズ</td>
            <td>
              <p>縦の長さと横の長さの合計が30㎝以内</p>
            </td>
          </tr>
          <tr>
            <td>印刷加工</td>
            <td>
              刺繍・ジャガード織
            </td>
          </tr>
          <tr>
            <td>生地色</td>
            <td>刺繍の場合、表・裏それぞれ22色からお選びください。</td>
          </tr>
          <tr>
            <td>フチ加工</td>
            <td>
              オーバーロック仕上げ・ヒートカット仕上げ
            </td>
          </tr>
          <tr>
            <td>裏面留め具</td>
            <td>
              ロック式の安全ピン・バタフライクラッチ
            </td>
          </tr>
          <tr>
            <td>最小ロット</td>
            <td>
              50枚
            </td>
          </tr>
          <tr>
            <td>試作品</td>
            <td>
              5,500円（税込）<br />但し、300個以上ご注文の場合は無料になります。
            </td>
          </tr>
          <tr>
            <td>包装</td>
            <td>
              ・一括包装<br />
              ・個別OPP包装
            </td>
          </tr>
        </table>
      </div>
      <div>&nbsp;</div>
      <img class="lazy" data-src="images/flight_tag/wappen_patch_size.webp?v=1.00" style="width:100%;">

      <h2 class="toggle-header"><?= lang('フチ加工・裏面留め具') ?><span>+</span></h2>
      <div class="toggle-container">
        <p>フチ加工は、オーバーロック仕上げとヒートカット仕上げからお選びいただけます。オーバーロック仕上げは、フチを二重縫いしているので、製品に厚みが出て高級感が増します。ヒートカット仕上げは、高温のカッターで生地を溶かしながら裁断するため、ほつれにくくなります。</p>
        <p>裏側の留め具は、ロック式の安全ピンまたはバタフライクラッチいづれかをお選びください。</p>

        <div>&nbsp;</div>
        <div class="d-flex">
          <div class="flex-item">
            <a href="images/flight_tag/ft_badge_07.webp?v=1.01" data-lightbox="sample_2_1" data-title="" style="text-decoration:none;">
              <img class="lazy" data-src="images/flight_tag/ft_badge_07.webp?v=1.01">
              <div class="plus"><i class="fas fa-search-plus"></i></div>
            </a>
            <h3>▲ロック式の安全ピン</h3>
          </div>
          <div class="flex-item">
            <a href="images/flight_tag/ft_badge_08.webp?v=1.01" data-lightbox="sample_2_2" data-title="" style="text-decoration:none;">
              <img class="lazy" data-src="images/flight_tag/ft_badge_08.webp?v=1.01">
              <div class="plus"><i class="fas fa-search-plus"></i></div>
            </a>
            <h3>▲バタフライクラッチ</h3>
          </div>
        </div>

      </div>

      <h2 class="toggle-header"><?= lang('テンプレート') ?><span>+</span></h2>
      <div class="toggle-container">
        <div class="flex-container justify-between">
          <a class="btn-a btn-yellow download_temp" href="download/download?fname=template-flighttag-badge_20231215.zip">
            <span>刺繍バッジ</span>
          </a>
        </div>
      </div>

      <h2 class=""><?= lang('製作料金') ?></h2>
      <p>ご希望のサイズ・数量に該当する価格表をクリックすると、注文画面に進みます。</p>
      <?php
      $prices = [
        '50' => '450',
        '100' => '348',
        '300' => '224',
        '500' => '182',
        '1000' => '131',
        '3000' => '86'
      ];
      ?>
      <div style="clear: both;"></div>
      <div class="tbl_s cl2" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tbl_price_deli loading">
          <thead>
            <tr>
              <th rowspan="2">縦＋横（cm）</th>
              <th colspan="6">数量</th>
            </tr>
            <tr>
              <th colspan="">50</th>
              <th colspan="">100</th>
              <th colspan="">300</th>
              <th colspan="">500</th>
              <th colspan="">1000</th>
              <th colspan="">3000</th>
            </tr>
          </thead>
          <tbody>
            <?php for ($i = 5; $i <= 30; $i++) : ?>
              <tr>
                <td><?= $i ?></td>
                <?php foreach ($prices as $key => $price) : ?>
                  <td data-size="<?= $i ?>" data-qty="<?= $key ?>" onclick="pre_set(this);"><?= floor(($price + (15 * ($i - 5))) * 1.1) ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endfor; ?>
          </tbody>
        </table>
      </div>
      <div>&nbsp;</div>
      <h3>【データトレース代金について】</h3>
      <p>アドビイラストレータの入稿データをお持ちでない場合、当店にてイラストレータファイルに変換するトレース作業を行います。その際、製作料金とは別に2,200円（税込）がかかります。</p>
      <h3>【版型料金】</h3>
      <p>1つのご注文につき、版型料金が上記料金とは別に4,400円（税込）かかります。</p>
      <h3>【フチ加工】</h3>
      <p>・オーバーロック仕上げ：＋@55円（税込）</p>
      <p>・ヒートカット仕上げ：追加料金なし</p>
      <h3>【裏面留め具】</h3>
      <p>・ロック式の安全ピン：＋@11円（税込）</p>
      <p>・バタフライクラッチ：＋@11円（税込）</p>
      <h3>【刺繍糸色の数】</h3>
      <p>糸色3色までは同一金額となります。4色以上は1色ごとに@22円（税込）加算となります。</p>
      <table width="100%" class="tb-w12-new" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tbody>
          <tr align="center">
            <td style="">&nbsp;</td>
            <td align="center" colspan="7">刺繍糸色の数</td>
          </tr>
          <tr align="center">
            <td style="">&nbsp;</td>
            <td align="center">1～3色 </td>
            <td align="center">4色</td>
            <td align="center">5色</td>
            <td align="center">6色</td>
            <td align="center">7色</td>
            <td align="center">8色</td>
          </tr>
          <tr>
            <td>追加料金</td>
            <td align="">なし</td>
            <td align="">@22円（税込）</td>
            <td align="">@44円（税込）</td>
            <td align="">@66円（税込）</td>
            <td align="">@88円（税込）</td>
            <td align="">@110円（税込）</td>
          </tr>
        </tbody>
      </table>
      <p>刺繍タイプは8色、ジャガード織タイプは9色までご使用可能です。</p>
      <h3>【包装料金】</h3>
      <p>・まとめ包装：追加料金なし</p>
      <p>・個包装：＋@8円（税込）</p>
      <h3>【試作品】</h3>
      <p>5,500円（税込）の追加料金がかかります。なお、300個以上ご注文の場合は無料です。</p>
      <h3>【WEB掲載】</h3>
      <p>ご注文画面にて「製作実績の掲載を許可する」をお選びいただいたお客様には、ご注文数量にかかわらず、合計金額から5,500円（税込）割引とさせていただきます。</p>

      <?php include("campaign_news.php"); ?>
      <h2 id="est-content"><?= lang('ご注文・見積書作成') ?></h2>
      <?php include("campaign_banner.php"); ?>
      <span style="font-size: 12px;">※<?= lang('一つのデザインにつき一注文となります。複数のデザインがある場合、それぞれのデザインで別々にご注文ください。') ?></span>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('オリジナル刺繍バッジ') ?>】</h3>
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
                <td><?= lang('仕様タイプ') ?></td>
                <td><span id="sample-prd-type"></span></td>
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
                <td><?= lang('OPP個別包装') ?></td>
                <td><span id="sample-prd-opp"></span></td>
              </tr>
            </table>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="images/flight_tag/ft_badge_07.webp?v=1.01" width="135" height="135" id="sample-part-pic" class="picpro">
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
                <div class="step-number">2</div><span class="step-details"><?= lang('試作品・OPP個別包装') ?></span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="オリジナル刺繍バッジ" />
          </div>
          <?php
          switch ($ft_type) {
            case '刺繍':
              $ft_type0 = "checked";
              break;
            case 'ジャガード織':
              $ft_type1 = "checked";
              break;
            default:
              $ft_type0 = "checked";
              break;
          }
          switch ($ft_option) {
            case 'スタンダード':
              $ft_option0 = "checked";
              break;
            case 'プレミアム':
              $ft_option1 = "checked";
              break;
            default:
              $ft_option0 = "checked";
              break;
          }
          switch ($ft_process) {
            case 'スタンダード':
              $ft_process0 = "checked";
              break;
            case 'プレミアム':
              $ft_process1 = "checked";
              break;
            default:
              $ft_process0 = "checked";
              break;
          }
          //Setup sample data
          switch ($ft_sample) {
            case 'あり':
              $sample = "checked";
              break;
          }
          //Setup sample data
          switch ($ft_trace) {
            case 'あり':
              $trace = "checked";
              break;
          }
          //Setup trace data
          switch ($ft_opp) {
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

            <h3><?= lang('サイズ（縦・横合計）') ?></h3>
            <div class="part-container">
              <div class="part-content prd-selection">
                <label class="part-name ">
                  <select name="ft_size" onchange="check_val('next')">
                    <option value="5" <?= ($ft_size == "5" ? 'selected' : '') ?>>5cm</option>
                    <option value="6" <?= ($ft_size == "6" ? 'selected' : '') ?>>6cm</option>
                    <option value="7" <?= ($ft_size == "7" ? 'selected' : '') ?>>7cm</option>
                    <option value="8" <?= ($ft_size == "8" ? 'selected' : '') ?>>8cm</option>
                    <option value="9" <?= ($ft_size == "9" ? 'selected' : '') ?>>9cm</option>
                    <option value="10" <?= ($ft_size == "10" ? 'selected' : '') ?>>10cm</option>
                    <option value="11" <?= ($ft_size == "11" ? 'selected' : '') ?>>11cm</option>
                    <option value="12" <?= ($ft_size == "12" ? 'selected' : '') ?>>12cm</option>
                    <option value="13" <?= ($ft_size == "13" ? 'selected' : '') ?>>13cm</option>
                    <option value="14" <?= ($ft_size == "14" ? 'selected' : '') ?>>14cm</option>
                    <option value="15" <?= ($ft_size == "15" ? 'selected' : '') ?>>15cm</option>
                    <option value="16" <?= ($ft_size == "16" ? 'selected' : '') ?>>16cm</option>
                    <option value="17" <?= ($ft_size == "17" ? 'selected' : '') ?>>17cm</option>
                    <option value="18" <?= ($ft_size == "18" ? 'selected' : '') ?>>18cm</option>
                    <option value="19" <?= ($ft_size == "19" ? 'selected' : '') ?>>19cm</option>
                    <option value="20" <?= ($ft_size == "20" ? 'selected' : '') ?>>20cm</option>
                    <option value="21" <?= ($ft_size == "21" ? 'selected' : '') ?>>21cm</option>
                    <option value="22" <?= ($ft_size == "22" ? 'selected' : '') ?>>22cm</option>
                    <option value="23" <?= ($ft_size == "23" ? 'selected' : '') ?>>23cm</option>
                    <option value="24" <?= ($ft_size == "24" ? 'selected' : '') ?>>24cm</option>
                    <option value="25" <?= ($ft_size == "25" ? 'selected' : '') ?>>25cm</option>
                    <option value="26" <?= ($ft_size == "26" ? 'selected' : '') ?>>26cm</option>
                    <option value="27" <?= ($ft_size == "27" ? 'selected' : '') ?>>27cm</option>
                    <option value="28" <?= ($ft_size == "28" ? 'selected' : '') ?>>28cm</option>
                    <option value="29" <?= ($ft_size == "29" ? 'selected' : '') ?>>29cm</option>
                    <option value="30" <?= ($ft_size == "30" ? 'selected' : '') ?>>30cm</option>
                  </select>
                </label>
              </div>
            </div>
            <h3><?= lang('仕様タイプ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="ft_type" value="刺繍" onclick="check_val('next')" <?= $ft_type0 ?>><?= lang('刺繍') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="ft_type" value="ジャガード織" onclick="check_val('next')" <?= $ft_type1 ?>><?= lang('ジャガード織') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>

            <div class="only_embro">
              <h3><?= lang('生地') ?></h3>
              <div class="part-container">
                <div class="part-content">
                  <label class="part-name"><input type="radio" name="ft_option" value="ツイル生地" onclick="check_val('next')" <?= $ft_option0 ?>><?= lang('ツイル生地') ?> <span class="checkmark"></span></label>
                </div>
                <div class="part-content">
                  <label class="part-name"><input type="radio" name="ft_option" value="フェルト生地" onclick="check_val('next')" <?= $ft_option1 ?>><?= lang('フェルト生地') ?> <span class="checkmark"></span></label>
                </div>
              </div>

              <h3>生地色　表</h3>
              <div class="part-content preview-container">
                <div class="preview-sub flex-container strap-color">
                  <div class="normal_c">
                    <div class="show_c">
                      <img src="" id="img-show-Insatsu1" class="d-none"><br />
                      <span id="txt-show-Insatsu1"></span>
                    </div>
                    <div class="choose_c">
                      <table>
                        <tbody>
                          <tr>
                            <td>
                              <input type="radio" id="0" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T184（赤色）' : '108（赤色）') ?>" <?= ($ft_fabric_color1 == '108（赤色）' || $ft_fabric_color1 == 'T184（赤色）' ? 'checked' : ($ft_fabric_color1 == '' ? 'checked' : '')) ?>>
                              <label for="0"><img src="images/flight_tag/icon-01.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="1" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T223（緑色）' : '63（緑）') ?>" <?= ($ft_fabric_color1 == '63（緑）' || $ft_fabric_color1 == 'T223（緑色）' ? 'checked' : "") ?>>
                              <label for="1"><img src="images/flight_tag/icon-02.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T47（紺藍）' : '83（紺藍）') ?>" <?= ($ft_fabric_color1 == '83（紺藍）' || $ft_fabric_color1 == 'T47（紺藍）' ? 'checked' : "") ?>>
                              <label for="2"><img src="images/flight_tag/icon-03.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="3" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T244（紅赤）' : '76（紅赤）') ?>" <?= ($ft_fabric_color1 == 'T244（紅赤）' || $ft_fabric_color1 == 'T244（紅赤）' ? 'checked' : "") ?>>
                              <label for="3"><img src="images/flight_tag/icon-04.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="4" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T142（オレンジ色）' : '30（オレンジ色）') ?>" <?= ($ft_fabric_color1 == '30（オレンジ色）' || $ft_fabric_color1 == 'T142（オレンジ色）'   ? 'checked' : "") ?>>
                              <label for="4"><img src="images/flight_tag/icon-05.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="5" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T95（えんじ）' : '131（えんじ）') ?>" <?= ($ft_fabric_color1 == '131（えんじ）' || $ft_fabric_color1 == 'T95（えんじ）' ? 'checked' : "") ?>>
                              <label for="5"><img src="images/flight_tag/icon-06.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="6" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T202（藤紫）' : '78（藤紫）') ?>" <?= ($ft_fabric_color1 == '78（藤紫）' || $ft_fabric_color1 == 'T202（藤紫）' ? 'checked' : "") ?>>
                              <label for="6"><img src="images/flight_tag/icon-07.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="7" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T258（紫色）' : '74（紫色）') ?>" <?= ($ft_fabric_color1 == '74（紫色）' || $ft_fabric_color1 == 'T258（紫色）' ? 'checked' : "") ?>>
                              <label for="7"><img src="images/flight_tag/icon-08.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="8" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T214（山吹色）' : '135（山吹色）') ?>" <?= ($ft_fabric_color1 == '135（山吹色）' || $ft_fabric_color1 == 'T214（山吹色）' ? 'checked' : "") ?>>
                              <label for="8"><img src="images/flight_tag/icon-09.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="9" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T54（黄色）' : '32（黄色）') ?>" <?= ($ft_fabric_color1 == '32（黄色）' || $ft_fabric_color1 == 'T54（黄色）' ? 'checked' : "") ?>>
                              <label for="9"><img src="images/flight_tag/icon-10.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="10" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T122（ピンク）' : '9（ピンク）') ?>" <?= ($ft_fabric_color1 == '9（ピンク）' || $ft_fabric_color1 == 'T122（ピンク）' ? 'checked' : "") ?>>
                              <label for="10"><img src="images/flight_tag/icon-11.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="11" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T219（茶色）' : '94（茶色）') ?>" <?= ($ft_fabric_color1 == '94（茶色）' || $ft_fabric_color1 == 'T219（茶色）' ? 'checked' : "") ?>>
                              <label for="11"><img src="images/flight_tag/icon-12.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="12" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T24（黄緑色）' : '35（黄緑色）') ?>" <?= ($ft_fabric_color1 == '35（黄緑色）' || $ft_fabric_color1 == 'T24（黄緑色）' ? 'checked' : "") ?>>
                              <label for="12"><img src="images/flight_tag/icon-13.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="13" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T218（ビリジアン）' : '66（ビリジアン）') ?>" <?= ($ft_fabric_color1 == '66（ビリジアン）' || $ft_fabric_color1 == 'T218（ビリジアン）' ? 'checked' : "") ?>>
                              <label for="13"><img src="images/flight_tag/icon-14.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="14" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T32（スカイブルー）' : '46（スカイブルー）') ?>" <?= ($ft_fabric_color1 == '46（スカイブルー）' || $ft_fabric_color1 == 'T32（スカイブルー）' ? 'checked' : "") ?>>
                              <label for="14"><img src="images/flight_tag/icon-15.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="15" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T37（青色）' : '52（青色）') ?>" <?= ($ft_fabric_color1 == '52（青色）' || $ft_fabric_color1 == 'T37（青色）' ? 'checked' : "") ?>>
                              <label for="15"><img src="images/flight_tag/icon-16.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="16" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T198（牡丹色）' : '12（牡丹色）') ?>" <?= ($ft_fabric_color1 == '12（牡丹色）' || $ft_fabric_color1 == 'T198（牡丹色）' ? 'checked' : "") ?>>
                              <label for="16"><img src="images/flight_tag/icon-17.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="17" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T256（灰色）' : '129（灰色）') ?>" <?= ($ft_fabric_color1 == '129（灰色）' || $ft_fabric_color1 == 'T256（灰色）' ? 'checked' : "") ?>>
                              <label for="17"><img src="images/flight_tag/icon-18.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="18" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? '1.2mmBLACA（黒色）' : '123（黒色）') ?>" <?= ($ft_fabric_color1 == '123（黒色）' || $ft_fabric_color1 == '1.2mmBLACA（黒色）' ? 'checked' : "") ?>>
                              <label for="18"><img src="images/flight_tag/icon-19.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="19" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T01B（白）' : '1（白）') ?>" <?= ($ft_fabric_color1 == '1（白）' || $ft_fabric_color1 == 'T01B（白）' ? 'checked' : "") ?>>
                              <label for="19"><img src="images/flight_tag/icon-20.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="20" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T199（ネイビー）' : '88（ネイビー）') ?>" <?= ($ft_fabric_color1 == '88（ネイビー）' || $ft_fabric_color1 == 'T199（ネイビー）' ? 'checked' : "") ?>>
                              <label for="20"><img src="images/flight_tag/icon-21.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="21" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T108（ダークブルー）' : '126（ダークブルー）') ?>" <?= ($ft_fabric_color1 == '126（ダークブルー）' || $ft_fabric_color1 == 'T108（ダークブルー）' ? 'checked' : "") ?>>
                              <label for="21"><img src="images/flight_tag/icon-22.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="pantone" class="STD_printing_color1" name="ft_fabric_color1" value="PANTONE/DIC指定" <?= ($ft_fabric_color1 == 'PANTONE/DIC指定' ? 'checked' : "") ?>>
                              <label for="pantone">
                                <div>PANTONE/<br />DIC指定</div>
                              </label>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <h3><?= lang('使用する糸色の数') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty"><input type="number" name="color_variation" max="8" style="text-align: right;" onblur="check_val('next');(this.value.trim()==0 || this.value.trim()==''?this.value = '1':'')" value="<?= ($color_variation == "" || $color_variation == "0" ? 1 : $color_variation) ?>"></label>
              </div>
            </div>

            <h3><?= lang('フチ加工') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ft_process" value="オーバーロック仕上げ" onclick="check_val('next')" <?= $ft_process0 ?>><?= lang('オーバーロック仕上げ') ?>【＋@55円（税込）】 <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ft_process" value="ヒートカット仕上げ" onclick="check_val('next')" <?= $ft_process1 ?>><?= lang('ヒートカット仕上げ') ?>【追加料金なし】 <span class="checkmark"></span></label>
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
            <h3><?= lang('裏面留め具') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name p-normal"><input type="radio" name="ft_backside" value="ロック式の安全ピン" onclick="check_val('next')" <?= ($ft_backside == "" ? "checked" : ($ft_backside == "ロック式の安全ピン" ? "checked" : "")) ?>><?= lang('ロック式の安全ピン') ?>【＋@11円（税込）】 <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name p-normal"><input type="radio" name="ft_backside" value="バタフライクラッチ" onclick="check_val('next')" <?= ($ft_backside == "バタフライクラッチ" ? "checked" : "") ?>><?= lang('バタフライクラッチ') ?>【＋@11円（税込）】 <span class="checkmark"></span></label>
              </div>
            </div>

            <h3><?= lang('試作品・データトレース・OPP個別包装') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='ft_sample'>
                    <input type="checkbox" class="checkbox" name="ft_sample" value="あり" onclick="check_val('next');" <?= $sample ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>試作品【300個以下ご注文の場合、5500円（税込）】
                </label>
                <div class="error" id="sample-error"></div>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='ft_trace'>
                    <input type="checkbox" class="checkbox" name="ft_trace" value="あり" onclick="check_val('next');" <?= $sample ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>データトレース【2,200円（税込）】
                </label>
                <div class="error" id="sample-error"></div>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='ft_opp'>
                    <input type="checkbox" class="checkbox" name="ft_opp" value="あり" onclick="check_val('next');" <?= $opp ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>OPP個別包装【＋@8円（税込）】
                </label>
              </div>
            </div>

            <h3><?= lang('ご注文製品の当店WEBサイトへの掲載・ご連絡事項') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name p-normal"><input type="radio" name="keisai" value="製作実績の掲載を許可する" onclick="check_val('next')" <?= ($keisai == "製作実績の掲載を許可する" ? 'checked' : ($keisai == "" ? 'checked' : '')) ?>><?= lang('製作実績の掲載を許可する') ?>【5,500円（税込）の割引が適用されます。】<span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name p-normal"><input type="radio" name="keisai" value="製作実績の掲載を許可しない" onclick="check_val('next')" <?= ($keisai == "製作実績の掲載を許可しない" ? 'checked' : '') ?>><?= lang('製作実績の掲載を許可しない') ?> <span class="checkmark"></span></label>
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
                      <td class="TableLeft"><?= lang('注文製品タイプ') ?></td>
                      <td class="" id="prd_production" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('サイズ（縦・横合計）') ?></td>
                      <td class="" id="prd_size" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('仕様タイプ') ?></td>
                      <td class="" id="prd_type" style="text-align: left;"></td>
                    </tr>
                    <tr class="only_embro">
                      <td class="TableLeft"><?= lang('生地') ?></td>
                      <td class="" id="prd_material" style="text-align: left;"></td>
                    </tr>
                    <tr class="only_embro">
                      <td class="TableLeft"><?= lang('生地色　表') ?></td>
                      <td class="" id="prd_fabric_color1" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('使用する糸色の数') ?></td>
                      <td class="" id="prd_color_variation" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('フチ加工') ?></td>
                      <td class="" id="prd_processing" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('数量') ?></td>
                      <td class="" id="prd_amount" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('裏面留め具') ?></td>
                      <td class="" id="prd_part" style="text-align: left;"><?= lang('デザインあり') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class="" id="prd_sample" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class="" id="prd_trace" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('OPP個別包装') ?></td>
                      <td class="" id="prd_opp" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('WEB掲載') ?></td>
                      <td class="" id="prd_web" style="text-align: left;"></td>
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
                      <td class="TableLeft"><?= lang('版型料金') ?></td>
                      <td class=""><input id="prd_mold_price" type="text" name="prd_mold_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('フチ加工') ?></td>
                      <td class=""><input id="prd_process_price" type="text" name="prd_process_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class=""><input id="prd_trace_price" type="text" name="prd_trace_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('糸色料金') ?></td>
                      <td class=""><input id="prd_color_price" type="text" name="prd_color_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('裏面留め具') ?></td>
                      <td class=""><input id="prd_part_price" type="text" name="prd_part_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('送料') ?></td>
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
      <h2 class="toggle-header"><?= lang('刺繍バッジに関するFAQ') ?><span>+</span></h2>
      <div class="toggle-container">
        <p class="text-orange">1. データ作成方法について教えてください。</p>
        <p>お客様ご自身でデータを作成される場合には、テンプレートをご使用ください。もしくは、イメージのデザインデータを弊社へメール送付いただきましたら、デザイン図を作成いたします（有料）。contact@hotmobily.jp 例えば、名刺しかない、昔作った実物しかない、お店の看板の写真しかない場合でも、そのデータを元に製作できる場合がほとんどです。</p>
        <div>&nbsp;</div>
        <p class="text-orange">2. 昇華転写（フルカラー）印刷もできますか？</p>
        <p>大変恐れ入りますが、現在は刺繍とジャガード織のみ承っております。</p>
        <div>&nbsp;</div>
        <p class="text-orange">3. 注文方法、決済方法を教えてください。</p>
        <p>決済方法は、銀行振込とクレジットカード決済からお選びいただけます。詳しくは<a href="/guide/payment">こちら</a>をご覧ください。</p>
        <div>&nbsp;</div>
        <p class="text-orange">4. 注文内容のキャンセルや変更はできますか？</p>
        <p>【キャンセルについて】</p>
        <p>ご注文確定前でしたら、ご注文の取消（キャンセル）が可能です。ご入金が完了している場合、かかった費用を差し引いて、ご指定の銀行口座にご返金致します。ご注文確定後かつ量産開始前の場合は、キャンセル料がかかります。ご注文確定後かつ量産開始後は、誠に申し訳ございませんが、ご注文の取消（キャンセル）をお受けできません。</p>
        <p>【変更について】</p>
        <p>ご注文確定後でも、量産開始前でしたらご注文内容の変更が可能です。変更内容により、変更に必要な期間、費用が異なります。量産開始後は、誠に申し訳ございませんが、ご注文の変更をお受けできません。詳しくは<a href="/guide/cancel_return">こちら</a>をご覧ください。</p>
        <div>&nbsp;</div>
        <p class="text-orange">5. 量産前に、試作品を確認することはできますか？</p>
        <p>はい、可能です。試作品は現在、期間限定で無料で承っております。ご注文画面にて「試作品あり」をご選択ください。</p>
        <div>&nbsp;</div>
        <p class="text-orange">6. 仕様に記載のサイズ以外のサイズも製作できますか？</p>
        <p>指定サイズ範囲外をご希望の場合は、弊社の営業担当までご相談ください。</p>
        <div>&nbsp;</div>
      </div>

      <?php include('flight_tag_blog.php'); ?>

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
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
  <script language="JavaScript" src="/js/calculater_ftc_new.js?v=<?php echo date('is') ?>" type="text/javascript"></script>
  <script type="text/javascript" src="js/pdf_wappen_new.js?v=<?php echo date('is') ?>"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="/products/acrylic/ptw/photoswipe.min.js?v=1.08"></script>
  <script src="/products/acrylic/ptw/photoswipe-ui-default.min.js"></script>
  <script type="text/javascript">
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
      url: "/products/check_holiday.php",
      data: {
        "product": "7days"
      },
      success: function(data) {
        productionDate2(data.sort());
      },
      dataType: "json"
    });
    var tmp = "<?= $_GET['mode'] ?>";
    $(function() {
      var t = $("#i_txt1"),
        s = $("#i_txt2");
      screen.width <= 768 && (t.attr("src", "images/img_txt2_n1.svg"), s.attr("src", "images/text_sample_n1.svg"))
    }, (tmp != "" ? valid_chk_btn('step3') : ""));

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

    $("h2.toggle-header, h2.toggle-header span").click(function() {
      // Slide toggle the next .toggle-container
      $(this).next(".toggle-container").slideToggle();

      // Change the text of the span inside the clicked h2
      var span = $(this).find("span");
      if (span.text() === "+") {
        span.text("-");
      } else {
        span.text("+");
      }
    });
  </script>
</body>

</html>