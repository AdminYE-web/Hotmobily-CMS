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
	<link rel="canonical" href="/guide/order_flow.php" />
	<meta name="description" content="เว็บไซต์ hotstrapthai.com มีคู่มือที่จะช่วยให้ลูกค้าสามารถสั่งซื้อสินค้าได้อย่างง่ายดาย พร้อมทั้งบอกราคาให้อย่างครบถ้วน การันตีได้ว่าลูกค้าจะได้รับสินค้ามีคุณภาพในราคาที่ถูกใจ" />
	<meta name="keywords" content="วิธีการสั่งซื้อ, สายคล้องคอพนักงาน, สายคล้องคอ, ซองใส่บัตรพนักงาน, ซับลิเมชั่น" />
	<title>วิธีการสั่งซื้อ|สายคล้องคอพนักงาน</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">วิธีการสั่งซื้อ</h1>
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
				<h2>วิธีการสั่งซื้อ</h2>
				<div class="col-box-row">
					<div class="col-box-num">
						<span>1.</span>
					</div>
					<div class="col-box-txt">
					<h3 class="m0 blue">เลือกสินค้าที่คุณต้องการ</h3>
					<p>ในเว็บไซต์ของเรามี<a href="/products/" class="link2">สายคล้องคอพนักงาน</a>รูปแบบต่างๆและ<a href="/products/parts.php" class="link2">ส่วนประกอบเชือก</a>ที่มีหลากหลายให้
					คุณได้เลือกอย่างมากมาย นอกจากนี้สายคล้องคอพนักงานของเรายังมีให้เลือกมากถึง<a href="/products/product_color_std.php" class="link2"> 20 สี</a>และยังสั่งสีพิเศษตามที่คุณต้องการได้อีกด้วย รวมทั้งในเว็บไซต์ของเรายัง<a href="/products/case_cards.php" class="link2">ซองใส่บัตรพนักงาน</a>ให้เลือกมากกว่า 10 และบางแบบยังฟรีอีกด้วย(เมื่อสั่งซื้อพร้อมสายคล้องคอ) <a href="/orders/" class="link2">คลิกที่นี่</a> เพื่อสั้งซื้อสินค้า</p>
					</div>
				</div>
				<div style="clear: both;">&nbsp;</div>
				<div class="col-box-row">
					<div class="col-box-num">
						<span>2.</span>
					</div>
					<div class="col-box-txt">
					<h3 class="m0 blue">เริ่มการสั่งซื้อ</h3>
					<p>
						ในหน้าของการสั่งซื้อสินค้าจะมี 6 ขั้นตอนหลักๆดังต่อไปนี้<br/>
						1.) <span class="red">ขั้นตอนเลือกแบบเชือก</span> โดยบริษัทของเราจำหน่ายสายค้ลองคอพนักงาน 4 แบบคือ <a href="/products/premium.php" class="link2">สายคล้องคอพนักงานแบบพรีเมียม</a>, <a href="/products/standard.php" class="link2">สายคล้องคอแบบโพลีเอสเตอร์</a>, <a href="/products/nylon.php" class="link2">สายคล้องคอแบบไนลอน</a>, <a href="/products/fullcolor.php" class="link2">สายคล้องคอแบบซับลิเมชั่น</a><br/>
						2.)	<span class="red" id="color">ขั้นตอนเลือกสีเชือก</span> ในส่วนขั้นตอนนี้ลูกค้าต้องทำการเลือกสีเชือกธรรมดาหรือ
						เพิ่มสีเชือกพิเศษอย่างน้อย 1 สี โดยสีธรรมดาสามารถเลือกได้ไม่เกิน 5 สี(สีที่สองขึ้นไปมีค่าใช้จ่ายเพิ่มสีละ 800 บาทต่อสี/การสั่งซื้อ)และสีพิเศษเพิ่มได้ไม่เกิน 3 สี(มีค่าใช้จ่ายเพิ่มสีละ 1500 บาทต่อสี/การสั่งซื้อ)<br/>
						3.) <span class="red" id="scolor">ขั้นตอนเลือกสีสกรีน</span> หากลูกค้าไม่ได้เพิ่มสีอื่นทางเราจะกำหนดให้เป็นสีขาว โดยค่าบริการสีสกรีนจะอยู่ที่สีละ 1000 บาท/การสั่งซื้อ <br/>
						4.) <span class="red">ขั้นตอนเลือกพาร์ท</span> ในขั้นตอนนี้จะแบ่งเป็น 4 ขั้นตอนย่อยๆได้แก่<br/>
						&nbsp;&nbsp;&nbsp; 4.1) <a href="/products/part.php" class="link2">ส่วนประกอบเชือก</a> ส่วนประกอบเชือกคือตะขอที่ติดอยู่บริเวณหัวเชือกมีให้เลือกมากถึง 8 แบบและยังสามารถเลือกแบบที่เป็นโยโย่ได้ด้วย โดยจะมีส่วนประกอบเชือกแบบที่ฟรีและมีค่าใช้จ่ายโดยแบบฟรีจะอยู่ในกล่องสีฟ้าและแบบมีค่าใช้จ่ายจะอยู่ในกล่องสีแดง<br/>
						&nbsp;&nbsp;&nbsp; 4.2) ส่วนประกอบพิเศษ ในส่วนนี้จะเป็นส่วนประกอบพิเศษที่จะสามารถเพิ่มเติมเข้าไปในเส้นของสายคล้องคอได้และแต่ละชิ้นจะมีค่าใช้จ่ายไม่เท่ากัน<br/>
						&nbsp;&nbsp;&nbsp; 4.3) <span id="sample">ตัวอย่างต้นแบบ</span> ในกรณีที่ลูกค้าต้องการตัวอย่างต้นแบบ ลูกค้าจะได้รับสินค้าตัวอย่างภายในระยะเวลาการผลิตสินค้าประเภทนั้นตรวจสอบระยะเวลาการผลิตได้<a href="/products/product_detail.php" class="link2">ที่นี่</a> หลังจากลูกค้าสินค้าและตอบตกลง จะเริ่มทำการผลิตสินค้าต่อตามระยะเวลาการผลิต หากมีข้อสงสัยเพิ่มเติม<a href="/contact/index.php" class="link2">กรุณาติดต่อเรา</a><br/>
						&nbsp;&nbsp;&nbsp; 4.4) <span id="express">ความต้องการเร่งด่วน</span> ในกรีที่ลูกค้ามีความต้องการสินค้าแบบเร่งด่วนทางเราก็จะมีบริการให้ลูกค้าสามารถเลือกได้โดย บริการความต้องการสินค้าแบบเร่งด่วนนี้จะมีค่าใช้จ่ายเพิ่มเติม 10 เปอร์เซ็นของยอดค่าใช้จ่ายทั้งหมดก่อนบวกภาษีมูลค่าเพิ่ม การสั่งผลิตสายคล้องคอแบบเร่งด่วนลูกค้าจะไม่สามารถสั่งเกิน 500 เส้นและสายคล้องคอแบบพรีเมียมจะไม่สามารถใช้บริการนี้ได้ สายคล้องคอที่ผลิตแบบเร่งด่วนก็จะมีคุณภาพเหมือนกับสายคล้องคอที่สั่งแบบปกติ แต่ขอให้ลูกค้ามั่นใจว่า หากเลือกใช้บริการนี้จะได้รับสินค้ารวดเร็วทันใจและได้คุณภาพอย่างแน่นอน<br/>
						5.) <span class="red">ขั้นตอนเลือกซองใส่บัตรพนักงาน</span> ในส่วนของขั้นตอนจะให้ลูกค้าเลือกแบบ<a href="/products/case_cards.php" class="link2">ซองใส่บัตรพนักงาน</a>ที่ต้องการ ซึ่งจะมีทั้งแบบที่ไม่มีค่าใช้จ่าย<br/>
						6.) <span class="red">ขั้นตอนการใส่จำนวนที่ต้องการสั่งซื้อ</span> จำนวนขั้นต่ำคือ 50 เส้นและสูงสุดคือ 50,000 เส้น จำนวนขั้นต่ำจะมีการเปลี่ยนแปลงไปตามเงื่อนไขต่างๆตามที่ลูกค้าเลือกแต่ละขั้นตอนที่ผ่านมา หากพบข้อสงสัย<a href="/contact/index.php" class="link2">กรุณาติดต่อเรา</a><br/>
						:: หลังจากลูกค้าทำตอนขั้นตอนต่างๆครบถ้วนกรุณากดปุ่มคำนวนราคา ::<br/>
						:: หลังจากลูกค้ากดปุ่มคำนวนราคาจะสามารถสั่งซื้อสินค้าตามข้อมูลในใบเสนอราคาที่แสดงในหน้านั้นได้โดยกดปุ่มสั่งซื้อหรือจะสั่งพิมพ์รายก็สามารถทำได้โดยกดปุ่มพิมพ์ใบเสนอราคา ::
					</p>
					</div>
				</div>
				<div style="clear: both;">&nbsp;</div>
				<div class="col-box-row">
					<div class="col-box-num">
						<span>3.</span>
					</div>
					<div class="col-box-txt">
					<h3 class="m0 blue">กรอกข้อมูลยืนยันการสั่งซื้อ</h3>
					<p>หลังจากเสร็จสิ้นการเลือกซื้อสายคล้องคอแล้ว ในหน้าหน้าถัดไปจะเป็นส่วนให้ลูกค้ากรอกข้อมูลเพื่อยืนยันการสั่งซื้อโดยทางบริษัท จะไม่มีการเปิดเผยข้อมูลส่วนตัวของลูกค้าโดยเด็ดขาด ข้อมูลจะถูกใช้เพื่อการติดต่อกับทางบริษัทเท่านั้น ลูกค้าโปรดเพิ่มไฟล์ตัวอย่างสายคล้องคอที่ต้องการในหัวข้อ<span class="red">ไฟล์ตัวอย่าง</span> หรือดาวน์โหลด <a href="/template/index.php" class="link2">design template</a> เพื่อความสะดวกในการสั่งซื้อสายคล้องคอได้อีกด้วย</p>
					</div>
				</div>
				<div class="col-box-row">
					<div class="col-box-num">
						<span>4.</span>
					</div>
					<div class="col-box-txt">
					<h3 class="m0 blue">ตรวจสอบความถูกต้องของข้อมูล</h3>
					<p>เมื่อท่านตรวจสอบความถูกต้องเรียบร้อยแล้ว ให้กดปุ่ม send เพื่อยืนยันคำสั่งซื้อ หลังจากยืนยันคำสั่งซื้อท่านจะได้รับอีเมลจาก <a href="mailto:contact_hs@hotstrapthai.com" class="link2">contact_hs@hotstrapthai.com</a> เพื่อแสดงรายละเอียดการสั่งซื้อ คำสั่งซื้อทุกคำสั่งซื้อจะมีระยะเวลา 7 วันเพื่อชำระเงิน หลังจากท่านชำระเงินเรียบร้อยแล้วหรือพบข้อสงสัยกรุณาแจ้งทาง <a href="mailto:contact_hs@hotstrapthai.com" class="link2">contact_hs@hotstrapthai.com</a> หรือโทร <a href="tel:026378995" class="link2">02-637-8995</a> <br/>ขอขอบพระคุณเป็นอย่างสูงสำหรับความไว้วางใจในการสั่งซื้อสินค้ากับทางเรา</p>
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