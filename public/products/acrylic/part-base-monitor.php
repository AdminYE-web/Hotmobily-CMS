<?php
	$attachment = array(
		array('part_name' => '背面パーツ（小サイズ）',
			 'part_price' => '0',
			 'part_pic' => '/products/acrylic/img/monitor-acrylic-back01.webp?v=1.02', 
			 'part_id' => 'base-ellp'),
		array('part_name' => '背面パーツ（大サイズ・印刷あり）',
			  'part_price' => '0', 
			  'part_pic' => '/products/acrylic/img/monitor-acrylic-back02.webp?v=1.02', 
			  'part_id' => 'base-cir')
	);

	function PartName($value)
	{
		if(isset($_GET['s'])&&$_GET['s']!="")
		{
			switch ($_GET['s']) {
				case '50':if($value == "base-ellp" || $value == "base-prereg"){return '40x20';}else{return '40x40';}break;
				case '75':if($value == "base-ellp" || $value == "base-prereg"){return '60x30';}else{return '60x60';}break;
				case '100':if($value == "base-ellp" || $value == "base-prereg"){return '75x40';}else{return '75x75';}break;
			}
		}else{
			if($value == "base-ellp" || $value == "base-prereg"){return '40x20';}else{return '40x40';}
		}
	}

	function PartPrice()
	{
		if(isset($_GET['s'])&&$_GET['s']!="")
		{
			switch ($_GET['s']) {
				case '50':return "20";break;
				case '75':return "40";break;
				case '100':return "80";break;
			}
		}else{
			return "20";
		}
	}

	if(isset($_GET['c'])&&$_GET['c']!="")
	{
		echo json_encode($attachment);
	}
?>
