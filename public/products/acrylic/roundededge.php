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
	<meta name="keywords" content="<?= lang('アクリル,キーホルダー,エッヂ,面取り'); ?>">
	<meta name="description" content="<?= lang('オリジナルアクリルキーホルダー。製品のエッヂを面取り加工。肌触りの良い製品に仕上がります。'); ?>">
	<title><?= lang('オリジナルアクリルキーホルダー。製品のエッヂを面取り加工。肌触りの良い製品に仕上がります。'); ?></title>
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
			lign-content: center;
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
			<h1><?= lang('エッジが滑らか。触って納得の仕上がりです'); ?></h1>
			<img src="img/acrylic-cnc-01.webp" style="margin-top: 5px;" width="100%" height="422">
			<h2><?= lang('製品のエッヂを面取り加工。肌触りの良い製品に仕上がります'); ?></h2>
			<p>
				<?= lang('とても細かなことですが、HOTMOBILYオリジナルグッズのこだわりです。アクリルのカットは通常レーザーが多く、カットした後に違和感のある盛り上がりができてしまいます。当店の製品はCNC加工機を使い、全ての製品の面取りをしています。エッジってどこ？という方は、上の写真で確認ください。'); ?><br /><br />
				<?= lang('他社製品との比較イメージ図'); ?>
			</p><br />
			<img src="/img/acrylic_cnc_02.webp" style="padding-bottom: 5px;" width="100%" height="100%">
			<!-- <p><?= lang('当社アクリル製品'); ?></p><br /> -->
			<!-- <img src="/img/acryliccut_othercomp.webp" style="padding-bottom: 5px;" width="100%" height="150"> -->
			<!-- <p><?= lang('他社の代表的なアクリル製品'); ?></p> -->
			<h2><?= lang('アクキーができるまで'); ?></h2>
			<div class="videoWrapper" style="margin-bottom: 5px;">
				<img src="img/production_process_youtube.webp" data-src="g6wha8kIsc0" class="iframe" width="100%" height="434">
				<div class="playbtn">
					<div class="tri"></div>
				</div>
			</div>
			<p><?= lang('動画の後半でアクリル製品のカット工程の説明をしております。'); ?></p>
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