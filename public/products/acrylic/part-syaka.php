<?php
	$attachment = array(
		array('part_name' => 'ボールチェーンシルバー', 'part_price' => '0', 'part_pic' => '/products/images/HM_part14.jpg'),
		array('part_name' => 'ボールチェーン黄色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part9.jpg'),
		array('part_name' => 'ボールチェーン赤色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part10.jpg'),
		array('part_name' => 'ボールチェーン青色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part11.jpg'),
		array('part_name' => 'ボールチェーンピンク色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part12.jpg'),
		array('part_name' => 'ボールチェーン緑色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part13.jpg'),
	);

	if (isset($_GET['c'])&&$_GET['c']!="") {
		echo json_encode($attachment);
	}
?>
