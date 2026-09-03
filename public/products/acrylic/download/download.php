<?php
/********************************************************************

    ファイルダウンロード用ヘッダー処理

********************************************************************/

$fname = isset($_GET['fname']) ? $_GET['fname'] : '';

/*
 * อนุญาตเฉพาะชื่อไฟล์จริง ห้ามมี path, quote, tag, slash
 * ถ้ามีนามสกุลอื่น ให้เพิ่มใน list นี้
 */
if (!preg_match('/\A[A-Za-z0-9._ -]+\z/', $fname)) {
    http_response_code(400);
    exit('Invalid file name');
}

$baseDir = realpath(__DIR__);
$filepath = realpath($baseDir . DIRECTORY_SEPARATOR . $fname);

/* กัน path traversal เช่น ../../config.php */
if ($filepath === false || strpos($filepath, $baseDir . DIRECTORY_SEPARATOR) !== 0 || !is_file($filepath)) {
    header('HTTP/1.1 404 Not Found');
    exit('File not found');
}

/* オープンできるか確認 */
if (!is_readable($filepath)) {
    header('HTTP/1.1 403 Forbidden');
    exit('Cannot read file');
}

/* ファイルサイズの確認 */
$content_length = filesize($filepath);
if ($content_length === false || $content_length <= 0) {
    header('HTTP/1.1 404 Not Found');
    exit('File not found');
}

$downloadName = basename($fname);

header('X-Content-Type-Options: nosniff');
header('Content-Disposition: attachment; filename="' . addcslashes($downloadName, "\\\"") . '"');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . $content_length);

readfile($filepath);
exit;
