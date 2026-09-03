<?php
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
//Read Modules
require_once('../control/Control_Rubber.php');
include_once('../common/Const.php');

include_once('../common/SetUpLang.php');

include_once('const_js.php');

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
  <meta name="keywords" content="<?= lang('ラバーフォトフレーム,オリジナル,作成,製作,写真立て') ?>">
  <meta name="description" content="<?= lang('オリジナルラバーフォトフレームが作れます。野球やサッカーボールのテンプレートもあってスポーツイベント記念品のデザインも楽々作成。いつまでも飾っておきたい写真立てになります。') ?>">
  <meta name="robots" content="index,follow" />
  <title><?= lang('オリジナルラバーフォトフレームが作れます。') ?></title>
  <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
  <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
  <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
  <link href="/css/modal.css?v=1.02" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="/css/swiper.min.css">
  <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
  <?php include("../head_products.html"); ?>
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
  <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
  <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">
  <link rel="stylesheet" type="text/css" href="css/scroll.css">
  <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
  <style type="text/css">

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }

    #date_create_sample1,
    #date_create_sample2 {
      font-size: 22px;
      font-weight: bold;
      color: red;
      letter-spacing: -1px;
      overflow: hidden;
    }

    .mt-10 {
      max-width: 100%;
    }

    @media(max-width: 576px) {
      div.howto+div {
        font-size: 5vw !important;
      }
    }

    table.cld_tb {
      margin-top: 10px;
    }

    .repeat input[type="text"] {
        padding: 5px 10px;
        margin-left: -32px;
        width: -webkit-fill-available;
    }

    <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
  
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
  <link rel="stylesheet" href="rubberstrap/css/lightbox.css">
  <!-- /lightbox2-master -->
  <link rel="stylesheet" type="text/css" href="/products/css/foodproducts_banner.css?v=0.03">
</head>

