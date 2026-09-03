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
    $_POST["$k"] = $v;
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

// $_SESSION['fd_name'] = 'rubbercoastor';
unset($_SESSION['fd_name']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="オリジナルお守り,ジャガード織,フルカラー,昇華転写,お土産グッズ,オリジナルグッズ制作,オリジナルデザイン,格安,大ロット,小ロット,ノベルティ">
  <meta name="description" content="オリジナルお守り制作を承っております。格安制作1個あたり200円（税込）から！大ロットがお得です。さらに小ロット50個から制作も可能。ジャガード織タイプとフルカラー（昇華転写）タイプの2種をご用意。お気軽にご注文・ご相談ください。">
  <meta name="robots" content="index,follow" />
  <title>オリジナルお守り制作！ジャガード織&フルカラー（昇華転写）</title>
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


    .mt-10-part .picpro {
      width: 98%;
      margin: 0;
    }

    .btn-a.btn-orange,
    .btn-a.btn-yellow {
        width: 80%;
        background-color: #f79647
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
      text-align: center !important
    }


    .mt-10-part div {
      text-align: center
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

    .exc_pro1 {
      position: relative;
      overflow: hidden;
      padding-bottom: 110px;
      max-height: 230px
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
      background: transparent url(/products/rubbercoaster/images/coaster_number_3.webp) no-repeat !important;
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
      gap: 15px;
    }

    .flex-item {
      flex: 0 0 50%;
      height: fit-content;
    }

    .mt-10-part {
      min-width: 23%;
      max-width: 23%
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
      justify-content: flex-start;
      flex-flow: row wrap;
      margin: 10px 0;
    }

    .group-container .btn-select {
      width: calc(20% - 6px);
      border: 1px solid #9e9e9e;
      text-align: center;
      margin-bottom: 10px;
      padding: 10px 5px;
      cursor: pointer;
      border-radius: 3px;
      transition-duration: 0.3s;
      position: relative;
      margin: 4px;
    }

    .btn-select img {
      width: 100%;
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

    .tab-container {
      width: 100%;
      margin: 0 auto;
    }

    .tab-header {
      display: flex;
      border-bottom: 2px solid #ccc;
    }

    .tab {
      flex: 1;
      padding: 10px 20px;
      text-align: center;
      cursor: pointer;
      background: #f1f1f1;
      color: #333;
      border: 1px solid #ccc;
      border-bottom: none;
      transition: background 0.3s ease;
      margin-bottom: 0 !important;
      margin-top: 10px;
    }

    .tab:not(.active):hover {
      background: #ddd;
    }

    .tab.tab-success.active {
      background: #fff;
      border-top: 3px solid rgb(13, 155, 13);
      font-weight: bold;
    }

    .tab.tab-warning.active {
      background: #fff;
      border-top: 3px solid rgb(235, 119, 42);
      font-weight: bold;
    }

    .tab-content {
      border: 1px solid #ccc;
      padding: 20px;
      background: #fff;
    }

    .h3-new {
      width: 100% !important;
      font-size: 17px !important;
      letter-spacing: 0.05em !important;
      padding: 13px 10px !important;
      background-image: repeating-linear-gradient(90deg, rgba(255, 165, 0, 1) 0, rgba(255, 165, 0, 1) 2px, rgba(0, 0, 0, 0) 2px, rgba(0, 0, 0, 0) 4px);
      background-size: 4px 4px;
      background-repeat: repeat-x;
      background-position: center bottom;
      margin-top: 20px;
      margin-bottom: 20px;
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

      <h1><?= lang('オリジナルお守りをご制作～ジャガード織&フルカラー（昇華転写）をご用意～') ?></h1>

      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/omamori/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a>
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aオリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます%0A%0A詳細はこちら:https://hotmobily.jp/products/omamori/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fomamori%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fomamori%2f&amp;text=オリジナルコースターの製作。同人からイベント、ノベルティまで、100枚から激安価格で製作できます" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
      </div>

      <img src="/products/images/OMAMORI_3.webp?v=1.03" width="771px" height="390px">
      <div>&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
            <swiper-slide><img src="/products/images/omamori01.webp?dd=<?php echo date('is') ?>"></swiper-slide>
            <swiper-slide><img src="/products/images/omamori07.webp?dd=<?php echo date('is') ?>"></swiper-slide>
            <swiper-slide><img src="/products/images/omamori04.webp?dd=<?php echo date('is') ?>"></swiper-slide>
          </swiper-container>
        </div>
        <div class="flex-item item new-text" style="display:grid;align-content: center;line-height: 2;">
          <p>デザインを糸で織り込むジャガード織タイプと、表面にデザインを印刷するフルカラータイプをご用意！</p><br>
          <p style="color:red;">大ロット注文なら1個あたり200円（税込）～の激安製作♪さらに、小ロット （50個から）のご注文も可能です！</p><br>
          <p>紐色は12色をご用意！お客様のデザインに合った色やお好きな色をお選びください。</p>
        </div>
      </div>
      <div style="clear:both;"></div>

      <!-- <h2><?= lang('レーザー彫刻で自由に名入れ可能！') ?></h2>
        <div class="d-flex">
            <div class="flex-item">
                <div class="">
                    <img src="/products/images/image_default.webp" alt="">
                </div>
            </div>
            <div class="flex-item new-text" style="padding-top:20px">
                <p>ボトルオープナーの表面に、レーザー彫刻で自由に文字を入れることが可能です。</p><br>
                <p>光沢のある本体にくっきりとしたホワイトのレーザー彫刻が際立ちます</p><br>
                <p>1行だけの文字入れも、2行に分けた文字入れも可能です。</p>
            </div>
        </div>
        <div style="clear:both;"></div> -->

      <h2><?= lang('ジャガード織タイプとフルカラータイプ') ?></h2>
      <div>
        <div class="d-flex">
          <div class="flex-item">
            <div class="">
              <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
                <swiper-slide><img src="/products/images/omamori02.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img src="/products/images/omamori05.webp?dd=<?php echo date('is') ?>"></swiper-slide>
              </swiper-container>
            </div>
          </div>
          <div class="flex-item new-text" style="">
            <h2 style="margin-bottom:10px;">ジャガード織</h2>
            <p>デザインを糸で織り込むので、高級感や立体感が出るのが特徴です。手で触れると刺繍のような質感があり、存在感のある仕上がりになります。</p><br>
            <p>プレミアム感を出したい場合や質感にこだわる場合におすすめです。</p><br>
            <p>デザインに使用可能な色数は8色が上限となっております。金・銀も対応可能です。</p>
          </div>
        </div>
        <br>
        <div class="d-flex">
          <div class="flex-item">
            <div class="">
              <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30" loop="true">
                <swiper-slide><img src="/products/images/omamori03.webp?dd=<?php echo date('is') ?>"></swiper-slide>
                <swiper-slide><img src="/products/images/omamori06.webp?dd=<?php echo date('is') ?>"></swiper-slide>
              </swiper-container>
            </div>
          </div>
          <div class="flex-item new-text" style="">
            <h2 style="margin-bottom:10px;">フルカラー</h2>
            <p>デザインをフルカラーで布の表面に印刷するので、カラーグラデーションの再現が可能なことや使用する色数の制限がないことが特徴です。さらに、ジャガード織よりも制作コストを抑えることができます。</p><br>
            <p>カラーデザインにこだわる場合や低コストで制作したい場合におすすめです。</p><br>
            <br>
            <a href="#prices">制作料金の詳細はこちら</a>
          </div>
        </div>
        <br>
      </div>
      <div style="clear:both;"></div>

      <h2><?= lang('12色の基本カラーをご用意！') ?></h2>
      <div>
        <p class="new-text">紐色は下記の12色をご用意しております。どの色をお選び頂いても料金に相違はございません。</p>
        <br>

        <?php
        $tempolary = array('真紅色', '薄紅色', 'あずき色', '金色', '黄土色', '青緑色', '濃紺色', '草緑色', '軍緑色', '薄紫色', '赤茶色', '茶色', '漂泊色', '空色');
        ?>
        <!-- <div class="d-flex2">
          <?php foreach ($tempolary as $index => $lyc): ?>
            <div class="">
              <div class="">
                <div class="txt-center">
                  <p><?php echo $lyc ?></p>
                </div>
                <img src="/products/images/color_<?php echo sprintf("%02d", ($index + 1)) ?>.webp" alt="">
              </div>
            </div>
          <?php endforeach; ?>
        </div> -->


        <div class="">
          <div class="swiper-container swiper-container-initialized swiper-container-horizontal swiper2">
            <div class="row">
              <?php foreach ($tempolary as $index => $lyc): ?>
                <?php if ($index == 3 || $index == 10) continue; ?>
                <div class="mt-10-part">
                  <div class="">
                    <a href="/products/images/color_<?php echo sprintf("%02d", ($index + 1)) ?>.webp?v=0.01" data-lightbox="acrylic_swiper<?php echo sprintf("%02d", ($index + 1)) ?>" style="text-decoration: none;" data-title="">
                      <img src="/products/images/color_<?php echo sprintf("%02d", ($index + 1)) ?>.webp?v=0.01" class="picpro" width="229" height="229" />
                      <div class="camera-left" style="text-decoration: none; font-size: 10px;">📷<?php echo $lyc ?></div>
                    </a>
                    <!-- <a href="/gallery/img-acrylic/2023-acrylic-gallery/50.webp?v=0.01" data-lightbox="acrylic_swiper<?php echo sprintf("%02d", ($index + 1)) ?>" data-title=""></a> -->
                    <!-- <a href="/gallery/img-acrylic/2023-acrylic-gallery/51.webp?v=0.01" data-lightbox="acrylic_swiper<?php echo sprintf("%02d", ($index + 1)) ?>" data-title=""></a> -->
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="mt-10-part">
              </div>
            </div>
          </div>
          <!-- <div class="swiper-button-next"></div>
            <div style="text-align: center; margin: 15px auto 0;">
                <a href="/gallery/acrylic_key"><img class="btn_z" src="/products/images/but3-02.webp" width="266" height="40" /></a>
            </div> -->
        </div>


      </div>
      <div style="clear:both;"></div>


      <h2>OPP個別包装サービスをご用意しております！</h2>
      <div>
        <div>
          <p class="new-text">当店のお守りは個別でPVC袋で包装されておりますが、ご希望であれば、PVC袋に入ったお守りをさらにOPP個別包装することが可能です。下の写真の、左がOPP袋なし（PVC袋のみ）、右がOPP個別包装です。</p>
        </div>
        <br>
        <div>
          <img src="/products/images/Omamori_packing.webp?v=1.03" width="771px" height="auto">
        </div>
        <div id="prices"></div>

      </div>

      <div style="clear:both;"></div>

      <h2><?= lang('制作料金') ?></h2>
      <div id="">
        <div class="tab-container">
          <div class="tab-header">
            <div class="tab tab-warning active" onclick="showTab(1)">ジャガード織タイプ</div>
            <div class="tab tab-success" onclick="showTab(2)">フルカラータイプ</div>
          </div>
        </div>



        <div class="price-table1 tab-panel">
          <?php
          $prices = [
            '50' => '450',
            '100' => '348',
            '300' => '224',
            '500' => '182',
            '1000' => '131',
            '3000' => '86'
          ];
          ?>
          <div style="clear: both;"></div>
          <div class="tbl_s cl2" style="position: relative;">
            <div class="scroll-center">
              <div class="arrow"></div>
            </div>

            <table class="tbl_price_deli">
              <thead>
                <tr>
                  <th style="background-color: #ffcccc;">個数</th>
                  <th>1個あたりの単価</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="background-color: #ffcccc;">50</td>
                  <td>750円</td>
                </tr>
                <tr>
                  <td style="background-color: #ffcccc;">100</td>
                  <td>440円</td>
                </tr>
                <tr>
                  <td style="background-color: #ffcccc;">500</td>
                  <td>350円</td>
                </tr>
                <tr>
                  <td style="background-color: #ffcccc;">1000</td>
                  <td>300円</td>
                </tr>
                <tr>
                  <td style="background-color: #ffcccc;">2000</td>
                  <td>250円</td>
                </tr>
                <tr>
                  <td style="background-color: #ffcccc;">3000</td>
                  <td>220円</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="price-table2 tab-panel" style="display: none;">
          <table class="tbl_price_deli">
            <thead>
              <tr>
                <th style="background-color: #ffcccc;">個数</th>
                <th>1個あたりの単価</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="background-color: #ffcccc;">50</td>
                <td>740円</td>
              </tr>
              <tr>
                <td style="background-color: #ffcccc;">100</td>
                <td>430円</td>
              </tr>
              <tr>
                <td style="background-color: #ffcccc;">500</td>
                <td>330円</td>
              </tr>
              <tr>
                <td style="background-color: #ffcccc;">1000</td>
                <td>260円</td>
              </tr>
              <tr>
                <td style="background-color: #ffcccc;">2000</td>
                <td>220円</td>
              </tr>
              <tr>
                <td style="background-color: #ffcccc;">3000</td>
                <td>200円</td>
              </tr>
            </tbody>
          </table>
        </div>

        <br>
        <div class="new-text">
          <p>※フルカラータイプをお選びの場合は、別途版型代金（税込6,600円）が発生します。</p>
          <p>※試作品を製作する場合は、別途6,600円（税込）追加となります。</p>
          <p>※個包装をご希望の場合は、1個あたり追加8円（税込）となります。</p>
          <p>※アドビイラストレータの入稿データをお持ちでない場合、当店にてイラストレータファイルに変換するトレース作業を行います。その際、製作料金とは別に2,200円（税込）がかかります。</p>
          <!-- <p>※当ページの注文フォームからは、1,000個までご注文可能です。1,000個を超える個数のご注文をご検討中の方はお問い合わせください。</p> -->
        </div>
      </div>

      <!-- End New Section -->

      <h2><?= lang('納期') ?></h2>
      <div>
        <div>
          <h2>本生産納期</h2>
          <div style="display: flex;">
            <div class="delivery"><span class="btn-a std-btn"><?= lang('通常納期'); ?></span></div>
            <div class="delivery">
              <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('15営業日後出荷'); ?></div>
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

      <h2><?= lang('入稿データについて') ?></h2>
      <div>
        <p class="new-text">入稿データ作成についてのご案内及びテンプレートをご用意しております。</p>
        <br>
        <div
            style="display: flex; flex-direction: row; justify-content: center; width: 100%; text-decoration:underline;">
            <a class="btn-a btn-yellow"
                href="/products/new-template/omamori_l_template_20260707_1310.zip"
                target="_blank" download><span><?= lang('テンプレートダウンロード') ?></span></a>
        </div>
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
            <h3 class="red">【<?= lang('オリジナルお守り') ?>】</h3>
            <span class="total-price"><span class="prd_total">0</span>円（<?= lang('税込') ?>）</span>
          </div>
          <div style="clear: both;"></div>
          <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
            <div class="step-box">
              <table class="table_rubber" style="padding: 0">
                <tr>
                  <td><?= lang('仕様タイプ') ?></td>
                  <td><span id="sample-prd-pcs">-</span></td>
                </tr>
                <tr>
                  <td><?= lang('紐色') ?></td>
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
                  <div class="step-number">1</div><span class="step-details"><?= lang('仕様タイプ・紐色・数量') ?></span>
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
            <div style="display: table-column;"><input type="text" name="ItemType" id="strap" value="オリジナルお守り" /></div>
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

              <h3><?= lang('仕様タイプ') ?></h3>
              <div class="part-container">
                <div class="part-content"><label class="part-name"><input type="radio" class="ItemPCS" name="ItemPCS" id="pcs1" value="ジャガード織タイプ" onclick="clearValue();check_val(this);" <?= $lsSelected_1pcs ?>><?= lang('ジャガード織タイプ') ?> <span class="checkmark"></span></label></div>
                <div class="part-content"><label class="part-name"><input type="radio" class="ItemPCS" name="ItemPCS" id="pcs2" value="フルカラータイプ" onclick="clearValue();check_val(this);" <?= $lsSelected_2pcs ?>><?= lang('フルカラータイプ') ?> <span class="checkmark"></span></label></div>
                <span style="color: red" id="error_pcs"></span>
              </div>

              <div class="color_area">
                <h3>紐色</h3>
                <div class="group-container">
                  <label class="btn-select">
                    <img src="/products/images/color_01.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="真紅色" <?= ($ItemColors == '真紅色' ? 'checked' : '') ?> onclick="clearValue();">真紅色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_02.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="薄紅色" <?= ($ItemColors == '薄紅色' ? 'checked' : '') ?> onclick="clearValue();">薄紅色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_03.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="あずき色" <?= ($ItemColors == 'あずき色' ? 'checked' : '') ?> onclick="clearValue();">あずき色
                  </label>
                  <!-- <label class="btn-select">
                    <img src="/products/images/color_04.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="金色" <?= ($ItemColors == '金色' ? 'checked' : '') ?> onclick="clearValue();">金色
                  </label> -->
                  <label class="btn-select">
                    <img src="/products/images/color_05.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="黄土色" <?= ($ItemColors == '黄土色' ? 'checked' : '') ?> onclick="clearValue();">黄土色
                  </label>

                  <label class="btn-select">
                    <img src="/products/images/color_06.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="青緑色" <?= ($ItemColors == '青緑色' ? 'checked' : '') ?> onclick="clearValue();">青緑色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_07.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="濃紺色" <?= ($ItemColors == '濃紺色' ? 'checked' : '') ?> onclick="clearValue();">濃紺色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_08.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="草緑色" <?= ($ItemColors == '草緑色' ? 'checked' : '') ?> onclick="clearValue();">草緑色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_09.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="軍緑色" <?= ($ItemColors == '軍緑色' ? 'checked' : '') ?> onclick="clearValue();">軍緑色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_10.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="薄紫色" <?= ($ItemColors == '薄紫色' ? 'checked' : '') ?> onclick="clearValue();">薄紫色
                  </label>

                  <!-- <label class="btn-select">
                    <img src="/products/images/color_11.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="赤茶色" <?= ($ItemColors == '赤茶色' ? 'checked' : '') ?> onclick="clearValue();">赤茶色
                  </label> -->
                  <label class="btn-select">
                    <img src="/products/images/color_12.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="茶色" <?= ($ItemColors == '茶色' ? 'checked' : '') ?> onclick="clearValue();">茶色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_13.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="漂泊色" <?= ($ItemColors == '漂泊色' ? 'checked' : '') ?> onclick="clearValue();">漂泊色
                  </label>
                  <label class="btn-select">
                    <img src="/products/images/color_14.webp?d=<?php echo date('is') ?>" alt="">
                    <input type="radio" class="ItemColors" name="ItemColors" value="空色" <?= ($ItemColors == '空色' ? 'checked' : '') ?> onclick="clearValue();">空色
                  </label>
                </div>
                <span style="color: red" id="error_color"></span>
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
                        <td class="TableLeft"><?= lang('版型代金') ?></td>
                        <td class=""><input id="prd_mold_price" type="text" name="prd_mold_price" readonly>円</td>
                      </tr>
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

      <h2><?= lang('当店お守り制作サービスの特徴！') ?></h2>
      <div>
        <h2 class="feature1">注文数が多いほどお得！激安価格でご提供！</h2>
        <p class="new-text">当店では、ご注文数量が多くなればなるほど1個あたりの単価が段階的にお安くなる、大変お得な「ボリュームディスカウント」を採用しております。例えば、全校生徒に配る卒業・入学の記念品をはじめ、企業の大規模な展示会やイベントで配布する販促ノベルティなど、数百個から数千個単位の大ロット製作においては、驚くほどリーズナブルな価格でのご提供が可能です。</p>
        <br>
        <p class="new-text">「よりたくさんの人に配りたいけれど、限られた予算内に収まるか不安…」「品質は絶対に落とさずに、コストだけを賢く抑えたい」とお悩みのご担当者様は、ぜひ一度当店にご相談ください。お客様の決められたご予算内で最高のコストパフォーマンスを発揮できるよう、最適なプランニングで全力サポートいたします！</p>

        <h2 class="feature2">豊富な紐色数！</h2>
        <p class="new-text">お守りの全体の印象を大きく左右する「結び紐」の部分にも徹底的にこだわっていただけるよう、当店ではバリエーション豊かな全12色の基本カラーを標準でご用意しております。</p>
        <br>
        <p class="new-text">王道の「真紅色」や華やかな「金色」をはじめ、「薄紅色」「青緑色」「草緑色」「茶色」「濃紺色」など、伝統的な和の雰囲気からポップなテイストまで幅広くカバーする絶妙な色合いを取り揃えました。学校のスクールカラーや部活動のチームカラー、企業のブランドカラーに合わせるのはもちろん、アイドルやキャラクターの「推し色」を採用するなど、アイデア次第で表現の幅が無限に広がります。</p>
        <br>
        <p class="new-text">どの紐色をお選びいただいても追加料金は一切かかりません。お客様のこだわりのオリジナルデザインの魅力をさらに引き立てる、とっておきの一色をぜひ見つけてください。</p>
        <!-- <br> -->

        <!-- <h2 class="feature3">大ロットにも柔軟にご対応！</h2>
        <p class="new-text">2,000個以上、3,000個以上などの大ロットにもご対応いたします。1,000個を超える数のご注文をご検討の方は、お気軽にお問い合わせください。</p>
        <br>

        <p class="new-text">※1,000個以下であれば、当ページの<a href="javascript:void(0)">注文フォーム</a>からご注文頂けます。</p><br>
        <br>
        <p class="new-text">※1,000個を超える大ロットご注文の方は、<a href="/contact">問い合わせフォーム</a>からご相談ください。お電話でのご相談も承っております。</p> -->
      </div>
      <div style="clear: both;"></div>

      <h2><?= lang('お守りの中身について') ?></h2>
      <div class="flex-container">
        <div class="flex-item item">
          <img src="/products/images/omamori_content.webp?v=1.03" alt="">
        </div>
        <div class="flex-item item new-text" style="display:grid;align-content: center;line-height: 2;">
          <p>お守りの袋の中は空となっております。綿や厚紙などは入っておりません。</p><br>
        </div>
      </div>

      <h2><?= lang('用途はさまざま！スポーツ・教育現場・推し活など！') ?></h2>
      <div>
        <img src="/products/images/omamori_banner03102026.webp?v=1.03" width="771px" height="390px" loading="lazy">
      </div>
      <br>
      <div class="">
        <p class="new-text">日本人にとって古くから親しまれてきた「お守り」は、単なるアイテムの枠を超え、誰かの幸せや成功を願う温かい思いが込められた特別な存在です。既製品にはない「自分たちだけの特別なメッセージ」を形にできるオリジナルお守りは、受け取った人の心を強く打ち、長く大切にされる唯一無二の記念品やノベルティとして幅広い用途で活用されています。</p>

        <h3 class="h3-new sm-bold">教育現場で配布する合格祈願グッズとして</h3>
        <p class="new-text">代表的な用途の一つが、学校法人や学習塾、予備校など教育現場における「合格祈願グッズ」です。受験という人生の大きな壁に立ち向かう生徒たちへ、先生方からの「頑張れ」「応援しているよ」という熱いエールを形にするのに、お守りほどふさわしいものはありません。例えば、学校や塾のロゴマーク、スローガン、さらには校舎のイラストなどをデザインに組み込むことで、試験会場という緊張を強いられる場所でも、いつもの学び舎との繋がりを感じられる心の拠り所となります。ホットモバイリーでは、伝統的で重厚感のある「ジャガード織」と、写真やグラデーションも鮮やかに表現できる「フルカラー印刷（昇華転写）」の2種類をご用意しているため、格式高さを重視した由緒あるデザインから、親しみやすいポップなデザインまで、思い通りの表現が可能です。</p>
        <h3 class="h3-new sm-bold">スポーツや部活動でのお守りとして</h3>
        <p class="new-text">また、スポーツ少年団や中学校・高校の部活動、さらにはプロスポーツチームのグッズとしてもオリジナルお守りは大活躍します。大会に向けた「必勝祈願」や、大きな怪我なくプレーできることを願う「安全祈願」として、チーム全員で同じお守りをカバンにつければ、団結力はより一層強固なものになります。ホットモバイリーのオリジナルお守りは、全12色という豊富な紐色を標準でご用意しているのが大きな強みです。真紅色、青緑色、金色など、チームのユニフォームカラーやスクールカラーに合わせて紐の色を選ぶことで、統一感のある洗練されたチームグッズが完成します。卒部式や引退試合の際に、後輩から先輩へ、あるいは指導者から選手へ贈る記念品としても、かけがえのない青春の思い出を彩る最高のプレゼントとなるでしょう。</p>
        <h3 class="h3-new sm-bold">販促グッズやノベルティとして</h3>
        <p class="new-text">さらに、オリジナルお守りの活躍の場は教育やスポーツの現場に留まりません。企業の販促キャンペーンやイベントのノベルティとしても、非常に高いポテンシャルを秘めています。例えば、交通安全キャンペーンでの配布物として、企業ロゴと「無事故祈願」のメッセージを入れたお守りは、実用性とメッセージ性を兼ね備えた優れたPRアイテムになります。自動車ディーラーや保険会社などの成約記念品としても喜ばれるはずです。また、近年盛り上がりを見せているアニメやゲーム、アイドルなどの「推し活」グッズとしても、オリジナルお守りは大人気です。キャラクターのイラストやアイドルのメンバーカラーを使用したお守りは、「推し」の健康や活躍を祈るアイテムとして、あるいはファン同士の連帯感を生むグッズとして、物販コーナーで高い売上を期待できる商材です。フルカラータイプであれば、キャラクターの繊細な色使いも忠実に再現できますし、ジャガード織であれば、伝統工芸品のような付加価値をつけることができます。</p>
        <h3 class="h3-new sm-bold">ホットモバイリーならあらゆる活用シーンに対応可能！</h3>
        <p class="new-text">ホットモバイリーのオリジナルお守り製作は、50個という小ロットから対応可能なため、クラス単位や小さなサークルでのご注文から、数千個規模の大型イベント、企業ノベルティまで、あらゆる規模のニーズに柔軟にお応えします。大ロットになるほど1個あたりの単価が下がり、最安220円(税込）という激安価格での製作が可能になる点も、予算管理が厳しい担当者様にとって大きなメリットです。Illustratorなどの専門ソフトをお持ちでない場合でも、データ作成からしっかりとサポートさせていただきます。「どんなデザインにすればいいか迷っている」「予算内でどれくらい作れるか知りたい」といったご相談も大歓迎です。大切な誰かを思いやる気持ち、チームの強い絆、企業からお客様への感謝の思い。そんな目に見えない大切な「思い」を、ホットモバイリーの高品質なオリジナルお守りという形にして、一人でも多くの方へ届けてみませんか。</p>
      </div>

      <h2><?= lang('製品仕様・付属品等') ?></h2>
      <div class="new-text">
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td>名称</td>
              <td>オリジナルお守り</td>
            </tr>
            <tr>
              <td>素材</td>
              <td>ポリエステル</td>
            </tr>
            <tr>
              <td>サイズ</td>
              <td>50X80mm以内</td>
            </tr>
            <tr>
              <td>印刷方法</td>
              <td>ジャガード織/昇華転写印刷（フルカラー）</td>
            </tr>
            <tr>
              <td>色数</td>
              <td>ジャガード織は8色まで/昇華転写印刷は無制限</td>
            </tr>
            <tr>
              <td>紐色</td>
              <td>12色</td>
            </tr>
            <tr>
              <td>最小ロット</td>
              <td>50個</td>
            </tr>
            <tr>
              <td>包装</td>
              <td>一括包装（お守りが個別でPVC袋に包装されている状態です）・個別OPP包装（お守りを個別でPVC袋の上からさらにOPP袋で包装した状態です）</td>
            </tr>
            <tr>
              <td>納期</td>
              <td>15営業日後出荷</td>
            </tr>
            <tr>
              <td>袋の中身について</td>
              <td>お守りの袋の中は空です</td>
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
  <script type="text/javascript" src="<?= $cal_omamori_js ?>"></script>
  <script type="text/javascript" src="<?= $pdf_omamori_js ?>"></script>

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