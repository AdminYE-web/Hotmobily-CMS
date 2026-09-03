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
	<link rel="canonical" href="/guide/cancel_return.php" />
	<meta name="description" content="เว็บไซต์ hotstrapthai.com  จัดจำหน่ายสายคล้องคอพนักงานตามความต้องการของลูกค้าโดยลูกค้า อีกทั้งลูกค้ายังสามารถยกเลิกคำสั่งซื้อและได้รับค่ามัดจำคืนอีกด้วย" />
	<meta name="keywords" content="วิธีการยกเลิกคำสั่งซื้อ, ยกเลิก, cancel, สายคล้องคอพนักงาน, สายคล้องคอ, มัดจำ, ราคาถูก" />
	<title>วิธีการยกเลิกคำสั่งซื้อ|สายคล้องคอพนักงาน</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel"><?php lang("wellcome",$_SESSION["lang"]) ?></h1>
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
				<h2>วิธีการยกเลิกคำสั่งซื้อ</h2>
				<h3 class="blue">รายละเอียดเงื่อนไขการยกเลิกคำสั่งซื้อ</h3>
				<p>หากลูกค้ามีความประสงที่จะยกเลิกคำสั่งซื้อจะมีอยู่ 2 กรณีคือ<br/> 
					1.) ในกรณีที่ยังไม่ได้ทำการชำระเงิน <span class="red">รายการคำสั่งซื้อของท่านจะถูกยกเลิกภายใน 7 วัน</span><br/>
					2.) ในกรณีที่ลูกค้าทำการชำระเงินเข้ามาเรียบร้อยแล้ว การยกเลิกคำสั่งซื้อจะถูกหักค่าบริการตามเงื่อนไขดังนี้<br/>
					&nbsp;&nbsp;2.1) หากลูกค้าต้องการยกเลิกคำสั่งซื้อหลังจากทำการชำระเงินเรียบร้อยแล้ว<span class="red">ภายใน 3 วัน</span> จะถูกหักค้าบริการเป็นจำนวน <span class="red">30%</span> ของยอดสั่งซื้อ<br/>
					&nbsp;&nbsp;2.2) หากลูกค้าต้องการยกเลิกคำสั่งซื้อหลังจากทำการชำระเงินเรียบร้อยแล้ว<span class="red">ภายใน 6 วัน</span> จะถูกหักค้าบริการเป็นจำนวน <span class="red">50%</span> ของยอดสั่งซื้อ<br/>
					&nbsp;&nbsp;2.2) หากลูกค้าต้องการยกเลิกคำสั่งซื้อโดยระยะเวลาหลังจากการชำระเงิน<span class="red">มากกว่า 6 วัน</span> ทางเราขอสงวนสิทธิในหักค่าบริการ 100% หากมีข้อสงสัยเพิ่มเติม<a href="/contact/" class="link2">กรุณาติดต่อเรา</a>
				</p>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>


</body>
</html>