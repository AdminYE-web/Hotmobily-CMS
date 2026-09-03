<?php
if(!isset($_GET['t'])){
  header("Location:home");exit();
}
switch ($_GET['t']) {
  case 'rubberstrap':
  $t = "ラバーストラップ・ラバーキーホルダー";
  $cat="rubberstrap";
  $q = ["ラバーストラップ・ラバーキーホルダーの材質は何ですか？", "細かいデザインでも製作料金は同じですか？", "ラバーストラップ・ラバーキーホルダーは最大何センチまで作れるのか？", "汚れがつかないように防止するためにはどうすればよいのですか？", "大量発注の場合値引きはしてくれますか？", "黒ずんだ汚れがついたラバーストラップ・ラバーキーホルダーの汚れはどのように落とせますか？", "細かいデザインでも製作料金は同じですか？"];
  $a = ["ATBC-PVC(非フタル酸エステル系塩ビ)というプラスチックです。ラバーストラップ・ラバーキーホルダーという名称から、ゴムでできていると思われている方もいらっしゃいますが、下水などの配管に使われている灰色の塩ビパイプという菅がありますが....","デザインの細かさや、使っている色数で製作料金が変わることはありません。例えば、上の２つのラバーストラップの製作料金は同じです。また、サイズが小さくなっても基本的には価格が安くなる事はありま....", "身に着ける一般的なラバーストラップ・ラバーキーホルダーですと7センチ四方くらいまでが一般的です。それは、身に着けるという制約があるので、例えば鞄の様な大きさですと、身に着けるというよりは持ち歩くという感覚になってしまいますよね。<br/>次に、製品生産という観点でお答えしますと、....","ホットモバイリーでは、そもそも汚れを付着しにくくして、たとえ汚れてしまった場合でも簡単に汚れが落とせる汚れ防止加工をオプションサービスで提供しています。この加工は、ラバー....","これまで約10年間ラバーストラップ・ラバーキーホルダーの製作に携わってきまして、大量ご注文の場合の良くあるお値引きの事例は例えば下記の様な事....", "全体的な汚れではなく、小さな黒点の様な外観の場合気泡かも知れません。ラバーストラップ・ラバーキーホルダーは液体のゴムを熱で固めて製品にしますので、その際に細かな気泡が入ってしまうと黒点汚れの様に見えます。気....","ホットモバイリーは事業のスタートがオリジナルラバーストラップの製作でした。これまで約7年近くラバー製品の設計や販売をさせて頂いておりまして、色移りや経年変化に対する大きなクレームはなかったです。しかしながら、この問題は深堀すると色々と考えるべき点も出てき...."];
  break;
  default: header("Location:home");exit();break;
  break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="keywords" content="オリジナルグッズ,FAQ,よくある質問">
  <meta name="description" content="オリジナルグッズを製作する際の良くある質問。ホットスモバイリーのFAQ">
  <meta name="robots" content="noindex">
  <link href="/campaign/css/all.css" rel="stylesheet" type="text/css">
  <title>オリジナルグッズを製作する際の良くある質問。ホットスモバイリーのFAQ</title>
  <?php include("../head_products.html"); ?>

  <link href="../css/faq_2nd.css" rel="stylesheet" type="text/css" media="all" />

  <style type="text/css">
  span.faq-q {
    font-family: IwaUDGoDspPro-Eb,sans-serif !important;
    color: #E50011;
    padding-right: 10px;
    font-size: 24px;
  }

  .faq-a{
    font-size: 24px;
    font-family: IwaUDGoDspPro-Eb,sans-serif !important;
    padding-right: 10px;
  }

  span.faq_txt {
    font-family: IwaUDGoDspPro-Eb,sans-serif !important;
    font-size: 24px;
  }
  .d-flex{display: flex;}
  .d-flex>div {
    display: grid;
    padding-top: 13px;
  }

  hr {
    border: 0.5px solid silver;
    margin-bottom: 20px;
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

  <?=($_SESSION['lang']=="kr"?'#content_wrapper{font-family: "돋움체",DotumChe,serif!important;}h1,h2,h3{font-family: "돋움체",DotumChe,serif!important;}':'')?>
  <?=($_SESSION['lang']=="th"?'#content_wrapper{font-family: "Prompt", sans-serif!important;}h1,h2,h3{font-family: "Prompt", sans-serif!important;}':'')?>
</style>

</head>
<body id="top">

  <!-- :: header start :: -->
  <?php include("../header.html"); ?>
  <!-- :: header end :: -->

  <!-- globalNavi -->
  <?php include("../gnavi.html"); ?>
  <!-- globalNavi End -->

  <!-- :: wrapper start :: -->
  <div id="wrapper">

    <!-- sidemenu-->
    <?php include("sidenavi.php"); ?>
    <!-- sidemenu End -->

    <!-- :: content_wrapper start :: -->
    <div id="content_wrapper" class="scrollingPanel">
      <h2>オリジナルグッズ製作に関する良くある質問 (FAQ)</h2>
      <p style="margin-bottom: 20px;"><?=$t?></p>
      <?php 
      foreach ($q as $key => $value) { 
        ?>
        <div style="margin-bottom: 5px;" class="d-flex"><span class="faq-q">Q.</span><div class="faq_txt"><?= $value ?></div></div>
        <div class="d-flex">
          <span class="faq-a">A.</span>
          <div><?= $a[$key] ?></div>        
        </div>
        <div style="text-align: center; margin: 15px auto;" class="">
          <button class="but3">
            <a href="/faq/details/rubberstrap/q<?=($key+1)?>" style="text-decoration: none; color: black; font-size: 16px; padding: 10px 40px;" class="">もっと見る <i class="fas fa-arrow-circle-right"></i></a>
          </button>
        </div>
        <hr/>
        <?php
      }
      ?>
      
    </div>
    <!-- :: content_wrapper end :: -->
  </div>
  <!-- :: WRAPPER end :: -->

  <!--フッター ここから-->
  <?php include("../footer.html"); ?>
  <!--フッター ここまで-->
</body></html>>
