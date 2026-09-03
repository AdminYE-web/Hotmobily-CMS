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
	<link rel="canonical" href="/products/nylon.php" />
	<meta name="description" content="สายคล้องคอผ้าไนลอน สายคล้องคอราคาถูกสกรีนคมชัด สกรีนแบบซิลสกรีนไม่แตกหลุดง่ายเหมือนการสกรีนแบบทั่วไป สายคล้องคอขนาด 10,15,20mm. สายคล้องคอไม่มีขั้นต่ำ 1 เส้นก็สั่งได้" />
	<meta name="keywords" content="ผลิต,ผ้าไนลอน,ราคาถูก,สกรีนโลโก้,สกรีน,น้ำหนักเบา,งานด่วน,ไม่มีขั้นต่ำ" />
	<title>สายคล้องคอผ้าไนลอน | ไม่มีขั้นต่ำ | Hotstrapthai.com</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">สายคล้องคอพนักงาน - ผ้าไนลอน</h1>
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
				<h2><?php lang("nylon",$_SESSION["lang"]) ?></h2>
				<div class="slide_show">
				<div class="img-show">
					<img src="img/nylon-1-b.jpg?v=1.01" id="prm-i1">
					<img src="img/nylon-2-b.jpg?v=1.01" id="prm-i2" style="display: none;">
					<img src="img/nylon-3-b.jpg?v=1.01" id="prm-i3" style="display: none;">
					<img src="img/nylon-4-b.jpg?v=1.01" id="prm-i4" style="display: none;">
				</div>
				<div class="sub-show">
					<div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/nylon-1-s.jpg?v=1.01"></a></div>
					<div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/nylon-2-s.jpg?v=1.01"></a></div>
					<div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/nylon-3-s.jpg?v=1.01"></a></div>
					<div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/nylon-4-s.jpg?v=1.01"></a></div>
				</div><br/>
				<span class="red">*ติดต่อพนักงานขายขอรับตัวอย่างสายคล้องคอฟรี!<a href="/contact/" class="link2">ที่นี่</a></span>
				</div>
				<div class="txt-show">
					<span><?php lang("detail",$_SESSION["lang"]) ?></span>
					<table class="tbl-txt">
						<tr>
							<td class="td1">ชือสินค้า</td>
							<td class="td2">สายคล้องคอผ้าไนลอน</td>
						</tr>
						<tr>
							<td class="td1">ขนาดเชือก</td>
							<td class="td2">10mm, 15mm, 20mm และขนาดอื่นๆ</td>
						</tr>
						<tr>
							<td class="td1">สีเชือก</td>
							<td class="td2">2607C<a class="link2" href="product_color_nyl.php">ดูเพิ่มเติม</a></td>
						</tr>
						<tr>
							<td class="td1">พาร์ทเชือกที่ใช้</td>
							<td class="td2">ตะขอพลาสติก, กระดุมเหล็ก<a class="link2" href="parts.php">ดูเพิ่มเติม</a></td>
						</tr>
						<tr>
							<td class="td1">การจัดส่ง</td>
							<td class="td2"><a class="link2" href="#nylon">คลิกที่นี่</a></td>
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
				<h3 class="blue">ตารางราคาสายคล้องคอพนักงานแบบไนลอน</h3>
				<img src="img/nylon_opt.jpg" class="img_center">
				<div class="exceed-table">
				<table class="tbl_prd" cellpadding="5" cellspacing="0">
            <tbody>
            <tr align="center" bgcolor="#E6E7E8">
              <td width="15%" colspan="2" bgcolor="#ffffff">&nbsp;</td>
              <td width="8%">20 เส้น+</td>
              <td width="8%">30 เส้น+</td>
              <td width="8%">50 เส้น+</td>
              <td width="8%">100 เส้น+</td>
              <td width="8%">200 เส้น+</td>
              <td width="8%">300 เส้น+</td>
              <td width="8%">500 เส้น+</td>
              <td width="8%">1,000 เส้น+</td>
              <td width="8%">2,000 เส้น+</td>
              <td width="8%">3,000 เส้น+</td>
            </tr>
            <tr align="center" bgcolor="#ffffff">
              <td rowspan="1" colspan="2" bgcolor="#FFFF99">ขนาด<span class="red">10</span>mm ถักแบบ Flat</td>
              <td><span class="red f_tbl" >48 บาท</span><br>(960 บาท)</td>
              <td><span class="red f_tbl" >48 บาท</span><br>(1,440 บาท)</td>
              <td><span class="red f_tbl" >48 บาท</span><br>(2,400 บาท)</td>
              <td><span class="red f_tbl" >45 บาท</span><br>(4,500 บาท)</td>
              <td><span class="red f_tbl" >39 บาท</span><br>(7,800 บาท)</td>
              <td><span class="red f_tbl" >34 บาท</span><br>(10,200 บาท)</td>
              <td><span class="red f_tbl" >27 บาท</span><br>(13,500 บาท)</td>
              <td><span class="red f_tbl" >21 บาท</span><br>(21,000 บาท)</td>
              <td><span class="red f_tbl" >20 บาท</span><br>(40,000 บาท)</td>
              <td><span class="red f_tbl" >18 บาท</span><br>(54,000 บาท)</td>
            </tr>
            <tr align="center" bgcolor="#ffffff">
              <td rowspan="1" colspan="2" style="background-color:#FFFF99">ขนาด<span class="red">15</span>mm. ถักแบบ Flat</td>
              <td><span class="red f_tbl">74 บาท</span><br>(1,480 บาท)</td>
              <td><span class="red f_tbl">74 บาท</span><br>(2,220 บาท)</td>
              <td><span class="red f_tbl">74 บาท</span><br>(3,700 บาท)</td>
              <td><span class="red f_tbl">47 บาท</span><br>(4,700 บาท)</td>
              <td><span class="red f_tbl">41 บาท</span><br>(8,200 บาท)</td>
              <td><span class="red f_tbl">35 บาท</span><br>(10,500 บาท)</td>
              <td><span class="red f_tbl">29 บาท</span><br>(14,500 บาท)</td>
              <td><span class="red f_tbl">22 บาท</span><br>(22,000 บาท)</td>
              <td><span class="red f_tbl">20 บาท</span><br>(40,000 บาท)</td>
              <td><span class="red f_tbl">19 บาท</span><br>(57,000 บาท)</td>
            </tr>
			<tr align="center" bgcolor="#ffffff">
              <td rowspan="1" colspan="2" style="background-color:#FFFF99">ขนาด<span class="red">20</span>mm. ถักแบบ Flat</td>
              <td><span class="red f_tbl">89 บาท</span><br>(1,780 บาท)</td>
              <td><span class="red f_tbl">89 บาท</span><br>(2,670 บาท)</td>
              <td><span class="red f_tbl">89 บาท</span><br>(4,450 บาท)</td>
              <td><span class="red f_tbl">51 บาท</span><br>(5,100 บาท)</td>
              <td><span class="red f_tbl">47 บาท</span><br>(9,400 บาท)</td>
              <td><span class="red f_tbl">43 บาท</span><br>(12,900 บาท)</td>
              <td><span class="red f_tbl">35 บาท</span><br>(17,500 บาท)</td>
              <td><span class="red f_tbl">26 บาท</span><br>(26,000 บาท)</td>
              <td><span class="red f_tbl">23 บาท</span><br>(46,000 บาท)</td>
              <td><span class="red f_tbl">21 บาท</span><br>(63,000 บาท)</td>
            </tr>
        </tbody></table></div>
        <div class="txt-price">
        	1) แถวบนคือราคาผลิตสายคล้องบัตรต่อหน่วย แถวล่างคือราคาต่อหน่วย x จำนวนผลิต(ราคานี้ยังไม่รวมค่าบล็อคสกรีน)<br/>
			2) ราคาจำหน่ายนี้รวมค่าบรรจุใส่ถุง และค่าจัดส่งภายในประเทศต่อ 1 สถานที่<br/>
			3) หากสายคล้องบัตรที่ท่านสั่งผลิตมีจำนวนมาก ทางเราจะส่งสายคล้อง / บัตรตัวอย่างให้ตรวจสอบก่อนผลิตจริงฟรี<br/>
			4) ตัวอย่างสายคล้องบัตร (ดีไซน์ตัวอย่าง) ผลิตได้หนึ่งเส้นต่อหนึ่งรายการสั่งซื้อเท่านั้น<br/>
			5) อาจมีค่าใช้จ่ายเพิ่มเติมสำหรับพาร์ทออฟชั่นเสริม,เชือกขนาดพิเศษ หรือ แบบพิเศษ<br/>
			6) ราคาจำหน่ายสายคล้องบัตรที่แสดงยังไม่รวมภาษีมูลค่าเพิ่ม<br/>
			7) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ
		</div>
				<div style="clear: both;">&nbsp;</div>
				<h3 class="blue">ราคาค่าบล๊อคตามความยาวโลโก้</h3>
				<p>การสกรีนสายคล้องคอที่มีโลโก้ยาวๆ อาจจะทำให้ราคาบล๊อคแตกต่างกัน <a href="javascript:void(0)" onclick="togg('detail')" class="link2">คลิกที่นี่</a></p>
				<div id="div_detail" class="div_t">
				<img src="img/blog190.jpg" class="img_center" alt="ค่าบล็อคสายขนาดปกติ">
				<img src="img/blog190up.jpg" class="img_center" alt="ค่าบล็อคสายขนาดพิเศษ">
				<img src="img/blog400up.jpg" class="img_center" alt="ราคาสายขนาดพิเศษ">
				<img src="img/nylon-01.jpg?v=1.00">
				</div>
				<h3 class="blue" id="nylon">สายคล้องคอพนักงานแบบไนลอน</h3>
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
				<span>
			    	*กรณีที่สั่งผลิตสายคล้อง / บัตรไม่เกิน 3,000 เส้น(สำหรับการส่งมอบปกติ)<br/>
					*กรณีที่สั่งผลิตสายคล้อง / บัตรไม่เกิน 500 เส้น(สำหรับการส่งมอบแบบเร่งด่วน)<br/>
					*หากเลือกสีเส้นตั้งแต่สองสีขึ้นไปจะใช้เวลาเพิ่มขึ้น<br/>
					*วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์
				</span>
				<h3 class="blue">สายคล้องคอผ้าไนลอน</h3>
				<p>สายคล้องคอผ้าไนลอนซึ่งมีราคาถูก แต่มีคุณสมบัติเด่นคือไม่ยับง่าย และอยู่ทรงคงสภาพเดิมได้ดี มีสีที่สดกว่าผ้าโพลีเอสเตอร์ เนื้อผ้ามีความเหนียวและยืดหยุ่น สามารถผลิตได้ไม่มีขั้นต่ำ ไปจนถึงจำนวนมากกว่า 10,000 เส้นในระยะเวลาสั้นๆ สำหรับใช้ในงานเลี้ยงหรืองานกิจกรรมของบริษัท อีกทั้งเรายังมีซองแบบอ่อนสำหรับใส่บัตรพนักงาน บัตร ID และบัตรต่างๆ แถมฟรีอีกด้วยและท่านยังสามารถสั่งทำสายคล้องคอพนักงานแบบพิเศษได้อีกด้วย
				<table class="tbl_prd" cellpadding="5" cellspacing="0">
			      <tbody>
						<tr align="center">
			        <td bgcolor="#F3B183"></td>
			        <td bgcolor="#F3B183">พื้นผิว</td>
			        <td bgcolor="#F3B183">สกรีน</td>
			        <td bgcolor="#F3B183">ผิวสัมผัส</td>
			        <td bgcolor="#F3B183">น้ำหนัก</td>
			        <td bgcolor="#F3B183">ราคา</td>
			        <td bgcolor="#F3B183">ความนิยม</td>
			      </tr>
			      <tr align="center">
			        <td rowspan="2">โพลีเอสเตอร์</td>
			        <td>ไม่มีความวาว</td>
			        <td>ดีมาก</td>
			        <td>ไม่เรียบ</td>
			        <td>เบา</td>
			        <td>เกือบเท่ากัน</td>
			        <td>80%</td>
			      </tr>
						<tr align="center">
			        <td colspan="6">เป็นสายคล้องคอแบบใหม่ที่ส่วนใหญ่ผลิตจากโพลีเอสเตอร์</td>
			      </tr>
						<tr align="center">
			        <td rowspan="2">ไนลอน</td>
			        <td>มีความวาว</td>
			        <td>ดีมาก</td>
			        <td>เรียบเนียน</td>
			        <td>หนัก (30%UP)</td>
			        <td>เกือบเท่ากัน</td>
			        <td>20%</td>
			      </tr>
						<tr align="center">
			        <td colspan="6">ปัจจุบันสายคล้องคอไนลอนมีอัตราความนิยมเพิ่มขึ้น</td>
			      </tr>
						</tbody>
				</table>
				<h3 class="blue">การถักเชือกขนาดต่างๆ</h3>
				<p>ขนาด 10mm, 15mm, 20mm จะเป็นการถักแบบ Flat ทั้งหมด ท่านสามารถสั่งผลิตเชือกขนาด 25 mm, 30 mm และ 35 mm สามารถออกแบบได้ตามความต้องการ แต่อาจมีข้อจำกัดสำหรับเชือกขนาดดังกล่าว กรุณา<a href="/contact/" class="link2">ติดต่อสอบถาม</a>ข้อมูลเพิ่มเติมก่อนทำการสั่งผลิตสายคล้องบัตร หากต้องการเชือกที่มีขนาดสั้นกว่ามาตรฐาน(ขนาดพิเศษ) จะมีราคาจำหน่ายถูกลง</p>
				<h3 class="blue">วัสดุ</h3>
				<p>ไนลอนเป็นผ้าชนิดบางเงาและมีราคาจำหน่ายถูก</p>
				<h3 class="blue">การนำไปใช้</h3>
				<p>・สายคล้องคอที่ออกแบบเป็นพิเศษ สกรีนชื่อบริษัทหรือชื่อโปรเจกต์ต่างๆ ใช้ในสำนักงาน โรงพยาบาล สถานดูแลผู้สูงอายุ หรือนำโยโย่ติดเข้าไปเพื่อใช้คล้องบัตรเข้างาน บัตรพนักงาน ฯลฯ ได้อย่างง่ายดาย <br><br>
					・สายคล้องคอที่ออกแบบด้วยการสกรีนโลโก้หลากหลายสีสันสำหรับใช้ในร้านค้าเพื่อสร้างความสวยงาม นิยมขนาด 20 mm ขึ้นไป <br><br>
					・ใช้สกรีนชื่อโรงพยาบาลหรือคลินิกสำหรับแพทย์และพยาบาล เพื่อนำมาคล้องกับโทรศัพท์ได้ <br><br>
					・ใช้ในกิจกรรมใหญ่ๆ ในโรงเรียน เช่น งานกีฬา อีเวนต์ ประเพณีต่างๆ เป็นต้น ซึ่งสามารถกำหนดสีรูปแบบโลโก้ได้ สามารถสั่งทำในระยะเวลาสั้นๆได้อีกด้วย ซึงผลงานที่ผ่านเราได้ออกแบบผลิตสายคล้อง / บัตรแบบพิเศษกับลูกค้าPTA เป็นจำนวนมาก <br><br>
					・รองรับการผลิตจำนวนมากสำหรับการใช้ในกิจกรรมใหญ่ๆ เช่น งานประชุมทางวิชาการ อีเวนต์ ฯลฯ ซึ่งสามารถกำหนดออกแบบรายละเอียดของสี หรือ โลโก้แบบพิเศษ และสามารถสั่งผลิตในระยะเวลาอันรวดเร็วได้อีกด้วย <br><br>
					・ใช้ในโปรโมชั่นส่งเสริมการขายหรือใช้เป็นของสมนาคุณในโอกาศพิเศษได้อีกด้วย</p>
					<h2>ส่วนประกอบสายคล้องคอ</h2>
				<table class="tbl_vt">
					<tr>
						<td>
							<h3>ตะขอสปริง</h3>
							<img src="img/part_new/Lever_Nascan.jpg"><br/>
							<span>วัสดุ : โลหะ<br/>
							<font color="red">ราคาเริ่มต้น : 4 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
							ใช้ห้อยบัตรพนักงาน, บัตร ID หรือบัตรต่างๆ เป็นตะขอที่ได้รับความนิยมเพราะสามารถกดเปิด-ปิดได้สะดวกด้วยมือเดียว</span>
						</td>
						<td>
							<h3>ตะขอเกี่ยวทรงแบน</h3>
							<img src="img/part_new/nasican.jpg"><br/>
							<span>วัสดุ : โลหะ<br/>
							<font color="red">ราคาเริ่มต้น : 4 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
							หัวตะขอจะต่างจากตะขอแบบทั่วไป เหมาะสำหรับซองใส่บัตรพนักงานที่มีรูขนาดเล็ก</span>
						</td>
					</tr>
					<tr>
						<td>
							<h3>ตะขอสปริงดีดทรงรี</h3>
							<img src="img/part_new/Hook.jpg"><br/>
							<span>วัสดุ : โลหะ<br/>
							<font color="red">ราคาเริ่มต้น : 4 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
							บริเวณส่วนเปิด-ปิดต้องใช้มือดันเข้าไปเพื่อเปิดซึ่งจะไม่เหมือนกับตะขอสปริงที่จะมีส่วนที่ยื่นออกมาจากด้านข้างเพื่อให้กดเปิด</span>
						</td>
						<td>
							<h3>ตะขอสปริงดีด</h3>
							<img src="img/part_new/Aminascan.jpg"><br/>
							<span>วัสดุ : โลหะ<br/>
							<font color="red">ราคาเริ่มต้น : 4 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
							บริเวณส่วนเปิด-ปิด จะคล้ายกับตะขอสปริงดีดทรงรี</span>
						</td>
					</tr>
					<tr>
						<td>
							<h3>คลิปเหล็กแบบหนีบ</h3>
							<img src="img/part_new/clip_steel.jpg"><br/>
							<span>วัสดุ : โลหะ<br/>
							<font color="red">ราคาเริ่มต้น : 4 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm <br/>
							คลิปหนีบโลหะ มีความแข็งแรง สามารถนำไปหนีบกับซองใส่บัตรพนักงานแบบพลาสติกได้</span>
						</td>
						<td>
							<h3>คลิปเหล็กแบบหนีบ+พีวีซี</h3>
							<img src="img/part_new/clip_steel_pvc.jpg"><br/>
							<span>วัสดุ : โลหะ+พีวีซี (PVC)<br/>
							<font color="red">ราคาเริ่มต้น : 9 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : ทุกขนาด<br/>
							คลิปหนีบโลหะพร้อมตะขอพีวีซี เหมาะสำหรับนำไปคล้องกับซองใส่บัตรพนักงาน</span>
						</td>
					</tr>
					<tr>
						<td>
							<h3>คลิปหนีบ A</h3>
							<img src="img/part_new/Card_clipA.jpg"><br/>
							<span>วัสดุ : พลาสติก<br/>
							<font color="red">ราคาเริ่มต้น : 10 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm และขนาดอื่น ๆ<br/>
							ชิ้นส่วนนี้สามารถนำไปใช้สำหรับหนีบบัตรพนักงาน  หรือ ID Card ได้โดยตรง หรือนำไปหนีบไว้ที่กระเป๋าเสื้อได้ด้วย</span>
						</td>
						<td>
							<h3>ตะขอพีวีซี</h3>
							<img src="img/part_new/PVC.jpg"><br/>
							<span>วัสดุ : พีวีซี (PVC)<br/>
							<font color="red">ราคาเริ่มต้น : 9 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
							ชิ้นส่วนนี้สามารถใช้ห้อยบัตรพนักงาน บัตรID Card หรือบัตรต่างๆ</span>
						</td>
					</tr>
					<tr>
						<td>
							<h3>คลิปยูโร A</h3>
							<img src="img/part_new/Removable-A.jpg"><br/>
							<span>วัสดุ : ABS+สปริงโลหะ+ตะขอโลหะ<br/>
							<font color="red">ราคาเริ่มต้น : 31 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(มีเฉพาะสีดำ),
							20 mm(มีเฉพาะสีขาว)<br/>
							ตัวคลิปผลิตในประเทศญี่ปุ่น คุณภาพดีมาก ในส่วนของคลิปสามารถถอดแยกเพื่อนำไปหนีบกับกระเป๋าเสื้อ,กางเกงได้</span>
						</td>
						<td>
							<h3>คลิปยูโร B</h3>
							<img src="img/part_new/Removable-B.jpg"><br/>
							<span>วัสดุ : พลาสติก+ตะขอโลหะ+ตะขอเรซิ่น<br/>
							<font color="red">ราคาเริ่มต้น : 13 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
							ตัวคลิปสามารถแยกออกจากห่วงโลหะได้เพื่อนำไปติดเข้ากับสายคล้องคอเพื่อใช้ห้อยบัตรต่างๆ จะนำมาใช้ห้อยบัตร ID หรือบัตรพนักงานไว้ที่กระเป๋าเสื้อหรือบริเวณอื่นก็ได้</span>
						</td>
					</tr>
					<tr>
						<td>
							<h3>คลิปยูโร C</h3>
							<img src="img/part_new/euro_c.jpg"><br/>
							<span>วัสดุ : พลาสติก+แกนโลหะ <br/>
							<font color="red">ราคาเริ่มต้น : 15 บาท</font><br/>
							ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(มีเฉพาะสีขาว)<br/>
							คลิปพลาสติกเนื้อดี แกนโลหะ มีความแข็งแรงและทนทาน ส่วนปลายคลิปวัสดุเป็นยางอ่อน มีความยืดหยุ่นสูงทำให้ใช้งานได้ยาวนาน</span>
						</td>
						<td>
						</td>
					</tr>
				</table>
			<h3 class="blue">ส่วนประกอบพิเศษสำหรับสายคล้องคอแบบโพลีเอสเตอร์</h3>
			<table class="tbl_vt">
			<tr>
				<td>
					<h3>Safety part</h3>
					<img src="img/part_new/Safety-part.jpg"><br/>
					<span>วัสดุ: พลาสติก มีสีดำ, สีขาว (ขนาด 20 mm จะมีแค่สีดำ)<br/>
						ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
						ชิ้นส่วนที่แข็งแรงนี้จะช่วยป้องกันให้สายคล้องคอหลุดออกจากคอยากขึ้น
						<a href="img/ins_sf.jpg" data-lightbox="img1" data-title="" class="link2" style="text-decoration:none;">จุดที่สามารถติดตั้ง Safety part ได้</a>หรือคลิก<a href="img/MVI_0719.mp4" target="_blank" class="link2">ที่นี่</a>เพื่อดูวิดิโอสาธิตการใช้งาน</span>
				</td>
				<td>
					<h3>สายห้อยโทรศัพท์มือถือ</h3>
					<img src="img/part_new/mobile.jpg"><br/>
					<span>วัสดุ : พลาสติก (ยกเว้นส่วนที่เป็นห่วงและสายห้อยโทรศัพท์)<br/>
						ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm และขนาดอื่นๆ<br/>
						ชิ้นส่วนสำหรับห้อยโทรศัพท์มือถือ หรืออุปกรณ์ต่างๆ สามารถแยกออกจากกันได้ มีให้เลือก2สี คือ สีขาว และสีดำ</span>
					</td>
			</tr>
			<tr>
				<td>
					<h3>ตัวล็อกก้ามปู</h3>
					<img src="img/part_new/Buckle.jpg"><br/>
					<span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br/>
					ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
					และขนาดอื่น ๆ (สามารถใช้กับเชือกขนาด 30 mmได้ รูปทรงอาจแตกต่างกันเล็กน้อย) ชิ้นส่วนนี้นำไปติดเข้ากับสายคล้องคอ และสามารถถอดออกได้โดยกดตรงด้านข้างของตัวล็อคก้ามปูแล้วดึงออก</span>
				</td>
				<td>
					<h3>ตัวเลื่อนปรับความยาวแบบ A</h3>
					<img src="img/part_new/parts_A.jpg"><br/>
					<span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br/>
					ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
					ชิ้นส่วนนี้จะใช้สำหรับปรับระดับความสั้น ความยาวของสายคล้องคอได้</span>
				</td>
			</tr>
			<tr>
				<td>
				<h3>ตัวเลื่อนปรับความยาวแบบ B</h3>
				<img src="img/part_new/parts_B.jpg"><br/>
				<span>วัสดุ : พลาสติก (มีเฉพาะสีดำเท่านั้น )<br/>
				ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(Flat)<br/>
				ชิ้นส่วนนี้จะอยู่บริเวณคอเมื่อกดปุ่มสีดำแล้วเลื่อนจะสามารถปรับความยาวของสายคล้องคอให้สั้นหรือยาวได้</span>
				</td>
				<td>
				<h3>ตัวเลื่อนปรับความยาวแบบ C</h3>
				<img src="img/part_new/parts_C.jpg"><br/>
				<span>วัสดุ : พลาสติก ( มีเฉพาะสีดำเท่านั้น )<br/>
				ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm(Tubeler), 15 mm(Flat)<br/>
				ชิ้นส่วนนี้จะอยู่บริเวณคอ สามารถใช้เลื่อนเพื่อปรับระดับความยาวของสายคล้องคอได้ตามต้องการ</span>
				</td>
			</tr>
			<tr>
				<td>
				<h3>ตัวล็อกแบบหนีบ</h3>
				<img src="img/part_new/caulking.jpg"><br/>
				<span>วัสดุ : โลหะ<br/>
				ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm<br/>
				ชิ้นส่วนนี้เป็นโลหะรูปทรงสี่เหลี่ยมผืนผ้าที่นำไปติดเข้ากับสาย
				คล้องคอ เพื่อพับส่วนปลายเก็บที่ด้านหลังแทนการเย็บ</span>
				</td>
				<td></td>
			</tr>
		</table>
			<div class="btn-ctu">
				<a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a>
				<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
				<a href="/template/" class="btn-s1">Design template</a>
			</div>
			<h2>จุดเด่นของการผลิตสายคล้องของบริษัทเรา</h2>
			<h3 class="blue">จุดเด่นที่ 1</h3>
			<div class="row" id="box-show">
				<label><img src="img/s_red1.jpg"><br/><span>สกรีนโลโก้คมชัดสามารถพิมพ์เครื่องหมายเล็กๆ เช่น ® หรือ TM ได้</span></label>
				<label><img src="img/s_red2.jpg"><br/>สกรีนโดยการยิง</label>
				<label><img src="img/s_red3.jpg"><br/>สกรีนแบบเรียบ</label>
			</div>
			<p><span class="red">ลายสกรีนโลโก้บริษัทหรือชื่อต่างๆ คมชัด!
			ความหนากำลังดี สัมผัสลื่นไม่หยาบ</span><br/>
			การสกรีนชื่อบริษัทหรืองานกิจกรรมต่างๆ ของเราเป็นการสกรีนด้วยสีทับซ้ำหลายครั้ง ทำให้ลายสกรีนคมชัด สวยงาม สามารถสกรีนได้สูงสุดถึง 6 สีตามตำแหน่งที่ต้องการ ท่านสามารถดูผลงานที่ผ่านมาบางส่วนของเราได้ นอกจากนี้ วิธีการสกรีนทั้งหมดของเราเป็นแบบ Home position จึงสามารถกำหนดตำแหน่งโลโก้ ชื่อบริษัท และจัดวางตามความต้องการได้ ทั้งนี้ โลโก้ที่สกรีนต่อเนื่องจะไม่สามารถกำหนดจุดสิ้นสุดได้ แต่ไม่ต้องกังวลว่าลายสกรีนจะทับกาวที่เป็นตัวยึด
			</p>
			<h3 class="blue">จุดเด่นที่ 2</h3>
			<p><span class="red">การสกรีนโลโก้บริษัทหรือโลโก้โรงพยาบาลแบบซับลิเมชั่นลงบนคลิปและตัวยึด</span><br/>
			เราขอแนะนำคลิปและตัวยึดที่เป็นผลิตภัณฑ์เฉพาะของบริษัทเราซึ่งสามารถยึดติดกับเชือกได้อย่างแน่นหนา ทั้งยังสามารถนำไปคล้องกับซองใส่บัตร ID นามบัตร บัตรพนักงาน ฯลฯ ได้ด้วย นอกจากนี้ เรายังมีบริการพิเศษที่สามารถสกรีนโลโก้บริษัทหรือโลโก้โรงพยาบาลแบบซับลิเมชั่นลงบนคลิปและตัดยึด จากนั้นจะเคลือบด้วยอีพ็อกซี่ เรซิ่น ทำให้สีไม่ถลอกหรือหลุดลอกออกง่าย มีชิ้นส่วนสีขาวและสีดำให้เลือกได้ตามต้องการ
			</p>
			<h3 class="blue">จุดเด่นที่ 3</h3>
			<div class="row" id="box-show2">
				<label><img src="img/print_sample745_1.jpg"><br/>ภาพอ้างอิงการสกรีน 2 สี</label>
				<label><img src="img/print_sample745_2.jpg"><br/>ภาพอ้างอิงการสกรีน 5 สี</label>
			</div>
			<p><span class="red">สุดพิเศษ! สามารถสกรีนสีเชือกแบบพิเศษได้มากสุดถึง 6 สี　สกรีนได้ทั้งด้านหน้าและด้านหลัง หรือจะใส่สายคล้องคอแบบ 2 หัวก็ได้</span><br/>
			・สกรีนสีโลโก้ด้วยสีย้อมพิเศษ (ตั้งแต่ 100 เส้นขึ้นไปต่อสี)<br/>
			・สกรีนโลโก้บริษัททั้งชื่อและตราสัญลักษณ์ได้สูงสุดถึง 6 สี และยังสามารถกำหนดพื้นที่ที่ไม่ต้องการใส่สีได้ด้วย<br/>
			・สามารถสกรีนโลโก้ได้ทั้ง 2 ด้าน ทั้งด้านหน้าและด้านหลังของสายคล้องคอ<br/>
			・สามารถกำหนดขอเกี่ยวสำหรับสายคล้องบัตรต่างๆ ได้ ซึ่งเราผลิตสายคล้องคอแบบ 2 หัวด้วย<br/>
			・ความยาวของเชือกแบบมาตรฐาน หากพับครึ่งหรือคล้องคอจะมีความยาว 45 cm และ 60 cm　หากต้องการสายคล้องคอแบบยาว ทางเราก็มีบริการด้วยเช่นกัน
			</p>
			<h3 class="blue">สายคล้องคอพนักงานสกรีนสองด้าน</h3>
			<p>
				สายคล้องคอพนักงานผ้าโพลีเอสเตอร์และผ้าไนลอน สามารถสกรีนได้ทั้งสองด้านตามความต้องการของลูกค้า เพียงส่งแบบที่ต้องการมาให้เราหรือสามารถให้เราออกแบบให้ได้โดยไม่มีค่าใช้จ่าย
				ภาพด้านล่างจะเป็นตัวอย่างสายคล้องคอพนักงานแบบสกรีนสองด้านที่เราเคยทำมา หากสนใจสั่งซื้อสายคล้องคอ<a href="/contact/" class="link2">โปรดติดต่อหาเรา</a>
			</p>
			<div id="box-show">
				<img src="img/twoprint2.jpg">
			</div>
			<h3 class="blue">ตารางแสดงสีเชือก</h3>
			<p>เรามีสีพื้นฐานให้เลือกทั้งหมด 20 สี ส่วนใหญ่นิยมสั่งซื้อโทนสีแดงและสีฟ้า ซึ่งทั้ง 2 สีมีโทนสีที่คล้ายกันคือ สีแดง (PANTONE485C) กับ Flag red และสีน้ำเงิน (PANTONE293C) กับ Reflex Blue  และ Process Blue นอกจากนี้ยังมีสีส้มและสีดำที่เป็นที่นิยมเช่นกัน อีกทั้งยังมีสีใหม่เพิ่มเข้ามาอย่างสีชมพูและสีชมพูโบตั๋นด้วย (ข้อมูลเดือนพฤษภาคม ค.ศ. 2014)</p>
			<div class="box">
				<img src="img/Nylon-color-banner.jpg?v=1.01"><br/>
			</div>
			<p>
				・สามารถสั่งสีของสายคล้องคอได้ตั้งแต่ 2 สีขึ้นไปโดยต้องสั่งผลิตจำนวนขั้นต่ำ 100 เส้นขึ้นไปต่อสี(ไม่เกิน 5 สี)<br/>
				・หากต้องการสั่งผลิตเพิ่มอีก 1 สี จะมีค่าใช้จ่ายเพิ่มเติม 800 บาท (ไม่รวมภาษี)
			</p>
			<div class="btn-ctu">
				<a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a>
				<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
				<a href="/template/" class="btn-s1">Design template</a>
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
