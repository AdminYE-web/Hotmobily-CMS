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
include("../../connect_db/Control_Connect.php");
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
  if ($msMode != "MODE_CART") {
    unset($_SESSION['index']);
    ClearSessionPrice();
  }
}
// エラー出力用
$mrErrMsgList = array();
$msErrFocusCtl = "";

//メイン関数の呼出
Main();

$data1 = mysqli_query($conn, "SELECT COUNT(id) AS totalreview FROM reviews_hm") or die(mysqli_error());
$info1 = mysqli_fetch_assoc($data1);

$data2 = mysqli_query($conn, "SELECT AVG(service) AS avg_service, AVG(product) AS avg_product FROM reviews_hm") or die(mysqli_error());
$info2 = mysqli_fetch_assoc($data2);

$japanNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Tokyo'));
$planDisableStart = new DateTimeImmutable('2026-08-13 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisableEnd = new DateTimeImmutable('2026-08-17 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisabled = ($japanNow >= $planDisableStart && $japanNow < $planDisableEnd) ? 'disabled' : '';

// 1. Define or retrieve your dynamic product variables here
// *************************************************************
// REPLACE these placeholder values with your actual PHP variables
// that hold the product data from your database or CMS.
// *************************************************************
$product_name = "【ホットモバイリー】オリジナルアクリルスマホスタンド";
$product_description = "オリジナルアクリルスマホスタンドをオーダーメイドで製作。最短6営業日で出荷可能。小ロット1個から製作できます。最安単価876円。実用性にも優れキャラクターグッズやノベルティに最適";
$product_image_url = "https://hotmobily.jp/products/acrylic/img/acyl-stand1.webp";
$product_sku = "HM-ASS-2024";
$product_price = 876;
$product_currency = "JPY";
$product_availability = "InStock";
$product_url = "https://hotmobily.jp/products/acrylic/stand";

// 2. Build the Product Schema array in PHP
$schema_array = [
    '@context' => 'https://schema.org/',
    '@type' => 'Product',
    // Product Details
    'name' => $product_name,
    'description' => $product_description,
    'sku' => $product_sku,
    'url' => $product_url,
    'image' => $product_image_url,
    'brand' => [
        '@type' => 'Brand',
        'name' => 'HotMobily', // Your brand name
    ],

    // Offer Details (Required for price/availability snippets)
    'offers' => [
        '@type' => 'Offer',
        'url' => $product_url,
        // availability must use the full schema.org URL
        'availability' => 'https://schema.org/' . $product_availability,
        'priceCurrency' => $product_currency,
        'price' => $product_price,
        "priceValidUntil" => "2026-12-31",
    ],

    "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => number_format($info2['avg_product'], 1),
        "reviewCount" => $info1['totalreview']
    ],

    'review' => [
        '@type' => 'Review',
        "name" => "当店ラバーストラップのレビュー",
        "author" => [
            "@type" => "Person",
            "name" => "Anonymous"
        ],
        'positiveNotes' => [
            '@type' => 'ItemList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => '対応が丁寧で不安なく作れて感謝しています。 年末のせいか制作にやや時間がかかったのが少し気になりましたが、それ以外は完璧でした。 またよろしくお願いします。',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => '発色が一番好みだったのと、裏面保護があるのがいいと思いました。 もう少し小さくしても印刷が衰えないならアクキーもそのうち作りたいです。',
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => 'いつもお世話になっております。 制作前のやり取り、納期、仕上り、梱包状態、そして細部にわたる製品のクオリティ全てに満足しております。',
                ],
            ],
        ],
    ]

];


