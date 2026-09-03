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
	<style type="text/css">
		.fs_tbl {
		    font-size: 12px!important;
		}
	</style>
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
	<div class="product" id="container">
		<div class="container">
			<div class="pd-main">
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
							<td class="td2">2607C<a class="link2" href="product_color.php">ดูเพิ่มเติม</a></td>
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
						<img class="w-100" src="img/mini-1pc.jpg"><br/>
					</td>
					<td>
						<img class="w-100" src="img/mini-3d.jpg"><br/>
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
              <td width="20%" colspan="2" bgcolor="#ffffff">สกรีน <span class="red">1</span> สี</td>
              <td width="8%">20 เส้น</td>
              <td width="8%">30 เส้น</td>
              <td width="8%">50 เส้น</td>
              <td width="8%">100 เส้น</td>
              <td width="8%">200 เส้น</td>
              <td width="8%">300 เส้น</td>
              <td width="8%">500 เส้น</td>
              <td width="8%">1,000 เส้น</td>
              <td width="8%">2,000 เส้น</td>
              <td width="8%">3,000 เส้น</td>
            </tr>
            <tr align="center" bgcolor="#ffffff">
                <td rowspan="1" colspan="2" bgcolor="#FFFF99">ขนาด<span class="red">10</span>mm.</td>
                <td><span class="red f_tbl" >2,960 บาท</span><br>148.00บาท/เส้น</td>
                <td><span class="red f_tbl" >3,440 บาท</span><br>114.67บาท/เส้น</td>
                <td><span class="red f_tbl" >4,400 บาท</span><br>88.00บาท/เส้น</td>
                <td><span class="red f_tbl" >6,500 บาท</span><br>65.00บาท/เส้น</td>
                <td><span class="red f_tbl" >9,800 บาท</span><br>49.00บาท/เส้น</td>
                <td><span class="red f_tbl" >12,200 บาท</span><br>40.67บาท/เส้น</td>
                <td><span class="red f_tbl" >15,500 บาท</span><br>31.00บาท/เส้น</td>
                <td><span class="red f_tbl" >23,000 บาท</span><br>23.00บาท/เส้น</td>
                <td><span class="red f_tbl" >42,000 บาท</span><br>21.00บาท/เส้น</td>
                <td><span class="red f_tbl" >56,000 บาท</span><br>18.67บาท/เส้น</td>
            </tr>
            <tr align="center" bgcolor="#ffffff">
                <td rowspan="1" colspan="2" style="background-color:#FFFF99">ขนาด<span class="red">15</span>mm.</td>
                <td><span class="red f_tbl" >3,480 บาท</span><br>174.00บาท/เส้น</td>
                <td><span class="red f_tbl" >4,220 บาท</span><br>140.67บาท/เส้น</td>
                <td><span class="red f_tbl" >5,700 บาท</span><br>114.00บาท/เส้น</td>
                <td><span class="red f_tbl" >6,700 บาท</span><br>67.00บาท/เส้น</td>
                <td><span class="red f_tbl" >10,200 บาท</span><br>51.00บาท/เส้น</td>
                <td><span class="red f_tbl" >12,500 บาท</span><br>41.67บาท/เส้น</td>
                <td><span class="red f_tbl" >16,500 บาท</span><br>33.00บาท/เส้น</td>
                <td><span class="red f_tbl" >24,000 บาท</span><br>24.00บาท/เส้น</td>
                <td><span class="red f_tbl" >42,000 บาท</span><br>21.00บาท/เส้น</td>
                <td><span class="red f_tbl" >59,000 บาท</span><br>19.67บาท/เส้น</td>
            </tr>
			<tr align="center" bgcolor="#ffffff">
                <td rowspan="1" colspan="2" style="background-color:#FFFF99">ขนาด<span class="red">20</span>mm.</td>
                <td><span class="red f_tbl" >3,780 บาท</span><br>189.00บาท/เส้น</td>
                <td><span class="red f_tbl" >4,670 บาท</span><br>155.67บาท/เส้น</td>
                <td><span class="red f_tbl" >6,450 บาท</span><br>129.00บาท/เส้น</td>
                <td><span class="red f_tbl" >7,100 บาท</span><br>71.00บาท/เส้น</td>
                <td><span class="red f_tbl" >11,400 บาท</span><br>57.00บาท/เส้น</td>
                <td><span class="red f_tbl" >14,900 บาท</span><br>49.67บาท/เส้น</td>
                <td><span class="red f_tbl" >19,500 บาท</span><br>39.00บาท/เส้น</td>
                <td><span class="red f_tbl" >28,000 บาท</span><br>28.00บาท/เส้น</td>
                <td><span class="red f_tbl" >48,000 บาท</span><br>24.00บาท/เส้น</td>
                <td><span class="red f_tbl" >65,000 บาท</span><br>21.67บาท/เส้น</td>
            </tr>
        </tbody></table></div>
	        <div class="txt-price">
	            1) ราคานี้เป็นราคาของสายคล้องคอสกรีน 1 สีเท่านั้นหากต้องการสกรีนมากกว่า 1 สีกรุณา<a href="/contact/" class="link2">ติดต่อพนักงานขาย</a><br/>
				2) ราคาจำหน่ายนี้รวมค่าบรรจุใส่ถุง และค่าจัดส่งภายในประเทศต่อ 1 สถานที่<br/>
				3) หากสายคล้องบัตรที่ท่านสั่งผลิตมีจำนวนมาก ทางเราจะส่งสายคล้อง / บัตรตัวอย่างให้ตรวจสอบก่อนผลิตจริงฟรี<br/>
				4) ตัวอย่างสายคล้องบัตร (ดีไซน์ตัวอย่าง) ผลิตได้หนึ่งเส้นต่อหนึ่งรายการสั่งซื้อเท่านั้น<br/>
				5) อาจมีค่าใช้จ่ายเพิ่มเติมสำหรับพาร์ทออฟชั่นเสริม,เชือกขนาดพิเศษ หรือ แบบพิเศษ<br/>
				6) ราคาจำหน่ายสายคล้องบัตรที่แสดงยังไม่รวมภาษีมูลค่าเพิ่ม<br/>
				7) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ
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
				<p>
			    	*กรณีที่สั่งผลิตสายคล้อง / บัตรไม่เกิน 3,000 เส้น(สำหรับการส่งมอบปกติ)<br/>
					*กรณีที่สั่งผลิตสายคล้อง / บัตรไม่เกิน 500 เส้น(สำหรับการส่งมอบแบบเร่งด่วน)<br/>
					*หากเลือกสีเส้นตั้งแต่สองสีขึ้นไปจะใช้เวลาเพิ่มขึ้น<br/>
					*วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์
				</p>
				<h3 class="blue">สายคล้องคอผ้าไนลอน</h3>
				<p>สายคล้องคอผ้าไนลอนซึ่งมีราคาถูก แต่มีคุณสมบัติเด่นคือไม่ยับง่าย และอยู่ทรงคงสภาพเดิมได้ดี มีสีที่สดกว่าผ้าโพลีเอสเตอร์ เนื้อผ้ามีความเหนียวและยืดหยุ่น สามารถผลิตได้ไม่มีขั้นต่ำ ไปจนถึงจำนวนมากกว่า 10,000 เส้นในระยะเวลาสั้นๆ สำหรับใช้ในงานเลี้ยงหรืองานกิจกรรมของบริษัท อีกทั้งเรายังมีซองแบบอ่อนสำหรับใส่บัตรพนักงาน บัตร ID และบัตรต่างๆ แถมฟรีอีกด้วยและท่านยังสามารถสั่งทำสายคล้องคอพนักงานแบบพิเศษได้อีกด้วย</p>
					<div class="exceed-table">
				
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
			        <td class="fs_tbl">ไม่มีความวาว</td>
			        <td class="fs_tbl">ดีมาก</td>
			        <td class="fs_tbl">ไม่เรียบ</td>
			        <td class="fs_tbl">เบา</td>
			        <td class="fs_tbl">เกือบเท่ากัน</td>
			        <td class="fs_tbl">80%</td>
			      </tr>
						<tr align="center">
			        <td colspan="6">เป็นสายคล้องคอแบบใหม่ที่ส่วนใหญ่ผลิตจากโพลีเอสเตอร์</td>
			      </tr>
						<tr align="center">
			        <td rowspan="2">ไนลอน</td>
			        <td class="fs_tbl">มีความวาว</td>
			        <td class="fs_tbl">ดีมาก</td>
			        <td class="fs_tbl">เรียบเนียน</td>
			        <td class="fs_tbl">หนัก (30%UP)</td>
			        <td class="fs_tbl">เกือบเท่ากัน</td>
			        <td class="fs_tbl">20%</td>
			      </tr>
						<tr align="center">
			        <td colspan="6">ปัจจุบันสายคล้องคอไนลอนมีอัตราความนิยมเพิ่มขึ้น</td>
			      </tr>
				</tbody>
				</table>
				</div>
				<h3 class="blue">การถักเชือกขนาดต่างๆ</h3>
				<p>ขนาด 10mm, 15mm, 20mm จะเป็นการถักแบบ Flat ทั้งหมด ท่านสามารถสั่งผลิตเชือกขนาด 25 mm, 30 mm และ 35 mm สามารถออกแบบได้ตามความต้องการ แต่อาจมีข้อจำกัดสำหรับเชือกขนาดดังกล่าว กรุณา<a href="/contact/" class="link2">ติดต่อสอบถาม</a>ข้อมูลเพิ่มเติมก่อนทำการสั่งผลิตสายคล้องบัตร หากต้องการเชือกที่มีขนาดสั้นกว่ามาตรฐาน(ขนาดพิเศษ) จะมีราคาจำหน่ายถูกลง</p>
				<h3 class="blue">วัสดุ</h3>
				<p>ไนลอนเป็นผ้าชนิดบางเงาและมีราคาจำหน่ายถูก</p>
				<h3 class="blue">การนำไปใช้</h3>
				<p><span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สายคล้องคอที่ออกแบบเป็นพิเศษ สกรีนชื่อบริษัทหรือชื่อโปรเจกต์ต่างๆ ใช้ในสำนักงาน โรงพยาบาล สถานดูแลผู้สูงอายุ หรือนำโยโย่ติดเข้าไปเพื่อใช้คล้องบัตรเข้างาน บัตรพนักงาน ฯลฯ ได้อย่างง่ายดาย <br>
				<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สายคล้องคอที่ออกแบบด้วยการสกรีนโลโก้หลากหลายสีสันสำหรับใช้ในร้านค้าเพื่อสร้างความสวยงาม นิยมขนาด 20 mm ขึ้นไป <br>
				<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> ใช้สกรีนชื่อโรงพยาบาลหรือคลินิกสำหรับแพทย์และพยาบาล เพื่อนำมาคล้องกับโทรศัพท์ได้ <br>
				<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> ใช้ในกิจกรรมใหญ่ๆ ในโรงเรียน เช่น งานกีฬา อีเวนต์ ประเพณีต่างๆ เป็นต้น ซึ่งสามารถกำหนดสีรูปแบบโลโก้ได้ สามารถสั่งทำในระยะเวลาสั้นๆได้อีกด้วย ซึงผลงานที่ผ่านเราได้ออกแบบผลิตสายคล้อง / บัตรแบบพิเศษกับลูกค้าPTA เป็นจำนวนมาก <br>
				<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> รองรับการผลิตจำนวนมากสำหรับการใช้ในกิจกรรมใหญ่ๆ เช่น งานประชุมทางวิชาการ อีเวนต์ ฯลฯ ซึ่งสามารถกำหนดออกแบบรายละเอียดของสี หรือ โลโก้แบบพิเศษ และสามารถสั่งผลิตในระยะเวลาอันรวดเร็วได้อีกด้วย <br>
				<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> ใช้ในโปรโมชั่นส่งเสริมการขายหรือใช้เป็นของสมนาคุณในโอกาศพิเศษได้อีกด้วย</p>
				

				<h2>ส่วนประกอบสายคล้องคอ</h2>

				<div class="row-bs">
                        <div class="col-sm-6 col-12">
                            <div style="padding: 0 10px;">
                                <h3>ตะขอสปริง</h3>
                                <img class="w-100" src="img/part_new/Lever_Nascan.jpg"><br />
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
                                <img class="w-100" src="img/part_new/nasican.jpg"><br />
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
                                <img class="w-100" src="img/part_new/Hook.jpg"><br />
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
                                <img class="w-100" src="img/part_new/Aminascan.jpg"><br />
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
                                <img class="w-100" src="img/part_new/clip_steel.jpg"><br />
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
                                <img class="w-100" src="img/part_new/clip_steel_pvc.jpg"><br />
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
                                <img class="w-100" src="img/part_new/Card_clipA.jpg"><br />
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
                                <img class="w-100" src="img/part_new/PVC.jpg"><br />
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
                                <img class="w-100" src="img/part_new/Removable-A.jpg"><br />
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
                                <img class="w-100" src="img/part_new/Removable-B.jpg"><br />
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
                                <img class="w-100" src="img/part_new/euro_c.jpg"><br />
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
                                <img class="w-100" src="img/part_new/Safety-part.jpg"><br />
                                <span>วัสดุ: พลาสติก มีสีดำ, สีขาว (ขนาด 20 mm จะมีแค่สีดำ)<br />
                                    ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
                                    ชิ้นส่วนที่แข็งแรงนี้จะช่วยป้องกันให้สายคล้องคอหลุดออกจากคอยากขึ้น
                                    <a href="img/ins_sf.jpg" data-lightbox="img1" data-title="" class="link2" style="text-decoration:none;">จุดที่สามารถติดตั้ง Safety part ได้</a>หรือคลิก<a href="img/MVI_0719.mp4" target="_blank" class="link2">ที่นี่</a>เพื่อดูวิดิโอสาธิตการใช้งาน</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div style="padding: 0 10px;">
                                <h3>สายห้อยโทรศัพท์มือถือ</h3>
                                <img class="w-100" src="img/part_new/mobile.jpg"><br />
                                <span>วัสดุ : พลาสติก (ยกเว้นส่วนที่เป็นห่วงและสายห้อยโทรศัพท์)<br />
                                    ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm และขนาดอื่นๆ<br />
                                    ชิ้นส่วนสำหรับห้อยโทรศัพท์มือถือ หรืออุปกรณ์ต่างๆ สามารถแยกออกจากกันได้ มีให้เลือก2สี คือ สีขาว และสีดำ</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div style="padding: 0 10px;">
                                <h3>ตัวล็อกก้ามปู</h3>
                                <img class="w-100" src="img/part_new/Buckle.jpg"><br />
                                <span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br />
                                    ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
                                    และขนาดอื่น ๆ (สามารถใช้กับเชือกขนาด 30 mmได้ รูปทรงอาจแตกต่างกันเล็กน้อย) ชิ้นส่วนนี้นำไปติดเข้ากับสายคล้องคอ และสามารถถอดออกได้โดยกดตรงด้านข้างของตัวล็อคก้ามปูแล้วดึงออก</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div style="padding: 0 10px;">
                                <h3>ตัวเลื่อนปรับความยาวแบบ A</h3>
                                <img class="w-100" src="img/part_new/parts_A.jpg"><br />
                                <span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br />
                                    ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br />
                                    ชิ้นส่วนนี้จะใช้สำหรับปรับระดับความสั้น ความยาวของสายคล้องคอได้</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div style="padding: 0 10px;">
                                <h3>ตัวเลื่อนปรับความยาวแบบ B</h3>
                                <img class="w-100" src="img/part_new/parts_B.jpg"><br />
                                <span>วัสดุ : พลาสติก (มีเฉพาะสีดำเท่านั้น )<br />
                                    ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(Flat)<br />
                                    ชิ้นส่วนนี้จะอยู่บริเวณคอเมื่อกดปุ่มสีดำแล้วเลื่อนจะสามารถปรับความยาวของสายคล้องคอให้สั้นหรือยาวได้</span>
                                 </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div style="padding: 0 10px;">
                                <h3>ตัวเลื่อนปรับความยาวแบบ C</h3>
                                    <img class="w-100" src="img/part_new/parts_C.jpg"><br />
                                    <span>วัสดุ : พลาสติก ( มีเฉพาะสีดำเท่านั้น )<br />
                                        ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm(Tubeler), 15 mm(Flat)<br />
                                        ชิ้นส่วนนี้จะอยู่บริเวณคอ สามารถใช้เลื่อนเพื่อปรับระดับความยาวของสายคล้องคอได้ตามต้องการ</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div style="padding: 0 10px;">
                                <h3>ตัวล็อกแบบหนีบ</h3>
                                <img class="w-100" src="img/part_new/caulking.jpg"><br />
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
			<h2>จุดเด่นของการผลิตสายคล้องของบริษัทเรา</h2>
			<h3 class="blue">จุดเด่นที่ 1</h3>
			<div class="row-bs" id="box-show">				
                        <div class="col-sm-4 col-12">
                        	<div style="padding: 0 5px;">
                            <img src="img/s_red1.jpg"><br />สกรีนโลโก้คมชัดสามารถพิมพ์เครื่องหมายเล็กๆ เช่น ® หรือ TM ได้</div></div>
                        <div class="col-sm-4 col-12">

                        	<div style="padding: 0 5px;">
                            <img src="img/s_red2.jpg"><br />สกรีนโดยการยิง</div></div>
                        <div class="col-sm-4 col-12">

                        	<div style="padding: 0 5px;">
                            <img src="img/s_red3.jpg"><br />สกรีนแบบเรียบ</div></div>
                    </div>
			<p><span class="red">ลายสกรีนโลโก้บริษัทหรือชื่อต่างๆ คมชัด! ความหนากำลังดี สัมผัสลื่นไม่หยาบ</span><br/>
			การสกรีนชื่อบริษัทหรืองานกิจกรรมต่างๆ ของเราเป็นการสกรีนด้วยสีทับซ้ำหลายครั้ง ทำให้ลายสกรีนคมชัด สวยงาม สามารถสกรีนได้สูงสุดถึง 6 สีตามตำแหน่งที่ต้องการ ท่านสามารถดูผลงานที่ผ่านมาบางส่วนของเราได้ นอกจากนี้ วิธีการสกรีนทั้งหมดของเราเป็นแบบ Home position จึงสามารถกำหนดตำแหน่งโลโก้ ชื่อบริษัท และจัดวางตามความต้องการได้ ทั้งนี้ โลโก้ที่สกรีนต่อเนื่องจะไม่สามารถกำหนดจุดสิ้นสุดได้ แต่ไม่ต้องกังวลว่าลายสกรีนจะทับกาวที่เป็นตัวยึด
			</p>
			<h3 class="blue">จุดเด่นที่ 2</h3>
			<p><span class="red">การสกรีนโลโก้บริษัทหรือโลโก้โรงพยาบาลแบบซับลิเมชั่นลงบนคลิปและตัวยึด</span><br/>
			เราขอแนะนำคลิปและตัวยึดที่เป็นผลิตภัณฑ์เฉพาะของบริษัทเราซึ่งสามารถยึดติดกับเชือกได้อย่างแน่นหนา ทั้งยังสามารถนำไปคล้องกับซองใส่บัตร ID นามบัตร บัตรพนักงาน ฯลฯ ได้ด้วย นอกจากนี้ เรายังมีบริการพิเศษที่สามารถสกรีนโลโก้บริษัทหรือโลโก้โรงพยาบาลแบบซับลิเมชั่นลงบนคลิปและตัดยึด จากนั้นจะเคลือบด้วยอีพ็อกซี่ เรซิ่น ทำให้สีไม่ถลอกหรือหลุดลอกออกง่าย มีชิ้นส่วนสีขาวและสีดำให้เลือกได้ตามต้องการ
			</p>
			<h3 class="blue">จุดเด่นที่ 3</h3>
					<div class="row-bs" id="box-show2">
                        <div class="col-sm-6 col-12" style="padding-bottom: 10px;">
                        	<div style="padding: 0 5px;">
                            <img src="img/print_sample745_1.jpg" style="padding-bottom: 10px;"><br />ภาพอ้างอิงการสกรีน 2 สี</div>
                        </div>
                        <div class="col-sm-6 col-12" style="padding-bottom: 10px;">
                        	<div style="padding: 0 5px;">
                            <img src="img/print_sample745_2.jpg" style="padding-bottom: 10px;"><br />ภาพอ้างอิงการสกรีน 5 สี</div></div>
                   </div>
                    <p style="margin-top: 0px;"><span class="red">สุดพิเศษ! สามารถสกรีนสีเชือกแบบพิเศษได้มากสุดถึง 6 สี สกรีนได้ทั้งด้านหน้าและด้านหลัง หรือจะใส่สายคล้องคอแบบ 2 หัวก็ได้</span><br />
                    	<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สกรีนสีโลโก้ด้วยสีย้อมพิเศษ (ตั้งแต่ 100 เส้นขึ้นไปต่อสี) ในราคาถูก<br />
                    	<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สกรีนโลโก้บริษัท สกรีนชื่อ และตราสัญลักษณ์ได้สูงสุดถึง 6 สี และยังสามารถออกแบบดีไซน์กำหนดพื้นที่ที่ไม่ต้องการใส่สีได้ด้วย<br />
                    	<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สามารถสกรีนโลโก้ได้ทั้ง 2 ด้าน ทั้งด้านหน้าและด้านหลังของสายคล้องคอ<br />
                    	<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สามารถกำหนดขอเกี่ยวสำหรับสายคล้องบัตรต่างๆ ได้ ซึ่งเราผลิตสายคล้องคอแบบ 2 หัวด้วย<br />
                    	<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> ความยาวของเชือกแบบมาตรฐาน หากพับครึ่งหรือคล้องคอจะมีความยาว 45 cm และ 60 cm หากต้องการสายคล้องคอขนาดพิเศษราคาถูก ทางเราก็มีบริการด้วยเช่นกัน
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
                    	<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สามารถสั่งสีของสายคล้องคอได้ตั้งแต่ 2 สีขึ้นไปโดยต้องสั่งผลิตจำนวนขั้นต่ำ 100 เส้นขึ้นไปต่อสี(ไม่เกิน 5 สี)<br />
                    	<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> หากต้องการสั่งผลิตเพิ่มอีก 1 สี จะมีค่าใช้จ่ายเพิ่มเติม 800 บาท (ไม่รวมภาษี)</p>
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