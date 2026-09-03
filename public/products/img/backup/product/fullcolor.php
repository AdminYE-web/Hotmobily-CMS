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
	<link rel="canonical" href="/products/fullcolor.php" />
	<meta name="description" content="สายคล้องคอซับลิเมชั่น รับผลิตและออกแบบสายคล้องคอ พิมพ์ลายคมชัดเห็นรายละเอียดได้ชัดเจน สายคล้องคอราคาถูก ใช้วิธีการพิมพ์แบบซับลิเมชั่นซึ่งสามารถพิมพ์กี่สีก็ได้ลงบนสายคล้องคอ 1 เส้น ไม่มีขั้นต่ำในการสั่งผลิต" />
	<meta name="keywords" content="สกรีน,ซับลิเมชั่น,หลายเฉดสี,บัตรพนักงาน,หลากหลายสี,ติดทน,ออกแบบ, ไม่มีขั้นต่ำ" />
	<title>สายคล้องคอพนักงานแบบซับลิเมชัน | ไม่มีขั้นต่ำ | Hotstrapthai.com</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">สายคล้องคอพนักงาน - พิมพ์แบบซับลิเมชัน</h1>
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
	<div class="product" id="container">
		<div class="container">
			<div class="pd-main">
				<!--Side menu-->
				<?php require_once('side_menu.php')?>
				<!--end-->
				<div class="content">
					<h2><?php lang("fullcolor",$_SESSION["lang"]) ?></h2>
					<div class="slide_show">
						<div class="img-show">
							<img src="img/fc-1-b.jpg" id="prm-i1">
							<img src="img/fc-2-b.jpg" id="prm-i2" style="display: none;">
							<img src="img/fc-3-b.jpg" id="prm-i3" style="display: none;">
							<img src="img/fc-4-b.jpg" id="prm-i4" style="display: none;">
						</div>
						<div class="sub-show">
							<div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/fc-1-s.jpg"></a></div>
							<div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/fc-2-s.jpg"></a></div>
							<div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/fc-3-s.jpg"></a></div>
							<div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/fc-4-s.jpg"></a></div>
						</div><br/>
						<span class="red">*ติดต่อพนักงานขายขอรับตัวอย่างสายคล้องคอฟรี!<a href="/contact/" class="link2">ที่นี่</a></span>
					</div>
					<div class="txt-show">
						<span><?php lang("detail",$_SESSION["lang"]) ?></span>
						<table class="tbl-txt">
							<tr>
								<td class="td1">ชื่อสินค้า</td>
								<td class="td2">สายคล้องคอแบบซับลิเมชั่น</td>
							</tr>
							<tr>
								<td class="td1">ขนาดเชือก</td>
								<td class="td2">10mm, 15mm, 20mm และขนาดอื่นๆ</td>
							</tr>
							<tr>
								<td class="td1">สีเชือก</td>
								<td class="td2">พิมพ์แบบซับลิเมชั่น</td>
							</tr>
							<tr>
								<td class="td1">พาร์ทเชือกที่ใช้</td>
								<td class="td2">ตะขอ <a class="link2" href="parts.php">ดูเพิ่มเติม</a></td>
							</tr>
							<tr>
								<td class="td1">การจัดส่ง</td>
								<td class="td2"><a class="link2" href="product_detail.php#fullcolor">คลิกที่นี่</a></td>
							</tr>
						</table>
						<div class="btn-ctu">
							<a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a>
							<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
							<a href="/template/" class="btn-s1">Design template</a>
						</div>
					</div>
					<table class="tbl_vt">
						<tr>
							<td>
								<img src="img/mini-1pc.jpg"><br/>
							</td>
							<td>
								<img src="img/mini-3d.jpg"><br/>
							</td>
						</tr>
						<tr>
							<span class="red">*สายคล้องคอไม่มีขั้นต่ำ ติดต่อพนักงานเพื่อขอราคาสำหรับออเดอร์ต่ำกว่า 20 เส้น<a href="/contact/" class="link2">ที่นี่</a></span>
						</tr>
					</table>
					<h3 class="blue">ตารางแสดงราคาสายคล้องคอพนักงานแบบซับลิเมชั่น(พิมพ์ด้านเดียว)</h3>
					<img src="img/fullcolor_opt.jpg" class="img_center">
					<div class="exceed-table">
						<table class="tbl_prd" cellpadding="5" cellspacing="0">
							<tbody><tr align="center">
								<td>จำนวนเชือก</td>
								<td bgcolor="#E6E7E8">20 เส้น</td>
								<td bgcolor="#E6E7E8">30  เส้น</td>
								<td bgcolor="#E6E7E8">50  เส้น</td>
								<td bgcolor="#E6E7E8">100  เส้น</td>
								<td bgcolor="#E6E7E8">200  เส้น</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 10mm</td>
								<td><span class="red">90 บาท</span><br>
								(1,800 บาท)</td>
								<td><span class="red">90 บาท</span><br>
								(2,700 บาท)</td>
								<td><span class="red">90 บาท</span><br>
								(4,500 บาท)</td>
								<td><span class="red">56 บาท</span><br>
								(5,600 บาท)</td>
								<td><span class="red">40 บาท</span><br>
								(8,000 บาท)</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 15mm</td>
								<td><span class="red">92 บาท</span><br>
								(1,840 บาท)</td>
								<td><span class="red">92 บาท</span><br>
								(2,760 บาท)</td>
								<td><span class="red">92 บาท</span><br>
								(4,600 บาท)</td>
								<td><span class="red">58 บาท</span><br>
								(5,800 บาท)</td>
								<td><span class="red">42 บาท</span><br>
								(8,400 บาท)</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 20mm</td>
								<td><span class="red">94 บาท</span><br>
								(1,800 บาท)</td>
								<td><span class="red">94 บาท</span><br>
								(2,820 บาท)</td>
								<td><span class="red">94 บาท</span><br>
								(4,700 บาท)</td>
								<td><span class="red">60 บาท</span><br>
								(6,000 บาท)</td>
								<td><span class="red">43 บาท</span><br>
								(8,600 บาท)</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 25mm</td>
								<td><span class="red">97 บาท</span><br>
								(1,940 บาท)</td>
								<td><span class="red">97 บาท</span><br>
								(2,910 บาท)</td>
								<td><span class="red">97 บาท</span><br>
								(4,850 บาท)</td>
								<td><span class="red">64 บาท</span><br>
								(6,400 บาท)</td>
								<td><span class="red">46 บาท</span><br>
								(9,200 บาท)</td>
							</tr>


							<tr align="center">
								<td>จำนวนเชือก</td>
								<td bgcolor="#E6E7E8">300 เส้น</td>
								<td bgcolor="#E6E7E8">500 เส้น</td>
								<td bgcolor="#E6E7E8">1,000 เส้น</td>
								<td bgcolor="#E6E7E8">2,000 เส้น</td>
								<td bgcolor="#E6E7E8">3,000 เส้น</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 10mm</td>
								<td><span class="red">37  บาท</span><br>
								(11,100 บาท)</td>
								<td><span class="red">33 บาท</span><br>
								(16,500 บาท)</td>
								<td><span class="red">31 บาท</span><br>
								(31,000 บาท)</td>
								<td><span class="red">27 บาท</span><br>
								(54,000 บาท)</td>
								<td><span class="red">21 บาท</span><br>
								(63,000 บาท)</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 15mm</td>
								<td><span class="red">39  บาท</span><br>
								(11,700 บาท)</td>
								<td><span class="red">35 บาท</span><br>
								(17,500 บาท)</td>
								<td><span class="red">33 บาท</span><br>
								(33,000 บาท)</td>
								<td><span class="red">27 บาท</span><br>
								(54,000 บาท)</td>
								<td><span class="red">22 บาท</span><br>
								(66,000 บาท)</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 20mm</td>
								<td><span class="red">40 บาท</span><br>
								(12,000 บาท)</td>
								<td><span class="red">36 บาท</span><br>
								(18,000 บาท)</td>
								<td><span class="red">34 บาท</span><br>
								(34,000 บาท)</td>
								<td><span class="red">27 บาท</span><br>
								(54,000 บาท)</td>
								<td><span class="red">24 บาท</span><br>
								(72,000 บาท)</td>
							</tr>
							<tr align="center">
								<td bgcolor="#ffff99" class="red">ขนาด 25mm</td>
								<td><span class="red">43 บาท</span><br>
								(12,900 บาท)</td>
								<td><span class="red">39 บาท</span><br>
								(19,500 บาท)</td>
								<td><span class="red">37 บาท</span><br>
								(37,000 บาท)</td>
								<td><span class="red">30 บาท</span><br>
								(60,000 บาท)</td>
								<td><span class="red">26 บาท</span><br>
								(78,000 บาท)</td>
							</tr>


						</tbody></table></div>
						<div style="clear: both;">&nbsp;</div>
						<h3 class="blue">ตารางแสดงราคาสายคล้องคอพนักงานแบบซับลิเมชั่น(พิมพ์สองด้าน)</h3>
						<div class="exceed-table">
							<table class="tbl_prd" cellpadding="5" cellspacing="0">
								<tbody><tr align="center">
									<td>จำนวนเชือก</td>
									<td bgcolor="#E6E7E8">20 เส้น</td>
									<td bgcolor="#E6E7E8">30 เส้น</td>
									<td bgcolor="#E6E7E8">50 เส้น</td>
									<td bgcolor="#E6E7E8">100 เส้น</td>
									<td bgcolor="#E6E7E8">200 เส้น</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด10mm</td>
									<td><span class="red">101 บาท</span><br>
									(2,020 บาท)</td>
									<td><span class="red">101 บาท</span><br>
									(3,030 บาท)</td>
									<td><span class="red">101 บาท</span><br>
									(5,050 บาท)</td>
									<td><span class="red">70 บาท</span><br>
									(7,000 บาท)</td>
									<td><span class="red">50 บาท</span><br>
									(10,000 บาท)</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด 15mm</td>
									<td><span class="red">102 บาท</span><br>
									(2,040 บาท)</td>
									<td><span class="red">102 บาท</span><br>
									(3,060 บาท)</td>
									<td><span class="red">102 บาท</span><br>
									(5,100 บาท)</td>
									<td><span class="red">72 บาท</span><br>
									(7,200 บาท)</td>
									<td><span class="red">52 บาท</span><br>
									(10,400 บาท)</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด 20mm</td>
									<td><span class="red">105 บาท</span><br>
									(2,100 บาท)</td>
									<td><span class="red">105 บาท</span><br>
									(3,150 บาท)</td>
									<td><span class="red">105 บาท</span><br>
									(5,250 บาท)</td>
									<td><span class="red">73 บาท</span><br>
									(7,300 บาท)</td>
									<td><span class="red">53 บาท</span><br>
									(10,600 บาท)</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด 25mm</td>
									<td><span class="red">108 บาท</span><br>
									(2,160 บาท)</td>
									<td><span class="red">108 บาท</span><br>
									(3,240 บาท)</td>
									<td><span class="red">108 บาท</span><br>
									(5,400 บาท)</td>
									<td><span class="red">76 บาท</span><br>
									(7,600 บาท)</td>
									<td><span class="red">56 บาท</span><br>
									(11,200 บาท)</td>
								</tr>
								<tr align="center">
									<td>จำนวนเชือก</td>
									<td bgcolor="#E6E7E8">300 เส้น</td>
									<td bgcolor="#E6E7E8">500 เส้น</td>
									<td bgcolor="#E6E7E8">1000 เส้น</td>
									<td bgcolor="#E6E7E8">2000 เส้น</td>
									<td bgcolor="#E6E7E8">3000 เส้น</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด 10mm</td>
									<td><span class="red">46 บาท</span><br>
									(13,800 บาท)</td>
									<td><span class="red">41 บาท</span><br>
									(20,500 บาท)</td>
									<td><span class="red">35 บาท</span><br>
									(35,000 บาท)</td>
									<td><span class="red">28 บาท</span><br>
									(56,000 บาท)</td>
									<td><span class="red">23 บาท</span><br>
									(69,000 บาท)</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด 15mm</td>
									<td><span class="red">48 บาท</span><br>
									(14,400 บาท)</td>
									<td><span class="red">43 บาท</span><br>
									(21,500 บาท)</td>
									<td><span class="red">40 บาท</span><br>
									(40,000 บาท)</td>
									<td><span class="red">28 บาท</span><br>
									(56,000 บาท)</td>
									<td><span class="red">23 บาท</span><br>
									(69,000 บาท)</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด 20mm</td>
									<td><span class="red">48 บาท</span><br>
									(14,400 บาท)</td>
									<td><span class="red">44 บาท</span><br>
									(22,000 บาท)</td>
									<td><span class="red">40 บาท</span><br>
									(40,000 บาท)</td>
									<td><span class="red">29 บาท</span><br>
									(58,000 บาท)</td>
									<td><span class="red">26 บาท</span><br>
									(78,000 บาท)</td>
								</tr>
								<tr align="center">
									<td bgcolor="#ffff99" class="red">ขนาด 25mm</td>
									<td><span class="red">51 บาท</span><br>
									(15,300 บาท)</td>
									<td><span class="red">47 บาท</span><br>
									(23,500 บาท)</td>
									<td><span class="red">43 บาท</span><br>
									(43,000 บาท)</td>
									<td><span class="red">31 บาท</span><br>
									(62,000 บาท)</td>
									<td><span class="red">28 บาท</span><br>
									(84,000 บาท)</td>
								</tr>

							</tbody></table></div>
							<div class="txt-price">
								1) แถวบนคือราคาผลิตสินค้าต่อหน่วย แถวล่างคือราคาต่อหน่วย x จำนวนผลิต<br/>
								2) ราคานี้รวมค่าบรรจุใส่ถุง และค่าจัดส่งภายในประเทศต่อ 1 สถานที่<br/>
								3) หากสินค้าที่ท่านสั่งผลิตมีจำนวนมากก็จะได้ราคาถูกมากขึ้นและทางเราจะส่งสินค้าตัวอย่างให้ตรวจสอบก่อนผลิตจริงฟรี<br/>
								4) ตัวอย่างสินค้า (ดีไซน์ตัวอย่าง) ผลิตได้หนึ่งเส้นต่อหนึ่งรายการสั่งซื้อเท่านั้น<br/>
								5) อาจมีค่าใช้จ่ายเพิ่มเติมสำหรับพาร์ทออฟชั่นเสริม<br/>
								6) ราคาสินค้าที่แสดงยังไม่รวมภาษีมูลค่าเพิ่ม<br/>
								7) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ
							</div>
							<div style="clear: both;">&nbsp;</div>
							<img src="img/fullcolor-01.jpg">
							<h3 class="blue" id="nylon">สายคล้องคอพนักงานแบบซับลิเมชัน</h3>
							<div class="table_01">
								<div class="tb_00">
									<div class="tr_01">
										<div class="tb_01">ระยะเวลาการส่งมอบปกติ</div>
										<div class="tb_02">ภายใน 8~11 วันทำการ</div>
									</div>
								</div>
							</div>
							<div class="table_01">
								<div class="tb_00">
									<div class="tr_01">
										<div class="tb_05">เวลาส่งมอบแบบเร่งด่วน</div>
										<div class="tb_06">ภายใน 6~7 วันทำการ</div>
									</div>
								</div>
							</div>
							<p>
								*กรณีที่สั่งผลิตสินค้าไม่เกิน 3,000 เส้น(สำหรับการส่งมอบปกติ)<br>
								*กรณีที่สั่งผลิตสินค้าไม่เกิน 500 เส้น(สำหรับการส่งมอบแบบเร่งด่วน)<br>
								*หากเลือกสีเส้นตั้งแต่สองสีขึ้นไปจะใช้เวลาเพิ่มขึ้น<br>
								*วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์
							</p>
							<h3 class="blue">จุดเด่นของสายคล้องคอสกรีนแบบซับลิเมชั่น</h3>
							<p>เราสามารถสกรีนแบบซับลิเมชั่นได้จากภาพถ่ายหรือดีไซน์ที่มีการไล่โทนสีฉูดฉาด(Gradation) ได้ตามที่ท่านเป็นผู้ออกแบบ อีกทั้งยังสกรีนโลโก้ได้แบบไม่จำกัดจำนวนสีในราคาถูก ทั้งนี้อาจมีบางแบบที่ไม่สามารถสกรีนได้ สามารถตรวจสอบจากสายคล้องคอตัวอย่างที่อยู่ด้านล่าง
								หากเป็นโลโก้แบบพิเศษจะเป็นปัญหาได้ เราจะผลิตตัวอย่างสินค้าตามตำแหน่งดีไซน์ของลูกค้าที่ออกแบบมา 
								(*1) ให้ตรวจสอบก่อนการทำการผลิตจริง หรือหากเป็นงานที่ต้องการสั่งผลิตด่วน <br>
								(*2) ทางเราก็มีบริการเช่นกันหรือแม้กระทั่งสายขนาดพิเศษราคาถูกก็สามารถสั่งได้ <br>
								(*3)ระยะขอบและตำแหน่งในการสกรีนจะอยู่ประมาณ 2-3 cm <br>
							(*4)อาจจะมีวันหยุดของโรงงาน กรุณาแจ้งล่วงหน้าก่อนสั่งสินค้า</p>
							<h3 class="blue">วิธีการสกรีน</h3>
							<p>เราใช้วิธีการสกรีนแบบซับลิเมชั่นจากแบบดีไซน์ที่ลูกค้าออกแบบมา นำมาสกรีนลงบนพื้นสีขาว
								สามารถดูภาพอ้างอิงการสกรีนได้จากด้านล่าง การสกรีนแบบพิเศษนั้นจะทำด้วยวิธีการเทสีระเหิดผ่านความร้อนซ้ำหลายๆครั้ง
								เพื่อให้สีติดทน ไม่หลุดง่าย และแม้ว่าจะเป็นการสกรีนซ้ำหลายครั้ง แต่ลายที่ได้ก็จะมีความเรียบเนียน คมชัด ไม่หนาและขรุขระ
							การสกรีนแบบซับลิเมชั่นนั้นอาจมีข้อจำกัดเกี่ยวกับขนาดของเส้นโลโก้ ท่านสามารถดูรายละเอียดเพิ่มเติมได้จากด้านล่างนี้</p>
							<img src="img/fullcolor-02.jpg" class="img_center">
							<p class="red">จากสีพื้นของเชือกคือสีขาว เมือสกรีนแบบซับลิเมชั่นด้วยสีอื่นๆ ด้วยตัวอักษร หรือรูปร่างต่างๆ ความกว้างของเส้นโลโก้
								หรือส่วนที่เว้นให้เห็นสีขาวต้องกว้างอย่างน้อย0.3mm ขึ้นไปหากน้อยกว่า 0.3 mm อาจจะทำให้สีซึมเข้าบริเวณนั้น
							อาจจะทำให้มองไม่เห็นรูปร่าง หรืออักษรของโลโก้นั้นๆได้</p>
							<img src="img/fc_chklogo.jpg" class="img_center">
							<p class="red">จากภาพเป็นตัวอย่าง สายคล้องบัตรที่มีขนาดโลโก้เล็กกว่า 0.3mm จากการสกรีนสายคล้องบัตรนี้ ทำให้บางลายเส้นตามดีไซน์ไม่สามารถมองเห็นบนเส้นเชือกได้</p>
							<h3 class="blue">ขนาดเชือกที่รองรับ</h3>
							<p>โดยมาตรฐานแล้ว สามารถรองรับเชือกที่มีขนาด 10 mm, 15 mm และ 20 mm
							หากท่านต้องการเชือกที่มีขนาดใหญ่กว่า 20 mmขึ้นไป กรุณาติดต่อสอบถามล่วงหน้าเกี่ยวกับจำนวนที่สามารถสั่งผลิตได้</p>
							<h3 class="blue">วัสดุ</h3>
							<p>การสกรีนแบบซับลิเมชั่นจะสกรีนลงบนผ้าโพลีเอสเตอร์โดยเฉพาะ ซึ่งลายโลโก้จะเรียบเนียน ไม่ขรุขระ
							การสกรีนบนเชือกถักแบบFlat และ Tubeler นั้นผิวสัมผัสจะแตกต่างกัน ท่านจะได้รับสินค้าที่ท่านเป็นผู้ออกแบบในราคาถูกและสามารถขอดูตัวอย่างเชือกได้</p>
							<h3 class="blue">เปรียบเทียบความแตกต่างระหว่างการสกรีนแบบซิลค์สกรีนและการสกรีนแบบซับลิเมชั่น</h3>
							<div style="font-size: 16px;">การสกรีนแบบซิลค์สกรีนและการสกรีนแบบซับลิเมชั่นนั้นมีความแตกต่างกันหลายจุด สามารถดูรายละเอียดได้จากด้านล่างนี</div><br>
							<table class="tbl_prd" cellpadding="5" cellspacing="0">
								<tbody>
									<tr align="center">
										<td bgcolor="#F3B183">ประเภทการสกรีน</td>
										<td bgcolor="#F3B183">สกรีนแบบ 3D</td>
										<td bgcolor="#F3B183">การไล่โทนสี</td>
										<td bgcolor="#F3B183">ความคมชัด</td>
										<td bgcolor="#F3B183">ผิวสัมผัส</td>
										<td bgcolor="#F3B183">จำนวนสี</td>
										<td bgcolor="#F3B183">ความทนทาน (ความคงทนของสี)</td>
									</tr>
									<tr align="center">
										<td>การสกรีนแบบซิลค์สกรีน</td>
										<td style="font-size:150%">◎</td>
										<td style="font-size:150%">X</td>
										<td style="font-size:150%">〇</td>
										<td style="font-size:150%">〇</td>
										<td style="font-size:150%">△</td>
										<td style="font-size:150%">△</td>
									</tr>
									<tr align="center">
										<td>การสกรีนแบบซับลิเมชั่น</td>
										<td style="font-size:150%">X</td>
										<td style="font-size:150%">◎</td>
										<td style="font-size:150%">△</td>
										<td style="font-size:150%">〇</td>
										<td style="font-size:150%">◎</td>
										<td style="font-size:150%">◎</td>
									</tr>
								</tbody>
							</table>
							<div>◎ = ดีมาก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								〇 = ดี&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								△ = พอใช้&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							x = ไม่ได้</div>
							<div style="clear: both;">&nbsp;</div>
							<h3 class="blue">ดีไซน์สำหรับลูกค้าที่ต้องการใช้ไฟล์เป็น AI</h3>
							<p>ท่านสามารถดาวน์โหลดไฟล์ได้จาก <a class="link-red" href="#">Template</a> สำหรับการสกรีนแบบซับลิเมชั่น เมื่อท่านดาวน์โหลดไฟล์เรียบร้อยแล้ว
							สามารถนำไปออกแบบได้ตามต้องการ โดยเลือกขนาดของเชือกที่ต้องการ ซึ่งใน Template จะมี Layout ที่บอกระยะขอบที่สามารถสกรีนได้ไว้ด้วย</p>
							<h2>ส่วนประกอบสายคล้องคอ</h2>
							<div class="row-bs">
								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>ตะขอสปริง</h3>
										<img src="img/part_new/Lever_Nascan.jpg"><br />
										<span>วัสดุ : โลหะ<br />
											<font color="red">ราคาเริ่มต้น : 4 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											ใช้ห้อยบัตรพนักงาน, บัตร ID หรือบัตรต่างๆ เป็นตะขอที่ได้รับความนิยมเพราะสามารถกดเปิด-ปิดได้สะดวกด้วยมือเดียว
										</span>
									</div>
								</div>
								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>ตะขอเกี่ยวทรงแบน</h3>
										<img src="img/part_new/nasican.jpg"><br />
										<span>วัสดุ : โลหะ<br />
											<font color="red">ราคาเริ่มต้น : 4 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											หัวตะขอจะต่างจากตะขอแบบทั่วไป เหมาะสำหรับซองใส่บัตรพนักงานที่มีรูขนาดเล็ก
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>ตะขอสปริงดีดทรงรี</h3>
										<img src="img/part_new/Hook.jpg"><br />
										<span>วัสดุ : โลหะ<br />
											<font color="red">ราคาเริ่มต้น : 4 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											บริเวณส่วนเปิด-ปิดต้องใช้มือดันเข้าไปเพื่อเปิดซึ่งจะไม่เหมือนกับตะขอสปริงที่จะมีส่วนที่ยื่นออกมาจากด้านข้างเพื่อให้กดเปิด
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>ตะขอสปริงดีด</h3>
										<img src="img/part_new/Aminascan.jpg"><br />
										<span>วัสดุ : โลหะ<br />
											<font color="red">ราคาเริ่มต้น : 4 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											บริเวณส่วนเปิด-ปิด จะคล้ายกับตะขอสปริงดีดทรงรี
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>คลิปเหล็กแบบหนีบ</h3>
										<img src="img/part_new/clip_steel.jpg"><br />
										<span>วัสดุ : โลหะ<br />
											<font color="red">ราคาเริ่มต้น : 4 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm <br />
											คลิปหนีบโลหะ มีความแข็งแรง สามารถนำไปหนีบกับซองใส่บัตรพนักงานแบบพลาสติกได้
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>คลิปเหล็กแบบหนีบ+พีวีซี</h3>
										<img src="img/part_new/clip_steel_pvc.jpg"><br />
										<span>วัสดุ : โลหะ+พีวีซี (PVC)<br />
											<font color="red">ราคาเริ่มต้น : 9 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : ทุกขนาด<br />
											คลิปหนีบโลหะพร้อมตะขอพีวีซี เหมาะสำหรับนำไปคล้องกับซองใส่บัตรพนักงาน
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>คลิปหนีบ A</h3>
										<img src="img/part_new/Card_clipA.jpg"><br />
										<span>วัสดุ : พลาสติก<br />
											<font color="red">ราคาเริ่มต้น : 10 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm และขนาดอื่น ๆ<br />
											ชิ้นส่วนนี้สามารถนำไปใช้สำหรับหนีบบัตรพนักงาน หรือ ID Card ได้โดยตรง หรือนำไปหนีบไว้ที่กระเป๋าเสื้อได้ด้วย
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>ตะขอพีวีซี</h3>
										<img src="img/part_new/PVC.jpg"><br />
										<span>วัสดุ : พีวีซี (PVC)<br />
											<font color="red">ราคาเริ่มต้น : 9 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											ชิ้นส่วนนี้สามารถใช้ห้อยบัตรพนักงาน บัตรID Card หรือบัตรต่างๆ
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>คลิปยูโร A</h3>
										<img src="img/part_new/Removable-A.jpg"><br />
										<span>วัสดุ : ABS+สปริงโลหะ+ตะขอโลหะ<br />
											<font color="red">ราคาเริ่มต้น : 31 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(มีเฉพาะสีดำ),
											20 mm(มีเฉพาะสีขาว)<br />
											ตัวคลิปผลิตในประเทศญี่ปุ่น คุณภาพดีมาก ในส่วนของคลิปสามารถถอดแยกเพื่อนำไปหนีบกับกระเป๋าเสื้อ,กางเกงได้
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>คลิปยูโร B</h3>
										<img src="img/part_new/Removable-B.jpg"><br />
										<span>วัสดุ : พลาสติก+ตะขอโลหะ+ตะขอเรซิ่น<br />
											<font color="red">ราคาเริ่มต้น : 13 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											ตัวคลิปสามารถแยกออกจากห่วงโลหะได้เพื่อนำไปติดเข้ากับสายคล้องคอเพื่อใช้ห้อยบัตรต่างๆ จะนำมาใช้ห้อยบัตร ID หรือบัตรพนักงานไว้ที่กระเป๋าเสื้อหรือบริเวณอื่นก็ได้
										</span>
									</div>
								</div>

								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>คลิปยูโร C</h3>
										<img src="img/part_new/euro_c.jpg"><br />
										<span>วัสดุ : พลาสติก+แกนโลหะ <br />
											<font color="red">ราคาเริ่มต้น : 15 บาท</font><br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(มีเฉพาะสีขาว)<br />
											คลิปพลาสติกเนื้อดี แกนโลหะ มีความแข็งแรงและทนทาน ส่วนปลายคลิปวัสดุเป็นยางอ่อน มีความยืดหยุ่นสูงทำให้ใช้งานได้ยาวนาน
										</span>
									</div>
								</div>
							</div>
							<h3 class="blue">ส่วนประกอบพิเศษสำหรับสายคล้องคอแบบโพลีเอสเตอร์</h3>
							<div class="row-bs">
								<div class="col-sm-6 col-12">
									<div style="padding: 0 10px;">
										<h3>Safety part</h3>
										<img src="img/part_new/Safety-part.jpg"><br />
										<span>วัสดุ: พลาสติก มีสีดำ, สีขาว (ขนาด 20 mm จะมีแค่สีดำ)<br />
											ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											ชิ้นส่วนที่แข็งแรงนี้จะช่วยป้องกันให้สายคล้องคอหลุดออกจากคอยากขึ้น
											<a href="img/ins_sf.jpg" data-lightbox="img1" data-title="" class="link2" style="text-decoration:none;">จุดที่สามารถติดตั้ง Safety part ได้</a>หรือคลิก<a href="img/MVI_0719.mp4" target="_blank" class="link2">ที่นี่</a>เพื่อดูวิดิโอสาธิตการใช้งาน</span>
										</div>
									</div>
									<div class="col-sm-6 col-12">
										<div style="padding: 0 10px;">
											<h3>สายห้อยโทรศัพท์มือถือ</h3>
											<img src="img/part_new/mobile.jpg"><br />
											<span>วัสดุ : พลาสติก (ยกเว้นส่วนที่เป็นห่วงและสายห้อยโทรศัพท์)<br />
												ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm และขนาดอื่นๆ<br />
											ชิ้นส่วนสำหรับห้อยโทรศัพท์มือถือ หรืออุปกรณ์ต่างๆ สามารถแยกออกจากกันได้ มีให้เลือก2สี คือ สีขาว และสีดำ</span>
										</div>
									</div>
									<div class="col-sm-6 col-12">
										<div style="padding: 0 10px;">
											<h3>ตัวล็อกก้ามปู</h3>
											<img src="img/part_new/Buckle.jpg"><br />
											<span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br />
												ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											และขนาดอื่น ๆ (สามารถใช้กับเชือกขนาด 30 mmได้ รูปทรงอาจแตกต่างกันเล็กน้อย) ชิ้นส่วนนี้นำไปติดเข้ากับสายคล้องคอ และสามารถถอดออกได้โดยกดตรงด้านข้างของตัวล็อคก้ามปูแล้วดึงออก</span>
										</div>
									</div>
									<div class="col-sm-6 col-12">
										<div style="padding: 0 10px;">
											<h3>ตัวเลื่อนปรับความยาวแบบ A</h3>
											<img src="img/part_new/parts_A.jpg"><br />
											<span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br />
												ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
											ชิ้นส่วนนี้จะใช้สำหรับปรับระดับความสั้น ความยาวของสายคล้องคอได้</span>
										</div>
									</div>
									<div class="col-sm-6 col-12">
										<div style="padding: 0 10px;">
											<h3>ตัวเลื่อนปรับความยาวแบบ B</h3>
											<img src="img/part_new/parts_B.jpg"><br />
											<span>วัสดุ : พลาสติก (มีเฉพาะสีดำเท่านั้น )<br />
												ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(Flat)<br />
											ชิ้นส่วนนี้จะอยู่บริเวณคอเมื่อกดปุ่มสีดำแล้วเลื่อนจะสามารถปรับความยาวของสายคล้องคอให้สั้นหรือยาวได้</span>
										</div>
									</div>
									<div class="col-sm-6 col-12">
										<div style="padding: 0 10px;">
											<h3>ตัวเลื่อนปรับความยาวแบบ C</h3>
											<img src="img/part_new/parts_C.jpg"><br />
											<span>วัสดุ : พลาสติก ( มีเฉพาะสีดำเท่านั้น )<br />
												ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm(Tubeler), 15 mm(Flat)<br />
											ชิ้นส่วนนี้จะอยู่บริเวณคอ สามารถใช้เลื่อนเพื่อปรับระดับความยาวของสายคล้องคอได้ตามต้องการ</span>
										</div>
									</div>
									<div class="col-sm-6 col-12">
										<div style="padding: 0 10px;">
											<h3>ตัวล็อกแบบหนีบ</h3>
											<img src="img/part_new/caulking.jpg"><br />
											<span>วัสดุ : โลหะ<br />
												ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm<br />
												ชิ้นส่วนนี้เป็นโลหะรูปทรงสี่เหลี่ยมผืนผ้าที่นำไปติดเข้ากับสาย
											คล้องคอ เพื่อพับส่วนปลายเก็บที่ด้านหลังแทนการเย็บ</span>
										</div>
									</div>
								</div>
								<div class="btn-ctu">
									<a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a>
									<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
									<a href="/template/" class="btn-s1">Design template</a>
								</div>
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
