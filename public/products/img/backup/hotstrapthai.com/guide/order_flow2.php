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
	<meta name="robots" content="noindex" />
	<link rel="canonical" href="/guide/order_flow.php" />
	<meta name="description" content="เว็บไซต์ hotstrapthai.com มีคู่มือที่จะช่วยให้ลูกค้าสามารถสั่งซื้อสินค้าได้อย่างง่ายดาย พร้อมทั้งบอกราคาให้อย่างครบถ้วน การันตีได้ว่าลูกค้าจะได้รับสินค้ามีคุณภาพในราคาที่ถูกใจ" />
	<meta name="keywords" content="วิธีการสั่งซื้อ, สายคล้องคอพนักงาน, สายคล้องคอ, ซองใส่บัตรพนักงาน, ซับลิเมชั่น" />
	<title>วิธีการสั่งซื้อ|สายคล้องคอพนักงาน</title>
	<style type="text/css">
		.shadow_lvl1_2{
			-webkit-filter: drop-shadow(5px 5px 5px #949090);
    		filter: drop-shadow(5px 5px 5px #949090)
		}
		.content{
			background: url(img/ord_human.png) right bottom no-repeat;
			min-height: 750px !important;
		}
		#box-show2{
			position: relative;
			width: 100%;
			height: 100px;
		}
		#box-show2 img{
			position: absolute;
		    width: 48%;
		    
		}
		#box-show2 img:nth-of-type(1) {
		    left: 0px;
		}
		#box-show2 img:nth-of-type(2) {
		    right: 0px;
		}
		@media screen and (max-width: 600px) {
			#box-show2{
				position: relative;
			    width: 100%;
			    height: 30px;
			}
			.content{
				min-height: 300px !important;
			}
			.img_center{
				width: 50%;
			}
		}
	</style>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">วิธีการสั่งซื้อ</h1>
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
				<div class="img_center">
					<img src="img/ord_title.png" alt="ขั้นตอนการสั่งซื้อ">
				</div>
				<div style="clear: both;">&nbsp;</div>
				<div id="box-show2">
					<figure><img src="img/ord1.png" alt="" class="shadow_lvl1_2">
					<img src="img/ord2.png" alt="" class="shadow_lvl1_2"></figure>
				</div>					
				<div style="clear: both;">&nbsp;</div>
				<div id="box-show2">
					<figure><img src="img/ord3.png" alt="" class="shadow_lvl1_2">
					<img src="img/ord4.png" alt="" class="shadow_lvl1_2"></figure>
				</div>
				<div style="clear: both;">&nbsp;</div>
				<div id="box-show2">
					<figure><img src="img/ord5.png" alt="" class="shadow_lvl1_2">
					<img src="img/ord6.png" alt="" class="shadow_lvl1_2"></figure>
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