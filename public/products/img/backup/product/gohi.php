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
	<link rel="canonical" href="/products/gohi.php" />
	<meta name="description" content="สายคล้องบัตรหนัง PU สายหนังเทียมเกรดพรีเมียม ช่วยอัพเกรดระดับความน่าเชื่อถือขององค์กร ตัวสายมีให้เลือกมากถึง 34 สี สายแข็งแรงทนทานใช้งานได้นานการันตีคุณภาพจากประเทศญี่ปุ่น" />
	<meta name="keywords" content="สายคล้องบัตร, สายหนังเทียม, หนัง, หนังเทียม, pu, องค์กร" />
	<title>สายคล้องบัตรหนังเทียม PU</title>
	<style type="text/css">
		.tbl_edit{
			margin: auto;width: 80%;text-align: center;
		}
	</style>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">สายคล้องบัตรพนักงาน - หนังเทียม PU</h1>
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
					<h2>สายคล้องบัตรหนัง PU</h2>
					<div class="slide_show">
						<div class="img-show">
							<img src="img/gh-1.jpg" id="prm-i1">
							<img src="img/gh-2.jpg" id="prm-i2" style="display: none;">
							<img src="img/gh-3.jpg" id="prm-i3" style="display: none;">
							<img src="img/gh-4.jpg" id="prm-i4" style="display: none;">
						</div>
						<div class="sub-show">
							<div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/gh-1.jpg" width="120"></a></div>
							<div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/gh-2.jpg" width="120"></a></div>
							<div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/gh-3.jpg" width="120"></a></div>
							<div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/gh-4.jpg" width="120"></a></div>
						</div><br/>
						<span class="red">*ติดต่อพนักงานขายขอรับตัวอย่างสายคล้องคอฟรี!<a href="/contact/" class="link2">ที่นี่</a></span>
					</div>
					<div class="txt-show">
						<span><?php lang("detail",$_SESSION["lang"]) ?></span>
						<table class="tbl-txt">
							<tr>
								<td class="td1">ชื่อสินค้า</td>
								<td class="td2">สายคล้องบัตรหนัง PU</td>
							</tr>
							<tr>
								<td class="td1">ขนาดเชือก</td>
								<td class="td2">10mm, 15mm</td>
							</tr>
							<tr>
								<td class="td1">สีเชือก</td>
								<td class="td2">กรุณาสอบถามพนักงานขาย</td>
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
					<img src="/images/pu_banner.jpg?v=1.01" style="width:100%">
					<h3 class="blue">ตารางราคาสายคล้องบัตรหนัง PU</h3>
					<img src="img/nylon_opt.jpg" class="img_center">
					<div class="exceed-table">
						<table class="tbl_prd" cellpadding="5" cellspacing="0">
							<tbody>
								<tr align="center" bgcolor="#E6E7E8">
									<td width="20%" colspan="2" bgcolor="#ffffff">&nbsp;</td>
									<td width="10%">50 เส้น</td>
									<td width="10%">100 เส้น</td>
									<td width="10%">200 เส้น</td>
									<td width="10%">300 เส้น</td>
									<td width="10%">500 เส้น</td>
									<td width="10%">1,000 เส้น</td>
									<td width="10%">2,000 เส้น</td>
									<td width="10%">3,000 เส้น</td>
								</tr>
								<tr align="center" bgcolor="#ffffff">
									<td rowspan="1" colspan="2" bgcolor="#FFFF99">ขนาด<span class="red">10</span>mm.</td>
									<td><span class="red f_tbl" >6,350 บาท</span><br>127.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >8,800 บาท</span><br>88.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >15,600 บาท</span><br>78.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >20,300 บาท</span><br>67.67บาท/เส้น</td>
						            <td><span class="red f_tbl" >27,000 บาท</span><br>54.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >40,000 บาท</span><br>40.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >78,000 บาท</span><br>39.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >107,000 บาท</span><br>35.67บาท/เส้น</td>
								</tr>
								<tr align="center" bgcolor="#ffffff">
									<td rowspan="1" colspan="2" style="background-color:#FFFF99">ขนาด<span class="red">15</span>mm.</td>
									<td><span class="red f_tbl" >7,200 บาท</span><br>144.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >9,900 บาท</span><br>99.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >17,800 บาท</span><br>89.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >23,600 บาท</span><br>78.67บาท/เส้น</td>
						            <td><span class="red f_tbl" >31,000 บาท</span><br>62.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >47,000 บาท</span><br>47.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >92,000 บาท</span><br>46.00บาท/เส้น</td>
						            <td><span class="red f_tbl" >131,000 บาท</span><br>43.67บาท/เส้น</td>
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
							<h3 class="blue" id="delivery">ระยะเวลาการผลิต</h3>
							<div class="table_01">
								<div class="tb_00">
									<div class="tr_01" id="delivery">
										<div class="tb_01">ระยะเวลาการส่งมอบปกติ</div>
										<div class="tb_02">ภายใน 13~15 วันทำการ</div>
									</div>
								</div>
							</div>
							<p>
								*กรณีที่สั่งผลิตสายคล้อง / บัตรไม่เกิน 3,000 เส้น(สำหรับการส่งมอบปกติ)<br/>
								*หากเลือกสีเส้นตั้งแต่สองสีขึ้นไปจะใช้เวลาเพิ่มขึ้น<br/>
								*วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์
							</p>

							<div class="row-bs" style="text-align: center;">
								<div class="col-12">
									<img src="img/pu-0.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-1.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-2.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-3.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-4.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-5.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-6.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-7.jpg" style="padding: 5px 0;">
								</div>
								<div class="col-md-6 col-12">
									<img src="img/pu-8.jpg" style="padding: 5px 0;">
								</div>
							</div>
							<h3 class="blue">รายละเอียดสาย</h3>
							<p>ชื่อผลิตภัณฑ์: สายคล้องบัตรหนัง PU<br>
								ความยาว: ควมยาวแบบพับครึ่ง 45CM (เป็นความยาวมาตรฐาน หากลูกค้าต้องการความยาวมากกว่านี้ก็สามารถทำได้เช่นกัน) <br>
							สีเชือก: สีของสายคล้องคอหนังPU </p>
							<img src="img/color-pu.jpg" class="img_center">
							<p>ความหนา: 2～2.5mm <br>
							จำนวนขั้นต่ำ: 50 เส้น </p>
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
							<div class="btn-ctu">
								<a href="/contact/" class="btn-s1">ติดต่อฝ่ายขาย</a>
							</div>
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
