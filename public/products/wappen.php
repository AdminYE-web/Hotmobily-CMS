<?php

ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
error_reporting(E_ALL ^ E_NOTICE);
//Read Modules
require_once('../control/Control_Rubber.php');

require_once __DIR__ . "/../connect_db/Control_Connect.php";

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


    // if($_COOKIE['username'] == "ome")
    // {
    //     echo "<pre>";
    //     print_r ($mrFormData);
    //     echo "</pre>";
    // }


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
    <meta name="keywords" content="<?= lang('オリジナル,ワッペン,パッチ,刺繍,ジャガード織,昇華転写,フルカラー,製作,デザイン,制作,名入れ,ロゴ,イラスト,写真') ?>">
    <meta name="description" content="<?= lang('オリジナルワッペン製作。あなたのデザインで完全オーダーメイド。刺繍・ジャガード織・昇華転写（フルカラー）の3種ご用意。細かいデザインでも安価にワッペン製作が可能。最短6営業日出荷の短納期。最小ロット50枚。ロゴ、イラスト、社名、写真など') ?>">
    <meta name="robots" content="index,follow">
    <title><?= lang('オリジナルワッペン製作|短納期&大ロットが超お得！フルカラー可') ?></title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="preload" type="text/css" href="/css/homepage_hotstrap.css" as="style"
        onload="this.rel='stylesheet'">
    <link href="/products/css/calendar.css?v=2" rel="stylesheet" type="text/css" />
    <link href="/products/css/box.css" rel="stylesheet" type="text/css" />
    <link href="/css/modal.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/swiper.min.css">
    <link href="/products/css/box-shadow.css?v=1.05" rel="stylesheet" type="text/css">
    <?php include("../head_products.html"); ?>
    <link rel="stylesheet" type="text/css" href="/campaign/css/all.css?v=1.01">
    <link href="/products/css/product_group.css?v=1.13" rel="stylesheet" type="text/css" />
    <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
    <link href="/products/acrylic/css/acrylic.css?v=1.04" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/products/acrylic/ptw/photoswipe.css">
    <link rel="stylesheet" href="/products/acrylic/ptw/default-skin.css">
    <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
    <link href="css/flight_tag.css?v=1.06" rel="stylesheet" type="text/css" />
    <link href="https://hotstrap.jp/css/products.css?v=1.16" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .part-content.preview-container {
            background: unset;
        }

        .choose_c img {
            width: 98%;
        }

        .d-none {
            display: none;
        }

        .show_c img {
            width: fit-content;
            height: auto;
        }

        #wrapper .pswp img {
            height: auto !important;
        }

        .pswp--animated-in .pswp__zoom-wrap {
            transform: translate3d(0px, 140px, 0px) scale(1) !important;
        }

        .orange2 {
            color: #ffc000;
            font-weight: bold;
            font-size: 28px;
            font-family: IwaUDGoDspPro-Eb, sans-serif !important;
        }

        .red2 {
            color: red;
            font-weight: bold;
            font-size: 29px;
            font-family: IwaUDGoDspPro-Eb, sans-serif !important;
        }

        .dsd {
            line-height: 1.5;
            /* margin-top: 30px !important; */
            margin-bottom: 20px !important;
            min-height: 56px;
            padding-top: 4px !important;
            font-size: 20px !important;
            align-items: center;
            border-bottom: unset !important;
            font-family: IwaUDGoDspPro-Th, sans-serif !important;
        }

        div.plus2 {
            position: absolute;
            right: 5px;
            bottom: 5px;
            color: #555;
            font-size: 17px;
            border-radius: 100%;
            width: 15px;
            height: 15px;
            /* background: linear-gradient(to bottom, #f3f5f6 0, #dedfe0 100%); */
            /* padding: 9px; */
            bottom: 16px;
            /* right: 10px; */
            left: 15px;
            width: 100%;
        }

        #step2 label.part-name.p-normal {
            padding: 10px !important;
            padding-left: 45px !important;
        }

        .table-container {
            overflow-x: auto;
            max-height: 400px;
            /* Set a max height for the container if needed */
        }

        .tbl_price_deli thead {
            position: sticky;
            top: 55px;
            background-color: #ffdada;
        }

        #content_wrapper>h2.feature1,
        #content_wrapper>h2.feature2,
        #content_wrapper>h2.feature3,
        #content_wrapper>h2.feature4 {
            text-align: left;
            color: #281600 !important;
            display: inline-block;
            font-size: 21px !important;
        }

        #content_wrapper>h2.feature1 .red,
        #content_wrapper>h2.feature2 .red,
        #content_wrapper>h2.feature3 .red,
        #content_wrapper>h2.feature4 .red {
            font-size: 29px;
            font-family: IwaUDGoDspPro-Eb, sans-serif !important;
        }

        #content_wrapper>h2.feature1 {
            background: transparent url(/products/images/wappen/feature-wappen-01.webp) no-repeat !important;
            background-size: 56px 56px !important;
            background-position: 0px center !important;
        }

        #content_wrapper>h2.feature2 {
            background: transparent url(/products/images/wappen/feature-wappen-02.webp) no-repeat !important;
            background-size: 56px 56px !important;
            background-position: 0px center !important;
        }

        #content_wrapper>h2.feature3 {
            background: transparent url(/products/images/wappen/feature-wappen-03.webp) no-repeat !important;
            background-size: 56px 56px !important;
            background-position: 0px center !important;
        }

        #content_wrapper>h2.feature4 {
            background: transparent url(/products/images/wappen/feature-wappen-04.webp) no-repeat !important;
            background-size: 56px 56px !important;
            background-position: 0px center !important;
        }

        .toon {
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 20px;
        }

        .flex-item.w-31 {
            flex: 0 0 30% !important;
        }

        .twice {
            flex-direction: row;
            justify-content: flex-start;
            gap: 10px;
        }

        .lb-prev,
        .lb-next {
            display: none !important;
        }

        @media screen and (max-width: 768px) {
            .flex-item.w-30 div.plus {
                bottom: 33% !important;
                right: 0;
            }

            .tbl_price_deli thead {
                top: 0;
                position: unset;
                display: block;
            }

            .tbl_s.cl2 {
                overflow-x: unset;
            }

            .tbl_price_deli tbody {
                max-height: 250px;
                overflow-y: auto;
                display: block;
                width: 100%;
            }

            .tbl_price_deli tbody tr {
                width: 100%;
                display: table;
            }

            .tbl_price_deli tbody td {
                width: calc(100% / 7);
            }

            .tbl_price_deli th {
                width: calc(100% /7);
            }

            .switch_off_button {
                min-width: 70px;
            }

            .toon {
                gap: 12px;
            }

            #step2 .paper-container {
                display: none;
            }

            .flex-item.w-31 {
                flex: 0 0 48% !important;
            }
        }

        .tbl_price_deli tr td:nth-child(n+2):hover {
            background: #d9ffe3;
            cursor: pointer;
        }

        table.tbl_price_deli tr td:nth-child(1) {
            background: #ffdada !important;
        }

        table.tbl_price_deli tr:nth-child(2)>th:nth-child(n) {
            background: #b8e9ff;
            color: #2196f3;
        }

        .tb-w12-new tbody td:not(:first-child) {
            background: #f0f0f0;
        }

        .tb-w12-new tr:nth-child(3) td:nth-child(n+2) {
            background: white !important;
        }

        .tb-w12-new {
            background: #f0f0f0;
        }

        .col-md-6 {
            width: 50%;
            margin: 0 auto;
        }

        table.col-md-6 {
            border: #000000 1px solid;
            border-collapse: collapse;
            text-align: center;
        }

        table.col-md-6 td {
            border: #000000 1px solid;
            border-collapse: collapse;
            padding: 5px;
        }

        /* All gallbox child */

        @media (max-width: 576px) {
            .gallbox {
                width: 33%;
                text-align: left;
            }

            .gallbox {
                display: block !important;
            }

            .col-md-6 {
                width: 100%;
            }

            .switch_off_button {
                min-width: 70px;
            }

            .toon {
                gap: 12px;
            }

            #step2 .paper-container {
                display: none;
            }

            .flex-item.w-31 {
                flex: 0 0 48% !important;
            }
        }

        #step2 .paper-container {
            height: fit-content;
        }

        input[name=template_code] {
            padding: 5px;
            font-size: 16px;
            margin-left: 5px;
        }

        #step2 label#template_code {
            padding: 5px !important;
        }

        .repeat input[type="text"] {
            padding: 5px 10px;
            margin-left: -32px;
            width: -webkit-fill-available;
        }

        #content_wrapper>h2.feature1,
        #content_wrapper>h2.feature2,
        #content_wrapper>h2.feature3,
        #content_wrapper>h2.feature4 {
            line-height: 1.2 !important;
        }

        .btn-lg {
            width: 48%;
            padding: 10px;
        }

        .btn {
            margin: 10px 0;
        }

        .btn-warning {
            background: orange;
            color: white;
            border: 1px solid #ac7506;
        }

        .btn-success {
            background: #4CAF50;
            color: white;
            border: 1px solid green;
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

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .new-text {
            font-size: 16px !important;
            letter-spacing: 0.05em !important;
            line-height: 150% !important;
        }

        #date_create111,
        #date_create222,
        #date_create_5days_1,
        #date_create_5days_2 {
            font-size: 22px;
            font-weight: bold;
            color: black;
            letter-spacing: -1px;
            overflow: hidden;
        }
  .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
}
        <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
    </style>
    <script>
        $(document).ready(function() {
            $("#open1").click(function() {
                $("#slide1").slideToggle("slow");
            });
        });
    </script>
    <!-- lightbox2-master -->
    <link rel="stylesheet" href="css/lightbox.css">
    <!-- /lightbox2-master -->

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
            <?php include('../global_news.html'); ?>
            <?php include('banner-campaign.php') ?>
            <h1><?= lang('オリジナルワッペンの製作') ?></h1>
            <div class="social-time">
                <span class="social-content">
                    <a href="mailto:?subject=オリジナルメガネクロス&amp;body=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。:https://hotmobily.jp/products/cloth.php" title="Share by Email" target="_blank"><?= lang('シェアする') ?></a><a href="mailto:?subject=オリジナルメガネクロス&amp;body=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。:https://hotmobily.jp/products/cloth.php" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
                    <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fcloth.php" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fcloth.php&amp;text=マイクロファイバー生地を使用し、オリジナルメガネクロスが製作できます。" target="_blank"><i class="fab fa-twitter-square"></i></a>
                </span>
                <span class="time-content"><?= lang('更新日') ?> 2026年8月3日</span>
            </div>

            <img src="images/banner_wappen_2024.webp" alt="オリジナルワッペン" />
            <div>&nbsp;</div>

            <p class="new-text">
                オリジナルワッペンをお好みのデザインで製作できます。刺繍タイプ・ジャガード織タイプ・昇華転写ワッペンの3種。社名の文字やロゴ・イラスト入りワッペンを、ノベルティやイベントグッズとして作成します。最短6営業日後出荷の短納期、50枚からご注文いただけます。バッグや衣類などに付けやすいよう、裏面加工の種類も豊富。マジックテープ加工・アイロンテープ・接着シール・クレジット印字がお選びいただけます。
            </p>
            <div>&nbsp;</div>

            <h2><?= lang('オリジナルワッペンの特徴') ?></h2>
            <p class="new-text"><span class="red" style="font-family:IwaUDGoDspPro-Eb, sans-serif !important;font-size:16px;">刺繍・ジャガード織・昇華転写</span>の3タイプのワッペンをご用意しております。</p>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a href="images/wappen/Embroidered_Wappen.webp?v=1.01" data-lightbox="sample_0_1" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/wappen/Embroidered_Wappen.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text" style="text-align:center;display:block;">刺繍</h3>
                </div>
                <div class="flex-item w-30">
                    <a href="images/wappen/Jacquard_Wappen.webp?v=1.01" data-lightbox="sample_0_2" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/wappen/Jacquard_Wappen.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text" style="text-align:center;display:block;">ジャガード織</h3>
                </div>
                <div class="flex-item w-30">
                    <a href="images/wappen/Pring_Wappen.webp?v=1.01" data-lightbox="sample_0_3" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/wappen/Pring_Wappen.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text" style="text-align:center;display:block;">昇華転写</h3>
                </div>
            </div>
            <div>
                <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">刺繍ワッペン</h2>
                <p class="new-text">刺繍糸でデザインを再現。圧倒的な高級感を備えた定番タイプのワッペンです。</p><br />
                <p class="new-text">刺繍糸のボリュームによる立体的なデザインで、プレミアム感を演出。重厚で特別なワッペンをお届けいたします。</p>
                <p class="new-text">社名や店名、チーム名、ロゴ、キャラクターなどを厚みのあるデザインで再現すれば、自社ブランドやオリジナルキャラクターを、動き出すような立体感でグッと目立たせることが可能です。一針一針の存在感が文字やイラストを際立たせます。インパクト重視の太字やシンプルなロゴにとくに向いたタイプです。</p><br />
                <p class="new-text">カラーデザインにつきましては、お客様のデザインをできる限り忠実に再現するべく、使用する刺繍糸の色を当店の色のプロが厳選いたします。</p>
            </div>
            <div>
                <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">ジャガード織ワッペン</h2>
                <p class="new-text">生地そのものでデザインを再現。細かなデザインにぴったりのワッペンです。</p><br />
                <p class="new-text">繊細なデザインこそ、ジャガード織の出番。微細なラインまで妥協しない織りの美学で、複雑な図案を精密に再現してみせます。「普通のワッペン」ではなく、見る人の視線を奪う緻密な「アート」をお届けいたします。「織り」だからこそ出せる精細なクオリティです。</p>
                <p class="new-text">細部に魂を込めたこだわりの絵柄、美を追求した図柄、圧巻のディテールを、糸一本一本の織りの力によって実現します。</p><br />
                <p class="new-text">微細なラインだけでなく、カラーデザインにつきましても、もちろん妥協はいたしません。当店の色の専門家が、プロの目線で生地に用いる色糸を厳選いたします。</p>
            </div>
            <div>
                <h2 style="font-size: 21px;letter-spacing: 0.05em;line-height: 150%;">昇華転写ワッペン</h2>
                <p class="new-text">フルカラープリントでデザインを再現。写真のようなデザインやグラデーションをカタチにし、さらにコストを抑えたワッペンです。</p><br />
                <p class="new-text">精度の高い印刷技術で、奥行きや陰影、繊細な色の移ろいを、高解像度であざやかに再現。まるで風景がそのままワッペンになったかのような一品をお届けいたします。さらに、刺繍・ジャガード織と比べ安価なことも大きな魅力です。</p>
                <p class="new-text">目を疑うような写真級のリアルさ、緻密なグラフィック、絶妙な色の階調の再現を可能にした新定番。従来のワッペンでは超えられなかった一線を見事に超えました。</p><br />
                <p class="new-text">最高級の発色で、見とれるようなグラデーション、ぼかしや濃淡、色の重なりなど色彩の芸術の世界を描き出します。</p>
            </div>
            <h2 class="feature1"><span class="red">安さ</span>が自慢。<span class="red">業界最安値</span>をめざしています</h2>
            <!-- <img src="images/wappen_banner_202411.webp" alt="オリジナルワッペン" /> -->
            <img src="images/wappen-banner_20250211.webp" alt="オリジナルワッペン" />
            <div>&nbsp;</div>
            <p class="new-text">HOTMOBILYオリジナルグッズのワッペンは、ロット数が増えれば増えるほど単価が安くなる価格設定となっており、<span class="red new-text" style="text-decoration: underline;">ワッペンのサイズが大きくなっても単価が上がりにくいことが特徴です。</span>「<span class="red new-text" style="text-decoration: underline;">大きいサイズのワッペンをお得に作りたい！</span>」「<span class="red new-text" style="text-decoration: underline;">大ロットを安く注文したい！</span>」とお考えのお客様にぴったりです。</p>
            <div>&nbsp;</div>

            <p class="new-text"><span class="red new-text" style="text-decoration: underline;">また、糸色数が増えても単価が上がりにくいことが特徴です。</span>色目以降の追加料金はたったの@22円（税込）です。（4色使用の場合は＋@22円（税込）、5色使用の場合は＋@44円（税込）となります）常に業界最安値を目指してます。</p>
            <div>&nbsp;</div>
            <p class="new-text">フチ加工のオーバーロック仕上げも＋@55円（税込）と激安設定。裏面加工もアイロンテープは＋@11円（税込）、その他マジックテープなども＋@55円（税込）で承っております。</p>
            <div>&nbsp;</div>

            <h2 class="feature2">フチ加工や裏面加工など、<span class="red">オプション加工</span>の種類も豊富です</h2>
            <p class="new-text">
                ワッペンのフチ加工は、オーバーロック仕上げとレーザーカット仕上げ（切り落とし）のいずれかをお選び頂けます。オーバーロック仕上げの糸は、ご希望の色に最も近い色を使用いたします。また裏面加工は、マジックテープ加工・アイロンテープ・接着シール・クレジット印字のご用意がございます。
            </p>


            <div class="d-flex twice">
                <div class="flex-item w-30">
                    <a href="images/wappen_overlock.webp?v=1.01" data-lightbox="sample_3_1" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/wappen_overlock.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text">▲オーバーロック仕上げ</h3>
                </div>
                <div class="flex-item w-30">
                    <a href="images/Heat_cut.webp?v=1.01" data-lightbox="sample_3_2" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/Heat_cut.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text">▲レーザーカット仕上げ</h3>
                </div>
            </div>


            <!-- <div class="d-flex">
                    <div class="flex-item w-30">
                        <a href="images/flight_tag/W_-09.webp?v=1.01" data-lightbox="sample_3_1" data-title="" style="text-decoration:none;">
                            <img class="lazy" data-src="images/flight_tag/W_-09.webp?v=1.01">
                            <div class="plus"><i class="fas fa-search-plus"></i></div>
                        </a>
                        <h3 class="new-text">▲オーバーロック仕上げ</h3>
                    </div>
                    <div class="flex-item w-30">
                        <a href="images/flight_tag/W_-10.webp?v=1.01" data-lightbox="sample_3_2" data-title="" style="text-decoration:none;">
                            <img class="lazy" data-src="images/flight_tag/W_-10.webp?v=1.01">
                            <div class="plus"><i class="fas fa-search-plus"></i></div>
                        </a>
                        <h3 class="new-text">▲ヒートカット仕上げ</h3>
                    </div>
                    <div class="flex-item w-30">
                        <a href="images/wappen/Heat_cut.webp?v=1.01" data-lightbox="sample_3_3" data-title="" style="text-decoration:none;">
                            <img class="lazy" data-src="images/wappen/Heat_cut.webp?v=1.01">
                            <div class="plus"><i class="fas fa-search-plus"></i></div>
                        </a>
                        <h3 class="new-text">▲レーザーカット仕上げ</h3>
                    </div>
                </div> -->


            <!-- <div style="margin: 10px 0;">
                <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                        <td></td>
                        <td style="text-align: center;">刺繍</td>
                        <td style="text-align: center;">ジャガード織</td>
                        <td style="text-align: center;">昇華転写</td>
                    </tr>
                    <tr>
                        <td style="">オーバーロック仕上げ</td>
                        <td style="text-align: center;">〇</td>
                        <td style="text-align: center;">〇</td>
                        <td style="text-align: center;">〇</td>
                    </tr>
                    <tr>
                        <td style="">レーザーカット仕上げ</td>
                        <td style="text-align: center;">〇</td>
                        <td style="text-align: center;">〇</td>
                        <td style="text-align: center;">〇</td>
                    </tr>
                </table>
            </div> -->

            <h2 class="feature3"><span class="red">刺繍ワッペンは生地色豊富！</span>刺繍カラーもご希望に近い色を選択可能！</h2>
            <p class="new-text">
                刺繍ワッペンは、ベースとなる生地の上に刺繍を模様として加工します。このため、刺繍ワッペンは生地色を選択する必要がございます。表と裏、それぞれ22色からお選びください。その他の色も、ご希望の色に合わせてお選びいただけます。刺繍糸色は、お客様のデザインをもとに当店にて選定した色を使用いたします。（基本8色まで選択可）。ジャガード織ワッペンは、生地を織る際に複数の色の糸を使い分けることでデザインを再現するため、生地色という考え方がありません。昇華転写ワッペンも、デザインのプリントの際に生地全体を染めるため、生地色という考え方はありません。
            </p>
            <h3 style="font-family: IwaUDGoDspPro-Eb, sans-serif !important;font-size: 20px;">ツイル生地</h3>
            <img class="lazy" data-src="images/flight_tag/F_-34.webp">
            <div>&nbsp;</div>
            <h3 style="font-family: IwaUDGoDspPro-Eb, sans-serif !important;font-size: 20px;">フェルト生地</h3>
            <img class="lazy" data-src="images/flight_tag/F_-39.webp">
            <div>&nbsp;</div>

            <!-- <h2 class="toggle-header">重厚感・高級感重視なら刺繍ワッペンがおすすめ！<span>+</span></h2>
                <div class="toggle-container">
                    <p class="new-text"></p>          
                    <div>
                        <img src="https://hotmobily.jp/lp/images/wappen/wappen_guide01_01.webp" alt="">
                    </div>
                    <br>
                    <p class="new-text">重厚感や高級感のあるワッペンをお求めの方には、刺繍ワッペンをおすすめしております。刺繍糸の厚みでデザインやワッペンそのものに厚みが出るので、クオリティがグッと高く見えます。</p>
                    <br>
                    <p class="new-text">刺繍ワッペンをご検討中の方向けに、土台の生地選びや刺繍ワッペンが得意なこと・苦手なことなどをガイドページで解説していますので、ぜひご確認ください。</p>
                    <br>
                    <div style="text-align: right;">
                        <a href="/lp/wappen_guide_embroidery.php" class="new-text">刺繍ワッペンガイドページはこちら</a>
                    </div>
                </div> -->


            <!-- <div>&nbsp;</div> -->
            <h2 class=""><?= lang('ワッペンの生地の種類') ?></h2>
            <p class="new-text">刺繍ワッペンと昇華転写のワッペンは、ベースとなる生地に種類があります。</p>
            <div style="margin: 10px 0;">
                <table width="100%" class="tb-w12" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                        <td>生地の種類</td>
                        <td style="text-align: center;">刺繍</td>
                        <td style="text-align: center;">昇華転写</td>
                    </tr>
                    <tr>
                        <td>ツイル</td>
                        <td style="text-align: center;">〇</td>
                        <td style="text-align: center;">〇</td>
                    </tr>
                    <tr>
                        <td>フェルト</td>
                        <td style="text-align: center;">〇</td>
                        <td style="text-align: center;">✕</td>
                    </tr>
                    <tr>
                        <td>サテン</td>
                        <td style="text-align: center;">✕</td>
                        <td style="text-align: center;">〇</td>
                    </tr>
                </table>
            </div>
            <p class="new-text">上記のように、一般的なツイル生地、温かみのあるフェルト生地、表面がなめらかなサテン生地、高級感と光沢感のあるエンブクロスを取り扱っております。</p>
            <p class="new-text">ジャガード織ワッペンは、デザインを生地に直接織り込むかたちなので、生地の種類は1種類のみです。</p>

            <div class="d-flex">
                <div class="flex-item">
                    <a href="images/flight_tag/W_-07.webp?v=1.01" data-lightbox="sample_2_1" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/flight_tag/W_-07.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text">▲ツイル生地（63・緑色 使用）</h3>
                </div>
                <div class="flex-item">
                    <a href="images/flight_tag/W_-08.webp?v=1.01" data-lightbox="sample_2_2" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/flight_tag/W_-08.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text">▲フェルト生地（T54・黄色 使用）</h3>
                </div>
            </div>
            <div class="d-flex">
                <div class="flex-item">
                    <a href="images/wappen/Satin.webp?v=1.01" data-lightbox="sample_3_1" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/wappen/Satin.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text">▲サテン生地</h3>
                </div>
                <!-- <div class="flex-item">
                    <a href="images/wappen/Embcross.webp?v=1.01" data-lightbox="sample_3_2" data-title="" style="text-decoration:none;">
                        <img class="lazy" data-src="images/wappen/Embcross.webp?v=1.01">
                        <div class="plus"><i class="fas fa-search-plus"></i></div>
                    </a>
                    <h3 class="new-text">▲エンブクロス生地</h3>
                </div> -->
            </div>

            <h2 class=""><?= lang('フチ加工・裏面加工') ?></h2>
            <div class="">
                <!-- <p class="new-text">ワッペンのフチ加工は、オーバーロック仕上げ・ヒートカット仕上げ・レーザーカット仕上げからお選びいただけます。刺繍・ジャガード織はオーバーロックとヒートカットのいずれか、昇華転写はオーバーロック仕上げとレーザーカットのいずれかになります。オーバーロック仕上げは、フチを二重縫いしているので、製品に厚みが出てワッペンに高級感が増します。ヒートカット仕上げは、高温のカッターでワッペン生地を溶かしながら裁断するため、ほつれにくくなります。レーザーカット仕上げは、レーザー光線で生地を裁断する仕上げ方法で、細かなカットが得意です。裏面加工はマジックテープ加工・アイロンテープ・接着シール・加工なしからお選びいただけます。クレジット表記などを1色で印字することも可能です。</p> -->
                <p class="new-text">ワッペンのフチ加工は、オーバーロック仕上げ・レーザーカット仕上げからお選びいただけます。オーバーロック仕上げは、フチを二重縫いしているので、製品に厚みが出てワッペンに高級感が増します。ただ、星形など鋭角のある形状や複雑な形状にオーバーロック仕上げを施すのは難しく、四角形や丸形などシンプルな形状に向いた仕上げです。レーザーカット仕上げは、鋭角のある形状や複雑な形状にも対応できます。レーザー光線で生地を裁断する仕上げ方法で、細かなカットが得意です。裏面加工はマジックテープ加工・アイロンテープ・接着シール・加工なしからお選びいただけます。クレジット表記などを1色で印字することも可能です。</p>
                <div>&nbsp;</div>
                <div class="d-flex">
                    <div class="flex-item w-30">
                        <a href="images/flight_tag/W_-11.webp?v=1.01" data-lightbox="sample_4_1" data-title="" style="text-decoration:none;">
                            <img class="lazy" data-src="images/flight_tag/W_-11.webp?v=1.01">
                            <div class="plus"><i class="fas fa-search-plus"></i></div>
                        </a>
                        <h3 class="new-text">▲マジックテープ加工</h3>
                    </div>
                    <div class="flex-item w-30">
                        <a href="images/flight_tag/W_-12.webp?v=1.01" data-lightbox="sample_4_2" data-title="" style="text-decoration:none;">
                            <img class="lazy" data-src="images/flight_tag/W_-12.webp?v=1.01">
                            <div class="plus"><i class="fas fa-search-plus"></i></div>
                        </a>
                        <h3 class="new-text">▲アイロンテープ</h3>
                    </div>
                    <div class="flex-item w-30">
                        <a href="images/flight_tag/W_-13.webp?v=1.01" data-lightbox="sample_4_3" data-title="" style="text-decoration:none;">
                            <img class="lazy" data-src="images/flight_tag/W_-13.webp?v=1.01">
                            <div class="plus"><i class="fas fa-search-plus"></i></div>
                        </a>
                        <h3 class="new-text">▲接着シール</h3>
                    </div>
                </div>
            </div>

            <h2>納期</h2>
            <div>
                <p class="new-text"><span class="red new-text">最短6営業日後出荷</span>が可能です。</p><br>
                <p class="new-text">ワッペンのタイプ別の製作日数（デザイン確定から出荷までにかかる営業日数）は以下になります。</p><br>

                <table width="100%" class="tb-w12-new" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
                    <tbody>
                        <tr align="center">
                            <td align="center" style="padding: 8px;">数量</td>
                            <td align="center" style="padding: 8px;">刺繍タイプ</td>
                            <td align="center" style="padding: 8px;">ジャガード織タイプ</td>
                            <td align="center" style="padding: 8px;">昇華転写タイプ</td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 8px;">50</td>
                            <td align="center" style="background-color: white;">7</td>
                            <td align="center" style="background-color: white;">7</td>
                            <td align="center" style="background-color: white;">6</td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 8px;">100</td>
                            <td align="center" style="background-color: white;">7</td>
                            <td align="center" style="background-color: white;">10</td>
                            <td align="center" style="background-color: white;">7</td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 8px;">300</td>
                            <td align="center" style="background-color: white;">10</td>
                            <td align="center" style="background-color: white;">10</td>
                            <td align="center" style="background-color: white;">7</td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 8px;">500</td>
                            <td align="center" style="background-color: white;">12</td>
                            <td align="center" style="background-color: white;">10</td>
                            <td align="center" style="background-color: white;">7</td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 8px;">1000</td>
                            <td align="center" style="background-color: white;">15</td>
                            <td align="center" style="background-color: white;">12</td>
                            <td align="center" style="background-color: white;">10</td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 8px;">3000</td>
                            <td align="center" style="background-color: white;">15</td>
                            <td align="center" style="background-color: white;">15</td>
                            <td align="center" style="background-color: white;">12</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p class="new-text">なお、試作品の納期は、ワッペンのタイプに関わらず6営業日後出荷となります。</p>
            </div>
            <div style="clear:both;"></div>
            <div>
                <h2>本生産納期</h2>
                <div style="display: flex;">
                    <div class="delivery"><span class="btn-a std-btn"><?= lang('刺繍・ジャガード織'); ?></span></div>
                    <div class="delivery">
                        <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('7営業日後出荷'); ?></div>
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
                <div style="text-align: right;">
                    <span class="red">※</span><?= lang('刺繍タイプ300個未満、ジャガード織タイプ100個未満の場合の出荷予定日です。'); ?>
                </div>
            </div>
            <div style="clear:both;"></div>
            <!-- <div>
                    <h2>本生産納期</h2>
                    <div style="display: flex;">
                        <div class="delivery"><span class="btn-a std-btn"><?= lang('ジャガード織'); ?></span></div>
                        <div class="delivery">
                            <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('7営業日後出荷'); ?></div>
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
                            <td><span id="date_create111"></span></td>
                            <td><span id="date_create222"></span></td>
                        </tr>
                    </table>
                </div>
                <div style="clear:both;"></div> -->
            <br>
            <div>
                <!-- <h2>本生産納期</h2> -->
                <div style="display: flex;">
                    <div class="delivery"><span class="btn-a std-btn"><?= lang('昇華転写'); ?></span></div>
                    <div class="delivery">
                        <div class="tb_02" style=" color: #006ab1;padding: 2px 5px;"><?= lang('6営業日後出荷'); ?></div>
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
                        <td><span id="date_create_5days_1"></span></td>
                        <td><span id="date_create_5days_2"></span></td>
                    </tr>
                </table>
                <div style="text-align: right;">
                    <span class="red">※</span><?= lang('100個未満の場合の出荷予定日です。'); ?>
                </div>
            </div>
            <div style="clear:both;"></div>
            <hr />
            <div>
                <h2>試作納期</h2>
                <div style="display: flex;">
                    <div class="delivery"><span class="btn-a" style="background: #66fffe; color: #000;">試作納期</span>
                    </div>
                    <div class="delivery">
                        <div class="tb_06" style="color: #004140;padding: 2px 5px;">6営業日後出荷</div>
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
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <h2><?= lang('製作料金') ?></h2>
            <p class="new-text">刺繍・ジャガード織タイプと昇華転写タイプ、それぞれの料金表をご用意しております。ご希望のサイズ・数量に該当する価格表記をクリックすると、注文画面に進みます。</p>
            <div class="tab-container">
                <div class="tab-header">
                    <div class="tab tab-warning active" onclick="showTab(1)">刺繍・ジャガード織料金表</div>
                    <div class="tab tab-success" onclick="showTab(2)">昇華転写料金表</div>
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
                    <table class="tbl_price_deli loading">
                        <thead>
                            <tr>
                                <th rowspan="2">縦＋横（cm）</th>
                                <th colspan="6">数量</th>
                            </tr>
                            <tr>
                                <th colspan="">50</th>
                                <th colspan="">100</th>
                                <th colspan="">300</th>
                                <th colspan="">500</th>
                                <th colspan="">1000</th>
                                <th colspan="">3000</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 5; $i <= 30; $i++) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <?php foreach ($prices as $key => $price) : ?>
                                        <td data-size="<?= $i ?>" data-qty="<?= $key ?>" onclick="pre_set(this);"><?= floor(($price + (15 * ($i - 5))) * 1.1) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="price-table2 tab-panel" style="display: none;">

                <table class="tbl_price_deli">
                    <thead>
                        <tr>
                            <th>枚数</th>
                            <th>1枚あたりの単価</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>50</td>
                            <td>638</td>
                        </tr>
                        <tr>
                            <td>100</td>
                            <td>418</td>
                        </tr>
                        <tr>
                            <td>300</td>
                            <td>220</td>
                        </tr>
                        <tr>
                            <td>500</td>
                            <td>187</td>
                        </tr>
                        <tr>
                            <td>1000</td>
                            <td>176</td>
                        </tr>
                        <tr>
                            <td>3000</td>
                            <td>154</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>&nbsp;</div>
            <h3 class="new-text">【データトレース代金について】</h3>
            <p class="new-text">アドビイラストレータの入稿データをお持ちでない場合、当店にてイラストレータファイルに変換するトレース作業を行います。その際、製作料金とは別に2,200円（税込）がかかります。</p>
            <h3 class="new-text">【版型料金】</h3>
            <p class="new-text">1つのご注文につき、版型料金が上記料金とは別に4,400円（税込）かかります。</p>
            <h3 class="new-text">【フチ加工】</h3>
            <p class="new-text">・オーバーロック仕上げ：＋@55円（税込）</p>
            <!-- <p class="new-text">・ヒートカット仕上げ：追加料金なし</p> -->
            <p class="new-text">・レーザーカット仕上げ:追加料金なし</p>
            <h3 class="new-text">【裏面加工】</h3>
            <p class="new-text">・マジックテープ ：＋@55円（税込）</p>
            <p class="new-text">・アイロンテープ： ＋@11円（税込）</p>
            <p class="new-text">・接着シール：＋@55円（税込）</p>
            <p class="new-text">・クレジット印字：＋@55円（税込）</p>
            <h3 class="new-text">【刺繍糸色の数】</h3>
            <p class="new-text">糸色3色までは同一金額となります。4色以上は1色ごとに@22円（税込）加算となります。</p>
            <table width="100%" class="tb-w12-new" border-solid="1" bordercolor="#cccccc" border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
                <tbody>
                    <tr align="center">
                        <td>&nbsp;</td>
                        <td align="center" colspan="7">刺繍糸色の数</td>
                    </tr>
                    <tr align="center">
                        <td>&nbsp;</td>
                        <td align="center">1～3色 </td>
                        <td align="center">4色</td>
                        <td align="center">5色</td>
                        <td align="center">6色</td>
                        <td align="center">7色</td>
                        <td align="center">8色</td>
                    </tr>
                    <tr>
                        <td>追加料金</td>
                        <td align="">なし</td>
                        <td align="">@22円（税込）</td>
                        <td align="">@44円（税込）</td>
                        <td align="">@66円（税込）</td>
                        <td align="">@88円（税込）</td>
                        <td align="">@110円（税込）</td>
                    </tr>
                </tbody>
            </table>
            <p class="new-text">刺繍タイプは8色、ジャガード織タイプは9色までご使用可能です。</p>
            <h3 class="new-text">【包装料金】</h3>
            <p class="new-text">・まとめ包装：追加料金なし</p>
            <p class="new-text">・個包装：＋@8円（税込）</p>
            <h3 class="new-text">【試作品】</h3>
            <p class="new-text">5,500円（税込）の追加料金がかかります。なお、300個以上ご注文の場合は無料です。</p>
            <h3 class="new-text">【WEB掲載】</h3>
            <p class="new-text">ご注文画面にて「製作実績の掲載を許可する」をお選びいただいたお客様には、ご注文数量にかかわらず、合計金額から5,500円（税込）割引とさせていただきます。</p>

            <h2 class=""><?= lang('テンプレート') ?></h2>
            <div class="">
                <div class="flex-container justify-between">
                    <a class="btn-a btn-yellow download_temp" href="download/download?fname=template-flighttag-wappen_20231215.zip">
                        <span>オリジナルワッペン</span>
                    </a>
                </div>
            </div>

            <h2>オリジナルワッペン製作事例</h2>
            <!-- New image gallery -->
            <div class="ex-row">
                <div class="gall_pro">
                    <div class="gallbox">
                        <div class="prodate">名入れ</div>
                        <a href="images/wappen/20260129130033208_0 1.webp" data-lightbox="1" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/20260129130033208_0 1.webp" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">車デザイン</div>
                        <a href="images/wappen/20260129130817214_0 1.webp" data-lightbox="2" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/20260129130817214_0 1.webp" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">ウルフドッグ</div>
                        <a href="images/wappen/dogwappen1203.webp?v=1.01" data-lightbox="3" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/dogwappen1203.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">サボテン</div>
                        <a href="images/wappen/tree_1.webp?v=1.01" data-lightbox="4" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/tree_1.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">花とテントウムシ</div>
                        <a href="images/wappen/flowerwappen1203.webp?v=1.01" data-lightbox="5" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/flowerwappen1203.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <!-- New -->
                    <div class="gallbox">
                        <div class="prodate">レースカー</div>
                        <a href="images/wappen/car12.webp?v=1.01" data-lightbox="6" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/car12.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">クラシックカー</div>
                        <a href="images/wappen/car13.webp?v=1.01" data-lightbox="10" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/car13.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">ポップな自転車</div>
                        <a href="images/wappen/bikewappen1203.webp?v=1.01" data-lightbox="7" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/bikewappen1203.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">クールな自転車ワッペン</div>
                        <a href="images/wappen/bike10.webp?v=1.01" data-lightbox="8" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/bike10.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">ビビッドデザイン</div>
                        <a href="images/wappen/bike6.webp?v=1.01" data-lightbox="9" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/bike6.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">バイクワッペン</div>
                        <a href="images/wappen/motor10.webp?v=1.01" data-lightbox="11" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/motor10.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">レッドバイク</div>
                        <a href="images/wappen/motor5.webp?v=1.01" data-lightbox="12" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/motor5.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">ジャック・ラッセル・テリア</div>
                        <a href="images/wappen_production_ghost.webp?v=1.01" data-lightbox="13" data-title="" style="text-decoration:none;">
                            <img src="images/wappen_production_ghost.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">ガーベラ</div>
                        <a href="images/wappen/flower_3.webp?v=1.01" data-lightbox="14" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/flower_3.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>

                    <div class="gallbox">
                        <div class="prodate">自転車と子ども</div>
                        <a href="images/wappen/bike11.webp?v=1.01" data-lightbox="15" data-title="" style="text-decoration:none;">
                            <img src="images/wappen/bike11.webp?v=1.01" class="picpro" width="229" height="229"><br />
                            <div class="camera-left" style="font-size: 10px;">📷<?= lang('クリックすると拡大します') ?></div>
                        </a>
                    </div>
                </div>
                <div style="text-align: center; margin: 15px auto 0;" id="est-content-prd">
                    <button class="but3">
                        <a href="/gallery/wappen" style="text-decoration: none; color: black; font-size: 16px; padding: 10px 40px;" class=""><?= lang('もっと製作事例を見る') ?> <i class="fas fa-arrow-circle-right"></i></a>
                    </button>
                </div>
            </div>
            <div style="clear:both;"></div>

            <h2 id="est-contents"><?= lang('デザインサンプル') ?></h2>

            <!-- <h2 class="feature2">フチ加工や裏面加工など、<span class="red">オプション加工</span>の種類も豊富です</h2> -->
            <h3 class="dsd"><span class="orange2">デザインサンプル</span>で、<span class="red2">簡単に</span>、<span class="red2">短時間</span>で欲しかったデザインが出来上がり。お客様は変更点をご指示するだけ。複数<span class="red2">デザイン案無料</span>！何度でも<span class="red2">修正無料</span>！</h3>
            <span class="new-text" style="font-size: 13.6px;"><?= lang('デザインサンプルとは、当店ワッペン専任デザイナーが、多くのお客様の利用シーンを想定し、事前に作成させて頂いたデザイン案の集合体です。') ?></span>
            <span class="new-text" style="font-size: 13.6px;"><?= lang('カッコイイ、格調高いデザイン案を予めお客様にご提示することで、皆様は複雑なデザイン作成をする事なく、簡単に、短時間で欲しかったワッペンのデザイン作成を終わらせる事ができます。') ?></span><br><br>
            <span class="new-text" style="font-size: 13.6px;"><?= lang('デザイン案は何度でも、無料で修正可能。チームや都市名の変更はもちとん、例えば下記タイガーのデザインをイルカに変更して欲しい、') ?></span>
            <span class="new-text" style="font-size: 13.6px;"><?= lang('背景色違いで2案、フォント違いで2案、デザインサンプルを2種を使って2案などお客様のご要望にお応えします。') ?></span><br><br>
            <span class="new-text" style="font-size: 13.6px;"><?= lang('各デザイン案には番号が振られております。デザイン作成依頼の際は、その番号を当店にご連絡ください。') ?></span>
            <div>&nbsp;</div>
            <div class="d-flex toon" style="">
                <?php
                $sql = "SELECT * FROM wappen_category WHERE `status` = 1 ORDER BY id ASC";

                $stmt = mysqli_prepare($conn, $sql);

                // Execute the SQL statement
                mysqli_stmt_execute($stmt);

                // echo $sql;

                $result = mysqli_stmt_get_result($stmt);
                $whole_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

                if (mysqli_num_rows($result) > 0) :
                    foreach ($whole_data as $row) : ?>
                        <div class="flex-item w-31" style="margin-bottom: 14px;">
                            <a href="/products/wappen-template?category=<?= $row["code"] ?>" style="text-decoration:none;">
                                <img class="lazy" data-src="<?php echo $row['pic'] ?>">
                                <div class="plus2"><i class="fas fa-caret-square-right" style="color: red;"></i>&nbsp;&nbsp;<font color="black"><?php echo $row['category_name'] ?></font>
                                </div>
                            </a>
                            <!-- <h3 class="new-text">▲マジックテープ加工</h3> -->
                        </div>
                <?php endforeach;
                endif; ?>

            </div>
            <div style="clear:both;"></div>

            <h2>お役立ち情報</h2>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/blog-content/wappen_sewing"><img src="../blog-content/upload/202406141229095315.png" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/blog-content/wappen_sewing">ミシン初めての営業担当がワッペンを縫製してみました。</a>
                </div>
            </div>
            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/blog-content/wappen_iron"><img src="../blog-content/upload/202410221848558305.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/blog-content/wappen_iron">営業担当がアイロンでワッペンを取り付けてみました</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_embroidery"><img src="/lp/images/wappen/wappen_guide_embroidery01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_embroidery">「御社の顔」になるオリジナル刺繍ワッペン。営業担当が教える、ブランド価値を上げるための仕様選び</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_production"><img src="/lp/images/wappen-guide/wappen_guide_production01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_production">理想のデザインを形にするオリジナルワッペンの作り方｜プロ仕様の製作工程と選び方完全ガイド</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_name"><img src="/lp/images/wappen-name/wappen_guide_name01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_name">ユニフォームにおける「名札」の枠を超えたオリジナルネームワッペンの戦略的価値</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_illustration"><img src="/lp/images/wappen-ai/wappen_guide_illustration01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_illustration">ビジネスに「アート」と「温もり」を実装する。オリジナルイラストワッペンが拓く、感性ブランディングの新時代</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_character"><img src="/lp/images/wappen-character/wappen_guide_character01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_character">愛される「顔」を、持ち歩ける「資産」へ。企業キャラクターをワッペン化すべき戦略的理由</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_iron"><img src="/lp/images/wappen-iron/wappen_guide_iron01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_iron">手軽にプロ仕様！オリジナルワッペンをアイロン接着で作るメリットと完全ガイド</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_seal"><img src="/lp/images/wappen-seal/wappen_guide_seal01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_seal">貼るだけで完成！オリジナルワッペンを高級ステッカー感覚で楽しむ、新しい活用法</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_tape"><img src="/lp/images/wappen-tape/wappen_guide_tape01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_tape">組織を強くする「付け外し」の魔法。法人向け「オリジナルワッペン マジックテープ」活用ガイド</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_photo"><img src="/lp/images/wappen-photo/wappen_guide_photo01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_photo">ビジュアル・インパクトがビジネスを変える。「写真」をそのまま形にするオリジナルワッペンの戦略的活用</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_small_lot"><img src="/lp/images/wappen-iot/wappen_guide_lot01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_small_lot">理想を形にする「オリジナルワッペン 小ロット」製作ガイド：品質とコストを両立させる専門知識</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_oshikatsu"><img src="/lp/images/wappen-opt/wappen_guide11_01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_oshikatsu">絆を深める「推し活」の新定番！50枚から作るオリジナルワッペン完全活用ガイド</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_bigsize"><img src="/lp/images/wappen-size/wappen_guide12_01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_bigsize">背中で語る圧倒的存在感！「オリジナルワッペン 大きいサイズ」完全製作ガイド</a>
                </div>
            </div>

            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/lp/wappen_guide_letter"><img src="/lp/images/wappen-letter/wappen_guide14_01.webp" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/lp/wappen_guide_letter">「オリジナルワッペン」の価値は「文字」で決まる｜企業ブランドを雄弁に語るタイポグラフィとデザイン戦略</a>
                </div>
            </div>

            <?php include("campaign_news.php"); ?>

            <div>&nbsp;</div>

            <h2 class=""><?= lang('オリジナルワッペンの仕様') ?></h2>
            <div class="">
                <table class="table_rubber" style="padding: 0 ;">
                    <tr>
                        <td class="TableLeft"><?= lang('名称') ?></td>
                        <td class=""><?= lang('オリジナルワッペン') ?></td>
                    </tr>
                    <tr>
                        <td class="TableLeft">素材</td>
                        <td class="">〈刺繍・ジャガード〉<br />ツイル生地・フェルト生地<br />〈昇華転写〉<br />ツイル生地・サテン生地</td>
                    </tr>
                    <tr>
                        <td class="TableLeft"><?= lang('サイズ') ?></td>
                        <td class=""><a href="images/flight_tag/wappen_patch_size.webp?v=1.00" data-lightbox="0" data-title="" style="text-decoration:none;">縦の長さと横の長さの合計が30㎝以内</a></td>
                    </tr>
                    <tr>
                        <td class="TableLeft">製造方法</td>
                        <td class="">刺繍・ジャガード織・昇華転写</td>
                    </tr>
                    <tr>
                        <td class="TableLeft">生地色</td>
                        <td class="">刺繍の場合、表・裏それぞれ22色からお選びください。</td>
                    </tr>
                    <tr>
                        <td class="TableLeft">フチ加工</td>
                        <!-- <td class="">〈刺繍・ジャガード〉<br />オーバーロック仕上げ・ヒートカット仕上げ<br />〈昇華転写〉<br />オーバーロック仕上げ・レーザーカット仕上げ</td> -->
                        <td>オーバーロック仕上げ・レーザーカット仕上げ</td>
                    </tr>
                    <tr>
                        <td class="TableLeft">裏面加工</td>
                        <td class="">マジックテープ加工・アイロンテープ・接着シール・クレジット印字・加工なし</td>
                    </tr>
                    <tr>
                        <td class="TableLeft">包装</td>
                        <td class="">一括包装・個別OPP包装</td>
                    </tr>
                    <tr>
                        <td class="TableLeft">最小ロット</td>
                        <td class="">50枚</td>
                    </tr>
                    <tr>
                        <td class="TableLeft">試作品</td>
                        <td class="">5,500円（税込）但し、300個以上ご注文の場合は無料になります。</td>
                    </tr>
                    <tr>
                        <td class="TableLeft">本生産納期</td>
                        <td class="">
                            刺繍タイプ : 最短7営業日後出荷 <br>
                            ジャガード織タイプ : 最短7営業日後出荷 <br>
                            昇華転写タイプ : 最短5営業日後出荷
                        </td>
                    </tr>
                    <tr>
                        <td class="TableLeft">単価</td>
                        <td class="">94円（税込）～</td>
                    </tr>
                </table>
            </div>
            <div>&nbsp;</div>

            <h2 id="est-content"><?= lang('ご注文・見積書作成') ?></h2>

            <?php include('campaign_banner.php') ?>

            <span style="font-size: 12px;">※<?= lang('一つのデザインにつき一注文となります。複数のデザインがある場合、それぞれのデザインで別々にご注文ください。') ?></span>
            <div style="overflow: unset!important;">
                <div class="fixed-contrainer">
                    <h3 class="red">【<?= lang('オリジナルワッペン') ?>】</h3>
                    <span class="total-price"><span class="prd_total">0</span>円<?= lang('（税込）') ?></span>
                </div>
                <div style="clear: both;"></div>
                <div class="step-container line1" style="padding: 5px;border: 1px solid lightgray;margin-bottom: 5px;">
                    <div class="step-box">
                        <table class="table_rubber" style="padding: 0">
                            <tr>
                                <td><?= lang('ご注文タイプ') ?></td>
                                <td><span id="sample-prd-prdt"></span></td>
                            </tr>
                            <tr>
                                <td><?= lang('仕様タイプ') ?></td>
                                <td><span id="sample-prd-type"></span></td>
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
                                <td><?= lang('OPP個別包装') ?></td>
                                <td><span id="sample-prd-opp"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="step-box line2" style="text-align: center;">
                        <!-- <img src="/products/images/HM_part1-2.jpg" width="135" height="135" id="sample-part-pic" class="picpro"> -->
                    </div>
                    <div class="step-box line2" style="text-align: center;">
                    </div>
                </div>
                <div class="step-container">
                    <div class="step-box step-list">
                        <ul>
                            <li id="dot-step1" class="active">
                                <div class="step-number">1</div><span class="step-details"><?= lang('ご注文タイプ・サイズ・印刷面') ?></span>
                            </li>
                            <li id="dot-step2">
                                <div class="step-number">2</div><span class="step-details"><?= lang('試作品・OPP個別包装') ?></span>
                            </li>
                            <li id="dot-step3">
                                <div class="step-number">3</div><span class="step-details"><?= lang('製品仕様・製作料金') ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
                    <div style="display: table-column;">
                        <input type="hidden" name="ItemType" id="strap" value="オリジナルワッペン・パッチ" />
                        <input type="hidden" id="ms_mode" value="<?php echo (isset($_GET['mode']) ? $_GET['mode'] : "") ?>">
                    </div>
                    <?php
                    switch ($ft_type) {
                        case '刺繍':
                            $ft_type0 = "checked";
                            break;
                        case 'ジャガード織':
                            $ft_type1 = "checked";
                            break;
                        case '昇華転写':
                            $ft_type2 = "checked";
                            break;
                        default:
                            $ft_type0 = "checked";
                            break;
                    }
                    switch ($ft_option) {
                        case 'スタンダード':
                            $ft_option0 = "checked";
                            break;
                        case 'フェルト生地':
                            $ft_option1 = "checked";
                            break;
                        case 'サテン生地':
                            $ft_option2 = "checked";
                            break;
                        case 'エンブクロス':
                            $ft_option3 = "checked";
                            break;
                        default:
                            $ft_option0 = "checked";
                            break;
                    }
                    switch ($ft_process) {
                        case 'スタンダード':
                            $ft_process0 = "checked";
                            break;
                        case 'プレミアム':
                            $ft_process1 = "checked";
                            break;
                        default:
                            $ft_process0 = "checked";
                            break;
                    }
                    //Setup sample data
                    switch ($ft_sample) {
                        case 'あり':
                            $sample = "checked";
                            break;
                    }
                    //Setup sample data
                    switch ($ft_trace) {
                        case 'あり':
                            $trace = "checked";
                            break;
                    }
                    //Setup trace data
                    switch ($ft_opp) {
                        case 'あり':
                            $opp = "checked";
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
                        <h3 class="new-text">以前のご注文と同じデザインでの製作ですか？</h3>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="いいえ" onclick="$('.repeat').hide();" <?= $RepeatSelected_1 ?>>いいえ <span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="ItemDesignRepeat" value="はい" onclick="$('.repeat').show();" <?= $RepeatSelected_2 ?>>はい<span class="checkmark"></span></label>
                            </div>
                        </div>

                        <div class="repeat" style="<?= $RepeatStyle_2 ?>">
                            <h3 class="new-text">前回ご注文の管理番号等がもしおわかりでしたら、ご入力ください。</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="text" name="design_no" value="<?= $design_no ?>">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h3 class="new-text"><?= lang('サイズ（縦・横合計）') ?></h3>
                        <div class="part-container">
                            <div class="part-content prd-selection">
                                <label class="part-name ">
                                    <select name="ft_size" onchange="check_val('next')">
                                        <option value="5" <?= ($ft_size == "5" ? 'selected' : '') ?>>5cm</option>
                                        <option value="6" <?= ($ft_size == "6" ? 'selected' : '') ?>>6cm</option>
                                        <option value="7" <?= ($ft_size == "7" ? 'selected' : '') ?>>7cm</option>
                                        <option value="8" <?= ($ft_size == "8" ? 'selected' : '') ?>>8cm</option>
                                        <option value="9" <?= ($ft_size == "9" ? 'selected' : '') ?>>9cm</option>
                                        <option value="10" <?= ($ft_size == "10" ? 'selected' : '') ?>>10cm</option>
                                        <option value="11" <?= ($ft_size == "11" ? 'selected' : '') ?>>11cm</option>
                                        <option value="12" <?= ($ft_size == "12" ? 'selected' : '') ?>>12cm</option>
                                        <option value="13" <?= ($ft_size == "13" ? 'selected' : '') ?>>13cm</option>
                                        <option value="14" <?= ($ft_size == "14" ? 'selected' : '') ?>>14cm</option>
                                        <option value="15" <?= ($ft_size == "15" ? 'selected' : '') ?>>15cm</option>
                                        <option value="16" <?= ($ft_size == "16" ? 'selected' : '') ?>>16cm</option>
                                        <option value="17" <?= ($ft_size == "17" ? 'selected' : '') ?>>17cm</option>
                                        <option value="18" <?= ($ft_size == "18" ? 'selected' : '') ?>>18cm</option>
                                        <option value="19" <?= ($ft_size == "19" ? 'selected' : '') ?>>19cm</option>
                                        <option value="20" <?= ($ft_size == "20" ? 'selected' : '') ?>>20cm</option>
                                        <option value="21" <?= ($ft_size == "21" ? 'selected' : '') ?>>21cm</option>
                                        <option value="22" <?= ($ft_size == "22" ? 'selected' : '') ?>>22cm</option>
                                        <option value="23" <?= ($ft_size == "23" ? 'selected' : '') ?>>23cm</option>
                                        <option value="24" <?= ($ft_size == "24" ? 'selected' : '') ?>>24cm</option>
                                        <option value="25" <?= ($ft_size == "25" ? 'selected' : '') ?>>25cm</option>
                                        <option value="26" <?= ($ft_size == "26" ? 'selected' : '') ?>>26cm</option>
                                        <option value="27" <?= ($ft_size == "27" ? 'selected' : '') ?>>27cm</option>
                                        <option value="28" <?= ($ft_size == "28" ? 'selected' : '') ?>>28cm</option>
                                        <option value="29" <?= ($ft_size == "29" ? 'selected' : '') ?>>29cm</option>
                                        <option value="30" <?= ($ft_size == "30" ? 'selected' : '') ?>>30cm</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <img src="images/wappen/wappen-size-banner.webp?v=1.01" class="col-md-6" style="display:block;">

                        <h3 class="new-text"><?= lang('仕様タイプ') ?></h3>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name">
                                    <input type="radio" name="ft_type" value="刺繍" onclick="check_val('next')" <?= $ft_type0 ?>><?= lang('刺繍') ?>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="part-content">
                                <label class="part-name">
                                    <input type="radio" name="ft_type" value="ジャガード織" onclick="check_val('next')" <?= $ft_type1 ?>><?= lang('ジャガード織') ?>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="part-content">
                                <label class="part-name">
                                    <input type="radio" name="ft_type" value="昇華転写" onclick="check_val('next')" <?= $ft_type2 ?>><?= lang('昇華転写') ?>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>


                        <h3 class="new-text"><?= lang('生地') ?></h3><a class="btn-details inline" href="javascript:void(0)" for="modal-1" style="cursor: pointer;" onclick="$('#modal-1').prop('checked',true)">詳細</a>
                        <input class="modal-state" id="modal-1" type="checkbox">
                        <div class="modal">
                            <label class="modal__bg" for="modal-1"></label>
                            <div class="modal__inner modal1" style="height: max-content!important;">
                                <label class="modal__close" for="modal-1"></label>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <h4 style="font-size: 19px;">ツイル生地</h4>
                                <p style="font-size: 16px;">さまざまな布製品に広く使われている、最も一般的なタイプの生地です。斜めの畝（うね）状に見える織り目が特徴です。</p>
                                <div>&nbsp;</div>
                                <h4 style="font-size: 19px;">フェルト生地</h4>
                                <p style="font-size: 16px;">ふんわりとした風合いや温かみが特徴の生地です。子ども向けデザインにとくによく使われる生地です。</p>
                                <div>&nbsp;</div>
                                <h4 style="font-size: 19px;">サテン生地</h4>
                                <p style="font-size: 16px;">なめらかな表面が特徴の生地です。光沢もあり、高級感も出ます。</p>
                                <div>&nbsp;</div>
                                <h4 style="font-size: 19px;">エンブクロス</h4>
                                <p style="font-size: 16px;">表面が刺繍面のようになっている生地です。光沢もあり、サテン生地とは違った高級感が出ます。</p>
                                <div>&nbsp;</div>
                            </div>
                        </div>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="ft_option" value="ツイル生地" onclick="check_val('next')" <?= $ft_option0 ?>><?= lang('ツイル生地') ?> <span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="ft_option" value="フェルト生地" onclick="check_val('next')" <?= $ft_option1 ?>><?= lang('フェルト生地') ?> <span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="ft_option" value="サテン生地" onclick="check_val('next')" <?= $ft_option2 ?>><?= lang('サテン生地') ?> <span class="checkmark"></span></label>
                            </div>
                            <!-- <div class="part-content">
                                <label class="part-name"><input type="radio" name="ft_option" value="エンブクロス" onclick="check_val('next')" <?= $ft_option3 ?>><?= lang('エンブクロス') ?> <span class="checkmark"></span></label>
                            </div> -->
                        </div>

                        <div class="only_embro">
                            <h3 class="new-text">生地色　表（ジャガード織・昇華転写は生地色の考え方がありません）</h3>
                            <div class="part-content preview-container">
                                <div class="preview-sub flex-container strap-color">
                                    <div class="normal_c">
                                        <div class="show_c">
                                            <img src="" id="img-show-Insatsu1" class="d-none"><br />
                                            <span id="txt-show-Insatsu1"></span>
                                        </div>
                                        <div class="choose_c">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="radio" id="0" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T184（赤色）' : '108（赤色）') ?>" <?= ($ft_fabric_color1 == '108（赤色）' || $ft_fabric_color1 == 'T184（赤色）' ? 'checked' : ($ft_fabric_color1 == '' ? 'checked' : '')) ?>>
                                                            <label for="0"><img src="images/flight_tag/icon-01.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="1" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T223（緑色）' : '63（緑）') ?>" <?= ($ft_fabric_color1 == '63（緑）' || $ft_fabric_color1 == 'T223（緑色）' ? 'checked' : "") ?>>
                                                            <label for="1"><img src="images/flight_tag/icon-02.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="2" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T47（紺藍）' : '83（紺藍）') ?>" <?= ($ft_fabric_color1 == '83（紺藍）' || $ft_fabric_color1 == 'T47（紺藍）' ? 'checked' : "") ?>>
                                                            <label for="2"><img src="images/flight_tag/icon-03.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="3" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T244（紅赤）' : '76（紅赤）') ?>" <?= ($ft_fabric_color1 == 'T244（紅赤）' || $ft_fabric_color1 == 'T244（紅赤）' ? 'checked' : "") ?>>
                                                            <label for="3"><img src="images/flight_tag/icon-04.webp"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="radio" id="4" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T142（オレンジ色）' : '30（オレンジ色）') ?>" <?= ($ft_fabric_color1 == '30（オレンジ色）' || $ft_fabric_color1 == 'T142（オレンジ色）'   ? 'checked' : "") ?>>
                                                            <label for="4"><img src="images/flight_tag/icon-05.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="5" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T95（えんじ）' : '131（えんじ）') ?>" <?= ($ft_fabric_color1 == '131（えんじ）' || $ft_fabric_color1 == 'T95（えんじ）' ? 'checked' : "") ?>>
                                                            <label for="5"><img src="images/flight_tag/icon-06.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="6" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T202（藤紫）' : '78（藤紫）') ?>" <?= ($ft_fabric_color1 == '78（藤紫）' || $ft_fabric_color1 == 'T202（藤紫）' ? 'checked' : "") ?>>
                                                            <label for="6"><img src="images/flight_tag/icon-07.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="7" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T258（紫色）' : '74（紫色）') ?>" <?= ($ft_fabric_color1 == '74（紫色）' || $ft_fabric_color1 == 'T258（紫色）' ? 'checked' : "") ?>>
                                                            <label for="7"><img src="images/flight_tag/icon-08.webp"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="radio" id="8" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T214（山吹色）' : '135（山吹色）') ?>" <?= ($ft_fabric_color1 == '135（山吹色）' || $ft_fabric_color1 == 'T214（山吹色）' ? 'checked' : "") ?>>
                                                            <label for="8"><img src="images/flight_tag/icon-09.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="9" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T54（黄色）' : '32（黄色）') ?>" <?= ($ft_fabric_color1 == '32（黄色）' || $ft_fabric_color1 == 'T54（黄色）' ? 'checked' : "") ?>>
                                                            <label for="9"><img src="images/flight_tag/icon-10.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="10" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T122（ピンク）' : '9（ピンク）') ?>" <?= ($ft_fabric_color1 == '9（ピンク）' || $ft_fabric_color1 == 'T122（ピンク）' ? 'checked' : "") ?>>
                                                            <label for="10"><img src="images/flight_tag/icon-11.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="11" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T219（茶色）' : '94（茶色）') ?>" <?= ($ft_fabric_color1 == '94（茶色）' || $ft_fabric_color1 == 'T219（茶色）' ? 'checked' : "") ?>>
                                                            <label for="11"><img src="images/flight_tag/icon-12.webp"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="radio" id="12" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T24（黄緑色）' : '35（黄緑色）') ?>" <?= ($ft_fabric_color1 == '35（黄緑色）' || $ft_fabric_color1 == 'T24（黄緑色）' ? 'checked' : "") ?>>
                                                            <label for="12"><img src="images/flight_tag/icon-13.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="13" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T218（ビリジアン）' : '66（ビリジアン）') ?>" <?= ($ft_fabric_color1 == '66（ビリジアン）' || $ft_fabric_color1 == 'T218（ビリジアン）' ? 'checked' : "") ?>>
                                                            <label for="13"><img src="images/flight_tag/icon-14.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="14" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T32（スカイブルー）' : '46（スカイブルー）') ?>" <?= ($ft_fabric_color1 == '46（スカイブルー）' || $ft_fabric_color1 == 'T32（スカイブルー）' ? 'checked' : "") ?>>
                                                            <label for="14"><img src="images/flight_tag/icon-15.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="15" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T37（青色）' : '52（青色）') ?>" <?= ($ft_fabric_color1 == '52（青色）' || $ft_fabric_color1 == 'T37（青色）' ? 'checked' : "") ?>>
                                                            <label for="15"><img src="images/flight_tag/icon-16.webp"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="radio" id="16" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T198（牡丹色）' : '12（牡丹色）') ?>" <?= ($ft_fabric_color1 == '12（牡丹色）' || $ft_fabric_color1 == 'T198（牡丹色）' ? 'checked' : "") ?>>
                                                            <label for="16"><img src="images/flight_tag/icon-17.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="17" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T256（灰色）' : '129（灰色）') ?>" <?= ($ft_fabric_color1 == '129（灰色）' || $ft_fabric_color1 == 'T256（灰色）' ? 'checked' : "") ?>>
                                                            <label for="17"><img src="images/flight_tag/icon-18.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="18" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? '1.2mmBLACA（黒色）' : '123（黒色）') ?>" <?= ($ft_fabric_color1 == '123（黒色）' || $ft_fabric_color1 == '1.2mmBLACA（黒色）' ? 'checked' : "") ?>>
                                                            <label for="18"><img src="images/flight_tag/icon-19.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="19" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T01B（白）' : '1（白）') ?>" <?= ($ft_fabric_color1 == '1（白）' || $ft_fabric_color1 == 'T01B（白）' ? 'checked' : "") ?>>
                                                            <label for="19"><img src="images/flight_tag/icon-20.webp"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="radio" id="20" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T199（ネイビー）' : '88（ネイビー）') ?>" <?= ($ft_fabric_color1 == '88（ネイビー）' || $ft_fabric_color1 == 'T199（ネイビー）' ? 'checked' : "") ?>>
                                                            <label for="20"><img src="images/flight_tag/icon-21.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="21" class="STD_printing_color1" name="ft_fabric_color1" value="<?= ($ft_option == "フェルト生地" ? 'T108（ダークブルー）' : '126（ダークブルー）') ?>" <?= ($ft_fabric_color1 == '126（ダークブルー）' || $ft_fabric_color1 == 'T108（ダークブルー）' ? 'checked' : "") ?>>
                                                            <label for="21"><img src="images/flight_tag/icon-22.webp"></label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="pantone" class="STD_printing_color1" name="ft_fabric_color1" value="PANTONE/DIC指定" <?= ($ft_fabric_color1 == 'PANTONE/DIC指定' ? 'checked' : "") ?>>
                                                            <label for="pantone">
                                                                <div>PANTONE/<br />DIC指定</div>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="color-variation-container">
                            <h3 class="new-text"><?= lang('使用する使用する糸色の数（昇華転写に糸色数は関係ありません）糸色の数') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name" id="label-qty"><input type="number" name="color_variation" max="8" style="text-align: right;" onblur="check_val('next');(this.value.trim()==0 || this.value.trim()==''?this.value = '1':'')" value="<?= ($color_variation == "" || $color_variation == "0" ? 1 : $color_variation) ?>"></label>
                                </div>
                            </div>
                        </div>

                        <h3 class="new-text"><?= lang('フチ加工') ?></h3>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name"><input type="radio" name="ft_process" value="オーバーロック仕上げ" onclick="check_val('next')" <?= $ft_process0 ?>><?= lang('オーバーロック仕上げ') ?>【＋@55円（税込）】 <span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <!-- <label class="part-name"><input type="radio" name="ft_process" value="ヒートカット仕上げ" onclick="check_val('next')" <?= $ft_process1 ?>>レーザーカット仕上げ【追加料金なし】<span class="checkmark"></span></label> -->
                                <label class="part-name"><input type="radio" name="ft_process" value="レーザーカット仕上げ" onclick="check_val('next')" <?= $ft_process1 ?>>レーザーカット仕上げ【追加料金なし】<span class="checkmark"></span></label>
                            </div>
                        </div>

                        <h3 class="new-text"><?= lang('裏面加工') ?></h3>
                        <div class="part-container">
                            <div class="part-content prd-selection">
                                <label class="part-name ">
                                    <select id="ft_backside_type" name="ft_backside_type" onchange="check_val('next')">
                                        <option value="加工なし" <?= ($ft_backside_type == "加工なし" ? 'selected' : '') ?>>加工なし【追加料金なし】</option>
                                        <option value="マジックテープ" <?= ($ft_backside_type == "マジックテープ" ? 'selected' : '') ?>>マジックテープ【＋@55円（税込）】</option>
                                        <option value="アイロンテープ" <?= ($ft_backside_type == "アイロンテープ" ? 'selected' : '') ?>>アイロンテープ【＋@11円（税込）】</option>
                                        <option value="接着シール" <?= ($ft_backside_type == "接着シール" ? 'selected' : '') ?>>接着シール【＋@55円（税込）】</option>
                                        <option value="クレジット印字" <?= ($ft_backside_type == "クレジット印字" ? 'selected' : '') ?>>クレジット印字【＋@55円（税込）】</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <h3 class="new-text"><?= lang('数量') ?></h3>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name" id="label-qty"><?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;<input type="number" name="qty" style="text-align: right;" id="qty" onblur="check_val('next')" value="<?= $qty ?>"></label>
                                <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="estimate-content" id="step2">
                        <h3 class="new-text"><?= lang('試作品・データトレース・OPP個別包装') ?></h3>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name">
                                    <div class="switch_off_button b2 switch_off">
                                        <input type='hidden' value='なし' name='ft_sample'>
                                        <input type="checkbox" class="checkbox" name="ft_sample" value="あり" onclick="check_val('next');" <?= $sample ?>>
                                        <div class="knobs">
                                            <span></span>
                                        </div>
                                        <div class="layer"></div>
                                    </div><span>試作品【300個以下ご注文の場合、5500円（税込）】</span>
                                </label>
                                <div class="error" id="sample-error"></div>
                            </div>
                            <div class="part-content">
                                <label class="part-name">
                                    <div class="switch_off_button b2 switch_off">
                                        <input type='hidden' value='なし' name='ft_trace'>
                                        <input type="checkbox" class="checkbox" name="ft_trace" value="あり" onclick="check_val('next');" <?= $trace ?>>
                                        <div class="knobs">
                                            <span></span>
                                        </div>
                                        <div class="layer"></div>
                                    </div>データトレース【2,200円（税込）】
                                </label>
                                <div class="error" id="sample-error"></div>
                            </div>
                            <div class="part-content">
                                <label class="part-name">
                                    <div class="switch_off_button b2 switch_off">
                                        <input type='hidden' value='なし' name='ft_opp'>
                                        <input type="checkbox" class="checkbox" name="ft_opp" value="あり" onclick="check_val('next');" <?= $opp ?>>
                                        <div class="knobs">
                                            <span></span>
                                        </div>
                                        <div class="layer"></div>
                                    </div>OPP個別包装【＋@8円（税込）】
                                </label>
                            </div>
                        </div>

                        <h3 class="template_free"><?= lang('デザインサンプル番号（ご利用の場合のみ）') ?></h3>
                        <div class="part-container template_free">
                            <div class="part-content">
                                <label class="part-name" id="template_code"><input type="text" name="template_code" style="text-align: right;" id="template_code" value="<?= $template_code ?>" onblur="get_more_templates();check_val('next');"></label>
                            </div>
                        </div>
                        <div class="template_free flex-container paper-container">
                            <div class="preview-container">
                                <div class="preview-sub flex-container" id="paper-preview">
                                </div>
                            </div>
                        </div>

                        <h3 class="new-text"><?= lang('ご注文製品の当店WEBサイトへの掲載・ご連絡事項') ?></h3>
                        <div class="part-container">
                            <div class="part-content">
                                <label class="part-name p-normal"><input type="radio" name="keisai" value="製作実績の掲載を許可する" onclick="check_val('next')" <?= ($keisai == "製作実績の掲載を許可する" ? 'checked' : ($keisai == "" ? 'checked' : '')) ?>><?= lang('製作実績の掲載を許可する') ?>【5,500円（税込）の割引が適用されます。】<span class="checkmark"></span></label>
                            </div>
                            <div class="part-content">
                                <label class="part-name p-normal"><input type="radio" name="keisai" value="製作実績の掲載を許可しない" onclick="check_val('next')" <?= ($keisai == "製作実績の掲載を許可しない" ? 'checked' : '') ?>><?= lang('製作実績の掲載を許可しない') ?> <span class="checkmark"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="estimate-content flex-item" id="step3">
                        <div class="flex-container">
                            <div class="flex-item">
                                <h3 class="new-text"><?= lang('製品仕様') ?></h3>
                                <table class="table_rubber">
                                    <tbody>
                                        <tr>
                                            <td class="TableLeft"><?= lang('注文製品タイプ') ?></td>
                                            <td class="" id="prd_production" style="text-align: left;"></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('サイズ（縦・横合計）') ?></td>
                                            <td class="" id="prd_size" style="text-align: left;"></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('仕様タイプ') ?></td>
                                            <td class="" id="prd_type" style="text-align: left;"></td>
                                        </tr>
                                        <tr class="only_embro">
                                            <td class="TableLeft"><?= lang('生地') ?></td>
                                            <td class="" id="prd_material" style="text-align: left;"></td>
                                        </tr>
                                        <tr class="only_embro">
                                            <td class="TableLeft"><?= lang('生地色　表') ?></td>
                                            <td class="" id="prd_fabric_color1" style="text-align: left;"></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('使用する糸色の数') ?></td>
                                            <td class="" id="prd_color_variation" style="text-align: left;"></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('フチ加工') ?></td>
                                            <td class="" id="prd_processing" style="text-align: left;"></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('数量') ?></td>
                                            <td class="" id="prd_amount" style="text-align: left;"></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('裏面加工') ?></td>
                                            <td class="" id="prd_backside" style="text-align: left;"><?= lang('デザインあり') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('試作品') ?></td>
                                            <td class="" id="prd_sample" style="text-align: left;"><?= lang('なし') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('データトレース') ?></td>
                                            <td class="" id="prd_trace" style="text-align: left;"><?= lang('なし') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('OPP個別包装') ?></td>
                                            <td class="" id="prd_opp" style="text-align: left;"><?= lang('なし') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('WEB掲載') ?></td>
                                            <td class="" id="prd_web" style="text-align: left;"></td>
                                        </tr>
                                        <tr class="template_free">
                                            <td class="TableLeft"><?= lang('デザインサンプル番号') ?></td>
                                            <td style="text-align: left;"><span id="sample-prd-temp"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex-item">
                                <h3 class="new-text"><?= lang('製作料金') ?></h3>
                                <table class="table_rubber total_price_tbl">
                                    <tbody>
                                        <tr>
                                            <td class="TableLeft"><?= lang('商品代金') ?></td>
                                            <td class=""><input id="prd_price" type="text" name="prd_price" readonly>円</td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('版型料金') ?></td>
                                            <td class=""><input id="prd_mold_price" type="text" name="prd_mold_price" readonly>円</td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('フチ加工') ?></td>
                                            <td class=""><input id="prd_process_price" type="text" name="prd_process_price" readonly>円</td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('試作品') ?></td>
                                            <td class=""><input id="prd_sample_price" type="text" name="prd_sample_price" readonly>円</td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('データトレース') ?></td>
                                            <td class=""><input id="prd_trace_price" type="text" name="prd_trace_price" readonly>円</td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('糸色料金') ?></td>
                                            <td class=""><input id="prd_color_price" type="text" name="prd_color_price" readonly>円</td>
                                        </tr>
                                        <tr>
                                            <td class="TableLeft"><?= lang('裏面加工') ?></td>
                                            <td class=""><input id="prd_backside_price" type="text" name="prd_backside_price" readonly>円</td>
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
                                    <td colspan="2" style="background: none;border: none;">
                                        <div class="flex-container btn-container">
                                            <input type="button" class="btn clr-btn flex-item" value="CLEAR" id="" onclick="setzero();valid_chk_btn('step1');">
                                            <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step1');$('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                                            <a href="javascript:void(0)" class="btn btn-back" onclick="valid_chk_btn('step2');$('#cus_detail').hide();"><?= lang('オプション修正') ?></a>
                                            <input type="button" class="btn est-btn flex-item" value="見積書" id="button_pdf2" onclick="$('#cus_detail').toggle();">
                                            <input type="button" class="btn ord-btn flex-item" value="ご注文情報入力へ" onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form);">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="acrylic-btn" class="btn-container">
                        <a href="javascript:void(0)" id="back" class="btn btn-back" onclick="valid_chk_btn('back')"><?= lang('戻る') ?></a>
                        <a href="javascript:void(0)" id="next" class="btn btn-next" onclick="valid_chk_btn('next')"><?= lang('オプション入力へ') ?></a>
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
                                <td class="TableLeft"><?= lang('郵便番号') ?> </td>
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
            <hr>
            <a href="/contact/?sndKBN=1&item=オリジナルワッペン"><img src="images/wappen/banner_wappen2.webp"></a>
            <h2 class="toggle-header"><?= lang('オリジナルワッペンに関するFAQ') ?><span>+</span></h2>
            <div class="toggle-container">
                <p class="text-orange">1. データ作成方法について教えてください。</p>
                <p class="new-text">お客様ご自身でデータを作成される場合には、テンプレートをご使用ください。もしくは、イメージのデザインデータを弊社へメール送付いただきましたら、デザイン図を作成いたします（有料）。contact@hotmobily.jp 例えば、名刺しかない、昔作った実物しかない、お店の看板の写真しかない場合でも、そのデータを元に製作できる場合がほとんどです。</p>
                <div>&nbsp;</div>
                <p class="text-orange">2. 昇華転写（フルカラー）印刷もできますか？</p>
                <p class="new-text">大変恐れ入りますが、現在は刺繍とジャガード織のみ承っております。</p>
                <div>&nbsp;</div>
                <p class="text-orange">3. 注文方法、決済方法を教えてください。</p>
                <p class="new-text">決済方法は、銀行振込とクレジットカード決済からお選びいただけます。詳しくは<a href="/guide/payment">こちら</a>をご覧ください。</p>
                <div>&nbsp;</div>
                <p class="text-orange">4. 注文内容のキャンセルや変更はできますか？</p>
                <p class="new-text">【キャンセルについて】</p>
                <p class="new-text">ご注文確定前でしたら、ご注文の取消（キャンセル）が可能です。ご入金が完了している場合、かかった費用を差し引いて、ご指定の銀行口座にご返金致します。ご注文確定後かつ量産開始前の場合は、キャンセル料がかかります。ご注文確定後かつ量産開始後は、誠に申し訳ございませんが、ご注文の取消（キャンセル）をお受けできません。</p>
                <p class="new-text">【変更について】</p>
                <p class="new-text">ご注文確定後でも、量産開始前でしたらご注文内容の変更が可能です。変更内容により、変更に必要な期間、費用が異なります。量産開始後は、誠に申し訳ございませんが、ご注文の変更をお受けできません。詳しくは<a href="/guide/cancel_return">こちら</a>をご覧ください。</p>
                <div>&nbsp;</div>
                <p class="text-orange">5. 量産前に、試作品を確認することはできますか？</p>
                <p class="new-text">はい、可能です。試作品は現在、期間限定で無料で承っております。ご注文画面にて「試作品あり」をご選択ください。</p>
                <div>&nbsp;</div>
                <p class="text-orange">6. 仕様に記載のサイズ以外のサイズも製作できますか？</p>
                <p class="new-text">指定サイズ範囲外をご希望の場合は、弊社の営業担当までご相談ください。</p>
                <div>&nbsp;</div>
            </div>

            <?php include('flight_tag_blog.php'); ?>

        </div>
        <!-- :: content_wrapper end :: -->
    </div>
    <!-- :: wrapper end :: -->

    <!--フッター ここから-->
    <?php include('../footer.php'); ?>
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
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.20"></script>
    <script language="JavaScript" src="<?= $cal_wappen_js_2025 ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?= $pdf_wappen_js ?>"></script>
    <script type="text/javascript" src="/products/js/date.js"></script>
    <script type="text/javascript" src="/js/common.js?v=1.02"></script>
    <script type="text/javascript" src="/products/js/jquery.ez-plus.js?v=1.01"></script>
    <script src="/products/acrylic/ptw/photoswipe.min.js?v=1.08"></script>
    <script src="/products/acrylic/ptw/photoswipe-ui-default.min.js"></script>
    <!-- <script src="js/cloth_calendar.js"></script> -->
    <script type="text/javascript">
        $.ajax({
            type: "POST",
            url: "/products/check_holiday.php",
            data: {
                "product": "7days"
            },
            success: function(data) {

                // console.log(data);
                productionDate(data.sort());
            },
            dataType: "json"
        });

        $.ajax({
            type: "POST",
            url: "/products/check_holiday.php",
            data: {
                "product": "6days"
            },
            success: function(data) {

                // console.log(data);
                productionDate5Days(data.sort());
            },
            dataType: "json"
        });

        $.ajax({
            type: "POST",
            url: "/products/check_holiday.php",
            data: {
                "product": "6days"
            },
            success: function(data) {
                // console.log('2');
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
        }, (tmp != "" ? valid_chk_btn('step3') : ""));

        $("input[name='ft_type']:checked").trigger("change");

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

        $("h2.toggle-header, h2.toggle-header span").click(function() {
            // Slide toggle the next .toggle-container
            $(this).next(".toggle-container").slideToggle();

            // Change the text of the span inside the clicked h2
            var span = $(this).find("span");
            if (span.text() === "+") {
                span.text("-");
            } else {
                span.text("+");
            }
        });
        // ft_type on change
        // $(document).on("change", "input[name=ft_type]", function() {
        //   var ft_type = $("input[name=ft_type]:checked").val();
        //   var template_selected = "<?= $template_selected ?>";
        //   var showed_arr = [];

        //   if (ft_type == "ジャガード織") {
        //     $.ajax({
        //       type: "GET",
        //       url: "/products/get-wappen-data.php",
        //       data: {
        //         id: template_selected,
        //       },
        //       success: function(data) {
        //         console.log(data);
        //         $(data).each(function(index, value) {
        //           $('#paper-preview').append('<div class="flex-item">' +
        //             '<label class="part-name"><input type="radio" name="template_selected" onclick="setToInput()" value="' + value.wappen_code + '"><img src="https://hotmobily.jp/wappen-template/' + value.wappen_image + '" width="154px">' + value.wappen_code + '</label>' +
        //             '</div>');
        //           // Keep value.wappen_code to array
        //           showed_arr.push(value.wappen_code);
        //         });
        //         showed_template = showed_arr.join(',');
        //         $('#showed_templates').val(showed_template);
        //       },
        //       dataType: "json"
        //     });
        //   }
        // });

        function get_more_templates() {
            // var showed_template = $('#showed_templates').val();
            var template_selected = $('input[name=template_code]').val();
            // var showed_arr = [];
            $.ajax({
                type: "GET",
                url: "/products/get-wappen-data2.php",
                data: {
                    id: template_selected,
                    // more: showed_template,
                },
                success: function(data) {
                    console.log(data);
                    if (data.length != 0) {
                        $('#paper-preview').html('');
                        $(data).each(function(index, value) {
                            $('#paper-preview').append('<div class="flex-item">' +
                                '<label class="part-name"><a href="https://hotmobily.jp/wappen-template/' + value.wappen_image + '" data-lightbox="template_image" data-title="" style="text-decoration:none;"><img src="https://hotmobily.jp/wappen-template/' + value.wappen_image + '" width="154px"></a>' + value.wappen_code + '</label>' +
                                '</div>');
                            // Keep value.wappen_code to array
                            // showed_arr.push(value.wappen_code);
                        });
                        // showed_arr to string and combine showed_template with showed_arr
                        // showed_template += ',' + showed_arr.join(',');
                        // $('#showed_templates').val(showed_template);
                    } else {
                        // alert data not found
                        alert('テンプレートが見つかりませんでした。');
                        $('#paper-preview').html('');
                        $('input[name=template_code]').val('');
                    }
                },
                dataType: "json"
            });
        }

        function showTab(tabIndex) {
            const tabs = document.querySelectorAll('.tab');
            const panels = document.querySelectorAll('.tab-panel');

            tabs.forEach((tab, index) => {
                tab.classList.toggle('active', tabIndex === index + 1);
                panels[index].style.display = tabIndex === index + 1 ? 'block' : 'none';
            });
        }
    </script>
</body>

</html>