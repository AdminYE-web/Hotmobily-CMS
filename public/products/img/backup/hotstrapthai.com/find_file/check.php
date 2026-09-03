<?php
	session_start();
	$pass = $_POST['password'];

	if($pass == 'ye1234'){
		$_SESSION["true"] = "1";
		echo '$("#list1").html("<h2>List File Order</h2>';
				$dir    = "../orders/upload/";
				$files1 = scandir($dir,1);
				$iMax = count($files1)-2;
				for($i=0;$i<$iMax;$i++){
					$allowed =  array('jpg','jpeg','JPG');
					$ext = pathinfo($files1[$i], PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						echo '<p>download: <a href=\"download.php?fname='.$files1[$i].'&path=../orders/upload\" target=\"_blank\" class=\"preview\">'.$files1[$i].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../orders/upload/'.$files1[$i])).'</p>';
					}else{
						echo '<p>download: <a href=\"download.php?fname='.$files1[$i].'&path=../orders/upload\" target=\"_blank\">'.$files1[$i].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../orders/upload/'.$files1[$i])).'</p>';
					}
				}
		echo '");
		$("#list2").html("<h2>List File Contact</h2>';
				$dir2    = '../contact/upload/';
				$files2 = scandir($dir2,1);
				$iMax2 = count($files2)-2;
				for($i2=0;$i2<$iMax2;$i2++){
					$allowed =  array('jpg','jpeg','JPG');
					$ext = pathinfo($files2[$i2], PATHINFO_EXTENSION);
					if(in_array($ext,$allowed)){
						echo '<p>download: <a href=\"download.php?fname='.$files2[$i2].'&path=../contact/upload\" target=\"_blank\" class=\"preview\">'.$files2[$i2].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../contact/upload/'.$files2[$i2])).'</p>';
					}else{
						echo '<p>download: <a href=\"download.php?fname='.$files2[$i2].'&path=../contact/upload\" target=\"_blank\">'.$files2[$i2].'</a><br> date upload: '.date ("F d Y H:i:s.", filemtime('../contact/upload/'.$files2[$i2])).'</p>';
					}
				}
		echo '");';
				
		echo '$(\'#order\').show();$(\'#contact\').show();$(\'#acrylic\').show();';
	}else{
		
	}
?>