<style type="text/css">
	.flex-container#btn-group {
		margin-top: 10px
	}

	.sm-text {
		font-size: 12px
	}

	.top-contrainer {
		border-bottom: 2px solid #ebebeb;
		position: relative
	}

	.top-contrainer div div {
		display: block;
		padding: 0;
		width: 100%;
		margin-bottom: 25px
	}

	.top-contrainer>p {
		display: block;
		text-align: center;
		position: absolute;
		background: #fff;
		top: -20px;
		left: calc(20% + 20px);
		font-size: 25px;
		padding: 0 20px;
		font-family: IwaUDGoDspPro-Eb, sans-serif !important
	}

	.top-contrainer div {
		display: inline-grid;
		width: calc(50% - 8px);
		padding: 0 3px;
	}

	.top-contrainer div img {
		width: 100%
	}

	.top-contrainer div div a {
		margin-left: 5px;
		padding: 8px 30px;
		display: block;
		float: right;
		margin-top: 5px;
		width: fit-content !important
	}

	.top-contrainer div p.prodate {
		display: inline-block;
		font-size: 14px;
		margin: 0;
		margin-bottom: 5px;
		border-radius: 15px;
		padding: 0 4px;
		margin-top: 10px;
		float: left;
		width: 13%;
		background: linear-gradient(to bottom, #d66f21 10%, #ea8335 35%, #f58e41 100%);
		color: white;
	}

	.top-contrainer div span {
		font-family: IwaUDGoDspPro-Eb, sans-serif !important;
		font-size: 16px;
		display: inline-block;
		float: right;
		width: 84%;
		margin-top: 9px;
	}

	.top-contrainer div p:not(.prodate) {
		display: inline-block;
		border-top: 2px solid #ed8639;
		margin-top: 10px;
		padding-top: 10px
	}

	.top-contrainer div a i {
		position: absolute;
		bottom: 15px;
		right: 15px;
		color: #fff;
		background: #ef883a;
		padding: 10px;
		border-radius: 50%
	}

	.top-contrainer div a {
		position: relative
	}

	.top-contrainer div a:hover {
		opacity: .8;
		transition-duration: .2s
	}

	@media (max-width: 576px) {
		.top-contrainer>p {
			position: unset;
			top: 0;
			left: 0;
			padding: 0
		}

		.top-contrainer {
			padding: 5px;
			border-bottom: unset;
		}

		.top-contrainer div div {
			display: block;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 0
		}

		.top-contrainer div img {
			width: 100%
		}

		.top-contrainer div {
			display: grid;
			width: 100%;
			padding: 0
		}

		.top-contrainer div p:not(.prodate) {
			padding-bottom: 10px;
			border-bottom: 2px solid #ebebeb;
			margin-bottom: 15px
		}
	}
</style>

<style>
    .new-textz{
        font-size: 16px !important;
        letter-spacing: 0.05em !important;
        line-height: 150% !important;
    }
</style>

<?php if(isset($product_key) && ($product_key == "omamori-keyholder")): //Only for Omamori Keyholder ?>

	<h2>自社生産・1個から製作可能！</h2>
	<div class="top-contrainer">

		<div>
			<a href="/products/acrylic/ownfactory"><img src="/products/acrylic/img/tip-detail-4.webp" width="378" height="207"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
			<div>
				<p class="prodate">特徴 01</p><span>全て自社で生産しています。だから、安い</span>
				<p class="new-textz">お客様の大切な製品を製作する会社として、責任を持って生産する為に、アクリル製品は全て自社の工場で生産しています。印刷からカット、アタッチメントの取り付け、検査、梱包まで全て社内で完結しています。</p>
			</div>
		</div>
		<div>
			<a href="/products/acrylic/1pcmoq"><img src="/products/acrylic/img/tip-detail-2.webp" width="378" height="207"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
			<div>
				<p class="prodate">特徴 02</p><span>オリジナルアクキーが、1個から注文できます</span>
				<p class="new-textz">当店なら、オリジナルデザイン印刷1個の注文でも喜んでお受けいたします。1個や2個の注文は以外と多いんですよ。</p>
			</div>
		</div>
		
	</div>

<?php else: ?>

	<?php 
		$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $urlSegments = explode('/', $urlPath);

		$image_protection = "img/acrylic-protection.webp";
		$image_one = "/products/acrylic/img/tip-detail-2.webp";
		$image_cnc = "/products/acrylic/img/tip-detail-3.webp";
		$image_factory = "/products/acrylic/img/tip-detail-4.webp";

		if((!empty($urlSegments[2]) && ($urlSegments[2] == "acrylic")) && (empty($urlSegments[3]) OR (!empty($urlSegments[3]) && in_array($urlSegments[3], array('index.php','index_test.php', 'figure','figure_test'))))) {
			$image_protection = "/products/acrylic/img/acrylic-protection20260608.webp";
			$image_one = "/products/acrylic/img/acrylic-one20260608.webp";
			$image_cnc = "/products/acrylic/img/acrylic-cnc20260608.webp";
			$image_factory = "/products/acrylic/img/acrylic-factory20260608.webp";
		}
	?>

	<h2>当店アクリルキーホルダー4つの特徴</h2>
	<div class="top-contrainer">
		<div>
			<a href="/products/acrylic/filmcoating"><img src="<?php echo $image_protection; ?>" width="378" height="207"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
			<div>
				<p class="prodate">特徴 01</p><span>印刷が剥がれない。しかもずっと綺麗</span>
				<p class="new-textz">当店のアクキーは、印刷面の全面をPETフィルムで保護します。印刷部分だけを保護するのではなく、面全体を透明シートで保護しますので、自然な製品の仕上がりとなります。</p>
			</div>
		</div>
		<div>
			<a href="/products/acrylic/1pcmoq"><img src="<?php echo $image_one; ?>" width="378" height="207"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
			<div>
				<p class="prodate">特徴 02</p><span>オリジナルアクキーが、1個から注文できます</span>
				<p class="new-textz">当店なら、オリジナルデザイン印刷1個の注文でも喜んでお受けいたします。1個や2個の注文は以外と多いんですよ。</p>
			</div>
		</div>
		<div>
			<a href="/products/acrylic/roundededge"><img src="<?php echo $image_cnc; ?>" width="378" height="207"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
			<div>
				<p class="prodate">特徴 03</p><span>エッジが滑らか。触って納得の仕上がりです</span>
				<p class="new-textz">とても細かなことですが、当店のこだわりです。アクリルのカットは通常レーザーが多く、カットした後に違和感のある盛り上がりができてしまいます。当店の製品はCNC加工機を使い、全ての製品の面取りをしています。エッジってどこ？という方は、上の写真で確認ください。</p>
			</div>
		</div>
		<div>
			<a href="/products/acrylic/ownfactory"><img src="<?php echo $image_factory; ?>" width="378" height="207"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
			<div>
				<p class="prodate">特徴 04</p><span>全て自社で生産しています。だから、安い</span>
				<p class="new-textz">お客様の大切な製品を製作する会社として、責任を持って生産する為に、アクリル製品は全て自社の工場で生産しています。印刷からカット、アタッチメントの取り付け、検査、梱包まで全て社内で完結しています。</p>
			</div>
		</div>
	</div>

<?php endif; ?>

