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
	function write_date($no) {
		require('../db_connect.php');
		$sql = "SELECT * FROM `enroll` where date_time like '".date('Y-m-d')."%' and user_id = $no and status not like 'delete%'";
		if ($result = $con->query($sql)) {
		    /* fetch associative array */
		    $c = 0;
		    while ($row = $result->fetch_assoc()) {
		    	if($c == 0 || $c == 3){
		    		printf ("<span class='red'>เวลา: %s </span>\n", $row["date_time"]);
		        	echo "<a href='javascript:void(0)' class='red' onclick='delete_enr(".$row["id"].",\"php\",\"".$row["date_time"]."\")'>ลบ</a><br/>";
		    	}else{
					printf ("<span>เวลา: %s </span>\n", $row["date_time"]);
		        	echo "<a href='javascript:void(0)' class='red' onclick='delete_enr(".$row["id"].",\"php\",\"".$row["date_time"]."\")'>ลบ</a><br/>";
		    	}
		    	$c++;
		    }
		    /* free result set */
		    $result->free();
		}
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:p="http://www.evolus.vn/Namespace/Pencil" xmlns:html="http://www.w3.org/1999/xhtml">
<head>
	<!--head-->
	<?php require_once('../head.php')?>
	<!--end-->
	<meta name="robots" content="" />
	<link rel="canonical" href="" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<title>ลงทะเบียน</title>
	<style type="text/css">
		.td3{
			width: 20% !important;
		}
		.td4{
			width: 30% !important;
		}
		.tr_d{
			height: 135px;vertical-align: baseline;
		}
		p{
			padding: 0px !important;
		}
	</style>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel"><a href="/login/">login</a></h1>
		</div>
	</div>
	<div id="container">
		<div class="container">
			<h2>เช็คชื่อ: <?=date("m/d/Y");?></h2>
			<table class="tbl-txt tbl-cont">
				<tr class="tr_d">
					<td class="td3" style="font-size: 20px;">Takemura san<br/><a class="link2" onclick="chk_enroll('takemura','user_00',1);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_00"><?php write_date(1)?></p></td>
					<td class="td3" style="font-size: 20px;">Joe san<br/><a class="link2" onclick="chk_enroll('joe','user_08',6);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_08"><?php write_date(6)?></p></td>
				</tr>
				<tr class="tr_d">
					<td class="td3" style="font-size: 20px;">Bew san<br/><a class="link2" onclick="chk_enroll('bew','user_01',2);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_01"><?php write_date(2)?></p></td>
					<td class="td3" style="font-size: 20px;">Prang san<br/><a class="link2" onclick="chk_enroll('prang','user_07',10);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_07"><?php write_date(10)?></p></td>
				</tr>
				<tr class="tr_d">
					<td class="td3" style="font-size: 20px;">Oong san<br/><a class="link2" onclick="chk_enroll('oong','user_02',3);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_02"><?php write_date(3)?></p></td>
					<td class="td3" style="font-size: 20px;">Ice san<br/><a class="link2" onclick="chk_enroll('ice','user_06',4);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_06"><?php write_date(4)?></p></td>
				</tr>
				<tr class="tr_d">
					<td class="td3" style="font-size: 20px;">Aun san<br/><a class="link2" onclick="chk_enroll('aun','user_03',5);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_03"><?php write_date(5)?></p></td>
					<td class="td3" style="font-size: 20px;">Aek san<br/><a class="link2" onclick="chk_enroll('aek','user_05',7);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4"><p id="user_05"><?php write_date(7)?></p></td>
				</tr>
				<tr class="tr_d">
					<td class="td3" style="font-size: 20px;">Lek san<br/><a class="link2" onclick="chk_enroll('lek','user_04',8);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4" colp="3"><p id="user_04"><?php write_date(8)?></p></td>
					<td class="td3" style="font-size: 20px;">Aum san<br/><a class="link2" onclick="chk_enroll('aum','user_09',9);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4" colp="3"><p id="user_09"><?php write_date(9)?></p></td>
				</tr>
				<tr class="tr_d">
					<td class="td3" style="font-size: 20px;">Ice san<span style="color: red">(New)</span><br/><a class="link2" onclick="chk_enroll('ice','user_10',11);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4" colp="3"><p id="user_10"><?php write_date(11)?></p></td>
					<td class="td3" style="font-size: 20px;">Oil san<br/><a class="link2" onclick="chk_enroll('oil','user_12',13);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4" colp="3"><p id="user_12"><?php write_date(13)?></p></td>
				</tr>
				<tr class="tr_d">
					<td class="td3" style="font-size: 20px;">Sheen san<br/><a class="link2" onclick="chk_enroll('sheen','user_14',14);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4" colp="3"><p id="user_14"><?php write_date(14)?></p></td>
					<td class="td3" style="font-size: 20px;">Fast san<br/><a class="link2" onclick="chk_enroll('fast','user_15',15);" href="javascript:void(0)">เช็คชื่อ</a></td>
					<td class="td4" colp="3"><p id="user_15"><?php write_date(15)?></p></td>
				</tr>
			</table>
		</div>
		<!-- <div id="dialog" title="กรอกข้อมูลให้ครบ">
		  <p>
		  	<table>
		  		<tr class="">
		  			<td class="td1">New Date-Time:</td>
					<td class="td2" colp="3"><input type="text" id="new_date" value=""></td>
		  		</tr>
		  		<tr class="">
		  			<td class="td1">Password:</td>
					<td class="td2" colp="3"><input type="text" id="pass" value=""></td>
		  		</tr>
		  	</table>
		  </p>
		</div> -->
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script type="text/javascript">
		$(function() {
		  $(window).keydown(function(event){
		    if(event.keyCode == 13) {
		      event.preventDefault();
		      return false;
		    }
		  });
		});
		function gettime() {
			var n = new Date();
			var y = n.getFullYear();
			var m = n.getMonth();
			var d = n.getDate();
			var h = addZero(n.getHours());
			var mi = addZero(n.getMinutes());
			var s = addZero(n.getSeconds());
			m++;
			var time = y+"-"+m+"-"+d+" "+h+":"+mi+":"+s;
			return time;
		}
		function chk_enroll(name,id,no) {
			var r = confirm(name+" ยืนยันการลงทะเบียน ณ เวลา"+gettime());
			if (r == true) {
			    $.ajax({
			    	url: "save_enroll.php",
			    	type: 'get',
					data: {
						"id": no,
						"time":gettime()
					},
			    	success: function(data){
			        	if(!data){
			        		if($("#"+id+" span").length===0||$("#"+id+" span").length===3){
								$("#"+id).append("<span class='red'>เวลา: "+gettime()+"</span> <a href='javascript:void(0)' class='red' onclick='delete_enr("+no+",\"js\",\""+gettime()+"\")'>ลบ</a><br/>");
			        		}else{
								$("#"+id).append("<span>เวลา: "+gettime()+"</span> <a href='javascript:void(0)' class='red' onclick='delete_enr("+no+",\"js\",\""+gettime()+"\")'>ลบ</a><br/>");
			        		}
			        	}else{
			        		alert(data);
			        	}
			    	}
			    });
			}
		}
		function addZero(i) {
		    if (i < 10) {
		        i = "0" + i;
		    }
		    return i;
		}
		function delete_enr(id,type,time) {
			var tmp = prompt("Please enter password for delete\n"+time, "");
			if (tmp == null || tmp == "") {
			    alert("cancelled.");
			} else {
				$.ajax({
			    	url: "delete_enroll.php",
			    	type: 'get',
					data: {
						"id": id,
						"type": type,
						"time": time,
						"pass": tmp
					},
			    	success: function(result){
			        	if(!result){
			        		txt = "deleted.";
			        	}else{
			        		txt = "password not correct.";
			        	}
			        	alert(txt);
			    	}
			    });
			}
		}
		// function edit_enr(id,type,time){
		// 	$("#dialog").dialog('open');
		// 	$('#new_date').text(gettime())
		// }
	</script>
</body>
</html>
