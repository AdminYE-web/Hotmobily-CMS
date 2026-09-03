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


// echo "<pre>";
// print_r ($_SESSION);
// echo "</pre>";



// $_SESSION['fd_name'] = 'rubbercoastor';
unset($_SESSION['fd_name']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="オリジナル,クッションポーチ,オリジナルグッズ製作,自社ブランディング,企業グッズ,ロゴ入りグッズ,キャラクターグッズ,社名入り,名入れ,緩衝材ポーチ,防水ポーチ">
  <meta name="description" content="お客様のオリジナルデザインを印刷したクッションポーチ （緩衝材付きポーチ）をご製作！イベント配布用ノベルティや販売用オリジナルグッズ、実用性とオリジナリティを兼ね備えたブランディングツールとして大ウケ間違いなし！カラー・緩衝材を選択可能">
  <meta name="robots" content="index,follow" />
  <title>オリジナルデザインでクッションポーチをご制作！当店だけの特別サービス！</title>
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/products/css/box-shadow.css?v=1.02" rel="stylesheet" type="text/css" />
  <?php include("../../head_products.html"); ?>
  <link rel="preload" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link rel="preload" href="/products/css/product_group.css?v=1.08" as="style" onload="this.onload=null;this.rel='stylesheet'" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../css/scroll.css">
  <link href="/css/modal.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="/css/rubber.css?v=1.06">

  <style type="text/css">
    .prodate,.tag-menu{font-weight:700}#est-content h2,.box-purple,.d-flex .flex-item.w-30>a,.gal-btn,.gal-btn a,.gallbox,.group-container .btn-select,.mt-10-part div,.poster-item,.prodate,.row .mt-10-part,.tab,.thought,.txt-center,swiper-slide{text-align:center}.ballroon2,.tag-menu .tag-name,.unlink,a.btn-details{text-decoration:none!important}.d-inline,.gal-btn a,.tag-menu .tag-name,a.btn-details,h3{display:inline-block}a .ballroon .inner:after,a.ballroon2 .inner:after{content:'';border-top:none;border-left:none;z-index:0}.new-text{font-size:16px!important;letter-spacing:.05em!important;line-height:150%!important}.gal-btn a,.prodate,div.plus{font-size:16px}.preview-sub .hover{max-width:19.87%}.preview-sub .hover img,.preview-top img{width:100%;height:100%}.videoWrapper{margin-top:0}.gall_pro{flex-flow:row wrap;justify-content:flex-start;padding:0;margin-bottom:10px;display:flex}.prodate{padding:0 5px;background:linear-gradient(to bottom,#d66f21 10%,#ea8335 35%,#f58e41 100%);border-radius:5px;color:#fff;width:87%;margin:auto}.ZoomContainer{display:none}.tag-menu .tag-name{padding:2px 12px;background:#f7b516;margin:5px 3px 5px 0;border:1px solid #f58904;color:#fff;border-radius:15px}.tag-menu .tag-name.active,.tag-menu .tag-name:not(.non-active):hover{background:#fff;color:#f58904}.selected-tag{display:block;animation:1s fade-in}.unselect-tag{display:none;animation:1s fade-out}.d-flex,.d-flex2,.thought,swiper-slide{display:flex}.mt-10-part .picpro{width:98%;margin:0}.thought.bg-red:before,.thought:before{width:44px;height:44px;top:-12px;left:28px}@keyframes fade-in{from{opacity:0}to{opacity:1}}@keyframes fade-out{from{opacity:1}to{opacity:0}}.tag-name{font-weight:400}#est-content h2{font-size:25px;color:#000}.gallbox{width:33%}.picpro{border:1px solid #d3d3d3;box-shadow:1px 1px 5px #d3d3d3;margin:5px}.row .mt-10-part{min-width:33%;max-width:33%}.camera-left{width:90%;text-align:left!important}.exc_pro1{position:relative;overflow:hidden;padding-bottom:110px;max-height:230px}.btn-a.btn-orange,.btn-a.btn-yellow{width:80%!important;background-color:#f79647}@media (max-width:576px){.mt-10-part{min-width:32%;max-width:32%}.preview-sub .hover{max-width:19.67%}input[name=numberOf]{width:calc(100% - 200px)}.prodate{width:90%;margin:0;font-size:13px;font-weight:500}#label-qty{justify-content:space-between}.gallbox{width:50%;text-align:left}.gall_pro .gallbox{display:none}.flex-container.b-bottom.p-bottom,.gallbox:first-child,.gallbox:nth-child(2),.gallbox:nth-child(3),.gallbox:nth-child(4),.gallbox:nth-child(5),.gallbox:nth-child(6),.gallbox:nth-child(7),.gallbox:nth-child(8){display:block}.btn-a.btn-orange,.btn-a.btn-yellow{width:100%!important}}.thought.bg-red:after,.thought:after{width:30px;height:30px;bottom:-10px;right:26px}span.tag-name.non-active{background:#2196f3;border:unset;border-radius:2px;padding:2px 16px;margin-bottom:0;font-size:11px}a .ballroon .inner,a.ballroon2 .inner{white-space:nowrap;line-height:1.33;padding:1px 8px}a.btn-details{margin-left:10px;padding:3px 15px;cursor:pointer;color:#595a5a;border-radius:5px;border:1px solid #d3d3d3;transition-duration:.2s}a.btn-details:hover{color:#09f;background:#fff;border:1px solid #09f;transition-duration:.2s}.under-line{text-decoration:underline}.but3{padding:8px 0;border:1px solid #b5b5b5;box-shadow:0 2px 6px #b5b5b5;border-radius:5px;background-image:linear-gradient(#f7f7f7,#dbdbdb);transition:.3s ease-in-out}.but3:hover{opacity:.8;box-shadow:0 2px 6px #666}.feature1{background:url(/products/rubbercoaster/images/coaster_number_1.webp) 0 center/50px 85px no-repeat!important}.feature2{background:url(/products/rubbercoaster/images/coaster_number_2.webp) 0 center/50px 85px no-repeat!important}.feature3{background:url(/products/rubbercoaster/images/coaster_number_3.webp) 0 center/50px 85px no-repeat!important}.feature4{background:url(images/coaster_number_4.webp) 0 center/50px 85px no-repeat!important}.feature1,.feature2,.feature3,.feature4{color:#000!important;line-height:1.5;margin-top:15px!important;min-height:85px;padding-left:66px!important;padding-top:4px!important;font-size:18px!important;display:flex;align-items:center}.thought{background-color:#fff2cc;padding:20px;border-radius:30px;min-width:40px;min-height:40px;margin:20px 20px 100px;position:relative;align-items:center;justify-content:center;font-size:1rem;max-width:100%}.thought:after,.thought:before{content:"";background-color:#fff2cc;border-radius:50%;display:block;position:absolute;z-index:-1}.thought:before{box-shadow:-50px 30px 0 -12px #fff2cc}.thought:after{box-shadow:40px -34px 0 0 #fff2cc,-28px -6px 0 -2px #fff2cc,-24px 17px 0 -6px #fff2cc,-5px 25px 0 -10px #fff2cc}.thought.bg-red{background-color:#f4cccc}.thought.bg-red:after,.thought.bg-red:before{content:"";background-color:#f4cccc;border-radius:50%;display:block;position:absolute;z-index:-1}.thought.bg-red:before{box-shadow:-50px 30px 0 -12px #f4cccc}.thought.bg-red:after{box-shadow:40px -34px 0 0 #f4cccc,-28px -6px 0 -2px #f4cccc,-24px 17px 0 -6px #f4cccc,-5px 25px 0 -10px #f4cccc}.thought.bg-blue{background-color:#cfe2f3}.thought.bg-blue:after,.thought.bg-blue:before{content:"";background-color:#cfe2f3;border-radius:50%;display:block;position:absolute;z-index:-1}.thought.bg-blue:before{width:44px;height:44px;top:-12px;left:28px;box-shadow:-50px 30px 0 -12px #cfe2f3}.thought.bg-blue:after{bottom:-10px;right:26px;width:30px;height:30px;box-shadow:40px -34px 0 0 #cfe2f3,-28px -6px 0 -2px #cfe2f3,-24px 17px 0 -6px #cfe2f3,-5px 25px 0 -10px #cfe2f3}.d-flex{flex-wrap:wrap}.d-flex2{flex-wrap:wrap;justify-content:flex-start;gap:15px}.flex-item{flex:0 0 50%;height:fit-content}.mt-10-part{min-width:23%;max-width:23%}.table-descp td,.table-descp th,.table-descp tr{border:1px solid #000;border-collapse:collapse}.text-orange{color:#f58904}.flex-container{align-items:flex-start;background:#fff}.preview-sub .flex-item.rubber{margin:unset!important;width:100%;height:100%;display:block;background:#fff}.preview-sub{justify-content:flex-start!important}.preview-top div:not(#box-show-id-1){display:block;background:#fff}.preview-sub .flex-item{max-width:32.8%}.preview-sub .flex-item.rubber img{max-height:80px;width:auto}.preview-top>div.rubber img{width:auto;height:100%;display:block;margin-left:auto;margin-right:auto;background:#fff;max-height:237px}swiper-container{width:100%;height:auto;overflow:hidden;margin-left:auto;margin-right:auto}swiper-slide{font-size:18px;background:#fff;justify-content:center;align-items:center;height:auto}swiper-slide img{display:block;width:100%;height:100%;object-fit:cover}:root{--swiper-theme-color:#f58904!important;--swiper-pagination-bullet-width:20px!important;--swiper-pagination-bullet-height:20px!important}table.tbl_price_deli.loading:not(.for_fans) tbody td:not(:first-child){background:linear-gradient(to right,#eee 20%,#ddd 50%,#eee 80%);background-size:500px 100px;animation-name:moving-gradient;animation-duration:1s;animation-iteration-count:infinite;animation-timing-function:linear;animation-fill-mode:forwards}@-webkit-keyframes moving-gradient{0%{background-position:-250px 0}100%{background-position:250px 0}}.table_rubber_final td:last-child{background-color:#fff}.title-orange{margin-bottom:10px}.text-warning{color:#f90}.red-highlight-box{padding:10px;background:#ffb2b2;margin:10px 0;line-height:2}.modal__inner{width:770px}@media (max-width:576px){.container-cloud .justify-content-between{flex-direction:column;text-align:center}.container-cloud .d-flex.justify-content-between p{margin:0!important}.mt-12{min-width:100%}.table_rubber td:nth-child(odd){width:25%}.flex-item.w-30{flex:0 0 100%!important}.modal__inner{width:95%;padding:1em}}table.cld_tb{margin-top:10px}.d-flex.justify-content-between a.btn{background:#5b9bd5;width:49%;height:35px;text-decoration:none;color:#fff;font-size:20px;text-align:center;line-height:2;border-radius:5px}.d-flex.justify-content-between a.btn:hover{opacity:.8}.d_TEXT1{line-height:1.5}.ballroon{left:100%;position:absolute;top:-16px}a .ballroon .inner{position:relative;background-color:#f90;color:#fff;border:1px solid #8d5500;font-size:10px;border-radius:32px}a .ballroon .inner:after{position:absolute;transform:rotate(65deg);width:6px;height:6px;border-right:1px solid #653d00f5;display:inline-block;border-bottom:1px solid #653d00f5;background-color:#f90;bottom:-3px;left:6%}.table_rubber_final td:nth-child(odd){width:35%;height:50px}.table_rubber_final td:last-child{width:65%}.flex-item .btn{flex:unset}.flex-item.w-30{flex:0 0 30%;margin-bottom:0}.flex-item.w-70{flex:0 0 70%;max-width:68%;margin:auto}.unlink{color:#000!important}#date_create_sample1,#date_create_sample2,#date_create_speed_1,#date_create_speed_2{font-size:22px;font-weight:700;color:red;letter-spacing:-1px;overflow:hidden}.title-orange{font-family:"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","メイリオ",Meiryo,Osaka,"ＭＳ Ｐゴシック","MS PGothic",sans-serif;background:#f58904;padding:3px 3px 3px 10px!important;color:#fff;font-size:20px;display:block}.btn-select img,.flex-item img{width:100%}.flex-item-30{flex:0 0 32%}.d-flex .flex-item.w-30 img{width:auto;max-width:100%;height:150px}.d-flex .flex-item.w-30>a{display:block;position:relative}.group-container{display:flex;justify-content:flex-start;flex-flow:row wrap;margin:10px 0}.group-container .btn-select{width:calc(20% - 6px);border:1px solid #9e9e9e;padding:10px 5px;cursor:pointer;border-radius:3px;transition-duration:.3s;position:relative;margin:4px}.btn-select input[type=radio]{opacity:0;width:0}div.plus{position:absolute;color:#555;border-radius:100%;width:15px;height:15px;background:linear-gradient(to bottom,#f3f5f6 0,#dedfe0 100%);padding:9px;bottom:0;right:20px}.mt-10{max-width:100%}.gal-btn{margin-top:8px}.gal-btn a{background:linear-gradient(to bottom,#f7f7f7 0,#dbdbdb 100%);border:1px solid #bab7b6;border-radius:5px;box-shadow:0 3.5px 0 0 #b5b5b5;color:#333;padding:10px 30px;text-decoration:none;transition:.3s}.gal-btn a:hover{box-shadow:none;transform:translateY(3px)}.group-container .btn-select.active,.group-container .btn-select:hover{border:1px solid #fff;background:#f7b516;color:#fff}.group-container .btn-select.active .top-noted,.group-container .btn-select:hover .top-noted{background:#fff;border:2px solid #1e6077;color:#1e6077}.group-container .btn-select:has(input[type=radio]:checked){border:1px solid #fff;background:#f7b516;color:#fff}.box-purple{color:#a428a5;background:#ff93ff;border-radius:6px;font-size:18px;padding:8px 10px;margin-right:10px;min-width:215px;height:unset}.d-inline{margin-top:13px}.bg-purple th:first-child{background:#ff93ff;color:#9e009f}.tab-container{width:100%;margin:0 auto}.tab-header{display:flex;border-bottom:2px solid #ccc}.tab{flex:1;padding:10px 20px;cursor:pointer;background:#f1f1f1;color:#333;border:1px solid #ccc;border-bottom:none;transition:background .3s;margin-bottom:0!important;margin-top:10px}.tab:not(.active):hover{background:#ddd}.tab.tab-success.active{background:#fff;border-top:3px solid #0d9b0d;font-weight:700}.tab.tab-warning.active{background:#fff;border-top:3px solid #eb772a;font-weight:700}.tab-content{border:1px solid #ccc;padding:20px;background:#fff}@media(max-width:768px){.tbl_price_tg{display:grid}.tbl_price_tg>p{width:100%}.tbl_price_tg div{display:flex;justify-content:center;flex-wrap:wrap;flex-direction:row;align-items:center;align-content:center}.switch_chk{margin:10px}.btn-a.btn-orange,.btn-a.btn-yellow{font-size:16px!important}}.ballroon2,a.ballroon2 .inner:after{position:absolute;display:inline-block}.ballroon2{top:-16px;margin-left:6px;padding:3px 5px;background:#f44336;border-radius:5px;border:1px solid #d3d3d3;transition-duration:.2s;margin-top:12px;color:#fff!important;right:0}a.ballroon2 .inner{position:relative;font-size:14px;border-radius:32px}a.ballroon2 .inner:after{transform:rotate(223deg);width:6px;height:6px;border-right:1px solid #d3d3d3;border-bottom:1px solid #d3d3d3;background-color:#f44336;top:-4.4px;left:0}.repeat input[type=text]{padding:5px 10px;margin-left:-32px;width:-webkit-fill-available}.poster-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;max-width:1000px;margin:auto}.poster-item{background:#fff;border-radius:unset;overflow:hidden;transition:transform .3s}.poster-item img{width:100%;height:auto;display:block}.poster-caption{padding:10px;font-size:14px;color:#555}h2.feature1{background:url(/products/images/wappen/feature-wappen-01.webp) 0 center/50px 50px no-repeat!important}h2.feature2{background:url(/products/images/wappen/feature-wappen-02.webp) 0 center/50px 50px no-repeat!important}h2.feature3{background:url(/products/images/wappen/feature-wappen-03.webp) 0 center/50px 50px no-repeat!important}.fw-bold{font-family:IwaUDGoDspPro-Bd,sans-serif!important;font-weight:700}@media (max-width:768px){.d-flex2{justify-content:center}.flex-item{flex-basis:100%;max-width:100%}.thought{margin-bottom:0}.poster-grid{grid-template-columns:repeat(2,1fr)}}
    
    .shape-options {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
    }

    .shape-options-two {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: start;
    }

    .shape-options input[type="radio"], .shape-options-two input[type="radio"] {
        display: none;
    }

    .shape-card {
        width: 150px;
        background: #e6f2f5;
        border: #f0f0f0 2px solid;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
        padding: 20px 10px;
    }

    .shape-card img {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .shape-card span {
        display: block;
        font-weight: bold;
        margin-top: 10px;
    }

    .shape-options input[type="radio"]:checked + .shape-card, .shape-options-two input[type="radio"]:checked + .shape-card {
        border-color: #ffffff;
        background: #f7b516;
        color: white;
    }

    #date_create77{
        font-size: 22px;
        font-weight: bold;
        color: red;
        letter-spacing: -1px;
        overflow: hidden;
    }

    .swiper-button-prev, .swiper-button-next{
        display:none;,
    }

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

    @media screen and (max-width: 768px) {
        .swiper-button-prev, .swiper-button-next{
            display:block;,
        }

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

    @media (max-width: 576px) {
        .swiper-button-prev, .swiper-button-next{
            display:block;,
        }
    }

    @media screen and (min-width: 298px) and (max-width: 331px) {
        .shape-options, .shape-options-two{
            justify-content: flex-start;
            gap: 10px;
        }
        .shape-card{
            width: 150px;
        }
    }

    @media screen and (min-width: 332px) and (max-width: 405px) {
        .shape-options, .shape-options-two{
            justify-content: flex-start;
            gap: 10px;
        }
        .shape-card{
            width: 135px;
        }
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
  <link rel="stylesheet" href="../css/lightbox.css">
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

      <h1><?= lang('オリジナルデザインでクッションポーチをご制作！当店だけの特別サービス！') ?></h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/tapestry/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a>
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/tapestry/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2ftapestry%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2ftapestry%2f&amp;text=オリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
      </div>

        <img src="/products/images/pouch/banner_cushion-pouch2.webp?v=1.03" width="771px" height="390px">
        <div>&nbsp;</div>

        <div>
            <p class="new-text">
            お客様のオリジナルデザインを印刷したプチプチしたデザインのクッションポーチ をご製作！クッション付きのPVC製ポーチに希望のデザインをフルカラー印刷できるのは当店のみ！オリジナルグッズ製作や自社ブランディングにぜひご利用ください。
            </p>
        </div>
        <div style="clear:both;"></div>

        <h2>実用性×オリジナリティ！販売グッズやノベルティに</h2>
        <div>
            <img src="/products/images/pouch/Pouchi-01_v2.webp?v=1.03" width="771px" height="390px">
            <br><br>
            <p class="new-text">ポーチ内に入れた持ち物をプチプチとしたデザインのクッションでしっかり保護しながら収納できる高い実用性に加え、自社のロゴやキャラクターを印刷でき、ブランドイメージをそのまま形にできます。イベント配布のノベルティや販売用グッズとして、実用性とオリジナリティを兼ね備えたブランディングツールとして、大活躍間違いなし！</p>
        </div>

        <!-- <div style="clear:both;"></div>
        <h2>ファングッズ・ゲーマーグッズに最適！プレイマットにも</h2>
        <div>
            <div>
                <img src="/products/images/deskmat_900_600_01.webp" alt="" width="771" height="390" />
            </div>
            <br>
            <p class="new-text">オリジナルデザインのデスクマットは、アニメファンやゲーマー向けの定番グッズです。表面にキャラクターやロゴをあざやかに印刷。光学式マウスにも完全対応した高品質マットは実用性も高く、ユーザーに喜ばれます。エンタメ業界の法人様、個人のクリエイター様から人気です。</p>
            <br>
            <div>
                <img src="/products/images/deskmat_900_600_02.webp" alt="" width="771" height="390" />
            </div>
            <br>
            <p class="new-text">カードゲーマー向けのプレイマットとしても製作が可能。オリジナルデザインによってゲームの世界観を演出しつつ、カード配置を明確にするエリアラインでプレイをスムーズに。ユーザーのゲームプレイ体験を特別なものにします。</p>
        </div> -->

        <div style="clear:both;"></div>

        <h2>当店のクッションポーチの特徴！</h2>
        <div>
            <div>
                <h2 class="feature1 new-text">オリジナルデザインの印刷ができるのは当社のみ！</h2>
                <p class="new-text">
                プチプチとしたデザインのクッションポーチにオリジナルのロゴやイラストをフルカラー印刷できるのは当店のみ！自社の社名やブランドロゴ、キャラクターなどが入ったポーチを製作できます。自社だけのオリジナルグッズ製作やブランディングにグッド！
                </p>
                <br>
                <div class="poster-grid">
                    <div class="poster-item">
                        <div>
                            <p class="new-text"></p>
                        </div>
                        <img onclick="openSimpleModal2(this)" src="/products/images/pouch/Pouchi-02.webp" alt="Poster 1" />
                        <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?></div>
                    </div>
                    <div class="poster-item">
                        <div>
                            <p class="new-text"></p>
                        </div>
                        <img onclick="openSimpleModal2(this)" src="/products/images/pouch/Pouchi-03.webp" alt="Poster 2" />
                        <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?></div>
                    </div>
                </div>
                <br>
                <div class="poster-grid">
                    <div class="poster-item">
                        <div>
                            <p class="new-text"></p>
                        </div>
                        <img onclick="openSimpleModal2(this)" src="/products/images/pouch/Pouchi-04.webp" alt="Poster 3" />
                        <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?></div>
                    </div>
                    <div class="poster-item">
                        <div>
                            <p class="new-text"></p>
                        </div>
                        <img onclick="openSimpleModal2(this)" src="/products/images/pouch/Pouchi-05.webp" alt="Poster 4" />
                        <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?></div>
                    </div>
                </div>
            </div>  
            <div>
                <h2 class="feature2 new-text">チャックとクッションでポーチ内の持ち物をしっかり保護！</h2>
                <p class="new-text">
                    簡単にしっかり閉まるチャックと、衝撃から中身を守るクッションで、ポーチの中身を保護します。実用性・機能性が高く、ユーザーに喜ばれること間違いなし！
                </p>
                <br>
                <div>
                    <img onclick="openSimpleModal2(this)" src="/products/images/pouch/Pouchi-06_v2.webp?v=1.03" width="771px" height="390px">
                    <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?></div>
                </div>
            </div>  
            <div>
                <h2 class="feature3 new-text">クッションの形はノーマルとハートの2種類をご用意！</h2>
                <p class="new-text">プチプチとしたクッションのデザインの形は、一般的な丸型と、キュートなハート型をご用意。入れたいデザインやブランドのイメージに合わせてご選択ください。どちらをご選択頂いても料金は変わりません。</p>
                <br>
                <div class="poster-grid">
                    <div class="poster-item">
                        <div>
                            <p class="new-text">丸型</p>
                        </div>
                        <img onclick="openSimpleModal2(this)" src="/products/images/pouch/Pouchi-07.webp" alt="Poster 3" />
                        <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?></div>
                    </div>
                    <div class="poster-item">
                        <div>
                            <p class="new-text">ハート型</p>
                        </div>
                        <img onclick="openSimpleModal2(this)" src="/products/images/pouch/Pouchi-08.webp" alt="Poster 4" />
                        <div class="camera-left" style="text-decoration:none; font-size: 10px; margin: 0; color:#1a0dab;">📷<?= lang('クリックすると拡大します') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>

        <h2><?= lang('制作事例') ?></h2>
        <div class="ex-row">
            <div class="swiper-button-prev"></div>
            <div class="swiper-container swiper2">
                <div class="swiper-wrapper swiper-bt">

                    <div class="swiper-slide">
                    <div class="prodate">ロゴ入れポーチ</div>
                    <a href="/products/images/pouch/Pouchi-09.webp" data-lightbox="acrylic_swiper15" style="text-decoration:none;" data-title="">
                        <img src="/products/images/pouch/Pouchi-09.webp" class="picpro" width="229" height="229">
                        <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                        </div>
                    </a>
                    <a href="/products/images/pouch/Pouchi-10.webp" data-lightbox="acrylic_swiper15" data-title=""></a>
                    </div>

                    <div class="swiper-slide">
                    <div class="prodate">ブランド名入りポーチ</div>
                    <a href="/products/images/pouch/Pouchi-11.webp" data-lightbox="acrylic_swiper16" style="text-decoration:none;" data-title="">
                        <img src="/products/images/pouch/Pouchi-11.webp" class="picpro" width="229" height="229">
                        <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                        </div>
                    </a>
                    <a href="/products/images/pouch/Pouchi-12.web" data-lightbox="acrylic_swiper16" data-title=""></a>
                    </div>

                    <div class="swiper-slide">
                    <div class="prodate">名入れポーチ</div>
                    <a href="/products/images/pouch/Pouchi-13.webp" data-lightbox="acrylic_swiper1" style="text-decoration:none;" data-title="">
                        <img src="/products/images/pouch/Pouchi-13.webp" class="picpro" width="229" height="229">
                        <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                        </div>
                    </a>
                    <a href="/products/images/pouch/Pouchi-14.webp" data-lightbox="acrylic_swiper1" data-title=""></a>
                    </div>

                    <div class="swiper-slide">
                    <div class="prodate">動物の写真入り</div>
                    <a href="/products/images/pouch/Pouchi-15.webp" data-lightbox="acrylic_swiper17" style="text-decoration:none;" data-title="">
                        <img src="/products/images/pouch/Pouchi-15.webp" class="picpro" width="229" height="229">
                        <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                        </div>
                    </a>
                    <a href="/products/images/pouch/Pouchi-16.webp" data-lightbox="acrylic_swiper17" data-title=""></a>
                    </div>

                    <div class="swiper-slide">
                    <div class="prodate">キャラクター</div>
                    <a href="/products/images/pouch/Pouchi-17.webp" data-lightbox="acrylic_swiper18" style="text-decoration:none;" data-title="">
                        <img src="/products/images/pouch/Pouchi-17.webp" class="picpro" width="229" height="229">
                        <div class="camera-left" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?>
                        </div>
                    </a>
                    <a href="/products/images/pouch/Pouchi-18.webp" data-lightbox="acrylic_swiper18" data-title=""></a>
                    </div>

                </div>
            </div>
            <div class="swiper-button-next"></div>
        </div>

        <div style="clear:both;"></div>
        <h2>2種類のサイズをご用意</h2>
        <div>
            <p class="new-text">当店では、小ぶりで可愛い縦100ｃｍ×横150ｃｍ、ボリュームのある縦160ｃｍ×横204ｃｍの2種類のサイズをご用意しております。</p><br>
            <div>
                <img src="/products/images/pouch/Pouchi-19_v2.webp" alt="" width="771" height="390" />
            </div>
        </div>
        <div style="clear:both;"></div>

        <h2>クッションのカラーは5種類！</h2>
        <div>
            <p class="new-text">クッションのカラーは、クリア、ピンク、イエロー、グリーン、パープルの5種類をご用意しております。どの色をご選択頂いても料金は変わりません。</p><br>
            <div>
                <img src="/products/images/pouch/Pouchi-20_v2.webp" alt="" width="771" height="390" />
            </div>
        </div>

        <div style="clear:both;"></div>
        <h2>制作料金</h2>
        <!-- <div class="new-text">
            <p>注文数量別の税込単価は以下となります。</p><br>
            <table width="100%" class="tb-w12 txt-center" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th scope="col">数量</th>
                        <th scope="col">縦100×横150mm</th>
                        <th scope="col">縦160×横204mm</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">100</td>
                        <td data-label="A2サイズ">1,205</td>
                        <td data-label="B2サイズ">1,000</td>
                    </tr>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">300</td>
                        <td data-label="A2サイズ">1,056</td>
                        <td data-label="B2サイズ">1,000</td>
                    </tr>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">500</td>
                        <td data-label="A2サイズ">999</td>
                        <td data-label="B2サイズ">1,000</td>
                    </tr>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">1000</td>
                        <td data-label="A2サイズ">941</td>
                        <td data-label="B2サイズ">1,000</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <p>最小ロットは100枚です。また、当Webページの注文フォームから注文可能な最大数量は1,000個となっております。1,000個を超える個数のご注文をご希望の方は、個別に<a href="/contact">お問い合わせ</a>ください。</p>
        </div> -->

        <div class="new-text">
            <p>注文数量別の税込単価は以下となります。</p><br>
            <table width="100%" class="tb-w12 txt-center" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f0f0f0;">
                        <th scope="col">数量</th>
                        <th scope="col">単価</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">100</td>
                        <td data-label="A2サイズ">592</td>
                    </tr>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">300</td>
                        <td data-label="A2サイズ">467</td>
                    </tr>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">500</td>
                        <td data-label="A2サイズ">414</td>
                    </tr>
                    <tr>
                        <td data-label="数量" style="background-color: #f0f0f0;">1000</td>
                        <td data-label="A2サイズ">362</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <p>最小ロットは100枚です。また、当Webページの注文フォームから注文可能な最大数量は1,000個となっております。1,000個を超える個数のご注文をご希望の方は、個別に<a href="/contact">お問い合わせ</a>ください。</p>
        </div>

      <h2><?= lang('納期') ?></h2>
      <div>
        <div>
          <h2>本生産納期</h2>
          <div style="display: flex;">
            <div class="delivery"><span class="btn-a std-btn"><?= lang('通常納期'); ?></span></div>
            <div class="delivery">
              <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('10業日後出荷'); ?></div>
            </div>
          </div>
          <div>&nbsp;</div>

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
        <hr />
        <div>
          <h2>試作納期</h2>
          <div style="display: flex;">
            <div class="delivery"><span class="btn-a" style="background: #66fffe; color: #000;">試作納期</span>
            </div>
            <div class="delivery">
              <div class="tb_06" style="color: #004140;padding: 2px 5px;">7営業日後出荷</div>
            </div>
          </div>
          <div>&nbsp;</div>

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
            <span class="red">※</span><?= lang('お急ぎの場合、営業担当にご相談下さい。出来る限りお客様のご希望に沿うよう対応させていただきます。'); ?><br>
            <span class="red">※</span><?= lang('営業日には、土日祝日を含みません。'); ?><br>
          </span>
        </div>
      </div>
      <div style="clear: both;"></div>

      <h2><?= lang('入稿データ') ?></h2>
      <div>
        <p class="new-text">入稿データ作成についてのご案内及びテンプレートをご用意しております。下記からダウンロードが可能です。</p>
        <br>

        <div style="display:flex; flex-direction:row; justify-content:center; width:100%;">
            <a class="btn-a btn-yellow" href="template/template_puchipuchipouch.ai" target="_blank" download><span><?= lang('入稿データ用テンプレート') ?></span></a>
        </div>
          <br>
        
        <br>
        <p>入稿データはAIデータでの作成をお願いしております。上記の入稿データ作成のご案内・テンプレートもAIデータとなっております。Adobe Illustratorをお持ちでないお客様は、JPG、PNG、PDF等でのご入稿が可能です。</p>
      </div>
      <div style="clear: both;"></div>

      <h2><?= lang('ご注文・見積書作成') ?></h2>
      <?php include('../campaign_banner.php') ?>
      <div>
        <p class="new-text">※一つのデザインにつき一注文となります。複数のデザインがある場合、それぞれのデザインで別々にご注文ください。</p>
        <br>

        <div style="overflow: unset!important;">
          <div class="fixed-contrainer">
            <h3 class="red">【<?= lang('クッションポーチ') ?>】</h3>
            <span class="total-price"><span class="prd_total">0</span>円（<?= lang('税込') ?>）</span>
          </div>
          <div style="clear: both;"></div>
          <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
            <div class="step-box">
              <table class="table_rubber" style="padding: 0">
                <tr>
                  <td><?= lang('サイズ') ?></td>
                  <td><span id="sample-prd-size">-</span></td>
                </tr>
                <tr>
                  <td><?= lang('カラー') ?></td>
                  <td><span id="sample-prd-color">-</span></td>
                </tr>
                <tr>
                  <td><?= lang('クッション') ?></td>
                  <td><span id="sample-air">-</span></td>
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
                <tr>
                  <td><?= lang('OPP個別包装') ?></td>
                  <td><span id="sample-prd-opp">-</span></td>
                </tr>
              </table>
            </div>
            <div class="step-box line2" style="text-align: center;">

            </div>
            <div class="step-box line2" style="text-align: center;">

            </div>
          </div>
          <div class="step-container">
            <div class="step-box step-list">
              <ul>
                <li id="dot-step1" class="active">
                  <div class="step-number">1</div><span class="step-details"><?= lang('サイズ・数量') ?></span>
                </li>
                <li id="dot-step2">
                  <div class="step-number">2</div><span class="step-details"><?= lang('試作品・データトレース') ?></span>
                </li>
                <li id="dot-step3">
                  <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・制作料金') ?></span>
                </li>
              </ul>
            </div>
          </div>
          <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
            <div style="display: table-column;"><input type="text" name="ItemType" id="strap" value="クッションポーチ" /></div>
            <?php
            switch ($ItemPCS) {
              case "ジャガード織タイプ":
                $lsSelected_1pcs = 'checked';
                break;
              case "フルカラータイプ":
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

                <div style="clear: both;"></div><br>
                <h3>サイズ</h3>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name"><input type="radio" name="ItemSize" value="100x150mm" onclick="clearValue();check_val(this);" <?php echo (isset($ItemSize) ? ($ItemSize == "100x150mm" ? "checked" : "") : "checked") ?>>縦100x横150mm <span class="checkmark"></span></label>
                    </div>
                    <div class="part-content">
                        <label class="part-name"><input type="radio" name="ItemSize" value="160x204mm" onclick="clearValue();check_val(this);" <?php echo (isset($ItemSize) ? ($ItemSize == "160x204mm" ? "checked" : "") : "") ?>>縦160x横204mm<span class="checkmark"></span></label>
                    </div>
                </div>
                <!-- <div id="ItemSize-Image">
                    <img src="/products/images/banner_default.jpg" alt="" width="771px" height="390px">
                </div> -->
                <div style="clear: both;"></div><br>

                <div class="part-container" id="section-shape-color">
                    <h3>カラー</h3>
                    <div class="shape-options-two">
                        <div class="move-mb">
                            <label>
                                <input type="radio" class="ItemColors" name="ItemColors" value="クリア" <?php echo (isset($ItemColors) ? ($ItemColors == "クリア" ? "checked" : "") : "checked") ?>>
                                <div class="shape-card">
                                <div><img src="/products/images/pouch/Pouchi_color01.webp" alt=""></div>
                                <span>クリア</span>
                                </div>
                            </label>
                        </div>
                        <div class="move-mb">
                            <label>
                                <input type="radio" class="ItemColors" name="ItemColors" value="ピンク" <?php echo (isset($ItemColors) ? ($ItemColors == "ピンク" ? "checked" : "") : "") ?>>
                                <div class="shape-card">
                                <div><img src="/products/images/pouch/Pouchi_color02.webp" alt=""></div>
                                <span>ピンク</span>
                                </div>
                            </label>
                        </div>
                        <div class="move-mb">
                            <label>
                                <input type="radio" class="ItemColors" name="ItemColors" value="イエロー" <?php echo (isset($ItemColors) ? ($ItemColors == "イエロー" ? "checked" : "") : "") ?>>
                                <div class="shape-card">
                                <div><img src="/products/images/pouch/Pouchi_color03.webp" alt=""></div>
                                <span>イエロー</span>
                                </div>
                            </label>
                        </div>
                        <div class="move-mb">
                            <label>
                                <input type="radio" class="ItemColors" name="ItemColors" value="グリーン" <?php echo (isset($ItemColors) ? ($ItemColors == "グリーン" ? "checked" : "") : "") ?>>
                                <div class="shape-card">
                                <div><img src="/products/images/pouch/Pouchi_color04.webp" alt=""></div>
                                <span>グリーン</span>
                                </div>
                            </label>
                        </div>
                        <div class="move-mb">
                            <label>
                                <input type="radio" class="ItemColors" name="ItemColors" value="パープル" <?php echo (isset($ItemColors) ? ($ItemColors == "パープル" ? "checked" : "") : "") ?>>
                                <div class="shape-card">
                                <div><img src="/products/images/pouch/Pouchi_color05.webp" alt=""></div>
                                <span>パープル</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <span style="color: red" id="error_shape_color"></span>
                </div>
                <div style="clear: both;"></div><br>

                <h3>クッション</h3>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name"><input type="radio" name="air_items" value="丸型" onclick="clearValue();check_val(this);" <?php echo (isset($air_items) ? ($air_items == "丸型" ? "checked" : "") : "checked") ?>>丸型 <span class="checkmark"></span></label>
                    </div>
                    <div class="part-content">
                        <label class="part-name"><input type="radio" name="air_items" value="ハート型" onclick="clearValue();check_val(this);" <?php echo (isset($air_items) ? ($air_items == "ハート型" ? "checked" : "") : "") ?>>ハート型<span class="checkmark"></span></label>
                    </div>
                </div>

                <div style="clear: both;"></div><br>

                <h3><?= lang('ご注文本数') ?></h3>
                <div class="part-container">
                    <div class="part-content">
                        <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="numberOf" id="no_of_order" class="right" onchange="this.value=format_number(this.value);" value="<?php echo $numberOf ?>" style="text-align: right;"><br /></label>
                        <div id="err_numberOf_mess"></div>
                    </div>
                </div>
                <span style="color: red" id="error_message"></span>
            </div>


            <div class="estimate-content" id="step2">
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
                    <?= lang('試作品【13,000円（税込）】') ?>
                  </label>
                  <div class="error" id="sample-error"></div>
                </div>
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
                    <?= lang('データトレース【2,200円(税込)】') ?>
                  </label>
                </div>
              </div>
              <div class="part-container">
                <div class="part-content">
                  <label class="part-name">
                    <div class="switch_off_button b2 switch_off">
                      <input type='hidden' value='なし' name='ItemOPP'>
                      <input type="checkbox" class="checkbox" name="ItemOPP" value="あり" onclick="setToInput();" <?= ($ItemOPP == 'あり' ? 'checked' : '') ?>>
                      <div class="knobs"><span></span></div>
                      <div class="layer"></div>
                    </div>
                    <?= lang('OPP個別包装【＋@8円(税込)】') ?>
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
                        <td class="TableLeft"><?= lang('サイズ') ?></td>
                        <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                      </tr>
                      <tr>
                        <td class="TableLeft"><?= lang('カラー') ?></td>
                        <td class="" id="prd_ItemColors" style="text-align: left;"></td>
                      </tr>
                      <tr>
                        <td class="TableLeft"><?= lang('クッション') ?></td>
                        <td class="" id="prd_air" style="text-align: left;"></td>
                      </tr>
                      <tr>
                        <td class="TableLeft"><?= lang('数量') ?></td>
                        <td class="" id="prd_qty" style="text-align: left;"></td>
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
                        <td class="TableLeft"><?= lang('OPP個別包装') ?></td>
                        <td class="" id="prd_ItemOPP" style="text-align: left;"></td>
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
                      <!-- <tr>
                        <td class="TableLeft"><?= lang('フチ加工') ?></td>
                        <td class=""><input id="coating_shape_price" type="text" name="coating_shape_price" readonly>円</td>
                      </tr> -->
                      <tr>
                        <td class="TableLeft"><?= lang('データトレース') ?></td>
                        <td class=""><input id="prd_trace_price" type="text" name="prd_trace_price" readonly>円</td>
                      </tr>
                      <tr>
                        <td class="TableLeft"><?= lang('試作品') ?></td>
                        <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
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
      </div>
      <div style="clear: both;"></div>

      <!-- <h2><?= lang('当店お守り制作サービスの特徴！') ?></h2>
      <div>
        <h2 class="feature1">注文数が多いほどお得！激安価格でご提供！</h2>
        <p class="new-text">注文数が多いほど、1個あたりの単価をお安くすることが可能です。「大ロットでの制作を検討中だが費用に悩んでいる」という方は、ぜひ当店に制作をお任せください。</p>

        <h2 class="feature2">豊富な紐色数！</h2>
        <p class="new-text">真紅色、薄紅色、金色、青緑色、草緑色、茶色など、計14色の紐色をご用意しております。お客様のオリジナルデザインと合った色をお選びください。</p>
        <br>

        <h2 class="feature3">大ロットにも柔軟にご対応！</h2>
        <p class="new-text">2,000個以上、3,000個以上などの大ロットにもご対応いたします。1,000個を超える数のご注文をご検討の方は、お気軽にお問い合わせください。</p>
        <br>

        <p class="new-text">※1,000個以下であれば、当ページの<a href="javascript:void(0)">注文フォーム</a>からご注文頂けます。</p><br>
        <br>
        <p class="new-text">※1,000個を超える大ロットご注文の方は、<a href="/contact">問い合わせフォーム</a>からご相談ください。お電話でのご相談も承っております。</p>
      </div> -->
      <div style="clear: both;"></div>

      <h2><?= lang('製品仕様・付属品等') ?></h2>
      <div class="new-text">
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td>名称</td>
              <td>クッションポーチ</td>
            </tr>
            <tr>
              <td>素材</td>
              <td>PVC</td>
            </tr>
            <tr>
              <td>サイズ</td>
              <td>縦100×横150mm／縦160×横204mm</td>
            </tr>
            <tr>
              <td>印刷方法</td>
              <td>UVプリント</td>
            </tr>
            <tr>
              <td>最小ロット</td>
              <td>100個</td>
            </tr>
            <tr>
              <td>包装</td>
              <td>まとめ包装、個別OPP包装</td>
            </tr>
            <tr>
              <td>納期</td>
              <td>10営業日後出荷</td>
            </tr>
          </tbody>
        </table>
      </div>


      <!-- End new section --->

      <?php //$page = 'product'; include('../../campaign_2021.php'); 
      ?>

      <?php //include('../../delivery_note.php'); 
      ?>
      <br>

      <?php //include("../campaign_news.php"); 
      ?>


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

    <div id="pdp-v4-modal" class="pdp-v2-modal-overlay">
        <div class="pdp-v2-modal-container">
          <span class="pdp-v4-modal-close">&times;</span>
          <img class="pdp-v2-modal-content" id="pdp-v4-modal-img" alt="Zoomed view">

          <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn">
          </div>
        </div>
    </div>

  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include("../../footer.php"); ?>
  <!--フッター ここまで-->

  <!-- /lightbox2-master -->
  <script src="../js/lightbox.js"></script>
  <script>
    lightbox.option({
      'maxWidth': 750,
      'maxHeight': 750,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <!-- /lightbox2-master -->
  <script src="/js/swiper.min.js"></script>
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.18"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <!-- <script type="text/javascript" src="/products/js/auto-slider.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
  <!-- google script -->
  <!-- リマーケティング タグの Google コード -->
  <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->
  <!-- Swiper JS -->
  <script type="text/javascript" src="/js/calculater_pouch.js?e=<?php echo date('is') ?>"></script>
  <script type="text/javascript" src="/js/pdf_pouch.js?e=<?php echo date('is') ?>"></script>

  <script type="text/javascript">
    $(function() {
      $('#info_div').load('/info/index.php');
    });

    /* <![CDATA[ */
    var google_conversion_id = 1036353231;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */


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

    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "10days"
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

    $("input[name='paper_select']").on('click load', function() {
      $('#sample-paper-pic').attr('data-src',
        '/products/acrylic/img/' + $('input[name="paper"]:checked').val() + '.jpg');
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    });

    $('.preview-sub .flex-item img').on('click mouseenter', function() {
      $(this).parents('.preview-container').find('div.my-gallery div').hide();
      $(this).parents('.preview-container').find('div.my-gallery div#' + $(this).attr('id')).show();
    });

    $('.tbl_price_deli.loading').load("../getdate_disp_coaster_2024", function(data) {
      $('.tbl_price_deli.loading').replaceWith(data);
      $('.tbl_price_deli').removeClass("loading");
    });

    function showTab(tabIndex) {
      const tabs = document.querySelectorAll('.tab');
      const panels = document.querySelectorAll('.tab-panel');

      tabs.forEach((tab, index) => {
        tab.classList.toggle('active', tabIndex === index + 1);
        panels[index].style.display = tabIndex === index + 1 ? 'block' : 'none';
      });
    }


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
  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
  </script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
    </div>
  </noscript>
  <!-- /.google script -->

</body>

</html>