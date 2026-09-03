<?php
	require('../db_connect.php');
	foreach ($_GET as $key => $value) {
		$_GET[$key]=addslashes(strip_tags(trim($value)));
	}
	if ($_GET['id'] !='') { $_GET['id']=(int) $_GET['id']; }

	extract($_GET);

	$sql0 = "SELECT * FROM `hs_admin` where password = '".$_GET['pass']."'";
	if ($result = $con->query($sql0)) {
		$count = $result->num_rows;
		if($count!=0){
			while ($row = $result->fetch_assoc()) {
				$admin_name = $row['admin_name'];
			}
		}else{
			echo "password not correct.";
		}
		$result->close();
	}
	if(isset($admin_name)){
		if($_GET['type']=="php"){
			$sql = "UPDATE enroll SET status = 'delete by ".$admin_name."' WHERE id = ".$_GET['id'];
			$con->query($sql);
		}else if($_GET['type']=="js"){
			$sql = "UPDATE enroll SET status = 'delete by ".$admin_name."' WHERE user_id = ".$_GET['id']." AND date_time = '".$_GET['time']."'";
			$con->query($sql);
		}
	}
	
?>