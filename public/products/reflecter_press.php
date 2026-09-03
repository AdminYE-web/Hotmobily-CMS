<?php

include_once('../common/SetUpLang.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="<?= lang('リフレクター,交通安全,キーホルダー,オリジナル,反射') ?>">
  <meta name="description" content="<?= lang('オリジナル形状のリフレクター(反射)キーホルダーの製作。交通安全グッズに最適。100個から。') ?>">
  <meta name="robots" content="index,follow">
  <title><?= lang('オリジナル形状のリフレクター(反射)キーホルダーの製作。交通安全グッズに最適') ?></title>
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.02" rel="stylesheet" type="text/css" />
  <link href="/products/css/product_group.css?v=1.08" rel="stylesheet" type="text/css">
  <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <?php include('../head_products.html'); ?>
  <script language="JavaScript" type="text/javascript">
    <!-- Overture K.K. window.ysm_customData = new Object(); window.ysm_customData.conversion = "transId=,currency=,amount="; var ysm_accountid  = "1C8AE9TA2V1IGBU2QBLAVUASHCO"; document.write("<SCR" + "IPT language='JavaScript' type='text/javascript' "  + "SRC=//" + "srv2.wa.marketingsolutions.yahoo.com" + "/script/ScriptServlet" + "?aid=" + ysm_accountid  + "></SCR" + "IPT>"); // 
    -->
  </script>
  <script>
    $(document).ready(function() {
      $("#open1").click(function() {
        $("#slide1").slideToggle("slow");
      });
    });
  </script>
  <!-- lightbox2-master -->
  <link rel="stylesheet" href="css/lightbox.css">
  <link href="responsive.css" rel="stylesheet" type="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <!-- /lightbox2-master -->
  <style type="text/css">
    .picpro {
      width: 93%
    }

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }

    .handle {
      position: absolute;
      width: 20px;
      height: 20px;
      color: orange;
      z-index: 1111;
      border-radius: 50%;
      box-shadow: inset 0 0 0 10px;
      opacity: .8;
      -webkit-transition: opacity .25s;
      transition: opacity .25s;
      cursor: -webkit-grab;
      cursor: -moz-grab;
      cursor: grab
    }

    .handle:hover {
      opacity: .8
    }

    .handle:after {
      display: block;
      content: "";
      position: absolute;
      top: -8px;
      left: -8px;
      right: -8px;
      bottom: -8px
    }

    #left {
      width: 350px;
      height: 350px;
      float: left;
      position: relative
    }

    #right {
      width: 350px;
      height: 350px;
      float: right;
      position: relative
    }

    .tb_color tr:nth-child(5) td {
      padding: 0 !important
    }

    .tb_color tr:nth-child(5) td img {
      width: 100%
    }

    .d_TEXT1 {
      margin-left: 0;
      margin-right: 0
    }

    .exc_pro {
      padding-bottom: 120px;
      max-height: 200px
    }

    .tbl_s .tb-w12 tr td {
      width: 9%
    }

    @media screen and (max-width: 1024px) {
      .handle {
        display: none
      }

      #left,
      #right {
        width: auto;
        height: auto;
        margin-bottom: 350px;
        display: block;
        float: unset;
        position: inherit
      }

      .table_img {
        margin-top: 350px
      }

      .exc_pro {
        max-height: unset;
        padding-bottom: 0
      }

      .swiper-container {
        padding-bottom: 0
      }

      .picpro {
        width: 90%
      }
    }

    .tb_color {
      width: 99.8%;
      border-collapse: collapse;
      margin-top: 10px;
      box-shadow: 1px 1px 5px #d3d3d3
    }

    <?= ($_SESSION['lang'] == "kr" ? 'body,#content_wrapper,h1,h2,h3,.prodate,.q-detail,.tab-label,#wrapper #content_wrapper ul,.taizen_b_txt,.blit_nums{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body,#content_wrapper,h1,h2,h3,.prodate,.q-detail,.tab-label,#wrapper #content_wrapper ul,.taizen_b_txt,.blit_nums{font-family: "Prompt", sans-serif!important;}' : '') ?>

    /*new css*/
    .image_flex {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .image_flex img {
      width: calc(50% - 5px);
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

    <?php include('../sidenavi.php'); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
      <?php include('../global_news.html'); ?>
      <?php include('../campaign_2021.php'); ?>
      <h1><?= lang('オリジナルリフレクター(反射)キーホルダーの製作 (2026年版)') ?></h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=オリジナルリフレクター(反射)キーホルダーの製作&amp;body=オリジナル形状のリフレクター(反射)キーホルダーの製作。交通安全グッズに最適。100個から。:https://hotmobily.jp/products/reflecter_press.php" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a><a href="mailto:?subject=オリジナルリフレクター(反射)キーホルダーの製作&amp;body=オリジナル形状のリフレクター(反射)キーホルダーの製作。交通安全グッズに最適。100個から。:https://hotmobily.jp/products/reflecter_press.php" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2freflecter%5Fpress.php" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2freflecter%5Fpress.php&amp;text=オリジナル形状のリフレクター(反射)キーホルダーの製作。交通安全グッズに最適。100個から。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content"><?= lang('更新日') ?> 2026<?= lang('年') ?>7<?= lang('月') ?>6<?= lang('日') ?></span>
      </div>

      <img src="images/banner-reflector-press-2024.webp">
      <p>&nbsp;</p>
      <h2><?= lang('リフレクターチャーム（反射チャーム）とは') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('車のライトなどの光を反射して、暗いなかでも明るく光るリフレクターチャーム（反射チャーム）です。')?><br/><br/>

        <?= lang('アクセサリーとしてだけでなく、光を反射して持ち主の存在を知らせる実用的な機能があります。') ?><br/><br/>

        <?= lang('当店ではオリジナル形状のリフレクターチャーム制作が可能です。') ?>
      </p>
      <table width="100%" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td><img src="img/reflecter_pressimg06.webp" alt="" width="176" height="130" /></td>
          <td><img src="img/reflecter_pressimg07.webp" alt="" width="176" height="130" /></td>
          <td><img src="img/reflecter_pressimg08.webp" alt="" width="176" height="130" /></td>
          <td><img src="img/reflecter_pressimg09.webp" alt="" width="176" height="130" /></td>
        </tr>
        <tr>
          <td width="25%"><img src="img/reflecter_pressimg01.webp" alt="" width="176" height="130" /></td>
          <td width="25%"><img src="img/reflecter_pressimg02.webp" alt="" width="176" height="130" /></td>
          <td width="25%"><img src="img/reflecter_pressimg03.webp" alt="" width="176" height="130" /></td>
          <td width="25%"><img src="img/reflecter_pressimg04.webp" alt="" width="176" height="130" /></td>
        </tr>
        <tr>
          <td><img src="img/reflecter_pressimg05.webp" alt="" width="176" height="130" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <hr>
      <h2><?= lang('当店のリフレクターチャーム（反射チャーム）の特長') ?></h2>
      <ul class="new-text">
        <li><?= lang('オリジナルデザインで作製出来ますのでテーマパーク、動物園、水族館などのグッズやお土産品としてもご利用頂けます。') ?></li>
        <li><?= lang('当店の反射シートには住友３Ｍ社製のスコッチライトを使用しています。※詳細は下記<a href="#s3m">住友3M社のスコッチライトについて</a>をご覧下さい。') ?></li>
        <li><?= lang('最小ロット100個から作成出来ます。') ?></li>
      </ul>
      <hr>
      <div id="pro1" style="margin-top: 10px;">
        <img class="lazy" data-src="img/reflec_b3_3M.webp" alt="" width="185" height="123">
        <img class="lazy" data-src="img/reflec_b2.webp" alt="" width="185" height="123">
      </div>
      <div id="pro2" style="margin-top: 10px;">
        <img class="lazy" data-src="img/reflec_b3_new.webp?v=1.01" alt="" width="185" height="123">
        <img class="lazy" data-src="img/reflec_b4.webp" alt="" width="185" height="123">
      </div>
      <div style="clear:both;"></div>
      <h2><?= lang('製作事例紹介') ?></h2><br />
      <div class="ex-row">
        <div class="swiper-button-prev"></div>
        <div class="swiper-container swiper2">
          <div class="swiper-wrapper swiper-bt">
            <div class="swiper-slide">
              <a href="img/reflecter_press1.webp" data-lightbox="reflecter_press_set01" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press1.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press1_1.webp" data-lightbox="reflecter_press_set01" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press1_2.webp" data-lightbox="reflecter_press_set01" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press1_3.webp" data-lightbox="reflecter_press_set01" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press4.webp" data-lightbox="reflecter_press_set04" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press4.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press4_1.webp" data-lightbox="reflecter_press_set04" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press4_2.webp" data-lightbox="reflecter_press_set04" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press4_3.webp" data-lightbox="reflecter_press_set04" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press2.webp" data-lightbox="reflecter_press_set02" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press2.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press2_1.webp" data-lightbox="reflecter_press_set02" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press2_2.webp" data-lightbox="reflecter_press_set02" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press2_3.webp" data-lightbox="reflecter_press_set02" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press3.webp" data-lightbox="reflecter_press_set03" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press3.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press3_1.webp" data-lightbox="reflecter_press_set03" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press3_2.webp" data-lightbox="reflecter_press_set03" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press3_3.webp" data-lightbox="reflecter_press_set03" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press5.webp" data-lightbox="reflecter_press_set05" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press5.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press5_1.webp" data-lightbox="reflecter_press_set05" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press5_2.webp" data-lightbox="reflecter_press_set05" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press5_3.webp" data-lightbox="reflecter_press_set05" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press6.webp" data-lightbox="reflecter_press_set06" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press6.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press6_1.webp" data-lightbox="reflecter_press_set06" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press6_2.webp" data-lightbox="reflecter_press_set06" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press6_3.webp" data-lightbox="reflecter_press_set06" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press7.webp" data-lightbox="reflecter_press_set07" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press7.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press7_1.webp" data-lightbox="reflecter_press_set07" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press7_2.webp" data-lightbox="reflecter_press_set07" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press7_3.webp" data-lightbox="reflecter_press_set07" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press8.webp" data-lightbox="reflecter_press_set08" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press8.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press8_1.webp" data-lightbox="reflecter_press_set08" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press8_2.webp" data-lightbox="reflecter_press_set08" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press8_3.webp" data-lightbox="reflecter_press_set08" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press9.webp" data-lightbox="reflecter_press_set09" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press9.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press9_1.webp" data-lightbox="reflecter_press_set09" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press9_2.webp" data-lightbox="reflecter_press_set09" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press9_3.webp" data-lightbox="reflecter_press_set09" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press10.webp" data-lightbox="reflecter_press_set10" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press10.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press10_1.webp" data-lightbox="reflecter_press_set10" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press10_2.webp" data-lightbox="reflecter_press_set10" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press10_3.webp" data-lightbox="reflecter_press_set10" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press11.webp" data-lightbox="reflecter_press_set11" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press11.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press11_1.webp" data-lightbox="reflecter_press_set11" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press11_2.webp" data-lightbox="reflecter_press_set11" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press11_3.webp" data-lightbox="reflecter_press_set11" data-title="2020年6月24日掲載"></a>
            </div>
            <div class="swiper-slide">
              <a href="img/reflecter_press12.webp" data-lightbox="reflecter_press_set12" style="text-decoration:none;" data-title="2020年6月24日掲載">
                <img data-src="img/reflecter_press12.webp" class="picpro lazy" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="img/reflecter_press12_1.webp" data-lightbox="reflecter_press_set12" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press12_2.webp" data-lightbox="reflecter_press_set12" data-title="2020年6月24日掲載"></a>
              <a href="img/reflecter_press12_3.webp" data-lightbox="reflecter_press_set12" data-title="2020年6月24日掲載"></a>
            </div>
          </div>
        </div>
        <div class="swiper-button-next"></div>
      </div>

      <hr>
      
      <table class="cld_tb" style="width:99%">
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

      
      <h2><?= lang('ご注文方法') ?></h2>
      <?php include('campaign_banner.php') ?>
      <p class="d_TEXT1 new-text">
        <?= lang('圧着リフレクターチャームのご注文は、下記1.～3.のご注文内容を<a href="/contact/index.php">お問い合わせフォーム</a>より弊社までお送り頂きます。') ?></p>

      <h3><span class="blit_nums"><?= lang('1. デザインのご入稿') ?></span></h3>
      <p class="d_TEXT1 new-text">
        <?= lang('製作されるデザインのご入稿をお願い致します。デザインはアドビイラストレータファイルでお送り頂くと、最も速く確認作業が完了します。PSDやJPEG、pdfなどイラストレータファイル以外の場合、製品の大きさの情報も記載してください。') ?><br><br>
        <span class="blit_nums"><?= lang('リフレクターチャーム（反射チャーム）の製作イメージ') ?></span><br />
        <?= lang('リフレクターチャーム（反射チャーム）はデザインの輪郭線のみを表現する製品となります。線幅は0.4mm以上必要になります。また、線と線の間隔にも0.4mm以上スペースが必要です。') ?><br>
        <img class="lazy" data-src="img/reflecter02.webp" width="554" height="166"><br>
        <font color="#f00"><?= lang('※図の赤線部分は、PVCカラーシートで反射しません。PVCカラーシート部分が多いと、反射効率が低下しますので、ご注意ください。') ?></font>
      </p>
      <div style="text-align: center;"><img class="lazy" data-src="img/reflecter_press.webp" width="770" height="194" style="max-width: 100%;"></div>
      <h3><span class="blit_nums"><?= lang('2. カラーシートの選択（PVC製）') ?></span></h3>
      <p class="d_TEXT1 new-text">
        <?= lang('デザインの輪郭線を表現するカラーシートの色を全18色の中から選択します。1色につき100個以上から色の組み合わせが可能です。例：注文個数１,000個 色の内訳（青700個 赤100個 黄色200個）') ?>
      </p>
      <table border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" class="tb-w12 tb_color">
        <!-- Row 1 -->
        <tr align="center">
          <td style="background: #fff;">001<?= lang('白') ?></td>
          <td style="background: #fff;">003<?= lang('青') ?></td>
          <td style="background: #fff;">004<?= lang('黄') ?></td>
          <td style="background: #fff;">005<?= lang('緑') ?></td>
          <td style="background: #fff;">007<?= lang('オレンジ') ?></td>
        </tr>
        <tr align="center">
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
        </tr>
        <tr align="center" valign="middle">
          <td style="background: #fff;"><img class="lazy" data-src="img/reflecter_color3n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color4n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color5n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color6n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color7n.webp" width="140" height="140"></td>
        </tr>
      </table>
      <table border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" class="tb-w12 tb_color">
        <!-- Row 2 -->
        <tr align="center">
          <td style="background: #fff;">008<?= lang('赤') ?></td>
          <td style="background: #fff;">011<?= lang('黒') ?></td>
          <td style="background: #fff;">013<?= lang('ピンク') ?></td>
          <td style="background: #fff;">017<?= lang('黄') ?></td>
          <td style="background: #fff;">018<?= lang('黄土') ?></td>
        </tr>
        <tr align="center">
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
        </tr>
        <tr align="center" valign="middle">
          <td style="background: #fff;"><img class="lazy" data-src="img/reflecter_color8n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color9n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color10n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color11n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color12n.webp" width="140" height="140"></td>
        </tr>
      </table>
      <table border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" class="tb-w12 tb_color">
        <!-- Row 3 -->
        <tr align="center">
          <td style="background: #fff;">020<?= lang('藤紫') ?></td>
          <td style="background: #fff;">021<?= lang('薄青') ?></td>
          <td style="background: #fff;">023<?= lang('水色') ?></td>
          <td style="background: #fff;">024<?= lang('黄') ?></td>
          <td style="background: #fff;">029<?= lang('赤オレンジ') ?></td>
        </tr>
        <tr align="center">
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
        </tr>
        <tr align="center" valign="middle">
          <td style="background: #fff;"><img class="lazy" data-src="img/reflecter_color13n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color14n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color15n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color16n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color17n.webp" width="140" height="140"></td>
        </tr>
      </table>
      <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" class="tb-w12 tb_color" style="width: 60%;">
        <!-- Row 4 -->
        <tr align="center">
          <td style="background: #fff;">033<?= lang('深青') ?></td>
          <td style="background: #fff;">034<?= lang('黄緑') ?></td>
          <td style="background: #fff;">039<?= lang('紫') ?></td>
        </tr>
        <tr align="center">
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
          <td style="background: #f0f0f0;"><?= lang('通常時') ?></td>
        </tr>
        <tr align="center" valign="middle">
          <td style="background: #fff;"><img class="lazy" data-src="img/reflecter_color18n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color19n.webp" width="140" height="140"></td>
          <td><img class="lazy" data-src="img/reflecter_color20n.webp" width="140" height="140"></td>
        </tr>
      </table><br />
      <h3><span class="blit_nums"><?= lang('3. アタッチメント') ?></span></h3>
      <p class="d_TEXT1 new-text">
        <?= lang('リフレクターチャーム（反射チャーム）のアタッチメントはボールチェーンが標準装備となります。<br>※ご希望がございましたら、キーリング（黒リングのみ不可）や松葉への変更も可能です。') ?>
      </p>

      <table width="100%" border="0" cellspacing="1" cellpadding="0" style="margin-top:0px;">
        <tbody>
          <tr>
            <td valign="top" class="d_TEXT1" align="center"><a data-lightbox="reflec_m-set" style="text-decoration:none;" href="img/denwa3_b.webp"><img class="lazy" data-src="img/denwa3.webp" width="175" height="145" />
                <div style="text-decoration:none; font-size: 10px;text-align: left;">📷<?= lang('クリックすると拡大します') ?></div>
              </a></td>
            <td align="center"><a data-lightbox="reflec_m-set" style="text-decoration:none;" href="img/denwa2_b.webp"><img class="lazy" data-src="img/denwa2.webp" width="195" height="145" />
                <div style="text-decoration:none; font-size: 10px;text-align: left;">📷<?= lang('クリックすると拡大します') ?></div>
              </a></td>
            <td align="center"><a data-lightbox="reflec_m-set" style="text-decoration:none;" href="img/denwa1_b.webp"><img class="lazy" data-src="img/denwa1.webp" width="195" height="145" />
                <div style="text-decoration:none; font-size: 10px;text-align: left;">📷<?= lang('クリックすると拡大します') ?></div>
              </a></td>
          </tr>
        </tbody>
      </table>
      <p><?= lang('標準装備のボールチェーン（左）／松葉にはスマートフォン用差込プラグを取り付ける事が出来ます。＜スマートフォン用プラグ　11円/個＞（中央、右）') ?><br>
      </p>
      <hr>
      <h2><?= lang('デザインの注意点') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('リフレクターチャーム（反射チャーム）は2枚の反射シートと色つきのカラーシート（PVC製）を張り合わせて作製します。製品の中央部はプニプニとした柔らかい手触りですが、デザインに鋭角部分がございますと、その部分は非常に硬くなります。一般的なご利用であれば問題ございませんが、小さいお子様への配布をご検討されております場合は、デザイン作成の段階でご相談下さい。弊社にて製品全体にある程度の丸みを持たせたデザインに修正させて頂きます。') ?>
      </p>
      <table width="208" border="0" cellpadding="0" cellspacing="4">
        <tr align="center">
          <td width="200" class="d_TEXT1"><img class="lazy" data-src="img/reflecter04.webp" width="460" height="133" />
          </td>
        </tr>
      </table>
      <hr>
    
      <div id="pricing" style="clear: both;"></div>

      <h2><?= lang('製品サイズの認識') ?></h2>
      <table width="100%" border="0" align="center" cellpadding="0">
        <tr>
          <td width="60%" valign="top">
            <p class="d_TEXT1 new-text">
              <?= lang('製品サイズは縦70mm以内、横70mm以内、にてデザインして下さい。右図のように70mm×70mmの正方形内にデザインを収めるという認識ではございませんのでご注意下さい。') ?></p>
          </td>
          <td width="40%"><img class="lazy" data-src="img/reflecter_press_size.webp" width="300" height="240" /></td>
        </tr>
      </table>

      <?php include("campaign_news.php"); ?>
      <hr>

      <h2><?= lang('製作料金') ?></h2>
      <div class="tbl_s">
        <table width="710" border="0" cellspacing="2" cellpadding="0">
          <tr valign="top" class="process">
            <td colspan="2">
              <p class="new-text"><?= lang('下記、製作料金一覧の製品単価には製品版型代金、製品配送代金、試作品配送1回、が含まれております。最小ロット100個から製作出来ます。') ?></p>
            </td>
          </tr>
        </table>
        <table width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" class="tb-w12" style="border-collapse:collapse;margin-top: 10px;text-align: center;">
          <tr>
            <td style="width: 18%;"><?= lang('製品サイズ／個数') ?></td>
            <td style="color: red;">100<?= lang('個') ?></td>
            <td style="color: red;">200<?= lang('個') ?></td>
            <td>300<?= lang('個') ?></td>
            <td>500<?= lang('個') ?></td>
            <td>1,000<?= lang('個') ?></td>
            <td>2,000<?= lang('個') ?></td>
            <td>3,000<?= lang('個') ?></td>
            <td>5,000<?= lang('個') ?></td>
            <td>10,000<?= lang('個') ?></td>
          </tr>
          <tr>
            <td align="center">70mm×70mm<?= lang('以内') ?> </td>
            <td style="color: red;">541円</td>
            <td style="color: red;">433円</td>
            <td>326円</td>
            <td>249円</td>
            <td>185円</td>
            <td>158円</td>
            <td>132円</td>
            <td>109円</td>
            <td>91円</td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="2" cellpadding="0" class="">
          <tbody class="">
            <tr valign="top" class="process">
              <td colspan="2" class="new-text">
                <font><?= lang('※上記価格は税込み価格です。<br />※製品サイズが70mm×70mmを超えるデザインは別途お見積をさせて頂きます。') ?></font>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr valign="top" class="process new-text">
          <td colspan="2">
            <p>●　裏面印刷（単色・カラー共通）</p>
          </td>
        </tr>
        <tr valign="top" class="process new-text">
          <td colspan="2">
            <p>製品の裏面に印刷を入れる事も出来ます。@36円（税込）増しです。</p>
          </td>
        </tr>
      </table>
      <div class="image_flex">
        <img src="/products/images/reflecter_press_100_20220407.webp" width="380" height="192">
        <img src="/products/images/reflecter_press_200_20220407.webp" width="380" height="192">
      </div>
      <hr>
      <h2><?= lang('納期') ?></h2>
      <?php include('../delivery_note.php'); ?>
      <div>
        <p class="d_TEXT1 new-text">
          <?= lang('量産品：3,000個程度までは製作開始より10営業日にて出荷致します。<br>試作品：製作開始より9営業日にて出荷致します。') ?>
        </p>
      </div>
      <div style="clear:both;"></div>
      <dl id="strap_option">
      </dl>
      <hr>
      <h2><a name="s3m" id="s3m"></a><?= lang('住友3M社のスコッチライト') ?>
      </h2>
      <p class="d_TEXT1 new-text">
        <?= lang('スコッチライトは、入射光を光源の方向にまっすぐ戻す「再帰性反射」を実現した高機能素材です。車のヘッドライトなどの光を効率的に反射し、夜でも明るく輝いて見えるすぐれた特性を備えています。危険の多い夜間、屋外で働く作業員のユニフォームなどの安全性向上に視認性のすぐれた反射材として活躍しています。<br>※一部の文章は住友3M社のホームページより引用しています。') ?>
      </p>
      <hr>

      <?php include('part-daishi-lang-v2.php'); ?>
      <hr>
      <h2><?= lang('特大サイズ対応') ?></h2>
      <div style="text-align:center;">
        <a href="img/Jumbo-size4.webp" data-lightbox="reflecter-jumbo" style="text-decoration:none;">
          <img class="lazy" data-src="img/Jumbo-size4.webp" width="100%" height="508" style="max-width: 720px;">
        </a>
      </div>
      <a href="img/Jumbo-size4.webp" data-lightbox="reflecter-jumbo1" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
      <div>&nbsp;</div>
      <p class="new-text"><?= lang('製品サイズ300mm程度ジャンボサイズもご提案出来ます。ご希望のお客様は営業担当までご連絡ください。') ?></p>
      <div style="clear:both;"></div>

      <hr>
      <h2><?= lang('圧着リフレクターのサンプル') ?></h2>
      <a href="/contact/?item=リフレクターチャーム（圧着タイプ）"><img class="lazy" data-src="img/banner_cont3.webp" width="100%" height="82"></a><br /><br />
      <hr>

      <?php 
        $favor = 'reflecter';
        if (isset($favor) && $favor) {
            include 'product-faq-v2.php';
        }
      ?>

      <hr>
      <?php include('rubber_blogs.php'); ?>
      <h2><?= lang('営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('当店では担当の営業マンが直接製品やサービスのご提案・ご説明をさせて頂けます。WEBサイトだけではなかなかイメージが掴めない。価格も含めて相談したい。このようなご要望がございましたら是非お声掛け下さい。営業担当が実際にサンプル品をもって御社にお伺いし詳しく説明させて頂きます。ご希望のお客様はお手数ですが、バナーをクリックして頂き必要事項をご入力ください。お伺いできるエリアは東京都内もしくは近郊に限ります。事情によりお伺いできない場合もございますので、ご了承ください。') ?>
        <center><a href="//hotmobily.jp/meeting_date/"><img class="lazy" data-src="../img/btn_meetingdate_1.svg" title="ノベルティー営業担当呼び出しフォーム" width="771" height="82" /></a></center>
      </p>

      <hr>
      <h2 style="margin-top:-10px;"><br>
        <?= lang('その他リフレクターチャーム') ?></h2>
      <table width="750" border="0" cellspacing="1" cellpadding="0" style="margin-top:0px;">
        <tr>
          <td valign="top" class="d_TEXT1" align="center"><a href="reflecter_print.php"><img class="lazy" data-src="img/rft_banner_print_01.webp" alt="" width="162" height="107" /></a></td>
          <td align="center"><a href="reflecter_hard.html"><img class="lazy" data-src="img/rft_banner_hard_01.webp" alt="" width="162" height="107" /></a></td>
          <td align="center"><a href="reflecter_wristband.html"><img class="lazy" data-src="img/rft_banner_wristband_01.webp" alt="" width="162" height="107" /></a></td>
          <td align="center"><a href="reflecter_sticker.html"><img class="lazy" data-src="img/rft_banner_sticker_01.webp" alt="" width="162" height="107" /></a></td>
        </tr>
      </table>
      <br />
      <img class="lazy" data-src="images/text_sample.svg" width="100%" height="620" id="i_txt2">
      <hr>
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../footer.php'); ?>
  <!--フッター ここまで-->
  <script src="js/lightbox.js"></script>
  <script src="/js/swiper.min.js"></script>
  <script>
    lightbox.option({
      'maxWidth': 750,
      'maxHeight': 750,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <!-- /lightbox2-master -->
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.1"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript">
    $(function() {
      var s = $("#i_txt2");
      screen.width <= 768 && (s.attr("src", "images/text_sample_n1.svg"))

        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get("tab");

        if (tab != "" && tab !== undefined && tab === "price") {
            window.scrollTo(0, $("#pricing").offset().top);
        }
    });
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "圧着リフレクター"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });
  </script>
  <script type="text/javascript">
    $(function() {
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
  </script>
</body>

</html>