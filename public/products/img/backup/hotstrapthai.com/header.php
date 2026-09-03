<header>
	<div class="container">
		<div class="img-logo">
			<a href="<?=$url?>"><img src="/images/logo-thai2.jpg" alt="จำหน่ายสายคล้องคอพนักงาน"></a>
		</div>
		<div class="gnavi-menu">
			<nav>
			  <ul id='menu'>
			    <li><a id="mm_home" href="<?=$url?>"><?php lang("home",$_SESSION["lang"]) ?></a></li>
			    <li class="prd-d"><a id="mm_prd" href="/products/index.php"><?php lang("product",$_SESSION["lang"]) ?></a>
			    	<div class="prd-content">
				      <a href="/products/premium.php"><?php lang("premium",$_SESSION["lang"]) ?></a>
				      <a href="/products/standard.php"><?php lang("poly",$_SESSION["lang"]) ?></a>
				      <a href="/products/nylon.php"><?php lang("nylon",$_SESSION["lang"]) ?></a>
				      <a href="/products/fullcolor.php"><?php lang("fullcolor",$_SESSION["lang"]) ?></a>
				      <a href="/products/reflector.php">สายคล้องบัตรสะท้อนแสง</a>
				      <a href="/products/gohi.php">สายคล้องบัตรหนัง PU</a>
				      <a href="/products/carabiner.php"><?php lang("carabiner",$_SESSION["lang"]) ?></a>
				    </div>
			    </li>
			    <li class="prd-d2"><a href="javascript:void(0)">รายละเอียดสายเพิ่มเติม</a>
			    	<div class="prd-content2">
			    	  <a href="/products/case_cards.php">ซองใสใส่บัตรพนักงาน</a>
				      <a href="/products/parts.php">พาร์ทสายคล้องคอ</a>
				      <a href="/products/cloth.php">ลักษณะผ้าสายคล้องคอ</a>
				      <a href="/products/yoyo.php">โยโย่ติดซองใส่บัตร</a>
				      <a href="/products/product_color.php">สีเชือก</a>
				      <a href="/products/product_detail.php">รายละเอียดการจัดส่ง</a>
				      <a href="/gallery/">แกลอรี่ลูกค้าของเรา</a>
				    </div>
				</li>
			    <li><a id="mm_ord" href="/orders/"><?php lang("orders",$_SESSION["lang"]) ?></a></li>
			    <li><a id="mm_abt" href="/guide/">ขั้นตอนการสั่งซื้อ</a></li>
			    <li><a id="mm_ctu" href="/contact/"><?php lang("contact",$_SESSION["lang"]) ?></a></li>
			  </ul>
			</nav>
		</div>
	</div>
</header>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v3.3"></script>