// 3. Convert the PHP array to a JSON string.
// Use JSON_UNESCAPED_UNICODE to ensure Japanese characters are handled correctly.
$json_ld_output = json_encode($schema_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="<?= lang('アクリルスマホスタンド,オリジナル,名入れ,製作,作成,1個から') ?>">
  <meta name="description" content="<?= lang('オリジナルのアクリルスマホスタンド（モバイルスタンド）が1個から注文可。剥がれない印刷。丈夫なアクスタ。激安価格で、小ロット、短納期を実現') ?>">
  <meta name="robots" content="index,follow">
  <title><?= lang('アクリルスマホスタンド（モバイルスタンド）の製作。1個から注文可。保護フィルムで、印刷が剥がれません。') ?></title>
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <?php include('../../head_products.html'); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <link href="/products/css/product_group.css?v=1.11" rel="stylesheet" type="text/css" />
  <link href="css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.10" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="ptw/photoswipe.css">
  <link rel="stylesheet" href="ptw/default-skin.css">
  <link href="/products/acrylic/css/hand-scroll.css?v=1.00" rel="stylesheet" type="text/css">
  <link href="/products/css/calendar.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css" rel="stylesheet" type="text/css" />
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

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }

    .step-container.line1 {
      padding: 5px;
      border: 1px solid lightgray;
      margin-bottom: 5px;
      width: calc(100% - 15px)
    }

    .sold-out2 {
      position: absolute;
      left: 25%;
      top: 40%;
      transform: rotate(350deg);
      -ms-transform: rotate(350deg);
      -moz-transform: rotate(350deg);
      -webkit-transform: rotate(350deg);
      -o-transform: rotate(350deg)
    }

    .sold-out {
      position: absolute;
      left: 25%;
      top: 38%;
      transform: rotate(350deg);
      -ms-transform: rotate(350deg);
      -moz-transform: rotate(350deg);
      -webkit-transform: rotate(350deg);
      -o-transform: rotate(350deg)
    }

    .ZoomContainer {
      display: none
    }

    .row .mt-10-part {
      min-width: 33%;
      max-width: 33%;
      text-align: center
    }

    .camera-left {
      width: 90%;
      text-align: left !important
    }

    .exc_pro {
      padding-bottom: 40px;
      max-height: 50px;
      margin-bottom: 10px
    }

    .exc_pro1 {
      position: relative;
      overflow: hidden
    }

    .read-more1 {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      text-align: center;
      margin: 0;
      padding: 10px 0 2px;
      background: #fff;
      z-index: 1;
      display: none
    }

    .sold-out {
      position: absolute;
      left: 25%;
      top: 20%;
      transform: rotate(350deg);
      -ms-transform: rotate(350deg);
      -moz-transform: rotate(350deg);
      -webkit-transform: rotate(350deg);
      -o-transform: rotate(350deg)
    }

    .download_templete .modal-content.data {
      width: 30%
    }

    .data .btn-a.btn-yellow,
    .btn-a.btn-orange {
      width: 80%
    }

    .data .table_rubber td:nth-child(odd) {
      background: #fff
    }

    @media(max-width: 768px) {
      .download_templete .modal-content.data {
        width: 90%
      }
    }

    @media (max-width: 576px) {
      .exc_pro {
        max-height: 85px
      }

      .read-more {
        display: block
      }

      input[name="qty"] {
        width: calc(100% - 200px)
      }

      #label-qty {
        justify-content: space-between
      }
    }

    #delivery-main {
      text-decoration: none;
      position: relative
    }

    #delivery-main:after {
      content: ' ';
      font-size: inherit;
      display: block;
      position: absolute;
      right: 0;
      left: 0;
      top: 30%;
      bottom: 40%;
      border-top: 1px solid red;
      border-bottom: 1px solid red
    }

    .delivery-sub {
      pointer-events: none
    }

    #date_create4 {
      font-size: 22px;
      font-weight: bold;
      color: red;
      letter-spacing: -1px;
      overflow: hidden;
    }

    .flex-container.btn-container div.flex-item {
      width: 30%;
    }

    #step3 .flex-container.btn-container div.flex-item .ord-btn {
      width: 100%;
    }

    .flex-container.btn-container {
      align-items: flex-start;
    }

    .btn-success {
      background: #00a300;
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
      <?php include("acrylic_info.php"); ?>
      <?php include('../banner-campaign.php') ?>
      <h1>アクリルスマホスタンド（モバイルスタンド）の製作。1個から注文可。保護フィルムで、印刷が剥がれません(2026年版)</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルのアクリルスマホスタンド（モバイルスタンド）が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/stand" title="Share by Email" target="_blank">シェアする</a><a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルのアクリルスマホスタンド（モバイルスタンド）が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/stand" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2fstand" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2fstand&amp;text=オリジナルのアクリルスマホスタンド（モバイルスタンド）が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <div class="flex-container">
        <div class="flex-item item">
          <div class="preview-container">
            <div class="preview-top my-gallery">
              <div id="box-show-id-1">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x1665">
                    <img class="zoom-img" id="zoom_01" src="img/acyl-stand1.webp" data-zoom-image="img/acyl-stand1.webp" itemprop="thumbnail" width="376" height="458">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-2">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x1665">
                    <img class="zoom-img" id="zoom_02" src="img/acyl-stand2.webp" data-zoom-image="img/acyl-stand2.webp" itemprop="thumbnail" width="376" height="458">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-3">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x1665">
                    <img class="zoom-img" id="zoom_03" src="img/acyl-stand3.webp" data-zoom-image="img/acyl-stand3.webp" itemprop="thumbnail" width="376" height="458">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-4">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x1665">
                    <img class="zoom-img" id="zoom_04" src="img/acyl-stand4.webp" data-zoom-image="img/acyl-stand4.webp" itemprop="thumbnail" width="376" height="458">
                  </a>
                </figure>
              </div>
            </div>

            <div class="preview-sub flex-container">
              <div class="flex-item"><img src="img/acyl-stand1.webp" width="93" height="114" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();">
              </div>
              <div class="flex-item"><img src="img/acyl-stand2.webp" width="93" height="114" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();">
              </div>
              <div class="flex-item"><img src="img/acyl-stand3.webp" width="93" height="114" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();">
              </div>
              <div class="flex-item"><img src="img/acyl-stand4.webp" width="93" height="114" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();">
              </div>
            </div>
          </div>
          <div style="font-size: 12px;" class="camera-preview">📷大きな画像にマウスを合わせると拡大されます</div>
          <div class="ptw-container"></div>
        </div>

        <div class="flex-item item">
          <table class="table_rubber" style="padding: 0 ;">
            <tr>
              <td class="TableLeft">素材</td>
              <td class="">アクリル板3mm厚</td>
            </tr>
            <tr>
              <td class="TableLeft">サイズ</td>
              <td class="">本体(組立時)：高150mmx幅90mmx奥行100mm</td>
            </tr>
            <tr>
              <td class="TableLeft">色数</td>
              <td class="">フルカラーUVインクジェット印刷+白押さえが基本となります。<br />片面印刷：UV印刷+白押さえ</td>
            </tr>
            <tr>
              <td class="TableLeft">アタッチメント</td>
              <td class="">なし</td>
            </tr>
            <tr>
              <td class="TableLeft">台紙</td>
              <td class="">既製品：50種類のデータから選択可 <br>
                オリジナル印刷：お客様の入稿データを使用し、印刷します <br>
                支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。
              </td>
            </tr>
            <tr>
              <td class="TableLeft">試作品</td>
              <td class="">20以上のご注文から可能です</td>
            </tr>
            <tr>
              <td class="TableLeft">最小ロット</td>
              <td class="">1個</td>
            </tr>
            <tr>
              <td class="TableLeft">包装</td>
              <td class="">個別OPP包装</td>
            </tr>
            <tr>
              <td class="TableLeft">特徴</td>
              <td class="">印刷面をフィルム保護。CNCカット</td>
            </tr>
            <tr>
              <td class="TableLeft">納期</td>
              <td class="">6営業日/10営業日</td>
            </tr>
          </table>
        </div>
      </div>

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

      <!-- <div class="flex-container">
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_smartphone_stand_20220607.zip">
              <span>テンプレート</span>
            </a>
            <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
              <span>入稿データ作成</span>
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/howtoorder/acrylic" target="_blank">
              <span>ご注文の流れ</span>
            </a>
            <a class="btn-a btn-yellow" href="/contact/?item=アクリルスマホスタンド">
              <span>無料サンプル</span>
            </a>
          </div>
        </div>
      </div> -->
      <!-- <div class="flex-container">
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
      </div> -->


      <table class="cld_tb">
        <tr class="cld_head">
          <td colspan="2">今、この製品を製作開始した場合の出荷日を表示中</td>
        </tr>
        <tr class="cld_r1">
          <td><?= lang('製作開始日時') ?></td>
          <td>６営業日出荷予定</td>
        </tr>
        <tr class="cld_r2">
          <td rowspan="4"><span id="date_create"></span></td>
          <td><span id="date_create4"></span></td>
        </tr>
        <tr class="cld_r1">
          <td>10営業日出荷予定</td>
        </tr>
        <tr class="cld_r2">
          <td><span id="date_create2"></span></td>
        </tr>
      </table>

	  <br>

      <a class="new-text" href="/howtoorder/acrylic" target="_blank">アクリル製品のご注文の流れ</a>
      <br><br>
      <a class="new-text" href="/contact/?item=アクリルスマホスタンド" >無料サンプルの送付をリクエスト</a>
	  
      <div id="download_temp_data" class="download_templete">
        <div class="modal-content data">
          <span class="close">&times;</span>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="/products/data-acrylic-stand.php" target="_blank">
                    <div>Illustrator／Photoshopはこちら</div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="/products/clip_studio_data_making.php" target="_blank">
                    <div>CLIP STUDIO PAINTはこちら</div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

	  <h2>入稿データ作成について</h2>
      <br>
      <p class="new-text">アクリル製品の製作に必要不可欠なカットパス・白押さえの作成（データ作成補助）を無料で承っております。お気軽にご利用ください。</p>
      <br>
      <a href="/products/acrylic/cutline_white" target="_blank">
        <img src="img/Banner_Acrylc_Pink.webp" width="770" height="194" />
      </a>
      <br>
      <br>
      <p class="new-text">なお、「カットパス・白押さえも自分で細かく設定したい」という方向けに、入稿データ作成のテンプレート及びアクリル製品の入稿データ作成ガイドもご用意しております。</p>
      <br>

      <a class="new-text" href="/products/acrylic/template/template-acrylic_smartphone_stand_20220607.zip" download>入稿データテンプレートをダウンロード</a>
      <br>
      <br>
      <a class="new-text" href="/lp/acrylic-guide.php?sec=data">入稿データ作成ガイド</a>

      <h2>印刷を守る保護フィルム付き！</h2>
      <br>
      <img class="lazy" data-src="img/acrylic-protection-cnc-02.webp" width="770" height="388" loading="lazy">
      <br><br>
      <p class="new-text">当店アクリルグッズは、印刷を守る保護フィルム付き。コインで削っても印刷が剥がれません。さらに、カット面のエッジには滑らかな触り心地のCNC加工を採用しています。</p>
      <br>

      <?php $page = 'product';  include('../../campaign_2021.php'); ?>
    
      <div class="videoWrapper">
        <img src="img/ak-yt.webp" data-src="ho78jzoURdM" class="iframe" width="100%" height="434">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <?php include("four_reason-v2.php") ?>
      <h2>製作事例紹介</h2>
      <div class="tag-menu" style="display: none;">
        タグで絞込み：
        <a href='/gallery/acrylic_key-test?tag=個人' class='tag-name' target="_blank">個人</a>
        <a href='/gallery/acrylic_key-test?tag=会社' class='tag-name' target="_blank">会社</a>
        <a href='/gallery/acrylic_key-test?tag=赤色' class='tag-name' target="_blank">赤色</a>
        <a href='/gallery/acrylic_key-test?tag=青色' class='tag-name' target="_blank">青色</a>
        <a href='/gallery/acrylic_key-test?tag=黄色' class='tag-name' target="_blank">黄色</a>
        <a href='/gallery/acrylic_key-test?tag=紫色' class='tag-name' target="_blank">紫色</a>
        <a href='/gallery/acrylic_key-test?tag=緑色' class='tag-name' target="_blank">緑色</a>
        <a href='/gallery/acrylic_key-test?tag=黒色' class='tag-name' target="_blank">黒色</a>
        <a href='/gallery/acrylic_key-test?tag=1人' class='tag-name' target="_blank">1人</a>
        <a href='/gallery/acrylic_key-test?tag=複数人' class='tag-name' target="_blank">複数人</a>
        <a href='/gallery/acrylic_key-test?tag=片面' class='tag-name' target="_blank">片面</a>
        <a href='/gallery/acrylic_key-test?tag=両面' class='tag-name' target="_blank">両面</a>
      </div>
      <div class="exc_pro1 ex-row">
        <div class="swiper-button-prev"></div>
        <div class="swiper-container swiper2">
          <div class="swiper-wrapper swiper-bt">
            <div class="swiper-slide">
              <a href="/products/acrylic/img/acrylic-stand-1.webp" data-lightbox="acrylic-a1" style="text-decoration:none;" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　青山様">
                <img src="/products/acrylic/img/acrylic-stand-1.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します </div>
              </a>
              <a href="/products/acrylic/img/acrylic-stand-1b.webp" data-lightbox="acrylic-a1" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　青山様"></a>
              <a href="/products/acrylic/img/acrylic-stand-1c.webp" data-lightbox="acrylic-a1" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　青山様"></a>
            </div>
            <div class="swiper-slide">
              <a href="/products/acrylic/img/acrylic-stand-2.webp" data-lightbox="acrylic-a2" style="text-decoration:none;" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　望月様">
                <img src="/products/acrylic/img/acrylic-stand-2.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します </div>
              </a>
              <a href="/products/acrylic/img/acrylic-stand-2b.webp" data-lightbox="acrylic-a2" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　望月様"></a>
              <a href="/products/acrylic/img/acrylic-stand-2c.webp" data-lightbox="acrylic-a2" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　望月様"></a>
            </div>
            <div class="swiper-slide">
              <a href="/products/acrylic/img/acrylic-stand-3.webp" data-lightbox="acrylic-a3" style="text-decoration:none;" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　石川様">
                <img src="/products/acrylic/img/acrylic-stand-3.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します </div>
              </a>
              <a href="/products/acrylic/img/acrylic-stand-3b.webp" data-lightbox="acrylic-a3" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　石川様"></a>
              <a href="/products/acrylic/img/acrylic-stand-3c.webp" data-lightbox="acrylic-a3" data-title="集え!!クリエイター無料製作キャンペーン当選デザイン　石川様"></a>
            </div>
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div style="text-align: center; margin: 15px auto 0; display: none;">
          <a href="/gallery/acrylic_key"><img class="btn_z" src="/products/images/but3-02.webp" width="266" height="167"></a>
        </div>
        <div class="read-more1"><a href="#" class="btn"><img class="btn_z" src="/products/images/but3-02.webp" width="266" height="167"></a></div>
      </div>
      <!-- <hr /> -->
      <!-- <h2 style="margin-top: 5px;">入稿データ作成方法</h2>
      <a href="https://hotmobily.jp/products/data-acrylic-stand.php" target="_blank"><img src="img/banner_design_data.webp" width="100%" height="388" style="max-width:770px;"></a> -->
      <?php include("../campaign_news.php"); ?>
      <hr />
      <h2>代表的な本数での価格表</h2>
      <p class="new-text">納期と印刷面を選択してください。サイズ別の製作単価表が表示されます。ここは価格表のみです。<a href="#est-content">見積・注文</a>はこちらです。</p><br />
      <h3>納期</h3>
      <div class="part-container">
        <div class="part-content" style="display: flex;">
          <label class="part-name"><input type="radio" name="prc_delivery" value="10" checked="" onclick="writePriceTable('del');">10営業日 <span class="checkmark"></span></label>
          <label class="part-name"><input type="radio" name="prc_delivery" value="6" onclick="writePriceTable('del');">6営業日 <span class="checkmark"></span></label>
        </div>
      </div><br />
      <h3>数量・サイズ別価格表</h3>
      <div class="fixed-thead">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table id="table-price" class="tbl-price tb-w12 blink" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;width: 99%;">
          <thead>
            <tr>
              <td></td>
              <td>150x90mm</td>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※お買い上げ金額合計が11,000円（税込）未満の場合、別途送料880円（税込）がかかります。<br>
      </div>
      <h2 id="est-content">ご注文・見積書作成</h2>

      <?php include('../campaign_banner.php') ?>

      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【アクリルスマホスタンド（モバイルスタンド）】</h3>
          <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td>納期</td>
                <td><span id="sample-prd-prdt"></span></td>
              </tr>
              <tr>
                <td>サイズ</td>
                <td><span id="sample-prd-size"></span></td>
              </tr>
              <tr>
                <td>数量</td>
                <td><span id="sample-prd-qty"></span></td>
              </tr>
              <tr>
                <td>試作品</td>
                <td><span id="sample-prd-samp"></span></td>
              </tr>
              <tr>
                <td>データ作成補助</td>
                <td><span id="sample-prd-trace"></span></td>
              </tr>
            </table>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="img/coming-soon.webp" id="sample-paper-pic" class="picpro" width="500" height="500"><br />
            台紙:<span id="sample-paper-name">なし</span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details">納期・サイズ</span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div><span class="step-details">台紙等</span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details">製品仕様・製作料金</span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="アクリルスマホスタンド" />
            <input type="hidden" id="ms_mode" value="<?php echo (isset($_GET['mode']) ? $_GET['mode'] : "") ?>">
          </div>
          <?php
          //Setup delivery data
          switch ($acy_delivery) {
            case '10営業日':
              $delivery_10 = "checked";
              break;
            case '6営業日':
              $delivery_6 = "checked";
              break;
            default:
              $delivery_10 = "checked";
              break;
          }
          //Setup size data
          switch ($acy_size) {
            case '150x90':
              $size110 = "checked";
              break;
            default:
              $size110 = "checked";
              break;
          }
          //Setup sample data
          switch ($acy_sample) {
            case 'あり':
              $sample = "checked";
              break;
          }
          //Setup trace data
          switch ($acy_trace) {
            case 'あり':
              $trace = "checked";
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
            
            <h3>納期</h3>
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_delivery" value="10営業日" onclick="check_val('next')" <?= $delivery_10 ?>>10営業日<span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name" <?=$delivery_disabled?>><input type="radio" name="acy_delivery" value="6営業日" onclick="check_val('next')" <?= $delivery_6 ?> <?= $planDisabled ?>>6営業日 <span class="checkmark"></span></label>
              </div>
              <h3 style="font-size: 13px;"><i style="color:red" class="fa fa-exclamation-circle" aria-hidden="true"></i>毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。
              </h3>
            </div>
            <h3>サイズ</h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_size" value="150x90" onclick="check_val('next');" <?= $size110 ?>>150mmx90mm. <span class="checkmark"></span></label>
              </div>
            </div>
            <h3>数量</h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty">ご注文・御見積数量&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" onblur="check_val('next')" value="<?= $qty ?>"></label>
                <div class="error" id="qty-error"></div>
              </div>
              <h3 style="font-size: 13px;">※デザイン1種につき1注文となります。デザインが複数ある場合は、デザインごとにご注文ください。</h3>
            </div>
          </div>
          <div class="estimate-content" id="step2">
            <h3>台紙</h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='acy_paper_select'>
                    <input type="checkbox" class="checkbox" name="acy_paper_select" value="あり" onclick="check_val('next')" <?= ($acy_paper_select == "あり" ? "checked" : "") ?>>
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
                  <?php if ($acy_paper_select == "あり") {
                    include("../acy_paper_preview.php");
                  } ?>
                </div>
              </div>
            </div>
            <h3 style="display: inline;">試作品・データ作成補助</h3><a href="javascript:void(0)" id="opn-modal">詳細</a>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='acy_sample'>
                    <input type="checkbox" class="checkbox" name="acy_sample" value="あり" onclick="cal_c()" <?= $sample ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>
                  試作品 (20個以上から)
                </label>
                <div class="error" id="sample-error"></div>
              </div>
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='acy_trace'>
                    <input type="checkbox" class="checkbox" name="acy_trace" value="あり" onclick="cal_c()" <?= $trace ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>
                  データ作成補助
                </label>
                <div id="myModal" class="modal">
                  <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <p>
                      アクリル製品を製作する際に必要な、カットパスと白押さえのデータを作成するサービスです。<br />アドビイラストレータもしくはフォトショップ以外のソフトでデザインを作成した場合には、必ずありを選択してください。
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="estimate-content flex-item" id="step3">
            <div class="flex-container">
              <div class="flex-item">
                <h3>製品仕様</h3>
                <table class="table_rubber">
                  <tbody>
                    <tr>
                      <td class="TableLeft">納期</td>
                      <td class="" id="prd_production" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">サイズ</td>
                      <td class="" id="prd_size" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">数量</td>
                      <td class="" id="prd_amount" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">台紙</td>
                      <td class="" id="prd_paper" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class="" id="prd_sample" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データ作成補助</td>
                      <td class="" id="prd_trace" style="text-align: left;">なし</td>
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
                      <td class=""><input id="prd_price" type="text" name="prd_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">台紙</td>
                      <td class=""><input id="prd_paper_price" type="text" name="prd_paper_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データ作成補助</td>
                      <td class=""><input id="prd_trace_price" type="text" name="prd_trace_price" readonly>円</td>
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
                      <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="setzero();">
                      <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step1');$('#cus_detail').hide();">製作条件修正</a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step2');$('#cus_detail').hide();">オプション修正</a>
                      <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle();">
                      <div class="flex-item">
                        <input type="button" class="btn ord-btn btn-success" value="カートに入れる" onclick="comSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', form);">
                        <!-- <input type="button" class="btn ord-btn" value="すぐに購入" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form);"> -->
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="acrylic-btn" class="btn-container">
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="validation('back')">戻る</a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="validation('next')">オプション入力へ</a>
          </div>
        </form>
        <div id="cus_detail" style="display:none;" align="center">
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');" value="御社情報確定（PDF出力）">
                  <div class="remark">&nbsp;※社名や会社名の入力は任意です</div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr />
      <h2 style="margin-top: 5px;">よくある質問</h2>
      <div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">Aというデザインを2枚、Bというデザインを2枚注文する際、合計4枚として注文できますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">はい、できます。</span><a href="javascript:void(0)" onclick="$('#panel1').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel1" class="a-detail new-text">
            アクリルスマホスタンドの注文画面はカート形式となっております。この場合、まずAデザインのご注文をカートに入れていただき、その後「買い物を続ける」ボタンをクリックしてください。アクリル製品一覧画面に移行しますので、再度アクリルスマホスタンドのページに行き、注文画面からBデザインのご注文をカートに入れてください。カートに2つの注文が入っていることをご確認後「購入へ」ボタンをクリックし、ご購入のステップにお進みください。例えば、表面のデザインは同じで、裏面のデザインだけが異なる場合も、別々の注文として2件のご注文をカートに入れていただく必要がございます。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">データ作成補助はどんな時に必要ですか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">アドビイラストレータもしくは、フォトショップ以外で作成されたデータでご注文の場合、原則必須となります。</span><a href="javascript:void(0)" onclick="$('#panel2').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel2" class="a-detail new-text">
            アクリルキーホルダーを作成する際、デザインのデータ以外に、カットパスと白押さえのデータが必要となります。カットバスとは、どのようにアクリルキーホルダーをカットするかのデータです。白押さえとは、アクリルキーホルダーを印刷する際、白色部分は印刷されませんので、透明となります。一旦白色以外の部分を印刷した後、指定された部分のみ白色印刷を行います。カットパスと白押さえの詳細は、<a href="https://hotmobily.jp/products/data-acrylic-umbrella.php">入稿データ作成</a>のページをご覧ください。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">注文したのですが、キャンセルしたいです。できますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">製作（量産）開始のご連絡前であれば可能です。</span><a href="javascript:void(0)" onclick="$('#panel3').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel3" class="a-detail new-text">
            製品の製作を開始する際には、その旨をメールでご連絡させて頂きます。このメールが送信される前であれば、キャンセルは可能です。キャンセル費用はかかりません。既に製作料金のお振込みが完了している場合、ご返金させて頂きますが、ご返金に伴う振り込み手数料はお客様負担となります。また、製作料金よりも振り込み手数料の方が高い場合、ご返金はできません。製作開始後のキャンセルは一切できませんのでご了承ください。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">配送先を複数拠点に出来ますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">複数拠点に発送は可能です。</span><a href="javascript:void(0)" onclick="$('#panel4').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel4" class="a-detail new-text">ただし、発送数量、発送住所をお伺いして別途配送手配代金を追加で頂戴する必要がございます。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">注文フォームから注文した内容を変更できますか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">注文内容の変更は可能ですが、案件の進行状況によっては対応は異なります。</span><a href="javascript:void(0)" onclick="$('#panel5').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel5" class="a-detail new-text">
            弊社にてデザインを調整前（製作開始前）は、正しい注文内容にて再注文をお願いします。<br />弊社にてデザインを調整後（製作開始後）は、デザインを変更できませんが、パーツは変更可能でございます。パーツ変更に伴い、追加料金が発生する場合、差額を再度ご入金頂く必要がございます。
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail">同じデザインですが、複数種のアタッチメントに変更したいです。手配は可能ですか？</div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange">手配可能です。</span><a href="javascript:void(0)" onclick="$('#panel6').slideToggle('fast');">...詳細表示</a></div>
          <div id="panel6" class="a-detail new-text">現在のご注文フォームからこのような注文はお受けできませんので、ご希望がございますお客様は直接営業担当までご相談ください。
          </div>
        </div>
        <div class="quest">Q</div>
        <div class="q-detail">納期について、6営業と10営業がありますが、営業日とは何ですか？また、配送時間はどれくらいですか？</div>
        <div class="ans">A</div>
        <div class="q-detail"><span class="orange">営業日とは土日祝をカウントしない日数です。</span><a href="javascript:void(0)" onclick="$('#panel7').slideToggle('fast');">...詳細表示</a></div>
        <div id="panel7" class="a-detail new-text">また、製品の配送には2日程度かかります。※離島を除く。
        </div>
      </div>
      <hr />
      <?php include('../acrylic-blog.php'); ?>
      <h2>その他アクリル製品</h2>
	  <?php include('acrylic-items-lists.php') ?>
      <!-- <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/"><img src="img/go_to_top.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/figure"><img src="img/go_to_figure.webp" width="380" height="165"></a>
        </div>
      </div>
      <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/umbrella"><img src="img/go_to_um.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/badge"><img src="img/go_to_badge.webp" width="380" height="165"></a>
        </div>
      </div>
      <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/coaster"><img src="img/go_to_coaster.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/hairbunch"><img src="img/go_to_hair.webp" width="380" height="165"></a>
        </div>
      </div>
      <div class="flex-container">
        <div class="flex-item item" style="text-align: center;">
          <a href="/products/acrylic/griptok"><img src="img/go_to_griptok.webp" width="380" height="165"></a>
        </div>
        <div class="flex-item item" style="text-align: center;">

        </div>
      </div> -->
      <hr />
      <h2>営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。</h2>
      <a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82"></a>
      <div style="clear: both">&nbsp;</div>
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../../footer.html'); ?>
  <!--フッター ここまで-->
  <script src="../js/lightbox.js"></script>
  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/products/js/hand-scroll.js?v=1.01"></script>
  <script type="text/javascript" src="<?= $cal_acrylic_stand_js ?>"></script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="ptw/photoswipe.min.js?v=1.08"></script>
  <script src="ptw/photoswipe-ui-default.min.js"></script>
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script>
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

    lightbox.option({
      'maxWidth': 800,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    });
    $(function() {
      var tmp = "<?= $_GET['mode'] ?>";
      if (tmp != "") {
        validation('step3');
      }
    })

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
            "padding-bottom": 0
          })
          .animate({
            "height": totalHeight
          });

        $p.fadeOut();

        return false;
      });
    });
    $("input[name='acy_paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/acy_paper_preview.php');
      }
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

    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "アクリルキーホルダー"
      },
      success: function(data) {
        prd_date1(data.sort());
      },
      dataType: "json"
    });
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "アクリルキーホルダー exp"
      },
      success: function(data) {
        prd_date2(data.sort());
      },
      dataType: "json"
    });

    function prd_date1(date) {
      var str = date,
        l = str.length - 1,
        date_f = new Date(str[0]),
        date_l = new Date(str[l]),
        f = new Date();
      var date = new Date();
      var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];
      currentHours = date.getHours();
      currentHours = ("0" + currentHours).slice(-2);
      $('.cld_tb').show();
      $('#date_create').text(add_digi(parseInt(f.getMonth() + 1)) + "月" + add_digi(f.getDate()) + "日(" + dayOfWeekStrJP[f
        .getDay()] + ") " + add_digi(f.getHours()) + ":" + add_digi(f.getMinutes()));
      $('#date_create2').text(add_digi(parseInt(date_l.getMonth() + 1)) + "月" + add_digi(date_l.getDate()) + "日(" +
        dayOfWeekStrJP[date_l.getDay()] + ")");
    }

    function prd_date2(date) {
      var str = date,
        l = str.length - 1,
        date_f = new Date(str[0]),
        date_l = new Date(str[l]),
        f = new Date();
      var date = new Date();
      var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];
      currentHours = date.getHours();
      currentHours = ("0" + currentHours).slice(-2);
      $('.cld_tb').show();
      $('#date_create4').text(add_digi(parseInt(date_l.getMonth() + 1)) + "月" + add_digi(date_l.getDate()) + "日(" +
        dayOfWeekStrJP[date_l.getDay()] + ")");
    }

    function add_digi(num) {
      if (num < 10) {
        return "0" + num;
      } else {
        return num;
      }
    }
  </script>

  <script type="application/ld+json">
        [
            <?php echo $json_ld_output; ?>, {
                "@context": "https://schema.org",
                "@type": "BreadcrumbList",
                "itemListElement": [{
                        "@type": "ListItem",
                        "position": 1,
                        "name": "ホーム",
                        "item": "https://hotmobily.jp/"
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": "Products",
                        "item": "https://hotmobily.jp/products"
                    },
                    {
                        "@type": "ListItem",
                        "position": 3,
                        "name": "アクリルスマホスタンド",
                        "item": "https://hotmobily.jp/products/acrylic/stand"
                    }
                ]
            }
        ]
    </script>
    <!-- /.google script -->
</body>

</html>