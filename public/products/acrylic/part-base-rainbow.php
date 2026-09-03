<?php
	$attachment = array(
		array('part_name' => '【定型】楕円 '.PartName('base-ellp').'mm 印刷なし',
			 'part_price' => '0',
			 'part_pic' => '/products/acrylic/img/base01.jpg?v=1.02', 
			 'part_id' => 'base-ellp'),
		array('part_name' => '【定型】円 '.PartName('base-cir').'mm 印刷なし',
			  'part_price' => '0', 
			  'part_pic' => '/products/acrylic/img/base02.jpg?v=1.02', 
			  'part_id' => 'base-cir'),
		array('part_name' => '【定型】長方形 '.PartName('base-prereg').'mm 印刷なし', 
			  'part_price' => '0', 
			  'part_pic' => '/products/acrylic/img/base03.jpg?v=1.02', 
			  'part_id' => 'base-prereg'),
		array('part_name' => '【定型】正方形 '.PartName('base-reg').'mm 印刷なし', 
			  'part_price' => '0', 
			  'part_pic' => '/products/acrylic/img/base04.jpg?v=1.02', 
			  'part_id' => 'base-reg'),
		array('part_name' => '【オリジナル】印刷あり',
			'part_price' => PartPrice(), 
			'part_pic' => '/products/acrylic/img/base05.jpg?v=1.02', 
			'part_id' => 'base-cust'),
		array('part_name' => '【オリジナル】印刷なし', 
			'part_price' => '0', 
			'part_pic' => '/products/acrylic/img/base06.jpg?v=1.02', 
			'part_id' => 'base-cust2'),
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
