<?php
	session_start();
	require('../lang.php');
	if(isset($_GET['l'])&&($_GET['l']=="th"||$_GET['l']=="en")){
		$lang = $_GET['l'];
		$_SESSION["lang"] = $lang;
	}else{
		if(!isset($_SESSION["lang"])){
			$lang = "th";
			$_SESSION["lang"] = $lang;
		}
	}
	$url_this = "//{$_SERVER['HTTP_HOST']}";
	$url_this = $url_this."".strtok($_SERVER["REQUEST_URI"],'?');
	$escaped_url = htmlspecialchars( $url_this, ENT_QUOTES, 'UTF-8' );
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:p="http://www.evolus.vn/Namespace/Pencil" xmlns:html="http://www.w3.org/1999/xhtml">
<head>
	<!--head-->
	<?php require_once('../head.php')?>
	<!--end-->
	<meta name="robots" content="index,follow" />
	<link rel="canonical" href="/guide/index.php" />
	<meta name="description" content="บริษัท ยูแอนด์ เอิร์ธ ซิสเท็ม จำกัด รับออกแบบและผลิตสายคล้องคอ สายคล้องบัตรตามคำสั่งซื้อของลูกค้า โดยมีวิธีสั่งซื้อและข้อมูลต่างๆ เกี่ยวกับสายคล้องคอให้กับลูกค้าอย่างครบถ้วน" />
	<meta name="keywords" content="วิธีสั่งซื้อ, วิธีชำระเงิน, วิธียกเลิกคำสั่งซื้อ, วิธีออกแบบ, สายคล้องคอพนักงาน, สายคล้องคอ, สายคล้องบัตร" />
	<title>วิธีสั่งซื้อ|สายคล้องคอพนักงาน</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">วิธีสั่งซื้อ</h1>
			<p class="lang">
				<a href="<?=$escaped_url;?>?l=th">TH</a>|<a href="<?=$escaped_url;?>?l=en">EN</a>
			</p>
			<div class="line_api">
				<a href="http://line.me/ti/p/~youandearth.th" target="_blank"><img src="/images/line_btn.png"></a>
			</div>
		</div>
	</div>
	<!--header-->
	<?php require_once('../header.php')?>
	<!--end-->
	<div id="container">
		<div class="container">
			<!--Side menu-->
			<?php require_once('side_menu.php')?>
			<!--end-->
			<div class="content">
				<h2>ขั้นตอนการสั่งซื้อสินค้า</h2>
				<div class="box">
					<a href="order_flow.php"><img src="img/guide-01.jpg" width="32%"></a>
					<a href="/template/"><img src="img/guide-02.jpg" width="32%"></a>
					<a href="payment.php"><img src="img/guide-03.jpg" width="32%"></a>
				</div>
				<div class="box">
					<a href="/products/product_detail.php"><img src="img/guide-04.jpg" width="32%"></a>
					<a href="cancel_return.php"><img src="img/guide-05.jpg" width="32%"></a>
					<a href="/contact/"><img src="img/guide-06.jpg" width="32%"></a>
				</div>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>


</body>
</html>