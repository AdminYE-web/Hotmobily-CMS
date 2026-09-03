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
	<link rel="canonical" href="/products/reflector.php" />
	<meta name="description" content="สายคล้องบัตรสะท้อนแสง ตัวสายคล้องบัตรมีแถบสะท้อนแสงเหมาะสำหรับพนักงานที่ต้องทำงานในเวลากลางคืนช่วยเพิ่มความปลอดภัยหรืองานอีเว้นท์ที่จัดในที่มืดเพื่อเพิ่มความโดดเด่น" />
	<meta name="keywords" content="สายสะท้อนแสง,สายคล้องบัตร,สายคล้องคอพนักงาน,เรืองแสง,สะท้อนแสง,reflector" />
	<title>สายคล้องบัตรสะท้อนแสง - Reflector Strap</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">สายคล้องบัตรพนักงาน - สะท้อนแสง</h1>
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
					<h2>สายคล้องบัตรสะท้อนแสง</h2>
					<div class="slide_show">
						<div class="img-show">
							<img src="img/rf-1.jpg" id="prm-i1">
							<img src="img/rf-2.jpg" id="prm-i2" style="display: none;">
							<img src="img/rf-3.jpg" id="prm-i3" style="display: none;">
							<img src="img/rf-4.jpg" id="prm-i4" style="display: none;">
						</div>
						<div class="sub-show">
							<div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/rf-1.jpg" width="120"></a></div>
							<div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/rf-2.jpg" width="120"></a></div>
							<div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/rf-3.jpg" width="120"></a></div>
							<div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/rf-4.jpg" width="120"></a></div>
						</div><br/>
						<span class="red">*ติดต่อพนักงานขายขอรับตัวอย่างสายคล้องบัตรสะท้อนแสงฟรี!<a href="/contact/" class="link2">ที่นี่</a></span>
					</div>
					<div class="txt-show">
						<span><?php lang("detail",$_SESSION["lang"]) ?></span>
						<table class="tbl-txt">
							<tr>
								<td class="td1">ชื่อสินค้า</td>
								<td class="td2">สายคล้องบัตรสะท้อนแสง</td>
							</tr>
							<tr>
								<td class="td1">ขนาดเชือก</td>
								<td class="td2">10mm, 15mm, 20mm และขนาดอื่นๆ</td>
							</tr>
							<tr>
								<td class="td1">สีเชือก</td>
								<td class="td2">Orange C&nbsp;<a class="link2" href="product_color.php">ดูเพิ่มเติม</a></td>
							</tr>
							<tr>
								<td class="td1">พาร์ทเชือกที่ใช้</td>
								<td class="td2">ตะขอ <a class="link2" href="parts.php">ดูเพิ่มเติม</a></td>
							</tr>
							<tr>
								<td class="td1">การจัดส่ง</td>
								<td class="td2"><a class="link2" href="#delivery">คลิกที่นี่</a></td>
							</tr>
						</table>
						<div class="btn-ctu">
							<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
						</div>
					</div>
					<div style="clear: both;">&nbsp;</div>
					<img src="/images/reflector_banner.jpg?v=1.01" style="width:100%">
					<h3 class="blue">ตารางราคาสายคล้องบัตรสะท้อนแสง</h3>
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
          	<td rowspan="1" colspan="2" style="background-color:#FFFF99">ขนาด<span class="red">15</span>mm.</td>
          	<td><span class="red f_tbl" >3,920 บาท</span><br>196.00บาท/เส้น</td>
            <td><span class="red f_tbl" >4,880 บาท</span><br>162.67บาท/เส้น</td>
            <td><span class="red f_tbl" >6,800 บาท</span><br>136.00บาท/เส้น</td>
            <td><span class="red f_tbl" >8,100 บาท</span><br>81.00บาท/เส้น</td>
            <td><span class="red f_tbl" >12,600 บาท</span><br>63.00บาท/เส้น</td>
            <td><span class="red f_tbl" >15,800 บาท</span><br>52.67บาท/เส้น</td>
            <td><span class="red f_tbl" >21,000 บาท</span><br>42.00บาท/เส้น</td>
            <td><span class="red f_tbl" >31,000 บาท</span><br>31.00บาท/เส้น</td>
            <td><span class="red f_tbl" >54,000 บาท</span><br>27.00บาท/เส้น</td>
            <td><span class="red f_tbl" >77,000 บาท</span><br>25.67บาท/เส้น</td>
          </tr>
          <tr align="center" bgcolor="#ffffff">
          	<td rowspan="1" colspan="2" style="background-color:#FFFF99">ขนาด<span class="red">20</span>mm.</td>
          	<td><span class="red f_tbl" >4,320 บาท</span><br>216.00บาท/เส้น</td>
            <td><span class="red f_tbl" >5,480 บาท</span><br>182.67บาท/เส้น</td>
            <td><span class="red f_tbl" >7,800 บาท</span><br>156.00บาท/เส้น</td>
            <td><span class="red f_tbl" >8,600 บาท</span><br>86.00บาท/เส้น</td>
            <td><span class="red f_tbl" >14,200 บาท</span><br>71.00บาท/เส้น</td>
            <td><span class="red f_tbl" >18,800 บาท</span><br>62.67บาท/เส้น</td>
            <td><span class="red f_tbl" >25,000 บาท</span><br>50.00บาท/เส้น</td>
            <td><span class="red f_tbl" >36,000 บาท</span><br>36.00บาท/เส้น</td>
            <td><span class="red f_tbl" >62,000 บาท</span><br>31.00บาท/เส้น</td>
            <td><span class="red f_tbl" >83,000 บาท</span><br>27.67บาท/เส้น</td>
          </tr>
      </tbody>
  </table>
