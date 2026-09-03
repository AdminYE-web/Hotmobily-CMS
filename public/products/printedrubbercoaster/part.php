<?php
$attachment = array(
    array('part_name' => '通常松葉（カニカン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part1-2.webp'),
    array('part_name' => 'ゴム松葉（カニカン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part2-2.webp'),
    array('part_name' => 'ボールチェーンシルバー', 'part_price' => '0', 'part_pic' => '/products/images/HM_part14.webp'),
    array('part_name' => '通常松葉（カニカン・スマホプラグ）', 'part_price' => '10', 'part_pic' => '/products/images/HM_part3.webp'),
    array('part_name' => 'ボールチェーン黄色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part9.webp'),
    array('part_name' => 'ボールチェーン赤色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part10.webp'),
    array('part_name' => 'ボールチェーン青色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part11.webp'),
    array('part_name' => 'ボールチェーンピンク色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part12.webp'),
    array('part_name' => 'ボールチェーン緑色', 'part_price' => '10', 'part_pic' => '/products/images/HM_part13.webp'),
    array('part_name' => 'リング小（チェーン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part15.jpg'),
    array('part_name' => 'リング小（回転カン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part18.jpg'),
    array('part_name' => 'リング中（チェーン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part16.jpg'),
    array('part_name' => 'リング中（回転カン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part19.jpg'),
    array('part_name' => 'リング大（チェーン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part17.jpg'),
    array('part_name' => 'リング大（回転カン）', 'part_price' => '0', 'part_pic' => '/products/images/HM_part20.jpg'),
    array('part_name' => 'リング黒色', 'part_price' => '0', 'part_pic' => '/products/images/HM_part21.jpg'),
    array('part_name' => '銀色ナスカン', 'part_price' => '10', 'part_pic' => '/products/images/HM_part5.jpg'),
    array('part_name' => '金色ナスカン', 'part_price' => '20', 'part_pic' => '/products/images/HM_part4.jpg'),
    array('part_name' => '星型ナスカン', 'part_price' => '20', 'part_pic' => '/products/images/HM_part6.jpg'),
    array('part_name' => 'ハート型ナスカン', 'part_price' => '20', 'part_pic' => '/products/images/HM_part7.jpg'),
    array('part_name' => '半月型ナスカン', 'part_price' => '20', 'part_pic' => '/products/images/HM_part8.jpg')
);

if (isset($_GET['c']) && $_GET['c'] != "") {
    echo json_encode($attachment);
}
?>