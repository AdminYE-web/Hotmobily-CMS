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
	<link rel="canonical" href="/gallery/index.php" />
	<meta name="description" content="บริษัทรับออกแบบ ผลิต และจำหน่ายสายคล้องคอพนักงานรูปแบบต่างๆ มีวัสดุประกอบสายคล้องคอมากมาย ซึ่งคุณสามารถเลือกได้ตามความต้องการ ลองเข้ามาดูตัวอย่างผลงานที่ผ่านมาของเรากัน" />
	<meta name="keywords" content="ลูกค้าของเรา, ตัวอย่างสายคล้องคอ, สายคล้องบัตร, สายคล้องคอ, ผลงาน" />
	<title>ตัวอย่างสายคล้องคอลูกค้าของเรา</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">ตัวอย่างสายคล้องคอ ลูกค้าของเรา</h1>
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
			<h2>ตัวอย่างสายคล้องคอลูกค้าของเรา</h2>	
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=1"><img src="img/sample1-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 15/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=2"><img src="img/sample2-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 15/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=3"><img src="img/sample3-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 17/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=4"><img src="img/sample4-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมี่ยม</p><br><p>ผลิตวันที่: 17/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=5"><img src="img/sample5-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 20/8/2018</p></div>
				</div>	
			</div>
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=6"><img src="img/sample6-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 23/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=7"><img src="img/sample7-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมี่ยม</p><br><p>ผลิตวันที่: 24/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=8"><img src="img/sample8-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 02/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=9"><img src="img/sample9-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 04/9/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=10"><img src="img/sample10-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น</p><br><p>ผลิตวันที่: 27/8/2018</p></div>
				</div>	
			</div>
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=11"><img src="img/sample11-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 28/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=12"><img src="img/sample12-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมี่ยม</p><br><p>ผลิตวันที่: 01/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=13"><img src="img/sample13-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=14"><img src="img/sample14-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมี่ยม</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=15"><img src="img/sample15-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
			</div>
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=16"><img src="img/sample16-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=17"><img src="img/sample17-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=18"><img src="img/sample18-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=19"><img src="img/sample19-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=20"><img src="img/sample20-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
			</div>
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=21"><img src="img/sample21-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=22"><img src="img/sample22-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมี่ยม</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=23"><img src="img/sample23-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมี่ยม</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=24"><img src="img/sample24-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=25"><img src="img/sample25-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 06/8/2018</p></div>
				</div>	
			</div>
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=26"><img src="img/sample26-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 12/9/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=27"><img src="img/sample27-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบซับลิเมชั่น</p><br><p>ผลิตวันที่: 01/10/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=28"><img src="img/sample28-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบซับลิเมชั่น</p><br><p>ผลิตวันที่: 01/10/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=29"><img src="img/sample29-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 28/09/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=30"><img src="img/sample30-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 02/10/2018</p></div>
				</div>	
			</div>
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=31"><img src="img/sample31-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบซับลิเมชั่น</p><br><p>ผลิตวันที่: 02/10/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=32"><img src="img/sample32-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 10/10/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=33"><img src="img/sample33-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบซับลิเมชั่น</p><br><p>ผลิตวันที่: 16/10/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=34"><img src="img/sample34-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 18/10/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=35"><img src="img/sample35-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าไนลอน</p><br><p>ผลิตวันที่: 18/10/2018</p></div>
				</div>	
			</div>
			<div class="gallery-box2">
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=36"><img src="img/sample36-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมียม</p><br><p>ผลิตวันที่: 25/10/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=37"><img src="img/sample37-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมียม</p><br><p>ผลิตวันที่: 31/10/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=38"><img src="img/sample38-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบซับลิเมชั่น</p><br><p>ผลิตวันที่: 08/11/2018</p></div>
				</div>
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=39"><img src="img/sample39-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานแบบพรีเมียม</p><br><p>ผลิตวันที่: 10/10/2018</p></div>
				</div>	
				<div class="subg-box">
					<div class="img-show2"><a href="product_detail.php?id=40"><img src="img/sample40-1.jpg"></a></div>
					<div class="sub-show2"><p>สายคล้องคอพนักงานผ้าโพลีเอสเตอร์</p><br><p>ผลิตวันที่: 16/10/2018</p></div>
				</div>	
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>

	<!-- <script type="text/javascript" src="js/js.js"></script> -->

</body>
</html>
