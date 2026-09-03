<?php
/********************************************************************

	ファイルダウンロード用ヘッダー処理

	Ver1.0  2008/10/10  Junko Munehira
	
********************************************************************/

	if($_GET['fname']){
		$fname = $_GET['fname'];
	}

	$path = "./";
	$filepath = "./".$fname;

	/* ファイルの存在確認 */
    if (!file_exists($filepath)) {
        die("Error: File(".$filepath.") does not exist");
    }

    /* オープンできるか確認 */
    if (!($fp = fopen($filepath, "r"))) {
        die("Error: Cannot open the file(".$fname.")");
    }
    fclose($fp);

    /* ファイルサイズの確認 */
    if (($content_length = filesize($filepath)) == 0) {
        die("Error: File size is 0.(".$filepath.")");
    }
    
	header('Content-Disposition: attachment; filename="'.basename($fname).'"');
	header('Content-Type: application/octet-stream');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($filepath));
	readfile($filepath);

?>