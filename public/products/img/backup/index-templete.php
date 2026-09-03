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
	<link rel="canonical" href="/template/index.php" />
	<meta name="description" content="บริษัท ยูแอนด์ เอิร์ธ ซิสเท็ม จำกัด รับออกแบบและผลิตสายคล้องคอตามคำสั่งซื้อของลูกค้า ด้วยประสบการณ์ยาวนานกว่า 10 ปี มีสายคล้องคอให้เลือกมากถึง 4 แบบ มี design template ที่ช่วยให้ลูกค้าออกแบบการสั่งซื้อให้ง่ายขึ้น" />
	<meta name="keywords" content="design, ดีไซน์สายคล้องคอ, สายคล้องคอ, ราคาสาคล้องคอ, สายคล้องคอพนักงาน, งานออกแบบ, สายคล้องบัตร, ออกแบบสายคล้องคอ" />
	<title>วิธีออกแบบ|สายคล้องคอพนักงาน</title>
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
				<h2>วิธีการออกแบบ</h2>
				<h3 class="blue m0">คำอธิบาย</h3>
				<p>ในส่วนของวิธีการออกแบบสายคล้องคอ ลูกค้าสามารถเลือกแบบสายและดาวน์โหลด AI/PDF ตามแบบที่ลูกค้าต้องการได้ตามด้านล่าง ในไฟล์จะมีข้อมูลดีไซน์, ข้อมูลสี, ข้อมูลเกี่ยวกับการสกีนโลโก้หรือชื่อ, ขนาดเชือก, ตัวอย่างดีไซน์และข้อมูลอื่นๆ ขอให้ลูกค้าโปรดทำความเข้าใจข้อมูลต่างๆเพื่อความรวดเร็วในการผลิตและออกแบบสายคล้องคอ หากมีข้อสงสัยเพิ่มเติมโปรด<a href="/contact/" class="link2">ติดต่อเรา</a></p>
				<h3 class="blue">สายค้ลองคอแบบพรีเมียม ไฟล์ .ai</h3>
				<a href="/download/download.php?fname=Template Design_PREMIUM_10mm.ai">Template Design_PREMIUM_10mm.ai</a><br/>
				<a href="/download/download.php?fname=Template Design_PREMIUM_15mm.ai">Template Design_PREMIUM_15mm.ai</a><br/>
				<h3 class="blue">สายค้ลองคอแบบผ้าโพลีเอสเตอร์/ผ้าไนลอน ไฟล์ .ai</h3>
				<a href="/download/download.php?fname=Template Design_STANDARD_10mm.ai">Template Design_STANDARD_10mm.ai</a><br/>
				<a href="/download/download.php?fname=Template Design_STANDARD_15mm.ai">Template Design_PREMIUM_15mm.ai</a><br/>
				<a href="/download/download.php?fname=Template Design_STANDARD_20mm.ai">Template Design_PREMIUM_20mm.ai</a><br/>
				<h3 class="blue">สายค้ลองคอแบบซับลิเมชัน ไฟล์ .ai</h3>
				<a href="/download/download.php?fname=Template Design_sublimation_10mm.ai">Template Design_sublimation_10mm.ai</a><br/>
				<a href="/download/download.php?fname=Template Design_sublimation_15mm.ai">Template Design_sublimation_15mm.ai</a><br/>
				<a href="/download/download.php?fname=Template Design_sublimation_20mm.ai">Template Design_sublimation_20mm.ai</a><br/>
				<div style="clear: both;">&nbsp;</div>
				<h3 class="blue">สายค้ลองคอแบบพรีเมียม ไฟล์ .pdf</h3>
				<a href="/download/download.php?fname=Template Design_PREMIUM_10mm.pdf">Template Design_PREMIUM_10mm.pdf</a><br/>
				<a href="/download/download.php?fname=Template Design_PREMIUM_15mm.pdf">Template Design_PREMIUM_15mm.pdf</a><br/>
				<h3 class="blue">สายค้ลองคอแบบผ้าโพลีเอสเตอร์/ผ้าไนลอน ไฟล์ .pdf</h3>
				<a href="/download/download.php?fname=Template Design_STANDARD_10mm.pdf">Template Design_STANDARD_10mm.pdf</a><br/>
				<a href="/download/download.php?fname=Template Design_STANDARD_15mm.pdf">Template Design_PREMIUM_15mm.pdf</a><br/>
				<a href="/download/download.php?fname=Template Design_STANDARD_20mm.pdf">Template Design_PREMIUM_20mm.pdf</a><br/>
				<h3 class="blue">สายค้ลองคอแบบซับลิเมชัน ไฟล์ .pdf</h3>
				<a href="/download/download.php?fname=Template Design_sublimation_10mm.pdf">Template Design_sublimation_10mm.pdf</a><br/>
				<a href="/download/download.php?fname=Template Design_sublimation_15mm.pdf">Template Design_sublimation_15mm.pdf</a><br/>
				<a href="/download/download.php?fname=Template Design_sublimation_20mm.pdf">Template Design_sublimation_20mm.pdf</a>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>
</body>
</html>