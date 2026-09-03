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

	if((isset($_SESSION['customer_data']['status'])&&$_SESSION['customer_data']['status']==0)
		||(!isset($_GET['type']))){
		unset($_SESSION['customer_data']);
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
	<link rel="canonical" href="/contact/index.php" />
	<meta name="description" content="บริษัท ยูแอนด์ เอิร์ธ ซิสเท็ม จำกัด จัดจำหน่ายสายคล้องคอพนักงานมายาวนานกว่า 10 ปี สั่งซื้อขั้นต่ำเพียง 50 เส้น ได้รับชิ้นงานรวดเร็วในราคาประหยัดและสามารถสั่งสายคล้องคอที่มีขนาดหรือแบบพิเศษได้อีกด้วย" />
	<meta name="keywords" content="ติดต่อเรา, แบบฟอร์มคำถาม, วิธีสั่งซื้อ, กรุงเทพ, สายคล้องคอ, สายคล้องคอพนักงาน, สายคล้องบัตร, ส่งฟรี, ไซส์พิเศษ, แบบพิเศษ" />
	<title>ออกแบบ สั่งทำสายคล้องคอพนักงาน</title>
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel">ติดต่อสอบถาม สายคล้องคอพนักงาน สายคล้องบัตร</h1>
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
			<h2><?php lang("contact",$_SESSION["lang"]) ?></h2>	
			<div id="box-show">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d968.9977899884705!2d100.51953393083207!3d13.718984900741267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29f25acbbe43b%3A0xd51668055a27010b!2syou+and+earth+system+co.%2Cltd.!5e0!3m2!1sth!2sth!4v1536115057902" width="820" height="450" frameborder="0" style="border:0" allowfullscreen class="map"></iframe>
			</div>		
			<div style="clear: both;">&nbsp;</div>
			<span>ที่อยู่ : 152 อาคารชาร์เตอร์ สแควร์ ถนนสาทรเหนือ แขวงสีลม เขตบางรัก กทม 10500 <br>
				โทรศัพท์ : 02-637-8995,02-266-5929(บัญชี) </span><br>
				<span class="blue">เวลาทำการ : จันทร์-ศุกร์ เวลา 08:30-17:30น.</span><br>
				<span class="green">Line id: youandearth.th</span>
			<div style="clear: both;">&nbsp;</div>
			<h2><?php lang("inquiry",$_SESSION["lang"]) ?></h2>
			<form action="confirm.php" method="post" name="form" id="cont">
				<?php
				$prd = "";$sale = "";$oth="";$urg="";
				if(isset($_SESSION["customer_data"]['subject'])){
					$tmp = $_SESSION["customer_data"]['subject'];
					switch ($tmp) {
						case 'product':$_SESSION["customer_data"]['other']="";$prd="checked";break;
						case 'sale_request':$_SESSION["customer_data"]['other']="";$sale="checked";break;
						case 'other':$oth="checked";break;
					}
				}
				if(isset($_SESSION["customer_data"]['urgent'])&&$_SESSION["customer_data"]['urgent']=='1'){
					$urg="checked";
				}
				?>
				<table class="tbl-txt tbl-cont">
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("subject",$_SESSION["lang"]) ?></td>
						<td class="td4">
							<label class="label-radio">
								<?php lang("about_prd",$_SESSION["lang"]) ?>
								<input type="radio" name="subject" value="product" required <?=$prd?>>
								<span class="checkmark"></span>
							</label><br/>
							<label class="label-radio">
								<?php lang("sale_request",$_SESSION["lang"]) ?>
								<input type="radio" name="subject" value="sale_request" <?=$sale?>>
								<span class="checkmark"></span>
							</label><br/>
							<label class="label-radio">
								<?php lang("others",$_SESSION["lang"]) ?>
								<input type="radio" name="subject" value="other" <?=$oth?>>
								<span class="checkmark"></span>
							</label>
							<input type="text" name="other" value="<?=(isset($_SESSION["customer_data"]['other']))?$_SESSION["customer_data"]['other']:"";?>" placeholder="<?php lang("typing",$_SESSION["lang"]) ?>"><br/>
							<label class="label-radio">
								<?php lang("urgent",$_SESSION["lang"]) ?>
								<input type="checkbox" name="urgent" value="1" <?=$urg?>>
								<span class="checkmark"></span>
							</label>
						</td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("name",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="name" value="<?=(isset($_SESSION["customer_data"]['name']))?$_SESSION["customer_data"]['name']:"";?>" placeholder="<?php lang("name",$_SESSION["lang"]) ?>" required><br/></td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("company",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="company" value="<?=(isset($_SESSION["customer_data"]['company']))?$_SESSION["customer_data"]['company']:"";?>" placeholder="<?php lang("company",$_SESSION["lang"]) ?>" required><br/></td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("email",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="email" name="email" value="<?=(isset($_SESSION["customer_data"]['email']))?$_SESSION["customer_data"]['email']:"";?>" placeholder="<?php lang("email",$_SESSION["lang"]) ?>" required><br/></td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("phone",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="phone" value="<?=(isset($_SESSION["customer_data"]['phone']))?$_SESSION["customer_data"]['phone']:"";?>" placeholder="<?php lang("phone",$_SESSION["lang"]) ?>" required><br/></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("fax",$_SESSION["lang"]) ?></td>
						<td class="td4"><input type="text" name="fax" value="<?=(isset($_SESSION["customer_data"]['fax']))?$_SESSION["customer_data"]['fax']:"";?>" placeholder="<?php lang("fax",$_SESSION["lang"]) ?>"><br/></td>
					</tr>
					<tr>
						<td class="td3">แนบไฟล์(ขนาดไม่เกิน 2 mb.)<br/><span class="red">(เลือกไฟล์และกดปุ่ม upload)</span></td>
						<td class="td4">
							<input type="file" name="file[]">&nbsp;<input type="button" id="submit-btn" value="upload" onclick="upload();"><br/>
							<span id="result">
					            <?php if(!empty($_SESSION["customer_data"]['tmpfile_cont'])||!empty($_SESSION['filename_cont'])){
					                foreach($_SESSION["customer_data"]['tmpfile_cont'] as $key => $value) {
					                    echo $value." <input type='button' value='ลบ' onclick='remove(".$key.")'><br/>";
					                }}?>
					        </span>
						</td>
					</tr>
					<tr>
						<td class="td3"><span class="red">*</span><?php lang("message",$_SESSION["lang"]) ?><span class="green">(หากต้องการใบเสนอราคากรุณาระบุขนาด, สีและแบบตัวล็อคที่ต้องการขอบคุณครับ)</span></td>
						<td class="td4"><textarea name="message" id="txt-area" required><?=(isset($_SESSION["customer_data"]['message']))?$_SESSION["customer_data"]['message']:"";?></textarea></td>
					</tr>
					<tr>
						<td class="td_full" colspan="2">
							<?=$error?>
							<input type="submit" name="submit" id="submit" value="next" class="button btn1">
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

	<script type="text/javascript" src="js/js.js"></script>
	<script type="text/javascript">
		// var tmp = "<?php if(isset($_SESSION["customer_data"]['subject'])){ echo $_SESSION["customer_data"]['subject']; }?>";
		// if(tmp==""){
		// $(function(){
		// 	$('#modal').click();
		// })}
	</script>

</body>
</html>
