<?php

include_once('../common/SetUpLang.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="オリジナル,キーホルダー,製作,ラバー,アクリル,作成,オリジナルキーホルダー,印刷,1個から">
  <meta name="description" content="オリジナルキーホルダーを小ロット1個から、低価格、短納期で製作。ラバー、アクリル、リフレクターなど素材も豊富。">
  <meta name="robots" content="index,follow">
  <title>オリジナルキーホルダーを1個から製作。アクリル、ラバー、リフレクターなど。HOTMOBILYオリジナルグッズ</title>
  <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/products/css/lightbox.css">
  <style type="text/css">
    .d-flex {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
    }

    .justify-content-between {
      justify-content: space-between;
    }

    .frame-item {
      width: 30%;
      padding: 10px;
      border: 1px solid #e5e5e5;
      margin-bottom: 10px;
      position: relative;
    }

    .frame-item a {
      color: black !important;
      text-decoration: none !important;
    }

    .frame-item h3 {
      margin-bottom: 10px;
    }

    .frame-item img {
      width: 100%;
      margin-bottom: 10px;
    }

    img.item {
      width: 30%;
      max-width: 90px !important;
      max-height: 72px !important;
    }

    .btn {
      width: 100%;
      margin: 10px auto;
      display: block;
      color: white;
      background: #ff9900;
      border: unset;
      padding: 5px;
      cursor: pointer;
      border-radius: 5px;
    }

    .frame-item .red {
      font-size: 20px;
    }

    @media (min-width:961px) {
      .frame-item:hover a>.hover-content {
        display: block;
        position: absolute;
        width: calc(100% - 18px);
        background: #e5e5e5;
        left: -1px;
        padding: 10px;
        z-index: 1;
      }

      .frame-item:not(.ranking-container):hover {
        background: #e5e5e5;
      }
    }

    .hover-content {
      display: none;
    }

    .text-info {
      font-size: 17px;
      color: #6d9eeb;
    }

    .mb {
      display: none;
    }

    .w-50 {
      width: 47%;
    }

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }

    .h3-new {
        width: 100% !important;
        font-size: 17px !important;
        letter-spacing: 0.05em !important;
        padding: 13px 10px;
        background-image: repeating-linear-gradient(90deg, rgba(255, 165, 0, 1) 0, rgba(255, 165, 0, 1) 2px, rgba(0, 0, 0, 0) 2px, rgba(0, 0, 0, 0) 4px);
        background-size: 4px 4px;
        background-repeat: repeat-x;
        background-position: center bottom;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .fs-bold {
        font-family: 'IwaUDGoDspPro-Bd' !important;
    }

    @media screen and (max-width: 768px) {
      .frame-item {
        width: 100% !important;
      }

      .d-flex.ranking-lists>div {
        width: 100% !important;
      }

      .d-flex.ranking-lists>div>div>div {
        justify-items: center;
      }

      .w-30 {
        flex-basis: 100% !important;
        margin: 0 !important;
      }

      .modal-content .d-flex a {
        flex-basis: 100% !important;
        margin-bottom: 10px;
      }

      .mb {
        display: block;
      }

      .d-flex.justify-content-between.text-center {
        overflow: hidden;
        height: 730px;
        position: relative;
      }

      .no-overflow {
        height: 100% !important;
      }

      .btn-see-more {
        width: 260px;
        left: calc(50% - 135px);
        height: 35px;
        background: white;
        color: #0093ff;
        border: 3px solid #0093ff;
        display: grid;
        align-content: center;
        border-radius: 0;
        position: absolute;
        top: 45%;
      }

      .disabled-content {
        display: block;
        width: 100%;
        position: absolute;
        top: 80%;
        height: -webkit-fill-available;
        background: linear-gradient(360deg, rgb(255 255 255 / 100%) 70%, rgba(255, 255, 255, 0) 80%);
      }

      .modal-content {
        width: 85% !important;
      }

      .modal-content .d-flex {
        width: 100% !important;
      }

      .d-footer {
        border-top: 1px solid #dddddd;
        margin-bottom: 15px;
      }
    }

    .d-flex.ranking-lists {
      position: relative;
      padding: 15px 0px;
      align-items: center;
    }

    .d-flex.ranking-lists>div {
      width: 35%;
      align-content: center;
    }

    .ranking-lists p {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .d-flex.ranking-lists>div>div>div {
      width: 50%;
      display: grid;
      align-content: center;
    }

    .ranking img:not(.number-ranking) {
      width: 70%;
      margin: 15px 55px;
    }

    .d-flex.ranking-lists a {
      margin: 0;
      width: 80%;
      color: white;
      text-align: center;
      text-decoration: none;
    }

    .border-bottom {
      border-bottom: 2px solid #ff9900;
    }

    .d-flex.ranking-lists>div:not(.ranking) {
      width: 65%;
    }

    .text-big {
      font-size: 20px;
    }

    .number-ranking {
      max-width: 90px !important;
      left: calc(50% - 45px);
      top: 0px;
    }

    .text-center {
      text-align: center;
    }

    .frame-item.ranking-container {
      padding-top: 50px;
    }

    .d-flex.justify-content-between.text-center::after {
      content: "";
      flex: 0 0 33%;
    }

    #content_wrapper h1 {
      margin-top: 0 !important;
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

    .w-30 {
      flex-basis: 32%;
      margin: 1%;
      margin-left: 0;
    }

    .w-30>.d-body img {
      width: 100%;
    }

    .d-body {
      padding: 5px;
      border: 1px solid #dddddd;
      border-bottom: unset;
    }

    .d-footer {
      padding: 5px;
      border: 1px solid #dddddd;
      text-align: center;
    }

    .tag-list a {
      display: inline-block;
      margin-right: 10px;
      padding: 5px 15px;
      background: #fe9800;
      border-radius: 5px;
      color: white !important;
      text-decoration: none !important;
      margin-bottom: 5px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
      overflow: hidden;
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 60%;
      text-align: center;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-content img {
      max-width: 100%;
    }

    .modal-content .d-flex {
      width: 60%;
      margin: auto;
      margin-top: 10px;
      display: flex;
    }

    .modal-content .d-flex a {
      flex-basis: 50%;
    }

    .d-flex.justify-content-between.text-center {
      transition: height 0.3s ease-in-out;
    }

    .w-30 {
      position: relative;
    }

    img.pointer-img {
      position: absolute;
      width: 33px !important;
      height: 33px;
      bottom: 40px;
      right: 10px;
      padding: 5px;
      background-color: white;
      border-radius: 50%;
    }

    .w-30:hover .pointer-img {
      opacity: 0.7;
    }

    .align-end {
      align-items: flex-end;
    }

    h3.text-center {
      font-family: IwaUDGoDspPro-Eb, sans-serif !important;
    }

    .font-small {
      font-size: smaller;
    }

    img.p-absolute {
      width: 109px;
      height: auto;
      position: absolute;
      right: 5px;
      top: 0;
    }
    .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
}
  </style>
  <?php include('../head_products.html'); ?>
</head>

<body id="top">
  <!-- :: header start :: -->
  <?php include('../header.html'); ?>
  <!-- :: header end :: -->

  <!-- globalNavi -->
  <?php include('../gnavi.php'); ?>
  <!-- globalNavi End -->

  <!-- :: wrapper start :: -->
  <div id="wrapper">

    <!-- sidemenu-->

    <?php include('../sidenavi.php'); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
    <?php include('banner-campaign.php') ?>
      <h1>オリジナルキーホルダーが小ロット1個から製作 作成できます。短納期6営業日～出荷。(2026年版)</h1>
      <div class="social-time" style="text-align: right;">
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <img src="img/Original Hotstrap banner.webp?v=1.05">
      <p class="new-text">各種オリジナルキーホルダーの制作を承っております。「自社のロゴでキーホルダーを作りたい」「ペットの写真でキーホルダーを作りたい」などお考えの方は、ぜひ当店のオリジナルキーホルダー製作サービスをご利用ください。</p>
      <ul class="new-text">
        <li><a href="https://hotmobily.jp/products/rubberkeyholder/">ラバーキーホルダー</a></li>
        <li><a href="https://hotmobily.jp/products/acrylic/">アクリルキーホルダー</a></li>
        <li><a href="https://hotmobily.jp/products/reflecter_print">リフレクターキーホルダー（印刷）</a></li>
        <li><a href="https://hotmobily.jp/products/reflecter_press">リフレクターキーホルダー（圧着）</a></li>
        <li><a href="https://hotmobily.jp/products/reflecter_hard">リフレクターキーホルダー（硬貨）</a></li>
        <li><a href="https://hotmobily.jp/products/floatkeyholder">フローティングキーホルダー</a></li>
        <li><a href="https://hotmobily.jp/products/led_original">LEDライトキーホルダー</a></li>
        <li><a href="https://hotmobily.jp/products/flight_tag_keyholder">刺繍キーホルダー</a></li>
      </ul>
      <div>&nbsp;</div>
      <p class="new-text">上記のキーホルダーはすべて「ダイカット」と呼ばれる技術により自由な形状で製作できる製品です。シンプルな丸型や長方形だけでなく、文字をかたどった形やキャラクターの形など、複雑な形状にも対応できます。</p>
      <div>&nbsp;</div>
      <div class="ex-row">
        <div class="gall_pro">
          <div class="gallbox">
            <div class="prodate">キャラクターのラバー</div>
            <a href="img/ranking/daeda231-560a-45a9-a3db-5869d0eadcc7-600.webp" data-lightbox="ranking-1" data-title="" style="text-decoration:none;">
              <img src="img/ranking/daeda231-560a-45a9-a3db-5869d0eadcc7-600.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
          </div>

          <div class="gallbox">
            <div class="prodate">文字のラバー</div>
            <a href="img/ranking/0a1f8ce3-441b-4b6f-93dd-73247c459d3a.webp" data-lightbox="ranking-2" data-title="" style="text-decoration:none;">
              <img src="img/ranking/0a1f8ce3-441b-4b6f-93dd-73247c459d3a.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
          </div>

          <div class="gallbox">
            <div class="prodate">ロゴと文字のアクリル</div>
            <a href="img/ranking/20240628173439399_0.webp" data-lightbox="ranking-3" data-title="" style="text-decoration:none;">
              <img src="img/ranking/20240628173439399_0.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
          </div>

          <div class="gallbox">
            <div class="prodate">キャラクターのアクリル</div>
            <a href="img/ranking/94.webp" data-lightbox="ranking-4" data-title="" style="text-decoration:none;">
              <img src="img/ranking/94.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
          </div>

          <div class="gallbox">
            <div class="prodate">圧着リフレクター</div>
            <a href="img/ranking/ref-keyholder01.webp" data-lightbox="ranking-5" data-title="" style="text-decoration:none;">
              <img src="img/ranking/ref-keyholder01.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
          </div>

          <div class="gallbox">
            <div class="prodate">印刷リフレクター</div>
            <a href="img/ranking/ref_keyholder02.webp" data-lightbox="ranking-6" data-title="" style="text-decoration:none;">
              <img src="img/ranking/ref_keyholder02.webp" class="picpro" width="229" height="229"><br />
              <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
            </a>
          </div>
        </div>
      </div>
      <div style="clear:both;"></div>
      <p class="new-text">当店のオリジナルキーホルダーは、個人様のご注文はもちろん、学校行事、自動車・バイクショップ様での店頭販売グッズ、自治体での大規模イベントまで、お約束のご納期に間に合わせるよう、担当営業が全力でご支援いたします。安心してご注文ください。</p>
      <div>&nbsp;</div>
      <p class="new-text">「どうしたらよいかわからない」「とりあえず相談に乗ってほしい」などありましたら、お気軽にお電話もしくはお問い合わせフォームからご連絡ください。</p>
      <div>&nbsp;</div>
      <p class="new-text">経験豊富な営業担当が、ご納品まで伴走いたします。</p>
      <div>&nbsp;</div>
      <p class="new-text">実際に製品を製作され、ご納品させて頂いたお客様からの貴重なご意見も、ご購入の判断材料になるかと思います。是非、事前にご確認ください。</p>
      <div>&nbsp;</div>
      <ul class="new-text">
        <li><a href="/reviews/">当店サイト内に記載頂いたレビュー</a></li>
        <li><a href="https://g.page/r/Cc1pKhMQ1ds2EAI/review">Googleレビュー</a></li>
      </ul>
      <div>&nbsp;</div>

      <div class="d-flex justify-content-between">
        <!-- 1 -->
        <div class="frame-item w-50 p-relative">
          <a href="/products/rubberkeyholder/">
            <img src="img/ranking/ranking_icon/icon_recomment_01.webp" class="p-absolute">
            <img src="img/ranking/04.webp?v=1.01">
            <h3 class="text-center">ラバーキーホルダー</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@480円～</p>
              <p class="w-50 font-small new-text">(100個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow3.png">
              <img class="item" src="img/ranking/ranking_icon/Red1.png">
              <img class="item" src="img/ranking/ranking_icon/blue.png">
            </div>
            <div class="">
              凹凸のある仕上がりで立体感も楽しめます。裏面印刷もOK、アニメグッズにも最適です。
            </div>
          </a>
        </div>
        <!-- 2 -->
        <div class="frame-item w-50 p-relative">
          <a href="/products/acrylic/">
            <img src="img/ranking/ranking_icon/icon_recomment_02.webp" class="p-absolute">
            <img src="img/ranking/06.webp">
            <h3 class="text-center">アクリルキーホルダー</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@207円～</p>
              <p class="w-50 font-small new-text">(100個ご注文の場合）</p>
            </div>

            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow1.png">
              <img class="item" src="img/ranking/ranking_icon/Red2.png">
              <img class="item" src="img/ranking/ranking_icon/Purple.png">
            </div>
            <div class="">
              1個から製作ができ、単価が一番安いです。全面PETフィルムで保護するため印刷が剥がれません。
            </div>
          </a>
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <!-- 3 -->
        <div class="frame-item">
          <a href="/products/reflecter_print">
            <img src="/img/printed_reflecter03132026.webp">
            <h3 class="text-center">リフレクターキーホルダー（印刷）</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@541円～</p>
              <p class="w-50 font-small new-text">(100個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow3.png">
              <img class="item" src="img/ranking/ranking_icon/Red1.png">
              <img class="item" src="img/ranking/ranking_icon/green.png">
            </div>
            <div class="">
              交通安全グッズに最適。フルカラー印刷なので、細かいデザインも再現できます。
            </div>
          </a>
        </div>
        <!-- 4 -->
        <div class="frame-item">
          <a href="/products/reflecter_press">
            <img src="img/ranking/02.webp">
            <h3 class="text-center">リフレクターキーホルダー（圧着）</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@541円～</p>
              <p class="w-50 font-small new-text">(100個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow3.png">
              <img class="item" src="img/ranking/ranking_icon/Red1.png">
              <img class="item" src="img/ranking/ranking_icon/green.png">
            </div>
            <div class="">
              リフレクターの中で最も定番。交通安全グッズとして、動物園や水族館のお土産品として。
            </div>
          </a>
        </div>
        <!-- 5 -->
        <div class="frame-item">
          <a href="/products/reflecter_hard">
            <img src="img/ranking/03.webp?v=1.01">
            <h3 class="text-center">リフレクターキーホルダー（硬質）</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@521円～</p>
              <p class="w-50 font-small new-text">(300個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow4.png">
              <img class="item" src="img/ranking/ranking_icon/Red1.png">
              <img class="item" src="img/ranking/ranking_icon/green.png">
            </div>
            <div class="">
              珍しいタイプの硬質リフレクター。反射させたい部分を指定することができます。
            </div>
          </a>
        </div>
        <!-- 6 -->
        <div class="frame-item">
          <a href="/products/pvc_hariawase">
            <img src="img/ranking/01.webp">
            <h3 class="text-center">3D立体（PVC）</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@792円～</p>
              <p class="w-50 font-small new-text">(100個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow3.png">
              <img class="item" src="img/ranking/ranking_icon/Red3.png">
              <img class="item" src="img/ranking/ranking_icon/blue.png">
            </div>
            <div class="">
              ラバーを貼り合わせて製作します。3D立体チャームの中で、最も簡易なデータで作れるタイプです。
            </div>
          </a>
        </div>
        <!-- 7 -->
        <div class="frame-item">
          <a href="/products/polyresign">
            <img src="img/ranking/10.webp">
            <h3 class="text-center">3D立体（ポリレジン）</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@484円～</p>
              <p class="w-50 font-small new-text">(500個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow5.png">
              <img class="item" src="img/ranking/ranking_icon/Red4.png">
              <img class="item" src="img/ranking/ranking_icon/Purple.png">
            </div>
            <div class="">
              500個～と小ロットで製作できる3D立体チャーム。船やトラック等のミニチュアも、お手軽に製作できます。
            </div>
          </a>
        </div>
        <!-- 8 -->
        <div class="frame-item">
          <a href="/products/injection">
            <img src="img/ranking/09.webp">
            <h3 class="text-center">3D立体（インジェクション）</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">ご相談</p>
              <p class="w-50 font-small new-text">（お問合せください）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow6.png">
              <img class="item" src="img/ranking/ranking_icon/Red6.png">
              <img class="item" src="img/ranking/ranking_icon/Purple.png">
            </div>
            <div class="">
              本格派の3D立体チャーム。市販品のおもちゃなどと同一の製造方法です。
            </div>
          </a>
        </div>
        <!-- 10 -->
        <div class="frame-item">
          <a href="/products/floatkeyholder">
            <img src="img/ranking/05.webp">
            <h3 class="text-center">フローティングキーホルダー</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@694円～</p>
              <p class="w-50 font-small new-text">(100個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow3.png">
              <img class="item" src="img/ranking/ranking_icon/Red6.png">
              <img class="item" src="img/ranking/ranking_icon/green.png">
            </div>
            <div class="">
              鍵につけておくと、水の中に落とした際、浮かんで知らせてくれます。プール施設のロッカーキーに。夏季の販促品に。
            </div>
          </a>
        </div>
        <!-- 11 -->
        <div class="frame-item">
          <a href="/products/led_original">
            <img src="img/ranking/08.webp">
            <h3 class="text-center">LEDライトキーホルダー</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@253円～</p>
              <p class="w-50 font-small new-text">（500個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/ranking_icon/Yellow5.png">
              <img class="item" src="img/ranking/ranking_icon/Red3.png">
              <img class="item" src="img/ranking/ranking_icon/green.png">
            </div>
            <div class="">
              ボタン電池が内蔵されており、指で押すと発光します。電池の連続使用時間は2時間程度。夜の鍵穴を照らす時に便利。
            </div>
          </a>
        </div>

        <!-- 12 -->
        <div class="frame-item">
          <a href="/products/flight_tag_keyholder">
            <img src="img/ranking/20.webp?v=1.01">
            <h3 class="text-center">刺繍キーホルダー</h3>
            <div class="d-flex align-end">
              <p class="red w-50 new-text">@382円～</p>
              <p class="w-50 font-small new-text">（100個ご注文の場合）</p>
            </div>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <img class="item" src="img/ranking/50個から注文OK.webp">
              <img class="item" src="img/graduation/15days.webp">
              <img class="item" src="img/ranking/ranking_icon/green.png">
            </div>
            <div class="">
              刺繍またはジャガード織で、オリジナルデザインを再現。温かみのある仕上がりが特徴です。裏面は表面と同じようにデザインすることも、クレジットなどを印字することも可能です。
            </div>
          </a>
        </div>
      </div>

      <div>&nbsp;</div>
      <h2 class="text-info">納期ランキング</h2>
      <p class="new-text">製作期間の短い順に製品をご紹介</p>
      <div class="d-flex no-overflow justify-content-between text-center">
        <div class="frame-item w-50">
          <a href="/products/acrylic/">
            <img class="number-ranking" src="img/ranking/1位.webp?v=1.01">
            <img src="/gallery/img-acrylic/2023-acrylic-gallery/10.webp?v=0.01">
            <h3>アクリルキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/6営業日出荷.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>

        <div class="frame-item w-50">
          <a href="/products/rubberkeyholder/">
            <img class="number-ranking" src="img/ranking/2位.webp?v=1.01">
            <img src="/gallery/img-keyholder/2023-rubberkeyholder-gallery/16.webp">
            <h3>ラバーキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/10営業日出荷.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="d-flex justify-content-between text-center">

        <div class="frame-item">
          <a href="/products/reflecter_print">
            <img class="number-ranking" src="img/ranking/2位.webp?v=1.01">
            <img src="img/ranking/11.webp">
            <h3>リフレクター（印刷・圧着・硬質）</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/10営業日出荷.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>

        <div class="frame-item">
          <a href="/products/flight_tag_keyholder">
            <img class="number-ranking" src="img/ranking/4位.webp?v=1.01">
            <img src="img/ranking/21.webp?v=1.01">
            <h3>刺繍キーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/graduation/15days.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>

        <div class="frame-item">
          <a href="/products/floatkeyholder">
            <img class="number-ranking" src="img/ranking/5位.webp?v=1.01">
            <img src="img/ranking/12.webp">
            <h3>フローティングキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/20営業日出荷.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>
        <p class="mb disabled-content">
          <a class="btn mb btn-see-more">もっと見る</a>
        </p>
      </div>

      <h2 class="text-info">単価ランキング</h2>
      <p class="new-text">単価の低い順に製品をご紹介（100個注文が可能な製品のみ表示しています）</p>
      <div>&nbsp;</div>
      <div class="d-flex no-overflow justify-content-between text-center">
        <div class="frame-item w-50">
          <a href="/products/acrylic/">
            <img class="number-ranking" src="img/ranking/1位.webp?v=1.01">
            <img src="img/ranking/13.webp">
            <h3>アクリルキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <p class="red new-text">207円～</p>
            <p class="new-text">（100個ご注文の場合）</p>
          </a>
        </div>

        <div class="frame-item w-50">
          <a href="/products/rubberkeyholder/">
            <img class="number-ranking" src="img/ranking/2位.webp?v=1.01">
            <img src="img/ranking/14.webp?v=1.01">
            <h3>ラバーキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <p class="red new-text">480円～</p>
            <p class="new-text">（100個ご注文の場合）</p>
          </a>
        </div>
      </div>

      <div class="d-flex justify-content-between text-center">
        <div class="frame-item">
          <a href="/products/flight_tag_keyholder">
            <img class="number-ranking" src="img/ranking/3位.webp?v=1.01">
            <img src="img/ranking/22.webp?v=1.01">
            <h3>刺繍キーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <p class="red new-text">382円～</p>
            <p class="new-text">（100個ご注文の場合）</p>
          </a>
        </div>

        <div class="frame-item">
          <a href="/products/reflecter_print">
            <img class="number-ranking" src="img/ranking/4位.webp?v=1.01">
            <img src="img/ranking/15.webp">
            <h3>リフレクター（印刷・圧着）</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <p class="red new-text">541円～</p>
            <p class="new-text">（100個ご注文の場合）</p>
          </a>
        </div>

        <div class="frame-item">
          <a href="/products/floatkeyholder">
            <img class="number-ranking" src="img/ranking/5位.webp?v=1.01">
            <img src="img/ranking/16.webp">
            <h3>フローティングキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <p class="red new-text">694円～</p>
            <p class="new-text">（100個ご注文の場合）</p>
          </a>
        </div>

        <p class="mb disabled-content new-text">
          <a class="btn mb btn-see-more">もっと見る</a>
        </p>
      </div>

      <div>&nbsp;</div>
      <h2 class="text-info">ロット数ランキング</h2>
      <p class="new-text">最小ロットの少ない順に製品をご紹介</p>
      <div class="d-flex no-overflow justify-content-between text-center">
        <div class="frame-item w-50">
          <a href="/products/acrylic/">
            <img class="number-ranking" src="img/ranking/1位.webp?v=1.01">
            <img src="/gallery/img-acrylic/2023-acrylic-gallery/01.webp?v=0.01">
            <h3>アクリルキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/1個から注文OK.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>

        <div class="frame-item w-50">
          <a href="/products/flight_tag_keyholder">
            <img class="number-ranking" src="img/ranking/2位.webp?v=1.01">
            <img src="img/ranking/20.webp?v=1.01">
            <h3>刺繍キーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/50個から注文OK.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>
      </div>

      <div class="d-flex justify-content-between text-center">
        <div class="frame-item">
          <a href="/products/rubberkeyholder/">
            <img class="number-ranking" src="img/ranking/3位.webp?v=1.01">
            <img src="/gallery/img-keyholder/rubberkey_20221229_set9-D.webp">
            <h3>ラバーキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/100個から注文OK.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>

        <div class="frame-item">
          <a href="/products/reflecter_print">
            <img class="number-ranking" src="img/ranking/3位.webp?v=1.01">
            <img src="img/ranking/17.webp">
            <h3>リフレクター（印刷・圧着）</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/100個から注文OK.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>

        <div class="frame-item">
          <a href="/products/floatkeyholder">
            <img class="number-ranking" src="img/ranking/3位.webp?v=1.01">
            <img src="img/ranking/18.webp">
            <h3>フローティングキーホルダー</h3>
            <button type="button" class="btn">商品詳細へ</button>
            <div class=" d-flex justify-content-between">
              <div class="item"></div>
              <img class="item" src="img/ranking/100個から注文OK.webp">
              <div class="item"></div>
            </div>
          </a>
        </div>

        <div class="w-30"></div>

        <p class="mb disabled-content new-text">
          <a class="btn mb btn-see-more">もっと見る</a>
        </p>
      </div>

      <h2>オリジナルキーホルダー事例集</h2>
      <div class="tag-list">
        <a href="javascript:void(0)" data-tag="all">すべて</a>
        <a href="javascript:void(0)" data-tag="acrylic">アクリル</a>
        <a href="javascript:void(0)" data-tag="keyholder">ラバー</a>
        <a href="javascript:void(0)" data-tag="reflector">リフレクター</a>
        <a href="javascript:void(0)" data-tag="3d">3D立体</a>
        <a href="javascript:void(0)" data-tag="float">フローティング</a>
        <a href="javascript:void(0)" data-tag="led">LED</a>
      </div>
      <div class="d-flex sample-preview">
        <div class="w-30 acrylic">
          <div class="d-body">
            <a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)">
              <img src="/gallery/img-acrylic/ACY-2-13-1.webp?v=0.01">
              <img src="img/ranking/pointer-ranking.webp" class="pointer-img">
            </a>
          </div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="/gallery/img-acrylic/ACY-1-09_01.webp?v=0.01"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="/gallery/img-acrylic/acry040122-33a.jpg"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-01-01.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-01-02.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-01-03.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-01-04.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-01-05.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 acrylic">
          <div class="d-body"><a href="javascript:void(0)" data-modal="acrylic" data-capsule="img/ranking/acrylic.webp" data-link="/products/acrylic/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-01-06.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">アクリルキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="/gallery/img-keyholder/gal9_5-1-n(1).webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="/gallery/img-keyholder/key-110121-27a.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="/gallery/img-keyholder/k-018-n(1).webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-02-01.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-02-02.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-02-03.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-02-04.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-02-05.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 keyholder">
          <div class="d-body"><a href="javascript:void(0)" data-modal="keyholder" data-capsule="img/ranking/rubber.webp" data-link="/products/rubberkeyholder/" onclick="open_modal(this)"><img src="img/ranking/acrylic-new-02-06.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">ラバーキーホルダー</div>
        </div>
        <div class="w-30 reflector">
          <div class="d-body"><a href="javascript:void(0)" data-modal="reflector" data-capsule="img/ranking/reflecter_print.webp" data-link="/products/reflecter_print.php" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample1.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">リフレクターキーホルダー（印刷）</div>
        </div>
        <div class="w-30 reflector">
          <div class="d-body"><a href="javascript:void(0)" data-modal="reflector" data-capsule="img/ranking/reflecter_print.webp" data-link="/products/reflecter_print.php" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample2.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">リフレクターキーホルダー（印刷）</div>
        </div>
        <div class="w-30 reflector">
          <div class="d-body"><a href="javascript:void(0)" data-modal="reflector" data-capsule="img/ranking/reflecter_print.webp" data-link="/products/reflecter_print.php" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample3.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">リフレクターキーホルダー（印刷）</div>
        </div>
        <div class="w-30 reflector">
          <div class="d-body"><a href="javascript:void(0)" data-modal="reflector" data-capsule="img/ranking/reflecter_press.webp" data-link="/products/reflecter_press.php" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample4.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">リフレクターキーホルダー（圧着）</div>
        </div>
        <div class="w-30 reflector">
          <div class="d-body"><a href="javascript:void(0)" data-modal="reflector" data-capsule="img/ranking/reflecter_press.webp" data-link="/products/reflecter_press.php" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample5.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">リフレクターキーホルダー（圧着）</div>
        </div>
        <div class="w-30 reflector">
          <div class="d-body"><a href="javascript:void(0)" data-modal="reflector" data-capsule="img/ranking/reflecter_hard.webp" data-link="/products/reflecter_hard.html" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample6.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">リフレクターキーホルダー（硬質）</div>
        </div>
        <div class="w-30 3d">
          <div class="d-body"><a href="javascript:void(0)" data-modal="3d" data-capsule="img/ranking/pvc_hariawase.webp" data-link="/products/pvc_hariawase" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample7.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">3D立体（PVC貼り合わせ）</div>
        </div>
        <div class="w-30 3d">
          <div class="d-body"><a href="javascript:void(0)" data-modal="3d" data-capsule="img/ranking/pvc_hariawase.webp" data-link="/products/pvc_hariawase" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample8.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">3D立体（PVC貼り合わせ）</div>
        </div>
        <div class="w-30 3d">
          <div class="d-body"><a href="javascript:void(0)" data-modal="3d" data-capsule="img/ranking/polyresign.webp" data-link="/products/polyresign" onclick="open_modal(this)"><img src="/products/img/ranking/10.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">3D立体（ポリレジン）</div>
        </div>
        <div class="w-30 3d">
          <div class="d-body"><a href="javascript:void(0)" data-modal="3d" data-capsule="img/ranking/injection.webp" data-link="/products/injection" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample10.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">3D立体（インジェクション）</div>
        </div>
        <div class="w-30 float">
          <div class="d-body"><a href="javascript:void(0)" data-modal="float" data-capsule="img/ranking/floatkeyholder.webp" data-link="/products/injection" onclick="open_modal(this)"><img src="/products/img/ranking/05.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">フローティング</div>
        </div>
        <div class="w-30 led">
          <div class="d-body"><a href="javascript:void(0)" data-modal="led" data-capsule="img/ranking/LED.webp" data-link="/products/led.html" onclick="open_modal(this)"><img src="/products/img/ranking/ranking_sample12.webp"><img src="img/ranking/pointer-ranking.webp" class="pointer-img"></a></div>
          <div class="d-footer">LEDライトキーホルダー</div>
        </div>
      </div>

      <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <p>Some text in the Modal..</p>
          <div class="d-flex justify-content-between">
          </div>
        </div>

      </div>

      <h2>オリジナルキーホルダー　素材別</h2>
      <p class="new-text">
        オリジナルキーホルダーを素材別にご紹介します。作りたいキーホルダーのイメージ、質感、予算、納期などの情報を予めまとめて頂くと、どのキーホルダーが最適か決定しやすいと思います。
        <br /><br />
        ・<a href="/products/rubberkeyholder/">ラバーキーホルダー（ゴム素材）</a>：ラバストの愛称で親しまれ、キャラクター製品を中心に、ショップのグッズやゲームイベントでの配布物など多くのシーンで利用頂いております。軟質のPVC（塩ビ）ゴム製で、ソフトラバーとも呼ばれます。当店で最も売れているオリジナルキーホルダーです。
        <br /><br />
        ・<a href="/products/acrylic/">アクリルキーホルダー</a>：皆さんご存知のアクキーです。こちらも自社工場で丁寧に生産しております。最大の特徴は1個から製作できる事と、単価がお安いことです。オリジナルキーホルダーを初めて製作されるなら、アクキーから初めてはどうでしょうか。
        <br /><br />
        ・<a href="/products/reflecter">リフレクターキーホルダー（反射素材）</a>：自動車のライト等で反射する素材（リフレクター素材）を使用したキーホルダーです。交通安全グッズとして自治体様、自動車メーカー様を中心に、多数ご利用頂いております。当店では小ロット100個～製作可能です。
        <br /><br />
        ・<a href="/products/3dcharm.html">立体（3D)キーホルダー</a>：一般的なラバストが2Dの平面であるのに対し、立体のキーホルダーです。完成品の精度やご予算により複数の素材、製法がございます。単価も他製品と比較して高くなります。初めて本製品をご検討頂く場合、営業担当までご相談ください。
        <br /><br />
        ・<a href="/products/floatkeyholder">フローティングキーホルダー</a>：ビート板の素材で製作するオリジナルキーホルダーです。水に浮きます。夏の定番グッズとして根強い人気があります。良くみかける楕円形だけではなく、この製品もオリジナル形状で製作できます。
        <br /><br />
        ・<a href="/products/led_original">LEDライトキーホルダー</a>：ボタン電池が内蔵されており内蔵のLEDライトは光るユニークなオリジナルキーホルダーです。お店やイベントのロゴを印刷し、自由な形状で製作できます。
        <br /><br />
        ・<a href="/products/flight_tag_keyholder">刺繍キーホルダー</a>：ワッペンと同じ素材です。刺繍の温かみが感じられるユニークなキーホルダーです。印刷や金型を使った製品では感じられないぬくもりを感じることができるキーホルダーです。
      </p>

      <h2 class="text-info">オリジナルキーホルダーの多彩な活用シーン</h2>
      <div>
        <img src="/img/Custom_keyholders03122026.webp" class="w-100" alt="">
      </div>
        <br>
        <div>
            <p class="new-text">オリジナルキーホルダーは、実用性とデザイン性を兼ね備えたアイテムとして、ビジネスの現場から個人のプライベートな記念品まで、極めて幅広いシーンで活用されています。ここでは、ホットモバイリーで製作されるお客様が、実際にどのような目的でキーホルダーを活用されているのか、代表的なシーンをご紹介します。</p>

            <h3 class="h3-new fs-bold">【法人・企業様向け】ブランド価値を高めるプロモーションツールとして</h3>
            <p class="new-text">企業にとって、オリジナルキーホルダーは低コストでありながら、長期間にわたって顧客の手元に残り続ける非常にコストパフォーマンスの高い販促ツールです。</p>
            <br>
            <p class="new-text">たとえば、会社名やロゴをあしらったキーホルダーは、展示会やイベントでの配布物として定番です。特にアクリルキーホルダーは発色が良く、ブランドカラーを忠実に再現できるため、受け取った方に企業のプロフェッショナルな印象を強く残します。自動車ディーラーの成約記念や、不動産会社の鍵の引き渡し用など、ビジネスの節目を彩るアイテムとしても選ばれています。</p>
            <br>
            <p class="new-text">また、自社のマスコットキャラクターや、版権をお持ちのIP（知的財産）を使ったグッズ製作は、ファンとのエンゲージメントを高める重要な手段です。ラバーストラップやアクリルキーホルダーは、コレクション性が高く、カバンや小物に付けやすいため、SNSでの拡散効果も期待できます。「限定感」を演出することで、販売用グッズとしての収益化にも貢献します。</p>

            <h3 class="h3-new fs-bold">【自治体・教育機関のお客様向け】交通安全や防犯啓発の地域活動</h3>
            <p class="new-text">自治体や学校、警察署などでは、リフレクター（反射材）キーホルダーが多用されています。暗い夜道で光る特性を活かし、子供や高齢者の交通安全グッズとして、また地域一体となった防犯活動の象徴として、実益を兼ねた活用が進んでいます。</p>

            <h3 class="h3-new fs-bold">【個人のお客様向け】日常を彩る特別な「たった一つ」のアイテムとして</h3>
            <p class="new-text">個人のお客様においては、既製品にはない「自分だけのこだわり」や「大切な思い出」を形にする手段として、1個からの小ロット製作が人気です。スマートフォンの中に眠っている愛犬や愛猫、お子様の写真。それらをアクリルキーホルダーにすることで、いつでもどこへでも持ち歩ける特別な宝物に変わります。切り抜き加工を施せば、まるで写真がそのまま小さくなったような可愛らしい仕上がりになり、家族へのプレゼントとしても大変喜ばれます。</p>
            <br>
            <p class="new-text">また、自作イラストをプロ仕様のグッズに仕上げる楽しみも格別です。同人誌即売会での頒布用はもちろん、自分用や友人との「お揃いグッズ」として製作される方も増えています。当店の高品質な印刷技術なら、繊細な色使いや細かなラインも忠実に再現可能です。</p>
            <br>
            <p class="new-text">部活動やサークルの引退・卒業記念にも、オリジナルキーホルダーの製作はぴったり。部活動のユニフォームや楽器、サークルのロゴをモチーフにしたキーホルダーは、共に汗を流した仲間との絆を形にする最高の記念品になります。名前や背番号を入れることで、世界に二つとないパーソナライズされたギフトとなり、数年後も当時の思い出を鮮明に蘇らせてくれるはずです。</p>
        </div>



      <h2 class="text-info">この商品に関する記事</h2>
      <div class="d-flex justify-content-between">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/originalkeyholder-delivery"><img src="/blog-content/upload/202308311110027350.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/originalkeyholder-delivery">オリジナルキーホルダーを急ぎで作りたい！納期はどれぐらい？</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <div class="d-flex justify-content-between">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/promotional-giveaway-1"><img src="/blog-content/upload/202308241733194642.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/promotional-giveaway-1">人気の法人ノベルティは何？注意点と効果を最大化させるための工夫</a>
        </div>
      </div>
      <!--
      
      
      <div>&nbsp;</div>
      <div class="d-flex justify-content-between">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/originalgoods-aiservices"><img src="/blog-content/upload/202309071211157923.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/originalgoods-aiservices">AIを使ってオリジナルグッズが作れるって本当？AI画像生成おすすめサービス5選</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <div class="d-flex justify-content-between">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/acrylic-difference"><img src="/blog-content/upload/202309141852231917.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/acrylic-difference">今さら聞けない！アクリルキーホルダー（アクキー）とアクリルチャームの違いとは？</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <div class="d-flex justify-content-between">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/howtomake-originalgoods"><img src="/blog-content/upload/202309281647114842.png" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/howtomake-originalgoods">オリジナルグッズの作り方・流れ・手順【HOTMOBILY】</a>
        </div>
      </div>
      <div>&nbsp;</div>
      <div class="d-flex justify-content-between">
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
  <?php include('../footer.php'); ?>
  <!--フッター ここまで-->

	<script src="/products/js/lightbox.js"></script>
  <script>
    $(".tag-list a").click(function() {
      var tag = $(this).attr("data-tag");

      if (tag == "all") {
        $(".sample-preview > div.w-30").show();
      } else {
        $(".sample-preview > div.w-30").hide();
        $(".sample-preview > div.w-30." + tag).show();
      }
    });

    window.open_modal = function(element) {
      var imgSrc = $(element).find("img").attr("src");
      var tag = $(element).attr("data-modal");
      var link = $(element).attr("data-link");
      var capsule = $(element).attr("data-capsule");

      // Display the image in the modal
      $("#myModal .modal-content p").html('<img src="' + imgSrc + '" alt="Modal Image" />');
      $("#myModal .modal-content div").html('<a href="' + link + '"><img src="' + capsule + '"></a><a href="/contact/index-test?sample=' + replaceSlashWithHyphen(imgSrc) + '"><img src="img/ranking/contact.webp"></a>');

      // Open the modal
      $("#myModal").fadeIn();
    }

    // Close the modal
    $(".close").click(function() {
      $("#myModal").fadeOut();
    });

    // Close the modal when clicking outside
    $(window).click(function(event) {
      if ($(event.target).is("#myModal")) {
        $("#myModal").fadeOut();
      }
    });

    function replaceSlashWithHyphen(str) {
      return str.replace(/\//g, '::');
    }

    $('.btn-see-more').click(function() {
      $(this).closest('.disabled-content').fadeOut();
      var container = $(this).closest('.d-flex.justify-content-between.text-center');
      if (container.css('height') === '604px' || container.css('height') === '') {
        container.css('height', 'auto');
      } else {
        container.css('height', '604px');
      }
    });
  </script>
</body>

</html>