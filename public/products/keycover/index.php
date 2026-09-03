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

  ClearSessionPrice();
}
// エラー出力用
$mrErrMsgList = array();
$msErrFocusCtl = "";

//メイン関数の呼出
Main();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="ラバー,キーカバー,オリジナル,作成,製作,同人">
  <meta name="description" content="キーカバーをオリジナルのデザインで製作できます。半立体構造のラバーキーカバー。裏面のデザインもコミ。">
  <meta name="robots" content="index,follow" />
  <title>キーカバーをオリジナルのデザインで製作できます。半立体構造のラバーキーカバー</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css?v=1.01" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <?php include("../../head_products.html"); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.03" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
  <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">
  <link rel="stylesheet" type="text/css" href="../css/scroll.css">

  <link href="/css/rubber.css?v=1.02" rel="stylesheet" type="text/css" />
  <style type="text/css">

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }
    
    @media(max-width: 576px) {
      label.part-name img {
        width: calc(100% - 5px) !important;
      }

      #step2 .flex-container {
        overflow-x: hidden;
      }
    }

    @media(max-width: 576px) {
      div.howto+div {
        font-size: 5vw !important;
      }
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

    .repeat input[type="text"] {
        padding: 5px 10px;
        margin-left: -32px;
        width: -webkit-fill-available;
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

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
      <?php include("../rubber_info.php"); ?>
      <?php include('../banner-campaign.php') ?>
      <h1>キーカバーをオリジナルのデザインで製作できます。半立体構造のラバーキーカバー (2026年版)</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aキーカバーをオリジナルのデザインで製作できます。半立体構造のラバーキーカバー。裏面のデザインもコミ。%0A%0A詳細はこちら:https://hotmobily.jp/products/keycover/" title="Share by Email" target="_blank">シェアする</a>
          <a href="mailto:?subject=ホットモバイリーのこの商品を推薦したいと思います&amp;body=ホットモバイリーのこの商品を推薦したいと思います%0A%0Aキーカバーをオリジナルのデザインで製作できます。半立体構造のラバーキーカバー。裏面のデザインもコミ。%0A%0A詳細はこちら:https://hotmobily.jp/products/keycover/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fkeycover%2f" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fkeycover%2f&amp;text=キーカバーをオリジナルのデザインで製作できます。半立体構造のラバーキーカバー。裏面のデザインもコミ。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <img src="/products/images/rubber_feature_banner.webp?v=1.02">
      <div>&nbsp;</div>
      <div class="flex-container">
        <div class="flex-item item">
          <div class="preview-container">
            <div class="preview-top my-gallery">
              <div id="box-show-id-1">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1366x841">
                    <img class="zoom-img" id="zoom_01" src="images/keycover-1.webp" width="376" height="231" data-zoom-image="images/keycover-1.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-2" style="display: none;">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1366x841">
                    <img class="zoom-img" id="zoom_02" src="images/keycover-2.webp" width="376" height="231" data-zoom-image="images/keycover-2.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-3" style="display: none;">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1366x841">
                    <img class="zoom-img" id="zoom_03" src="images/keycover-3.webp" data-zoom-image="images/keycover-3.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
              <div id="box-show-id-4" style="display: none;">
                <figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                  <a href="javascript:void(0)" itemprop="contentUrl" data-size="1366x841">
                    <img class="zoom-img" id="zoom_04" src="images/keycover-4.webp" width="376" height="231" data-zoom-image="images/keycover-4.webp" itemprop="thumbnail">
                  </a>
                </figure>
              </div>
            </div>
            <div class="preview-sub flex-container">
              <div class="flex-item"><img src="images/keycover-1.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-1').show();">
              </div>
              <div class="flex-item"><img src="images/keycover-2.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-2').show();">
              </div>
              <div class="flex-item"><img src="images/keycover-3.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-3').show();">
              </div>
              <div class="flex-item"><img src="images/keycover-4.webp" width="93" height="58" onclick="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();" onmouseover="$('.preview-top div').each(function(){$(this).hide()});$('#box-show-id-4').show();">
              </div>
            </div>
          </div>
          <div style="font-size: 12px;" class="camera-preview">📷大きな画像にマウスを合わせると拡大されます</div>
          <div class="ptw-container"></div>
        </div>
        <div class="flex-item item new-text">
          オリジナルラバーキーカバーが製作できます。自由な形状でオリジナルのデザインができます。<br /><br />
          鍵に取り付けると、保護やデコレーションの役割を果たします。目立つ色で製作すればバッグの中で見つけやすく、紛失防止にもなります。<br /><br />
          表面だけでなく、裏面も自由にデザイン可能。基本サイズは縦70mmX横70mm以内、厚さは通常約3mm。<br /><br />
          小ロット・短納期で製作できるため、イベントグッズやノベルティグッズにおすすめです。
        </div>
      </div>
      <div style="clear:both;"></div>

        <h2>ラバー製品完全ガイドをご用意！</h2>
        <div>
            <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
        </div>
        <div>
            <p class="new-text">初めてラバー製品の製作を依頼する方や、クオリティに独自のこだわりがある方なら、「製作を依頼するのに何が必要なのかな？」「どんなラバー製品が製作可能なのかな？」などの疑問が出てきますよね。</p><br>
            <p class="new-text">そんな方のために、ラバー製品の注文の流れや、さまざまな加工タイプ、特殊素材などについて解説した完全ガイドをご用意。
            </p><br>
            <p class="new-text">安心してハイクオリティのラバーキーカバーを製作するために、ぜひともお役立てください。</p>
            <br>
            <div style="text-align: right;">
                <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
            </div>
        </div>

      <div style="clear:both;"></div>
      <h2>ラバーキーカバーとは、どんな製品？</h2>
      <div class="block-g">
        <div class="block-title" style="background: #febc28;">RUBBER KEY COVER FRONT</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/keycover-5z.webp" data-lightbox="imgst-set" style="text-decoration:none;">
              <img src="images/keycover-5.webp" width="453" height="268">
            </a>
          </div>
          <div class="bp2">
            <a href="images/keycover-6z.webp" data-lightbox="imgst-set" style="text-decoration:none;">
              <img src="images/keycover-6.webp" width="239" height="268">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/keycover-5z.webp" data-lightbox="imgst-set01" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します</a>
          <a href="images/keycover-6z.webp" data-lightbox="imgst-set01"></a>
        </div>
        <div class="b-text">印刷では無く、液体ラバー（ゴム）を成型し形を作ります。金型を使って形を作りますので、細かな模様も綺麗に再現できます。</div>
      </div>
      <div class="block-g">
        <div class="block-title" style="background: rgb(146,208,80);">RUBBER KEY COVER BACK</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/keycover-7z.webp" data-lightbox="imgst-set2" style="text-decoration:none;">
              <img src="images/keycover-7.webp" width="453" height="268">
            </a>
          </div>
          <div class="bp2">
            <a href="images/keycover-8z.webp" data-lightbox="imgst-set2" style="text-decoration:none;">
              <img src="images/keycover-8.webp" width="239" height="268">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/keycover-7z.webp" data-lightbox="imgst-set02" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します</a>
          <a href="images/keycover-8z.webp" data-lightbox="imgst-set02"></a>
        </div>
        <div class="b-text">裏面も立体加工が可能です。平面にして、シルク印刷を入れる事も出来ます。</div>
      </div>
      <div class="block-g">
        <div class="block-title" style="background: rgb(248,203,173);;">RUBBER KEY COVER SIDE</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/keycover-9z.webp" data-lightbox="imgst-set3" style="text-decoration:none;">
              <img src="images/keycover-9.webp" width="453" height="268">
            </a>
          </div>
          <div class="bp2">
            <a href="images/keycover-10z.webp" data-lightbox="imgst-set3" style="text-decoration:none;">
              <img src="images/keycover-10.webp" width="239" height="268">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/keycover-9z.webp" data-lightbox="imgst-set03" style="text-decoration:none; font-size: 10px;">📷クリックすると拡大します</a>
          <a href="images/keycover-10z.webp" data-lightbox="imgst-set03"></a>
        </div>
        <div class="b-text">側面は最下層3mm、2層目・3層目が0.5mmとなります。最下層、2層目、3層目はそれぞれ写真のような仕上がりとなります。</div>
      </div>
      <hr />
      <h2>ラバーキーカバーの製作工程のご紹介</h2>
      <div class="videoWrapper">
        <img src="/products/img/rubber-production-yt.webp" data-src="5KK0a4b1C9Q" class="iframe" width="773" height="435">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <hr />
      <!-- <div>
        <h2><?= lang('製品仕様・付属品等') ?></h2>
        <table class="table_rubber" cellpadding="5" cellspacing="0">
          <tbody>
            <tr>
              <td><?= lang('名称') ?></td>
              <td><?= lang('ラバーキーカバー') ?></td>
            </tr>
            <tr>
              <td><?= lang('素材') ?></td>
              <td><?= lang('ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)。熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細は') ?><a href="/products/foodproducts.php?data=keycover" target="_blank">こちら</a>。</td>
            </tr>
            <tr>
              <td><?= lang('大きさ') ?></td>
              <td><?= lang('縦70mmX横70mm以内。（このサイズを超える製品は、別途費用がかかります）') ?></td>
            </tr>
            <tr>
              <td><?= lang('厚さ') ?></td>
              <td><?= lang('通常約3mm。肉厚指定のある場合、事前にご相談下さい。') ?></td>
            </tr>
            <tr>
              <td><?= lang('色数') ?></td>
              <td><?= lang('スタンダードの場合12色まで、プレミアムの場合18色までご使用頂けます。') ?><br>
                <?= lang('印刷物ではないため、グラデーションは表現できません。') ?></td>
            </tr>
            <tr>
              <td><?= lang('色指定') ?></td>
              <td><?= lang('以下2通りのいづれか。①PANTONE(パントーン)もしくは、DIC(ディック)番号によるご指定。②弊社もしくは、お客様が印刷された、色見本（カラーペーパー）によるご指定。') ?>
              </td>
            </tr>
            <tr>
              <td><?= lang('裏面印刷') ?></td>
              <td>平面にして、単色（シルク）印刷、カラー印刷をすることが可能です。プレミアムの場合は無料、スタンダードの場合は単色が＋@33円（税込）、カラーが＋@55円（税込）となります。</td>
            </tr>
            <tr>
              <td><?= lang('最小製作個数（最小ロット）') ?>
              </td>
              <td><?= lang('100個より製作します。（ホットモバイリーファンは、10個9,900円です。）') ?></td>
            </tr>
            <tr>
              <td><?= lang('台紙') ?></td>
              <td><?= lang('オプションとして台紙の封入が可能です。') ?>
                <a href="/products/daishi.html"><?= lang('台紙封入の詳細。') ?></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div> -->

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
        <a href="/products/new-template/template-keycover-final.zip" class="resource-button" style="color: #233c4a">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <path d="M12 18v-7"></path>
            <path d="M8.5 14.5 12 18l3.5-3.5"></path>
          </svg>
          <span>入稿データテンプレートをダウンロード</span>
        </a>

        <a href="/products/data" class="resource-button" style="color: #233c4a">
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

        <a href="/contact/?item=ラバーキーカバー" class="resource-button" style="color: #233c4a">
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
      <!-- <div class="row how" style="margin-top: -8px;">
        <a class="mt-10 btn-a btn-yellow" href="/lp/rubber-guide-structure.php" target="_blank">
          <div class="howto"><img src="/products/images/icon-kako-rb.webp" width="34" height="34"></div>
          <div>立体加工詳細</div>
        </a>
        <a class="mt-10 btn-a btn-yellow" href="/products/quality.html" target="_blank">
          <div class="howto"><img src="/products/images/icon-qlt-rb.webp" width="34" height="34"></div>
          <div>品質基準詳細</div>
        </a>
        <a href="javascript:void(0)" class="mt-10 btn-a btn-yellow" for="modal-1" style="cursor: pointer;" onclick="$('#modal-1').prop('checked',true)">
          <div class="howto"><img src="/products/images/icon-des-rb.webp" width="34" height="34"></div>
          <div>お客様へのお約束</div>
        </a>
        <input class="modal-state" id="modal-1" type="checkbox" />
        <div class="modal">
          <label class="modal__bg" for="modal-1"></label>
          <div class="modal__inner modal1">
            <label class="modal__close" for="modal-1"></label>
            <h2>ホットモバイリーから皆様へのお約束</h2>
            <p class="d_TEXT1">ホットモバイリーは、日々皆様と接しデザインを作成、製品の製作をする中で、<br>
              お客様対応と製品品質で日本一でありたいと思い事業活動を行っております。<br>
              そのために以下の点を事業活動の指針としています。</p>

            <h2>数あるノベルティー製作会社の中で、最もきめの細かなサービスを提供する。</h2>
            <p class="d_TEXT1">製品の品質に責任を持つ。<br>
              これら2つの事業活動の指針を実現する為、具体的には以下の点を常に意識してサービスを提供しています。</p>

            <h2>皆様のデザインを出来る限り忠実に製品化する。</h2>
            <p class="d_TEXT1">皆様のデザインは電子データです。特にキャラクター製品は多くのディテールを含んでおり、<br>
              データ入稿、一発製品化とはいきません。 多くの場合修正を必要としますが、その修正は最低限に留める。</p>

            <h2>皆様が納得いくまで、何回でもデザインの修正を行います。</h2>
            <p class="d_TEXT1">ホットモバイリーは理解しています、オリジナルグッズの製作が決して安くないことを。<br>
              ですから皆様に納得して頂けるまで、何度でも デザインの修正を無料で行います。<br>
              デザイン修正を行った結果、オリジナルグッズの製作を希望されない場合、料金はかかりません。</p>

            <h2>品質基準を明確にし、品質基準を満たさない製品が納品されてしまった場合、無条件で製品の再作製を行います。</h2>
            <p class="d_TEXT1">ホットモバイリーは製品の品質基準を明確にし、全てのお客様に公表しています。<br>
              この品質基準は、業界で最も厳しい基準だと考えております。<br>
              このような管理をしても、海外生産ということもあり、品質基準を満たさない製品が皆様に納品されしまうことがあります。<br>
              その際は理由の如何を問わず、全数再作成し、再度納品させて頂いております。<br>
              皆様に満足頂くこと、これはホットモバイリーの使命です。</p>

            <h2>ホットモバイリーで製作頂いた全てのお客様に、アンケートでご不満な点を質問し、その回答を誰でも閲覧できるように公開します。</h2>
            <p class="d_TEXT1">インターネットだけで、高額な買い物をするには不安が残る。ホットモバイリーは、本当に大丈夫なのか？我々が大丈夫だと言うより、<br>
              皆様に答えて頂いた方がより的確に判断して頂けます。全てのホットモバイリーご利用者様にアンケートを実施。<br>
              特に記述式で満足した点でなく、不満な点を記載してもらうようお願いしています。<br>
              アンケート結果は全て公開。弊社で回答の改ざんができないよう、第三者のシステムを利用しています。<br>
              ご意見をもとに改善させて頂いた例は多く、例えば<br><br>

              WEBサイトだけで販売されているので、売っている人の顔が見えない。スタッフの自己紹介をWEBでやったら良いのではないか。<br>
              →WEBサイトにスタッフ紹介を追加しました。<br><br>

              <span style="color: red;">皆様の貴重なご意見やお叱りがホットモバイリーを強くしてくれます。</span>
            </p>
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
      <?php $page = 'product';
      include('../../campaign_2021.php'); ?>

      <div style="clear:both;"></div>

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
        <span class="font_s" style="float:right; text-align: right;">
          <span class="sun">※</span><?= lang('お急ぎの場合、営業担当にご相談下さい。出来る限りお客様のご希望に沿うよう対応させていただきます。'); ?><br>
          <span class="sun">※</span><?= lang('営業日には、土日祝日を含みません。'); ?><br>
        </span>
      </div>
      <div style="clear:both;"></div>
      <hr />
      <h2>アタッチメント</h2>
      <p class="new-text">
        写真をクリックすると拡大写真と詳細説明を確認頂けます。
      </p>
      <br>
      <div class="row">
        <div class="mt-10-part">
          <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
            <img class="picpro" src="/products/images/HM_part1.webp" width="160" height="160">
          </a><br />
          <div>+0円</div>
          <a href="/products/images/HM_part1.webp" data-lightbox="img-part-set-1-1" data-title="<strong>【通常松葉+カニカン】</strong>製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
            <img class="picpro" src="/products/images/HM_part2.webp" width="160" height="160">
          </a><br />
          <div>+0円</div>
          <a href="/products/images/HM_part2.webp" data-lightbox="img-part-set-2-1" data-title="<strong>【ゴム松葉+カニカン】</strong>松葉紐が伸縮します。製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。">
            <img class="picpro" src="/products/images/HM_part14.webp" width="160" height="160">
          </a><br />
          <div>+0円</div>
          <a href="/products/images/HM_part14.webp" data-lightbox="img-part-set-14-1" data-title="<strong>【ボールチェーンシルバー】</strong>銀色のボールチェーンです。追加料金なく手配できるボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。">
            <img class="picpro" src="/products/images/HM_part3.webp" width="160" height="160">
          </a><br />
          <div>+11円</div>
          <a href="/products/images/HM_part3.webp" data-lightbox="img-part-set-3-1" data-title="<strong>【通常松葉+カニカン+スマホプラグ】</strong>通常松葉+カニカンの紐の先端にスマホプラグがついています。イヤホンジャックに挿入して使用できます。また、製品本体と松葉を切り離すことができますので、携帯電話等への取り付けが容易になります。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。">
            <img class="picpro" src="/products/images/HM_part9.webp" width="160" height="160">
          </a><br />
          <div>+11円</div>
          <a href="/products/images/HM_part9.webp" data-lightbox="img-part-set-9-1" data-title="<strong>【ボールチェーン黄色】</strong>黄色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。">
            <img class="picpro" src="/products/images/HM_part10.webp" width="160" height="160">
          </a><br />
          <div>+11円</div>
          <a href="/products/images/HM_part10.webp" data-lightbox="img-part-set-10-1" data-title="<strong>【ボールチェーン赤色】</strong>赤色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。">
            <img class="picpro" src="/products/images/HM_part11.webp" width="160" height="160">
          </a><br />
          <div>+11円</div>
          <a href="/products/images/HM_part11.webp" data-lightbox="img-part-set-11-1" data-title="<strong>【ボールチェーン青色】</strong>青色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。">
            <img class="picpro" src="/products/images/HM_part12.webp" width="160" height="160">
          </a><br />
          <div>+11円</div>
          <a href="/products/images/HM_part12.webp" data-lightbox="img-part-set-12-1" data-title="<strong>【ボールチェーンピンク色】</strong>ピンク色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
        <div class="mt-10-part">
          <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。">
            <img class="picpro" src="/products/images/HM_part13.webp" width="160" height="160">
          </a><br />
          <div>+11円</div>
          <a href="/products/images/HM_part13.webp" data-lightbox="img-part-set-13-1" data-title="<strong>【ボールチェーン緑色】</strong>緑色のボールチェーンです。" style="font-size: 10px;">📷クリックすると拡大します</a>
        </div>
      </div>
      <h2>製作料金一覧</h2>
      <p class="d_TEXT1 new-text">
        製作料金の一覧の表で確認頂けます。製作本数や製作条件を指定して、製作料金を確認したい場合、<a href="/estimate/">自動見積ページ</a>にてご確認下さい。
      </p><br />
      スタンダード
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>977 円</td>
            <td>750 円</td>
            <td>521 円</td>
            <td>382 円</td>
            <td>281 円</td>
            <td>210 円</td>
            <td>157 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(97,700 円)</td>
            <td>(150,000 円)</td>
            <td>(156,300 円)</td>
            <td>(191,000 円)</td>
            <td>(281,000 円)</td>
            <td>(630,000 円)</td>
            <td>(785,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br />
      </div>

      <div>&nbsp;</div>
      スタンダード（スピード発送）
      <div class="tbl_s" style="position: relative;">
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>100個～</td>
            <td>200個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1098 円</td>
            <td>871 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(109,800 円)</td>
            <td>(174,200 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('スピード発送の場合、最大ロットは200個となります。') ?><br />
        ※<?= lang('裏面印刷代金、トレース代金は含まれておりません。') ?><br />
        ※<?= lang('汚れ防止加工はできません。') ?><br />
      </div>
      <div>&nbsp;</div>

      プレミアム
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td>&nbsp;</td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td>製品単価</td>
            <td>1086 円</td>
            <td>845 円</td>
            <td>603 円</td>
            <td>448 円</td>
            <td>334 円</td>
            <td>249 円</td>
            <td>183 円</td>
          </tr>
          <tr align="center">
            <td>税込総額</td>
            <td>(108,600 円)</td>
            <td>(169,000 円)</td>
            <td>(180,900 円)</td>
            <td>(224,000 円)</td>
            <td>(334,000 円)</td>
            <td>(747,000 円)</td>
            <td>(915,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('プレミアムでは、試作品、裏面印刷、トレース代金は無料です。') ?><br />
      </div>
      <hr />
      <h2>スタンダードとプレミアムの違い</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/product-difference.php?data=2" target="_blank"><img src="/img/top4-banner.webp" width="745" height="350"></a></div>
      <h2>製作納期</h2>
      <div style="clear: both;"></div>
      <!-- <div id="info_div"></div>    -->
      <?php include('../../delivery_note.php'); ?><br>
      <p class="d_TEXT1 new-text">
        納期：<br />
        <span class="red">下記日数は全て営業日。</span><br />
        納期=製作日数+配送日数で定義されるものとします。<br />
        営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。中国春節、国慶節期間につきましては、別途定める休日が指定されます。<br />シルク印刷ありでのご注文の場合、+1営業日<br />色味指定を印刷紙で行う場合、+3営業日<br />※お客様から印刷紙手配が遅れる場合、この限りではございません。
      </p>
      ◆スタンダード製作期間（単位：営業日。配送日数は含まず）
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr align="center">
          <td style="width: 30%">&nbsp;</td>
          <td align="center">300個以下</td>
          <td align="center">1,000個以下</td>
          <td align="center">3,000個程度まで</td>
        </tr>
        <tr>
          <td>試作品製作日数</td>
          <td align="center">6</td>
          <td align="center">6</td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td>量産品製作日数(試作あり)</td>
          <td align="center">16</td>
          <td align="center">21</td>
          <td align="center">29～</td>
        </tr>
        <tr>
          <td>量産のみの製作日数（試作なし）</td>
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
      ◆プレミアム製作期間（単位：営業日。配送日数は含まず）
      <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
        <tr>
          <td style="width: 30%;">&nbsp;</td>
          <td align="center">300個以下</td>
          <td align="center">1,000個以下</td>
          <td align="center">3,000個程度まで</td>
        </tr>
        <tr>
          <td>試作品製作日数</td>
          <td align="center">6</td>
          <td align="center">6</td>
          <td align="center">6</td>
        </tr>
        <tr>
          <td>量産品製作日数(試作あり)</td>
          <td align="center">23</td>
          <td align="center">28</td>
          <td align="center">36～</td>
        </tr>
        <tr>
          <td>量産のみの製作日数（試作なし）</td>
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
      <p class="d_TEXT1 new-text">◆配送日数：1-2営業日</p>
      <p class="d_TEXT1 new-text">
        ◇例）<br />
        スタンダード<br />
        300個<br />
        試作品なしの場合
      </p>
      <p class="d_TEXT1 new-text">
        ・製作期間：10営業日<br />
        ・配送期間：1-2営業日<br />
        合計：11-12営業日となります。
      </p>
      <div style="clear: both;"></div>
      <div style="margin-top: 10px;">
        <a href="/campaign/quality_rubberstrap.php"><img data-src="/products/images/banner-quality-2025.webp" class="lazy" width="100%" height="" style="max-width: 770px;"></a>
      </div>
      <?php include("../campaign_news.php"); ?>
      <h2>厚労省の定める規格基準に合格した安全性の高い材料を使用</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/foodproducts.php?data=keycover" target="_blank"><img class="lazy" data-src="/img/safety-banner.webp" width="745" height="70"></a></div>
      <div style="clear:both;">&nbsp;</div>
      <div id="est-content">

      <?php include('../campaign_banner.php') ?>

        <div style="clear:both;"></div>
        <h2>ご注文・見積書作成</h2>
      </div>
      <?php include('../../delivery_note.html'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【ラバーキーカバー】</h3>
          <span class="total-price"><span class="prd_total">0</span>円（税込）</span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td>ご注文タイプ</td>
                <td><span id="sample-prd-pcs">-</span></td>
              </tr>
              <tr>
                <td>サイズ</td>
                <td><span>70X70mm以内。</span></td>
              </tr>
              <tr>
                <td>裏面印刷</td>
                <td><span id="sample-prd-screen">-</span></td>
              </tr>
              <tr>
                <td>汚れ防止加工</td>
                <td><span id="sample-prd-coating">-</span></td>
              </tr>
              <tr>
                <td>数量</td>
                <td><span id="sample-prd-qty">-</span></td>
              </tr>
              <tr>
                <td>試作品</td>
                <td><span id="sample-prd-samp">-</span></td>
              </tr>
              <tr>
                <td>データトレース</td>
                <td><span id="sample-prd-trace">-</span></td>
              </tr>
            </table>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="/products/images/HM_part1-2.webp" width="135" height="135" id="sample-part-pic" class="picpro"><br />
            <span id="sample-part-name">通常松葉（カニカン）</span>
          </div>
          <div class="step-box line2" style="text-align: center;">
            <img src="/products/acrylic/img/coming-soon.webp" width="500" height="500" id="sample-paper-pic" class="picpro"><br />
            台紙:<span id="sample-paper-name">なし</span>
          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details">ご注文タイプ・裏面印刷</span>
              </li>
              <li id="dot-step2">
                <div class="step-number">2</div><span class="step-details">アタッチメント・台紙等</span>
              </li>
              <li id="dot-step3">
                <div class="step-number">3</div><span class="step-details">製品仕様・製作料金</span>
              </li>
            </ul>
          </div>
        </div>
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
          <div style="display: table-column;">
            <input type="text" name="ItemType" id="strap" value="ラバーキーカバー" />
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
            
            <h3>ご注文タイプ</h3>
            <?php include('../alert-btn.php') ?>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemPCS" id="pcs1" value="スタンダード" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_1pcs ?>>スタンダード <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name" <?=$delivery_disabled?>><input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）" onclick="click_typeorder_enabled();clearValue();" <?= $lsSelected_4pcs ?>><?= lang('スタンダード（スピード7営業日発送）') ?> <span class="checkmark"></span></label>
              </div>
              <div class="part-content">
                <label class="part-name"><input type="radio" name="ItemPCS" id="pcs2" value="プレミアム" onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?>>プレミアム <span class="checkmark"></span></label>
              </div>
              <span style="color: red" id="error_pcs"></span>
            </div>

            <h3><?= lang('特殊素材（蓄光／蛍光／ラメ／金色銀色）') ?></h3>
            <div class="part-container">
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材なし" <?php echo $material0_checked ?> onclick="clearValue();" /><?= lang('特殊素材なし') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="ItemMaterial" value="特殊素材あり" <?php echo $material1_checked ?> onclick="clearValue();" /><?= lang('特殊素材あり') ?> <span class="checkmark"></span></label></div>
            </div>

            <h3>裏面印刷</h3>
            <div class="part-container">
              裏面もラバーでのデザインをご希望の方は「印刷なし」をお選びください。
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="nashiprint" value="印刷なし" <?php echo $printing1_checked ?> onclick="clearValue();" /><?= lang('印刷なし') ?> <span class="checkmark"></span></label></div>
              裏面を平面にし、単色またはカラー印刷されたい場合は以下いづれかをお選びください。
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="ariprint" value="単色（シルク）印刷" <?php echo $printing2_checked ?> onclick="clearValue();" /><?= lang('単色（シルク）印刷') ?> <span class="checkmark"></span></label></div>
              <div class="part-content"><label class="part-name"><input type="radio" name="silk_print" id="fcprint" value="フルカラー印刷" <?php echo $printing3_checked ?> onclick="clearValue();" /><?= lang('フルカラー印刷') ?> <span class="checkmark"></span></label></div>
              <span style="color: red" id="error_print"></span>
              <span style="color: red">※プレミアムは裏面印刷が無料</span>
            </div>


            <h3 class="inline">汚れ防止加工</h3><a class="btn-details inline" href="javascript:void(0)" for="modal-2" style="cursor: pointer;" onclick="$('#modal-2').prop('checked',true)">詳細</a>
            <input class="modal-state" id="modal-2" type="checkbox">
            <div class="modal">
              <label class="modal__bg" for="modal-2"></label>
              <div class="modal__inner modal1" style="height: fit-content;">
                <label class="modal__close" for="modal-2"></label>
                <img src="/products/images/banner-coating.webp" width="100%" height="327"><br>
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

            <h3>ご注文本数</h3>
            <div class="part-container">
              <div class="part-content">
                <label class="part-name" id="label-qty">ご注文・御見積数量&nbsp;&nbsp;<input type="number" name="numberOf" id="no_of_order" class="right" onchange="this.value=format_number(this.value);" value="<?php echo $numberOf ?>" style="text-align: right;"><br /></label>
                <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?></div>
              </div>
            </div>
            <span style="color: red" id="error_message"></span>
          </div>
          <div class="estimate-content" id="step2">
            <h3>アタッチメント</h3>
            <div class="flex-container">
              <div class="preview-container">
                <div class="preview-sub flex-container">
                  <?php
                  include('part.php');
                  $i = 0;
                  for ($i = 0; $i < count($attachment); $i++) {
                    echo '
                      <div class="flex-item">
                      <label class="part-name">
                      <input type="radio" name="part" value="' . $attachment[$i]["part_name"] . '" onclick="getPartData(\'' . $attachment[$i]["part_name"] . '\')" ' . ($part == $attachment[$i]["part_name"] ? 'checked' : ($i == 0 ? 'checked' : '')) . '>
                      <img src="' . $attachment[$i]["part_pic"] . '" width="95" height="95" class="picpro">
                      <br><span class="part_price_std">+' . ($attachment[$i]["part_price"] * 1.1) . '円</span><span class="part_price_prm">+0円</span>
                      </label>
                      </div>';
                  }
                  ?>
                </div>
              </div>
            </div>
            <h3>台紙</h3>
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
                  台紙印刷
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
            <h3>試作品・データトレース</h3>
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
                  試作品
                </label>
              </div>
              <font color="red">※プレミアムは実物校正代金が無料</font>
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
                  データトレース
                </label>
              </div>
              <font color="red">※プレミアムはトレース代金が無料</font>
            </div>
          </div>
          <div class="estimate-content flex-item" id="step3">
            <div class="flex-container">
              <div class="flex-item">
                <h3>製品仕様</h3>
                <table class="table_rubber">
                  <tbody>
                    <tr>
                      <td class="TableLeft">ご注文タイプ</td>
                      <td class="" id="prd_ItemPCS" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">サイズ</td>
                      <td class="" style="text-align: left;">70X70mm以内。</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">裏面印刷</td>
                      <td class="" id="prd_silk_print" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class="" id="prd_coating" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">ご注文本数</td>
                      <td class="" id="prd_qty" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">アタッチメント</td>
                      <td class="" id="prd_part" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">台紙</td>
                      <td class="" id="prd_paper" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class="" id="prd_SendPrototype" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データトレース</td>
                      <td class="" id="prd_DeFormat" style="text-align: left;">なし</td>
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
                <h3>製作料金</h3>
                <table class="table_rubber total_price_tbl">
                  <tbody>
                    <tr>
                      <td class="TableLeft">商品代金</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="StrapPrice" readonly="readonly" id="textfield7" class="right" value="<?= $StrapPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">裏面印刷代金</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="SilkPrint" readonly="readonly" id="textfield13" class="right" value="<?php echo $SilkPrint ?>" />円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="coatingPrice" readonly="readonly" id="textfield13_2" class="right" value="<?= $coatingPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">アタッチメント</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">台紙</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PaperPrice" readonly="readonly" id="textfield7_2" class="right" value="<?= $PaperPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">試作品</td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="ProShipping" readonly="readonly" id="textfield3" class="right" value="<?= $ProShipping ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft">データトレース</td>
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
                      <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="clearValue();$('#cus_detail').hide();valid_chk_btn('step1');" />
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step1');$('#cus_detail').hide();">製作条件修正</a>
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step2');$('#cus_detail').hide();">ｱﾀｯﾁﾒﾝﾄ修正</a>
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
            <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn('back')">戻る</a>
            <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')">アタッチメント・オプション入力へ</a>
          </div>
        </form>
        <div id="cus_detail" style="display: none;" align="center">
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');$('.loading').show();" value="御社情報確定（PDF出力）" />
                  <div class="remark">&nbsp;※社名や会社名の入力は任意です</div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <?php $fd_type = "keycover";
      $favor = "keycover";
      include '../rubber_product_detail_test.php'; ?>
      <h2>営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。</h2>
      <center><a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a></center>
      <br />
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include("../../footer.html"); ?>
  <!--フッター ここまで-->

  <!-- /lightbox2-master -->
  <script src="js/lightbox.js"></script>
  <script>
    lightbox.option({
      'maxWidth': 600,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <!-- /lightbox2-master -->
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.16"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <!-- google script -->
  <!-- リマーケティング タグの Google コード -->
  <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->
  <!-- Swiper JS -->
  <script src="/js/swiper.min.js"></script>

  <script type="text/javascript" src="/js/_setToInput_2026.js?v=<?php echo date('is') ?>"></script>
  <script language="JavaScript" src="/js/validation_new.js?v=1.10" type="text/javascript"></script>
  <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="/products/acrylic/ptw/photoswipe.min.js?v=1.08"></script>
  <script src="/products/acrylic/ptw/photoswipe-ui-default.min.js"></script>
  <script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1036353231;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    $('#info_div').load('/info/index.php');
    /* ]]> */
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "ラバーキーカバー"
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
    }, getPartData($('input[name="part"]:checked').val()), (tmp != "" ? valid_chk_btn('step3') : ""));

    if (window.innerWidth < 768) {
      var swiper = new Swiper('.swiper-container', {
        slidesPerView: 2,
        spaceBetween: 15,
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
            "padding-bottom": 70
          })
          .animate({
            "height": totalHeight
          });

        $p.fadeOut();

        return false;
      });
    });
    $("input[name='paper_select']").on('click load', function() {
      if ($(this).is(':checked')) {
        $('#paper-preview').load('/products/paper_preview.php');
      }
    })
  </script>
  <script type="text/javascript" src="/js/common.js?v=1.02"></script>
  <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
  </script>
  <noscript>
    <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
    </div>
  </noscript>
  <!-- /.google script -->

</body>

</html>