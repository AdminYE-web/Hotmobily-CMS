<?php
	session_start();
	$count = count($_FILES["file"]["name"]);
	//count file upload
	if(isset($_SESSION["customer_data"]['filename_cont'])){
		$arrlength = count($_SESSION["customer_data"]['filename_cont']);
	}else{
		$arrlength = 0;
	}
	$file_name = date("YmdHisB");
	$i = 0;
	if($arrlength>=0||$arrlength<3){
		for($y=0;$y<$count;$y++){
			//get last pointer array of $_SESSION['filename']
			if($arrlength==0){
				$lastpointer = 0;
			}else{
				$lastpointer = end(array_keys($_SESSION["customer_data"]['filename_cont']))+1;
			}

			$temp = explode(".", $_FILES["file"]["name"][$y]);
			$newfilename = $file_name . '_'.$lastpointer.'.' . end($temp);

			$allowed =  array('pdf','ai','jpg','jpeg','JPG');

			$ext = pathinfo($newfilename, PATHINFO_EXTENSION);
			if (is_uploaded_file($_FILES['file']['tmp_name'][$y])&&$arrlength<3){
				if(in_array($ext,$allowed)){
					if(move_uploaded_file($_FILES["file"]["tmp_name"][$y], "../contact/upload/" . $newfilename)){
						echo $_FILES["file"]["name"][$y]." อัพโหลดเรียบร้อย <input type='button' value='ลบ' onclick='remove(".$lastpointer.")'><br/>";
						$_SESSION["customer_data"]['filename_cont'][$lastpointer] = $newfilename;
						$_SESSION["customer_data"]['tmpfile_cont'][$lastpointer] = $_FILES["file"]["name"][$y];
						$arrlength++;
					}
				} else{
					echo $_FILES["file"]["name"][$y]."(นามสกุลไฟล์ไม่ถูกต้อง)<br/>";
				}
			}else{
				if($_FILES["file"]["name"][$y]){
					echo $_FILES["file"]["name"][$y]." อัพโหลดผิดพลาดกรุณาลองใหม่<br/>";
				}else{
					echo '';
				}
			}
		}
	}else{
		echo "ไม่สามารถอัพโหลดไฟล์เพิ่มได้";
	}

?>
