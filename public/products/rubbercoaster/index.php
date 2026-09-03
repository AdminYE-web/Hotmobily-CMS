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

$japanNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Tokyo'));
$planDisableStart = new DateTimeImmutable('2026-08-13 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisableEnd = new DateTimeImmutable('2026-08-17 00:00:00', new DateTimeZone('Asia/Tokyo'));
$planDisabled = ($japanNow >= $planDisableStart && $japanNow < $planDisableEnd) ? 'disabled' : '';
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
  <meta name="keywords" content="コースター,オリジナル,製作,ラバーコースター,デザイン,ノベルティ">
  <meta name="description" content="オリジナルコースターを、1枚から製作できます。飲食店のオリジナルグッズや法人ノベルティ、自治体PRグッズなどにおすすめ。高品質、短納期、低価格。水に強く耐久性があり、何度でも使えるので便利です。デザインでお困りの際はご相談ください。">
  <meta name="robots" content="index,follow" />
  <title>オリジナルコースター お好みのデザインで、1枚～製作できます。小ロット・短納期</title>
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

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }

    .mt-10-part {
      min-width: 23%;
      max-width: 23%
    }

    .mt-10-part div {
      text-align: center
    }

    .preview-sub .hover {
      max-width: 19.87%
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
      background: transparent url(images/coaster_number_1.webp) no-repeat !important;
      background-size: 50px 85px !important;
      background-position: 0px center !important;
    }

    .feature2 {
      background: transparent url(images/coaster_number_2.webp) no-repeat !important;
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

    .flex-item {
      flex: 0 0 50%;
      height: fit-content;
    }

    @media (max-width: 768px) {

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
      width: calc(24% - 10px);
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

    @media(max-width: 768px) {
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

    .ut_price{
        display: block !important;
    }

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
    .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
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
      <h1><?= lang('オリジナルコースター　お好みのデザインで、1枚～製作できます') ?></h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/rubbercoaster/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a>
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/rubbercoaster/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubbercoaster%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubbercoaster%2f&amp;text=オリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
      </div>
      <img src="/products/images/rubber_feature_banner.webp?v=1.02">
      <div>&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
            <swiper-slide><img src="images/pic1_2023.webp"></swiper-slide>
            <swiper-slide><img src="images/pic2_2023.webp"></swiper-slide>
            <swiper-slide><img src="images/pic3_2023.webp"></swiper-slide>
          </swiper-container>
        </div>
        <div class="flex-item item new-text" style="display:grid;align-content: center;line-height: 2;">
          <p>オリジナルコースターは洗って何度でも使えるため、紙コースターよりもエコ！</p>
          <p>裏面にもイラストや文字、QRコードなどを印刷することができます。お好みのデザイン・形で1枚からご注文いただけます。さらに、<font style="font-weight:bold;">汚れ防止加工（税込単価99円）</font>も可能！</p>
          <p>飲食店のお客様が圧倒的多数ですが、実はノベルティグッズや自治体PRグッズとしてもご活用が可能。</p>
          <p>「デザインについて悩んでいる」などお困りの際は、当店までご相談ください。</p>
        </div>
      </div>
      <div style="clear:both;"></div>

        <h2>ラバー製品完全ガイドをご用意！</h2>
        <div>
            <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
        </div>
        <div>
            <p class="new-text">初めてラバーコースターを製作する方や、よりハイクオリティのラバー製品を製作したい方なら、オリジナルラバー製品の製作について詳しく知りたいですよね。</p><br>
            <p class="new-text">そんな方のために、ラバー製品の加工タイプや特殊素材、汚れ防止加工、入稿データ作成などについての完全ガイドをご用意。
            </p><br>
            <p class="new-text">最高のラバーコースター製作にぜひともお役立てください。</p>
            <br>
            <div style="text-align: right;">
                <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
            </div>
        </div>

      <div style="clear:both;"></div>
      <h2><?= lang('オリジナルコースター、実はこんな時に使えるんです！') ?></h2>
      <h3 class="title-orange">飲食店のオリジナルグッズとして</h3>

      <div class="d-flex">
        <div class="flex-item">
          <div class="thought">新規店舗のオープンが決まった！<br />
            お店のロゴが入ったオリジナルグッズを<br />
            取り入れたいけど、何がいいかな？
          </div>
        </div>
        <div class="flex-item new-text" style="padding-top:20px">
          オリジナルコースターなら、防水性が高いため繰り返しご使用いただけるうえ、お店の名前やロゴ、QRコードなどを印刷することができます。<br />
          お客様の目に必ず入るといっても過言ではないコースターを、オリジナリティあふれるデザインで作ってみませんか？
        </div>
      </div>

      <h3 class="text-orange">飲食店 製作事例</h3>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-130121-8a.jpg" data-lightbox="sample_1_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-130121-8a.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>同一層加工の特徴を活かしています。お店の雰囲気にマッチした、洗練されたイメージの仕上がりとなりました。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>


        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-53.jpg" data-lightbox="sample_2_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-53.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>タコメーターをモチーフにした、ユニークなコースター。所々に遊び心が垣間見えるデザインが、飲食の時間を楽しくしてくれそうです。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-130121-10a.jpg" data-lightbox="sample_3_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-130121-10a.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>筆で描いたような味のあるデザイン。漢字の細部までしっかり再現出来ました。この上にビールジョッキを置いて、焼肉をお腹いっぱい食べたいですね。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-130121-2a.jpg" data-lightbox="sample_4_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-130121-2a.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>野球のボールを中心に配置した面白いデザインです。個性的なオリジナル製品となりました。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-130121-4a.jpg" data-lightbox="sample_5_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-130121-4a.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>黄色と黒、バランス取れた仕上がりになりました。上質な雰囲気の漂うデザインです。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/Coster_F12.jpg" data-lightbox="sample_6_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/Coster_F12.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>タマゴ形のかわいらしいコースター。お客様のアイデアを形に出来た時、お客様に喜んで頂いた時、ものづくりをしていて一番嬉しい瞬間です。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/Coster_F20.jpg" data-lightbox="sample_7_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/Coster_F20.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>ダーツ盤を模したデザインのコースター。製品の厚みを6ｍｍと、厚めにご指定頂きました。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-20.jpg" data-lightbox="sample_8_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-20.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>フチなし多層構造コースターです。フチのあり・なしはお好みでご選択頂けます。製作料金も同一価格です。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-130121-5a.jpg" data-lightbox="sample_9_1" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-130121-5a.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>別注文で製作頂きましたデザインの配色を変更しての製作です。同じデザインでも配色を変更すると印象が異なります。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

      </div>

      <h3 class="title-orange">法人ノベルティとして</h3>

      <div class="d-flex">
        <div class="flex-item">
          <div class="thought bg-red">会社のイベントに来てくださるお客様や一般の方々に、何かノベルティをお渡ししたい…</div>
        </div>
        <div class="flex-item new-text" style="padding-top: 20px;">
          薄くてかさばらないオリジナルコースターなら、ノベルティにも最適です。会社のロゴやWEBサイトのアドレスなどを印刷すれば、会社のPRグッズとしても活躍してくれるでしょう。オプションでお好みの<a href="/products/daishi.html">台紙を製作・同封</a>することも可能です。
        </div>
      </div>

      <h3 class="text-orange">法人ノベルティ 製作事例</h3>
      <div class="d-flex">
        <div class="flex-item  w-30">
          <a href="/gallery/img-coaster/Coster_F2.jpg" data-lightbox="sample_1_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/Coster_F2.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>ベース層に青・黄・黒を配置してその上にキャラクターのデザインを乗っけています。デザインは立体的になりますが、グラスを置いた時もグラつきません。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item  w-30">
          <a href="/gallery/img-coaster/coaster-130121-16a.jpg" data-lightbox="sample_2_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-130121-16a.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>20周年の記念品として製作させていただきました。黒の中のビビッドカラーが映えていますね。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item  w-30">
          <a href="/gallery/img-coaster/coaster-49.jpg" data-lightbox="sample_3_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-49.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>YOU AND EARTH 特性オリジナルコースター。会社へ来客があった時に使う事を目的としたちょっとしたノベルティーです。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item  w-30">
          <a href="/gallery/img-coaster/Coster_F22.jpg" data-lightbox="sample_4_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/Coster_F22.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>円形や正方形以外の形状のコースターも製作可能です。このコースターは、2色2層構造です。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item  w-30">
          <a href="/gallery/img-coaster/Coster_F5.jpg" data-lightbox="sample_5_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/Coster_F5.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>少ない色数ですっきり表現されている素敵なコースター。文字部分はスリットで、ベースのゴム層が覗くように加工しております。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/Coster_F11.jpg" data-lightbox="sample_6_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/Coster_F11.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>このようにオリジナル形状のコースターの製作も可能です。中央部分が大きいため1層高くなっていますが、グラスを置いても安定しています。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-34.jpg" data-lightbox="sample_7_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-34.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>ブルーと白、そしてアクセントの赤。3色2層のコースターです。URLのような細かい文字も再現することができます。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/coaster-26.jpg" data-lightbox="sample_8_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/coaster-26.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>ピンクをベースにしたとても可愛い仕上がりになりました。弊社製作チームの女性スタッフに大人気のコースターです。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>

        <div class="flex-item w-30">
          <a href="/gallery/img-coaster/Coster_F23.jpg" data-lightbox="sample_9_2" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="/gallery/img-coaster/Coster_F23.jpg">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>レコードの溝がとても上手く表現された製品です。中央部分の文字は、オレンジ色の層に対して一層上がった構造です。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>
      </div>

      <h3 class="title-orange">自治体のPRグッズとして</h3>

      <div class="d-flex">
        <div class="flex-item">
          <div class="thought bg-blue">地方創生プロジェクトの一環として、短編映画を製作することに。何か良いPR方法はないだろうか？</div>
        </div>
        <div class="flex-item new-text" style="padding-top: 20px;">
          地方創生プロジェクトにおけるPRグッズとしてもご活用いただけます。例えば地方で短編映画を製作することになった時、映画のオリジナルコースターをつくり、その地域の飲食店に配布することで映画の認知拡大につながります。ご当地キャラクターを印刷したり、都道府県の形状にカットしたり、アイデア次第で色々な使い方ができるでしょう。</div>
      </div>

      <h3 class="text-orange">自治体PRグッズ製作事例</h3>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a href="images/pic10_2023.webp" data-lightbox="sample_1_3" data-title="" style="text-decoration:none;">
            <img class="lazy" data-src="images/pic10_2023.webp">
            <div class="plus"><i class="fas fa-search-plus"></i></div>
          </a>
          <div>
            <p>▲</p>
            <p>マンホールデザインのコースターです。ご当地キャラクターや観光名所のイラストを取り入れてみるのもおすすめです。</p>
            <div style="clear: both;">&nbsp;</div>
          </div>
        </div>
      </div>
      <hr>
      <h2><?= lang('自由に変えられる！オリジナルコースターの形状') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('円形や四角形、イラストに合わせた形状など、お好みの形でオリジナルコースターを製作いただけます。世界に1つしかないコースターをデザインしてみませんか？') ?><br />
      </p>
      <div class="flex-container">
        <div class="flex-item item">
          <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
            <swiper-slide>
              <a href="images/coaster_2023_0519_01_L.webp" data-lightbox="sample_2" data-title="" style="text-decoration:none;">
                <img src="images/coaster_2023_0519_02.webp?v=1.01">
              </a>
            </swiper-slide>
            <swiper-slide>
              <a href="images/glass_02_02.webp" data-lightbox="sample_2" data-title="" style="text-decoration:none;">
                <img src="images/glass_02_02.webp?v=1.01">
              </a>
            </swiper-slide>
        </div>
        <div class="flex-item item">
          <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
            <swiper-slide>
              <a href="images/coaster_2023_0519_03_L.webp" data-lightbox="sample_3" data-title="" style="text-decoration:none;">
                <img src="images/coaster_2023_0519_03.webp?v=1.01">
              </a>
            </swiper-slide>
            <swiper-slide>
              <a href="images/glass_02_01.webp" data-lightbox="sample_3" data-title="" style="text-decoration:none;">
                <img src="images/glass_02_01.webp?v=1.01">
              </a>
            </swiper-slide>
        </div>
      </div>

      <hr>
      <h2><?= lang('お好みで選べる！フチあり・フチなし') ?></h2>
      <p class="d_TEXT1 new-text">
        <?= lang('オリジナルコースターは、フチあり・フチなしの2タイプから選択いただけます。どちらのタイプも、製作料金は変わりません。') ?>
      </p>
      <img src="images/corner_view_banner1.webp">
      <div style="clear:both;">&nbsp;</div>
      <img src="images/corner_view_banner2.webp">
      <hr />
      <h2><?= lang('オリジナルコースターの製作工程のご紹介') ?></h2>
      <div class="videoWrapper">
        <img src="img/rubber-coaster-production-yt.webp" data-src="YIo9Ww-1mQ4" class="iframe" width="773" height="">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <!-- <div>
        <h2><?= lang('製品仕様・付属品等') ?></h2>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td><?= lang('名称') ?></td>
              <td><?= lang('オリジナルコースター') ?></td>
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
              <td><?= lang('裏面印刷') ?></td>
              <td><?= lang('単色（シルク）印刷、カラー印刷ともに可能です。プレミアムの場合は無料、スタンダードの場合は単色が＋@33円（税込）、カラーが＋@55円（税込）となります。') ?></td>
            </tr>
            <tr>
              <td><?= lang('試作品（実物校正サンプル）') ?></td>
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
              <td>1枚より。</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div> -->
      <!-- <div class="flex-container" style="padding-top: 8px;">
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/products/rubbercoaster/download/download.php?fname=template-coaster-20250604.zip">
              <span><?= lang('テンプレート') ?></span>
            </a>
            <a class="btn-a btn-yellow" href="/products/data" target="_blank">
              <span><?= lang('入稿データ作成') ?></span>
            </a>
          </div>
        </div>
        <div class="flex-item item">
          <div class="btn-container item_btn" style="display: flex;justify-content: space-between;">
            <a class="btn-a btn-yellow" href="/howtoorder/" target="_blank">
              <span><?= lang('ご注文の流れ') ?></span>
            </a>
            <a class="btn-a btn-yellow" href="/contact/?item=ラバーコースター">
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

      <div>
        <div class="resource-button-grid">
          <a href="/products/new-template/template-coaster-20250604.zip" class="resource-button" download style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
              <polyline points="14 2 14 8 20 8"></polyline>
              <path d="M12 18v-7"></path>
              <path d="M8.5 14.5 12 18l3.5-3.5"></path>
            </svg>
            <span>入稿データテンプレートをダウンロード</span>
          </a>

          <a href="/products/data.html" class="resource-button" style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M5 2.5h13.5v19H6.5A2.5 2.5 0 0 1 4 19V4a1.5 1.5 0 0 1 1-1.5z"></path>
              <path d="M4 19a2.5 2.5 0 0 1 2.5-2.5h12"></path>
              <rect x="8" y="6.5" width="7" height="8" rx=".5"></rect>
              <circle cx="11.5" cy="9.2" r=".9" fill="currentColor" stroke="none"></circle>
              <path d="M11.5 11.5v2.2"></path>
            </svg>
            <span>入稿データ作成のご案内</span>
          </a>

          <a href="/howtoorder/" class="resource-button" style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M10.5 6h5.5a2 2 0 0 1 2 2v3.5"></path>
              <polyline points="15 8.5 18 11.5 21 8.5"></polyline>
              <path d="M13.5 18H8a2 2 0 0 1-2-2v-3.5"></path>
              <polyline points="3 15.5 6 12.5 9 15.5"></polyline>
              <circle cx="6" cy="6" r="3.8" fill="currentColor" stroke="none"></circle>
              <text x="6" y="7.6" font-size="4.5" font-family="sans-serif" font-weight="bold" text-anchor="middle" fill="#fff" stroke="none">1</text>
              <circle cx="18" cy="18" r="3.8" fill="currentColor" stroke="none"></circle>
              <text x="18" y="19.6" font-size="4.5" font-family="sans-serif" font-weight="bold" text-anchor="middle" fill="#fff" stroke="none">2</text>
            </svg>
            <span>ご注文の流れ</span>
          </a>

          <a href="/contact/?item=ラバーコースター" class="resource-button" style="color: #233c4a">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <polyline points="20 12 20 22 4 22 4 12"></polyline>
              <rect x="2" y="7" width="20" height="5"></rect>
              <line x1="12" y1="22" x2="12" y2="7"></line>
              <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
              <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
            </svg>
            <span>無料サンプルの送付をリクエスト</span>
          </a>
        </div>
      </div>

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
      <h2>製作料金・納期一覧</h2>
      <div class="tbl_price_tg" style="position:relative;">
        <p class="new-text">
          <?= lang('製作の料金（送料込み、税込み総額）と当店からの出荷日目安が表示されます。ご納期は、現時点でご注文確定（デザイン確定、お支払い完了）の場合です。翌日以降ご注文の出荷日目安は、下記よりご注文予定日を選択してください。'); ?>
        </p>
        <div>
          <label class="switch_chk" style="display: none;"><input type="checkbox" id="tg_unit" checked onchange="$('.ut_price').toggle();"><label for="tg_unit"></label><?= lang('単価を表示'); ?></label>
          <label class="switch_chk"><input type="checkbox" id="tg_prdt" onchange="$('.ut_date').toggle();" /><label for="tg_prdt"></label><?= lang('営業日数を表示'); ?></label>
        </div>
      </div>
      <div style="clear: both;"></div>
      <?php $unit = ['1～10', 50, 60, 100, 200, 300, 500, 1000, 3000, 5000];  ?>
      <div class="tbl_s cl2" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tbl_price_deli loading">
          <thead>
            <tr>
              <th></th>
              <th colspan="3">スタンダード</th>
              <th colspan="3">プレミアム</th>
            </tr>
            <tr>
              <th rowspan="2">数量</th>
              <th rowspan="2">製作料金（税込総額・単価）</th>
              <th colspan="2">当店からの出荷日目安</th>
              <th rowspan="2">製作料金（税込総額・単価）</th>
              <th colspan="2">当店からの出荷日目安</th>
            </tr>
            <tr>
              <th>量産のみ</th>
              <th>試作込み最短</th>
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
      <div style="clear:both;">&nbsp;</div>
      <table class="tbl_price_deli bg-purple">
        <thead>
          <tr>
            <th colspan="5">スタンダード（スピード発送）</th>
          </tr>
          <tr>
            <td rowspan="2">数量</th>
            <td rowspan="2">製作料金（税込総額・単価）</th>
            <td colspan="2">当店からの出荷日目安</th>
          </tr>
          <tr>
            <td>量産のみ</th>
            <td>試作込み最短</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1～10</td>
            <td>
              <div class="tt_price">23,100円</div>
              <div class="ut_price">-</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>50</td>
            <td>
              <div class="tt_price">41,500円</div>
              <div class="ut_price">830円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>80</td>
            <td>
              <div class="tt_price">56,640円</div>
              <div class="ut_price">708円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>100</td>
            <td>
              <div class="tt_price">58,700円</div>
              <div class="ut_price">587円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>200</td>
            <td>
              <div class="tt_price">96,800円</div>
              <div class="ut_price">484円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
          <tr>
            <td>300</td>
            <td>
              <div class="tt_price">138,900円</div>
              <div class="ut_price">463円</div>
            </td>
            <td class="speed_deli_date"></td>
            <td class="speed_deli_date2"></td>
          </tr>
        </tbody>
      </table>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは300個となります。') ?><br>
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br>
        ※<?= lang('汚れ防止加工はできません。') ?><br><br>
      </div>
      <div style="clear:both;">&nbsp;</div>
      <p class="new-text"> 最も多くのお客様に選ばれているスタンダード、7営業日出荷のスタンダード（スピード発送）、店頭やネット販売でも問題のない最高品質タイプのプレミアムの、3種類がございます。</p>
      <div class="red-highlight-box new-text">
        <p><span style="color:red;">プレミアム</span>とは？</p>
        <p>海外での検査に加え、<span class="sm-bold">日本国内の専門検査会社での検査</span>を行い品質を保証。</p>
        <p>製作可能な色数や裏面印刷へのこだわりなど、専任の担当者が細部までヒアリングを行い、対応させて頂きます。</p>
        <p>※プレミアムでは、<span class="sm-bold">試作品・シルク印刷・トレース代金は無料</span>です。</p>
      </div>
      <p class="new-text">スタンダード・スタンダード（スピード発送）・プレミアムの違いについて、詳しくは<a href="/products/product-difference.php?data=2">こちら</a>をご覧ください。</p>
      <hr>
      <h2><?= lang('製作納期') ?></h2>
      <div style="clear: both;"></div>
      <!-- <div id="info_div"></div>    -->
      <?php include('../../delivery_note.php'); ?>
      <br>
      <p class="d_TEXT1 new-text"><?= lang('納期') ?>：<br /><span class="red"><?= lang('下記日数は全て営業日。') ?></span><br /><?= lang('納期=製作日数+配送日数で定義されるものとします。<br />営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。中国春節、国慶節期間につきましては、別途定める休日が指定されます。<br />シルク印刷ありでのご注文の場合、+1営業日<br />色味指定を印刷紙で行う場合、+3営業日<br />※お客様から印刷紙手配が遅れる場合、この限りではございません。') ?>
      </p>
      ◆<?= lang('スタンダード製作期間（単位：営業日。配送日数は含まず）') ?>
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
      </table>
      <br />
      ◆<?= lang('スタンダード（スピード発送）製作期間（単位：営業日。配送日数は含まず）') ?>
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">200個以下</td>
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
      </table>
      <br />
      <p class="d_TEXT1 new-text">
        <?= lang('◆汚れ防止加工') ?><br>
        <?= lang('スタンダード/プレミアム製品製作期間+3～5営業日') ?>
      </p>
      <br />
      <p class="d_TEXT1 new-text">◆<?= lang('配送日数') ?>：<?= lang('1-2営業日') ?></p>
      <p class="d_TEXT1 new-text">
        ◇<?= lang('例') ?>）<br />
        <?= lang('スタンダード') ?><br />
        300<?= lang('個') ?><br />
        <?= lang('試作品なしの場合') ?>
      </p>
      <p class="d_TEXT1 new-text">
        ・<?= lang('製作期間') ?>：10<?= lang('営業日') ?><br />
        ・<?= lang('配送期間') ?>：1-2<?= lang('営業日') ?><br />
        <?= lang('合計') ?>：11-12<?= lang('営業日となります。') ?>
      </p>
      <h2>HOTMOBILYオリジナルグッズのオリジナルコースターは、ここが違う！</h2>
      <h3 class="feature1">デザイン細部の再現にもこだわりを</h3>
      <div class="d-flex">
        <div class="flex-item">
          <img src="images/zoom8.webp?v=1.03" class="w-100">
        </div>
        <div class="flex-item">
          <p class="new-text">デザインの細部、特にキャラクターの顔の検査には厳しい検査基準を設けております。少しでも基準を満たしていない製品は全て不良品としております。</p>
        </div>
      </div>

      <h3 class="feature2">裏面印刷も断然キレイ</h3>
      <div class="d-flex">
        <div class="flex-item">
          <img src="images/zoom15.webp" class="w-100">
        </div>
        <div class="flex-item">
          <p class="new-text">裏面の印刷は、細かい線が擦れたり、潰れたりして綺麗に印刷出来ないことも多く、印刷の結果は技術者の力量に大きく左右されます。当店、全自動機械制御の印刷機によるUV印刷。細い線でも綺麗に印刷できるほか、全ての製品に対して個体差なく印刷することができます。単色印刷もカラー印刷も可能です。</p>
        </div>
      </div>

      <h3 class="feature3">納期が早い！</h3>
      <div class="d-flex">
        <div class="flex-item">
          <img src="images/zoom11.webp" class="w-100">
        </div>
        <div class="flex-item">
          <p class="new-text">スタンダード（スピード発送）・200個まで・試作品なしのご注文なら、製作期間は7営業日、配送期間は1～2営業日。合計8～9営業日でお手元に製品が届きます。</p>
        </div>
      </div>

      <h3 class="feature4">デザインの相談にも丁寧な対応</h3>
      <div class="d-flex">
        <div class="flex-item">
          <img src="images/zoom12.webp" class="w-100">
        </div>
        <div class="flex-item">
          <p class="new-text">オリジナルコースター製作にあたり、一番こだわりたくて、一番難しいのが「デザイン」ではないでしょうか？当店らお客様のデザインに関するご相談にも丁寧な対応を心がけております。「こんなこと聞いてもいいのかな？」と思われた場合にも、まずはお問合せくださいませ。</p>
        </div>
      </div>

      <?php include("../campaign_news.php"); ?>
      <h2>安全性の高い材料を使用</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/foodproducts.php?data=rubbercoaster" target="_blank"><img class="lazy" data-src="/img/safety-banner.webp" width="745" height="70"></a></div>
      <div style="clear:both;">&nbsp;</div>
      <div id="est-content">
            
      <?php include('../campaign_banner.php') ?>

        <div style="clear:both;"></div>
        <h2><?= lang('ご注文・見積書作成') ?></h2>
      </div>
      <?php include('../../delivery_note.php'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('ラバーコースター') ?>】</h3>
          <span class="total-price"><span class="prd_total">0</span><?= lang('円（税込）') ?></span>
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
                <td><span>90X90mm<?= lang('以内。') ?></span></td>
              </tr>
              <tr>
                <td><?= lang('形状タイプ') ?></td>
                <td><span id="sample-shape">-</span></td>
              </tr>
              <tr>
                <td><?= lang('裏面印刷') ?></td>
                <td><span id="sample-prd-screen">-</span></td>
              </tr>
              <tr>
                <td><?= lang('汚れ防止加工') ?></td>
                <td><span id="sample-prd-coating">-</span></td>
              </tr>
              <tr>
                <td><?= lang('フチ加工') ?></td>
                <td><span id="sample-shape-border">-</span></td>
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
            <img class="picpro lazy" data-src="/products/images/HM_part1-2.webp" width="320" height="320" id="sample-part-pic"><br />
            <span id="sample-part-name"><?= lang('通常松葉（カニカン）') ?></span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img class="picpro lazy" data-src="/products/acrylic/img/coming-soon.webp" width="135" height="135" id="sample-paper-pic"><br />
            <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ・裏面印刷') ?></span>
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
            <input type="text" name="ItemType" id="strap" value="ラバーコースター" />
          </div>
          <?php
          switch ($ItemPCS) {
            case "スタンダード":
              $lsSelected_1pcs = 'checked';
              break;
            case "プレミアム":
              $lsSelected_2pcs = 'checked';
              break;
            case "スタンダード（スピード7営業日発送）":
              $lsSelected_4pcs = 'checked';
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


          switch ($ItemMaterial) {
            case "特殊素材なし":
              $material0_checked = 'checked';
              break;
            case "特殊素材あり":
              $material1_checked = 'checked';
              break;
            default:
              $material0_checked = 'checked';
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

          <style>
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

                /* ซ่อน radio ดั้งเดิม */
                .shape-options input[type="radio"], .shape-options-two input[type="radio"] {
                    display: none;
                }

                /* การ์ด */
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

                /* เมื่อเลือก */
                .shape-options input[type="radio"]:checked + .shape-card, .shape-options-two input[type="radio"]:checked + .shape-card {
                    border-color: #ffffff;
                    background: #f7b516;
                    color: white;
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

                
          </style>
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

            <h3>形状タイプ</h3>
            <div class="part-container">
                <div class="shape-options">
                    <div class="move-mb">
                        <label>
                            <input type="radio" class="shapeType" name="shape_type" value="未定" <?php echo (isset($shape_type) ? ($shape_type == "未定" ? "checked" : "") : "checked") ?>>
                            <div class="shape-card">
                            <div><img src="/products/images/shape_01.webp" alt=""></div>
                            <span>未定</span>
                            </div>
                        </label>
                    </div>

                    <div class="move-mb">
                        <label>
                            <input type="radio" class="shapeType" name="shape_type" value="丸" <?php echo (isset($shape_type) ? ($shape_type == "丸" ? "checked" : "") : "") ?>>
                            <div class="shape-card">
                            <div><img src="/products/images/shape_02.webp" alt=""></div>
                            <span>丸</span>
                            </div>
                        </label>
                    </div>

                    <div class="move-mb">
                        <label>
                            <input type="radio" class="shapeType" name="shape_type" value="四角" <?php echo (isset($shape_type) ? ($shape_type == "四角" ? "checked" : "") : "") ?>>
                            <div class="shape-card">
                            <div><img src="/products/images/shape_03.webp" alt=""></div>
                            <span>四角</span>
                            </div>
                        </label>
                    </div>

                    <div class="move-mb">
                        <label>
                            <input type="radio" class="shapeType" name="shape_type" value="シェイプ" <?php echo (isset($shape_type) ? ($shape_type == "シェイプ" ? "checked" : "") : "") ?>>
                            <div class="shape-card">
                            <div><img src="/products/images/shape_04.webp" alt=""></div>
                            <span>シェイプ</span>
                            </div>
                        </label>
                    </div>

                </div>
                <span style="color: red" id="error_shape_custom"></span>
            </div>
            <br>

            <h3><?= lang('ご注文タイプ') ?></h3>
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_1pcs ?>><?= lang('スタンダード') ?> <span class="checkmark"></span></label></div>
              <div class="part-content" <?=$delivery_disabled?>><label class="part-name"><input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_4pcs ?> <?= $planDisabled ?>><?= lang('スタンダード（スピード7営業日発送）') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?> <?= $planDisabled ?>><?= lang('プレミアム') ?> <span class="checkmark"></span></label></div>
              <span style="color: red" id="error_pcs"></span>
            </div>

            <h3><?= lang('特殊素材（蓄光／蛍光／ラメ／金色銀色）') ?></h3>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材なし" <?php echo $material0_checked ?> onclick="clearValue();" /><?= lang('特殊素材なし') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材あり" <?php echo $material1_checked ?> onclick="clearValue();" /><?= lang('特殊素材あり') ?> <span class="checkmark"></span></label></div>
            </div>

            <h3><?= lang('裏面印刷') ?></h3>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="nashiprint" value="印刷なし" <?php echo $printing1_checked ?> onclick="clearValue();" /><?= lang('印刷なし') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="ariprint" value="単色（シルク）印刷" <?php echo $printing2_checked ?> onclick="clearValue();" /><?= lang('単色（シルク）印刷') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="fcprint" value="フルカラー印刷" <?php echo $printing3_checked ?> onclick="clearValue();" /><?= lang('フルカラー印刷') ?>
                  <span class="checkmark"></span></label></div>
              <span style="color: red" id="error_print"></span>
              <font color="red">※<?= lang('プレミアムはシルク印刷代金が無料') ?></font>
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
              <div class="part-content">
                <label class="part-name"><input type="radio" name="coating" id="coating0" value="汚れ防止加工なし" <?php echo $coating0_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工なし') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="coating" id="coating1" value="汚れ防止加工あり" <?php echo $coating1_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工あり (納期+3～5営業日）') ?> <span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_coating"></span>
            </div>

            <h3>フチ加工</h3>
            <div class="part-container" id="section-shape-processing">
                <div class="shape-options-two">
                    <div class="move-mb">
                        <label>
                            <input type="radio" class="shape-processing" name="shape_processing" value="なし" <?php echo (isset($shape_processing) ? ($shape_processing == "なし" ? "checked" : "") : "checked") ?>>
                            <div class="shape-card">
                            <div><img src="/products/images/Fuchi_01_edit.webp" alt=""></div>
                            <span>なし</span>
                            </div>
                        </label>
                    </div>
                    <div class="move-mb">
                        <label>
                            <input type="radio" class="shape-processing" name="shape_processing" value="あり" <?php echo (isset($shape_processing) ? ($shape_processing == "あり" ? "checked" : "") : "") ?>>
                            <div class="shape-card">
                            <div><img src="/products/images/Fuchi_02_edit.webp" alt=""></div>
                            <span>あり</span>
                            </div>
                        </label>
                    </div>
                </div>
                <span style="color: red" id="error_shape_processing"></span>
            </div>
            <br>

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
                    <img src="/products/images/HM_design1.webp" width="300" height="300" style="width: 300px!important;">
                  </div>
                  <div class="flex-item">
                    <img src="/products/images/HM_design2.webp" width="300" height="300" style="width: 300px!important;">
                  </div>
                </div>
                カラーバリエーション2種類目から＜3,300円(税込)/デザイン＞<br />
                ※カラーバリエーション毎の個数は、入稿データ内またはご連絡事項に記載してください。<br />
                ※4種類まで可能。各バリエーションの最小ロットは50個です。<br />
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
            <input type='hidden' value='なし' name='part'>
            <h3><?= lang('台紙') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='paper_select'>
                    <input type="checkbox" class="checkbox" name="paper_select" value="あり" onclick="check_val('next')" <?= ($paper_select == "あり" ? 'checked' : '') ?>>
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
                  <?php if ($paper_select == "あり") {
                    include("../paper_preview.php");
                  } ?>
                </div>
              </div>
            </div>
            <h3><?= lang('試作品・データトレース') ?></h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='SendPrototype'>
                    <input type="checkbox" class="checkbox" name="SendPrototype" value="あり" onclick="setToInput();" <?= $sendActual_checked ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>
                  <?= lang('試作品') ?>
                </label>
              </div>
              <font color="red">※<?= lang('プレミアムは試作品代金が無料') ?></font>
              <font color="red">※<?= lang('ご注文納期とは別に、6営業日+配送2日がかかります。') ?></font>
            </div>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name">
                  <div class="switch_off_button b2 switch_off">
                    <input type='hidden' value='なし' name='DeFormat'>
                    <input type="checkbox" class="checkbox" name="DeFormat" value="あり" onclick="setToInput();" <?= $others_checked ?>>
                    <div class="knobs">
                      <span></span>
                    </div>
                    <div class="layer"></div>
                  </div>
                  <?= lang('データトレース') ?>
                </label>
              </div>
              <font color="red">※<?= lang('プレミアムはトレース代金が無料') ?></font>
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
                      <td class="" style="text-align: left;">90X90mm<?= lang('以内。') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('形状タイプ') ?></td>
                      <td class="" id="prd_shape_custom" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('裏面印刷') ?></td>
                      <td class="" id="prd_silk_print" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class="" id="prd_coating" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('フチ加工') ?></td>
                      <td class="" id="prd_shape_border" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('ご注文本数') ?></td>
                      <td class="" id="prd_qty" style="text-align: left;"></td>
                    </tr>
                    <tr style="display: none;">
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class="" id="prd_part" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('台紙') ?></td>
                      <td class="" id="prd_paper" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('試作品') ?></td>
                      <td class="" id="prd_SendPrototype" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class="" id="prd_DeFormat" style="text-align: left;"><?= lang('なし') ?></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('カラーバリエーション') ?></td>
                      <td class="" id="prd_ItemDesign" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('特殊素材') ?></td>
                      <td class="" id="prd_ItemMaterial" style="text-align: left;"></td>
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
                    <tr style="display: none;">
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
                      <td class="TableLeft"><?= lang('特殊素材') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="MaterialCharge" readonly="readonly" id="MaterialCharge" class="right" value="<?= $MaterialCharge ?>">円</td>
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
                      <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="clearValue();$('#cus_detail').hide();valid_chk_btn2('step1');" />
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn2('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn2('step2');$('#cus_detail').hide();"><?= lang('オプション修正') ?></a>
                      <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle()" />
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
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn2('back')"><?= lang('戻る') ?></a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn2('next')"><?= lang('オプション入力へ') ?></a>
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');$('.loading').show();" value="御社情報確定（PDF出力）" />
                  <div class="remark">&nbsp;※<?= lang('社名や会社名の入力は任意です') ?></div>
                  <span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr />
      <?php $fd_type = "rubbercoastor"; ?>
      <h2><?= lang('裏面印刷・汚れ防止加工・蓄光・蛍光・ラメ材料・金色銀色') ?></h2>
      <table class="table_rubber table_rubber_final" cellpadding="5" cellspacing="0">
        <tbody>
          <tr>
            <td width="20%">裏面印刷（単色・カラー）</td>
            <td width="80%">
              単色（シルク）印刷【@33円（税込）】もしくはカラー印刷【@55円（税込）】ができます。<br />
              ・会社やグループの名前、マーク、QRコード<br />
              ・営業日や営業時間、電話番号など<br />
              ・製品の著作権表示
            </td>
          </tr>
          <tr>
            <td width="20%">汚れ防止加工</td>
            <td width="80%">
              オリジナルコースターに付着した日常的な汚れが簡単にとれる加工です。【@99円（税込）】気になる黒ずみなどの汚れが付きにくく、また付着した場合でも落ちやすくなります。※納期は、＋3～5営業日かかります。
            </td>
          </tr>
          <tr>
            <td width="20%">
              <a href="/products/img/rubber-color-n.webp" data-lightbox="imgmn-set2" style="text-decoration:none;position:relative;">蛍光<span class="ballroon"><span class="inner">MORE</span></span></a>
              <a href="/products/img/rubber-color-z.webp" data-lightbox="imgmn-set2" style="text-decoration:none;"></a>
            </td>
            <td width="80%">蛍光系材料（オレンジ、緑、黄色、ピンク）を使用したコースターの製作ができます。【@33円（税込）】</td>
          </tr>
          <tr>
            <td width="20%">
              <a href="/products/img/rubber-crytal-n.webp" data-lightbox="imgmn-set3" style="text-decoration:none;position:relative;">ラメ<span class="ballroon"><span class="inner">MORE</span></span></a>
              <a href="/products/img/rubber-crytal-z.webp" data-lightbox="imgmn-set3" style="text-decoration:none;"></a>
            </td>
            <td width="80%">無色半透明材料にラメを散りばめた素材を使用することで、涼しげな印象を持たせることができます。【@33円（税込）】</td>
          </tr>
          </tr>
          <tr>
            <td width="20%">
              <a href="images/pic3_2023.webp" data-lightbox="imgmn-set4" style="text-decoration:none;position:relative;">金色銀色<span class="ballroon"><span class="inner">MORE</span></span></a>
              <a href="images/zoom7.webp" data-lightbox="imgmn-set4" style="text-decoration:none;"></a>
            </td>
            <td width="80%">お店の名前やロゴを金色、銀色素材で表現できます。【@33円（税込）】</td>
          </tr>
          <tr>
            <td width="20%">
              <a href="images/zoom13.webp?v=1.01" data-lightbox="imgmn-set5" style="text-decoration:none;position:relative;">蓄光<span class="ballroon"><span class="inner">MORE</span></span></a>
              <a href="images/zoom14.webp?v=1.01" data-lightbox="imgmn-set5" style="text-decoration:none;"></a>
            </td>
            <td width="80%">蓄光（光りを蓄積する）材料を使ってコースターを製作できます。【@33円（税込）】<br />
              日光のあたる場所に製品を20～30分程度放置しておくと、約1時間程度光ります。発行色は、緑色とオレンジ色の2色。</td>
          </tr>
        </tbody>
      </table>

      <div style="clear:both;">&nbsp;</div>
      <h3 class="title-orange">裏面印刷（単色・カラー）</h3>
      <p class="new-text">お店の名前、開店日、記念日等を1色で印刷できます。文字だけでなく、マークやキャラクター、QRコード等も印刷できます。</p>
      <div class="flex-container">
        <div class="flex-item item">
          <a href="images/top_09.webp" data-lightbox="top-set1" style="text-decoration:none;">
            <img src="images/top_09.webp" class="w-100">
          </a>
          <a href="images/zoom9.webp" data-lightbox="top-set1" style="text-decoration:none;"></a>
        </div>
        <div class="flex-item item">
          <a href="images/top_10.webp" data-lightbox="top-set2" style="text-decoration:none;">
            <img src="images/top_10.webp" class="w-100">
          </a>
          <a href="images/zoom10.webp" data-lightbox="top-set2" style="text-decoration:none;"></a>
        </div>
      </div>
      <img src="/products/images/fc_printing_backside.webp?v=1.01">
      <div style="clear:both;">&nbsp;</div>
      <h3 class="title-orange">汚れ防止加工</h3>
      <?php include('../coating_details_2026.php'); ?>
      <div style="clear:both;">&nbsp;</div>

      <!-- <h2>オリジナルコースターに関するFAQ</h2>
      <p class="text-warning new-text">1. グラスについた水滴で、オリジナルコースターも一緒に持ち上がってしまいますか？</p>
      <div style="clear:both;">&nbsp;</div>
      <p class="new-text">オリジナルコースターは1枚およそ40g程度ございますので、グラスと一緒に持ち上がることはございません。品質ご評価用の無料サンプルをお送りすることができます。ご希望の場合、サンプル請求よりお申込みください。</p>
      <div style="clear:both;">&nbsp;</div>
      <p class="text-warning new-text">2. オリジナルコースターは、食洗器で洗うことはできますか？</p>
      <div style="clear:both;">&nbsp;</div>
      <p class="new-text">食洗器で洗っていただくことはできますが、デザインにより破損してしまう場合がございます。そのため、食洗器の頻繁なご利用を予定されている場合には、ご注文時に弊社の営業担当にご相談くださいませ。</p>
      <div style="clear:both;">&nbsp;</div>

      <p class="text-warning new-text">3. グラスを置いた時にグラグラしたり、コップが倒れやすくなったりしませんか？</p>
      <div style="clear:both;">&nbsp;</div>
      <p class="new-text">コースター面に凸部分がある場合でも、凸部分の高さは0.5mm程度ですので大きくグラグラすることはございません。気になる場合、表面が完全にフラットなデザインでのご注文をお勧めします。</p>

      <div style="text-align: center; margin: 15px auto 0;">
        <button class="but3">
          <a href="/faq/rubbercoaster.html" style="text-decoration: none; color: black; font-size: 16px; padding: 10px 40px;" class="">FAQをもっと見る <i class="fas fa-arrow-circle-right"></i></a>
        </button>
      </div>
       -->
        <div style="text-align: right;">
            <a href="https://hotmobily.jp/faq/details/rubberstrap/q4" class="new-text">汚れ防止加工の詳細はこちら</a><br><br>
        </div>


        <h3 class="title-orange">特殊素材や構造の種類について</h3>
        <div>
            <img src="https://hotmobily.jp/products/images/rubberstrap/rubberstrap_special.webp" alt="">
        </div><br>
        <div>
            <p class="new-text">金銀、ラメ、蛍光、蓄光などの特殊素材や、ラバーコースターの構造の種類などについてのガイドをご用意しております。ハイレベルなラバーコースターの製作にぜひともお役立てください。
            </p>
            <br>
            <div style="text-align: right;">
                <a href="https://hotmobily.jp/lp/rubber-guide-special.php" class="new-text">特殊素材についてはこちら</a>
                <br><br>
                <a href="https://hotmobily.jp/lp/rubber-guide-structure.php" class="new-text">ラバー製品の構造の種類についてはこちら</a>
            </div>
        </div>

        <div style="clear:both;">&nbsp;</div>
       <?php
            $favor = "rubbercoaster";
            if (isset($favor) && ($favor)) {
                include '../product-faq-v2.php';
            }
        ?>
        
      <div style="clear:both;">&nbsp;</div>
      <h2><?= lang('製作事例紹介') ?></h2>
      <p class="d_TEXT1 new-text"><?= lang('当店にご注文頂きました、オリジナルコースターの製作事例をご紹介させて頂きます。') ?></p>
      <div class="tag-menu">
        <?= lang('タグで絞込み') ?>：
        <a href='/gallery/rubbercoaster?tag=個人' class='tag-name' target="_blank"><?= lang('個人') ?></a>
        <a href='/gallery/rubbercoaster?tag=会社' class='tag-name' target="_blank"><?= lang('会社') ?></a>
        <a href='/gallery/rubbercoaster?tag=赤色' class='tag-name' target="_blank"><?= lang('赤色') ?></a>
        <a href='/gallery/rubbercoaster?tag=青色' class='tag-name' target="_blank"><?= lang('青色') ?></a>
        <a href='/gallery/rubbercoaster?tag=黄色' class='tag-name' target="_blank"><?= lang('黄色') ?></a>
        <a href='/gallery/rubbercoaster?tag=紫色' class='tag-name' target="_blank"><?= lang('紫色') ?></a>
        <a href='/gallery/rubbercoaster?tag=緑色' class='tag-name' target="_blank"><?= lang('緑色') ?></a>
        <a href='/gallery/rubbercoaster?tag=黒色' class='tag-name' target="_blank"><?= lang('黒色') ?></a>
        <a href='/gallery/rubbercoaster?tag=黒色' class='tag-name' target="_blank"><?= lang('白色') ?></a>
        <a href='/gallery/rubbercoaster?tag=1人' class='tag-name' target="_blank"><?= lang('1人') ?></a>
        <a href='/gallery/rubbercoaster?tag=複数人' class='tag-name' target="_blank"><?= lang('複数人') ?></a>
      </div>
      <!-- New image gallery -->
      <div class="ex-row">
        <div class="gall_pro">
          <div class="gallbox">
            <div class="prodate">2022<?= lang('年') ?>2<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-270622-1a.webp?v=0.1" data-lightbox="coaster-270622-1" data-title="S.様 2022年2月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-270622-1a.webp?v=0.1" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-270622-1b.webp?v=0.1" data-lightbox="coaster-270622-1" data-title="S.様 2022年2月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-270622-1c.webp?v=0.1" data-lightbox="coaster-270622-1" data-title="S.様 2022年2月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2022<?= lang('年') ?>2<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-270622-2a.webp?v=0.1" data-lightbox="coaster-270622-2" data-title="A.様 2022年2月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-270622-2a.webp?v=0.1" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-270622-2b.webp?v=0.1" data-lightbox="coaster-270622-2" data-title="A.様 2022年2月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-270622-2c.webp?v=0.1" data-lightbox="coaster-270622-2" data-title="A.様 2022年2月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2021<?= lang('年') ?>12<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-270622-3a.webp?v=0.1" data-lightbox="coaster-270622-3" data-title="G.様 2022年2月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-270622-3a.webp?v=0.1" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-270622-3b.webp?v=0.1" data-lightbox="coaster-270622-3" data-title="G.様 2022年2月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-270622-3c.webp?v=0.1" data-lightbox="coaster-270622-3" data-title="G.様 2022年2月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2020<?= lang('年') ?>10<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-230421-1a.webp" data-lightbox="coaster-230421-1" data-title="MQ commune 2020年10月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-230421-1a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-230421-1b.webp" data-lightbox="coaster-230421-1" data-title="MQ commune 2020年10月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-230421-1c.webp" data-lightbox="coaster-230421-1" data-title="MQ commune 2020年10月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2020<?= lang('年') ?>11<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-1a.webp" data-lightbox="coaster-130121-1" data-title="S.様 2020年11月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-1a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-1b.webp" data-lightbox="coaster-130121-1" data-title="S.様 2020年11月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-1c.webp" data-lightbox="coaster-130121-1" data-title="S.様 2020年11月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2020<?= lang('年') ?>3<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-2a.webp" data-lightbox="coaster-130121-2" data-title="JTIS 様 2020年3月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-2a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-2b.webp" data-lightbox="coaster-130121-2" data-title="JTIS 様 2020年3月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-2c.webp" data-lightbox="coaster-130121-2" data-title="JTIS 様 2020年3月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2020<?= lang('年') ?>5<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-3a.webp" data-lightbox="coaster-130121-3" data-title="M.様 2020年5月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-3a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-3b.webp" data-lightbox="coaster-130121-3" data-title="M.様 2020年5月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-3c.webp" data-lightbox="coaster-130121-3" data-title="M.様 2020年5月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2020<?= lang('年') ?>3<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-4a.webp" data-lightbox="coaster-130121-4" data-title="ゆめりあ 様 2020年3月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-4a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-4b.webp" data-lightbox="coaster-130121-4" data-title="ゆめりあ 様 2020年3月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-4c.webp" data-lightbox="coaster-130121-4" data-title="ゆめりあ 様 2020年3月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2019<?= lang('年') ?>9<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-6a.webp" data-lightbox="coaster-130121-6" data-title="B.様 2019年9月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-6a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-6b.webp" data-lightbox="coaster-130121-6" data-title="B.様 2019年9月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-6c.webp" data-lightbox="coaster-130121-6" data-title="B.様 2019年9月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2019<?= lang('年') ?>5<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-7a.webp" data-lightbox="coaster-130121-7" data-title="深浦フーズ 様 2019年5月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-7a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-7b.webp" data-lightbox="coaster-130121-7" data-title="深浦フーズ 様 2019年5月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-7c.webp" data-lightbox="coaster-130121-7" data-title="深浦フーズ 様 2019年5月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2019<?= lang('年') ?>4<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-9a.webp" data-lightbox="coaster-130121-9" data-title="インペリアルドラゴン 様 2019年4月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-9a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-9b.webp" data-lightbox="coaster-130121-9" data-title="インペリアルドラゴン 様 2019年4月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-9c.webp" data-lightbox="coaster-130121-9" data-title="インペリアルドラゴン 様 2019年4月" style="text-decoration:none;"></a>
          </div>
          <div class="gallbox">
            <div class="prodate">2019<?= lang('年') ?>5<?= lang('月') ?><?= lang('ご注文') ?></div>
            <a href="/gallery/img-coaster/coaster-130121-11a.webp" data-lightbox="coaster-130121-11" data-title="深浦フーズ 様 2019年5月" style="text-decoration:none;">
              <img src="/gallery/img-coaster/coaster-130121-11a.webp" class="picpro" width="229" height="229">
              <div class="camera-left">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
            <a href="/gallery/img-coaster/coaster-130121-11b.webp" data-lightbox="coaster-130121-11" data-title="深浦フーズ 様 2019年5月" style="text-decoration:none;"></a>
            <a href="/gallery/img-coaster/coaster-130121-11c.webp" data-lightbox="coaster-130121-11" data-title="深浦フーズ 様 2019年5月" style="text-decoration:none;"></a>
          </div>
        </div>

        <div style="text-align: center; margin: 15px auto 0;" class="">
          <button class="but3"><a href="/gallery/rubbercoaster" style="text-decoration: none; color: black; font-size: 16px; padding: 10px 40px;" class="">もっと製作事例を見る <i class="fas fa-arrow-circle-right"></i></a></button>
        </div>
      </div>
      <div style="clear:both;">&nbsp;</div>
            <hr>
      <div>
        <h2><?= lang('製品仕様・付属品等') ?></h2>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td><?= lang('名称') ?></td>
              <td><?= lang('オリジナルコースター') ?></td>
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
              <td><?= lang('裏面印刷') ?></td>
              <td><?= lang('単色（シルク）印刷、カラー印刷ともに可能です。プレミアムの場合は無料、スタンダードの場合は単色が＋@33円（税込）、カラーが＋@55円（税込）となります。') ?></td>
            </tr>
            <tr>
              <td><?= lang('試作品（実物校正サンプル）') ?></td>
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
              <td>1枚より。</a>
              </td>
            </tr>
          </tbody>
        </table>
    </div>

      <div style="clear:both;">&nbsp;</div>
      <h2>この商品に関する記事</h2>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/originalcoaster_1_hotmobily"><img src="/blog-content/upload/202308161827539455.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/originalcoaster_1_hotmobily">オリジナルコースターの作り方を徹底解説</a>
        </div>
      </div>
      <!-- <div style="clear:both;">&nbsp;</div>
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
      </div>-->
      <div>&nbsp;</div>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/howtomake-cheaper"><img src="/blog-content/upload/202310051309082634.jpg" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/howtomake-cheaper">知ってる人だけトクをする！オリジナルグッズを安く作る方法5選</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/about-trace"><img src="/blog-content/upload/202312201645595384.jpg" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/about-trace">オリジナルグッズ製作でよく聞く「トレース」って何？なぜ必要なの？</a>
        </div>
      </div>
      <hr />
      <h2><?= lang('営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。') ?></h2>
      <center><a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a></center>
      </p><br />

      <a href="https://hotmobily.jp/production/"><img data-src="/products/images/banner-production-v2.webp" class="lazy" width="100%" height="194" /></a><br><br />
    </div>
    <!-- :: content_wrapper end :: -->
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

  <script type="text/javascript" src="/js/_setToInput_2026.js?v=<?php echo date('is') ?>"></script>
  <script language="JavaScript" src="/js/validation_new.js?v=1.10" type="text/javascript"></script>
  <script type="text/javascript" src="/products/js/pdf_rubber_New.js?v=<?php echo date('is') ?>"></script>

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
        "product": "ラバーコースター"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
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

    var tmp = "<?= $_GET['mode'] ?>";
    $(function() {

      var t = $("#i_txt1"),
        s = $("#i_txt2");
      screen.width <= 768 && (t.attr("src", "images/img_txt2_n1.svg"), s.attr("src", "images/text_sample_n1.svg"))
    }, (tmp != "" ? valid_chk_btn2('step3') : ""), setToInput());

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