<body id="top">
  <!-- :: header start :: -->
  <?php include("../header.html");  ?>
  <!-- :: header end :: -->
  <!-- globalNavi -->
  <?php include("../gnavi.php"); ?>
  <!-- globalNavi End -->

  <!-- :: wrapper start :: -->
  <div id="wrapper">
    <!-- sidemenu-->
    <?php include("../sidenavi.php"); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper">
      <?php include("rubber_info.php"); ?>
      <?php include('banner-campaign.php') ?>
      <h1><?= lang('オリジナルラバーフォトフレームが作れます。') ?>(2026年版)</h1>
      <div style="display: flow-root;">
        <div class="social-time">
          <span class="social-content">
            <a href="mailto:?subject=ラバータグをオリジナルの形状で製作します。&amp;body=最短10営業日で製作。ラバータグをオリジナルの形状で作成。同人からイベント、ノベルティまで。%0A%0A詳細はこちら:https://hotmobily.jp/products/rubberstrap/" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a>
            <a href="mailto:?subject=ラバータグをオリジナルの形状で製作します。&amp;body=最短10営業日で製作。ラバータグをオリジナルの形状で作成。同人からイベント、ノベルティまで。:https://hotmobily.jp/products/rubberstrap/" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
            <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubbertag" target="_blank"><i class="fab fa-facebook-square"></i></a>
            <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2frubbertag&amp;text=" target="_blank"><i class="fab fa-twitter-square"></i></a>
          </span>
          <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
        </div>
      </div>
      <img src="images/banner_rubber-frame.webp" width="100%" height="388" style="max-width: 770px;">
      <div class="flex-container" style="margin-top:10px;">
        <div class="flex-item item">
          <div class="videoWrapper" style="text-align:center;">
            <img src="images/rubber_frame_tn.webp" data-src="IKz2zNnn2tk" class="iframe" width="100%" height="213" style="max-width:378px;">
            <div class="playbtn">
              <div class="tri"></div>
            </div>
          </div>
        </div>
        <div class="flex-item item">
          <h2 style="margin-top: 0px;">オリジナルラバーフォトフレーム製作</h2>
          <p class="new-text">
            ラバーフォトフレームをオリジナルのデザインで製作できます。<br><br>
            お気に入りの写真やカードなどをオリジナルデザインのフレームに装着できます。世界に1点しかないオリジナルデザインでの作製です。<br><br>
            パーティやスポーツ大会はもちろん、家族写真やペットの写真などお好きな写真をいれて飾れます。<br><br>
            水濡れや黄ばみなど写真の経年劣化の保護にもなり、大切な思い出をより長い時間、保存して頂けます。
          </p>
        </div>
      </div>
      <hr />

        <h2>ラバー製品完全ガイドをご用意！</h2>
        <div>
            <a href="/lp/rubber-guide.php"><img class="" src="/products/images/rubberstrap/banner_rubber_guide.webp"></a>
        </div>
        <div>
            <p class="new-text">ラバー製品の製作を初めて依頼する方の場合、「このデザインはラバーで再現できるのかな？」「ベストな仕上がりにするために何ができるかな？」などの疑問が出てきますよね。</p><br>
            <p class="new-text">そんな方のために、ラバー製品のデザインのポイントや、ラバー製品をトラブルなくベストな仕上がりで製作するための注意点などについて、完全ガイドページで解説しています。
            </p><br>
            <p class="new-text">最高のラバーフォトフレーム製作にぜひともお役立てください。</p>
            <br>
            <div style="text-align: right;">
                <a href="/lp/rubber-guide.php" class="new-text">完全ガイドページはこちら</a>
            </div>
        </div>

      <hr>
      <h2><?= lang('ラバーフォトフレームとは、どんな製品？') ?></h2>
      <div class="block-g">
        <div class="block-title" style="background: #febc28;">RUBBER PHOTO FRAME FRONT</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/rubber_frame1z.webp" data-lightbox="imgst-set" style="text-decoration:none;">
              <img src="images/rubber_frame1.webp" width="455" height="270">
            </a>
          </div>
          <div class="bp2">
            <a href="images/rubber_frame4z.webp" data-lightbox="imgst-set" style="text-decoration:none;">
              <img src="images/rubber_frame4.webp" width="240" height="270">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/rubber_frame1z.webp" data-lightbox="imgst-set01" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
          <a href="images/rubber_frame4z.webp" data-lightbox="imgst-set01"></a>
        </div>
        <div class="b-text"><?= lang('フォトフレームは液体ラバー（ゴム）を成型し形を作ります。立体加工のある仕上がりです。') ?></div>
      </div>
      <div class="block-g">
        <div class="block-title" style="background: rgb(248,203,173);;">RUBBER PHOTO FRAME STAND</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/rubber_frame3z.webp" data-lightbox="imgst-set3" style="text-decoration:none;">
              <img src="images/rubber_frame3.webp" width="455" height="270">
            </a>
          </div>
          <div class="bp2">
            <a href="images/rubber_frame2z.webp" data-lightbox="imgst-set3" style="text-decoration:none;">
              <img src="images/rubber_frame2.webp" width="240" height="270">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/rubber_frame3z.webp" data-lightbox="imgst-set03" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
          <a href="images/rubber_frame2z.webp" data-lightbox="imgst-set03"></a>
        </div>
        <div class="b-text"><?= lang('スタンドでしっかりと支えます。机やテーブルなど置く場所を選びません。') ?></div>
      </div>
      <div class="block-g">
        <div class="block-title" style="background: rgb(248,203,173);;">RUBBER PHOTO FRAME INSIDE</div>
        <div class="row-bs">
          <div class="bp1">
            <a href="images/rubber_frame5z.webp" data-lightbox="imgst-set4" style="text-decoration:none;">
              <img src="images/rubber_frame5.webp" width="455" height="270">
            </a>
          </div>
          <div class="bp2">
            <a href="images/rubber_frame6z.webp" data-lightbox="imgst-set4" style="text-decoration:none;">
              <img src="images/rubber_frame6.webp" width="240" height="270">
            </a>
          </div>
        </div>
        <div class="t-pic">
          <a href="images/rubber_frame5z.webp" data-lightbox="imgst-set04" style="text-decoration:none; font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></a>
          <a href="images/rubber_frame6z.webp" data-lightbox="imgst-set04"></a>
        </div>
        <div class="b-text"><?= lang('裏面から写真を入れる事ができます。写真の取り外しも簡単にできます。') ?></div>
      </div>

      <hr />
      <h2><?= lang('ラバーフォトフレームの製作工程のご紹介') ?></h2>
      <div class="videoWrapper">
        <img src="/products/img/rubber-production-yt.webp" data-src="5KK0a4b1C9Q" class="iframe" width="773" height="435">
        <div class="playbtn">
          <div class="tri"></div>
        </div>
      </div>
      <hr />
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
        <a href="/products/new-template/template-RubberPhotoFrame.zip" class="resource-button" style="color: #233c4a">
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
        <a href="/contact/?item=フォトフレーム" class="resource-button" style="color: #233c4a">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
          <span>無料サンプルの送付をリクエスト</span>
        </a>
      </div>


      <!-- <div class="row how" style="margin-top: -8px;">
        <a class="mt-10 btn-a btn-yellow" href="/lp/rubber-guide-structure.php" target="_blank">
          <div class="howto"><img src="/products/images/icon-kako-rb.webp" width="34" height="34"></div>
          <div><?= lang('立体加工詳細') ?></div>
        </a>
        <a class="mt-10 btn-a btn-yellow" href="/products/quality.html" target="_blank">
          <div class="howto"><img src="/products/images/icon-qlt-rb.webp" width="34" height="34"></div>
          <div><?= lang('品質基準詳細') ?></div>
        </a>
        <a href="javascript:void(0)" class="mt-10 btn-a btn-yellow" for="modal-1" style="cursor: pointer;" onclick="$('#modal-1').prop('checked',true)">
          <div class="howto"><img src="/products/images/icon-des-rb.webp" width="34" height="34"></div>
          <div><?= lang('お客様へのお約束') ?></div>
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
      <h2>製作料金一覧</h2>
      <div class="tbl_s" style="position: relative;">
        <div class="scroll-center">
          <div class="arrow"></div>
        </div>
        <table class="tb-w12" width="100%" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
          <tr align="center">
            <td></td>
            <td>30個～</td>
            <td>100個～</td>
            <td>200個～</td>
            <td>300個～</td>
            <td>500個～</td>
            <td>1,000個～</td>
            <td>3,000個～</td>
            <td>5,000個～</td>
          </tr>
          <tr align="center">
            <td><?= lang('製品単価') ?></td>
            <td>1,430 円</td>
            <td>1,430 円</td>
            <td>1,166 円</td>
            <td>846 円</td>
            <td>714 円</td>
            <td>514 円</td>
            <td>388 円</td>
            <td>326 円</td>
          </tr>
          <tr align="center">
            <td><?= lang('税込総額') ?></td>
            <td>(42,900 円)</td>
            <td>(143,000 円)</td>
            <td>(233,200 円)</td>
            <td>(253,800 円)</td>
            <td>(357,000 円)</td>
            <td>(514,000 円)</td>
            <td>(1,164,000 円)</td>
            <td>(1,630,000 円)</td>
          </tr>
        </table>
      </div>
      <div class="font_s" style="text-align: right;">
        ※<?= lang('料金表です。') ?><br />
        ※<?= lang('上記価格は税込み価格です。') ?><br />
        ※<?= lang('トレース代金は含まれておりません。') ?><br />
      </div>
      <hr>
      <h2><?= lang('納期（製作期間）') ?></h2>
      <?php include('../notice.html'); ?><br>
      <p class="d_TEXT1 new-text"><?= lang('納期=製作日数+配送日数で計算致します。') ?></p><br />
      <p class="d_TEXT1 new-text">【<?= lang('製作期間') ?>】</p>
      ◆<?= lang('製作期間（単位：営業日。配送日数は含まず）') ?>
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
      <div class="font_s" style="text-align: right;">
        <?= lang('営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。') ?><br>
        <?= lang('製品生産国中国の長期休暇につきましては、別途定める休日が指定されます。') ?><br>
        <?= lang('色味指定を印刷紙で行う場合、+3営業日。') ?><br>
        <?= lang('（お客様から印刷紙手配が遅れる場合、この限りではございません）') ?>
      </div>
      <p class="d_TEXT1 new-text">【<?= lang('配送日数') ?>】<br>
        <?= lang('北海道、九州、沖縄は2日。その他地域は1日。（離島等に関しては、別途お問い合わせください。）') ?><br>
        <?= lang('配送日数は、営業日でなく土日祝も含めた日数となります。') ?>
      </p><br>
      <p class="d_TEXT1 new-text">
        【<?= lang('納期計算例') ?>】<br>
        <?= lang('300個、試作品なしでご注文の場合、') ?><br>
        <?= lang('・製作期間：10営業日') ?><br>
        <?= lang('・配送期間：1-2日（配送地域により異なります）') ?><br>
        <?= lang('となります。') ?>
      </p>
      <div style="clear: both;"></div>
      <div style="margin-top: 10px;">
        <a href="/campaign/quality_rubberstrap.php"><img data-src="/products/images/banner-quality-2025.webp" class="lazy" width="100%" height="" style="max-width:770px;"></a>
      </div>
      <?php include("campaign_news.php"); ?>
      <h2>厚労省の定める規格基準に合格した安全性の高い材料を使用</h2>
      <div style="text-align:center;"><a class="img-hover" href="/products/foodproducts.php?data=rubberframe" target="_blank"><img class="lazy" data-src="/img/safety-banner.webp" width="745" height="70"></a></div>
      <div style="clear:both;">&nbsp;</div>
      <div id="est-content">

      <?php include('campaign_banner.php') ?>
        <div style="clear:both;"></div>
        <h2><?= lang('ご注文・見積書作成') ?></h2>
      </div>
      <?php include('../notice.html'); ?>
      <div style="overflow: unset!important;">
        <div class="fixed-contrainer">
          <h3 class="red">【<?= lang('ラバーフォトフレーム（写真立て）') ?>】</h3>
          <span class="total-price"><span class="prd_total">0</span>円（<?= lang('税込') ?>）</span>
        </div>
        <div style="clear: both;"></div>
        <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
          <div class="step-box">
            <table class="table_rubber" style="padding: 0">
              <tr>
                <td><?= lang('サイズ') ?></td>
                <td><span>150X250mm以内。</span></td>
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
            <img src="/products/images/HM_part1-2.webp" width="320" height="320" id="sample-part-pic" class="picpro" style="display: none;"><br />
            <span id="sample-part-name">化粧箱</span>
          </div>
          <div class="step-box line2" style="text-align: center;">

          </div>
        </div>
        <div class="step-container">
          <div class="step-box step-list">
            <ul>
              <li id="dot-step1" class="active">
                <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ') ?></span>
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
            <input type="text" name="ItemType" id="strap" value="ラバーフォトフレーム（写真立て）" />
          </div>
          <?php
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
            <h3><?= lang('化粧箱') ?></h3>
            <div class="flex-container">
              <div class="preview-container">
                <div class="preview-sub flex-container">
                  <div class="flex-item">
                    <label class="part-name">
                      <input type="radio" name="packing" value="白色無地" <?= ($packing == "白色無地" ? "checked" : "") ?> onclick="clearValue();setToInput();">
                      <img data-src="/products/images/frame-packing1.webp" width="95" height="95" class="picpro lazy">
                      <br><span>+33円</span>
                    </label>
                  </div>
                  <div class="flex-item">
                    <label class="part-name">
                      <input type="radio" name="packing" value="OPP個別包装" <?= ($packing == "OPP個別包装" ? "checked" : "") ?> onclick="clearValue();setToInput();">
                      <img data-src="/products/images/frame-packing2.webp" width="95" height="95" class="picpro lazy">
                      <br><span>+0円</span>
                    </label>
                  </div>
                </div>
                <div class="error" id="part-error" style="text-align: center;"></div>
              </div>
            </div>
            <h3><?= lang('実物校正サンプル・データトレース') ?></h3>
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
                  <?= lang('実物校正サンプル') ?>
                </label>
              </div>
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
                      <td class="" style="text-align: left;">150X250mm以内。</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('ご注文本数') ?></td>
                      <td class="" id="prd_qty" style="text-align: left;"></td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('実物校正サンプル') ?></td>
                      <td class="" id="prd_SendPrototype" style="text-align: left;">なし</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class="" id="prd_DeFormat" style="text-align: left;">なし</td>
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
                    <tr style="display: none;">
                      <td class="TableLeft"><?= lang('シルク印刷代金') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="SilkPrint" readonly="readonly" id="textfield13" class="right" value="<?php echo $SilkPrint ?>" />円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('化粧箱代金') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="printingPrice" readonly="readonly" id="textfield13_3" class="right" value="<?= $printingPrice ?>">円</td>
                    </tr>
                    <tr style="display: none;">
                      <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PartPrice" readonly="readonly" id="textfield7_1" class="right" value="<?= $PartPrice ?>">円</td>
                    </tr>
                    <tr style="display: none;">
                      <td class="TableLeft"><?= lang('台紙') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="PaperPrice" readonly="readonly" id="textfield7_2" class="right" value="<?= $PaperPrice ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('実物校正サンプル') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="ProShipping" readonly="readonly" id="textfield3" class="right" value="<?= $ProShipping ?>">円</td>
                    </tr>
                    <tr>
                      <td class="TableLeft"><?= lang('データトレース') ?></td>
                      <td class=""><input style="text-align: right;" type="text" size="16" name="TraceCharge" readonly="readonly" id="textfield4" class="right" value="<?= $TraceCharge ?>">円</td>
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
                      <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn2('step2');$('#cus_detail').hide();"><?= lang('ｱﾀｯﾁﾒﾝﾄ修正') ?></a>
                      <input type="button" class="btn est-btn flex-item" value="<?= lang('見積書') ?>" id="button_pdf2" onclick="$('#cus_detail').toggle()" />
                      <input type="button" class="btn ord-btn flex-item" value="<?= lang('ご注文情報入力へ') ?>" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form); " />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
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
                  <input id="button_pdf" type="button" style="cursor:pointer;height: 30px;width: 250px;color: red" onclick="validate('gcd');$('.loading').show();" value="<?= lang('御社情報確定（PDF出力）') ?>" />
                  <div class="remark">&nbsp;<?= lang('※社名や会社名の入力は任意です') ?></div><span id="validate_error" style="color:red"></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <?php $fd_type = "rubberframe";
      include 'rubber_product_detail_test.php'; ?>
      <h2>営業担当が直接御社にお伺いし、様々な製品やサービスのご提案・ご説明をさせて頂きます。</h2>
      <div align="center">
        <a href="//hotmobily.jp/meeting_date/"><img src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a>
      </div>
      <br />
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->

  <!--フッター ここから-->
  <?php include("../footer.php"); ?>
  <!--フッター ここまで-->

  <!-- /lightbox2-master -->
  <script src="js/lightbox.js"></script>
  <script>
    lightbox.option({
      'maxWidth': 800,
      'maxHeight': 800,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <!-- /lightbox2-master -->
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.12"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <!-- google script -->
  <!-- リマーケティング タグの Google コード -->
  <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->
  <!-- Swiper JS -->
  <script src="/js/swiper.min.js"></script>
  <script src="/js/jquery.bxslider.js?v=1.00"></script>
  <script type="text/javascript" src="/js/_setToInput_2026.js?v=<?php echo date('is') ?>"></script>
  <script language="JavaScript" src="/js/validation_frame.js?v=1.11" type="text/javascript"></script>
  <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>
  <script type="text/javascript" src="/products/js/auto-slider.js"></script>
  <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
  <script src="/products/acrylic/ptw/photoswipe.min.js?v=1.08"></script>
  <script src="/products/acrylic/ptw/photoswipe-ui-default.min.js"></script>
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
        "product": "ラバーキーホルダー"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });

    $.ajax({
      type: "POST",
      url: "get_sample_date.php",
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
      screen.width <= 768 && (t.attr("src", "rubberstrap/images/img_txt2_n1.svg"), s.attr("src",
        "rubberstrap/images/text_sample_n1.svg"))
    }, (tmp != "" ? valid_chk_btn2('step3') : ""), setToInput());

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