<?php
	session_start();
	require('../lang.php');
	require('../db_connect.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../phpmailer/src/Exception.php';
	require '../phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);   

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
	$file = "";
	$url_this = $url_this."".strtok($_SERVER["REQUEST_URI"],'?');
	$escaped_url = htmlspecialchars( $url_this, ENT_QUOTES, 'UTF-8' );
	if(!empty($_SESSION['customer_data']['tmpfile_cont'])&&!empty($_SESSION['customer_data']['filename_cont'])){
		foreach($_SESSION['customer_data']['tmpfile_cont'] as $key => $value) {
			$file .= $value.' ';
		}
	}
	if (isset($_SESSION['customer_data'])) {
		$tmp = $_SESSION["customer_data"]['subject'];
		$subject = $_SESSION['customer_data']['subject'];
		$subject_txt="HOTSTRAP - ขอบคุณที่ใช้บริการของเรา";
		if($_SESSION['customer_data']['urgent']=='1'){
			$urgent = 1;
		}else{$urgent = 0;}
		$sql = "INSERT INTO `contact` (`cont_id`, `subject`, `urgent_status`, `name`, `company`, `mail`, `phone`, `messages`, `other`, `fax`, `file_upload`, `date_create`, `status`) VALUES ('".$_SESSION['customer_data']['contact_no']."',
						'".$subject."','".$urgent."',
						'".mysqli_real_escape_string($con,$_SESSION['customer_data']['name'])."',
						'".mysqli_real_escape_string($con,$_SESSION['customer_data']['company'])."',
						'".mysqli_real_escape_string($con,$_SESSION['customer_data']['email'])."',
						'".mysqli_real_escape_string($con,$_SESSION['customer_data']['phone'])."',
						'".mysqli_real_escape_string($con,$_SESSION['customer_data']['message'])."',
						'".mysqli_real_escape_string($con,$_SESSION['customer_data']['other'])."',
						'".mysqli_real_escape_string($con,$_SESSION['customer_data']['fax'])."',
						'".$file."',
						'".date('Y-m-d')."','NR')";
		$con->query($sql);

		if($subject=="product"){
		$body = "<p>
			เรียน K.".$_SESSION['customer_data']['name']."<br/> เราได้รับคำถามของคุณเรียบร้อยแล้ว ทางเราจะตรวจสอบและรีบตอบกลับโดยเร็วที่สุด กรุณาตรวจสอบตามข้อมูลด้านล่าง หากมีข้อสงสัยเพิ่มเติมหรือมีข้อผิดพลาด ติดต่อหาเราโดยการตอบกลับอีเมลฉบับนี้ ขอบคุณครับ
		</p>";
		$subject_id = "สอบถามเกี่ยวกับสินค้า";
		}elseif ($subject=="sale_request") {
		$body = "<p>
			เรียน K.".$_SESSION['customer_data']['name']."<br/> เราได้รับคำร้องของคุณเรียบร้อยแล้ว ทางเราจะรีบติดต่อกลับโดยเร็วที่สุด กรุณาตรวจสอบตามข้อมูลด้านล่าง หากมีข้อสงสัยเพิ่มเติมหรือมีข้อผิดพลาด ติดต่อหาเราโดยการตอบกลับอีเมลฉบับนี้ ขอบคุณครับ
		</p>";
		$subject_id = "ติดต่อพนักงานขาย";
		}elseif ($subject=="other") {
		$body = "<p>
			เรียน K.".$_SESSION['customer_data']['name']."<br/> ขอขอบคุณที่ติดต่อหาเรา ทางเราจะรีบติดต่อกลับโดยเร็วที่สุด กรุณาตรวจสอบตามข้อมูลด้านล่าง หากมีข้อสงสัยเพิ่มเติมหรือมีข้อผิดพลาด ติดต่อหาเราโดยการตอบกลับอีเมลฉบับนี้ ขอบคุณครับ
		</p>";
		$subject_id = "ติดต่อเรื่องอื่นๆ";
		}
		$body .='
			<table style="border: 2px solid #f2f2f2;border-collapse: collapse;">
					<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">หัวข้อการติดต่อ</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$subject_id.'</p></td>
					</tr>';
		if($_SESSION['customer_data']['other']!=''){
			$body .='<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">รายละเอียด</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$_SESSION['customer_data']['other'].'</p></td>
					</tr>';
		}			
		if($_SESSION['customer_data']['urgent']=='1'){
			$body .='<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">ความต้องการติดต่อเร่งด่วน</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>ต้องการ</p></td>
					</tr>';
		}
		$body .='<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">ชื่อลูกค้า</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$_SESSION['customer_data']['name'].'</p></td>
					</tr>
					<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">ชื่อบริษัท</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$_SESSION['customer_data']['company'].'</p></td>
					</tr>
					<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">E-mail</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$_SESSION['customer_data']['email'].'</p></td>
					</tr>
					<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">เบอร์โทรศัพท์</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$_SESSION['customer_data']['phone'].'</p></td>
					</tr>
					<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">Fax</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$_SESSION['customer_data']['fax'].'</p></td>
					</tr>';
					if(!empty($_SESSION["customer_data"]['tmpfile_cont'])&&!empty($_SESSION["customer_data"]['filename_cont'])){
						$body .= '<tr><td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">ไฟล์ที่ฝาก</td><td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>';
					    foreach($_SESSION["customer_data"]['tmpfile_cont'] as $key => $value) {
					    	$body .= $value.'<br/>';
						}
						$body .= '</p></td></tr>';
					}
					if(!empty($_SESSION["customer_data"]['filename_cont'])&&!empty($_SESSION["customer_data"]['filename_cont'])){
						$body .= '<tr><td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">ไฟล์ในระบบ</td><td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>';
					    foreach($_SESSION["customer_data"]['filename_cont'] as $key => $value) {
					    	$body .= $value.'<br/>';
						}
						$body .= '</p></td></tr>';
					}
				$body .='<tr>
						<td style="background: #f2f2f2;width: 30%;border-bottom: white 2px solid;text-align: left;padding-left: 20px !important;">ข้อความ</td>
						<td style="width: 70%;border-bottom:2px #f2f2f2 solid;padding-left: 15px !important;"><p>'.$_SESSION['customer_data']['message'].'</p></td>
					</tr>
			</table>';
		

		$mail->CharSet = "utf-8";

		$mail->setFrom('contact_hs@hotstrapthai.com', 'Hotstrap Admin');
		$mail->addAddress($_SESSION['customer_data']['email']);
		$mail->Subject = $subject_txt;

		$mail->MsgHTML($body);

		$mail->AddBCC('hotmobily201603@gmail.com');
		$mail->AddBCC('contact_hs@hotstrapthai.com');
		$mail->AddBCC('hotmobily2016@gmail.com');
		$mail->AddBCC('kadota@gmail.com');
		$mail->AddBCC('takemura.d@gmail.com');
		$mail->AddBCC('hotmobilyweb2017@gmail.com');
		$mail->Send('HOTSTRAP::เราได้รับการติดต่อจากคุณเรียบร้อยแล้ว');

		unset($_SESSION['customer_data']);
	}else{
		$_SESSION['customer_data']['status'] = 0;
		header("Location: //".$url."/contact/index.php");
		exit();
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:p="http://www.evolus.vn/Namespace/Pencil" xmlns:html="http://www.w3.org/1999/xhtml">
<head>
	<!--head-->
	<?php require_once('../head.php')?>
	<!--end-->
	<title>สายคล้องคอพนักงาน</title>
	<!-- Event snippet for HS_contact conversion page -->
	<script>
	  gtag('event', 'conversion', {
	      'send_to': 'AW-806959730/6crFCLijzZIBEPL05IAD',
	      'value': 20.0,
	      'currency': 'THB'
	  });
	</script>
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
			ขอบคุณครับ
		</div>
	</div>
	<div class="box-clear"></div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>
</body>
</html>