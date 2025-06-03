<?php 
ob_start();
include '../../autoloader.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    exit(json_encode(['status' => 'error', 'message' => 'Hanya metode GET yang diizinkan.']));
}
$nis = filter_input(INPUT_GET, 'nis', FILTER_SANITIZE_NUMBER_INT);
if (!validateNIS($nis)) {
    http_response_code(400); // Bad Request
    exit(json_encode(['status' => 'error', 'message' => 'NIS tidak valid.']));
}

try {
    generateQRCode($nis);
} catch (Exception $e) {
    http_response_code(500);
    exit(json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat membuat QR Code.']));
}
function validateNIS($nis) {
    return ctype_digit($nis);
}
function generateQRCode($nis) {
    $tempdir = dirname(__DIR__) . "/../qr_images/";
    if (!file_exists($tempdir)) {
        mkdir($tempdir, 0755, true);
    }
    // $filename = $tempdir . hash('sha256', $nis) . ".png";
    $filename = $tempdir . $nis . ".png";
    if (!file_exists($filename)) {
        qrcode();
        QRcode::png($nis, $filename, QR_ECLEVEL_L, 4);
    }
    ob_end_clean();
    header('Content-Type: image/png'); 
    readfile($filename);
}
?>