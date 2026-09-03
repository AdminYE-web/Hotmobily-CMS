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

	if (isset($_POST['subject'])&&
	isset($_POST['name'])&&
	isset($_POST['company'])&&
	isset($_POST['email'])&&
	isset($_POST['phone'])&&
	isset($_POST['message'])) {
		if(!isset($_SESSION['contact_no'])){
			$_SESSION['customer_data']['contact_no'] = "cont_".date('Ymd_His')."".rand('100','1000');
			$id = $_SESSION['customer_data']['contact_no'];
		}else{
			$id = $_SESSION['customer_data']['contact_no'];
		}
		$_SESSION['customer_data']['subject'] = $_POST['subject'];
		$_SESSION['customer_data']['name'] = htmlspecialchars($_POST['name']);
		$_SESSION['customer_data']['company'] = htmlspecialchars($_POST['company']);
		$_SESSION['customer_data']['email'] = htmlspecialchars($_POST['email']);
		$_SESSION['customer_data']['phone'] = htmlspecialchars($_POST['phone']);
		$_SESSION['customer_data']['message'] = htmlspecialchars($_POST['message']);
		$_SESSION['customer_data']['other'] = htmlspecialchars($_POST['other']);
		$_SESSION['customer_data']['fax'] = htmlspecialchars($_POST['fax']);
		$_SESSION['customer_data']['status'] = 1;
		(isset($_POST['urgent']))?$_SESSION['customer_data']['urgent'] = $_POST['urgent']:$_SESSION['customer_data']['urgent']=	"0";	
	}else{
		$_SESSION['customer_data']['status'] = 0;
		header("Location: //".$url."/contact/index.php");
		exit();
	}
	//status 0 = ข้อมูลที่ส่งมาไม่ครบถ้วน;
	//status 1 = user ย้อนกลับไปแก้ไขข้อมูล;
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:p="http://www.evolus.vn/Namespace/Pencil" xmlns:html="http://www.w3.org/1999/xhtml">
<head>
	<!--head-->
	<?php require_once('../head.php')?>
	<!--end-->
	<title>สายคล้องคอพนักงาน</title>
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
			<h2><?php lang("contact",$_SESSION["lang"]) ?></h2><br/>
			<?php
				$tmp = $_SESSION["customer_data"]['subject'];
			?>
			<table class="tbl-txt tbl-cont">
					<tr>
						<td class="td3"><?php lang("contact_id",$_SESSION["lang"]) ?></td>
						<td class="td4"><p><?=$_SESSION['customer_data']['contact_no']?></p></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("subject",$_SESSION["lang"]) ?></td>
						<td class="td4"><p>
							<?php switch ($tmp) {
									case 'product':lang('about_prd',$_SESSION["lang"]);break;
									case 'sale_request':lang('sale_request',$_SESSION["lang"]);break;
									case 'other':lang('others',$_SESSION["lang"]);echo ": ".$_SESSION['customer_data']['other'];break;
								  }
								  if($_SESSION['customer_data']['urgent']==='1'){
								  	echo "<span class='red'>*";
								  	lang('urgent',$_SESSION["lang"]);
								  	echo "</span>";
								  }
							?></p></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("name",$_SESSION["lang"]) ?></td>
						<td class="td4"><p><?=$_SESSION['customer_data']['name']?></p></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("company",$_SESSION["lang"]) ?></td>
						<td class="td4"><p><?=$_SESSION['customer_data']['company']?></p></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("email",$_SESSION["lang"]) ?></td>
						<td class="td4"><p><?=$_SESSION['customer_data']['email']?></p></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("phone",$_SESSION["lang"]) ?></td>
						<td class="td4"><p><?=$_SESSION['customer_data']['phone']?></p></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("fax",$_SESSION["lang"]) ?></td>
						<td class="td4"><p><?=$_SESSION['customer_data']['fax']?></p></td>
					</tr>
					<tr>
						<td class="td3"><?php lang("message",$_SESSION["lang"]) ?></td>
						<td class="td4"><p><?=$_SESSION['customer_data']['message']?></p></td>
					</tr>
					<?php 
					if(!empty($_SESSION["customer_data"]['tmpfile_cont'])&&!empty($_SESSION["customer_data"]['filename_cont'])){
						echo '<tr><td class="td3">ไฟล์ที่ฝาก</td><td class="td4"><p>';
					    foreach($_SESSION["customer_data"]['tmpfile_cont'] as $key => $value) {
					    	echo $value.'<br/>';
						}
						echo '</p></td></tr>';
					}
					?>
					<tr>
						<td class="td_full" colspan="2">
							<input type="button" value="back" class="button btn2" onclick="location.href = '//hotstrapthai.com/contact/?type=confirm';">
							<input type="submit" name="submit" id="submit" value="send" class="button btn1" onclick="location.href = '//hotstrapthai.com/contact/complete.php';">
						</td>
					</tr>
			</table>
		</div>
	</div>
	<div class="box-clear"></div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>
</body>
</html>