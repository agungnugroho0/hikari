<?php
header('Content-Type: application/json');
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m'); // Default ke bulan ini

$lolos = tampil ("SELECT DATE_FORMAT(tgl_lolos, '%d') as 'tgl', COUNT(tgl_lolos) AS jumlah_lolos FROM log_lolos WHERE DATE_FORMAT(tgl_lolos, '%Y-%m') = '$bulan' GROUP BY DATE_FORMAT(tgl_lolos, '%d')");

echo json_encode($lolos);