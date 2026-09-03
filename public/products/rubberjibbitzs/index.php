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
  ClearSessionPrice();
}
// エラー出力用
$mrErrMsgList = array();
$msErrFocusCtl = "";

//メイン関数の呼出
Main();

$_SESSION['fd_name'] = 'rubbercoastor';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="ジビッツ,オリジナル,激安,制作">
  <meta name="description" content="オリジナルのデザイン・形状のジビッツを製作できます。100個から制作、短納期。イベントでの配布や商品としての販売、自社ブランドPRのノベルティなど、多彩な活用が可能です。汚れ防止加工もお付けできます。">
  <meta name="robots" content="index,follow" />
  <title>オリジナルラバージビッツを小ロット短納期で製作できます！汚れ防止加工も可能</title>
 <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/products/css/box-shadow.css?v=1.02" rel="stylesheet" type="text/css" />
  <?php include("../../head_products.html"); ?>
  <link rel="preload" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <link rel="preload" href="/products/css/product_group.css?v=1.08" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../css/scroll.css">
  <link href="/css/modal.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="/css/rubber.css?v=1.06">

  <style type="text/css">
    .gal-btn a,.product-txt-sub a{text-decoration:none}.product-txt-sub a,.product-txt-sub h4{font-family:IwaUDGoDspPro-Eb,sans-serif!important}.new-text{font-size:16px!important;letter-spacing:.05em!important;line-height:150%!important}.TableLeft{text-align:left!important}.box-purple,.gal-btn,.gal-btn a{text-align:center}@-webkit-keyframes moving-gradient{0%{background-position:-250px 0}100%{background-position:250px 0}}table.tbl_price_deli.loading:not(.for_fans) tbody td:not(:first-child){background:linear-gradient(to right,#eee 20%,#ddd 50%,#eee 80%);background-size:500px 100px;animation-name:moving-gradient;animation-duration:1s;animation-iteration-count:infinite;animation-timing-function:linear;animation-fill-mode:forwards}a.img-hover img{transition:.3s ease-in-out}a.img-hover:hover img{opacity:.8;box-shadow:1px 1px 6px grey}.product-detail{display:flex;flex-direction:row;flex-wrap:nowrap;justify-content:space-between;align-items:stretch;align-content:center}.product-txt{display:flex;flex-direction:column;justify-content:space-around;flex-wrap:wrap;align-content:flex-end;align-items:flex-start;width:calc(45% - 5px);padding-left:5px}.product-img img,.product-txt-sub{width:100%}.product-txt-sub h4{font-size:16px;background:#fff}.product-txt-sub p{font-size:11px;line-height:1.2;color:#666}.product-img{width:calc(55% - 5px);position:relative}.product-line-group{position:absolute;display:grid;grid-template-rows:repeat(3,1fr);top:0;width:100%;height:100%;align-items:center}.product-line{height:2px;background:#666;position:relative}div#line01{width:55%}div#line02{width:75%}div#line03{width:48%}div#line04{width:86%}div#line05{width:82%}.product-line:before{content:'';position:absolute;right:0;border-radius:10px;width:20px;height:20px;background-color:#ff80006e;animation:2s infinite pulse;transform:translateY(-8.5px) translateX(6.5px)}.product-line:after{content:'';position:absolute;border-radius:10px;width:7px;height:7px;background-color:#ff8000;transform:translateY(-2px)}#A,#C,#D,a.ballroon .inner{position:relative}#line01:after,#line01:before,#line02:after,#line02:before,#line03:after,#line03:before{right:0}#line04:after,#line05:after{left:0}#line04:before,#line05:before{transform:translateY(-8.5px) translateX(-6.5px);left:0}.group-container{display:flex;justify-content:space-between;flex-flow:row wrap;margin:10px 0}.group-container .btn-select{width:calc(24% - 10px);border:1px solid #9e9e9e;text-align:center;margin-bottom:10px;padding:10px 5px;cursor:pointer;border-radius:3px;transition-duration:.3s;position:relative}.btn-select input[type=radio]{opacity:0;width:0}.group-container .btn-select.active,.group-container .btn-select:hover{border:1px solid #fff;background:#f7b516;color:#fff}.group-container .btn-select.active .top-noted,.group-container .btn-select:hover .top-noted{background:#fff;border:2px solid #1e6077;color:#1e6077}@keyframes pulse{0%,100%{opacity:1}50%{opacity:0}}.product-txt-mb{align-content:center}.pc-show{display:block}.mobile-show{display:none}#B,#C .PC-C-Contents,.Mb-A-Contents{filter:blur(10px);opacity:0;transition:filter 1.5s ease-out,opacity 1.5s ease-out}@media(max-width:768px){.tbl_price_tg{display:grid}.tbl_price_tg p{width:100%}.tbl_price_tg div{display:flex;justify-content:center;flex-wrap:wrap;flex-direction:row;align-items:center;align-content:center}.switch_chk{margin:10px}.item-sp{margin-bottom:-55px!important}}@media screen and (max-width:768px){#A,.mobile-show{display:block}.pc-show{display:none}#A{margin-top:0;opacity:1}#B,#D .Mb-D-Contents,.Mb-A-Contents{filter:blur(10px);opacity:0;transition:filter 1.5s ease-out,opacity 1.5s ease-out}}@media(max-width:576px){label.part-name img{width:calc(100% - 5px)!important}#step2 .flex-container{overflow-x:hidden}div.howto+div{font-size:5vw!important}}.modal__inner{width:770px}@media(max-width:546px){.product-detail{flex-wrap:wrap}.product-detail-mb{align-items:center;flex-direction:column-reverse}.product-img-mb{width:100%}.product-img-mb img{width:60%}.product-img-right{display:flex;justify-content:flex-end}.product-txt-mb{width:80%}}.ballroon,.d-inline,.gal-btn a{display:inline-block}@media(max-width:425px){.product-txt-sub{width:95%}.product-txt-sub h4{font-size:14px}.product-txt-sub p{font-size:11px}.modal__inner{width:95%;padding:1em}}table.cld_tb{margin-top:10px}.preview-sub .hover img,.preview-top img{height:auto}.gal-btn{margin-top:8px}.gal-btn a{font-size:16px;background:linear-gradient(to bottom,#f7f7f7 0,#dbdbdb 100%);border:1px solid #bab7b6;border-radius:5px;box-shadow:0 3.5px 0 0 #b5b5b5;color:#333;padding:10px 30px;transition:.3s}.gal-btn a:hover{box-shadow:none;transform:translateY(3px)}#date_create_sample1,#date_create_sample2,#date_create_speed_1,#date_create_speed_2{font-size:22px;font-weight:700;color:red;letter-spacing:-1px;overflow:hidden}.mt-10{max-width:100%}.group-container .btn-select:has(input[type=radio]:checked){border:1px solid #fff;background:#f7b516;color:#fff}.box-purple{color:#a428a5;background:#ff93ff;border-radius:6px;font-size:18px;padding:8px 10px;margin-right:10px;min-width:215px;height:unset}.d-inline{margin-top:13px}.bg-purple th:first-child{background:#ff93ff;color:#9e009f}.ballroon{top:-16px;margin-left:6px;padding:3px 5px;text-decoration:none!important;background:#f44336;border-radius:5px;border:1px solid #d3d3d3;transition-duration:.2s;margin-top:12px;color:#fff!important;right:0;position:absolute}a.ballroon .inner{white-space:nowrap;font-size:14px;border-radius:32px;line-height:1.33;padding:1px 8px}a.ballroon .inner:after{content:'';position:absolute;transform:rotate(223deg);width:6px;height:6px;border-right:1px solid #d3d3d3;display:inline-block;border-bottom:1px solid #d3d3d3;background-color:#f44336;border-top:none;border-left:none;top:-4.4px;left:0;z-index:0}.repeat input[type=text]{padding:5px 10px;margin-left:-32px;width:-webkit-fill-available}#content_wrapper>h2.feature1,#content_wrapper>h2.feature2,#content_wrapper>h2.feature3,#content_wrapper>h2.feature4{margin-top:30px!important;margin-bottom:10px!important;min-height:48px;padding-left:66px!important;padding-top:4px!important;align-items:center;border-bottom:unset!important;font-family:IwaUDGoDspPro-Th,sans-serif!important;line-height:1.8;text-align:left;color:#281600!important;display:block;font-size:21px!important}#content_wrapper>h2.feature1 .red,#content_wrapper>h2.feature2 .red,#content_wrapper>h2.feature3 .red,#content_wrapper>h2.feature4 .red{font-size:29px;font-family:IwaUDGoDspPro-Eb,sans-serif!important}#content_wrapper>h2.feature1{background:url(/products/images/wappen/feature-wappen-01.webp) 0 center/50px 50px no-repeat!important}#content_wrapper>h2.feature2{background:url(/products/images/wappen/feature-wappen-02.webp) 0 center/50px 50px no-repeat!important}#content_wrapper>h2.feature3{background:url(/products/images/wappen/feature-wappen-03.webp) 0 center/50px 50px no-repeat!important}swiper-container{width:100%;height:auto;overflow:hidden;margin-left:auto;margin-right:auto}swiper-slide{text-align:center;font-size:18px;background:#fff;display:flex;justify-content:center;align-items:center;height:auto}swiper-slide img{display:block;width:100%;height:100%;object-fit:cover}:root{--swiper-theme-color:#f58904!important;--swiper-pagination-bullet-width:20px!important;--swiper-pagination-bullet-height:20px!important}

    /* --- MODAL POPUP STYLES --- */
    .pdp-v2-modal-overlay {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity var(--pdp-v2-fade-speed) ease-in-out;
    }

    /* Class added by JS to show modal */
    .pdp-v2-modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .pdp-v2-modal-container {
        position: relative;
        max-width: 90%;
        max-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pdp-v2-modal-content {
        display: block;
        width: 100%;
        height: auto;
        max-height: 90vh;
        object-fit: contain;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.5);
        /* This property handles the slow fade effect */
        transition: opacity var(--pdp-v2-fade-speed) ease-in-out;
        opacity: 1;
    }

    .pdp-v2-modal-overlay.active .pdp-v2-modal-content {
        transform: scale(1);
    }

    .pdp-v2-modal-close,  .pdp-v3-modal-close, .pdp-v4-modal-close{
        position: absolute;
        bottom: -40px;
        right: 0;
        /* Position relative to the container */
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
    }

    .pdp-v2-modal-next {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        cursor: pointer;
        z-index: 10001;
        opacity: 0;
        transition: all 0.3s ease;
        filter: drop-shadow(0px 0px 8px rgba(0, 0, 0, 1));
    }

    .pdp-v2-modal-next svg {
        width: 100%;
        height: 100%;
        stroke-width: 1.5;
    }

    .pdp-v2-modal-overlay:hover .pdp-v2-modal-next {
        opacity: 0.8;
    }

    .pdp-v2-modal-next:hover {
        opacity: 1;
        transform: translateY(-50%) scale(1.1);
    }

    @media(max-width: 768px) 
    {
        .pdp-v2-modal-next {
            right: 5px;
            width: 35px;
            height: 35px;
        }

        .pdp-v2-modal-close {
            bottom: -45px;
        }

        .pdp-v2-thumb-grid {
            grid-template-columns: repeat(2, 1fr);
            /* 2 per row */
        }
    }
    

    <?= ($_SESSION['lang'] == "kr" ? 'body{font-family: "돋움체",DotumChe,serif!important;}#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}.prodate{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body{font-family: "Prompt", sans-serif!important;}#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}.prodate{font-family: "Prompt", sans-serif!important;}' : '') ?>
  
    .resource-button-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 16px;
      margin: 14px 0 22px;
      max-width: 780px;
    }

    .resource-button {
      display: flex;
      align-items: center;
      min-height: 84px;
      padding: 14px 26px;
      border: 1px solid #e5e5e5;
      border-radius: 7px;
      background: #fff;
      color: #233c4a;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .22);
      transition: box-shadow .2s ease, transform .2s ease;
    }

    .resource-button:hover,
    .resource-button:focus {
      color: #233c4a;
      text-decoration: none;
      box-shadow: 0 3px 10px rgba(0, 0, 0, .28);
      transform: translateY(-1px);
    }

    .resource-button svg {
      flex: 0 0 54px;
      width: 54px;
      height: 54px;
      margin-right: 22px;
      stroke: currentColor;
      stroke-width: 1.9;
    }

    .resource-button span {
      color: #0d0d0d;
      font-family: IwaUDGoDspPro-Eb, "Noto Sans JP", "Yu Gothic", sans-serif;
      font-size: 22px;
      font-weight: 800;
      line-height: 1.25;
      letter-spacing: 0;
    }

    @media (max-width: 768px) {
      .resource-button-grid {
        grid-template-columns: 1fr;
        gap: 12px;
      }

      .resource-button {
        min-height: 74px;
        padding: 12px 18px;
      }

      .resource-button svg {
        flex-basis: 44px;
        width: 44px;
        height: 44px;
        margin-right: 16px;
      }

      .resource-button span {
        font-size: 18px;
      }
    }
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
  <noscript>
    <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
    <link href="/products/css/product_group.css?v=1.08" rel="stylesheet" type="text/css" />
  </noscript>
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
    <div id="content_wrapper">
      <?php include("../rubber_info.php"); ?>
      <?php include('../banner-campaign.php') ?>
      <h1><?= lang('ジビッツをオリジナルデザインで制作！汚れ防止加工も可能') ?></h1>
      <div class="social-time">
        <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
      </div>
      <img src="images/jibbitz_banner.webp">
      <div>&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
            <swiper-slide><img onclick="openSimpleModal(this)" src="images/Jibbitzs01.webp"></swiper-slide>
            <swiper-slide><img onclick="openSimpleModal(this)" src="images/Jibbitzs02.webp"></swiper-slide>
            <swiper-slide><img onclick="openSimpleModal(this)" src="images/Jibbitzs03.webp"></swiper-slide>
          </swiper-container>
          <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?>
        </div>
        </div>
        <div class="flex-item item" style="display:grid;line-height: 2;">
          <p>「こんなジビッツチャームを作りたい！」に応える、オーダーメイドのオリジナルラバージビッツ制作を承っております。</p>
          <p>自社生産かつ豊富なラバー製品の制作実績がある当社なら、確かな品質で安心。自社生産のため高品質の特注品を激安で制作できることも強みです。最も良くご注文頂く100個の製作料金は、48,000円（税込）といつでも激安価格で製作しております。</p>
          <p>さらに、業界最短の7営業日で制作が可能。お急ぎの方も安心してご連絡ください。</p>
        </div>
      </div>
      <div style="clear:both;"></div>

        <h2>ラバー製品完全ガイドをご用意！</h2>
        <div>
            <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
        </div>
        <div>
            <p class="new-text">当店のジビッツはラバー製品です。「ラバー製品はどんな特徴があるの？」「ラバー製品でオリジナルグッズを製作するときの注意点って？」などの疑問をお持ちの方もいますよね。</p><br>
            <p class="new-text">そんな方へ向けて、ラバー製品の特徴やラバー製品のデザインの注意点などについての完全ガイドをご用意しました。</p><br>
            <p class="new-text">オリジナルのラバージビッツを最高の仕上がりで製作するのに、ぜひともお役立てください。</p>
            <br>
            <div style="text-align: right;">
                <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
            </div>
        </div>

      <div style="clear:both;"></div>
      <h2><?= lang('当店制作のジビッツ') ?></h2>
      <div class="ex-row">
        <div class="gall_pro">

          <div class="gallbox">
            <div class="prodate">ロゴのジビッツ</div>
            <a href="images/Jibbitz_logo01.webp" data-lightbox="01" data-title="" style="text-decoration:none;">
              <img data-src="images/Jibbitz_logo01.webp" class="picpro" width="100%" height="229" src="images/Jibbitz_logo01.webp"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
            <a href="images/Jibbitz_logo02.webp" data-lightbox="01" data-title="" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">猫のジビッツ</div>
            <a href="images/Jibbitz_cat01.webp" data-lightbox="01" data-title="" style="text-decoration:none;">
              <img data-src="images/Jibbitz_cat01.webp" class="picpro" width="100%" height="229" src="images/Jibbitz_cat01.webp"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
            <a href="images/Jibbitz_cat02.webp" data-lightbox="01" data-title="" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">ドーナツのジビッツ</div>
            <a href="images/Jibbitz_donut01.webp" data-lightbox="01" data-title="" style="text-decoration:none;">
              <img data-src="images/Jibbitz_donut01.webp" class="picpro" width="100%" height="229" src="images/Jibbitz_donut01.webp"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
            <a href="images/Jibbitz_donut02.webp" data-lightbox="01" data-title="" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">花のジビッツ</div>
            <a href="images/Jibbitz_flower01.webp" data-lightbox="01" data-title="" style="text-decoration:none;">
              <img data-src="images/Jibbitz_flower01.webp" class="picpro" width="100%" height="229" src="images/Jibbitz_flower01.webp"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
            <a href="images/Jibbitz_flower02.webp" data-lightbox="01" data-title="" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">クッキーのジビッツ</div>
            <a href="images/Jibbitz_cookie01.webp" data-lightbox="01" data-title="" style="text-decoration:none;">
              <img data-src="images/Jibbitz_cookie01.webp" class="picpro" width="100%" height="229" src="images/Jibbitz_cookie01.webp"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
            <a href="images/Jibbitz_cookie02.webp" data-lightbox="01" data-title="" style="text-decoration:none;"></a>
          </div>

          <div class="gallbox">
            <div class="prodate">犬のジビッツ</div>
            <a href="images/Jibbitz-dog01.webp" data-lightbox="01" data-title="" style="text-decoration:none;">
              <img data-src="images/Jibbitz-dog01.webp" class="picpro" width="100%" height="229" src="images/Jibbitz-dog01.webp"><br>
              <div class="camera-left" style="font-size: 10px;">📷クリックすると拡大します</div>
            </a>
            <a href="images/Jibbitz-dog02.webp" data-lightbox="01" data-title="" style="text-decoration:none;"></a>
          </div>
        </div>
        <!-- <div style="text-align: center; margin: 15px auto 0;">
          <button class="but3" fdprocessedid="oqir7d">
            <a href="/gallery/" style="text-decoration: none; color: black; font-size: 16px; padding: 10px 40px;" class="">もっと製作事例を見る <i class="fas fa-arrow-circle-right"></i></a>
          </button>
        </div> -->
      </div>

      <hr>
      <h2><?= lang('ジビッツとはどんなもの？') ?></h2>
      <p class="new-text">
        ジビッツとは、クロックスなどのシューズに取り付けて楽しむ小さなアクセサリーパーツです。シューズの穴に差し込むだけで、誰でも手軽にクロックスをカスタマイズができるのが最大の魅力。キャラクターや動物、文字、食べ物など、さまざまなデザインで制作できます。手のひらサイズなのに、個性をしっかり表現できる、まさに“小さな主役”といえるのがジビッツアクセサリーです。
      </p>
      <img src="images/Jibbitzs04.webp" width="100%">
      <div style="clear:both;">&nbsp;</div>
      <p class="new-text">
      ジビッツの裏面には、このようにクロックスにジビッツを取り付けるためのパーツが付いています。このパーツをクロックスの穴に差し込み、ジビッツをクロックスに装着します。
      </p>
      <img src="images/Jibbitz-back01.webp" width="100%">
      <hr />
      <h2><?= lang('ラバー製品の制作工程') ?></h2>
      <div class="videoWrapper">
        <img src="/products/img/rubber-production-yt.webp" data-src="5KK0a4b1C9Q" class="iframe" width="773" height="">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <hr>
      <h2>当店ラバージビッツの強み</h2>
      <div>
        <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">ラバー製品の実績多数！</h2>
        <p class="new-text">当店はこれまで、ラバーストラップやラバーキーホルダー、ラバーコースターなど、数多くのラバー製品を制作してまいりました。ラバーのプロである当店が、確かな品質のラバージビッツをお客様のもとにお届けいたします。</p>
        <div>&nbsp;</div>
        <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">汚れ防止加工が可能！</h2>
        <p class="new-text">地面に近い位置で使用するジビッツは、砂や土が付着しがちです。「できるだけ長くきれいに使えるものにしたい」という方向けに、オプションとして汚れ防止加工をご用意しております。</p>
        <p class="new-text">もし汚れが付いても、水洗いで落とせるので、製品を長くきれいに使えます。</p>
        <p class="new-text">一般的な汚れ防止加工は非常に硬く折れ曲がりませんが、当店ラバー製品の汚れ防止加工は柔軟性があり、ラバーの動きについていきます。</p>
        <br>
            <div style="text-align: right;">
                <a href="https://hotmobily.jp/faq/details/rubberstrap/q4" class="new-text">汚れ防止加工の詳細はこちら
                </a>
            </div>
        <div>&nbsp;</div>
        <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">最短7営業日後出荷！</h2>
        <p class="new-text">原稿（デザインデータ）確定日から最短7営業日後に出荷可能です。7営業日後出荷をご希望の場合は、通常納期ではなく、スピード発送納期でご注文ください。</p>
        <p class="new-text">なお、スピード発送納期で対応可能なのは注文数が300個以下の場合です。</p>
      </div>
    <hr>

      <br>
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

            <div class="resource-button-grid">
        <a href="/products/new-template/template-coaster-final.zip" class="resource-button" style="color: #233c4a">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><path d="M12 18v-7"></path><path d="M8.5 14.5 12 18l3.5-3.5"></path></svg>
          <span>入稿データテンプレートをダウンロード</span>
        </a>
        <a href="/products/data" class="resource-button" style="color: #233c4a">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 2.5h13.5v19H6.5A2.5 2.5 0 0 1 4 19V4a1.5 1.5 0 0 1 1-1.5z"></path><path d="M4 19a2.5 2.5 0 0 1 2.5-2.5h12"></path><rect x="8" y="6.5" width="7" height="8" rx=".5"></rect><circle cx="11.5" cy="9.2" r=".9" fill="currentColor" stroke="none"></circle><path d="M11.5 11.5v2.2"></path></svg>
          <span>入稿データ作成のご案内</span>
        </a>
        <a href="/howtoorder/" class="resource-button" style="color: #233c4a">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10.5 6h5.5a2 2 0 0 1 2 2v3.5"></path><polyline points="15 8.5 18 11.5 21 8.5"></polyline><path d="M13.5 18H8a2 2 0 0 1-2-2v-3.5"></path><polyline points="3 15.5 6 12.5 9 15.5"></polyline><circle cx="6" cy="6" r="3.8" fill="currentColor" stroke="none"></circle><text x="6" y="7.6" font-size="4.5" font-family="sans-serif" font-weight="bold" text-anchor="middle" fill="#fff" stroke="none">1</text><circle cx="18" cy="18" r="3.8" fill="currentColor" stroke="none"></circle><text x="18" y="19.6" font-size="4.5" font-family="sans-serif" font-weight="bold" text-anchor="middle" fill="#fff" stroke="none">2</text></svg>
          <span>ご注文の流れ</span>
        </a>
        <a href="/contact/?item=ラバーコースター" class="resource-button" style="color: #233c4a">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
          <span>無料サンプルの送付をリクエスト</span>
        </a>
      </div>
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
        <span class="font_s" style="">
          <span class="sun">※</span><?= lang('お急ぎの場合、営業担当にご相談下さい。出来る限りお客様のご希望に沿うよう対応させていただきます。'); ?><br>
          <span class="sun">※</span><?= lang('営業日には、土日祝日を含みません。'); ?><br>
        </span>
      </div>
      <div style="clear:both;"></div>
      <hr />
      <div style="clear: both;"></div>
      <h2>制作料金・納期一覧</h2>
      <div class="tbl_price_tg" style="position:relative;">
        <p class="new-text">
        下記の表のご納期は、現時点でご注文確定（デザイン確定、お支払い完了）の場合のご納期です。<br/>
        制作料金・納期は、数量や<a href="/products/product-difference.php?data=3">制作プラン</a>によって異なります。<br/><br/>
        制作プランは、スタンダード、スタンダード（スピード発送）、プレミアム、の4つがあります。<br/><br/>
        <a href="/products/product-difference.php?data=3">制作プランの詳細はコチラ</a>
        </p>
        <div>
          <label class="switch_chk"><input type="checkbox" id="tg_unit" onchange="$('.ut_price').toggle();" /><label for="tg_unit"></label><?= lang('単価を表示'); ?></label>
          <label class="switch_chk"><input type="checkbox" id="tg_prdt" onchange="$('.ut_date').toggle();" /><label for="tg_prdt"></label><?= lang('営業日数を表示'); ?></label>
        </div>
      </div>
      
      <div style="clear: both;"></div>
      <?php $unit = [100, 200, 300, 500, 1000, 3000, 5000];  ?>
      <div class="tbl_s cl2" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tbl_price_deli loading">
          <thead>
            <tr>
              <th></th>
              <th colspan="4">スタンダード</th>
              <th colspan="4">プレミアム</th>
            </tr>
            <tr>
              <th rowspan="2">数量</th>
              <th colspan="2">製作料金（税込総額）</th>
              <th colspan="2">当店からの出荷日目安</th>
              <th colspan="2">製作料金（税込総額）</th>
              <th colspan="2">当店からの出荷日目安</th>
            </tr>
            <tr>
              <th>3mm厚</th>
              <th>5mm厚</th>
              <th>量産のみ</th>
              <th>試作込み最短</th>
              <th>3mm厚</th>
              <th>5mm厚</th>
              <th>量産のみ</th>
              <th>試作込み最短</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($unit as $key => $value) {  ?>
              <tr>
                <td><?= $value ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            <?php  } ?>
          </tbody>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スタンダードには裏面印刷代金、トレース代金は含まれておりません。') ?><br>
        ※<?= lang('プレミアムでは、試作品、裏面印刷、トレース代金は無料です。') ?><br>
        ※<?= lang('試作込みの製作日数には、試作品配送日数として1日加算しております。') ?><br><br>
      </div>

      <table class="tbl_price_deli bg-purple">
        <thead>
          <tr>
            <th colspan="5">スタンダード（スピード発送）</th>
          </tr>
          <tr>
            <td rowspan="2">数量</th>
            <td colspan="2">製作料金（税込総額）</th>
            <td colspan="2">当店からの出荷日目安</th>
          </tr>
          <tr>
            <td>3mm厚</th>
            <td>5mm厚</th>
            <td>量産のみ</th>
            <td>試作込み最短</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>100</td>
            <td>
              <div class="tt_price">￥54,300</div>
              <div class="ut_price">￥543</div>
            </td>
            <td>
              <div class="tt_price">￥65,100</div>
              <div class="ut_price">￥651</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>200</td>
            <td>
              <div class="tt_price">￥88,400</div>
              <div class="ut_price">￥442</div>
            </td>
            <td>
              <div class="tt_price">￥106,000</div>
              <div class="ut_price">￥530</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>300</td>
            <td>
              <div class="tt_price">￥101,700</div>
              <div class="ut_price">￥339</div>
            </td>
            <td>
              <div class="tt_price">￥122,100</div>
              <div class="ut_price">￥407</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
        </tbody>
      </table>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは300個となります。') ?><br>
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br>
        ※<?= lang('汚れ防止加工は、スピード発送の対象外です。') ?><br><br>
      </div>

      <!-- <table class="tbl_price_deli for_fans">
        <thead>
          <tr>
            <th></th>
            <th colspan="4">ホットモバイリーファン</th>
          </tr>
          <tr>
            <th rowspan="2">数量</th>
            <th colspan="2">製作料金（税込総額）</th>
            <th colspan="2">当店からの出荷日目安</th>
          </tr>
          <tr>
            <th>3mm厚</th>
            <th>5mm厚</th>
            <th>量産のみ</th>
            <th>試作込み最短</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>10</td>
            <td>
              <div class="tt_price">￥9,900</div>
              <div class="ut_price">￥990</div>
            </td>
            <td>なし</td>
            <td>-</td>
            <td>なし</td>
          </tr>
        </tbody>
      </table> -->
      <!-- <div class="font_s for_fans" style="text-align: right;">※<?= lang('トレース代金は含まれております。') ?><br></div> -->
      <div style="clear: both;"></div>

      <h2><?= lang('お得なセット販売実施中！') ?></h2>
      <div>
        <p class="new-text">複数デザインでのご製作をお考えなら、セット販売がお得です。3種デザインでのセットのご制作であれば、<font color="red">製作単価をお安く</font>いたします。たとえば、1個あたりの製作単価が306円（税込）のとき、通常3個あたりの製作価格は3倍の918円（税込）ですが、3種セット販売なら2.5倍の765円（税込）です。このように、<font color="red">本来3個あたりの価格は「1個あたりの単価×3」となるところが、セット販売なら「1個あたりの単価×2.5」</font>となります。</p>
        <br>
        <p class="new-text" style="letter-spacing: 0.02em !important;">合計金額でいいますと、1種のデザインで300個ご制作の場合、通常は単価306円（税込）×300個で合計91,800円（税込）です。しかし、3種デザインのセット販売で300個ご制作であれば、合計76,500円（税込）になります。この場合、<font color="red">15,300円お得</font>です。</p>
        <br>
        <p class="new-text">セット販売でのご注文をご希望の方は、<a href="/contact/">お問い合わせフォーム</a>からお気軽にお問い合わせください。</p>
      </div>

      <h2><?= lang('ラバー製品の製作プラン') ?></h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/product-difference.php?data=3" target="_blank"><img class="lazy" data-src="/img/top3-banner.webp?v=1.01" width="745" height="450"></a></div>
      <h2><?= lang('納期（製作期間）') ?></h2>
      <div style="clear: both;"></div>
      <?php include('../../delivery_note.php'); ?>
      <!-- <div id="info_div"></div>    -->
      <p class="d_TEXT1 new-text"><?= lang('納期=製作日数+配送日数で計算致します。') ?></p><br />
      <p class="d_TEXT1 new-text">【<?= lang('製作期間') ?>】</p>
      <p class="">◆<?= lang('スタンダード製作期間（単位：営業日。配送日数は含まず）') ?></p>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
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
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">10</td>
          <td align="center">14</td>
          <td align="center">22～</td>
        </tr>
      </table><br />

      ◆<?= lang('スタンダード（スピード発送）製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">300個以下</td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数（試作あり）') ?></td>
          <td align="center">13</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">7</td>
        </tr>
      </table><br />

      ◆<?= lang('プレミアム製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
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
          <td align="center">23</td>
          <td align="center">28</td>
          <td align="center">36～</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
      </table><br />
      <!-- ◆<?= lang('ホットモバイリーファンは納期のご指定は頂けません。') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">10<?= lang('個') ?></td>
        </tr>
        <tr>
          <td><?= lang('試作品製作日数') ?></td>
          <td align="center">対応なし</td>
        </tr>
        <tr>
          <td><?= lang('量産品製作日数(試作あり)') ?></td>
          <td align="center">対応なし</td>
        </tr>
        <tr>
          <td><?= lang('量産のみの製作日数（試作なし）') ?></td>
          <td align="center">約3週間～1ヵ月程度</td>
        </tr>
      </table><br /> -->
      <p class="d_TEXT1 new-text"><a href="javascript:void(0)" class="jump"><?= lang('◆汚れ防止加工') ?></a><br /><?= lang('スタンダード/プレミアム製品製作期間+3～5営業日') ?></p><br />

      <div class="font_s new-text" style="">
        <?= lang('弊社稼働日につきまして、詳しくは<a href="/guide/delivery">こちら</a>をご覧ください。') ?><br /><?= lang('製品生産国中国の長期休暇につきましては、別途定める休日が指定されます。') ?><br /><?= lang('シルク印刷ありでのご注文の場合、+1営業日。') ?><br /><?= lang('色味指定を印刷紙で行う場合、+3営業日。') ?><br /><?= lang('（お客様から印刷紙手配が遅れる場合、この限りではございません）') ?>
      </div>
      <div style="clear: both;">&nbsp;</div>
      <p class="d_TEXT1 new-text">
        【<?= lang('配送日数') ?>】<br /><?= lang('北海道、九州、沖縄は2日。その他地域は1日。（離島等に関しては、別途お問い合わせください。）') ?><br /><?= lang('配送日数は、営業日でなく土日祝も含めた日数となります。') ?>
      </p><br />
      <p class="d_TEXT1 new-text">
        【<?= lang('納期計算例') ?>】<br /><?= lang('スタンダード仕様にて、300個、試作品なしでご注文の場合、') ?><br /><?= lang('・製作期間：10営業日') ?><br /><?= lang('・配送期間：1-2日（配送地域により異なります）') ?><br /><?= lang('となります。') ?>
      </p>
      <div style="clear: both;">&nbsp;</div>
      <div style="margin-top: 10px;"><a href="/campaign/quality_rubberstrap.php"><img data-src="/products/images/banner-quality-2025.webp" class="lazy" width="100%" height="" style="max-width:770px;"></a></div>
      <?php include("../campaign_news.php"); ?>
      <h2>厚労省の定める規格基準に合格した安全性の高い材料を使用</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/foodproducts.php?data=rubberstrap" target="_blank"><img class="lazy" data-src="/img/safety-banner.webp" width="745" height="70"></a></div>
      <div style="clear:both;">&nbsp;</div>
      <div id="est-content">

      <?php include('../campaign_banner.php') ?>

        <h2><?= lang('ご注文・見積書作成') ?></h2>
      </div>
      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('ラバージビッツ') ?>】</h3>
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
                <td><?= lang('サイズ') ?></td>
                <td><span id="sample-prd-size">-</span></td>
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
            <br />
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img data-src="/products/acrylic/img/coming-soon.webp" width="135" height="135" id="sample-paper-pic" class="picpro lazy" style="display: none;"><br />台紙:<span id="sample-paper-name">なし</span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ') ?></span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div><span class="step-details"><?= lang('台紙等') ?></span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;"><input type="text" name="ItemType" id="strap" value="ラバージビッツ" /></div>
          <?php
          switch ($ItemPCS) {
            case "スタンダード":
              $lsSelected_1pcs = 'checked';
              break;
            case "プレミアム":
              $lsSelected_2pcs = 'checked';
              break;
            case "ホットモバイリーファン":
              $lsSelected_3pcs = 'checked';
              break;
            case "スタンダード（スピード7営業日発送）":
              $lsSelected_4pcs = 'checked';
              break;
            case "トリプルベネフィットキャンペーン":
              $lsSelected_0pcs = 'checked';
              break;
          }
          switch ($ItemSize) {
            case "通常（70*70/3mm厚）":
              $tickness0_checked = 'checked';
              break;
            case "ハイインパクト（70*70/5mm厚）":
              $tickness1_checked = 'checked';
              break;
            default:
              $tickness0_checked = 'checked';
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
                <div>&nbsp;</div>
                <div class="flex-container p-bottom">
                  <div class="icon-img"><img class="lazy" data-src="/products/images/icon-hotmobilyfan-pc.webp" width="122" height="122"></div>
                  <div class="icon-text">
                    <h4><?= lang('ラバスト製作の入門プラン。業界最安値であなたの創作意欲に応えます'); ?></h4>
                    <p>
                      <?= lang('10個9,900円（税込)。ラバスト製作の初心者向け入門プランです。ラバストと他の製品の大きな違いは、事前に金型を作る必要があるので、ラバスト独特のデザインに変更しないといけない点です。こういった所を、できる限り小予算で体験して頂いたり、これから本格的にラバストを含めたグッズ製作をやってみようという方を念頭に置いたプランです。'); ?><br /><span class="font_s"><?= lang('・このサービスは、個人のお客様専用のサービスです。<br/>・このサービスをご注文頂くお客様は、ホットモバイリーのツイッター(@GoodsYe)のフォローをお願いしております。<br/>・データトレースも製作料金に含まれますので、どの様なデータでも大丈夫です。<br/>・ご納期の指定はできません。<br/>・見積書、請求書、領収書の発行はできません。WEBサイトからのご注文のみとなります。<br/>ホットモバイリーファンの品質基準は'); ?><a href="https://hotmobily.jp/products/quality.html#quality-check1"><?= lang('スタンダートの品質基準をご覧ください'); ?></a></span>
                    </p>
                    <div>&nbsp;</div>
                  </div>
                </div>
              </div>
            </div>
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_1pcs ?>><?= lang('スタンダード') ?> <span class="checkmark"></span></label></div>
              <div class="part-content" <?= $delivery_disabled ?>><label class="part-name"><input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_4pcs ?>><?= lang('スタンダード（スピード7営業日発送）') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?>><?= lang('プレミアム') ?> <span class="checkmark"></span></label></div>
              <span style="color: red" id="error_pcs"></span>
            </div>
            <h3><?= lang('ベース厚さ') ?></h3><a class="btn-details inline" href="javascript:void(0)" for="modal-4" style="cursor: pointer;" onclick="$('#modal-4').prop('checked',true)">詳細</a>
            <input class="modal-state" id="modal-4" type="checkbox">
            <div class="modal">
              <label class="modal__bg" for="modal-4"></label>
              <div class="modal__inner modal1" style="height: fit-content;"><label class="modal__close" for="modal-4"></label>最下層の厚みは、通常3mmでございます。ハイインパクトの最下層は5mmとなりまして、製品単価はスタンダード+20％増、プレミアム+10％増、となります。
              </div>
            </div>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" id="normal_size" name="ItemSize" value="通常（70*70/3mm厚）" <?php echo $tickness0_checked ?> onclick="clearValue();" /><?= lang('通常（3mm厚）') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" id="big_size" name="ItemSize" value="ハイインパクト（70*70/5mm厚）" <?php echo $tickness1_checked ?> onclick="clearValue();" /><?= lang('ハイインパクト（5mm厚）') ?> <span class="checkmark"></span></label></div>
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
                ※4種類まで可能。各バリエーションの最小ロットは100個です。<br />
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
                    include("../paper_preview.php");
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
                      <td class="TableLeft"><?= lang('サイズ') ?></td>
                      <td class="" id="prd_ItemSize" style="text-align: left;"></td>
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
                  </tbody>
                </table>
              </div>
              <div class="flex-item">
                <h3><?= lang('製作料金') ?></h3>
                <table class="table_rubber total_price_tbl">
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
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
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
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')">アタッチメント・オプション入力へ</a>
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
      
      <div style="clear:both;">&nbsp;</div>
      <div>
        <h2><?= lang('製品仕様・付属品等') ?></h2>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td><?= lang('名称') ?></td>
              <td><?= lang('オリジナルラバージビッツ') ?></td>
            </tr>
            <tr>
              <td><?= lang('素材') ?></td>
              <td><?= lang('ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)。熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細は') ?><a href="/products/foodproducts.php?data=rubbercoaster" target="_blank">こちら</a>。</td>
            </tr>
            <tr>
              <td><?= lang('大きさ') ?></td>
              <td><?= lang('縦90mmX横90mm以内。（このサイズを超える製品は、別途費用がかかります）') ?></td>
            </tr>
            <tr>
              <td><?= lang('厚さ') ?></td>
              <td><?= lang('通常約5～6mm。肉厚指定のある場合、事前にご相談下さい。') ?></td>
            </tr>
            <tr>
              <td><?= lang('色数') ?></td>
              <td><?= lang('スタンダードは12色まで、プレミアムは18色までご使用いただけます。') ?><br>
                <?= lang('印刷物ではないため、グラデーションは表現できません。') ?></td>
            </tr>
            <tr>
              <td><?= lang('色指定') ?></td>
              <td><?= lang('以下2通りのいづれか。①PANTONE(パントーン)もしくは、DIC(ディック)番号によるご指定。②弊社もしくは、お客様が印刷された、色見本（カラーペーパー）によるご指定。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('試作品（実物構成サンプル）') ?></td>
              <td><?= lang('スタンダードの場合、+8,800円（税込）、プレミアムの場合無料。') ?></td>
            </tr>
            <tr>
              <td><?= lang('台紙') ?></td>
              <td><?= lang('オプションとして台紙の封入が可能です。') ?>
                <a href="/products/daishi.html"><?= lang('台紙封入の詳細。') ?></a> <?= lang('支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('最小ロット') ?></td>
              <td>100個</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <h2><?= lang('営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <center><a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a></center>
      </p><br />

      <a href="https://hotmobily.jp/production/"><img data-src="/products/images/banner-production-v2.webp" class="lazy" width="100%" height="194" /></a><br><br />
    </div>
    <!-- :: content_wrapper end :: -->

    <div id="pdp-v3-modal" class="pdp-v2-modal-overlay">
        <div class="pdp-v2-modal-container">
            <span class="pdp-v3-modal-close">&times;</span>
            
            <div class="pdp-v2-modal-prev" id="pdp-v2-modal-prev-btn" onclick="changeModalImage(-1)">
                &#10094; </div>

            <img class="pdp-v2-modal-content" id="pdp-v3-modal-img" alt="Zoomed view">

            <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn" onclick="changeModalImage(1)">
                &#10095; </div>
        </div>
    </div>


  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include("../../footer.php"); ?>
  <!--フッター ここまで-->

  <!-- /lightbox2-master -->
  <script src="js/lightbox.js"></script>
  <script>
    lightbox.option({
      'maxWidth': 750,
      'maxHeight': 750,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <!-- /lightbox2-master -->
  <script type="text/javascript" src="/js/_setToInput_2026.js?v=<?php echo date('is') ?>"></script>
  <script language="JavaScript" src="/js/validation_new.js?v=1.11" type="text/javascript"></script>
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>

  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>

  <script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#open-virus").click(function() {
            $("#slide-virus").slideToggle("slow");
        });

        if ($(window).width() < 768) //Mobile Screen
        {
            // $('#B').fadeIn(1200);

            $("#B").css({
                "filter": "blur(10px)",
                "opacity": "0",
                "transition": "filter 0.8s ease-out, opacity 0.8s ease-out" 
            });

            setTimeout(function () {
                $("#B").css({
                    "filter": "blur(0px)",
                    "opacity": "1"
                });
            }, 200);

            setTimeout(function(){
                $(".Mb-D-Contents").css({
                    "filter": "blur(10px)",
                    "opacity": "0",
                    "transform": "translateY(50px)",
                    "transition": "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
                });

                setTimeout(function () {
                    $(".Mb-D-Contents").css({
                        "filter": "blur(0px)",
                        "opacity": "1",
                        "transform": "translateY(0)"
                    });
                }, 200);

            }, 400);

            setTimeout(function(){
                $(".Mb-A-Contents").css({
                    "filter": "blur(10px)",
                    "opacity": "0",
                    "transform": "translateY(-50px)",
                    "transition": "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
                });

                setTimeout(function () {
                    $(".Mb-A-Contents").css({
                        "filter": "blur(0px)",
                        "opacity": "1",
                        "transform": "translateY(0)"
                    });
                }, 200);
            }, 600);
        }
        else
        {
            // $('#B').fadeIn(1500);

            $("#B").css({
                "filter": "blur(10px)",
                "opacity": "0",
                "transition": "filter 0.8s ease-out, opacity 0.8s ease-out" 
            });

            setTimeout(function () {
                $("#B").css({
                    "filter": "blur(0px)",
                    "opacity": "1"
                });
            }, 200);

            setTimeout(function(){
                $(".PC-C-Contents").css({
                    "filter": "blur(10px)",
                    "opacity": "0",
                    "transform": "translateY(400px)",
                    "transition": "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
                });

                setTimeout(function () {
                    $(".PC-C-Contents").css({
                        "filter": "blur(0px)",
                        "opacity": "1",
                        "transform": "translateY(0)"
                    });
                }, 50);

            }, 400);

            setTimeout(function(){
                $(".Mb-A-Contents").css({
                    "filter": "blur(10px)",
                    "opacity": "0",
                    "transform": "translateY(-100px)",
                    "transition": "filter 0.8s ease-out, opacity 0.8s ease-out, transform 0.8s ease-out"
                });

                setTimeout(function () {
                    $(".Mb-A-Contents").css({
                        "filter": "blur(0px)",
                        "opacity": "1",
                        "transform": "translateY(0)"
                    });
                }, 200);
            }, 600);

            // $("#C").fadeIn('slow', 0, function(){
            //     $("#C").css("opacity", "1").animate({ bottom: "0px" }, 200, "easeOutCubic");
            // });
            
            // setTimeout(function(){
            //     $("#A").fadeIn('slow', 0, function() {
            //         $("#A").css("opacity", "1").animate({ marginTop: "0px" }, 1000, "easeOutCubic");
            //     });
            // }, 1000);
        }
        
    });
    $('.preview-sub img').click(function() {
      var e = $(this).attr('data-embed');
      var r = $(this).attr('data-src');
      if ($('.preview-top').find('img').length) {
        $('.preview-top img').attr('src', r);
        $('.preview-top img').attr('data-src', e);
      } else {
        $('.preview-top iframe').attr('src', 'https://www.youtube.com/embed/' + e);
      }
    });
    $(function() {
      $('#info_div').load('/info/index.php');
      $('.tbl_price_deli.loading').load("../getdate_disp2023", function(data) {
        $('.tbl_price_deli.loading').replaceWith(data);
        $('.tbl_price_deli').removeClass("loading");
      });
    });
    /* <![CDATA[ */
    var google_conversion_id = 1036353231;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
    var tmp = "<?= $_GET['mode'] ?>";
    $(function() {
      var t = $("#i_txt1"),
        s = $("#i_txt2");
      screen.width <= 768 && (t.attr("src", "images/img_txt2_n1.svg"), s.attr("src", "images/text_sample_n1.svg"))
    }, (tmp != "" ? valid_chk_btn('step3') : ""));
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "ラバーキーホルダー"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });
    $("input[name='paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    });

    $.ajax({
      type: "POST",
      url: "../get_sample_date.php",
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
      url: "../get_sample_date.php",
      success: function(data) {
        // console.log(data);
        productionDate2(data.sort());
      },
      dataType: "json"
    });

    $('.jump').click(function(e){
        $('html, body').animate({
            scrollTop: $('#text-coating').offset().top - 100
        }, 800);

        e.preventDefault();
    }); 


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
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".tbl_s").on("click scroll", function() {
        $(this).find(".scroll-center").hide();
      });
    });
  </script>
  <noscript>
    <div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
    </div>
  </noscript>
  <!-- /.google script -->
</body>

</html>