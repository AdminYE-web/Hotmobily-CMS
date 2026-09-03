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
	<meta name="keywords" content="<?= lang('アクリル,キーホルダー,印刷,剥がれない'); ?>">
	<meta name="description" content="<?= lang('印刷が剥がれないアクリルキーホルダー。印刷面の全面をPETフィルムで保護するので、大切な印刷が剥がれる心配がありません。'); ?>">
	<title><?= lang('印刷が剥がれないアクリルキーホルダー。'); ?></title>
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
			.flex-link {}

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
			<h1><?= lang('印刷面の全面をPETフィルムで保護するので、大切な印刷が剥がれる心配がありません。'); ?></h1>
			<img style="padding: 5px 0;" width="100%" height="427" src="/img/acrylic-film-01ver02.webp">
			<p><?= lang('HOTMOBILYオリジナルグッズのアクキーは、印刷面の全面をPETフィルムで保護します。印刷部分だけを保護するのではなく、面全体を透明シートで保護しますので、自然な製品の仕上がりとなります。鍵や金属物が直接印刷面に触れないので印刷が剥がれてしまうことがありません。保護用のPETフィルムは厚さ0.2mm。保護している事さえ気づかない薄さです。無料サンプル請求で実物を確認頂けます。'); ?></p>
			<h2><?= lang('ギザギザコインで擦りテストを実施。'); ?></h2>
			<img class="lazy" data-src="/products/acrylic/img/acrylic-film-02.webp" style="padding-bottom: 5px;" width="100%" height="422" src="img/acrylic-film-02.webp">
			<p><?= lang('100円硬化のギザギザ部分を使用して、印刷が本当に剥がれないかをテストしてみました。他社製品の印刷強度と比較する形でご紹介しています。ご覧の通りHOTMOBILYオリジナルグッズの製品は面全体がPETフィルムで保護されていますので印刷は剥がれません。大切なアクキーをいつまでも綺麗な形でお使い頂く事ができます。また白押さえ部分だけを保護するコーティング加工と比較し、印刷面の不自然な凹凸が一切無いのが特徴です。製品の仕上がりがとても自然です。'); ?></p>
			<h2><?= lang('今回のコスリテストの様子を動画にまとめてみました。'); ?></h2>
			<p><?= lang('収録内容。 ①ギザギザコインを使った擦りテストのテスト風景と結果。 ②PETフィルムコートの構造解説。 ③カットなどの加工方法の紹介。'); ?></p>
			<div style="clear: both;">&nbsp;</div>
			<div class="videoWrapper">
				<img src="img/acrylic-film-youtube_1.webp" data-src="pnKcyfuh4Rw" class="iframe" width="100%" height="434">
				<div class="playbtn">
					<div class="tri"></div>
				</div>
			</div>
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