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

if ($_COOKIE["username"] == "ome") {
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);

    $is_found = false;
    if(!empty($uri_segments))
    {
        foreach ($uri_segments as $pad => $uri) {
            if(strpos($uri, 'omamori-keyholder') !== false) {
                $is_found = true;
            }
        }
    }
}


// echo "<pre>";
// print_r ($_SESSION);
// echo "</pre>";

$data1 = mysqli_query($conn, "SELECT COUNT(id) AS totalreview FROM reviews_hm") or die(mysqli_error());
$info1 = mysqli_fetch_assoc($data1);

$data2 = mysqli_query($conn, "SELECT AVG(service) AS avg_service, AVG(product) AS avg_product FROM reviews_hm") or die(mysqli_error());
$info2 = mysqli_fetch_assoc($data2);

// 1. Define or retrieve your dynamic product variables here
// *************************************************************
// REPLACE these placeholder values with your actual PHP variables
// that hold the product data from your database or CMS.
// *************************************************************
$product_name = "【ホットモバイリー】オリジナルお守りアクリルキーホルダー";
$product_description = "オリジナルお守りアクリルキーホルダーをオーダーメイドで製作。最短6営業日で出荷可能。小ロット1個から製作できます。最安単価245円。新しい形のお守りやファングッズとして最適";
$product_image_url = "https://hotmobily.jp/products/images/acrylic_omamori-10.webp";
$product_sku = "HM-OAK-2025";
$product_price = 245;
$product_currency = "JPY";
$product_availability = "InStock";
$product_url = "https://hotmobily.jp/products/acrylic/omamori-keyholder.php";

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
  <meta name="robots" content="index,follow">
  <meta name="keywords" content="<?= lang('オリジナルお守りアクリルキーホルダー,お守りアクリルキーホルダー製作,神社,寺院,推し活動,アニメ,キャラクター,アイドル,Vtuber') ?>">
  <meta name="description" content="<?= lang('オリジナルデザインでお守りアクリルキーホルダーをご制作！神社・寺院の新しいお守りとして！アニメキャラやアイドル、Vtuberの推し活グッズとしても最適！紐は叶結びと鈴付き（根付紐）の2種類をご用意！小ロット1個から製作可能！') ?>">
  <title><?= lang('オリジナルデザインでお守りアクリルキーホルダーをご製作！') ?></title>
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
    .mt-10-part div,.row .mt-10-part{text-align:center}.pdp-v2-modal-content,.pdp-v2-modal-overlay{transition:opacity var(--pdp-v2-fade-speed) ease-in-out}.data .table_rubber td:nth-child(odd),.read-more1,swiper-slide{background:#fff}.row{justify-content:flex-start}.new-text{font-size:16px!important;letter-spacing:.05em!important;line-height:150%!important}.mt-10-part{min-width:23%;max-width:23%}.row .mt-10-part{min-width:33%;max-width:33%}.camera-left{width:90%;text-align:left!important}.prodate,.read-more1,swiper-slide{text-align:center}.exc_pro1{position:relative;overflow:hidden;padding-bottom:110px;max-height:230px}.exc_pro{max-height:325px}.read-more1{position:absolute;bottom:0;left:0;width:100%;margin:0;padding:10px 0 2px;z-index:1}.tag-menu{font-weight:700}.tag-name{font-weight:400}.download_templete .modal-content.data,.flex-container.btn-container div.flex-item{width:30%}.btn-a.btn-orange,.data .btn-a.btn-yellow{width:80%}.prodate{padding:0 5px;font-weight:700;background:linear-gradient(to bottom,#d66f21 10%,#ea8335 35%,#f58e41 100%);border-radius:5px;color:#fff;font-size:16px;font-family:'Noto Sans JP',sans-serif;width:87%;margin:auto}.exc_pro1 .swiper-slide{margin-bottom:12px}.pdp-v2-modal-overlay{display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background-color:rgba(0,0,0,.9);align-items:center;justify-content:center;opacity:0}.pdp-v2-modal-overlay.active{display:flex;opacity:1}.pdp-v2-modal-container{position:relative;max-width:90%;max-height:90vh;display:flex;align-items:center;justify-content:center}#productImg,.img-fayde{max-width:100%}.pdp-v2-modal-content{display:block;width:100%;height:auto;max-height:90vh;object-fit:contain;box-shadow:0 5px 30px rgba(0,0,0,.5);opacity:1}.pdp-v2-modal-overlay.active .pdp-v2-modal-content{transform:scale(1)}.pdp-v2-modal-close,.pdp-v3-modal-close,.pdp-v4-modal-close{position:absolute;bottom:-40px;right:0;color:#f1f1f1;font-size:40px;font-weight:700;cursor:pointer;line-height:1}.pdp-v2-modal-next{position:absolute;top:50%;right:10px;transform:translateY(-50%);width:45px;height:45px;display:flex;align-items:center;justify-content:center;color:#fff;cursor:pointer;z-index:10001;opacity:0;transition:.3s;filter:drop-shadow(0px 0px 8px rgba(0, 0, 0, 1))}#A,#C,#D,.img-container{position:relative}.pdp-v2-modal-next svg{width:100%;height:100%;stroke-width:1.5}.pdp-v2-modal-overlay:hover .pdp-v2-modal-next{opacity:.8}.pdp-v2-modal-next:hover{opacity:1;transform:translateY(-50%) scale(1.1)}swiper-container{width:100%;height:auto;overflow:hidden;margin-left:auto;margin-right:auto}swiper-slide{font-size:18px;display:flex;justify-content:center;align-items:center;height:auto}swiper-slide img{display:block;width:100%;height:100%;object-fit:cover}:root{--swiper-theme-color:#f58904!important;--swiper-pagination-bullet-width:20px!important;--swiper-pagination-bullet-height:20px!important}.row-slider{display:flex;flex-direction:row;gap:15px}@media(max-width:768px){.download_templete .modal-content.data{width:90%}}@media (max-width:576px){.exc_pro1{padding-bottom:0}input[name=qty]{width:calc(100% - 200px)}#label-qty{justify-content:space-between}.prodate{width:90%;margin:0;font-size:13px;font-weight:500}.exc_pro1 .swiper-slide{margin-bottom:0}.flex-container.btn-container div.flex-item{width:100%!important}.row-slider{display:flex;flex-direction:column;gap:5px}.pdp-v2-thumb-grid,.poster-grid{grid-template-columns:repeat(2,1fr)}.pdp-v2-modal-next{right:5px;width:35px;height:35px}.pdp-v2-modal-close{bottom:-45px}}a.tag-name{padding:2px 5px;background:#f7b516;display:inline-block;margin:5px 5px 5px 0;border:1px solid #f58904;color:#fff;text-decoration:none;border-radius:5px}a.tag-name.active,a.tag-name:hover{background:#fff;color:#f58904}.selected-tag{display:block;animation:1s fade-in}.unselect-tag{display:none;animation:1s fade-out}#productImg,.pc-show{display:block}#lens,.mobile-show{display:none}#B,#C .PC-C-Contents,.Mb-A-Contents{filter:blur(10px);opacity:0;transition:filter .5s ease-out,opacity .5s ease-out}.img-container{display:inline-block}#productImg{height:auto;user-select:none}#lens{position:absolute;border:2px solid rgba(255,255,255,.95);width:180px;height:140px;pointer-events:none;background-repeat:no-repeat;box-shadow:0 6px 18px rgba(0,0,0,.25);z-index:50}@keyframes fade-in{from{opacity:0}to{opacity:1}}@keyframes fade-out{from{opacity:1}to{opacity:0}}.sign{font-size:35px}#date_create4{font-size:22px;font-weight:700;color:red;letter-spacing:-1px;overflow:hidden}#step3 .flex-container.btn-container div.flex-item .ord-btn{width:100%}.flex-container.btn-container{align-items:flex-start}.btn-success{background:#00a300}.repeat input[type=text]{padding:5px 10px;margin-left:-32px;width:-webkit-fill-available}@media screen and (max-width:768px){#A,.mobile-show{display:block}.pc-show{display:none}#A{margin-top:0;opacity:1}#B,#D .Mb-D-Contents,.Mb-A-Contents{filter:blur(10px);opacity:0;transition:filter .5s ease-out,opacity .5s ease-out}}#content_wrapper>h2.feature1,#content_wrapper>h2.feature2,#content_wrapper>h2.feature3,#content_wrapper>h2.feature4{border:unset;padding-left:61px;font-family:IwaUDGoDspPro-Th,sans-serif!important;text-align:left;color:#281600!important;display:block;font-size:21px!important}#content_wrapper>h2.feature1{background:url(/products/images/wappen/feature-wappen-01.webp) 0 center/50px 50px no-repeat!important}#content_wrapper>h2.feature2{background:url(/products/images/wappen/feature-wappen-02.webp) 0 center/50px 50px no-repeat!important}#content_wrapper>h2.feature3{background:url(/products/images/wappen/feature-wappen-03.webp) 0 center/50px 50px no-repeat!important}
    <?= ($_SESSION['lang'] == "kr" ? 'body{font-family: "돋움체",DotumChe,serif!important;}#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}.prodate,.q-detail,.tab-label{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body{font-family: "Prompt", sans-serif!important;}#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}.prodate,.q-detail,.tab-label{font-family: "Prompt", sans-serif!important;}' : '') ?>
  </style>
  <script>
    (function() {
      function css(el, styles) {
        if (!el) return;
        Object.assign(el.style, styles);

        requestAnimationFrame(() => {
          el.style.filter = "blur(0)";
        });
      }

      function cssAll(selector, styles) {
        document.querySelectorAll(selector).forEach(el => css(el, styles));
      }

      document.addEventListener("DOMContentLoaded", function() {

        // if (window.innerWidth < 768) {
        //   // ===== MOBILE =====

        //   css(document.getElementById("B"), {
        //     filter: "blur(10px)",
        //     opacity: "0",
        //     transition: "filter 0.8s ease-out, opacity 0.8s ease-out"
        //   });

        //   setTimeout(() => {
        //     css(document.getElementById("B"), {
        //       filter: "blur(0px)",
        //       opacity: "1"
        //     });
        //   }, 400);

        //   setTimeout(() => {
        //     cssAll(".Mb-D-Contents", {
        //       filter: "blur(10px)",
        //       opacity: "0",
        //       transform: "translateY(50px)",
        //       transition: "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
        //     });

        //     setTimeout(() => {
        //       cssAll(".Mb-D-Contents", {
        //         filter: "blur(0px)",
        //         opacity: "1",
        //         transform: "translateY(0)"
        //       });
        //     }, 200);

        //   }, 600);

        //   cssAll(".Mb-A-Contents", {
        //     filter: "blur(0px)",
        //     opacity: "1",
        //     transform: "translateY(0)"
        //   });

        // } else {
        //   // ===== DESKTOP =====

        //   css(document.getElementById("B"), {
        //     filter: "blur(10px)",
        //     opacity: "0",
        //     transition: "filter 0.8s ease-out, opacity 0.8s ease-out"
        //   });

        //   setTimeout(() => {
        //     css(document.getElementById("B"), {
        //       filter: "blur(0px)",
        //       opacity: "1"
        //     });
        //   }, 200);

        //   setTimeout(() => {
        //     cssAll(".PC-C-Contents", {
        //       filter: "blur(10px)",
        //       opacity: "0",
        //       transform: "translateY(400px)",
        //       transition: "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
        //     });

        //     setTimeout(() => {
        //       cssAll(".PC-C-Contents", {
        //         filter: "blur(0px)",
        //         opacity: "1",
        //         transform: "translateY(0)"
        //       });
        //     }, 200);

        //   }, 600);

        //   setTimeout(() => {
        //     cssAll(".Mb-A-Contents", {
        //       filter: "blur(10px)",
        //       opacity: "0",
        //       transform: "translateY(-100px)",
        //       transition: "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
        //     });

        //     setTimeout(() => {
        //       cssAll(".Mb-A-Contents", {
        //         filter: "blur(0px)",
        //         opacity: "1",
        //         transform: "translateY(0)"
        //       });
        //     }, 200);
        //   }, 400);
        // }

      });
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
        <h1 class=""><?= lang('オリジナルデザインでお守りアクリルキーホルダーをご製作！') ?></h1>
        <div class="social-time ">
          <span class="social-content">
            <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0A光の角度で色が変わる！お守りアクリルキーホルダー剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/aurora.php" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a><a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0A光の角度で色が変わる！お守りアクリルキーホルダー剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現%0A%0A詳細はこちら:https://hotmobily.jp/products/acrylic/aurora.php" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
            <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2faurora.php" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2facrylic%2faurora.php&amp;text=光の角度で色が変わる！お守りアクリルキーホルダー剥がれない印刷。丈夫なアクキー。激安価格で、小ロット、短納期を実現" target="_blank"><i class="fab fa-twitter-square"></i></a>
          </span>
          <span class="time-content">更新日 2026年6月5日</span>
        </div>
      </div>

      <div id="">
        <img src="/products/images/banner-_omamoti-service.webp" alt="オリジナルデザインでお守りアクリルキーホルダーをご製作！" width="771" height="390" />
      </div>

      <div>&nbsp;</div>

      <div class="" id="">
        <div class="flex-container">

          <div class="flex-item item">
            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
                <swiper-slide><img onclick="openSimpleModal(this)" src="/products/images/omamoris_acrylic.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img onclick="openSimpleModal(this)" src="/products/images/acrylic_omamori-02.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img onclick="openSimpleModal(this)" src="/products/images/acrylic_omamori-03.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img onclick="openSimpleModal(this)" src="/products/images/acrylic_omamori-04.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img onclick="openSimpleModal(this)" src="/products/images/acrylic_omamori-05.webp?dd=<?php echo date('is') ?>"></swiper-slide>
            </swiper-container>
          </div>
          <div class="flex-item item new-text" style="display:grid;align-content: center;line-height: 2;">
            <h2 style="margin-top: 0px;"><?= lang('新しいかたちのお守り！お守りアクリルキーホルダー！') ?></h2><br>
            <p class="new-text">
            従来のお守りの概念をアップデートした、オリジナルお守りアクリルキーホルダーを1個から制作可能です。神社・仏閣のお客様向けの授与品としてはもちろん、推し活・オタク向けグッズとしても大人気のアイテムです。<br><br>
            お守り紐は、伝統的な叶結びタイプ、可愛らしい鈴付きタイプの2種類をご用意。オリジナルデザインと組み合わせれば、開運祈願・ご利益訴求・推し活シーンにもマッチする、他にはない特別なお守りグッズが作れます。
            </p>
          </div>
        </div>
      </div>

        <h2><?= lang('お守りは布製だけじゃない！アクリルという選択肢') ?></h2>
        <div>
            <!-- <div>
                <img src="/products/images/all_omamoris.webp" alt="" width="771" height="auto" />
            </div> -->
            <br>
            <p class="new-text">お守りといえば布製のお守りを連想する方が多いですが、「お守りアクリルキーホルダー」という選択肢もあります。見た目の印象やデザインのバラエティが布製のお守りとは全く異なるので、「従来のお守りとは違ったお守りを作りたい」とお考えの神社・仏閣関係の方に自信を持っておすすめできます。</p>
            <br>

            <div class="row-slider">
                <div class="flex-item item">
                    <div style="text-align:center;"></div>
                    <img loading="lazy" onclick="openSimpleModal2(this)" src="/products/images/acrylic_omamori-06.webp" alt="" class="img-fayde">
                    <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                    </div>
                </div>

                <div class="flex-item item">
                    <div style="text-align:center;"></div>
                    <img loading="lazy" onclick="openSimpleModal2(this)" src="/products/images/acrylic_omamori-07.webp" alt="" class="img-fayde">
                    <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                    </div>
                </div>
            </div>

            <br>
            <p class="new-text">アニメキャラやアイドル、Vtuberなど「推し」の魅力を詰め込んだグッズとしても、当社のお守りアクリルキーホルダーは大活躍間違いなし。キャラクターのイラストやアイドルの写真をデザインすれば、思わず手に取りたくなる「推し守り」に早変わり。ファンの心をしっかりつかむ、特別感あふれるオリジナルグッズが作れます。</p>
            <br>

            <div class="row-slider">
                <div class="flex-item item">
                    <div style="text-align:center;"></div>
                    <img loading="lazy" onclick="openSimpleModal2(this)" src="/products/images/acrylic_omamori-08.webp" alt="" class="img-fayde">
                    <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                    </div>
                </div>

                <div class="flex-item item">
                    <div style="text-align:center;"></div>
                    <img loading="lazy" onclick="openSimpleModal2(this)" src="/products/images/acrylic_omamori-09.webp" alt="" class="img-fayde">
                    <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>

        <h2><?= lang('叶結びか、鈴付きか選べる！') ?></h2>
        <div>
            <p class="new-text">お守りアクキーに付ける紐は、叶結びタイプと鈴付きタイプの両方をご用意しております。なお、アクリル部分のサイズが、叶結びをご選択頂いた場合には縦75mm・横50mm、鈴付きタイプをご選択頂いた場合には縦70mm・横42mmになります。どちらをお選び頂いても、料金は変わりません。</p>
            <br>

            <div class="row-slider">
                <div class="flex-item item">
                    <div style="text-align:center;" class="new-text">叶結び</div>
                    <img loading="lazy" onclick="openSimpleModal2(this)" src="/products/images/acrylic_omamori-02.webp" alt="" class="img-fayde">
                    <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                    </div>
                </div>

                <div class="flex-item item">
                    <div style="text-align:center;" class="new-text">鈴付き</div>
                    <img loading="lazy" onclick="openSimpleModal2(this)" src="/products/images/acrylic_omamori-03.webp" alt="" class="img-fayde">
                    <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>

        <h2>オーロラ加工を付けることも可能！</h2>
        <div class="flex-container">
            <div class="flex-item item">
                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
                    <swiper-slide><img loading="lazy" onclick="openSimpleModal(this)" src="/products/images/acrylic_omamori-04.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                    <swiper-slide><img loading="lazy" onclick="openSimpleModal(this)" src="/products/images/acrylic_omamori-05.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                </swiper-container>
            </div>
            <div class="flex-item item new-text" style="line-height: 2;">
                <p class="new-text">当店のオリジナルお守りアクリルキーホルダーは、より特別感を演出できるオーロラ加工にも対応しています。オーロラ加工とは、光の加減や見る角度によってアクリル板がブルー・オレンジ・イエローなど多彩に変化する人気の特殊加工です。</p><br>
                <p class="new-text">手に取るたびに印象が変わるため、</p><br>
                <p class="new-text">・神社・仏閣の限定授与品</p>
                <p class="new-text">・推し活・キャラクターグッズのレア感演出</p>
                <p class="new-text">・記念品・イベント物販の特別仕様</p>
                <br>
                <p class="new-text">としても最適です。他にはない輝きで、ワンランク上のお守りアクキーを制作できます。</p>
            </div>
        </div>
     

      <h2><?= lang('お守りアクリルキーホルダーの製作事例') ?></h2>
      <div class="ex-row">
        <div class="swiper-button-prev"></div>
        <div class="swiper-container swiper2">
          <div class="swiper-wrapper swiper-bt">

            <div class="swiper-slide">
              <div class="prodate">必勝祈願お守り</div>
              <a href="/products/images/acrylic_omamori-10.webp" data-lightbox="acrylic_swiper15" style="text-decoration:none;" data-title="">
                <img loading="lazy" src="/products/images/acrylic_omamori-10.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/acrylic_omamori-11.webp" data-lightbox="acrylic_swiper15" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">金運招来お守り</div>
              <a href="/products/images/acrylic_omamori-12.webp" data-lightbox="acrylic_swiper16" style="text-decoration:none;" data-title="">
                <img loading="lazy" src="/products/images/acrylic_omamori-12.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/acrylic_omamori-13.webp" data-lightbox="acrylic_swiper16" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">開運招福お守り</div>
              <a href="/products/images/acrylic_omamori-14.webp" data-lightbox="acrylic_swiper1" style="text-decoration:none;" data-title="">
                <img loading="lazy" src="/products/images/acrylic_omamori-14.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/acrylic_omamori-15.webp" data-lightbox="acrylic_swiper1" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">アイドルお守り</div>
              <a href="/products/images/acrylic_omamori-16.webp" data-lightbox="acrylic_swiper17" style="text-decoration:none;" data-title="">
                <img loading="lazy" src="/products/images/acrylic_omamori-16.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/acrylic_omamori-17.webp" data-lightbox="acrylic_swiper17" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">アニメキャラお守り</div>
              <a href="/products/images/acrylic_omamori-18.webp" data-lightbox="acrylic_swiper19" style="text-decoration:none;" data-title="">
                <img loading="lazy" src="/products/images/acrylic_omamori-18.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/acrylic_omamori-19.webp" data-lightbox="acrylic_swiper19" data-title=""></a>
            </div>

            <div class="swiper-slide">
              <div class="prodate">オーロラ加工お守り</div>
              <a href="/products/images/acrylic_omamori-20.webp" data-lightbox="acrylic_swiper21" style="text-decoration:none;" data-title="">
                <img loading="lazy" src="/products/images/acrylic_omamori-20.webp" class="picpro" width="229" height="229">
                <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                </div>
              </a>
              <a href="/products/images/acrylic_omamori-21.webp" data-lightbox="acrylic_swiper21" data-title=""></a>
            </div>
            
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <!-- <div style="text-align: center; margin: 15px auto 0;">
          <a href="/gallery/acrylic_key"><img loading="lazy" class="btn_z" src="/products/images/but3-02.webp" width="266" height="40"></a>
        </div> -->
      </div>

      <h2><?= lang('紐一覧') ?></h2>
      <p class="new-text"><?= lang('写真をクリックすると拡大写真と詳細説明を確認頂けます。') ?></p>
      <div class="exc_pro">
        <div class="swiper-container">
          <div class="row">
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_01.webp" data-lightbox="img-part-set-5" data-title="叶結び・真紅色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_01.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_01.webp" data-lightbox="img-part-set-5-1" data-title="叶結び・真紅色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・真紅色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_02.webp" data-lightbox="img-part-set-6" data-title="叶結び・薄紅色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_02.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_02.webp" data-lightbox="img-part-set-6-1" data-title="叶結び・薄紅色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・薄紅色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_03.webp" data-lightbox="img-part-set-7" data-title="叶結び・あずき色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_03.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_03.webp" data-lightbox="img-part-set-7-1" data-title="叶結び・あずき色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・あずき色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_04.webp" data-lightbox="img-part-set-14" data-title="叶結び・金色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_04.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_04.webp" data-lightbox="img-part-set-14-1" data-title="叶結び・金色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・金色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_05.webp" data-lightbox="img-part-set-4" data-title="叶結び・黄土色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_05.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_05.webp" data-lightbox="img-part-set-4-1" data-title="叶結び・黄土色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・黄土色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_06.webp" data-lightbox="img-part-set-15" data-title="叶結び・青緑色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_06.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_06.webp" data-lightbox="img-part-set-15-1" data-title="叶結び・青緑色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・青緑色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_07.webp" data-lightbox="img-part-set-18" data-title="叶結び・濃紺色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_07.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_07.webp" data-lightbox="img-part-set-18-1" data-title="叶結び・濃紺色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・濃紺色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_08.webp" data-lightbox="img-part-set-16" data-title="叶結び・草緑色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_08.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_08.webp" data-lightbox="img-part-set-16-1" data-title="叶結び・草緑色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・草緑色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_09.webp" data-lightbox="img-part-set-19" data-title="叶結び・軍緑色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_09.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_09.webp" data-lightbox="img-part-set-19-1" data-title="叶結び・軍緑色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・軍緑色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_10.webp" data-lightbox="img-part-set-17" data-title="叶結び・薄紫色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_10.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_10.webp" data-lightbox="img-part-set-17-1" data-title="叶結び・薄紫色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・薄紫色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_11.webp" data-lightbox="img-part-set-20" data-title="叶結び・赤茶色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_11.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_11.webp" data-lightbox="img-part-set-20-1" data-title="叶結び・赤茶色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・赤茶色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_12.webp" data-lightbox="img-part-set-8" data-title="叶結び・茶色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_12.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_12.webp" data-lightbox="img-part-set-8-1" data-title="叶結び・茶色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・茶色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_13.webp" data-lightbox="img-part-set-1" data-title="叶結び・漂泊色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_13.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_13.webp" data-lightbox="img-part-set-1-1" data-title="叶結び・漂泊色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・漂泊色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/kanae_color_14.webp" data-lightbox="img-part-set-2" data-title="叶結び・空色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/kanae_color_14.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/kanae_color_14.webp" data-lightbox="img-part-set-2-1" data-title="叶結び・空色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>叶結び・空色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/Suzu_color01.webp" data-lightbox="img-part-set-3" data-title="鈴付き・赤色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/Suzu_color01.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/Suzu_color01.webp" data-lightbox="img-part-set-3-1" data-title="鈴付き・赤色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>鈴付き・赤色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/Suzu_color02.webp" data-lightbox="img-part-set-9" data-title="鈴付き・桃色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/Suzu_color02.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/Suzu_color02.webp" data-lightbox="img-part-set-9-1" data-title="鈴付き・桃色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>鈴付き・桃色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/Suzu_color03.webp" data-lightbox="img-part-set-10" data-title="鈴付き・黄色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/Suzu_color03.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/Suzu_color03.webp" data-lightbox="img-part-set-10-1" data-title="鈴付き・黄色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>鈴付き・黄色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/Suzu_color04.webp" data-lightbox="img-part-set-11" data-title="鈴付き・橙色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/Suzu_color04.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/Suzu_color04.webp" data-lightbox="img-part-set-11-1" data-title="鈴付き・橙色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>鈴付き・橙色</div>
            </div>
            <div class="mt-10-part">
              <a href="/products/images/Suzu_color05.webp" data-lightbox="img-part-set-12" data-title="鈴付き・水色">
                <img loading="lazy" class="picpro lazy" data-src="/products/images/Suzu_color05.webp" width="229" height="229">
              </a><br>
              <a href="/products/images/Suzu_color05.webp" data-lightbox="img-part-set-12-1" data-title="鈴付き・水色" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
              <div>鈴付き・水色</div>
            </div>
          </div>
        </div>
        <div class="read-more1"><a href="#" class="btn"><img loading="lazy" class="btn_z" src="/products/images/but3-03.webp" width="266" height="40"></a></div>
      </div>
      <hr />
        <div style="clear: both;"></div><br>

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
            <a class="btn-a btn-yellow download" href="/products/acrylic/template/template-acrylic_omamori.zip">
              <span><?= lang('テンプレート') ?></span>
            </a>
            <a class="btn-a btn-yellow" href="javascript:void(0)">
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
      <a class="new-text" href="/contact/?item=お守りアクリルキーホルダー" >無料サンプルの送付をリクエスト</a>

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
                    <div><img loading="lazy" class="lazy" data-src="img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_50mm_20250320.psd">
                    <div><img loading="lazy" class="lazy" data-src="img/psd-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>75×75mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_75mm_20250320.ai">
                    <div><img loading="lazy" class="lazy" data-src="img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_75mm_20250320.psd">
                    <div><img loading="lazy" class="lazy" data-src="img/psd-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?></div>
                  </a>
                </td>
              </tr>
              <tr>
                <td>100×100mm</td>
                <td>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_100mm_20250320.ai">
                    <div><img loading="lazy" class="lazy" data-src="img/ai-icon.webp" width="20" height="20">
                      <?= lang('テンプレートダウンロード') ?>
                    </div>
                  </a>
                  <a class="btn-a btn-yellow" href="../download/download.php?fname=template-acrylic_100mm_20250320.psd">
                    <div><img loading="lazy" class="lazy" data-src="img/psd-icon.webp" width="20" height="20">
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
      <hr  />

        <h2>エッジ加工はCNC加工を採用！</h2>
        <div>
            <div class="img-container">
                <img loading="lazy" id="productImg" src="/products/images/Omamori_acrylic_adge_900_600.webp" alt="エッジ加工はCNC加工を採用！" width="771" height="auto" />
                <div id="lens" aria-hidden="true"></div>
            </div>
           
            <small>マウスを合わせて拡大</small>
            <br><br>
            <p class="new-text">アクリル製品のエッジのカットは通常レーザーが多く、カットした後に違和感のある盛り上がりができてしまいます。当店の製品はCNC加工機を使い、全ての製品の面取りをしていますので、見た目もきれいで手で触ってもなめらかです。<a href="/products/acrylic/roundededge">CNCカットの詳細はこちら。</a></p>
        </div>
        <div style="clear: both;"></div>
 

        <h2>保護フィルムでデザインを保護！はがれない印刷</h2>
        <div>
            <div class="videoWrapper">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/aWzdrxdejyU?si=yXAvWdpecxvarbJH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div>
            <br>
            <p class="new-text">印刷面の全面をPETフィルムで保護しておりますので、デザインの印刷がはがれません。しかも、印刷部分だけを保護するのではなく、面全体を透明シートで保護しますので、PETフィルムが目立つことなく、自然な仕上がりの製品となります。<a href="/products/acrylic/filmcoating">PETフィルムの詳細はこちら</a></p>
            </div>
        </div>

        <hr>
        <div style="clear: both;"></div>

        <h2>入稿データ作成でお困りの方も安心！</h2>
        <div>
            <img loading="lazy" src="/products/images/banner_cutpath-omamori.webp" alt="エッジ加工はCNC加工を採用！" width="771" height="auto" />
            <br><br>
            <p class="new-text">お守りアクリルキーホルダーを製作する際に必要な「カットパス」と「白押さえ」のデータ作成をホットモバイリーオリジナルグッズのプロスタッフが無料で作成します。製作開始前に図面を 確認できますので、お客様のご納得のいくまで何度でも修正できます。<a href="/products/acrylic/cutline_white" class="new-text">当サービスの詳細はこちら。</a></p>
            <br>
            <p class="new-text">なお、「白押さえなども含め自分で入稿データを作成したい」という方向けに、Adobe illustratorで編集可能な入稿データ作成のテンプレート（AIデータ）をご用意しております。</p>
            <br><br>
            <a href="/products/acrylic/template/template-acrylic_omamori.zip" class="new-text" download>テンプレートをダウンロード</a>
            <!-- <p class="new-text" style="letter-spacing:0.00em !important;">アクリルキーホルダーを製作する際に必要な「カットパス」と「白押さえ」のデータ作成を HOTMOBILYオリジナルグッズのプロスタッフが無料で作成します。製作開始前に図面を 確認できますので、お客様のご納得のいくまで何度でも修正できます。<a href="/products/acrylic/cutline_white">当サービスの詳細はこちら。</a></p> -->
            <!-- <p class="new-text">アクリルキーホルダーを製作する際に必要な「カットパス」と「白押さえ」のデータ作成をホットモバイリーオリジナルグッズのプロスタッフが無料で作成します。製作開始前に図面を 確認できますので、お客様のご納得のいくまで何度でも修正できます。<a href="/products/acrylic/cutline_white">当サービスの詳細はこちら。</a></p> -->
        </div>

        <hr>
        <div style="clear: both;"></div>
        <?php 
            $product_key = "omamori-keyholder";
            include("four_reason-v2.php") 
        ?>

        <!-- <div style="clear: both;"></div>
        <h2 style="margin-top: 5px;"><?= lang('入稿データ作成方法') ?></h2>
        <a href="https://hotmobily.jp/products/data-acrylic.php" target="_blank"><img loading="lazy" class="lazy" data-src="img/banner_design_data.webp" width="770" height="388"></a>
        <hr> -->

      <?php $page = 'product';
      include('../../campaign_2021.php'); ?>
      <?php //include('campaign_slide.php'); ?>
      <!-- <img loading="lazy" class="lazy" data-src="img/banner-acrylic.webp" width="770" height="388"> -->
      <!-- <hr /> -->
      <div id="attachments" style="clear: both;"></div>
      <!-- <div class="videoWrapper">
        <img loading="lazy" src="img/ak-yt.webp" data-src="pnKcyfuh4Rw" class="iframe" width="770" height="434">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div> -->
      <!-- <hr /> -->
      <!-- <h2 style="margin-top: 5px;"><?= lang('入稿データ作成方法') ?></h2> -->
      <!-- <a href="https://hotmobily.jp/products/data-acrylic.php" target="_blank"><img loading="lazy" class="lazy" data-src="img/acrylic-data-guide.webp" width="770" height="388"></a> -->
      <?php include("../campaign_news.php"); ?>
      <hr />
      <h2><?= lang('価格表') ?></h2>
      <p class="new-text"><?= lang('納期、印刷・加工タイプごとの注文数別単価表をご用意しております。ご希望の納期・加工タイプを選択してください。<a href="#est-content">見積もり・注文はこちら。</a>') ?></p><br />
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

      <div>
        <h3><?= lang('印刷・加工タイプ') ?></h3>
        <div class="part-container">
          <div class="part-content">
            <label class="part-name"><input type="radio" name="prc_screen" value="1" checked="" onclick="writePriceTable();"><?= lang('片面印刷・オーロラ加工なし') ?> <span class="checkmark"></span></label>
            <label class="part-name"><input type="radio" name="prc_screen" value="2" onclick="writePriceTable();"><?= lang('両面印刷・オーロラ加工なし') ?> <span class="checkmark"></span></label>
            <label class="part-name"><input type="radio" name="prc_screen" value="3" onclick="writePriceTable();"><?= lang('片面印刷・オーロラ加工あり') ?> <span class="checkmark"></span></label>
          </div>
        </div>
      </div>

      <br />
      <h3><?= lang('数量・サイズ別価格表') ?></h3>
      <div class="fixed-thead">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table id="table-price" class="tbl-price tb-w12 blink" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;width: 99%;">
          <thead>
            <tr>
              <td></td>
              <td>75×50mm<?= lang('以内') ?> / 70×42mm以内</td>
              <!-- <td>70×42mm<?= lang('以内') ?></td> -->
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
          <h3 class="red">【<?= lang('お守りアクリルキーホルダー') ?>】</h3>
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
              <!-- <tr>
                <td><?= lang('加工タイプ') ?></td>
                <td><span id="sample-prd-process"></span></td>
              </tr> -->
              <tr>
                <td><?= lang('印刷・加工タイプ') ?></td>
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
            <img loading="lazy" class="lazy" data-src="/products/images/HM_part1-2.webp" id="sample-part-pic" class="picpro" width="320" height="320"><br />
            <span id="sample-part-name"><?= lang('アタッチメント:なし') ?></span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img loading="lazy" class="lazy" data-src="img/coming-soon.webp" style="display: none;" id="sample-paper-pic" class="picpro" width="500" height="500"><br />
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
            <input type="text" name="ItemType" id="strap" value="お守りアクリルキーホルダー" />
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
            case '75x50mm（叶結び紐）':
              $size50 = "checked";
              break;
            case '70x42mm（鈴付き紐）':
              $size75 = "checked";
              break;
            // case '100':
            //   $size100 = "checked";
            //   break;
            default:
              $size50 = "checked";
              break;
          }
          //Setup screen data
          switch ($acy_screen) {
            case '片面印刷・オーロラ加工なし':
              $screen1 = "checked";
              break;
            case '両面印刷：オーロラ加工なし':
              $screen2 = "checked";
              break;
            case '片面印刷・オーロラ加工あり':
                $screen3 = "checked";
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

            <h3>納期</h3>
            <div class="acy_delivery">
              <?php include('../alert-btn.php') ?>
              <div class="part-container">
                <div class="part-content">
                  <label class="part-name"><input type="radio" name="acy_delivery" value="10営業日"  <?= $delivery_10 ?>>10<?= lang('営業日') ?><span class="checkmark"></span></label>
                </div>
                <div class="part-content ">
                  <label class="part-name" <?= $delivery_disabled ?>><input type="radio" name="acy_delivery" value="6営業日"  <?= $delivery_6 ?>>6<?= lang('営業日') ?> <span class="checkmark"></span></label>
                </div>
              </div>
              <h3 style="font-size: 13px;"><i style="color:red" class="fa fa-exclamation-circle" aria-hidden="true"></i>毎営業日正午(昼の12時)までに仕上がりイメージ図のご承認及び製作料金のお支払いの両方が完了した場合、当日が1営業日目となります。それ以降は翌営業日扱いとなります。ご注文日及びデータのご入稿日ではございません。
              </h3>
            </div>

            <h3><?= lang('サイズ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_size" value="75x50mm（叶結び紐）"  <?= $size50 ?>>75x50mm（叶結び紐） <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_size" value="70x42mm（鈴付き紐）"  <?= $size75 ?>>70x42mm（鈴付き紐） <span class="checkmark"></span></label>
              </div>
              <!-- <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_size" value="100" onclick="check_val('next')" <?= $size100 ?>>100x100mm. <span class="checkmark"></span></label>
              </div> -->
            </div>

            <div style="clear: both;"></div><br>

            <!-- <h3><?= lang('加工タイプ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="shape_processing" value="ブルーベース加工" onclick="check_val('next')"> ブルーベース加工 <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="shape_processing" value="ピンクベース加工" onclick="check_val('next')" >ピンクベース加工 <span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_shape_processing"></span>
            </div> -->

            <div style="clear: both;"></div><br>

            <h3><?= lang('印刷・加工タイプ') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_screen" value="片面印刷・オーロラ加工なし" <?= $screen1 ?>><?= lang('片面印刷・オーロラ加工なし') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_screen" value="両面印刷：オーロラ加工なし" <?= $screen2 ?>><?= lang('両面印刷：オーロラ加工なし') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="acy_screen" value="片面印刷・オーロラ加工あり" <?= $screen3 ?>><?= lang('片面印刷・オーロラ加工あり') ?> <span class="checkmark"></span></label>
              </div>
            </div>
            <h3><?= lang('数量') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" value="<?= $qty ?>"></label>
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
                    include('part-omamori.php');
                    // if (date('Y-m-d') >= date('2025-11-01') && date('Y-m-d') <= date('2025-11-16')) {
                    //     include('part-event.php');
                    // } else {
                    //     include('part.php');
                    // }

                  $i = 0;
                  for ($i = 0; $i < count($attachment); $i++) {
                    echo '
										<div class="flex-item type_'.$attachment[$i]["type"].'">
										<label class="part-name">
										<input type="radio" name="acy_part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartDataOmamori(\'' . $attachment[$i]["part_name"] . '\')" ' . ($acy_part == $attachment[$i]["part_name"] ? 'checked' : '') . '>
										<img loading="lazy" class="lazy" data-src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="picpro">
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
                    <input type="checkbox" class="checkbox" name="acy_paper_select" value="あり" onclick="check_val('next')" <?= ($acy_paper_select != "なし" ? ($acy_paper_select != "" ? "checked" : "") : "") ?>>
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
                    <!-- <tr>
                      <td class="TableLeft"><?= lang('加工タイプ') ?></td>
                      <td class="" id="prd_processing" style="text-align: left;"></td>
                    </tr> -->
                    <tr>
                      <td class="TableLeft"><?= lang('印刷・加工タイプ') ?></td>
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
                        <input type="button" class="btn ord-btn btn-success" value="カートに入れる" onclick="if(chk_part()){comSubmit('<?php echo $link . '?mode=MODE_CART' ?>', '_top', form);}">
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
          <td class=""><?= lang('お守りアクリルキーホルダー') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('素材') ?></td>
          <td class=""><?= lang('アクリル板3mm厚') ?></td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('サイズ') ?></td>
          <td class="">75x50mm（叶結び紐） / 70x42mm（鈴付き紐）</td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('印刷仕様') ?></td>
          <td class="">フルカラーUVインクジェット印刷+白押さえが基本となります。<br>片面印刷：UV印刷+白押さえ <br>両面印刷：UV印刷+白押さえ+UV印刷</td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('叶結び紐、鈴付き紐') ?></td>
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
          既製品：50種類のデータから選択可<br>オリジナル印刷：お客様の入稿データを使用し、印刷します<br>支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。
          </td>
        </tr>
        <tr>
          <td class="TableLeft"><?= lang('特徴') ?></td>
          <td class=""><?= lang('印刷面をフィルム保護。CNCカット。') ?></td>
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
        //include '../product-faq-v2.php';
      }
      ?>

      <hr />
      <?php //include('../acrylic-blog.php'); ?>

      <?php
      if (isset($favor) && $favor == 'acrylic') {
        //include '../product-review-v2.php';
      }
      ?>

      <h2><?= lang('アクリルグッズ一覧') ?></h2>
      <br>
      <?php include('acrylic-items-lists.php') ?>

      <h2><?= lang('営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <a href="//hotmobily.jp/meeting_date/"><img loading="lazy" class="lazy" data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82"></a>
      <div style="clear: both">&nbsp;</div>
      <img loading="lazy" src="img/x-banner.webp">
      <div style="clear: both">&nbsp;</div>
      <!-- <div class="flex-container">
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
      </div> -->
    </div>

    <div id="pdp-v3-modal" class="pdp-v2-modal-overlay">
        <div class="pdp-v2-modal-container">
            <span class="pdp-v3-modal-close">&times;</span>
            
            <div class="pdp-v2-modal-prev" id="pdp-v2-modal-prev-btn" onclick="changeModalImage(-1)">
                &#10094; </div>

            <img loading="lazy" class="pdp-v2-modal-content" id="pdp-v3-modal-img" alt="Zoomed view">

            <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn" onclick="changeModalImage(1)">
                &#10095; </div>
        </div>
    </div>

    <div id="pdp-v4-modal" class="pdp-v2-modal-overlay">
        <div class="pdp-v2-modal-container">
          <span class="pdp-v4-modal-close">&times;</span>
          <img loading="lazy" class="pdp-v2-modal-content" id="pdp-v4-modal-img" alt="Zoomed view">

          <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn">
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
  <script type="text/javascript" src="/products/acrylic/js/calculate_omamori_keyholder.js?v=<?php echo date('is') ?>"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
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

<script>
(function() {
  const img = document.getElementById('productImg');
  const lens = document.getElementById('lens');
  const zoom = 2; // change zoom factor (2.2 = 220%)

    // Ensure DOM and image loaded
    function ready(cb) {
        if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', cb);
        } else cb();
    }

    ready(() => {
        if (!img) return console.error('productImg not found');

        // Wait until image is loaded so getBoundingClientRect works and natural sizes are available
        if (!img.complete) {
        img.addEventListener('load', init);
        } else {
        init();
        }
    });

    function init() 
    {
        const lensStyle = getComputedStyle(lens);
        const lensW = parseFloat(lensStyle.width);
        const lensH = parseFloat(lensStyle.height);

        img.addEventListener('mouseenter', () => {
        lens.style.display = 'block';
        lens.style.backgroundImage = `url('${img.src}')`;
        const rect = img.getBoundingClientRect();
            lens.style.backgroundSize = `${rect.width * zoom}px ${rect.height * zoom}px`;
        });

        // Hide on leave
        img.addEventListener('mouseleave', () => {
            lens.style.display = 'none';
        });

        window.addEventListener('resize', () => {
        if (lens.style.display === 'block') {
            const rect = img.getBoundingClientRect();
            lens.style.backgroundSize = `${rect.width * zoom}px ${rect.height * zoom}px`;
        }
        });

        img.addEventListener('mousemove', function(e) {
        const rect = img.getBoundingClientRect();

        let x = e.clientX - rect.left;
        let y = e.clientY - rect.top;

        if (x < 0) x = 0;
        if (y < 0) y = 0;
        if (x > rect.width) x = rect.width;
        if (y > rect.height) y = rect.height;

        let left = x - lensW / 2;
        let top = y - lensH / 2;

        if (left < 0) left = 0;
        if (top < 0) top = 0;
        if (left + lensW > rect.width) left = rect.width - lensW;
        if (top + lensH > rect.height) top = rect.height - lensH;

        lens.style.left = `${left}px`;
        lens.style.top = `${top}px`;

            const bgX = -(x * zoom - lensW / 2);
            const bgY = -(y * zoom - lensH / 2);
            lens.style.backgroundPosition = `${bgX}px ${bgY}px`;
        });
    }
})();


    // Global variables to track the gallery state
    let modalImages = [];     // Stores the list of image sources
    let currentImgIndex = 0;  // Tracks which image is currently showing

    const modal2 = document.getElementById('pdp-v3-modal');
    const modalImg2 = document.getElementById('pdp-v3-modal-img');
    const closeBtn2 = document.getElementsByClassName('pdp-v3-modal-close')[0];

    const modal4 = document.getElementById('pdp-v4-modal');
    const modalImg4 = document.getElementById('pdp-v4-modal-img');
    const closeBtn4 = document.getElementsByClassName('pdp-v4-modal-close')[0];

    function closeModal2() {
        modal2.classList.remove('active');
    }

    closeBtn2.onclick = closeModal2;

    // Close when clicking outside the image
    modal2.onclick = (e) => {
        if (e.target === modal2) closeModal2();
    };


    function closeModal4() {
        modal4.classList.remove('active');
    }

    closeBtn4.onclick = closeModal4;

    // Close when clicking outside the image
    modal4.onclick = (e) => {
        if (e.target === modal4) closeModal4();
    };

    function openSimpleModal(element) {
        const modal = document.getElementById('pdp-v3-modal');
        const modalImg = document.getElementById('pdp-v3-modal-img');
        let clickedSrc = "";

        // 1. Determine the source of the clicked item
        if (element.tagName === 'IMG') {
            clickedSrc = element.src;
        } else {
            const parent = element.closest('.flex-item');
            const img = parent.querySelector('swiper-container img');
            clickedSrc = img ? img.src : "";
        }

        // 2. Scan the Swiper to find ALL images for the gallery
        // We look for the closest swiper-container relative to the clicked element
        const swiperContainer = element.closest('swiper-container') || document.querySelector('.mySwiper');
        
        if (swiperContainer) {
            // Get all images inside the slides
            const images = swiperContainer.querySelectorAll('img');
            modalImages = []; // Reset array
            
            // Populate the array and find the index of the clicked image
            images.forEach((img, index) => {
                modalImages.push(img.src);
                if (img.src === clickedSrc) {
                    currentImgIndex = index;
                }
            });
        } else {
            // Fallback if no swiper found (just show single image)
            modalImages = [clickedSrc];
            currentImgIndex = 0;
        }

        // 3. Open the modal
        if (clickedSrc) {
            modal.classList.add('active');
            updateModalImage(); // Helper function to set src
            
            if (typeof pdpTimer !== 'undefined') clearInterval(pdpTimer);
        }
    }

    // Function to handle Next (1) and Prev (-1) clicks
    function changeModalImage(direction) {
        // Update the index
        currentImgIndex += direction;

        // Loop Logic:
        // If we go past the last image, go back to the first
        if (currentImgIndex >= modalImages.length) {
            currentImgIndex = 0;
        }
        // If we go before the first image, go to the last
        if (currentImgIndex < 0) {
            currentImgIndex = modalImages.length - 1;
        }

        updateModalImage();
    }

    // Helper to actually update the DOM
    function updateModalImage() {
        const modalImg = document.getElementById('pdp-v3-modal-img');
        modalImg.style.opacity = '0.5'; // Optional: fade effect start
        modalImg.src = modalImages[currentImgIndex];
        
        // Simple fade in animation
        setTimeout(() => {
            modalImg.style.opacity = '1';
        }, 100);
    }


    function openSimpleModal2(element) {
        const modal = document.getElementById('pdp-v4-modal');
        const modalImg = document.getElementById('pdp-v4-modal-img');
        let imgSrc = "";

        // 1. Logic to find the image source
        if (element.tagName === 'IMG') {
            // If they clicked the image directly
            imgSrc = element.src;
        } else {
            // If they clicked the 'camera-left' div, find the image in the same block
            const parent = element.closest('.flex-item');
            const img = parent.querySelector('swiper-container img');
            imgSrc = img ? img.src : "";
        }

        // 2. Open the modal if we found a source
        if (imgSrc) {
            modal.classList.add('active');
            modalImg.src = imgSrc;
            modalImg.style.opacity = '1';
            
            // Stop any auto-scrolling sliders if necessary
            if (typeof pdpTimer !== 'undefined') clearInterval(pdpTimer);
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
                        "name": "お守りアクリルキーホルダー",
                        "item": "https://hotmobily.jp/products/acrylic/omamori-keyholder.php"
                    }
                ]
            }
        ]
    </script>
    <!-- /.google script -->
</body>

</html>