<?php
header('Cache-Control: public, max-age=300'); // 5 minutes
header('Content-Type: text/html; charset=UTF-8');
if (extension_loaded('zlib') && !ob_get_level()) {
    ob_start('ob_gzhandler');
}
ini_set("session.bug_compat_warn", 0);
//Start Session
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//Read Modules
require_once('../../control/Control_Rubber.php');
include_once('../../common/Const.php');
include_once('../../common/SetUpLang.php');
include_once('../const_js.php');
include("../../connect_db/Control_Connect.php");


// GETリクエストを取得
// $msMode = $_GET['mode'];
$msMode = "";
if (isset($_GET['mode'])) {
    $msMode = $_GET['mode'];
}
$btn_flg = false;

// パラメータを取得
if ($msMode == "MODE_MOD") {
    $mrFormData = $_SESSION;
    foreach ($mrFormData as $k => $v) {
        $$k = $v;
        $_POST["$k"] = $_SESSION["$v"];
    }
    $_SESSION['btn_flg'] = false;
} else if ($msMode == "CANCEL") {
    $btn_flg = $_POST['btn_flg'];
    $_POST[] = array();

    session_unset();
    session_destroy();
    $link = gsCnv2Form($_SERVER['SERVER_PHP_SELF']);
} else if ($msMode === "MODE_RESET") {
    session_unset();
    session_destroy();
} else {
    $mrFormData = $_POST;
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


$data1 = mysqli_query($conn, "SELECT COUNT(id) AS totalreview FROM reviews_hm") or die(mysqli_error());
$info1 = mysqli_fetch_assoc($data1);

$data2 = mysqli_query($conn, "SELECT AVG(service) AS avg_service, AVG(product) AS avg_product FROM reviews_hm") or die(mysqli_error());
$info2 = mysqli_fetch_assoc($data2);

// 1. Define or retrieve your dynamic product variables here
// *************************************************************
// REPLACE these placeholder values with your actual PHP variables
// that hold the product data from your database or CMS.
// *************************************************************
$product_name = "【ホットモバイリー】オリジナルラバーストラップ";
$product_description = "オリジナル形状のラバーストラップをオーダーメイドで製作。最短7営業日で出荷可能なプランや、少数（10個）向けプランあり。";
$product_image_url = "https://hotmobily.jp/gallery/img-rub/2023-rubberstrap-gallery/4.webp";
$product_sku = "HM-RS-2024";
$product_price = 126;
$product_currency = "JPY";
$product_availability = "InStock";
$product_url = "https://hotmobily.jp/products/rubberstrap/";

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
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="オリジナル,印刷ラバーコースター,印刷ラバーコースター,製作,1個,最安,最短,短納期,イラスト,写真,ロゴ,飲食店,バー">
    <meta name="description"
        content="オリジナル印刷ラバーコースター製作！1個から製作可能、業界最安・最短納期！UV印刷でロゴ・店名・イラスト・写真をあざやかに表現。形状は標準形状から選ぶ簡単注文も、こだわりのオリジナル形状での注文も可能。ラバーコースターならホットモバイリー">
    <meta name="robots" content="index,follow" />
    <title>オリジナル印刷ラバーコースター製作！1個から注文可|フルカラー</title>
    <link rel="canonical" href="https://hotmobily.jp/products/rubberstrap/">
    <link rel="preload" type="text/css" href="https://hotstrap.jp/css/homepage.css?v=1.15" as="style"
        onload="this.rel='stylesheet'">
    <link href="/products/css/box.css" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/css/modal.css?v=1.01" rel="preload" type="text/css" as="style" onload="this.rel='stylesheet'" />
    <link href="/products/css/calendar.css?v=2" rel="preload" type="text/css" as="style"
        onload="this.rel='stylesheet'" />
    <?php include("../../head_products.html"); ?>
    <link rel="stylesheet" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <link href="/products/css/product_group.css?v=1.14" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163" as="style"
        onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="stylesheet" type="text/css" href="../css/scroll.css">
    <link href="/css/rubber.css?v=1.06" rel="stylesheet" type="text/css" />
    <style type="text/css">
        <?= ($_SESSION['lang'] == "kr" ? '#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}' : '') ?>
        <?= ($_SESSION['lang'] == "th" ? '#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}' : '') ?>
    </style>
    <noscript>
        <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
        <link href="/products/acrylic/css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
        <link href="/products/acrylic/css/acrylic.css?v=1.05" rel="stylesheet" type="text/css">
    </noscript>
    <script language="JavaScript" type="text/javascript">
    </script>
    <script type="text/javascript" src="/js/lazyload.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#open1").click(function () {
                $("#slide1").slideToggle("slow");
            });
        });
    </script>
    <style>
        .lpc,.new-text{letter-spacing:.05em!important}.prod-sched-wrapper,.prod-sched-wrapper *{box-sizing:border-box}table,table.prod-sched-table{border-collapse:collapse;width:99%}.pdp-v2-thumb-grid,.thumbnails{grid-template-columns:repeat(2,1fr)}body{font-family:IwaUDGoDspPro-Th,sans-serif!important}:root{--pdp-v2-accent:#ff477e;--pdp-v2-slide-speed:0.6s}.new-text{font-size:16px!important;line-height:150%!important}.container{max-width:100%;margin:0 auto;display:flex;gap:15px;background:#fff}.h1-new{color:#000!important;background:unset!important;margin-bottom:5px!important;text-align:center!important;font-size:22px!important}#est-order,.box-purple,.btnz,.group-container .btn-select,.link-text,.modal-content,.row .mt-10-part-4,.text-center,td{text-align:center}#est-order{font-size:25px;color:#000}.new-topic{color:#eb8018;font-size:19px}.text-orange{color:#000}.group-container{display:flex;justify-content:space-between;flex-flow:row wrap;margin:10px 0}.action-buttons,.social-sns,table.cld_tb{margin-top:10px}.group-container .btn-select{width:calc(24% - 10px);border:1px solid #9e9e9e;margin-bottom:10px;padding:10px 5px;cursor:pointer;border-radius:3px;transition-duration:.3s;position:relative}.btn-select input[type=radio]{opacity:0;width:0}.group-container .btn-select.active,.group-container .btn-select:hover{border:1px solid #fff;background:#f7b516;color:#fff}.group-container .btn-select.active .top-noted,.group-container .btn-select:hover .top-noted{background:#fff;border:2px solid #1e6077;color:#1e6077}.group-container .btn-select:has(input[type=radio]:checked){border:1px solid #fff;background:#f7b516;color:#fff}table.tbl_price_deli.loading:not(.for_fans) tbody td:not(:first-child){background:linear-gradient(to right,#eee 20%,#ddd 50%,#eee 80%);background-size:500px 100px;animation-name:moving-gradient;animation-duration:1s;animation-iteration-count:infinite;animation-timing-function:linear;animation-fill-mode:forwards}.product-gallery{flex:1;display:flex;flex-direction:column;gap:15px}.main-image img{width:100%;border-radius:8px;cursor:zoom-in}.thumbnails{display:grid;gap:10px}.thumbnails img{width:100%;border-radius:4px;cursor:pointer;opacity:.6;transition:opacity .3s}.thumbnails img.active,.thumbnails img:hover{opacity:1;border:1px solid #eb8018}.action-buttons{display:flex;flex-direction:column;gap:10px}.btnz{padding:15px;border:none;color:#fff;font-weight:700;cursor:pointer;border-radius:4px}.btn-orange{background-color:#cc3f44;font-size:16px}.btn-dark-orange{background-color:#e67e22;font-size:16px}.link-text{color:#333;text-decoration:underline;font-size:.9rem}.product-details{flex:1}.price-box{background:#efefef;padding:5px;margin-bottom:2px}.price-box p{font-size:20px}.promo-title{color:#f59420;font-size:1.2rem;margin-bottom:15px;letter-spacing:.05em}.info-card,.info-card h3,table{margin-bottom:10px}.text-left{text-align:left}#table_rubber,.prod-sched-label{text-align:left!important}.info-card h3{font-size:1rem;padding-left:10px}.info-card img{width:100%;border-radius:4px}.modal-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.8);display:none;justify-content:center;align-items:center;z-index:1000}.modal-overlay:target,.social-sns{display:flex}.modal-content{background:#fff;padding:20px;position:relative;max-width:90%;max-height:90%}.close-btn{position:absolute;top:-40px;right:0;color:#fff;font-size:30px;text-decoration:none}.fw-bold{font-family:IwaUDGoDspPro-Bd,sans-serif!important;font-weight:700}.social-sns{flex-direction:row;justify-content:end;gap:5px;margin-bottom:20px}.accordion-container{max-width:100%;margin:0 auto;background-color:#fff;border-bottom:1px solid #e5e5e5}.accordion-input{display:none}.accordion-header{display:flex;justify-content:flex-start;align-items:center;padding:15px;background-color:#fff;cursor:pointer;font-weight:700;font-size:1.2rem;position:relative;transition:background .3s}.arrow-dove,.icon{position:absolute}.icon{right:20px;width:20px;height:20px}.icon::after,.icon::before{content:'';position:absolute;background-color:#000;transition:transform .3s}.icon::before{width:100%;height:2px;top:50%;left:0;transform:translateY(-50%)}.icon::after{width:2px;height:100%;left:50%;top:0;transform:translateX(-50%)}.accordion-content{max-height:0;overflow:hidden;transition:max-height .5s cubic-bezier(0, 1, 0, 1),padding .3s;padding:0 10px}.tab-menu,.table-wrapper{overflow-x:auto}.accordion-input:checked~.accordion-content{max-height:3000px;padding:20px 10px 10px}.accordion-input:checked~.accordion-header .icon::after{transform:translateX(-50%) rotate(90deg);max-height:0;opacity:0}.arrow-dove{flex-shrink:0;width:10px;height:10px;border-right:2px solid #333;border-bottom:2px solid #333;transform:rotate(45deg);transition:transform .3s;right:20px}.accordion-input:checked~.accordion-header .arrow-dove{transform:rotate(-135deg)}.plan-section,.prod-sched-section{margin-bottom:20px}.plan-section h3{font-size:1.1rem;margin-bottom:15px;color:#333}#date_create_sample1,#date_create_sample2,#date_create_speed_1,#date_create_speed_2{font-size:22px;font-weight:700;color:red;letter-spacing:-1px;overflow:hidden}.box-purple{color:#a428a5;background:#ff93ff;border-radius:6px;font-size:18px;padding:8px 10px;margin-right:10px;min-width:215px;height:unset}.d-inline{display:inline-block;margin-top:13px}.bg-purple th:first-child{background:#ff93ff;color:#9e009f}.btn-a.btn-orange,.btn-a.btn-yellow{width:80%;background-color:#f79647}th{background-color:#d1e3f0;padding:10px}td{padding:12px 10px}.note{color:#000;line-height:1.5;font-size:11.5px!important}.prod-sched-wrapper{color:#000;max-width:800px;margin:0 auto;background:#fff}.prod-sched-title{margin:0 0 10px;padding-left:10px;color:#000}.prod-sched-subtitle{color:#666;font-weight:400}.prod-sched-scroll-box{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}table.prod-sched-table{font-size:.95rem;min-width:500px;margin:0}.prod-sched-table td,.prod-sched-table th{border:1px solid #ccc;padding:10px 12px;text-align:center;vertical-align:middle}.prod-sched-table thead th{background-color:#f4f4f4;font-weight:700;color:#444}.prod-sched-label{background-color:#fdfdfd;font-weight:500;width:35%;min-width:180px}.prod-sched-table tbody tr:hover{background-color:#f9f9f9}.prod-sched-info-box h3{font-size:1rem;margin:0 0 10px;color:#222;font-weight:700}.prod-sched-list{list-style-type:disc;padding-left:20px;margin:0}.prod-sched-list li{margin-bottom:5px}.prod-sched-list strong{color:#d32f2f}.prod-sched-info-box small{color:#777;font-size:.85em}.tab-container{width:100%;max-width:1200px;margin:auto}.tab-menu{display:flex;border-bottom:1px solid #ddd}.tab-link{flex:1;padding:15px 20px;border:none;background:#faf7f5;cursor:pointer;font-weight:700;color:#e67e22;white-space:nowrap;border-right:1px solid #ddd}.tab-link.active{background:#fff;border-top:4px solid #e67e22;border-left:1px solid;border-right:1px solid;color:#e67e22;border-bottom:1px solid #fff;margin-bottom:-1px}.tab-content{display:none;padding:10px 0 0!important;border:none!important;border-top:none;background:#fff!important;font-family:IwaUDGoDspPro-Th,sans-serif!important}.tab-content.active{display:block;max-height:2000px}.grid-layout{display:flex;flex-wrap:wrap;gap:20px}.itemz{flex:1 1 calc(33.333% - 20px);min-width:250px}.itemz img{width:100%;height:auto;border-radius:4px}.row .mt-10-part-4{min-width:25%;max-width:25%}.product-d_feature_title{font-size:16px;display:block;width:100%;border-bottom:1px solid #d2d2d2;padding:0 0 15px!important;margin:20px 0 30px!important;color:#f58904}.pdp-v2-gallery-wrapper{width:100%;max-width:500px;background:#fff;position:relative}.pdp-v2-main-viewport{width:100%;overflow:hidden;position:relative;background-color:#fcfcfc}#A,#C,#D,.pdp-v2-main-link{position:relative}.pdp-v2-image-strip{display:flex;width:100%;transition:transform var(--pdp-v2-slide-speed) cubic-bezier(.4, 0, .2, 1)}.pdp-v2-main-link::after,.pdp-v2-zoom-icon{position:absolute;background-color:rgba(0,0,0,.4);transition:opacity .3s;pointer-events:none}.pdp-v2-zoom-icon{top:50%;left:50%;transform:translate(-50%,-50%);width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;opacity:0;z-index:2}.pdp-v2-zoom-icon svg{width:32px;height:32px;color:#fff}.pdp-v2-main-link:hover .pdp-v2-zoom-icon,.pdp-v2-main-link:hover::after{opacity:1}.pdp-v2-thumb-grid{display:grid;gap:8px;padding:10px 0;background:#fff}.pdp-v2-thumb-item{width:100%;border-radius:6px;cursor:pointer;object-fit:cover;border:2px solid #f0f0f0;transition:.3s;opacity:.6}.pdp-v2-modal-content,.pdp-v2-modal-overlay{transition:opacity var(--pdp-v2-fade-speed) ease-in-out;width:100%}.pdp-v2-thumb-item.pdp-v2-active-state{border-color:#e67e22;opacity:1;transform:scale(.98)}.pdp-v2-main-link{min-width:100%;display:block;cursor:pointer}.pdp-v2-main-link::after{content:'';top:0;left:0;width:100%;height:100%;opacity:0;z-index:1}.pdp-v2-slide-img{min-width:100%;width:100%;height:auto;display:block}.pdp-v2-modal-overlay{display:none;position:fixed;z-index:9999;left:0;top:0;height:100%;background-color:rgba(0,0,0,.9);align-items:center;justify-content:center;opacity:0}.pdp-v2-modal-overlay.active{display:flex;opacity:1}.pdp-v2-modal-container{position:relative;max-width:90%;max-height:90vh;display:flex;align-items:center;justify-content:center}.pdp-v2-modal-content{display:block;height:auto;max-height:90vh;object-fit:contain;box-shadow:0 5px 30px rgba(0,0,0,.5);opacity:1}.pdp-v2-modal-overlay.active .pdp-v2-modal-content{transform:scale(1)}.pdp-v2-modal-close{position:absolute;bottom:-40px;right:0;color:#f1f1f1;font-size:40px;font-weight:700;cursor:pointer;line-height:1}.pdp-v2-modal-next{position:absolute;top:50%;right:10px;transform:translateY(-50%);width:45px;height:45px;display:flex;align-items:center;justify-content:center;color:#fff;cursor:pointer;z-index:10001;opacity:0;transition:.3s;filter:drop-shadow(0px 0px 8px rgba(0, 0, 0, 1))}.pdp-v2-modal-next svg{width:100%;height:100%;stroke-width:1.5}.pdp-v2-modal-overlay:hover .pdp-v2-modal-next{opacity:.8}.pdp-v2-modal-next:hover{opacity:1;transform:translateY(-50%) scale(1.1)}.thumbnail-track{display:flex;transition:transform .5s ease-in-out;gap:10px}.thumbnail-track img{width:80px;height:auto;cursor:pointer;flex-shrink:0}a{text-decoration:underline!important}.fw-style{font-size:18px}#B,#C .PC-C-Contents,#D .Mb-D-Contents,.Mb-A-Contents,.Mb-B-Contents{filter:blur(10px);opacity:0;transition:filter 1.5s ease-out,opacity 1.5s ease-out}.qty-inp,.sub-col{width:25%}.poster-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;max-width:1000px;margin:auto}.poster-item{background:#fff;border-radius:unset;overflow:hidden;transition:transform .3s}.poster-item img{width:100%;height:auto;display:block}.poster-caption{padding:10px;font-size:14px;color:#555}.main-col{width:100%;display:flex;flex-direction:row;gap:10px;align-items:center;margin-top:10px}.img-cxol{width:100%}.prod-container{color:#333;max-width:900px;padding:0 15px}.prod-section-title{font-size:1.1rem;margin:30px 0 15px;font-weight:700}.prod-table-wrapper{width:100%;overflow-x:auto}.prod-table-ui{width:99%;border-collapse:collapse;background-color:#fff;min-width:500px;color:#000}.prod-table-ui td,.prod-table-ui th{border:1px solid #ccc;padding:12px 15px;text-align:center}.prod-table-ui thead th{background-color:#f8f9fa;font-weight:700;font-size:.95rem}.prod-table-ui td.prod-label{text-align:center;font-weight:500;width:45%}.prod-sub{font-size:.85rem;font-weight:400}.prod-table-ui tbody tr:hover{background-color:#fdfdfd}@media (max-width:768px){.container,.tab-menu{flex-direction:column}.product-details,.product-gallery,.qty-inp,.tbl_price_tg p{width:100%}.accordion-header,.prod-sched-title,.prod-section-title{font-size:1rem}td,th{padding:8px 5px;font-size:.8rem}.tbl_price_tg{display:grid}.tbl_price_tg div{display:flex;justify-content:center;flex-wrap:wrap;flex-direction:row;align-items:center;align-content:center}.prod-sched-wrapper{padding:10px}table.prod-sched-table{font-size:.85rem}.prod-sched-table td,.prod-sched-table th{padding:8px}.tab-link{border-right:none;border-bottom:1px solid #ddd;text-align:left}.itemz{flex:1 1 100%}.pdp-v2-modal-next{right:5px;width:35px;height:35px}.pdp-v2-modal-close{bottom:-45px}.pdp-v2-thumb-grid,.thumbnails{grid-template-columns:repeat(3,1fr)}.poster-grid{grid-template-columns:repeat(2,1fr)}.sub-col{width:50%}.prod-table-ui td,.prod-table-ui th{padding:10px 8px;font-size:.9rem}}.but3{padding:8px 0;border:1px solid #b5b5b5;box-shadow:0 2px 6px #b5b5b5;border-radius:5px;background-image:linear-gradient(#f7f7f7,#dbdbdb);transition:.3s ease-in-out}#A{margin-top:0;display:block;opacity:1}
    </style>

    <!-- lightbox2-master -->
    <link rel="stylesheet" href="css/lightbox.css">
    <!-- /lightbox2-master -->
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
        <div id="content_wrapper" class="scrollingPanel">
            <?php include("../rubber_info.php"); ?>
            <?php include('../banner-campaign.php') ?>
            <div id="">
                <h1 class="h1-new">オリジナル印刷ラバーコースター（2026年版）</h1>
                <div class="social-sns">
                    <p>シェアする</p>
                    <a href="//x.com/GoodsYe" target="_blank"><img src="/products/images/rubberstrap/v2/x-icon.webp"
                            alt="" width="20px"></a>
                    <a href="//www.facebook.com/Hotmobily_jp-%E3%83%9B%E3%83%83%E3%83%88%E3%83%A2%E3%83%90%E3%82%A4%E3%83%AA%E3%83%BC-171871399585893"
                        target="_blank"><img src="/products/images/rubberstrap/v2/Facebook-icon.webp" alt=""
                            width="20px"></a>
                    <a href="https://www.instagram.com/hot.mobily/?hl=ja" target="_blank"><img
                            src="/products/images/rubberstrap/v2/IG_icon.webp" alt="" width="20px"></a>
                    <p>更新日：2026年1月30日</p>
                </div>
            </div>
            <div class="container">
                <div class="product-gallery" id="">

                    <div class="pdp-v2-main-viewport">
                        <div class="pdp-v2-image-strip" id="pdp-v2-js-strip">
                        </div>
                    </div>

                    <div class="pdp-v2-thumb-grid" id="pdp-v2-js-grid-pc">
                    </div>

                    <!-- <div class="action-buttons">
                        <button class="btnz btn-orange" type="button" onclick="GotoDiv(1)">この商品を見積・注文する</button>
                        <a href="/gallery/rubberstrap" class="new-text" style="color:black !important;">制作事例を見る</a>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="link-text new-text" onclick="GotoDiv(5)"
                            style="color: black;">商品レビューを見る</a>
                    </div> -->
                    <div class="action-buttons">
                        <button class="btnz btn-orange" type="button" onclick="GotoDiv(1)">この商品を見積・注文する</button>
                    </div>

                </div>

                <div class="product-details" id="">
                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">参考単価：</span>1個451円（1個注文時）</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">100個合計金額：</span>100個合計金額：30,400円</p>
                    </div>

                    <div class="price-box">
                        <p class="lpc"><span class="text-orange">出荷目安（通常納期）：</span><span class=""
                                id="date_create2x1"></span></p>
                    </div>

                    <div class=">
                        <small class="note">※出荷目安は本日原稿が確定した場合の日付です。</small><br>
                        <small class="note">※出荷目安は注文個数やプランによって異なります。詳しくは<a href="javascript:void(0)" class=""
                                onclick="GotoDiv(2)">こちら</a>をご確認ください。</small>
                    </div>

                    <h2 class="promo-title" style="color: #cc3f44; !important;">
                        業界最速・最安！1個から製作可能な自社生産の印刷ラバーコースター</h2>

                    <div class="info-card">
                        <h3 class="lpc fw-bold">たった1個から製作可能！自宅用にも◎</h3>
                        <img src="/products/printedrubbercoaster/images/v2/printed_coaster_banner01.webp" alt=""
                            loading="lazy">
                        <p class="new-text">最小ロット1個。お店用だけでなく、自宅用や友人へのプレゼントとしても気軽に製作できます。</p><br>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(77)"
                                style="color: black;">納期と料金の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc fw-bold">色のグラデーションを表現できる！</h3>
                        <img src="/products/printedrubbercoaster/images/v2/printed_coaster_banner02.webp" alt=""
                            loading="lazy">
                        <p class="new-text">一般的なラバーコースターではできないカラーグラデーションが、印刷ラバーコースターなら表現可能！</p><br>
                        <div style="text-align:right;">
                            <a href="javascript:void(0)" class="new-text" onclick="GotoDiv(99)"
                                style="color: black;">印刷の詳細</a>
                        </div>
                    </div>

                    <div class="info-card">
                        <h3 class="lpc fw-bold">汚れ防止オプションあり！</h3>
                        <img src="/products/printedrubbercoaster/images/v2/printed_coaster_banner03.webp" alt=""
                            loading="lazy">
                        <p class="new-text">うっかりコースターを汚してしまっても安心な汚れ防止加工オプションをご用意。</p><br>
                        <div style="text-align:right;">
                            <a href="https://hotmobily.jp/faq/details/rubberstrap/q4" class="new-text"
                                style="color: black;">汚れ防止加工の詳細</a>
                        </div>
                    </div>

                </div>
            </div>

            <!--Accordion Shape-->
            <div id="acc-shape">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="shape-toggle" class="accordion-input" checked>
                        <label for="shape-toggle" class="accordion-header" id="shape-g">
                            <span class="fw-bold">選べる形状</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">当店ご用意の標準形状2種（丸、四角）からご希望の形状をお選び頂けます。</p>
                                <br>
                                <p class="new-text">
                                    形状に独自のこだわりがある方には、お客様ご指定のオリジナル形状でご製作することも可能です。オリジナル形状の場合は、最小ロット100個となります。</p>
                                <br>
                                <div>
                                    <div class="poster-grid">
                                        <div class="poster-item">
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this)"
                                                    src="/products/printedrubbercoaster/images/v2/printed_coaster_07.webp"
                                                    alt="Poster 1" />
                                                <!-- <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="poster-item">

                                            <img loading="lazy" onclick="openSimpleModal(this)"
                                                src="/products/printedrubbercoaster/images/v2/printed_coaster_08.webp"
                                                alt="Poster 2" />
                                            <!-- <div class="camera-left" style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">📷<?= lang('クリックすると拡大します') ?>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="prod-sched-scroll-box">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Shape-->

            <!--Accordion Color-->
            <div id="acc-color">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="color-toggle" class="accordion-input" checked>
                        <label for="color-toggle" class="accordion-header" id="color-g">
                            <span class="fw-bold">選べるカラー</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">
                                    全9色の印刷ラバーコースター用の本体色をご用意しております。お選び頂いた色のラバー本体の表面に、お客様のデザインを印刷するかたちになります。</p>
                                <br>
                                <div class="main-col">
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">赤</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_rednew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">ピンク</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_pinknew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">オレンジ</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_orangenew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">黄色</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_yellownew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                </div>
                                <div class="main-col">
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">青</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_bluenew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">緑</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_greennew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">黒</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_blacknew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">白</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_whitenew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>
                                </div>
                                <div class="main-col">
                                    <div class="sub-col">
                                        <div class="text-center">
                                            <p class="new-text">グレー</p>
                                        </div>
                                        <img loading="lazy" onclick="openSimpleModal(this)"
                                            src="/products/printedrubbercoaster/images/v2/printedcoaster_graynew.webp"
                                            alt="" class="img-cxol">
                                        <div class="camera-left"
                                            style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                            📷<?= lang('クリックすると拡大します') ?></div>
                                    </div>

                                    <div class="sub-col">
                                    </div>

                                    <div class="sub-col">
                                    </div>

                                    <div class="sub-col">
                                    </div>

                                </div>
                                <br>
                                <p class="new-text">※モニター上で見える色は実物とは違って見えることがございます。色にこだわりのある方には、色見本のお取り寄せをおすすめしております。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Color-->

            <!--Accordion Print Type-->
            <div id="acc-print_type">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="print_type-toggle" class="accordion-input" checked>
                        <label for="print_type-toggle" class="accordion-header" id="print_type-g">
                            <span class="fw-bold">通常印刷と全面印刷</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">印刷ラバーコースターにデザインを印刷する範囲は、通常印刷と全面印刷の2種類があります。</p>
                                <br>
                                <p class="new-text">
                                    通常印刷は、デザインの印刷範囲の端とラバー本体の端の間に2mmのスペースを空けます。一方で、全面印刷は、印刷範囲の端とラバー本体の端の隙間がわずか0.5mmになります。ぱっと見ただけでは、印刷デザインとラバー本体の端に隙間があることに気づかない方も多いでしょう。
                                </p>
                                <br>
                                <div>
                                    <div class="poster-grid">
                                        <div class="poster-item">
                                            <div style="text-align: center;">
                                                <p class="new-text">通常印刷</p>
                                            </div>
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this)"
                                                    src="/products/printedrubbercoaster/images/v2/printed_coaster_09.webp"
                                                    alt="Poster 1" />
                                                <div class="camera-left"
                                                    style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                    📷<?= lang('クリックすると拡大します') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="poster-item">
                                            <div style="text-align: center;">
                                                <p class="new-text">全面印刷</p>
                                            </div>
                                            <img loading="lazy" onclick="openSimpleModal(this)"
                                                src="/products/printedrubbercoaster/images/v2/printed_coaster_10.webp"
                                                alt="Poster 2" />
                                            <div class="camera-left"
                                                style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                📷<?= lang('クリックすると拡大します') ?>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="new-text">端まで印刷の注意点</p>
                                    <p class="new-text">
                                        デザインの印刷範囲の端とラバー本体の端の間に一切余白を設けない印刷も可能ではありますが、製造の際に印刷用インクがラバーストラップ・ラバーキーホルダーの側面に付着するおそれがございます。あらかじめご了承頂けますようお願い申し上げます。余白なしでの製作をご希望の場合は、注文フォームの連絡事項の欄にてお知らせください。
                                    </p>
                                    <br>
                                    <div>
                                        <img src="/products/printedrubbercoaster/images/v2/printed_sidenew02.webp"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Print Type-->

            <!--Accordion Shipping-->
            <div id="acc-shipping">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="shipping-toggle" class="accordion-input" checked>
                        <label for="shipping-toggle" class="accordion-header">
                            <span class="fw-bold">制作料金と納期について</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">制作料金と納期は、お選び頂いた形状・出荷コース・注文数量・汚れ防止加工の有無によって異なります。</p>
                                <br>
                                <p class="new-text">通常納期（10営業日後出荷）コース</p>
                                <br>
                                <div class="prod-sched-scroll-box">
                                    <table class="prod-sched-table">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">数量</th>
                                                <th class="fw-bold">1</th>
                                                <th class="fw-bold">10</th>
                                                <th class="fw-bold">30</th>
                                                <th class="fw-bold">50</th>
                                                <th class="fw-bold">100</th>
                                                <th class="fw-bold">300</th>
                                                <th class="fw-bold">500</th>
                                                <th class="fw-bold">1000</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold"><strong>価格</strong></td>
                                                <td>¥451<br><span>@¥451</span></td>
                                                <td>¥3,460<br><span>@¥346</span></td>
                                                <td>¥9,900<br><span>@¥330</span></td>
                                                <td>¥15,850<br><span>@¥317</span></td>
                                                <td>¥25,000<br><span>@¥304</span></td>
                                                <td>¥76,800<br><span>@¥256</span></td>
                                                <td>¥120,000<br><span>@¥240</span></td>
                                                <td>¥216,000<br><span>@¥216</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>

                                <div>
                                    <?php $unit = [1, 10, 30, 50, 100, 300, 500, 1000]; ?>

                                    <div class="tbl_s cl2" style="position: relative;">
                                        <div class="scroll-center">
                                            <div class="arrow"></div>
                                        </div>
                                        <table class="tbl_price_deli loading">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="4">スタンダード</th>
                                                </tr>
                                                <tr>
                                                    <th rowspan="2">数量</th>
                                                    <th colspan="2">当店からの出荷日目安</th>
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
                                                <?php foreach ($unit as $key => $value) { ?>
                                                    <tr>
                                                        <td><?= $value ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>

                                    <div>
                                        <div style="display: flex">
                                            <div class="delivery">
                                                <span class="btn-a std-btn"><?= lang('通常納期'); ?></span>
                                            </div>
                                            <div class="delivery">
                                                <div class="tb_02" style="color: #006ab1; padding: 2px 5px">
                                                    <?= lang('10営業日後出荷'); ?>
                                                </div>
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

                                    <div class="font_s" style="text-align: left;">
                                        ※<?= lang('注文個数が500個以上の場合、上記よりも出荷にお時間を要するケースがございます。納期については個別にご相談ください。') ?><br>
                                    </div>
                                    <br>

                                    <div>
                                        <p class="newtext">スピード発送（7営業日後出荷）コース</p>
                                        <div class="prod-sched-scroll-box">
                                            <table class="prod-sched-table">
                                                <thead>
                                                    <tr>
                                                        <th class="fw-bold">数量</th>
                                                        <th class="fw-bold">1</th>
                                                        <th class="fw-bold">10</th>
                                                        <th class="fw-bold">30</th>
                                                        <th class="fw-bold">50</th>
                                                        <th class="fw-bold">100</th>
                                                        <th class="fw-bold">300</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold"><strong>価格</strong></td>
                                                        <td>¥502<br><span>@¥502</span></td>
                                                        <td>¥3,840<br><span>@¥384</span></td>
                                                        <td>¥11,010<br><span>@¥367</span></td>
                                                        <td>¥17,600<br><span>@¥352</span></td>
                                                        <td>¥33,800<br><span>@¥338</span></td>
                                                        <td>¥77,400<br><span>@¥258</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="font_s" style="text-align: left;">
                                            ※<?= lang('上記価格は全て税込価格です。') ?><br>
                                            ※<?= lang('最大ロット300個です。') ?>
                                        </div>
                                        <br>

                                        <table class="tbl_price_deli bg-purple">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">スタンダード（スピード発送）</th>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2">数量</th>
                                                    <td colspan="2">当店からの出荷日目安</th>
                                                </tr>
                                                <tr>
                                                    <td>量産のみ</th>
                                                    <td>試作込み最短</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>100</td>
                                                    <td class="speed_deli_date"></td>
                                                    <td class="speed_deli_date2"></td>
                                                </tr>
                                                <tr>
                                                    <td>200</td>
                                                    <td class="speed_deli_date"></td>
                                                    <td class="speed_deli_date2"></td>
                                                </tr>
                                                <tr>
                                                    <td>300</td>
                                                    <td class="speed_deli_date"></td>
                                                    <td class="speed_deli_date2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>

                                    <div>
                                        <div style="margin-top: 13px"></div>
                                        <div style="display: flex">
                                            <div class="delivery"><span class="btn-a"
                                                    style="color: #a428a5;background: #ff93ff;">スピード納期</span></div>
                                            <h2 class="red tb_02" style="padding: 2px 5px!important;margin-top: 0px;">
                                                7営業日後出荷</h2>
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
                                                <td><span id="date_create_speed_1"></span></td>
                                                <td><span id="date_create_speed_2"></span></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <br>
                                    <p class="new-text fw-bold">オリジナル形状について</p>
                                    <p class="new-text">オリジナル形状での製作は金版型を作成する必要があるため、版型代金が別途9,350円（税込）かかります。</p>
                                    <br>
                                    <p class="new-text">
                                        オリジナル形状は、1個からのご製作が難しい代わりに、試作品オプションをご用意しております。料金は8,800円となります。試作品の出荷は原稿確定から6営業日後です。
                                    </p>
                                    <br>

                                    <div>
                                        <div style="margin-top: 13px"></div>
                                        <div style="display: flex">
                                            <div class="delivery"><span class="btn-a"
                                                    style="background: #66fffe; color: #000">試作納期</span></div>
                                            <div class="delivery">
                                                <div class="tb_06" style="color: #004140; padding: 2px 5px">6営業日後出荷
                                                </div>
                                            </div>
                                        </div>
                                        <table class="cld_tb" style="display: table">
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
                                        <span class="font_s" style="float: right; text-align: right">
                                            <span
                                                class="sun new-text">※</span><?= lang('お急ぎの場合、営業担当にご相談下さい。出来る限りお客様のご希望に沿うよう対応させていただきます。'); ?><br />
                                            <span class="sun new-text">※</span><?= lang('営業日には、土日祝日を含みません。'); ?><br />
                                        </span>
                                    </div>
                                    <br>
                                    <br>
                                    <br>

                                    <p class="new-text">各種オプション料金（税込）</p>
                                    <div class="prod-sched-scroll-box">
                                        <table class="prod-sched-table">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">汚れ防止加工</th>
                                                    <th class="" style="background-color:white;">@77円</th>
                                                </tr>
                                                <tr>
                                                    <th class="fw-bold">裏面印刷</th>
                                                    <th class="" style="background-color:white;">@33円</th>
                                                </tr>
                                                <tr>
                                                    <th class="fw-bold">特殊素材</th>
                                                    <th class="" style="background-color:white;">@33円</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <br>
                                    <p class="new-text">汚れ防止加工を付ける場合、加工に日数を要するため、出荷日が上記＋3～5営業日後となります。</p>
                                    <br>
                                    <p class="new-text">
                                        北海道、九州、沖縄は2日。その他地域は1日。（離島等に関しては、別途お問い合わせください。）配送日数は、営業日でなく土日祝も含めた日数となります。</p>
                                    <br>
                                    <div>
                                        <a class="" href="javascript:void(0)" style="color:black;"
                                            onclick="GotoDiv(88)"><span><?= lang('各種オプションの詳細はこちら') ?></span></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Shipping-->

            <!--Accordion Num Days-->
            <div id="acc-num_days">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="num_days-toggle" class="accordion-input" checked>
                        <label for="num_days-toggle" class="accordion-header" id="num_days-g">
                            <span class="fw-bold">製作日数</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">各種条件での製作日数の目安は以下です。</p>
                                <br>
                                <p class="new-text fw-bold">◆スタンダード製作期間 (単位：営業日。配送日数は含まず)</p>
                                <br>
                                <div>
                                    <div class="prod-container">
                                        <div class="prod-table-wrapper">
                                            <table class="prod-table-ui">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>300個以下</th>
                                                        <th>1,000個以下</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="prod-label">量産品製作日数<br /><span
                                                                class="prod-sub">(標準形状)</span></td>
                                                        <td>10</td>
                                                        <td>14</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-label">試作品製作日数<br /><span
                                                                class="prod-sub">(オリジナル形状)</span></td>
                                                        <td>6</td>
                                                        <td>6</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-label">
                                                            量産品製作日数<br /><span class="prod-sub">(オリジナル形状・試作なし)</span>
                                                        </td>
                                                        <td>10</td>
                                                        <td>14</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-label">
                                                            量産品製作日数<br /><span class="prod-sub">(オリジナル形状・試作あり)</span>
                                                        </td>
                                                        <td>16</td>
                                                        <td>20</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <h3 class="prod-section-title">◆スタンダード (スピード発送) 製作期間 (単位: 営業日。配送日数は含まず)</h3>

                                        <div class="prod-table-wrapper">
                                            <table class="prod-table-ui">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>300個以下</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="prod-label">試作品製作日数<br /><span
                                                                class="prod-sub">(オリジナル形状)</span></td>
                                                        <td>6</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-label">
                                                            量産品製作日数<br /><span class="prod-sub">(オリジナル形状・試作あり)</span>
                                                        </td>
                                                        <td>13</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="prod-label">量産品製作日数<br /><span
                                                                class="prod-sub">(形状問わず・試作なし)</span></td>
                                                        <td>7</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Num Days-->

            <!--Accordion Template-->
            <div id="acc-data">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="template-toggle" class="accordion-input" checked>
                        <label for="template-toggle" class="accordion-header">
                            <span class="fw-bold">入稿データについて</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <p class="new-text">
                                        当店の印刷ラバーコースターは、JPEG、PNG、PDFなどのイラスト・写真をご送付頂ければ製作可能です。お送り頂いた画像を元に、当店が無料で入稿データ（AI形式）をご用意いたします。入稿に不安のある方も安心してご利用頂けます。
                                    </p>
                                    <br>
                                    <p class="new-text">
                                        なお、Adobeイラストレーターをお持ちの方であれば、当店のテンプレートデータ（AI形式）をベースに、ご自身で入稿データを作成して頂くことも可能です</p>
                                    <br>
                                    <div
                                        style="display: flex; flex-direction: row; justify-content: center; width: 100%">
                                        <a class="btn-a btn-yellow"
                                            href="/products/printedrubbercoaster/download/printedrubbercoaster-template.zip"
                                            target="_blank" download><span><?= lang('テンプレートダウンロード') ?></span></a>
                                    </div>
                                    <br>
                                    <div style="text-align: right;">
                                        <a href="/lp/rubber-guide-data.php" class="new-text">入稿データの詳細</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Template-->


            <!--Order Form Here-->
            <div id="order-form">
            <?php include('../campaign_banner.php') ?>

                <h2 style="text-align: center; color: black;"><?= lang('ご注文・見積書作成') ?></h2>
                <div style="overflow: unset !important;">
                    <div class="fixed-contrainer">
                        <h3 class="red">【<?= lang('ラバーコースター') ?>】</h3>
                        <span class="total-price"><span class="prd_total">0</span><?= lang('円（税込）') ?></span>
                    </div>
                    <div style="clear: both;"></div>

                    <div class="step-container line1"
                        style="padding: 5px; border: 1px solid lightgray; margin-bottom: 5px;">
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
                                    <td><?= lang('印刷タイプ') ?></td>
                                    <td><span id="sample-prd-print_type">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('本体色') ?></td>
                                    <td><span id="sample-prd-color_tank">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('汚れ防止加工') ?></td>
                                    <td><span id="sample-prd-coating">-</span></td>
                                </tr>
                                <!-- <tr>
                                    <td><?= lang('フチ加工') ?></td>
                                    <td><span id="sample-shape-border">-</span></td>
                                </tr> -->
                                <tr>
                                    <td><?= lang('数量') ?></td>
                                    <td><span id="sample-prd-qty">-</span></td>
                                </tr>
                                <tr>
                                    <td><?= lang('試作品') ?></td>
                                    <td><span id="sample-prd-samp">-</span></td>
                                </tr>
                                <!-- <tr>
                                    <td><?= lang('データトレース') ?></td>
                                    <td><span id="sample-prd-trace">-</span></td>
                                </tr> -->
                            </table>
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <!-- <img class="picpro lazy" data-src="/products/images/HM_part1-2.webp" width="320"
                                height="320" id="sample-part-pic"><br />
                            <span id="sample-part-name"><?= lang('通常松葉（カニカン）') ?></span> -->
                        </div>
                        <div class="step-box line2" style="text-align: center;">
                            <!-- <img class="picpro lazy" data-src="/products/acrylic/img/coming-soon.webp" width="135"
                                height="135" id="sample-paper-pic"><br /> -->
                            <?= lang('台紙') ?>:<span id="sample-paper-name"><?= lang('なし') ?></span>
                        </div>
                    </div>

                    <div class="step-container">
                        <div class="step-box step-list">
                            <ul>
                                <li id="dot-step1" class="active">
                                    <div class="step-number">1</div><span
                                        class="step-details"><?= lang('ご注文タイプ・裏面印刷') ?></span>
                                </li>
                                <li id="dot-step2">
                                    <div class="step-number">2</div><span
                                        class="step-details"><?= lang('アタッチメント・台紙等') ?></span>
                                </li>
                                <li id="dot-step3">
                                    <div class="step-number">3</div><span
                                        class="step-details"><?= lang('製品仕様・製作料金') ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <form action="" method="post" name="form" id="form" enctype="multipart/form-data">
                        <div style="display: table-column;">
                            <input type="text" name="ItemType" id="strap" value="印刷ラバーコースター" />
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
                            case "印刷あり":
                                $printing4_checked = 'checked';
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

                        $shapeSelected_1 = $shapeSelected_2 = $shapeSelected_3 = "";
                        $shapeStyle_1 = $shapeStyle_2 = 'display:none;';
                        switch ($ItemShape) {
                            case "丸型":
                                $shapeSelected_1 = 'checked';
                                $shapeStyle_1 = 'display:block;';
                                $shapeStyle_2 = 'display:none;';
                                break;
                            case "四角型":
                                $shapeSelected_2 = 'checked';
                                $shapeStyle_2 = 'display:block;';
                                $shapeStyle_1 = 'display:none;';
                                break;
                            case "オリジナル":
                                $shapeSelected_3 = 'checked';
                                break;
                            default:
                                if ($msMode != "MODE_MOD") {
                                    $shapeSelected_1 = 'checked';
                                    $shapeStyle_1 = 'display:block;';
                                }
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

                            .shape-options-five {
                                display: flex;
                                flex-wrap: wrap;
                                gap: 12px;
                                width: 100%;
                                box-sizing: border-box;
                            }

                            .shape-options-five * {
                                box-sizing: border-box;
                            }

                            .shape-options-five .move-mb {
                                width: calc(20% - 10px);
                                min-width: 120px;
                            }

                            .shape-options-five .shape-card {
                                width: 100% !important;
                                padding: 15px 5px;
                                margin: 0;
                            }

                            .shape-options-five input[type="radio"] {
                                display: none;
                            }

                            .shape-options-five input[type="radio"]:checked+.shape-card {
                                border-color: #ffffff;
                                background: #f7b516;
                                color: white;
                            }

                            /* ซ่อน radio ดั้งเดิม */
                            .shape-options input[type="radio"],
                            .shape-options-two input[type="radio"] {
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
                            .shape-options input[type="radio"]:checked+.shape-card,
                            .shape-options-two input[type="radio"]:checked+.shape-card {
                                border-color: #ffffff;
                                background: #f7b516;
                                color: white;
                            }

                            @media screen and (min-width: 298px) and (max-width: 331px) {

                                .shape-options,
                                .shape-options-two {
                                    justify-content: flex-start;
                                    gap: 10px;
                                }

                                .shape-card {
                                    width: 150px;
                                }
                            }

                            @media screen and (min-width: 332px) and (max-width: 405px) {

                                .shape-options,
                                .shape-options-two {
                                    justify-content: flex-start;
                                    gap: 10px;
                                }

                                .shape-card {
                                    width: 135px;
                                }
                            }

                            @media screen and (max-width: 991px) {
                                .shape-options-five .move-mb {
                                    width: calc(33.33% - 10px);
                                }
                            }

                            @media screen and (max-width: 480px) {
                                .shape-options-five {
                                    gap: 8px;
                                    padding: 0 5px;
                                }

                                .shape-options-five .move-mb {
                                    width: calc(50% - 6px);
                                    min-width: unset;
                                }

                                .shape-options-five .shape-card {
                                    padding: 10px 5px;
                                }

                                .shape-options-five .shape-card span {
                                    font-size: 13px;
                                }
                            }
                        </style>

                        <div class="estimate-content" id="step1">
                            <h3>以前のご注文と同じデザインでの製作ですか？</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemDesignRepeat" value="いいえ"
                                            onclick="$('.repeat').hide();" <?= $RepeatSelected_1 ?>>いいえ
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemDesignRepeat" value="はい"
                                            onclick="$('.repeat').show();" <?= $RepeatSelected_2 ?>>はい
                                        <span class="checkmark"></span>
                                    </label>
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
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemShape" class="shapeType" id="pcs12" value="丸型"
                                            <?= $shapeSelected_1 ?>>丸型
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemShape" class="shapeType" id="pcs13" value="四角型"
                                            <?= $shapeSelected_2 ?>>四角型
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemShape" class="shapeType" id="pcs14" value="オリジナル"
                                            <?= $shapeSelected_3 ?>>オリジナル
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <span style="color: red" id="error_shape"></span>
                            </div>

                            <!-- New option -->
                            <h3>印刷タイプ</h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemPrint" class="printType" id="pcs2" value="通常印刷"
                                            <?php if ($ItemPrint == "通常印刷")
                                                echo "checked"; ?>>通常印刷
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemPrint" class="printType" id="pcs2" value="全面印刷"
                                            <?php if ($ItemPrint == "全面印刷")
                                                echo "checked"; ?>>全面印刷
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <span style="color: red" id="error_print"></span>
                                <!-- <a href="/lp/rubber-guide-data.php">入稿データ作成の詳細</a> -->
                            </div>
                            <br>

                            <!-- New option -->
                            <h3>本体色</h3>
                            <div class="part-container">
                                <div class="shape-options-five">
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="赤" <?php echo (isset($ItemColor) ? ($ItemColor == "赤" ? "checked" : "") : "checked") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_red.webp"
                                                        alt=""></div>
                                                <span>赤</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="ピンク" <?php echo (isset($ItemColor) ? ($ItemColor == "ピンク" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_pink.webp"
                                                        alt=""></div>
                                                <span>ピンク</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="オレンジ" <?php echo (isset($ItemColor) ? ($ItemColor == "オレンジ" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_orange.webp"
                                                        alt=""></div>
                                                <span>オレンジ</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="黄色" <?php echo (isset($ItemColor) ? ($ItemColor == "黄色" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_yellow.webp"
                                                        alt=""></div>
                                                <span>黄色</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="青" <?php echo (isset($ItemColor) ? ($ItemColor == "青" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_blue.webp"
                                                        alt=""></div>
                                                <span>青</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="緑" <?php echo (isset($ItemColor) ? ($ItemColor == "緑" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_green.webp"
                                                        alt=""></div>
                                                <span>緑</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="黒" <?php echo (isset($ItemColor) ? ($ItemColor == "黒" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_black.webp"
                                                        alt=""></div>
                                                <span>黒</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="白" <?php echo (isset($ItemColor) ? ($ItemColor == "白" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_white.webp"
                                                        alt=""></div>
                                                <span>白</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="color_tank" name="ItemColor" value="グレー" <?php echo (isset($ItemColor) ? ($ItemColor == "グレー" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img
                                                        src="/products/printedrubbercoaster/images/new/rubber_gray.webp"
                                                        alt=""></div>
                                                <span>グレー</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- New option -->
                            <h3><?= lang('ご注文タイプ') ?></h3>
                            <?php include('../../delivery_note.php'); ?>
                            <?php include('../alert-btn.php') ?>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemPCS" id="pcs1" value="スタンダード"
                                            onclick="clearValue();" <?= $lsSelected_1pcs ?>><?= lang('スタンダード') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content" <?= $delivery_disabled ?>>
                                    <label class="part-name">
                                        <input type="radio" name="ItemPCS" id="pcs4" value="スタンダード（スピード7営業日発送）"
                                            onclick="clearValue();" <?= $lsSelected_4pcs ?>><?= lang('スタンダード（スピード7営業日発送）') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <!-- <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemPCS" id="pcs2" value="プレミアム"
                                            onclick="click_typeorder_disabled();clearValue();" <?= $lsSelected_2pcs ?>><?= lang('プレミアム') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div> -->
                                <span style="color: red" id="error_pcs"></span>
                            </div>

                            <h3><?= lang('特殊素材（蓄光／蛍光／ラメ／金色銀色）') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemMaterial" value="特殊素材なし" <?php echo $material0_checked ?> onclick="clearValue();" /><?= lang('特殊素材なし') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="ItemMaterial" value="特殊素材あり" <?php echo $material1_checked ?> onclick="clearValue();" /><?= lang('特殊素材あり') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <h3><?= lang('裏面印刷') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="silk_print" id="nashiprint" value="印刷なし" <?php echo $printing1_checked ?> onclick="clearValue();" /><?= lang('印刷なし') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="silk_print" id="byprint" value="印刷あり" <?php echo $printing4_checked ?> onclick="clearValue();" /><?= lang('印刷あり') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <!-- <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="silk_print" id="ariprint" value="単色（シルク）印刷" <?php echo $printing2_checked ?> onclick="clearValue();" /><?= lang('単色（シルク）印刷') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div> -->
                                <!-- <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="silk_print" id="fcprint" value="フルカラー印刷" <?php echo $printing3_checked ?> onclick="clearValue();" /><?= lang('フルカラー印刷') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div> -->
                                <span style="color: red" id="error_silk_print"></span>
                                <!-- <font color="red">※<?= lang('プレミアムはシルク印刷代金が無料') ?></font> -->
                            </div>

                            <h3><?= lang('汚れ防止加工') ?></h3>
                            <a class="btn-details inline" href="javascript:void(0)" for="modal-2"
                                style="cursor: pointer;" onclick="$('#modal-2').prop('checked',true)">詳細</a>
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
                                    <label class="part-name">
                                        <input type="radio" name="coating" id="coating0" value="汚れ防止加工なし" <?php echo $coating0_checked ?> onclick="clearValue();" /><?= lang('汚れ防止加工なし') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="part-content">
                                    <label class="part-name">
                                        <input type="radio" name="coating" id="coating1" value="汚れ防止加工あり" <?php echo $coating1_checked ?>
                                            onclick="clearValue();" /><?= lang('汚れ防止加工あり (納期+3～5営業日）') ?>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <span style="color: red" id="error_coating"></span>
                            </div>

                            <!-- <h3>フチ加工</h3>
                            <div class="part-container" id="section-shape-processing">
                                <div class="shape-options-two">
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="shape-processing" name="shape_processing"
                                                value="なし" <?php echo (isset($shape_processing) ? ($shape_processing == "なし" ? "checked" : "") : "checked") ?>>
                                            <div class="shape-card">
                                                <div><img src="/products/images/Fuchi_01_edit.webp" alt=""></div>
                                                <span>なし</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="move-mb">
                                        <label>
                                            <input type="radio" class="shape-processing" name="shape_processing"
                                                value="あり" <?php echo (isset($shape_processing) ? ($shape_processing == "あり" ? "checked" : "") : "") ?>>
                                            <div class="shape-card">
                                                <div><img src="/products/images/Fuchi_02_edit.webp" alt=""></div>
                                                <span>あり</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <span style="color: red" id="error_shape_processing"></span>
                            </div> -->

                            <!-- <br>
                            <h3>カラーバリエーション</h3>
                            <a class="btn-details inline" href="javascript:void(0)" for="modal-5"
                                style="cursor: pointer;" onclick="$('#modal-5').prop('checked',true)">詳細</a>
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
                                            <img src="/products/images/HM_design1.webp" width="300" height="300"
                                                style="width: 300px!important;">
                                        </div>
                                        <div class="flex-item">
                                            <img src="/products/images/HM_design2.webp" width="300" height="300"
                                                style="width: 300px!important;">
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
                            <p>1種類カラーバリエーションが増えると、＋3300円（税込）</p> -->
                            <div>&nbsp;</div>

                            <h3><?= lang('ご注文本数') ?></h3>
                            <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name" id="label-qty">
                                        <?= lang('ご注文・御見積数量') ?>&nbsp;&nbsp;
                                        <input type="number" name="numberOf" id="no_of_order" class="right"
                                            onchange="this.value=format_number(this.value);"
                                            value="<?php echo $numberOf ?>" style="text-align: right;"><br />
                                    </label>
                                    <div id="err_numberOf_mess"><?php echo gsGetErrMessage($mrErrMsgList['numberOf']) ?>
                                    </div>
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
                                            <input type="checkbox" class="checkbox" name="paper_select" value="あり"
                                                onclick="check_val('next')" <?= ($paper_select == "あり" ? 'checked' : '') ?>>
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
                                            <input type="checkbox" class="checkbox" name="SendPrototype" value="あり"
                                                id="SampleCheckbox" onclick="setToInput();" <?= $sendActual_checked ?>
                                                disabled>
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('試作品') ?>
                                    </label>
                                </div>

                            </div>
                            <!-- <div class="part-container">
                                <div class="part-content">
                                    <label class="part-name">
                                        <div class="switch_off_button b2 switch_off">
                                            <input type='hidden' value='なし' name='DeFormat'>
                                            <input type="checkbox" class="checkbox" name="DeFormat" value="あり"
                                                onclick="setToInput();" <?= $others_checked ?>>
                                            <div class="knobs">
                                                <span></span>
                                            </div>
                                            <div class="layer"></div>
                                        </div>
                                        <?= lang('データトレース') ?>
                                    </label>
                                </div>
                            </div> -->
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
                                                <td class="TableLeft"><?= lang('印刷タイプ') ?></td>
                                                <td class="" id="prd-print-type" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('本体色') ?></td>
                                                <td class="" id="prd-color-tank" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('裏面印刷') ?></td>
                                                <td class="" id="prd_silk_print" style="text-align: left;"></td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                                                <td class="" id="prd_coating" style="text-align: left;"></td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('フチ加工') ?></td>
                                                <td class="" id="prd_shape_border" style="text-align: left;"></td>
                                            </tr> -->
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
                                                <td class="" id="prd_SendPrototype" style="text-align: left;">
                                                    <?= lang('なし') ?>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('データトレース') ?></td>
                                                <td class="" id="prd_DeFormat" style="text-align: left;">
                                                    <?= lang('なし') ?>
                                                </td>
                                            </tr> -->
                                            <!-- <tr>
                                                <td class="TableLeft"><?= lang('カラーバリエーション') ?></td>
                                                <td class="" id="prd_ItemDesign" style="text-align: left;"></td>
                                            </tr> -->
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
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="StrapPrice" readonly="readonly" id="textfield7"
                                                        class="right" value="<?= $StrapPrice ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('版型代金') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="MoldPrice" readonly="readonly" id="textfield2"
                                                        class="right" value="<?= $MoldPrice ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('裏面印刷代金') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="SilkPrint" readonly="readonly" id="textfield13"
                                                        class="right" value="<?php echo $SilkPrint ?>" />円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('汚れ防止加工') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="coatingPrice" readonly="readonly" id="textfield13_2"
                                                        class="right" value="<?= $coatingPrice ?>">円</td>
                                            </tr>
                                            <tr style="display: none;">
                                                <td class="TableLeft"><?= lang('アタッチメント') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="PartPrice" readonly="readonly" id="textfield7_1"
                                                        class="right" value="<?= $PartPrice ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('台紙') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="PaperPrice" readonly="readonly" id="textfield7_2"
                                                        class="right" value="<?= $PaperPrice ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('試作品') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="ProShipping" readonly="readonly" id="textfield3"
                                                        class="right" value="<?= $ProShipping ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('データトレース') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="TraceCharge" readonly="readonly" id="textfield4"
                                                        class="right" value="<?= $TraceCharge ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('カラーバリエーション') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="DesignsCharge" readonly="readonly" id="DesignsCharge"
                                                        class="right" value="<?= $DesignsCharge ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('特殊素材') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="MaterialCharge" readonly="readonly" id="MaterialCharge"
                                                        class="right" value="<?= $MaterialCharge ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('小計(税込)') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="BeforeTax" readonly="readonly" id="textfield9"
                                                        class="right" value="<?= $BeforeTax ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('お値引き') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="discount" readonly="readonly" id="textfield_dis"
                                                        class="right" value="<?= $discount ?>">円</td>
                                            </tr>
                                            <tr>
                                                <td class="TableLeft"><?= lang('合計(税込)') ?></td>
                                                <td class=""><input style="text-align: right;" type="text" size="16"
                                                        name="grandTotal" readonly="readonly" id="textfield11"
                                                        class="right" value="<?= $grandTotal ?>">円</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <table class="table_rubber total_price_tbl">
                                <tbody>
                                    <tr id="">
                                        <td colspan="2" style="background: unset; border: unset;">
                                            <div class="flex-container btn-container">
                                                <input type="button" class="btn clr-btn flex-item" value="CLEAR" id=""
                                                    onclick="clearValue(); $('#cus_detail').hide(); valid_chk_btn2('step1');" />
                                                <a href="javascript:void(0)" class="btn btn-back"
                                                    onclick="valid_chk_btn2('step1'); $('#cus_detail').hide();"><?= lang('製作条件修正') ?></a>
                                                <a href="javascript:void(0)" class="btn btn-back"
                                                    onclick="valid_chk_btn2('step2'); $('#cus_detail').hide();"><?= lang('オプション修正') ?></a>
                                                <input type="button" class="btn est-btn flex-item" value="見積書"
                                                    id="button_pdf2" onclick="$('#cus_detail').toggle()" />
                                                <input type="button" class="btn ord-btn flex-item"
                                                    value="<?= lang('ご注文情報入力へ') ?>" for="modal-ord"
                                                    onclick="$('#modal-ord').prop('checked',true)" />
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
                                    <diV style="display: grid; justify-items: center;">
                                        <picture>
                                            <source media="(max-width:650px)"
                                                srcset="/img/delivery_10days_notice_mb.jpg" style="width: 100%;">
                                            <img src="/img/delivery_10days_notice.jpg" alt="Flowers"
                                                style="width:100%;">
                                        </picture>
                                        <input type="button" class="btn btn-back flex-item" value="<?= lang('OK') ?>"
                                            for="modal-ord"
                                            onclick="comSubmit('<?php echo $link . '?mode=' . $msMode ?>', '_top', form); " />
                                    </diV>
                                </div>
                            </div>
                        </div>

                        <div id="acrylic-btn" class="btn-container">
                            <a href="javascript:void(0)" id="back" class="btn btn-back"
                                onclick="valid_chk_btn2('back')"><?= lang('戻る') ?></a>
                            <a href="javascript:void(0)" id="next" class="btn btn-next"
                                onclick="valid_chk_btn2('next')"><?= lang('オプション入力へ') ?></a>
                        </div>
                    </form>

                    <div id="cus_detail" style="display: none;" align="center">
                        <table class="table_rubber" style="display: table;">
                            <tbody>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（姓）') ?></td>
                                    <td class="text-left"><input name="Name_S" id="sname" type="text" maxlength="100"
                                            value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お名前（名）') ?></td>
                                    <td class="text-left"><input name="Name_F" id="fname" type="text" maxlength="100"
                                            value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('法人名') ?></td>
                                    <td class="text-left"><input name="Corp_Name" id="Corp_Name" type="text" value=""
                                            size="45" maxlength="100"></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('郵便番号') ?></td>
                                    <td class="text-left"><input type="text" id="zip" name="zip" maxlength="8" size="15"
                                            value="">&nbsp;<input type="button" id="src_btn" onclick="address_fn();"
                                            value="住所に変換"><br><span id="error" style="color:red"></span></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('都道府県') ?></td>
                                    <td class="text-left"><input type="text" id="address1" name="prefc" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('以降の住所') ?></td>
                                    <td class="text-left"><input id="address2" name="address" type="text"
                                            class="contact_text1" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('番地、建物名、部屋番号') ?></td>
                                    <td class="text-left"><input id="address_street" name="address_street" type="text"
                                            class="contact_text1" value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('TELハイフンなし') ?></td>
                                    <td class="text-left"><input name="tel" id="tel" type="text" maxlength="11"
                                            value=""></td>
                                </tr>
                                <tr>
                                    <td class="TableLeft"><?= lang('お客様メモ欄') ?></td>
                                    <td class="text-left"><input name="comment" id="comment" type="text" size="45"
                                            value=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"
                                        style="padding: 10px; background: unset; border: unset;">
                                        <input id="button_pdf" type="button"
                                            style="cursor:pointer; height: 30px; width: 250px; color: red"
                                            onclick="validate('gcd'); $('.loading').show();" value="御社情報確定（PDF出力）" />
                                        <div class="remark">&nbsp;※<?= lang('社名や会社名の入力は任意です') ?></div>
                                        <span id="validate_error" style="color:red"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--End Order Form Here-->

            <!--Accordion Option-->
            <div id="acc-option">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="option-toggle" class="accordion-input" checked>
                        <label for="option-toggle" class="accordion-header" id="option-g">
                            <span class="fw-bold">オプション</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">下記のオプションをご用意しております。</p>
                                <br>
                                <div>
                                    <div class="poster-grid">
                                        <div class="poster-item">
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this)"
                                                    src="/products/printedrubbercoaster/images/v2/printed_coaster_banner03.webp"
                                                    alt="Poster 1" />
                                                <div>
                                                    <p class="new-text fw-bold">汚れ防止加工オプション</p>
                                                    <p class="new-text">
                                                        うっかり汚してしまっても安心の汚れ防止加工オプションをご用意。印刷ラバーコースターをキレイに保ちます</p>
                                                </div>
                                                <br>
                                                <div>
                                                    <a href="/faq/details/rubberstrap/q4" class="new-text">汚れ防止加工の詳細</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="poster-item">
                                            <img loading="lazy" onclick="openSimpleModal(this)"
                                                src="/products/printedrubbercoaster/images/new/printed_coaster_backside.png"
                                                alt="Poster 2" />
                                            <div>
                                                <p class="new-text fw-bold">裏面印刷オプション</p>
                                                <p class="new-text">
                                                    オモテ面だけでなく、ウラ面にもデザインをUV印刷可能です。オモテ面のマットな仕上がりに対し、裏面は光沢のある仕上がりになります。</p>
                                            </div>
                                            <br>
                                            <div>
                                                <a href="/lp/rubber-guide-special.php?sec=clear2"
                                                    class="new-text">裏面印刷の詳細</a>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="poster-grid">
                                        <!-- <div class="poster-item">
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this)"
                                                    src="/products/printedrubbercoaster/images/new/printed_coaster_banner04.png"
                                                    alt="Poster 1" />
                                                <div>
                                                    <p class="new-text fw-bold">フチあり加工</p>
                                                    <p class="new-text">印刷ラバーコースターの縁部分に段差をつけるフチ加工が可能です。</p>
                                                </div>

                                            </div>
                                        </div> -->
                                        <div class="poster-item">
                                            <img loading="lazy" onclick="openSimpleModal(this)"
                                                src="/products/printedrubbercoaster/images/v2/printed_coaster_banner04.webp?v=1"
                                                alt="Poster 2" />
                                            <div>
                                                <p class="new-text fw-bold">特殊素材</p>
                                                <p class="new-text">
                                                    金銀、ラメ、蛍光、蓄光などの特殊素材で印刷ラバーコースターを製作可能。使用シーンに合った素材をお選びください。</p>
                                            </div>
                                            <br>
                                            <div>
                                                <a href="/lp/rubber-guide-special.php" class="new-text">特殊素材の詳細</a>
                                            </div>
                                        </div>
                                        <div class="poster-item">
                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this)"
                                                    src="/products/printedrubbercoaster/images/new/daishi_20260127.png"
                                                    alt="Poster 1" />
                                                <div>
                                                    <p class="new-text fw-bold">台紙封入</p>
                                                    <p class="new-text">当店のテンプレートデザイン、またはお客様のオリジナルデザインの台紙を封入します。</p>
                                                </div>
                                                <br>
                                                <div>
                                                    <a href="/products/daishi.html" class="new-text">台紙封入の詳細</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Option-->


            <!--Accordion Print-->
            <div id="acc-print">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="print-toggle" class="accordion-input" checked>
                        <label for="print-toggle" class="accordion-header" id="print-g">
                            <span class="fw-bold">鮮やかで強いフルカラーUV印刷</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">
                                    お客様のオリジナリティあふれるイラストやとっておきの写真、こだわりぬいたカラーデザインなどを、高い再現度で鮮やかにフルカラー印刷します。一般的なラバーコースターではできなかった色のグラデーションや陰影の表現が可能です。さらに水に強く、水やお茶で濡れても印刷が落ちる心配がありません。
                                </p>
                                <br>
                                <div>
                                    <div class="poster-grid">
                                        <div class="poster-item">

                                            <div>
                                                <img loading="lazy" onclick="openSimpleModal(this)"
                                                    src="/products/printedrubbercoaster/images/new/printed_coaster_normal.jpg"
                                                    alt="Poster 1" />
                                                <div class="camera-left"
                                                    style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                    📷<?= lang('クリックすると拡大します') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="poster-item">

                                            <img loading="lazy" onclick="openSimpleModal(this)"
                                                src="/products/printedrubbercoaster/images/new/printed_coaster07.jpg"
                                                alt="Poster 2" />
                                            <div class="camera-left"
                                                style="text-decoration:none; font-size: 10px; color: #1a0dab; margin: 0;">
                                                📷<?= lang('クリックすると拡大します') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Print-->

            <!--Accordion Flow -->
            <div id="acc-flow">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="flow-toggle" class="accordion-input" checked>
                        <label for="flow-toggle" class="accordion-header">
                            <span class="fw-bold">注文の流れ</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/printedrubbercoaster/images/v2/printed_coaster_banner05.webp"
                                        alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    当ページの注文フォームよりご注文ください。注文後、注文完了メールがお客様のメールアドレス宛てに送付されます。その後、当店からお客様へ、デザインの確認等のご連絡をメールでさせて頂きます。
                                </p>
                                <div style="text-align: right;">
                                    <a href="/lp/rubber-guide-flow.php" class="new-text">注文の流れの詳細</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Flow -->

            <!--Accordion Security -->
            <div id="acc-safety">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="security-toggle" class="accordion-input" checked>
                        <label for="security-toggle" class="accordion-header">
                            <span class="fw-bold">食品衛生法のおもちゃ規格に準拠した安全性</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <div>
                                    <img src="/products/printedrubbercoaster/images/v2/printed_coaster_banner06.webp"
                                        alt="" width="100%" loading="lazy">
                                </div>
                                <br>
                                <p class="new-text">
                                    当店の印刷ラバーコースターは、食品衛生法のおもちゃ規格に準拠した「ATBC-PVC（非フタル酸系塩ビ）」を使用しています。小さなお子様が誤って口に含んでしまっても健康を損なうおそれのない安全な素材です。また、安価なラバー製品にありがちな特有の刺激臭もございません。
                                </p>
                                <br>
                                <div style="text-align: right;">
                                    <a href="/lp/rubber-guide-production.php?sec=durability01"
                                        class="new-text">素材の安全性の詳細</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Security -->

            <!--Accordion Spec-->
            <div id="acc-specifications">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="spec-toggle" class="accordion-input" checked>
                        <label for="spec-toggle" class="accordion-header">
                            <span class="fw-bold">製品仕様</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <table class="table_rubber" cellpadding="5" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td><?= lang('名称') ?></td>
                                            <td style="text-align: left;"><?= lang('オリジナル印刷ラバーコースター') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('素材') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('ATBC-PVC（非フタル酸エステル系）のPVC(塩ビ)。熱や経年劣化による変形や変色が少なく、PVC特有のゴムの臭いが少ない材料。詳細はこちら。') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('大きさ') ?></td>
                                            <td style="text-align: left;"><?= lang('90mm×90mm以内') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('厚さ') ?></td>
                                            <td style="text-align: left;"><?= lang('3mm') ?></td>
                                        </tr>
                                        <tr>
                                            <td>印刷</td>
                                            <td style="text-align: left;"><?= lang('フルカラーUV印刷') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('裏面印刷') ?></td>
                                            <td style="text-align: left;">
                                                <?= lang('カラー印刷が可能です。＋@55円（税込）となります。') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('最小製作個数（最小ロット）') ?></td>
                                            <td style="text-align: left;"><?= lang('標準形状は1個。オリジナル形状は100個。') ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('試作品（実物校正サンプル）') ?></td>
                                            <td style="text-align: left;"><?= lang('8,800円（税込）。対象はオリジナル形状でのご注文のみ。') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang('台紙') ?></td>
                                            <td style="text-align: left;"><?= lang('オプションとして台紙の封入が可能です。') ?> <a
                                                    href="/products/daishi.html"
                                                    style="color:black;"><?= lang('台紙封入の詳細。') ?></a>
                                                <?= lang('支給された台紙封入、JANシール貼り等の軽作業は、@22円（税込）でお受けしております。') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Accordion Spec-->

            <div id="sales">
                <div class="accordion-container">
                    <div class="accordion-item">
                        <input type="checkbox" id="lastd-toggle" class="accordion-input" checked>
                        <label for="lastd-toggle" class="accordion-header">
                            <span class="fw-bold fw-style">営業担当が御社にお伺いいたします！各種相談受付</span>
                            <span class="icon"></span>
                        </label>

                        <div class="accordion-content">
                            <div class="plan-section">
                                <p class="new-text">「グッズ製作について直接対面で話して相談したい」という法人様向けに、訪問サービスをご用意しております。</p>
                                <br>
                                <div align="center">
                                    <a href="//hotmobily.jp/meeting_date/"><img
                                            data-src="../../img/btn_meetingdate_1.webp" title="ノベルティー営業担当呼び出しフォーム"
                                            width="100%" height="82" class="lazy" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>





            <div id="pdp-v2-modal" class="pdp-v2-modal-overlay">
                <div class="pdp-v2-modal-container">
                    <span class="pdp-v2-modal-close">&times;</span>
                    <img class="pdp-v2-modal-content" id="pdp-v2-modal-img" alt="Zoomed view">

                    <div class="pdp-v2-modal-next" id="pdp-v2-modal-next-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>


        </div>
        <!-- :: content_wrapper end :: -->
    </div>
    <!-- :: wrapper end :: -->
    <!--フッター ここから-->
    <?php include("../../footer.php"); ?>
    <!--フッター ここまで-->
    <!-- /lightbox2-master -->
    <script src="../js/lightbox.js"></script>
    <script src="/js/swiper.min.js"></script>
    <script>
        lightbox.option({
            'maxWidth': 800,
            'maxHeight': 800,
            'alwaysShowNavOnTouchDevices': true
        });
    </script>
    <!-- /lightbox2-master -->
    <!-- google script -->
    <!-- リマーケティング タグの Google コード -->
    <!--
リマーケティング タグは、個人を特定できる情報と関連付けることも、デリケートなカテゴリに属するページに設置することも許可されません。タグの設定方法については、こちらのページをご覧ください。
http://google.com/ads/remarketingsetup
-->
    <!-- Swiper JS -->
    <script type="text/javascript" src="/js/_setToInput_printedrubbercoaster2.js?ver=<?php echo date('is') ?>"></script>
    <script language="JavaScript" src="/js/validation_new.js?v=1.11" type="text/javascript"></script>
    <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.17"></script>
    <script type="text/javascript" src="/products/js/date.js"></script>
    <script type="text/javascript" src="<?= $pdf_rubber_js ?>"></script>
    <script>
        $(document).ready(function () {
            let params = '<?php echo (isset($_GET['sec']) ? $_GET['sec'] : "") ?>';
            if (params != "") {
                GotoDiv(params, true);
            }

            // document.getElementById('SampleCheckbox').disabled = true;

            // --- 1. CACHE DOM ELEMENTS (Performance Boost) ---
            const elements = {
                modal: document.getElementById('pdp-v2-modal'),
                modalImg: document.getElementById('pdp-v2-modal-img'),
                pdpStrip: document.getElementById('pdp-v2-js-strip'),
                pdpGrid: document.getElementById('pdp-v2-js-grid-pc'),
                nextBtn: document.getElementById('pdp-v2-modal-next-btn'),
                closeBtns: document.querySelectorAll('.pdp-v2-modal-close'),
                body: document.body
            };

            const imageList = [{
                src: "/products/printedrubbercoaster/images/v2/printed_coaster_01.webp",
                targetId: "processing",
                alt: ""
            },
            {
                src: "/products/printedrubbercoaster/images/v2/printed_coaster_02.webp",
                targetId: "special",
                alt: ""
            },
            {
                src: "/products/printedrubbercoaster/images/v2/printed_coaster_03.webp",
                targetId: "plans",
                alt: ""
            },
            {
                src: "/products/printedrubbercoaster/images/v2/printed_coaster_04.webp",
                targetId: "production",
                alt: ""
            },
            {
                src: "/products/printedrubbercoaster/images/v2/printed_coaster_05.webp",
                targetId: "production",
                alt: ""
            },
            {
                src: "/products/printedrubbercoaster/images/v2/printed_coaster_06.webp",
                targetId: "production",
                alt: ""
            }
            ];

            let pdpCurrentIdx = 0;
            let pdpTimer;
            const isMobile = window.innerWidth < 768;

            function initGallery() {
                // Create fragments to minimize Reflows
                const stripFragment = document.createDocumentFragment();
                const gridFragment = document.createDocumentFragment();
                const zoomSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>';

                imageList.forEach((item, i) => {
                    // Build Main Strip
                    const mainContainer = document.createElement('div');
                    mainContainer.className = 'pdp-v2-main-link';

                    // Use template literal for speed
                    mainContainer.innerHTML = `
                <div class="pdp-v2-zoom-icon">${zoomSVG}</div>
                <img src="${item.src}" alt="${item.alt}" loading="" class="pdp-v2-slide-img">
            `;
                    // Add event directly
                    mainContainer.onclick = () => openModal(i);
                    stripFragment.appendChild(mainContainer);

                    // Build Thumbnails
                    const thumbImg = document.createElement('img');
                    thumbImg.src = item.src;
                    thumbImg.alt = item.alt;
                    thumbImg.loading = '';
                    thumbImg.className = 'pdp-v2-thumb-item' + (i === 0 ? ' pdp-v2-active-state' : '');

                    thumbImg.onclick = () => {
                        updateGalleryView(i);
                        restartAutoTimer();
                    };
                    gridFragment.appendChild(thumbImg);
                });

                if (elements.pdpStrip) elements.pdpStrip.appendChild(stripFragment);
                if (elements.pdpGrid) elements.pdpGrid.appendChild(gridFragment);

                if (elements.pdpGrid) elements.pdpGrid.classList.remove('is-hidden');
            }

            function updateGalleryView(index) {
                pdpCurrentIdx = index;
                if (elements.pdpStrip) elements.pdpStrip.style.transform = `translateX(-${index * 100}%)`;

                // Efficient class toggling
                const thumbs = document.getElementsByClassName('pdp-v2-thumb-item');
                for (let i = 0; i < thumbs.length; i++) {
                    if (i === index) thumbs[i].classList.add('pdp-v2-active-state');
                    else thumbs[i].classList.remove('pdp-v2-active-state');
                }
            }

            function openModal(index) {
                pdpCurrentIdx = index;
                if (elements.modal) {
                    elements.modal.classList.add('active');
                    elements.modalImg.src = imageList[index].src;
                    elements.modalImg.style.opacity = '1';
                    clearInterval(pdpTimer);
                }
            }

            function closeModal() {
                if (elements.modal) elements.modal.classList.remove('active');
                restartAutoTimer();
            }

            function nextImage() {
                pdpCurrentIdx = (pdpCurrentIdx + 1) % imageList.length;
                // Fade effect logic
                elements.modalImg.style.opacity = '0';
                setTimeout(() => {
                    elements.modalImg.src = imageList[pdpCurrentIdx].src;
                    elements.modalImg.onload = () => {
                        elements.modalImg.style.opacity = '1';
                    };
                }, 200);
                updateGalleryView(pdpCurrentIdx);
            }

            // Modal Event Listeners
            if (elements.closeBtns) elements.closeBtns.forEach(btn => btn.onclick = closeModal);
            if (elements.modal) elements.modal.onclick = (e) => {
                if (e.target === elements.modal) closeModal();
            };
            if (elements.nextBtn) elements.nextBtn.onclick = (e) => {
                e.stopPropagation();
                nextImage();
            };

            function startAutoTimer() {
                pdpTimer = setInterval(() => {
                    pdpCurrentIdx = (pdpCurrentIdx + 1) % imageList.length;
                    updateGalleryView(pdpCurrentIdx);
                }, 4000);
            }

            function restartAutoTimer() {
                clearInterval(pdpTimer);
                startAutoTimer();
            }

            // --- 4. OPTIMIZED ENTRANCE ANIMATIONS ---
            // Replaces the nested setTimeout "Callback Hell"
            function runEntranceAnimations() {
                // Define animation targets based on screen size
                const targets = isMobile ? ['#B', '.Mb-D-Contents', '.Mb-A-Contents', '.Mb-B-Contents'] : ['#B', '.PC-C-Contents', '.Mb-A-Contents', '.Mb-B-Contents'];

                // Initial State (Apply via JS to ensure CSS matches)
                targets.forEach(sel => {
                    $(sel).css({
                        "filter": "blur(10px)",
                        "opacity": "0",
                        "transform": "translateY(50px)",
                        "transition": "all 0.8s ease-out"
                    });
                });

                // Loop with staggered delays
                targets.forEach((selector, index) => {
                    setTimeout(() => {
                        $(selector).css({
                            "filter": "blur(0px)",
                            "opacity": "1",
                            "transform": "translateY(0)"
                        });
                    }, index * 200 + 100); // 200ms stagger
                });
            }

            // --- 5. EVENT DELEGATION FOR ACCORDIONS ---
            // Replaces adding listeners to every single header
            document.addEventListener('click', function (e) {
                // Check if clicked element is an accordion header or inside one
                const header = e.target.closest('.accordion-header');
                if (!header) return;

                // Close all others
                document.querySelectorAll('.accordion-header').forEach(h => {
                    content.style.maxHeight = null;
                    if (h !== header) {
                        h.classList.remove('active');
                        h.nextElementSibling.style.maxHeight = null;
                        h.nextElementSibling.style.paddingTop = "0";
                        h.nextElementSibling.style.paddingBottom = "0";
                    }
                });

                // Toggle Clicked
                const content = header.nextElementSibling;
                header.classList.toggle('active');

                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    content.style.paddingTop = "0";
                    content.style.paddingBottom = "0";
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                    content.style.paddingTop = "15px";
                    content.style.paddingBottom = "15px";
                }
            });

            // --- 6. AJAX & EXTERNAL CONTENT ---
            // Grouped for cleaner execution

            // Load Info
            $('#info_div').load('/info/index.php');

            // Load Price Table
            const $priceTbl = $('.tbl_price_deli.loading');
            if ($priceTbl.length) {
                $priceTbl.load("../getdate_disp2023-printedrubber", function (data) {
                    $(this).replaceWith(data);
                    $('.tbl_price_deli').removeClass("loading");
                });
            }

            // Check Holiday
            $.post("/products/check_holiday.php", {
                "product": "ラバーキーホルダー"
            }, function (data) {
                if (typeof productionDate === 'function') productionDate(data.sort());
            }, "json");

            // Get Sample Date
            $.post("../get_sample_date.php", {
                'days': '7',
                'format_cal': '12'
            }, function (data) {
                $('.speed_deli_date').html(formatDate(data[1]) + "<br/><div class='ut_date'>7日</diV>");
                $('.speed_deli_date2').html(formatDate(data[2]) + "<br/><div class='ut_date'>13日</diV>");
                if (typeof productionDate3 === 'function') productionDate3(data.sort());
            }, "json");

            // Get Sample Date 2
            $.post("../get_sample_date.php", function (data) {
                if (typeof productionDate2 === 'function') productionDate2(data.sort());
            }, "json");

            // --- 7. MISC UI HANDLERS ---

            // Paper Preview
            $(document).on('click', "input[name='paper_select']", function () {
                if ($(this).is(':checked')) {
                    $('#paper-preview').load('/products/paper_preview.php');
                }
            });

            // Read More Expanders (Delegated)
            $(document).on('click', '.exc_pro1 .btn, .exc_pro .btn', function (e) {
                e.preventDefault();
                const $el = $(this);
                const $up = $el.closest('.exc_pro1, .exc_pro'); // Find parent container
                const $containers = $up.find("div.swiper-container");

                let totalHeight = 0;
                $containers.each(function () {
                    totalHeight += $(this).outerHeight();
                });

                $up.css({
                    "max-height": 9999,
                    "padding-bottom": 70
                })
                    .animate({
                        "height": totalHeight
                    });
                $el.parent().fadeOut();
            });

            // Video Preview Switcher
            $('.preview-sub img').click(function () {
                var e = $(this).attr('data-embed');
                var r = $(this).attr('data-src');
                if ($('.preview-top').find('img').length) {
                    $('.preview-top img').attr('src', r).attr('data-src', e);
                } else {
                    $('.preview-top iframe').attr('src', 'https://www.youtube.com/embed/' + e);
                }
            });

            // Swiper Logic
            if (isMobile) {
                if (typeof Swiper !== 'undefined') {
                    new Swiper('.swiper-container', {
                        slidesPerView: 2,
                        spaceBetween: 10,
                        slidesPerGroup: 1,
                        loop: false,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        },
                    });
                }
                // Delayed Scroll (optimized)
                setTimeout(() => window.scrollBy(0, 5), 3000);
            } else {
                setTimeout(() => window.scrollBy(0, 5), 100);
            }

            $("#open-virus").click(function () {
                $("#slide-virus").slideToggle("slow");
            });
            $('.jump').click(function (e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#text-coating').offset().top - 100
                }, 800);
            });

            // INITIALIZE
            initGallery();
            startAutoTimer();
            // runEntranceAnimations();

            // Dynamic Text Updates
            var tmp = "<?= $_GET['mode'] ?? '' ?>"; // Safety check for PHP
            if (isMobile) {
                $("#i_txt1").attr("src", "images/img_txt2_n1.svg");
                $("#i_txt2").attr("src", "images/text_sample_n1.svg");
            }
            // Assumes getPartData is defined globally
            if (typeof getPartData === 'function') getPartData($('input[name="part"]:checked').val());
            if (tmp != "" && typeof valid_chk_btn === 'function') valid_chk_btn('step1');

        }); // End Ready

        // --- GLOBAL FUNCTIONS (Keep outside ready to be accessible) ---

        function openTab(evt, tabName) {
            $(".tab-content").hide();
            $(".tab-link").removeClass("active");

            const tab = document.getElementById(tabName);
            if (tab) {
                tab.style.display = "block";
                tab.style.maxHeight = "2000px";
            }
            if (evt && evt.currentTarget) evt.currentTarget.classList.add("active");
        }

        function GotoDiv(no, external_page = false) {
            let em = '';
            if (!no) return;

            if (!external_page) {
                const map = {
                    1: '#order-form',
                    2: '#acc-shipping',
                    3: '#acc-price',
                    4: '#acc-detail',
                    5: '#reviews',
                    77: '#acc-print_type',
                    88: '#acc-option',
                    99: '#acc-print_type',
                };
                em = map[no];
                if (no == 2) openShippingAccordion();
                if (no == 3) openPriceAccordion();
                if (no == 77) openShippingAccordion();
                if (no == 88) openOptionAccordion();
                if (no == 99) openPrinTypeAccordion();
            } else {
                em = '#' + no;
            }

            if (em && $(em).length) {
                $("html, body").animate({
                    scrollTop: $(em).offset().top - 100
                }, 1000);
            }
        }

        function openSimpleModal(element) {
            const modal = document.getElementById('pdp-v2-modal');
            const modalImg = document.getElementById('pdp-v2-modal-img');
            let imgSrc = "";

            if (element.tagName === 'IMG') imgSrc = element.src;
            else {
                const img = element.closest('.flex-item')?.querySelector('swiper-container img');
                if (img) imgSrc = img.src;
            }

            if (imgSrc && modal) {
                modal.classList.add('active');
                modalImg.src = imgSrc;
                modalImg.style.opacity = '1';
            }
        }

        function openPriceAccordion() {
            $('#price-toggle').prop('checked', true);
            document.getElementById('acc-price')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function openShippingAccordion() {
            $('#shipping-toggle').prop('checked', true);
            document.getElementById('acc-shipping')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function openPrinTypeAccordion() {
            $('#print_type-toggle').prop('checked', true);
            document.getElementById('acc-print_type')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function openOptionAccordion() {
            $('#option-toggle').prop('checked', true);
            document.getElementById('acc-option')?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    </script>
    </script>
    <script type="text/javascript" src="/js/common.js?v=1.02"></script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".tbl_s").on("click scroll", function () {
                $(this).find(".scroll-center").hide();
            });
        });
    </script>
    <noscript>
        <div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt=""
                src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1036353231/?value=0&amp;guid=ON&amp;script=0" />
        </div>
    </noscript>
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
                        "name": "ラバーストラップ",
                        "item": "https://hotmobily.jp/products/rubberstrap/"
                    }
                ]
            }
        ]
    </script>
    <!-- /.google script -->
</body>

</html>