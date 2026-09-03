<?php
	session_start();
	require('lang.php');
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
	<?php require_once('head.php')?>
	<!--end-->
	<meta name="robots" content="index,follow" />
	<meta name="description" content="ผลิตและออกแบบสายคล้องคอพนักงาน สายคล้องบัตรไม่มีขั้นต่ำ 1 เส้นก็สามารถสั่งได้ สายคล้องคอขนาด 10,15,20mm. มีส่วนประกอบสายคล้องคอให้เลือกหลากหลาย ผลิตด้วยโรงงานสายคล้องคอของเราเอง สามารถการันตีคุณภาพได้ ราคาถูก" />
	<meta name="keywords" content="สายคล้องคอพนักงาน, ซองใส่บัตรพนักงาน, ราคาถูก, โยโย่, ซับลิเมชั่น, สายคล้องคอ, สายคล้องบัตร, ไม่มีขั้นต่ำ" />
	<title>ผลิตและจัดจำหน่ายสายคล้องคอราคาถูก | ไม่มีขั้นต่ำ จัดส่งฟรี | Hotstrapthai.com</title>
	<link rel="stylesheet" href="/css/slider.css">
	<link rel="stylesheet" href="/css/slideshow.css?v=1.02">
	<style type="text/css">
		.logo_box{
			display: flex;
		    margin: 10px 0px;
		    width: 100%;
		}
		.logo_box img{
			padding: 0 2px;
			border-left: black solid 1px;
			border-right: black solid 1px;
			max-width: 200px;
		}
	</style>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">บริษัทผลิตสายคล้องคอ โรงงานสายคล้องคอ สั่งได้ไม่มีขั้นต่ำ</h1>
			<p class="lang">
				<a href="<?=$escaped_url;?>?l=th">TH</a>|<a href="<?=$escaped_url;?>?l=en">EN</a>
			</p>
			<div class="line_api">
				<a href="http://line.me/ti/p/~youandearth.th" target="_blank"><img src="/images/line_btn.png"></a>
			</div>
		</div>
	</div>
	<!--header-->
	<?php require_once('header.php')?>
	<!--end-->
	<div class="home" id="container">
		<div class="container">
			<div class="slideshow-container">
				<div class="mySlides fade">
				  <a href="/products/nylon.php"><img src="/images/banner_slide-01-02.jpg?v=1.01" alt="สายคล้องคอพนักงานไม่มีขั้นต่ำการผลิต" title="สายคล้องคอพนักงานไม่มีขั้นต่ำการผลิต" style="width:100%"></a>
				</div>
				<div class="mySlides fade">
				  <a href="/products/standard.php"><img src="/images/3days_banner.jpg?v=1.08" alt="สายคล้องคองานด่วนผลิตภายใน 3 วัน" title="สายคล้องคองานด่วนผลิตภายใน 3 วัน" style="width:100%"></a>
				</div>
				<div class="mySlides fade">
				  <a href="/template/production.php"><img src="/images/qty_banner.jpg?v=1.06" alt="สายคล้องคอคุณภาพดีใช้งานได้นาน" title="สายคล้องคอคุณภาพดีใช้งานได้นาน" style="width:100%"></a>
				</div>
				<div class="mySlides fade">
				  <a href="/products/fullcolor.php"><img src="/images/color_banner.png?v=1.06" alt="สายคล้องบัตรราคาส่ง ยิ่งเยอะยิ่งถูก" title="สายคล้องบัตรราคาส่ง ยิ่งเยอะยิ่งถูก" style="width:100%"></a>
				</div>
				<div class="mySlides fade">
				  <a href="/products/reflector.php"><img src="/images/reflector_banner.jpg?v=1.01" alt="สายคล้องบัตรสะท้อนแสง แบบพิเศษ" title="สายคล้องบัตรสะท้อนแสง แบบพิเศษ" style="width:100%"></a>
				</div>
				<div class="mySlides fade">
				  <a href="/products/gohi.php"><img src="/images/pu_banner.jpg?v=1.01" alt="สายคล้องบัตรหนัง PU คุณภาพดี" title="สายคล้องบัตรหนัง PU คุณภาพดี" style="width:100%"></a>
				</div>
			</div>
			<div class="logo_box">
				<img src="/images/logo_slide-01-2.png?v=1.07" style="width:100%" class="dot" onclick="currentSlide(1)" alt="สายคล้องคอพนักงานไม่มีขั้นต่ำ">
				<img src="/images/3days_logo.png?v=1.08" style="width:100%" class="dot" onclick="currentSlide(2)" alt="สายคล้องคอพนักงานงานด่วน">
				<img src="/images/qty_logo.png?v=1.06" style="width:100%" class="dot" onclick="currentSlide(3)" alt="สายคล้องบัตรงานคุณภาพ">
				<img src="/images/color_logo.png?v=1.06" style="width:100%" class="dot" onclick="currentSlide(4)" alt="สายสกรีนสอดสี">
				<img src="/images/reflector_logo.png?v=1.08" style="width:100%" class="dot" onclick="currentSlide(5)" alt="สายสะท้อนแสง">
				<img src="/images/pu_logo.jpg?v=1.07" style="width:100%" class="dot" onclick="currentSlide(6)" alt="สายหนัง PU">
			</div>
			<div class="category"><h3>:: โปรโมชั่นประจำเดือน ::</h3></div>
			<div class="prd_shw">
				<div class="prd_l">
					<img src="/images/free_design.jpg" class="prd-img" alt="ออกแบบสายคล้องคอพนักงาน">
					<span class="prd-txt">รับออกแบบ ผลิตสายคล้องคอพนักงาน <span class="red">ออกแบบให้ฟรีไม่มีค่าใช้จ่าย</span>ศึกษารายละเอียดเพิ่มเติม<a href="/template/production.php" class="link2">ที่นี่</a></span>
				</div>
				<div class="prd_r">
					<img src="/images/free_sample.jpg?v=1.01" class="prd-img" alt="สายค้ลองคอพนักงานส่งฟรี">
					<span class="prd-txt">ฉลองเปิดเว็บไซต์ใหม่ <span class="red">แจกตัวอย่างสายคล้องคอให้คุณฟรี</span>กรอกข้อมูล <a href="/contact/" class="link2">ที่นี่</a>และรอรับสินค้าได้เลย</span>
				</div>
			</div>
			<div class="category"><h3><?php lang("hotitem",$_SESSION["lang"]) ?></h3></div>
			<div class="prd_shw">
				<div class="prd_l">
					<a href="/products/premium.php"><img src="/images/premium-home.jpg" class="prd-img" alt="สายคล้องคอพนักงานแบบพรีเมียม"></a>
					<span class="prd-txt">สายคล้องคอพนักงานแบบพรีเมียม สกรีนชื่อบริษัทโลโก้บริษัท สีที่ใช้ในการสกรีนมีทั้งสีธรรมดาและสีพิเศษ(PANTONE) นอกจากนี้ยังมีซองใส่บัตร(ID Card) ให้เลือกตามความต้องการ <a href="/products/premium.php" class="link-red">ดูข้อมูลเพิ่มเติม</a></span>
				</div>
				<div class="prd_r">
					<a href="/products/standard.php"><img src="/images/poly-home.jpg" class="prd-img" alt="สายคล้องคอพนักงานผ้าโพลีเอสเตอร์"></a>
					<span class="prd-txt">สายคล้องคอพนักงานผ้าโพลีเอสเตอร์ เป็นแบบที่นิยมสั่งผลิตเป็นอันดับหนึ่งมีขนาดตั้งแต่ 10, 15, 20มม. และสามารถผลิตแบบหรือขนาดพิเศษตามลูกค้าต้องการสามารถสกรีนชื่อบริษัทได้ <a href="/products/standard.php" class="link-red">ดูข้อมูลเพิ่มเติม</a></span>
				</div>
				<div class="prd_l">
					<a href="/products/nylon.php"><img src="/images/nylon-home.jpg" class="prd-img" alt="สายคล้องคอพนักงานผ้าไนลอน"></a>
					<span class="prd-txt">สายคล้องคอพนักงานผ้าไนลอน ราคาถูกและคุณภาพดี สามารถออกแบบได้ตามความต้องการสามารถกำหนัดสีของสายคล้องคอและสีสกรีนได้ไม่มีขั้นต่ำการผลิต 1 เส้นก็สั่งได้<a href="/products/nylon.php" class="link-red">ดูข้อมูลเพิ่มเติม</a></span>
				</div>
				<div class="prd_r">
					<a href="/products/fullcolor.php"><img src="/images/fullcolor-home.jpg" class="prd-img" alt="สายคล้องคอสกรีนแบบซับลิเมชั่น"></a>
					<span class="prd-txt">สายคล้องคอสกรีนแบบซับลิเมชั่น สามารถสกรีนได้จากภาพถ่ายที่มีความคมชัดตั้งแต่ 300 ppi ขึ้นไปหรือดีไซน์ที่มีสีสันฉูดฉาดได้ และยังสามารถสกรีนจำนวนสีและโลโก้ลงบนสายคล้องคอได้อย่างไม่จำกัด <a href="/products/fullcolor.php" class="link-red">ดูข้อมูลเพิ่มเติม</a></span>
				</div>
				<div class="prd_l">
					<a href="/products/gohi.php"><img src="/images/pu-home.jpg" class="prd-img" alt="สายคล้องบัตรหนัง pu"></a>
					<span class="prd-txt">สายคล้องบัตรหนัง PU สายคล้องบัตรคุณภาพที่การรันตีความสวยงามของสาย อัพเกรดระดับความน่าเชื่อถือให้องค์กรของคุณ ตัวสายทำจากหนังเทียม วัสดุคุณภาพสูง เนื้อสัมผัสคล้ายหนังแท้ทนทาน<a href="/products/gohi.php" class="link-red">ดูข้อมูลเพิ่มเติม</a></span>
				</div>
				<div class="prd_r">
					<a href="/products/reflector.php"><img src="/images/reflector-home.jpg" class="prd-img" alt="สายคล้องบัตรสะท้อนแสง"></a>
					<span class="prd-txt">สายคล้องบัตรสะท้อนแสง สายแบบพิเศษที่เพิ่มความปลอดภัยสำหรับหน่วยงานที่ต้องทำงานในเวลากลางคืนหรือบริเวณที่มีการสัญจรของรถยนต์ โดยสายจะช่วยสะท้อนแสงเพื่อช่วยผู้สวมใส่สามารถเดินทางได้อย่างปลอดภัย<a href="/products/reflector.php" class="link-red">ดูข้อมูลเพิ่มเติม</a></span>
				</div>
				<div class="prd_l">
					<a href="/products/carabiner.php"><img src="/images/carabiner-home.jpg" class="prd-img" alt="คาราบิเนอร์"></a>
					<span class="prd-txt">คาราบิเนอร์ ตะขอเกี่ยวอเนกประสงค์ สามารถเกี่ยวกับเชือก หรืออุปกรณ์ต่างๆ เช่น พวงกุญแจ เป็นต้น ทั้งนี้สามารถออกแบบโลโก้หรือ สกรีนชื่อบริษัท หรือชื่อต่างๆได้ ซึ่งมีให้เลือกหลายสี และการสกรีน2แบบ <a href="/products/carabiner.php" class="link-red">ดูข้อมูลเพิ่มเติม</a></span>
				</div>
			</div>
			<div class="btn-ctu">
				<a href="/contact/" class="btn-s1"><?php lang("sale",$_SESSION["lang"]) ?></a>
				<a href="/orders/" class="btn-s1"><?php lang("order",$_SESSION["lang"]) ?></a>
			</div>
			<div style="clear: both;">&nbsp;</div>
			<div class="slideFrame" id="slide">
	        <ul class="slideGuide">
	          <li class="slideCell">
	            <a href="slide/1-2.jpg" data-lightbox="img1" data-title="" style="text-decoration:none;">
	              <img src="slide/1.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/2-2.jpg" data-lightbox="img1" data-title="" style="text-decoration:none;">
	              <img src="slide/2.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/3-2.jpg" data-lightbox="img2" data-title="" style="text-decoration:none;">
	              <img src="slide/3.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/4-2.jpg" data-lightbox="img2" data-title="" style="text-decoration:none;">
	              <img src="slide/4.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/5-2.jpg" data-lightbox="img3" data-title="" style="text-decoration:none;">
	              <img src="slide/5.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/6-2.jpg" data-lightbox="img3" data-title="" style="text-decoration:none;">
	              <img src="slide/6.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/7-2.jpg" data-lightbox="img4" data-title="" style="text-decoration:none;">
	              <img src="slide/7.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/8-2.jpg" data-lightbox="img4" data-title="" style="text-decoration:none;">
	              <img src="slide/8.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/9-2.jpg" data-lightbox="img5" data-title="" style="text-decoration:none;">
	              <img src="slide/9.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/10-2.jpg" data-lightbox="img6" data-title="" style="text-decoration:none;">
	              <img src="slide/10.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/11-2.jpg" data-lightbox="img6" data-title="" style="text-decoration:none;">
	              <img src="slide/11.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/12-2.jpg" data-lightbox="img7" data-title="" style="text-decoration:none;">
	              <img src="slide/12.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/13-2.jpg" data-lightbox="img7" data-title="" style="text-decoration:none;">
	              <img src="slide/13.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/14-2.jpg" data-lightbox="img8" data-title="" style="text-decoration:none;">
	              <img src="slide/14.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/15-2.jpg" data-lightbox="img8" data-title="" style="text-decoration:none;">
	              <img src="slide/15.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/16-2.jpg" data-lightbox="img9" data-title="" style="text-decoration:none;">
	              <img src="slide/16.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/17-2.jpg" data-lightbox="img9" data-title="" style="text-decoration:none;">
	              <img src="slide/17.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/18-2.jpg" data-lightbox="img10" data-title="" style="text-decoration:none;">
	              <img src="slide/18.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/19-2.jpg" data-lightbox="img10" data-title="" style="text-decoration:none;">
	              <img src="slide/19.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/20-2.jpg" data-lightbox="img11" data-title="" style="text-decoration:none;">
	              <img src="slide/20.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/21-2.jpg" data-lightbox="img11" data-title="" style="text-decoration:none;">
	              <img src="slide/21.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/22-2.jpg" data-lightbox="img12" data-title="" style="text-decoration:none;">
	              <img src="slide/22.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/23-2.jpg" data-lightbox="img12" data-title="" style="text-decoration:none;">
	              <img src="slide/23.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/24-2.jpg" data-lightbox="img13" data-title="" style="text-decoration:none;">
	              <img src="slide/24.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/25-2.jpg" data-lightbox="img13" data-title="" style="text-decoration:none;">
	              <img src="slide/25.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/26-2.jpg" data-lightbox="img14" data-title="" style="text-decoration:none;">
	              <img src="slide/26.jpg" alt="">
	            </a>
	          </li>
	          <li class="slideCell">
	            <a href="slide/27-2.jpg" data-lightbox="img14" data-title="" style="text-decoration:none;">
	              <img src="slide/27.jpg" alt="">
	            </a>
	          </li>
	        </ul>
	        <div class="slideCtrl left">&lt;</div>
	        <div class="slideCtrl right">&gt;</div>
	      </div>
			<div class="category"><h3><?php lang("customer",$_SESSION["lang"]) ?></h3></div>
			<div class="customer">
				<ul>
					<li><a href="images/client-01-b.jpg" data-lightbox="cus-01"><img src="/images/client-01.jpg"></a></li>
					<li><a href="images/client-02-b.jpg" data-lightbox="cus-02"><img src="/images/client-02.jpg"></a></li>
					<li><a href="images/client-03-b.jpg" data-lightbox="cus-03"><img src="/images/client-03.jpg"></a></li>
					<li><a href="images/client-04-b.jpg" data-lightbox="cus-04"><img src="/images/client-04.jpg"></a></li>
					<li><a href="images/client-13-b.jpg" data-lightbox="cus-13"><img src="/images/client-13.jpg"></a></li>
					<li><a href="images/client-06-b.jpg" data-lightbox="cus-06"><img src="/images/client-06.jpg"></a></li>
				</ul>
			</div>
			<div style="clear: both;">&nbsp;</div>
			<div class="customer">
				<ul>
					<li><a href="images/client-07-b.jpg" data-lightbox="cus-07"><img src="/images/client-07.jpg"></a></li>
					<li><a href="images/client-08-b.jpg" data-lightbox="cus-08"><img src="/images/client-08.jpg"></a></li>
					<li><a href="images/client-09-b.jpg" data-lightbox="cus-09"><img src="/images/client-09.jpg"></a></li>
					<li><a href="images/client-10-b.jpg" data-lightbox="cus-10"><img src="/images/client-10.jpg"></a></li>
					<li><a href="images/client-11-b.jpg" data-lightbox="cus-11"><img src="/images/client-11.jpg"></a></li>
					<li><a href="images/client-12-b.jpg" data-lightbox="cus-12"><img src="/images/client-12.jpg"></a></li>
				</ul>
			</div>
			<div style="clear: both;">&nbsp;</div>
			<div class="customer">
				<ul>
					<li><a href="images/client-17-b.jpg?v=1.01" data-lightbox="cus-17"><img src="/images/client-17.jpg"></a></li>
					<li><a href="images/client-18-b.jpg?v=1.01" data-lightbox="cus-18"><img src="/images/client-18.jpg"></a></li>
					<li><a href="images/client-19-b.jpg?v=1.01" data-lightbox="cus-19"><img src="/images/client-19.jpg"></a></li>
					<li><a href="images/client-20-b.jpg?v=1.01" data-lightbox="cus-20"><img src="/images/client-20.jpg"></a></li>
					<li><a href="images/client-21-b.jpg?v=1.01" data-lightbox="cus-21"><img src="/images/client-21.jpg"></a></li>
					<li><a href="images/client-23-b.jpg?v=1.01" data-lightbox="cus-23"><img src="/images/client-23.jpg"></a></li>
				</ul>
			</div>
			<div style="clear: both;">&nbsp;</div>
			<div id="box-show">
				<span class="red">คลิกที่โลโก้เพื่อดูสายคล้องคอตัวอย่าง</span>
			</div>
			<div class="btn-ctu">
				<a href="/gallery/" class="btn-s1">แกลอรี่สายคล้องคอ</a>
				<a href="/contact/" class="btn-s1"><?php lang("sale",$_SESSION["lang"]) ?></a>
			</div>
		</div>

	</div>
	<!--footer-->
	<?php require_once('footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>
	<script type="text/javascript">
		$(function(){
			$("#slide").slider({
				time: 40,
				speed: 3
			});
		});
		var slideIndex = 1;
		showSlides(slideIndex);

		// Thumbnail image controls
		function currentSlide(n) {
		  showSlides(slideIndex = n,"stop");
		}

		function showSlides(n,bool) {
		  var i;
		  var slides = document.getElementsByClassName("mySlides");
		  var dots = document.getElementsByClassName("dot");
		  n = slideIndex;
		  if (n > slides.length) {slideIndex = 1}
		  if (n < 1) {slideIndex = slides.length}
		  for (i = 0; i < slides.length; i++) {
		      slides[i].style.display = "none";
		  }
		  // slides[slideIndex-1].style.display = "block";
		  // dots[slideIndex-1].className += " active";
		  slides[slideIndex-1].style.display = "block";
		  slideIndex++;
		  if(!bool){
			setTimeout(showSlides, 15000); // Change image every 2 seconds
		  }
		}
	</script>
</body>
</html>
