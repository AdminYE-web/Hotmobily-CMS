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

	if(!isset($_GET['c'])){
		$error = '<span class="red">กรุณากรอกทุกช่องที่มีเครื่องหมาย *</span>';
	}else{
		$error = "";
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:p="http://www.evolus.vn/Namespace/Pencil" xmlns:html="http://www.w3.org/1999/xhtml">
<head>
	<!--head-->
	<?php require_once('../head.php')?>
	<!--end-->
	<meta name="robots" content="index,follow" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<title>สายคล้องคอพนักงาน</title>
	<?php
		$t1_i="display:none;";$t2_i="display:none;";$t3_i="display:none;";$t4_i="display:none;";$t5_i="display:none;";
		$t1_o="";$t2_o="";$t3_o="";$t4_o="";$t5_o="";
		if(isset($_SESSION["cus_orders_data2"]['packing'])){
		switch ($_SESSION["cus_orders_data2"]['packing']) {
			case 'type1':$t1_o="selected";$t1_i="";break;
			case 'type2':$t2_o="selected";$t2_i="";break;
			case 'type3':$t3_o="selected";$t3_i="";break;
			case 'type4':$t4_o="selected";$t4_i="";break;
			case 'type5':$t5_o="selected";$t5_i="";break;					
		}
		}else{
			$t1_i="";$t1_o="selected";
		}
	?>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel"><?php lang("wellcome",$_SESSION["lang"]) ?></h1>
			<p class="lang">
				<a href="<?=$escaped_url;?>?l=th">TH</a>|<a href="<?=$escaped_url;?>?l=en">EN</a>
			</p>
		</div>
	</div>
	<!--header-->
	<?php require_once('../header.php')?>
	<!--end-->
	<div id="container">
		<div class="container">
			<h2>กรุณากรอกข้อมูลยืนยันการเพื่อการสั่งซื้อ</h2>
			<form action="customer_details.php?c=next" method="post" name="form" id="ord">
				<table class="tbl-txt tbl-cont">
					<tr>
						<td class="td3"><span class="red">*</span>โปรดเลือกวิธีแพ็คสายคล้องคอ</td>
						<td class="td4">
							<table class="">
							<tr><td class="tb-50">
							<select name="packing" style="width:100%">
								<option value="type1" <?=$t1_o?>>สายคล้องคอใส่ซองละ 1 เส้น::ซองใส่บัตรพนักงาน 50 ชิ้น(แนะนำ)</option>
								<option value="type2" <?=$t2_o?>>สายคล้องคอใส่ซองละ 25 เส้น::ซองใส่บัตรพนักงาน 50 ชิ้น(แนะนำ)</option>
								<option value="type3" <?=$t3_o?>>รวมสายคล้องคอและซองใส่บัตรพนักงานแบบประกอบเรียบร้อย แยกแพ็ค</option>
								<option value="type4" <?=$t4_o?>>รวมสายคล้องคอและซองใส่บัตรพนักงานแบบยังไม่ได้ประกอบ
								แยกแพ็ค</option>
								<option value="type5" <?=$t5_o?>>รวมสายคล้องคอและซองใส่บัตรแบบประกอบแล้วใส่แพ็คละ 25 ชิ้น</option>
							</select></td>
							<td class="tb-50">
							<img src="img/pack_3.jpg" id="type1" style="<?=$t1_i?>">
							<img src="img/pack_5.jpg" id="type2" style="<?=$t2_i?>">
							<img src="img/pack_1.jpg" id="type3" style="<?=$t3_i?>">
							<img src="img/pack_2.jpg" id="type4" style="<?=$t4_i?>">
							<img src="img/pack_4.jpg" id="type5" style="<?=$t5_i?>">
							</td></tr></table>
						</td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("name",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="name" value="<?=(isset($_SESSION["cus_orders_data2"]['name']))?$_SESSION["cus_orders_data2"]['name']:"";?>" placeholder="<?php lang("name",$_SESSION["lang"]) ?>" required></td>
					</tr>
					<?php 
						$cus_com = "checked";
						$cus_per = "checked";
						if(isset($_SESSION["cus_orders_data2"]['cus_type'])){
							switch ($_SESSION["cus_orders_data2"]['cus_type']) {
								case 'company':$cus_per = "";break;
								case 'personal':$cus_com = "";break;
							}
						}else{
							$cus_per = "";
						}
					?>
					<tr>
						<td class="td3"><span class="red">*</span>ประเภทลูกค้า</td>
						<td class="td4">
							<label class="label-radio" style="margin-bottom: 0">
								บริษัท								
								<input type="radio" name="cus_type" value="company" <?=$cus_com?>>
								<span class="checkmark"></span>
							</label>
							<label class="label-radio" style="margin-bottom: 0">
								บุคคลทั่วไป								
								<input type="radio" name="cus_type" value="personal" <?=$cus_per?>>
								<span class="checkmark"></span>
							</label>
						</td>
					</tr>
					<tr>
						<td class="td3"><?php lang("company",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="company" value="<?=(isset($_SESSION["cus_orders_data2"]['company']))?$_SESSION["cus_orders_data2"]['company']:"";?>" placeholder="<?php lang("company",$_SESSION["lang"]) ?>"></td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("email",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="email" value="<?=(isset($_SESSION["cus_orders_data2"]['email']))?$_SESSION["cus_orders_data2"]['email']:"";?>" placeholder="<?php lang("email",$_SESSION["lang"]) ?>" required></td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("phone",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="phone" value="<?=(isset($_SESSION["cus_orders_data2"]['phone']))?$_SESSION["cus_orders_data2"]['phone']:"";?>" placeholder="<?php lang("phone",$_SESSION["lang"]) ?>" required></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("fax",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="fax" value="<?=(isset($_SESSION["cus_orders_data2"]['fax']))?$_SESSION["cus_orders_data2"]['fax']:"";?>" placeholder="<?php lang("fax",$_SESSION["lang"]) ?>"></td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span>ที่อยู่</td>
						<td class="td4">
							<textarea name="address" id="txt-area" required=""><?=(isset($_SESSION["cus_orders_data2"]['address']))?$_SESSION["cus_orders_data2"]['address']:"";?></textarea>
						</td>
					</tr>
					<tr>
						<td class="td3">ไฟล์ตัวอย่าง(ขนาดไม่เกิน 2 mb.)<br/><span class="red">(เลือกไฟล์และกดปุ่ม upload)</span></td>
						<td class="td4">
							<input type="file" name="file[]">&nbsp;<input type="button" id="submit-btn" value="upload" onclick="upload();"><br/>
							<span id="result">
					            <?php if(!empty($_SESSION["cus_orders_data2"]['tmpfile_con'])||!empty($_SESSION["cus_orders_data2"]['filename_con'])){
					                foreach($_SESSION["cus_orders_data2"]['tmpfile_con'] as $key => $value) {
					                    echo $value." <input type='button' value='ลบ' onclick='remove(".$key.")'><br/>";
					                }}?>
					        </span>
						</td>
					</tr>
					<tr>
						<td class="td3">ฟ้อนต์ตัวอย่าง</td>
						<td class="td4"><input type="text" name="font" value="<?=(isset($_SESSION["cus_orders_data2"]['font']))?$_SESSION["cus_orders_data2"]['font']:"";?>" placeholder=""></td>
					</tr>
					<tr>
						<td class="td3">หมายเหตุ</td>
						<td class="td4"><input type="text" name="other_i" value="<?=(isset($_SESSION["cus_orders_data2"]['other_i']))?$_SESSION["cus_orders_data2"]['other_i']:"";?>" placeholder=""></td>
					</tr>
					<tr>
						<td class="td_full" colspan="2">
							<input type="button" id="back" value="back" class="button btn2" onclick="pcd();">
							<?=$error?>
							<input type="submit" id="submit" value="next" class="button btn1">
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>

	<!-- Include js here -->
	<script type="text/javascript" src="js/js.js"></script>
</body>
</html>