<?php
	session_start();
	require('../db_connect.php');
	if(isset($_POST['username'])&&isset($_POST['password'])){
		$data = "SELECT * FROM `hs_admin` where `username`='".$_POST['username']."' and `password`='".$_POST['password']."'";
		if($con->query($data)){
			$_SESSION['username'] = "admin";
			header("Location: //hotstrapthai.com/enroll/admin.php");
        	exit();      
		}else{
			header("Location: //hotstrapthai.com/enroll/index.php");
        	exit();	
		}
	}else{
		header("Location: //hotstrapthai.com/enroll/index.php");
        exit();
	}
?>