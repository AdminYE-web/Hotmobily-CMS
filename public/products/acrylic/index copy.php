<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
error_reporting(E_ALL ^ E_NOTICE);
//Read Modules
require_once('../../control/Control_Rubber.php');
include_once('../../common/Const.php');
include_once('../../common/SetUpLang.php');
include("../../connect_db/Control_Connect.php");

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
} else if ($msMode === "MODE_RESET") {
  session_unset();
  session_destroy();
} else {
  $mrFormData = $_POST;
  $link = gsCnv2Form($_SERVER['SERVER_PHP_SELF']);
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

// 1. Define or retrieve your dynamic product variables here
// *************************************************************
// REPLACE these placeholder values with your actual PHP variables
// that hold the product data from your database or CMS.
// *************************************************************
$product_name = "【ホットモバイリー】オリジナルアクリルキーホルダー";
$product_description = "オリジナルデザインのアクリルキーホルダーをオーダーメイドで製作。最短6営業日で出荷可能。小ロット1個から製作できます。最安168円。キャラクターグッズや企業ノベルティに";
$product_image_url = "https://hotmobily.jp/gallery/img-acrylic/ACY-2-13-1.webp?v=0.01";
$product_sku = "HM-AK-2024";
$product_price = 168;
$product_currency = "JPY";
$product_availability = "InStock";
$product_url = "https://hotmobily.jp/products/acrylic/";

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

// Check Cart for Simulator Items
$cartHasSimulator = false;
$cartHasNormal = false;
$cartHasDelivery10 = false;
$cartHasDelivery6 = false;
$cartHasSample = false;
$cartHasNoSample = false;

$count_no_simulator = $count_have_simulator = 0;
if (isset($_COOKIE['cart'])) {
  $cart_ids = $_COOKIE['cart'];
  // Sanitize to allow only comma-separated numbers
  if (preg_match('/^[0-9,]+$/', $cart_ids)) {
    $sql = "SELECT item_detail FROM `HM_cart_detail` WHERE id IN (" . $cart_ids . ")";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        $details = json_decode($row['item_detail'], true);
        if (is_array($details)) {
          foreach ($details as $item) {

            // Check if item is relevant (Acrylic) or general rule? 
            // User said "simulator used item and not used item".
            // We assume this applies generally or at least when adding new Acrylic.
            if (isset($item['acy_simulator']) && $item['acy_simulator'] == 'はい') {
              $cartHasSimulator = true;
              $count_have_simulator ++;
            } else {
              // Assume items without this flag or set to 'いいえ' are normal
              // But we should probably only count items that *could* have simulator?
              // For safety, let's treat any item without simulator as "normal".
              $cartHasNormal = true;
              $count_no_simulator ++;
            }

            // Check Delivery
            if (isset($item['acy_delivery'])) {
              if ($item['acy_delivery'] == '10営業日') {
                $cartHasDelivery10 = true;
              } elseif ($item['acy_delivery'] == '6営業日') {
                $cartHasDelivery6 = true;
              }
            }

            // Check Sample
            if (isset($item['acy_sample']) && $item['acy_sample'] == 'あり') {
              $cartHasSample = true;
            } else {
              $cartHasNoSample = true;
            }
          }
        }
      }
    }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index,follow">
  <meta name="keywords" content="<?= lang('アクリル,キーホルダー,オリジナル,名入れ,製作,作成,アクキー,剥がれない,1個から') ?>">
  <meta name="description" content="<?= lang('オリジナルのアクリルキーホルダーが1個から注文可。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現') ?>">
  <title><?= lang('オリジナルアクリルキーホルダー(アクキー)の製作。1個から注文可。保護フィルムで、印刷が剥がれません。') ?></title>
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <?php include('../../head_products.html'); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <link href="/products/css/product_group.css?v=1.11" rel="stylesheet" type="text/css" />
  <link href="css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.10" rel="stylesheet" type="text/css">
  <link href="/products/css/calendar.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="ptw/photoswipe.css">
  <link rel="stylesheet" href="ptw/default-skin.css">
  <link href="/products/acrylic/css/hand-scroll.css?v=1.00" rel="stylesheet" type="text/css">
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
    .mt-10-part div,.row .mt-10-part{text-align:center}.data .table_rubber td:nth-child(odd),.read-more1{background:#fff}#A,#C,#D,.exc_pro1{position:relative}.row{justify-content:flex-start}.new-text{font-size:16px!important;letter-spacing:.05em!important;line-height:150%!important}.mt-10-part{min-width:23%;max-width:23%}.row .mt-10-part{min-width:33%;max-width:33%}.camera-left{width:90%;text-align:left!important}.exc_pro1{overflow:hidden;padding-bottom:110px;max-height:230px}.exc_pro{max-height:325px}.read-more1{position:absolute;bottom:0;left:0;width:100%;text-align:center;margin:0;padding:10px 0 2px;z-index:1}.tag-menu{font-weight:700}.tag-name{font-weight:400}.download_templete .modal-content.data,.flex-container.btn-container div.flex-item{width:30%}.btn-a.btn-orange,.data .btn-a.btn-yellow{width:80%}.prodate{padding:0 5px;text-align:center;font-weight:700;background:linear-gradient(to bottom,#d66f21 10%,#ea8335 35%,#f58e41 100%);border-radius:5px;color:#fff;font-size:16px;font-family:'Noto Sans JP',sans-serif;width:87%;margin:auto}.exc_pro1 .swiper-slide{margin-bottom:12px}@media(max-width:768px){.download_templete .modal-content.data{width:90%}}@media (max-width:576px){.exc_pro1{padding-bottom:0}input[name=qty]{width:calc(100% - 200px)}#label-qty{justify-content:space-between}.prodate{width:90%;margin:0;font-size:13px;font-weight:500}.exc_pro1 .swiper-slide{margin-bottom:0}.flex-container.btn-container div.flex-item{width:100%!important}}a.tag-name{padding:2px 5px;background:#f7b516;display:inline-block;margin:5px 5px 5px 0;border:1px solid #f58904;color:#fff;text-decoration:none;border-radius:5px}a.tag-name.active,a.tag-name:hover{background:#fff;color:#f58904}.selected-tag{display:block;animation:1s fade-in}.unselect-tag{display:none;animation:1s fade-out}.pc-show{display:block}.mobile-show{display:none}#B,#C .PC-C-Contents,.Mb-A-Contents{filter:blur(10px);opacity:0;transition:filter .5s ease-out,opacity .5s ease-out}@keyframes fade-in{from{opacity:0}to{opacity:1}}@keyframes fade-out{from{opacity:1}to{opacity:0}}.sign{font-size:35px}#date_create4{font-size:22px;font-weight:700;color:red;letter-spacing:-1px;overflow:hidden}#step3 .flex-container.btn-container div.flex-item .ord-btn{width:100%}.flex-container.btn-container{align-items:flex-start}.btn-success{background:#00a300}.repeat input[type=text]{padding:5px 10px;margin-left:-32px;width:-webkit-fill-available}@media screen and (max-width:768px){#A,.mobile-show{display:block}.pc-show{display:none}#A{margin-top:0;opacity:1}#B,#D .Mb-D-Contents,.Mb-A-Contents{filter:blur(10px);opacity:0;transition:filter .5s ease-out,opacity .5s ease-out}}
    .acrylic-use-cases{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:50px;margin:16px 0 34px}.acrylic-use-card{border:1px solid #e5e5e5;background:#fff;padding:10px 12px 18px;box-sizing:border-box}.acrylic-use-card-title{margin:0 0 8px;color:#f58904;font-size:15px;font-weight:700;line-height:1.4}.acrylic-use-card-img{display:block;width:100%;aspect-ratio:1/1;object-fit:cover;border:1px solid #ddd;box-sizing:border-box}.acrylic-use-card-date{margin:5px 0 22px;text-align:right;font-size:10px;line-height:1;color:#000}.acrylic-use-card-comment-title{margin:0 0 6px;font-size:16px;font-weight:700;line-height:1.4;color:#000}.acrylic-use-card-text{margin:0;font-size:14px;line-height:1.55;letter-spacing:.04em;color:#000}@media screen and (max-width:576px){.acrylic-use-cases{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.acrylic-use-card{padding:8px}.acrylic-use-card-title{font-size:14px}.acrylic-use-card-comment-title{font-size:15px}.acrylic-use-card-text{font-size:13px}}
    <?= ($_SESSION['lang'] == "kr" ? 'body{font-family: "돋움체",DotumChe,serif!important;}#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}.prodate,.q-detail,.tab-label{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body{font-family: "Prompt", sans-serif!important;}#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}.prodate,.q-detail,.tab-label{font-family: "Prompt", sans-serif!important;}' : '') ?>
  </style>
  <script>
    (function() {
    //   function css(el, styles) {
    //     if (!el) return;
    //     Object.assign(el.style, styles);

    //     requestAnimationFrame(() => {
    //       el.style.filter = "blur(0)";
    //     });
    //   }

    //   function cssAll(selector, styles) {
    //     document.querySelectorAll(selector).forEach(el => css(el, styles));
    //   }

    })();
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
      <?php include("acrylic_info.php"); ?>
      <?php include('../banner-campaign.php') ?>

      <div id="" class="">
        <h1 class=""><?= lang('オリジナルアクリルキーホルダー(アクキー)の製作。1個から注文可。保護フィルムで、印刷が剥がれません(2026年版)') ?></h1>
        <div class="social-time">
          <span class="social-content">
            <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルのアクリルキーホルダー(アクキー)が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a><a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルのアクリルキーホルダー(アクキー)が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
            <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2f&amp;text=オリジナルのアクリルキーホルダー(アクキー)が製作できます。剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現" target="_blank"><i class="fab fa-twitter-square"></i></a>
          </span>
          <span class="time-content">更新日 2026年6月12日</span>
        </div>
      </div>

      <div id="">
        <img src="img/acrylic_banner2024.webp?v=1.01" alt="オリジナルアクリルキーホルダー(アクキー)の製作。1個から注文可。保護フィルムで、印刷が剥がれません(2024年版)" width="" height="" />
        <!-- <a href="/lp/acrylic-simulator-guide.php"><img src="/lp/images/acrylic-simulator/6-autocutline02_v2.webp" alt="オリジナルアクリルキーホルダー(アクキー)の製作。1個から注文可。保護フィルムで、印刷が剥がれません(2024年版)" width="" height="" /></a> -->
        
      </div>

      <div>&nbsp;</div>

      <div class="" id="">
        <div class="flex-container">
          <div class="flex-item item">
            <div class="preview-container">
              <div class="preview-top my-gallery">
                <div id="box-show-id-1">
                  <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                    <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                      <img class="zoom-img" id="zoom_01" src="img/acrylickey/acykey_375x230-1.webp?v=1.01" data-zoom-image="img/acrylickey/acykey_1365x840-1.webp" width="376" height="231" itemprop="thumbnail">
                    </a>
                  </figure>
                </div>
                <div id="box-show-id-2">
                  <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                    <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                      <img class="zoom-img" id="zoom_02" src="img/acrylickey/acykey_375x230-2.webp" data-zoom-image="img/acrylickey/acykey_1365x840-2.webp" width="376" height="231" itemprop="thumbnail">
                    </a>
                  </figure>
                </div>
                <div id="box-show-id-3">
                  <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                    <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                      <img class="zoom-img" id="zoom_03" src="img/acrylickey/acykey_375x230-3.webp" data-zoom-image="img/acrylickey/acykey_1365x840-3.webp" width="376" height="231" itemprop="thumbnail">
                    </a>
                  </figure>
                </div>
                <div id="box-show-id-4">
                  <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                    <a href="javascript:void(0)" itemprop="contentUrl" data-size="1365x840">
                      <img class="zoom-img" id="zoom_04" src="img/acrylickey/acykey_375x230-4.webp" data-zoom-image="img/acrylickey/acykey_1365x840-4.webp" width="376" height="231" itemprop="thumbnail">
                    </a>
                  </figure>
                </div>
              </div>
              <div class="preview-sub flex-container">
                <div class="flex-item"><img src="img/acrylickey/acykey_375x230-1.webp?v=1.01" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();">
                </div>
                <div class="flex-item"><img src="img/acrylickey/acykey_375x230-2.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();">
                </div>
                <div class="flex-item"><img src="img/acrylickey/acykey_375x230-3.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();">
                </div>
                <div class="flex-item"><img src="img/acrylickey/acykey_375x230-4.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();">
                </div>
              </div>
            </div>
            <div style="font-size: 12px;" class="camera-preview">📷<?= lang('大きな画像にマウスを合わせると拡大されます') ?></div>
            <div class="ptw-container"></div>
          </div>

          <div class="flex-item item">
            <h2 style="margin-top: 0px;"><?= lang('オリジナルアクリルキーホルダー製作') ?></h2>
            <p class="new-text">
              アクリルキーホルダーをオリジナルのデザインで製作できます。<br /><br />
              印刷面を透明度の高いフィルムで保護。印刷が露出せず、剥がれたり傷ついたりしません。<br /><br />
              小ロット1個から製作できます。レーザーカッターではなく、CNCでカットする為、エッジがいつも滑らかで肌触り抜群です。<br /><br />
              透明度が高く、裏面から見ても透けない印刷が特徴です。全品オーダーメイドの特注品。一方価格は常に激安で作成できるのが当店の強みです。同人グッズ、企業名入れノベルティ等として幅広くご利用頂いております。アクキー製作なら、まずは当店へご相談下さい。
            </p>
          </div>
        </div>
      </div>

      <h2>シミュレーターをご用意！カットラインと白押さえを自動生成！</h2>
      <a href="/lp/acrylic-simulator-guide.php"><img src="/lp/images/acrylic-simulator/simulator_banner-guidepage-v2.webp" alt=""></a><br /><br />
      <p class="new-text">お客様がアクキーにしたいイラストや写真をアップロードすれば、その場でアクキーのカットライン（カットパス）が生成されるシミュレーターをご用意しております。</p><br />
      <p class="new-text">注文の時点でカットラインがどのような形になるかわかるので、「完成図をイメージして注文できる」「途中でデザイナーをはさまずに手早くサッと注文できる」などのメリットが強みです。ぜひご活用ください。</p><br />
      <a href="/lp/acrylic-simulator-guide.php" class="btn btn-primary new-text">シミュレーター使用ガイド</a>

      <h2><?= lang('オリジナルアクリルキーホルダー製作事例') ?></h2>
      <div class="tag-menu">
        <?= lang('タグで絞込み') ?>：
        <a href='/gallery/acrylic_key?tag=個人' class='tag-name' target="_blank"><?= lang('個人') ?></a>
        <a href='/gallery/acrylic_key?tag=会社' class='tag-name' target="_blank"><?= lang('会社') ?></a>
        <a href='/gallery/acrylic_key?tag=赤色' class='tag-name' target="_blank"><?= lang('赤色') ?></a>
        <a href='/gallery/acrylic_key?tag=青色' class='tag-name' target="_blank"><?= lang('青色') ?></a>
        <a href='/gallery/acrylic_key?tag=黄色' class='tag-name' target="_blank"><?= lang('黄色') ?></a>
        <a href='/gallery/acrylic_key?tag=紫色' class='tag-name' target="_blank"><?= lang('紫色') ?></a>
        <a href='/gallery/acrylic_key?tag=ピンク色' class='tag-name' target="_blank"><?= lang('ピンク色') ?></a>
        <a href='/gallery/acrylic_key?tag=緑色' class='tag-name' target="_blank"><?= lang('緑色') ?></a>
        <a href='/gallery/acrylic_key?tag=黒色' class='tag-name' target="_blank"><?= lang('黒色') ?></a>
        <a href='/gallery/acrylic_key?tag=1人' class='tag-name' target="_blank"><?= lang('1人') ?></a>
        <a href='/gallery/acrylic_key?tag=複数人' class='tag-name' target="_blank"><?= lang('複数人') ?></a>
        <a href='/gallery/acrylic_key?tag=片面' class='tag-name' target="_blank"><?= lang('片面') ?></a>
        <a href='/gallery/acrylic_key?tag=両面' class='tag-name' target="_blank"><?= lang('両面') ?></a>
      </div>
      <div class="ex-row">
        <div class="swiper-button-prev"></div>
        <div class="swiper-container swiper2">
          <div class="swiper-wrapper swiper-bt">

            <div class="swiper-slide">
              <div class="prodate">シンプルなロゴ</div>
              <a href="/products/acrylic/img/acrylic-2026/hey-king-records-custom-acrylic-keychain.webp" data-lightbox="acrylic_swiper15" style="text-decoration:none;" data-title="">
                <img src="/products/acrylic/img/acrylic-2026/hey-king-records-custom-acrylic-keychain.webp" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/2023-acrylic-gallery/50.webp?v=0.01" data-lightbox="acrylic_swiper15" data-title=""></a>
              <a href="/gallery/img-acrylic/2023-acrylic-gallery/51.webp?v=0.01" data-lightbox="acrylic_swiper15" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">大きいサイズ</div>
              <a href="/products/acrylic/img/acrylic-2026/shishito-pepper-kawaii-food-acrylic-keychain.webp" data-lightbox="acrylic_swiper16" style="text-decoration:none;" data-title="">
                <img src="/products/acrylic/img/acrylic-2026/shishito-pepper-kawaii-food-acrylic-keychain.webp" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/2023-acrylic-gallery/65.webp?v=0.01" data-lightbox="acrylic_swiper16" data-title=""></a>
              <a href="/gallery/img-acrylic/2023-acrylic-gallery/66.webp?v=0.01" data-lightbox="acrylic_swiper16" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">女の子のキャラクター</div>
              <a href="/products/acrylic/img/acrylic-2026/custom-anime-girl-idol-character-acrylic-keychain.webp" data-lightbox="acrylic_swiper1" style="text-decoration:none;" data-title="">
                <img src="/products/acrylic/img/acrylic-2026/custom-anime-girl-idol-character-acrylic-keychain.webp" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/ACY-2-13-2.webp" data-lightbox="acrylic_swiper1" data-title=""></a>
              <a href="/gallery/img-acrylic/ACY-2-13-4.webp?v=0.01" data-lightbox="acrylic_swiper1" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">ポップなキャラクター</div>
              <a href="/products/acrylic/img/acrylic-2026/anime-boy-cool-character-with-cap-keychain.webp" data-lightbox="acrylic_swiper2" style="text-decoration:none;" data-title="">
                <img src="/products/acrylic/img/acrylic-2026/anime-boy-cool-character-with-cap-keychain.webp" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/ACY-2-06-02.webp" data-lightbox="acrylic_swiper2" data-title=""></a>
              <a href="/gallery/img-acrylic/ACY-2-06-4.webp" data-lightbox="acrylic_swiper2" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">セーラー服のロゴデザイン</div>
              <a href="/products/acrylic/img/acrylic-2026/retro-neon-shigure-custom-acrylic-keychain.webp" data-lightbox="acrylic_swiper3" style="text-decoration:none;" data-title="">
                <img src="/products/acrylic/img/acrylic-2026/retro-neon-shigure-custom-acrylic-keychain.webp" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/ACY-1-09_02.webp" data-lightbox="acrylic_swiper3" data-title=""></a>
              <a href="/gallery/img-acrylic/ACY-1-0909.webp" data-lightbox="acrylic_swiper3" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">動物のキャラクター</div>
              <a href="/gallery/img-acrylic/acry040122-61a.jpg?v=0.01" data-lightbox="acrylic_swiper4" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry040122-61a.jpg?v=0.01" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry040122-61b.jpg" data-lightbox="acrylic_swiper4" data-title=""></a>
              <a href="/gallery/img-acrylic/acry040122-61c.jpg" data-lightbox="acrylic_swiper4" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">女の子のイラスト</div>
              <a href="/gallery/img-acrylic/acry040122-33a.jpg" data-lightbox="acrylic_swiper5" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry040122-33a.jpg" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry040122-33b.jpg" data-lightbox="acrylic_swiper5" data-title=""></a>
              <a href="/gallery/img-acrylic/acry040122-33c.jpg" data-lightbox="acrylic_swiper5" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">着ぐるみキャラクター</div>
              <a href="/gallery/img-acrylic/acry040122-36a.jpg" data-lightbox="acrylic_swiper6" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry040122-36a.jpg" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry040122-36b.jpg" data-lightbox="acrylic_swiper6" data-title=""></a>
              <a href="/gallery/img-acrylic/acry040122-36c.jpg" data-lightbox="acrylic_swiper6" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">観光列車の記念デザイン</div>
              <a href="/gallery/img-acrylic/acry230622-2a.webp" data-lightbox="acrylic_swiper7" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry230622-2a.webp" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry230622-2b.webp" data-lightbox="acrylic_swiper7" data-title=""></a>
              <a href="/gallery/img-acrylic/acry230622-2d.webp" data-lightbox="acrylic_swiper7" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">賑やかなパステルカラー</div>
              <a href="/gallery/img-acrylic/acry040122-32a.jpg" data-lightbox="acrylic_swiper8" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry040122-32a.jpg" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry040122-32b.jpg" data-lightbox="acrylic_swiper8" data-title=""></a>
              <a href="/gallery/img-acrylic/acry040122-32c.jpg" data-lightbox="acrylic_swiper8" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">ウサギのキャラクター</div>
              <a href="/gallery/img-acrylic/acry230622-12a.webp" data-lightbox="acrylic_swiper9" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry230622-12a.webp" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry230622-12b.webp" data-lightbox="acrylic_swiper9" data-title=""></a>
              <a href="/gallery/img-acrylic/acry230622-12c.webp?v=0.1" data-lightbox="acrylic_swiper9" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">ロゴデザイン</div>
              <a href="/gallery/img-acrylic/acry270721-2a.jpg" data-lightbox="acrylic_swiper10" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry270721-2a.jpg" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry270721-2b.jpg" data-lightbox="acrylic_swiper10" data-title=""></a>
              <a href="/gallery/img-acrylic/acry270721-2c.jpg?v=0.1" data-lightbox="acrylic_swiper10" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">かわいらしいキャラクター</div>
              <a href="/gallery/img-acrylic/acry040122-54a.jpg" data-lightbox="acrylic_swiper11" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry040122-54a.jpg" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry040122-54b.jpg" data-lightbox="acrylic_swiper11" data-title=""></a>
              <a href="/gallery/img-acrylic/acry040122-54c.jpg?v=0.1" data-lightbox="acrylic_swiper11" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">飛行機のイラスト</div>
              <a href="/products/acrylic/img/acrylic-a21.jpg?v=1.00" data-lightbox="acrylic_swiper13" style="text-decoration:none;" data-title="">
                <img src="/products/acrylic/img/acrylic-a21.jpg?v=1.00" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/acrylic/img/acrylic-a21b.jpg?v=1.00" data-lightbox="acrylic_swiper13" data-title=""></a>
              <a href="/products/acrylic/img/acrylic-a21bag.jpg?v=1.00" data-lightbox="acrylic_swiper13" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">かわいい鳥のイラスト</div>
              <a href="/gallery/img-acrylic/acry040122-52a.jpg?v=1.00" data-lightbox="acrylic_swiper14" style="text-decoration:none;" data-title="">
                <img src="/gallery/img-acrylic/acry040122-52a.jpg?v=1.00" class="picpro" width="229" height="229" loading="lazy">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/gallery/img-acrylic/acry040122-52b.jpg?v=1.00" data-lightbox="acrylic_swiper14" data-title=""></a>
              <a href="/gallery/img-acrylic/acry040122-52c.jpg?v=1.00" data-lightbox="acrylic_swiper14" data-title=""></a>
            </div>

          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div style="text-align: center; margin: 15px auto 0;">
          <a href="/gallery/acrylic_key"><img class="btn_z" src="/products/images/but3-02.webp" width="266" height="40"></a>
        </div>
      </div>
      <?php include("four_reason-v2.php") ?>

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

      <!-- <div class="flex-container" id="btn-group">
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow download_temp" href="javascript:void(0)">
              <span><?= lang('テンプレート') ?></span>
            </a>
            <a class="btn-a btn-yellow " href="/products/data-acrylic.php">
              <span><?= lang('入稿データ作成') ?></span>
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/howtoorder/acrylic" target="_blank">
              <span><?= lang('ご注文の流れ') ?></span>
            </a>
            <a class="btn-a btn-yellow" href="/contact/?item=アクリルキーホルダー">
              <span><?= lang('無料サンプル') ?></span>
            </a>
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
      <a class="new-text" href="/contact/?item=アクリルキーホルダー" >無料サンプルの送付をリクエスト</a>


        <h2>入稿データ作成について</h2>
        <br>
        <p class="new-text">アクリル製品の製作に必要不可欠なカットパス・白押さえの作成（データ作成補助）を無料で承っております。お気軽にご利用ください。</p>
        <br>
        <a href="/products/acrylic/cutline_white" target="_blank">
	        <img src="img/data-creation-service.webp" width="770" height="194" />
        </a>
        <br>
        <br>
        <p class="new-text">なお、「カットパス・白押さえも自分で細かく設定したい」という方向けに、入稿データ作成のテンプレート及びアクリル製品の入稿データ作成ガイドもご用意しております。</p>
        <br>

        <a class="new-text" href="/products/acrylic/template/template-acrylic-keychain.zip" download>入稿データテンプレートをダウンロード</a>
        <br>
        <br>
        <a class="new-text" href="/products/data-acrylic.php">入稿データ作成ガイド</a>

        <h2>印刷を守る保護フィルム付き！</h2>
        <br>
        <img class="lazy" data-src="img/acrylic-protection-cnc-02.webp" width="770" height="388" loading="lazy">
        <br><br>
        <p class="new-text">当店アクリルグッズは、印刷を守る保護フィルム付き。コインで削っても印刷が剥がれません。さらに、カット面のエッジには滑らかな触り心地のCNC加工を採用しています。</p>
        <br>
        <div id="attachments" style="clear: both;"></div>
        <div class="videoWrapper">
            <img src="img/acrylic-film-youtube (2).webp" data-src="pnKcyfuh4Rw" class="iframe" width="770" height="434" loading="lazy">
                <div class="playbtn">
                <div class="tri"></div>
            </div>
        </div>

      <div id="download_templete" class="download_templete">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3><?= lang('アクリルキーホルダー') ?>【Illustrator／Photoshop】</h3>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>50×50mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_50mm_20250320.ai">
                    <div><img class="lazy" data-src="img/ai-icon.webp" width="20" height="20" loading="lazy">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_50mm_20250320.psd">
                    <div><img class="lazy" data-src="img/psd-icon.webp" width="20" height="20" loading="lazy">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>75×75mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_75mm_20250320.ai">
                    <div><img class="lazy" data-src="img/ai-icon.webp" width="20" height="20" loading="lazy">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_75mm_20250320.psd">
                    <div><img class="lazy" data-src="img/psd-icon.webp" width="20" height="20" loading="lazy">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>100×100mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_100mm_20250320.ai">
                    <div><img class="lazy" data-src="img/ai-icon.webp" width="20" height="20" loading="lazy">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_100mm_20250320.psd">
                    <div><img class="lazy" data-src="img/psd-icon.webp" width="20" height="20" loading="lazy">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div id="download_temp_data" class="download_templete">
        <div class="modal-content data">
          <span class="close">&times;</span>
          <table class="table_rubber">
            <tbody>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="/products/data-acrylic.php" target="_blank">
                    <div>Illustrator／Photoshopは<?= lang('こちら') ?></div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>
                  <a class="btn-a btn-yellow" href="/products/clip_studio_data_making.php" target="_blank">
                    <div>CLIP STUDIO PAINT<?= lang('はこちら') ?></div>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- <hr style="margin-bottom: 10px;margin-top: 0;" /> -->
      <?php $page = 'product';
      include('../../campaign_2021.php'); ?>
      
     
      <h2><?= lang('アタッチメント') ?></h2>
      <p class="new-text"><?= lang('写真をクリックすると拡大写真と詳細説明を確認頂けます。') ?></p>
      <div class="exc_pro">
        <div class="swiper-container">
          <div class="row">
            <div class="mt-10-part">
              <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-5" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。">
                <img class="picpro lazy" data-src="/products/images/HM_part5.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part5.webp" data-lightbox="img-part-set-5-1" data-title="<strong>【銀色ナスカン】</strong>銀色のナスカンです。片手で開閉出来ますので、小さいお子様でも簡単にご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-6" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。">
                <img class="picpro lazy" data-src="/products/images/HM_part6.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part6.webp" data-lightbox="img-part-set-6-1" data-title="<strong>【星型ナスカン】</strong>星型のナスカンです。アクセントのあるパーツです。記念品などでもご利用頂けます。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-7" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。">
                <img class="picpro lazy" data-src="/products/images/HM_part7.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part7.webp" data-lightbox="img-part-set-7-1" data-title="<strong>【ハート型ナスカン】</strong>ハート型のナスカンです。キャラクター系のデザインに合わせてもかわいいパーツです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part14.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14-1" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-4" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。">
                <img class="picpro lazy" data-src="/products/images/HM_part4.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part4.webp" data-lightbox="img-part-set-4-1" data-title="<strong>【金色ナスカン】</strong>金メッキをしたナスカンです。高級感のあるデザインにぴったりです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-15" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm">
                <img class="picpro lazy" data-src="/products/images/HM_part15.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part15.webp" data-lightbox="img-part-set-15-1" data-title="<strong>【リング小+チェーン】</strong>最も小さいキーリングです。小物系のデザインにご利用頂けます。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-18" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm">
                <img class="picpro lazy" data-src="/products/images/HM_part18.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part18.webp" data-lightbox="img-part-set-18-1" data-title="<strong>【リング小+回転カン】</strong>最も小さいキーリングです。丈夫な回転カン仕様です。 リング 外径：23mm　内径：20mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-16" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm">
                <img class="picpro lazy" data-src="/products/images/HM_part16.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part16.webp" data-lightbox="img-part-set-16-1" data-title="<strong>【リング中+チェーン】</strong>最も一般的なサイズのキーリングです。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-19" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm">
                <img class="picpro lazy" data-src="/products/images/HM_part19.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part19.webp" data-lightbox="img-part-set-19-1" data-title="<strong>【リング中+回転カン】</strong>最も一般的なサイズのキーリングです。丈夫な回転カン仕様です。 リング 外径：30mm　内径：25mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-17" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm">
                <img class="picpro lazy" data-src="/products/images/HM_part17.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part17.webp" data-lightbox="img-part-set-17-1" data-title="<strong>【リング大+チェーン】</strong>最も大きいキーリングです。大きいサイズのデザインに適しています。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-20" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm">
                <img class="picpro lazy" data-src="/products/images/HM_part20.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part20.webp" data-lightbox="img-part-set-20-1" data-title="<strong>【リング大+回転カン】</strong>最も大きいキーリングです。丈夫な回転カン仕様です。 リング 外径：33mm　内径：29mm" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-8" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。">
                <img class="picpro lazy" data-src="/products/images/HM_part8.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+22円</div>
              <a href="/products/images/HM_part8.webp" data-lightbox="img-part-set-8-1" data-title="<strong>【半月型ナスカン】</strong>半月型のナスカンです。しっとりとした印象のナスカンです。大人向けのデザインの場合、お勧めです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro lazy" data-src="/products/images/HM_part1.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro lazy" data-src="/products/images/HM_part2.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2-1" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
                <img class="picpro lazy" data-src="/products/images/HM_part3.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3-1" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part9.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9-1" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part10.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10-1" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part11.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11-1" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part12.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12-1" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
              <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。">
                <img class="picpro lazy" data-src="/products/images/HM_part13.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+11円</div>
              <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13-1" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
              <a href="/products/acrylic/img/HM_part-um1.jpg" data-lightbox="img-part-set-55" data-title="アンブレラマーカー">
                <img class="picpro lazy" data-src="/products/acrylic/img/HM_part-um1.jpg" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/acrylic/img/HM_part-um1.jpg" data-lightbox="img-part-set-55-1" data-title="アンブレラマーカー" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
              <a href="/products/acrylic/img/HM_part-um2.jpg" data-lightbox="img-part-set-66" data-title="アンブレラマーカー+ボールチェーン">
                <img class="picpro lazy" data-src="/products/acrylic/img/HM_part-um2.jpg" width="229" height="229" loading="lazy">
              </a><br>
              <div>+0円</div>
              <a href="/products/acrylic/img/HM_part-um2.jpg" data-lightbox="img-part-set-66-1" data-title="アンブレラマーカー+ボールチェーン" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
              <a href="/products/images/Red_opener.webp" data-lightbox="img-part-set-91" data-title="<strong>【ボトルオープナー（赤色）】</strong>赤色のボトルオープナーです。">
                <img class="picpro lazy" data-src="/products/images/Red_opener.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+55円</div>
              <a href="/products/images/Red_opener.webp" data-lightbox="img-part-set-91-1" data-title="<strong>【ボトルオープナー（赤色）】</strong>赤色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
              <a href="/products/images/Blue_opener.webp" data-lightbox="img-part-set-92" data-title="<strong>【ボトルオープナー（青色）】</strong>青色のボトルオープナーです。">
                <img class="picpro lazy" data-src="/products/images/Blue_opener.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+55円</div>
              <a href="/products/images/Blue_opener.webp" data-lightbox="img-part-set-92-1" data-title="<strong>【ボトルオープナー（青色）】</strong>青色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
              <a href="/products/images/Purple_opener.webp" data-lightbox="img-part-set-93" data-title="<strong>【ボトルオープナー（紫色）】</strong>紫色のボトルオープナーです。">
                <img class="picpro lazy" data-src="/products/images/Purple_opener.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+55円</div>
              <a href="/products/images/Purple_opener.webp" data-lightbox="img-part-set-93-1" data-title="<strong>【ボトルオープナー（紫色）】</strong>紫色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

            <div class="mt-10-part">
              <a href="/products/images/Black_opener.webp" data-lightbox="img-part-set-94" data-title="<strong>【ボトルオープナー（黒色）】</strong>黒色のボトルオープナーです。">
                <img class="picpro lazy" data-src="/products/images/Black_opener.webp" width="229" height="229" loading="lazy">
              </a><br>
              <div>+55円</div>
              <a href="/products/images/Black_opener.webp" data-lightbox="img-part-set-94-1" data-title="<strong>【ボトルオープナー（黒色）】</strong>黒色のボトルオープナーです。" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
            </div>

          </div>
        </div>
        <div class="read-more1"><a href="#" class="btn"><img class="btn_z" src="/products/images/but3-03.webp" width="266" height="40" loading="lazy"></a></div>
      </div>
      <hr />
      <h2 style="margin-top: 5px;"><?= lang('入稿データ作成方法') ?></h2>
      <a href="https://hotmobily.jp/products/data-acrylic.php" target="_blank"><img class="lazy" data-src="img/acrylic-data-guide.webp" width="770" height="388" loading="lazy"></a>
      <?php include("../campaign_news.php"); ?>
      <hr />
      <h2><?= lang('代表的な本数での価格表') ?></h2>
      <p class="new-text"><?= lang('納期と印刷面を選択してください。サイズ別の製作単価表が表示されます。ここは価格表のみです。<a href="#est-content">見積・注文</a>はこちらです。') ?></p><br />
      <h3><?= lang('納期') ?></h3>
      <div class="part-container">
        <div class="part-content" style="display: flex;">
          <label class="part-name">
            <input type="radio" name="prc_delivery" value="10" checked="" onclick="writePriceTable('del');">10<?= lang('営業日') ?> <span class="checkmark"></span>
          </label>
          <label class="part-name">
            <input type="radio" name="prc_delivery" value="6" onclick="writePriceTable('del');">6<?= lang('営業日') ?>
            <span class="checkmark"></span>
          </label>
        </div>
      </div>
      <h3><?= lang('印刷面') ?></h3>
      <div class="part-container">
        <div class="part-content" style="display: flex;">
          <label class="part-name"><input type="radio" name="prc_screen" value="1" checked="" onclick="writePriceTable();"><?= lang('片面印刷') ?> <span class="checkmark"></span></label>
          <label class="part-name"><input type="radio" name="prc_screen" value="2" onclick="writePriceTable();"><?= lang('両面印刷') ?> <span class="checkmark"></span></label>
        </div>
      </div><br />
      <h3><?= lang('数量・サイズ別価格表') ?></h3>
      <div class="fixed-thead">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table id="table-price" class="tbl-price tb-w12 blink" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;width: 99%;">
          <thead>
            <tr>
              <td></td>
              <td>50×50mm<?= lang('以内') ?></td>
              <td>75×75mm<?= lang('以内') ?></td>
              <td>100×100mm<?= lang('以内') ?></td>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※お買い上げ金額合計が11,000円（税込）未満の場合、別途送料880円（税込）がかかります。<br>
      </div>
      <h2 id="est-content"><?= lang('ご注文・見積書作成') ?></h2>

      <?php include('../campaign_banner.php') ?>

      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('アクリルキーホルダー') ?>】</h3>
          <span class="total-price"><span class="prd_total">0</span>円<?= lang('（税込）') ?></span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td><?= lang('納期') ?></td>
                <td><span id="sample-prd-prdt"></span></td>
              </tr>
              <tr>
                <td><?= lang('サイズ') ?></td>
                <td><span id="sample-prd-size"></span></td>
              </tr>
              <tr>
                <td><?= lang('印刷面') ?></td>
                <td><span id="sample-prd-screen"></span></td>
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
                <td><?= lang('データ作成補助') ?></td>
                <td><span id="sample-prd-trace"></span></td>
              </tr>
            </table>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img class="lazy" data-src="/products/images/HM_part1-2.webp" id="sample-part-pic" class="picpro" width="320" height="320"><br />
            <span id="sample-part-name"><?= lang('アタッチメント:なし') ?></span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img class="lazy" data-src="img/coming-soon.webp" style="display: none;" id="sample-paper-pic" class="picpro" width="500" height="500"><br />
            <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('納期・サイズ・印刷面') ?></span>
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
            <input type="text" name="ItemType" id="strap" value="アクリルキーホルダー" />
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
            case '50':
              $size50 = "checked";
              break;
            case '75':
              $size75 = "checked";
              break;
            case '100':
              $size100 = "checked";
              break;
            default:
              $size50 = "checked";
              break;
          }
          //Setup screen data
          switch ($acy_screen) {
            case '片面印刷':
              $screen1 = "checked";
              break;
            case '両面印刷':
              $screen2 = "checked";
              break;
            default:
              $screen1 = "checked";
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

            <h3><?= lang('シミュレーターを使用しますか？お客様のイラストや写真を元にカットパス・白押さえを自動生成します（片面印刷のみ対応）。') ?></h3>
            <h3 style="font-size: 13px; margin-top: 5px;">※着日指定、注文後の配送先変更は対応いたしかねます。着日指定をご希望の場合、注文後の配送先変更の可能性がある場合は、シミュレーターを使用しない方法での注文をお願いいたします。</h3>
            <h3 style="font-size: 13px;">※シミュレーターを使わない注文でご提供させて頂いている製作図面確認は省略となります。</h3>
            <h3 style="font-size: 13px;">※カード支払いのみとなります。<a href="javascript:void(0)" onclick="$('#modal-5').prop('checked',true)">その他の注意点</a></h3>

            <input class="modal-state" id="modal-5" type="checkbox">
            <div class="modal">
                <label class="modal__bg" for="modal-5"></label>
                <div class="modal__inner modal1" style="height: fit-content;">
                    <label class="modal__close" for="modal-5"></label>
                    <div>
                        <p class="new-text">【シミュレーター使用の注意点】</p>
                        <br>
                        <p class="new-text" style="font-size: 13px !important;">※着日指定、注文後の配送先変更は対応いたしかねます。着日指定をご希望の場合、注文後の配送先変更の可能性がある場合は、シミュレーターを使用しない方法での注文をお願いいたします。</p>
                        <p class="new-text" style="font-size: 13px !important;">※シミュレーターを使わない注文でご提供させて頂いている製作図面確認は省略となります。</p>
                        <p class="new-text" style="font-size: 13px !important;">※カード支払いのみとなります。</p>
                        <p class="new-text" style="font-size: 13px !important;">※シミュレーター使用の注文では台紙なしとなります。</p>
                        <p class="new-text" style="font-size: 13px !important;">※シュミレーター未使用、納期、試作などオプションが異なる別の商品と一緒にカートに入れる事はできません。</p>
                        <p class="new-text" style="font-size: 13px !important;">※背景削除ができる背景の色は白色のみです。</p>
                        <p class="new-text" style="font-size: 13px !important;">※著作権や肖像権を侵害するおそれがあるご注文はお断りしております。</p>
                        <p class="new-text" style="font-size: 13px !important;">※著名な作品を模したデザインは1個のみ、自分用、無料配布などであっても正式な許可が無い限りお断りしております。</p>
                        <br>
                        <p class="new-text">【重要】ご注文確定後のキャンセル・変更について</p>
                        <br>
                        <p class="new-text" style="font-size: 13px !important;">アクリルシミュレーターの特性上、ご注文が確定した直後に工場での製作が開始されます。 そのため、ご注文確定後のキャンセル・デザインや数量の変更、およびご返金はお受けすることができません。デザインや数量等に間違いがないか、十分にご確認の上ご注文をお願いいたします。万が一、事前にお約束している納期に遅れが生じた場合でも、それを理由としたご注文のキャンセルはお受けできません。イベント等で製品の利用日が決まっているお客様は、日数に余裕をもったご注文をおすすめしております。</p>
                    </div>
                </div>
            </div>

            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_simulator" value="いいえ" onclick="check_simulator_interaction()" <?= ($acy_simulator == "いいえ" || $acy_simulator == "") ? "checked" : "" ?>><?= lang('いいえ') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_simulator" value="はい" onclick="check_simulator_interaction()" <?= ($acy_simulator == "はい") ? "checked" : "" ?>><?= lang('はい') ?> <span class="checkmark"></span></label>
              </div>
            </div>

            <h3>納期</h3>
            <div class="acy_delivery">
              <?php include('../alert-btn.php') ?>
              <div class="part-container">
                <div class="part-content">
                  <label class="part-name"><input type="radio" name="acy_delivery" value="10営業日" onclick="check_val('next')" <?= $delivery_10 ?>>10<?= lang('営業日') ?><span class="checkmark"></span></label>
                </div>
                <div class="part-content ">
                  <label class="part-name" <?= $delivery_disabled ?>><input type="radio" name="acy_delivery" value="6営業日" onclick="check_val('next')" <?= $delivery_6 ?>>6<?= lang('営業日') ?> <span class="checkmark"></span></label>
                </div>
              </div>
              <!-- <h3 style="font-size: 13px;"><i style="color:red" class="fa fa-exclamation-circle" aria-hidden="true"></i>毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。 -->
              </h3>
            </div>

            <h3><?= lang('サイズ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_size" value="50" onclick="check_val('next')" <?= $size50 ?>>50x50mm. <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_size" value="75" onclick="check_val('next')" <?= $size75 ?>>75x75mm. <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_size" value="100" onclick="check_val('next')" <?= $size100 ?>>100x100mm. <span class="checkmark"></span></label>
              </div>
            </div>
            <h3><?= lang('印刷面') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_screen" value="片面印刷" onclick="check_val('next')" <?= $screen1 ?>><?= lang('片面印刷') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_screen" value="両面印刷" onclick="check_val('next')" <?= $screen2 ?>><?= lang('両面印刷') ?> <span class="checkmark"></span></label>
              </div>
            </div>
            <h3><?= lang('数量') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" onblur="check_val('next')" value="<?= $qty ?>"></label>
                <div class="error" id="qty-error"></div>
              </div>
              <h3 style="font-size: 13px;">※デザイン1種につき1注文となります。デザインが複数ある場合は、デザインごとにご注文ください。</h3>
            </div>
          </div>
          <div class="estimate-content" id="step2">
            <h3><?= lang('アタッチメント') ?></h3>
            <div class="flex-container">
              <div class="preview-container">
                <div class="preview-sub flex-container">
                  <?php
                  include('part-acrylic-keychain.php');
                  $i = 0;
                  for ($i = 0; $i < count($attachment); $i++) {
                    echo '
										<div class="flex-item">
										<label class="part-name">
										<input type="radio" name="acy_part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($acy_part == $attachment[$i]["part_name"] ? 'checked' : '') . '>
										<img class="lazy" data-src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="picpro">
										<br><span class="std_price">+' . ($attachment[$i]["part_price"] * 1.1) . '円</span>
										</label>
										</div>';
                  }
                  ?>
                </div>
                <div class="error" id="part-error" style="text-align: center;"></div>
              </div>
            </div>
            <h3><?= lang('台紙') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='acy_paper_select'>
                    <input type="checkbox" class="checkbox" name="acy_paper_select" value="あり" <?= ($acy_paper_select != "なし" ? ($acy_paper_select != "" ? "checked" : "") : "") ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>
                  <?= lang('台紙印刷') ?>
                </label>
                <div class="error" id="paper-error"></div>
                <div id="acy_paper_msg"></div>
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
            <h3 style="display: inline;"><?= lang('試作品・データ作成補助') ?></h3><a href="javascript:void(0)" id="opn-modal">詳細</a>
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
                  <?= lang('試作品 (20個以上から)') ?>
                </label>
                <div class="error" id="sample-error"></div>
                <div class="error" id="sample-simulator-remark"></div>
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
                  <?= lang('データ作成補助') ?>
                </label>
                <div id="myModal" class="modal">
                  <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <p>
                      <?= lang('アクリル製品を製作する際に必要な、カットパスと白押さえのデータを作成するサービスです。<br/>アドビイラストレータもしくはフォトショップ以外のソフトでデザインを作成した場合には、必ずありを選択してください。') ?>
                    </p>
                  </div>
                </div>
              </div>
              <p class="red">※完成図シミュレーターを利用される場合、データ作成補助オプションは必要ありません。</p>
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
                      <td class="TableLeft"><?= lang('印刷面') ?></td>
                      <td class="" id="prd_print" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('数量') ?></td>
                      <td class="" id="prd_amount" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class="" id="prd_part" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('台紙') ?></td>
                      <td class="" id="prd_paper" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class="" id="prd_sample" style="text-align: left;">なし')?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データ作成補助') ?></td>
                      <td class="" id="prd_trace" style="text-align: left;">なし</td>
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
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class=""><input id="prd_part_price" type="text" name="prd_part_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('台紙') ?></td>
                      <td class=""><input id="prd_paper_price" type="text" name="prd_paper_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データ作成補助') ?></td>
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
                      <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="validation('step2');$('#cus_detail').hide();"><?= lang('ｱﾀｯﾁﾒﾝﾄ修正') ?></a>
                      <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle();">
                      <div class="flex-item">
                      <input type="button" class="btn ord-btn btn-success" value="カートに入れる" onclick="if(chk_part() && checkMixedSimulator()){GoSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', form);}">
                        <!-- <input type="button" class="btn ord-btn btn-success" value="カートに入れる" onclick="if(chk_part() && checkMixedSimulator() && ShowSimulatorPopup()){comSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', form);}"> -->
                        <!-- <input type="button" class="btn ord-btn" value="すぐに購入" onclick="if(chk_part()){comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form);}"> -->
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="acrylic-btn" class="btn-container">
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="validation('back')"><?= lang('戻る') ?></a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="validation('next')"><?= lang('アタッチメント・オプション入力へ') ?></a>
          </div>
        </form>

        <input class="modal-state" id="modal-7" type="checkbox">
        <div class="modal">
            <label class="modal__bg" for="modal-7"></label>
            <div class="modal__inner modal1" style="height: fit-content;">
                <label class="modal__close" for="modal-7"></label>
                <div>
                    <p class="new-text">【シミュレーター使用の注意点】</p>
                    <br>
                    <p class="new-text" style="font-size: 13px !important;">※着日指定、注文後の配送先変更は対応いたしかねます。着日指定をご希望の場合、注文後の配送先変更の可能性がある場合は、シミュレーターを使用しない方法での注文をお願いいたします。</p>
                    <p class="new-text" style="font-size: 13px !important;">※シミュレーターを使わない注文でご提供させて頂いている製作図面確認は省略となります。</p>
                    <p class="new-text" style="font-size: 13px !important;">※カード支払いのみとなります。</p>
                    <p class="new-text" style="font-size: 13px !important;">※シミュレーター使用の注文では台紙なしとなります。</p>
                    <p class="new-text" style="font-size: 13px !important;">※シュミレーター未使用、納期、試作などオプションが異なる別の商品と一緒にカートに入れる事はできません。</p>
                    <p class="new-text" style="font-size: 13px !important;">※背景削除ができる背景の色は白色のみです。</p>
                    <p class="new-text" style="font-size: 13px !important;">※著作権や肖像権を侵害するおそれがあるご注文はお断りしております。</p>
                    <p class="new-text" style="font-size: 13px !important;">※著名な作品を模したデザインは1個のみ、自分用、無料配布などであっても正式な許可が無い限りお断りしております。</p>
                    <br>
                     <p class="new-text">【重要】ご注文確定後のキャンセル・変更について</p>
                    <br>
                    <p class="new-text" style="font-size: 13px !important;">アクリルシミュレーターの特性上、ご注文が確定した直後に工場での製作が開始されます。 そのため、ご注文確定後のキャンセル・デザインや数量の変更、およびご返金はお受けすることができません。デザインや数量等に間違いがないか、十分にご確認の上ご注文をお願いいたします。万が一、事前にお約束している納期に遅れが生じた場合でも、それを理由としたご注文のキャンセルはお受けできません。イベント等で製品の利用日が決まっているお客様は、日数に余裕をもったご注文をおすすめしております。</p>
                </div>
                <div style="display: flex; flex-direction: row; justify-content: center; margin-top: 15px;">
                    <button type="button" onclick="comSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', document.getElementById('form'));" style="padding: 10px; width: 30%; cursor:pointer;">OK</button>
                </div>
            </div>
        </div>

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
                <td class="TableLeft"><?= lang('郵便番号') ?></td>
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
      <h2 style="margin-top: 5px;"><?= lang('製品仕様・付属品等') ?></h2>

      <table class="table_rubber" style="padding: 0 ;">
        <tr>
          <td class="TableLeft"><?= lang('名称') ?></td>
          <td class=""><?= lang('オリジナルアクリルキーホルダー') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('素材') ?></td>
          <td class=""><?= lang('アクリル板3mm厚') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('サイズ') ?></td>
          <td class="">50X50mm / 75X75mm / 100X100mm </td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('色数') ?></td>
          <td class=""><?= lang('フルカラーUVインクジェット印刷+白押さえが基本となります。<br/>片面印刷：UV印刷+白押さえ<br/>両面印刷：UV印刷+白押さえ+UV印刷') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('アタッチメント') ?></td>
          <td class=""><?= lang('ボールチェーン、キーリング等') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('最小ロット') ?></td>
          <td class="">1<?= lang('個') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('包装') ?></td>
          <td class=""><?= lang('個別OPP包装') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('台紙') ?></td>
          <td class="">
            <?= lang('既製品：50種類のデータから選択可<br/>オリジナル印刷：お客様の入稿データを使用し、印刷します<br/>支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。') ?>
          </td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('特徴') ?></td>
          <td class=""><?= lang('印刷面をフィルム保護。CNCカット') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('納期') ?></td>
          <td class="">6<?= lang('営業日') ?>/10<?= lang('営業日') ?></td>
        </tr>
      </table>
      <!-- <hr /> -->
      <!-- <h2 style="margin-top: 5px;"><?= lang('よくある質問') ?></h2>
      <div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('一度の注文で複数種類のデザインを注文できますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('はい、できます。') ?></span><a href="javascript:void(0)" onclick="$('#panel1').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel1" class="a-detail new-text">
            <?= lang('たとえば、2つのデザインを注文する場合は、まず片方のデザインの注文をカートに入れて頂き、その後「買い物を続ける」ボタンをクリックしてください。クリック後、アクリル製品一覧画面が表示されます。一覧画面で、2つめとして購入したいアクリル製品の欄を選んで頂き、注文画面から2つめのデザインのご注文をカートに入れてください。その後、カートに2つの注文が入っていることをご確認後「購入へ」ボタンをクリックし、ご購入のステップにお進みください。オモテ面のデザインは同じでウラ面のデザインだけが異なる場合も、別々のデザインとして2件のご注文をカートにお入れください。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('データ作成補助はどんな時に必要ですか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('アドビイラストレータもしくは、フォトショップ以外で作成されたデータでご注文の場合、原則必須となります。') ?></span><a href="javascript:void(0)" onclick="$('#panel2').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel2" class="a-detail new-text">
            <?= lang('アクリルキーホルダーを作成する際、デザインのデータ以外に、カットパスと白押さえのデータが必要となります。カットバスとは、どのようにアクリルキーホルダーをカットするかのデータです。白押さえとは、アクリルキーホルダーを印刷する際、白色部分は印刷されませんので、透明となります。一旦白色以外の部分を印刷した後、指定された部分のみ白色印刷を行います。カットパスと白押さえの詳細は、<a href="https://hotmobily.jp/products/data-acrylic.php">入稿データ作成</a>のページをご覧ください。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('注文したのですが、キャンセルしたいです。できますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('製作（量産）開始のご連絡前であれば可能です。') ?></span><a href="javascript:void(0)" onclick="$('#panel3').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel3" class="a-detail new-text">
            <?= lang('製品の製作を開始する際には、その旨をメールでご連絡させて頂きます。このメールが送信される前であれば、キャンセルは可能です。キャンセル費用はかかりません。既に製作料金のお振込みが完了している場合、ご返金させて頂きますが、ご返金に伴う振り込み手数料はお客様負担となります。また、製作料金よりも振り込み手数料の方が高い場合、ご返金はできません。製作開始後のキャンセルは一切できませんのでご了承ください。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('配送先を複数拠点に出来ますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('複数拠点に発送は可能です。') ?></span><a href="javascript:void(0)" onclick="$('#panel4').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel4" class="a-detail new-text"><?= lang('ただし、発送数量、発送住所をお伺いして別途配送手配代金を追加で頂戴する必要がございます。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('注文フォームから注文した内容を変更できますか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('注文内容の変更は可能ですが、案件の進行状況によっては対応は異なります。') ?></span><a href="javascript:void(0)" onclick="$('#panel5').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel5" class="a-detail new-text">
            <?= lang('弊社にてデザインを調整前（製作開始前）は、正しい注文内容にて再注文をお願いします。<br/>弊社にてデザインを調整後（製作開始後）は、デザインを変更できませんが、パーツは変更可能でございます。パーツ変更に伴い、追加料金が発生する場合、差額を再度ご入金頂く必要がございます。') ?>
          </div>
        </div>
        <div style="margin-bottom: 10px;">
          <div class="quest">Q</div>
          <div class="q-detail"><?= lang('同じデザインですが、複数種のアタッチメントに変更したいです。手配は可能ですか？') ?></div>
          <div class="ans">A</div>
          <div class="q-detail"><span class="orange"><?= lang('手配可能です。') ?></span><a href="javascript:void(0)" onclick="$('#panel6').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
          <div id="panel6" class="a-detail new-text"><?= lang('現在のご注文フォームからこのような注文はお受けできませんので、ご希望がございますお客様は直接営業担当までご相談ください。') ?>
          </div>
        </div>
        <div class="quest">Q</div>
        <div class="q-detail"><?= lang('納期について、6営業と10営業がありますが、営業日とは何ですか？また、配送時間はどれくらいですか？') ?></div>
        <div class="ans">A</div>
        <div class="q-detail"><span class="orange"><?= lang('営業日とは土日祝をカウントしない日数です。') ?></span><a href="javascript:void(0)" onclick="$('#panel7').slideToggle('fast');">...<?= lang('詳細表示') ?></a></div>
        <div id="panel7" class="a-detail new-text"><?= lang('また、製品の配送には2日程度かかります。※離島を除く。') ?>
        </div>
      </div> -->

      <?php
      $favor = 'acrylic';
      if (isset($favor) && $favor == 'acrylic') {
        include '../product-faq-v2.php';
      }
      ?>

      <hr />
      <?php include('../acrylic-blog.php'); ?>

      <?php
      if (isset($favor) && $favor == 'acrylic') {
        include '../product-review-v2.php';
      }
      ?>
<!-- addnew -->
      <h2><?= lang('アクリルキーホルダー利用事例') ?></h2>
      <br>
      <p class="new-text"><?= lang('当店で製作させて頂いたアクリルキーホルダーの利用事例です。') ?></p><br />
      <div class="acrylic-use-cases">
        <div class="acrylic-use-card">
          
          <a href="/products/acrylic/img/acrylickey/acrylic-keychain-use-01.webp" data-lightbox="acrylic_use_card1" style="text-decoration:none;" data-title="">
            <img class="acrylic-use-card-img lazy" data-src="/products/acrylic/img/acrylickey/acrylic-keychain-use-01.webp" alt="<?= lang('マイバッグに取り付けたアクリルキーホルダー') ?>" width="320" height="320" loading="lazy">
            <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
          </a>
          <p class="acrylic-use-card-date">2026年6月12日</p>
          <h3 class="acrylic-use-card-title"><?= lang('マイバッグに取り付け！') ?></h3>
          <p class="acrylic-use-card-text"><?= lang('可愛い女の子イラストのアクキーと一緒にお出かけ！') ?></p>
        </div>
        <div class="acrylic-use-card">
          
          <a href="/products/acrylic/img/acrylickey/acrylic-keychain-use-02.webp" data-lightbox="acrylic_use_card2" style="text-decoration:none;" data-title="">
            <img class="acrylic-use-card-img lazy" data-src="/products/acrylic/img/acrylickey/acrylic-keychain-use-02.webp" alt="<?= lang('キーリングとして使えるアクリルキーホルダー') ?>" width="320" height="320" loading="lazy">
            <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
          </a>
          <p class="acrylic-use-card-date">2026年6月12日</p>
          <h3 class="acrylic-use-card-title"><?= lang('キーリングとして！') ?></h3>
          <p class="acrylic-use-card-text"><?= lang('マイキーにクールなカーデザインのアクキーをプラス！') ?></p>
        </div>
      </div>


      <h2><?= lang('アクリルグッズ一覧') ?></h2>
      <br>
      
      <?php include('acrylic-items-lists.php') ?>

      <h2><?= lang('営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <a href="//hotmobily.jp/meeting_date/"><img class="lazy" data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82"></a>
      <div style="clear: both">&nbsp;</div>
      <img src="img/x-banner.webp">
      <div style="clear: both">&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">ネルゲル様のアクリルキーホルダー30個今日届きました😆✨素敵に作ってくれて感謝です💞仕上がり綺麗で予備も2つ入れてくれてました✨またぜひ次も何か作りたいです🩷<br>初めてのアクリルキーホルダーだから嬉しい💞<a href="https://twitter.com/hashtag/%E3%82%A2%E3%82%AF%E3%83%AA%E3%83%AB%E3%82%AD%E3%83%BC%E3%83%9B%E3%83%AB%E3%83%80%E3%83%BC?src=hash&amp;ref_src=twsrc%5Etfw">#アクリルキーホルダー</a><a href="https://twitter.com/hashtag/%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC?src=hash&amp;ref_src=twsrc%5Etfw">#ホットモバイリー</a> <a href="https://t.co/WBzy0ZOgGf">https://t.co/WBzy0ZOgGf</a> <a href="https://t.co/GZpmt5E37U">pic.twitter.com/GZpmt5E37U</a></p>&mdash; エトワール (@etowarlukarzas) <a href="https://twitter.com/etowarlukarzas/status/1738063253954232607?ref_src=twsrc%5Etfw">December 22, 2023</a>
          </blockquote>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="flex-item item">
          <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">PundaRock 🆕GOODS✨<br><br>ロゴアクリルキーホルダー！<br><br>1/8(月・祝)熊猫夜会<br>＠下北沢BREATH<br><br>より発売開始です！！<br><br>1個 1,000円<br><br>是非ともよろしくお願いします！<br><br>めちゃくちゃ可愛い!<br>そして仕上げが丁寧✨<a href="https://twitter.com/GoodsYe?ref_src=twsrc%5Etfw">@GoodsYe</a> 様ありがとうございます😆 <a href="https://t.co/4eFwlJDeUp">pic.twitter.com/4eFwlJDeUp</a></p>&mdash; 熊猫屋☆HiRΦ 🐼2024/1/8(月祝)下北沢BREATH,1/21(日)Giorno (@panda8hiro) <a href="https://twitter.com/panda8hiro/status/1743126711661903912?ref_src=twsrc%5Etfw">January 5, 2024</a>
          </blockquote>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="flex-item item">
          <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">参加者特典のプレゼントはホットモバイリー様(<a href="https://twitter.com/GoodsYe?ref_src=twsrc%5Etfw">@GoodsYe</a>)で製作させてもらいました。<br><br>最初から裏面に保護フィルム付きだし面取りしてくれて画像だけ投げたらパスも引いて貰えます。<br>仕上がりや対応もとても良かったのでまた次回も利用させて貰いたいです！！<a href="https://t.co/bLybMDI1gO">https://t.co/bLybMDI1gO</a> <a href="https://t.co/qjoCeoZSAI">pic.twitter.com/qjoCeoZSAI</a></p>&mdash; 朝倉工務店 (@askr_iktrik) <a href="https://twitter.com/askr_iktrik/status/1739937918456668377?ref_src=twsrc%5Etfw">December 27, 2023</a>
          </blockquote>
          <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
      </div>
    </div>

    <!-- :: content_wrapper end :: -->
  </div>
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include('../../footer.php'); ?>
  <!--フッター ここまで-->
  <script src="../js/lightbox.js"></script>
  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/products/js/hand-scroll.js?v=1.01"></script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="ptw/photoswipe.min.js?v=1.08"></script>
  <script src="ptw/photoswipe-ui-default.min.js"></script>
  <!-- <script type="text/javascript" src="/products/js/auto-slider.js"></script> -->
  <script type="text/javascript" src="<?= $cal_acrylic_js ?>"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" language="javascript">
    $(document).ready(function() {
      $("#open-virus").click(function() {
        $("#slide-virus").slideToggle("slow");
      });

      var $el, $ps, $up, totalHeight;
      $(".exc_pro1 .btn").click(function() {
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
      $(".exc_pro .btn").click(function() {
        totalHeight = 0
        $el = $(this);
        $p = $el.parent();
        $up = $p.parent();
        $ps = $up.find("div.swiper-container:not('.read-more1')");
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
      $('#info_div').load('/info/index.php');

      var tmp = "<?= $_GET['mode'] ?>";
      if (tmp != "") {
        validation('step3');
        check_val('next');
      }
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
      // Simulator interaction
      $('input[name="ItemDesignRepeat"]').change(check_simulator_interaction);
      $('input[name="acy_screen"]').change(check_simulator_interaction);
      $('input[name="acy_trace"]').change(check_simulator_interaction);
      $('input[name="acy_sample"]').change(check_simulator_interaction);
      check_simulator_interaction();
    });

    lightbox.option({
      'maxWidth': 800,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    });
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
      window.onload = function() {
        // Wait a short time after the page loads before scrolling
        setTimeout(function() {
          // Scroll the page down by a small amount (e.g., 100 pixels)
          window.scrollBy(0, 5);
        }, 3000); // Adjust the timeout and scroll amount as needed
      };
    } else {
      window.onload = function() {
        // Wait a short time after the page loads before scrolling
        setTimeout(function() {
          // Scroll the page down by a small amount (e.g., 100 pixels)
          window.scrollBy(0, 5);
        }, 100); // Adjust the timeout and scroll amount as needed
      };
    }
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
    $("input[name='acy_paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/acy_paper_preview.php');
      }
    });

    function check_simulator_interaction() {
      var simulator = $('input[name="acy_simulator"]:checked').val();
      if (simulator === "はい") {
        $('input[name="ItemDesignRepeat"][value="はい"]').prop('disabled', true);
        if ($('input[name="ItemDesignRepeat"]:checked').val() === "はい") {
          $('input[name="ItemDesignRepeat"][value="いいえ"]').prop('checked', true);
          $('.repeat').hide();
        }
        $('input[name="acy_screen"][value="両面印刷"]').prop('disabled', true);
        if ($('input[name="acy_screen"]:checked').val() === "両面印刷") {
          $('input[name="acy_screen"][value="片面印刷"]').prop('checked', true);
          check_val('next');
        }
        $('input[name="acy_trace"]').prop('disabled', true);
        if ($('input[name="acy_trace"]').is(':checked')) {
          $('input[name="acy_trace"]').prop('checked', false);
          cal_c();
        }
        
        $('input[name=acy_sample][type="checkbox"]').attr('disabled',true);
        $('input[name=acy_sample]').attr('disabled',true);
        if ($('input[name="acy_sample"]').is(':checked')) {
            $('input[name=acy_sample][type="checkbox"]').prop('checked',false);	
            $('input[name=acy_sample][type="checkbox"]').removeAttr( "checked" );
            cal_c();
        }

        $('#sample-simulator-remark').html('<p style="font-size:13px; color:red;">※完成図シミュレーター利用時には試作品なしとなります。</p>');
        
      } else {
        $('input[name="ItemDesignRepeat"][value="はい"]').prop('disabled', false);
        $('input[name="acy_screen"][value="両面印刷"]').prop('disabled', false);
        $('input[name="acy_trace"]').prop('disabled', false);
        $('input[name=acy_sample]').attr('disabled',false);
        $('input[name=acy_sample][type="checkbox"]').attr('disabled',false);
         $('#sample-simulator-remark').html('');
      }
      var repeat = $('input[name="ItemDesignRepeat"]:checked').val();
      var screen = $('input[name="acy_screen"]:checked').val();
      var trace = $('input[name="acy_trace"]').is(':checked');
      if (repeat === "はい" || screen === "両面印刷" || trace) {
        $('input[name="acy_simulator"][value="はい"]').prop('disabled', true);
      } else {
        $('input[name="acy_simulator"][value="はい"]').prop('disabled', false);
      }
    }

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

    // Mixed Simulator Validation
    var cartHasSimulator = <?= $cartHasSimulator ? 'true' : 'false' ?>;
    var cartHasNormal = <?= $cartHasNormal ? 'true' : 'false' ?>;
    var cartHasDelivery10 = <?= $cartHasDelivery10 ? 'true' : 'false' ?>;
    var cartHasDelivery6 = <?= $cartHasDelivery6 ? 'true' : 'false' ?>;
    var cartHasSample = <?= $cartHasSample ? 'true' : 'false' ?>;
    var cartHasNoSample = <?= $cartHasNoSample ? 'true' : 'false' ?>;
    var debugCartId = "<?= isset($cart_ids) ? $cart_ids : 'none' ?>";
    var count_have_simulator = <?php echo $count_have_simulator ?>;
    var count_no_simulator = <?php echo $count_no_simulator ?>;
    var BypassSimulatorConvert = false;

    function checkMixedSimulator() {
      var simOption = $('input[name="acy_simulator"]:checked').val();
      var currentIsSimulator = (simOption === 'はい');

      var deliveryOption = $('input[name="acy_delivery"]:checked').val();

      var sampleOption = $('input[name="acy_sample"]:checked').val();
      var currentHasSample = (sampleOption === 'あり');

      console.log("Debug Simulator Check:");
      console.log("Cart IDs:", debugCartId);
      console.log("CartHasSimulator:", cartHasSimulator);
      console.log("CartHasNormal:", cartHasNormal);
      console.log("Current Selection:", simOption);
      console.log("CurrentIsSimulator:", currentIsSimulator);
      console.log("CartHasSample:", cartHasSample);
      console.log("CartHasNoSample:", cartHasNoSample);
      console.log("CurrentHasSample:", currentHasSample);

      console.log("count_have_simulator:", count_have_simulator);
      console.log("count_no_simulator:", count_no_simulator);


        if ((count_no_simulator > 0 && currentIsSimulator) || (count_have_simulator > 0 && !currentIsSimulator)) {
            BypassSimulatorConvert = true;
        }



      if ((cartHasSimulator && !currentIsSimulator) && !BypassSimulatorConvert) {
        alert("申し訳ありませんが、シミュレーション（カットパス・白押さえの自動生成）を使用した商品と使用していない商品を同時にカートに入れることはできません。ご了承ください。");
        return false;
      }

      if ((cartHasNormal && currentIsSimulator) && !BypassSimulatorConvert) {
        alert("申し訳ありませんが、シミュレーション（カットパス・白押さえの自動生成）を使用した商品と使用していない商品を同時にカートに入れることはできません。ご了承ください。");
        return false;
      }

      // Check Delivery consistency
      if ((cartHasDelivery10 && deliveryOption !== '10営業日') || (cartHasDelivery6 && deliveryOption !== '6営業日')) {
        alert('申し訳ありませんが、出荷予定日が異なる商品を同時にカートに入れることはできません。ご了承ください。');
        return false;
      }

      // Check Sample consistency
      if (cartHasSample && !currentHasSample) {
        alert('申し訳ありませんが、試作品ありの注文と試作品なしの注文を同時にカートに入れることはできません。ご了承ください');
        return false;
      }

      if (cartHasNoSample && currentHasSample) {
        alert('申し訳ありませんが、試作品ありの注文と試作品なしの注文を同時にカートに入れることはできません。ご了承ください');
        return false;
      }

      return true;
    }

    function GoSubmit(link, sec, form)
    {
        // console.log(link);
        // console.log(sec);
        // console.log(form);
        
        var smpValue = $('input[name="acy_simulator"]:checked').val();
        if (smpValue == "はい") {
            $('#modal-7').prop('checked',true);
        } else {
            comSubmit(link, sec, form);
        }
    }

    function SubmitAction(link, sec, form)
    {
        console.log(link);
        console.log(sec);
        console.log(form);

        alert('form is subbmit!');
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
            "name": "アクリルキーホルダー",
            "item": "https://hotmobily.jp/products/acrylic/"
          }
        ]
      }
    ]
  </script>
  <!-- /.google script -->

</body>

</html>
