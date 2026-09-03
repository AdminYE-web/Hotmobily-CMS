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
	<meta name="keywords" content="<?= lang('アクリル,キーホルダー,1個'); ?>">
	<meta name="description" content="<?= lang('オリジナルアクリルキーホルダーが1個から製作できます。'); ?>">
	<title><?= lang('オリジナルアクリルキーホルダーが1個から製作できます。'); ?></title>
	<?php include('../../head_products.html'); ?>
	<link rel="stylesheet" type="text/css" href="/css/banner_style.css?v=1.19">
	<link href="css/renew_products.css?v=1.163" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
	<style type="text/css">
		#wrapper {
			overflow: hidden;
		}

		.flex-link {
			display: flex;
			flex-direction: row;
			align-content: flex-start;
			align-items: stretch;
			justify-content: space-around;
			flex-wrap: wrap;
		}

		.flex-link a {
			text-decoration: underline;
			color: black;
			font-size: 12px;
			transition: all .3s ease-in-out;
			display: flex;
			flex-wrap: wrap;
			align-content: center;
			justify-content: center;
			align-items: center;
			text-align: center;
		}

		.flex-link a:hover {
			color: #ff0000;
		}

		.flex-link span {
			background: #ff0000;
			padding: 2px 6px;
			color: #fff;
			border-radius: 50%;
			margin-right: 5px;
		}

		hr {
			border: 0.5px solid #dcdcdc;
			margin: 15px 0;
		}

		@media (max-width: 576px) {
			.flex-link a {
				padding: 10px;
				width: 100%;
				margin-bottom: 8px;
			}
		}
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
			<h1><?= lang('小ロット、1個から注文できます'); ?></h1>
			<img src="img/acrylic-from-one.webp" style="padding: 5px 0;" width="100%" height="422">
			<p><?= lang('HOTMOBILYオリジナルグッズなら、オリジナルデザイン印刷1個の注文でも喜んでお受けいたします。1個や2個の注文は以外と多いんですよ。個人のお客様はもちろん、会社の注文でも、1個作って仕上がりを確認してみたい、社内で上司の許可を取るのに、実物があった方が良いなどのお客様からの注文が多いです。'); ?></p>
			<h2><?= lang('1個（枚）ご注文時の参考価格'); ?></h2>
			<p>
				<?= lang('アクキー1個ご注文時の製作料金：990円～（税込）'); ?><br /><br />
				<?= lang('アクスタ1個ご注文時の製作料金：1049円～（税込）'); ?><br /><br />
				<?= lang('アクリルコースター1枚ご注文時の製作料金：1188円～（税込）'); ?><br /><br />
				<?= lang('※製作する製品のサイズや納期、アタッチメント（金具）の種類などにより価格が変わります。'); ?><br /><br />
				<?= lang('正確な製作料金の確認は、各製品紹介ページの『ご注文・見積書作成』よりお願いします。'); ?>
			</p>
			<h2><?= lang('試作品（実物校正サンプル）の製作について'); ?></h2>
			<p><?= lang('20枚以上のご注文から製作前に1個（枚）製作し確認後、量産をすることができます。'); ?></p>
			<hr />
			<div class="flex-link">
				<a href="/products/acrylic/" target="_blank"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span><?= lang('アクリルキーホルダー製品紹介ページ'); ?></a>
				<a href="/products/acrylic/figure" target="_blank"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span><?= lang('アクリルフィギュアスタンド製品紹介ページ'); ?></a>
				<a href="/products/acrylic/all" target="_blank"><span><i class="fa fa-caret-right" aria-hidden="true"></i></span><?= lang('その他アクリル製品一覧'); ?></a>
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