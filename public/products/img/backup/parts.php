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
	<link rel="canonical" href="/products/parts.php" />
	<meta name="description" content="บริษัทยูแอนด์เอริธ ซิสเท็มจำกัด รับออกแบบและผลิตสายคล้องคอพนักงาน สายคล้องบัตร โดยมีส่วนประกอบเชือกที่หลากหลายเพื่อให้ตรงกับความต้องการของลูกค้ามากที่สุด" />
	<meta name="keywords" content="ส่วนประกอบเชือก, สายคล้องคอพนักงาน, สายคล้องบัตร, สายคล้องคอ, ตะขอ, คลิปPVC, โยโย่" />
	<title>ส่วนประกอบสาย | สายคล้องคอพนักงาน | ส่งฟรี</title>
	<style type="text/css">
		.tbl_vt .tbl_prd tr {
			vertical-align: middle;
			content: "";
			display: flex;
		}
		.tbl_vt tr {
			vertical-align: text-top;
			content: "";
			display: table;
			clear: both;
			margin-bottom: 0px;
		}
		.tbl_prd {
			width: 100%;
			font-size: 75%;
			border-collapse: collapse;
			border: 1px solid grey;
		}
		.tbl_prd tr td {
			border: 1px solid grey;
		}
		.tbl_prd tr td {
			border: 1px solid grey;
			width: 100%;
		}
	</style>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">พาร์ทสายคล้องคอ</h1>
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
			<div class="pd-main" style="">
				<!--Side menu-->
				<?php require_once('side_menu.php')?>
				<!--end-->
				<div class="content">
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
					<h2>ส่วนประกอบพิเศษ</h2>
					<div class="row-bs">
						<div class="col-sm-6 col-12">
							<div style="padding: 0 10px;">
								<h3>Safety part</h3>
								<img src="img/part_new/Safety-part.jpg"><br/>
								<span>วัสดุ: พลาสติก มีสีดำ, สีขาว (ขนาด 20 mm จะมีแค่สีดำ)<br/>
									<font color="red">ราคาเริ่มต้น : 5 บาท</font><br/>
									ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
									ชิ้นส่วนที่แข็งแรงนี้จะช่วยป้องกันให้สายคล้องคอหลุดออกจากคอยากขึ้น
									<a href="img/ins_sf.jpg" data-lightbox="img1" data-title="" class="link2" style="text-decoration:none;">จุดที่สามารถติดตั้ง Safety part ได้</a>หรือคลิก<a href="img/MVI_0719.mp4" target="_blank" class="link2">ที่นี่</a>เพื่อดูวิดิโอสาธิตการใช้งาน</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>สายห้อยโทรศัพท์มือถือ</h3>
									<img src="img/part_new/mobile.jpg"><br/>
									<span>วัสดุ : พลาสติก (ยกเว้นส่วนที่เป็นห่วงและสายห้อยโทรศัพท์)<br/>
										<font color="red">ราคาเริ่มต้น : 5 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm และขนาดอื่นๆ<br/>
									ชิ้นส่วนสำหรับห้อยโทรศัพท์มือถือ หรืออุปกรณ์ต่างๆ สามารถแยกออกจากกันได้ มีให้เลือก2สี คือ สีขาว และสีดำ</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>สายห้อยโทรศัพท์มือถือ (แบบถอดได้)</h3>
									<img src="img/part_new/detachable.jpg"><br/>
									<span>วัสดุ : พลาสติก (ยกเว้นส่วนที่เป็นสายห้อยโทรศัพท์มือถือ)<br/>
										<font color="red">ราคาเริ่มต้น : 5 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 15 mm<br/>
									ชิ้นส่วนนี้นำไปติดเข้ากับสายคล้องคอ แล้วยังสามารถแยกออกจากกันได้อีกด้วย ในส่วนที่เป็นเชือกยังสามารถห้อยโทรศัพท์มือถือ หรืออุปกรณ์ต่างๆได้</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>สายห้อยโทรศัพท์มือถือ (แบบชิ้นเดียว)</h3>
									<img src="img/part_new/Pine.jpg"><br/>
									<span>วัสดุ : พลาสติก (ยกเว้นส่วนที่เป็นสายห้อยโทรศัพท์มือถือ)<br/>
										<font color="red">ราคาเริ่มต้น : 5 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 15 mm, 20 mm<br/>
										ชิ้นส่วนนี้นำไปติดเข้ากับสายคล้องคอ ส่วนทีเป็นสายห้อยโทรศัพท์มือถือจะยึดติดแน่นกับส่วนพลาสติกซึ่งมีความ
									แข็งแรงจึงสามารถนำไปใช้ห้อยโทรศัพท์มือถือ หรืออุปกรณ์ต่างๆได้</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>ตะขอพลาสติก</h3>
									<img src="img/part_new/Plasticnasacan.jpg"><br/>
									<span>วัสดุ : พลาสติก<br/>
										<font color="red">ราคาเริ่มต้น : 12 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
									ชิ้นส่วนนี้มีน้ำหนักเบา ใช้งานง่ายกว่าชิ้นส่วนที่เป็นโลหะ เหมาะกับสายคล้องคอสำหรับเด็ก</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>ตัวล็อกก้ามปู</h3>
									<img src="img/part_new/Buckle.jpg"><br/>
									<span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br/>
										<font color="red">ราคาเริ่มต้น : 13 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
									และขนาดอื่น ๆ (สามารถใช้กับเชือกขนาด 30 mmได้ รูปทรงอาจแตกต่างกันเล็กน้อย) ชิ้นส่วนนี้นำไปติดเข้ากับสายคล้องคอ และสามารถถอดออกได้โดยกดตรงด้านข้างของตัวล็อคก้ามปูแล้วดึงออก</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>ตัวเลื่อนปรับความยาวแบบ A</h3>
									<img src="img/part_new/parts_A.jpg"><br/>
									<span>วัสดุ : พลาสติก (มีเฉพาะสีดำ)<br/>
										<font color="red">ราคาเริ่มต้น : 15 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
									ชิ้นส่วนนี้จะใช้สำหรับปรับระดับความสั้น ความยาวของสายคล้องคอได้</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>ตัวเลื่อนปรับความยาวแบบ B</h3>
									<img src="img/part_new/parts_B.jpg"><br/>
									<span>วัสดุ : พลาสติก (มีเฉพาะสีดำเท่านั้น )<br/>
										<font color="red">ราคาเริ่มต้น : 10 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm(Flat)<br/>
									ชิ้นส่วนนี้จะอยู่บริเวณคอ เมื่อกดปุ่มสีดำแล้วเลื่อนจะสามารถปรับความยาวของสายคล้องคอให้สั้นหรือยาวได้</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>ตัวเลื่อนปรับความยาวแบบ C</h3>
									<img src="img/part_new/parts_C.jpg"><br/>
									<span>วัสดุ : พลาสติก ( มีเฉพาะสีดำเท่านั้น )<br/>
										<font color="red">ราคาเริ่มต้น : 10 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm(Tubeler), 15 mm(Flat)<br/>
									ชิ้นส่วนนี้จะอยู่บริเวณคอ สามารถใช้เลื่อนเพื่อปรับระดับความยาวของสายคล้องคอได้ตามต้องการ</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>ตัวเลื่อนปรับความยาวแบบ E</h3>
									<img src="img/part_new/parts_E.jpg"><br/>
									<span>วัสดุ : พลาสติก (มีเฉพาะสีดำเท่านั้น )<br/>
										<font color="red">ราคาเริ่มต้น : 10 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 15 mm, 20 mm (เฉพาะแบบ Flat เท่านั้น )<br/>
									ชิ้นส่วนนี้จะอยู่บริเวณคอ สามารถใช้เลื่อนเพื่อปรับระดับความยาวของสายคล้องคอได้ตามต้องการ</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>ตัวล็อกแบบหนีบ</h3>
									<img src="img/part_new/caulking.jpg"><br/>
									<span>วัสดุ : โลหะ<br/>
										<font color="red">ราคาเริ่มต้น : 5 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
										ชิ้นส่วนนี้เป็นโลหะรูปทรงสี่เหลี่ยมผืนผ้าที่นำไปติดเข้ากับสาย
									คล้องคอ เพื่อพับส่วนปลายเก็บที่ด้านหลังแทนการเย็บ</span>
								</div>
							</div>
							<div class="col-sm-6 col-12">
								<div style="padding: 0 10px;">
									<h3>กระดุมเรซิ่น</h3>
									<img src="img/part_new/tomegu.jpg"><br/>
									<span>วัสดุ : พลาสติก (พร้อมสติ๊กเกอร์เรซิ่น)<br/>
										<font color="red">สั่งขั้นต่ำ 50 ชิ้น ราคาเริ่มต้น : 30 บาท</font><br/>
										ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm<br/>
										ชิ้นส่วนนี้เป็นพลาสติกทรงกลมเพื่อปิดรอยเย็บ สกรีนโลโก้บริษัท ตรา สัญลักษณ์ต่างๆได้
									กรณีนำสายคล้องคอไปซัก สามารถถอดโลโก้ด้านบนออกได้</span>
								</div>
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
