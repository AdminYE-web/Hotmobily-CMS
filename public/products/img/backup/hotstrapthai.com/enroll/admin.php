<?php
	session_start();
	require('../db_connect.php');
    if(!isset($_SESSION['username'])){
        header("Location: //hotstrapthai.com/enroll/index.php");
        exit();
    }
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
</head>
<body>
	<div class="head_h1">
		<div class="container">
			<h1 class="txt-wel"><a href="logout.php">logout</a></h1>
		</div>
	</div>
	<div id="container">
		<div class="container" style="height: auto;min-height: 700px;">
			<h2>Admin menu</h2>
			<input type="date" id="f_date"> - <input type="date" id="l_date"><br/><br/>
				<select id="name">
					<?php
						$sql = "SELECT * FROM `user`";
						if ($result = $con->query($sql)) {
						    /* fetch associative array */
						    while ($row = $result->fetch_assoc()) {
						    	echo "<option value=".$row['user_id'].">".$row['user_name']."</option>";
						    }
						    /* free result set */
						    $result->free();
						}
					?>
				</select>
			&nbsp;<input type="button" value="ค้นหา" onclick="qry_enr()"><br/>
			<div id="result"></div>
			<table class="tbl-txt tbl-cont" id="tbl2">
				
			</table>
		</div>
	</div>
	<!--footer-->
	<?php require_once('../footer.php')?>
	<!--end-->
	<a href="javascript:void(0)" id="page_top"><img src="/images/button_gotop.png" width="60" height="60" alt="PAGE TOP "/></a>
	<script src="js/jquery.table2excel.js"></script>

	<script type="text/javascript">
		function qry_enr(){
			var date_f = $('#f_date').val();
			var date_l = $('#l_date').val();
			var name = $('#name').val();
			var name_txt = $("#name option:selected").text();
			// var name = $('#name').filter(":selected").val();
			if(date_f!=""&&date_l!=""){
				$.ajax({
				    	url: "search_qry.php",
				    	type: 'get',
						data: {
							"date_f": date_f,
							"date_l": date_l,
							"id": name
						},
				    	success: function(data){
				        	if(data){
				        		$('#tbl2').html(data);
				        		$('#result').html('<h3>'+name_txt+' <button value="export" onclick="export_xls()">export</button></h3>');
				        	}else{
				        		alert('ไม่มีข้อมูล')
				        	}
				    	}
				});
			}else{
				alert('please enter all date');
			}
		}
		function export_xls() {
	        $("#tbl2").table2excel({
	                exclude: ".table",
	                name: "Excel Document",
	                filename: "report",
	                fileext: ".xlsx",
	                exclude_img: true,
	                exclude_links: true,
	                exclude_inputs: true
	          }); 
	    }
	</script>
</body>
</html>
