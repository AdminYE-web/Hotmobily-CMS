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
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = 1;
	}
	switch ($id) {
		case '1':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "10 ครั้ง";
			$color = "485C";
			$print_color = "White";
			$part = "ตะขอสปริงดีดทรงรี";
		break;
		case '2':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "485C";
			$print_color = "White";
			$part = "ตะขอสปริงดีด";
		break;
		case '3':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "4 ครั้ง + 1 ครั้ง";
			$color = "Black";
			$print_color = "White, 382C, Pantone Rhodamine Red C, Pantone 2645C";
			$part = "ตะขอสปริงดีด, ตัวล็อคก้ามปู, Safty part, ตัวเลื่อนปรับความยาวแบบ A";
		break;
		case '4':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "5 ครั้ง";
			$color = "293C_3";
			$print_color = "Yellow C";
			$part = "คลิปขาว, ตัวล็อคเหล็ก, ตัวเลื่อนบอลกลม";
		break;
		case '5':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "2607 C_17";
			$print_color = "White";
			$part = "ตะขอสปริงดีด";
		break;
		case '6':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "9 ครั้ง";
			$color = "208 C_5";
			$print_color = "Gold";
			$part = "ตะขอสปริงดีด, ตัวล็อคก้ามปู";
		break;
		case '7':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "5 ครั้ง";
			$color = "Reflex Blue";
			$print_color = "White";
			$part = "คลิปขาว, โลโก้เรซิ่น, ตัวเลื่อนบอลกลม";
		break;
		case '8':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "1 ครั้ง";
			$color = "Black";
			$print_color = "White";
			$part = "ตะขอสปริงดีด, ตัวล็อคก้ามปู";
		break;
		case '9':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "7 ครั้ง";
			$color = "Black";
			$print_color = "Pantone 2010C";
			$part = "ตะขอสปริงดีดทรงรี";
		break;
		case '10':
			$type = "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "-";
			$color = "-";
			$print_color = "-";
			$part = "ตะขอสปริงดีด";
		break;
		case '11':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "6 ครั้ง";
			$color = "Black";
			$print_color = "White";
			$part = "ตะขอสปริงดีด";
		break;
		case '12':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "1 ครั้ง";
			$color = "Process Blue";
			$print_color = "White";
			$part = "คลิปขาว, ตัวล็อคเหล็ก, ตัวเลื่อนบอลกลม";
		break;
		case '13':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 10mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "11 ครั้ง";
			$color = "Purple C_18";
			$print_color = "White";
			$part = "ตะขอสปริงดีด, ตัวเลื่อนปรับความยาวแบบ C";
		break;
		case '14':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "6 ครั้ง";
			$color = "White_11";
			$print_color = "Pantone Cool Gray 6C, Pantone 485C";
			$part = "ตะขอสปริงดีด, โลโก้เรซิ่น, ตัวเลื่อนบอลกลม";
		break;
		case '15':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "White, Reflex blue_1";
			$print_color = "Silver";
			$part = "คลิปยูโร B";
		break;
		case '16':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "Cool Gray 6 C_20";
			$print_color = "Pantone 485C, White";
			$part = "คลิปยูโร B, ห่วงวงกลม";
		break;
		case '17':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 10mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "10 ครั้ง";
			$color = "361 C_12";
			$print_color = "White";
			$part = "คลิปยูโร A";
		break;
		case '18':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "Reflex Blue";
			$print_color = "485C, White";
			$part = "ตะขอสปริงดีดทรงรี, ตัวเลื่อนปรับความยาวแบบ B";
		break;
		case '19':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "1905 C_15";
			$print_color = "White";
			$part = "ตะขอสปริงดีด, ตัวเลื่อนปรับความยาวแบบ E";
		break;
		case '20':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 10mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "11 ครั้ง";
			$color = "Orange C";
			$print_color = "White";
			$part = "สายห้อยโทรศัพท์(แบบถอดได้), ตัวล็อคเหล็ก";
		break;
		case '21':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "Yellow C_16";
			$print_color = "Black";
			$part = "คลิปหนีบ A";
		break;
		case '22':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "11 ครั้ง";
			$color = "293C";
			$print_color = "White";
			$part = "คลิปยูโร A, โลโก้เรซิ่น, ตัวเลื่อนบอลกลม";
		break;
		case '23':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "6 ครั้ง";
			$color = "Black_4";
			$print_color = "485C, White";
			$part = "คลิปดำ, สายห้อยโทรศัพท์, โลโก้เรซิ่น, ตัวเลื่อนบอลกลม";
		break;
		case '24':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "Black";
			$print_color = "485C, White";
			$part = "โยโย่+สกรีน, ตัวเลื่อนปรับความยาวแบบ C";
		break;
		case '25':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง";
			$color = "2607 C_17";
			$print_color = "485C, White";
			$part = "ตะขอสปริงดีดพลาสติก, หมุดเหล็ก";
		break;
		case '26':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "6 ครั้ง";
			$color = "485C";
			$print_color = "White";
			$part = "ตะขอสปริงดีด";
		break;
		case '27':
			$type = "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "พิมพ์ทั้งสองด้าน";
			$color = "-";
			$print_color = "-";
			$part = "ตะขอสปริงดีด";
		break;
		case '28':
			$type = "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "พิมพ์ทั้งสองด้าน";
			$color = "-";
			$print_color = "-";
			$part = "ตะขอสปริงดีด, Safty";
		break;
		case '29':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "12 ครั้ง";
			$color = "298 C";
			$print_color = "White";
			$part = "ตะขอสปริงดีด,ตัวล็อคแบบหนีบ";
		break;
		case '30':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "17 ครั้ง(พิมพ์ทั้งสองด้าน)";
			$color = "Black_4";
			$print_color = "White";
			$part = "ตะขอสปริงดีด, ห่วงวงกลม, ตัวล็อคก้ามปู, Safty, ตัวเลื่อนปรับความยาวแบบ A";
		break;
		case '31':
			$type = "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "-";
			$color = "-";
			$print_color = "-";
			$part = "ตะขอสปริงดีด";
		break;
		case '32':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "5 ครั้ง(พิมพ์ทั้งสองด้าน)";
			$color = "Black_4";
			$print_color = "Gold";
			$part = "ตะขอสปริงดีดทรงรี";
		break;
		case '33':
			$type = "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";
			$lenght = "กว้าง : 25mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "พิมพ์ทั้งสองด้าน";
			$color = "-";
			$print_color = "-";
			$part = "ตะขอ PVC, D-ring";
		break;
		case '34':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "13 ครั้ง";
			$color = "Reflex Blue";
			$print_color = "White";
			$part = "ตะขอสปริงดีด";
		break;
		case '35':
			$type = "สายคล้องคอพนักงานผ้าไนลอน";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "2 ครั้ง";
			$color = "Yellow_C";
			$print_color = "White";
			$part = "ตะขอสปริงดีดทรงรี";
		break;
		case '36':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "9 ครั้ง";
			$color = "232C";
			$print_color = "White";
			$part = "คลิปขาว, โลโก้เรซิ่น, ตัวเลื่อนบอลกลม";
		break;
		case '37':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "10 ครั้ง";
			$color = "Orange_C";
			$print_color = "Black_4k";
			$part = "คลิปขาว, โลโก้เรซิ่น, ตัวเลื่อนบอลกลม";
		break;
		case '38':
			$type = "สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น";
			$lenght = "กว้าง : 15mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "พิมพ์ทั้งสองด้าน";
			$color = "-";
			$print_color = "-";
			$part = "ตะขอสปริงดีด";
		break;
		case '39':
			$type = "สายคล้องคอพนักงานแบบพรีเมี่ยม";
			$lenght = "กว้าง : 10mm, ยาว : 1000mm(พับครึ่ง 500mm)";
			$print_count = "5 ครั้ง";
			$color = "Reflex Blue";
			$print_color = "White";
			$part = "คลิปขาว, โลโก้เรซิ่น, ตัวเลื่อนบอลกลม";
		break;
		case '40':
			$type = "สายคล้องคอพนักงานผ้าโพลีเอสเตอร์";
			$lenght = "กว้าง : 20mm, ยาว : 900mm(พับครึ่ง 450mm)";
			$print_count = "8 ครั้ง(พิมพ์ทั้งสองด้าน)";
			$color = "Flag_Red";
			$print_color = "White, PANTONE 293C";
			$part = "ตะขอสปริงดีดทรงรี";
		break;
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:p="http://www.evolus.vn/Namespace/Pencil" xmlns:html="http://www.w3.org/1999/xhtml">
<head>
	<!--head-->
	<?php require_once('../head.php')?>
	<!--end-->
	<meta name="robots" content="index,follow" />
	<link rel="canonical" href="/gallery/product_detail.php" />
	<meta name="description" content="บริษัทรับออกแบบ ผลิต และจำหน่ายสายคล้องคอพนักงานรูปแบบต่างๆ มีวัสดุประกอบสายคล้องคอมากมาย ซึ่งคุณสามารถเลือกได้ตามความต้องการ ลองเข้ามาดูตัวอย่างผลงานที่ผ่านมาของเรากัน" />
	<meta name="keywords" content="ลูกค้าของเรา, ตัวอย่างสายคล้องคอ, สายคล้องบัตร, สายคล้องคอ, ผลงาน" />
	<title>รายละเอียดตัวอย่างสายคล้องคอพนักงาน</title>
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">รายละเอียดตัวอย่างสายคล้องคอพนักงาน ลูกค้าของเรา</h1>
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
			<h2>รายละเอียดตัวอย่างสายคล้องคอพนักงาน ลูกค้าของเรา</h2>
			<div class="flexslider">
	          <ul class="slides">
	            <li data-thumb="img/sample<?=$id;?>-1.jpg">
	  	    	    <img src="img/sample<?=$id;?>-1.jpg" />
	  	    	</li>
	  	    	<li data-thumb="img/sample<?=$id;?>-2.jpg">
	  	    	    <img src="img/sample<?=$id;?>-2.jpg" />
	  	    	</li>
	  	    	<li data-thumb="img/sample<?=$id;?>-3.jpg">
	  	    	    <img src="img/sample<?=$id;?>-3.jpg" />
	  	    	</li>
	  	    	<li data-thumb="img/sample<?=$id;?>-4.jpg">
	  	    	    <img src="img/sample<?=$id;?>-4.jpg" />
	  	    	</li>
	          </ul>
        	</div>
        	<div style="clear: both;">&nbsp;</div>
        	<table class="tbl-txt tbl-cont">
				<tr>
					<td class="td3">รูปแบบสายคล้องคอ</td>
					<td class="td4"><?=$type?></td>
				</tr>
				<tr>
					<td class="td3">ขนาดสายคล้องคอพนักงาน</td>
					<td class="td4"><?=$lenght?></td>
				</tr>
				<tr>
					<td class="td3">จำนวนพิมพ์โลโก้</td>
					<td class="td4"><?=$print_count?></td>
				</tr>
				<tr>
					<td class="td3">สีเชือก</td>
					<td class="td4"><?=$color?></td>
				</tr>
				<tr>
					<td class="td3">สีสกรีน</td>
					<td class="td4"><?=$print_color?></td>
				</tr>
				<tr>
					<td class="td3">ส่วนประกอบสายคล้องคอพนักงาน</td>
					<td class="td4"><?=$part?></td>
				</tr>
			</table>
			<div class="btn-ctu">
				<a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a>
				<a href="/gallery/" class="btn-s1">กลับหน้าหลัก</a>
				<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>

	<!-- <script type="text/javascript" src="js/js.js"></script> -->
	<!-- FlexSlider -->
  	<script defer src="js/jquery.flexslider.js"></script>
  	<script type="text/javascript">
    $(function() {
	  $('.flexslider').flexslider({
	    animation: "slide",
	    controlNav: "thumbnails"
	  });
	});
  </script>
</body>
</html>
