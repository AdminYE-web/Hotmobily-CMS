<?php
session_start();
require_once('../../control/Control_Rubber.php');
include_once('../../common/Const.php');
include_once('../../common/SetUpLang.php');
Main();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex">
	<meta name="keywords" content="<?=lang('アクリル,キーホルダー,自社生産,安い');?>">
	<meta name="description" content="<?=lang('全て自社で生産しています。だから、安い');?>">
	<title><?=lang('オリジナルアクリルキーホルダー。全て自社で生産しています。だから、安い。');?></title>
	<?php include('../../head_products.html'); ?>
	<link rel="stylesheet" type="text/css" href="/css/banner_style.css?v=1.19">
	<link href="css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
	<style type="text/css">
		#wrapper {overflow: hidden;}
		.flex-link {display: flex;flex-direction: row;align-content: flex-start;align-items: stretch;justify-content: space-around;flex-wrap: wrap;}
		.flex-link a {text-decoration: underline;color: black;font-size: 12px;transition: all .3s ease-in-out;display: flex;flex-wrap: wrap;align-content: center;justify-content: flex-start;align-items: center;text-align: center;margin-bottom: 10px;width: 50%;}
		.flex-link a:hover {color: #ff0000;}
		.flex-link span {background: #ff0000;padding: 2px 6px;color: #fff;border-radius: 50%;margin-right: 5px;}
		hr {border: 0.5px solid #dcdcdc; margin: 15px 0;}
		span.hilight-txt {font-size: 19px;}
		@media (max-width: 768px) {span.hilight-txt {font-size: 4vw;}}
		@media (max-width: 576px) {.flex-link a {padding: 10px;width: 100%;margin-bottom: 8px;}}
	</style>
</head>
<body id="top">
	<!-- :: header start :: -->
		<?php include('../../header.html'); ?>
		<!-- :: header end :: -->

		<!-- globalNavi -->
		<?php include('../../gnavi.php'); ?>
		<!-- globalNavi End -->

		<!-- :: wrapper start :: -->
		<div id="wrapper">

			<!-- sidemenu-->
			<?php include('../../sidenavi.php'); ?>
			<!-- sidemenu End -->

			<!-- :: content_wrapper start :: -->
			<div id="content_wrapper">
				<h1><?=lang('全て自社で生産しています。だから、安い');?></h1>
				<img src="img/acrylic-factory20260608.webp" style="padding: 5px 0;" width="100%" height="422">
				<p>
					<?=lang('お客様の大切な製品を製作する会社として、責任を持って生産する為に、アクリル製品は全て自社の工場で生産しています。印刷からカット、アタッチメントの取り付け、検査、梱包まで全て社内で完結しています。');?><br/><br/>
					<?=lang('だから、結果として');?><span class="red hilight-txt">安い</span>。<br/><br/>
					<?=lang('お客様にとって重要な製品の品質を落とすことなく、どこよりもお安い価格で製作します。');?>
				</p>
				<h2><?=lang('アクキーができるまで');?></h2>
				<div class="videoWrapper" style="margin-bottom: 5px;">	
					<img src="img/production_process_youtube (1).webp" data-src="g6wha8kIsc0" class="iframe" width="100%" height="434">
					<div class="playbtn"><div class="tri"></div></div>
				</div>
				<p>
					<?=lang('1枚のアクリルキーホルダーを作る為には多くの工程を必要とします。印刷、保護フィルムの貼り合わせ、カット、アタッチメント取付、検品、梱包など。各工程の作業の様子を１つの動画にしております。アクリル製品の生産工程に興味のある方にはとても分かりやすい動画になっています。');?>
				</p>		
				<hr/>
				<div class="flex-link">
					<a href="https://hotmobily.jp/company/" target="_blank"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span><?=lang('中国広東省にある自社工場のご案内');?></a>
					<a href="/products/acrylic/" target="_blank"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span><?=lang('アクリルキーホルダー製品紹介ページ');?></a>
					<a href="/products/acrylic/figure" target="_blank"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span><?=lang('アクリルフィギュアスタンド製品紹介ページ');?></a>
					<a href="/products/acrylic/all" target="_blank"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span><?=lang('その他アクリル製品一覧');?></a>
				</div>
			</div>
		<!-- :: content_wrapper end :: -->
		</div>
	</div>
	<!-- :: wrapper end :: -->

	<!--フッター ここから-->
	<?php include('../../footer.php'); ?>
	<!--フッター ここまで-->

	<!-- javascript -->
	<script src="../js/lightbox.js"></script>
	<script src="/js/swiper.min.js"></script>
	<script type="text/javascript" src="/js/common.js?v=1.02"></script>
</body>
</html>