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

	if(isset($_GET['c'])&&$_GET['c']=="del"){
		unset($_SESSION['cus_orders_data']);
		unset($_SESSION['cus_orders_data2']);
	}
	$prd_premiun = "";$prd_poly = "";$prd_nylon = "";$prd_fc = ""; 
				$scolor_check0 = "checked";$scolor_check1 = "";
				$pcolor_check0 = "checked";$pcolor_check1 = "";
				$option_check0 = "checked";$option_check1 = "";
				$sample_check0 = "checked";$sample_check1 = "";
				$express_check0 = "checked";$express_check1 = "";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:p="http://www.evolus.vn/Namespace/Pencil" xmlns:html="http://www.w3.org/1999/xhtml">
<head>
	<!--head-->
	<?php require_once('../head.php')?>
	<!--end-->
	<meta name="robots" content="index,follow" />
	<link rel="canonical" href="/orders/index.php" />
	<meta name="description" content="รับผลิต ออกแบบสายคล้องคอพนักงาน สายคล้องบัตรด้วยเครื่องมือที่ได้มาตราฐานและสามารถผลิตสินค้าที่มีคุณภาพได้อย่างรวดเร็ว ลูกค้าสามารถสั่งซื้อสินค้าด้วยตัวเองได้ตลอด 24 ชั่วโมงจัดส่งฟรีทั่วประเทศ" />
	<meta name="keywords" content="สั่งทำสายคล้องคอพนักงาน, ซื้อสายคล้องคอพนักงาน, ราคาสายคล้องคอพนักงาน, สายคล้องคอพนักงาน, สายคล้องคอ, สายคล้องบัตร, รับออกแบบสายคล้องคอ, ผลิตสายคล้องคอ, ไซส์พิเศษ, แบบพิเศษ" />
	<title>สายคล้องบัตร|สายคล้องคอ|สั่งซื้อได้ตลอด 24 ชั่วโมง</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">โปรแกรมสั่งซื้อสายคล้องคอพนักงาน สายคล้องบัตรอัตโนมัติ</h1>
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
	<?php
		$d_step7 = "display:none;";
	?>
	<div id="container">
		<div class="container" id="orders">
			<form action="customer_details.php" method="post" id="form">
			<h2><?php lang("orders",$_SESSION["lang"]) ?></h2>
			<p style="display: none;">ยินดีต้อนรับเข้าสู่โปรแกรมสั่งซื้อสินค้าแบบอัตโนมัติ ที่จะช่วยให้คุณสามารถออกแบบคำสั่งซื้อหรือทำใบเสนอราคาได้ด้วยตัวของคุณเองตลอด 24 ชั่วโมง โดยท่านจะต้องทำตาม step 1-6 หากมีข้อสงสัยวิธีการใช้งานโปรดโหลด<a class="link2" href="order_webthai.pdf" target="_blank">PDF</a>สอนการใช้งาน หรือ<a class="link2" href="/guide/order_flow.php">คลิกที่นี่</a>เพื่ออ่านวิธีการใช้งาน หรือ<a href="/contact/" class="link2">ติดต่อเจ้าหน้าที่</a>นอกจากนี้ทางเรามีบริการจำหน่ายตัวอย่างสินค้าในราคา 350 บาท/เส้น(รวมค่าจัดส่งทั่วประเทศ)</p>
			<div class="abt_01">
			<div id="step1">
				<h3>step 1: กรุณาเลือกแบบเชือก<span class="red" id="error1"></span></h3>
				<div class="left">
					<select id="ItemType" name="ItemType">
						<option value="none">::ประเภทเชือก::</option>
						<option value="premium" <?=$prd_premiun?>><?php lang("premium",$_SESSION["lang"]) ?></option>
						<option value="poly" <?=$prd_poly?>><?php lang("poly",$_SESSION["lang"]) ?></option>
						<option value="nylon" <?=$prd_nylon?>><?php lang("nylon",$_SESSION["lang"]) ?></option>
						<option value="fullcolor" <?=$prd_fc?>><?php lang("fullcolor",$_SESSION["lang"]) ?></option>
					</select><br/>
					<select id="ItemSize" name="ItemSize" disabled="true">
						<option>::ขนาดเชือก::</option>
					</select><br/>
					<select id="ItemPrint" name="ItemPrint" disabled="true">
						<option>::ขนาดรูปแบบการพิมพ์::</option>
					</select>
					<div class="premium-option"></div>
					<p>หากต้องการสายคล้องคอขนาดพิเศษหรือสายคล้งคอแบบพิเศษกรุณา<a href="/contact/" class="link-red">ติดต่อเรา</a></p>
				</div>
				<div class="right"><div class="ord_img-box"></div></div>
			</div>
			<div id="step2">
				<h3>step 2: กรุณาเลือกสีเชือก<span class="red" id="error2"></span></h3>
				<h4>step 2.1: สีปกติ(คละสีได้มากสุด 5 สีตั้งแต่สีที่ 2 ขึ้นไปมีค่าใช้จ่ายเพิ่ม 800 บาทต่อสี/การสั่งซื้อ)</h4>
				<div class="color-container">
					<div class="row">
						<label class="label-radio">
							<img src="img/10_1.jpg">
							<input type="checkbox" name="prd_color[]" value="485C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_2.jpg">
							<input type="checkbox" name="prd_color[]" value="361C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_3.jpg">
							<input type="checkbox" name="prd_color[]" value="Reflex blue">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_4.jpg">
							<input type="checkbox" name="prd_color[]" value="Flag red">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_5.jpg">
							<input type="checkbox" name="prd_color[]" value="Orange C">
							<span class="checkmark"></span>
						</label>
					</div>
					<div class="row">
						<label class="label-radio">
							<img src="img/10_6.jpg">
							<input type="checkbox" name="prd_color[]" value="208C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_7.jpg">
							<input type="checkbox" name="prd_color[]" value="Purple C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_8.jpg">
							<input type="checkbox" name="prd_color[]" value="2607C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_9.jpg">
							<input type="checkbox" name="prd_color[]" value="1235C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_10.jpg">
							<input type="checkbox" name="prd_color[]" value="Yellow C">
							<span class="checkmark"></span>
						</label>
					</div>
					<div class="row">
						<label class="label-radio">
							<img src="img/10_11.jpg">
							<input type="checkbox" name="prd_color[]" value="1905C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_12.jpg">
							<input type="checkbox" name="prd_color[]" value="478C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_13.jpg">
							<input type="checkbox" name="prd_color[]" value="382C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_14.jpg">
							<input type="checkbox" name="prd_color[]" value="348C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_15.jpg">
							<input type="checkbox" name="prd_color[]" value="Process blue">
							<span class="checkmark"></span>
						</label>
					</div>
					<div class="row">
						<label class="label-radio">
							<img src="img/10_16.jpg">
							<input type="checkbox" name="prd_color[]" value="293C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_17.jpg">
							<input type="checkbox" name="prd_color[]" value="232C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_18.jpg">
							<input type="checkbox" name="prd_color[]" value="Coolgray6C">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_19.jpg">
							<input type="checkbox" name="prd_color[]" value="Black">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_20.jpg">
							<input type="checkbox" name="prd_color[]" value="White">
							<span class="checkmark"></span>
						</label>
					</div>
					<div class="row">	
						<label class="label-radio">
							<img src="img/10_21.jpg">
							<input type="checkbox" name="prd_color[]" value="Navy">
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							<img src="img/10_22.jpg">
							<input type="checkbox" name="prd_color[]" value="Dark Blue">
							<span class="checkmark"></span>
						</label>
					</div>
				</div>
				<h4 id="step2_2">step 2.2: สีเชือกพิเศษ(มีค่าใช้จ่ายสีละ 1500 บาท/การสั่งซื้อ)(กรุณาระบุสีที่ต้องการตาม Pantone หากไม่มีสีที่คุณต้องการในตารางสี)<span class="red" id="error2_2"></span></h4>
				<div class="color-s-select">
					<label class="label-radio">
						ต้องการ
						<input type="radio" name="prd_scolor" value="1" <?=$scolor_check1?>>
						<span class="checkmark"></span>
					</label>
					<label class="label-radio">
						ไม่ต้องการ
						<input type="radio" name="prd_scolor" value="0" <?=$scolor_check0?>>
						<span class="checkmark"></span>
					</label>
					<div class="color-s-container"></div>
				</div>
			</div>
			<div id="step3">
				<h3>step 3: กรุณาเลือกสีสกรีน(สกรีนได้มากสุด 6 สี ค่าใช้จ่ายสีละ 1000 บาท/การสั่งซื้อ สีสกรีนพื้นฐานจะเป็นสีขาวหากลูกค้าไม่เลือกสีอื่น)<span class="red" id="error3"></span></h3>
				<div class="color-s-select">
				<label class="label-radio">
						ต้องการสีอื่น
						<input type="radio" name="prd_pcolor" value="1" <?=$pcolor_check1?>>
						<span class="checkmark"></span>
					</label>
					<label class="label-radio">
						ไม่ต้องการสีอื่น
						<input type="radio" name="prd_pcolor" value="0" <?=$pcolor_check0?>>
						<span class="checkmark"></span>
					</label>
					<div class="color-p-container"></div>
				</div>
			</div>
			<div id="step4">
				<h3>step 4: กรุณาเลือกพาร์ท<span class="red" id="error4"></span></h3>
				<div id="step4_1">
				<h4>step 4.1: ส่วนประกอบเชือก(กรุณาเลือก free part หรือ other part หรือ yoyo part อย่างน้อย 1 ชนิด)</h4>
				<div class="part-container">
					<div class="row bblue">
						<span class="part-txt">:: Free part ::</span><br/>
						<label class="label-radio">
							<img src="img/part/part-01.jpg">
							<input type="radio" name="prd_part" value="n_1">
							<span class="checkmark"></span>
							<br/>ตะขอ<br/>(N-1)
						</label>
						<label class="label-radio">
							<img src="img/part/part-02.jpg">
							<input type="radio" name="prd_part" value="n_14">
							<span class="checkmark"></span>
							<br/>ตะขอ<br/>(N-14)
						</label>
						<label class="label-radio">
							<img src="img/part/part-03.jpg">
							<input type="radio" name="prd_part" value="n_7">
							<span class="checkmark"></span>
							<br/>ตะขอ<br/>(N-7)
						</label>
						<label class="label-radio">
							<img src="img/part/part-04.jpg">
							<input type="radio" name="prd_part" value="n_4">
							<span class="checkmark"></span>
							<br/>ตะขอ<br/>(N-4)
						</label>
						<label class="label-radio">
							<img src="img/part/part-09.jpg">
							<input type="radio" name="prd_part" value="clip_steel">
							<span class="checkmark"></span>
							<br/>คลิปหนีบ<br/>(Steel Clip)
						</label>
					</div>
					<div class="row bred">
						<span class="part-txt">:: Other part ::</span><br/>
						<label class="label-radio">
							<img src="img/part/part-05.jpg">
							<input type="radio" name="prd_part" value="n_15a">
							<span class="checkmark"></span>
							<br/>คลิปยูโร<br/>(N-15-A)
						</label>
						<label class="label-radio">
							<img src="img/part/part-06.jpg">
							<input type="radio" name="prd_part" value="n_15b">
							<span class="checkmark"></span>
							<br/>คลิปยูโร<br/>(N-15-B)
						</label>
						<label class="label-radio">
							<img src="img/part/part-07.jpg">
							<input type="radio" name="prd_part" value="n_10">
							<span class="checkmark"></span>
							<br/>ตัวหนีบ<br/>(N-10)
						</label>
						<label class="label-radio">
							<img src="img/part/part-08.jpg">
							<input type="radio" name="prd_part" value="n_20">
							<span class="checkmark"></span>
							<br/>ตะขอPVC<br/>(N-20)
						</label><br/>
						<label class="label-radio">
							<img src="img/part/pastic_part.jpg">
							<input type="radio" name="prd_part" value="pastic_part">
							<span class="checkmark"></span>
							<br/>ตะขอพลาสติก<br/>(N-12)
						</label>
						<label class="label-radio">
							<img src="img/part/mobile_01.jpg">
							<input type="radio" name="prd_part" value="mobile_01">
							<span class="checkmark"></span>
							<br/>สายห้อยโทรศัพท์<br/>มือถือ(แบบถอดได้)
						</label>
						<label class="label-radio">
							<img src="img/part/Oring.jpg">
							<input type="radio" name="prd_part" value="Oring">
							<span class="checkmark"></span>
							<br/>ห่วงวงกลม<br/>(O-ring)
						</label>
						<label class="label-radio">
							<img src="img/part/D_ring.jpg">
							<input type="radio" name="prd_part" value="D_ring">
							<span class="checkmark"></span>
							<br/>ห่วงครึ่งวงกลม<br/>(D-ring)
						</label><br/>
						<span class="part-txt">:: YoYo part(<a href="/products/yoyo.php" class="link2">ดูข้อมูลเพิ่มเติม</a>) ::</span><br/> 
						<table class="part-table">
							<tr>
								<td class="tb-40">
									<select name="yoyo_type" id="yoyo_type">
										<option value="none">::เลือกประเภทโยโย่::</option>
										<option value="black_white">โยโย่ขาว-ดำ</option>
										<option value="black">โยโย่ดำ</option>
										<option value="color">โยโย่สี</option>
									</select><br>
									<select name="yoyo_color" id="yoyo_color" disabled="true">
										<option>::เลือกสี::</option>
									</select><br>
									<select name="yoyo_sticker" id="yoyo_sticker" disabled="true">
										<option>::ต้องการสติกเกอร์หรือไม่::</option>
									</select>
								</td>
								<td class="tb-20">
									<div id="yoyo_img"></div>
								</td>
								<td class="tb-40">
									<span id="yoyo_txt">::ข้อมูลเพิ่มเติม::</span>
								</td>
							</tr>
						</table><br/>
					</div>
				</div>
				</div>
				<div class="option-container">
					<h4>step 4.2: ส่วนประกอบพิเศษ(ส่วนประกอบพิเศษมีค่าบริการ)</h4>
					<div class="color-s-select">
						<label class="label-radio">
							ต้องการ
							<input type="radio" name="prd_option" value="1" <?=$option_check1?>>
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							ไม่ต้องการ
							<input type="radio" name="prd_option" value="0" <?=$option_check0?>>
							<span class="checkmark"></span>
						</label>
						<div class="options-container">
							
						</div>
					</div>
				</div>
				<div class="soption-container">
					<h4>step 4.3: คุณต้องการตัวอย่างต้นแบบหรือไม่(<a href="/guide/order_flow.php#sample" class="link2" target="_blank">ข้อมูลเพิ่มเติม</a>)</h4>
					<div class="color-s-select">
						<label class="label-radio">
							ต้องการ
							<input type="radio" name="prd_sample" value="1" <?=$sample_check1?>>
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							ไม่ต้องการ
							<input type="radio" name="prd_sample" value="0" <?=$sample_check0?>>
							<span class="checkmark"></span>
						</label>
					</div>
					<h4>step 4.4: คุณต้องการแบบเร่งด่วนหรือไม่(ความต้องการแบบเร่งด่วนมีค่าบริการ <a class="link2" href="/products/product_detail.php#time" target="_blank">ดูระยะเวลาการผลิตเร่งด่วน</a>)(<a href="/guide/order_flow.php#express" class="link2" target="_blank">ข้อมูลเพิ่มเติม</a>)</h4>
					<div class="color-s-select">
						<label class="label-radio">
							ต้องการ
							<input type="radio" name="prd_express" value="1" <?=$express_check1?>>
							<span class="checkmark"></span>
						</label>
						<label class="label-radio">
							ไม่ต้องการ
							<input type="radio" name="prd_express" value="0" <?=$express_check0?>>
							<span class="checkmark"></span>
						</label>
					</div>
				</div>
			</div>
			<div id="step5">
				<h3>step 5: กรุณาเลือกซองใส่บัตรพนักงาน(ในกลุ่มสีฟ้าจะไม่มีค่าใช้จ่าย)<span class="red" id="error5"></span></h3>
				<table class="case-table">
					<tr>
						<td class="tb-20">
							<select id="card" name="prd_case">
								<option value="ID_STD_1" class="free">ซองใส่บัตรแบบอ่อน STD-1</option>
								<option value="ID_STD_2" class="free">ซองใส่บัตรแบบอ่อน STD-2</option>
								<option value="ID_STD_3" class="free">ซองใส่บัตรแบบอ่อน STD-3</option>
								<option value="ID_1_N">ซองใส่บัตรแบบอ่อน 1_N</option>
								<option value="ID_1_NZ">ซองใส่บัตรแบบอ่อน 1_NZ</option>
								<option value="ID_2_N">ซองใส่บัตรแบบอ่อน 2_N</option>
								<option value="ID_3_N">ซองใส่บัตรแบบอ่อน 3_N</option>
								<option value="ID_4_N">ซองใส่บัตรแบบอ่อน 4_N</option>
								<option value="ID_4_NZ">ซองใส่บัตรแบบอ่อน 4_NZ</option>
								<option value="ID_5_NZ">ซองใส่บัตรแบบอ่อน 5_NZ</option>
								<option value="ID_6_N">ซองใส่บัตรแบบอ่อน 6_N(ขนาดบัตรประชาชน)</option>
								<option value="ID_6_NZ">ซองใส่บัตรแบบอ่อน 6_NZ</option>
								<option value="ID_8_N">ซองใส่บัตรแบบอ่อน 8_N</option>
								<option value="ID_9_N">ซองใส่บัตรแบบอ่อน 9_N</option>
								<option value="ID_AC01">ซองใส่บัตรแบบอ่อน AC01</option>
								<option value="ID_AC02">ซองใส่บัตรแบบอ่อน AC02</option>
								<option value="ID_F001">ซองใส่บัตรแบบกรอบแข็ง F001</option>
								<option value="ID_F002">ซองใส่บัตรแบบกรอบแข็ง F002</option>
								<option value="ID_F003">ซองใส่บัตรแบบกรอบแข็ง F003</option>
								<option value="ID_F004">ซองใส่บัตรแบบกรอบแข็ง F004</option>
								<option value="none">ไม่รับซองใส่บัตร</option>
							</select>
						</td>
						<td class="tb-40">
							<div id="case_img"><img src="img/case/ID_STD_1.jpg?v=1.02" width="240"></div>
						</td>
						<td class="tb-40">
							<div id="case_txt">ID-STD-1<br/>ประเภท ：เคสแบบอ่อน<br/>ขนาดนามบัตร ：แนวตั้ง 64 mm × แนวนอน 92 mm<br/>ขนาดรอบนอก ：แนวตั้ง 87mm × แนวนอน 100 mm<br/>รูปแบบ ：ใส่นามบัตรแนวนอน<br/>สี：ไม่มีสี เป็นแบบใส(ด้านหน้า) 、ไม่มีสี เป็นลายนูนแบบใส(ด้านหลัง)<br/> ฝาและซิป  ：มีด้านหลัง รูซ้าย-ขวา ：เส้นผ่านศูนย์กลาง 4.4 mm<br/> รูกลาง ：กว้าง 17 mm  สูง 4.4 mm</div>
						</td>
					</tr>
				</table>
			</div>
			<div id="step6">
				<h3>step 6: ใส่จำนวนที่ต้องการสั่งซื้อ<span class="red" id="error6"></span></h3>
				<input type="number" name="qty" id="qty" value="<?=(isset($_SESSION["cus_orders_data"]['qty']))?$_SESSION["cus_orders_data"]['qty']:"";?>"> เส้น
				<div class="btn-ctu">
					<a href="/orders/?c=del" class="btn-s1" id="del">ล้าง</a>
					<a href="javascript:void(0)" class="btn-s1" id="cal">คำนวนราคา</a>
				</div>
			</div>
			<div id="step7" style="<?=$d_step7?>">
				<?php require_once('quotation/index.php') ?>
				<div class="btn-ctu">
					<a href="javascript:void(0)" class="btn-s1" id="print">พิมพ์ใบเสนอราคา</a>
					<input type="submit" class="btn-s1" id="" value="สั่งซื้อ" />
				</div>
			</div>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>

	<!-- Include js here -->
	<script type="text/javascript" src="js/js.js?v=1.14"></script>
	<script type="text/javascript" src="js/calculate.js?v=1.254"></script>
	<script type="text/javascript" src="js/printThis.js"></script>
	<script type="text/javascript">
		$(function() {<?php
				if(isset($_GET['c'])&&$_GET['c']=="back"){ 
				if(isset($_SESSION["cus_orders_data"]['ItemType'])){
					switch ($_SESSION["cus_orders_data"]['ItemType']) {
						case 'premium':
						$prd_premiun = "selected";
						echo"set_size('premium');set_img('premium','l');";
						break;
						case 'poly':$prd_poly = "selected";
						echo"set_size('poly');set_img('poly','l');";break;
						case 'nylon':$prd_nylon = "selected";
						echo"set_size('nylon');set_img('nylon','l');";break;
						case 'fullcolor':$prd_fc = "selected";
						echo"set_size('fullcolor');set_img('fullcolor','l');";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['ItemSize'])){
					switch ($_SESSION["cus_orders_data"]['ItemSize']) {
						case '10':echo"set_size_selected(10);";break;
						case '15':echo"set_size_selected(15);";break;
						case '20':echo"set_size_selected(20);";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['ItemPrint'])){
					switch ($_SESSION["cus_orders_data"]['ItemPrint']) {
						case 'font':echo"set_print_selected('font');";break;
						case 'all':echo"set_print_selected('all');";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['prd_color'])){
					foreach ($_SESSION["cus_orders_data"]['prd_color'] as $key => $value) {
						echo"set_color_checked('".$value."');";
					}
				}
				if(isset($_SESSION["cus_orders_data"]['prd_scolor'])){
					switch ($_SESSION["cus_orders_data"]['prd_scolor']) {
						case '1':
						$scolor_check0 = "";$scolor_check1 = "checked";
						echo "set_s_color(1);";
						if(isset($_SESSION["cus_orders_data"]['prd_stxt'])){
							echo "set_txt_scolor(".json_encode($_SESSION["cus_orders_data"]['prd_stxt']).");";
						}
						break;
						case '0':$scolor_check0 = "checked";$scolor_check1 = "";echo "set_s_color(0);";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['prd_pcolor'])){
					switch ($_SESSION["cus_orders_data"]['prd_pcolor']) {
						case '1':
						$pcolor_check0 = "";$pcolor_check1 = "checked";
						echo "set_p_color(1);";
						if(isset($_SESSION["cus_orders_data"]['prd_ptxt'])){
							echo "set_txt_pcolor(".json_encode($_SESSION["cus_orders_data"]['prd_ptxt']).");";
						}
						break;
						case '0':$pcolor_check0 = "checked";$pcolor_check1 = "";echo "set_s_color(0);";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['prd_part'])){
					echo "set_part_checked('".$_SESSION["cus_orders_data"]['prd_part']."');";
				}
				if(isset($_SESSION["cus_orders_data"]['yoyo_type'])&&$_SESSION["cus_orders_data"]['yoyo_type']!="none"){
					echo "set_yoyo_checked('".$_SESSION["cus_orders_data"]['yoyo_type']."','".$_SESSION["cus_orders_data"]['yoyo_color']."','".$_SESSION["cus_orders_data"]['yoyo_sticker']."');";
				}
				if(isset($_SESSION["cus_orders_data"]['premium_option'])){
					echo "set_part_checked('".$_SESSION["cus_orders_data"]['premium_option']."');";
				}
				if(isset($_SESSION["cus_orders_data"]['prd_option'])){
					switch ($_SESSION["cus_orders_data"]['prd_option']) {
						case '1':
						$option_check0 = "";$option_check1 = "checked";
						echo "set_s_option(1);";
						if(isset($_SESSION["cus_orders_data"]['option_other1'])){
						echo "set_part_checked('".$_SESSION["cus_orders_data"]['option_other1']."');";
						}
						if(isset($_SESSION["cus_orders_data"]['option_other2'])){
						echo "set_part_checked('".$_SESSION["cus_orders_data"]['option_other2']."');";
						}
						if(isset($_SESSION["cus_orders_data"]['option_other3'])){
						echo "set_part_checked('".$_SESSION["cus_orders_data"]['option_other3']."');";
						}
						if(isset($_SESSION["cus_orders_data"]['option_other4'])){
						echo "set_part_checked('".$_SESSION["cus_orders_data"]['option_other4']."');";
						}
						if(isset($_SESSION["cus_orders_data"]['option_s'])){
						echo "set_part_checked('".$_SESSION["cus_orders_data"]['option_s']."');";
						}
						break;
						case '0':$option_check0 = "checked";$option_check1 = "";echo "set_s_option(0);";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['prd_sample'])){
					switch ($_SESSION["cus_orders_data"]['prd_sample']) {
						case '1':$sample_check0 = "";$sample_check1 = "checked";break;
						case '0':$sample_check0 = "checked";$sample_check1 = "";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['prd_express'])){
					switch ($_SESSION["cus_orders_data"]['prd_express']) {
						case '1':$express_check0 = "";$express_check1 = "checked";break;
						case '0':$express_check0 = "checked";$express_check1 = "";break;
					}
				}
				if(isset($_SESSION["cus_orders_data"]['prd_case'])){
					echo "set_case_selected('".$_SESSION["cus_orders_data"]['prd_case']."');";
				}

			}?>})
	</script>

</body>
</html>