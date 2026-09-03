<?php

/********************************************************************
 Secure File Download Handler
 Fixes: LFI, Path Traversal, Arbitrary File Access
 ********************************************************************/

// ---- CONFIG ----
$BASE_DIR = realpath(__DIR__ . '');   // Only allow downloads from this folder
$ALLOWED_EXT = ['pdf', 'zip', 'jpg', 'png', 'docx', 'xlsx', 'ai', 'psd', 'clip']; // optional

// ---- INPUT ----
if (!isset($_GET['fname']) || empty($_GET['fname'])) {
	http_response_code(400);
	die('Invalid request');
}

$fname = $_GET['fname'];

// ---- SANITIZE ----
$fname = basename($fname); // remove ../ and paths

// ---- BUILD PATH ----
$filepath = realpath($BASE_DIR . '/' . $fname);

// ---- SECURITY CHECKS ----

// realpath must exist
if ($filepath === false) {
	http_response_code(404);
	die('File not found');
}

// must stay inside BASE_DIR
if (strpos($filepath, $BASE_DIR) !== 0) {
	http_response_code(403);
	die('Access denied');
}

// optional extension check
$ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
if (!empty($ALLOWED_EXT) && !in_array($ext, $ALLOWED_EXT)) {
	http_response_code(403);
	die('File type not allowed');
}

// file must exist
if (!file_exists($filepath)) {
	http_response_code(404);
	die('File not found');
}

// readable
if (!is_readable($filepath)) {
	http_response_code(403);
	die('Permission denied');
}

// ---- HEADERS ----
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($filepath));
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: public');

// ---- OUTPUT ----
readfile($filepath);
exit;
