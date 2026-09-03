<?php
	session_start();
	// $count = count($_FILES["file"]["name"]);
	// $arrlength = count($_SESSION['filename']);	
	$key = $_GET['session'];

	unlink("../contact/upload/" .$_SESSION["customer_data"]['filename_cont'][$key]);
	// $_SESSION["tmpfile"] = array_splice($arr, $key, 1);
	// $_SESSION["filename"] = array_splice($arr2, $key, 1);

    unset($_SESSION["customer_data"]["tmpfile_cont"][$key]);
    unset($_SESSION["customer_data"]["filename_cont"][$key]);

?>