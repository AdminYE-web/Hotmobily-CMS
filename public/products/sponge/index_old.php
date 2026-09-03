<?php include_once('../common/SetUpLang.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="キッチンスポンジ, オリジナル, 印刷, 形状, 50個から">
  <meta name="description" content="グッズ・ノベルティ用オリジナル形状、オリジナル印刷のキッチンスポンジが最小50個から作れます。実用性の高い大人気ノベルティです">
  <meta name="robots" content="noindex,nofollow">
  <title>オリジナル印刷、オリジナル形状のキッチンスポンジが50個以上から製作できます。グッズ・ノベルティ用  HOTMOBILYオリジナルグッズ</title>
  <style type="text/css">
    <?= ($_SESSION['lang'] == "kr" ? 'body{font-family: "돋움체",DotumChe,serif!important;}#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}.prodate,.q-detail,.tab-label{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body{font-family: "Prompt", sans-serif!important;}#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}.prodate,.q-detail,.tab-label{font-family: "Prompt", sans-serif!important;}' : '') ?>
  </style>
  <?php include('../../head_products.html'); ?>
  <link href="/products/css/box-shadow.css?v=1.02" rel="stylesheet" type="text/css" />
  <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/products/css/lightbox.css">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <style type="text/css">
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
      visibility: hidden;
    }

    div#line02 {
      width: 12%;
    }

    div#line03 {
      visibility: hidden;
    }

    div#line04 {
      width: 37%
    }

    div#line05 {
      visibility: hidden;
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

    .flex-item-50 {
      width: calc(50% - 2.5px);
      margin-top: 10px;
    }

    #head-banner {
      position: relative;
    }

    #head-banner .head-banner-text {
      position: absolute;
      left: 0;
      bottom: 0;
      color: #fff;
      font-size: 28px;
      line-height: 2.25rem;
      padding: 0 0 20px 20px !important;
      font-weight: 600;
      font-family: IwaUDGoDspPro-Eb, sans-serif !important;
    }

    .hl,
    .hl2 {
      z-index: 1;
      -webkit-background-clip: text;
      background: transparent;
      position: relative;
      display: inline-flex;
    }

    .hl2 {
      -webkit-text-fill-color: red;
      color: red;
    }

    .hl::before {
      -webkit-text-stroke: 4px #000;
      position: absolute;
      top: 0;
      content: attr(data-text);
      color: #000;
    }

    .hl2::before {
      -webkit-text-stroke: 3px #fff;
      color: #fff;
    }

    .hl-text,
    .hl2-text {
      z-index: 1;
      -webkit-background-clip: text;
      -webkit-text-fill-color: #fff;
      background: transparent;
      color: #fff;
    }

    .hl2-text {
      -webkit-text-fill-color: red;
      color: red;
    }

    @media(max-width: 768px) {
      #head-banner .head-banner-text {
        font-size: 22px
      }
    }

    @media(max-width: 640px) {
      #head-banner .head-banner-text {
        font-size: 18px;
        line-height: 1.75rem;
        padding: 0 0 10px 20px !important;
        letter-spacing: 0.2px !important;
      }
    }

    @media(max-width: 576px) {
      #head-banner .head-banner-text {
        font-size: 14px;
      }
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

    @media(max-width: 576px) {
      #head-banner .head-banner-text {
        font-size: 12px;
        line-height: 1.25rem;
        padding-left: 10px !important;
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
  </style>
  <script language="JavaScript" type="text/javascript">
    <!-- Overture K.K. window.ysm_customData = new Object(); window.ysm_customData.conversion = "transId=,currency=,amount="; var ysm_accountid  = "1C8AE9TA2V1IGBU2QBLAVUASHCO"; document.write("<SCR" + "IPT language='JavaScript' type='text/javascript' "  + "SRC=//" + "srv2.wa.marketingsolutions.yahoo.com" + "/script/ScriptServlet" + "?aid=" + ysm_accountid  + "></SCR" + "IPT>"); // 
    -->
  </script>

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
      <?php include('../banner-campaign.php') ?>
      <h1><?= lang('オリジナル印刷、オリジナル形状のキッチンスポンジが50個以上から製作できます。グッズ・ノベルティ用(2025年版)') ?></h1>
      <div style="display: flow-root;">
        <div class="social-time">
          <!-- <span class="social-content">
                        <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0A業界最安・最速のオリジナルラバーストラップの製作。100個34,000円。最短10営業日で製作。同人からイベント、ノベルティまで。%0A%0A詳細はこちら:https://hotmobily.jp/products/rubberstrap/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a>
                        <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0A業界最安・最速のオリジナルラバーストラップの製作。100個34,000円。最短10営業日で製作。同人からイベント、ノベルティまで。%0A%0A詳細はこちら:https://hotmobily.jp/products/rubberstrap/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
                        <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubberstrap%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubberstrap%2f&amp;text=業界最安・最速のオリジナルラバーストラップの製作。100個34,000円。最短10営業日で製作。同人からイベント、ノベルティまで。" target="_blank"><i class="fab fa-twitter-square"></i></a>
                    </span> -->
          <span class="time-content"><?= lang('更新日') ?> 2025年1月29日</span>
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
      <div style="clear:both;">&nbsp;</div>

      <div id="head-banner">
        <img src="images/sponge-headbanner-2.webp" alt="" width="770" height="450">
        <div class="head-banner-text">
          <p>
            <span class="hl" data-text="特徴1：キャラクターやロゴマークのオリジナル形状で製作"><span class="hl-text">特徴1：キャラクターやロゴマークの</span><span class="hl2-text">オリジナル形状</span><span class="hl-text">で製作</span></span>
            <br>
            <span class="hl" data-text="特徴2：未使用2㎜→使用後2cm 使用時はボリューム感あり"><span class="hl-text">特徴2：未使用2㎜→</span><span class="hl2-text">使用後2cm</span>&nbsp;<span class="hl-text">使用時は</span><span class="hl2-text">ボリューム感</span><span class="hl-text">あり</span></span>
            <br>
            <span class="hl" data-text="特徴3：最小50個から、最短10営業日で出荷"><span class="hl-text">特徴3：</span><span class="hl2-text">最小50個</span><span class="hl-text">から、</span><span class="hl2-text">最短10営業日</span><span class="hl-text">で出荷</span></span>
          </p>
        </div>
      </div>

      <div class="flex-container">
        <div class="flex-item-50" style="text-align: center;">
          <p style="text-align: left;">使用前</p>
          <a href="images/sponge-1-587.webp?v=0.2" data-lightbox="a01" style="text-decoration:none;" data-title="">
            <img src="images/sponge-1-380.webp?v=0.2" width="380" height="324">
          </a><br />
          <a href="images/sponge-1-587.webp?v=0.2" data-lightbox="a01-1" style="text-decoration:none;font-size: 10px;float: left;" class="">📷クリックすると拡大します</a>
        </div>
        <div class="flex-item-50" style="text-align: center;">
          <p style="text-align: left;">使用後</p>
          <a href="images/sponge-2-587.webp?v=0.1" data-lightbox="a01" style="text-decoration:none;" data-title="">
            <img src="images/sponge-2-380.webp?v=0.1" width="380" height="324">
          </a><br />
          <a href="images/sponge-1-587.webp?v=0.1" data-lightbox="a01-1" style="text-decoration:none;font-size: 10px;float: left;" class="">📷クリックすると拡大します</a>
        </div>
        <div class="flex-item-50" style="text-align: center;">
          <p style="text-align: left;">天然木パルプ綿素材</p>
          <a href="images/sponge-3-587.webp?v=0.2" data-lightbox="a01" style="text-decoration:none;" data-title="">
            <img src="images/sponge-3-380.webp?v=0.2" width="380" height="324">
          </a><br />
          <a href="images/sponge-3-587.webp?v=0.2" data-lightbox="a01-1" style="text-decoration:none;font-size: 10px;float: left;" class="">📷クリックすると拡大します</a>
        </div>
        <div class="flex-item-50" style="text-align: center;">
          <p style="text-align: left;">吊り下げ用紐付き</p>
          <a href="images/sponge-4-587.webp?v=0.1" data-lightbox="a01" style="text-decoration:none;" data-title="">
            <img src="images/sponge-4-380.webp?v=0.1" width="380" height="324">
          </a><br />
          <a href="images/sponge-3-587.webp?v=0.1" data-lightbox="a01-1" style="text-decoration:none;font-size: 10px;float: left;" class="">📷クリックすると拡大します</a>
        </div>
      </div>

      <h2><?= lang('オリジナルキッチンスポンジとは、どんな製品？') ?></h2>
      <div class="product-detail">
        <div class="product-txt">
          <div class="product-txt-sub"></div>
          <div class="product-txt-sub">
            <h3>吊り下げ紐</h3>
            <p>吊り下げ紐付きで乾燥にも便利。</p>
          </div>
          <div class="product-txt-sub"></div>
        </div>
        <div class="product-img">
          <picture>
            <source media="(max-width:546px)" srcset="images/285_570-left.webp?v=0.1">
            <img class="lazy" data-src="images/210_420-left.webp" width="210" height="420">
          </picture>
          <div class="product-line-group">
            <div class="product-line" id="line01"></div>
            <div class="product-line" id="line02"></div>
            <div class="product-line" id="line03"></div>
          </div>
        </div>
        <div class="product-img">
          <picture>
            <source media="(max-width:546px)" srcset="images/285_570-right.webp?v=0.1">
            <img class="lazy" data-src="images/210_420-right.webp" width="210" height="420">
          </picture>
          <div class="product-line-group" style="grid-template-rows: repeat(4, 1fr); justify-items: end;">
            <div></div>
            <div class="product-line" id="line04"></div>
            <div class="product-line" id="line05"></div>
          </div>
        </div>
        <div class="product-txt" style="align-content: flex-start;">
          <div class="product-txt-sub"></div>
          <div class="product-txt-sub">
            <h3>キャラクターの形状に合わせたダイカット形状</h3>
            <p>配布や発送に便利な薄さです。</p>
          </div>
          <div class="product-txt-sub"></div>
          <div class="product-txt-sub"></div>
        </div>
      </div>
      <div class="product-detail">
        <div class="product-txt">
          <div class="product-txt-sub">
            <h3>使用前厚さ僅か2mm</h3>
            <p>3mmの通常品と、より重厚感のある5mmが選択可。</p>
          </div>
        </div>
        <div class="product-img"><img class="lazy" data-src="images/2mm.webp?v=0.2" width="285" height="100"></div>
        <div class="product-img"><img class="lazy" data-src="images/20mm.webp?v=0.2" width="285" height="100"></div>
        <div class="product-txt">
          <div class="product-txt-sub">
            <h3>厚さ約20mm</h3>
            <p>水に浸すと、日常使いとして十分なボリュームのある厚さになります。</p>
          </div>
        </div>
      </div>
      <hr />

      <h2>製品仕様</h2>
      <table class="table_rubber" cellpadding="5" cellspacing="0">
        <tbody>
          <tr>
            <td>形状</td>
            <td>印刷したいデザインに沿ったオリジナル形状（ダイカット）での製作が可能です。</td>
          </tr>
          <tr>
            <td>大きさ</td>
            <td>約90mm程度までの大きさが一般的です。</td>
          </tr>
          <tr>
            <td>厚さ</td>
            <td>使用時には約20mmの厚さがあります。配送時は圧縮され数ミリです。</td>
          </tr>
          <tr>
            <td>素材</td>
            <td>天然木パルプ綿</td>
          </tr>
          <tr>
            <td>本体色</td>
            <td>白色のみ<br></td>
          </tr>
          <tr>
            <td>印刷方式</td>
            <td>カラー印刷</td>
          </tr>
          <tr>
            <td>表面</td>
            <td>表面はスポンジ上になっていますので、気泡のような穴や凹みがあります。</td>
          </tr>
          <tr>
            <td>包装形態</td>
            <td>製品は圧縮され、個別OPP包装された形で届きます。</td>
          </tr>
          <tr>
            <td>最小ロット</td>
            <td>50個～製作できます。</td>
          </tr>
          <tr>
            <td>付属品</td>
            <td>壁掛け用の紐が付属します。</td>
          </tr>
          <tr>
            <td>その他</td>
            <td>水に含ませると膨張します。厚さは2mm⇒20mm程度。大きさは約10%膨張します。</td>
          </tr>
        </tbody>
      </table>
      <hr>

      <h2>オリジナルキッチンスポンジ料金表</h2>
      <p>製作料金</p>
      <div class="tbl_s">
        <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
          <tr align="center">
            <td colspan="11" bgcolor="#EFEFEF">製品単価</td>
          </tr>
          <tr align="center">
            <td bgcolor="#ffcccc">50個</td>
            <td bgcolor="#ffcccc">100個</td>
            <td bgcolor="#ffcccc">300個</td>
            <td bgcolor="#ffcccc">500個</td>
            <td bgcolor="#ffcccc">1,000個</td>
            <td bgcolor="#ffcccc">3,000個</td>
          </tr>
          <tr align="center">
            <td>￥359円</td>
            <td>￥306円</td>
            <td>￥244円</td>
            <td>￥224円</td>
            <td>￥182円</td>
            <td>￥146円</td>
          </tr>
        </table>
      </div>
      <table width="600" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
        <tr>
          <td align="left">
            <p><strong>
                ※単価は全て税込です。<br>
                ※ご指定1拠点への配送料金を含みます。<br>
                ※ご注文確定後の実物校正サンプル代を含みます。校正サンプル不要の場合でも単価は変わりません。
              </strong></p>
          </td>
        </tr>
      </table>
      <hr>

      <h2>納期（製作期間）</h2>
      <div style="clear: both;"></div>
      <!-- <div id="info_div"></div> -->
      <?php include('../../delivery_note.php'); ?>
      <p>
        納期=製作日数+配送日数で計算致します。<br><br>
        【製作期間】<br>
        単位：営業日。配送日数は含まず
      </p>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr align="center">
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">300個以下 </td>
          <td align="center">1,000個以下</td>
          <td align="center">～3,000個</td>
        </tr>
        <tr>
          <td>試作品製作日数</td>
          <td align="center">7</td>
          <td align="center">7</td>
          <td align="center">7</td>
        </tr>
        <tr>
          <td>量産品製作日数</td>
          <td align="center">10</td>
          <td align="center">11</td>
          <td align="center">12</td>
        </tr>
      </table>
      <table width="600" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
        <tr>
          <td align="right">
            <p><strong>
                営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。<br>
                製品生産国中国の長期休暇につきましては、別途定める休日が指定されます。
              </strong></p>
          </td>
        </tr>
      </table>
      <hr>
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
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../../footer.php'); ?>
  <!--フッター ここまで-->
  <script src="/products/js/lightbox.js"></script>
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.1"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript">
    $(function() {
      var s = $("#i_txt2");
      screen.width <= 768 && (s.attr("src", "images/text_sample_n1.svg"))
    });
    lightbox.option({
      'maxWidth': 800,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    });
    $(function() {
      $('#info_div').load('/info/index.php');
    });
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "オリジナルキッチンスポンジ"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });
  </script>
</body>

</html>