</div>
      <div class="txt-price">
      	1) ราคานี้เป็นราคาของสายคล้องคอสกรีน 1 สีเท่านั้นหากต้องการสกรีนมากกว่า 1 สีกรุณา<a href="/contact/" class="link2">ติดต่อพนักงานขาย</a><br/>
      	2) ราคาจำหน่ายนี้รวมค่าบรรจุใส่ถุง และค่าจัดส่งภายในประเทศต่อ 1 สถานที่<br/>
      	3) หากสายคล้องบัตรที่ท่านสั่งผลิตมีจำนวนมาก ทางเราจะส่งสายคล้อง / บัตรตัวอย่างให้ตรวจสอบก่อนผลิตจริงฟรี<br/>
      	4) ตัวอย่างสายคล้องบัตร (ดีไซน์ตัวอย่าง) ผลิตได้หนึ่งเส้นต่อหนึ่งรายการสั่งซื้อเท่านั้น<br/>
      	5) อาจมีค่าใช้จ่ายเพิ่มเติมสำหรับพาร์ทออฟชั่นเสริม,เชือกขนาดพิเศษ หรือ แบบพิเศษ<br/>
      	6) ราคาจำหน่ายสายคล้องบัตรที่แสดงยังไม่รวมภาษีมูลค่าเพิ่ม<br/>
      	7) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ
      </div>
      <h3 class="blue" id="delivery">ระยะเวลาการผลิต</h3>
      <div class="table_01">
      	<div class="tb_00">
      		<div class="tr_01" id="delivery">
      			<div class="tb_01">ระยะเวลาการส่งมอบปกติ</div>
      			<div class="tb_02">ภายใน 11~13 วันทำการ</div>
      		</div>
      	</div>
      </div>
      <p>
      	*กรณีที่สั่งผลิตสายคล้อง / บัตรไม่เกิน 3,000 เส้น(สำหรับการส่งมอบปกติ)<br/>
      	*หากเลือกสีเส้นตั้งแต่สองสีขึ้นไปจะใช้เวลาเพิ่มขึ้น<br/>
      	*วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์
      </p>
      <h2 class="blue">สายคล้องบัตรสะท้อนแสง-Reflector มีสองแบบดังนี้</h2>
      <h3 class="blue">สายคล้องบัตรสะท้อนแสงแบบ A</h3>
      <img src="img/reflectorA.jpg" class="img_center">
      <p>ชื่อผลิตภัณฑ์: สายคล้องบัตรสะท้อนแสง A</p>
      <p>ลักษณะผ้า: ผ้าโพลีเอสเตอร์(ผ้าไนลอนไม่สามารถทำได้)</p>
      <p>วัสดุสะท้อนแสง: แผ่นเทปสะท้อนแสงที่ติดลงบนตัวสายคล้องบัตรจะมีความกว้างเท่ากันกับเชือกเพื่อให้เห็นเป็นแสงสะท้อนออกมา ซึ่งจะมีความกว้างประมาณ 8-25mm </p>
      <p>ขนาดสาย: 15, 20mm (<span class="red">ขนาด 10mm ไม่สามารถทำได้</span>)</p>
      <p>การสกรีน: สกรีนโลโก้แบบซิลค์สกรีนทับลงบนแทบสะท้อนแสง ส่วนที่สกรีนจะไม่สะท้อนแสง</p>
      <h3 class="blue">สายคล้องบัตรสะท้อนแสงแบบ B</h3>
      <img src="img/reflectorB.jpg" class="img_center">
      <p>ชื่อผลิตภัณฑ์: สายคล้องบัตรสะท้อนแสง B</p>
      <p>ลักษณะผ้า: ผ้าโพลีเอสเตอร์(ผ้าไนลอนไม่สามารถทำได้)</p>
      <p>วัสดุสะท้อนแสง: แผ่นสะท้อนจะสอดเข้าไปในเส้นของสายคล้องบัตรเรียงสองแถว ซึ่งขนาดของแถบสะท้อนมี3แบบ คือ กว้าง 1mm, 1.5mm, 2mm ด้านหลังจะไม่เห็นแถบสะท้อนแสง </p>
      <p>ขนาดสาย: 15, 20mm (<span class="red">ขนาด 10mm ไม่สามารถทำได้</span>)</p>
      <p>การสกรีน: สกรีนโลโก้แบบซิลค์สกรีน</p>
      <h3 class="blue">สีของสายคล้องบัตร</h3>
      <div class="box">
      	<img src="img/Poly-color-banner.jpg?v=1.01"><br>
      </div>
      <div class="btn-ctu">
      	<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
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
