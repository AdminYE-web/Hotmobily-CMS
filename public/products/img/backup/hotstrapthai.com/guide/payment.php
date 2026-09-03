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
	<link rel="canonical" href="/guide/payment.php" />
	<meta name="description" content="เว็บไซต์ hotstrapthai.com  จัดจำหน่ายสายคล้องคอพนักงานตามความต้องการของลูกค้าโดยลูกค้า ยิ่งซื้อมากยิ่งได้รับราคาที่ถูกมาก อีกทั้งยังจ่ายเพียงแค่มัดจำก่อนรับสินค้าได้อีกด้วย" />
	<meta name="keywords" content="วิธีการชำระเงิน, สายคล้องคอพนักงาน, สายคล้องคอ, ไทยพาณิชย์, กรุงเทพ" />
	<title>วิธีการชำระเงิน|สายคล้องคอพนักงาน</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">วิธีการชำระเงิน</h1>
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
				<h2>วิธีการชำระเงิน</h2>
				<h3 class="blue">รายละเอียดเงื่อนไขการชำระเงิน</h3>
				<p>เงื่อนไขในการชำระเงินจะถูกออกแบบรูปแบบหลักๆดังนั้<br/>
					1.) ในกรณีที่คำสั่งซื้อมีมูลค่า<span class="red">น้อยกว่า 10,000 บาท</span> ลูกค้าจะต้องชำระเงิน<span class="red">เต็มจำนวน</span><br/>
					2.) ในกรณีที่คำสั่งซื้อมีมูลค่า<span class="red">มากกว่า 10,000 บาทแต่ไม่เกิน 50,000 บาท</span> ลูกค้าที่สั่งซื้อในนามบริษัท สามารถชำระเงินได้โดย<span class="red">มัดจำ 50% ของยอกการสั่งซื้อ ส่วนลูกค้าทั่วไปต้องชำระเงินเต็มจำนวนมูลค่าการสั่งซื้อ</span><br/>
					3.) ในกรณีที่คำสั่งซื้อมีมูลค่า<span class="red">มากกว่า 50,000 บาทขึ้นไป</span> ลูกค้ากรุณาสอบถามอัตราการชำระเงินมัดจำได้กับทางเราโดย <a href="/contact/" class="link2">คลิกที่นี่</a> หรือเมลสอบถามมาได้ที่ <a href="mailto:contact_hs@hotstrapthai.com" class="link2">contact_hs@hotstrapthai.com</a> หรือโทร <a href="tel:026378995" class="link2">02-637-8995</a> 
				</p>
				<h3 class="blue">รายละเอียดการชำระเงิน</h3>
				<p>รายละเอียดการชำระเงิน ลูกค้าสามารถทำได้สองวิธีคือ<br/>
					1.)โอนเงินมาที่ </p>
					<table class="tbl-txt tbl-cont">
					<tbody><tr>
						<td class="td3">ธนาคาร</td>
						<td class="td4"><p>ไทยพาณิชย์</p></td>
					</tr>
					<tr>
						<td class="td3">เลขที่บัญชี</td>
						<td class="td4"><p>191-204022-3</p></td>
					</tr>
					<tr>
						<td class="td3">ชื่อบัญชี</td>
						<td class="td4"><p>บริษัทยูแอนด์เอิร์ธซิสเท็ม จำกัด</p></td>
					</tr>
					<tr>
						<td class="td3">สาขา</td>
						<td class="td4"><p>โรงพยาบาลเซนต์หลุยส์</p></td>
					</tr>
					</tbody></table>
				<p>2.) ลูกค้าสามารถเดินทางมาชำระเงินด้วยตนเองได้ที่ <br/>152 อาคารชาร์เตอร์ สแควร์ 
					ถนนสาทรเหนือ แขวงสีลม เขตบางรัก กทม 10500 <br/>
					โทรศัพท์ : 02-637-8997, 02-266-5929 <br/>
					เวลาทำการ : จันทร์-ศุกร์ เวลา 08:30-17:30น. 
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