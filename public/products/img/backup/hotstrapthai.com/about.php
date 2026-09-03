<?php
	session_start();
	require('lang.php');
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
	<?php require_once('head.php')?>
	<!--end-->
	<meta name="robots" content="index,follow" />
	<link rel="canonical" href="/about.php" />
	<meta name="description" content="เกี่ยวกับเรา บริษัท ยูแอนด์ เอิร์ธ ซิสเท็ม จำกัดก่อตั้งเพื่อผลิตและจำหน่ายสายคล้องบัตรมานานกว่า 10 ปีภายใต้โรงงานผลิตสายคล้องบัตรของเราเอง ซึ่งสามารถควบคุมคุณภาพการผลิต เพื่อให้ลูกค้ามั่นใจว่าจะได้รับสายคล้องบัตรที่มีคุณภาพที่สุด" />
	<meta name="keywords" content="ยูแอนด์เอิร์ธ, youandearth, ญี่ปุ่น, สายคล้องคอพนักงาน, เกี่ยวกับเรา, สายคล้องคอ, สายคล้องบัตร, โรงงานผลิต" />
	<title>เกี่ยวกับเรา - โรงงานผลิตสายคล้องบัตร</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">บริษัท ยูแอนด์ เอิร์ธ ซิสเท็ม จำกัด</h1>
			<p class="lang">
				<a href="<?=$escaped_url;?>?l=th">TH</a>|<a href="<?=$escaped_url;?>?l=en">EN</a>
			</p>
			<div class="line_api">
				<a href="http://line.me/ti/p/~youandearth.th" target="_blank"><img src="/images/line_btn.png"></a>
			</div>
		</div>
	</div>
	<!--header-->
	<?php require_once('header.php')?>
	<!--end-->
	<div id="container">
		<div class="container" id="about">
			<div class="abt_01">
				<div class="left">
					<p><span class="txt-hilight">บริษัท ยูแอนด์ เอิร์ธ ซิสเท็ม จำกัด</span><br/><br/> 
					&nbsp;&nbsp;&nbsp;ก่อตั้งเมื่อวันที่ 5 กรกฎาคม 2550 สำนักงานใหญ่ตั้งอยู่ที่ประเทศญี่ปุ่น
					โดยนายมาซะโนริ คาโดตะ ประธานกรรมการบริษัท มีนโนบายจะขยายธุรกิจและขยายตลาด
					เพื่อให้เป็นที่รู้จักในประเทศไทยจึงเปิดสาขาในประเทศไทยในนามบริษัท ยู แอนด์ เอิร์ธ ซิสเท็ม จำกัด โดยดำเนินธุรกิจเกี่ยวกับการออกแบบและจำหน่ายสายคล้องคอและซองใส่บัตรคุณภาพดี ราคามาตรฐาน พร้อมประสบการณ์ที่ยาวนานกว่า 10 ปี ซึ่งทางบริษัทฯ มีทีมดีไซน์เนอร์ที่สามารถออกแบบ และให้คำปรึกษากับลูกค้าได้ตรงตามความต้องการด้วยมาตราฐานของสินค้า และราคาที่เหมาะสม 
					เพื่อตอบสนองไลฟ์สไตล์ขององค์กรให้โดดเด่น ซึ่งบริษัทชั้นนำต่างเลือกใช้บริการของเราด้วยโรงงานผลิตสายคล้องบัตรของเราเอง</p>
				</div>
				<div class="right"><img src="/images/ye-logo.jpg"></div>
			</div>
			<div class="abt_02">
				<div class="left"><img src="/images/factory.jpg"></div>
				<div class="right">
					<p>บริษัทของเรามีฐานการผลิตสายคล้องคอที่อยู่ที่มณฑลกว้างตุ้ง ประเทศจีน
					ควบคุมคุณภาพการผลิตด้วยมาตราฐานญี่ปุ่น เรามีโรงงานผลิตสายคล้องบัตรของเราเอง
					ลูกค้าสามารถกำหนดรายละเอียดและออกแบบสายได้อย่างอิสระ ด้วยโรงงานที่ได้รับมาตราฐาน
					เราสามารถผลิตสายคล้องบัตรที่มีคุณภาพออกมาอย่างต่อเนื่อง</p>
				</div>
			</div>
			<div class="abt_01">
				<div class="left">
					<p><span class="txt-hilight">ภาพรวมบริษัท</span><br/><br/>
					รับออกแบบสายคล้องคอ ซึ่งมีลักษณะและวัสดุของตัวสายคล้องให้เลือกได้ถึง 4 ประเภท 
					ได้แก่ พรีเมี่ยม โพลีเอสเตอร์ ไนลอน และ ซับลิเมชั่น
					ทั้งนี้ท่านสามารถเลือกส่วนประกอบของสายคล้องคอต่างได้อย่างหลากหลายตามต้องการ</p>
				</div>
				<div class="right"><img src="/images/product_sum.jpg"></div>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121776510-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-121776510-1');
	</script>

</body>
</html>