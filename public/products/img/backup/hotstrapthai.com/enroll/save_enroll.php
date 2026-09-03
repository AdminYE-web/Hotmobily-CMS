<?php
	require('../db_connect.php');
	$sql_1 = "SELECT * FROM `enroll` where `status` LIKE 'by click' and date_time like '".date('Y-m-d')."%' and user_id = ".$_GET['id'];
	if ($result = $con->query($sql_1)) {
		$count = $result->num_rows;
		if($count<4){
			$sql = "INSERT INTO `enroll` (`date_time`,`user_id`,`status`) VALUES ('".$_GET['time']."',".$_GET['id'].",'by click')";
			$con->query($sql);
			$result->close();
		}else{
			echo "คุณเช็คไปครบแล้ว";
		}
	}else{
		$sql = "INSERT INTO `enroll` (`date_time`,`user_id`,`status`) VALUES ('".$_GET['time']."',".$_GET['id'].",'by click')";
		$con->query($sql);
	}
?>