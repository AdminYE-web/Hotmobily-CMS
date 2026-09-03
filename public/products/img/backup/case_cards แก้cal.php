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
	<link rel="canonical" href="/products/case_cards.php" />
	<meta name="description" content="รับผลิตและออกแบบสายคล้องบัตร, สายคล้องคอพนักงานแถมฟรีซองใส่บัตรพนักงานและจัดสง่ฟรีทั่วประเทศ" />
	<meta name="keywords" content="ซองใส่บัตรพนักงาน, ซองพลาสติก, ใส่บัตร, สายคล้องคอพนักงาน, สายคล้องคอ, สายคล้องบัตร, ที่ใส่บัตรพนักงาน, บัตรพนักงาน, ซองพลาสติกใส่บัตร" />
	<title>ซองใส่บัตรพนักงาน|สายคล้องคอพนักงาน</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">ซองพลาสติก ซองใส่บัตรพนักงาน</h1>
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
				<h2>ซองใส่บัตรพนักงานแบบอ่อน</h2>
				<div id="box-show">
					<img src="img/banner-id.jpg">
				</div>
				<p>จัดจำหน่ายซองใส่บัตรพนักงาน ซองพลาสติกราคาถูกมีให้คุณเลือกมากถึง 14 แบบและแถมฟรีซองใส่บัตรแนวนอนแบบอ่อน เมื่อ<a href="/orders/" class="link2">สั่งซื้อ</a>พร้อมสายคล้องคอพนักงาน หากมีข้อสงสัย<a href="/contact/">กรุณาติดต่อพนักงานหรือ<span class="red">ตรวจสอบราคา</span><a href="#estimate" class="link2">ที่นี่</a></p>
				<h2>ซองใส่บัตรพนักงานแบบกรอบแข็ง</h2>
				<div class="table_01">
				    <div class="tb_00">
					    <div class="tr_01">
						    <div class="tb_02" id="box-show">
						    	<a href="img/F001.jpg?v=1.01" data-lightbox="id-hd">
						    		<img src="img/F001.jpg?v=1.01" width="320">
						    	</a>
						    </div>
						    <div class="tb_02" id="box-show">
						    	<a href="img/F002.jpg?v=1.01" data-lightbox="id-hd">
						    		<img src="img/F002.jpg?v=1.01" width="320">
						    	</a>
						    </div>
					    </div>
					    <div class="tr_01">
						    <div class="tb_02" id="box-show">
						    	<a href="img/F003.jpg?v=1.01" data-lightbox="id-hd">
						    		<img src="img/F003.jpg?v=1.01" width="320">
						    	</a>
						    </div>
						    <div class="tb_02" id="box-show">
						    	<a href="img/F004.jpg?v=1.02" data-lightbox="id-hd">
						    		<img src="img/F004.jpg?v=1.02" width="320">
						    	</a>
						    </div>
					    </div>
				    </div>
			    </div>
				<div class="btn-ctu">
					<a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a>
					<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
				</div>
				<h2>ตรวจสอบราคา</h2>
				<p>โปรแกรมคำนวนราคาซองใส่บัตรพนักงานแบบต่างๆทั้งซองใส่บัตรแนวตั้งและซองใส่บัตรแนวนอน โดย<span class="red">เลือกแบบซองใส่บัตรที่ต้อง</span>-> <span class="red">ใส่จำนวน</span> -> <span class="red">กดคำนวณราคา (เลือกแบบซองใส่บัตรเพื่อดูภาพแต่ละซองใส่บัตร)</span></p>
				<h3 class="blue" id="estimate">เลือกแบบซองใส่บัตร</h3>
				<table class="case-table">
					<tr>
						<td class="tb-20">
							<select id="card" name="prd_case">
								<option value="ID_STD_1" class="free">ซองใส่บัตรแบบอ่อนแนวนอน STD-1 ฟรี</option>
								<option value="ID_STD_2" class="free">ซองใส่บัตรแบบอ่อนแนวนอน STD-2 ฟรี</option>
								<option value="ID_STD_3" class="free">ซองใส่บัตรแบบอ่อนแนวนอน STD-3 ฟรี</option>
								<option value="ID_1_N">ซองใส่บัตรแบบอ่อน 1_N</option>
								<option value="ID_1_NZ">ซองใส่บัตรแบบอ่อน 1_NZ</option>
								<option value="ID_2_N">ซองใส่บัตรแบบอ่อน 2_N</option>
								<option value="ID_3_N">ซองใส่บัตรแบบอ่อน 3_N</option>
								<option value="ID_4_N">ซองใส่บัตรแบบอ่อน 4_N</option>
								<option value="ID_4_NZ">ซองใส่บัตรแบบอ่อน 4_NZ</option>
								<option value="ID_5_NZ">ซองใส่บัตรแบบอ่อน 5_NZ</option>
								<option value="ID_6_N">ซองใส่บัตรแบบอ่อน 6_N</option>
								<option value="ID_6_NZ">ซองใส่บัตรแบบอ่อน 6_NZ</option>
								<option value="ID_8_N">ซองใส่บัตรแบบอ่อน 8_N</option>
								<option value="ID_9_N">ซองใส่บัตรแบบอ่อน 9_N</option>
								<option value="ID_AC01">ซองใส่บัตรแบบอ่อน AC01</option>
								<option value="ID_AC02">ซองใส่บัตรแบบอ่อน AC02</option>
								<option value="ID_F001">ซองใส่บัตรแบบกรอบแข็ง F001</option>
								<option value="ID_F002">ซองใส่บัตรแบบกรอบแข็ง F002</option>
								<option value="ID_F003">ซองใส่บัตรแบบกรอบแข็ง F003</option>
								<option value="ID_F004">ซองใส่บัตรแบบกรอบแข็ง F004</option>
							</select>
						</td>
						<td class="tb-40">
							<div id="case_img"><img src="img/case/ID_STD_1.jpg?v=1.01" width="240"></div>
						</td>
						<td class="tb-40">
							<div id="case_txt">ID-STD-1<br/>ประเภท ：เคสแบบอ่อน<br/>ขนาดนามบัตร ：แนวตั้ง 64 mm × แนวนอน 92 mm<br/>ขนาดรอบนอก ：แนวตั้ง 87 mm × แนวนอน 100 mm<br/>รูปแบบ ：ใส่นามบัตรแนวนอน<br/>สี：ไม่มีสี เป็นแบบใส(ด้านหน้า) 、ไม่มีสี เป็นลายนูนแบบใส(ด้านหลัง)<br/> ฝาและซิป  ：มีด้านหลัง<br/> รูซ้าย-ขวา ：เส้นผ่านศูนย์กลาง 4.4 mm<br/> รูกลาง ：กว้าง 17 mm  สูง 4.4 mm</div>
						</td>
					</tr>
				</table>
				<h3 class="blue">ใส่จำนวน</h3>
				จำนวน <input type="number" name="qty" id="qty_case" value=""> ชิ้น
				<div class="btn-ctu"><a href="javascript:void(0)" class="btn-s1" id="cal_case">คำนวณราคา</a></div>
				<span class="red" id="show-price"></span><br/>
				<span class="red" id="show-remark"></span>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>

	<!-- Include js here -->
	<script type="text/javascript" src="/orders/js/js.js?v=1.06"></script>
	<script type="text/javascript" src="/orders/js/calculate.js?v=1.08"></script>
	<script type="text/javascript" src="js/calculate_test.js?v=1.01"></script>
</body>
</html>
