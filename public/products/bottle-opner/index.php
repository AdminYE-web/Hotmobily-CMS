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
  <meta name="keywords" content="ボトルオープナー,名入れ,オリジナル,レーザー彫刻,社名,イベント名,ブランド名,メッセージ,格安,大ロット,小ロット,販促グッズ,ノベルティ,ビールフェス,ビールイベント,ビアフェス,ワインイベント,ワインフェスティバル,お酒,オリジナルグッズ制作">
  <meta name="description" content="社名やブランド名、メッセージ等を名入れしたオリジナルボトルオープナーを1個あたり89円(税込)からご制作！大ロットが格安でお得です！さらに小ロット50個からも注文可能！本体色の基本カラーは赤・青・緑・黒・紫をご用意。お気軽にご注文・ご相談ください。">
  <meta name="robots" content="index,follow" />
  <title>名入れボトルオープナーを制作！大ロットが格安！小ロット注文可能！</title>
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
    .new-text {
      font-size: 16px !important;
      letter-spacing: 0.05em !important;
      line-height: 150% !important;
    }

    .mt-10-part {
      min-width: 23%;
      max-width: 23%
    }

    .mt-10-part div,
    .txt-center {
      text-align: center
    }

    .preview-sub .hover {
      max-width: 19.87%
    }
   .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
}
    .preview-top img,
    .preview-sub .hover img {
      width: 100%;
      height: 100%
    }

    .videoWrapper {
      margin-top: 0
    }

    .gall_pro {
      flex-flow: row wrap;
      justify-content: flex-start;
      padding: 0;
      margin-bottom: 10px;
      display: flex
    }

    .prodate {
      padding: 0 5px;
      text-align: center;
      font-weight: 700;
      background: linear-gradient(to bottom, #d66f21 10%, #ea8335 35%, #f58e41 100%);
      border-radius: 5px;
      color: #fff;
      font-size: 16px;
      width: 87%;
      margin: auto
    }

    .ZoomContainer {
      display: none
    }

    .tag-menu .tag-name {
      padding: 2px 12px;
      background: #f7b516;
      display: inline-block;
      margin: 5px 3px;
      border: 1px solid #f58904;
      color: #fff;
      margin-left: 0;
      text-decoration: none !important;
      border-radius: 15px;
    }

    .tag-menu .tag-name.active,
    .tag-menu .tag-name:not(.non-active):hover {
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
      font-weight: 700
    }

    .tag-name {
      font-weight: 400
    }

    #est-content h2 {
      font-size: 25px;
      text-align: center;
      color: #000
    }

    .gallbox {
      width: 33%;
      text-align: center
    }

    .picpro {
      border: 1px solid lightgray;
      box-shadow: 1px 1px 5px #d3d3d3;
      margin: 5px
    }

    .camera-left {
      width: 90%;
      text-align: left !important
    }

    @media (max-width: 576px) {
      .mt-10-part {
        min-width: 32%;
        max-width: 32%
      }

      .preview-sub .hover {
        max-width: 19.67%
      }

      input[name="numberOf"] {
        width: calc(100% - 200px)
      }

      .prodate {
        width: 90%;
        margin: 0;
        font-size: 13px;
        font-weight: 500
      }

      #label-qty {
        justify-content: space-between
      }

      .gallbox {
        width: 50%;
        text-align: left
      }

      .gall_pro .gallbox {
        display: none
      }

      .gallbox:nth-child(1),
      .gallbox:nth-child(2),
      .gallbox:nth-child(3),
      .gallbox:nth-child(4),
      .gallbox:nth-child(5),
      .gallbox:nth-child(6),
      .gallbox:nth-child(7),
      .gallbox:nth-child(8) {
        display: block
      }

      .flex-container.b-bottom.p-bottom {
        display: block;
      }
    }

    span.tag-name.non-active {
      background: #2196f3;
      border: unset;
      border-radius: 2px;
      padding: 2px 16px;
      margin-bottom: 0;
      font-size: 11px;
    }

    a.btn-details {
      display: inline-block;
      margin-left: 10px;
      padding: 3px 15px;
      text-decoration: none !important;
      cursor: pointer;
      color: #595a5a;
      border-radius: 5px;
      border: 1px solid lightgray;
      transition-duration: .2s
    }

    a.btn-details:hover {
      color: #09f;
      background: #fff;
      border: 1px solid #09f;
      transition-duration: .2s
    }

    h3 {
      display: inline-block
    }

    .under-line {
      font-family: IwaUDGoDspPro-Eb, sans-serif !important;
      text-decoration: underline;
    }

    .but3 {
      padding: 8px 0;
      border: 1px solid #b5b5b5;
      box-shadow: 0px 2px 6px #b5b5b5;
      border-radius: 5px;
      background-image: linear-gradient(#f7f7f7, #dbdbdb);
      transition: all 0.3s ease-in-out;
    }

    .but3:hover {
      opacity: 0.8;
      box-shadow: 0px 2px 6px #666666;
    }

    .feature1 {
      background: transparent url(/products/rubbercoaster/images/coaster_number_1.webp) no-repeat !important;
      background-size: 50px 85px !important;
      background-position: 0px center !important;
    }

    .feature2 {
      background: transparent url(/products/rubbercoaster/images/coaster_number_2.webp) no-repeat !important;
      background-size: 50px 85px !important;
      background-position: 0px center !important;
    }

    .feature3 {
      background: transparent url(images/coaster_number_3.webp) no-repeat !important;
      background-size: 50px 85px !important;
      background-position: 0px center !important;
    }

    .feature4 {
      background: transparent url(images/coaster_number_4.webp) no-repeat !important;
      background-size: 50px 85px !important;
      background-position: 0px center !important;
    }

    .feature1,
    .feature2,
    .feature3,
    .feature4 {
      color: black !important;
      line-height: 1.5;
      margin-top: 30px !important;
      /* margin-bottom: 20px !important; */
      min-height: 85px;
      padding-left: 66px !important;
      padding-top: 4px !important;
      font-size: 18px !important;
      display: flex;
      align-items: center;
      font-size: 20px;
      font-family: IwaUDGoDspPro-Eb, sans-serif !important;
      margin-top: 20px;
    }

    .thought {
      display: flex;
      background-color: #fff2cc;
      padding: 20px;
      border-radius: 30px;
      min-width: 40px;
      min-height: 40px;
      margin: 20px;
      position: relative;
      align-items: center;
      justify-content: center;
      text-align: center;
      font-size: 1rem;
      max-width: 100%;
      margin-bottom: 100px;
    }

    .thought:before,
    .thought:after {
      content: "";
      background-color: #fff2cc;
      border-radius: 50%;
      display: block;
      position: absolute;
      z-index: -1;
    }

    .thought:before {
      width: 44px;
      height: 44px;
      top: -12px;
      left: 28px;
      box-shadow: -50px 30px 0 -12px #fff2cc;
    }

    .thought:after {
      bottom: -10px;
      right: 26px;
      width: 30px;
      height: 30px;
      box-shadow: 40px -34px 0 0 #fff2cc,
        -28px -6px 0 -2px #fff2cc,
        -24px 17px 0 -6px #fff2cc,
        -5px 25px 0 -10px #fff2cc;
    }

    .thought.bg-red {
      background-color: #f4cccc;
    }

    .thought.bg-red:before,
    .thought.bg-red:after {
      content: "";
      background-color: #f4cccc;
      border-radius: 50%;
      display: block;
      position: absolute;
      z-index: -1;
    }

    .thought.bg-red:before {
      width: 44px;
      height: 44px;
      top: -12px;
      left: 28px;
      box-shadow: -50px 30px 0 -12px #f4cccc;
    }

    .thought.bg-red:after {
      bottom: -10px;
      right: 26px;
      width: 30px;
      height: 30px;
      box-shadow: 40px -34px 0 0 #f4cccc,
        -28px -6px 0 -2px #f4cccc,
        -24px 17px 0 -6px #f4cccc,
        -5px 25px 0 -10px #f4cccc;
    }

    .thought.bg-blue {
      background-color: #cfe2f3;
    }

    .thought.bg-blue:before,
    .thought.bg-blue:after {
      content: "";
      background-color: #cfe2f3;
      border-radius: 50%;
      display: block;
      position: absolute;
      z-index: -1;
    }

    .thought.bg-blue:before {
      width: 44px;
      height: 44px;
      top: -12px;
      left: 28px;
      box-shadow: -50px 30px 0 -12px #cfe2f3;
    }

    .thought.bg-blue:after {
      bottom: -10px;
      right: 26px;
      width: 30px;
      height: 30px;
      box-shadow: 40px -34px 0 0 #cfe2f3,
        -28px -6px 0 -2px #cfe2f3,
        -24px 17px 0 -6px #cfe2f3,
        -5px 25px 0 -10px #cfe2f3;
    }

    .d-flex {
      display: flex;
      flex-wrap: wrap;
    }

    .d-flex2 {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
      gap: 5px;
    }

    .flex-item {
      flex: 0 0 50%;
      height: fit-content;
    }

    @media (max-width: 768px) {

      .d-flex2 {
        justify-content: center;
      }

      /* Media query for mobile devices */
      .flex-item {
        flex-basis: 100%;
        max-width: 100%;
        /* margin-bottom: 35px; */
        /* Each item occupies 100% width */
      }

      .thought {
        margin-bottom: 0px;
      }
    }

    .text-orange {
      color: #f58904;
      font-size: 19px;
    }

    .flex-container {
      align-items: flex-start;
    }

    .preview-sub .flex-item.rubber {
      margin: unset !important;
    }


    .preview-sub {
      justify-content: flex-start !important;
    }

    .preview-top div:not(#box-show-id-1) {
      display: block;
      background: white;
    }

    .preview-sub .flex-item {
      max-width: 32.8%;
    }

    .preview-sub .flex-item.rubber img {
      max-height: 80px;
      width: auto;
    }

    .preview-top>div.rubber img {
      width: auto;
      height: 100%;
      display: block;
      margin-left: auto;
      margin-right: auto;
      background: white;
      max-height: 237px;
    }

    .preview-sub .flex-item.rubber {
      width: 100%;
      height: 100%;
      display: block;
      margin: auto;
      background: white;
    }

    .flex-container {
      background: white;
    }

    swiper-container {
      width: 100%;
      height: auto;
      /* Reset the height */
      overflow: hidden;
    }

    swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: auto;
    }

    swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    swiper-container {
      margin-left: auto;
      margin-right: auto;
    }

    :root {
      --swiper-theme-color: #f58904 !important;
      --swiper-pagination-bullet-width: 20px !important;
      --swiper-pagination-bullet-height: 20px !important;
    }

    table.tbl_price_deli.loading:not(.for_fans) tbody td:not(:first-child) {
      background: linear-gradient(to right, #eee 20%, #ddd 50%, #eee 80%);
      background-size: 500px 100px;
      animation-name: moving-gradient;
      animation-duration: 1s;
      animation-iteration-count: infinite;
      animation-timing-function: linear;
      animation-fill-mode: forwards;
    }

    @-webkit-keyframes moving-gradient {
      0% {
        background-position: -250px 0;
      }

      100% {
        background-position: 250px 0;
      }
    }

    .table_rubber_final td:last-child {
      background-color: white;
      width: 25%;
    }

    .title-orange {
      background-color: #ff9900;
      padding: 2px 10px;
      margin-bottom: 10px;
      color: white;
    }

    .text-warning {
      color: #ff9900;
    }

    .red-highlight-box {
      padding: 10px;
      background: #ffb2b2;
      margin: 10px 0;
      line-height: 2;
    }

    .sm-bold {
      font-family: IwaUDGoDspPro-Eb, sans-serif !important;
    }

    .modal__inner {
      width: 770px;
    }

    @media (max-width: 576px) {


      .container-cloud .justify-content-between {
        flex-direction: column;
        text-align: center;
      }

      .container-cloud .d-flex.justify-content-between p {
        margin: 0px !important;
      }

      .mt-12 {
        min-width: 100%;
      }

      .table_rubber td:nth-child(odd) {
        width: 25%;
      }

      .flex-item.w-30 {
        flex: 0 0 100% !important;
      }

      .modal__inner {
        width: 95%;
        padding: 1em;
      }
    }

    table.cld_tb {
      margin-top: 10px;
    }

    .d-flex.justify-content-between a.btn {
      background: #5b9bd5;
      width: 49%;
      height: 35px;
      text-decoration: none;
      color: white;
      font-size: 20px;
      text-align: center;
      line-height: 2;
      border-radius: 5px;
    }

    .d-flex.justify-content-between a.btn:hover {
      opacity: 0.8;
    }

    .d_TEXT1 {
      line-height: 1.5;
    }

    .ballroon {
      left: 100%;
      position: absolute;
      top: -16px;
    }

    a .ballroon .inner {
      white-space: nowrap;
      position: relative;
      white-space: nowrap;
      background-color: #ff9900;
      color: #ffffff;
      border: 1px solid #8d5500;
      font-size: 10px;
      border-radius: 32px;
      line-height: 1.33;
      padding: 1px 8px;

    }

    a .ballroon .inner:after {
      content: '';
      position: absolute;
      transform: rotate(65deg);
      z-index: 1;
      width: 6px;
      height: 6px;
      border-right: 1px solid #653d00f5;
      display: inline-block;
      border-bottom: 1px solid #653d00f5;
      background-color: #ff9900;
      border-top: none;
      border-left: none;
      bottom: -3px;
      left: 6%;
      z-index: 0;
    }

    .table_rubber_final td:nth-child(odd) {
      width: 35%;
      height: 50px;
    }

    .table_rubber_final td:last-child {
      width: 65%;
    }

    .flex-item .btn {
      flex: unset;
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

    #date_create_sample1,
    #date_create_sample2,
    #date_create_speed_1,
    #date_create_speed_2 {
      font-size: 22px;
      font-weight: bold;
      color: red;
      letter-spacing: -1px;
      overflow: hidden;
    }

    .mt-10 {
      max-width: 100%;
    }

    .title-orange {
      font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", "メイリオ", Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
      background: #F58904;
      padding: 3px 3px 3px 10px !important;
      color: #FFF;
      font-size: 20px;
      display: block;
    }

    .flex-item img {
      width: 100%;
    }

    .flex-item-30 {
      flex: 0 0 32%;
    }

    .d-flex .flex-item.w-30 img {
      width: auto;
      max-width: 100%;
      height: 150px;
    }

    .d-flex .flex-item.w-30>a {
      display: block;
      text-align: center;
      position: relative;
    }


    .group-container {
      display: flex;
      justify-content: space-between;
      flex-flow: row wrap;
      margin: 10px 0;
    }

    .group-container .btn-select {
      width: calc(19% - 8px);
      border: 1px solid #9e9e9e;
      text-align: center;
      margin-bottom: 10px;
      padding: 10px 5px;
      cursor: pointer;
      border-radius: 3px;
      transition-duration: 0.3s;
      position: relative;
    }

    .btn-select input[type="radio"] {
      opacity: 0;
      width: 0;
    }

    .group-container .btn-select:hover,
    .group-container .btn-select.active {
      border: 1px solid #ffffff;
      background: #f7b516;
      color: white;
    }

    .group-container .btn-select:hover .top-noted,
    .group-container .btn-select.active .top-noted {
      background: white;
      border: 2px solid #1e6077;
      color: #1e6077;
    }

    div.plus {
      position: absolute;
      color: #555;
      font-size: 16px;
      border-radius: 100%;
      width: 15px;
      height: 15px;
      background: linear-gradient(to bottom, #f3f5f6 0, #dedfe0 100%);
      padding: 9px;
      bottom: 0;
      right: 20px;
    }

    .mt-10 {
      max-width: 100%;
    }

    .gal-btn {
      text-align: center;
      margin-top: 8px;
    }

    .gal-btn a {
      font-size: 16px;
      background: linear-gradient(to bottom, #f7f7f7 0, #dbdbdb 100%);
      border: 1px solid #bab7b6;
      border-radius: 5px;
      box-shadow: 0 3.5px 0 0 #b5b5b5;
      color: #333;
      display: inline-block;
      padding: 10px 30px;
      text-decoration: none;
      text-align: center;
      transition: all .3s ease;
    }

    .gal-btn a:hover {
      box-shadow: none;
      transform: translateY(3px);
    }

    .group-container .btn-select:hover,
    .group-container .btn-select.active {
      border: 1px solid #ffffff;
      background: #f7b516;
      color: white;
    }

    .group-container .btn-select:hover .top-noted,
    .group-container .btn-select.active .top-noted {
      background: white;
      border: 2px solid #1e6077;
      color: #1e6077;
    }


    .group-container .btn-select:has(input[type=radio]:checked) {
      border: 1px solid #ffffff;
      background: #f7b516;
      color: white;
    }

    .box-purple {
      color: #a428a5;
      background: #ff93ff;
      border-radius: 6px;
      font-size: 18px;
      padding: 8px 10px;
      margin-right: 10px;
      min-width: 215px;
      text-align: center;
      height: unset;
    }

    .d-inline {
      display: inline-block;
      margin-top: 13px;
    }

    .bg-purple th:nth-child(1) {
      background: #ff93ff;
      color: #9e009f;
    }

    .color-g{
        width: 250px;
        height: 250px;
    }

    .ope-10{
        width: 75%;
    }

    @media(max-width: 768px) {
        .color-g{
            width: 100%;
        }

        .ope-10{
            width: 100%;
        }

      .tbl_price_tg {
        display: grid;
      }

      .tbl_price_tg>p {
        width: 100%;
      }

      .tbl_price_tg div {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        flex-direction: row;
        align-items: center;
        align-content: center;
      }

      .switch_chk {
        margin: 10px;
      }
    }

    .ballroon2 {
      top: -16px;
      display: inline-block;
      margin-left: 6px;
      padding: 3px 5px;
      text-decoration: none !important;
      background: #f44336;
      border-radius: 5px;
      border: 1px solid lightgray;
      transition-duration: 0.2s;
      margin-top: 12px;
      color: white !important;
      right: 0px;
      position: absolute;
    }

    a.ballroon2 .inner {
      white-space: nowrap;
      position: relative;
      white-space: nowrap;
      font-size: 14px;
      border-radius: 32px;
      line-height: 1.33;
      padding: 1px 8px;
    }

    a.ballroon2 .inner:after {
      content: '';
      position: absolute;
      transform: rotate(223deg);
      z-index: 1;
      width: 6px;
      height: 6px;
      border-right: 1px solid lightgray;
      display: inline-block;
      border-bottom: 1px solid lightgray;
      background-color: #f44336;
      border-top: none;
      border-left: none;
      top: -4.4px;
      left: 0;
      z-index: 0;
    }

    .repeat input[type="text"] {
      padding: 5px 10px;
      margin-left: -32px;
      width: -webkit-fill-available;
    }

    label.btn-select img {
      width: -webkit-fill-available;
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

      <h1><?= lang('名入れボトルオープナーをご制作！大ロットが格安の嬉しいお値段設定！') ?></h1>

      <div class="social-time">
            <span class="social-content">
                <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/bottle-opner/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a>
                <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/bottle-opner/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
                <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fbottle-opner%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
                <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%bottle-opner%2f&amp;text=オリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます" target="_blank"><i class="fab fa-twitter-square"></i></a>
            </span>
            <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
        </div>

      <img src="/products/images/Bottle_opener.webp?v=1.04" width="771px" height="390px">
      <div>&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
            <swiper-slide><img src="/products/images/opener01.webp?e=<?php echo date('is') ?>"></swiper-slide>
            <swiper-slide><img src="/products/images/opener02.webp?e=<?php echo date('is') ?>"></swiper-slide>
            <swiper-slide><img src="/products/images/opener03.webp?e=<?php echo date('is') ?>"></swiper-slide>
          </swiper-container>
        </div>
        <div class="flex-item item new-text" style="display:grid;align-content: center;line-height: 2;">
          <p>社名やブランド名、イベント名、メッセージなどを入れたオリジナルボトルオープナーを制作！</p><br>
          <p style="color:red;">業界きっての激安価格（1個あたり税込89円～）でご提供！ロット数が多いほどお得です！さらに、小ロット50個からご注文可能！</p><br>
          <p>ビアフェスタや酒類の販促イベント、酒造メーカーのブランディングなどにおすすめです。</p>
        </div>
      </div>
      <div style="clear:both;"></div>

      <h2><?= lang('レーザー彫刻で自由に名入れ可能！') ?></h2>
      <div class="d-flex">
        <div class="flex-item">
          <div class="">
            <img src="/products/images/opener04.webp?k=1" alt="">
          </div>
        </div>
        <div class="flex-item new-text" style="padding-top:20px">
            <p>ボトルオープナーの表面に、レーザー彫刻で自由に文字を入れることが可能です。</p><br>
            <p>光沢のある本体にくっきりとしたホワイトのレーザー彫刻が際立ちます</p><br>
            <p>1行だけの文字入れも、2行に分けた文字入れも可能です。</p>

            <br>
            <a href="#price">制作料金の詳細はこちら</a>
        </div>
      </div>


      <div style="clear:both;"></div>
      <h2><?= lang('5色の基本カラーをご用意！') ?></h2>
      <div>
        <p class="new-text">本体色には5色の基本カラーをご用意しております。基本カラー以外をご希望の場合は、お手数ではございますが個別に<a href="/contact">お問い合わせ</a>ください。</p><br>
        <div class="d-flex2">
          <div class="">
            <div class="">
              <div class="txt-center">
                <p>赤</p>
              </div>
              <img src="/products/images/opener05.webp?d=<?php echo date('is') ?>" alt="" class="color-g">
            </div>
          </div>

          <div class="">
            <div class="">
              <div class="txt-center">
                <p>青</p>
              </div>
              <img src="/products/images/opener06.webp?d=<?php echo date('is') ?>" alt="" class="color-g">
            </div>
          </div>

          <div class="">
            <div class="">
              <div class="txt-center">
                <p>緑</p>
              </div>
              <img src="/products/images/opener07.webp?d=<?php echo date('is') ?>" alt="" class="color-g">
            </div>
          </div>

          <div class="">
            <div class="">
              <div class="txt-center">
                <p>黒</p>
              </div>
              <img src="/products/images/opener08.webp?d=<?php echo date('is') ?>" alt="" class="color-g">
            </div>
          </div>

          <div class="">
            <div class="">
              <div class="txt-center">
                <p>紫</p>
              </div>
              <img src="/products/images/opener09.webp?d=<?php echo date('is') ?>" alt="" class="color-g">
            </div>
          </div>
        </div>
      </div>
      <div style="clear:both;"></div>

      <h2><?= lang('他製品との組み合わせも可能です！') ?></h2>
        <div>
            <div style="text-align:center;">
                <img src="/products/images/opener_others.webp?d=<?php echo date('is') ?>" alt="" class="ope-10">
            </div>
            <br>
            <div>
                <p class="new-text">ネックストラップやアクリルキーホルダー、ラバーキーホルダーなど他製品と組み合わせることも可能です。他製品と組み合わせたご注文をご検討中の方は、ぜひお気軽にご相談ください。</p>
                <br>
                <a href="/contact" class="new-text">お問い合わせフォームはこちら</a>
            </div>
        </div>


      <div style="clear:both;"></div>
      <h2><?= lang('注文タイプ') ?></h2>
      <div>
        <div style="text-align:center;">
            <img src="/products/images/opener10.webp?d=<?php echo date('is') ?>" alt="" class="ope-10">
        </div>


        <div>
            <p class="new-text">注文タイプは、「ミックスカラー注文」と「色指定注文」の2タイプがございます。</p>
            <br>
            <h2 class="feature1">ミックスカラー注文</h2>
            <p class="new-text">制作開始から7営業日後に出荷可能です。ただし、ボトルオープナーの本体色は指定不可となります。本体色がランダムですので、「50個注文のうち30個が赤色、20個が青色」「100個のうち10個が赤色、50個が青色、40個が緑色」などのかたちでのお届けとなります。</p>
            <br>

            <div id="price"></div>

            <h2 class="feature2">色指定注文</h2>
            <p class="new-text">制作開始から8営業日後に出荷可能です。ボトルオープナーの本体色を指定可能です。5色の基本カラーのいずれかをお選びください。1回の注文につき1色の選択となります。複数色指定のご注文をご希望の方は個別に<a href="/contact">お問い合わせ</a>ください。</p>
        </div>
      </div>

      <div style="clear:both;"></div>
      <h2><?= lang('制作料金') ?></h2>
      <div>
        <div>
          <table class="tbl_price_deli">
            <thead>
              <tr>
                <th style="background-color: #fbb">数量</th>
                <th>単価（税込）</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>50</td>
                <td>
                  <div class="tt_price" style="font-size: 16px;">400円</div>
                </td>
              </tr>
              <tr>
                <td>100</td>
                <td>
                  <div class="tt_price" style="font-size: 16px;">250円</div>
                </td>
              </tr>
              <tr>
                <td>500</td>
                <td>
                  <div class="tt_price" style="font-size: 16px;">120円</div>
                </td>
              </tr>
              <tr>
                <td>1000</td>
                <td>
                  <div class="tt_price" style="font-size: 16px;">100円</div>
                </td>
              </tr>
              <tr>
                <td>2000</td>
                <td>
                  <div class="tt_price" style="font-size: 16px;">95円</div>
                </td>
              </tr>
              <tr>
                <td>3000</td>
                <td>
                  <div class="tt_price" style="font-size: 16px;">93円</div>
                </td>
              </tr>
              <tr>
                <td>5000</td>
                <td>
                  <div class="tt_price" style="font-size: 16px;">89円</div>
                </td>
              </tr>
            </tbody>
          </table>

          <br>
          <div class="new-text">
            <p>※試作品を製作する場合は、別途6,600円（税込）追加となります。</p>
            <p>※個包装をご希望の場合は、1個あたり追加8円（税込）となります。</p>
            <p>※当ページの注文フォームからは、1,000個までご注文可能です。1,000個を超える個数のご注文をご検討中の方は<a href="/contact">お問い合わせ</a>ください。</p>
          </div>
        </div>
      </div>
      <div style="clear:both;"></div>

      <h2><?= lang('納期') ?></h2>
      
      <div>
        <h3 class="text-orange">本生産納期</h3>
        <div style="display: flex;">
            <div class="delivery"><span class="btn-a std-btn"><?= lang('ミックスカラー注文'); ?></span></div>
            <div class="delivery">
              <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('7営業日後出荷'); ?></div>
            </div>
        </div>
        <div style="display: flex;">
            <div class="delivery"><span class="btn-a std-btn"><?= lang('色指定注文'); ?></span></div>
            <div class="delivery">
              <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('8営業日後出荷'); ?></div>
            </div>
        </div>
        <div>&nbsp;</div>

        <div>
          <table class="cld_tb">
            <tr class="cld_head">
              <td colspan="2">今、この製品を製作開始した場合の出荷日を表示中</td>
            </tr>
            <tr class="cld_r1">
              <td><?= lang('製作開始日時') ?></td>
              <td>ミックスカラー注文</td>
            </tr>
            <tr class="cld_r2">
              <td rowspan="4"><span id="date_create"></span></td>
              <td><span id="date_create4" class="fvb" style="font-size: 22px; font-weight:bold;"></span></td>
            </tr>
            <tr class="cld_r1">
              <td>色指定注文</td>
            </tr>
            <tr class="cld_r2">
              <td><span id="date_create2"></span></td>
            </tr>
          </table>
          <br>
          <div class="new-text">
            <p>ミックスカラー注文 : 本体色指定不可の注文タイプです。複数色のバージョンをお届けいたします。</p>
            <p>色指定注文 : 本体色を指定可能な注文タイプです。選択可能な色は1色になります。</p>
          </div>
        </div>
        <br>
        <h3 class="text-orange">試作納期</h3>
        <div style="display: flex;">
            <div class="delivery"><span class="btn-a" style="background: #66fffe; color: #000;">試作納期</span>
            </div>
            <div class="delivery">
              <div class="tb_06" style="color: #004140;padding: 2px 5px;">8営業日後出荷</div>
            </div>
          </div>
          <div>&nbsp;</div>

        <div>
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
        </div>
      </div>

      
      <div style="clear: both;"></div>

      <h2><?= lang('入稿データについて') ?></h2>
      <div>
        <p class="new-text">入稿データ作成についてのご案内及びテンプレートをご用意しております。</p>
        <br>

        <a href="/products/new-template/template-bottleopener_20260312.ai" style="background-color:yellow; padding:10px; text-align:center; display:block; text-decoration:none; color:black; font-weight:bold; border-radius:5px;" target="_blank" download>入稿データ作成のご案内・テンプレートを ダウンロード</a>

        <br>
        <p class="new-text">入稿データはAIデータでの作成をお願いしております。上記の入稿データ作成のご案内・テンプレートもAIデータとなっております。Adobe Illustratorをお持ちでないお客様は、JPG、PNG、PDF等でのご入稿が可能です。</p>
      </div>
      <div style="clear: both;"></div>

      <h2><?= lang('ご注文・見積書作成') ?></h2>

      <?php include('../campaign_banner.php') ?>

      <div>
        <p class="new-text">※一つのデザインにつき一注文となります。複数のデザインがある場合、それぞれのデザインで別々にご注文ください。</p>
        <br>

        <div style="overflow: unset!important;">
          <div class="fixed-contrainer">
            <h3 class="red">【<?= lang('オリジナルボトルオープナー') ?>】</h3>
            <span class="total-price"><span class="prd_total">0</span>円（<?= lang('税込') ?>）</span>
          </div>
          <div style="clear: both;"></div>
          <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
            <div class="step-box">
              <table class="table_rubber" style="padding: 0">
                <tr>
                  <td><?= lang('注文タイプ') ?></td>
                  <td><span id="sample-prd-pcs">-</span></td>
                </tr>
                <tr>
                  <td><?= lang('本体色') ?></td>
                  <td><span id="sample-prd-color">-</span></td>
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
                  <div class="step-number">1</div><span class="step-details"><?= lang('本体色・数量') ?></span>
                </li>
                <li id="dot-step2">
                  <div class="step-number">2</div><span class="step-details"><?= lang('試作品・OPP個別包装') ?></span>
                </li>
                <li id="dot-step3">
                  <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・制作料金') ?></span>
                </li>
              </ul>
            </div>
          </div>
          <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
            <div style="display: table-column;"><input type="text" name="ItemType" id="strap" value="オリジナルボトルオープナー" /></div>
            <?php
            switch ($ItemPCS) {
              case "ミックスカラー注文":
                $lsSelected_1pcs = 'checked';
                break;
              case "色指定注文":
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

              <h3><?= lang('注文タイプ') ?></h3>
              <div class="part-container">
                <div class="part-content"><label class="part-name"><input type="radio" class="ItemPCS" name="ItemPCS" id="pcs1" value="ミックスカラー注文" onclick="clearValue();check_val(this);" <?= $lsSelected_1pcs ?>><?= lang('ミックスカラー注文（色指定不可・7営業日後出荷）') ?> <span class="checkmark"></span></label></div>
                <div class="part-content"><label class="part-name"><input type="radio" class="ItemPCS" name="ItemPCS" id="pcs2" value="色指定注文" onclick="clearValue();check_val(this);" <?= $lsSelected_2pcs ?>><?= lang('色指定注文（色指定可・8営業日後出荷）') ?> <span class="checkmark"></span></label></div>
                <span style="color: red" id="error_pcs"></span>
              </div>

              <div class="color_area">
                <h3>本体色</h3>
                <div class="group-container">
                  <label class="btn-select">
                    <img src="/products/images/opener05.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="赤色" <?= ($ItemColors == '赤色' ? 'checked' : '') ?> onclick="clearValue();">赤色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/opener06.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="青色" <?= ($ItemColors == '青色' ? 'checked' : '') ?> onclick="clearValue();">青色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/opener07.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="緑色" <?= ($ItemColors == '緑色' ? 'checked' : '') ?> onclick="clearValue();">緑色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/opener08.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="黒色" <?= ($ItemColors == '黒色' ? 'checked' : '') ?> onclick="clearValue();">黒色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/opener09.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="紫色" <?= ($ItemColors == '紫色' ? 'checked' : '') ?> onclick="clearValue();">紫色
                  </label>
                </div>

                <span style="color: red" id="error_pcs_col"></span>
              </div>

              <div>&nbsp;</div>
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
              <h3><?= lang('試作品・データトレース・OPP個別包装') ?></h3>
              <div class="part-container">
                <div class="part-content">
                  <label class="part-name">
                    <div class="switch_off_button b2 switch_off">
                      <input type='hidden' value='なし' name='SendPrototype'>
                      <input type="checkbox" class="checkbox" name="SendPrototype" value="あり" onclick="setToInput();" <?= $sendActual_checked ?>>
                      <div class="knobs"><span></span></div>
                      <div class="layer"></div>
                    </div>
                    <?= lang('試作品【6,600円(税込)】') ?>
                  </label>
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
                    <?= lang('データトレース') ?>
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
                        <td class="TableLeft"><?= lang('注文タイプ') ?></td>
                        <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                      </tr>
                      <tr>
                        <td class="TableLeft"><?= lang('本体色') ?></td>
                        <td class="" id="prd_ItemColors" style="text-align: left;"></td>
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

      <h2><?= lang('当店ボトルオープナーの特徴！') ?></h2>
      <div>
        <h2 class="feature1">業界きっての激安価格！</h2>
        <p class="new-text">1個あたり最安81円からご制作！ロット数が多いほど単価を低く抑えることが可能です。「大量のボトルオープナーが必要だけど費用が心配」とお悩みの方は、ぜひお気軽にお問い合わせください。</p>

        <h2 class="feature2">小ロットでも注文可能！</h2>
        <p class="new-text">50個の小ロットからご注文を承っております。小規模のイベントや販促活動にぴったりです。</p>
        <br>

        <p class="new-text">※1,000個以下のご注文であれば、当ページの注文フォームからご注文頂けます。</p><br>
        <p class="new-text">※1,000個を超える大ロットご注文の方は、問い合わせフォームからご相談ください。お電話でのご相談も承っております。</p>
      </div>
      <div style="clear: both;"></div>

      <h2><?= lang('製品仕様・付属品等') ?></h2>
      <div class="new-text">
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td>名称</td>
              <td>オリジナルボトルオープナー</td>
            </tr>
            <tr>
              <td>素材</td>
              <td>アルミニウム</td>
            </tr>
            <tr>
              <td>サイズ</td>
              <td>62.5mm×12mm</td>
            </tr>
            <tr>
              <td>印刷方法</td>
              <td>レーザー彫刻</td>
            </tr>
            <tr>
              <td>本体色</td>
              <td>赤、青、緑、黒、紫</td>
            </tr>
            <tr>
              <td>最小ロット</td>
              <td>50個</td>
            </tr>
            <tr>
              <td>包装</td>
              <td>一括包装・個別OPP包装</td>
            </tr>
            <tr>
              <td>納期</td>
              <td>ミックスカラー注文 : 7営業日後出荷 <br> 色指定注文 : 8営業日後出荷</td>
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
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
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
  <script type="text/javascript" src="<?= $cal_bottle_js ?>"></script>
  <script type="text/javascript" src="<?= $pdf_bottle_js ?>"></script>

  <script type="text/javascript">
    $(function() {
      $('#info_div').load('/info/index.php');
    });

    /* <![CDATA[ */
    var google_conversion_id = 1036353231;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */

    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "アクリルキーホルダーbt"
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
        "product": "アクリルキーホルダーbtexp"
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

    $.ajax({
      type: "POST",
      url: "/products/check_holiday2.php",
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
    }, (tmp != "" ? valid_chk_btn('step3') : ""), setToInput());

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