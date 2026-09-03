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
	<link rel="canonical" href="/products/carabiner.php" />
	<meta name="description" content="คาราบิเนอร์ คือตะขอเกี่ยวอเนกประสงค์ สามารถนำมาใช้งานได้หลากหลาย ทั้งนำไปเกี่ยวกับสายคล้องบัตรหรือแจกเป็นของสัมนาคุณในงานอีเว้นท์ต่าง เรารับออกแบบและสกรีนลายลงบนคาราบิเนอร์ ไม่ว่าจะเป็นการสกรีนชื่อบริษัทหรือชื่องานอีเว้นท์ต่างๆ" />
	<meta name="keywords" content="คาราบิเนอร์, ตะขอ, ตัวเกี่ยวอเนกประสงค์, ตะขอเกี่ยวอเนกประสงค์, งานสกรีน, เลเซอร์, ของสัมนาคุณ" />
	<title>คาราบิเนอร์ ตะขอเกี่ยวอเนกประสงค์</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">คาราบิเนอร์ ตะขอเกี่ยวอเนกประสงค์</h1>
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
				<h2><?php lang("carabiner",$_SESSION["lang"]) ?></h2>
				<span>
					ตะขอเกี่ยวอเนกประสงค์ สามารถนำไปใช้งานกับเชือก และอุปกรณ์อื่นๆ นำมาประดับเป็นพวงกุญแจ
					สำหรับของสัมนาคุณในงานอิเว้นท์ต่างๆ หรือในงานแข่งขันกีฬา สามารถคล้องกับสายคล้องคอ
					หรือผลิตแบบติดเชือกขนาดสั้นได้ เป็นต้น มีน้ำหนักเบาเพียง 10 กรัมและสามารถรับน้ำหนักได้ถึง 70 กิโลกรัม
				</span>
				<h3 class="blue">คุณสมบัติพิเศษ</h3>
				<table class="tbl_vt">
					<tr>
						<td>
							<!-- <h3>รายละเอียด</h3> -->
							<img src="img/carabiner/carabiner_banner_1.jpg"><br/>
							<span>คาราบิเนอร์แบบเลเซอร์เป็นสินค้าคุณภาพดีไม่แพ้คาราบิเนอร์ทั่วไป</span>
						</td>
						<td>
							<!-- <h3>รายละเอียด</h3> -->
							<img src="img/carabiner/carabiner_banner_2.jpg"><br/>
							<span>ตัวผลิตภัณฑ์มี2แบบคือ แบบเงาและแบบด้าน</span>
						</td>
					</tr>
					<tr>
						<td>
							<!-- <h3>รายละเอียด</h3> -->
							<img src="img/carabiner/carabiner_banner_3.jpg"><br/>
							<span>ส่วนที่แบนราบสามารถสกรีนโลโก้ลงไปได้ ซึ่งสามารถสกรีนได้ 2 แบบคือ แบบเลเซอร์ และแบบซิลสกรีน</span>
						</td>
						<td>
							<!-- <h3>รายละเอียด</h3> -->
							<img src="img/carabiner/carabiner_banner_4.jpg"><br/>
							<span>ผลิตภัณฑ์ทั้งหมดนี้ได้ผ่านการทดสอบคุณภาพมาแล้ว ส่วนทีเป็นแขนเปิด-ปิดที่อยู่ตำแหน่งตรงกลางจะมีความแข็งแรงทนทานสูง</span>
						</td>
					</tr>
				</table>
				<div class="btn-ctu">
					<!-- <a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a> -->
					<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
					<!-- <a href="/template/" class="btn-s1">Design template</a> -->
				</div>
				<h3 class="blue">ตารางแสดงราคาคาราบิเนอร์</h3>
				<span>ราคาคาราบิเนอร์(ไม่มีสกรีน)</span>
				<div style="clear: both;">&nbsp;</div>
				<div class="exceed-table">
				<table class="tbl_prd" cellpadding="5" cellspacing="0">
	      	<tbody>
							<tr align="center" bgcolor="#E6E7E8">
								<td width="20%" rowspan="2" bgcolor="#ffffff">Size</td>
								<td width="80%" colspan="8" bgcolor="#ffffff">จำนวน</td>
							</tr>
	            <tr align="center" bgcolor="#E6E7E8">
	              <td width="10%">50 ชิ้น+</td>
	              <td width="10%">100 ชิ้น+</td>
	              <td width="10%">200 ชิ้น+</td>
	              <td width="10%">300 ชิ้น+</td>
	              <td width="10%">500 ชิ้น+</td>
	              <td width="10%">1,000 ชิ้น+</td>
	              <td width="10%">2,000 ชิ้น+</td>
	              <td width="10%">3,000 ชิ้น+</td>
	            </tr>
	            <tr align="center" bgcolor="#ffffff">
	              <td rowspan="1" bgcolor="#FFFF99">Size M<br>ขนาด<span class="red"> 60 </span>mm<br>(ความกว้าง)</td>
	              <td><span class="red f_tbl" >61 บาท</span><br>(3,050 บาท)</td>
	              <td><span class="red f_tbl" >50 บาท</span><br>(5,000 บาท)</td>
	              <td><span class="red f_tbl" >49 บาท</span><br>(9,800 บาท)</td>
	              <td><span class="red f_tbl" >47 บาท</span><br>(14,100 บาท)</td>
	              <td><span class="red f_tbl" >43 บาท</span><br>(21,500 บาท)</td>
	              <td><span class="red f_tbl" >38 บาท</span><br>(38,000 บาท)</td>
	              <td><span class="red f_tbl" >36 บาท</span><br>(72,000 บาท)</td>
	              <td><span class="red f_tbl" >35 บาท</span><br>(105,000 บาท)</td>
	            </tr>
							<tr align="center" bgcolor="#ffffff">
	              <td rowspan="1" bgcolor="#FFFF99">Size L<br>ขนาด<span class="red"> 70 </span>mm<br>(ความกว้าง)</td>
	              <td><span class="red f_tbl" >87 บาท</span><br>(4,350 บาท)</td>
	              <td><span class="red f_tbl" >73 บาท</span><br>(7,300 บาท)</td>
	              <td><span class="red f_tbl" >70 บาท</span><br>(14,00 บาท)</td>
	              <td><span class="red f_tbl" >67 บาท</span><br>(20,100 บาท)</td>
	              <td><span class="red f_tbl" >62 บาท</span><br>(31,000 บาท)</td>
	              <td><span class="red f_tbl" >55 บาท</span><br>(55,000 บาท)</td>
	              <td><span class="red f_tbl" >53 บาท</span><br>(106,000 บาท)</td>
	              <td><span class="red f_tbl" >51 บาท</span><br>(153,000 บาท)</td>
	            </tr>
		    	</tbody>
				</table>
		  	</div>
				<div class="txt-price">
        	1) ราคาด้านบนนี้เป็นราคาต่อจำนวนชิ้น(1ชิ้น/หน่วย) ซึ่งยังไม่รวมภาษีมูลค่าเพิ่ม<br/>
					2) หากสกรีนด้วยเลเซอร์ หรือแบบซิลค์สกรีนราคาจะเท่ากัน<br/>
					3) หากลูกค้าต้องการสินค้าตัวอย่างก่อนผลิตจริงจะมีค่าใช้จ่ายสำหรับเลเซอร์ 1,500 บาทและซิลค์สกรีน 5,500 บาท<br/>
					4) กรณีที่ลูกค้าต้องการสั่งหลายสีในออร์เดอร์เดียว ดีไซน์ต้องเหมือนกัน และสามารถสั่งคละได้สีละ50ชิ้นขึ้นไป<br/>
				</div>
				<span>
				ราคาสกรีนโลโก้<br>
				ราคาสกรีนโลโก้แบ่งออกเป็น 2 แบบ คือ สกรีนแบบเลเซอร์ และ สกรีนแบบซิลค์สกรีน<br>
				สามารถสกรีนได้ทั้งด้านเดียว และ แบบสองด้าน กรณีที่ลูกค้าอยากพิมพ์สองด้านโลโก้ต้องเหมือนกันทั้งคู่<br>
				</span>
				<h3 class="blue">แนะนำผลิตภัณฑ์ (สีผลิตภัณฑ์และการสกรีน)</h3>
				<table class="tbl_vt">
					<tr>
						<td>
							<h3>Ruby Red : แบบเงา</h3>
							<img src="img/carabiner/cb_gs_red_ss.jpg"><br/>
						</td>
						<td>
							<h3>Ruby Red : แบบด้าน</h3>
							<img src="img/carabiner/cb_mat_red_ss.jpg"><br/>
						</td>
					</tr>
					<tr>
						<td>
							<h3>Black : แบบเงา</h3>
							<img src="img/carabiner/cb_gs_black_ss.jpg"><br/>
						</td>
						<td>
							<h3>Black : แบบด้าน</h3>
							<img src="img/carabiner/cb_mat_black_ss.jpg"><br/>
						</td>
					</tr>
					<tr>
						<td>
							<h3>Silver : แบบเงา</h3>
							<img src="img/carabiner/cb_gs_slv_ss.jpg"><br/>
						</td>
						<td>
							<h3>Silver : แบบด้าน</h3>
							<img src="img/carabiner/cb_mat_slv_ss.jpg"><br/>
						</td>
					</tr>
					<tr>
						<td>
							<h3>การสกรีนด้วยเลเซอร์</h3>
							<img src="img/carabiner/cb_mat_slv_ls.jpg"><br/>
						</td>
						<td>
							<h3>การสกรีนแบบซิลค์สกรีน</h3>
							<img src="img/carabiner/cb_sl2_s.jpg"><br/>
						</td>
					</tr>
				</table>
				<div class="btn-ctu">
					<!-- <a href="/orders/" class="btn-s1">สั่งซื้อสินค้า</a> -->
					<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
					<!-- <a href="/template/" class="btn-s1">Design template</a> -->
				</div>
				<h3 class="blue" id="poly">ระยะเวลาการจัดส่ง</h3>
				<div class="table_01">
						<div class="tb_00">
							<div class="tr_01">
								<div class="tb_01">ระยะเวลาส่งมอบสำหรับเลเซอร์สกรีน</div>
								<div class="tb_02">ภายใน 8~11 วันทำการ</div>
							</div>
						</div>
					</div>
					<div class="table_01">
						<div class="tb_00">
							<div class="tr_01">
								<div class="tb_05">ระยะเวลาส่งมอบสำหรับซิลค์สกรีน</div>
								<div class="tb_06">ภายใน 8~14 วันทำการ</div>
							</div>
						</div>
					</div>
				<span>
						*วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์
				</span>
			</div>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>
</body>
</html>
