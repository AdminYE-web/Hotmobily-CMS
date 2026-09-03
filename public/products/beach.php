<?php
session_start();
//require_once('../blog/wp-load.php');
include_once('../common/SetUpLang.php');
include("../connect_db/Control_Connect.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="オリジナル,ビーチサンダル,製作,オーダー,特注,1足">
  <meta name="description" content="オリジナルビーチサンダルを製作しています。1足よりご注文可。フルカラー印刷で、ご希望のデザインでオーダーメイド。">
  <meta name="robots" content="index,follow">
  <!-- <link href="/products/css/boxshow.css?v=1.10" rel="stylesheet" type="text/css" /> -->
  <link href="/products/css/boxshowshoes.css?v=1.17" rel="stylesheet" type="text/css" />
  <title>オリジナルビーチサンダルの製作。1足よりご注文可 HOTMOBILYオリジナルグッズ</title>
  <link href="/products/css/box-shadow.css?v=1.02" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/campaign/css/all.css">
  <link rel="stylesheet" type="text/css" href="/products/css/product_group.css?v=1.13">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
  <!-- :: header start :: -->
  <?php include('../head_products.html'); ?>
  <!-- :: header end :: -->

  <link href="/products/css/calendar.css" rel="stylesheet" type="text/css" />
  <!--<script language="JavaScript" type="text/javascript"> 
 Overture K.K. window.ysm_customData = new Object(); window.ysm_customData.conversion = "transId=,currency=,amount="; var ysm_accountid  = "1C8AE9TA2V1IGBU2QBLAVUASHCO"; document.write("<SCR" + "IPT language='JavaScript' type='text/javascript' "  + "SRC=//" + "srv2.wa.marketingsolutions.yahoo.com" + "/script/ScriptServlet" + "?aid=" + ysm_accountid  + "></SCR" + "IPT>");
</script>-->
  <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
  <!-- lightbox2-master -->
  <link rel="stylesheet" href="css/lightbox.css">
  <style type="text/css">
    .txt_sp {
      color: red;
      display: none;
      animation: txt infinite;
      animation-duration: 1s;
    }

    #botm_txt {
      font-size: 12px;
      line-height: 30px;
      display: none;
      text-align: center;
    }
   .button {
    letter-spacing: 0;
    font-feature-settings: normal;
}
.side_link{
  letter-spacing: 0;
    font-feature-settings: normal;
}
    .f14 {
      font-size: 14px;
    }

    /* Safari 4.0 - 8.0 */
    @-webkit-keyframes txt {
      from {
        color: red;
      }

      to {
        color: white;
      }
    }

    /* Standard syntax */
    @keyframes txt {
      from {
        color: red;
      }

      to {
        color: white;
      }
    }

    .left {
      margin-left: 0 !important;
    }

    .right {
      padding: 0 !important;
    }

    .splide__track {
      padding: 5px 0;
    }

    .splide__slide {
      list-style: none;
      text-align: center;
    }

    .splide__slide a img {
      transition: all 0.2s ease-in-out;
      transition-duration: 0.2s;
      width: 90%;
      border-radius: 8px;
      border: 3px solid #dbdbda;
    }

    .splide__slide a:hover img {
      border: 3px solid #ff8000;
    }

    .splide__arrow--next {
      right: 0;
    }

    .splide__arrow--prev {
      left: 0;
    }

    .new-text{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }

    @media(max-width: 768px) {

      .d_TEXT1,
      .d_TEXT1-2 {
        margin-right: 0;
      }
    }
  </style>
  <!-- /lightbox2-master -->
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
      <h1>オリジナルビーチサンダルの製作。1足よりご注文可(2025年版)</h1>
      <div class="social-time">
        <span class="social-content">
          <a href="mailto:?subject=オリジナルビーチサンダルの製作。1足よりご注文可。&amp;body=オリジナルビーチサンダルを製作しています。1足よりご注文可。フルカラー印刷で、ご希望のデザインでオーダーメイド。:https://hotmobily.jp/products/beach" title="Share by Email" target="_blank">シェアする</a><a href="mailto:?subject=オリジナルビーチサンダルの製作。1足よりご注文可。&amp;body=オリジナルビーチサンダルを製作しています。1足よりご注文可。フルカラー印刷で、ご希望のデザインでオーダーメイド。:https://hotmobily.jp/products/beach" title="Share by Email" target="_blank"><i class="far fa-envelope"></i></a>
          <a href="https://www.facebook.com/share.php?u=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fbeach" target="_blank"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.twitter.com/share?url=https%3A%2F%2Fwww.hotmobily.jp%2fproducts%2fbeach&amp;text=オリジナルビーチサンダルを製作しています。1足よりご注文可。フルカラー印刷で、ご希望のデザインでオーダーメイド。" target="_blank"><i class="fab fa-twitter-square"></i></a>
        </span>
        <span class="time-content">更新日 2026年8月3日</span>
      </div>
      <table class="cld_tb" style="width: -webkit-fill-available;">
        <tr class="cld_head">
          <td colspan="2">今、この製品を製作開始した場合の出荷日を表示中</td>
        </tr>
        <tr class="cld_r1">
          <td>製作開始日時</td>
          <td>出荷予定</td>
        </tr>
        <tr class="cld_r2">
          <td><span id="date_create"></span></td>
          <td><span id="date_create2"></span></td>
        </tr>
      </table>
      <div style="clear:both;">&nbsp;</div>
      <h2>オリジナルのデザインを印刷した、ビーチサンダルが作成できます</h2>
      <p class="d_TEXT1 new-text">
        ビーチサンダルの表面に、オリジナルのデザインを名入れプリントした、オーダーメイドのビーチサンダルが、小ロット1足から製造できます。夏に盛んなイベントや行事の記念品・ノベルティ製品として、OEM製造致します。オーダーメイド製品でも激安価格を維持し、お求め安くなっております。
      </p>

      <table width="750" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" class="d_TEXT1" align="center">
            <a href="img/beach_img01.jpg" data-lightbox="beach1-set" style="text-decoration:none;">
              <img src="img/beach_01.webp" width="345" height="240" />
            </a>
          </td>
          <td valign="top" class="d_TEXT1" align="center">
            <a href="img/beach_img02.jpg" data-lightbox="beach1-set" style="text-decoration:none;">
              <img src="img/beach_02.webp" width="345" height="240" />
            </a>
          </td>
        </tr>
        <tr>
          <td valign="top" class="d_TEXT1" align="center">
            <a href="img/beach_img03.jpg" data-lightbox="beach1-set" style="text-decoration:none;">
              <img src="img/beach_03.webp" width="345" height="240" />
            </a>
          </td>
          <td align="center">
            <a href="img/beach_img04.jpg" data-lightbox="beach1-set" style="text-decoration:none;">
              <img src="img/beach_04.webp" width="345" height="240" />
            </a>
          </td>
        </tr>
        <tr>
          <td style="font-size:10px;">
            <a href="img/beach_img01.jpg" data-lightbox="beach1-set_text" style="text-decoration:none;">📷クリックすると拡大します</a>
            <a href="img/beach_img02.jpg" data-lightbox="beach1-set_text" style="text-decoration:none;"></a>
            <a href="img/beach_img03.jpg" data-lightbox="beach1-set_text" style="text-decoration:none;"></a>
            <a href="img/beach_img04.jpg" data-lightbox="beach1-set_text" style="text-decoration:none;"></a>
          </td>
        </tr>
      </table>


      <hr>
      <h2>オリジナルビーチサンダル製作事例</h2>
      <div class="splide">
        <div class="splide__track">
          <ul class="splide__list">
            <li class="splide__slide">
              <a href="slideimg/beach01.jpg" data-lightbox="beach2-set" style="text-decoration:none;">
                <img src="slideimg/beach01_s.webp" alt="" width="231" height="173">
              </a>
            </li>
            <li class="splide__slide">
              <a href="slideimg/beach02.jpg" data-lightbox="beach2-set" style="text-decoration:none;">
                <img src="slideimg/beach02_s.webp" alt="" width="231" height="173">
              </a>
            </li>
            <li class="splide__slide">
              <a href="slideimg/beach03.jpg" data-lightbox="beach2-set" style="text-decoration:none;">
                <img src="slideimg/beach03_s.webp" alt="" width="231" height="173">
              </a>
            </li>
            <li class="splide__slide">
              <a href="slideimg/beach04.jpg" data-lightbox="beach2-set" style="text-decoration:none;">
                <img src="slideimg/beach04_s.webp" alt="" width="231" height="173">
              </a>
            </li>
            <li class="splide__slide">
              <a href="slideimg/beach05.jpg" data-lightbox="beach2-set" style="text-decoration:none;">
                <img src="slideimg/beach05_s.webp" alt="" width="231" height="173">
              </a>
            </li>
            <li class="splide__slide">
              <a href="slideimg/beach06.jpg" data-lightbox="beach2-set" style="text-decoration:none;">
                <img src="slideimg/beach06_s.webp" alt="" width="231" height="173">
              </a>
            </li>
          </ul>
        </div>
      </div>
      <hr>
      <h2>オリジナルビーチサンダルの利用例</h2>
      <p class="d_TEXT1 new-text"><span class="listleft">●</span> 地域のイベントや行事の記念品、ノベルティ製品として<br />
        <span class="listleft">●</span> 夏の旅行やレジャーに向けて、オリジナルのデザインをプリントして<br />
        <span class="listleft">●</span> 店舗名前を印刷した、夏季新商品として<br />
        <span class="listleft">●</span> 会社ロゴや名前を入れ、企画の広告を兼ねた販促品として
      </p>

      <hr>
      <h2>仕様</h2>
      <table width="710" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process" style="margin-top:15px;">
        <tr>
          <td>材質</td>
          <td>本体：ゴム　　　鼻緒：プラスチック</td>
        <tr>
          <td>サイズ</td>
          <td>S、M、Lの3種(S:25cm, M:27cm, L:29cm)、お子様用のサイズ（S、M、L）もございます。</td>
        <tr>
        <tr>
          <td>厚さ</td>
          <td>約15mm</td>
        <tr>
        <tr>
          <td>重量</td>
          <td>250g(両足)、370g(型枠込み)</td>
        <tr>
          <td>最低製作個数</td>
          <td>1足</td>
        <tr>
          <td>色</td>
          <td>本体表面：フルカラー　　裏面：黒色　　鼻緒：黒色、赤色、青色</td>
        <tr>
        <tr>
        <tr>
          <td>デザイン</td>
          <td>アドビイラストレータでのご入稿</td>
        <tr>
          <td>包装</td>
          <td>OPP個別包装</td>
        <tr>
      </table>
      <div style="margin-top:20px;" class="taizen_b_txt new-text">オリジナルビーチサンダルの構造</div>
      <!-- <div align="center" style="margin-top:10px;"><img src="img/beach_illust.jpg" width="700" height="237" /></div>   -->
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/sandals-green_z.jpg" data-lightbox="sandals-rg" style="text-decoration:none;">
              <img src="img/sandals-green.webp" width="350" height="242">
            </a>
          </td>
          <td>
            <a href="img/sandals-red_z.jpg" data-lightbox="sandals-rg" style="text-decoration:none;">
              <img src="img/sandals-red.webp" width="350" height="242">
            </a>
          </td>
        </tr>
        <tr>
          <td style="font-size:10px;">
            <a href="img/sandals-green_z.svg" data-lightbox="sandals-text_rg" style="text-decoration:none;">📷クリックすると拡大します</a>
            <a href="img/sandals-red_z.jpg" data-lightbox="sandals-text_rg" style="text-decoration:none;"></a>
          </td>
        </tr>
      </table>
      <div style="margin-top:20px;" class="taizen_b_txt new-text">オリジナルビーチサンダルの寸法</div>
      <div style="margin-top:20px; padding-left:60px; color:red;" class="new-text">同一デザインであれば、複数サイズの組み合わせが可能です。</div>
      <div style="margin-top:5px; padding-left:60px; color:red;font-size: 11px;" class="new-text">※1サイズにつき50足以上で組み合わせ出来ます。</div>
      <!-- <div align="center" style="margin-top:10px;"><img src="img/beach_size.png" width="700" height="318" /></div> -->
      <!-- adults -->
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/adult_L_Z.jpg" data-lightbox="sandals-set" style="text-decoration:none;">
              <img src="img/adult_L.webp" width="225" height="230">
            </a>
          </td>
          <td>
            <a href="img/adult_M_Z.jpg" data-lightbox="sandals-set" style="text-decoration:none;">
              <img src="img/adult_M.webp" width="225" height="230">
            </a>
          </td>
          <td>
            <a href="img/adult_S_Z.jpg" data-lightbox="sandals-set" style="text-decoration:none;">
              <img src="img/adult_S.webp" width="225" height="230">
            </a>
          </td>
        </tr>
      </table>
      <!-- child -->
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/child_L_Z.jpg" data-lightbox="sandals-set" style="text-decoration:none;">
              <img src="img/child_L.webp" width="225" height="230">
            </a>
          </td>
          <td>
            <a href="img/child_M_Z.jpg" data-lightbox="sandals-set" style="text-decoration:none;">
              <img src="img/child_M.webp" width="225" height="230">
            </a>
          </td>
          <td>
            <a href="img/child_S_Z.jpg" data-lightbox="sandals-set" style="text-decoration:none;">
              <img src="img/child_S.webp" width="225" height="230">
            </a>
          </td>
        </tr>
        <tr>
          <td style="font-size:10px;">
            <a href="img/adult_L_Z.jpg" data-lightbox="sandals-set_text" style="text-decoration:none;">📷クリックすると拡大します</a>
            <a href="img/adult_M_Z.jpg" data-lightbox="sandals-set_text" style="text-decoration:none;"></a>
            <a href="img/adult_S_Z.jpg" data-lightbox="sandals-set_text" style="text-decoration:none;"></a>
            <a href="img/child_L_Z.jpg" data-lightbox="sandals-set_text" style="text-decoration:none;"></a>
            <a href="img/child_M_Z.jpg" data-lightbox="sandals-set_text" style="text-decoration:none;"></a>
            <a href="img/child_S_Z.jpg" data-lightbox="sandals-set_text" style="text-decoration:none;"></a>
          </td>
        </tr>
      </table>
      <hr>
      <h2>メッセージを足跡で残せるビーチサンダル</h2>
      <!-- <div align="center" style="margin-top:10px;"><img src="img/beach_message.jpg" width="700" height="300" /></div> -->
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/sandals_text-1_z.jpg" data-lightbox="sandals-text" style="text-decoration:none;">
              <img src="img/sandals_text-1.webp" width="233" height="280">
            </a>
          </td>
          <td>
            <a href="img/sandals_text-2_z.jpg" data-lightbox="sandals-text" style="text-decoration:none;">
              <img src="img/sandals_text-2.webp" width="233" height="280">
            </a>
          </td>
          <td>
            <a href="img/sandals_text-3_z.jpg" data-lightbox="sandals-text" style="text-decoration:none;">
              <img src="img/sandals_text-3.webp" width="233" height="280">
            </a>
          </td>
        </tr>
        <tr>
          <td style="font-size:10px;">
            <a href="img/sandals_text-1_z.jpg" data-lightbox="sandals-text_orange" style="text-decoration:none;">📷クリックすると拡大します</a>
            <a href="img/sandals_text-2_z.jpg" data-lightbox="sandals-text_orange" style="text-decoration:none;"></a>
            <a href="img/sandals_text-3_z.jpg" data-lightbox="sandals-text_orange" style="text-decoration:none;"></a>
          </td>
        </tr>
      </table>
      <p class="d_TEXT1 new-text">
        ビーチサンダルの底面に溝を彫ることで、砂にメッセージを残すことができます。裏面に彫るメッセージの内容は、もちろんオリジナルで製作できます。裏面にメッセージを入れる、裏面名入れには別途費用がかかります。詳細は<a href="../contact/index.php">お問い合わせ</a>下さい。
        ※こちらの加工は300個以上のご注文よりご提案できます。溝加工製作料金は製品単価220円増（税込）となります。
      </p>
      <hr>
      <h2>黒色ゴム以外のビーチサンダルの製作</h2>
      <p class="d_TEXT1 new-text">黒色以外のゴム色での製作が可能です。600足以上からの製作で、製作単価165円（税込）増となります。（標準価格のビーチサンダルは、全て黒色ゴムとなります。）</p>
      <hr>
      <h2>ご注文方法</h2>
      <table width="700" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td width="29" valign="top"><span class="blit_nums">1.</span></td>
          <td width="570" colspan="2" class="d_TEXT1 new-text"><span class="blit_nums">デザインの作成、ご入稿</span>
            <p>製作されるデザインのご入稿をお願い致します。デザインはアドビイラストレータファイルでお送り頂くと、最も速く確認作業が完了します。
              <a href="download/download.php?fname=枠なしテンプレート.zip">枠なしテンプレート</a>、<a href="download/download.php?fname=枠ありテンプレート.zip">枠ありテンプレート</a>を参考に、製品のデザインを作成して下さい。PSDやJPEG、PDF、手書きの原稿などイラストレータファイル以外の場合、製品の大きさの情報も記載してください。
            </p>
          </td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="2" class="d_TEXT1">&nbsp;</td>

        </tr>
        <tr>
          <td valign="top"><span class="blit_nums">2.</span></td>
          <td colspan="2" valign="top" class="d_TEXT1 new-text">
            <p><span class="blit_nums" id="blit">鼻緒部分の色を選択</span>&nbsp;<span class="blit_nums txt_sp">キャンペーン中</span><br />
              鼻緒の色は黒色が標準となります。下記のように別途青色や赤色などもご指定頂くことが可能です。黒色以外の鼻緒の色は、パントーン番号(PANTONE番号)でご指定下さい。
              鼻緒の特色は、100足以上からのご注文をお願いします。鼻緒の色の指定は製品単価+66円（税込）にて手配させていただけます。</p>
            <p>&nbsp;</p>
            <table width="600" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process">
              <tr align="center">
                <td>黒色</td>
                <td>青色</td>
                <td>赤色</td>
              </tr>
              <tr align="center" valign="middle">
                <td><img src="img/beach_black.webp" alt="" width="132" height="87" /></td>
                <td><img src="img/beach_blue.webp" alt="" width="132" height="87" /></td>
                <td><img src="img/beach_red.webp" alt="" width="132" height="87" /></td>
              </tr>
            </table>
            <p>&nbsp;</p>
          </td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="2" valign="top" class="d_TEXT1">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><span class="blit_nums">3.</span></td>
          <td colspan="2" valign="top" class="d_TEXT1 new-text"><span class="blit_nums">オリジナルビーチサンダルの製作イメージ</span><br /><br />
            <img src="img/beach_design.webp" width="648" height="264">
            <font color="#f00"><br />
          </td>
        </tr>
      </table>
      <hr>
      <h2>製作料金</h2>
      <div class="tbl_s">
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr valign="top" class="process">
            <td colspan="2">
              <p class="f14 new-text">下記の料金は、該当個数の製品をご注文された場合の製品単価（税込）です。本製作料金には、製品版型代金、製品配送代金、試作品配送1回、が含まれております。</p>
              <p class="red f14 new-text">※100足以下のご注文は試作品の製作は承れません。</p>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" align="left" valign="top">
              <table border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process" style="margin-left:0px;width: 100%;">
                <tr>
                  <td align="center" width="">&nbsp;</td>
                  <td align="center" bgcolor="#EFEFEF" width="">1-2足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">3～9足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">10足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">20足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">30足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">40足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">50足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">100足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">300足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">500足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">1,000足</td>
                </tr>
                <tr>
                  <td align="center">型枠あり</td>
                  <td align="center" bgcolor="#EFEFEF">4,070円</td>
                  <td align="center" bgcolor="#EFEFEF">3,520円</td>
                  <td align="center" bgcolor="#EFEFEF">2,970円</td>
                  <td align="center" bgcolor="#EFEFEF">2,970円</td>
                  <td align="center" bgcolor="#EFEFEF">2,310円</td>
                  <td align="center" bgcolor="#EFEFEF">2,310円</td>
                  <td align="center" bgcolor="#EFEFEF">1,870円</td>
                  <td align="center" bgcolor="#EFEFEF">1,738円</td>
                  <td align="center" bgcolor="#EFEFEF">1,408円</td>
                  <td align="center" bgcolor="#EFEFEF">1,243円</td>
                  <td align="center" bgcolor="#EFEFEF">1,095円</td>
                </tr>
                <tr>
                  <td align="center">型枠なし</td>
                  <td align="center" bgcolor="#EFEFEF">3,850円</td>
                  <td align="center" bgcolor="#EFEFEF">3,300円</td>
                  <td align="center" bgcolor="#EFEFEF">2,750円</td>
                  <td align="center" bgcolor="#EFEFEF">2,750円</td>
                  <td align="center" bgcolor="#EFEFEF">2,090円</td>
                  <td align="center" bgcolor="#EFEFEF">2,090円</td>
                  <td align="center" bgcolor="#EFEFEF">1,650円</td>
                  <td align="center" bgcolor="#EFEFEF">1,518円</td>
                  <td align="center" bgcolor="#EFEFEF">1,188円</td>
                  <td align="center" bgcolor="#EFEFEF">1,111円</td>
                  <td align="center" bgcolor="#EFEFEF">913円</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr valign="top" class="process">
            <td colspan="2" class="f14 new-text">※上記製品単価は製品単価（税込）です。</td>
          </tr>
          <tr valign="top" class="process">
            <td colspan="2">
              <p class="f14 new-text" style="margin-top:10px;"><strong>◎300足、型枠なしでご注文の場合</strong></p>
              <p class="f14 new-text" style="margin-top:10px;"><span class="faq_q_txt">1,188円(単価)X300足(数量)=356,400円</span></p>
            </td>
          </tr>
        </table>
      </div>
      <hr>
      <h2 style="margin-top:15px;">試作品納期</h2>
      <div class="tbl_s">
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td nowrap="nowrap" align="left" valign="top">
              <table border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process" style="margin-left:0px;width: 100%;">
                <tr>
                  <td align="center" width="">&nbsp;</td>
                  <td align="center" bgcolor="#EFEFEF" width="">1-2足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">3～9足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">10足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">20足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">30足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">40足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">50足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">100足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">300足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">500足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">1,000足</td>
                </tr>
                <tr>
                  <td align="center">型枠あり</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                </tr>
                <tr>
                  <td align="center">型枠なし</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">-</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr valign="top" class="process">
            <td colspan="2">
              <p class="f14 new-text">日数は全て営業日。</p>
              <p class="f14 new-text">営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。中国春節、国慶節期間につきましては、別途定める休日が指定されます。</p>
              <p class="red f14 new-text">※100足以下のご注文は試作品の製作は承れません。</p>
              <p class="f14 new-text">※配送に別途+3日程度頂いております。</p>
            </td>
          </tr>
        </table>
      </div>
      <hr>
      <h2 style="margin-top:15px;">量産品納期</h2>
      <div class="tbl_s">
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td nowrap="nowrap" align="left" valign="top">
              <table border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC" class="process" style="margin-left:0px;width: 100%;">
                <tr>
                  <td align="center" width="">&nbsp;</td>
                  <td align="center" bgcolor="#EFEFEF" width="">1-2足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">3～9足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">10足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">20足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">30足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">40足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">50足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">100足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">300足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">500足</td>
                  <td align="center" bgcolor="#EFEFEF" width="">1,000足</td>
                </tr>
                <tr>
                  <td align="center">型枠あり</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">10</td>
                  <td align="center" bgcolor="#EFEFEF">15</td>
                  <td align="center" bgcolor="#EFEFEF">15</td>
                  <td align="center" bgcolor="#EFEFEF">20</td>
                  <td align="center" bgcolor="#EFEFEF">25</td>
                </tr>
                <tr>
                  <td align="center">型枠なし</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">5</td>
                  <td align="center" bgcolor="#EFEFEF">10</td>
                  <td align="center" bgcolor="#EFEFEF">15</td>
                  <td align="center" bgcolor="#EFEFEF">15</td>
                  <td align="center" bgcolor="#EFEFEF">20</td>
                  <td align="center" bgcolor="#EFEFEF">25</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr valign="top" class="process">
            <td colspan="2">
              <p class="f14 new-text">日数は全て営業日。</p>
              <p class="f14 new-text">営業日とは、平日及び土曜日、祝日を含み、日曜日を除きます。中国春節、国慶節期間につきましては、別途定める休日が指定されます。</p>
              <p class="f14 new-text">※配送に別途+3日程度頂いております。</p>
            </td>
          </tr>
        </table>
      </div>
      <hr>
      <h2 style="margin-top:15px;">ご注意ください</h2>
      <table width="710" border="0" cellspacing="2" cellpadding="0">
        <tr valign="top" class="process">
          <td>
            <font color="red" class="f14 new-text">
              ※製品印刷位置が、ご注文時にご提出致します製品完成図と比べて、上下左右に最大15mm程度異なる場合がございます。これは昇華転写印刷という印刷手法上避けられない問題です。この印刷ズレは品質保証の対象とはなりませんので、予めご了解の上、ご注文下さい。
            </font><br />
            <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
              <tr>
                <td>
                  <a href="img/sampleA_Z.svg" data-lightbox="sandals-sample" style="text-decoration:none;">
                    <img src="img/sampleA.webp" width="233" height="238">
                  </a>
                </td>
                <td>
                  <a href="img/sampleB_Z.svg" data-lightbox="sandals-sample" style="text-decoration:none;">
                    <img src="img/sampleB.webp" width="233" height="238">
                  </a>
                </td>
              </tr>
              <tr valign="top">
                <td><a href="img/sampleA_Z.svg" data-lightbox="sandals-text_AB" style="text-decoration:none;">📷印刷ズレの影響（確認しやすい）を受けやすいデザイン例</a></td>
                <td><a href="img/sampleB_Z.svg" data-lightbox="sandals-text_AB" style="text-decoration:none;">📷印刷ズレの影響（確認しにくい）を受けにくいデザイン例<br />
                    ※印刷ズレがない、少ない、という意味ではございません。</a></td>
              </tr>
            </table>
            <p class="f14 new-text">
              ※写真等のデザインは綺麗に印刷されません。印刷するデザインは、アドビイラストレータで作成頂くことをお勧め致します。<br />
              ※必ず弊社サンプル品で、印刷鮮明度のご確認をお願いします。
            </p>

            <a href="./beach_quality.php"><img src="images/beach_quality_banner.webp"></a>
          </td>
        </tr>
      </table>
      <hr>
      <h2>製作事例のご紹介</h2>
      <p class="d_TEXT1 new-text">
        オーダーメイドビーチサンダルの製作事例をご紹介。ノベルティ用、メッセージ入り、子供用等、これまでの製作事例の一部をご紹介致します。全商品、オーダーメイドのデザインをプリントしたオリジナルの製品です。</p>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh_beach04.webp" data-zoom-src="images/image_sh_beach04_zoom.jpg" id="sh-i1" width="100%" height="258" style="">
            <img src="images/image_sh_beach02.webp" data-zoom-src="images/image_sh_beach02_zoom.jpg" id="sh-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh_beach03.webp" data-zoom-src="images/image_sh_beach03_zoom.jpg" id="sh-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh_beach01.webp" data-zoom-src="images/image_sh_beach01_zoom.jpg" id="sh-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh',$(this).attr('id'));"><img src="images/image_sh_beach04.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh',$(this).attr('id'));"><img src="images/image_sh_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh',$(this).attr('id'));"><img src="images/image_sh_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh',$(this).attr('id'));"><img src="images/image_sh_beach01.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">枠も含めたデザインで、とても完成度の高い製品ですね。貰った人は使わないで、保存しておきたくなるのではないでしょうか。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh2_beach04.webp" data-zoom-src="images/image_sh2_beach04_zoom.jpg" id="sh2-i1" width="100%" height="258" style="">
            <img src="images/image_sh2_beach02.webp" data-zoom-src="images/image_sh2_beach02_zoom.jpg" id="sh2-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh2_beach03.webp" data-zoom-src="images/image_sh2_beach03_zoom.jpg" id="sh2-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh2_beach01.webp" data-zoom-src="images/image_sh2_beach01_zoom.jpg" id="sh2-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show ">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh2',$(this).attr('id'));"><img src="images/image_sh2_beach04.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh2',$(this).attr('id'));"><img src="images/image_sh2_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh2',$(this).attr('id'));"><img src="images/image_sh2_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh2',$(this).attr('id'));"><img src="images/image_sh2_beach01.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">人気のモノトーンです。やっぱり、枠ありはいいですね。サンダルとしてではなく、記念品として、残しておきたくなります。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh3_beach01.webp" data-zoom-src="images/image_sh3_beach01_zoom.jpg" id="sh3-i1" width="100%" height="258" style="">
            <img src="images/image_sh3_beach02.webp" data-zoom-src="images/image_sh3_beach02_zoom.jpg" id="sh3-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh3_beach03.webp" data-zoom-src="images/image_sh3_beach03_zoom.jpg" id="sh3-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh3_beach04.webp" data-zoom-src="images/image_sh3_beach04_zoom.jpg" id="sh3-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh3',$(this).attr('id'));"><img src="images/image_sh3_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh3',$(this).attr('id'));"><img src="images/image_sh3_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh3',$(this).attr('id'));"><img src="images/image_sh3_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh3',$(this).attr('id'));"><img src="images/image_sh3_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">タッチして写真を選択・拡大<div class="dot_line"></div>
            </div>
            <p id="text_show1">
              くじらのイラストが入った、かわいいデザインです。夏のビーチに良く似合いますね。また、牡丹色のベースに、スカイブルーの鼻緒が良く似合います。鼻緒の色は、基本的に黒色ですが、その他の色もご指定頂けます。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh4_beach01.webp" data-zoom-src="images/image_sh4_beach01_zoom.jpg" id="sh4-i1" width="100%" height="258" style="">
            <img src="images/image_sh4_beach02.webp" data-zoom-src="images/image_sh4_beach02_zoom.jpg" id="sh4-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh4_beach03.webp" data-zoom-src="images/image_sh4_beach03_zoom.jpg" id="sh4-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh4_beach04.webp" data-zoom-src="images/image_sh4_beach04_zoom.jpg" id="sh4-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show ">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh4',$(this).attr('id'));"><img src="images/image_sh4_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh4',$(this).attr('id'));"><img src="images/image_sh4_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh4',$(this).attr('id'));"><img src="images/image_sh4_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh4',$(this).attr('id'));"><img src="images/image_sh4_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">個性的で魅力的なデザインです。例えば、これまでにTシャツやチラシを製作されたことがあれば、そのデータがビーチサンダルでも
              使えるかも知れません。もちろん、多少の修正は必要ですが。サンダル表面の印刷は、フルカラー印刷ですので、色の数が多くても、
              グラデーションがあっても、問題ありません。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh5_beach01.webp" data-zoom-src="images/image_sh5_beach01_zoom.jpg" id="sh5-i1" width="100%" height="258" style="">
            <img src="images/image_sh5_beach02.webp" data-zoom-src="images/image_sh5_beach02_zoom.jpg" id="sh5-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh5_beach03.webp" data-zoom-src="images/image_sh5_beach03_zoom.jpg" id="sh5-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh5_beach04.webp" data-zoom-src="images/image_sh5_beach04_zoom.jpg" id="sh5-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh5',$(this).attr('id'));"><img src="images/image_sh5_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh5',$(this).attr('id'));"><img src="images/image_sh5_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh5',$(this).attr('id'));"><img src="images/image_sh5_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh5',$(this).attr('id'));"><img src="images/image_sh5_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">幾何学模様のスッキリしたデザインです。スカイブルーのベースに、黄色の鼻緒が映えますね。
              例えば、Sサイズ100足、Mサイズ100足の様に、サイズを混ぜて注文頂く場合でも、合算した数量
              での単価を適用させて頂きます。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh6_beach01.webp" data-zoom-src="images/image_sh6_beach01_zoom.jpg" id="sh6-i1" width="100%" height="258" style="">
            <img src="images/image_sh6_beach02.webp" data-zoom-src="images/image_sh6_beach02_zoom.jpg" id="sh6-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh6_beach03.webp" data-zoom-src="images/image_sh6_beach03_zoom.jpg" id="sh6-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh6_beach04.webp" data-zoom-src="images/image_sh6_beach04_zoom.jpg" id="sh6-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh6',$(this).attr('id'));"><img src="images/image_sh6_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh6',$(this).attr('id'));"><img src="images/image_sh6_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh6',$(this).attr('id'));"><img src="images/image_sh6_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh6',$(this).attr('id'));"><img src="images/image_sh6_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">シンプルなデザインですが、サンダルを履いた時でも、ロゴの一部が見える様に
              <良く考えられたデザインです。鼻緒の白色も好感が持てますね。< /p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh7_beach01.webp" data-zoom-src="images/image_sh7_beach01_zoom.jpg" id="sh7-i1" width="100%" height="258" style="">
            <img src="images/image_sh7_beach02.webp" data-zoom-src="images/image_sh7_beach02_zoom.jpg" id="sh7-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh7_beach03.webp" data-zoom-src="images/image_sh7_beach03_zoom.jpg" id="sh7-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh7_beach04.webp" data-zoom-src="images/image_sh7_beach04_zoom.jpg" id="sh7-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh7',$(this).attr('id'));"><img src="images/image_sh7_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh7',$(this).attr('id'));"><img src="images/image_sh7_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh7',$(this).attr('id'));"><img src="images/image_sh7_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh7',$(this).attr('id'));"><img src="images/image_sh7_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">白色の鼻緒は、明るくて、いつ見てもいいですね。サンダルのデザインは、左右タ対象でなくてもいいんですよ。全く別々のデザインでも、同じデザインでも、製作料金は変わりません。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh8_beach01.webp" data-zoom-src="images/image_sh8_beach01_zoom.jpg" id="sh8-i1" width="100%" height="258" style="">
            <img src="images/image_sh8_beach02.webp" data-zoom-src="images/image_sh8_beach02_zoom.jpg" id="sh8-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh8_beach03.webp" data-zoom-src="images/image_sh8_beach03_zoom.jpg" id="sh8-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh8_beach04.webp" data-zoom-src="images/image_sh8_beach04_zoom.jpg" id="sh8-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh8',$(this).attr('id'));"><img src="images/image_sh8_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh8',$(this).attr('id'));"><img src="images/image_sh8_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh8',$(this).attr('id'));"><img src="images/image_sh8_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh8',$(this).attr('id'));"><img src="images/image_sh8_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">人気のモノトーンです。やはり、黒ベースの製品には、赤色の鼻緒が似合います。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh9_beach04.webp" data-zoom-src="images/image_sh9_beach04_zoom.jpg" id="sh9-i1" width="100%" height="258" style="">
            <img src="images/image_sh9_beach02.webp" data-zoom-src="images/image_sh9_beach02_zoom.jpg" id="sh9-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh9_beach03.webp" data-zoom-src="images/image_sh9_beach03_zoom.jpg" id="sh9-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh9_beach01.webp" data-zoom-src="images/image_sh9_beach01_zoom.jpg" id="sh9-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh9',$(this).attr('id'));"><img src="images/image_sh9_beach04.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh9',$(this).attr('id'));"><img src="images/image_sh9_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh9',$(this).attr('id'));"><img src="images/image_sh9_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh9',$(this).attr('id'));"><img src="images/image_sh9_beach01.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">白黒2色のシンプルな色使いの個性的な仕上がりです。この製品のように、かかとに近い部分にロゴを入れておくと、サンダルを履いた時でもロゴマークが見えます。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh10_beach01.webp" data-zoom-src="images/image_sh10_beach01_zoom.jpg" id="sh10-i1" width="100%" height="258" style="">
            <img src="images/image_sh10_beach02.webp" data-zoom-src="images/image_sh10_beach02_zoom.jpg" id="sh10-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh10_beach03.webp" data-zoom-src="images/image_sh10_beach03_zoom.jpg" id="sh10-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh10_beach04.webp" data-zoom-src="images/image_sh10_beach04_zoom.jpg" id="sh10-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh10',$(this).attr('id'));"><img src="images/image_sh10_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh10',$(this).attr('id'));"><img src="images/image_sh10_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh10',$(this).attr('id'));"><img src="images/image_sh10_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh10',$(this).attr('id'));"><img src="images/image_sh10_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">人気のスカイブルーと牡丹色の組み合わせですね。この様に、サンダルのデザインは左右対称でも、そうでなくても大丈夫ですよ。
              例えば、左右全く別々のデザインでも製作できます。もちろん、製作料金は変わりません。せっかく作るなら、ひと手間かけて、
              完成度の高い製品を製作してみてはいかがでしょうか。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh11_beach04.webp" data-zoom-src="images/image_sh11_beach04_zoom.jpg" id="sh11-i1" width="100%" height="258" style="">
            <img src="images/image_sh11_beach02.webp" data-zoom-src="images/image_sh11_beach02_zoom.jpg" id="sh11-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh11_beach03.webp" data-zoom-src="images/image_sh11_beach03_zoom.jpg" id="sh11-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh11_beach01.webp" data-zoom-src="images/image_sh11_beach01_zoom.jpg" id="sh11-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh11',$(this).attr('id'));"><img src="images/image_sh11_beach04.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh11',$(this).attr('id'));"><img src="images/image_sh11_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh11',$(this).attr('id'));"><img src="images/image_sh11_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh11',$(this).attr('id'));"><img src="images/image_sh11_beach01.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">枠付きのビーチサンダルは、実際に使わなくても、記念品やプレゼントとして最適です。
              デザインは枠も含めたデザインで考えてください。また、この様にサンダル裏面に、
              文字やマークを入れる加工もできます。砂浜に文字が残りますね。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh12_beach03.webp" data-zoom-src="images/image_sh12_beach03_zoom.jpg" id="sh12-i1" width="100%" height="258" style="">
            <img src="images/image_sh12_beach04.webp" data-zoom-src="images/image_sh12_beach04_zoom.jpg" id="sh12-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh12_beach02.webp" data-zoom-src="images/image_sh12_beach02_zoom.jpg" id="sh12-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh12_beach01.webp" data-zoom-src="images/image_sh12_beach01_zoom.jpg" id="sh12-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh12',$(this).attr('id'));"><img src="images/image_sh12_beach03.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh12',$(this).attr('id'));"><img src="images/image_sh12_beach04.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh12',$(this).attr('id'));"><img src="images/image_sh12_beach02.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh12',$(this).attr('id'));"><img src="images/image_sh12_beach01.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">白色をベースとした、爽やかな仕上がりの好感の持てるデザインです。
              このように、サンダルの外側の枠も含めて製作することもできます。
              記念品として末永く持って貰える製品を作りたいですね。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh13_beach01.webp" data-zoom-src="images/image_sh13_beach01_zoom.jpg" id="sh13-i1" width="100%" height="258" style="">
            <img src="images/image_sh13_beach02.webp" data-zoom-src="images/image_sh13_beach02_zoom.jpg" id="sh13-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh13_beach03.webp" data-zoom-src="images/image_sh13_beach03_zoom.jpg" id="sh13-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh13_beach04.webp" data-zoom-src="images/image_sh13_beach04_zoom.jpg" id="sh13-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh13',$(this).attr('id'));"><img src="images/image_sh13_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh13',$(this).attr('id'));"><img src="images/image_sh13_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh13',$(this).attr('id'));"><img src="images/image_sh13_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh13',$(this).attr('id'));"><img src="images/image_sh13_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">ベースがピンク色のかわいいデザインです。デザイン製作が難しい場合、お考えのデザインのイメージを当店にご連絡ください。デザイン
              作成料はかかりません。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh14_beach01.webp" data-zoom-src="images/image_sh14_beach01_zoom.jpg" id="sh14-i1" width="100%" height="258" style="">
            <img src="images/image_sh14_beach02.webp" data-zoom-src="images/image_sh14_beach02_zoom.jpg" id="sh14-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh14_beach03.webp" data-zoom-src="images/image_sh14_beach03_zoom.jpg" id="sh14-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh14_beach04.webp" data-zoom-src="images/image_sh14_beach04_zoom.jpg" id="sh14-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh14',$(this).attr('id'));"><img src="images/image_sh14_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh14',$(this).attr('id'));"><img src="images/image_sh14_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh14',$(this).attr('id'));"><img src="images/image_sh14_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh14',$(this).attr('id'));"><img src="images/image_sh14_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">黒色無地、印刷無しのサンダルです。ベースゴムの色は黒色になりますが、この様な製品も製作できますよ。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh15_beach01.webp" data-zoom-src="images/image_sh15_beach01_zoom.jpg" id="sh15-i1" width="100%" height="258" style="">
            <img src="images/image_sh15_beach02.webp" data-zoom-src="images/image_sh15_beach02_zoom.jpg" id="sh15-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh15_beach03.webp" data-zoom-src="images/image_sh15_beach03_zoom.jpg" id="sh15-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh15_beach04.webp" data-zoom-src="images/image_sh15_beach04_zoom.jpg" id="sh15-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh15',$(this).attr('id'));"><img src="images/image_sh15_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh15',$(this).attr('id'));"><img src="images/image_sh15_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh15',$(this).attr('id'));"><img src="images/image_sh15_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh15',$(this).attr('id'));"><img src="images/image_sh15_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">ご注文の多い黒系のデザインです。赤色の鼻緒も素敵です。黒色以外の鼻緒の色は、別途費用がかかります。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh16_beach01.webp" data-zoom-src="images/image_sh16_beach01_zoom.jpg" id="sh16-i1" width="100%" height="258" style="">
            <img src="images/image_sh16_beach02.webp" data-zoom-src="images/image_sh16_beach02_zoom.jpg" id="sh16-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh16_beach03.webp" data-zoom-src="images/image_sh16_beach03_zoom.jpg" id="sh16-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh16_beach04.webp" data-zoom-src="images/image_sh16_beach04_zoom.jpg" id="sh16-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh16',$(this).attr('id'));"><img src="images/image_sh16_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh16',$(this).attr('id'));"><img src="images/image_sh16_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh16',$(this).attr('id'));"><img src="images/image_sh16_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh16',$(this).attr('id'));"><img src="images/image_sh16_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">フルカラー印刷ならではの、個性的なデザインです。ビーチサンダルへの印刷は、フルカラー印刷をした生地をサンダル本体に貼り付けることで行います。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh17_beach01.webp" data-zoom-src="images/image_sh17_beach01_zoom.jpg" id="sh17-i1" width="100%" height="258" style="">
            <img src="images/image_sh17_beach02.webp" data-zoom-src="images/image_sh17_beach02_zoom.jpg" id="sh17-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh17_beach03.webp" data-zoom-src="images/image_sh17_beach03_zoom.jpg" id="sh17-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh17_beach04.webp" data-zoom-src="images/image_sh17_beach04_zoom.jpg" id="sh17-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh17',$(this).attr('id'));"><img src="images/image_sh17_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh17',$(this).attr('id'));"><img src="images/image_sh17_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh17',$(this).attr('id'));"><img src="images/image_sh17_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh17',$(this).attr('id'));"><img src="images/image_sh17_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">ロゴやマークのデザインは、この製品のように、サンダルより大きく入る
              ようにして、デザインがカットされてしまうようにする方が、綺麗に見えます。</p>
          </div>
        </div>
        <div class="slide_show">
          <div class="img-show">
            <img src="images/image_sh18_beach04.webp" data-zoom-src="images/image_sh18_beach04_zoom.jpg" id="sh18-i1" width="100%" height="258" style="">
            <img src="images/image_sh18_beach02.webp" data-zoom-src="images/image_sh18_beach02_zoom.jpg" id="sh18-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh18_beach03.webp" data-zoom-src="images/image_sh18_beach03_zoom.jpg" id="sh18-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh18_beach01.webp" data-zoom-src="images/image_sh18_beach01_zoom.jpg" id="sh18-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh18',$(this).attr('id'));"><img src="images/image_sh18_beach04.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh18',$(this).attr('id'));"><img src="images/image_sh18_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh18',$(this).attr('id'));"><img src="images/image_sh18_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh18',$(this).attr('id'));"><img src="images/image_sh18_beach01.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">夏らしいすっきりしたデザインが素敵です。イベント等での配布用には、この製品のように枠のある製品の方が、記念品としての価値が上がるかも知れません。</p>
          </div>
        </div>
      </div>
      <div style="display: flex;">
        <div class="slide_show">
          <div class="img-show img-zoom">
            <img src="images/image_sh19_beach01.webp" data-zoom-src="images/image_sh19_beach01_zoom.jpg" id="sh19-i1" width="100%" height="258" style="">
            <img src="images/image_sh19_beach02.webp" data-zoom-src="images/image_sh19_beach02_zoom.jpg" id="sh19-i2" style="display: none;" width="100%" height="258">
            <img src="images/image_sh19_beach03.webp" data-zoom-src="images/image_sh19_beach03_zoom.jpg" id="sh19-i3" style="display: none;" width="100%" height="258">
            <img src="images/image_sh19_beach04.webp" data-zoom-src="images/image_sh19_beach04_zoom.jpg" id="sh19-i4" style="display: none;" width="100%" height="258">
          </div>
          <div class="sub-show">
            <div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('sh19',$(this).attr('id'));"><img src="images/image_sh19_beach01.webp" width="81" height="61"></a></div>
            <div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('sh19',$(this).attr('id'));"><img src="images/image_sh19_beach02.webp" width="81" height="61"></a></div>
            <div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('sh19',$(this).attr('id'));"><img src="images/image_sh19_beach03.webp" width="81" height="61"></a></div>
            <div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('sh19',$(this).attr('id'));"><img src="images/image_sh19_beach04.webp" width="81" height="61"></a></div>
          </div>
          <div class="sub-show sub-show-mb" style="background: white;text-align: left;">
            <div id="botm_txt">
              タッチして写真を選択・拡大
              <div class="dot_line"></div>
            </div>
            <p id="text_show1">色使いがいいですね。黄色ベースに青色の鼻緒の組み合わせも
              良くご注文頂きます。</p>
          </div>
        </div>
      </div>
      <div class="dot_line"></div>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/sandals-A.jpg" data-lightbox="sandals-a_f" style="text-decoration:none;">
              <img src="img/sandals-A.webp" width="350" height="263" alt="オリジナルビーチサンダルイメージ黒色">
            </a>
          </td>
          <td>
            <a href="img/sandals-B.jpg" data-lightbox="sandals-a_f" style="text-decoration:none;">
              <img src="img/sandals-B.webp" width="350" height="263" alt="オリジナルビーチサンダルイメージ黄色">
            </a>
          </td>
        </tr>
        <tr valign="top">
          <td><a href="img/sandals-A.jpg" data-lightbox="sandals-text_af" style="text-decoration:none;">📷子供用のビーチサンダルも作成できます。</a></td>
          <td><a href="img/sandals-B.jpg" data-lightbox="sandals-text_af" style="text-decoration:none;">📷子供用の製作事例。鼻緒の色はお客様ご指定のスカイブルーです。</a></td>
        </tr>
      </table>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/sandals-D.jpg" data-lightbox="sandals-a_f" style="text-decoration:none;">
              <img src="img/sandals-D.webp" width="350" height="263">
            </a>
          </td>
          <td>
            <a href="img/sandals-C.jpg" data-lightbox="sandals-a_f" style="text-decoration:none;">
              <img src="img/sandals-C.webp" width="350" height="263">
            </a>
          </td>
        </tr>
        <tr valign="top">
          <td><a href="img/sandals-D.jpg" data-lightbox="sandals-text_af" style="text-decoration:none;">📷鼻緒の色はお客様ご指定のグリーンです。大人用Mサイズ。</a></td>
          <td><a href="img/sandals-C.jpg" data-lightbox="sandals-text_af" style="text-decoration:none;">📷メッセージ入りの製作事例。裏面に凹加工で刻印を入れ、砂にメッセージが入ります。大人用Mサイズ。</a></td>
        </tr>
      </table>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/sandals-E.jpg" data-lightbox="sandals-a_f" style="text-decoration:none;">
              <img src="img/sandals-E.webp" width="350" height="263" alt="オリジナルビーチサンダルイメージピンク">
            </a>
          </td>
          <td>
            <a href="img/sandals-F.jpg" data-lightbox="sandals-a_f" style="text-decoration:none;">
              <img src="img/sandals-F.webp" width="350" height="263" alt="オリジナルロゴプリントビーチサンダルイメージ">
            </a>
          </td>
        </tr>
        <tr valign="top">
          <td><a href="img/sandals-E.jpg" data-lightbox="sandals-text_af" style="text-decoration:none;">📷鼻緒の色はお客様ご指定のピンクです。</a></td>
          <td><a href="img/sandals-F.jpg" data-lightbox="sandals-text_af" style="text-decoration:none;">📷サンダルの全面にフルカラーで印刷できます。</a></td>
        </tr>
      </table>
      <p class="d_TEXT1 new-text">
        下の写真のようなピンク色や黄緑色等の特色をご希望の場合、PANTONE番号（もしくは何らかの紙媒体）で指定して頂けると製作できます。
        鼻緒の色の特色指定は、別途ビーチサンダル１足あたり、66円（税込）アップとなります。
      </p>
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="8">
        <tr>
          <td>
            <a href="img/sandals-G.jpg" data-lightbox="sandals-g_h" style="text-decoration:none;">
              <img src="img/sandals-G.webp" width="350" height="263">
            </a>
          </td>
          <td>
            <a href="img/sandals-H.jpg" data-lightbox="sandals-g_h" style="text-decoration:none;">
              <img src="img/sandals-H.webp" width="350" height="263">
            </a>
          </td>
        </tr>
        <tr valign="top">
          <td><a href="img/sandals-G.jpg" data-lightbox="sandals-text_gh" style="text-decoration:none;">📷黄緑色鼻緒の例</a>
          </td>
          <td><a href="img/sandals-H.jpg" data-lightbox="sandals-text_gh" style="text-decoration:none;">📷ピンク色鼻緒の例</a>
          </td>
        </tr>
      </table>
      <hr>
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
      <!-- <h2 class="text-info">この商品に関する記事</h2>
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
      </div>
      <div>&nbsp;</div>
      <div class="d-flex">
        <div class="flex-item w-30">
          <a class="unlink" href="/blog-content/howtomake-cheaper"><img src="/blog-content/upload/202310051309082634.jpg" class="w-100"></a>
        </div>
        <div class="flex-item w-70">
          <a class="unlink" href="/blog-content/howtomake-cheaper">知ってる人だけトクをする！オリジナルグッズを安く作る方法5選</a>
        </div>
      </div>
      <div>&nbsp;</div> -->

        <?php 
            $favor = "beach";
            if (isset($favor) && ($favor)) {
                include 'product-faq-v2.php';
            }
        ?>

      <h2>営業担当が直接御社にお伺いし、製品やサービスのご提案・ご説明をさせて頂きます。</h2>
      <center><a href="//hotmobily.jp/meeting_date/"><img src="../img/btn_meetingdate_1.svg" title="ノベルティー営業担当呼び出しフォーム" width="100%" height="82" /></a></center>
      <img src="images/text_sample.svg" width="100%" height="620" id="i_txt2">
      <hr>
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: wrapper end :: -->
  <!--フッター ここから-->
  <?php include('../footer.html'); ?>
  <!--フッター ここまで-->
  <!-- /lightbox2-master -->
  <script src="js/lightbox.js"></script>
  <script type="text/javascript" src="/products/js/jquery.zoom.js?v=1.03"></script>
  <script type="text/javascript" src="/products/js/date.js"></script>
  <script type="text/javascript" src="/products/js/calendar_n2.js?v=3.1"></script>
  <script>
    lightbox.option({
      'maxWidth': 600,
      'maxHeight': 600,
      'alwaysShowNavOnTouchDevices': true
    })
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      mediumZoom('.img-show img', {
        margin: 10
      });
    });

    function img_slide(type, id) {
      for (var i = 1; i <= 4; i++) {
        var tmp = $('#' + type + "-i" + i);
        tmp.hide();
      }
      $('#' + type + "-" + id).fadeIn("slow");
    }
  </script>
  <!-- /lightbox2-master -->
  <script type="text/javascript">
    $(function() {
      var s = $("#i_txt2");
      screen.width <= 768 && (s.attr("src", "images/text_sample_n1.svg"))
    });
    $.ajax({
      type: "POST",
      url: "/products/check_holiday.php",
      data: {
        "product": "ラバーストラップ"
      },
      success: function(data) {
        productionDate(data.sort());
      },
      dataType: "json"
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
  <script type="text/javascript">
    var splide = new Splide('.splide', {
      type: 'loop',
      perPage: 3,
      pagination: false,
      arrows: true,
      breakpoints: {
        425: {
          perPage: 2,
        }
      },
    });
    splide.mount();
  </script>
</body>

</html>