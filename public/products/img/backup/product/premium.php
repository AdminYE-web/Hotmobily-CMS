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
	<link rel="canonical" href="/products/premium.php" />
	<meta name="description" content="สายคล้องคอสกรีนด้วยชื่อ โลโก้ต่างๆ สกรีนแบบซิลคสกรีน พร้อมโลโก้เรซิ่นสกรีนแบบซับลิเมชั่น คล้องกับบัตรพนักงานในราคาถูกๆ" />
	<meta name="keywords" content="สายคล้องคอพนักงาน,โลโก้เรซิ่น,สกรีนชื่อ,สกรีนแบบซับลิเมชั่น,ราคาถูก,คล้องโยโย่,บัตรพนักงาน" />
	<title>รับผลิตสายคล้องคอแบบซิลค์สกรีนราคาถูก พร้อมโลโก้เรซิ่น</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">สายคล้องคอพนักงาน - แบบพรีเมียม</h1>
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
				<h2><?php lang("premium",$_SESSION["lang"]) ?></h2>
				<div class="slide_show">
					<div class="img-show">
					<img src="img/pm-1-b.jpg?v=1.01" id="prm-i1">
					<img src="img/pm-2-b.jpg?v=1.01" id="prm-i2" style="display: none;">
					<img src="img/pm-3-b.jpg?v=1.01" id="prm-i3" style="display: none;">
					<img src="img/pm-4-b.jpg?v=1.01" id="prm-i4" style="display: none;">
					</div>
					<div class="sub-show">
						<div class="i1"><a id="i1" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/pm-1-s.jpg?v=1.01"></a></div>
						<div class="i2"><a id="i2" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/pm-2-s.jpg?v=1.01"></a></div>
						<div class="i3"><a id="i3" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/pm-3-s.jpg?v=1.01"></a></div>
						<div class="i4"><a id="i4" href="javascript:void(0)" onclick="img_slide('prm',$(this).attr('id'));"><img src="img/pm-4-s.jpg?v=1.01"></a></div>
					</div><br/>
				<span class="red">*ติดต่อพนักงานขายขอรับตัวอย่างสายคล้องคอฟรี! <a href="/contact/" class="link2">ที่นี่</a></span>
				</div>

				<div class="txt-show">
					<span><?php lang("detail",$_SESSION["lang"]) ?></span>
					<table class="tbl-txt">
						<tr>
							<td class="td1">ชือสินค้า</td>
							<td class="td2">สายคล้องคอแบบพรีเมียม</td>
						</tr>
						<tr>
							<td class="td1">ขนาดเชือก</td>
							<td class="td2">10mm, 15mm</td>
						</tr>
						<tr>
							<td class="td1">สีเชือก</td>
							<td class="td2">Flag red<br><a class="link2" href="product_color.php">ดูเพิ่มเติม</a></td>
						</tr>
						<tr>
							<td class="td1">พาร์ทเชือกที่ใช้</td>
							<td class="td2">คลิปขาว, ตัวเลื่อนปรับระดับ(ลูกบอล) <a class="link2" href="parts.php">ดูเพิ่มเติม</a></td>
						</tr>
						<tr>
							<td class="td1">การจัดส่ง</td>
							<td class="td2"><a class="link2" href="#premium">คลิกที่นี่</a></td>
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
					<img src="img/mini-20pc.jpg"><br/>
				</td>
				<td>
					<img src="img/mini-3d.jpg"><br/>
				</td>
			</tr>
		  </table>
			<h3 class="blue">รายละเอียดเพิ่มเติม</h3>
			<p>สายคล้องคอพนักงานราคาถูก สายคล้องบัตรพนักงานคุณภาพดี สามารถออกแบบสกรีนชื่อบริษัท ชื่อโรงพยาบาล ฯลฯ ลงบนสายคล้องคอ สามารถเลือกสีของตัวสายคล้องคอได้ทั้งสีธรรมดาและสีย้อมพิเศษ ออกแบบได้ตามต้องการ นอกจากนี้ยังมีซองใส่บัตร (บัตร ID/นามบัตร) ให้เลือกตามความต้องการอีกด้วยยิ่งสั่งมากก็จะได้รับราคาถูกลงอีกด้วย</p>
			<h3 class="blue">แบบเชือก</h3>
			<p>การถักแบบ Tubeler  ขนาด 10 mm (สามารถเลือกการถักแบบ Flat ได้เช่นกัน แต่ผิวสัมผัสของการถักแบบ Tubeler จะเนียนเรียบกว่า ซึ่งการถักแบบ Tubeler และการถักแบบ Flat ราคาเท่ากัน)<br/>
			การถักแบบ Flat ขนาด 15 mm <br/>
			*ขึ้นอยู่กับคลิปและตัวยึดที่ใช้ หากเป็นขนาดพิเศษ เช่น เชือกขนาด 20 mm และ 25 mm ไม่สามารถเลือกได้</p>
			<h3 class="blue">วัสดุ</h3>
			<p>โพลีเอสเตอร์</p>
			<h3 class="blue">ความยาว</h3>
			<p>วัดจากคอลงมายาว 50 CM (เป็นความยาวมาตรฐาน สามารถกำหนดความยาวของสายคล้องคอตามความต้องการได้) สามารถใส่ชิ้นส่วนสำหรับปรับระดับความยาวได้ด้วย หากต้องการขนาดพิเศษ กรุณา<a href="/contact/" class="link2">ติดต่อเรา</a></p>
			<h3 class="blue">ความหนา</h3>
			<p>Tubeler：ประมาณ 1.6 mm<br/>
			Flat：ประมาณ 0.8 mm</p>
			<h3 class="blue" id="premium">สายคล้องคอพนักงานแบบพรีเมียม</h3>
			<div class="table_01">
				<div class="tb_00">
					<div class="tr_01">
						<div class="tb_01">ระยะเวลาการส่งมอบปกติ (สายพรีเมียม)</div>
						<div class="tb_02">ภายใน 11 วันทำการ</div>
					</div>
				</div>
			</div>
			<p>
			*กรณีที่สั่งผลิตสินค้าไม่เกิน 3,000 เส้น<br>
			*วันทำการจะไม่นับรวมวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์
			</p>
			<h3 class="blue">ตารางราคาสายคล้องคอพนักงานแบบพรีเมียม</h3>
			<p>สินค้าที่ท่านสั่งผลิตมีจำนวนมากนอกจากราคาถูกลงแล้ว ทางเราจะส่งสินค้าตัวอย่างให้ตรวจสอบก่อนผลิตจริงฟรี</p>
			<img src="img/premium_opt.jpg" class="img_center">
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
              <td><span class="red f_tbl" >3,720 บาท</span><br>186.00บาท/เส้น</td>
              <td><span class="red f_tbl" >4,580 บาท</span><br>152.67บาท/เส้น</td>
              <td><span class="red f_tbl" >6,300 บาท</span><br>126.00บาท/เส้น</td>
              <td><span class="red f_tbl" >8,900 บาท</span><br>89.00บาท/เส้น</td>
              <td><span class="red f_tbl" >15,800 บาท</span><br>79.00บาท/เส้น</td>
              <td><span class="red f_tbl" >21,500 บาท</span><br>71.67บาท/เส้น</td>
              <td><span class="red f_tbl" >28,500 บาท</span><br>57.00บาท/เส้น</td>
              <td><span class="red f_tbl" >42,000 บาท</span><br>42.00บาท/เส้น</td>
              <td><span class="red f_tbl" >82,000 บาท</span><br>41.00บาท/เส้น</td>
              <td><span class="red f_tbl" >122,000 บาท</span><br>40.67บาท/เส้น</td>
            </tr>
            <tr align="center" bgcolor="#ffffff">
              <td rowspan="1" colspan="2" bgcolor="#FFFF99">ขนาด<span class="red">15</span>mm.</td>
              <td><span class="red f_tbl" >4,060 บาท</span><br>203.00บาท/เส้น</td>
              <td><span class="red f_tbl" >5,090 บาท</span><br>169.67บาท/เส้น</td>
              <td><span class="red f_tbl" >7,150 บาท</span><br>143.00บาท/เส้น</td>
              <td><span class="red f_tbl" >10,300 บาท</span><br>103.00บาท/เส้น</td>
              <td><span class="red f_tbl" >18,600 บาท</span><br>93.00บาท/เส้น</td>
              <td><span class="red f_tbl" >25,400 บาท</span><br>84.67บาท/เส้น</td>
              <td><span class="red f_tbl" >33,500 บาท</span><br>67.00บาท/เส้น</td>
              <td><span class="red f_tbl" >51,000 บาท</span><br>51.00บาท/เส้น</td>
              <td><span class="red f_tbl" >100,000 บาท</span><br>50.00บาท/เส้น</td>
              <td><span class="red f_tbl" >149,000 บาท</span><br>49.67บาท/เส้น</td>
            </tr>
        </tbody></table>
    	</div>
        <div class="txt-price">
        	1) ราคานี้เป็นราคาของสายคล้องคอสกรีน 1 สีเท่านั้นหากต้องการสกรีนมากกว่า 1 สีกรุณา<a href="/contact/" class="link2">ติดต่อพนักงานขาย</a><br/>
			2) ราคานี้รวมค่าบรรจุใส่ถุง และค่าจัดส่งภายในประเทศต่อ 1 สถานที่<br/>
			3) ตัวอย่างสินค้า (ดีไซน์ตัวอย่าง) ผลิตได้หนึ่งเส้นต่อหนึ่งรายการสั่งซื้อเท่านั้น<br/>
			4) อาจมีค่าใช้จ่ายเพิ่มเติมสำหรับพาร์ทออฟชั่นเสริม<br/>
			5) ราคาสินค้าที่แสดงยังไม่รวมภาษีมูลค่าเพิ่ม<br/>
		</div>
		<div class="box">
				<img src="img/Premium-01.jpg?v=1.00">
		</div>
	<div class="box">
		<img src="img/cover sticker.jpg">
		<img src="img/PM_01.jpg">
		<img src="img/PM_02.jpg">
		<img src="img/PM_03_1.jpg">
		<img src="img/PM_03_2.jpg">
		<h3>วิดิโอสาธิตการใช้งาน</h3>
		<div style="text-align: center;">
			<video id="sampleMovie" width="700" height="auto" preload controls>
				<source src="img/clicp_prm.mp4" />
			</video>
		</div>
		<div style="clear: both;">&nbsp;</div>
		<img src="img/PM_03_3.jpg">
		<img src="img/PM_03_4.jpg">
		<img src="img/PM_03_5.jpg">
		<img src="img/PM_03_6.jpg">
		<h3>วิดิโอสาธิตการถอดคลิปเพื่อใส่บัตร</h3>
		<div style="text-align: center;">
			<video id="sampleMovie2" width="700" height="auto" preload controls>
				<source src="img/prm_card.mp4" />
			</video>
		</div>
		<div style="clear: both;">&nbsp;</div>
		<img src="img/PM_04_1.jpg">
		<img src="img/PM_04_2.jpg">
	</div>
		<h3 class="blue">ส่วนประกอบพิเศษสำหรับสายคล้องคอแบบพรีเมียม</h3>
		<div class="row-bs">
			<div class="col-sm-6 col-12">
				<h3>Safety part</h3>
				<img src="img/part_new/Safety-part.jpg"><br/>
				<p style="margin: 0;">วัสดุ: พลาสติก มีสีดำ, สีขาว (ขนาด 20 mm จะมีแค่สีดำ)<br/>
						ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm<br/>
						ชิ้นส่วนที่แข็งแรงนี้จะช่วยป้องกันให้สายคล้องคอหลุดออกจากคอยากขึ้น
						<a href="img/ins_sf.jpg" data-lightbox="img1" data-title="" class="link2" style="text-decoration:none;">จุดที่สามารถติดตั้ง Safety part ได้ </a>หรือคลิก<a href="img/MVI_0719.mp4" target="_blank" class="link2">ที่นี่</a> เพื่อดูวิดิโอสาธิตการใช้งาน</p>
			</div>
			<div class="col-sm-6 col-12">
				<h3>สายห้อยโทรศัพท์มือถือ</h3>
				<img src="img/part_new/mobile.jpg"><br/>
				<p style="margin: 0;">วัสดุ : พลาสติก (ยกเว้นส่วนที่เป็นห่วงและสายห้อยโทรศัพท์)<br/>
						ขนาดเชือกมาตรฐานที่ใส่ได้ : 10 mm, 15 mm, 20 mm และขนาดอื่นๆ<br/>
						ชิ้นส่วนสำหรับห้อยโทรศัพท์มือถือ หรืออุปกรณ์ต่างๆ สามารถแยกออกจากกันได้ มีให้เลือก 2สี คือ สีขาว และสีดำ</p>
				</div>
			</div>
		<h3 class="blue">โยโย่ติดซองใส่บัตร: โยโย่ขาวดำ</h3>
				<div style="text-align: center;">
					<video id="sampleMovie" width="400" height="360" preload controls>
					    <source src="img/yoyo.MOV" />
					</video>
				</div>
				<p>พาร์ทโยโย่หมาะสำหรับนำมาใช้กับบัตรพนักงาน หรือบัตร Security card นอกจากจะคล้องกับสายคล้องคอพนักงานได้แล้ว ยังสามารถนำมาติดกับกระเป๋าเสื้อได้อีกด้วย
				โยโย่หลากหลายสี ส่วนกลางของพาร์ทนั้นทำมาจากอีพ๊อกซี่ เรซิ่นสามารถสกีนโลโก้แบบซับลิเมชั่นลงไปได้ หรือจะไม่ใส่โลโก้ก็ได้เช่นกันและสามารถสั่งแยกจากเชือกก็สามารถทำได้ขั้นต่ำเพียง 20 ชิ้น <a href="javascript:void(0)" onclick="togg('yoyo')" class="link2">ดูข้อมูลเพิ่มเติม</a></p>
				<div id="div_yoyo" class="div_t">
				<h3 class="blue">ลักษณะ</h3>
				<p>สี: ขาว, ดำ<br/>ความยาวสาย: 60 CM</p>
				<img src="img/yoyo2.jpg" class="img_center">
				<h3 class="blue">วิธีใช้</h3>
				<p>ตะขอ : นำห่วงวงกลมที่คล้องสายคล้องคอมาติดกับตะขอด้านหลังของโยโย่<br/>
				ติดโดยตรง : ด้านบนของโยโย่จะมีช่องว่างที่สามารถคล้องเชือกได้โดยตรง</p>
				<img src="img/yoyo1.jpg" class="img_center">
				<h3 class="blue">ขนาดเส้นที่สามารถคล้องพาร์ทโยโย่ได้โดยตรง</h3>
				<p>15mm ,20mm</p>
				<h3 class="blue">ราคา</h3>
				<table class="tbl_prd" cellpadding="5" cellspacing="0">
	            <tr align="center" bgcolor="#E6E7E8">
	              <td>จำนวน</td>
	              <td>ราคาโยโย่รวมสายคล้องคอ</td>
	              <td>ราคาโยโย่ไม่รวมสาย</td>
	            </tr>
	            <tr align="center" bgcolor="#ffffff">
	              <td>50 ชิ้น</td>
	              <td>128 บาท</td>
	              <td>132 บาท</td>
	            </tr>
	            <tr align="center" bgcolor="#ffffff">
	              <td>100 ชิ้น</td>
	              <td>70 บาท</td>
	              <td>70 บาท</td>
	            </tr>
	            <tr align="center" bgcolor="#ffffff">
	              <td>300 ชิ้น</td>
	              <td>60 บาท</td>
	              <td>65 บาท</td>
	            </tr>
	            <tr align="center" bgcolor="#ffffff">
	              <td>500 ชิ้น</td>
	              <td>46 บาท</td>
	              <td>49 บาท</td>
	            </tr>
	            <tr align="center" bgcolor="#ffffff">
	              <td>1,000 ชิ้น</td>
	              <td>42 บาท</td>
	              <td>42 บาท</td>
	            </tr>
	            </table>
	            <div class="txt-price">
	        	1) ราคานี้เป็นราคาที่รวมกรีนโลโก้แบบซับลิเมชั่นแล้ว<br>
				2) ราคานี้ไม่รวมภาษีมูลค่าเพิ่ม(7%)<br>
				3) ราคาที่สั่งรวมกับสายคล้องคออาจจะมีค่าใช่จ่ายเพิ่มเติม </div>
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
			<img src="img/s_red1.jpg"><br/>สกรีนโลโก้คมชัดสามารถพิมพ์เครื่องหมายเล็กๆ เช่น ® หรือ TM ได้</div></div>
			<div class="col-sm-4 col-12">
				<div style="padding: 0 5px;">
			<img src="img/s_red2.jpg"><br/>สกรีนโดยการยิง</div></div>
			<div class="col-sm-4 col-12">
				<div style="padding: 0 5px;">
			<img src="img/s_red3.jpg"><br/>สกรีนแบบเรียบ</div></div>
		</div>
		<p><span class="red">ลายสกรีนโลโก้บริษัทหรือสกรีนชื่อต่างๆ คมชัด! ความหนากำลังดี สัมผัสลื่นไม่หยาบ</span><br/>
		การสกรีนชื่อบริษัทหรืองานกิจกรรมต่างๆ ของเราเป็นการสกรีนด้วยสีทับซ้ำหลายครั้ง ทำให้ลายสกรีนคมชัด สวยงาม สามารถสกรีนได้สูงสุดถึง 6 สีตามตำแหน่งที่ต้องการ ท่านสามารถดูผลงานที่ผ่านมาบางส่วนของเราได้ นอกจากนี้ วิธีการสกรีนทั้งหมดของเราเป็นแบบ Home position จึงสามารถกำหนดตำแหน่งโลโก้ ชื่อบริษัท และออกแบบจัดวางตามความต้องการได้ ทั้งนี้ โลโก้ที่สกรีนต่อเนื่องจะไม่สามารถกำหนดจุดสิ้นสุดได้ แต่ไม่ต้องกังวลว่าลายสกรีนจะทับกาวที่เป็นตัวยึด
		</p>
		<h3 class="blue">จุดเด่นที่ 2</h3>
		<p><span class="red">การสกรีนโลโก้บริษัทหรือโลโก้โรงพยาบาลแบบซับลิเมชั่นลงบนคลิปและตัวยึด</span><br/>
		เราขอแนะนำคลิปและตัวยึดที่เป็นผลิตภัณฑ์เฉพาะของบริษัทเราซึ่งสามารถยึดติดกับเชือกได้อย่างแน่นหนา ทั้งยังสามารถนำไปคล้องกับซองใส่บัตร ID นามบัตร บัตรพนักงาน ฯลฯ  นอกจากนี้ เรายังมีบริการพิเศษที่สามารถสกรีนโลโก้บริษัท โลโก้โรงพยาบาล หรือโลโก้ต่างๆ ออกแบบได้อย่างอิสระ ด้วยการสกรีนแบบซับลิเมชั่นลงบนคลิปและตัดยึด จากนั้นจะเคลือบด้วยอีพ็อกซี่ เรซิ่น ทำให้สีไม่ถลอกหรือหลุดลอกออกง่าย มีชิ้นส่วนสีขาวและสีดำให้เลือกได้ตามต้องการ
		</p>
		<h3 class="blue">จุดเด่นที่ 3</h3>
		<div class="row-bs" id="box-show2">

			<div class="col-sm-6 col-12" style="padding-bottom: 10px;">
				<div style="padding: 0 5px;">
			<img src="img/print_sample745_1.jpg" style="padding-bottom: 10px;"><br/>ภาพอ้างอิงการสกรีน 2 สี</div></div>
			<div class="col-sm-6 col-12" style="padding-bottom: 10px;">
				<div style="padding: 0 5px;">
			<img src="img/print_sample745_2.jpg" style="padding-bottom: 10px;"><br/>ภาพอ้างอิงการสกรีน 5 สี</div></div>
		</div>
		<p style="margin-top: 0px;"><span class="red">สุดพิเศษ! สามารถสกรีนสีเชือกแบบพิเศษได้มากสุดถึง 6 สี สกรีนได้ทั้งด้านหน้าและด้านหลัง หรือจะใส่สายคล้องคอแบบ 2 หัวก็ได้</span><br/>
		<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สกรีนสีโลโก้ด้วยสีย้อมพิเศษ (ตั้งแต่ 100 เส้นขึ้นไปต่อสี) ในราคาถูก<br/>
		<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สกรีนโลโก้บริษัท สกรีนชื่อ และตราสัญลักษณ์ได้สูงสุดถึง 6 สี และยังสามารถออกแบบดีไซน์กำหนดพื้นที่ที่ไม่ต้องการใส่สีได้ด้วย<br/>
		<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สามารถสกรีนโลโก้ได้ทั้ง 2 ด้าน ทั้งด้านหน้าและด้านหลังของสายคล้องคอ<br/>
		<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สามารถกำหนดขอเกี่ยวสำหรับสายคล้องบัตรต่างๆ ได้ ซึ่งเราผลิตสายคล้องคอแบบ 2 หัวด้วย<br/>
		<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> ความยาวของเชือกแบบมาตรฐาน หากพับครึ่งหรือคล้องคอจะมีความยาว 45 cm และ 60 cm หากต้องการสายคล้องคอขนาดพิเศษราคาถูก ทางเราก็มีบริการด้วยเช่นกัน
		</p>
		<h3 class="blue">ตารางแสดงสีเชือก</h3>
		<p>เรามีสีพื้นฐานให้เลือกทั้งหมด 20 สี ส่วนใหญ่นิยมสั่งซื้อโทนสีแดงและสีฟ้า ซึ่งทั้ง 2 สีมีโทนสีที่คล้ายกันคือ สีแดง (PANTONE485C) กับ Flag red และสีน้ำเงิน (PANTONE293C) กับ Reflex Blue และ Process Blue นอกจากนี้ยังมีสีส้มและสีดำที่เป็นที่นิยมเช่นกัน อีกทั้งยังมีสีใหม่เพิ่มเข้ามาอย่างสีชมพูและสีชมพูโบตั๋นด้วย (ข้อมูลเดือนพฤษภาคม ค.ศ. 2014)</p>
		<div class="box">
			<img src="img/Poly-color-banner.jpg?v=1.01"><br/>
		</div>
		<p>
			<span style='font-size:30px; vertical-align: bottom;'>&bull;</span> สามารถสั่งสีของสายคล้องคอได้ตั้งแต่ 2 สีขึ้นไปโดยต้องสั่งผลิตจำนวนขั้นต่ำ 100 เส้นขึ้นไปต่อสี(ไม่เกิน 5 สี)<br/>
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
