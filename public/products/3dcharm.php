<?php
session_start();
include_once('../common/SetUpLang.php');
include("../connect_db/Control_Connect.php");
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="3Dチャーム">
    <meta name="description" content="オリジナル3Dチャーム（立体チャーム）を製作するならホットモバイリー！「PVC貼り合わせ」「ポリレジン」「インジェクション」という3つの製造方法の特徴、最低ロット数、素材の違いから、予算や目的に合わせた最適な選び方まで網羅した完全マニュアルです。同人グッズや企業ノベルティ、販売用アイテムのプロジェクトを大成功させたいご担当者様は必見です。">

    <meta name="robots" content="index,follow">
    <title>オリジナルス3D立体キーホルダー・ストラップ、イヤホン ジャック ストラップなど！各種オリジナル3Dチャームを製作可能！</title>

    <?php include('../head_products.html') ?>

    <link href="../css/faq_2nd.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="preload" href="/campaign/css/all.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />

    <script language="JavaScript" type="text/javascript">
        // window.ysm_customData = new Object();
        // window.ysm_customData.conversion = "transId=,currency=,amount=";
        // var ysm_accountid  = "1C8AE9TA2V1IGBU2QBLAVUASHCO";
        // document.write("<SCR" + "IPT language='JavaScript' type='text/javascript' "
        // + "SRC=//" + "srv2.wa.marketingsolutions.yahoo.com" + "/script/ScriptServlet" + "?aid=" + ysm_accountid
        // + "></SCR" + "IPT>");
        // -->
    </script>

    <style>
        .fs-bold {
            font-family: 'IwaUDGoDspPro-Bd' !important;
        }

        .new-text {
            font-size: 16px !important;
            letter-spacing: 0.05em !important;
            line-height: 150% !important;
        }

        #mbp,
        .mbp{
            display:none;
        }

        #pcp,
        .pcp{
            display:block;
        }
        

        .h1-default {
            background: white;
            color: black;
            padding: 0;
        }

        /* h3{
            font-size: 19px !important;
            letter-spacing: 0.05em !important;
        } */

        .h3-new {
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

        /* .h2-default{
            color: black;
        } */
        .h2-default {
            display: flex;
            align-items: center;
            padding: 15px !important;
            background-color: #f2f2f2;
            color: #333333;
            margin: 40px 0 0 0 !important;
        }

        .h2-default:before {
            display: inline-block;
            width: 5px;
            height: 1.5em;
            margin-right: .5em;
            background-color: #ffa500;
            content: '';
        }

        .mt-20 {
            margin-top: 20px;
        }

        .txt-center {
            text-align: center;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .fz-16 {
            font-size: 16px;
        }

        .fz-14 {
            font-size: 14px;
        }

        .w-30 {
            width: 30%;
        }

        .w-50 {
            width: 50%;
        }

        .w-100 {
            width: 100%;
        }

        .img-temp {
            width: 40%;
        }

        .blue-hig {
            background-color: #33ccff;
            color: white;
            padding: 5px;
        }

        .gray-hig {
            background-color: #f5f5f5;
            padding: 10px;
        }

        .tag-menu .tag-name {
            display: inline-block;
            margin: 5px 3px;
            color: #fff;
            margin-left: 0;
            text-decoration: none !important;
        }

        span.tag-name.non-active {
            background: #2196f3;
            border: unset;
            border-radius: 2px;
            padding: 2px 16px;
            margin-bottom: 0;
            font-size: 11px;
        }

        .img-col {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            padding-top: 15px;
        }

        .product-card {
            max-width: 200px;
            border: 2px solid #D5D5DE;
            text-align: center;
            font-family: sans-serif;
            background-color: #f8c045;
            color: #fff !important;
        }


        .product-card:hover {
            cursor: pointer;
            /* background: #D5D3DC;            */
            box-shadow: 0 3px 3px 0px rgba(0, 0, 0, 0.5);
            transform: translateY(3px);
            color: #fff !important;
        }

        .product-image {
            width: 100%;
            display: block;
            border-bottom: 2px solid #D5D5DE;
        }

        .product-text {
            background-color: #f8c045;
            color: #fff !important;
            padding: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        .product-card a {
            color: #fff !important;
        }

        a:hover {
            text-decoration: none !important;
        }

        hr {
            margin: 6.5px 0;
            border: 0.5px solid #dcdcdc;
        }

        #wrapper #content_wrapper ul {
            /* margin: 0; */
            list-style-type: none !important;
            list-style-image: none !important;
            font-size: 16px !important;
        }

        .main-area {
            display: flex;
            flex-direction: row;
            width: 100%;
        }

        .sub-area {
            width: 50%;
        }

        .img-acc {
            max-width: 100%;
            height: auto;
        }

        hr {
            margin-top: 12px;
        }

        .fs-12 {
            font-size: 12px !important;
        }

        .font-black {
            color: black !important;
        }

        .box2 {
            padding: 0.5em 1em;
            margin: 2em 0;
            font-weight: bold;
            color: orange;
            background: #FFF;
            border: solid 3px orange;
            border-radius: 10px;
        }

        .box2 p {
            margin: 0;
            padding: 0;
        }

        .hlt {
            background: linear-gradient(transparent 50%, yellow 50%);
        }

        .red-btn {
            display: inline-block;
            background-color: #d32f2f;
            color: white !important;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            max-width: 100%;
            box-sizing: border-box;
            text-decoration: none;
        }

        .red-btn:hover {
            background-color: #b71c1c; 
        }

        .jess:hover{
            text-decoration: underline !important;
        }

        .banner-j{
            display: flex;
            flex-direction: row;
            gap: 10px;
            width: 100%;
        }

        .banner-k{
            width: 50%;
        }

        .img-ra{
            width: 100%;
        }

        .video-yt{
            width: 771px;
            height: 434px;
        }

        @media (max-width: 500px) {
            .img-col {
                justify-content: center;
                gap: 10px;
            }

            .product-card {
                max-width: 100%;
            }

            .product-text {
                font-size: 14px;
                padding: 8px;
            }

            .main-area {
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            .sub-area {
                width: 100%;
            }

            .banner-k{
                width: 100%;
            }
        }

        @media screen and (max-width: 768px) {
            .img-col {
                justify-content: center;
                gap: 10px;
            }

            .img-temp {
                width: 100%;
            }

            .main-area {
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            .sub-area {
                width: 100%;
            }

            .banner-k{
                width: 100%;
            }

            .video-yt{
                width: 100%;
                height: 250px;
            }

            #mbp,
            .mbp{
                display:block;
            }

            #pcp,
            .pcp{
                display:none;
            }

            #mbp .red-btn,
            .mbp .red-btn {
                width: 100%;
                max-width: 330px;
                padding: 10px 12px;
                font-size: 17px;
                line-height: 1.6;
                text-align: center !important;
                white-space: nowrap;
            }
        }

        @media(max-width: 425px) {
            .img-col {
                justify-content: center;
                gap: 10px;
            }

            .img-temp {
                width: 100%;
            }

            .main-area {
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            .sub-area {
                width: 100%;
            }

            .banner-k{
                width: 100%;
            }
        }
    </style>

</head>

<body id="top">

    <?php include('../header.html') ?>
    <?php include('../gnavi.html') ?>

    <div id="wrapper">
        <?php include('../sidenavi.html') ?>
        <div id="content_wrapper">
            <div>
                <h1 class="" style="background-color:#F58904;">オリジナルス3D立体キーホルダー・ストラップ、イヤホン ジャック ストラップなど！各種オリジナル3Dチャームを製作可能！</h1>
                <div style="text-align:end;">
                    <div class="social-time">
                        <span class="social-content">
                            <a href="javascript:void(0)" title="Share by Email" onclick="shareByEmail()">シェアする</a>
                            <a href="javascript:void(0)" title="Share by Email" style="color:black;" onclick="shareByEmail()"><i class="far fa-envelope"></i></a>
                            <a href="https://www.facebook.com/share.php?u=https://hotmobily.jp/lp/acrylic-guide.php" target="_blank" style="color:black;"><i class="fab fa-facebook-square"></i></a>
                            <a href="https://www.twitter.com/share?url=https://hotmobily.jp/lp/acrylic-guide.php" target="_blank" style="color:black;"><i class="fab fa-twitter-square"></i></a>
                        </span>
                        <span class="time-content">更新日 2026年8月3日</span>
                    </div>
                </div>
            </div>

            <div>
                <img loading="lazy" src="/products/images/3d/3dcharm01.webp?n=1" alt="" style="width: 100%;">
            </div>

            <!-- Topic 1 -->
            <!-- <div>
                <div class="mt-20" id="one">
                    <h2 class="h2-default fs-bold">各種オリジナル3Dチャームを製作！</h2>
                </div>
                <br>
                <p class="new-text">半立体PVC貼り合わせ、ポリレジン、インジェクションの3種の3Dチャームの製作を承っております。それぞれの製造方法や特長は以下になります。</p>
                <br>
                <div class="exceed-table new-text">
                    <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process" style="margin-top:15px;">
                        <tr>
                        <td align="center" class="new-text">名称</td>
                        <td align="center" class="new-text">素材</td>
                        <td align="center" class="new-text">製造方法</td>
                        <td align="center" class="new-text">特長</td>
                        <td align="center" class="new-text">イヤホンジャックチャーム</td>
                        <td align="center" class="new-text" >品質</td>
                        <td align="center" class="new-text" >最低<br />
                            製作個数</td>
                        </tr>
                        <tr>
                        <td align="center" class="new-text" ><a href="pvc_hariawase.html" class="new-text">半立体PVC貼り合わせ</a></td>
                        <td align="center" class="new-text" >ATBC-PVC(塩ビ)<br />
                            (非フタル酸PVC)</td>
                        <td class="new-text">2枚の平面に近いラバー製品を貼り合わせます</td>
                        <td>最も安価に製作できる。平面（半立体）ラバーストラップの貼り合わせ</td>
                        <td align="center" class="new-text" >製作可</td>
                        <td align="center" class="new-text">中</td>
                        <td align="center" class="new-text" >500個～</td>
                        </tr>
                        <tr>
                        <td align="center" class="new-text" ><a href="polyresign.html" class="new-text">ポリレジン</a></td>
                        <td align="center" class="new-text" >ポリレジン<br />
                            (ポリエチレン+石粉)</td>
                        <td>三次元簡易金型により原型を成型。模様やロゴを印刷により表現</td>
                        <td>3Dチャームを、比較的少ない個数で、最も安価に製造できる方法</td>
                        <td align="center" class="new-text" >製作可</td>
                        <td align="center" class="new-text">中</td>
                        <td align="center" class="new-text" >500個～</td>
                        </tr>
                        <tr>
                        <td align="center" class="new-text" ><a href="injection.html" class="new-text">インジェクション</a></td>
                        <td align="center" class="new-text" >ABS、PVC等</td>
                        <td>射出成型用金型を用いて原型を成型。模様やロゴを印刷により表現</td>
                        <td>シャープな輪郭線で高品質。10,000個以上の製作では、最も効果的。</td>
                        <td align="center" class="new-text" >製作可</td>
                        <td align="center" class="new-text">高</td>
                        <td align="center" class="new-text" >1,000個～</td>
                        </tr>
                    </table>
                </div>
                <br>
                <div>
                    <table width="710" style="margin-top:10px;">
                        <tr>
                            <td align="center"><a href="pvc_hariawase.html"><img src="img/charm_bnr1.webp" alt="PVC貼り合わせ" width="230" height="124" /></a></td>
                            <td align="center"><a href="polyresign.html"><img src="img/charm_bnr2.webp" alt="ポリレジン" width="230" height="124" /></a></td>
                            <td align="center"><a href="injection.html"><img src="img/charm_bnr3.webp" alt="インジェクション" width="230" height="124" /></a></td>
                        <tr>
                            <td align="center"><a href="pvc_hariawase.html" class="new-text">PVC貼り合わせ</a></td>
                            <td align="center"><a href="polyresign.html" class="new-text">ポリレジン</a></td>
                            <td align="center"><a href="injection.html" class="new-text">インジェクション</a></td>
                        <tr>
                    </table>
                </div>
            </div> -->

            <!-- Topic 2 -->
            <div>
                <div class="mt-20" id="two">
                    <h2 class="h2-default fs-bold">3Dチャームとは？平面グッズにはない圧倒的な魅力と活用シーン</h2>
                </div>
                <br>
                <div>
                    <img loading="lazy" src="/products/images/3d/3dcharm02.webp" alt="" style="width: 100%;">
                </div>
                <h3 class="h3-new fs-bold">1-1. 3Dチャームの定義と平面アイテムとの違い</h3>
                <p class="new-text">3Dチャームとは、キャラクターや企業ロゴ、商品パッケージなどを360度どこから見ても立体的に美しく再現したアイテムのことです。 通常のアクリル製品や一般的なラバー製品は、2D（平面）または半立体（表面のみ凹凸がある状態）で表現されます。これに対し、3Dチャームは前後左右に厚みと造形を持ち、まるで小さなフィギュアや精巧なミニチュア模型のような高い完成度を誇ります。 平面のイラストをそのままグッズ化するのも素敵ですが、立体化することで「触り心地の良さ」「所有欲を満たす本物感」「あらゆる角度から楽しめる愛らしさ」が大きくプラスされ、コレクターズアイテムとしての価値が格段に高まります。</p>
                <h3 class="h3-new fs-bold">3Dチャームの代表的な活用シーン</h3>
                <p class="new-text">3Dチャームは、その高いクオリティと存在感から、以下のような幅広いシーンで強力なプロモーションツールとして大活躍しています。</p>
                <br>
                <p class="new-text fs-bold">キャラクターグッズ・アニメグッズ</p>
                <p class="new-text">アニメ、ゲーム、VTuberなどのキャラクターをデフォルメして可愛らしく立体化。販売用グッズやカプセルトイ（ガチャガチャ）の景品、クレーンゲームのプライズとして非常に高い人気を誇ります。</p>
                <br>
                <p class="new-text fs-bold">企業の販促ノベルティ</p>
                <p class="new-text">自社の主力商品（飲料のボトル、お菓子のパッケージ、家電製品、自動車など）を精巧にミニチュア化。展示会での配布やSNSキャンペーンの景品として、ブランド認知度とお客様からの愛着を深める絶大な効果を発揮します。</p>
                <br>
                <p class="new-text fs-bold">アーティスト・アイドルのツアーグッズ</p>
                <p class="new-text">ツアーロゴやマスコットキャラクター、象徴的なモチーフを立体化したチャームは、ライブの物販でファンに大変喜ばれる、特別感にあふれたアイテムです。</p>

                <br>
                <p class="new-text fs-bold">観光地のお土産・記念品</p>
                <p class="new-text">ご当地キャラクターや歴史的建造物、名産品をかたどったチャームは、インバウンド（訪日外国人）需要も含めて、長く愛される定番商品として安定した人気を見込めます。</p>
            </div>

            <!-- Topic 3 -->
            <div>
                <div class="mt-20" id="three">
                    <h2 class="h2-default fs-bold">素材と製造方法による3Dチャームの違い（3大製法の魅力）</h2>
                </div>
                <br>
                <div>
                    <p class="new-text">ホットモバイリーが提供する3Dチャーム製品は、材料や製造方法の違いにより大きく分けて3つの種類があります。それぞれの特性、コストパフォーマンスの良さ、得意な表現を正しく理解することが、理想のグッズを形にするための第一歩です。</p>
                    <h3 class="h3-new fs-bold">半立体PVC貼り合わせ（最も手軽に豊かなボリューム感を演出）</h3>
                    <div>
                        <img src="/products/images/3d/3dcharm03.webp" alt="">
                    </div>
                    <br>
                    <p class="new-text">最も手軽に、そしてリーズナブルにボリューム感たっぷりのチャームを製作できるのが「半立体PVC貼り合わせ」という手法です。</p>
                    <br>
                    <p class="new-text fs-bold">素材</p>
                    <p class="new-text">ATBC-PVC（塩ビ／非フタル酸PVC）</p>
                    <br>
                    <p class="new-text fs-bold">製造方法</p>
                    <p class="new-text">表面用と裏面用、2枚の平面に近いラバー製品（半立体ラバーアイテム）を個別に成型し、それらを背中合わせに強力に貼り合わせることで厚みのある立体的なチャームを作り出します。</p>
                    <br>
                    <p class="new-text fs-bold">最低製作個数</p>
                    <p class="new-text">100個</p>
                    <br>
                    <p class="new-text fs-bold">特長とメリット</p>
                    <p class="new-text">この製法最大の魅力は「圧倒的なコストパフォーマンスの高さ」です。完全な3D用の金型を起こす必要がないため、初期費用（金型代）を大きく抑えつつ立体感を実現できます。また、素材に使用しているATBC-PVCは、環境や人体に優しい安全な非フタル酸PVCです。柔らかく弾力のあるゴムのような質感が特徴で、落下しても傷つきにくく、長く綺麗にお使いいただけるという実用的なメリットもあります。小さなお子様向けのグッズとしても大変おすすめです。</p>
                    <br>
                    <p class="new-text fs-bold">得意な表現</p>
                    <p class="new-text">「分厚くボリュームのあるラバーアイテム」という表現が適しており、ポップで可愛らしいキャラクターや、シンプルなロゴマークなどを元気いっぱいに表現するのに最適です（※構造上、側面に貼り合わせのラインが生じます）。</p>
                    <br>
                    <div style="text-align:center; margin-top:10px;" id="pcp">
                        <a href="/products/pvc_hariawase" class="red-btn mb" style="text-align:center;">3D立体チャーム（半立体PVC貼り合わせ）のページへ</a>
                        <!-- <table width="710" style="margin-top:10px;">
                            <tr>
                                <td align="left"><a href="pvc_hariawase.html"><img src="img/charm_bnr1.webp" alt="PVC貼り合わせ" width="230" height="124" /></a></td>
                            <tr>
                                <td align="left"><a href="pvc_hariawase.html" class="new-text">PVC貼り合わせ</a></td>
                            <tr>
                        </table> -->
                    </div>

                    <div style="text-align:center; margin-top:10px;" id="mbp">
                        <a href="/products/pvc_hariawase" class="red-btn pc" style="text-align:left;">3D立体チャーム（半立体PVC貼り合わせ）<br>のページへ</a>
                    </div>

                    <h3 class="h3-new fs-bold">ポリレジン（温かみのある造形と小〜中ロットでの立体化に最適）</h3>
                    <div>
                        <img src="/products/images/3d/3dcharm04.webp" alt="">
                    </div>
                    <br>
                    <p class="new-text">フィギュアのような本格的な立体感を持ちながら、少ない個数でもコストを抑えてハイクオリティに製作できるのが「ポリレジン」製法です。</p>
                    <br>
                    <p class="new-text fs-bold">素材</p>
                    <p class="new-text">ポリレジン（ポリエチレン樹脂と石粉などを混ぜ合わせた複合素材）</p>
                    <br>
                    <p class="new-text fs-bold">製造方法</p>
                    <p class="new-text">三次元の簡易金型（シリコン型など）を作成し、そこに液状のポリレジンを流し込んで（キャスト成型）原型を作ります。硬化後、表面の複雑な模様やキャラクターの表情、ロゴなどを職人の丁寧な手作業による塗装や特殊な印刷によって表現します。</p>
                    <br>
                    <p class="new-text fs-bold">最低製作個数</p>
                    <p class="new-text">500個</p>
                    <br>
                    <p class="new-text fs-bold">特長とメリット</p>
                    <p class="new-text">ポリレジンは石粉が含まれているため、一般的なプラスチックよりはずっしりとした心地よい重みがあり、陶器や素焼きのような温かみのある上質なマット感が特徴です。完全な3D形状を表現できるため、複雑なキャラクターの造形や、丸みを帯びたアイテムの再現に非常に優れています。また、高額な鋼材の金型を使わないため、本格的な立体物でありながら初期費用をリーズナブルに抑えられます。500個〜数千個程度の小〜中ロットで、本格的な3Dチャームを製作したい場合に最も力を発揮する製法です。</p>
                    <br>
                    <p class="new-text fs-bold">得意な表現</p>
                    <p class="new-text">職人の手作業の温もりを感じる仕上がりは、キャラクターの魅力を最大限に引き出します。複雑な造形も得意としています。</p>
                    <br>
                    <div style="text-align:center; margin-top:10px;" class="pcp">
                        <a href="/products/polyresign.php" class="red-btn" style="text-align:center;">3D立体チャーム（ポリレジン）のページへ</a>
                        <!-- <table width="710" style="margin-top:10px;">
                            <tr>
                                <td align="left"><a href="polyresign.html"><img src="img/charm_bnr2.webp" alt="ポリレジン" width="230" height="124" /></a></td>
                            <tr>
                                <td align="left"><a href="polyresign.html" class="new-text">ポリレジン</a></td>
                            <tr>
                        </table> -->
                    </div>

                    <div style="text-align:center; margin-top:10px;" class="mbp">
                        <a href="/products/polyresign.php" class="red-btn">3D立体チャーム（ポリレジン）<br>のページへ</a>
                    </div>
                    
                    <h3 class="h3-new fs-bold">インジェクション（射出成型）（大ロット・最高品質・シャープな仕上がり）</h3>
                    <div>
                        <img src="/products/images/3d/3d-5.webp" alt="">
                    </div>
                    <br>
                    <p class="new-text">数万個規模の大規模なプロモーションや、市販の高級ハイエンドグッズとして極めて精度の高い製品を求める場合は、「インジェクション（射出成型）」が圧倒的な強さを発揮します。</p>
                    <br>
                    <p class="new-text fs-bold">素材</p>
                    <p class="new-text">ABS樹脂、PVC、アクリル樹脂など</p>
                    <br>
                    <p class="new-text fs-bold">製造方法</p>
                    <p class="new-text">鋼材を精密に削り出して高耐久の射出成型用金型（金型）を製作し、そこに加熱してドロドロに溶かしたプラスチック樹脂を高圧で注入（射出）して成型します。成型後、模様やロゴを精細な印刷や塗装で表現します。</p>
                    <br>
                    <p class="new-text fs-bold">最低製作個数</p>
                    <p class="new-text">1,000個（※コストメリットが最大化するのは10,000個以上）</p>
                    <br>
                    <p class="new-text fs-bold">特長とメリット</p>
                    <p class="new-text">市販のプラモデルや高級カプセルトイと全く同じ本格的な製法であり、シャープな輪郭線、エッジの効いた直線的なデザイン、微細なディテールの再現において右に出るものはありません。プラスチック特有の硬質で美しいツヤのある仕上がりや、均一な品質は3つの製法の中でトップクラスです。また、1回の成型サイクルが数秒〜数十秒と非常に短いため、金型さえ完成してしまえば大量生産を超高速で行うことができます。製作個数が10,000個を超えるような大ロット案件においては、1個あたりの単価を最も抑えることができる、最強の大量生産向け製法です。</p>
                    <br>
                    <p class="new-text fs-bold">得意な表現</p>
                    <p class="new-text">精密なメカニックデザイン、細かな文字が入ったパッケージのミニチュアなど、極めて高い再現度が求められるデザインに最適です。</p>
                    <br>
                    <div style="text-align:center; margin-top:10px;">
                        <a href="/products/injection.php" class="red-btn" style="text-align:center;">3D立体チャーム（インジェクション）のページへ</a>
                        <!-- <table width="710" style="margin-top:10px;">
                            <tr>
                                <td align="left"><a href="injection.html"><img src="img/charm_bnr3.webp" alt="インジェクション" width="230" height="124" /></a></td>
                            <tr>
                                <td align="left"><a href="injection.html" class="new-text">インジェクション</a></td>
                            <tr>
                        </table> -->
                    </div>
                </div>
            </div>

             <!-- Topic 4 -->
            <div>
                <div class="mt-20" id="fourth">
                    <h2 class="h2-default fs-bold">【目的・予算別】最適な製造方法を確信を持って選ぶシミュレーション</h2>
                </div>
                <br>
                <div>
                    <img src="/products/images/3d/3dcharm06.webp" alt="">
                </div>
                <br>
                <p class="new-text">前章で解説した3つの製法を踏まえ、お客様の目的や状況に応じた最適な選び方を具体的にシミュレーションしてみましょう。これで確信を持って最適な手法を選択していただけます。</p>

                <h3 class="h3-new fs-bold">パターンA：「予算を上手に活用して、100個くらいでボリューム感のあるノベルティを作りたい」</h3>
                <p class="new-text">おすすめなのは、半立体PVC貼り合わせです。限られた予算の中で、「厚み」や「ボリューム感」をしっかりと出してユーザーにインパクトを与えたい場合は、PVC貼り合わせが最適です。金型代が数万円程度とリーズナブルなため、小ロットでも予算内にすっきりと収めやすく、ラバー特有のポップな可愛らしさを存分に表現できます。</p>

                <h3 class="h3-new fs-bold">パターンB：「500〜1,000個の販売用グッズとして、本格的な立体のキャラクターフィギュアを作りたい」</h3>
                <p class="new-text">おすすめなのは、ポリレジンです。販売用として高いクオリティを担保しつつ、無駄のない適正な数量で効率よく展開したい場合は、ポリレジン一択となります。フィギュアのような丸みや立体感を美しく表現でき、簡易金型を用いるため初期費用も抑えられます。手作業の温もりを感じる仕上がりは、キャラクターの魅力を引き出し、ファンの心を掴みます。</p>
                
                <h3 class="h3-new fs-bold">パターンC：「全国チェーン店でのキャンペーン景品として、数万個規模で精密なミニチュアを作りたい」</h3>
                <p class="new-text">おすすめなのは、インジェクション（射出成型）です。商品のボトルやパッケージの精巧なミニチュアなど、小さな文字の視認性やエッジのシャープさが求められ、かつ数万個単位で大規模に展開したい場合はインジェクション製法です。初期の金型代はかかりますが、数万個で割れば1個あたりの負担はわずかになり、圧倒的なコストパフォーマンスと最高品質を両立できます。</p>
            </div>
            
             <!-- Topic 5 -->
            <div>
                <div class="mt-20" id="fifth">
                    <h2 class="h2-default fs-bold">理想を完璧に形にする！3Dチャームデザインデータ作成のコツ</h2>
                </div>
                <br>
                <div>
                    <img src="/products/images/3d/3dcharm07.webp" alt="">
                </div>
                <br>
                <p class="new-text">立体物を製作する場合、平面の印刷物とは異なる楽しいアプローチが待っています。スムーズに製作を進め、理想の仕上がりを実現するための重要なポイントを解説します。</p>
                <br>
                <p class="new-text">「正面のイラスト1枚しかない」「手書きのアイデアシートしかない」という場合でも大歓迎です！ホットモバイリーの専任スタッフが、長年の経験に基づき、立体化の最適なバランスをご提案いたします。</p>
                <h3 class="h3-new fs-bold">1.三面図（正面・側面・背面）の用意でさらにスムーズに</h3>
                <p class="new-text">可能であれば、キャラクターやアイテムの「正面」「横」「後ろ」から見たデザイン画（三面図）をご用意ください。これにより、モデラー（立体データを作成する職人）がお客様のイメージを正確かつ詳細に把握でき、スムーズかつスピーディーに理想の形へと仕上げることができます。</p>

                <h3 class="h3-new fs-bold">2.長く美しい状態を保つためのデザインアレンジ</h3>
                <p class="new-text">ポリレジンやPVCの場合、極端に細いパーツ（例：細い杖、髪の毛の毛先、独立した細い指など）は、長くご愛用いただくために耐久性を高める工夫が必要です。立体化する際は、あえて少し太くデフォルメして可愛らしさを強調したり、本体と一体化させる（くっつける）デザインにアレンジしたりすることで、いつまでも美しい状態を保つ丈夫な仕上がりになります。</p>
               
                <h3 class="h3-new fs-bold">3.自立する喜び（フィギュア用途の場合）</h3>
                <p class="new-text">チャームとしてぶら下げるだけでなく、机の上に置いて飾る（フィギュアとして楽しむ）ことも想定している場合は、足元や底面が平らになっているか、重心のバランスが取れていて自立するかどうかをデザイン段階で考慮すると、お客様の楽しみ方がさらに広がります。</p>
                
            </div>
            
             <!-- Topic 6 -->
            <div>
                <div class="mt-20" id="sixth">
                    <h2 class="h2-default fs-bold">ホットモバイリーが3Dチャーム製作で選ばれる4つの強み</h2>
                </div>
                <br>
                <div>
                    <img src="/products/images/3d/3dcharm08.webp" alt="">
                </div>
                <br>
                <p class="new-text">数あるオリジナルグッズ製作会社の中で、ホットモバイリーが多くのお客様から高い評価をいただき、リピートしていただいている理由をご紹介します。</p>
                <h3 class="h3-new fs-bold">1. 安全環境に配慮した高品質素材の採用（ATBC-PVC）</h3>
                <p class="new-text">ホットモバイリーでは、PVC（塩化ビニル）を使用する製品において、環境ホルモンとして懸念されるフタル酸エステル類を含まない「ATBC-PVC（非フタル酸PVC）」を標準採用しています。これにより、アパレルブランドのノベルティや、小さなお子様が手にする可能性のある教育機関向けのグッズとしても、世界基準の安全性と安心感をご提供しています（※半立体PVC貼り合わせのみ対応）。</p>

                <h3 class="h3-new fs-bold">2. 多彩なアタッチメント（取り付け金具・パーツ）で魅力アップ</h3>
                <p class="new-text">用途に合わせて、最適な取り付けパーツを自由にお選びいただけます。 定番のナスカン（キーホルダー金具）やボールチェーン、カニカン、マツバ紐など、ターゲットユーザーのライフスタイルに合わせて柔軟にカスタマイズ可能です。パーツの組み合わせ次第で、同じチャーム本体でも全く新しい魅力を持った商品へと生まれ変わります。</p>

                <h3 class="h3-new fs-bold">3. オリジナル台紙・パッケージのトータルサポートでブランド力向上</h3>
                <p class="new-text">グッズの魅力をさらに一段階引き立てる「オリジナル印刷の台紙（ヘッダー）」や、美しいOPP袋への封入作業もワンストップで承っております。店頭に並べる際のフック穴付きヘッダーや、世界観を伝える二つ折り台紙など、販売・配布の形態に合わせたパッケージングまで全てお任せください。箱を開けた瞬間にそのまま販売・配布できる、完成された状態でお届けします。</p>

                <h3 class="h3-new fs-bold">4. プロの専任スタッフによる徹底した伴走サポート</h3>
                <p class="new-text">「金型の仕組みを深く知って、より良いものを作りたい」「予算内でどこまでこだわれるか相談したい」という意欲的なご担当者様も大歓迎です。ホットモバイリーでは、グッズ製作の経験豊富な専任スタッフが、お客様のデザインやご要望をもとに、最適な製造手法のご提案から、魅力を高めるためのアドバイスまで徹底的にサポートいたします。海外の優れた提携工場との密な連携により、高品質・低価格・短納期を実現しています。</p>

                
            </div>

             <!-- Topic 7 -->
            <div>
                <div class="mt-20" id="seventh">
                    <h2 class="h2-default fs-bold">ご注文から納品まで、期待が高まる製作フロー</h2>
                </div>
                <br>
                <div>
                    <img src="/products/images/3d/3dcharm09.webp" alt="">
                </div>
                <br>
                <p class="new-text">実際にホットモバイリーで3Dチャームをご注文いただく際の製作の流れをご案内します。</p>
                <h3 class="h3-new fs-bold">1.お問い合わせ・お見積もり依頼</h3>
                <p class="new-text">ご希望の製法（未定でも構いません）、予定数量、デザインイメージ、希望納期をお知らせください。専任スタッフが、プロジェクトを成功に導く最適なプランとお見積りをご提示します。</p>

                <h3 class="h3-new fs-bold">2.デザインのすり合わせ・データ入稿</h3>
                <p class="new-text">イラストデータをご提出いただき、製造に適した立体化のバランスや、美しい印刷・塗装の仕様を楽しく調整していきます。</p>

                <h3 class="h3-new fs-bold">3.原型・サンプル（試作品）の確認で確かな手応えを</h3>
                <p class="new-text">実際の素材を使った原型、または試作品を製作します。お客様に実物や写真をご確認いただき、形状や色味の最終チェックを行います。徐々に形になっていく喜びを感じていただける工程です。</p>

                <h3 class="h3-new fs-bold">4.量産（本生産）</h3>
                <p class="new-text">サンプルに大満足いただいた後、いよいよ量産を開始します。厳格な品質管理基準のもと、工場にて一つひとつ丹精を込めて成型・塗装・組み立てが行われます。</p>

                <h3 class="h3-new fs-bold">5.検品・納品</h3>
                <p class="new-text">完成した製品は、丁寧な検品作業を経て、ご指定のパーツを取り付け、美しく個別包装を行い、お客様のもとへ大切にお届けします。</p>
                
            </div>

             <!-- Topic 8 -->
            <div>
                <div class="mt-20" id="eighth">
                    <h2 class="h2-default fs-bold">3Dチャーム製作に関するよくある質問（FAQ）</h2>
                </div>
                <br>

                <p class="new-text"><font color="blue">Q1.</font> アタッチメント（金具）を複数種類混ぜて発注することはできますか？</p>
                <p class="new-text"><font color="red">A1.</font>はい、大歓迎です！例えば、総ロット1,000個のご注文に対し、500個をナスカン金具、残り500個をボールチェーンにするといった、バリエーション豊かな対応も承っております。お見積り時にご希望の内訳をお知らせください。</p>
                <br>

                <p class="new-text"><font color="blue">Q2.</font>色味の指定は細かくできますか？</p>
                <p class="new-text"><font color="red">A2.</font>はい、可能です。PANTONEやDICなどのカラーコードでのご指定はもちろん、ターゲットとなるキャラクターの公式イラストや現物サンプルに色を近づけるための調色作業も丁寧に行います。お客様が思い描く鮮やかな色彩を忠実に再現いたします。</p>
                <br>

                <p class="new-text"><font color="blue">Q3.</font>納期はどのくらいかかりますか？</p>
                <p class="new-text"><font color="red">A3.</font> 製造方法やロット数によって異なりますが、目安として、最も早いPVC貼り合わせで約3〜4週間、ポリレジンで約4〜6週間、インジェクションの場合は1.5〜2ヶ月程度で完成いたします。イベント日などの明確な目標がある場合は、可能な限り最速のスケジュールをご提案いたしますので、ぜひお気軽にご相談ください。※ポリレジン、インジェクションの製法に関しましてはデザインによって大きく製作日数が変動いたします。</p>
            </div>

             <!-- Topic 9 -->
            <div>
                <div class="mt-20" id="nineth">
                    <h2 class="h2-default fs-bold">こだわりのオリジナル3Dチャーム製作はホットモバイリーへ！</h2>
                </div>
                <br>

                <p class="new-text">立体的な造形で圧倒的な存在感を放つ3Dチャームは、ファンや顧客の心を強く惹きつける、最高に魅力的なオリジナルグッズです。 本記事で解説したように、『半立体PVC貼り合わせ』『ポリレジン』『インジェクション』という3つの製造方法には、それぞれ素晴らしい個性と得意分野があります。これらをプロジェクトの目的や予算に合わせて的確に選択することが、グッズ製作を大成功に導く最大のポイントです。</p>

                <br>
                <p class="new-text">ホットモバイリーでは、長年のオリジナルグッズ製作で培ったノウハウと熱意をもって、お客様の「こんな素晴らしいものを作りたい！」というアイデアを、期待を超える最高の形に仕上げます。企画段階からのご相談、お見積りは無料で行っております。</p>

                <br>
                <p class="new-text">「自社のキャラクターを立体化するとどんな素敵なグッズになる？」「このデザインを一番魅力的に見せる製法はどれ？」など、少しでもご興味がございましたら、ぜひお気軽にホットモバイリーまでお問い合わせください。皆様の素晴らしいプロジェクトのお手伝いができることを、心より楽しみにしております！</p>
            </div>

        </div>
    </div>

    <?php include('../footer.php') ?>

</body>

<script>
    $(function() {

        let params = '<?php echo (isset($_GET['sec']) ? $_GET['sec'] : "") ?>';

        if (params != "") {
            GotoDiv(params, true);
        }
        // let replacements = {
        //     "アクリルキーホルダー": "https://hotmobily.jp/products/acrylic/",
        //     "ラバーストラップ": "https://hotmobily.jp/products/rubberstrap/",
        //     "ラバーキーホルダー": "https://hotmobily.jp/products/rubberkeyholder/",
        //     "リフレクター": "https://hotmobily.jp/products/reflecter.php",
        //     "リフレクターチャーム": "https://hotmobily.jp/products/reflecter.php",
        //     "ラバーコースター": "https://hotmobily.jp/products/rubbercoaster/",
        //     "マイクロファイバークロス": "https://hotmobily.jp/products/mki",
        //     "フライトタグ": "https://hotmobily.jp/products/flight_tag",
        //     "カラビナ": "https://hotmobily.jp/products/carabiner/",
        // };

        // $('#content_wrapper > div:not(.img-col):not(.swing)').each(function() {
        //     let html = $(this).html();

        //     $.each(replacements, function(text, url) {
        //         let regex = new RegExp(text, 'g');
        //         let link = `<a href="${url}" target="_blank">${text}</a>`;
        //         html = html.replace(regex, link);
        //     });

        //     $(this).html(html);
        // });

    });

    function shareByEmail() {
        const subject = "ベテラン営業パーソンが教える、学校・塾向けノベルティの最新動向";
        const body = `ベテラン営業パーソンが教える、学校・塾向けノベルティの最新動向 https://hotmobily.jp/lp/school-01.php`;

        const mailtoLink = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        window.open(mailtoLink, '_blank');
    }


    function GotoDiv(no, external_page = false) {
        let em = '';
        if (no != "") {
            if (!external_page) {
                if (no == 1) {
                    em = '#one';
                }

                if (no == 2) {
                    em = '#two';
                }

                if (no == 3) {
                    em = '#three';
                }

                if (no == 4) {
                    em = '#fourth';
                }

                if (no == 5) {
                    em = '#fifth';
                }

                if (no == 6) {
                    em = '#sixth';
                }

                if (no == 7) {
                    em = '#seventh';
                }

                if (no == 8) {
                    em = '#eighth';
                }

                if (no == 9) {
                    em = '#nineth';
                }

                if (no == 10) {
                    em = '#cupsuletoy';
                }

                if (no == 11) {
                    em = '#inhouse';
                }
            } else {
                em = '#' + no;
            }
        }

        if (em != "") {
            $("html, body").animate({
                scrollTop: $(em).offset().top - 100
            }, 1000);
        }
    }
</script>

</html>
