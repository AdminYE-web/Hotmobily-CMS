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
  <meta name="keywords" content="<?= lang('フライトタグ,オリジナル,刺繍タグ,製作,デザイン,刺繍タグキーホルダー,制作,名入れ') ?>">
  <meta name="description" content="<?= lang('フライトタグ（刺繍タグキーホルダー）をオリジナルデザインで製作できます。名入れ可能な完全オーダーメイド。細かいデザインでも制作可能です。最短15営業日出荷の短納期。50枚からご注文いただけます。') ?>">
  <meta name="robots" content="index,follow">
  <title><?= lang('フライトタグ（刺繍タグキーホルダー）の製作50枚から HOTMOBILYオリジナルグッズ') ?></title>
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
  <link href="css/flight_tag.css?v=1.10" rel="stylesheet" type="text/css" />
  <link href="https://hotstrap.jp/css/products.css?v=1.15" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/hand-scroll.css?v=1.00" rel="stylesheet" type="text/css">

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
   .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
}
    .show_c img {
      width: fit-content;
      height: auto;
    }

    #content_wrapper>h2.feature1,
    #content_wrapper>h2.feature2,
    #content_wrapper>h2.feature3,
    #content_wrapper>h2.feature4 {
      text-align: left;
    }

    @media (max-width: 576px) {
      .delivery .btn-a {
        margin-bottom: 5px;
      }

      .jp-des {
        margin: 10px 0px 10px 0px;
      }

      .item-img-jp {
        margin-bottom: 5px;
      }
    }

    @media screen and (max-width: 768px) {
      .delivery .btn-a {
        margin-bottom: 5px;
      }

      .jp-des {
        margin: 10px 0px 10px 0px;
      }

      .item-img-jp {
        margin-bottom: 5px;
      }
    }

    .repeat input[type="text"] {
      padding: 5px 10px;
      margin-left: -32px;
      width: -webkit-fill-available;
    }

    .new-text {
      font-size: 16px !important;
      letter-spacing: 0.05em !important;
      line-height: 150% !important;
    }

    table.tbl_price_deli tr:first-child>th:nth-child(4) {
      background: #ffe64e;
      color: #ff6414;
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
      <h1><?= lang('フライトタグ（刺繍タグキーホルダー）の製作　50枚から') ?></h1>
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
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1000x1000">
                    <img class="zoom-img" id="zoom_01" src="images/flight_tag/Flighttags_20250423.webp?v=1.02" data-zoom-image="images/flight_tag/F_-28-L.webp?v=1.01" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-2">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1000x1000">
                    <img class="zoom-img" id="zoom_02" src="images/flight_tag/F_-29.webp?v=1.02" data-zoom-image="images/flight_tag/F_-29-L.webp?v=1.01" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-3">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1000x1000">
                    <img class="zoom-img" id="zoom_03" src="images/flight_tag/F_-30.webp?v=1.02" data-zoom-image="images/flight_tag/F_-30-L.webp?v=1.01" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-4">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1000x1000">
                    <img class="zoom-img" id="zoom_04" src="images/flight_tag/F_-31.webp?v=1.02" data-zoom-image="images/flight_tag/F_-31-L.webp?v=1.01" width="376" height="231" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
            </div>
            <div class="preview-sub flex-container">
              <div class="flex-item"><img src="images/flight_tag/Flighttags_20250423.webp?v=1.02" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();">
              </div>
              <div class="flex-item"><img src="images/flight_tag/F_-29.webp?v=1.02" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();">
              </div>
              <div class="flex-item"><img src="images/flight_tag/F_-30.webp?v=1.02" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();">
              </div>
              <div class="flex-item"><img src="images/flight_tag/F_-31.webp?v=1.02" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();">
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
              <td class=""><?= lang('フライトタグ（刺繍タグキーホルダー）') ?></td>
            </tr>
            <tr>
              <td class="TableLeft"><?= lang('サイズ') ?></td>
              <td class="">縦：約30mm／横：約140mm<br />基本形状は長方形ですが、ご希望の形状があればご相談ください。</td>
            </tr>
            <tr>
              <td class="TableLeft">印刷加工</td>
              <td class="">刺繍（8色以内）・ジャガード織（8色以内）・昇華転写（フルカラー印刷）</td>
            </tr>
            <tr>
              <td class="TableLeft">フチ加工</td>
              <td class="">オーバーロック仕上げ</td>
            </tr>
            <tr>
              <td class="TableLeft">裏面</td>
              <td class="">デザイン可</td>
            </tr>
            <tr>
              <td class="TableLeft">アタッチメント</td>
              <td class="">銀リング・黒リング・銀色ナスカン</td>
            </tr>
            <tr>
              <td class="TableLeft">最小ロット</td>
              <td class="">50枚</td>
            </tr>
            <tr>
              <td class="TableLeft">試作品</td>
              <td class="">5,500円（税込）<br />
                但し、300個以上ご注文の場合は無料になります。</td>
            </tr>
            <tr>
              <td class="TableLeft">本生産納期</td>
              <td class="">15営業日</td>
            </tr>
            <tr>
              <td class="TableLeft">単価</td>
              <td class="">132円（税込）～　</td>
            </tr>
          </table>
        </div>
      </div>
      <div>&nbsp;</div>

      <p class="new-text">
        フライトタグ（刺繍タグキーホルダー）をオリジナルデザインで製作できます。航空・旅行業界のみならず、ロゴやイラストを入れたイベントグッズとしてもご活用いただけます。最短15営業日出荷の短納期、50枚からご注文いただけます。
      </p>
      <div>&nbsp;</div>
      <p class="new-text">
        刺繍（8色以内）・ジャガード織（8色以内）・昇華転写（フルカラー印刷）から選べる、名入れ可能な完全オーダーメイドです。トラベルバッグに取り付けたり、キーホルダーとして日常使いしたり、ジャケットなど衣類に付けたりと、さまざまな用途があります。
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

      <h2>3種類のフライトタグをご用意！</h2>
      <p class="new-text">当店では、刺繍タイプ・ジャガード織タイプ・昇華転写タイプの3種類のフライトタグをご用意しております。</p>
      <div class="flex-container">
        <div class="flex-item w-30">
          <a href="images/EmbroideredFT.webp?v=1.01" data-lightbox="sample_0_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/EmbroideredFT.webp?v=1.01">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div style="text-align: center;">刺繍タイプ</div>
        </div>
        <div class="flex-item w-30">
          <a href="images/JacquardFT.webp?v=1.01" data-lightbox="sample_0_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/JacquardFT.webp?v=1.01">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div style="text-align: center;">ジャガード織タイプ</div>
        </div>
        <div class="flex-item w-30">
          <a href="images/PrintedFT.webp?v=1.01" data-lightbox="sample_0_3" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/PrintedFT.webp?v=1.01">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div style="text-align: center;">昇華転写タイプ</div>
        </div>
      </div>
      <div>
        <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">【刺繍フライトタグ】立体感がポイント！</h2>
        <p class="new-text">特別なオリジナルのフライトタグに、確かな“手応え”を。糸の一本一本による立体感ある刺繍でデザインを再現します。</p><br />

        <p class="new-text">刺繍タイプのフライトタグは、その重厚感ある仕上がりと実用性で、幅広い業界から選ばれ続けている定番アイテムです。手に取った瞬間に伝わるしっかりした厚みと、刺繍ならではの立体感が、企業やブランドの信頼感を強く印象づけます。ヴィンテージライクなデザインにも、ミニマルな現代的ロゴにも絶妙にマッチ。</p><br />

        <p class="new-text">社名やロゴマークの刺繍などカスタマイズが自由自在で、航空・自動車・イベント業界をはじめ、社名やメッセージの発信に最適です。とくに航空機やミリタリー由来のデザインに相性が良く、その精巧さはまさに「本物志向」のための選択。</p><br />

        <p class="new-text">「手に取って嬉しいフライトタグ」をお探しなら、刺繍フライトタグをぜひご検討ください。</p>
      </div>
      <div>
        <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">【ジャガード織フライトタグ】細かいデザインに最適！</h2>
        <p class="new-text">細やかでスマートな、際立つ“存在感”を。こだわりの織りの技術でデザインを再現します。</p><br />

        <p class="new-text">糸の織り込みによってロゴやデザインを再現するため、極細の線もクリアに表現。緻密なつくりのロゴや線画風のデザイン、小さな文字のさりげないメッセージも、糸の密な織りによって美しくあざやかにカタチにします。繊細な文字や複雑な模様もはっきり表現できるため、「ブランドロゴを正確に再現したい」「企業スローガンをきれいに見せたい」といったご要望にも柔軟に対応可能。その高度な再現力はまさに「ゆずれないこだわり」のための技術力。</p><br />

        <p class="new-text">さらに、フラットな表面はスマートな印象を与え、落ち着いた品格を演出。自社のイメージ戦略やオリジナルデザインの印象付けで効果を発揮します。</p><br />

        <p class="new-text">「ディテールが目を引くフライトタグ」をお探しなら、ジャガード織フライトタグをぜひご検討ください。</p>
      </div>
      <div>
        <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">【昇華転写フライトタグ】細かいデザインに最適！</h2>
        <p class="new-text">卓越した描写力で、圧倒的な'リアリティ'を。ハイレベルの印刷技術でデザインを再現します。</p><br />

        <p class="new-text">昇華転写タイプなら、専用の特殊な印刷技術による高発色で、陰影や色の階調を色彩豊かに再現。写真のようなグラフィックや繊細なカラーデザインをあざやかに描き出します。フォトライクなグラフィックや配色にこだわった図柄が、そのままの姿でフライトタグに。「リアルなデザインに仕上げたい」「カラーグラデーションの入ったロゴをそのまま再現したい」などのご要望でしたら、昇華転写タイプのフライトタグがぴったりです。ピクセル単位の精細なプリントは、まさに「写実の美」のためのリアルさ。</p><br />

        <p class="new-text">印刷面はフラットな仕上がりで、なめらかな手触り。プレミアム感を演出します。</p><br />

        <p class="new-text">「リアリティで魅せるフライトタグ」をお探しなら、昇華転写フライトタグをぜひご検討ください。</p>
      </div>

      <h2><?= lang('フライトタグ（刺繍タグキーホルダー）の特徴') ?></h2>
      <h2 class="feature1">本体色も刺繍糸色も、種類豊富！</h2>
      <p class="new-text">
        刺繍タイプは本体色も刺繍糸色も、種類豊富！
      </p>
      <img class="lazy" data-src="images/flight_tag/F_-34.webp">
      <h2 class="feature2">フチ加工は厚みの出るオーバーロック仕上げ</h2>
      <p class="new-text">
        フチ加工は、フライトタグに一般的に用いられるオーバーロック仕上げとなります。フチを二重縫いしているので、製品に厚みが出て高級感が増します。オーバーロック仕上げで使用する糸は、ご希望の色に最も近い色を使用いたします。裏面は、表面と同様にデザインを入れることができます。
      </p>
      <div class="flex-container">
        <div class="flex-item item-img-jp">
          <a href="images/flight_tag/F_-35.webp?v=1.01" data-lightbox="sample_5_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/flight_tag/F_-35.webp?v=1.01">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
        </div>
        <div class="flex-item">
          <a href="images/flight_tag/F_-36.webp" data-lightbox="sample_5_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/flight_tag/F_-36.webp">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
        </div>
      </div>

      <h2 class=""><?= lang('フライトタグとは') ?></h2>
      <div class="">
        <p class="new-text">離陸前の取り外しミスを防ぐために、目印として飛行機のカバーや安全装置に取り付けられる「REMOVE BEFORE FLIGHT」のタグ。 航空業界関係者や旅行好きな人々の中で「おしゃれ」「かわいい」と話題を呼び、好きなイラストや文字を入れたオリジナルフライトタグも人気となっています。</p>

        <div class="flex-container">
          <div class="flex-item item-img-jp">
            <a href="images/flight_tag/F_-37.webp?v=1.01" data-lightbox="sample_4_1" data-title="" style="text-decoration:none;">
              <img class="lazy" data-src="images/flight_tag/F_-37.webp?v=1.01">
              <div class="plus"><i class="fas fa-search-plus"></i></div>
            </a>
          </div>
          <div class="flex-item">
            <a href="images/flight_tag/F_-38.webp?v=1.01" data-lightbox="sample_4_1" data-title="" style="text-decoration:none;">
              <img class="lazy" data-src="images/flight_tag/F_-38.webp?v=1.01">
              <div class="plus"><i class="fas fa-search-plus"></i></div>
            </a>
          </div>
        </div>
      </div>

      <h2 class=""><?= lang('製品仕様') ?></h2>
      <div>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td><?= lang('名称') ?></td>
              <td><?= lang('フライトタグ（刺繍タグキーホルダー）') ?></td>
            </tr>
            <tr>
              <td><?= lang('サイズ') ?></td>
              <td><?= lang('基本サイズは縦：約30mm／横：約140mmです。') ?><br />基本形状は長方形ですが、ご希望の形状があればご相談ください。</td>
            </tr>
            <tr>
              <td><?= lang('印刷加工') ?></td>
              <td>刺繍（8色以内）・ジャガード織（8色以内）・昇華転写（フルカラー印刷）</td>
            </tr>
            <tr>
              <td><?= lang('生地色') ?></td>
              <td>表・裏それぞれ22色からお選びください。それ以外の色をパントーン番号でご指定いただくことも可能です。</td>
            </tr>
            <tr>
              <td><?= lang('フチ加工') ?></td>
              <td><?= lang('オーバーロック仕上げ') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('裏面加工') ?></td>
              <td>
                <?= lang('デザイン可') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('アタッチメント') ?></td>
              <td>
                <?= lang('銀リング・黒リング・銀色ナスカン') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('最小ロット') ?></td>
              <td>
                <?= lang('50枚') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('試作品') ?></td>
              <td>
                <?= lang('5,500円（税込）<br/>但し、300個以上ご注文の場合は無料になります。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('包装') ?></td>
              <td>
                ・一括包装<br />
                ・個別OPP包装
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <h2 class="toggle-header"><?= lang('アタッチメント') ?><span>+</span></h2>
      <div class="toggle-container">
        <p class="new-text">アタッチメントは、銀リング・黒リング・銀色ナスカンのいづれかをお選びいただけます。どちらをお選びいただいても、追加料金はかかりません。</p>
        <div class="flex-container">
          <div class="flex-item w-30">
            <a href="images/flight_tag/ft-part-1.webp" data-lightbox="sample_part" data-title="" style="text-decoration:none;">
              <img class="lazy" data-src="images/flight_tag/ft-part-1.webp">
              <div class="plus"><i class="fas fa-search-plus"></i></div>
            </a>
            銀リング
          </div>
          <div class="flex-item w-30">
            <a href="images/flight_tag/ft-part-2.webp" data-lightbox="sample_part" data-title="" style="text-decoration:none;">
              <img class="lazy" data-src="images/flight_tag/ft-part-2.webp">
              <div class="plus"><i class="fas fa-search-plus"></i></div>
            </a>
            黒リング
          </div>
          <div class="flex-item w-30">
            <a href="images/flight_tag/ft-part-3.webp" data-lightbox="sample_part" data-title="" style="text-decoration:none;">
              <img class="lazy" data-src="images/flight_tag/ft-part-3.webp">
              <div class="plus"><i class="fas fa-search-plus"></i></div>
            </a>
            銀色ナスカン
          </div>
        </div>
      </div>

      <h2 class="toggle-header"><?= lang('テンプレート') ?><span>+</span></h2>
      <div class="toggle-container">
        <div class="flex-container justify-between">
          <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
            <span>フライトタグ</span>
          </a>
        </div>
      </div>
      <div id="download_templete" class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=template-flight_tag_20260423_OL.ai" target="_blank">
                    <div><img class="lazy" data-src="/products/acrylic/img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="download/download.php?fname=template-flight_tag_20260423_OL.pdf" target="_blank">
                    <div><img class="lazy" data-src="/products/acrylic/img/pdf-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- <h2 class="toggle-header"><?= lang('製作料金') ?><span>+</span></h2> -->
      <h2 class="" style="text-align:left;">&nbsp;&nbsp;<?= lang('製作料金') ?></h2>
      <div class="toggle-container" style="display:block;">
        <div class="tbl_price_tg text-right">
          <div>
            <label class="switch_chk"><input type="checkbox" id="tg_unit" onchange="$('.ut_price').toggle();" /><label for="tg_unit"></label><?= lang('単価を表示'); ?></label>
          </div>
        </div>
        <div style="clear: both;"></div>
        <div class="tbl_s cl2" style="position: relative;">
          <div class="scroll-center">
            <div class="arrow"></div>
          </div>
          <table class="tbl_price_deli loading">
            <thead>
              <tr>
                <th></th>
                <th colspan="">刺繍</th>
                <th colspan="">ジャガード織</th>
                <th colspan="">昇華転写</th>
              </tr>
              <tr>
                <th rowspan="">数量</th>
                <th colspan="">製作料金（税込総額）</th>
                <th colspan="">製作料金（税込総額）</th>
                <th colspan="">制作料金 (税込総額) </th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td>50</td>
                <td>
                  <div class="tt_price" style="font-size:16px">30,800 円</div>
                  <div class="ut_price" style="font-size:16px">616 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">34,650 円</div>
                  <div class="ut_price" style="font-size:16px">693 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">31,900 円</div>
                  <div class="ut_price" style="font-size:16px">638 円</div>
                </td>
              </tr>
              <tr>
                <td>100</td>
                <td>
                  <div class="tt_price" style="font-size:16px">46,700 円</div>
                  <div class="ut_price" style="font-size:16px">467 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">50,600 円</div>
                  <div class="ut_price" style="font-size:16px">506 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">41,800 円</div>
                  <div class="ut_price" style="font-size:16px">418 円</div>
                </td>
              </tr>
              <tr>
                <td>300</td>
                <td>
                  <div class="tt_price" style="font-size:16px">105,600 円</div>
                  <div class="ut_price" style="font-size:16px">352 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">79,200 円</div>
                  <div class="ut_price" style="font-size:16px">264 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">83,700 円</div>
                  <div class="ut_price" style="font-size:16px">279 円</div>
                </td>
              </tr>
              <tr>
                <td>500</td>
                <td>
                  <div class="tt_price" style="font-size:16px">123,500 円</div>
                  <div class="ut_price" style="font-size:16px">247 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">107,000 円</div>
                  <div class="ut_price" style="font-size:16px">214 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">93,500 円</div>
                  <div class="ut_price" style="font-size:16px">187 円</div>
                </td>
              </tr>
              <tr>
                <td>1000</td>
                <td>
                  <div class="tt_price" style="font-size:16px">181,000 円</div>
                  <div class="ut_price" style="font-size:16px">181 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">170,000 円</div>
                  <div class="ut_price" style="font-size:16px">170 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">176,000 円</div>
                  <div class="ut_price" style="font-size:16px">176 円</div>
                </td>
              </tr>
              <tr>
                <td>3000</td>
                <td>
                  <div class="tt_price" style="font-size:16px">411,000 円</div>
                  <div class="ut_price" style="font-size:16px">137 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">396,000 円</div>
                  <div class="ut_price" style="font-size:16px">132 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">462,000 円</div>
                  <div class="ut_price" style="font-size:16px">154 円</div>
                </td>
              </tr> -->
              <tr>
                <td>50</td>
                <td>
                  <div class="tt_price" style="font-size:16px">36,850 円</div>
                  <div class="ut_price" style="font-size:16px">737 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">35,300 円</div>
                  <div class="ut_price" style="font-size:16px">706 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">31,550 円</div>
                  <div class="ut_price" style="font-size:16px">631 円</div>
                </td>
              </tr>
              <tr>
                <td>100</td>
                <td>
                  <div class="tt_price" style="font-size:16px">55,400 円</div>
                  <div class="ut_price" style="font-size:16px">554 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">52,900 円</div>
                  <div class="ut_price" style="font-size:16px">529 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">45,100 円</div>
                  <div class="ut_price" style="font-size:16px">451 円</div>
                </td>
              </tr>
              <tr>
                <td>300</td>
                <td>
                  <div class="tt_price" style="font-size:16px">104,700 円</div>
                  <div class="ut_price" style="font-size:16px">349 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">93,000 円</div>
                  <div class="ut_price" style="font-size:16px">310 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">83,700 円</div>
                  <div class="ut_price" style="font-size:16px">279 円</div>
                </td>
              </tr>
              <tr>
                <td>500</td>
                <td>
                  <div class="tt_price" style="font-size:16px">145,500 円</div>
                  <div class="ut_price" style="font-size:16px">291 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">124,000 円</div>
                  <div class="ut_price" style="font-size:16px">248 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">115,500 円</div>
                  <div class="ut_price" style="font-size:16px">231 円</div>
                </td>
              </tr>
              <tr>
                <td>1000</td>
                <td>
                  <div class="tt_price" style="font-size:16px">234,000 円</div>
                  <div class="ut_price" style="font-size:16px">234 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">198,000 円</div>
                  <div class="ut_price" style="font-size:16px">198 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">185,000 円</div>
                  <div class="ut_price" style="font-size:16px">185 円</div>
                </td>
              </tr>
              <tr>
                <td>3000</td>
                <td>
                  <div class="tt_price" style="font-size:16px">540,000 円</div>
                  <div class="ut_price" style="font-size:16px">180 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">435,000 円</div>
                  <div class="ut_price" style="font-size:16px">145 円</div>
                </td>
                <td>
                  <div class="tt_price" style="font-size:16px">417,000 円</div>
                  <div class="ut_price" style="font-size:16px">139 円</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div>&nbsp;</div>
        <h3>【データトレース代金について】</h3>
        <p class="new-text">アドビイラストレータの入稿データをお持ちでない場合、当店にてイラストレータファイルに変換するトレース作業を行います。その際、製作料金とは別に2,200円（税込）がかかります。</p>
      </div>

      <h2 id="est-content"><?= lang('ご注文・見積書作成') ?></h2>
      <?php include("campaign_banner.php"); ?>

      <span style="font-size: 12px;">※<?= lang('一つのデザインにつき一注文となります。複数のデザインがある場合、それぞれのデザインで別々にご注文ください。') ?></span>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('フライトタグ（刺繍タグキーホルダー）') ?>】</h3>
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
            <img src="images/flight_tag/ft-part-1.webp" width="135" height="135" id="sample-part-pic" class="picpro" style="display:none">
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
            <input type="text" name="ItemType" id="strap" value="フライトタグ（刺繍タグキーホルダー）" />
          </div>
          <?php
          switch ($ft_type) {
            case '刺繍':
              $ft_type0 = "checked";
              break;
            case 'ジャガード織':
              $ft_type1 = "checked";
              break;
            case '昇華転写':
              $ft_type2 = "checked";
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
              <div class="part-content">
                <label class="part-name">
                  <input type="radio" name="ft_type" value="昇華転写" onclick="check_val('next')" <?= $ft_type2 ?>><?= lang('昇華転写') ?>
                  <span class="checkmark"></span>
                </label>
              </div>
            </div>

            <div class="only_embro">
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
                              <input type="radio" id="1" class="STD_printing_color1" name="ft_fabric_color1" value="108 （赤色）" <?= ($ft_fabric_color1 == '108 （赤色）' ? 'checked' : ($ft_fabric_color1 == '' ? 'checked' : '')) ?>>
                              <label for="1"><img src="images/flight_tag/icon-01.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2" class="STD_printing_color1" name="ft_fabric_color1" value="63 （緑）" <?= ($ft_fabric_color1 == '63 （緑）' ? 'checked' : "") ?>>
                              <label for="2"><img src="images/flight_tag/icon-02.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="3" class="STD_printing_color1" name="ft_fabric_color1" value="83 （紺藍）" <?= ($ft_fabric_color1 == '83 （紺藍）' ? 'checked' : "") ?>>
                              <label for="3"><img src="images/flight_tag/icon-03.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="4" class="STD_printing_color1" name="ft_fabric_color1" value="76 （紅赤）" <?= ($ft_fabric_color1 == '76 （紅赤）' ? 'checked' : "") ?>>
                              <label for="4"><img src="images/flight_tag/icon-04.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="5" class="STD_printing_color1" name="ft_fabric_color1" value="30 （オレンジ色）" <?= ($ft_fabric_color1 == '30 （オレンジ色）' ? 'checked' : "") ?>>
                              <label for="5"><img src="images/flight_tag/icon-05.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="6" class="STD_printing_color1" name="ft_fabric_color1" value="131 （えんじ）" <?= ($ft_fabric_color1 == '131 （えんじ）' ? 'checked' : "") ?>>
                              <label for="6"><img src="images/flight_tag/icon-06.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="7" class="STD_printing_color1" name="ft_fabric_color1" value="78 （藤紫）" <?= ($ft_fabric_color1 == '78 （藤紫）' ? 'checked' : "") ?>>
                              <label for="7"><img src="images/flight_tag/icon-07.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="8" class="STD_printing_color1" name="ft_fabric_color1" value="74 （紫色）" <?= ($ft_fabric_color1 == '74 （紫色）' ? 'checked' : "") ?>>
                              <label for="8"><img src="images/flight_tag/icon-08.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="9" class="STD_printing_color1" name="ft_fabric_color1" value="135 （山吹色） " <?= ($ft_fabric_color1 == '135 （山吹色） ' ? 'checked' : "") ?>>
                              <label for="9"><img src="images/flight_tag/icon-09.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="10" class="STD_printing_color1" name="ft_fabric_color1" value="32 （黄色）" <?= ($ft_fabric_color1 == '32 （黄色）' ? 'checked' : "") ?>>
                              <label for="10"><img src="images/flight_tag/icon-10.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="11" class="STD_printing_color1" name="ft_fabric_color1" value="9 （ピンク）" <?= ($ft_fabric_color1 == '9 （ピンク）' ? 'checked' : "") ?>>
                              <label for="11"><img src="images/flight_tag/icon-11.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="12" class="STD_printing_color1" name="ft_fabric_color1" value="94 （茶色）" <?= ($ft_fabric_color1 == '94 （茶色）' ? 'checked' : "") ?>>
                              <label for="12"><img src="images/flight_tag/icon-12.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="13" class="STD_printing_color1" name="ft_fabric_color1" value="35（黄緑色）" <?= ($ft_fabric_color1 == '35（黄緑色）' ? 'checked' : "") ?>>
                              <label for="13"><img src="images/flight_tag/icon-13.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="14" class="STD_printing_color1" name="ft_fabric_color1" value="66（ビリジアン）" <?= ($ft_fabric_color1 == '66（ビリジアン）' ? 'checked' : "") ?>>
                              <label for="14"><img src="images/flight_tag/icon-14.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="15" class="STD_printing_color1" name="ft_fabric_color1" value="46（スカイブルー）" <?= ($ft_fabric_color1 == '46（スカイブルー）' ? 'checked' : "") ?>>
                              <label for="15"><img src="images/flight_tag/icon-15.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="16" class="STD_printing_color1" name="ft_fabric_color1" value="52（青色）" <?= ($ft_fabric_color1 == '52（青色）' ? 'checked' : "") ?>>
                              <label for="16"><img src="images/flight_tag/icon-16.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="17" class="STD_printing_color1" name="ft_fabric_color1" value="12（牡丹色）" <?= ($ft_fabric_color1 == '12（牡丹色）' ? 'checked' : "") ?>>
                              <label for="17"><img src="images/flight_tag/icon-17.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="18" class="STD_printing_color1" name="ft_fabric_color1" value="129（灰色）" <?= ($ft_fabric_color1 == '129（灰色）' ? 'checked' : "") ?>>
                              <label for="18"><img src="images/flight_tag/icon-18.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="19" class="STD_printing_color1" name="ft_fabric_color1" value="123（黒色）" <?= ($ft_fabric_color1 == '123（黒色）' ? 'checked' : "") ?>>
                              <label for="19"><img src="images/flight_tag/icon-19.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="20" class="STD_printing_color1" name="ft_fabric_color1" value="1（白）" <?= ($ft_fabric_color1 == '1（白）' ? 'checked' : "") ?>>
                              <label for="20"><img src="images/flight_tag/icon-20.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="21" class="STD_printing_color1" name="ft_fabric_color1" value="88（ネイビー）" <?= ($ft_fabric_color1 == '88（ネイビー）' ? 'checked' : "") ?>>
                              <label for="21"><img src="images/flight_tag/icon-21.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="22" class="STD_printing_color1" name="ft_fabric_color1" value="126（ダークブルー）" <?= ($ft_fabric_color1 == '126（ダークブルー）' ? 'checked' : "") ?>>
                              <label for="22"><img src="images/flight_tag/icon-22.webp"></label>
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

              <h3>生地色　裏</h3>
              <div class="part-content preview-container">
                <div class="preview-sub flex-container strap-color">
                  <div class="normal_c">
                    <div class="show_c">
                      <img src="" id="img-show-Insatsu2" class="d-none"><br />
                      <span id="txt-show-Insatsu2" class="d-none"></span>
                    </div>
                    <div class="choose_c">
                      <table>
                        <tbody>
                          <tr>
                            <td>
                              <input type="radio" id="2-1" class="STD_printing_color2" name="ft_fabric_color2" value="108 （赤色）" <?= ($ft_fabric_color2 == '108 （赤色）' ? 'checked' : ($ft_fabric_color2 == '' ? 'checked' : '')) ?>>
                              <label for="2-1"><img src="images/flight_tag/icon-01.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-2" class="STD_printing_color2" name="ft_fabric_color2" value="63 （緑）" <?= ($ft_fabric_color2 == '63 （緑）' ? 'checked' : "") ?>>
                              <label for="2-2"><img src="images/flight_tag/icon-02.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-3" class="STD_printing_color2" name="ft_fabric_color2" value="83 （紺藍）" <?= ($ft_fabric_color2 == '83 （紺藍）' ? 'checked' : "") ?>>
                              <label for="2-3"><img src="images/flight_tag/icon-03.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-4" class="STD_printing_color2" name="ft_fabric_color2" value="76 （紅赤）" <?= ($ft_fabric_color2 == '76 （紅赤）' ? 'checked' : "") ?>>
                              <label for="2-4"><img src="images/flight_tag/icon-04.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="2-5" class="STD_printing_color2" name="ft_fabric_color2" value="30 （オレンジ色）" <?= ($ft_fabric_color2 == '30 （オレンジ色）' ? 'checked' : "") ?>>
                              <label for="2-5"><img src="images/flight_tag/icon-05.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-6" class="STD_printing_color2" name="ft_fabric_color2" value="131 （えんじ）" <?= ($ft_fabric_color2 == '131 （えんじ）' ? 'checked' : "") ?>>
                              <label for="2-6"><img src="images/flight_tag/icon-06.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-7" class="STD_printing_color2" name="ft_fabric_color2" value="78 （藤紫）" <?= ($ft_fabric_color2 == '78 （藤紫）' ? 'checked' : "") ?>>
                              <label for="2-7"><img src="images/flight_tag/icon-07.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-8" class="STD_printing_color2" name="ft_fabric_color2" value="74 （紫色）" <?= ($ft_fabric_color2 == '74 （紫色）' ? 'checked' : "") ?>>
                              <label for="2-8"><img src="images/flight_tag/icon-08.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="2-9" class="STD_printing_color2" name="ft_fabric_color2" value="135 （山吹色） " <?= ($ft_fabric_color2 == '135 （山吹色） ' ? 'checked' : "") ?>>
                              <label for="2-9"><img src="images/flight_tag/icon-09.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-10" class="STD_printing_color2" name="ft_fabric_color2" value="32 （黄色）" <?= ($ft_fabric_color2 == '32 （黄色）' ? 'checked' : "") ?>>
                              <label for="2-10"><img src="images/flight_tag/icon-10.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-11" class="STD_printing_color2" name="ft_fabric_color2" value="9 （ピンク）" <?= ($ft_fabric_color2 == '9 （ピンク）' ? 'checked' : "") ?>>
                              <label for="2-11"><img src="images/flight_tag/icon-11.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-12" class="STD_printing_color2" name="ft_fabric_color2" value="94 （茶色）" <?= ($ft_fabric_color2 == '94 （茶色）' ? 'checked' : "") ?>>
                              <label for="2-12"><img src="images/flight_tag/icon-12.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="2-13" class="STD_printing_color2" name="ft_fabric_color2" value="35（黄緑色）" <?= ($ft_fabric_color2 == '35（黄緑色）' ? 'checked' : "") ?>>
                              <label for="2-13"><img src="images/flight_tag/icon-13.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-14" class="STD_printing_color2" name="ft_fabric_color2" value="66（ビリジアン）" <?= ($ft_fabric_color2 == '66（ビリジアン）' ? 'checked' : "") ?>>
                              <label for="2-14"><img src="images/flight_tag/icon-14.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-15" class="STD_printing_color2" name="ft_fabric_color2" value="46（スカイブルー）" <?= ($ft_fabric_color2 == '46（スカイブルー）' ? 'checked' : "") ?>>
                              <label for="2-15"><img src="images/flight_tag/icon-15.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-16" class="STD_printing_color2" name="ft_fabric_color2" value="52（青色）" <?= ($ft_fabric_color2 == '52（青色）' ? 'checked' : "") ?>>
                              <label for="2-16"><img src="images/flight_tag/icon-16.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="2-17" class="STD_printing_color2" name="ft_fabric_color2" value="12（牡丹色）" <?= ($ft_fabric_color2 == '12（牡丹色）' ? 'checked' : "") ?>>
                              <label for="2-17"><img src="images/flight_tag/icon-17.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-18" class="STD_printing_color2" name="ft_fabric_color2" value="129（灰色）" <?= ($ft_fabric_color2 == '129（灰色）' ? 'checked' : "") ?>>
                              <label for="2-18"><img src="images/flight_tag/icon-18.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-19" class="STD_printing_color2" name="ft_fabric_color2" value="123（黒色）" <?= ($ft_fabric_color2 == '123（黒色）' ? 'checked' : "") ?>>
                              <label for="2-19"><img src="images/flight_tag/icon-19.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-20" class="STD_printing_color2" name="ft_fabric_color2" value="1（白）" <?= ($ft_fabric_color2 == '1（白）' ? 'checked' : "") ?>>
                              <label for="2-20"><img src="images/flight_tag/icon-20.webp"></label>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="radio" id="2-21" class="STD_printing_color2" name="ft_fabric_color2" value="88（ネイビー）" <?= ($ft_fabric_color2 == '88（ネイビー）' ? 'checked' : "") ?>>
                              <label for="2-21"><img src="images/flight_tag/icon-21.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-22" class="STD_printing_color2" name="ft_fabric_color2" value="126（ダークブルー）" <?= ($ft_fabric_color2 == '126（ダークブルー）' ? 'checked' : "") ?>>
                              <label for="2-22"><img src="images/flight_tag/icon-22.webp"></label>
                            </td>
                            <td>
                              <input type="radio" id="2-pantone" class="STD_printing_color2" name="ft_fabric_color2" value="PANTONE/DIC指定" <?= ($ft_fabric_color2 == 'PANTONE/DIC指定' ? 'checked' : "") ?>>
                              <label for="2-pantone">
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

            <h3><?= lang('数量') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" id="qty" onblur="check_val('next')" value="<?= $qty ?>"></label>
                <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?></div>
              </div>
            </div>
          </div>

          <div class="estimate-content" id="step2">
            <h3>アタッチメント</h3>
            <div class="flex-container">
              <div class="preview-container">
                <div class="preview-sub flex-container">
                  <?php
                  include('part_flight_tag.php');
                  $i = 0;
                  for ($i = 0; $i < count($attachment); $i++) {
                    echo '
                  <div class="flex-item">
                  <label class="part-name">
                  <input type="radio" name="part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($part == $attachment[$i]["part_name"] ? 'checked' : ($i == 0 ? 'checked' : '')) . '>
                  <img src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="picpro">
                  <br><span class="part_price_std">+' . ($attachment[$i]["part_price"] * 1.1) . '円</span>
                  </label>
                  </div>';
                  }
                  ?>
                </div>
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
                  </div>データトレース
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
                  </div>OPP個別包装【+@8円（税込）】
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
                      <td class="TableLeft"><?= lang('注文製品タイプ') ?></td>
                      <td class="" id="prd_production" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('仕様タイプ') ?></td>
                      <td class="" id="prd_type" style="text-align: left;"></td>
                    </tr>
                    <tr class="only_embro">
                      <td class="TableLeft"><?= lang('生地色　表') ?></td>
                      <td class="" id="prd_fabric_color1" style="text-align: left;"></td>
                    </tr>
                    <tr class="only_embro">
                      <td class="TableLeft"><?= lang('生地色　裏') ?></td>
                      <td class="" id="prd_fabric_color2" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('数量') ?></td>
                      <td class="" id="prd_amount" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class="" id="prd_part" style="text-align: left;"><?= lang('なし') ?></td>
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
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class=""><input id="prd_trace_price" type="text" name="prd_trace_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('OPP個別包装') ?></td>
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
      <h2 class="toggle-header"><?= lang('フライトタグ（刺繍タグキーホルダー）に関するFAQ') ?><span>+</span></h2>
      <div class="toggle-container">
        <p class="text-orange">1. データ作成方法について教えてください。</p>
        <p class="new-text">お客様ご自身でデータを作成される場合には、テンプレートをご使用ください。もしくは、イメージのデザインデータを弊社へメール送付いただきましたら、デザイン図を作成いたします（有料）。contact@hotmobily.jp 例えば、名刺しかない、昔作った実物しかない、お店の看板の写真しかない場合でも、そのデータを元に製作できる場合がほとんどです。</p>
        <div>&nbsp;</div>
        <p class="text-orange">2. 注文方法、決済方法を教えてください。</p>
        <p class="new-text">決済方法は、銀行振込とクレジットカード決済からお選びいただけます。詳しくは<a href="/guide/payment">こちら</a>をご覧ください。</p>
        <div>&nbsp;</div>
        <p class="text-orange">3. 注文内容のキャンセルや変更はできますか？</p>
        <p class="new-text">【キャンセルについて】</p>
        <p class="new-text">ご注文確定前でしたら、ご注文の取消（キャンセル）が可能です。ご入金が完了している場合、かかった費用を差し引いて、ご指定の銀行口座にご返金致します。ご注文確定後かつ量産開始前の場合は、キャンセル料がかかります。ご注文確定後かつ量産開始後は、誠に申し訳ございませんが、ご注文の取消（キャンセル）をお受けできません。</p>
        <p class="new-text">【変更について】</p>
        <p class="new-text">ご注文確定後でも、量産開始前でしたらご注文内容の変更が可能です。変更内容により、変更に必要な期間、費用が異なります。量産開始後は、誠に申し訳ございませんが、ご注文の変更をお受けできません。詳しくは<a href="/guide/cancel_return">こちら</a>をご覧ください。</p>
        <div>&nbsp;</div>
        <p class="text-orange">4. 仕様に記載のサイズ以外のサイズも製作できますか？</p>
        <p class="new-text">指定サイズ範囲外をご希望の場合は、弊社の営業担当までご相談ください。</p>
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
  <script language="JavaScript" src="/js/calculater_flight_tag_2025_new.js?v=<?php echo date('is') ?>" type="text/javascript"></script>
  <script type="text/javascript" src="<?= $pdf_ftg_js ?>"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/products/js/hand-scroll.js?v=1.01"></script>
  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/products/js/hand-scroll.js?v=1.01"></script>
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
    }, getPartData($('input[name="part"]:checked').val()), chk_color(), check_val(), (tmp != "" ? valid_chk_btn('step3') : ""));

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