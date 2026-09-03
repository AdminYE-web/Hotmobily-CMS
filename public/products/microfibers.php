<?php

include_once('../common/SetUpLang.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="robots" content="noindex">
    <title>オリジナルマイクロファイバー製品の製作</title>
    <style type="text/css">
        .product {
            width: 99%;
            display: inline-block;
            border-top: 1px solid #f0f0f0;
            border-left: 1px solid #f0f0f0;
            border-right: 1px solid #dcdcdc;
            border-bottom: 3px solid #dcdcdc;
            margin-bottom: 10px;
        }

        .title2 {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            padding: 8px 0;
            text-align: center;
            background: #f0f0f0;
        }

        .row-bs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 10px;
        }

        .product a {
            color: #333 !important;
        }

        .name_pro {
            padding: 10px 15px;
            font-size: 16px;
            line-height: 24px;
        }

        .red_b {
            font-size: 20px;
            font-weight: bold;
            line-height: 28px;
            color: #e60012;
            padding: 5px 0;
        }

        .tag {
            font-size: 12px;
            color: #333;
            font-weight: normal;
            float: left;
            padding: 0 6px;
            margin: 10px 6px 10px 0;
            border-radius: 15px;
            background: #f0f0f0;
        }

        .size {
            font-size: 12px;
            line-height: 20px;
            clear: both;
        }

        .product a:hover {
            text-decoration: none;
            opacity: 0.7;
        }

        @media screen and (max-width: 768px) {
            .row-bs {
                display: block;
                width: 99%;
            }

            .product {
                width: 100%;
            }

            .product img {
                width: 100%;
            }
        }

        <?= ($_SESSION['lang'] == "kr" ? 'body{font-family: "돋움체",DotumChe,serif!important;}#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}.prodate,.q-detail,.tab-label{font-family: "돋움체",DotumChe,serif!important;}' : '') ?><?= ($_SESSION['lang'] == "th" ? 'body{font-family: "Prompt", sans-serif!important;}#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}.prodate,.q-detail,.tab-label{font-family: "Prompt", sans-serif!important;}' : '') ?>
    </style>

    <style type="text/css">
        .info_box2 {
            margin-top: 0 !important;
        }

        div.info_box2 {
            margin-bottom: 10px;
            background-color: #fff;
            border: #900 2px solid;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
        }

        #info_div div.info_box2 h2 {
            margin: 12px 5px !important;
            color: #333 !important;
            font-size: 15px !important;
            background: none !important;
            line-height: 20px !important;
            margin-top: 12px !important;
            text-align: center !important;
            letter-spacing: 0.05em !important;
        }

        div.info_box2 p {
            font-size: 13px !important;
            padding: 0px 10px 10px 5px !important;
        }

        .fa{
            margin: 0;
        }

        .fav{
            font-size: large !important;
            font-weight: bold !important;
        }

        .info_box2 h2 a {
            color: red;
        }

        .strong {
            color: red;
            font-weight: bold;
            font-size: 16px;
        }

        #info_disp h1{
            display: none;
        }

        @media (max-width: 576px) {
            .quo_table_in.pk_tbl td {
            width: 100% !important;
            margin-bottom: 10px;
            }

            .info_box2 a {
            font-size: 0.65rem;
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

        <?php $prd_cloth="1";include('../sidenavi.php'); ?>
        <!-- sidemenu End -->

        <!-- :: content_wrapper start :: -->
        <div id="content_wrapper">
            <?php //include('../global_news.html'); ?>

            <!-- <?php if(date('Y-m-d') < date('2026-08-05')): ?>
                <div class="info_box2">
                    <h2 class="fa" align="center">
                        <a class="fav" href="javascript:void(0)" onclick="$('#info_disp').slideToggle();">8月1日～8月5日まで夏季休業</a>
                    </h2>
                </div>
            <?php endif; ?> -->

            <?php include('banner-campaign.php') ?>
            <h1><?= lang('マイクロファイバーグッズ') ?></h1><br />
            <div class="row-bs">
                <div class="product">
                    <!-- <div class="title2">当店一番人気</div> -->
                    <a href="/products/cloth.php">
                        <img src="img/cloth_new_05.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('メガネクリーナー') ?></b>

                            <div class="red_b">1<?= lang('枚') ?> 44円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>オリジナルサイズ：お客様指定サイズ<br/>規定サイズ') ?>：150mm×150mm/150mm×180mm
                            </div>
                        </div>
                    </a>
                </div>
                <div class="product">
                    <!-- <div class="title2">簡易防水機能つき</div> -->
                    <a href="/products/pouch.php">
                        <img src="img/microfibers-pouch.webp" width="245" height="210">
                        <br />
                        <div class="name_pro">
                            <b><?= lang('マイクロファイバーポーチ') ?></b>

                            <div class="red_b">1<?= lang('枚') ?> 209円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>オリジナルサイズ：お客様指定サイズ<br/>規定サイズ') ?>：90mm×180mm/100mm×180mm
                            </div>
                        </div>
                    </a>
                </div>
                <div class="product">
                    <!-- <div class="title2">高品質・高機能製品</div> -->
                    <a href="/products/mousepad.html">
                        <img src="img/microfibers-mousepad.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('マイクロファイバーマウスパッド') ?></b>

                            <div class="red_b">1<?= lang('枚') ?> 209円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>オリジナルサイズ：お客様指定サイズ<br/>規定サイズ') ?>：175mm×230mm
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row-bs">
                <div class="product">
                    <a href="/products/mki">
                        <img src="img/mki_pic_18.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('マイクロファイバークロス スウェード生地') ?></b>
                            <div class="red_b">1<?= lang('枚') ?> 99円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>規定サイズ:<br/>') ?>：150mm×150mm/150mm×180mm
                            </div>
                        </div>
                    </a>
                </div>
                <div class="product">
                    <a href="/products/slm">
                        <img src="img/mki_pic_19.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('マイクロファイバークロス  100％リサイクルポリエステル') ?></b>
                            <div class="red_b">1<?= lang('枚') ?> 150円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>規定サイズ:<br/>') ?>：150mm×150mm/150mm×180mm
                            </div>
                        </div>
                    </a>
                </div>
                <div class="product">
                    <!-- <div class="title2">簡易防水機能つき</div> -->
                    <a href="/products/recycle-cloth.php">
                        <img src="img/microfibers-recycle-cloth.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('メガネクリーナー（リサイクル原糸）') ?></b>

                            <div class="red_b">1<?= lang('枚') ?> 92円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>オリジナルサイズ：お客様指定サイズ<br/>規定サイズ') ?>：150mm×150mm/150mm×180mm
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row-bs">
                <div class="product">
                    <!-- <div class="title2">当店一番人気</div> -->
                    <a href="/products/glass-box.html">
                        <img src="img/microfibers-glass-box.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('マイクロファイバーメガネケース') ?></b>

                            <div class="red_b">1<?= lang('個') ?> 349円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>
                            <div class="size">
                                <?= lang('サイズ<br/>規定サイズ') ?>：W160mmxH60mmxD40mm
                            </div>
                        </div>
                    </a>
                </div>
                <div class="product">
                    <!-- <div class="title2">高品質・高機能製品</div> -->
                    <a href="/products/microfiber.html">
                        <img src="img/microfibers.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('メガネクリーナー（裏面タオル地）') ?></b>

                            <div class="red_b">1<?= lang('枚') ?> 176円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">9<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>オリジナルサイズ：お客様指定サイズ<br/>規定サイズ') ?>：150mm×150mm/150mm×180mm
                            </div>
                        </div>
                    </a>
                </div>
                <div class="product">
                    <!-- <div class="title2">当店一番人気</div> -->
                    <a href="/products/towel.html">
                        <img src="img/microfibers-towel.webp" width="245" height="210"><br />
                        <div class="name_pro">
                            <b><?= lang('マイクロファイバータオル') ?></b>
                            <div class="red_b">1<?= lang('枚') ?> 220円～</div>
                            <div class="size"><?= lang('予算感：お買い得') ?></div>

                            <div class="tag">10<?= lang('営業日') ?></div>

                            <div class="size">
                                <?= lang('サイズ<br/>オリジナルサイズ：お客様指定サイズ<br/>規定サイズ') ?>：200mm×1000mm/400mm×700mm
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <style>
                .d-flex {
                    display: flex;
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
            </style>
            <h2 class="text-info">この商品に関する記事</h2>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/blog-content/promotional-giveaway-1"><img src="/blog-content/upload/202308241733194642.png" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/blog-content/promotional-giveaway-1">人気の法人ノベルティは何？注意点と効果を最大化させるための工夫</a>
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
            <div>&nbsp;</div>
            <div class="d-flex">
                <div class="flex-item w-30">
                    <a class="unlink" href="/blog-content/microfiber-towel"><img src="/blog-content/upload/202312271219267059.jpg" class="w-100"></a>
                </div>
                <div class="flex-item w-70">
                    <a class="unlink" href="/blog-content/microfiber-towel">マイクロファイバーとコットンタオルの違いは？</a>
                </div>
            </div>
            <div>&nbsp;</div>
        </div>
        <!-- :: content_wrapper end :: -->
    </div>
    <!-- :: wrapper end :: -->

    <!--フッター ここから-->
    <?php include('../footer.php'); ?>
    <!--フッター ここまで-->
    <script src="js/cloth_calendar.js?v=1.14"></script>
</body>

</html>